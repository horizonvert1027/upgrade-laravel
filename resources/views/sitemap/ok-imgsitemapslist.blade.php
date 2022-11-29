<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$all_len = App\Models\Images::where('status','active')->count();
$pages = 0;
if( $all_len > 5000 )
{
   $pages = round($all_len / 5000);
}
else
{
   $pages = 1;  
}
for($i=0; $i < $pages; $i++) { 
   $index = ($i == 0) ? "" : "-".$i;
} 
for($i=0; $i < $pages; $i++) { 
   $index = ($i == 0) ? "" : "-".$i;
?>
<sitemap>
      <loc>{{ url('/')}}/sg/images{{$index}}</loc>
</sitemap>
<?php } ?>
</sitemapindex>