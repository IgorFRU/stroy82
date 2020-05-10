@extends('layouts.admin-app')
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif 
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-import-tab" data-toggle="tab" href="#nav-import" role="tab" aria-controls="nav-import" aria-selected="true"><i class="fas fa-file-import"></i> Импорт</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-export" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-file-export"></i> Экспорт</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane mt-4 mb-4 fade show active" id="nav-import" role="tabpanel" aria-labelledby="nav-import-tab">
            <div class="row mb-4 w-100">
                
                <div class="col-4 mb-2">
                    <div class="card mr-1 ml-1 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Импорт товаров из Excel</h5>
                            <p class="card-text h1"></p>
                            <a href="{{ route('admin.import-export.import') }}" class="card-link">Начать <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="w-100">
                <div class="h5">Ранее импортированные товары</div>
                @if ($products->count() > 0)
                    <div class="bg-warning rounded p-2 my-2 text-center">Обязательно дополните информацию об этих товарах перед их публикацией на сайте!</div>
                @endif                
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
                     
                    @forelse ($products as $product)
                    
                    <tr>
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
                                <span class="p-1" title="Оплата товара онлайн"><i class="fas fa-credit-card"></i></span>
                            @endif
                            @if ($product->packaging)
                                <span class="p-1" title="Товар продаётся упаковками"><i class="fas fa-box"></i></span>
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
        <div class="tab-pane fade mt-4 mb-4" id="nav-export" role="tabpanel" aria-labelledby="nav-export-tab">
                            
        </div>
    </div>
</div>

@endsection
