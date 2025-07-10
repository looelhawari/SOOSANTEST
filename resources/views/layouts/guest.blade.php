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
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }
            
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="auth-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23auth-pattern)"/></svg>');
                opacity: 0.5;
            }
            
            .auth-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                position: relative;
                z-index: 2;
            }
            
            .auth-logo {
                margin-bottom: 2rem;
                animation: fadeInDown 0.8s ease-out;
            }
            
            .auth-logo img {
                height: 60px;
                filter: brightness(0) invert(1);
                transition: all 0.3s ease;
            }
            
            .auth-logo:hover img {
                transform: scale(1.05);
                filter: brightness(0) invert(1) drop-shadow(0 4px 8px rgba(255,255,255,0.3));
            }
            
            .auth-card {
                width: 100%;
                max-width: 450px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: var(--border-radius);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(255, 255, 255, 0.2);
                padding: 3rem;
                position: relative;
                overflow: hidden;
                animation: slideUp 0.8s ease-out;
            }
            
            .auth-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--accent-color), var(--primary-color));
            }
            
            .auth-title {
                text-align: center;
                color: var(--text-color);
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }
            
            .auth-subtitle {
                text-align: center;
                color: var(--text-muted);
                margin-bottom: 2rem;
                font-size: 1rem;
            }
            
            /* Enhanced form styles */
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            .form-label {
                display: block;
                color: var(--text-color);
                font-weight: 600;
                margin-bottom: 0.5rem;
                font-size: 0.95rem;
            }
            
            .form-input {
                width: 100%;
                padding: 1rem 1.25rem;
                border: 2px solid var(--border-color);
                border-radius: var(--border-radius);
                font-size: 1rem;
                transition: all 0.3s ease;
                background: white;
                color: var(--text-color);
            }
            
            .form-input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
                transform: translateY(-1px);
            }
            
            .form-error {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }
            
            .checkbox-group {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin: 1.5rem 0;
            }
            
            .checkbox-input {
                width: 18px;
                height: 18px;
                border: 2px solid var(--border-color);
                border-radius: 4px;
                appearance: none;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
            }
            
            .checkbox-input:checked {
                background: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .checkbox-input:checked::after {
                content: '✓';
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                color: white;
                font-size: 12px;
                font-weight: bold;
            }
            
            .checkbox-label {
                color: var(--text-muted);
                font-size: 0.9rem;
                cursor: pointer;
            }
            
            .auth-button {
                width: 100%;
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: white;
                border: none;
                border-radius: var(--border-radius);
                padding: 1rem 2rem;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .auth-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
            }
            
            .auth-button:active {
                transform: translateY(0);
            }
            
            .auth-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s ease;
            }
            
            .auth-button:hover::before {
                left: 100%;
            }
            
            .auth-link {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                font-size: 0.9rem;
            }
            
            .auth-link:hover {
                color: var(--secondary-color);
                text-decoration: underline;
            }
            
            .auth-actions {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 2rem;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .status-message {
                background: linear-gradient(135deg, #dcfce7, #bbf7d0);
                color: #166534;
                padding: 1rem;
                border-radius: var(--border-radius);
                margin-bottom: 1.5rem;
                border-left: 4px solid var(--accent-color);
                font-size: 0.9rem;
            }
            
            /* Animations */
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Mobile responsive */
            @media (max-width: 768px) {
                .auth-container {
                    padding: 1rem;
                }
                
                .auth-card {
                    padding: 2rem;
                }
                
                .auth-actions {
                    flex-direction: column;
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <!-- Language Toggle for Guest Pages -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060;">
            <x-language-toggle style="background: rgba(255, 255, 255, 0.9); padding: 0.5rem; border-radius: 12px; backdrop-filter: blur(10px);" />
        </div>
        
        <div class="auth-container">
            <div class="auth-logo">
                <img src="{{ asset('images/logo.png') }}" alt="SoosanEgypt" onerror="this.style.display='none';">
                <div style="color: white; font-size: 1.5rem; font-weight: 700; text-align: center;">SoosanEgypt</div>
            </div>

            <div class="auth-card">
                {{ $slot }}
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Enhanced form interactions
                const inputs = document.querySelectorAll('.form-input');
                inputs.forEach(input => {
                    // Floating label effect
                    input.addEventListener('focus', function() {
                        this.style.transform = 'translateY(-2px)';
                        this.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.15)';
                    });
                    
                    input.addEventListener('blur', function() {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
                    });
                    
                    // Real-time validation feedback
                    input.addEventListener('input', function() {
                        if (this.value.trim() !== '') {
                            this.style.borderColor = 'var(--accent-color)';
                        } else {
                            this.style.borderColor = 'var(--border-color)';
                        }
                    });
                });
                
                // Enhanced button interactions
                const buttons = document.querySelectorAll('.auth-button');
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
                
                // Add ripple animation
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
                
                // Enhanced checkbox interactions
                const checkboxes = document.querySelectorAll('.checkbox-input');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        this.style.transform = 'scale(1.1)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                });
            });
        </script>
    </body>
</html>
