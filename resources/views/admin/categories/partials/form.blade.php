<div class="row">
    <div class="col-lg-6">
        <div class="row">

        
            <div class="input-group mb-3 col-md-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">id</span>
                </div>
                <input type="text" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $category->id ?? '' }}">
            </div>
            <div class="input-group mb-3 col-md-3">
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
        </div>
        <div class="form-group row">
            <label for="category" class="col-sm-4 col-form-label">Название категории</label>
            <div class="col-md-8">
                <input type="text" name="category" class="form-control" id="category" value="{{ $category->category ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-4 col-form-label">Описание категории</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="description" id="description" rows="6">{{ $category->description ?? '' }}</textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="meta_description" class="col-sm-4 col-form-label">Дополнительное писание (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="4">{{ $category->meta_description ?? '' }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="meta_keywords" class="col-sm-4 col-form-label">Ключевые слова (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="2">{{ $category->meta_keywords ?? '' }}</textarea>
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
                <p>При загрузке нового изображения старое будет удалено!</p>
                <img src="{{ asset('imgs/categories/')}}/{{ $category->image }}" alt="">
            </div>            
        @endisset
    </div>
</div>
<div class="row col-md-12 d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>       