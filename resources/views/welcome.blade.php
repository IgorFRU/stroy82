@extends('layouts.main-app')

@section('content')
    <div class="header wrap d-flex justify-content-between">
        <div class="header_banners col-lg-9">
            <div class="header_banner">
                <img src="{{ asset('imgs/banners/i8.jpg') }}" alt="" class="img-fluid">
                <div class="header_banner__control">
                    <div class="">
                        <h3>
                            <a href="#">Скидка 30% на кирпич облицовочный</a>                                
                        </h3>                            
                    </div>
                    <div class="control__date btn bg-light-red">
                        с 15.07 по 29.07 
                    </div>
                </div>
            </div>  
            <div class="superiorities col-lg-12 d-flex justify-content-between">
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-truck"></i></div>
                    <span>Быстрая доставка по Симферополю и Крыму</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="far fa-credit-card"></i></div>
                    <span>Удобные способы оплаты заказа</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-money-bill-alt"></i></div>
                    <span>Отличные цены вне конкуренции</span>
                </div>
                <div class="superiority col-lg-3">
                    <div class="superiority__icon"><i class="fas fa-phone"></i></div>
                    <span>Доступность менеджера с 08:00 до 19:00</span>
                </div>    
            </div>              
        </div>
        @isset($articles)
        <div class="header_articles col-lg-3">
            @foreach ($articles as $article)
                <div class="header_article">
                    <h5>
                        {{ $article->limit_title }}
                    </h5>
                    <div class="d-flex justify-content-between">
                        <span>
                            {{ $article->start_date }}
                        </span>
                        <a href="#">далее...</a>
                    </div>
                </div>
            @endforeach
        </div>
        @endisset            
    </div>
    <div class="sales_products wrap d-flex col-lg-12">
        
        <div class="sale_product col-lg-4">sefsfsef</div>
        <div class="sale_product col-lg-4">sefsefsfsfsfsef</div>
        <div class="sale_product col-lg-4">sefsefsfsfsfsef</div>
    </div>
      
@endsection