<h1 align="center">Seatify – Aplikasi Reservasi dan Pemesanan Restaurant Berbasis Web </h1>

<h2 align="center">Aplikasi web Laravel untuk sistem reservasi dan pemesanan restoran oleh pelanggan dan admin.</h2>

## 📄 Laporan

-   [Video Presentasi](https://youtu.be/KJ2iPufUeM4?si=1o57Jr1a8oVXY0tG)
-   [Video Demo](https://youtu.be/6wJOj5lO4ig)
-   [Laporan Akhir PBL Kelompok 5 – Aplikasi Reservasi dan Pemesanan Restaurant Berbasis Web](LaporanAAS_Kel5_IF2C_Pagi.pdf)

## 👥 TEAM

-   Muhammad Rizky Febrian 3312401082
-   Muhammad Naufal Hakim 3312401088
-   Rafles Yuda Stevenses N. 3312401062
-   Sakila Ananda Putri 3312411082

## 📌 Fitur Aplikasi

-   Login untuk staf & pelanggan
-   CRUD Menu dan Reservasi
-   Pemesanan meja oleh pelanggan
-   Persetujuan reservasi oleh admin
-   Riwayat Transaksi dan Pembayaran
-   Dashboard Statistik Admin

## 🧑‍💻 Akun default

#### staf

-   username : staf1
-   password : stafpass1

#### pelanggan

-   username : Carmite
-   password : 123456789

## 💻 Cara Instalasi

**Clone Repository**

```bash
 git clone https://github.com/MuhammadRizkyFebrian/reservasirestoran.git
 cd reservasirestoran
```

## Buka Terminal Di kode Editor

**Install Dependensi**

```bash
  composer install
  composer dump-autoload
  composer update
```

**Storage Link**

```bash
  php artisan storage:link
```

**Atur Env**

Buat file `.env` baru di root proyek dan isi dengan konfigurasi berikut:

```env
APP_NAME="Seatify"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbreservasirestoran
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@gmail.com
MAIL_PASSWORD=app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

SESSION_EXPIRE_ON_CLOSE=true
```

Setelah file `.env` terbuat, ubah informasi sensitif berikut:

1. Konfigurasi email untuk OTP:

    - `MAIL_USERNAME=email@gmail.com` -> Ganti dengan email Gmail Anda
    - `MAIL_PASSWORD=app_password` -> Ganti dengan App Password dari Gmail
    - `MAIL_FROM_ADDRESS=email@gmail.com` -> Ganti dengan email Gmail Anda

2. Konfigurasi database (opsional):
    - `DB_DATABASE=dbreservasirestoran` -> Nama database bisa disesuaikan
    - `DB_USERNAME=root` -> Username database bisa disesuaikan
    - `DB_PASSWORD=` -> Password database jika ada

Terakhir, generate app key baru:

```bash
php artisan key:generate
```

## Cara Mendapatkan Gmail App Password

1. Buka [Google Account Settings](https://myaccount.google.com/)
2. Pilih "Security"
3. Aktifkan "2-Step Verification"
4. Kembali ke Security, pilih "App passwords"
5. Generate App Password untuk aplikasi baru misalnya "Laravel"
6. Salin password yang digenerate ke MAIL_PASSWORD di .env

## Jalankan Web

```bash
  php artisan serve
```

<div align="center">
  <p><sub>Copyright © 2025 Seatify – All rights reserved.</sub></p>
</div>
