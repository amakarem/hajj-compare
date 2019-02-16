<?php
if (get_option('bsa_pro_plugin_symbol_position') == 'before') {
	$before = '<small>'.get_option('bsa_pro_plugin_currency_symbol').'</small> ';
} else {
	$before = '';
}
if (get_option('bsa_pro_plugin_symbol_position') != 'before') {
	$after = ' <small>'.get_option('bsa_pro_plugin_currency_symbol').'</small>';
} else {
	$after = '';
}

$model 							= new BSA_PRO_Model();
$countSpaces 					= $model->countSpaces();
$countAds 						= $model->countAds();
$countEarnings 					= $model->countEarnings();
$getPendingAds 					= $model->getPendingAds('admin_dashboard');
$getLastAds 					= $model->getLastAds();
$getAffiliateWithdrawals 		= $model->getAffiliateWithdrawals('pending', bsa_role());
$getSites 						= $model->getSites(bsa_role(), 'pending');
$getWithdrawals 				= $model->getWithdrawals('pending', bsa_role());
?>
<div style="float:right;text-align: right">
	<strong><a href="http://codecanyon.net/item/ads-pro-multipurpose-wordpress-ad-manager/10275010?ref=scripteo">ADS PRO</a></strong> - Version <?php echo get_option('bsa_pro_plugin_version') ?>
</div>
<h2>
	<i class="dashicons dashicons-megaphone"></i> ADS PRO - Dashboard
</h2>

<?php if ( get_option('bsa_pro_plugin_username') == '' || get_option('bsa_pro_plugin_username') == null ): ?>
<div class="updated notice notice-success">
	<h3>Earn more with Ads Pro!</h3>
	<p>
		Paste your <strong>username in the Settings</strong> to show referral link at the bottom of Ad Spaces. <strong><a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-opts#bsaAdmin">Here</a></strong> you can enable it.
		<br><br>
		<strong>Example</strong> Ad Space:<br>
		<img class="bsaProSampleRef" src="https://cdn.pbrd.co/images/GTPGQa3.png" title="Ads Pro - Referral Link"/>
	</p>
</div>
<?php endif; ?>

<?php bsaProCheckUpdate(); ?>

<?php if ( get_option('bsa_pro_plugin_max_button') == '' || get_option('bsa_pro_plugin_max_button') == null ): ?>
	<div class="error">
		<h3>After upload new files you need to re-activate Ads Pro Plugin!</h3>
		<p>
			Go to Plugins <strong><a href="<?php echo admin_url(); ?>plugins.php">here</a></strong> to re-activate Ads Pro.
		</p>
	</div>
<?php endif; ?>

<div class="bsaDashboard">
	<div class="bsaDashboard-stats">
		<div class="bsaDashboard-stat">
			<div class="bsaDashboard-inner greenBg">
				<span class="dashicons dashicons-welcome-widgets-menus"></span>
				<span class="bsaDashboard-title">Spaces / Ads</span>
				<strong class="bsaDashboard-amount"><?php echo ( $countSpaces ) ? $countSpaces : 0 ?> / <?php echo ( $countAds ) ? $countAds : 0 ?> </strong>
			</div>
		</div>
		<div class="bsaDashboard-stat">
			<div class="bsaDashboard-inner blueBg">
				<span class="dashicons dashicons-external"></span>
				<span class="bsaDashboard-title">Clicks</span>
				<strong class="bsaDashboard-amount"><?php $clicks = get_option('bsa_pro_plugin_dashboard_clicks'); echo number_format($clicks, 0, '.', ' ') ?> <small>clicks</small></strong>
			</div>
		</div>
		<div class="bsaDashboard-stat">
			<div class="bsaDashboard-inner yellowBg">
				<span class="dashicons dashicons-visibility"></span>
				<span class="bsaDashboard-title">Impressions</span>
				<strong class="bsaDashboard-amount"><?php $views = get_option('bsa_pro_plugin_dashboard_views'); echo number_format($views, 0, '.', ' ') ?> <small>views</small></strong>
			</div>
		</div>
		<div class="bsaDashboard-stat">
			<div class="bsaDashboard-inner violetBg">
				<span class="dashicons dashicons-welcome-view-site"></span>
				<span class="bsaDashboard-title">CTR</span>
				<strong class="bsaDashboard-amount"><?php echo ( $views > 0 ) ? number_format(($clicks / $views) * 100, 2, '.', ' ') : 0; ?> <small>%</small></strong>
			</div>
		</div>
		<div class="bsaDashboard-stat">
			<div class="bsaDashboard-inner redBg">
				<span class="dashicons dashicons-vault"></span>
				<span class="bsaDashboard-title">Total earnings</span>
				<strong class="bsaDashboard-amount"><?php echo ( $countEarnings ) ? $before.bsa_number_format($countEarnings).$after : $before.bsa_number_format(0).$after ?></strong>
			</div>
		</div>
	</div>
</div>

<?php  $model->getAdminAction();
if ( $model->validationAccept() ) {
	echo '
	<div class="updated settings-error" id="setting-error-settings_updated">
		<p><div class="bsaLoader"></div><strong>Ad has been accepted.</strong></p>
	</div>';
} elseif ( $model->validationBlocked() ) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Ad blocked.</strong></p>
		</div>';
} elseif ($model->validationPaid()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Ad marked as paid.</strong></p>
		</div>';
} elseif ($model->validationWithdrawalPaid()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Agency Withdrawal marked as paid.</strong></p>
		</div>';
} elseif ($model->validationWithdrawalRejected()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Agency Withdrawal has been rejected.</strong></p>
		</div>';
} elseif ($model->affiliateWithdrawalPaid()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Affiliate Withdrawal marked as paid.</strong></p>
		</div>';
} elseif ($model->affiliateWithdrawalRejected()) {
	echo '
		<div class="updated settings-error" id="setting-error-settings_updated">
			<p><div class="bsaLoader"></div><strong>Affiliate Withdrawal has been rejected.</strong></p>
		</div>';
} ?>

<h3>Pending Ads</h3>
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
	if (count($getPendingAds) > 0) {
		foreach ($getPendingAds as $key => $entry) {

			if ($key % 2) {
				$alternate = '';
			} else {
				$alternate = 'alternate';
			}
			?>

			<tr class="<?php echo $alternate; ?>">
				<td class="bsaAdminImg">
					<img class="bsaAdminThumb"
						 src="<?php echo ($entry['img'] != '') ? bsa_upload_url(null, $entry['img']) : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'); ?>">
				</td>
				<td class="post-title page-title column-title">
					<strong><a href="<?php echo $entry['url']; ?>"><?php echo $entry['title']; ?></a></strong>
					<?php echo ($entry['description'] != '') ? $entry['description'] : ''; ?>
					<?php echo ($entry['html'] != '') ? 'HTML' : ''; ?>
					<div class="row-actions">
						<form action="" method="post">
							<input type="hidden" value="accept" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
								<span class="bsaProActionBtn bsaPaidBtn"><input type="submit" value="Accept this Ad"
																				id="submitAccept" name="submit"></span>
						</form>
						|
						<?php if ($entry['paid'] == 0 || $entry['paid'] == NULL): ?>
							<form action="" method="post">
								<input type="hidden" value="paid" name="bsaProAction">
								<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
									<span class="bsaProActionBtn bsaPaidBtn"><input type="submit" value="Mark as paid"
																					id="submitPaid"
																					name="submit"></span>
							</form>
							|
						<?php endif; ?>
						<form action="" method="post">
							<input type="hidden" value="block" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
								<span class="bsaProActionBtn bsaBlockBtn"><input type="submit" value="Block"
																				 id="submitBlock" name="submit"></span>
						</form>
						|
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
					Views <strong><?php echo ($views != NULL) ? $views : 0; ?></strong><br>
					Clicks <strong><?php echo ($clicks != NULL) ? $clicks : 0; ?></strong><br>
					<?php if ($views != NULL && $clicks != NULL): ?>
						CTR
						<strong><?php echo number_format(($clicks / $views) * 100, 2, '.', '') . '%'; ?></strong>
						<br>
					<?php endif; ?>
					<a target="_blank href="<?php echo get_option('bsa_pro_plugin_ordering_form_url') . ((strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE) ? '&' : '?') ?>bsa_pro_stats=1&bsa_pro_email=<?php echo str_replace('@', '%40', $entry['buyer_email']); ?>&bsa_pro_id=<?php echo $entry['id']; ?>">
						full statistics
					</a>
				</td>
				<td>
					<?php
					if ($entry['ad_model'] == 'cpd') {
						$time = time();
						$limit = $entry['ad_limit'];
						$diff = $limit - $time;
						$limit_value = ($diff < 86400 /* 1 day in sec */) ? ($diff > 0) ? 'less than 1 day' : '0 days' : number_format($diff / 24 / 60 / 60) . ' days';
						$diffTime = date('d M Y (H:m:s)', time() + $diff);
					} else {
						$limit_value = ($entry['ad_model'] == 'cpc') ? $entry['ad_limit'] . ' clicks' : $entry['ad_limit'] . ' views';
						$diffTime = '';
					}
					?>
					<strong><?php echo $limit_value; ?></strong><br>
					<?php echo ($entry['ad_model'] == 'cpd') ? $diffTime : ''; ?>
				</td>
				<td>
					Space ID <strong><?php echo $entry['space_id']; ?></strong><br>
					Ad ID / Order ID <strong><?php echo $entry['id']; ?></strong><br>
					Billing Model <strong><?php echo strtoupper($entry['ad_model']); ?></strong><br>
					Cost <strong><?php echo $before . bsa_number_format($entry['cost']) . $after; ?></strong><br>
					<?php if ($entry['paid'] == 1): ?>
						<span class="bsaColorGreen">Paid</span>
					<?php elseif ($entry['paid'] == 2): ?>
						<span class="bsaColorGreen">Added via Admin Panel</span>
					<?php else: ?>
						<span class="bsaColorRed">Not paid</span>
					<?php endif; ?><br>
					<?php if ( $model->getPendingTask($entry['id'], 'ad') ): ?>
						<span class="dashicons dashicons-clock"></span> scheduled status change
					<?php endif; ?>
				</td>
			</tr>
			<?php
		}
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

<h3>Pending Affiliate Withdrawals (<a href="http://codecanyon.net/user/scripteo/portfolio?ref=scripteo">Affiliate Program Add-on</a>)</h3>
<table class="wp-list-table widefat bsaListTable">
	<thead>
	<tr>
		<th><?php echo bsa_get_trans('affiliate_program', 'id'); ?></th>
		<th style="" class="manage-column post-title page-title column-title"><?php echo bsa_get_trans('affiliate_program', 'user_id'); ?></th>
		<th style="" class="manage-column"><?php echo bsa_get_trans('affiliate_program', 'date'); ?></th>
		<th style="" class="manage-column"><?php echo bsa_get_trans('affiliate_program', 'amount'); ?></th>
		<th style="" class="manage-column"><?php echo bsa_get_trans('affiliate_program', 'account'); ?></th>
		<th style="" class="manage-column"><?php echo bsa_get_trans('affiliate_program', 'status'); ?></th>
	</tr>
	</thead>

	<tbody>
	<?php
	if (count($getAffiliateWithdrawals) > 0) {
		foreach ($getAffiliateWithdrawals as $key => $entry) {

			if ($key % 2) {
				$alternate = '';
			} else {
				$alternate = 'alternate';
			}
			?>

			<tr class="<?php echo $alternate; ?>">
				<td class="bsaAdminImg">
					<?php echo $entry['id']; ?>
				</td>
				<td class="post-title page-title column-title">
					<strong><?php echo $entry['user_id']; ?></strong>

					<div class="row-actions">
						<form action="" method="post">
							<input type="hidden" value="affiliateWithdrawalPaid" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
							<span class="bsaProActionBtn bsaPaidBtn"><input type="submit" value="Mark as paid" id="submitAffiliateWithdrawalPaid" name="submit"></span>
						</form>
						|
						<form action="" method="post">
							<input type="hidden" value="affiliateWithdrawalReject" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
							<span class="bsaProActionBtn bsaBlockBtn"><input type="submit" value="Reject" id="submitAffiliateWithdrawalReject" name="submit"></span>
						</form>
					</div>
				</td>
				<td>
					<?php echo (($entry['request_time'] > 0) ? '<strong>'.date('Y M d', $entry['request_time']).'</strong> '.date('h:m:s', $entry['request_time']) : '-'); ?>
				</td>
				<td>
					<?php echo $before.' '.$entry['amount'].' '.$after; ?>
				</td>
				<td>
					<?php echo $entry['payment_account']; ?>
				</td>
				<td>
					<?php if ( $entry['status'] == 'done' ): ?>
						<span class="bsaColorGreen"><?php echo bsa_get_trans('affiliate_program', 'done'); ?></span>
					<?php elseif ( $entry['status'] == 'pending' ): ?>
						<span class="bsaColorGrey"><?php echo bsa_get_trans('affiliate_program', 'pending'); ?></span>
					<?php else: ?>
						<span class="bsaColorRed"><?php echo bsa_get_trans('affiliate_program', 'rejected'); ?></span>
					<?php endif; ?>
				</td>
			</tr>

		<?php }
	} else {
		?>

		<tr>
			<td style="text-align: center" colspan="7">
				<?php echo bsa_get_trans('affiliate_program', 'empty'); ?>
			</td>
		</tr>

	<?php } ?>
	</tbody>
</table>

<h3>Pending Sites (<a href="http://codecanyon.net/item/ads-pro-1-wordpress-marketing-agency-addon/10665901?ref=scripteo">Marketing Agency Add-on</a>)</h3>
<table class="wp-list-table widefat bsaListTable">
	<thead>
	<tr>
		<th></th>
		<th style="" class="manage-column post-title page-title column-title">Site Title</th>
		<th style="" class="manage-column">URL</th>
		<th style="" class="manage-column">Status</th>
	</tr>
	</thead>

	<tbody>
	<?php
	if (count($getSites) > 0) {
		foreach ($getSites as $key => $entry) {

			if ($key % 2) {
				$alternate = '';
			} else {
				$alternate = 'alternate';
			}
			?>

			<tr class="<?php echo $alternate; ?>">
				<td class="bsaAdminImg">
					<img class="bsaAdminThumb" src="<?php echo ( $entry['thumb'] != '' ) ? bsa_upload_url(null, $entry['thumb']) : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'); ?>">
				</td>
				<td class="post-title page-title column-title">
					<strong><?php echo $entry['title']; ?></strong>
					<div class="row-actions">
						<span class="bsaPaidBtn">
							<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-ma-new-site&site_id=<?php echo $entry['id']; ?>">
								Edit
							</a>
						</span>
					</div>
				</td>
				<td>
					<a href="<?php echo $entry['url']; ?>"><?php echo $entry['url']; ?></a>
				</td>
				<td>
					<?php if ( $entry['status'] == 'active' ): ?>
						<span class="bsaColorGreen">Active</span>
					<?php elseif ( $entry['status'] == 'pending' ): ?>
						<span class="bsaColorGrey">Pending</span>
					<?php else: ?>
						<span class="bsaColorRed">Inactive</span>
					<?php endif; ?>
				</td>
			</tr>

		<?php }
	} else {
		?>

		<tr>
			<td style="text-align: center" colspan="4">
				List empty.
			</td>
		</tr>

	<?php } ?>
	</tbody>
</table>

<h3>Pending Agency Withdrawals (<a href="http://codecanyon.net/item/ads-pro-1-wordpress-marketing-agency-addon/10665901?ref=scripteo">Marketing Agency Add-on</a>)</h3>
<table class="wp-list-table widefat bsaListTable">
	<thead>
	<tr>
		<th>ID</th>
		<th style="" class="manage-column post-title page-title column-title">User ID</th>
		<th style="" class="manage-column">Date</th>
		<th style="" class="manage-column">Amount</th>
		<th style="" class="manage-column">Payment Account</th>
		<th style="" class="manage-column">Status</th>
	</tr>
	</thead>

	<tbody>
	<?php
	if (count($getWithdrawals) > 0) {
		foreach ($getWithdrawals as $key => $entry) {

			if ($key % 2) {
				$alternate = '';
			} else {
				$alternate = 'alternate';
			}
			?>

			<tr class="<?php echo $alternate; ?>">
				<td class="bsaAdminImg">
					<?php echo $entry['id']; ?>
				</td>
				<td class="post-title page-title column-title">
					<strong><?php echo $entry['user_id']; ?></strong>

					<div class="row-actions">
						<form action="" method="post">
							<input type="hidden" value="withdrawalPaid" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
							<span class="bsaProActionBtn bsaPaidBtn"><input type="submit" value="Mark as paid" id="submitWithdrawalPaid" name="submit"></span>
						</form>
						|
						<form action="" method="post">
							<input type="hidden" value="withdrawalReject" name="bsaProAction">
							<input type="hidden" value="<?php echo $entry['id']; ?>" name="orderId">
							<span class="bsaProActionBtn bsaBlockBtn"><input type="submit" value="Reject" id="submitWithdrawalReject" name="submit"></span>
						</form>
					</div>
				</td>
				<td>
					<?php echo(($entry['request_time'] > 0) ? '<strong>' . date('Y M d', $entry['request_time']) . '</strong> ' . date('h:m:s', $entry['request_time']) : '-'); ?>
				</td>
				<td>
					<?php echo $before . ' ' . $entry['amount'] . ' ' . $after; ?>
				</td>
				<td>
					<?php echo $entry['payment_account']; ?>
				</td>
				<td>
					<?php if ($entry['status'] == 'done'): ?>
						<span class="bsaColorGreen">Done</span>
					<?php elseif ($entry['status'] == 'pending'): ?>
						<span class="bsaColorGrey">Pending</span>
					<?php else: ?>
						<span class="bsaColorRed">Rejected</span>
					<?php endif; ?>
				</td>
			</tr>

		<?php }
	} else {
		?>

		<tr>
			<td style="text-align: center" colspan="6">
				List empty.
			</td>
		</tr>

	<?php } ?>
	</tbody>
</table>

<h3>Last Sold Ads</h3>
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
	if (count($getLastAds) > 0) {
		foreach ($getLastAds as $key => $entry) {

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
					<strong><a href="<?php echo $entry['url']; ?>"><?php echo $entry['title']; ?></a></strong>
					<?php echo ( $entry['description'] != '' ) ? $entry['description'] : ''; ?>
					<?php echo ( $entry['html'] != '' ) ? 'HTML' : '' ; ?>
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
					Space ID <strong><?php echo $entry['space_id']; ?></strong><br>
					Ad ID / Order ID <strong><?php echo $entry['id']; ?></strong><br>
					Billing Model <strong><?php echo strtoupper($entry['ad_model']); ?></strong><br>
					Cost <strong><?php echo $before . bsa_number_format($entry['cost']) . $after; ?></strong><br>
					<?php if ( $entry['paid'] == 1 ): ?>
						<span class="bsaColorGreen">Paid</span>
					<?php elseif ( $entry['paid'] == 2 ): ?>
						<span class="bsaColorGreen">Added via Admin Panel</span>
					<?php else: ?>
						<span class="bsaColorRed">Not paid</span>
					<?php endif; ?>
				</td>
			</tr>

		<?php
		}
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


<script>
	(function($){
		// - start - open page
		var bsaItemsWrap = $('.wrap');
		bsaItemsWrap.hide();

		setTimeout(function(){
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page

		<?php if ( $model->validationAccept() or $model->validationBlocked() or $model->validationPaid() or $model->validationWithdrawalPaid() or $model->validationWithdrawalRejected() or $model->affiliateWithdrawalPaid() or $model->affiliateWithdrawalRejected() ) { ?>
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
	})(jQuery);
</script>