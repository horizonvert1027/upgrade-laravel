<?php
$contenturl = '';
$multilangLink = '';
$description = '404 Error! Page Not Found!';
$title = 'Page Not Found! 404 Error! ';
$keywords = '404 Error! Page Not Found!';
$thumbimage = url('/').'/public/logo.png';

?>




<style type="text/css">
.login-rgister {
    display: block;
    width: fit-content;
    border: 2px solid var(--light-dark-clr);
    padding: 12px;
    border-radius: 12px;
    box-shadow: var(--tag-shadow);
    background: var(--light-white-clr);
    text-align: -webkit-center;
    margin: auto;
    margin-top: 12%;
}
.ibox.bsh.mt20 {background: transparent;box-shadow: none;}</style>

<?php $__env->startSection('content'); ?>

  <div class="container">
  <section>
  <div class="col-md-12">
  <div class="ibox bsh mt20">
  <div class="login-rgister">
        <h1 style="font-size: 35px"><?php echo e(trans('error.error_404')); ?></h1>
        <h3>Page not found</h3>
        <p class="subtitle-error">Either you typed incorrectly, or the page is no longer available.</p>
        <div>
          <a href="<?php echo e(url('/')); ?>">
          <?php echo e(trans('error.go_home')); ?>

          </a>
        </div>


  </div>
</div>
</div>
</section>
</div>
<?php $__env->stopSection(); ?>








<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/errors/404.blade.php ENDPATH**/ ?>