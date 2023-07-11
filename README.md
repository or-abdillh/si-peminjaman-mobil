# Dokumentasi: Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital dengan Framework Laravel 10

- [Dokumentasi: Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital dengan Framework Laravel 10](#dokumentasi-sistem-informasi-peminjaman-mobil-bertanda-tangan-digital-dengan-framework-laravel-10)
	- [1. Pendahuluan](#1-pendahuluan)
		- [Deskripsi sistem informasi](#deskripsi-sistem-informasi)
		- [Tujuan dokumentasi](#tujuan-dokumentasi)
		- [Lingkup sistem informasi](#lingkup-sistem-informasi)
	- [2. Persiapan](#2-persiapan)
		- [Persyaratan sistem](#persyaratan-sistem)
		- [Instalasi dan konfigurasi](#instalasi-dan-konfigurasi)
		- [Konfigurasi database](#konfigurasi-database)
		- [Pengaturan Tambahan](#pengaturan-tambahan)
	- [3. Arsitektur Sistem](#3-arsitektur-sistem)
		- [Arsitektur MVC (Model-View-Controller)](#arsitektur-mvc-model-view-controller)
			- [1. Model](#1-model)
			- [2. View](#2-view)
			- [3. Controller](#3-controller)
		- [Struktur direktori](#struktur-direktori)
		- [Penjelasan komponen utama (Model, View, Controller)](#penjelasan-komponen-utama-model-view-controller)
			- [1. Model](#1-model-1)
			- [2. View](#2-view-1)
		- [3. Controller](#3-controller-1)
			- [Admin Controllers](#admin-controllers)
			- [Auth Controllers](#auth-controllers)
			- [Deputy Controllers](#deputy-controllers)
			- [Manager Controllers](#manager-controllers)
			- [User Controllers](#user-controllers)
			- [Profile Controller](#profile-controller)
			- [Signature Controller](#signature-controller)
		- [Penjelasan mekanisme routing](#penjelasan-mekanisme-routing)
			- [1. Definisi Route](#1-definisi-route)
			- [2. Group Route](#2-group-route)
			- [3. Resourceful Routing](#3-resourceful-routing)
			- [4. Method dalam Controller](#4-method-dalam-controller)
	- [4. Fitur-fitur](#4-fitur-fitur)
		- [4.1. Autentikasi Pengguna](#41-autentikasi-pengguna)
		- [4.2. Manajemen Peminjaman Mobil](#42-manajemen-peminjaman-mobil)
		- [4.3. Tanda Tangan Digital](#43-tanda-tangan-digital)
		- [4.4. Manajemen Pelanggan](#44-manajemen-pelanggan)
	- [5. Model Data](#5-model-data)
	- [6. Pengujian](#6-pengujian)
	- [7. Konfigurasi Tambahan](#7-konfigurasi-tambahan)
	- [8. Penanganan Kesalahan](#8-penanganan-kesalahan)
	- [9. Pemeliharaan dan Perawatan](#9-pemeliharaan-dan-perawatan)
	- [10. Kontribusi](#10-kontribusi)
	- [11. Lisensi](#11-lisensi)
	- [12. Referensi](#12-referensi)


## 1. Pendahuluan

### Deskripsi sistem informasi
Sistem informasi berbasis web yang digunakan dalam membantu proses pengajuan peminjaman unit mobil pada SMP SMA Global Islamic Boarding School (GIBS) yang menerapkan teknologi tanda tangan digital berbasis gambar (Digital Signature) pada proses legalisir pengajuan peminjaman unit mobil 

Sistem informasi ini mengambi studi kasus pada Kantor Tata Usaha / Administrasi dan General Service (GS) SMP SMA Global Islamic Boarding School (GIBS) 

### Tujuan dokumentasi
Pembuatan dokumentasi ini bertujuan untuk membantu proses hand over atau peralihan user maupun developer menjadi lebih mudah dan cepat serta dengan harapan user maupun developer dapat memahami semua alur dan logika yang digunakan pada sistem informasi ini, sehingga tidak menutup keadanya pengembangan lebih lanjut dari sistem informasi ini

### Lingkup sistem informasi
Lingkup sistem informasi peminjaman mobil bertanda tangan digital menggunakan framework Laravel 10 mencakup beberapa aspek berikut:

1. Peminjaman Mobil: Sistem ini mepengguna untuk melakukan peminjaman mobil. Pengguna dapat melihat daftar mobil yang tersedia, memilih mobil yang ingin dipinjam, dan mengajukan permohonan peminjaman.
2. Manajemen Peminjaman: Sistem ini mencakup fitur-fitur manajemen peminjaman, seperti persetujuan peminjaman, penjadwalan pengambilan dan pengembalian mobil.
3. Tanda Tangan Digital: Sistem ini mepengguna untuk melakukan tanda tangan digital sebagai tanda persetujuan dan konfirmasi atas peminjaman mobil. Tanda tangan digital yang dibuat oleh pengguna akan disimpan dan dihubungkan dengan peminjaman yang terkait

## 2. Persiapan
### Persyaratan sistem
Sistem informasi ini menggunakan framework Laravel versi 10, menggunakan PHP versi 8, dan menggunakan MySQL sebagai database management sytem (DBMS)

### Instalasi dan konfigurasi
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

Menjalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Menjalankan server

```bash
php artisan serve
```

### Konfigurasi database
Konfigurasi database dapat ditemukan pada `.env` yang memiliki konfigurasi default sebagai berikut:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_mobil
DB_USERNAME=root
DB_PASSWORD=
```
Lakukan perubahan pada konfigurasi jika terdapat perbedaan pada konfirgurasi bawaan dari sistem operasi atau DBMS yang digunakan

### Pengaturan Tambahan
Jalankan perintah berikut untuk membuat sub direktori baru pada `storage` yang digunakan dalam menyimpan hasil upload dokumen, profile picture, dan signature dari user

```bash
mkdir storage/app/public/attachments && mkdir storage/app/public/pictures && mkdir storage/app/public/signatures
```

Jika kesulitan dalam menggunakan command line, pembuatan sub direktori baru bisa dilakukan dengan menggunakan bantuan file explorer dengan membuat folder baru `attachments`, `pictures`, dan `signatures` pada `storage/app/public`

## 3. Arsitektur Sistem

### Arsitektur MVC (Model-View-Controller)
Sistem ini dibangun menggunakan Arsitektur MVC yaitu sebuah pendekatan dalam pengembangan perangkat lunak yang memisahkan logika bisnis, tampilan, dan interaksi pengguna menjadi tiga komponen terpisah. Arsitektur ini bertujuan untuk meningkatkan pemeliharaan kode, memisahkan perhatian terhadap berbagai aspek sistem, dan mepengembangan yang lebih terstruktur.

#### 1. Model
Model merupakan komponen yang bertanggung jawab untuk mengelola data dan logika bisnis dalam aplikasi. Model mewakili struktur data dan berisi operasi-operasi yang berkaitan dengan manipulasi data, validasi, dan aturan bisnis. Model tidak bergantung pada tampilan atau interaksi pengguna, dan dapat digunakan kembali dalam berbagai bagian aplikasi.

#### 2. View
View merupakan komponen yang mengatur tampilan antarmuka pengguna (UI) dan menampilkan informasi kepada pengguna. View bertanggung jawab untuk mengubah data dari Model menjadi tampilan yang dapat ditampilkan pengguna. View tidak mengandung logika bisnis, tetapi hanya fokus pada cara menampilkan data yang diberikan.

#### 3. Controller
Controller merupakan komponen yang bertanggung jawab untuk menerima input dari pengguna, memproses permintaan, dan berinteraksi dengan Model dan View. Controller menerima input dari pengguna melalui View, mengubah Model berdasarkan input tersebut, dan memperbarui tampilan yang ditampilkan oleh View. Controller juga mengatur alur logika bisnis dalam aplikasi.

### Struktur direktori
Sistem informasi ini dibangun menggunakan framework Laravel sehingga memiliki struktur direktori default atau bawaan dari Laravel, berikut struktur direktori utama dalam di sistem:

```
si-peminjaman-mobil
|--- app
|   |--- Http
|   |	|--- Controllers
|   |	|	|--- Admin
|   |	|	|--- Deputy
|   |	|	|--- Manager
|   |	|	|--- User
|   |--- Models
|   |--- public
|   |--- resources
|   |	|--- views
|   |	|	|--- pages
|   |	|	|	|--- admin
|   |	|	|	|--- deputy
|   |	|	|	|--- manager
|   |	|	|	|--- profile
|   |	|	|	|--- signature
|   |	|	|	|--- user
|   |	|	|--- dashboard.blade.php
|   |--- routes
|   |--- storage
|   |	|--- app
|   |	|	|--- public
|   |	|	|	|--- attachments
|   |	|	|	|--- pictures
|   |	|	|	|--- signatures
|-- .env
```

### Penjelasan komponen utama (Model, View, Controller)

#### 1. Model
Model merupakan representasi dari tabel pada database, pada sistem informasi ini file file model dapat ditemukan pada `app/Models`

```
si-peminjaman-mobil
|	|-- app
|	|	|-- Models
|	|	|	|-- Activity.php
|	|	|	|-- Car.php
|	|	|	|-- Feedback.php
|	|	|	|-- Letter.php
|	|	|	|-- Participant.php
|	|	|	|-- Signature.php
|	|	|	|-- User.php
|	|	|	|-- UserManager.php
|	|	|	|-- Validation.php
```

#### 2. View
View merupakan komponen yang bertanggung jawab dalam menampilkan output dari hasil pengolahan data oleh controller kepada user. 

Sistem informasi ini menerapkan beberapa role / tipe pengguna yang telah dibahas [disini](#41-autentikasi-pengguna), sehingga struktur direktori untuk View pada sistem ini akan menyesuaikan dengan role / tipe penggunanya

Berikut struktur direktori komponen utama View di dalam sistem ini:

```
si-peminjaman-mobil
|	|-- resources
|	|	|-- views
|	|	|	|-- auth
|	|	|	|	|-- login.blade.php
|	|	|	|	|-- register.blade.php
|	|	|	|-- layouts
|	|	|	|	|-- soft-ui
|	|	|	|	|	|-- auth
|	|	|	|	|	|	|-- login.blade.php
|	|	|	|	|	|	|-- register.blade.php
|	|	|	|	|	|-- app.blade.php
|	|	|	|-- pages
|	|	|	|	|-- admin
|	|	|	|	|-- deputy
|	|	|	|	|-- manager
|	|	|	|	|-- profile
|	|	|	|	|-- signature
|	|	|	|	|-- user
|	|	|	|-- dashboard.blade.php
```

View dalam struktur direktori tersebut ditempatkan di dalam direktori `resources/views`. Direktori views menyimpan file-file tampilan antarmuka pengguna yang akan ditampilkan kepada pengguna. Berikut adalah beberapa sub-direktori yang ada di dalam views:

1. `auth`: Direktori ini berisi tampilan terkait dengan otentikasi pengguna seperti login dan registrasi. Dalam direktori auth, terdapat file `login.blade.php` dan `register.blade.php` yang bertanggung jawab untuk menampilkan formulir login dan registrasi.
2. `layouts`: Direktori ini berisi tampilan layout yang digunakan secara umum dalam aplikasi. Di dalam `layouts`, ada direktori `soft-ui` yang kemudian memiliki sub-direktori `auth`. Dalam sub-direktori `auth`, terdapat file `login.blade.php` dan `register.blade.php` yang digunakan untuk tampilan otentikasi dengan layout khusus.
3. `pages`: Direktori ini berisi tampilan halaman-halaman tertentu dalam aplikasi. Terdapat beberapa sub-direktori seperti `admin`, `deputy`, `manager`, `profile`, `signature`, dan `user` yang berisi tampilan halaman terkait dengan peran pengguna atau fitur tertentu dalam sistem.
4. `dashboard.blade.php`: File ini berisi tampilan halaman dashboard yang merupakan halaman utama aplikasi setelah pengguna berhasil masuk.

### 3. Controller
Controller dalam aplikasi ini berada di dalam direktori app/Http/Controllers dan bertanggung jawab untuk menangani logika bisnis dan merespons permintaan pengguna. Struktur direktori Controller memisahkan berbagai peran dan fitur dalam aplikasi. 

Sistem informasi ini menerapkan beberapa role / tipe pengguna yang telah dibahas [disini](#41-autentikasi-pengguna), sehingga struktur direktori untuk Controller pada sistem ini akan menyesuaikan dengan role / tipe penggunanya

Berikut adalah penjelasan untuk setiap Controller dalam struktur tersebut:
```
si-peminjaman-mobil
|	|-- app
|	|	|-- Http
|	|	|	|-- Controllers
|	|	|	|	|-- Admin
|	|	|	|	|	|-- ArchieveController.php
|	|	|	|	|	|-- CarController.php
|	|	|	|	|	|-- DashboardController.php
|	|	|	|	|	|-- FeedbackController.php
|	|	|	|	|	|-- LetterController.php
|	|	|	|	|	|-- UserController.php
|	|	|	|	|	|-- ValidationController.php
|	|	|	|	|-- Auth
|	|	|	|	|	|-- LoginController.php
|	|	|	|	|	|-- RegisterController.php
|	|	|	|	|-- Deputy
|	|	|	|	|	|-- DashboardController.php
|	|	|	|	|	|-- ValidationController.php
|	|	|	|	|-- Manager
|	|	|	|	|	|-- DashboardController.php
|	|	|	|	|	|-- EmployeeController.php
|	|	|	|	|	|-- ValidationController.php
|	|	|	|	|-- User
|	|	|	|	|	|-- DashboardController.php
|	|	|	|	|	|-- LetterController.php
|	|	|	|	|-- ProfileController.php
|	|	|	|	|-- SignatureController.php
```

#### Admin Controllers
1. `ArchieveController.php`: Controller ini bertanggung jawab untuk mengelola arsip surat pada peran admin. berisi tindakan (action) untuk menampilkan daftar arsip surat, mengelola kategori surat, dan lainnya.
2. `CarController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan mobil pada peran admin. berisi tindakan untuk menampilkan daftar mobil, menambahkan mobil baru, mengedit atau menghapus data mobil, dan sebagainya.
3. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran admin. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan manajemen peminjaman mobil.
4. `FeedbackController.php`: Controller ini bertanggung jawab untuk mengelola umpan balik terkait dengan peminjaman mobil pada peran admin. berisi tindakan untuk menampilkan daftar umpan balik, memproses umpan balik, dan mengirim tanggapan kepada pengguna.
5. `LetterController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan surat pada peran admin. berisi tindakan untuk menampilkan daftar surat, menambahkan surat baru, mengedit atau menghapus data surat, dan sebagainya.
6. `UserController.php`: Controller ini mengatur logika bisnis yang terkait dengan pengelolaan pengguna pada peran admin. berisi tindakan untuk menampilkan daftar pengguna, mengedit atau menghapus data pengguna, dan sebagainya.
7. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran admin. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi, dan memberikan legalisir tanda tangan.

#### Auth Controllers
1. `LoginController.php`: Controller ini bertanggung jawab untuk mengelola proses otentikasi dan login pengguna. berisi tindakan untuk menampilkan halaman login, memvalidasi informasi login, dan mengautentikasi pengguna.
2. `RegisterController.php`: Controller ini menangani proses pendaftaran pengguna baru. berisi tindakan untuk menampilkan halaman registrasi, memvalidasi informasi pendaftaran, dan menyimpan data pengguna baru ke dalam sistem.

#### Deputy Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran deputy. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan tugas dan tanggung jawab deputy.
2. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran deputy. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi oleh deputy, menyetujui atau menolak peminjaman, dan sebagainya.

#### Manager Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran manager. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan tugas dan tanggung jawab manager.
2. `EmployeeController.php`: Controller ini bertanggung jawab untuk mengelola data karyawan pada peran manager. berisi tindakan untuk menampilkan daftar karyawan, menambahkan karyawan baru, mengedit atau menghapus data karyawan, dan sebagainya.
3. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran manager. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi oleh manager berupa pemberian tanda tangan.

#### User Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran pengguna. berisi tindakan untuk menampilkan informasi pribadi, riwayat peminjaman, atau akses ke fitur-fitur lainnya yang relevan dengan peran pengguna.
2. `LetterController.php`: Controller ini bertanggung jawab untuk mengelola peminjaman surat pada peran pengguna. berisi tindakan untuk menampilkan daftar surat yang dapat dipinjam, membuat peminjaman surat, melihat status peminjaman, dan sebagainya.

#### Profile Controller
`ProfileController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan profil pengguna pada peran pengguna. berisi tindakan untuk menampilkan profil pengguna, mengedit atau memperbarui data pengguna, dan sebagainya.

#### Signature Controller
`SignatureController.php`: Controller ini bertanggung jawab untuk mengelola tanda tangan digital pengguna pada peran pengguna. berisi tindakan untuk menampilkan halaman tanda tangan, menyimpan tanda tangan yang diunggah, dan sebagainya.

### Penjelasan mekanisme routing
Routing adalah proses menentukan bagaimana aplikasi web merespons permintaan HTTP yang masuk dari pengguna. Routing menghubungkan URL dengan tindakan (action) yang sesuai dalam Controller untuk menangani permintaan tersebut.

Dalam aplikasi ini, mekanisme routing diimplementasikan menggunakan framework Laravel. Framework ini menyediakan sintaks dan fitur yang kuat untuk mengatur routing dengan mudah dan efisien.

Routing yang digunakan pada aplikasi ini bisa ditemui pada file `routes/web.php`

#### 1. Definisi Route
Route adalah aturan yang menghubungkan URL dengan tindakan dalam Controller yang akan dijalankan. Setiap route memiliki URL dan metode HTTP tertentu yang akan memicu tindakan yang sesuai dalam Controller.

Secara umum, definisi route terdiri dari URL, metode HTTP, dan tindakan yang akan dilakukan. Berikut adalah contoh definisi route pada sistem:

```php
Route::post('/profile/picture', [ProfileController::class, 'changeProfilePicture'])->name('profile.picture.change');
```

#### 2. Group Route
Grup route digunakan untuk mengelompokkan route yang memiliki karakteristik atau atribut yang sama. Ini mekita untuk menerapkan middleware, namespace, prefix, dan lainnya secara terpusat. Berikut adalah contoh penggunaan grup route didalam sistem:

```php
Route::group(['middleware' => ['auth', 'role:deputy']], function () {

    Route::get('/deputy', [DeputyDashboardController::class, 'index'])->name('deputy.dashboard.index');
    Route::resource('/deputy/validation', DeputyValidationController::class)->names('deputy.validation');
});
```
Pada contoh kode di atas, kita menggunakan `Route::group` untuk membuat grup route dengan middleware yang ditentukan. Middleware digunakan untuk menerapkan filter atau tindakan sebelum atau setelah menjalankan tindakan dalam `Controller`. Dalam contoh ini, kita menggunakan middleware `auth` dan `role:deputy` untuk memastikan pengguna yang mengakses route tersebut sudah terotentikasi dan memiliki peran sebagai `deputy`.

#### 3. Resourceful Routing
Pada kode berikut, sistem menggunakan `Route::resource` untuk mendefinisikan route yang mengikuti pola CRUD (Create, Read, Update, Delete) untuk beberapa komponen seperti `car`, `user`, `letter`, `feedback`, dan `validation`. Resourceful routing secara otomatis menghasilkan rute dan tindakan dalam Controller yang sesuai dengan pola CRUD yang ditentukan.

```php
Route::resource('/admin/car', AdminCarController::class)->names('admin.car');
Route::resource('/admin/user', AdminUserController::class)->names('admin.user');
Route::resource('/admin/letter', AdminLetterController::class)->names('admin.letter');
Route::resource('/admin/letter/feedback', AdminFeedbackController::class)->names('admin.letter.feedback');
Route::resource('/admin/validation', AdminValidationController::class)->names('admin.validation');
```

#### 4. Method dalam Controller
Pada kode diatas juga menunjukkan contoh penggunaan tindakan dalam Controller yang akan dipanggil saat route tertentu diakses. Misalnya, `AdminDashboardController` memiliki method `index` yang akan dijalankan saat URL `/admin` diakses. Hal yang sama berlaku untuk `AdminCarController`, `AdminUserController`, `AdminLetterController`, `AdminFeedbackController`, `AdminValidationController`, dan `AdminArchiveController` yang masing-masing memiliki method yang sesuai untuk setiap operasi CRUD yang didefinisikan.


## 4. Fitur-fitur

### 4.1. Autentikasi Pengguna

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.2. Manajemen Peminjaman Mobil

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.3. Tanda Tangan Digital

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.4. Manajemen Pelanggan

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

## 5. Model Data

- Deskripsi struktur database
- Penjelasan setiap tabel dan kolom
- Relasi antar tabel
- Contoh kode migrasi

## 6. Pengujian

- Rencana pengujian
- Penjelasan skenario pengujian
- Contoh kode pengujian

## 7. Konfigurasi Tambahan

- Konfigurasi penyimpanan tanda tangan digital
- Konfigurasi pengiriman email
- Pengaturan lainnya yang diperlukan

## 8. Penanganan Kesalahan

- Daftar kesalahan yang umum terjadi
- Solusi dan tindakan perbaikan

## 9. Pemeliharaan dan Perawatan

- Tugas pemeliharaan rutin
- Pembaruan dan peningkatan sistem
- Monitoring dan optimisasi performa

## 10. Kontribusi

- Panduan kontribusi
- Prosedur pengiriman pull request

## 11. Lisensi

- Jenis lisensi yang digunakan
- Informasi hak cipta

## 12. Referensi

- Referensi dan sumber daya tambahan
- Dokumentasi resmi Laravel 10

<br>
Last Edited 11/07/2023