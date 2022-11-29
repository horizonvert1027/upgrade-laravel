
<?php $__env->startSection('content'); ?>
<div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">
            <h1><?php echo e($title); ?></h1>
            
               <ol class="breadcrumb">
                  <li>
                     <a href="<?php echo e(url('/')); ?>" aria-label="home" title="home">
                        <span class="ichome"></span>
                     </a>
                  </li>
                  <li>
                     <a href="<?php echo e($maincatlink); ?>" > <?php echo e($maincatname); ?></a>
                  </li>
                  <li>
                     <a href="<?php echo e($categorylink); ?>" title="<?php echo e($categoryname); ?>"><?php echo e(Str::limit($categoryname, 25, '...')); ?>

                     </a>
                  </li>
                  <li>
                     <a href="<?php echo e($subcategorylink); ?>" title="<?php echo e($subcategoryname); ?>"><?php echo e(Str::limit($subcategoryname, 18, '...')); ?>

                     </a>
                  </li>
                  <li>
                     <?php echo e($subgroup); ?>

                  </li>
               </ol>

            <div class="projects-catalog sg">
               <div class="catalog-cover">
                  <ul class="sliderWrapper1 sliderscroll">
                     
                     <li>
                        <a class="slink sq" href="<?php echo e($subcategorylink); ?>">
                           <img class="img-circle sqtags" height="65" width="65" alt="<?php echo e($subcategoryname); ?>" src="<?php echo e(config('app.filesurl').('public/subcatpreview')); ?>/<?php echo e($subcategory[0]->preview); ?>">
                           <div class="sidekro sg">
                              <p class="sgtags"><b><?php echo e(($subcategoryname)); ?></b></p>
                              
                              <p><?php echo e(HH::getSubCategoryTotalImages($subcategory[0]->slug)); ?> <?php if($lastimage->opt_file_source ==''): ?>Images <?php else: ?> <?php echo e(strtoupper($lastimage->extension)); ?> Files <?php endif; ?></p>
                           </div>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>

            <?php if( $images->total() != 0 ): ?>

                  <?php if(HH::likecheck($title, $description) == false): ?>
                     <div class="cent adbox strip">
                        <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </div>
                  <?php endif; ?>

                  <div class="flex-images imagesFlex2 dataResult">
                     <?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     
                     <?php if( $images->count() != 0  ): ?>
                        <div class="container-paginator"><?php echo e($images->links()); ?>

                        </div>
                     <?php endif; ?>
                  </div>
            <?php else: ?>
                  <h3><?php echo e(trans('misc.no_results_found')); ?></h3>
            <?php endif; ?>
         </div>
      </div>
   </section>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('SchemaJson'); ?>
<script type="application/ld+json">
[
{
"@context": "http://schema.org",
"@type": "WebSite",
"name": "<?php echo e($title); ?>",
"description": "<?php echo e($description); ?>",
"keywords": "<?php echo e($keywords); ?>",
"url": "<?php echo e(url('/')); ?>",
"potentialAction":
{
"@type": "SearchAction",
"target":"<?php echo e(url('/')); ?>/search?q={search_term_string}",
"query-input": "required name=search_term_string"}},
{
"@context":"https://schema.org",
"@type":"BreadcrumbList",
"itemListElement":
[
{
"@type": "ListItem",
"position": 1,
"name": "Home",
"item": "<?php echo e(url('/')); ?>"},
{
"@type": "ListItem",
"position": 2,
"name": "<?php echo e($categoryname); ?>",
"item": "<?php echo e($categorylink); ?>"},
{
"@type":"ListItem",
"position": 3,
"name": "<?php echo e($subcategoryname); ?>",
"item": "<?php echo e($subcategorylink); ?>"
}
]
},

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
var ajaxlink = '<?php echo e(url("/")); ?>/ajax/subgroup?q=<?php echo e($subgroup); ?>&page=';
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/subgroup-show.blade.php ENDPATH**/ ?>