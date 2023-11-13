@extends('layouts.front')
@section('title', $product["name"] . ' - Добродвери')

@section('content')
    <div class="container">
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
@endsection