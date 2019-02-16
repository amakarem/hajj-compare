<?php
//Setup theme constant and default data
$theme_obj = wp_get_theme('grandtour');

define("GRANDTOUR_THEMENAME", $theme_obj['Name']);
define("GRANDTOUR_THEMEDEMO", false);
define("GRANDTOUR_THEMEDEMOIG", 'kinfolklifestyle');
define("GRANDTOUR_SHORTNAME", "pp");
define("GRANDTOUR_THEMEVERSION", $theme_obj['Version']);
define("GRANDTOUR_THEMEDEMOURL", $theme_obj['ThemeURI']);
define("GRANDTOUR_THEMEDATEFORMAT", get_option('date_format'));
define("GRANDTOUR_THEMETIMEFORMAT", get_option('time_format'));
define("ENVATOITEMID", 19264426);
define("GRANDTOUR_BUILDERDOCURL", 'http://themes.themegoods.com/grandtour/doc/create-a-page-using-content-builder-2/');

//Get default WP uploads folder
$wp_upload_arr = wp_upload_dir();
define("GRANDTOUR_THEMEUPLOAD", $wp_upload_arr['basedir']."/".strtolower(sanitize_title(GRANDTOUR_THEMENAME))."/");
define("GRANDTOUR_THEMEUPLOADURL", $wp_upload_arr['baseurl']."/".strtolower(sanitize_title(GRANDTOUR_THEMENAME))."/");

if(!is_dir(GRANDTOUR_THEMEUPLOAD))
{
	wp_mkdir_p(GRANDTOUR_THEMEUPLOAD);
}

/**
*  Begin Global variables functions
*/

//Get default WordPress post variable
function grandtour_get_wp_post() {
	global $post;
	return $post;
}

//Get default WordPress file system variable
function grandtour_get_wp_filesystem() {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	WP_Filesystem();
	global $wp_filesystem;
	return $wp_filesystem;
}

//Get default WordPress wpdb variable
function grandtour_get_wpdb() {
	global $wpdb;
	return $wpdb;
}

//Get default WordPress wp_query variable
function grandtour_get_wp_query() {
	global $wp_query;
	return $wp_query;
}

//Get default WordPress customize variable
function grandtour_get_wp_customize() {
	global $wp_customize;
	return $wp_customize;
}

//Get default WordPress current screen variable
function grandtour_get_current_screen() {
	global $current_screen;
	return $current_screen;
}

//Get default WordPress paged variable
function grandtour_get_paged() {
	global $paged;
	return $paged;
}

//Get default WordPress registered widgets variable
function grandtour_get_registered_widget_controls() {
	global $wp_registered_widget_controls;
	return $wp_registered_widget_controls;
}

//Get default WordPress registered sidebars variable
function grandtour_get_registered_sidebars() {
	global $wp_registered_sidebars;
	return $wp_registered_sidebars;
}

//Get default Woocommerce variable
function grandtour_get_woocommerce() {
	global $woocommerce;
	return $woocommerce;
}

//Get all google font usages in customizer
function grandtour_get_google_fonts() {
	$grandtour_google_fonts = array('tg_body_font', 'tg_header_font', 'tg_menu_font', 'tg_sidemenu_font', 'tg_sidebar_title_font', 'tg_button_font');
	
	global $grandtour_google_fonts;
	return $grandtour_google_fonts;
}

//Get menu transparent variable
function grandtour_get_page_menu_transparent() {
	global $grandtour_page_menu_transparent;
	return $grandtour_page_menu_transparent;
}

//Set menu transparent variable
function grandtour_set_page_menu_transparent($new_value = '') {
	global $grandtour_page_menu_transparent;
	$grandtour_page_menu_transparent = $new_value;
}

//Get no header checker variable
function grandtour_get_is_no_header() {
	global $grandtour_is_no_header;
	return $grandtour_is_no_header;
}

//Get deafult theme screen CSS class
function grandtour_get_screen_class() {
	global $grandtour_screen_class;
	return $grandtour_screen_class;
}

//Set deafult theme screen CSS class
function grandtour_set_screen_class($new_value = '') {
	global $grandtour_screen_class;
	$grandtour_screen_class = $new_value;
}

//Get theme homepage style
function grandtour_get_homepage_style() {
	global $grandtour_homepage_style;
	return $grandtour_homepage_style;
}

//Set theme homepage style
function grandtour_set_homepage_style($new_value = '') {
	global $grandtour_homepage_style;
	$grandtour_homepage_style = $new_value;
}

//Get page gallery ID
function grandtour_get_page_gallery_id() {
	global $grandtour_page_gallery_id;
	return $grandtour_page_gallery_id;
}

//Get default theme options variable
function grandtour_get_options() {
	global $grandtour_options;
	return $grandtour_options;
}

//Set default theme options variable
function grandtour_set_options($new_value = '') {
	global $grandtour_options;
	$grandtour_options = $new_value;
}

//Get top bar setting
function grandtour_get_topbar() {
	global $grandtour_topbar;
	return $grandtour_topbar;
}

//Set top bar setting
function grandtour_set_topbar($new_value = '') {
	global $grandtour_topbar;
	$grandtour_topbar = $new_value;
}

//Get is hide title option
function grandtour_get_hide_title() {
	global $grandtour_hide_title;
	return $grandtour_hide_title;
}

//Set is hide title option
function grandtour_set_hide_title($new_value = '') {
	global $grandtour_hide_title;
	$grandtour_hide_title = $new_value;
}

//Get theme page content CSS class
function grandtour_get_page_content_class() {
	global $grandtour_page_content_class;
	return $grandtour_page_content_class;
}

//Set theme page content CSS class
function grandtour_set_page_content_class($new_value = '') {
	global $grandtour_page_content_class;
	$grandtour_page_content_class = $new_value;
}

//Get Kirki global variable
function grandtour_get_kirki() {
	global $kirki;
	return $kirki;
}

//Get admin theme global variable
function grandtour_get_wp_admin_css_colors() {
	global $_wp_admin_css_colors;
	return $_wp_admin_css_colors;
}

//Get theme plugins
function grandtour_get_plugins() {
	global $grandtour_tgm_plugins;
	return $grandtour_tgm_plugins;
}

//Set theme plugins
function grandtour_set_plugins($new_value = '') {
	global $grandtour_tgm_plugins;
	$grandtour_tgm_plugins = $new_value;
}

function grandtour_get_months() {
	$available_months = array(
		"january" 	=> esc_html__('January', 'grandtour' ),
		"february" 	=> esc_html__('February', 'grandtour' ),
		"march" 	=> esc_html__('March', 'grandtour' ),
		"april" 	=> esc_html__('April', 'grandtour' ),
		"may" 		=> esc_html__('May', 'grandtour' ),
		"june" 		=> esc_html__('June', 'grandtour' ),
		"july" 		=> esc_html__('July', 'grandtour' ),
		"august" 	=> esc_html__('August', 'grandtour' ),
		"september" => esc_html__('September', 'grandtour' ),
		"october" 	=> esc_html__('October', 'grandtour' ),
		"november" 	=> esc_html__('November', 'grandtour' ),
		"december" 	=> esc_html__('December', 'grandtour' ),
	);
	
	return $available_months;
}

function grandtour_get_sort_options() {
	$sort_options = array(
		"date" 			=> esc_html__('Sort By Date', 'grandtour' ),
		"price_low" 	=> esc_html__('Price Low to High', 'grandtour' ),
		"price_high" 	=> esc_html__('Price High to Low', 'grandtour' ),
		"name" 			=> esc_html__('Sort By Name', 'grandtour' ),
		"popular" 		=> esc_html__('Sort By Popularity', 'grandtour' ),
		"review" 		=> esc_html__('Sort By Review Score', 'grandtour' ),
	);
	
	return $sort_options;
}

function grandtour_get_days() {
	$available_days = array(
		"monday" 		=> esc_html__('Monday', 'grandtour' ),
		"tuesday" 		=> esc_html__('Tuesday', 'grandtour' ),
		"wednesday" 	=> esc_html__('Wednesday', 'grandtour' ),
		"thursday" 		=> esc_html__('Thursday', 'grandtour' ),
		"friday" 		=> esc_html__('Friday', 'grandtour' ),
		"saturday" 		=> esc_html__('Saturday', 'grandtour' ),
		"sunday" 		=> esc_html__('Sunday', 'grandtour' ),
	);
	
	return $available_days;
}

//Get page custom fields values
function grandtour_get_page_postmetas() {
	//Get all sidebars
	$theme_sidebar = array(
		'' => '',
		'Page Sidebar' => 'Page Sidebar', 
		'Contact Sidebar' => 'Contact Sidebar', 
		'Blog Sidebar' => 'Blog Sidebar',
	);
	
	$dynamic_sidebar = get_option('pp_sidebar');
	
	if(!empty($dynamic_sidebar))
	{
		foreach($dynamic_sidebar as $sidebar)
		{
			$theme_sidebar[$sidebar] = $sidebar;
		}
	}
	
	/*
		Get gallery list
	*/
	$args = array(
	    'numberposts' => -1,
	    'post_type' => array('galleries'),
	);
	
	$galleries_arr = get_posts($args);
	$galleries_select = array();
	$galleries_select['(Display Post Featured Image)'] = '';
	
	foreach($galleries_arr as $gallery)
	{
		$galleries_select[$gallery->ID] = $gallery->post_title;
	}
	
	/*
		Get page templates list
	*/
	if(function_exists('get_page_templates'))
	{
		$page_templates = get_page_templates();
		$page_templates_select = array();
		$page_key = 1;
		
		foreach ($page_templates as $template_name => $template_filename) 
		{
			$page_templates_select[$template_name] = get_template_directory_uri()."/functions/images/page/".basename($template_filename, '.php').".png";
			$page_key++;
		}
	}
	else
	{
		$page_templates_select = array();
	}
	
	/*
		Get all menus available
	*/
	$menus = get_terms('nav_menu');
	$menus_select = array(
		 '' => 'Default Menu'
	);
	foreach($menus as $each_menu)
	{
		$menus_select[$each_menu->slug] = $each_menu->name;
	}
	
	$grandtour_page_postmetas = array();
	$pp_menu_layout = get_option('pp_menu_layout');
		
	if($pp_menu_layout != 'leftmenu')
	{
	    $grandtour_page_postmetas[99] = array("section" => "Page Menu", "id" => "page_menu_transparent", "type" => "checkbox", "title" => "Make Menu Transparent", "description" => "Check this option if you want to display main menu in transparent");
	}
	
	$grandtour_page_postmetas_extended = 
		array (
			/*
				Begin Page custom fields
			*/
			array("section" => esc_html__('Page Template', 'grandtour' ), "id" => "page_custom_template", "type" => "template", "title" => esc_html__('Page Template', 'grandtour' ), "description" => esc_html__('Select template for this page', 'grandtour' ), "items" => $page_templates_select),
			
			array("section" => esc_html__('Page Title', 'grandtour' ), "id" => "page_show_title", "type" => "checkbox", "title" => esc_html__('Hide Default Page Header', 'grandtour' ), "description" => esc_html__('Check this option if you want to hide default page header', 'grandtour' )),
			
			array("section" => esc_html__('Page Tagline', 'grandtour' ), "id" => "page_tagline", "type" => "textarea", "title" => esc_html__('Page Tagline (Optional)', 'grandtour' ), "description" => esc_html__('Enter page tagline. It will displays under page title (*Note: HTML code also support)', 'grandtour' )),
			
			array(
    			"section" 		=> esc_html__('Page Attributes', 'grandtour' ), 
    			"id" 			=> "page_header_type", 
    			"type" 			=> "select", 
    			"title" 		=> esc_html__('Header Content Type', 'grandtour' ), 
    			"description" 	=> esc_html__('Select header content type for this page.', 'grandtour' ), 
				"items" 		=> array(
					"Image" => "Featured Image",
					"Vimeo Video" => "Vimeo Video",
					"Youtube Video" => "Youtube Video",
			)),
				
			array(
				"section" 		=> esc_html__('Page Attributes', 'grandtour' ), 
				"id" 			=> "page_header_vimeo", 
				"type" 			=> "text", 
				"title" 		=> esc_html__('Vimeo Video ID (Optional)', 'grandtour' ), 
				"description" 	=> esc_html__('Please enter Vimeo Video ID for example 73317780', 'grandtour' )
			),
			
			array(
				"section" 		=> esc_html__('Page Attributes', 'grandtour' ), 
				"id" 			=> "page_header_youtube", 
				"type" 			=> "text", 
				"title" 		=> esc_html__('Youtube Video ID (Optional)', 'grandtour' ), 
				"description" 	=> esc_html__('Please enter Youtube Video ID for example 6AIdXisPqHc', 'grandtour' )
			),
			
			array("section" => esc_html__('Select Sidebar (Optional)', 'grandtour' ), "id" => "page_sidebar", "type" => "select", "title" => esc_html__('Page Sidebar (Optional)', 'grandtour' ), "description" => esc_html__('Select this page sidebar to display. To use this option, you have to select page template end with "Sidebar" only', 'grandtour' ), "items" => $theme_sidebar),
			
			array("section" => esc_html__('Select Menu', 'grandtour' ), "id" => "page_menu", "type" => "select", "title" => esc_html__('Page Menu (Optional)', 'grandtour' ), "description" => esc_html__('Select this page menu if you want to display main menu other than default one', 'grandtour' ), "items" => $menus_select),
		);
	
	
	$grandtour_page_postmetas = $grandtour_page_postmetas + $grandtour_page_postmetas_extended;
		
	return $grandtour_page_postmetas;
}
?>
