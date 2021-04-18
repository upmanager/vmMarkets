@inject('lang', 'App\Lang')

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/markets.css" rel="stylesheet">
    @include('bsb.style', array())

</head>

<body class="q-login d-flex">

<div class="d-flex flex-vertical-center justify-content-around" style="width: 100vw">
    <div class="d-flex flex-row flex-vertical-center justify-content-around">

        <div align="d-flex flex-column justify-content-around">
            <div class="d-flex justify-content-around q-mb10" >
                <img src="img/logo.png" height="100px" >
            </div>
            <div class="d-flex justify-content-around q-mb20 q-font-30" style="color: #9dc4d4">
                {{ config('app.name') }}
            </div>

            <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="d-flex justify-content-around q-mb20 q-font-bold" style="color: #9dc4d4">
                {{$lang->get(569)}} {{--Sign in to start your session--}}
            </div>

            <div class="d-flex justify-content-around q-mb20 q-font-bold" style="color: #9dc4d4">
                <input id="email" type="email" class="q-form @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>

            @error('email')
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="d-flex justify-content-around q-mb20 q-font-bold" style="color: #9dc4d4; width: 300px">
                <input id="password" type="password" class="q-form @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="d-flex q-mb20 q-font-bold" style="color: #9dc4d4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="margin-right: 10px">
                {{$lang->get(570)}} {{--Remember Me--}}
            </div>

            <div class="d-flex q-mb20 " >
                <button type="submit" class="q-btn-all q-color-alert waves-effect q-font-bold q-font-20" style="background-color: #87eefd!important; width: 100%; color: #484948">
                    {{$lang->get(571)}} {{--Login--}}
                </button>
            </div>

{{--            <a href="{{route('password.request')}}">Forgot Password?</a>--}}

            </form>
        </div>
    </div>

</div>


<!-- Jquery Core Js -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="plugins/bootstrap/js/bootstrap.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="plugins/node-waves/waves.js"></script>

<!-- Validation Plugin Js -->
<script src="plugins/jquery-validation/jquery.validate.js"></script>

<!-- Custom Js -->
<script src="js/markets.js"></script>

</body>

</html>


