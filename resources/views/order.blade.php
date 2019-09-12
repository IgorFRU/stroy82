@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Корзина @endslot
        @slot('parent_route') {{ route('cart') }} @endslot 
               
        @slot('active') Оформление заказа @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <h2>Оформление заказа</h2>
                <form class="accordion col-lg-12" id="order">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Контактные данные
                            </button>
                        </h2>
                        </div>
                    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#order">
                            <div class="card-body">
                                <h4>Для того, чтобы мы смогли доставить выбранные вами товары, введите ваши контактные данные</h4>                  
                                <div class="col-lg-5">                                    
                                    <div class="form-group">
                                        <label for="surname">Фамилия</label>
                                        <input type="text" class="form-control form-control-sm" required id="surname" value="{{ Auth::user()->up_surname ?? '' }}">
                                    </div>
                                </div>  
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="name">Имя</label>
                                        <input type="text" class="form-control form-control-sm" required id="name" value="{{ Auth::user()->up_name ?? '' }}">
                                    </div>
                                </div>     
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="address">Адрес</label>
                                        <input type="text" class="form-control form-control-sm" required id="address" value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                </div>
                                @if (Auth::check() && Auth::user()->phone != '' )                                       
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="phone">Номер телефона</label>
                                        <input type="text" class="form-control form-control-sm" readonly id="phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="phone">Номер телефона</label>
                                        <input type="text" class="form-control form-control-sm" required id="phone">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Способ оплаты
                            </button>
                        </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#order">
                        <div class="card-body">
                            <div class="form-check" id="payment_method">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_1" value="1" checked>
                                <label class="form-check-label" for="payment_method_1">
                                    Наличными при получении
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_2" value="2">
                                <label class="form-check-label" for="payment_method_2">
                                    По безналу (нужно будет ввести данные плательщика) 
                                    <button type="button" class="btn btn-sm btn-secondary color-white" data-toggle="modal" id="firm_edit" disabled data-target="#firm"><i class="fas fa-pencil-alt"></i></button>
                                </label>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Collapsible Group Item #3
                            </button>
                        </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#order">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                        </div>
                    </div>
                    <div class="modal" id="firm" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="firm_inn">ИНН</label>
                                            <input type="text" class="form-control form-control-sm" required id="firm_inn">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn m-green" id="firm_inn_confirm">Сохранить</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    </form>
                <div class="col-lg-12 row d-flex justify-content-end">
                    <a href="{{ route('order') }}" class="btn btn-success">Оформить заказ</a>
                </div>
            </div>
        </div>
    </section>
    
    
      
@endsection