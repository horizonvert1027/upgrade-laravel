  <?php if( $settings->captcha == 'on' ): ?> 
  <?php echo app('captcha')->render();; ?>

  <?php endif; ?>

<rss version="2.0"> 
<channel>
  <title><?php echo e(config('app.sitename')); ?></title>
  <link><?php echo e(config('app.url')); ?></link>
  <description>New <?php echo e($categories[0]->name); ?></description>
  <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  
  
     <?php  if( Str::slug( $img->title ) == '' ) {
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
        $tags = explode(",",$img->metakeywords);
    $preview = config('app.filesurl').(config('path.preview').$img->preview);
    $large = config('app.filesurl').(config('path.large').$img->large);
       if ($img->extension == 'gif') {
        $pinthumbnail = config('app.filesurl').(config('path.large').$img->large);
        $types = "image/gif";
    }
    else {
        $pinthumbnail = config('app.filesurl').(config('path.pinthumbnail').$img->pinthumbnail);
         $types = "image/webp";
    }

    if($img->pinthumbnail != NULL){
      $imagesrc = $pinthumbnail;
    }
      else {
        $imagesrc = $preview;
      }
      $imagesrcs = $large;
			?>

  <item>
    <title><?php echo e($img->title); ?></title>
    <link><?php echo e(url('/').('/')); ?><?php echo e($file); ?><?php echo e($img->id); ?><?php echo e(($slugUrl)); ?></link>
    <guid isPermaLink="true"><?php echo e(url('/').('/')); ?><?php echo e($file); ?><?php echo e($img->id); ?><?php echo e(($slugUrl)); ?></guid>
    <enclosure url="<?php echo e($imagesrcs); ?>" length="123456789" type="<?php echo e($types); ?>" />
    <description>
    <?php
  
    
    ?>
    <![CDATA[
<div><img width="300" src="<?php echo e($imagesrcs); ?>"  />
<?php echo e(App\helper::removetags($categories[0]->spdescr)); ?> this is <?php echo e($img->title); ?> <?php if(isset($tags[3])): ?> <?php echo e($tags[3]); ?> <?php endif; ?> <?php if(isset($tags[4])): ?> <?php echo e($tags[4]); ?> <?php endif; ?> <?php if(isset($tags[5])): ?> <?php echo e($tags[5]); ?> <?php endif; ?>
</div> 
]]>
</description>
    <pubDate><?php echo e(date("D, d M Y H:i:s T", strtotime($img->date))); ?></pubDate>
  </item>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</channel>
</rss>
<?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/rss/feeds.blade.php ENDPATH**/ ?>