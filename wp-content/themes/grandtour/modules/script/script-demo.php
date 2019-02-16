<?php 
header("content-type: application/x-javascript"); 
?>
jQuery(document).ready(function() {
	jQuery('#option_btn').click(
		function() {
			if(!jQuery('#option_wrapper').hasClass('open'))
			{	
	    		jQuery('#option_wrapper').addClass('open');
	 			jQuery(this).addClass('open');
	 		}
	 		else
	 		{
	 			var isOpenOption = jQuery.cookie("framed_demo");
				if(jQuery.type(isOpenOption) === "undefined")
	    		{
	    			jQuery.cookie("grandtour_demo", 1, { expires : 7, path: '/' });
	    		}
	 			jQuery('#option_wrapper').removeClass('open');
				jQuery('#option_btn').removeClass('open');
	 		}
		}
	);
});
