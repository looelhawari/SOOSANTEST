<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        
        <!-- Global Styles -->
        <link href="{{ asset('css/global-styles.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-color: #2563eb;
                --secondary-color: #1d4ed8;
                --accent-color: #4ade80;
                --background-color: #f8fafc;
                --text-color: #111827;
                --text-muted: #6b7280;
                --border-color: #e2e8f0;
                --shadow-color: rgba(0, 0, 0, 0.1);
                --transition-duration: 0.4s;
                --border-radius: 12px;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background: var(--background-color);
                color: var(--text-color);
                line-height: 1.6;
            }
            
            .app-container {
                min-height: 100vh;
                background: var(--background-color);
            }
            
            .app-header {
                background: white;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                border-bottom: 1px solid var(--border-color);
                position: sticky;
                top: 0;
                z-index: 100;
            }
            
            .app-header-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 1.5rem 2rem;
            }
            
            .app-main {
                padding: 2rem 0;
                min-height: calc(100vh - 200px);
            }
            
            .app-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
            }
            
            /* Enhanced card styles for dashboard */
            .dashboard-card {
                background: white;
                border-radius: var(--border-radius);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                padding: 2rem;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .dashboard-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
                transform: scaleX(0);
                transition: transform 0.3s ease;
                transform-origin: left;
            }
            
            .dashboard-card:hover::before {
                transform: scaleX(1);
            }
            
            .dashboard-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
            }
            
            /* Enhanced navigation styles */
            .app-nav {
                background: white;
                border-bottom: 1px solid var(--border-color);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .nav-item {
                color: var(--text-muted);
                text-decoration: none;
                padding: 0.75rem 1.5rem;
                border-radius: var(--border-radius);
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-weight: 500;
            }
            
            .nav-item:hover {
                color: var(--primary-color);
                background: rgba(37, 99, 235, 0.05);
                text-decoration: none;
                transform: translateX(4px);
            }
            
            .nav-item.active {
                color: var(--primary-color);
                background: rgba(37, 99, 235, 0.1);
                border-left: 4px solid var(--primary-color);
            }
            
            /* Enhanced button styles */
            .btn-enhanced {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: var(--border-radius);
                padding: 0.75rem 1.5rem;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s ease;
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }
            
            .btn-enhanced:hover {
                background: var(--secondary-color);
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
                color: white;
                text-decoration: none;
            }
            
            .btn-enhanced::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s ease;
            }
            
            .btn-enhanced:hover::before {
                left: 100%;
            }
            
            .btn-secondary {
                background: var(--accent-color);
            }
            
            .btn-secondary:hover {
                background: #22c55e;
                box-shadow: 0 8px 20px rgba(74, 222, 128, 0.3);
            }
            
            .btn-outline {
                background: transparent;
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
            }
            
            .btn-outline:hover {
                background: var(--primary-color);
                color: white;
            }
            
            /* Form enhancements */
            .form-enhanced {
                background: white;
                border-radius: var(--border-radius);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
                padding: 2rem;
            }
            
            .form-field {
                margin-bottom: 1.5rem;
            }
            
            .field-label {
                display: block;
                color: var(--text-color);
                font-weight: 600;
                margin-bottom: 0.5rem;
                font-size: 0.95rem;
            }
            
            .field-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 2px solid var(--border-color);
                border-radius: var(--border-radius);
                font-size: 1rem;
                transition: all 0.3s ease;
                background: white;
                color: var(--text-color);
            }
            
            .field-input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
                transform: translateY(-1px);
            }
            
            /* Table enhancements */
            .table-enhanced {
                width: 100%;
                background: white;
                border-radius: var(--border-radius);
                overflow: hidden;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                border: 1px solid var(--border-color);
            }
            
            .table-enhanced thead {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
            }
            
            .table-enhanced th {
                padding: 1rem 1.5rem;
                font-weight: 600;
                text-align: left;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .table-enhanced td {
                padding: 1rem 1.5rem;
                border-bottom: 1px solid var(--border-color);
                transition: all 0.3s ease;
            }
            
            .table-enhanced tbody tr:hover {
                background: rgba(37, 99, 235, 0.02);
            }
            
            .table-enhanced tbody tr:last-child td {
                border-bottom: none;
            }
            
            /* Alert enhancements */
            .alert-enhanced {
                padding: 1rem 1.5rem;
                border-radius: var(--border-radius);
                margin-bottom: 1.5rem;
                border-left: 4px solid;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }
            
            .alert-success {
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                border-color: var(--accent-color);
                color: #166534;
            }
            
            .alert-error {
                background: linear-gradient(135deg, #fef2f2, #fecaca);
                border-color: #dc2626;
                color: #991b1b;
            }
            
            .alert-warning {
                background: linear-gradient(135deg, #fefce8, #fef3c7);
                border-color: #f59e0b;
                color: #92400e;
            }
            
            .alert-info {
                background: linear-gradient(135deg, #dbeafe, #bfdbfe);
                border-color: var(--primary-color);
                color: #1e40af;
            }
            
            /* Notification Styles */
            /* Notification Badge Styles */
            .notification-badge {
                font-size: 0.7rem;
                min-width: 18px;
                height: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: pulse 2s infinite;
            }
            
            .badge-pulse {
                animation: pulse 1s ease-in-out;
            }
            
            .badge-new {
                animation: bounce 0.5s ease-in-out;
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            
            /* Notification Dropdown Styles */
            .notification-dropdown-content {
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                border-radius: 12px;
                padding: 0;
            }
            
            .notification-item {
                border-bottom: 1px solid #f1f5f9;
                transition: all 0.3s ease;
            }
            
            .notification-item:hover {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                transform: translateX(5px);
            }
            
            .notification-item.unread {
                background: linear-gradient(135deg, #fef3c7 0%, #fef7cd 100%);
                border-left: 4px solid #f59e0b;
            }
            
            .notification-dot {
                width: 8px;
                height: 8px;
                background: #ef4444;
                border-radius: 50%;
                margin-left: 10px;
                animation: pulse 2s infinite;
            }
            
            .notification-new {
                animation: slideInRight 0.5s ease-out;
            }
            
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            /* Toast Notification Styles */
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 350px;
                background: white;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                overflow: hidden;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }
            
            .toast-notification.show {
                transform: translateX(0);
            }
            
            .toast-notification .toast-header {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                color: white;
                padding: 12px 16px;
                border-bottom: none;
            }
            
            .toast-notification .toast-body {
                padding: 16px;
            }
            
            .toast-notification .btn-close {
                filter: invert(1);
            }
            
            /* Mobile responsive */
            @media (max-width: 768px) {
                .app-header-content,
                .app-content {
                    padding: 1rem;
                }
                
                .dashboard-card {
                    padding: 1.5rem;
                }
                
                .form-enhanced {
                    padding: 1.5rem;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="app-container">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="app-header">
                    <div class="app-header-content">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="app-main">
                <div class="app-content">
                    {{ $slot }}
                </div>
            </main>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Enhanced interactions for dashboard elements
                const cards = document.querySelectorAll('.dashboard-card');
                cards.forEach((card, index) => {
                    // Add entrance animation
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    
                    setTimeout(() => {
                        card.style.transition = 'all 0.6s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                    
                    // Enhanced hover interactions
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-8px) scale(1.02)';
                    });
                    
                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });
                
                // Enhanced button interactions
                const buttons = document.querySelectorAll('.btn-enhanced');
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        // Ripple effect
                        const ripple = document.createElement('span');
                        const rect = this.getBoundingClientRect();
                        const size = Math.max(rect.width, rect.height);
                        const x = e.clientX - rect.left - size / 2;
                        const y = e.clientY - rect.top - size / 2;
                        
                        ripple.style.cssText = `
                            position: absolute;
                            width: ${size}px;
                            height: ${size}px;
                            left: ${x}px;
                            top: ${y}px;
                            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
                            border-radius: 50%;
                            transform: scale(0);
                            animation: ripple 0.6s ease-out;
                            pointer-events: none;
                        `;
                        
                        this.appendChild(ripple);
                        
                        setTimeout(() => {
                            ripple.remove();
                        }, 600);
                    });
                });
                
                // Enhanced form interactions
                const inputs = document.querySelectorAll('.field-input');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.style.transform = 'translateY(-2px)';
                        this.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.15)';
                    });
                    
                    input.addEventListener('blur', function() {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                    });
                });
                
                // Enhanced table interactions
                const tableRows = document.querySelectorAll('.table-enhanced tbody tr');
                tableRows.forEach(row => {
                    row.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateX(4px)';
                        this.style.boxShadow = '4px 0 8px rgba(37, 99, 235, 0.1)';
                    });
                    
                    row.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateX(0)';
                        this.style.boxShadow = 'none';
                    });
                });
                
                // Add ripple animation CSS
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(style);
            });
        </script>
        
        <!-- Notification JavaScript -->
        <script src="{{ asset('js/notifications.js') }}"></script>
        
        <script>
            // Initialize notifications when page loads
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof NotificationManager !== 'undefined') {
                    window.notificationManager = new NotificationManager();
                }
            });
            
            // Global notification functions
            function markNotificationAsRead(notificationId) {
                if (window.notificationManager) {
                    window.notificationManager.markAsRead(notificationId);
                }
            }
            
            function markAllNotificationsAsRead() {
                if (window.notificationManager) {
                    window.notificationManager.markAllAsRead();
                }
            }
            
            // Handle notification clicks
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('notification-item') || e.target.closest('.notification-item')) {
                    const notificationItem = e.target.classList.contains('notification-item') ? e.target : e.target.closest('.notification-item');
                    const notificationId = notificationItem.dataset.notificationId;
                    
                    if (notificationId) {
                        markNotificationAsRead(notificationId);
                    }
                }
            });
        </script>
    </body>
</html>
