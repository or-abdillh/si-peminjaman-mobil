<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Surat — {{ @$name }}</title>

    {{-- css untuk layouting surat --}}
    {{-- @vite('resources/sass/print-layout.scss') --}}
    <link rel="stylesheet" href="{{ asset('css/print-layout.css') }}">
</head>
<body>
    <main id="letter">
        @yield('content')
    </main>

    <script type="text/javascript">
    
        window.addEventListener('DOMContentLoaded', () => {
            window.print()
        })

    </script>
</body>
</html>