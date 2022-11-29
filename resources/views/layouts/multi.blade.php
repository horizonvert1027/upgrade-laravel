<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>
<style>
	img.searchimg {
    border-radius: 2px;
    margin-right: 9px;
    vertical-align: bottom;
    }
</style>

<link rel="preload" href="/public/jscss/cssobs.css?9987" as="style">
<link rel="stylesheet" href="/public/jscss/cssobs.css?9987">
<link rel="preload" href="/public/jscss/jsobs.js" as="script">
@yield('OwnCss')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

<link rel="canonical" href="{{$contenturl}}">
<link rel="alternate" hreflang="{{config('app.locale')}}" href="{{$contenturl}}" />
<link rel="alternate" hreflang="x-default" href="https://{{$multilangLink}}" />
@if ( config('app.locale')!='en' )
<link rel="alternate" hreflang="en" href="https://{{$multilangLink}}" />
@else
<link rel="alternate" hreflang="es" href="https://es.{{$multilangLink}}" />
@endif

@if(isset($rssfeed) && ($rssfeed!=''))
    <link rel="alternate" type="application/rss+xml" title="{{$title}} Feed" href="{{$rssfeed}}">
@endif
@if(isset($sitemap) && ($sitemap!=''))
    <link rel="sitemap" type="application/xml" title="Sitemap for {{$title}}" href="{{$sitemap}}">
@endif
<title>{{$title}}</title>
<meta name="description" content="{{$description}}">
<meta name="keywords" content="{{$keywords}}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{$contenturl}}">
<meta property="og:site_name" content="{{$settings->title}}">
<meta property="og:title" content="{{$title}}">
<meta property="og:description" content="{{$description}}">
<meta property="og:image" content="{{$thumbimage}}"/>
<meta property="og:tag" content="@if (isset($arrayTags[0])){{trim($arrayTags[0])}}@endif">
<meta property="og:tag" content="@if (isset($arrayTags[1])){{trim($arrayTags[1])}}@endif">
<meta property="og:tag" content="@if (isset($arrayTags[2])){{trim($arrayTags[2])}}@endif">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{$contenturl}}"/>
<meta name="twitter:image" content="{{$thumbimage}}"/>
<meta name="twitter:title" content="{{$title}}">
<meta name="twitter:description" content="{{$description}}"/>
<meta name="twitter:site" content="{{'@'.config('app.sitename')}}">
@yield('SchemaJson')
@if( isset( $settings->google_analytics ) )
    <?php echo html_entity_decode($settings->google_analytics) ?>
@endif
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

@if( $settings->notification == 'on' && !Request::is('type/*'))

        <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>

        <script>
        var firebaseConfig = {
            apiKey: "AIzaSyBOuFvJ3hBrwMZ8taDtakASd5-Ol_4DzjM",
            authDomain: "oyebesmartestnoti.firebaseapp.com",
            projectId: "oyebesmartestnoti",
            storageBucket: "oyebesmartestnoti.appspot.com",
            messagingSenderId: "580791977582",
            appId: "1:580791977582:web:6e258f70248ef391e6887f",
            measurementId: "G-C673Z2DBD3"
            };
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/firebase-messaging-sw.js').then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                        console.log(registration);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
                });
            }

        	document.addEventListener("DOMContentLoaded", function (event) {
                messaging.requestPermission()
                    .then(function () {
                        return messaging.getToken();
                    })
                    .then(function (token) {
                        console.log(token);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '{{ route("save.token") }}',
                            type: 'POST',
                            data: {
                                token: token
                            },
                            dataType: 'JSON',
                            success: function (response) {
                            },
                            error: function (err) {
                            },
                        });
                    }).catch(function (err) {
                });
            });

            messaging.onMessage(function (payload) {
                console.log("Message has received : ", payload);
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                    click_action: payload.notification.click_action,
                };
                new Notification(noteTitle, noteOptions);
            });

        </script>
@endif

@if(Request::is('photo/*', 'fetch/*', 's/*', 'c/*', 'type/*', 'g/*', 'latest', 'featured', 'search?q=*') && $settings->google_ads_index == 'on')
	<script>
	var googleadslink = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7015538341079527";
	</script>
    @else
    <script>
    var googleadslink = "";
    </script>
@endif
@yield('javascript')
</body>
</html>