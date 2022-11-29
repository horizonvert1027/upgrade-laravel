

<?php $__env->startSection('OwnCss'); ?>
<link href="<?php echo e(asset('/public/css/jquery-ui-1.8.2.custom.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="preload" href="/public/jscss/catcssobs.css?14" as="style">
    <link rel="stylesheet" href="/public/jscss/catcssobs.css?14">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
   <section>
    <div class="col-md-12">
        <div class="ibox bsh mt20 mb35">

        <h1><?php echo e($category->name); ?></h1>
        
        <?php if( Auth::user() && Auth::user()->role == 'admin' ): ?>
            <a class="aligncenter nvbtn" href="<?php echo e(url('panel/admin/categories/edit')); ?>/<?php echo e($category->id); ?>/<?php echo e($category->main_cat_id); ?>">Edit
            </a>
        <?php endif; ?>

        <ol class="breadcrumb">              
            <li>
                <a href="<?php echo e(url('/')); ?>" aria-label="home" title="home">
                    <span class="ichome"></span>
                </a>
            </li>

            <li>
                <a href="<?php echo e(url('type')); ?>/<?php echo e($main_categories[0]->slug); ?>" >
                    <?php echo e($main_categories[0]->name); ?>

                </a>
            </li>

            <li>
                <a href="<?php echo e(url('c')); ?>/<?php echo e($category->slug); ?>" >
                  <?php echo e($category->name); ?>

                </a>
            </li>                            
        </ol>
     
    <div class="searchsubcats">

        <div class="inner">
            <h3>Search <?php echo e($category->name); ?></h3>
        </div>

        <span class="text-black">
            <input class="subcatinput" type="text" name="subcategory" placeholder="Search <?php echo e($category->name); ?>...">
        </span>
        
        <span class="linksblock"></span>

    </div>
        
        <div id="categoryFlex">
            <?php
            $allSubcategories = App\subcategories::where('categories_id',$category->id)->where('mode','on')->orderBy('name')->paginate($sublimit)->onEachSide(1);
            ?>
            <?php $__currentLoopData = $allSubcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php 
             $imagescount = HH::getSubTotalImages($sub->id);
             if( $imagescount == 0 ){
                continue;
             }
             if( $sub->sthumbnail == '' ) {
                $_image = 'default.jpg';
             } else {
                $_image = $sub->sthumbnail;
             } 
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 row-margin-20">
                <a href="<?php echo e(url('s')); ?>/<?php echo e(("$sub->slug")); ?>">
                    <img height="350" width="439" class="custom-rounded lazy" src="/public/img-subcategory/default.jpg" data-original="<?php echo e(config('app.filesurl')); ?><?php echo e((config('path.img-subcategory').$_image)); ?>" alt="<?php echo e($sub->name); ?>">
                </a>
                <h3><a class="tab-list" href="<?php echo e(url('s')); ?>/<?php echo e(("$sub->slug")); ?>"><?php echo e(Str::limit($sub->name, 18, '')); ?></a></h3>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if( $allSubcategories->count() == $sublimit ){ $page=1; ?>
            
                <div class="catpagination">
                <a href="<?php echo e(url('ajax/subcategories')); ?>?page=<?php echo e($page+1); ?>">Show More</a>
            </div>
            <?php } ?>
        </div>

            <?php if(HH::likecheck($title, $description) == false): ?>
            <div class="cent adbox strip">
               <?php echo $__env->make('ads.responsiveads', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <?php endif; ?>

                <div class="flex-images imagesFlex2 dataResult">
                     <?php if( $category->cpdescr != '' ) { $url = url('/'); $category->cpdescr=preg_replace("/#([A-Za-z0-9\_\-\.]*)/", "<a target='_blank' href='".$url."/search?q=$1'>#$1</a>", $category->cpdescr); } ?> <?php $dstr = $category->cpdescr; $topdescr = $moredescr = ""; if( strlen($dstr) > 500 ) { $pindex = strpos($dstr, "</p>"); $topdescr = substr($dstr, 0, $pindex+4); $topdescr .= '<a href="javascript:void(0);" class="read-more">read more...</a>'; $moredescr = substr($dstr, $pindex+4); $topdescr .= '<a class="more-text">'.$moredescr.'</a>'; } else { $topdescr = $dstr; } ?>
                    <div class="description show-read-more"><?php echo $topdescr; ?></div>
                     <?php echo $__env->make('includes.mob-sim-images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="container-paginator">
                    <?php echo e($images->links()); ?>

                    </div>
                </div>
 </div>
</div>
</section>
</div>

<?php $__env->stopSection(); ?>

        <?php $__env->startSection('SchemaJson'); ?>
         <script type="application/ld+json">[{"@context":"http://schema.org","@type":"WebSite","name":"⚡<?php echo e(HH::counts($images->total())); ?>+ Best <?php echo e($subcattitle); ?> <?php echo e(HH::titleahead($titleahead)); ?>","description":"<?php echo e(HH::removetags($categorydescr)); ?>","keywords":"<?php echo e($category->keyword); ?>","url":"<?php echo e(url('/')); ?>/c/<?php echo e($category->slug.''); ?>","potentialAction":{"@type":"SearchAction","target": "<?php echo e(url('/')); ?>/search?q={search_term_string}","query-input": "required name=search_term_string"}},{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement": [{"@type":"ListItem","position": 1,"name": "Home","item": "<?php echo e(url('/')); ?>"},{"@type":"ListItem","position": 2,"name": "<?php echo e($main_categories[0]->name); ?>","item": "<?php echo e(url('type')); ?>/<?php echo e($main_categories[0]->slug); ?>"},{"@type": "ListItem","position": 3,"name": "<?php echo e($category->name); ?>"}]},<?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if($i->opt_file_source != ""){$slugUrl1  = 'file';}else {$slugUrl1  = 'photo'; }?>
         {"@context":"http://schema.org","@type": "ImageObject","name": "<?php echo e($i->title); ?>","caption":"<?php echo e($i->title); ?>","keywords": "<?php echo e($i->metakeywords); ?>","description":"<?php echo e($i->title); ?>","image":"<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>","url": "<?php echo e(url('/')); ?>/<?php echo e(($slugUrl1)); ?>/<?php echo e(($i->id).'/'.Str::slug($i->title)); ?>","contentUrl":"<?php echo e(config('app.filesurl').('uploads/large/').($i->large)); ?>","thumbnail": "<?php echo e(config('app.filesurl').('uploads/preview/').($i->preview)); ?>","fileFormat": "image/<?php echo e($i->extension); ?>","sourceOrganization":"<?php echo e($settings->sitename); ?>"}<?php if($k != (count($images)-1)): ?>,<?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>]
        </script>
        <?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(asset('/public/js/auto-complete.js')); ?>"></script>
    <script src="<?php echo e(asset('/public/admin/js/jquery-ui.min.js')); ?>?2" type="text/javascript"></script>
    <script>

        <?php
        $arr = array();
        $subMap = array();
        $allsubcategories = \App\subcategories::all();
        foreach ($allsubcategories as $key => $subcat)
        {
            $arr[] = $subcat->name;
            $subMap[ $subcat->slug ] = $subcat->categories_id."|".$subcat->name;
        }
        ?>

        var allsubs = '<?php echo addslashes(json_encode($arr));?>';
        allsubs = JSON.parse(allsubs);
        var allsubsmap = '<?php echo addslashes(json_encode($subMap));?>';
        allsubsmap = JSON.parse(allsubsmap);

        $("input[name='subcategory']").autocomplete({
            source: allsubs,
            minLength: 2,
            open: function(){ $(".linksblock").html(''); },
            select: function( event, ui )
            {
                var category = "";
                var subcategory = "";
                $(".linksblock").html('');
                var sub = ui.item.value.trim();
                $("input[name='subcategory']").val(sub);
                $.each(allsubsmap, function(i, obj)
                {
                    console.log()
                    var d = obj.split("|");
                    if( d[1] == sub )
                    {
                        subcategory = i;
                        category = d[0];
                    }
                });
                var baseurl = "<?php echo e(url('/')); ?>";
             
                var href = baseurl+'/s/'+subcategory;
                $(".linksblock").append("<a id='addsubcat' class='nvbtn' href='"+href+"'>View Images</a>");
            }
        });
    </script>
    <script src="<?php echo e(asset('public/js/lazyload.min.js')); ?>"></script>
    <script>

    


        var ajaxlink = '<?php echo e(url("/")); ?>/ajax/category?slug=<?php echo e($category->slug); ?>&page=';
document.addEventListener("DOMContentLoaded", yall), 

$(document).ready(function() {
    var a = 0;
    $("#categoryFlex img.lazy").each(function() {
        var t = $(this),
            e = new Image;
        e.src = $(this).attr("data-original"), e.addEventListener("load", function() {
            t.attr("src", this.src)
        }, !1)
    })
});
function loadSimilarImages(page) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '<?php echo e(url("/")); ?>/ajax/subcategories?category_id=<?php echo e($category->id); ?>&limit=<?php echo e($sublimit); ?>&page=' + page
            }).done(function (data) {
                if (data) {
                    $('#categoryFlex .catpagination').remove();
                    $('#categoryFlex').append(data);
                } else {
                    sweetAlert("<?php echo e(trans('misc.error_oops')); ?>", "<?php echo e(trans('misc.error')); ?>", "error");
                }
            });
        }

        $(document).on('click', '.catpagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#categoryFlex .catpagination').html('<div class="spinner"></div>');
            loadSimilarImages(page);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/category.blade.php ENDPATH**/ ?>