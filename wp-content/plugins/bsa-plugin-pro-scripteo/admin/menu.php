<?php

function bsa_pro_head_menu()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		} ?>
		<?php require_once 'dashboard.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_spaces()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		} ?>
		<?php require_once 'items.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_add_new_space()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		} ?>
		<?php bsaAddNewSpace(); ?>
		<?php require_once 'add-space.php'; ?>
	</div>
<?php
}

function bsaAddNewSpace()
{

	if ( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'updateSpace' ) {

		if ( $_POST["name"] != '' ) {

			$model = new BSA_PRO_Model();
			$cpc_status = $model->billingValidator('cpc');
			$cpm_status = $model->billingValidator('cpm');
			$cpd_status = $model->billingValidator('cpd');

			if ( $cpc_status == 'isset' || $cpc_status == 'incorrect' || $cpm_status == 'isset' || $cpm_status == 'incorrect' || $cpd_status == 'isset' || $cpd_status == 'incorrect' ) {

				if ( $_POST['max_items'] < $model->countAds($_GET['space_id']) || $cpc_status == 'incorrect' || $cpm_status == 'incorrect' || $cpd_status == 'incorrect' ) {

					if ( $_POST['max_items'] < $model->countAds($_GET['space_id']) ) { // if ad limit smaller than number of active ads

						echo '
					<div class="updated settings-error">
						<p><strong>Error!</strong> You have more active ads than ad limit.<br><br>
						<strong>Note!</strong><br>
						Increase number of maximum ads.</p>
					</div>';

					} else {

						echo '
					<div class="updated settings-error">
						<p><strong>Error, incorrect contract values!</strong> Please enter the price and values for some contract, add them one by one (all values must be different).<br><br>
						<strong>Note!</strong><br>
						Enter <strong>0</strong> in the price field if you do not want to use some of billing model.</p>
					</div>';
					}

				} else {

					$advanced_opt = array(
						'hide_for_id' => (isset($_POST['hide_for_id']) && $_POST['hide_for_id'] != '' ? implode(",", $_POST['hide_for_id']) : null), // hide for specific posts / pages
						'show_customs' => (isset($_POST['show_customs']) && $_POST['show_customs'] != '' ? $_POST['show_customs'] : null), // show for specific customs
						'hide_customs' => (isset($_POST['hide_customs']) && $_POST['hide_customs'] != '' ? $_POST['hide_customs'] : null), // hide for specific customs
					);

					$model->updateSpace(
						$_GET['space_id'],
						stripslashes($_POST['name']),
						stripslashes($_POST['title']),
						stripslashes($_POST['add_new']),
						($_POST['cpc_price'] > 0 ? $_POST['cpc_price'] : 0),
						($_POST['cpm_price'] > 0 ? $_POST['cpm_price'] : 0),
						($_POST['cpd_price'] > 0 ? $_POST['cpd_price'] : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_1'] > 0 ? $_POST['cpc_contract_1'] : 0) : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_2'] > 0 ? $_POST['cpc_contract_2'] : 0) : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_3'] > 0 ? $_POST['cpc_contract_3'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_1'] > 0 ? $_POST['cpm_contract_1'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_2'] > 0 ? $_POST['cpm_contract_2'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_3'] > 0 ? $_POST['cpm_contract_3'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_1'] > 0 ? $_POST['cpd_contract_1'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_2'] > 0 ? $_POST['cpd_contract_2'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_3'] > 0 ? $_POST['cpd_contract_3'] : 0) : 0),
						($_POST['discount_2'] > 0 && $_POST['discount_2'] <= 100 ? $_POST['discount_2'] : 0),
						($_POST['discount_3'] > 0 && $_POST['discount_3'] <= 100 ? $_POST['discount_3'] : 0),
						$_POST['grid_system'],
						$_POST['template'],
						$_POST['display_type'],
						$_POST['random'],
						$_POST['max_items'],
						$_POST['col_per_row'],
						$_POST['font'],
						$_POST['font_url'],
						$_POST['header_bg'],
						$_POST['header_color'],
						$_POST['link_color'],
						$_POST['ads_bg'],
						$_POST['ad_bg'],
						$_POST['ad_title_color'],
						$_POST['ad_desc_color'],
						$_POST['ad_url_color'],
						$_POST['ad_extra_color_1'],
						$_POST['ad_extra_color_2'],
						$_POST['animation'],
						( isset($_POST['space_categories']) && $_POST['space_categories'] != '' ? implode(",", $_POST['space_categories']) : null ),
						( isset($_POST['space_tags']) && $_POST['space_tags'] != '' ? implode(",", $_POST['space_tags']) : null ),
						( isset($_POST['show_in_country']) && $_POST['show_in_country'] != '' ? implode(",", $_POST['show_in_country']) : null ),
						( isset($_POST['hide_in_country']) && $_POST['hide_in_country'] != '' ? implode(",", $_POST['hide_in_country']) : null ),
						( isset($_POST['show_in_advanced']) && $_POST['show_in_advanced'] != '' ? $_POST['show_in_advanced'] : null ),
						( isset($_POST['hide_in_advanced']) && $_POST['hide_in_advanced'] != '' ? $_POST['hide_in_advanced'] : null ),
						( isset($_POST['devices']) && $_POST['devices'] != '' ? implode(",", $_POST['devices']) : null ),
						( isset($_POST['unavailable_dates']) && $_POST['unavailable_dates'] != '' ? $_POST['unavailable_dates'] : null ),
						( isset($_POST['show_ads']) && isset($_POST['show_close_btn']) && isset($_POST['close_ads']) ? ($_POST['show_ads'] > 0 ? $_POST['show_ads'] : '0').','.($_POST['show_close_btn'] > 0 ? $_POST['show_close_btn'] : '0').','.($_POST['close_ads'] > 0 ? $_POST['close_ads'] : '0') : '0,0,0' ),
						json_encode($advanced_opt),
						(($_POST['status'] == 'active') ? 'active' : 'inactive')
					);
					do_action( 'bsa-pro-updateSpace', $_POST, $_GET['space_id'] );

					if ( isset($_SESSION[bsa_get_opt('prefix').'bsa_space_'.$_GET['space_id']]) || isset($_SESSION[bsa_get_opt('prefix').'bsaProSpace'.$_GET['space_id']]) ) {
						unset($_SESSION[bsa_get_opt('prefix').'bsa_space_'.$_GET['space_id']]); // Reset cache
						unset($_SESSION[bsa_get_opt('prefix').'bsaProSpace'.$_GET['space_id']]); // Reset cache
					}

					echo '
					<div class="updated settings-error">
						<p><strong>Space updated.</strong></p>
					</div>';
				}
			} else {

				echo '
				<div class="updated settings-error">
					<p><strong>Error, empty contracts!</strong> You should set at least one contract.</p>
				</div>';
			}

		} else {

			echo '
			<div class="updated settings-error">
				<p><strong>Space not saved.</strong> The name field is required!</p>
			</div>';
		}

	} elseif ( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'addNewSpace' ) {

		if ( $_POST["name"] != '' ) {

			$model = new BSA_PRO_Model();
			$cpc_status = $model->billingValidator('cpc');
			$cpm_status = $model->billingValidator('cpm');
			$cpd_status = $model->billingValidator('cpd');

			if ( $cpc_status == 'isset' || $cpc_status == 'incorrect' || $cpm_status == 'isset' || $cpm_status == 'incorrect' || $cpd_status == 'isset' || $cpd_status == 'incorrect' ) {

				if ( $cpc_status == 'incorrect' || $cpm_status == 'incorrect' || $cpd_status == 'incorrect' ) {

					echo '
					<div class="updated settings-error">
						<p><strong>Error, incorrect contract values!</strong> Please enter the price and values for some contract, add them one by one (all values must be different).<br><br>
						<strong>Note!</strong><br>
						Enter <strong>0</strong> in the price field if you do not want to use some of billing model.</p>
					</div>';

				} else {

					$advanced_opt = array(
						'hide_for_id' => (isset($_POST['hide_for_id']) && $_POST['hide_for_id'] != '' ? implode(",", $_POST['hide_for_id']) : null), // hide for specific posts / pages
						'show_customs' => (isset($_POST['show_customs']) && $_POST['show_customs'] != '' ? $_POST['show_customs'] : null), // show for specific customs
						'hide_customs' => (isset($_POST['hide_customs']) && $_POST['hide_customs'] != '' ? $_POST['hide_customs'] : null), // hide for specific customs
					);

					$model->addNewSpace(
						NULL,
						stripslashes($_POST['name']),
						stripslashes($_POST['title']),
						stripslashes($_POST['add_new']),
						($_POST['cpc_price'] > 0 ? $_POST['cpc_price'] : 0),
						($_POST['cpm_price'] > 0 ? $_POST['cpm_price'] : 0),
						($_POST['cpd_price'] > 0 ? $_POST['cpd_price'] : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_1'] > 0 ? $_POST['cpc_contract_1'] : 0) : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_2'] > 0 ? $_POST['cpc_contract_2'] : 0) : 0),
						($_POST['cpc_price'] > 0 ? ($_POST['cpc_contract_3'] > 0 ? $_POST['cpc_contract_3'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_1'] > 0 ? $_POST['cpm_contract_1'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_2'] > 0 ? $_POST['cpm_contract_2'] : 0) : 0),
						($_POST['cpm_price'] > 0 ? ($_POST['cpm_contract_3'] > 0 ? $_POST['cpm_contract_3'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_1'] > 0 ? $_POST['cpd_contract_1'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_2'] > 0 ? $_POST['cpd_contract_2'] : 0) : 0),
						($_POST['cpd_price'] > 0 ? ($_POST['cpd_contract_3'] > 0 ? $_POST['cpd_contract_3'] : 0) : 0),
						($_POST['discount_2'] > 0 && $_POST['discount_2'] <= 100 ? $_POST['discount_2'] : 0),
						($_POST['discount_3'] > 0 && $_POST['discount_3'] <= 100 ? $_POST['discount_3'] : 0),
						$_POST['grid_system'],
						$_POST['template'],
						$_POST['display_type'],
						$_POST['random'],
						$_POST['max_items'],
						$_POST['col_per_row'],
						$_POST['font'],
						$_POST['font_url'],
						$_POST['header_bg'],
						$_POST['header_color'],
						$_POST['link_color'],
						$_POST['ads_bg'],
						$_POST['ad_bg'],
						$_POST['ad_title_color'],
						$_POST['ad_desc_color'],
						$_POST['ad_url_color'],
						$_POST['ad_extra_color_1'],
						$_POST['ad_extra_color_2'],
						$_POST['animation'],
						( isset($_POST['space_categories']) && $_POST['space_categories'] != '' ? implode(",", $_POST['space_categories']) : null ),
						( isset($_POST['space_tags']) && $_POST['space_tags'] != '' ? implode(",", $_POST['space_tags']) : null ),
						( isset($_POST['show_in_country']) && $_POST['show_in_country'] != '' ? implode(",", $_POST['show_in_country']) : null ),
						( isset($_POST['hide_in_country']) && $_POST['hide_in_country'] != '' ? implode(",", $_POST['hide_in_country']) : null ),
						( isset($_POST['show_in_advanced']) && $_POST['show_in_advanced'] != '' ? $_POST['show_in_advanced'] : null ),
						( isset($_POST['hide_in_advanced']) && $_POST['hide_in_advanced'] != '' ? $_POST['hide_in_advanced'] : null ),
						( isset($_POST['devices']) && $_POST['devices'] != '' ? implode(",", $_POST['devices']) : null ),
						( isset($_POST['unavailable_dates']) && $_POST['unavailable_dates'] != '' ? $_POST['unavailable_dates'] : null ),
						( isset($_POST['show_ads']) && isset($_POST['show_close_btn']) && isset($_POST['close_ads']) ? ($_POST['show_ads'] > 0 ? $_POST['show_ads'] : '0').','.($_POST['show_close_btn'] > 0 ? $_POST['show_close_btn'] : '0').','.($_POST['close_ads'] > 0 ? $_POST['close_ads'] : '0') : '0,0,0' ),
						json_encode($advanced_opt),
						(($_POST['status'] == 'active') ? 'active' : 'inactive')
					);
					do_action( 'bsa-pro-addNewSpace', $_POST, $model->getTableName('spaces') );
					$_SESSION['bsa_space_status'] = 'space_added';

					echo '
					<div class="updated settings-error">
						<p><strong>Space saved.</strong> Click <a href="'.admin_url().'admin.php?page=bsa-pro-sub-menu-spaces">here</a> to show all spaces.</p>
					</div>';
				}
			} else {

				echo '
				<div class="updated settings-error">
					<p><strong>Error, empty contracts!</strong> You should set at least one contract.</p>
				</div>';
			}

		} else {

			echo '
			<div class="updated settings-error">
				<p><strong>Space not saved.</strong> The name field is required!</p>
			</div>';
		}
	}
}

