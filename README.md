# TatetaGeo 🌐

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-Proprietary-gold?style=flat-square)](#)

**TatetaGeo** adalah REST API mikroservis berkinerja tinggi berbasis **Laravel 13** yang menyediakan data wilayah administrasi Indonesia secara lengkap dan terstruktur. Layanan ini mengunduh, mengindeks, menyimpan, dan menyajikan seluruh data geografis Indonesia secara offline langsung dari **Badan Pusat Statistik (BPS)**.

Dibangun untuk memberikan akses data geografis dengan waktu respons di bawah 5ms, layanan ini memastikan aplikasi klien mendapatkan data wilayah Indonesia yang akurat tanpa bergantung pada koneksi eksternal atau risiko pemblokiran IP oleh BPS.

---

## ✨ Fitur Utama

-   **Complete Indonesian Regional Data**: Data lengkap wilayah administrasi Indonesia (Provinsi, Kabupaten, Kecamatan, Kelurahan/Desa) yang diambil langsung dari `sig.bps.go.id`.
-   **Automated Data Crawler**: Sistem crawler otomatis dengan *polite delay* untuk mengunduh dan memperbarui data wilayah secara aman tanpa risiko pemblokiran IP.
-   **High-Performance Database**: Tabel relasional SQLite terindeks ketat untuk pencarian data instan dengan response time sub-5ms.
-   **Smart Name-Based Search**: REST API pencarian ID wilayah berdasarkan nama secara case-insensitive, menghilangkan kebutuhan loop rekursif di sisi klien.
-   **Secure API Authentication**: Diproteksi penuh menggunakan **Laravel Sanctum** dengan Bearer Token authentication untuk memastikan hanya klien terotorisasi yang dapat mengakses data.
-   **RESTful API Design**: Endpoint API yang konsisten, mudah diintegrasikan, dan mengikuti best practices REST API.

---

## ⚙️ Instalasi & Setup

Ikuti langkah-langkah berikut untuk menjalankan TatetaGeo di lingkungan lokal Anda.

### 1. Persiapan Awal
Kloning atau masuk ke direktori proyek dan pasang semua dependensi Composer:
```bash
composer install
```

### 2. Salin Konfigurasi Environment
Buat file `.env` dari sampel yang disediakan:
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database (SQLite)
Secara default, TatetaGeo menggunakan SQLite sebagai database lokal yang terisolasi dan cepat. Buat file database dan jalankan migrasi tabel:
```bash
# Membuat file database SQLite kosong
touch database/database.sqlite

# Menjalankan migrasi database
php artisan migrate
```

### 4. Jalankan Seeder Wilayah BPS (Crawl Data)
Jalankan perintah seeder untuk memulai proses pengunduhan otomatis data wilayah administrasi Indonesia langsung dari BPS. Proses ini dioptimalkan dengan `insertOrIgnore` sehingga aman dari bentrok data:
```bash
php artisan db:seed
```

### 5. Membuat Token API Akses (Sanctum Bearer)
Untuk membuat token autentikasi yang dapat digunakan oleh aplikasi klien seperti Aksara, buat pengguna baru terlebih dahulu, lalu hasilkan token akses melalui Artisan Tinker:
```bash
# Buka Laravel Tinker
php artisan tinker
```
Di dalam konsol Tinker, jalankan perintah berikut:
```php
// 1. Buat user admin baru
$user = \App\Models\User::create([
    'name' => 'Aksara Client',
    'email' => 'client@aksara.com',
    'password' => bcrypt('password-super-aman')
]);

// 2. Generate API token akses
$token = $user->createToken('AksaraGeoToken')->plainTextToken;

// 3. Tampilkan token
echo $token;
```
Salin *plain text token* yang muncul (misalnya `1|ntZ2FSpcVPv2W3yynxt26...`) dan pasang sebagai nilai `TATETA_GEO_TOKEN` di file `.env` aplikasi klien Anda.

---

## 🚀 Menjalankan API Service

Jalankan server TatetaGeo di port khusus (misalnya `8001`):
```bash
php artisan serve --port=8001
```

Layanan Anda kini aktif di `http://127.0.0.1:8001`.

---

## 📡 API Endpoints (v1)

Semua permintaan harus menyertakan header `Accept: application/json` dan token otorisasi Bearer:
`Authorization: Bearer <TATETA_GEO_TOKEN>`

| Method | Endpoint | Query Parameters | Keterangan |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/v1/provinces` | | Mengambil semua provinsi |
| **GET** | `/api/v1/provinces/find` | `name` | Mencari ID Provinsi berdasarkan nama |
| **GET** | `/api/v1/regencies` | `province_id` | Mengambil kabupaten berdasarkan ID Provinsi |
| **GET** | `/api/v1/regencies/find` | `name`, `province_name` (optional) | Mencari ID Kabupaten berdasarkan nama |
| **GET** | `/api/v1/districts` | `regency_id` | Mengambil kecamatan berdasarkan ID Kabupaten |
| **GET** | `/api/v1/districts/find` | `name`, `regency_name` (optional) | Mencari ID Kecamatan berdasarkan nama |

---

## 👥 Developed By

TatetaGeo dikembangkan oleh **Samasta Teknologi Nuswantara**.
