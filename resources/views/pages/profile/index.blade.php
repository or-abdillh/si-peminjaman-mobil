@extends('layouts.soft-ui.app')

@push('before-styles')

<style>

.avatar { 
    background-position: center;
    background-size: cover;
    border-radius: 50%;
    width: 160px; 
    height: 160px;
}

</style>

@endpush

@section('content')

<main class="container-fluid row">

    {{-- detail informasi pengguna saat ini --}}
    <section class="col-lg-4">
        <section  class="card">
            <section class="card-body">
                <section class="w-full d-flex justify-content-center">
                    {{-- foto profile --}}
                    @if ( is_null( auth()->user()->picture ) )
                    <div class="avatar mb-3" style="background-image: url({{ asset('/images/avatar.png') }});"></div>
                    @else
                    <div class="avatar mb-3" style="background-image: url({{ asset('/storage/pictures/' . auth()->user()->picture) }});"></div>
                    @endif
                </section>
                {{-- informasi pribadi --}}
                <section class="mb-4">
                    <section class="text-center">
                        {{-- nama --}}
                        <h5>{{ auth()->user()->name }}</h5>
                        {{-- email --}}
                        <p>{{ auth()->user()->email }}</p>
                    </section>
                    <hr class="bg-secondary">
                </section>
                <section>
                    {{-- Nomor telepon --}}
                    <small>No. Telepon</small>
                    <p>{{ auth()->user()?->phone_number ? auth()->user()?->phone_number : 'Tidak ada data' }}</p>
                    {{-- Posisi --}}
                    <small>Posisi</small>
                    <p>{{ auth()->user()?->position ?? 'Tidak ada data' }}</p>
                    {{-- Atasan --}}
                    <small>Atasan</small>
                    @foreach (auth()->user()?->managedBy as $manager)
                        <p>{{ $manager?->managerDetail?->name ?? 'Tidak ada data' }}</p>
                    @endforeach
                </section>
            </section>
        </section>
    </section>

    {{-- form update profile --}}
    <section class="col-lg-8">
        <section class="card mb-4">
            <section class="card-header d-flex justify-content-between">
                <section>
                    <h5>Ubah Informasi Pengguna</h5>
                    <small>Silahkan melakukan perubahan data akun anda menggunakan form berikut</small>
                </section>
                <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid text-lg fa-user-edit"></i>
                </section>
            </section>
            <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST" class="card-body">
                @csrf
                @method('PUT')
                {{-- nama pengguna --}}
                <label>Nama</label>
                <input type="text" name="name" value="{{ auth()->user()?->name }}" class="form-control mb-3 @error('name') is-invalid @enderror" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- email pengguna --}}
                <label>Alamat Email</label>
                <input type="text" name="email" value="{{ auth()->user()?->email }}" class="form-control mb-3 @error('email') is-invalid @enderror" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- nomor telepon pengguna --}}
                <label>Nomor Telepon</label>
                <input type="tel" name="phone_number" value="{{ auth()->user()?->phone_number }}" class="form-control mb-3 @error('phone_number') is-invalid @enderror" placeholder="Masukkan nomor telepon aktif" required>
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                {{-- posisi pengguna --}}
                <label>Posisi Pekerjaan</label>
                <input type="text" name="position" value="{{ auth()->user()?->position }}" class="form-control mb-3 @error('position') is-invalid @enderror" placeholder="Masukkan posisi pekerjaan anda saat ini" required>
                @error('position')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
                <button type="submit" class="btn btn-primary" >Save Changes</button>

            </form>
        </section>

        {{-- ubah profile picture --}}
        <section class="card mb-4">
            <section class="card-header d-flex justify-content-between">
                <section>
                    <h5>Ubah Profile Picture</h5>
                    <small>Upload berkas foto anda dalam bentuk PNG atau JPG</small>
                </section>
                <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid text-lg fa-image"></i>
                </section>
            </section>
            <form action="{{ route('profile.picture.change') }}" method="POST" class="card-body" enctype="multipart/form-data">
                @csrf
                <label>Upload berkas</label>
                <input type="file" name="picture" class="form-control mb-3 @error('picture') 'is-invalid' @enderror" accept=".png, .jpg, .jpeg" required>
                @error('picture')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </section>

        {{-- ubah kata sandi --}}
        <section class="card">
            <section class="card-header d-flex justify-content-between">
                <section>
                    <h5>Ubah kata sandi</h5>
                    <small>Lakukan perubahan kata sandi anda menggunakan form berikut</small>
                </section>
                <section class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid text-lg fa-user-cog"></i>
                </section>
            </section>
            <form action="{{ route('profile.password.reset') }}" method="POST" class="card-body">
                @csrf
                @method('PUT')
                {{-- password lama --}} 
                <label>Kata sandi saat ini</label>
                <input type="password" name="old_password" class="form-control mb-3 @error('old_password') is-invalid @enderror" placeholder="Masukkan kata sandi anda saat ini">
                @error('old_password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label>Kata sandi baru</label>

                <section class="row">
                    <div class="col-lg-6 mb-3">
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Masukkan kata sandi baru" aria-label="Password" aria-describedby="password-addon">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
        
                    <div class="col-lg-6 mb-3">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" aria-label="Konfirmasi Password" aria-describedby="password-addon">
                    </div>
                </section>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </section>
    </section>

</main>

@endsection