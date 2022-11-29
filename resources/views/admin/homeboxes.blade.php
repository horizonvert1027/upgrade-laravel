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
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/homeboxes') }}" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">

					@include('errors.errors-forms')

                    
                <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Header Custom Menus</h3>
                </div><!-- /.box-header -->
                
                
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu 1 Title</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text1 }}" name="text1" class="form-control" placeholder="{{ trans('admin.email_admin') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                  
                  
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu 1 Link </label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu1 }}" name="menu1" class="form-control" placeholder="{{ trans('admin.email_admin') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  

                   
                  <hr>
                  
                  

                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu 2 Title</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text2 }}" name="text2" class="form-control" placeholder="{{ trans('admin.email_admin') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                   
                   
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu 2 Link</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu2 }}" name="menu2" class="form-control" placeholder="{{ trans('admin.email_admin') }}">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <hr>
                 
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu 3 Title </label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text3 }}" name="text3" class="form-control" placeholder="title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Header Custom Menu Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu3 }}" name="menu3" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                  <br>
                  
                  
                  
                  
                  
                  	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Home Box Buttons by Profession</h3>
                </div><!-- /.box-header -->
                
                
                
                
                

                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text4 }}" name="text4" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu4 }}" name="menu4" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image4 }}" name="image4" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text5 }}" name="text5" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu5 }}" name="menu5" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image5 }}" name="image5" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text6 }}" name="text6" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu6 }}" name="menu6" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image6 }}" name="image6" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text7 }}" name="text7" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu7 }}" name="menu7" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image7 }}" name="image7" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text8 }}" name="text8" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu8 }}" name="menu8" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image8 }}" name="image8" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Title 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text19 }}" name="text19" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Link 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu19 }}" name="menu19" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Buttons by Profession Image Link 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image19 }}" name="image19" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Home Box Buttons Main Type</h3>
                </div><!-- /.box-header -->
                
                
                
                  
                    <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Title 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text9 }}" name="text9" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  



                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu9 }}" name="menu9" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Image Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image9 }}" name="image9" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Title 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text10 }}" name="text10" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu10 }}" name="menu10" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Image Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image10 }}" name="image10" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Title 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text11 }}" name="text11" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu11 }}" name="menu11" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Image Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image11 }}" name="image11" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Title 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text12 }}" name="text12" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu12 }}" name="menu12" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Main Type Image Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image12 }}" name="image12" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  
                  
                  	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Home Box Buttons Top</h3>
                </div><!-- /.box-header -->
                
                
                
                
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text13 }}" name="text13" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu13 }}" name="menu13" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 1</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image13 }}" name="image13" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text14 }}" name="text14" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu14 }}" name="menu14" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 2</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image14 }}" name="image14" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text15 }}" name="text15" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu15 }}" name="menu15" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 3</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image15 }}" name="image15" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text16 }}" name="text16" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu16 }}" name="menu16" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 4</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image16 }}" name="image16" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text17 }}" name="text17" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu17 }}" name="menu17" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 5</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image17 }}" name="image17" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                  
                  
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Title 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->text18 }}" name="text18" class="form-control" placeholder="Title">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Link 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->menu18 }}" name="menu18" class="form-control" placeholder="href link">
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  
                  
                   <div class="form-group">
                      <label class="col-sm-2 control-label">Home Box Buttons Top Image Link 6</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{ $settings->image18 }}" name="image18" class="form-control" placeholder="img src link">
                      </div>
                    </div>
                  <!-- /.box-body -->
                    
                  <hr>
                  
                  
                 
                  
                  
                  
                  
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
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
