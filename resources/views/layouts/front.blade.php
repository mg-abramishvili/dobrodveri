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
                <div class="header-top">
                    <div class="container">
                        <div class="header-top-logo">
                            <a href="/">logo</a>
                        </div>
                        <div class="header-top-nav">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="#">Поиск</a>
                                    </li>
                                    <li>
                                        <a href="#">Акции</a>
                                    </li>
                                    <li>
                                        <a href="#">Избранное</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-top-tel">
                            <a href="#">8 937 850 40 40</a>
                            <span>Ежедневно с 10:00 до 20:00</span>
                        </div>
                    </div>
                </div>

                <div class="header-bottom">
                    <div class="container">
                        <div class="header-bottom-menu">
                            menu
                        </div>
                        <div class="header-bottom-nav">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="#">Межкомнатные двери</a>
                                    </li>
                                    <li>
                                        <a href="#">Скрытые двери</a>
                                    </li>
                                    <li>
                                        <a href="#">Входные двери</a>
                                    </li>
                                    <li>
                                        <a href="#">Фурнитура</a>
                                    </li>
                                    <li>
                                        <a href="#">Где купить</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-bottom-action">
                            <a href="#">Заказать замер</a>
                        </div>
                    </div>
                </div>
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