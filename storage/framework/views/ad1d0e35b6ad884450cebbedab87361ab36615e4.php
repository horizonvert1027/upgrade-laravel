<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
	<?php $__currentLoopData = App\Models\Pages::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	<url>
             <loc><?php echo e(url('page',$page->slug)); ?></loc>
             <priority>0.3</priority>
             <changefreq>yearly</changefreq>
       </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</urlset><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/sitemap/ok-page-sitemap.blade.php ENDPATH**/ ?>