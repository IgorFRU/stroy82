@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><p class="h3">Основные настройки сайта</p></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                   
                    
                    <div class="row">
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('admin.settings') }}">                            
                                <div class="form-group row">
                                    <label for="site_name" class="col-sm-3 col-form-label">Название сайта</label>
                                    <div class="col-md-9">
                                        <input type="text" name="site_name" class="form-control" id="site_name" value="{{ $settings->site_name ?? '' }}">
                                    </div>                                    
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Адрес</label>
                                    <div class="col-md-9">
                                        <input type="text" name="address" class="form-control" id="address" value="{{ $settings->address ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_1" class="col-sm-3 col-form-label">Основной номер телефона</label>
                                    <div class="col-md-9">
                                        <input type="text" name="phone_1" class="form-control" id="phone_1" value="{{ $settings->phone_1 ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_2" class="col-sm-3 col-form-label">Дополнительный номер телефона</label>
                                    <div class="col-md-9">
                                        <input type="text" name="phone_2" class="form-control" id="phone_2" value="{{ $settings->phone_2 ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">E-mail</label>
                                    <div class="col-md-9">
                                        <input type="email" name="email" class="form-control" id="email" value="{{ $settings->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="viber" class="col-sm-3 col-form-label">Viber</label>
                                    <div class="col-md-4">
                                        <input type="text" name="viber" class="form-control" id="viber" value="{{ $settings->viber ?? '' }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info">Из осн. тел.</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-info">Из доп. тел.</button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="vkontakte" class="col-sm-3 col-form-label">Вконтакте</label>
                                    <div class="col-md-9">
                                        <input type="text" name="vkontakte" class="form-control" id="vkontakte" value="{{ $settings->vkontakte ?? '' }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="main_text" class="col-sm-3 col-form-label">Информация о магазине</label>
                                    <div class="col-md-9">
                                            <textarea class="form-control" name="main_text" id="exampleFormControlTextarea1" rows="10">{{ $settings->main_text ?? '' }}</textarea>
                                    </div>
                                </div> 
                                <button type="submit" class="btn btn-primary">Сохранить</button>                           
                            </form>
                        </div>
                        <div class="col-md-6">
                            <p class="h3">Список администраторов</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">e-mail</th>
                                    <th scope="col">Зарегистрирован</th>
                                    <th scope="col">Изменен</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 1
                                @endphp
                                @foreach ($admins as $admin)
                                <tr @if ($admin->id == $one_admin->id) class="table-success" @endif >
                                    <th scope="row">{{ $count++ }}</th>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->created_at }}</td>
                                    <td>{{ $admin->updated_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="h3">Последние необработанные заказы</p>
                                <button type="button" class="btn btn-warning"><a href="#">Все заказы</a></button>
                            </div>
                            
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Покупатель</th>
                                    <th scope="col">Фамилия</th>
                                    <th scope="col">Номер тел.</th>
                                    <th scope="col">Зарегистрирован</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 1
                                @endphp
                                @foreach ($orders as $order)
                                <tr>
                                    <th scope="row"><a href="#">{{ $order->number }}</a></th>
                                    <td><a href="#"></a> {{ $order->consumers->id }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td><a href="tel: {{ $user->phone }}">{{ $user->phone }}</a> </td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <p class="h3">Последние зарегистрированные покупатели</p>
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Фамилия</th>
                                    <th scope="col">Номер тел.</th>
                                    <th scope="col">Зарегистрирован</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $count = 1
                                @endphp
                                @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $count++ }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td><a href="tel: {{ $user->phone }}">{{ $user->phone }}</a> </td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
