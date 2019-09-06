@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
{{-- {{ Breadcrumbs::render('product', $product->category->slug, $product) }} --}}
    {{-- @php
        dd($product->images);
    @endphp --}}
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
        @slot('parent') Категории товаров @endslot
            @slot('parent_route') {{ route('categories') }} @endslot  
        @slot('parent2') {{ $product->category->category }} @endslot
            @slot('parent2_route') {{ route('category', $product->category->slug) }} @endslot        
        @slot('active') {{ $product->product }} @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <div class="product__images col-lg-4 row">
                    @if (isset($product->images))
                    {{-- @php
                        dd($product->images);
                    @endphp --}}
                        @if (count($product->images) > 1)
                            <div class="product__images__many">
                                <div class="main_product_image">
                                    @foreach ($product->images as $image)
                                        @php
                                            $main_img = 0;
                                        @endphp
                                        @if ($image->main)
                                        @php $main_img = 1; @endphp
                                            <img src="{{ asset('imgs/products/thumbnails')}}/{{ $image->thumbnail}}" alt="{{ $image->alt ?? '' }}">
                                        @endif
                                    @endforeach
                                    @if ($main_img == 0)
                                        <img src="{{ asset('imgs/products/thumbnails')}}/{{ $product->images['0']->thumbnail}}" alt="{{ $product->images['0']->alt ?? '' }}">
                                    @endif
                                </div>
                                <div class="images__container">
                                    @if (count($product->images) > 4)
                                        <span class="up">&uarr;</span>
                                        <span class="down">&darr;</span>
                                    @endif
                                    <div class="column">
                                        @forelse ($product->images as $image)
                                        <div class="images__container__item">
                                            <img @if($image->main) class="main" @elseif($main_img == 0 && $loop->first) class="main" @endif src="{{ asset('imgs/products/thumbnails')}}/{{ $image->thumbnail}}" alt="{{ $image->alt ?? '' }}">
                                        </div>                                        
                                        @empty
                                            
                                        @endforelse
                                    </div>
                                    
                                </div>
                            </div>
                        @elseif (count($product->images) == 0)
                            <div class="product__images__one">
                                <img src="{{ asset('imgs/nopic.png')}}" alt="">
                            </div>
                        @else
                            <div class="product__images__one">
                                <img src="{{ asset('imgs/products/thumbnails')}}/{{ $product->images['0']->thumbnail}}" alt="{{ $product->images['0']->alt ?? '' }}">
                            </div>                    
                        @endif
                    @else
                        
                    @endif
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
                <div class="col-lg-8">
                    <h1 class="col-lg-12">{{ $product->product }} @isset($product->category->category)  - {{ $product->category->category }} @endisset @isset($product->manufacture->manufacture)  {{ $product->manufacture->manufacture }} @endisset</h1>
                    <div class="col-lg-12 product__subtitle d-flex justify-content-start">
                        @isset($product->autoscu)
                            <span class="product_card__content__category">внутренний артикул: {{ $product->autoscu ?? '' }}</span>
                        @endisset
                        @isset($product->category->slug)
                            <span class="product_card__content__category"> | <a href="{{ route('category', $product->category->slug) }}">{{ $product->category->category ?? '' }}</a></span>
                        @endisset
                        @isset($product->manufacture->slug)
                            <span class="product_card__content__manufacture"> | <a href="{{ route('manufacture', $product->manufacture->slug) }}">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                        @endisset
                    </div>
                    <hr>
                    <div class="properties_prices col-lg-12 row">
                        {{-- @php
                            dd($product->category->property);
                        @endphp --}}
                        
                        
                        
                        {{-- @php
                            dd($product->category->property)
                        @endphp --}}
                        <div class="product__properties color_l_grey col-lg-5">
                        @isset($product->delivery_time)
                            <div class="italic" style="display: block;"><i class="far fa-calendar-alt"></i> срок поставки: {{ $product->delivery_time }}</div>
                        @endisset
                        @isset($product->category->property)
                        <div>
                            @foreach ($product->category->property as $property)
                                @if (isset($property->property) && isset($propertyvalues[$property->id]))
                                    <div class="product__property d-flex justify-content-between">
                                        <span class="product__property__title">{{ $property->property }}</span> <span>{{ $propertyvalues[$property->id] ?? '' }}</span>
                                    </div>
                                @endif
                                
                            @endforeach
                            </div>
                            @endisset
                            <p>{{ $product->short_description ?? '' }}</p>
                        </div>

                        
                        
                        <div class="product__prices col-lg-7">
                            <div class="product__price__value">
                                Цена: @if ($product->actually_discount)
                                @php
                                    $new_price_unit = $product->discount_price;
                                @endphp
                                    <span class="product__prices__old">{{ $product->price_number }}</span><span id="price" class="product__prices__new new_price"> {{ number_format($new_price_unit, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                                @else
                                    <span id="price" class="product__prices__new  new_price"> {{ $product->price_number }} </span><i class="fas fa-ruble-sign"></i>
                                @endif
                                за 1 {{ $product->unit->unit ?? '' }}
                            </div>
                            {{-- @php
                            dd($product->price);
                        @endphp --}}
                            @isset($product->packaging)
                            <div class="product__price__value__package">
                                Цена: @if ($product->actually_discount)
                                    <span class="product__prices__old">{{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }}</span><span class="product__prices__new new_price"> {{ number_format($product->discount_price * $product->unit_in_package, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                                @else
                                    <span class="product__prices__new  new_price"> {{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                                @endif
                                за 1 уп. ({{ $product->unit_number ?? '' }} {{ $product->unit->unit ?? '' }})
                            </div>   
                            @endisset
                            <div class="product__input_units">
                                Кол-во {{ $product->unit->unit ?? '' }}:
                                <span class="product__input_units_minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                <input type="text" name="product__input_units" id="product__input_units" data-package="{{ $product->unit_in_package ?? '' }}" value="@if ($product->packaging && isset($product->unit_in_package)){{ number_format($product->unit_in_package, 3, ',', '') }}@else 1 @endif"> 
                                <span class="product__input_units_plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                                 (упаковок: <span class="count_package">1</span>)
                            </div>
                            <div class="product__result_price">
                                <span>Итого: </span>
                                <div></div>
                                <i class="fas fa-ruble-sign"></i>
                                <span class='to_cart btn btn-primary'><i class="fas fa-shopping-cart"></i> купить</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            @isset($product->description)
            <hr>
            <div class="col-lg-12">
                {!! $product->description ?? '' !!}
            </div>
            @endisset
            
        </div>
        <div class="hidden_inputs">
            <input type="text" name="product_id" id="product_id" readonly value="{{ $product->id }}">
            @if (Auth::check())
                <input type="text" name="user_id" id="user_id" readonly value="{{ Auth::id() }}">
            @endif
        </div>
    </section>
    
    
      
@endsection