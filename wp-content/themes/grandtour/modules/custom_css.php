<?php 
header('Content-type: text/css');

$pp_advance_combine_css = get_option('pp_advance_combine_css');

if(!empty($pp_advance_combine_css))
{
	//Function for compressing the CSS as tightly as possible
	function grandtour_compress($buffer) {
	    //Remove CSS comments
	    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	    //Remove tabs, spaces, newlines, etc.
	    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	    return $buffer;
	}

	//This GZIPs the CSS for transmission to the user
	//making file size smaller and transfer rate quicker
	ob_start("ob_gzhandler");
	ob_start("grandtour_compress");
}
?>

<?php
if(empty($pp_animation))
{
	for($i=1;$i<=50;$i++)
	{
?>
.animated<?php echo intval($i); ?>
{
	-webkit-animation-delay: <?php echo floatval($i/10); ?>s;
	-moz-animation-delay: <?php echo floatval($i/10); ?>s;
	animation-delay: <?php echo floatval($i/10); ?>s;
}
<?php
	}
}
?>

<?php
	//Check if hide portfolio navigation
	$pp_portfolio_single_nav = get_option('pp_portfolio_single_nav');
	if(empty($pp_portfolio_single_nav))
	{
?>
.portfolio_nav { display:none; }
<?php
	}
?>
<?php
	$tg_fixed_menu = kirki_get_option('tg_fixed_menu');
	
	if(!empty($tg_fixed_menu))
	{
		//Check if Wordpress admin bar is enabled
		$menu_top_value = 0;
		if(is_admin_bar_showing())
		{
			$menu_top_value = 30;
		}
?>
.top_bar.fixed
{
	position: fixed;
	animation-name: slideDown;
	-webkit-animation-name: slideDown;	
	animation-duration: 0.5s;	
	-webkit-animation-duration: 0.5s;
	z-index: 999;
	visibility: visible !important;
	top: <?php echo intval($menu_top_value); ?>px;
}

<?php
	$pp_menu_font = get_option('pp_menu_font');
	$pp_menu_font_diff = 16-$pp_menu_font;
?>
.top_bar.fixed #menu_wrapper div .nav
{
	margin-top: <?php echo intval($pp_menu_font_diff); ?>px;
}

.top_bar.fixed #searchform
{
	margin-top: <?php echo intval($pp_menu_font_diff-8); ?>px;
}

.top_bar.fixed .header_cart_wrapper
{
	margin-top: <?php echo intval($pp_menu_font_diff+5); ?>px;
}

.top_bar.fixed #menu_wrapper div .nav > li > a
{
	padding-bottom: 24px;
}

.top_bar.fixed .logo_wrapper img
{
	max-height: 40px;
	width: auto;
}
<?php
	}
	
	//Hack animation CSS for Safari
	$current_browser = grandtour_get_browser();

	if(isset($current_browser['name']) && $current_browser['name'] == 'Internet Explorer')
	{
?>
#wrapper
{
	overflow-x: hidden;
}
.mobile_menu_wrapper
{
    overflow: auto;
}
body.js_nav .mobile_menu_wrapper 
{
    display: block;
}
.gallery_type, .portfolio_type
{
	opacity: 1;
}
#searchform input[type=text]
{
	width: 75%;
}
.woocommerce .logo_wrapper img
{
	max-width: 50%;
}
<?php
	}
?>

<?php
	$tg_menu_layout = grandtour_menu_layout();
	$tg_sidemenu = kirki_get_option('tg_sidemenu');
	
	if(empty($tg_sidemenu) && $tg_menu_layout != 'hammenufull')
	{
?>
#mobile_nav_icon
{
    display: none;
}
<?php
	}
?>
<?php
if(GRANDTOUR_THEMEDEMO)
{
?>
#option_btn
{
	position: fixed;
	top: 150px;
	right: -2px;
	cursor:pointer;
	z-index: 9;
	background: #fff;
	border-right: 0;
	width: 40px;
	height: 155px;
	padding: 10px 0 10px 0;
	text-align: center;
	border-radius: 5px 0px 0px 5px;
	box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
	line-height: 1.4;
	
	-webkit-transform: translate(0px, 0px);
	-moz-transform: translate(0px, 0px);
	transform: translate(0px, 0px);
	
	-webkit-transition: -webkit-transform 600ms ease;
	-moz-transition: transform 600ms ease;
	-o-transition: -o-transform 600ms ease;
	transition: transform 600ms ease;
}

#option_btn.open
{
	-webkit-transform: translate(-351px, 0px);
	-moz-transform: translate(-351px, 0px);
	transform: translate(-351px, 0px);
}

#option_btn span
{
	font-size: 15px;
	line-height: 31px;
	color: #222;
}

#option_wrapper
{
	position: fixed;
	top: 0;
	right: 0;
	width: 350px;
	background: #fff;
	z-index: 99999;
	box-shadow: -1px 1px 10px rgba(0, 0, 0, 0.1);
	overflow: auto;
	height: 100%;
	color: #222;
	line-height: 1.5;
    font-size: 14px;
    
    -webkit-transform: translate(351px, 0px);
	-moz-transform: translate(351px, 0px);
	transform: translate(351px, 0px);
	
	-webkit-transition: -webkit-transform 600ms ease;
	-moz-transition: transform 600ms ease;
	-o-transition: -o-transform 600ms ease;
	transition: transform 600ms ease;
}

#option_wrapper.open
{
	-webkit-transform: translate(0px, 0px);
	-moz-transform: translate(0px, 0px);
	transform: translate(0px, 0px);
}

#option_wrapper:hover
{
	overflow-y: auto;
}

#option_wrapper h6.demo_title
{
	font-size: 15px;
	font-weight: 600;
	letter-spacing: 0;
}

.demo_color_list
{
	list-style: none;
	display: block;
	margin: 30px 0 10px 0;
}

.demo_color_list > li
{
	display: inline-block;
	position: relative;
	width: 11%;
	height: auto;
	overflow: hidden;
	cursor: pointer;
	padding: 0;
	box-sizing: border-box;
	text-align: center;
	font-size: 11px;
	margin-bottom: 15px;
}

.demo_color_list > li .item_content_wrapper
{1
	width: 100%;
}

.demo_color_list > li .item_content_wrapper .item_content
{
	width: 100%;
	box-sizing: border-box;
}

.demo_color_list > li .item_content_wrapper .item_content .item_thumb
{
	width: 30px;
	height: 30px;
	position: relative;
	line-height: 0;
	border-radius: 250px;
	margin: auto;
}

.demo_list
{
	list-style: none;
	display: block;
	margin: 30px 0 20px 0;
	float: left;
}

.demo_list li
{
	display: block;
	float: left;
	position: relative;
	margin-bottom: 15px;
	margin-right: 14px;
	width: calc(50% - 7px);
	overflow: hidden;
	line-height: 0;
}

.demo_list li:nth-child(2n)
{
	margin-right: 0;
}

.demo_list li img
{
	max-width: 100%;
	height: auto;
	line-height: 0;
}

.demo_list li:hover img
{
	-webkit-transition: all 0.2s ease-in-out;
	-moz-transition: all 0.2s ease-in-out;
	-o-transition: all 0.2s ease-in-out;
	-ms-transition: all 0.2s ease-in-out;
	transition: all 0.2s ease-in-out;
	-webkit-filter: blur(2px);
	filter: blur(2px);
	-moz-filter: blur(2px);
}

.demo_list li:hover .demo_thumb_hover_wrapper 
{
	opacity: 1;
}

.demo_thumb_hover_wrapper 
{
	background-color: rgba(0, 0, 0, 0.5);
	height: 100%;
	left: 0;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	top: 0;
	transition: opacity 0.4s ease-in-out;
	-o-transition: opacity 0.4s ease-in-out;
	-ms-transition: opacity 0.4s ease-in-out;
	-moz-transition: opacity 0.4s ease-in-out;
	-webkit-transition: opacity 0.4s ease-in-out;
	visibility: visible;
	width: 100%;
	line-height: normal;
}

.demo_thumb_hover_inner
{
	display: table;
	height: 100%;
	width: 100%;
	text-align: center;
	vertical-align: middle;
}

.demo_thumb_desc
{
	display: table-cell;
	height: 100%;
	text-align: center;
	vertical-align: middle;
	width: 100%;
	padding: 0 10% 0 10%;
	box-sizing: border-box;
}

#option_wrapper .inner h6
{
	margin: 10px 0 0 0;
}

.demo_thumb_hover_inner h6
{
	color: #fff !important;
	line-height: 20px;
	font-size: 12px;
	letter-spacing: 0;
}

.demo_thumb_desc .button.white
{
	margin-top: 10px;
	font-size: 12px !important;
}

.demo_thumb_desc .button.white:hover
{
	background: #fff !important;
	color: #000 !important;
	border-color: #fff !important;
}

#option_wrapper .inner
{
	padding: 25px 15px 0 15px;
	box-sizing: border-box;
}

body.admin-bar #option_wrapper .inner
{
	padding-top: 70px;
}

#option_wrapper .demo_desc
{
	box-sizing: border-box;
	margin-top: 10px;
	padding: 0 10px 0 10px;
	font-size: 12px;
	opacity: 0.7;
}

.demotip
{
	display: block;
}
<?php
}
?>

