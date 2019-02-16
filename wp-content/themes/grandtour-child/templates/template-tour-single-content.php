<?php
	//Get current tour layout
	$tour_layout = get_post_meta($post->ID, 'tour_layout', true);	
?>

<div class="sidebar_content <?php if($tour_layout == 'Fullwidth') { ?>full_width<?php } ?>">
					
	<?php
		//If single tour fullwidth layout, display title
		if($tour_layout != 'Fullwidth')
		{
	?>

		<?php
			//Get tour label
			$tour_label = get_post_meta($post->ID, 'tour_label', true);
			
			if(!empty($tour_label))
			{
		?>
		<div class="tour_label sidebar"><?php echo esc_html($tour_label); ?></div>
		<?php
			}	
		?>
	<?php
			//Display tour tagline
			if(!empty($page_tagline))
			{
	?>
			<div class="page_tagline">
				<?php echo nl2br($page_tagline); ?>
			</div>
	<?php
			}
		}
		
		//Display tour attributes
		$tour_days = get_post_meta($post->ID, 'tour_days', true);
		$tour_minimum_age = get_post_meta($post->ID, 'tour_minimum_age', true);
		$tour_months = get_post_meta($post->ID, 'tour_months', true);
		$tour_availability = get_post_meta($post->ID, 'tour_availability', true);
		$tour_price = get_post_meta($post->ID, 'tour_price', true);
		
		$tour_attribute_class = 'one_fourth';
		if($tour_layout == 'Fullwidth')
		{
			$tour_attribute_class = 'one_fifth';
		}
		
		if(!empty($tour_days) OR !empty($tour_minimum_age) OR !empty($tour_months) OR !empty($tour_availability))
		{
	?>
		<div class="single_tour_attribute_wrapper themeborder <?php echo esc_attr(strtolower($tour_layout)); ?>">
			<?php
				if(!empty($tour_price))
				{
			?>
				<div class="one_third nomarginr">
					<div class="tour_attribute_icon fas fa-dollar-sign"></div>
					<div class="tour_attribute_content"></i>
					<?php echo esc_html(grandtour_format_tour_price($tour_price)); ?>
					</div>
				</div>
			<?php
				}
			?>

			<?php
				if(!empty($tour_days))
				{
			?>
				<div class="one_third nomarginr">
					<div class="tour_attribute_icon far fa-clock"></div>
					<div class="tour_attribute_content">
					<?php
						//Display tour durations
						echo grandtour_get_tour_duration($post->ID);
					?>
					</div>
				</div>
			<?php
				}
			?>
			
			<?php
				if(!empty($tour_months))
				{
			?>
				<div class="one_third nomarginr">
					<div class="tour_attribute_icon far fa-calendar-alt"></div>
					<div class="tour_attribute_content">
						<?php 
							if(is_array($tour_months))
							{
								if(count($tour_months) == 12)
								{
									echo esc_html__("All Months", 'grandtour');
								}
								else
								{
									$i = 0;
									$len = count($tour_months);
									foreach($tour_months as $tour_month)
									{
										echo date_i18n("M", strtotime("1 ".$tour_month." 2017"));
										
										if ($i != $len - 1) 
										{
											echo ',&nbsp;';
										}
										
										$i++;
									}
								}
							}
						?>
					</div>
				</div>
			<?php
				}
			?>
			
			
			<?php
				if($tour_layout == 'Fullwidth')
				{
					//Get tour price
		 			//$tour_price = get_post_meta($post->ID, 'tour_price', true);
		 			
		 			if(!empty($tour_price))
		 			{
		 				$tour_discount_price = get_post_meta($post->ID, 'tour_discount_price', true);
		 	?>
		 		<div class="<?php echo esc_attr($tour_attribute_class); ?> last" style="position:relative;">
			 		<?php
						//Get tour label
						$tour_label = get_post_meta($post->ID, 'tour_label', true);
						
						if(!empty($tour_label))
						{
					?>
					<div class="tour_label"><?php echo esc_html($tour_label); ?></div>
					<?php
						}	
					?>
					<div class="tour_attribute_icon ti-money"></div>
					<div class="tour_attribute_content">
						<div class="single_tour_price <?php echo esc_attr(strtolower($tour_layout)); ?>">
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
					</div>
				</div>
		 	<?php
		 			}
		 		}	
			?>
		</div><br class="clear"/>
	<?php
		}
		
		if (have_posts()) : while (have_posts()) : the_post();
	?>
		<div class="single_tour_content">
	    	<?php the_content(); ?>
		</div>
	<?php endwhile; endif; ?>
	
	<?php
		//If single tour fullwidth layout, display book, share buttons
		if($tour_layout == 'Fullwidth')
		{
	?>
		<br class="clear"/><div class="single_tour_after_content_wrapper">
	<?php
		   //Get tour booking method
		   $tour_booking_method = get_post_meta($post->ID, 'tour_booking_method', true);
		   
		   //Check how to display booking form
		   switch($tour_booking_method)
		   {
		   	case 'contact_form7':
		   	default:
		?>
		<a href="javascript:;" id="single_tour_book_after_content_open" class="button" data-type="inline"><?php esc_html_e('Book This Tour', 'grandtour' ); ?></a>
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
		<a href="javascript:;" id="single_tour_book_after_content_open" class="button" data-type="inline"><?php esc_html_e('Book This Tour', 'grandtour' ); ?></a>
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
 		//Check if enable tour sharing
 		$tg_tour_single_share = kirki_get_option('tg_tour_single_share');
 		
 		if(!empty($tg_tour_single_share))
 		{
 	?>
 	<a id="single_tour_share_button" href="javascript:;" class="button ghost themeborder"><span class="ti-email"></span><?php esc_html_e("Share this tour", 'grandtour'); ?></a>
 	<?php
 			}
 	?>
		</div>
	<?php
 		}
 	?>
	
	<?php
	    //Display tour departure information
	    $tour_departure = get_post_meta($post->ID, 'tour_departure', true);
	    $tour_departure_time = get_post_meta($post->ID, 'tour_departure_time', true);
	    $tour_return_time = get_post_meta($post->ID, 'tour_return_time', true);
	    $tour_included = get_post_meta($post->ID, 'tour_included', true);
	    $tour_not_included = get_post_meta($post->ID, 'tour_not_included', true);
	    $tour_map_address = get_post_meta($post->ID, 'tour_map_address', true);
	?>
	<ul class="single_tour_departure_wrapper themeborder">
		<?php
			if(!empty($tour_departure))
			{
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Departure", 'grandtour'); ?></div>
			<div class="single_tour_departure_content"><?php echo esc_html($tour_departure); ?></div>
		</li>
		<?php
			}
		?>
		
		<?php
			if(!empty($tour_departure_time))
			{
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Departure Time", 'grandtour'); ?></div>
			<div class="single_tour_departure_content"><?php echo esc_html($tour_departure_time); ?></div>
		</li>
		<?php
			}
		?>
		
		<?php
			if(!empty($tour_return_time))
			{
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Return Time", 'grandtour'); ?></div>
			<div class="single_tour_departure_content"><?php echo esc_html($tour_return_time); ?></div>
		</li>
		<?php
			}
		?>
		
		<?php
			if(!empty($tour_included))
			{
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Included", 'grandtour'); ?></div>
			<div class="single_tour_departure_content">
				<?php
					if(!empty($tour_included) && is_array($tour_included))
					{
						foreach($tour_included as $key => $tour_included_item)
						{
							$last_class = '';
							if(($key+1)%2 == 0)	
							{
								$last_class = 'last';
							}
				?>
				<div class="one_half <?php echo esc_attr($last_class); ?>">
					<span class="ti-check"></span><?php echo esc_html($tour_included_item); ?>
				</div>
				<?php
						}
					}
				?>
			</div>
		</li>
		<?php
			}
		?>
		
		<?php
			if(!empty($tour_included))
			{
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Not Included", 'grandtour'); ?></div>
			<div class="single_tour_departure_content">
				<?php
					if(!empty($tour_not_included) && is_array($tour_not_included))
					{
						foreach($tour_not_included as $key => $tour_not_included_item)
						{
							$last_class = '';
							if(($key+1)%2 == 0)	
							{
								$last_class = 'last';
							}
				?>
				<div class="one_half <?php echo esc_attr($last_class); ?>">
					<span class="ti-close"></span><?php echo esc_html($tour_not_included_item); ?>
				</div>
				<?php
						}
					}
				?>
			</div>
		</li>
		<?php
			}
		?>
		
		<?php
			if(!empty($tour_map_address))
			{
				$tg_tour_map_marker = kirki_get_option('tg_tour_map_marker');
		?>
		<li>
			<div class="single_tour_departure_title"><?php esc_html_e("Maps", 'grandtour'); ?></div>
			<div class="single_tour_departure_content"><?php echo do_shortcode('[tg_map width="1000" height="300" address="'.esc_attr($tour_map_address).'" zoom="13" marker="'.esc_url($tg_tour_map_marker).'"]'); ?></div>
		</li>
		<?php
			}
		?>
	</ul>

	<?php
		//Check if enable tour review
		$tg_tour_single_review = kirki_get_option('tg_tour_single_review');
		
		//Display tour comment
		if (comments_open($post->ID) && !empty($tg_tour_single_review)) 
		{
	?>
		<div class="fullwidth_comment_wrapper sidebar">
			<?php comments_template( '', true ); ?>
		</div>
	<?php
		}
	?>
		
</div>
