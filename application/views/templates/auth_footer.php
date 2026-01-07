<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Custom Enhanced Scripts -->
<script src="<?= base_url('assets/'); ?>js/custom-enhanced.js"></script>

<!-- Global Loading Overlay for Auth Pages -->
<div id="globalLoadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
        <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <h3 class="text-white mt-3" id="loadingOverlayTitle">Processing...</h3>
        <p class="text-white" id="loadingOverlayMessage">Please wait while we process your request.</p>
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