
<div class="col-lg-12">
    <div class="form-group row">
        <label for="image" class="col-sm-2 col-form-label">Изображение</label>
        <div class="custom-file col-md-10">
            <input type="file" class="custom-file-input" id="customFile" name="image" required>
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>                                    
    </div>
    @isset($article->image)
    <div class="category_edit_img">
        <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Изображение</label>
            <img class="col-lg-4" src="{{ asset('imgs/banners/')}}/{{ $banner->image }}" alt="">
        </div>
    </div>            
    @endisset
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label">Заголовок</label>
        <div class="col-md-10">
            <input type="text" name="title" class="form-control" id="title" maxlength="255" value="{{ $banner->title ?? '' }}">
        </div>                                    
    </div>    
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Описание</label>
        <div class="col-md-10">
            <input type="text" name="description" class="form-control" id="description" maxlength="255" value="{{ $banner->description ?? '' }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="link" class="col-sm-2 col-form-label">Ссылка</label>
        <div class="col-md-10">
            <input type="text" name="link" class="form-control" id="link" maxlength="255" value="{{ $banner->link ?? '' }}">
        </div>
    </div>
    <hr>
</div>


   
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" class="form-control" name="id" id="object_id" data-object='article' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $banner->id ?? '' }}">
        </div>
        
        
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.banners.index') }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   