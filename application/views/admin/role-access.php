<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-key mr-2"></i><?= $title; ?>
        </h1>
        <a href="<?= base_url('admin/role'); ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-2"></i>Back to Roles
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-shield-alt mr-2"></i>Access Control for: <span class="badge badge-primary"><?= $role['role']; ?></span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" class="text-center" width="80">No.</th>
                                    <th scope="col">Menu Name</th>
                                    <th scope="col" class="text-center" width="150">Access</th>
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
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input form-check-input" id="access<?= $m['id'] ?>" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                                <label class="custom-control-label" for="access<?= $m['id'] ?>"></label>
                                            </div>
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
        
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Information
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <i class="fas fa-check-circle text-success mr-2"></i>
                        Toggle the switches to grant or revoke menu access for this role.
                    </p>
                    <p class="mb-3">
                        <i class="fas fa-sync-alt text-primary mr-2"></i>
                        Changes are saved automatically when you toggle a switch.
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-shield-alt text-warning mr-2"></i>
                        Make sure to test the access after making changes.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->