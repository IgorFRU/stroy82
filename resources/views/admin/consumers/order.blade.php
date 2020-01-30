@extends('layouts.admin-app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card"  >
                <div class="card-header d-flex justify-content-between @if ($order->completed) text-white bg-secondary @endif">
                    <p class="h3">@if ($order->completed) <span class="p-1 bg-success rounded">Завершён</span> @endif Детали заказа №<strong>{{ $order->number }}</strong> от {{ $order->create_d_m_y_t }} (покупатель: {{ $consumer->full_name ?? '' }})</p>
                    {{-- <a href="{{ route('admin.consumers.create') }}" class="btn btn-primary">Новый покупатель</a>                 --}}
                </div>
                <div class="card-body">
                    <div class="order_control row p-2 mb-3">
                        <div class="row ml-2 mr-2">
                            <span class="">Текущий статус заказа: </span>
                            <div class="col">
                                <div style="color: {!! $order->status->color ?? '' !!}">{!! $order->status->icon ?? '' !!} {{ $order->status->orderstatus }}</div>
                            </div>                            
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#change_order_status">
                            Изменить статус заказа
                          </button>
                    </div>

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

<div class="modal" tabindex="-1" role="dialog" id="change_order_status">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Изменить статус заказа</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="orderstatus" class="col-sm-4 col-form-label">Статус заказа</label>
                <div class="col-sm-8">
                    <select class="form-control" name="orderstatus" id="orderstatus">
                        @forelse ($statuses as $status)
                            <option value="{{ $status->id }}" @if ($order->status->id == $status->id) selected @endif>{{ $status->orderstatus }}</option>
                        @empty
                            
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary active">
                    <input class="" type="radio" name="options" id="order_not_complited" autocomplete="off" @if (!$order->completed) checked  @endif> @if (!$order->completed) Заказ активен @else Сделать заказ активным  @endif
                </label>
                <label class="btn btn-danger">
                    <input class="" type="radio" name="options" id="order_complited" autocomplete="off" @if ($order->completed) checked  @endif> @if ($order->completed) Заказ завершён @else Завершить заказ @endif
                </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
          <button type="button" class="btn btn-primary">Сохранить</button>
        </div>
      </div>
    </div>
  </div>
@endsection