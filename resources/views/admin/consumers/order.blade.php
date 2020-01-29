@extends('layouts.admin-app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Детали заказа №<strong>{{ $order->number }}</strong> от {{ $order->create_d_m_y_t }} (покупатель: {{ $consumer->full_name ?? '' }})</p>
                    {{-- <a href="{{ route('admin.consumers.create') }}" class="btn btn-primary">Новый покупатель</a>                 --}}
                </div>
                <div class="card-body">

                    <table class="table cart_table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Сумма</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th>
                                        <div class="cart_table__item d-flex">
                                               
                                            @if(isset($product->category->slug))
                                                <div class="product_title"><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}" target="_blank">{{ Str::limit($product->product, 30, '... ') }}</a></div>
                                            @else
                                                <div class="product_title"><a href="{{ route('product.without_category', $product->slug) }}" target="_blank">{{ Str::limit($product->product, 30, '... ') }}</a></div>
                                            @endif
                                        </div>
                                    </th>
                                    <th>                                        
                                        <div class="">{{ number_format($product->pivot->price, 2, ',', ' ') }} руб.</div>
                                    </th>
                                    <th>
                                        {{ $product->pivot->amount }}
                                        {{ $product->unit->unit ?? 'ед.' }}
                                        
                                    </th>
                                    <th>
                                        {{ number_format($product->pivot->amount * $product->pivot->price, 2, ',', ' ') }} руб.
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                      @if (!$order->unread)
                        <div class="p-1">Заказ просмотрен администратором: {{ $order->read_d_m_y_t ?? '' }}</div>
                      @endif
                        
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection