<?php
if (get_option('bsa_pro_plugin_symbol_position') == 'before') {
	$before = get_option('bsa_pro_plugin_currency_symbol');
} else {
	$before = '';
}
if (get_option('bsa_pro_plugin_symbol_position') != 'before') {
	$after = get_option('bsa_pro_plugin_currency_symbol');
} else {
	$after = '';
}

$getTasks = $model->getCronTasks();
$get_ads = $model->getAdsForSchedule();
$get_spaces = $model->getSpacesForSchedule();

$ifAdForm = ((isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'task-ad') ? true : false);
$ifSpaceForm = ((isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'task-space') ? true : false);

?>
<h2>
		<span class="dashicons dashicons-calendar-alt"></span> Ads Schedule
<?php if ( isset($_GET['bsa-form']) ): ?>
	<p><span class="dashicons dashicon-14 dashicons-arrow-left-alt"></span> <a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-cron">back to <strong>tasks list</strong></a></p>
<?php else: ?>
	<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-cron&bsa-form=task-ad" class="add-new-h2">Set task for Ad</a> <a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-cron&bsa-form=task-space" class="add-new-h2">Set task for Ad Space</a>
<?php endif; ?>
</h2>

<?php
if ($model->taskClosed()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Task has been blocked.</strong></p>
		</div>';
}

if ( $ifAdForm || $ifSpaceForm ): ?>

	<?php if ( $ifAdForm && $get_ads || $ifSpaceForm && $get_spaces ): ?>

		<form action="" method="post" class="bsaNewStandardAd">
			<input type="hidden" value="task-<?php echo (($ifAdForm) ? 'ad' : 'space'); ?>" name="bsaProAction">
			<table class="bsaAdminTable form-table">
				<tbody class="bsaTbody">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-clock"></span> Set task for Ad <?php echo (($ifAdForm) ? null : 'Space'); ?></h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="<?php echo (($ifAdForm) ? 'ad' : 'space'); ?>_id">Select <?php echo (($ifAdForm) ? 'Ad' : 'Space'); ?> ID</label></th>
					<td>
						<select id="<?php echo (($ifAdForm) ? 'ad' : 'space'); ?>_id" name="<?php echo (($ifAdForm) ? 'ad' : 'space'); ?>_id">
							<?php foreach ((($ifAdForm) ? $get_ads : $get_spaces) as $entry):
								echo '<option value="'.esc_html( $entry['id'] ).'">' . esc_html( $entry['id'] ) . (($entry[(($ifAdForm) ? 'title' : 'name')] != '') ? ' - '.$entry[(($ifAdForm) ? 'title' : 'name')] : null) . ' ('.$entry['status'].')' . '</option>';
							endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="cron_action">Select action</label></th>
					<td>
						<select id="cron_action" name="cron_action">
							<?php if ($ifAdForm): ?>
								<option value="active">change status to active</option>
								<option value="blocked">change status to blocked</option>
							<?php else: ?>
								<option value="active">change status to active</option>
								<option value="inactive">change status to inactive</option>
							<?php endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="repeat">When repeat?</label></th>
					<td>
						<fieldset>
							<label title="run once"><input type="radio" checked="checked" value="0" name="repeat">only once</label><br>
							<label title="run every day"><input type="radio" value="1" name="repeat">every day</label><br>
							<label title="run every 2 days"><input type="radio" value="2" name="repeat">every 2 days</label><br>
							<label title="run every 3 days"><input type="radio" value="3" name="repeat">every 3 days</label><br>
							<label title="run every 4 days"><input type="radio" value="4" name="repeat">every 4 days</label><br>
							<label title="run every 5 days"><input type="radio" value="5" name="repeat">every 5 days</label><br>
							<label title="run every 6 days"><input type="radio" value="6" name="repeat">every 6 days</label><br>
							<label title="run every 7 days"><input type="radio" value="7" name="repeat">every 7 days</label><br>
							<label title="run every 14 days"><input type="radio" value="14" name="repeat">every 14 days</label><br>
							<label title="run every 30 days"><input type="radio" value="30" name="repeat">every 30 days</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th class="bsaLast" scope="row">
						<label for="start_date">
							Start-up time<br><br>
							<span style="font-weight:normal;">current server time: <br><strong><?php echo date('Y-m-d H:i'); ?></strong></span>
						</label>
					</th>
					<td class="bsaLast">
						<input type="text" class="start_date" id="start_date" name="start_date" value="" placeholder="select date" style="width:100%;max-width:307px;"/>
						<br>
						<select id="start_date" name="hour" style="width:100%;max-width:150px;">
							<option value="">select hour</option>
							<?php for ( $i = 0; $i <= 23; $i++ ) {
								echo '<option value="'.(($i<=9) ? 0 : null).$i.'">' . (($i<=9) ? 0 : null) . $i . '</option>';
							} ?>
						</select>
						<select id="start_date" name="minutes" style="width:100%;max-width:150px;">
							<option value="">select minutes</option>
							<?php for ( $i = 0; $i <= 5; $i++ ) {
								echo '<option value="'.$i.'0">' . $i . '0</option>';
							} ?>
						</select>
						<p><strong>Note!</strong><br>Start-up time should be greater than the current.<br>The interval between tasks should be a minimum of 10 minutes</p>
					</td>
				</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="Save" class="button button-primary" id="bsa_pro_submit" name="submit">
			</p>
		</form>

	<?php else: ?>

		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><strong>Error!</strong> Active or <?php echo (($ifAdForm) ? 'blocked Ads' : 'inactive Ad Spaces'); ?> not exists!</p>
		</div>

	<?php endif; ?>

<?php else: ?>

	<h3>Pending Tasks</h3>
	<table class="wp-list-table widefat bsaListTable">
		<thead>
		<tr>
			<th class="manage-column"><strong>ID</strong></th>
			<th class="manage-column"><strong>Ad / Space ID</strong></th>
			<th class="manage-column"><strong>Action type</strong></th>
			<th class="manage-column"><strong>Start-up time</strong></th>
			<th class="manage-column"><strong>When repeat?</strong></th>
			<th class="manage-column"><strong>Actions</strong></th>
		</tr>
		</thead>

		<tbody>
		<?php
		$tasksPagination = new AdsProPagination();
		if (count($getTasks) > 0 && $tasksPagination->getTasksPages() && $tasksPagination->getTasksPages() != 'not_found') {
			foreach ($tasksPagination->getTasksPages() as $key => $entry) {

				if ($key % 2) {
					$alternate = '';
				} else {
					$alternate = 'alternate';
				}
				?>

				<tr class="<?php echo $alternate; ?>">
					<td>
						<?php echo $entry['id']; ?>
					</td>
					<td>
						<?php echo '<strong>Ad '.(($entry['item_type'] == 'space') ? 'Space' : null).' ID:</strong> '.$entry['item_id']; ?>
					</td>
					<td>
						<?php echo 'change status to <strong>'.$entry['action_type'].'</strong>'; ?>
					</td>
					<td>
						<strong><?php echo date('Y-m-d', $entry['start_time']); ?></strong> <?php echo date('H:i', $entry['start_time']); ?>
					</td>
					<td>
						<?php if ( $entry['when_repeat'] == 0 ) {
							echo 'only <strong>once</strong>';
						} else {
							echo 'repeat <strong>every '.(($entry['when_repeat'] > 1) ? $entry['when_repeat'].' days' : 'day').'</strong>';
						} ?>
					</td>
					<td>
						<form action="" method="post">
							<input type="hidden" value="close-task" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
								<span class="bsaProActionBtn bsaBlockBtn">
									<input type="submit" value="Close this task" id="submit" name="submit">
								</span>
						</form>
					</td>
				</tr>

			<?php }

			if ( count($getTasks) > 40 ): ?>
				<tr>
					<td colspan="6">
						<?php
						if($prev = $tasksPagination->getPrev()): ?>
							<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-cron&pagination='.$prev); ?>">< Prev Page</a>
						<?php endif ?>
						<?php if($next = $tasksPagination->getNext('tasks')): ?>
							<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-cron&pagination='.$next); ?>" style="float:right;">Next Page ></a>
						<?php endif ?>
					</td>
				</tr>
			<?php
			endif;

		} else {
			?>

			<tr>
				<td style="text-align: center" colspan="5">
					List empty.
				</td>
			</tr>

		<?php } ?>
		</tbody>
	</table>

<?php endif; ?>

<script>
	(function($) {
		// - start - open page
		var bsaItemsWrap = $('.wrap');
		bsaItemsWrap.hide();

		setTimeout(function(){
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page

		<?php if ($model->taskClosed()) { ?>
		var bsaValidationAlert = $('#setting-error-settings_updated');
		bsaValidationAlert.fadeIn(100);
		setTimeout(function(){
			bsaValidationAlert.fadeOut(100);
			bsaItemsWrap.fadeOut(100);
		}, 2000);
		setTimeout(function(){
			window.location=document.location.href;
		}, 2000);
		<?php } ?>

		$(document).ready(function() {
			$('.start_date').datepicker({
				dateFormat : 'yy-mm-dd',
				beforeShow: function(input, inst) {
					$('#ui-datepicker-div').addClass('bsaProCalendar');
				}
			});
		});
	})(jQuery);
</script>