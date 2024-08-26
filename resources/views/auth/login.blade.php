<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/theme19.css') }}">
</head>
<body>
    <div id="app">
        <login-form></login-form>
    </div>

    <!-- Vue.js CDN (Vue 3) -->
    <script type="module" src="https://unpkg.com/vue@3.2.47/dist/vue.esm-browser.js"></script>
    <!-- Include your main.js file -->
    <script type="module" src="{{ asset('js/main.js') }}"></script>
    <script type="module" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="module" src="{{ asset('auth/auth-main.js') }}"></script>
</body>
</html>
