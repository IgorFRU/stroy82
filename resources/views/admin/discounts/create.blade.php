@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Новый производитель</p></div>
                <div class="card-body">
                    
                    
                    <form action="{{route('admin.manufactures.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Forme include --}}
            
                        @include('admin.manufactures.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection