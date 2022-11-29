<?php
?>
@extends('layouts.multi') @section('content')
    <div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">

           
            @if ( Auth::user() && Auth::user()->role == 'admin' )
            <div class="cent aligncenter">
               <a class="nvbtn" href="{{url('panel/admin/subcategories/edit')}}/{{$subcategory->id}}/{{$subcategory->categories_id}}">Edit</a>
            </div>
            @endif
            <h1>{{HH::counts($images->total())}}+ {{$subcategoryname}} {{HH::titleahead($titleahead)}}</h1>
            <ol class="breadcrumb">
               <li>
                   <a href="{{ url('/') }}" aria-label="home" title="home">
                       <span class="ichome"></span>
                   </a>
               </li>
               <li>
                  <a href="{{ $maincatlink }}"> {{ $maincatname }}
                  </a>
               </li>
               <li>
                  <a href="{{ $categorylink }}">{{ $categoryname }}
                  </a>
               </li>
               <li>
                  <a href="{{ $subcategorylink }}" title="{{ $subcategoryname }}">@if(HH::isMobile())  {{Str::limit($subcategoryname, 18, '.') }} @else {{($subcategoryname)}} @endif
                  </a>
               </li>
            </ol>
<div class="projects-catalog">
        <div class="catalog-cover">
            <i class="left-button"></i>
            <ul class="sliderWrapper1 sliderscroll">
                @if( $tags !="")
                    @for( $i = 0; $i
                        < $count_tags; ++$i ) @php $first=HH::getFristImageSubGroup($tags[$i]); @endphp

                        @if( $first !="" && $tags[$i] !="") 
                     <li class="slide">
                        <a class="slink" href="{{url('g',Str::slug(($tags[$i])))}}">
                           <img class="img-circle tags" height="50" width="50" src="{{config('app.filesurl').('uploads/thumbnail')}}/{{($first)}}" alt="{{ $tags[$i] }}">
                           <div class="sidekro tags">
                           {{HH::subgroupneat(HH::specialmatchedword($tags[$i], $subcategoryname))}}</div>
                        </a>
                     </li>

                        @endif
                    @endfor
                @endif 
            </ul>
            <i class="right-button"></i> 
    </div>
</div>
           @php 
            if( $subcategory->spdescr != '' ) { 
               $url = url('/'); 
               $subcategory->spdescr=preg_replace("/(#([\w\-.]*)+ )+/","<a href='".$contenturl."'>$subcategoryname </a>", $subcategory->spdescr); }

            @endphp

      @php 
            $dstr = $subcategory->spdescr;
            $topdescr = $moredescr = "";

            if( strlen($dstr) > 500 ) { 
               $pindex = strpos($dstr, "</p>"); 
               $topdescr = substr($dstr, 0, $pindex+4); 
               $topdescr .= '<a href="javascript:void(0);" class="read-more">read more...</a>';
               $moredescr = substr($dstr, $pindex+4);
               $topdescr .= '<a class="more-text">'.$moredescr.'</a>';
            }
            else { 
               $topdescr = $dstr; 
            } 
      @endphp

            <div class="show-read-more">{!!$topdescr!!}</div>

            

            @if(HH::likecheck(HH::combinAllTitles($images), $description) == false)
            <div class="cent adbox strip">
               @include('ads.responsiveads')
            </div>
            @endif
            <div class="flex-images imagesFlex2 dataResult">
                @include('includes.mob-sim-images')
               <div class="container-paginator"> {{ $images->links() }} </div>
            </div>



         </div>
      </div>
   </section>
</div>

@endsection

@section('SchemaJson')
<script type="application/ld+json">
      [
      {
         "@context": "http://schema.org",
         "@type": "WebSite",
         "name": "{{$title}}",
         "description": "{{$description}}",
         "keywords": "{{ $keywords }}",
         "url": "{{ url('')}}",
         "potentialAction": 
         {
            "@type": "SearchAction",
            "target":"{{url('/')}}/search?q={search_term_string}",
            "query-input": "required name=search_term_string"}},
         {
            "@context":"https://schema.org",
            "@type":"BreadcrumbList",
            "itemListElement": 
            [
            {
               "@type": "ListItem",
               "position": 1,
               "name": "Home",
               "item": "{{ url('/') }}"},
               {
                  "@type": "ListItem",
                  "position": 2,
                  "name": "{{ $categoryname }}",
                  "item": "{{$categorylink}}"},
                  {
                     "@type":"ListItem",
                     "position": 3,
                     "name": "{{ $subcategoryname }}",
                     "item": "{{$subcategorylink}}"
                  }

            ]
         },
                  

                  @foreach($images as $k => $i)
                     @php if($i->opt_file_source != ""){$slugUrl1  = 'file';}
                        else {$slugUrl1  = 'photo';}
                     @endphp
                     {
                        "@context": "http://schema.org",
                        "@type": "ImageObject",
                        "name": "{{$i->title}}",
                        "caption": "{{$i->title}}",
                        "keywords": "{{$i->metakeywords}}",
                        "description": "{{ HH::removetags($description)}}",
                        "image":"{{url('/')}}/{{($slugUrl1)}}/{{($i->id).'/'.Str::slug($i->title)}}",
                        "url":"{{url('/')}}/{{($slugUrl1)}}/{{($i->id).'/'.Str::slug($i->title)}}",
                        "contentUrl":"{{config('app.filesurl').('uploads/large/').($i->large)}}",
                        "thumbnail": "{{config('app.filesurl').('uploads/preview/').($i->preview)}}",
                        "fileFormat":"image/{{$i->extension}}",
                        "sourceOrganization":"{{$settings->sitename}}"
                     }
                        @if($k != (count($images) - 1)),
                        @endif
                  @endforeach
               ]
   </script>
@endsection
@section('javascript')
   <script>
      var ajaxlink = '{{ url("/") }}/ajax/category?slug={{$subcategory->slug}}&page=';
   </script>
@endsection