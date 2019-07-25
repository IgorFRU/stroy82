@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><p class="h3">Новая категория</p></div>
                <div class="card-body">
                    
                    
            
                        {{-- Forme include --}}
            
                        @include('admin.categories.partials.form')
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection