<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
<?php $__env->startSection('content'); ?> 
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="formcenter">
                <div class="mt20 mb35 forms">
                                   <div class="login-rgister">
                    <h1><?php echo e(trans('auth.sign_up')); ?></h1>
                        <div class="aligncenter" style="margin: 8px 0px 8px">
                            <img src="/public/svg/user.png" style="height: 60px;">
                        </div>
                    
                    
                              <?php echo $__env->make('errors.errors-forms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                              <?php if(session('login_required')): ?>
                                <div id="dangerAlert"><?php echo e(session('login_required')); ?>

                                </div>
                              <?php endif; ?>
                            <form action="<?php echo e(url('register')); ?>" method="post" name="form" id="signup_form">
                            
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                           
                              <!-- FORM GROUP -->
                              <input type="text" class="form-control login" value="" name="name" placeholder="Your Name" title="name" autocomplete="on">
                            <!-- ./FORM GROUP -->
                                  

                             <!-- FORM GROUP -->
                              <input type="text" class="form-control login" value="<?php echo e(old('email')); ?>" name="email" placeholder="<?php echo e(trans('auth.email')); ?>" title="<?php echo e(trans('auth.email')); ?>" autocomplete="on">
                              
                            <!-- ./FORM GROUP -->

                            <!-- FORM GROUP for Number-->
                            <div class="countrycodenumber">
                              <select name="phonecode" class="containerform countrycode">
                                <?php $__currentLoopData = App\Models\Countries::orderBy('country_name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="options" <?php if( 99 == $country->id ): ?> selected="selected" <?php endif; ?> value="<?php echo e($country->phonecode); ?>"><?php echo e($country->country_name); ?> (+<?php echo e($country->phonecode); ?>) </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                              <input class="form-control login numberc" 
                              type="number" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required name="numberm" placeholder="Enter Your 10 Digit Number" title="numberm" autocomplete="on"/>
                              
                            </div><!-- ./FORM GROUP -->
                        
                        <!-- FORM GROUP -->
                              <input type="text" class="form-control login" name="username" placeholder="<?php echo e(trans('auth.username')); ?>" title="<?php echo e(trans('auth.username')); ?>" autocomplete="off">
                              <span id="username_error"></span>
                       <!-- ./FORM GROUP -->

                         <!-- FORM GROUP -->
                              <input type="password" class="form-control login" name="password" placeholder="<?php echo e(trans('auth.password')); ?>" title="<?php echo e(trans('auth.password')); ?>" autocomplete="off">
                              
                         <!-- ./FORM GROUP -->
                         

                          <?php if( $settings->captcha == 'on' ): ?>    
                            
                              <input type="text" class="form-control login" name="captcha" id="lcaptcha" placeholder="" title="">
                            
                              <div id="errorCaptcha" role="alert" style="display: none;">
                                <?php echo e(Lang::get('auth.error_captcha')); ?>

                              </div>
                            
                          <?php endif; ?>
                         
                           <button type="submit" id="buttonSubmitRegister" class="formbtn"><?php echo e(trans('auth.sign_up')); ?></button>

                     

                          
                          <div style="margin-top: 5px">
                            Once you register, you agree with our <a href="<?php echo e(config('app.urlname')); ?>/page/terms">Terms and Conditions
                          </a>
                          </div>
                            
                          </form>
                     
                    <strong><?php echo e(Lang::get('auth.already_have_an_account')); ?> <a href="<?php echo e(url('login')); ?>" class="signupbt"><?php echo e(trans('auth.login')); ?></a></strong>
                </div>   
                </div>
            </div>
        </div>
        </section>
   </div>               
<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
  
<script type="text/javascript">

$(document).ready(function(){

    $("input[name='username']").blur(function()
    {
        $("#username_error").removeClass("ierror").removeClass("ivalid");
        
        $("#username_error").html("Validating username...");
        var username = $(this).val();
        username = username.toLowerCase();
        $(this).val(username);

        var format = /[!@#$%^&*()+\~=\[\]{};':"\\|,<>\/?]+/;

        if( username.indexOf(" ") != -1 || 
            format.test(username))
        {
            $("#username_error").addClass("ierror").html("username cannot contain spaces or special chars.");
            return false;
        }

        var csrf = $("input[name='_token']").val();
        $.post("<?php echo url('validate');?>",{_token:csrf,username:username},function(data)
        {
            $("#username_error").removeClass("ierror").removeClass("ivalid");
            if( data == 'error')
            {
                $("#username_error").html("Data invalid. Try Again");
                $("#username_error").addClass("ierror");
            }
            else if( data == 1 )
            {
                $("#username_error").html("Username already taken, try another.");
                $("#username_error").addClass("ierror");    
            }
            else
            {
                $("#username_error").html("Username is available! ");
                $("#username_error").addClass("ivalid");
            }
        })
    });

});


 <?php if( $settings->captcha == 'on' ): ?>     
 /*
 *  ==============================================  Captcha  ============================== * /
 */
   var captcha_a = Math.ceil( Math.random() * 5 );
   var captcha_b = Math.ceil( Math.random() * 5 );
   var captcha_c = Math.ceil( Math.random() * 5 );
   var captcha_e = ( captcha_a + captcha_b ) - captcha_c;
  
    function generate_captcha( id ) {
      var id = ( id ) ? id : 'lcaptcha';
      $("#" + id ).html( captcha_a + " + " + captcha_b + " - " + captcha_c + " = ").attr({'placeholder' : captcha_a + " + " + captcha_b + " - " + captcha_c, title: 'Captcha = '+captcha_a + " + " + captcha_b + " - " + captcha_c });
    }
    $("input").attr('autocomplete','off');
    generate_captcha('lcaptcha');

$('#buttonSubmitRegister').click(function(e)
{
    e.preventDefault();

    if( $("#username_error").hasClass("ierror") )
    {
        return false;
    }

    var captcha        = $("#lcaptcha").val();
      if( captcha != captcha_e ){
        var error = true;
            $("#errorCaptcha").fadeIn(500);
            $('#lcaptcha').focus();
            return false;
          } else {
            $('.wrap-loader').show();
            $(this).css('display','none');
          $('.auth-social').css('display','none');
          $('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
          $('#signup_form').submit();
          }
    });
    
    <?php else: ?>
          
  $('#buttonSubmitRegister').click(function()
  {
      if( $("#username_error").hasClass("ierror") )
      {
        return false;
      }
      $('.wrap-loader').show();
      $(this).css('display','none');
      $('.auth-social').css('display','none');
      $('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
    });
    
    <?php endif; ?>
    
    <?php if(count($errors) > 0): ?>
      scrollElement('#dangerAlert');
    <?php endif; ?>
    
    <?php if(session('notification')): ?>
      $('#signup_form, #dangerAlert').remove();
    <?php endif; ?>

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>