@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> <a class="breadcrumblink" href="{{ url('panel/admin/main_category') }}">Types</a> <i class="fa fa-angle-right margin-separator"></i> <b>{{$name}}</b> {{ trans('misc.categories') }} Lists ({{$data->count()}})
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
                  <h3 class="box-title"> {{ trans('misc.categories') }}</h3>
                 
                    <a href="{{ url('panel/admin/categories/add').'/'.$id }}" class="btn btn-sm btn-success no-shadow pull-right">
                      <i class="glyphicon glyphicon-plus myicon-right"></i> {{ trans('misc.add_new') }}
                    </a>
                  

                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                <form action="{{ url('panel/admin/maincategories/add') }}" method="post">
                  @csrf
                  <table class="table table-hover">
               <tbody>

                @if( $data->count() !=  0 )
                   <tr>
                      <th class="active">ID</th>
                      <th class="active">{{ trans('admin.name') }}</th>
                      <th class="active">TitleaHead</th>
                      <th class="active">{{ trans('admin.tags') }}</th>                      
                      <th class="active">{{ trans('admin.actions') }}</th>
                      <th class="active">Check</th>
                      <th class="active">Pending</th>
                    </tr>

                  @foreach( $data as $category )
                    <tr>
                      <td>{{ $category->id }}</td>
                      <td>{{ $category->name }}</td>
                      <td><input type="text" title="Click to Edit" readonly class="titleahead readme" data-id="{{$category->id}}" name="trow{{$category->id}}" value="{{$category->titleahead}}"></td>
                     <td><input type="text" title="Click to Edit" readonly class="imagetags readme" data-id="{{$category->id}}" name="trow{{$category->id}}" value="{{$category->keyword}}"></td>
                    <?php // print_r($main_categorys) ;?>
                      <td class="tinbtn">
                        <a href="{{ url('panel/admin/subcategories/view/').'/'.$category->id }}" class="btn btn-success btn-xs padding-btn" style="margin-right: 5px;">
                          Sub Category
                        </a>
                        <a href="{{ url('panel/admin/categories/edit/').'/'.$category->id.'/'.$id }}" class="btn btn-success btn-xs padding-btn" style="margin-right: 5px;">
                          {{ trans('admin.edit') }}
                        </a>

                     @if( $category->id != 1 )
                        <a href="javascript:void(0);" data-url="{{ url('panel/admin/categories/delete/').'/'.$category->id.'/'.$id }}" class="btn btn-danger btn-xs padding-btn actionDelete" style="width: fit-content;">
                          {{ trans('admin.delete') }}
                          </a>
                          @endif

                          </td>
                          
                      <td>
                        
                        <a class="btn-success" style="margin-top:-5px" href="{{ url('c').'/'.$category->slug}}">
                        View
                        </a>
                      </td>
                      @php
                      $pendingcount = App\Helper::getCatPendingImages($category->id);
                      @endphp
                      <td> ({{$pendingcount}}) </td>
                    </tr><!-- /.TR -->
                    @endforeach

                    @else
                    <hr />
                      <h3 class="text-center no-found">{{ trans('misc.no_results_found') }}</h3>
                    @endif

                  </tbody>


                  </table>
                  
                </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      @include('admin.topbottom')
@endsection
@include('admin.topbottom')
@section('javascript')

<script type="text/javascript">

  $(document).ready(function(){

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
      $.post("{{url('panel/admin/categories/updateTags')}}",
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
            message = 'Category '+id+' Tags updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Category '+id+' Tags updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("section.content").prepend(html);
          setTimeout(function(){
            $("#ajaxResponse").remove();
          }, 2000);
      });
    });

    $(".titleahead").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".titleahead").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = $(this).data("id");
      var titleahead = $(this).val();
      var csrf = "{{csrf_token()}}";
      $.post("{{url('panel/admin/categories/updateTitleahead')}}",
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
            message = 'Category '+id+' Titleahead updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Category '+id+' Titleahead updated failed';
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
  var url     = element.attr('data-url');

  element.blur();

  swal(
    {   title: "{{trans('misc.delete_confirm')}}",
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
