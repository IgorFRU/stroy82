@extends('layouts.main-app')
@section('scripts')
    @parent
    <!-- <script src="{{ asset('js/discount_countdown.js') }}" defer></script> -->
@endsection
@section('content')
    
@component('components.breadcrumb')
    @slot('main') <i class="fas fa-home"></i> @endslot
    @slot('active') Контакты @endslot    
@endcomponent 
<section class="wrap">
    <div class="white_box p10 row">
        <div class="col-lg-6">
            <div class="user_section">
                <h4 id="address"><i class="fas fa-building"></i> <span>{{ $contacts->site_name ?? '' }}</span></h4>
            </div>
            @if ($contacts->address != NULL)
            <div class="user_section">
                <h4 id="address"><i class="fas fa-map-marker-alt"></i> <span>{{ $contacts->address ?? '' }}</span></h4>
            </div>
            @endif
            @if ($contacts->phone_1 != NULL)
            <div class="user_section">
                <h4 id="phone1"><i class="fas fa-phone"></i> <span>{{ $contacts->phone_1 ?? '' }}</span></h4>
            </div>
            @endif
            @if ($contacts->phone_2 != NULL)
            <div class="user_section">
                <h4 id="phone2"><i class="fas fa-phone"></i> <span>{{ $contacts->phone_2 ?? '' }}</span></h4>
            </div>
            @endif
            @if ($contacts->email != NULL)
            <div class="user_section">
                <h4 id="email"><i class="fas fa-at"></i> <span>{{ $contacts->email ?? '' }}</span></h4>
            </div>
            @endif
        </div>
        <div class="col-lg-6">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-warning">{{ Session::get('error') }}</div>
            @endif
            <form id="send_question" method="POST" action="{{ route('send.question') }}">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label">Имя</label>
                    <div class="col-sm-8">
                      <input type="name" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-4 col-form-label">Номер телефона</label>
                    <div class="col-sm-8">
                      <input type="phone" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-4 col-form-label">Ваш вопрос</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" id="question" name="question" required maxlength="500" rows="5"></textarea>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col"><span id="captcha_img">{!! captcha_img('flat') !!}</span> <span id="refresh_captcha"><i class="fas fa-sync-alt"></i></span></div>
                    <div class="col">
                        <input type="text" class="form-control" id="captcha" name="captcha" required placeholder="Текст с картинки">
                    </div>
                    <button type="submit" class="btn btn-info col">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</section>
    
    
      
@endsection