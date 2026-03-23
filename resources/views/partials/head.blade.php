<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'LCBA MIS' }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('images/LCBA LOGO VECTOR.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/LCBA LOGO VECTOR.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/dark-mode.js') }}"></script>
