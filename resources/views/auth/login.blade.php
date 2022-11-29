@extends('layouts.multi')

<link href="{{ asset('public/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/public/jscss/form.css">
<style>.login-rgister {
    margin-top: 23% !important
}
</style>

@section('content') 
    <div class="container">
        <section>
            <div class="col-md-12">
            	<div class="formcenter">
                <div class="mt20 mb35 forms">
                       
                            <div class="login-rgister">

     						<h1>{{ trans('auth.login') }}</h1>
        							<div class="aligncenter" style="margin: 8px 0px 8px">
									<img src="/public/svg/user.png" style="height: 60px;">
								</div>
								@include('errors.errors-forms')
											@if (session('login_required'))
						            	{{ session('login_required') }}
						          @endif
     							
							      	<form action="{{ url('login') }}" method="post" name="form" id="signup_form">
							          @csrf
							      		<input type="hidden" name="_token" value="{{ csrf_token() }}">
							          	<input type="text" class="form-control login" value="{{ old('email') }}" name="email" id="email" placeholder="Email" title="{{ trans('auth.username_or_email') }}" autocomplete="on">

								        <input type="password" class="form-control login" name="password" id="password" placeholder="{{ trans('auth.password') }}" title="{{ trans('auth.password') }}" autocomplete="on">

								        <button class="formbtn" type="submit" id="buttonSubmit">{{ trans('auth.sign_in') }}</button><a href="{{url('password/reset')}}" style="margin-top:5px">
												{{ trans('auth.forgot_password') }}</a>
							     	</form>		
     						 	
									@if( $settings->registration_active == 1 )	 
										<strong>{{ Lang::get('auth.not_have_account') }}</strong>
										<b>
											<a class="signupbt" href="{{ url('register') }}">{{ trans('auth.sign_up') }}</a>
										</b>
									@endif
						</div>
                     
                </div>
           </div>
            </div>
        </section>
   </div>               
@endsection


@section('javascript')
	<script type="text/javascript">
	$('#email').focus();
	$('#buttonSubmit').click(function(){
    	$(this).css('display','none');
    	$('.auth-social').css('display','none');
    	$('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
    });
    
    
	
	@if (count($errors) > 0)
    	scrollElement('#dangerAlert');
    @endif
</script>
@endsection
