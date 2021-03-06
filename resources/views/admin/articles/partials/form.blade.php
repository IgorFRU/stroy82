
<div class="col-lg-12">
    
    <div class="form-group row">
        <label for="article" class="col-sm-2 col-form-label">Название статьи</label>
        <div class="col-md-10">
            <input type="text" name="article" class="form-control" id="article" value="{{ $article->article ?? '' }}" required>
        </div>                                    
    </div>
    

    <div class="form-group row">
        <label for="image" class="col-sm-2 col-form-label">Изображение</label>
        <div class="custom-file col-md-10">
            <input type="file" class="custom-file-input" id="customFile" name="image">
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>                                    
    </div>
    @isset($article->image)
    <div class="category_edit_img">
        <div class="p-3 mb-2 bg-danger text-white rounded">При загрузке нового изображения старое будет удалено навсегда!</div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Изображение</label>
            <img class="col-lg-4" src="{{ asset('imgs/articles/')}}/{{ $article->image }}" alt="">
        </div>
    </div>            
    @endisset
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">Текст статьи</label>
        <div class="col-md-10">
                <textarea class="form-control" name="description" id="description" rows="6">{{ $article->description ?? '' }}</textarea>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="meta_description" class="col-sm-2 col-form-label">Дополнительное писание (для поисковых машин)</label>
        <div class="col-md-10">
                <textarea class="form-control" name="meta_description" id="exampleFormControlTextarea1" rows="2">{{ $article->meta_description ?? '' }}</textarea>
        </div>
    </div>
    {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
</div>

{{-- <div class="col-lg-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
            Добавить товары
        </button>
        @isset($article->products)
        <div class="col-md-12">
                
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Категория</th>
                    <th scope="col">Наличие</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $count = 1
                @endphp   
                @forelse ($article->products as $product)
                @php
                    // dd($product)
                @endphp
                <tr @if (!$product->published) class='bg-secondary'  @endif>
                    <th scope="row">{{ $count++ }}</th>
                    <td>{{ $product->product }}</td>
                    <td>
                        @isset($product->discount)
                            @if ($product->discount->type == '%')
                                <div class='btn-group' role="group">
                                    <div class="btn text-light bg-success btn-sm" data-toggle="tooltip" data-placement="top" title="Акция '{{ $product->discount->discount }}' до {{ Carbon\Carbon::parse($product->discount->discount_end)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}"> 
                                        {{ $product->price * $product->discount->numeral }} руб.
                                    </div>
                                    <div class="btn text-light bg-secondary btn-sm">{{ $product->price_number }} руб.</div>
                                </div>
                            @elseif ($product->discount->type == 'rub')
                                <div class='btn-group' role="group">
                                    <div class="btn text-light bg-success btn-sm" data-toggle="tooltip" data-placement="top" title="Акция '{{ $product->discount->discount }}' до {{ Carbon\Carbon::parse($product->discount->discount_end)->locale('ru')->isoFormat('DD MMMM YYYY', 'Do MMMM') }}">
                                        {{ $product->price - $product->discount->value }} руб.
                                    </div>
                                    <div class="btn text-light bg-secondary btn-sm">{{ $product->price_number }} руб.</div>
                            @endif
                        @endisset
                        @empty ($product->discount)
                            <div class="btn text-light bg-success btn-sm">{{ $product->price_number }} руб.</div>
                        @endempty
                        
                    
                    
                    </td>
                    <td>{{ $product->categories->category ?? '' }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <div class='row'>                                
                            
                            <form onsubmit="if(confirm('Удалить?')) {return true} else {return false}" action="{{route('admin.products.destroy', $product)}}" method="post">
                            @csrf                         
                            <input type="hidden" name="_method" value="delete">                         
                            <button type="submit" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>                                                 
                        </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <div class="alert alert-warning">Вы еще не добавили ни одного товара!</div>
                @endforelse
            
        
    </div>
        @endisset
        
        
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Добавить товары</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="ajaxAddProductSearch" name="product" placeholder="Поиск товара">
                    <div id="ajaxAddProductSearchResult">
                        
                    </div>
                </div>
                <div class="form-group">
                    <select id="ajaxAddProductByCategory" name="category" class="form-control">
                        <option selected value="0">Выберите категорию...</option>
                        <@include('admin.categories.partials.child-categories', ['categories' => $categories])
                    </select>
                </div>
                <div class="form-group">
                    <select id="ajaxAddProductByCategoryShow" class="form-control">
                        <option selected value="0">Выберите товар...</option>
                    </select>
                </div>
            </div>
            <div>
                <input type="hidden" id="article_id" name="article_id" value="{{ $article->id ?? ''}}">
            </div>
            <div class="hidden_inputs">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="ajaxAddProductButtonClose" data-changed="false" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="ajaxAddProductButton" disabled>Добавить</button>
            </div>
            </div>
        </div>
        </div>
</div> --}}
<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        прикрепленные товары
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col col-lg-4">
                        <select id="ajaxAddProductByCategory" name="category" class="form-control">
                            <option selected value="0">Выберите категорию...</option>
                            <@include('admin.categories.partials.child-categories', ['categories' => $categories])
                        </select>
                    </div>
                    <div class="form-group col col-lg-8">
                        <select id="ajaxAddProductByCategoryShow" class="form-control">
                            <option selected value="0">Выберите товар...</option>
                        </select>
                    </div>
                    <div class="hidden_inputs">
                        @isset($article->products)
                            @foreach ($article->products as $product)
                                <input type='hidden' name='product_id[]' value="{{ $product->id }}">
                            @endforeach
                        @endisset
                        
                    </div>
                </div>                      
            </div>
            <div class="col-lg-12" id="ajaxAddProductResult">
                    
                @isset($article->products)
                    @foreach ($article->products as $product)
                        <button type="button" data-product-id="{{ $product->id }}" class="btn btn-secondary"><a href="#"><i class="fas fa-external-link-square-alt"></i></a> id: {{ $product->id }} | {{ $product->product }} | {{ $product->price }} руб. <span class="ajaxAddProductResultRemove"><i class="fas fa-window-close"></i></span></button>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</div>
   
<div class="edit_form_bottom_menu">
    <div class="row align-middle">        
        <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">id</span>
            </div>
            <input type="text" class="form-control" name="id" id="object_id" data-object='article' disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->id ?? '' }}">
        </div>
        {{-- <div class="input-group mb-3 col-md-1">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-eye"></i></span>
            </div>
            <input type="text" class="form-control" name="views" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->views ?? '' }}">
        </div> --}}
        <div class="input-group mb-3 col-md-7">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">slug</span>
            </div>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $article->slug ?? '' }}">
            {{-- <input type="text" class="form-control" name="slug" disabled aria-label="Username" aria-describedby="basic-addon1" value="{{ $article->slug ?? '0' }}"> --}}
        </div>
        <div class="mb-3 col-md-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
        <div class="mb-3 col-md-2">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-danger">Выйти</a>
        </div>
                
    </div>
</div>   