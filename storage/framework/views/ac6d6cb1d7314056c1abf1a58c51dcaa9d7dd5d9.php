<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
   $resolution = explode('x', $image->resolution);
   $newWidth = $resolution[0];
   $newHeight = $resolution[1];
   
   $slug = $image->category->slug;
   $categories = DB::table('categories')->where('slug','=',$slug)->get();
   $maincategoryID = $categories[0]->main_cat_id;
   
   if(isset($image->opt_file_source) && $image->opt_file_source != "") { 
      $slugUrl1  = 'file';
      } 
      else {
         $slugUrl1  = 'photo';
      }

   if($maincategoryID == '1' ) { 
      $background = 'background-image: url('.url('public/img/png_bg.png').');';
   } 

   else { 
      $background = '';
   }


   if ($image->extension == 'gif') {
      $thumbnail = config('app.filesurl').(config('path.large').$image->large); 
   }
      else {
         $thumbnail = config('app.filesurl').(config('path.simthumbnail').$image->simthumbnail); 
      }

?>
   <a style="<?php echo e($background); ?>" href="<?php echo e(config('app.appurl')); ?>/<?php echo e($slugUrl1); ?>/<?php echo e($image->id); ?>/<?php echo e(Str::slug($image->title)); ?>" class="item hovercard mobileimgs" data-w="<?php echo e($newWidth); ?>" data-h="<?php echo e($newHeight); ?>" title="<?php echo e($image->title); ?>">
      <img data-src="<?php echo e($thumbnail); ?>" class="lozad" height="<?php echo e($newHeight); ?>" width="<?php echo e($newWidth); ?>" alt="<?php echo e(Str::limit($image->title, 28, '')); ?>"/>
   </a>
   <a href="<?php echo e(config('app.appurl')); ?>/<?php echo e($slugUrl1); ?>/<?php echo e($image->id); ?>/<?php echo e(Str::slug($image->title)); ?>" class="mob imgbtn btn">Go to Download Page
   </a> 
      
      <?php if(HH::likecheck($image->title) == false): ?>
         <?php if( ($loop->iteration % 7) == 0 ): ?>
            <div class="googleadblock cent adbox">
               <?php echo $__env->make('ads.mobileads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
         <?php endif; ?>
      <?php endif; ?>
      
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/includes/mob-sim-images.blade.php ENDPATH**/ ?>