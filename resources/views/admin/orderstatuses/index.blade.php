@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Статусы заказов</p>
                    <a href="{{ route('admin.orderstatuses.create') }}" class="btn btn-primary">Новый статус</a>                
                </div>
                <div class="d-flex flex-wrap">
                    @forelse ($orderstatuses as $status)
                            <div class="card-30">                               
                                <div class="card-body">
                                    <h5 class="card-title" style="color: {!! $status->color ?? '' !!}">{!! $status->icon ?? '' !!} {{ $status->orderstatus }}</h5>
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.orderstatuses.edit', ['id' => $status->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.orderstatuses.destroy', $status)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning">Вы еще не добавили ни одного статуса заказа!</div>
                            
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection