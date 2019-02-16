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

function selectedOpt($optName, $optValue)
{
	if(get_option('bsa_pro_plugin_'.$optName) == $optValue) {
		echo 'selected="selected"';
	}
}

function validValue($variableName)
{
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		echo $_POST[$variableName];
	} else {
		echo get_option('bsa_pro_plugin_'.$variableName);
	}
}

function validNewValue($arr, $param)
{
	if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST[$param] != '') {
		echo stripslashes($_POST[$param]);
	} else {
		$getArr = get_option(BSA_PRO_ID.$arr);
		echo stripslashes($getArr[$param]);
	}
}

function ifCheckboxEnabled($variableName)
{
	$getArr = get_option(BSA_PRO_ID.'_settings');
	if ( $variableName == 'woo_item' && $getArr[$variableName] != '' ) {
		echo 'value="1" checked';
	} elseif ( get_option('bsa_pro_plugin_'.$variableName) != '' ) {
		echo 'value="1" checked';
	} else {
		echo 'value="0"';
	}
}

function validSelectedOpt($optName, $optValue)
{
	if ( get_option(BSA_PRO_ID.'_'.$optName) == $optValue || isset($_POST[$optName]) && $_POST[$optName] == $optValue ) {
		echo 'selected="selected"';
	}
}

function validNewSelectedOpt($arr, $param, $value, $type = null)
{
	$getArr = get_option(BSA_PRO_ID.$arr);
	if ( isset($getArr[$param]) && $getArr[$param] == $value || isset($_POST[$param]) && $_POST[$param] == $value ) {
		if ( $type == 'checkbox' ) {
			echo 'checked="checked"';
		} else {
			echo 'selected="selected"';
		}
	}
}
?>
	<h2><i class="dashicons-before dashicons-admin-settings"></i> Settings</h2>

	<h2 class="nav-tab-white nav-tab-wrapper">
		<a href="#bsaPayment" class="nav-tab nav-tab-active" data-group="bsaTabPayment">Payment</a>
		<a href="#bsaReInstallation" class="nav-tab" data-group="bsaTabReInstallation">Re-installation</a>
		<a href="#bsaHooks" class="nav-tab" data-group="bsaTabHooks">Hooks</a>
		<a href="#bsaBuddyPress" class="nav-tab" data-group="bsaTabBuddyPress">BuddyPress</a>
		<a href="#bsaBbPress" class="nav-tab" data-group="bsaTabBbPress">bbPress</a>
		<a href="#bsaNotifications" class="nav-tab" data-group="bsaTabNotifications">Notifications</a>
		<a href="#bsaAdmin" class="nav-tab" data-group="bsaTabAdmin">Admin</a>
		<a href="#bsaMedia" class="nav-tab" data-group="bsaTabMedia">Media</a>
		<a href="#bsaCustomization" class="nav-tab" data-group="bsaTabOrderForm">Customization</a>
		<a href="#bsaAffiliate" class="nav-tab" data-group="bsaTabAffiliateProgram">Affiliate Program Add-on</a>
		<a href="#bsaAddOn" class="nav-tab" data-group="bsaTabMarketingAgency">Marketing Agency Add-on</a>
	</h2>

	<form action="" method="post" novalidate>
		<input type="hidden" value="updateSettings" name="bsaProAction">
		<table class="bsaAdminTable bsaMarTopNull form-table">
			<tbody id="bsaPayment" class="bsaTabPayment bsaTbody">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-cart"></span> Payments Settings</h3>
					</th>
				</tr>
				<tr class="bsaBottomLine">
					<th scope="row"><label for="purchase_code">Purchase Code</label></th>
					<td><input type="text" class="regular-text code" value="<?php validValue('purchase_code'); ?>" id="purchase_code" name="purchase_code">
						<p class="description"><strong style="<?php echo ((validValue('purchase_code') != '') ? '' : 'color:red') ?>">This field is required to unlock all features!</strong> You can download it from <a href="http://codecanyon.net/item/ads-pro-multipurpose-wordpress-ad-manager/10275010?ref=scripteo">CodeCanyon</a></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="paypal">PayPal E-mail</label>
						<div class="switch-wrapper"><input class="bsaSwitch" data-section="bsa-paypal-section" type="checkbox" <?php ifCheckboxEnabled('paypal'); ?>></div>
					</th>
					<td><input type="text" class="regular-text code bsa-paypal-section bsa-paypal-section-input" value="<?php validValue('paypal'); ?>" id="paypal" name="paypal">
						<p class="description bsa-paypal-section">At this address you will receive PayPal payments.</p></td>
				</tr>
				<tr>
					<th scope="row"><label for="secret_key">Stripe Secret Key</label>
						<div class="switch-wrapper"><input class="bsaSwitch" data-section="bsa-stripe-section" type="checkbox" <?php ifCheckboxEnabled('secret_key'); ?>></div>
					</th>
					<td><input type="text" class="regular-text ltr bsa-stripe-section bsa-stripe-section-input" value="<?php validValue('secret_key'); ?>" id="stripe_code" name="secret_key">
						<p class="description bsa-stripe-section">Stripe > Your account > Account Settings > API Keys</p></td>
				</tr>
				<tr class="bsa-stripe-section">
					<th scope="row"><label for="publishable_key">Stripe Publishable Key</label></th>
					<td><input type="text" class="regular-text ltr bsa-stripe-section-input" value="<?php validValue('publishable_key'); ?>" id="publishable_key" name="publishable_key">
						<p class="description">Stripe > Your account > Account Settings > API Keys</p></td>
				</tr>
				<tr>
					<th scope="row"><label for="bank_transfer_content">Bank Transfer Details</label>
						<div class="switch-wrapper"><input class="bsaSwitch" data-section="bsa-bank-section" type="checkbox" <?php ifCheckboxEnabled('trans_payment_bank_transfer_content'); ?>></div>
					</th>
					<td>
						<textarea id="bank_transfer_content" name="trans_payment_bank_transfer_content" class="regular-text bsa-bank-section bsa-bank-section-input" rows="3" cols="40"><?php validValue('trans_payment_bank_transfer_content'); ?></textarea>
					</td>
				</tr>
				<tr class="bsaBottomLine">
					<th scope="row"><label for="woo_item">WooCommerce</label>
						<div class="switch-wrapper"><input class="bsaSwitch" data-section="bsa-woocommerce-section" type="checkbox" <?php ifCheckboxEnabled('woo_item'); ?>></div>
					</th>
					<td>
						<select id="woo_item" name="woo_item" class="bsa-woocommerce-section bsa-woocommerce-section-input">
							<option value="">Empty</option>
							<?php
							$args 		= array( 'post_type' => 'product', 'post_status' => 'publish', 'numberposts' => -1 );
							$products 	= get_posts( $args );
							foreach ($products as $entry) {
								$get_post_meta = get_post_meta($entry->ID, '_sold_individually');
								if ( $get_post_meta[0] == 'yes' ) {
									?><option value="<?php echo $entry->ID; ?>" <?php validNewSelectedOpt('_settings', 'woo_item', $entry->ID); ?>><?php echo $entry->post_title; ?> (ID: <?php echo $entry->ID; ?>)</option><?php
								}
							} ?>
						</select>
						<p class="description bsa-woocommerce-section">Choose WooCommerce item. Item will be used in the cart.</p></td>
				</tr>
				<tr>
					<th scope="row"><label for="ordering_form_url">URL to the Order Form</label></th>
					<td><input type="url" class="regular-text code" maxlength="1000" value="<?php validValue('ordering_form_url'); ?>" id="ordering_form_url" name="ordering_form_url">
						<p class="description">Order Form you can display by shortcode <strong>[bsa_pro_form_and_stats]</strong></p>
						<p class="description"><strong>Example</strong> http://your_page.com/order_ads</p></td>
				</tr>
				<tr class="bsa-paypal-section">
					<th scope="row"><label for="currency_code">PayPal Currency Code</label></th>
					<td><input type="text" class="regular-text ltr bsa-paypal-section" value="<?php echo get_option('bsa_pro_plugin_'.'currency_code') ?>" id="currency_code" name="currency_code">
						<p class="description bsa-paypal-section">More information about PayPal Currency Codes <a href="https://developer.paypal.com/docs/classic/api/currency_codes/">here</a>.</p></td>
				</tr>
				<tr class="bsa-stripe-section">
					<th scope="row"><label for="stripe_code">Stripe Currency Code</label></th>
					<td><input type="text" class="regular-text ltr bsa-stripe-section" value="<?php echo get_option('bsa_pro_plugin_'.'stripe_code') ?>" id="stripe_code" name="stripe_code">
						<p class="description bsa-stripe-section">More information about Stripe Currency Codes <a href="https://support.stripe.com/questions/which-currencies-does-stripe-support">here</a>.</p></td>
				</tr>
				<tr>
					<th scope="row"><label for="currency_symbol">Currency symbol</label></th>
					<td><input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'currency_symbol') ?>" id="currency_symbol" name="currency_symbol"></td>
				</tr>
				<tr>
					<th scope="row">Price format (symbol position)</th>
					<td>
						<fieldset>
							<label title="symbol before"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'symbol_position') == 'before') { echo 'checked="checked"'; } ?> value="before" name="symbol_position"><strong>before</strong> price <span>(eg. <strong>$10</strong>)</span></label><br>
							<label title="symbol after"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'symbol_position') == 'after') { echo 'checked="checked"'; } ?>value="after" name="symbol_position"><strong>after</strong> price <span>(eg. <strong>10$</strong>)</span></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Auto-Accept Ads</th>
					<td>
						<fieldset>
							<label title="auto accept ads after purchase"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'auto_accept') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="auto_accept"><strong>yes</strong></label><br>
							<label title="do not accept ads automatically"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'auto_accept') == 'no') { echo 'checked="checked"'; } ?>value="no" name="auto_accept"><strong>no</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Show the Order Form only for logged in users</th>
					<td>
						<fieldset>
							<label title="yes"><input type="radio" <?php if(bsa_get_opt('settings', 'form_restrictions') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="form_restrictions"><strong>yes</strong></label><br>
							<label title="no"><input type="radio" <?php if(bsa_get_opt('settings', 'form_restrictions') == 'no') { echo 'checked="checked"'; } ?>value="no" name="form_restrictions"><strong>no</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Show optional field in the Order Form</th>
					<td>
						<fieldset>
							<label title="show optional field in the order form"><input type="radio" <?php if(bsa_get_opt('order_form', 'optional_field') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="optional_field"><strong>yes</strong></label><br>
							<label title="hide optional field in the order form"><input type="radio" <?php if(bsa_get_opt('order_form', 'optional_field') == 'no') { echo 'checked="checked"'; } ?>value="no" name="optional_field"><strong>no</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th class="bsaLast" scope="row">Show calendar in the Order Form</th>
					<td class="bsaLast">
						<fieldset>
							<label title="show calendar in the order form"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'calendar') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="calendar"><strong>yes</strong></label><br>
							<label title="hide calendar in the order form"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'calendar') == 'no') { echo 'checked="checked"'; } ?>value="no" name="calendar"><strong>no</strong></label>
						</fieldset>
					</td>
				</tr>
			</tbody>
			<tbody id="bsaReInstallation" class="bsaTabReInstallation bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-admin-plugins"></span> Re-installation</h3>
				</th>
			</tr>
			<tr>
				<th class="bsaLast" scope="row">Delete all the data when uninstalling?</th>
				<td class="bsaLast">
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'installation') == 'no') { echo 'checked="checked"'; } ?> value="no" name="installation"><strong>no</strong>, keep all added spaces and ads</label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'installation') == 'yes') { echo 'checked="checked"'; } ?>value="yes" name="installation"><strong>yes</strong>, remove all data (spaces and ads)</label>
					</fieldset>
				</td>
			</tr>
			</tbody>
			<tbody id="bsaHooks" class="bsaTabHooks bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-editor-insertmore"></span> Hooks</h3>
				</th>
			</tr>
			<tr>
				<th scope="row"><label for="before_hook">Show Ads before content</label></th>
				<td>
					<textarea id="before_hook" name="before_hook" class="regular-text ltr" rows="7" cols="50"><?php echo get_site_option('bsa_pro_plugin_'.'before_hook'); ?></textarea>
					<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
				</td>
			</tr>
			<?php for ($i = 1; $i <= 10; $i++): ?>
				<tr>
					<th scope="row"><label for="after_<?php echo $i ?>_paragraph">Show Ads after #<?php echo $i ?> paragraph<br> <small>&lt;/p&gt; tag closing each paragraph</small></label></th>
					<td>
						<textarea id="after_<?php echo $i ?>_paragraph" name="after_<?php echo $i ?>_paragraph" class="regular-text ltr" rows="1" cols="50"><?php echo get_site_option('bsa_pro_plugin_'.'after_' . $i . '_paragraph'); ?></textarea>
						<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
					</td>
				</tr>
			<?php endfor; ?>
			<tr>
				<th class="bsaLast" scope="row"><label for="after_hook">Show Ads after content</label></th>
				<td class="bsaLast">
					<textarea id="after_hook" name="after_hook" class="regular-text ltr" rows="7" cols="50"><?php echo get_site_option('bsa_pro_plugin_'.'after_hook'); ?></textarea>
					<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
				</td>
			</tr>
			</tbody>
			<tbody id="bsaBuddyPress" class="bsaTabBuddyPress bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-editor-insertmore"></span> BuddyPress Hooks</h3>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<h3>Stream (ads after activities)</h3>
				</th>
			</tr>
			<?php for ($i = 1; $i <= 20; $i++): ?>
				<tr>
					<th scope="row"><label for="after_<?php echo $i ?>_activity">Show Ads after #<?php echo $i ?> activity</label></th>
					<td>
						<textarea id="after_<?php echo $i ?>_activity" name="after_<?php echo $i ?>_activity" class="regular-text ltr" rows="1" cols="50"><?php echo bsa_get_opt('bp_stream_hook', $i); ?></textarea>
						<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
					</td>
				</tr>
			<?php endfor; ?>
			</tbody>
			<tbody id="bsaBbPress" class="bsaTabBbPress bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-editor-insertmore"></span> bbPress Hooks</h3>
				</th>
			</tr>
			<tr>
				<th colspan="2">
					<h3>Forum (ads after topics)</h3>
				</th>
			</tr>
			<?php for ($i = 1; $i <= get_option( '_bbp_topics_per_page', '15' ); $i++): ?>
				<tr>
					<th scope="row"><label for="after_<?php echo $i ?>_topic">Show Ads after #<?php echo $i ?> topic</label></th>
					<td>
						<textarea id="after_<?php echo $i ?>_topic" name="after_<?php echo $i ?>_topic" class="regular-text ltr" rows="1" cols="50"><?php echo bsa_get_opt('bbp_forum_hook', $i); ?></textarea>
						<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
					</td>
				</tr>
			<?php endfor; ?>
			<tr>
				<th colspan="2">
					<h3>Topic (ads after replies)</h3>
				</th>
			</tr>
			<?php for ($i = 1; $i <= get_option( '_bbp_replies_per_page', '15' ); $i++): ?>
				<tr>
					<th scope="row"><label for="after_<?php echo $i ?>_reply">Show Ads after #<?php echo $i ?> reply</label></th>
					<td>
						<textarea id="after_<?php echo $i ?>_reply" name="after_<?php echo $i ?>_reply" class="regular-text ltr" rows="1" cols="50"><?php echo bsa_get_opt('bbp_topic_hook', $i); ?></textarea>
						<p class="description"><strong>Example:</strong> separate semicolon <strong>;</strong><br>[bsa_pro_ad_space id="1"] ; [bsa_pro_ad_space id="2"] ; [bsa_pro_ad_space id="3"]</p>
					</td>
				</tr>
			<?php endfor; ?>
			</tbody>
			<tbody id="bsaNotifications" class="bsaTabNotifications bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-microphone"></span> Notifications</h3>
				</th>
			</tr>
			<tr>
				<th scope="row">Send email reminder to the Buyer if expires Ads</th>
				<td>
					<fieldset>
						<label title="yes"><input type="radio" <?php validNewSelectedOpt('_settings', 'up_expires_notice', 'yes', 'checkbox'); ?> value="yes" name="up_expires_notice"><strong>yes</strong></label><br>
						<label title="no"><input type="radio" <?php validNewSelectedOpt('_settings', 'up_expires_notice', 'no', 'checkbox'); ?>value="no" name="up_expires_notice"><strong>no</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Send email reminder to the Buyer if expired Ads</th>
				<td>
					<fieldset>
						<label title="yes"><input type="radio" <?php validNewSelectedOpt('_settings', 'up_expired_notice', 'yes', 'checkbox'); ?> value="yes" name="up_expired_notice"><strong>yes</strong></label><br>
						<label title="no"><input type="radio" <?php validNewSelectedOpt('_settings', 'up_expired_notice', 'no', 'checkbox'); ?>value="no" name="up_expired_notice"><strong>no</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="up_cpc_notice">Send CPC email reminder if less than</label></th>
				<td>
					<select id="up_cpc_notice" name="up_cpc_notice">
						<option value="5" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 5); ?>>5 clicks to the end</option>
						<option value="6" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 6); ?>>6 clicks to the end</option>
						<option value="7" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 7); ?>>7 clicks to the end</option>
						<option value="8" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 8); ?>>8 clicks to the end</option>
						<option value="9" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 9); ?>>9 clicks to the end</option>
						<option value="10" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 10); ?>>10 clicks to the end</option>
						<option value="15" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 15); ?>>15 clicks to the end</option>
						<option value="20" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 20); ?>>20 clicks to the end</option>
						<option value="30" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 30); ?>>30 clicks to the end</option>
						<option value="40" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 40); ?>>40 clicks to the end</option>
						<option value="50" <?php validNewSelectedOpt('_settings', 'up_cpc_notice', 50); ?>>50 clicks to the end</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="up_cpm_notice">Send CPM email reminder if less than</label></th>
				<td>
					<select id="up_cpm_notice" name="up_cpm_notice">
						<option value="100" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 100); ?>>100 views to the end</option>
						<option value="250" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 250); ?>>250 views to the end</option>
						<option value="500" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 500); ?>>500 views to the end</option>
						<option value="1000" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 1000); ?>>1000 views to the end</option>
						<option value="2500" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 2500); ?>>2500 views to the end</option>
						<option value="5000" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 5000); ?>>5000 views to the end</option>
						<option value="7500" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 7500); ?>>7500 views to the end</option>
						<option value="10000" <?php validNewSelectedOpt('_settings', 'up_cpm_notice', 10000); ?>>10000 views to the end</option>
					</select>
				</td>
			</tr>
			<tr>
				<th class="bsaLast" scope="row"><label for="up_cpd_notice">Send CPD email reminder if less than</label></th>
				<td class="bsaLast">
					<select id="up_cpd_notice" name="up_cpd_notice">
						<option value="2" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 2); ?>>2 days to the end</option>
						<option value="3" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 3); ?>>3 days to the end</option>
						<option value="4" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 4); ?>>4 days to the end</option>
						<option value="5" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 5); ?>>5 days to the end</option>
						<option value="6" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 6); ?>>6 days to the end</option>
						<option value="7" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 7); ?>>7 days to the end</option>
						<option value="8" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 8); ?>>8 days to the end</option>
						<option value="9" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 9); ?>>9 days to the end</option>
						<option value="10" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 10); ?>>10 days to the end</option>
						<option value="14" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 14); ?>>14 days to the end</option>
						<option value="21" <?php validNewSelectedOpt('_settings', 'up_cpd_notice', 21); ?>>21 days to the end</option>
					</select>
				</td>
			</tr>
			</tbody>
			<tbody id="bsaAdmin" class="bsaTabAdmin bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-admin-settings"></span> Admin</h3>
				</th>
			</tr>
			<tr>
				<th scope="row"><label for="username">Envato Affiliate - Username</label></th>
				<td><input type="text" class="regular-text ltr" value="<?php validValue('username'); ?>" id="username" name="username">
					<p class="description">
						<strong>Paste your username to earn more on Envato Affiliate Program</strong>
						<br>Referral Link will shown at the bottom of Ad Space. <a target="_blank" href="https://codecanyon.net/affiliate_program">Learn more</a> about Affiliate Program
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Users can edit Ads in the frontend / backend panel</th>
				<td>
					<fieldset>
						<label title="backend"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'editable') == 'backend') { echo 'checked="checked"'; } ?> value="backend" name="editable"><strong>backend</strong></label><br>
						<label title="frontend"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'editable') == 'frontend') { echo 'checked="checked"'; } ?> value="frontend" name="editable"><strong>frontend</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">RTL Support</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'rtl_support') == 'no') { echo 'checked="checked"'; } ?> value="no" name="rtl_support"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'rtl_support') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="rtl_support"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Disable preview for HTML Ad</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'html_preview') == 'no') { echo 'checked="checked"'; } ?> value="no" name="html_preview"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'html_preview') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="html_preview"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Hide all ads for logged users</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'hide_if_logged') == 'no') { echo 'checked="checked"'; } ?> value="no" name="hide_if_logged"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'hide_if_logged') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="hide_if_logged"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Disable Admin Bar link</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'link_bar') == 'no') { echo 'checked="checked"'; } ?> value="no" name="link_bar"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'link_bar') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="link_bar"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Selection method of Ad Spaces</th>
				<td>
					<fieldset>
						<label title="tabs"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'selection') == 'tabs') { echo 'checked="checked"'; } ?> value="tabs" name="selection"><strong>tabs</strong></label><br>
						<label title="select"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'selection') == 'select') { echo 'checked="checked"'; } ?> value="select" name="selection"><strong>select</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Show an Ad Name field on the list</th>
				<td>
					<fieldset>
						<label title="yes"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'ad_name') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="ad_name"><strong>yes</strong></label><br>
						<label title="no"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'ad_name') == 'no') { echo 'checked="checked"'; } ?>value="no" name="ad_name"><strong>no</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Use rel="nofollow" attribute for all links</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'nofollow') == 'no') { echo 'checked="checked"'; } ?> value="no" name="nofollow"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(bsa_get_opt('admin_settings', 'nofollow') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="nofollow"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row">Show Coundown inside Ads</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(bsa_get_opt('other', 'countdown') == 'no') { echo 'checked="checked"'; } ?> value="no" name="countdown"><strong>no</strong></label><br>
						<label title="yes"><input type="radio" <?php if(bsa_get_opt('other', 'countdown') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="countdown"><strong>yes</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="clicks_counter">Change Click Dashboard Counter</label></th>
				<td>
					<input type="number" class="regular-text ltr" value="" id="clicks_counter" name="clicks_counter">
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="views_counter">Change Views Dashboard Counter</label></th>
				<td>
					<input type="number" class="regular-text ltr" value="" id="views_counter" name="views_counter">
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="upload_dir">Upload DIR <br>(as default keep it empty)</label></th>
				<td>
					<input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'upload_dir') ?>" id="upload_dir" name="upload_dir">
					<p class="description"><strong>Use this option carefully because this option affect on upload folder.</strong><br>(default: bsa-pro-upload)</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="prefix">Cache Prefix <br>(as default keep it empty)</label></th>
				<td>
					<input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'prefix') ?>" id="prefix" name="prefix">
					<p class="description">Use unique prefix for each site if you are using multiple wordpress installation with the one domain.</p>
				</td>
			</tr>
			<tr>
				<th class="bsaLast" scope="row"><label for="privileges">Access as Admin for Users with Capability</label></th>
				<td class="bsaLast">
					<input type="text" class="regular-text ltr" value="<?php echo bsa_get_opt('admin_settings', 'privileges') ?>" id="privileges" name="privileges">
					<p class="description"><strong>Use this option carefully because you can give access by unauthorized users.</strong><br>(e.g. manage_option,install_plugins)</p><br><br>
				</td>

			</tr>
			</tbody>
			<tbody id="bsaMedia" class="bsaTabMedia bsaTbody" style="display:none">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-format-image"></span> File & Ads</h3>
					</th>
				</tr>
				<tr>
					<th scope="row">Example Ad if empty Ad Space</th>
					<td>
						<fieldset>
							<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'example_ad') == 'no') { echo 'checked="checked"'; } ?> value="no" name="example_ad"><strong>no</strong></label><br>
							<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'example_ad') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="example_ad"><strong>yes</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Optimize All Images (crop tool)</th>
					<td>
						<fieldset>
							<label title="yes, gif animations will not be available"><input type="radio" <?php if(bsa_get_opt('other', 'crop_tool') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="crop_tool"><strong>yes</strong>, gif animations will not be available</label><br>
							<label title="no, gif animations will be available"><input type="radio" <?php if(bsa_get_opt('other', 'crop_tool') == 'no') { echo 'checked="checked"'; } ?>value="no" name="crop_tool"><strong>no</strong>, gif animations will  be available</label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Optimize All CSS files into One</th>
					<td>
						<fieldset>
							<label title="no"><input type="radio" <?php if(bsa_get_opt('other', 'optimization') == 'no') { echo 'checked="checked"'; } ?> value="no" name="optimization"><strong>no</strong></label><br>
							<label title="yes"><input type="radio" <?php if(bsa_get_opt('other', 'optimization') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="optimization"><strong>yes</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Carousel Script for Slider</th>
					<td>
						<fieldset>
							<label title="owl"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'carousel_script') == 'owl') { echo 'checked="checked"'; } ?> value="owl" name="carousel_script"><strong>owlCarousel</strong></label><br>
							<label title="bx"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'carousel_script') == 'bx') { echo 'checked="checked"'; } ?> value="bx" name="carousel_script"><strong>bxSlider</strong></label>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="thumb_size">Maximum upload file size <br>(default 400kb)</label></th>
					<td><input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'thumb_size') ?>" id="thumb_size" name="thumb_size"> <abbr title="kilobyte">kb</abbr></td>
				</tr>
				<tr>
					<th scope="row"><label for="thumb_w">Image, maximum width <br>(default 1024px)</label></th>
					<td><input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'thumb_w') ?>" id="thumb_w" name="thumb_w"> <abbr title="pixels">px</abbr></td>
				</tr>
				<tr class="bsaBottomLine">
					<th class="bsaLast" scope="row"><label for="thumb_h">Image, maximum height <br>(default 800px)</label></th>
					<td class="bsaLast"><input type="text" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'thumb_h') ?>" id="thumb_h" name="thumb_h"> <abbr title="pixels">px</abbr></td>
				</tr>
<!--				<tr>-->
<!--					<th scope="row"><label for="max_title">Maximum length of Ad Title</label></th>-->
<!--					<td><input type="text" class="regular-text ltr" value="--><?php //echo get_option('bsa_pro_plugin_'.'max_title') ?><!--" id="max_title" name="max_title"> <abbr>(40-70 characters)</abbr></td>-->
<!--				</tr>-->
<!--				<tr>-->
<!--					<th scope="row"><label for="max_desc">Maximum length of Ad Description</label></th>-->
<!--					<td><input type="text" class="regular-text ltr" value="--><?php //echo get_option('bsa_pro_plugin_'.'max_desc') ?><!--" id="max_desc" name="max_desc"> <abbr>(80-140 characters)</abbr></td>-->
<!--				</tr>-->
			</tbody>
			<tbody id="bsaCustomization" class="bsaTabOrderForm bsaTbody" style="display:none">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> Order Form Customization</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="form_bg">Form Background</label></th>
					<td>
						<input id="form_bg"
							   name="form_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_bg') ?>"
							   data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_c">Form Text Color</label></th>
					<td>
						<input id="form_c"
							   name="form_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_c') ?>"
							   data-default-color="#444444" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_input_bg">Input Background</label></th>
					<td>
						<input id="form_input_bg"
							   name="form_input_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_input_bg') ?>"
							   data-default-color="#f5f5f5" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_input_c">Input Color</label></th>
					<td>
						<input id="form_input_c"
							   name="form_input_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_input_c') ?>"
							   data-default-color="#444444" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_price_c">Price Color</label></th>
					<td>
						<input id="form_price_c"
							   name="form_price_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_price_c') ?>"
							   data-default-color="#65cc84" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_discount_bg">Discount Background</label></th>
					<td>
						<input id="form_discount_bg"
							   name="form_discount_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_discount_bg') ?>"
							   data-default-color="#df5050" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_discount_c">Discount Color</label></th>
					<td>
						<input id="form_discount_c"
							   name="form_discount_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_discount_c') ?>"
							   data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_button_bg">Button Background</label></th>
					<td>
						<input id="form_button_bg"
							   name="form_button_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_button_bg') ?>"
							   data-default-color="#65cc84" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_button_c">Button Color</label></th>
					<td>
						<input id="form_button_c"
							   name="form_button_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_button_c') ?>"
							   data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> Alert Colors</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="form_alert_c">Alert Text Color</label></th>
					<td>
						<input id="form_alert_c"
							   name="form_alert_c"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_alert_c') ?>"
							   data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_alert_success_bg">Success Background</label></th>
					<td>
						<input id="form_alert_success_bg"
							   name="form_alert_success_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_alert_success_bg') ?>"
							   data-default-color="#65cc84" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="form_alert_failed_bg">Failed Background</label></th>
					<td>
						<input id="form_alert_failed_bg"
							   name="form_alert_failed_bg"
							   value="<?php echo get_option('bsa_pro_plugin_'.'form_alert_failed_bg') ?>"
							   data-default-color="#df5050" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> Chart Colors</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="stats_views_line">Stats Views Color</label></th>
					<td>
						<input id="stats_views_line"
							   name="stats_views_line"
							   value="<?php echo get_option('bsa_pro_plugin_'.'stats_views_line') ?>"
							   data-default-color="#673AB7" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="stats_clicks_line">Stats Clicks Color</label></th>
					<td>
						<input id="stats_clicks_line"
							   name="stats_clicks_line"
							   value="<?php echo get_option('bsa_pro_plugin_'.'stats_clicks_line') ?>"
							   data-default-color="#FBCD39" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> Affiliate Program Customization</h3>
					</th>
				</tr>
				<?php $opt = 'ap_custom'; ?>
				<tr>
					<th scope="row"><label for="general_bg">General Background</label></th>
					<td>
						<input id="general_bg" name="general_bg" value="<?php echo bsa_get_opt($opt, 'general_bg') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="general_color">General Color</label></th>
					<td>
						<input id="general_color" name="general_color" value="<?php echo bsa_get_opt($opt, 'general_color') ?>" data-default-color="#000000" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="commission_bg">Commission Section - Background</label></th>
					<td>
						<input id="commission_bg" name="commission_bg" value="<?php echo bsa_get_opt($opt, 'commission_bg') ?>" data-default-color="#673ab7" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="commission_color">Commission Section - Color</label></th>
					<td>
						<input id="commission_color" name="commission_color" value="<?php echo bsa_get_opt($opt, 'commission_color') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="balance_bg">Balance Section - Background</label></th>
					<td>
						<input id="balance_bg" name="balance_bg" value="<?php echo bsa_get_opt($opt, 'balance_bg') ?>" data-default-color="#8e6acf" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="balance_color">Balance Section - Color</label></th>
					<td>
						<input id="balance_color" name="balance_color" value="<?php echo bsa_get_opt($opt, 'balance_color') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="link_color">Balance Link Color</label></th>
					<td>
						<input id="link_color" name="link_color" value="<?php echo bsa_get_opt($opt, 'link_color') ?>" data-default-color="#ffd71a" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ref_bg">Referral Section - Background</label></th>
					<td>
						<input id="ref_bg" name="ref_bg" value="<?php echo bsa_get_opt($opt, 'ref_bg') ?>" data-default-color="#ffd71a" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ref_color">Referral Section - Color</label></th>
					<td>
						<input id="ref_color" name="ref_color" value="<?php echo bsa_get_opt($opt, 'ref_color') ?>" data-default-color="#000000" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="table_bg">Table Section - Background</label></th>
					<td>
						<input id="table_bg" name="table_bg" value="<?php echo bsa_get_opt($opt, 'table_bg') ?>" data-default-color="#ffd71a" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="table_color">Table Section - Color</label></th>
					<td>
						<input id="table_color" name="table_color" value="<?php echo bsa_get_opt($opt, 'table_color') ?>" data-default-color="#000000" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> User Panel Customization</h3>
					</th>
				</tr>
				<?php $opt = 'user_panel'; ?>
				<tr>
					<th scope="row"><label for="head_bg">Head Background</label></th>
					<td>
						<input id="head_bg" name="head_bg" value="<?php echo bsa_get_opt($opt, 'head_bg') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="head_color">Head Color</label></th>
					<td>
						<input id="head_color" name="head_color" value="<?php echo bsa_get_opt($opt, 'head_color') ?>" data-default-color="#000000" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="body_bg">Body Background</label></th>
					<td>
						<input id="body_bg" name="body_bg" value="<?php echo bsa_get_opt($opt, 'body_bg') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="body_color">Body Color</label></th>
					<td>
						<input id="body_color" name="body_color" value="<?php echo bsa_get_opt($opt, 'body_color') ?>" data-default-color="#000000" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="separator">Separator</label></th>
					<td>
						<input id="separator" name="separator" value="<?php echo bsa_get_opt($opt, 'separator') ?>" data-default-color="#ededed" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="link_color">Link Color</label></th>
					<td>
						<input id="link_color" name="link_color" value="<?php echo bsa_get_opt($opt, 'link_color') ?>" data-default-color="#21759b" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="pending_bg">Pending Status - Background</label></th>
					<td>
						<input id="pending_bg" name="pending_bg" value="<?php echo bsa_get_opt($opt, 'pending_bg') ?>" data-default-color="#999" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="pending_color">Pending Status - Color</label></th>
					<td>
						<input id="pending_color" name="pending_color" value="<?php echo bsa_get_opt($opt, 'pending_color') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="active_bg">Active Status - Background</label></th>
					<td>
						<input id="active_bg" name="active_bg" value="<?php echo bsa_get_opt($opt, 'active_bg') ?>" data-default-color="#4DA720" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="active_color">Active Status - Color</label></th>
					<td>
						<input id="active_color" name="active_color" value="<?php echo bsa_get_opt($opt, 'active_color') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="expired_bg">Expired Status - Background</label></th>
					<td>
						<input id="expired_bg" name="expired_bg" value="<?php echo bsa_get_opt($opt, 'expired_bg') ?>" data-default-color="#FF2A13" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="expired_color">Expired Status - Color</label></th>
					<td>
						<input id="expired_color" name="expired_color" value="<?php echo bsa_get_opt($opt, 'expired_color') ?>" data-default-color="#FFFFFF" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_bg">Button - Background</label></th>
					<td>
						<input id="button_bg" name="button_bg" value="<?php echo bsa_get_opt($opt, 'button_bg') ?>" data-default-color="#673ab7" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="button_color">Button - Color</label></th>
					<td>
						<input id="button_color" name="button_color" value="<?php echo bsa_get_opt($opt, 'button_color') ?>" data-default-color="#ffd71a" type="text" class="bsaColorPicker">
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-admin-appearance"></span> Custom CSS / JS</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="custom_css">Custom CSS</label></th>
					<td>
						<textarea id="custom_css" name="custom_css" class="regular-text ltr" rows="17" cols="70"><?php echo get_option('bsa_pro_plugin_'.'custom_css') ?></textarea>
					</td>
				</tr>
				<tr>
					<th class="bsaLast" scope="row"><label for="custom_js">Custom JavaScript</label></th>
					<td class="bsaLast">
						<textarea id="custom_js" name="custom_js" class="regular-text ltr" rows="17" cols="70"><?php echo get_option('bsa_pro_plugin_'.'custom_js') ?></textarea>
					</td>
				</tr>
				<?php if ( get_option('bsa_pro_plugin_calendar') == 'yes' ): ?>
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-calendar-alt"></span> Calendar Advanced Settings</h3>
					</th>
				</tr>
				<tr>
					<th class="bsaLast" scope="row"><label for="advanced_calendar">Custom JavaScript</label></th>
					<td class="bsaLast">
						<textarea id="advanced_calendar" name="advanced_calendar" class="regular-text ltr" rows="17" cols="140"><?php echo get_option('bsa_pro_plugin_'.'advanced_calendar') ?></textarea>
					</td>
				</tr>
				<?php endif; ?>
			</tbody>
			<tbody id="bsaAffiliate" class="bsaTabAffiliateProgram bsaTbody" style="display:none">
				<tr>
					<th colspan="2">
						<h3><span class="dashicons dashicons-cart"></span> Affiliate Program Settings (<a href="http://codecanyon.net/user/scripteo?ref=scripteo">Affiliate Program Add-on</a>)</h3>
					</th>
				</tr>
				<tr>
					<th scope="row"><label for="ap_cookie_lifetime">Cookie Lifetime</label></th>
					<td>
						<select id="ap_cookie_lifetime" name="ap_cookie_lifetime">
							<?php

							for ($i = 10; $i <= 90; $i++) {
								echo $i;
								if ( $i <= 10 || $i == 15 || $i == 20 || $i == 25 || $i == 30 || $i == 40 || $i == 50 || $i == 60 || $i == 70 || $i == 80 || $i == 90 ) {
									?>
									<option value="<?php echo $i; ?>" <?php validSelectedOpt('ap_cookie_lifetime', $i); ?>> <?php echo $i; ?> <?php if($i == 1) { echo 'day'; } else { echo 'days'; } ?></option>
								<?php
								}
							}

							?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ap_commission">Affiliate Commission</label></th>
					<td><input type="number" class="regular-text code" value="<?php echo get_option('bsa_pro_plugin_'.'ap_commission'); ?>" id="ap_commission" name="ap_commission"> <abbr title="percent">%</abbr></td>
				</tr>
				<tr class="bsaBottomLine">
					<th class="bsaLast" scope="row"><label for="ap_minimum_withdrawal">Minimum amount for Withdrawal</label></th>
					<td class="bsaLast"><?php echo $before ?><input type="number" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'ap_minimum_withdrawal'); ?>" id="ap_minimum_withdrawal" name="ap_minimum_withdrawal"> <?php echo $after ?></td>
				</tr>
			</tbody>
			<tbody id="bsaAddOn" class="bsaTabMarketingAgency bsaTbody" style="display:none">
			<tr>
				<th colspan="2">
					<h3><span class="dashicons dashicons-cart"></span> Marketing Agency Settings (<a href="http://codecanyon.net/item/ads-pro-1-wordpress-marketing-agency-addon/10665901?ref=scripteo">Marketing Agency Add-on</a>)</h3>
				</th>
			</tr>
			<tr>
				<th scope="row">Privacy<br>(who can add sites to a marketing agency)</th>
				<td>
					<fieldset>
						<label title="no"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'private_ma') == 'no') { echo 'checked="checked"'; } ?> value="no" name="private_ma"><strong>public</strong>, users can add their sites</label><br>
						<label title="yes"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'private_ma') == 'yes') { echo 'checked="checked"'; } ?>value="yes" name="private_ma"><strong>private</strong>, only administrators can add sites</label>
					</fieldset>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="agency_api_url">URL to Agency API</label></th>
				<td><input type="url" class="regular-text code" maxlength="1000" value="<?php echo get_option('bsa_pro_plugin_'.'agency_api_url'); ?>" id="agency_api_url" name="agency_api_url">
					<p class="description">How to configure API page? (<a href="http://adspro.scripteo.info/documentation/#agency">Video Guide</a>)</p>
					<p class="description"><strong>Example</strong> http://your_page.com/api</p></td>
			</tr>
			<tr>
				<th scope="row"><label for="agency_ordering_form_url">URL to Agency Ordering Form</label></th>
				<td><input type="url" class="regular-text code" maxlength="1000" value="<?php echo get_option('bsa_pro_plugin_'.'agency_ordering_form_url'); ?>" id="agency_ordering_form_url" name="agency_ordering_form_url">
					<p class="description">Ordering form you can display by shortcode <strong>[bsa_pro_agency_form]</strong></p>
					<p class="description"><strong>Example</strong> http://your_page.com/agency_order_ads</p></td>
			</tr>
			<tr>
				<th scope="row"><label for="agency_commission">Agency Commission</label></th>
				<td><input type="number" class="regular-text code" value="<?php echo get_option('bsa_pro_plugin_'.'agency_commission'); ?>" id="agency_commission" name="agency_commission"> <abbr title="percent">%</abbr></td>
			</tr>
			<tr>
				<th scope="row">Allow displaying Ads for other Sites (non-wordpress)</th>
				<td>
					<fieldset>
						<label title="ads can be shown only for wordpress via ads pro parser"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'agency_other_sites') == 'no') { echo 'checked="checked"'; } ?> value="no" name="agency_other_sites"><strong>no</strong>, ads can be shown only for wordpress via Ads Pro Parser</label><br>
						<label title="ads can be shown anywhere via iframe also"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'agency_other_sites') == 'yes') { echo 'checked="checked"'; } ?>value="yes" name="agency_other_sites"><strong>yes</strong>, ads can be shown anywhere via iframe also</label>
					</fieldset>
					<p class="description"><strong>Note!</strong><br>For the iframe option, you can use all Ad Templates and default Display Type.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Agency Auto-Accept Sites</th>
				<td>
					<fieldset>
						<label title="auto accept sites for marketing agency"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'agency_auto_accept') == 'yes') { echo 'checked="checked"'; } ?> value="yes" name="agency_auto_accept"><strong>yes</strong></label><br>
						<label title="do not accept sites automatically"><input type="radio" <?php if(get_option('bsa_pro_plugin_'.'agency_auto_accept') == 'no') { echo 'checked="checked"'; } ?>value="no" name="agency_auto_accept"><strong>no</strong></label>
					</fieldset>
				</td>
			</tr>
			<tr class="bsaBottomLine">
				<th class="bsaLast" scope="row"><label for="agency_minimum_withdrawal">Minimum amount for Withdrawal</label></th>
				<td class="bsaLast"><?php echo $before ?><input type="number" class="regular-text ltr" value="<?php echo get_option('bsa_pro_plugin_'.'agency_minimum_withdrawal'); ?>" id="agency_minimum_withdrawal" name="agency_minimum_withdrawal"> <?php echo $after ?></td>
			</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
	</form>

<script>
	(function($){
		// - start - open page
		var bsaItemsWrap = $('.wrap');
		bsaItemsWrap.hide();

		setTimeout(function(){
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page

		$(document).ready(function(){

			// open tab after refresh
			var navTab = $('.nav-tab');
			var hash = window.location.hash;
			if ( hash !== "" && hash !== "#/" ) {
				navTab.removeClass('nav-tab-active');
				$('a[href="' + hash + '"]').addClass('nav-tab-active');

				$('.bsaTbody').hide();
				$(hash).show();
			}

			// init color picker
			$('.bsaColorPicker').wpColorPicker();

			// menu actions
			navTab.click(function(){
				var attr = $(this).attr("data-group");

				navTab.removeClass('nav-tab-active');
				$(this).addClass('nav-tab-active');

				$('.bsaTbody').hide();
				$('.' + attr).show();
			});

			var bsaSwitch = $(".bsaSwitch");
			options = { /* see below */ };
			bsaSwitch.switchButton(options);
			bsaSwitch.each(function(){
				var section = $(this).data('section');
				if ( $(this).is(':checked') ) {
					$('.'+section).show();
				} else {
					$('.'+section).hide();
					$('.'+section+'-input').val('');
				}
			});
			bsaSwitch.change(function(){
				var section = $(this).data('section');
				if($(this).is(':checked')) {
					$('.'+section).fadeIn();
				} else {
					$('.'+section).fadeOut();
					$('.'+section+'-input').val('');
				}
			});

		});

	})(jQuery);
</script>
