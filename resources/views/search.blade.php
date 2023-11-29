@extends('layouts.front')
@section('title', 'Поиск по сайту - Добродвери')
@section('description', 'Поиск по сайту - Добродвери')
@section('content')
    <div class="container page-search">
        <h1 class="title-header">Поиск по сайту</h1>
        
        @foreach($products as $product)
            <div class="search-product-item">
                <a href="/product/{{ $product->slug }}">
                    {{ $product->name }}
                </a>
            </div>
        @endforeach
    </div>
@endsection