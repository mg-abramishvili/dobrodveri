@php
    $popularProducts = json_decode($popularProducts, true);
@endphp

@extends('layouts.front')
@section('title', 'Добродвери')

@section('content')
    <div class="swiper home-main-slider">
        <div class="swiper-wrapper">
            @foreach($mainSlider as $slide)
                <div class="swiper-slide home-main-slider-item" style="background-image: url({{ $slide->image }})">
                    <div class="home-main-slider-item-inner">
                        <h4>{{ $slide->header }}</h4>

                        <p>{{ $slide->text }}</p>

                        @if($slide->link)
                            <a href="{{ $slide->link }}">Подробнее</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination home-main-slider-pagination"></div>
        <!-- <div class="swiper-button-prev home-main-slider-button-prev"></div>
        <div class="swiper-button-next home-main-slider-button-next"></div> -->
    </div>

    <div class="container">
        <div class="category-products-list">
            @foreach($popularProducts as $product)
                <div class="products-list-item">
                    <a href="/product/{{ $product['slug'] }}">
                        @if($product['image'])
                            <div class="products-list-item-image">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                            </div>
                        @endif

                        <div class="products-list-item-price">
                            {{ $product['price'] }} <small>₽</small>
                        </div>

                        <p class="products-list-item-name">
                            {{ $product['name'] }} {{ $product['view_counter'] }}
                        </p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/swiper-bundle.min.css" />
@endsection

@section('scripts')
    <script src="/js/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const swiper = new Swiper('.home-main-slider', {
                loop: true,

                pagination: {
                    el: '.home-main-slider-pagination',
                    clickable: true,
                },

                navigation: {
                    nextEl: '.home-main-slider-button-next',
                    prevEl: '.home-main-slider-button-prev',
                },
            })
        })
    </script>
@endsection