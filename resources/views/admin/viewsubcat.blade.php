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

          @if( $data->total() !=  0 && $data->count() != 0 )   
            <form action="{{ url('panel/admin/subcategories/view/'.$id.'') }}" id="formSort" method="get">
              <select name="sort" id="sort" class="form-control input-sm" style="float:right;width: auto; padding-right: 20px;border-radius: 5px !important;margin-top: 5px;margin-right: 15px;font-size: 16px !important">
                  @if( Auth::user()->role == 'editor')
                  <option @if( $sort == 'created_by') selected="selected" @endif value="created_by">Mine</option>
                  @endif
                  <option @if( $sort == '') selected="selected" @endif value="">{{ trans('admin.sort_id') }}</option>
                  
                  <option @if( $sort == 'name') selected="selected" @endif value="name">Name</option>
                   <option @if( $sort == 'id') selected="selected" @endif value="id">ID</option>
                    <option @if( $sort == 'date') selected="selected" @endif value="date">Date</option>
                    <option @if( $sort == 'allinsta') selected="selected" @endif value="allinsta">All Scrap</option>
                    <option @if( $sort == 'instacronstatus') selected="selected" @endif value="instacronstatus">5 Scrap</option>
                </select>
                
            </form><!-- form -->
          @endif
          <h4>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> <a class="breadcrumblink" href="{{ url('panel/admin/main_category') }}">All Types</a> <i class="fa fa-angle-right margin-separator"></i> <a class="breadcrumblink" href="{{ url('panel/admin/categories').'/'.$categories->main_cat_id }}">{{$catname }} (Type)</a> <i class="fa fa-angle-right margin-separator"></i> {{ $categories->name }} (Category)
          </h4>

        </section>

        <!-- Main content -->
        <section class="content">
          <h2> Subcategories Lists of Category <b>{{ $categories->name }}</b></h2>
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
                  
                    
                            @if( $data->total() !=  0 && $data->count() != 0 )   
          <form action="{{ url('panel/admin/subcategories/view/'.$id.'') }}" id="formSearch" method="get" style="display: inline-flex;">
              <input type="text" value="<?php echo (isset($q))? $q : "";?>" name="q" id="query" class="form-control input-sm" style="border-radius: 5px !important;width: fit-content;margin: 0px 5px 0px 0px;" placeholder="Search Subcategory"/>       
              <input type="submit" name="search" value="Submit" />     
          </form>
        @endif

                    <a href="{{ url('panel/admin/subcategories/add').'/'.$id }}" class="btn btn-sm btn-success no-shadow pull-right"><i class="glyphicon glyphicon-plus myicon-right"></i> {{ trans('misc.add_new') }}
                   </a>
                 
                </div><!-- /.box-header -->







                <div class="table-responsive no-padding">
              <table class="table table-hover" style="margin-bottom: 10px;">
               
                    
            </table>
                <table class="table">
                <tbody>
                  @if( $data->count() !=  0 )
                   <tr>
                      <th class="active">ID</th>
                      <!-- <th class="active">Created By</th> -->
                      <th class="active">Thumb</th>
                      <th class="active">Name</th>
                      <!-- <th class="active">Img Title</th> -->
                      <!-- <th class="active">{{ trans('admin.tags') }}</th> -->
                      
                      <th class="active">Pending</th>
                      <th class="active">Show at Home</th>
                      <th class="active">Mode</th>
                      <th class="active">Image Title</th>
                      <th class="active">{{ trans('admin.actions') }}</th>
                      <th class="active">Upload All</th>
                      <th class="active">View</th>
                      <th class="active">Date</th>
                      <th class="active">Select Subgroup</th>
                    </tr>
                  @foreach( $data as $category )
                    <tr class="table-hover">
              

                      <td>{{ $category->id }}</td>

                     <!--  <td> @php echo ($category->created_by == 1) ? "Admin": $category->username; @endphp</td> -->

                      <td>
                        @php 
                        $thumbnail_path = config('path.img-subcategory'); @endphp
                        @if( $category->sthumbnail != "" )
                        <img width="102" height="80" src="{{Storage::url($thumbnail_path.$category->sthumbnail)}}"/>
                       
                        @else
                          <img width="102" height="80" src="{{Storage::url($thumbnail_path.$category->sthumbnail)}}"/>
                          
                        @endif
                      </td>

                      @php
                      $pendingcount = App\Helper::getSubPendingImages($category->id);
                      @endphp
                      
                      @php
                      $totalcount = App\Helper::getSubTotalImages($category->id);
                      @endphp


                      @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                      <td>
                        <p style="color: silver;cursor: not-allowed;">{{(\Illuminate\Support\Str::limit($category->name, 12, ''))}} </p> </td>

                        <td> <a style="background:#1f9e1f;width: 65px;text-align-last: center;float: right;color:white;padding:4px;font-size: 11px;border-radius:3px;font-weight:500" href="{{ url('panel/admin/subcatimages').'/'.$category->id}}"> (<b>{{$pendingcount}}/{{$totalcount}}</b>)</a>
                        </td>

                      @else
                      <td>
                        <p>{{(($category->name))}}
                        </p></td>

                        <td>
                          <a style="background:#1f9e1f;width: 65px;text-align-last: center;float: right;color:white;padding:4px;font-size: 11px;border-radius:3px;font-weight:500" href="{{ url('panel/admin/subcatimages').'/'.$category->id}}"> (<b>{{$pendingcount}}/{{$totalcount}}</b>)</a>
                        </td>
                      @endif
                      

                  <td>

                      
                        <?php if( $category->showathome == 'no' ) {
                        $mode = 'warning';
                        } elseif( $category->showathome == 'yes' ) {
                        $mode = 'success';
                        }
                        ?>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                       <div>
                        {{($category->showathome)}}
                        </div>
                        @else
                        
                        <select data-id="{{$category->id}}" class="showahometoggle label-{{$mode}}">
                        <option {{($category->showathome=='no')?"selected":""}} value="no">No</option>
                        <option {{($category->showathome=='yes')?"selected":""}} value="yes">Yes</option></select>
                        @endif
                      
                  </td>

                  <td>

                      
                        <?php if( $category->mode == 'off' ) {
                        $mode = 'warning';
                        } elseif( $category->mode == 'on' ) {
                        $mode = 'success';
                        }
                        ?>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                       <div>
                        {{($category->mode)}}
                        </div>
                        @else
                        
                        <select data-id="{{$category->id}}" class="modetoggle label-{{$mode}}">
                        <option {{($category->mode=='off')?"selected":""}} value="off">OFF</option>
                        <option {{($category->mode=='on')?"selected":""}} value="on">ON</option></select>
                        @endif
                      
                  </td>

                   <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <div style="    color: silver;cursor: not-allowed;">
                        {{\Illuminate\Support\Str::limit($category->imgtitle, 18)}}
                        </div>
                        @else
                        <input style="border: 1px solid #b8b8b8;
                        border-radius: 2px;" type="text" title="Click to Edit" readonly class="imagetitle readme" data-id="{{$category->id}}" name="trow{{$category->id}}" value="{{$category->imgtitle}}">
                        @endif
                      </td>
                      
                      <!-- <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <div style="    color: silver;cursor: not-allowed;">
                        {{\Illuminate\Support\Str::limit($category->keyword, 18)}}
                        </div>
                        @else
                        <input style="border: 1px solid #b8b8b8;
                        border-radius: 2px;" type="text" title="Click to Edit" readonly class="imagetags readme" data-id="{{$category->id}}" name="trow{{$category->id}}" value="{{$category->keyword}}">
                        @endif
                      </td>  -->
                      
                      <!-- <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <div style="color: silver;cursor: not-allowed;">{{$category->insta_username}}
                        </div>
                        @else
                        {{$category->insta_username}}
                        @endif
                      </td>  --> 

                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                            <a style="margin-right:4px" class="btn btn-success btn-xs padding-btn disable">
                            {{ trans('admin.edit') }}
                            </a>
                            <a style="margin-right:4px" href="javascript:void(0);" class="btn btn-danger btn-xs padding-btn disable">
                            {{ trans('admin.delete') }}
                            </a>
                        @else
                            <a style="margin-right:4px" href="{{ url('panel/admin/subcategories/edit/').'/'.$category->id.'/'.$id  }}" class="btn btn-success btn-xs padding-btn">
                            {{ trans('admin.edit') }}
                            </a>
                            <a style="margin-right:4px" href="javascript:void(0);" data-url="{{ url('panel/admin/subcategories/delete/').'/'.$category->id.'/'.$id }}" class="btn btn-danger btn-xs padding-btn actionDelete">
                            {{ trans('admin.delete') }}
                            </a>
                        @endif
                      </td>

                      <td> 
                        <?php if( $category->allinsta == 'no' ) {
                        $mode = 'warning';
                        } elseif( $category->allinsta == 'yes' ) {
                        $mode = 'success';
                        }
                        ?>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                       <div>
                        {{($category->allinsta)}}
                        </div>
                        @else
                        
                        <select data-id="{{$category->id}}" class="allinstasel label-{{$mode}}">
                        <option {{($category->allinsta=='no')?"selected":""}} value="no">No</option>
                        <option {{($category->allinsta=='yes')?"selected":""}} value="yes">Yes</option></select>
                        @endif
                      </td>

                      <td><a class="btn-success" target="_blank" href="{{ url('s').'/'.$category->slug}}">View</a>
                      </td>

                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )

                        @if(!is_null($category->special_date)) {{date("d-m-Y", strtotime($category->special_date))}} @endif

                        @else

                        <input type="text" title="Click to Edit" readonly class="imageDate readme" data-id="{{$category->id}}" name="trow{{$category->id}}" @if(!is_null($category->special_date)) value="{{date("d-m-Y", strtotime($category->special_date))}}" @else value="" @endif >


                        @endif
                      </td>

                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                         
                          <?php 

                          $keywords = explode(",", $category->keyword);
                          
                          foreach($keywords as $key)
                          { 
                            $key=trim($key);
                            if($category->selectedgroup==$key){
                            echo $key;
                            }

                          }
                          ?>

                        @else
                          
                      <select data-id="{{$category->id}}" class="selectSubgroup">
                        <option>--Subgroup--</option>
                        <?php $keywords = explode(",", $category->keyword);
                        foreach($keywords as $key){ $key=trim($key);?>
                          <option <?php echo ($category->selectedgroup==$key)?"selected":"";?> value="{{$key}}">{{$key}}</option>
                        <?php } ?>
                      </select>
                          

                        
                        @endif
                      </td>  


                    </tr><!-- /.TR -->
                    @endforeach

                    @else
                    <hr />
                      <h3 class="text-center no-found">{{ trans('misc.no_results_found') }}</h3>
                    @endif
                  </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>

       @if( $data->count() )
        {{ $data->appends(['sort' => $sort])->links() }}
       @endif

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

<script type="text/javascript">

  $(document).ready(function()
  {

    $(".imageDate").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".imageDate").datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
    });

    $(".selectSubgroup").change(function()
    {
      var id = $(this).data("id");
      var selectSubgroup = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updateSubgroup')}}",
      {
        _token:csrf,
        id:id,
        selectSubgroup:selectSubgroup
      },
      function(data, featured)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'SubCat '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'SubCat '+id+' updated failed';
            resclass = 'alert-danger';
          }
          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 3000);
      });  
    });

    $(".imageDate").change(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);

      var id = $(this).data("id");
      var special_date = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updatesSpecialDate')}}",
      {
        _token:csrf,
        id:id,
        special_date:special_date
      },
      function(data, featured)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'SubCat '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'SubCat '+id+' updated failed';
            resclass = 'alert-danger';
          }
          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 3000);
      });  
    });

    $("#sort").change(function(){
      $("#formSort").submit();
    });

    $(".allinstasel").change(function()
    {
      var id = $(this).data("id");
      var allinsta = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updateAllInsta')}}",
      {
        _token: csrf,
        id: id,
        allinsta: allinsta
      },
      function(data, featured)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'SubCat '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'SubCat '+id+' updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 3000);
      });

    });



     $(".showahometoggle").change(function()
    {
      var id = $(this).data("id");
      var showathome = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updateshowathome')}}",
      {
        _token: csrf,
        id: id,
        showathome: showathome
      },
      function(data, featured)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'SubCat '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'SubCat '+id+' updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 3000);
      });

    });


     $(".modetoggle").change(function()
    {
      var id = $(this).data("id");
      var mode = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updatemode')}}",
      {
        _token: csrf,
        id: id,
        mode: mode
      },
      function(data, featured)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'SubCat '+id+' updated successful';
            resclass = 'alert-success';
          } else {
            message = 'SubCat '+id+' updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("#mess").html(html);
          setTimeout(function(){
            $("#mess").html("");
          }, 3000);
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
      $.post("{{url('panel/admin/subcategories/updateTags')}}",
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
            message = 'Sub Category '+id+' Tags updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Sub Category '+id+' Tags updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("section.content").prepend(html);
          setTimeout(function(){
            $("#ajaxResponse").remove();
          }, 2000);
      });
    });

    $(".imagetitle").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".imagetitle").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = $(this).data("id");
      var imagetitle = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/subcategories/updateImageTitle')}}",
      {
        _token: csrf,
        id: id,
        imgtitle: imagetitle
      },
      function(data, status)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'Sub Category '+id+' Imagetitle updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Sub Category '+id+' Imagetitle updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("section.content").prepend(html);
          setTimeout(function(){
            $("#ajaxResponse").remove();
          }, 2000);
      });
    });

  });

$(".actionDelete").click(function(e) {
  e.preventDefault();
  var element = $(this);
  var url = element.attr('data-url');
  element.blur();
  swal({   
      title: "{{trans('misc.delete_confirm')}}",
      text: "{{trans('misc.confirm_delete_category')}}",
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
            window.location.href = url;
          }
      });
    });
</script>
<script type="text/javascript">
function selectRow(row)
{
    var firstInput = row.getElementsByTagName('input')[0];
    firstInput.checked = !firstInput.checked;
}
</script>
 @include('admin.topbottom')
@endsection
