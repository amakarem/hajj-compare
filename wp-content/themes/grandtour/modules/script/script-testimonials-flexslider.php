<?php header("content-type: application/x-javascript"); ?>
jQuery(document).ready(function(){ 
	jQuery('.testimonial_slider_wrapper').flexslider({
	      animation: "fade",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      slideshow: true,
	      controlNav: true,
	      smoothHeight: false,
	      pauseOnHover: true,
	      directionNav: false,
	      slideshowSpeed: 4000,
	      animationSpeed: 400,
	      move: 1
	});
});
