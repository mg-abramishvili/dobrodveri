@php
    $product = json_decode($product, true);
@endphp

@extends('layouts.front')
@section('title', $product["name"] . ' - Добродвери')

@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li>
                <a href="/catalog/">Каталог</a>
            </li>
            <li>
                <a href="/catalog/{{ $product["category"]["slug"] }}/">{{ $product["category"]["name"] }}</a>
            </li>
            <li>
                <a>{{ $product["name"] }}</a>
            </li>
        </ul>
    </div>

    <div class="container product-detail">
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
    
                @if(request()->innerdecor)
                    innerdecor="{{ request()->innerdecor }}"
                @endif
    
                @if(request()->size)
                    size="{{ request()->size }}"
                @endif
            />
        </div>
    </div>

    <div class="product-detail-tabs" id="product-detail-tabs">
        <div class="container">
            <ul class="product-detail-tabs-buttons">
                <li class="product-detail-tab-button">
                    <button onclick="selectTab('description')">Описание</button>
                </li>
                <li class="product-detail-tab-button">
                    <button onclick="selectTab('attributes')">Характеристики</button>
                </li>
                <li class="product-detail-tab-button">
                    <button onclick="selectTab('reviews')">Отзывы</button>
                </li>
                <li class="product-detail-tab-button">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="product-detail-tab product-detail-tab-reviews">
            <div class="container">
                @foreach($product["reviews"] as $review)
                    {{ $review["text"] }}
                @endforeach
    
                <create-product-review :product_id="{{ $product['id'] }}" />
            </div>
        </div>
        <div class="product-detail-tab product-detail-tab-specials">
            <div class="container">
                Акции
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function selectTab(selectedTab) {
        let productTabs = document.querySelectorAll('.product-detail-tab')

        productTabs.forEach(tab => {
            tab.classList.remove('product-detail-tab-active')
        })

        document.getElementsByClassName("product-detail-tab-" + selectedTab)[0].classList.add('product-detail-tab-active');
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