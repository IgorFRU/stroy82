@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Товары @isset($parent_category)
                        из категории "{{ $parent_category }}"
                    @endisset</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Новый товар</a>                
                </div>
                <div class="col-md-12">
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Наличие</th>
                            <th scope="col">Срок доставки</th>
                            <th scope="col">Оплата онлайн</th>
                            <th scope="col"></th>
                            {{-- <th scope="col">Описание</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = 1
                        @endphp   
                        @forelse ($products as $product)
                        <tr>
                            <th scope="row">{{ $count++ }}</th>
                            <td>{{ $product->product }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->category->category }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->delivery_time }}</td>
                            <td>{{ $product->pay_online }}</td>
                            <td>
                                <div class="row">                                
                                    <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                    <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.products.destroy', $product)}}" method="post">
                                    @csrf                         
                                    <input type="hidden" name="_method" value="delete">                         
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>                                                 
                                </form>
                                </div>
                            </td>
                            {{-- <td>{{ $vendor->description }}</td> --}}
                        </tr>
                        @empty
                            <div class="alert alert-warning">Вы еще не добавили ни одного товара!</div>
                        @endforelse
                    
                
            </div>
        </div>
    </div>
</div>
@endsection