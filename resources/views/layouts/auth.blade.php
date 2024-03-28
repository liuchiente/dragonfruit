<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/sass/app.scss','resources/js/app.js'])

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('vendor/sb-admin-2/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('vendor/sb-admin-2/img/favicon.png') }}" rel="icon" type="image/png">

    <style>
        .bg-login-image {
            background: url({{ asset('img/login.jpg')}});
            background-position: center;
            background-size: cover;
        }

        .bg-gradient-primary {
        background-color: #157022;
        background-image: linear-gradient(180deg, #157022 10%, #f2c150 100%);
        background-size: cover;
        }

    </style>

</head>
<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center">

@yield('main-content')

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/sb-admin-2/sb-admin-2.min.js') }}"></script>
</body>
</html>
