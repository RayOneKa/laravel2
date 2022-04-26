@extends('layouts.app')

@section('title')
    Список категорий
@endsection

@section('content')
    <h1>
        Список категорий
    </h1>

    <admin-categories-component :categories="{{$categories}}"></admin-categories-component>
@endsection