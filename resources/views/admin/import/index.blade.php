@extends('layouts.admin-app')
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif 
   
    <form class="row mb-1 w-100" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row w-100 mb-3">
            <div class="col-md-2">
                <label for="first_line">№ первой строки товаров</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="first_line" name="first_line" placeholder="введите № первой строки товаров">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-2">
                <label for="last_line">№ последней строки товаров</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="last_line" name="last_line" placeholder="введите № последней строки товаров">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-2">
                <label for="vendor">Поставщик</label>
                <select class="form-control" id="vendor" name="vendor">
                    <option value="0">Не указывать</option>
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
            </div>

            <div class="col-md-2">
                <label for="category_id">Категория</label>
                <select class="form-control" id="category_id" data-import='true' name="category">
                    <option value="0">Не указывать</option>
                    @include('admin.categories.partials.child-categories', ['categories' => $categories])
                </select>
            </div>

            <div class="col-md-2">
                <label for="unit">Ед. изм.</label>
                <select class="form-control" id="unit" name="unit">
                    <option value="0">Не указывать</option>
                    @forelse ($units as $unit)
                        <option value="{{ $unit->id }}">
                            {{ $unit->unit }} 
                        </option>
                    @empty
                        
                    @endforelse
                </select>
            </div>

            <div class="col-md-2">
                <label for="manufacture">Производитель</label>
                <select class="form-control" id="manufacture" name="manufacture">
                    <option value="0">Не указывать</option>
                    @forelse ($manufactures as $manufacture)
                        <option value="{{ $manufacture->id }}">
                            {{ $manufacture->manufacture }} 
                        </option>
                    @empty
                        
                    @endforelse
                </select>
            </div>
        </div>
        <div class="h4 mt-3">Укажите соответствие колонок</div>
        <div class="form-row w-100">            
            <div class="col-md-1 mb-3">
                <label for="product" class="text-danger">Наименование*</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="product" name="column_product" placeholder="Наименование" required>
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="scu">Артикул</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="scu" name="column_scu" placeholder="Артикул">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            {{-- <div class="col-md-2 mb-3">
                <label for="manufacture_name" class="">Производитель</label>
                <input type="text" class="form-control" id="manufacture_name" name="column_manufacture_name" placeholder="Производитель" >
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div> --}}
            
            {{-- <div class="col-md-2 mb-3">
                <label for="category_name" class="">Категория</label>
                <input type="text" class="form-control" id="category_name" name="column_category_name" placeholder="Категория" >
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div> --}}

            <div class="col-md-1 mb-3">
                <label for="incomin_price">Цена опт</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="incomin_price" name="column_incomin_price" placeholder="Цена опт">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="price">Цена розн.</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="incomin_price" name="column_price" placeholder="Цена розн.">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="unit_in_package">Ед. изм. в уп.</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="unit_in_package" name="column_unit_in_package" placeholder="в уп.">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3 mt-4">
                <label class="form-check-label" for="packaging">Продается упаковками</label>
                <input class="form-check-input" type="checkbox" name="packaging" id="packaging" value="1">
            </div>

            <div class="col-md-1 mb-3">
                <label for="size_l">Длина</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="size_l" name="column_size_l" placeholder="Длина">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="size_w">Ширина</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="size_w" name="column_size_w" placeholder="Ширина">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>
            
            <div class="col-md-1 mb-3">
                <label for="size_t">Толщина</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="size_t" name="column_size_t" placeholder="Толщина">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="size_type">Ед.разм.</label>
                <select class="form-control" id="size_type" name="size_type">
                    <option value="0">Не указывать</option>                    
                    <option value="mm">мм.</option>
                    <option value="cm">см.</option>
                    <option value="m">м.</option>
                </select>
            </div>
            
            <div class="col-md-1 mb-3">
                <label for="mass">Масса, кг.</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="mass" name="column_mass" placeholder="Масса, кг.">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>
            
            <div class="col-md-1 mb-3">
                <label for="amount_in_package">Шт. в уп.</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="amount_in_package" name="column_amount_in_package" placeholder="Шт. в уп.">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>
        </div>

        <div class="form-row w-100 border rounded border-secondary p-3">
        <div class="h5 mt-3 w-100">Характеристики</div>
            <div class="import_products_properties w-100 row col">
                
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
            <button type="submit" class="btn btn-primary success_check">Загрузить</button>
        </div>
    </form>
    <span class="row bg-warning d-inline rounded p-2 my-1">* поля, обозначенные звездочкой, обязательны для заполнения</span>
@endsection
