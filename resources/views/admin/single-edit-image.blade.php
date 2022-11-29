@extends('admin.layout')
@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('public/jcropper/cropper.css') }}" type="text/css" />
<style type="text/css">
  .modal-body {
    position: relative;
    padding: 15px;
    overflow: scroll;
}
.box-footer,.box-body{
  float: left;
  width: 100%;
}
</style>
@endsection
@section('content')
      <div class="content-wrapper">
        <section class="content">
        	<div class="content">
       <div class="row">
       	<div class="col-md-12">
         <h2 class="box-title">{{ trans('admin.edit') }}</h2>
        </div>
        <div style="height:auto;width:90%;margin: 0 auto;" class="box-header with-border">
                  <div style="width: 100%;max-height:800px;float: left;" class="img-container">
                    <img data-id="{{$data->id}}" id="imagetoedit" crossorigin="anonymous" src="{{$data->imagetoedit}}">
                  </div>
                </div>
       
        <div class="col-md-9">
          <div class="">
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/images/update') }}" enctype="multipart/form-data">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<input type="hidden" name="id" value="{{$data->id}}">
                  <input type="hidden" name="referer" value="{{$referer}}">
                  <div id="croppedimagebox" style="display:none;float: left;" class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Cropped Image</label>
                      <div class="col-sm-10">
                        <input type="text" id="croppedimage" class="form-control" name="croppedimage" value=""> 
                      </div>
                    </div>
                  </div>
					       @include('errors.errors-forms')
                  <div class="box-body" style="margin-top: 10px;margin-bottom: 10px;">
                    
                          <button type="submit" class="btn btn-success pull-right">{{ trans('admin.save') }}</button>
                          <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Crop Image</a>
                          <span id="cropmessage" style="color:green;padding: 2px;font-weight: bold;"></span>
                          <a href="{{ url('panel/admin/images') }}" class="btn btn-default">{{ trans('admin.cancel') }}</a>
                </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label">{{ trans('admin.title') }}</label>
                            <div class="col-sm-10">
                              <input type="text" value="{{ $data->title }}" name="title" class="form-control" placeholder="{{ trans('admin.title') }}">
                            </div>
                          </div>
                 
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Metakeywords</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $data->metakeywords }}" id="tagInput"  name="metakeywords" class="form-control" placeholder="Metakeywords">
                      	<p class="help-block">* {{ trans('misc.add_tags_guide') }}</p>
                      </div>
                    </div>
                  </div>
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
                  </div>
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
                  </div>
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
                  </div>
                </form>
              </div>
        </div>
        <div id="viewimage" class="col-md-3">
        	<div class="block-block text-center">
            @php
            $imgurl = Storage::url(config('path.thumbnail').$data->thumbnail);
            $name = pathinfo($imgurl, PATHINFO_FILENAME);
            $type = 'image/jpeg';
            @endphp
        		<img data-type="{{$type}}" data-name="{{$name}}" id="showimage" src="{{$imgurl}}" class="thumbnail img-responsive">
        	</div>
        	<a href="{{ url('photo',$data->id) }}" target="_blank" class="btn btn-lg btn-success btn-block margin-bottom-10">{{ trans('admin.view') }} <i class="fa fa-external-link-square"></i></a>
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
		</div>
        		</div>
        	</div>
        </section>
      </div>
@endsection
@section('javascript')
  @php
  $r = rand(10,1000);
  @endphp
	<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/jcropper/dist/cropper.js?17')}}"></script>
  <script src="{{ asset('public/jcropper/dist/jquery-cropper.js?13')}}"></script>
	<script type="text/javascript">
		
    $(document).ready(function(){

      if( $(window).width() < 1024){
        $("#viewimage").css("float", "left");
      }

    });

	$("#tagInput").tagsInput({      
		 'delimiter': [','],
		 'width':'auto',
		 'height':'auto',
     'removeWithBackspace' : true,
     'minChars' : 3,
     'maxChars' : 25,
     'defaultText':'{{ trans("misc.add_tag") }}',
	});
	
  $(".actionDelete").click(function(e){
   	e.preventDefault();
    var element = $(this);
    var id = element.attr('data-url');
	  var form = $(element).parents('form');
	  element.blur();

	  swal({   
        title: "{{trans('misc.delete_confirm')}}",  
  		  type: "warning", 
  		  showLoaderOnConfirm: true,
  		  showCancelButton: true,   
  		  confirmButtonColor: "#DD6B55",  
  		  confirmButtonText: "{{trans('misc.yes_confirm')}}",   
  		  cancelButtonText: "{{trans('misc.cancel_confirm')}}",  
  		  closeOnConfirm: false, 
		  }, function(isConfirm){  
		    	if (isConfirm) {   
		    	 	 form.submit(); 
		    	}
		    });
		});
		
    $('input[type="radio"]').iCheck({
      radioClass: 'iradio_flat-red'
    });
	
</script>	
<script src="{{ asset('public/jcropper/dist/main.js?32')}}"></script>
@endsection
