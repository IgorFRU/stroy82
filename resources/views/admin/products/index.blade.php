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
                    
                    <div class="row col-md-10">
                        <div class="col-md-3 row">
                            <label for="items_per_page" class="col-md-8 col-form-label">Товаров на странице</label>
                            <div class="col-md-4">
                                @php
                                    $perPage = 5;
                                    $count = 5;
                                @endphp
                                <select class="form-control" name="items_per_page" id="items_per_page">
                                    @for ($i = 1; $i < $count; $i++)
                                    @php
                                        $pP = $perPage * pow(2, $i);
                                    @endphp
                                        <option @if (isset($_COOKIE['adm_items_per_page']) && $_COOKIE['adm_items_per_page'] == $pP) selected='selected' @endif value="{!! $pP !!}">{!! $pP !!}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" id="show_published" name="show_published">
                                <option @if (isset($_COOKIE['adm_show_published']) && $_COOKIE['adm_show_published'] == 0) selected='selected' @endif value="0">Все</option>
                                <option @if (isset($_COOKIE['adm_show_published']) && $_COOKIE['adm_show_published'] == 1) selected='selected' @endif value="1">Опублик.</option>
                                <option @if (isset($_COOKIE['adm_show_published']) && $_COOKIE['adm_show_published'] == 2) selected='selected' @endif value="2">Неопублик.</option>
                            </select>
                        </div>  
                        <div class="col-md-3">
                            <select class="form-control" id="index_category_id" name="index_category_id">
                                <option value="0">-- Все категории --</option>
                                @include('admin.products.partials.categories', ['categories' => $categories, 'delimiter' => $delimiter])
                            </select>
                        </div>
                        <div class="col-md-3">
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
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="id">№ <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col"></th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="product">Товар <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="scu">Арт внутр. <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="autoscuscu">Арт произв. <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="price">Цена <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm adm_product_sort" data-sort="category">Категория <i class="fas fa-sort"></i></button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm disabled">Наличие</button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm disabled">Срок доставки</button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm disabled">Дополнительно</button>
                            </th>
                            <th scope="col">
                                <button type="button" class="btn btn-light btn-sm disabled"><i class="fas fa-wrench"></i></button>
                            </th>
                            {{-- <th scope="col">Описание</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            if (!isset($count)) {
                                $count = 1;
                            } 
                        @endphp   
                        @forelse ($products as $product)
                        @php
                            // dd($product)
                        @endphp
                        <tr @if (!$product->published) class='bg-secondary'  @endif>
                            <th scope="row">{{ ($products->currentpage()-1) * $products->perpage() + $loop->iteration }} (id:{{ $product->id }})</th>
                            <td>
                                <input class="form-check-input product_id"  data-toggle="tooltip" data-placement="top" title="id: {{ $product->id }}" type="checkbox" value="{{ $product->id }}" id="product_id_{{ $product->id }}">
                            </td>
                            <td>{{ $product->product }}</td>
                            <td>{{ $product->autoscu }}</td>
                            <td>{{ ($product->scu) ?? '' }} </td>
                            <td>
                                @if(isset($product->discount) && $product->actually_discount)
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
                                @else
                                    <div class="btn text-light bg-success btn-sm">{{ $product->price_number }} руб.</div> 
                                @endif
                                
                            
                            
                            </td>
                            <td>{{ $product->category->category ?? '' }}</td>
                            {{-- <td>{{ $product->manufactures->manufacture }}</td> --}}
                            <td>{{ $product->quantity ?? '-' }}</td>
                            <td>{{ $product->delivery_time ?? '-' }}</td>
                            <td>
                                @if ($product->pay_online)
                                    <span class="p-1"><i class="fas fa-credit-card"></i></span>
                                @endif
                                @if ($product->packaging)
                                    <span class="p-1"><i class="fas fa-box"></i></span>
                                @endif
                                
                            
                            </td>
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
            </div>
        </div>
    </div>
</div>
@endsection