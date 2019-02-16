<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

//Get page header display setting
$page_title = get_the_title();
$page_menu_transparent = 0;

//Get tour header option
$tg_tour_single_header = kirki_get_option('tg_tour_single_header');

if(has_post_thumbnail($current_page_id, 'original') && !empty($tg_tour_single_header))
{
	$pp_page_bg = '';
	
	//Get page featured image
	$image_id = get_post_thumbnail_id($current_page_id); 
    $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
    
    if(isset($image_thumb[0]) && !empty($image_thumb[0]))
    {
    	$pp_page_bg = $image_thumb[0];
    	$page_menu_transparent = 1;
    }
    
    $grandtour_topbar = grandtour_get_topbar();
	$grandtour_screen_class = grandtour_get_screen_class();
	
	//Get header featured content
	$tour_header_type = get_post_meta(get_the_ID(), 'tour_header_type', true);
	
	$video_url = '';
				
	if($tour_header_type == 'Youtube Video' OR $tour_header_type == 'Vimeo Video')
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		if($tour_header_type == 'Youtube Video')
		{
			$tour_header_youtube = get_post_meta(get_the_ID(), 'tour_header_youtube', true);
			$video_url = 'https://www.youtube.com/watch?v='.$tour_header_youtube;
		}
		else
		{
			$tour_header_vimeo = get_post_meta(get_the_ID(), 'tour_header_vimeo', true);
			$video_url = 'https://vimeo.com/'.$tour_header_vimeo;
		}
	}
?>
<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg parallax<?php } ?> <?php if(!empty($grandtour_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandtour_screen_class)) { ?>split<?php } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?> <?php if($tour_header_type == 'Youtube Video' OR $tour_header_type == 'Vimeo Video') { ?>data-jarallax-video="<?php echo esc_url($video_url); ?>"<?php } ?>>
	<?php
		//Check page title vertical alignment
		$tg_page_title_vertical_alignment = kirki_get_option('tg_page_title_vertical_alignment');
		if($tg_page_title_vertical_alignment == 'center')
		{	
	?>
		<div class="overlay_background visible"></div>
	<?php
		}
	?>

	<div class="page_title_wrapper">
		<div class="page_title_inner">
			<div class="page_title_content">
				<div class="page_title_small_content">
					<h1 <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo esc_html($page_title); ?></h1>
					<br class="clear"/>
					<?php
						//Get tour booking method
						$tour_booking_method = get_post_meta($post->ID, 'tour_booking_method', true);
						
						//Check how to display booking form
	    				switch($tour_booking_method)
	    				{
		     				case 'contact_form7':
		     				default:
		     		?>
		     		<a href="javascript:;" id="single_tour_book_open" class="button" data-type="inline"><?php esc_html_e('Book This Tour', 'grandtour' ); ?></a>
		     		<?php
			     			break;
			     			
			     			case 'woocommerce_product':
				 			$tour_booking_product = get_post_meta($post->ID, 'tour_booking_product', true);
				 			$obj_product = wc_get_product($tour_booking_product);
 		    				
 		    				if(class_exists('Woocommerce') && !empty($tour_booking_product))
 		    				{
 			    				$obj_product = wc_get_product($tour_booking_product);
 			    				
 			    				if($obj_product->is_type('simple')) 
 			    				{
 					?>
 					<button data-product="<?php echo esc_attr($tour_booking_product); ?>" data-processing="<?php esc_html_e("Please wait...", 'grandtour'); ?>" data-url="<?php echo admin_url('admin-ajax.php').esc_attr("?action=grandtour_add_to_cart&product_id=".$tour_booking_product); ?>" class="single_tour_add_to_cart button"><?php esc_html_e("Book This Tour", 'grandtour'); ?></button>
 					<?php
	 			    			}
	 			    			else
	 			    			{
		 			?>
		 			<a href="javascript:;" id="single_tour_book_open" class="button" data-type="inline"><?php esc_html_e('Book This Tour', 'grandtour' ); ?></a>
		 			<?php
	 			    			}	
	 			    		}
				 	?>
				 			
				 	<?php
				 			break;
				 			
				 			case 'external':
				 				$tour_booking_url = get_post_meta($post->ID, 'tour_booking_url', true);
				 	?>
				 	<a href="<?php echo esc_url($tour_booking_url); ?>" class="button" target="_blank"><?php esc_html_e("Book This Tour", 'grandtour'); ?></a>
				 	<?php
				 			break;
		     			}
					?>
					<?php
						//Get tour gallery
						$tour_gallery = get_post_meta($current_page_id, 'tour_gallery', true);
						
						if(!empty($tour_gallery))
						{
							//Get gallery images
							$all_photo_arr = get_post_meta($tour_gallery, 'wpsimplegallery_gallery', true);
							
							$image_url = '';
							if(isset($all_photo_arr[0]) && !empty($all_photo_arr[0]))
							{
								$image_url = wp_get_attachment_image_src($all_photo_arr[0], 'original', true);
							}
					?>
					<a href="<?php echo esc_url($image_url[0]); ?>" id="single_tour_gallery_open" class="button fancy-gallery"><span class="ti-camera"></span><?php esc_html_e('View Photos', 'grandtour' ); ?></a>
					<div style="display:none;">
						<?php
						if(!empty($all_photo_arr))
						{
							foreach($all_photo_arr as $key => $photo_id)
							{
								if($key > 0)
								{
							        $image_url = '';
							        
							        if(!empty($photo_id))
							        {
							        	$image_url = wp_get_attachment_image_src($photo_id, 'original', true);
							        }
							        
							        //Get image meta data
									$image_caption = get_post_field('post_excerpt', $photo_id);
						?>
						 <a id="single_tour_gallery_image<?php echo esc_attr($key); ?>" href="<?php echo esc_url($image_url[0]); ?>" title="<?php echo esc_attr($image_caption); ?>" class="fancy-gallery"></a>
						<?php	
								}	
							}
						}
						?>
					</div>
					<?php		
						}
					?>
					
					<?php
						//Get tour video review
						$tour_video_preview = get_post_meta($current_page_id, 'tour_video_preview', true);
						
						if(!empty($tour_video_preview))
						{
					?>
					<a href="#video_review<?php echo esc_attr($current_page_id); ?>" id="single_tour_video_preview_open" class="button" data-type="inline"><span class="ti-control-play"></span><?php esc_html_e('Video Preview', 'grandtour' ); ?></a>
					
					<div id="video_review<?php echo esc_attr($current_page_id); ?>" class="tour_video_preview_wrapper" style="display:none;"><?php echo $tour_video_preview; ?></div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>

<!-- Begin content -->
<?php
	$grandtour_page_content_class = grandtour_get_page_content_class();
?>
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>">
