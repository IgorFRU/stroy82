@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('parent') Корзина @endslot
        @slot('parent_route') {{ route('cart') }} @endslot 
               
        @slot('active') Оформление заказа @endslot
    @endcomponent 
    
    
    
    <section class="product wrap">
        <div class="white_box p10">
            <div class="col-lg-12 row">
                <div class="bg-success color-white p10">
                    Заказ <a href="{{ route('orderShow', $number) }}">№{{ $number }}</a> успешно сформирован. Если у нас появятся вопросы, мы скоро с Вами свяжемся.
                </div>
            </div>
        </div>
    </section>
    
    
      
@endsection