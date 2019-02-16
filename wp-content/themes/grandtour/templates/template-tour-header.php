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
	
	$parallax_class = 'parallax';
	
	//Check if add parallax effect
	$tg_page_header_bg_parallax = kirki_get_option('tg_page_header_bg_parallax');
	
	if($tour_header_type == 'Image' && empty($tg_page_header_bg_parallax))
	{
		$parallax_class = '';
	}
?>
<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php echo esc_attr($parallax_class); ?><?php } ?> <?php if(!empty($grandtour_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandtour_screen_class)) { ?>split<?php } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?> <?php if($tour_header_type == 'Youtube Video' OR $tour_header_type == 'Vimeo Video') { ?>data-jarallax-video="<?php echo esc_url($video_url); ?>"<?php } ?>>
	<div class="single_tour_header_content">
		<div class="standard_wrapper">
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
			
			<?php
				//Get tour price
				$tour_price = get_post_meta($current_page_id, 'tour_price', true);
				
				if(!empty($tour_price))
				{
					$tour_discount_price = get_post_meta($current_page_id, 'tour_discount_price', true);
			?>
			<div class="single_tour_header_price">
				<div class="single_tour_price">
					<?php
					if(!empty($tour_discount_price))
					{
					?>
						<span class="normal_price">
							<?php echo esc_html(grandtour_format_tour_price($tour_price)); ?>
						</span>
						<?php echo esc_html(grandtour_format_tour_price($tour_discount_price)); ?>
					<?php
					}
					else
					{
					?>
						<?php echo esc_html(grandtour_format_tour_price($tour_price)); ?>
					<?php
					}
					?>
				</div>
				<div class="single_tour_per_person">
					<?php esc_html_e('Per Person', 'grandtour' ); ?>
				</div>
			</div>
			<?php
				}
			?>
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
