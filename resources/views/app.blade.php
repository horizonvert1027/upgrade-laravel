<!DOCTYPE html>
<html lang="en">
<head>
<style>
	img.searchimg {
    border-radius: 2px;
    margin-right: 9px;
    vertical-align: bottom;
    }
</style>

<link rel="preload" href="/public/jscss/cssobs.css?9962" as="style">
<link rel="stylesheet" href="/public/jscss/cssobs.css?9962">
<link rel="preload" href="/public/jscss/jsobs.js" as="script">
@yield('OwnCss')
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="theme-color" content="#05203e" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#16212d" media="(prefers-color-scheme: dark)">
<meta name="viewport" content="width=device-width">
<link rel="manifest" href="{{ url('/') }}/manifest.json">
<meta name="application-name" content="OBS">
@if(Request::is('fetch/*')) 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7015538341079527"
     crossorigin="anonymous"></script>
@endif
@if(!Request::is('/')) 
    <style>.autocomplete-suggestions {top: 52px!important;}@media (max-width: 800px){.autocomplete-suggestions {left: 0!important;width: 100%!important;top: 54px!important;border-radius: 0 0 8px 8px!important;}}
    </style>
@endif

@if( $settings->stickyadsonoff == 'on' && Request::is('photo/*'))
    <style>@media (max-width: 800px){.progress-wrap.active-progress {bottom: 96px;}}</style>
@endif

<link importance="low" rel="icon" href="{{ url('/') }}/public/img/favicon.ico">
<link rel="apple-touch-icon" href="{{ url('/') }}/public/img/logo.png">

@if(isset($rssfeed) && ($rssfeed!=''))
	<link rel="alternate" type="application/rss+xml" title="{{$title}} Feed" href="{{$rssfeed}}">
@endif

@if(isset($sitemap) && ($sitemap!=''))
	<link rel="sitemap" type="application/xml" title="Sitemap for {{$title}}" href="{{$sitemap}}">
@endif


      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="theme-color" content="#05203e"/>
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="{{config('app.appurl')}}/public/jscss/mycss.css">
      <link rel="manifest" href="{{config('app.appurl')}}/manifest.json" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="application-name" content="OBS">
      <link rel="shortcut icon" href="{{config('app.appurl')}}/public/img/favicon-32x32.png" type="image/jpg" />
      <link rel="icon" href="{{config('app.appurl')}}/public/img/favicon.ico" />
      <link rel="apple-touch-icon" href="{{config('app.appurl')}}/public/img/apple/apple-touch-icon.png" />
      <title>@section('title')@show @if( isset( $settings->title ) ){{$settings->title}}@endif</title>
      <meta name="description" content="@yield('description_custom'){{ $settings->description }}">
      <meta name="keywords" content="@yield('keywords_custom'){{ $settings->keywords }}">
</head>
<body>
	<div class="progress-wrap">
	<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1.1 -2 108 108">
		<path class="arrsvg"/>
	</svg>
</div>
	<a href="#" id="scroll" style="display: none"></a>
		@if( $settings->captcha == 'on' )
			{!! app('captcha')->render(); !!}
		@endif
		@include('includes.navbar')
		@yield('content')
		@include('includes.footer')
<script src="/public/jscss/jsobs.js"></script>
    <script>
    var googleadslink = "";
    </script>
@yield('javascript')
</body>
</html>