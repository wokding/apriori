        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-prescription-bottle-alt"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Kimia Farma</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Query Menu -->
            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                                FROM `user_menu` JOIN `user_access_menu` 
                                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                WHERE `user_access_menu`.`role_id` = $role_id 
                                ORDER BY 
                                    CASE 
                                        WHEN `user_menu`.`id` = 1 THEN 1
                                        WHEN `user_menu`.`id` = 4 THEN 2
                                        WHEN `user_menu`.`id` = 2 THEN 3
                                        WHEN `user_menu`.`id` = 3 THEN 4
                                        ELSE 5
                                    END ASC
                                ";
            $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <!-- Looping Menu -->
            <?php foreach ($menu as $m) : ?>
                <div class="sidebar-heading">
                    <?= $m['menu']; ?>
                </div>

                <!-- Siapkan Sub-Menu Sesuai Menu -->
                <?php
                $menuId = $m['id'];
                $querySubMenu = "SELECT *
                                FROM `user_sub_menu` JOIN `user_menu` 
                                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                WHERE `user_sub_menu`.`menu_id` = $menuId
                                AND `user_sub_menu`.`is_active` = 1
                                ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>

                <?php foreach ($subMenu as $sm) : ?>
                    <?php
                    // Build current URL from URI segments
                    $current_path = $this->uri->segment(1);
                    if ($this->uri->segment(2)) {
                        $current_path .= '/' . $this->uri->segment(2);
                    }
                    
                    // Check if this menu item is active
                    $is_active = (trim($current_path, '/') === trim($sm['url'], '/'));
                    ?>
                    <li class="nav-item <?= $is_active ? 'active' : ''; ?>">
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon']; ?>"></i>
                            <span><?= $sm['title']; ?></span></a>
                    </li>
                <?php endforeach; ?>

                    <hr class="sidebar-divider mt-3">

                <?php endforeach; ?>

                <!-- Nav Item - Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('auth/logout'); ?>">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

        </ul>
        <!-- End of Sidebar -->