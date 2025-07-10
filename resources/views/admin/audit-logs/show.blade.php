@extends('layouts.admin')

@section('title', __('audit-logs.show.title'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('audit-logs.show.title') }}</h1>
        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('audit-logs.show.back_to_logs') }}
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('audit-logs.show.basic_info') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>{{ __('audit-logs.show.event') }}</th>
                            <td>
                                <span class="badge badge-{{ $auditLog->event === 'created' ? 'success' : ($auditLog->event === 'updated' ? 'warning' : 'danger') }}">
                                    {{ __('audit-logs.table.events.' . $auditLog->event) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.model_type') }}</th>
                            <td>{{ class_basename($auditLog->auditable_type) }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.record_id') }}</th>
                            <td>{{ $auditLog->auditable_id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.user') }}</th>
                            <td>{{ $auditLog->user ? $auditLog->user->name . ' (#' . $auditLog->user->id . ')' : __('audit-logs.table.system') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.datetime') }}</th>
                            <td>{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.table.columns.ip_address') }}</th>
                            <td>{{ $auditLog->ip_address ?? __('audit-logs.table.na') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.method') }}</th>
                            <td>{{ $auditLog->method ?? __('audit-logs.table.na') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.url') }}</th>
                            <td>{{ $auditLog->url ?? __('audit-logs.table.na') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('audit-logs.show.user_agent') }}</th>
                            <td style="word-break: break-word;">{{ Str::limit($auditLog->user_agent, 100) ?? __('audit-logs.table.na') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($auditLog->old_values || $auditLog->new_values)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('audit-logs.show.data_changes') }}</h5>
                </div>
                <div class="card-body">
                    @if($auditLog->old_values && $auditLog->event === 'updated')
                    <h6>{{ __('audit-logs.modal.old_values') }}</h6>
                    <div class="bg-light p-3 mb-3 rounded">
                        <pre class="mb-0">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif

                    @if($auditLog->new_values)
                    <h6>{{ $auditLog->event === 'updated' ? __('audit-logs.modal.new_values') : __('audit-logs.modal.new_values') }}</h6>
                    <div class="bg-light p-3 rounded">
                        <pre class="mb-0">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif

                    @if($auditLog->old_values && $auditLog->event === 'deleted')
                    <h6>{{ __('audit-logs.modal.deleted_values') }}</h6>
                    <div class="bg-light p-3 rounded">
                        <pre class="mb-0">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($auditLog->event === 'updated' && $auditLog->old_values && $auditLog->new_values)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('audit-logs.show.field_comparison') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('audit-logs.show.field') }}</th>
                                    <th>{{ __('audit-logs.show.old_value') }}</th>
                                    <th>{{ __('audit-logs.show.new_value') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLog->new_values as $field => $newValue)
                                <tr>
                                    <td><strong>{{ $field }}</strong></td>
                                    <td>
                                        <span class="text-danger">
                                            {{ $auditLog->old_values[$field] ?? __('audit-logs.table.na') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            {{ $newValue }}
                                        </span>
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
    @endif
</div>
@endsection
