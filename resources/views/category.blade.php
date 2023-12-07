@php
    $productsWithPagination = json_decode($productsWithPagination, true);
    $skusWithPagination = json_decode($skusWithPagination, true);
@endphp

@extends('layouts.front')
@section('title', 'Каталог - Добродвери')

@section('content')
    <div class="container category">
        <h1 class="title-header">{{ $category->name }}</h1>

        <aside class="category-filter">
            <product-filter
                :category_id="{{ $category->id }}"

                @if(request()->price_from)
                    req_price_from="{{ request()->price_from }}"
                @endif

                @if(request()->price_to)
                    req_price_to="{{ request()->price_to }}"
                @endif

                @if(request()->type)
                    req_type="{{ request()->type }}"
                @endif

                @if(request()->style)
                    req_style="{{ request()->style }}"
                @endif

                @if(request()->color)
                    req_color="{{ request()->color }}"
                @endif

                @if(request()->glass)
                    req_glass="{{ request()->glass }}"
                @endif

                @if(request()->surface)
                    req_surface="{{ request()->surface }}"
                @endif

                @if(request()->innerdecor)
                    req_innerdecor="{{ request()->innerdecor }}"
                @endif

                @if(request()->purpose)
                    req_purpose="{{ request()->purpose }}"
                @endif

                @if(request()->furnituretype)
                    req_furnituretype="{{ request()->furnituretype }}"
                @endif
            />
        </aside>

        <div class="category-products">
            <div id="category-products-list" class="category-products-list">
                @if($productsWithPagination)
                    @each('product-list-item', $productsWithPagination['products'], 'product')
                @endif

                @if($skusWithPagination)
                    @each('product-list-item-sku', $skusWithPagination['skus'], 'sku')
                @endif
            </div>

            <products />
        </div>
    </div>

    @include('recently-viewed')
@endsection