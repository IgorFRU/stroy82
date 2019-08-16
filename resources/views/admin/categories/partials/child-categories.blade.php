{{-- Подключаемый шаблон для вывода выпадающего списка родительских категорий при создании или редактировании категории --}}
@foreach($categories as $category_list)
    <option value="{{$category_list->id ?? ""}}"  
    @isset($category->category_id)
           
        @if($category->category_id == $category_list->id)
            selected="selected"
        @endif
        @if($category->id == $category_list->category_id)
            disabled=""
        @endif        
        @if($category->id == $category_list->id)
            hidden="" {{-- скрываем саму категорию из списка родителей--}}
        @endif    
    @endisset 
    @isset($product->category_id)
        @if ($category_list->id == $product->category_id)
        selected = "selected"
        @endif
    @endisset    
    >
    {!! $delimiter ?? '' !!}{{$category_list->category ?? ""}}
    </option>    
    {{-- рекурсивная вложенность категорий --}}    
    @if(count($category_list->children) > 0)    
        {{-- если есть хоть одна вложенная категория, подключаем этот же шаблон --}}
        
        @include('admin.categories.partials.child-categories', [
            'categories' => $category_list->children,
            'delimiter' => ' - '.$delimiter
        ])
    
    @endif
    
@endforeach