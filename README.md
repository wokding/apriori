# 🛒 Apriori Data Mining System

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.2-blue.svg)](https://php.net)
[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.1.x-orange.svg)](https://codeigniter.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Active-success.svg)]()

> **Implementasi Data Mining Penjualan Obat Bebas dengan Algoritma Apriori**  
> Studi Kasus: Apotek Kimia Farma Summarecon Bekasi

## 📋 Deskripsi

Sistem Data Mining berbasis web yang mengimplementasikan **Algoritma Apriori** untuk analisis pola pembelian obat bebas di Apotek Kimia Farma. Sistem ini membantu dalam menemukan **association rules** dan pola **market basket analysis** untuk meningkatkan strategi penjualan dan penataan produk.

## ✨ Fitur Utama

- 🔐 **Sistem Autentikasi** - Login dengan role-based access control
- 📊 **Dashboard Interaktif** - Visualisasi statistik database real-time
- 💾 **Manajemen Data Transaksi** - CRUD transaksi penjualan dengan date range picker
- ⚙️ **Mining Process** - Pemrosesan Algoritma Apriori dengan konfigurasi support & confidence
- 📈 **Visualisasi Hasil** - Tampilan itemset dan association rules dengan metrik lengkap
- 🔍 **Analisis Detail** - Support, confidence, dan lift untuk setiap aturan asosiasi
- 🗑️ **Database Cleanup** - Manajemen data proses mining dengan statistik ukuran database
- 👥 **User Management** - Manajemen user dan role access
- 📱 **Responsive Design** - Bootstrap 4 dengan SB Admin template

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
| **Libraries** | PhpSpreadsheet, MPDF, Daterangepicker |
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
- Pilih process log yang ingin dilihat
- Analisis itemset dan association rules
- Export hasil ke PDF

### 4. Database Cleanup
- Buka **Database Cleanup**
- Lihat statistik database
- Pilih jumlah proses yang ingin disimpan
- Hapus data lama untuk performa optimal

## 📊 Screenshot

### Dashboard
![Dashboard](docs/screenshots/dashboard.png)

### Mining Process
![Mining](docs/screenshots/mining.png)

### Results
![Results](docs/screenshots/results.png)

## 🤝 Kontribusi

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

## 📄 License

Proyek ini dilisensikan di bawah [MIT License](LICENSE) - lihat file LICENSE untuk detail.

## 👨‍💻 Author

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
