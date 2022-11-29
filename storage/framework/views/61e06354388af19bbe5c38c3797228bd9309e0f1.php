<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

         <?php
         use App\subcategories;
         $page = isset($page) ? $page : 0;
         $offset = $page * 500;
         ?>

   <?php $__currentLoopData = subcategories::offset($offset)->limit(500)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   
         <?php
            $tags = $subcategories->keyword;
            $tags=explode(',',$tags);
            $count_tags=count($tags);
            $first=HH::getFristImageSubGroup($tags[0]);
         ?>

      <?php if( $first !=""): ?> 
         <sitemap>
               <loc><?php echo e(url('sg')); ?>/subgroupsof/<?php echo e(Str::slug($subcategories->slug)); ?></loc>
         </sitemap>
      <?php endif; ?>

   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</sitemapindex>
<?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/sitemap/ok-subgroups.blade.php ENDPATH**/ ?>