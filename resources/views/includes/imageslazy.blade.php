@foreach( $images as $image ) 

<?php
	$resolution = explode('x', $image->resolution);
	$newWidth = $resolution[0];
	$newHeight = $resolution[1];
	$thumbnail = config('app.filesurl').(config('path.simthumbnail').$image->simthumbnail);
	$slug = $image->category->slug;
	$categories = DB::table('categories')->where('slug','=',$slug)->get();
	$maincategoryID = $categories[0]->main_cat_id;


	if(isset($image->opt_file_source) && $image->opt_file_source != "") { 
		$slugUrl1  = 'file';
		} 
		else {
			$slugUrl1  = 'photo';
		}

	if($maincategoryID == '1' ) { 
		$background = 'background-image: url('.url('public/img/png_bg.png').');';
	} 

	elseif ($image->extension == 'gif') {
		$thumbnail = config('app.filesurl').(config('path.large').$image->large); 
		$background = '';
	}
	else { 
		$background = '';
	}

?>

<a style="{{$background}}" href="{{config('app.appurl')}}/{{$slugUrl1}}/{{$image->id}}/{{ Str::slug($image->title)}}" class="item" data-w="{{$newWidth}}" data-h="{{$newHeight}}" title="{{$image->title}}">
	<img class="lozad" src="/public/svg/load.svg" data-src="{{$thumbnail}}" alt="{{Str::limit($image->title, 28, '') }}"/>
</a>

@endforeach
