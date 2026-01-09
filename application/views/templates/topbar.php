<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Title for Mobile -->
            <div class="d-md-none">
                <span class="text-primary font-weight-bold"><?= $title; ?></span>
            </div>

            <?php
            $CI = get_instance();
            $is_admin = isset($user['role_id']) && (int)$user['role_id'] === 1;
            $notif_items = [];
            $notif_count = 0;

            if ($is_admin) {
                $notif_items = $CI->db
                    ->select('name,email,date_created')
                    ->where('is_active', 0)
                    ->order_by('date_created', 'DESC')
                    ->limit(5)
                    ->get('user')
                    ->result_array();
                $notif_count = $CI->db->where('is_active', 0)->from('user')->count_all_results();
            } else {
                // Untuk member: tampilkan pesan aktif, badge 1x lalu hilang setelah dibuka (via JS/localStorage)
                $notif_items = [
                    [
                        'title' => 'Akun aktif',
                        'subtitle' => 'Admin telah mengaktifkan akun Anda',
                        'date_created' => time()
                    ]
                ];
                $notif_count = 1; // badge muncul, di-hide oleh JS setelah dibuka
            }
            ?>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Alerts -->
                <li class="nav-item dropdown no-arrow mx-1 d-none d-sm-block">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <?php if ($notif_count > 0) : ?>
                            <span class="badge badge-danger badge-counter" id="notifBadge" data-role="<?= $is_admin ? 'admin' : 'member'; ?>"><?= $notif_count > 9 ? '9+' : $notif_count; ?></span>
                        <?php endif; ?>
                    </a>
                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            <?= $is_admin ? 'Registrasi menunggu aktivasi' : 'Notifikasi Akun'; ?>
                        </h6>
                        <?php if (empty($notif_items)) : ?>
                            <span class="dropdown-item small text-gray-500">Tidak ada notifikasi</span>
                        <?php else : ?>
                            <?php foreach ($notif_items as $item) : ?>
                            <div class="dropdown-item d-flex align-items-center">
                                <div class="mr-3">
                                    <div class="icon-circle <?= $is_admin ? 'bg-warning' : 'bg-success'; ?>">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">
                                        <?= date('d M Y H:i', $item['date_created']); ?>
                                    </div>
                                    <?php if ($is_admin) : ?>
                                        <div class="font-weight-bold text-gray-800">Pending: <?= htmlspecialchars($item['name']); ?></div>
                                        <div class="text-gray-600 small">Email: <?= htmlspecialchars($item['email']); ?></div>
                                    <?php else : ?>
                                        <div class="font-weight-bold text-gray-800"><?= $item['title']; ?></div>
                                        <div class="text-gray-600 small"><?= $item['subtitle']; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if ($is_admin && $notif_count > 0) : ?>
                            <a class="dropdown-item text-center small text-primary" href="<?= base_url('admin/users'); ?>">Kelola aktivasi</a>
                        <?php endif; ?>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-700 font-weight-bold"><?= $user['name']; ?></span>
                        <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #4e73df;">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-profile rounded-circle mb-2" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" style="width: 60px; height: 60px; object-fit: cover;">
                            <h6 class="font-weight-bold"><?= $user['name']; ?></h6>
                            <small class="text-muted"><?= $user['email']; ?></small>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('user/index'); ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            My Profile
                        </a>
                        <a class="dropdown-item" href="<?= base_url('user/edit'); ?>">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <script>
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                var badge = document.getElementById('notifBadge');
                if (!badge) return;

                // Only apply auto-hide for member
                if (badge.dataset.role === 'member') {
                    var seenKey = 'notif_member_seen';
                    var hideBadge = function() { badge.classList.add('d-none'); };

                    // Hide if already seen in this browser
                    if (localStorage.getItem(seenKey)) {
                        hideBadge();
                    }

                    // When dropdown opened/clicked, mark as seen and hide badge
                    var dropdown = document.getElementById('alertsDropdown');
                    if (dropdown) {
                        var markSeen = function() {
                            localStorage.setItem(seenKey, '1');
                            hideBadge();
                        };
                        dropdown.addEventListener('click', markSeen);
                        // For Bootstrap event (if available)
                        if (typeof jQuery !== 'undefined' && typeof $.fn.dropdown !== 'undefined') {
                            $(dropdown).on('show.bs.dropdown', markSeen);
                        }
                    }
                }
            });
        })();
        </script>

        <!-- Toast Container (will be populated by toastr.js) -->
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