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
            		{{ trans('admin.edit') }}
            		
            		<i class="fa fa-angle-right margin-separator"></i> 
            		{{ $data->title }}
            		
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
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/images/update') }}" enctype="multipart/form-data">
                	
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="id" value="{{$data->id}}">	
			
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
                      <label class="col-sm-2 control-label">MetaKeywords</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->metakeywords }}" id="tagInput"  name="metakeywords" class="form-control" placeholder="metakeywords">
                      	<p class="help-block">* {{ trans('misc.add_tags_guide') }}</p>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('misc.category') }}</label>
                      <div class="col-sm-10">
                      	<select name="categories_id" class="form-control">
                      	
                      	@foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category ) 	
                            <option @if( $data->categories_id == $category->id ) selected="selected" @endif value="{{$category->id}}">{{ $category->name }}</option>
						@endforeach
                         
                          </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
        
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.status') }}</label>
                      <div class="col-sm-10">
                      	<select name="status" class="form-control">
                            <option @if( $data->status == 'active' ) selected="selected" @endif value="active">{{ trans('admin.active') }}</option>
                            <option @if( $data->status == 'pending' ) selected="selected" @endif value="pending">{{ trans('admin.pending') }}</option>
                          </select>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('misc.featured')  }}</label>
                      <div class="col-sm-10">
                      	
                      	<div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="featured" @if( $data->featured == 'yes' ) checked="checked" @endif value="yes" checked>
                          {{ trans('misc.yes')  }}
                        </label>
                      </div>
                      
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="featured" @if( $data->featured == 'no' ) checked="checked" @endif value="no">
                         {{ trans('misc.no')  }}
                        </label>
                      </div>
                      
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  
                  <div class="box-footer">
                  	 <a href="{{ url('panel/admin/images') }}" class="btn btn-default">{{ trans('admin.cancel') }}</a>
                    <button type="submit" class="btn btn-success pull-right">{{ trans('admin.save') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
              
        </div><!-- /. col-md-9 -->
        
        <div class="col-md-3">
        	
        	<div class="block-block text-center">
        		<img src="{{Storage::url(config('path.thumbnail').$data->thumbnail)}}" class="thumbnail img-responsive">
        	</div>
        	
        	<a href="{{ url('photo',$data->id) }}" target="_blank" class="btn btn-lg btn-success btn-block margin-bottom-10">{{ trans('admin.view') }} <i class="fa fa-external-link-square"></i> </a>
        	
        <ol class="list-group">
        	<li class="list-group-item"> {{trans('misc.uploaded_by')}} <span class="pull-right color-strong">{{ $data->user()->username }}</span></li>
			<li class="list-group-item"> {{trans('misc.published')}} <span class="pull-right color-strong">{{ App\Helper::formatDate($data->date) }}</span></li>
			
		</ol>
		
		<div class="block-block text-center">
		{!! Form::open([
			            'method' => 'POST',
			            'url' => 'panel/admin/images/delete',
			            'class' => 'displayInline'
				        ]) !!}
				        {!! Form::hidden('id',$data->id ); !!}
	            	{!! Form::submit(trans('admin.delete'), ['class' => 'btn btn-lg btn-danger btn-block margin-bottom-10 actionDelete']) !!}
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
	<script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>
	
	<script type="text/javascript">
		
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
	
$(".actionDelete").click(function(e) {
   	e.preventDefault();
   	   	
   	var element = $(this);
	var id     = element.attr('data-url');
	var form    = $(element).parents('form');
	
	element.blur();
	
	swal(
		{   title: "{{trans('misc.delete_confirm')}}",  
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
