<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
	@foreach( App\Models\Pages::all() as $page )
    	<url>
             <loc>{{ url('page',$page->slug) }}</loc>
             <priority>0.3</priority>
             <changefreq>yearly</changefreq>
       </url>
    @endforeach

</urlset>