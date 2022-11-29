<style type="text/css">
  ul.sliderWrapper4.sliderscroll.trending {
    text-align-last: center;
}
a.slink.sq.trending.cat.main {
    padding: 0px;
    border-top: none;
}
.sidekro.chapta.main {
    align-items: center;
    display: block;
    margin: auto;
    padding: 4px 8px 8px;
}
img.img-circle.sqtags.trending.main {
    padding: 0px;
    border-radius: 8px 8px 0px 0px;
}
</style>

<div class="homeslider">
  <h2 class="homesliderhead"><span class="color-default">Browse by </span>Types</h2>
  <div class="projects-catalog">
    <div class="catalog-cover">
      <i class="left-button sq trending"></i>
      <ul class="sliderWrapper4 sliderscroll trending">
        <?php
        $trendsubcat = DB::table('main_categorys')->limit(5)->get();
        ?>
        <?php $__currentLoopData = $trendsubcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tsub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $thumbnail = config('app.filesurl').'public/img-category/'. $tsub->thumbnail; if($tsub->thumbnail =='') {
        $thumbnail = config('app.filesurl').'public/img-category/default.jpg';
        }
        ?>
        <li class="slide trending">
          <a class="slink sq trending cat main" href="<?php echo e(url('/')); ?>/type/<?php echo e($tsub->slug); ?>">
            <div class="ekmee">
              <img height="100" width="126" loading="lazy" class="img-circle sqtags trending main" src="<?php echo e($thumbnail); ?>">
             
            </div>
            <div class="sidekro chapta main">
              <p class="cats"> <?php echo e(($tsub->name)); ?></p>
              
            </div>
          </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <i class="right-button sq trending"></i>
    </div>
  </div>
</div>


<div class="homeslider">
  <h2 class="homesliderhead"><span class="color-default">Browse Trending </span>Categories</h2>
  <div class="projects-catalog">
    <div class="catalog-cover">
      <i class="left-button sq trending"></i>
      <ul class="sliderWrapper3 sliderscroll trending">
        <?php
        $trendsubcat = DB::table('categories')->where([['mode', 'on'],['showathome','yes']])->orderBy('last_updated', 'DESC')->limit(18)->get();
        ?>
        <?php $__currentLoopData = $trendsubcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tsub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $thumbnail = config('app.filesurl').'public/img-category/'. $tsub->thumbnail; if($tsub->thumbnail =='') {
        $thumbnail = config('app.filesurl').'public/img-category/default.jpg';
        }

        $images = App\Models\Query::categoryImages($tsub->slug);
        $maincat = DB::table('main_categorys')->where([['id', $tsub->main_cat_id]])->get();
        $subcatss = DB::table('subcategories')->where([['categories_id', $tsub->id],['mode','on']])->count();
        $counting = $images['total'];
        if($maincat[0]->id == 3 || $maincat[0]->id == 4) {
          $ahead = 'Files';
        }
        else if($maincat[0]->id == 1) {
          $ahead = 'PNGs';
        }

        else if($maincat[0]->id == 0) {
          $ahead = 'Backgrounds';
        }

        else if($maincat[0]->id == 2) {
          $ahead = 'Wallpapers';
        }

        else {
          $ahead = 'Images';
        }
        ?>
        <li class="slide trending">
          <a class="slink sq trending cat" href="<?php echo e(url('/')); ?>/c/<?php echo e($tsub->slug); ?>">
            <div class="ekmee" style="display: flex">
              <img height="45" width="57" loading="lazy" class="img-circle sqtags trending" src="<?php echo e($thumbnail); ?>">
              <p class="txtttt"><b><?php echo e(HH::numberformat($counting)); ?> <?php echo e($ahead); ?></b></p>
            </div>
            <div class="sidekro chapta trending type">
              <p class="cats"> <?php echo e(($tsub->name)); ?> <?php echo e(($maincat[0]->name)); ?></p>
              
              <p class="main"><?php echo e(HH::numberformat($subcatss)); ?> Subcategories</p>
            </div>
          </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <i class="right-button sq trending"></i>
    </div>
  </div>
</div>
<div class="homeslider">
  <h2 class="homesliderhead"><span class="color-default">Trending Stocks </span>Collection</h2>
  <div class="projects-catalog">
    <div class="catalog-cover">
      <i class="left-button sq trending subcats"></i>
      <ul class="sliderWrapper2 sliderscroll trending subcats">
        <?php
        $trendsubcat = DB::table('subcategories')->where([['mode', 'on'],['showathome','yes']])->orderBy('last_updated', 'DESC')->limit(25)->get();
        ?>
        <?php $__currentLoopData = $trendsubcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tsub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $thumbnail = config('app.filesurl').'public/subcatpreview/'. $tsub->preview; if($tsub->preview =='') {
        $thumbnail = config('app.filesurl').'public/default-avatar.svg';
        }
        ?>
        <li class="slide trending subcats">
          <a class="slink sq trending subcats" href="<?php echo e(url('/')); ?>/s/<?php echo e($tsub->slug); ?>">
            <img height="100" width="100" loading="lazy" class="img-circle sqtags trending subcats" src="<?php echo e($thumbnail); ?>">
            <div class="sidekro chapta trending subcats">
              <p><b><?php echo e(Str::limit($tsub->name,14,'.')); ?></b></p>
              <p class="trendinglink">
                <?php
                $sitearr=explode(", ",$tsub->tags,2);
                ?>
                <?php echo e(Str::limit(ucwords($sitearr[0]),13,'.')); ?>

              </p>
            </div>
          </a>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <i class="right-button sq trending subcats"></i>
    </div>
  </div>
</div>
<?php
$string = $subcategories->pluck('categories_id');
?>
<?php if(stristr($string, '211') || stristr($string, '28')): ?>
<div class="homeslider">
  <h2 class="homesliderhead festbdd"><span class="color-default">Today's </span>Festival</h2>
  <div class="projects-catalog birthday">
    <div class="catalog-cover">
      <i class="left-button sq trending subcats birthday"></i>
      <ul class="sliderWrapperFestival sliderscroll trending subcats birthday">
        <?php
        foreach($subcategories as $subcat) {
        if( $subcat->categories_id != 211 && $subcat->categories_id != 28  ) {
        continue;
        }
        $thumbnail = config('app.filesurl')."/public/subcatpreview/".$subcat->preview;
        if ($subcat->preview=='') {
        $thumbnail =config('app.filesurl').'public/default-avatar.svg';
        }
        ?>
        <li class="slide trending subcats birthday festival">
          <a class="slink sq trending subcats" href="s/<?php echo e(($subcat->slug)); ?>">
            <img height="100" width="100" loading="lazy" class="img-circle sqtags trending subcats birthday festival" src="<?php echo e($thumbnail); ?>">
            <div class="sidekro chapta trending subcats birthday">
              <p><b><?php echo e(($subcat->name)); ?></b></p>
              <p class="trendinglink">
                <?php echo e(($subcat->tags)); ?>

              </p>
            </div>
          </a>
        </li>
        <?php } ?>
      </ul>
      <i class="right-button sq trending subcats birthday"></i>
    </div>
  </div>
</div>
<?php endif; ?>
<?php if(stristr($string, '31')): ?>
<div class="homeslider">
  <h2 class="homesliderhead festbdd"><span class="color-default">Today's </span>Birthday</h2>
  <div class="projects-catalog birthday">
    <div class="catalog-cover">
      <i class="left-button sq trending subcats birthday"></i>
      <ul class="sliderWrapperBirthday sliderscroll trending subcats birthday">
        <?php
        foreach($subcategories as $subcat) {
        if( $subcat->categories_id != 31 ) {
        continue;
        }
        $thumbnail = config('app.filesurl')."/public/subcatpreview/".$subcat->preview;
        if ($subcat->preview=='') {
        $thumbnail =config('app.filesurl').'public/default-avatar.svg';
        }
        $originalDob = $subcat->special_date;
        $newDob= date("d-m-Y", strtotime($originalDob));
        $tz  = new DateTimeZone('Asia/Kolkata');
        $dob = $subcat->special_date;
        $age = DateTime::createFromFormat('d-m-Y', $newDob, $tz)->diff(new DateTime('now', $tz))->y;
        ?>
        <li class="slide trending subcats birthday">
          <a class="slink sq trending subcats" href="s/<?php echo e(($subcat->slug)); ?>">
            <img height="100" width="100" loading="lazy" class="img-circle sqtags trending subcats birthday" src="<?php echo e($thumbnail); ?>">
            <div class="sidekro chapta trending subcats birthday">
              <p><b><?php echo e(($subcat->name)); ?></b></p>
              <p class="trendinglink">
                <?php echo e($age); ?> Years
              </p>
            </div>
          </a>
        </li>
        <?php } ?>
      </ul>
      <i class="right-button sq trending subcats birthday"></i>
    </div>
  </div>
</div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\resources\views/includes/homeboxes.blade.php ENDPATH**/ ?>