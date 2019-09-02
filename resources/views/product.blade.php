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
    
    <section class="last_products wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <div class="product__images col-lg-4 row">
                    @if (isset($product->images))
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
                        @else
                            @if (count($product->images) == 0)
                                <div class="product__images__one">
                                    <img src="{{ asset('imgs/nopic.png')}}" alt="">
                                </div>
                            @endif                                
                        @endif
                    @else
                        
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    
      
@endsection