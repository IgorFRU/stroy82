@extends('layouts.admin-app')

@section('scripts')
    @parent
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card edit_form">
                <div class="card-header"><p class="h3">{{ $title }}</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="put">
                        @include('admin.admin.partials.form')                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection