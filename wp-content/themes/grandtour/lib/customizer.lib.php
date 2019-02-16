<?php
/**
* Custom Sanitize Functions
**/
function grandtour_sanitize_checkbox( $input ) {
	if(is_bool($input))
	{
		return $input;
	}
	else
	{
		return false;
	}

}

function grandtour_sanitize_slider( $input ) {	if(is_numeric($input))
	{
		return $input;
	}
	else
	{
		return 0;

	}
}

function grandtour_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/*** Configuration to disable default Wordpress customizer tabs
**/

add_action( 'customize_register', 'grandtour_customize_register' );
function grandtour_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
}

/**
 * Configuration sample for the Kirki Customizer
 */
function grandtour_demo_configuration_sample() {

    /**
     * If you need to include Kirki in your theme,
     * then you may want to consider adding the translations here
     * using your textdomain.
     * 
     * If you're using Kirki as a plugin then you can remove these.
     */

    $strings = array(
        'background-color' => esc_html__('Background Color', 'grandtour' ),
        'background-image' => esc_html__('Background Image', 'grandtour' ),
        'no-repeat' => esc_html__('No Repeat', 'grandtour' ),
        'repeat-all' => esc_html__('Repeat All', 'grandtour' ),
        'repeat-x' => esc_html__('Repeat Horizontally', 'grandtour' ),
        'repeat-y' => esc_html__('Repeat Vertically', 'grandtour' ),
        'inherit' => esc_html__('Inherit', 'grandtour' ),
        'background-repeat' => esc_html__('Background Repeat', 'grandtour' ),
        'cover' => esc_html__('Cover', 'grandtour' ),
        'contain' => esc_html__('Contain', 'grandtour' ),
        'background-size' => esc_html__('Background Size', 'grandtour' ),
        'fixed' => esc_html__('Fixed', 'grandtour' ),
        'scroll' => esc_html__('Scroll', 'grandtour' ),
        'background-attachment' => esc_html__('Background Attachment', 'grandtour' ),
        'left-top' => esc_html__('Left Top', 'grandtour' ),
        'left-center' => esc_html__('Left Center', 'grandtour' ),
        'left-bottom' => esc_html__('Left Bottom', 'grandtour' ),
        'right-top' => esc_html__('Right Top', 'grandtour' ),
        'right-center' => esc_html__('Right Center', 'grandtour' ),
        'right-bottom' => esc_html__('Right Bottom', 'grandtour' ),
        'center-top' => esc_html__('Center Top', 'grandtour' ),
        'center-center' => esc_html__('Center Center', 'grandtour' ),
        'center-bottom' => esc_html__('Center Bottom', 'grandtour' ),
        'background-position' => esc_html__('Background Position', 'grandtour' ),
        'background-opacity' => esc_html__('Background Opacity', 'grandtour' ),
        'ON' => esc_html__('ON', 'grandtour' ),
        'OFF' => esc_html__('OFF', 'grandtour' ),
        'all' => esc_html__('All', 'grandtour' ),
        'cyrillic' => esc_html__('Cyrillic', 'grandtour' ),
        'cyrillic-ext' => esc_html__('Cyrillic Extended', 'grandtour' ),
        'devanagari' => esc_html__('Devanagari', 'grandtour' ),
        'greek' => esc_html__('Greek', 'grandtour' ),
        'greek-ext' => esc_html__('Greek Extended', 'grandtour' ),
        'khmer' => esc_html__('Khmer', 'grandtour' ),
        'latin' => esc_html__('Latin', 'grandtour' ),
        'latin-ext' => esc_html__('Latin Extended', 'grandtour' ),
        'vietnamese' => esc_html__('Vietnamese', 'grandtour' ),
    );

    $args = array(
        'textdomain'   => 'grandtour',
    );

    return $args;

}
add_filter( 'kirki/config', 'grandtour_demo_configuration_sample' );

/**
 * Create the customizer panels and sections
 */
function grandtour_add_panels_and_sections( $wp_customize ) {

	/**
     * Add panels
     */
    $wp_customize->add_panel( 'general', array(
        'priority'    => 35,
        'title'       => esc_html__('General', 'grandtour' ),
    ) ); 
    
    $wp_customize->add_panel( 'menu', array(
        'priority'    => 35,
        'title'       => esc_html__('Navigation', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'header', array(
        'priority'    => 39,
        'title'       => esc_html__('Header', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'sidebar', array(
        'priority'    => 43,
        'title'       => esc_html__('Sidebar', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'footer', array(
        'priority'    => 44,
        'title'       => esc_html__('Footer', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'gallery', array(
        'priority'    => 45,
        'title'       => esc_html__('Gallery', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'tour', array(
        'priority'    => 46,
        'title'       => esc_html__('Tour', 'grandtour' ),
    ) );
    
    $wp_customize->add_panel( 'blog', array(
        'priority'    => 47,
        'title'       => esc_html__('Blog', 'grandtour' ),
    ) );
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		$wp_customize->add_panel( 'shop', array(
	        'priority'    => 48,
	        'title'       => esc_html__('Shop', 'grandtour' ),
	    ) );
	}

    /**
     * Add sections
     */
	$wp_customize->add_section( 'logo_favicon', array(
        'title'       => esc_html__('Logo & Favicon', 'grandtour' ),
        'priority'    => 34,

    ) );
    
    $wp_customize->add_section( 'general_image', array(
        'title'       => esc_html__('Image', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 46,

    ) );
    
    $wp_customize->add_section( 'general_typography', array(
        'title'       => esc_html__('Typography', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 47,

    ) );
    
    $wp_customize->add_section( 'general_color', array(
        'title'       => esc_html__('Background & Colors', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 48,

    ) );
    
    $wp_customize->add_section( 'general_input', array(
        'title'       => esc_html__('Input and Button Elements', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 49,

    ) );
    
    $wp_customize->add_section( 'general_sharing', array(
        'title'       => esc_html__('Sharing', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 50,

    ) );
    
    $wp_customize->add_section( 'general_mobile', array(
        'title'       => esc_html__('Mobile', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 50,

    ) );
    
    $wp_customize->add_section( 'general_frame', array(
        'title'       => esc_html__('Frame', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 51,

    ) );
    
    $wp_customize->add_section( 'general_boxed', array(
        'title'       => esc_html__('Boxed Layout', 'grandtour' ),
        'panel'		  => 'general',
        'priority'    => 52,

    ) );

    $wp_customize->add_section( 'menu_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 36,

    ) );
    
    $wp_customize->add_section( 'menu_typography', array(
        'title'       => esc_html__('Typography', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 36,

    ) );
    
    $wp_customize->add_section( 'menu_color', array(
        'title'       => esc_html__('Colors', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 37,

    ) );
    
    $wp_customize->add_section( 'menu_submenu', array(
        'title'       => esc_html__('Sub Menu', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_megamenu', array(
        'title'       => esc_html__('Mega Menu', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_topbar', array(
        'title'       => esc_html__('Top Bar', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_contact', array(
        'title'       => esc_html__('Contact Info', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 39,

    ) );
    
    $wp_customize->add_section( 'menu_sidemenu', array(
        'title'       => esc_html__('Side Menu', 'grandtour' ),
        'panel'		  => 'menu',
        'priority'    => 39,

    ) );
    
    $wp_customize->add_section( 'header_background', array(
        'title'       => esc_html__('Background', 'grandtour' ),
        'panel'		  => 'header',
        'priority'    => 40,

    ) );
    
    $wp_customize->add_section( 'header_title', array(
        'title'       => esc_html__('Page Title', 'grandtour' ),
        'panel'		  => 'header',
        'priority'    => 41,

    ) );
    
    $wp_customize->add_section( 'header_builder_title', array(
        'title'       => esc_html__('Content Builder Header', 'grandtour' ),
        'panel'		  => 'header',
        'priority'    => 41,

    ) );
    
    $wp_customize->add_section( 'header_tagline', array(
        'title'       => esc_html__('Page Tagline & Sub Title', 'grandtour' ),
        'panel'		  => 'header',
        'priority'    => 42,

    ) );
    
    $wp_customize->add_section( 'sidebar_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'sidebar',
        'priority'    => 42,

    ) );
    
    $wp_customize->add_section( 'sidebar_typography', array(
        'title'       => esc_html__('Typography', 'grandtour' ),
        'panel'		  => 'sidebar',
        'priority'    => 43,

    ) );
    
    $wp_customize->add_section( 'sidebar_color', array(
        'title'       => esc_html__('Colors', 'grandtour' ),
        'panel'		  => 'sidebar',
        'priority'    => 44,

    ) );
    
    $wp_customize->add_section( 'footer_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'footer',
        'priority'    => 45,

    ) );
    
    $wp_customize->add_section( 'footer_color', array(
        'title'       => esc_html__('Colors', 'grandtour' ),
        'panel'		  => 'footer',
        'priority'    => 46,

    ) );
    
    $wp_customize->add_section( 'footer_copyright', array(
        'title'       => esc_html__('Copyright', 'grandtour' ),
        'panel'		  => 'footer',
        'priority'    => 47,

    ) );
    
    $wp_customize->add_section( 'gallery_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'gallery',
        'priority'    => 48,

    ) );
    
    $wp_customize->add_section( 'gallery_lightbox', array(
        'title'       => esc_html__('Lightbox', 'grandtour' ),
        'panel'		  => 'gallery',
        'priority'    => 49,

    ) );
    
    $wp_customize->add_section( 'tour_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'tour',
        'priority'    => 51,
    ) );
    
    $wp_customize->add_section( 'tour_single', array(
        'title'       => esc_html__('Single Tour Page', 'grandtour' ),
        'panel'		  => 'tour',
        'priority'    => 52,
    ) );
    
    $wp_customize->add_section( 'destination_single', array(
        'title'       => esc_html__('Single Destination Page', 'grandtour' ),
        'panel'		  => 'tour',
        'priority'    => 52,
    ) );
    
    $wp_customize->add_section( 'blog_general', array(
        'title'       => esc_html__('General', 'grandtour' ),
        'panel'		  => 'blog',
        'priority'    => 53,

    ) );
    
    $wp_customize->add_section( 'blog_slider', array(
        'title'       => esc_html__('Slider', 'grandtour' ),
        'panel'		  => 'blog',
        'priority'    => 54,

    ) );
    
    $wp_customize->add_section( 'blog_single', array(
        'title'       => esc_html__('Single Post', 'grandtour' ),
        'panel'		  => 'blog',
        'priority'    => 55,

    ) );
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		$wp_customize->add_section( 'shop_layout', array(
	        'title'       => esc_html__('Layout', 'grandtour' ),
	        'panel'		  => 'shop',
	        'priority'    => 55,
	
	    ) );
	    
	    $wp_customize->add_section( 'shop_single', array(
	        'title'       => esc_html__('Single Product', 'grandtour' ),
	        'panel'		  => 'shop',
	        'priority'    => 56,
	
	    ) );
	}

}
add_action( 'customize_register', 'grandtour_add_panels_and_sections' );

/**
 * Register and setting to header section
 */
function grandtour_header_setting( $wp_customize ) {

	//Register Logo Tab Settings
	$wp_customize->add_setting( 'tg_favicon', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );
	
    $wp_customize->add_setting( 'tg_retina_logo', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_setting( 'tg_retina_transparent_logo', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    //End Logo Tab Settings
    
    //Register General Tab Settings
    $wp_customize->add_setting( 'tg_enable_right_click', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_enable_dragging', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_body_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_body_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
	$wp_customize->add_setting( 'tg_header_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_header_font_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h1_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h2_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h3_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h4_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h5_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h6_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_content_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_hover_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_h1_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_hr_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_focus_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_button_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    //End General Tab Settings
    

    //Register Menu Tab Settings
    $wp_customize->add_setting( 'tg_menu_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_fixed_menu', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_padding', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_hover_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_active_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_hover_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_hover_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_megamenu_header_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_megamenu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_social_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_contact_hours', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_contact_number', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search_input_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_hover_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    //End Menu Tab Settings
    
    //Register Header Tab Settings
	$wp_customize->add_setting( 'tg_page_header_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_page_header_padding_top', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_header_padding_bottom', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_bg_height', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_header_builder_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_header_builder_font_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    //End Header Tab Settings
    
    //Register Copyright Tab Settings
    
    $wp_customize->add_setting( 'tg_footer_sidebar', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
	
	$wp_customize->add_setting( 'tg_footer_social_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
	$wp_customize->add_setting( 'tg_footer_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_hover_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_social_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_text', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_html',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_right_area', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_totop', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    //End Copyright Tab Settings
    
    
    //Begin Gallery Tab Settings
    $wp_customize->add_setting( 'tg_gallery_sort', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_lightbox_skin', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_lightbox_enable_caption', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_lightbox_thumbnails', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_lightbox_opacity', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_gallery_hover_slide', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_full_autoplay', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_full_slideshow_timer', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_full_slideshow_trans', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_full_slideshow_trans_speed', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_full_image_caption', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_full_nocover', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_full_arrow', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_kenburns_timer', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_kenburns_zoom', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_kenburns_trans', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    //End Gallery Tab Settings
    
    
    //Begin Portfolio Tab Settings
    $wp_customize->add_setting( 'tg_portfolio_filterable', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_filterable_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_filterable_sort', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_items', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_next_prev', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_recent', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    //End Portfolio Tab Settings
    
    
    //Begin Blog Tab Settings
    $wp_customize->add_setting( 'tg_blog_display_full', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_archive_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_category_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_tag_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_header_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_feat_content', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_tags', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_author', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_related', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'grandtour_sanitize_checkbox',
    ) );
    //End Blog Tab Settings
    
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		//Begin Shop Tab Settings
		$wp_customize->add_setting( 'tg_shop_layout', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_items', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'grandtour_sanitize_slider',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_price_font_color', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_related_products', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'grandtour_sanitize_checkbox',
	    ) );
		//End Shop Tab Settings
	}
    
    
    //Add Live preview
    if ( $wp_customize->is_preview() && ! is_admin() ) {
	    add_action( 'wp_footer', 'grandtour_customize_preview', 21);
	}
}
add_action( 'customize_register', 'grandtour_header_setting' );

/**
 * Create the setting
 */
function grandtour_custom_setting( $controls ) {

	//Default control choices
	$tg_text_transform = array(
	    'none' => 'None',
	    'capitalize' => 'Capitalize',
	    'uppercase' => 'Uppercase',
	    'lowercase' => 'Lowercase',
	);
	
	$tg_text_alignment = array(
	    'left' => 'Left',
	    'center' => 'Center',
	    'right' => 'Right',
	);
	
	$tg_copyright_content = array(
	    'social' => 'Social Icons',
	    'menu' => 'Footer Menu',
	);
	
	$tg_copyright_column = array(
	    '' => 'Hide Footer Sidebar',
	    1 => '1 Column',
	    2 => '2 Column',
	    3 => '3 Column',
	    4 => '4 Column',
	);
	
	$tg_gallery_sort = array(
		'drag' => 'By Drag&drop',
		'post_date' => 'By Newest',
		'post_date_old' => 'By Oldest',
		'rand' => 'By Random',
		'title' => 'By Title',
	);
	
	$tg_portfolio_filterable_sort = array(
		'name' => 'By Name',
		'slug' => 'By Slug',
		'id' => 'By ID',
		'count' => 'By Number of Portfolio',
	);
	
	$tg_blog_layout = array(
		'blog_g' => 'Grid',
		'blog_gs' => 'Grid + Right Siebar',
		'blog_gls' => 'Grid + Left Siebar',
		'blog_r' => 'Right Sidebar',
		'blog_l' => 'Left Sidebar',
		'blog_f' => 'Fullwidth',
	);
	
	$tg_shop_layout = array(
		'fullwidth' => 'Fullwidth',
		'sidebar' => 'With Sidebar',
	);
	
	$tg_slideshow_trans = array(
	    1 => 'Fade',
	    2 => 'Slide Top',
	    3 => 'Slide Right',
	    4 => 'Slide Bottom',
	    5 => 'Slide Left',
	    6 => 'Carousel Right',
	    7 => 'Carousel Left',
	);
	
	$tg_menu_layout = array(
	    'leftalign' => 'Left Align',
	    'leftalign_search' => 'Left Align + Search Bar',
	    'centeralign' => 'Center Align',
	    'centeralogo' => 'Center Logo + 2 Menus',
	    'hammenuside' => 'Hamburger Menu + Side Menu',
	    'hammenufull' => 'Hamburger Menu + Fullscreen Menu',
	);
	
	$tg_slider_layout = array(
		'slider' => 'Fullwidth',
		'3cols-slider' => '3 Columns',
	);
	
	$tg_lightbox_skin = array(
		'metro-white' => 'White',
		'metro-black' => 'Black',
		'light' => 'Light',
		'mac' => 'Mac',
		'smooth' => 'Smooth',
	);
	
	$tg_lightbox_thumbnails = array(
		'' => 'No Thumbnail',
		'horizontal' => 'Horizontal Align',
		'vertical' => 'Vertical Align',
	);
	
	$tg_sidemenu_align = array(
		'left' => 'Left',
		'right' => 'Right',
	);
	
	$tg_sidemenu_text_align = array(
		'left' => 'Left',
		'center' => 'Center',
		'right' => 'Right',
	);
	
	$tg_sidemenu_overlay_effect = array(
		'blur' => 'Blur',
		'fade' => 'Fade',
		'no_effect' => 'No Effect',
	);
	
	$tg_single_tour_content = array(
	    'booking' => 'Display Tour Booking First',
	    'content' => 'Display Tour Content First',
	);
	
	$tg_text_vertical_alignment = array(
	    'baseline' => 'Baseline',
	    'center' => 'Center',
	);
	
	$tg_single_tour_related_layout = array(
	    2 => '2 Columns',
	    3 => '3 Columns',
	    4 => '4 Columns',
	);
	
	$tg_single_destination_tour_content = array(
	    'before' => 'Display Tours before content',
	    'after' => 'Display Tours after content',
	);
	
	//Get all categories
	$categories_arr = get_categories();
	$tg_categories_select = array();
	$tg_categories_select[''] = '';
	
	foreach ($categories_arr as $cat) {
		$tg_categories_select[$cat->cat_ID] = $cat->cat_name;
	}
	
	//Get all gallery categories
	$gallery_categories_arr = get_terms('gallerycat', 'hide_empty=0&hierarchical=0&parent=0&orderby=name');
	$tg_gallery_categories_select = array();
	$tg_gallery_categories_select[''] = '';
	
	if(!empty($gallery_categories_arr) && is_array($gallery_categories_arr))
	{
		foreach ($gallery_categories_arr as $gallery_cat) {
			$tg_gallery_categories_select[$gallery_cat->slug] = $gallery_cat->name;
		}
	}
	
	//Register Logo Tab Settings
	$controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_favicon',
        'label'    => esc_html__('Favicon', 'grandtour' ),
        'description' => esc_html__('A favicon is a 16x16 pixel icon that represents your site; paste the URL to a .ico image that you want to use as the image', 'grandtour' ),
        'section'  => 'logo_favicon',
	    'default'  => '',
	    'priority' => 1,
    );
	
	$controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_retina_logo',
        'label'    => esc_html__('Retina Logo', 'grandtour' ),
        'description' => esc_html__('Retina Ready Image logo. It should be 2x size of normal logo. For example 200x60px logo will displays at 100x30px', 'grandtour' ),
        'section'  => 'logo_favicon',
	    'default'  => get_template_directory_uri().'/images/logo@2x.png',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_retina_logo_for_admin',
        'label'    => esc_html__('Display Retina Logo in Theme Setting', 'grandtour' ),
        'description' => esc_html__('Check this to replace theme setting to your logo. It helps branding your site', 'grandtour' ),
        'section'  => 'logo_favicon',
        'default'  => '',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_retina_transparent_logo',
        'label'    => esc_html__('Retina Transparent Logo', 'grandtour' ),
        'description' => esc_html__('Retina Ready Image logo for menu transparent page. It should be 2x size of normal logo. For example 200x60px logo will displays at 100x30px. Recommend logo color is white or bright color', 'grandtour' ),
        'section'  => 'logo_favicon',
	    'default'  => get_template_directory_uri().'/images/logo@2x_white.png',
	    'priority' => 3,
    );
    //End Logo Tab Settings
    
    //Register General Tab Settings
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_right_click',
        'label'    => esc_html__('Enable Right Click Protection', 'grandtour' ),
        'description' => esc_html__('Check this to disable right click.', 'grandtour' ),
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_dragging',
        'label'    => esc_html__('Enable Image Dragging Protection', 'grandtour' ),
        'description' => esc_html__('Check this to disable dragging on all images.', 'grandtour' ),
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_body_typography_title',
        'label'    => esc_html__('Body and Content Settings', 'grandtour' ),
        'section'  => 'general_typography',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_body_font',
        'label'    => esc_html__('Main Content Font Family', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 'Work Sans',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => 'body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, textarea',
	            'property' => 'font-family',
	        ),
	    ),
		'transport' => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_body_font_size',
        'label'    => esc_html__('Main Content Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 15,
        'choices' => array( 'min' => 11, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, input[type=submit], input[type=button], a.button, .button',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_body_font_weight',
        'label'    => esc_html__('Main Content Font Weight', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 400,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => 'body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, textarea',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 1,
	    'js_vars'   => array(
			array(
				'element'  => 'body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, textarea',
				'function' => 'css',
				'property' => 'font-weight',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_header_typography_title',
        'label'    => esc_html__('Header Settings', 'grandtour' ),
        'section'  => 'general_typography',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_header_font',
        'label'    => esc_html__('H1, H2, H3, H4, H5, H6 Font Family', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, .post_quote_title, label, strong[itemprop="author"], #page_content_wrapper .posts.blog li a, .page_content_wrapper .posts.blog li a, .readmore, .post_detail.single_post, .page_tagline, #gallery_caption .tg_caption .tg_desc, #filter_selected, #autocomplete li strong, .post_detail.single_post a, .post_detail.single_post a:hover,.post_detail.single_post a:active, blockquote,.single_tour_price, .single_tour_departure_wrapper li .single_tour_departure_title, .comment_rating_wrapper .comment_rating_label, .tour_excerpt, .widget_post_views_counter_list_widget, .sidebar_widget li.widget_products, #copyright, #footer_menu li a, #footer ul.sidebar_widget li ul.posts.blog li a, .woocommerce-page table.cart th, table.shop_table thead tr th, .tour_price, p.price span.amount, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a, .woocommerce ul.products li.product .price',
	            'property' => 'font-family',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_header_font_weight',
        'label'    => esc_html__('H1, H2, H3, H4, H5, H6 Font Weight', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 600,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, #autocomplete li strong',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 2,
	    'js_vars'   => array(
			array(
				'element'  => 'h1, h2, h3, h4, h5, h6, h7, #autocomplete li strong',
				'function' => 'css',
				'property' => 'font-weight',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_header_font_spacing',
        'label'    => esc_html__('H1, H2, H3, H4, H5, H6 Font Spacing', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => -1,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, #autocomplete li strong',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
	    'js_vars'   => array(
			array(
				'element'  => 'h1, h2, h3, h4, h5, h6, h7, #autocomplete li strong',
				'function' => 'css',
				'property' => 'letter-spacing',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h1_size',
        'label'    => esc_html__('H1 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 34,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h1',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h2_size',
        'label'    => esc_html__('H2 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 28,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h2',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h3_size',
        'label'    => esc_html__('H3 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 24,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h3',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h4_size',
        'label'    => esc_html__('H4 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 20,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h4',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h5_size',
        'label'    => esc_html__('H5 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 18,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h5',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h6_size',
        'label'    => esc_html__('H6 Font Size', 'grandtour' ),
        'section'  => 'general_typography',
        'default'  => 16,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h6',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_content_bg_color',
        'label'    => esc_html__('Main Content Background Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'body, #wrapper, #page_content_wrapper.fixed, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, #body_loading_screen, h3#reply-title span, .overlay_gallery_wrapper, .pricing_wrapper_border, .pagination a, .pagination span, #captcha-wrap .text-box input, .flex-direction-nav a, .blog_promo_title h6, #supersized li, #gallery_caption .tg_caption, #horizontal_gallery_wrapper .image_caption, #tour_search_form, .tour_search_form',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => '#gallery_expand',
	            'property' => 'border-bottom-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_font_color',
        'label'    => esc_html__('Page Content Font Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#222222',
        'output' => array(
	        array(
	            'element'  => 'body, .pagination a, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, .post_info a, #page_content_wrapper.split #copyright, .page_content_wrapper.split #copyright, .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, .readmore, #page_content_wrapper .inner .sidebar_wrapper .sidebar .single_tour_booking_wrapper label, .woocommerce-MyAccount-navigation ul a, .theme_link_color',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '::selection',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => '::-webkit-input-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '::-moz-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => ':-ms-input-placeholder',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_link_color',
        'label'    => esc_html__('Page Content Link Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => 'a, .post_detail.single_post',
	            'property' => 'color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active',
	            'property' => 'background-color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
	    'js_vars'   => array(
			array(
	            'element'  => 'a, .post_detail.single_post',
	            'property' => 'color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active',
	            'property' => 'background-color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active',
	            'property' => 'border-color',
	        ),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_hover_link_color',
        'label'    => esc_html__('Page Content Hover Link Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#1EC6B6',
        'output' => array(
	        array(
	            'element'  => 'a:hover, a:active, .post_info_comment a i, ',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.post_excerpt.post_tag a:hover, input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active',
	            'property' => 'background',
	        ),
	        array(
	            'element'  => '.post_excerpt.post_tag a:hover, input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
	            'element'  => 'a:hover, a:active, .post_info_comment a i',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.post_excerpt.post_tag a:hover, input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active',
	            'property' => 'background',
	        ),
	        array(
	            'element'  => '.post_excerpt.post_tag a:hover, input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active',
	            'property' => 'border-color',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_h1_font_color',
        'label'    => esc_html__('H1, H2, H3, H4, H5, H6 Font Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, pre, code, tt, blockquote, .post_header h5 a, .post_header h3 a, .post_header.grid h6 a, .post_header.fullwidth h4 a, .post_header h5 a, blockquote, .site_loading_logo_item i, .ppb_subtitle, .woocommerce .woocommerce-ordering select, .woocommerce #page_content_wrapper a.button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button:hover, .ui-accordion .ui-accordion-header a, .tabs .ui-state-active a, body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .post_header h5 a, .post_header h6 a, .flex-direction-nav a:before, .social_share_button_wrapper .social_post_view .view_number, .social_share_button_wrapper .social_post_share_count .share_number, .portfolio_post_previous a, .portfolio_post_next a, #filter_selected, #autocomplete li strong, .post_detail.single_post a, .post_detail.single_post a:hover,.post_detail.single_post a:active, .single_tour_departure_wrapper li .single_tour_departure_title, .cart_item .product-name a, .single_tour_booking_wrapper .single_tour_view_desc, .single_tour_booking_wrapper .single_tour_view_icon, .tour_product_variable_title',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => 'body.page.page-template-gallery-archive-split-screen-php #fp-nav li .active span, body.tax-gallerycat #fp-nav li .active span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav li .active span, body.page.tax-portfolioset #fp-nav li .active span, body.page.page-template-gallery-archive-split-screen-php #fp-nav ul li a span, body.tax-gallerycat #fp-nav ul li a span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav ul li a span, body.page.tax-portfolioset #fp-nav ul li a span',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 14,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_hr_color',
        'label'    => esc_html__('Horizontal Line Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#dce0e0',
        'output' => array(
	        array(
	            'element'  => '#social_share_wrapper, hr, #social_share_wrapper, .post.type-post, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle, .comment .right, .widget_tag_cloud div a, .meta-tags a, .tag_cloud a, #footer, #post_more_wrapper, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, #page_content_wrapper .inner .sidebar_content, #page_content_wrapper .inner .sidebar_content.left_sidebar, .ajax_close, .ajax_next, .ajax_prev, .portfolio_next, .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_next, .separated, .blog_next_prev_wrapper, #post_more_wrapper h5, #ajax_portfolio_wrapper.hidding, #ajax_portfolio_wrapper.visible, .tabs.vertical .ui-tabs-panel, .ui-tabs.vertical.right .ui-tabs-nav li, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce-page div.product .woocommerce-tabs .panel, .woocommerce #content div.product .woocommerce-tabs .panel, .woocommerce-page #content div.product .woocommerce-tabs .panel, .woocommerce table.shop_table, .woocommerce-page table.shop_table, table tr td, .woocommerce .cart-collaterals .cart_totals, .woocommerce-page .cart-collaterals .cart_totals, .woocommerce .cart-collaterals .shipping_calculator, .woocommerce-page .cart-collaterals .shipping_calculator, .woocommerce .cart-collaterals .cart_totals tr td, .woocommerce .cart-collaterals .cart_totals tr th, .woocommerce-page .cart-collaterals .cart_totals tr td, .woocommerce-page .cart-collaterals .cart_totals tr th, table tr th, .woocommerce #payment, .woocommerce-page #payment, .woocommerce #payment ul.payment_methods li, .woocommerce-page #payment ul.payment_methods li, .woocommerce #payment div.form-row, .woocommerce-page #payment div.form-row, .ui-tabs li:first-child, .ui-tabs .ui-tabs-nav li, .ui-tabs.vertical .ui-tabs-nav li, .ui-tabs.vertical.right .ui-tabs-nav li.ui-state-active, .ui-tabs.vertical .ui-tabs-nav li:last-child, #page_content_wrapper .inner .sidebar_wrapper ul.sidebar_widget li.widget_nav_menu ul.menu li.current-menu-item a, .page_content_wrapper .inner .sidebar_wrapper ul.sidebar_widget li.widget_nav_menu ul.menu li.current-menu-item a, .pricing_wrapper, .pricing_wrapper li, .ui-accordion .ui-accordion-header, .ui-accordion .ui-accordion-content, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle:before, h2.widgettitle:before, #autocomplete, .ppb_blog_minimal .one_third_bg, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.event_title, .tabs .ui-tabs-panel, .ui-tabs .ui-tabs-nav li, .ui-tabs li:first-child, .ui-tabs.vertical .ui-tabs-nav li:last-child, .woocommerce .woocommerce-ordering select, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page table.cart th, table.shop_table thead tr th, hr.title_break, .overlay_gallery_border, #page_content_wrapper.split #copyright, .page_content_wrapper.split #copyright, .post.type-post, .events.type-events, h5.event_title, .post_header h5.event_title, .client_archive_wrapper, #page_content_wrapper .sidebar .content .sidebar_widget li.widget, .page_content_wrapper .sidebar .content .sidebar_widget li.widget, hr.title_break.bold, blockquote, .social_share_button_wrapper, .social_share_button_wrapper, body:not(.single) .post_wrapper, .themeborder',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 15,
	    'js_vars'   => array(
			array(
				'element'  => '#social_share_wrapper, hr, #social_share_wrapper, .post.type-post, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle, .comment .right, .widget_tag_cloud div a, .meta-tags a, .tag_cloud a, #footer, #post_more_wrapper, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, #page_content_wrapper .inner .sidebar_content, #page_content_wrapper .inner .sidebar_content.left_sidebar, .ajax_close, .ajax_next, .ajax_prev, .portfolio_next, .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_next, .separated, .blog_next_prev_wrapper, #post_more_wrapper h5, #ajax_portfolio_wrapper.hidding, #ajax_portfolio_wrapper.visible, .tabs.vertical .ui-tabs-panel, .ui-tabs.vertical.right .ui-tabs-nav li, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce-page div.product .woocommerce-tabs .panel, .woocommerce #content div.product .woocommerce-tabs .panel, .woocommerce-page #content div.product .woocommerce-tabs .panel, .woocommerce table.shop_table, .woocommerce-page table.shop_table, table tr td, .woocommerce .cart-collaterals .cart_totals, .woocommerce-page .cart-collaterals .cart_totals, .woocommerce .cart-collaterals .shipping_calculator, .woocommerce-page .cart-collaterals .shipping_calculator, .woocommerce .cart-collaterals .cart_totals tr td, .woocommerce .cart-collaterals .cart_totals tr th, .woocommerce-page .cart-collaterals .cart_totals tr td, .woocommerce-page .cart-collaterals .cart_totals tr th, table tr th, .woocommerce #payment, .woocommerce-page #payment, .woocommerce #payment ul.payment_methods li, .woocommerce-page #payment ul.payment_methods li, .woocommerce #payment div.form-row, .woocommerce-page #payment div.form-row, .ui-tabs li:first-child, .ui-tabs .ui-tabs-nav li, .ui-tabs.vertical .ui-tabs-nav li, .ui-tabs.vertical.right .ui-tabs-nav li.ui-state-active, .ui-tabs.vertical .ui-tabs-nav li:last-child, #page_content_wrapper .inner .sidebar_wrapper ul.sidebar_widget li.widget_nav_menu ul.menu li.current-menu-item a, .page_content_wrapper .inner .sidebar_wrapper ul.sidebar_widget li.widget_nav_menu ul.menu li.current-menu-item a, .pricing_wrapper, .pricing_wrapper li, .ui-accordion .ui-accordion-header, .ui-accordion .ui-accordion-content, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle:before, h2.widgettitle:before, #autocomplete, .ppb_blog_minimal .one_third_bg, #page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.event_title, .tabs .ui-tabs-panel, .ui-tabs .ui-tabs-nav li, .ui-tabs li:first-child, .ui-tabs.vertical .ui-tabs-nav li:last-child, .woocommerce .woocommerce-ordering select, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page table.cart th, table.shop_table thead tr th, hr.title_break, .overlay_gallery_border, #page_content_wrapper.split #copyright, .page_content_wrapper.split #copyright, .post.type-post, .events.type-events, h5.event_title, .post_header h5.event_title, .client_archive_wrapper, #page_content_wrapper .sidebar .content .sidebar_widget li.widget, .page_content_wrapper .sidebar .content .sidebar_widget li.widget, hr.title_break.bold, blockquote, .social_share_button_wrapper, .social_share_button_wrapper, body:not(.single) .post_wrapper, .themeborder',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_review_star_color',
        'label'    => esc_html__('Review Stars Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#1EC6B6',
        'output' => array(
	        array(
	            'element'  => '.br-theme-fontawesome-stars-o .br-widget a.br-selected:after, .woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before, .woocommerce #review_form #respond p.stars a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#toTop, .single_tour_users_online_wrapper .single_tour_users_online_icon',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
			array(
	            'element'  => '.br-theme-fontawesome-stars-o .br-widget a.br-selected:after, .woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before, .woocommerce #review_form #respond p.stars a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#toTop, .single_tour_users_online_wrapper .single_tour_users_online_icon',
	            'property' => 'background',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_tour_label_color',
        'label'    => esc_html__('Tour Label Color', 'grandtour' ),
        'section'  => 'general_color',
        'default'  => '#1EC6B6',
        'output' => array(
	        array(
	            'element'  => '.single_tour_attribute_wrapper .tour_label, a.tour_image .tour_label, .grid.portfolio_type .tour_label, .tour_label.sidebar',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
	        array(
	            'element'  => '.single_tour_attribute_wrapper .tour_label, a.tour_image .tour_label, .grid.portfolio_type .tour_label, .tour_label.sidebar',
	            'property' => 'background',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_input_title',
        'label'    => esc_html__('Input and Textarea Settings', 'grandtour' ),
        'section'  => 'general_input',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_bg_color',
        'label'    => esc_html__('Input and Textarea Background Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], input[type=number], textarea, select',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_font_color',
        'label'    => esc_html__('Input and Textarea Font Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#555555',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], input[type=number], textarea, select',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 17,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_border_color',
        'label'    => esc_html__('Input and Textarea Border Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#dce0e0',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], input[type=number], textarea, select',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 18,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_focus_color',
        'label'    => esc_html__('Input and Textarea Focus State Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#999999',
        'output' => array(
	        array(
	            'element'  => 'input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=date]:focus, input[type=number]:focus, textarea:focus, #tour_search_form .one_fourth:not(.last):hover',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_button_title',
        'label'    => esc_html__('Button Settings', 'grandtour' ),
        'section'  => 'general_input',
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_button_font',
        'label'    => esc_html__('Button Font Family', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => 'Work Sans',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt',
	            'property' => 'font-family',
	        ),
	    ),
		'transport' => 'postMessage',
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_bg_color',
        'label'    => esc_html__('Button Background Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer_bar .button, .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post_type_icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one_half.gallery2 .portfolio_type_wrapper, .one_third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrappe, .post_share_text, #close_share, .widget_tag_cloud div a:hover, a.tour_image .tour_price, .mobile_menu_wrapper #close_mobile_menu, a.tour_image .tour_price, .grid.portfolio_type .tour_price, .ui-accordion .ui-accordion-header .ui-icon, .mobile_menu_wrapper #mobile_menu_close.button, .header_cart_wrapper .cart_count',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => '.pagination span, .pagination a:hover, .button.ghost, .button.ghost:hover, .button.ghost:active, blockquote:after, .woocommerce-MyAccount-navigation ul li.is-active',
	            'property' => 'border-color',
	        ),
	        array(
	            'element'  => '.comment_box:before, .comment_box:after',
	            'property' => 'border-top-color',
	        ),
	        array(
	            'element'  => '.button.ghost, .button.ghost:hover, .button.ghost:active, .infinite_load_more, blockquote:before, .woocommerce-MyAccount-navigation ul li.is-active a',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer_bar .button, .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post_type_icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one_half.gallery2 .portfolio_type_wrapper, .one_third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrappe, .post_share_text, #close_share, .widget_tag_cloud div a:hover, a.tour_image .tour_price, .mobile_menu_wrapper #close_mobile_menu, a.tour_image .tour_price, .grid.portfolio_type .tour_price, .ui-accordion .ui-accordion-header .ui-icon, .mobile_menu_wrapper #mobile_menu_close.button, .header_cart_wrapper .cart_count',
				'function' => 'css',
				'property' => 'background-color',
			),
			array(
				'element'  => '.pagination span, .pagination a:hover, .button.ghost, .button.ghost:hover, .button.ghost:active, blockquote:after, .woocommerce-MyAccount-navigation ul li.is-active',
				'function' => 'css',
				'property' => 'border-color',
			),
			array(
				'element'  => '.comment_box:before, .comment_box:after',
				'function' => 'css',
				'property' => 'border-top-color',
			),
			array(
				'element'  => '.button.ghost, .button.ghost:hover, .button.ghost:active, .infinite_load_more, blockquote:before, .woocommerce-MyAccount-navigation ul li.is-active a',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_font_color',
        'label'    => esc_html__('Button Font Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination a:hover, .woocommerce .footer_bar .button , .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post_type_icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one_half.gallery2 .portfolio_type_wrapper, .one_third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrapper, .post_share_text, #close_share, .widget_tag_cloud div a:hover, a.tour_image .tour_price, .mobile_menu_wrapper #close_mobile_menu, .ui-accordion .ui-accordion-header .ui-icon, .mobile_menu_wrapper #mobile_menu_close.button',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer_bar .button, .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post_type_icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one_half.gallery2 .portfolio_type_wrapper, .one_third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrappe, .post_share_text, #close_share, .widget_tag_cloud div a:hover, a.tour_image .tour_price, .mobile_menu_wrapper #close_mobile_menu, a.tour_image .tour_price, .grid.portfolio_type .tour_price, .ui-accordion .ui-accordion-header .ui-icon, .mobile_menu_wrapper #mobile_menu_close.button',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 21,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_border_color',
        'label'    => esc_html__('Button Border Color', 'grandtour' ),
        'section'  => 'general_input',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination a:hover, .woocommerce .footer_bar .button , .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .infinite_load_more, .post_share_text, #close_share, .widget_tag_cloud div a:hover, .mobile_menu_wrapper #close_mobile_menu, .mobile_menu_wrapper #mobile_menu_close.button',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer_bar .button, .woocommerce .footer_bar .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post_type_icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one_half.gallery2 .portfolio_type_wrapper, .one_third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrappe, .post_share_text, #close_share, .widget_tag_cloud div a:hover, a.tour_image .tour_price, .mobile_menu_wrapper #close_mobile_menu, a.tour_image .tour_price, .grid.portfolio_type .tour_price, .ui-accordion .ui-accordion-header .ui-icon, .mobile_menu_wrapper #mobile_menu_close.button',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 22,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_mobile_responsive',
        'label'    => esc_html__('Enable Responsive Layout', 'grandtour' ),
        'description' => esc_html__('Check this to enable responsive layout for tablet and mobile devices.', 'grandtour' ),
        'section'  => 'general_mobile',
        'default'  => 1,
	    'priority' => 25,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_frame',
        'label'    => esc_html__('Enable Frame', 'grandtour' ),
        'description' => esc_html__('Check this to enable frame for site layout', 'grandtour' ),
        'section'  => 'general_frame',
        'default'  => 0,
	    'priority' => 26,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_frame_color',
        'label'    => esc_html__('Frame Color', 'grandtour' ),
        'section'  => 'general_frame',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => '.frame_top, .frame_bottom, .frame_left, .frame_right',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 27,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_boxed',
        'label'    => esc_html__('Enable Boxed Layout', 'grandtour' ),
        'description' => esc_html__('Check this to enable boxed layout for site layout', 'grandtour' ),
        'section'  => 'general_boxed',
        'default'  => 0,
	    'priority' => 28,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_boxed_bg_color',
        'label'    => esc_html__('Background Color', 'grandtour' ),
        'section'  => 'general_boxed',
        'default'  => '#f0f0f0',
        'output' => array(
	        array(
	            'element'  => 'body.tg_boxed',
	            'property' => 'background-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'body.tg_boxed',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 28,
    );
    $controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_boxed_bg_image',
        'label'    => esc_html__('Background Image', 'grandtour' ),
        'description' => esc_html__('Upload background image for boxed layout', 'grandtour' ),
        'section'  => 'general_boxed',
	    'default'  => '',
	    'priority' => 28,
    );
    //End General Tab Settings

	//Register Menu Tab Settings 
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_menu_layout',
        'label'    => esc_html__('Menu Layout', 'grandtour' ),
        'section'  => 'menu_general',
        'default'  => 'leftalign',
        'choices'  => $tg_menu_layout,
	    'priority' => 1,
    );
	
	$controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_fixed_menu',
        'label'    => esc_html__('Enable Sticky Menu', 'grandtour' ),
        'description' => esc_html__('Enable this option to display main menu fixed when scrolling', 'grandtour' ),
        'section'  => 'menu_general',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_smart_fixed_menu',
        'label'    => esc_html__('Enable Smart Sticky Menu', 'grandtour' ),
        'description' => esc_html__('Enable this option to make menu displays when scroll down and hide when scroll up', 'grandtour' ),
        'section'  => 'menu_general',
        'default'  => 1,
	    'priority' => 1,
    );
	
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_menu_font',
        'label'    => esc_html__('Menu Font Family', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a',
	            'property' => 'font-family',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_menu_font_size',
        'label'    => esc_html__('Menu Font Size', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 13,
        'choices' => array( 'min' => 11, 'max' => 40, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a, .header_cart_wrapper i',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_menu_padding',
        'label'    => esc_html__('Menu Padding', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 26,
        'choices' => array( 'min' => 0, 'max' => 150, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a, html[data-menu=centeralogo] #logo_right_button',
	            'property' => 'padding-top',
	            'units'    => 'px',
	        ),
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a, html[data-menu=centeralogo] #logo_right_button',
	            'property' => 'padding-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_menu_weight',
        'label'    => esc_html__('Menu Font Weight', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 500,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_menu_font_spacing',
        'label'    => esc_html__('Menu Font Spacing', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 0,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_menu_transform',
        'label'    => esc_html__('Menu Font Text Transform', 'grandtour' ),
        'section'  => 'menu_typography',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_bg',
        'label'    => esc_html__('Menu Background', 'grandtour' ),
        'section'  => 'menu_color',
	    'default'     => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.top_bar',
	            'property' => 'background-color',
	        ),
	    ),
	    'priority' => 4,
	    'transport' 	 => 'postMessage',
	    'js_vars'   => array(
			array(
				'element'  => '.top_bar',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_font_color',
        'label'    => esc_html__('Menu Font Color', 'grandtour' ),
        'section'  => 'menu_color',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a, #mobile_nav_icon, #logo_wrapper .social_wrapper ul li a, .header_cart_wrapper > a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#mobile_nav_icon',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_hover_font_color',
        'label'    => esc_html__('Menu Hover State Font Color', 'grandtour' ),
        'section'  => 'menu_color',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li a.hover, #menu_wrapper .nav ul li a:hover, #menu_wrapper div .nav li a.hover, #menu_wrapper div .nav li a:hover, .header_cart_wrapper a:hover, #page_share:hover, #gallery_download:hover, .view_fullscreen_wrapper a:hover, #logo_wrapper .social_wrapper ul li a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_active_font_color',
        'label'    => esc_html__('Menu Active State Font Color', 'grandtour' ),
        'section'  => 'menu_color',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper div .nav > li.current-menu-item > a, #menu_wrapper div .nav > li.current-menu-parent > a, #menu_wrapper div .nav > li.current-menu-ancestor > a, #menu_wrapper div .nav li ul li.current-menu-item a, #menu_wrapper div .nav li.current-menu-parent  ul li.current-menu-item a, #logo_wrapper .social_wrapper ul li a:active',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_border_color',
        'label'    => esc_html__('Menu Bar Border Color', 'grandtour' ),
        'section'  => 'menu_color',
        'default'  => '#dce0e0',
        'output' => array(
	        array(
	            'element'  => '.top_bar, #page_caption, #nav_wrapper',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_submenu_font_title',
        'label'    => esc_html__('Typography Settings', 'grandtour' ),
        'section'  => 'menu_submenu',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_submenu_font_size',
        'label'    => esc_html__('SubMenu Font Size', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => 13,
        'choices' => array( 'min' => 10, 'max' => 40, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_submenu_weight',
        'label'    => esc_html__('SubMenu Font Weight', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => 500,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_submenu_font_spacing',
        'label'    => esc_html__('SubMenu Font Spacing', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => 0,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_submenu_transform',
        'label'    => esc_html__('SubMenu Font Text Transform', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_submenu_color_title',
        'label'    => esc_html__('Color Settings', 'grandtour' ),
        'section'  => 'menu_submenu',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_font_color',
        'label'    => esc_html__('Sub Menu Font Color', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a, #menu_wrapper div .nav li.current-menu-parent ul li.current-menu-item a, #menu_wrapper .nav ul li.megamenu ul li ul li a, #menu_wrapper div .nav li.megamenu ul li ul li a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_hover_font_color',
        'label'    => esc_html__('Sub Menu Hover State Font Color', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a:hover, #menu_wrapper div .nav li ul li a:hover, #menu_wrapper div .nav li.current-menu-parent ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:hover, #menu_wrapper div .nav li.megamenu ul li ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:active, #menu_wrapper div .nav li.megamenu ul li ul li a:active, #menu_wrapper div .nav li.current-menu-parent ul li.current-menu-item  a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 14,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_hover_bg_color',
        'label'    => esc_html__('Sub Menu Hover State Background Color', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul li a:hover, #menu_wrapper div .nav li ul li a:hover, #menu_wrapper div .nav li.current-menu-parent ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:hover, #menu_wrapper div .nav li.megamenu ul li ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:active, #menu_wrapper div .nav li.megamenu ul li ul li a:active',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 15,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_bg_color',
        'label'    => esc_html__('Sub Menu Background Color', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul, #menu_wrapper div .nav li ul',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_border_color',
        'label'    => esc_html__('Sub Menu Border Color', 'grandtour' ),
        'section'  => 'menu_submenu',
        'default'  => '#dce0e0',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper .nav ul li ul, #menu_wrapper div .nav li ul',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 17,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_megamenu_header_color',
        'label'    => esc_html__('Mega Menu Header Font Color', 'grandtour' ),
        'section'  => 'menu_megamenu',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper div .nav li.megamenu ul li > a, #menu_wrapper div .nav li.megamenu ul li > a:hover, #menu_wrapper div .nav li.megamenu ul li > a:active, #menu_wrapper div .nav li.megamenu ul li.current-menu-item > a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 18,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_megamenu_border_color',
        'label'    => esc_html__('Mega Menu Border Color', 'grandtour' ),
        'section'  => 'menu_megamenu',
        'default'  => '#dce0e0',
        'output' => array(
	        array(
	            'element'  => '#menu_wrapper div .nav li.megamenu ul li',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_topbar',
        'label'    => esc_html__('Display Top Bar', 'grandtour' ),
        'description' => esc_html__('Enable this option to display top bar above main menu', 'grandtour' ),
        'section'  => 'menu_topbar',
        'default'  => 0,
	    'priority' => 21,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_topbar_bg_color',
        'label'    => esc_html__('Top Bar Background Color', 'grandtour' ),
        'section'  => 'menu_topbar',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '.above_top_bar',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 22,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_topbar_font_color',
        'label'    => esc_html__('Top Bar Menu Font Color', 'grandtour' ),
        'section'  => 'menu_topbar',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#top_menu li a, .top_contact_info, .top_contact_info i, .top_contact_info a, .top_contact_info a:hover, .top_contact_info a:active',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 23,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_menu_contact_hours',
        'label'    => esc_html__('Contact Hours (Optional)', 'grandtour' ),
        'description' => esc_html__('Enter your company contact hours.', 'grandtour' ),
        'section'  => 'menu_contact',
        'default'  => 'Mon-Fri 09.00 - 17.00',
        'transport' 	 => 'postMessage',
	    'priority' => 26,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_menu_contact_number',
        'label'    => esc_html__('Contact Phone Number (Optional)', 'grandtour' ),
        'description' => esc_html__('Enter your company contact phone number.', 'grandtour' ),
        'section'  => 'menu_contact',
        'default'  => '1.800.456.6743',
        'transport' => 'postMessage',
	    'priority' => 27,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_topbar_social_link',
        'label'    => esc_html__('Open Top Bar Social Icons link in new window', 'grandtour' ),
        'description' => esc_html__('Check this to open top bar social icons link in new window', 'grandtour' ),
        'section'  => 'menu_contact',
        'default'  => 1,
	    'priority' => 28,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_sidemenu',
        'label'    => esc_html__('Enable Side Menu on Desktop', 'grandtour' ),
        'description' => 'Check this option to enable side menu on desktop',
        'section'  => 'menu_sidemenu',
        'default'  => 1,
	    'priority' => 31,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidemenu_align',
        'label'    => esc_html__('Side Menu Alignment', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 'right',
        'choices'  => $tg_sidemenu_align,
	    'priority' => 31,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_sidemenu_overlay_effect',
        'label'    => esc_html__('Side Menu Overlay Effect', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 'blur',
        'choices'  => $tg_sidemenu_overlay_effect,
	    'priority' => 31,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_sidemenu_font_title',
        'label'    => esc_html__('Typography Settings', 'grandtour' ),
        'section'  => 'menu_sidemenu',
	    'priority' => 31,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidemenu_font',
        'label'    => esc_html__('Side Menu Font Family', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'font-family',
	        ),
	    ),
		'transport' => 'postMessage',
	    'priority' => 32,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidemenu_font_size',
        'label'    => esc_html__('Side Menu Font Size', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 24,
        'choices' => array( 'min' => 11, 'max' => 40, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 33,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidemenu_line_height',
        'label'    => esc_html__('Side Menu Line Height (em)', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 2,
        'choices' => array( 'min' => 1, 'max' => 3, 'step' => 0.1 ),
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'line-height',
				'units'    => 'em',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 33,
	    'js_vars'   => array(
			array(
				'element'  => '.mobile_main_nav li a, #sub_menu li a',
				'function' => 'css',
				'property' => 'line-height',
				'units'    => 'em',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidemenu_font_weight',
        'label'    => esc_html__('Side Menu Font Weight', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 700,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 33,
	    'js_vars'   => array(
			array(
				'element'  => '.mobile_main_nav li a, #sub_menu li a',
				'function' => 'css',
				'property' => 'font-weight',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidemenu_font_transform',
        'label'    => esc_html__('Side Menu Font Text Transform', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 34,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidemenu_font_spacing',
        'label'    => esc_html__('Side Menu Font Spacing', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => -1,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 35,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidemenu_text_align',
        'label'    => esc_html__('Side Menu Text Alignment', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 'left',
        'choices'  => $tg_sidemenu_text_align,
	    'priority' => 35,
	    'output' => array(
	        array(
	            'element'  => '.mobile_menu_wrapper, .mobile_menu_wrapper h2.widgettitle, .mobile_menu_wrapper .sidebar_widget',
	            'property' => 'text-align',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 35,
	    'js_vars'   => array(
			array(
				'element'  => '.mobile_menu_wrapper, .mobile_menu_wrapper h2.widgettitle, .mobile_menu_wrapper .sidebar_widget',
				'function' => 'css',
				'property' => 'text-align',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_sidemenu_bg_title',
        'label'    => esc_html__('Color Settings', 'grandtour' ),
        'section'  => 'menu_sidemenu',
	    'priority' => 36,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_bg',
        'label'    => esc_html__('Side Menu Background', 'grandtour' ),
        'section'  => 'menu_sidemenu',
	    'default'  => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.mobile_menu_wrapper',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'js_vars'   => array(
			array(
	            'element'  => '.mobile_menu_wrapper',
	            'property' => 'background-color',
	        ),
		),
	    'priority' => 36,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidemenu_bg_opacity',
        'label'    => esc_html__('Side Menu Background Opacity', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 85,
        'choices' => array( 'min' => 0, 'max' => 100, 'step' => 5 ),
	    'priority' => 37,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_font_color',
        'label'    => esc_html__('Side Menu Font Color', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a, #sub_menu li a, .mobile_menu_wrapper .sidebar_wrapper a, .mobile_menu_wrapper .sidebar_wrapper, #close_mobile_menu i, .mobile_menu_wrapper .social_wrapper ul li a, html[data-menu=hammenufull] #copyright',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 37,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_font_hover_color',
        'label'    => esc_html__('Side Menu Hover State Font Color', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#FF4A52',
        'output' => array(
	        array(
	            'element'  => '.mobile_main_nav li a:hover, .mobile_main_nav li a:active, #sub_menu li a:hover, #sub_menu li a:active, .mobile_menu_wrapper .sidebar_wrapper h2.widgettitle, .mobile_menu_wrapper .social_wrapper ul li a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 38,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_menu_search_title',
        'label'    => esc_html__('Search Settings', 'grandtour' ),
        'section'  => 'menu_sidemenu',
	    'priority' => 39,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_menu_search',
        'label'    => esc_html__('Enable Search', 'grandtour' ),
        'description' => esc_html__('Select to display search form in header of side menu', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => 0,
	    'priority' => 40,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_search_input_color',
        'label'    => esc_html__('Search Input Background Color', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.mobile_menu_wrapper #searchform input[type=text]',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 42,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_search_font_color',
        'label'    => esc_html__('Search Input Font Color', 'grandtour' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#222222',
        'output' => array(
	        array(
	            'element'  => '.mobile_menu_wrapper #searchform input[type=text], .mobile_menu_wrapper #searchform button i',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.mobile_menu_wrapper #searchform ::-webkit-input-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.mobile_menu_wrapper #searchform ::-moz-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.mobile_menu_wrapper #searchform :-ms-input-placeholder',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 43,
    );
    //End Menu Tab Settings
    
    //Register Header Tab Settings
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_page_header_bg_title',
        'label'    => esc_html__('Background Image Settings', 'grandtour' ),
        'section'  => 'header_background',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_bg_height',
        'label'    => esc_html__('Page Title Background Image Height (in pixels)', 'grandtour' ),
        'section'  => 'header_background',
        'default'  => 550,
        'choices' => array( 'min' => 150, 'max' => 1500, 'step' => 10 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption.hasbg',
	            'property' => 'height',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_margin_bottom',
        'label'    => esc_html__('Page Title Background Image Margin Bottom (in pixels)', 'grandtour' ),
        'section'  => 'header_background',
        'default'  => 40,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 5 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption.hasbg',
	            'property' => 'margin-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_page_header_bg_parallax',
        'label'    => esc_html__('Add Parallax Effect When Scroll', 'grandtour' ),
        'description' => esc_html__('Enable this option to add parallax effect to header background image when scrolling pass it', 'grandtour' ),
        'section'  => 'header_background',
        'default'  => '1',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_page_header_bgcolor_title',
        'label'    => esc_html__('Background Color Settings', 'grandtour' ),
        'section'  => 'header_background',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_page_header_bg_color',
        'label'    => esc_html__('Page Header Background Color', 'grandtour' ),
        'section'  => 'header_background',
        'default'  => '#f9f9f9',
        'output' => array(
	        array(
	            'element'  => '#page_caption',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_header_padding_top',
        'label'    => esc_html__('Page Header Padding Top', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 50,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption',
	            'property' => 'padding-top',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_header_padding_bottom',
        'label'    => esc_html__('Page Header Padding Bottom', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 50,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption',
	            'property' => 'padding-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_page_title_font',
        'label'    => esc_html__('Page Title Font Family', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title',
	            'property' => 'font-family',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_font_size',
        'label'    => esc_html__('Page Title Font Size', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 40,
        'choices' => array( 'min' => 12, 'max' => 100, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_font_weight',
        'label'    => esc_html__('Page Title Font Weight', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 700,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title, .post_caption h1',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_line_height',
        'label'    => esc_html__('Page Title Line Height (em)', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 1.3,
        'choices' => array( 'min' => 1, 'max' => 3, 'step' => 0.1 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .post_caption h1',
	            'property' => 'line-height',
				'units'    => 'em',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
	    'js_vars'   => array(
			array(
				'element'  => '#page_caption h1, .post_caption h1',
				'function' => 'css',
				'property' => 'line-height',
				'units'    => 'em',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_page_title_transform',
        'label'    => esc_html__('Page Title Text Transform', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title, .post_caption h1',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_font_spacing',
        'label'    => esc_html__('Page Title Font Spacing', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => -2,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title, .post_caption h1',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_page_title_font_color',
        'label'    => esc_html__('Page Title Font Color', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '#page_caption h1, .ppb_title, .post_caption h1',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_page_title_vertical_alignment',
        'label'    => esc_html__('Page Title Text Vertical Alignment', 'grandtour' ),
        'section'  => 'header_title',
        'default'  => 'baseline',
        'choices'  => $tg_text_vertical_alignment
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_header_builder_font',
        'label'    => esc_html__('Content Builder Header Font Family', 'grandtour' ),
        'section'  => 'header_builder_title',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => '.ppb_title',
	            'property' => 'font-family',
	        ),
	    ),
	    'transport' => 'postMessage',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_header_builder_font_size',
        'label'    => esc_html__(' Content Builder Header Font Size', 'grandtour' ),
        'section'  => 'header_builder_title',
        'default'  => 36,
        'choices' => array( 'min' => 12, 'max' => 100, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h2.ppb_title',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
	    'js_vars'   => array(
			array(
				'element'  => 'h2.ppb_title',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_header_builder_font_weight',
        'label'    => esc_html__('Content Builder Header Font Weight', 'grandtour' ),
        'section'  => 'header_builder_title',
        'default'  => 700,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '.ppb_title',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
	    'js_vars'   => array(
			array(
				'element'  => 'h2.ppb_title',
				'function' => 'css',
				'property' => 'font-weight',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_header_builder_font_transform',
        'label'    => esc_html__('Content Builder Header Text Transform', 'grandtour' ),
        'section'  => 'header_builder_title',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => 'h2.ppb_title',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
	    'js_vars'   => array(
			array(
				'element'  => 'h2.ppb_title',
				'function' => 'css',
				'property' => 'text-transform',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_header_builder_font_spacing',
        'label'    => esc_html__('Content Builder Header Font Spacing', 'grandtour' ),
        'section'  => 'header_builder_title',
        'default'  => -2,
        'choices' => array( 'min' => -10, 'max' => 5, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h2.ppb_title',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
	    'js_vars'   => array(
			array(
				'element'  => 'h2.ppb_title',
				'function' => 'css',
				'property' => 'letter-spacing',
				'units'    => 'px',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_page_tagline_font_color',
        'label'    => esc_html__('Page Tagline Font Color', 'grandtour' ),
        'section'  => 'header_tagline',
        'default'  => '#8D9199',
        'output' => array(
	        array(
	            'element'  => '.page_tagline, .thumb_content span, .portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company, .post_detail.single_post, #gallery_caption .tg_caption .tg_desc',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
	    'js_vars'   => array(
			array(
				'element'  => '.page_tagline, .thumb_content span, .portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company, .post_detail.single_post, #gallery_caption .tg_caption .tg_desc',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_tagline_font_size',
        'label'    => esc_html__('Page Title Font Size', 'grandtour' ),
        'section'  => 'header_tagline',
        'default'  => 15,
        'choices' => array( 'min' => 10, 'max' => 30, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '.page_tagline, .post_detail, .thumb_content span, .portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_tagline_font_weight',
        'label'    => esc_html__('Page Tagline Font Weight', 'grandtour' ),
        'section'  => 'header_tagline',
        'default'  => 500,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '.page_tagline',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_tagline_font_spacing',
        'label'    => esc_html__('Page Tagline Font Spacing', 'grandtour' ),
        'section'  => 'header_tagline',
        'default'  => 0,
        'choices' => array( 'min' => -10, 'max' => 4, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '.page_tagline, .post_header .post_detail, .recent_post_detail, .post_detail, .thumb_content span, .portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_page_tagline_transform',
        'label'    => esc_html__('Page Tagline Text Transform', 'grandtour' ),
        'section'  => 'header_tagline',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '.page_tagline, .post_header .post_detail, .recent_post_detail, .post_detail, .thumb_content span, .portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    //End Header Tab Settings
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_sidebar_sticky',
        'label'    => esc_html__('Enable Sticky Sidebar', 'grandtour' ),
        'description' => esc_html__('Check this to displays sidebar fixed when scrolling.', 'grandtour' ),
        'section'  => 'sidebar_general',
        'default'  => 1,
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidebar_title_font',
        'label'    => esc_html__('Widget Title Font Family', 'grandtour' ),
        'section'  => 'sidebar_typography',
        'default'  => 'Poppins',
        'choices'  => Kirki_Fonts::get_font_choices(),
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'font-family',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidebar_title_font_size',
        'label'    => esc_html__('Widget Title Font Size', 'grandtour' ),
        'section'  => 'sidebar_typography',
        'default'  => 18,
        'choices' => array( 'min' => 11, 'max' => 40, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidebar_title_font_weight',
        'label'    => esc_html__('Widget Title Font Weight', 'grandtour' ),
        'section'  => 'sidebar_typography',
        'default'  => 700,
        'choices' => array( 'min' => 100, 'max' => 900, 'step' => 100 ),
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'font-weight',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_sidebar_title_font_spacing',
        'label'    => esc_html__('Widget Title Font Spacing', 'grandtour' ),
        'section'  => 'sidebar_typography',
        'default'  => -1,
        'choices' => array( 'min' => -10, 'max' => 4, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'letter-spacing',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sidebar_title_transform',
        'label'    => esc_html__('Widget Title Text Transform', 'grandtour' ),
        'section'  => 'sidebar_typography',
        'default'  => 'none',
        'choices'  => $tg_text_transform,
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'text-transform',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_font_color',
        'label'    => esc_html__('Sidebar Font Color', 'grandtour' ),
        'section'  => 'sidebar_color',
        'default'  => '#555555',
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .inner .sidebar_wrapper .sidebar .content, .page_content_wrapper .inner .sidebar_wrapper .sidebar .content',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_link_color',
        'label'    => esc_html__('Sidebar Link Color', 'grandtour' ),
        'section'  => 'sidebar_color',
        'default'  => '#222222',
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .inner .sidebar_wrapper a:not(.button), .page_content_wrapper .inner .sidebar_wrapper a:not(.button)',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_hover_link_color',
        'label'    => esc_html__('Sidebar Hover Link Color', 'grandtour' ),
        'section'  => 'sidebar_color',
        'default'  => '#1EC6B6',
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .inner .sidebar_wrapper a:hover:not(.button), #page_content_wrapper .inner .sidebar_wrapper a:active:not(.button), .page_content_wrapper .inner .sidebar_wrapper a:hover:not(.button), .page_content_wrapper .inner .sidebar_wrapper a:active:not(.button)',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_title_color',
        'label'    => esc_html__('Sidebar Widget Title Font Color', 'grandtour' ),
        'section'  => 'sidebar_color',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    //End Sidebar Tab Settings
    
    //Register Footer Tab Settings
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_footer_sidebar',
        'label'    => esc_html__('Footer Sidebar Columns', 'grandtour' ),
        'section'  => 'footer_general',
        'default'  => '3',
        'choices'  => $tg_copyright_column,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_footer_social_link',
        'label'    => esc_html__('Open Footer Social Icons link in new window', 'grandtour' ),
        'description' => esc_html__('Check this to open footer social icons link in new window', 'grandtour' ),
        'section'  => 'footer_general',
        'default'  => 1,
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_bg',
        'label'    => esc_html__('Footer Background', 'grandtour' ),
        'section'  => 'footer_color',
	    'priority' => 1,
	    'default'  => '#000000',
	    'output' => array(
	        array(
	            'element'  => '.footer_bar, #footer, .tour_recently_view',
	            'property' => 'background-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer_bar, #footer, .tour_recently_view',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_font_color',
        'label'    => esc_html__('Footer Font Color', 'grandtour' ),
        'section'  => 'footer_color',
        'default'  => '#cccccc',
        'output' => array(
	        array(
	            'element'  => '#footer, #copyright, #footer_menu li a, #footer_menu li a:hover, #footer_menu li a:active',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_link_color',
        'label'    => esc_html__('Footer Link Color', 'grandtour' ),
        'section'  => 'footer_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#copyright a, #copyright a:active, #footer a, #footer a:active, #footer .sidebar_widget li h2.widgettitle, .tour_recently_view h3.sub_title',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '#copyright a, #copyright a:active, #footer a, #footer a:active, #footer .sidebar_widget li h2.widgettitle, .tour_recently_view h3.sub_title',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_hover_link_color',
        'label'    => esc_html__('Footer Hover Link Color', 'grandtour' ),
        'section'  => 'footer_color',
        'default'  => '#1EC6B6',
        'output' => array(
	        array(
	            'element'  => '#copyright a:hover, #footer a:hover, .social_wrapper ul li a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_border_color',
        'label'    => esc_html__('Footer Border Color', 'grandtour' ),
        'section'  => 'footer_color',
        'default'  => '#222222',
        'output' => array(
	        array(
	            'element'  => '.footer_bar_wrapper, .footer_bar, .tour_recently_view h3.sub_title, .tour_recently_view',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer_bar_wrapper, .footer_bar, .tour_recently_view h3.sub_title, .tour_recently_view',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_social_color',
        'label'    => esc_html__('Footer Social Icon Color', 'grandtour' ),
        'section'  => 'footer_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.footer_bar_wrapper .social_wrapper ul li a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'textarea',
        'settings'  => 'tg_footer_copyright_text',
        'label'    => esc_html__('Copyright Text', 'grandtour' ),
        'description' => esc_html__('Enter your copyright text.', 'grandtour' ),
        'section'  => 'footer_copyright',
        'default'  => '© Copyright Grand Tour Theme Demo - Theme by ThemeGoods',
        'transport' 	 => 'postMessage',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_footer_copyright_right_area',
        'label'    => esc_html__('Copyright Right Area Content', 'grandtour' ),
        'section'  => 'footer_copyright',
        'default'  => 'menu',
        'choices'  => $tg_copyright_content,
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_footer_copyright_totop',
        'label'    => esc_html__('Go To Top Button', 'grandtour' ),
        'description' => 'Check this option to enable go to top button at the bottom of page when scrolling',
        'section'  => 'footer_copyright',
        'default'  => 1,
	    'priority' => 7,
    );
    //End Footer Tab Settings
    
    
    //Begin Gallery Tab Settings
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_gallery_global_title',
        'label'    => esc_html__('Global Settings', 'grandtour' ),
        'section'  => 'gallery_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_gallery_sort',
        'label'    => esc_html__('Gallery Images Sorting', 'grandtour' ),
        'description' => 'Select gallery images sorting options',
        'section'  => 'gallery_general',
        'default'  => 'drag',
        'choices'  => $tg_gallery_sort,
	    'priority' => 1,
    );
            
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_lightbox_skin',
        'label'    => esc_html__('Select lightbox skin color', 'grandtour' ),
        'description' => esc_html__('Select which skin you want to use for lightbox', 'grandtour' ),
        'section'  => 'gallery_lightbox',
        'default'  => 'metro-black',
        'choices'  => $tg_lightbox_skin,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_lightbox_enable_caption',
        'label'    => esc_html__('Display image caption in lightbox', 'grandtour' ),
        'description' => esc_html__('Check if you want to display image caption under the image in lightbox mode', 'grandtour' ),
        'section'  => 'gallery_lightbox',
        'default'  => 1,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_lightbox_thumbnails',
        'label'    => esc_html__('Select lightbox thumbnails alignment', 'grandtour' ),
        'description' => esc_html__('Select which alignment you want to use for lightbox thumbnails', 'grandtour' ),
        'section'  => 'gallery_lightbox',
        'default'  => 'horizontal',
        'choices'  => $tg_lightbox_thumbnails,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_lightbox_opacity',
        'label'    => esc_html__('Lightbox Overlay Opacity', 'grandtour' ),
        'section'  => 'gallery_lightbox',
        'default'  => 80,
        'choices' => array( 'min' => 0, 'max' => 100, 'step' => 5 ),
	    'priority' => 1,
    );
    
    //End Gallery Tab Settings
    
    
    //Begin Portfolio Tab Settings
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_tour_currency_title',
        'label'    => esc_html__('Currency Settings', 'grandtour' ),
        'section'  => 'tour_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_tour_currency',
        'label'    => esc_html__('Currency', 'grandtour' ),
        'description' => esc_html__('Enter default tour pricing currency.', 'grandtour' ),
        'section'  => 'tour_general',
        'default'  => '$',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_tour_currency_display',
        'label'    => esc_html__('Currency Display', 'grandtour' ),
        'description' => esc_html__('Select how currency display between tour price', 'grandtour' ),
        'section'  => 'tour_general',
        'default'  => 'before',
        'choices'  => array(
	        'before' => 'Before price',
	        'after' => 'After price',
        ),
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_tour_currency_thousand_sep',
        'label'    => esc_html__('Thousand Separator', 'grandcarrental' ),
        'description' => esc_html__('Enter thousand separator of displayed price.', 'grandcarrental' ),
        'section'  => 'tour_general',
        'default'  => ',',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_tour_currency_decimal_sep',
        'label'    => esc_html__('Decimal Separator', 'grandcarrental' ),
        'description' => esc_html__('Enter decimal separator of displayed price.', 'grandcarrental' ),
        'section'  => 'tour_general',
        'default'  => '.',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_tour_currency_decimal_number',
        'label'    => esc_html__('Number of Separator', 'grandcarrental' ),
        'description' => esc_html__('Enter number of decimal points for displayed price.', 'grandcarrental' ),
        'section'  => 'tour_general',
        'default'  => 0,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_car_general_other',
        'label'    => esc_html__('Other Settings', 'grandcarrental' ),
        'section'  => 'tour_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_recently_view',
        'label'    => esc_html__('Enable Recently View Tours', 'grandtour' ),
        'description' => esc_html__('Check this option to enable recently view tours before footer', 'grandtour' ),
        'section'  => 'tour_general',
        'default'  => 0,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_advanced_search',
        'label'    => esc_html__('Enable Advanced Search', 'grandtour' ),
        'description' => esc_html__('Check this option to enable advanced search options for tour search form', 'grandtour' ),
        'section'  => 'tour_general',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_tour_search_margintop',
        'label'    => esc_html__('Default Tour Search Form Margin Top', 'grandtour' ),
        'section'  => 'tour_general',
        'default'  => 0,
        'choices' => array( 'min' => -200, 'max' => 200, 'step' => 5 ),
	    'priority' => 1,
	    'transport' => 'postMessage',
	    'output'   => array(
			array(
				'element'  => '#tour_search_form',
				'function' => 'css',
				'property' => 'margin-top',
				'units'    => 'px',
			),
		),
	    'js_vars'   => array(
			array(
				'element'  => '#tour_search_form',
				'function' => 'css',
				'property' => 'margin-top',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_tour_single_general_title',
        'label'    => esc_html__('General Settings', 'grandtour' ),
        'section'  => 'tour_single',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_single_header',
        'label'    => esc_html__('Display Tour Header Content', 'grandtour' ),
        'description' => esc_html__('Check this option to display tour header content in single tour page', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_single_review',
        'label'    => esc_html__('Enable Tour Review', 'grandtour' ),
        'description' => esc_html__('Check this option to enable tour review', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_single_share',
        'label'    => esc_html__('Enable Tour Sharing', 'grandtour' ),
        'description' => esc_html__('Check this option to enable tour sharing', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_tour_display_related',
        'label'    => esc_html__('Display Related Tours', 'grandtour' ),
        'description' => esc_html__('Check this option to display related tours on single tour page', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => 1,
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_tour_related_layout',
        'label'    => esc_html__('Related Tours Layouts', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => '3',
        'choices'  => $tg_single_tour_related_layout,
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_tour_map_marker',
        'label'    => esc_html__('Map Marker', 'grandtour' ),
        'description' => esc_html__('Select map marker for tour map address', 'grandtour' ),
        'section'  => 'tour_single',
	    'default'  => get_template_directory_uri().'/cache/map_marker.png',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_tour_single_mobile_title',
        'label'    => esc_html__('Mobile Settings', 'grandtour' ),
        'section'  => 'tour_single',
	    'priority' => 10,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_tour_single_mobile_content',
        'label'    => esc_html__('Content and Sidebar', 'grandtour' ),
        'section'  => 'tour_single',
        'default'  => 'booking',
        'choices'  => $tg_single_tour_content,
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_destination_single_tour_order',
        'label'    => esc_html__('Display Destination related tours before or after its content', 'grandtour' ),
        'section'  => 'destination_single',
        'default'  => 'before',
        'choices'  => $tg_single_destination_tour_content,
	    'priority' => 11,
    );
    //End Portfolio Tab Settings
    
    
    //Begin Blog Tab Settings
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_full',
        'label'    => esc_html__('Display Full Blog Post Content', 'grandtour' ),
        'description' => esc_html__('Check this option to display post full content in blog page (excerpt blog grid layout)', 'grandtour' ),
        'section'  => 'blog_general',
        'default'  => 0,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_archive_layout',
        'label'    => esc_html__('Archive Page Layout', 'grandtour' ),
        'description' => esc_html__('Select page layout for displaying archive page', 'grandtour' ),
        'section'  => 'blog_general',
        'default'  => 'blog_r',
        'choices'  => $tg_blog_layout,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_category_layout',
        'label'    => esc_html__('Category Page Layout', 'grandtour' ),
        'description' => esc_html__('Select page layout for displaying category page', 'grandtour' ),
        'section'  => 'blog_general',
        'default'  => 'blog_r',
        'choices'  => $tg_blog_layout,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_tag_layout',
        'label'    => esc_html__('Tag Page Layout', 'grandtour' ),
        'description' => esc_html__('Select page layout for displaying tag page', 'grandtour' ),
        'section'  => 'blog_general',
        'default'  => 'blog_r',
        'choices'  => $tg_blog_layout,
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_feat_content',
        'label'    => esc_html__('Display Post Featured Content', 'grandtour' ),
        'description' => esc_html__('Check this to display featured content (image or gallery) in single post page', 'grandtour' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_tags',
        'label'    => esc_html__('Display Post Tags', 'grandtour' ),
        'description' => esc_html__('Check this option to display post tags on single post page', 'grandtour' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_author',
        'label'    => esc_html__('Display About Author', 'grandtour' ),
        'description' => esc_html__('Check this option to display about author on single post page', 'grandtour' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_related',
        'label'    => esc_html__('Display Related Posts', 'grandtour' ),
        'description' => esc_html__('Check this option to display related posts on single post page', 'grandtour' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 8,
    );
    //End Blog Tab Settings
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		//Begin Shop Tab Settings
		$controls[] = array(
	        'type'     => 'radio-buttonset',
	        'settings'  => 'tg_shop_layout',
	        'label'    => esc_html__('Shop Main Page Layout', 'grandtour' ),
	        'description' => esc_html__('Select page layout for displaying shop\'s products page', 'grandtour' ),
	        'section'  => 'shop_layout',
	        'default'  => 'fullwidth',
	        'choices'  => $tg_shop_layout,
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'slider',
	        'settings'  => 'tg_shop_items',
	        'label'    => esc_html__('Products Page Show At Most', 'grandtour' ),
	        'description' => esc_html__('Select number of product items you want to display per page', 'grandtour' ),
	        'section'  => 'shop_layout',
	        'default'  => 16,
	        'choices' => array( 'min' => 1, 'max' => 100, 'step' => 1 ),
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_price_font_color',
	        'label'    => esc_html__('Product Price Font Color', 'grandtour' ),
	        'section'  => 'shop_single',
	        'default'  => '#FF4A52',
	        'output' => array(
		        array(
		            'element'  => '.woocommerce ul.products li.product .price ins, .woocommerce-page ul.products li.product .price ins, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, p.price ins span.amount, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_shop_related_products',
	        'label'    => esc_html__('Display Related Products', 'grandtour' ),
	        'description' => esc_html__('Check this option to display related products on single product page', 'grandtour' ),
	        'section'  => 'shop_single',
	        'default'  => 1,
		    'priority' => 3,
	    );
		//End Shop Tab Settings
	}

    return $controls;
}
add_filter( 'kirki/controls', 'grandtour_custom_setting' );


function grandtour_customize_preview()
{
?>
    <script type="text/javascript">
        ( function( $ ) {
        	//Register Logo Tab Settings
        	wp.customize('tg_retina_logo',function( value ) {
                value.bind(function(to) {
                    jQuery('#custom_logo img').attr('src', to );
                });
            });
        	//End Logo Tab Settings
        
			//Register General Tab Settings
            wp.customize('tg_body_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, textarea').css('fontFamily', to );
                });
            });
            
            wp.customize('tg_body_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, input[type=submit], input[type=button], a.button, .button').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_header_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('h1, h2, h3, h4, h5, h6, h7, .post_quote_title, label, strong[itemprop="author"], #page_content_wrapper .posts.blog li a, .page_content_wrapper .posts.blog li a, .readmore, .post_detail.single_post, .page_tagline, #gallery_caption .tg_caption .tg_desc, #filter_selected, #autocomplete li strong, .post_detail.single_post a, .post_detail.single_post a:hover,.post_detail.single_post a:active, blockquote,.single_tour_price, .single_tour_departure_wrapper li .single_tour_departure_title, .comment_rating_wrapper .comment_rating_label, .tour_excerpt, .widget_post_views_counter_list_widget, .sidebar_widget li.widget_products, #copyright, #footer_menu li a, #footer ul.sidebar_widget li ul.posts.blog li a, .woocommerce-page table.cart th, table.shop_table thead tr th, .tour_price, p.price span.amount, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a, .woocommerce ul.products li.product .price').css('fontFamily', to );
                });
            });
            
            wp.customize('tg_h1_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h1').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_h2_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h2').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_h3_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h3').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_h4_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h4').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_h5_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h5').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_h6_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h6').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_content_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('body, #wrapper, #page_content_wrapper.fixed, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, #body_loading_screen, h3#reply-title span, .overlay_gallery_wrapper, .pricing_wrapper_border, .pagination a, .pagination span, #captcha-wrap .text-box input, .flex-direction-nav a, .blog_promo_title h6, #supersized li, #gallery_caption .tg_caption, #tour_search_form, .tour_search_form').css('background-color', to );
                });
            });
            
            wp.customize('tg_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('body, .pagination a, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, .post_info a, #page_content_wrapper.split #copyright, .page_content_wrapper.split #copyright, .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, .readmore, #page_content_wrapper .inner .sidebar_wrapper .sidebar .single_tour_booking_wrapper label, .woocommerce-MyAccount-navigation ul a').css('color', to );
                    jQuery('::selection').css('background-color', to );
                    jQuery('::-webkit-input-placeholder').css('color', to );
                    jQuery('::-moz-placeholder').css('color', to );
                    jQuery(':-ms-input-placeholder').css('color', to );
                });
            });
            
            wp.customize('tg_h1_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('h1, h2, h3, h4, h5, pre, code, tt, blockquote, .post_header h5 a, .post_header h3 a, .post_header.grid h6 a, .post_header.fullwidth h4 a, .post_header h5 a, blockquote, .site_loading_logo_item i, .woocommerce .woocommerce-ordering select, .woocommerce #page_content_wrapper a.button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button:hover, .tabs .ui-state-active a, body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active a, body.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .post_header h5 a, .post_header h6 a, .flex-direction-nav a:before, .social_share_button_wrapper .social_post_view .view_number, .social_share_button_wrapper .social_post_share_count .share_number, .portfolio_post_previous a, .portfolio_post_next a, #autocomplete li strong, .post_detail.single_post a, .post_detail.single_post a:hover,.post_detail.single_post a:active, .single_tour_departure_wrapper li .single_tour_departure_title, .cart_item .product-name a, .single_tour_booking_wrapper .single_tour_view_desc, .single_tour_booking_wrapper .single_tour_view_icon, .tour_product_variable_title').css('color', to );
                    
                    jQuery('body.page.page-template-gallery-archive-split-screen-php #fp-nav li .active span, body.tax-gallerycat #fp-nav li .active span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav li .active span, body.page.tax-portfolioset #fp-nav li .active span, body.page.page-template-gallery-archive-split-screen-php #fp-nav ul li a span, body.tax-gallerycat #fp-nav ul li a span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav ul li a span, body.page.tax-portfolioset #fp-nav ul li a span').css('backgroundColor', to );
                });
            });
            
            wp.customize('tg_input_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], textarea, select').css('background-color', to );
                });
            });
            
            wp.customize('tg_input_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], textarea, select').css('color', to );
                });
            });
            
            wp.customize('tg_input_border_color',function( value ) {
                value.bind(function(to) {
                    jQuery('input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input[type=number], textarea, select').css('border-color', to );
                });
            });
            
            wp.customize('tg_input_focus_color',function( value ) {
                value.bind(function(to) {
                    jQuery('input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=date]:focus, input[type=number]:focus, textarea:focus, #tour_search_form .one_fourth:not(.last)').css('border-color', to );
                });
            });
            
            wp.customize('tg_button_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt').css('fontFamily', to );
                });
            });
            //End General Tab Settings
        
        	//Register Menu Tab Settings
        	wp.customize('tg_menu_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('fontFamily', to );
                });
            });
            
            wp.customize('tg_menu_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_menu_padding',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('paddingTop', to+'px' );
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('paddingBottom', to+'px' );
                });
            });
            
            wp.customize('tg_menu_weight',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('fontWeight', to );
                });
            });
            
            wp.customize('tg_menu_font_spacing',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('letterSpacing', to+'px' );
                });
            });
            
            wp.customize('tg_menu_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a').css('textTransform', to );
                });
            });
            
            wp.customize('tg_menu_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a, #menu_wrapper div .nav li > a, #page_share, #mobile_nav_icon, #logo_wrapper .social_wrapper ul li a, .header_cart_wrapper > a').css('color', to );
                });
            });
            
            wp.customize('tg_menu_hover_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li a.hover, #menu_wrapper .nav ul li a:hover, #menu_wrapper div .nav li a.hover, #menu_wrapper div .nav li a:hover, #logo_wrapper .social_wrapper ul li a:hover').css('color', to );
                });
            });
            
            wp.customize('tg_menu_active_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper div .nav > li.current-menu-item > a, #menu_wrapper div .nav > li.current-menu-parent > a, #menu_wrapper div .nav > li.current-menu-ancestor > a, #menu_wrapper div .nav li ul li.current-menu-item a, #menu_wrapper div .nav li.current-menu-parent  ul li.current-menu-item a, .header_cart_wrapper a:active, #page_share:active, #gallery_download:active, .view_fullscreen_wrapper a:active, #logo_wrapper .social_wrapper ul li a:active').css('color', to );
                    jQuery('#menu_wrapper div .nav > li.current-menu-item > a, #menu_wrapper div .nav > li.current-menu-parent > a, #menu_wrapper div .nav > li.current-menu-ancestor > a, #menu_wrapper div .nav li ul li.current-menu-item a, #menu_wrapper div .nav li.current-menu-parent  ul li.current-menu-item a').css('borderColor', to );
                });
            });
            
            wp.customize('tg_menu_border_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.top_bar, #page_caption, #nav_wrapper').css('borderColor', to );
                });
            });
            
            wp.customize('tg_submenu_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_submenu_weight',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a').css('fontWeight', to );
                });
            });
            
            wp.customize('tg_submenu_font_spacing',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a').css('letterSpacing', to+'px' );
                });
            });
            
            wp.customize('tg_submenu_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a').css('textTransform', to );
                });
            });
            
            wp.customize('tg_submenu_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a, #menu_wrapper div .nav li ul li a, #menu_wrapper div .nav li.current-menu-parent ul li a').css('color', to );
                });
            });
            
            wp.customize('tg_submenu_hover_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a:hover, #menu_wrapper div .nav li ul li a:hover, #menu_wrapper div .nav li.current-menu-parent ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:hover, #menu_wrapper div .nav li.megamenu ul li ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:active, #menu_wrapper div .nav li.megamenu ul li ul li a:active').css('color', to );
                });
            });
            
            wp.customize('tg_submenu_hover_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul li a:hover, #menu_wrapper div .nav li ul li a:hover, #menu_wrapper div .nav li.current-menu-parent ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:hover, #menu_wrapper div .nav li.megamenu ul li ul li a:hover, #menu_wrapper .nav ul li.megamenu ul li ul li a:active, #menu_wrapper div .nav li.megamenu ul li ul li a:active').css('background', to );
                });
            });
            
            wp.customize('tg_submenu_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul, #menu_wrapper div .nav li ul').css('background', to );
                });
            });
            
            wp.customize('tg_submenu_border_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper .nav ul li ul, #menu_wrapper div .nav li ul').css('borderColor', to );
                });
            });
            
            wp.customize('tg_megamenu_header_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper div .nav li.megamenu ul li > a, #menu_wrapper div .nav li.megamenu ul li > a:hover, #menu_wrapper div .nav li.megamenu ul li > a:active, #menu_wrapper div .nav li.megamenu ul li.current-menu-item > a').css('color', to );
                });
            });
            
            wp.customize('tg_megamenu_border_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#menu_wrapper div .nav li.megamenu ul li').css('borderColor', to );
                });
            });
            
            wp.customize('tg_topbar_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.above_top_bar').css('background', to );
                });
            });
            
            wp.customize('tg_topbar_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#top_menu li a, .top_contact_info, .top_contact_info i, .top_contact_info a, .top_contact_info a:hover, .top_contact_info a:active').css('color', to );
                });
            });
            
            wp.customize('tg_menu_contact_hours',function( value ) {
                value.bind(function(to) {
                    jQuery('#top_contact_hours').html('<i class="fa fa-clock-o"></i>'+to);
                });
            });
            
            wp.customize('tg_menu_contact_number',function( value ) {
                value.bind(function(to) {
                    jQuery('#top_contact_number').html('<i class="fa fa-phone"></i>'+to);
                });
            });
            
            wp.customize('tg_menu_search_input_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_menu_wrapper #searchform').css('background', to );
                });
            });
            
            wp.customize('tg_menu_search_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_menu_wrapper #searchform input[type=text], .mobile_menu_wrapper #searchform button i, #close_mobile_menu i').css('color', to );
                    jQuery('.mobile_menu_wrapper #searchform ::-webkit-input-placeholder').css('color', to );
                    jQuery('.mobile_menu_wrapper #searchform ::-moz-placeholder').css('color', to );
                    jQuery('.mobile_menu_wrapper #searchform :-ms-input-placeholder').css('color', to );
                });
            });
            
            wp.customize('tg_sidemenu_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('.mobile_main_nav li a, #sub_menu li a').css('fontFamily', to );
                });
            });
            
            wp.customize('tg_sidemenu_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_main_nav li a, #sub_menu li a').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_sidemenu_font_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_main_nav li a, #sub_menu li a').css('textTransform', to );
                });
            });
            
            wp.customize('tg_sidemenu_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_main_nav li a, #sub_menu li a, .mobile_menu_wrapper .sidebar_wrapper a, #close_mobile_menu, .mobile_menu_wrapper .social_wrapper ul li a, html[data-menu=hammenufull] #copyright').css('color', to );
                });
            });
            
            wp.customize('tg_submenu_hover_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.mobile_main_nav li a:hover, .mobile_main_nav li a:active, #sub_menu li a:active, .mobile_menu_wrapper .sidebar_wrapper h2.widgettitle, .mobile_menu_wrapper .social_wrapper ul li a:hover').css('color', to );
                });
            });
            //End Menu Tab Settings
            
            
            //Register Header Tab Settings 
        	wp.customize('tg_page_header_bg_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption, .page_caption_bg_content, .overlay_gallery_content').css('background-color', to );
                    jQuery('.page_caption_bg_border, .overlay_gallery_border').css('border-color', to );
                });
            });
            
            wp.customize('tg_page_header_padding_top',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption').css('paddingTop', to+'px' );
                });
            });
            
            wp.customize('tg_page_header_padding_bottom',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption').css('paddingBottom', to+'px' );
                });
            });
            
            wp.customize('tg_page_title_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption h1, .post_caption h1').css('color', to );
                });
            });
            
            wp.customize('tg_page_title_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption h1, .post_caption h1').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_page_title_font_weight',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption h1, .post_caption h1').css('fontWeight', to );
                });
            });
            
            wp.customize('tg_page_title_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption h1, .post_caption h1').css('textTransform', to );
                });
            });
            
            wp.customize('tg_page_title_bg_height',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_caption.hasbg').css('height', to+'vh' );
                });
            });
            
            wp.customize('tg_header_builder_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('h2.ppb_title').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_header_builder_font_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('h2.ppb_title').css('textTransform', to );
                });
            });
            
            wp.customize('tg_page_tagline_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('.portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_page_tagline_font_weight',function( value ) {
                value.bind(function(to) {
                    jQuery('.page_tagline,.portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company').css('fontWeight', to );
                });
            });
            
            wp.customize('tg_page_tagline_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('.portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company').css('textTransform', to );
                });
            });
            
            wp.customize('tg_page_tagline_font_spacing',function( value ) {
                value.bind(function(to) {
                    jQuery('.portfolio_desc .portfolio_excerpt, .testimonial_customer_position, .testimonial_customer_company').css('letterSpacing', to+'px' );
                });
            });
        	//End Logo Header Settings
        	
        	//Register Sidebar Tab Settings
            wp.customize('tg_sidebar_title_font',function( value ) {
                value.bind(function(to) {
                	var ppGGFont = 'http://fonts.googleapis.com/css?family='+to;
                	if(jQuery('#google_fonts_'+to).length===0)
                	{
			    		jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+to+'" href="'+ppGGFont+'" type="text/css" media="all">');
			    	}
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('fontFamily', to );
                });
            });
            
            wp.customize('tg_sidebar_title_font_size',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('fontSize', to+'px' );
                });
            });
            
            wp.customize('tg_sidebar_title_font_weight',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('fontWeight', to );
                });
            });
            
            wp.customize('tg_sidebar_title_transform',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('textTransform', to );
                });
            });
            
            wp.customize('tg_sidebar_title_font_spacing',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('letterSpacing', to+'px' );
                });
            });
            
            wp.customize('tg_sidebar_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .inner .sidebar_wrapper .sidebar .content, .page_content_wrapper .inner .sidebar_wrapper .sidebar .content').css('color', to );
                });
            });
            
            wp.customize('tg_sidebar_link_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .inner .sidebar_wrapper a:not(.button), .page_content_wrapper .inner .sidebar_wrapper a:not(.button)').css('color', to );
                });
            });
            
            wp.customize('tg_sidebar_hover_link_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .inner .sidebar_wrapper a:hover, #page_content_wrapper .inner .sidebar_wrapper a:active, .page_content_wrapper .inner .sidebar_wrapper a:hover, .page_content_wrapper .inner .sidebar_wrapper a:active').css('color', to );
                });
            });
            
            wp.customize('tg_sidebar_title_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#page_content_wrapper .sidebar .content .sidebar_widget li h2.widgettitle, h2.widgettitle, h5.widgettitle').css('color', to );
                });
            });
            //End Sidebar Tab Settings
            
            //Register Footer Tab Settings
            
            wp.customize('tg_footer_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#footer, #copyright, #footer_menu li a, #footer_menu li a:hover, #footer_menu li a:active').css('color', to );
                });
            });
            });
            
            wp.customize('tg_footer_hover_link_color',function( value ) {
                value.bind(function(to) {
                    jQuery('#copyright a:hover, #footer a:hover, .social_wrapper ul li a:hover').css('color', to );
                });
            });
            
            wp.customize('tg_footer_social_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.footer_bar_wrapper .social_wrapper ul li a').css('color', to );
                });
            });
            
            wp.customize('tg_footer_copyright_text',function( value ) {
                value.bind(function(to) {
                    jQuery('#copyright').html( to );
                });
            });
            //End Footer Tab Settings
            
            
            //Register Shop Tab Settings
             wp.customize('tg_shop_price_font_color',function( value ) {
                value.bind(function(to) {
                    jQuery('.woocommerce ul.products li.product .price ins, .woocommerce-page ul.products li.product .price ins, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, p.price ins span.amount, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price').css( 'color', to );
                });
            });
            //End Shop Tab Settings
        } )( jQuery )
    </script>
<?php	
}
