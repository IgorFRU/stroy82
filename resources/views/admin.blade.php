@extends('layouts.admin-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/ajax_upload_product_image.js') }}" defer></script>
    <script src="https://cdn.tiny.cloud/1/4ogn001qp1t620kw68fag111as9qnq1nqba3n4ycar2puh9p/tinymce/5/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'#description',
            plugins: "anchor link insertdatetime lists"
        });
    </script>
@endsection
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif 
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-home"></i></a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-profile" aria-selected="false">Настройки</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-activity" role="tab" aria-controls="nav-contact" aria-selected="false">Последние активности</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane mt-4 mb-4 fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row mb-4 d-flex justify-content-center align-self-stretch w-100">
                <div class="card mr-1 ml-1 text-center bg-warning" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Сегодня</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1 js_date_today"></p>
                    </div>
                </div>

                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Товаров</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $product_count ?? '' }}</p>
                        <a href="{{ route('admin.products.index') }}" class="card-link">Список</a>
                        <a href="{{ route('admin.products.create') }}" class="card-link">Добавить товар</a>
                    </div>
                </div>

                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Категорий</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $category_count ?? '' }}</p>
                        <a href="{{ route('admin.categories.index') }}" class="card-link">Список</a>
                        <a href="{{ route('admin.categories.create') }}" class="card-link">Добавить категорию</a>
                    </div>
                </div>
            </div>
            <div class="row mb-4 d-flex justify-content-center align-self-stretch w-100">
                <div class="card mr-1 ml-1 text-center @if($hot_orders > 0) bg-danger @else bg-info  @endif text-white" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Заказов к исполнению</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $hot_orders ?? '' }}</p>
                        <a href="{{ route('admin.hot.orders') }}" class="card-link text-white">Список</a>
                    </div>
                </div>
                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Покупателей</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $user_count ?? '' }}</p>
                        <a href="{{ route('admin.consumers.index') }}" class="card-link">Список</a>
                    </div>
                </div>
                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Незавершённых корзин</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $hot_carts ?? '' }}</p>
                        {{-- <a href="{{ route('admin.discounts.index') }}" class="card-link">Список</a> --}}
                    </div>
                </div>
            </div>
            <div class="row mb-4 d-flex justify-content-center align-self-stretch w-100">
                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Активных акций</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $hot_discounts ?? '' }}</p>
                        <a href="{{ route('admin.discounts.index') }}" class="card-link">Список</a>
                    </div>
                </div>
                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Баннеров</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $banners_count ?? '' }}</p>
                        <a href="{{ route('admin.banners.index') }}" class="card-link">Список</a>
                    </div>
                </div>
                <div class="card mr-1 ml-1 text-center" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Статей</h5>
                        {{-- <h6 class="card-subtitle mb-2 text-muted"></h6> --}}
                        <p class="card-text h1">{{ $articles_count ?? '' }}</p>
                        <a href="{{ route('admin.articles.index') }}" class="card-link">Список</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="tab-pane fade mt-4 mb-4" id="nav-settings" role="tabpanel" aria-labelledby="nav-profile-tab">
            <form method="POST" action="{{ route('admin.settings', $settings->id) }}">  
                <div class="d-flex">
                    <div class="col-lg-5">
                        
                    {{-- <form method="POST" action="admin/settings/{{ $settings->id }}">     --}}    
                        @csrf
                        {{-- <input type="hidden" name="_method" value="put">                    --}}
                        <input type="hidden" name="id" value="{{ $settings->id }}">                   
                        <div class="form-group row">
                            <label for="site_name" class="col-sm-4 col-form-label">Название сайта</label>
                            <div class="col-md-8">
                                <input type="text" name="site_name" class="form-control" id="site_name" value="{{ $settings->site_name ?? '' }}">
                            </div>                                    
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-4 col-form-label">Адрес</label>
                            <div class="col-md-8">
                                <input type="text" name="address" class="form-control" id="address" value="{{ $settings->address ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_1" class="col-sm-4 col-form-label">Основной номер телефона</label>
                            <div class="col-md-8">
                                <input type="text" name="phone_main" class="form-control phone-mask" id="phone_1" value="{{ $settings->phone_main ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone_2" class="col-sm-4 col-form-label">Дополнительный номер телефона</label>
                            <div class="col-md-8">
                                <input type="text" name="phone_add" class="form-control phone-mask" id="phone_2" value="{{ $settings->phone_add ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">E-mail</label>
                            <div class="col-md-8">
                                <input type="email" name="email" class="form-control" id="email" value="{{ $settings->email ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="viber" class="col-sm-4 col-form-label">Viber</label>
                            <div class="col-md-8">
                                <input type="text" name="viber" class="form-control" id="viber" value="{{ $settings->viber ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label"></label>
                            <div class="col-md-3">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" id="phone_1_button" class="btn btn-secondary">Из осн. тел.</button>
                                        <button type="button" id="phone_2_button" class="btn btn-secondary">Из доп. тел.</button>
                                    </div>                                        
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vkontakte" class="col-sm-4 col-form-label">Вконтакте</label>
                            <div class="col-md-8">
                                <input type="text" name="vkontakte" class="form-control" id="vkontakte" value="{{ $settings->vkontakte ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group row">
                            <label for="main_text" class="col-sm-4 col-form-label">Информация о магазине</label>
                            <div class="col-md-8">
                                    <textarea class="form-control" name="main_text" id="description" rows="70">{{ $settings->main_text ?? '' }}</textarea>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-primary">Сохранить</button>                
                    </div>
                </div>
            </form>                
        </div>
        <div class="tab-pane fade mt-4 mb-4" id="nav-activity" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="w-100">
                <div class=" d-flex justify-content-between">
                    <p class="h3">Список администраторов</p>
                    {{-- <button class="btn btn-sm btn-info">Изменить параметры безопасности</button> --}}
                </div>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">e-mail</th>
                        <th scope="col">Зарегистрирован</th>
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
                    </tr>
                    @endforeach      
                    </tbody>
                </table>
                <hr>
                <div class="d-flex justify-content-between mb-1">
                    <p class="h3">Последние необработанные заказы</p>
                    <a class="btn btn-primary" href="{{ route('admin.orders') }}">Все заказы</a>
                </div>
                
                <table class="table table-dark">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Покупатель</th>
                        <th scope="col">Номер тел.</th>
                        <th scope="col">Зарегистрирован</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $count = 1
                    @endphp
                    @forelse ($orders as $order)
                    <tr>
                        <th scope="row"><a href="{{ route('admin.order', $order->number) }}" target="_blank">{{ $order->number }}</a></th>
                        <td>{{ $order->create_d_m_y_t }}</td>
                        <td><a href="#"></a> {{ $order->consumers->full_name ?? '' }}</td>
                        <td><a href="tel: {{ $order->consumers->phone ?? '' }}">{{ $order->consumers->phone ?? '' }}</a> </td>
                        <td>{{ $order->consumers->created_at ?? '' }}</td>
                    </tr>
                    @empty
                    
                    @endforelse
                    </tbody>
                </table>
                <hr>
                <div class="d-flex justify-content-between mb-1">
                    <p class="h3">Последние зарегистрированные покупатели</p>
                    <a class="btn btn-primary" href="{{ route('admin.consumers.index') }}">Все покупатели</a>
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Покупатель</th>
                        <th scope="col">e-mail</th>
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
                        <td><a href="{{ route('admin.consumer', $user->id) }}" target="_blank">{{ $user->full_name }}</a></td>
                        <td>{{ $user->email ?? '' }}</td>
                        <td><a href="tel: {{ $user->phone ?? '' }}">{{ $user->phone ?? '' }}</a> </td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function(e){
        const phone_1 = document.querySelector('#phone_1').value;
        const phone_2 = document.querySelector('#phone_2').value;
        var viber = document.querySelector('#viber');
        document.getElementById('phone_1_button').addEventListener("click", function() {
            viber.value = phone_1;
        });
        document.getElementById('phone_2_button').addEventListener("click", function() {
            viber.value = phone_2;
        });
    }
    
    // var phone_2_button = document.querySelector('.phone_2_button');
    
    // phone_2_button.addEventListener("click", function() {
    //     console.log(phone_1_button);
    //     viber.value = phone_2;
    // });
</script>
@endsection
