<?php

namespace App\Core\Repositories;

use App\Core\Contracts\RepositoryInterface;
use App\Core\Contracts\MemoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Base Repository Implementation
 * 
 * Unified repository pattern with advanced caching, filtering,
 * and performance optimization for all models.
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;
    protected MemoryInterface $memory;
    protected string $cachePrefix;
    protected int $cacheTtl = 3600; // 1 hour
    protected array $searchableFields = [];
    protected array $filterableFields = [];
    protected array $stats = [
        'queries' => 0,
        'cache_hits' => 0,
        'cache_misses' => 0,
        'created' => 0,
        'updated' => 0,
        'deleted' => 0
    ];

    public function __construct(Model $model, MemoryInterface $memory)
    {
        $this->model = $model;
        $this->memory = $memory->namespace('repository');
        $this->cachePrefix = strtolower(class_basename($model));
        $this->initializeRepository();
    }

    /**
     * Find record by ID with intelligent caching
     */
    public function find(int $id, array $columns = ['*'], bool $cache = true): ?object
    {
        try {
            $cacheKey = $this->getCacheKey('find', $id, $columns);

            if ($cache && $this->memory->has($cacheKey)) {
                $this->stats['cache_hits']++;
                return $this->memory->retrieve($cacheKey);
            }

            $this->stats['queries']++;
            $result = $this->model->select($columns)->find($id);

            if ($result && $cache) {
                $this->memory->store($cacheKey, $result, $this->cacheTtl);
            }

            if (!$result) {
                $this->stats['cache_misses']++;
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Repository find failed', [
                'model' => get_class($this->model),
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Find multiple records with advanced filtering
     */
    public function findMany(array $criteria = [], array $columns = ['*'], bool $cache = true): object
    {
        try {
            $cacheKey = $this->getCacheKey('findMany', $criteria, $columns);

            if ($cache && $this->memory->has($cacheKey)) {
                $this->stats['cache_hits']++;
                return $this->memory->retrieve($cacheKey);
            }

            $this->stats['queries']++;
            $query = $this->model->select($columns);
            
            // Apply criteria filters
            $query = $this->applyCriteria($query, $criteria);
            
            $result = $query->get();

            if ($cache) {
                $this->memory->store($cacheKey, $result, $this->cacheTtl);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Repository findMany failed', [
                'model' => get_class($this->model),
                'criteria' => $criteria,
                'error' => $e->getMessage()
            ]);
            return new Collection();
        }
    }

    /**
     * Create new record with automatic cache invalidation
     */
    public function create(array $data): object
    {
        try {
            DB::beginTransaction();

            $result = $this->model->create($data);
            
            if ($result) {
                $this->stats['created']++;
                $this->invalidateModelCache();
                $this->logActivity('created', $result);
            }

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Repository create failed', [
                'model' => get_class($this->model),
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Update existing record with cache invalidation
     */
    public function update(int $id, array $data): bool
    {
        try {
            DB::beginTransaction();

            $record = $this->model->find($id);
            if (!$record) {
                return false;
            }

            $updated = $record->update($data);
            
            if ($updated) {
                $this->stats['updated']++;
                $this->invalidateRecordCache($id);
                $this->logActivity('updated', $record, $data);
            }

            DB::commit();
            return $updated;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Repository update failed', [
                'model' => get_class($this->model),
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Delete record with cache cleanup
     */
    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();

            $record = $this->model->find($id);
            if (!$record) {
                return false;
            }

            $deleted = $record->delete();
            
            if ($deleted) {
                $this->stats['deleted']++;
                $this->invalidateRecordCache($id);
                $this->logActivity('deleted', $record);
            }

            DB::commit();
            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Repository delete failed', [
                'model' => get_class($this->model),
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get paginated results with caching
     */
    public function paginate(array $criteria = [], int $perPage = 15, array $columns = ['*']): object
    {
        try {
            $cacheKey = $this->getCacheKey('paginate', $criteria, ['perPage' => $perPage, 'columns' => $columns]);

            if ($this->memory->has($cacheKey)) {
                $this->stats['cache_hits']++;
                return $this->memory->retrieve($cacheKey);
            }

            $this->stats['queries']++;
            $query = $this->model->select($columns);
            
            // Apply criteria filters
            $query = $this->applyCriteria($query, $criteria);
            
            $result = $query->paginate($perPage);

            $this->memory->store($cacheKey, $result, $this->cacheTtl / 2); // Shorter cache for paginated results

            return $result;
        } catch (\Exception $e) {
            Log::error('Repository paginate failed', [
                'model' => get_class($this->model),
                'criteria' => $criteria,
                'error' => $e->getMessage()
            ]);
            return new LengthAwarePaginator([], 0, $perPage);
        }
    }

    /**
     * Advanced search with full-text capabilities
     */
    public function search(string $query, array $fields = [], array $filters = []): object
    {
        try {
            $searchFields = !empty($fields) ? $fields : $this->searchableFields;
            $cacheKey = $this->getCacheKey('search', [$query, $searchFields, $filters]);

            if ($this->memory->has($cacheKey)) {
                $this->stats['cache_hits']++;
                return $this->memory->retrieve($cacheKey);
            }

            $this->stats['queries']++;
            $queryBuilder = $this->model->newQuery();

            // Apply search conditions
            if (!empty($searchFields) && !empty($query)) {
                $queryBuilder->where(function ($q) use ($query, $searchFields) {
                    foreach ($searchFields as $field) {
                        $q->orWhere($field, 'LIKE', "%{$query}%");
                    }
                });
            }

            // Apply additional filters
            $queryBuilder = $this->applyCriteria($queryBuilder, $filters);

            $result = $queryBuilder->get();

            $this->memory->store($cacheKey, $result, $this->cacheTtl / 4); // Shorter cache for search results

            return $result;
        } catch (\Exception $e) {
            Log::error('Repository search failed', [
                'model' => get_class($this->model),
                'query' => $query,
                'fields' => $fields,
                'error' => $e->getMessage()
            ]);
            return new Collection();
        }
    }

    /**
     * Get repository statistics
     */
    public function stats(): array
    {
        $memoryStats = $this->memory->stats();
        
        return [
            'model' => get_class($this->model),
            'cache_prefix' => $this->cachePrefix,
            'operations' => $this->stats,
            'cache_efficiency' => $this->calculateCacheEfficiency(),
            'memory' => $memoryStats,
            'database' => $this->getDatabaseStats(),
            'timestamp' => now()->toISOString()
        ];
    }

    /**
     * Clear repository cache
     */
    public function clearCache(): bool
    {
        try {
            $pattern = "{$this->cachePrefix}:*";
            return $this->memory->flush($pattern);
        } catch (\Exception $e) {
            Log::error('Repository cache clear failed', [
                'model' => get_class($this->model),
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Protected helper methods
     */
    protected function initializeRepository(): void
    {
        $this->stats['initialized_at'] = now();
        
        // Load model-specific configuration
        $this->loadModelConfig();
    }

    protected function loadModelConfig(): void
    {
        $modelClass = get_class($this->model);
        
        // Set searchable fields from model if available
        if (method_exists($this->model, 'getSearchableFields')) {
            $this->searchableFields = $this->model->getSearchableFields();
        }

        // Set filterable fields from model if available
        if (method_exists($this->model, 'getFilterableFields')) {
            $this->filterableFields = $this->model->getFilterableFields();
        }
    }

    protected function getCacheKey(string $operation, ...$params): string
    {
        $key = implode(':', array_merge([$this->cachePrefix, $operation], array_map('serialize', $params)));
        return md5($key);
    }

    protected function applyCriteria($query, array $criteria)
    {
        foreach ($criteria as $field => $value) {
            if (in_array($field, $this->filterableFields) || empty($this->filterableFields)) {
                if (is_array($value)) {
                    $query->whereIn($field, $value);
                } else {
                    $query->where($field, $value);
                }
            }
        }

        return $query;
    }

    protected function invalidateModelCache(): void
    {
        $this->memory->flush("{$this->cachePrefix}:*");
    }

    protected function invalidateRecordCache(int $id): void
    {
        $patterns = [
            "{$this->cachePrefix}:find:{$id}:*",
            "{$this->cachePrefix}:findMany:*",
            "{$this->cachePrefix}:paginate:*",
            "{$this->cachePrefix}:search:*"
        ];

        foreach ($patterns as $pattern) {
            $this->memory->flush($pattern);
        }
    }

    protected function logActivity(string $action, object $model, array $changes = []): void
    {
        // Integration with audit system
        try {
            event('model.activity', [
                'action' => $action,
                'model' => get_class($model),
                'model_id' => $model->id ?? null,
                'changes' => $changes,
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);
        } catch (\Exception $e) {
            Log::warning('Activity logging failed', ['error' => $e->getMessage()]);
        }
    }

    protected function calculateCacheEfficiency(): float
    {
        $totalRequests = $this->stats['cache_hits'] + $this->stats['cache_misses'];
        return $totalRequests > 0 ? ($this->stats['cache_hits'] / $totalRequests) * 100 : 0;
    }

    protected function getDatabaseStats(): array
    {
        try {
            $tableName = $this->model->getTable();
            
            $stats = DB::select("
                SELECT 
                    COUNT(*) as record_count,
                    AVG(CHAR_LENGTH(CAST(id AS CHAR))) as avg_id_length
                FROM {$tableName}
            ");

            return [
                'table' => $tableName,
                'record_count' => $stats[0]->record_count ?? 0,
                'avg_id_length' => $stats[0]->avg_id_length ?? 0
            ];
        } catch (\Exception $e) {
            return ['error' => 'Database stats unavailable'];
        }
    }
}
