<?php
//Get page ID
if(is_object($post))
{
    $obj_page = get_page($post->ID);
}
$current_page_id = '';

if(isset($obj_page->ID))
{
    $current_page_id = $obj_page->ID;
}
elseif(is_home())
{
    $current_page_id = get_option('page_on_front');
}
?>

<div class="header_style_wrapper">
<?php
    //Check if display top bar
    $tg_topbar = kirki_get_option('tg_topbar');
    if(GRANDTOUR_THEMEDEMO && isset($_GET['topbar']) && !empty($_GET['topbar']))
	{
	    $tg_topbar = true;
	}
    
    $grandtour_topbar = grandtour_get_topbar();
    grandtour_set_topbar($tg_topbar);
    
    if(!empty($tg_topbar))
    {
?>

<!-- Begin top bar -->
<div class="above_top_bar">
    <div class="page_content_wrapper">
    
    <div class="top_contact_info">
		<?php
		    $tg_menu_contact_hours = kirki_get_option('tg_menu_contact_hours');
		    
		    if(!empty($tg_menu_contact_hours))
		    {	
		?>
		    <span id="top_contact_hours"><i class="fa fa-clock-o"></i><?php echo esc_html($tg_menu_contact_hours); ?></span>
		<?php
		    }
		?>
		<?php
		    //Display top contact info
		    $tg_menu_contact_number = kirki_get_option('tg_menu_contact_number');
		    
		    if(!empty($tg_menu_contact_number))
		    {
		?>
		    <span id="top_contact_number"><a href="tel:<?php echo esc_attr($tg_menu_contact_number); ?>"><i class="fa fa-phone"></i><?php echo esc_html($tg_menu_contact_number); ?></a></span>
		<?php
		    }
		?>
    </div>
    	
    <?php
    	//Display Top Menu
    	if ( has_nav_menu( 'top-menu' ) ) 
		{
		    wp_nav_menu( 
		        	array( 
		        		'menu_id'			=> 'top_menu',
		        		'menu_class'		=> 'top_nav',
		        		'theme_location' 	=> 'top-menu',
		        	) 
		    ); 
		}
    ?>
    <br class="clear"/>
    </div>
</div>
<?php
    }
?>
<!-- End top bar -->

<?php
	//Get Page Menu Transparent Option
	$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

    $pp_page_bg = '';
    //Get page featured image
    if(has_post_thumbnail($current_page_id, 'full'))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        $pp_page_bg = $image_thumb[0];
    }
    
   if(!empty($pp_page_bg) && basename($pp_page_bg)=='default.png')
    {
    	$pp_page_bg = '';
    }
	
	//Check if Woocommerce is installed	
	if(class_exists('Woocommerce') && grandtour_is_woocommerce_page())
	{
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );
		$page_menu_transparent = get_post_meta($shop_page_id, 'page_menu_transparent', true);
	}
	
	if(is_single() && !empty($pp_page_bg) && !grandtour_is_woocommerce_page())
	{
	    $post_type = get_post_type();
	    
	    switch($post_type)
	    {
	    	case 'tour':
	    		$tg_tour_single_header = kirki_get_option('tg_tour_single_header');
		    	
	    		if(has_post_thumbnail($current_page_id, 'original') && !empty($tg_tour_single_header))
				{
	    			$page_menu_transparent = 1;
	    		}
	    	break;
	    	
	    	case 'destination':
				if(has_post_thumbnail($current_page_id, 'original'))
				{
		    		$page_menu_transparent = 1;
		    	}
		    break;

			default:
	    		$page_menu_transparent = 0;	
	    	break;
	    }
	}
	else if(is_single() && empty($pp_page_bg) && !grandtour_is_woocommerce_page())
	{
		$page_menu_transparent = 0;	
	}
	
	if(is_search())
	{
	    $page_menu_transparent = 0;
	}
	
	if(is_404())
	{
	    $page_menu_transparent = 0;
	}
	
	if(!empty($term) && function_exists('z_taxonomy_image_url'))
	{
	    $pp_page_bg = z_taxonomy_image_url();
	 
		 if(!empty($pp_page_bg))
		 {
		 	$page_menu_transparent = 1;
		 }
	}
	
	$grandtour_homepage_style = grandtour_get_homepage_style();
	if($grandtour_homepage_style == 'fullscreen')
	{
	    $page_menu_transparent = 1;
	}
