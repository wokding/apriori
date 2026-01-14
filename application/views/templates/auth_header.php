<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Login dan Registrasi Sistem Apriori Kimia Farma - Platform Data Mining untuk Analisis Penjualan Obat Bebas">
    <meta name="keywords" content="login kimia farma, apriori login, sistem farmasi, data mining apotek">
    <meta name="author" content="Kimia Farma">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= current_url(); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= current_url(); ?>">
    <meta property="og:title" content="<?= $title; ?> | Apriori - Kimia Farma">
    <meta property="og:description" content="Login dan Registrasi Sistem Apriori Kimia Farma">
    <meta property="og:image" content="<?= base_url('assets/img/kimiafarma.png'); ?>">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title; ?> | Apriori - Kimia Farma">
    <meta name="twitter:description" content="Login dan Registrasi Sistem Apriori Kimia Farma">
    <meta name="twitter:image" content="<?= base_url('assets/img/kimiafarma.png'); ?>">
    
    <!-- PWA & Mobile -->
    <meta name="theme-color" content="#667eea">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/kimiafarma.png'); ?>">
    <link rel="apple-touch-icon" href="<?= base_url('assets/img/kimiafarma.png'); ?>">
    <!-- Disable default favicon.ico lookup -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>💊</text></svg>">

    <title><?= $title; ?> | Apriori - Kimia Farma</title>

    <!-- Preload Critical Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet" onerror="this.remove()">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" onerror="this.remove()">

    <!-- Toastr for Toast Notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" onerror="this.remove()">
    
    <!-- Toast Override CSS -->
    <link href="<?= base_url('assets/'); ?>css/toast-override.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Custom Enhanced Styles -->
    <link href="<?= base_url('assets/'); ?>css/custom-style.css" rel="stylesheet">
    
    <!-- Loading Indicator Styles -->
    <link href="<?= base_url('assets/'); ?>css/loading-indicator.css" rel="stylesheet">

</head>

<body class="auth-wrapper">

<!-- Page Loading Indicator -->
<div class="page-loading-indicator" id="pageLoadingIndicator">
    <div class="loading-content">
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <div class="loading-logo">
            <i class="fas fa-capsules"></i>
        </div>
        <h3>Loading...</h3>
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
    </div>
</div>