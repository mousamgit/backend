<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.header') <!-- Include the header partial -->

    <title>{{ $title ?? 'Default Title' }}</title>
    <style>
        /* Include your CSS styling here */
      
    </style>
</head>
<body>
    @include('layouts.topbar') 
    @include('layouts.sidebar')

    <div class="tab-content right-content">
        @yield('content') 
    </div>
</body>
</html>
