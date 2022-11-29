<?php 
// ** Data User logged ** //
     $user = Auth::user();
	  ?>
@extends('app')

@section('title') {{ trans('users.delete_account') }} - @endsection

@section('content') 
<div class="jumbotron md index-header jumbotron_set jumbotron-cover">
      <div class="container wrap-jumbotron position-relative">
        <h1 class="title-site title-sm">{{ trans('users.delete_account') }}</h1>
      </div>
    </div>

<div class="container margin-bottom-40">
	
		<!-- Col MD -->
		<div class="col-md-12">
			<div class="wrap-center center-block">
				
				<div class="btn-block text-center margin-bottom-10">
	    			<i class="icon-warning ico-no-result"></i>
	    		</div>
	    		
				<h4 class="text-center">
					{{trans('misc.alert_delete_account')}}
				</h4>
				
				<form action="{{ url('account/delete') }}" method="post" name="form" class="margin-top-20">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="btn-block text-center">
						<button type="submit" id="buttonSubmit" class="btn btn-lg btn-main custom-rounded">{{ trans('misc.yes_confirm') }}</button>
             		  <a href="{{ url('account') }}" class="btn btn-default btn-lg custom-rounded">{{ trans('misc.cancel_confirm') }}</a>
					</div>
				</form>
            
		</div><!-- wrap center -->
		</div><!-- /COL MD -->
		
 </div><!-- container -->
 
 <!-- container wrap-ui -->
@endsection

