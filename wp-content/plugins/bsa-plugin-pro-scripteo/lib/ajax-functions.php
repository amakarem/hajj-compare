<?php

function bsa_pro_ajax_load_ad_space()
{
	$pid 			= $_POST['pid'];
	$id 			= $_POST['id'];
	$max_width 		= ( isset($_POST['max_width']) ? $_POST['max_width'] : null );
	$delay 			= ( isset($_POST['delay']) ? $_POST['delay'] : null );
	$padding_top 	= ( isset($_POST['padding_top']) ? $_POST['padding_top'] : null );
	$attachment 	= ( isset($_POST['attachment']) ? $_POST['attachment'] : null );
	$if_empty 		= ( isset($_POST['if_empty']) ? $_POST['if_empty'] : null );
	$custom_image 	= ( isset($_POST['custom_image']) ? $_POST['custom_image'] : null );
	$powered 		= ( isset($_POST['powered']) ? $_POST['powered'] : null );
	$show_ids 		= ( isset($_POST['show_ids']) ? $_POST['show_ids'] : null );
	$hide_for_id 	= ( isset($_POST['hide_for_id']) ? $_POST['hide_for_id'] : null );

	if ( !in_array($pid, explode(',', $hide_for_id)) && function_exists('bsa_pro_ad_space') ) {
		echo bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, 'ajax', $if_empty, $custom_image, $powered, $show_ids);
	} else {
		echo null;
	}
	die();
}
add_action('wp_ajax_bsa_pro_ajax_load_ad_space', 'bsa_pro_ajax_load_ad_space');
add_action( 'wp_ajax_nopriv_bsa_pro_ajax_load_ad_space', 'bsa_pro_ajax_load_ad_space' );

function bsa_preview_callback()
{
	if( $_POST && isset($_POST['bsa_template']) ) {
		require dirname(__FILE__) . '/../frontend/template/'.$_POST['bsa_template'].'.php';
	} elseif( $_POST && isset($_POST['bsa_space_id']) ) {
		require dirname(__FILE__) . '/../frontend/template/'.bsa_space($_POST['bsa_space_id'],'template').'.php';
	} else {
		echo 'Templates can not be download.';
	}
	die();
}
add_action('wp_ajax_bsa_preview_callback', 'bsa_preview_callback');
add_action( 'wp_ajax_nopriv_bsa_preview_callback', 'bsa_preview_callback' );

function bsa_required_inputs_callback()
{
	if( $_POST && $_POST['bsa_space_id'] && $_POST['bsa_get_required_inputs'] ) {
		echo require dirname(__FILE__) . '/../frontend/template/'.bsa_space($_POST['bsa_space_id'],'template').'.php';
	} else {
		echo 'Required inputs can not be download.';
	}
	die();
}
add_action('wp_ajax_bsa_required_inputs_callback', 'bsa_required_inputs_callback');
add_action( 'wp_ajax_nopriv_bsa_required_inputs_callback', 'bsa_required_inputs_callback' );

