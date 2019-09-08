@extends('layouts.main-app')
@section('scripts')
    @parent
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('main') <i class="fas fa-home"></i> @endslot
               
        @slot('active') Личный кабинет @endslot
    @endcomponent 
    
    
    
    <section class="wrap">
        <div class="white_box p10">
                <div class="user_section">
                    <h2><i class="material-icons"></i> {{ Auth::user()->full_name }}</h2>
                </div>
                <div class="user_section">
                    <h2><i class="material-icons"></i> Личные данные</h2>
                </div>          
        </div>
    </section>
    
    
      
@endsection