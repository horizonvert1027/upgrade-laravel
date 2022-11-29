@extends('admin.layout')

@section('content')

<style type="text/css">
  .content{
    padding-left: 30px;
    padding-right: 30px;
    background: white
  }
  .skin-red .content-header {
    background: white!important;
}

.content-wrapper, .right-side {
    background-color: #ffffff !important;
}

.box{
  box-shadow: 0 0 8px #1a0b4e43;
  border-top: 3px solid #ff6868;
  border-radius: 12px;
}

img {
    border-radius: 4px;
}

@media (max-width: 900px)
{
  .content {
    padding-left: 7px;
    padding-right: 7px;
}
</style>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> {{$user->name}} Subcategories
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

        	<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"> Sub Category</h3>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                <table class="table">
                <tbody>
               	  @if( $data->count() !=  0 )
                   <tr>
                      <th class="active">ID</th>
                      <th class="active">Thumb</th>
                      <th class="active">Name <p style="float: right;"> Pending </p> </th>
                      <th class="active">Username ID</th>
                      <th class="active">{{ trans('admin.actions') }}</th>
                      <th class="active">Upload All</th>
                      <th class="active">View</th>
                    </tr>
                  @foreach( $data as $category )
                    <tr class="table-hover">
                      <td>{{ $category->id }}</td>
                      <td>@php $thumbnail_path  = config('path.img-subcategory');  if( $category->sthumbnail != "" ) { @endphp
                        <img style="width:100px;height:75px;" src="{{Storage::url($thumbnail_path.$category->sthumbnail)}}"/>
                        @php } else { } @endphp
                      </td>
                      @php
                      $pendingcount = App\Helper::getSubPendingImages($category->id);
                      @endphp
                      
                        @php
                      $totalcount = App\Helper::getSubTotalImages($category->id);
                      @endphp

                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <p style="color: silver;cursor: not-allowed;">{{(\Illuminate\Support\Str::limit($category->name, 12, ''))}} &nbsp; <a style="background:#1f9e1f;width: 65px;text-align-last: center;float: right;color:white;padding:4px;font-size: 11px;border-radius:3px;font-weight:500" href="{{ url('panel/admin/subcatimages').'/'.$category->id}}"> (<b>{{$pendingcount}}/{{$totalcount}}</b>)</a></p>
                        @else
                        <p>{{(\Illuminate\Support\Str::limit($category->name, 12, ''))}} &nbsp; <a style="background:#1f9e1f;width: 65px;text-align-last: center;float: right;color:white;padding:4px;font-size: 11px;border-radius:3px;font-weight:500" href="{{ url('panel/admin/subcatimages').'/'.$category->id}}"> (<b>{{$pendingcount}}/{{$totalcount}}</b>)</a></p>
                        @endif
                      </td> 
                      
                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <div style="color: silver;cursor: not-allowed;">{{$category->insta_username}}
                        </div>
                        @else
                        {{$category->insta_username}}
                        @endif
                      </td>  

                      <td>
                        @if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
                        <a style="
                        background-color: #00a65a66;
                        border-color: #008d4c0f;    cursor: not-allowed;" href="{{ url('panel/admin/subcategories/edit/').'/'.$category->id.'/'.$category->categories_id  }}" class="btn btn-success btn-xs padding-btn">
                        {{ trans('admin.edit') }}
                        </a>
                        <a style="background-color: #dd4b3940;
                        border-color: #d7392500;    cursor: not-allowed;" href="javascript:void(0);" data-url="{{ url('panel/admin/subcategories/delete/').'/'.$category->id.'/'.$category->categories_id }}" class="btn btn-danger btn-xs padding-btn actionDelete">
                        {{ trans('admin.delete') }}
                        </a>
                        @else
                        <a href="{{ url('panel/admin/subcategories/edit/').'/'.$category->id.'/'.$category->categories_id  }}" class="btn btn-success btn-xs padding-btn">
                        {{ trans('admin.edit') }}
                        </a>
                        <a href="javascript:void(0);" data-url="{{ url('panel/admin/subcategories/delete/').'/'.$category->id.'/'.$category->categories_id }}" class="btn btn-danger btn-xs padding-btn actionDelete">
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
                        
                      <select data-id="{{$category->id}}" class="allinstasel label-{{$mode}}" style="width: 60px">
                        <option {{($category->allinsta=='no')?"selected":""}} value="no">No</option>
                        <option {{($category->allinsta=='yes')?"selected":""}} value="yes">Yes</option>
                      </select>
                      
                      </td>
                      <td style="padding-top: 12px;"><a target="_blank" style="background: #1f9e1f;
                      color: white;
                      padding: 5px 11px 5px;
                      font-size: 12px;
                      border-radius: 3px;" href="{{ url('s').'/'.$category->slug}}">View</a>
                      </td>

                    </tr>
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
        {{ $data->links() }}
       @endif

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

<script type="text/javascript">

  $(document).ready(function(){

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

          var html = "<span class='"+resclass+"' id='ajaxResponse'>"+message+"</span>";
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
@endsection
