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
                <div class="cart col-lg-3">
                    <div class="cart_img d-flex justify-content-end">
                        <div>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <span class="cart_count">0</span>
                        </div>                       
                        <span class="cart_sum"><span></span><i class="fas fa-ruble-sign"></i></span>
                    </div>
                    @isset($cart_products)
                        <div class="cart__content white_box p10 big_shadow">
                        @if (count($cart_products))
                            
                        
                        
                            @php
                                $total_price = 0;
                            @endphp
                            @foreach ($cart_products as $product)
                            {{-- @php
                                dd($product);
                            @endphp --}}
                            
                            <div class="cart__content__item d-flex justify-content-between @if ($loop->last) last @endif" data-product="{{$product->id}}">
                                <div class="cart__content__left d-flex">
                                    @if (isset($product->main_or_first_image->thumbnail))
                                        <img src="{{ asset('imgs/products/thumbnails')}}/{{ $product->main_or_first_image->thumbnail ??  '' }}">
                                    @else
                                        <img src="{{ asset('imgs/nopic.png') ??  '' }}">
                                    @endif

                                    @if(isset($product->category->slug))
                                        <div class="product_title"><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></div>
                                    @else
                                        <div class="product_title"><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></div>
                                    @endif
                                </div>
                                <div class="cart__content__right d-flex">                                    
                                    <div class="product_quantity">{{ $carts[$product->id] }} @isset($product->unit_id) {{ $product->unit->unit }} @endisset</div>

                                    @if ($product->actually_discount)
                                        @php
                                            $price = $product->discount_price * $carts[$product->id];
                                            $total_price += $price;
                                        @endphp
                                        <div class="product_sum btn btn-sm btn-info">{{ number_format($product->discount_price * $carts[$product->id], 2, ',', ' ') }} руб.</div>                                        
                                    @else
                                        @php
                                            $price = $product->price * $carts[$product->id];
                                            $total_price += $price;
                                        @endphp
                                        <div class="product_sum btn btn-sm btn-info">{{ number_format($product->price * $carts[$product->id], 2, ',', ' ') }} руб.</div>
                                    @endif

                                    
                                </div>
                                
                            </div>
                            @endforeach
                            <hr>
                            <div class="product_sum d-flex justify-content-end">
                                <span>Общая сумма (руб.): </span>
                                <div class="btn product_finalsum  btn-info"> {{ number_format($total_price, 2, ',', ' ') }}</div>
                                <div class="btn m-green">Оформить заказ</div>
                            </div>
                        </div> 
                        @else
                            корзина пока пуста
                        @endif
                    @endisset
                    
                    
                </div>
            </div>            
        </nav>

        <main>
            @yield('content')
        </main>
        <footer>
                @include('layouts.footer')
        </footer>
    </div>
</body>
</html>
