<?php
/**
 * The main template file for preview content builder display page.
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

get_header(); 

//if dont have password set
if(!post_password_required())
{
	wp_enqueue_script("grandtour-custom-onepage", get_template_directory_uri()."/js/custom_onepage.js", false, GRANDTOUR_THEMEVERSION, true);
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

<div class="ppb_wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar<?php } ?>">
<?php
	//Check if live content builder mode
	$is_live_builder = false;
	if(isset($_GET['ppb_live']))
	{
		$is_live_builder = true;
		
		$grandtour_screen_class = grandtour_get_screen_class();
		grandtour_set_screen_class('ppb_wrapper');
		
		wp_enqueue_script("grandtour-live-builder", get_template_directory_uri()."/js/custom_livebuilder.js", false, GRANDTOUR_THEMEVERSION, true);
	}

	$ppb_form_data_order = get_transient('grandtour_'.$post->ID.'_data_order');
	$ppb_page_content = '';
	
	if(isset($ppb_form_data_order))
	{
	    $ppb_form_item_arr = explode(',', $ppb_form_data_order);
	}
	
	$ppb_shortcodes = array();
	
	require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
	
	if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	{
	    $ppb_shortcode_code = '';
	    $ppb_form_item_data = get_transient('grandtour_'.$post->ID.'_data');
	    $ppb_form_item_size = get_transient('grandtour_'.$post->ID.'_size');
	
	    foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    {
	    	if(isset($ppb_form_item_data[$ppb_form_item]))
		    {
		    	$ppb_form_item_data_obj = json_decode(stripslashes($ppb_form_item_data[$ppb_form_item]));
		    	
		    	$ppb_shortcode_content_name = $ppb_form_item_data_obj->shortcode.'_content';
		    	
		    	if(isset($ppb_form_item_data_obj->$ppb_shortcode_content_name))
		    	{
		    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[$ppb_form_item].'" ';
		    		
		    		//Get shortcode title
		    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
		    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
		    		{
		    			$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
		    		}
		    		
		    		//Get shortcode attributes
		    		if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
		    		{
			    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
			    		
			    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
			    		{
			    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
			    			{
			    				$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
			    			}
			    			elseif($attr_name == 'margin')
			    			{
			    				$ppb_shortcode_attr_margin_top = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_top';
		    				
			    				if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top))
								{
				    				$ppb_shortcode_code.= $attr_name.'_top="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_right = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_right';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right))
								{
				    				$ppb_shortcode_code.= $attr_name.'_right="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_bottom = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_bottom';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom))
								{
				    				$ppb_shortcode_code.= $attr_name.'_bottom="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_left = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_left';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left))
								{
				    				$ppb_shortcode_code.= $attr_name.'_left="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left)).'" ';
				    			}
			    			}
			    		}
			    	}
			    	
			    	//Check if in live builder
		    		if($is_live_builder)
					{
					    $ppb_shortcode_code.= 'builder_id="'.esc_attr($ppb_form_item).'" ';
					}
	
		    		$ppb_shortcode_code.= ']'.rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_content_name).'[/'.$ppb_form_item_data_obj->shortcode.']';
		    	}
		    	else if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
		    	{
		    		$ppb_shortcode_code = '['.$ppb_form_item_data_obj->shortcode.' size="'.$ppb_form_item_size[$ppb_form_item].'" ';
		    		
		    		//Get shortcode title
		    		$ppb_shortcode_title_name = $ppb_form_item_data_obj->shortcode.'_title';
		    		if(isset($ppb_form_item_data_obj->$ppb_shortcode_title_name))
		    		{
		    			$ppb_shortcode_code.= 'title="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_title_name), ENT_QUOTES, "UTF-8").'" ';
		    		}
		    		
		    		//Get shortcode attributes
		    		if(isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
		    		{
			    		$ppb_shortcode_arr = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode];
			    		
			    		foreach($ppb_shortcode_arr['attr'] as $attr_name => $attr_item)
			    		{
			    			$ppb_shortcode_attr_name = $ppb_form_item_data_obj->shortcode.'_'.$attr_name;
			    			
			    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_name))
			    			{
			    				$ppb_shortcode_code.= $attr_name.'="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_name)).'" ';
			    			}
			    			elseif($attr_name == 'margin')
			    			{
			    				$ppb_shortcode_attr_margin_top = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_top';
		    				
			    				if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top))
								{
				    				$ppb_shortcode_code.= $attr_name.'_top="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_top)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_right = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_right';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right))
								{
				    				$ppb_shortcode_code.= $attr_name.'_right="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_right)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_bottom = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_bottom';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom))
								{
				    				$ppb_shortcode_code.= $attr_name.'_bottom="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_bottom)).'" ';
				    			}
				    			
				    			$ppb_shortcode_attr_margin_left = $ppb_form_item_data_obj->shortcode.'_'.$attr_name.'_left';
				    			
				    			if(isset($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left))
								{
				    				$ppb_shortcode_code.= $attr_name.'_left="'.esc_attr(rawurldecode($ppb_form_item_data_obj->$ppb_shortcode_attr_margin_left)).'" ';
				    			}
			    			}
			    		}
			    	}
		    		
		    		//Check if in live builder
		    		if($is_live_builder)
					{
					    $ppb_shortcode_code.= 'builder_id="'.esc_attr($ppb_form_item).'" ';
					}
		    		
		    		$ppb_shortcode_code.= ']';
		    	}
		    	
		    	$ppb_page_content.= grandtour_apply_content($ppb_shortcode_code);
	        }
        }
    }

    echo $ppb_page_content;
}
?>
</div>

<?php
	//Disable all link for live builder
	if($is_live_builder)
	{
?>
<script>
jQuery(document).ready(function(){
	jQuery('body a').live('click', function() { return false; });
	parent.triggerResize();
	parent.hideLoading();
});
</script>
<style>
.parallax
{
	z-index: 0;
}
</style>
<?php
	}
?>

<?php get_footer(); ?>
