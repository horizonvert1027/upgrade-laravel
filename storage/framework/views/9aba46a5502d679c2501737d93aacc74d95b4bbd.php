<?php if( $settings->google_ads_index == 'on' && $settings->stickyadsonoff == 'on' && HH::likecheck($title) == false): ?>
	<div class='stickyads'>
		<input id="toggle" type="checkbox">
		<label for="toggle" class="stickyadsClose"></label>
		<div class="stickyadsContent">
			<?php echo html_entity_decode($settings->stickyads) ?>
	  	</div>
	</div>
<?php endif; ?>



<?php /**PATH /home/admin/web/oyebesmartest.com/public_html/resources/views/ads/stickyads.blade.php ENDPATH**/ ?>