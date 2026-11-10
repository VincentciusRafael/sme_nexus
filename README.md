# SME Nexus

**SME Nexus** adalah aplikasi berbasis web yang dikembangkan menggunakan Laravel 12 untuk mendukung pengelolaan profil UMKM serta proses intelligence dan collaboration dalam satu platform.

## Teknologi

- PHP 8.2 atau lebih baru
- Laravel 12
- MySQL / MariaDB
- Composer
- HTML, CSS, dan JavaScript
- Laravel Eloquent ORM

## Persyaratan Sistem

Pastikan perangkat sudah memiliki:

- PHP >= 8.2
- Composer
- MySQL atau MariaDB
- Ekstensi PHP: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `fileinfo`, dan `json`
- Git

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/VincentciusRafael/sme_nexus.git
cd sme_nexus
```

### 2. Install Dependency Laravel

Folder `vendor/` tidak disertakan dalam repository. Buat kembali dependency menggunakan Composer:

```bash
composer install
```

### 3. Konfigurasi Environment

Buat file `.env` dari template:

```bash
cp .env.example .env
```

Buka `.env`, lalu sesuaikan konfigurasi aplikasi dan database:

```env
APP_NAME="SME Nexus"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sme
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password database dengan konfigurasi MySQL/MariaDB masing-masing.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Persiapkan Database

Buat database dengan nama:

```sql
CREATE DATABASE db_sme;
```

Impor file backup database SME Nexus (`.sql`) melalui phpMyAdmin atau MySQL client.

Contoh menggunakan terminal:

```bash
mysql -u root -p db_sme < nama_file_backup.sql
```

Ganti `nama_file_backup.sql` dengan lokasi file backup database yang disediakan.

**Catatan:** Impor backup database terlebih dahulu apabila menggunakan database yang sudah berisi struktur tabel dan data. Jangan menjalankan `migrate:fresh` karena perintah tersebut menghapus seluruh tabel dan data.

### 6. Persiapkan Storage

```bash
php artisan storage:link
```

### 7. Bersihkan Cache Konfigurasi

```bash
php artisan optimize:clear
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Buka aplikasi melalui:

http://127.0.0.1:8000

## Frontend dan Asset

Versi project ini menggunakan asset CSS dan JavaScript yang sudah tersedia pada source code.

Untuk menjalankan aplikasi sesuai konfigurasi asset saat ini, tidak diperlukan proses `npm install`, `npm run dev`, maupun `npm run build`.

## Struktur Project

```text
sme_nexus/
├── app/
│   ├── Modules/
│   └── Shared/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

## Catatan Penting

- File `.env` tidak disertakan karena berisi konfigurasi lokal dan informasi sensitif.
- Folder `vendor/` tidak disertakan karena dapat dibuat kembali melalui Composer.
- File `composer.lock` disertakan untuk menjaga konsistensi versi dependency.
- Database harus disiapkan dan diimpor sebelum aplikasi dijalankan.
- Jangan menggunakan `migrate:fresh` pada database yang sudah berisi data penting.
- Untuk deployment production, ubah `APP_ENV` menjadi `production` dan `APP_DEBUG` menjadi `false`.
- Jangan membagikan password database, application key, atau API key ke repository publik.

## Pengembang

**SME Nexus**  
Laravel-based SME Management Platform

Repository: https://github.com/VincentciusRafael/sme_nexus
