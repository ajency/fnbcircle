@section('js')
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrumbs as $position => $item)
        {
            "@type": "ListItem",
            "position": {{$position+1}},
            "item": {
                "@id": "{{$item['url']}}",
                "name": "{{$item['name']}}"@isset($item['image']),
                "image": "{{$item['image']}}"@endisset
            }
        } @if(!$loop->last) , @endif
        @endforeach
    ]
}
</script>
@endsection

<ul class="fnb-breadcrums flex-row">
    @foreach($breadcrumbs as $position => $item)
    @if($loop->first)
    <li class="fnb-breadcrums__section">
        <a href="/" title="Home" target="_blank">
            <i class="fa fa-home home-icon" aria-hidden="true"></i>
        </a>
    </li>
    @elseif($loop->last)
    <li class="fnb-breadcrums__section ellipsis">
            <p class="fnb-breadcrums__title ellipsis" title="{{$item['name']}}">{{$item['name']}}</p>
    </li>
    @else
    <li class="fnb-breadcrums__section ellipsis">
        <a href="{{$item['url']}}" title="{{$item['name']}}" target="_blank">
            <p class="fnb-breadcrums__title ellipsis" title="{{$item['name']}}">{{$item['name']}}</p>
        </a>
    </li>
    @endif

    @if(!$loop->last)
    <li class="fnb-breadcrums__section">
        <!-- <a href="#"> -->
            <p class="fnb-breadcrums__title">/</p>
        <!-- </a> -->
    </li>
    @endif
    @endforeach
    
</ul>