<?php
	$wp_query = grandtour_get_wp_query();
	
	$query_string = 'paged='.$paged;
	$query_string.= grandtour_get_initial_tour_query();
	
	if(!empty($term))
	{
		$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$custom_tax = $wp_query->query_vars['taxonomy'];
	    $query_string .= '&'.$custom_tax.'='.$term;
	}
	
	parse_str($query_string, $args);
    
    if(isset($_GET['keyword']) && !empty($_GET['keyword']))
    {  
    	/*$args['tax_query'][] = array(
		    array(
		        'taxonomy' => 'tourtag',
		        'field' => 'name',
		        'terms' => $_GET['keyword']
		    )
		);*/
        $args['s'] = $_GET['keyword'];
    }
    
    if(isset($_GET['month']) && !empty($_GET['month']))
    { 
    	$args['meta_query'][] = array(
        	'key' => 'tour_months',
        	'value' => $_GET['month'],
        	'type' => 'CHAR',
        	'compare' => 'LIKE'
        );
    }
    
    if(isset($_GET['tourcat']) && !empty($_GET['tourcat']))
    { 
    	$args['tourcat'] = $_GET['tourcat'];
    }
    
    if(isset($_GET['budget']) && !empty($_GET['budget']))
    {
    	$args['meta_query'][] = array(
        	'key' => 'tour_price',
        	'value' => $_GET['budget'],
        	'type' => 'numeric',
        	'compare' => '<='
        );
    }
    
    if(isset($_GET['destination_id']) && !empty($_GET['destination_id']))
    { 
    	$selected_destination_tours = get_post_meta($_GET['destination_id'], 'destination_tour', true);
    	
    	if(!empty($selected_destination_tours) && is_array($selected_destination_tours))
    	{
	    	$args['post__in'] = $selected_destination_tours;
    	}
    	else
    	{
	    	$args['post__in'] = array(1);
    	}
    }
    
    if(isset($_GET['sort_by']) && !empty($_GET['sort_by']))
    { 
    	switch($_GET['sort_by'])
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
	    	
	    	case 'popular':
	    		$args['orderby'] = 'post_views';
	    		$args['order'] = 'DESC';
	    	break;
	    	
	    	case 'review':
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'average_rating';
	    		$args['order'] = 'DESC';
	    	break;
    	}
    }
    
    query_posts($args);
    
    if(empty($term))
	{
		wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
?>
<form id="tour_search_form" name="tour_search_form" method="get" action="<?php echo get_the_permalink($id); ?>">
    <div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    		<input id="keyword" name="keyword" type="text" autocomplete="off" placeholder="<?php esc_html_e('Destination, city', 'grandtour' ); ?>" <?php if(isset($_GET['keyword'])) { ?>value="<?php echo esc_attr($_GET['keyword']); ?>"<?php } ?>/>
    		<span class="ti-search"></span>
    		<div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
    	</div>
    	<div class="one_fourth themeborder">
	    	<?php
		    	//Get available months
		    	$available_months = grandtour_get_months();
		    ?>
    		<select id="month" name="month">
	    		<option value=""><?php esc_html_e('Any Month', 'grandtour' ); ?></option>
	    		<?php
		    		foreach($available_months as $key => $available_month)	
		    		{
			    ?>
			    	<option value="<?php echo esc_attr($key); ?>" <?php if(isset($_GET['month']) && $_GET['month']==$key) { ?>selected<?php } ?>><?php echo esc_attr($available_month); ?></option>
			    <?php	
			    	}
		    	?>
    		</select>
    		<span class="ti-calendar"></span>
    	</div>
    	<div class="one_fourth themeborder">
    		<?php
		    	//Get available months
		    	$sort_options = grandtour_get_sort_options();
		    ?>
    		<select id="sort_by" name="sort_by">
	    		<?php
		    		foreach($sort_options as $key => $sort_option)	
		    		{
			    ?>
			    	<option value="<?php echo esc_attr($key); ?>" <?php if(isset($_GET['sort_by']) && $_GET['sort_by']==$key) { ?>selected<?php } ?>><?php echo esc_attr($sort_option); ?></option>
			    <?php	
			    	}
		    	?>
    		</select>
    		<span class="ti-exchange-vertical"></span>
    	</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="<?php echo _e( 'Search', 'grandtour' ); ?>"/>
    	</div>
    	
    	<?php
	    	//Check if enable advanced search
	    	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	    	
	    	if(!empty($tg_tour_advanced_search))
	    	{
	    ?>
    	<br class="clear"/>
    	<div class="tour_advance_search_wrapper">
	    	<div class="one_fourth themeborder">
		    	<select id="tourcat" name="tourcat">
	    			<option value=""><?php esc_html_e('All Categories', 'grandtour' ); ?></option>
			    	<?php
				    	//Get tour categories list
						$tour_cats_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
						
						if(!empty($tour_cats_arr))
						{
							foreach($tour_cats_arr as $key => $tour_cat)	
							{
					?>
						<option value="<?php echo esc_attr($tour_cat->slug); ?>" <?php if(isset($_GET['tourcat']) && $_GET['tourcat']==$tour_cat->slug) { ?>selected<?php } ?>><?php echo esc_attr($tour_cat->name); ?></option>
					<?php
							}
						}
				    ?>
		    	</select><span class="ti-angle-down"></span>
	    	</div>
	    	
	    	<div class="one_fourth themeborder">
		    	<select id="destination_id" name="destination_id">
	    			<option value=""><?php esc_html_e('Any Destinations', 'grandtour' ); ?></option>
			    	<?php
				    	//Get destination items
					    $args = array(
						    'numberposts' => -1,
						    'post_type' => array('destination'),
						    'suppress_filters' => false,
						    'orderby' => 'title',
						    'order' => 'ASC'
						);
						$destination_arr = get_posts($args);
						
						if(!empty($destination_arr))
						{
							foreach($destination_arr as $key => $destination)	
							{
					?>
						<option value="<?php echo esc_attr($destination->ID); ?>" <?php if(isset($_GET['destination_id']) && $_GET['destination_id']==$destination->ID) { ?>selected<?php } ?>><?php echo esc_attr($destination->post_title); ?></option>
					<?php
							}
						}
				    ?>
		    	</select><span class="ti-angle-down"></span>
	    	</div>
	    	
	    	<div class="one_fourth themeborder">
		    	<input id="budget" name="budget" type="text" placeholder="<?php esc_html_e('Max budget ex. 500', 'grandtour' ); ?>" <?php if(isset($_GET['budget'])) { ?>value="<?php echo esc_attr($_GET['budget']); ?>"<?php } ?>/>
		    	<?php
			    	//Get currency setting
			    	$tg_tour_currency = kirki_get_option('tg_tour_currency');
			    ?>
		    	<span><?php echo esc_attr($tg_tour_currency); ?></span>
	    	</div>
    	</div>
    	
    	<div class="tour_advance_search_wrapper_link">
	    	<a id="tour_advance_search_toggle" class="theme_link_color" href="javascript:;"><span class="icon ti-angle-down"></span><?php esc_html_e( 'Advanced Search', 'grandtour' ); ?></a>
    	</div>
    	<?php
	    	}
	    ?>
    </div>
</form>
<?php
	}
?>
