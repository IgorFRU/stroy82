<ol class="breadcrumb">
    <div class="wrap">
        <li class="box light_grey_box"><a href="{{route('index')}}">{{$main}}</a></li>
        @isset($parent)
            <li class="box light_grey_box"><a href="{{ $parent_route }}">{{$parent}}</a></li>
        @endisset
        
        @isset($parent2)
            <li class="box light_grey_box"><a href="{{ $parent2_route }}">{{$parent2}}</a></li>
        @endisset
        <li class="box grey_box">{{$active}}</li>
    </div>
</ol>