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
                                    <h1 class="auth-title mt-3">Welcome Back!</h1>
                                    <p class="text-muted">Please login to your account</p>
                                </div>
                                
                                <form class="user" method="post" action="<?= base_url('auth'); ?>"
                                      data-loading="true"
                                      data-loading-title="Logging in..."
                                      data-loading-message="Please wait while we verify your credentials.">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>" autocomplete="email" required>
                                        </div>
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-primary text-white">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" autocomplete="current-password" required>
                                        </div>
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-user btn-block btn-lg mt-4">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                                    </button>
                                </form>
                                
                                <hr class="my-4">
                                
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">
                                        <i class="fas fa-key mr-1"></i> Forgot Password?
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