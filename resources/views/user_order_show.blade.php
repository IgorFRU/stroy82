@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Корзина @endslot
        @slot('parent_route') {{ route('cart') }} @endslot 
               
        @slot('active') Оформление заказа @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                @if ($error != '')
                    <div class="col-lg-12 color-white bg-danger p10">
                        {{ $error }}
                    </div>
                @else
                    <h3>Заказ №{{ $order->number }} от {{ $order->d_m_y }}</h3>
                    <div class="col-lg-12 row">
                        <div class="col-lg-4">
                            товаров: {{ $order->products->count() }}
                        </div>                        
                        <div class="col-lg-4">
                            сумма заказа: 
                        </div>                      
                        <div class="col-lg-4">
                            способ оплаты: @if ($order->payment_method == 'on delivery')
                                оплата при получении товара
                            @elseif ($order->payment_method == 'firm')
                                безналичный расчёт
                            @elseif ($order->payment_method == 'online')
                                оплата онлайн
                            @endif
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </section>
    
    
      
@endsection