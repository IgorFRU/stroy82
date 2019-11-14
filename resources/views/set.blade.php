@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Подборки товаров @endslot
        @slot('parent_route') {{ route('sets') }} @endslot    
    @slot('active') {{ $set->set }} @endslot
@endcomponent 
   <section class="wrap">
        <h1>{{ $set->set }}</h1>
        {!! $set->description !!}
   </section>
    
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
    @else 
    В данной подборке нет товаров
    @endisset
    
    
      
@endsection