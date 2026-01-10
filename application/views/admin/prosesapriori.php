<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cogs mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-sliders-h mr-2"></i>Apriori Algorithm Configuration
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/prosesapriori'); ?>" method="post" id="formApriori" 
                          data-loading="true" 
                          data-loading-title="Processing Apriori Algorithm..." 
                          data-loading-message="Calculating frequent itemsets and association rules. For large datasets (1 year+), this may take 5-30 minutes. Please do not close this window.">

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-calendar-alt mr-2 text-primary"></i>Transaction Date Range
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                </div>
                                <input type="text" name="range_tanggal" id="reservation" class="form-control daterange" placeholder="Select date range..." required />
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Select the date range for transactions to process. You can select 1 year or more - larger ranges will take longer to process (5-30 minutes).
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-percentage mr-2 text-primary"></i>Minimum Support (%)
                            </label>
                            <input class="form-control" type="number" step="0.01" name="support" placeholder="Enter minimum support (e.g., 5)" required />
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>The minimum percentage of transactions that must contain the itemset
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-chart-line mr-2 text-primary"></i>Minimum Confidence (%)
                            </label>
                            <input class="form-control" type="number" step="0.01" name="confidence" placeholder="Enter minimum confidence (e.g., 50)" required />
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle mr-1"></i>The minimum confidence level for association rules
                            </small>
                        </div>

                        <hr>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-block" id="btnSubmit" style="padding: 0.75rem;">
                                <i class="fas fa-cogs mr-2"></i>Process Data
                            </button>
                            <a href="<?= base_url('admin/hasil'); ?>" class="btn btn-secondary btn-block mt-2" style="padding: 0.75rem;">
                                <i class="fas fa-chart-bar mr-2"></i>View Results
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-lightbulb mr-2"></i>How It Works
                    </h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Apriori Algorithm Steps:</h6>
                    <ol class="pl-3 mb-4">
                        <li class="mb-2">Select transaction date range</li>
                        <li class="mb-2">Set minimum support threshold</li>
                        <li class="mb-2">Set minimum confidence threshold</li>
                        <li class="mb-2">Generate frequent itemsets</li>
                        <li class="mb-2">Generate association rules</li>
                    </ol>
                    
                    <div class="alert alert-info mb-3">
                        <small>
                            <i class="fas fa-clock mr-1"></i>
                            <strong>Processing Time Estimates:</strong><br>
                            • 1 month: ~1-2 minutes<br>
                            • 3 months: ~2-5 minutes<br>
                            • 6 months: ~5-10 minutes<br>
                            • 1 year: ~10-20 minutes<br>
                            • 2+ years: ~20-30 minutes
                        </small>
                    </div>
                    
                    <div class="alert alert-warning mb-2">
                        <small>
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <strong>Important:</strong> For larger date ranges (6+ months), use LOWER support values (0.5-1%) to get meaningful results. Higher support values may filter out too many patterns.
                        </small>
                    </div>
                    
                    <div class="alert alert-success mb-0">
                        <small>
                            <i class="fas fa-lightbulb mr-1"></i>
                            <strong>Recommended Settings:</strong><br>
                            • 1-3 months: Support 2-5%, Confidence 50%<br>
                            • 6-12 months: Support 0.5-1%, Confidence 40%<br>
                            • 1+ year: Support 0.3-0.5%, Confidence 30%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
$(document).ready(function() {
    // Form-specific handling if needed
    $('#formApriori').on('submit', function() {
        // Additional custom behavior can go here
        return true;
    });
});
</script>