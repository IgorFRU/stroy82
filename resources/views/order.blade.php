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
                <form class="accordion col-lg-12" id="order" action="{{ route('order.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <div class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Контактные данные
                            </div>
                        </h2>
                        </div>
                    
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#order">
                            <div class="card-body">
                                <h4>Для того, чтобы мы смогли доставить выбранные вами товары, введите ваши контактные данные</h4>                  
                                <div class="col-lg-5">                                    
                                    <div class="form-group">
                                        <label for="surname">Фамилия</label>
                                        <input type="text" class="form-control form-control-sm" name="surname" required id="surname" value="{{ Auth::user()->up_surname ?? '' }}">
                                    </div>
                                </div>  
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="name">Имя</label>
                                        <input type="text" class="form-control form-control-sm" name="name" required id="name" value="{{ Auth::user()->up_name ?? '' }}">
                                    </div>
                                </div>     
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="address">Адрес</label>
                                        <input type="text" class="form-control form-control-sm" name="address" required id="address" value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                </div>
                                @if (Auth::check() && Auth::user()->phone != '' )                                       
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="phone">Номер телефона</label>
                                        <input type="text" class="form-control form-control-sm" name="phone" readonly id="phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="phone">Номер телефона</label>
                                        <input type="phone" class="form-control form-control-sm" name="phone" required id="phone">
                                    </div>
                                </div>
                                @endif
                                @if (Auth::check() && Auth::user()->email != '' )                                       
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="email">Эл. почта</label>
                                        <input type="email" class="form-control form-control-sm" name="email" readonly id="email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label for="email">Эл. почта</label>
                                        <input type="email" class="form-control form-control-sm" name="email" id="email">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <div class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Способ оплаты
                            </div>
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
                                    Безналичный расчёт (нужно будет ввести данные плательщика) 
                                    <button type="button" class="btn btn-sm btn-secondary color-white" data-toggle="modal" id="firm_edit" disabled data-target="#firm"><i class="fas fa-pencil-alt"></i></button>
                                </label>
                            </div>
                            <div class="user_firms_list">
                                @if (Auth::check())  
                                    @foreach ($user->firms as $firm)
                                        <li class="btn btn-sm btn-secondary" data-inn="{{ $firm->inn ?? '' }}" disabled>{{ $firm->name ?? '' }} (ИНН {{ $firm->inn ?? '' }})</li>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <input type="hidden" name="firm_id">
                    <div class="modal" id="firm" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Данные фирмы-плательщика</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="col-lg-12 row">
                                        <div class="form-group col-lg-9 row">
                                            <label for="firm_inn" class="col-lg-3">ИНН</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_inn" id="firm_inn">
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="button" class="btn btn-warning btn-sm" id="firm_inn_check">Запросить данные</button>
                                        </div>
                                    </div>
                                    <div id="firm_data">
                                    <hr>
                                    <div class="col-lg-12 row">
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_name" class="col-lg-3">Название</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_name" id="firm_name">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_ogrn" class="col-lg-3">ОГРН</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_ogrn" id="firm_ogrn">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_okpo" class="col-lg-3">ОКПО</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_okpo" id="firm_okpo">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_postal_code" class="col-lg-3">Индекс</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_postal_code" id="firm_postal_code">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_region" class="col-lg-3">Регион</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_region" id="firm_region">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_city" class="col-lg-3">Город</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_city" id="firm_city">
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="firm_street" class="col-lg-3">Улица</label>
                                            <input type="text" maxlength="190" class="form-control form-control-sm col-lg-9" name="firm_street" id="firm_street">
                                            <input type="hidden" name="firm_status" id="firm_status">
                                        </div>
                                    </div>
                                </div>
                                <div id="firm_data_error" class="bg-danger p10 color-white">
                                    Данная организация не может выступать плательщиком. Введите, пожалуйста, другие данные.
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn m-green" id="firm_inn_confirm">Сохранить</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 row d-flex justify-content-end mt-20">
                        {{-- <button type="submit" class="btn btn-primary">Сохранить</button> --}}
                        <input type="submit" class="btn m-green" value="Завершить оформление заказа">
                    </div>
                </form>
                
            </div>
        </div>
    </section>
    
    
      
@endsection