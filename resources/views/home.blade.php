@extends('layouts.front')
@section('title', 'Добродвери')

@section('content')
    <div class="container">
        <div class="category-products-list">
            @foreach($popularProducts as $product)
                <div class="products-list-item">
                    <a href="/product/{{ $product->slug }}">
                        <p class="products-list-item-name">
                            {{ $product->name }}
                        </p>

                        <div class="products-list-item-price">
                            {{ $product->price }} <small>₽</small>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection