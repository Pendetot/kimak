<!-- [ Header Topbar ] start -->
<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item d-inline-flex d-md-none">
                    <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-magnifying-glass"></i>
                    </a>
                    <div class="dropdown-menu pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="mb-0 d-flex align-items-center">
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search..." />
                                <button class="btn btn-light-secondary btn-search">Search</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="pc-h-item d-none d-md-inline-flex">
                    <form class="form-search">
                        <i class="ph-duotone ph-magnifying-glass icon-search"></i>
                        <input type="search" class="form-control" placeholder="Search..." />
                        <button class="btn btn-search" style="padding: 0"><kbd>ctrl+k</kbd></button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item d-none d-md-inline-flex">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-circles-four"></i>
                    </a>
                    <div class="dropdown-menu dropdown-qta dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h5 class="m-0">Quick Access</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="row g-0">
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-calendar-blank"></i>
                                        <span>Calendar</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-shopping-cart"></i>
                                        <span>Cart</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-headphones"></i>
                                        <span>Support</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-user"></i>
                                        <span>Account</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-currency-circle-dollar"></i>
                                        <span>Plans</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#!" class="dropdown-item text-center">
                                        <i class="ph-duotone ph-user-circle"></i>
                                        <span>Users</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item d-none d-md-inline-flex">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                            <i class="ph-duotone ph-cpu"></i>
                            <span>Default</span>
                        </a>
                    </div>
                </li>
                <li class="dropdown pc-h-item d-none d-md-inline-flex">
                    <a class="pc-head-link head-link-primary dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-translate"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown lng-dropdown">
                        <a href="#!" class="dropdown-item" data-lng="en">
                            <span>
                                English
                                <small>(UK)</small>
                            </span>
                        </a>
                        <a href="#!" class="dropdown-item" data-lng="fr">
                            <span>
                                français
                                <small>(French)</small>
                            </span>
                        </a>
                        <a href="#!" class="dropdown-item" data-lng="ro">
                            <span>
                                Română
                                <small>(Romanian)</small>
                            </span>
                        </a>
                        <a href="#!" class="dropdown-item" data-lng="cn">
                            <span>
                                中国人
                                <small>(Chinese)</small>
                            </span>
                        </a>
                    </div>
                </li>
                <li class="pc-h-item">
                    <a class="pc-head-link pct-c-btn" href="#" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvas_pc_layout">
                        <i class="ph-duotone ph-gear-six"></i>
                    </a>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-diamonds-four"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item">
                            <i class="ph-duotone ph-user"></i>
                            <span>My Account</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ph-duotone ph-gear"></i>
                            <span>Settings</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ph-duotone ph-lifebuoy"></i>
                            <span>Support</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ph-duotone ph-lock-key"></i>
                            <span>Lock Screen</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ph-duotone ph-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false" id="notificationDropdown">
                        <i class="ph-duotone ph-bell"></i>
                        <span class="badge bg-success pc-h-badge" id="notificationBadge" style="display: none;">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Notifikasi</h5>
                            <ul class="list-inline ms-auto mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="btn btn-sm btn-light-primary" onclick="markAllAsRead()">
                                        <i class="ph-duotone ph-checks f-14"></i> Tandai Semua
                                    </button>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route('notifications.index') }}" class="avtar avtar-s btn-link-hover-primary">
                                        <i class="ph-duotone ph-arrow-square-out f-16"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                            style="max-height: calc(100vh - 235px)">
                            <div id="notificationLoader" class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush" id="notificationList">
                                <!-- Notifications will be loaded here via JavaScript -->
                            </ul>
                            <div id="noNotifications" class="text-center py-4" style="display: none;">
                                <i class="ph-duotone ph-bell-slash f-48 text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada notifikasi</p>
                                <small class="text-muted">Notifikasi akan muncul di sini</small>
                            </div>
                        </div>
                        <div class="dropdown-footer" id="notificationFooter" style="display: none;">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">
                                            <i class="ph-duotone ph-arrow-square-out me-1"></i>Lihat Semua Notifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                        @if(Auth::guard('karyawan')->check())
                            <img src="{{ Auth::guard('karyawan')->user()->getPhotoUrl() }}" alt="user-image"
                                class="user-avtar">
                        @else
                            <img src="{{ asset('images/default_avatar.png') }}" alt="user-image"
                                class="user-avtar">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header d-flex align-items-center justify-content-between">
                            <h5 class="m-0">Profile</h5>
                        </div>
                        <div class="dropdown-body">
                            <div class="profile-notification-scroll position-relative"
                                style="max-height: calc(100vh - 225px)">
                                <ul class="list-group list-group-flush w-100">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                @if(Auth::guard('karyawan')->check())
                                                    <img src="{{ Auth::guard('karyawan')->user()->getPhotoUrl() }}"
                                                        alt="user-image" class="wid-50 rounded-circle" />
                                                @else
                                                    <img src="{{ asset('images/default_avatar.png') }}"
                                                        alt="user-image" class="wid-50 rounded-circle" />
                                                @endif
                                            </div>
                                            <div class="flex-grow-1 mx-3">
                                                @if(Auth::guard('karyawan')->check())
                                                    <h5 class="mb-0">{{ Auth::guard('karyawan')->user()->display_name }}</h5>
                                                    <a class="link-primary"
                                                        href="mailto:{{ Auth::guard('karyawan')->user()->email }}">{{ Auth::guard('karyawan')->user()->email }}</a>
                                                @else
                                                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                                    <a class="link-primary"
                                                        href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @if(Auth::guard('karyawan')->check())
                                        <li class="list-group-item">
                                            <a href="{{ route('karyawan.profile.show') }}" class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph-duotone ph-user-circle"></i>
                                                    <span>View Profile</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="{{ route('karyawan.change-password') }}" class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph-duotone ph-lock"></i>
                                                    <span>Change Password</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="list-group-item">
                                        @if(Auth::guard('karyawan')->check())
                                            <a href="{{ route('karyawan.logout') }}"
                                                onclick="event.preventDefault();
                                                          document.getElementById('karyawan-logout-form').submit();"
                                                class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph-duotone ph-power"></i>
                                                    <span>Logout</span>
                                                </span>
                                            </a>
                                            <form id="karyawan-logout-form" action="{{ route('karyawan.logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        @else
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();"
                                                class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph-duotone ph-power"></i>
                                                    <span>Logout</span>
                                                </span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- [ Header Topbar ] end -->

