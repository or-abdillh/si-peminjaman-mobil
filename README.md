# Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital 

Studi kasus Kantor Tata Usaha SMP SMA Global Islamic Boarding School (GIBS)

## Fitur Utama
Beberapa fitur utama pada sistem informasi ini adalah sebagai berikut :
- Form Pengajuan Peminjaman Online
- Tanda Tangan Digital / Image
- Monitoring Ketersediaan Unit Mobil
- Monitoring Proses Pengajuan
- Cetak Surat
## Role Pengguna
Sistem informasi ini menggunakan beberapa tipe atau role pengguna, diantaranya sebagai berikut :
- Administrator
- User / Pemohon
- Manager / Atasan Pemohon
- Deputi
## Database
Sistem informasi ini menggunakan MySQL sebagai DBMS, berikut rancangan database dari [SI Peminjaman Mobil](https://drawsql.app/teams/orabdillh/diagrams/si-peminjaman-mobil)
## Requirements
Sistem informasi ini dibangun menggunakan framework Laravel versi 10 dan menggunakan PHP versi 8.1

Menggunakan Laravel UI Bootstrap dan Spatie Role Permission sebagai Authentication Library

Admin template yang digunakan adalah [Soft UI Dashboard by Creative Team](https://www.creative-tim.com/product/soft-ui-dashboard)
## Instalasi
Ikuti langkah - langkah berikut dalam menjalankan sistem ini secara lokal di komputer

Cloning repository ini menggunakan GIT

```bash
git clone https://github.com/or-abdillh/si-peminjaman-mobil
```
```bash
cd si-peminjaman-mobil
```

Instalasi module PHP dan Laravel

```bash
composer install
```

Instalasi module Node JS

```bash
npm install
```

Persiapan environment

```bash
cp .env.example .env
```
```bash
php artisan key:generate
```
```bash
php artisan storage:link
```
```bash
php artisan optimize
```

Persiapan database / Pastikan Koneksi MySQL sudah aktif

```bash
php artisan migrate --seed
```

Menjalankan server

```bash
php artisan serve
```
Informasi akun Administrator bisa dilihat pada database/seeder/AdminSeeder.php
