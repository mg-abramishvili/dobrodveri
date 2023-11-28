@extends('layouts.front')
@section('title', 'Каталог - Добродвери')

@section('content')
    <div class="container category">
        <products
            :category="{{ $category }}"

            @if(request()->price_from)
                price_from="{{ request()->price_from }}"
            @endif

            @if(request()->price_to)
                price_to="{{ request()->price_to }}"
            @endif

            @if(request()->order)
                order="{{ request()->order }}"
            @endif
            
            @if(request()->order_direction)
                order_direction="{{ request()->order_direction }}"
            @endif

            @if(request()->type)
                type="{{ request()->type }}"
            @endif

            @if(request()->style)
                style="{{ request()->style }}"
            @endif

            @if(request()->innerdecor)
                innerdecor="{{ request()->innerdecor }}"
            @endif

            @if(request()->furnituretype)
                furnituretype="{{ request()->furnituretype }}"
            @endif

            @if(request()->purpose)
                purpose="{{ request()->purpose }}"
            @endif

            @if(request()->surface)
                surface="{{ request()->surface }}"
            @endif

            @if(request()->color)
                color="{{ request()->color }}"
            @endif

            @if(request()->glass)
                glass="{{ request()->glass }}"
            @endif
        />
    </div>
@endsection