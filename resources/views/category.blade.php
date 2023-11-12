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

            @if(request()->types)
                types="{{ request()->types }}"
            @endif

            @if(request()->innerdecors)
                innerdecors="{{ request()->innerdecors }}"
            @endif

            @if(request()->furnituretypes)
                furnituretypes="{{ request()->furnituretypes }}"
            @endif

            @if(request()->purposes)
                purposes="{{ request()->purposes }}"
            @endif

            @if(request()->surafces)
                surafces="{{ request()->surafces }}"
            @endif

            @if(request()->colors)
                colors="{{ request()->colors }}"
            @endif

            @if(request()->glasses)
                glasses="{{ request()->glasses }}"
            @endif
        />
    </div>
@endsection