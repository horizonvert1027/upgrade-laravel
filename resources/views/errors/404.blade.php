<?php
$contenturl = '';
$multilangLink = '';
$description = '404 Error! Page Not Found!';
$title = 'Page Not Found! 404 Error! ';
$keywords = '404 Error! Page Not Found!';
$thumbimage = url('/').'/public/logo.png';

?>


@extends('layouts.multi')

<style type="text/css">
.login-rgister {
    display: block;
    width: fit-content;
    border: 2px solid var(--light-dark-clr);
    padding: 12px;
    border-radius: 12px;
    box-shadow: var(--tag-shadow);
    background: var(--light-white-clr);
    text-align: -webkit-center;
    margin: auto;
    margin-top: 12%;
}
.ibox.bsh.mt20 {background: transparent;box-shadow: none;}</style>

@section('content')

  <div class="container">
  <section>
  <div class="col-md-12">
  <div class="ibox bsh mt20">
  <div class="login-rgister">
        <h1 style="font-size: 35px">{{ trans('error.error_404') }}</h1>
        <h3>Page not found</h3>
        <p class="subtitle-error">Either you typed incorrectly, or the page is no longer available.</p>
        <div>
          <a href="{{ url('/') }}">
          {{ trans('error.go_home') }}
          </a>
        </div>


  </div>
</div>
</div>
</section>
</div>
@endsection







