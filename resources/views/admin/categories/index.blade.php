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
                            <div class="card-30">
                                <div class="card-img-container">
                                    <img src="
                                        @if(isset($category->image))
                                            {{ asset('imgs/categories/')}}/{{ $category->image }}
                                        @else
                                            {{ asset('imgs/nopic.png')}}
                                        @endif
                                    " class="card-img-top img-fluid">
                                </div>                                
                                <div class="card-body">
                                    <a href="{{ route('admin.products.index', ['category' => $category->id]) }}">
                                        <h5 class="card-title">{{ $category->category }}</h5>
                                    </a>
                                    @isset($category->parents)
                                        <p class="card-text">родит.кат.: <a href="{{ route('admin.categories.edit', ['id' => $category->parents->id]) ?? '' }}" class="badge badge-light">{{ $category->parents->category }}</a></p>
                                    @endisset
                                    <p class="card-text">{{ mb_substr(strip_tags($category->description), 0, 50) }}{{ strlen ($category->description ) > 50 ? "..." : "" }}</p>
                                    <span>товаров в категории: </span>{{ $category->products->count() }} | <span>просмотров: {{ $category->views }}</span>
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                        
                                            
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.categories.destroy', $category)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
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