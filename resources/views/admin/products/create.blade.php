@extends('layouts.admin-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/ajax_create_product.js') }}" defer></script>
    <script src="{{ asset('js/dropzone.js') }}" defer></script>
    <script src="https://cdn.tiny.cloud/1/4ogn001qp1t620kw68fag111as9qnq1nqba3n4ycar2puh9p/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'#description',
            plugins: "anchor link insertdatetime lists"
        });
    </script>
@endsection

@section('styles')  
    @parent  
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet">
@endsection

@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Новый товар</p></div>
                <div class="card-body">
                        {{-- Forme include --}}            
                        @include('admin.products.partials.form')                       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection