@extends('admin.layout')

@section('css')
<link href="{{{ asset('public/plugins/iCheck/all.css') }}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
  .autocomplete-suggestions{text-align:left;cursor:default;background:#fff;box-shadow:-1px 1px 5px rgba(0,0,0,.1);width:auto;border-radius:10px;position:absolute;display:none;z-index:9999;max-height:254px;overflow:hidden;overflow-y:auto;box-sizing:border-box}.autocomplete-suggestion span{width:87%;display:inline-block;padding:1px}.autocomplete-suggestion a{background-image:url(/public/img/searchbox_sprites312_hr.webp);background-size:20px;height:20px;width:20px;margin:2px;flex:1;float:right;background-position:bottom center}.autocomplete-suggestion{position:relative;padding-left:8px;line-height:27px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-size:1.18em;color:#333;border-radius:10px}.autocomplete-suggestion.selected{background:#f0f0f0}.modalsign_up{width:40%;cursor:pointer;display:inline-block;color:grey;margin:0 20px 10px 25px}
</style>

@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <section class="content-header">
          <h4>
            {{{ trans('admin.admin') }}}
             
            	<i class="fa fa-angle-right margin-separator"></i>
            	 <a class="breadcrumblink" href="{{ url('panel/admin/categories/').'/'.$categories->main_cat_id}}">	
                {{{ trans('misc.categories') }}}
              </a>
            			<i class="fa fa-angle-right margin-separator"></i>
            				{{{ trans('admin.edit') }}}
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">


        	<div class="content">

        		<div class="row">

        	<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">{{{ trans('admin.edit') }}}</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
                	<input type="hidden" name="id" value="{{{ $categories->id }}}">

					   @include('errors.errors-forms')

                
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.name') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ $categories->name }}}" name="name" class="form-control" placeholder="{{{ trans('admin.name') }}}">
                      </div>
                    </div>
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.slug') }}}</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ $categories->slug }}}" name="slug" class="form-control" placeholder="{{{ trans('admin.slug') }}}">
                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keyword</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ $categories->keyword }}}" name="keyword" class="form-control" placeholder="Enter keyword">
                      </div>
                    </div>
                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">TitleaHead</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ $categories->titleahead }}}" name="titleahead" class="form-control" placeholder="Enter TitleaHead">
                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Search SubCats</label>
                      <div class="col-sm-10">
                        <input type="text" value="" id="searchrelatedtags" name="searchrelatedtags" class="form-control" placeholder="Search keyword">
                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Related Subcat Tags</label>
                      <div class="col-sm-10">
                        <input type="text" value="{{{ $categories->relatedtags }}}" name="relatedtags" class="form-control" placeholder="Enter Related Tags">
                        <p class="help-block">only give the slug of the subcategory, i.e. virat-kohli-photos</p>
                      </div>
                    </div>

                
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Post Description</label>
                      <div class="col-sm-10">
                        <textarea name="cpdescr" id="cpdescr">{{ $categories->cpdescr }}</textarea>
                      </div>
                    </div>
                 

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Show at home?</label>
                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="yes" @if( $categories->showathome == 'yes' ) checked @endif>
                          Yes
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="showathome" value="no" @if( $categories->showathome == 'no' ) checked @endif>
                          No
                        </label>
                      </div>

                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{{ trans('admin.status') }}}</label>
                      <div class="col-sm-10">

                        <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="mode" value="on" @if( $categories->mode == 'on' ) checked @endif>
                          {{{ trans('admin.active') }}}
                        </label>
                      </div>

                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" @if(  $categories->id == 1 ) disabled="disabled" @endif name="mode" value="off" @if( $categories->mode == 'off' ) checked @endif>
                          {{{ trans('admin.disabled') }}}
                        </label>
                      </div>

                      </div>
                    </div>
                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.thumbnail') }} ({{trans('misc.optional')}})</label>
                      <div class="col-sm-10">
                      	<div class="btn-info box-file">
                      		<input type="file" accept="image/*" name="thumbnail" />
                      		
                      		</div>

                      <p class="help-block">{{ trans('admin.thumbnail_desc') }}</p>

                        <div class="thumbfilename">
                          <i class="glyphicon glyphicon-paperclip myicon-right"></i>
                          <p>{{ $categories->thumbnail }}</p>
                       </div>

                      </div>
                    </div>
                

                    <a href="{{{ url('panel/admin/categories') }}}" class="btn btn-default">{{{ trans('admin.cancel') }}}</a>
                    <button type="submit" class="btn btn-success pull-right">{{{ trans('admin.save') }}}</button>
                 
                </form>
              </div>

        		</div><!-- /.row -->

        	</div><!-- /.content -->

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
  
    <script async src="{{ asset('public/js/autocompleteAdmin.js?122222') }}"></script>

	<!-- icheck -->
	<script src="{{{ asset('public/plugins/iCheck/icheck.min.js') }}}" type="text/javascript"></script>
	<script src="{{{ asset('public/Trumbowyg-master/dist/trumbowyg.min.js') }}}"></script>
  <script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	   
    console.log("<?php echo addslashes(json_encode($allsubcategories));?>");	

    function myFunction() 
    {
      var copyText = document.getElementById("searchrelatedtags");
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      document.execCommand("copy");
    }
    
    $(document).ready(function(){

        var res = new Array();
      var searchdata = JSON.parse('<?php echo json_encode($allsubcategories);?>');
      for (var key in searchdata) {
        if (searchdata.hasOwnProperty(key)) {
          res.push(searchdata[key]);
        }
      }

      demo1 = new autoComplete({
        selector:"#searchrelatedtags",
        minChars:3,
        source: function(term, suggest){
          term = term.toLowerCase();
          var matches = [];
          for (i=0; i<res.length; i++)
              if (~res[i].toLowerCase().indexOf(term)) matches.push(res[i].toLowerCase());
          suggest(matches);

          $(".autocomplete-suggestion span").click(function(e)
          {
              $("#searchrelatedtags").val($(this).html());
              e.preventDefault();
              $("div.autocomplete-suggestions").hide()
              myFunction();    
          });

        },
        onSelect: function(e, term)
        {
          e.preventDefault();
          myFunction();     
        }
      });
    });

    $(function() 
    {
      $('#cpdescr').trumbowyg();
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
           
	 	 });

     $('input[type="radio"]').iCheck({
          radioClass: 'iradio_flat-red'
        });

        function replaceString(string) {
          return string.replace(/[\-\_\.\+]/ig,' ')
        }

        $('input[type="file"]').attr('title', window.URL ? ' ' : '');

    $("#relatedtags").tagsInput({

     'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
     'width':'auto',
     'height':'auto',
       'removeWithBackspace' : true,
       'minChars' : 3,
       'maxChars' : 50,
       'defaultText':'{{ trans("misc.add_tag") }}',
       onChange: function() {
          var input = $(this).siblings('.tagsinput');

      if( input.children('span.tag').length >= 100){
              input.children('div').hide();
          }
          else{
              input.children('div').show();
          }},});
      
	</script>

<link rel="stylesheet" href="{{{ asset('public/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}}">
 @include('admin.topbottom')
@endsection
