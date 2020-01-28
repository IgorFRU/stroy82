<div class="row">
    <div class="col-lg-12 row">
        
        <div class="form-group col-lg-6 row">
            <label for="orderstatus" class="col-sm-4 col-form-label">Статус заказа</label>
            <div class="col-md-6">
                <input type="text" name="orderstatus" class="form-control" id="orderstatus" value="{{ $orderstatus->orderstatus ?? '' }}">
            </div>
        </div> 
        <div class="form-group col-lg-6 row">            
            <label for="icon" class="col-sm-4 col-form-label">Иконка</label>
            <div class="col-md-6">
                <input type="text" name="icon" class="form-control" id="icon" value="{{ $orderstatus->icon ?? '' }}">
            </div>
        </div>        
        <div class="form-group col-lg-6 row">            
            <label for="color" class="col-sm-4 col-form-label">Цвет</label>
            <div class="col-md-6">
                <input type="color" name="color" class="form-control" id="color" value="{{ $orderstatus->color ?? '#343a40' }}">
            </div>
        </div>
        <div class="mb-3 col-md-2">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>                                    
                           
    </div>
</div>   