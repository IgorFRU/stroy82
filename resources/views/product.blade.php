@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
    хлебные крошки
    {{-- @php
        dd($product->images);
    @endphp --}}
    
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
                </div>
                <div class="col-lg-8">
                    <h1 class="col-lg-12">{{ $product->product }} @isset($product->category->category)  - {{ $product->category->category }} @endisset</h1>
                    <div class="col-lg-12 product__subtitle d-flex justify-content-start">
                        @isset($product->category->slug)
                            <span class="product_card__content__category"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->category ?? '' }}</a></span>
                        @endisset
                         | 
                        @isset($product->manufacture->slug)
                            <span class="product_card__content__manufacture"><a href="{{ route('manufacture', $product->manufacture->slug) }}">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                        @endisset
                    </div>
                    <hr>
                    <div class="properties_prices col-lg-12 row">
                        {{-- @php
                            dd($product->category->property);
                        @endphp --}}
                        @isset($product->category->property)
                        <div class="product__properties col-lg-6">
                            @foreach ($product->category->property as $property)
                                <div class="product__property d-flex justify-content-between">
                                <span class="product__property__title">{{ $property->property }}</span> <span>{{ $propertyvalues[$property->id] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                        @endisset
                        <div class="product__prices col-lg-6">
                            <div class="product__price__value">
                                Цена: @if ($product->actually_discount)
                                <span class="product__prices__old">{{ $product->price_number }}</span><span class="product__prices__new"> {{ $product->discount_price }} </span> за 1 {{ $product->unit->unit ?? '' }}
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    
      
@endsection