function bsa_get_billing_models_callback()
{
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

	if( $_POST && $_POST['bsa_space_id'] ) {
		$sid = $_POST['bsa_space_id'];
		$admin = (isset($_POST['bsa_pro_admin']) ? $_POST['bsa_pro_admin'] : null); // if admin panel

		echo '<div class="bsaProInputsGroup bsaProInputsBillingModel">';
			if ( bsa_space($sid, 'cpc_price') != NULL && bsa_space($sid, 'cpc_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpc_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner bsaInputInnerModel">
						<input id="bsa_pro_cpc_model" type="radio" name="ad_model" value="cpc" onchange="selectBillingModel()">
						<label for="bsa_pro_cpc_model">'.get_option("bsa_pro_plugin_trans_"."form_right_cpc_name").'</label>
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpm_price') != NULL && bsa_space($sid, 'cpm_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpm_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner bsaInputInnerModel">
						<input id="bsa_pro_cpm_model" type="radio" name="ad_model" value="cpm" onchange="selectBillingModel()">
						<label for="bsa_pro_cpm_model">'.get_option("bsa_pro_plugin_trans_"."form_right_cpm_name").'</label>
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpd_price') != NULL && bsa_space($sid, 'cpd_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpd_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner bsaInputInnerModel">
						<input id="bsa_pro_cpd_model" type="radio" name="ad_model" value="cpd" onchange="selectBillingModel()">
						<label for="bsa_pro_cpd_model">'.get_option("bsa_pro_plugin_trans_"."form_right_cpd_name").'</label>
					</div>
				</div>';
			}
			do_action( 'bsa-pro-billing-models-callback', $sid );
		echo '</div>';

		$model = new BSA_PRO_Model();
		$get_free_ads = $model->getUserCol(get_current_user_id(), 'free_ads');
		$free_ads = (isset($get_free_ads['free_ads']) && $get_free_ads['free_ads'] > 0) ? $get_free_ads['free_ads'] : 0;
		if ( bsa_space($sid, 'cpc_price') != NULL && bsa_space($sid, 'cpc_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpc_price') == 0.00 && bsa_role() == 'admin' ) {
			echo '<div class="bsaProInputsGroup bsaProInputsValues bsaProInputsValuesCPC" style="display: none;">';
			do_action( 'bsa-pro-billing-models-before', $sid, 'cpc', $before, $after);
			if ( bsa_space($sid, 'cpc_contract_1') != NULL && bsa_space($sid, 'cpc_contract_1') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpc_1" type="radio" name="ad_limit_cpc" value="'.bsa_space($sid, 'cpc_contract_1').'">
						<label for="bsa_pro_ad_limit_cpc_1">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpc_contract_1').' '.get_option("bsa_pro_plugin_trans_"."form_right_clicks").'</span>
							';
							if ( isset($_POST['bsa_order']) ) {
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : bsa_space($sid, 'cpc_price'))).$after.'</span>';
							}
							echo '
						</label>
					</div>
				</div>';
			} elseif ( $admin == 1 && bsa_space($sid, 'cpc_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<label for="bsa_pro_ad_limit_cpc_1">Display Limit (clicks)</label>
						<input id="bsa_pro_ad_limit_cpc_1" type="number" name="ad_limit_cpc" value="" style="margin-top:10px;width: 100%;">
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpc_contract_2') != NULL && bsa_space($sid, 'cpc_contract_2') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpc_2" type="radio" name="ad_limit_cpc" value="'.bsa_space($sid, 'cpc_contract_2').'">
						<label for="bsa_pro_ad_limit_cpc_2">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpc_contract_2').' '.get_option("bsa_pro_plugin_trans_"."form_right_clicks").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpc_2 = (bsa_space($sid, 'cpc_price') * (bsa_space($sid, 'cpc_contract_2') / bsa_space($sid, 'cpc_contract_1')));
								$d_cpc_2 = ((bsa_space($sid, 'discount_2') > 0) ? $cpc_2 * (bsa_space($sid, 'discount_2') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpc_2 - $d_cpc_2)).$after.'</span>';
								if ( bsa_space($sid, 'discount_2') > 0 && $free_ads == 0 ) {
									echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_2').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpc_contract_3') != NULL && bsa_space($sid, 'cpc_contract_3') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpc_3" type="radio" name="ad_limit_cpc" value="'.bsa_space($sid, 'cpc_contract_3').'">
						<label for="bsa_pro_ad_limit_cpc_3">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpc_contract_3').' '.get_option("bsa_pro_plugin_trans_"."form_right_clicks").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpc_3 = (bsa_space($sid, 'cpc_price') * (bsa_space($sid, 'cpc_contract_3') / bsa_space($sid, 'cpc_contract_1')));
								$d_cpc_3 = ((bsa_space($sid, 'discount_3') > 0) ? $cpc_3 * (bsa_space($sid, 'discount_3') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpc_3 - $d_cpc_3)).$after.'</span>';
								if ( bsa_space($sid, 'discount_3') > 0 && $free_ads == 0 ) {
									echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_3').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			echo '</div>';
		}

		if ( bsa_space($sid, 'cpm_price') != NULL && bsa_space($sid, 'cpm_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpm_price') == 0.00 && bsa_role() == 'admin' ) {
			echo '<div class="bsaProInputsGroup bsaProInputsValues bsaProInputsValuesCPM" style="display: none;">';
			do_action( 'bsa-pro-billing-models-before', $sid, 'cpm', $before, $after);
			if ( bsa_space($sid, 'cpm_contract_1') != NULL && bsa_space($sid, 'cpm_contract_1') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpm_1" type="radio" name="ad_limit_cpm" value="'.bsa_space($sid, 'cpm_contract_1').'">
						<label for="bsa_pro_ad_limit_cpm_1">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpm_contract_1').' '.get_option("bsa_pro_plugin_trans_"."form_right_views").'</span>
							';
							if ( isset($_POST['bsa_order']) ) {
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : bsa_space($sid, 'cpm_price'))).$after.'</span>';
							}
							echo '
						</label>
					</div>
				</div>';
			} elseif ( $admin == 1 && bsa_space($sid, 'cpm_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<label for="bsa_pro_ad_limit_cpm_1">Display Limit (views)</label>
						<input id="bsa_pro_ad_limit_cpm_1" type="number" name="ad_limit_cpm" value="" style="margin-top:10px;width: 100%;">
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpm_contract_2') != NULL && bsa_space($sid, 'cpm_contract_2') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpm_2" type="radio" name="ad_limit_cpm" value="'.bsa_space($sid, 'cpm_contract_2').'">
						<label for="bsa_pro_ad_limit_cpm_2">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpm_contract_2').' '.get_option("bsa_pro_plugin_trans_"."form_right_views").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpm_2 = (bsa_space($sid, 'cpm_price') * (bsa_space($sid, 'cpm_contract_2') / bsa_space($sid, 'cpm_contract_1')));
								$d_cpm_2 = ((bsa_space($sid, 'discount_2') > 0) ? $cpm_2 * (bsa_space($sid, 'discount_2') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpm_2 - $d_cpm_2)).$after.'</span>';
								if ( bsa_space($sid, 'discount_2') > 0 && $free_ads == 0 ) {
									echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_2').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpm_contract_3') != NULL && bsa_space($sid, 'cpm_contract_3') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpm_3" type="radio" name="ad_limit_cpm" value="'.bsa_space($sid, 'cpm_contract_3').'">
						<label for="bsa_pro_ad_limit_cpm_3">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpm_contract_3').' '.get_option("bsa_pro_plugin_trans_"."form_right_views").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpm_3 = (bsa_space($sid, 'cpm_price') * (bsa_space($sid, 'cpm_contract_3') / bsa_space($sid, 'cpm_contract_1')));
								$d_cpm_3 = ((bsa_space($sid, 'discount_3') > 0) ? $cpm_3 * (bsa_space($sid, 'discount_3') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpm_3 - $d_cpm_3)).$after.'</span>';
								if ( bsa_space($sid, 'discount_3') > 0 && $free_ads == 0 ) {
								echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_3').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			echo '</div>';
		}

		if ( bsa_space($sid, 'cpd_price') != NULL && bsa_space($sid, 'cpd_price') != 0.00 || $admin == 1 && bsa_space($sid, 'cpd_price') == 0.00 && bsa_role() == 'admin' ) {
			echo '<div class="bsaProInputsGroup bsaProInputsValues bsaProInputsValuesCPD" style="display: none;">';
			do_action( 'bsa-pro-billing-models-before', $sid, 'cpd', $before, $after);
			if ( bsa_space($sid, 'cpd_contract_1') != NULL && bsa_space($sid, 'cpd_contract_1') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpd_1" type="radio" name="ad_limit_cpd" value="'.bsa_space($sid, 'cpd_contract_1').'">
						<label for="bsa_pro_ad_limit_cpd_1">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpd_contract_1').' '.get_option("bsa_pro_plugin_trans_"."form_right_days").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : bsa_space($sid, 'cpd_price'))).$after.'</span>';
							}
							echo '
						</label>
					</div>
				</div>';
			} elseif ( $admin == 1 && bsa_space($sid, 'cpd_price') == 0.00 && bsa_role() == 'admin' ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<label for="bsa_pro_ad_limit_cpd_1">Display Limit (days)</label>
						<input id="bsa_pro_ad_limit_cpd_1" type="number" name="ad_limit_cpd" value="" style="margin-top:10px;width: 100%;">
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpd_contract_2') != NULL && bsa_space($sid, 'cpd_contract_2') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpd_2" type="radio" name="ad_limit_cpd" value="'.bsa_space($sid, 'cpd_contract_2').'">
						<label for="bsa_pro_ad_limit_cpd_2">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpd_contract_2').' '.get_option("bsa_pro_plugin_trans_"."form_right_days").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpd_2 = (bsa_space($sid, 'cpd_price') * (bsa_space($sid, 'cpd_contract_2') / bsa_space($sid, 'cpd_contract_1')));
								$d_cpd_2 = ((bsa_space($sid, 'discount_2') > 0) ? $cpd_2 * (bsa_space($sid, 'discount_2') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpd_2 - $d_cpd_2)).$after.'</span>';
								if ( bsa_space($sid, 'discount_2') > 0 && $free_ads == 0 ) {
									echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_2').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			if ( bsa_space($sid, 'cpd_contract_3') != NULL && bsa_space($sid, 'cpd_contract_3') != 0 ) {
				echo '
				<div class="bsaProInput">
					<div class="bsaInputInner">
						<input id="bsa_pro_ad_limit_cpd_3" type="radio" name="ad_limit_cpd" value="'.bsa_space($sid, 'cpd_contract_3').'">
						<label for="bsa_pro_ad_limit_cpd_3">
							<span class="bsaProExpiration">'.bsa_space($sid, 'cpd_contract_3').' '.get_option("bsa_pro_plugin_trans_"."form_right_days").'</span>';
							if ( isset($_POST['bsa_order']) ) {
								$cpd_3 = (bsa_space($sid, 'cpd_price') * (bsa_space($sid, 'cpd_contract_3') / bsa_space($sid, 'cpd_contract_1')));
								$d_cpd_3 = ((bsa_space($sid, 'discount_3') > 0) ? $cpd_3 * (bsa_space($sid, 'discount_3') / 100) : 0);
								echo '<span class="bsaProPrice">'.$before.bsa_number_format(($free_ads > 0 ? 0 : $cpd_3 - $d_cpd_3)).$after.'</span>';
								if ( bsa_space($sid, 'discount_3') > 0 && $free_ads == 0 ) {
									echo '<span class="bsaProDiscount">(-'.bsa_space($sid, 'discount_3').'%)</span>';
								}
							}
							echo '
						</label>
					</div>
				</div>';
			}
			echo '</div>';
		}
		if ( isset($_POST['bsa_order']) ) {
			do_action( 'bsa-pro-billing-models-callback-sub', $sid, $_POST['bsa_order'], $before, $after );
		}
	} else {
		echo 'Spaces can not be download.';
	}
	die();
}
add_action('wp_ajax_bsa_get_billing_models_callback', 'bsa_get_billing_models_callback');
add_action( 'wp_ajax_nopriv_bsa_get_billing_models_callback', 'bsa_get_billing_models_callback' );

function bsa_stats_chart_callback()
{
	if( isset($_POST) && isset($_POST['ad_id']) ) {
		$model = new BSA_PRO_Model();
		$ad_id = $_POST['ad_id'];
		$days = $_POST['days'];
		echo json_encode(array(
			"labels" => array(
				date('m.d', time() - ( ($days - 1) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 2) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 3) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 4) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 5) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 6) * 24 * 60 * 60 )),
				date('m.d', time() - ( ($days - 7) * 24 * 60 * 60 ))
			),
			"clicks" => array(
				$model->bsaChartClicks($ad_id, $days),
				$model->bsaChartClicks($ad_id, $days - 1),
				$model->bsaChartClicks($ad_id, $days - 2),
				$model->bsaChartClicks($ad_id, $days - 3),
				$model->bsaChartClicks($ad_id, $days - 4),
				$model->bsaChartClicks($ad_id, $days - 5),
				$model->bsaChartClicks($ad_id, $days - 6)
			),
			"views" => array(
				$model->bsaChartViews($ad_id, $days),
				$model->bsaChartViews($ad_id, $days - 1),
				$model->bsaChartViews($ad_id, $days - 2),
				$model->bsaChartViews($ad_id, $days - 3),
				$model->bsaChartViews($ad_id, $days - 4),
				$model->bsaChartViews($ad_id, $days - 5),
				$model->bsaChartViews($ad_id, $days - 6)
			)
		));
	} else {
		echo 'Stats can not be download.';
	}
	die();
}
add_action('wp_ajax_bsa_stats_chart_callback', 'bsa_stats_chart_callback');
add_action( 'wp_ajax_nopriv_bsa_stats_chart_callback', 'bsa_stats_chart_callback' );

