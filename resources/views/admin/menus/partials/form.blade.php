
<div class="col-lg-12">    
    <div class="form-group row">
        <div class='col-lg-8 row'>
            <label for="menu" class="col-lg-3 col-form-label">Пункт меню</label>
            <div class="col-lg-9">
                <input type="text" name="menu" class="form-control" id="menu" value="{{ $menu->menu ?? '' }}" required maxlength="63">
            </div>
        </div>
        <div class='col-lg-4 row'>
            <label for="sortpriority" class="col-lg-4 col-form-label">Приоритет</label>
            <div class="col-md-8">
                <input type="range" name="sortpriority" class="form-control" id="" min="0" max="20" value="{{$menu->sortpriority ?? 0}}" required>
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
            <input type="text" class="form-control" name="id" id="object_id" data-object='currency' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $menu->id ?? '' }}">
        </div>
        <div class="input-group mb-3 col-md-7">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $menu->slug ?? '' }}">
            {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.menus.index') }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   