<?php

namespace App\Core\Contracts;

/**
 * System Memory Interface
 * 
 * Unified interface for all memory operations across the system.
 * Provides caching, storage, and retrieval mechanisms with TTL support.
 */
interface MemoryInterface
{
    /**
     * Store data in memory with optional TTL
     */
    public function store(string $key, mixed $data, ?int $ttl = null): bool;

    /**
     * Retrieve data from memory
     */
    public function retrieve(string $key, mixed $default = null): mixed;

    /**
     * Check if key exists in memory
     */
    public function has(string $key): bool;

    /**
     * Remove data from memory
     */
    public function forget(string $key): bool;

    /**
     * Clear all memory data or by pattern
     */
    public function flush(?string $pattern = null): bool;

    /**
     * Get memory statistics
     */
    public function stats(): array;

    /**
     * Set namespace for memory operations
     */
    public function namespace(string $namespace): self;
}
