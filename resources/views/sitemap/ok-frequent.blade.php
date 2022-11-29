<?php 
$images = DB::table('images')->where('status', 'active')->orderBy('date', 'DESC')->first();
$latestdata = $images->date;
$latestdatq = new DateTime($latestdata);
$latestdat = $latestdatq->format('Y-m-d\TH:i:sP'); 



$featuredimages = DB::table('images')->where('status', 'active')->where('featured','yes')->orderBy('featured_date', 'DESC')->first();
$featureddata = $featuredimages->featured_date;
$featureddatq = new DateTime($featureddata);
$featureddat = $featureddatq->format('Y-m-d\TH:i:sP'); 

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    <url>
         <loc>{{ url('/') }}</loc>
         <lastmod>{{$latestdat}}</lastmod>
         <changefreq>daily</changefreq>
         <priority>0.9</priority>
   </url>

    <url>
         <loc>{{ url('/latest') }}</loc>
         <lastmod>{{$latestdat}}</lastmod>
         <changefreq>daily</changefreq>
         <priority>0.9</priority>
   </url>

       <url>
         <loc>{{ url('/featured') }}</loc>
         <lastmod>i {{ $featureddat }} </lastmod>
         <changefreq>weekly</changefreq>
         <priority>0.7</priority>
   </url>

</urlset>