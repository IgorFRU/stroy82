@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot     
    @slot('active') Категории товаров @endslot
@endcomponent 

    <section class="category_cards row wrap">
    @foreach ($categories as $category)
        <div class="col-12 col-sm-6 col-md-4 p-1">
            <div class="category_card white_box">
                <div class="category_card__img">
                    <img  class="img-fluid"
                    @if(isset($category->image))
                        src="{{ asset('imgs/categories/')}}/{{ $category->image }}"
                    @else 
                        src="{{ asset('imgs/nopic.png')}}"
                    @endif >
                </div> 
                <div class="category_card__title p10">
                    <h2 class="h4"><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></h2>
                </div>
            </div>
        </div>
    @endforeach
</section>
      
@endsection