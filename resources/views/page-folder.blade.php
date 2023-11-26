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
                {{ $page->name }}
            </a>
        @endforeach
    </div>
@endsection