@extends('layouts.multi')
@section('content')

    <div class="container">
		   <section>
		      <div class="col-md-12">
		         <div class="ibox bsh mt20 mt35">
					
							@if( $images->total() != 0 )
								@if(HH::likecheck($title, $description) == false)
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

							<h3 class="aligncenter">
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
           [   {
           "@context": "https://schema.org",
           "@type": "WebSite",
           "url": "{{ url('/') }}",
           "potentialAction": {
           "@type": "SearchAction",
           "target": "{{ url('/') }}/search?q={search_term_string}",
           "query-input": "required name=search_term_string"
           }},

           {"@context":"http://schema.org","@type":"Organization","name":"{{config('app.sitename')}}","url":"{{ url('/') }}","logo":"{{ asset('public/img/apple') }}/apple-touch-icon.png","sameAs":["https://www.facebook.com/{{config('app.sitename')}}","https://twitter.com/{{config('app.sitename')}}","http://{{config('app.sitename')}}.tumblr.com/","https://instagram.com/{{config('app.sitename')}}/"]},

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
                        "sourceOrganization":"{{config('app.sitename')}}"
                     }
                        @if($k != (count($images) - 1)),
                        @endif
                  @endforeach
           ]
         </script>
@endsection

@section('javascript')
        <script>
            var ajaxlink = '{{ URL::to("/") }}/ajax/featured?page='
        </script>
@endsection
