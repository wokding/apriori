<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-broom mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <!-- Database Statistics -->
    <div class="row">
        <!-- Table Sizes Card -->
        <div class="col-lg-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body py-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Database Size</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $total_size = 0;
                                foreach ($stats['sizes'] as $size) {
                                    $total_size += $size;
                                }
                                // Format: desimal pakai titik, tanpa thousand separator
                                echo number_format($total_size, 2) . ' MB';
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-database fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <?php foreach ($stats['sizes'] as $table => $size): ?>
                            <div class="d-flex justify-content-between mb-1">
                                <span><i class="fas fa-table mr-1"></i><?= ucfirst($table); ?>:</span>
                                <strong><?= number_format($size, 2); ?> MB</strong>
                            </div>
                        <?php endforeach; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Record Counts Card -->
        <div class="col-lg-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body py-3">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Records</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $total_records = $stats['process_log'] + $stats['itemset1'] + 
                                                $stats['itemset2'] + $stats['itemset3'] + 
                                                $stats['confidence'] + $stats['transaksi'];
                                // Format dengan koma sebagai thousand separator
                                echo number_format($total_records);
                                ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <hr class="my-2">
                    <small class="text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-folder mr-1"></i>Process Logs:</span>
                            <strong><?= number_format($stats['process_log']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-receipt mr-1"></i>Transactions:</span>
                            <strong><?= number_format($stats['transaksi']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-layer-group mr-1"></i>Itemset 1:</span>
                            <strong><?= number_format($stats['itemset1']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-layer-group mr-1"></i>Itemset 2:</span>
                            <strong><?= number_format($stats['itemset2']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-layer-group mr-1"></i>Itemset 3:</span>
                            <strong><?= number_format($stats['itemset3']); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-project-diagram mr-1"></i>Rules:</span>
                            <strong><?= number_format($stats['confidence']); ?></strong>
                        </div>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Cleanup Actions -->
    <div class="row">
        <!-- Keep Latest N Processes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-broom mr-2"></i>Keep Latest Processes
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle mr-1"></i>Keep the latest N processes and delete all older ones. This helps maintain database performance.
                    </p>
                    <form id="formKeepLatest" action="<?= base_url('admin/deleteOldProcesses'); ?>" method="post">
                        <div class="form-group">
                            <label class="font-weight-bold">Keep Latest:</label>
                            <select name="keep_latest" id="keep_latest" class="form-control" required>
                                <option value="5">5 Processes</option>
                                <option value="10" selected>10 Processes</option>
                                <option value="20">20 Processes</option>
                                <option value="30">30 Processes</option>
                                <option value="50">50 Processes</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-warning btn-block shadow-sm no-loading" onclick="confirmKeepLatest()">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Old Processes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete All -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-left-danger">
                <div class="card-header bg-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-exclamation-circle mr-1 text-danger"></i>
                        <strong class="text-danger">Warning:</strong> This will delete ALL process data permanently. Only transaction data will be kept.
                    </p>
                    <form id="formDeleteAll" action="<?= base_url('admin/deleteAllProcesses'); ?>" method="post">
                        <button type="button" class="btn btn-danger btn-block shadow-sm no-loading" onclick="confirmDeleteAll()">
                            <i class="fas fa-bomb mr-2"></i>Delete All Process Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Process List -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-history mr-2"></i>Process History
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center" style="color: white !important;">No</th>
                            <th style="color: white !important;">Process ID</th>
                            <th class="text-center" style="color: white !important;">Date Range</th>
                            <th class="text-center" style="color: white !important;">Parameters</th>
                            <th class="text-center" style="color: white !important;">Results</th>
                            <th class="text-center" width="100" style="color: white !important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($processes)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                                    No process data found
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($processes as $process): ?>
                                <tr>
                                    <td class="text-center font-weight-bold"><?= $no++; ?></td>
                                    <td>
                                        <span class="badge badge-primary"><?= $process['process_id']; ?></span>
                                    </td>
                                    <td class="text-center">
                                        <small>
                                            <i class="fas fa-calendar-alt mr-1 text-muted"></i>
                                            <?= date('d M Y', strtotime($process['start_date'])); ?>
                                            <br>to<br>
                                            <?= date('d M Y', strtotime($process['end_date'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <strong>Support:</strong> <?= $process['min_support']; ?>%<br>
                                            <strong>Confidence:</strong> <?= $process['min_confidence']; ?>%
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <div class="d-flex justify-content-between px-2">
                                                <span>Itemset 1:</span>
                                                <strong class="badge badge-info"><?= number_format($process['itemset1_count']); ?></strong>
                                            </div>
                                            <div class="d-flex justify-content-between px-2">
                                                <span>Itemset 2:</span>
                                                <strong class="badge badge-info"><?= number_format($process['itemset2_count']); ?></strong>
                                            </div>
                                            <div class="d-flex justify-content-between px-2">
                                                <span>Itemset 3:</span>
                                                <strong class="badge badge-info"><?= number_format($process['itemset3_count']); ?></strong>
                                            </div>
                                            <div class="d-flex justify-content-between px-2">
                                                <span>Rules:</span>
                                                <strong class="badge badge-success"><?= number_format($process['rules_count']); ?></strong>
                                            </div>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-danger btn-sm no-loading" 
                                                onclick="confirmDeleteProcess(<?= $process['id']; ?>, '<?= $process['process_id']; ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
// Make functions globally accessible
window.confirmDeleteProcess = function(processId, processName) {
    if (confirm('Are you sure you want to delete process ' + processName + ' and all related data?\n\nThis action cannot be undone!')) {
        // Show loading
        document.getElementById('loadingOverlayTitle').textContent = 'Deleting Process';
        document.getElementById('loadingOverlayMessage').textContent = 'Deleting process ' + processName + '...';
        document.getElementById('globalLoadingOverlay').style.display = 'flex';
        
        // Redirect to delete URL
        window.location.href = '<?= base_url('admin/deleteProcess/'); ?>' + processId;
    }
};

window.confirmKeepLatest = function() {
    var keepCount = document.getElementById('keep_latest').value;
    
    if (confirm('Delete all processes except the latest ' + keepCount + '?\n\nThis action cannot be undone!')) {
        // Show loading overlay
        document.getElementById('loadingOverlayTitle').textContent = 'Cleaning Database';
        document.getElementById('loadingOverlayMessage').textContent = 'Deleting old processes...';
        document.getElementById('globalLoadingOverlay').style.display = 'flex';
        
        // Submit form
        document.getElementById('formKeepLatest').submit();
    }
};

window.confirmDeleteAll = function() {
    if (confirm('Are you sure you want to DELETE ALL process data?\n\nThis will remove:\n- All process logs\n- All itemsets (1, 2, 3)\n- All association rules\n\nThis action CANNOT be undone!')) {
        // Show loading overlay
        document.getElementById('loadingOverlayTitle').textContent = 'Cleaning Database';
        document.getElementById('loadingOverlayMessage').textContent = 'Deleting all process data...';
        document.getElementById('globalLoadingOverlay').style.display = 'flex';
        
        // Submit form
        document.getElementById('formDeleteAll').submit();
    }
};
</script>