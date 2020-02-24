
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
      @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
      @endforeach  
  </ul>  
</div>    
@endif
<div class="col-lg-12">    
    <div class="form-group row">
        <label for="name" class="col-form-label col-sm-3">Имя:</label>
        <div class="col-sm-7">
            <input type="name" class="form-control" id="name" name="name" required value="@if(old('name')) {{ old('name') }} @else {{ $user->name ?? '' }} @endif">
        </div>                                  
    </div>    

    <div class="form-group row">
        <label for="email" class="col-form-label col-sm-3">Email:</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" id="email" name="email" required value="@if(old('email')) {{ old('email') }} @else {{ $user->email ?? '' }} @endif">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-form-label col-sm-3">Пароль:</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="password" name="password" minlength="8" {{ (Request::is('*create*') ? 'required' : '') }}>
        </div>
    </div>
    <div class="form-group row">
        <label for="password_confirmation" class="col-form-label col-sm-3">Подтверждение пароля:</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" {{ (Request::is('*create*') ? 'required' : '') }}>
        </div>
    </div>
</div>


<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" class="form-control" name="id" id="object_id" data-object='article' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $user->id ?? '' }}">
        </div>
        <div class="mb-3 col-md-2">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="mb-3 col-md-2">
            <a href="{{ url()->previous() }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   