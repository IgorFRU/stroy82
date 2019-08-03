<div class="row">
    <div class="col-lg-6">
        
        <div class="form-group row">
            <label for="vendor" class="col-sm-4 col-form-label">Название поставщика</label>
            <div class="col-md-8">
                <input type="text" name="vendor" class="form-control" id="vendor" value="{{ $vendor->vendor ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">e-mail</label>
            <div class="col-md-8">
                <input type="email" name="email" class="form-control" id="email" value="{{ $vendor->email ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-4 col-form-label">Номер телефона</label>
            <div class="col-md-8">
                <input type="text" name="phone" class="form-control" id="phone" value="{{ $vendor->phone ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="address" class="col-sm-4 col-form-label">Адрес</label>
            <div class="col-md-8">
                <input type="text" name="address" class="form-control" id="address" value="{{ $vendor->address ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="site" class="col-sm-4 col-form-label">Сайт</label>
            <div class="col-md-8">
                <input type="text" name="site" class="form-control" id="site" value="{{ $vendor->site ?? '' }}">
            </div>                                    
        </div>
        <div class="form-group row">
            <label for="delivery_time" class="col-sm-4 col-form-label">Срок доставки</label>
            <div class="col-md-8">
                <input type="text" name="delivery_time" class="form-control" id="delivery_time" value="{{ $vendor->delivery_time ?? '' }}">
            </div>                                    
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group row">
            <label for="description" class="col-sm-4 col-form-label">Описание поставщика</label>
            <div class="col-md-8">
                    <textarea class="form-control" name="description" id="description" rows="8">{{ $vendor->description ?? '' }}</textarea>
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
                <input type="text" class="form-control" name="id" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $vendor->id ?? '' }}">
            </div>
            <div class="input-group mb-3 col-md-8">
            </div>
            <div class="mb-3 col-md-2">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
                    
        </div>
</div>   