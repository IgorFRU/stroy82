@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('active') Акции @endslot    
@endcomponent 
<section class="category_cards row wrap">
    @foreach ($sales as $sale)
        <div class="category_card white_box w23per d-flex">
            <div class="discount_sticker p10 @if($sale->it_actuality) bg-blue @else bg-l-grey  @endif"><span>-{{ $sale->value }}{{ $sale->rus_type }}</span></div>
            {{-- <div class="category_card__img">
                
                <img  class="img-fluid"
                @if(isset($sale->image))
                    src="{{ asset('imgs/sales/')}}/{{ $sale->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div>  --}}
                <div class="category_card__title p10">
                    <h4><a href="{{ route('sale', $sale->slug) }}">{{ $sale->discount }} {{ $sale->value }}{{ $sale->rus_type }}</a></h4>
                    <div class="card_info @if($sale->it_actuality) color-green  @endif">{{ $sale->start_d_m_y }} - {{ $sale->d_m_y }} @if(!$sale->it_actuality) <br>(акция закончилась!) @endif</div>
                    <p>{{ $sale->description ?? '' }}</p>
                </div>
                
        </div>
    @endforeach
</section>
    
    
      
@endsection