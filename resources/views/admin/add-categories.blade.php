@extends('admin.layout')

@section('css')
<link href="{{{ asset('public/plugins/iCheck/all.css') }}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{{ trans('admin.admin') }}}
            	<i class="fa fa-angle-right margin-separator"></i>
            		{{{ trans('misc.categories') }}}
            			<i class="fa fa-angle-right margin-separator"></i>
            				{{{ trans('misc.add_new') }}}
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

        	<div class="content">

        		<div class="row">

        	   <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{{ trans('misc.add_new') }}}</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{{ url('panel/admin/categories/add').'/'.$id }}}" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{{ csrf_token() }}}">

					       @include('errors.errors-forms')

                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.name') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ old('name') }}}" name="name" class="form-control" placeholder="{{{ trans('admin.name') }}}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.slug') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ old('slug') }}}" name="slug" class="form-control" placeholder="{{{ trans('admin.slug') }}}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keyword</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ old('keyword') }}}" name="keyword" class="form-control" placeholder="enter keyword">
                      </div>
                    </div>
                  </div><!-- /.box-body -->


                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">TitleaHead</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ old('titleahead') }}}" name="titleahead" class="form-control" placeholder="Enter TitleaHead">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                  
                   <!--text Clipping Description-->
                <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Text Clipping Area</label>
                      <div class="col-sm-10">
                      	<textarea name="Text Clipping Area" rows="14" class="form-control" placeholder="Help Box"></textarea>
                    </div>
                    </div>
                    </div>
                    <!--Description-->
                    
                 
               <!-- Post Description -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Post Description</label>
                      <div class="col-sm-10">
                      
                        <textarea name="cpdescr" id="cpdescr"></textarea>
                      </div>
                    </div>
                  </div>
                   <!-- Post Description -->
                  
        


                                      <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Show at home?</label>
                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="yes" checked>
                          Yes
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="no">
                          No
                        </label>
                      </div>

                      </div>
                    </div>
                  </div><!-- /.box-body -->


                 
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.status') }}}</label>
                      <div class="col-sm-10">

                      	<div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="on" checked>
                          {{{ trans('admin.active') }}}
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="off">
                          {{{ trans('admin.disabled') }}}
                        </label>
                      </div>

                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.thumbnail') }} ({{trans('misc.optional')}})</label>
                      <div class="col-sm-10">
                      	<div class="btn btn-info box-file">
                      		<input type="file" accept="image/*" name="thumbnail" />
                      		<i class="glyphicon glyphicon-cloud-upload myicon-right"></i> {{ trans('misc.upload') }}
                      		</div>

                      <p class="help-block">{{ trans('admin.thumbnail_desc') }}</p>

                      <div class="btn-default btn-lg btn-border btn-block pull-left text-left display-none fileContainer">
					     	<i class="glyphicon glyphicon-paperclip myicon-right"></i>
					     	<small class="myicon-right file-name-file"></small> <i class="icon-cancel-circle delete-attach-file-2 pull-right" title="{{ trans('misc.delete') }}"></i>
					     </div>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="{{{ url('panel/admin/categories') }}}" class="btn btn-default">{{{ trans('admin.cancel') }}}</a>
                    <button type="submit" class="btn btn-success pull-right">{{{ trans('admin.save') }}}</button>
                  </div><!-- /.box-footer -->
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
	<script src="{{{ asset('public/plugins/iCheck/icheck.min.js') }}}" type="text/javascript"></script>
	
	<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

	<script type="text/javascript">
	 CKEDITOR.replace( 'cpdescr' );
		//Flat red color scheme for iCheck
        $('input[type="radio"]').iCheck({
          radioClass: 'iradio_flat-red'
        });
	</script>


@endsection
