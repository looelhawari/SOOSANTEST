@extends('layouts.admin')

@section('title', __('contact-messages.page_title'))

@section('content')
<style>
    .modern-page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 0;
        margin: -2rem -2rem 2rem;
        border-radius: 0 0 1rem 1rem;
        position: relative;
        overflow: hidden;
    }
    .modern-page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
    }
    .modern-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 1rem;
        text-align: center;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    .message-card {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        position: relative;
    }
    .message-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-color: #667eea;
    }
    .message-card.unread {
        border-left: 4px solid #ffc107;
        background: #fff9e6;
    }
    .message-card.read {
        border-left: 4px solid #28a745;
    }
    .message-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.5rem;
        margin-right: 1rem;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    .modern-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0 0.25rem;
    }
    .modern-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .modern-btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    .modern-btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    .modern-btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }
    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid;
        background: transparent;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }
    .action-btn:hover {
        transform: scale(1.1);
    }
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    .filter-tabs {
        background: #fff;
        border-radius: 50px;
        padding: 0.25rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        display: inline-flex;
        margin-bottom: 2rem;
    }
    .filter-tab {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        background: transparent;
        border: none;
        color: #6c757d;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .filter-tab.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
</style>

<!-- Page Header -->
<div class="modern-page-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="h2 mb-2">{{ __('contact-messages.page_title') }}</h1>
                @if(auth()->user()->isEmployee())
                    <p class="mb-0 opacity-75">{{ __('contact-messages.view_customer_inquiries') }}</p>
                @else
                    <p class="mb-0 opacity-75">{{ __('contact-messages.manage_customer_inquiries') }}</p>
                @endif
            </div>
            <div class="col-md-4 text-md-end">
                <div class="filter-tabs">
                    <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" 
                       class="filter-tab {{ request('status') == 'unread' ? 'active' : '' }}">
                        <i class="fas fa-envelope me-1"></i>{{ __('contact-messages.unread') }}
                    </a>
                    <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" 
                       class="filter-tab {{ request('status') == 'read' ? 'active' : '' }}">
                        <i class="fas fa-envelope-open me-1"></i>{{ __('contact-messages.read') }}
                    </a>
                    <a href="{{ route('admin.contact-messages.index') }}" 
                       class="filter-tab {{ !request('status') ? 'active' : '' }}">
                        <i class="fas fa-list me-1"></i>{{ __('contact-messages.all') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 1rem; border: none; box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $messages->total() }}</div>
        <div class="stat-label">{{ __('contact-messages.total_messages') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
        <div class="stat-value">{{ $messages->where('is_read', false)->count() }}</div>
        <div class="stat-label">{{ __('contact-messages.unread_messages') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
        <div class="stat-value">{{ $messages->where('is_read', true)->count() }}</div>
        <div class="stat-label">{{ __('contact-messages.read_messages') }}</div>
    </div>
    <div class="stat-card" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
        <div class="stat-value">{{ $messages->where('created_at', '>=', now()->subDay())->count() }}</div>
        <div class="stat-label">{{ __('contact-messages.todays_messages') }}</div>
    </div>
</div>

<!-- Messages Grid -->
<div class="row">
    @forelse($messages as $message)
        <div class="col-lg-12 mb-4">
            <div class="message-card {{ !$message->is_read ? 'unread' : 'read' }}">
                <div class="d-flex align-items-start">
                    <div class="message-avatar">
                        {{ strtoupper(substr($message->first_name, 0, 1)) }}{{ strtoupper(substr($message->last_name, 0, 1)) }}
                    </div>
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="mb-1">{{ $message->first_name }} {{ $message->last_name }}</h5>
                                <small class="text-muted">{{ $message->email }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge badge-modern bg-{{ !$message->is_read ? 'warning' : 'success' }}">
                                    {{ $message->is_read ? __('contact-messages.read_status') : __('contact-messages.unread_status') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ $message->created_at ? $message->created_at->diffForHumans() : __('contact-messages.na') }}
                                </small>
                            </div>
                        </div>
                        
                        <h6 class="mb-2 text-primary">{{ $message->subject ?? __('contact-messages.no_subject') }}</h6>
                        <p class="text-muted mb-3">{{ Str::limit($message->message, 120) }}</p>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.contact-messages.show', $message) }}" 
                               class="action-btn border-info text-info" 
                               title="{{ __('contact-messages.view_message_tooltip') }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if(!$message->is_read && auth()->user()->isAdmin())
                                <form action="{{ route('admin.contact-messages.mark-read', $message) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="action-btn border-success text-success" 
                                            title="{{ __('contact-messages.mark_as_read_tooltip') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            
                            @if(auth()->user()->isAdmin())
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn border-danger text-danger" 
                                            title="{{ __('contact-messages.delete_message_tooltip') }}"
                                            onclick="return confirm('{{ __('contact-messages.confirm_delete_message') }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4>{{ __('contact-messages.no_messages_found') }}</h4>
                <p class="mb-4">
                    @if(request('status'))
                        {{ __('contact-messages.no_status_messages', ['status' => __(('contact-messages.' . request('status')))]) }}
                    @else
                        {{ __('contact-messages.no_contact_messages_yet') }}
                    @endif
                </p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($messages->hasPages())
    <div class="modern-card">
        <div class="card-body text-center">
            {{ $messages->withQueryString()->links() }}
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth hover effects
    const messageCards = document.querySelectorAll('.message-card');
    messageCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animate stat cards on load
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Auto-refresh unread count every 30 seconds
    setInterval(function() {
        // This could be enhanced with AJAX to update the unread count
        console.log('Checking for new messages...');
    }, 30000);
});
</script>
@endsection
