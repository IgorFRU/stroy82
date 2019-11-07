@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('active') Статьи @endslot    
@endcomponent 
<section class="category_cards row wrap">
    @foreach ($articles as $article)
        <div class="category_card white_box w23per">
            <div class="category_card__img">
                <img  class="img-fluid"
                @if(isset($article->image))
                    src="{{ asset('imgs/articles/')}}/{{ $article->image }}"
                @else 
                    src="{{ asset('imgs/nopic.png')}}"
                @endif >
            </div> 
            <div class="category_card__title p10">
                <h4><a href="{{ route('article', $article->slug) }}">{{ $article->article }}</a></h4>
            </div>
        </div>
    @endforeach
</section>
    
    
      
@endsection