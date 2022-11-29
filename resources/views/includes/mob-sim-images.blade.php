@foreach( $images as $image)

<?php
   $resolution = explode('x', $image->resolution);
   $newWidth = $resolution[0];
   $newHeight = $resolution[1];
   
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

   else { 
      $background = '';
   }


   if ($image->extension == 'gif') {
      $thumbnail = config('app.filesurl').(config('path.large').$image->large); 
   }
      else {
         $thumbnail = config('app.filesurl').(config('path.simthumbnail').$image->simthumbnail); 
      }

?>
   <a style="{{$background}}" href="{{config('app.appurl')}}/{{$slugUrl1}}/{{$image->id}}/{{ Str::slug($image->title)}}" class="item hovercard mobileimgs" data-w="{{$newWidth}}" data-h="{{$newHeight}}" title="{{$image->title}}">
      <img data-src="{{$thumbnail}}" class="lozad" height="{{$newHeight}}" width="{{$newWidth}}" alt="{{Str::limit($image->title, 28, '') }}"/>
   </a>
   <a href="{{config('app.appurl')}}/{{$slugUrl1}}/{{$image->id}}/{{ Str::slug($image->title)}}" class="mob imgbtn btn">Go to Download Page
   </a> 
      
      @if(HH::likecheck($image->title) == false)
         @if( ($loop->iteration % 7) == 0 )
            <div class="googleadblock cent adbox">
               @include('ads.mobileads')
            </div>
         @endif
      @endif
      
@endforeach