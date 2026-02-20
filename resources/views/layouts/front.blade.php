<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{Vite::asset('resources/front/images/Tata-Pravesh-Favicon.png')}}">
    <link rel="icon" href="{{Vite::asset('resources/front/images/Tata-Pravesh-Favicon.png')}}" sizes="32x32" />
    <link rel="icon" href="{{Vite::asset('resources/front/images/Tata-Pravesh-Favicon.png')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{Vite::asset('resources/front/images/Tata-Pravesh-Favicon.png')}}" />

    {{-- Favicon --}}
    @vite(['resources/front/scss/style.scss', 'resources/front/js/app.js'])

    <link rel="stylesheet" href="{{ url('assets/fonts/stylesheet.css')}}" media="all">
    <link rel="stylesheet" href="{{ url('assets/intlTelInput/intlTelInput.css') }}">
    <script src="{{ url('assets/intlTelInput/intlTelInput.js') }}"></script>
</head>

<body>

    @include('admin.includes.header')
        @yield('content')
    {{-- @include('front.includes.footer') --}}

    @stack('scripts')
    <script>
        var base_url = '{{url('/')}}';
    </script>
    <script type="module">
        
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</body>

</html>
