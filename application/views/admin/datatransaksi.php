<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-database mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-table mr-2"></i>Transaction Data Management
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <?= validation_errors(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <a href="" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#newDataTransaksiModal">
                            <i class="fas fa-plus fa-sm mr-2"></i>Add New Transaction
                        </a>
                        <a href="" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#importTransaksiModal">
                            <i class="fas fa-file-import fa-sm mr-2"></i>Import Data
                        </a>
                        <a href="<?= base_url('admin/deleteAllDataTransaksi/') ?>" class="btn btn-danger shadow-sm delete-btn" data-confirm="Are you sure you want to delete ALL transaction data? This action cannot be undone!">
                            <i class="fas fa-trash-alt fa-sm mr-2"></i>Delete All Data
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover table-bordered" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" class="text-center" width="60" style="color: white !important;">No.</th>
                                    <th scope="col" class="text-center" style="color: white !important;">Transaction Code</th>
                                    <th scope="col" class="text-center" style="color: white !important;">Transaction Date</th>
                                    <th scope="col" style="color: white !important;">Products</th>
                                    <th scope="col" class="text-center" style="color: white !important;">Total Price</th>
                                    <th scope="col" class="text-center" width="150" style="color: white !important;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($dataTransaksi as $dt) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $i ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-primary"><?= $dt['id_transaksi']; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <i class="fas fa-calendar-alt mr-1 text-muted"></i>
                                            <?= date('d M Y', strtotime($dt['transaction_date'])); ?>
                                        </td>
                                        <td><?= $dt['produk']; ?></td>
                                        <td class="text-right font-weight-bold text-success">
                                            Rp <?= number_format($dt['total'], 0, ',', '.'); ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" data-target="#editDataTransaksiModal<?= $dt['id'] ?>" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/deleteDataTransaksi/' . $dt['id']) ?>" class="btn btn-danger btn-sm delete-btn" data-confirm="Are you sure you want to delete transaction <?= $dt['id_transaksi']; ?>?" title="Delete">
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
<div class="modal fade" id="newDataTransaksiModal" tabindex="-1" aria-labelledby="newDataTransaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="newDataTransaksiModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Add New Transaction
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/datatransaksi'); ?>" method="post"
                  data-loading="true"
                  data-loading-title="Saving Transaction..."
                  data-loading-message="Please wait...">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id_transaksi"><i class="fas fa-barcode mr-2 text-primary"></i>Transaction Code</label>
                        <input type="text" class="form-control" id="id_transaksi" name="id_transaksi" placeholder="Enter transaction code" required>
                    </div>
                    <div class="form-group">
                        <label for="transaction_date"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Transaction Date</label>
                        <input type="text" class="form-control datepicker" id="transaction_date" name="transaction_date" placeholder="Select date" required>
                    </div>
                    <div class="form-group">
                        <label for="produk"><i class="fas fa-box mr-2 text-primary"></i>Products</label>
                        <textarea class="form-control" id="produk" name="produk" rows="3" placeholder="Enter products (comma separated)" required></textarea>
                        <small class="form-text text-muted">Example: Product A, Product B, Product C</small>
                    </div>
                    <div class="form-group">
                        <label for="total"><i class="fas fa-money-bill-wave mr-2 text-primary"></i>Total Price</label>
                        <input type="number" step="0.01" class="form-control" id="total" name="total" placeholder="Enter total price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Save Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- Tambah via Upload Excel Modal -->
                <div class="modal fade" id="importTransaksiModal" tabindex="-1" aria-labelledby="importTransaksiModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="importTransaksiModalLabel">
                                    <i class="fas fa-file-import mr-2"></i>Import Transactions
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/importTransaksi') ?>" enctype="multipart/form-data" method="post"
                                  data-loading="true"
                                  data-loading-title="Importing Transactions..."
                                  data-loading-message="Processing CSV file. Please wait...">
                                <div class="modal-body">
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Note:</strong> Please use CSV format. Download sample template below.
                                    </div>
                                    <div class="form-group">
                                        <label for="validatedCustomFile"><i class="fas fa-file-csv mr-2 text-primary"></i>Select CSV File</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="validatedCustomFile" name="fileURL" accept=".csv" required>
                                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="<?= base_url('assets/uploads/sample-csv.csv') ?>" class="btn btn-outline-primary btn-sm" target="_blank">
                                            <i class="fas fa-download mr-1"></i>Download Sample Template
                                        </a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i>Cancel
                                    </button>
                                    <button type="submit" name="import" class="btn btn-success">
                                        <i class="fas fa-upload mr-1"></i>Import Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- edit Modal -->
                <?php foreach ($dataTransaksi as $edt) : ?>
                    <div class="modal fade" id="editDataTransaksiModal<?= $edt['id'] ?>" tabindex="-1" aria-labelledby="editDataTransaksiModal<?= $edt['id'] ?>Label" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title" id="editDataTransaksiModal<?= $edt['id'] ?>Label">
                                        <i class="fas fa-edit mr-2"></i>Edit Transaction
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('admin/editDataTransaksi/' . $edt['id']); ?>" method="post"
                                      data-loading="true"
                                      data-loading-title="Updating Transaction..."
                                      data-loading-message="Please wait...">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="id_transaksi"><i class="fas fa-barcode mr-2 text-primary"></i>Transaction Code</label>
                                            <input type="text" class="form-control" value="<?= $edt['id_transaksi'] ?>" readonly id="id_transaksi" name="id_transaksi">
                                            <small class="form-text text-muted">This field cannot be changed</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_date"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Transaction Date</label>
                                            <input type="text" class="form-control datepicker" value="<?= $edt['transaction_date'] ?>" id="transaction_date" name="transaction_date" placeholder="Select date" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="produk"><i class="fas fa-box mr-2 text-primary"></i>Products</label>
                                            <textarea class="form-control" id="produk" name="produk" rows="3" placeholder="Enter products (comma separated)" required><?= $edt['produk']; ?></textarea>
                                            <small class="form-text text-muted">Example: Product A, Product B, Product C</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="total"><i class="fas fa-money-bill-wave mr-2 text-primary"></i>Total Price</label>
                                            <input type="number" step="0.01" class="form-control" value="<?= $edt['total'] ?>" id="total" name="total" placeholder="Enter total price" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i>Cancel
                                        </button>
                                        <button type="submit" class="btn btn-warning text-white">
                                            <i class="fas fa-save mr-1"></i>Update Transaction
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- End edit Modal -->