<?php

$keywords = $titleahead = $preview = $thumbimage = '';
if($images->total())
{
    $titleahead = $images[0]->category->main_cat_id;
    $keywords = $images[0]->metakeywords;
    $preview = $images[0]->preview;
}
if(isset($titleahead) && $titleahead == 0)
{$aageka  = 'Full HD Backgrounds';} 
elseif(isset( $titleahead) && $titleahead == 1)
{$aageka  = 'Full HD Transparent Images';}
elseif(isset( $titleahead) && $titleahead == 2)
{$aageka  = 'Full HD Wallpapers';}
elseif(isset( $titleahead) && $titleahead == 3)
{$aageka  = 'Presets & Brushes';}
elseif(isset( $titleahead) && $titleahead == 4)
{$aageka  = 'Graphics Templates';}
else {$aageka = 'HD Images | Photo';}
;

if(isset($img->opt_file_source) && $img->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}

$title = ucwords($q). ' ' . $aageka;
$description = ucwords($q) . ' ' . $aageka;
$thumbimage = config('app.filesurl').'uploads/preview/' . $preview;
$sitemap = '';
$multilangLink = config('app.topsiteurl').'/search?q='.$q;
$contenturl = url('/').'/search?q='.$q;
$rssfeed = url('/').'/rssfeeds';

?>


<?php $__env->startSection('title'); ?><?php echo e(e($title)); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

 <div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">
	        <h1><?php echo e(trans('misc.result_of')); ?> "<?php echo e($q); ?>"</h1>
	        <h5 class="aligncenter"><?php echo e($total); ?> Total Files Matched</h5>
		      <?php if( $images->total() == 0 ): ?>
		        <p class="subtitle-site aligncenter"><strong>No Files Matched</strong></p>
		      <?php endif; ?>

					<?php if( $images->total() != 0 ): ?>
				
			            <?php if(HH::likecheck($q) == false): ?>
				            <div class="cent adbox strip">
				               <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				            </div>
			            <?php endif; ?>
			            
							<div class="flex-images imagesFlex2 dataResult">
								<?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
									<?php if( $images->count() != 0  ): ?>
									    <div class="container-paginator">
										<?php echo e($images->links()); ?>

										</div>
									<?php endif; ?>
							</div>

				             <?php else: ?>
				           
				    		<h3>
				    			<?php echo e(trans('misc.no_results_found')); ?>

				    	   </h3>

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
				"@context": "https://schema.org",
				"@type": "WebSite",
				"url": "<?php echo e(url('/')); ?>",
				"potentialAction": {
					"@type": "SearchAction",
					"target": "<?php echo e(url('/')); ?>/search?q={search_term_string}",
					"query-input": "required name=search_term_string"
				}
			},
			<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php 
					if($i->opt_file_source != "") {
						$slugUrl1  = 'file';
					}
					else {
						$slugUrl1  = 'photo';
					}
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
		var ajaxlink = '<?php echo e(url("/")); ?>/ajax/search?q=<?php echo e($q); ?>&page=';
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/search.blade.php ENDPATH**/ ?>