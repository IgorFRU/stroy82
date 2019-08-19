@extends('layouts.admin-app')

@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Группы товаров</p>
                    <a href="{{ route('admin.sets.create') }}" class="btn btn-primary">Новая группа</a>                
                </div>
                <div class="d-flex flex-wrap col-lg-12">
                    @forelse ($sets as $set)
                            <div class="card-30">
                                <div class="card-img-container">
                                    <img src="
                                        @if(isset($set->image))
                                            {{ asset('imgs/sets/')}}/{{ $set->image }}
                                        @else
                                            {{ asset('imgs/nopic.png')}}
                                        @endif
                                    " class="card-img-top img-fluid">
                                </div>                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted">товаров привязано: {{ $set->products->count() }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.products.index', ['set' => $set->id]) }}">
                                        <h5 class="card-title">{{ $set->set }}</h5>
                                    </a>
                                    <p class="card-text">{{ mb_substr(strip_tags($set->description), 0, 50) }}{{ strlen ($set->description ) > 50 ? "..." : "" }}</p>
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.sets.edit', ['id' => $set->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                        
                                            
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.sets.destroy', $set)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning col-lg-12">Вы еще не добавили ни одной группы товаров!</div>
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection