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
        </div>

        <div class="h4 mt-3">Укажите соответствие колонок</div>
        <div class="form-row w-100">

            <div class="col-md-2">
                <label for="scu_type">Используемый артикул</label>
                <select class="form-control" id="scu_type" data-import='true' name="scu_type">
                    <option value="autoscu" selected>Внутренний (уникальный)</option>
                    <option value="scu">Производителя (осторожно!)</option>
                    
                </select>
            </div>

            <div class="col-md-2 mb-3">
                <label for="column_scu" class="text-danger">Артикул*</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="column_scu" name="column_scu" placeholder="Артикул" required>
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-2 mb-3">
                <label for="product">Наименование</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="product" name="column_product" placeholder="Наименование товара">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            <div class="col-md-1 mb-3">
                <label for="scu">Артикул</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="scu" name="scu" placeholder="Артикул">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div>

            {{-- <div class="col-md-1 mb-3">
                <label for="incomin_price">Цена опт</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="incomin_price" name="column_incomin_price" placeholder="Цена опт">
                <div class="invalid-feedback">
                    Тут должно быть число!
                </div>
            </div> --}}

            <div class="col-md-1 mb-3">
                <label for="price">Цена розн.</label>
                <input type="text" class="form-control check_numeric" data-success_check="success_check" id="incomin_price" name="column_price" placeholder="Цена розн." required>
                <div class="invalid-feedback">
                    Тут должно быть число!
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
