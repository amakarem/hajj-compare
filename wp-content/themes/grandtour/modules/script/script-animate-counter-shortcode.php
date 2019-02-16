<?php 
header("content-type: application/x-javascript"); 
?>
window.odometerOptions = {
  format: '(,ddd).dd'
};
setTimeout(function(){
    jQuery('#<?php echo esc_js($_GET['id']); ?>').html(<?php echo esc_js($_GET['end']); ?>);
}, 1000);
