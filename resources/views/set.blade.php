@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
    хлебные крошки
   инфа о подборке
    
    @isset($set->products)  
    <section class="wrap">
        <div class="section_title">
                Товары
        </div>
        <div class="product_cards col-lg-12 row">
            @foreach ($set->products as $product)
            @include('layouts.products')
                
            @endforeach
        </div>
    </section>
    @endisset
    
    
      
@endsection