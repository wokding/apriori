<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <!-- Profile Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-id-card mr-2"></i>Profile Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-fluid rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #4e73df;" alt="Profile Picture">
                            <div class="mt-3">
                                <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="40%"><strong><i class="fas fa-user mr-2 text-primary"></i>Full Name</strong></td>
                                        <td>: <?= $user['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-envelope mr-2 text-primary"></i>Email</strong></td>
                                        <td>: <?= $user['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-calendar-alt mr-2 text-primary"></i>Member Since</strong></td>
                                        <td>: <?= date('d F Y', $user['date_created']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-shield-alt mr-2 text-primary"></i>Account Status</strong></td>
                                        <td>: <span class="badge badge-success">Active</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-cog mr-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </a>
                    <a href="<?= base_url('user/changepassword'); ?>" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-key mr-2"></i>Change Password
                    </a>
                    <a href="#" data-toggle="modal" data-target="#logoutModal" class="btn btn-danger btn-block">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->