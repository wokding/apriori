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
<div id="globalLoadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
        <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <h3 class="text-white mt-3" id="loadingOverlayTitle">Processing...</h3>
        <p class="text-white" id="loadingOverlayMessage">Please wait while we process your request.</p>
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
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">
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

<!-- Custom Enhanced Scripts -->
<script src="<?= base_url('assets/'); ?>js/custom-enhanced.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

<!-- Date Picker Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<script src="<?= base_url('assets/'); ?>daterange/daterange.js"></script>
<script src="<?= base_url('assets/'); ?>bootstrap-datepicker-1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

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
                        document.location.href = "<?= base_url('admin/roleAccess/'); ?>" + roleId;
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
            
            // Disable all submit buttons in the form
            form.find('button[type="submit"], input[type="submit"]').prop('disabled', true);
            
            // Allow form to continue submitting
            return true;
        });
        
        // Global navigation loading - Show loading on menu/link clicks
        $('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"]):not([data-toggle]):not(.no-loading):not(.delete-btn):not(.btn-delete)').on('click', function(e) {
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
    });
</script>

</body>

</html>