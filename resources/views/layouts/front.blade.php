<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        @vite('resources/css/front.css')
    </head>
    <body>
        <div id="front" class="wrapper">
            <header>
                
            </header>

            <main>
                @yield('content')
            </main>

            <footer>

            </footer>
        </div>
        
        @vite('resources/js/front.js')
    </body>
</html>