function bsa_pro_sub_menu_add_new_ad()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		} ?>
		<?php bsaAddNewAd(); ?>
		<?php require_once 'add-ad.php'; ?>
	</div>
<?php
}

function bsaAddNewAd()
{
	$plugin_id = 'bsa_pro_plugin_';

	if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'updateAd') {

		// validate form
		if ( isset($_GET['ad_id']) && bsa_space(bsa_ad($_GET['ad_id'], 'space_id'), 'template') != 'html' ) {
			foreach (explode(',', str_replace('desc', 'description', $_POST['inputs_required'])) as $input) {
				$error = FALSE;
				if ($input == 'img') {
					if ($_FILES['img']["name"] == '') {
						$error = FALSE; // img not required for updateAd Action
					}
				} else {
					if ($_POST[$input] == '') {
						$error = TRUE;
					}
				}
				if ($error == TRUE) {
					echo '
				<div class="updated settings-error">
					<p><strong>Ad not saved.</strong> The ' . str_replace(',', ', ', str_replace('desc', 'description', $_POST['inputs_required'])) . ' fields are required!</p>
				</div>';
					return;
				}
			}
		}

		if ( $_POST["buyer_email"] != '' ) {

			// if isset img
			$uploadName = strtolower($_FILES["img"]["name"]);
			if ( $uploadName ) {
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $uploadName);
				$extension = end($temp);
				$fileName = NULL;

				if ((($_FILES["img"]["type"] == "image/gif")
						|| ($_FILES["img"]["type"] == "image/jpeg")
						|| ($_FILES["img"]["type"] == "image/jpg")
						|| ($_FILES["img"]["type"] == "image/pjpeg")
						|| ($_FILES["img"]["type"] == "image/x-png")
						|| ($_FILES["img"]["type"] == "image/png"))
					&& $_FILES["img"]["error"] == 0
					&& in_array($extension, $allowedExts)) {

					$fileName = time().'-'.$uploadName;
					$path     = bsa_upload_url('basedir', $fileName);
					$thumbLoc = $_FILES["img"]["tmp_name"];

					list($width, $height) = getimagesize($thumbLoc);
					$maxSize = get_option($plugin_id.'thumb_size');
					$maxWidth = get_option($plugin_id.'thumb_w');
					$maxHeight = get_option($plugin_id.'thumb_h');

					if (($_FILES["img"]["size"] > $maxSize * 1024) OR $width > $maxWidth OR $height > $maxHeight) {
						echo '
						<div class="updated settings-error">
							<p><strong>Ad not saved.</strong> Images was too high.</p>
						</div>';
						return;
					} else {
						// save img
						move_uploaded_file($thumbLoc, $path);
					}
				} else {
					echo '
					<div class="updated settings-error">
						<p><strong>Ad not saved.</strong> Type of image invalid.</p>
					</div>
					';
					return;
				}
			} else {
				$fileName = (isset($_POST["img_url"]) && $_POST["img_url"] != '' ? $_POST["img_url"] : null);
			}

			$limit = bsa_ad($_GET['ad_id'], 'ad_limit');
			if ( isset($_POST["increase_limit"]) && $_POST["increase_limit"] != '' ) {
				if ( $_POST["increase_limit"] > 0 || $_POST["increase_limit"] < 0 ) { // increase / decrease limit
					if ( bsa_ad($_GET['ad_id'], 'ad_model') == 'cpd' ) {
						$time = time();
						$increase = $_POST["increase_limit"] * 24 * 60 * 60;
						$diff = $limit - $time;
						$increase_limit = ($diff <= 0) ? $time + $increase : $limit + $increase;
					} else {
						$increase_limit = $limit + $_POST["increase_limit"];
					}
				} else {
					$increase_limit = bsa_ad($_GET['ad_id'], 'ad_limit');
				}
			} else {
				$increase_limit = null;
			}

//			var_dump(stripslashes( wp_filter_post_kses( addslashes( $_POST["html"] ) ) ));
			if ( (bsa_role() == 'user') ) {
				$status = ((get_option('bsa_pro_plugin_auto_accept') == 'no') ? 'pending' : null);
				$increase_limit = null;
			} else {
				$status = null;
			}

			$capping = ( $_POST["capping"] > 0 ? number_format($_POST["capping"], 0, '', '') : 0);
			$ad_name = ( isset($_POST["ad_name"]) && $_POST["ad_name"] != '' ) ? $_POST["ad_name"] : null;
			$optional_field = ( isset($_POST["optional_field"]) && $_POST["optional_field"] != '' ) ? $_POST["optional_field"] : null;

			$model = new BSA_PRO_Model();
			$model->updateAd( $_GET['ad_id'], $ad_name, $_POST["buyer_email"], $_POST["title"], $_POST["description"], $_POST["button"], $_POST["url"], $fileName, stripslashes( $_POST["html"] ), $capping, $optional_field, $increase_limit, $status );

			echo '
						<div class="updated settings-error">
							<p><strong>Success!</strong> Ad saved.</p>
						</div>';

		} else {

			echo '
			<div class="updated settings-error">
				<p><strong>Ad not saved.</strong> The buyer email field is required!</p>
			</div>';

		}

	} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'addNewAd') {

		// validate form
			if ( isset($_POST["space_id"]) && bsa_space($_POST["space_id"], 'template') != 'html' ) {
			foreach ( explode(',', str_replace('desc', 'description', $_POST['inputs_required'])) as $input ) {
				$error = FALSE;
				if ( $input == 'img' ) {
					if ( $_FILES['img']["name"] != '' || isset($_POST["img_url"]) && $_POST["img_url"] != '' ) {
						$error = FALSE;
					} else {
						$error = TRUE;
					}
				} else {
					if ( $_POST[$input] == '' ) {
						$error = TRUE;
					}
				}
				if ( $error == TRUE ) {
					echo '
					<div class="updated settings-error">
						<p><strong>Ad not saved.</strong> The '.str_replace(',', ', ', str_replace('desc', 'description', $_POST['inputs_required'])).' fields are required!</p>
					</div>';
					return;
				}
			}
		}

		if ( isset($_POST["buyer_email"]) && $_POST["buyer_email"] != '' && isset($_POST["space_id"]) && $_POST["space_id"] != '' && isset($_POST["ad_model"]) && $_POST["ad_model"] != '' && isset($_POST["ad_limit_" . $_POST["ad_model"]]) && $_POST["ad_limit_" . $_POST["ad_model"]] != '' ) {

			// if isset img
			if ( $_FILES['img']["name"] ) {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG",);
				$temp = explode(".", $_FILES["img"]["name"]);
				$extension = end($temp);
				$fileName = NULL;

				if ((($_FILES["img"]["type"] == "image/gif")
						|| ($_FILES["img"]["type"] == "image/jpeg")
						|| ($_FILES["img"]["type"] == "image/jpg")
						|| ($_FILES["img"]["type"] == "image/pjpeg")
						|| ($_FILES["img"]["type"] == "image/x-png")
						|| ($_FILES["img"]["type"] == "image/png"))
					&& $_FILES["img"]["error"] == 0
					&& in_array($extension, $allowedExts)) {

					$fileName = time().'-'.$_FILES["img"]["name"];
					$path     = bsa_upload_url('basedir', $fileName);
					$thumbLoc = $_FILES["img"]["tmp_name"];

					list($width, $height) = getimagesize($thumbLoc);
					$maxSize = get_option($plugin_id.'thumb_size');
					$maxWidth = get_option($plugin_id.'thumb_w');
					$maxHeight = get_option($plugin_id.'thumb_h');

					if (($_FILES["img"]["size"] > $maxSize * 1024) OR $width > $maxWidth OR $height > $maxHeight) {
						echo '
						<div class="updated settings-error">
							<p><strong>Ad not saved.</strong> Images was too high.</p>
						</div>';
						return;
					} else {
						// save img
						move_uploaded_file($thumbLoc, $path);
					}
				} else {
					echo '
					<div class="updated settings-error">
						<p><strong>Ad not saved.</strong> Type of image invalid.</p>
					</div>
					';
					return;
				}
			} else {
				$fileName = (isset($_POST["img_url"]) && $_POST["img_url"] != '' ? $_POST["img_url"] : '');
			}

			// set limit for cpd - change days to timestamp
			if ( $_POST["ad_model"] == 'cpd' ) {
				$ad_limit = time() + ($_POST["ad_limit_" . $_POST["ad_model"]] * 24 * 60 * 60);
			} else {
				$ad_limit = $_POST["ad_limit_" . $_POST["ad_model"]];
			}

			$model = new BSA_PRO_Model();

			if ( (bsa_role() == 'user') ) {
				$status = ((get_option('bsa_pro_plugin_auto_accept') == 'no') ? 'pending' : 'active');
			} else {
				$status = 'active';
			}

			$capping = ( $_POST["capping"] > 0 ? number_format($_POST["capping"], 0, '', '') : 0);
			$ad_name = ( isset($_POST["ad_name"]) && $_POST["ad_name"] != '' ) ? $_POST["ad_name"] : null;
			$optional_field = ( isset($_POST["optional_field"]) && $_POST["optional_field"] != '' ) ? $_POST["optional_field"] : null;

			$model->addNewAd(	NULL, $_POST["space_id"], $ad_name, $_POST["buyer_email"], $_POST["title"], $_POST["description"], $_POST["button"], $_POST["url"], $fileName, stripslashes( $_POST["html"] ), $capping, $optional_field, $_POST["ad_model"], $ad_limit, 0.00, 2, $status); // paid 2 - Added via Admin Panel

			$_SESSION['bsa_ad_status'] = 'ad_added';

			echo '
			<div class="updated settings-error">
				<p><strong>Success!</strong> Ad saved.</p>
			</div>';

		} else {

			echo '
			<div class="updated settings-error">
				<p><strong>Ad not saved.</strong> The buyer email, space id, billing model fields are required!</p>
			</div>';

		}
	}
}

