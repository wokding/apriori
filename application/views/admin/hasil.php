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
                                            <a href="javascript:void(0);" class="btn btn-info btn-sm no-loading" title="View Details" onclick="confirmViewDetails('<?php echo $display_id ?>')">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-warning btn-sm mb-1 no-loading" title="Export PDF" onclick="confirmExportPDF('<?php echo $display_id ?>')">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm no-loading" title="Delete" onclick="confirmDeleteResult('<?php echo $display_id ?>')">
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

                <!-- Modal View Details Confirmation -->
                <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="viewDetailsModalLabel">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to view details for result ID <strong><span id="view_details_result_id"></span></strong>?</p>
                                <small class="text-muted">You will be redirected to the detailed results page.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-info" id="confirmViewDetailsBtn">
                                    <i class="fas fa-eye mr-1"></i>Yes, View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Export PDF Confirmation -->
                <div class="modal fade" id="exportPDFModal" tabindex="-1" aria-labelledby="exportPDFModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title" id="exportPDFModalLabel">
                                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Are you sure you want to export PDF for result ID <strong><span id="export_pdf_result_id"></span></strong>?</p>
                                <small class="text-muted">The PDF will open in a new tab.</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-warning" id="confirmExportPDFBtn">
                                    <i class="fas fa-file-pdf mr-1"></i>Yes, Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                // Make functions globally accessible
                window.confirmViewDetails = function(resultId) {
                    Swal.fire({
                        title: 'View Details?',
                        html: 'Are you sure you want to view details for result ID <strong>' + resultId + '</strong>?<br><br>You will be redirected to the detailed results page.',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#17a2b8',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-eye mr-2"></i>Yes, View Details',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Loading Details', 'Please wait while we load the result details...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Loading Details';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we load the result details...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Redirect after a delay to ensure loading shows
                            setTimeout(function() {
                                window.location.href = '<?php echo site_url('admin/viewRule/'); ?>' + resultId;
                            }, 500);
                        }
                    });
                };

                window.confirmExportPDF = function(resultId) {
                    Swal.fire({
                        title: 'Export PDF?',
                        html: 'Are you sure you want to export PDF for result ID <strong>' + resultId + '</strong>?<br><br>The PDF will open in a new tab.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-file-pdf mr-2"></i>Yes, Export PDF',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated fadeInDown faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Exporting PDF', 'Please wait while we generate the PDF report...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Exporting PDF';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we generate the PDF report...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Open PDF in new tab after a delay to ensure loading shows
                            setTimeout(function() {
                                window.open('<?php echo site_url('admin/viewRulePDF/'); ?>' + resultId, '_blank');
                                // Hide loading after PDF opens
                                setTimeout(function() {
                                    if (typeof window.hideLoading === 'function') {
                                        window.hideLoading();
                                    } else {
                                        document.getElementById('globalLoadingOverlay').style.display = 'none';
                                    }
                                }, 1000);
                            }, 500);
                        }
                    });
                };

                window.confirmDeleteResult = function(resultId) {
                    Swal.fire({
                        title: 'Delete Result?',
                        html: 'Are you sure you want to delete result ID <strong>' + resultId + '</strong>?<br><br>This action cannot be undone!',
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Yes, Delete',
                        cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                        customClass: {
                            popup: 'animated shake faster'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading immediately
                            if (typeof window.showLoading === 'function') {
                                window.showLoading('Deleting Result', 'Please wait while we delete the result...');
                            } else {
                                document.getElementById('loadingOverlayTitle').textContent = 'Deleting Result';
                                document.getElementById('loadingOverlayMessage').textContent = 'Please wait while we delete the result...';
                                document.getElementById('globalLoadingOverlay').style.display = 'flex';
                            }

                            // Redirect after a delay to ensure loading shows
                            setTimeout(function() {
                                window.location.href = '<?php echo site_url('admin/hapusRule/'); ?>' + resultId;
                            }, 500);
                        }
                    });
                };
                </script>
