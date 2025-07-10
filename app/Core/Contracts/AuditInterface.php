<?php

namespace App\Core\Contracts;

/**
 * Audit System Interface
 * 
 * Unified interface for system-wide auditing and monitoring.
 * Provides comprehensive tracking of all system activities.
 */
interface AuditInterface
{
    /**
     * Log system activity
     */
    public function log(string $event, string $model, int $modelId, array $changes = [], ?int $userId = null): bool;

    /**
     * Retrieve audit logs with filtering
     */
    public function getLogs(array $filters = [], int $limit = 100): object;

    /**
     * Get audit statistics
     */
    public function getStats(array $filters = []): array;

    /**
     * Export audit logs
     */
    public function export(array $filters = [], string $format = 'csv'): string;

    /**
     * Real-time audit monitoring
     */
    public function monitor(): object;

    /**
     * Clear old audit logs
     */
    public function cleanup(int $daysToKeep = 90): int;
}
