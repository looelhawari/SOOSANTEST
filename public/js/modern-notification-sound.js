// Modern WhatsApp-style notification sound
class ModernNotificationSound {
    constructor() {
        this.audioContext = null;
        this.isEnabled = localStorage.getItem('notification_sound_enabled') !== 'false';
        this.soundType = localStorage.getItem('notification_sound_type') || 'whatsapp';
        this.initAudioContext();
    }

    async initAudioContext() {
        try {
            this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
        } catch (e) {
            console.log('Web Audio API not supported');
        }
    }

    async resumeAudioContext() {
        if (this.audioContext && this.audioContext.state === 'suspended') {
            await this.audioContext.resume();
        }
    }

    createWhatsAppSound() {
        if (!this.audioContext) return;

        const createTone = (frequency, startTime, duration, volume = 0.25, type = 'sine') => {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();
            const filterNode = this.audioContext.createBiquadFilter();

            oscillator.connect(filterNode);
            filterNode.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            oscillator.frequency.setValueAtTime(frequency, startTime);
            oscillator.type = type;

            // Warm filter
            filterNode.type = 'lowpass';
            filterNode.frequency.setValueAtTime(4000, startTime);
            filterNode.Q.setValueAtTime(1, startTime);

            // Smooth envelope
            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.02);
            gainNode.gain.exponentialRampToValueAtTime(volume * 0.8, startTime + duration * 0.4);
            gainNode.gain.exponentialRampToValueAtTime(0.001, startTime + duration);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration);
        };

        const currentTime = this.audioContext.currentTime;

        // WhatsApp-style notification: gentle two-tone chime
        createTone(880, currentTime, 0.15, 0.22, 'sine');        // First tone (A5)
        createTone(659, currentTime + 0.08, 0.18, 0.20, 'sine'); // Second tone (E5)

        // Add subtle harmonics for richness
        createTone(1320, currentTime + 0.02, 0.08, 0.06, 'triangle'); // Third harmonic
        createTone(440, currentTime + 0.05, 0.1, 0.05, 'sine');       // Sub harmonic
    }

    createMessageSound() {
        if (!this.audioContext) return;

        const createTone = (frequency, startTime, duration, volume = 0.2) => {
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);

            oscillator.frequency.setValueAtTime(frequency, startTime);
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.001, startTime + duration);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration);
        };

        const currentTime = this.audioContext.currentTime;

        // Simple message notification
        createTone(700, currentTime, 0.2, 0.25);
    }

    async play(type = 'notification') {
        if (!this.isEnabled && type !== 'test') return;

        try {
            await this.resumeAudioContext();

            switch (type) {
                case 'whatsapp':
                case 'notification':
                    this.createWhatsAppSound();
                    break;
                case 'message':
                    this.createMessageSound();
                    break;
                case 'test':
                    this.createMessageSound();
                    break;
                default:
                    this.createWhatsAppSound();
            }

            console.log('🔊 Modern notification sound played:', type);

        } catch (e) {
            console.log('Could not play notification sound:', e);
            // Fallback to HTML5 audio
            this.playFallbackSound();
        }
    }

    playFallbackSound() {
        const audio = new Audio();
        audio.volume = 0.4;

        // Better quality fallback sound (WhatsApp-like beep)
        audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+HyvmwhBTeMy/DYgDsICGy+79uQQAxRp+PwtmMcBTiR1/LMeS0FJHfH8N2QQAoUXrTp66hVFApGnt/yu2whBTeMy/DYgDsICGy+79uQQAxRp+PwtmMcBTiR1/LMeS0FJHfH8N2QQAoUXrTp66hVFApGnt/yu2whBTeMy/DYgDsICGy+79uQQA==';

        audio.play().catch(e => console.log('Fallback sound failed:', e));
    }

    toggle() {
        this.isEnabled = !this.isEnabled;
        localStorage.setItem('notification_sound_enabled', this.isEnabled);

        // Play test sound if enabling
        if (this.isEnabled) {
            setTimeout(() => this.play('test'), 300);
        }

        return this.isEnabled;
    }

    setType(type) {
        this.soundType = type;
        localStorage.setItem('notification_sound_type', type);

        // Play test of new sound
        setTimeout(() => this.play(type), 200);
    }
}

