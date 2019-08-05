@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Редактирование акции 
                    <button type="button" class="btn btn-primary">{{ $discount->discount }}</button></p>
                </div>
                <div class="card-body">
                        {{-- Forme include --}}
                    <form action="{{route('admin.discounts.update', ['id' => $discount->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.discounts.partials.form')
                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection