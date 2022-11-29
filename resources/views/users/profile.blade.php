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

@extends('layouts.multi')
@section('content')

@section('OwnCss')
    <link rel="preload" href="/public/jscss/profile.css" as="style">
    <link rel="stylesheet" href="/public/jscss/profile.css">
@endsection
<div class="jumbotron profileUser index-header jumbotron_set jumbotron-cover-user" style="{{$cover}}">

<div class="container wrap-jumbotron position-relative">	

@if( Auth::check() && Auth::user()->id == $user->id )	
	<!-- *********** COVER ************* -->  
      <form class="pull-left myicon-right position-relative" style="z-index: 100;" action="{{url('upload/cover')}}" method="POST" id="formCover" accept-charset="UTF-8" enctype="multipart/form-data">
    		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="button" class="btn btn-default" id="cover_file" style="margin-top: 10px;">
	    		<i class="icon-camera myicon-right"></i> {{ trans('misc.change_cover') }}
	    		</button>
	    		 <input type="file" name="photo" id="uploadCover" accept="image/*" style="visibility: hidden;">
			</form><!-- *********** COVER ************* -->

			@endif
			</div>
    </div>

<div class="container margin-bottom-40 margin-top-40">
	
	<div class="row"></div>
<!-- Col MD -->
<div class="col-md-12">	

	<div class="center-block text-center profile-user-over">
		
		<a href="{{ url($user->username) }}">
        		<img src="{{$thumbimage}}" width="125" height="125" class="img-circle border-avatar-profile avatarUser" />
        		
        		</a> 
        		
        <h1 class="title-item none-overflow font-default">
		        		@if( $user->name != '' )
		        		
		        		<h2 style="font-size: 27px;
    font-weight: 600;">{{ e( $user->name ) }} 


@if( $user->role == 'admin' )	

    <div class="tooltip">
    <img  src="{{url(config('path.svg'))}}/verified.svg" width="40px" style="margin-top: -5px;border: none;
    width: 30px;" class="img-circle" />
  <span class="tooltiptext">Verified</span>
</div>

@endif
</h2>
		        		
		        		<small class="text-muted">{{ '@'.$user->username }}</small>
		        		
		        		@else
		        		
		        		{{ e( $user->username ) }}
		        		
		        		@endif
		        	</h1>
        
        
@if( Auth::check() && Auth::user()->id == $user->id )
	<!-- *********** AVATAR ************* -->  
      <form action="{{url('upload/avatar')}}" method="POST" id="formAvatar" accept-charset="UTF-8" enctype="multipart/form-data">
    		<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button type="button" class="btn btn-default" id="avatar_file" style="margin-top: 10px;">
	    		<i class="icon-camera myicon-right"></i> {{ trans('misc.change_avatar') }}
	    		</button>
	    		 <input type="file" name="photo" id="uploadAvatar" accept="image/*" style="visibility: hidden;">
			</form><!-- *********** AVATAR ************* -->
			@endif
		
	    			
	    	
<div class="main-wrapper">
      @if( $user->userlevel > 0 )
		  <div class="badge yellow">
		    <div class="circle"> <i class="fa fa-bolt"></i></div>
		    <div class="ribbon">Level 1</div>
		  </div>
      @else
      <div class="badge yellow disable">
        <div class="circle"> <i class="fa fa-bolt"></i></div>
        <div class="ribbon disable">Level 1</div>
      </div>
      @endif

      @if( $user->userlevel > 1 )
		  <div class="badge orange">
		    <div class="circle"> <i class="fa fa-bookmark-o"></i></div>
		    <div class="ribbon">Level 2</div>
		  </div>
      @else
      <div class="badge orange disable">
        <div class="circle"> <i class="fa fa-bookmark-o"></i></div>
        <div class="ribbon disable">Level 2</div>
      </div>
      @endif      

      @if( $user->userlevel > 2 )
		  <div class="badge purple">
		    <div class="circle"> <i class="fa fa-lightbulb-o"></i></div>
		    <div class="ribbon">Level 3</div>
		  </div>
      @else
      <div class="badge purple disable">
        <div class="circle"> <i class="fa fa-lightbulb-o"></i></div>
        <div class="ribbon disable">Level 3</div>
      </div>
      @endif      

      @if( $user->userlevel > 3 )
		  <div class="badge green-dark">
		    <div class="circle"> <i class="fa fa-trophy"></i></div>
		    <div class="ribbon">Level 4</div>
		  </div>
      @else
      <div class="badge green-dark disable">
        <div class="circle"> <i class="fa fa-trophy"></i></div>
        <div class="ribbon disable">Level 4</div>
      </div>
      @endif  		
		  
</div>


@if( Auth::check() && $user->id != Auth::user()->id )	
<!-- <a href="#" class="btn btn-sm btn-default" data-toggle="modal" data-target="#reportUser" title="{{trans('misc.report')}}"><i class="fa fa-flag"></i></a> -->
	    			 		@endif
    			    				
		<h4 class="text-bold line-sm position-relative font-family-primary font-default text-muted" style="text-decoration: underline;">@if( $user->role == 'admin' )	(Content Manager) @else About @endif</h4>
    						   
		   	 <small class="center-block subtitle-user">
      		 	{{ trans('misc.member_since') }} {{ date('M d, Y', strtotime($user->date) ) }}
      		 	</small>
      		 	
      		 @if( $user->countries_id != '' )	
      		 	<small class="center-block subtitle-user">
      		 		<i class="fa fa-map-marker myicon-right"></i> {{ $user->country()->country_name }}
      		 	</small>
      		 	@endif
                   
           @if( $user->bio != '' )
           <h4 class="text-center bio-user none-overflow" style="    margin-top: 1px;">{{ e($user->bio) }}</h4>
           @endif
           
        <div class="fkamal">

  
  @if( $user->twitter != '' ) <a class="ictweet" href="{{ e( $user->twitter ) }}" target="_blank"></a> @endif
  @if( $user->instagram != '' )<a class="icig" href="{{ e( $user->instagram ) }}" target="_blank"></a>@endif
  @if( $user->facebook != '' )<a class="icfb" href="{{ e( $user->facebook ) }}" target="_blank"></a>@endif
  @if( $user->website != '' )<a class="ichome" href="{{ e( $user->website ) }}" target="_blank"></a>@endif

