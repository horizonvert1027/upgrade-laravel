@extends('layouts.multi')

@section('OwnCss')

   @if(($previousimgthumbnail !=''))
      <link rel="preload" as="image" href="{{$previousimgthumbnail}}">
   @endif

   @if(($nextimgthumbnail !=''))
      <link rel="preload" as="image" href="{{$nextimgthumbnail}}">
   @endif

   <link rel="preload" as="image" href="{{$thumbimage}}">
   <meta name="robots" content="max-image-preview:large">
@endsection

@section('content')
   <div class="container">
      <section>
     
            <!-- col-md-8 -->
            <div class="col-md-8">
               @if( $response->status == 'pending' )
                  <div class="alert alert-warning" role="alert">
                     Pending Approval
                  </div>
               @endif
         
               <div class="ibox bsh gallnav">
                  @if( $previousimageurl != "" )
                  <a href="{{$previousimageurl}}" title="{{$previousimage->title}}" rel="prev">
                     <div class="floatleft">
                        <img alt="{{$previousimage->title}}" class="img-circle bsh" src="{{$previousimgthumbnail}}" height="45" width="45">
                     </div>
                     <span class="iccleft floatleft"></span>
                  </a>
                  @else
                     <div class="floatleft" style="visibility: hidden">
                        <img class="img-circle bsh" height="45" width="45">
                     </div>
                     <span class="iccleft floatleft" style="visibility: hidden"></span>
                  @endif

                  <a onclick="vibrateSimple();" href="@if($response->subgroup!=''){{url('/')}}/g/{{Str::slug($response->subgroup)}}@else{{$subcatlink}}@endif" class="gall mybtn">
                     <span class="glrtxt">Gallery</span>
                  </a>

                  @if( $nextimageurl != "" )
                  <a href="{{$nextimageurl}}" title="{{$nextimage->title}}" rel="next">
                     <div class="floatright">
                        <img alt="{{$nextimage->title}}" class="img-circle bsh" src="{{$nextimgthumbnail}}" height="45" width="45">
                     </div>
                     <span class="iccright floatright"></span>
                  </a>
                  @else
                     <div class="floatright" style="visibility: hidden">
                        <img class="img-circle bsh" height="45" width="45">
                     </div>
                     <span class="iccright floatright" style="visibility: hidden"></span>
                  @endif


               </div>

               <div class="pwadiv">
                  <p class="dummytxt">Quick to Web App</p>
                  <button onclick="vibrateSimple()" class="btnApp" aria-label="Install Progresive App button">Install Web App</button>
               </div>

              
               <div class="ibox bsh">
                  <div class="aligncenter">
                    

                     <div class="imgd">
                         <img class="img-thumbnail disableRightClick" src="{{$thumbimage}}" alt="{{$imgalt}}" width="{{$newWidth}}" height="{{$newHeight}}" style="{{$png}}">
 
                     </div>
                  </div>

               </div>


                  <div class="credits1">
                     <div class="credits22">
                          @if($credits!='')<b>📷</b> {{$credits}}@else <b>Source:</b> Social Media @endif
                        <button id="myPopup1" class="tooltip popup">i
                           <span class="popuptext" id="myPopup">
                              @if($response->user()->username!='')This {{$filename}} is uploaded by user, <b>{{$response->user()->name}}</b>.@endif
                              The authority of this {{$filename}} belongs to its respective owner @if($credits!='')<b>'{{$credits}}'</b> Please give the credits to '{{$credits}}', if you have the permission/license to use this {{$filename}} anywhere. @endif <br>
                              {{$settings->sitename}} is a community platform for users to download and share {{$filename}}.<br>
                              If you've any issue, please visit <a href="#footerbtn" style="color:#00af9c"><b>DMCA/Contact</b></a> page.
                           </span>
                        </button>
                     </div>

                  </div>

               <div class="title">
                  <h1>{{$imgtitletrue}}</h1>
               </div>

               @if(HH::likecheck($title, $description) == false)
               
                  <div class="cent adbox">
                     @include('ads.responsiveads')
                  </div>
              
               @endif
                 
            </div>
            <!-- col-md-8 END-->
            <!-- col-md-4 -->
            <div class="col-md-4">

               <div class="ibox bsh description">
                  @php
                     if( $imgdescrtrue != '' ) { 
                        $name='#'.str_replace(' ','',$subcatname);
                        $imgdescrtrue=preg_replace("/(#([\w\-.]*)+ )+/","<a href='".$subcatlink."'>$name </a>",$imgdescrtrue);
                     } 
                  @endphp

                  @php
                     $dstr = $imgdescrtrue;
                     $topdescr = $moredescr = "";
                     if( strlen($dstr) > 500 ) {
                        $pindex=strpos($dstr,"</p>");
                        $topdescr=substr($dstr,0,$pindex+4);
                        $topdescr .='<a href="javascript:void(0);" class="read-more">read more...</a>';
                        $moredescr=substr($dstr,$pindex+4);
                        $topdescr .='<span class="more-text">'.$moredescr.'</span>';
                     }
                     else {
                        $topdescr = $dstr;
                     }
                  @endphp
                  <div class="show-read-more">{!!$topdescr!!}</div>
               </div>

               @if(HH::likecheck($title, $description) == false)
                  <div class="ibox bsh desk">
                     <div class="cent adbox">
                        @include('ads.desk')
                     </div>
                  </div>
               @endif

                   @if( Auth::check() && isset($response->user()->id) && Auth::user()->id == $response->user()->id )
                     <div style="display: flex;margin-bottom: 15px;">

                        <div style="margin-right: 2px;display: block;width: -webkit-fill-available;text-align: -webkit-center;background: var(--link-clr);border-radius: 5px 0px 0px 5px;">
                           <a style="color: var(--box-clr);padding: 5px;display: block;font-size: 16px;font-weight: 600;" href="{{url('panel/admin/images',$response->id) }}">{{trans('admin.edit')}}
                           </a>
                        </div>

                        <form style="background: blue;color: white;display: block;width: -webkit-fill-available;border-radius: 0px 5px 5px 0px;margin-block-end: 0em;" method="POST" action="{{url('panel/admin/images/delete')}}">
                           <input name="_token" type="hidden" value="{{{csrf_token()}}}">
                           <input name="id" type="hidden" value="{{$response->id}}">
                           <input style="border: none;color: white;background: #cf1313;width: -webkit-fill-available;display: block;padding: 6px;border-radius: 0px 5px 5px 0px;font-size: 16px;" data-url="{{$response->id}}" class="actionDelete" type="submit" value="Delete">
                        </form>
                     </div>
                     @endif

                  <button onclick="location.href='{{url('fetch',$response->large)}}/original';vibrateSimple()" class="mybtn" aria-label="download">Download
                  </button>
               @if(HH::likecheck($title, $description) == false)
                  <div class="ibox bsh desk">
                     <div class="cent adbox">
                        @include('ads.desk')
                     </div>
                  </div>
               @endif
            @if($response->subcat->keyword!= '')

               @php
                  $tags=explode(',',$response->subcat->keyword);
                  $count_tags=count($tags);
                  $checksg = HH::checktaghasimg($tags);
               @endphp

               @if($checksg !='')
                  <div class="ibox bsh">
                        <h4>Tagged</h4>
                        <div class="projects-catalog">
                           <div class="catalog-cover">
                              <i class="left-button"></i>
                              <ul class="sliderWrapper1 sliderscroll">
                                 <?php for( $i = 0; $i < $count_tags; ++$i) { $sthumbnail = HH::getFristImageSubGroup($tags[$i]);?> 
                                      @if($sthumbnail!='')
                                    <li class="slide">
                                      <a class="slink" href="{{url('g',Str::slug(($tags[$i])))}}">
                                       <img height="50" width="50" loading="lazy" class="img-circle tags" src="{{config('app.filesurl')}}uploads/thumbnail/{{($sthumbnail)}}" alt="{{ $tags[$i] }}">
                                       <div class="sidekro tags">
                                       <?php 
                                          $subgroupname =HH::specialmatchedword($tags[$i], $subcatname);
                                          $subgroupname = HH::subgroupneat($subgroupname);
                                       ?>
                                          {{$subgroupname}}
                                       </div>
                                       </a>
                                    </li>
                                       @endif
                                  <?php } ?>
                              </ul>
                              <i class="right-button"></i> 
                           </div>
                     </div>
                  </div>     
               @endif
               @endif

               @if($response->category->relatedtags!= '')
                  <div class="ibox bsh">
                     <h4>Related</h4>
                     <?php $tags=explode(',',$response->category->relatedtags);
                     $count_tags=count($tags) ?>
                     <div class="projects-catalog">
                        <div class="catalog-cover">
                           <i class="left-button sq"></i>
                           <ul class="sliderWrapper2 sliderscroll">
                        <?php for( $i = 0; $i < $count_tags; ++$i) { 
                           $sthumbnail = HH::getSubCategoryThumbnail($tags[$i]);
                           $tagged = HH::getSubCategoryTagged($tags[$i]);
                           $totalimages = HH::getSubCategoryTotalImages($tags[$i]);
                           $subcatslug =  HH::getSubCategoryslug($tags[$i]);
                           $getext =  HH::getSubCategoryExt($tags[$i]);
                           $optfile =  HH::getSubCategoryOptfile($tags[$i]);
                           $getname = HH::getSubCategoryName($tags[$i]);
                           if($sthumbnail!=''){ 
                              $relthumb = config('app.filesurl').'public/img-subcategory/'.$sthumbnail;
                           }
                           else{
                              $relthumb = config('app.filesurl').'public/img-category/default.jpg';
                           }
                        ?> 
                        <li class="slide">
                              <a class="slink sq" href="{{url('s',Str::slug(($subcatslug)))}}">
                                 <img height="80" width="102" loading="lazy" class="img-circle sqtags" src="{{$relthumb}}" alt="{{ $getname }} @if($optfile!=NULL) {{$optfile}} Files @else Images @endif">
                                 <div class="sidekro chapta">
                                    <p><b>{{(Str::limit(ucwords($getname),16,'.'))}}</b></p>
                                    <p>{{(Str::limit($tagged,18,'.'))}}</p>
                                    <p>({{$totalimages}}) @if($optfile!=NULL) {{$optfile}} Files @else Images @endif</p>
                                 </div>
                              </a>
                        </li>
                        <?php 
                           } 
                        ?>
                  <li class="slide">
                     <a class="slink viewmore" href="{{($catlink)}}">
                     <div class="sidekro viewmore1" style="margin: 4px;">
                     <p><b>View</b></p>
                     <p>more</p>
                     </div>
                     </a>
                  </li>
                           </ul>
                           
                           <i class="right-button sq"></i> 
                        </div>
                     </div>
                  </div>     
               @endif


            <a class="arrowsim" href="#tosimilar">
               <div class="gtsim">
                  <span></span>
                  <span></span>
                  <span></span>
               </div>
               <p class="scrolltxt">Scroll to Similar</p>
            </a>
            
            </div>
            <!-- col-md-4 END-->   
        
          <!-- col-md-12 END -->

         <div class="col-md-12" id="tosimilar">
            <div class="ibox bsh">

               @if(HH::likecheck($title, $description) == false)
               
                     <div class="cent adbox">
                        @include('ads.mobileads')
                     </div>
                  
               @endif

               @if( $images->count() != 0 )
                  <div class="card-header">
                     <h4>Similar {{$response->subcat->name}}</h4>
                  </div>
                  <div class="flex-images imagesFlex2">
                     @include('includes.imageslazy')
                  </div>
               @endif
            </div>
         </div>

      </section>
   </div>
   
   @if(HH::likecheck($title, $description) == false)
      @include('ads.stickyads')
   @endif
   
@endsection

@section('SchemaJson')
<script type="application/ld+json">
   [{"@context":"https://schema.org","@type": "BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "{{ url('/') }}"},{"@type":"ListItem","position": 2,"name":"@if($response->subgroup!=''){{$subcatname}} @else {{($catname)}}@endif","item":"@if($response->subgroup!=''){{($subcatlink)}} @else {{($catlink)}} @endif"},{"@type":"ListItem","position":3,"name":"@if($response->subgroup!=''){{($response->subgroup)}} @else{{($subcatname)}}@endif","item":"@if($response->subgroup!=''){{url('/')}}/g/{{Str::slug($response->subgroup)}}@else {{($subcatlink)}} @endif"},{"@type":"ListItem","position":4,"name":"{{$title}}"}]},{"@context":"http://schema.org","@type":"Organization","name":"{{$settings->sitename}}","url":"{{ url('/') }}","logo":"{{ asset('public/img/apple') }}/apple-touch-icon.png","sameAs":["https://www.facebook.com/{{$settings->facebook}}","https://twitter.com/{{$settings->twitter}}","https://instagram.com/{{$settings->instagram}}"]},{"@context":"http://schema.org","@type":"ImageObject","name":"{{$title}}","description":"{{$description}}","keywords":"{{$keywords}}","caption":"{{$imgtitletrue}}","contentUrl":"{{$imglarge}}","image":"{{$contenturl}}","url":"{{$contenturl}}",@if(isset($response->opt_file_source) && $response->opt_file_source != "")"fileFormat":"image/{{$response->extension}}",@endif "thumbnail":"{{$thumbimage}}","sourceOrganization":"{{$settings->sitename}}" }]
</script>
@endsection