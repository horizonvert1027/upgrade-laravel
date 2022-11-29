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
     {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> Empty Searches 
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

    <span style="display:block;width:200px;float:left;">
      <label style="float:left;float:left;line-height:29px;font-size:18px;padding-right:10px;">Select All : </label><input style="width: 20px;height:20px;" type="checkbox" id="checkall" name="checkall" class="pull-left" placeholder="SelectAll">
    </span>

    <button class="imglink actionDeleteMultiple" style="width: max-content; ">{{ trans('admin.delete') }}</button> 
      
    <a style="width: max-content;" href="javascript:void(0);" data-url="{{ url('panel/admin/emptysearch/deleteall') }}" class="imglink actionTruncate">{{ trans('admin.truncate') }}</a>
       
  <div id="mess"></div>
 	<table class="table table-hover">
  <thead>
    <tr>
      <th>Select</th>
      <th scope="col">ID</th>
      <th scope="col">Keyword</th>
      <th scope="col">Created</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  	 <?php $pos=1 ?>
  	@foreach($emptysearchs as $empty)
    <tr onclick="selectRow(this)" id="tr{{$empty->id}}" >
      <td><input type="checkbox" class="selectedrow" name="row{{$empty->id}}" value="{{$empty->id}}"></td>
      <th scope="row">{{ $empty->id }}</th>
      <td>{{ $empty->q }}</td>
      <td>{{ $empty->created }}</td>
      <td><a href="javascript:void(0);" data-url="{{ url('panel/admin/emptysearch/delete').'/'.$empty->id }}" class="btn btn-danger btn-xs padding-btn actionDelete">{{ trans('admin.delete') }}</a></td>
    </tr>
   <?php  $pos++; ?>
    @endforeach
  </tbody>
</table>
   @if( $emptysearchs->count() != 0 )    
   {{ $emptysearchs->links() }}
   @endif

<!-- Create here paginTION OF 15 ITEMS IN EACH PAGE -->
        	
          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
	
<script type="text/javascript">

  $(document).ready(function(){

    $("#checkall").click(function(){
      var val = $(this).prop("checked");
      $(".selectedrow").each(function(){
        $(this).prop("checked", val);
      });
    });

    $(".actionDeleteMultiple").click(function()
    {
      var cnt = $(".selectedrow:checked").length;
      if( cnt )
      {
        var id = "";
        $(".selectedrow:checked").each(function(){
          id += (id == "") ? "" : ",";
          id += $(this).val(); 
        });
        var csrf = "{{csrf_token()}}";
        $.post("{{url('panel/admin/emptysearch/deletemultiple')}}",
        {
          _token: csrf,
          id: id,
        },
        function(data, status)
        {
          var message = '';
          var resclass = '';
          if( data != 0 )
          {
            message = 'Record '+id+' delete successful';
            resclass = 'alert-success';
          } else {
            message = 'Record '+id+' delete failed';
            resclass = 'alert-danger';
          }

          var allsel = id.split(",");
          var len = allsel.length;
          for(var i=0; i < len;i++)
          {
            $("#tr"+allsel[i]).remove();
          }
          var html = "<span class='"+resclass+"' id='ajaxResponse'>"+message+"</span>";
          $("#mess").html(html);
          setTimeout(function()
          {
            $("#mess").html("");
          }, 3000);
        });
      } else{       
        alert("Please select atleast 1 record.");
      }
    });

  });

  $(".actionTruncate").click(function(e)
  {
      e.preventDefault();
      var element = $(this);
      var url = element.attr('data-url');
      element.blur();
      swal({
      title: "{{trans('misc.delete_confirm')}}",
      text: "{{trans('misc.delete_all')}}",
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

  $(".actionDelete").click(function(e) {
      e.preventDefault();
      var element = $(this);
      var url = element.attr('data-url');
      element.blur();
      swal({
      title: "{{trans('misc.delete_confirm')}}",
      text: "{{trans('misc.delete')}}",
        type: "warning",
        showLoaderOnConfirm: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "{{trans('misc.yes_confirm')}}",
        cancelButtonText: "{{trans('misc.cancel_confirm')}}",
        closeOnConfirm: false,
        },
        function(isConfirm)
        {
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
