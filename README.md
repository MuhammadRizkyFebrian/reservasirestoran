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

**Copy dan Atur Env**

```bash
# Buat file .env baru dengan konten berikut:
cat > .env << 'EOL'
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
```

**Key Generate**

```bash
  php artisan key:generate
```

## Jalankan Web

```bash
  php artisan serve
```

<div align="center">
  <p><sub>Copyright © 2025 Seatify – All rights reserved.</sub></p>
</div>
