@extends('layouts.front')
@section('title', $product["name"] . ' - Добродвери')

@section('content')
    <div class="container product-detail">
        <div class="product-detail-image-sliders">
            <product-slider :product="{{ json_encode($product) }}"></product-slider>
        </div>

        <div class="product-detail-desc">
            <h1>{{ $product["name"] }}</h1>
            
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
@endsection