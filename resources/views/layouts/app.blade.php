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

    <div class="loader-wrap" style="display: none;">
        <div class="ml-loader">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
    </div>


    <div class="loader-container-pdf-data-wrap" id="loader-container-pdf-data-wrap" style="display:none;">
        <div class="loader-container-pdf-data" id="loader-pdf-data">
            <div class="loader-text-pdf-data">Cargando...</div>
            <div class="progress-bar-pdf-data">
              <div class="progress-fill-pdf-data" id="progress-pdf-data"></div>
            </div>
            <div class="progress-desc-pdf-data">
              Analizando PDF para extraer todos los datos, en pocos segundos lo tienes.
            </div>
        </div>
    </div>

    @include('admin.includes.header')
        @yield('content')
    @include('admin.includes.footer_user')

    @stack('scripts')
    <script>
        var base_url = '{{url('/')}}';
    </script>
    <script type="module">
        var input = document.querySelector("#phone_prifix");
        window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "ES",
        });
        var iti = window.intlTelInputGlobals.getInstance(input);
        $('#dialCode').val(iti.getSelectedCountryData().dialCode);
        input.addEventListener("countrychange", function() {
            $('#dialCode').val(iti.getSelectedCountryData().dialCode);
        });

        // window.lang_select = function() {
        //     $(".account-login").slideToggle();
        // }
        document.addEventListener('click', function (e) {
            var container = document.querySelector('.account_name');
            if (!container.contains(e.target)) {
                $(".account-login").slideUp();
            }
            e.stopPropagation();
        });
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</body>

</html>
