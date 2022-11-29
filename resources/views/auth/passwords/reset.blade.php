@extends('app')

@section('content')

<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">
        <h1 class="title-site title-sm">{{{ trans('auth.reset_password') }}}</h1>
        <p class="subtitle-site"><strong>{{{$settings->title}}}</strong></p>
      </div>
    </div>
    
<div class="container-fluid margin-bottom-40">
	<div class="row">
		<div class="col-md-12">
			
			<h2 class="text-center line position-relative">{{{ trans('auth.reset_password') }}}</h2>
	
	<div class="login-form">

					
		@include('errors.errors-forms')
	            	
          	<form action="{{{ url('/password/reset') }}}" method="post" name="form" id="signup_form">
            
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group has-feedback">
              <input type="text" class="form-control login-field custom-rounded" name="email" id="email" value="{{{ old('email') }}}" placeholder="{{{ trans('auth.email') }}}" title="{{{ trans('auth.email') }}}" autocomplete="off">
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
             </div>
             
             <!-- FORM GROUP -->
         <div class="form-group has-feedback">
              <input type="password" class="form-control login-field custom-rounded" name="password" placeholder="{{{ trans('auth.password') }}}" title="{{{ trans('auth.password') }}}" autocomplete="off">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
         </div><!-- ./FORM GROUP -->
         
         <div class="form-group has-feedback">
			<input type="password" class="form-control" name="password_confirmation" placeholder="{{{ trans('auth.confirm_password') }}}" title="{{{ trans('auth.confirm_password') }}}" autocomplete="off">
			<span class="glyphicon glyphicon-log-in form-control-feedback"></span>
		</div>
         
           <button type="submit" id="buttonSubmit" class="btn btn-block btn-lg btn-main custom-rounded">{{{ trans('auth.reset_password') }}}</button>
          </form>
     </div><!-- Login Form -->
	
		</div><!-- col-md-12 -->
	</div><!-- row -->
</div><!-- container -->
@endsection

@section('javascript')
	<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}"></script>
	
	<script type="text/javascript">
	 $('#buttonSubmit').click(function(){
    	$(this).css('display','none');
    	$('<div class="btn-block text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw fa-loader"></i></div>').insertAfter('#signup_form');
    });
    
    @if (count($errors) > 0)
    	scrollElement('#dangerAlert');
    @endif

</script>
@endsection
