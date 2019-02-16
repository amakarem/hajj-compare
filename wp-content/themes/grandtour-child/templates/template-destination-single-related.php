<?php
    $tg_tour_display_related = kirki_get_option('tg_tour_display_related');
    $tg_tour_related_layout = kirki_get_option('tg_tour_related_layout');
    
    $wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	$items = 3;
	
	switch($tg_tour_related_layout)
	{
		case 2:
		default:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
			$items = 2;
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
			$items = 3;
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
			$items = 4;
		break;
	}
    
    if(!empty($tg_tour_display_related))
    {    
		$destination_tours = get_post_meta(get_the_ID(), 'destination_tour', true);
		
		if(!empty($destination_tours) && is_array($destination_tours)) 
		{
 ?>
  	<div class="tour_related">
	<h3 class="sub_title"><?php echo esc_html_e('Related Tours', 'grandtour' ); ?></h3>

	<div id="portfolio_filter_wrapper" class="gallery classic <?php echo esc_attr($wrapper_class); ?> portfolio-content section content clearfix" data-columns="<?php echo esc_attr($tg_tour_related_layout); ?>">
    <?php
       	foreach($destination_tours as $destination_tour)
       	{
	       	$image_url = '';
			$tour_ID = $destination_tour;
					
			if(has_post_thumbnail($tour_ID, 'grandtour-gallery-grid'))
			{
			    $image_id = get_post_thumbnail_id($tour_ID);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($tour_ID);
    ?>
    <div class="element grid <?php echo esc_attr($grid_wrapper_class); ?>">
		<div class="<?php echo esc_attr($column_class); ?> classic static filterable portfolio_type themeborder">
			<?php 
				if(!empty($small_image_url[0]))
				{
			?>		
					<a class="tour_image" href="<?php echo esc_url($permalink_url); ?>">
						<img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
						
						<?php
							//Get tour label
							$tour_label = get_post_meta($tour_ID, 'tour_label', true);
							
							if(!empty($tour_label))
							{
						?>
						<div class="tour_label"><?php echo esc_html($tour_label); ?></div>
						<?php
							}	
						?>
						
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
	                </a>
					
					<div class="portfolio_info_wrapper">
        			    <a class="tour_link" href="<?php echo esc_url($permalink_url); ?>"><h4><?php echo get_the_title($tour_ID); ?></h4></a>
        			    <div class="tour_excerpt"><?php echo grandtour_get_excerpt_by_id($tour_ID); ?></div>
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
									
									if($overall_rating_count > 0)
									{
							?>
									<div class="tour_attribute_rating_count">
										<?php echo intval($overall_rating_count); ?>&nbsp;
										<?php
											if($overall_rating_count > 1)
											{
												echo esc_html__('reviews', 'grandtour' );
											}
											else
											{
												echo esc_html__('review', 'grandtour' );
											}
										?>
									</div>
							<?php
									}
							?>
								</div>
							<?php
								}    
		        			?>
		        			
		        			<?php
			        			$tour_days = get_post_meta($tour_ID, 'tour_days', true);	
			        			
			        			if(!empty($tour_days))
			        			{
			        		?>
		        			    <div class="tour_attribute_days">
			        			    <span class="ti-time"></span>
			        			    <?php
										//Display tour durations
										echo grandtour_get_tour_duration($tour_ID);
									?>
		        			    </div>
		        			<?php
			        			}
			        		?>
        			    </div>
        			    <br class="clear"/>
				    </div>
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
<?php
	 }
} //end if show related
?>
