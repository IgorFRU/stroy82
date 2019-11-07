@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Статьи @endslot
        @slot('parent_route') {{ route('categories') }} @endslot 
    @isset($category->parents)
        @slot('parent2') {{ $category->parents->category }} @endslot
            @slot('parent2_route') {{ route('category', $category->parents->slug) }} @endslot        
    @endisset
    
    @slot('active') {{ $category->category }} @endslot
@endcomponent 
   <section class="wrap">
        <h1>{{ $category->category }}</h1>
        {!! $category->description !!}
   </section>
    
    
      
@endsection