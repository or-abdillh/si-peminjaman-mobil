
# Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital 

Studi kasus Kantor Tata Usaha SMP SMA Global Islamic Boarding School (GIBS)

Daftar Isi
- [Sistem Informasi Peminjaman Mobil Bertanda Tangan Digital](#sistem-informasi-peminjaman-mobil-bertanda-tangan-digital)
	- [Fitur Utama](#fitur-utama)
	- [Role Pengguna](#role-pengguna)
	- [Database](#database)
	- [Requirements](#requirements)
	- [Instalasi](#instalasi)
	- [Struktur Project](#struktur-project)
		- [Models](#models)
		- [Controllers](#controllers)
		- [Views](#views)
		- [Storage](#storage)
	- [Fitur dan Penggunaan](#fitur-dan-penggunaan)
		- [Relasi](#relasi)
		- [Konfimasi Pengajuan oleh Pemohon](#konfimasi-pengajuan-oleh-pemohon)
		- [Konfirmasi Pengajuan oleh Admin](#konfirmasi-pengajuan-oleh-admin)
		- [Proses Legalisir Oleh Manager](#proses-legalisir-oleh-manager)
		- [Proses Legalisir Oleh Deputy](#proses-legalisir-oleh-deputy)
		- [Mengambil tanda tangan pada legalisir](#mengambil-tanda-tangan-pada-legalisir)
		- [Mengambil data karyawan dan manager](#mengambil-data-karyawan-dan-manager)


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
## Struktur Project
Terdapat beberapa sub folder, khususnya pada *Controllers* dan juga *Views* berdasarkan tipe atau role pengguna serta fitur yang bisa di akses oleh role tertentu

Ini memungkinkan untuk mempermudah proses pengembangan sistem dengan melakukan pengelompokkan logic dan tampilan yang terstruktur berdasarkan tipe pengguna 

### Models
Berisikan *class* model yang merepresentasikan bentuk dan struktur tabel pada rancangan database yang digunakan beserta relasi yang berlaku antar model

```
|_ app
|  +- Models
|  |  |_ Activity.php
|  |  |_ Car.php
|  |  |_ Feedback.php
|  |  |_ Letter.php
|  |  |_ Participant.php
|  |  |_ Signature.php
|  |  |_ User.php
|  |  |_ UserManager.php
|  |  |_ Validation.php
```

### Controllers
Setiap controller diperuntukkan menangani pemrosesan logic bisnis pada model atau fitur tertentu di masing - masing tipe pengguna

```
|_ app
|  +- Http
|  |  +- Controllers
|  |  |  +- Admin
|  |  |  |  |_ ArchiveController.php
|  |  |  |  |_ CarController.php
|  |  |  |  |_ DashboardController.php
|  |  |  |  |_ FeedbackController.php
|  |  |  |  |_ LetterController.php
|  |  |  |  |_ UserController.php
|  |  |  +- Deputy
|  |  |  |  |_ DashboardController.php
|  |  |  |  |_ ...
|  |  |  +- Manager
|  |  |  |  |_ DashboardController.php
|  |  |  |  |_ ...
|  |  |  +- User
|  |  |  |  |_ DashboardController.php
|  |  |  |  |_ ...
```

### Views
Direktori ini digunakan untuk menampilkan hasil pemrosesan logic bisnis pada controller ke dalam tampilan pengguna. Terdapat beberapa sub folder yang perlu diketahui penggunaannya :

**resources/views/includes**

Berisikan file .blade.php yang digunakan secara global pada seluruh halaman

**resources/views/layouts**

Berisikan beberapa file .blade.php dan sub folder *sott-ui* yang digunakan untuk menerapkan *styling* CSS dan struktur HTML agar tetap konsisten disetiap halaman sesuai peruntukkan

**resources/views/pages**

Diperuntukkan untuk menampilkan halaman di tiap tiap fitur. Berisikan beberapa sub folder berdasarkan tipe pengguna dan setiap sub folder di tiap tipe pengguna juga memiliki sub folder berdasarkan fitur yang dimiliki tipe pengguna tertentu

**resources/views/dashboard.blade.php**

Ini merupakan file utama dalam menampilkan halaman dashboard di setiap tipe pengguna. Tampilan pada dashboard akan menyesuaikan dengan tipe pengguna yang sedang login atau mengakses halaman dashboard.

Untuk melakukan kustomisasi data berdasarkan tipe pengguna, bisa menggunakan file DashboardController.php pada setiap sub folder berdasarkan tipe pengguna pada app/Http/Controllers yang sudah disediakan

```
resources
|_ views
|  +- includes
|  |  |_ breadcrumb.blade.php
|  |  |_ core-js.blade.php
|  |  |_ footer.blade.php
|  |  |_ head.blade.php
|  |  |_ meta.blade.php
|  |  |_ navbar.blade.php
|  |  |_ sidebar.blade.php
|  +- layouts
|  |  +- soft-ui
|  |  |  +- auth
|  |  |  |  |_ login.blade.php
|  |  |  |  |_ register.blade.php
|  |  |  |_ app.blade.php
|  |  |_ print.blade.php
|  +- pages
|  |  +- admin
|  |  |  +- archive
|  |  |  |  |_ index.blade.php
|  |  |  |_ car
|  |  |  |_ letter
|  |  |  |_ user
|  |  |  |_ validation
|  |  |_ deputy
|  |  |_ manager
|  |  |_ profile
|  |  |_ signature
|  |  |_ user
|  |_ dashboard.blade.php
```

### Storage

Direktori ini digunakan dalam menyimpan file hasil dari fitur rekam tanda tangan digital, fitur upload lampiran pengajuan, dan upload profile picture pengguna.

```
|_ storage
|  +- app
|  |  +- public
|  |  |  +- attachments
|  |  |  |  |_ 647435c8cbe92.pdf
|  |  |  |_ pictures
|  |  |  +- signatures
|  |  |  |  |_ 6474237ad0840.jpg
```
Direktori ini secara otomatis akan dibuatkan *symbolic link* ke direktori public saat menjalankan perintah `php artisan storage:link`, sehingga proses pemanggilan file bisa menggunakan method ` asset() `
```html
  <img src="{{ asset('storage/signatures/6474237ad0840.jpg') }}" />
  <img src="{{ asset('storage/pictures/' . auth()->user()->picture) }}" />
  <a href="{{ asset('storage/attachments/647435c8cbe92.pdf') }}">Lihat lampiran</a>
  ```

## Fitur dan Penggunaan
Pada section ini akan dijelaskan mengenai beberapa fitur yang telah di implementasikan ke dalam sistem beserta contoh penggunaanya

### Relasi
Setiap model yang memiliki relasi baik itu *one-to-many* maupun *one-to-one* telah didefinisikan pada model, sehingga proses pemanggilan model yang menggunakan *query inner join* bisa menggunakan contoh kode berikut

```php
public function index()
{
	// ambil data user berdasarkan id sama dengan 1
	$user = User::findOrFail(1);
	// ambil semua surat yang pernah diajukan oleh si user
	$letters = $user->letters;
}
```
Kode diatas akan mempersingkat penulisan syntax dalam melakukan query inner join, berbeda dengan contoh kode berikut, hasilnya sama namun jauh lebih rumit dalam penulisan
```php
public function index()
{
	// ambil data user berdasarkan id sama dengan 1
	$user = User::findOrFail(1);
	// ambil semua surat yang pernah diajukan oleh si user
	$letters = Letter::where('user_id', $user->id)->get();	
}
```
Selain digunakan pada logic bisnis, bisa juga digunakan pada view yang diinginkan, contoh kode sebagai berikut :
```blade
@foreach( $letters as $letter )
<p>{{ $loop->iteration }}. Pengajuan pada kegiatan {{ $letter->name }} diajukan oleh {{ $letter->user?->name }}
@endforeach
```
Contoh kode diatas akan menampilkan list surat yang telah terinput menjadi kalimat
 ``1. Pengajuan pada kegiatan Seleksi O2SN diajukan oleh Mr. Danang Suhardjo``
 dan seterusnya hingga semua data telah semuanya di render

### Konfimasi Pengajuan oleh Pemohon
Sistem ini memungkinkan untuk menghapus data atau record pada tabel secara sementara atau tidak permanen, sehingga bisa dilakukan recovery kembali pada data yang telah terhapus. Pada sistem ini, model `Letter` telah menerapkan `soft delete`, dapat dilihat pada `app/Models/Letter.php` :

`Soft delete` ini digunakan pada fitur konfirmasi pengajuan, yang dimana pada saat user atau pemohon melakukan konfirmasi terhadap pengajuan yang mereka ajukan, baik itu berstatus diterima maupun ditolak, maka sistem akan menandai pengajuan tersebut agar tidak lagi ditampilkan pada halaman pengajuan serta sekaligus sebagai penanda bahwa proses peminjaman telah selesai

Contoh penggunaan nya adalah sebagai berikut
```php
public function confirmation($id)
{
	// ambil surat pengajuan berdasarkan $id
	$letter = Letter::findOrFail($id);
	// lakukan soft delete, sebagai penanda bahwa surat sudah dikonfirmasi balik oleh pemohon
	$letter->delete(); 
}
```
Dengan menggunakan kode diatas maka surat tersebut terhapus tidak secara permanen. Namun, jika ingin melakukan hapus permanen bisa menggunakan opsi lain yaitu, `$letter->forceDelete()`

### Konfirmasi Pengajuan oleh Admin

Pada studi kasus yang diangkat, setiap pengajuan yang dikirimkan oleh pemohon harus dilakukan konfirmasi terlebih dahulu oleh Admin, yaitu dengan mempertimbangkan kelengkapan form pengajuan yang diterima, bukti lampiran jika ada, serta memastikan apakah ada unit mobil yang tersedia. Jika semua dirasa sesuai dan masih ada unit mobil yang tersedia, maka admin bisa melakukan konfirmasi pengajuan tersebut.

Pada model `Letter` menyimpan informasi `car_id` yaitu data mengenai unit mobil yang akan digunakan oleh pemohon berdasarkan pengajuan. Pada saat pengajuan dikirimkan field `car_id` sengaja tidak diisikan atau bernilai `null` agar sistem bisa melakukan pendeteksian bahwa pengajuan tersebut masih belum di konfirmasi oleh admin.

Berikut contoh kode dalam menangani proses konfirmasi pengajuan oleh admin
```php
<?php

public function update(Request $request, String $id)
{
	// validasi request yang masuk
	$validate = $request->validate([
		'user_id'  =>  'required|numeric',
		'car_id'  =>  'required|numeric'
	]);
	
	// cek apakah user sudah memiliki tanda tangan digital
	$signature =  Signature::where('user_id', $validate['user_id'])->first();
	if (!$signature) return 'anda belum melakukan perekaman tanda tangan';

	// cek apakah user memiliki atasan
	$managers = UserManager::where('user_id', $validate['user_id'])->get();
	if (count($managers) == 0) return 'anda belum memiliki data atasan';

	// ambil surat pengajuan yang ingin di konfirmasi berdasarkan $id
	$letter = Letter::findOrFail($id);

	// ambil data unit mobil yang akan digunakan
	$car =  Car::findOrFail($validate['car_id']);

	// masukkan id dari $car ke dalam $letter
	$letter->update(['car_id'  => $car->id]);

	// ubah status dari unit mobil tersebut menjadi true atau sedang terpakai
	$car->update(['status'  =>  true]);

	// membuat data legalisir untuk surat pengajuan ini
	Validation::create([
		'letter_id'  => $letter->id,
		'applicant_signature'  => $signature->id,
		'deputy_signature'  =>  null,
		'manager_signature'  =>  null
	]);
}
```
Pada kode diatas sistem akan melakukan pengecekan terlebih dahulu apakah pemohon telah memiliki tanda tangan digital atau data atasan yang valid.

Pada saat semua pengecekan berhasil dilewati, maka sistem akan secara otomatis melakukan update status pada unit mobil yang digunakan menjadi "sedang digunakan". Sistem akan membuat data legalisir baru untuk surat pengajuan tersebut yang dimana untuk pengisian `deputy_signature`  dan `manager_signature` sengaja di beri nilai `null` karena untuk pemberian nilai pada kedua field tersebut hanya bisa dilakukan oleh `Deputy` dan `manager` si pemohon.

### Proses Legalisir Oleh Manager 
User yang login dan memliki tipe pengguna `manager`, akan diberikan fitur berupa legalisir pengajuan. Pada fitur ini sistem akan menampilkan semua pengajuan peminjaman mobil yang telah di konfirmasi oleh Admin sebelumnnya yang diajukan oleh pemohon yang berstatus bawahannya.

Berikut adalah contoh kode untuk menampilkan semua pengajuan yang perlu di legalisir berdasarkan bawahan si manager
```php
public function index()
{
	// ambil data manager yang saat ini sedang login
	$user = Auth::user();

	// ambil semua pengajuan yang diajukan oleh bawahan si manager yang sudah di konfirmasi oleh admin
	$letters =  Letter::whereNotNull('car_id')
		->whereIn('user_id', function ($query) use ($user) {
			$query->select('user_id')
				->from('user_managers')
				->where('manager_id', $user->id);
		})->get();
		
	// ambil pengajuan yang perlu di legalisir oleh si manager
	$validations = $letters->map(function ($letter) {
		return  Validation::where('letter_id', $letter->id)
			->whereNull('manager_signature')
			->first();
	})->filter();
}
```
Pada kode diatas dalam mendapatkan surat pengajuan dari para bawahan dan telah di konfirmasi oleh admin, sistem menggunakan sub query agar mendapatkan data surat pengajuan yang `car_id` tidak bernilai `null` yang hanya diajukan oleh para bawahan si manager dengan bantuan tabel `user_managers` 

Sistem akan melakukan filter terhadap semua surat yang telah didapatkan dengan ketentuan bahwa data legalisir oleh si manager pada tiap surat belum bernilai atau dengan kata lain manager belum memberikan legalisir.

Berikut adalah contoh kode untuk mengani proses konfirmasi legalisir oleh manager
```php
<?php

public function update(String $id)
{
	// ambil data surat pengajuan yang akan dilegalisir oleh si manager
	$validation = Validation::findOrFail($id);

	// cek apakah tanda tangan si manager ada
	$signature =  Signature::where('user_id', Auth::user()->id)->first();
	if (!$signature) return 'anda belum melakukan perekaman tanda tangan';

	// cek apakah file tanda tangan ada di sistem
	$signaturePath =  'public/signatures/'  . $signature->image;
	if (!Storage::exists($signaturePath)) return 'file tanda tangan anda tidak ditemukan';

	// melakukan proses legalisir
	$validation->update(['manager_signature'  => $signature->id]);
}
```
Pada kode diatas sistem akan memasukkan `id` dari tanda tangan manager ke dalam `manager_signature` yang menandakan bahwa pengajuan telah di legalisir oleh manager atau atasan pemohon.

### Proses Legalisir Oleh Deputy
Pada proses ini kurang lebih sama dengan apa yang dilakukan sistem pada proses legalisir oleh manager, namun pada pengambilan surat pengajuan yang telah dikonfirmasi oleh admin, sistem akan mengambil semua surat tersebut tanpa harus melakukan sub query ke table `user_managers`

### Mengambil tanda tangan pada legalisir
Sesuai dengan studi kasus yang diangkat, setiap surat pengajuan harus disetujui dan diketahui oleh tiga aktor, yaitu `Deputi`, `Atasan Pemohon`,  dan `Pemohon`  dibuktikan dengan pemberian tanda tangan digital pada surat tersebut atau bisa disebut legalisir.

Infomasi mengenai legalisir dari suatu surat pengajuan disimpan didalam model `Validation`, dapat dilihat pada `app/Models/Validation.php`

Pada model ini akan menyimpan informasi mengenai `letter_id`, `deputy_signature`, `manager_signature`, dan `applicant_signature`. Model ini memiliki relasi dengan model `Letter` dan `Signature`, yang dapat digunakan dalam menyimpan informasi mengenai surat pengajuan yang di legalisir beserta informasi tanda tangan digital di masing - masing aktor

Contoh penggunaan nya sebagai berikut :
```php
<?php

public function show($id)
{
	// ambil surat pengajuan berdasarkan $id
	$letter = Letter::findOrFail($id);
	
	// ambil data legalisir
	$validation = $letter->validation;
	// cek apakah legalisir sudah dibuat
	if (!$validation) return 'Legalisir tidak ditemukan';
	
	// ambil data tanda tangan dari deputy beserta namanya
	$deputySignature = $validation->deputySignature?->image;
	$deputyName = $validation->deputySignature?->user?->name;
	
	// ambil data tanda tangan dari manager beserta namanya
	$managerSignature = $validation->managerSignature?->image;
	$managerName = $validation->managerSignature?->user?->name;
	
	// ambil data tanda tangan dari pemohon beserta namanya
	$applicantSignature = $validation->applicantSignature?->image;
	$applicantName = $validation->applicantSignature?->user?->name;
}
```

### Mengambil data karyawan dan manager

Sistem ini memungkinkan untuk menyimpan informasi mengenai data karyawan dan manager pada satu model yaitu model `UserManager`, dapat dilihat pada `app/Models/UserManager.php`.  Model ini menyimpan informasi mengenai `user_id` dan `manager_id` yang memiliki relasi dengan model `User`.

Dengan skema seperti ini memungkinkan seorang karyawan atau yang diwakilkan dengan `user_id` dapat berada di lebih dari satu manager yang diwakilkan oleh `manager_id`. Begitu juga dengan manager yang bisa memiliki lebih dari satu karyawan.

Berikut contoh penggunaannya :
```php
public function index() 
{
	// ambil data user berdasarkan id sama dengan 1
	$user = User::findOrFail(1);
	
	// ambil semua data user lain yang menjadi bawahan si user tadi
	$employess = $user->employees;
	// ambil nama bawahan paling pertama
	$employee = $user->employees?->first()?->employeeDetail?->name; 
	
	// ambil semua data atasan atau manager si user tadi
	$managers = $user->managedBy;
	// ambil nama manager paling pertama
	$manager = $user->managedBy?->first()?->managerDetail?->name;
}
```
