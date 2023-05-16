<!DOCTYPE html>
<html lang="id">
<head>
    {{-- meta's --}}
    @include('includes.meta')

    {{-- linked to resources --}}
    @include('includes.head')

    {{-- additional CSS JS --}}
    @stack('before-styles')
    @stack('before-scripts')
</head>
<body>
    {{-- main wrapper --}}
    <main class="main-content  mt-0">
        {{-- inner wrapper --}}
        <section class="min-vh-100 mb-8">
            @yield('content')
        </section>
        {{-- footer --}}
        @include('includes.footer')
    </main>

    {{-- core JS --}}
    @include('includes.core-js')

    {{-- additional CSS JS --}}
    @stack('after-styles')
    @stack('after-scripts')
</body>
</html>