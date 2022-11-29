@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{ trans('admin.admin') }}
            	<i class="fa fa-angle-right margin-separator"></i>
            		{{ trans('admin.pages') }}
            			<i class="fa fa-angle-right margin-separator"></i>
            				{{ trans('admin.edit') }}
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

        	<div class="content">

        		<div class="row">

        	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('admin.edit') }}</h3>
                </div><!-- /.box-header -->


                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ url('panel/admin/pages/'.$data->id) }}">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="_method" value="PUT">

					@include('errors.errors-forms')

                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.title') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->title }}" name="title" class="form-control" placeholder="{{ trans('admin.title') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.slug') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->slug }}" name="slug" class="form-control" placeholder="{{ trans('admin.slug') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.content') }}</label>
                      <div class="col-sm-10">
						
                      	<textarea name="content"rows="5" cols="40" id="content" class="form-control" placeholder="{{ trans('admin.content') }}">{{ $data->content }}</textarea>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <a href="{{ url('panel/admin/pages') }}" class="btn btn-default">{{ trans('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right">{{ trans('admin.save') }}</button>
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
<script src="{{{ asset('public/plugins/ckeditor/ckeditor.js') }}}" type="text/javascript"></script>
<script type="text/javascript">
		$(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.

	    	CKEDITOR.replace('content',{
                allowedContent: true
            });

	 	 });
	</script>

@endsection
