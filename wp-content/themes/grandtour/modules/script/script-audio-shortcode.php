<?php
header("content-type: application/x-javascript"); 
?>
<?php
if(isset($_GET['id']) && !empty($_GET['id']))
{
?>
jQuery(document).ready(function(){
	var player = new MediaElementPlayer('#<?php echo esc_js($_GET['id']); ?>', {
		alwaysShowControls: false,
	    features: ['playpause']
	});
	player.play();
});
<?php
}
?>
