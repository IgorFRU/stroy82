<form action="{{route('admin.categories.store')}}" method="post">
        @csrf

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
                    <textarea class="form-control" name="description" id="description" rows="6">{{ $category->description ?? '' }}</textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="main_text" class="col-sm-4 col-form-label">Дополнительное писание (для поисковых машин)</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="main_text" id="exampleFormControlTextarea1" rows="4">{{ $category->meta_description ?? '' }}</textarea>
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
                <select class="form-control" id="category_id">
                    <option value="0">-- Без родителя --</option>
                    {{-- @include('admin.categories.partials.child-categories', ['categories' => $categories]) --}}
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
    </div>
</div>
</form>        