<?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container-paginator">
	<?php echo e($images->links()); ?>

</div>
<script type="text/javascript">
	const observer = lozad();
observer.observe();
</script><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/ajax/images-ajax.blade.php ENDPATH**/ ?>