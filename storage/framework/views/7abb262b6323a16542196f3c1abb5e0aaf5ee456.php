

<?php $__env->startSection('OwnCss'); ?>

   <?php if(($previousimgthumbnail !='')): ?>
      <link rel="preload" as="image" href="<?php echo e($previousimgthumbnail); ?>">
   <?php endif; ?>

   <?php if(($nextimgthumbnail !='')): ?>
      <link rel="preload" as="image" href="<?php echo e($nextimgthumbnail); ?>">
   <?php endif; ?>

   <link rel="preload" as="image" href="<?php echo e($thumbimage); ?>">
   <meta name="robots" content="max-image-preview:large">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
   <div class="container">
      <section>
     
            <!-- col-md-8 -->
            <div class="col-md-8">
               <?php if( $response->status == 'pending' ): ?>
                  <div class="alert alert-warning" role="alert">
                     Pending Approval
                  </div>
               <?php endif; ?>
         
               <div class="ibox bsh gallnav">
                  <?php if( $previousimageurl != "" ): ?>
                  <a href="<?php echo e($previousimageurl); ?>" title="<?php echo e($previousimage->title); ?>" rel="prev">
                     <div class="floatleft">
                        <img alt="<?php echo e($previousimage->title); ?>" class="img-circle bsh" src="<?php echo e($previousimgthumbnail); ?>" height="45" width="45">
                     </div>
                     <span class="iccleft floatleft"></span>
                  </a>
                  <?php else: ?>
                     <div class="floatleft" style="visibility: hidden">
                        <img class="img-circle bsh" height="45" width="45">
                     </div>
                     <span class="iccleft floatleft" style="visibility: hidden"></span>
                  <?php endif; ?>

                  <a onclick="vibrateSimple();" href="<?php if($response->subgroup!=''): ?><?php echo e(url('/')); ?>/g/<?php echo e(Str::slug($response->subgroup)); ?><?php else: ?><?php echo e($subcatlink); ?><?php endif; ?>" class="gall mybtn">
                     <span class="glrtxt">Gallery</span>
                  </a>

                  <?php if( $nextimageurl != "" ): ?>
                  <a href="<?php echo e($nextimageurl); ?>" title="<?php echo e($nextimage->title); ?>" rel="next">
                     <div class="floatright">
                        <img alt="<?php echo e($nextimage->title); ?>" class="img-circle bsh" src="<?php echo e($nextimgthumbnail); ?>" height="45" width="45">
                     </div>
                     <span class="iccright floatright"></span>
                  </a>
                  <?php else: ?>
                     <div class="floatright" style="visibility: hidden">
                        <img class="img-circle bsh" height="45" width="45">
                     </div>
                     <span class="iccright floatright" style="visibility: hidden"></span>
                  <?php endif; ?>


               </div>

               <div class="pwadiv">
                  <p class="dummytxt">Quick to Web App</p>
                  <button onclick="vibrateSimple()" class="btnApp" aria-label="Install Progresive App button">Install Web App</button>
               </div>

              
               <div class="ibox bsh">
                  <div class="aligncenter">
                    

                     <div class="imgd">
                         <img class="img-thumbnail disableRightClick" src="<?php echo e($thumbimage); ?>" alt="<?php echo e($imgalt); ?>" width="<?php echo e($newWidth); ?>" height="<?php echo e($newHeight); ?>" style="<?php echo e($png); ?>">
 
                     </div>
                  </div>

               </div>


                  <div class="credits1">
                     <div class="credits22">
                          <?php if($credits!=''): ?><b>📷</b> <?php echo e($credits); ?><?php else: ?> <b>Source:</b> Social Media <?php endif; ?>
                        <button id="myPopup1" class="tooltip popup">i
                           <span class="popuptext" id="myPopup">
                              <?php if($response->user()->username!=''): ?>This <?php echo e($filename); ?> is uploaded by user, <b><?php echo e($response->user()->name); ?></b>.<?php endif; ?>
                              The authority of this <?php echo e($filename); ?> belongs to its respective owner <?php if($credits!=''): ?><b>'<?php echo e($credits); ?>'</b> Please give the credits to '<?php echo e($credits); ?>', if you have the permission/license to use this <?php echo e($filename); ?> anywhere. <?php endif; ?> <br>
                              <?php echo e($settings->sitename); ?> is a community platform for users to download and share <?php echo e($filename); ?>.<br>
                              If you've any issue, please visit <a href="#footerbtn" style="color:#00af9c"><b>DMCA/Contact</b></a> page.
                           </span>
                        </button>
                     </div>

                  </div>

               <div class="title">
                  <h1><?php echo e($imgtitletrue); ?></h1>
               </div>

               <?php if(HH::likecheck($title, $description) == false): ?>
               
                  <div class="cent adbox">
                     <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
              
               <?php endif; ?>
                 
            </div>
            <!-- col-md-8 END-->
            <!-- col-md-4 -->
            <div class="col-md-4">

               <div class="ibox bsh description">
                  <?php
                     if( $imgdescrtrue != '' ) { 
                        $name='#'.str_replace(' ','',$subcatname);
                        $imgdescrtrue=preg_replace("/(#([\w\-.]*)+ )+/","<a href='".$subcatlink."'>$name </a>",$imgdescrtrue);
                     } 
                  ?>

                  <?php
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
                  ?>
                  <div class="show-read-more"><?php echo $topdescr; ?></div>
               </div>

               <?php if(HH::likecheck($title, $description) == false): ?>
                  <div class="ibox bsh desk">
                     <div class="cent adbox">
                        <?php echo $__env->make('ads.desk', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </div>
                  </div>
               <?php endif; ?>

                   <?php if( Auth::check() && isset($response->user()->id) && Auth::user()->id == $response->user()->id ): ?>
                     <div style="display: flex;margin-bottom: 15px;">

                        <div style="margin-right: 2px;display: block;width: -webkit-fill-available;text-align: -webkit-center;background: var(--link-clr);border-radius: 5px 0px 0px 5px;">
                           <a style="color: var(--box-clr);padding: 5px;display: block;font-size: 16px;font-weight: 600;" href="<?php echo e(url('panel/admin/images',$response->id)); ?>"><?php echo e(trans('admin.edit')); ?>

                           </a>
                        </div>

                        <form style="background: blue;color: white;display: block;width: -webkit-fill-available;border-radius: 0px 5px 5px 0px;margin-block-end: 0em;" method="POST" action="<?php echo e(url('panel/admin/images/delete')); ?>">
                           <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
                           <input name="id" type="hidden" value="<?php echo e($response->id); ?>">
                           <input style="border: none;color: white;background: #cf1313;width: -webkit-fill-available;display: block;padding: 6px;border-radius: 0px 5px 5px 0px;font-size: 16px;" data-url="<?php echo e($response->id); ?>" class="actionDelete" type="submit" value="Delete">
                        </form>
                     </div>
                     <?php endif; ?>

                  <button onclick="location.href='<?php echo e(url('fetch',$response->large)); ?>/original';vibrateSimple()" class="mybtn" aria-label="download">Download
                  </button>
               <?php if(HH::likecheck($title, $description) == false): ?>
                  <div class="ibox bsh desk">
                     <div class="cent adbox">
                        <?php echo $__env->make('ads.desk', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </div>
                  </div>
               <?php endif; ?>
            <?php if($response->subcat->keyword!= ''): ?>

               <?php
                  $tags=explode(',',$response->subcat->keyword);
                  $count_tags=count($tags);
                  $checksg = HH::checktaghasimg($tags);
               ?>

               <?php if($checksg !=''): ?>
                  <div class="ibox bsh">
                        <h4>Tagged</h4>
                        <div class="projects-catalog">
                           <div class="catalog-cover">
                              <i class="left-button"></i>
                              <ul class="sliderWrapper1 sliderscroll">
                                 <?php for( $i = 0; $i < $count_tags; ++$i) { $sthumbnail = HH::getFristImageSubGroup($tags[$i]);?> 
                                      <?php if($sthumbnail!=''): ?>
                                    <li class="slide">
                                      <a class="slink" href="<?php echo e(url('g',Str::slug(($tags[$i])))); ?>">
                                       <img height="50" width="50" loading="lazy" class="img-circle tags" src="<?php echo e(config('app.filesurl')); ?>uploads/thumbnail/<?php echo e(($sthumbnail)); ?>" alt="<?php echo e($tags[$i]); ?>">
                                       <div class="sidekro tags">
                                       <?php 
                                          $subgroupname =HH::specialmatchedword($tags[$i], $subcatname);
                                          $subgroupname = HH::subgroupneat($subgroupname);
                                       ?>
                                          <?php echo e($subgroupname); ?>

                                       </div>
                                       </a>
                                    </li>
                                       <?php endif; ?>
                                  <?php } ?>
                              </ul>
                              <i class="right-button"></i> 
                           </div>
                     </div>
                  </div>     
               <?php endif; ?>
               <?php endif; ?>

               <?php if($response->category->relatedtags!= ''): ?>
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
                              <a class="slink sq" href="<?php echo e(url('s',Str::slug(($subcatslug)))); ?>">
                                 <img height="80" width="102" loading="lazy" class="img-circle sqtags" src="<?php echo e($relthumb); ?>" alt="<?php echo e($getname); ?> <?php if($optfile!=NULL): ?> <?php echo e($optfile); ?> Files <?php else: ?> Images <?php endif; ?>">
                                 <div class="sidekro chapta">
                                    <p><b><?php echo e((Str::limit(ucwords($getname),16,'.'))); ?></b></p>
                                    <p><?php echo e((Str::limit($tagged,18,'.'))); ?></p>
                                    <p>(<?php echo e($totalimages); ?>) <?php if($optfile!=NULL): ?> <?php echo e($optfile); ?> Files <?php else: ?> Images <?php endif; ?></p>
                                 </div>
                              </a>
                        </li>
                        <?php 
                           } 
                        ?>
                  <li class="slide">
                     <a class="slink viewmore" href="<?php echo e(($catlink)); ?>">
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
               <?php endif; ?>


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

               <?php if(HH::likecheck($title, $description) == false): ?>
               
                     <div class="cent adbox">
                        <?php echo $__env->make('ads.mobileads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                     </div>
                  
               <?php endif; ?>

               <?php if( $images->count() != 0 ): ?>
                  <div class="card-header">
                     <h4>Similar <?php echo e($response->subcat->name); ?></h4>
                  </div>
                  <div class="flex-images imagesFlex2">
                     <?php echo $__env->make('includes.imageslazy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  </div>
               <?php endif; ?>
            </div>
         </div>

      </section>
   </div>
   
   <?php if(HH::likecheck($title, $description) == false): ?>
      <?php echo $__env->make('ads.stickyads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php endif; ?>
   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('SchemaJson'); ?>
<script type="application/ld+json">
   [{"@context":"https://schema.org","@type": "BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "<?php echo e(url('/')); ?>"},{"@type":"ListItem","position": 2,"name":"<?php if($response->subgroup!=''): ?><?php echo e($subcatname); ?> <?php else: ?> <?php echo e(($catname)); ?><?php endif; ?>","item":"<?php if($response->subgroup!=''): ?><?php echo e(($subcatlink)); ?> <?php else: ?> <?php echo e(($catlink)); ?> <?php endif; ?>"},{"@type":"ListItem","position":3,"name":"<?php if($response->subgroup!=''): ?><?php echo e(($response->subgroup)); ?> <?php else: ?><?php echo e(($subcatname)); ?><?php endif; ?>","item":"<?php if($response->subgroup!=''): ?><?php echo e(url('/')); ?>/g/<?php echo e(Str::slug($response->subgroup)); ?><?php else: ?> <?php echo e(($subcatlink)); ?> <?php endif; ?>"},{"@type":"ListItem","position":4,"name":"<?php echo e($title); ?>"}]},{"@context":"http://schema.org","@type":"Organization","name":"<?php echo e($settings->sitename); ?>","url":"<?php echo e(url('/')); ?>","logo":"<?php echo e(asset('public/img/apple')); ?>/apple-touch-icon.png","sameAs":["https://www.facebook.com/<?php echo e($settings->facebook); ?>","https://twitter.com/<?php echo e($settings->twitter); ?>","https://instagram.com/<?php echo e($settings->instagram); ?>"]},{"@context":"http://schema.org","@type":"ImageObject","name":"<?php echo e($title); ?>","description":"<?php echo e($description); ?>","keywords":"<?php echo e($keywords); ?>","caption":"<?php echo e($imgtitletrue); ?>","contentUrl":"<?php echo e($imglarge); ?>","image":"<?php echo e($contenturl); ?>","url":"<?php echo e($contenturl); ?>",<?php if(isset($response->opt_file_source) && $response->opt_file_source != ""): ?>"fileFormat":"image/<?php echo e($response->extension); ?>",<?php endif; ?> "thumbnail":"<?php echo e($thumbimage); ?>","sourceOrganization":"<?php echo e($settings->sitename); ?>" }]
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/images/show.blade.php ENDPATH**/ ?>