<?php
?>
 <?php $__env->startSection('content'); ?>
    <div class="container">
   <section>
      <div class="col-md-12">
         <div class="ibox bsh mt20 mt35">

           
            <?php if( Auth::user() && Auth::user()->role == 'admin' ): ?>
            <div class="cent aligncenter">
               <a class="nvbtn" href="<?php echo e(url('panel/admin/subcategories/edit')); ?>/<?php echo e($subcategory->id); ?>/<?php echo e($subcategory->categories_id); ?>">Edit</a>
            </div>
            <?php endif; ?>
            <h1><?php echo e(HH::counts($images->total())); ?>+ <?php echo e($subcategoryname); ?> <?php echo e(HH::titleahead($titleahead)); ?></h1>
            <ol class="breadcrumb">
               <li>
                   <a href="<?php echo e(url('/')); ?>" aria-label="home" title="home">
                       <span class="ichome"></span>
                   </a>
               </li>
               <li>
                  <a href="<?php echo e($maincatlink); ?>"> <?php echo e($maincatname); ?>

                  </a>
               </li>
               <li>
                  <a href="<?php echo e($categorylink); ?>"><?php echo e($categoryname); ?>

                  </a>
               </li>
               <li>
                  <a href="<?php echo e($subcategorylink); ?>" title="<?php echo e($subcategoryname); ?>"><?php if(HH::isMobile()): ?>  <?php echo e(Str::limit($subcategoryname, 18, '.')); ?> <?php else: ?> <?php echo e(($subcategoryname)); ?> <?php endif; ?>
                  </a>
               </li>
            </ol>
<div class="projects-catalog">
        <div class="catalog-cover">
            <i class="left-button"></i>
            <ul class="sliderWrapper1 sliderscroll">
                <?php if( $tags !=""): ?>
                    <?php for( $i = 0; $i
                        < $count_tags; ++$i ): ?> <?php $first=HH::getFristImageSubGroup($tags[$i]); ?>

                        <?php if( $first !="" && $tags[$i] !=""): ?> 
                     <li class="slide">
                        <a class="slink" href="<?php echo e(url('g',Str::slug(($tags[$i])))); ?>">
                           <img class="img-circle tags" height="50" width="50" src="<?php echo e(config('app.filesurl').('uploads/thumbnail')); ?>/<?php echo e(($first)); ?>" alt="<?php echo e($tags[$i]); ?>">
                           <div class="sidekro tags">
                           <?php echo e(HH::subgroupneat(HH::specialmatchedword($tags[$i], $subcategoryname))); ?></div>
                        </a>
                     </li>

                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?> 
            </ul>
            <i class="right-button"></i> 
    </div>
</div>
           <?php 
            if( $subcategory->spdescr != '' ) { 
               $url = url('/'); 
               $subcategory->spdescr=preg_replace("/(#([\w\-.]*)+ )+/","<a href='".$contenturl."'>$subcategoryname </a>", $subcategory->spdescr); }

            ?>

      <?php 
            $dstr = $subcategory->spdescr;
            $topdescr = $moredescr = "";

            if( strlen($dstr) > 500 ) { 
               $pindex = strpos($dstr, "</p>"); 
               $topdescr = substr($dstr, 0, $pindex+4); 
               $topdescr .= '<a href="javascript:void(0);" class="read-more">read more...</a>';
               $moredescr = substr($dstr, $pindex+4);
               $topdescr .= '<a class="more-text">'.$moredescr.'</a>';
            }
            else { 
               $topdescr = $dstr; 
            } 
      ?>

            <div class="show-read-more"><?php echo $topdescr; ?></div>

            

            <?php if(HH::likecheck(HH::combinAllTitles($images), $description) == false): ?>
            <div class="cent adbox strip">
               <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <?php endif; ?>
            <div class="flex-images imagesFlex2 dataResult">
                <?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
               <div class="container-paginator"> <?php echo e($images->links()); ?> </div>
            </div>



         </div>
      </div>
   </section>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('SchemaJson'); ?>
<script type="application/ld+json">
      [
      {
         "@context": "http://schema.org",
         "@type": "WebSite",
         "name": "<?php echo e($title); ?>",
         "description": "<?php echo e($description); ?>",
         "keywords": "<?php echo e($keywords); ?>",
         "url": "<?php echo e(url('')); ?>",
         "potentialAction": 
         {
            "@type": "SearchAction",
            "target":"<?php echo e(url('/')); ?>/search?q={search_term_string}",
            "query-input": "required name=search_term_string"}},
         {
            "@context":"https://schema.org",
            "@type":"BreadcrumbList",
            "itemListElement": 
            [
            {
               "@type": "ListItem",
               "position": 1,
               "name": "Home",
               "item": "<?php echo e(url('/')); ?>"},
               {
                  "@type": "ListItem",
                  "position": 2,
                  "name": "<?php echo e($categoryname); ?>",
                  "item": "<?php echo e($categorylink); ?>"},
                  {
                     "@type":"ListItem",
                     "position": 3,
                     "name": "<?php echo e($subcategoryname); ?>",
                     "item": "<?php echo e($subcategorylink); ?>"
                  }

            ]
         },
                  

                  <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($i->opt_file_source != ""){$slugUrl1  = 'file';}
                        else {$slugUrl1  = 'photo';}
                     ?>
                     {
                        "@context": "http://schema.org",
                        "@type": "ImageObject",
                        "name": "<?php echo e($i->title); ?>",
                        "caption": "<?php echo e($i->title); ?>",
                        "keywords": "<?php echo e($i->metakeywords); ?>",
                        "description": "<?php echo e(HH::removetags($description)); ?>",
                        "image":"<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>",
                        "url":"<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>",
                        "contentUrl":"<?php echo e(config('app.filesurl').('uploads/large/').($i->large)); ?>",
                        "thumbnail": "<?php echo e(config('app.filesurl').('uploads/preview/').($i->preview)); ?>",
                        "fileFormat":"image/<?php echo e($i->extension); ?>",
                        "sourceOrganization":"<?php echo e($settings->sitename); ?>"
                     }
                        <?php if($k != (count($images) - 1)): ?>,
                        <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               ]
   </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
   <script>
      var ajaxlink = '<?php echo e(url("/")); ?>/ajax/category?slug=<?php echo e($subcategory->slug); ?>&page=';
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/subcategory.blade.php ENDPATH**/ ?>