@media only screen and (max-width: 768px) {
	html[data-menu=leftmenu] .mobile_menu_wrapper
	{
		right: 0;
		left: initial;
		
		-webkit-transform: translate(360px, 0px);
		-ms-transform: translate(360px, 0px);
		transform: translate(360px, 0px);
		-o-transform: translate(360px, 0px);
	}
}

<?php
	$tg_full_arrow = kirki_get_option('tg_full_arrow');
	$tg_content_bg_color = kirki_get_option('tg_content_bg_color');
	$tg_h1_font_color = kirki_get_option('tg_h1_font_color');
	
	if(!empty($tg_full_arrow))
	{
?>
a#prevslide:before, a#nextslide:before
{
	font-family: "FontAwesome";
	font-size: 18px;
	line-height: 40px;
	display: block;
	content: '\f104';
	color: <?php echo esc_attr($tg_h1_font_color); ?>;
	margin-top: 0px;
	margin-left: -3px;
}
a#nextslide:before
{
	content: '\f105';
}
body.page-template-gallery a#prevslide, body.single-galleries a#prevslide
{ 
	z-index:9; cursor: pointer; display: block; position: fixed; top: 47%; padding: 0 20px 0 20px; width: initial; height: initial; 
	background: <?php echo esc_attr($tg_content_bg_color); ?>;
	-webkit-transition: .2s ease-in-out;
	-moz-transition: .2s ease-in-out;
	-o-transition: .2s ease-in-out;
	transition: .2s ease-in-out;
	width: 40px;
	height: 40px;
	box-sizing: border-box;
	-webkit-box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
    -moz-box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
    box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
	
	border-radius: 250px;
	opacity: 1 !important;
	box-sizing: border-box;
	left: -80px;
}

body.page-template-gallery:hover a#prevslide, body.single-galleries:hover a#prevslide
{
	left: 20px;
}

body.page-template-gallery a#nextslide, body.single-galleries a#nextslide
{ 
	z-index:9; cursor: pointer;  display: block; position: fixed; right: -80px; top: 47%; padding: 0 20px 0 20px; width: initial; height: initial; 
	background: <?php echo esc_attr($tg_content_bg_color); ?>;
	-webkit-transition: .2s ease-in-out;
	-moz-transition: .2s ease-in-out;
	-o-transition: .2s ease-in-out;
	transition: .2s ease-in-out;
	width: 40px;
	height: 40px;
	box-sizing: border-box;
	-webkit-box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
    -moz-box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
    box-shadow: 0 8px 8px -6px rgba(0,0,0,.15);
	
	border-radius: 250px;
	opacity: 1 !important;
	box-sizing: border-box;
}

body.page-template-gallery:hover a#nextslide, body.single-galleries:hover a#nextslide
{
	right: 20px;
}
<?php
	}
?>

