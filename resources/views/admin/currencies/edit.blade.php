@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.tiny.cloud/1/4ogn001qp1t620kw68fag111as9qnq1nqba3n4ycar2puh9p/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'#description',
            plugins: "anchor link insertdatetime lists"
        });
    </script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Редактирование валюты 
                    <button type="button" class="btn btn-primary">{{ $currency->currency }}</button></p>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.currencies.update', ['id' => $currency->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.currencies.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection