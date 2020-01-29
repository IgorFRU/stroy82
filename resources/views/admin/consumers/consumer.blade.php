@extends('layouts.admin-app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">{{ $consumer->full_name }} (id: {{ $consumer->id }}) @if ($consumer->is_online) <button class="btn btn-sm btn-success" title="Пользователь сейчас на сайте">online</button> @endif</p>
                    {{-- <a href="{{ route('admin.consumers.create') }}" class="btn btn-primary">Новый покупатель</a>                 --}}
                </div>
                <div class="d-flex flex-wrap">

                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">№ заказа</th>
                            <th scope="col">Дата заказа</th>
                            <th scope="col">Сумма заказа</th>
                            <th scope="col">Кол-во товаров</th>
                            <th scope="col">Статус</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($consumer->orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <th><a href="{{ route('admin.consumer.order', ['consumer' => $consumer, 'order' => $order->number]) }}">{{ $order->number ?? '' }}</a>@if ($order->unread) <button class="btn btn-sm btn-danger" title="Новый заказ, требующий реакции!">NEW</button> @endif</th>
                                    <th>{{ $order->created_at }}</th>
                                    <th>{{ $order->summ }}</th>
                                    <th>{{ $order->count_products ?? '' }}</th>
                                    <th style="color: {!! $status->color ?? '' !!}" title=" {{ $order->status->orderstatus ?? '' }}">{!! $order->status->icon ?? '' !!}</th>
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