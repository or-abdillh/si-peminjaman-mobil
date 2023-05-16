<!DOCTYPE html>
<html lang="id">
<head>
    {{-- meta's --}}
    @include('includes.meta')
    
    {{-- linked to resources --}}
    @include('includes.head')

    {{-- additional css or js --}}
    @stack('before-styles')
    @stack('before-scripts')
</head>
<body class="g-sidenav-show bg-gray-100">

    {{-- sidebar --}}
    @include('includes.sidebar')

    {{-- main wrapper element --}}
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        {{-- navbar --}}
        @include('includes.navbar')

        {{-- inner wrapper element --}}
        <section class="container-fluid py-4">

            {{-- content --}}
            @yield('content')

            {{-- footer --}}
            @include('includes.footer')
        </section>
    </main>

    {{-- core js files --}}
    @include('includes.core-js')
    
    {{-- additional css or js --}}
    @stack('after-styles')
    @stack('after-scripts')
</body>
</html>