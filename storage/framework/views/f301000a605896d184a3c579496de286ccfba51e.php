<?php 
	$trueProfile = true;
	$userID = $user->id;	
	if( $user->cover == '' ) {
		$cover = 'background: #232a29;';
	}	
	else 
	{
		$cover_image = url(config('path.covers').$user->cover);
		$cover = "background: url('".$cover_image."') no-repeat center center #232a29; background-size: cover;";
	}
	

?>


<?php $__env->startSection('content'); ?>

<?php $__env->startSection('OwnCss'); ?>
    <link rel="preload" href="/public/jscss/profile.css" as="style">
    <link rel="stylesheet" href="/public/jscss/profile.css">
<?php $__env->stopSection(); ?>
<div class="jumbotron profileUser index-header jumbotron_set jumbotron-cover-user" style="<?php echo e($cover); ?>">

<div class="container wrap-jumbotron position-relative">	

<?php if( Auth::check() && Auth::user()->id == $user->id ): ?>	
	<!-- *********** COVER ************* -->  
      <form class="pull-left myicon-right position-relative" style="z-index: 100;" action="<?php echo e(url('upload/cover')); ?>" method="POST" id="formCover" accept-charset="UTF-8" enctype="multipart/form-data">
    		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<button type="button" class="btn btn-default" id="cover_file" style="margin-top: 10px;">
	    		<i class="icon-camera myicon-right"></i> <?php echo e(trans('misc.change_cover')); ?>

	    		</button>
	    		 <input type="file" name="photo" id="uploadCover" accept="image/*" style="visibility: hidden;">
			</form><!-- *********** COVER ************* -->

			<?php endif; ?>
			</div>
    </div>

<div class="container margin-bottom-40 margin-top-40">
	
	<div class="row"></div>
<!-- Col MD -->
<div class="col-md-12">	

	<div class="center-block text-center profile-user-over">
		
		<a href="<?php echo e(url($user->username)); ?>">
        		<img src="<?php echo e($thumbimage); ?>" width="125" height="125" class="img-circle border-avatar-profile avatarUser" />
        		
        		</a> 
        		
        <h1 class="title-item none-overflow font-default">
		        		<?php if( $user->name != '' ): ?>
		        		
		        		<h2 style="font-size: 27px;
    font-weight: 600;"><?php echo e(e( $user->name )); ?> 


<?php if( $user->role == 'admin' ): ?>	

    <div class="tooltip">
    <img  src="<?php echo e(url(config('path.svg'))); ?>/verified.svg" width="40px" style="margin-top: -5px;border: none;
    width: 30px;" class="img-circle" />
  <span class="tooltiptext">Verified</span>
</div>

<?php endif; ?>
</h2>
		        		
		        		<small class="text-muted"><?php echo e('@'.$user->username); ?></small>
		        		
		        		<?php else: ?>
		        		
		        		<?php echo e(e( $user->username )); ?>

		        		
		        		<?php endif; ?>
		        	</h1>
        
        
<?php if( Auth::check() && Auth::user()->id == $user->id ): ?>
	<!-- *********** AVATAR ************* -->  
      <form action="<?php echo e(url('upload/avatar')); ?>" method="POST" id="formAvatar" accept-charset="UTF-8" enctype="multipart/form-data">
    		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<button type="button" class="btn btn-default" id="avatar_file" style="margin-top: 10px;">
	    		<i class="icon-camera myicon-right"></i> <?php echo e(trans('misc.change_avatar')); ?>

	    		</button>
	    		 <input type="file" name="photo" id="uploadAvatar" accept="image/*" style="visibility: hidden;">
			</form><!-- *********** AVATAR ************* -->
			<?php endif; ?>
		
	    			
	    	
<div class="main-wrapper">
      <?php if( $user->userlevel > 0 ): ?>
		  <div class="badge yellow">
		    <div class="circle"> <i class="fa fa-bolt"></i></div>
		    <div class="ribbon">Level 1</div>
		  </div>
      <?php else: ?>
      <div class="badge yellow disable">
        <div class="circle"> <i class="fa fa-bolt"></i></div>
        <div class="ribbon disable">Level 1</div>
      </div>
      <?php endif; ?>

      <?php if( $user->userlevel > 1 ): ?>
		  <div class="badge orange">
		    <div class="circle"> <i class="fa fa-bookmark-o"></i></div>
		    <div class="ribbon">Level 2</div>
		  </div>
      <?php else: ?>
      <div class="badge orange disable">
        <div class="circle"> <i class="fa fa-bookmark-o"></i></div>
        <div class="ribbon disable">Level 2</div>
      </div>
      <?php endif; ?>      

      <?php if( $user->userlevel > 2 ): ?>
		  <div class="badge purple">
		    <div class="circle"> <i class="fa fa-lightbulb-o"></i></div>
		    <div class="ribbon">Level 3</div>
		  </div>
      <?php else: ?>
      <div class="badge purple disable">
        <div class="circle"> <i class="fa fa-lightbulb-o"></i></div>
        <div class="ribbon disable">Level 3</div>
      </div>
      <?php endif; ?>      

      <?php if( $user->userlevel > 3 ): ?>
		  <div class="badge green-dark">
		    <div class="circle"> <i class="fa fa-trophy"></i></div>
		    <div class="ribbon">Level 4</div>
		  </div>
      <?php else: ?>
      <div class="badge green-dark disable">
        <div class="circle"> <i class="fa fa-trophy"></i></div>
        <div class="ribbon disable">Level 4</div>
      </div>
      <?php endif; ?>  		
		  
