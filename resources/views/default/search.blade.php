<?php

$keywords = $titleahead = $preview = $thumbimage = '';
if($images->total())
{
    $titleahead = $images[0]->category->main_cat_id;
    $keywords = $images[0]->metakeywords;
    $preview = $images[0]->preview;
}
if(isset($titleahead) && $titleahead == 0)
{$aageka  = 'Full HD Backgrounds';} 
elseif(isset( $titleahead) && $titleahead == 1)
{$aageka  = 'Full HD Transparent Images';}
elseif(isset( $titleahead) && $titleahead == 2)
{$aageka  = 'Full HD Wallpapers';}
elseif(isset( $titleahead) && $titleahead == 3)
{$aageka  = 'Presets & Brushes';}
elseif(isset( $titleahead) && $titleahead == 4)
{$aageka  = 'Graphics Templates';}
else {$aageka = 'HD Images | Photo';}
;

if(isset($img->opt_file_source) && $img->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}

$title = ucwords($q). ' ' . $aageka;
$description = ucwords($q) . ' ' . $aageka;
$thumbimage = config('app.filesurl').'uploads/preview/' . $preview;
$sitemap = '';
$multilangLink = config('app.topsiteurl').'/search?q='.$q;
$contenturl = url('/').'/search?q='.$q;
$rssfeed = url('/').'/rssfeeds';

?>
@extends('layouts.multi')

@section('title'){{ e($title) }}@endsection

@section('content')

 <div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">
	        <h1>{{ trans('misc.result_of') }} "{{ $q }}"</h1>
	        <h5 class="aligncenter">{{ $total }} Total Files Matched</h5>
		      @if( $images->total() == 0 )
		        <p class="subtitle-site aligncenter"><strong>No Files Matched</strong></p>
		      @endif

					@if( $images->total() != 0 )
				
			            @if(HH::likecheck($q) == false)
				            <div class="cent adbox strip">
				               @include('ads.responsiveads')
				            </div>
			            @endif
			            
							<div class="flex-images imagesFlex2 dataResult">
								@include('includes.mob-sim-images')
									@if( $images->count() != 0  )
									    <div class="container-paginator">
										{{ $images->links() }}
										</div>
									@endif
							</div>

				             @else
				           
				    		<h3>
				    			{{ trans('misc.no_results_found') }}
				    	   </h3>

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
				"@context": "https://schema.org",
				"@type": "WebSite",
				"url": "{{ url('/') }}",
				"potentialAction": {
					"@type": "SearchAction",
					"target": "{{ url('/') }}/search?q={search_term_string}",
					"query-input": "required name=search_term_string"
				}
			},
			@foreach($images as $k => $i)
				@php 
					if($i->opt_file_source != "") {
						$slugUrl1  = 'file';
					}
					else {
						$slugUrl1  = 'photo';
					}
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
		var ajaxlink = '{{ url("/") }}/ajax/search?q={{$q}}&page=';
	</script>
@endsection
