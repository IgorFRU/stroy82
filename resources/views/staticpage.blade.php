@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')

{{-- @php
    dd($category->parents);
@endphp --}}
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('active') {{ $staticpage->title }} @endslot
@endcomponent 
   <section class="wrap">
        <h1>{{ $staticpage->title }}</h1>
        <article>
            {!! $staticpage->text !!}
        </article>
   </section>
   
      
@endsection