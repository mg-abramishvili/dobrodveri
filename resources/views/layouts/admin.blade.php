<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Добродвери - ПУ</title>

        @vite('resources/css/admin.css')
    </head>
    <body>
        <div id="admin" class="wrapper">
            <header>
                
            </header>

            <main>
                @yield('content')
            </main>

            <footer>

            </footer>
        </div>
        
        @vite('resources/js/admin.js')
    </body>
</html>