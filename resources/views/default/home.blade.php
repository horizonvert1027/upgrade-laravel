@extends('layouts.multi')

  @section('OwnCss')
    <link rel="preload" href="/public/jscss/homecssobs.css?792" as="style">
    <link rel="stylesheet" href="/public/jscss/homecssobs.css?792">
  @endsection

@section('content')

    <div class="jumbotron index-header aligncenter">

      <h1 class="bounce-in-top">{{$sitearr[0]}} <span style="color: #d9d91a">{{ $sitearr[1]}}</span></h1>
      <p class="swing-in-bottom-fwd"><strong>{{$settings->welcome_subtitle}}</strong></p>

        <div class="jumbotron22">
          <form role="search" autocomplete="off" action="{{config('app.appurl')}}/search" method="get">
          <div class="suggest">
          <input type="text" class="form-control suggest" name="q" value="" placeholder="Search..." aria-label="Search">
          
          <button class="search" aria-label="Justify" title="Search" type="submit">
          <span class="icsearch"></span>
          </button>
          </div>
          </form>
        </div>

            <div class="projects-catalog">
              <div class="catalog-cover">
                <i class="left-button"></i>
                  <ul id="butt" class="sliderWrapper1 sliderscroll">
                    @if($settings->hotsearch!='')
                        <?php $tags=explode(',',$settings->hotsearch);$count_tags=count($tags); 
                          for( $i = 0; $i < $count_tags; ++$i ) { 
                          $first=HH::getFristImageSearch($tags[$i]);
                          ?>          
                      <li class="slide htags">
                        <a class="slink" alt="Polpular Search" href="search?q={{HH::spacesUrl($tags[$i])}}">
                          @if ($first!='')
                          <img class="img-circle tags" height="40" width="40" src="{{config('app.filesurl').('uploads/thumbnail')}}/{{($first)}}">
                          @endif
                           <div class="sidekro tags">
                             {{$tags[$i]}}
                           </div>
                           
                        </a>
                      </li>
                       <?php } ?>
                    @endif 
                  </ul>
                <i class="right-button"></i>
              </div>
            </div>
    </div>
    

    @include('includes.homeboxes') 

<div class="container">
  <section>
    <div class="col-md-12">
      <div class="ibox mt20">


<!--   <?php echo date('m/d/Y h:i:s a', time()); ?>

    <?php echo date_default_timezone_set("America/New_York");echo "The time is " . date("h:i:sa"); ?> -->

             



    <div class="aligncenter imgs">


      <h2>Latest
      <span class="color-default">Stocks</span></h2>
      <div class="flex-images imagesFlex2">
      @include('includes.imageslazy')
      </div>
      <a class="man" href="{{config('app.appurl')}}/latest"> {{ trans('misc.view_all') }}</a>
      
      @if($settings->whatstoday!='')
        <h2>{{($settings->whatstoday)}}
        <span class="color-default">Stocks</span></h2>
      
        <div class="flex-images imagesFlex2">
        @php
          $category = App\subcategories::whereIn('slug',[''.$settings->whatstodaylink.''])->pluck('id')->toArray();
          $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
        @endphp
          @include('includes.imageslazy')
        </div>
          <a class="man" href="{{('')}}/s/{{str_replace(" ","- ",($settings->whatstodaylink))}}"> {{ trans('misc.view_all') }}</a>
      @endif


      @if($settings->whatstoday1!='')
        <h2>{{($settings->whatstoday1)}}
        <span class="color-default">Contents</span></h2>
      
        <div class="flex-images imagesFlex2">
          @php
            $category = App\subcategories::whereIn('slug',[''.$settings->whatstoday1link.''])->pluck('id')->toArray();
            $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
          @endphp
            @include('includes.imageslazy')
        </div>
          <a class="man" href="{{('')}}/s/{{str_replace(" ","- ",($settings->whatstoday1link))}}"> {{ trans('misc.view_all') }}</a>
      @endif



      @if($settings->homefiles1!='')
        <h2>Recommended
        <span class="color-default">Wallpapers</span></h2>
        <div class="flex-images imagesFlex2">
        @php
        $category = App\subcategories::whereIn('slug',[''.$settings->homefiles1.''])->pluck('id')->toArray();
        $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
        @endphp
        @include('includes.imageslazy')
        </div>
        <a class="man" href="{{('')}}/s/{{str_replace(" ","- ",($settings->homefiles1))}}"> {{ trans('misc.view_all') }}
        </a>
      @endif

        @if($settings->homefiles2!='')
          <h2>Editing
          <span class="color-default">Stocks</span></h2>
          <div class="flex-images imagesFlex2">
          @php
            $category = App\subcategories::whereIn('slug',[''.$settings->homefiles2.''])->pluck('id')->toArray();
            $images   = App\models\Images::where('status', 'active')->whereIn('subcategories_id',$category)->take(40)->orderBy('id','DESC')->get();
          @endphp
            @include('includes.imageslazy')
          </div>
          <a class="man" href="{{('')}}/s/{{str_replace(" ","- ",($settings->homefiles2))}}"> {{ trans('misc.view_all') }}
          </a>
        @endif

        <div>
        @php
          $images   = App\models\Images::where('featured', 'yes')->where('status','active')->orderBy('featured_date','DESC')->take(30)->get();
        @endphp
        @if( $images->count() != 0 )
          <h2>Featured<span class="color-default">Stocks</span></h2>
          <div class="flex-images imagesFlex2">
            @php
              $images   = App\models\Images::where('featured', 'yes')->where('status','active')->orderBy('featured_date','DESC')->take(30)->get();
            @endphp
            @include('includes.imageslazy')
          </div>
          <a class="man" href="{{('')}}/featured"> {{ trans('misc.view_all') }}
          </a>
        @endif
        </div>
        
        
    </div>

</div>
</section>
</div>
</div>
@endsection

@section('javascript')

  @if( Auth::check() && Auth::user()->status == 'pending' )
    <div class="alert alert-danger text-center margin-zero border-group">
    <i class="icon-warning myicon-right"></i> {{trans('misc.confirm_email')}} <strong>{{ Auth::user()->email}}</strong>
    </div>
  @endif

<script>
var googleadslink = "";
slide('.sliderWrapper3')
slide('.sliderWrapperBirthday')
slide('.sliderWrapperFestival')
</script>

@endsection
