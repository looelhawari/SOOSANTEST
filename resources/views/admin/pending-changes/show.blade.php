@extends('layouts.admin')

@section('title', __('admin.review_change'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="page-title">{{ __('admin.review_change') }}</h1>
                    <a href="{{ route('admin.pending-changes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('admin.back_to_list') }}
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('admin.change_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>{{ __('admin.type') }}:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge badge-info">{{ $pendingChange->model_name }}</span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>{{ __('admin.action') }}:</strong></div>
                                <div class="col-sm-9">
                                    @if($pendingChange->action === 'update')
                                        <span class="badge badge-warning">{{ __('admin.update') }}</span>
                                    @elseif($pendingChange->action === 'delete')
                                        <span class="badge badge-danger">{{ __('admin.delete') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>{{ __('admin.requested_by') }}:</strong></div>
                                <div class="col-sm-9">{{ $pendingChange->requestedBy->name }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>{{ __('admin.requested_at') }}:</strong></div>
                                <div class="col-sm-9">{{ $pendingChange->created_at->format('M d, Y H:i:s') }}</div>
                            </div>

                            @if($pendingChange->action === 'delete')
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ __('admin.delete_warning') }}
                                </div>
                            @else
                                <h6 class="mt-4 mb-3">{{ __('admin.proposed_changes') }}:</h6>
                                
                                @php $changes = $pendingChange->changed_fields; @endphp
                                
                                @if(count($changes) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>{{ __('admin.field') }}</th>
                                                    <th>{{ __('admin.current_value') }}</th>
                                                    <th>{{ __('admin.proposed_value') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($changes as $field => $change)
                                                    <tr>
                                                        <td><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}</strong></td>
                                                        <td>
                                                            <span class="text-muted">
                                                                @if(is_null($change['from']))
                                                                    <em>{{ __('admin.empty') }}</em>
                                                                @else
                                                                    {{ $change['from'] }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="text-success font-weight-bold">
                                                                @if(is_null($change['to']))
                                                                    <em>{{ __('admin.empty') }}</em>
                                                                @else
                                                                    {{ $change['to'] }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">{{ __('admin.no_changes_detected') }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('admin.review_actions') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($pendingChange->isPending())
                                <!-- Approve Button -->
                                <form method="POST" action="{{ route('admin.pending-changes.approve', $pendingChange) }}" class="mb-3">
                                    @csrf
                                    <div class="form-group">
                                        <label>{{ __('admin.approval_notes') }} ({{ __('admin.optional') }})</label>
                                        <textarea name="review_notes" class="form-control" rows="2" 
                                                  placeholder="{{ __('admin.approval_notes_placeholder') }}"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block"
                                            onclick="return confirm('{{ __('admin.confirm_approve') }}')">
                                        <i class="fas fa-check"></i> {{ __('admin.approve_change') }}
                                    </button>
                                </form>

                                <!-- Reject Button -->
                                <button type="button" class="btn btn-danger btn-block" 
                                        data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times"></i> {{ __('admin.reject_change') }}
                                </button>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.pending-changes.reject', $pendingChange) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('admin.reject_change') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>{{ __('admin.reason_for_rejection') }} <span class="text-danger">*</span></label>
                                                        <textarea name="review_notes" class="form-control" rows="4" required
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
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    {{ __('admin.change_already_reviewed') }}
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-5"><strong>{{ __('admin.status') }}:</strong></div>
                                    <div class="col-sm-7">
                                        @if($pendingChange->isApproved())
                                            <span class="badge badge-success">{{ __('admin.approved') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('admin.rejected') }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($pendingChange->reviewedBy)
                                    <div class="row mt-2">
                                        <div class="col-sm-5"><strong>{{ __('admin.reviewed_by') }}:</strong></div>
                                        <div class="col-sm-7">{{ $pendingChange->reviewedBy->name }}</div>
                                    </div>
                                @endif
                                
                                @if($pendingChange->reviewed_at)
                                    <div class="row mt-2">
                                        <div class="col-sm-5"><strong>{{ __('admin.reviewed_at') }}:</strong></div>
                                        <div class="col-sm-7">{{ $pendingChange->reviewed_at->format('M d, Y H:i') }}</div>
                                    </div>
                                @endif
                                
                                @if($pendingChange->review_notes)
                                    <div class="mt-3">
                                        <strong>{{ __('admin.review_notes') }}:</strong>
                                        <p class="mt-1">{{ $pendingChange->review_notes }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
