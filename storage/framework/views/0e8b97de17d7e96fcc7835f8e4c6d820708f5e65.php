
<?php $__env->startSection('content'); ?>   
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="ibox bsh mt20 mt35">
                    <?php if(HH::likecheck($title, $description) == false): ?>
                        <div class="cent adbox strip">
                        <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>
                	<div class="flex-images imagesFlex2 dataResult">
                	<?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    	<div class="container-paginator"><?php echo e($images->links()); ?>

                        </div>
                	</div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

 <?php $__env->startSection('SchemaJson'); ?>
     <script type="application/ld+json">
       [   {
       "@context": "https://schema.org",
       "@type": "WebSite",
       "url": "<?php echo e(url('/')); ?>",
       "potentialAction": {
       "@type": "SearchAction",
       "target": "<?php echo e(url('/')); ?>/search?q={search_term_string}",
       "query-input": "required name=search_term_string"
       }},
          <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php if($i->opt_file_source != ""){$slugUrl1  = 'file';}
                else {$slugUrl1  = 'photo';}
             ?>
             {
                "@context": "http://schema.org",
                "@type": "ImageObject",
                "name": "<?php echo e($i->title); ?>",
                "caption": "<?php echo e($i->title); ?>",
                "keywords": "<?php echo e($i->metakeywords); ?>",
                "description": "<?php echo e(HH::removetags($description)); ?>",
                "image":"<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>",
                "url":"<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>",
                "contentUrl":"<?php echo e(config('app.filesurl').('uploads/large/').($i->large)); ?>",
                "thumbnail": "<?php echo e(config('app.filesurl').('uploads/preview/').($i->preview)); ?>",
                "fileFormat":"image/<?php echo e($i->extension); ?>",
                "sourceOrganization":"<?php echo e($settings->sitename); ?>"
             }
                <?php if($k != (count($images) - 1)): ?>,
                <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       ]
     </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
       var ajaxlink = '<?php echo e(URL::to("/")); ?>/ajax/latest?page='
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/latest.blade.php ENDPATH**/ ?>