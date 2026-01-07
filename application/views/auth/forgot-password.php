<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="card auth-card">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('assets/img/kimiafarma.png'); ?>" class="auth-logo img-fluid" alt="Kimia Farma Logo">
                                    <h1 class="auth-title mt-3">Forgot Password?</h1>
                                    <p class="text-muted">Enter your email to reset your password</p>
                                </div>
                                
                                <!-- Info Box -->
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Note:</strong> Your password will be reset to <strong>password123</strong> automatically.
                                </div>
                                
                                <form class="user" method="post" action="<?= base_url('auth/forgotpassword'); ?>"
                                      data-loading="true"
                                      data-loading-title="Resetting Password..."
                                      data-loading-message="Please wait while we reset your password.">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your registered email..." value="<?= set_value('email'); ?>" autocomplete="email" required>
                                        </div>
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-user btn-block btn-lg mt-4">
                                        <i class="fas fa-key mr-2"></i> Reset Password
                                    </button>
                                </form>
                                
                                <hr class="my-4">
                                
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">
                                        <i class="fas fa-arrow-left mr-1"></i> Back to Login
                                    </a>
                                </div>
                                <div class="text-center mt-2">
                                    <a class="small" href="<?= base_url('auth/registration'); ?>">
                                        <i class="fas fa-user-plus mr-1"></i> Create an Account!
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>