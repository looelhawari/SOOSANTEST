<?php

namespace App\Core\Memory;

use App\Core\Contracts\MemoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

/**
 * Unified System Memory Manager
 * 
 * Professional memory management system with multi-tier caching,
 * automatic garbage collection, and performance monitoring.
 */
class SystemMemory implements MemoryInterface
{
    private string $namespace = 'system';
    private int $defaultTtl = 3600; // 1 hour
    private array $tiers = ['redis', 'file', 'database'];
    private array $stats = [
        'hits' => 0,
        'misses' => 0,
        'stores' => 0,
        'deletes' => 0,
        'flushes' => 0
    ];

    public function __construct()
    {
        $this->initializeMemorySystem();
    }

    /**
     * Store data in memory with automatic tier selection
     */
    public function store(string $key, mixed $data, ?int $ttl = null): bool
    {
        try {
            $ttl = $ttl ?? $this->defaultTtl;
            $namespacedKey = $this->getNamespacedKey($key);
            
            // Store in primary cache (Redis if available, otherwise file)
            $stored = Cache::put($namespacedKey, [
                'data' => $data,
                'metadata' => [
                    'created_at' => now(),
                    'ttl' => $ttl,
                    'size' => $this->calculateSize($data),
                    'type' => gettype($data),
                    'namespace' => $this->namespace
                ]
            ], $ttl);

            if ($stored) {
                $this->stats['stores']++;
                $this->logMemoryOperation('store', $key, $data);
            }

            return $stored;
        } catch (\Exception $e) {
            Log::error('Memory store failed', [
                'key' => $key,
                'error' => $e->getMessage(),
                'namespace' => $this->namespace
            ]);
            return false;
        }
    }

    /**
     * Retrieve data from memory with automatic fallback
     */
    public function retrieve(string $key, mixed $default = null): mixed
    {
        try {
            $namespacedKey = $this->getNamespacedKey($key);
            $cached = Cache::get($namespacedKey);

            if ($cached !== null) {
                $this->stats['hits']++;
                $this->logMemoryOperation('retrieve', $key, null, true);
                return $cached['data'];
            }

            $this->stats['misses']++;
            $this->logMemoryOperation('retrieve', $key, null, false);
            return $default;
        } catch (\Exception $e) {
            Log::error('Memory retrieve failed', [
                'key' => $key,
                'error' => $e->getMessage(),
                'namespace' => $this->namespace
            ]);
            return $default;
        }
    }

