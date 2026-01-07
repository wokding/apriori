<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-bar mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-table mr-2"></i>Process Results
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover table-bordered" style="width:100%">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-center" width="60" style="color: white !important;">No.</th>
                                    <th class="text-center" style="color: white !important;">Process ID</th>
                                    <th class="text-center" style="color: white !important;">Start Date</th>
                                    <th class="text-center" style="color: white !important;">End Date</th>
                                    <th class="text-center" style="color: white !important;">Min Support (%)</th>
                                    <th class="text-center" style="color: white !important;">Min Confidence (%)</th>
                                    <th class="text-center" width="200" style="color: white !important;">Actions</th>
                						</tr>
                            </thead>
                            <tbody>
                                <?php $j = 1; ?>
                                <?php foreach ($hasil as $hasil) : ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?php echo $j ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-primary badge-pill"><?php echo !empty($hasil->process_id) ? $hasil->process_id : 'DM-' . str_pad($hasil->id, 3, '0', STR_PAD_LEFT) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <i class="fas fa-calendar-check mr-1 text-success"></i>
                                            <?php echo date('d M Y', strtotime($hasil->start_date)) ?>
                                        </td>
                                        <td class="text-center">
                                            <i class="fas fa-calendar-check mr-1 text-danger"></i>
                                            <?php echo date('d M Y', strtotime($hasil->end_date)) ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-success"><?php echo $hasil->min_support ?>%</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info"><?php echo $hasil->min_confidence ?>%</span>
                                        </td>
                                        <td class="text-center">
                                            <?php $display_id = !empty($hasil->process_id) ? $hasil->process_id : 'DM-' . str_pad($hasil->id, 3, '0', STR_PAD_LEFT); ?>
                                            <a href="<?php echo site_url('admin/viewRule/' . $display_id) ?>" class="btn btn-info btn-sm" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo site_url('admin/viewRulePDF/' . $display_id) ?>" class="btn btn-warning btn-sm" target="_blank" title="Export PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="<?= base_url('admin/hapusRule/' . $display_id) ?>" class="btn btn-danger btn-sm delete-btn" data-confirm="Are you sure you want to delete result ID <?= $display_id ?>?" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $j++; ?>
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

<!-- Delete Confirmation-->
                			<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                				<div class="modal-dialog" role="document">
                					<div class="modal-content">
                						<div class="modal-header">
                							<h5 class="modal-title" id="exampleModalLabel">
                								Apakah anda yakin?
                							</h5>
                							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
                								<span aria-hidden="true">×</span>
                							</button>
                						</div>
                						<div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
                						<div class="modal-footer">
                							<button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                							<a id="btn-delete" class="btn btn-danger" href="#">Hapus</a>
                						</div>
                					</div>
                				</div>
                			</div>

                		</div>
                	</div>
                </div>

                </div>