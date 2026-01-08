/**
 * =====================================================
 * CONSISTENT LOADING INDICATOR SYSTEM
 * =====================================================
 * Handles all loading states across the application
 */

(function() {
    'use strict';

    // ==================== PAGE LOAD INDICATOR ====================
    // Hide page loading indicator when page is fully loaded
    window.addEventListener('load', function() {
        const pageLoader = document.getElementById('pageLoadingIndicator');
        if (pageLoader) {
            setTimeout(function() {
                pageLoader.classList.add('hidden');
                setTimeout(function() {
                    pageLoader.style.display = 'none';
                }, 500); // Wait for fade out animation
            }, 300); // Minimum display time
        }
    });

    // Fallback: Hide loader after 5 seconds if load event doesn't fire
    setTimeout(function() {
        const pageLoader = document.getElementById('pageLoadingIndicator');
        if (pageLoader && pageLoader.style.display !== 'none') {
            pageLoader.classList.add('hidden');
            setTimeout(function() {
                pageLoader.style.display = 'none';
            }, 500);
        }
    }, 5000);

    // ==================== GLOBAL LOADING OVERLAY ====================
    window.showLoading = function(title, message) {
        title = title || 'Processing...';
        message = message || 'Please wait while we process your request.';
        
        const overlay = document.getElementById('globalLoadingOverlay');
        const titleEl = document.getElementById('loadingOverlayTitle');
        const messageEl = document.getElementById('loadingOverlayMessage');
        
        if (overlay) {
            if (titleEl) titleEl.textContent = title;
            if (messageEl) messageEl.textContent = message;
            
            overlay.style.display = 'flex';
            setTimeout(function() {
                overlay.style.opacity = '1';
            }, 10);
        }
    };

    window.hideLoading = function() {
        const overlay = document.getElementById('globalLoadingOverlay');
        if (overlay) {
            overlay.style.opacity = '0';
            setTimeout(function() {
                overlay.style.display = 'none';
            }, 300);
        }
    };

    // ==================== FORM SUBMISSION LOADING ====================
    $(document).ready(function() {
        // Auto-attach loading to all forms (except those with no-loading class)
        $('form:not(.no-loading)').on('submit', function(e) {
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"], input[type="submit"]');

            // Don't show loading if form has validation errors
            if ($form.find('.is-invalid').length > 0) {
                return;
            }

            // Check if form is inside a modal
            const $modal = $form.closest('.modal');

            if ($modal.length > 0) {
                // Close modal first, then show loading
                $modal.modal('hide');
                $modal.on('hidden.bs.modal', function() {
                    // Show loading after modal closes
                    setTimeout(function() {
                        showFormLoading($form);
                    }, 200);
                });
            } else {
                // Show loading immediately for non-modal forms
                showFormLoading($form);
            }
        });

        // Helper function to show loading for forms
        function showFormLoading($form) {
            // Check if form has custom loading attributes
            const hasCustomLoading = $form.data('loading') === true;
            const customTitle = $form.data('loading-title');
            const customMessage = $form.data('loading-message');

            // Show loading indicator with custom or default text
            if (hasCustomLoading || customTitle || customMessage) {
                showLoading(
                    customTitle || 'Submitting...',
                    customMessage || 'Please wait while we process your request.'
                );
            } else {
                // Default loading for forms without custom attributes
                showLoading('Submitting...', 'Please wait while we process your request.');
            }
        }

        // ==================== AJAX LOADING ====================
        // Show loading on AJAX requests (but not if modal is open)
        $(document).on('ajaxStart', function() {
            // Don't show loading if a modal is currently open or if loading is already showing
            if ($('.modal.show').length === 0 && !$('.swal2-container').length && $('#globalLoadingOverlay').css('display') === 'none') {
                showLoading();
            }
        });

        $(document).on('ajaxStop', function() {
            hideLoading();
        });

        // ==================== DELETE BUTTON LOADING ====================
        $(document).on('click', '.btn-delete, .delete-btn, a[href*="delete"]', function(e) {
            const href = $(this).attr('href');
            if (href && href !== '#' && href.indexOf('delete') !== -1) {
                // Will be handled by confirm modal in custom-enhanced.js
                // Loading will show after confirmation
            }
        });

        // ==================== NAVIGATION LOADING ====================
        // Show loading on page navigation (links that cause page reload)
        $('a:not([target="_blank"]):not([href^="#"]):not(.no-loading)').on('click', function(e) {
            const href = $(this).attr('href');
            
            // Skip certain links
            if (!href || href === '#' || href === 'javascript:void(0)' || href === 'javascript:;') {
                return;
            }
            
            // Skip if it's a download link
            if ($(this).attr('download') !== undefined) {
                return;
            }
            
            // Skip if it opens modal
            if ($(this).attr('data-toggle') === 'modal') {
                return;
            }
            
            // Skip if any modal is currently open
            if ($('.modal.show').length > 0) {
                return;
            }
            
            // Show loading for navigation
            showLoading('Loading...', 'Please wait...');
        });

        // ==================== DATATABLE LOADING ====================
        // Override DataTables loading message
        if ($.fn.DataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    processing: '<div style="text-align: center;"><i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i><br><span class="text-primary font-weight-bold">Loading data...</span></div>'
                }
            });
        }
    });

    // ==================== EXPORT FUNCTIONS ====================
    window.loadingIndicator = {
        show: showLoading,
        hide: hideLoading,
        showPageLoader: function() {
            const pageLoader = document.getElementById('pageLoadingIndicator');
            if (pageLoader) {
                pageLoader.style.display = 'flex';
                pageLoader.classList.remove('hidden');
            }
        },
        hidePageLoader: function() {
            const pageLoader = document.getElementById('pageLoadingIndicator');
            if (pageLoader) {
                pageLoader.classList.add('hidden');
                setTimeout(function() {
                    pageLoader.style.display = 'none';
                }, 500);
            }
        }
    };

})();
