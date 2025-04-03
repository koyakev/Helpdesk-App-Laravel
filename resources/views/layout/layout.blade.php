<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        @vite('resources/css/app.css')
        <style>
            [x-cloak] { display: none !important; } /* Hides elements until Alpine initializes */
        </style>
    </head>
    <body>
        @if(session('user'))
            @include('layout.navigation')
        @endif
        <div class="flex h-screen w-full">
            @if(session('user'))
                @include('layout.sidenavigation')
            @endif
            
            <div class="w-full flex-col m-6 items-center mt-15">
                @yield('content')
            </div>
        </div>
    </body>
</html>