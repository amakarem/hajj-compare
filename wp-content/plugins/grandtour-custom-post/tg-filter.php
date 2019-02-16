<?php
function grandtour_tourcat_custom_fields($tag) {

   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="tourcat_template"><?php _e('Tour Category Page Template', 'grandtour'); ?></label>
	</th>
	<td>
		<select name="tourcat_template" id="tourcat_template">
			<?php
				$tg_tour_archive_templates = array(
				  'tour-2-classic'		=> 'Tour 2 Columns Classic',
				  'tour-3-classic'		=> 'Tour 3 Columns Classic',
				  'tour-4-classic'		=> 'Tour 4 Columns Classic',
				  'tour-2-classic-r'	=> 'Tour Classic Right Sidebar',
				  'tour-2-classic-l'	=> 'Tour Classic Left Sidebar',
				  'tour-2-grid'			=> 'Tour 2 Columns Grid',
				  'tour-3-grid'			=> 'Tour 3 Columns Grid',
				  'tour-4-grid'			=> 'Tour 4 Columns Grid',
				  'tour-2-grid-r'		=> 'Tour Grid Right Sidebar',
				  'tour-2-grid-l'		=> 'Tour Grid Left Sidebar',
				  'tour-list-r'			=> 'Tour List Right Sidebar',
				  'tour-list-l'			=> 'Tour List Left Sidebar',
				);
				
				foreach($tg_tour_archive_templates as $key => $tg_tour_archive_template)
				{
			?>
			<option value="<?php echo esc_attr($key); ?>" <?php if($term_meta['tourcat_template']==$key) { ?>selected<?php } ?>><?php echo esc_html($tg_tour_archive_template); ?></option>
			<?php
				}
			?>
		</select>
		<br />
		<span class="description"><?php _e('Select page template for this tour category', 'grandtour'); ?></span>
	</td>
</tr>

<?php
}

