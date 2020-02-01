@extends('layouts.admin-app')
@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Активные заказы</p>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">№ заказа</th>
                            <th scope="col">Статус оплаты</th>
                            <th scope="col">Дата заказа</th>
                            <th scope="col">Покупатель</th>
                            <th scope="col">Сумма заказа</th>
                            <th scope="col">Кол-во товаров</th>
                            <th scope="col">Статус</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th><a href="{{ route('admin.order', ['order' => $order->number]) }}">{{ $order->number ?? '' }}</a>@if ($order->unread) <button class="btn btn-sm btn-danger" title="Новый заказ, требующий реакции!">NEW</button> @endif</th>
                                    <th>@if ($order->successful_payment) <div class="order_successful_payment true"><span><i class="fas fa-check"></i></span> Оплачен</div> @else <div class="order_successful_payment false"><span><i class="fas fa-times"></i></span> Не оплачен</div> @endif</th>
                                    <th>{{ $order->create_d_m_y_t }}</th>
                                    <th>@if (isset($order->consumers))
                                        <a href="{{ route('admin.consumer', $order->consumers->id) }}">{{ $order->consumers->full_name ?? '' }}</a> @if ($order->consumers->is_online) <button class="btn btn-sm btn-success ml-1" title="Пользователь сейчас на сайте">online</button> @endif @if (!$order->consumers->quick) <button class="btn btn-sm btn-warning ml-1" title="Пользователь прошел полноценную регистрацию"><i class="fas fa-user-plus"></i></button> @endif
                                    @else
                                        -пользователь не найден или удалён-
                                    @endif
                                        </th>
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
        </div>
    </div>
</div>
@endsection