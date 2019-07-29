@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Производители</p>
                    <a href="{{ route('admin.manufactures.create') }}" class="btn btn-primary">Новый производитель</a>                
                </div>
                <div class="d-flex flex-wrap">
                    @forelse ($manufactures as $manufacture)
                            <div class="card-30">
                                <div class="card-img-container">
                                    <img src="
                                        @if(isset($manufacture->image))
                                            {{ asset('imgs/categories/')}}/{{ $manufacture->image }}
                                        @else
                                            {{ asset('imgs/nopic.png')}}
                                        @endif
                                    " class="card-img-top img-fluid">
                                </div>                                
                                <div class="card-body">
                                    <a href="{{ route('admin.products.index', ['category' => $manufacture->id]) }}">
                                        <h5 class="card-title">{{ $manufacture->manufacture }}</h5>
                                    </a>
                                    <p class="card-text">страна: {{ $manufacture->country ?? '' }}</p>
                                    <p class="card-text">{{ $manufacture->description }}</p>
                                    <span>товаров производителя: </span>{{ $manufacture->products->count() }}
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.manufactures.edit', ['id' => $manufacture->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.manufactures.destroy', $manufacture)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning">Вы еще не добавили ни одного производителя!</div>
                            
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection