<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="description" content="Data Mining Apriori - Kimia Farma">
    <meta name="author" content="Kimia Farma">
    <meta name="theme-color" content="#4e73df">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon.ico'); ?>">

    <title><?= $title; ?> | Apriori - Kimia Farma</title>

    <!-- Preload Critical Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css">
    <link href="<?= base_url('assets/'); ?>bootstrap-datepicker-1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">

    <!-- Toastr for Toast Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- Toast Override CSS -->
    <link href="<?= base_url('assets/'); ?>css/toast-override.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <!-- Custom Enhanced Styles -->
    <link href="<?= base_url('assets/'); ?>css/custom-style.css" rel="stylesheet">
    
    <!-- Mobile Responsive Enhancement -->
    <link href="<?= base_url('assets/'); ?>css/mobile-responsive.css" rel="stylesheet">
    
    <!-- Loading Skeleton Screens -->
    <link href="<?= base_url('assets/'); ?>css/loading-skeleton.css" rel="stylesheet">
    
    <!-- Loading Indicator -->
    <link href="<?= base_url('assets/'); ?>css/loading-indicator.css" rel="stylesheet">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">

</head>

<body id="page-top">
    <!-- Global Page Loading Indicator -->
    <div id="pageLoadingIndicator" class="page-loading-indicator">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <div class="loading-logo">
                <i class="fas fa-capsules"></i>
            </div>
            <h4 class="loading-text">Loading...</h4>
            <div class="loading-bar">
                <div class="loading-bar-fill"></div>
            </div>
        </div>
    </div>
    
    <!-- Offline Indicator -->
    <div class="offline-indicator">
        <i class="fas fa-wifi-slash mr-2"></i>You are offline
    </div>
    
    <!-- PWA Install Button (Hidden by default, shown by JS when installable) -->
    <button id="pwa-install-btn" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000; background: linear-gradient(135deg, #4e73df 0%, #2e59d9 100%); color: white; border: none; padding: 12px 24px; border-radius: 50px; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.4); cursor: pointer; font-weight: 600; font-size: 14px;">
        <i class="fas fa-download mr-2"></i>Install App
    </button>
    
    <!-- Page Wrapper -->
    <div id="wrapper">