<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <link rel="manifest" href="/manifest.json" />
        <meta name="name" content="{{ url('/') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#150b50"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Upload {{$settings->title}}</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="/public/jscss/upload.css?11222" rel="stylesheet" type="text/css"/>

@if( isset( $settings->google_analytics ) )
    <?php echo html_entity_decode($settings->google_analytics) ?>
@endif
    </head>
<body>


    <div class="popout font-default"></div>

    <div class="wrap-loader">
        <i class="fa fa-cog fa-spin fa-3x fa-fw cog-loader"></i>
        <i class="fa fa-cog fa-spin fa-3x fa-fw cog-loader-small"></i>
    </div>

    <div class="progress-wrapper display-none" id="progress" style=" position: fixed;z-index: 1000000;margin-top:0px; text-align:center;  width: 100%;">
  <div class="progress" style="border-radius: 0;">
    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
  </div>
  <div class="progress-info" style="background: #02a359f7; z-index: 1000000; color: #fff; font-size: 50px">
    <div class="progress-percentage">
      <span class="percent">0%</span>
    </div>
  </div>
</div>
    <div class="wrap-loader-progress">
    </div>
        @include('includes.navbar')
        @yield('content')
        @include('includes.footer')
<script src="{{ asset('public/jscss/jsobs.js?1115') }}"></script> 
<script src="{{ asset('public/plugins/jQuery/jQuery.min.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src="{{ asset('public/jscss/upload.js') }}"></script>
<script src="{{ asset('public/js/jquery.form.js') }}"></script>
@yield('javascript')
</body>
</html>