@extends('layouts.main-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/discount_countdown.js') }}" defer></script>
@endsection
@section('content')
    <div class="header">
        @if (count($banners) > 0)
            <div id="carouselExampleCaptions" class="carousel slide carousel_header" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($banners as $item)
                        <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->iteration-1 }}" class="@if($loop->iteration == 1) active @endif"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner mainpage-banners">
                    @foreach ($banners as $banner)
                        <div class="carousel-item @if($loop->iteration == 1) active @endif">
                            @if ($banner->tags->count())
                                <div class="banner_tags">
                                    @forelse ($banner->tags as $tag)
                                        <div class="mb-4">
                                            <div class="banner_tag mr-2 {{ $tag->shadow }} {{ $tag->rounded }}" style="padding: {{ $tag->padding }}px; background: {{ $tag->background }}; color: {{ $tag->color }}; box-shadow: ;">{{ $tag->text }}</div>
                                        </div>
                                    @empty
                                        
                                    @endforelse
                                </div>
                            @endif
                            <img src="{{ asset('imgs/banners/')}}/{{ $banner->image }}" class="d-block w-100" alt="{{ $banner->title ?? '' }}">
                            <div class="carousel-caption">
                            <h5>@if ($banner->link != '' || $banner->link != NULL)
                                <a href="{{ $banner->link }}" target="_blank">{{ $banner->title ?? 'Перейти...' }}</a>
                            @else
                                {{ $banner->title ?? '' }}
                            @endif                                
                            </h5>
                            <p>{{ $banner->description ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        @endif
    </div>
    <section class="welcome_section">
        <div class="container">
            <div class="box mt--40 mb--40 col-md-12 d-flex flex-wrap shadow align-self-stretch">
                <div class="col-lg-7 col-12">
                    <img src="{{ asset('imgs/m_hardhatandtools.jpg')}}" class="img-fluid p-4 bg-white" alt="">
                </div>
                <div class="bg-white col-lg-5 col-12 p-2">
                    <div class="p-4 text-center">
                        <h3 class=" mb-4 mt-4">Добро пожаловать на сайт строительного магазина <span class="h2 text-danger">Stroy82.com</span></h3>
                        <p class="text-secondary">В нашем интернет-магазине можно купить дёшево практически любой вид стройматериалов с быстрой и удобной доставкой по Симферополю и другим городам Крыма!</p>
                    </div>                    
                </div>
            </div>
        </div>
    </section>

        {{-- <div class="header_banners col-lg-9">
            <div class="header_banner">
                <img src="{{ asset('imgs/banners/i8.jpg') }}" alt="" class="img-fluid">
                <div class="header_banner__control">
                    <div class="">
                        <h3>
                            <a href="#">Скидка 30% на кирпич облицовочный</a>                                
                        </h3>                            
                    </div>
                    <div class="control__date btn bg-light-red">
                        с 15.07 по 29.07 
                    </div>
                </div>
            </div>  
            <div class="superiorities col-lg-12 d-flex justify-content-between">
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-truck"></i></div>
                    <span>Быстрая доставка по Симферополю и Крыму</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="far fa-credit-card"></i></div>
                    <span>Удобные способы оплаты заказа</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-money-bill-alt"></i></div>
                    <span>Отличные цены вне конкуренции</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-phone"></i></div>
                    <span>Доступность менеджера с 08:00 до 19:00</span>
                </div>    
            </div>              
        </div> --}}
        {{-- @isset($articles)
        <div class="header_articles col-lg-3">
            @foreach ($articles as $article)
                <div class="header_article">
                    <h5>
                        {{ $article->limit_title }}
                    </h5>
                    <div class="d-flex justify-content-between">
                        <span>
                            {{ $article->start_date }}
                        </span>
                        <a href="{{ route('article', $article->slug) }}">далее...</a>
                    </div>
                </div>
            @endforeach
        </div>
        @endisset             --}}
    <section class="superiorities">
        <div class='wrap col-lg-12 d-flex flex-wrap justify-content-between color-white'>
            <div class="superiority col-md-3 col-sm-6 col-12 mb-4 mb-md-0">
                <div class="superiority__icon"><i class="fas fa-truck"></i></div>
                <span>Быстрая доставка по Симферополю и Крыму</span>
            </div>
            <div class="superiority col-md-3 col-sm-6 col-12 mb-4 mb-md-0">
                <div class="superiority__icon"><i class="far fa-credit-card"></i></div>
                <span>Удобные способы оплаты заказа</span>
            </div>
            <div class="superiority col-md-3 col-sm-6 col-12 mb-4 mb-md-0">
                <div class="superiority__icon"><i class="fas fa-money-bill-alt"></i></div>
                <span>Отличные цены вне конкуренции</span>
            </div>
            <div class="superiority col-md-3 col-sm-6 col-12 mb-4 mb-md-0">
                <div class="superiority__icon"><i class="fas fa-phone"></i></div>
                <span>Доступность менеджера с 08:00 до 19:00</span>
            </div>   
        </div>
    </section> 

    @isset($discounts)
    <section class="discount_products">
        <div class="container">
            <div class="box mt--40 mb--20 shadow bg-white">                
                <h3 class="h1 text-center color-main font-weight-bold">Успейте купить</h3>
                <div class="d-flex align-self-stretch flex-wrap">
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($discounts as $discount)        
                        @break($count == 3)
                        @foreach ($discount->product as $product)
                            @break($count == 3)
                            @php $count++; @endphp
                            <div class="col-lg-4 p-2">
                                <div class="bg-secondary p-4 img_overflow text-white" style="background-image: url({{ asset('imgs/products/thumbnails/') }}/{{ $product->main_or_first_image->thumbnail ?? '' }}); background-size: cover;">
                                    <div class="sale_product__info">
                                        <h3 class="mb-4">
                                            @if(isset($product->category->slug))
                                                <a class="text-white" href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a>
                                            @else
                                                <a class="text-white" href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a>
                                            @endif
                                        </h3>

                                        <div class="prices d-flex lg-12 p-2 bg-dark color-white rounded shadow justify-content-around">
                                            <div class="old_price">{{ $product->price }}</div>
                                            <div class="new_price">
                                                @if ($product->discount->type == '%')
                                                    {{ number_format($product->price * $product->discount->numeral, 2, ',', ' ') }}
                                                @elseif ($product->discount->type == 'rub')
                                                    {{ number_format($product->price - $product->discount->value, 2, ',', ' ') }}
                                                @endif <span><i class="fas fa-ruble-sign"></i>@isset($product->unit) за 1 {{ $product->unit->unit }} @endisset</span>
                                            </div>
                                        </div>
                                        <div id="countdown-{{ $product->id }}" class="sale_product__count d-flex mb-4 color-white justify-content-around" data-id={{ $product->id }} data-discount="{{ $product->discount->discount_end }}">                                
                                            <div class="countdown-number">
                                                <span class="days countdown-time"></span>
                                            </div>
                                            <div class="countdown-number">
                                                <span class="hours countdown-time"></span>
                                            </div>
                                            <div class="countdown-number">
                                                <span class="minutes countdown-time"></span>
                                            </div>
                                            <div class="countdown-number">
                                                <span class="seconds countdown-time"></span>
                                            </div>                                             
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    @endforeach
                </div>
            </div>
        </div>
    </section> 
    @endisset
    
    @if (count($articles)> 0)
        <section class="mb-5 mt-5 wrap">
            <div class="section_title">
            </div>
            <div class="card-group">
                @forelse ($articles as $article)
                    <div class="col-12 mb-2">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title"><a href="{{ route('article', $article->slug) }}">{{ $article->limit_title }}</a></h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $article->start_date }}</h6>
                                <p class="card-text">{!! $article->limit_text !!}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    
                @endforelse
            </div>
        </section>
    @endif
    
    @isset($categories)
    <section class="categories container mt-5">
        <div class="section_title">
            <h3 class="h1 text-center color-main font-weight-bold">Категории товаров</h3>
        </div>
        <div class="category_cards row">
            @foreach ($categories as $category)
                <div class="col-12 col-sm-6 col-md-4 p-1">
                    <div class="category_card white_box">
                        <div class="category_card__img">
                            <img  class="img-fluid"
                            @if(isset($category->image))
                                src="{{ asset('imgs/categories/')}}/{{ $category->image }}"
                            @else 
                                src="{{ asset('imgs/nopic.png')}}"
                            @endif >
                        </div> 
                        <div class="category_card__title p10">
                            <h2 class="h4"><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></h2>
                        </div>
                    </div>
                </div>                
            @endforeach
        </div>
    </section>
    @endisset
    @isset($lastProducts)  
    <section class="last_products wrap mt-5">
        <div class="section_title">
            <h3 class="h1 text-center color-main font-weight-bold">Новые товары</h3>
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($lastProducts as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="product_card white_box">
                    <div class="product_card__img">
                        <img  class="img-fluid"
                        @if(isset($product->images) && count($product->images) > 0)
                            src="{{ asset('imgs/products/thumbnails/')}}/{{ $product->main_or_first_image->thumbnail }}"
                            alt="{{ $product->main_or_first_image->alt }}"
                        @else 
                            src="{{ asset('imgs/nopic.png')}}"
                        @endif >
                    </div>                    
                    <div class="product_card__content p10">      
                        <div class="product_card__content__info">
                            <div class="d-flex justify-content-between">
                                @isset($product->category->slug)
                                    <span class="product_card__content__category"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->category ?? '' }}</a></span>
                                @endisset
                                @isset($product->manufacture->slug)
                                    <span class="product_card__content__manufacture"><a href="{{ route('manufacture', $product->manufacture->slug) }}">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                                @endisset
                                
                            </div>
                            {{-- <span class="product_inner_scu">код: {{ $product->autoscu }}</span> --}}
                        </div>
                        @if(isset($product->category->slug))
                            <h2 class="h5"><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h2>
                        @else
                            <h2 class="h5"><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h2>
                        @endif
                        <div class="short_description">{{ $product->short_description ?? '' }}</div>
                        <div class="prices row lg-12 d-flex justify-content-between">
                            <div class=" d-flex">
                                @if(isset($product->discount) && $product->actually_discount)
                                    <div class="old_price">{{ number_format($product->price, 2, ',', ' ') }}</div>
                                    <div class="new_price">
                                    @if ($product->discount->type == '%')
                                        {{ number_format($product->price * $product->discount->numeral, 2, ',', ' ') }} 
                                    @elseif ($product->discount->type == 'rub')
                                        {{ number_format($product->price - $product->discount->value, 2, ',', ' ') }}
                                    @endif
                                    </div>
                                @else
                                    <div class="new_price">
                                        {{ number_format($product->price, 2, ',', ' ') }}
                                        
                                    </div>
                                    
                                @endif
                            </div>
                                @if ($product->packaging)
                                    <div class="unit_buttons">
                                        @isset($product->unit)
                                            <span class="unit_buttons__unit active" data-package="{{$product->unit_in_package ?? ''}}">1 {{ $product->unit->unit }}</span>
                                        @endisset
                                        <span class="unit_buttons__package" data-package="{{$product->unit_in_package ?? ''}}">1 уп.</span>
                                    </div>
                                @endif
                                
                                
                        </div>
                    </div>
                    <div class="product_superiorities">
                        {{-- @isset($product->pay_online)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-green">
                                    <i class="fas fa-credit-card"></i>
                                </span>
                                <span class="product_superiority__right m-green">
                                    Этот товар можно оплатить онлайн
                                </span>
                            </div>
                        @endisset --}}
                        @if($product->actually_discount)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-red">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <span class="product_superiority__right m-red">
                                    Акция до {{ $product->discount->d_m_y }}
                                </span>
                            </div>
                        @endif
                        
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </section>
    @endisset

    @isset($popularProducts)  
    <section class="last_products wrap mt-5">
        <div class="section_title">
            <h3 class="h1 text-center color-main font-weight-bold">Популярные товары</h3>
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($popularProducts as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2">
                <div class="product_card white_box">
                    <div class="product_card__img">
                        <img  class="img-fluid"
                        @if(isset($product->images) && count($product->images) > 0)
                            src="{{ asset('imgs/products/thumbnails/')}}/{{ $product->main_or_first_image->thumbnail }}"
                            alt="{{ $product->main_or_first_image->alt }}"
                        @else 
                            src="{{ asset('imgs/nopic.png')}}"
                        @endif >
                    </div>                    
                    <div class="product_card__content p10">      
                        <div class="product_card__content__info">
                            <div class="d-flex justify-content-between">
                                @isset($product->category->slug)
                                    <span class="product_card__content__category"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->category ?? '' }}</a></span>
                                @endisset
                                @isset($product->manufacture->slug)
                                    <span class="product_card__content__manufacture"><a href="{{ route('manufacture', $product->manufacture->slug) }}">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                                @endisset
                                
                            </div>
                            {{-- <span class="product_inner_scu">код: {{ $product->autoscu }}</span> --}}
                        </div>
                        @if(isset($product->category->slug))
                            <h2 class="h5"><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h2>
                        @else
                            <h2 class="h5"><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h2>
                        @endif
                        <div class="short_description">{{ $product->short_description ?? '' }}</div>
                        <div class="prices row lg-12 d-flex justify-content-between">
                            <div class=" d-flex">
                                @if(isset($product->discount) && $product->actually_discount)
                                    <div class="old_price">{{ number_format($product->price, 2, ',', ' ') }}</div>
                                    <div class="new_price">
                                    @if ($product->discount->type == '%')
                                        {{ number_format($product->price * $product->discount->numeral, 2, ',', ' ') }} 
                                    @elseif ($product->discount->type == 'rub')
                                        {{ number_format($product->price - $product->discount->value, 2, ',', ' ') }}
                                    @endif
                                    </div>
                                @else
                                    <div class="new_price">
                                        {{ number_format($product->price, 2, ',', ' ') }}
                                        
                                    </div>
                                    
                                @endif
                            </div>
                                @if ($product->packaging)
                                    <div class="unit_buttons">
                                        @isset($product->unit)
                                            <span class="unit_buttons__unit active" data-package="{{$product->unit_in_package ?? ''}}">1 {{ $product->unit->unit }}</span>
                                        @endisset
                                        <span class="unit_buttons__package" data-package="{{$product->unit_in_package ?? ''}}">1 уп.</span>
                                    </div>
                                @endif
                                
                                
                        </div>
                    </div>
                    <div class="product_superiorities">
                        {{-- @isset($product->pay_online)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-green">
                                    <i class="fas fa-credit-card"></i>
                                </span>
                                <span class="product_superiority__right m-green">
                                    Этот товар можно оплатить онлайн
                                </span>
                            </div>
                        @endisset --}}
                        @if($product->actually_discount)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-red">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <span class="product_superiority__right m-red">
                                    Акция до {{ $product->discount->d_m_y }}
                                </span>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endisset

    @if (isset($about->main_text))
    <section class="main_about wrap mt-5">
        <h1>{{ $about->site_name }}</h1>
        {!! $about->main_text ?? '' !!}
        <span class="hidding"></span>
        <button class="btn btn-secondary btn-sm">раскрыть...</button>
    </section>        
    @endif   
@endsection