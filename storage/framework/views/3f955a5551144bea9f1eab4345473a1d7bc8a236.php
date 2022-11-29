

  <?php $__env->startSection('OwnCss'); ?>
    <link rel="preload" href="/public/jscss/homecssobs.css?792" as="style">
    <link rel="stylesheet" href="/public/jscss/homecssobs.css?792">
  <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="jumbotron index-header aligncenter">

      <h1 class="bounce-in-top"><?php echo e($sitearr[0]); ?> <span style="color: #d9d91a"><?php echo e($sitearr[1]); ?></span></h1>
      <p class="swing-in-bottom-fwd"><strong><?php echo e($settings->welcome_subtitle); ?></strong></p>

        <div class="jumbotron22">
          <form role="search" autocomplete="off" action="<?php echo e(config('app.appurl')); ?>/search" method="get">
          <div class="suggest">
          <input type="text" class="form-control suggest" name="q" value="" placeholder="Search..." aria-label="Search">
          
          <button class="search" aria-label="Justify" title="Search" type="submit">
          <span class="icsearch"></span>
          </button>
          </div>
          </form>
        </div>

            <div class="projects-catalog">
              <div class="catalog-cover">
                <i class="left-button"></i>
                  <ul id="butt" class="sliderWrapper1 sliderscroll">
                    <?php if($settings->hotsearch!=''): ?>
                        <?php $tags=explode(',',$settings->hotsearch);$count_tags=count($tags); 
                          for( $i = 0; $i < $count_tags; ++$i ) { 
                          $first=HH::getFristImageSearch($tags[$i]);
                          ?>          
                      <li class="slide htags">
                        <a class="slink" alt="Polpular Search" href="search?q=<?php echo e(HH::spacesUrl($tags[$i])); ?>">
                          <?php if($first!=''): ?>
                          <img class="img-circle tags" height="40" width="40" src="<?php echo e(config('app.filesurl').('uploads/thumbnail')); ?>/<?php echo e(($first)); ?>">
                          <?php endif; ?>
                           <div class="sidekro tags">
                             <?php echo e($tags[$i]); ?>

                           </div>
                           
                        </a>
                      </li>
                       <?php } ?>
                    <?php endif; ?> 
                  </ul>
                <i class="right-button"></i>
              </div>
            </div>
    </div>
    

    <?php echo $__env->make('includes.homeboxes', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

<div class="container">
  <section>
    <div class="col-md-12">
      <div class="ibox mt20">


<!--   <?php echo date('m/d/Y h:i:s a', time()); ?>

    <?php echo date_default_timezone_set("America/New_York");echo "The time is " . date("h:i:sa"); ?> -->

             



    <div class="aligncenter imgs">


      <h2>Latest
      <span class="color-default">Stocks</span></h2>
      <div class="flex-images imagesFlex2">
      <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>
      <a class="man" href="<?php echo e(config('app.appurl')); ?>/latest"> <?php echo e(trans('misc.view_all')); ?></a>
      
      <?php if($settings->whatstoday!=''): ?>
        <h2><?php echo e(($settings->whatstoday)); ?>

        <span class="color-default">Stocks</span></h2>
      
        <div class="flex-images imagesFlex2">
        <?php
          $category = App\subcategories::whereIn('slug',[''.$settings->whatstodaylink.''])->pluck('id')->toArray();
          $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
        ?>
          <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
          <a class="man" href="<?php echo e(('')); ?>/s/<?php echo e(str_replace(" ","- ",($settings->whatstodaylink))); ?>"> <?php echo e(trans('misc.view_all')); ?></a>
      <?php endif; ?>


      <?php if($settings->whatstoday1!=''): ?>
        <h2><?php echo e(($settings->whatstoday1)); ?>

        <span class="color-default">Contents</span></h2>
      
        <div class="flex-images imagesFlex2">
          <?php
            $category = App\subcategories::whereIn('slug',[''.$settings->whatstoday1link.''])->pluck('id')->toArray();
            $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
          ?>
            <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
          <a class="man" href="<?php echo e(('')); ?>/s/<?php echo e(str_replace(" ","- ",($settings->whatstoday1link))); ?>"> <?php echo e(trans('misc.view_all')); ?></a>
      <?php endif; ?>



      <?php if($settings->homefiles1!=''): ?>
        <h2>Recommended
        <span class="color-default">Wallpapers</span></h2>
        <div class="flex-images imagesFlex2">
        <?php
        $category = App\subcategories::whereIn('slug',[''.$settings->homefiles1.''])->pluck('id')->toArray();
        $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
        ?>
        <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <a class="man" href="<?php echo e(('')); ?>/s/<?php echo e(str_replace(" ","- ",($settings->homefiles1))); ?>"> <?php echo e(trans('misc.view_all')); ?>

        </a>
      <?php endif; ?>

        <?php if($settings->homefiles2!=''): ?>
          <h2>Editing
          <span class="color-default">Stocks</span></h2>
          <div class="flex-images imagesFlex2">
          <?php
            $category = App\subcategories::whereIn('slug',[''.$settings->homefiles2.''])->pluck('id')->toArray();
            $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
          ?>
            <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
          <a class="man" href="<?php echo e(('')); ?>/s/<?php echo e(str_replace(" ","- ",($settings->homefiles2))); ?>"> <?php echo e(trans('misc.view_all')); ?>

          </a>
        <?php endif; ?>

        <div>
        <?php
          $images   = App\models\Images::where('featured', 'yes')->where('status','active')->orderBy('featured_date','DESC')->take(30)->get();
        ?>
        <?php if( $images->count() != 0 ): ?>
          <h2>Featured<span class="color-default">Stocks</span></h2>
          <div class="flex-images imagesFlex2">
            <?php
              $images   = App\models\Images::where('featured', 'yes')->where('status','active')->orderBy('featured_date','DESC')->take(30)->get();
            ?>
            <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
          <a class="man" href="<?php echo e(('')); ?>/featured"> <?php echo e(trans('misc.view_all')); ?>

          </a>
        <?php endif; ?>
        </div>
        
        
    </div>

</div>
</section>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

  <?php if( Auth::check() && Auth::user()->status == 'pending' ): ?>
    <div class="alert alert-danger text-center margin-zero border-group">
    <i class="icon-warning myicon-right"></i> <?php echo e(trans('misc.confirm_email')); ?> <strong><?php echo e(Auth::user()->email); ?></strong>
    </div>
  <?php endif; ?>

<script>
var googleadslink = "";
slide('.sliderWrapper3')
slide('.sliderWrapperBirthday')
slide('.sliderWrapperFestival')
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/home.blade.php ENDPATH**/ ?>