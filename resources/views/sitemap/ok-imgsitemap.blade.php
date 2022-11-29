<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

@php
$page = isset($page) ? $page : 0;
$offset = $page * 5000;
@endphp
   @foreach( App\Models\Images::offset($offset)->where('status','active')->limit(5000)->get() as $img)
   <?php  if( \Illuminate\Support\Str::slug( $img->title ) == '' ) {
				$slugUrl  = '';
			} else {
				$slugUrl  = '/'.\Illuminate\Support\Str::slug( $img->title );
			} ;

			if(isset($img->opt_file_source) && $img->opt_file_source != ""){
				$file='file/';
			}
			else
			{
				$file='photo/';
			}
			?>
<url>
 <loc>{{ url($file).('/').($img->id).$slugUrl }}</loc>
     <image:image>
		<image:loc>{{config('app.filesurl').(config('path.preview'))}}{{($img->preview)}}</image:loc>
		<image:title>{{$img->title}}</image:title>
		<image:caption>{{ $img->title }}</image:caption>
	 </image:image>
</url>
 @endforeach
   
</urlset>