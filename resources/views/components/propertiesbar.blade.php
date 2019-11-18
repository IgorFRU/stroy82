<aside class="sidebar white_box p10 color-white">
    <h4>Фильтр</h4>
    {{-- @php
        dd($properties->properties)
    @endphp --}}
    @forelse ($category_properties as $category_property)
        <div class="property">
            <div class="property__title">
                {{ $category_property->property }} ({{$category_property->id}})
            </div>
            <div class="property__list">
                @foreach ($properties as $property)
                    @if ($property->properties->id == $category_property->id)                         
                        <label><input type="checkbox" class="property__item" data-property_id="{{ $property->property_id }}" value="{{ $property->value }}" name="{{ $category_property->property }}"> {{ $property->value }}</label>
                    @endif
                    
                
                @endforeach
            </div>
        </div>
    @empty
        
    @endforelse

    <form action="" method="post" id="properties">
        <input type="hidden" name="properties[]">
    </form>


</aside>