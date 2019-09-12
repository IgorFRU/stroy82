@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
               
        @slot('active') Личный кабинет @endslot
    @endcomponent 
    
    
    
    <section class="wrap">
        <div class="white_box p10">
            <div class="user_section">
                <h2 id="fullname"><i class="fas fa-user-alt"></i> <span>{{ Auth::user()->full_name }}</span></h2>
            </div>
            <div class="user_section">
                <h2><i class="fas fa-info-circle"></i> Личные данные <button type="button" class="btn btn-sm btn-secondary color-white" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fas fa-pencil-alt"></i></button></h2>
                <div class="user_section__content">                        
                    <div class="d-flex justify-content-start mt-20">
                        @if(isset(Auth::user()->up_surname) && strlen(Auth::user()->up_surname) > 0)
                        <div class="custom_input mr-50">
                            <div class="custom_input__top_title color-ll-grey">
                                Фамилия
                            </div>
                            <div class="custom_input__content" id="surname">
                                {{ Auth::user()->up_surname }}
                            </div>
                        </div>   
                        @endif
                        @if(strlen(Auth::user()->up_name) > 0)
                        <div class="custom_input">
                            <div class="custom_input__top_title color-ll-grey">
                                Имя
                            </div>
                            <div class="custom_input__content" id="name">
                                {{ Auth::user()->up_name }}
                            </div>
                        </div>   
                        @endif
                    </div>                       
                    <div class="d-flex justify-content-start mt-20">
                        @if(strlen(Auth::user()->email) > 0)
                        <div class="custom_input mr-50">
                            <div class="custom_input__top_title color-ll-grey">
                                эл. почта
                            </div>
                            <div class="custom_input__content" id="email">
                                {{ Auth::user()->email }}
                            </div>
                        </div>   
                        @endif
                        @if(strlen(Auth::user()->phone) > 0)
                        <div class="custom_input mr-50">
                            <div class="custom_input__top_title color-ll-grey">
                                Номер телефона
                            </div>
                            <div class="custom_input__content">
                                {{ Auth::user()->phone }}
                            </div>
                        </div>   
                        @endif
                        @if(strlen(Auth::user()->address) > 0)
                        <div class="custom_input mr-50">
                            <div class="custom_input__top_title color-ll-grey">
                                адрес
                            </div>
                            <div class="custom_input__content" id="address">
                                {{ Auth::user()->address }}
                            </div>
                        </div>   
                        @endif
                    </div>
                </div>
            </div>
            <div class="user_section">
                <h2><i class="fas fa-shopping-cart"></i> Активные заказы <a href="#" class="btn btn-sm btn-secondary color-white"><i class="fas fa-archive"></i> Архив заказов</a></h2>
                <div class="user_section__content mt-20">
                    <p class="color-ll-grey">
                        У вас пока нет активных заказов
                    </p>
                </div>
            </div>
            <div class="user_section">
                <h2><i class="fas fa-heart"></i> Избранные товары</h2>
                <div class="user_section__content mt-20">
                    <p class="color-ll-grey">
                        У вас пока нет избранных товаров
                    </p>
                </div>
            </div>
        </div>
    </section>
  
    
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header l-green">
            <h5 class="modal-title" id="exampleModalLabel">Редактирование персональных данных</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="user_info" action="{{ route('user.edit') }}">
                @csrf
                <div class="row col-lg-12">
                    <div class="form-group col-lg-6">
                        <label for="user_info_surname" class="col-form-label">Фамилия:</label>
                        <input type="text" class="form-control" id="user_info_surname" maxlength="100" name="user_info_surname" value="{{ Auth::user()->up_surname ?? '' }}">
                    </div>
                    <div class="form-group col-lg-6">
                            <label for="user_info_name" class="col-form-label">Имя:</label>
                            <input type="text" class="form-control" id="user_info_name" maxlength="100" name="user_info_name" required value="{{ Auth::user()->up_name ?? '' }}">
                    </div>
                </div>

                <div class="row col-lg-12">
                    <div class="form-group col-lg-12">
                        <label for="user_info_address" class="col-form-label">Адрес:</label>
                        <input type="text" class="form-control" id="user_info_address" maxlength="190" name="user_info_address" value="{{ Auth::user()->address ?? '' }}">
                    </div>
                </div>

                <div class="row col-lg-12">
                    <div class="form-group col-lg-12">
                        <label for="user_info_email" class="col-form-label">Эл. почта:</label>
                        <input type="email" class="form-control" id="user_info_email" maxlength="100" name="user_info_email" required value="{{ Auth::user()->email ?? '' }}">
                    </div>
                </div>
                <input type="hidden" name="user_info_id" id="user_info_id" value="{{ Auth::user()->id ?? '' }}">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
            <input type="submit" class="btn l-green user_info_send" value="Сохранить">
        </div>
        </div>
    </div>
</div>
@endsection