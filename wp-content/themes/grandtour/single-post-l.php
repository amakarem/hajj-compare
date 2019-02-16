<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

get_header(); 

$grandtour_topbar = grandtour_get_topbar();

/**
*	Get current page id
**/

$current_page_id = $post->ID;

//If display feat content
$tg_blog_feat_content = kirki_get_option('tg_blog_feat_content');


/**
*	Get current page id
**/

$current_page_id = $post->ID;
$post_gallery_id = '';
if(!empty($tg_blog_feat_content))
{
	$post_gallery_id = get_post_meta($current_page_id, 'post_gallery_id', true);
}

//Include custom header feature
get_template_part("/templates/template-post-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    		<div class="sidebar_content left_sidebar">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(!empty($tg_blog_feat_content) && has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>
						
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<?php
	    	if(!empty($tg_blog_feat_content) )
	    	{
			    //Get post featured content
			    $post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);
			    
			    switch($post_ft_type)
			    {
			    	case 'Image':
			    	default:
			        	if(!empty($image_thumb))
			        	{
			        		$large_image_url = wp_get_attachment_image_src($image_id, 'original', true);
			        		
			        		$pp_menu_layout = get_option('pp_menu_layout');
			        		
			        		if($pp_menu_layout != 'leftmenu')
							{
								$small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-blog', true);
							}
							else
							{
			        			$small_image_url = wp_get_attachment_image_src($image_id, 'large', true);
			        		}
			?>
			
			    	    <div class="post_img static">
			    	    	<a href="<?php echo esc_url($large_image_url[0]); ?>" class="img_frame">
			    	    		<img src="<?php echo esc_url($small_image_url[0]); ?>" alt="" class="" />
				            </a>
			    	    </div>
			
			<?php
			    		}
			    	break;
			    	
			    	case 'Vimeo Video':
			    		$post_ft_vimeo = get_post_meta(get_the_ID(), 'post_ft_vimeo', true);
			?>
			    		<?php echo do_shortcode('[tg_vimeo video_id="'.esc_attr($post_ft_vimeo).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Youtube Video':
			    		$post_ft_youtube = get_post_meta(get_the_ID(), 'post_ft_youtube', true);
			?>
			    		<?php echo do_shortcode('[tg_youtube video_id="'.esc_attr($post_ft_youtube).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Gallery':
			    		$post_ft_gallery = get_post_meta(get_the_ID(), 'post_ft_gallery', true);
	
						//Get gallery images
						$all_photo_arr = get_post_meta($post_ft_gallery, 'wpsimplegallery_gallery', true);
						
						//Get gallery sorting
						$all_photo_arr = grandtour_resort_gallery_img($all_photo_arr);
						
						if(!empty($all_photo_arr))
						{
			?>
						<div class="post_gallery_wrapper">
			<?php
							$all_photo_count = count($all_photo_arr);
							$plus_photo_count = 0;
							
							if($all_photo_count > 6)
							{
								$plus_photo_count = $all_photo_count - 6;
							}
							
							foreach($all_photo_arr as $key => $photo_id)
							{
							    $small_image_url = '';
							    $hyperlink_url = get_permalink($photo_id);
							    $thumb_image_url = '';
							    
							    if(!empty($photo_id))
							    {
							    	//if mobile or tablet then use smaller image size for better performance
							    	if(!wp_is_mobile())
							    	{
								    	$image_size = 'original';
							    	}
							    	else
							    	{
								    	$image_size = 'large';
							    	}
							    	$image_url = wp_get_attachment_image_src($photo_id, $image_size, true);
							    	$thumb_image_url = wp_get_attachment_image_src($photo_id, 'thumbnail', true);
							    }
							    
							    //Get image meta data
							    $image_caption = get_post_field('post_excerpt', $photo_id);
							    $image_alt = get_post_meta($photo_id, '_wp_attachment_image_alt', true);
							    $tg_lightbox_enable_caption = kirki_get_option('tg_lightbox_enable_caption');
							    
							    //First image large
							    if($key == 0)
							    {
			?>
							    <div class="post_img post_gallery_featured static">
							    	<a <?php if(!empty($tg_lightbox_enable_caption)) { ?>title="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
								    	<img src="<?php echo esc_url($image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>"/>
									</a>
								</div>
			<?php
							    }
							    else
							    {
							    	$last_class = '';
							    	if(($key)%6 == 0)
							    	{
								    	$last_class = 'last';
							    	}
							    	
							    	$hidden_class = '';
							    	if($key > 6)
							    	{
								    	$hidden_class = 'hidden';
							    	}
			?>
								<div class="one_fifth <?php echo esc_attr($last_class); ?> <?php echo esc_attr($hidden_class); ?>">
									<a <?php if(!empty($tg_lightbox_enable_caption)) { ?>title="<?php if(!empty($image_caption)) { ?><?php echo esc_attr($image_caption); ?><?php } ?>"<?php } ?> class="fancy-gallery" href="<?php echo esc_url($image_url[0]); ?>">
								    	<?php
								    		if($key == 6)
								    		{
									    ?>
									    <div class="more_gallery_count">+<?php echo intval($plus_photo_count); ?></div>
									    <?php
								    		}
								    	?>
								    	<img src="<?php echo esc_url($thumb_image_url[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>"/>
									</a>
								</div>
			<?php
							    }
							}
						}
			?>
						</div><br class="clear"/>
			<?php
						
			    	break;
			    	
			    } //End switch
			} //End if enable blog featured image
			?>
			    
			<?php
			    the_content();
			    wp_link_pages();
			?>
			
			<?php
				//Get share button
				get_template_part("/templates/template-post-tags");
				
			    //Get post author
				get_template_part("/templates/template-author");
				
				//Get post related
			    get_template_part("/templates/template-post-related");
			?>
			
	    </div>
	    
	</div>

</div>
<!-- End each blog post -->

<?php
if (comments_open($post->ID)) 
{
?>
<div class="fullwidth_comment_wrapper sidebar">
	<?php comments_template( '', true ); ?>
</div>
<?php
}
?>

<?php endwhile; endif; ?>
						
    	</div>

    		<div class="sidebar_wrapper left_sidebar">
    		
    			<div class="sidebar_top"></div>
    		
    			<div class="sidebar">
    			
    				<div class="content">

    					<?php 
						if (is_active_sidebar('single-post-sidebar')) { ?>
		    	    		<ul class="sidebar_widget">
		    	    		<?php dynamic_sidebar('single-post-sidebar'); ?>
		    	    		</ul>
		    	    	<?php } ?>
    				
    				</div>
    		
    			</div>
    			<br class="clear"/>
    	
    			<div class="sidebar_bottom"></div>
    		</div>
    
    </div>
    <!-- End main content -->
   
</div>

<br class="clear"/><br/><br/>
</div>
<?php get_footer(); ?>
