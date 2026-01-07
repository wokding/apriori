<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9">
            <div class="card auth-card">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <img src="<?= base_url('assets/img/kimiafarma.png'); ?>" class="auth-logo img-fluid" alt="Kimia Farma Logo">
                                    <h1 class="auth-title mt-3">Create an Account!</h1>
                                    <p class="text-muted">Join us to get started</p>
                                </div>
                                
                                <form class="user" method="post" action="<?= base_url('auth/registration'); ?>"
                                      data-loading="true"
                                      data-loading-title="Creating Account..."
                                      data-loading-message="Please wait while we set up your account.">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>" autocomplete="name" required>
                                        </div>
                                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>" autocomplete="email" required>
                                        </div>
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control form-control-lg password-input" id="password1" name="password1" placeholder="Password" autocomplete="new-password" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="password-strength-wrapper mt-2"></div>
                                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control form-control-lg password-input" id="password2" name="password2" placeholder="Repeat Password" autocomplete="new-password" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-user btn-block btn-lg mt-4">
                                        <i class="fas fa-user-plus mr-2"></i> Register Account
                                    </button>
                                </form>
                                
                                <hr class="my-4">
                                
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">
                                        <i class="fas fa-key mr-1"></i> Forgot Password?
                                    </a>
                                </div>
                                <div class="text-center mt-2">
                                    <a class="small" href="<?= base_url('auth'); ?>">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Already have an account? Login!
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