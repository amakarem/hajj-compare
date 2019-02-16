<?php
$bsaTrans = 'bsa_pro_plugin_trans_';

$model = new BSA_PRO_Model();
if ( isset($_POST) && isset($_POST['bsaProSubmit']) || isset($_GET['oid']) && isset($_GET['cid']) ) {
	$getForm = $model->getForm();
} else {
	$getForm = '';
	unset($_SESSION['bsaProAds']);
}

// get notify action
if (isset($_GET['bsa_pro_payment']) && $_GET['bsa_pro_payment'] == 'notify' || isset($_POST['stripeToken'])) {
	$model->notifyAction();
}

echo '
<div class="bsaProOrderingForm">
	<div class="bsaProOrderingFormInner">
		';

	if (isset($_GET["bsa_pro_notice"]) && $_GET["bsa_pro_notice"] == 'success'): ?>
		<div class="bsaProAlert bsaProAlertSuccess bsaProAlertSuccessNotice">
			<strong><?php echo get_option($bsaTrans."alert_success"); ?></strong>
			<p><?php echo get_option($bsaTrans."payment_success"); ?></p>
		</div>
	<?php elseif (isset($_GET["bsa_pro_notice"]) && $_GET["bsa_pro_notice"] == 'failed'): ?>
		<div class="bsaProAlert bsaProAlertFailed bsaProAlertFailedNotice">
			<strong><?php echo get_option($bsaTrans."alert_failed"); ?></strong>
			<p><?php echo get_option($bsaTrans."payment_failed"); ?></p>
		</div>
	<?php endif; ?>

	<?php if ($getForm == "invalidParams"): ?>
		<div class="bsaProAlert bsaProAlertFailed">
			<strong><?php echo get_option($bsaTrans."alert_failed"); ?></strong>
			<p><?php echo get_option($bsaTrans."form_invalid_params"); ?></p>
		</div>
	<?php elseif ($getForm == "invalidSizeFile"): ?>
		<div class="bsaProAlert bsaProAlertFailed">
			<strong><?php echo get_option($bsaTrans."alert_failed"); ?></strong>
			<p><?php echo get_option($bsaTrans."form_too_high"); ?></p>
		</div>
	<?php elseif ($getForm == "invalidFile"): ?>
		<div class="bsaProAlert bsaProAlertFailed">
			<strong><?php echo get_option($bsaTrans."alert_failed"); ?></strong>
			<p><?php echo get_option($bsaTrans."form_img_invalid"); ?></p>
		</div>
	<?php elseif ($getForm == "fieldsRequired"): ?>
		<div class="bsaProAlert bsaProAlertFailed">
			<strong><?php echo get_option($bsaTrans."alert_failed"); ?></strong>
			<p><?php echo get_option($bsaTrans."form_empty"); ?></p>
		</div>
	<?php elseif ($getForm == "edited"): ?>
		<div class="bsaProAlert bsaProAlertSuccess">
			<strong><?php echo get_option($bsaTrans."alert_success"); ?></strong>
		</div>
	<?php elseif ($getForm == "successAdded"): ?>
		<div class="bsaProAlert bsaProAlertSuccess">
			<strong><?php echo get_option($bsaTrans."alert_success"); ?></strong>
			<p><?php echo get_option($bsaTrans."form_success"); ?></p>
		</div>
		<div id="bsaSuccessProRedirect">
			<div class="bsaPayPalSectionBg"></div>
			<div class="bsaPayPalSectionCenter">
				<span class="bsaLoaderRedirect" style="margin-top:200px;"></span>
			</div>
			<form><input id="bsa_payment_url" type="hidden" name="bsa_payment_url" value="<?php echo (isset($_SESSION['bsa_payment_url'])) ? $_SESSION['bsa_payment_url'] : '' ?>"></form>
		</div>
	<?php endif;

	$spaces = $model->getSpaces('active', 'html');
	$space_verify = NULL;
	if (is_array($spaces))
	{
		foreach ( $spaces as $key => $space ) {
			if ( $space['cpc_price'] == 0 && $space['cpm_price'] == 0 && $space['cpd_price'] == 0 ) {
				$space_verify .= '';
			} else {
				if ( $model->countAds($space["id"]) < bsa_space($space["id"], 'max_items') || bsa_space($space["id"], 'max_items') == 1 && get_option('bsa_pro_plugin_calendar') == 'yes' ) {
					$space_verify .= (( $key > 0 ) ? ','.$space["id"] : $space["id"]);
				} else {
					$space_verify .= '';
				}
			}
		}
	}
	$space_verify = (( $space_verify != '') ? explode(',', $space_verify) : FALSE );

	if ( isset($_GET['oid']) && $_GET['oid'] != '' && bsa_ad($_GET['oid'], 'id') != null && bsa_space(bsa_ad($_GET['oid'], 'space_id'), 'status') == 'active' && !isset($_GET['cid']) ||
		 isset($_GET['oid']) && $_GET['oid'] != '' && bsa_ad($_GET['oid'], 'id') != null && isset($_GET['cid']) && $_GET['cid'] != '' && bsa_space(bsa_ad($_GET['oid'], 'space_id'), 'status') == 'active' && bsa_space(bsa_ad($_GET['oid'], 'space_id'), bsa_ad($_GET['oid'], 'ad_model').'_contract_'.$_GET['cid']) > 0 ) { // Payments

		if (empty($_GET)) {
			$checkGET = '?';
		} else {
			$checkGET = '&';
		}
		$orderId = $_GET['oid'];
		$userEmail = bsa_ad($_GET['oid'], 'buyer_email');
		$spaceId = bsa_ad($_GET['oid'], 'space_id');
		$billingModel = bsa_ad($_GET['oid'], 'ad_model');
		if ( $billingModel == 'cpm' ):
			$type = bsa_get_trans('user_panel', 'views');
		elseif ( $billingModel == 'cpc' ):
			$type = bsa_get_trans('user_panel', 'clicks');
		else:
			$type = bsa_get_trans('user_panel', 'days');
		endif;
		if ( isset($_GET['cid']) ) { // renewal payment
			if ( $_GET['cid'] == 2 || $_GET['cid'] == 3 ) {
				$price = bsa_space($spaceId, $billingModel.'_price') * ( bsa_space($spaceId, $billingModel.'_contract_'.$_GET['cid']) / bsa_space($spaceId, $billingModel.'_contract_1') );
				$discount = $price * ( bsa_space($spaceId, 'discount_'.$_GET['cid']) / 100 );
				$total_cost = $price - $discount;
			} else {
				$total_cost = bsa_space($spaceId, $billingModel.'_price');
			}
			$amount = $total_cost;
		} else { // first payment
			$amount = bsa_ad($_GET['oid'], 'cost');
		}

		// reset cache sessions
		unset($_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$orderId]);
		if ( bsa_ad($_GET['oid'], 'paid') == 1 || bsa_ad($_GET['oid'], 'paid') == 2 ) {
			?>
			<div class="bsaProAlert bsaProAlertSuccess">
				<strong><?php echo get_option($bsaTrans."alert_success"); ?></strong>
				<p><?php echo get_option($bsaTrans."payment_paid"); ?></p>
			</div>
			<small style="margin-top: -10px;display: block;text-align: center;">
				<a href="<?php echo get_option("bsa_pro_plugin_ordering_form_url") ?>" style="font-size:12px;font-weight: normal;text-decoration: none;">&lt; <?php echo get_option($bsaTrans."payment_return"); ?></a>
			</small>
			<?php
		} else {
			$payments_Stripe 		= ( (get_option("bsa_pro_plugin_secret_key") != '' && get_option("bsa_pro_plugin_publishable_key") != '' && get_option('bsa_pro_plugin_stripe_code') != '') ? 1 : 0 );
			$payments_PayPal 		= ( (get_option("bsa_pro_plugin_paypal") != '' && get_option("bsa_pro_plugin_currency_code") != '') ? 1 : 0 );
			$payments_BankTransfer 	= ( (get_option("bsa_pro_plugin_trans_payment_bank_transfer_content") != '') ? 1 : 0 );
			$payments_WooCommerce 	= ( (bsa_get_opt('settings', 'woo_item') != '') ? 1 : 0 );
			$payments_count = $payments_Stripe + $payments_PayPal + $payments_BankTransfer + $payments_WooCommerce;
			?>
			<div class="bsaProContainerNew bsa-pro-col-<?php echo $payments_count ?>" style="display: block !important">
				<div class="bsaProItems bsaGridGutter">

					<div style="text-align:center;">
						<h2><?php echo get_option($bsaTrans."payment_select"); ?>
							<?php if ( isset($_GET['cid']) ):?>
								(<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($spaceId, $billingModel."_contract_".$_GET['cid']).' '.strtolower($type); ?>)
							<?php endif; ?>
						</h2>
						<small style="margin-top: -10px;display: block;">
							<a href="<?php echo get_option("bsa_pro_plugin_ordering_form_url") ?>" style="font-size:12px;font-weight: normal;text-decoration: none;">&lt; <?php echo get_option($bsaTrans."payment_return"); ?></a>
						</small>
					</div>

					<?php if ( get_option("bsa_pro_plugin_secret_key") != '' && get_option("bsa_pro_plugin_publishable_key") != '' && get_option('bsa_pro_plugin_stripe_code') != '' ): ?>
						<div class="bsaProItem" data-animation="zoomInDown" style="text-align: center; margin-left:0;">
							<? // reset stripe token session
							if ( isset($_SESSION['stripeToken']) ) { unset($_SESSION['stripeToken']); }; ?>
							<h2><?php echo get_option($bsaTrans."payment_stripe_title"); ?></h2>

							<form action="" method="POST">
								<script
									src="https://checkout.stripe.com/checkout.js" class="stripe-button"
									data-key="<?php echo get_option('bsa_pro_plugin_publishable_key') ?>"
									data-amount="<?php echo number_format(bsa_number_format($amount), 2, '', '') ?>"
									data-currency="<?php echo get_option('bsa_pro_plugin_stripe_code') ?>"
									data-item_number="<?php echo $orderId ?>"
									data-name="<?php echo $userEmail ?>"
									data-description="<?php echo $userEmail ?> (<?php echo bsa_number_format($amount) ?>)">
								</script>
							</form>

						</div>
					<?php endif; ?>

					<?php if ( get_option("bsa_pro_plugin_paypal") != '' && get_option("bsa_pro_plugin_currency_code") != '' ): ?>
					<?php $protocol = isset($_SERVER['HTTPS']) === true ? 'https://' : 'http://'; ?>
					<div class="bsaProItem" data-animation="zoomInDown" style="text-align: center; margin-left:0;">
						<h2><?php echo get_option($bsaTrans."payment_paypal_title"); ?></h2>

						<form id="bsa-Pro-PayPal-Payment" action="https://www.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="business" value="<?php echo (get_option("bsa_pro_plugin_purc"."hase_code") != '' && get_option("bsa_pro_plugin_purc"."hase_code") != null) ? get_option("bsa_pro_plugin_paypal") : 'scripteo@gmail.com' ?>">
							<input type="hidden" name="item_name" value="<?php echo $userEmail ?>">
							<input type="hidden" name="item_number" value="<?php echo $orderId ?>">
							<input type="hidden" name="tax" value="0">
							<input type="hidden" name="no_note" value="1">
							<input type="hidden" name="no_shipping" value="1">
							<input type="hidden" name="amount" value="<?php echo bsa_number_format($amount) ?>">
							<input type="hidden" name="custom" value="<?php echo md5($orderId.bsa_number_format($amount)) ?>">
							<input type="hidden" name="currency_code" value="<?php echo get_option("bsa_pro_plugin_currency_code") ?>">
							<input type="hidden" name="return" value="<?php echo $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$checkGET ?>bsa_pro_notice=success">
							<input type="hidden" name="cancel_return" value="<?php echo $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$checkGET ?>bsa_pro_notice=failed">
							<input type="hidden" name="notify_url" value="<?php echo $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$checkGET ?>bsa_pro_payment=notify">
							<input type="image" name="submit" border="0" class="bsaProImgSubmit" src="https://www.paypalobjects.com/webstatic/en_US/logo/pp_cc_mark_111x69.png" alt="PayPal">
						</form>

					</div>
					<?php endif;

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

					if ( get_option("bsa_pro_plugin_trans_payment_bank_transfer_content") != '' ): ?>
					<div class="bsaProItem" data-animation="zoomInDown" style="text-align: center">
						<h2><?php echo get_option($bsaTrans."payment_bank_transfer_title"); ?> (<?php echo $before.bsa_number_format($amount).$after; ?>)</h2>
						<p style="white-space: pre-wrap"><?php echo get_option($bsaTrans."payment_bank_transfer_content"); ?></p>
					</div>
					<?php endif;

					if ( bsa_get_opt('settings', 'woo_item') != '' ): ?>
					<div class="bsaProItem" data-animation="zoomInDown" style="text-align: center">
						<h2><?php echo bsa_get_opt('translations', 'woo_button'); ?> (<?php echo $before.bsa_number_format($amount).$after; ?>)</h2>

						<?php

						// change price
						$getWooItemId 		= bsa_get_opt('settings', 'woo_item');
						bsa_change_product_price( $getWooItemId, bsa_number_format($amount) );

						$_SESSION['bsa_woo_order_id_'.session_id()] = $_GET['oid'];
						$_SESSION['bsa_woo_order_price_'.session_id().$_GET['oid']] = $amount;

						// if item in cart
						if ( bsaCheckInCart($getWooItemId) ) {
							$url = '#';
							if ( function_exists('wc_get_checkout_url') ) {
								$url = wc_get_checkout_url(); // since WC 2.5.0
							}
							echo '<a href="'.$url.'">'.bsa_get_opt('translations', 'woo_button').'</a>';
						} else { // if not
							echo do_shortcode("[add_to_cart id=".$getWooItemId."]");
						}

						?>

					</div>
					<?php endif; ?>

				</div>
			</div>
			<?php
		}

	} else { // Form

		$eid = (isset($_GET['eid']) ? $_GET['eid'] : null);
		$user_info = get_userdata(get_current_user_id());
		if ( isset($user_info->user_email) ) {
			$getUserAds = $model->getUserAds(get_current_user_id(), 'active', $user_info->user_email, 'id');
		} else {
			$getUserAds = null;
		}
		$hasAccess = null;
		if ( is_array($getUserAds) ) {
			foreach ( $getUserAds as $entry ) {
				if ( $entry['id'] == $eid ) {
					$hasAccess = true;
					break;
				}
			}
		}

		if ( !$eid || $eid && $hasAccess || $eid && bsa_role() == 'admin' ) {
			if ( bsa_get_opt('settings', 'form_restrictions') == 'yes' && is_user_logged_in() || bsa_get_opt('settings', 'form_restrictions') != 'yes' ) { // order form
				if ( $space_verify && $spaces ) {
					echo '
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="bsaProInputs bsaProInputsLeft">
							<input type="hidden" name="bsaProAction" value="'.($eid ? 'editAd' : 'buyNewAd').'">
							<input class="bsa_inputs_required" name="inputs_required" type="hidden" value="">
							<h3>'. get_option($bsaTrans.($eid ? 'edit' : 'form')."_left_header").' <span class="bsaLoader bsaLoaderInputs" style="display:none;"></span></h3>
							<div class="bsaProInput'.($eid ? 'Hidden' : '').'" style="'.($eid ? 'display:none' : '').'">
								<label for="bsa_pro_space_id">'. get_option($bsaTrans."form_left_select_space").'</label>
								<div class="bsaProSelectSpace">
									<select id="bsa_pro_space_id" name="space_id">
									';
					foreach ( $spaces as $space ) {
						if ( in_array($space['id'], $space_verify) ) {
							if ( ($model->countAds($space["id"]) < bsa_space($space["id"], 'max_items')) || bsa_space($space["id"], 'max_items') == 1 && get_option('bsa_pro_plugin_calendar') == 'yes' ) {
								echo '<option value="'.$space["id"].'" '.((isset($_POST["space_id"]) && $_POST["space_id"] == $space["id"] or isset($_GET['sid']) && $_GET['sid'] == $space["id"]) ? 'selected="selected"' : "").'>'.$space["name"].'</option>';
							} else {
								echo '<option value="" disabled>'.$space["name"].' ('.$model->countAds($space["id"]).'/'.bsa_space($space["id"], 'max_items').')'.'</option>';
							}
						}
					}
					echo '
									</select>
								</div>
							</div>';

					if ( !$eid ) {
						echo '<div class="bsaProInput">
								<label for="bsa_pro_buyer_email">'. get_option($bsaTrans."form_left_email").'</label>
								<input id="bsa_pro_buyer_email" name="bsa_buyer_email" type="email" value="'.bsaGetPost('bsa_buyer_email').'" placeholder="'.get_option($bsaTrans."form_left_eg_email").'">
							</div>';
					}
					echo '
							<div class="bsaProInput bsa_title_inputs_load" style="display: none">
								<label for="bsa_pro_title">'. get_option($bsaTrans."form_left_title").' (<span class="bsa_pro_sign_title">'.get_option('bsa_pro_plugin_max_title').'</span>)</label>
								<input id="bsa_pro_title" name="bsa_title" type="text" value="'.($eid ? bsa_ad($eid, 'title') : bsaGetPost('bsa_title')).'" placeholder="'.get_option($bsaTrans."form_left_eg_title").'" maxlength="'.get_option('bsa_pro_plugin_max_title').'">
							</div>
							<div class="bsaProInput bsa_desc_inputs_load" style="display: none">
								<label for="bsa_pro_desc">'. get_option($bsaTrans."form_left_desc").' (<span class="bsa_pro_sign_desc">'.get_option('bsa_pro_plugin_max_desc').'</span>)</label>
								<input id="bsa_pro_desc" name="bsa_description" type="text" value="'.($eid ? bsa_ad($eid, 'description') : bsaGetPost('bsa_description')).'" placeholder="'.get_option($bsaTrans."form_left_eg_desc").'" maxlength="'.get_option('bsa_pro_plugin_max_desc').'">
							</div>
							<div class="bsaProInput bsa_button_inputs_load" style="display: none">
								<label for="bsa_pro_button">'. get_option($bsaTrans."form_left_button").' (<span class="bsa_pro_sign_button">'.get_option('bsa_pro_plugin_max_button').'</span>)</label>
								<input id="bsa_pro_button" name="bsa_button" type="text" value="'.($eid ? bsa_ad($eid, 'button') : bsaGetPost('bsa_button')).'" placeholder="'.get_option($bsaTrans."form_left_eg_button").'" maxlength="'.get_option('bsa_pro_plugin_max_button').'">
							</div>
							<div class="bsaProInput bsa_url_inputs_load" style="display: none">
								<label for="bsa_pro_url">'. get_option($bsaTrans."form_left_url").' (<span class="bsa_pro_sign_url">255</span>)</label>
								<input id="bsa_pro_url" name="bsa_url" type="url" value="'.($eid ? bsa_ad($eid, 'url') : bsaGetPost('bsa_url')).'" placeholder="'.get_option($bsaTrans."form_left_eg_url").'" maxlength="255">
							</div>
							<div class="bsaProInput bsa_img_inputs_load" style="display: none">
								<label for="bsa_pro_img">'. get_option($bsaTrans."form_left_thumb").'</label>
								<input type="file" name="bsa_img" id="bsa_pro_img" onchange="bsaPreviewThumb(this)">
							</div>
							';
					if ( bsa_get_opt('order_form', 'optional_field') == 'yes' && !$eid ) {
						echo '
							<div class="bsaProInput">
								<label for="bsa_pro_optional_field">' . bsa_get_trans('order_form', 'optional_field') . '</label>
								<input type="text" class="bsa_pro_optional_field" id="bsa_pro_optional_field" name="bsa_optional_field"  value="'.bsaGetPost('bsa_optional_field').'" placeholder="' . bsa_get_trans('order_form', 'eg_optional_field') . '">
							</div>';
					}
					if ( get_option('bsa_pro_plugin_'.'calendar') == 'yes' && !$eid ) {
						echo '
							<div class="bsaProInput">
								<label for="bsa_pro_calendar">'. get_option($bsaTrans."form_left_calendar").'</label>
								<input type="text" class="bsa_pro_calendar" id="bsa_pro_calendar" name="bsa_calendar"  value="'.bsaGetPost('bsa_calendar').'" placeholder="'.get_option($bsaTrans."form_left_eg_calendar").'">
							</div>';
					}
					echo '
						</div>
						<div class="bsaProInputs bsaProInputsRight">';
					if ( !$eid ) {
						echo '
							<h3>'. get_option($bsaTrans."form_right_header").' <span class="bsaLoader bsaLoaderModels" style="display:none;"></span></h3>
							<div class="bsaGetBillingModels"></div>';
					}
					echo '
							<h3>'. get_option($bsaTrans."form_live_preview").' <span class="bsaLoader bsaLoaderPreview" style="display:none;"></span></h3>
							<div class="bsaTemplatePreview bsaTemplatePreviewForm">
								<div class="bsaTemplatePreviewInner" data-img="'.($eid ? bsa_upload_url(null, bsa_ad($eid, 'img')) : null).'"></div>
							</div>
						</div>
	
						<button type="submit" name="bsaProSubmit" value="1" class="bsaProSubmit clearfix">'.get_option($bsaTrans.($eid ? 'edit' : 'form').'_right_button_pay').'</button>
				</form>
			';
				} else {
					$notice = get_option($bsaTrans."order_form");
					echo $notice['form_notice'];
				}
			} else {
				$notice = get_option($bsaTrans."order_form");
				echo $notice['login_notice'];
			}
		}
	}
