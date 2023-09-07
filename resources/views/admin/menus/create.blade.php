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
                <div class="card-header"><p class="h3">Новый пункт меню</p></div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{route('admin.menus.store')}}" method="post" enctype="multipart/form-data">
                        @csrf            
                        @include('admin.menus.partials.form')
                    </form>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection