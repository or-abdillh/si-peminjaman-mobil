@extends('layouts.soft-ui.auth.register')

@section('content')
<div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url({{ asset('soft-ui/assets/img/curved-images/curved14.jpg') }});">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Halo!</h1>
            <p class="text-lead text-white">Silahkan mendaftar akun untuk dapat menggunakan aplikasi ini</p>
        </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
          <div class="card-header text-center pt-4">
            <h5>Buat Akun</h5>
          </div>
          <div class="card-body">
            <form role="form text-left" action="{{ route('register') }}" method="POST">
                @csrf
              <div class="mb-3">
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap" aria-label="Name" aria-describedby="email-addon">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="mb-3">
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="Alamat Email" aria-label="Email" aria-describedby="email-addon">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="mb-3">
                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="mb-3">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" aria-label="Konfirmasi Password" aria-describedby="password-addon">
              </div>

              <div class="text-center">
                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Daftar</button>
              </div>
              <p class="text-sm mt-3 mb-0">Sudah punya akun? <a href="javascript:;" class="text-dark font-weight-bolder">Masuk disini</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection