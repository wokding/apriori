<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-list-ul mr-2"></i><?= $title; ?>
        </h1>
        <a href="" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#newSubMenuModal">
            <i class="fas fa-plus fa-sm mr-2"></i>Add New Submenu
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-table mr-2"></i>Submenu Management
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" class="text-center" width="60">No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col">URL</th>
                                    <th scope="col" class="text-center">Icon</th>
                                    <th scope="col" class="text-center" width="100">Status</th>
                                    <th scope="col" class="text-center" width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($subMenu as $sm) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i ?></td>
                                        <td>
                                            <i class="<?= $sm['icon']; ?> mr-2 text-primary"></i>
                                            <strong><?= $sm['title']; ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><?= $sm['menu']; ?></span>
                                        </td>
                                        <td>
                                            <code><?= $sm['url']; ?></code>
                                        </td>
                                        <td class="text-center">
                                            <i class="<?= $sm['icon']; ?> fa-lg"></i>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($sm['is_active'] == 0) : ?>
                                                <span class="badge badge-danger">Inactive</span>
                                            <?php else : ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" data-target="#editSubMenuModal<?= $sm['id'] ?>" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('menu/deleteSubMenu/' . $sm['id']) ?>" class="btn btn-danger btn-sm delete-btn" data-confirm="Are you sure you want to delete <?= $sm['title']; ?>?" title="Delete">
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
                <div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="newSubMenuModalLabel">
                                    <i class="fas fa-plus-circle mr-2"></i>Add New Sub Menu
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('menu/submenu'); ?>" method="post"
                                  data-loading="true"
                                  data-loading-title="Saving Submenu..."
                                  data-loading-message="Please wait...">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title"><i class="fas fa-heading mr-2 text-primary"></i>Submenu Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter submenu title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="menu_id"><i class="fas fa-list mr-2 text-primary"></i>Parent Menu</label>
                                        <select name="menu_id" id="menu_id" class="form-control" required>
                                            <option value="">Select Menu</option>
                                            <?php foreach ($menu as $m) : ?>
                                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="url"><i class="fas fa-link mr-2 text-primary"></i>Submenu URL</label>
                                        <input type="text" class="form-control" id="url" name="url" placeholder="e.g., admin/dashboard" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="icon"><i class="fas fa-icons mr-2 text-primary"></i>Submenu Icon</label>
                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="e.g., fas fa-fw fa-tachometer-alt" required>
                                        <small class="form-text text-muted">Use Font Awesome icon classes</small>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="1" name="is_active" id="is_active" checked>
                                            <label class="custom-control-label" for="is_active">
                                                <i class="fas fa-check-circle mr-1 text-success"></i>Active
                                            </label>
                                        </div>
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

                <!-- Edit Modal -->
                <?php foreach ($subMenu as $esm) : ?>
                    <div class="modal fade" id="editSubMenuModal<?= $esm['id'] ?>" tabindex="-1" aria-labelledby="editSubMenuModal<?= $esm['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editSubMenuModal<?= $esm['id'] ?>Label">
                                        <i class="fas fa-edit mr-2"></i>Edit Sub Menu
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('menu/editSubMenu/' . $esm['id']); ?>" method="post"
                                      data-loading="true"
                                      data-loading-title="Updating Submenu..."
                                      data-loading-message="Please wait...">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title"><i class="fas fa-heading mr-2 text-primary"></i>Submenu Title</label>
                                            <input type="text" class="form-control" value="<?= $esm['title'] ?>" id="title" name="title" placeholder="Enter submenu title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="menu_id"><i class="fas fa-list mr-2 text-primary"></i>Parent Menu</label>
                                            <select name="menu_id" id="menu_id" class="form-control" required>
                                                <option value="">Select Menu</option>
                                                <?php foreach ($menu as $mm) : ?>
                                                    <?php if ($esm['menu_id'] == $mm['id']) : ?>
                                                        <option value="<?= $mm['id']; ?>" selected><?= $mm['menu']; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $mm['id']; ?>"><?= $mm['menu']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="url"><i class="fas fa-link mr-2 text-primary"></i>Submenu URL</label>
                                            <input type="text" class="form-control" value="<?= $esm['url'] ?>" id="url" name="url" placeholder="e.g., admin/dashboard" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="icon"><i class="fas fa-icons mr-2 text-primary"></i>Submenu Icon</label>
                                            <input type="text" class="form-control" value="<?= $esm['icon'] ?>" id="icon" name="icon" placeholder="e.g., fas fa-fw fa-tachometer-alt" required>
                                            <small class="form-text text-muted">Use Font Awesome icon classes</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <?php if ($esm['is_active'] == 1) : ?>
                                                    <input type="checkbox" class="custom-control-input" value="1" name="is_active" id="is_active<?= $esm['id'] ?>" checked>
                                                <?php else : ?>
                                                    <input type="checkbox" class="custom-control-input" value="1" name="is_active" id="is_active<?= $esm['id'] ?>">
                                                <?php endif; ?>
                                                <label class="custom-control-label" for="is_active<?= $esm['id'] ?>">
                                                    <i class="fas fa-check-circle mr-1 text-success"></i>Active
                                                </label>
                                            </div>
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
                <!-- End Edit Modal -->