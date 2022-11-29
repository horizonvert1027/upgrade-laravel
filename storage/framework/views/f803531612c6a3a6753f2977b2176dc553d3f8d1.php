<?php

$keywords = $titleahead = $preview = $thumbimage = '';
if($images->total())
{
    $titleahead = $images[0]->category->main_cat_id;
    $keywords = $images[0]->metakeywords;
    $preview = $images[0]->preview;
}
if(isset($titleahead) && $titleahead == 0)
{$aageka  = 'Full HD Backgrounds';} 
elseif(isset( $titleahead) && $titleahead == 1)
{$aageka  = 'Full HD Transparent Images';}
elseif(isset( $titleahead) && $titleahead == 2)
{$aageka  = 'Full HD Wallpapers';}
elseif(isset( $titleahead) && $titleahead == 3)
{$aageka  = 'Presets & Brushes';}
elseif(isset( $titleahead) && $titleahead == 4)
{$aageka  = 'Graphics Templates';}
else {$aageka = 'HD Images | Photo';}
;

if(isset($img->opt_file_source) && $img->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}

$title = ucwords($q). ' ' . $aageka;
$description = 'Get to download for free' . ucwords($q) . ' ' . $aageka . 'We have collected a number' . ucwords($q) . 'for you. Explore and download the one which best suit for you.';
$thumbimage = config('app.filesurl').'uploads/preview/' . $preview;
$sitemap = '';
$contenturl = url('/').'/search?q='.$q;
$multilangLink = config('app.topsiteurl').'/search?q='.$q;
$rssfeed = url('/').'/rssfeeds';

?>


    <link rel="preload" href="/public/jscss/searchcssobs.css?122" as="style">
    <link rel="stylesheet" href="/public/jscss/searchcssobs.css?122">
    <link rel="preload" href="/public/jscss/myjs-s.js?122" as="script">
<?php $__env->startSection('content'); ?>
<script async src="https://cse.google.com/cse.js?cx=008157868660029855624:nyz53n2bw9b">
</script>
<div class="container">
    <section>
        <div class="search-noresults">
            <h2 class="watext"> Sorry, but no results!</h2>
            <p>We can add "<b style="font-weight: 700"><?php echo e(trim($q)); ?></b>", if You request now via WhatsApp.</p>
            <a class="btn btn-primary nvbtn" href="https://wa.me/7860737062?text=Hi">WhatsApp Us
            </a>
        </div>  

        <div class="gcse-search"> 
        </div> 
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script async src="/public/jscss/myjs-s.js?122"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/searcher.blade.php ENDPATH**/ ?>