@extends('layouts.main-app')
@section('scripts')
    @parent
    <script src="{{ asset('js/discount_countdown.js') }}" defer></script>
@endsection
@section('content')
    <div class="header wrap d-flex justify-content-between">
        <div class="header_banners col-lg-9">
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
        </div>
        @isset($articles)
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
                        <a href="#">далее...</a>
                    </div>
                </div>
            @endforeach
        </div>
        @endisset            
    </div>
    <section class="sales_products wrap row d-flex col-lg-12">
        @isset($discounts)
        @php
            $count = 0;
        @endphp
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
                                    <a href="#">{{ $product->product }}</a>                                    
                                </h4>
                                <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span>
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
                                    @endif <span><i class="fas fa-ruble-sign"></i></span>
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
        @endisset
        
    </section>

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
                        <h5><a href="#">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
                        <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span>
                        <div>{{ $product->short_description ?? '' }}</div>
                        <div class="prices row col lg-12">
                            
                                @if(isset($product->discount))
                                    <div class="old_price">{{ $product->price }}</div>
                                    <div class="new_price col-lg-6">
                                    @if ($product->discount->type == '%')
                                        {{ number_format($product->price * $product->discount->numeral, 2, ',', ' ') }}
                                    @elseif ($product->discount->type == 'rub')
                                        {{ number_format($product->price - $product->discount->value, 2, ',', ' ') }}
                                    @endif
                                        <span><i class="fas fa-ruble-sign"></i></span>
                                    </div>
                                @else
                                    <div class="new_price">
                                        {{ $product->price }}
                                        <span><i class="fas fa-ruble-sign"></i></span>
                                        <span class="units"></span>
                                    </div>
                                @endif
                                
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endisset
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
                            <h4>{{ $category->category }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endisset
    
      
@endsection