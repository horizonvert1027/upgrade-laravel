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

                <i class="fa fa-angle-right margin-separator"></i>
                {{ trans('admin.limits') }}

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
                  <h3 class="box-title">{{ trans('admin.limits') }}</h3>
                </div><!-- /.box-header -->



                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/settings/limits') }}" enctype="multipart/form-data">

                  <input type="hidden" name="_token" value="{{ csrf_token() }}">


    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.auto_approve_images') }}</label>
                      <div class="col-sm-10">
                        <select name="auto_approve_images" class="form-control">
                            <option @if( $settings->auto_approve_images == 'on' ) selected="selected" @endif value="on">{{ trans('misc.yes') }}</option>
                <option @if( $settings->auto_approve_images == 'off' ) selected="selected" @endif value="off">{{ trans('misc.no') }}</option>

                          </select>
                      </div>
                    </div>

                  <div class="form-group">
                      <label class="col-sm-2 control-label">Download from and to</label>
                      <div class="col-sm-10">
                        <div class="ekmee" style="display: flex">
                          <label style="margin: auto 7px auto 0px;">From:</label>
                        <input type="number" name="downloadidfrom" value="{{$settings->downloadidfrom}}" class="form-control" placeholder="FROM"> <label style="margin: auto 7px auto 5px;">To:</label>
                        <input type="number" name="downloadidto" value="{{$settings->downloadidto}}" class="form-control" placeholder="TO">
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.limit_upload_user') }}</label>
                      <div class="col-sm-10">
                        <select name="limit_upload_user" class="form-control">
                            <option @if( $settings->limit_upload_user == 0 ) selected="selected" @endif value="0">{{ trans('admin.unlimited') }}</option>
                <option @if( $settings->limit_upload_user == 1 ) selected="selected" @endif value="1">1</option>
                <option @if( $settings->limit_upload_user == 2 ) selected="selected" @endif value="2">2</option>
                <option @if( $settings->limit_upload_user == 3 ) selected="selected" @endif value="3">3</option>
                <option @if( $settings->limit_upload_user == 4 ) selected="selected" @endif value="4">4</option>
                <option @if( $settings->limit_upload_user == 5 ) selected="selected" @endif value="5">5</option>
                <option @if( $settings->limit_upload_user == 10 ) selected="selected" @endif value="10">10</option>
                <option @if( $settings->limit_upload_user == 15 ) selected="selected" @endif value="15">15</option>
                <option @if( $settings->limit_upload_user == 20 ) selected="selected" @endif value="20">20</option>
                <option @if( $settings->limit_upload_user == 25 ) selected="selected" @endif value="25">25</option>
                <option @if( $settings->limit_upload_user == 30 ) selected="selected" @endif value="30">30</option>
                <option @if( $settings->limit_upload_user == 40 ) selected="selected" @endif value="40">40</option>
                <option @if( $settings->limit_upload_user == 50 ) selected="selected" @endif value="50">50</option>
                <option @if( $settings->limit_upload_user == 100 ) selected="selected" @endif value="100">100</option>
                          </select>
                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.result_request_images') }}</label>
                      <div class="col-sm-10">
                        <select name="result_request" class="form-control">
                            <option @if( $settings->result_request == 12 ) selected="selected" @endif value="12">12</option>
                <option @if( $settings->result_request == 24 ) selected="selected" @endif value="24">24</option>
                <option @if( $settings->result_request == 36 ) selected="selected" @endif value="36">36</option>
                <option @if( $settings->result_request == 48 ) selected="selected" @endif value="48">48</option>
                <option @if( $settings->result_request == 60 ) selected="selected" @endif value="60">60</option>
                          </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Pagination Limit</label>
                      <div class="col-sm-10">
                        <select name="paginationlimit" class="form-control">
                
                <option @if( $settings->paginationlimit == 50 ) selected="selected" @endif value="50">50</option>
                <option @if( $settings->paginationlimit == 100 ) selected="selected" @endif value="100">100</option>
                <option @if( $settings->paginationlimit == 250 ) selected="selected" @endif value="250">250</option>
                <option @if( $settings->paginationlimit == 500 ) selected="selected" @endif value="500">500</option>
                <option @if( $settings->paginationlimit == 1000 ) selected="selected" @endif value="1000">1000</option>
                <option @if( $settings->paginationlimit == 1500 ) selected="selected" @endif value="1500">1500</option>
                          </select>
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
       'maxChars' : 35,
       'defaultText':'{{ trans("misc.add_tag") }}',
  });

  </script>


@endsection
