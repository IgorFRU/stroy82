<div class="row">
    <div class="col-lg-6">
        
        <div class="form-group row">
            <label for="unit" class="col-sm-4 col-form-label">Единица измерения</label>
            <div class="col-md-6">
                <input type="text" name="unit" class="form-control" id="unit" value="{{ $unit->unit ?? '' }}">
            </div>
            <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>                                    
        </div>                    
    </div>
</div>   