// A callback function to save our extra taxonomy field(s)
function grandtour_save_tourcat_custom_fields( $term_id ) {
    if ( isset( $_POST['tourcat_template'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );

        if ( isset( $_POST['tourcat_template'] ) ){
            $term_meta['tourcat_template'] = $_POST['tourcat_template'];
        }
        
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

// Add the fields to the "gallery categories" taxonomy, using our callback function
add_action( 'tourcat_edit_form_fields', 'grandtour_tourcat_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_tourcat', 'grandtour_save_tourcat_custom_fields', 10, 2 );


function grandtour_destinationcat_custom_fields($tag) {

   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="destinationcat_template"><?php _e('Destination Category Page Template', 'grandtour'); ?></label>
	</th>
	<td>
		<select name="destinationcat_template" id="destinationcat_template">
			<?php
				$tg_destination_archive_templates = array(
				  'destination-f'		=> 'Destination Fullwidth',
				  'destination-r'		=> 'Destination Right Sidebar',
				  'destination-l'		=> 'Destination Left Sidebar',
				);
				
				foreach($tg_destination_archive_templates as $key => $tg_destination_archive_template)
				{
			?>
			<option value="<?php echo esc_attr($key); ?>" <?php if($term_meta['destinationcat_template']==$key) { ?>selected<?php } ?>><?php echo esc_html($tg_destination_archive_template); ?></option>
			<?php
				}
			?>
		</select>
		<br />
		<span class="description"><?php _e('Select page template for this destination category', 'grandtour'); ?></span>
	</td>
</tr>

<?php
}

// A callback function to save our extra taxonomy field(s)
function grandtour_save_destinationcat_custom_fields( $term_id ) {
    if ( isset( $_POST['destinationcat_template'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );

        if ( isset( $_POST['destinationcat_template'] ) ){
            $term_meta['destinationcat_template'] = $_POST['destinationcat_template'];
        }
        
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}

// Add the fields to the "gallery categories" taxonomy, using our callback function
add_action( 'destinationcat_edit_form_fields', 'grandtour_destinationcat_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_destinationcat', 'grandtour_save_destinationcat_custom_fields', 10, 2 );


//Add upload form to page
if (is_admin()) {
  $current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);

  if ($current_admin_page == 'post' || $current_admin_page == 'post-new')
  {
 
    /** Need to force the form to have the correct enctype. */
    function grandtour_add_post_enctype() {
      echo "<script type=\"text/javascript\">
        jQuery(document).ready(function(){
        jQuery('#post').attr('enctype','multipart/form-data');
        jQuery('#post').attr('encoding', 'multipart/form-data');
        });
        </script>";
    }
 
    add_action('admin_head', 'grandtour_add_post_enctype');
  }
}

add_action( 'edit_form_after_title', 'grandtour_content_builder_enable');

function grandtour_content_builder_enable ($post) 
{
	//Check if enable content builder
	$ppb_enable = get_post_meta($post->ID, 'ppb_enable');
	$enable_builder_class = '';
	$enable_classic_builder_class = '';
	
	if(!empty($ppb_enable))
	{
		$enable_builder_class = 'hidden';
		$enable_classic_builder_class = 'visible';
	}
	
	//Check if user edit page
	$page_id = '';
	
	if (isset($_GET['action']) && $_GET['action'] == 'edit')
	{
		$page_id = $post->ID;
	}

	//Display only on page and portfolio
	if($post->post_type == 'page' OR $post->post_type == 'portfolios')
	
    echo '<a href="javascript:;" id="enable_builder" class="'.esc_attr($enable_builder_class).'" data-page-id="'.esc_attr($page_id).'"><i class="fa fa-th-list"></i>'.esc_html__('Edit in Content Builder', 'grandtour' ).'</a>';
    echo '<a href="javascript:;" id="enable_classic_builder" class="'.esc_attr($enable_classic_builder_class).'"><i class="fa fa-edit"></i>'.esc_html__('Edit in Classic Editor', 'grandtour' ).'</a>';
}

if ( ! function_exists( 'grandtour_theme_kirki_update_url' ) ) {
    function grandtour_theme_kirki_update_url( $config ) {
        $config['url_path'] = get_template_directory_uri() . '/modules/kirki/';
        return $config;
    }
}
add_filter( 'kirki/config', 'grandtour_theme_kirki_update_url' );

add_action( 'customize_register', function( $wp_customize ) {
	/**
	 * The custom control class
	 */
	class Kirki_Controls_Title_Control extends WP_Customize_Control {
		public $type = 'title';
		public function render_content() { 
			echo $this->label;
		}
	}
	// Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['title'] = 'Kirki_Controls_Title_Control';
		return $controls;
	} );

} );

add_action( 'wp_enqueue_scripts', 'grandtour_enqueue_front_end_scripts' );
function grandtour_enqueue_front_end_scripts() 
{
	wp_enqueue_style("fontawesome-stars", WP_PLUGIN_URL."/grandtour-custom-post/css/fontawesome-stars-o.css", false);
}

add_action( 'admin_enqueue_scripts', 'grandtour_enqueue_back_end_scripts' );
function grandtour_enqueue_back_end_scripts() 
{
	wp_enqueue_style("fontawesome-stars", WP_PLUGIN_URL."/grandtour-custom-post/css/fontawesome-stars-o.css", false);
	wp_enqueue_script('barrating', WP_PLUGIN_URL.'/grandtour-custom-post/js/jquery.barrating.js', false);
}

// Add fields after default fields above the comment box, always visible

add_action( 'comment_form_logged_in_after', 'grandtour_additional_fields' );
add_action( 'comment_form_after_fields', 'grandtour_additional_fields' );

function grandtour_additional_fields () 
{
	$post_type = get_post_type();	
	
	if($post_type == 'tour')
	{
		wp_enqueue_style("fontawesome-stars", WP_PLUGIN_URL."/grandtour-custom-post/css/fontawesome-stars-o.css", false);
		wp_enqueue_script('barrating', WP_PLUGIN_URL.'/grandtour-custom-post/js/jquery.barrating.js', false);
		
		echo '<p class="comment-form-rating">'.
		'<label for="accomodation_rating">'. esc_html__('Accomodation', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="accomodation_rating" name="accomodation_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<p class="comment-form-rating">'.
		'<label for="destination_rating">'. esc_html__('Destination', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="destination_rating" name="destination_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<p class="comment-form-rating">'.
		'<label for="meals_rating">'. esc_html__('Meals', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="meals_rating" name="meals_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<p class="comment-form-rating">'.
		'<label for="transport_rating">'. esc_html__('Transport', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="transport_rating" name="transport_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<p class="comment-form-rating">'.
		'<label for="value_rating">'. esc_html__('Value For Money', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="value_rating" name="value_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<p class="comment-form-rating">'.
		'<label for="overall_rating">'. esc_html__('Overall', 'grandtour') . '</label>
		<span class="commentratingbox">
		<select id="overall_rating" name="overall_rating">';
		for( $i=1; $i <= 5; $i++ )
		echo '<option value="'. $i .'">'. $i .'</option>';
		echo'</select></p>';
		
		echo '<script>';
		echo 'jQuery(function() {
	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating({
	        	theme: "fontawesome-stars-o",
	        	emptyValue: 0,
	        	allowEmpty: true
	      	});
	      	
	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating("set", 0);
	    });';
	    echo '</script>';
	}
}

// Save the comment meta data along with comment

add_action( 'comment_post', 'grandtour_save_comment_meta_data' );
function grandtour_save_comment_meta_data( $comment_id ) 
{
	$obj_comment = get_comment($comment_id);
	$post_type = get_post_type($obj_comment->comment_post_ID);
	
	if($post_type == 'tour')
	{
		if ( ( isset( $_POST['accomodation_rating'] ) ) && ( $_POST['accomodation_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['accomodation_rating']);
		add_comment_meta( $comment_id, 'accomodation_rating', $rating );
		
		if ( ( isset( $_POST['destination_rating'] ) ) && ( $_POST['destination_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['destination_rating']);
		add_comment_meta( $comment_id, 'destination_rating', $rating );
		
		if ( ( isset( $_POST['meals_rating'] ) ) && ( $_POST['meals_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['meals_rating']);
		add_comment_meta( $comment_id, 'meals_rating', $rating );
		
		if ( ( isset( $_POST['transport_rating'] ) ) && ( $_POST['transport_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['transport_rating']);
		add_comment_meta( $comment_id, 'transport_rating', $rating );
		
		if ( ( isset( $_POST['value_rating'] ) ) && ( $_POST['value_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['value_rating']);
		add_comment_meta( $comment_id, 'value_rating', $rating );
		
		if ( ( isset( $_POST['overall_rating'] ) ) && ( $_POST['overall_rating'] != '') )
		$rating = wp_filter_nohtml_kses($_POST['overall_rating']);
		add_comment_meta( $comment_id, 'overall_rating', $rating );
		
		//Calculate average rating
		$args = array(
			'status' => 'approve',
			'post_id' => $obj_comment->comment_post_ID, // use post_id, not post_ID
		);
		$tg_comments = get_comments($args);
		$count_comments = count($tg_comments);
		$rating_avg = 0;
		$rating_points = 0;
		
		if(!empty($tg_comments) && is_array($tg_comments))
		{
			foreach($tg_comments as $tg_comment)
			{
				$rating = get_comment_meta( $tg_comment->comment_ID, 'overall_rating', true );
				$rating_points += $rating;
			}
			
			$rating_avg = $rating_points/$count_comments;
		}
		
		if(!empty($rating_avg))
		{
			if (!get_post_meta($obj_comment->comment_post_ID, 'average_rating')) {
				add_post_meta($obj_comment->comment_post_ID, 'average_rating', $rating_avg);
			} else {
				update_post_meta($obj_comment->comment_post_ID, 'average_rating', $rating_avg);
			}
		}
	}
}


// Add the filter to check if the comment meta data has been filled or not

add_filter( 'preprocess_comment', 'grandtour_verify_comment_meta_data' );
function grandtour_verify_comment_meta_data( $commentdata ) 
{
	$post_type = get_post_type($commentdata['comment_post_ID']);	
	
	if($post_type == 'tour')
	{
		if ( ! isset( $_POST['accomodation_rating'] ) OR empty($_POST['accomodation_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with accomodation rating.', 'grandtour' ) );
		
		if ( ! isset( $_POST['destination_rating'] ) OR empty($_POST['destination_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with destination rating.', 'grandtour' ) );
		
		if ( ! isset( $_POST['meals_rating'] ) OR empty($_POST['meals_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with meals rating.', 'grandtour' ) );
		
		if ( ! isset( $_POST['transport_rating'] ) OR empty($_POST['transport_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with transport rating.', 'grandtour' ) );
		
		if ( ! isset( $_POST['value_rating'] ) OR empty($_POST['value_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with value for money rating.', 'grandtour' ) );
		
		if ( ! isset( $_POST['overall_rating'] ) OR empty($_POST['overall_rating']) )
		wp_die( esc_html__( 'Error: You did not add your rating. Hit the BACK button of your Web browser and resubmit your comment with overall rating.', 'grandtour' ) );
	}
	
	return $commentdata;
}

//Add an edit option in comment edit screen  

add_action( 'add_meta_boxes_comment', 'grandtour_extend_comment_add_meta_box' );
function grandtour_extend_comment_add_meta_box($comment) 
{
	$post_type = get_post_type($comment->comment_post_ID);	
	
	if($post_type == 'tour')
	{
	    add_meta_box( 'title', esc_html__( 'Comment Metadata - Rating', 'grandtour' ), 'grandtour_extend_comment_meta_box', 'comment', 'normal', 'high' );
	}
}
 
function grandtour_extend_comment_meta_box ($comment) 
{
	$post_type = get_post_type($comment->comment_post_ID);	
	
	if($post_type == 'tour')
	{
	    $accomodation_rating = get_comment_meta( $comment->comment_ID, 'accomodation_rating', true );
	    $destination_rating = get_comment_meta( $comment->comment_ID, 'destination_rating', true );
	    $meals_rating = get_comment_meta( $comment->comment_ID, 'meals_rating', true );
	    $transport_rating = get_comment_meta( $comment->comment_ID, 'transport_rating', true );
	    $value_rating = get_comment_meta( $comment->comment_ID, 'value_rating', true );
	    $overall_rating = get_comment_meta( $comment->comment_ID, 'overall_rating', true );
	    
	    wp_nonce_field( 'grandtour_extend_comment_update', 'grandtour_extend_comment_update', false );
	    wp_enqueue_style("fontawesome-stars", WP_PLUGIN_URL."/grandtour-custom-post/css/fontawesome-stars-o.css", false);
		wp_enqueue_script('barrating', WP_PLUGIN_URL.'/grandtour-custom-post/js/jquery.barrating.js', false);
?>
    <p>
        <label for="accomodation_rating"><?php esc_html_e( 'Accomodation ', 'grandtour' ); ?></label>
			<select id="accomodation_rating" name="accomodation_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $accomodation_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    
    <p>
        <label for="destination_rating"><?php esc_html_e( 'Destination ', 'grandtour' ); ?></label>
			<select id="destination_rating" name="destination_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $destination_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    
    <p>
        <label for="meals_rating"><?php esc_html_e( 'Meals ', 'grandtour' ); ?></label>
			<select id="meals_rating" name="meals_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $meals_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    
    <p>
        <label for="transport_rating"><?php esc_html_e( 'Transport ', 'grandtour' ); ?></label>
			<select id="transport_rating" name="transport_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $transport_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    
    <p>
        <label for="value_rating"><?php esc_html_e( 'Value For Money ', 'grandtour' ); ?></label>
			<select id="value_rating" name="value_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $value_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    
    <p>
        <label for="overall_rating"><?php esc_html_e( 'Overall ', 'grandtour' ); ?></label>
			<select id="overall_rating" name="overall_rating">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<option value="'. $i .'"';
				if ( $overall_rating == $i ) echo ' selected';
				echo '>'. $i .' </option>'; 
				}
			?>
			</select>
    </p>
    <?php
		echo '<script>';
		echo 'jQuery(function() {
	      	jQuery("#accomodation_rating, #destination_rating, #meals_rating, #transport_rating, #value_rating, #overall_rating").barrating({
	        	theme: "fontawesome-stars-o",
	        	emptyValue: 0,
	        	allowEmpty: true
	      	});
	    });';
	    echo '</script>';
    }
}

// Update comment meta data from comment edit screen 

add_action( 'edit_comment', 'grandtour_extend_comment_edit_metafields' );
function grandtour_extend_comment_edit_metafields( $comment_id ) 
{
	$obj_comment = get_comment($comment_id);
	$post_type = get_post_type($obj_comment->comment_post_ID);
	
	if($post_type == 'tour')
	{
	    if( ! isset( $_POST['grandtour_extend_comment_update'] ) || ! wp_verify_nonce( $_POST['grandtour_extend_comment_update'], 'grandtour_extend_comment_update' ) ) return;
	
		if ( ( isset( $_POST['accomodation_rating'] ) ) && ( $_POST['accomodation_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['accomodation_rating']);
		update_comment_meta( $comment_id, 'accomodation_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'accomodation_rating');
		endif;
		
		if ( ( isset( $_POST['destination_rating'] ) ) && ( $_POST['destination_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['destination_rating']);
		update_comment_meta( $comment_id, 'destination_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'destination_rating');
		endif;
		
		if ( ( isset( $_POST['meals_rating'] ) ) && ( $_POST['meals_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['meals_rating']);
		update_comment_meta( $comment_id, 'meals_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'meals_rating');
		endif;
		
		if ( ( isset( $_POST['transport_rating'] ) ) && ( $_POST['transport_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['transport_rating']);
		update_comment_meta( $comment_id, 'transport_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'transport_rating');
		endif;
		
		if ( ( isset( $_POST['value_rating'] ) ) && ( $_POST['value_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['value_rating']);
		update_comment_meta( $comment_id, 'value_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'value_rating');
		endif;
		
		if ( ( isset( $_POST['overall_rating'] ) ) && ( $_POST['overall_rating'] != '') ):
		$rating = wp_filter_nohtml_kses($_POST['overall_rating']);
		update_comment_meta( $comment_id, 'overall_rating', $rating );
		else :
		delete_comment_meta( $comment_id, 'overall_rating');
		endif;
	}
}

// Add the comment meta (saved earlier) to the comment text 
// You can also output the comment meta values directly in comments template  

add_filter( 'comment_text', 'grandtour_modify_comment');
function grandtour_modify_comment( $text )
{
	$post_type = get_post_type();	
	
	if($post_type == 'tour')
	{
		$plugin_url_path = WP_PLUGIN_URL;
	
		if( $accomodation_rating = get_comment_meta( get_comment_ID(), 'accomodation_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Accomodation', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $accomodation_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $accomodation_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';		
		}
		
		if( $destination_rating = get_comment_meta( get_comment_ID(), 'destination_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Destination', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $destination_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $destination_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';	
		}
		
		if( $meals_rating = get_comment_meta( get_comment_ID(), 'meals_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Meals', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $meals_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $meals_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';	
		}
		
		if( $transport_rating = get_comment_meta( get_comment_ID(), 'transport_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Transport', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $transport_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $transport_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';	
		}
		
		if( $value_rating = get_comment_meta( get_comment_ID(), 'value_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Value For Money', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $value_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $value_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';	
		}
		
		if( $overall_rating = get_comment_meta( get_comment_ID(), 'overall_rating', true ) ) {
			$text.= '<div class="comment_rating_wrapper">';
			$text.= '<div class="comment_rating_label">'.esc_html__('Overall', 'grandtour').'</div>';
			
			$text.= '<div class="br-theme-fontawesome-stars-o"><div class="br-widget">';
			
			for( $i=1; $i <= $overall_rating; $i++ ) {
				$text.= '<a href="javascript:;" class="br-selected"></a>';
			}
			
			$empty_star = 5 - $overall_rating;
			
			if(!empty($empty_star))
			{
				for( $i=1; $i <= $empty_star; $i++ ) {
					$text.= '<a href="javascript:;"></a>';
				}
			}
			
			$text.= '</div></div></div>';	
		}
	}
	
	return $text;
}

add_filter( 'posts_where', 'grandtour_search_posts_where', 10, 2 );
function grandtour_search_posts_where( $where, $wp_query )
{
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= 'OR (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\' ';
        $where .= 'AND ' . $wpdb->posts . '.post_type = \'tour\' AND ' . $wpdb->posts . '.post_status = \'publish\')';
    }
    return $where;
}

//Make widget support shortcode
add_filter('widget_text', 'do_shortcode');
?>
