<?php $date = Carbon\Carbon::yesterday()->format('Y-m-d'); ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
 @foreach($subcategories as $subcategory)
<?php 
  $imagescount = HH::getSubTotalImages($subcategory->id);
  if( $imagescount == 0 ){
    continue;
  }

   $keywords = explode(",", $subcategory->keyword);
   foreach ($keywords as $key => $subgroup) 
   {
    if( $subgroup == "" ){
      continue;
    }

    $subgroupImages = App\Models\Images::where('status','active')->where('subgroup',$subgroup)->orderBy('date' ,'desc')->limit(1)->get();
    if( count($subgroupImages) == 0 ){
      continue;
    }
    $date = "";
    foreach ($subgroupImages as $subgroupImage) 
    {
      $lastmod = new DateTime($subgroupImage->date);
      $date = $lastmod->format('Y-m-d\TH:i:sP'); 
    }
    ?>
<url>
 <loc>{{ url('g').('/').Str::slug($subgroup)}}</loc>
 <lastmod>{{$date}}</lastmod>
    <?php
      foreach($subgroupImages as $img ){ 
      if(Str::slug( $img->title ) == '' ) {
        $slugUrl  = '';
      } else {
        $slugUrl  = '/'.Str::slug( $img->title );
      }
      if(isset($img->opt_file_source) && $img->opt_file_source != ""){
        $file='file/';
      }else{
        $file='photo/';
      }
   ?>
    <image:image>
      <image:loc>{{config('app.filesurl').('uploads/preview')}}/{{($img->preview)}}</image:loc>
      <image:title>{{$img->title}}</image:title>
      <image:caption>{{ $img->title }}</image:caption>
    </image:image> 
  <?php } ?>
</url>
<?php }?>
@endforeach   
</urlset>