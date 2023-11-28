<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        @yield('css')

        @vite('resources/css/front.css')
    </head>
    <body>
        <div id="front" class="wrapper">
            <header>
                <div class="header-top">
                    <div class="container">
                        <div class="header-top-logo">
                            <a href="/">
                                <img src="/img/logo.svg" alt="Добродвери">
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
                                        <a href="/favorites">
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
                            <button id="menu_button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                Меню
                            </button>
                        </div>
                        <div class="header-bottom-menu-content">
                            <ul>
                                @foreach($pages as $page)
                                    <li>
                                        <a href="/p/{{ $page->slug }}/">{{ $page->name }}</a>
                                    </li>
                                @endforeach
                                <li>
                                    <a href="/dizaineram">Дизайнерам</a>
                                </li>
                                <li>
                                    <a href="/polezno/">Полезно</a>
                                </li>
                            </ul>
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
                                        <a href="/catalog/vkhodnyie-dveri/">Входные двери</a>
                                    </li>
                                    <li>
                                        <a href="/catalog/furnitura/">Фурнитура</a>
                                    </li>
                                    <li>
                                        <a href="#">Где купить</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="header-bottom-action">
                            <a onclick="openModal('LeadZamer')">Заказать замер</a>
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
                <div class="footer-top">
                    <div class="container">
                        <div class="footer-about">
                            <a href="#" class="footer-logo">
                                <img src="/img/logo.svg" alt="Добродвери">
                            </a>
    
                            <p>© 2022-{{ now()->year }} «Добродвери». Все права защищены.</p>
    
                            <a href="/policy" class="footer-policy">Политика конфиденциальности</a>
                        </div>
                        <div class="footer-nav">
                            <ul>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="/catalog/{{ $category->slug }}/">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <ul>
                                @foreach($pages as $page)
                                    <li>
                                        <a href="/p/{{ $page->slug }}">{{ $page->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="footer-socials">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="/img/vk.svg" alt="VK">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="/img/vk.svg" alt="VK">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <p>Информация на сайте не является публичной офертой, носит исключительно информационный характер и может быть изменена по усмотрению компании. Изображения товаров, размещенных на сайте, могут отличаться от оригиналов. Полное или частичное использование материалов данного сайта – запрещено!</p>
                    </div>
                </div>
            </footer>
            
            <div class="quiz-banner">
                <div class="container">
                    <p>Ответьте на 4 вопроса и узнайте стоимость и сроки!</p>
                    <button onclick="openModal('Quiz')">Пройти тест</button>
                </div>
            </div>

            <div id="modal_LeadZamer" class="modal">
                <div class="modal-content">
                    <button onclick="closeModal()" class="modal-close">&times;</button>
    
                    <create-lead subject="Заказ замера" />
                </div>
            </div>
            
            <div id="modal_Quiz" class="modal">
                <div class="modal-content">
                    <button onclick="closeModal()" class="modal-close">&times;</button>
    
                    <quiz />
                </div>
            </div>
        </div>
        
        @vite('resources/js/front.js')

        @yield('scripts')

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                let menuButton = document.getElementById('menu_button')
                let menu = document.getElementsByClassName('header-bottom-menu-content')[0]
    
                menuButton.onclick = function() {
                    if(menu.classList.contains('expanded')) {
                        menu.classList.remove('expanded')
                    } else {
                        menu.classList.add('expanded')
                    }
                }

                window.addEventListener('click', function(e) {   
                    if(!menu.contains(e.target) && !menuButton.contains(e.target) && menu.classList.contains('expanded')) {
                        menu.classList.remove('expanded')
                    }
                })
            })
        </script>

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

        <script>
            window.addEventListener('DOMContentLoaded', function(){
                let figures = document.getElementsByTagName('figure')
                let tables = document.getElementsByTagName('table')
                
                for (let figure of figures) {
                    if(figure.classList.contains('table')) {
                        figure.classList.remove('table')
                    }
                }

                for (let table of tables) {
                    if(!table.classList.contains('table')) {
                        table.classList.add('table')
                    }
                }
            })
        </script>

        <script>
            function openModal(modalID) {
                let modal = document.getElementById("modal_" + modalID)

                if(modal) {
                    modal.style.display = "block"
                }
            }

            function closeModal() {
                let modals = document.querySelectorAll('.modal')

                modals.forEach(modal => {
                    modal.style.display = "none"
                })
            }

            window.onclick = function(event) {
                let modals = document.querySelectorAll('.modal')

                modals.forEach(modal => {
                    if (event.target == modal && modal.style.display == 'block') {
                        modal.style.display = "none"
                    }
                })
            }
        </script>

        <script>
            window.addEventListener('DOMContentLoaded', function() {
                let quizBanner = document.getElementsByClassName('quiz-banner')[0]

                setTimeout(() => {
                    if(quizBanner) {
                        quizBanner.style.display = 'block'
                    }
                }, 15000)
            })
        </script>
    </body>
</html>