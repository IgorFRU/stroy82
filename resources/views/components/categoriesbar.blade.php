<aside class="white_box p10 mb-4 categories_bar">
    <h4>Категории товаров</h4>
    <div class="categories_bar__toggle active">
        @forelse ($categories as $category)                
            {{-- @if (count($category->products) > 0)         --}}
                <li><a href="{{ route('category', $category->slug) }}" class="{{ (Request::is('catalog/' . $category->slug) ? 'active' : '') }}">{{ $category->category }} @if($category->products->count() > 0)<span class="badge badge-light ml-2">{{ $category->products->count() }}</span>@endif</a>
                    @if (count($category->children) > 0)
                        <ul>
                            @forelse ($category->children as $child)
                                {{-- @if (count($child->products) > 0) --}}
                                    <li><a href="{{ route('category', $child->slug) }}" class="{{ (Request::is('catalog/' . $child->slug) ? 'active' : '') }}">{{ $child->category }} @if($child->products->count() > 0)<span class="badge badge-light ml-2">{{ $child->products->count() }}</span>@endif</a>
                                {{-- @endif --}}
                                @if (count($child->children) > 0)
                                    <ul>
                                        @forelse ($child->children as $child)
                                            {{-- @if (count($child->products) > 0) --}}
                                                <li><a href="{{ route('category', $child->slug) }}" class="{{ (Request::is('catalog/' . $child->slug) ? 'active' : '') }}">{{ $child->category }} @if($child->products->count() > 0)<span class="badge badge-light ml-2">{{ $child->products->count() }}</span>@endif</a>
                                            {{-- @endif --}}
                                            @if (count($child->children) > 0)
                                                <ul>
                                                    @forelse ($child->children as $child)
                                                        {{-- @if (count($child->products) > 0) --}}
                                                            <li><a href="{{ route('category', $child->slug) }}" class="{{ (Request::is('catalog/' . $child->slug) ? 'active' : '') }}">{{ $child->category }} @if($child->products->count() > 0)<span class="badge badge-light ml-2">{{ $child->products->count() }}</span>@endif</a>
                                                        {{-- @endif --}}
                                                    @empty                                        
                                                    @endforelse
                                                </ul>
                                            @endif
                                        @empty                                        
                                        @endforelse
                                    </ul>
                                @endif
                            @empty                                        
                            @endforelse
                        </ul>
                    @endif
                </li>
            {{-- @endif --}}

        @empty                        
        @endforelse
    </div>
    <div class="button__toggle active" data-toopen="categories_bar__toggle">
        <span class="toopen"><i class="fas fa-arrow-circle-down"></i></span>
    </div>
</aside>