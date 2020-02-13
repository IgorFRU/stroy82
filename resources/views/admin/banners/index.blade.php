@extends('layouts.admin-app')

@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu2')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Баннеры</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Новый баннер</a>                
                </div>
                <div class="d-flex flex-wrap col-lg-12">
                    @forelse ($banners as $banner)
                            <div class="card-30">
                                <div class="card-img-container">
                                    <img src="
                                        @if(isset($banner->image))
                                            {{ asset('imgs/banners/')}}/{{ $banner->image }}
                                        @endif
                                    " class="card-img-top img-fluid">
                                </div>                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">                                        
                                        <div>
                                            <h3>{{ $banner->title ?? '' }}</h3>
                                        </div>
                                    </div>
                                    <p class="card-text">{{ mb_substr(strip_tags($banner->description), 0, 50) }}</p>                                    
                                    <p class="card-text">{{ mb_substr(strip_tags($banner->link), 0, 50) }}</p>                                    
                                    <div class="card_buttons">
                                        <a href="{{ route('admin.banners.edit', ['id' => $banner->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i>  Редактировать</a>
                                        
                                            
                                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.banners.destroy', $banner)}}" method="post">
                                                @csrf                         
                                                 <input type="hidden" name="_method" value="delete">                         
                                                 <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>  Удалить</button>                                                 
                                             </form>
                                    </div>                                   
                                </div>
                            </div>
                            
                        @empty
                        <div class="alert alert-warning col-lg-12">Вы еще не добавили ни одного баннера!</div>
                        @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection