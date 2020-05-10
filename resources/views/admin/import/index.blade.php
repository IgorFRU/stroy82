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
                <input type="text" class="form-control" id="first_line" name="first-line" placeholder="введите № первой строки товаров" required>
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
