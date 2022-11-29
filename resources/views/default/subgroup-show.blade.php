@extends('layouts.multi')
@section('content')
<div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">
            <h1>{{$title}}</h1>
            
               <ol class="breadcrumb">
                  <li>
                     <a href="{{ url('/') }}" aria-label="home" title="home">
                        <span class="ichome"></span>
                     </a>
                  </li>
                  <li>
                     <a href="{{ $maincatlink }}" > {{ $maincatname }}</a>
                  </li>
                  <li>
                     <a href="{{ $categorylink }}" title="{{ $categoryname }}">{{Str::limit($categoryname, 25, '...') }}
                     </a>
                  </li>
                  <li>
                     <a href="{{ $subcategorylink }}" title="{{ $subcategoryname }}">{{Str::limit($subcategoryname, 18, '...') }}
                     </a>
                  </li>
                  <li>
                     {{$subgroup}}
                  </li>
               </ol>

            <div class="projects-catalog sg">
               <div class="catalog-cover">
                  <ul class="sliderWrapper1 sliderscroll">
                     
                     <li>
                        <a class="slink sq" href="{{ $subcategorylink }}">
                           <img class="img-circle sqtags" height="65" width="65" alt="{{ $subcategoryname }}" src="{{config('app.filesurl').('public/subcatpreview')}}/{{$subcategory[0]->preview}}">
                           <div class="sidekro sg">
                              <p class="sgtags"><b>{{ ($subcategoryname) }}</b></p>
                              
                              <p>{{HH::getSubCategoryTotalImages($subcategory[0]->slug)}} @if ($lastimage->opt_file_source =='')Images @else {{strtoupper($lastimage->extension)}} Files @endif</p>
                           </div>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>

            @if( $images->total() != 0 )

                  @if(HH::likecheck($title, $description) == false)
                     <div class="cent adbox strip">
                        @include('ads.responsiveads')
                     </div>
                  @endif

                  <div class="flex-images imagesFlex2 dataResult">
                     @include('includes.mob-sim-images')
                     
                     @if( $images->count() != 0  )
                        <div class="container-paginator">{{$images->links()}}
                        </div>
                     @endif
                  </div>
            @else
                  <h3>{{trans('misc.no_results_found')}}</h3>
            @endif
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
"url": "{{ url('/')}}",
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
var ajaxlink = '{{ url("/") }}/ajax/subgroup?q={{$subgroup}}&page=';
</script>
@endsection