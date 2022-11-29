<?php
if( Auth::check() ) {

    // FOLLOW ACTIVE
    $followActive = App\Models\Followers::where( 'follower', Auth::user()->id )
        ->where('following',$response->user()->id)
        ->where('status', '1')
        ->first();

    if( $followActive ) {
        $textFollow   = trans('users.following');
        $icoFollow    = '-ok';
        $activeFollow = 'btnFollowActive';
    } else {
        $textFollow   = trans('users.follow');
        $icoFollow    = '-plus';
        $activeFollow = '';
    }

    // LIKE ACTIVE
    $likeActive = App\Models\Like::where( 'user_id', Auth::user()->id )
        ->where('images_id',$response->id)
        ->where('status','1')
        ->first();

    if( $likeActive ) {
        $textLike   = trans('misc.unlike');
        $icoLike    = 'fa fa-heart';
        $statusLike = 'active';
    } else {
        $textLike   = trans('misc.like');
        $icoLike    = 'fa fa-heart-o';
        $statusLike = '';
    }

    // ADD TO COLLECTION
    $collections = App\Models\Collections::where('user_id',Auth::user()->id)->orderBy('id','asc')->get();

}//<<<<---- *** END AUTH ***

// All Images resolutions
$stockImages = $response->stock;

// Similar Photos
$arrayTags  = explode(",",$response->tags);
$countTags = count( $arrayTags );

$images = App\Models\Images::where('categories_id',$response->categories_id)
    ->whereStatus('active')
    ->where(function($query) use ($arrayTags,$countTags){
        for( $k = 0; $k < $countTags; ++$k ){
            $query->orWhere('tags', 'LIKE', '%'.$arrayTags[$k].'%');
        }
    } )
    ->where('id', '<>',$response->id)
    ->orderByRaw('RAND()')
    ->take(20)
    ->get();

// Comments
$comments_sql = $response->comments()->where('status','1')->orderBy('date', 'desc')->paginate(10);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <meta property="og:site_name" content="{{$settings->title}}"/>
    <meta property="og:url" content="{{url("photo/$response->id").'/'.str_slug($response->title)}}"/>
    <meta property="og:image" content="{{ asset('public/uploads/preview/') }}/{{$response->preview}}"/>
    <meta property="og:image:type" content="image/png/photo/wallpaper"/>
    <meta property="og:image:alt" contnent="{{ $response->alt }} {{ $response->title }}"/>
    <meta property="og:title" content="{{ $response->title }}"/>
    <meta property="og:description" content="{{ App\Helper::removeLineBreak( e( $response->description ) ) }}"/>

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:image" content="{{ asset('public/uploads/preview/') }}/{{$response->preview}}"/>
    <meta name="twitter:title" content="{{ $response->title }}"/>
    <meta name="twitter:description" content="{{ App\Helper::removeLineBreak( e( $response->description ) ) }}"/>

    <link href="{{ asset('public/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/css/main.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
@if( isset( $settings->google_analytics ) )
    <?php echo html_entity_decode($settings->google_analytics) ?>
@endif

<div class="popout font-default"></div>

<div class="wrap-loader">
    <i class="fa fa-cog fa-spin fa-3x fa-fw cog-loader"></i>
    <i class="fa fa-cog fa-spin fa-3x fa-fw cog-loader-small"></i>
</div>

@if(!Request::is('/'))
    <form role="search" class="box_Search collapse" autocomplete="off" action="{{ url('search') }}" method="get"
          id="formShow">
        <div>
            <input type="text" name="q" class="input_search form-control" id="btnItems" placeholder="Search">
            <button type="submit" id="_buttonSearch"><i class="icon-search"></i></button>
        </div><!--/.form-group -->
    </form><!--./navbar-form -->
@endif

@include('includes.navbar')

<section>
    <div class="container">
        <div class="col-md-9">
            <div class="ibox">
                <div class="breadcrumbtext">
                    <div class="scp-breadcrumb">
                        <ul class="boxb breadcrumb">
                            <li><a href="https://oyebesmartest.com">Home</a></li>
                            <li><a class="fcheck" href="{{url('category',$response->category->slug)}}"
                                   title="{{$response->category->name}}">{{str_limit($response->category->name, 18, '...') }}</a>
                            </li>
                            <li><a href="{{ url($response->subcat->slug) }}/subcategory"
                                   title="{{$response->subcat->name}}">{{str_limit($response->subcat->name, 18, '...') }}</a>
                            </li>
                            <li><a href="{{ url('photo',$response->id) }}"
                                   title="{{$response->title}}">{{str_limit($response->title, 10, '...') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center margin-bottom-zero">
                    <img class="img-responsive disableRightClick" title="{{ $response->title }}" alt="{{ $response->alt}} {{ $response->title}}" caption="{{ $response->caption}}-{{ $response->title}}" style="display: inline-block;" src="{{url('public/uploads/preview',$response->preview)}}" />
                </div>
             </div>
        </div>



        <div class="col-md-3">2</div>
    </div>
</section>


<script src="{{ asset('public/plugins/jQuery/jQuery.min.js') }}"></script>
<script src="{{ asset('public/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/js/inner.js') }}"></script>

</body>
</html>