<?php
	//Check if enable b & w effect
	$tg_gallery_hover_bw = kirki_get_option('tg_gallery_hover_bw');
	
	if(!empty($tg_gallery_hover_bw))
	{
?>
.two_cols.gallery .element img, .three_cols.gallery .element img, .four_cols.gallery .element img, .five_cols.gallery .element img, .one_half.gallery2.classic a img, .one_third.gallery3.classic a img, .one_fourth.gallery4.classic a img
{
	-webkit-filter: grayscale(100%);
	filter: grayscale(100%);
}

.two_cols.gallery .element:hover img, .three_cols.gallery .element:hover img, .four_cols.gallery .element:hover img, .five_cols.gallery .element:hover img, .one_half.gallery2.classic a:hover img, .one_third.gallery3.classic a:hover img, .one_fourth.gallery4.classic a:hover img
{
	-webkit-filter: grayscale(0%);
	filter: grayscale(0%);
}
<?php
	}
	
	if(GRANDTOUR_THEMEDEMO)
	{
?>
body.postid-6282 .three_cols.gallery .element img, body.page-id-6352 .three_cols.gallery .element img
{
	-webkit-filter: grayscale(100%);
	filter: grayscale(100%);
}
body.postid-6282 .three_cols.gallery .element a:hover img, body.page-id-6352 .three_cols.gallery .element a:hover img
{
	-webkit-filter: grayscale(0%);
	filter: grayscale(0%);
}
<?php
	}
?>

<?php
	$tg_sidemenu_font_size = kirki_get_option('tg_sidemenu_font_size');
	
	if(!empty($tg_sidemenu_font_size))
	{
?>
#sub_menu .sub-menu li a
{
	font-size: <?php echo intval($tg_sidemenu_font_size-2); ?>px;
	line-height: 2em;
}
<?php
	}
	
	if($tg_sidemenu_font_size > 30)
	{
?>
.mobile_main_nav li a
{
	line-height: 1.2em;
}
<?php
	}
?>

<?php
	$tg_sidemenu_bg = kirki_get_option('tg_sidemenu_bg');
	$tg_sidemenu_bg_opacity = kirki_get_option('tg_sidemenu_bg_opacity');
	$tg_sidemenu_bg_opacity_value = $tg_sidemenu_bg_opacity/100;
	
	if(!empty($tg_sidemenu_bg))
	{
		$tg_sidemenu_bg_arr = grandtour_hex_to_rgb($tg_sidemenu_bg);
?>
body .mobile_menu_wrapper
{
	background: rgba(<?php echo esc_attr($tg_sidemenu_bg_arr['r']); ?>, <?php echo esc_attr($tg_sidemenu_bg_arr['g']); ?>, <?php echo esc_attr($tg_sidemenu_bg_arr['b']); ?>, <?php echo esc_attr($tg_sidemenu_bg_opacity_value); ?>);
}
<?php
	}	
?>

<?php
	$tg_menu_layout = grandtour_menu_layout();
	$tg_sidemenu_align = kirki_get_option('tg_sidemenu_align');
	
	if($tg_sidemenu_align == 'right' && $tg_menu_layout != 'hammenufull')
	{
?>
.mobile_menu_wrapper
{
	right: -10px;
	left: auto;
	-webkit-transform: translate(100%, 0px);
	-moz-transform: translate(100%, 0px);
	transform: translate(100%, 0px);
}

body.js_nav .mobile_menu_wrapper, html[data-menu=leftmenu] body.js_nav .mobile_menu_wrapper
{
	-webkit-transform: translate(calc(100% - 360px), 0px);
	-ms-transform: translate(calc(100% - 360px), 0px);
	transform: translate(calc(100% - 360px), 0px);
	right: 0;
	left: auto;
}

@media only screen and (max-width: 767px) {
	body.js_nav .mobile_menu_wrapper, html[data-menu=leftmenu] body.js_nav .mobile_menu_wrapper
	{
		-webkit-transform: translate(calc(100% - 270px), 0px);
		-ms-transform: translate(calc(100% - 270px), 0px);
		transform: translate(calc(100% - 270px), 0px);
	}
}
<?php
	}
	elseif($tg_menu_layout == 'hammenufull')
	{
?>
body.js_nav #side_menu_wrapper
{
	display: none;
}
<?php
	}
?>

