<?php
if ( function_exists( 'add_theme_support' ) ) {
	// Setup thumbnail support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background' );
}

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'grandtour-gallery-grid', 700, 466, true );
	add_image_size( 'grandtour-gallery-list', 500, 500, true );
	add_image_size( 'grandtour-blog', 960, 636, true );
}

add_action( 'after_setup_theme', 'grandtour_woocommerce_support' );

function grandtour_woocommerce_support() {
    	add_theme_support( 'woocommerce' );
}

add_filter('wp_get_attachment_image_attributes', 'grandtour_responsive_image_fix');

function grandtour_responsive_image_fix($attr) {
    if (isset($attr['sizes'])) unset($attr['sizes']);
    if (isset($attr['srcset'])) unset($attr['srcset']);
    return $attr;
}

add_filter('wp_calculate_image_sizes', '__return_false', PHP_INT_MAX);
add_filter('wp_calculate_image_srcset', '__return_false', PHP_INT_MAX);

/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'flush_rewrite_rules' );
?>