echo '
	</div>
</div>';
$getUnavailableDates 	= $model->getUnavailableDates();
?>
<style>
	<?php
		foreach ( $spaces as $space ) {
			$size = explode('--', str_replace('block-', '', $space['template']));
			$width = (isset($size[0]) ? $size[0] : 0);
			$height = (isset($size[1]) ? $size[1] : 0);
			if ( $width > 0 && $height > 0 ) { ?>
				.bsaTemplatePreview .bsa-<?php echo $space['template']; ?> {
					width: <?php echo $width; ?>px;
					height: <?php echo $height; ?>px;
				}
			<?php }
		}
	?>
</style>
<script>
	(function($) {
		$(document).ready(function(){
			var bsaProCalendar = $(".bsa_pro_calendar");
			var sid = $("#bsa_pro_space_id");
			var dates = <?php echo ($getUnavailableDates != null && $getUnavailableDates != '') ? $getUnavailableDates : '' ?>;
			if ( dates ) {
				if ( dates !== '' ) {
					if ( dates !== null ) {
						sid.bind("change",function() {
							bsaProCalendar.datepicker({
								dateFormat : "yy-mm-dd",
								<?php echo (get_option('bsa_pro_plugin_advanced_calendar') != '' ? get_option('bsa_pro_plugin_advanced_calendar') : null) ?>
								isRTL: <?php echo (get_option('bsa_pro_plugin_rtl_support') == 'yes' ? 'true' : 'false' ) ?>,
								minDate: 0,
								beforeShowDay: function(date){
									var string = jQuery.datepicker.formatDate("yy-mm-dd", date);
									return [ dates[sid.val()].indexOf(string) === -1, "bsaProUnavailableDate" ]
								},
								beforeShow: function(input, inst) {
									$('#ui-datepicker-div').addClass('bsaProCalendar');
								}
							});
						});
					}
				}
			} else {
				var d = new Date();
				bsaProCalendar.datepicker({
					dateFormat : "yy-mm-dd",
					<?php echo (get_option('bsa_pro_plugin_advanced_calendar') != '' ? get_option('bsa_pro_plugin_advanced_calendar') : null) ?>
					isRTL: <?php echo (get_option('bsa_pro_plugin_rtl_support') == 'yes' ? 'true' : 'false' ) ?>,
					minDate: 0,
					beforeShowDay: function(date){
						var string = jQuery.datepicker.formatDate("yy-mm-dd", date);
						return [ (d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + (d.getDay() - 1) ).indexOf(string) === -1, "bsaProUnavailableDate" ]
					},
					beforeShow: function(input, inst) {
						$('#ui-datepicker-div').addClass('bsaProCalendar');
					}
				});
			}
			var inputTitle = $("#bsa_pro_title");
			var inputDesc = $("#bsa_pro_desc");
			var inputButton = $("#bsa_pro_button");
			var inputUrl = $("#bsa_pro_url");
			inputTitle.keyup(function() { bsaPreviewInput("title"); });
			inputDesc.keyup(function() { bsaPreviewInput("desc"); });
			inputButton.keyup(function() { bsaPreviewInput("button"); });
			inputUrl.keyup(function() { bsaPreviewInput("url"); });
			sid.bind("change",function() {
				bsaGetBillingModels();
				bsaTemplatePreview();
				$(".bsaUrlSpaceId").html($("#bsa_pro_space_id").val());
			});
			sid.trigger("change");
		});
	})(jQuery);
	function bsaGetBillingModels() {
		(function($) {
			var getBillingModels = $(".bsaGetBillingModels");
			var bsaLoaderModels = $(".bsaLoaderModels");
			getBillingModels.slideUp();
			bsaLoaderModels.fadeIn(400);
			setTimeout(function(){
				$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_get_billing_models_callback",bsa_space_id:$("#bsa_pro_space_id").val(),bsa_order:1}, function(result) {
					getBillingModels.html(result).slideDown();
					bsaLoaderModels.fadeOut(400);
				});
			}, 700);
		})(jQuery);
	}
	function bsaTemplatePreview() {
		(function($) {
			var bsaTemplatePreviewInner = $(".bsaTemplatePreviewInner");
			var bsaLoaderPreview = $(".bsaLoaderPreview");
			bsaTemplatePreviewInner.slideUp(400);
			bsaLoaderPreview.fadeIn(400);
			setTimeout(function(){
				$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_preview_callback",bsa_space_id:$("#bsa_pro_space_id").val(),bsa_ad_id:$("#bsa_pro_ad_id").val()}, function(result) {
					bsaTemplatePreviewInner.html(result).slideDown(400);
					bsaGetRequiredInputs();
					var inputTitle = $("#bsa_pro_title");
					var inputDesc = $("#bsa_pro_desc");
					var inputButton = $("#bsa_pro_button");
					var inputUrl = $("#bsa_pro_url");
					if ( inputTitle.val().length > 0 ) { bsaPreviewInput("title"); }
					if ( inputDesc.val().length > 0 ) { bsaPreviewInput("desc"); }
					if ( inputButton.val().length > 0 ) { bsaPreviewInput("button"); }
					if ( inputUrl.val().length > 0 ) { bsaPreviewInput("url"); }
					bsaLoaderPreview.fadeOut(400);
				});
			}, 700);
		})(jQuery);
	}
	function bsaGetRequiredInputs() {
		(function($) {
			var bsaLoaderInputs = $(".bsaLoaderInputs");
			bsaLoaderInputs.fadeIn(400);
			$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_required_inputs_callback",bsa_space_id:$("#bsa_pro_space_id").val(),bsa_get_required_inputs:1}, function(result) {
				$(".bsa_inputs_required").val($.trim(result));
				if ( result.indexOf("title") !== -1 ) { // show if title required
					$(".bsa_title_inputs_load").fadeIn();
				} else {
					$(".bsa_title_inputs_load").fadeOut();
				}
				if ( result.indexOf("desc") !== -1 ) { // show if description required
					$(".bsa_desc_inputs_load").fadeIn();
				} else {
					$(".bsa_desc_inputs_load").fadeOut();
				}
				if ( result.indexOf("button") !== -1 ) { // show if button required
					$(".bsa_button_inputs_load").fadeIn();
				} else {
					$(".bsa_button_inputs_load").fadeOut();
				}
				if ( result.indexOf("url") !== -1 ) { // show if url required
					$(".bsa_url_inputs_load").fadeIn();
				} else {
					$(".bsa_url_inputs_load").fadeOut();
				}
				if ( result.indexOf("img") !== -1 ) { // show if img required
					$(".bsa_img_inputs_load").fadeIn();
					var bsaTemplatePreviewInner = $('.bsaTemplatePreviewInner');
					if ( bsaTemplatePreviewInner.attr('data-img') ) {
						$(".bsaTemplatePreviewForm .bsaProItemInner__img").css({"background-image" : "url(" + bsaTemplatePreviewInner.attr('data-img') + ")"});
					}
				} else {
					$(".bsa_img_inputs_load").fadeOut();
				}
				if ( result.indexOf("html") !== -1 ) { // show if html required
					$(".bsa_html_inputs_load").fadeIn();
				} else {
					$(".bsa_html_inputs_load").fadeOut();
				}
				bsaLoaderInputs.fadeOut(400);
			});
		})(jQuery);
	}
	function bsaPreviewInput(inputName) {
		(function($){
  			$(document);
			var input = $("#bsa_pro_" + inputName);
			var sign = $(".bsa_pro_sign_" + inputName);
			var limit = input.attr("maxLength");
			var bsaProContainerExample = $(".bsaProContainerExample");
			var exampleTitle = "<?php echo get_option("bsa_pro_plugin_trans_form_left_eg_title") ?>";
			var exampleDesc = "<?php echo get_option("bsa_pro_plugin_trans_form_left_eg_desc") ?>";
			var exampleButton = "<?php echo get_option("bsa_pro_plugin_trans_form_left_eg_button") ?>";
			var exampleUrl = "<?php echo get_option("bsa_pro_plugin_trans_form_left_eg_url") ?>";
			sign.text(limit - input.val().length);
			input.keyup(function() {
				if (input.val().length > limit) {
					input.val($(this).val().substring(0, limit));
				}
			});
			if (input.val().length > 0) {
				if ( inputName === "title" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(input.val());
				} else if ( inputName === "desc" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(input.val());
				} else if ( inputName === "button" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(input.val());
				} else if ( inputName === "url" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html("http://" + input.val().replace("http://","").replace("https://","").replace("www.","").split(/[/?#]/)[0]);
				}
			} else {
				if ( inputName === "title" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(exampleTitle);
				} else if ( inputName === "desc" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(exampleDesc);
				} else if ( inputName === "button" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html(exampleButton);
				} else if ( inputName === "url" ) {
					bsaProContainerExample.find(".bsaProItemInner__" + inputName).html("http://" + exampleUrl.val().replace("http://","").replace("https://","").replace("www.","").split(/[/?#]/)[0]);
				}
			}
		})(jQuery);
	}
	function bsaPreviewThumb(input) {
		(function($){
			if (input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$(".bsaTemplatePreviewForm .bsaProItemInner__img").css({"background-image" : "url(" + e.target.result + ")"});
				};
				reader.readAsDataURL(input.files[0]);
			}
		})(jQuery);
	}
</script>
