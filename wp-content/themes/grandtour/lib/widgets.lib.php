<?php

/**
*	Begin Recent Posts Custom Widgets
**/

class Grandtour_Recent_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Recent_Posts', 'description' => 'The recent posts with thumbnails' );
		parent::__construct('Grandtour_Recent_Posts', 'Custom Recent Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$items = absint($items);
		
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			grandtour_posts('recent', $items, TRUE, trim($show_thumb));
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'show_thumb' => '') );
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>">Items (default 3): <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>">Display Thumbnails: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Grandtour_Recent_Posts');

/**
*	End Recent Posts Custom Widgets
**/


/**
*	Begin Flickr Feed Custom Widgets
**/

class Grandtour_Flickr extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Flickr', 'description' => 'Display your recent Flickr photos' );
		parent::__construct('Grandtour_Flickr', 'Custom Flickr', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$flickr_id = empty($instance['flickr_id']) ? ' ' : apply_filters('widget_title', $instance['flickr_id']);
		$title = $instance['title'];
		$items = $instance['items'];
		$items = absint($items);
		
		if(!is_numeric($items))
		{
			$items = 9;
		}
		
		if(empty($title))
		{
			$title = 'Flickr Widget';
		}
		
		if(!empty($items) && !empty($flickr_id))
		{
			$photos_arr = grandtour_get_flickr(array('type' => 'user', 'id' => $flickr_id, 'items' => $items));

			if(!empty($photos_arr))
			{
				echo stripslashes($before_title);
				echo esc_html($title);
				echo stripslashes($after_title);
				
				echo '<ul class="flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li>';
					echo '<a target="_blank" href="'.esc_url($photo['link']).'"><img src="'.esc_url($photo['thumb_url']).'" alt="'.esc_attr($photo['title']).'" width="75" height="75" /></a>';
					echo '</li>';
				}
				
				echo '</ul><br class="clear"/>';
			}
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = absint($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'flickr_id' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$flickr_id = strip_tags($instance['flickr_id']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>">Flickr ID <a href="http://idgettr.com/">Find your Flickr ID here</a>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr_id')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr_id')); ?>" type="text" value="<?php echo esc_attr($flickr_id); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>">Items (default 9): <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Grandtour_Flickr');

/**
*	End Flickr Feed Custom Widgets
**/


/**
*	Begin Instagram Feed Custom Widgets
**/

class Grandtour_Instagram extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Instagram', 'description' => 'Display your recent Instagram photos' );
		parent::__construct('Grandtour_Instagram', 'Custom Instagram', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$title = $instance['title'];
		$items = $instance['items'];
		$items = absint($items);
		
		//Get Instagram Access Data
		$pp_instagram_username = get_option('pp_instagram_username');
		$pp_instagram_access_token = get_option('pp_instagram_access_token');
		
		if(!is_numeric($items))
		{
			$items = 9;
		}
		
		if(empty($title))
		{
			$title = 'Flickr Widget';
		}
		
		if(!empty($items) && !empty($pp_instagram_username) && !empty($pp_instagram_access_token))
		{
			$photos_arr = grandtour_get_instagram($pp_instagram_username, $pp_instagram_access_token, $items);

			if(!empty($photos_arr))
			{
				echo stripslashes($before_title);
				echo esc_html($title);
				echo stripslashes($after_title);
				
				echo '<ul class="flickr">';
				
				foreach($photos_arr as $photo)
				{
					echo '<li>';
					echo '<a target="_blank" href="'.esc_url($photo['link']).'"><img src="'.esc_url($photo['thumb_url']).'" width="75" height="75" alt="" /></a>';
					echo '</li>';
				}
				
				echo '</ul><br class="clear"/>';
			}
		}
		else
		{
			echo 'Error: Please check if you enter Instagram username and Access Token in Theme Setting > Social Profiles';
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['items'] = absint($new_instance['items']);
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$title = strip_tags($instance['title']);

?>
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>">Items (default 9): <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
<?php
	}
}

register_widget('Grandtour_Instagram');

/**
*	End Instagram Feed Custom Widgets
**/

/**
*	Begin Category Posts Custom Widgets
**/

class Grandtour_Cat_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Cat_Posts', 'description' => 'Display category\'s post' );
		parent::__construct('Grandtour_Cat_Posts', 'Custom Category Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		$cat_id = empty($instance['cat_id']) ? 0 : $instance['cat_id'];
		$items = empty($instance['items']) ? 0 : $instance['items'];
		$items = absint($items);
		
		$show_thumb = empty($instance['show_thumb']) ? ' ' : apply_filters('widget_title', $instance['show_thumb']);
		
		if(empty($items))
		{
			$items = 5;
		}
		
		if(!empty($cat_id))
		{
			grandtour_cat_posts($cat_id, $items, TRUE, trim($show_thumb));
		}

		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['cat_id'] = strip_tags($new_instance['cat_id']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['show_thumb'] = strip_tags($new_instance['show_thumb']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'cat_id' => '', 'items' => '', 'show_thumb' => '') );
		$cat_id = strip_tags($instance['cat_id']);
		$items = strip_tags($instance['items']);
		$show_thumb = strip_tags($instance['show_thumb']);
		
		$categories = get_categories('hide_empty=0&orderby=name');
		$wp_cats = array(
			0		=> "Choose a category"
		);
		foreach ($categories as $category_list ) {
			$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
		}

?>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('cat_id')); ?>">Category: 
				<select  id="<?php echo esc_attr($this->get_field_id('cat_id')); ?>" name="<?php echo esc_attr($this->get_field_name('cat_id')); ?>">
				<?php
					foreach($wp_cats as $wp_cat_id => $wp_cat)
					{
				?>
						<option value="<?php echo esc_attr($wp_cat_id); ?>" <?php if(esc_attr($cat_id) == $wp_cat_id) { echo 'selected="selected"'; } ?>><?php echo esc_html($wp_cat); ?></option>
				<?php
					}
				?>
				</select>
			</label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>">Items (default 5): <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<p><label for="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>">Display Thumbnails: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_thumb')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumb')); ?>" type="checkbox" value="1" <?php if(!empty($show_thumb)) { ?>checked<?php } ?> /></label></p>
<?php
	}
}

register_widget('Grandtour_Cat_Posts');

/**
*	End Category Posts Custom Widgets
**/

/**
*	Begin Social Profiles Custom Widgets
**/

class Grandtour_Social_Profiles_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Social_Profiles_Posts', 'description' => 'Display social profiles' );
		parent::__construct('Grandtour_Social_Profiles_Posts', 'Custom Social Profiles', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = $instance['title'];

		echo stripslashes($before_widget);
		
		if(!empty($title) && strlen($title) > 0)
		{
			echo stripslashes($before_title);
			echo esc_html($title);
			echo stripslashes($after_title);
		}
		
		echo do_shortcode('[tg_social_icons style="light" size="small"]');

		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'title' => '') );
		$title = strip_tags($instance['title']);

?>
		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}

register_widget('Grandtour_Social_Profiles_Posts');

/**
*	End Social Profiles Widgets
**/

/**
*	Begin About Me Custom Widgets
**/

class Grandtour_About_Us extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_About_Us', 'description' => 'Display about us information' );
		parent::__construct('Grandtour_About_Us', 'Custom About Us', $widget_ops);
		add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		$title = $instance['title'];
		$image = $instance['image'];
		$description = $instance['description'];

		echo stripslashes($before_widget);
		echo stripslashes($before_title);
		
		if(!empty($title))
		{
			echo '<h2 class="widgettitle"><span>'.esc_html($title).'</span></h2>';
		}
		
		echo stripslashes($after_title);
		
		echo '<div class="textwidget">';
		echo '<div class="widget_about_image"><img src="'.esc_url($image).'"/></div>';
		echo '<div class="widget_about_desc">'.esc_html($description).'</div>';
		echo '</div>';

		echo stripslashes($after_widget);
	}
	
	/**
     * Upload the Javascripts for the media uploader
     */
    function upload_scripts()
    {
    	wp_enqueue_media();
        wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
        wp_enqueue_script('grandtour-upload-media-widget', get_template_directory_uri().'/functions/upload_media_widget.js', array('jquery'));

        
        wp_enqueue_style('thickbox');
    }

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image'] = esc_url($new_instance['image']);
		$instance['description'] = $new_instance['description'];

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => '', 'title' => '', 'image' => '', 'description' => '') );
		$title = strip_tags($instance['title']);
		$image = strip_tags($instance['image']);
		$description = $instance['description'];

