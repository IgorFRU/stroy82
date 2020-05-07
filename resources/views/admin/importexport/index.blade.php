@extends('layouts.admin-app')
@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif 
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-import-tab" data-toggle="tab" href="#nav-import" role="tab" aria-controls="nav-import" aria-selected="true"><i class="fas fa-file-import"></i> Импорт</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-export" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-file-export"></i> Экспорт</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane mt-4 mb-4 fade show active" id="nav-import" role="tabpanel" aria-labelledby="nav-import-tab">
            <div class="row mb-4 w-100">
                
                <div class="col-4 mb-2">
                    <div class="card mr-1 ml-1 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Импорт товаров из Excel</h5>
                            <p class="card-text h1"></p>
                            <a href="{{ route('admin.importexport.import') }}" class="card-link">Начать <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                
                

                
            </div>
        </div>
        <div class="tab-pane fade mt-4 mb-4" id="nav-export" role="tabpanel" aria-labelledby="nav-export-tab">
                            
        </div>
    </div>
</div>
<script>
    window.onload = function(e){
        const phone_1 = document.querySelector('#phone_1').value;
        const phone_2 = document.querySelector('#phone_2').value;
        var viber = document.querySelector('#viber');
        document.getElementById('phone_1_button').addEventListener("click", function() {
            viber.value = phone_1;
        });
        document.getElementById('phone_2_button').addEventListener("click", function() {
            viber.value = phone_2;
        });
    }
</script>
@endsection
