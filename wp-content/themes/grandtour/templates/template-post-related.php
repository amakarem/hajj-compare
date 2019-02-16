<?php
    $tg_blog_display_related = kirki_get_option('tg_blog_display_related');
    
    if($tg_blog_display_related)
    {
?>

<?php
//for use in the loop, list 9 post titles related to post's tags on current post
$tags = wp_get_post_tags($post->ID);

if ($tags) {

    $tag_in = array();
  	//Get all tags
  	foreach($tags as $tags)
  	{
      	$tag_in[] = $tags->term_id;
  	}

  	$args=array(
      	  'tag__in' => $tag_in,
      	  'post__not_in' => array($post->ID),
      	  'showposts' => 3,
      	  'ignore_sticky_posts' => 1,
      	  'orderby' => 'date',
      	  'order' => 'DESC'
  	 );
  	$my_query = new WP_Query($args);
  	$i_post = 1;
  	
  	if( $my_query->have_posts() ) {
 ?>
  	<div class="post_related">
	<h5 class="subtitle"><span><?php echo esc_html_e('You might also like', 'grandtour' ); ?></span></h5>
    <?php
       while ($my_query->have_posts()) : $my_query->the_post();
       
       $last_class = '';
       if($i_post%3==0)
       {
	       $last_class = 'last';
       }
       
       $image_thumb = '';
					
		if(has_post_thumbnail(get_the_ID(), 'large'))
		{
		    $image_id = get_post_thumbnail_id(get_the_ID());
		    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
		}
    ?>
       <div class="one_third <?php echo esc_attr($last_class); ?>">
		   <!-- Begin each blog post -->
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
				<div class="post_wrapper grid_layout">
				
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
					
					    	    <div class="post_img small static">
					    	    	<a href="<?php the_permalink(); ?>">
					    	    		<img src="<?php echo esc_url($small_image_url[0]); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="" />
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
					    	
					    } //End switch
					?>
				    
				    <div class="post_header_wrapper">
						<div class="post_header grid">
							<div class="post_detail single_post">
							    <span class="post_info_date">
							    	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U')); ?></a>
							    </span>
							</div>
						    <h6><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
						</div>
				    </div>
				    
				</div>
			
			</div>
			<!-- End each blog post -->
       </div>
     <?php
     		$i_post++;
	 		endwhile;
	 		
	 		wp_reset_postdata();
     ?>
  	</div>
<?php
  	}
}
    } //end if show related
?>
