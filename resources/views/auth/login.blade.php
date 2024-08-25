<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <login-form></login-form>
    </div>

    <!-- Vue.js CDN (Vue 3) -->
    <script type="module" src="https://unpkg.com/vue@3.2.47/dist/vue.esm-browser.js"></script>
    <!-- Include your main.js file -->
    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>
</html>
