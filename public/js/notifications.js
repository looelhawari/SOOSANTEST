class NotificationManager {
    constructor() {
        this.notifications = [];
        this.unreadCount = 0;
        this.previousCount = 0;
        this.lastNotificationId = null;
        this.isPolling = false;
        this.pollingInterval = null;
        this.init();
    }

    init() {
        // First, ensure the DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.initializeNotifications();
            });
        } else {
            this.initializeNotifications();
        }
    }

    initializeNotifications() {
        // Get initial count from server-side rendered badge
        this.getInitialBadgeCount();
        this.loadNotifications();
        this.initializeRealTimePolling();
        this.bindEvents();
        console.log('Notification Manager initialized - Real-time notifications active');
        console.log('Current unread count:', this.unreadCount);
    }

    initializeRealTimePolling() {
        // Start with immediate check, then poll every 5 seconds for real-time updates
        this.checkForNewNotifications();
        this.startPolling();
    }

    startPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
        }

        // Poll every 5 seconds for real-time experience
        this.pollingInterval = setInterval(() => {
            this.checkForNewNotifications();
        }, 5000);

        this.isPolling = true;
        console.log('Real-time polling started (every 5 seconds)');
    }

    stopPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
        this.isPolling = false;
        console.log('Real-time polling stopped');
    }

    async checkForNewNotifications() {
        try {
            const response = await fetch('/api/notifications/check', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();

                // Update unread count in real-time
                if (data.unreadCount !== this.unreadCount) {
                    const previousCount = this.unreadCount;
                    this.unreadCount = data.unreadCount;
                    this.updateNotificationBadge();

                    // Animate badge if count increased
                    if (data.unreadCount > previousCount) {
                        this.animateBadge();
                    }

                    console.log(`Notification count updated: ${previousCount} -> ${data.unreadCount}`);
                }

                // Show toast for new notifications
                if (data.hasNew && data.latestNotification) {
                    this.showToast(data.latestNotification);
                    this.loadNotifications(); // Refresh the dropdown
                }

            } else {
                console.warn('Failed to check notifications:', response.status);
            }
        } catch (error) {
            console.error('Error checking for notifications:', error);
            // Retry after a short delay if there's an error
            setTimeout(() => {
                if (this.isPolling) {
                    this.checkForNewNotifications();
                }
            }, 10000);
        }
    }

    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.notifications = data.notifications;

                // Only update the count if we got a valid response
                if (typeof data.unreadCount === 'number') {
                    this.unreadCount = data.unreadCount;
                    this.updateNotificationBadge();
                }

                this.updateNotificationDropdown();
                console.log('Notifications loaded successfully:', data.unreadCount, 'unread');
            } else {
                console.warn('Failed to load notifications:', response.status);
            }
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    } updateNotificationBadge(count = null) {
        const badge = document.querySelector('.notification-badge');
        const actualCount = count !== null ? count : this.unreadCount;

        console.log('Updating notification badge:', actualCount, 'previous:', this.previousCount);

        if (badge) {
            // Update the text content
            badge.textContent = actualCount > 99 ? '99+' : actualCount;

            // Show or hide the badge based on count
            if (actualCount > 0) {
                // Show the badge
                badge.style.display = 'inline-block';
                badge.style.visibility = 'visible';
                badge.classList.add('badge-visible');
                badge.classList.remove('d-none');

                // Add pulsing effect for new notifications only if count increased
                if (actualCount > this.previousCount) {
                    badge.classList.add('badge-pulse');
                    setTimeout(() => {
                        badge.classList.remove('badge-pulse');
                    }, 1000);
                }
            } else {
                // Hide the badge
                badge.style.display = 'none';
                badge.style.visibility = 'hidden';
                badge.classList.remove('badge-visible', 'badge-pulse');
                badge.classList.add('d-none');
            }

            this.previousCount = actualCount;
        } else {
            console.warn('Notification badge element not found');
        }

        // Also update browser title with count
        this.updatePageTitle(actualCount);
    }

    updatePageTitle(count) {
        const originalTitle = document.title.replace(/^\(\d+\) /, '');
        if (count > 0) {
            document.title = `(${count}) ${originalTitle}`;
        } else {
            document.title = originalTitle;
        }
    }

    animateBadge() {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.classList.add('badge-new');
            setTimeout(() => {
                badge.classList.remove('badge-new');
            }, 2000);
        }
    } updateNotificationDropdown() {
        const dropdown = document.querySelector('.notification-dropdown-content');
        if (!dropdown) return;

        // Clear existing content first
        dropdown.innerHTML = '';

        // Add header
        const header = document.createElement('li');
        header.innerHTML = `<h6 class="dropdown-header">
            <i class="fas fa-bell me-2"></i>Notifications 
            ${this.unreadCount > 0 ? `<span class="badge bg-danger ms-2">${this.unreadCount}</span>` : ''}
        </h6>`;
        dropdown.appendChild(header);

        if (this.notifications.length === 0) {
            const noNotifications = document.createElement('li');
            noNotifications.innerHTML = `
                <div class="dropdown-item-text text-muted text-center py-3">
                    <i class="fas fa-bell-slash fa-2x mb-2 d-block"></i>
                    No notifications yet
                </div>
            `;
            dropdown.appendChild(noNotifications);
        } else {
            // Add notifications
            this.notifications.slice(0, 5).forEach((notification, index) => {
                const icon = notification.data.icon || 'fas fa-bell';
                const color = notification.data.color || 'primary';
                const timeAgo = this.timeAgo(new Date(notification.created_at));

                const notificationItem = document.createElement('li');
                notificationItem.innerHTML = `
                    <a class="dropdown-item py-2 notification-item ${!notification.read_at ? 'unread' : ''}" 
                       href="/notifications"
                       data-notification-id="${notification.id}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="${icon} text-${color}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-truncate">${notification.data.title}</div>
                                <div class="text-muted small text-truncate">${notification.data.message}</div>
                                <div class="text-muted small">${timeAgo}</div>
                            </div>
                            ${!notification.read_at ? '<div class="notification-dot"></div>' : ''}
                        </div>
                    </a>
                `;

                // Add animation for new notifications
                if (index === 0 && !notification.read_at) {
                    notificationItem.classList.add('notification-new');
                }

                dropdown.appendChild(notificationItem);
            });
        }

        // Add footer
        const footer = document.createElement('li');
        footer.innerHTML = `<hr class="dropdown-divider">`;
        dropdown.appendChild(footer);

        const viewAll = document.createElement('li');
        viewAll.innerHTML = `
            <a class="dropdown-item text-center fw-bold" href="/notifications">
                <i class="fas fa-list me-2"></i>View All Notifications
            </a>
        `;
        dropdown.appendChild(viewAll);

        // Add mark all as read if there are unread notifications
        if (this.unreadCount > 0) {
            const markAllRead = document.createElement('li');
            markAllRead.innerHTML = `
                <button class="dropdown-item text-center text-primary mark-all-read-btn">
                    <i class="fas fa-check-double me-2"></i>Mark All as Read
                </button>
            `;
            dropdown.appendChild(markAllRead);
        }
    }

    showToast(notification) {
        if (!notification) return;

        const toast = this.createToast(notification);
        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 5000);

        // Play notification sound
        this.playNotificationSound();
    }

    createToast(notification) {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.style.cursor = 'pointer';

        // Make the toast clickable
        toast.onclick = (e) => {
            if (e.target.classList.contains('btn-close')) return;

            // Mark as read and redirect
            this.markAsRead(notification.id);

            // Navigate to notification URL or default page
            if (notification.data.url) {
                window.location.href = notification.data.url;
            } else {
                window.location.href = '/notifications';
            }
        };

        toast.innerHTML = `
            <div class="toast-header">
                <i class="${notification.data.icon || 'fas fa-bell'} text-${notification.data.color || 'primary'}"></i>
                <strong class="me-auto ms-2">${notification.data.title}</strong>
                <small class="text-muted">Just now</small>
                <button type="button" class="btn-close" onclick="event.stopPropagation(); this.parentElement.parentElement.remove()"></button>
            </div>
            <div class="toast-body">
                <p class="mb-1">${notification.data.message}</p>
                ${notification.data.reason ? `<p class="text-danger small mb-0">${notification.data.reason}</p>` : ''}
                <small class="text-muted">Click to view details</small>
            </div>
        `;
        return toast;
    }

    // Sound settings and preferences
    initializeSoundSettings() {
        this.soundEnabled = localStorage.getItem('notification_sound_enabled') !== 'false';
        this.soundType = localStorage.getItem('notification_sound_type') || 'whatsapp';
    }

    toggleSound() {
        this.soundEnabled = !this.soundEnabled;
        localStorage.setItem('notification_sound_enabled', this.soundEnabled);

        // Show feedback
        this.showSuccessToast(
            this.soundEnabled ?
                'Notification sounds enabled 🔊' :
                'Notification sounds disabled 🔇'
        );

        // Play test sound if enabling
        if (this.soundEnabled) {
            setTimeout(() => this.playNotificationSound('test'), 500);
        }
    }

    // Multiple sound types like WhatsApp
    createWhatsAppSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();

        const createTone = (frequency, startTime, duration, volume = 0.25) => {
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.setValueAtTime(frequency, startTime);
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + duration);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration);
        };

        // WhatsApp-like notification: two gentle tones
        const currentTime = audioContext.currentTime;
        createTone(800, currentTime, 0.12, 0.2);      // First tone
        createTone(600, currentTime + 0.08, 0.15, 0.18); // Second tone (overlapping)
    }

    createDiscordSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();

        const createTone = (frequency, startTime, duration, volume = 0.2) => {
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.setValueAtTime(frequency, startTime);
            oscillator.type = 'triangle';

            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(volume, startTime + 0.02);
            gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + duration);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration);
        };

        // Discord-like notification: rising tone
        const currentTime = audioContext.currentTime;
        createTone(400, currentTime, 0.08, 0.15);
        createTone(600, currentTime + 0.06, 0.08, 0.18);
        createTone(800, currentTime + 0.12, 0.1, 0.15);
    }

    createSlackSound() {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();

        const createComplexTone = (frequencies, startTime, duration, volume = 0.15) => {
            frequencies.forEach((freq, index) => {
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();

                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);

                oscillator.frequency.setValueAtTime(freq, startTime);
                oscillator.type = 'sine';

                gainNode.gain.setValueAtTime(0, startTime);
                gainNode.gain.linearRampToValueAtTime(volume / frequencies.length, startTime + 0.01);
                gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + duration);

                oscillator.start(startTime);
                oscillator.stop(startTime + duration);
            });
        };

        // Slack-like notification: chord progression
        const currentTime = audioContext.currentTime;
        createComplexTone([523, 659, 784], currentTime, 0.15, 0.2); // C major chord
    }

    playNotificationSound(type = this.soundType) {
        if (!this.soundEnabled) return;

        // Modern WhatsApp-like notification sound using Web Audio API
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();

            // Play different sounds based on type
            switch (type) {
                case 'whatsapp':
                    this.createWhatsAppSound();
                    break;
                case 'discord':
                    this.createDiscordSound();
                    break;
                case 'slack':
                    this.createSlackSound();
                    break;
                default:
                    // Fallback to a simple beep if Web Audio API is not available
                    console.log('Unknown sound type, using fallback sound');

                    // Create a simple notification sound as fallback
                    const audio = document.createElement('audio');
                    audio.src = 'data:audio/wav;base64,UklGRj4CAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YRoCAACCiIWFbF1fdJivq5iMjI2JhpKDkpWMko2KkJ6QjpCPkY6QjoWQkZGOkZSRk46QkpKSkY6QkpKUkpGSkpKSko+QkpOTkpKTkpKSkZGRkpKSk5OSkZKSkpGSkpGRkpOTkpOTkpGSkpKSk5OSkZKSkpOTkpKSk5OSkpKSkpOTkpKTkpKSkpGRkpOTkpOTkpGSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKTkpKSkpKRkZKTk5OTkpKSkpKSk5OSkZKSkpOTkpKSkpKSkpOTkpKT
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
            });

            if (response.ok) {
                // Update local state immediately for better UX
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.updateNotificationBadge();
                this.loadNotifications(); // Refresh notifications
                console.log('Notification marked as read');
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch('/api/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                // Update local state immediately
                this.unreadCount = 0;
                this.updateNotificationBadge();
                this.loadNotifications(); // Refresh notifications
                console.log('All notifications marked as read');

                // Show success feedback
                this.showSuccessToast('All notifications marked as read');
            }
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }

    handleNotificationClick(e) {
        const notificationItem = e.target.closest('.notification-item');
        if (!notificationItem) return;

        // Add visual feedback
        notificationItem.classList.add('clicked');

        // If it's unread, mark as read
        if (notificationItem.classList.contains('unread')) {
            const notificationId = notificationItem.dataset.notificationId;
            if (notificationId) {
                this.markAsRead(notificationId);
            }
        }
    }

    // Debug and status methods
    getStatus() {
        return {
            isPolling: this.isPolling,
            unreadCount: this.unreadCount,
            notificationCount: this.notifications.length,
            pollingInterval: this.pollingInterval ? '5 seconds' : 'stopped',
            lastNotificationId: this.lastNotificationId
        };
    }

    logStatus() {
        console.log('Notification Manager Status:', this.getStatus());
    }

    // Force refresh notifications
    async forceRefresh() {
        console.log('Force refreshing notifications...');
        await this.loadNotifications();
        await this.checkForNewNotifications();
        this.logStatus();
    }

    getInitialBadgeCount() {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            // Try to get the initial count from data attribute first
            const initialCount = parseInt(badge.getAttribute('data-initial-count')) || 0;

            if (initialCount > 0) {
                this.unreadCount = initialCount;
                console.log('Initial notification count from server:', initialCount);
            } else {
                // Fallback: get from text content
                const currentText = badge.textContent.trim();
                const currentCount = currentText === '99+' ? 99 : parseInt(currentText) || 0;

                if (currentCount > 0) {
                    this.unreadCount = currentCount;
                    console.log('Initial notification count from badge text:', currentCount);
                }
            }

            // Ensure the badge is displayed correctly from the start
            this.updateNotificationBadge(this.unreadCount);
        }
    }
}

// Initialize notification manager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.notificationManager = new NotificationManager();
});

// Add CSS for notifications
const style = document.createElement('style');
style.textContent = `
    .notification-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        min-width: 300px;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    }

    .notification-toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification-toast .toast-header {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-top-left-radius: calc(0.375rem - 1px);
        border-top-right-radius: calc(0.375rem - 1px);
    }

    .notification-toast .toast-body {
        padding: 0.75rem;
    }

    .notification-item {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .notification-item:hover {
        background-color: rgba(0, 0, 0, 0.04);
    }

    .notification-item.unread {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .notification-item.clicked {
        animation: pulse 0.3s ease;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .notification-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
        min-width: 18px;
        text-align: center;
        line-height: 1;
    }
`;
document.head.appendChild(style);
