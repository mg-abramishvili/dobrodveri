@php
    $product = json_decode($product, true);
@endphp

@extends('layouts.front')
@section('title', $product["name"] . ' - Добродвери')

@section('content')
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

        <div class="product-detail-tabs" id="product-detail-tabs">
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

            <div class="product-detail-tab product-detail-tab-active product-detail-tab-description">
                {!! $product["description"] !!}
            </div>
            <div class="product-detail-tab product-detail-tab-attributes">
                Характеристики
            </div>
            <div class="product-detail-tab product-detail-tab-reviews">
                @foreach($product["reviews"] as $review)
                    {{ $review["text"] }}
                @endforeach

                <create-product-review :product_id="{{ $product['id'] }}" />
            </div>
            <div class="product-detail-tab product-detail-tab-specials">
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