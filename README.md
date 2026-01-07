# 🛒 Apriori Data Mining System

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.2-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.1.x-orange.svg)](https://codeigniter.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-success.svg)]()
[![PWA](https://img.shields.io/badge/PWA-Ready-blueviolet.svg)]()
[![Mobile](https://img.shields.io/badge/Mobile-Responsive-success.svg)]()

> **Implementasi Data Mining Penjualan Obat Bebas dengan Algoritma Apriori**  
> Studi Kasus: Apotek Kimia Farma Summarecon Bekasi  
> ✨ **Enhanced with Modern UI/UX & PWA Support**

## 📋 Deskripsi

Sistem Data Mining berbasis web yang mengimplementasikan **Algoritma Apriori** untuk analisis pola pembelian obat bebas di Apotek Kimia Farma. Sistem ini membantu dalam menemukan **association rules** dan pola **market basket analysis** untuk meningkatkan strategi penjualan dan penataan produk.

## ✨ Fitur Utama

### 🎯 Core Features
- 🔐 **Sistem Autentikasi** - Login dengan role-based access control
- 📊 **Dashboard Interaktif** - Visualisasi statistik database real-time
- 💾 **Manajemen Data Transaksi** - CRUD transaksi penjualan dengan date range picker
- ⚙️ **Mining Process** - Pemrosesan Algoritma Apriori dengan konfigurasi support & confidence
- 📈 **Visualisasi Hasil** - Tampilan itemset dan association rules dengan metrik lengkap
- 🔍 **Analisis Detail** - Support, confidence, dan lift untuk setiap aturan asosiasi
- 🗑️ **Database Cleanup** - Manajemen data proses mining dengan statistik ukuran database
- 👥 **User Management** - Manajemen user dan role access

### ✨ UI/UX Enhancements (NEW!)
- 📱 **100% Mobile Responsive** - Touch-friendly interface untuk Android & iOS
- 🚀 **Progressive Web App (PWA)** - Install ke home screen, offline capable
- 👆 **Touch Gestures** - Swipe navigation, pull-to-refresh, haptic feedback
- ⏳ **Loading Skeletons** - Smooth loading animations untuk better UX
- 🔌 **Offline Support** - Tetap accessible tanpa internet connection
- 🎨 **Modern UI** - Enhanced dengan animations dan microinteractions
- ♿ **Accessibility** - WCAG compliant untuk semua users
- ⚡ **Performance Optimized** - Fast loading dengan service worker caching

## 🎯 Algoritma Apriori

### Cara Kerja
1. **Itemset Generation** - Mencari frequent itemsets dengan minimum support
2. **Rule Generation** - Membuat association rules dari frequent itemsets
3. **Metrics Calculation** - Menghitung support, confidence, dan lift

### Optimasi Performa
- ⚡ Pre-computed pair counts untuk itemset-2
- ⚡ Pre-computed triplet counts untuk itemset-3
- ⚡ Single-pass counting untuk dataset besar
- ⚡ Execution time: 1800 detik, Memory limit: 1024MB

## 🛠️ Teknologi

| Kategori | Stack |
|----------|-------|
| **Backend** | PHP 7.2+, CodeIgniter 3.1.x |
| **Database** | MySQL 5.7+ |
| **Frontend** | Bootstrap 4, jQuery, Font Awesome |
| **UI/UX** | Mobile-Responsive CSS, Touch Gestures, Loading Skeletons |
| **PWA** | Service Worker, Web App Manifest, Offline Support |
| **Libraries** | PhpSpreadsheet, MPDF, Daterangepicker, DataTables |
| **Server** | Apache/Nginx, PHP-FPM |

## 📦 Instalasi

### Prasyarat
```bash
- PHP >= 7.2
- MySQL >= 5.7
- Composer
- Apache/Nginx
- Git
```

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/wokding/apriori.git
cd apriori
```

2. **Install Dependencies**
```bash
composer install
```

3. **Konfigurasi Database**
```bash
# Copy file konfigurasi
cp application/config/database.php.sample application/config/database.php

# Edit database.php dan sesuaikan:
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'your_username',
    'password' => 'your_password',
    'database' => 'db_apriori',
);
```

4. **Import Database**
```bash
mysql -u root -p < database/db_apriori.sql
```

5. **Set Permissions**
```bash
chmod -R 755 application/cache
chmod -R 755 application/logs
chmod -R 755 assets/uploads
```

6. **Jalankan Server**
```bash
# Development server
php -S localhost:8000

# Atau gunakan Apache/Nginx
```

7. **Akses Aplikasi**
```
URL: http://localhost:8000
Default Login:
- Email: admin@admin.com
- Password: admin123
```

### 🎨 Setup UI/UX Enhancement (Optional)

Fitu📚 Documentation Files
- **[UI-UX-ENHANCEMENT-GUIDE.md](UI-UX-ENHANCEMENT-GUIDE.md)** - Dokumentasi lengkap UI/UX enhancements
- **[QUICK-START-UIUX.md](QUICK-START-UIUX.md)** - Quick reference untuk UI/UX features
- **[GIT-GITHUB-GUIDE.md](GIT-GITHUB-GUIDE.md)** - Git workflow & GitHub deployment guide
- **[CONTRIBUTING.md](CONTRIBUTING.md)** - Contribution guidelines

### Struktur Folder
```
apriori/
├── application/          # CodeIgniter application
│   ├── controllers/      # Controller files
│   ├── models/          # Model files (Apriori logic)
│   ├── views/           # View templates
│   └── config/          # Configuration files
├── assets/              # Static assets
│   ├── css/            # Stylesheets + mobile-responsive.css ⭐
│   ├── js/             # JavaScript + mobile-enhancement.js ⭐
│   ├── img/            # Images
│   └── uploads/        # User uploads
├── database/           # SQL files
├── system/             # CodeIgniter core
├── vendor/             # Composer dependencies
├── manifest.json       # PWA manifest ⭐
├── service-worker.js   # Service Worker ⭐
└── offline.html        # Offline fallback page ⭐
```
*⭐ = New enhancement files* iPhone SE, 12 Pro (iOS)
# - Samsung Galaxy S20 (Android)
# - iPad Air (Tablet)
```

3. **Enable PWA** (Production dengan HTTPS)
```bash
# Service Worker hanya aktif di:
# - localhost (development)
# - HTTPS domain (production)

# Check PWA status:
# Chrome DevTools → Application tab → Manifest & Service Workers
```

4. **Read Documentation**
```bash
# Lengkap: UI-UX-ENHANCEMENT-GUIDE.md
# Quick:   QUICK-START-UIUX.md
# Git:     GIT-GITHUB-GUIDE.md
```

## 📖 Dokumentasi

### Struktur Folder
```
apriori/
├── application/          # CodeIgniter application
│   ├── controllers/      # Controller files
│   ├── models/          # Model files (Apriori logic)
│   ├── views/           # View templates
│   └── config/          # Configuration files
├── assets/              # Static assets
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   ├── img/            # Images
│   └── uploads/        # User uploads
├── database/           # SQL files
├── system/             # CodeIgniter core
└── vendor/             # Composer dependencies
```

### Konfigurasi Mining

Edit parameter di **Proses Apriori** page:
```php
Minimum Support: 10-50%    // Threshold itemset frequency
Minimum Confidence: 60-90% // Threshold rule reliability
Date Range: Custom range   // Filter transaksi by date
```

### Database Schema

**Tabel Utama:**
- `transaksi` - Data transaksi penjualan
- `process_log` - Log proses mining
- `itemset1/2/3` - Frequent itemsets
- `confidence` - Association rules
- `user` - Data pengguna
- `user_role` - Role management

## 🚀 Penggunaan

### 1. Input Data Transaksi
- Navigasi ke **Data Transaksi**
- Tambah transaksi dengan ID, tanggal, produk, dan total
- Import dari Excel/CSV (opsional)

### 2. Proses Mining
- Buka **Proses Apriori**
- Set minimum support dan confidence
- Pilih date range transaksi
- Klik **Start Mining Process**
- Tunggu hingga proses selesai (progress indicator tersedia)

### 3. Lihat Hasil
- Navigasi ke **Hasil**
- Pilih process s

### Desktop View
![Dashboard](docs/screenshots/dashboard.png)

### Mobile View (NEW!)
<p align="center">
  <img src="docs/screenshots/mobile-dashboard.png" width="300" alt="Mobile Dashboard">
  <img src="docs/screenshots/mobile-menu.png" width="300" alt="Mobile Menu">
</p>

### PWA Install (NEW!)
<p align="center">
  <img src="docs/screenshots/pwa-install.png" width="300" alt="PWA Install">
  <img src="docs/screenshots/offline-page.png" width="300" alt="Offline Page">
</p>

### Mining Process
![Mining](docs/screenshots/mining.png)

### Results & Analyticta lama untuk performa optimal

## 📊 Screenshot

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Mining Process
![Mining](docs/screenshots/mining.png)

### Results
![Results](docs/screenshots/results.png)

## 🤝 Kontribusi
1.0] - 2026-01-07
- ✨ **Major UI/UX Enhancement**
- 📱 Added mobile-responsive CSS (100% mobile compatible)
- 🚀 Implemented Progressive Web App (PWA) support
- 👆 Added touch gestures & mobile optimization
- ⏳ Added loading skeleton screens
- 🔌 Added offline support & service worker
- 📚 Comprehensive documentation (3 new MD files)
- 🎨 Enhanced animations & microinteractions
- ⚡ Performance optimization with caching

### [1.
Kontribusi sangat diterima! Silakan baca [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan lengkap.

### Quick Start untuk Kontributor
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 Changelog

### [1.0.0] - 2026-01-07
- ✨ Initial release
- 🎯 Implementasi Algoritma Apriori
- 📊 Dashboard dengan statistik real-time
- ⚡ Optimasi performa mining process
- 🎨 UI/UX improvements dengan Bootstrap 4

## 🐛 Bug Reports

Jika menemukan bug, silakan [buat issue](https://github.com/wokding/apriori/issues) dengan detail:
- Deskripsi bug
- Langkah untuk reproduce
- Expected behavior
- Screenshots (jika ada)
- Environment (OS, PHP version, etc)
✨ Features Highlight

### 🏆 Lighthouse Scores (Target)
- 🚀 Performance: **85+**
- ♿ Accessibility: **90+**
- 🎯 Best Practices: **90+**
- 📱 PWA: **90+**
- 🔍 SEO: **85+**

### 📱 Mobile Compatibility
- ✅ Android 10+ (Chrome 80+)
- ✅ iOS 13+ (Safari 13+)
- ✅ Tablet & Desktop
- ✅ Touch-friendly interface (44x44px buttons)
- ✅ Swipe gestures & haptic feedback
- ✅ Responsive tables (card-style on mobile)

### 🚀 PWA Features
- ✅ Install to home screen
- ✅ Offline functionality
- ✅ Fast loading (service worker cache)
- ✅ App-like experience
- ✅ Push notification ready
- ✅ Background sync ready

### ⚡ Performance
- Fast loading dengan service worker caching
- Lazy loading untuk images
- Optimized assets (CSS/JS)
- Database query optimization
- GZIP compression support

## 🙏 Acknowledgments

- [CodeIgniter](https://codeigniter.com) - PHP Framework
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [SB Admin](https://startbootstrap.com/theme/sb-admin-2) - Admin Template
- [Font Awesome](https://fontawesome.com) - Icons
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io) - Excel handling
- [PWA Builder](https://www.pwabuilder.com/) - PWA tools & resources
**Ade Naufal Rianto**
- GitHub: [@wokding](https://github.com/wokding)
- Institution: Apotek Kimia Farma Summarecon Bekasi

## 🙏 Acknowledgments

- [CodeIgniter](https://codeigniter.com) - PHP Framework
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [SB Admin](https://startbootstrap.com/theme/sb-admin-2) - Admin Template
- [Font Awesome](https://fontawesome.com) - Icons
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io) - Excel handling
- Apotek Kimia Farma Summarecon Bekasi - Data & Case Study

## 📞 Support

Jika memerlukan bantuan:
- 📧 Email: adenaufalr@example.com
- 💬 [GitHub Discussions](https://github.com/wokding/apriori/discussions)
- 🐛 [Issue Tracker](https://github.com/wokding/apriori/issues)

---

<p align="center">
  Made with ❤️ for Data Mining Research
</p>

<p align="center">
  <sub>⭐ Star this repo if you find it helpful!</sub>
</p>
