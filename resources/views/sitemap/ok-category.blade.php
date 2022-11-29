<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	@foreach( App\Models\Categories::all() as $cat )
		@php
			$images = App\Models\Images::where('status', 'active')->where('categories_id',$cat->id)->get();
			$total = $images->count(); 
		@endphp

		@if(!$total==0)
			<url>
				@php
					$lastdate = $cat->last_updated;
					$lastmod = new DateTime($lastdate);
					$result = $lastmod->format('Y-m-d\TH:i:sP');
				@endphp
				<loc>{{ url('c')}}/{{($cat->slug) }}</loc>
				<lastmod>{{($result)}}</lastmod>
			</url>
		@endif
	@endforeach

</urlset>