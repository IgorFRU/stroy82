<aside class="sidebar white_box p10 color-white">
    <h4>Фильтр</h4>
    {{-- @php
        dd($properties->properties)
    @endphp --}}
    @if (count($manufactures) > 1)
        <h5>Производители</h5>
        @forelse ($manufactures as $manufacture)
            <label><input type="checkbox" class="property__item" data-property_id="manufacture" value="{{ $manufacture->id }}" name="{{ $manufacture->manufacture }}"> {{ $manufacture->manufacture }}</label>
        @empty
            
        @endforelse
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
                        <label><input type="checkbox" class="property__item" data-property_id="{{ $property->property_id }}" value="{{ $property->value }}" name="{{ $category_property->property }}"> {{ $property->value }}</label>
                    @endif
                    
                
                @endforeach

                <div class="confirm_property_button btn btn-sm btn-info">Применить</div>
            </div>
        </div>
    @empty
        
    @endforelse

    <form action="" method="post" id="properties">
        <input type="hidden" name="properties[]">
    </form>


</aside>