function bsa_stats_clicks_callback()
{
	if( isset($_POST) && isset($_POST['ad_id']) ) {
		do_action( 'bsa-pro-stats-clicks', $_POST);
		$model = new BSA_PRO_Model();
		$ad_id = $_POST['ad_id'];
		$days = $_POST['days'];
		$clicks = $model->bsaGetClicks($ad_id, $days);
		if ( $clicks != null ) {
			echo '	<table>
			<tbody>';
			foreach ( $clicks as $click ) {
				echo '
				<tr class="'.(( date('d', $click['action_time']) % 2 == 0) ? "bsaEven" : "bsaOdd").'">
					<td width="20%">'.date('Y/m/d', $click['action_time']).'</td>
					<td width="40%">'.substr($click['user_ip'], 0, -3).'***</td>
					<td width="30%">'.$click['browser'].'</td>
					<td width="10%">'.( ( $click['status'] == "correct" ) ? "<span class='bsaCorrectIcon'></span>" : "<span class='bsaInCorrectIcon'></span>" ).'</td>
				</tr>
				';
			};
			echo '
			</tbody>
			</table>';
		} else {
			return null;
		}
	} else {
		echo 'Stats can not be download.';
	}
	die();
}
add_action('wp_ajax_bsa_stats_clicks_callback', 'bsa_stats_clicks_callback');
add_action( 'wp_ajax_nopriv_bsa_stats_clicks_callback', 'bsa_stats_clicks_callback' );

// Ads Sortable Function
function bsa_sortable_callback()
{
	if( $_POST && isset($_POST['bsa_order']) ) {
		$ads = $_POST['bsa_order'];
		$model = new BSA_PRO_Model();

		foreach ( $ads as $key => $ad )
			$model->changeAdPriority($ad, count($ads) - $key);
	}
	die();
}
add_action('wp_ajax_bsa_sortable_callback', 'bsa_sortable_callback');
add_action( 'wp_ajax_nopriv_bsa_sortable_callback', 'bsa_sortable_callback' );

// Get All Unselected Elements
function bsa_unselected()
{
	$ajax_limit = $_POST['ajax_limit'];
	$get_type = $_POST['type'];
	$space_id = $_POST['space_id'];
	$offset = $_POST['bsa_offset'];

	if ( $get_type == 'posts' ) {
		if ( is_multisite() ) {

			// Current Site
			$current = get_current_site();

			// All Sites
			$blogs = json_decode(json_encode(get_sites()), true);

			foreach ( $blogs as $blog ) {

				// switch to the blog
				switch_to_blog( $blog['blog_id'] );

				// get only selected entry
				$getEntryIds = null;
				if ( isset($space_id) ) {
					$getIds = json_decode(bsa_space($space_id, 'advanced_opt'));
					if ( isset($getIds->hide_for_id) ) {
						foreach ( explode(',', $getIds->hide_for_id) as $getId ) {
							if ( substr($getId, 0, 1) == $blog['blog_id'] ) {
								$getEntryIds[] = substr($getId, 1);
							}
						}
					}
				}

				// get_categories args
				$args = array( 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'posts_per_page' => $ajax_limit );
				$allPosts = get_posts( $args );
				if ($allPosts) {
					foreach($allPosts as $key => $post) {
						echo '
						<li class="bsaProSpecificItem bsaCheckItem-PO'.$post->ID.'-'.$blog['blog_id'].'">
							<label class="selectit"><input value="'.$blog['blog_id'].$post->ID.'" class="bsaCheckItem" section="PO" itemId="PO'.$post->ID.'-'.$blog['blog_id'].'" type="checkbox" name="hide_for_id[]">
							'.$post->post_title.' (site id: '.$blog['blog_id'].')</label>
						</li>';
					}
				}

			}

			// return to the current site
			switch_to_blog( $current->id );

		} else {

			// get only selected entry
			$getEntryIds = null;
			if ( isset($space_id) ) {
				$getIds = json_decode(bsa_space($space_id, 'advanced_opt'));
				if ( isset($getIds->hide_for_id) ) {
					foreach ( explode(',', $getIds->hide_for_id) as $getId ) {
						$getEntryIds[] = $getId;
					}
				}
			}

			$args = array( 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'posts_per_page' => $ajax_limit );
			$allPosts = get_posts( $args );
			if ($allPosts) {
				foreach($allPosts as $post) {
					echo '<li class="bsaProSpecificItem bsaCheckItem-PO'.$post->ID.'">
						<label class="selectit"><input value="'.$post->ID.'" class="bsaCheckItem" section="PO" itemId="PO'.$post->ID.'" type="checkbox" name="hide_for_id[]"> '.$post->post_title.'</label>
					</li>';
				}
			}

		}

	} elseif ( $get_type = 'pages' ){
		if ( is_multisite() ) {

			// Current Site
			$current = get_current_site();

			// All Sites
			$blogs = json_decode(json_encode(get_sites()), true);

			foreach ( $blogs as $blog ) {

				// switch to the blog
				switch_to_blog( $blog['blog_id'] );

				// get only selected entry
				$getEntryIds = null;
				if ( isset($space_id) ) {
					$getIds = json_decode(bsa_space($space_id, 'advanced_opt'));
					if ( isset($getIds->hide_for_id) ) {
						foreach ( explode(',', $getIds->hide_for_id) as $getId ) {
							if ( substr($getId, 0, 1) == $blog['blog_id'] ) {
								$getEntryIds[] = substr($getId, 1);
							}
						}
					}
				}

				// get_categories args
				$args = array( 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $ajax_limit );
				$allPosts = get_pages( $args );
				if ($allPosts) {
					foreach($allPosts as $key => $post) {
						echo '
						<li class="bsaProSpecificItem bsaCheckItem-PA'.$post->ID.'-'.$blog['blog_id'].'">
							<label class="selectit"><input value="'.$blog['blog_id'].$post->ID.'" class="bsaCheckItem" section="PA" itemId="PA'.$post->ID.'-'.$blog['blog_id'].'" type="checkbox" name="hide_for_id[]">
							'.$post->post_title.' (site id: '.$blog['blog_id'].')</label>
						</li>';
					}
				}

			}

			// return to the current site
			switch_to_blog( $current->id );

		} else {

			// get only selected entry
			$getEntryIds = null;
			if ( isset($space_id) ) {
				$getIds = json_decode(bsa_space($space_id, 'advanced_opt'));
				if ( isset($getIds->hide_for_id) ) {
					foreach ( explode(',', $getIds->hide_for_id) as $getId ) {
						$getEntryIds[] = $getId;
					}
				}
			}

			$args = array( 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $ajax_limit );
			$allPosts = get_pages( $args );
			if ($allPosts) {
				foreach($allPosts as $post) {
					echo '<li class="bsaProSpecificItem bsaCheckItem-PA'.$post->ID.'">
						<label class="selectit"><input value="'.$post->ID.'" class="bsaCheckItem" section="PA" itemId="PA'.$post->ID.'" type="checkbox" name="hide_for_id[]"> '.$post->post_title.'</label>
					</li>';
				}
			}

		}
	} elseif ( $get_type == 'tags' ) {
		if ( is_multisite() ) {

			// Current Site
			$current = get_current_site();

			// All Sites
			$blogs = json_decode(json_encode(get_sites()), true);

			foreach ( $blogs as $blog ) {

				// switch to the blog
				switch_to_blog( $blog['blog_id'] );

				// get only selected tags
				$getEntryIds = null;
				if ( isset($space_id) ) {
					$getIds = bsa_space($space_id, 'has_tags');
					foreach ( explode(',', $getIds) as $getId ) {
						$getId = get_term_by('name', $getId, 'post_tag');
						if ( isset( $getId->term_id ) ) {
							$getEntryIds[] = $getId->term_id;
						}
					}
				}

				$args = array( 'taxonomy' => 'post_tag', 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $offset + $ajax_limit );
				$posttags = get_terms($args);
				if ($posttags) {
					foreach($posttags as $key => $tag) {
						?>
						<li class="bsaProSpecificItem bsaCheckItem-T<?php echo $key.$tag->term_id; ?>-<?php echo $blog['blog_id']; ?>">
							<label class="selectit"><input value="<?php echo $tag->name; ?>" class="bsaCheckItem" section="T" itemId="T<?php echo $key.$tag->term_id; ?>-<?php echo $blog['blog_id']; ?>" type="checkbox" name="space_tags[]">
								<?php echo $tag->name; ?> (site id: <?php echo $blog['blog_id']; ?>)</label>
						</li>
					<?php
					}
				}

			}

			// return to the current site
			switch_to_blog( $current->id );

		} else {

			// get only selected tags
			$getEntryIds = null;
			if ( isset($space_id) ) {
				$getIds = bsa_space($space_id, 'has_tags');
				foreach ( explode(',', $getIds) as $getId ) {
					$getId = get_term_by('name', $getId, 'post_tag');
					if ( isset( $getId->term_id ) ) {
						$getEntryIds[] = $getId->term_id;
					}
				}
			}

			$args = array( 'taxonomy' => 'post_tag', 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $offset + $ajax_limit );
			$posttags = get_terms($args);
			if ($posttags) {
				foreach($posttags as $key => $tag) {
					$rand = rand(100,1000);
					?>
					<li class="bsaProSpecificItem bsaCheckItem-T<?php echo $key.$rand; ?>">
						<label class="selectit"><input value="<?php echo $tag->name; ?>" class="bsaCheckItem" section="T" itemId="T<?php echo $key.$rand; ?>" type="checkbox" name="space_tags[]">
							<?php echo $tag->name; ?></label>
					</li>
				<?php
				}
			}

		}
	} elseif ( $get_type = 'categories' ){
		if ( is_multisite() ) {

			// Current Site
			$current = get_current_site();

			// All Sites
			$blogs = json_decode(json_encode(get_sites()), true);

			foreach ( $blogs as $blog ) {

				// switch to the blog
				switch_to_blog( $blog['blog_id'] );

				// get only selected tags
				$getEntryIds = null;
				if ( isset($space_id) ) {
					$getIds = bsa_space($space_id, 'in_categories');
					foreach ( explode(',', $getIds) as $getId ) {
						$getEntryIds[] = $getId;
					}
				}

				$args = array( 'taxonomy' => 'category', 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $offset + $ajax_limit );
				$postcategories = get_terms($args);
				if ($postcategories) {
					foreach ($postcategories as $postcategory) {
						?>
						<li class="bsaProSpecificItem bsaCheckItem-CT<?php echo $postcategory->term_id; ?>-<?php echo $blog['blog_id']; ?>">
							<label class="selectit"><input
									value="<?php echo $postcategory->term_id; ?>"
									class="bsaCheckItem" section="CT"
									itemId="CT<?php echo $postcategory->term_id; ?>-<?php echo $blog['blog_id']; ?>"
									type="checkbox"
									name="space_categories[]">
								<?php echo $postcategory->name; ?> (site id: <?php echo $blog['blog_id']; ?>)</label>
						</li>
					<?php
					}
				}

			}

			// return to the current site
			switch_to_blog( $current->id );

		} else {

			// get only selected tags
			$getEntryIds = null;
			if ( isset($space_id) ) {
				$getIds = bsa_space($space_id, 'in_categories');
				foreach ( explode(',', $getIds) as $getId ) {
					$getEntryIds[] = $getId;
				}
			}

			$args = array( 'taxonomy' => 'category', 'exclude' => $getEntryIds, 'offset'=> ($offset > 0) ? $offset : 0, 'number' => $offset + $ajax_limit );
			$postcategories = get_terms($args);
			if ($postcategories) {
				foreach ($postcategories as $postcategory) {
					?>
					<li class="bsaProSpecificItem bsaCheckItem-CT<?php echo $postcategory->term_id; ?>">
						<label class="selectit"><input
								value="<?php echo $postcategory->term_id; ?>"
								class="bsaCheckItem" section="CT"
								itemId="CT<?php echo $postcategory->term_id; ?>"
								type="checkbox"
								name="space_categories[]">
							<?php echo $postcategory->name; ?></label>
					</li>
				<?php
				}
			}

		}
	}
	die();
}
add_action('wp_ajax_bsa_unselected', 'bsa_unselected');
add_action( 'wp_ajax_nopriv_bsa_unselected', 'bsa_unselected' );

// Admin Ajax Function
function bsa_admin_action_callback()
{
	// Remove Ad Template
	if ( bsa_role() == 'admin' ) // verify roles
	{
		if( $_POST && isset($_POST['id']) && isset($_POST['type']) && $_POST['type'] == 'remove_template' )
		{
			$custom_templates = get_option('bsa_pro_plugin_custom_templates');
			$custom_templates = explode(',', $custom_templates);
			$css_file = plugin_dir_path( __DIR__ ) . 'frontend/css/block-'.$_POST['id'].'.css';
			$php_file = plugin_dir_path( __DIR__ ) . 'frontend/template/block-'.$_POST['id'].'.php';
			if ( file_exists($css_file) && file_exists($php_file) )
			{
				unlink($css_file);
				unlink($php_file);
				if ( !file_exists($css_file) && !file_exists($php_file) )
				{
					foreach (array_keys($custom_templates, $_POST['id']) as $key) {
						unset($custom_templates[$key]);
					}
					update_option('bsa_pro_plugin_custom_templates', implode(',', $custom_templates));
					echo 'removed';
				}
			} else {
				foreach (array_keys($custom_templates, $_POST['id']) as $key) {
					unset($custom_templates[$key]);
				}
				update_option('bsa_pro_plugin_custom_templates', implode(',', $custom_templates));
				echo 'removed';
			}
		}
	}

	die();
}
add_action('wp_ajax_bsa_admin_action_callback', 'bsa_admin_action_callback');
add_action( 'wp_ajax_nopriv_bsa_admin_action_callback', 'bsa_admin_action_callback' );