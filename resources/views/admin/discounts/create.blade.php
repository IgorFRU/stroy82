@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu2')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Новая акция</p></div>
                <div class="card-body">
                    
                    
                    <form action="{{route('admin.discounts.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Forme include --}}
            
                        @include('admin.discounts.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection