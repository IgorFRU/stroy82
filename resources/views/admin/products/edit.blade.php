@extends('layouts.admin-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/ajax_upload_product_image.js') }}" defer></script>
    <script src="https://cdn.tiny.cloud/1/4ogn001qp1t620kw68fag111as9qnq1nqba3n4ycar2puh9p/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'#description',
            plugins: "anchor link insertdatetime lists"
        });
    </script>
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
                <div class="card-header">
                    <div class="d-flex justify-content-lg-between">
                        <span class="h3">Редактирование товара 
                            <button type="button" class="btn btn-primary disabled">{{ $product->product }}</button>
                            @isset($product->id)                        
                                @if(isset($product->category->slug))
                                    <a target="_blank" class="btn btn-link" href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}"><i class="fas fa-external-link-alt"></i> Посмотреть на сайте</a>
                                @else
                                    <a target="_blank" class="btn btn-link" href="{{ route('product.without_category', $product->slug) }}"><i class="fas fa-external-link-alt"></i> Посмотреть на сайте</a>
                                @endif
                            @endisset
                        </span>
                        <button class="btn btn-success" data-toggle="modal" data-target="#productOptions">Добавить опции товара</button>
                    </div>                    
                </div>
                <div class="card-body">
                        {{-- Forme include --}}
                    
                        @include('admin.products.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection