<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="robots" content="index, follow"/>

@isset($tag['title']) <meta name="title" content="{{$tag['title']}}" /> @endisset
@isset($tag['description']) <meta name="description" content="{{$tag['description']}}" /> @endisset
@isset($tag['keywords']) <meta name="keywords" content="{{$tag['keywords']}}" /> @endisset


@isset($ogtag['siteName'])<meta property="og:site_name" content="{{$ogtag['siteName']}}">@endisset
@isset($ogtag['url'])<meta property="og:url" content="{{$ogtag['url']}}">@endisset
@isset($ogtag['title'])<meta property="og:title" content="{{$ogtag['title']}}">@endisset
@isset($ogtag['image'])<meta property="og:image" content="{{$ogtag['image']}}">@endisset
@isset($ogtag['description'])<meta property="og:description" content="{{$ogtag['description']}}">@endisset
@isset($ogtag['type'])<meta property="og:type" content="{{$ogtag['type']}}">@endisset


@isset($twitterTag['card'])<meta property="twitter:card" content="{{$twitterTag['card']}}">@endisset
@isset($twitterTag['handle'])<meta property="twitter:site" content="{{$twitterTag['handle']}}">@endisset
@isset($twitterTag['handle'])<meta property="twitter:creator" content="{{$twitterTag['handle']}}">@endisset
@isset($twitterTag['description'])<meta property="twitter:description" content="{{$twitterTag['description']}}">@endisset
@isset($twitterTag['title'])<meta property="twitter:title" content="{{$twitterTag['title']}}">@endisset
@isset($twitterTag['image'])<meta property="twitter:image" content="{{$twitterTag['image']}}">@endisset
@isset($twitterTag['imageAlt'])<meta property="twitter:image:alt" content="{{$twitterTag['imageAlt']}}">@endisset
