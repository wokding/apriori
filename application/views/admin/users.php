<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-list mr-2"></i>Registered Users
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="dataTable" style="width:100%">
                            <thead class="bg-primary" style="color: #ffffff !important;">
                                <tr>
                                    <th scope="col" width="50" class="text-center" style="color: #ffffff !important;">No.</th>
                                    <th scope="col" style="color: #ffffff !important;">Name</th>
                                    <th scope="col" style="color: #ffffff !important;">Email</th>
                                    <th scope="col" width="120" class="text-center" style="color: #ffffff !important;">Role</th>
                                    <th scope="col" width="120" class="text-center" style="color: #ffffff !important;">Status</th>
                                    <th scope="col" width="150" class="text-center" style="color: #ffffff !important;">Registered</th>
                                    <th scope="col" width="200" class="text-center" style="color: #ffffff !important;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $u) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('assets/img/profile/') . $u['image']; ?>" 
                                                     class="rounded-circle mr-2" 
                                                     width="35" 
                                                     height="35"
                                                     onerror="this.src='<?= base_url('assets/img/profile/default.jpg'); ?>'">
                                                <strong><?= $u['name']; ?></strong>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope mr-2 text-primary"></i>
                                            <?= $u['email']; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-<?= $u['role_id'] == 1 ? 'danger' : 'info'; ?> badge-pill">
                                                <i class="fas fa-user-tag mr-1"></i><?= $u['role']; ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($u['is_active'] == 1) : ?>
                                                <span class="badge badge-success badge-pill">
                                                    <i class="fas fa-check-circle mr-1"></i>Active
                                                </span>
                                            <?php else : ?>
                                                <span class="badge badge-secondary badge-pill">
                                                    <i class="fas fa-times-circle mr-1"></i>Inactive
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar mr-1"></i>
                                                <?= date('d M Y', $u['date_created']); ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($u['email'] == 'adenaufalr@gmail.com') : ?>
                                                <!-- Main Administrator - Actions Disabled -->
                                                <span class="badge badge-secondary badge-pill" title="Main administrator cannot be modified">
                                                    <i class="fas fa-lock mr-1"></i>Protected
                                                </span>
                                            <?php else : ?>
                                                <?php if ($u['is_active'] == 1) : ?>
                                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm mr-1 mb-1 no-loading" title="Deactivate User" onclick="confirmToggleStatus(<?= $u['id']; ?>, '<?= htmlspecialchars($u['name'], ENT_QUOTES); ?>', 'deactivate')">
                                                        <i class="fas fa-user-slash"></i>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm mr-1 mb-1 no-loading" title="Activate User" onclick="confirmToggleStatus(<?= $u['id']; ?>, '<?= htmlspecialchars($u['name'], ENT_QUOTES); ?>', 'activate')">
                                                        <i class="fas fa-user-check"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="javascript:void(0);" class="btn btn-info btn-sm mr-1 mb-1 no-loading" title="Change Role" onclick="confirmChangeRole(<?= $u['id']; ?>, '<?= htmlspecialchars($u['name'], ENT_QUOTES); ?>', <?= $u['role_id']; ?>)">
                                                    <i class="fas fa-user-tag"></i>
                                                </a>

                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1 no-loading" title="Delete User" onclick="confirmDeleteUser(<?= $u['id']; ?>, '<?= htmlspecialchars($u['name'], ENT_QUOTES); ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

                <!-- Modal Toggle Status -->
                <div class="modal fade" id="toggleStatusModal" tabindex="-1" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="toggleStatusModalLabel">
                                    <i class="fas fa-info-circle mr-2"></i><span id="modal_action_title">Confirmation</span>
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/toggleUserStatus/'); ?>" method="post" id="toggleStatusForm"
                                  data-loading="true"
                                  data-loading-title="Updating User Status..."
                                  data-loading-message="Please wait while we update the user status.">
                                <div class="modal-body">
                                    <input type="hidden" id="toggle_id" name="id">
                                    <p class="mb-0">Are you sure you want to <strong><span id="action_text"></span></strong> user <strong><span id="user_name"></span></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="confirm_button">
                                        Yes, Proceed
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Delete User -->
                <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="deleteUserModalLabel">
                                    <i class="fas fa-info-circle mr-2"></i>Delete Confirmation
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/deleteUser/'); ?>" method="post" id="deleteUserForm"
                                  data-loading="true"
                                  data-loading-title="Deleting User..."
                                  data-loading-message="Please wait while we delete the user.">
                                <div class="modal-body">
                                    <input type="hidden" id="delete_id" name="id">
                                    <p class="mb-0">Are you sure you want to delete user <strong><span id="delete_user_name"></span></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        Yes, Delete
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="editUserModalLabel">
                                    <i class="fas fa-edit mr-2"></i>Edit User
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/editUser'); ?>" method="post"
                                  data-loading="true"
                                  data-loading-title="Updating User..."
                                  data-loading-message="Please wait while we update the user.">
                                <div class="modal-body">
                                    <input type="hidden" id="edit_user_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_name"><i class="fas fa-user mr-2 text-success"></i>Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter user name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_email"><i class="fas fa-envelope mr-2 text-success"></i>Email</label>
                                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter user email" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideLoadingIndicator()">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success no-loading">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Change Role -->
                <div class="modal fade" id="changeRoleModal" tabindex="-1" aria-labelledby="changeRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="changeRoleModalLabel">
                                    <i class="fas fa-user-tag mr-2"></i>Change User Role
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/changeUserRole'); ?>" method="post" id="changeRoleForm"
                                  data-loading="true"
                                  data-loading-title="Changing User Role..."
                                  data-loading-message="Please wait while we update the user role.">
                                <div class="modal-body">
                                    <input type="hidden" id="change_role_id" name="id">
                                    <p class="mb-3">Change role for user: <strong><span id="change_role_user_name"></span></strong></p>

                                    <div class="form-group">
                                        <label for="role_id"><i class="fas fa-user-shield mr-2 text-primary"></i>Select Role</label>
                                        <select class="form-control" id="role_id" name="role_id" required>
                                            <option value="">-- Select Role --</option>
                                            <option value="1">Administrator</option>
                                            <option value="2">Member</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Yes, Change Role
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                // Make functions globally accessible
                window.confirmToggleStatus = function(id, name, action) {
                    const actionText = action.charAt(0).toUpperCase() + action.slice(1);
                    const actionColor = action === 'activate' ? '#28a745' : '#ffc107';
                    const actionIcon = action === 'activate' ? 'user-check' : 'user-slash';

                    Swal.fire({
                        title: actionText + ' User?',
                        html: 'Are you sure you want to <strong>' + action + '</strong> user <strong>' + name + '</strong>?<br><br>This will change their account status.',
                        icon: action === 'activate' ? 'success' : 'warning',
                        showCancelButton: true,
                        confirmButtonColor: actionColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-' + actionIcon + ' mr-2"></i>Yes, ' + actionText,
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Updating User Status', 'Please wait while we update the user status...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Updating User Status';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we update the user status...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Submit form after a delay to ensure loading shows
                            setTimeout(function() {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '<?= base_url('admin/toggleUserStatus/'); ?>' + id;
                                document.body.appendChild(form);
                                form.submit();
                            }, 500);
                        }
                    });
                };

                window.confirmDeleteUser = function(id, name) {
                    Swal.fire({
                        title: 'Delete User?',
                        html: 'Are you sure you want to delete user <strong>' + name + '</strong>?<br><br>This action cannot be undone!',
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Yes, Delete',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated shake faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Deleting User', 'Please wait while we delete the user...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Deleting User';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we delete the user...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Submit form after a delay to ensure loading shows
                            setTimeout(function() {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '<?= base_url('admin/deleteUser/'); ?>' + id;
                                document.body.appendChild(form);
                                form.submit();
                            }, 500);
                        }
                    });
                };

                window.confirmChangeRole = function(id, name, currentRoleId) {
                    Swal.fire({
                        title: 'Change User Role?',
                        html: 'Are you sure you want to change the role for user <strong>' + name + '</strong>?<br><br>You will be able to modify their permissions.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-user-tag mr-2"></i>Yes, Change Role',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Opening Change Role Form', 'Please wait while we prepare the form...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Opening Change Role Form';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we prepare the form...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Populate the modal with user data and show modal after a delay
                            setTimeout(function() {
                                document.getElementById('change_role_id').value = id;
                                document.getElementById('change_role_user_name').textContent = name;
                                document.getElementById('role_id').value = currentRoleId;

                                // Hide loading and show the modal
                                if (typeof window.hideLoading === 'function') {
                                    window.hideLoading();
                                } else {
                                    document.getElementById('globalLoadingOverlay').style.display = 'none';
                                }
                                $('#changeRoleModal').modal('show');
                            }, 500);
                        }
                    });
                };
                </script>