</div>


<?php if( Auth::check() && $user->id != Auth::user()->id ): ?>	
<!-- <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#reportUser" title="<?php echo e(trans('misc.report')); ?>"><i class="fa fa-flag"></i></a> -->
	    			 		<?php endif; ?>
    			    				
		<h4 class="text-bold line-sm position-relative font-family-primary font-default text-muted" style="text-decoration: underline;"><?php if( $user->role == 'admin' ): ?>	(Content Manager) <?php else: ?> About <?php endif; ?></h4>
    						   
		   	 <small class="center-block subtitle-user">
      		 	<?php echo e(trans('misc.member_since')); ?> <?php echo e(date('M d, Y', strtotime($user->date) )); ?>

      		 	</small>
      		 	
      		 <?php if( $user->countries_id != '' ): ?>	
      		 	<small class="center-block subtitle-user">
      		 		<i class="fa fa-map-marker myicon-right"></i> <?php echo e($user->country()->country_name); ?>

      		 	</small>
      		 	<?php endif; ?>
                   
           <?php if( $user->bio != '' ): ?>
           <h4 class="text-center bio-user none-overflow" style="    margin-top: 1px;"><?php echo e(e($user->bio)); ?></h4>
           <?php endif; ?>
           
        <div class="fkamal">

  
  <?php if( $user->twitter != '' ): ?> <a class="ictweet" href="<?php echo e(e( $user->twitter )); ?>" target="_blank"></a> <?php endif; ?>
  <?php if( $user->instagram != '' ): ?><a class="icig" href="<?php echo e(e( $user->instagram )); ?>" target="_blank"></a><?php endif; ?>
  <?php if( $user->facebook != '' ): ?><a class="icfb" href="<?php echo e(e( $user->facebook )); ?>" target="_blank"></a><?php endif; ?>
  <?php if( $user->website != '' ): ?><a class="ichome" href="<?php echo e(e( $user->website )); ?>" target="_blank"></a><?php endif; ?>

</div>

			             
	   <ul style="display:none" class="nav nav-pills inlineCounterProfile justify-list-center">
        	  
        	  <li>
        	  	<small class="btn-block sm-btn-size text-left counter-sm"><?php echo e(App\Helper::formatNumber($user->images()->count())); ?></small>
        	  	<span class="text-muted">Files</span>
        	  </li><!-- End Li -->
        	 
        	 <?php if( Auth::check() && Auth::user()->id == $user->id ): ?> 
        	  <li>
        	  	<small class="btn-block sm-btn-size text-left counter-sm"><?php echo e(App\Helper::formatNumber($user->images_pending()->count())); ?></small>
        	  	<a href="<?php echo e(url( 'photos/pending')); ?>" class="text-muted link-nav-user">Stocks</a>
        	  </li><!-- End Li -->
        	  <?php endif; ?>
        	  
        	 
    			
    	</ul>
           
	</div><!-- Center Div -->

<hr />

	<?php if( $images->total() != 0 ): ?>	

<div class="flex-images imagesFlex2 dataResult">
	     <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	     
	     <?php if( $images->count() != 0  ): ?>   
			    <div class="container-paginator">
			    	<?php echo e($images->links()); ?>

			    	</div>	
			    	<?php endif; ?>
	     
	     </div><!-- Image Flex -->
	     			    		 
	  <?php else: ?>
	  
	  <?php endif; ?>

 </div><!-- /COL MD -->
 </div><!-- row -->

<?php if( Auth::check() && $user->id != Auth::user()->id && $user->paypal_account != '' || Auth::guest()  && $user->paypal_account != '' ): ?> 
 <form id="form_pp" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"  style="display:none">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="return" value="<?php echo e(url($user->username)); ?>">
    <input type="hidden" name="cancel_return"   value="<?php echo e(url($user->username)); ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="item_name" value="<?php echo e(trans('misc.support').' @'.$user->username); ?> - <?php echo e($settings->title); ?>" >
    <input type="hidden" name="business" value="<?php echo e($user->paypal_account); ?>">
    <input type="submit">
</form>
<?php endif; ?>

