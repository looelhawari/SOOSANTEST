@extends('layouts.admin')

@section('title', __('audit-logs.header.title'))

@section('content')
<div class="container-fluid">
    <!-- Header with stats -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-eye text-primary"></i>
                    {{ __('audit-logs.header.title') }}
                </h1>
                <div class="btn-group">
                    <a href="{{ route('admin.audit-logs.dashboard') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> {{ __('audit-logs.header.dashboard_btn') }}
                    </a>
                    <button type="button" class="btn btn-success" onclick="exportLogs()">
                        <i class="fas fa-download"></i> {{ __('audit-logs.header.export_btn') }}
                    </button>
                    <button type="button" class="btn btn-warning" id="realTimeToggle">
                        <i class="fas fa-play"></i> {{ __('audit-logs.header.realtime_btn') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-list-alt fa-2x me-3"></i>
                        <div>
                            <div class="small">{{ __('audit-logs.stats.total_events') }}</div>
                            <div class="h4">{{ number_format($stats['total_logs']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-day fa-2x me-3"></i>
                        <div>
                            <div class="small">{{ __('audit-logs.stats.today') }}</div>
                            <div class="h4">{{ number_format($stats['today_logs']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-week fa-2x me-3"></i>
                        <div>
                            <div class="small">{{ __('audit-logs.stats.this_week') }}</div>
                            <div class="h4">{{ number_format($stats['this_week_logs']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-calendar-alt fa-2x me-3"></i>
                        <div>
                            <div class="small">{{ __('audit-logs.stats.this_month') }}</div>
                            <div class="h4">{{ number_format($stats['this_month_logs']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-filter"></i> {{ __('audit-logs.filters.title') }}
                <button class="btn btn-sm btn-outline-secondary ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse">
                    {{ __('audit-logs.filters.toggle_btn') }}
                </button>
            </h5>
        </div>
        <div class="collapse show" id="filtersCollapse">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.audit-logs.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.date_from') }}</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.date_to') }}</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.event_type') }}</label>
                            <select name="event" class="form-select">
                                <option value="">{{ __('audit-logs.filters.all_events') }}</option>
                                @foreach($events as $event)
                                    <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>
                                        {{ __('audit-logs.table.events.' . $event) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.model_type') }}</label>
                            <select name="model_type" class="form-select">
                                <option value="">{{ __('audit-logs.filters.all_models') }}</option>
                                @foreach($modelTypes as $type)
                                    <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                        {{ class_basename($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.user') }}</label>
                            <select name="user_id" class="form-select">
                                <option value="">{{ __('audit-logs.filters.all_users') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('audit-logs.filters.search') }}</label>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('audit-logs.filters.search_placeholder') }}" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> {{ __('audit-logs.filters.apply_btn') }}
                            </button>
                            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> {{ __('audit-logs.filters.clear_btn') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-history"></i> {{ __('audit-logs.table.title') }}
                <span class="badge bg-secondary">{{ $auditLogs->total() }} {{ __('audit-logs.table.entries') }}</span>
            </h5>
            <div id="realTimeStatus" class="text-muted small" style="display: none;">
                <i class="fas fa-circle text-success blink"></i> {{ __('audit-logs.table.live_monitoring') }}
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="auditLogsTable">
                    <thead class="table-dark">
                        <tr>
                            <th>{{ __('audit-logs.table.columns.time') }}</th>
                            <th>{{ __('audit-logs.table.columns.user') }}</th>
                            <th>{{ __('audit-logs.table.columns.event') }}</th>
                            <th>{{ __('audit-logs.table.columns.model') }}</th>
                            <th>{{ __('audit-logs.table.columns.ip_address') }}</th>
                            <th>{{ __('audit-logs.table.columns.details') }}</th>
                            <th>{{ __('audit-logs.table.columns.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr data-log-id="{{ $log->id }}">
                                <td>
                                    <span class="text-muted small">{{ $log->created_at->format('M d, H:i:s') }}</span>
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
                                                <div class="avatar-circle bg-primary text-white">
                                                    {{ substr($log->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $log->user->name }}</div>
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
                                        <i class="fas fa-{{ $log->event == 'created' ? 'plus' : ($log->event == 'updated' ? 'edit' : ($log->event == 'deleted' ? 'trash' : 'undo')) }}"></i>
                                        {{ __('audit-logs.table.events.' . $log->event) }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold">{{ class_basename($log->auditable_type) }}</span>
                                        <small class="text-muted d-block">ID: {{ $log->auditable_id }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace small">{{ $log->ip_address ?: __('audit-logs.table.na') }}</span>
                                    @if($log->url)
                                        <br><small class="text-muted">{{ Str::limit($log->url, 30) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($log->new_values)
                                        <button class="btn btn-sm btn-outline-info" onclick="showChanges({{ json_encode($log->old_values) }}, {{ json_encode($log->new_values) }}, '{{ $log->event }}')">
                                            <i class="fas fa-eye"></i> {{ __('audit-logs.table.view_changes') }}
                                        </button>
                                    @else
                                        <span class="text-muted">{{ __('audit-logs.table.no_changes') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-search fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('audit-logs.table.empty_state') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($auditLogs->hasPages())
            <div class="card-footer">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Changes Modal -->
<div class="modal fade" id="changesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="changesContent"></div>
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

.blink {
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

.font-monospace {
    font-family: 'Courier New', monospace;
}
</style>

<script>
let realTimeEnabled = false;
let lastLogId = 0;
let realTimeInterval;

// Initialize last log ID
@if($auditLogs->count() > 0)
lastLogId = {{ $auditLogs->first()->id }};
@endif

document.getElementById('realTimeToggle').addEventListener('click', function() {
    realTimeEnabled = !realTimeEnabled;
    
    if (realTimeEnabled) {
        this.innerHTML = '<i class="fas fa-pause"></i> Stop Real-time';
        this.className = 'btn btn-danger';
        document.getElementById('realTimeStatus').style.display = 'block';
        startRealTimeMonitoring();
    } else {
        this.innerHTML = '<i class="fas fa-play"></i> Real-time';
        this.className = 'btn btn-warning';
        document.getElementById('realTimeStatus').style.display = 'none';
        stopRealTimeMonitoring();
    }
});

function startRealTimeMonitoring() {
    realTimeInterval = setInterval(fetchNewLogs, 3000); // Check every 3 seconds
}

function stopRealTimeMonitoring() {
    if (realTimeInterval) {
        clearInterval(realTimeInterval);
    }
}

function fetchNewLogs() {
    fetch(`{{ route('admin.audit-logs.realtime') }}?last_id=${lastLogId}`)
        .then(response => response.json())
        .then(data => {
            if (data.logs && data.logs.length > 0) {
                data.logs.forEach(log => {
                    addLogToTable(log);
                });
                lastLogId = data.last_id;
            }
        })
        .catch(error => {
            console.error('Error fetching real-time logs:', error);
        });
}

function addLogToTable(log) {
    const tbody = document.querySelector('#auditLogsTable tbody');
    const row = document.createElement('tr');
    row.className = 'table-warning';
    row.setAttribute('data-log-id', log.id);
    
    const eventColors = {
        'created': 'success',
        'updated': 'warning', 
        'deleted': 'danger',
        'restored': 'info'
    };
    const color = eventColors[log.event] || 'secondary';
    
    const eventIcons = {
        'created': 'plus',
        'updated': 'edit',
        'deleted': 'trash',
        'restored': 'undo'
    };
    const icon = eventIcons[log.event] || 'question';
    
    row.innerHTML = `
        <td>
            <span class="text-muted small">${new Date(log.created_at).toLocaleString()}</span>
            <br>
            <small class="text-muted">Just now</small>
        </td>
        <td>
            ${log.user ? `
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2">
                        ${log.user.name.charAt(0)}
                    </div>
                    <div>
                        <div class="fw-bold">${log.user.name}</div>
                        <small class="text-muted">${log.user.role}</small>
                    </div>
                </div>
            ` : '<span class="text-muted">System</span>'}
        </td>
        <td>
            <span class="badge bg-${color}">
                <i class="fas fa-${icon}"></i>
                ${log.event.charAt(0).toUpperCase() + log.event.slice(1)}
            </span>
        </td>
        <td>
            <div>
                <span class="fw-bold">${log.auditable_type.split('\\').pop()}</span>
                <small class="text-muted d-block">ID: ${log.auditable_id}</small>
            </div>
        </td>
        <td>
            <span class="font-monospace small">${log.ip_address || 'N/A'}</span>
            ${log.url ? `<br><small class="text-muted">${log.url.substring(0, 30)}</small>` : ''}
        </td>
        <td>
            ${log.new_values ? `
                <button class="btn btn-sm btn-outline-info" onclick="showChanges(${JSON.stringify(log.old_values)}, ${JSON.stringify(log.new_values)}, '${log.event}')">
                    <i class="fas fa-eye"></i> View Changes
                </button>
            ` : '<span class="text-muted">No changes</span>'}
        </td>
        <td>
            <a href="/admin/audit-logs/${log.id}" class="btn btn-sm btn-primary">
                <i class="fas fa-search"></i>
            </a>
        </td>
    `;
    
    tbody.insertBefore(row, tbody.firstChild);
    
    // Remove highlight after 5 seconds
    setTimeout(() => {
        row.classList.remove('table-warning');
    }, 5000);
}

function showChanges(oldValues, newValues, event) {
    let content = '';
    
    if (event === 'created') {
        content = '<h6>New Record Created:</h6>';
        content += '<div class="row"><div class="col-12">';
        content += '<h6 class="text-success">New Values:</h6>';
        content += '<pre class="bg-light p-3 rounded">' + JSON.stringify(newValues, null, 2) + '</pre>';
        content += '</div></div>';
    } else if (event === 'updated') {
        content = '<h6>Record Updated:</h6>';
        content += '<div class="row">';
        content += '<div class="col-md-6">';
        content += '<h6 class="text-danger">Old Values:</h6>';
        content += '<pre class="bg-light p-3 rounded">' + JSON.stringify(oldValues, null, 2) + '</pre>';
        content += '</div>';
        content += '<div class="col-md-6">';
        content += '<h6 class="text-success">New Values:</h6>';
        content += '<pre class="bg-light p-3 rounded">' + JSON.stringify(newValues, null, 2) + '</pre>';
        content += '</div>';
        content += '</div>';
    } else if (event === 'deleted') {
        content = '<h6>Record Deleted:</h6>';
        content += '<div class="row"><div class="col-12">';
        content += '<h6 class="text-danger">Deleted Values:</h6>';
        content += '<pre class="bg-light p-3 rounded">' + JSON.stringify(oldValues, null, 2) + '</pre>';
        content += '</div></div>';
    }
    
    document.getElementById('changesContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('changesModal')).show();
}

function exportLogs() {
    const form = document.getElementById('filterForm');
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    window.open(`{{ route('admin.audit-logs.export') }}?${params.toString()}`, '_blank');
}

// Auto-submit form on filter change
document.querySelectorAll('#filterForm select, #filterForm input[type="date"]').forEach(element => {
    element.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>
@endsection
