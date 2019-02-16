<?php
//Add data for recently viewed tours
grandtour_set_recently_view_tours();

/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

get_header(); 

//Include custom header feature
get_template_part("/templates/template-tour-header");

$page_tagline = get_the_excerpt();
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">
	    	
    		<?php
	    		//Get how single tour content display on mobile
	    		$tg_tour_single_mobile_content = kirki_get_option('tg_tour_single_mobile_content');
	    		
	    		if($tg_tour_single_mobile_content == 'booking')
	    		{
		    		//Include tour booking
					get_template_part("/templates/template-tour-single-booking");	
					
		    		//Include tour content
					get_template_part("/templates/template-tour-single-content");
				}
				else
				{
					//Include tour content
					get_template_part("/templates/template-tour-single-content");
					
					//Include tour booking
					get_template_part("/templates/template-tour-single-booking");
				}
	    	?>
    	</div>
    </div>
    <!-- End main content -->
    
    <?php
	  	//Include related tours
	  	get_template_part("/templates/template-tour-single-related");
	?>
   
</div>
<br class="clear"/>
</div>
<?php get_footer(); ?>
