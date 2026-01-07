/**
 * Custom Enhanced JavaScript
 * Apriori - Kimia Farma Application
 */

(function($) {
    "use strict";

    // ==================== INITIALIZATION ====================
    // Create toast container on page load
    $(document).ready(function() {
        if ($('#toast-container').length === 0) {
            $('body').append('<div id="toast-container"></div>');
        }
        
        // Add fade-in to page content
        $('body').addClass('loaded');
        
        // Focus first input in forms
        $('form:not(.no-autofocus) input:not([type="hidden"]):first').focus();
        
        // Initialize tooltips for buttons with title attribute
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
        
        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const $icon = $(this).find('i');
            const $input = $(this).closest('.input-group').find('input');
            
            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                $input.attr('type', 'password');
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });

    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Initialize popovers
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    // Smooth scrolling using jQuery easing
    $('a.scroll-to-top').click(function(e) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });

    // Add active class to current page
    var url = window.location.pathname;
    var activePage = url.substring(url.lastIndexOf('/') + 1);
    $('.nav-item a').each(function() {
        var href = $(this).attr('href');
        if (href && href.indexOf(activePage) !== -1) {
            $(this).closest('.nav-item').addClass('active');
        }
    });

    // Animate numbers on dashboard cards
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            element.innerHTML = Math.floor(progress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animate dashboard numbers
    $(window).on('load', function() {
        $('.h5.mb-0.font-weight-bold').each(function() {
            const $this = $(this);
            const countTo = parseInt($this.text());
            if (!isNaN(countTo)) {
                $this.text('0');
                animateValue(this, 0, countTo, 1500);
            }
        });
    });

    // ==================== TOAST NOTIFICATIONS ====================
    window.showToast = function(message, type = 'info', duration = 4000) {
        // Ensure container exists
        if ($('#toast-container').length === 0) {
            $('body').append('<div id="toast-container"></div>');
        }
        
        const iconMap = {
            'success': 'fa-check-circle',
            'error': 'fa-times-circle',
            'warning': 'fa-exclamation-triangle',
            'info': 'fa-info-circle'
        };
        
        const toast = $(`
            <div class="custom-toast toast-${type}">
                <i class="fas ${iconMap[type]} mr-2"></i>
                <span>${message}</span>
                <button class="toast-close">&times;</button>
            </div>
        `);
        
        $('#toast-container').append(toast);
        
        setTimeout(() => {
            toast.addClass('show');
        }, 10);
        
        setTimeout(() => {
            toast.removeClass('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
        
        toast.find('.toast-close').on('click', function() {
            toast.removeClass('show');
            setTimeout(() => toast.remove(), 300);
        });
    };

    // ==================== CONFIRMATION MODAL ====================
    window.showConfirmModal = function(options) {
        const defaults = {
            title: 'Confirmation',
            message: 'Are you sure you want to proceed?',
            confirmText: 'Yes',
            cancelText: 'Cancel',
            confirmClass: 'btn-danger',
            onConfirm: function() {},
            onCancel: function() {}
        };
        
        const settings = $.extend({}, defaults, options);
        
        const modal = $(`
            <div class="modal fade custom-confirm-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-circle mr-2"></i>${settings.title}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>${settings.message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                ${settings.cancelText}
                            </button>
                            <button type="button" class="btn ${settings.confirmClass} confirm-action">
                                ${settings.confirmText}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `);
        
        modal.find('.confirm-action').on('click', function() {
            settings.onConfirm();
            modal.modal('hide');
        });
        
        modal.on('hidden.bs.modal', function() {
            modal.remove();
        });
        
        $('body').append(modal);
        modal.modal('show');
    };

    // ==================== DELETE BUTTON HANDLER ====================
    // Use event delegation to handle dynamically loaded buttons
    $(document).on('click', '.btn-delete, .delete-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $btn = $(this);
        const href = $btn.attr('href');
        const message = $btn.data('confirm') || 'Are you sure you want to delete this item?';
        
        if (!href || href === '#' || href === '') {
            showToast('Invalid delete action', 'error');
            return false;
        }
        
        showConfirmModal({
            title: 'Delete Confirmation',
            message: message,
            confirmText: 'Yes, Delete',
            cancelText: 'Cancel',
            confirmClass: 'btn-danger',
            onConfirm: function() {
                // Show global loading overlay
                $('#loadingOverlayTitle').text('Deleting...');
                $('#loadingOverlayMessage').text('Please wait while we delete the item.');
                $('#globalLoadingOverlay').fadeIn(200);
                
                // Redirect to delete URL
                window.location.href = href;
            }
        });
        
        return false;
    });

    // ==================== CONVERT FLASH MESSAGES TO TOAST ====================
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert:not(.alert-permanent)').each(function() {
                const $alert = $(this);
                let type = 'info';
                
                if ($alert.hasClass('alert-success')) type = 'success';
                else if ($alert.hasClass('alert-danger')) type = 'error';
                else if ($alert.hasClass('alert-warning')) type = 'warning';
                
                const message = $alert.text().trim();
                if (message) {
                    showToast(message, type, 5000);
                }
                
                $alert.remove();
            });
        }, 300);
    });

    // ==================== REAL-TIME FORM VALIDATION ====================
    // Email validation
    $('input[type="email"]').on('input', function() {
        const $input = $(this);
        const email = $input.val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            $input.addClass('is-invalid');
            if (!$input.next('.invalid-feedback').length) {
                $input.after('<div class="invalid-feedback">Please enter a valid email address</div>');
            }
        } else {
            $input.removeClass('is-invalid');
            $input.next('.invalid-feedback').remove();
        }
    });

    // Password strength indicator (only for registration form)
    $('input[type="password"][name="password1"]').on('input', function() {
        const $input = $(this);
        const password = $input.val();
        const $wrapper = $input.closest('.col-sm-6').find('.password-strength-wrapper');
        
        if (password.length === 0) {
            $wrapper.html('');
            return;
        }
        
        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[@$!%*?&#]/.test(password)) strength++;
        
        const strengthText = ['Weak', 'Fair', 'Good', 'Strong'];
        const strengthClass = ['text-danger', 'text-warning', 'text-info', 'text-success'];
        const strengthIcon = ['fa-times-circle', 'fa-exclamation-circle', 'fa-check-circle', 'fa-check-circle'];
        
        $wrapper.html(`<small class="password-strength ${strengthClass[strength - 1] || 'text-danger'}">
            <i class="fas ${strengthIcon[strength - 1] || 'fa-times-circle'} mr-1"></i>
            Password strength: ${strengthText[strength - 1] || 'Weak'}
        </small>`);
    });

    // Password confirmation match
    $('input[type="password"][name="password2"]').on('input', function() {
        const $input = $(this);
        const password1 = $('input[name="password1"]').val();
        const password2 = $input.val();
        
        if (password2 && password1 !== password2) {
            $input.addClass('is-invalid').removeClass('is-valid');
            if (!$input.next('.invalid-feedback').length) {
                $input.after('<div class="invalid-feedback">Passwords do not match</div>');
            }
        } else if (password2) {
            $input.addClass('is-valid').removeClass('is-invalid');
            $input.next('.invalid-feedback').remove();
        }
    });

    // ==================== FORM VALIDATION & SUBMISSION ====================
    // Form validation feedback
    $('form:not(.no-validation)').on('submit', function(e) {
        var isValid = true;
        const $form = $(this);
        
        // Check required fields
        $form.find('[required]').each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        // Check email validity
        $form.find('input[type="email"]').each(function() {
            const email = $(this).val();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                $(this).addClass('is-invalid');
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showToast('Please fill all required fields correctly', 'error');
            return false;
        }
        
        // Show loading on valid submit (but don't prevent submission)
        const $submitBtn = $form.find('button[type="submit"]');
        if ($submitBtn.length && !$form.hasClass('no-loading')) {
            const originalHtml = $submitBtn.html();
            $submitBtn.data('original-html', originalHtml);
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
        }
        
        // Form will submit normally
        return true;
    });

    // Clear invalid state on input
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    // ==================== IMAGE PREVIEW ====================
    window.previewImage = function(input, targetId = 'imagePreview') {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const $preview = $('#' + targetId);
            
            reader.onload = function(e) {
                $preview.attr('src', e.target.result);
                $preview.removeClass('d-none');
                $preview.parent().find('.no-image-text').addClass('d-none');
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    };

    // Auto-attach image preview to file inputs with class 'image-input'
    $('.image-input').on('change', function() {
        const previewId = $(this).data('preview') || 'imagePreview';
        previewImage(this, previewId);
        
        // Show filename
        const fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // Add enter key submit for forms
    $('input').on('keypress', function(e) {
        if (e.which === 13 && !$(this).is('textarea')) {
            $(this).closest('form').submit();
        }
    });

    // Enhanced file input
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });

    // ==================== LOADING INDICATORS ====================
    // Add loading overlay function
    window.showLoader = function(message = 'Loading...') {
        if ($('.loader-overlay').length === 0) {
            $('body').append(`
                <div class="loader-overlay">
                    <div class="loader-spinner"></div>
                    <p class="loader-message">${message}</p>
                </div>
            `);
        }
    };

    window.hideLoader = function() {
        $('.loader-overlay').fadeOut('slow', function() {
            $(this).remove();
        });
    };

    // Print functionality
    $('.btn-print').on('click', function() {
        window.print();
    });

    // Export to Excel (if using DataTables)
    $('.btn-excel').on('click', function() {
        var table = $('.table').DataTable();
        table.button('.buttons-excel').trigger();
    });

    // Add fade-in animation to cards on scroll
    $(window).on('scroll', function() {
        $('.card').each(function() {
            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height();
            
            if (bottom_of_window > bottom_of_object) {
                $(this).animate({'opacity':'1'}, 500);
            }
        });
    });

    // Sidebar toggle enhancement
    $('#sidebarToggle, #sidebarToggleTop').on('click', function() {
        $('body').toggleClass('sidebar-toggled');
        $('.sidebar').toggleClass('toggled');
        if ($('.sidebar').hasClass('toggled')) {
            $('.sidebar .collapse').collapse('hide');
        }
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function() {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
        
        // Toggle the side navigation when window is resized below 480px
        if ($(window).width() < 480 && !$('.sidebar').hasClass('toggled')) {
            $('body').addClass('sidebar-toggled');
            $('.sidebar').addClass('toggled');
            $('.sidebar .collapse').collapse('hide');
        }
    });

    // Prevent dropdown from closing when clicking inside
    $('.dropdown-menu').on('click', function(e) {
        if ($(this).hasClass('keep-open')) {
            e.stopPropagation();
        }
    });

    // Add copy to clipboard functionality
    $('.copy-to-clipboard').on('click', function() {
        var text = $(this).data('copy');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
        
        showToast('Copied to clipboard!', 'success', 2000);
    });

    // Format currency inputs
    $('.currency-input').on('input', function() {
        var value = $(this).val().replace(/[^\d]/g, '');
        $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, ','));
    });

    // Lazy load images
    $('img[data-src]').each(function() {
        $(this).attr('src', $(this).data('src'));
    });

})(jQuery);

