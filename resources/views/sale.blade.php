@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Акции @endslot
        @slot('parent_route') {{ route('sales') }} @endslot   
    @slot('active') {{ $sale->discount }} {{ $sale->value }}{{ $sale->type }} @endslot    
@endcomponent 
<section class="category_cards row wrap">
    
        <div class="category_card white_box w23per">
            <div class="category_card__img">
                <img  class="img-fluid"
                @if(isset($sale->image))
                    src="{{ asset('imgs/sales/')}}/{{ $sale->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div> 
            <div class="category_card__title p10">
                <h4><a href="{{ route('sale', $sale->slug) }}">{{ $sale->discount }} {{ $sale->value }}{{ $sale->type }}</a></h4>
                <div class="card_info @if($sale->it_actuality) color-green  @endif">{{ $sale->start_d_m_y }} - {{ $sale->d_m_y }}</div>
                <p>{{ $sale->description ?? '' }}</p>
            </div>
        </div>
</section>
    
    
      
@endsection