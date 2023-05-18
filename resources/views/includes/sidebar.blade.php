<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <header class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
        <img src="{{ asset('soft-ui/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">SI Peminjaman Mobil</span>
        </a>
    </header>

    <hr class="horizontal dark mt-0">

    <section class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        {{-- links --}}
        <ul class="navbar-nav">
            {{-- dashboard     --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard.index') || request()->routeIs('manager.dashboard.index') || request()->routeIs('user.dashboard.index') ? 'active' : '' }}" 
                    @if (auth()->user()->hasRole('admin'))
                        href="/admin"
                    @elseif(auth()->user()->hasRole('manager'))
                        href="/manager"
                    @else
                        href="/"
                    @endif>
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house {{ request()->routeIs('admin.dashboard.index') || request()->routeIs('manager.dashboard.index') || request()->routeIs('user.dashboard.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master</h6>
            </li>

            {{-- Hanya untuk role admin  --}}
            @if ( auth()->user()->hasRole('admin') )
            {{-- Unit Mobil --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.car.index') ? 'active' : '' }}" href="{{ route('admin.car.index') }}">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-car {{ request()->routeIs('admin.car.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Unit Mobil</span>
                </a>
            </li>

            {{-- Pengguna --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-group {{ request()->routeIs('admin.user.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Pengguna</span>
                </a>
            </li>
            @endif

            @if ( auth()->user()->hasRole('user') )
            {{-- Signature --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.signature.index') ? 'active' : '' }}" href="{{ route('user.signature.index') }}">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-file-signature {{ request()->routeIs('user.signature.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Tanda Tangan</span>
                </a>
            </li>
            @endif
            
            @if ( auth()->user()->hasRole('manager') )
            {{-- Employe --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.employee.index') ? 'active' : '' }}" href="{{ route('manager.employee.index') }}">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-group {{ request()->routeIs('manager.employee.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Karyawan</span>
                </a>
            </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Transaksi</h6>
            </li>

            {{-- Pengajuan --}}
            <li class="nav-item">
                <a class="nav-link" href="">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-envelope-open-text text-dark"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Pengajuan</span>
                </a>
            </li>

            {{-- Arsip --}}
            <li class="nav-item">
                <a class="nav-link" href="">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-folder-open text-dark"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Arsip</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Area Pengguna</h6>
            </li>

            {{-- log out --}}
            <li class="nav-item">
                <a class="nav-link" href="">
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-gear text-dark"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            {{-- log out --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    {{-- icon --}}
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-right-from-bracket text-dark"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>

        </ul>
    </section>
</aside>