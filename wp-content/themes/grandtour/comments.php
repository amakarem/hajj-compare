<?php
//Required password to comment
if ( post_password_required() ) { ?>
	<p><?php esc_html_e( 'This post is password protected. Enter the password to view comments.', 'grandtour' ); ?></p>
<?php
	return;
}
?>
<?php 
//Display Comments
if( have_comments() ) : ?> 

<?php
	if($post->post_type != 'tour')
	{
?>
	<h3 class="comment_title"><?php comments_number(esc_html__( 'Leave A Reply', 'grandtour' ), esc_html__( '1 Comment', 'grandtour' ), '% '.esc_html__( 'Comments', 'grandtour' )); ?></span></h3>
	
<?php
	}
	else
	{
?>
	<h3 class="comment_title"><?php comments_number(esc_html__( 'Leave A Review', 'grandtour' ), esc_html__( '1 Review', 'grandtour' ), '% '.esc_html__( 'Reviews', 'grandtour' )); ?></span></h3>
<?php
		$comment_number = get_comments_number($post->ID);
		
		if(!empty($comment_number))
		{
?>
		<div class="avg_comment_rating_wrapper themeborder">
<?php
			$accomodation_rating_arr = grandtour_get_review($post->ID, 'accomodation_rating');
			$accomodation_rating = intval($accomodation_rating_arr['average']);
			
			if(!empty($accomodation_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Accomodation', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $accomodation_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $accomodation_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
			
			$destination_rating_arr = grandtour_get_review($post->ID, 'destination_rating');
			$destination_rating = intval($destination_rating_arr['average']);
			
			if(!empty($destination_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Destination', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $destination_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $destination_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
			
			$meals_rating_arr = grandtour_get_review($post->ID, 'meals_rating');
			$meals_rating = intval($meals_rating_arr['average']);
			
			if(!empty($meals_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Meals', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $meals_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $meals_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
			
			$transport_rating_arr = grandtour_get_review($post->ID, 'transport_rating');
			$transport_rating = intval($transport_rating_arr['average']);
			
			if(!empty($transport_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Transport', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $transport_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $transport_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
			
			$value_rating_arr = grandtour_get_review($post->ID, 'value_rating');
			$value_rating = intval($value_rating_arr['average']);
			
			if(!empty($value_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Value For Money', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $value_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $value_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
			
			$overall_rating_arr = grandtour_get_review($post->ID, 'overall_rating');
			$overall_rating = intval($overall_rating_arr['average']);
			
			if(!empty($overall_rating_arr))
			{
				$return_html = '';
				$return_html.= '<div class="comment_rating_wrapper">';
				$return_html.= '<div class="comment_rating_label">'.esc_html__('Overall', 'grandtour').'</div>';
				
				$return_html.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
				
				for( $i=1; $i <= $overall_rating; $i++ ) {
					$return_html.= '<a href="javascript:;" class="br-selected"></a>';
				}
				
				$empty_star = 5 - $overall_rating;
				
				if(!empty($empty_star))
				{
					for( $i=1; $i <= $empty_star; $i++ ) {
						$return_html.= '<a href="javascript:;"></a>';
					}
				}
				
				$return_html.= '</div></div></div>';
				echo $return_html;
			}
?>
		</div>
<?php
		}
	}
?>
<div>
	<a name="comments"></a>
	<?php wp_list_comments( array('callback' => 'grandtour_comment', 'avatar_size' => '40') ); ?>
</div>

<!-- End of thread -->  
<div style="height:10px"></div>

<?php endif; ?> 


<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

<div class="pagination"><p><?php previous_comments_link('<'); ?> <?php next_comments_link('>'); ?></p></div><br class="clear"/>

<?php endif; // check for comment navigation ?>


<?php 
//Display Comment Form
if ('open' == $post->comment_status) : ?> 

<?php 
	if($post->post_type != 'tour')
	{
		comment_form(array(
		    'title_reply' => esc_html__( 'Leave A Reply', 'grandtour' )
		));
	}
	else
	{
		comment_form(array(
		    'title_reply' => esc_html__( 'Write A Review', 'grandtour' )
		));
	}
?>
			
<?php endif; ?>
