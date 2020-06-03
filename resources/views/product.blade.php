@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" defer></script>
@endsection
@section('styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
@endsection
@section('content')
    
{{-- {{ Breadcrumbs::render('product', $product->category->slug, $product) }} --}}
    {{-- @php
        dd($product->images);
    @endphp --}}
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
        @slot('parent') Каталог товаров @endslot
            @slot('parent_route') {{ route('categories') }} @endslot 
        @isset($product->category)
            @slot('parent2') {{ $product->category->category }} @endslot
                @slot('parent2_route') {{ route('category', $product->category->slug) }} @endslot        
        @endisset 
        
        @slot('active') {{ $product->product }} @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <h1 class="col-lg-12 color-main p-3 font-weight-bold">{{ $product->product }} @isset($product->scu) (арт.: {{$product->scu}}) @endisset @isset($product->category->category)  - {{ $product->category->category }} @endisset @isset($product->manufacture->manufacture)  {{ $product->manufacture->manufacture }} @endisset</h1>
                <div class="w-100 product__subtitle d-flex justify-content-start flex-wrap mb-4">
                    @isset($product->autoscu)
                        <span class="product_card__content__scu mr-0 mr-md-4 mb-2 mb-md-0">код: {{ $product->autoscu ?? '' }}</span>
                    @endisset
                    @isset($product->category->slug)
                        <span class="product_card__content__category"> <a href="{{ route('category', $product->category->slug) }}">{{ $product->category->category ?? '' }}</a></span>
                    @endisset
                    @isset($product->manufacture->slug)
                        <span class="product_card__content__manufacture mr-2">| производитель: <a href="{{ route('manufacture', $product->manufacture->slug) }}">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                    @endisset
                </div>                
                <div class="product__images col-sm-6 col-12 row">                   
                    @forelse ($product->images as $image)
                        <a href="{{ asset('imgs/products')}}/{{ $image->image}}" data-toggle="lightbox" data-gallery="product-gallery" class="@if (count($product->images) == 1) col-sm-12 @elseif(count($product->images) == 2) col-sm-6 @else col-sm-4 @endif mb-1 product_add_image">
                            <img src="{{ asset('imgs/products/thumbnails')}}/{{ $image->thumbnail}}" class="img-fluid"  alt="{{ $image->alt ?? $product->product }}">
                        </a>
                    @empty
                        <img src="{{ asset('imgs/nopic.png')}}" alt="{{ $product->product }}">
                    @endforelse
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
                        {{-- @if($product->actually_discount)
                            <div class="product_superiority">
                                <span class="product_superiority__left l-red">
                                    <i class="fas fa-percentage"></i>
                                </span>
                                <span class="product_superiority__right m-red">
                                    Акция до {{ $product->discount->d_m_y }}
                                </span>
                            </div>
                            <div class="product_superiority">
                                <span class="badge badge-danger font-weight-light p-2">Акция до {{ $product->discount->d_m_y }}</span>
                            </div>
                        @endif --}}
                        
                    </div>
                </div>
                <div class="col-sm-6 col-12">  
                    @if($product->actually_discount)
                            <span class="badge badge-danger font-weight-light p-2 mb-2">Акция до {{ $product->discount->d_m_y }}</span>
                        @endif                   
                    <div class="product__price__value mb-4 mt-4 mt-md-0">
                        
                        Цена: @if ($product->actually_discount)
                        @php
                            $new_price_unit = $product->discount_price;
                        @endphp
                            <span class="product__prices__old">{{ $product->price_number }}</span><span id="price" class="product__prices__new new_price"> {{ number_format($new_price_unit, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                        @else
                            <span id="price" class="product__prices__new  new_price"> {{ $product->price_number }} </span><i class="fas fa-ruble-sign"></i>
                        @endif
                        за 1 {{ $product->unit->unit ?? 'ед.' }}
                    </div>
                    {{-- @php
                    dd($product->price);
                @endphp --}}
                    @if($product->packaging)
                        <div class="text-info mb-4">
                            <i class="fas fa-info-circle"></i> Данный товар продаётся только целыми упаковками по {{ $product->unit_in_package ?? 1 }} {{ $product->unit->unit ?? 'ед.' }}
                        </div>
                    {{-- <div class="product__price__value__package">
                        Цена: @if ($product->actually_discount)
                            <span class="product__prices__old">{{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }}</span><span class="product__prices__new new_price"> {{ number_format($product->discount_price * $product->unit_in_package, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                        @else
                            <span class="product__prices__new  new_price"> {{ number_format($product->price * $product->unit_in_package, 2, ',', ' ') }} </span><i class="fas fa-ruble-sign"></i>
                        @endif
                        за 1 уп. ({{ $product->unit_number ?? '' }} {{ $product->unit->unit ?? '' }})
                    </div>    --}}
                    @endif
                    <div class="product__input_units">
                        Кол-во {{ $product->unit->unit ?? 'ед.' }}:
                        <span class="product__input_units_minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
                        <input type="text" name="product__input_units" id="product__input_units" data-package="{{ $product->unit_in_package ?? 1 }}" value="@if ($product->packaging && isset($product->unit_in_package)){{ number_format($product->unit_in_package, 3, ',', '') }}@else 1 @endif"> 
                        <span class="product__input_units_plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                            (упаковок: <span class="count_package">1</span>)
                    </div>
                    <div class="product__result_price">
                        <span>Итого: </span>
                        <div></div>
                        <i class="fas fa-ruble-sign"></i>
                        <span class='to_cart btn btn-primary' data-product="{{ $product->id }}"><i class="fas fa-shopping-cart"></i> купить</span>
                    </div>
                </div>
                
            </div>
            @isset($product->description)
            <hr>
            <div class="col-lg-12 row">
                <div class="product__properties color_l_grey col-lg-4">
                    <div class="mb-lg-3">                            
                        @isset($product->delivery_time)
                            <span class="italic" style="display: block;"><i class="far fa-calendar-alt"></i> срок поставки: {{ $product->delivery_time }}</span>
                        @endisset
                        @if ($product->full_size != '')
                            <span class="italic" style="display: block;"><i class="fas fa-ruler-combined"></i> {{ $product->full_size }}</span>
                        @endif
                        @if ($product->mass != '')
                            <span class="italic" style="display: block;"><i class="fas fa-weight"></i> масса: {{ $product->mass_number }} кг. @if (isset($product->unit->unit)) (1 {{ $product->unit->unit }}) @endif </span>
                        @endif
                    </div>
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
                <div class="col-lg-8">
                    <h2 class="h4 mb-3">Описание {{ $product->product }}</h2>
                    {!! $product->description ?? '' !!}
                </div>
                
            </div>
            @endisset
            
        </div>
    </section>
    
    
      
@endsection