<?php if( Auth::check() ): ?>
<div style="display:none" class="modal fade" id="reportUser" tabindex="-1" role="dialog" aria-hidden="true">
     		<div class="modal-dialog modal-sm">
     			<div class="modal-content"> 
     				<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel">
				        	<strong><?php echo e(trans('misc.report')); ?></strong>
				        	</h4>
				     </div><!-- Modal header -->
				     
				      <div class="modal-body listWrap">
				    
				    <!-- form start -->
			    <form method="POST" action="<?php echo e(url('report/user')); ?>" enctype="multipart/form-data" id="formReport">
			    	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			    	<input type="hidden" name="id" value="<?php echo e($user->id); ?>">  	
				    <!-- Start Form Group -->
                    <div class="form-group">
                      <label><?php echo e(trans('admin.reason')); ?></label>
                      	<select name="reason" class="form-control">
                      		<option value="spoofing"><?php echo e(trans('admin.spoofing')); ?></option>
                            <option value="copyright"><?php echo e(trans('admin.copyright')); ?></option>
                            <option value="privacy_issue"><?php echo e(trans('admin.privacy_issue')); ?></option>
                            <option value="violent_sexual_content"><?php echo e(trans('admin.violent_sexual_content')); ?></option>
                          </select>
                               
                  </div><!-- /.form-group-->
                  
                   <button type="submit" class="btn btn-sm btn-danger reportUser"><?php echo e(trans('misc.report')); ?></button>
                   
                    </form>

				      </div><!-- Modal body -->
     				</div><!-- Modal content -->
     			</div><!-- Modal dialog -->
     		</div><!-- Modal -->
     		<?php endif; ?>
 
 <!-- container wrap-ui -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<?php echo $__env->make('includes.javascript_general', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
        		var ajaxlink = '<?php echo e(url("/")); ?>/ajax/user/images?id=<?php echo e($user->id); ?>&page=';

$('#btnFormPP').click(function(e){
	$('#form_pp').submit();
});
		 
<?php if( Auth::check() && Auth::user()->id == $user->id ): ?>

	//<<<<<<<=================== * UPLOAD AVATAR  * ===============>>>>>>>//
    $(document).on('change', '#uploadAvatar', function(){
    
    $('.wrap-loader').show();
    
   (function(){
	 $("#formAvatar").ajaxForm({
	 dataType : 'json',	
	 success:  function(e){
	 if( e ){
        if( e.success == false ){
		$('.wrap-loader').hide();
		
		var error = '';
                        for($key in e.errors){
                        	error += '' + e.errors[$key] + '';
                        }
		swal({   
    			title: "<?php echo e(trans('misc.error_oops')); ?>",   
    			text: ""+ error +"",   
    			type: "error",   
    			confirmButtonText: "<?php echo e(trans('users.ok')); ?>" 
    			});
		
			$('#uploadAvatar').val('');

		} else {
			
			$('#uploadAvatar').val('');
			$('.avatarUser').attr('src',e.avatar);
			$('.wrap-loader').hide();
		}
		
		}//<-- e
			else {
				$('.wrap-loader').hide();
				swal({   
    			title: "<?php echo e(trans('misc.error_oops')); ?>",   
    			text: '<?php echo e(trans("misc.error")); ?>',   
    			type: "error",   
    			confirmButtonText: "<?php echo e(trans('users.ok')); ?>" 
    			});
    			
				$('#uploadAvatar').val('');
			}
		   }//<----- SUCCESS
		}).submit();
    })(); //<--- FUNCTION %
});//<<<<<<<--- * ON * --->>>>>>>>>>>
//<<<<<<<=================== * UPLOAD AVATAR  * ===============>>>>>>>//

//<<<<<<<=================== * UPLOAD COVER  * ===============>>>>>>>//
$(document).on('change', '#uploadCover', function(){
    
    $('.wrap-loader').show();
    
   (function(){
	 $("#formCover").ajaxForm({
	 dataType : 'json',	
	 success:  function(e){
	 if( e ){
        if( e.success == false ){
		$('.wrap-loader').hide();
		
		var error = '';
                        for($key in e.errors){
                        	error += '' + e.errors[$key] + '';
                        }
		swal({   
    			title: "<?php echo e(trans('misc.error_oops')); ?>",   
    			text: ""+ error +"",   
    			type: "error",   
    			confirmButtonText: "<?php echo e(trans('users.ok')); ?>" 
    			});
		
			$('#uploadCover').val('');

		} else {
			
			$('#uploadCover').val('');
			
			$('.jumbotron-cover-user').css({ background: 'url("'+e.cover+'") center center #232a29','background-size': 'cover' });;
			$('.wrap-loader').hide();
		}
		
		}//<-- e
			else {
				$('.wrap-loader').hide();
				swal({   
    			title: "<?php echo e(trans('misc.error_oops')); ?>",   
    			text: '<?php echo e(trans("misc.error")); ?>',   
    			type: "error",   
    			confirmButtonText: "<?php echo e(trans('users.ok')); ?>" 
    			});
    			
				$('#uploadCover').val('');
			}
		   }//<----- SUCCESS
		}).submit();
    })(); //<--- FUNCTION %
});//<<<<<<<--- * ON * --->>>>>>>>>>>
//<<<<<<<=================== * UPLOAD COVER  * ===============>>>>>>>//

<?php endif; ?>
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/users/profile.blade.php ENDPATH**/ ?>