
<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label for="image" class="col-sm-2 col-form-label">Изображение</label>
            <div class="custom-file col-md-10">
                <input type="file" class="custom-file-input" id="customFile" name="image" @if (!isset($banner->image))
                required
                @endif >
                <label class="custom-file-label" for="customFile">Выберите файл</label>
            </div>                                    
        </div>
        @isset($banner->image)
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

    <div class="col-lg-6">
        <div class="card p-2 bannertags">
            <div class="h5">Надписи на баннере</div>

            <div class="row">
                <div class="form-group col-md-5">
                    <label for="tag_text" class="col-form-label">Текст</label>
                    <div class="">
                        <input type="text" name="tag_text" class="form-control bannertag_input" id="tag_text" maxlength="191" value="">
                    </div>
                </div>

                <div class="col-md-7 bannertag_preview mt-4">
                    <span class="banner_tag" style="padding: 5px; background: #4682B4; border-radius: 0rem; color: #ffffff; box-shadow: ;"></span>
                </div>

                <div class="form-group col-md-2">
                    <label for="tag_background" class="col-form-label">Фон</label>
                    <div class="">
                        <input type="color" name="tag_background" class="form-control bannertag_input" id="tag_background" maxlength="20" value="#4682B4">
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="tag_color" class="col-form-label">Цвет</label>
                    <div class="">
                        <input type="color" name="tag_color" class="form-control bannertag_input" id="tag_color" maxlength="20" value="#ffffff">
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label for="tag_priority" class="col-form-label">Порядок</label>
                    <div class="">
                        <input type="number" name="tag_priority" class="form-control bannertag_input" id="tag_priority" min="0" max="30" value="0">
                    </div>
                </div>

                <div class="col-md-2 ml-4 mb-2 mt-2">
                    <input class="form-check-input" type="checkbox" name="tag_rounded" id="tag_rounded" value="rounded">
                    <label class="form-check-label" for="tag_rounded">Скругление</label>

                    
                    <input class="form-check-input" type="checkbox" name="tag_shadow" id="tag_shadow" value="shadow">
                    <label class="form-check-label" for="tag_shadow">Тень</label>
                </div>

                <div class="form-group col-md-3">
                    <label for="tag_padding" class="col-form-label">Отступы, px</label>
                    <div class="">
                        <input type="number" name="tag_padding" class="form-control bannertag_input" id="tag_padding" min="2" max="30" value="5">
                    </div>
                </div>
            </div>

            <div class="btn btn-lg btn-block btn-success bannertag_button_add disabled" disabled>Добавить</div>

            <hr>

            @forelse ($banner->tags as $item)
                <div class="my-2 mr-2" data-banner_tag_id="{{ $item->id }}">
                    <span class="banner_tag mr-2 {{ $item->shadow }} {{ $item->rounded }}" style="padding: {{ $item->padding }}px; background: {{ $item->background }}; color: {{ $item->color }}; box-shadow: ;">{{ $item->text }}</span>
                    
                    <span class="text-secondary">{{ $item->priority }}</span>
                    <span class="btn btn-warning btn-sm mx-1 bannertag_button_edit"><i class="fas fa-pen"></i></span>
                    <span class="btn btn-danger btn-sm mx-1 bannertag_button_delete"><i class="far fa-trash-alt"></i></span>
                </div>
            @empty
                
            @endforelse
        </div>        
    </div>
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