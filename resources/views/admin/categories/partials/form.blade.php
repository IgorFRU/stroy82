<div class="row">
    <div class="col-lg-6">
        
        <div class="form-group row">
            <label for="category" class="col-sm-4 col-form-label">Название категории</label>
            <div class="col-md-8">
                <input type="text" name="category" class="form-control" id="category" value="{{ $category->category ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-4 col-form-label">Описание категории</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="description" id="description" rows="16">{{ $category->description ?? '' }}</textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="meta_description" class="col-sm-4 col-form-label">Дополнительное писание (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="4" maxlength="190"{{ $category->meta_description ?? '' }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="meta_keywords" class="col-sm-4 col-form-label">Ключевые слова (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="2" maxlength="190">{{ $category->meta_keywords ?? '' }}</textarea>
            </div>
        </div>
        
    </div>
    <div class="col-lg-6">            
        <div class="form-group row">
            <label for="category_id" class="col-md-4 col-form-label">Родительская категория</label>
            <div class="col-md-8">
                <select class="form-control" id="category_id" name="category_id">
                    <option value="0">-- Без родителя --</option>
                    @include('admin.categories.partials.child-categories', ['categories' => $categories])
                </select>
            </div> 
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-4 col-form-label">Изображение</label>
            <div class="custom-file col-md-7">
                <input type="file" class="custom-file-input" id="customFile" name="image">
                <label class="custom-file-label" for="customFile">Выберите файл</label>
            </div>                                    
        </div>
        @isset($category->image)
            <div class="category_edit_img">
                <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
                <img src="{{ asset('imgs/categories/')}}/{{ $category->image }}" alt="">
            </div>            
        @endisset
    </div>
</div>

<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" id="category_id-2" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $category->id ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
            </div>
            <input type="text" class="form-control" name="views" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $category->views ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $category->slug ?? '' }}">
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>  
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-danger">Выйти</a>
        </div>              
    </div>
</div>  

<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Характеристики категории
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group row">
                    <label for="category" class="col-sm-4 col-form-label">Существующая хар-ка</label>
                    <div class="col-md-6">
                        <select class="form-control" id="property_id" name="property_id">  
                            <option value="0">выберите хар-ку</option>                          
                            @foreach ($properties as $property)
                            <option data-property="{{ $property->property }}" value="{{ $property->id }}">{{ $property->property }}</option>
                            @endforeach
                        </select>
                    </div> 
                    <button type="button" class="col-md-2 btn btn-success btn-sm disabled"id="propertyAddButton0">Добавить</button>                                   
                </div>
                <div class="form-group row">
                    <label for="property" class="col-sm-4 col-form-label">Новая характеристика</label>
                    <div class="col-md-6">
                        <input type="text" name="property" class="form-control" id="property" value="" placeholder="введите название...">
                    </div> 
                    <button type="button" class="col-md-2 btn btn-success btn-sm disabled" id="propertyAddButton">Добавить</button>                                   
                </div> 
            </div>
            

            <div class="hidden_inputs">
                @isset($category->property)
                    @foreach ($category->property as $property)
                        <input type='hidden' name='property_id[]' value="{{ $property->id }}">
                    @endforeach
                @endisset    
            </div>
            <span class="col-lg-12" id="categoryAddPropertyResult">
                    
                @isset($category->property)
                    @foreach ($category->property as $property)
                        <button type="button" data-property-id="{{ $property->id }}" class="btn btn-secondary">{{ $property->property }} 
                            <span class="categoryPropertyItemRemove" title="Открепить от категории"><i class="fas fa-window-close"></i></span>
                            <span class="categoryPropertyItemTrash rounded-right" title="Удалить навсегда"  data-toggle="modal" data-target=".confirm-to-trash-property"><i class="fas fa-trash"></i></span>
                        </button>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>

<div class="modal fade confirm-to-trash-property" tabindex="-1" id="confirmModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      
        {{-- <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> --}}
    <div class="modal-body">
        <p>Вы уверены, что хотите удалить эту характеристику?</p>
        <p>Отменить выбранное действие будет невозможно!</p>
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary confirm-to-trash-property-cancel" data-dismiss="modal">Отмена</button>
        <button type="button" class="btn btn-primary confirm-to-trash-property-ok">OK</button>
    </div>
    </div>
  </div>
</div>
</div>