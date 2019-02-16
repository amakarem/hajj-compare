<?php
 $tg_blog_display_tags = kirki_get_option('tg_blog_display_tags');

    if(has_tag() && !empty($tg_blog_display_tags))
    {
?>
    <div class="post_excerpt post_tag">
    	<?php
	    	if( $tags = get_the_tags() ) {
			    foreach( $tags as $tag ) {
			        echo '<a href="' . get_term_link( $tag, $tag->taxonomy ) . '">#' . $tag->name . '</a>';
			    }
			}	
	   	?>
    </div>
<?php
    }
?>

<div id="post_share_text" class="post_share_text"><span class="ti-share"></span></div>
<br class="clear"/>