// Enhanced CSS Styles
$('head').append(`
<style>
/* ==================== LOADING OVERLAY ==================== */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    backdrop-filter: blur(5px);
}

.loader-spinner {
    width: 60px;
    height: 60px;
    border: 6px solid rgba(255, 255, 255, 0.2);
    border-top: 6px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loader-message {
    color: white;
    margin-top: 20px;
    font-size: 18px;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* ==================== TOAST NOTIFICATIONS ==================== */
#toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
}

.custom-toast {
    background: white;
    padding: 15px 20px;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    opacity: 0;
    transform: translateX(400px);
    transition: all 0.3s ease;
    border-left: 4px solid #667eea;
    min-width: 300px;
}

.custom-toast.show {
    opacity: 1;
    transform: translateX(0);
}

.custom-toast.toast-success {
    border-left-color: #28a745;
}

.custom-toast.toast-success i {
    color: #28a745;
}

.custom-toast.toast-error {
    border-left-color: #dc3545;
}

.custom-toast.toast-error i {
    color: #dc3545;
}

.custom-toast.toast-warning {
    border-left-color: #ffc107;
}

.custom-toast.toast-warning i {
    color: #ffc107;
}

.custom-toast.toast-info {
    border-left-color: #17a2b8;
}

.custom-toast.toast-info i {
    color: #17a2b8;
}

.custom-toast span {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

.custom-toast .toast-close {
    background: none;
    border: none;
    font-size: 20px;
    color: #999;
    cursor: pointer;
    padding: 0;
    margin-left: 10px;
    line-height: 1;
}

.custom-toast .toast-close:hover {
    color: #333;
}

/* ==================== CONFIRMATION MODAL ==================== */
.custom-confirm-modal .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.custom-confirm-modal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    border-bottom: none;
}

.custom-confirm-modal .modal-title {
    font-weight: 600;
    font-size: 18px;
}

.custom-confirm-modal .modal-header .close {
    color: white;
    opacity: 0.8;
    text-shadow: none;
}

.custom-confirm-modal .modal-header .close:hover {
    opacity: 1;
}

.custom-confirm-modal .modal-body p {
    font-size: 16px;
    margin: 0;
    color: #555;
}

.custom-confirm-modal .modal-footer {
    border-top: 1px solid #eee;
}

/* ==================== FORM VALIDATION STYLES ==================== */
.password-strength {
    display: block;
    margin-top: 5px;
    font-weight: 600;
    font-size: 12px;
}

.form-control.is-valid {
    border-color: #28a745;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

/* ==================== PAGE TRANSITION ==================== */
body {
    opacity: 0;
}

body.loaded {
    opacity: 1;
    transition: opacity 0.3s ease-in;
}

/* ==================== IMAGE PREVIEW ==================== */
.image-preview-container {
    position: relative;
    margin-bottom: 20px;
}

.image-preview-container img {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.image-preview-container img:hover {
    transform: scale(1.02);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    #toast-container {
        right: 10px;
        left: 10px;
        max-width: none;
    }
    
    .custom-toast {
        min-width: auto;
    }
}
</style>
`);
