<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

<?php
$page = isset($page) ? $page : 0;
$offset = $page * 5000;
?>
   <?php $__currentLoopData = App\Models\Images::offset($offset)->where('status','active')->limit(5000)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <?php  if( \Illuminate\Support\Str::slug( $img->title ) == '' ) {
				$slugUrl  = '';
			} else {
				$slugUrl  = '/'.\Illuminate\Support\Str::slug( $img->title );
			} ;

			if(isset($img->opt_file_source) && $img->opt_file_source != ""){
				$file='file/';
			}
			else
			{
				$file='photo/';
			}
			?>
<url>
 <loc><?php echo e(url($file).('/').($img->id).$slugUrl); ?></loc>
     <image:image>
		<image:loc><?php echo e(config('app.filesurl').(config('path.preview'))); ?><?php echo e(($img->preview)); ?></image:loc>
		<image:title><?php echo e($img->title); ?></image:title>
		<image:caption><?php echo e($img->title); ?></image:caption>
	 </image:image>
</url>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   
</urlset><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/sitemap/ok-imgsitemap.blade.php ENDPATH**/ ?>