<nav class="nav nav-pills nav-fill tabs">
    <span class="nav-item nav-link active" data-tab="main">Основная информация</span>
    <span class="nav-item nav-link" data-tab="description">Описание</span>
    <span class="nav-item nav-link" data-tab="size">Габариты</span>
    <span class="nav-item nav-link" data-tab="properties">Характеристики</span>
</nav>
<hr>
<div id="main" class="tab_item active">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label for="scu" class="col-sm-4 col-form-label">Артикул</label>
                        <div class="col-md-8">
                            <input type="text" name="scu" class="form-control" id="scu" value="{{ $product->scu ?? '' }}">
                        </div>                                    
                    </div>    
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label for="quantity" class="col-sm-4 col-form-label">Наличие</label>
                        <div class="col-md-8">
                            <input type="text" name="quantity" class="form-control" id="quantity" value="{{ $product->quantity ?? '' }}">
                        </div>                                    
                    </div>    
                </div>
            </div>
            
            <div class="form-group row">
                <label for="product" class="col-sm-2 col-form-label">Название</label>
                <div class="col-md-10">
                    <input type="text" name="product" class="form-control" required id="product" value="{{ $product->product ?? '' }}">
                </div>                                    
            </div>            
        </div>
        <div class="col-lg-4">
            <div class="form-group row">
                <label for="category_id" class="col-md-4 col-form-label">Категория</label>
                <div class="col-md-8">
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="0">-- Без родителя --</option>
                        @include('admin.categories.partials.child-categories', ['categories' => $categories])
                    </select>
                </div> 
            </div>
            <div class="form-group row">
                <label for="manufacture_id" class="col-md-4 col-form-label">Производитель</label>
                <div class="col-md-8">
                    <select class="form-control" id="manufacture_id" name="manufacture_id">
                        <option>------------</option>
                        @forelse ($manufactures as $manufacture)
                            <option value="{{ $manufacture->id }}">{{ $manufacture->manufacture }}</option>
                        @empty
                            
                        @endforelse
                    </select>
                </div> 
            </div> 
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col col-lg-8">
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label">Цена</label>
                        <div class="col-md-10">
                            <input type="text" name="price" class="form-control" id="price" value="{{ $product->price ?? '' }}">
                        </div>                                    
                    </div>    
                </div>
                <div class="col col-lg-2">                    
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pay_online">
                        <label class="form-check-label" for="pay_online">
                            Оплата онлайн
                        </label>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-2">                    
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="packaging">
                        <label class="form-check-label" for="packaging">
                            Продажа упаковками
                        </label>
                        </div>
                    </div>
                </div>
            </div>
                      
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col col-lg-4">
                    <div class="form-group row">
                        <label for="discount" class="col-sm-4 col-form-label">Акция</label>
                        <div class="col-md-8">
                            <select class="form-control" id="discount_id" name="discount_id">
                                <option>------------</option>
                                @forelse ($discounts as $discount)
                                    <option value="{{ $discount->id }}">
                                        {{ $discount->discount }} - 
                                        {{ $discount->value }} 
                                        {{ $discount->type }}
                                    </option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>                                    
                    </div>    
                </div>
                <div class="col col-lg-4">
                    <div class="form-group row">
                        <label for="vendor" class="col-sm-4 col-form-label">Поставщик</label>
                        <div class="col-md-8">
                            <select class="form-control" id="vendor_id" name="vendor_id">
                                <option>------------</option>
                                @forelse ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">
                                        {{ $vendor->vendor }} 
                                    </option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>                                    
                    </div>    
                </div>
                
                <div class="col col-lg-4">                    
                    <div class="form-group">
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="packaging">
                        <label class="form-check-label" for="packaging">
                            Продажа упаковками
                        </label>
                        </div>
                    </div>
                </div>
            </div>
                      
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group row">
                <label for="image" class="col-sm-3 col-form-label">Изображение</label>
                <div class="custom-file col-md-9">
                    <input type="file" class="custom-file-input" id="customFile" name="image">
                    <label class="custom-file-label" for="customFile">Выберите файл</label>
                </div>                                    
            </div>
        </div>
        <div class="col-lg-6">
            @isset($manufacture->image)
                <div class="category_edit_img">
                    <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
                    <img src="{{ asset('imgs/manufactures/')}}/{{ $manufacture->image }}" alt="">
                </div>            
            @endisset
        </div>
    </div>



</div>
<div id="description" class="tab_item">
    <p>Описание</p>
</div>
<div id="size" class="tab_item">
    <p>Габариты</p>
</div>
<div id="properties" class="tab_item">
    <p>Характеристики</p>
</div>


    









<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>











   
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
            <div class="input-group mb-3 col-md-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">id</span>
                </div>
                <input type="text" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $manufacture->id ?? '' }}">
            </div>
            <div class="input-group mb-3 col-md-8">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">slug</span>
                </div>
                <input type="text" class="form-control" name="slug" readonly aria-label="Username" aria-describedby="basic-addon1" value="{{ $manufacture->slug ?? '' }}">
            </div>
            <div class="mb-3 col-md-2">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
                    
        </div>
</div>   