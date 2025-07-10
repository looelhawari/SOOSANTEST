{{-- Language Toggle Component with Earth Icon --}}
<div class="language-toggle-container {{ $class ?? '' }}" style="{{ $style ?? '' }}">
    <div class="language-toggle {{ app()->isLocale('ar') ? 'active' : '' }}" 
         onclick="toggleLanguage()" 
         id="languageToggle"
         title="{{ __('auth.switch_language') }}">
        <div class="language-toggle-icon">
            <i class="fas fa-globe"></i>
        </div>
        <div class="language-toggle-slider">
            {{ app()->isLocale('ar') ? 'ع' : 'EN' }}
        </div>
        <div class="language-labels">
            <span class="lang-en">EN</span>
            <span class="lang-ar">ع</span>
        </div>
    </div>
</div>

{{-- Language Toggle JavaScript --}}
@push('scripts')
<script>
    // Language Toggle Function
    function toggleLanguage() {
        const toggle = document.getElementById('languageToggle');
        if (!toggle) return;
        
        const slider = toggle.querySelector('.language-toggle-slider');
        const currentLang = toggle.classList.contains('active') ? 'ar' : 'en';
        const newLang = currentLang === 'ar' ? 'en' : 'ar';
        
        // Add visual feedback
        toggle.style.transform = 'scale(0.95)';
        setTimeout(() => {
            toggle.style.transform = 'scale(1)';
        }, 150);
        
        // Update slider text with animation
        if (slider) {
            slider.style.opacity = '0.5';
            setTimeout(() => {
                slider.textContent = newLang === 'ar' ? 'ع' : 'EN';
                slider.style.opacity = '1';
            }, 150);
        }
        
        // Navigate to new language
        window.location.href = `{{ url('/lang') }}/${newLang}`;
    }
</script>
@endpush

{{-- Additional CSS for the enhanced language toggle --}}
@push('styles')
<style>
    .language-toggle-icon {
        position: absolute;
        left: 6px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        font-size: 14px;
        z-index: 1;
        transition: all 0.3s ease;
    }
    
    .language-toggle.active .language-toggle-icon {
        color: rgba(255, 255, 255, 0.9);
        left: 8px;
    }
    
    .language-toggle-slider {
        padding-left: 20px;
    }
    
    .language-toggle.active .language-toggle-slider {
        padding-left: 8px;
        padding-right: 20px;
    }
    
    /* Navbar specific styling */
    .navbar .language-toggle-container {
        margin-left: 1rem;
    }
    
    /* Dropdown specific styling */
    .dropdown-menu .language-toggle-container {
        margin: 0;
        padding: 0.5rem 1rem;
    }
    
    .dropdown-menu .language-toggle {
        width: 70px;
        height: 32px;
    }
    
    .dropdown-menu .language-toggle-slider {
        width: 26px;
        height: 26px;
        top: 2px;
        left: 2px;
        font-size: 9px;
        padding-left: 18px;
    }
    
    .dropdown-menu .language-toggle.active .language-toggle-slider {
        transform: translateX(36px);
        padding-left: 6px;
        padding-right: 18px;
    }
    
    .dropdown-menu .language-toggle-icon {
        font-size: 12px;
        left: 5px;
    }
    
    .dropdown-menu .language-toggle.active .language-toggle-icon {
        left: 6px;
    }
</style>
@endpush
