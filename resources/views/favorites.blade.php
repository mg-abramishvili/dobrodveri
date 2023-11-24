@extends('layouts.front')
@section('title', 'Избранное - Добродвери')
@section('description', 'Избранное - Добродвери')
@section('content')
    <div class="container breadcrumbs">
        <ul>
            <li>
                <a href="/">Главная</a>
            </li>
            <li>
                <a>Избранное</a>
            </li>
        </ul>
    </div>

    <div class="container page-detail">
        <h1 class="title-header">Избранные товары</h1>

            <favorites />
    </div>
@endsection