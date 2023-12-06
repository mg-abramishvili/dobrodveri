@php
    $productsWithPagination = json_decode($productsWithPagination, true);
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
                    reqPriceFrom="{{ request()->price_from }}"
                @endif

                @if(request()->price_to)
                    reqPriceTo="{{ request()->price_to }}"
                @endif

                @if(request()->order)
                    reqOrder="{{ request()->order }}"
                @endif
                
                @if(request()->order_direction)
                    reqOrderDirection="{{ request()->order_direction }}"
                @endif

                @if(request()->type)
                    reqType="{{ request()->type }}"
                @endif

                @if(request()->style)
                    reqStyle="{{ request()->style }}"
                @endif

                @if(request()->innerdecor)
                    reqInnerDecor="{{ request()->innerdecor }}"
                @endif

                @if(request()->furnituretype)
                    reqFurnitureType="{{ request()->furnituretype }}"
                @endif

                @if(request()->purpose)
                    reqPurpose="{{ request()->purpose }}"
                @endif

                @if(request()->surface)
                    reqSurface="{{ request()->surface }}"
                @endif

                @if(request()->color)
                    reqColor="{{ request()->color }}"
                @endif

                @if(request()->glass)
                    reqGlass="{{ request()->glass }}"
                @endif
            />
        </aside>

        <div class="category-products">
            <div id="category-products-list" class="category-products-list">
                @each('product-list-item', $productsWithPagination['products'], 'product')
            </div>

            <products />
        </div>
    </div>

    @include('recently-viewed')
@endsection