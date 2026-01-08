<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-bars mr-2"></i><?= $title; ?>
        </h1>
        <a href="" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#newMenuModal">
            <i class="fas fa-plus fa-sm mr-2"></i>Add New Menu
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-list mr-2"></i>Menu Management
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" width="80" class="text-center">No.</th>
                                    <th scope="col">Menu Name</th>
                                    <th scope="col" width="150" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($menu as $m) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i ?></td>
                                        <td>
                                            <i class="fas fa-folder mr-2 text-primary"></i>
                                            <strong><?= $m['menu']; ?></strong>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm mr-1 mb-1 no-loading" title="Edit" onclick="confirmEditMenu(<?= $m['id']; ?>, '<?= htmlspecialchars($m['menu'], ENT_QUOTES); ?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm mb-1 no-loading" title="Delete" onclick="confirmDeleteMenu(<?= $m['id']; ?>, '<?= htmlspecialchars($m['menu'], ENT_QUOTES); ?>')">
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

                <!-- Add Modal -->
                <div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="newMenuModalLabel">
                                    <i class="fas fa-plus-circle mr-2"></i>Add New Menu
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('menu'); ?>" method="post"
                                  data-loading="true"
                                  data-loading-title="Saving Menu..."
                                  data-loading-message="Please wait...">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="menu"><i class="fas fa-bars mr-2 text-primary"></i>Menu Name</label>
                                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Enter menu name" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i>Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- edit Modal -->
                <?php foreach ($menu as $em) : ?>
                    <div class="modal fade" id="editMenuModal<?= $em['id'] ?>" tabindex="-1" aria-labelledby="editMenuModal<?= $em['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editMenuModal<?= $em['id'] ?>Label">
                                        <i class="fas fa-edit mr-2"></i>Edit Menu
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('menu/editMenu/' . $em['id']); ?>" method="post"
                                      data-loading="true"
                                      data-loading-title="Updating Menu..."
                                      data-loading-message="Please wait...">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="menu"><i class="fas fa-bars mr-2 text-primary"></i>Menu Name</label>
                                            <input type="text" class="form-control" value="<?= $em['menu'] ?>" id="menu" name="menu" placeholder="Enter menu name" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-warning text-white">
                                            <i class="fas fa-save mr-1"></i>Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- End edit Modal -->

                <!-- Modal Edit Menu Confirmation -->
                <div class="modal fade" id="editMenuConfirmModal" tabindex="-1" aria-labelledby="editMenuConfirmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="editMenuConfirmModalLabel">
                                    <i class="fas fa-edit mr-2"></i>Edit Menu
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to edit menu <strong><span id="edit_menu_name"></span></strong>?</p>
                                <small class="text-muted">You will be able to modify the menu details.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-success" id="confirmEditMenuBtn">
                                    <i class="fas fa-edit mr-1"></i>Yes, Edit Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Make functions globally accessible
                window.confirmEditMenu = function(menuId, menuName) {
                    Swal.fire({
                        title: 'Edit Menu?',
                        html: 'Are you sure you want to edit menu <strong>' + menuName + '</strong>?<br><br>You will be able to modify the menu details.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-edit mr-2"></i>Yes, Edit Menu',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Loading Menu Editor', 'Opening menu edit form...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Loading Menu Editor';
                                document.getElementById('loadingOverlayMessage').textContent = 'Opening menu edit form...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Open edit modal after a delay to ensure loading shows
                            setTimeout(function() {
                                $('#editMenuModal' + menuId).modal('show');
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

                window.confirmDeleteMenu = function(menuId, menuName) {
                    Swal.fire({
                        title: 'Delete Menu?',
                        html: 'Are you sure you want to delete menu <strong>' + menuName + '</strong>?<br><br>This action cannot be undone!',
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
                                window.showLoading('Deleting Menu', 'Please wait while we delete the menu...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Deleting Menu';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we delete the menu...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Redirect after a delay to ensure loading shows
                            setTimeout(function() {
                                window.location.href = '<?php echo site_url('menu/deleteMenu/'); ?>' + menuId;
                            }, 500);
                        }
                    });
                };
                </script>
