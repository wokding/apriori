<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>
                <i class="fas fa-copyright mr-1"></i>Copyright <?= date('Y'); ?> 
                <strong>Kimia Farma Apotek</strong> - All Rights Reserved
            </span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Global Loading Overlay -->
<div id="globalLoadingOverlay" class="global-loading-overlay" style="display: none;">
    <div class="loading-overlay-content">
        <div class="loading-spinner-wrapper">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="loading-logo">
                <i class="fas fa-capsules"></i>
            </div>
        </div>
        <h3 class="loading-title" id="loadingOverlayTitle">Processing...</h3>
        <p class="loading-message" id="loadingOverlayMessage">Please wait while we process your request.</p>
        <div class="loading-bar">
            <div class="loading-bar-fill"></div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-sign-out-alt mr-2"></i>Ready to Leave?
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Select "Logout" below if you are ready to end your current session.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <a class="btn btn-primary" href="<?= site_url('auth/logout'); ?>">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Toastr for Toast Notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" onerror="console.warn('Toastr failed to load')"></script>

<!-- SweetAlert2 for Modal Confirmations -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" onerror="console.warn('SweetAlert2 failed to load')"></script>

<!-- Custom Enhanced Scripts -->
<script src="<?= base_url('assets/'); ?>js/custom-enhanced.js"></script>

<!-- Loading Indicator Script -->
<script src="<?= base_url('assets/'); ?>js/loading-indicator.js"></script>

<!-- Mobile Enhancement Scripts -->
<script src="<?= base_url('assets/'); ?>js/mobile-enhancement.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js" onerror="console.warn('DataTables responsive failed to load')"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js" onerror="console.warn('DataTables responsive bootstrap failed to load')"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<!-- Date Picker Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" onerror="console.warn('Moment.js failed to load')"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" onerror="console.warn('DateRangePicker failed to load')"></script>
<script src="<?= base_url('assets/'); ?>daterange/daterange.js" onerror="console.warn('Custom daterange.js failed to load')"></script>
<script src="<?= base_url('assets/'); ?>bootstrap-datepicker-1.9.0/dist/js/bootstrap-datepicker.min.js" onerror="console.warn('Bootstrap Datepicker failed to load')"></script>

<script>
    $(document).ready(function() {
        // Datepicker initialization
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: 'bottom auto'
        });

        // Custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });

        // Role access toggle
        $('.form-check-input').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('admin/changeAccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    setTimeout(function() {
                        var redirectUrl = "<?= base_url('admin/roleAccess/'); ?>" + roleId;
                        if (typeof window.InfinityFreeHelper !== 'undefined') {
                            redirectUrl = window.InfinityFreeHelper.preserveTrackingParam(redirectUrl);
                        }
                        document.location.href = redirectUrl;
                    }, 500);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Failed to update access. Please try again.');
                }
            });
        });

        // Add smooth scroll behavior
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
        
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

            // Loading indicator handles all visual feedback - no need to disable buttons

            // Allow form to continue submitting
            return true;
        });
        
        // Global navigation loading - Show loading on menu/link clicks
        $('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"]):not([data-toggle]):not(.no-loading):not(.delete-btn):not(.btn-delete):not([data-confirm])').on('click', function(e) {
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

        // Handle external resource loading errors gracefully
        window.addEventListener('error', function(event) {
            // Check if error is related to resource loading (CSS, JS, etc)
            if (event.filename && !event.filename.includes('localhost')) {
                // Suppress console errors for external resources
                console.warn('External resource failed to load:', event.filename);
                event.preventDefault();
            }
        }, true);
    });
</script>

</body>

</html>