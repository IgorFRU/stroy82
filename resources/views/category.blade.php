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
    @slot('parent') Каталог товаров @endslot
        @slot('parent_route') {{ route('categories') }} @endslot 
    @isset($category->parents)
        @slot('parent2') {{ $category->parents->category }} @endslot
            @slot('parent2_route') {{ route('category', $category->parents->slug) }} @endslot        
    @endisset
    
    @slot('active') {{ $category->category }} @endslot
@endcomponent 
   <section>
        <h1 class="wrap">{{ $category->category }}</h1>        
   </section>
   @if(count($category->children) > 0)
      <section class="category_cards row wrap">
    @foreach ($category->children as $subcategory)
        <div class="category_card white_box w23per">
            <div class="category_card__img">
                <img  class="img-fluid"
                @if(isset($subcategory->image))
                    src="{{ asset('imgs/categories/')}}/{{ $subcategory->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div> 
            <div class="category_card__title p10">
                <h4><a href="{{ route('category', $subcategory->slug) }}">{{ $subcategory->category }}</a></h4>
            </div>
        </div>
    @endforeach
    </section> 
   @endif
    
    
   {{-- @if(isset($products) && count($products) > 0) --}}
    <section class="last_products wrap row">
        <div class="col-lg-3 p-0 fix-to-top-parent">
            <div class="fix-to-top">
                @include('components.categoriesbar', ['min_price' =>$products->min('price')])
                @if (isset($products) && count($products) > 0 && isset($category->property) && count($category->property) > 0)
                    
                        {{-- @component('components.propertiesbar')
                            @slot('min_price') {{ $products->min('price') }}
                        @endcomponent --}}
                @include('components.propertiesbar', ['min_price' =>$products->min('price'), 'category_properties' => $category->property, 'properties' => $properties, 'manufactures' => $manufactures ])
                    
                @else
                    
                @endif
            </div>
        </div>
        
        <div class="col-lg-9">
        @if(isset($products) && count($products) > 0)
            <div class="col-lg-12 row product_sort_bar mb-2 d-flex justify-content-end">
                <div class="form-group row col-lg-4">
                    <label for="products_sort" class="col-lg-4">Сортировать</label>
                    <div class="col-md-8">
                        <select class="form-control custom-select custom-select-sm product_sort_bar__select" id="products_sort" data-cookie='products_sort'>
                            {{-- <option value="discount">Сначала со скидкой</option> --}}
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'nameAZ') selected='selected' @endif value="nameAZ">По алфавиту (А-Я)</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'nameZA') selected='selected' @endif value="nameZA">По алфавиту (Я-А)</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'price_up') selected='selected' @endif value="price_up">От дорогих к дешёвым</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'price_down') selected='selected' @endif value="price_down">От дешёвых к дорогим</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'popular') selected='selected' @endif value="popular">По популярности</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'new_up') selected='selected' @endif value="new_up">Сначала новые</option>
                            <option @if (isset($_COOKIE['product_sort']) && $_COOKIE['product_sort'] == 'new_down') selected='selected' @endif value="new_down">Сначала старые</option>
                        </select>
                    </div> 
                </div>
                <div class="form-group col col-lg-4 d-flex justify-content-end">
                    <label for="products_per_page" class="mr-1">Товаров на странице</label>
                    <div class="">
                        <select class="form-control custom-select custom-select-sm product_sort_bar__select" id="products_per_page" data-cookie='products_per_page'>
                            <option @if (isset($_COOKIE['products_per_page']) && $_COOKIE['products_per_page'] == '24') selected='selected' @endif value="24">24</option>
                            <option @if (isset($_COOKIE['products_per_page']) && $_COOKIE['products_per_page'] == '48' || !isset($_COOKIE['products_per_page'])) selected='selected' @endif value="48">48</option>
                            <option @if (isset($_COOKIE['products_per_page']) && $_COOKIE['products_per_page'] == '96') selected='selected' @endif value="96">96</option>
                        </select>
                    </div> 
                </div> 
            </div>
        @endif
        
            <div class="product_cards col-lg-12 row">
                @forelse ($products_filtered as $product)
                    {{-- @if (isset($checked_properties) && $product->property_active_product($checked_properties) ) --}}
                        {{-- <div class="product_card white_box w23per"> --}}
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
                                        {{-- <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span> --}}
                                    </div>
                                        
                                    @if(isset($product->category->slug))
                                        <h5><a href="{{ route('product', ['category' => $product->category->slug, 'product' => $product->slug]) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
                                    @else
                                        <h5><a href="{{ route('product.without_category', $product->slug) }}">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
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

                    {{-- @endif --}}
                @empty
                    В данной категории нет товаров
                @endforelse
            </div>
            <div class="paginate">
                {{ $products->appends(request()->input())->links('layouts.pagination') }}
            </div>
        </div>
    </section>
    {{-- @else 
        <div class="wrap">
            В данной категории нет товаров
        </div>
    @endif --}}

    
    
    
    <div class="wrap">{!! $category->description !!}</div>
    
      
@endsection