// Initialize global sound manager
window.notificationSound = new ModernNotificationSound();

// Add sound control to the page
document.addEventListener('DOMContentLoaded', function () {
    // Add sound toggle button to navigation
    const soundToggle = document.createElement('div');
    soundToggle.className = 'sound-control';
    soundToggle.innerHTML = `
        <button class="btn btn-sm btn-outline-secondary sound-toggle-btn" 
                onclick="toggleNotificationSound()" 
                title="Toggle notification sounds">
            <i class="fas ${window.notificationSound.isEnabled ? 'fa-volume-up' : 'fa-volume-mute'}"></i>
        </button>
    `;

    // Add to navbar if it exists
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        const navbarNav = navbar.querySelector('.navbar-nav');
        if (navbarNav) {
            const soundLi = document.createElement('li');
            soundLi.className = 'nav-item';
            soundLi.appendChild(soundToggle);
            navbarNav.appendChild(soundLi);
        }
    }

    // Add sound control styles
    const style = document.createElement('style');
    style.textContent = `
        .sound-control {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        
        .sound-toggle-btn {
            border: none;
            background: transparent;
            color: #6c757d;
            transition: all 0.3s ease;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sound-toggle-btn:hover {
            background: rgba(108, 117, 125, 0.1);
            color: #495057;
            transform: scale(1.1);
        }
        
        .sound-toggle-btn.enabled {
            color: #28a745;
        }
        
        .sound-toggle-btn.disabled {
            color: #dc3545;
        }
        
        .sound-control-tooltip {
            position: fixed;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 9999;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sound-control-tooltip.show {
            opacity: 1;
        }
    `;
    document.head.appendChild(style);
});

// Global function to toggle sound
function toggleNotificationSound() {
    const isEnabled = window.notificationSound.toggle();
    const btn = document.querySelector('.sound-toggle-btn');

    if (btn) {
        const icon = btn.querySelector('i');
        if (isEnabled) {
            icon.className = 'fas fa-volume-up';
            btn.classList.add('enabled');
            btn.classList.remove('disabled');
            btn.title = 'Disable notification sounds';
        } else {
            icon.className = 'fas fa-volume-mute';
            btn.classList.add('disabled');
            btn.classList.remove('enabled');
            btn.title = 'Enable notification sounds';
        }
    }

    // Show feedback
    showSoundToggleFeedback(isEnabled);
}

// Show feedback when toggling sound
function showSoundToggleFeedback(isEnabled) {
    const feedback = document.createElement('div');
    feedback.className = 'sound-toggle-feedback';
    feedback.innerHTML = `
        <div class="alert alert-${isEnabled ? 'success' : 'warning'} alert-dismissible fade show" style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 250px;
            animation: slideInRight 0.3s ease;
        ">
            <i class="fas ${isEnabled ? 'fa-volume-up' : 'fa-volume-mute'} me-2"></i>
            <strong>Notification sounds ${isEnabled ? 'enabled' : 'disabled'}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    document.body.appendChild(feedback);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (document.body.contains(feedback)) {
            document.body.removeChild(feedback);
        }
    }, 3000);

    // Add animation styles if not already added
    if (!document.querySelector('#sound-toggle-animations')) {
        const style = document.createElement('style');
        style.id = 'sound-toggle-animations';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    }
}

// Update the NotificationManager to use the new sound system
if (typeof NotificationManager !== 'undefined') {
    // Override the playNotificationSound method
    NotificationManager.prototype.playNotificationSound = function (type = 'notification') {
        if (window.notificationSound) {
            window.notificationSound.play(type);
        }
    };
}
