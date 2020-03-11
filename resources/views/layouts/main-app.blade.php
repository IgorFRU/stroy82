<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="65ebcfbce0d79b0b" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{!! $description ?? $about->main_text ?? 'Интернет-магазин строительных товаров в Симферополе. Доставка по Крыму.' !!}"> 

    <title> @if (isset($local_title)){{ $local_title . ' - ' }}@endif {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Scripts -->
    @section('scripts')

    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script> --}}
    <script src="{{ asset('js/script.js') }}" defer></script>
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
    {{-- <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    @show
</head>
<body>
    <div id="app">
        <section class="top_nav navbar flex-row flex-nowrap justify-content-between d-flex align-items-center">
            <div class="left_nav">
                @forelse ($topmenu as $item)
                    <a href="{{ $item->slug ?? '#' }}">{{ $item->title }}</a>
                @empty
                @endforelse
                <a href="{{ route('contacts') }}">Контакты</a>
            </div>
            <div class="search_nav">
                <form action="{{ route('search') }}" method="get">
                    <input type="search" name="q" id="search_nav" placeholder="поиск...">
                    <div class="search_nav__result shadow p-3 bg-white rounded text-dark">
                        <span class="close_button" aria-hidden="true">&times;</span>
                        <div class="search_nav__products p-2 border-bottom">
                            <div class="h5">Товары</div>
                            <div class="search_nav__products_body"></div>
                        </div>
                        <div class="search_nav__categories p-2 border-bottom">
                            <div class="h5">Категории</div>
                            <div class="search_nav__categories_body"></div>
                        </div>
                        <div class="search_nav__manufactures p-2">
                            <div class="h5">Производители</div>
                            <div class="search_nav__manufactures_body"></div>
                        </div>
                        <button type="submit" class="btn btn-info">Все результаты поиска</button>
                    </div>
                </form>
            </div>
            <div class="right_nav d-flex justify-content-lg-end">
                <a  data-toggle="modal" data-target=".check_order_status" href="#" title="Проверить статус заказа"><i class="fas fa-check"></i> <span class="d-none d-md-inline">проверить статус заказа</span></a>


                @guest
                    <a href="{{ route('login') }}" title="Вход"><i class="fas fa-sign-in-alt"></i> <span class="d-none d-md-inline">вход</span></a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" title="Регистрация"><i class="fas fa-user-plus"></i> <span class="d-none d-md-inline">регистрация</span></a>
                    @endif
                @else
                    <div class="right_nav__user l-red">
                        <span><i class="far fa-user"></i> {{ Auth::user()->name }} <i class="fas fa-sort-down"></i></span>
                        <div class="right_nav__user__menu">
                            <a href="{{ route('home') }}">Личный кабинет</a>
                            <a href="{{ route('usersOrders') }}">Мои заказы</a>
                            <a class="" href="@if (Auth::guard('admin')->check()) {{ route('admin.logout') }} @else {{ route('logout') }} @endif"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Выход</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest   
            </div>
        </section>
        <nav class="">
            <div class="nav_content d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="/"><img src="{{ asset('imgs/Stroy82_logo_200_white.png') }}" alt=""></a>
                    
                </div>
                <div class="burger d-block ">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="main_menu mr-2 d-flex">
                    
                    <div class="main_menu__item">
                        <a href="{{ route('categories') }}">Категории</a>
                        @if (count($categories) > 0)
                            <div class="main_menu__submenu">
                                @foreach ($categories as $category)
                                <div class="main_menu__submenu__item">
                                    <a @if (count($category->children) > 0) class="parent_link" @endif href="{{ route('category', $category->slug) }}">{{ $category->category }}</a>
                                    @if (count($category->children) > 0)
                                        <div class="main_menu__submenu__right">
                                            @foreach ($category->children as $children)
                                                <a href="{{ route('category', $children->slug) }}">{{ $children->category }}</a>
                                                @if (count($category->children) > 0)
                                                @endif                            
                                            @endforeach
                                        </div>
                                    @endif
                                </div>                                
                                @endforeach
                            </div>
                        @endif                        
                    </div>
                    <div class="main_menu__item">
                        <a href="{{ route('sales') }}">Акции</a>
                    </div>
                    @if (count($sets) > 0)
                        <div class="main_menu__item">
                            <a href="{{ route('sets') }}">Подборки</a>                            
                            <div class="main_menu__submenu">
                                @foreach ($sets as $set)
                                <div class="main_menu__submenu__item">
                                    <a href="{{ route('set', $set->slug) }}">{{ $set->set }}</a>
                                </div>                                
                                @endforeach
                            </div>                                  
                        </div>
                    @endif
                    <div class="main_menu__item">
                        <a href="{{ route('articles') }}">Статьи</a>
                    </div>
                </div>
                <div class="nav_contacts mr-2">
                    @isset($settings->phone_main)
                        <a class="col-lg-12" href="tel:+7{{ $settings->phone_main }}">{{ $settings->main_phone }}</a>
                    @endisset
                    @isset($settings->phone_add)
                        <a class="col-lg-12" href="tel:+7{{ $settings->phone_add }}">{{ $settings->add_phone }}</a>
                    @endisset
                </div>  
                <div class="nav_contacts nav_contacts_address col-lg-2 mr-2 d-none d-sm-block">{{ $settings->address ?? '' }}</div>                  
                    
                <div class="cart">
                    <div class="cart_img d-flex justify-content-end">
                        <div>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                            <span class="cart_count">0</span>
                        </div>                       
                        <span class="cart_sum"><span>0</span><i class="fas fa-ruble-sign"></i></span>
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
                                        <div class="product_sum btn btn-sm btn-dark disabled">{{ number_format($product->price * $carts[$product->id], 2, ',', ' ') }} руб.</div>
                                    @endif

                                    
                                </div>
                                
                            </div>
                            @endforeach
                            <hr>
                            <div class="product_sum d-flex justify-content-end">
                                <span>Общая сумма (руб.): </span>
                                <div class="btn product_finalsum btn-dark disabled"> {{ number_format($total_price, 2, ',', ' ') }}</div>
                                <div class="btn m-green"><a href="{{ route('cart') }}">Перейти в корзину</a></div>
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

    <div class="modal fade check_order_status" tabindex="-1" role="dialog" aria-labelledby="check_order_status" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('checkorderstatus') }}" method="post">
                <div class="modal-content">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="check_order_status__number" class="col-form-label">№ заказа</label>
                            <div class="">
                                <input type="text" class="form-control" id="check_order_status__number" name="check_order_status__number" value="" maxlength="11" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="check_order_status__phone" class="col-form-label">Последние 4 цифры номера телефона, на который был сделан заказ</label>
                            <div class="">
                                <input type="text" class="form-control" id="check_order_status__phone" name="check_order_status__phone" placeholder="" minlength="4" maxlength="4" required>
                            </div>
                        </div>                        
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary check_order_status__send" >Отправить</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
