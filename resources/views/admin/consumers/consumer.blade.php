@extends('layouts.admin-app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card @if ($consumer->is_online) border-success @endif">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">{{ $consumer->full_name }}  (id: {{ $consumer->id }}) @if (!$consumer->quick) <button class="btn btn-sm btn-warning ml-1" title="Пользователь прошел полноценную регистрацию"><i class="fas fa-user-plus"></i></button> @endif @if ($consumer->is_online) <button class="btn btn-sm btn-success" title="Пользователь сейчас на сайте">online</button> @endif</p>
                </div>
                <div class="card-body">
                    <div class="consumer_info mb-4">
                        <div class="row">
                            <div class="col-lg-3"><small class="text-muted">Фамилия</small></div>
                            <div class="col-lg-3"><small class="text-muted">Имя</small></div>
                            <div class="col-lg-3"><small class="text-muted">№ телефона</small></div>
                            <div class="col-lg-3"><small class="text-muted">e-mail</small></div>
                            <div class="w-100 mb-2"></div>
                            <div class="col-lg-3"><strong>{{ $consumer->surname ?? '-' }}</strong></div>
                            <div class="col-lg-3"><strong>{{ $consumer->name ?? '-' }}</strong></div>
                            <div class="col-lg-3"><strong>{{ $consumer->phone ?? '-' }}</strong></div>
                            <div class="col-lg-3"><strong>{{ $consumer->email ?? '-' }}</strong></div>
                            <div class="w-100 mb-4"></div>
                            <div class="col-lg-6"><small class="text-muted">Адрес</small></div>
                            <div class="col-lg-3"><small class="text-muted">Дата регистрации</small></div>
                            <div class="col-lg-3"><small class="text-muted">Последняя активность</small></div>
                            <div class="w-100 mb-2"></div>
                            <div class="col-lg-6"><strong>{{ $consumer->address ?? '-' }}</strong></div>
                            <div class="col-lg-3"><strong>{{ $consumer->create_d_m_y_t ?? '' }}</strong></div>
                            <div class="col-lg-3"><strong>{{ $consumer->activity_d_m_y_t ?? $consumer->create_d_m_y_t }}</strong></div>
                        </div>
                    </div>
                    <hr>
                    <h4>Заказы покупателя</h4>
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
                            @forelse ($consumer->orders as $order)
                                <tr @if ($order->completed) class="bg-secondary text-light" title='Заказ завершён' @endif>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th><a href="{{ route('admin.consumer.order', ['consumer' => $consumer, 'order' => $order->number]) }}">{{ $order->number ?? '' }}</a>@if ($order->unread) <button class="btn btn-sm btn-danger" title="Новый заказ, требующий реакции!">NEW</button> @endif</th>
                                    <th>@if ($order->successful_payment) <div class="order_successful_payment true"><span><i class="fas fa-check"></i></span> Оплачен</div> @else <div class="order_successful_payment false"><span><i class="fas fa-times"></i></span> Не оплачен</div> @endif</th>
                                    <th>{{ $order->create_d_m_y_t }}</th>
                                    <th>{{ $order->summ }}</th>
                                    <th>{{ $order->count_products ?? '' }}</th>
                                    <th style="color: {!! $status->color ?? '' !!}" title=" {{ $order->status->orderstatus ?? '' }}">{!! $order->status->icon ?? $order->status->orderstatus !!}</th>
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