@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
               
        @slot('active') Корзина @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                @if (count($cart)>0)
                @php
                    $count = 1;
                @endphp
                <table class="table cart_table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Сумма</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                <tr>
                                    <th scope="row">{{ $count++ }}</th>
                                    <th>
                                        <div class="cart_table__item d-flex">
                                            @if (isset($item->product->main_or_first_image->thumbnail))
                                                <img src="{{ asset('imgs/products/thumbnails')}}/{{ $item->product->main_or_first_image->thumbnail ??  '' }}">
                                            @else
                                                <img src="{{ asset('imgs/nopic.png') ??  '' }}">
                                            @endif
    
                                            @if(isset($item->product->category->slug))
                                                <div class="product_title"><a href="{{ route('product', ['category' => $item->product->category->slug, 'product' => $item->product->slug]) }}">{{ Str::limit($item->product->product, 30, '... ') }}</a></div>
                                            @else
                                                <div class="product_title"><a href="{{ route('product.without_category', $item->product->slug) }}">{{ Str::limit($item->product->product, 30, '... ') }}</a></div>
                                            @endif
                                        </div>
                                    </th>
                                    <th>
                                        @if ($item->product->actually_discount)
                                            <div class="">{{ number_format($item->product->discount_price, 2, ',', ' ') }} руб.</div>                                        
                                        @else
                                            <div class="">{{ number_format($item->product->price, 2, ',', ' ') }} руб.</div>
                                        @endif
                                    </th>
                                    <th>
                                        <div class="cart_table__item_quantity">
                                            <span class="cart_table__item_quantity_minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                            <input type="text" readonly class="cart__product__input_units" name="product__input_units" id="{{ $item->product->id }}" data-package="{{ $item->product->unit_in_package ?? 1 }}" value="{{ $item->quantity }}"> 
                                            <span class="cart_table__item_quantity_plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>   
                                            <span class="btn btn-sm l-green product__inpunt_accept"><i class="far fa-check-circle"></i></span>
                                        </div>
                                        {{ $item->product->unit->unit ?? 'ед.' }}
                                        
                                    </th>
                                    <th>
                                        @if ($item->product->actually_discount)
                                            <div class="">{{ number_format($item->product->discount_price * $item->quantity, 2, ',', ' ') }} руб.</div>                                        
                                        @else
                                            <div class="">{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} руб.</div>
                                        @endif
                                    </th>
                                    <th>
                                        <form onsubmit="if(confirm('Удалить данный товар из корзины?')) {return true} else {return false}" action="{{route('cart.destroy', $item->id)}}" method="post">
                                            @csrf                         
                                            <input type="hidden" name="_method" value="delete">                         
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>                                                 
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                @else
                    Ваша корзина пуста! К покупкам!
                @endif
                
            </div>
            <div class="col-lg-12 row d-flex justify-content-end">
                <div class="cart_table_sum bg-m-grey p10 color-white">
                    <div class="d-flex justify-content-between">
                        <div class="cart_table_sum__title">Товаров: </div>
                        <div class="cart_table_sum__content"> {{ $count-1 ?? '' }}</div>
                    </div>
                    @if ($mass > 0)
                    <div class="d-flex justify-content-between">
                        <div class="cart_table_sum__title">Примерная масса: </div>
                        <div class="cart_table_sum__content"> {{ $mass . ' кг.' ?? '' }}</div>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <div class="cart_table_sum__title">Итого: </div>
                        <div class="cart_table_sum__content"> {{ number_format($sum, 2, ',', ' '). ' руб.' ?? '0 руб.' }}</div>
                    </div>
                </div>
            </div>   
            <div class="col-lg-12 row d-flex justify-content-end">
                <a href="{{ route('order.index') }}" class="btn btn-success">Оформить заказ</a>
            </div>
        </div>
    </section>
    
    
      
@endsection