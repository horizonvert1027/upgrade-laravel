@foreach($subcategories as $sub ) 

<?php  $imagescount = App\Helper::getSubTotalImages($sub->id); 
if( $imagescount == 0 ){ 
	continue; 
} 
if( $sub->sthumbnail == '' ) { 
	$_image = 'default.jpg'; 
} 
else { 
	$_image = $sub->sthumbnail;
} 
?> 

	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 row-margin-20">
		<a href="{{url('s')}}/{{("$sub->slug")}}">
			<img height="350" width="439" class="custom-rounded" loading="lazy" src="{{config('app.filesurl')}}{{(config('path.img-subcategory').$_image)}}" alt="{{ $sub->name }}">
		</a>
		<h3>
			<a class="tab-list" href="{{url('s')}}/{{("$sub->slug")}}">{{Str::limit($sub->name, 18, '') }} </a>
		</h3>
	</div>
	@endforeach

	@if( count($subcategories) == $limit )
	<div class="catpagination">
		<a style="display:block;" href="{{url('ajax/subcategories')}}?page={{$page+1}}">Show More</a>
	</div>
	@endif