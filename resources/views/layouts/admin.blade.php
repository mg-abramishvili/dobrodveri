<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Добродвери - ПУ</title>

        @vite('resources/css/admin.css')
    </head>
    <body class="admin_panel" style="min-height: 100vh;">
        @auth
            <div id="admin"></div>
        @endauth

        @guest
            <main>
                @yield('content')
            </main>
        @endguest

        @if(Route::currentRouteName() != 'login')
            <script src="/js/bootstrap.min.js"></script>
            @vite('resources/js/admin.js')
        @endif
        
    </body>
</html>