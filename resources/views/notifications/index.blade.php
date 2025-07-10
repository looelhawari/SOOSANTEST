@extends('layouts.admin')

@section('title', __('admin.notifications'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('admin.notifications') }}</h4>
                    @if($notifications->count() > 0)
                        <form method="POST" action="{{ route('notifications.mark-all-as-read') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                {{ __('admin.mark_all_as_read') }}
                            </button>
                        </form>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item {{ $notification->read_at ? '' : 'list-group-item-warning' }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                {{ $notification->data['title'] ?? __('admin.notifications') }}
                                                @if(!$notification->read_at)
                                                    <span class="badge bg-warning ms-2">{{ __('New') }}</span>
                                                @endif
                                            </h6>
                                            <p class="mb-1">{{ $notification->data['message'] ?? '' }}</p>
                                            
                                            @if(isset($notification->data['reason']) && $notification->data['reason'])
                                                <div class="alert alert-danger mt-2 mb-2">
                                                    <strong>{{ __('admin.reason_for_rejection') }}</strong> {{ $notification->data['reason'] }}
                                                </div>
                                            @endif
                                            
                                            @if(isset($notification->data['reviewed_by']))
                                                <small class="text-muted">
                                                    {{ __('admin.reviewed_by') }} {{ $notification->data['reviewed_by'] }} 
                                                    @if(isset($notification->data['reviewed_at']))
                                                        {{ __('admin.reviewed_at') }} {{ $notification->data['reviewed_at'] }}
                                                    @endif
                                                </small>
                                            @endif
                                        </div>
                                        
                                        <div class="ms-3">
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            @if(!$notification->read_at)
                                                <form method="POST" action="{{ route('notifications.mark-as-read', $notification->id) }}" class="d-inline mt-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        {{ __('admin.mark_as_read') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('admin.no_notifications_yet') }}</h5>
                            <p class="text-muted">{{ __('admin.notifications_help') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
