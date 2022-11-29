<?php
// Total
use App\subcategories;
$total_images = App\Models\Images::count();
$images       = App\Models\Images::orderBy('id','DESC')->take(10)->get();
$users        = App\Models\User::orderBy('id','DESC')->take(10)->get();
$latestsubcats = subcategories::where([['mode', 'on']])->orderBy('created_date', 'DESC')->take(10)->get();

?>

<?php $__env->startSection('css'); ?>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php echo e(\App\Helper::formatNumber( \App\Models\User::count() )); ?></h3>
            <p><?php echo e(trans('misc.members')); ?></p>
          </div>
          <div class="icon">
            <i class="ion ion-ios-people"></i>
          </div>
          <a href="<?php echo e(url('panel/admin/members')); ?>" class="small-box-footer"><?php echo e(trans('misc.view_more')); ?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo e(\App\Helper::formatNumber( $total_images )); ?></h3>
              <p><?php echo e(trans_choice('misc.images_plural', $total_images)); ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-images"></i>
            </div>
            <a href="<?php echo e(url('panel/admin/images')); ?>" class="small-box-footer"><?php echo e(trans('misc.view_more')); ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>SubCats</h3>
              <p>Edit, add or view</p>
            </div>
            <div class="icon">
              <i class="ion-android-apps"></i>
            </div>
            <span class="text-black">
              <input class="searchwala" type="text" name="subcategory" placeholder="Search Subcategory...">
            </span>
            <span class="linksblock">
            </span>
          </div>
          </div><!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
              <div class="inner">
                <h3>Cats</h3>
                <p>Add or view</p>
              </div>
              <div class="icon">
                <i class="ion-android-list"></i>
              </div>
              <span class="description-text text-black"><select class="searchwala" id="maincat">
                <option value="">-Select-</option>
                <?php $__currentLoopData = $main_categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select></span>
            </div>
            </div><!-- ./col -->
          </div>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>Review</h3>
                  <p>Pending Contents</p>
                </div>
                <div class="icon">
                  <i class="ion-clipboard"></i>
                </div>
                <a href="<?php echo e(url('panel/admin/images?sort=pending')); ?>" class="small-box-footer">Review Now <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              </div><!-- ./col -->
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>iAll</h3>
                    <p>All iImages</p>
                  </div>
                  <div class="icon">
                    <i class="ion-social-instagram-outline"></i>
                  </div>
                  <a href="<?php echo e(url('InstaCronAll')); ?>" target="_blank" class="small-box-footer">Start Now <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>iLatest</h3>
                    <p>Latest 5 images</p>
                  </div>
                  <div class="icon">
                    <i class="ion-social-instagram"></i>
                  </div>
                  <a href="<?php echo e(url('InstaCron')); ?>" target="_blank" class="small-box-footer">Start Now <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>Scrape</h3>
                    <p>Scrape images</p>
                  </div>
                  <div class="icon">
                    <i class="ion-arrow-graph-down-right"></i>
                  </div>
                  <a href="<?php echo e(url('WebScrapper')); ?>" target="_blank" class="small-box-footer">Start Now <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
<div class="row">
              <div class="col-md-3">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"><?php echo e(trans('admin.latest_images')); ?></h3>
                    <div class="box-tools pull-right">
                    </div>
                    </div><!-- /.box-header -->
                    <?php if( $total_images != 0 ): ?>
                    <div class="box-body">
                      <ul class="products-list product-list-in-box">
                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        switch (  $image->status ) {
                        case 'active':
                        $color_status = 'success';
                        $txt_status = trans('misc.active');
                        break;
                        case 'pending':
                        $color_status = 'warning';
                        $txt_status = trans('misc.pending');
                        break;
                        }
                        ?>
                        <li class="item">
                          <div class="product-img">
                            <img height="50" width="50" src="<?php echo e(config('app.filesurl').(config('path.thumbnail').$image->thumbnail)); ?>" style="height: auto !important;" />
                          </div>
                          <div class="product-info">
                            <a href="<?php echo e(url('photo')); ?>/<?php echo e($image->id); ?>" target="_blank" class="product-title"><?php echo e(Str::limit($image->title, 18, '.')); ?>

                              <span class="label label-<?php echo e($color_status); ?> pull-right"><?php echo e($txt_status); ?></span>
                            </a>
                            <span class="product-description">
                              <?php echo e(trans('misc.by')); ?> <?php echo e('@'.$image->user()->username); ?> / <?php echo e(App\Helper::formatDate($image->date)); ?>

                            </span>
                          </div>
                          </li><!-- /.item -->
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <a class="box-footer text-center" href="<?php echo e(url('panel/admin/images')); ?>" class="uppercase"><?php echo e(trans('admin.view_all_images')); ?></a>
                        </div><!-- /.box-body -->
                        <?php else: ?>
                        <div class="box-body">
                          <h5><?php echo e(trans('admin.no_result')); ?></h5>
                          </div><!-- /.box-body -->
                          <?php endif; ?>
                        </div>
                      </div>

              <div class="col-md-3">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Recent Subcategories</h3>
                    <div class="box-tools pull-right">
                    </div>
                    </div><!-- /.box-header -->


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
                              <span class="label label-<?php echo e($color_status); ?> pull-right">
                                <a target="_blank" href="<?php echo e(url('panel/admin/subcategories/edit/'.$subcat->id."/".$subcat->categories_id)); ?>"><b>Edit</b></a>
                              </span>
                            
                            <span class="product-description">
                              <?php echo e(trans('misc.by')); ?> <?php echo e('@'.HH::getusername($subcat->created_by)); ?> / <?php echo e(App\Helper::formatDate($subcat->created_date)); ?>

                            </span>
                          </div>
                          </li><!-- /.item -->
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <a class="box-footer text-center" href="<?php echo e(url('panel/admin/recentsubcategories')); ?>" class="uppercase">View All Recents</a>
                        </div><!-- /.box-body -->
                        <?php else: ?>
                        <div class="box-body">
                          <h5><?php echo e(trans('admin.no_result')); ?></h5>
                          </div><!-- /.box-body -->
                          <?php endif; ?>
                        </div>
  </div>
                      <div class="col-md-6">
                        <!-- USERS LIST -->
                        <div class="box box-danger">
                          <div class="box-header with-border">
                            <h3 class="box-title">Quick at a go</h3>
                            <div class="box-tools pull-right">
                            </div>
                            </div><!-- /.box-header -->
                            <div class="box-body commands">
                              <a href="<?php echo e(url('panel/admin/optimizecache')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Optimize:clear</a>

                              <a href="<?php echo e(url('panel/admin/keygenearate')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-undo"> </i> Key Genearate</a>

                              <a href="<?php echo e(url('panel/admin/removesessions')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Remove Sessions</a>

                              <a href="<?php echo e(url('panel/admin/alllogclear')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"> <i class="fa fa-trash"> </i> Clear all Logs</a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclear')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Purge all Cache</a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclearsubcat')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"> <i class="fa fa-trash"> </i> Purge Subcat Cache</a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclearsubgroup')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"> <i class="fa fa-trash"> </i> Purge Subgroup Cache</a>


                              <a href="<?php echo e(url('panel/admin/pagecacheclearhome')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Purge Home Cache</a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclearlatest')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Purge latest Cache </a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclearimages')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Purge Images Cache</a>

                              <a href="<?php echo e(url('panel/admin/logclear')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Remove Laravel Log</a>

                              <a href="<?php echo e(url('panel/admin/pagecacheclearcat')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"><i class="fa fa-trash"> </i> Purge Cat Cache</a>


                              <a href="<?php echo e(url('log-viewer/logs')); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,resizable=yes,dependent=yes,fullscreen=yes'); return false;" class="small-box-footer artisanbtn"> <i class="fa fa-file-text"> </i> View Logs</a> 


                              <a href="/upload" target="popup" onclick="window.open('/upload','popup', 'resizable=no,fullscreen,width='+screen.availWidth+', height='+screen.availHeight); return false" class="small-box-footer artisanbtn"><i class="fa fa-upload"> </i> Upload</i></a>

                              </div><!-- /.box-body -->
                              </div><!--/.box -->
                            </div>
                            <div class="col-md-6">
                              <!-- USERS LIST -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Subcats with 'All InstaCron' on</h3>
    </div>
    <div class="box-body">
      <ul class="products-list product-list-in-box">
        <?php foreach ($allinstasubs as $key => $allsub) {
        $editlink = url('panel/admin/subcategories/edit/');
        $editlink .= "/".$allsub->id."/".$allsub->categories_id;
        $totalcount = App\Helper::getSubTotalImages($allsub->id);
        ?>
        <li class="item">
          <div class="product-img">
            <i class="fa fa-file"></i>
          </div>
          <div class="product-info">
            <a href="<?php echo e($editlink); ?>" target="_blank" class="product-title"><?php echo e($allsub->name); ?>

            </a>
            <span class="label pull-right">
              <a href="<?php echo e(url('s').'/'.$allsub->slug); ?>">View</a>
            </span>
            <span class="product-description">
              <?php echo e($totalcount); ?> Total photos
            </span>
          </div>
        </li>
          <?php } ?>
      </ul>
          <div class="box-footer text-center">
            <a href="<?php echo e(url('panel/admin/subcategories/view/31?sort=allinsta')); ?>" class="uppercase">View Subcats sorted by (AllInsta)
            </a>
          </div><!-- /.box-footer -->
    </div><!-- /.box-body -->
  </div>
</div><!-- ./row -->

<div class="row">
  
