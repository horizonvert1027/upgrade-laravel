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
    <div class="content-wrapper">
    <div class="container">

            <div class="col-md-4">
                <h2>Add Category</h2>
                <form action="{{ url('/panel/admin/main-category/mainupdate/'.$main->id) }}" method="POST" enctype="multipart/form-data">
                 @method('PATCH')
                    @csrf
                    <input type="text" class="form-control" style="margin-bottom: 6px;" value="{{$main->name}}" name="main_category" required placeholder="Category Name">
                    <input type="text" class="form-control" style="margin-bottom: 6px;" value="{{$main->titleahead}}" name="titleahead" required placeholder="Titleahead">
                    <input type="text" class="form-control" style="margin-bottom: 6px;" value="{{$main->slug}}" name="slug" required placeholder="Slug">
                    <div class="row" style="margin-left: 0px; margin-right: 0px;">
                        <input type="file" class="form-control" style="margin-bottom: 6px;" value="{{$main->thumbnail}}" name="thumbnail" placeholder="Upload..">
                        <span style="margin-bottom: 6px; position: absolute;right: 0;margin: -47px;"><img height="50px" width="50px" src="{{asset('public/temp/'.$main->thumbnail)}}"></span>
                    </div>
                <button name="submit" class="btn btn-default mt-md-7 text-center" align="center">Update</button>
                </form></div>

    </div>
    </div>
    @endsection



@section('javascript')
<script type="text/javascript">
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
