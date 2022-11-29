<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
        @foreach($subcat as $sub)
                @php
                        $imagescount = HH::getSubTotalImages($sub->id);
                                if( $imagescount == 0 ){
                                	continue;
                                }
                        $lastdate = $sub->last_updated;
                        $lastmod = new DateTime($lastdate);
                        $result = $lastmod->format('Y-m-d\TH:i:sP');
                @endphp
                <url>
                        <loc>{{url('/')}}/s/{{\Illuminate\Support\Str::slug($sub->slug)}}</loc>
                        <lastmod>{{$result}}</lastmod>
                </url>
        @endforeach
</urlset>