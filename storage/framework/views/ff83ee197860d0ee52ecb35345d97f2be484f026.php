<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
 <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php 
  $imagescount = HH::getSubTotalImages($subcategory->id);
  if( $imagescount == 0 ){
    continue;
  }

   $keywords = explode(",", $subcategory->keyword);
   foreach ($keywords as $key => $subgroup) 
   {
    if( $subgroup == "" ){
      continue;
    }

    $subgroupImages = App\Models\Images::where('status','active')->where('subgroup',$subgroup)->orderBy('date' ,'desc')->limit(1)->get();
    if( count($subgroupImages) == 0 ){
      continue;
    }
    $date = "";
    foreach ($subgroupImages as $subgroupImage) 
    {
      $lastmod = new DateTime($subgroupImage->date);
      $date = $lastmod->format('Y-m-d\TH:i:sP'); 
    }
    ?>
<url>
 <loc><?php echo e(url('g').('/').Str::slug($subgroup)); ?></loc>
 <lastmod><?php echo e($date); ?></lastmod>
    <?php
      foreach($subgroupImages as $img ){ 
      if(Str::slug( $img->title ) == '' ) {
        $slugUrl  = '';
      } else {
        $slugUrl  = '/'.Str::slug( $img->title );
      }
      if(isset($img->opt_file_source) && $img->opt_file_source != ""){
        $file='file/';
      }else{
        $file='photo/';
      }
   ?>
    <image:image>
      <image:loc><?php echo e(config('app.filesurl').('uploads/preview')); ?>/<?php echo e(($img->preview)); ?></image:loc>
      <image:title><?php echo e($img->title); ?></image:title>
      <image:caption><?php echo e($img->title); ?></image:caption>
    </image:image> 
  <?php } ?>
</url>
<?php }?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
</urlset><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/sitemap/ok-instantsubgroup.blade.php ENDPATH**/ ?>