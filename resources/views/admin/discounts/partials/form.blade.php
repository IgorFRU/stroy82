<div class="row">
    <div class="col-lg-8">
        
        <div class="form-group row">
            <label for="discount" class="col-sm-3 col-form-label">Название акции</label>
            <div class="col-md-9">
                <input type="text" name="discount" class="form-control" id="discount" value="{{ $discount->discount ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label">Описание акции</label>
            <div class="col-md-9">
                    <textarea class="form-control" name="description" id="description" rows="6">{{ $discount->description ?? '' }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-lg-4">            
        <div class="form-group row">
            <label for="value" class="col-sm-3 col-form-label">Скидка</label>
            <div class="col-md-5">
                <input type="text" name="value" class="form-control" id="value" value="{{ $discount->value ?? '' }}">
            </div>       
            <div class="col-md-4">
                <select class="form-control" name="type" id="">
                    <option value="%" @if (isset($discount->type) && $discount->type === '%') selected @endif >%</option>
                    <option value="rub" @if (isset($discount->type) && $discount->type === 'rub') selected @endif >Руб.</option>
                </select>
            </div>                              
        </div>  
        <hr>  
        <p>Сроки действия акции</p>       
        <div class="form-group row">
            <label for="value" class="col-sm-3 col-form-label">Начало</label>
            <div class="col-md-9">
                <input type="date" class="form-control" id="discount_start" name="discount_start"
                @isset($discount->discount_start)
                value="{{ Carbon\Carbon::parse($discount->discount_start)->format('Y-m-d')}}"
                @endisset
                required>
            </div>                            
        </div>             
        <div class="form-group row">
            <label for="value" class="col-sm-3 col-form-label">Конец</label>
            <div class="col-md-9">
                <input type="date" class="form-control" id="discount_end" name="discount_end" 
                @isset($discount->discount_end)
                value="{{ Carbon\Carbon::parse($discount->discount_end)->format('Y-m-d')}}"
                @endisset
                 required>
            </div>                            
        </div>       
    </div>
</div>

   @php
    //    dd(Carbon\Carbon::parse($discount->discount_end)->format('d-m-Y'))
   @endphp
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
            <div class="input-group mb-3 col-md-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">id</span>
                </div>
                <input type="text" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $discount->id ?? '' }}">
            </div>
            <div class="input-group mb-3 col-md-8">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">slug</span>
                </div>
                <input type="text" class="form-control" name="slug" readonly aria-label="Username" aria-describedby="basic-addon1" value="{{ $discount->slug ?? '' }}">
            </div>
            <div class="mb-3 col-md-2">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
                    
        </div>
</div>   