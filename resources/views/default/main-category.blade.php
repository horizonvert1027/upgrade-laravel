@extends('layouts.multi')
@section('OwnCss')
<style>.boxe1{float:left;width:25%;padding-left:5px;margin-bottom:10px}img.img-responsive.boxthumb{max-width:100%}@media (min-width: 200px) and (max-width: 400px){.box2{width:50%}}@media (min-width: 401px) and (max-width: 800px){.box3{width:50%}}.boxthumb{border-radius:8px}.col-md-12{display:flex}div#mainLazy{display: flow-root}.col-md-12 {display: block !important}</style>
@endsection
@section('content')
<div class="container">
<section>
  <div class="col-md-12">
  	<div id="mainLazy" class="ibox bsh mt20 mt35">
				<h1>{{ $main_name }}</h1>
					<div class="aligncenter">
						<p>
							<strong>{{trans('misc.browse_by_category')}}</strong>
						</p>
					</div>
					<ol class="breadcrumb">
						<li>
						    <a href="{{ url('/') }}" aria-label="home" title="home">
						        <span class="ichome"></span>
						    </a>
						</li>
						<li>
							<a href="{{ url('type/'.Str::slug($slug)) }}">{{ $main_name }}
							</a>
						</li>
					</ol>
            @if(HH::likecheck($title, $description) == false)
	            <div class="cent adbox strip mb35">
	               @include('ads.responsiveads')
	            </div>
            @endif

				@foreach( $data as $category )

				<?php $images = App\Models\Query::categoryImages($category->slug); ?>
               @if( $images['total'] != 0 )


				<?php if( $category->thumbnail == '' ) { $_image = 'default.jpg'; } else { $_image = $category->thumbnail; } ?>
						<div class="boxe1 box2 box3 box4"> 
						<a href="{{ url('c') }}/{{ $category->slug }}">
							<img class="img-responsive boxthumb" width="457" src="{{config('app.filesurl')}}public/img-category/{{ $_image }}" alt="{{ $category->name }}">
						</a>

					<div class="aligncenter" style="overflow: hidden;margin: 0px 5px;">
						<p>
							<a style="overflow: hidden;white-space: nowrap;" href="{{ url('c') }}/{{ $category->slug }}">
								{{ ($category->name)}}({{$category->images()->count()}})
							</a>
						</p>
					</div>
					</div>

					@endif
				@endforeach
	 </div>
  </div>
</section>
</div>
@endsection

@section('SchemaJson')
		<script type="application/ld+json">
			{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"{{ url('/') }}","name":"Home"}},{"@type":"ListItem","position":2,"item":{"@id":"{{ url('type/'.Str::slug($slug)) }}","name":"{{ $main_name }}"}}]}
		</script>
		<script type="application/ld+json">
			[{"@context":"http://schema.org","@type":"WebSite","name":"{{ $main_name }}","description":"Best {{ $main_name }}","keywords":"{{ $keywords }}","url":"{{ url('type/'.Str::slug($slug)) }}","potentialAction":{"@type":"SearchAction","target":"{{ url('/') }}/search?q={search_term_string}","query-input":"required name=search_term_string"}}]
		</script>
	@endsection