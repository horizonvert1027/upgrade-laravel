<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
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
<?php echo $__env->yieldContent('OwnCss'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="theme-color" content="#05203e" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#16212d" media="(prefers-color-scheme: dark)">
<meta name="viewport" content="width=device-width">
<link rel="manifest" href="<?php echo e(url('/')); ?>/manifest.json">
<meta name="application-name" content="OBS">
<?php if(Request::is('fetch/*')): ?> 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7015538341079527"
     crossorigin="anonymous"></script>
<?php endif; ?>
<?php if(!Request::is('/')): ?> 
    <style>.autocomplete-suggestions {top: 52px!important;}@media (max-width: 800px){.autocomplete-suggestions {left: 0!important;width: 100%!important;top: 54px!important;border-radius: 0 0 8px 8px!important;}}
    </style>
<?php endif; ?>

<?php if( $settings->stickyadsonoff == 'on' && Request::is('photo/*')): ?>
    <style>@media (max-width: 800px){.progress-wrap.active-progress {bottom: 96px;}}</style>
<?php endif; ?>

<link importance="low" rel="icon" href="<?php echo e(url('/')); ?>/public/img/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo e(url('/')); ?>/public/img/logo.png">

<link rel="canonical" href="<?php echo e($contenturl); ?>">
<link rel="alternate" hreflang="<?php echo e(config('app.locale')); ?>" href="<?php echo e($contenturl); ?>" />
<link rel="alternate" hreflang="x-default" href="https://<?php echo e($multilangLink); ?>" />
<?php if( config('app.locale')!='en' ): ?>
<link rel="alternate" hreflang="en" href="https://<?php echo e($multilangLink); ?>" />
<?php else: ?>
<link rel="alternate" hreflang="es" href="https://es.<?php echo e($multilangLink); ?>" />
<?php endif; ?>

<?php if(isset($rssfeed) && ($rssfeed!='')): ?>
    <link rel="alternate" type="application/rss+xml" title="<?php echo e($title); ?> Feed" href="<?php echo e($rssfeed); ?>">
<?php endif; ?>
<?php if(isset($sitemap) && ($sitemap!='')): ?>
    <link rel="sitemap" type="application/xml" title="Sitemap for <?php echo e($title); ?>" href="<?php echo e($sitemap); ?>">
<?php endif; ?>
<title><?php echo e($title); ?></title>
<meta name="description" content="<?php echo e($description); ?>">
<meta name="keywords" content="<?php echo e($keywords); ?>">
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo e($contenturl); ?>">
<meta property="og:site_name" content="<?php echo e($settings->title); ?>">
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image" content="<?php echo e($thumbimage); ?>"/>
<meta property="og:tag" content="<?php if(isset($arrayTags[0])): ?><?php echo e(trim($arrayTags[0])); ?><?php endif; ?>">
<meta property="og:tag" content="<?php if(isset($arrayTags[1])): ?><?php echo e(trim($arrayTags[1])); ?><?php endif; ?>">
<meta property="og:tag" content="<?php if(isset($arrayTags[2])): ?><?php echo e(trim($arrayTags[2])); ?><?php endif; ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="<?php echo e($contenturl); ?>"/>
<meta name="twitter:image" content="<?php echo e($thumbimage); ?>"/>
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>"/>
<meta name="twitter:site" content="<?php echo e('@'.config('app.sitename')); ?>">
<?php echo $__env->yieldContent('SchemaJson'); ?>
<?php if( isset( $settings->google_analytics ) ): ?>
    <?php echo html_entity_decode($settings->google_analytics) ?>
<?php endif; ?>
</head>
<body>
	<div class="progress-wrap">
	<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1.1 -2 108 108">
		<path class="arrsvg"/>
	</svg>
</div>
	<a href="#" id="scroll" style="display: none"></a>
		<?php if( $settings->captcha == 'on' ): ?>
			<?php echo app('captcha')->render();; ?>

		<?php endif; ?>
		<?php echo $__env->make('includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->yieldContent('content'); ?>
		<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="/public/jscss/jsobs.js"></script>

<?php if( $settings->notification == 'on' && !Request::is('type/*')): ?>

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
                            url: '<?php echo e(route("save.token")); ?>',
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
<?php endif; ?>

<?php if(Request::is('photo/*', 'fetch/*', 's/*', 'c/*', 'type/*', 'g/*', 'latest', 'featured', 'search?q=*') && $settings->google_ads_index == 'on'): ?>
	<script>
	var googleadslink = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7015538341079527";
	</script>
    <?php else: ?>
    <script>
    var googleadslink = "";
    </script>
<?php endif; ?>
<?php echo $__env->yieldContent('javascript'); ?>
</body>
</html><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/layouts/multi.blade.php ENDPATH**/ ?>