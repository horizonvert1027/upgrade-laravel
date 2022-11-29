<?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

<?php  $imagescount = App\Helper::getSubTotalImages($sub->id); 
if( $imagescount == 0 ){ 
	continue; 
} 
if( $sub->sthumbnail == '' ) { 
	$_image = 'default.jpg'; 
} 
else { 
	$_image = $sub->sthumbnail;
} 
?> 

	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 row-margin-20">
		<a href="<?php echo e(url('s')); ?>/<?php echo e(("$sub->slug")); ?>">
			<img height="350" width="439" class="custom-rounded" loading="lazy" src="<?php echo e(config('app.filesurl')); ?><?php echo e((config('path.img-subcategory').$_image)); ?>" alt="<?php echo e($sub->name); ?>">
		</a>
		<h3>
			<a class="tab-list" href="<?php echo e(url('s')); ?>/<?php echo e(("$sub->slug")); ?>"><?php echo e(Str::limit($sub->name, 18, '')); ?> </a>
		</h3>
	</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php if( count($subcategories) == $limit ): ?>
	<div class="catpagination">
		<a style="display:block;" href="<?php echo e(url('ajax/subcategories')); ?>?page=<?php echo e($page+1); ?>">Show More</a>
	</div>
	<?php endif; ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/ajax/subcategory-ajax.blade.php ENDPATH**/ ?>