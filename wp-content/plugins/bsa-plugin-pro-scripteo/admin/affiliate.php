<?php
if (get_option('bsa_pro_plugin_symbol_position') == 'before') {
	$before = '<small>'.get_option('bsa_pro_plugin_currency_symbol').'</small>';
} else {
	$before = '';
}
if (get_option('bsa_pro_plugin_symbol_position') != 'before') {
	$after = '<small>'.get_option('bsa_pro_plugin_currency_symbol').'</small>';
} else {
	$after = '';
}

$model = new BSA_PRO_Model();
$getAffiliateWithdrawals = $model->getAffiliateWithdrawals(NULL, bsa_role());
$affiliateMinToWithdrawal = ( get_option('bsa_pro_plugin_'.'ap_minimum_withdrawal') > 0 ) ? get_option('bsa_pro_plugin_'.'ap_minimum_withdrawal') : 50;
?>

<h2>
	<span class="dashicons dashicons-vault"></span> <?php echo bsa_get_trans('affiliate_program', 'affiliate'); ?>
	<?php if ( bsa_role() == 'user' ): ?>
		<p><span class="dashicons dashicon-14 dashicons-plus-alt"></span> <a class="bsaMakeWithdrawal" style="cursor: pointer"><?php echo bsa_get_trans('affiliate_program', 'make'); ?></a></p>
	<?php endif; ?>
</h2>

<?php $model->getAdminAction();
if ( $model->affiliateWithdrawalNotPossible() ) {
	echo '
		<div class="updated settings-error">'; ?>
			<p><?php echo bsa_get_trans('affiliate_program', 'failed'); ?></p>
	<?php echo '</div>';
} elseif ( $model->affiliateWithdrawalDone() ) {
	echo '<div class="updated settings-error">'; ?>
			<p><?php echo bsa_get_trans('affiliate_program', 'success'); ?></p>
	<?php echo '</div>';
} ?>

<?php if ( bsa_role() == 'user' ): ?>
	<form action="" method="post" class="bsaNewWithdrawal" style="display: none">
		<input type="hidden" value="affiliateNewWithdrawal" name="bsaProAction">
		<input type="hidden" value="<?php echo get_current_user_id(); ?>" name="orderId">
		<table class="bsaAdminTable form-table">
			<tbody class="bsaTbody">
			<tr>
				<th scope="row"><label><?php echo bsa_get_trans('affiliate_program', 'earnings'); ?></label></th>
				<td>
					<?php echo $before ?><input name="amount" type="number" class="regular-text" placeholder="" maxlength="255" value="<?php echo bsa_number_format($model->getAffiliateBalance()) ?>" disabled><?php echo $after ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="bsa_pro_payment_account"><?php echo bsa_get_trans('affiliate_program', 'payment'); ?></label></th>
				<td>
					<input id="bsa_pro_payment_account" name="payment_account" type="email" class="regular-text" maxlength="255" value="">
				</td>
			</tr>
			</tbody>
		</table>
		<input class="bsa_inputs_required" name="inputs_required" type="hidden" value="">
		<p class="submit">
			<input type="submit" value="<?php echo bsa_get_trans('affiliate_program', 'button'); ?>" class="button button-primary" id="bsa_pro_submit" name="submit">
		</p>
	</form>
<?php endif; ?>

<h3><?php echo bsa_get_trans('affiliate_program', 'withdrawals'); ?></h3>
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
<script>
	(function($) {
		// - start - open page
		var bsaItemsWrap = $(".wrap");
		setTimeout(function () {
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page

		var bsaMakeWithdrawal = $('.bsaMakeWithdrawal');
		var bsaNewWithdrawal = $('.bsaNewWithdrawal');
		bsaMakeWithdrawal.click(function(){
			bsaNewWithdrawal.fadeIn();
		});
	})(jQuery);
</script>