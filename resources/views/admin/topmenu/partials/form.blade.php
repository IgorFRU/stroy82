<div class="row col-lg-12"> 
    <div class="col col-lg-12">
        <div class="form-group">
            <div class="form-check">
                @if(isset($topmenu->id))
                    <input class="form-check-input js_oneclick" type="checkbox" id="published" name="published" value="{{ $topmenu->published }}" @if($topmenu->published) checked @endif>
                @else
                    <input class="form-check-input js_oneclick" type="checkbox" name="published" id="published" value="1"  checked >
                @endif
                {{-- Скрытое поле для отправки на сервер value неотмеченного чекбокса --}}
                <input type="hidden" name="published" id="published" class="form-check-input js_oneclick_hidden" value="1" >
                <label class="form-check-label" for="published">
                    Опубликован
                </label>
            </div>
        </div>   
    </div>       
    <div class="form-group row col-lg-9">
        <label for="title" class="col-sm-2 col-form-label">Заголовок</label>
        <div class="col-md-10">
            <input type="text" name="title" class="form-control" id="title" value="{{ $topmenu->title ?? '' }}" required>
        </div>                                  
    </div>  
    <div class="form-group row col-lg-3">
        <label for="priority" class="col-sm-6 col-form-label">Приоритет</label>
        <div class="col-md-6">
            <input type="text" name="priority" class="form-control" id="priority" value="{{ $topmenu->priority ?? '' }}">
        </div>                                  
    </div> 
    <div class="form-group row col-lg-12">
        <label for="text" class="col-sm-1 col-form-label">Текст</label>
        <div class="col-md-11">
            <textarea class="form-control" name="text" id="text" rows="36">{{ $topmenu->text ?? '' }}</textarea>
        </div>                                  
    </div>       
</div>   
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" id="category_id-2" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $topmenu->id ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
            </div>
            <input type="text" class="form-control" name="views" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $topmenu->views ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-6">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" class="form-control" name="slug" id="slug" value="{{ $topmenu->slug ?? '' }}">
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>  
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.topmenu.index') }}" class="btn btn-danger">Выйти</a>
        </div>              
    </div>
</div>  