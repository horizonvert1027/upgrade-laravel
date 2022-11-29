<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
        <?php $__currentLoopData = $subcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                        $imagescount = HH::getSubTotalImages($sub->id);
                                if( $imagescount == 0 ){
                                	continue;
                                }
                        $lastdate = $sub->last_updated;
                        $lastmod = new DateTime($lastdate);
                        $result = $lastmod->format('Y-m-d\TH:i:sP');
                ?>
                <url>
                        <loc><?php echo e(url('/')); ?>/s/<?php echo e(\Illuminate\Support\Str::slug($sub->slug)); ?></loc>
                        <lastmod><?php echo e($result); ?></lastmod>
                </url>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/sitemap/ok-categoryssubcategory.blade.php ENDPATH**/ ?>