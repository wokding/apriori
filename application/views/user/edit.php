<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit mr-2"></i><?= $title; ?>
        </h1>
        <a href="<?= base_url('user'); ?>" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-2"></i>Back to Profile
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit mr-2"></i>Edit Profile Information
                    </h6>
                </div>
                <div class="card-body">
                    <?= form_open_multipart('user/edit'); ?>
                    
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label font-weight-bold">
                            <i class="fas fa-envelope mr-2 text-primary"></i>Email
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            <small class="form-text text-muted">Email cannot be changed</small>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-bold">
                            <i class="fas fa-user mr-2 text-primary"></i>Full Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" placeholder="Enter your full name">
                            <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">
                            <i class="fas fa-image mr-2 text-primary"></i>Profile Picture
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4 text-center mb-3">
                                    <div class="image-preview-container">
                                        <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" 
                                             class="img-thumbnail rounded shadow" 
                                             style="width: 150px; height: 150px; object-fit: cover;" 
                                             id="imagePreview">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input image-input" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               data-preview="imagePreview">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Max file size: 2MB. Allowed: JPG, PNG, GIF. Preview will update automatically.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                            <a href="<?= base_url('user'); ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                    
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Tips
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            Use a professional photo
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            Keep your name updated
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success mr-2"></i>
                            Profile picture should be clear
                        </li>
                        <li>
                            <i class="fas fa-check text-success mr-2"></i>
                            Avoid special characters in name
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

<script>
// Preview image before upload
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>