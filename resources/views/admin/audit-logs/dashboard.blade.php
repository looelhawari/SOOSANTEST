@extends('layouts.admin')

@section('title', __('audit-logs.header.dashboard_btn'))

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-chart-bar text-primary"></i>
                    {{ __('audit-logs.header.dashboard_btn') }}
                </h1>
                <div class="btn-group">
                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> {{ __('audit-logs.header.title') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Charts Row -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i>
                        {{ __('audit-logs.dashboard.daily_activity', [], app()->getLocale()) }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="dailyActivityChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie"></i>
                        {{ __('audit-logs.dashboard.event_types', [], app()->getLocale()) }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="eventTypesChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-database"></i>
                        {{ __('audit-logs.dashboard.most_active_models', [], app()->getLocale()) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>{{ __('audit-logs.dashboard.model', [], app()->getLocale()) }}</th>
                                    <th>{{ __('audit-logs.dashboard.activity_count', [], app()->getLocale()) }}</th>
                                    <th>{{ __('audit-logs.dashboard.percentage', [], app()->getLocale()) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalModelActivity = $modelStats->sum('count'); @endphp
                                @foreach($modelStats as $stat)
                                    <tr>
                                        <td>
                                            <strong>{{ class_basename($stat->auditable_type) }}</strong>
                                        </td>
                                        <td>{{ number_format($stat->count) }}</td>
                                        <td>
                                            @php $percentage = $totalModelActivity > 0 ? ($stat->count / $totalModelActivity) * 100 : 0; @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
                                                    {{ number_format($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i>
                        {{ __('audit-logs.dashboard.most_active_users', [], app()->getLocale()) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>{{ __('audit-logs.dashboard.user', [], app()->getLocale()) }}</th>
                                    <th>{{ __('audit-logs.dashboard.activity_count', [], app()->getLocale()) }}</th>
                                    <th>{{ __('audit-logs.dashboard.percentage', [], app()->getLocale()) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalUserActivity = $activeUsers->sum('count'); @endphp
                                @foreach($activeUsers as $userStat)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php $userImg = $userStat->user->image_url; @endphp
                                                @if($userImg)
                                                    <img src="{{ asset($userImg) }}" alt="{{ $userStat->user->name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                                                @else
                                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2">
                                                        {{ substr($userStat->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <strong>{{ $userStat->user->name }}</strong>
                                            </div>
                                        </td>
                                        <td>{{ number_format($userStat->count) }}</td>
                                        <td>
                                            @php $percentage = $totalUserActivity > 0 ? ($userStat->count / $totalUserActivity) * 100 : 0; @endphp
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%">
                                                    {{ number_format($percentage, 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Stats & Graphs Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card primary text-center mb-3">
                <div class="fs-2 fw-bold">{{ number_format($totalLogs) }}</div>
                <div class="small">{{ __('audit-logs.dashboard.total_logs', [], app()->getLocale()) }}</div>
            </div>
            <div class="stats-card info text-center mb-3">
                <div class="fs-2 fw-bold">{{ number_format($uniqueUsers) }}</div>
                <div class="small">{{ __('audit-logs.dashboard.unique_users', [], app()->getLocale()) }}</div>
            </div>
            <div class="stats-card success text-center mb-3">
                <div class="fs-5">{{ __('audit-logs.dashboard.most_active_day', [], app()->getLocale()) }}</div>
                <div class="fw-bold">{{ $mostActiveDay['date'] ?? '-' }}</div>
                <div class="small">{{ $mostActiveDay['count'] ?? '-' }} {{ __('audit-logs.dashboard.logs', [], app()->getLocale()) }}</div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i>
                        {{ __('audit-logs.dashboard.monthly_activity', [], app()->getLocale()) }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyActivityChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i>
                        {{ __('audit-logs.dashboard.recent_activity', [], app()->getLocale()) }}
                    </h5>
                    <span class="badge bg-primary">{{ $recentLogs->count() }} {{ __('audit-logs.dashboard.latest_entries', [], app()->getLocale()) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('audit-logs.table.columns.time') }}</th>
                                    <th>{{ __('audit-logs.table.columns.user') }}</th>
                                    <th>{{ __('audit-logs.table.columns.event') }}</th>
                                    <th>{{ __('audit-logs.table.columns.model') }}</th>
                                    <th>{{ __('audit-logs.dashboard.summary', [], app()->getLocale()) }}</th>
                                    <th>{{ __('audit-logs.table.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="text-muted small">{{ $log->created_at->format('H:i:s') }}</span>
                                            <br>
                                            <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            @if($log->user)
                                                <div class="d-flex align-items-center">
                                                    @php $userImg = $log->user->image_url; @endphp
                                                    @if($userImg)
                                                        <img src="{{ asset($userImg) }}" alt="{{ $log->user->name }}" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                                                    @else
                                                        <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2">
                                                            {{ substr($log->user->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold small">{{ $log->user->name }}</div>
                                                        <small class="text-muted">{{ ucfirst($log->user->role) }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('audit-logs.table.system') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $eventColors = [
                                                    'created' => 'success',
                                                    'updated' => 'warning',
                                                    'deleted' => 'danger',
                                                    'restored' => 'info'
                                                ];
                                                $color = $eventColors[$log->event] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                {{ __('audit-logs.table.events.' . $log->event, [], app()->getLocale()) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold">{{ class_basename($log->auditable_type) }}</span>
                                                <small class="text-muted d-block">ID: {{ $log->auditable_id }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if($log->new_values && count($log->new_values) > 0)
                                                @php
                                                    $changedFields = collect($log->new_values)->keys()->take(3);
                                                @endphp
                                                <small class="text-muted">
                                                    {{ __('audit-logs.dashboard.changed', [], app()->getLocale()) }}: {{ $changedFields->implode(', ') }}
                                                    @if(count($log->new_values) > 3)
                                                        <span class="badge bg-light text-dark">+{{ count($log->new_values) - 3 }} {{ __('audit-logs.dashboard.more', [], app()->getLocale()) }}</span>
                                                    @endif
                                                </small>
                                            @else
                                                <small class="text-muted">{{ __('audit-logs.table.events.' . $log->event, [], app()->getLocale()) }} {{ class_basename($log->auditable_type) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-primary">
                        {{ __('audit-logs.dashboard.view_all_activity_logs', [], app()->getLocale()) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
}
.stats-card {
    padding: 20px;
    border-radius: 8px;
    color: #fff;
    margin-bottom: 1rem;
}
.stats-card.primary {
    background-color: #007bff;
}
.stats-card.info {
    background-color: #17a2b8;
}
.stats-card.success {
    background-color: #28a745;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Activity Chart
const dailyActivityCtx = document.getElementById('dailyActivityChart').getContext('2d');
const dailyActivityChart = new Chart(dailyActivityCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailyActivity->pluck('date')) !!},
        datasets: [{
            label: 'Activity Count',
            data: {!! json_encode($dailyActivity->pluck('count')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Event Types Chart
const eventTypesCtx = document.getElementById('eventTypesChart').getContext('2d');
const eventTypesChart = new Chart(eventTypesCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($eventStats->pluck('event')->map(function($event) { return ucfirst($event); })) !!},
        datasets: [{
            data: {!! json_encode($eventStats->pluck('count')) !!},
            backgroundColor: [
                '#28a745', // created - green
                '#ffc107', // updated - yellow
                '#dc3545', // deleted - red
                '#17a2b8', // restored - blue
                '#6f42c1', // other - purple
                '#fd7e14'  // other - orange
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Monthly Activity Chart
const monthlyActivityCtx = document.getElementById('monthlyActivityChart').getContext('2d');
const monthlyActivityChart = new Chart(monthlyActivityCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyActivity->pluck('month')) !!},
        datasets: [{
            label: 'Logs',
            data: {!! json_encode($monthlyActivity->pluck('count')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
@endsection
