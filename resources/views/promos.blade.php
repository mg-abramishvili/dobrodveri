@extends('layouts.front')
@section('title', 'Акции - Добродвери')
@section('description', 'Акции - Добродвери')
@section('content')
    <div class="container page-promos">
        <h1 class="title-header">Акции</h1>

        <div class="promos-list">
            @forelse($promos as $promo)
                <a href="/promo/{{ $promo->id }}" class="promo-list-item">
                    <div class="promo-list-item-image" style="background-image: url({{ $promo->image ? $promo->image : '/img/no-image.jpg' }});"></div>
                    
                    <div class="promo-list-item-desc">
                        <h5>
                            {{ $promo->name }}
                        </h5>
                    </div>
                </a>
            @empty
                <p>Акции сейчас нет.</p>
            @endforelse
        </div>
    </div>
@endsection