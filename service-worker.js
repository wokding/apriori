/**
 * Service Worker for PWA Support
 * Apriori - Kimia Farma Application
 * Provides offline capability and caching
 */

const CACHE_NAME = 'apriori-kf-v1.0.2';
const RUNTIME_CACHE = 'apriori-runtime-v1.0.2';

// Assets to cache on install
const PRECACHE_ASSETS = [
    '/',
    '/assets/css/sb-admin-2.min.css',
    '/assets/css/custom-style.css',
    '/assets/css/mobile-responsive.css',
    '/assets/js/sb-admin-2.min.js',
    '/assets/js/custom-enhanced.js',
    '/assets/js/mobile-enhancement.js',
    '/assets/vendor/jquery/jquery.min.js',
    '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
    '/assets/vendor/fontawesome-free/css/all.min.css',
    '/assets/img/kimiafarma.png',
    '/offline.html'
];

// Install event - cache assets
self.addEventListener('install', (event) => {
    console.log('[Service Worker] Installing...');
    
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[Service Worker] Precaching assets');
                // Use addAll with error handling to skip missing files
                return cache.addAll(PRECACHE_ASSETS)
                    .catch((error) => {
                        console.warn('[Service Worker] Some assets failed to cache:', error);
                        // Continue even if some assets fail to cache
                        return Promise.resolve();
                    });
            })
            .then(() => self.skipWaiting())
    );
});

// Activate event - cleanup old caches
self.addEventListener('activate', (event) => {
    console.log('[Service Worker] Activating...');
    
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((cacheName) => {
                        return cacheName !== CACHE_NAME && cacheName !== RUNTIME_CACHE;
                    })
                    .map((cacheName) => {
                        console.log('[Service Worker] Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    })
            );
        }).then(() => self.clients.claim())
    );
});

// Helper function to normalize URL by removing InfinityFree tracking parameters (?i=X)
function normalizeUrl(url) {
    const normalized = new URL(url);
    // Remove InfinityFree tracking parameter (used on mobile browsers as cookie bypass)
    normalized.searchParams.delete('i');
    return normalized;
}

// Helper function to create a normalized request for cache matching
function createNormalizedRequest(request) {
    const normalizedUrl = normalizeUrl(request.url);
    return new Request(normalizedUrl.toString(), {
        method: request.method,
        headers: request.headers,
        mode: request.mode,
        credentials: request.credentials,
        redirect: request.redirect
    });
}

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip cross-origin requests
    if (url.origin !== location.origin) {
        return;
    }

    // Skip POST, PUT, DELETE requests
    if (request.method !== 'GET') {
        return;
    }

    // Skip requests with InfinityFree tracking parameter for dynamic pages
    // This ensures the ?i=X parameter is preserved for session tracking on mobile
    if (url.searchParams.has('i') && (
        url.pathname.includes('/auth') || 
        url.pathname.includes('/admin') ||
        url.pathname.includes('/user') ||
        url.pathname === '/' ||
        url.pathname === ''
    )) {
        // Let these requests pass through to the network directly
        // Don't cache or intercept - InfinityFree needs the ?i parameter for session
        return;
    }

    // Skip logout requests to avoid redirect issues
    if (url.pathname.includes('/auth/logout')) {
        return;
    }

    // Skip delete/hapus requests to avoid redirect issues
    if (url.pathname.includes('/hapus') || url.pathname.includes('/delete')) {
        return;
    }

    // Skip root URL to avoid redirect issues
    if (url.pathname === '/' || url.pathname === '') {
        return;
    }

    // Skip requests that are not for navigation or document
    if (request.destination !== 'document' && request.destination !== 'empty') {
        return;
    }

    // Network First for API calls
    if (url.pathname.includes('/api/') || url.pathname.includes('/admin/')) {
        event.respondWith(networkFirst(request));
        return;
    }

    // Cache First for static assets
    if (url.pathname.match(/\.(js|css|png|jpg|jpeg|svg|gif|woff|woff2|ttf|eot)$/)) {
        event.respondWith(cacheFirst(request));
        return;
    }

    // Stale While Revalidate for HTML pages
    event.respondWith(staleWhileRevalidate(request));
});

// Cache First Strategy
async function cacheFirst(request) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }

    try {
        const networkResponse = await fetch(request, { redirect: 'follow' });
        if (networkResponse.ok) {
            const cache = await caches.open(RUNTIME_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.log('[Service Worker] Fetch failed:', error);
        return caches.match('/offline.html');
    }
}

// Network First Strategy
async function networkFirst(request) {
    try {
        const networkResponse = await fetch(request, { redirect: 'follow' });
        if (networkResponse.ok) {
            const cache = await caches.open(RUNTIME_CACHE);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        return caches.match('/offline.html');
    }
}

// Stale While Revalidate Strategy
async function staleWhileRevalidate(request) {
    const cachedResponse = await caches.match(request);

    const fetchPromise = fetch(request, { redirect: 'follow' }).then((networkResponse) => {
        if (networkResponse.ok) {
            const cache = caches.open(RUNTIME_CACHE);
            cache.then((c) => c.put(request, networkResponse.clone()));
        }
        return networkResponse;
    }).catch(() => {
        return caches.match('/offline.html');
    });

    return cachedResponse || fetchPromise;
}

// Background Sync for offline actions
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-data') {
        event.waitUntil(syncData());
    }
});

async function syncData() {
    console.log('[Service Worker] Syncing data...');
    // Implementation for syncing offline data
}

// Push Notification Support
self.addEventListener('push', (event) => {
    const options = {
        body: event.data ? event.data.text() : 'New notification',
        icon: '/assets/img/icons/icon-192x192.png',
        badge: '/assets/img/icons/icon-96x96.png',
        vibrate: [200, 100, 200],
        tag: 'apriori-notification',
        requireInteraction: false,
        actions: [
            {
                action: 'view',
                title: 'View',
                icon: '/assets/img/icons/icon-96x96.png'
            },
            {
                action: 'close',
                title: 'Close',
                icon: '/assets/img/icons/icon-96x96.png'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('Apriori - Kimia Farma', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    if (event.action === 'view') {
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Message handler for communication with clients
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data && event.data.type === 'CACHE_URLS') {
        const urlsToCache = event.data.urls;
        event.waitUntil(
            caches.open(RUNTIME_CACHE).then((cache) => {
                return cache.addAll(urlsToCache);
            })
        );
    }
});

// Periodic Background Sync (experimental)
self.addEventListener('periodicsync', (event) => {
    if (event.tag === 'update-data') {
        event.waitUntil(updateData());
    }
});

async function updateData() {
    console.log('[Service Worker] Periodic sync: updating data...');
    // Implementation for periodic data updates
}

console.log('[Service Worker] Loaded successfully');
