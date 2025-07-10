@extends('layouts.admin')

@section('title', __('admin.pending_changes'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="page-title">{{ __('admin.pending_changes') }}</h1>
                    <div>
                        <a href="{{ route('admin.pending-changes.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history"></i> {{ __('admin.view_history') }}
                        </a>
                    </div>
                </div>
            </div>

            @if($pendingChanges->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.type') }}</th>
                                        <th>{{ __('admin.action') }}</th>
                                        <th>{{ __('admin.requested_by') }}</th>
                                        <th>{{ __('admin.requested_at') }}</th>
                                        <th>{{ __('admin.summary') }}</th>
                                        <th>{{ __('admin.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingChanges as $change)
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">{{ $change->model_name }}</span>
                                            </td>
                                            <td>
                                                @if($change->action === 'update')
                                                    <span class="badge badge-warning">{{ __('admin.update') }}</span>
                                                @elseif($change->action === 'delete')
                                                    <span class="badge badge-danger">{{ __('admin.delete') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $change->requestedBy->name }}</td>
                                            <td>{{ $change->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                @if($change->action === 'delete')
                                                    <span class="text-danger">{{ __('admin.delete_record') }}</span>
                                                @else
                                                    @php
                                                        $changes = $change->changed_fields;
                                                        $changeCount = count($changes);
                                                    @endphp
                                                    <small class="text-muted">
                                                        {{ $changeCount }} {{ __('admin.fields_changed') }}
                                                        @if($changeCount > 0)
                                                            ({{ implode(', ', array_keys($changes)) }})
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.pending-changes.show', $change) }}" 
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i> {{ __('admin.view') }}
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.pending-changes.approve', $change) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                                onclick="return confirm('{{ __('admin.confirm_approve') }}')">
                                                            <i class="fas fa-check"></i> {{ __('admin.approve') }}
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#rejectModal{{ $change->id }}">
                                                        <i class="fas fa-times"></i> {{ __('admin.reject') }}
                                                    </button>
                                                </div>

                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $change->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{ route('admin.pending-changes.reject', $change) }}">
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ __('admin.reject_change') }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>{{ __('admin.reason_for_rejection') }}</label>
                                                                        <textarea name="review_notes" class="form-control" rows="3" required
                                                                                  placeholder="{{ __('admin.explain_rejection') }}"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        {{ __('admin.cancel') }}
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        {{ __('admin.reject') }}
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pendingChanges->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('admin.no_pending_changes') }}</h4>
                        <p class="text-muted">{{ __('admin.no_pending_changes_desc') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
