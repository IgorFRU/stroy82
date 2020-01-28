<aside class="sidebar white_box p10 color-white">
    {{-- <form action="{{ route('category', $category->slug) }}" method="get"> --}}
        <h4>Фильтр</h4>
        {{-- @php
            dd($filteredManufacture)
        @endphp --}}
        @if (count($manufactures) > 1)
            <h5>Производители</h5>
            <div class="property__list">
                @forelse ($manufactures as $manufacture)
                    <label><input type="checkbox" class="property__item" data-property_id="manufacture" value="{{ $manufacture->id }}" name="manufacture" @foreach ($filteredManufacture as $item) @if ($manufacture->id == $item) checked @endif @endforeach> {{ $manufacture->manufacture }}</label>
                @empty
                    
                @endforelse
                <button class="btn confirm_property_button btn btn-sm btn-info" title="Применить"><i class="fas fa-check"></i></button>
            </div>
        @endif
        

        @if (count($category_properties) > 0)
            <h5>Параметры</h5> 
        @endif
        
        @forelse ($category_properties as $category_property)
            <div class="property">
                <div class="property__title">
                    {{ $category_property->property }} ({{$category_property->id}})
                </div>
                <div class="property__list">
                    @php
                        // dd($properties);
                    @endphp
                    @foreach ($properties as $property)
                        @if ($property->properties->id == $category_property->id)                         
                            <label><input type="checkbox" class="property__item" data-property_id="{{ $property->property_id }}" value="{{ $property->value }}" name="{{ $property->property_id }}"> {{ $property->value }}</label>
                        @endif
                        
                    
                    @endforeach

                    <button class="btn confirm_property_button btn btn-sm btn-info" title="Применить"><i class="fas fa-check"></i></button>
                </div>
            </div>
        @empty
            
        @endforelse

        {{-- <form action="" method="post" id="properties"> --}}
            {{-- <input type="hidden" name="filter[]"> --}}
            {{-- <input type="hidden" name="category" value="{{ $category->id }}"> --}}
        {{-- </form> --}}
    {{-- </form> --}}


</aside>