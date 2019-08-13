<div class="row">
    <div class="col-lg-12">
        
        <div class="form-group row">
            <label for="article" class="col-sm-2 col-form-label">Название статьи</label>
            <div class="col-md-10">
                <input type="text" name="article" class="form-control" id="article" value="{{ $article->article ?? '' }}" required>
            </div>                                    
        </div>
        

        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Изображение</label>
            <div class="custom-file col-md-10">
                <input type="file" class="custom-file-input" id="customFile" name="image">
                <label class="custom-file-label" for="customFile">Выберите файл</label>
            </div>                                    
        </div>
        @isset($article->image)
            <div class="category_edit_img">
                <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
                <img src="{{ asset('imgs/articles/')}}/{{ $article->image }}" alt="">
            </div>            
        @endisset
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">Текст статьи</label>
            <div class="col-md-10">
                    <textarea class="form-control" name="description" id="description" rows="26">{{ $article->description ?? '' }}</textarea>
            </div>
        </div>
        <hr>
        <div class="form-group row">
            <label for="meta_description" class="col-sm-2 col-form-label">Дополнительное писание (для поисковых машин)</label>
            <div class="col-md-10">
                    <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="2">{{ $article->meta_description ?? '' }}</textarea>
            </div>
        </div>
        {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
    </div>
</div>
   
<div class="edit_form_bottom_menu">
        <div class="row align-middle">        
                <div class="input-group mb-3 col-md-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">id</span>
                    </div>
                    <input type="text" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->id ?? '' }}">
                </div>
                {{-- <div class="input-group mb-3 col-md-1">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
                    </div>
                    <input type="text" class="form-control" name="views" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->views ?? '' }}">
                </div> --}}
                <div class="input-group mb-3 col-md-8">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">slug</span>
                    </div>
                    <input type="text" name="slug" class="form-control" id="slug" value="{{ $article->slug ?? '' }}">
                    {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
                </div>
                <div class="mb-3 col-md-2">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
                        
            </div>
</div>   