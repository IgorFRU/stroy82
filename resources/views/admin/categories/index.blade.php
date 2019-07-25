@extends('layouts.admin-app')

@section('content')
@php
    $number = 1
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><p class="h3">Категории товаров</p></div>
                <div class="card-body">
                    <p class="h4">Уровень {{ $number++ }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection