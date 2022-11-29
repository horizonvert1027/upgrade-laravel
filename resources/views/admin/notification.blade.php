@extends('admin.layout')

@section('css')
@endsection

@section('content')
<style type="text/css">
    .alert.alert-success {
    margin-top: -22px !important;
}
@media (min-width: 768px){
.form-horizontal .control-label {
    width: 11% !important;
}}

</style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h4>
                {{ trans('admin.admin') }}
                <i class="fa fa-angle-right margin-separator"></i>
                {{ __('Push Notification') }}
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
            @elseif(Session::has('error_message'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="fa fa-close margin-separator"></i> {{ Session::get('error_message') }}
                </div>
            @endif

            <div class="content">


                <div class="row">

                  <div class="totalsubs box">
                            <div class="subcont" style="font-size: 18px;text-align: -webkit-center;">Total subscribers are: <b>{{$counts}}</b></div>
                 </div>

                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Send Push Notification</h3>
                        </div><!-- /.box-header -->


                      
                        <!-- form start -->
                        <form class="form-horizontal" method="POST" action="{{ route('sendNotificationProcess') }}" enctype="multipart/form-data">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            @include('errors.errors-forms')


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Type of Subscribers</label>
                                <div class="col-sm-10">
                                <select name="category" class="form-control">

                                    <option value="">
                                        All
                                    </option>

                                    <option value="0">
                                        Background
                                    </option>

                                    <option value="1">
                                        PNG
                                    </option>

                                    <option value="2">
                                        Wallpapers
                                    </option>

                                    <option value="3">
                                        Addons
                                    </option>

                                    <option value="4">
                                        Graphics
                                    </option>

                                    <option value="5">
                                        Images
                                    </option>

                                </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" value="" name="title" class="form-control"
                                           placeholder="Notification title Name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Url</label>
                                <div class="col-sm-10">
                                    <input type="url" value="" name="url" class="form-control"
                                           placeholder="Notification url" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Icon Url</label>
                                <div class="col-sm-10">
                                    <input type="url" value="" name="icon" class="form-control"
                                           placeholder="Icon url" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Body</label>
                                <div class="col-sm-10">
                                    <textarea rows="5" name="body" class="form-control"
                                              placeholder="Notification body" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success">{{__('Send Notification')}}</button>
                                </div>
                            </div>



                        </form>
                    </div>

                </div><!-- /.row -->

            </div><!-- /.content -->

            <!-- Your Page Content Here -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('javascript')

@endsection
