@isset($page['title']) <title> {!!$page['title']!!}</title>@endisset

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="robots" content="index, follow"/>

<link rel="canonical" href="{{ url('/')}}" />

@isset($tags['title']) <meta name="title" content="{!!$tags['title']!!}" /> @endisset

@isset($tags['description']) <meta name="description" content="{!!$tags['description']!!}" /> @endisset

@isset($tags['keywords']) <meta name="keywords" content="{{$tags['keywords']}}" /> @endisset

<!-- Open Graph -->
@isset($ogtag['title'])<meta property="og:title" content="{!!$ogtag['title']!!}">@endisset

@isset($ogtag['url'])<meta property="og:url" content="{{$ogtag['url']}}">@endisset

@isset($ogtag['description'])<meta property="og:description" content="{!!$ogtag['description']!!}">@endisset

@isset($ogtag['image'])<meta property="og:image" content="{{$ogtag['image']}}">@endisset

@isset($ogtag['type'])<meta property="og:type" content="{{$ogtag['type']}}">@endisset

@isset($ogtag['site_name'])<meta property="og:site_name" content="{{$ogtag['site_name']}}">@endisset

<meta property="fb:app_id" content="{{ env('FACEBOOK_ID') }}">


<!-- Twitter -->
@isset($twitterTag['card'])<meta property="twitter:card" content="{{$twitterTag['card']}}">@endisset

@isset($twitterTag['site'])<meta property="twitter:site" content="{{$twitterTag['site']}}">@endisset

@isset($twitterTag['creator'])<meta property="twitter:creator" content="{{$twitterTag['creator']}}">@endisset

@isset($twitterTag['title'])<meta property="twitter:title" content="{!!$twitterTag['title']!!}">@endisset

@isset($twitterTag['description'])<meta property="twitter:description" content="{!!$twitterTag['description']!!}">@endisset

@isset($twitterTag['url'])<meta property="twitter:url" content="{!!$twitterTag['url']!!}">@endisset


@isset($twitterTag['image'])<meta property="twitter:image" content="{{$twitterTag['image']}}">@endisset

@isset($twitterTag['image_alt'])<meta property="twitter:image:alt" content="{{$twitterTag['image_alt']}}">@endisset




<!-- google+ -->
@isset($itemPropTag['name'])<meta itemprop="name" content="{!!$itemPropTag['name']!!}" />@endisset

@isset($itemPropTag['url'])<meta itemprop="url" content="{{$itemPropTag['url']}}" />@endisset

@isset($itemPropTag['description'])<meta itemprop="description" content="{!!$itemPropTag['description']!!}" />@endisset

@isset($itemPropTag['image'])<meta itemprop="image" content="{{$itemPropTag['image']}}" />@endisset