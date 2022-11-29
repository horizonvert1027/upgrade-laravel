<?php $__env->startSection('OwnCss'); ?>
<style>.boxe1{float:left;width:25%;padding-left:5px;margin-bottom:10px}img.img-responsive.boxthumb{max-width:100%}@media (min-width: 200px) and (max-width: 400px){.box2{width:50%}}@media (min-width: 401px) and (max-width: 800px){.box3{width:50%}}.boxthumb{border-radius:8px}.col-md-12{display:flex}div#mainLazy{display: flow-root}.col-md-12 {display: block !important}</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
<section>
  <div class="col-md-12">
  	<div id="mainLazy" class="ibox bsh mt20 mt35">
				<h1><?php echo e($main_name); ?></h1>
					<div class="aligncenter">
						<p>
							<strong><?php echo e(trans('misc.browse_by_category')); ?></strong>
						</p>
					</div>
					<ol class="breadcrumb">
						<li>
						    <a href="<?php echo e(url('/')); ?>" aria-label="home" title="home">
						        <span class="ichome"></span>
						    </a>
						</li>
						<li>
							<a href="<?php echo e(url('type/'.Str::slug($slug))); ?>"><?php echo e($main_name); ?>

							</a>
						</li>
					</ol>
            <?php if(HH::likecheck($title, $description) == false): ?>
	            <div class="cent adbox strip mb35">
	               <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            </div>
            <?php endif; ?>

				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<?php $images = App\Models\Query::categoryImages($category->slug); ?>
               <?php if( $images['total'] != 0 ): ?>


				<?php if( $category->thumbnail == '' ) { $_image = 'default.jpg'; } else { $_image = $category->thumbnail; } ?>
						<div class="boxe1 box2 box3 box4"> 
						<a href="<?php echo e(url('c')); ?>/<?php echo e($category->slug); ?>">
							<img class="img-responsive boxthumb" width="457" src="<?php echo e(config('app.filesurl')); ?>public/img-category/<?php echo e($_image); ?>" alt="<?php echo e($category->name); ?>">
						</a>

					<div class="aligncenter" style="overflow: hidden;margin: 0px 5px;">
						<p>
							<a style="overflow: hidden;white-space: nowrap;" href="<?php echo e(url('c')); ?>/<?php echo e($category->slug); ?>">
								<?php echo e(($category->name)); ?>(<?php echo e($category->images()->count()); ?>)
							</a>
						</p>
					</div>
					</div>

					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	 </div>
  </div>
</section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('SchemaJson'); ?>
		<script type="application/ld+json">
			{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"<?php echo e(url('/')); ?>","name":"Home"}},{"@type":"ListItem","position":2,"item":{"@id":"<?php echo e(url('type/'.Str::slug($slug))); ?>","name":"<?php echo e($main_name); ?>"}}]}
		</script>
		<script type="application/ld+json">
			[{"@context":"http://schema.org","@type":"WebSite","name":"<?php echo e($main_name); ?>","description":"Best <?php echo e($main_name); ?>","keywords":"<?php echo e($keywords); ?>","url":"<?php echo e(url('type/'.Str::slug($slug))); ?>","potentialAction":{"@type":"SearchAction","target":"<?php echo e(url('/')); ?>/search?q={search_term_string}","query-input":"required name=search_term_string"}}]
		</script>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\resources\views/default/main-category.blade.php ENDPATH**/ ?>