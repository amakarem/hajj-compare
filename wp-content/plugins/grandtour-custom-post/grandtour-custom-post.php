<?php
/*
Plugin Name: Grand Tour Theme Custom Post Type
Plugin URI: http://themes.themegoods2.com/grandtour/demo/
Description: Plugin that will create custom post types for Grand Tour theme.
Version: 2.1
Author: ThemeGoods
Author URI: http://themeforest.net/user/ThemeGoods
License: GPLv2
*/

//Setup translation string via PO file

add_action('plugins_loaded', 'grandtour_load_textdomain');
function grandtour_load_textdomain() 
{
	load_plugin_textdomain( 'grandtour-custom-post', FALSE, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

function post_type_galleries() {
	$labels = array(
    	'name' => esc_html__('Galleries', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Gallery', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Gallery', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Gallery', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Gallery', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Gallery', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Gallery', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Gallery', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Gallery found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Gallery found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title', 'excerpt' ),
    	'menu_icon' => ''
	); 		

	register_post_type( 'galleries', $args );
	
  	$labels = array(			  
  	  'name' => esc_html__( 'Gallery Categories', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Gallery Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Search Gallery Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Gallery Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Gallery Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Gallery Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Gallery Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Gallery Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Gallery Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Gallery Category Name', 'grandtour-custom-post' ),
  	); 							  	  
  	
  	register_taxonomy(
		'gallerycat',
		'galleries',
		array(
			'public'=>true,
			'hierarchical' => false,
			'labels'=> $labels,
			'query_var' => 'gallerycat',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'gallerycat', 'with_front' => false ),
		)
	);	
} 
								  
add_action('init', 'post_type_galleries');


function post_type_tours() {
	$labels = array(
    	'name' => esc_html__('Tours', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Tour', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Tour', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Tour', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Tour', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Tour', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Tour', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Tours', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Tour found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Tour found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail', 'excerpt', 'comments'),
    	'menu_icon' => ''
	); 		

	register_post_type( 'tour', $args );
	
  	$labels = array(			  
  	  'name' => esc_html__( 'Tour Categories', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Tour Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Search Tour Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Tour Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Tour Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Tour Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Tour Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Tour Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Tour Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Tour Category Name', 'grandtour-custom-post' ),
  	); 							  
  	
  	register_taxonomy(
		'tourcat',
		'tour',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'tourcat',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'tourcat', 'with_front' => false ),
		)
	);		  
}
								  
add_action('init', 'post_type_tours');

add_action( 'init', 'create_tour_tag_taxonomies', 0 );

//create two taxonomies, genres and tags for the post type "tag"
function create_tour_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tour Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tour Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tour Tags' ),
    'popular_items' => __( 'Popular Tour Tags' ),
    'all_items' => __( 'All Tour Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tour Tag' ), 
    'update_item' => __( 'Update Tour Tag' ),
    'add_new_item' => __( 'Add New Tour Tag' ),
    'new_item_name' => __( 'New Tour Tag Name' ),
    'separate_items_with_commas' => __( 'Separate tour tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tour tags' ),
    'choose_from_most_used' => __( 'Choose from the most used tour tags' ),
    'menu_name' => __( 'Tour Tags' ),
  ); 

  register_taxonomy('tourtag','tour',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_menu' => false,
    'show_in_nav_menus' => false,
    'show_in_rest' => false,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tourtag' ),
  ));
}

function post_type_destination() {
	$labels = array(
    	'name' => esc_html__('Destinations', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Destination', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Destination', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Destination', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Destination', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Destination', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Destination', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Destination', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Destination found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Destination found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
    	'menu_icon' => ''
	); 		

	register_post_type( 'destination', $args );
	
  	$labels = array(			  
  	  'name' => esc_html__( 'Destinations Category', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Destination Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Search Destination Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Destination Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Destination Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Destination Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Destination Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Destination Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Destination Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Destination Category Name', 'grandtour-custom-post' ),
  	); 							  	  
  	
  	register_taxonomy(
		'destinationcat',
		'destination',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'destinationcat',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'destinationcat', 'with_front' => false ),
		)
	);	
} 
								  
add_action('init', 'post_type_destination');

function post_type_testimonials() {
	$labels = array(
    	'name' => esc_html__('Testimonials', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Testimonial', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Testimonial', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Testimonial', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Testimonial', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Testimonial', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Testimonial', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Testimonial', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Testimonial found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Testimonial found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title', 'editor', 'thumbnail'),
    	'menu_icon' => ''
	); 		

	register_post_type( 'testimonials', $args );
	
	$labels = array(			  
  	  'name' => esc_html__( 'Testimonial Categories', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Testimonial Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Search Testimonial Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Testimonial Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Testimonial Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Testimonial Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Testimonial Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Testimonial Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Testimonial Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Testimonial Category Name', 'grandtour-custom-post' ),
  	); 							  
  	
  	register_taxonomy(
		'testimonialcats',
		'testimonials',
		array(
			'public'=>true,
			'hierarchical' => false,
			'labels'=> $labels,
			'query_var' => 'testimonialcats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'testimonialcats', 'with_front' => false ),
		)
	);		  
} 
								  
add_action('init', 'post_type_testimonials');


function post_type_team() {
	$labels = array(
    	'name' => esc_html__('Team Members', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Team Member', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Team Member', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Team Member', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Team Member', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Team Member', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Team Member', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Team Members', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Team Member found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Team Member found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail'),
    	'menu_icon' => ''
	); 		

	register_post_type( 'team', $args );
	
	$labels = array(			  
  	  'name' => esc_html__( 'Team Categories', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Team Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Team Service Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Team Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Team Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Team Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Team Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Team Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Team Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Team Category Name', 'grandtour-custom-post' ),
  	); 							  
  	
  	register_taxonomy(
		'teamcats',
		'team',
		array(
			'public'=>true,
			'hierarchical' => false,
			'labels'=> $labels,
			'query_var' => 'teamcats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'teamcats', 'with_front' => false ),
		)
	);
}
add_action('init', 'post_type_team');


function post_type_pricing() {
	$labels = array(
    	'name' => esc_html__('Pricing', 'post type general name', 'grandtour-custom-post'),
    	'singular_name' => esc_html__('Pricing', 'post type singular name', 'grandtour-custom-post'),
    	'add_new' => esc_html__('Add New Pricing', 'book', 'grandtour-custom-post'),
    	'add_new_item' => esc_html__('Add New Pricing', 'grandtour-custom-post'),
    	'edit_item' => esc_html__('Edit Pricing', 'grandtour-custom-post'),
    	'new_item' => esc_html__('New Pricing', 'grandtour-custom-post'),
    	'view_item' => esc_html__('View Pricing', 'grandtour-custom-post'),
    	'search_items' => esc_html__('Search Pricings', 'grandtour-custom-post'),
    	'not_found' =>  esc_html__('No Pricing found', 'grandtour-custom-post'),
    	'not_found_in_trash' => esc_html__('No Pricing found in Trash', 'grandtour-custom-post'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title'),
    	'menu_icon' => ''
	); 		

	register_post_type( 'pricing', $args );
	
	$labels = array(			  
  	  'name' => esc_html__( 'Pricing Categories', 'taxonomy general name', 'grandtour-custom-post' ),
  	  'singular_name' => esc_html__( 'Pricing Category', 'taxonomy singular name', 'grandtour-custom-post' ),
  	  'search_items' =>  esc_html__( 'Pricing Service Categories', 'grandtour-custom-post' ),
  	  'all_items' => esc_html__( 'All Pricing Categories', 'grandtour-custom-post' ),
  	  'parent_item' => esc_html__( 'Parent Pricing Category', 'grandtour-custom-post' ),
  	  'parent_item_colon' => esc_html__( 'Parent Pricing Category:', 'grandtour-custom-post' ),
  	  'edit_item' => esc_html__( 'Edit Pricing Category', 'grandtour-custom-post' ), 
  	  'update_item' => esc_html__( 'Update Pricing Category', 'grandtour-custom-post' ),
  	  'add_new_item' => esc_html__( 'Add New Pricing Category', 'grandtour-custom-post' ),
  	  'new_item_name' => esc_html__( 'New Pricing Category Name', 'grandtour-custom-post' ),
  	); 							  
  	
  	register_taxonomy(
		'pricingcats',
		'pricing',
		array(
			'public'=>true,
			'hierarchical' => false,
			'labels'=> $labels,
			'query_var' => 'pricingcats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'pricingcats', 'with_front' => false ),
		)
	);
}
add_action('init', 'post_type_pricing');


add_filter( 'manage_posts_columns', 'rt_add_gravatar_col');
function rt_add_gravatar_col($cols) {
	$cols['thumbnail'] = esc_html__('Thumbnail', 'grandtour-custom-post');
	return $cols;
}

add_action( 'manage_posts_custom_column', 'rt_get_author_gravatar');
function rt_get_author_gravatar($column_name ) {
	if ( $column_name  == 'thumbnail'  ) {
		echo get_the_post_thumbnail(get_the_ID(), array(100, 100));
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
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->ID] = $gallery->post_title;
}

/*
	Get tour list
*/
$args = array(
    'numberposts' => -1,
    'post_type' => array('tour'),
);

$tours_arr = get_posts($args);
$tours_select = array();

foreach($tours_arr as $tour)
{
	$tours_select[$tour->ID] = $tour->post_title;
}

/*
	Get post layouts
*/
$post_layout_select = array();
$post_layout_select = array(
	'With Right Sidebar' => 'With Right Sidebar',
	'With Left Sidebar' => 'With Left Sidebar',
	'Fullwidth' => 'Fullwidth',
);

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

if (function_exists('grandtour_get_months')) 
{
	$available_months = grandtour_get_months();
}
else
{
	$available_months = array(
		"january" 	=> esc_html__('January', 'grandtour-custom-post' ),
		"february" 	=> esc_html__('February', 'grandtour-custom-post' ),
		"march" 	=> esc_html__('March', 'grandtour-custom-post' ),
		"april" 	=> esc_html__('April', 'grandtour-custom-post' ),
		"may" 		=> esc_html__('May', 'grandtour-custom-post' ),
		"june" 		=> esc_html__('June', 'grandtour-custom-post' ),
		"july" 		=> esc_html__('July', 'grandtour-custom-post' ),
		"august" 	=> esc_html__('August', 'grandtour-custom-post' ),
		"september" => esc_html__('September', 'grandtour-custom-post' ),
		"october" 	=> esc_html__('October', 'grandtour-custom-post' ),
		"november" 	=> esc_html__('November', 'grandtour-custom-post' ),
		"december" 	=> esc_html__('December', 'grandtour-custom-post' ),
	);
}

if (function_exists('grandtour_get_days')) 
{
	$available_days = grandtour_get_days();
}
else
{
	$available_days = array(
		"monday" 		=> esc_html__('Monday', 'grandtour-custom-post' ),
		"tuesday" 		=> esc_html__('Tuesday', 'grandtour-custom-post' ),
		"wednesday" 	=> esc_html__('Wednesday', 'grandtour-custom-post' ),
		"thursday" 		=> esc_html__('Thursday', 'grandtour-custom-post' ),
		"friday" 		=> esc_html__('Friday', 'grandtour-custom-post' ),
		"saturday" 		=> esc_html__('Saturday', 'grandtour-custom-post' ),
		"sunday" 		=> esc_html__('Sunday', 'grandtour-custom-post' ),
	);
}

$single_tour_layouts = array(
	"Sidebar" 			=> 'Sidebar',
	"Fullwidth" 		=> 'Fullwidth'
);

//Get contact form 7 form list
$contactform7_arr = array();

//Check if contact form 7 plugin is installed	
$contactform7_plugin_path = 'contact-form-7/wp-contact-form-7.php';

if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$contactform7_activated = is_plugin_active($contactform7_plugin_path);
if($contactform7_activated)
{
	$contactform7_obj_arr = WPCF7_ContactForm::find($args);
	
	if(!empty($contactform7_obj_arr) && is_array($contactform7_obj_arr))
	{
		foreach($contactform7_obj_arr as $contactform7_obj)
		{
			$contactform7_id = $contactform7_obj->id();
			$contactform7_title = $contactform7_obj->title();
			
			$contactform7_arr[$contactform7_id] = $contactform7_title;
		}
	}
}

//Get woocommerce product list
$woocommerce_product_arr = array();

//Check if woocommerce plugin is installed	
$woocommerce_plugin_path = 'woocommerce/woocommerce.php';

if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$woocommerce_activated = is_plugin_active($woocommerce_plugin_path);
if($woocommerce_activated)
{
	$args = array( 'post_type' => 'product', 'posts_per_page' => -1, 'suppress_filters' => false );

    $products_arr = get_posts( $args );

    if(!empty($products_arr) && is_array($products_arr))
	{
		foreach($products_arr as $products_obj)
		{
			$woocommerce_product_arr[$products_obj->ID] = $products_obj->post_title;
		}
	}
}

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
	Begin creating custom fields
*/

$postmetas = 
	array (
		'post' => array(
			array("section" => "Content Type", "id" => "post_layout", "type" => "template", "title" => "Post Layout", "description" => "You can select layout of this single post page.", "items" => $post_layout_select),
			array(
    		"section" => "Featured Content Type", "id" => "post_ft_type", "type" => "select", "title" => "Featured Content Type", "description" => "Select featured content type for this post. Different content type will be displayed on single post page", 
				"items" => array(
					"Image" => "Image",
					"Gallery" => "Gallery",
					"Vimeo Video" => "Vimeo Video",
					"Youtube Video" => "Youtube Video",
				)),
			
			array("section" => "Gallery", "id" => "post_ft_gallery", "type" => "select", "title" => "Gallery (Optional)", "description" => "Please select a gallery.</strong>", "items" => $galleries_select),
				
			array("section" => "Vimeo Video ID", "id" => "post_ft_vimeo", "type" => "text", "title" => "Vimeo Video ID", "description" => "Please enter Vimeo Video ID for example 73317780"),
			
			array("section" => "Youtube Video ID", "id" => "post_ft_youtube", "type" => "text", "title" => "Youtube Video ID", "description" => "Please enter Youtube Video ID for example 6AIdXisPqHc"),
		),
		
		'tour' => array(
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_days", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Number of Day(s)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter number of days for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_hours", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Number of Hour(s)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter number of hours for this tour", 'grandtour-custom-post')
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_available_days", 
    			"type" 			=> "checkboxes", 
    			"title" 		=> esc_html__("Available Day(s)", 'grandtour-custom-post'), 
    			"description" 	=> "Select which day(s) this tour will be available", 
				"items" 		=> $available_days
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_minimum_age", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Minimum Age(s)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter number of minimum age(s) for this tour", 'grandtour-custom-post')
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_months", 
    			"type" 			=> "checkboxes", 
    			"title" 		=> esc_html__("Tour Month(s)", 'grandtour-custom-post'), 
    			"description" 	=> "Select which month(s) this tour will be available", 
				"items" 		=> $available_months
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_availability", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Availability", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter number of availability for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_price", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Price", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter price for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_discount_price", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Discount Price (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter discount price for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_label", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Label (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter label for this tour. For example Sale", 'grandtour-custom-post')
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_booking_method", 
    			"type" 			=> "select", 
    			"title" 		=> esc_html__("Booking Method"), 
    			"description" 	=> "Select booking option for this tour", 
				"items" 		=> array(
					'contact_form7' 		=> "Contact Form 7",
					'woocommerce_product' 	=> "Woocommerce",
					'html' 					=> "HTML & Shortcode",
					'external' 				=> "External Link",
				)
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_booking_contactform7", 
    			"type" 			=> "select", 
    			"title" 		=> esc_html__("Conform Form 7"), 
    			"description" 	=> "Select contact form for this tour booking", 
				"items" 		=> $contactform7_arr
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_booking_product", 
    			"type" 			=> "select", 
    			"title" 		=> esc_html__("Woocommerce Product"), 
    			"description" 	=> "Select product for this tour booking", 
				"items" 		=> $woocommerce_product_arr
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_booking_url", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Booking URL", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter booking URL for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_booking_html", 
				"type" 			=> "textarea", 
				"title" 		=> esc_html__("Booking HTML & Shortcode", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter custom HTML or shortcode for booking", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_departure", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Departure", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter departure location for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_departure_time", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Departure Time", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter departure time for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_return_time", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Return Time", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter departure time for this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_included", 
				"type" 			=> "adding_list", 
				"title" 		=> esc_html__("Included", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter what\'s included in this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_not_included", 
				"type" 			=> "adding_list", 
				"title" 		=> esc_html__("Not Included", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter what\'s not included in this tour", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_map_address", 
				"type" 			=> "text", 
				"title" 		=> esc_html__("Map Address (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter tour address for Google Maps for example London", 'grandtour-custom-post')
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_gallery", 
				"type" 			=> "select", 
				"title" 		=> esc_html__("Gallery (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Select sample image gallery for this tour", 'grandtour-custom-post'),
				"items" 		=> $galleries_select
			),
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_video_preview", 
				"type" 			=> "textarea", 
				"title" 		=> esc_html__("Video Review (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter video review embed HTML code for this tour", 'grandtour-custom-post')
			),
			array(
    			"section" 		=> "Tour Attributes", 
    			"id" 			=> "tour_header_type", 
    			"type" 			=> "select", 
    			"title" 		=> "Header Content Type", 
    			"description" 	=> "Select header content type for this tour. Different content type will be displayed on single tour page", 
				"items" 		=> array(
					"Image" => "Featured Image",
					"Vimeo Video" => "Vimeo Video",
					"Youtube Video" => "Youtube Video",
			)),
				
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_header_vimeo", 
				"type" 			=> "text", 
				"title" 		=> "Vimeo Video ID ", 
				"description" 	=> "Please enter Vimeo Video ID for example 73317780"
			),
			
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_header_youtube", 
				"type" 			=> "text", 
				"title" 		=> "Youtube Video ID", 
				"description" 	=> "Please enter Youtube Video ID for example 6AIdXisPqHc"
			),
			
			array(
				"section" 		=> "Tour Attributes", 
				"id" 			=> "tour_layout", 
				"type" 			=> "select", 
				"title" 		=> esc_html__("Single Tour Page Layout", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter layout for this tour", 'grandtour-custom-post'),
				"items" 		=> $single_tour_layouts
			),
		),
		
		'destination' => array(
			array(
    			"section" 		=> "Destination Attributes", 
    			"id" 			=> "destination_header_type", 
    			"type" 			=> "select", 
    			"title" 		=> "Header Content Type", 
    			"description" 	=> "Select header content type for this destination. Different content type will be displayed on single destination page", 
				"items" 		=> array(
					"Image" => "Featured Image",
					"Vimeo Video" => "Vimeo Video",
					"Youtube Video" => "Youtube Video",
			)),
				
			array(
				"section" 		=> "Destination Attributes", 
				"id" 			=> "destination_header_vimeo", 
				"type" 			=> "text", 
				"title" 		=> "Vimeo Video ID", 
				"description" 	=> "Please enter Vimeo Video ID for example 73317780"
			),
			
			array(
				"section" 		=> "Destination Attributes", 
				"id" 			=> "destination_header_youtube", 
				"type" 			=> "text", 
				"title" 		=> "Youtube Video ID", 
				"description" 	=> "Please enter Youtube Video ID for example 6AIdXisPqHc"
			),
			array(
				"section" 		=> "Destination Attributes", 
				"id" 			=> "destination_sidebar", 
				"type" 			=> "select", 
				"title" 		=> esc_html__("Sidebar (Optional)", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Select sidebar to display for this destination", 'grandtour-custom-post'),
				"items" 		=> $theme_sidebar
			),
			array(
    			"section" 		=> "Destination Attributes", 
    			"id" 			=> "destination_tour", 
    			"type" 			=> "checkboxes", 
    			"title" 		=> esc_html__("Related Tours (Optional)", 'grandtour-custom-post'), 
    			"description" 	=> "Select which tours which are related with this destination (recommended 3 items)", 
				"items" 		=> $tours_select
			),
			
			array(
				"section" 		=> "Destination Attributes", 
				"id" 			=> "destination_layout", 
				"type" 			=> "select", 
				"title" 		=> esc_html__("Single Destination Page Layout", 'grandtour-custom-post'), 
				"description" 	=> esc_html__("Enter layout for this destination", 'grandtour-custom-post'),
				"items" 		=> $single_tour_layouts
			),
		),
		
		'team' => array(
			array("section" => "Team Option", "id" => "team_position", "type" => "text", "title" => "Position and Role", "description" => "Enter team member position and role ex. Marketing Manager"),
			array("section" => "Facebook URL", "id" => "member_facebook", "type" => "text", "title" => "Facebook URL", "description" => "Enter team member Facebook URL"),
		    array("section" => "Twitter URL", "id" => "member_twitter", "type" => "text", "title" => "Twitter URL", "description" => "Enter team member Twitter URL"),
		    array("section" => "Google+ URL", "id" => "member_google", "type" => "text", "title" => "Google+ URL", "description" => "Enter team member Google+ URL"),
		    array("section" => "Linkedin URL", "id" => "member_linkedin", "type" => "text", "title" => "Linkedin URL", "description" => "Enter team member Linkedin URL"),
		),
		
		'pricing' => array(
			array("section" => "Pricing Option", "id" => "pricing_featured", "type" => "checkbox", "title" => "Make this pricing featured", "description" => "Check this option if you want to display this pricing as featured one."),
			array("section" => "Pricing Option", "id" => "pricing_plan_currency", "type" => "text", "title" => "Currency", "description" => "Enter currency", "sample" => "$"),
			array("section" => "Pricing Option", "id" => "pricing_plan_price", "type" => "text", "title" => "Exact Price", "description" => "Enter exact price", "sample" => "10"),
			array("section" => "Pricing Option", "id" => "pricing_plan_time", "type" => "text", "title" => "Time", "description" => "Enter price per time (optional)", "sample" => 'month'),
			array("section" => "Pricing Option", "id" => "pricing_plan_features", "type" => "textarea", "title" => "Plan Features", "description" => "Enter pricing plan features.", "sample" => "Unlimited Pages\nUnlimited Storage\nMobile Website\n24/7 Customer Support"),
			array("section" => "Pricing Option", "id" => "pricing_button_text", "type" => "text", "title" => "Button Text", "description" => "Enter pricing button text", "sample" => "Purchase Now"),
		    array("section" => "Pricing Option", "id" => "pricing_button_url", "type" => "text", "title" => "Button URL", "description" => "Enter pricing button  URL", "sample" => "http://themeforest.net"),
		),
		
		'testimonials' => array(
			array("section" => "Testimonial Option", "id" => "testimonial_name", "type" => "text", "title" => "Customer Name", "description" => "Enter customer name"),
			array("section" => "Testimonial Option", "id" => "testimonial_position", "type" => "text", "title" => "Customer Position", "description" => "Enter customer position in company"),
			array("section" => "Testimonial Option", "id" => "testimonial_company_name", "type" => "text", "title" => "Company Name", "description" => "Enter customer company name"),
			array("section" => "Testimonial Option", "id" => "testimonial_company_website", "type" => "text", "title" => "Company Website URL", "description" => "Enter customer company website URL"),
		),
);

function create_meta_box() {

	global $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}
	
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		foreach($postmetas as $key => $postmeta)
		{
			if($_GET['post_type']==$key && !empty($postmeta))
			{
				add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'normal', 'high' );
			}
		}
	}

}  

function new_meta_box() {
	global $post, $postmetas, $gallery_template_urls;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}

	echo '<input type="hidden" name="pp_meta_form" id="pp_meta_form" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	//Get visual page template option
	$pp_visual_page_templates = get_option('pp_visual_page_templates');
	
	$meta_section = '';

	foreach ( $postmetas as $key => $postmeta ) {
	
		if($_GET['post_type'] == $key)
		{
		
			foreach ( $postmeta as $postmeta_key => $each_meta ) {
		
				$meta_id = $each_meta['id'];
				$meta_title = $each_meta['title'];
				$meta_description = $each_meta['description'];
				
				if(isset($postmeta['section']))
				{
					$meta_section = $postmeta['section'];
				}
				
				$meta_type = '';
				if(isset($each_meta['type']))
				{
					$meta_type = $each_meta['type'];
				}
				
				echo '<div id="post_option_'.strtolower($each_meta['id']).'" class="pp_meta_option key'.intval($postmeta_key+1).' '.$meta_type.'">';
				echo "<div class=\"meta_title_wrapper\">";
				echo "<strong>".$meta_title."</strong>";
				
				echo "<div class='pp_widget_description'>$meta_description</div>";
				
				echo "</div>";
				echo "<div class=\"meta_title_field\">";
				
				if ($meta_type == 'checkbox') {
					$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
					echo "<input type='checkbox' name='$meta_id' id='$meta_id' class='iphone_checkboxes' value='1' $checked />";
				}
				else if ($meta_type == 'select') {
					echo "<select name='$meta_id' id='$meta_id'>";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $key => $item)
						{
							echo '<option value="'.$key.'"';
							
							if($key == get_post_meta($post->ID, $meta_id, true))
							{
								echo ' selected ';
							}
							
							echo '>'.$item.'</option>';
						}
					}
					
					echo "</select>";
				}
				else if ($meta_type == 'template') {
					$current_value = get_post_meta($post->ID, $meta_id, true);
					echo "<input type='hidden' name='$meta_id' id='$meta_id' value='$current_value' />";
					echo "<ul name=\"".$meta_id."_list\" id=\"".$meta_id."_list\" class=\"meta_template_list\">";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $key => $template_name)
						{
							echo '<li data-parent="'.$meta_id.'" data-value="'.esc_attr($key).'" ';
							
							if($key == $current_value)
							{
								echo 'class="checked"';
							}
							
							echo '>';
							
							//Check if use visual page templates
						    if(!empty($pp_visual_page_templates))
						    {
								if(isset($gallery_template_urls[$key]))
								{
									echo '<a href="'.esc_url($gallery_template_urls[$key]).'" target="_blank" title="View Sample" class="tooltipster meta_template_link"><i class="fa fa-external-link"></i></a>';
								}
							}
							echo '<div class="template_title">'.$template_name.'</div>';
							echo '</li>';
						}
					}
					
					echo "</ul>";
				}
				else if ($meta_type == 'checkboxes') {
					if(!empty($each_meta['items']))
					{
						$checkboxes_post_values = get_post_meta($post->ID, $meta_id, true);
						
						echo '<div class="wp-tab-panel"><ul id="'.$meta_id.'_checklist">';
					
						foreach ($each_meta['items'] as $key => $item)
						{
							echo '<li>';
							echo '<input name="'.$meta_id.'[]" id="'.$meta_id.'[]" type="checkbox"  value="'.$key.'"';
							
							if(is_array($checkboxes_post_values) && !empty($checkboxes_post_values) && in_array($key, $checkboxes_post_values))
							{
								echo ' checked ';
							}
							
							echo '/>'.$item;
							echo '</li>';
						}
						
						echo '</ul></div>';
					}
				}
				else if ($meta_type == 'adding_list') {
					
					echo '<table id="'.$meta_id.'_sortable" class="adding_list_sortable">';
		
					echo '<thead>';
					echo '<tr>';
					
					echo '<th width="5%"></th>';
					echo '<th width="90%">'.esc_html__("Title", 'grandtour-custom-post').'</th>';
					echo '<th width="5%"></th>';
					
					echo '</tr>';
					echo '</thead>';
					
					echo '<tbody>';
					
					$adding_list_arr = get_post_meta($post->ID, $meta_id, true);
					
					if(!empty($adding_list_arr) && is_array($adding_list_arr))
					{
						foreach($adding_list_arr as $key => $adding_list_item)
						{
							echo '<tr>';
							echo '<td class="sortable_handle"><span class="dashicons dashicons-menu"></span></td>';
							echo '<td><input type="text" class="widefat" name="'.$meta_id.'[]" value="'.esc_attr($adding_list_item).'"></td>';
							echo '<td><a class="button adding_list_remove_row" href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></td>';
							echo '</tr>';
						}
					}
					else
					{
						echo '<tr>';
							echo '<td class="sortable_handle"><span class="dashicons dashicons-menu"></span></td>';
							echo '<td><input type="text" class="widefat" name="'.$meta_id.'[]" value=""></td>';
							echo '<td><a class="button adding_list_remove_row" href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></td>';
							echo '</tr>';
					}
					
					echo '</tbody>';
					echo '</table>';
		
					echo '<a id="'.$meta_id.'_add_row" class="button adding_list_add_row" data-target="'.$meta_id.'_sortable" data-metaid="'.$meta_id.'" href="javascript:;">'.esc_html__("Add another", 'grandtour-custom-post').'</a>';
					
					echo '<script>';
					echo '
						jQuery("#'.$meta_id.'_add_row").on( "click", function(){
							var rowHTML = \'\';
							rowHTML+= \'<tr>\';
							rowHTML+= \'<td class="sortable_handle"><span class="dashicons dashicons-menu"></span></td>\';
							rowHTML+= \'<td><input type="text" class="widefat" name="'.$meta_id.'[]"></td>\';
							rowHTML+= \'<td><a class="button adding_list_remove_row" href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a></td>\';
							rowHTML+= \'</tr>\';
							
							jQuery("#'.$meta_id.'_sortable").find("tbody:last").append(rowHTML);
							addingListRemoveEvent();
						});
					';
					echo '</script>';
				}
				else if ($meta_type == 'file') { 
				    echo "<input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:calc(100% - 75px)' /><input id='".$meta_id."_button' name='".$meta_id."_button' type='button' value='Upload' class='metabox_upload_btn button' readonly='readonly' rel='".$meta_id."' style='margin:0 0 0 5px' />";
				}
				else if ($meta_type == 'textarea') {
					if(isset($postmeta[$postmeta_key]['sample']))
					{
						echo "<textarea name='$meta_id' id='$meta_id' class=' hint' style='width:100%' rows='7' title='".$postmeta[$postmeta_key]['sample']."'>".get_post_meta($post->ID, $meta_id, true)."</textarea>";
					}
					else
					{
						echo "<textarea name='$meta_id' id='$meta_id' class='' style='width:100%' rows='7'>".get_post_meta($post->ID, $meta_id, true)."</textarea>";
					}
				}			
				else {
					if(isset($postmeta[$postmeta_key]['sample']))
					{
						echo "<input type='text' name='$meta_id' id='$meta_id' class='' title='".$postmeta[$postmeta_key]['sample']."' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:100%' />";
					}
					else
					{
						echo "<input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:100%' />";
					}
				}
				
				echo "</div>";
				echo '</div>';
			}
		}
	}

}

function save_postdata( $post_id ) {

	global $postmetas;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['pp_meta_form']) && !wp_verify_nonce( $_POST['pp_meta_form'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']))
        return;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}
	
	if (isset($_POST['pp_meta_form'])) 
	{
		//If import page content builder
		if(is_admin() && isset($_POST['ppb_import_current']) && !empty($_POST['ppb_import_current']))
		{
			//If upload import builder file
			if(isset($_FILES['ppb_import_current_file']['name']) && !empty($_FILES['ppb_import_current_file']['name']))
			{
				//Check if zip file
				$import_filename = $_FILES['ppb_import_current_file']['name'];
				$import_type = $_FILES['ppb_import_current_file']['type'];
				$is_zip = FALSE;
				$new_filename = basename($import_filename, '_.zip');
				
				$accepted_types = array('application/zip', 
	                                'application/x-zip-compressed', 
	                                'multipart/x-zip', 
	                                'application/s-compressed');
	 
			    foreach($accepted_types as $mime_type) {
			        if($mime_type == $import_type) {
			            $is_zip = TRUE;
			            break;
			        } 
			    }
			}
			//If import demo pages
			else if(isset($_POST['ppb_import_demo_file']) && !empty($_POST['ppb_import_demo_file']))
			{
				$is_zip = FALSE;
			}
			//If import from saved template
			else if(isset($_POST['ppb_import_template_key']) && !empty($_POST['ppb_import_template_key']))
			{
				$is_zip = FALSE;
			}
			
			if($is_zip)
			{
				WP_Filesystem();
				$upload_dir = wp_upload_dir();
				$cache_dir = '';
				
				if(isset($upload_dir['basedir']))
				{
					$cache_dir = $upload_dir['basedir'].'/meteors';
				}
				
				move_uploaded_file($_FILES["ppb_import_current_file"]["tmp_name"], $cache_dir.'/'.$import_filename);
				//$unzipfile = unzip_file( $cache_dir.'/'.$import_filename, $cache_dir);
				
				$zip = new ZipArchive();
				$x = $zip->open($cache_dir.'/'.$import_filename);
				
				for($i = 0; $i < $zip->numFiles; $i++) {
			        $new_filename = $zip->getNameIndex($i);
			        break;
			    }  
				
				if ($x === true) {
					$zip->extractTo($cache_dir); 
					$zip->close();
				}

				$import_options_json = file_get_contents($cache_dir.'/'.$new_filename);
				unlink($cache_dir.'/'.$import_filename);
				unlink($cache_dir.'/'.$new_filename);
			}
			else
			{
				//If import demo pages
				if(isset($_POST['ppb_import_demo_file']) && !empty($_POST['ppb_import_demo_file']))
				{
					$import_options_json = file_get_contents(get_template_directory().'/cache/demos/pages/'.$_POST['ppb_import_demo_file']);
				}
				//If import from saved template
				else if(isset($_POST['ppb_import_template_key']) && !empty($_POST['ppb_import_template_key']))
				{
					$import_options_json = get_option( SHORTNAME."_template_".$_POST['ppb_import_template_key']);
				}
				else
				{
					//If .json file then import
					$import_options_json = $wp_filesystem->get_contents($_FILES["ppb_import_current_file"]["tmp_name"]);
					
					if(empty($import_options_json))
					{
						$import_options_json = file_get_contents($_FILES["ppb_import_current_file"]["tmp_name"]);
					}
				}
			}
			
			$import_options_arr = json_decode($import_options_json, true);
			
			if(isset($import_options_arr['ppb_form_data_order'][0]) && !empty($import_options_arr['ppb_form_data_order'][0]))
			{
				grandtour_page_update_custom_meta($post_id, $import_options_arr['ppb_form_data_order'][0], 'ppb_form_data_order');
			}
			
			$ppb_item_arr = explode(',', $import_options_arr['ppb_form_data_order'][0]);
			
			if(is_array($ppb_item_arr) && !empty($ppb_item_arr))
			{
				foreach($ppb_item_arr as $key => $ppb_item_arr)
				{
					if(isset($import_options_arr[$ppb_item_arr.'_data'][0]) && !empty($import_options_arr[$ppb_item_arr.'_data'][0]))
					{
						grandtour_page_update_custom_meta($post_id, $import_options_arr[$ppb_item_arr.'_data'][0], $ppb_item_arr.'_data');
					}
					
					if(isset($import_options_arr[$ppb_item_arr.'_size'][0]) && !empty($import_options_arr[$ppb_item_arr.'_size'][0]))
					{
						grandtour_page_update_custom_meta($post_id, $import_options_arr[$ppb_item_arr.'_size'][0], $ppb_item_arr.'_size');
					}
				}
			}
			
			header("Location: ".$_SERVER['HTTP_REFERER']);
			exit;
		}
	
		//If export page content builder
		if(is_admin() && isset($_POST['ppb_export_current']) && !empty($_POST['ppb_export_current']))
		{
			$page_title = get_the_title($post_id);
		
			$json_file_name = THEMENAME.'-Page-'.sanitize_title($page_title).'-Export-'.date('m-d-Y_hia');
			$json_file_name = strtolower($json_file_name);
	
			header('Content-disposition: attachment; filename='.$json_file_name.'.json');
			header('Content-type: application/json');
			
			//Get current content builder data
			$ppb_form_data_order = get_post_meta($post_id, 'ppb_form_data_order');
			$export_options_arr = array();
			
			if(!empty($ppb_form_data_order))
			{
				$export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

				//Get each builder module data
				$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
			
				foreach($ppb_form_item_arr as $key => $ppb_form_item)
				{
					$ppb_form_item_data = get_post_meta($post_id, $ppb_form_item.'_data');
					$export_options_arr[$ppb_form_item.'_data'] = $ppb_form_item_data;
					
					$ppb_form_item_size = get_post_meta($post_id, $ppb_form_item.'_size');
					$export_options_arr[$ppb_form_item.'_size'] = $ppb_form_item_size;
				}
			}
		
			echo json_encode($export_options_arr);
			
			exit;
		}
	
		foreach ( $postmetas as $postmeta ) {
			foreach ( $postmeta as $each_meta ) {
				
				if (isset($_POST[$each_meta['id']]) && $_POST[$each_meta['id']]) {
					update_custom_meta($post_id, $_POST[$each_meta['id']], $each_meta['id']);
				}
				
				if (isset($_POST[$each_meta['id']]) && $_POST[$each_meta['id']] == "") {
					delete_post_meta($post_id, $each_meta['id']);
				}
				
				if (!isset($_POST[$each_meta['id']])) {
					delete_post_meta($post_id, $each_meta['id']);
				}
			
			}
		}
	
		// Saving Page Builder Data
		if(isset($_POST['ppb_enable']) && !empty($_POST['ppb_enable']))
		{
		    update_custom_meta($post_id, $_POST['ppb_enable'], 'ppb_enable');
		}
		else
		{
		    delete_post_meta($post_id, 'ppb_enable');
		}
		
		if(isset($_POST['ppb_form_data_order']) && !empty($_POST['ppb_form_data_order']))
		{
		    update_custom_meta($post_id, $_POST['ppb_form_data_order'], 'ppb_form_data_order');
		    
		    $ppb_item_arr = explode(',', $_POST['ppb_form_data_order']);
		    if(is_array($ppb_item_arr) && !empty($ppb_item_arr))
		    {
		    	foreach($ppb_item_arr as $key => $ppb_item_arr)
		    	{
		    		if(isset($_POST[$ppb_item_arr.'_data']) && !empty($_POST[$ppb_item_arr.'_data']))
		    		{
		    			update_custom_meta($post_id, $_POST[$ppb_item_arr.'_data'], $ppb_item_arr.'_data');
		    		}
		    		
		    		if(isset($_POST[$ppb_item_arr.'_size']) && !empty($_POST[$ppb_item_arr.'_size']))
		    		{
		    			update_custom_meta($post_id, $_POST[$ppb_item_arr.'_size'], $ppb_item_arr.'_size');
		    		}
		    	}
		    }
		}
		//If content builder is empty
		else
		{
		    update_custom_meta($post_id, '', 'ppb_form_data_order');
		}
		
		//If enable Content Builder then also copy its content to standard page content
		if (isset($_POST['ppb_enable']) && !empty($_POST['ppb_enable']) && ! wp_is_post_revision( $post_id ) )
		{
			//unhook this function so it doesn't loop infinitely
			remove_action('save_post', 'save_postdata');
		
			//update the post, which calls save_post again
			$ppb_page_content = grandtour_apply_builder($post_id, 'portfolios', FALSE);
			
			$current_post = array (
		      'ID'           => $post_id,
		      'post_content' => $ppb_page_content,
		    );
		    
		    wp_update_post($current_post);
		    if (is_wp_error($post_id)) {
				$errors = $post_id->get_error_messages();
				foreach ($errors as $error) {
					echo esc_html($error);
				}
			}
	
			//re-hook this function
			add_action('save_post', 'save_postdata');
		}
	}
}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (isset($_POST['pp_meta_form'])) 
	{
		if (!get_post_meta($postID, $field_name)) {
			add_post_meta($postID, $field_name, $newvalue);
		} else {
			update_post_meta($postID, $field_name, $newvalue);
		}
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 
add_action('save_post', 'save_postdata'); 

/*
	End creating custom fields
*/

//Include gallery admin interface
include_once (plugin_dir_path( __FILE__ ) . "/gallery/tg-gallery.php");

//Include Theme Shortcode
include_once (plugin_dir_path( __FILE__ ) . "tg-shortcode.php");

//Include Content Builder Shortcode
include_once (plugin_dir_path( __FILE__ ) . "tg-contentbuilder.php");

//Include plugin filter & hook
include_once (plugin_dir_path( __FILE__ ) . "tg-filter.php");
?>
