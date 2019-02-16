<?php header("content-type: application/x-javascript"); ?>
<?php
	if(!isset($_GET['id']))
	{
		$slider_id = 'post_featured_slider';
	}
	else
	{
		$slider_id = $_GET['id'];
	}
?>
jQuery(document).ready(function(){ 
	jQuery('#<?php echo esc_js($slider_id); ?>').flexslider({
	      animation: "slide",
	      animationLoop: true,
	      itemMargin: 0,
	      minItems: 1,
	      maxItems: 1,
	      controlNav: true,
	      smoothHeight: false,
	      slideshow: 0,
	      animationSpeed: 400,
<?php
	$tg_blog_slider_autoplay = kirki_get_option('tg_blog_slider_autoplay');
	
	if(!empty($tg_blog_slider_autoplay))
	{
?>
		  slideshow: 1,
<?php
	}
?>
<?php
	$tg_blog_slider_timer = kirki_get_option('tg_blog_slider_timer');
	
	if(!empty($tg_blog_slider_timer))
	{
?>
		  slideshowSpeed: <?php echo intval($tg_blog_slider_timer*1000); ?>,
<?php
	}
?>
	      move: 1
	});
});

jQuery(document).ready(function() {
    fixFlexsliderHeight<?php echo esc_js($slider_id); ?>();
});

jQuery(window).load(function() {
    fixFlexsliderHeight<?php echo esc_js($slider_id); ?>();
});

jQuery(window).resize(function() {
    fixFlexsliderHeight<?php echo esc_js($slider_id); ?>();
});

function fixFlexsliderHeight<?php echo esc_js($slider_id); ?>() {
    jQuery('#<?php echo esc_js($slider_id); ?>').each(function(){
        var sliderHeight = 0;
        jQuery(this).find('.slides > li').each(function(){
            slideHeight = jQuery(this).height();
            if (sliderHeight < slideHeight) {
                sliderHeight = slideHeight;
            }
        });
        jQuery(this).find('.flex-viewport').css({'height' : sliderHeight});
    });
}
