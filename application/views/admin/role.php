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
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" width="80" class="text-center">No.</th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col" width="200" class="text-center">Actions</th>
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
                                            <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="btn btn-warning btn-sm" title="Manage Access">
                                                <i class="fas fa-key"></i>
                                            </a>
                                            <a href="" class="btn btn-success btn-sm" title="Edit Role">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="" class="btn btn-danger btn-sm" title="Delete Role">
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

                <!-- Modal -->
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