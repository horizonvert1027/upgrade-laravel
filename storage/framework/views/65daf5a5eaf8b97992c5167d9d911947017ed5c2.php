<?php $__env->startSection('css'); ?>
    <style>
        input[type='file']{
            opacity: 1;
            font-size: 14px;
            position: relative;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           <?php echo e(trans('admin.admin')); ?> <i class="fa fa-angle-right margin-separator"></i> Main Type
          </h1>

        </section>

        <!-- Main content -->
        <section class="content">






          <div class="row">
            <div class="col-md-6">
              <div class="box">
				  
				  
                <div class="box-body table-responsive no-padding">
					<?php
use App\subcategories;
$latestsubcats = subcategories::where([['mode', 'on']])->orderBy('created_date', 'DESC')->take(50)->get();
?>
        <?php if( count($latestsubcats) != 0 ): ?>
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php $__currentLoopData = $latestsubcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <li class="item">
                  <div class="product-img">
                    <img height="50" width="50" src="<?php echo e(config('app.filesurl').(config('path.subcat_preview').$subcat->preview)); ?>" style="height: auto !important;" />
                  </div>
                  <div class="product-info">
                    <a href="<?php echo e(url('panel/admin/subcatimages/')); ?>/<?php echo e($subcat->id); ?>" target="_blank" class="product-title"><?php echo e(Str::limit($subcat->name,18,'.')); ?>

                      </a>
                      <span class="label label pull-right">
                        <a target="_blank" href="<?php echo e(url('panel/admin/subcategories/edit/'.$subcat->id."/".$subcat->categories_id)); ?>"><b>Edit</b></a>
                      </span>
                    
                    <span class="product-description">
                      <?php echo e(trans('misc.by')); ?> <?php echo e('@'.HH::getusername($subcat->created_by)); ?> / <?php echo e(App\Helper::formatDate($subcat->created_date)); ?>

                    </span>
                  </div>
                  </li><!-- /.item -->
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
               
                </div><!-- /.box-body -->
                <?php else: ?>
                <div class="box-body">
                  <h5><?php echo e(trans('admin.no_result')); ?></h5>
            </div><!-- /.box-body -->
        <?php endif; ?>
   
                </div><!-- /.box-body -->
				  
              </div><!-- /.box -->
            </div>
          </div>

          <!-- Your Page Content Here -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">

  $(document).ready(function()
  {
    $(".titleahead").click(function()
    {
      $(this).removeClass("readme").addClass("editme");
      $(this).attr("readonly", false);
    });

    $(".titleahead").blur(function()
    {
      $(this).removeClass("editme").addClass("readme");
      $(this).attr("readonly", true);
      var id = "main_category"+$(this).data("id");
      var titleahead = $(this).val();
      var csrf = "<?php echo e(csrf_token()); ?>";
      $.post("<?php echo e(url('panel/admin/maincategories/updateTitleahead')); ?>",
      {
        _token: csrf,
        id: id,
        titleahead: titleahead
      },
      function(data, status)
      {
        var message = '';
        var resclass = '';
          if( data )
          {
            message = 'Main Category '+id+' Titleahead updated successful';
            resclass = 'alert-success';
          } else {
            message = 'Main Category '+id+' Titleahead updated failed';
            resclass = 'alert-danger';
          }

          var html = "<div id='ajaxResponse' class='alert "+resclass+"'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><i class='fa fa-check margin-separator'></i>"+message+"</div>";
          $("section.content").prepend(html);
          setTimeout(function(){
            $("#ajaxResponse").remove();
          }, 2000);
      });
    });

  });

  function ConfirmDelete()
  {
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
      return false;
  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/admin/recentsubcategories.blade.php ENDPATH**/ ?>