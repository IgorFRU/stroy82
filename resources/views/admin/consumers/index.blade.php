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
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($consumers as $consumer)
                          
                          <tr>
                              
                                <th scope="row">1</th>
                                <th><a href="{{ route('admin.consumer', $consumer->id) }}">{{ $consumer->name ?? '' }}</a></th>
                                <th>{{ $consumer->surname ?? '' }}</th>
                                <th>{{ $consumer->address ?? '' }}</th>
                                <th>{{ $consumer->phone ?? '' }}</th>
                                <th>{{ $consumer->email ?? '' }}</th>
                                <th>{{ $consumer->created_at ?? '' }}</th>
                            
                                
                            </tr>
                        
                          @empty
                              
                          @endforelse
                            
                         
                        </tbody>
                      </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection