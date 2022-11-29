@extends('layouts.multi')

@section('OwnCss')
<link href="{{ asset('/public/css/jquery-ui-1.8.2.custom.css')}}" rel="stylesheet" type="text/css" />
    <link rel="preload" href="/public/jscss/catcssobs.css?14" as="style">
    <link rel="stylesheet" href="/public/jscss/catcssobs.css?14">
@endsection

@section('content')
<div class="container">
   <section>
    <div class="col-md-12">
        <div class="ibox bsh mt20 mb35">

        <h1>{{ $category->name }}</h1>
        
        @if ( Auth::user() && Auth::user()->role == 'admin' )
            <a class="aligncenter nvbtn" href="{{url('panel/admin/categories/edit')}}/{{$category->id}}/{{$category->main_cat_id}}">Edit
            </a>
        @endif

        <ol class="breadcrumb">              
            <li>
                <a href="{{ url('/') }}" aria-label="home" title="home">
                    <span class="ichome"></span>
                </a>
            </li>

            <li>
                <a href="{{ url('type') }}/{{ $main_categories[0]->slug }}" >
                    {{ $main_categories[0]->name }}
                </a>
            </li>

            <li>
                <a href="{{ url('c') }}/{{ $category->slug }}" >
                  {{ $category->name }}
                </a>
            </li>                            
        </ol>
     
    <div class="searchsubcats">

        <div class="inner">
            <h3>Search {{ $category->name }}</h3>
        </div>

        <span class="text-black">
            <input class="subcatinput" type="text" name="subcategory" placeholder="Search {{ $category->name }}...">
        </span>
        
        <span class="linksblock"></span>

    </div>
        
        <div id="categoryFlex">
            @php
            $allSubcategories = App\subcategories::where('categories_id',$category->id)->where('mode','on')->orderBy('name')->paginate($sublimit)->onEachSide(1);
            @endphp
            @foreach($allSubcategories as $sub )
             <?php 
             $imagescount = HH::getSubTotalImages($sub->id);
             if( $imagescount == 0 ){
                continue;
             }
             if( $sub->sthumbnail == '' ) {
                $_image = 'default.jpg';
             } else {
                $_image = $sub->sthumbnail;
             } 
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 row-margin-20">
                <a href="{{url('s')}}/{{("$sub->slug")}}">
                    <img height="350" width="439" class="custom-rounded lazy" src="/public/img-subcategory/default.jpg" data-original="{{config('app.filesurl')}}{{(config('path.img-subcategory').$_image)}}" alt="{{ $sub->name }}">
                </a>
                <h3><a class="tab-list" href="{{url('s')}}/{{("$sub->slug")}}">{{ Str::limit($sub->name, 18, '') }}</a></h3>
            </div>
            @endforeach
            <?php if( $allSubcategories->count() == $sublimit ){ $page=1; ?>
            
                <div class="catpagination">
                <a href="{{url('ajax/subcategories')}}?page={{$page+1}}">Show More</a>
            </div>
            <?php } ?>
        </div>

            @if(HH::likecheck($title, $description) == false)
            <div class="cent adbox strip">
               @include('ads.responsiveads')
            </div>
            @endif

                <div class="flex-images imagesFlex2 dataResult">
                     @php if( $category->cpdescr != '' ) { $url = url('/'); $category->cpdescr=preg_replace("/#([A-Za-z0-9\_\-\.]*)/", "<a target='_blank' href='".$url."/search?q=$1'>#$1</a>", $category->cpdescr); } @endphp @php $dstr = $category->cpdescr; $topdescr = $moredescr = ""; if( strlen($dstr) > 500 ) { $pindex = strpos($dstr, "</p>"); $topdescr = substr($dstr, 0, $pindex+4); $topdescr .= '<a href="javascript:void(0);" class="read-more">read more...</a>'; $moredescr = substr($dstr, $pindex+4); $topdescr .= '<a class="more-text">'.$moredescr.'</a>'; } else { $topdescr = $dstr; } @endphp
                    <div class="description show-read-more">{!!$topdescr!!}</div>
                     @include('includes.mob-sim-images')
                    <div class="container-paginator">
                    {{ $images->links() }}
                    </div>
                </div>
 </div>
</div>
</section>
</div>

@endsection

        @section('SchemaJson')
         <script type="application/ld+json">[{"@context":"http://schema.org","@type":"WebSite","name":"⚡{{HH::counts($images->total())}}+ Best {{$subcattitle}} {{HH::titleahead($titleahead)}}","description":"{{HH::removetags($categorydescr)}}","keywords":"{{ $category->keyword }}","url":"{{ url('/') }}/c/{{$category->slug.''}}","potentialAction":{"@type":"SearchAction","target": "{{ url('/') }}/search?q={search_term_string}","query-input": "required name=search_term_string"}},{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "{{ url('/') }}"},{"@type":"ListItem","position": 2,"name": "{{ $main_categories[0]->name }}","item": "{{ url('type') }}/{{ $main_categories[0]->slug }}"},{"@type": "ListItem","position": 3,"name": "{{ $category->name }}"}]},@foreach($images as $k=>$i)@php if($i->opt_file_source != ""){$slugUrl1  = 'file';}else {$slugUrl1  = 'photo'; }@endphp
         {"@context":"http://schema.org","@type": "ImageObject","name": "{{$i->title}}","caption":"{{$i->title}}","keywords": "{{$i->metakeywords}}","description":"{{$i->title}}","image":"{{url('/')}}/{{($slugUrl1)}}/{{($i->id).'/'.Str::slug($i->title)}}","url": "{{url('/')}}/{{($slugUrl1)}}/{{($i->id).'/'.Str::slug($i->title)}}","contentUrl":"{{config('app.filesurl').('uploads/large/').($i->large)}}","thumbnail": "{{config('app.filesurl').('uploads/preview/').($i->preview)}}","fileFormat": "image/{{$i->extension}}","sourceOrganization":"{{$settings->sitename}}"}@if($k != (count($images)-1)),@endif @endforeach]
        </script>
        @endsection
@section('javascript')
<script src="{{ asset('/public/js/auto-complete.js') }}"></script>
    <script src="{{ asset('/public/admin/js/jquery-ui.min.js')}}?2" type="text/javascript"></script>
    <script>

        <?php
        $arr = array();
        $subMap = array();
        $allsubcategories = \App\subcategories::all();
        foreach ($allsubcategories as $key => $subcat)
        {
            $arr[] = $subcat->name;
            $subMap[ $subcat->slug ] = $subcat->categories_id."|".$subcat->name;
        }
        ?>

        var allsubs = '<?php echo addslashes(json_encode($arr));?>';
        allsubs = JSON.parse(allsubs);
        var allsubsmap = '<?php echo addslashes(json_encode($subMap));?>';
        allsubsmap = JSON.parse(allsubsmap);

        $("input[name='subcategory']").autocomplete({
            source: allsubs,
            minLength: 2,
            open: function(){ $(".linksblock").html(''); },
            select: function( event, ui )
            {
                var category = "";
                var subcategory = "";
                $(".linksblock").html('');
                var sub = ui.item.value.trim();
                $("input[name='subcategory']").val(sub);
                $.each(allsubsmap, function(i, obj)
                {
                    console.log()
                    var d = obj.split("|");
                    if( d[1] == sub )
                    {
                        subcategory = i;
                        category = d[0];
                    }
                });
                var baseurl = "{{url('/')}}";
             
                var href = baseurl+'/s/'+subcategory;
                $(".linksblock").append("<a id='addsubcat' class='nvbtn' href='"+href+"'>View Images</a>");
            }
        });
    </script>
    <script src="{{ asset('public/js/lazyload.min.js') }}"></script>
    <script>

    


        var ajaxlink = '{{ url("/") }}/ajax/category?slug={{$category->slug}}&page=';
document.addEventListener("DOMContentLoaded", yall), 

$(document).ready(function() {
    var a = 0;
    $("#categoryFlex img.lazy").each(function() {
        var t = $(this),
            e = new Image;
        e.src = $(this).attr("data-original"), e.addEventListener("load", function() {
            t.attr("src", this.src)
        }, !1)
    })
});
function loadSimilarImages(page) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '{{ url("/") }}/ajax/subcategories?category_id={{$category->id}}&limit={{$sublimit}}&page=' + page
            }).done(function (data) {
                if (data) {
                    $('#categoryFlex .catpagination').remove();
                    $('#categoryFlex').append(data);
                } else {
                    sweetAlert("{{trans('misc.error_oops')}}", "{{trans('misc.error')}}", "error");
                }
            });
        }

        $(document).on('click', '.catpagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#categoryFlex .catpagination').html('<div class="spinner"></div>');
            loadSimilarImages(page);
        });
    </script>
@endsection