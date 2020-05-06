@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')

{{-- @php
    dd($category->parents);
@endphp --}}
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot    
    @slot('active') Результаты поиска @endslot
@endcomponent  
    <section class="last_products wrap row">
        {{-- <div class="col-lg-3 p-0 fix-to-top-parent">
            <div class="fix-to-top">
                @include('components.categoriesbar', ['min_price' =>$products->min('price')])
                @if (isset($products) && count($products) > 0 && isset($category->property) && count($category->property) > 0)
                    @include('components.propertiesbar', ['min_price' =>$products->min('price'), 'category_properties' => $category->property, 'properties' => $properties, 'manufactures' => $manufactures, 'filteredManufacture' => $filteredManufacture ])
                @else
                    
                @endif
            </div>
        </div> --}}
        
        <div class="col-lg-12">    
            <h1>Товары</h1>    
            <div class="product_cards col-lg-12 row mb-4">
                
                @forelse ($products as $product)
                    <div class="col-lg-3">
                        <div class="product_card white_box mb-4">
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

                                {{-- {{ $product->property_active_product }} --}}
                                
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
                                                @isset($product->unit)<span class="unit_buttons__unit active" data-package="{{$product->unit_in_package ?? ''}}">1 {{ $product->unit->unit }}</span>@endisset <span class="unit_buttons__package" data-package="{{$product->unit_in_package ?? ''}}" title="{{$product->unit_in_package ?? ''}} {{ $product->unit->unit ?? '' }}">1 уп.</span>
                                            </div>
                                        @endif
                                        
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    Товаров по вашему запросу не найдено
                @endforelse
            </div>
            <h1>Категории</h1>
            <div class="col-lg-12 row mb-4">                
                @forelse ($categories as $category)
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
                            <h2 class="h4"><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></h2>
                        </div>
                    </div>
                @empty
                    Категорий по вашему запросу не найдено
                @endforelse
            </div>
            <h1>Производители</h1>
            <div class="col-lg-12 row mb-4">                
                @forelse ($manufactures as $manufacture)
                    <div class="category_card white_box w23per">                        
                        <div class="category_card__title p10">
                            <h2 class="h4"><a href="{{ route('manufacture', $manufacture->slug) }}">{{ $manufacture->manufacture }}</a></h2>
                        </div>
                    </div>
                @empty
                    Призводителей по вашему запросу не найдено
                @endforelse
            </div>
        </div>
    </section>
    {{-- @else 
        <div class="wrap">
            В данной категории нет товаров
        </div>
    @endif --}}

    
    
    
    
    
      
@endsection