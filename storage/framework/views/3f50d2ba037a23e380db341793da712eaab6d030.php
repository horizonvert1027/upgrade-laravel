

<link href="<?php echo e(asset('public/plugins/iCheck/all.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
<style>.login-rgister {
    margin-top: 23% !important
}
</style>

<?php $__env->startSection('content'); ?> 
    <div class="container">
        <section>
            <div class="col-md-12">
            	<div class="formcenter">
                <div class="mt20 mb35 forms">
                       
                            <div class="login-rgister">

     						<h1><?php echo e(trans('auth.login')); ?></h1>
        							<div class="aligncenter" style="margin: 8px 0px 8px">
									<img src="/public/svg/user.png" style="height: 60px;">
								</div>
								<?php echo $__env->make('errors.errors-forms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
											<?php if(session('login_required')): ?>
						            	<?php echo e(session('login_required')); ?>

						          <?php endif; ?>
     							
							      	<form action="<?php echo e(url('login')); ?>" method="post" name="form" id="signup_form">
							          <?php echo csrf_field(); ?>
							      		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
							          	<input type="text" class="form-control login" value="<?php echo e(old('email')); ?>" name="email" id="email" placeholder="Email" title="<?php echo e(trans('auth.username_or_email')); ?>" autocomplete="on">

								        <input type="password" class="form-control login" name="password" id="password" placeholder="<?php echo e(trans('auth.password')); ?>" title="<?php echo e(trans('auth.password')); ?>" autocomplete="on">

								        <button class="formbtn" type="submit" id="buttonSubmit"><?php echo e(trans('auth.sign_in')); ?></button><a href="<?php echo e(url('password/reset')); ?>" style="margin-top:5px">
												<?php echo e(trans('auth.forgot_password')); ?></a>
							     	</form>		
     						 	
									<?php if( $settings->registration_active == 1 ): ?>	 
										<strong><?php echo e(Lang::get('auth.not_have_account')); ?></strong>
										<b>
											<a class="signupbt" href="<?php echo e(url('register')); ?>"><?php echo e(trans('auth.sign_up')); ?></a>
										</b>
									<?php endif; ?>
						</div>
                     
                </div>
           </div>
            </div>
        </section>
   </div>               
<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
	<script type="text/javascript">
	$('#email').focus();
	$('#buttonSubmit').click(function(){
    	$(this).css('display','none');
    	$('.auth-social').css('display','none');
    	$('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
    });
    
    
	
	<?php if(count($errors) > 0): ?>
    	scrollElement('#dangerAlert');
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>