<div class="wrap row col-lg-12">
    <div class="col-lg-3">
        <h5>Категории</h5>
        <ul>
            @forelse ($categories as $category)
                <li><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></li>
            @empty
                
            @endforelse
        </ul>
    </div>
    <div class="col-lg-3">
        <h5>Подборки</h5>
        <ul>
            @forelse ($sets as $set)
                <li><a href="{{ route('set', $set->slug) }}">{{ $set->set }}</a></li>
            @empty
                
            @endforelse
        </ul>
    </div>
    <div class="col-lg-3">
        <h5>Информация</h5>
    </div>
    <div class="col-lg-3">
        <h5>Контакты</h5>
    </div>
</div>