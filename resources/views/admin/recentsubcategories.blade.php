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
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> Main Type
          </h1>

        </section>

        <!-- Main content -->
        <section class="content">






          <div class="row">
            <div class="col-md-6">
              <div class="box">
				  
				  
                <div class="box-body table-responsive no-padding">
					<?php
use App\subcategories;
$latestsubcats = subcategories::where([['mode', 'on']])->orderBy('created_date', 'DESC')->take(50)->get();
?>
        @if( count($latestsubcats) != 0 )
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                @foreach( $latestsubcats as $subcat )
                
                <li class="item">
                  <div class="product-img">
                    <img height="50" width="50" src="{{ config('app.filesurl').(config('path.subcat_preview').$subcat->preview) }}" style="height: auto !important;" />
                  </div>
                  <div class="product-info">
                    <a href="{{ url('panel/admin/subcatimages/') }}/{{$subcat->id}}" target="_blank" class="product-title">{{ Str::limit($subcat->name,18,'.') }}
                      </a>
                      <span class="label label pull-right">
                        <a target="_blank" href="{{url('panel/admin/subcategories/edit/'.$subcat->id."/".$subcat->categories_id)}}"><b>Edit</b></a>
                      </span>
                    
                    <span class="product-description">
                      {{ trans('misc.by') }} {{ '@'.HH::getusername($subcat->created_by)}} / {{ App\Helper::formatDate($subcat->created_date) }}
                    </span>
                  </div>
                  </li><!-- /.item -->
                  @endforeach
                </ul>
               
                </div><!-- /.box-body -->
                @else
                <div class="box-body">
                  <h5>{{ trans('admin.no_result') }}</h5>
            </div><!-- /.box-body -->
        @endif
   
                </div><!-- /.box-body -->
				  
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
