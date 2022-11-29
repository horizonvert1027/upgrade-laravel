<?php $__env->startSection('title'); ?>
<?php echo e(trans('auth.password_recover')); ?> -
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">
        <h1 class="title-site title-sm"><?php echo e(trans('auth.password_recover')); ?></h1>
        <p class="subtitle-site"><strong><?php echo e($settings->title); ?></strong></p>
      </div>
    </div>
    
<div class="container-fluid margin-bottom-40">
	<div class="row">
		<div class="col-md-12">
			
			<h2 class="text-center line position-relative"><?php echo e(trans('auth.password_recover')); ?></h2>
	
	<div class="login-form">
		
		<?php if(session('status')): ?>
						<div class="alert alert-success">
							<?php echo e(session('status')); ?>

						</div>
					<?php endif; ?>

					
		<?php echo $__env->make('errors.errors-forms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	            	
          	<form action="<?php echo e(url('/password/email')); ?>" method="post" name="form" id="signup_form">
            <?php echo e(csrf_field()); ?>

            <div class="form-group has-feedback">
            	
              <input type="text" class="form-control login-field custom-rounded" name="email" id="email" placeholder="<?php echo e(trans('auth.email')); ?>" title="<?php echo e(trans('auth.email')); ?>" autocomplete="off">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
             </div>
         
           <button type="submit" id="buttonSubmit" class="btn btn-block btn-lg btn-main custom-rounded"><?php echo e(trans('auth.send')); ?></button>
				<a href="<?php echo e(url('login')); ?>" class="text-center btn-block margin-top-10 back_btn"><i class="fa fa-long-arrow-left"></i> <?php echo e(trans('auth.back')); ?></a>
          </form>
     </div><!-- Login Form -->
	
		</div><!-- col-md-12 -->
	</div><!-- row -->
</div><!-- container -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
	<script src="<?php echo e(asset('public/plugins/iCheck/icheck.min.js')); ?>"></script>
	
	<script type="text/javascript">
	
	$('#email').focus();
	
	 $('#buttonSubmit').click(function(){
    	$(this).css('display','none');
    	$('.back_btn').css('display','none');
    	$('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
    });
    
    <?php if(count($errors) > 0): ?>
    	scrollElement('#dangerAlert');
    <?php endif; ?>

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>