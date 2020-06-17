<div class="modal fade" tabindex="-1" role="dialog" id="productOptions">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title product_options_steps_title">Опции товара <span>(шаг 1)</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body product_options_steps">

                <div data-step='1' class="options_step_1 options_step @if($product->options->count() == 0) active @endif">
                    <div class="form-group">
                        <label for="main">Основная/дочерняя опция</label>                        
                        <select name="main" class="form-control" id="main">
                            <option value="1">Основная</option>
                            <option value="0">Дочерняя</option>                            
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary mr-4 step_button" data-next="1" data-name="options_step_1">Далее</button>
                </div>
                
                <div data-step='2' class="options_step_2 options_step @if($product->options->count()) active @endif">
                    <div class="form-group">
                        <label for="typeoption_id">Название опции (не обязательно)</label>                        
                        <select name="typeoption_id" class="form-control" id="typeoption_id">
                            <option value="0">Не выбрано</option>
                            <option value="new">Добавить</option>
                            @forelse ($typeoptions as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                        
                    <div class="border border-warning my-2 p-3 rounded" id="typeoption_id_new" style="display: none;">
                        <div class="form-group">
                            <label for="typeoption_id_add">Название опции</label>
                            <input type="text" class="form-control" id="typeoption_id_add" maxlength="190">
                            <small id="emailHelp" class="form-text text-muted">Название должно быть уникальным</small>
                        </div>
                        <button type="button" class="btn btn-success typeoption_id_new_button disabled" disabled>Добавить</button>

                    </div>
                    <button type="button" class="btn btn-secondary mr-4 step_button" data-next="0" data-name="options_step_2">Назад</button>
                    <button type="button" class="btn btn-primary mr-4 step_button" data-next="1" data-name="options_step_2">Далее</button>
                </div>

                <div data-step='3' class="options_step_3 options_step">
                    <div class="form-group">
                        <label for="type">Тип опции (обязательно)</label>
                        <select name="type" class="form-control" id="type">
                            <option value="photo">Фотография/цвет</option>
                            <option value="text">Текст</option>
                        </select>
                      </div>
                    <button type="button" class="btn btn-secondary mr-4 step_button" data-next="0" data-name="options_step_3">Назад</button>
                    <button type="button" class="btn btn-primary mr-4 step_button" data-next="1" data-name="options_step_3">Далее</button>
                </div>

                <div data-step='4' class="options_step_4 options_step">
                    <div class="row col">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="option">Значение</label>
                                <input type="text" class="form-control check_not_empty" data-success_check='option_name_button' id="option" maxlength="190">
                                <div class="invalid-feedback">
                                    Это поле должно быть заполнено!
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="name_plus">Добавить к названию товара</label>
                            <select name="name_plus" class="form-control" id="name_plus">
                                <option value="true">Да</option>
                                <option value="false">Нет</option>
                            </select>
                        </div>
                    </div>

                    <div class="row col">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="option_scu">Артикул</label>
                                <input type="text" class="form-control" id="option_scu" maxlength="190">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="option_price">Цена</label>
                            <input type="text" class="form-control" id="option_price" maxlength="190">
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary mr-4 step_button" data-next="0" data-name="options_step_3">Назад</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary disabled option_name_button" disabled>Сохранить</button>
            </div>
        </div>
    </div>
</div>