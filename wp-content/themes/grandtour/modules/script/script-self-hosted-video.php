<?php
header("content-type: application/x-javascript"); 

if(isset($_GET['portfolio_id']) && !empty($_GET['portfolio_id']))
{
	$portfolio_mp4_url = get_post_meta($_GET['portfolio_id'], 'portfolio_mp4_url', true);
?>
jwplayer("fullscreen_self_hosted_vid").setup({
    flashplayer: "<?php echo get_template_directory_uri(); ?>/js/player.swf",
    file: "<?php echo esc_js($portfolio_mp4_url); ?>",
    width: "100%",
    height: "100%",
    autostart: "true"
});
<?php
}
?>
