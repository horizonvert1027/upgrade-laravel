@extends('layouts.multi')
<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
@section('content') 
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="formcenter">
                <div class="mt20 mb35 forms">
                                   <div class="login-rgister">
                    <h1>{{{ trans('auth.sign_up') }}}</h1>
                        <div class="aligncenter" style="margin: 8px 0px 8px">
                            <img src="/public/svg/user.png" style="height: 60px;">
                        </div>
                    
                    
                              @include('errors.errors-forms')
                              @if (session('login_required'))
                                <div id="dangerAlert">{{ session('login_required') }}
                                </div>
                              @endif
                            <form action="{{{ url('register') }}}" method="post" name="form" id="signup_form">
                            
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                           
                              <!-- FORM GROUP -->
                              <input type="text" class="form-control login" value="" name="name" placeholder="Your Name" title="name" autocomplete="on">
                            <!-- ./FORM GROUP -->
                                  

                             <!-- FORM GROUP -->
                              <input type="text" class="form-control login" value="{{{ old('email') }}}" name="email" placeholder="{{{ trans('auth.email') }}}" title="{{{ trans('auth.email') }}}" autocomplete="on">
                              
                            <!-- ./FORM GROUP -->

                            <!-- FORM GROUP for Number-->
                            <div class="countrycodenumber">
                              <select name="phonecode" class="containerform countrycode">
                                @foreach( App\Models\Countries::orderBy('country_name')->get() as $country )
                                    <option class="options" @if( 99 == $country->id ) selected="selected" @endif value="{{$country->phonecode}}">{{ $country->country_name }} (+{{$country->phonecode}}) </option>
                                @endforeach
                              </select>
                              <input class="form-control login numberc" 
                              type="number" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required name="numberm" placeholder="Enter Your 10 Digit Number" title="numberm" autocomplete="on"/>
                              
                            </div><!-- ./FORM GROUP -->
                        
                        <!-- FORM GROUP -->
                              <input type="text" class="form-control login" name="username" placeholder="{{{ trans('auth.username') }}}" title="{{{ trans('auth.username') }}}" autocomplete="off">
                              <span id="username_error"></span>
                       <!-- ./FORM GROUP -->

                         <!-- FORM GROUP -->
                              <input type="password" class="form-control login" name="password" placeholder="{{{ trans('auth.password') }}}" title="{{{ trans('auth.password') }}}" autocomplete="off">
                              
                         <!-- ./FORM GROUP -->
                         

                          @if( $settings->captcha == 'on' )    
                            
                              <input type="text" class="form-control login" name="captcha" id="lcaptcha" placeholder="" title="">
                            
                              <div id="errorCaptcha" role="alert" style="display: none;">
                                {{Lang::get('auth.error_captcha')}}
                              </div>
                            
                          @endif
                         
                           <button type="submit" id="buttonSubmitRegister" class="formbtn">{{{ trans('auth.sign_up') }}}</button>

                     

                          
                          <div style="margin-top: 5px">
                            Once you register, you agree with our <a href="{{config('app.urlname')}}/page/terms">Terms and Conditions
                          </a>
                          </div>
                            
                          </form>
                     
                    <strong>{{ Lang::get('auth.already_have_an_account') }} <a href="{{{ url('login') }}}" class="signupbt">{{{ trans('auth.login') }}}</a></strong>
                </div>   
                </div>
            </div>
        </div>
        </section>
   </div>               
@endsection


@section('javascript')
  
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


 @if( $settings->captcha == 'on' )     
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
    
    @else
          
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
    
    @endif
    
    @if (count($errors) > 0)
      scrollElement('#dangerAlert');
    @endif
    
    @if (session('notification'))
      $('#signup_form, #dangerAlert').remove();
    @endif

</script>


@endsection