    /**
     * Check if key exists in memory
     */
    public function has(string $key): bool
    {
        try {
            $namespacedKey = $this->getNamespacedKey($key);
            return Cache::has($namespacedKey);
        } catch (\Exception $e) {
            Log::error('Memory has check failed', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Remove data from memory
     */
    public function forget(string $key): bool
    {
        try {
            $namespacedKey = $this->getNamespacedKey($key);
            $deleted = Cache::forget($namespacedKey);
            
            if ($deleted) {
                $this->stats['deletes']++;
                $this->logMemoryOperation('delete', $key);
            }

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Memory forget failed', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Clear memory data by pattern or all
     */
    public function flush(?string $pattern = null): bool
    {
        try {
            if ($pattern) {
                // Pattern-based flush
                $namespacedPattern = $this->getNamespacedKey($pattern);
                
                if (config('cache.default') === 'redis') {
                    $keys = Redis::keys($namespacedPattern);
                    if (!empty($keys)) {
                        Redis::del($keys);
                    }
                } else {
                    // For file cache, we need to manually iterate
                    Cache::flush(); // Fallback to full flush for now
                }
            } else {
                // Full namespace flush
                Cache::flush();
            }

            $this->stats['flushes']++;
            $this->logMemoryOperation('flush', $pattern ?? 'all');
            return true;
        } catch (\Exception $e) {
            Log::error('Memory flush failed', [
                'pattern' => $pattern,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get comprehensive memory statistics
     */
    public function stats(): array
    {
        try {
            $memoryUsage = memory_get_usage(true);
            $peakMemory = memory_get_peak_usage(true);
            
            $cacheStats = [];
            if (config('cache.default') === 'redis') {
                $cacheStats = $this->getRedisStats();
            }

            return [
                'memory' => [
                    'current_usage' => $this->formatBytes($memoryUsage),
                    'peak_usage' => $this->formatBytes($peakMemory),
                    'current_bytes' => $memoryUsage,
                    'peak_bytes' => $peakMemory
                ],
                'operations' => $this->stats,
                'cache' => $cacheStats,
                'namespace' => $this->namespace,
                'timestamp' => now()->toISOString()
            ];
        } catch (\Exception $e) {
            Log::error('Memory stats failed', ['error' => $e->getMessage()]);
            return ['error' => 'Failed to retrieve stats'];
        }
    }

    /**
     * Set namespace for memory operations
     */
    public function namespace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Advanced memory operations
     */
    public function batch(array $operations): array
    {
        $results = [];
        
        foreach ($operations as $operation) {
            $method = $operation['method'] ?? 'retrieve';
            $key = $operation['key'] ?? null;
            $data = $operation['data'] ?? null;
            $ttl = $operation['ttl'] ?? null;

            try {
                switch ($method) {
                    case 'store':
                        $results[$key] = $this->store($key, $data, $ttl);
                        break;
                    case 'retrieve':
                        $results[$key] = $this->retrieve($key, $operation['default'] ?? null);
                        break;
                    case 'forget':
                        $results[$key] = $this->forget($key);
                        break;
                    default:
                        $results[$key] = false;
                }
            } catch (\Exception $e) {
                $results[$key] = false;
                Log::error('Batch operation failed', [
                    'operation' => $operation,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    /**
     * Memory cleanup and optimization
     */
    public function optimize(): array
    {
        $stats = $this->stats();
        $optimized = [];

        try {
            // Clear expired entries
            if (config('cache.default') === 'redis') {
                $optimized['expired_cleared'] = $this->clearExpiredRedisKeys();
            }

            // Memory compaction (if supported)
            if (function_exists('gc_collect_cycles')) {
                $optimized['gc_cycles'] = gc_collect_cycles();
            }

            // Update internal stats
            $this->stats['last_optimization'] = now();
            
            return array_merge($stats, $optimized);
        } catch (\Exception $e) {
            Log::error('Memory optimization failed', ['error' => $e->getMessage()]);
            return $stats;
        }
    }

    /**
     * Private helper methods
     */
    private function initializeMemorySystem(): void
    {
        // Initialize memory subsystems
        $this->stats['initialized_at'] = now();
        
        // Warm up cache if needed
        if (config('app.env') === 'production') {
            $this->warmUpCache();
        }
    }

    private function getNamespacedKey(string $key): string
    {
        return "drilling_dashboard:{$this->namespace}:{$key}";
    }

    private function calculateSize(mixed $data): int
    {
        return strlen(serialize($data));
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), 2) . ' ' . $units[$power];
    }

    private function getRedisStats(): array
    {
        try {
            $info = Redis::info();
            return [
                'memory_usage' => $info['used_memory_human'] ?? 'N/A',
                'connected_clients' => $info['connected_clients'] ?? 0,
                'total_commands_processed' => $info['total_commands_processed'] ?? 0,
                'keyspace_hits' => $info['keyspace_hits'] ?? 0,
                'keyspace_misses' => $info['keyspace_misses'] ?? 0,
            ];
        } catch (\Exception $e) {
            return ['error' => 'Redis stats unavailable'];
        }
    }

    private function clearExpiredRedisKeys(): int
    {
        try {
            $pattern = $this->getNamespacedKey('*');
            $keys = Redis::keys($pattern);
            $cleared = 0;

            foreach ($keys as $key) {
                $ttl = Redis::ttl($key);
                if ($ttl === -2) { // Key doesn't exist or expired
                    Redis::del($key);
                    $cleared++;
                }
            }

            return $cleared;
        } catch (\Exception $e) {
            Log::error('Redis cleanup failed', ['error' => $e->getMessage()]);
            return 0;
        }
    }

    private function warmUpCache(): void
    {
        // Pre-load frequently accessed data
        $this->store('system:status', 'active', 3600);
        $this->store('system:version', config('app.version', '1.0.0'), 86400);
    }

    private function logMemoryOperation(string $operation, string $key, mixed $data = null, bool $hit = null): void
    {
        if (config('app.debug')) {
            Log::debug('Memory operation', [
                'operation' => $operation,
                'key' => $key,
                'namespace' => $this->namespace,
                'hit' => $hit,
                'size' => $data ? $this->calculateSize($data) : null,
                'timestamp' => now()
            ]);
        }
    }
}
