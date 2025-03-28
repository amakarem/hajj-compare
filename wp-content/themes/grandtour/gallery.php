<?php
/**
 * The main template file for display gallery page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Check if gallery template
$grandtour_page_gallery_id = grandtour_get_page_gallery_id();
if(!empty($grandtour_page_gallery_id))
{
	$current_page_id = $grandtour_page_gallery_id;
}

//Check if password protected
get_template_part("/templates/template-password");

//Get gallery images
$all_photo_arr = get_post_meta($current_page_id, 'wpsimplegallery_gallery', true);
$all_photo_count = count($all_photo_arr);

//Sort gallery images
$all_photo_arr = grandtour_resort_gallery_img($all_photo_arr);

get_header();

$grandtour_topbar = grandtour_get_topbar();

//Get gallery header
get_template_part("/templates/template-gallery-header");
?>

<div class="inner">

	<div class="inner_wrapper nopadding">
	
	<div id="page_main_content" class="sidebar_content full_width nopadding fixed_column">
	
	<div id="portfolio_filter_wrapper" class="gallery four_cols portfolio-content section content clearfix" data-columns="4">
	
	<?php
		$tg_lightbox_enable_caption = kirki_get_option('tg_lightbox_enable_caption');
	
	    foreach($all_photo_arr as $key => $photo_id)
	    {
	        $small_image_url = '';
	        $image_url = '';
	        
	        if(!empty($photo_id))
	        {
	        	$image_url = wp_get_attachment_image_src($photo_id, 'original', true);
	        	$small_image_url = wp_get_attachment_image_src($photo_id, 'grandtour-gallery-list', true);
	        }
	        
	        //Get image meta data
			$image_caption = get_post_field('post_excerpt', $photo_id);
			$image_alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
	?>
	<div class="element grid classic4_cols">
	
		<div class="one_fourth gallery4 static filterable gallery_type animated<?php echo esc_attr($key+1); ?>" data-id="post-<?php echo esc_attr($key+1); ?>">
		
			<?php 
			    if(isset($image_url[0]) && !empty($image_url[0]))
			    {
			?>		
			    <a <?php if(!empty($tg_lightbox_enable_caption)) { ?>data-caption="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
			        <img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
			        
			        <?php
					     if(!empty($grandtour_purchase_url))
					     {
					 ?>
					 <a href="<?php echo esc_url($grandtour_purchase_url); ?>" title="<?php echo esc_html__('Purchase', 'grandtour' ); ?>" class="button tooltip"><i class="fa fa-shopping-cart"></i></a>
					 <?php
					     }
					 ?>
					
					<?php
					 	if(!empty($image_caption_raw))
					 	{
					 ?>
					     <div class="portfolio_title">
					    	<div class="image_caption">
					    	    <?php echo esc_html($image_caption_raw); ?>
					        </div>
					     </div>
					<?php
					    }
					?>
			    </a>
			<?php
			    }		
			?>
		
		</div>
		
	</div>
	<?php
		}
	?>
		
	</div>
	</div>

</div>
</div>
<br class="clear"/>
</div>
<?php get_footer(); ?>
<!-- End content -->
