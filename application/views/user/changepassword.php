<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-key mr-2"></i><?= $title; ?>
        </h1>
        <a href="<?= base_url('user'); ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-2"></i>Back to Profile
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-lock mr-2"></i>Change Password
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('user/changepassword'); ?>" method="post"
                          data-loading="true"
                          data-loading-title="Changing Password..."
                          data-loading-message="Please wait...">
                        <div class="form-group">
                            <label for="current_password" class="font-weight-bold">
                                <i class="fas fa-lock mr-2 text-primary"></i>Current Password
                            </label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your current password" required>
                            <?= form_error('current_password', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password1" class="font-weight-bold">
                                <i class="fas fa-key mr-2 text-primary"></i>New Password
                            </label>
                            <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="Enter new password" required>
                            <?= form_error('new_password1', '<small class="text-danger">', '</small>'); ?>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Password must be at least 3 characters
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password2" class="font-weight-bold">
                                <i class="fas fa-check-circle mr-2 text-primary"></i>Repeat New Password
                            </label>
                            <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Re-enter new password" required>
                            <?= form_error('new_password2', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save mr-2"></i>Change Password
                            </button>
                            <a href="<?= base_url('user'); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-shield-alt mr-2"></i>Password Security Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Use a strong password:</strong> Mix uppercase, lowercase, numbers, and symbols
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Make it unique:</strong> Don't reuse passwords from other accounts
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Keep it secret:</strong> Never share your password with anyone
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Change regularly:</strong> Update your password every 3-6 months
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>Avoid common words:</strong> Don't use dictionary words or personal info
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->