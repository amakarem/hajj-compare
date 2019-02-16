<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
*/

//Check if single attachment page
if($post->post_type == 'attachment')
{
	get_template_part("single-attachment");
	die;
}

//Check if content builder preview
if(isset($_GET['rel']) && !empty($_GET['rel']) && isset($_GET['ppb_preview']))
{
	get_template_part("page-preview");
	die;
}

//Check if content builder preview page
if(isset($_GET['ppb_preview_page']))
{
	get_template_part("page-preview-page");
	die;
}

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

get_header(); 
?>

<?php
//Get Page Menu Transparent Option
$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

//Get page header display setting
$page_title = get_the_title();
$page_show_title = get_post_meta($current_page_id, 'page_show_title', true);

if(empty($page_show_title))
{
	//Get current page tagline
	$page_tagline = get_post_meta($current_page_id, 'page_tagline', true);

	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full'))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
    }
    
    //Check if add parallax effect
	$tg_page_header_bg_parallax = kirki_get_option('tg_page_header_bg_parallax');
	
	//Check if enable content builder
	$ppb_enable = get_post_meta($current_page_id, 'ppb_enable', true);
	
	$grandtour_topbar = grandtour_get_topbar();
	$page_header_type = '';
	
	//Get header featured content
	$page_header_type = get_post_meta(get_the_ID(), 'page_header_type', true);
	
	$video_url = '';
				
	if($page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video')
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		if($page_header_type == 'Youtube Video')
		{
			$page_header_youtube = get_post_meta(get_the_ID(), 'page_header_youtube', true);
			$video_url = 'https://www.youtube.com/watch?v='.$page_header_youtube;
		}
		else
		{
			$page_header_vimeo = get_post_meta(get_the_ID(), 'page_header_vimeo', true);
			$video_url = 'https://vimeo.com/'.$page_header_vimeo;
		}
	}
?>
<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php if(!empty($tg_page_header_bg_parallax)) { ?>parallax<?php } ?> <?php } ?> <?php if(!empty($grandtour_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandtour_screen_class)) { echo esc_attr($grandtour_screen_class); } ?> <?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?> <?php if($page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video') { ?>data-jarallax-video="<?php echo esc_url($video_url); ?>"<?php } ?>>
	
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

	<?php
		if(empty($page_show_title))
		{
	?>
	<div class="page_title_wrapper">
		<div class="page_title_inner">
			<div class="page_title_content">
				<h1 <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo esc_html($page_title); ?></h1>
				<?php
			    	if(!empty($page_tagline))
			    	{
			    ?>
			    	<div class="page_tagline">
			    		<?php echo nl2br($page_tagline); ?>
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

</div>
<?php
}
?>

<?php
	//Check if use page builder
	$ppb_form_data_order = '';
	$ppb_form_item_arr = array();
	$ppb_enable = get_post_meta($current_page_id, 'ppb_enable', true);
	
	$grandtour_topbar = grandtour_get_topbar();
?>
<?php
	if(!empty($ppb_enable))
	{
		$grandtour_screen_class = grandtour_get_screen_class();
		grandtour_set_screen_class('ppb_wrapper');
		
		//if dont have password set
		if(!post_password_required())
		{
		wp_enqueue_script("grandtour-custom-onepage", get_template_directory_uri()."/js/custom_onepage.js", false, GRANDTOUR_THEMEVERSION, true);
?>
<div class="ppb_wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar<?php } ?>">
<?php
		grandtour_apply_builder($current_page_id);
?>
</div>
<?php		
		} //end if dont have password set
		else
		{
?>
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar<?php } ?>">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content full_width"><br/><br/>
<?php
			the_content();
?>
    		<br/><br/></div>
    	</div>
    </div>
</div>
<?php
		}
	}
	else
	{
?>
<!-- Begin content -->
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar<?php } ?>">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content full_width">
    		<?php 
    			if ( have_posts() ) {
    		    while ( have_posts() ) : the_post(); ?>		
    	
    		    <?php the_content(); break;  ?>

    		<?php endwhile; 
    		}

			if (comments_open($post->ID)) 
			{
			?>
			<div class="fullwidth_comment_wrapper">
				<?php comments_template( '', true ); ?>
			</div>
			<?php
			}
			?>
    		</div>
    	</div>
    	<!-- End main content -->
    </div> 
</div>
<?php
}
?>
<?php get_footer(); ?>
