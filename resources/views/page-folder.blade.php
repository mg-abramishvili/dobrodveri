@extends('layouts.front')
@section('title', $title . '- Добродвери')
@section('description', $title . '- Добродвери')
@section('content')
    <div class="container page-detail">
        <h1 class="title-header">{{ $title }}</h1>

        <div class="page-folder">
            @foreach($pagesF as $page)
                <a href="/p/{{ $page->slug }}">
                    <div class="page-cover" style="background-image: url({{$page->cover ? $page->cover : '/img/no-image.jpg'}})"></div>
                    <div class="page-f-desc">
                        <div class="page-f-name">
                            {{ $page->name }}
                        </div>
                        <div class="page-f-more">Подробнее</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection