@extends('admin.layout')

@section('css')
    <style>
        input[type='file']{
            opacity: 1;
            font-size: 14px;
            position: relative;
        }
    </style>
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> Types
          </h1>

        </section>

        <!-- Main content -->
        <section class="content">






          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">

                  <div class="box-tools">


                  </div>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                <form action="{{ url('panel/admin/maincategories/add') }}" method="post">
                  @csrf
                  <table class="table table-hover">
               <tbody>

                   <tr>
                      <th class="active">Id</th>
                      <th class="active">Name</th>
                      <th class="active">Categories</th>
                      <th class="active">Slug</th>
                      <th class="active">Image</th>
                       <th class="active">TitleAhead</th>
                      <th class="active">Edit</th>
                      <th class="active">Delete</th>
                    </tr>

                  @foreach($main_categorys as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->name }}</td>
                      <td><a class="btn btn-success btn-xs padding-btn" href="{{ url('/panel/admin/categories/'.$value->id.'')}} ">Categories</a></td>
                            <td>{{ $value->slug }} </td>
                            <td>
                                <img style="height: 50px;width: 50px;"
                                     @if($value->thumbnail) src="{{config('app.filesurl')}}/{{config('path.img-category')}}/{{$value->thumbnail}}"
                                     @else src="{{asset('default.jpg')}}" @endif
                                >
                            </td>
                            <td><input type="text" title="Click to Edit" readonly class="titleahead readme" data-id="{{$value->id}}" name="trow{{$value->id}}" value="{{$value->titleahead}}"></td>
                            <td><a class="btn btn-default delete" href="{{ url('/panel/admin/main_category/'.$value->id.'/maincategoriesedit')}} ">Edit</a></td>
                            <td><form method="post" onsubmit="return ConfirmDelete()" action="{{ url('/panel/admin/main-category/destroy') }}">
                                  @csrf
                                <input type="hidden" name="id_main" value="{{ $value->id }}"><button type="submit" class="btn btn-danger delete" >Delete</button></form></td>
                    </tr><!-- /.TR -->
                    @endforeach
                  </tbody>


                  </table>

                </form>


                </div><!-- /.box-body -->

                <!-- Add cat -->
            <div class="col-md-4">
                <h2>Add Category</h2>
                <form action="{{ url('/panel/admin/main-category/add') }}" method="POST" class="form-group" enctype="multipart/form-data" style="margin-bottom: 6px;">
                    @csrf
                    <input type="text" class="form-control" style="margin-bottom: 6px;" name="main_category" required placeholder="Category Name">
                    <input type="text" class="form-control" style="margin-bottom: 6px;" name="slug" required placeholder="Slug">
                    <input type="file" class="form-control" style="margin-bottom: 6px;" name="thumbnail" accept="image/*" placeholder="Upload" />
                    <button name="submit" class="btn btn-default mt-md-7 text-center form-control" align="center">Add Category</button>
                </form>
            </div>
            <!--  -->

              </div><!-- /.box -->
            </div>
          </div>

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')
<script type="text/javascript">

  $(document).ready(function()
  {
    $(".titleahead").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".titleahead").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = "main_category"+$(this).data("id");
      var titleahead = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/maincategories/updateTitleahead')}}",
      {
        _token: csrf,
        id: id,
        titleahead: titleahead
      },
      function(data, status)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'Main Category '+id+' Titleahead updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Main Category '+id+' Titleahead updated failed';
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

  function ConfirmDelete()
  {
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
      return false;
  }
</script>
@endsection
