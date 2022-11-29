<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

         <?php
         use App\subcategories;
         $page = isset($page) ? $page : 0;
         $offset = $page * 500;
         ?>

   @foreach( subcategories::offset($offset)->limit(500)->get() as $subcategories )
   
         @php
            $tags = $subcategories->keyword;
            $tags=explode(',',$tags);
            $count_tags=count($tags);
            $first=HH::getFristImageSubGroup($tags[0]);
         @endphp

      @if( $first !="") 
         <sitemap>
               <loc>{{ url('sg')}}/subgroupsof/{{Str::slug($subcategories->slug)}}</loc>
         </sitemap>
      @endif

   @endforeach

</sitemapindex>
