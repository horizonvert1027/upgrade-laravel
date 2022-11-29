@extends('admin.layout')
@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
@endsection
<style>
td {
margin: 5px !important;
padding: 10px !important;
border-top: 1px solid lightgrey;
border-left: 1px solid lightgrey;
}
th {
border-left: 1px solid lightgrey;
margin: 5px !important;
padding: 10px !important;
}
.error{
color: red;
}
.success{
color: green;
}



/* Style tab links */
.tablink {
    background-color: #555;
    color: white;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 8px 9px;
    font-size: 17px;
    width: 100%;
    max-width: 49% !important;
}
button#defaultOpen {
    border-radius: 4px 0px 0px 4px;
    margin-right: 2px;
}
button.tablink {
    border-radius: 0px 4px 4px 0px;
    margin-left: 2px;
}
/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  display: none;
  padding: 45px 0px;
}
@media (min-width: 801px){
  .rowek {
    display: flex;
    justify-content: space-evenly;
}
}
.ekmeflex {
    display: flex;
}
.alert.alert-danger {
    position: absolute;
    display: block;
    margin: auto;
    left: 50%;
    top: 5%;
    color: var(--black-clr);
}
.svhide.hidden{
  display: none !important;
}
</style>
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h4>{{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i>
      WebScraper
      </h4>
  </section>

  <section class="content">
    <span class="message"></span>
    <div class="content" style="margin-top: -25px;">
      
        <div class="tab">
          <button id="defaultOpen" class="tablink" onclick="openPage('Lists', this, 'green')" >Lists</button>
          <button  class="tablink" onclick="openPage('Form', this, 'green')">Form</button>
          
        </div>

      <div id="Form" class="tabcontent">
        <div class="box-danger">
          <!-- form start -->
          <div class="row">
            <form class="form-horizontal webscrapper_form" method="POST" action="{{ url('panel/admin/webscrapper') }}" enctype="multipart/form-data">
              <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
              <div>
                <div class="form-group" style="margin-top: 25px;">
                  <label class="col-sm-2 control-label">Sub Category</label>
                  <div class="col-sm-10">
                    <input type="text" name="subcategory" placeholder="Search Name...">
                  </div>
                </div>
                
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Cat/SubCat/Subgroup</label>
                  <div class="col-sm-10">
                    <div class="ekmeflex">
                    <select name="category_id" id="image_catsubcat" style="width:36%">
                      <option value="">--Select--</option>
                      @foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category )
                      <option value="{{$category->id}}">{{ $category->name }}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">URL</label>
                  <div class="col-sm-10">
                    <input type="text" value="@php echo $url; @endphp" id="url" name="url"  class="" placeholder="URL">
                    <span id="nerror" class="error"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Parent Element</label>
                  <div class="col-sm-10">
                    <input type="text" value="@php echo $element; @endphp" name="element" class="" placeholder="Enter Element">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Class name of IMG Tag</label>
                  <div class="col-sm-10">
                    <input type="text"  name="class" value="@php echo $class; @endphp" class="" placeholder="Enter Class name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Title of Image</label>
                  <div class="col-sm-10">
                    <input type="text" name="title" class="" value="{{$title}}" placeholder="Enter Title">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Credits</label>
                  <div class="col-sm-10">
                    <input type="text" name="credits" class="" value="{{$credits}}" placeholder="Enter Credits">
                  </div>
                </div>


                <div class="form-group">
                  <label class="col-sm-2 control-label">MetaKeywords of Image</label>
                  <div class="col-sm-10">
                    <input type="text" class="" id="metakeywords" name="metakeywords" value="" placeholder="Enter metakeywords">
                    <p class="help-block">given values inserted before default metakeywords. i.e. <b>given, value</b>, abc, def, ghi...</p>
                  </div>
                </div>
                
                <div class="rowek">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Image Status</label>
                    <div class="col-sm-10">
                      <div class="radio">
                        <label class="padding-zero">
                        <input type="radio" name="image_status" @if( $image_status == 'pending' ) checked="checked" @endif value="pending">
                          Pending
                        </label>
                      </div>
                      <div class="radio">
                        <label class="padding-zero">
                        <input type="radio" name="image_status" @if($image_status == 'active' ) checked="checked" @endif value="active" checked>
                          active
                        </label>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Verify</label>
                    <div class="col-sm-10">
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="verify" @if( $verify == 'yes' ) checked="checked" @endif value="yes" >
                          Test it
                        </label>
                      </div>
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="verify" @if( $verify == 'no' ) checked="checked" @endif value="no" checked>
                          Directly Save
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label">Scrape</label>
                    <div class="col-sm-10">
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="autocron" @if( $autocron == 'yes' ) checked="checked" @endif value="yes" checked>
                          Scrape On
                        </label>
                      </div>
                      <div class="radio">
                        <label class="padding-zero">
                          <input type="radio" name="autocron" @if( $autocron == 'no' ) checked="checked" @endif value="no">
                          Scrape Off
                        </label>

                      </div>
                    </div>
                  </div>
                </div>
                
                <center>
                <div style="display: flex; justify-content: center">

                  <button type="button" class="btn btn-success save_webscrapper" style="width: 130px; margin-right: 5px;">
                    Save </button>
                    
                    <span class="loading hidden"><i class="fa fa-spinner fa-pulse fa-fw" style="font-size:25px"></i>&nbsp;</span> 

                <!--  <button type="button" onclick="window.open('{{url('WebScrapper')}}','targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="btn btn-success" style="width: 130px;">Start Scraping</button> -->
                  
                </div>
                </center>
                
              </div>
            </form>
          </div>
        </div>
    </div>

    <div id="Lists" class="tabcontent">
            @if( $response )
              <div class="row">
                <?php if( is_array($response) ) {
                foreach ($response as $key => $value)
                {
                echo "<img style='border:1px solid #000;margin:2px;height:100px;float:left;' src='".$value."' />";
                }
                }
                else
                ?>
              </div>
            @endif
            @if( $webscrappers->count() > 0 )
              <div class="row">
                <span id="updateresponse" style="width:100%;display:block;height:20px"></span>
                <div style="width:99%;overflow: auto;border: 1.1px solid #dddddd;border-radius: 8px;padding:0;margin:0;">
                  <table class="bordered">
                    <tr>
                      <th>Id</th>
                      <!-- <th>Cat ID</th>
                      <th>SubCat ID</th> -->
                      <th>Subgroup</th>
                      <th>Url</th>
                      <th>Element</th>
                      <th>Class</th>
                      <th>Title</th>
                      <!-- <th>Image Status</th> -->
                      <th>Autocron</th>
                      <th>Cron Status</th>
                      <th>Action</th>
                    </tr>
                    @php
                    foreach($webscrappers as $row){
                    @endphp
                    <tr>
                      <td>{{$row->id}}</td>
                      <!-- <td>{{$row->category_id}}</td>
                      <td>{{$row->subcategory_id}}</td> -->
                      <td>{{$row->subgroup}}</td>
                      <td>{{$row->url}}</td>
                      <td>{{$row->element}}</td>
                      <td>{{$row->class}}</td>
                      <td>
                        <input type="text" title="Click to Edit" readonly class="title readme" data-id="{{$row->title}}" name="title" value="{{$row->title}}">
                      </td>
                      <td><select data-id="{{$row->id}}" class="autocron">
                        <option <?php echo ($row->autocron=='yes')?"selected":"";?> value="yes">Yes</option>
                        <option <?php echo ($row->autocron=='no')?"selected":"";?> value="no">No</option>
                      </select></td>
                      <!-- <td>{{$row->image_status}}</td> -->
                      <td>{{$row->cron_status}}</td>
                      <td><a href="{{url('panel/admin/webscrapper/delete/'.$row->id)}}" class="btn btn-danger">Delete</a></td>
                    </tr>
                    @php
                    }
                    @endphp
                  </table>

                </div>
              </div>
            @endif
            
 @if( $webscrappers->count() != 0 )    
       {{ $webscrappers->links() }}
  @endif

      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


@endsection

@section('javascript')
      <!-- icheck -->
      <script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.js') }}" type="text/javascript"></script>
      <script type="text/javascript">

function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

      var titlepart2 = new Array();
      titlepart2[2] = 'Full HD Wallpapers';
      titlepart2[223] = 'Full HD';
      titlepart2[0] = 'Full HD Backgrounds Images Pictures';
      titlepart2[1] = 'PNGs Transparent Images';
      titlepart2[5] = 'Images, Pictures, Photos';
      var titlepart3 = new Array();
      titlepart3[31] = 'Wallpapers, Photos, Pictures, WhatsApp Status DP';
      var domainParent = new Array();
      domainParent['wallpapercave.com'] = 'a';
      domainParent['pngimg.com'] = 'div';
      var imgclass = new Array();
      imgclass['wallpapercave.com'] = 'wpinkw';
      imgclass['pngimg.com'] = 'png_png png_imgs';
      function updateTitle(subgrp)
      {
      var catid = $("#image_catsubcat").val();
      var sucatname = $("#imgsubcat option:selected").text();
      var title = ""+subgrp+" ";
      if(typeof titlepart2[catid] === 'undefined') {
      //
      }
      else
      {
      title += titlepart2[catid]+" ";
      }
      if(typeof titlepart3[catid] === 'undefined') {
      //
      }
      else
      {
      title += titlepart3[catid];
      }
      $("#metakeywords").val(subgrp)
      $("input[name='title']").val(title);
      }
      $(document).ready(function()
      {
      $(".autocron").change(function(){
      $("#updateresponse").removeClass('success').removeClass('error').html("Updating Record...");
      var id = $(this).data('id');
      var autocron = $(this).val();
      var csrf = $("#csrf_token").val();
      $.post("{{url('/panel/admin/updatewebscrapper')}}",{id:id,autocron:autocron,_token:csrf},
      function(data, status)
      {
      if( data.indexOf('failed') != -1 )
      {
      $("#updateresponse").addClass('error').html(data);
      }
      else
      {
      $("#updateresponse").addClass('success').html(data);
      }
      });
      });
      
      $(".title").click(function()
      {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
      });
      $(".title").blur(function()
      {
      $("#updateresponse").removeClass('success').removeClass('error').html("Updating Record...");
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = $(this).data('id');
      var title = $(this).val();
      var csrf = $("#csrf_token").val();
      $.post("{{url('/panel/admin/updatewebscrappertitle')}}",{id:id,title:title,_token:csrf},
      function(data, status)
      {
      if( data.indexOf('failed') != -1 )
      {
      $("#updateresponse").addClass('error').html(data);
      }
      else
      {
      $("#updateresponse").addClass('success').html(data);
      }
      });
      });
      <?php
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
      $("input[name='subcategory']").autocomplete({
      source: allsubs,
      minLength: 2,
      open: function(){ $(".linksblock").html(''); },
      select: function( event, ui )
      {
      var category = "";
      var subcategory = "";
      $(".linksblock").html('');
      var sub = ui.item.value.trim();
      $("input[name='subcategory']").val(sub);
      $.each(allsubsmap, function(i, obj)
      {
      var d = obj.split("|");
      if( d[1] == sub )
      {
      subcategory = i;
      category = d[0];
      }
      });
      $("#image_catsubcat").val(category);
      $("#image_catsubcat").trigger('change');
      setTimeout(function()
      {
      if( $("#imgsubcat").length )
      {
      $("#imgsubcat").val(subcategory);
      $("#imgsubcat").trigger('change');
      }
      }, 1000);
      }
      });
      $("#url").blur(function()
      {
      var url = $(this).val();
      var csrf = $("#csrf_token").val();
      $.post("{{url('/panel/admin/checkwebscrapperurl')}}",{url:url,_token:csrf},
      function(data, status)
      {
      $("#nerror").html(data);
      });
      if( url.search('wallpapercave.com') != -1 )
      {
      $("input[name='element']").val(domainParent['wallpapercave.com']);
      $("input[name='class']").val(imgclass['wallpapercave.com']);
      }
      else if( url.search('pngimg.com') != -1 )
      {
      $("input[name='element']").val(domainParent['pngimg.com']);
      $("input[name='class']").val(imgclass['pngimg.com']);
      }
      else
      {
      $("input[name='element']").val('');
      $("input[name='class']").val('');
      }
      });
      $(document).on("change","#subgroup",function(){
      let sub_grp = $(this).val();
      updateTitle(sub_grp);
      })
      $("#image_catsubcat").change(function()
      {
      var ele = $(this);
      ele.parent().find("#imgsubcat").eq(0).remove();
      ele.parent().find("#subgroup").eq(0).remove();
      var category = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.get("{{url('getsubcat/')}}/"+category,
      function(data, status)
      {
    ele.parent().append("<select style='width:36%;padding:6px 20px 6px 8px;' name='subcategory_id' id='imgsubcat'>"+data+"</select>");
    setTimeout(function(){
    $("#imgsubcat").change(function()
    {
    var ele = $(this);
    ele.parent().find("#subgroup").eq(0).remove();
    var category = $(this).val();
    var csrf = "{{csrf_token()}}";
    $.get("{{url('getsubgroup/')}}/"+category,
    function(data, status){
  ele.parent().append("<select style='width:36%;padding:6px 20px 6px 8px;' name='subgroup' id='subgroup'>"+data.data+"</select>");
  updateTitle(data.select_subgroup);
  });
  });
  }, 100);
  });
  });
  });
  $(".save_webscrapper").on("click", function(e){
  let link = $(this).parents('form').attr('action');
  let formData = $(this).parents('form').serializeArray();
  $(".loading").removeClass('hidden');
  $.ajax({
  url: link,
  dataType: "JSON",
  type: "POST",
  data: formData,
  success: function (data){
  if (data.success === true){
  $(".loading").addClass('hidden');
  $(".message").html(`
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><i class="fa fa-check margin-separator"></i> ${data.message}
  </div>`)
  }
  },
  error: function(){
  $(".loading").addClass('hidden');
  $(".message").html(`
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close margin-separator"></i></span></button> Data Saved!
  </div>`)
  }
  })
  })
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