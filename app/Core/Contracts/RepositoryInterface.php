<?php

namespace App\Core\Contracts;

/**
 * Repository Pattern Interface
 * 
 * Unified interface for all data repositories in the system.
 * Provides consistent CRUD operations with caching and filtering.
 */
interface RepositoryInterface
{
    /**
     * Find record by ID with optional caching
     */
    public function find(int $id, array $columns = ['*'], bool $cache = true): ?object;

    /**
     * Find multiple records with filtering and caching
     */
    public function findMany(array $criteria = [], array $columns = ['*'], bool $cache = true): object;

    /**
     * Create new record
     */
    public function create(array $data): object;

    /**
     * Update existing record
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete record
     */
    public function delete(int $id): bool;

    /**
     * Get paginated results
     */
    public function paginate(array $criteria = [], int $perPage = 15, array $columns = ['*']): object;

    /**
     * Search records with advanced filtering
     */
    public function search(string $query, array $fields = [], array $filters = []): object;

    /**
     * Get repository statistics
     */
    public function stats(): array;

    /**
     * Clear repository cache
     */
    public function clearCache(): bool;
}
