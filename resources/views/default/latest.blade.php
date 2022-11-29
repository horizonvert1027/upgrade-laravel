@extends('layouts.multi')
@section('content')   
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="ibox bsh mt20 mt35">
                    @if(HH::likecheck($title, $description) == false)
                        <div class="cent adbox strip">
                        @include('ads.responsiveads')
                        </div>
                    @endif
                	<div class="flex-images imagesFlex2 dataResult">
                	@include('includes.mob-sim-images')
                    	<div class="container-paginator">{{ $images->links() }}
                        </div>
                	</div>
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
       var ajaxlink = '{{ URL::to("/") }}/ajax/latest?page='
    </script>
@endsection