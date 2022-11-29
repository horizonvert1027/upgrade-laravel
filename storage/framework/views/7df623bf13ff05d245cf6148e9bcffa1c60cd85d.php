<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

<?php
	$resolution = explode('x', $image->resolution);
	$newWidth = $resolution[0];
	$newHeight = $resolution[1];
	$thumbnail = config('app.filesurl').(config('path.simthumbnail').$image->simthumbnail);
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

	elseif ($image->extension == 'gif') {
		$thumbnail = config('app.filesurl').(config('path.large').$image->large); 
		$background = '';
	}
	else { 
		$background = '';
	}

?>

<a style="<?php echo e($background); ?>" href="<?php echo e(config('app.appurl')); ?>/<?php echo e($slugUrl1); ?>/<?php echo e($image->id); ?>/<?php echo e(Str::slug($image->title)); ?>" class="item" data-w="<?php echo e($newWidth); ?>" data-h="<?php echo e($newHeight); ?>" title="<?php echo e($image->title); ?>">
	<img class="lozad" src="/public/svg/load.svg" data-src="<?php echo e($thumbnail); ?>" alt="<?php echo e(Str::limit($image->title, 28, '')); ?>"/>
</a>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\resources\views/includes/imageslazy.blade.php ENDPATH**/ ?>