<?php
	//Check if smart sticky menu
	$tg_smart_fixed_menu = kirki_get_option('tg_smart_fixed_menu');
	
	if(!empty($tg_smart_fixed_menu))
	{
?>
@media only screen and (min-width: 960px)
{
	.top_bar.scroll
	{
		-webkit-transform: translateY(-100px);
	    -moz-transform: translateY(-100px);
	    -o-transform: translateY(-100px);
	    -ms-transform: translateY(-100px);
	    transform: translateY(-100px);
	    opacity: 0;
	}
	.top_bar.scroll.scroll_up
	{
		-webkit-transform: translateY(00px);
	    -moz-transform: translateY(0px);
	    -o-transform: translateY(0px);
	    -ms-transform: translateY(0px);
	    transform: translateY(0px);
	    opacity: 1;
	}
	.header_style_wrapper
	{
	    -webkit-transition: opacity 0.5s;
	    -moz-transition: opacity 0.5s;
	    transition: opacity 0.5s;
	}
	.header_style_wrapper.scroll_down
	{
		opacity: 0;
		z-index: 0;
	}
	
	.header_style_wrapper.scroll_up
	{
		opacity: 1;
	}
	
	body.page-template-gallery-archive-fullscreen-php .header_style_wrapper.scroll_down, 
	body.page-template-gallery-archive-fullscreen-php .header_style_wrapper.scroll_down .top_bar.scroll, 
	body.page-template-gallery-archive-split-screen-php .header_style_wrapper.scroll_down, 
	body.page-template-gallery-archive-split-screen-php .header_style_wrapper.scroll_down .top_bar.scroll,
	body.page-template-portfolio-fullscreen-php .header_style_wrapper.scroll_down, 
	body.page-template-portfolio-fullscreen-php .header_style_wrapper.scroll_down .top_bar.scroll, 
	body.page-template-portfolio-fullscreen-split-screen-php .header_style_wrapper.scroll_down, 
	body.page-template-portfolio-fullscreen-split-screen-php .header_style_wrapper.scroll_down .top_bar.scroll
	{
		opacity: 1 !important;
	}
	
	body.page-template-gallery-archive-fullscreen-php .header_style_wrapper.scroll_down .top_bar.scroll,
	body.page-template-gallery-archive-split-screen-php .header_style_wrapper.scroll_down .top_bar.scroll,
	body.page-template-portfolio-fullscreen-php .header_style_wrapper.scroll_down .top_bar.scroll,
	body.page-template-portfolio-fullscreen-split-screen-php .header_style_wrapper.scroll_down .top_bar.scroll
	{
		-webkit-transform: translateY(00px);
	    -moz-transform: translateY(0px);
	    -o-transform: translateY(0px);
	    -ms-transform: translateY(0px);
	    transform: translateY(0px);
	}
	
	body.page-template-gallery-archive-fullscreen-php .header_style_wrapper.nofixed,
	body.page-template-gallery-archive-split-screen-php .header_style_wrapper.nofixed,
	body.page-template-portfolio-fullscreen-php .header_style_wrapper.nofixed,
	body.page-template-portfolio-fullscreen-split-screen-php .header_style_wrapper.nofixed
	{
		display: block;
	}
}
<?php
	}
?>

<?php
	//Get main menu layout
	$tg_menu_layout = grandtour_menu_layout();
	
	if($tg_menu_layout == 'centeralogo')
	{
		$logo_margin_left = 46;
		
		//get custom logo
    	$tg_retina_logo = kirki_get_option('tg_retina_logo');

    	if(!empty($tg_retina_logo))
    	{
    		//Get image width and height
		    $image_id = grandtour_get_image_id($tg_retina_logo);
		    
		    if(!empty($image_id))
		    {
		        $obj_image = wp_get_attachment_image_src($image_id, 'original');
		        
		        $image_width = 0;
			    
			    if(isset($obj_image[1]))
			    {
			    	$image_width = intval($obj_image[1]/2);
			    }
			    
			    $logo_margin_left = intval($image_width/2);
		    }
    	}
?>
@media only screen and (min-width: 960px)
{
	#logo_normal.logo_container
	{
		margin-left: -<?php echo intval($logo_margin_left); ?>px;
	}
<?php
		//get custom logo
    	$tg_retina_transparent_logo = kirki_get_option('tg_retina_transparent_logo');

    	if(!empty($tg_retina_transparent_logo))
    	{
    		//Get image width and height
		    $image_id = grandtour_get_image_id($tg_retina_transparent_logo);
		    
		    if(!empty($image_id))
		    {
		        $obj_image = wp_get_attachment_image_src($image_id, 'original');
		        
		        $image_width = 0;
			    
			    if(isset($obj_image[1]))
			    {
			    	$image_width = intval($obj_image[1]/2);
			    }
			    
			    $logo_margin_left = intval($image_width/2);
		    }
    	}
?>
	#logo_transparent.logo_container
	{
		margin-left: -<?php echo intval($logo_margin_left); ?>px;
	}
}
<?php
	$tg_topbar = kirki_get_option('tg_topbar');
	
	if(!empty($tg_topbar))
	{
?>
@media only screen and (min-width: 960px)
{
	.top_bar.scroll .logo_container
	{
		top: 15px;
	}
	
	.top_bar .logo_container, .top_bar.scroll_up:not(.scroll) .logo_container
	{
		top: 45px;
	}
}
@media only screen and (max-width: 767px) {
	.top_bar .logo_container
	{
		top: 45px;
	}
}
<?php
	}
?>

<?php
	}
	
	$tg_boxed_bg_image = kirki_get_option('tg_boxed_bg_image');
	if(!empty($tg_boxed_bg_image))
	{
?>
body.tg_boxed
{
	background-image: url('<?php echo esc_url($tg_boxed_bg_image); ?>');
}
<?php
	}
	
	if(GRANDTOUR_THEMEDEMO)
    {
	    $tg_button_bg_color = kirki_get_option('tg_button_bg_color');
?>
.frame_top, .frame_bottom, .frame_left, .frame_right
{
	background: <?php echo esc_attr($tg_button_bg_color); ?>;
}
<?php   
	}
?>

<?php
	$tg_tour_recently_view = kirki_get_option('tg_tour_recently_view');
	
	if(!empty($tg_tour_recently_view))
	{
?>
#footer
{
	margin-top: 0;
}
<?php
	}
?>

<?php
	//Check page title vertical alignment
	$tg_page_title_vertical_alignment = kirki_get_option('tg_page_title_vertical_alignment');
	if($tg_page_title_vertical_alignment == 'center')
	{
?>
#page_caption.hasbg .page_title_wrapper
{
	height: 100%;
	bottom: 0;
	position: relative;
}

#page_caption.hasbg .page_title_wrapper .standard_wrapper
{
	width: 100%;
	height: 100%;
}

#page_caption.hasbg .page_title_wrapper .page_title_inner
{
	width: 100%;
	height: 100%;
	display: table;
}

#page_caption.hasbg .page_title_wrapper .page_title_inner .page_title_content
{
	display: table-cell;
	vertical-align: middle;
}

#page_caption.hasbg:after
{
	display: none;
}
<?php
	}
?>

<?php
/**
*	Get custom CSS for Desktop View
**/
$pp_custom_css = get_option('pp_custom_css');


if(!empty($pp_custom_css))
{
    echo stripslashes($pp_custom_css);
}
?>

<?php
/**
*	Get custom CSS for iPad Portrait View
**/
$pp_custom_css_tablet_portrait = get_option('pp_custom_css_tablet_portrait');


if(!empty($pp_custom_css_tablet_portrait))
{
?>
@media only screen and (min-width: 768px) and (max-width: 959px) {
<?php
    echo stripslashes($pp_custom_css_tablet_portrait);
?>
}
<?php
}
?>

<?php
/**
*	Get custom CSS for iPhone Portrait View
**/
$pp_custom_css_mobile_portrait = get_option('pp_custom_css_mobile_portrait');


if(!empty($pp_custom_css_mobile_portrait))
{
?>
@media only screen and (max-width: 767px) {
<?php
    echo stripslashes($pp_custom_css_mobile_portrait);
?>
}
<?php
}
?>

<?php
/**
*	Get custom CSS for iPhone Landscape View
**/
$pp_custom_css_mobile_landscape = get_option('pp_custom_css_mobile_landscape');


if(!empty($pp_custom_css_tablet_portrait))
{
?>
@media only screen and (min-width: 480px) and (max-width: 767px) {
<?php
    echo stripslashes($pp_custom_css_mobile_landscape);
?>
}
<?php
}
?>

<?php
if(!empty($pp_advance_combine_css))
{
	ob_end_flush();
	ob_end_flush();
}
?>