<script>
// Notification System JavaScript
let lastNotificationId = null;
let notificationPollingInterval = null;

// Load notifications when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    startNotificationPolling();
});

// Load notifications from server
function loadNotifications() {
    fetch('/api/notifications/topbar')
        .then(response => response.json())
        .then(data => {
            updateNotificationUI(data);
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notificationLoader').style.display = 'none';
        });
}

// Update notification UI
function updateNotificationUI(data) {
    const loader = document.getElementById('notificationLoader');
    const notificationList = document.getElementById('notificationList');
    const notificationBadge = document.getElementById('notificationBadge');
    const noNotifications = document.getElementById('noNotifications');
    const notificationFooter = document.getElementById('notificationFooter');

    // Hide loader
    loader.style.display = 'none';

    // Update badge
    if (data.unread_count > 0) {
        notificationBadge.textContent = data.unread_count;
        notificationBadge.style.display = 'block';
    } else {
        notificationBadge.style.display = 'none';
    }

    // Clear existing notifications
    notificationList.innerHTML = '';

    if (data.has_notifications) {
        noNotifications.style.display = 'none';
        notificationFooter.style.display = 'block';

        // Group notifications by date
        const today = new Date().toDateString();
        const yesterday = new Date(Date.now() - 86400000).toDateString();
        
        let currentDate = null;
        
        data.notifications.forEach(notification => {
            const notificationDate = new Date(notification.created_at).toDateString();
            
            // Add date separator
            if (currentDate !== notificationDate) {
                currentDate = notificationDate;
                let dateLabel = 'Hari lain';
                
                if (notificationDate === today) {
                    dateLabel = 'Hari ini';
                } else if (notificationDate === yesterday) {
                    dateLabel = 'Kemarin';
                }
                
                const dateItem = document.createElement('li');
                dateItem.className = 'list-group-item border-0 p-2';
                dateItem.innerHTML = `<p class="text-span mb-0">${dateLabel}</p>`;
                notificationList.appendChild(dateItem);
            }
            
            // Create notification item
            const notificationItem = createNotificationItem(notification);
            notificationList.appendChild(notificationItem);
        });

        // Store last notification ID for polling
        if (data.notifications.length > 0) {
            lastNotificationId = data.notifications[0].id;
        }
    } else {
        noNotifications.style.display = 'block';
        notificationFooter.style.display = 'none';
    }
}

// Create notification item HTML
function createNotificationItem(notification) {
    const li = document.createElement('li');
    li.className = `list-group-item ${notification.is_read ? '' : 'bg-light-primary bg-opacity-10'}`;
    li.style.cursor = 'pointer';
    
    li.innerHTML = `
        <div class="d-flex" onclick="handleNotificationClick(${notification.id}, '${notification.action_url}')">
            <div class="flex-shrink-0">
                <div class="avtar avtar-s bg-light-primary">
                    <i class="${notification.icon} f-18 ${notification.color}"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <div class="d-flex">
                    <div class="flex-grow-1 me-3 position-relative">
                        <h6 class="mb-0 text-truncate">${notification.title}</h6>
                        ${!notification.is_read ? '<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 8px; height: 8px;"></span>' : ''}
                    </div>
                    <div class="flex-shrink-0">
                        <span class="text-sm">${notification.time_ago}</span>
                    </div>
                </div>
                <p class="position-relative mt-1 mb-0 text-truncate">${notification.message}</p>
            </div>
        </div>
    `;
    
    return li;
}

// Handle notification click
function handleNotificationClick(notificationId, actionUrl) {
    // Mark as read
    fetch(`/api/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    }).then(() => {
        // Reload notifications to update UI
        loadNotifications();
        
        // Navigate to action URL if provided
        if (actionUrl && actionUrl !== 'null') {
            window.location.href = actionUrl;
        }
    });
}

// Mark all notifications as read
function markAllAsRead() {
    fetch('/api/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    }).then(() => {
        loadNotifications();
    });
}

// Start polling for new notifications
function startNotificationPolling() {
    notificationPollingInterval = setInterval(() => {
        if (lastNotificationId) {
            fetch(`/api/notifications/check-new/${lastNotificationId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.has_new) {
                        loadNotifications();
                    } else {
                        // Just update the badge count
                        const notificationBadge = document.getElementById('notificationBadge');
                        if (data.unread_count > 0) {
                            notificationBadge.textContent = data.unread_count;
                            notificationBadge.style.display = 'block';
                        } else {
                            notificationBadge.style.display = 'none';
                        }
                    }
                });
        }
    }, 30000); // Poll every 30 seconds
}

// Stop polling when page unloads
window.addEventListener('beforeunload', function() {
    if (notificationPollingInterval) {
        clearInterval(notificationPollingInterval);
    }
});
</script>