</div>

			             
	   <ul style="display:none" class="nav nav-pills inlineCounterProfile justify-list-center">
        	  
        	  <li>
        	  	<small class="btn-block sm-btn-size text-left counter-sm">{{ App\Helper::formatNumber($user->images()->count()) }}</small>
        	  	<span class="text-muted">Files</span>
        	  </li><!-- End Li -->
        	 
        	 @if( Auth::check() && Auth::user()->id == $user->id ) 
        	  <li>
        	  	<small class="btn-block sm-btn-size text-left counter-sm">{{ App\Helper::formatNumber($user->images_pending()->count()) }}</small>
        	  	<a href="{{url( 'photos/pending')}}" class="text-muted link-nav-user">Stocks</a>
        	  </li><!-- End Li -->
        	  @endif
        	  
        	 
    			
    	</ul>
           
	</div><!-- Center Div -->

<hr />

	@if( $images->total() != 0 )	

<div class="flex-images imagesFlex2 dataResult">
	     @include('includes.imageslazy')
	     
	     @if( $images->count() != 0  )   
			    <div class="container-paginator">
			    	{{ $images->links() }}
			    	</div>	
			    	@endif
	     
	     </div><!-- Image Flex -->
	     			    		 
	  @else
	  
	  @endif

 </div><!-- /COL MD -->
 </div><!-- row -->

@if( Auth::check() && $user->id != Auth::user()->id && $user->paypal_account != '' || Auth::guest()  && $user->paypal_account != '' ) 
 <form id="form_pp" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"  style="display:none">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="return" value="{{url($user->username)}}">
    <input type="hidden" name="cancel_return"   value="{{url($user->username)}}">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="item_name" value="{{trans('misc.support').' @'.$user->username}} - {{$settings->title}}" >
    <input type="hidden" name="business" value="{{$user->paypal_account}}">
    <input type="submit">
</form>
@endif

@if( Auth::check() )
<div style="display:none" class="modal fade" id="reportUser" tabindex="-1" role="dialog" aria-hidden="true">
     		<div class="modal-dialog modal-sm">
     			<div class="modal-content"> 
     				<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title text-center" id="myModalLabel">
				        	<strong>{{ trans('misc.report') }}</strong>
				        	</h4>
				     </div><!-- Modal header -->
				     
				      <div class="modal-body listWrap">
				    
				    <!-- form start -->
			    <form method="POST" action="{{ url('report/user') }}" enctype="multipart/form-data" id="formReport">
			    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
			    	<input type="hidden" name="id" value="{{ $user->id }}">  	
				    <!-- Start Form Group -->
                    <div class="form-group">
                      <label>{{ trans('admin.reason') }}</label>
                      	<select name="reason" class="form-control">
                      		<option value="spoofing">{{ trans('admin.spoofing') }}</option>
                            <option value="copyright">{{ trans('admin.copyright') }}</option>
                            <option value="privacy_issue">{{ trans('admin.privacy_issue') }}</option>
                            <option value="violent_sexual_content">{{ trans('admin.violent_sexual_content') }}</option>
                          </select>
                               
                  </div><!-- /.form-group-->
                  
                   <button type="submit" class="btn btn-sm btn-danger reportUser">{{ trans('misc.report') }}</button>
                   
                    </form>

				      </div><!-- Modal body -->
     				</div><!-- Modal content -->
     			</div><!-- Modal dialog -->
     		</div><!-- Modal -->
     		@endif
 
 <!-- container wrap-ui -->
@endsection

@section('javascript')
@include('includes.javascript_general')
<script type="text/javascript">
        		var ajaxlink = '{{ url("/") }}/ajax/user/images?id={{$user->id}}&page=';

$('#btnFormPP').click(function(e){
	$('#form_pp').submit();
});
		 
@if( Auth::check() && Auth::user()->id == $user->id )

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
    			title: "{{ trans('misc.error_oops') }}",   
    			text: ""+ error +"",   
    			type: "error",   
    			confirmButtonText: "{{ trans('users.ok') }}" 
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
    			title: "{{ trans('misc.error_oops') }}",   
    			text: '{{trans("misc.error")}}',   
    			type: "error",   
    			confirmButtonText: "{{ trans('users.ok') }}" 
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
    			title: "{{ trans('misc.error_oops') }}",   
    			text: ""+ error +"",   
    			type: "error",   
    			confirmButtonText: "{{ trans('users.ok') }}" 
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
    			title: "{{ trans('misc.error_oops') }}",   
    			text: '{{trans("misc.error")}}',   
    			type: "error",   
    			confirmButtonText: "{{ trans('users.ok') }}" 
    			});
    			
				$('#uploadCover').val('');
			}
		   }//<----- SUCCESS
		}).submit();
    })(); //<--- FUNCTION %
});//<<<<<<<--- * ON * --->>>>>>>>>>>
//<<<<<<<=================== * UPLOAD COVER  * ===============>>>>>>>//

@endif
</script>

@endsection