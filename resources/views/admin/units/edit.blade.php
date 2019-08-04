@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Редактирование единицы измерения 
                    <button type="button" class="btn btn-primary">{{ $unit->unit }}</button></p>
                </div>
                <div class="card-body">
                        {{-- Forme include --}}
                    <form action="{{route('admin.units.update', ['id' => $unit->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.units.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection