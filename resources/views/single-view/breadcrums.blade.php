<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        @foreach($breadcrums as $position => $item)
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
<ul class="fnb-breadcrums flex-row">
    <li class="fnb-breadcrums__section">
        <a href="">
            <i class="fa fa-home home-icon" aria-hidden="true"></i>
        </a>
    </li>
    <li class="fnb-breadcrums__section">
        <a href="">
            <p class="fnb-breadcrums__title">/</p>
        </a>
    </li>
    <li class="fnb-breadcrums__section">
        <a href="">
            <p class="fnb-breadcrums__title">{{$data['city']['name']}}</p>
        </a>
    </li>
    <li class="fnb-breadcrums__section">
        <a href="">
            <p class="fnb-breadcrums__title">/</p>
        </a>
    </li>
    <li class="fnb-breadcrums__section">
        <a href="">
            <p class="fnb-breadcrums__title main-name">{{$data['title']['name']}}</p>
        </a>
    </li>
</ul>
