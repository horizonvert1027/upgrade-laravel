@extends('admin.layout')

@section('content')

<style>
 .imagetle, .imagetags {
    cursor: pointer;
    min-width: 200px;
}

    div#cke_editor_content_6848 {
    width: 30px !important;
}
input[type=checkbox], input[type=radio] {
    height: 25px !important;
    width: 25px !important;
    cursor: pointer !important;
}
</style>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>


           {{ trans('admin.admin') }} | <a class="breadcrumblink" href="{{ url('panel/admin/subcategories/view/').'/'.$subcat->categories_id}}" >{{($catname)}} </a> | <a class="breadcrumblink" href="{{ url('s/').'/'.$subcat->slug}}" > View {{$subcat->name}}</a> | <a class="breadcrumblink" href="{{ url('panel/admin/subcategories/edit/').'/'.$subcat->id.'/'.$subcat->categories_id}}" > Edit {{$subcat->name}} <i class="fa fa-pencil"></i></a> | </i> {{$subcat->name}} ({{$data->total()}}) 
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
<span id="mess"></span>
@if(Session::has('alert_message'))
<div class="alert danger-success">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
  </button>
  <i class="fa fa-close margin-separator"></i> {{ Session::get('alert_message') }}
</div>
@endif

          <div class="row">
            <div class="col-xs-12">

              <div class="box">
  <div class="box-header">
    @php $sort = urldecode(trim($sort)); @endphp
    <div class="box-tools">
      <form action="{{ url('panel/admin/subcatimages/'.$subcat->id) }}" id="formSort" method="get">
        <select name="sort" id="sort" class="form-control input-sm">
          <option @if( $sort == '') selected="selected" @endif value="">{{ trans('admin.sort_id') }}</option>
          <option @if( $sort == 'pending') selected="selected" @endif value="pending">{{ trans('admin.pending') }}</option>
          <option @if( $sort == 'featured') selected="selected" @endif value="featured">Featured </option>
          <option @if( $sort == 'title') selected="selected" @endif value="title">{{ trans('admin.sort_title') }}</option>
          @php
          $mkeys = explode(",",$subcat->keyword);
          foreach( $mkeys as $k ) {
          $count = isset($sgdata[$k]) ? $sgdata[$k] : 0;
          if( $k != "" ) {
          $k = trim($k);
          @endphp
          <option @if( $sort == $k) selected="selected" @endif value="{{$k}}">SG:({{$count}}){{$k}}</option>
          @php } } @endphp
          <option @if( $sort == 'nogroup') selected="selected" @endif value="nogroup">SG:NoGroup</option>
        </select>
        <!-- <a id="deleteallpending" class="btn btn-danger" href="#" >Delete All Pending Images</a> -->
        <!-- <div id="mess" style="font-weight:bold;padding-left:5px;border:1px solid white;width:40%;margin-left:10%;line-height: 28px;">
          &nbsp;
        </div> -->
      </form>
      <form  role="search" autocomplete="off" action="{{ url('panel/admin/images') }}" method="get">
        <div class="input-group input-group-sm">
          <input type="text" name="q" class="pull-right" placeholder="Search">
          <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </form><!-- form -->
    </div> 
  </div><!-- /.box-header -->
      
      <div class="box-body" id="delete-loader" style="font-size: 20px;display: none;" align="center" >
        <div >
          <div class="text-success">Please wait while we updating images...</div>
          <img  src="{{URL::to('/').'/public/img/loader-bar.gif'}}">
        </div>
        <audio id="alert-sound" src="{{URL::to('/').'/public/audio/sweet-notification-alert.wav'}}" preload="auto"></audio>
      </div>

    <div class="box-body table-responsive no-padding">
      <table class="table table-hover">
        <tbody>
          <tr>
            <th>Select All</th>
            <th> Title </th>
            <!-- <th> DESCR </th> -->
            <th> Status </th>
            <th> Cat-Subcat </th>
            <th> SubGroup </th>
            <th> Tags </th>
            <th> Delete </th>
            <th> Save All </th>
          </tr>
          <tr>
            <div style="display: inline-block;">
              <td><input type="checkbox" id="checkall" name="checkall" class="pull-left" placeholder="SelectAll"></td>
              <td style="padding: 20px;"> <input style="width: -webkit-fill-available;" type="text" id="alltitle" name="title" class="pull-left" style="width:200px;" placeholder="Title"></td>
              <!--
              <td> <textarea style="margin-top: 5px;
                /* padding: 10px; */
                border: 1px solid #d5d5d5;
              border-radius: 4px;" id="alldescr" value="{{ old('descr') }}" name="descr" class="pull-left" style="width:250px;" placeholder="Descr"></textarea></td> -->
              <td style="padding: 20px;">
                <select style="width: fit-content; padding:6px 10px 6px 8px;" id="image_status">
                  <option value="pending">Pending</option>
                  <option selected value="active">Active</option>
                </select>
              </td>
              <td style="padding: 20px;">
                <select style="width: fit-content; padding: 6px 20px 6px 8px;" id="image_catsubcat">
                  <option value="">--Select--</option>
                  @foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category )
                  <option value="{{$category->id}}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </td>
              <td style="padding: 20px;">
                <select style="width: fit-content; padding: 6px 20px 6px 8px;" id="subgroup">
                  <option value="">--Select--</option>
                  @php
                  $subcatrow = App\subcategories::where('id',$subcat->id)->get();
                  if( $subcatrow[0]->keyword != '' ){
                  $keys = explode(",",$subcatrow[0]->keyword);
                  foreach($keys as $k){ @endphp
                  <option value="{{$k}}">{{$k}}</option>
                  }
                  @php } } @endphp
                </select>
              </td >
              <td style="padding: 20px;"><input style="width: -webkit-fill-available;" type="text" id="alltags" name="tags" class="pull-left" style="width:200px;" placeholder="AllTags"></td>
              <td ><input type="checkbox" id="deleteall" value="yes" name="deleteall" title="Check to Delete Selected" class="pull-left"></td>
              
              <td> <button style="padding:5px 15px;margin-top:0px;" type="button" id="checkallupdate" class="btn btn-default">Save</button></td>
            </div>
          </tr>
        </tbody>
      </table>
    </div>

</div>
              <div class="box">
                  <div class="box-body table-responsive no-padding">
                      @if( $data->count() != 0 )    
             {{ $data->appends(['q' => $query, 'sort' => $sort])->links() }}
             @endif
                  <table class="table table-hover">
                <tbody>
                @if( $data->total() !=  0 && $data->count() != 0 )
                   <tr>
                    <th class="active">Select</th>
                      <th class="active">{{ trans('misc.thumbnail') }}</th> 
                      <th class="active">{{ trans('admin.actions') }}</th>
                      <th class="active">ID</th>
                      <th class="active">{{ trans('admin.title') }}</th>
                      <th class="active">{{ trans('admin.status') }}</th>
                      <th class="active">Cat - Subcat</th>
                      <!-- <th class="active">{{ trans('admin.type') }}</th> -->
                      <th class="active">{{ trans('admin.tags') }}</th>
                      
                    </tr>
                  @foreach( $data as $image )
                    <?php if( $image->status == 'pending' ) {
                            $mode    = 'warning';
                            $_status = trans('admin.pending');
                          } elseif( $image->status == 'active' ) {
                            $mode = 'success';
                            $_status = trans('admin.active');
                          }
                      ?>
                    <tr onclick="selectRow(this)">
                      <td>
                        <input type="checkbox"  class="imagerow" name="row{{$image->id}}" value="{{$image->id}}">
                      </td>

                      <td>
                        <img src="{{config('app.filesurl').(config('path.preview').$image->preview)}}" width="120" />
                      </td>


                      <td>
                        <div class="pad">
                        <a style="margin-top: 5px" href="{{ url('panel/admin/images', $image->id) }}" class="btn btn-success btn-xs padding-btn">
                         <i class="fa fa-pencil"></i>
                        </a>  
                           {!! Form::open([
                          'method' => 'POST',
                          'url' => 'panel/admin/images/delete',
                          'class' => 'displayInline'
                        ]) !!}
                        
                        {!! Form::hidden('id',$image->id ); !!}
                        <button style="margin-top: 5px" type="submit" data-url = "{{$image->id}}" class="btn btn-danger btn-xs padding-btn actionDelete"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}                         
                        </td>


                      <td>

                        <div class="pad">
                        <div class="imgid">
                          {{ $image->id }}
                        </div>

                          <a style="margin-top: 5px" class="imglink" href="{{ url('photo', $image->id) }}" target="_blank">Link&nbsp;<i class="fa fa-external-link-square"></i></a>
                        </a>
                      </div>
                      </td>

                      <td>
                        <input type="text" title="Click to Edit" readonly class="imagetle readme" data-id="{{$image->id}}" name="title" value="{{$image->title}}">
                       
                      </td>
                      
                      <td><select data-id="{{$image->id}}" class="readsel label-{{$mode}}">
                        <option {{($image->status=='pending')?"selected":""}} value="pending">Pending</option>
                        <option {{($image->status=='active')?"selected":""}} value="active">Active</option></select></td>
                      <td><select data-id="{{$image->id}}" class="readcatsubcat">
                        <option value="">-Select-</option>
                        @foreach(  App\Models\Categories::where('mode','on')->orderBy('name')->get() as $category )   
                            <option @if( $image->categories_id == $category->id ) selected="selected" @endif value="{{$category->id}}">{{ $category->name }}</option>
                        @endforeach</select></td>
                                   
                      <td>
                        <input type="text" title="Click to Edit" readonly class="imagetags readme" data-id="{{$image->id}}" name="tags" value="{{$image->metakeywords}}" >
                      </td>
                      

                      
                    </tr><!-- /.TR -->
                    @endforeach
                    @else
                      <h3 class="text-center no-found">{{ trans('misc.no_results_found') }}</h3>
                      @if( isset( $query ) || isset( $sort )  )
                      <div class="col-md-12 text-center padding-bottom-15">
                        <a href="{{ url('panel/admin/subcategories/view/').'/'.$subcat->categories_id}}" class="btn btn-sm btn-danger">{{ trans('auth.back') }}</a>
                      </div>
                      @endif
                    @endif              
                  </tbody>
                  </table>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
          @if( $data->count() != 0 )    
             {{ $data->appends(['q' => $query, 'sort' => $sort])->links() }}
             @endif
            </div>
          </div>          
          <!-- Your Page Content Here -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
  
<script type="text/javascript">

$(function(){
    $('.read_descr').each(function(e){
        CKEDITOR.replace( this.id, {
                allowedContent: true,
                    on: {
                      blur: function( evt ){        
                       // console.log(evt.editor.getData());

                   var element=evt.editor.element.$;

                   var id=$(element).data('id');

                        
                    var descr = evt.editor.getData();


                    var csrf = "{{csrf_token()}}";
                    $.post("{{url('panel/admin/images/updateImage')}}",
                    {
                      _token: csrf,
                      id: id,
                      descr: descr
                    },
                    function(data, status)
                    {
                      var message = '';
                      var resclass = '';
                        if( data )
                        {
                          message = 'Image '+id+' updated successful';
                          resclass = 'alert-success';
                        } else {
                          message = 'Image '+id+' updated failed';
                          resclass = 'alert-danger';
                        }

                        var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
                        $("#mess").html(html);
                        setTimeout(function(){
                          $("#mess").html("");
                        }, 2000);
                    });






                      },
  
                    }
            });
    });
  });

  $(document).ready(function()
  {

    $("#deleteallpending").click(function(){

      $('#delete-loader').show();
      var categories_id = '{{$subcat->categories_id}}';
      var subcategories_id = '{{$subcat->id}}';
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcatimages/deleteAllPending')}}",
      {
        _token: csrf,
        categories_id: categories_id,
        subcategories_id: subcategories_id
      },
      function(data, status)
      {
        $('#delete-loader').hide();
        document.getElementById('alert-sound').play();
        var message = '';
        var resclass = '';
          if( data )
          {

            message = 'Pending Images delete successful';
            resclass = 'alert-success';
          } else {
            message = 'Pending Images delete failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function()
          {
            location.reload();
          }, 300);
      });
    });

    $("#checkall").click(function(){
      var val = $(this).prop("checked");
      $(".imagerow").each(function(){
        $(this).prop("checked", val);
      });
    });

    $("#checkallupdate").click(function(){
      var cnt = $(".imagerow:checked").length;
      if( cnt )
      {
        $('#delete-loader').show();

        var title = $("#alltitle").val();
        var status = $("#image_status").val();
         var descr = $("#alldescr").val();
        var categories_id = $("#image_catsubcat").val();
        var subcategories_id = ''; 
        if( $("#imgsubcat").length ){
          subcategories_id = $("#imgsubcat").val();  
        }
        var subgroup = $("#subgroup").val();  
        var tags = $("#alltags").val();
        var deleteall = 'no';
        if( $("#deleteall").prop("checked") )
        {
          deleteall = 'yes';
        }
        
        var id = "";
        $(".imagerow:checked").each(function(){
          id += (id == "") ? "" : ",";
          id += $(this).val(); 
        });
        var csrf = "{{csrf_token()}}";
        $.post("{{url('panel/admin/images/updateImage')}}",
        {
          _token: csrf,
          id: id,
          descr: descr,
          tags:tags,
          deleteall:deleteall,
          title: title,
          categories_id:categories_id,
          subcategories_id:subcategories_id,
          subgroup:subgroup,
          status:status
        },
        function(data, status)
        {
          $('#delete-loader').hide();
          document.getElementById('alert-sound').play();
          var message = '';
          var resclass = '';
            if( data )
            {

              message = 'Image '+id+' updated successful';
              resclass = 'alert-success';
            } else {
              message = 'Image '+id+' updated failed';
              resclass = 'alert-danger';
            }

            var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
            $("#mess").html(html);
            setTimeout(function()
            {
              location.reload();
            }, 100);
        });
      } else{       
        alert("Please select atleast 1 image.");
      }

    });

    $(".imagetle").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".readsel").change(function()
    {
      var id = $(this).data("id");
      var title = "";
      var status = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/images/updateImage')}}",
      {
        _token: csrf,
        id: id,
        title: title,
        status:status
      },
      function(data, status)
      {
          var message = '';
          var resclass = '';
          if( data )
          {
            message = 'Image '+id+' updated successful';
            resclass = 'alert-success';
            document.getElementById('alert-sound').play();
          } else {
            message = 'Image '+id+' updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 2000);
      });

    });
    

    $(".readcatsubcat").change(function()
    {
      var ele = $(this);
      ele.parent().find("#imgsubcat").eq(0).remove();
      var category = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.get("{{url('getsubcat/')}}/"+category,
      function(data, status)
      {
        ele.parent().append("<div id='imgsubcat'><select>"+data+"</select><button class='btn btn-sm btn-danger'>Cancel</button>&nbsp;&nbsp;<button class='btn btn-sm btn-primary'>Update</button></div>");

        $("#imgsubcat .btn-danger").click(function()
        {
            $(this).parent().remove();
        });

        $("#imgsubcat .btn-primary").click(function()
        {
            var ele = $(this);
            var imageid = $(this).parent().parent().find(".readcatsubcat").eq(0).data('id');
            var categories_id = $(this).parent().parent().find(".readcatsubcat").eq(0).val();
            var subcategories_id = $(this).parent().find("select").eq(0).val();
            console.log(imageid, categories_id, subcategories_id);

            var csrf = "{{csrf_token()}}";
            $.post("{{url('panel/admin/images/updateImage')}}",
            {
              _token: csrf,
              id: imageid,
              categories_id: categories_id,
              subcategories_id: subcategories_id,
            },
            function(data, status)
            {
              ele.parent().remove();
              var message = '';
              var resclass = '';
                if( data )
                {
                  message = 'Image '+imageid+' Cat and Subcat updated successful';
                  resclass = 'alert-success';
                } else {
                  message = 'Image '+id+' Cat and Subcat updated failed';
                  resclass = 'alert-danger';
                }
                var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
                $("#mess").html(html);
                setTimeout(function(){
                  $("#mess").html("");
                }, 2000);

            });

        });

      });
    });
  $(".read_descr").blur(function()
    {
      var id = $(this).data("id");
      var descr = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/images/updateImage')}}",
      {
        _token: csrf,
        id: id,
        descr: descr
      },
      function(data, status)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'Image '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Image '+id+' updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 2000);
      });
    });
    
    $("#image_catsubcat").change(function()
    {
      var ele = $(this);
      ele.parent().find("#imgsubcat").eq(0).remove();
      var category = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.get("{{url('getsubcat/')}}/"+category,
      function(data, status)
      {
        ele.parent().append("<select id='imgsubcat'>"+data+"</select>");        
      });
    });
    
    $(".imagetags").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".imagetags").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = $(this).data("id");
      var tags = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/images/updateImageTags')}}",
      {
        _token: csrf,
        id: id,
        tags: tags
      },
      function(data, status)
      {
          var message = '';
          var resclass = '';
          if( data )
          {
            message = 'Image '+id+' Tag updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Image '+id+' Tags updated failed';
            resclass = 'alert-danger';
          }
          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html('');
          }, 2000);
      });
    });

    $(".imagetle").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = $(this).data("id");
      var title = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/images/updateImage')}}",
      {
        _token: csrf,
        id: id,
        title: title
      },
      function(data, status)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'Image '+id+' Title updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Image '+id+' Title updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html('');
          }, 2000);

      });

    });

  });

  $(document).on('change','#sort',function(){
    $('#formSort').submit();
   });
   
  $(".actionDelete").click(function(e) {
    e.preventDefault();     
    var element = $(this);
    var id     = element.attr('data-url');
    var form    = $(element).parents('form');
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
        }, 
        function(isConfirm){  
           if (isConfirm) {   
            form.submit(); 
            //$('#form' + id).submit();
            }
        });      
     });
function selectRow(row)
{
    var firstInput = row.getElementsByTagName('input')[0];
    firstInput.checked = !firstInput.checked;
}
</script>
 @include('admin.topbottom')
@endsection
