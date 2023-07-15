@extends('layouts.soft-ui.auth.login')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-8">
          <div class="card-header pb-0 text-left bg-transparent">
            <h3 class="font-weight-bolder text-info text-gradient">Selamat datang</h3>
            <p class="mb-0">Masukan Email dan password untuk masuk ke dalam Website SI Peminjaman Mobil</p>
          </div>

          {{-- form --}} 
          <div class="card-body">
            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf
                <label>Email</label>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <label>Password</label>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check form-switch">
                    <input name="remember" class="form-check-input" type="checkbox" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="rememberMe">Ingat saya</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Login</button>
                </div>
            </form>
          </div>

          <div class="card-footer text-center pt-0 px-lg-2 px-1">
            <p class="mb-4 text-sm mx-auto">
              Belum punya akun?
              <a href="{{ route('register') }}" class="text-info text-gradient font-weight-bold">Buat akun</a>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
          <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{ asset('images/sekolah.jpeg') }}')"></div>
        </div>
      </div>
    </div>
  </div>
@endsection