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
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> {{ trans('contact') }} 
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
        	 <button class="btn-danger btn-md" style="width: max-content;">
            <a href="javascript:void(0);" data-url="{{ url('panel/admin/contact/deleteallcontact') }}" class="btn btn-danger btn-xs padding-btn actionTruncate">{{ trans('admin.truncate') }}</a>
            </button>     	
       	<table id="recordsTable" class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Select All <br/><input type="checkbox" class="recordAll" value=""/></th>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Subject</th>
      <th scope="col">Purpose</th>
      <th scope="col">Email</th>
      <th scope="col">Message</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  	 <?php $pos=1 ?>
  	@foreach($contacts as $contact)
    <tr onclick="selectRow(this)">
      <th scope="row"><input type="checkbox" class="record" value="{{ $contact->id }}"/></th>
      <th scope="row">{{ $contact->id }}</th>
      <td>{{ $contact->name }}</td>
      <td>{{ $contact->subject }}</td>
      <td>{{ $contact->purpose }}</td>
      <td>{{ $contact->email }}</td>
      <td style="word-wrap: break-word;overflow: auto;" >{{ $contact->message }}</td>
      <td><a href="javascript:void(0);" data-url="{{ url('panel/admin/contact/delete').'/'.$contact->id }}" class="btn btn-danger btn-xs padding-btn actionDelete">{{ trans('admin.delete') }}</a></td>
    </tr>
   <?php  $pos++; ?>
    @endforeach
  </tbody>
  </table>	
    <!-- Your Page Content Here -->
     @if( $contacts->count() != 0 )    
       {{ $contacts->links() }}
       @endif

    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
	
<script type="text/javascript">

  $(document).ready(function(){

    $(".recordAll").change(function()
    {
      var set = $(this).prop("checked");
      $("#recordsTable .record").each(function(){

        $(this).prop("checked", set);

      });

    });

  });

	$(".actionTruncate").click(function(e)
	{
    	e.preventDefault();
    	var element = $(this);
  		var url = element.attr('data-url');
      var ids = "";
      $("#recordsTable .record").each(function()
      {
        if( $(this).prop("checked") )
        {
          ids += (ids == "") ? "" : ",";
          ids += $(this).val();
        }
      });      

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
        function(isConfirm)
        {
            if (isConfirm) 
            {
                //window.location.href = url;
                var csrf = "{{csrf_token()}}";
                $.post(url,
                {
                  _token: csrf,
                  ids: ids
                },
                function(data, status)
                {
                  window.location.reload();
                });

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
@endsection
