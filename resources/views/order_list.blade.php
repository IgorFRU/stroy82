@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Личный кабинет @endslot
        @slot('parent_route') {{ route('home') }} @endslot 
               
        @slot('active') Заказы @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <h3>Список заказов</h3>
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">№ заказа</th>
                        <th scope="col">Статус оплаты</th>
                        <th scope="col">Дата заказа</th>
                        <th scope="col">Сумма заказа</th>
                        <th scope="col">Кол-во товаров</th>
                        <th scope="col">Статус</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <th><a href="{{ route('orderShow', ['order' => $order->number]) }}">{{ $order->number ?? '' }}</a>@if ($order->unread) <button class="btn btn-sm btn-danger" title="Новый заказ, требующий реакции!">NEW</button> @endif</th>
                                <th>@if ($order->successful_payment) <div class="order_successful_payment true"><span><i class="fas fa-check"></i></span> Оплачен</div> @else <div class="order_successful_payment false"><span><i class="fas fa-times"></i></span> Не оплачен</div> @endif</th>
                                <th>{{ $order->create_d_m_y_t }}</th>
                                <th>{{ $order->summ }}</th>
                                <th>{{ $order->count_products ?? '' }}</th>
                                <th style="color: {!! $order->status->color ?? '' !!}" title=" {{ $order->status->orderstatus ?? '' }}">{!! $order->status->icon ?? $order->status->orderstatus !!}</th>
                            </tr>
                        @empty
                            
                        @endforelse                 
                    </tbody>
                  </table>
                
            </div>
        </div>
    </section>
    
    
      
@endsection