<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($subcat as $sub)
@php
$imagescount = App\Helper::getSubTotalImages($sub->id);
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
 @php
 	$images = DB::table('images')->where('subcategories_id', $sub->id)->orderBy('date' , 'desc')->limit($limit)->get();
 @endphp
  @foreach($images as $img)
	<?php  if( \Illuminate\Support\Str::slug( $img->title ) == '' ) {
		$slugUrl  = '';
	} else {
		$slugUrl  = '/'.\Illuminate\Support\Str::slug( $img->title );
	}
	if(isset($img->opt_file_source) && $img->opt_file_source != ""){
		$file='file/';
	}else{
		$file='photo/';
	}
?><image:image>
	<image:loc>{{config('app.filesurl').('uploads/thumbnail')}}/{{($img->thumbnail)}}</image:loc>
	<image:title>{{$img->title}}</image:title>
	<image:caption>{{ $img->title }}</image:caption>
</image:image>
@endforeach
</url>
@endforeach
</urlset>