<div class="wrap row col-lg-12">
    <div class="col-lg-3">
        <h5>Категории</h5>
        <hr>
        <ul>
            @forelse ($categories as $category)
                <li><a href="{{ route('category', $category->slug) }}">{{ $category->category }}</a></li>
            @empty
                
            @endforelse
        </ul>
    </div>
    <div class="col-lg-3">
        <h5>Подборки</h5>
        <hr>
        <ul>
            @forelse ($sets as $set)
                <li><a href="{{ route('set', $set->slug) }}">{{ $set->set }}</a></li>
            @empty
                
            @endforelse
        </ul>
    </div>
    <div class="col-lg-3">
        <h5>Информация</h5>
        <hr>
        <ul>
            @forelse ($topmenu as $item)
                <li><a href="{{ $item->slug ?? '#' }}">{{ $item->title }}</a></li>
            @empty
            @endforelse
        </ul>
    </div>
    <div class="col-lg-3">
        <h5>Контакты</h5>
        <hr>
        @isset($settings->phone_main)
            <a class="d-block" href="tel:+7{{ $settings->phone_main }}">{{ $settings->main_phone }}</a>
        @endisset
        @isset($settings->phone_add)
            <a class="d-block" href="tel:+7{{ $settings->phone_add }}">{{ $settings->add_phone }}</a>
            {{-- <hr> --}}
        @endisset
        @if (isset($settings->viber) || isset($settings->whatsapp))
            <div class="social_links d-flex justify-content-start">
                @isset($settings->viber)
                    <a href="viber://chat?number=+7{{ $settings->viber }}" class='viber_icon mr-4'><i class="fab fa-viber"></i></a>                
                @endisset
                @isset($settings->whatsapp)
                    <a href=" https://wa.me/7{{ $settings->whatsapp }}" target="_blank" class='whatsapp_icon mr-2'><i class="fab fa-whatsapp"></i></a>
                    <hr>
                @endisset
            </div>
            {{-- <hr> --}}
        @endif            
        <div class="d-block">{{ $settings->address ?? '' }}</div>  
        </div>  
        
    </div>
</div>
<div class="flash-messeges">
    @if (Session::has('success'))
        <div class="shadow alert alert-success">{!! Session::get('success') !!}</div>
    @endif
    @if (Session::has('warning'))
        <div class="shadow alert alert-warning">{!! Session::get('warning') !!}</div>
    @endif
    @if (Session::has('danger'))
        <div class="shadow alert alert-danger">{!! Session::get('danger') !!}</div>
    @endif
</div>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym"); ym(59159728, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/59159728" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->