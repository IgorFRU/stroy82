{{-- Подключаемый шаблон для вывода выпадающего списка родительских категорий при создании или редактировании категории --}}
@foreach($categories as $category_list)
    <option value="{{$category_list->id ?? ""}}"  
    @isset($current_category)
        @if($current_category == $category_list->id)
            selected="selected"
        @endif
        @if ($category_list->products->count() == 0)
            disabled='disabled'
        @endif
    @endisset 
    @isset($product->category_id)
        @if ($category_list->id == $product->category_id)
        selected = "selected"
        @endif
    @endisset    
    >
    {!! $delimiter ?? '' !!}{{$category_list->category ?? ""}} ({{ $category_list->products->count() }})
    </option>    
    {{-- рекурсивная вложенность категорий --}}    
    @if(count($category_list->children) > 0)    
        {{-- если есть хоть одна вложенная категория, подключаем этот же шаблон --}}
        
        @include('admin.products.partials.categories', [
            'categories' => $category_list->children,
            'delimiter' => ' - '.$delimiter
        ])
    
    @endif
    
@endforeach