?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:', 'grandtour' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		</p>
		
		<p>
            <label for="<?php echo esc_attr($this->get_field_name( 'image' )); ?>"><?php esc_html_e( 'Profile Image:', 'grandtour' ); ?></label>
            <input name="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'image' )); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="tg_upload_image_button button" type="button" value="<?php esc_html_e( 'Select Image', 'grandtour' ); ?>" data-target="<?php echo esc_attr($this->get_field_name( 'image' )); ?>" />
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e( 'Description:', 'grandtour' ); ?> <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_attr($description); ?></textarea></label>
		</p>
<?php
	}
}

register_widget('Grandtour_About_Us');

/**
*	End About Me Widgets
**/


/**
*	Begin Tour Posts Custom Widgets
**/

class Grandtour_Tour_Posts extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'Grandtour_Tour_Posts', 'description' => 'The tour posts with information' );
		parent::__construct('Grandtour_Tour_Posts', 'Custom Tour Posts', $widget_ops);
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo stripslashes($before_widget);
		
		$title = '';
		if(isset($instance['title']))
		{
			$title = $instance['title'];
		}
		
		$items = empty($instance['items']) ? ' ' : apply_filters('widget_title', $instance['items']);
		$items = absint($items);
		
		$tourcat = empty($instance['tourcat']) ? ' ' : apply_filters('widget_title', $instance['tourcat']);
		$sortby = empty($instance['sortby']) ? ' ' : apply_filters('widget_title', $instance['sortby']);
		
		echo stripslashes($before_title);
		echo esc_html($title);
		echo stripslashes($after_title);
		
		if(!is_numeric($items))
		{
			$items = 3;
		}
		
		if(!empty($items))
		{
			//Display tour posts here
			$args = array(
				'numberposts' => $items,
				'post_type' => 'tour',
				'post_status' => 'publish',
				'suppress_filters' => 0,
			);
			
			switch($sortby)
	    	{
		    	case 'date':
		    	default:
		    		$args['orderby'] = 'post_date';
		    		$args['order'] = 'DESC';
		    	break;
		    	
		    	case 'price_low':
		    		$args['orderby'] = 'meta_value_num';
		    		$args['meta_key'] = 'tour_price';
		    		$args['order'] = 'ASC';
		    	break;
		    	
		    	case 'price_high':
		    		$args['orderby'] = 'meta_value_num';
		    		$args['meta_key'] = 'tour_price';
		    		$args['order'] = 'DESC';
		    	break;
		    	
		    	case 'name':
		    		$args['orderby'] = 'post_title';
		    		$args['order'] = 'ASC';
		    	break;
	    	}
	    	
	    	$tourcat = trim($tourcat);
	    	if(!empty($tourcat))
	    	{
		    	$args['tax_query'] = array(array( 
			        'taxonomy' => 'tourcat',
			        'field' => 'slug', 
			        'terms' => array($tourcat),
			        'operator' => 'IN'
			    ));
	    	}
			
			$tour_posts = get_posts($args);
			
			if(!empty($tour_posts))
			{
				foreach($tour_posts as $tour_post)
				{
					$tour_ID = $tour_post->ID;
					
					if(has_post_thumbnail($tour_ID, 'grandtour-gallery-grid'))
					{
					    $image_id = get_post_thumbnail_id($tour_ID);
					    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
					}
					
					$permalink_url = get_permalink($tour_ID);
	?>
					<div class="one gallery1 grid static filterable portfolio_type themeborder" style="background-image:url(<?php echo esc_url($small_image_url[0]); ?>);">	
						<a class="tour_image" href="<?php echo esc_url($permalink_url); ?>"></a>	
						<div class="portfolio_info_wrapper">
							<?php
								//Get tour price
								$tour_price = get_post_meta($tour_ID, 'tour_price', true);
								
								if(!empty($tour_price))
								{
									$tour_discount_price = get_post_meta($tour_ID, 'tour_discount_price', true);
							?>
							<div class="tour_price <?php if(!empty($tour_discount_price)) { ?>has_discount<?php } ?>">
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
							<?php
								}
							?>
			        	    <h5><?php echo esc_html($tour_post->post_title); ?></h5>
			        	    <div class="tour_attribute_wrapper">
				        	    <?php
					    			$overall_rating_arr = grandtour_get_review($tour_ID, 'overall_rating');
									$overall_rating = intval($overall_rating_arr['average']);
									$overall_rating_count = intval($overall_rating_arr['count']);
									
									if(!empty($overall_rating))
									{
							?>
									<div class="tour_attribute_rating">
							<?php
										if($overall_rating > 0)
										{
							?>
										<div class="br-theme-fontawesome-stars-o">
											<div class="br-widget">
							<?php
											for( $i=1; $i <= $overall_rating; $i++ ) {
												echo '<a href="javascript:;" class="br-selected"></a>';
											}
											
											$empty_star = 5 - $overall_rating;
											
											if(!empty($empty_star))
											{
												for( $i=1; $i <= $empty_star; $i++ ) {
													echo '<a href="javascript:;"></a>';
												}
											}
								?>
											</div>
										</div>
								<?php
										}
								?>
									</div>
								<?php
									}    
					    		?>
			        	    </div>
						</div>
					</div>
					
					<br class="clear"/>
	<?php
				}
			}
		}
		
		echo stripslashes($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['tourcat'] = strip_tags($new_instance['tourcat']);
		$instance['sortby'] = strip_tags($new_instance['sortby']);

		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'items' => 3, 'tourcat' => '', 'sortby' => '', 'title' => '') );
		$items = strip_tags($instance['items']);
		$tourcat = strip_tags($instance['tourcat']);
		$sortby = strip_tags($instance['sortby']);
		$title = strip_tags($instance['title']);
