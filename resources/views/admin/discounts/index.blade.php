@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Акции</p>
                    <div>
                        <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">Новая акция</a>  
                        @if ($actually)
                            <a href="{{ route('admin.discounts.archive') }}" class="btn btn-secondary">Архив акций</a>
                        @else
                            <a href="{{ route('admin.discounts.index') }}" class="btn btn-success">Актуальные акции</a>
                        @endif
                        
                    </div>
                                  
                </div>
                <div class="col-md-12">
                    
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Размер скидки</th>
                            <th scope="col">Начало</th>
                            <th scope="col">Окончание</th>
                            <th scope="col">Товаров</th>
                            {{-- <th scope="col">Описание</th> --}}
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = 1;
                        @endphp   
                        @forelse ($discounts as $discount)
                        <tr 
                            @if ($today->between(Carbon\Carbon::parse($discount->discount_start),
                                                 Carbon\Carbon::parse($discount->discount_end)))
                                class="table-success"
                            @elseif ($today->greaterThan(Carbon\Carbon::parse($discount->discount_start)->toDateString()))
                                class="table-secondary"
                            @else
                                class="table-warning"
                            @endif
                        >
                            <th scope="row">{{ $count++ }}
                            </th>
                            <td>{{ $discount->discount }}</td>
                            <td>{{ $discount->value }} @if ($discount->type === 'rub') руб. @else % @endif </td>
                            <td>{{ Carbon\Carbon::parse($discount->discount_start)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}</td>
                            <td>{{ Carbon\Carbon::parse($discount->discount_end)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}</td>
                            <td> </td>
                            {{-- <td>{{ mb_substr($discount->description, 0, 10) }}{{ strlen ($discount->description ) > 10 ? "..." : "" }}</td> --}}
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