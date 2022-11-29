<?php
$png = ''; 
$ext = pathinfo(Storage::url('uploads/preview',$response->preview), PATHINFO_EXTENSION); 

if($response->extension == 'png') { $png = 'background: url('.asset('public/img/png_bg.png').')  ';}
 ?>

@extends('layouts.multi')
@section('content')
<style>.dwnklie{max-width:500px;display:block;margin:0 auto 10px auto}.dbtn{margin-top:10px}img.img-responsive.disableRightClick.img-thumbnail{margin-top:10px}.ibox.bsh{margin-right:10px;margin-left:10px}.heartbeat.rem{font-size:23px;font-weight:700}.heartbeat.site{font-size:29px;font-weight:700}
/*.banner {border: 1px solid #c5c5c5;
    border-radius: 10px;
    background: #700cb9;
    display: inline-flex;
}img.bannerimg {
    height: 159px;
    margin: 0px 0px 0px 15px;
}.bigtxt {
   font-size: 20px;
    font-weight: 600;
}.bannertxt {
    color: white;
    margin: auto auto auto 20px;
}
a.bannerbtn {
    background: yellow;
    padding: 8px;
    border-radius: 4px;
    margin-top: 7px;
    display: block;
    color: black;
    font-weight: 600;
    text-align: -webkit-center;
}
.smalltxt {
    color: #31ff00;
}
.bannerh {
    margin: 0 auto;
    display: block;
    width: fit-content;
}*/
</style>
<div class="container">
    <section>

               @if(HH::likecheck($title, $description) == false)
                     @include('ads.responsiveads')
               @endif

        <div class="">
            <div class="iboxgallery">
                <div class="aligncenter rem">Do remember the site
                    <div class="heartbeat site">
                        Oye Be Smartest 
                    </div>
                </div>

                <!--         
                    <div class="bannerh">
                        <div class="banner">
                            <div class="bannertxt">
                               <div class="bigtxt">Hello Download</div>
                               <div class="smalltxt">it is very popular these days</div>
                               <a class="bannerbtn" href="#">Download Now!</a>
                            </div>
                        
                            <img class="bannerimg" src="/public/img/ronaldo.png">
                        </div>
                    </div>
                -->

                <div class="aligncenter">
                </div>

                <div class="cent aligncenter" style="color: green;">
                <p>ThankYou for downloading!</p>
                <p>If not downloaded automaically, 
                @if($response->opt_file_source != NULL)
                    <a onclick="vibrateSimple()" href="{{url('otherfetch')}}/{{$token_id}}/original" download>
                        <b>click here</b>
                    </a>
                    @else
                    <a onclick="vibrateSimple()" href="{{url('ifetch')}}/{{$token_id}}/original" download>
                        <b>click here</b>
                    </a>
                @endif
                </p>
                </div>

                <!-- 
                    <div class="dwnklie">
                    <button onclick="vibrateSimple(); playAudio()" class="mybtn btnApp" style="" aria-label="Install Progresive App button">Download our WebApp</button>
                    </div>
                -->

                @if($response->opt_file_source != NULL)
                    <a id="downloadthisimage" onclick="window.location='{{url('otherfetch')}}/{{$token_id}}/original'" href="#">
                    </a>
                @else
                    <a id="downloadthisimage" onclick="window.location='{{url('ifetch')}}/{{$token_id}}/original'" href="#">
                    </a>
                @endif
            
            </div>

                @if( $images->count() != 0 )
                  <div class="aligncenter" style="margin-top: 15px">
                    <h4>Similar {{$response->category->name}}</h4>
                    <div class="flex-images imagesFlex2">
                        @include('includes.imageslazy')
                    </div>

                    <a href="{{$subcatlink}}" class="gall mybtn" style="padding: 10px">
                        <span>Load more</span>
                    </a>
                  </div>
                @endif

        </div>
    </section>
</div>
   @if(HH::likecheck($title, $description) == false)
      @include('ads.stickyads')
   @endif
   
@endsection
    @section('SchemaJson')
      <script type="application/ld+json">
         [{"@context":"https://schema.org","@type": "BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "{{ url('/') }}"},{"@type":"ListItem","position": 2,"name":"@if($response->subgroup!=''){{$subcatname}} @else {{($catname)}}@endif","item":"@if($response->subgroup!=''){{($subcatlink)}} @else {{($catlink)}} @endif"},{"@type":"ListItem","position":3,"name":"@if($response->subgroup!=''){{($response->subgroup)}} @else{{($subcatname)}}@endif","item":"@if($response->subgroup!=''){{url('/')}}/g/{{Str::slug($response->subgroup)}}@else {{($subcatlink)}} @endif"},{"@type":"ListItem","position":4,"name":"{{$title}}"}]},{"@context":"http://schema.org","@type":"Organization","name":"{{config('app.sitename')}}","url":"{{ url('/') }}","logo":"{{ asset('public/img/apple') }}/apple-touch-icon.png","sameAs":["https://www.facebook.com/{{config('app.sitename')}}","https://twitter.com/{{config('app.sitename')}}","http://{{config('app.sitename')}}.tumblr.com/","https://instagram.com/{{config('app.sitename')}}/"]},{"@context":"http://schema.org","@type":"ImageObject","name":"{{$title}}","description":"{{$description}}","keywords":"{{$keywords}}","caption":"{{$imgtitletrue}}","contentUrl":"{{$imglarge}}","image":"{{$contenturl}}","url":"{{$contenturl}}",@if(isset($response->opt_file_source) && $response->opt_file_source != "")"fileFormat":"image/{{$response->extension}}",@endif "thumbnail":"{{$thumbimage}}","sourceOrganization":"{{config('app.sitename')}}" }]
      </script>
    @endsection