@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('scripts')
    @parent
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Редактирование пункта меню 
                    <button type="button" class="btn btn-primary">{{ $menu->menu }}</button></p>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.menus.update', ['id' => $menu->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.menus.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection