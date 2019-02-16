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

$getUsers 			= $model->getUsersList();
$getUserActiveAds 	= $model->getUserAds(get_current_user_id());
$getUserPendingAds 	= $model->getUserAds(get_current_user_id(), 'pending');
$get_free_ads 		= $model->getUserCol(get_current_user_id(), 'free_ads');

if ( bsa_role() == 'admin' ): // ADMIN SECTION ?>

	<h2>
		<span class="dashicons dashicons-admin-users"></span> Users Manager
		<?php if ( isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'free-ads' ): ?>
			 - Set free ads
		<?php elseif ( isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'give-access' ): ?>
			 - Set access to ads
		<?php endif; ?>
		<?php if ( isset($_GET['bsa-form']) ): ?>
			<p><span class="dashicons dashicon-14 dashicons-arrow-left-alt"></span> <a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-users">back to <strong>users list</strong></a></p>
		<?php else: ?>
			<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-users&bsa-form=free-ads" class="add-new-h2">Set free ads</a> <a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-users&bsa-form=give-access" class="add-new-h2">Set access to ads</a>
		<?php endif; ?>
	</h2>

	<?php if ( isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'free-ads' ): ?>

		<form action="" method="post" class="bsaFreeAds">
			<input type="hidden" value="free-ads" name="bsaProAction">
			<table class="bsaAdminTable form-table">
				<tbody class="bsaTbody">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-exerpt-view"></span> Add free ads</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="crease_method">Increase / Decrease</label></th>
					<td>
						<select id="crease_method" name="crease_method">
							<option value="increase">increase</option>
							<option value="decrease">decrease</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="free_ads">free Ads</label></th>
					<td>
						<select id="free_ads" name="free_ads">
							<option value="">select number of free ads</option>
							<?php for ( $i = 1; $i <= 10; $i++ ) {
								echo '<option value="'.$i.'">' . $i . ' free ad' . (($i>1) ? 's' : '') . '</option>';
							} ?>
						</select>
						<p class="description">
							Limit will increase if the user has unused free ads.
						</p>
					</td>
				</tr>
				<tr>
					<th class="bsaLast" scope="row"><label for="user_id">assign to</label></th>
					<td class="bsaLast">
						<select id="user_id" name="user_id">
							<option value="">select user</option>
							<?php if ( get_users( array( 'fields' => array( 'id','display_name' ) ) ) ) {
								foreach ( get_users( array( 'fields' => array( 'id','display_name' ) ) ) as $user ) {
									echo '<option value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . ' (ID: ' . esc_html( $user->id ) . ')' . '</option>';
								}
							} ?>
						</select>
					</td>
				</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" value="Save" class="button button-primary" id="bsa_pro_submit" name="submit">
			</p>
		</form>

	<?php elseif ( isset($_GET['bsa-form']) && $_GET['bsa-form'] == 'give-access' ): ?>

		<?php if ( get_bsa_ads() ): ?>

			<form action="" method="post" class="bsaNewStandardAd">
				<input type="hidden" value="give-access" name="bsaProAction">
				<table class="bsaAdminTable form-table">
					<tbody class="bsaTbody">
					<tr>
						<th colspan="2">
							<h3><span class="dashicons dashicons-exerpt-view"></span> Set access</h3>
						</th>
					</tr>
					<tr>
						<th scope="row"><label for="permissions">Permissions</label></th>
						<td>
							<select id="permissions" name="permissions">
								<option value="add">add access permissions</option>
								<option value="remove">remove access permissions</option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="ad_id">to Ad</label></th>
						<td>
							<select id="ad_id" name="ad_id">
								<option value="">select ad id</option>
								<?php foreach (get_bsa_ads() as $ad):
									echo '<option value="'.esc_html( $ad['id'] ).'">' . esc_html( $ad['id'] ) . (($ad['title'] != '') ? ' ('.$ad['title'].')' : '') . '</option>';
								endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th class="bsaLast" scope="row"><label for="user_id">for</label></th>
						<td class="bsaLast">
							<select id="user_id" name="user_id">
								<option value="">select user</option>
								<?php if ( get_users( array( 'fields' => array( 'id','display_name' ) ) ) ) {
									foreach ( get_users( array( 'fields' => array( 'id','display_name' ) ) ) as $user ) {
										echo '<option value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . ' (ID: ' . esc_html( $user->id ) . ')' . '</option>';
									}
								} ?>
							</select>
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
				<p><strong>Error!</strong> Ads not exists!</p>
			</div>

		<?php endif; ?>

	<?php else: ?>

		<h3>Users</h3>
		<table class="wp-list-table widefat bsaListTable">
			<thead>
			<tr>
				<th class="manage-column">ID</th>
				<th class="manage-column">User</th>
				<th class="manage-column">Free Ads</th>
				<th class="manage-column">Has access to Ads</th>
				<th class="manage-column">Actions</th>
			</tr>
			</thead>

			<tbody>
			<?php
			$usersPagination = new AdsProPagination();
			if (count($getUsers) > 0 && $usersPagination->getUsersPages() && $usersPagination->getUsersPages() != 'not_found') {
				foreach ($usersPagination->getUsersPages() as $key => $entry) {

					if ($key % 2) {
						$alternate = '';
					} else {
						$alternate = 'alternate';
					}
					?>

					<tr class="<?php echo $alternate; ?>">
						<td>
							<?php $user_info = get_userdata($entry['user_id']);
							echo $user_info->ID; ?>
						</td>
						<td>
							<?php
							echo '<strong>' . $user_info->user_login . '</strong>';
							?>
						</td>
						<td>
							<?php echo ( ($entry['free_ads'] > 1) ? $entry['free_ads'] . ' ads' : ( ($entry['free_ads'] == 1) ? $entry['free_ads'] . ' ad' : '-') ) ; ?>
						</td>
						<td>
							<?php $ads = null ?>
							<?php if ( json_decode($entry['ad_ids']) == null ) {
								echo '-';
							} else {
								foreach ( json_decode($entry['ad_ids']) as $ad ) {
									echo '(<strong>' . $ad . '</strong>) ';
								}
							} ?>
						</td>
						<td>
							<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-users&bsa-form=free-ads') ?>" style="margin-right: 15px">Edit Free Ads</a>
							<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-users&bsa-form=give-access') ?>">Edit Access to Ads</a>
						</td>
					</tr>

				<?php }

				if ( count($getUsers) > 40 ): ?>
					<tr>
						<td colspan="5">
							<?php
							if($prev = $usersPagination->getPrev()): ?>
								<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-users&pagination='.$prev); ?>">< Prev Page</a>
							<?php endif ?>
							<?php if($next = $usersPagination->getNext('users')): ?>
								<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-users&pagination='.$next); ?>" style="float:right;">Next Page ></a>
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

<?php else: // USERS SECTION ?>

	<div style="float:right;">
		<strong><a href="http://codecanyon.net/item/ads-pro-multipurpose-wordpress-ad-manager/10275010?ref=scripteo">ADS PRO</a></strong> - Version <?php echo get_option('bsa_pro_plugin_version') ?>
	</div>

	<h2>
		<span class="dashicons dashicons-exerpt-view"></span> Your Ads
		<?php if ( $get_free_ads['free_ads'] > 0 ): ?>
			<a href="<?php echo admin_url('admin.php?page=bsa-pro-sub-menu-add-new-ad') ?>" class="add-new-h2">Add new Ad</a>
		<?php endif; ?>
	</h2>

	<h3>Active Ads (<?php echo count($getUserActiveAds) ?>)</h3>
	<table class="wp-list-table widefat bsaListTable">
		<thead>
		<tr>
			<th></th>
			<th style="" class="manage-column post-title page-title column-title">Ad Content</th>
			<th style="" class="manage-column">Buyer</th>
			<th style="" class="manage-column">Stats</th>
			<th style="" class="manage-column">Ad Display Limit</th>
			<th style="" class="manage-column">Order Details</th>
		</tr>
		</thead>

		<tbody>
		<?php
		if (count($getUserActiveAds) > 0) {
			foreach ($getUserActiveAds as $key => $entry) {

				if ($key % 2) {
					$alternate = '';
				} else {
					$alternate = 'alternate';
				}
				?>

				<tr class="<?php echo $alternate; ?>">
					<td class="bsaAdminImg">
						<img class="bsaAdminThumb" src="<?php echo ( $entry['img'] != '' ) ? bsa_upload_url(null, $entry['img']) : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'); ?>">
					</td>
					<td class="post-title page-title column-title">
						<strong><a href="<?php echo $entry->url; ?>"><?php echo $entry['title']; ?></a></strong>
						<?php echo ( $entry['description'] != '' ) ? $entry['description'] : ''; ?>
						<?php echo ( $entry['html'] != '' ) ? 'HTML' : '' ; ?>
						<div class="row-actions">
							<span class="bsaPaidBtn">
								<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-add-new-ad&ad_id=<?php echo $entry['id']; ?>">
									Edit
								</a>
							</span>
						</div>
					</td>
					<td>
						<?php echo $entry['buyer_email']; ?>
					</td>
					<td>
						<?php
						$views = bsa_counter($entry['id'], 'view');
						$clicks = bsa_counter($entry['id'], 'click'); ?>
						Views <strong><?php echo ( $views != NULL ) ? $views : 0; ?></strong><br>
						Clicks <strong><?php echo ( $clicks != NULL ) ? $clicks : 0; ?></strong><br>
						<?php if ( $views != NULL && $clicks != NULL ): ?>
							CTR <strong><?php echo number_format(($clicks / $views) * 100, 2, '.', '').'%'; ?></strong><br>
						<?php endif; ?>
						<a target="_blank" href="<?php echo get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') ?>bsa_pro_stats=1&bsa_pro_email=<?php echo str_replace('@', '%40', $entry['buyer_email']); ?>&bsa_pro_id=<?php echo $entry['id']; ?>">
							full statistics
						</a>
					</td>
					<td>
						<?php
						if ( $entry['ad_model'] == 'cpd' ) {
							$time = time();
							$limit = $entry['ad_limit'];
							$diff = $limit - $time;
							$limit_value = ( $diff < 86400 /* 1 day in sec */ ) ? ( $diff > 0 ) ? 'less than 1 day' : '0 days' : number_format($diff / 24 / 60 / 60).' days';
							$diffTime = date('d M Y (H:m:s)', time() + $diff);
						} else {
							$limit_value = ($entry['ad_model'] == 'cpc') ? $entry['ad_limit'].' clicks' : $entry['ad_limit'].' views';
							$diffTime = '';
						}
						?>
						<strong><?php echo $limit_value; ?></strong><br>
						<?php echo ( $entry['ad_model'] == 'cpd' ) ? $diffTime : ''; ?>
					</td>
					<td>
						Ad ID / Order ID <strong><?php echo $entry['id']; ?></strong><br>
						Billing Model <strong><?php echo strtoupper($entry['ad_model']); ?></strong><br>
						Cost <strong><?php echo $before.$entry['cost'].$after; ?></strong><br>
						<?php if ( $entry['paid'] == 1 ): ?>
							<span class="bsaColorGreen">Paid</span>
						<?php elseif ( $entry['paid'] == 2 ): ?>
							<span class="bsaColorGreen">Added via Admin Panel</span>
						<?php else: ?>
							<span class="bsaColorRed">Not paid</span>
						<?php endif; ?>
					</td>
				</tr>

			<?php }
		} else {
			?>

			<tr>
				<td style="text-align: center" colspan="7">
					List empty.
				</td>
			</tr>

		<?php } ?>
		</tbody>
	</table>

	<h3>Pending Ads (<?php echo count($getUserPendingAds) . ((count($getUserPendingAds) > 1) ? ' ads' : ' ad') ?> waiting for approval)</h3>
	<table class="wp-list-table widefat bsaListTable">
		<thead>
		<tr>
			<th></th>
			<th style="" class="manage-column post-title page-title column-title">Ad Content</th>
			<th style="" class="manage-column">Buyer</th>
			<th style="" class="manage-column">Stats</th>
			<th style="" class="manage-column">Ad Display Limit</th>
			<th style="" class="manage-column">Order Details</th>
		</tr>
		</thead>

		<tbody>
		<?php
		if (count($getUserPendingAds) > 0) {
			foreach ($getUserPendingAds as $key => $entry) {

				if ($key % 2) {
					$alternate = '';
				} else {
					$alternate = 'alternate';
				}
				?>

				<tr class="<?php echo $alternate; ?>">
					<td class="bsaAdminImg">
						<img class="bsaAdminThumb" src="<?php echo ( $entry['img'] != '' ) ? bsa_upload_url(null, $entry['img']) : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'); ?>">
					</td>
					<td class="post-title page-title column-title">
						<strong><a href="<?php echo $entry->url; ?>"><?php echo $entry['title']; ?></a></strong>
						<?php echo ( $entry['description'] != '' ) ? $entry['description'] : ''; ?>
						<?php echo ( $entry['html'] != '' ) ? 'HTML' : '' ; ?>
						<div class="row-actions">
							<span class="bsaPaidBtn">
								<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-add-new-ad&ad_id=<?php echo $entry['id']; ?>">
									Edit
								</a>
							</span>
						</div>
					</td>
					<td>
						<?php echo $entry['buyer_email']; ?>
					</td>
					<td>
						<?php
						$views = bsa_counter($entry['id'], 'view');
						$clicks = bsa_counter($entry['id'], 'click'); ?>
						Views <strong><?php echo ( $views != NULL ) ? $views : 0; ?></strong><br>
						Clicks <strong><?php echo ( $clicks != NULL ) ? $clicks : 0; ?></strong><br>
						<?php if ( $views != NULL && $clicks != NULL ): ?>
							CTR <strong><?php echo number_format(($clicks / $views) * 100, 2, '.', '').'%'; ?></strong><br>
						<?php endif; ?>
						<a target="_blank" href="<?php echo get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') ?>bsa_pro_stats=1&bsa_pro_email=<?php echo str_replace('@', '%40', $entry['buyer_email']); ?>&bsa_pro_id=<?php echo $entry['id']; ?>">
							full statistics
						</a>
					</td>
					<td>
						<?php
						if ( $entry['ad_model'] == 'cpd' ) {
							$time = time();
							$limit = $entry['ad_limit'];
							$diff = $limit - $time;
							$limit_value = ( $diff < 86400 /* 1 day in sec */ ) ? ( $diff > 0 ) ? 'less than 1 day' : '0 days' : number_format($diff / 24 / 60 / 60).' days';
							$diffTime = date('d M Y (H:m:s)', time() + $diff);
						} else {
							$limit_value = ($entry['ad_model'] == 'cpc') ? $entry['ad_limit'].' clicks' : $entry['ad_limit'].' views';
							$diffTime = '';
						}
						?>
						<strong><?php echo $limit_value; ?></strong><br>
						<?php echo ( $entry['ad_model'] == 'cpd' ) ? $diffTime : ''; ?>
					</td>
					<td>
						Ad ID / Order ID <strong><?php echo $entry['id']; ?></strong><br>
						Billing Model <strong><?php echo strtoupper($entry['ad_model']); ?></strong><br>
						Cost <strong><?php echo $before.$entry['cost'].$after; ?></strong><br>
						<?php if ( $entry['paid'] == 1 ): ?>
							<span class="bsaColorGreen">Paid</span>
						<?php elseif ( $entry['paid'] == 2 ): ?>
							<span class="bsaColorGreen">Added via Admin Panel</span>
						<?php else: ?>
							<span class="bsaColorRed">Not paid</span>
						<?php endif; ?>
					</td>
				</tr>

			<?php }
		} else {
			?>

			<tr>
				<td style="text-align: center" colspan="7">
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
	})(jQuery);
</script>