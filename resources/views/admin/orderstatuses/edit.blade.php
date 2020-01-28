@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Редактирование статуса 
                    <button type="button" class="btn btn-primary">{{ $orderstatus->orderstatus }}</button></p>
                </div>
                <div class="card-body">
                        {{-- Forme include --}}
                    <form action="{{route('admin.orderstatuses.update', ['id' => $orderstatus->id])}}" method="post" >
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.orderstatuses.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection