<!DOCTYPE html>
@extends('layouts.upload')
@section('title'){{ trans('users.upload').' - ' }}@endsection
@section('content')
<?php $date = date('Y-m-d', strtotime('today')); $imagesUploads = App\Models\Images::where('user_id',Auth::user()->id)->whereRaw("DATE(date) = '".$date."'")->count();
		?>
<div class="container margin-bottom-40 padding-top-40">
	<form method="POST" action="{{ url('upload') }}" enctype="multipart/form-data" id="formUpload">
			@csrf
		<section>
			<div class="uploadwala">
				@if( $settings->limit_upload_user == 0 || $imagesUploads < $settings->limit_upload_user || Auth::user()->role == 'admin'  )
						<div class="col-md-4">
							@include('errors.errors-forms')
								
									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									<div class="filer-input-dragDrop position-relative" id="draggable">

									<input type="file" multiple accept="image/*" name="photo[]" id="filePhoto">

									<div class="previewPhoto">
									<div class="btn btn-danger btn-sm btn-remove-photo" id="removePhoto">
									Remove
									</div>
									</div>

									<div class="filer-input-inner">
									<div class="filer-input-icon">
									<i class="fa fa-cloud-upload"></i>
									</div>
									<div class="filer-input-text">
									<h3 class="margin-bottom-10">Drag & Drop or click to upload
									<i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
									</h3>

									<?php if ($settings->limit_upload_user == 0) {
									$limit = strtolower(trans('admin.unlimited'));
									} else {
									$limit = $settings->limit_upload_user;
									} ?>
									<ul>
									<li style="    list-style-type: none;
    margin-inline-start: -20px;
    margin-bottom: 4px;
">
										<B> {{ trans('conditions.terms') }}</B></li>
									<li style="list-style-type: disc;">  {{ trans('conditions.upload_max', ['limit' => $limit ]) }}</li>
									<li style="list-style-type: disc;"> Violence or pornographic content
										prohibited.
									</li>
									<li style="list-style-type: disc;"> {{ trans('conditions.own_images') }}
										.
									</li>
									</ul>
									</div>
									</div>
									</div>
						</div>

						<div class="col-md-8">
							
							<div class="form-group">
								<label>{{ trans('admin.title') }}</label>
								<input type="text" value="{{ old('title') }}" name="title" id="title" class="containerform" placeholder="{{ trans('admin.title') }}">
							</div>

							<div class="form-group">
								<label>Credits</label>
								<input type="text" value="{{ old('credits') }}" name="credits" id="credits" class="containerform" placeholder="Credits">
							</div>

							<div class="showingg">
								<div class="column25">
									<label>Upload Other File</label>
									<div class="ffff">
										<div id="optfilecheckno">
											<label class="checkbox">{{ trans('misc.no') }}
											<input type="radio" class="checkboxyn" name="opt-file-check" checked="checked" value="no">
											</label>
										</div>
										<div id="optfilecheckyes">
											<label class="checkbox">{{ trans('misc.yes') }}
											<input type="radio" class="checkboxyn" name="opt-file-check" value="yes">
											</label>
										</div>
									</div>
								</div>		

								<div class="column33"><div style="display:none; padding: 0px;font-size: 14px;margin: auto 0px;" class="filer-input-dragDrop position-relative oefile" id="draggable">
									<label>Drop or Select files</label>
									<input type="file" id="opt-file" name="opt-file" onchange="validate_fileupload(this);" style="opacity:1;position:relative;font-size:inherit;padding:0px;min-height: auto;width: 100%;" class="containerform">

										<p class="help-block">&nbsp;Upload Any file here.
										</p>
										<div id="feedback" style="color:red;">
										</div>
								</div>
								</div>
							</div>
							<div class="form-group">
									<label>Metakeywords</label>
									<input type="text" value="" id="tagInput-" name="metakeywords" class="containerform" placeholder="metakeywords">
							</div>
							<div class="column">
								<div class="form-group">
									<label>Search Subcategory</label>
									<input type="text" class="containerform" name="searchsubcat" placeholder="Search Subcategory" />
								</div>
							</div>
							<div class="rowss">
								<div class="column">
									<div class="form-group">
										<label>{{ trans('misc.category') }}</label>
										<select name="categories_id" id="cat" class="containerform">
											<option> Select </option>
											@foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category )
												<option value="{{$category->id}}">{{ $category->name }}</option>
											@endforeach
										</select>
										@if(Auth::user()->role == 'admin')
											<a href="{{url('panel/admin/categories/add/0')}}" target="popup" onclick="window.open('{{url('panel/admin/')}}','name','resizable=yes, scrollbars=yes, titlebar=yes' ,'width=800,height=600')">
												<i class="fa fa-plus-circle myicon-right"></i>
											</a>
										@endif
									</div>
								</div>
							</div>
							<div class="rowss">

								<div class="column">
									<div class="form-group">
										<label>Sub Category</label>
										<select name="subcategories_id" id="sub" class="containerform">
											<option></option>
											@foreach(  App\subcategories::where('mode','on')->orderBy('name')->get() as $subcategories )
												<option> Select </option>
												<option value="{{$subcategories->id}}">{{ $subcategories->name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="column">
									<div class="form-group">
										<label>{{ trans('misc.subgroup') }}</label>
										<select name="subgroup" id="subgroup" class="containerform">
											<option> Select </option>		
										</select>
									</div>
									<span class="linksblock"></span>
								</div>
							</div>
							<div class="alert alert-danger display-none" id="dangerAlert">
								<ul class="list-unstyled" id="showErrors">
								</ul>
							</div>
							<div class="box-footer">
								
								<button type="submit" id="upload" class="btn btn-lg btn-success pull-right">{{ trans('users.upload') }}
								</button>
								<div class="progress" style="display: none;">
									<div class="progress-bar" role="progressbar" aria-valuenow=""
										 aria-valuemin="0" aria-valuemax="100" style="width: 15%">
										0%
									</div>
								</div>
							</div>
						</div>
					@else
						<h3 class="margin-top-none text-center no-result no-result-mg">
						{{trans('misc.limit_uploads_user')}}
						</h3>
				@endif
			</div>
		</section>
	</form>
</div>
@endsection

@section('javascript')


<!-- Include JS file. -->
<script src="public/Trumbowyg-master/dist/trumbowyg.min.js"></script>
<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
        var valid = false;

        var tCount = 1;
		var timer;

		function changeProgress(value)
		{
			var selectedValue = value;
			document.querySelector(".progress-bar-striped > div").textContent = selectedValue + "%";
			document.querySelector(".progress-bar-striped > div").style.width = selectedValue + "%";
		}

		function startProgress()
		{
			timer = setInterval(function() {
				tCount = tCount + 1;
				if( tCount == 100 )
				{
					myStopFunction();
				}
				changeProgress(tCount);
			}, 1000);
		}

		function myStopFunction() {
		  clearTimeout(timer);
		}

		$(document).ready(function()
		{
			<?php
			  $allsubcategories = App\subcategories::all();
		      $arr = array();
		      $subMap = array();
		      foreach ($allsubcategories as $key => $subcat)
		      {
		        $arr[] = $subcat->name;
		        $subMap[ $subcat->id ] = $subcat->categories_id."|".$subcat->name;
		      }
		    ?>
			var allsubs = '<?php echo addslashes(json_encode($arr));?>';
	      allsubs = JSON.parse(allsubs);
	      var allsubsmap = '<?php echo addslashes(json_encode($subMap));?>';
	      allsubsmap = JSON.parse(allsubsmap);

	      $("input[name='searchsubcat']").autocomplete({
	        source: allsubs,
	        minLength: 2,
	        open: function(){ $(".linksblock").html(''); },
	        select: function( event, ui )
	        {
	          var category = "";
	          var subcategory = "";
	          var sub = ui.item.value.trim();
	          $("input[name='searchsubcat']").val(sub);
	          $.each(allsubsmap, function(i, obj)
	          {
	            //console.log(i);
	            //console.log(obj);
	            var d = obj.split("|");
	            if( d[1] == sub )
	            {
	              subcategory = i;
	              category = d[0];
	            }
	          });



	          $("#cat").val(category);
                $("#cat").trigger('change');

	          setTimeout(function(){
	          	$("#sub").val(subcategory);
	          	$("#sub").trigger('change');
	          }, 2000);


        //CKEDITOR.replace('descr');
        $("#sub").change(function()
        {
            subcat = $("#sub").val();
            $.ajax({
                url: "{{url('getsubgroupupload')}}/"+subcat, success:function(result)
                {
                    $("#subgroup").html(result);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        });

                var baseurl = "{{url('panel/admin')}}";

                var href = baseurl+'/subcategories/add/'+category;
                $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"' target='popup'>Add Subcategory</a>");

                var href = baseurl+'/subcategories/edit/'+subcategory+"/"+category;
                $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"' target='popup'>Edit Subcategory</a>");

                var href = baseurl+'/subcatimages/'+subcategory;
                $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"' target='popup'>Subcategory Images</a>");

	        }
	      });

            $("#optfilecheckno .iradio_flat-red, #optfilecheckno label").click(function(){
				$(".oefile").hide();
				document.getElementById("feedback").innerHTML = "";
				document.getElementById("opt-file").value = "";
			});
			$("#optfilecheckyes .iradio_flat-red, #optfilecheckyes label").click(function(){
			    document.getElementById("opt-file").value = "";
			    document.getElementById("feedback").innerHTML = "";
				$(".oefile").show();
				$(".filer-input-dragDrop.oefile").css('padding',0);
			});
		});

		function validate_fileupload(input_element) 
		{
            var el = document.getElementById("feedback");
            var fileName = input_element.value;
            var allowed_extensions = new Array("psd", "psb", "tiff", "eps", "dng", "pdf", "ppt", "pptx", "txt", "zip", "rar", "htm", "html", "otf", "ttf", "xmp", "apk", "webp", "doc", "docx", ".xmp");
            var file_extension = fileName.split('.').pop();
            for (var i = 0; i < allowed_extensions.length; i++) {
                if (allowed_extensions[i] == file_extension) {
                    valid = true; // valid file extension
                    el.innerHTML = fileName;
                    el.style.color = 'green';
                    return;
                }
            }
            el.style.color = 'red';
            el.innerHTML = "Invalid file";
            valid = false;
        }
		
        //CKEDITOR.replace('descr');
        $("#cat").change(function()
        {
            cat = $("#cat").val();
            $.ajax({
                url: "{{url('getsubcat')}}/"+cat, success:function(result)
                {
                    $("#sub").html(result);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        });

        //CKEDITOR.replace('descr');
        $("#sub").change(function()
        {
            subcat = $("#sub").val();
            $.ajax({
                url: "{{url('getsubgroupupload')}}/"+subcat, success:function(result)
                {
                    $("#subgroup").html(result);
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });
        });

         // function replaceString(string) {
        // 	return string.replace(/[\-\_\.\+]/ig,' ')
        // }
        function replaceString(string) {
            	var string = string.replace(/[-_().]|1|2|3|4|5|6|7|8|9|0/ig,'');
        	    return string.replace(/  /ig,' ');
        	}


        $('#removePhoto').click(function () {
            $('#filePhoto').val('');
            $('#title').val('');
            $('.previewPhoto').css({backgroundImage: 'none'}).hide();
            $('.filer-input-dragDrop').removeClass('hoverClass');
        });

        //================== START FILE IMAGE FILE READER
        $("#filePhoto").on('change', function () {

            var loaded = false;
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                if ($(this).val()) { //check empty input filed
                    oFReader = new FileReader(), rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/webp|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
                    if ($(this)[0].files.length === 0) {
                        return
                    }


                    var oFile = $(this)[0].files[0];
                    var fsize = $(this)[0].files[0].size; //get file size
                    var ftype = $(this)[0].files[0].type; // get file type


                    if (!rFilter.test(oFile.type)) {
                        $('#filePhoto').val('');
                        $('.popout').addClass('popout-error').html("{{ trans('misc.formats_available') }}").fadeIn(500).delay(5000).fadeOut();
                        return false;
                    }

                   
					
                        oFReader.onload = function (e) {

                        var image = new Image();
                        image.src = oFReader.result;

                        image.onload = function () {

                           
                            $('.previewPhoto').css({backgroundImage: 'url(' + e.target.result + ')'}).show();
                            $('.filer-input-dragDrop').addClass('hoverClass');
                            var _filname = oFile.name;
                            var fileName = _filname.substr(0, _filname.lastIndexOf('.'));
                            $('#title').val(replaceString(fileName));
                        };// <<--- image.onload


                    }

                    oFReader.readAsDataURL($(this)[0].files[0]);

                }
            } else {
                $('.popout').html('Can\'t upload! Your browser does not support File API! Try again with modern browsers like Chrome or Firefox.').fadeIn(500).delay(5000).fadeOut();
                return false;
            }
        });

        $('input[type="file"]').attr('title', window.URL ? ' ' : '');

        $("#tagInput").tagsInput({

            'delimiter': [','],   // Or a string with a single delimiter. Ex: ';'
            'width': 'auto',
            'height': 'auto',
            'removeWithBackspace': true,
            'minChars': 2,
            'maxChars': 25,
            'defaultText': '{{ trans("misc.add_tag") }}',
          
        });

		

		$(".onlyNumber").keydown(function (e) {
		    // Allow: backspace, delete, tab, escape, enter and .
		    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
		         // Allow: Ctrl+A, Command+A
		        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		         // Allow: home, end, left, right, down, up
		        (e.keyCode >= 35 && e.keyCode <= 40)) {
		             // let it happen, don't do anything
		             return;
		    }
		    // Ensure that it is a number and stop the keypress
		    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		        e.preventDefault();
		    }
		});
		var googleadslink = "";
</script>

@endsection
