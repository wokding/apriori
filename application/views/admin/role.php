<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-shield mr-2"></i><?= $title; ?>
        </h1>
        <a href="" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#newRoleModal">
            <i class="fas fa-plus fa-sm mr-2"></i>Add New Role
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-list mr-2"></i>Role Management
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="dataTable" style="width:100%">
                            <thead class="bg-primary" style="color: #ffffff !important;">
                                <tr>
                                    <th scope="col" width="80" class="text-center" style="color: #ffffff !important;">No.</th>
                                    <th scope="col" style="color: #ffffff !important;">Role Name</th>
                                    <th scope="col" width="200" class="text-center" style="color: #ffffff !important;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($role as $r) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i ?></td>
                                        <td>
                                            <i class="fas fa-user-tag mr-2 text-primary"></i>
                                            <strong><?= $r['role']; ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="btn btn-warning btn-sm mr-1 mb-1 no-loading" title="Manage Access" onclick="confirmManageAccess(<?= $r['id']; ?>, '<?= htmlspecialchars($r['role'], ENT_QUOTES); ?>')">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm mr-1 mb-1 no-loading" title="Edit Role" onclick="confirmEditRole(<?= $r['id']; ?>, '<?= htmlspecialchars($r['role'], ENT_QUOTES); ?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1 no-loading" title="Delete Role" onclick="confirmDeleteRole(<?= $r['id']; ?>, '<?= htmlspecialchars($r['role'], ENT_QUOTES); ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
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

                <!-- Modal Add Role -->
                <div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="newRoleModalLabel">
                                    <i class="fas fa-plus-circle mr-2"></i>Add New Role
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/role'); ?>" method="post"
                                  data-loading="true"
                                  data-loading-title="Saving Role..."
                                  data-loading-message="Please wait...">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="role"><i class="fas fa-user-shield mr-2 text-primary"></i>Role Name</label>
                                        <input type="text" class="form-control" id="role" name="role" placeholder="Enter role name" required>
                                    </div>
                                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideLoadingIndicator()">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary no-loading">
                        <i class="fas fa-save mr-1"></i>Save
                    </button>
                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Role -->
                <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="editRoleModalLabel">
                                    <i class="fas fa-edit mr-2"></i>Edit Role
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/editRole'); ?>" method="post"
                                  data-loading="true"
                                  data-loading-title="Updating Role..."
                                  data-loading-message="Please wait while we update the role.">
                                <div class="modal-body">
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_role"><i class="fas fa-user-shield mr-2 text-success"></i>Role Name</label>
                                        <input type="text" class="form-control" id="edit_role" name="role" placeholder="Enter role name" required>
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

                <!-- Modal Delete Role -->
                <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title" id="deleteRoleModalLabel">
                                    <i class="fas fa-info-circle mr-2"></i>Delete Confirmation
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/deleteRole/'); ?>" method="post" id="deleteRoleForm"
                                  data-loading="true"
                                  data-loading-title="Deleting Role..."
                                  data-loading-message="Please wait while we delete the role.">
                                <div class="modal-body">
                                    <input type="hidden" id="delete_id" name="id">
                                    <p class="mb-0">Are you sure you want to delete role <strong><span id="delete_role_name"></span></strong>?</p>
                                </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideLoadingIndicator()">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteRoleBtn">
                                    <i class="fas fa-trash-alt mr-1"></i>Yes, Delete
                                </button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Role Confirmation -->
                <div class="modal fade" id="editRoleConfirmModal" tabindex="-1" aria-labelledby="editRoleConfirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="editRoleConfirmModalLabel">
                                    <i class="fas fa-edit mr-2"></i>Edit Role
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to edit role <strong><span id="edit_role_confirm_name"></span></strong>?</p>
                                <small class="text-muted">You will be able to modify the role details.</small>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-success" id="confirmEditRoleBtn">
                                    <i class="fas fa-edit mr-1"></i>Yes, Edit Role
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Manage Access Confirmation -->
                <div class="modal fade" id="manageAccessModal" tabindex="-1" aria-labelledby="manageAccessModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="manageAccessModalLabel">
                                    <i class="fas fa-key mr-2"></i>Manage Access
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to manage access for role <strong><span id="manage_access_role_name"></span></strong>?</p>
                                <small class="text-muted">You will be redirected to the role access management page.</small>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideLoadingIndicator()">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-warning" id="confirmManageAccessBtn">
                                    <i class="fas fa-key mr-1"></i>Yes, Manage Access
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Make functions globally accessible
                window.confirmEditRole = function(id, role) {
                    Swal.fire({
                        title: 'Edit Role?',
                        html: 'Are you sure you want to edit role <strong>' + role + '</strong>?<br><br>You will be able to modify the role details.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-edit mr-2"></i>Yes, Edit Role',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Loading Role Editor', 'Opening role edit form...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Loading Role Editor';
                                document.getElementById('loadingOverlayMessage').textContent = 'Opening role edit form...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Populate and open edit modal after a delay to ensure loading shows
                            setTimeout(function() {
                                $('#edit_id').val(id);
                                $('#edit_role').val(role);
                                $('#editRoleModal').modal('show');
                                // Hide loading when modal is shown
                                if (typeof window.hideLoading === 'function') {
                                    window.hideLoading();
                                } else {
                                    document.getElementById('globalLoadingOverlay').style.display = 'none';
                                }
                            }, 500);
                        }
                    });
                };

                window.confirmManageAccess = function(id, role) {
                    Swal.fire({
                        title: 'Manage Access?',
                        html: 'Are you sure you want to manage access for role <strong>' + role + '</strong>?<br><br>You will be redirected to the role access management page.',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-key mr-2"></i>Yes, Manage Access',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Loading Access Management', 'Redirecting to role access page...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Loading Access Management';
                                document.getElementById('loadingOverlayMessage').textContent = 'Redirecting to role access page...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Redirect after a delay to ensure loading shows
                            setTimeout(function() {
                                window.location.href = '<?= base_url('admin/roleaccess/'); ?>' + id;
                            }, 500);
                        }
                    });
                };

                window.confirmDeleteRole = function(id, role) {
                    Swal.fire({
                        title: 'Delete Role?',
                        html: 'Are you sure you want to delete role <strong>' + role + '</strong>?<br><br>This action cannot be undone!',
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
                                window.showLoading('Deleting Role', 'Please wait while we delete the role...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Deleting Role';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we delete the role...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Submit form after a delay to ensure loading shows
                            setTimeout(function() {
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '<?= base_url('admin/deleteRole/'); ?>' + id;
                                document.body.appendChild(form);
                                form.submit();
                            }, 500);
                        }
                    });
                };
                </script>
