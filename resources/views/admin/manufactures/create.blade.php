@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">Новая категория</p></div>
                <div class="card-body">
                    
                    
                    <form action="{{route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Forme include --}}
            
                        @include('admin.categories.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection