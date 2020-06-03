@extends('layouts.admin-app')
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif 
   
    <form class="row mb-4 w-100" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row w-100">
            <div class="col-md-2 mb-3">
                <label for="first_line">№ первой строки товаров</label>
                <input type="text" class="form-control" id="first_line" name="first_line" placeholder="введите № первой строки товаров">
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="last_line">№ последней строки товаров</label>
                <input type="text" class="form-control" id="last_line" name="last_line" placeholder="введите № последней строки товаров">
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="vendor">Поставщик</label>
                <select class="form-control" id="vendor" name="vendor">
                    <option value="0">Без поставщика</option>
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
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="category">Категория</label>
                <select class="form-control" id="category" name="category">
                    <option value="0">Без категории</option>
                    @include('admin.categories.partials.child-categories', ['categories' => $categories])
                </select>
                <div class="valid-tooltip">
                    Looks good!
                </div>
            </div>
        </div>
        <div class="h4 mt-3">Укажите соответствие колонок</div>
        <div class="form-row w-100">            
            <div class="col-md-2 mb-3">
                <label for="product" class="text-danger">Наименование*</label>
                <input type="text" class="form-control" id="product" name="column_product" placeholder="Наименование товара" required>
            </div>

            <div class="col-md-1 mb-3">
                <label for="scu">Артикул</label>
                <input type="text" class="form-control" id="scu" name="column_scu" placeholder="Артикул">
            </div>

            <div class="col-md-2 mb-3">
                <label for="manufacture_name" class="">Производитель</label>
                <input type="text" class="form-control" id="manufacture_name" name="column_manufacture_name" placeholder="Производитель" >
            </div>
            
            <div class="col-md-2 mb-3">
                <label for="category_name" class="">Категория</label>
                <input type="text" class="form-control" id="category_name" name="column_category_name" placeholder="Категория" >
            </div>

            <div class="col-md-1 mb-3">
                <label for="incomin_price">Цена опт</label>
                <input type="text" class="form-control" id="incomin_price" name="column_incomin_price" placeholder="Цена опт">
            </div>

            <div class="col-md-1 mb-3">
                <label for="price">Цена розн.</label>
                <input type="text" class="form-control" id="incomin_price" name="column_price" placeholder="Цена розн.">
            </div>

            <div class="col-md-1 mb-3">
                <label for="unit_name">Ед. изм.</label>
                <input type="text" class="form-control" id="unit_name" name="column_unit_name" placeholder="Ед. изм.">
            </div>

            <div class="col-md-1 mb-3">
                <label for="unit_in_package">Ед. изм. в уп.</label>
                <input type="text" class="form-control" id="unit_in_package" name="column_unit_in_package" placeholder="в уп.">
            </div>

            <div class="col-md-1 mb-3 mt-4">
                <label class="form-check-label" for="packaging">Продается упаковками</label>
                <input class="form-check-input" type="checkbox" name="packaging" id="packaging" value="1">
            </div>
        </div>
        
        <div class="d-flex w-100 my-3">
            <div class="custom-file col-4 mr-2">
                <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                <label class="custom-file-label" for="file">Выберите файл</label>
                @error('file')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </div>
    </form>  
@endsection