?>
<div class="top_bar <?php if(!empty($page_menu_transparent)) { ?>hasbg<?php } ?>">
    <div class="standard_wrapper">
    	<!-- Begin logo -->
    	<div id="logo_wrapper">
    	
    	<?php
    	    //get custom logo
    	    $tg_retina_logo = kirki_get_option('tg_retina_logo');

    	    if(!empty($tg_retina_logo))
    	    {	
    	    	//Get image width and height
		    	$image_id = grandtour_get_image_id($tg_retina_logo);
		    	if(!empty($image_id))
		    	{
		    		$obj_image = wp_get_attachment_image_src($image_id, 'original');
		    		
		    		$image_width = 0;
			    	$image_height = 0;
			    	
			    	if(isset($obj_image[1]))
			    	{
			    		$image_width = intval($obj_image[1]/2);
			    	}
			    	if(isset($obj_image[2]))
			    	{
			    		$image_height = intval($obj_image[2]/2);
			    	}
		    	}
		    	else
		    	{
			    	$image_width = 0;
			    	$image_height = 0;
		    	}
    	?>
    	<div id="logo_normal" class="logo_container">
    		<div class="logo_align">
	    	    <a id="custom_logo" class="logo_wrapper <?php if(!empty($page_menu_transparent)) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo esc_url(home_url('/')); ?>">
	    	    	<?php
						if($image_width > 0 && $image_height > 0)
						{
					?>
					<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
						}
						else
						{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="92" height="22"/>
	    	    	<?php 
		    	    	}
		    	    ?>
	    	    </a>
    		</div>
    	</div>
    	<?php
    	    }
    	?>
    	
    	<?php
    		//get custom logo transparent
    	    $tg_retina_transparent_logo = kirki_get_option('tg_retina_transparent_logo');

    	    if(!empty($tg_retina_transparent_logo))
    	    {
    	    	//Get image width and height
		    	$image_id = grandtour_get_image_id($tg_retina_transparent_logo);
		    	$obj_image = wp_get_attachment_image_src($image_id, 'original');
		    	$image_width = 0;
		    	$image_height = 0;
		    	
		    	if(isset($obj_image[1]))
		    	{
		    		$image_width = intval($obj_image[1]/2);
		    	}
		    	if(isset($obj_image[2]))
		    	{
		    		$image_height = intval($obj_image[2]/2);
		    	}
    	?>
    	<div id="logo_transparent" class="logo_container">
    		<div class="logo_align">
	    	    <a id="custom_logo_transparent" class="logo_wrapper <?php if(empty($page_menu_transparent)) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo esc_url(home_url('/')); ?>">
	    	    	<?php
						if($image_width > 0 && $image_height > 0)
						{
					?>
					<img src="<?php echo esc_url($tg_retina_transparent_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="<?php echo esc_attr($image_width); ?>" height="<?php echo esc_attr($image_height); ?>"/>
					<?php
						}
						else
						{
					?>
	    	    	<img src="<?php echo esc_url($tg_retina_transparent_logo); ?>" alt="<?php esc_attr(get_bloginfo('name')); ?>" width="92" height="22"/>
	    	    	<?php 
		    	    	}
		    	    ?>
	    	    </a>
    		</div>
    	</div>
    	<?php
    	    }
    	?>
    	<!-- End logo -->
    	
    	<?php
	    	//Get main menu layout
			$tg_menu_layout = grandtour_menu_layout();
			
			if($tg_menu_layout == 'leftalign_search')
			{
				wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=s&form=menu_search_form&result=menu_search_autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	    ?>
	    <div id="menu_search">
		    <div class="menu_search_wrapper">
			    <form id="menu_search_form" class="searchform" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
				    <i class="fa fa-search"></i>
			    	<input type="text" class="field searchform-s" id="s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_html_e( 'Search tour by keywords', 'grandtour' ); ?>" autocomplete="off">
			    	<div id="menu_search_autocomplete" class="autocomplete" data-mousedown="false"></div>
			    </form>
		    </div>
	    </div>
	    <?php
		    }
		?>
    	
        <div id="menu_wrapper">
	        <div id="nav_wrapper">
	        	<div class="nav_wrapper_inner">
	        		<div id="menu_border_wrapper">
	        			<?php 	
	        				//Check if has custom menu
	        				if(is_object($post) && $post->post_type == 'page')
	    					{
	    						$page_menu = get_post_meta($current_page_id, 'page_menu', true);
	    					}
	        			
	        				if(empty($page_menu))
	    					{
	    						if ( has_nav_menu( 'primary-menu' ) ) 
	    						{
	    		    			    wp_nav_menu( 
	    		    			        	array( 
	    		    			        		'menu_id'			=> 'main_menu',
	    		    			        		'menu_class'		=> 'nav',
	    		    			        		'theme_location' 	=> 'primary-menu',
	    		    			        		'walker' => new grandtour_walker(),
	    		    			        	) 
	    		    			    ); 
	    		    			}
	    		    			else
	    		    			{
	    			    			echo '<div class="notice">'.esc_html__('Setup Menu via Wordpress Dashboard > Appearance > Menus', 'grandtour' ).'</div>';
	    		    			}
	    	    			}
	    	    			else
	    				    {
	    				     	if( $page_menu && is_nav_menu( $page_menu ) ) {  
	    						    wp_nav_menu( 
	    						        array(
	    						            'menu' => $page_menu,
	    						            'walker' => new grandtour_walker(),
	    						            'menu_id'			=> 'main_menu',
	    		    			        	'menu_class'		=> 'nav',
	    						        )
	    						    );
	    						}
	    				    }
	        			?>
	        		</div>
	        	</div>
	        	
	        	<!-- Begin right corner buttons -->
		    	<div id="logo_right_button">
					
					<!-- Begin side menu -->
					<a href="javascript:;" id="mobile_nav_icon"><span class="ti-menu"></span></a>
					<!-- End side menu -->
					
					<?php
					if (class_exists('Woocommerce')) {
					    //Check if display cart in header
					
					    $woocommerce = grandtour_get_woocommerce();
					    $cart_url = wc_get_cart_url();
					    $cart_count = $woocommerce->cart->cart_contents_count;
					?>
					<div class="header_cart_wrapper">
					    <div class="cart_count"><?php echo intval($cart_count); ?></div>
					    <a href="<?php echo esc_url($cart_url); ?>" title="<?php esc_html_e('View Cart', 'grandtour' ); ?>"><span class="ti-shopping-cart"></span></a>
					</div>
					<?php
					}
					?>
					
		    	</div>
		    	<!-- End right corner buttons -->
	        </div>
	        <!-- End main nav -->
        </div>
        
    	</div>
		</div>
    </div>
</div>
