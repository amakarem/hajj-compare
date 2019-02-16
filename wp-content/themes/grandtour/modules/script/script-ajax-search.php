<?php 
header("content-type: application/x-javascript"); 

if(isset($_GET['id']) && !empty($_GET['id']))
{
?>
jQuery('#<?php echo esc_js($_GET['id']); ?>').on('input', function() {
	jQuery.ajax({
		url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
		type:'POST',
		data:'action=grandtour_ajax_search_result&'+jQuery('#<?php echo esc_js($_GET['form']); ?>').serialize(),
		success:function(results) {
			jQuery("#<?php echo esc_js($_GET['result']); ?>").html(results);
			
			if(results != '')
			{
				jQuery("#<?php echo esc_js($_GET['result']); ?>").addClass('visible');
				jQuery("#<?php echo esc_js($_GET['result']); ?>").show();
				
				jQuery('#<?php echo esc_js($_GET['result']); ?> ul li a').mousedown(function() {
					jQuery("#<?php echo esc_js($_GET['result']); ?>").attr('data-mousedown', true);
				});
			}
			else
			{
				jQuery("#<?php echo esc_js($_GET['result']); ?>").hide();
			}
		}
	})
});

jQuery('#<?php echo esc_js($_GET['id']); ?>').bind('focus', function () {
    jQuery("#<?php echo esc_js($_GET['result']); ?>").addClass('visible');
});

jQuery('#<?php echo esc_js($_GET['id']); ?>').bind('blur', function () {
	if(jQuery("#<?php echo esc_js($_GET['result']); ?>").attr('data-mousedown') != 'true')
    {
    	jQuery("#<?php echo esc_js($_GET['result']); ?>").removeClass('visible');
    }
});
<?php
}
?>
