@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
           {{ trans('admin.admin') }} <i class="fa fa-angle-right margin-separator"></i> Insta Cron Log</h4>
        </section>

        @if(Session::has('info_message'))
		    <div class="alert alert-warning">
		    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
		      <i class="fa fa-warning margin-separator"></i>  {{ Session::get('info_message') }}
		    </div>
		    @endif

		    @if(Session::has('success_message'))
		    <div class="alert alert-success">
		    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
								</button>
		       <i class="fa fa-check margin-separator"></i>  {{ Session::get('success_message') }}
		    </div>
		    @endif

          <div class="row">
            <div class="col-xs-12">
              <div style="width: 95%;margin: 0 auto;" class="box">
                <div class="box-header">
                  @if( $data->count() !=  0 )
                      <div class="input-group input-group-sm" style="float:left;width: 150px;">
                        <div class="input-group-btn">
                          <a class="btn btn-danger" href="{{ url('panel/admin/deletealllog') }}">Delete All</a>
                        </div>
                      </div>
                  @endif
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover">
                  <tbody>

               	  @if( $data->count() != 0 )
                   <tr>
                      <th class="active">ID</th>
                      <th class="active">Instagram Account</th>
                      <th class="active">Date</th>
                      <th class="active">{{ trans('admin.actions') }}</th>
                    </tr>
                  @foreach( $data as $log )
                   <tr>
                      <td>{{ $log->id }}</td>
                      <td>{{ $log->insta_username }}</td>
                      <td>{{ App\Helper::formatDate($log->created) }}</td>
                      <td><a class="btn btn-danger" href="{{ url('panel/admin/deletelog/'.$log->id) }}">Delete</a></td>
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

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

<script type="text/javascript">

  $(".actionDelete").click(function(e) 
  {
    e.preventDefault();
    var element = $(this);
  });

</script>
@endsection
