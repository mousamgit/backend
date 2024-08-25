<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <login-form></login-form>
        <!-- Include other components here if needed -->
    </div>

    <!-- Vue.js CDN (Vue 3) -->
    <script src="https://unpkg.com/vue@3"></script>
    <!-- Include your main.js file -->
    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>
</html>
