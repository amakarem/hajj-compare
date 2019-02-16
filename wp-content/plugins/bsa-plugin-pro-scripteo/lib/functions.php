<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

add_action('init', 'bsaStartSession', 1);
function bsaStartSession()
{
	if(!session_id()) {
		session_start();
	}
}

// -- START -- Marketing Agency Functions
function bsa_role()
{
	if ( current_user_can('administrator') ) {
		return 'admin';
	} else {
		$privileges = explode(',', bsa_get_opt('admin_settings', 'privileges'));
		if ( bsa_get_opt('admin_settings', 'privileges') != '' && $privileges ) {
			foreach ( $privileges as $capability ) {
				if ( current_user_can( $capability ) ) {
					return 'admin';
				}
			}
		}
		return 'user';
	}
}

function bsa_verify_role($id, $type)
{
	$model = new BSA_PRO_Model();
	$user_info = get_userdata(get_current_user_id());

	if ( bsa_role() == 'admin' ) {
		return TRUE;
	} else {
		if ( $type == 'site' ) {
			if ( bsa_site($id, 'user_id') == get_current_user_id() ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $type == 'space' ) {
			if ( bsa_space($id, 'site_id') != NULL && strpos($model->getUserSites('id', bsa_role()), bsa_space($id, 'site_id')) !== FALSE ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $type == 'ad' ) {
			if ( bsa_ad($id, 'space_id') != NULL && strpos($model->getUserSpaces(), bsa_ad($id, 'space_id')) !== FALSE ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}

function bsa_site($id, $column = NULL)
{
	$model = new BSA_PRO_Model();
	$get_site = $model->getSite($id);
	$params = explode(',', $column);

	foreach ( $params as $param ) {
		if ( isset($_SESSION[bsa_get_opt('prefix').'bsa_site_'.$id][$param]) && $_SESSION[bsa_get_opt('prefix').'bsa_site_'.$id][$param] != '' ) {
			return $_SESSION[bsa_get_opt('prefix').'bsa_site_'.$id][$param];
		} else {
			if ( $param != NULL ) {
				if ( $get_site[$param] ) {
					$_SESSION[bsa_get_opt('prefix').'bsa_site_'.$id][$param] = $get_site[$param];
					return $get_site[$param];
				} else {
					return NULL;
				}
			} else {
				if ( $get_site ) {
					$_SESSION[bsa_get_opt('prefix').'bsa_site_'.$id]['id'] = $get_site['id'];
					return $get_site['id'];
				} else {
					return NULL;
				}
			}
		}
	}
}
// -- END -- Marketing Agency Functions

//function bsa_space($id, $column = NULL)
//{
//	$model = new BSA_PRO_Model();
//	$get_space = $model->getSpace($id);
//	$params = explode(',', $column);
//
//	foreach ( $params as $param ) {
//		if ( isset($_SESSION['bsa_space_'.$id][$param]) && $_SESSION['bsa_space_'.$id][$param] != '' ) {
//			return $_SESSION['bsa_space_'.$id][$param];
//		} else {
//			if ( $param != NULL ) {
//				if ( $get_space[$param] ) {
//					$_SESSION['bsa_space_'.$id][$param] = $get_space[$param];
//					return $get_space[$param];
//				} else {
//					return NULL;
//				}
//			} else {
//				if ( $get_space ) {
//					$_SESSION['bsa_space_'.$id]['id'] = $get_space['id'];
//					return $get_space['id'];
//				} else {
//					return NULL;
//				}
//			}
//		}
//	}
//}
//
//function get_bsa_ads()
//{
//	$model = new BSA_PRO_Model();
//	$get_ads = $model->getAds();
//
//	return $get_ads;
//}
//
//function bsa_ad($id, $column = NULL)
//{
//	$model = new BSA_PRO_Model();
//	$get_ad = $model->getAd($id);
//	$params = explode(',', $column);
//
//	foreach ( $params as $param ) {
//		if ( isset($_SESSION['bsa_ad_'.$id][$param]) && $_SESSION['bsa_ad_'.$id][$param] != '' ) {
//			return $_SESSION['bsa_ad_'.$id][$param];
//		} else {
//			if ( $param != NULL ) {
//				if ( $get_ad[$param] ) {
//					$_SESSION['bsa_ad_'.$id][$param] = $get_ad[$param];
//					return $get_ad[$param];
//				} else {
//					return NULL;
//				}
//			} else {
//				if ( $get_ad ) {
//					$_SESSION['bsa_ad_'.$id]['id'] = $get_ad['id'];
//					return $get_ad['id'];
//				} else {
//					return NULL;
//				}
//			}
//		}
//	}
//}

function bsa_get_opt($var, $str = null)
{
	$get = get_option('bsa_pro_plugin_' . $var);
	if ( isset($get) && $str == null ) {
		return $get;
	} elseif ( isset($get) && isset($get[$str]) ) {
		return $get[$str];
	} else {
		return null;
	}
}

function bsa_get_trans($var, $str)
{
	$get = get_option('bsa_pro_plugin_trans_' . $var);
	if ( isset($get) && isset($get[$str]) ) {
		return $get[$str];
	} else {
		return null;
	}
}

function bsa_space($id, $column = NULL)
{
	$params = explode(',', $column);

	if ( $params != null ) {
		foreach ( $params as $param ) {
			if ( $param != '' ) {
				if ( isset($_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id][$param]) && $_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id][$param] != '' ) {
					return $_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id][$param];
				} else {
					$model = new BSA_PRO_Model();
					$get_space = $model->getSpace($id);
					if ( $param != null ) {
						if ( isset($get_space[$param]) ) {
							$_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id][$param] = $get_space[$param];
							return $get_space[$param];
						} else {
							return null;
						}
					} else {
						if ( isset($get_space) ) {
							$_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id]['id'] = $get_space['id'];
							return $get_space['id'];
						} else {
							return null;
						}
					}
				}
			} else {
				$model = new BSA_PRO_Model();
				$get_space = $model->getSpace($id);
				if ( isset($get_space) ) {
					$_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id]['id'] = $get_space['id'];
					return $get_space['id'];
				} else {
					return null;
				}
			}
		}
	} else {
		$model = new BSA_PRO_Model();
		$get_space = $model->getSpace($id);
		if ( isset($get_space) ) {
			$_SESSION[bsa_get_opt('prefix').'bsa_space_'.$id]['id'] = $get_space['id'];
			return $get_space['id'];
		} else {
			return null;
		}
	}
}

function get_bsa_ads()
{
	$model = new BSA_PRO_Model();
	$get_ads = $model->getAds();

	return $get_ads;
}

function bsa_ad($id, $column = NULL)
{
	$params = explode(',', $column);

	if ( $params != null ) {
		foreach ( $params as $param ) {
			if ( $param != '' ) {
				if ( isset($_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id][$param]) && $_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id][$param] != '' ) {
					return $_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id][$param];
				} else {
					$model = new BSA_PRO_Model();
					$get_ad = $model->getAd($id);
					if ( $param != null ) {
						if ( isset($get_ad[$param]) ) {
							$_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id][$param] = $get_ad[$param];
							return $get_ad[$param];
						} else {
							return null;
						}
					} else {
						if ( isset($get_ad) ) {
							$_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id]['id'] = $get_ad['id'];
							return $get_ad['id'];
						} else {
							return null;
						}
					}
				}
			} else {
				$model = new BSA_PRO_Model();
				$get_ad = $model->getAd($id);
				if ( isset($get_ad) ) {
					$_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id]['id'] = $get_ad['id'];
					return $get_ad['id'];
				} else {
					return null;
				}
			}
		}
	} else {
		$model = new BSA_PRO_Model();
		$get_ad = $model->getAd($id);
		if ( isset($get_ad) ) {
			$_SESSION[bsa_get_opt('prefix').'bsa_ad_'.$id]['id'] = $get_ad['id'];
			return $get_ad['id'];
		} else {
			return null;
		}
	}
}

function bsa_pro_opt($table, $column, $value, $where, $whereIs)
{
	$model = new BSA_PRO_Model();
	return $model->update_bsa($table, $column, $value, $where, $whereIs);
}

function bsa_pro_update($table, $column, $value, $where, $whereIs)
{
	$model = new BSA_PRO_Model();
	return $model->update_bsa($table, $column, $value, $where, $whereIs);
}

// encode & decode json var
function bsa_parse_arr( $arr, $key = null, $replace = null ) // var = array or string (push/pull)
{
	if ( $key != 'push' && $arr != null ) { // pull array
		$getString = json_decode($arr);
		return ( isset($getString->$key) ? $getString->$key : ( isset($getString) ? $getString : null ) );
	} elseif ( $key == 'push' && $replace != null ) { // push action
		$getString = json_decode($arr);
		$arr = array_replace((array) $getString, $replace);
		$string = json_encode($arr);
		return ( isset($string) ? $string : null );
	}
	return null;

	// EXAMPLES:
//		bsa_parse_arr ( $arr, 'push', array('test' => 'test3, test4') ); // change geotarget filter
//		bsa_parse_arr ( $arr, 'notice' ); // get notice filter
//		bsa_parse_arr ( $arr ); // get whole filters
}

// generate form url
function bsaFormURL($sid = null, $type = null)
{
	$ofu = get_option('bsa_pro_plugin_ordering_form_url');
	$mfu = get_site_option('bsa_pro_plugin_order_form_url');
	$oau = get_option('bsa_pro_plugin_agency_ordering_form_url');
	$mau = get_site_option('bsa_pro_plugin_agency_order_form_url');
	$form_url = ((isset($type) && $type == 'agency') ? ((is_multisite()) ? $mau : $oau) : ((is_multisite()) ? $mfu : $ofu));

	if ( $sid == null && $type == null ) {
		return $form_url;
	} elseif ( $sid != null && $type != null ) {
		return $form_url.(( strpos($form_url, '?') == TRUE ) ? '&sid='.$sid : '?sid='.$sid).(bsa_space($sid, 'site_id') != '' ? '&site_id='.bsa_space($sid, 'site_id') : '');
	} else {
		return $form_url.(( strpos($form_url, '?') == TRUE ) ? '&sid='.$sid : '?sid='.$sid);
	}
}

function bsaGetExampleAd($template, $edit = null)
{
	if ( isset($edit) ) {
		$ad = array(
			array(
				"template" => $template,
				"id" => 0,
				"title" => get_option('bsa_pro_plugin_trans_example_title'),
				"description" => get_option('bsa_pro_plugin_trans_example_desc'),
				"url" => get_option('bsa_pro_plugin_trans_example_url'),
				"img" => plugins_url('/bsa-pro-scripteo/frontend/img/example.jpg')
			)
		);
	} else {
		if ( isset($_POST['bsa_ad_id']) ) {
			$ad = array(
				array(
					"template" => $template,
					"id" => 0,
					"title" => bsa_ad($_POST['bsa_ad_id'], "title"),
					"description" => bsa_ad($_POST['bsa_ad_id'], "description"),
					"url" => bsa_ad($_POST['bsa_ad_id'], "url"),
					"img" => bsa_ad($_POST['bsa_ad_id'], "img")
				)
			);
		} else {
			$ad = null;
		}
	}

	return $ad;
}

function bsaCreateCustomAdTemplates( $init = null )
{
	$custom_templates = get_option('bsa_pro_plugin_custom_templates');
	if ( $custom_templates != '' ) {
		$custom_templates = explode(',', $custom_templates);
		if ( is_array($custom_templates) && $init != true ) {
			foreach ( $custom_templates as $custom_template ) {
				if ( $custom_template != '' ) {
					$template = explode('--', $custom_template);
					$width = $template[0];
					$height = $template[1];
					bsaCreateAdTemplate($width, $height);
				}
			}
		}
		if ( is_array($custom_templates) && $init == true ) {
			wp_schedule_single_event( time() + 10, 'bsa_cron_recreate_templates' );
		}

		// re-generate css
		bsa_pro_generate_css( (get_option('bsa_pro_plugin_rtl_support') == 'yes' ? true : null) );
	}
}

function bsaGetPost($name)
{
	if (isset($_POST[$name])) {
		return $_POST[$name];
	} else {
		return '';
	}
}

function bsa_column_exists($table, $column)
{
	$model = new BSA_PRO_Model();
	$if_exists = $model->columnExists($table, $column);

	if ( $if_exists != FALSE ) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function bsa_option_exists($id, $table, $column)
{
	if ( isset($id) && $id != '' && isset($table) && $table != '' && isset($column) && $column != '' ) {

		if ( $table == 'sites' ) {
			if ( bsa_site($id, $column) != NULL || bsa_site($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $table == 'spaces' ) {
			if ( bsa_space($id, $column) != NULL || bsa_space($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ( $table == 'ads' ) {
			if ( bsa_ad($id, $column) != NULL || bsa_ad($id, $column) != '' ) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}
}

function bsa_counter($id, $type)
{
	$model = new BSA_PRO_Model();
	$get_counter = $model->getCounter($id, $type);

	if ( $get_counter ) {
		return $get_counter;
	} else {
		return NULL;
	}
}

add_filter( 'the_content', 'bsa_load_ads_in_content' );
function bsa_load_ads_in_content($content) {
	if( is_single() ) {
		if (get_site_option('bsa_pro_plugin_before_hook') != '' && get_site_option('bsa_pro_plugin_before_hook') != null || get_site_option('bsa_pro_plugin_after_hook') != '' && get_site_option('bsa_pro_plugin_after_hook') != null) {
			$get_before = explode(';', get_site_option('bsa_pro_plugin_before_hook'));
			$get_after = explode(';', get_site_option('bsa_pro_plugin_after_hook'));
			$before_content = null;
			$after_content = null;

			if (isset($get_before)) {
				foreach ($get_before as $before) {
					$before_content .= do_shortcode($before);
				}
			}
			if (isset($get_after)) {
				foreach ($get_after as $after) {
					$after_content .= do_shortcode($after);
				}
			}
			return $before_content . $content . $after_content;
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}

add_filter( 'the_content', 'bsa_load_ads_after_paragraphs' );
function bsa_load_ads_after_paragraphs( $content ) {
	if( is_singular() ) {
		$p_tag = '</p>';
		$paragraphs = explode($p_tag, $content);
		foreach ($paragraphs as $key => $paragraph) {
			for ($i = 1; $i <= 10; $i++) {
				$after_paragraph = $i;
				if (get_site_option('bsa_pro_plugin_after_' . $i . '_paragraph') != '' && get_site_option('bsa_pro_plugin_after_' . $i . '_paragraph') != null) {
					$get_after = explode(';', get_site_option('bsa_pro_plugin_after_' . $i . '_paragraph'));
					foreach ($get_after as $after) {
//					if ( trim( $paragraph ) ) {
//						$paragraphs[$key] .= $p_tag;
//					}
						if ($after_paragraph == $key + 1) {
							$paragraphs[$key] .= do_shortcode($after);
						}
					}
				}
			}
		}
		if (isset($get_after)) {
			return implode('', $paragraphs);
		} else {
			return $content;
		}
	} else {
		return $content;
	}
}

// bp hooks
add_filter( 'wp_footer', 'bsa_load_bp_hooks' );
function bsa_load_bp_hooks( ) {
	//	var_dump(!bp_is_blog_page());
	if ( function_exists('bp_is_current_component') && bp_is_current_component( 'activity' ) ) { // show ads after activity
		for ( $i = 1; $i <= 20; $i++ ) {
			$get_hooks = get_option('bsa_pro_plugin_bp_stream_hook');
			if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
				$shortcodes = explode(';', $get_hooks[$i]);
				foreach ( $shortcodes as $shortcode ) {
					$get_shortcode 	= shortcode_parse_atts($shortcode);
					$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
					$max_width 		= (isset($get_shortcode['max_width']) ? trim($get_shortcode['max_width'], ']') : null);
					$delay 			= (isset($get_shortcode['delay']) ? trim($get_shortcode['delay'], ']') : null);
					$padding_top 	= (isset($get_shortcode['padding_top']) ? trim($get_shortcode['padding_top'], ']') : null);
					$attachment 	= (isset($get_shortcode['attachment']) ? trim($get_shortcode['attachment'], ']') : null);
					$crop 			= (isset($get_shortcode['crop']) ? trim($get_shortcode['crop'], ']') : null);
					$if_empty 		= (isset($get_shortcode['if_empty']) ? trim($get_shortcode['if_empty'], ']') : null);
					?>
					<div class="bsa_pro_buddypress_stream_<?php echo $i.$id ?>" style="display:none"><?php echo bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty) ?></div>
					<script>
						(function ($) {
							$(document).ready(function () {
								$( ".activity-item" ).each( function( i, el ) {
									if ( i + 1 === <?php echo $i ?> ) {
//										console.log(i+1);
//										console.log(el);
										$( '.bsa_pro_buddypress_stream_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
									}
								});
							});
						})(jQuery);
					</script>
				<?php
				}
			}
		}
	}
}

// bbp hooks
add_filter( 'wp_footer', 'bsa_load_bbp_hooks' );
function bsa_load_bbp_hooks( ) {
	if ( class_exists( 'bbPress' ) ) {
		if ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			if ( function_exists( 'bbp_is_single_forum' ) && bbp_is_single_forum() ) { // show ads after topic
				for ( $i = 1; $i <= get_option( '_bbp_topics_per_page', '15' ); $i++ ) {
					$get_hooks = get_option('bsa_pro_plugin_bbp_forum_hook');
					if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
						$shortcodes = explode(';', $get_hooks[$i]);
						foreach ( $shortcodes as $shortcode ) {
							$get_shortcode 	= shortcode_parse_atts($shortcode);
							$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
							?>
							<div class="bsa_pro_bbpress_forum_<?php echo $i.$id ?>" style="display:none"><?php echo do_shortcode($shortcode) ?></div>
							<script>
								(function ($) {
									$(document).ready(function () {
										$( "#bbpress-forums .type-topic" ).each( function( i, el ) {
											if ( i + 1 === <?php echo $i ?> ) {
//												console.log(i+1);
//												console.log(el);
												$( '.bsa_pro_bbpress_forum_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
											}
										});
									});
								})(jQuery);
							</script>
						<?php
						}
					}
				}
			} else if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() ) { // show ads after reply
				for ( $i = 1; $i <= get_option( '_bbp_replies_per_page', '15' ); $i++ ) {
					$get_hooks = get_option('bsa_pro_plugin_bbp_topic_hook');
					if ( isset($get_hooks) && $get_hooks[$i] != '' && $get_hooks[$i] != null ) {
						$shortcodes = explode(';', $get_hooks[$i]);
						foreach ( $shortcodes as $shortcode ) {
							$get_shortcode 	= shortcode_parse_atts($shortcode);
							$id 			= (isset($get_shortcode['id']) ? trim($get_shortcode['id'], ']') : null);
							?>
							<div class="bsa_pro_bbpress_reply_<?php echo $i.$id ?>" style="display:none"><?php echo do_shortcode($shortcode) ?></div>
							<script>
								(function ($) {
									$(document).ready(function () {
										$( "#bbpress-forums .type-reply" ).each( function( i, el ) {
											if ( i + 1 === <?php echo $i ?> ) {
//												console.log(i+1);
//												console.log(el);
												$( '.bsa_pro_bbpress_reply_' + <?php echo $i.$id ?> ).insertAfter( $(this)).fadeIn();
											}
										});
									});
								})(jQuery);
							</script>
						<?php
						}
					}
				}
			}
		}
	}
}

function bsa_number_format($number)
{
	// default format
	$format = ((get_option('bsa_pro_plugin_currency_format')) ? explode('|', get_option('bsa_pro_plugin_currency_format')) : array(2, '.', ''));

	// if new
	if (isset($_GET['bsa_currency_format'])) {
		update_option('bsa_pro_plugin_currency_format', $_GET['bsa_currency_format']);
		$format = explode('|', $_GET['bsa_currency_format']);
	}
	$number = (isset($number) && $number > 0 ? $number : 0);

	return number_format($number, $format[0], $format[1], $format[2]);
}

function bsa_get_user_geo_data()
{
	if ( session_id() ) {
		if ( isset($_SESSION['bsaProGeoUser']) ) {
			return $_SESSION['bsaProGeoUser'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
			$response = wp_remote_get('http://ip-api.com/php/'.$ip);

			if( is_array($response) ) {
				$getGeoData = @unserialize($response['body']);
				if ( isset($getGeoData) ) {
					$_SESSION['bsaProGeoUser'] = $getGeoData;
					return $getGeoData;
				} else {
					return 'no_code';
				}
			} else {
				return 'no_code';
			}
		}
	} else {
		return 'no_code';
	}
}

function bsa_pro_verify_device($space_id)
{
	$detect = new BSA_Mobile_Detect();

	if ( isset($space_id) && bsa_space($space_id, 'devices') != '' && bsa_space($space_id, 'devices') != null && bsa_space($space_id, 'devices') != 'mobile,tablet,desktop' ) {

		if( !$detect->isMobile() && !$detect->isTablet() && in_array('desktop', explode(',', bsa_space($space_id, 'devices')), false) === true || // If desktop device.
			$detect->isTablet() && in_array('tablet', explode(',', bsa_space($space_id, 'devices')), false) === true || // If tablet device.
			$detect->isMobile() && !$detect->isTablet() && in_array('mobile', explode(',', bsa_space($space_id, 'devices')), false) === true ) { // If mobile device.

			if ( !$detect->isMobile() && !$detect->isTablet() ) {
//				echo 'desktop';
				if ( in_array('desktop', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} elseif ( $detect->isTablet() ) {
//				echo 'tablet';
				if ( in_array('tablet', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} elseif ( $detect->isMobile() && !$detect->isTablet() ) {
//				echo 'mobile';
				if ( in_array('mobile', explode(',', bsa_space($space_id, 'devices')), false) === true ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}

		} else {
			return false;
		}

	} else {
		return true;
	}
}

function bsa_pro_verify_geo($type, $countries)
{
	if ( $type != null && $countries != null && $countries != '' ) {
		$get_user_data = bsa_get_user_geo_data();
		if ( isset($get_user_data) || $get_user_data == 'no_code' ) {

			if ( $type == 'show' && $countries != null && $countries != '' && is_array($get_user_data) || $type == 'hide' && $countries != null && $countries != '' && is_array($get_user_data) ) {
				if ( isset($get_user_data['countryCode']) && $type == 'show' && in_array($get_user_data['countryCode'], explode(',', $countries), false) === true || // valid countries
					 isset($get_user_data['countryCode']) && $type == 'hide' && in_array($get_user_data['countryCode'], explode(',', $countries), false) !== true ) { // valid countries
					return true;
				} else {
					return false;
				}
			}

			if ( $type == 'show_advanced' && $countries != null && $countries != '' && is_array($get_user_data) ) {
				if ($type == 'show_advanced' && in_array($get_user_data['regionName'], explode(',', $countries), false) === true || // valid region
					$type == 'show_advanced' && in_array($get_user_data['city'], explode(',', $countries), false) === true || // valid cities
					$type == 'show_advanced' && in_array($get_user_data['zip'], explode(',', $countries), false) === true) { // valid zip
					return true;
				} else {
					return false;
				}
			}

			if ( $type == 'hide_advanced' && $countries != null && $countries != '' && is_array($get_user_data) ) {
				if ($type == 'hide_advanced' && in_array($get_user_data['regionName'], explode(',', $countries), false) !== true && // valid region
					$type == 'hide_advanced' && in_array($get_user_data['city'], explode(',', $countries), false) !== true && // valid cities
					$type == 'hide_advanced' && in_array($get_user_data['zip'], explode(',', $countries), false) !== true) { // valid zip
					return true;
				} else {
					return false;
				}
			}

			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

// get close actions
function bsaGetCloseActions($sid, $type)
{
	if ( bsa_space($sid, 'close_action') != null && bsa_space($sid, 'close_action') != '' ) {
		$get_close_action = explode(',', bsa_space($sid, 'close_action'));
		if ( $type == 'show_ads' ) {
			if ( isset($get_close_action[0]) ) {
				return number_format($get_close_action[0], 0, '', '');
			} else {
				return 0;
			}
		} elseif ( $type == 'show_close_btn' ) {
			if ( isset($get_close_action[1]) ) {
				return number_format($get_close_action[1], 0, '', '');
			} else {
				return 0;
			}
		} elseif ( $type == 'close_ads' ) {
			if ( isset($get_close_action[2]) ) {
				return number_format($get_close_action[2], 0, '', '');
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	} else {
		return 0;
	}
}

// capping function - capped ads
function bsaGetCappedAds($sid)
{
	$model 			= new BSA_PRO_Model();
	$capped_ads 	= (isset($_SESSION['bsa_capped_ads_'.$sid]) ? $_SESSION['bsa_capped_ads_'.$sid] : null);
	$ads 			= $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.$capped_ads);

	if ( isset($ads) ) {
		foreach ( $ads as $ad ) {
			$aid 			= $ad['id'];
			$ad_capping 	= bsa_ad($aid, 'capping');
			$sessionAdCapping 	= (isset($_SESSION['capped_ad_'.$aid]) ? $_SESSION['capped_ad_'.$aid] : null);

			if ( !isset($sessionAdCapping) ) {
				$_SESSION['capped_ad_'.$aid] = $ad_capping;
			}
		}

		foreach ( $ads as $ad ) {
			$aid 			= $ad['id'];
			$ad_capping 	= bsa_ad($aid, 'capping');

			if ( $ad_capping != null && $ad_capping != '' && $ad_capping > 0 ) { // if capping isset
				$sessionAdCapping 	= (isset($_SESSION['capped_ad_'.$aid]) ? $_SESSION['capped_ad_'.$aid] : null);

//			var_dump($sessionAdCapping);
				if ( !isset($sessionAdCapping) ) {
					$_SESSION['capped_ad_'.$aid] = $ad_capping;
				} else {
					if ( $sessionAdCapping > 0 ) {
						$_SESSION['capped_ad_'.$aid] = $sessionAdCapping - 1;
					} else {
						$capped_ads .= (strpos($capped_ads, ','.$aid) !== false) ? null : ','.$aid;
					}
				}
			}
		}
	}
//	var_dump($capped_ads);

	if ( $capped_ads ) {
		$_SESSION['bsa_capped_ads_'.$sid] = $capped_ads;
		return $capped_ads;
	} else {
		return null;
	}
}

function bsa_pro_ad_space($space_id = null, $max_width = null, $delay = null, $padding_top = null, $attachment = null, $crop = null, $if_empty = null, $custom_image = null, $powered = null, $show_ids = null)
{
	if ( $space_id == null ) {
		echo "<strong>ADS Error</strong> Missing <strong>id</strong> parameter!";
		return '';
	} else {
		$show_in_country = bsa_space($space_id, 'show_in_country');
		$hide_in_country = bsa_space($space_id, 'hide_in_country');
		$show_in_advanced = bsa_space($space_id, 'show_in_advanced');
		$hide_in_advanced = bsa_space($space_id, 'hide_in_advanced');

		$get_ids = json_decode(bsa_space($space_id, 'advanced_opt'));
		$get_blog_id = ( is_multisite() ? get_current_blog_id() : null );
		if ( isset($get_ids) && in_array($get_blog_id.get_the_ID(), explode(',', $get_ids->hide_for_id)) && get_the_ID() > 0 ) { // Hide for specific pages
			return null;
		}

		if ((get_option('bsa_pro_plugin_' . 'hide_if_logged') == 'yes' && is_user_logged_in()) != true && // Hide for logged users
			bsa_pro_verify_geo('show', $show_in_country) && bsa_pro_verify_geo('hide', $hide_in_country) && // Show / Hide in Countries
			bsa_pro_verify_geo('show_advanced', $show_in_advanced) && bsa_pro_verify_geo('hide_advanced', $hide_in_advanced) && // Show / Hide in Regions, Cities, ZipCodes
			bsa_pro_verify_device($space_id) // Verify device
		) {
			// Rand Space ID
			$space_ids = explode(',', $space_id);
			$space_rand_id = array_rand($space_ids, 1);
			$space_id = $space_ids[$space_rand_id];

			$taxonomy 	= 'none';
			$custom   	= 'none';
			$classes = get_body_class();
			if ( $crop != 'ajax' ) { // show ad space if ajax shortcode

				// if in category or has tag
				if (bsa_space($space_id, 'id') && bsa_space($space_id, 'in_categories') != '' && bsa_space($space_id, 'in_categories') != null ||
						bsa_space($space_id, 'id') && bsa_space($space_id, 'has_tags') != '' && bsa_space($space_id, 'has_tags') != null ||
						bsa_space($space_id, 'id') && is_category() && bsa_space($space_id, 'in_categories') == null ||
						bsa_space($space_id, 'id') && is_category() && bsa_space($space_id, 'in_categories') == ''
				) {
					$get_categories = bsa_space($space_id, 'in_categories');
					$get_tags = bsa_space($space_id, 'has_tags');
					$exp_categories = explode(',', $get_categories);
					$exp_tags = explode(',', $get_tags);

					$taxonomy_cat = 'empty';
					$taxonomy_tag = 'empty';
					if (is_array($exp_categories)) {
						foreach ($exp_categories as $category) {
							if ( has_term( $category, 'category' ) && !is_category() || is_category(get_cat_name($category)) && is_category() ) {
								$taxonomy_cat = 'isset';
								break;
							}
						}
					}
					if (is_array($exp_tags)) {
						foreach ($exp_tags as $tag) {
							if (has_term( $tag, 'post_tag' )) {
								$taxonomy_tag = 'isset';
								break;
							}
						}
					}
					if ($get_categories == '' && $get_categories == null && $get_tags == '' && $get_tags == null ||
							$get_categories == '' && $get_categories == null && $taxonomy_tag == 'isset' ||
							$taxonomy_cat == 'isset' && $get_tags == '' && $get_tags == null ||
							$taxonomy_cat == 'isset' && $taxonomy_tag == 'isset'
					) {
						$taxonomy = 'isset';
					} else {
						$taxonomy = 'empty';
					}
				} else {
					$taxonomy = 'none';
				}

				// if custom types or taxonomies
				$getAdvanced = json_decode(bsa_space($space_id, 'advanced_opt'));
				if (isset($getAdvanced->show_customs) && $getAdvanced->show_customs != '' && $getAdvanced->show_customs != null ||
					isset($getAdvanced->hide_customs) && $getAdvanced->hide_customs != '' && $getAdvanced->hide_customs != null )
				{
					$show_customs = explode(',', $getAdvanced->show_customs);
					$hide_customs = explode(',', $getAdvanced->hide_customs);

					$taxonomy_show 	= 'empty';
					$taxonomy_hide 	= 'empty';
					if (is_array($show_customs)) {
						foreach ($show_customs as $show) {
							if ( $show != '' ) {
								$taxonomy_show = 'hide';
								if ( is_tax( '', $show ) || has_term( '', $show ) || is_singular($show) || in_array($show, $classes) ) {
									$taxonomy_show = 'show';
									break;
								}
							}
						}
					}
					if (is_array($hide_customs)) {
						foreach ($hide_customs as $hide) {
							if ( $hide != '' ) {
								if ( is_tax( '', $hide ) || has_term( '', $hide ) || is_singular($hide) || in_array($hide, $classes) ) {
									$taxonomy_hide = 'hide';
									break;
								}
							}
						}
					}
					if ( $taxonomy_show == 'show' ) {
						$custom = 'isset';
					}
					if ( $taxonomy_show == 'hide' || $taxonomy_hide == 'hide' ) {
						$custom = 'hide';
					}
				} else {
					$custom = 'none';
				}
			}

			if ( $taxonomy != 'isset' && $taxonomy != 'none' || $custom != 'isset' && $custom != 'none' || $custom == 'hide' ) {
				return null;
			}

			if ( bsa_space($space_id, 'id') && bsa_space($space_id, 'status') == 'active' ) {

				$ad['ad_limit'] = 0;
				$ad['ad_model'] = 0;
				if (glob(plugin_dir_path(__FILE__) . "../frontend/template/" . bsa_space($space_id, 'template') . ".php") == null) {
					$styleName = 'default';
				} else {
					$styleName = bsa_space($space_id, 'template');
				}

				$sid 		= $space_id;
				$model 		= new BSA_PRO_Model();
				$ads 		= $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.bsaGetCappedAds($sid), $show_ids);
				$type 		= (bsa_space($sid, 'site_id') != NULL) ? 'agency' : null;
				$crop 		= ($crop == 'no' || $crop == 'ajax') ? $crop : null;
				$rel 		= (bsa_get_opt('admin_settings', 'nofollow') == 'yes' ? ' rel="nofollow"' : null);

				if ( defined('W3TC') ): ?>

					<?php if (!defined('W3TC_DYNAMIC_SECURITY')) { define('W3TC_DYNAMIC_SECURITY', md5(rand(0,9999))); } ?>

					<!--mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> $ads -->
					<?php $ads = $model->getActiveAds($sid, bsa_space($sid, 'max_items'), null, '0'.bsaGetCappedAds($sid), $show_ids); ?>
					<!--/mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->

				<?php endif;

				$example = null;
				if ( !isset($if_empty) && get_option('bsa_pro_plugin_example_ad') == 'yes' && count($ads) <= 0 ) { // example ads if empty ad space
					$example = true;
				}

				if (count($ads) > 0 || count($ads) == 0 && $if_empty != '' && bsa_space($sid, 'display_type') != 'background' || $example ) {
					if (isset($sid) && bsa_space($sid, 'display_type') == 'corner') {
						echo '<div class="bsaProCorner bsaProCorner-' . $sid . '">'; // -- START -- CORNER
						echo '
				<div class="bsaProRibbon"></div>
					<div class="bsaProCornerContent">
						<div class="bsaProCornerInner">';
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'floating' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-right' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-right'
					) {
						echo '<div class="bsaProFloating bsaProFloating-' . $sid . '" style="display: none"><div class="bsaFloatingButton"><span class="bsaFloatingClose bsaFloatingClose-' . $sid . '"></span></div>'; // -- START -- FLOATING
					} elseif (isset($sid) && strpos(bsa_space($sid, 'display_type'), 'carousel') !== false) {
						echo '<div class="bsaProCarousel bsaProCarousel-' . $sid . '" style="display:none">'; // -- START -- CAROUSEL
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'top_scroll_bar' || isset($sid) && bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
						echo '<div class="bsaProScrollBar bsaProScrollBar-' . $sid . '">'; // -- START -- TOP / BOTTOM SCROLL BAR
						if (bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
							echo '<div class="bsaProScrollBarButton"><span class="bsaProScrollBarClose bsaProScrollBarClose-' . $sid . '"></span></div>';
						}
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'popup' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'popup_2' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup_2'
					) {
						echo '
					<div class="bsaPopupWrapperBg bsaPopupWrapperBg-' . $sid . ' bsaHidden" style="display:none"></div>

					<div class="bsaPopupWrapper bsaPopupWrapper-' . $sid . ' bsaHidden" style="display:none">

						<div class="bsaPopupWrapperInner">
				'; // -- START -- POPUP, EXIT POPUP
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'layer') {
						echo '
					<div class="bsaPopupWrapperBg bsaPopupWrapperBg-' . $sid . ' bsaHidden"></div>

					<div class="bsaPopupWrapper bsaPopupWrapper-' . $sid . ' bsaHidden">
				'; // -- START -- LAYER
					}

					// -- START -- DEFAULT
					require dirname(__FILE__) . '/../frontend/template/' . $styleName . '.php';
					// -- END -- DEFAULT

					// -- START -- REFERRAL LINK
					$username = get_option('bsa_pro_plugin_username');
					if ( $powered != 'no' && $username != '' ) {
						$powered_by = get_option('bsa_pro_plugin_trans_powered');
						echo '<div class="bottomLink">';
						echo ( $powered_by != '' ? $powered_by : 'Powered by' ).' <a target="_blank" href="https://codecanyon.net/item/ads-pro-plugin-multipurpose-wordpress-advertising-manager/10275010?ref='.$username.'" title="Ads Pro Plugin - Multi-Purpose WordPress Advertising Manager">Ads Pro</a>';
						echo '</div>';
					}
					// -- END -- REFERRAL LINK

					if (isset($sid) && bsa_space($sid, 'display_type') != 'popup' &&
						bsa_space($sid, 'display_type') != 'corner' &&
						bsa_space($sid, 'display_type') != 'layer' &&
						bsa_space($sid, 'display_type') != 'exit_popup' &&
						bsa_space($sid, 'display_type') != 'background' &&
						bsa_space($sid, 'display_type') != 'link') {
						if ( bsaGetCloseActions($sid, 'show_ads') > 0 ): ?>
							<style>
								.bsaProContainer-<?php echo $sid?> {
									display: none;
								}
							</style>
						<?php endif; ?>
						<script>
							(function ($) {
								var bsaProContainer = $('.bsaProContainer-<?php echo $sid?>');
								var number_show_ads = "<?php echo bsaGetCloseActions($sid, 'show_ads') ?>";
								var number_hide_ads = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								if ( number_show_ads > 0 ) {
									setTimeout(function () { bsaProContainer.fadeIn(); }, number_show_ads * 1000);
								}
								if ( number_hide_ads > 0 ) {
									setTimeout(function () { bsaProContainer.fadeOut(); }, number_hide_ads * 1000);
								}
							})(jQuery);
						</script>
					<?php
					}

					if (isset($sid) && bsa_space($sid, 'display_type') == 'background') {
						?>
						<style>
							body {
								background-position: top center !important;
								<?php echo ((bsa_space($sid, 'ads_bg') != null) ? 'background-color: '.bsa_space($sid, 'ads_bg').' !important;' : null) ?>
								background-repeat: no-repeat !important;
								background-attachment: <?php echo ((isset($attachment) && $attachment == 'scroll') ? 'scroll' : 'fixed' ) ?> !important;
								padding-top: <?php echo ((isset($padding_top) && $padding_top != '') ? $padding_top.'px' : 'inherit') ?> !important;
							}
						</style>
						<script>
							(function ($) {
								$(document).ready(function () {
									var body = "body";
									var getImage = $(".bsaProContainer-<?php echo $sid ?> .bsaProItemInner__img").css("background-image");
									var getUrl = $(".bsaProContainer-<?php echo $sid ?> .bsaProItem__url").attr('href');
									$(".bsaProContainer-<?php echo $sid ?>").hide();
									$(body).css("background-image", getImage);
									$(body).click(function (e) {
										var body_target = $(e.target);
										if (body_target.is(body) === true) {
											window.open(getUrl, "_blank");
										}
									});
									$(document).mousemove(function (e) {
										var body_target = $(e.target);
										if (body_target.is(body)) {
											body_target.css("cursor", "pointer");
										} else {
											$(body).css("cursor", "auto");
										}
									});
								});
							})(jQuery);
						</script>
					<?php
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'corner') {
						echo '
						</div>
					</div>
				</div>'; // -- END -- CORNER
						?>
						<script>
							(function ($) {
								var body = $(document);
								$(window).scroll(function () {
									if ($(window).scrollTop() >= (body.height() - (body.height() - (body.height() * (<?php echo (($delay != 0 && $delay != NULL) ? $delay : $delay) / 100 ?>)))) - $(window).height()) {
										setTimeout(function () {
											<?php if ( bsaGetCloseActions($sid, 'show_ads') == 0 ): ?>
											$(".bsaProCorner-<?php echo $sid ?>").fadeIn();
											<?php endif; ?>
										}, 400);
									}
								});
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_ads') ?>";
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								if ( number_show > 0 ) {
									setTimeout(function () { bsaProCorner.fadeIn(400); }, number_show * 1000);
								}
								if ( number_close > 0 ) {
									setTimeout(function () { bsaProCorner.fadeOut(400); }, number_close * 1000);
								}
								var bsaProCorner = $(".bsaProCorner-<?php echo $sid ?>");
								bsaProCorner.appendTo(document.body);
							})(jQuery);
						</script>
						<style>
							.bsaProCorner-<?php echo $sid ?> {
								display: <?php echo (bsaGetCloseActions($sid, 'show_ads') > 0) ? 'none' : 'block' ?>;
								position: fixed;
								width: 150px;
								height: 150px;
								z-index: 10000;
								top: <?php echo (( is_user_logged_in() ) ? '32px' : '0') ?>;
								right: 0;
								-webkit-transition: all .5s; /* Safari */
								transition: all .5s;
							}
							.bsaProCorner:hover {
								width: 250px;
								height: 250px;
							}
						</style>
					<?php
					} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'floating' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-right' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-bottom-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-left' ||
						isset($sid) && bsa_space($sid, 'display_type') == 'floating-top-right'
					) {
						echo '</div>'; // -- END -- FLOATING
						?>
						<script>
							(function ($) {
								var body = $(document);
								$(window).scroll(function () {
									if ($(window).scrollTop() >= (body.height() - (body.height() - (body.height() * (<?php echo (($delay != 0 && $delay != NULL) ? $delay : $delay) / 100 ?>)))) - $(window).height()) {
										setTimeout(function () {
											$(".bsaProFloating-<?php echo $sid ?>").fadeIn();
										}, 400);
									}
								});
								var delay = '<?php echo $delay ?>';
								if ( delay === 'none' ) {
									setTimeout(function () {
										$(".bsaProFloating-<?php echo $sid ?>").fadeIn();
									}, 400);
								}
								var bsaProFloating = $(".bsaProFloating-<?php echo $sid ?>");
								var bsaFloatingClose = $(".bsaFloatingClose-<?php echo $sid ?>");
								var parent = bsaProFloating.parent('div');
								if ( parent.is('div') === true ) {
									bsaProFloating.appendTo(document.body);
								}
								bsaFloatingClose.click(function () {
									setTimeout(function () {
										bsaProFloating.removeClass("zoomInDown").addClass("animated zoomOutUp");
									}, 400);
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () { bsaProFloating.fadeOut(400); }, number_close * 1000);
									setTimeout(function () { bsaProFloating.remove(); }, (number_close * 1000) + 400);
								}
								if ( number_show > 0 ) {
									if ( number_show === 1000 ) {
										bsaFloatingClose.remove();
									} else {
										bsaFloatingClose.hide();
										setTimeout(function () {
											bsaFloatingClose.fadeIn();
										}, number_show * 1000);
									}
								}
							})(jQuery);
						</script>
						<style>
							.bsaProFloating-<?php echo $sid ?> {
								position: fixed;
								max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width : '320') ?>px;
								width: 90%;
								z-index: 10000;
							<?php if ( bsa_space($sid, 'display_type') == 'floating-top-left' ) {
									echo '
										top: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										left: 15px;
									';
								} elseif ( bsa_space($sid, 'display_type') == 'floating-top-right' ) {
									echo '
										top: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										right: 15px;
									';
								} elseif ( bsa_space($sid, 'display_type') == 'floating-bottom-left' ) {
									echo '
										bottom: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										left: 15px;
									';
								} else {
									echo '
										bottom: '.(( is_user_logged_in() ) ? 47 : 15).'px;
										right: 15px;
									';
								}
							?>
							}

							<?php if ( bsa_space($sid, 'display_type') == 'floating-top-left' || bsa_space($sid, 'display_type') == 'floating-bottom-left' ) {
									echo '
										.bsaProFloating-'.$sid.' .bsaFloatingButton {
											float: left;
										}
									';
								}
							?>
						</style>
					<?php
					} elseif (isset($sid) && strpos(bsa_space($sid, 'display_type'), 'carousel') !== false) {
					echo '</div>'; // -- END -- CAROUSEL
					$getColPerRow = bsa_space($sid, 'col_per_row');
					?>
					<script>
						(function ($) {
							function bsaOwlCarousel() {
								var owl = $(".bsa-owl-carousel-<?php echo $sid; ?>");
								<?php if ( get_option('bsa_pro_plugin_'.'carousel_script') == 'bx' ): ?>
									owl.bxSlider({
										<?php echo ((bsa_space($sid, 'display_type') == 'carousel_fade') ? 'mode : "fade",' : 'mode : "horizontal",') ?>
										slideMargin: 0,
										autoHover: true,
										adaptiveHeight: true,
										pager: false,
										pause: <?php echo (($delay > 0 && $delay != NULL) ? $delay : 5) * 1000 ?>,
										controls: false,
										auto: true
									});
								<?php else: ?>
									owl.owlCarousel({
										loop: true,
										autoPlay: <?php echo (($delay > 0 && $delay != NULL) ? $delay : 5) * 1000 ?>,
										autoPlayTimeout: <?php echo (($delay > 0 && $delay != NULL) ? $delay : 5) * 1000 ?>,
										autoPlayHoverPause: false,
										paginationSpeed: 700,
										items: <?php echo (($getColPerRow > 1) ? $getColPerRow : 1) ?>,
										rewindSpeed: 1000,
										<?php echo (($getColPerRow > 1) ? null : 'singleItem : true,') ?>
										slideSpeed: 400,
										autoWidth: true,
										<?php echo ((bsa_space($sid, 'display_type') == 'carousel_fade') ? 'transitionStyle : "bsaFade",' : null) ?>
										nav: false,
										dots: false
									});
								<?php endif; ?>
							}
							$(document).ready(function () {
								setTimeout(function () {
									var owlCarousel = $(".bsaProCarousel-<?php echo $sid; ?>");
									var crop = "<?php echo $crop; ?>";
									var ajax = $('.bsa_pro_ajax_load-<?php echo $sid; ?>');
									if ( crop === "ajax" ) {
										if ( ajax.children.length > 0 ) {
											owlCarousel.fadeIn();
											bsaOwlCarousel();
											setTimeout(function () {
												ajax.fadeIn();
											}, 100);
										}
									} else {
										bsaOwlCarousel();
										owlCarousel.fadeIn();
									}
								}, 700);
							});
						})(jQuery);
					</script>
					<style>
						.bsaProCarousel-<?php echo $sid?> {
							max-width: <?php echo (($max_width > 0) ? $max_width : '728') ?>px;
							width: 100%;
							overflow: hidden;
						}
						.bsaProCarousel-<?php echo $sid; ?> .bx-wrapper {
							border: 0 !important;
							box-shadow: none !important;
							margin-bottom: 0 !important;
						}
						<?php if ( $max_width > 0 ): ?>
							.bsa-owl-carousel-<?php echo $sid; ?> .bsaProItem {
								width: <?php echo $max_width ?>px !important;
							}
						<?php endif; ?>
					</style>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'top_scroll_bar' || isset($sid) && bsa_space($sid, 'display_type') == 'bottom_scroll_bar') {
					if (bsa_space($sid, 'display_type') == 'top_scroll_bar') {
						echo '<div class="bsaProScrollBarButton"><span class="bsaProScrollBarClose bsaProScrollBarClose-' . $sid . '"></span></div>';
					}
					echo '</div>'; // -- END -- TOP / BOTTOM SCROLL BAR
					?>
					<script>
						(function ($) {
							$(document).ready(function () {
								var bsaScrollBarWrapper = $('.bsaProScrollBar-<?php echo $sid?>');
								var bsaScrollBarInner = $('.bsaProScrollBar-<?php echo $sid?> .bsaProContainer-<?php echo $sid?> .bsaProItems');
								var bsaScrollBarClose = $(".bsaProScrollBarClose-<?php echo $sid ?>");
								bsaScrollBarWrapper.appendTo(document.body);
								bsaScrollBarInner.simplyScroll({
									speed: 2
								});
								bsaScrollBarClose.click(function () {
									setTimeout(function () {
										bsaScrollBarWrapper.removeClass("zoomInDown").addClass("animated zoomOutUp");
									}, 400);
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () { bsaScrollBarWrapper.fadeOut(400); }, number_close * 1000);
									setTimeout(function () { bsaScrollBarWrapper.remove(); }, (number_close * 1000) + 400);
								}
								if ( number_show > 0 ) {
									if ( number_show === 1000 ) {
										bsaScrollBarClose.remove();
									} else {
										bsaScrollBarClose.hide();
										setTimeout(function () {
											bsaScrollBarClose.fadeIn();
										}, number_show * 1000);
									}
								}
							});
						})(jQuery);
					</script>
					<style>
						.bsaProScrollBar-<?php echo $sid?> {
							width: 100%;
							position: fixed;
						<?php if ( bsa_space($sid, 'display_type') == 'top_scroll_bar' ): ?> top: <?php echo (( is_user_logged_in() ) ? '32px' : '0') ?>;
						<?php else: ?> bottom: 0;
						<?php endif; ?> left: 0;
							z-index: 10000;
						}
						.bsaProScrollBar-<?php echo $sid?> .bsaProItem {
							margin: 0 !important;
						}
						.bsaProScrollBar-<?php echo $sid?>, .bsaProScrollBar-<?php echo $sid?> .bsaProItems, .bsaProScrollBar-<?php echo $sid?> .bsaProContainerNew .bsaProItem.bsaReset {
							clear: none;
						}
						/* Explicitly set height/width of each list item */
						.simply-scroll .simply-scroll-list .bsaProItem {
							float: left; /* Horizontal scroll only */
							width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : 1920 / bsa_space($sid, 'col_per_row')).'px' ?> !important;
							height: auto;
						}
					</style>
				<?php
				} elseif (  isset($sid) && bsa_space($sid, 'display_type') == 'popup' ||
							isset($sid) && bsa_space($sid, 'display_type') == 'popup_2' ) {
					echo '</div><span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- POPUP
					?>
					<script>
						(function ($) {
							var ads = "<?php echo count($ads); ?>";
							if ( ads > 0 ) {
								var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid?>");
								var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid?>");
								var bsaBody = $("body");
								if (bsaPopupWrapper.hasClass('bsaClosed') === false) {
									setTimeout(function () {
//										bsaBody.css({
//											"overflow": "hidden",
//											"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
//										});
										bsaPopupWrapper.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
										bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
									}, <?php echo bsaGetCloseActions($sid, 'show_ads') * 1000 ?>);
								}
								$(document).ready(function () {
									var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
									bsaPopupClose.click(function () {
										bsaBody.css({"overflow": "visible", "height": "auto"});
										bsaPopupClose.addClass("animated zoomOut");
										bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut bsaClosed").fadeOut();
										bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
									});
									var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
									var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
									if ( number_close > 0 ) {
										bsaPopupWrapperBg.removeClass('animated');
										bsaPopupWrapper.removeClass('animated');
										setTimeout(function () {
											bsaPopupWrapperBg.fadeOut();
											bsaPopupWrapper.fadeOut();
										}, number_close * 1000);
									}
									if ( number_show > 0 ) {
										if ( number_show === 1000 ) {
											bsaPopupClose.remove();
										} else {
											bsaPopupClose.hide();
											setTimeout(function () {
												bsaPopupClose.fadeIn();
											}, number_show * 1000);
										}
									}
								});
							}
						})(jQuery);
					</script>
					<style>
						<?php if ($max_width != ''): ?>
						.bsaPopupWrapper-<?php echo $sid ?> .bsaProContainerNew {
							max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : '100%') ?> !important;
							margin: 0 auto;
						}
						<?php endif; ?>
						<?php if (bsa_option_exists($sid, 'spaces', 'ad_extra_color_1')): ?>
						.bsaPopupWrapperBg-<?php echo $sid ?> {
							background-color: <?php echo bsaHex2rgba(bsa_space($sid, 'ad_extra_color_1'), ( bsa_space($sid, 'display_type') == 'popup_2' ? 0.7 : 1 )) ?>;
						}
						<?php else: ?>
						.bsaPopupWrapperBg-<?php echo $sid ?> {
							background-color: <?php echo bsaHex2rgba('#ffffff', ( bsa_space($sid, 'display_type') == 'popup_2' ? 0.7 : 1 )) ?>;
						}
						<?php endif; ?>
					</style>
				<?php
				} elseif (isset($sid) && bsa_space($sid, 'display_type') == 'layer') {
					echo '<span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- LAYER
					?>
					<script>
						(function ($) {
							var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid ?>");
							var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid ?>");
							var bsaBody = $("body");
							setTimeout(function () {
								var getImage = $(".bsaProContainer-<?php echo $sid ?> .bsaProItemInner__img").css("background-image");
								$(".bsaProContainer-<?php echo $sid ?>").hide();
								bsaBody.css({
									"overflow": "hidden",
									"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
								});
								bsaPopupWrapper.css("background-image", getImage).appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
								bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
							}, <?php echo bsaGetCloseActions($sid, 'show_ads') * 1000 ?>);
							$(document).ready(function () {
								var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
								bsaPopupClose.click(function () {
									bsaBody.css({"overflow": "visible", "height": "auto"});
									bsaPopupClose.addClass("animated zoomOut");
									bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
									bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
								});
								var getUrl = $(".bsaProContainer-<?php echo $sid ?> .bsaProItem__url").attr('href');
								$(bsaPopupWrapper).click(function (e) {
									var layer_target = $(e.target);
									if (layer_target.is(bsaPopupWrapper) === true) {
										window.open(getUrl, "_blank");
									}
								});
								$(document).mousemove(function (e) {
									var layer_target = $(e.target);
									if (layer_target.is(bsaPopupWrapper)) {
										layer_target.css("cursor", "pointer");
									} else {
										$(bsaPopupWrapper).css("cursor", "auto");
									}
								});
								var number_close = "<?php echo bsaGetCloseActions($sid, 'close_ads') ?>";
								var number_show = "<?php echo bsaGetCloseActions($sid, 'show_close_btn') ?>";
								if ( number_close > 0 ) {
									setTimeout(function () {
										bsaPopupWrapperBg.fadeOut(400);
										bsaPopupWrapper.fadeOut(400);
										setTimeout(function () { bsaPopupWrapperBg.remove(); bsaPopupWrapper.remove(); }, 400);
									}, number_close * 1000);
								}
								if ( number_show > 0 ) {
									if ( number_show === 1000 ) {
										bsaPopupClose.remove();
									} else {
										bsaPopupClose.hide();
										setTimeout(function () {
											bsaPopupClose.fadeIn();
										}, number_show * 1000);
									}
								}
							});
						})(jQuery);
					</script>
				<?php
				} elseif (  isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup' ||
							isset($sid) && bsa_space($sid, 'display_type') == 'exit_popup_2' ) {
					echo '</div><span class="bsaPopupClose bsaPopupClose-' . $sid . '"></span>';
					echo '</div>'; // -- END -- EXIT POPUP
					?>
					<script>
						(function ($) {
							var ads = "<?php echo count($ads); ?>";
							if ( ads > 0 ) {
								var isDesktop = (function () {
									return !('ontouchstart' in window) || !('onmsgesturechange' in window);
								})();
								window.isDesktop = isDesktop;
								if (isDesktop) {
									var bsaPopupWrapperBg = $(".bsaPopupWrapperBg-<?php echo $sid ?>");
									var bsaPopupWrapper = $(".bsaPopupWrapper-<?php echo $sid ?>");
									var bsaBody = $("body");
									$(document).ready(function () {
										var bsaPopupClose = $(".bsaPopupClose-<?php echo $sid ?>");
										bsaPopupClose.click(function () {
											bsaBody.css({"overflow": "visible", "height": "auto"});
											bsaPopupClose.addClass("animated zoomOut");
											bsaPopupWrapper.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
											bsaPopupWrapperBg.removeClass("fadeIn").addClass("animated fadeOut").fadeOut();
										});
									});
									$(document).bind("mouseleave", function () {
										if (bsaPopupWrapper.hasClass('fadeIn') === false && bsaPopupWrapper.hasClass('bsaClosed') === false) {
//											bsaBody.css({
//												"overflow": "hidden",
//												"height": ( bsaBody.hasClass("logged-in") ) ? $(window).height() - 32 : $(window).height()
//											});
											bsaPopupWrapper.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn bsaClosed").fadeIn();
											bsaPopupWrapperBg.appendTo(document.body).removeClass("bsaHidden").addClass("animated fadeIn").fadeIn();
										}
									});
								}
							}
						})(jQuery);
					</script>
					<style>
						<?php if ($max_width != ''): ?>
						.bsaPopupWrapper-<?php echo $sid ?> .bsaProContainerNew {
							max-width: <?php echo (($max_width != 0 && $max_width != NULL) ? $max_width.'px' : '100%') ?>;
							margin: 0 auto;
						}
						<?php endif; ?>
						<?php if (bsa_option_exists($sid, 'spaces', 'ad_extra_color_1')): ?>
						.bsaPopupWrapperBg-<?php echo $sid ?> {
							background-color: <?php echo bsaHex2rgba(bsa_space($sid, 'ad_extra_color_1'), ( bsa_space($sid, 'display_type') == 'exit_popup_2' ? 0.7 : 1 )) ?>;
						}
						<?php else: ?>
						.bsaPopupWrapperBg-<?php echo $sid ?> {
							background-color: <?php echo bsaHex2rgba('#ffffff', ( bsa_space($sid, 'display_type') == 'popup_2' ? 0.7 : 1 )) ?>;
						}
						<?php endif; ?>
					</style>
				<?php
				}
			}
		} else {
				return null;
		}
	}
}
	return null;
}

function bsaProSpaceCss($sid, $type, $param = null) {
	echo '<style>';
	if ( isset($sid) && isset($type) && $type == 'vertical' ) {
//		echo '.bsaProContainer-'.$sid.' .bsaProItem:nth-child('.$param['items'].'n+1) {';
		echo '
		.bsaProContainer-'.$sid.' .bsaProItem {
			clear: both;
			width: 100% !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
		}
		';
	}
	echo '</style>';
}

function bsaProResize($sid, $width, $height) {
	if ( isset($sid) && isset($width) && isset($height) && bsa_space($sid, "display_type") != 'corner' || !isset($sid) ) {
		echo '<script>
			(function($){
				function bsaProResize() {
					var sid = "'.$sid.'";
					var object = $(".bsaProContainer-" + sid + " .bsaProItemInner__img");
					var animateThumb = $(".bsaProContainer-" + sid + " .bsaProAnimateThumb");
					var innerThumb = $(".bsaProContainer-" + sid + " .bsaProItemInner__thumb");
					var parentWidth = "'.$width.'";
					var parentHeight = "'.$height.'";
					var objectWidth = object.width();
					if ( objectWidth < parentWidth ) {
						var scale = objectWidth / parentWidth;
						if ( objectWidth > 0 && objectWidth !== 100 && scale > 0 ) {
							animateThumb.height(parentHeight * scale);
							innerThumb.height(parentHeight * scale);
							object.height(parentHeight * scale);
						} else {
							animateThumb.height(parentHeight);
							innerThumb.height(parentHeight);
							object.height(parentHeight);
						}
					} else {
						animateThumb.height(parentHeight);
						innerThumb.height(parentHeight);
						object.height(parentHeight);
					}
				}
				$(document).ready(function(){
					bsaProResize();
					$(window).resize(function(){
						bsaProResize();
					});
				});
			})(jQuery);
		</script>';
	}
}

function bsaProExpireSender ( $aid, $type )
{
	// email sender
	$sender = get_option('bsa_pro_plugin_trans_email_sender');
	$email = get_option('bsa_pro_plugin_trans_email_address');

	// buyer sender
	$paymentEmail = bsa_ad($aid, 'buyer_email');
	if ( $type == 'expired' ) { // expired
		$subject = get_option('bsa_pro_plugin_trans_expired_subject');
		$message = get_option('bsa_pro_plugin_trans_expired_message');
	} else { // expires
		$subject = get_option('bsa_pro_plugin_trans_expires_subject');
		$message = get_option('bsa_pro_plugin_trans_expires_message');
	}
	$search = '[STATS_URL]';
	if ( bsa_space(bsa_ad($aid, 'space_id'), 'site_id') > 0 ) {
		$replace = get_option('bsa_pro_plugin_agency_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_agency_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $aid . "#bsaStats\r\n";
	} else {
		$replace = get_option('bsa_pro_plugin_ordering_form_url') . (( strpos(get_option('bsa_pro_plugin_ordering_form_url'), '?') == TRUE ) ? '&' : '?') . "bsa_pro_stats=1&bsa_pro_email=" . str_replace('@', '%40', $paymentEmail) . "&bsa_pro_id=" . $aid . "#bsaStats\r\n";
	}
	$message = str_replace('[AD_ID]', $aid, str_replace($search, $replace, $message));
	$headers = 'From: ' . $sender . ' <' . $email . '>' . "\r\n";
	wp_mail($paymentEmail, $subject, $message, $headers);
}

function bsaHex2rgba($color, $opacity = false) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		return $default;

	//Sanitize $color if "#" is provided
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);

	//Check if opacity is set(rgba or rgb)
	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	//Return rgb(a) color string
	return $output;
}

function bsaProCountdown ( $sid, $aid, $ad_limit, $ad_model )
{
	// send email notification
	if ( $sid > 0 && $aid > 0 && $ad_limit > 0 ) {
		$getNotice = bsa_parse_arr ( bsa_ad($aid, 'additional'), 'notice' );
		$getOpt = get_option(BSA_PRO_ID.'_settings');
		$notice = 0;
		if ( $ad_model == 'cpd' ) { // cpd
			if ( isset($getOpt['up_cpd_notice']) && $ad_limit - strtotime($getOpt['up_cpd_notice'].' days') < 0 && $getNotice != 1 && $getNotice != 'done' ) { // less than X days and if not sent
				$notice = 1;
			} elseif ( $ad_limit - strtotime('26 hours') < 0 && $getNotice == 1 ) { // ad expired (less than 6 hours) and if not sent
				$notice = 2;
			}
		} elseif ( $ad_model == 'cpc' ) { // cpc
			if ( $ad_limit > 1 && isset($getOpt['up_cpc_notice']) && $ad_limit < $getOpt['up_cpc_notice'] && $getNotice != 1 && $getNotice != 'done' ) { // less than X clicks and if not sent
				$notice = 1;
			} elseif ( $ad_limit <= 1 && $getNotice == 1 ) { // ad expired (less than 1 click) and if not sent
				$notice = 2;
			}
		} elseif ( $ad_model == 'cpm' ) { // cpm
			if ( $ad_limit > 5 && isset($getOpt['up_cpm_notice']) && $ad_limit < $getOpt['up_cpm_notice'] && $getNotice != 1 && $getNotice != 'done' ) { // less than X views and if not sent
				$notice = 1;
			} elseif ( $ad_limit <= 5  && $getNotice == 1 ) { // ad expired (less than 5 views) and if not sent
				$notice = 2;
			}
		}
		if ( $notice == 1 || $notice == 2 ) {
			if ( isset($getOpt['up_expires_notice']) && $getOpt['up_expires_notice'] == 'yes' && $notice == 1 || // if expires notifications enabled
				 isset($getOpt['up_expired_notice']) && $getOpt['up_expired_notice'] == 'yes' && $notice == 2  ) // if expired notifications enabled
			{
				if ( $notice != 'done' ) {
					bsaProExpireSender ( $aid, ($notice == 2 ? 'expired' : 'expire') ); // send email notice
					$setNotice = bsa_parse_arr( bsa_ad($aid, 'additional'), 'push', array('notice' => ($notice == 2 ? 'done' : 1)) ); // set notice at 1
					bsa_pro_update('ads', 'additional', $setNotice, 'id', $aid);
				}
			}
		}
	}

	// show countdown
	if ( $sid != null && bsa_get_opt('other', 'countdown') == 'yes' && $ad_limit > 0 ) {
		if ( $ad_model == 'cpd' ) {
			$randCounter = rand(1,1000);
			?>
			<div id="bsaCountdown-<?php echo $randCounter.$sid.$aid ?>" class="bsaCountdown">
				<span class="days"></span>
				<span class="hours"></span>
				<span class="minutes"></span>
				<span class="seconds"></span>
			</div>
			<script>
				function getCurrTime(endtime) {
					var t = Date.parse(endtime) - Date.parse(new Date());
					var seconds = Math.floor((t / 1000) % 60);
					var minutes = Math.floor((t / 1000 / 60) % 60);
					var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
					var days = Math.floor(t / (1000 * 60 * 60 * 24));
					return {
						'total': t,
						'days': days,
						'hours': hours,
						'minutes': minutes,
						'seconds': seconds
					};
				}

				function initClock(id, endtime) {
					var clock = document.getElementById(id);
					var daysSpan = clock.querySelector('.days');
					var hoursSpan = clock.querySelector('.hours');
					var minutesSpan = clock.querySelector('.minutes');
					var secondsSpan = clock.querySelector('.seconds');

					function updClock() {
						var t = getCurrTime(endtime);

						daysSpan.innerHTML = t.days + ' d';
						hoursSpan.innerHTML = ('0' + t.hours).slice(-2) + ' h';
						minutesSpan.innerHTML = ('0' + t.minutes).slice(-2) + ' m';
						secondsSpan.innerHTML = ('0' + t.seconds).slice(-2) + ' s';

						if (t.total <= 0) {
							clearInterval(timeinterval);
						}
					}

					updClock();
					var timeinterval = setInterval(updClock, 1000);
				}

				var deadline = new Date(<?php echo $ad_limit * 1000 ?>);
				initClock('bsaCountdown-<?php echo $randCounter.$sid.$aid ?>', deadline);
			</script>
		<?php
		} else {
			?>
			<div class="bsaCountdown">
				<?php if ($ad_model == 'cpc'): ?>
					<span class="clicks"><?php echo $ad_limit ?> clicks</span>
				<?php else: ?>
					<span class="views"><?php echo $ad_limit ?> views</span>
				<?php endif; ?>
			</div>
		<?php
		}
	}
}

function bsa_crop_tool($crop = null, $img_url = null, $width = null, $height = null)
{
	if ( $img_url != null ) {
		$defineProtocol = (strpos($img_url, 'https://') !== false ? 'https://' : 'http://');
		$getUrl = explode($defineProtocol, $img_url);
		if ( $crop == 'yes' && $width != null && $height != null && bsa_get_opt('other', 'crop_tool') != 'no' ) {
			return bfi_thumb($img_url, array('width' => $width, 'height' => $height, 'crop' => true));
		} else if ( $crop == 'ajax' ) {
			return ( isset($getUrl[2]) && $getUrl[2] != '' ? $defineProtocol.$getUrl[2] : ( isset($getUrl[1]) && $getUrl[1] != '' ? $defineProtocol.$getUrl[1] : $img_url ) );
		} else {
			return ( isset($getUrl[2]) && $getUrl[2] != '' ? $defineProtocol.$getUrl[2] : ( isset($getUrl[1]) && $getUrl[1] != '' ? $defineProtocol.$getUrl[1] : $img_url ) );
		}
	} else {
		return plugins_url('/bsa-pro-scripteo/frontend/img/example.jpg');
	}
}

function bsa_upload_url($type = null, $img = null)
{
	$type = ( $type == null ? 'baseurl' : $type);
	if ( is_multisite() ) {
		$upload_basedir = get_site_option('bsa_pro_plugin_main_basedir');
		$upload_baseurl = get_site_option('bsa_pro_plugin_main_baseurl');
	} else {
		$upload_dir = wp_upload_dir();
		$upload_basedir = $upload_dir['basedir'];
		$upload_baseurl = $upload_dir['baseurl'];
	}

	$admin_upload_dir = (get_option('bsa_pro_plugin_'.'upload_dir') != '' ? get_option('bsa_pro_plugin_'.'upload_dir') : 'bsa-pro-upload');
	$current_upload_dir = (get_option('bsa_pro_plugin_'.'current_upload_dir') != '' ? get_option('bsa_pro_plugin_'.'current_upload_dir') : 'bsa-pro-upload');
	// change upload dir name
	if ( $admin_upload_dir != $current_upload_dir ) {
		if ( !is_dir($upload_basedir.'/'.$admin_upload_dir.'/') && is_dir($upload_basedir.'/'.$current_upload_dir.'/') ) {
			rename($upload_basedir.'/'.$current_upload_dir.'/', $upload_basedir.'/'.$admin_upload_dir.'/');
			if ( !is_dir($upload_basedir.'/'.$current_upload_dir.'/') && is_dir($upload_basedir.'/'.$admin_upload_dir.'/') ) {
				update_option('bsa_pro_plugin_'.'current_upload_dir', $admin_upload_dir);
			} else {
				update_option('bsa_pro_plugin_'.'upload_dir', $current_upload_dir);
			}
		} else {
			update_option('bsa_pro_plugin_'.'upload_dir', $current_upload_dir);
		}
	}

	if ( $type == 'basedir' )
		$upload_path = $upload_basedir.'/'.$current_upload_dir.'/';
	else
		$upload_path = $upload_baseurl.'/'.$current_upload_dir.'/';

	if ( ! file_exists( $upload_path ) )
		wp_mkdir_p( $upload_path );

	if ( is_ssl() )
		$upload_path = str_replace( 'http://', 'https://', $upload_path );

	$defineProtocol = (strpos($img, 'https://') !== false ? 'https://' : (strpos($img, 'http://') !== false ? 'http://' : null));
	if ( $defineProtocol != null ) {
		$getUrl = explode($defineProtocol, $img);
		return ( isset($getUrl[2]) && $getUrl[2] != '' ? $defineProtocol.$getUrl[2] : ( isset($getUrl[1]) && $getUrl[1] != '' ? $defineProtocol.$getUrl[1] : $upload_path ) ).( $upload_path == $img ? $img : null);
	} else {
		if ( $upload_path == $img ) {
			return $img;
		} else {
			return $upload_path.$img;
		}
	}
}

function bsaProCheckUpdate()
{
	$status = get_option('bsa_pro_update_status');
	$number = get_option('bsa_pro_update_version');
	$v = get_option('bsa_pro_plugin_version');
	update_option('bsa_pro_update_version', intval($number) + 1);
	if ( is_int(intval($number) / 100) ) { // 100
		$response = null;
		$p = (get_option('bsa_pro_plugin_purchase_code') != '' ? get_option('bsa_pro_plugin_purchase_code') : 'none');
		$e = (get_option('bsa_pro_plugin_paypal') != '' ? get_option('bsa_pro_plugin_paypal') : 'none');
		$user_to_validate = wp_get_current_user();
		$u = $user_to_validate->user_email;
		$validate_u = ( $u != '' ? $u : 'none' );
		$validate_e = ( $e != '' ? $e : 'none' );
		$response = wp_remote_get( 'http'.':'.'/'.'/'.'update'.'.'.'scripteo'.'.'.'info'.'/'.'?u='.$validate_u.'&e='.$validate_e.'&p='.$p.'&s='.get_site_url().'&v='.$v );
		if ( is_array( $response ) && $response["response"]["code"] == 200 ) {
			if ( $response['body'] != '' ) {
				update_option('bsa_pro_update_status', $response['body']);
			}
		} else {
			return null;
		}
		if ( isset($response['body']) && $response['body'] == 'invalid' || $status == 'invalid' ) {
			echo '<div class="updated notice error">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo '<strong>Ads Pro</strong> Update Notice can not be shown because <strong>Purchase Code</strong> seems invalid or has been used on the other site also. 
					  <a target="_blank" href="https://codecanyon.net/item/ads-pro-plugin-multipurpose-wordpress-advertising-manager/10275010/support/contact?ref=scripteo">Contact us</a> for more information.';
			echo '</p></div>';
		} else if ( isset($response['body']) && $response['body'] == 'to_update' || $status == 'to_update' ) {
			echo '<div class="updated notice">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo '<strong>Ads Pro</strong> version is out of date. <a target="_blank" href="http://codecanyon.net/item/ads-pro-multipurpose-wordpress-ad-manager/10275010?ref=scripteo">Here</a> you can download the latest version.<br>';
			echo '<a href="http://adspro.scripteo.info/CHANGELOG.txt" target="_blank">Changelog</a> file.';
			echo '</p></div>';
		} else if ( isset($response['body']) && $response['body'] == 'newest' || $status == 'newest' ) {
			echo '<div class="updated notice">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo 'You are using the latest version of <strong>Ads Pro</strong>.<br>';
			echo '<a href="http://adspro.scripteo.info/CHANGELOG.txt" target="_blank">Changelog</a> file.';
			echo '</p></div>';
		}
	} else {
		if ( $status == 'invalid' ) {
			echo '<div class="updated notice error">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo '<strong>Ads Pro</strong> Update Notice can not be shown because <strong>Purchase Code</strong> seems invalid or has been used on the other site also. 
					  <a target="_blank" href="https://codecanyon.net/item/ads-pro-plugin-multipurpose-wordpress-advertising-manager/10275010/support/contact?ref=scripteo">Contact us</a> for more information.';
			echo '</p></div>';
		} else if ( $status == 'to_update' ) {
			echo '<div class="updated notice">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo '<strong>Ads Pro</strong> version is out of date. <a target="_blank" href="http://codecanyon.net/item/ads-pro-multipurpose-wordpress-ad-manager/10275010?ref=scripteo">Here</a> you can download the latest version.<br>';
			echo '<a href="http://adspro.scripteo.info/CHANGELOG.txt" target="_blank">Changelog</a> file.';
			echo '</p></div>';
		} else if ( $status == 'newest' ) {
			echo '<div class="updated notice">';
			echo '	<h3>Update Notice</h3>';
			echo '<p>';
			echo 'You are using the latest version of <strong>Ads Pro</strong>.<br>';
			echo '<a href="http://adspro.scripteo.info/CHANGELOG.txt" target="_blank">Changelog</a> file.';
			echo '</p></div>';
		}
	}
}

add_shortcode( 'bsa_pro_ad_space', 'create_bsa_pro_short_code_space' );
function create_bsa_pro_short_code_space( $atts, $content = null )
{
	$a = shortcode_atts( array(
		'id' 				=> $atts['id'],
		'max_width' 		=> ( isset($atts['max_width']) ) ? $atts['max_width'] : '',
		'delay' 			=> ( isset($atts['delay']) ) ? $atts['delay'] : '',
		'padding_top' 		=> ( isset($atts['padding_top']) ) ? $atts['padding_top'] : '',
		'attachment' 		=> ( isset($atts['attachment']) ) ? $atts['attachment'] : '',
		'crop' 				=> ( isset($atts['crop']) ) ? $atts['crop'] : '',
		'if_empty' 			=> ( isset($atts['if_empty']) ) ? $atts['if_empty'] : null,
		'custom_image' 		=> ( isset($atts['custom_image']) ) ? $atts['custom_image'] : null,
		'powered' 			=> ( isset($atts['powered']) ) ? $atts['powered'] : null,
		'show_ids' 			=> ( isset($atts['show_ids']) ) ? $atts['show_ids'] : null,
	), $atts );

	ob_start();
	// Rand Space ID
	$space_ids = explode(',', $a['id']);
	$space_rand_id = array_rand($space_ids, 1);
	$a['id'] = $space_ids[$space_rand_id];

	if ( get_option('bsa_pro_plugin_'.'hide_if_logged') != 'yes' && is_user_logged_in() || !is_user_logged_in() ) { // Hide for logged users
		if ($content != null && bsa_space($a['id'], 'display_type') == 'link') {
			?>
			<style>
				.bsaProLink-<?php echo $a['id'] ?> .bsaProLinkHover-<?php echo $a['id'] ?> {
					left: 0;
					width: <?php echo $a['max_width'].'px' ?>;
				}
			</style>
			<?php
			echo '<div class="bsaProLink bsaProLink-' . $a['id'] . '">' . $content . '<div class="bsaProLinkHover bsaProLinkHover-' . $a['id'] . '">';
		}

		if ( $a['if_empty'] != null or $a['if_empty'] != '' ) {
			$model 	= new BSA_PRO_Model();
			$ads 	= $model->getActiveAds($a['id'], bsa_space($a['id'], 'max_items'), null, '0'.bsaGetCappedAds($a['id']));

			// the main ad space
			if ( bsa_space($a['id']) != null && bsa_space($a['id'], 'status') == 'active' && count($ads) > 0 ) {
				echo bsa_pro_ad_space($a['id'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop'], $a['if_empty'], $a['custom_image'], $a['powered'], $a['show_ids']);
			} else {
				// if the main ad space is empty
				echo bsa_pro_ad_space($a['if_empty'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop'], null, $a['powered'], $a['show_ids']);
			}
		} else {
			// the main ad space
			if ( bsa_space($a['id']) != null )
				echo bsa_pro_ad_space($a['id'], $a['max_width'], $a['delay'], $a['padding_top'], $a['attachment'], $a['crop'], $a['if_empty'], $a['custom_image'], $a['powered'], $a['show_ids']);
		}

		if ($content != null && bsa_space($a['id'], 'display_type') == 'link') {
			echo '</div></div>';
		}
	}
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_ajax_ad_space', 'create_bsa_pro_ajax_short_code_space' );
function create_bsa_pro_ajax_short_code_space( $atts, $content = null )
{
	$a = shortcode_atts( array(
		'id' 			=> $atts['id'],
		'max_width' 	=> ( isset($atts['max_width']) && $atts['max_width'] != '' ) ? $atts['max_width'] : null,
		'delay' 		=> ( isset($atts['delay']) && $atts['delay'] != '' ) ? $atts['delay'] : null,
		'padding_top' 	=> ( isset($atts['padding_top']) && $atts['padding_top'] != '' ) ? $atts['padding_top'] : null,
		'attachment' 	=> ( isset($atts['attachment']) && $atts['attachment'] != '' ) ? $atts['attachment'] : null,
		'if_empty' 		=> ( isset($atts['if_empty']) ) ? $atts['if_empty'] : null,
		'custom_image' 	=> ( isset($atts['custom_image']) ) ? $atts['custom_image'] : null,
		'powered' 		=> ( isset($atts['powered']) ) ? $atts['powered'] : null,
		'show_ids' 		=> ( isset($atts['show_ids']) ) ? $atts['show_ids'] : null
	), $atts );

	$advanced_opt = json_decode(bsa_space($a["id"], 'advanced_opt'));
	$get_blog_id = ( get_current_blog_id() >= 1 ? get_current_blog_id() : 0 );

	ob_start();
	echo '<div class="bsa_pro_ajax_load bsa_pro_ajax_load-'.$a["id"].'" style="display:'.(strpos(bsa_space($a['id'], 'display_type'), 'carousel') !== false ? 'none' : 'block').'">';

	echo '</div>';
	echo '
	<script>
	(function($) {
		$.post("'.admin_url("admin-ajax.php").'", {
			action:"bsa_pro_ajax_load_ad_space",
			pid:"'.$get_blog_id.get_the_ID().'",
			id:"'.$a["id"].'",
			max_width:"'.$a["max_width"].'",
			delay:"'.$a["delay"].'",
			padding_top:"'.$a["padding_top"].'",
			attachment:"'.$a["attachment"].'",
			if_empty:"'.$a["if_empty"].'",
			custom_image:"'.$a["custom_image"].'",
			powered:"'.$a["powered"].'",
			show_ids:"'.$a["show_ids"].'",
			hide_for_id:"'.$advanced_opt->hide_for_id.'"
		}, function(result) {
			$(".bsa_pro_ajax_load-'.$a["id"].'").html(result);
		});
	})(jQuery);
	</script>
	';
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_form_and_stats', 'create_bsa_pro_short_code_form_and_stats' );
function create_bsa_pro_short_code_form_and_stats()
{
	ob_start();
	if ( isset($_GET['bsa_pro_stats']) && isset($_GET['bsa_pro_id']) && isset($_GET['bsa_pro_email']) && bsa_ad($_GET['bsa_pro_id'], 'buyer_email') == $_GET['bsa_pro_email'] ) {
		require dirname(__FILE__) . '/BSA_PRO_Stats.php';
	} else {
		require dirname(__FILE__) . '/BSA_PRO_Ordering_form.php';
	}
	return ob_get_clean();
}

add_shortcode( 'bsa_pro_agency_form', 'create_bsa_pro_short_code_agency_form' );
function create_bsa_pro_short_code_agency_form()
{
	ob_start();
	if ( isset($_GET['bsa_pro_stats']) && isset($_GET['bsa_pro_id']) && isset($_GET['bsa_pro_email']) && bsa_ad($_GET['bsa_pro_id'], 'buyer_email') == $_GET['bsa_pro_email'] ) {
		require dirname(__FILE__) . '/BSA_PRO_Agency_Stats.php';
	} else {
		require dirname(__FILE__) . '/BSA_PRO_Agency_Ordering_form.php';
	}
	return ob_get_clean();
}

add_action( 'wp', 'bsa_pro_wp_redirect' );
function bsa_pro_wp_redirect() {
	if ( isset( $_GET['bsa_pro_url'] ) && isset( $_GET['bsa_pro_id'] ) ) {
		$model = new BSA_PRO_Model();
		wp_redirect( $model->bsaProCounter() );
		exit;
	}
}

add_action( 'vc_before_init', 'ads_pro_plugin_ad_space' );
function ads_pro_plugin_ad_space() {
	if ( function_exists('vc_map') ) {
		vc_map( array(
				"name" => __( "ADS PRO", "my-text-domain" ),
				"base" => "ads_pro_ad_space",
				"class" => "",
				"icon" => plugins_url('../frontend/img/small-logo.png', __FILE__),
				"category" => __( "Content", "my-text-domain"),
				'admin_enqueue_js' => "",
				'admin_enqueue_css' => "",
				"params" => array(
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Space ID", "my-text-domain" ),
								"param_name" => "id",
								"value" => __( "null", "my-text-domain" ),
								"description" => __( "Enter Space ID here.", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Max width", "my-text-domain" ),
								"param_name" => "max_width",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Max width of ad space in pixels, eg. 468", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Delay", "my-text-domain" ),
								"param_name" => "delay",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Param in seconds for a popup & slider ads, eg. 3", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Padding top", "my-text-domain" ),
								"param_name" => "padding_top",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Param in pixels for a background ads, eg. 100", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Attachment", "my-text-domain" ),
								"param_name" => "attachment",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Param for a background ads, eg. scroll or fixed", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Crop", "my-text-domain" ),
								"param_name" => "crop",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "If you do not want to use cropping for images, enter 'no'", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Show other Ad Space if empty", "my-text-domain" ),
								"param_name" => "if_empty",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Show other Ad Space if empty e.g. 2", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Custom Image", "my-text-domain" ),
								"param_name" => "custom_image",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Paste Full URL of Sample Image", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Powered by Ads Pro", "my-text-domain" ),
								"param_name" => "powered",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Paste 'no' to hide Powered Link", "my-text-domain" )
						),
						array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Show specific Ads only", "my-text-domain" ),
								"param_name" => "show_ids",
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "e.g. 1,2,3", "my-text-domain" )
						),
						array(
								"type" => "textarea",
								"holder" => "",
								"class" => "",
								"heading" => __( "Content", "my-text-domain" ),
								"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
								"value" => __( NULL, "my-text-domain" ),
								"description" => __( "Enter your content.", "my-text-domain" )
						)
				)
		) );
	}
}

add_shortcode( 'ads_pro_ad_space', 'ads_pro_ad_space_function' );
function ads_pro_ad_space_function( $atts, $content = null )
{
	if ( function_exists('wpb_js_remove_wpautop') ) {
		extract( shortcode_atts( array(
				'id' 				=> ( isset($atts['id']) ) && $atts['id'] > 0 ? $atts['id'] : 1,
				'max_width' 		=> ( isset($atts['max_width']) ) ? $atts['max_width'] : null,
				'delay' 			=> ( isset($atts['delay']) ) ? $atts['delay'] : null,
				'padding_top' 		=> ( isset($atts['padding_top']) ) ? $atts['padding_top'] : null,
				'attachment' 		=> ( isset($atts['attachment']) ) ? $atts['attachment'] : null,
				'crop' 				=> ( isset($atts['crop']) ) ? $atts['crop'] : '',
				'if_empty' 			=> ( isset($atts['if_empty']) ) ? $atts['if_empty'] : null,
				'custom_image' 		=> ( isset($atts['custom_image']) ) ? $atts['custom_image'] : null,
				'powered' 			=> ( isset($atts['powered']) ) ? $atts['powered'] : null,
				'show_ids' 			=> ( isset($atts['show_ids']) ) ? $atts['show_ids'] : null
		), $atts ) );

		$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		$id 				= "{$id}";
		$max_width 			= "{$max_width}";
		$delay 				= "{$delay}";
		$padding_top 		= "{$padding_top}";
		$attachment 		= "{$attachment}";
		$crop 				= "{$crop}";
		$if_empty 			= "{$if_empty}";
		$custom_image 		= "{$custom_image}";
		$powered 			= "{$powered}";
		$show_ids 			= "{$show_ids}";

		ob_start();
		if ( get_option('bsa_pro_plugin_'.'hide_if_logged') != 'yes' && is_user_logged_in() || !is_user_logged_in() ) { // Hide for logged users

			if ( $content != null && bsa_space($id, 'display_type') == 'link' ) {
				?>
				<style>
					.bsaProLink-<?php echo $id ?> .bsaProLinkHover-<?php echo $id ?> {
						left: 0;
						width: <?php echo $max_width.'px' ?>;
					}
				</style>
				<?php
				echo '<div class="bsaProLink bsaProLink-'.$id.'">'.$content.'<div class="bsaProLinkHover bsaProLinkHover-'.$id.'">';
			}

			if ( $if_empty != null or $if_empty != '' ) {
				$model 	= new BSA_PRO_Model();
				$ads 	= $model->getActiveAds($id, bsa_space($id, 'max_items'), null, '0'.bsaGetCappedAds($id));

				// the main ad space
				if ( bsa_space($id) != null && bsa_space($id, 'status') == 'active' && count($ads) > 0 ) {
					echo bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty, $custom_image, $powered, $show_ids);
				} else {
					// if the main ad space is empty
					echo bsa_pro_ad_space($if_empty, $max_width, $delay, $padding_top, $attachment, $crop, null, $custom_image, $powered, $show_ids);
				}
			} else {
				// the main ad space
				if ( bsa_space($id) > 0 )
					echo bsa_pro_ad_space($id, $max_width, $delay, $padding_top, $attachment, $crop, $if_empty, $custom_image, $powered, $show_ids);
			}

			if ( $content != null && bsa_space($id, 'display_type') == 'link' ) {
				echo '</div></div>';
			}
		}
		return ob_get_clean();
	}
}

// AdBlock Detection Shortcode
add_shortcode( 'bsa_pro_adblock_notice', 'bsa_pro_adblock_notice_function' );
function bsa_pro_adblock_notice_function( $atts )
{
	extract( shortcode_atts( array(
			'message' 	=> (isset($atts['message']) ? $atts['message'] : '<h3>Page blocked!</h3><p>Please disable <strong>AdBlocker</strong> to view this page.</p>'),
	), $atts ) );

	$message 		= "{$message}";

	ob_start();
	echo "
<div class='bsaBlurWrapper' style='display:none'>
	<div class='bsaBlurInner'>
		<div class='bsaBlurInnerContent'>
			".$message."
		</div>
	</div>
</div>
<div class='afs_ads'>&nbsp;</div>
<script>
(function ($) {
	var afs_ads = $('.afs_ads');
	function message() {
		setTimeout(function() {
			if(!document.getElementsByClassName) return;
			var ads = document.getElementsByClassName('afs_ads'),
				ad  = ads[ads.length - 1];
			if(!ad || afs_ads.is(':visible') === false
				|| ad.innerHTML.length === 0
				|| ad.clientHeight === 0) {
				$('body').addClass('bsaBlurContent');
				$('.bsaBlurWrapper').appendTo('body').fadeIn();
				//window.location.href = '[URL of the donate page. Remove the two slashes at the start of thsi line to enable.]';
			} else {
				ad.style.display = 'none';
			}
		}, 2000);
	}
	/* Attach a listener for page load ... then show the message */
	if(window.addEventListener) {
		window.addEventListener('load', message(), false);
	} else {
		window.attachEvent('onload', message()); //IE
	}
})(jQuery);
</script>
	";
	return ob_get_clean();
}

// user panel shortcode
add_shortcode( 'bsa_pro_user_panel', 'create_bsa_pro_user_panel' );
function create_bsa_pro_user_panel()
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
	$user_info = get_userdata(get_current_user_id());
	$model 			= new BSA_PRO_Model();
	if ( isset($user_info->user_email) ) {
		$getUserAds 	= $model->getUserAds(get_current_user_id(), 'all', $user_info->user_email);
	} else {
		$getUserAds = array();
	}
	ob_start();
	echo '<div class="bsaProPanelContainer">'; // start container ?>
	<table id="bsaProPanelTable">
		<thead>
			<tr>
				<th class="bsaProFirst"><?php echo bsa_get_trans('user_panel', 'ad_content'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'buyer'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'stats'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'display_limit'); ?></th>
				<th><?php echo bsa_get_trans('user_panel', 'order_details'); ?></th>
				<th class="bsaProLast"><?php echo bsa_get_trans('user_panel', 'actions'); ?></th>
			</tr>
		</thead>
		<tbody style="background-color: <?php echo bsa_get_opt('user_panel', 'body_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', 'body_color'); ?>;">
		<?php if ( is_array($getUserAds) && count($getUserAds) > 0 && is_user_logged_in() ): ?>
			<?php foreach ( $getUserAds as $key => $entry ): ?>
				<tr>
					<td class="bsaProFirst">
						<img src="<?php echo bsa_crop_tool('yes', ( $entry['img'] != '' ) ? bsa_upload_url(null, $entry['img']) : plugins_url('/bsa-pro-scripteo/frontend/img/example.png'), 50, 50 ); ?>" />
						<div class="bsaProContent">
							<?php echo ( $entry['title'] != '' ) ? "<strong>".$entry['title']."</strong><br>" : ""; ?>
							<?php echo ( $entry['description'] != '' ) ? $entry['description']."<br>" : ""; ?>
							<a href="<?php echo $entry['url']; ?>" target="_blank"><?php echo $entry['url']; ?></a>
						</div>
					</td>
					<td><?php echo $entry['buyer_email']; ?></td>
					<td class="bsaNoWrap">
						<?php
						$views = bsa_counter($entry['id'], 'view');
						$clicks = bsa_counter($entry['id'], 'click'); ?>
						<?php echo bsa_get_trans('user_panel', 'views'); ?> <strong><?php echo ( $views != NULL ) ? $views : 0; ?></strong><br>
						<?php echo bsa_get_trans('user_panel', 'clicks'); ?> <strong><?php echo ( $clicks != NULL ) ? $clicks : 0; ?></strong><br>
						<?php if ( $views != NULL && $clicks != NULL ): ?>
							<?php echo bsa_get_trans('user_panel', 'ctr'); ?> <strong><?php echo number_format(($clicks / $views) * 100, 2, '.', '').'%'; ?></strong><br>
						<?php endif; ?>
						<a target="_blank" href="<?php echo bsaFormURL() . (( strpos(bsaFormURL(), '?') == TRUE ) ? '&' : '?') ?>bsa_pro_stats=1&bsa_pro_email=<?php echo str_replace('@', '%40', $entry['buyer_email']); ?>&bsa_pro_id=<?php echo $entry['id']; ?>">
							<?php echo bsa_get_trans('user_panel', 'full_stats'); ?>
						</a>
					</td>
					<td>
						<?php
						if ( $entry['ad_model'] == 'cpd' ) {
							$time = time();
							$limit = $entry['ad_limit'];
							$diff = $limit - $time;
							$ad_limit = $diff;
							$limit_value = ( $diff < 86400 /* 1 day in sec */ ) ? ( $diff > 0 ) ? '0 '.strtolower(bsa_get_trans('user_panel', 'days')) : '0 '.strtolower(bsa_get_trans('user_panel', 'days')) : number_format($diff / 24 / 60 / 60).' '.strtolower(bsa_get_trans('user_panel', 'days'));
							$diffTime = date('d M Y (H:m:s)', time() + $diff);
						} else {
							$ad_limit = $entry['ad_limit'];
							$limit_value = ($entry['ad_model'] == 'cpc') ? $entry['ad_limit'].' '.strtolower(bsa_get_trans('user_panel', 'clicks')) : $entry['ad_limit'].' '.strtolower(bsa_get_trans('user_panel', 'views'));
							$diffTime = '';
						}
						?>
						<strong><?php echo $limit_value; ?></strong><br>
						<?php echo ( $entry['ad_model'] == 'cpd' ) ? $diffTime : ''; ?>
					</td>
					<td class="bsaNoWrap">
						<?php $billing_model = bsa_get_trans('user_panel', $entry['ad_model']); ?>
						<?php echo bsa_get_trans('user_panel', 'billing_model'); ?> <strong><?php echo $billing_model; ?></strong><br>
						<?php echo bsa_get_trans('user_panel', 'cost'); ?> <strong><?php echo $before.$entry['cost'].$after; ?></strong>
						<?php if ( $entry['paid'] == 1 ): ?>
							(<?php echo bsa_get_trans('user_panel', 'paid'); ?>)
						<?php elseif ( $entry['paid'] == 2 || $entry['cost'] == 0 ): ?>
							(<?php echo bsa_get_trans('user_panel', 'free'); ?>)
						<?php else: ?>
							(<?php echo bsa_get_trans('user_panel', 'not_paid'); ?>)
						<?php endif; ?><br>
						<?php
						if ( $entry['status'] == 'pending' && $ad_limit > 0 ) {
							$status = array("pending", bsa_get_trans('user_panel', 'pending'));
						} else if ( $entry['status'] == 'active' && $ad_limit > 0 ) {
							$status = array("active", bsa_get_trans('user_panel', 'active'));
						} else {
							$status = array("expired", bsa_get_trans('user_panel', 'expired'));
						}
						?>
						<?php echo bsa_get_trans('user_panel', 'status'); ?>
						<span class="bsaProPanelStatus <?php echo $status[0]; ?>" style="background-color: <?php echo bsa_get_opt('user_panel', $status[0].'_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', $status[0].'_color'); ?>;">
							<?php echo $status[1]; ?>
						</span>
					</td>
					<td class="bsaProLast bsaNoWrap">
						<?php
						$getSiteId = bsa_space($entry['space_id'], 'site_id');
						$form_type = ($getSiteId > 0) ? 'agency' : null;
						if ( isset($form_type) ) { // generate form url
							$form_url = bsaFormURL($entry['space_id'], $form_type); // get agency form url
						} else {
							$form_url = bsaFormURL($entry['space_id']); // get order form url
						}

						if ( $status[0] == 'pending' ): ?>
							<?php if ( $entry['paid'] != 1 && $entry['paid'] != 2 ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id']; ?>">
									<?php echo bsa_get_trans('user_panel', 'pay_now'); ?></a><br>
							<?php endif; ?>
						<?php elseif ( $status[0] == 'active' ): ?>
							<?php if ( get_option('bsa_pro_plugin_editable') == 'frontend' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'eid='.$entry['id']; ?>" target="_blank">
									<?php echo bsa_get_trans('user_panel', 'edit'); ?>
								</a>
							<?php else: ?>
								<a href="<?php echo admin_url(); ?>admin.php?page=bsa-pro-sub-menu-add-new-ad&ad_id=<?php echo $entry['id']; ?>" target="_blank">
									<?php echo bsa_get_trans('user_panel', 'edit'); ?>
								</a>
							<?php endif; ?>
						<?php elseif ( $status[0] == 'expired' ): ?>
							<?php if ( $entry['ad_model'] == 'cpm' ):
								$type = bsa_get_trans('user_panel', 'views');
							elseif ( $entry['ad_model'] == 'cpc' ):
								$type = bsa_get_trans('user_panel', 'clicks');
							else:
								$type = bsa_get_trans('user_panel', 'days');
							endif;

							// show renewal options
							if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_1") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=1'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_1").' '.strtolower($type); ?>
								</a><br>
							<?php endif; ?>
							<?php if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_2") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=2'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_2").' '.strtolower($type); ?>
								</a><br>
							<?php endif; ?>
							<?php if ( bsa_space($entry['space_id'], $entry['ad_model']."_contract_3") > 0 && bsa_space($entry['space_id'], 'status') == 'active' ): ?>
								<a href="<?php echo $form_url.(( strpos($form_url, '?') == TRUE ) ? '&' : '?').'oid='.$entry['id'].'&cid=3'; ?>">
									<?php echo bsa_get_trans('user_panel', 'renewal').' '.bsa_space($entry['space_id'], $entry['ad_model']."_contract_3").' '.strtolower($type); ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td class="bsaCenter" colspan="6">
					<a class="buyButton" href="<?php echo bsaFormURL(); ?>"><?php echo bsa_get_trans('user_panel', 'buy_ads'); ?></a>
				</td>
			</tr>
		<?php else: ?>
			<?php if ( is_user_logged_in() ): ?>
				<tr>
					<td class="bsaCenter" colspan="6">
						<a href="<?php echo bsaFormURL(); ?>"><?php echo bsa_get_trans('user_panel', 'first_purchase'); ?></a>
					</td>
				</tr>
			<?php else: ?>
				<tr>
					<td class="bsaCenter" colspan="6">
						<a href="<?php echo wp_login_url( bsaFormURL() ); ?>"><?php echo bsa_get_trans('user_panel', 'login_here'); ?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>
		</tbody>
	</table>
	<?php
	echo '</div>'; // end container
	?>
	<style>
		#bsaProPanelTable a {
			color: <?php echo bsa_get_opt('user_panel', 'link_color'); ?>;
		}
		#bsaProPanelTable .buyButton {
			background-color: <?php echo bsa_get_opt('user_panel', 'button_bg'); ?>;
			color: <?php echo bsa_get_opt('user_panel', 'button_color'); ?>;
		}
		#bsaProPanelTable .buyButton:hover {
			background-color: <?php echo bsa_get_opt('user_panel', 'button_color'); ?>;
			color: <?php echo bsa_get_opt('user_panel', 'button_bg'); ?>;
		}
		#bsaProPanelTable th {
			background-color: <?php echo bsa_get_opt('user_panel', 'head_bg'); ?>; color: <?php echo bsa_get_opt('user_panel', 'head_color'); ?>;
		}
		<?php if ( bsa_get_opt('user_panel', 'separator') != '' ): ?>
		#bsaProPanelTable th,
		#bsaProPanelTable tr {
			border-bottom: 1px solid <?php echo bsa_get_opt('user_panel', 'separator'); ?>;
		}
		<?php endif; ?>
	</style>
	<?php
	return ob_get_clean();
}

add_action( 'admin_bar_menu', 'ads_pro_bar_link', 999 );
function ads_pro_bar_link( $wp_admin_bar ) {
	if ( is_user_logged_in() && get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && is_multisite() && is_main_site() ||
		get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && !is_multisite() ||
		get_option('bsa_pro_plugin_'.'link_bar') != 'yes' && get_current_blog_id() != 1 && is_main_site(1) ) {
		$model = new BSA_PRO_Model();
		$get_free_ads = $model->getUserCol(get_current_user_id(), 'free_ads');
		$free_ads = ((bsa_role() == 'admin') ? null : '('. get_option('bsa_pro_plugin_trans_free_ads') .' ' . (($get_free_ads['free_ads'] > 0) ? $get_free_ads['free_ads'] : 0) . ')');
		$link = ((bsa_role() == 'admin') ? 'admin.php?page=bsa-pro-sub-menu' : 'admin.php?page=bsa-pro-sub-menu-users');
		$args = array(
			'id'    => 'ads_pro_bar_link',
			'title' => '<img src="'.plugins_url('../frontend/img/bsa-icon.png', __FILE__).'" alt="" style="width:16px;display:inline-block;"> ADS PRO ' . $free_ads,
			'href'  => get_admin_url(1).$link,
			'meta'  => array( 'class' => 'ads_pro_bar_link' ),
			'icon'  => plugins_url('../frontend/img/bsa-icon.png', __FILE__)
		);
		if ( is_user_logged_in() && $get_free_ads['free_ads'] >= 0 or bsa_role() == 'admin') {
			$wp_admin_bar->add_node( $args );
		}
	}
}

add_action( 'bsa_cron_jobs','bsa_do_pending_tasks' );
function bsa_do_pending_tasks() { // CRON Function
	$cron = new BSA_PRO_Model();
	$cron->doCronTasks();
}

// Re-create Custom Ad Templates
add_action( 'bsa_cron_recreate_templates','bsa_cron_recreate_task' );
function bsa_cron_recreate_task() { // CRON Function
	bsaCreateCustomAdTemplates();
}

add_action( 'bsa_cron_job_views_stats','bsa_function_views_stats' );
function bsa_function_views_stats() {
	$model = new BSA_PRO_Model();
	$get_views_counter = get_option('bsa_pro_plugin_dashboard_views');
	$yesterday = strtotime(date('Y-m-d', time() - (24 * 60 * 60)));
	$get_daily_counter = $model->getDailyViews($yesterday);

	if ( $get_daily_counter[0] > 0 ) {
		update_option('bsa_pro_plugin_dashboard_views', ($get_views_counter + $get_daily_counter[0])); // increase views stats
	}

	wp_schedule_single_event( time() + (24 * 60 * 60), 'bsa_cron_job_views_stats' );
}

//// do action
//do_action('bsa_pro_action', 'test argument');
//
//// add action
//add_action( 'bsa_pro_action', 'testBsaProAction' );
//function testBsaProAction($test) {
//	if ( $test != null ) {
//		echo "TEST ADS PRO ACTION" . " " . $test;
//	} else {
//		echo "TEST ADS PRO ACTION!";
//	}
//}
