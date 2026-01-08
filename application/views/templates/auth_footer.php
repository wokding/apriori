<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Toastr for Toast Notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom Enhanced Scripts -->
<script src="<?= base_url('assets/'); ?>js/custom-enhanced.js"></script>

<!-- Loading Indicator Script -->
<script src="<?= base_url('assets/'); ?>js/loading-indicator.js"></script>

<!-- Toast Flashdata Handler for Auth Pages -->
<?php 
// Get flashdata ONCE - this consumes it from session
$success_msg = $this->session->flashdata('success');
$error_msg = $this->session->flashdata('error');

// Create hash of message to track if already displayed
$message_hash = md5($success_msg . $error_msg);
$consumed_key = 'toast_consumed_' . $message_hash;

// Check if this message was already consumed (displayed)
$already_consumed = $this->session->userdata($consumed_key);

// Only output script if there's a message AND it hasn't been consumed yet
if (($success_msg || $error_msg) && !$already_consumed) :
    // Mark this message as consumed so it won't show again
    $this->session->set_userdata($consumed_key, time());
    
    // Clean up old consumed markers (older than 5 minutes)
    $all_userdata = $this->session->userdata();
    foreach ($all_userdata as $key => $value) {
        if (strpos($key, 'toast_consumed_') === 0 && is_numeric($value) && (time() - $value) > 300) {
            $this->session->unset_userdata($key);
        }
    }
?>
<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof toastr === 'undefined') return;
        
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        <?php if ($success_msg) : ?>
        toastr.success(<?= json_encode($success_msg); ?>);
        <?php endif; ?>

        <?php if ($error_msg) : ?>
        toastr.error(<?= json_encode($error_msg); ?>);
        <?php endif; ?>
    });
})();
</script>
<?php endif; ?>

<!-- Global Loading Overlay for Auth Pages -->
<div id="globalLoadingOverlay" class="global-loading-overlay" style="display: none;">
    <div class="loading-content">
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <h3 id="loadingOverlayTitle">Processing...</h3>
        <p id="loadingOverlayMessage">Please wait while we process your request.</p>
    </div>
</div>

<!-- Enhanced Form Scripts -->
<script>
    $(document).ready(function() {
        // Global form submit handler with loading
        $('form[data-loading="true"]').on('submit', function(e) {
            const form = $(this);
            const loadingTitle = form.data('loading-title') || 'Processing...';
            const loadingMessage = form.data('loading-message') || 'Please wait while we process your request.';
            
            // Update loading overlay text
            $('#loadingOverlayTitle').text(loadingTitle);
            $('#loadingOverlayMessage').text(loadingMessage);
            
            // Show loading overlay
            $('#globalLoadingOverlay').fadeIn(300);
            
            // Disable all submit buttons in the form
            form.find('button[type="submit"], input[type="submit"]').prop('disabled', true);
            
            // Allow form to continue submitting
            return true;
        });
        
        // Global navigation loading - Show loading on link clicks
        $('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"]):not([data-toggle]):not(.no-loading)').on('click', function(e) {
            const href = $(this).attr('href');
            
            // Skip if no href or empty href
            if (!href || href === '' || href === '#') {
                return true;
            }
            
            // Skip external links
            if (href.indexOf('http') === 0 && href.indexOf(window.location.host) === -1) {
                return true;
            }
            
            // Show loading overlay
            $('#loadingOverlayTitle').text('Loading...');
            $('#loadingOverlayMessage').text('Please wait while we load the page.');
            $('#globalLoadingOverlay').fadeIn(200);
        });
        
        // Hide loading on page show (for back button)
        $(window).on('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                $('#globalLoadingOverlay').fadeOut(200);
            }
        });
        
        // Password visibility toggle
        if ($('#password').length) {
            const togglePassword = $('<span class="password-toggle" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"><i class="fas fa-eye"></i></span>');
            $('#password').parent().css('position', 'relative').append(togglePassword);
            
            togglePassword.on('click', function() {
                const passwordField = $('#password');
                const icon = $(this).find('i');
                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        }
    });
</script>

</body>

</html>