<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <header class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html "
            target="_blank">
            <img src="{{ asset('images/gibs.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">SI Peminjaman Mobil</span>
        </a>
    </header>

    <hr class="horizontal dark mt-0">

    <section class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main">
        {{-- links --}}
        <ul class="navbar-nav">
            {{-- dashboard     --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard.index') || request()->routeIs('manager.dashboard.index') || request()->routeIs('user.dashboard.index') || request()->routeIs('deputy.dashboard.index') ? 'active' : '' }}"
                    @if (auth()->user()->hasRole('admin')) href="/admin"
                    @elseif(auth()->user()->hasRole('manager'))
                        href="/manager"
                    @elseif(auth()->user()->hasRole('deputy'))
                        href="/deputy"
                    @else
                        href="/" @endif>
                    {{-- icon --}}
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fa-solid fa-house {{ request()->routeIs('admin.dashboard.index') || request()->routeIs('manager.dashboard.index') || request()->routeIs('user.dashboard.index') || request()->routeIs('deputy.dashboard.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Master</h6>
            </li>

            {{-- Hanya untuk role admin  --}}
            @if (auth()->user()->hasRole('admin'))
                {{-- Unit Mobil --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.car.index') ? 'active' : '' }}"
                        href="{{ route('admin.car.index') }}">
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-car {{ request()->routeIs('admin.car.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Unit Mobil</span>
                    </a>
                </li>

                {{-- Pengguna --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.user.index') ? 'active' : '' }}"
                        href="{{ route('admin.user.index') }}">
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-user-group {{ request()->routeIs('admin.user.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Pengguna</span>
                    </a>
                </li>
            @endif

            @if (!auth()->user()->hasRole('admin'))
                {{-- Signature --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('signature.index') ? 'active' : '' }}"
                        href="{{ route('signature.index') }}">
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-signature {{ request()->routeIs('signature.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Tanda Tangan</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('manager'))
                {{-- Employe --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.employee.index') ? 'active' : '' }}"
                        href="{{ route('manager.employee.index') }}">
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-user-group {{ request()->routeIs('manager.employee.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Karyawan</span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Data Transaksi</h6>
            </li>

            @if (auth()->user()->hasRole('user') ||
                    auth()->user()->hasRole('admin'))
                {{-- Pengajuan --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.letter.index') || request()->routeIs('admin.letter.index') ? 'active' : '' }}"
                        @if (auth()->user()->hasRole('user')) href="{{ route('user.letter.index') }}"
                    @else
                    href="{{ route('admin.letter.index') }}" @endif>
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-envelope-open-text {{ request()->routeIs('user.letter.index') || request()->routeIs('admin.letter.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Pengajuan</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('deputy') ||
                    auth()->user()->hasRole('manager') ||
                    auth()->user()->hasRole('admin'))
                {{-- Pengesahan --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('manager.validation.index') || request()->routeIs('deputy.validation.index') || request()->routeIs('admin.validation.index') ? 'active' : '' }}"
                        @if (auth()->user()->hasRole('manager')) href="{{ route('manager.validation.index') }}"
                @elseif (auth()->user()->hasRole('admin'))
                    href="{{ route('admin.validation.index') }}"
                @else
                    href="{{ route('deputy.validation.index') }}" @endif>
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-solid fa-file-signature {{ request()->routeIs('manager.validation.index') || request()->routeIs('deputy.validation.index') || request()->routeIs('admin.validation.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Legalisir</span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Area Pengguna</h6>
            </li>

            @if (auth()->user()->hasRole('admin'))
                {{-- Arsip --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.archive.index') ? 'active' : '' }}"
                        href="{{ route('admin.archive.index') }}">
                        {{-- icon --}}
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fa-regular fa-folder-open {{ request()->routeIs('admin.archive.index') ? '' : 'text-dark' }}"></i>
                        </div>
                        {{-- link title --}}
                        <span class="nav-link-text ms-1">Arsip</span>
                    </a>
                </li>
            @endif

            {{-- log out --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                    href="{{ route('profile.index') }}">
                    {{-- icon --}}
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fa-solid fa-user-gear {{ request()->routeIs('profile.index') ? '' : 'text-dark' }}"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            {{-- log out --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    {{-- icon --}}
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-right-from-bracket text-dark"></i>
                    </div>
                    {{-- link title --}}
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>

        </ul>
    </section>
</aside>
