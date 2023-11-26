@extends('layouts.front')
@section('title', $title . '- Добродвери')
@section('description', $title . '- Добродвери')
@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li>
                <a href="/">Главная</a>
            </li>
            <li>
                <a>{{ $title }}</a>
            </li>
        </ul>
    </div>

    <div class="container page-detail">
        <h1 class="title-header">{{ $title }}</h1>

        @foreach($pagesF as $page)
            <a href="/p/{{ $page->slug }}">
                <div class="page-cover" style="background-image: url({{$page->cover ? $page->cover : '/img/no-image.jpg'}})"></div>
                {{ $page->name }}
            </a>
        @endforeach
    </div>
@endsection