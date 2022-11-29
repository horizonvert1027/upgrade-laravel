<footer class="footer-distributed">
   <div class="webapp_info aligncenter">
      <p class="mb10">Get to download your desired media files at your fingertips easily with our WebApp.</p>
      <?php if(!Request::is('photo/*')): ?>
         <div class="pwadiv footerpwa">
            <p class="dummytxt">Quick to Web App</p>
            <button onclick="vibrateSimple()" class="footerbtn btnApp" aria-label="Install Progresive App button">Install Web App</button>
         </div>
      <?php endif; ?>

   </div>
   <div class="footer-right aligncenter">
      <a class="leftbtn social ictweet" href="https://twitter.com/<?php echo e($settings->twitter); ?>" aria-label="twitter">
      </a>
      <a class="leftbtn social icfb" href="https://facebook.com/<?php echo e($settings->facebook); ?>" aria-label="facebook"></a>
      <a class="leftbtn social icig" href="https://instagram.com/<?php echo e($settings->instagram); ?>" aria-label="instagram"></a>
      <a class="leftbtn social icpin" href="https://pinterest.com/<?php echo e($settings->pinterest); ?>" aria-label="pinterest"></a>
      <a class="leftbtn social ictg" href="https://t.me/laptic" aria-label="telegram"></a>
   </div>
   <div id="footerbtn" class="footer-left">
      <a class="leftbtn" href="<?php echo e(config('app.appurl')); ?>/page/about">About</a>
      <a class="leftbtn" rel="help" href="<?php echo e(config('app.appurl')); ?>/contact-us">Contact</a>
      <a class="leftbtn" href="<?php echo e(config('app.appurl')); ?>/page/privacy">Privacy</a>
      <a class="leftbtn" href="<?php echo e(config('app.appurl')); ?>/page/terms">Terms</a>
      <a class="leftbtn" rel="help" href="<?php echo e(config('app.appurl')); ?>/dmca">DMCA</a>
   </div>
   <p class="footer-center">&copy; <?php echo e($settings->title); ?> - <?php echo date('Y'); ?></p>
</footer>
<?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/includes/footer.blade.php ENDPATH**/ ?>