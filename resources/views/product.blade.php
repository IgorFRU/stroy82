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
                                @if (isset($property->property) && isset($propertyvalues[$property->id]))
                                    <div class="product__property d-flex justify-content-between">
                                        <span class="product__property__title">{{ $property->property }}</span> <span>{{ $propertyvalues[$property->id] ?? '' }}</span>
                                    </div>
                                @endif
                                
                            @endforeach
                            <p>{{ $product->short_description ?? '' }}</p>
                        </div>

                        
                        @endisset
                        <div class="product__prices col-lg-6">
                            <div class="product__price__value">
                                Цена: @if ($product->actually_discount)
                                @php
                                    $new_price_unit = $product->discount_price;
                                @endphp
                                    <span class="product__prices__old">{{ $product->price_number }}</span><span class="product__prices__new new_price"> {{ number_format($new_price_unit, 2, ',', ' ') }} </span>
                                @else
                                    <span class="product__prices__new  new_price"> {{ $product->price_number }} </span>
                                @endif
                                за 1 {{ $product->unit->unit ?? '' }}
                            </div>
                            {{-- @php
                            dd($product->price);
                        @endphp --}}
                            @isset($product->packaging)
                            <div class="product__price__value__package">
                                Цена: @if ($product->actually_discount)
                                    <span class="product__prices__old">{{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }}</span><span class="product__prices__new new_price"> {{ number_format($product->discount_price * $product->unit_in_package, 2, ',', ' ') }} </span>
                                @else
                                    <span class="product__prices__new  new_price"> {{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }} </span>
                                @endif
                                за 1 уп. ({{ $product->unit_number ?? '' }} {{ $product->unit->unit ?? '' }})
                            </div>   
                            @endisset
                            <div class="product__input_units">
                                Кол-во {{ $product->unit->unit ?? '' }}:
                                <span class="product__input_units_minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                                <input type="text" name="product__input_units" id="product__input_units" data-package="{{ $product->unit_in_package ?? '' }}" value="@if ($product->packaging && isset($product->unit_in_package)){{ number_format($product->unit_in_package, 3, ',', ' ') }}@else 1 @endif"> 
                                <span class="product__input_units_plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                                 (упаковок: <span class="count_package">1</span>)
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    
      
@endsection