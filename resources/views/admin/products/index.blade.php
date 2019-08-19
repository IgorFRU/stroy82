@extends('layouts.admin-app')
@section('adminmenu')
    @parent
    @include('admin.partials.adminmenu')
@endsection
@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Товары @isset($parent_category)
                        из категории "{{ $parent_category }}"
                    @endisset
                    @isset($parent_manufacture)
                        производителя "{{ $parent_manufacture }}"
                    @endisset</p>
                    
                    <div class="row col-md-6">
                        <div class="col-md-5">
                            <select class="form-control" id="index_category_id" name="index_category_id">
                                <option value="0">-- Все категории --</option>
                                @include('admin.products.partials.categories', ['categories' => $categories])
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="index_manufacture_id" name="index_manufacture_id">
                                <option value="0">-- Все производители --</option>
                                
                                @foreach ($manufactures as $manufacture)
                                    <option value="{{ $manufacture->id }}"
                                        @isset($current_manufacture)
                                            @if($current_manufacture == $manufacture->id)
                                                selected="selected"
                                            @endif
                                            @if ($manufacture->products->count() == 0)
                                                disabled='disabled'
                                            @endif
                                        @endisset 
                                        @isset($product->category_id)
                                            @if ($category_list->id == $product->category_id)
                                            selected = "selected"
                                            @endif
                                        @endisset 
                                        >{{ $manufacture->manufacture }} ({{ $manufacture->products->count() }})</option>
                                                                     
                                @endforeach
                            </select>
                        </div> 
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary col-md-2">Новый товар</a> 
                    </div>
                                   
                </div>
                <div class="col-md-12">
                    
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Арт.</th>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Категория</th>
                            <th scope="col">Наличие</th>
                            <th scope="col">Срок доставки</th>
                            <th scope="col">Оплата онлайн</th>
                            <th scope="col"></th>
                            {{-- <th scope="col">Описание</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = 1
                        @endphp   
                        @forelse ($products as $product)
                        @php
                            // dd($product)
                        @endphp
                        <tr @if (!$product->published) class='bg-secondary'  @endif>
                            <th scope="row">{{ $count++ }}</th>
                            <td>{{ $product->autoscu }}</td>
                            <td>{{ $product->product }}</td>
                            <td>
                                @isset($product->discount)
                                    @if ($product->discount->type == '%')
                                        <div class='btn-group' role="group">
                                            <div class="btn text-light bg-success btn-sm" data-toggle="tooltip" data-placement="top" title="Акция '{{ $product->discount->discount }}' до {{ Carbon\Carbon::parse($product->discount->discount_end)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}"> 
                                                {{ $product->price * $product->discount->numeral }} руб.
                                            </div>
                                            <div class="btn text-light bg-secondary btn-sm">{{ $product->price_number }} руб.</div>
                                        </div>
                                    @elseif ($product->discount->type == 'rub')
                                        <div class='btn-group' role="group">
                                            <div class="btn text-light bg-success btn-sm" data-toggle="tooltip" data-placement="top" title="Акция '{{ $product->discount->discount }}' до {{ Carbon\Carbon::parse($product->discount->discount_end)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}">
                                                {{ $product->price - $product->discount->value }} руб.
                                            </div>
                                            <div class="btn text-light bg-secondary btn-sm">{{ $product->price_number }} руб.</div>
                                    @endif
                                @endisset
                                @empty ($product->discount)
                                    <div class="btn text-light bg-success btn-sm">{{ $product->price_number }} руб.</div>
                                @endempty
                                
                            
                            
                            </td>
                            <td>{{ $product->category->category ?? '' }}</td>
                            {{-- <td>{{ $product->manufactures->manufacture }}</td> --}}
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->delivery_time }}</td>
                            <td>{{ $product->pay_online }}</td>
                            <td>
                                <div class='row'>                                
                                    <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                    <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.products.destroy', $product)}}" method="post">
                                    @csrf                         
                                    <input type="hidden" name="_method" value="delete">                         
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>                                                 
                                </form>
                                </div>
                            </td>
                        </tr>
                        
                        @empty
                            <div class="alert alert-warning">Вы еще не добавили ни одного товара!</div>
                        @endforelse
                    </tbody>
                </table>
                <div class="paginate">
                    {{ $products->appends(request()->input())->links('layouts.pagination') }}
                </div>
                <div class="items_per_page">
                    <form  class="form-group row col-lg-6" action="{{ route('admin.products.index') }}" method="get">
                        <label for="pp" class="col-lg-3 col-form-label">Товаров на странице</label>
                        <div class="col-lg-2">
                            @php
                                $perPage = 5;
                                $count = 5;
                            @endphp
                            <select class="form-control" name="pp" id="pp">
                                @for ($i = 1; $i < $count; $i++)
                                @php
                                    $pP = $perPage * pow(2, $i);
                                @endphp
                                    <option @if ($pP == $itemsPerPage) selected='selected' @endif value="{!! $pP !!}">{!! $pP !!}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                                <select class="form-control" id="p_published" name="p_published">
                                    <option @if ($productPublished == 2) selected='selected' @endif value="2">Все</option>
                                    <option @if ($productPublished == 1) selected='selected' @endif value="1">Опублик.</option>
                                    <option @if ($productPublished == 0) selected='selected' @endif value="0">Неопублик.</option>
                                </select>
                            </div>
                        <button class="btn button-primary" type="submit">OK</button>        
                    </form> 
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection