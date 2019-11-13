@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('active') Производители @endslot
@endcomponent 

<section class="category_cards row wrap">
    @foreach ($manufactures as $manufacture)
        <div class="category_card white_box w23per">
            <div class="category_card__img">
                <img  class="img-fluid"
                @if(isset($manufacture->image))
                    src="{{ asset('imgs/manufactures/')}}/{{ $manufacture->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div> 
            <div class="category_card__title p10">
                <h4><a href="{{ route('manufacture', $manufacture->slug) }}">{{ $manufacture->manufacture }}</a></h4>
            </div>
        </div>
    @endforeach
</section>
      
@endsection