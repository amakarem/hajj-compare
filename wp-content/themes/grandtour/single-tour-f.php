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
get_template_part("/templates/template-tour-f-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">
	    	
    		<?php
	    		//Include tour content
				get_template_part("/templates/template-tour-single-content");
	    	?>
    
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
