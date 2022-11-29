<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="_token" content="<?php echo csrf_token(); ?>"/>
    <title>Admin Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="<?php echo e(asset('public/fonts/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet" type="text/css" />
     <link href="<?php echo e(asset('public/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo e(URL::asset('public/img/favicon.ico')); ?>" />
    <link href="<?php echo e(asset('public/plugins/sweetalert/sweetalert.css')); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo e(asset('public/jscss/AdminPanel.css?19551')); ?>" rel="stylesheet" type="text/css" />
    <?php echo $__env->yieldContent('css'); ?>
  </head>

  <body class="skin-red sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <a href="<?php echo e(url('panel/admin')); ?>" class="logo">
          <span class="logo-mini"><b><i class="ion ion-ios-bolt"></i></b></span>
          <span class="logo-lg"><b><i class="ion ion-ios-bolt"></i> Admin Panel</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <li><a href="#"><i class="glyphicon glyphicon-user myicon-right"></i>&nbsp;&nbsp;<?php echo e(ucfirst(Auth::user()->role)); ?></a></li>
              <li>
                <a href="<?php echo e(url('/')); ?>"><i class="glyphicon glyphicon-home myicon-right"></i>&nbsp;&nbsp;<?php echo e(trans('admin.view_site')); ?></a>
              </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo e(asset('public/avatar').'/'.Auth::user()->avatar); ?>" class="user-image" alt="User Image" />
                  <span class="hidden-xs"><?php echo e(Auth::user()->username); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="<?php echo e(asset('public/avatar').'/'.Auth::user()->avatar); ?>" class="img-circle" alt="User Image" />
                    <p>
                      <small><?php echo e(Auth::user()->username); ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo e(url( Auth::user()->username )); ?>" class="btn btn-default btn-flat"><?php echo e(trans('users.my_profile')); ?></a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo e(url('logout')); ?>" class="btn btn-default btn-flat"><?php echo e(trans('users.logout')); ?></a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
                <label class="theme-switch" for="checkbox">
                  <input type="checkbox" id="checkbox" />
                      <div class="slider round">
                        <div class="scenary">
                          <span class="moon icmoon">
                          </span>
                          <span class="sun icsun">
                          </span>
                        </div>
                      </div>
                </label>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo e(asset('public/avatar').'/'.Auth::user()->avatar); ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p class="text-overflow"><?php echo e(Auth::user()->username); ?></p>
              <small class="btn-block text-overflow"><a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> <?php echo e(trans('misc.online')); ?></a></small>
            </div>
          </div>
          <ul class="sidebar-menu">
            
            <li <?php if(Request::is('panel/admin')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin')); ?>"><i class="fa fa-dashboard"></i> <span><?php echo e(trans('admin.dashboard')); ?></span></a>
            </li>

        
            <?php if(Auth::user()->role == 'admin'): ?>
            <li <?php if(Request::is('panel/admin/settings')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/settings')); ?>">
                <i class="ion ion-android-settings"></i><?php echo e(trans('admin.general')); ?>

              </a>
            </li>
           

            <li <?php if(Request::is('panel/admin/settings/limits')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/settings/limits')); ?>">
              <i class="ion ion-ios-toggle"></i><?php echo e(trans('admin.limits')); ?>

            </a>
            </li>

        
            <li <?php if(Request::is('panel/admin/modify')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/modify')); ?>"><i class="ion ion-social-google"></i>
                <span>Google</span>
              </a>
            </li>
           
                        <!-- Links -->
           <li <?php if(Request::is('panel/admin/languages')): ?> class="active" <?php endif; ?>>
             <a href="<?php echo e(url('panel/admin/languages')); ?>"><i class="fa fa-language"></i> <span><?php echo e(trans('admin.languages')); ?></span></a>
           </li><!-- ./Links -->
           
            <li <?php if(Request::is('panel/admin/webscrapper')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/webscrapper')); ?>"><i class="fa fa-clone"></i> <span>Scrap</span></a>
            </li>
            <li <?php if(Request::is('panel/admin/instacronlog')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/instacronlog')); ?>"><i class="ion ion-arrow-graph-down-right"></i> <span>Insta Cron Log</span></a>
            </li>
            <?php
            $pendingcount = App\Helper::getPendingImages();
            ?>
            <li <?php if(Request::is('panel/admin/images')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/images')); ?>"><i class="fa fa-picture-o"></i> <span><?php echo e(trans_choice('misc.images_plural',0)); ?> 
                <span class="label label-danger label-admin" style="background-color: var(--link-clr); font-size: 105%;padding: .1em .6em .2em; color: var(--box-clr);">(<?php echo e($pendingcount); ?>)</span>
               </span></a>
            </li>
            <?php endif; ?>
            <li <?php if(Request::is('panel/admin/duplicate-images')): ?> class="active" <?php endif; ?>>
                  <a href="<?php echo e(url('panel/admin/duplicate-images')); ?>"><i class="fa fa-picture-o"></i> <span><?php echo e(__('Duplicate Images')); ?>

               </span></a>
              </li>
            <li <?php if(Request::is('panel/admin/main_category')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/main_category')); ?>"><i class="fa fa-list-ul"></i> <span>Types</span></a>
            </li>
            <?php if(Auth::user()->role == 'admin'): ?>
            <li <?php if(Request::is('panel/admin/contact')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/contact')); ?>"><i class="ion ion-android-contacts"></i> <span>Contacted us</span></a>
            </li>

                        <li <?php if(Request::is('panel/admin/dmca')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/dmca')); ?>"><i class="ion ion-ios-list"></i> <span>DMCA</span></a>
            </li>

            <li <?php if(Request::is('panel/admin/emptysearch')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/emptysearch')); ?>"><i class="fa fa-search"></i> <span>EmptySearch</span></a>
            </li>
<li <?php if(Request::is('panel/admin/send-notification')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/send-notification')); ?>"><i class="glyphicon glyphicon-bell"></i> <span><?php echo e(__('Push Notification')); ?></span></a>
          </li>

            <li <?php if(Request::is('panel/admin/topsearch')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/topsearch')); ?>"><i class="fa fa-search"></i> <span>Top Search</span></a>
            </li>

           <li <?php if(Request::is('panel/admin/theme')): ?> class="active" <?php endif; ?>>
             <a href="<?php echo e(url('panel/admin/theme')); ?>"><i class="fa fa-paint-brush"></i> <span><?php echo e(trans('misc.theme')); ?></span></a>
           </li>

          <li <?php if(Request::is('panel/admin/members')): ?> class="active" <?php endif; ?>>
            <a href="<?php echo e(url('panel/admin/members')); ?>"><i class="glyphicon glyphicon-user"></i> <span><?php echo e(trans('admin.members')); ?></span></a>
          </li>
            <li <?php if(Request::is('panel/admin/pages')): ?> class="active" <?php endif; ?>>
              <a href="<?php echo e(url('panel/admin/pages')); ?>"><i class="glyphicon glyphicon-file"></i> <span><?php echo e(trans('admin.pages')); ?></span></a>
            </li>
            <?php endif; ?>
        </section>
      </aside>
      <?php echo $__env->yieldContent('content'); ?>
      <footer class="main-footer">
       &copy; <strong><?php echo e($settings->title); ?></strong> - <?php echo date('Y'); ?>
      </footer>
    </div>
  
    <script src="<?php echo e(asset('public/plugins/jQuery/jQuery.min.js?1222')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/autocompleteAdmin.js?1222222')); ?>"></script>
    <script src="<?php echo e(asset('public/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/plugins/fastclick/fastclick.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/admin/js/app.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/plugins/sweetalert/sweetalert.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/admin/js/functions.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/admin/js/jquery-ui.min.js')); ?>?2" type="text/javascript"></script>
          <script>
    var URL_BASE = "<?php echo e(url('/')); ?>";
      const btn=document.querySelector('.theme-switch input[type="checkbox"]'),prefersDarkScheme=window.matchMedia("(prefers-color-scheme: dark)"),currentTheme=localStorage.getItem("theme");"dark"==currentTheme?(document.body.classList.toggle("dark-theme"),btn.checked=!1):"light"==currentTheme&&(document.body.classList.toggle("light-theme"),btn.checked=!0),btn.addEventListener("click",(function(){if(prefersDarkScheme.matches){document.body.classList.toggle("light-theme");var e=document.body.classList.contains("light-theme")?"light":"dark"}else document.body.classList.toggle("dark-theme"),e=document.body.classList.contains("dark-theme")?"dark":"light";localStorage.setItem("theme",e)}));
  </script>
    <?php echo $__env->yieldContent('javascript'); ?>
  </body>
</html>
<?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/admin/layout.blade.php ENDPATH**/ ?>