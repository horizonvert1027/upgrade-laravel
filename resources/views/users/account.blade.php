<?php $user = Auth::user(); ?>
@extends('app')
@section('content')

<style type="text/css">
  .login-rgister{
    display: block;
    width: fit-content;
    margin: 15% auto;
    border: 2px solid var(--light-dark-clr);
    padding: 12px;
    border-radius: 12px;
    box-shadow: var(--tag-shadow);
    background: var(--light-white-clr);
  }
  .ibox.bsh.mt20 {
    background: transparent;
    box-shadow: none;
}
button#buttonSubmit {
    background: var(--link-clr);
    margin-top: 8px;
}
@media (min-width: 650px){
.login-rgister{
margin: 0% auto 0%
  }
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
    border: 1px solid var(--btn-clr);
    background: var(--box-clr);
    color: var(--black-clr);    width: 100% !important;
  }
  form{
    display: inline-grid;
  }



select.form-control {
    width: -webkit-fill-available;
}
</style>


<div class="container">
<section>
<div class="col-md-12">
<div class="ibox bsh mt20">
<div class="login-rgister">
  <h1 class="title-site title-sm">{{ trans('users.account_settings') }}</h1>
	<div class="wrap-center center-block">
			@include('errors.errors-forms')

			

		<!-- ***** FORM ***** -->
       <form action="{{ url('account') }}" method="post" name="form">

          	<input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
        	<div class="col-md-6">
	           	<!-- ***** Form Group ***** -->
	            <div class="form-group has-feedback">
	            	<label class="font-default">{{ trans('misc.full_name_misc') }}</label>
	              <input type="text" class="form-control login-field custom-rounded" value="{{ e( $user->name ) }}" name="full_name" placeholder="{{ trans('misc.full_name_misc') }}" title="{{ trans('misc.full_name_misc') }}" autocomplete="off">
	             </div><!-- ***** Form Group ***** -->
           </div><!-- End Col MD-->


            <div class="col-md-6">
            	<!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">{{ trans('auth.email') }}</label>
              <input type="email" class="form-control login-field custom-rounded" value="{{$user->email}}" name="email" placeholder="{{ trans('auth.email') }}" title="{{ trans('auth.email') }}" autocomplete="off">
         </div><!-- ***** Form Group ***** -->
            </div><!-- End Col MD-->

        </div><!-- End row -->

			<div class="row">

				<div class="col-md-6">
					<!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">{{ trans('misc.username_misc') }}</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->username}}" name="username" placeholder="{{ trans('misc.username_misc') }}" title="{{ trans('misc.username_misc') }}" autocomplete="off">
         </div><!-- ***** Form Group ***** -->
				</div><!-- End Col MD-->
        
				<div class="col-md-6">
            <div class="form-group has-feedback">
              <label class="font-default">{{ trans('misc.country') }}</label>
              <div class="containerform">
              <select style="padding: 8px;" name="countries_id" class="form-control login-field" >
                <option value="">{{trans('misc.select_your_country')}}</option>
                @foreach(  App\Models\Countries::orderBy('country_name')->get() as $country )
                  <option @if( $user->countries_id == $country->id ) selected="selected" @endif value="{{$country->id}}">{{ $country->country_name }}</option>
            @endforeach
                          </select></div>
                  </div><!-- ***** Form Group ***** -->
				</div><!-- End Col MD-->

			</div><!-- End row -->   

        <div class="form-group has-feedback">
              <label class="font-default">Number</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->numberm}}" name="numberm" placeholder="https://www.twitter.com/username" title="https://www.twitter.com/Username" autocomplete="off">
         </div>

			

         <!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">{{ trans('misc.website_misc') }}</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->website}}" name="website" placeholder="{{ trans('misc.website_misc') }}" title="{{ trans('misc.website_misc') }}" autocomplete="off">
         </div><!-- ***** Form Group ***** -->

         <!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">Facebook</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->facebook}}" name="facebook" placeholder="https://www.facebook.com/username" title="https://www.facebook.com/Username" autocomplete="off">
         </div><!-- ***** Form Group ***** -->

         <!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">Twitter</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->twitter}}" name="twitter" placeholder="https://www.twitter.com/username" title="https://www.twitter.com/Username" autocomplete="off">
         </div><!-- ***** Form Group ***** -->

          

         <!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">Instagram</label>
              <input type="text" class="form-control login-field custom-rounded" value="{{$user->instagram}}" name="instagram" placeholder="https://instagram.com/username" title="https://instagram.com/username" autocomplete="off">
         </div><!-- ***** Form Group ***** -->

         <!-- ***** Form Group ***** -->
            <div class="form-group has-feedback">
            	<label class="font-default">{{ trans('misc.description') }}</label>
            	<textarea name="description" rows="4" id="bio" class="login-field custom-rounded" style="width: 100%;
    border-radius: 14px;
    border: 1px solid #00000029;
    padding: 10px 20px 10px;
    font-size: 17px">{{ e( $user->bio ) }}</textarea>
         </div><!-- ***** Form Group ***** -->

          <a href="{{ url('account/password') }}" class="list-group-item font-default @if(Request::is('account/password'))active @endif"> 
        <i class="fa fa-lock myicon-right"></i>Change Password</a>

           <button type="submit" id="buttonSubmit" class="btn btn-block btn-lg btn-main custom-rounded">{{ trans('misc.save_changes') }}</button>

         @if( $user->id != 1 )
           <div class="btn-block text-center margin-top-20">
           		<a href="{{url('account/delete')}}" class="text-danger">{{trans('users.delete_account')}}</a>
           </div>
           @endif

       </form><!-- ***** END FORM ***** -->

</div>
</div>
</div>
</div>
</section>
</div>
@endsection
