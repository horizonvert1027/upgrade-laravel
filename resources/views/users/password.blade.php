<?php $user = Auth::user(); ?>
@extends('app')

@section('title') {{ trans('auth.password') }} - @endsection

@section('content') 
<style>
#username_error{
width: 100%;
display: block;
font-size: 12px;
text-align: center;
margin-top: 1px;
}
.ierror{
color: red;
}
.ivalid{
color: green;
}

.login-rgister{
display: block;
width: fit-content;
margin: 8% auto;
border: 2px solid var(--light-dark-clr);
padding: 25px;
border-radius: 12px;
box-shadow: var(--tag-shadow);
background: var(--light-white-clr);
}
.ibox.bsh.mt20 {
background: transparent;
box-shadow: none;
}
button#buttonSubmitRegister {
background: var(--link-clr);
margin-top: 8px;
}
.forml {
display: block;
width: fit-content;
margin: 0 auto;
}
.login-field {
padding: 8px;
border-radius: 5px;
margin: 3px 0px;
border: var(--border);
background: var(--box-clr);
color: var(--black-clr);    width: 100% !important;
}
form{
display: inline-grid;
}

</style>
<div class="container">
<section>
<div class="col-md-12">
<div class="ibox bsh mt20">
<div class="login-rgister">

        <h1 class="title-site title-sm">{{ trans('auth.password') }}</h1>
     

			
	@if (Session::has('notification'))
         <div style="color:green">{{ Session::get('notification') }}</div>
      @endif
            	
      @if (Session::has('incorrect_pass'))
         <div style="color:red">Old Password entered is not correct</div>	
      @endif
            	
			@include('errors.errors-forms')	
			<div class="forml">
       <form action="{{ url('account/password') }}" method="post" name="form">
          	<input type="hidden" name="_token" value="{{ csrf_token() }}">
            	<label class="font-default">{{ trans('misc.old_password') }}</label>
              <input type="password" class="form-control login-field" name="old_password" placeholder="{{ trans('misc.old_password') }}" title="{{ trans('misc.old_password') }}" autocomplete="off">
            	<label class="font-default">{{ trans('misc.new_password') }}</label>
              <input type="password" class="form-control login-field" name="password" placeholder="{{ trans('misc.new_password') }}" title="{{ trans('misc.new_password') }}" autocomplete="off">

           		<button type="submit" id="buttonSubmit" class="btn btn-block btn-lg btn-main custom-rounded">{{ trans('misc.save_changes') }}</button>
       </form>
     </div>
		</div>
		</div>
 </div>
</section>
</div>
@endsection

