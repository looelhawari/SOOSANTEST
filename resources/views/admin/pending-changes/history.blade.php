@extends('layouts.admin')

@section('title', __('admin.change_history'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="page-title">{{ __('admin.change_history') }}</h1>
                    <div>
                        <a href="{{ route('admin.pending-changes.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-clock"></i> {{ __('admin.pending_changes') }}
                        </a>
                    </div>
                </div>
            </div>

            @if($changes->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">{{ __('admin.all_changes') }}</h5>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="statusFilter" id="all" value="all" checked>
                                <label class="btn btn-outline-secondary" for="all">{{ __('admin.all_changes') }}</label>
                                
                                <input type="radio" class="btn-check" name="statusFilter" id="approved" value="approved">
                                <label class="btn btn-outline-success" for="approved">{{ __('admin.approved_changes') }}</label>
                                
                                <input type="radio" class="btn-check" name="statusFilter" id="rejected" value="rejected">
                                <label class="btn btn-outline-danger" for="rejected">{{ __('admin.rejected_changes') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.change_type') }}</th>
                                        <th>{{ __('admin.action') }}</th>
                                        <th>{{ __('admin.requested_by') }}</th>
                                        <th>{{ __('admin.requested_at') }}</th>
                                        <th>{{ __('admin.reviewed_by') }}</th>
                                        <th>{{ __('admin.reviewed_at') }}</th>
                                        <th>{{ __('admin.status') }}</th>
                                        <th>{{ __('admin.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($changes as $change)
                                        <tr data-status="{{ $change->status }}">
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
                                            <td>{{ $change->reviewedBy->name ?? '-' }}</td>
                                            <td>{{ $change->reviewed_at ? $change->reviewed_at->format('M d, Y H:i') : '-' }}</td>
                                            <td>
                                                @if($change->status === 'approved')
                                                    <span class="badge badge-success">{{ __('admin.approved') }}</span>
                                                @elseif($change->status === 'rejected')
                                                    <span class="badge badge-danger">{{ __('admin.rejected') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.pending-changes.show', $change) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i> {{ __('admin.view') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $changes->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('admin.no_history') }}</h4>
                        <p class="text-muted">{{ __('admin.no_history_desc') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilters = document.querySelectorAll('input[name="statusFilter"]');
    const tableRows = document.querySelectorAll('tbody tr');

    statusFilters.forEach(filter => {
        filter.addEventListener('change', function() {
            const selectedStatus = this.value;
            
            tableRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                
                if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
