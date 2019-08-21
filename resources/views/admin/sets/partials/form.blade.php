
<div class="col-lg-12">
    
    <div class="form-group row">
        <label for="set" class="col-sm-2 col-form-label">Название группы</label>
        <div class="col-md-10">
            <input type="text" name="set" class="form-control" id="set" value="{{ $set->set ?? '' }}" required>
        </div>                                    
    </div>
    

    <div class="form-group row">
        <label for="image" class="col-sm-2 col-form-label">Изображение</label>
        <div class="custom-file col-md-10">
            <input type="file" class="custom-file-input" id="customFile" name="image">
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>                                    
    </div>
    @isset($set->image)
    <div class="category_edit_img">
        <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Изображение</label>
            <img class="col-lg-4" src="{{ asset('imgs/sets/')}}/{{ $set->image }}" alt="">
        </div>
    </div>            
    @endisset
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Описание группы</label>
        <div class="col-md-10">
                <textarea class="form-control" name="description" id="description" rows="6">{{ $set->description ?? '' }}</textarea>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="meta_description" class="col-sm-2 col-form-label">Дополнительное писание (для поисковых машин)</label>
        <div class="col-md-10">
                <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="2">{{ $set->meta_description ?? '' }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="meta_keywords" class="col-sm-2 col-form-label">Ключевые слова  (для поисковых машин)</label>
        <div class="col-md-10">
            <input type="text" name="meta_keywords" class="form-control" id="meta_keywords" value="{{ $set->meta_keywords ?? '' }}">
        </div>                                    
    </div>
</div>

<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        прикрепленные товары
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col col-lg-4">
                        <select id="ajaxAddProductByCategory" name="category" class="form-control">
                            <option selected value="0">Выберите категорию...</option>
                            <@include('admin.categories.partials.child-categories', ['categories' => $categories])
                        </select>
                    </div>
                    <div class="form-group col col-lg-8">
                        <select id="ajaxAddProductByCategoryShow" class="form-control">
                            <option selected value="0">Выберите товар...</option>
                        </select>
                    </div>
                    <div class="hidden_inputs">
                        @isset($set->products)
                            @foreach ($set->products as $product)
                                <input type='hidden' name='product_id[]' value="{{ $product->id }}">
                            @endforeach
                        @endisset
                        
                    </div>
                </div>                      
            </div>
            <div class="col-lg-12" id="ajaxAddProductResult">
                    
                @isset($set->products)
                    @foreach ($set->products as $product)
                        <button type="button" data-product-id="{{ $product->id }}" class="btn btn-secondary"><a href="#"><i class="fas fa-external-link-square-alt"></i></a> id: {{ $product->id }} | {{ $product->product }} | {{ $product->price }} руб. <span class="ajaxAddProductResultRemove"><i class="fas fa-window-close"></i></span></button>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
   
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" class="form-control" name="id" id="object_id" data-object='set' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $set->id ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-7">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $set->slug ?? '' }}">
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.sets.index') }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   