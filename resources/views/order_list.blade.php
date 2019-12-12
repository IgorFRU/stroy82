@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Личный кабинет @endslot
        @slot('parent_route') {{ route('home') }} @endslot 
               
        @slot('active') Заказы @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                @forelse ($orders as $order)
                <div class="col-lg-12"><a href="{{ route('usersOrder', $order->number) }}">{{ $order->number }}</a></div>
                @empty
                    
                @endforelse
                
            </div>
        </div>
    </section>
    
    
      
@endsection