?>
			<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title: <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('items')); ?>"><?php esc_html_e( 'Items:', 'grandtour' ); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('items')); ?>" name="<?php echo esc_attr($this->get_field_name('items')); ?>" type="text" value="<?php echo esc_attr($items); ?>" /></label></p>
			
			<?php
				//Get all tour categories
				$tour_cat_select = array();
				$tour_cat_select[''] = '';
				
				//Check if custom post type plugin is installed	
				$grandtour_custom_post = ABSPATH . '/wp-content/plugins/grandtour-custom-post/grandtour-custom-post.php';
				$grandtour_custom_post_activated = file_exists($grandtour_custom_post);
				
				if($grandtour_custom_post_activated)
				{
					$tour_cat_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=post_title&order=ASC');
					
					foreach ($tour_cat_arr as $tour_cat) {
						$tour_cat_select[$tour_cat->slug] = $tour_cat->name;
					}
				}	
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('tourcat')); ?>"><?php esc_html_e( 'Tour Category:', 'grandtour' ); ?>
					
					<select class="widefat" id="<?php echo esc_attr($this->get_field_id('tourcat')); ?>" name="<?php echo esc_attr($this->get_field_name('tourcat')); ?>">
						<option value="0"><?php esc_html_e( 'Any Tour Category', 'grandtour' ); ?></option>
						<?php
							if(!empty($tour_cat_select) && is_array($tour_cat_select))
							{
								foreach ($tour_cat_select as $key => $tour_cat) 
								{
									if(!empty($key) && !empty($tour_cat))
									{
						?>
								<option value="<?php echo esc_attr($key); ?>" <?php if($key==$tourcat) { ?>selected<?php } ?>><?php echo esc_html($tour_cat); ?></option>
						<?php
									}
								}
							}
						?>
					</select>
				</label>
			</p>
			
			<?php
				//Get all sort by options
				$tour_sortby_select = grandtour_get_sort_options();	
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('sortby')); ?>"><?php esc_html_e( 'Sort By:', 'grandtour' ); ?>
					
					<select class="widefat" id="<?php echo esc_attr($this->get_field_id('sortby')); ?>" name="<?php echo esc_attr($this->get_field_name('sortby')); ?>">
						<?php
							if(!empty($tour_sortby_select) && is_array($tour_sortby_select))
							{
								foreach ($tour_sortby_select as $key => $tour_sortby) 
								{
									if(!empty($key) && !empty($tour_sortby))
									{
						?>
								<option value="<?php echo esc_attr($key); ?>" <?php if($key==$sortby) { ?>selected<?php } ?>><?php echo esc_html($tour_sortby); ?></option>
						<?php
									}
								}
							}
						?>
					</select>
				</label>
			</p>
<?php
	}
}

register_widget('Grandtour_Tour_Posts');

/**
*	End Tour Posts Custom Widgets
**/
?>
