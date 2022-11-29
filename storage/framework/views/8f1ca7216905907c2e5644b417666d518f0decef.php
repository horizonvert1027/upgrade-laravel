
<style>
.pagee{
    margin: 5% 2%;
}
</style>
<?php $__env->startSection('content'); ?> 
    <div class="container">
        <section>
            <div class="col-md-12">
                <div class="ibox mb35 mt35">
                        <div class="pagee">
                            <h1 style="font-size: 35px; margin-bottom: 5px"><?php echo e($response->title); ?></h1>
                         <?php echo html_entity_decode($response->content) ?>
                        </div>
                             
                </div>
            </div>
        </section>
   </div>               
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.multi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/default/page.blade.php ENDPATH**/ ?>