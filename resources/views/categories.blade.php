@extends('layouts.front')
@section('title', 'Каталог - Добродвери')
@section('description', 'Купить межкомнатные и входные двери в Уфе - Добродвери')

@section('content')
    <div class="container category">
        <h1 class="title-header">Каталог</h1>

        
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="/catalog/{{ $category->slug }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    @include('recently-viewed')
@endsection