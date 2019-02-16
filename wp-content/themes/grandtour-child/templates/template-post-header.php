<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

$grandtour_topbar = grandtour_get_topbar();
$grandtour_screen_class = grandtour_get_screen_class();
$grandtour_page_content_class = grandtour_get_page_content_class();
?>

<div id="page_caption" class="<?php if(!empty($grandtour_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandtour_screen_class)) { echo esc_attr($grandtour_screen_class); } ?> <?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>">

	<?php
		//Check page title vertical alignment
		$tg_page_title_vertical_alignment = kirki_get_option('tg_page_title_vertical_alignment');
		if($tg_page_title_vertical_alignment == 'center')
		{	
	?>
		<div class="overlay_background visible"></div>
	<?php
		}
	?>

	<div class="page_title_wrapper">
		<div class="page_title_inner">
			<div class="page_title_content">
				<h1><?php the_title(); ?></h1>
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
			</div>
		</div>
	</div>

</div>

<!-- Begin content -->
<?php
$grandtour_page_content_class = grandtour_get_page_content_class();
?>
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>">
