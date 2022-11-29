@extends('admin.layout')
@section('content')
<style>

</style>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h4>
           {{ trans('admin.editor') }}
          </h4>
        </section>

        <!-- Main content -->
        <section class="content"> 
            @if(Session::has('info_message'))
            <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
              <i class="fa fa-warning margin-separator"></i>  {{ Session::get('info_message') }}          
            </div>
            @endif                
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
