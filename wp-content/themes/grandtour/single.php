<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

/**
*	Get current page id
**/

$current_page_id = $post->ID;

if($post->post_type == 'galleries')
{
	get_template_part("gallery");

	exit;
}
elseif($post->post_type == 'tour')
{
	$tour_layout = get_post_meta($post->ID, 'tour_layout', true);
	
	switch($tour_layout)
	{
		case 'Sidebar':
		default:
			get_template_part("single-tour-r");
			exit;
		break;
		
		case 'Fullwidth':
			get_template_part("single-tour-f");
			exit;
		break;
	}
	
	exit;
}
elseif($post->post_type == 'destination')
{
	$destination_layout = get_post_meta($post->ID, 'destination_layout', true);
	
	switch($destination_layout)
	{
		case 'Sidebar':
		default:
			get_template_part("single-destination-r");
			exit;
		break;
		
		case 'Fullwidth':
			get_template_part("single-destination-f");
			exit;
		break;
	}
	exit;
}
else
{
	$post_layout = get_post_meta($post->ID, 'post_layout', true);
	
	switch($post_layout)
	{
		case 'With Right Sidebar':
		default:
			get_template_part("single-post-r");
			exit;
		break;
		
		case 'With Left Sidebar':
			get_template_part("single-post-l");
			exit;
		break;
		
		case 'Fullwidth':
			get_template_part("single-post-f");
			exit;
		break;
	}
}
?>
