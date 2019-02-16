<?php
header("content-type: application/x-javascript"); 

if(isset($_GET['id']) && !empty($_GET['id']))
{
?>

jQuery(document).ready(function(){
	jwplayer("<?php echo esc_js($_GET['id']); ?>").setup({
	    flashplayer: "<?php echo get_template_directory_uri(); ?>/js/player.swf",
	    file: "<?php echo esc_js($_GET['file']); ?>",
	    image: "<?php echo esc_js($_GET['image']); ?>",
	    width: <?php echo esc_js($_GET['width']); ?>,
	    height: <?php echo esc_js($_GET['height']); ?>,
	});
});

<?php
}
?>
