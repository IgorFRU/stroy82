<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @section('scripts')

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://use.fontawesome.com/564e0d687f.js"></script>
    
    @show

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Cuprum:400,400i,700&display=swap&subset=cyrillic-ext" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
</head>
<body>
    <div id="app">
        <section class="top_nav navbar navbar-expand-lg">
            <div class="col-lg-3 left_nav">
                <a href="#">О нас</a>
                <a href="#">Оплата</a>
                <a href="#">Доставка</a>
                <a href="#">Контакты</a>
            </div>
            <div class="col-lg-4 search_nav">
                <input type="search" name="search_nav" id="search_nav" placeholder="поиск...">
            </div>
            <div class="col-lg-5 right_nav d-flex justify-content-lg-end">
                <a href="#"><i class="fas fa-check"></i> проверить статус заказа</a>
                <a href="#"><i class="fas fa-sign-in-alt"></i> вход</a>
                <a href="#"><i class="fas fa-user-plus"></i> регистрация</a>
            </div>
        </section>
        <nav class="">
            <div class="nav_content d-flex justify-content-between">
                <div class="logo">
                    <a href="/"><img src="{{ asset('imgs/Stroy82_logo_200_white.png') }}" alt=""></a>
                    
                </div>
                <div class="main_menu">
                    <a href="#">Категории</a>
                    <a href="#">Акции</a>
                    <a href="#">Подборки</a>
                    <a href="#">Статьи</a>
                </div>
                <div class="nav_contacts col-lg-2">
                    <span class="col-lg-12">Симферополь</span>
                    <a class="col-lg-12" href="tel:+79781234567">8(978) 123 45 67</a>
                    <a class="col-lg-12" href="tel:+79781234567">8(978) 123 45 67</a>
                </div>
                <div class="cart col-lg-2">
                    <div class="cart_img d-flex justify-content-end">
                        <div>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <span class="cart_count">0</span>
                        </div>                        
                        <span class="cart_sum">35 695 <i class="fas fa-ruble-sign"></i></span>
                    </div>
                    
                </div>
            </div>            
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
