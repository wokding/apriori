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
                                            <a href="" data-toggle="modal" data-target="#editMenuModal<?= $m['id'] ?>" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('menu/deleteMenu/' . $m['id']) ?>" class="btn btn-danger btn-sm delete-btn" data-confirm="Are you sure you want to delete <?= $m['menu']; ?>?" title="Delete">
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