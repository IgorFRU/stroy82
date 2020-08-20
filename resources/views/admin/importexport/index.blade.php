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
                <div class="h5">Ранее импортированные товары (они не отображаются на сайте и в основном разделе товаров в админке)</div>
                @if ($products->count() > 0)
                    <div class="bg-warning rounded p-2 my-4 text-center h4">Обязательно дополните информацию об этих товарах перед их публикацией на сайте!</div>
                @endif
                <div class="w-100 d-flex mb-2">
                    <button type="button" class="btn bg-warning product_group_delete disabled mr-1" disabled data-toggle="modal" data-target=".modalDeleteProduct" data-toggle="tooltip" data-placement="top" title="Удалить выбранные товары"><i class="fas fa-trash-alt mr-1"></i>Удалить</button>
                    <form action="{{ route('admin.products.published') }}" method="post">
                        @csrf
                        <div class="hidden_inputs">
                            <input type="hidden" name="product_group_ids[]">
                        </div>
                        <button type="submit" class="btn product_group_published disabled mr-1 bg-success text-white" href="#"><i class="fas fa-eye mr-1"></i>Опубликовать</button>
                    </form>
                    <form action="{{ route('admin.products.unimported') }}" method="post">
                        @csrf
                        <div class="hidden_inputs">
                            <input type="hidden" name="product_group_ids[]">
                        </div>
                        <button type="submit" class="btn product_group_unimported disabled mr-1 bg-danger text-white" title="Перенести товар(ы) в основной раздел"><i class="fas fa-file-upload mr-1"></i>В основной раздел</button>
                    </form>
                </div>
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
                            @if ($product->published)
                                <span class="p-1 text-success" title="Товар опубликован"><i class="fas fa-eye"></i></span>
                            @else
                                <span class="p-1 text-danger" title="Товар не опубликован"><i class="fas fa-eye-slash"></i></span>
                            @endif
                        
                        </td>
                        <td>
                            <div class='row'>                                
                                <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{ route('admin.products.destroy', ['product' => $product, 'route' => 'import-export.index']) }}" method="post">
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
            <form class="row mb-1 w-100" action="{{ route('admin.import-export.export') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row mb-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="published" name="published" checked>
                        <label class="custom-control-label text-secondary" for="published">Только опубликованные товары</label>
                    </div>
                </div>
                <div class="form-row w-100 mb-3">
        
                    {{-- <div class="col-md-4">
                        <label for="vendor">Поставщик</label>
                        <select class="form-control" id="vendor" name="vendor[]" multiple>
                            <option value="0">Все</option>
                            @forelse ($vendors as $vendor)
                                <option value="{{ $vendor->id }}"
                                    @isset($product->vendor_id)
                                        @if ($vendor->id == $product->vendor_id)
                                        selected = "selected"
                                        @endif
                                    @endisset>
                                    {{ $vendor->vendor }} 
                                </option>
                            @empty
                                
                            @endforelse
                        </select>
                        @if ($vendors->count())
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="vendor_not" name="vendor_not">
                            <label class="custom-control-label text-secondary" for="vendor_not">Кроме выбранных</label>
                        </div>
                        @endif
                    </div> --}}
        
                    <div class="col-md-4">
                        <label for="category_id">Категория</label>
                        <select class="form-control export" id="category_id" data-import='true' name="category[]" multiple>
                            <option value="0">Все</option>
                            @include('admin.categories.partials.child-categories', ['categories' => $categories])
                        </select>
                    @if ($categories->count())
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="category_not" name="category_not">
                        <label class="custom-control-label text-secondary" for="category_not">Кроме выбранных</label>
                    </div>
                    <input type="hidden" name="category_not_hidden[]">
                    @endif
                    
                    </div>
        
                    <div class="col-md-4">
                        <label for="manufacture">Производитель</label>
                        <select class="form-control" id="manufacture" name="manufacture[]" multiple>
                            <option value="0">Все</option>
                            @forelse ($manufactures as $manufacture)
                                <option value="{{ $manufacture->id }}">
                                    {{ $manufacture->manufacture }} 
                                </option>
                            @empty
                                
                            @endforelse
                        </select>
                        @if ($manufactures->count())
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="manufacture_not" name="manufacture_not">
                            <label class="custom-control-label text-secondary" for="manufacture_not">Кроме выбранных</label>
                        </div>
                        <input type="hidden" name="manufacture_not_hidden[]">
                        @endif
                    </div>
                    
                </div>
                <div class="h4 mt-3">Укажите соответствие колонок</div>
                <div class="form-row w-100">
                    <div class="col-md-2 mb-2">
                        <fieldset disabled>
                            <label for="export_column_1">1 столбец</label>
                            <select class="form-control disabled" id="export_column_1" name="export_column_1">
                                <option value="id">№</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-md-2 mb-2">
                        <fieldset disabled>
                            <label for="export_column_2">2 столбец</label>
                            <select class="form-control disabled" id="export_column_2" name="export_column_2">
                                <option value="autoscu">Внутренний артикул</option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="hide">
                        <select class="form-control template">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="export_column_3">3 столбец</label>
                        <select data-count='3' class="form-control export_column_number last" id="export_column_3" name="export_column_3">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="export_column_4">4 столбец</label>
                        <select data-count='4' class="form-control export_column_number disabled" id="export_column_4" name="export_column_4">
                            <option value="0">Пусто</option>
                            <option value="scu" disabled>Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="export_column_5">5 столбец</label>
                        <select data-count='5' class="form-control export_column_number disabled" id="export_column_5" name="export_column_5">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>

                    
                    <div class="col-md-2 mb-2">
                        <label for="export_column_6">6 столбец</label>
                        <select data-count='6' class="form-control export_column_number disabled" id="export_column_6" name="export_column_6">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="export_column_7">7 столбец</label>
                        <select data-count='7' class="form-control export_column_number disabled" id="export_column_7" name="export_column_7">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-2">
                        <label for="export_column_8">8 столбец</label>
                        <select data-count='8' class="form-control export_column_number disabled" id="export_column_8" name="export_column_8">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-2">
                        <label for="export_column_9">9 столбец</label>
                        <select data-count='9' class="form-control export_column_number disabled" id="export_column_9" name="export_column_9">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-2">
                        <label for="export_column_10">10 столбец</label>
                        <select data-count='10' class="form-control export_column_number disabled" id="export_column_10" name="export_column_10">
                            <option value="0">Пусто</option>
                            <option value="scu">Артикул</option>
                            <option value="product">Название товара</option>
                            <option value="category">Категория</option>
                            <option value="manufacture">Производитель</option>
                            <option value="vendor">Поставщик</option>
                            <option value="price">Цена</option>
                            <option value="description">Описание товара</option>
                            <option value="slug">Ссылка</option>
                            <option value="size_l">Длина</option>
                            <option value="size_w">Ширина</option>
                            <option value="size_t">Толщина</option>
                            <option value="mass">Масса</option>
                            <option value="properties">Характеристики</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="columns[]">
                <input type="hidden" name="values[]">
                <button type="submit" class="btn btn-primary export_send_button">Экспортировать</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="modalDeleteProduct" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
                <div class="modal-header">
                    <h4>Удаление товаров</h4>
                </div>
                <div class="modal-body">
                    Вы уверены, что хотите удалить выбранные товары? Отменить выбранное действие будет невозможно!
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.products.massdestroy') }}" method="post">
                        @csrf
                        <div class="hidden_inputs">
                            <input type="hidden" name="product_group_ids[]">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-warning">Да</button>
                    </form>
                </div>
        </div>      
    </div>
</div>
@endsection
