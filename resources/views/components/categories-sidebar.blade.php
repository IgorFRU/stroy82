<aside class="categories_sidebar">
    <nav class="card">
        <div class="card-header">Категории товаров</div>
        <div class="card-body">
            @forelse ($menus as $menu)
                @if (count($menu->category) > 0)
                    <h5>{{ $menu->menu }}</h5>
                    <ul>
                        @forelse ($menu->parent_categories as $category)                
                                <li><a href="/catalog/{{ $category->slug }}" class="{{ (Request::is('catalog/' . $category->slug) ? 'active' : '') }}">{{ $category->category }}</a><span class="product_count">{{ count($category->products) }}</span>
                                    <ul>
                                        @forelse ($category->children as $child)                                                                            
                                            <li><a href="/catalog/{{ $child->slug }}" class="{{ (Request::is('catalog/' . $child->slug) ? 'active' : '') }}">{{ $child->category }}</a><span class="product_count">{{ count($child->products) }}</span>
                                        @empty                                        
                                        @endforelse
                                    </ul>   
                                </li>
                        @empty                        
                        @endforelse
                    </ul>
                @endif  
            @empty                        
            @endforelse         
        </div> 
    </nav>
</aside>