<?php
/**
 * The main template file for display page.
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

$page_sidebar = get_post_meta($current_page_id, 'destination_sidebar', true);

if(empty($page_sidebar))
{
	$page_sidebar = 'Page Sidebar';
}

get_header(); 
?>

<?php
    //Include custom header feature
	get_template_part("/templates/template-header");
?>

    <div class="inner">
    
    <!-- Begin main content -->
    <div class="inner_wrapper">
	    
	    <?php
		    //Check related tour order
		    $tg_destination_single_tour_order = kirki_get_option('tg_destination_single_tour_order');
		    
		    if($tg_destination_single_tour_order == 'before')
		    {
		  		//Include related tours
		  		get_template_part("/templates/template-destination-single-related");
		  	}
		?>
        	
        <div class="sidebar_content full_width ">
        	<div class="sidebar_content page_content">
	        	<blockquote><?php the_excerpt(); ?></blockquote>
	        	
	        	 <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				 	<?php the_content(); ?>
				 <?php endwhile; ?>
				 
				<?php
			 		//Check if enable tour sharing
			 		$tg_tour_single_share = kirki_get_option('tg_tour_single_share');
			 		
			 		if(!empty($tg_tour_single_share))
			 		{
			 	?>
			 	<a id="single_tour_share_button" href="javascript:;" class="button ghost themeborder" style="width:auto;"><span class="ti-email"></span><?php esc_html_e("Share this tour", 'grandtour'); ?></a>
			 	<?php
			 		}
			 	?>
				 
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
        	</div>
        	
        	<div class="sidebar_wrapper">
	            <div class="sidebar">
	            
	            	<div class="content">
	            
	            		<?php 
						$page_sidebar = sanitize_title($page_sidebar);
						
						if (is_active_sidebar($page_sidebar)) { ?>
		    	    		<ul class="sidebar_widget">
		    	    		<?php dynamic_sidebar($page_sidebar); ?>
		    	    		</ul>
		    	    	<?php } ?>
	            	
	            	</div>
	        
	            </div>
				<br class="clear"/>
			</div>
        </div>
    
		<?php
			if($tg_destination_single_tour_order == 'after')
		    {
		  		//Include related tours
		  		get_template_part("/templates/template-destination-single-related");
		  	}
		?>
    
    </div>
    <!-- End main content -->
    
    </div>
</div>
<br class="clear"/>
<?php get_footer(); ?>
