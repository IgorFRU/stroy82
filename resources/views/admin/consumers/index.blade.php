@extends('layouts.admin-app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="h3">Покупатели</p>
                    {{-- <a href="{{ route('admin.consumers.create') }}" class="btn btn-primary">Новый покупатель</a>                 --}}
                </div>
                <div class="d-flex flex-wrap">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">адрес</th>
                            <th scope="col">Номер телефона</th>
                            <th scope="col">e-mail</th>
                            <th scope="col">дата регистрации</th>
                            <th scope="col">Кол-во заказов</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($consumers as $consumer)
                            
                            <tr>
                                
                                <th scope="row">{{ ($consumers->currentpage()-1) * $consumers->perpage() + $loop->iteration }} (id:{{ $consumer->id }})</th>
                                <th><a href="{{ route('admin.consumer', $consumer->id) }}">{{ $consumer->name ?? '' }}</a> @if ($consumer->is_online) <button class="btn btn-sm btn-success" title="Пользователь сейчас на сайте">online</button> @endif</th>
                                <th>{{ $consumer->surname ?? '' }}</th>
                                <th>{{ $consumer->address ?? '' }}</th>
                                <th>{{ $consumer->phone ?? '' }}</th>
                                <th>{{ $consumer->email ?? '' }}</th>
                                <th>{{ $consumer->created_at ?? '' }}</th>
                                <th>{{ count($consumer->orders) }}</th>
                            
                                
                            </tr>
                        
                            @empty
                                
                            @endforelse                         
                        </tbody>
                      </table>
                      <div class="paginate">
                        {{ $consumers->appends(request()->input())->links('layouts.pagination') }}
                      </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection