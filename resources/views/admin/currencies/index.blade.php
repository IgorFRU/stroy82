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
                    <p class="h3">Валюты</p>
                    <a href="{{ route('admin.currencies.create') }}" class="btn btn-primary">Новая валюта</a>                
                </div>
                <div class="d-flex flex-wrap col-lg-12">
                    @forelse ($currencies as $currency)
                            <div class="card-30">                               
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="text-muted">{{ Carbon\Carbon::parse($currency->created_at)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}</span>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $currency->currency_rus }}</h5>
                                    <p class="card-text">{{ $currency->currency }}</p>
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.currencies.edit', ['id' => $currency->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                        
                                            
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.currencies.destroy', $currency)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning col-lg-12">Вы еще не добавили ни одной валюты!</div>
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection