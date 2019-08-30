@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
    хлебные крошки
   инфа о категории
    
    @isset($products)  
    <section class="last_products wrap">
        <div class="section_title">
                Товары
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($products as $product)
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
                                <span class="product_card__content__category"><a href="{{ route('category', $category->slug) }}">{{ $product->category->category ?? '' }}</a></span>                 
                                <span class="product_card__content__manufacture"><a href="#">{{ $product->manufacture->manufacture ?? '' }}</a></span>             
                            </div>
                            {{-- <span class="product_inner_scu">артикул: {{ $product->autoscu }}</span> --}}
                        </div>
                            
                        <h5><a href="#">{{ Str::limit($product->product, 30, '... ') }}</a></h5>
                        
                        <div class="short_description">{{ $product->short_description ?? '' }}</div>
                        <div class="prices row lg-12 d-flex justify-content-between">
                            <div class=" d-flex">
                                @if(isset($product->discount))
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
    @endisset
    
    
      
@endsection