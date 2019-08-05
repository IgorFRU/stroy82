@extends('layouts.admin-app')

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
                <div class="card-header"><p class="h3">Новая категория</p></div>
                <div class="card-body">
                    
                    
                    <form action="{{route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Forme include --}}
            
                        @include('admin.categories.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection