<?php
/**
 * Template Name: Destination Right Sidebar
 * The main template file for display destination page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

//Get page sidebar
$page_sidebar = get_post_meta($current_page_id, 'page_sidebar', true);

if(empty($page_sidebar))
{
	$page_sidebar = 'Page Sidebar';
}

$grandtour_homepage_style = grandtour_get_homepage_style();

get_header();

$grandtour_page_content_class = grandtour_get_page_content_class();

//Include custom header feature
get_template_part("/templates/template-header");

$wp_query = grandtour_get_wp_query();
	
$query_string = 'paged='.$paged;
$query_string.= '&orderby=menu_order&order=ASC&post_type=destination&suppress_filters=0&post_status=publish';

if(!empty($term))
{
	$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$custom_tax = $wp_query->query_vars['taxonomy'];
    $query_string .= '&'.$custom_tax.'='.$term;
}

parse_str($query_string, $args);

query_posts($args);
?>

<!-- Begin content -->
<?php
	//Get all portfolio items for paging
	$wp_query = grandtour_get_wp_query();
	$current_photo_count = $wp_query->post_count;
	$all_photo_count = $wp_query->found_posts;
?>
    
<div class="inner">

	<div class="inner_wrapper nopadding">
	
	<?php
	    if(!empty($post->post_content) && empty($term))
	    {
	?>
	    <div class="standard_wrapper"><?php echo grandtour_apply_content($post->post_content); ?></div><br class="clear"/><br/>
	<?php
	    }
	?>
	
	<div id="page_main_content" class="sidebar_content fixed_column">
	
	<div class="standard_wrapper">
	
	<div id="portfolio_filter_wrapper" class="gallery grid portrait three_cols portfolio-content section content clearfix" data-columns="3">
	
	<?php
		$key = 0;
		if (have_posts()) : while (have_posts()) : the_post();
			$key++;
			$image_url = '';
			$tour_ID = get_the_ID();
					
			if(has_post_thumbnail($tour_ID, 'grandtour-gallery-grid'))
			{
			    $image_id = get_post_thumbnail_id($tour_ID);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($tour_ID);
			
			if(!empty($small_image_url[0]))
			{
	?>
	<div class="element grid classic3_cols animated<?php echo esc_attr($key+1); ?>">
	
		<div class="one_third gallery3 grid static filterable portfolio_type themeborder" data-id="post-<?php echo esc_attr($key+1); ?>" style="background-image:url(<?php echo esc_url($small_image_url[0]); ?>);">	
			<a class="tour_image" href="<?php echo esc_url($permalink_url); ?>"></a>	
			<div class="portfolio_info_wrapper">
        	    <h3><?php the_title(); ?></h3>
			</div>
		</div>
	</div>
	<?php
			}
		endwhile;
		else:
	?>
			<div class="tour_search_noresult"><span class="ti-info-alt"></span><?php esc_html_e("We haven't found any destination that matches you're criteria", 'grandtour'); ?></div>
	<?php
		endif;
	?>
		
	</div>
	<br class="clear"/>
	<?php
	    if($wp_query->max_num_pages > 1)
	    {
	    	if (function_exists("grandtour_pagination")) 
	    	{
	    	    grandtour_pagination($wp_query->max_num_pages);
	    	}
	    	else
	    	{
	    	?>
	    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
	    	<?php
	    	}
	    ?>
	    <div class="pagination_detail">
	     	<?php
	     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	     	?>
	     	<?php esc_html_e('Page', 'grandtour' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'grandtour' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
	     </div>
	     <?php
	     }
	?>
	
	</div>
	</div>
	
	<div class="sidebar_wrapper">
	 <div class="sidebar">
	 
	  <div class="content">
	 
	  	<?php 
	  	$page_sidebar = sanitize_title($page_sidebar);
	  	
	  	if (is_active_sidebar($page_sidebar)) { ?>
	     		<ul class="sidebar_widget">
	     		<?php dynamic_sidebar($page_sidebar); ?>
	     		</ul>
	     	<?php } ?>
	  
	  </div>
	 
	 </div>
	</div>

</div>
</div>
</div>
<?php get_footer(); ?>
<!-- End content -->
