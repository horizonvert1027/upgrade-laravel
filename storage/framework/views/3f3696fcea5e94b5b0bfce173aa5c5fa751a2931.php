<?php
$png = ''; 
$ext = pathinfo(Storage::url('uploads/preview',$response->preview), PATHINFO_EXTENSION); 

if($response->extension == 'png') { $png = 'background: url('.asset('public/img/png_bg.png').')  ';}
 ?>


<?php $__env->startSection('content'); ?>
<style>.dwnklie{max-width:500px;display:block;margin:0 auto 10px auto}.dbtn{margin-top:10px}img.img-responsive.disableRightClick.img-thumbnail{margin-top:10px}.ibox.bsh{margin-right:10px;margin-left:10px}.heartbeat.rem{font-size:23px;font-weight:700}.heartbeat.site{font-size:29px;font-weight:700}
/*.banner {border: 1px solid #c5c5c5;
    border-radius: 10px;
    background: #700cb9;
    display: inline-flex;
}img.bannerimg {
    height: 159px;
    margin: 0px 0px 0px 15px;
}.bigtxt {
   font-size: 20px;
    font-weight: 600;
}.bannertxt {
    color: white;
    margin: auto auto auto 20px;
}
a.bannerbtn {
    background: yellow;
    padding: 8px;
    border-radius: 4px;
    margin-top: 7px;
    display: block;
    color: black;
    font-weight: 600;
    text-align: -webkit-center;
}
.smalltxt {
    color: #31ff00;
}
.bannerh {
    margin: 0 auto;
    display: block;
    width: fit-content;
}*/
</style>
<div class="container">
    <section>

               <?php if(HH::likecheck($title, $description) == false): ?>
                     <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <?php endif; ?>

        <div class="">
            <div class="iboxgallery">
                <div class="aligncenter rem">Do remember the site
                    <div class="heartbeat site">
                        Oye Be Smartest 
                    </div>
                </div>

                <!--         
                    <div class="bannerh">
                        <div class="banner">
                            <div class="bannertxt">
                               <div class="bigtxt">Hello Download</div>
                               <div class="smalltxt">it is very popular these days</div>
                               <a class="bannerbtn" href="#">Download Now!</a>
                            </div>
                        
                            <img class="bannerimg" src="/public/img/ronaldo.png">
                        </div>
                    </div>
                -->

                <div class="aligncenter">
                </div>

                <div class="cent aligncenter" style="color: green;">
                <p>ThankYou for downloading!</p>
                <p>If not downloaded automaically, 
                <?php if($response->opt_file_source != NULL): ?>
                    <a onclick="vibrateSimple()" href="<?php echo e(url('otherfetch')); ?>/<?php echo e($token_id); ?>/original" download>
                        <b>click here</b>
                    </a>
                    <?php else: ?>
                    <a onclick="vibrateSimple()" href="<?php echo e(url('ifetch')); ?>/<?php echo e($token_id); ?>/original" download>
                        <b>click here</b>
                    </a>
                <?php endif; ?>
                </p>
                </div>

                <!-- 
                    <div class="dwnklie">
                    <button onclick="vibrateSimple(); playAudio()" class="mybtn btnApp" style="" aria-label="Install Progresive App button">Download our WebApp</button>
                    </div>
                -->

                <?php if($response->opt_file_source != NULL): ?>
                    <a id="downloadthisimage" onclick="window.location='<?php echo e(url('otherfetch')); ?>/<?php echo e($token_id); ?>/original'" href="#">
                    </a>
                <?php else: ?>
                    <a id="downloadthisimage" onclick="window.location='<?php echo e(url('ifetch')); ?>/<?php echo e($token_id); ?>/original'" href="#">
                    </a>
                <?php endif; ?>
            
            </div>

                <?php if( $images->count() != 0 ): ?>
                  <div class="aligncenter" style="margin-top: 15px">
                    <h4>Similar <?php echo e($response->category->name); ?></h4>
                    <div class="flex-images imagesFlex2">
                        <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <a href="<?php echo e($subcatlink); ?>" class="gall mybtn" style="padding: 10px">
                        <span>Load more</span>
                    </a>
                  </div>
                <?php endif; ?>

        </div>
    </section>
</div>
   <?php if(HH::likecheck($title, $description) == false): ?>
      <?php echo $__env->make('ads.stickyads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php endif; ?>
   
<?php $__env->stopSection(); ?>
    <?php $__env->startSection('SchemaJson'); ?>
      <script type="application/ld+json">
         [{"@context":"https://schema.org","@type": "BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "<?php echo e(url('/')); ?>"},{"@type":"ListItem","position": 2,"name":"<?php if($response->subgroup!=''): ?><?php echo e($subcatname); ?> <?php else: ?> <?php echo e(($catname)); ?><?php endif; ?>","item":"<?php if($response->subgroup!=''): ?><?php echo e(($subcatlink)); ?> <?php else: ?> <?php echo e(($catlink)); ?> <?php endif; ?>"},{"@type":"ListItem","position":3,"name":"<?php if($response->subgroup!=''): ?><?php echo e(($response->subgroup)); ?> <?php else: ?><?php echo e(($subcatname)); ?><?php endif; ?>","item":"<?php if($response->subgroup!=''): ?><?php echo e(url('/')); ?>/g/<?php echo e(Str::slug($response->subgroup)); ?><?php else: ?> <?php echo e(($subcatlink)); ?> <?php endif; ?>"},{"@type":"ListItem","position":4,"name":"<?php echo e($title); ?>"}]},{"@context":"http://schema.org","@type":"Organization","name":"<?php echo e(config('app.sitename')); ?>","url":"<?php echo e(url('/')); ?>","logo":"<?php echo e(asset('public/img/apple')); ?>/apple-touch-icon.png","sameAs":["https://www.facebook.com/<?php echo e(config('app.sitename')); ?>","https://twitter.com/<?php echo e(config('app.sitename')); ?>","http://<?php echo e(config('app.sitename')); ?>.tumblr.com/","https://instagram.com/<?php echo e(config('app.sitename')); ?>/"]},{"@context":"http://schema.org","@type":"ImageObject","name":"<?php echo e($title); ?>","description":"<?php echo e($description); ?>","keywords":"<?php echo e($keywords); ?>","caption":"<?php echo e($imgtitletrue); ?>","contentUrl":"<?php echo e($imglarge); ?>","image":"<?php echo e($contenturl); ?>","url":"<?php echo e($contenturl); ?>",<?php if(isset($response->opt_file_source) && $response->opt_file_source != ""): ?>"fileFormat":"image/<?php echo e($response->extension); ?>",<?php endif; ?> "thumbnail":"<?php echo e($thumbimage); ?>","sourceOrganization":"<?php echo e(config('app.sitename')); ?>" }]
      </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/images/download.blade.php ENDPATH**/ ?>