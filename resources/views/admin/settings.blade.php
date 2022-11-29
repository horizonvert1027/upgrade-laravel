@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{ trans('admin.admin') }}
            	<i class="fa fa-angle-right margin-separator"></i>
            		{{ trans('admin.general_settings') }}

          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

        	 @if(Session::has('success_message'))
		    <div class="alert alert-success">
		    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
		       <i class="fa fa-check margin-separator"></i> {{ Session::get('success_message') }}
		    </div>
		@endif

        	<div class="content">

        		<div class="row">

        	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('admin.general_settings') }}</h3>
                </div><!-- /.box-header -->



                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/settings') }}" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">

					@include('errors.errors-forms')

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Website Name</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->sitename }}" name="sitename" class="form-control" placeholder="Website Name">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.name_site') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->title }}" name="title" class="form-control" placeholder="{{ trans('admin.title') }}">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.welcome_subtitle') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->welcome_subtitle }}" name="welcome_subtitle" class="form-control" placeholder="{{ trans('admin.welcome_subtitle') }}">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.keywords') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->keywords }}" id="tagInput" name="keywords" class="form-control select2">
                        <p class="help-block">* {{ trans('misc.add_tags_guide') }}</p>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.description') }}</label>
                      <div class="col-sm-10">

                      	<textarea name="description" rows="4" id="description" class="form-control" placeholder="{{ trans('admin.description') }}">{{ $settings->description }}</textarea>
                      </div>
                    </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label">Facebook Username</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->facebook}}" name="facebook" class="form-control" placeholder="facebook username">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Twitter Username</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->twitter}}" name="twitter" class="form-control" placeholder="twitter username">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label">Instagram Username</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->instagram}}" name="instagram" class="form-control" placeholder="instagram username">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-2 control-label">Pinterest Username</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->pinterest}}" name="pinterest" class="form-control" placeholder="pinterest username">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Hot Searches</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->hotsearch}}" id="tagInputHot" name="hotsearch" class="form-control" placeholder="Hot Search">
                      <p class="help-block" style="margin-bottom: 0px;">It shows on Home Page below SearchBox</p>
                    </div>
                  </div>
              
                  <div class="form-group">
                    <label class="col-sm-2 control-label">What's Today</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->whatstoday1}}" name="whatstoday1" class="form-control" placeholder="What is Today?">
                    </div>
                  </div>
               
                  <div class="form-group">
                    <label class="col-sm-2 control-label">What's Today Link</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->whatstoday1link}}" name="whatstoday1link" class="form-control" placeholder="Whats Today SLUG?">
                      <p class="help-block" style="margin-bottom: 0px;">Enter the Subcategory slug only if it has images</p>
                    </div>
                  </div>
               
                  <div class="form-group">
                    <label class="col-sm-2 control-label">What's Today Editing</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->whatstoday}}" name="whatstoday" class="form-control" placeholder="What is Today?">
                    </div>
                  </div>
          
                  <div class="form-group">
                    <label class="col-sm-2 control-label">What's Today Editing Link</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->whatstodaylink}}" name="whatstodaylink" class="form-control" placeholder="Whats Today SLUG?">
                      <p class="help-block" style="margin-bottom: 0px;">Enter the Subcategory slug only if it has images</p>
                    </div>
                  </div>
               
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Home Files 1</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->homefiles1}}" name="homefiles1" class="form-control" placeholder="slug of the Sub Category">
                      <p class="help-block" style="margin-bottom: 0px;">Enter the Subcategory slug only if it has images</p>
                    </div>
                  </div>
               
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Home Files 2</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->homefiles2}}" name="homefiles2" class="form-control" placeholder="slug of the Sub Category">
                      <p class="help-block" style="margin-bottom: 0px;">Enter the Subcategory slug only if it has images</p>
                    </div>
                  </div>
               
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Captcha</label>
                      <div class="col-sm-10">

                      	<div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="captcha" @if( $settings->captcha == 'on' ) checked="checked" @endif value="on" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="captcha" @if( $settings->captcha == 'off' ) checked="checked" @endif value="off">
                          Off
                        </label>
                      </div>

                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Notification</label>
                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="notification" @if( $settings->notification == 'on' ) checked="checked" @endif value="on" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="notification" @if( $settings->notification == 'off' ) checked="checked" @endif value="off">
                          Off
                        </label>
                      </div>

                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.instacron_log') }}</label>
                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="instacron_log" @if( $settings->instacron_log == 'yes' ) checked="checked" @endif value="yes" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="instacron_log" @if( $settings->instacron_log == 'no' ) checked="checked" @endif value="no">
                          Off
                        </label>
                      </div>
                       <p class="help-block text-bold">* {{ trans('misc.instacronlog') }}</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.new_registrations') }}</label>
                      <div class="col-sm-10">

                      	<div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="registration_active" @if( $settings->registration_active == 1 ) checked="checked" @endif value="1" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="registration_active" @if( $settings->registration_active == 0 ) checked="checked" @endif value="0">
                          Off
                        </label>
                      </div>

                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.email_verification') }}</label>
                      <div class="col-sm-10">

                      	<div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="email_verification" @if( $settings->email_verification == 1 ) checked="checked" @endif value="1" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="email_verification" @if( $settings->email_verification == 0 ) checked="checked" @endif value="0">
                          Off
                        </label>
                      </div>

                      </div>
                    </div>
                  
                 
                    <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
               
                </form>
              </div>

        		</div><!-- /.row -->

        	</div><!-- /.content -->

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

	<!-- icheck -->
	<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
		//Flat red color scheme for iCheck
        $('input[type="radio"]').iCheck({
          radioClass: 'iradio_flat-red'
        });

        $("#tagInput").tagsInput({

		 'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
		 'width':'auto',
		 'height':'auto',
	     'removeWithBackspace' : true,
	     'minChars' : 3,
	     'maxChars' : 25,
	     'defaultText':'{{ trans("misc.add_tag") }}',
	     /*onChange: function() {
         	var input = $(this).siblings('.tagsinput');
         	var maxLen = 4;

			if( input.children('span.tag').length >= maxLen){
			        input.children('div').hide();
			    }
			    else{
			        input.children('div').show();
			    }
			},*/
	});

	</script>


@endsection
