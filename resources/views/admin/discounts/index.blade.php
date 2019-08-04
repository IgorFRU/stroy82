@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Акции</p>
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">Новая акция</a>                
                </div>
                <div class="col-md-12">
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Размер скидки</th>
                            <th scope="col">Начало</th>
                            <th scope="col">Окончание</th>
                            <th scope="col">Товаров</th>
                            <th scope="col">Описание</th>
                            <th scope="col" class="col-md-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = 1
                        @endphp   
                        @forelse ($discounts as $discount)
                        <tr>
                            <th scope="row">{{ $count++ }}</th>
                            <td>{{ $discount->discount }}</td>
                            <td>{{ $discount->value }} {{ $discount->type }}</td>
                            <td>{{ $discount->discount_start }}</td>
                            <td>{{ $discount->discount_end }}</td>
                            <td> </td>
                            <td>{{ $discount->description }}</td>
                            <td>
                                <div class="row">                                
                                    <a href="{{ route('admin.discounts.edit', ['id' => $discount->id]) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                    <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.discounts.destroy', $discount)}}" method="post">
                                    @csrf                         
                                    <input type="hidden" name="_method" value="delete">                         
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>                                                 
                                </form>
                                </div>
                            </td>
                            {{-- <td>{{ $vendor->description }}</td> --}}
                        </tr>
                        @empty
                            <div class="alert alert-warning">Вы еще не добавили ни одной скидки!</div>
                        @endforelse
                    
                
            </div>
        </div>
    </div>
</div>
@endsection