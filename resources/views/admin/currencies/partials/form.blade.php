
<div class="col-lg-12">    
    <div class="form-group row">
        <div class='col-lg-3 row'>
            <label for="currency" class="col-lg-6 col-form-label">Код валюты</label>
            <div class="col-lg-6">
                <input type="text" name="currency" class="form-control" id="currency" value="{{ $currency->currency ?? '' }}" required maxlength="3">
            </div>
        </div>
        <div class='col-lg-5 row'>
            <label for="currency_rus" class="col-lg-4 col-form-label">Русское название</label>
            <div class="col-md-8">
                <input type="text" name="currency_rus" class="form-control" id="currency_rus" value="{{ $currency->currency ?? '' }}" required maxlength="16">
            </div>
        </div>
        <div class="col-lg-3 row">
            <label for="to_update" class="col-lg-10 col-form-label">Запрашивать курс обмена?</label>  
            <div class="col-md-2">      
                @if(isset($currency->id))
                    <input type="checkbox" name="to_update" id="to_update" class="js_oneclick form-control" value="{{ $currency->to_update }}" @if($currency->to_update) checked @endif>
                    {{-- Скрытое поле для отправки на сервер value неотмеченного чекбокса --}}
                    <input type="hidden" name="to_update" id="to_update" class="js_oneclick_hidden form-control" value="{{ $currency->to_update }}" >  
                @else
                    <input type="checkbox" name="to_update" id="to_update" class="js_oneclick form-control" value="1"  checked >
                    {{-- Скрытое поле для отправки на сервер value неотмеченного чекбокса --}}
                    <input type="hidden" name="to_update" id="to_update" class="js_oneclick_hidden form-control" value="1" > 
                @endif
            </div>
        </div>
    </div>    
</div>

<div class="col-lg-12">    
    <div class="form-group row">
        <div class='col-lg-12 row'>
            <label for="css_style" class="col-lg-1 col-form-label">CSS</label>
            <div class="col-lg-11">
                <input type="text" name="css_style" class="form-control" id="css_style" value="{{ $currency->css_style ?? '' }}" required maxlength="127">
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
            <input type="text" class="form-control" name="id" id="object_id" data-object='currency' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $currency->id ?? '' }}">
        </div>
        {{-- <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
            </div>
            <input type="text" class="form-control" name="views" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->views ?? '' }}">
        </div> --}}
        <div class="input-group mb-3 col-md-7">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $currency->slug ?? '' }}">
            {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.currencies.index') }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   