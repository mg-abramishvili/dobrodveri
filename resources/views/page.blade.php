@extends('layouts.front')
@section('title', $page->name . '- Добродвери')
@section('description', $page->name . '- Добродвери')
@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li>
                <a href="/">Главная</a>
            </li>
            <li>
                <a>{{ $page->name }}</a>
            </li>
        </ul>
    </div>

    <div class="container page-detail">
        <h1 class="title-header">{{ $page->name }}</h1>

        {!! $page->text !!}
    </div>
@endsection