@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Статьи</p>
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">Новая статья</a>                
                </div>
                <div class="d-flex flex-wrap col-lg-12">
                    @forelse ($articles as $article)
                            <div class="card-30">
                                <div class="card-img-container">
                                    <img src="
                                        @if(isset($article->image))
                                            {{ asset('imgs/articles/')}}/{{ $article->image }}
                                        @else
                                            {{ asset('imgs/nopic.png')}}
                                        @endif
                                    " class="card-img-top img-fluid">
                                </div>                                
                                <div class="card-body">
                                    <a href="{{ route('admin.products.index', ['article' => $article->id]) }}">
                                        <h5 class="card-title">{{ $article->article }}</h5>
                                    </a>
                                    <p class="card-text">{{ mb_substr(strip_tags($article->description), 0, 50) }}{{ strlen ($article->description ) > 50 ? "..." : "" }}</p>
                                    <span>товаров в статье: </span>{{ $article->products->count() }}
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.articles.edit', ['id' => $article->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                        
                                            
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.articles.destroy', $article)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning col-lg-12">Вы еще не добавили ни одной статьи!</div>
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection