@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot     
    @slot('active') Подборки товаров @endslot
@endcomponent 

    <section class="category_cards row wrap">
    @foreach ($sets as $set)
        <div class="category_card white_box w23per">
            <div class="category_card__img">
                <img  class="img-fluid"
                @if(isset($set->image))
                    src="{{ asset('imgs/sets/')}}/{{ $set->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div> 
            <div class="category_card__title p10">
                <h2 class="h4"><a href="{{ route('set', $set->slug) }}">{{ $set->set }}</a></h2>
            </div>
        </div>
    @endforeach
</section>
      
@endsection