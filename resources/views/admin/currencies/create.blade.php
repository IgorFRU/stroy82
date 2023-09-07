@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.tiny.cloud/1/4ogn001qp1t620kw68fag111as9qnq1nqba3n4ycar2puh9p/tinymce/5/tinymce.min.js"></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
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
                <div class="card-header"><p class="h3">Новая валюта</p></div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{route('admin.currencies.store')}}" method="post" enctype="multipart/form-data">
                        @csrf            
                        @include('admin.currencies.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection