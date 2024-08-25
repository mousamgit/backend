<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        <login-form></login-form>
    </div>

    <script src="https://unpkg.com/vue@3"></script>
    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>
</html>
