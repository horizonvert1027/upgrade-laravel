<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php
         $allsubs = App\subcategories::all();
         $all_len = count($allsubs);
         $pages = 0;
            if( $all_len > 500 )
            {
            	$pages = round($all_len / 500) ;
            }
         for($i=1; $i < $pages; $i++) { 
         	$index = "-".$i;
            ?>
            <sitemap>
                  <loc>{{ url('/')}}/sg/subgroup{{$index}}</loc>
            </sitemap>
            <?php
         }
   ?>
</sitemapindex>