</div>
                                          <!-- Your Page Content Here -->
                                          </section><!-- /.content -->
                                          </div><!-- /.content-wrapper -->
                                          <?php $__env->stopSection(); ?>
                                          <?php $__env->startSection('javascript'); ?>
                                          <script type="text/javascript">
                                          $(document).ready(function()
                                          {
                                          var baseurl = "<?php echo e(url('panel/admin')); ?>";
                                          console.log(baseurl);
                                          <?php
                                          $arr = array();
                                          $subMap = array();
                                          foreach ($allsubcategories as $key => $subcat)
                                          {
                                          $arr[] = $subcat->name;
                                          $subMap[ $subcat->id ] = $subcat->categories_id."|".$subcat->name;
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
                                          console.log(i);
                                          console.log(obj);
                                          var d = obj.split("|");
                                          if( d[1] == sub )
                                          {
                                          subcategory = i;
                                          category = d[0];
                                          }
                                          });
                                          var href = baseurl+'/subcategories/add/'+category;
                                          $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Add Subcategory</a>");
                                          var href = baseurl+'/subcategories/edit/'+subcategory+"/"+category;
                                          $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Edit Subcategory</a>");
                                          var href = baseurl+'/subcatimages/'+subcategory;
                                          $(".linksblock").append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Subcategory Images</a>");
                                          }
                                          });
                                          $("#maincat").change(function()
                                          {
                                          var ele = $(this);
                                          ele.parent().find("#category").eq(0).remove();
                                          ele.parent().find("#addsubcat").eq(0).remove();
                                          var category = $(this).val();
                                          var csrf = "<?php echo e(csrf_token()); ?>";
                                          $.get("<?php echo e(url('getcategories/')); ?>/"+category,
                                          function(data, status)
                                          {
                                          ele.parent().append("<select id='category' name='category' style='width:-webkit-fill-available;margin:5px;padding:6px 20px 6px 8px;'><option>--Categories--</option>"+data+"</select>");
                                          setTimeout(function(){
                                          $("#category").change(function()
                                          {
                                          var ele = $(this);
                                          var category = $(this).val();
                                          var href = baseurl+'/subcategories/add/'+category;
                                          ele.parent().append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Add Subcategory</a>");
                                          var href = baseurl+'/subcategories/view/'+category;
                                          ele.parent().append("<a id='addsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>View Category</a>");
                                          });
                                          }, 100);
                                          });
                                          });
                                          $("#maincat1").change(function()
                                          {
                                          var ele = $(this);
                                          ele.parent().find("#category1").eq(0).remove();
                                          ele.parent().find("#subcategory1").eq(0).remove();
                                          ele.parent().find("#editsubcat").eq(0).remove();
                                          ele.parent().find("#subcatimages").eq(0).remove();
                                          var category = $(this).val();
                                          var csrf = "<?php echo e(csrf_token()); ?>";
                                          $.get("<?php echo e(url('getcategories/')); ?>/"+category,
                                          function(data, status)
                                          {
                                          ele.parent().append("<select id='category1' name='category1' style='width:250px;margin:5px;padding:6px 20px 6px 8px;'><option>--Categories--</option>"+data+"</select>");
                                          setTimeout(function(){
                                          $("#category1").change(function()
                                          {
                                          var ele = $(this);
                                          ele.parent().find("#subcategory1").eq(0).remove();
                                          ele.parent().find("#editsubcat").eq(0).remove();
                                          ele.parent().find("#subcatimages").eq(0).remove();
                                          var category = $(this).val();
                                          var csrf = "<?php echo e(csrf_token()); ?>";
                                          $.get("<?php echo e(url('getsubcat/')); ?>/"+category,
                                          function(data, status)
                                          {
                                          ele.parent().append("<select style='width:250px;margin:5px;padding:6px 20px 6px 8px;' id='subcategory1'><option>--Sub Categories--</option>"+data+"</select>");
                                          setTimeout(function(){
                                          $("#subcategory1").change(function()
                                          {
                                          ele.parent().find("#editsubcat").eq(0).remove();
                                          ele.parent().find("#subcatimages").eq(0).remove();
                                          var category = $(this).parent().find("#category1").eq(0).val();
                                          var subcategory = $(this).val();
                                          if( subcategory == "" )
                                          {
                                          return false;
                                          }
                                          var href = baseurl+'/subcategories/edit/'+subcategory+'/'+category;
                                          ele.parent().append("<a id='editsubcat' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Edit Subcategory</a>");
                                          var href = baseurl+'/subcatimages/'+subcategory;
                                          ele.parent().append("<a id='subcatimages' style='padding: 4px;display: block;margin: 11px;font-weight: bold;border: 1px solid white;text-align: center;border-radius: 3px;background: #0c576e;color: white;' href='"+href+"'>Subcategory Images</a>");
                                          });
                                          });
                                          });
                                          });
                                          }, 100);
                                          });
                                          });
                                          });
                                          </script>
                                          <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>