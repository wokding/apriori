<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt mr-2"></i><?= $title; ?>
        </h1>
    </div>

    <!-- Welcome Section -->
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body text-white p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="h3 font-weight-bold mb-2">
                        <i class="fas fa-chart-line mr-2"></i>DATA MINING SYSTEM
                    </h2>
                    <h4 class="h5 mb-2">Implementasi Data Mining Penjualan Obat Bebas</h4>
                    <h5 class="h6 mb-2">dengan Algoritma Apriori</h5>
                    <p class="mb-0">
                        <i class="fas fa-building mr-2"></i>Studi Kasus: Apotek Kimia Farma Summarecon Bekasi
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="fas fa-database" style="font-size: 5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Database Size Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Database Size
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $total_size = 0;
                                foreach ($stats['sizes'] as $size) {
                                    $total_size += $size;
                                }
                                echo number_format($total_size, 2) . ' MB';
                                ?>
                            </div>
                            <small class="text-muted">Total Size</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Records Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Records
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php 
                                $total_records = $stats['process_log'] + $stats['itemset1'] + 
                                                $stats['itemset2'] + $stats['itemset3'] + 
                                                $stats['confidence'] + $stats['transaksi'];
                                echo number_format($total_records);
                                ?>
                            </div>
                            <small class="text-muted">All Tables</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-success text-white">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Transaksi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Transaksi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data_transaksi; ?></div>
                            <small class="text-muted">Total Records</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-database"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hasil Proses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Hasil Proses
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $hasil_proses; ?></div>
                            <small class="text-muted">Processed Data</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-success text-white">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_user; ?></div>
                            <small class="text-muted">Registered Users</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-info text-white">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Your Role
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $nama_role['role']; ?></div>
                            <small class="text-muted">Access Level</small>
                        </div>
                        <div class="col-auto">
                            <div class="card-icon bg-warning text-white">
                                <i class="fas fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Tentang Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-primary text-white mr-3">
                                    <i class="fas fa-project-diagram"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Algoritma Apriori</h6>
                                    <small class="text-muted">Association Rule Mining</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-success text-white mr-3">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Obat Bebas</h6>
                                    <small class="text-muted">Over The Counter Medicine</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="card-icon bg-info text-white mr-3">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div>
                                    <h6 class="font-weight-bold mb-1">Market Basket Analysis</h6>
                                    <small class="text-muted">Sales Pattern Discovery</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->