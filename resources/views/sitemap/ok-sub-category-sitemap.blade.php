<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach( App\Models\Categories::all() as $categories )
	<?php
		$images = App\Models\Images::where('status', 'active')->where('categories_id',$categories->id)->get();
		$total = $images->count(); 
		$allsubcats = App\subcategories::where("categories_id", $categories->id)->where('mode','on')->get();
		$len = count($allsubcats);
		if( $len == 0 ){
			$forlen = 1;	
		}else{
			$forlen = round( $len / 100 ) + 1;
		}
		for($i=0; $i < $forlen; $i++) 
		{
			$page = ( $i == 0 ) ? "" : "-".$i;
			?>

			@if(!$total==0)
				<sitemap>
					<loc>{{url('/')}}/sg/{{($categories->slug)}}/subcategories{{$page}}</loc>
				</sitemap>
		 	@endif

			<?php
		}
	?>
@endforeach
</sitemapindex>