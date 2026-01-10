/**
 * Mobile Enhancement JavaScript
 * Touch Gestures, Responsive Behavior, Mobile Optimizations
 * Compatible: iOS Safari, Android Chrome, Desktop Browsers
 */

(function() {
    'use strict';

    // ==================== INFINITYFREE TRACKING PARAMETER HANDLER ====================
    // InfinityFree hosting adds ?i=X parameter on mobile browsers as a cookie bypass
    // This helper ensures the parameter is preserved across navigation
    const InfinityFreeHelper = {
        // Get the tracking parameter from current URL
        getTrackingParam: function() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('i');
        },

        // Add tracking parameter to a URL if it exists in current URL
        preserveTrackingParam: function(url) {
            const trackingParam = this.getTrackingParam();
            if (!trackingParam) return url;

            try {
                const urlObj = new URL(url, window.location.origin);
                // Only add if URL is same origin and doesn't already have the param
                if (urlObj.origin === window.location.origin && !urlObj.searchParams.has('i')) {
                    urlObj.searchParams.set('i', trackingParam);
                    return urlObj.toString();
                }
            } catch (e) {
                // If URL parsing fails, try string manipulation
                if (url.indexOf('http') !== 0 || url.indexOf(window.location.host) !== -1) {
                    const separator = url.indexOf('?') !== -1 ? '&' : '?';
                    if (url.indexOf('i=') === -1) {
                        return url + separator + 'i=' + trackingParam;
                    }
                }
            }
            return url;
        },

        // Initialize: update all links on page to preserve tracking param
        init: function() {
            const trackingParam = this.getTrackingParam();
            if (!trackingParam) return;

            // Update all internal links
            document.querySelectorAll('a[href]').forEach(function(link) {
                const href = link.getAttribute('href');
                if (!href) return;

                // Skip external links, anchors, javascript, and links that already have ?i=
                if (href.indexOf('#') === 0 ||
                    href.indexOf('javascript:') === 0 ||
                    href.indexOf('mailto:') === 0 ||
                    href.indexOf('tel:') === 0 ||
                    href.indexOf('i=') !== -1) {
                    return;
                }

                // Skip external domains
                if (href.indexOf('http') === 0 && href.indexOf(window.location.host) === -1) {
                    return;
                }

                link.setAttribute('href', InfinityFreeHelper.preserveTrackingParam(href));
            });

            // Update form actions
            document.querySelectorAll('form[action]').forEach(function(form) {
                const action = form.getAttribute('action');
                if (!action || action.indexOf('i=') !== -1) return;

                // Skip external domains
                if (action.indexOf('http') === 0 && action.indexOf(window.location.host) === -1) {
                    return;
                }

                form.setAttribute('action', InfinityFreeHelper.preserveTrackingParam(action));
            });

            console.log('[InfinityFree Helper] Tracking parameter preserved: i=' + trackingParam);
        }
    };

    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        InfinityFreeHelper.init();
    });

    // Make helper available globally for dynamic content
    window.InfinityFreeHelper = InfinityFreeHelper;

    // ==================== MOBILE DETECTION ====================
    const isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.iOS());
        },
        tablet: function() {
            return navigator.userAgent.match(/iPad|Android/i) && !navigator.userAgent.match(/Mobile/i);
        }
    };

    // ==================== PWA INSTALLATION ====================
    let deferredPrompt;
    const installButton = document.getElementById('pwa-install-btn');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        if (installButton) {
            installButton.style.display = 'block';
            
            installButton.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to the install prompt: ${outcome}`);
                    deferredPrompt = null;
                    installButton.style.display = 'none';
                }
            });
        }
    });

    // Check if app is already installed
    window.addEventListener('appinstalled', () => {
        console.log('PWA was installed');
        if (installButton) {
            installButton.style.display = 'none';
        }
    });

    // ==================== SERVICE WORKER REGISTRATION ====================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((registration) => {
                    console.log('ServiceWorker registered:', registration.scope);
                    
                    // Check for updates periodically
                    setInterval(() => {
                        registration.update();
                    }, 60000); // Check every minute
                })
                .catch((error) => {
                    console.log('ServiceWorker registration failed:', error);
                });
        });
    }

    // ==================== ONLINE/OFFLINE STATUS ====================
    function updateOnlineStatus() {
        const offlineIndicator = document.querySelector('.offline-indicator');
        
        if (!navigator.onLine) {
            if (offlineIndicator) {
                offlineIndicator.classList.add('show');
                offlineIndicator.innerHTML = '<i class="fas fa-wifi-slash mr-2"></i>You are offline. Some features may be limited.';
            }
        } else {
            if (offlineIndicator) {
                offlineIndicator.classList.remove('show');
            }
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    document.addEventListener('DOMContentLoaded', updateOnlineStatus);

    // ==================== TOUCH GESTURES ====================
    class TouchHandler {
        constructor() {
            this.touchStartX = 0;
            this.touchStartY = 0;
            this.touchEndX = 0;
            this.touchEndY = 0;
            this.minSwipeDistance = 50;
            
            this.init();
        }

        init() {
            if (!isMobile.any()) return;

            document.addEventListener('touchstart', (e) => {
                this.touchStartX = e.changedTouches[0].screenX;
                this.touchStartY = e.changedTouches[0].screenY;
            }, { passive: true });

            document.addEventListener('touchend', (e) => {
                this.touchEndX = e.changedTouches[0].screenX;
                this.touchEndY = e.changedTouches[0].screenY;
                this.handleGesture();
            }, { passive: true });
        }

        handleGesture() {
            const diffX = this.touchEndX - this.touchStartX;
            const diffY = this.touchEndY - this.touchStartY;

            // Swipe right to open sidebar
            if (diffX > this.minSwipeDistance && Math.abs(diffY) < 100) {
                this.openSidebar();
            }

            // Swipe left to close sidebar
            if (diffX < -this.minSwipeDistance && Math.abs(diffY) < 100) {
                this.closeSidebar();
            }
        }

        openSidebar() {
            const sidebar = document.getElementById('accordionSidebar');
            if (sidebar && window.innerWidth < 768) {
                sidebar.classList.remove('toggled');
            }
        }

        closeSidebar() {
            const sidebar = document.getElementById('accordionSidebar');
            if (sidebar && window.innerWidth < 768) {
                sidebar.classList.add('toggled');
            }
        }
    }

    // Initialize touch handler
    new TouchHandler();

    // ==================== RESPONSIVE TABLE ENHANCEMENT ====================
    function makeTablesResponsive() {
        const tables = document.querySelectorAll('table');
        
        tables.forEach((table) => {
            // Let DataTables responsive handle its own tables
            if (table.classList.contains('dataTable')) {
                table.classList.remove('table-mobile-card');
                return;
            }

            if (window.innerWidth < 768) {
                // Add data-label to each cell for mobile card view
                const headers = table.querySelectorAll('thead th');
                const rows = table.querySelectorAll('tbody tr');
                
                rows.forEach((row) => {
                    const cells = row.querySelectorAll('td');
                    cells.forEach((cell, index) => {
                        if (headers[index]) {
                            cell.setAttribute('data-label', headers[index].textContent);
                        }
                    });

                    // Mark the last cell as actions for styling
                    const lastCell = cells[cells.length - 1];
                    if (lastCell) {
                        lastCell.classList.add('mobile-actions');
                    }
                });
                
                table.classList.add('table-mobile-card');
            } else {
                table.classList.remove('table-mobile-card');
            }
        });
    }

    // Run on load and resize
    window.addEventListener('load', makeTablesResponsive);
    window.addEventListener('resize', debounce(makeTablesResponsive, 250));

    // ==================== VIEWPORT HEIGHT FIX (Mobile Browsers) ====================
    function setViewportHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }

    window.addEventListener('resize', debounce(setViewportHeight, 100));
    window.addEventListener('orientationchange', setViewportHeight);
    setViewportHeight();

    // ==================== PREVENT ZOOM ON DOUBLE TAP (iOS) ====================
    if (isMobile.iOS()) {
        let lastTouchEnd = 0;
        document.addEventListener('touchend', (event) => {
            const now = Date.now();
            if (now - lastTouchEnd <= 300) {
                event.preventDefault();
            }
            lastTouchEnd = now;
        }, false);
    }

    // ==================== OPTIMIZE SCROLLING ====================
    function optimizeScrolling() {
        const scrollableElements = document.querySelectorAll('.table-responsive, .modal-body, .card-body');
        
        scrollableElements.forEach((element) => {
            element.style.webkitOverflowScrolling = 'touch';
        });
    }

    document.addEventListener('DOMContentLoaded', optimizeScrolling);

    // ==================== PULL TO REFRESH ====================
    class PullToRefresh {
        constructor() {
            this.pStart = { x: 0, y: 0 };
            this.pCurrent = { x: 0, y: 0 };
            this.pulling = false;
            this.threshold = 80;
            this.indicator = null;
            
            this.init();
        }

        init() {
            if (!isMobile.any()) return;

            // Create pull indicator
            this.indicator = document.createElement('div');
            this.indicator.className = 'pull-to-refresh';
            this.indicator.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i>';
            document.body.prepend(this.indicator);

            window.addEventListener('touchstart', (e) => {
                if (window.scrollY === 0) {
                    this.pStart.x = e.touches[0].screenX;
                    this.pStart.y = e.touches[0].screenY;
                }
            }, { passive: true });

            window.addEventListener('touchmove', (e) => {
                if (window.scrollY === 0) {
                    this.pCurrent.x = e.touches[0].screenX;
                    this.pCurrent.y = e.touches[0].screenY;
                    
                    const diffY = this.pCurrent.y - this.pStart.y;
                    
                    if (diffY > 0 && diffY < this.threshold) {
                        this.pulling = true;
                        this.indicator.style.top = `${diffY - 60}px`;
                    }
                }
            }, { passive: true });

            window.addEventListener('touchend', () => {
                if (this.pulling) {
                    const diffY = this.pCurrent.y - this.pStart.y;
                    
                    if (diffY >= this.threshold) {
                        this.refresh();
                    }
                    
                    this.indicator.style.top = '-60px';
                    this.pulling = false;
                }
            }, { passive: true });
        }

        refresh() {
            // Show loading
            this.indicator.classList.add('active');
            
            // Reload page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
    }

    // Initialize pull to refresh on mobile
    if (isMobile.any()) {
        new PullToRefresh();
    }

    // ==================== SMART APP BANNER (iOS) ====================
    function addSmartBanner() {
        if (isMobile.iOS() && !window.navigator.standalone) {
            const banner = document.createElement('div');
            banner.className = 'ios-smart-banner';
            banner.innerHTML = `
                <div class="smart-banner-content">
                    <img src="/assets/img/icons/icon-96x96.png" alt="App Icon">
                    <div class="smart-banner-text">
                        <strong>Apriori - Kimia Farma</strong>
                        <p>Install app for better experience</p>
                    </div>
                    <button class="smart-banner-install">Install</button>
                    <button class="smart-banner-close">×</button>
                </div>
            `;
            
            document.body.prepend(banner);
            
            banner.querySelector('.smart-banner-close').addEventListener('click', () => {
                banner.remove();
                sessionStorage.setItem('smartBannerClosed', 'true');
            });
            
            if (sessionStorage.getItem('smartBannerClosed')) {
                banner.remove();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', addSmartBanner);

    // ==================== HAPTIC FEEDBACK ====================
    function vibrate(pattern) {
        if ('vibrate' in navigator && isMobile.any()) {
            navigator.vibrate(pattern);
        }
    }

    // Add vibration to buttons
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('.btn:not(.no-vibrate)');
        
        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                vibrate(10);
            });
        });
    });

    // ==================== LAZY LOADING IMAGES ====================
    function lazyLoadImages() {
        const images = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach((img) => imageObserver.observe(img));
    }

    if ('IntersectionObserver' in window) {
        document.addEventListener('DOMContentLoaded', lazyLoadImages);
    }

    // ==================== NETWORK INFORMATION API ====================
    function checkNetworkSpeed() {
        if ('connection' in navigator) {
            const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            
            if (connection) {
                const effectiveType = connection.effectiveType;
                
                // Reduce quality for slow connections
                if (effectiveType === 'slow-2g' || effectiveType === '2g') {
                    document.body.classList.add('slow-connection');
                    console.log('Slow connection detected, optimizing experience');
                }
                
                // Listen for changes
                connection.addEventListener('change', () => {
                    console.log('Connection type changed:', connection.effectiveType);
                });
            }
        }
    }

    checkNetworkSpeed();

    // ==================== ORIENTATION CHANGE HANDLER ====================
    function handleOrientationChange() {
        const orientation = window.orientation || screen.orientation?.angle;
        
        if (orientation === 90 || orientation === -90) {
            document.body.classList.add('landscape');
            document.body.classList.remove('portrait');
        } else {
            document.body.classList.add('portrait');
            document.body.classList.remove('landscape');
        }
    }

    window.addEventListener('orientationchange', handleOrientationChange);
    document.addEventListener('DOMContentLoaded', handleOrientationChange);

    // ==================== MOBILE SIDEBAR AUTO-CLOSE ====================
    function autoCloseSidebar() {
        if (window.innerWidth < 768) {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    const sidebar = document.getElementById('accordionSidebar');
                    if (sidebar) {
                        setTimeout(() => {
                            sidebar.classList.add('toggled');
                        }, 300);
                    }
                });
            });
        }
    }

    document.addEventListener('DOMContentLoaded', autoCloseSidebar);

    // ==================== PREVENT FORM RESUBMISSION ====================
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // ==================== UTILITY FUNCTIONS ====================
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ==================== EXPOSE UTILITIES ====================
    window.mobileUtils = {
        isMobile: isMobile,
        vibrate: vibrate,
        makeTablesResponsive: makeTablesResponsive,
        setViewportHeight: setViewportHeight
    };

    console.log('Mobile Enhancement loaded successfully');

})();
