@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Статьи @endslot
        @slot('parent_route') {{ route('articles') }} @endslot     
    @slot('active') {{ $article->article }} @endslot
@endcomponent 
   <section class="wrap">
        <h1>{{ $article->article }}</h1>
        {!! $article->description !!}
        @if(count($article->products) > 0)
        <section class="last_products">
            <div class="section_title">
                    Товары из статьи
            </div>
            <div class="product_cards col-lg-12 row">
                @foreach ($article->products as $product)
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
                    </div>
                @endforeach
            </div>
        </section>
        @endif
   </section>
    
    
      
@endsection