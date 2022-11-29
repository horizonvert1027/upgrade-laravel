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
<?php echo $__env->yieldContent('OwnCss'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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

<?php if(isset($rssfeed) && ($rssfeed!='')): ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo e($title); ?> Feed" href="<?php echo e($rssfeed); ?>">
<?php endif; ?>

<?php if(isset($sitemap) && ($sitemap!='')): ?>
	<link rel="sitemap" type="application/xml" title="Sitemap for <?php echo e($title); ?>" href="<?php echo e($sitemap); ?>">
<?php endif; ?>


      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <meta name="theme-color" content="#05203e"/>
      <meta name="viewport" content="width=device-width">
      <link rel="stylesheet" href="<?php echo e(config('app.appurl')); ?>/public/jscss/mycss.css">
      <link rel="manifest" href="<?php echo e(config('app.appurl')); ?>/manifest.json" />
      <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <meta name="application-name" content="OBS">
      <link rel="shortcut icon" href="<?php echo e(config('app.appurl')); ?>/public/img/favicon-32x32.png" type="image/jpg" />
      <link rel="icon" href="<?php echo e(config('app.appurl')); ?>/public/img/favicon.ico" />
      <link rel="apple-touch-icon" href="<?php echo e(config('app.appurl')); ?>/public/img/apple/apple-touch-icon.png" />
      <title><?php $__env->startSection('title'); ?><?php echo $__env->yieldSection(); ?> <?php if( isset( $settings->title ) ): ?><?php echo e($settings->title); ?><?php endif; ?></title>
      <meta name="description" content="<?php echo $__env->yieldContent('description_custom'); ?><?php echo e($settings->description); ?>">
      <meta name="keywords" content="<?php echo $__env->yieldContent('keywords_custom'); ?><?php echo e($settings->keywords); ?>">
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
    <script>
    var googleadslink = "";
    </script>
<?php echo $__env->yieldContent('javascript'); ?>
</body>
</html><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/app.blade.php ENDPATH**/ ?>