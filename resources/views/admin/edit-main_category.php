@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
    <div class="container">

            <div class="col-md-4">
                <h2>Add Category</h2>
                <form action="{{ url('/panel/admin/main-category/mainupdate/'.$main->name) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input type="text" class="form-control" value="{{$main->name}}" name="main_category" required placeholder="Category Name">
                    <input type="text" class="form-control" value="{{$main->titleahead}}" name="titleahead" required placeholder="Titleahead">
                    <input type="text" class="form-control" value="{{$main->slug}}" name="slug" required placeholder="Slug">
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
