# Dokumentasi: Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital dengan Framework Laravel 10

- [Dokumentasi: Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital dengan Framework Laravel 10](#dokumentasi-sistem-informasi-peminjaman-mobil-bertanda-tangan-digital-dengan-framework-laravel-10)
	- [1. Pendahuluan](#1-pendahuluan)
		- [1.1. Deskripsi sistem informasi](#11-deskripsi-sistem-informasi)
		- [1.2. Tujuan dokumentasi](#12-tujuan-dokumentasi)
		- [1.3. Lingkup sistem informasi](#13-lingkup-sistem-informasi)
	- [2. Persiapan](#2-persiapan)
		- [2.1. Persyaratan sistem](#21-persyaratan-sistem)
		- [2.2. Instalasi dan konfigurasi](#22-instalasi-dan-konfigurasi)
		- [2.3. Konfigurasi database](#23-konfigurasi-database)
		- [2.4. Pengaturan Tambahan](#24-pengaturan-tambahan)
	- [3. Arsitektur Sistem](#3-arsitektur-sistem)
		- [3.1. Arsitektur MVC (Model-View-Controller)](#31-arsitektur-mvc-model-view-controller)
			- [3.1.1. Model](#311-model)
			- [3.1.2. View](#312-view)
			- [3.1.3. Controller](#313-controller)
		- [3.2. Struktur direktori](#32-struktur-direktori)
		- [3.3. Penjelasan komponen utama (Model, View, Controller)](#33-penjelasan-komponen-utama-model-view-controller)
			- [3.3.1. Model](#331-model)
			- [3.3.2. View](#332-view)
			- [3.3.3. Controller](#333-controller)
				- [3.3.3.1. Admin Controllers](#3331-admin-controllers)
				- [3.3.3.2. Auth Controllers](#3332-auth-controllers)
				- [3.3.3.3. Deputy Controllers](#3333-deputy-controllers)
				- [3.3.3.4. Manager Controllers](#3334-manager-controllers)
				- [3.3.3.5. User Controllers](#3335-user-controllers)
				- [3.3.3.6. Profile Controller](#3336-profile-controller)
				- [3.3.3.7. Signature Controller](#3337-signature-controller)
		- [3.4. Penjelasan mekanisme routing](#34-penjelasan-mekanisme-routing)
			- [3.4.1. Definisi Route](#341-definisi-route)
			- [3.4.2. Group Route](#342-group-route)
			- [3.4.3. Resourceful Routing](#343-resourceful-routing)
			- [3.4.4. Method dalam Controller](#344-method-dalam-controller)
	- [4. Fitur-fitur](#4-fitur-fitur)
		- [4.1 Role / Tipe Pengguna](#41-role--tipe-pengguna)
			- [4.1.1 Deeskripsi Fitur](#411-deeskripsi-fitur)
			- [4.1.2 Alur Kerja](#412-alur-kerja)
				- [4.1.2.1 Instalasi](#4121-instalasi)
				- [4.1.2.2 Membuat Role Pengguna](#4122-membuat-role-pengguna)
			- [4.1.3 Contoh Kode Penggunaan](#413-contoh-kode-penggunaan)
		- [4.2. Autentikasi Pengguna](#42-autentikasi-pengguna)
		- [4.3. Manajemen Peminjaman Mobil](#43-manajemen-peminjaman-mobil)
		- [4.4. Tanda Tangan Digital](#44-tanda-tangan-digital)
		- [4.5. Manajemen Pelanggan](#45-manajemen-pelanggan)
	- [5. Model Data](#5-model-data)
	- [6. Pengujian](#6-pengujian)
	- [7. Konfigurasi Tambahan](#7-konfigurasi-tambahan)
	- [8. Penanganan Kesalahan](#8-penanganan-kesalahan)
	- [9. Pemeliharaan dan Perawatan](#9-pemeliharaan-dan-perawatan)
	- [10. Kontribusi](#10-kontribusi)
	- [11. Lisensi](#11-lisensi)
	- [12. Referensi](#12-referensi)


## 1. Pendahuluan

### 1.1. Deskripsi sistem informasi
Sistem informasi berbasis web yang digunakan dalam membantu proses pengajuan peminjaman unit mobil pada SMP SMA Global Islamic Boarding School (GIBS) yang menerapkan teknologi tanda tangan digital berbasis gambar (Digital Signature) pada proses legalisir pengajuan peminjaman unit mobil 

Sistem informasi ini mengambi studi kasus pada Kantor Tata Usaha / Administrasi dan General Service (GS) SMP SMA Global Islamic Boarding School (GIBS) 

### 1.2. Tujuan dokumentasi
Pembuatan dokumentasi ini bertujuan untuk membantu proses hand over atau peralihan user maupun developer menjadi lebih mudah dan cepat serta dengan harapan user maupun developer dapat memahami semua alur dan logika yang digunakan pada sistem informasi ini, sehingga tidak menutup keadanya pengembangan lebih lanjut dari sistem informasi ini

### 1.3. Lingkup sistem informasi
Lingkup sistem informasi peminjaman mobil bertanda tangan digital menggunakan framework Laravel 10 mencakup beberapa aspek berikut:

1. Peminjaman Mobil: Sistem ini mepengguna untuk melakukan peminjaman mobil. Pengguna dapat melihat daftar mobil yang tersedia, memilih mobil yang ingin dipinjam, dan mengajukan permohonan peminjaman.
2. Manajemen Peminjaman: Sistem ini mencakup fitur-fitur manajemen peminjaman, seperti persetujuan peminjaman, penjadwalan pengambilan dan pengembalian mobil.
3. Tanda Tangan Digital: Sistem ini mepengguna untuk melakukan tanda tangan digital sebagai tanda persetujuan dan konfirmasi atas peminjaman mobil. Tanda tangan digital yang dibuat oleh pengguna akan disimpan dan dihubungkan dengan peminjaman yang terkait

## 2. Persiapan
### 2.1. Persyaratan sistem
Sistem informasi ini menggunakan framework Laravel versi 10, menggunakan PHP versi 8, dan menggunakan MySQL sebagai database management sytem (DBMS)

### 2.2. Instalasi dan konfigurasi
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

### 2.3. Konfigurasi database
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

### 2.4. Pengaturan Tambahan
Jalankan perintah berikut untuk membuat sub direktori baru pada `storage` yang digunakan dalam menyimpan hasil upload dokumen, profile picture, dan signature dari user

```bash
mkdir storage/app/public/attachments && mkdir storage/app/public/pictures && mkdir storage/app/public/signatures
```

Jika kesulitan dalam menggunakan command line, pembuatan sub direktori baru bisa dilakukan dengan menggunakan bantuan file explorer dengan membuat folder baru `attachments`, `pictures`, dan `signatures` pada `storage/app/public`

## 3. Arsitektur Sistem

### 3.1. Arsitektur MVC (Model-View-Controller)
Sistem ini dibangun menggunakan Arsitektur MVC yaitu sebuah pendekatan dalam pengembangan perangkat lunak yang memisahkan logika bisnis, tampilan, dan interaksi pengguna menjadi tiga komponen terpisah. Arsitektur ini bertujuan untuk meningkatkan pemeliharaan kode, memisahkan perhatian terhadap berbagai aspek sistem, dan mepengembangan yang lebih terstruktur.

#### 3.1.1. Model
Model merupakan komponen yang bertanggung jawab untuk mengelola data dan logika bisnis dalam aplikasi. Model mewakili struktur data dan berisi operasi-operasi yang berkaitan dengan manipulasi data, validasi, dan aturan bisnis. Model tidak bergantung pada tampilan atau interaksi pengguna, dan dapat digunakan kembali dalam berbagai bagian aplikasi.

#### 3.1.2. View
View merupakan komponen yang mengatur tampilan antarmuka pengguna (UI) dan menampilkan informasi kepada pengguna. View bertanggung jawab untuk mengubah data dari Model menjadi tampilan yang dapat ditampilkan pengguna. View tidak mengandung logika bisnis, tetapi hanya fokus pada cara menampilkan data yang diberikan.

#### 3.1.3. Controller
Controller merupakan komponen yang bertanggung jawab untuk menerima input dari pengguna, memproses permintaan, dan berinteraksi dengan Model dan View. Controller menerima input dari pengguna melalui View, mengubah Model berdasarkan input tersebut, dan memperbarui tampilan yang ditampilkan oleh View. Controller juga mengatur alur logika bisnis dalam aplikasi.

### 3.2. Struktur direktori
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

### 3.3. Penjelasan komponen utama (Model, View, Controller)

#### 3.3.1. Model
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

#### 3.3.2. View
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

#### 3.3.3. Controller
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

##### 3.3.3.1. Admin Controllers
1. `ArchieveController.php`: Controller ini bertanggung jawab untuk mengelola arsip surat pada peran admin. berisi tindakan (action) untuk menampilkan daftar arsip surat, mengelola kategori surat, dan lainnya.
2. `CarController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan mobil pada peran admin. berisi tindakan untuk menampilkan daftar mobil, menambahkan mobil baru, mengedit atau menghapus data mobil, dan sebagainya.
3. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran admin. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan manajemen peminjaman mobil.
4. `FeedbackController.php`: Controller ini bertanggung jawab untuk mengelola umpan balik terkait dengan peminjaman mobil pada peran admin. berisi tindakan untuk menampilkan daftar umpan balik, memproses umpan balik, dan mengirim tanggapan kepada pengguna.
5. `LetterController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan surat pada peran admin. berisi tindakan untuk menampilkan daftar surat, menambahkan surat baru, mengedit atau menghapus data surat, dan sebagainya.
6. `UserController.php`: Controller ini mengatur logika bisnis yang terkait dengan pengelolaan pengguna pada peran admin. berisi tindakan untuk menampilkan daftar pengguna, mengedit atau menghapus data pengguna, dan sebagainya.
7. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran admin. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi, dan memberikan legalisir tanda tangan.

##### 3.3.3.2. Auth Controllers
1. `LoginController.php`: Controller ini bertanggung jawab untuk mengelola proses otentikasi dan login pengguna. berisi tindakan untuk menampilkan halaman login, memvalidasi informasi login, dan mengautentikasi pengguna.
2. `RegisterController.php`: Controller ini menangani proses pendaftaran pengguna baru. berisi tindakan untuk menampilkan halaman registrasi, memvalidasi informasi pendaftaran, dan menyimpan data pengguna baru ke dalam sistem.

##### 3.3.3.3. Deputy Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran deputy. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan tugas dan tanggung jawab deputy.
2. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran deputy. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi oleh deputy, menyetujui atau menolak peminjaman, dan sebagainya.

##### 3.3.3.4. Manager Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran manager. berisi tindakan untuk menampilkan informasi statistik, data penting, atau laporan terkait dengan tugas dan tanggung jawab manager.
2. `EmployeeController.php`: Controller ini bertanggung jawab untuk mengelola data karyawan pada peran manager. berisi tindakan untuk menampilkan daftar karyawan, menambahkan karyawan baru, mengedit atau menghapus data karyawan, dan sebagainya.
3. `ValidationController.php`: Controller ini bertanggung jawab untuk mengelola validasi peminjaman mobil pada peran manager. berisi tindakan untuk menampilkan daftar peminjaman yang perlu divalidasi oleh manager berupa pemberian tanda tangan.

##### 3.3.3.5. User Controllers
1. `DashboardController.php`: Controller ini mengatur logika bisnis yang terkait dengan tampilan dashboard untuk peran pengguna. berisi tindakan untuk menampilkan informasi pribadi, riwayat peminjaman, atau akses ke fitur-fitur lainnya yang relevan dengan peran pengguna.
2. `LetterController.php`: Controller ini bertanggung jawab untuk mengelola peminjaman surat pada peran pengguna. berisi tindakan untuk menampilkan daftar surat yang dapat dipinjam, membuat peminjaman surat, melihat status peminjaman, dan sebagainya.

##### 3.3.3.6. Profile Controller
`ProfileController.php`: Controller ini menangani logika bisnis terkait dengan pengelolaan profil pengguna pada peran pengguna. berisi tindakan untuk menampilkan profil pengguna, mengedit atau memperbarui data pengguna, dan sebagainya.

##### 3.3.3.7. Signature Controller
`SignatureController.php`: Controller ini bertanggung jawab untuk mengelola tanda tangan digital pengguna pada peran pengguna. berisi tindakan untuk menampilkan halaman tanda tangan, menyimpan tanda tangan yang diunggah, dan sebagainya.

### 3.4. Penjelasan mekanisme routing
Routing adalah proses menentukan bagaimana aplikasi web merespons permintaan HTTP yang masuk dari pengguna. Routing menghubungkan URL dengan tindakan (action) yang sesuai dalam Controller untuk menangani permintaan tersebut.

Dalam aplikasi ini, mekanisme routing diimplementasikan menggunakan framework Laravel. Framework ini menyediakan sintaks dan fitur yang kuat untuk mengatur routing dengan mudah dan efisien.

Routing yang digunakan pada aplikasi ini bisa ditemui pada file `routes/web.php`

#### 3.4.1. Definisi Route
Route adalah aturan yang menghubungkan URL dengan tindakan dalam Controller yang akan dijalankan. Setiap route memiliki URL dan metode HTTP tertentu yang akan memicu tindakan yang sesuai dalam Controller.

Secara umum, definisi route terdiri dari URL, metode HTTP, dan tindakan yang akan dilakukan. Berikut adalah contoh definisi route pada sistem:

```php
Route::post('/profile/picture', [ProfileController::class, 'changeProfilePicture'])->name('profile.picture.change');
```

#### 3.4.2. Group Route
Grup route digunakan untuk mengelompokkan route yang memiliki karakteristik atau atribut yang sama. Ini mekita untuk menerapkan middleware, namespace, prefix, dan lainnya secara terpusat. Berikut adalah contoh penggunaan grup route didalam sistem:

```php
Route::group(['middleware' => ['auth', 'role:deputy']], function () {

    Route::get('/deputy', [DeputyDashboardController::class, 'index'])->name('deputy.dashboard.index');
    Route::resource('/deputy/validation', DeputyValidationController::class)->names('deputy.validation');
});
```
Pada contoh kode di atas, kita menggunakan `Route::group` untuk membuat grup route dengan middleware yang ditentukan. Middleware digunakan untuk menerapkan filter atau tindakan sebelum atau setelah menjalankan tindakan dalam `Controller`. Dalam contoh ini, kita menggunakan middleware `auth` dan `role:deputy` untuk memastikan pengguna yang mengakses route tersebut sudah terotentikasi dan memiliki peran sebagai `deputy`.

#### 3.4.3. Resourceful Routing
Pada kode berikut, sistem menggunakan `Route::resource` untuk mendefinisikan route yang mengikuti pola CRUD (Create, Read, Update, Delete) untuk beberapa komponen seperti `car`, `user`, `letter`, `feedback`, dan `validation`. Resourceful routing secara otomatis menghasilkan rute dan tindakan dalam Controller yang sesuai dengan pola CRUD yang ditentukan.

```php
Route::resource('/admin/car', AdminCarController::class)->names('admin.car');
Route::resource('/admin/user', AdminUserController::class)->names('admin.user');
Route::resource('/admin/letter', AdminLetterController::class)->names('admin.letter');
Route::resource('/admin/letter/feedback', AdminFeedbackController::class)->names('admin.letter.feedback');
Route::resource('/admin/validation', AdminValidationController::class)->names('admin.validation');
```

#### 3.4.4. Method dalam Controller
Pada kode diatas juga menunjukkan contoh penggunaan tindakan dalam Controller yang akan dipanggil saat route tertentu diakses. Misalnya, `AdminDashboardController` memiliki method `index` yang akan dijalankan saat URL `/admin` diakses. Hal yang sama berlaku untuk `AdminCarController`, `AdminUserController`, `AdminLetterController`, `AdminFeedbackController`, `AdminValidationController`, dan `AdminArchiveController` yang masing-masing memiliki method yang sesuai untuk setiap operasi CRUD yang didefinisikan.


## 4. Fitur-fitur

### 4.1 Role / Tipe Pengguna
Pada sistem ini menggunakan library [Laravel Spatie Permission](https://spatie.be/docs/laravel-permission/v5/introduction) untuk membuat dan mengelola tipe pengguna yang ada didalam sistem ini. Adapun untuk tipe pengguna yang berlaku didalam aplikasi ini adalah
1. Admin
2. User / Pemohon
3. Manager / Atasan Pemohon
4. Deputy / Kepala Sekolah

#### 4.1.1 Deeskripsi Fitur
Fitur ini memungkinkan Anda untuk mengelola peran pengguna dan hak akses mereka menggunakan Spatie Permission. Anda dapat membuat, mengedit, dan menghapus peran pengguna, serta menetapkan hak akses spesifik untuk setiap peran. Fitur ini memungkinkan Anda untuk mengatur dan mengendalikan tingkat akses pengguna dalam aplikasi Anda.

#### 4.1.2 Alur Kerja
Berikut adalah alur kerja dari penggunaan Spatie Permission ke dalam sistem

##### 4.1.2.1 Instalasi
Menggunakan Composer untuk melakukan instalasi library ke dalam sistem
```bash
 composer require spatie/laravel-permission
```

Menambahkan service provider baru ke dalam `config/app.php`
```php
'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
```

Menjalankan perintah untuk melakukan publish 
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Melakukan penambahan trait pada model User di `app/Models/User.php`
```php
use HasRoles;
```

Menjalankan Migrasi bawaan dari Spatie Permission
```bash
php artisan migrate
```

Secara otomatis akan terjadi penambahan beberapa tabel baru pada database yang digunakan Spatie Permission dalam menjalankan fiturnya. Berikut adalah beberapa tabel baru yang akan di `create` secara otomatis oleh Spatie
1. `model_has_permission`,
2. `model_has_roles`
3. `permissions`
4. `roles`
5. `roles_has_permissions`

##### 4.1.2.2 Membuat Role Pengguna
Dengan menggunakan Spatie Permission kita dapat membuat bebeapa `role` atau tipe pengguna sesuai dengan kebutuhan sistem. Untuk membuat role pengguna kita dapat menggunakan fitur `Seeder` pada Laravel.

Berikut `seeder` yang digunakan oleh sistem dalam membuat role pengguna pada file `database/seeders/RoleSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roles = ['user', 'manager', 'deputy', 'admin'];

        foreach($roles as $role) {
            Role::create(["name" => $role]);
        }
    }
}
```
Pada kode diatas kita menggunakan model `Role` dengan melakukan import model dari `Spatie\Permission\Models\Role`, dimana model ini merupakan model bawaan dari Spatie yang digunakan dalam menyimpan berbagai tipe pengguna ke dalam tabel `roles`

Variable `$roles` menyimpan `array` yang berisikan nama - nama dari tipe pengguna yang ingin digunakan di dalam sistem. Variabel ini akan di `loop` menggunakan method `foreach` yang secara satu per satu akan melakukan `create` role baru ke dalam model `Role` melalui syntax dibawah ini, dimana `$role` merepresentasikan tiap - tiap isi array pada variabel `$roles` 

```php
Role::create(["name" => $role]);
```

Untuk memasukkan tipe role tersebut ke dalam tabel `roles` maka jalankan perintah berikut pada Command Prompt
```bash
php artisan db:seed --class=RoleSeeder
```
#### 4.1.3 Contoh Kode Penggunaan
1). Membuat akun khusus untuk admin. Kode berikut berada pada `database/seeders/AdminSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::create([
            "name" => "Administrator Tata Usaha",
            "password" => bcrypt('12345678'),
            "email" => "admin@gmail.com",
            "position" => "Adminstrator TU"
        ]);

        $admin->assignRole('admin');
    }
}
```
Pada kode diatas sistem akan membuat akun atau user baru dengan `name` Administrator Tata Usaha, `password` 12345678, `email` admin@gmail.com, dan `position` Administrator TU.

Pada kode diatas juga ditunjukkan bagaimana menerapkan `role` pengguna kepada user tertentu menggunakan kode `assignRole('nama-role')`, dimana pada kasus ini sistem akan menerapkan `role` pengguna admin pada akun atau user tersebut

2). Mendaftarkan akun baru melalui halaman `register`. Contoh kode berikut dapat ditemui pada `app/Http/Controllers/Auth/RegisterController.php`

```php
protected function create(array $data)
{
	$user = User::create([
		'name' => $data['name'],
		'email' => $data['email'],
		'password' => Hash::make($data['password'])
	]);

	$user->assignRole('user');

	return $user;
}
```
Berdasarkan kode diatas, setiap user yang melakukan pendaftaran akun baru melalui halaman `register` akan secara otomatis diterapkan `role` pengguna sebagai `user` melalui kode `$user->assignRole('user')`

3). Mengetahui tipe role pengguna dari user tertentu. Kode berikut dapat ditemui pada `resources/views/includes/breadcrumb.blade.php`

```html
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
    	<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ auth()->user()->roles->first()->name }}</a></li>
		...
    </ol>
</nav>
```

Pada kode diatas digunakan untuk menampilkan informasi mengenai tipe pengguna user yang saat ini sedang login di sistem, kemudian menampilkannya ke dalam `view`. 

Kode yang digunakan adalah
```php
auth()->user()->roles->first()->name;
```

### 4.2. Autentikasi Pengguna

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.3. Manajemen Peminjaman Mobil

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.4. Tanda Tangan Digital

- Deskripsi fitur
- Alur kerja
- Route terkait
- Contoh kode penggunaan

### 4.5. Manajemen Pelanggan

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
Last Edited 14/07/2023