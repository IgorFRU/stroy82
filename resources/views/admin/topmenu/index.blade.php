@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Пункты верхнего меню</p>
                    <a href="{{ route('admin.topmenu.create') }}" class="btn btn-primary">Новый пункт меню</a>                
                </div>
                <div class="d-flex flex-wrap">
                    @forelse ($topmenus as $topmenu)
                            <div class="card-30">                               
                                <div class="card-body">
                                    <h5 class="card-title">{{ $topmenu->title }}</h5>
                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.topmenu.edit', ['id' => $topmenu->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.topmenu.destroy', $topmenu)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning">Вы еще не добавили ни одного пункта меню!</div>
                            
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection