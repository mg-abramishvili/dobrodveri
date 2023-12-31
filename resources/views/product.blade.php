@php
    $product = json_decode($product, true);
@endphp

@extends('layouts.front')
@section('title', $product["name"] . ' - купить в Уфе - Добродвери')
@section('description', $product["name"] . ' - купить в Уфе - Добродвери')

@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li class="breadcrumbs-arrow-back">
                <a href="/catalog/{{ $product["category"]["slug"] }}/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </a>
            </li>
            <li class="nohash">
                <a href="/">Главная</a>
            </li>
            <li>
                <a href="/catalog/">Каталог</a>
            </li>
            <li>
                <a href="/catalog/{{ $product["category"]["slug"] }}/">{{ $product["category"]["name"] }}</a>
            </li>
        </ul>
    </div>

    <div class="container product-detail @if($product['category']['id'] == 2) product-detail-vkhod @endif">
        <div class="product-detail-image-sliders">
            <product-slider :product="{{ json_encode($product) }}"></product-slider>
        </div>

        <div class="product-detail-desc">
            <h1 class="product-detail-name">{{ $product["name"] }}</h1>

            @include('productReviewsCounter ', ['reviews' => $product["reviews"], 'rating' => $product["rating"]])
            
            <select-color-glass
                :product="{{ json_encode($product) }}"
    
                @if(request()->color)
                    color="{{ request()->color }}"
                @endif
    
                @if(request()->glass)
                    glass="{{ request()->glass }}"
                @endif
    
                @if(request()->inner_decor)
                    inner_decor="{{ request()->inner_decor }}"
                @endif
    
                @if(request()->size)
                    size="{{ request()->size }}"
                @endif
            />
        </div>

        <div class="product-detail-help-buttons">
            <ul>
                <li>
                    <button onclick="openModal('gdeKupit')">
                        <img src="/img/ico-location.svg" alt="Где купить?">
                        <span>Где купить?</span>
                    </button>
                </li>
                <li>
                    <button onclick="openModal('kakOplatit')">
                        <img src="/img/ico-card.svg" alt="Как оплатить?">
                        <span>Как оплатить?</span>
                    </button>
                </li>
                <li>
                    <button onclick="openModal('LeadZamer')">
                        <img src="/img/ico-size.svg" alt="Заказать замер">
                        <span>Заказать замер</span>
                    </button>
                </li>
                <li>
                    <button onclick="openModal('Lead')">
                        <img src="/img/ico-alarm.svg" alt="Обратный звонок">
                        <span>Обратный звонок</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="product-detail-tabs" id="product-detail-tabs">
        <div class="container">
            <ul class="product-detail-tabs-buttons">
                <li class="product-detail-tab-button product-detail-tab-button-description product-detail-tab-button-active">
                    <button onclick="selectTab('description')">Описание</button>
                </li>
                <li class="product-detail-tab-button product-detail-tab-button-attributes">
                    <button onclick="selectTab('attributes')">Характеристики</button>
                </li>
                <li class="product-detail-tab-button product-detail-tab-button-reviews">
                    <button onclick="selectTab('reviews')">Отзывы</button>
                </li>
                <li class="product-detail-tab-button product-detail-tab-button-specials">
                    <button onclick="selectTab('specials')">Акции</button>
                </li>
            </ul>
        </div>
        
        <div class="product-detail-tab product-detail-tab-active product-detail-tab-description">
            <div class="container">
                <div class="product-detail-tab-left">
                    Описание
                </div>

                <div class="product-detail-tab-right">
                    {!! $product["description"] !!}
                </div>
            </div>
        </div>
        <div class="product-detail-tab product-detail-tab-attributes">
            <div class="container">
                <div class="product-detail-tab-left">
                    Характеристики
                </div>
                <div class="product-detail-tab-right">
                    <table>
                        <tbody>
                            @if(isset($product['style']))
                                <tr>
                                    <td>Стиль</td>
                                    <td>
                                        {{ $product['style'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['type']))
                                <tr>
                                    <td>Тип</td>
                                    <td>
                                        {{ $product['type'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['construct']))
                                <tr>
                                    <td>Конструкция</td>
                                    <td>
                                        {{ $product['construct'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['surface']))
                                <tr>
                                    <td>Покрытие</td>
                                    <td>
                                        {{ $product['surface'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['purpose']))
                                <tr>
                                    <td>Назначение двери</td>
                                    <td>
                                        {{ $product['purpose'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['napolnenie']))
                                <tr>
                                    <td>Наполнение</td>
                                    <td>
                                        {{ $product['napolnenie'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['tolschina_polotna']))
                                <tr>
                                    <td>Толщина полотна</td>
                                    <td>
                                        {{ $product['tolschina_polotna'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['tolschina_metalla']))
                                <tr>
                                    <td>Толщина металла</td>
                                    <td>
                                        {{ $product['tolschina_metalla'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['vnutr_panel']))
                                <tr>
                                    <td>Внутренняя панель</td>
                                    <td>
                                        {{ $product['vnutr_panel'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['zamok']))
                                <tr>
                                    <td>Замок</td>
                                    <td>
                                        {{ $product['zamok'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['termorazryv']))
                                <tr>
                                    <td>Терморазрыв</td>
                                    <td>
                                        {{ $product['termorazryv'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['noch_zadvizh']))
                                <tr>
                                    <td>Ночная задвижка</td>
                                    <td>
                                        {{ $product['noch_zadvizh'] }}
                                    </td>
                                </tr>
                            @endif
                            @if(isset($product['rebra_zh']))
                                <tr>
                                    <td>Ребра жесткости</td>
                                    <td>
                                        {{ $product['rebra_zh'] }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="product-detail-tab product-detail-tab-reviews">
            <div class="container">
                <div class="product-detail-tab-left">
                    Отзывы
                </div>
                <div class="product-detail-tab-right">
                    <div class="product-reviews">
                        @forelse($product["reviews"] as $review)
                            <div class="product-review">
                                <div class="product-review-name">{{ $review["name"] }}</div>
                                <div class="product-review-rating">Оценка: <strong>{{ $review["rating"] }}</strong></div>
                                <div class="product-review-text">{{ $review["text"] }}</div>
                            </div>
                        @empty
                            <p>Пока нет отзывов на этот товар.</p>
                        @endforelse
                    </div>

                    <create-product-review :product_id="{{ $product['id'] }}" />
                </div>
            </div>
        </div>
        <div class="product-detail-tab product-detail-tab-specials">
            <div class="container">
                <div class="promos-list">
                    @forelse($product['promos'] as $promo)
                        <a href="/promo/{{ $promo['id'] }}" class="promo-list-item">
                            <div class="promo-list-item-image" style="background-image: url({{ $promo['image'] ? $promo['image'] : '/img/no-image.jpg' }});"></div>
                            
                            <div class="promo-list-item-desc">
                                <h5>
                                    {{ $promo['name'] }}
                                </h5>
                            </div>
                        </a>
                    @empty
                        Акций для этого товара пока нет.
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('popular')
    
    @include('recently-viewed')
@endsection

@section('scripts')
<script>
    function selectTab(selectedTab) {
        let productTabs = document.querySelectorAll('.product-detail-tab')

        productTabs.forEach(tab => {
            tab.classList.remove('product-detail-tab-active')
        })

        document.getElementsByClassName("product-detail-tab-" + selectedTab)[0].classList.add('product-detail-tab-active');

        let productTabsButtons = document.querySelectorAll('.product-detail-tab-button')

        productTabsButtons.forEach(tabButton => {
            tabButton.classList.remove('product-detail-tab-button-active')
        })

        document.getElementsByClassName("product-detail-tab-button-" + selectedTab)[0].classList.add('product-detail-tab-button-active');
    }

    function goToProductReviews() {
        var tabsElmnt = document.getElementById("product-detail-tabs")

        tabsElmnt.scrollIntoView()

        setTimeout(() => {
            selectTab('reviews')
        }, 500)
    }
</script>
@endsection