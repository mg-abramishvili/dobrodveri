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
                            <a href="/">
                                <img src="/img/logo.svg" alt="">
                            </a>
                        </div>
                        <div class="header-top-nav">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                            </svg>
                                            Поиск
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path>
                                            </svg>
                                            Избранное
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16">
                                                <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z"></path>
                                            </svg>
                                            Акции
                                        </a>
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
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                Меню
                            </button>
                        </div>
                        <div class="header-bottom-nav">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="/catalog/mezhkomnatnye-dveri/">Межкомнатные двери</a>
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

                <div class="map">
                    <div id="map-wrapper">
                        <iframe style="pointer-events: none;" src="https://yandex.ru/map-widget/v1/?um=constructor%3Afd9a3265a8a0f18f0262e22602e41e4149fe13ce4f185bf8ca78087a1c7e74a3&amp;source=constructor" width="100%" height="100%" frameborder="0"></iframe>
                    </div>
                </div>
            </main>

            <footer>

            </footer>
        </div>
        
        @vite('resources/js/front.js')

        @yield('scripts')

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                let mapTitle = document.createElement('div')
                mapTitle.className = 'map-title'
                mapTitle.textContent = 'Для активации карты нажмите по ней'

                let mapWrapper = document.getElementById('map-wrapper')
                mapWrapper.appendChild(mapTitle)

                mapWrapper.onclick = function() {
                    this.children[0].removeAttribute('style')
                    mapTitle.parentElement.removeChild(mapTitle)
                }
                
                mapWrapper.onmousemove = function(event) {
                    mapTitle.style.display = 'block'
                    if(event.offsetY > 10) mapTitle.style.top = event.offsetY + 20 + 'px'
                    if(event.offsetX > 10) mapTitle.style.left = event.offsetX + 20 + 'px'
                }
                
                mapWrapper.onmouseleave = function() {
                    mapTitle.style.display = 'none'
                }
            })
        </script>
    </body>
</html>