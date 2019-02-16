<?php
header("content-type: application/x-javascript"); 
?>
jQuery('#<?php echo esc_js($_GET['id']); ?>').circliful();
