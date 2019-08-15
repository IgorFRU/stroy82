@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Поставщики</p>
                    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">Новый поставщик</a>                
                </div>
                <div class="col-md-12">
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Поставщик</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">e-mail</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Срок доставки</th>
                            <th scope="col"></th>
                            {{-- <th scope="col">Описание</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = 1
                        @endphp   
                        @forelse ($vendors as $vendor)
                        <tr>
                            <th scope="row">{{ $count++ }}</th>
                            <td>{{ $vendor->vendor }}</td>
                            <td>{{ $vendor->address }}</td>
                            <td>{{ $vendor->email }}</td>
                            <td>{{ $vendor->phone }}</td>
                            <td>{{ $vendor->delivery_time }}</td>
                            <td>
                                <div class="row">

                                
                                    <a href="{{ route('admin.vendors.edit', ['id' => $vendor->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                    <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.vendors.destroy', $vendor)}}" method="post">
                                    @csrf                         
                                    <input type="hidden" name="_method" value="delete">                         
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>                                                 
                                </form>
                                </div>
                            </td>
                            {{-- <td>{{ $vendor->description }}</td> --}}
                        </tr>
                        @empty
                            <div class="alert alert-warning">Вы еще не добавили ни одного поставщика!</div>
                        @endforelse
                    
                
            </div>
        </div>
    </div>
</div>
@endsection