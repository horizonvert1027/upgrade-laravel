@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
            {{ trans('admin.admin') }} 
              <i class="fa fa-angle-right margin-separator"></i> 
                {{ trans('admin.edit') }}
                
                <i class="fa fa-angle-right margin-separator"></i> 
                {{ $data->username }}
                
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">

          <div class="content">
            
       <div class="row">
        
        <div class="col-md-9">
    
          <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{ trans('admin.edit') }}</h3>
                </div><!-- /.box-header -->
               
               
               
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/members/'.$data->id) }}" enctype="multipart/form-data">
                  
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="_method" value="PUT">  
      
          @include('errors.errors-forms')
                  
                 <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.name') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->name }}" name="name" class="form-control" placeholder="{{ trans('admin.name') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                   <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('auth.username') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->username }}" disabled="disabled" name="welcome_text" class="form-control" placeholder="{{ trans('auth.username') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('auth.email') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->email }}" name="email" class="form-control" placeholder="{{ trans('admin.email') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  

                   <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Level</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->userlevel }}" name="userlevel" class="form-control" placeholder="Userlevel">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  


                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.description') }}</label>
                      <div class="col-sm-10">
                        
                        <textarea name="bio" rows="4" id="bio" class="form-control" placeholder="{{ trans('admin.description') }}">{{ $data->bio }}</textarea>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.paypal_account') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->paypal_account }}" name="paypal_account" class="form-control" placeholder="{{ trans('admin.paypal_account') }}">
                        <p class="help-block">{{ trans('admin.paypal_account_donations') }}</p>
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                   <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('misc.username_on_twitter') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->twitter }}" name="twitter" class="form-control" placeholder="{{ trans('misc.username_on_twitter') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('misc.website_misc') }}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->website }}" name="website" class="form-control" placeholder="{{ trans('misc.website_misc') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.status') }}</label>
                      <div class="col-sm-10">
                        <select name="status" class="form-control">
                            <option @if( $data->status == 'pending' ) selected="selected" @endif value="pending">{{ trans('admin.pending') }}</option>
                <option @if( $data->status == 'active' ) selected="selected" @endif value="active">{{ trans('admin.active') }}</option>
                <option @if( $data->status == 'suspended' ) selected="suspended" @endif value="active">{{ trans('admin.suspended') }}</option>
    
                          </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.role') }}</label>
                      <div class="col-sm-10">
                        <select name="role" class="form-control">
                            <option @if( $data->role == 'normal' ) selected="selected" @endif value="normal">{{ trans('admin.normal') }}</option>
                            <option @if( $data->role == 'admin' ) selected="selected" @endif value="admin">{{ trans('admin.role_admin') }}</option>
                            <option @if( $data->role == 'editor' ) selected="selected" @endif value="editor">{{ trans('admin.editor') }}</option>
                          </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.authorized_to_upload')  }}</label>
                      <div class="col-sm-10">
                        
                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="authorized_to_upload" @if( $data->authorized_to_upload == 'yes' ) checked="checked" @endif value="yes" checked>
                          {{ trans('misc.yes')  }}
                        </label>
                      </div>
                      
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="authorized_to_upload" @if( $data->authorized_to_upload == 'no' ) checked="checked" @endif value="no">
                         {{ trans('misc.no')  }}
                        </label>
                      </div>
                      
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  
                  <div class="box-footer">
                     <a href="{{ url('panel/admin/members') }}" class="btn btn-default">{{ trans('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right">{{ trans('admin.save') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
              
        </div><!-- /. col-md-9 -->
        
        <div class="col-md-3">
          
          <div class="block-block text-center">
            <img src="{{asset('public/avatar').'/'.$data->avatar}}" class="thumbnail img-responsive">
          </div>
          
          <a href="{{ url($data->username) }}" target="_blank" class="btn btn-lg btn-success btn-block margin-bottom-10">{{ trans('admin.view') }} <i class="fa fa-external-link-square"></i> </a>
          
          <ol class="list-group">
      <li class="list-group-item"> {{trans('admin.registered')}} <span class="pull-right color-strong">{{ App\Helper::formatDate($data->date) }}</span></li>
      
      <li class="list-group-item"> {{trans('misc.country')}} <span class="pull-right color-strong">@if( $data->countries_id != '' ) {{ $data->country()->country_name }} @else {{ trans('admin.not_established') }} @endif</span></li>
      
      
      
  
    </ol>
    
    <div class="block-block text-center">
    {!! Form::open([
                  'method' => 'DELETE',
                  'route' => ['user.destroy', $data->id],
                  'class' => 'displayInline'
                ]) !!}
                {!! Form::submit(trans('admin.delete'), ['data-url' => $data->id, 'class' => 'btn btn-lg btn-danger btn-block margin-bottom-10 actionDelete']) !!}
            {!! Form::close() !!}
          </div>
    
    </div><!-- col-md-3 -->                         
            
            </div><!-- /.row -->
            
          </div><!-- /.content -->
          
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
  
  <!-- icheck -->
  <script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
  
  <script type="text/javascript">
    
    $(".actionDelete").click(function(e) {
    e.preventDefault();
        
    var element = $(this);
  var id     = element.attr('data-url');
  var form    = $(element).parents('form');
  
  element.blur();
  
  swal(
    {   title: "{{trans('misc.delete_confirm')}}",  
    text: "{{trans('admin.delete_user_confirm')}}",
      type: "warning", 
      showLoaderOnConfirm: true,
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",  
       confirmButtonText: "{{trans('misc.yes_confirm')}}",   
       cancelButtonText: "{{trans('misc.cancel_confirm')}}",  
        closeOnConfirm: false, 
        }, 
        function(isConfirm){  
           if (isConfirm) {   
            form.submit(); 
            //$('#form' + id).submit();
            }
           });
           
           
     });
     
    //Flat red color scheme for iCheck
        $('input[type="radio"]').iCheck({
          radioClass: 'iradio_flat-red'
        });
  
  </script>
  

@endsection