function bsa_pro_sub_menu_creator()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		} ?>
		<?php bsaCreateAdTemplate(); ?>
		<?php require_once 'creator.php'; ?>
	</div>
<?php
}

function bsaCreateAdTemplate($width = null, $height = null)
{
	if( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'adCreator' ||
		$width != null && $height != null)
	{

		if( isset($_POST["ad_width"]) && $_POST["ad_width"] > 0 && isset($_POST["ad_height"]) && $_POST["ad_height"] > 0 ||
			$width != null && $height != null )
		{
			$ad_width = ( $width == null ) ? $_POST["ad_width"] : $width;
			$ad_height = ( $height == null ) ? $_POST["ad_height"] : $height;

			$css_styles = '
/* -- START -- Reset */
#bsa-block-'.$ad_width.'--'.$ad_height.' h3,
#bsa-block-'.$ad_width.'--'.$ad_height.' a,
#bsa-block-'.$ad_width.'--'.$ad_height.' img,
#bsa-block-'.$ad_width.'--'.$ad_height.' span,
#bsa-block-'.$ad_width.'--'.$ad_height.' p {
	margin: 0;
	padding: 0;
	border: 0;
	border-radius: 0;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	text-decoration: none;
	line-height: 1.25;
}
/* -- END -- Reset */


/* -- START -- TEMPLATE */
#bsa-block-'.$ad_width.'--'.$ad_height.'.bsaProContainerNew .bsaProItem,
#bsa-block-'.$ad_width.'--'.$ad_height.' .bsaProItemInner__thumb,
#bsa-block-'.$ad_width.'--'.$ad_height.' .bsaProAnimateThumb {
	max-width: '.$ad_width.'px;
	max-height: '.$ad_height.'px;
}

#bsa-block-'.$ad_width.'--'.$ad_height.' .bsaProAnimateThumb {
	position: relative;
	width: 100%;
	height: '.$ad_height.'px;
}

#bsa-block-'.$ad_width.'--'.$ad_height.' .bsaProAnimateThumb:before{
	content: "";
	display: block;
}

#bsa-block-'.$ad_width.'--'.$ad_height.' .bsaProItemInner__img {
	position:  absolute;
	width: 100%;
	max-height: '.$ad_height.'px;
	height: auto;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	background-size: 100%;
	background-repeat: no-repeat;
}
/* -- END -- TEMPLATE */';
			file_put_contents(plugin_dir_path( __DIR__ ) . 'frontend/css/block-'.$ad_width.'--'.$ad_height.'.css', $css_styles);

			$template_code 			= file_get_contents(plugin_dir_path( __DIR__ ) . 'frontend/template/block-300--250.php');
			$template_overwrite 	= str_replace('300', 11111, str_replace('250', 22222, $template_code));
			$template_php 			= str_replace(11111, $ad_width, str_replace(22222, $ad_height, $template_overwrite));
			file_put_contents(plugin_dir_path( __DIR__ ) . 'frontend/template/block-'.$ad_width.'--'.$ad_height.'.php', $template_php);

			$custom_templates = get_option('bsa_pro_plugin_custom_templates');
			$exists = array_search($ad_width.'--'.$ad_height, explode(',', $custom_templates));
			if ($exists === false) {
				update_option('bsa_pro_plugin_custom_templates', $custom_templates.','.$ad_width.'--'.$ad_height);
			}

			if ( $width == null && $height == null && file_exists(plugin_dir_path( __DIR__ ) . 'frontend/css/block-'.$ad_width.'--'.$ad_height.'.css') ) {

				// re-generate css
				bsa_pro_generate_css( (get_option('bsa_pro_plugin_rtl_support') == 'yes' ? true : null) );

				echo '
				<div class="updated settings-error">
					<p>Ad Template (<strong>block-'.$ad_width.'--'.$ad_height.'</strong>) has been saved.</p>
				</div>';
			} else {
				echo '
			<div class="updated settings-error">
				<p><strong>Error!</strong> Files has not been created. Probably you should change permission for templates folder.</p>
			</div>';
			}
		} else {
			echo '
			<div class="updated settings-error">
				<p><strong>Error!</strong> Both fields required!</p>
			</div>';
		}
	}
}

function bsa_pro_sub_menu_settings()
{
	?>
	<div class="wrap">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		}
		if ( is_multisite() && is_main_site() ) {
			if (get_site_option('bsa_pro_plugin_main_basedir') == null ||
				get_site_option('bsa_pro_plugin_main_baseurl') == null ||
				get_site_option('bsa_pro_plugin_order_form_url') == null ||
				get_site_option('bsa_pro_plugin_order_form_url') != get_option('bsa_pro_plugin_ordering_form_url') ||
				get_site_option('bsa_pro_plugin_agency_order_form_url') == null ||
				get_site_option('bsa_pro_plugin_agency_order_form_url') != get_option('bsa_pro_plugin_agency_ordering_form_url')) {
				$upload_dir = wp_upload_dir();
				update_site_option('bsa_pro_plugin_main_basedir', $upload_dir['basedir']);
				update_site_option('bsa_pro_plugin_main_baseurl', $upload_dir['baseurl']);
				update_site_option('bsa_pro_plugin_order_form_url', get_option('bsa_pro_plugin_ordering_form_url'));
				update_site_option('bsa_pro_plugin_agency_order_form_url', get_option('bsa_pro_plugin_agency_ordering_form_url'));
			}
		} ?>
		<?php bsaUpdateSettings(); ?>
		<?php require_once 'settings.php'; ?>

	</div>
<?php
}

function bsaUpdateSettings()
{
	$opt = 'bsa_pro_plugin_';

	if( $_SERVER["REQUEST_METHOD"] == "POST" &&
		$_POST["bsaProAction"] == 'updateSettings' &&
		$_POST["ordering_form_url"] != '' )
	{
		// Check Update
		update_option('bsa_pro_update_version', 100);
		// Counters
		if ( isset( $_POST['clicks_counter'] ) && $_POST['clicks_counter'] > 0 ) {
			update_option('bsa_pro_plugin_dashboard_clicks', $_POST['clicks_counter']);
		}
		if ( isset( $_POST['views_counter'] ) && $_POST['views_counter'] > 0 ) {
			update_option('bsa_pro_plugin_dashboard_views', $_POST['views_counter']);
		}
		// Settings
		update_option($opt.'settings', array(
			// woo
			'woo_item' 				=> $_POST['woo_item'],
			// form
			'form_restrictions' 	=> $_POST['form_restrictions'],
			// notifications
			'up_expires_notice' 	=> ( isset($_POST['up_expires_notice']) && $_POST['up_expires_notice'] == 'yes' ? $_POST['up_expires_notice'] : 'no' ),
			'up_expired_notice' 	=> ( isset($_POST['up_expired_notice']) && $_POST['up_expired_notice'] == 'yes' ? $_POST['up_expired_notice'] : 'no' ),
			'up_cpc_notice' 		=> ( $_POST['up_cpc_notice'] > 0 ? $_POST['up_cpc_notice'] : 10 ),
			'up_cpm_notice' 		=> ( $_POST['up_cpm_notice'] > 0 ? $_POST['up_cpm_notice'] : 1000 ),
			'up_cpd_notice' 		=> ( $_POST['up_cpd_notice'] > 0 ? $_POST['up_cpd_notice'] : 5 ),
		));
		// order form
		update_option($opt.'order_form', array(
			'optional_field' 		=> $_POST['optional_field'],
		));
		// plugin settings
		update_option($opt.'purchase_code', str_replace(' ', '', $_POST['purchase_code']));
		update_option($opt.'paypal', $_POST['paypal']);
		update_option($opt.'secret_key', $_POST['secret_key']);
		update_option($opt.'publishable_key', $_POST['publishable_key']);
		update_option($opt.'trans_payment_bank_transfer_content', $_POST['trans_payment_bank_transfer_content']);
		update_option($opt.'ordering_form_url', $_POST['ordering_form_url']);
		update_option($opt.'currency_code', $_POST['currency_code']);
		update_option($opt.'stripe_code', $_POST['stripe_code']);
		update_option($opt.'currency_symbol', $_POST['currency_symbol']);
		update_option($opt.'symbol_position', $_POST['symbol_position']);
		update_option($opt.'auto_accept', $_POST['auto_accept']);
		update_option($opt.'calendar', $_POST['calendar']);
		// installation settings
		update_option($opt.'installation', $_POST['installation']);
		// hooks settings
		update_site_option($opt.'before_hook', str_replace('\"', '', $_POST['before_hook']));
		update_site_option($opt.'after_1_paragraph', str_replace('\"', '', $_POST['after_1_paragraph']));
		update_site_option($opt.'after_2_paragraph', str_replace('\"', '', $_POST['after_2_paragraph']));
		update_site_option($opt.'after_3_paragraph', str_replace('\"', '', $_POST['after_3_paragraph']));
		update_site_option($opt.'after_4_paragraph', str_replace('\"', '', $_POST['after_4_paragraph']));
		update_site_option($opt.'after_5_paragraph', str_replace('\"', '', $_POST['after_5_paragraph']));
		update_site_option($opt.'after_6_paragraph', str_replace('\"', '', $_POST['after_6_paragraph']));
		update_site_option($opt.'after_7_paragraph', str_replace('\"', '', $_POST['after_7_paragraph']));
		update_site_option($opt.'after_8_paragraph', str_replace('\"', '', $_POST['after_8_paragraph']));
		update_site_option($opt.'after_9_paragraph', str_replace('\"', '', $_POST['after_9_paragraph']));
		update_site_option($opt.'after_10_paragraph', str_replace('\"', '', $_POST['after_10_paragraph']));
		update_site_option($opt.'after_hook', str_replace('\"', '', $_POST['after_hook']));
		// BuddyPress hooks
		update_option($opt.'bp_stream_hook', array(
			1 	=> str_replace('\"', '', $_POST['after_1_activity']),
			2 	=> str_replace('\"', '', $_POST['after_2_activity']),
			3 	=> str_replace('\"', '', $_POST['after_3_activity']),
			4 	=> str_replace('\"', '', $_POST['after_4_activity']),
			5 	=> str_replace('\"', '', $_POST['after_5_activity']),
			6 	=> str_replace('\"', '', $_POST['after_6_activity']),
			7 	=> str_replace('\"', '', $_POST['after_7_activity']),
			8 	=> str_replace('\"', '', $_POST['after_8_activity']),
			9 	=> str_replace('\"', '', $_POST['after_9_activity']),
			10 	=> str_replace('\"', '', $_POST['after_10_activity']),
			11 	=> str_replace('\"', '', $_POST['after_11_activity']),
			12 	=> str_replace('\"', '', $_POST['after_12_activity']),
			13 	=> str_replace('\"', '', $_POST['after_13_activity']),
			14 	=> str_replace('\"', '', $_POST['after_14_activity']),
			15 	=> str_replace('\"', '', $_POST['after_15_activity']),
			16 	=> str_replace('\"', '', $_POST['after_16_activity']),
			17 	=> str_replace('\"', '', $_POST['after_17_activity']),
			18 	=> str_replace('\"', '', $_POST['after_18_activity']),
			19 	=> str_replace('\"', '', $_POST['after_19_activity']),
			20 	=> str_replace('\"', '', $_POST['after_20_activity']),
		));
		// bbPress hooks
		$imp_forum = array();
		for ( $i = 1; $i <= get_option( '_bbp_topics_per_page', '15' ); $i++ ) {
			$imp_forum[$i] = str_replace('\"', '', $_POST['after_'.$i.'_topic']);
		}
		update_option($opt.'bbp_forum_hook', $imp_forum);
		$imp_topic = array();
		for ( $i = 1; $i <= get_option( '_bbp_replies_per_page', '15' ); $i++ ) {
			$imp_topic[$i] = str_replace('\"', '', $_POST['after_'.$i.'_reply']);
		}
		update_option($opt.'bbp_topic_hook', $imp_topic);
		// admin panel settings
		update_option($opt.'username', $_POST['username']);
		update_option($opt.'editable', $_POST['editable']);
		update_option($opt.'rtl_support', $_POST['rtl_support']);
		update_option($opt.'html_preview', $_POST['html_preview']);
		update_option($opt.'hide_if_logged', $_POST['hide_if_logged']);
		update_option($opt.'link_bar', $_POST['link_bar']);
		update_option($opt.'upload_dir', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '', $_POST['upload_dir'])));
		update_option($opt.'prefix', $_POST['prefix']);
		update_option($opt.'admin_settings', array(
			'selection' 	=> $_POST['selection'],
			'nofollow' 		=> $_POST['nofollow'],
			'privileges' 	=> $_POST['privileges'],
			'ad_name' 		=> $_POST['ad_name'],
		));
		// affiliate program
		update_option($opt.'ap_cookie_lifetime', ($_POST['ap_cookie_lifetime'] >= 10) ? $_POST['ap_cookie_lifetime'] : 30);
		update_option($opt.'ap_commission', ($_POST['ap_commission'] >= 0 && $_POST['ap_commission'] <= 100) ? number_format(($_POST['ap_commission'] > 0 ? $_POST['ap_commission'] : 0), 0, '', '') : 10);
		update_option($opt.'ap_minimum_withdrawal', ($_POST['ap_minimum_withdrawal'] >= 0) ? $_POST['ap_minimum_withdrawal'] : 50);
		// marketing agency
		update_option($opt.'private_ma', $_POST['private_ma']);
		update_option($opt.'agency_api_url', $_POST['agency_api_url']);
		update_option($opt.'agency_ordering_form_url', $_POST['agency_ordering_form_url']);
		update_option($opt.'agency_commission', $_POST['agency_commission']);
		update_option($opt.'agency_other_sites', $_POST['agency_other_sites']);
		update_option($opt.'agency_auto_accept', $_POST['agency_auto_accept']);
		update_option($opt.'agency_minimum_withdrawal', $_POST['agency_minimum_withdrawal']);
		// thumbnail settings
		update_option($opt.'carousel_script', $_POST['carousel_script']);
		update_option($opt.'example_ad', $_POST['example_ad']);
		update_option($opt.'thumb_size', $_POST['thumb_size']);
		update_option($opt.'thumb_w', $_POST['thumb_w']);
		update_option($opt.'thumb_h', $_POST['thumb_h']);
		// length of inputs
		update_option($opt.'max_title', 40);
		update_option($opt.'max_desc', 80);
		// form customization
		update_option($opt.'form_bg', $_POST['form_bg']);
		update_option($opt.'form_c', $_POST['form_c']);
		update_option($opt.'form_input_bg', $_POST['form_input_bg']);
		update_option($opt.'form_input_c', $_POST['form_input_c']);
		update_option($opt.'form_price_c', $_POST['form_price_c']);
		update_option($opt.'form_discount_bg', $_POST['form_discount_bg']);
		update_option($opt.'form_discount_c', $_POST['form_discount_c']);
		update_option($opt.'form_button_bg', $_POST['form_button_bg']);
		update_option($opt.'form_button_c', $_POST['form_button_c']);
		update_option($opt.'form_alert_c', $_POST['form_alert_c']);
		update_option($opt.'form_alert_success_bg', $_POST['form_alert_success_bg']);
		update_option($opt.'form_alert_failed_bg', $_POST['form_alert_failed_bg']);
		update_option($opt.'stats_views_line', $_POST['stats_views_line']);
		update_option($opt.'stats_clicks_line', $_POST['stats_clicks_line']);
		update_option($opt.'custom_css', stripslashes_deep($_POST['custom_css']));
		update_option($opt.'custom_js', stripslashes_deep($_POST['custom_js']));
		if ( isset($_POST['advanced_calendar']) ) {
			update_option($opt.'advanced_calendar', stripslashes_deep($_POST['advanced_calendar']));
		}
		// other settings
		update_option($opt.'other', array(
			'optimization' 		=> $_POST['optimization'],
			'countdown' 		=> $_POST['countdown'],
			'crop_tool' 		=> $_POST['crop_tool'],
		));
		// affiliate program customization
		update_option($opt.'ap_custom', array(
			'general_bg' 		=> $_POST['general_bg'],
			'general_color' 	=> $_POST['general_color'],
			'commission_bg' 	=> $_POST['commission_bg'],
			'commission_color' 	=> $_POST['commission_color'],
			'balance_bg' 		=> $_POST['balance_bg'],
			'balance_color' 	=> $_POST['balance_color'],
			'link_color' 		=> $_POST['link_color'],
			'ref_bg' 			=> $_POST['ref_bg'],
			'ref_color' 		=> $_POST['ref_color'],
			'table_bg' 			=> $_POST['table_bg'],
			'table_color' 		=> $_POST['table_color']
		));
		// user panel customization
		update_option($opt.'user_panel', array(
			'head_bg' 			=> $_POST['head_bg'],
			'head_color' 		=> $_POST['head_color'],
			'body_bg' 			=> $_POST['body_bg'],
			'body_color' 		=> $_POST['body_color'],
			'separator' 		=> $_POST['separator'],
			'link_color' 		=> $_POST['link_color'],
			'pending_bg' 		=> $_POST['pending_bg'],
			'pending_color' 	=> $_POST['pending_color'],
			'active_bg' 		=> $_POST['active_bg'],
			'active_color' 		=> $_POST['active_color'],
			'expired_bg' 		=> $_POST['expired_bg'],
			'expired_color' 	=> $_POST['expired_color'],
			'button_bg' 		=> $_POST['button_bg'],
			'button_color' 		=> $_POST['button_color']
		));
		if ( isset($_POST['custom_js']) && $_POST['custom_js'] != '' ) {
			file_put_contents(plugin_dir_path( __FILE__ ) . '/../frontend/js/custom.js', stripslashes_deep($_POST['custom_js']));
		}

		// re-generate css
		bsa_pro_generate_css( (get_option('bsa_pro_plugin_rtl_support') == 'yes' ? true : null) );

		echo '
		<div class="updated settings-error">
			<p><strong>Settings saved.</strong></p>
		</div>';

	} else {

		if( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'updateSettings' && $_POST["ordering_form_url"] == '' ||
			$_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'updateSettings' && $_POST["ordering_form_url"] == '#' ) {
			echo '
			<div class="updated settings-error">
				<p><strong>Note!</strong> URL to ordering form field is required because is used to display statistics!</p>
			</div>';
		}
	}
}

function bsa_pro_sub_menu_translations()
{
	?>
	<div class="wrap" style="display:none">
		<?php bsaUpdateTranslations(); ?>
		<?php require_once 'translations.php'; ?>
	</div>
<?php
}

function bsaUpdateTranslations()
{
	$opt = 'bsa_pro_plugin_';
	$opt_trans = 'bsa_pro_plugin_trans_';

	if( $_SERVER["REQUEST_METHOD"] == "POST" && $_POST["bsaProAction"] == 'updateTranslations')
	{
		// Translations
		// agency ordering form
		update_option($opt_trans.'agency_title_form', stripslashes($_POST['agency_title_form']));
		update_option($opt_trans.'agency_back_button', stripslashes($_POST['agency_back_button']));
		update_option($opt_trans.'agency_visit_site', stripslashes($_POST['agency_visit_site']));
		update_option($opt_trans.'agency_buy_ad', stripslashes($_POST['agency_buy_ad']));
		// form left
		update_option($opt_trans.'form_left_header', stripslashes($_POST['form_left_header']));
		update_option($opt_trans.'edit_left_header', stripslashes($_POST['edit_left_header']));
		update_option($opt_trans.'form_left_select_space', stripslashes($_POST['form_left_select_space']));
		update_option($opt_trans.'form_left_email', stripslashes($_POST['form_left_email']));
		update_option($opt_trans.'form_left_eg_email', stripslashes($_POST['form_left_eg_email']));
		update_option($opt_trans.'form_left_title', stripslashes($_POST['form_left_title']));
		update_option($opt_trans.'form_left_eg_title', stripslashes($_POST['form_left_eg_title']));
		update_option($opt_trans.'form_left_desc', stripslashes($_POST['form_left_desc']));
		update_option($opt_trans.'form_left_eg_desc', stripslashes($_POST['form_left_eg_desc']));
		update_option($opt_trans.'form_left_url', stripslashes($_POST['form_left_url']));
		update_option($opt_trans.'form_left_eg_url', stripslashes($_POST['form_left_eg_url']));
		update_option($opt_trans.'form_left_thumb', stripslashes($_POST['form_left_thumb']));
		update_option($opt_trans.'form_left_calendar', stripslashes($_POST['form_left_calendar']));
		update_option($opt_trans.'form_left_eg_calendar', stripslashes($_POST['form_left_eg_calendar']));
		// form right
		update_option($opt_trans.'form_right_header', stripslashes($_POST['form_right_header']));
		update_option($opt_trans.'form_right_cpc_name', stripslashes($_POST['form_right_cpc_name']));
		update_option($opt_trans.'form_right_cpm_name', stripslashes($_POST['form_right_cpm_name']));
		update_option($opt_trans.'form_right_cpd_name', stripslashes($_POST['form_right_cpd_name']));
		update_option($opt_trans.'form_right_clicks', stripslashes($_POST['form_right_clicks']));
		update_option($opt_trans.'form_right_views', stripslashes($_POST['form_right_views']));
		update_option($opt_trans.'form_right_days', stripslashes($_POST['form_right_days']));
		update_option($opt_trans.'form_live_preview', stripslashes($_POST['form_live_preview']));
		update_option($opt_trans.'form_right_button_pay', stripslashes($_POST['form_right_button_pay']));
		update_option($opt_trans.'edit_right_button_pay', stripslashes($_POST['edit_right_button_pay']));
		// payments
		update_option($opt_trans.'payment_paid', stripslashes($_POST['payment_paid']));
		update_option($opt_trans.'payment_select', stripslashes($_POST['payment_select']));
		update_option($opt_trans.'payment_return', stripslashes($_POST['payment_return']));
		update_option($opt_trans.'payment_stripe_title', stripslashes($_POST['payment_stripe_title']));
		update_option($opt_trans.'payment_paypal_title', stripslashes($_POST['payment_paypal_title']));
		update_option($opt_trans.'payment_bank_transfer_title', stripslashes($_POST['payment_bank_transfer_title']));
		// alerts
		// success
		update_option($opt_trans.'alert_success', stripslashes($_POST['alert_success']));
		update_option($opt_trans.'form_success', stripslashes($_POST['form_success']));
		update_option($opt_trans.'payment_success', stripslashes($_POST['payment_success']));
		// failed
		update_option($opt_trans.'alert_failed', stripslashes($_POST['alert_failed']));
		update_option($opt_trans.'form_invalid_params', stripslashes($_POST['form_invalid_params']));
		update_option($opt_trans.'form_too_high', stripslashes($_POST['form_too_high']));
		update_option($opt_trans.'form_img_invalid', stripslashes($_POST['form_img_invalid']));
		update_option($opt_trans.'form_empty', stripslashes($_POST['form_empty']));
		update_option($opt_trans.'payment_failed', stripslashes($_POST['payment_failed']));
		// stats section
		update_option($opt_trans.'stats_header', stripslashes($_POST['stats_header']));
		update_option($opt_trans.'stats_views', stripslashes($_POST['stats_views']));
		update_option($opt_trans.'stats_clicks', stripslashes($_POST['stats_clicks']));
		update_option($opt_trans.'stats_ctr', stripslashes($_POST['stats_ctr']));
		update_option($opt_trans.'stats_prev_week', stripslashes($_POST['stats_prev_week']));
		update_option($opt_trans.'stats_next_week', stripslashes($_POST['stats_next_week']));
		// others
		update_option($opt_trans.'powered', stripslashes($_POST['powered']));
		update_option($opt_trans.'free_ads', stripslashes($_POST['free_ads']));
		// example ad
		update_option($opt_trans.'example_title', stripslashes($_POST['example_title']));
		update_option($opt_trans.'example_desc', stripslashes($_POST['example_desc']));
		update_option($opt_trans.'example_url', stripslashes($_POST['example_url']));
		// confirmation email
		update_option($opt_trans.'email_sender', stripslashes($_POST['email_sender']));
		update_option($opt_trans.'email_address', stripslashes($_POST['email_address']));
		// buyer email
		update_option($opt_trans.'buyer_subject', stripslashes($_POST['buyer_subject']));
		update_option($opt_trans.'buyer_message', stripslashes($_POST['buyer_message']));
		// seller email
		update_option($opt_trans.'seller_subject', stripslashes($_POST['seller_subject']));
		update_option($opt_trans.'seller_message', stripslashes($_POST['seller_message']));
		// notifications
		update_option($opt_trans.'expires_subject', stripslashes($_POST['expires_subject']));
		update_option($opt_trans.'expires_message', stripslashes($_POST['expires_message']));
		update_option($opt_trans.'expired_subject', stripslashes($_POST['expired_subject']));
		update_option($opt_trans.'expired_message', stripslashes($_POST['expired_message']));
		// affiliate program trans
		update_option($opt_trans.'affiliate_program', array(
			'commission' 		=> stripslashes($_POST['ap_commission']),
			'each_sale' 		=> stripslashes($_POST['ap_each_sale']),
			'balance' 			=> stripslashes($_POST['ap_balance']),
			'make' 				=> stripslashes($_POST['ap_make']),
			'ref_link' 			=> stripslashes($_POST['ap_ref_link']),
			'ref_notice' 		=> stripslashes($_POST['ap_ref_notice']),
			'ref_users' 		=> stripslashes($_POST['ap_ref_users']),
			'date' 				=> stripslashes($_POST['ap_date']),
			'buyer' 			=> stripslashes($_POST['ap_buyer']),
			'order' 			=> stripslashes($_POST['ap_order']),
			'comm_rate' 		=> stripslashes($_POST['ap_comm_rate']),
			'your_comm' 		=> stripslashes($_POST['ap_your_comm']),
			'empty' 			=> stripslashes($_POST['ap_empty']),
			'affiliate' 		=> stripslashes($_POST['ap_affiliate']),
			'earnings' 			=> stripslashes($_POST['ap_earnings']),
			'payment' 			=> stripslashes($_POST['ap_payment']),
			'button' 			=> stripslashes($_POST['ap_button']),
			'id' 				=> stripslashes($_POST['ap_id']),
			'user_id' 			=> stripslashes($_POST['ap_user_id']),
			'amount' 			=> stripslashes($_POST['ap_amount']),
			'account' 			=> stripslashes($_POST['ap_account']),
			'status' 			=> stripslashes($_POST['ap_status']),
			'pending' 			=> stripslashes($_POST['ap_pending']),
			'done' 				=> stripslashes($_POST['ap_done']),
			'rejected' 			=> stripslashes($_POST['ap_rejected']),
			'withdrawals' 		=> stripslashes($_POST['ap_withdrawals']),
			'success' 			=> stripslashes($_POST['ap_success']),
			'failed' 			=> stripslashes($_POST['ap_failed'])
		));
		// user panel trans
		update_option($opt_trans.'user_panel', array(
			'ad_content' 		=> stripslashes($_POST['up_ad_content']),
			'buyer' 			=> stripslashes($_POST['up_buyer']),
			'stats' 			=> stripslashes($_POST['up_stats']),
			'display_limit' 	=> stripslashes($_POST['up_display_limit']),
			'order_details' 	=> stripslashes($_POST['up_order_details']),
			'actions' 			=> stripslashes($_POST['up_actions']),
			'views' 			=> stripslashes($_POST['up_views']),
			'clicks' 			=> stripslashes($_POST['up_clicks']),
			'days' 				=> stripslashes($_POST['up_days']),
			'ctr' 				=> stripslashes($_POST['up_ctr']),
			'full_stats' 		=> stripslashes($_POST['up_full_stats']),
			'billing_model' 	=> stripslashes($_POST['up_billing_model']),
			'cpc' 				=> stripslashes($_POST['up_cpc']),
			'cpm' 				=> stripslashes($_POST['up_cpm']),
			'cpd' 				=> stripslashes($_POST['up_cpd']),
			'cost' 				=> stripslashes($_POST['up_cost']),
			'paid' 				=> stripslashes($_POST['up_paid']),
			'not_paid' 			=> stripslashes($_POST['up_not_paid']),
			'free' 				=> stripslashes($_POST['up_free']),
			'status' 			=> stripslashes($_POST['up_status']),
			'active' 			=> stripslashes($_POST['up_active']),
			'pending' 			=> stripslashes($_POST['up_pending']),
			'expired' 			=> stripslashes($_POST['up_expired']),
			'edit' 				=> stripslashes($_POST['up_edit']),
			'pay_now' 			=> stripslashes($_POST['up_pay_now']),
			'renewal' 			=> stripslashes($_POST['up_renewal']),
			'buy_ads' 			=> stripslashes($_POST['up_buy_ads']),
			'first_purchase' 	=> stripslashes($_POST['up_first_purchase']),
			'login_here' 		=> stripslashes($_POST['up_login_here']),
		));
		update_option($opt.'translations', array(
			// woo
			'woo_title' 		=> $_POST['woo_title'],
			'woo_button' 		=> $_POST['woo_button']
		));
		update_option($opt_trans.'order_form', array(
			// additional
			'optional_field' 	=> $_POST['optional_field'],
			'eg_optional_field' => $_POST['eg_optional_field'],
			'form_notice' 		=> $_POST['form_notice'],
			'login_notice' 		=> $_POST['login_notice'],
		));
		// statistics
		update_option($opt_trans.'statistics', array(
			'full_stats' 		=> $_POST['full_stats'],
			'last_90' 			=> $_POST['last_90'],
			'last_30' 			=> $_POST['last_30'],
			'last_7' 			=> $_POST['last_7'],
		));
		// additional actions
		do_action( 'bsa-pro-update-translations', $_POST, $opt_trans);
		echo '
		<div class="updated settings-error">
			<p><strong>Translations saved.</strong></p>
		</div>';
	}
}

function bsa_pro_sub_menu_users()
{
	?>
	<div class="wrap" style="display:none">
		<?php $model = new BSA_PRO_Model(); $model->getAdminAction() ?>
		<?php require_once 'users-manager.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_cron()
{
	?>
	<div class="wrap" style="display:none">
		<?php if ( get_option("bsa_pro_plugin_purchase_code") == '' || get_option("bsa_pro_plugin_purchase_code") == null ) {
			echo '
			<div class="updated settings-error">
				<p><strong>NOTE!</strong> Enter the <strong>purchase code</strong> in the settings to use all functions of ADS PRO! Thanks!</p>
			</div>';
		}
		$model = new BSA_PRO_Model(); $model->getAdminAction() ?>
		<?php require_once 'cron.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_ab_tests()
{
	?>
	<div class="wrap" style="display:none">
		<?php $model = new BSA_PRO_Model(); $model->getAdminAction() ?>
		<?php require_once 'ab-tests.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_affiliate()
{
	?>
	<div class="wrap" style="display:none">
		<?php $model = new BSA_PRO_Model(); $model->getAdminAction() ?>
		<?php require_once 'affiliate.php'; ?>
	</div>
<?php
}

function bsa_pro_sub_menu_updates()
{
	?>
	<div class="wrap" style="display:none">
		<?php $model = new BSA_PRO_Model(); $model->getAdminAction() ?>
		<?php require_once 'updates.php'; ?>
	</div>
<?php
}

function bsa_pro_create_menu()
{
	if ( is_multisite() && is_main_site() || !is_multisite() ) {
		$count = strlen(get_option('bsa_pro_plugin_purchase_code'));
		$icon_url = plugins_url('../frontend/img/bsa-icon.png', __FILE__);
		$role = ((bsa_role() == 'admin') ? 'a' : 'u');
		$affiliate_name = bsa_get_trans('affiliate_program', 'affiliate');
		add_menu_page('ADS PRO - Dashboard', 'ADS PRO', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu', 'bsa_pro_head_menu', $icon_url);
		add_submenu_page('bsa-pro-sub-menu', 'Spaces and Ads', 'Spaces and Ads', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-spaces', 'bsa_pro_sub_menu_spaces');
		add_submenu_page('bsa-pro-sub-menu', 'Add new Space', 'Add new Space', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-add-new-space', 'bsa_pro_sub_menu_add_new_space');
		add_submenu_page('bsa-pro-sub-menu', 'Add new Ad', 'Add new Ad', 'read', 'bsa-pro-sub-menu-add-new-ad', 'bsa_pro_sub_menu_add_new_ad');
		if ($count == 36) {
			add_submenu_page('bsa-pro-sub-menu', 'Standard Ad Creator', 'Standard Ad Creator', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-creator', 'bsa_pro_sub_menu_creator');
			add_submenu_page('bsa-pro-sub-menu', 'Ads Schedule', 'Ads Schedule', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-cron', 'bsa_pro_sub_menu_cron');
			add_submenu_page('bsa-pro-sub-menu', 'A/B Tests', 'A/B Tests', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-ab-tests', 'bsa_pro_sub_menu_ab_tests');
			add_submenu_page('bsa-pro-sub-menu', (($role == 'a') ? 'Users Manager' : 'Your Ads'), (($role == 'a') ? 'Users Manager' : 'Your Ads'), 'read', 'bsa-pro-sub-menu-users', 'bsa_pro_sub_menu_users');
			if ( is_plugin_active( 'bsa-pro-ap-scripteo/bsa-pro-ap.php' ) ) {
				add_submenu_page('bsa-pro-sub-menu', (($affiliate_name != '') ? $affiliate_name : 'Affiliate Program'), (($affiliate_name != '') ? $affiliate_name : 'Affiliate Program'), 'read', 'bsa-pro-sub-menu-affiliate', 'bsa_pro_sub_menu_affiliate');
			}
		}
		add_submenu_page('bsa-pro-sub-menu', 'Settings', 'Settings', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-opts', 'bsa_pro_sub_menu_settings');
		add_submenu_page('bsa-pro-sub-menu', 'Translations', 'Translations', (($role == 'a') ? 'read' : 'manage_options'), 'bsa-pro-sub-menu-trans', 'bsa_pro_sub_menu_translations');
//	add_submenu_page('bsa-pro-sub-menu', 'Updates', 'Updates', 'manage_options', 'bsa-pro-sub-menu-upd', 'bsa_pro_sub_menu_updates');
	}
}
add_action('admin_menu', 'bsa_pro_create_menu');

function bsa_pro_pages_body_class( $classes ) {
	$classes[] = 'bsa_pro_pages_body_class';
	return $classes;
}
add_filter( 'admin_body_class ', 'bsa_pro_pages_body_class' );


class AdsProPagination
{
	const PAGE_SIZE = 40;

	private function getCount($list)
	{
		$model = new BSA_PRO_Model();

		if ( $list == 'users' ) {
			return count($model->getUsersList());
		} elseif ( $list == 'tasks' ) {
			return count($model->getCronTasks());
		} else {
			return self::PAGE_SIZE;
		}
	}

	public function getNext($list)
	{
		$page = $this->getPage();

		if ($page * self::PAGE_SIZE >= $this->getCount($list))
			return null;

		return $page + 1;
	}

	public function getPrev()
	{
		$page = $this->getPage();

		if ($page == 1)
			return null;

		return $page - 1;
	}

	private function getPage()
	{
		$page = abs(isset($_GET['pagination']) ? $_GET['pagination'] : 0);

		if ($page < 1)
			$page = 1;

		return $page;
	}

	public function getUsersPages()
	{
		$page = $this->getPage();

		$pages = array();
		$model = new BSA_PRO_Model();

		if ( $model->getUsersList($page, self::PAGE_SIZE) )
			foreach ($model->getUsersList($page, self::PAGE_SIZE) as $entry)
				$pages[] = $entry;

		if ($page > 1 and !count($pages)) {
			return 'not_found';
		}

		return $pages;
	}

	public function getTasksPages()
	{
		$page = $this->getPage();

		$pages = array();
		$model = new BSA_PRO_Model();

		if ( $model->getCronTasks(null, $page, self::PAGE_SIZE) )
			foreach ($model->getCronTasks(null, $page, self::PAGE_SIZE) as $entry)
				$pages[] = $entry;

		if ($page > 1 and !count($pages)) {
			return 'not_found';
		}

		return $pages;
	}
}