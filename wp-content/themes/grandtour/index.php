<?php
/**
 * The main template file.
 *
 * @package WordPress
 */

get_header();

//Include post featured slider
$tg_blog_slider_layout = kirki_get_option('tg_blog_slider_layout');

if(GRANDTOUR_THEMEDEMO && isset($_GET['slider']))
{
	$tg_blog_slider_layout = $_GET['slider'];
}

if(!empty($tg_blog_slider_layout))
{
	get_template_part("/templates/template-".$tg_blog_slider_layout);
}
?>

<div id="page_content_wrapper" class="blog_wrapper">
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    		<div class="sidebar_content">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();
	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<?php
			    //Get post featured content
			    $post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);
			    
			    switch($post_ft_type)
			    {
			    	case 'Image':
			    	default:
			        	if(!empty($image_thumb))
			        	{
			        		$small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-blog', true);
			?>
			
			    	    <div class="post_img static">
			    	    	<a href="<?php the_permalink(); ?>">
			    	    		<?php the_post_thumbnail('grandtour-blog'); ?>
				            </a>
			    	    </div>
			
			<?php
			    		}
			    	break;
			    	
			    	case 'Vimeo Video':
			    		$post_ft_vimeo = get_post_meta(get_the_ID(), 'post_ft_vimeo', true);
			?>
			    		<?php echo do_shortcode('[tg_vimeo video_id="'.esc_attr($post_ft_vimeo).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Youtube Video':
			    		$post_ft_youtube = get_post_meta(get_the_ID(), 'post_ft_youtube', true);
			?>
			    		<?php echo do_shortcode('[tg_youtube video_id="'.esc_attr($post_ft_youtube).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Gallery':
			    		$post_ft_gallery = get_post_meta(get_the_ID(), 'post_ft_gallery', true);
			?>
			    		<?php echo do_shortcode('[tg_gallery_slider gallery_id="'.esc_attr($post_ft_gallery).'" width="670" height="270"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    } //End switch
			?>
			<div class="post_header_wrapper">
				<div class="post_header">
					<div class="post_detail single_post">
				    		<span class="post_info_date">
					    		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U')); ?></a>
				    		</span>
				    		<span class="post_info_comment">
				    			•
				    			<a href="<?php comments_link(); ?>">
				    				<?php 
					    				$post_comment_number = get_comments_number();
					    				echo intval($post_comment_number).'&nbsp;';
					    				
					    				if($post_comment_number <= 1)
					    				{
						    				echo esc_html_e('Comment', 'grandtour' );
					    				}
					    				else
					    				{
						    				echo esc_html_e('Comments', 'grandtour' );
					    				}
				    				?>
				    			</a>
				    		</span>
						</div>
			    	<div class="post_header_title">
				    	<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			    	</div>
			    </div>
					
			    <br class="clear"/>
			    
			    <?php
			    	$tg_blog_display_full = kirki_get_option('tg_blog_display_full');
			    	
			    	if(!empty($tg_blog_display_full))
			    	{
			    		the_content();
			    	}
			    	else
			    	{
			    		the_excerpt();
			    	}
			    ?>
			    <div class="post_button_wrapper">
			    	<a class="readmore" href="<?php the_permalink(); ?>"><?php echo esc_html_e('Read More', 'grandtour' ); ?><span class="ti-angle-right"></span></a>
			    </div>
			</div>
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

	    	<?php
	    	if($wp_query->max_num_pages > 1)
			{
				if (function_exists("grandtour_pagination")) 
				{
				    grandtour_pagination($wp_query->max_num_pages);
				}
				else
				{
				?>
				    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
				<?php
				}
			?>
			<div class="pagination_detail">
		     	<?php
		     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		     	?>
		     	<?php esc_html_e('Page', 'grandtour' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'grandtour' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
		     </div>
		     <?php
		     }
		     ?>
    		
			</div>
    	
    		<div class="sidebar_wrapper">
    		
    			<div class="sidebar_top"></div>
    		
    			<div class="sidebar">
    			
    				<div class="content">

    					<?php 
						if (is_active_sidebar('page-sidebar')) { ?>
		    	    		<ul class="sidebar_widget">
		    	    		<?php dynamic_sidebar('page-sidebar'); ?>
		    	    		</ul>
		    	    	<?php } ?>
    				
    				</div>
    		
    			</div>
    			<br class="clear"/>
    	
    			<div class="sidebar_bottom"></div>
    		</div>
    		
    	</div>
    <!-- End main content -->

</div>
</div>
<?php get_footer(); ?>
