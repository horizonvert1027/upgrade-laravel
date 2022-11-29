<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	@foreach( $searchkeywords as $query )
    	<url>
            <loc>{{ url('search?q=')}}{{($query->query) }}</loc>
       </url>
    @endforeach
</urlset>