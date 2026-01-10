# 🛒 Apriori Data Mining System

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.1-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.1.x-orange.svg)](https://codeigniter.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-success.svg)]()
[![PWA](https://img.shields.io/badge/PWA-Ready-blueviolet.svg)]()
[![Mobile](https://img.shields.io/badge/Mobile-Responsive-success.svg)]()
[![Database](https://img.shields.io/badge/MySQL-5.7+-blue.svg)](https://mysql.com)

> **Implementasi Data Mining Penjualan Obat Bebas dengan Algoritma Apriori**  
> Studi Kasus: Apotek Kimia Farma Summarecon Bekasi  
> ✨ **Enhanced with Modern UI/UX & PWA Support**

## 📋 Deskripsi

Sistem Data Mining berbasis web yang mengimplementasikan **Algoritma Apriori** untuk analisis pola pembelian obat bebas di Apotek Kimia Farma. Sistem ini membantu dalam menemukan **association rules** dan pola **market basket analysis** untuk meningkatkan strategi penjualan dan penataan produk.

### 🎯 Tujuan Sistem
- Menganalisis pola pembelian pelanggan untuk rekomendasi produk
- Menemukan produk yang sering dibeli bersamaan (frequent itemsets)
- Menghasilkan aturan asosiasi untuk strategi cross-selling dan bundling
- Membantu penataan produk di rak untuk meningkatkan penjualan

## ✨ Fitur Utama

### 🎯 Core Features
- 🔐 **Sistem Autentikasi** - Login dengan role-based access control (Admin/User)
- 📊 **Dashboard Interaktif** - Visualisasi statistik database real-time dengan metrik ukuran database
- 💾 **Manajemen Data Transaksi** - CRUD transaksi penjualan dengan date range picker dan import Excel/CSV
- ⚙️ **Mining Process** - Pemrosesan Algoritma Apriori dengan konfigurasi support & confidence (mendukung dataset 1 tahun+)
- 📈 **Visualisasi Hasil** - Tampilan itemset 1, 2, 3 dan association rules dengan metrik lengkap
- 🔍 **Analisis Detail** - Support, confidence, lift ratio, dan korelasi untuk setiap aturan asosiasi
- 📄 **Export PDF** - Generate laporan hasil mining ke PDF dengan Dompdf
- 🗑️ **Database Cleanup** - Manajemen data proses mining dengan statistik ukuran database per tabel
- 👥 **User Management** - Manajemen user, role, dan access control per menu
- 📋 **Menu Management** - Konfigurasi menu dinamis dengan role-based visibility

### ✨ UI/UX Enhancements
- 📱 **100% Mobile Responsive** - Touch-friendly interface untuk Android & iOS dengan CSS khusus (762+ lines)
- 🚀 **Progressive Web App (PWA)** - Install ke home screen, offline capable dengan service worker
- 👆 **Touch Gestures** - Swipe navigation untuk sidebar, pull-to-refresh ready
- ⏳ **Loading Indicators** - Spinner animations dengan progress bar untuk proses mining
- 🔌 **Offline Support** - Tetap accessible tanpa internet connection dengan cached assets
- 🎨 **Modern UI** - Enhanced dengan SweetAlert2 modals dan Toastr notifications
- ♿ **Accessibility** - iOS safe area support, touch target 44x44px sesuai guidelines
- ⚡ **Performance Optimized** - Fast loading dengan service worker caching dan lazy loading

## 🎯 Algoritma Apriori

### Cara Kerja
1. **Scan Data Transaksi** - Membaca semua transaksi dalam rentang tanggal yang dipilih
2. **Itemset-1 Generation** - Menghitung frekuensi setiap item dan filter dengan minimum support
3. **Itemset-2 Generation** - Menggabungkan item yang lolos untuk membuat pasangan dan filter dengan support
4. **Itemset-3 Generation** - Menggabungkan pasangan yang lolos untuk membuat triplet dan filter dengan support
5. **Rule Generation** - Membuat association rules dari frequent itemsets
6. **Metrics Calculation** - Menghitung support, confidence, lift ratio, dan korelasi

### Rumus Perhitungan
```
Support(X) = (Jumlah transaksi mengandung X / Total transaksi) × 100%
Confidence(X→Y) = (Support(X∪Y) / Support(X)) × 100%
Lift(X→Y) = Support(X∪Y) / (Support(X) × Support(Y))

Korelasi:
- Lift > 1: Korelasi Positif (produk sering dibeli bersamaan)
- Lift = 1: Tidak ada korelasi
- Lift < 1: Korelasi Negatif (produk jarang dibeli bersamaan)
```

### Optimasi Performa
- ⚡ **Pre-computed Pair Counts** - Single-pass counting untuk itemset-2
- ⚡ **Pre-computed Triplet Counts** - Efficient counting untuk itemset-3
- ⚡ **Batch Insert** - Insert data dalam batch 50 records untuk database
- ⚡ **Memory Optimization** - Smart array processing untuk dataset besar
- ⚡ **Execution Time:** 1800 detik (30 menit) max
- ⚡ **Memory Limit:** 1024MB untuk mining, 2048MB untuk view results

### Rekomendasi Parameter
| Rentang Data | Min Support | Min Confidence | Estimasi Waktu |
|--------------|-------------|----------------|----------------|
| 1-3 bulan | 2-5% | 50% | 1-2 menit |
| 3-6 bulan | 1-2% | 40% | 2-5 menit |
| 6-12 bulan | 0.5-1% | 30% | 5-15 menit |
| 1-2 tahun | 0.3-0.5% | 25% | 15-30 menit |

## 🛠️ Teknologi

| Kategori | Stack |
|----------|-------|
| **Backend** | PHP 8.1+, CodeIgniter 3.1.x |
| **Database** | MySQL 5.7+ / MariaDB 10.x+ |
| **Frontend** | Bootstrap 4.6, jQuery 3.x, Font Awesome 6.x |
| **UI/UX** | Mobile-Responsive CSS, Touch Gestures, Loading Indicators |
| **PWA** | Service Worker, Web App Manifest, Offline Support |
| **Libraries** | PhpSpreadsheet (Excel), Dompdf (PDF), Daterangepicker, DataTables Responsive |
| **Notifications** | Toastr.js, SweetAlert2 |
| **Server** | Apache/Nginx, PHP-FPM |

### 📦 Dependencies (Composer)
```json
{
    "phpoffice/phpspreadsheet": "^1.29",
    "dompdf/dompdf": "^3.0"
}
```

## 📦 Instalasi

### Prasyarat
```bash
- PHP >= 8.1 (direkomendasikan 8.3)
- Ekstensi PHP: mbstring, openssl, zip
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

> Jika menggunakan Windows/PowerShell pastikan ekstensi `mbstring`, `openssl`, dan `zip` sudah aktif di `php.ini`. Dompdf v3.x membutuhkan PHP >= 8.1.

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
Login Administrator:
- Email: administrator@gmail.com
- Password: admin123
Login Member:
- Email: userdemo@gmail.com
- Password: user123
```

## 📖 Dokumentasi

### 📚 Documentation Files
- **[CONTRIBUTING.md](CONTRIBUTING.md)** - Contribution guidelines
- **README.md** - Dokumentasi utama (file ini)

## 📂 Struktur Project

```
apriori/
├── application/                    # CodeIgniter application
│   ├── controllers/
│   │   ├── Admin.php              # Dashboard, Transaksi, Mining, Cleanup
│   │   ├── Auth.php               # Login, Register, Password Reset
│   │   ├── Menu.php               # Menu & Submenu Management
│   │   ├── User.php               # Profile & Change Password
│   │   └── Welcome.php            # Landing Page
│   ├── models/
│   │   ├── Admin_model.php        # Apriori algorithm & database operations
│   │   └── Menu_model.php         # Menu queries
│   ├── views/
│   │   ├── admin/                 # Admin pages (dashboard, mining, results)
│   │   ├── auth/                  # Authentication pages
│   │   ├── menu/                  # Menu management pages
│   │   ├── templates/             # Header, footer, sidebar
│   │   └── user/                  # User profile pages
│   ├── helpers/
│   │   ├── bulan_helper.php       # Date formatting
│   │   ├── kfa_helper.php         # Auth & session checks
│   │   └── rupiah_helper.php      # Number formatting
│   └── config/                    # Configuration files
├── assets/
│   ├── css/
│   │   ├── sb-admin-2.min.css     # SB Admin template
│   │   ├── custom-style.css       # Custom enhancements
│   │   ├── mobile-responsive.css  # Mobile CSS (762+ lines)
│   │   ├── loading-indicator.css  # Loading animations
│   │   ├── loading-skeleton.css   # Skeleton screens
│   │   └── toast-override.css     # Toastr customization
│   ├── js/
│   │   ├── sb-admin-2.min.js      # SB Admin scripts
│   │   ├── custom-enhanced.js     # Custom interactions
│   │   ├── mobile-enhancement.js  # Touch gestures & PWA (463 lines)
│   │   └── loading-indicator.js   # Loading overlay control
│   ├── vendor/                    # Frontend libraries
│   ├── img/                       # Images & logos
│   └── uploads/                   # User uploads
├── database/
│   └── db_apriori.sql            # Database schema & sample data (921 transaksi)
├── system/                        # CodeIgniter core
├── vendor/                        # Composer dependencies
├── manifest.json                  # PWA manifest
├── service-worker.js              # PWA service worker
├── offline.html                   # Offline fallback page
└── index.php                      # Entry point
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
| Tabel | Deskripsi |
|-------|-----------|
| `transaksi` | Data transaksi penjualan (id_transaksi, transaction_date, produk, total) |
| `process_log` | Log proses mining dengan process_id unik (DM-001, DM-002, dst) |
| `itemset1` | Frequent itemset tunggal dengan support dan status lolos |
| `itemset2` | Frequent itemset pasangan (2 item) |
| `itemset3` | Frequent itemset triplet (3 item) |
| `confidence` | Association rules dengan confidence, lift, dan korelasi |
| `user` | Data pengguna sistem |
| `user_role` | Role management (Admin, User) |
| `user_menu` | Konfigurasi menu utama |
| `user_sub_menu` | Konfigurasi submenu |
| `user_access_menu` | Mapping akses role ke menu |

## 🚀 Penggunaan

### 1. Input Data Transaksi
- Navigasi ke **Data Transaksi** dari sidebar
- Tambah transaksi manual dengan ID, tanggal, produk (dipisahkan koma), dan total
- **Import dari Excel/CSV:**
  - Format kolom: `id_transaksi`, `transaction_date`, `produk`, `total`
  - Format tanggal: `YYYY-MM-DD` atau `MM/DD/YYYY`
  - Produk dipisahkan dengan koma dalam satu cell

### 2. Proses Mining
- Buka **Proses Apriori** dari sidebar
- Set minimum support (%) - semakin rendah, semakin banyak itemset ditemukan
- Set minimum confidence (%) - threshold untuk association rules
- Pilih date range transaksi yang akan diproses
- Klik **Process Data** dan tunggu hingga selesai
- ⚠️ Untuk dataset besar (1 tahun+), proses bisa memakan waktu 15-30 menit

### 3. Lihat Hasil
- Navigasi ke **Hasil** untuk melihat daftar semua proses mining
- Klik pada Process ID (DM-001, DM-002, dst) untuk melihat detail
- Analisis yang tersedia:
  - **Itemset 1**: Produk individual yang sering muncul
  - **Itemset 2**: Pasangan produk yang sering muncul bersamaan
  - **Itemset 3**: Triplet produk yang sering muncul bersamaan
  - **Confidence Rules**: Aturan asosiasi dengan metrik lengkap
  - **Final Rules**: Association rules yang lolos threshold dengan lift ratio
- Export hasil ke **PDF** untuk dokumentasi atau presentasi

### 4. Database Cleanup
- Navigasi ke **Database Cleanup** untuk monitoring ukuran database
- Lihat statistik per tabel (ukuran MB dan jumlah record)
- Hapus proses mining lama untuk menjaga performa database
- Opsi: Keep latest N processes atau delete all

## 📊 Screenshot

> ℹ️ **Note**: Screenshots belum tersedia. Folder `docs/screenshots/` akan ditambahkan di update mendatang.

### Fitur yang Akan Ditampilkan:
- 🖥️ **Dashboard** - Statistik database dan overview sistem
- 📱 **Mobile View** - Responsive design di berbagai device
- ⚙️ **Mining Process** - Konfigurasi parameter Apriori
- 📈 **Results** - Visualisasi itemset dan association rules
- 📄 **PDF Export** - Contoh laporan hasil mining

## ✨ Features Highlight

### 🏆 Technical Highlights
- 🔄 **Optimized Apriori** - Pre-computed counts untuk performa tinggi
- 📊 **Scalable** - Mendukung dataset 1 tahun+ (921 transaksi sample)
- 🆔 **Smart Process ID** - Auto-regenerate sequential IDs (DM-001, DM-002)
- 📈 **Complete Metrics** - Support, Confidence, Lift, Korelasi
- 🔐 **Role-Based Access** - Kontrol akses per menu berdasarkan role
- 💾 **Batch Operations** - Efficient database operations

### 📱 Mobile Compatibility
- ✅ Android 10+ (Chrome 80+)
- ✅ iOS 13+ (Safari 13+)
- ✅ Tablet & Desktop
- ✅ Touch-friendly interface (min 44x44px touch targets)
- ✅ Swipe gestures untuk sidebar navigation
- ✅ Responsive tables dengan horizontal scroll
- ✅ iOS Safe Area support untuk notch devices

### 🚀 PWA Features
- ✅ Install to home screen (Android & iOS)
- ✅ Offline functionality dengan cached assets
- ✅ App-like experience (standalone display)
- ✅ Fast loading dengan service worker caching
- ✅ Background sync ready
- ✅ App shortcuts (Dashboard, Transaksi, Mining)

### ⚡ Performance
- Service worker caching untuk assets statis
- Lazy loading untuk data tables
- Optimized database queries dengan indexing
- Memory management untuk large datasets
- GZIP compression support

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan baca [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan lengkap.

### Quick Start untuk Kontributor
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 Changelog

### [2.1.0] - 2026-01-10
- 📤 **Project Published to GitHub**
- 📚 Complete documentation update dengan detail lengkap
- 🔧 Final code cleanup and optimization
- ✅ All features tested and verified
- 🚀 Production-ready release
- 📊 Sample data: 921 transaksi obat bebas

### [2.0.0] - 2026-01-08
- 🔧 **Major Update: PHP 8.1+ Required**
- 📦 Updated Dompdf to v3.x (security patches)
- 🔒 Enabled OpenSSL, mbstring, zip extensions
- 🖼️ Fixed PDF logo rendering dengan base64 encoding
- 📚 Updated documentation for PHP 8.1+ requirements
- ⚙️ Improved Dompdf configuration (remote images, HTML5 parser)
- 🆔 Implemented smart process_id generation (DM-001 format)
- 🗑️ Added Database Cleanup feature dengan statistik

### [1.0.0] - 2026-01-07
- ✨ Initial release
- 🎯 Implementasi Algoritma Apriori dengan optimasi
- 📊 Dashboard dengan statistik database real-time
- ⚡ Pre-computed pair/triplet counts untuk performa
- 🎨 UI/UX improvements dengan SB Admin 2 template
- 📱 Mobile responsive design (762+ lines CSS)
- 🚀 PWA support dengan service worker
- 👆 Touch gestures untuk mobile navigation
- 🔐 Role-based access control
- 📄 PDF export dengan Dompdf
- 📥 Excel/CSV import dengan PhpSpreadsheet

## 🐛 Bug Reports

Jika menemukan bug, silakan [buat issue](https://github.com/wokding/apriori/issues) dengan detail:
- Deskripsi bug
- Langkah untuk reproduce
- Expected behavior
- Screenshots (jika ada)
- Environment (OS, PHP version, etc)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Ade Naufal Rianto**
- GitHub: [@wokding](https://github.com/wokding)
- Institution: Apotek Kimia Farma Summarecon Bekasi

## 🙏 Acknowledgments

- [CodeIgniter 3](https://codeigniter.com) - PHP Framework yang ringan dan cepat
- [Bootstrap 4](https://getbootstrap.com) - CSS Framework responsive
- [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2) - Admin Dashboard Template
- [Font Awesome 6](https://fontawesome.com) - Icon library
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io) - Excel/CSV handling
- [Dompdf](https://github.com/dompdf/dompdf) - PDF generation
- [DataTables](https://datatables.net) - Interactive tables dengan responsive
- [SweetAlert2](https://sweetalert2.github.io) - Modal & dialog styling
- [Toastr.js](https://codeseven.github.io/toastr/) - Toast notifications
- [Moment.js](https://momentjs.com) - Date manipulation
- [Daterangepicker](https://www.daterangepicker.com) - Date range selection
- Apotek Kimia Farma Summarecon Bekasi - Data transaksi & Case Study

## 📞 Support

Jika memerlukan bantuan:
- 📧 Email: adenaufalr@gmail.com
- 💬 [GitHub Discussions](https://github.com/wokding/apriori/discussions)
- 🐛 [Issue Tracker](https://github.com/wokding/apriori/issues)

---

<p align="center">
  Made with ❤️ for Data Mining Research
</p>

<p align="center">
  <sub>⭐ Star this repo if you find it helpful!</sub>
</p>
