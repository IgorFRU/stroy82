@extends('layouts.main-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/discount_countdown.js') }}" defer></script>
@endsection
@section('content')
    <div class="header wrap row">
        @if (count($banners) > 0)
            <div class="col-lg-6">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($banners as $item)
                            <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->iteration-1 }}" class="@if($loop->iteration == 1) active @endif"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner mainpage-banners">
                        @foreach ($banners as $banner)
                            <div class="carousel-item @if($loop->iteration == 1) active @endif">
                                <img src="{{ asset('imgs/banners/')}}/{{ $banner->image }}" class="d-block w-100" alt="{{ $banner->title ?? '' }}">
                                <div class="carousel-caption d-none d-md-block">
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
            </div>
            <div class="col-lg-6 mainpage-banners">
                @forelse ($discounts as $discount)
                <div class="col">
                    <div class="category_card white_box d-flex">
                        <div class="discount_sticker p10 bg-blue">
                            <span>-{{ $discount->value }}{{ $discount->rus_type }}</span>
                        </div> 
                        <div class="category_card__title p10">
                            <h4><a href="{{ route('sale', $discount->slug) }}">{{ $discount->discount }} {{ $discount->value }}{{ $discount->rus_type }}</a></h4>
                            <div class="card_info @if($discount->it_actuality) color-green  @endif">{{ $discount->start_d_m_y }} - {{ $discount->d_m_y }} @if(!$discount->it_actuality) <br>(акция закончилась!) @endif</div>
                            <p>{{ $discount->description ?? '' }}</p>
                        </div>                        
                    </div>
                </div>
                @empty
                    
                @endforelse
            </div>
        @endif
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
        <div class="superiorities col-lg-12 d-flex justify-content-between mt-5 mb-4">
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
    </div>
    @if (count($articles)> 0)
        <section class="mb-5 wrap">
            <div class="section_title">
                Последние статьи
            </div>
            <div class="card-group">
                @forelse ($articles as $article)
                    <div class="col-lg-3">
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
    

    <section class="sales_products wrap">
        @isset($discounts)
        <div class="section_title">
            Успейте купить
        </div>
        @php
            $count = 0;
        @endphp
        <div class=" row d-flex col-lg-12">
            @foreach ($discounts as $discount)        
                {{-- после третьей итерации выходим из цикла     --}}
                @break($count == 2)
                @foreach ($discount->product as $product)
                    @break($count == 2)
                    @php $count++; @endphp
                    <div class="sale_product white_box p10 w47per d-flex justify-content-lg-start">
                        <div class="sale_product__img col-lg-5">
                            <img  class="img-fluid" 
                            @if(isset($product->images) && count($product->images) > 0)
                                src="{{ asset('imgs/products/thumbnails/')}}/{{ $product->main_or_first_image->thumbnail }}"
                                alt="{{ $product->main_or_first_image->alt }}"
                            @else 
                                src="{{ asset('imgs/nopic.png')}}"
                            @endif >
                        </div>
                        <div class="sale_product__info col-lg-7">
                            <div class="row col-lg-12">
                                <h4>
                                    @if(isset($product->category->slug))
                                        <a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a>
                                    @else
                                        <a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a>
                                    @endif                                   
                                </h4>
                                <div class="product_inner_scu row col-lg-12">артикул: {{ $product->autoscu }}</div>
                                <div class="product_short_description row col-lg-12">
                                    @isset($product->short_description)
                                        {{ $product->short_description }}
                                    @endisset
                                </div>                                
                            </div>
                            <div class="prices row col lg-12">
                                <div class="old_price">{{ $product->price }}</div>
                                <div class="new_price col-lg-6">
                                    @if ($product->discount->type == '%')
                                        {{ number_format($product->price * $product->discount->numeral, 2, ',', ' ') }}
                                    @elseif ($product->discount->type == 'rub')
                                        {{ number_format($product->price - $product->discount->value, 2, ',', ' ') }}
                                    @endif <span><i class="fas fa-ruble-sign"></i>@isset($product->unit) за 1 {{ $product->unit->unit }} @endisset</span>
                                </div>
                            </div>
                            <div id="countdown-{{ $product->id }}" class="sale_product__count d-flex" data-id={{ $product->id }} data-discount="{{ $product->discount->discount_end }}">
                                
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
                @endforeach
                
            @endforeach
        </div>
        @endisset
        
    </section>
    @isset($categories)
    <section class="categories wrap">
        <div class="section_title">
                Категории товаров
        </div>
        <div class="category_cards col-lg-12 row">
            @foreach ($categories as $category)
                <div class="category_card white_box w23per">
                    <div class="category_card__img">
                        <img  class="img-fluid"
                        @if(isset($category->image))
                            src="{{ asset('imgs/categories/')}}/{{ $category->image }}"
                        @else 
                            src="{{ asset('imgs/nopic.png')}}"
                        @endif >
                    </div> 
                    <div class="category_card__title p10">
                        <h4><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></h4>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endisset
    @isset($lastProducts)  
    <section class="last_products wrap">
        <div class="section_title">
                Последние поступления
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($lastProducts as $product)
                <div class="product_card white_box w23per">
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
                            {{-- <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span> --}}
                        </div>
                        @if(isset($product->category->slug))
                            <h5><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
                        @else
                            <h5><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
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
                        @isset($product->pay_online)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-green">
                                    <i class="fas fa-credit-card"></i>
                                </span>
                                <span class="product_superiority__right m-green">
                                    Этот товар можно оплатить онлайн
                                </span>
                            </div>
                        @endisset
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
            @endforeach
        </div>
    </section>
    @endisset

    @isset($popularProducts)  
    <section class="last_products wrap">
        <div class="section_title">
            Популярные товары
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($popularProducts as $product)
                <div class="product_card white_box w23per">
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
                            {{-- <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span> --}}
                        </div>
                        @if(isset($product->category->slug))
                            <h5><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
                        @else
                            <h5><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
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
                        @isset($product->pay_online)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-green">
                                    <i class="fas fa-credit-card"></i>
                                </span>
                                <span class="product_superiority__right m-green">
                                    Этот товар можно оплатить онлайн
                                </span>
                            </div>
                        @endisset
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
            @endforeach
        </div>
    </section>
    @endisset

    @if (isset($about->main_text))
    <section class="main_about wrap">
        {!! $about->main_text ?? '' !!}
        <span class="hidding"></span>
        <button class="btn btn-secondary btn-sm">раскрыть...</button>
    </section>        
    @endif   
@endsection