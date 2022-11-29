@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
          <h4>
            {{ trans('admin.admin') }}
              <i class="fa fa-angle-right margin-separator"></i>
                {{ trans('admin.general_settings') }}
                <i class="fa fa-angle-right margin-separator"></i>
                {{ trans('admin.limits') }}
          </h4>
  </section>
  <section class="content">
    @if(Session::has('success_message'))
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        {{ Session::get('success_message') }}
      </div>
    @endif
        <div class="content">
          <div class="row">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin.limits') }}</h3>
              </div>
              <form class="form-horizontal" method="POST" action="{{ url('panel/admin/modify') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Show Ads?</label>
                    <div class="col-sm-10">

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="google_ads_index" @if( $settings->google_ads_index == 'on' ) checked="checked" @endif value="on" checked>
                          On
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="google_ads_index" @if( $settings->google_ads_index == 'off' ) checked="checked" @endif value="off">
                          Off
                        </label>
                      </div>

                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Responsive Ads</label>
                    <div class="col-sm-10">
                      <textarea name="responsiveads" rows="7" class="form-control" placeholder="Paste Responsive Ads Code">{{ $settings->responsiveads}}</textarea>
                      <p class="help-block" style="margin-bottom: 0px;">This Ads is displayed at top of Main Cat, Cat, Subcat, Latest, Featured below the Image Title and Tagged in Image page and between images of Subcat, Cat, Latest, Featured.</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Desktop Ads</label>
                    <div class="col-sm-10">
                      <textarea rows="7" name="deskads" rows="8" class="form-control" placeholder="Desktop Ads Code">{{ $settings->deskads}}</textarea>
                      <p class="help-block" style="margin-bottom: 0px;">This Ads is displayed above the Download Button in Image page.</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Ads</label>
                    <div class="col-sm-10">
                      <textarea rows="7" name="mobileads" rows="8" class="form-control" placeholder="Mobile Ads Code">{{ $settings->mobileads}}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Sticky Ads</label>
                    <div class="col-sm-10">
                      <textarea rows="7" name="stickyads" class="form-control" placeholder="Paste stickyads Ad Code">{{ $settings->stickyads}}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Show Sticky Ads?</label>
                    <div class="col-sm-10">

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="stickyadsonoff" @if( $settings->stickyadsonoff == 'on' ) checked="checked" @endif value="on" checked>
                          On
                          <p class="help-block" style="margin-bottom: 0px;">This Ads is displayed only in Image Page.</p>
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="stickyadsonoff" @if( $settings->stickyadsonoff == 'off' ) checked="checked" @endif value="off">
                          Off
                        </label>
                      </div>

                    </div>
                  </div>


                    <div class="form-group">
                    <label class="col-sm-2 control-label">Ads with Image</label>
                    <div class="col-sm-10">
                      <textarea rows="7" name="adswithimage" class="form-control" placeholder="Paste adswithimage Ad Code">{{ $settings->adswithimage}}</textarea>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Google Analytics</label>
                    <div class="col-sm-10">
                      <textarea rows="7" name="google_analytics" class="form-control" placeholder="Paste Google Analytics">{{ $settings->google_analytics}}</textarea>
                    </div>
                  </div>


                
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Banned Keywords</label>
                    <div class="col-sm-10">
                      <input type="text" value="{{ $settings->bannedkeywords}}" id="tagInput" name="bannedkeywords" class="form-control" placeholder="Banned Keywords">
                      <p class="help-block" style="margin-bottom: 0px;">Banned Keywords containing page won't load ads.</p>
                    </div>
                  </div>

                  
                </div>
              <button type="submit" class="btn btn-success" style="margin-top: 10px">{{ trans('admin.save') }}</button>
              </form>
            </div>
          </div><!-- /. box-danger -->
        </div><!-- /.row -->
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
       'minChars' : 2,
       'maxChars' : 305,
       'defaultText':'{{ trans("misc.add_tag") }}',
  });

                $("#tagInputHot").tagsInput({
     'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
     'width':'auto',
     'height':'auto',
       'removeWithBackspace' : true,
       'minChars' : 2,
       'maxChars' : 305,
       'defaultText':'{{ trans("misc.add_tag") }}',
  });
  </script>
@endsection
