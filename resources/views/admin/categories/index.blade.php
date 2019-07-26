@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Категории товаров</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Новая категория</a>                
                </div>
                <div class="d-flex flex-wrap">
                    @forelse ($categories as $category)
                            <div class="card col-lg-4" style="width: 18rem;">
                                <div class="card-img-container">
                                    <img src="{{ asset('imgs/categories/')}}/{{ $category->image }}" class="card-img-top img-fluid" alt="{{ $category->category }}">
                                </div>                                
                                <div class="card-body">
                                    <h5 class="card-title">{{ $category->category }}</h5>
                                    @isset($category->parents)
                                        <p class="card-text">родит.кат.: <a href="{{ route('admin.categories.edit', ['id' => $category->parents->id]) ?? '' }}" class="badge badge-light">{{ $category->parents->category }}</a></p>
                                    @endisset
                                    <p class="card-text">{{ $category->description }}</p>
                                    <div class="row d-flex justify-content-between">
                                        <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}" class="btn btn-warning col-sm-4">Редактировать</a>
                                        <div class="input-group col-sm-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control" disabled value="{{ $category->views }}">
                                        </div>
                                        <div class="input-group col-sm-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
                                            </div>
                                            <input type="text" class="form-control" disabled value="{{ $category->products->count() }}">
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            
                        @empty
                            Вы еще не добавили ни одной категории
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection