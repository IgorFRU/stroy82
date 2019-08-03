<div class="row">
    <div class="col-lg-6">
        
        <div class="form-group row">
            <label for="manufacture" class="col-sm-4 col-form-label">Название производителя</label>
            <div class="col-md-8">
                <input type="text" name="manufacture" class="form-control" id="category" value="{{ $manufacture->manufacture ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-4 col-form-label">Описание производителя</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="description" id="description" rows="6">{{ $manufacture->description ?? '' }}</textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="meta_description" class="col-sm-4 col-form-label">Дополнительное писание (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="4">{{ $manufacture->meta_description ?? '' }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="meta_keywords" class="col-sm-4 col-form-label">Ключевые слова (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="2">{{ $manufacture->meta_keywords ?? '' }}</textarea>
            </div>                                    
        </div>
        
    </div>
    <div class="col-lg-6">            
        <div class="form-group row">
            <label for="country" class="col-sm-4 col-form-label">Страна</label>
            <div class="col-md-8">
                <input type="text" name="country" class="form-control" id="category" value="{{ $manufacture->country ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="image" class="col-sm-4 col-form-label">Изображение</label>
            <div class="custom-file col-md-7">
                <input type="file" class="custom-file-input" id="customFile" name="image">
                <label class="custom-file-label" for="customFile">Выберите файл</label>
            </div>                                    
        </div>
        @isset($manufacture->image)
            <div class="category_edit_img">
                <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
                <img src="{{ asset('imgs/manufactures/')}}/{{ $manufacture->image }}" alt="">
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