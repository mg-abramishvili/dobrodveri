@extends('layouts.front')
@section('title', $promo->name . ' - Добродвери')
@section('description', $promo->name . ' - Добродвери')
@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li class="nohash">
                <a href="/">Главная</a>
            </li>
            <li>
                <a href="/promos/">Акции</a>
            </li>
        </ul>
    </div>

    <div class="container page-promo">
        <h1 class="title-header">{{ $promo->name }}</h1>

        <img src="{{ $promo->image }}" alt="{{ $promo->name }}">

        <div class="page-promo-text">
            {!! $promo->description !!}
        </div>
    </div>
@endsection