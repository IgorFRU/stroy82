<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title . ' - ' ?? '' }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @section('scripts')

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <script src="https://use.fontawesome.com/564e0d687f.js"></script>    
    <script src="https://unpkg.com/imask"></script>
    
    @show

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Cuprum:400,400i,700&display=swap&subset=cyrillic-ext" rel="stylesheet">

    @section('styles')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    @show
</head>
<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('admin.index') }}" data-toggle="tooltip" data-placement="top" title="Главная страница"><i class="fas fa-sliders-h"></i><span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('admin.categories.index') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-store-alt"></i> Магазин
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ (Request::is('*products*') ? 'active' : '') }}" href="{{ route('admin.products.index') }}"><i class="fas fa-archive"></i> товары</a>
                                <a class="dropdown-item {{ (Request::is('*import-export*') ? 'active' : '') }}" href="{{ route('admin.import-export.index') }}"><i class="fas fa-file-excel"></i> импорт/экспорт</a>
                                <a class="dropdown-item {{ (Request::is('*categories*') ? 'active' : '') }}" href="{{ route('admin.categories.index') }}"><i class="fas fa-folder"></i> категории</a>
                                <a class="dropdown-item {{ (Request::is('*manufactures*') ? 'active' : '') }}" href="{{ route('admin.manufactures.index') }}"><i class="fas fa-industry"></i> производители</a>
                                <a class="dropdown-item {{ (Request::is('*vendors*') ? 'active' : '') }}" href="{{ route('admin.vendors.index') }}"><i class="fas fa-store-alt"></i>  Поставщики</a>
                                <a class="dropdown-item {{ (Request::is('*vendors*') ? 'active' : '') }}" href="{{ route('admin.sets.index') }}"><i class="fas fa-tasks"></i> Группы товаров</a>
                                <a class="dropdown-item {{ (Request::is('*units*') ? 'active' : '') }}" href="{{ route('admin.units.index') }}"><i class="fas fa-tape"></i>  Ед. измерения</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('admin.categories.index') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-tags"></i> Продвижение
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ (Request::is('*discounts*') ? 'active' : '') }}" href="{{ route('admin.discounts.index') }}"><i class="fas fa-percentage"></i>  Акции</a>
                                <a class="dropdown-item {{ (Request::is('*articles*') ? 'active' : '') }}" href="{{ route('admin.articles.index') }}"><i class="fas fa-newspaper"></i>  Статьи</a>
                                <a class="dropdown-item {{ (Request::is('*banners*') ? 'active' : '') }}" href="{{ route('admin.banners.index') }}"><i class="fas fa-images"></i>  Баннеры</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle rounded text-dark bg-info" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-archive"></i>  Покупатели и заказы
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ (Request::is('*consumers*') ? 'active' : '') }}" href="{{ route('admin.consumers.index') }}"><i class="fas fa-user-friends"></i>  Покупатели</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ (Request::is('*orders') ? 'active' : '') }}" href="{{ route('admin.orders') }}"><i class="fas fa-shopping-basket"></i>  Заказы</a>
                                <a class="dropdown-item rounded text-white bg-danger" href="{{ route('admin.hot.orders') }}"><i class="fas fa-fire"></i>  Заказы к исполнению @if ($active_orders_count > 0)
                                    <span class="badge badge-light">{{ $active_orders_count }}</span>
                                @endif</a>
                                <a class="dropdown-item {{ (Request::is('*orders/archive') ? 'active' : '') }}" href="{{ route('admin.archive.orders') }}"><i class="fas fa-boxes"></i>  Архив заказов</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ (Request::is('*orderstatuses*') ? 'active' : '') }}" href="{{ route('admin.orderstatuses.index') }}"><i class="fas fa-check"></i>  Статусы заказов</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('admin.categories.index') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-file-alt"></i> Статические страницы
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item {{ (Request::is('*topmenu*') ? 'active' : '') }}" href="{{ route('admin.topmenu.index') }}">Верхнее меню</a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}" target="_blank"><i class="fas fa-link"></i>  На сайт</a>
                        </li>
                        
                        <!-- Authentication Links -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user-shield"></i>  {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="@if (Auth::guard('admin')->check()) {{ route('admin.profile') }} @endif">Профиль</a>
                                     <hr>
                                    <a class="dropdown-item" href="@if (Auth::guard('admin')->check()) {{ route('admin.logout') }} @else {{ route('logout') }} @endif"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>  {{ __('Выйти') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link @if ($active_orders_count > 0) text-danger @endif" href="{{ route('admin.categories.index') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell"></i> @if ($active_orders_count > 0)
                                    <span class="badge badge-danger">{{ $active_orders_count }}</span>
                                @endif
                                </a>
                                @if ($active_orders_count > 0)
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item  rounded text-white bg-danger" href="{{ route('admin.hot.orders') }}">Есть новые заказы</a>
                                    </div>
                                @else
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <div class="dropdown-item">Уведомлений нет</div>
                                    </div>
                                @endif
                                
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @section('adminmenu')
                
                
            @show
            @yield('content')
            <div class="flash-messeges">
                @if (Session::has('success'))
                    <div class="shadow alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('warning'))
                    <div class="shadow alert alert-warning">{!! Session::get('warning') !!}</div>
                @endif
                @if (Session::has('danger'))
                    <div class="shadow alert alert-danger">{!! Session::get('danger') !!}</div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
