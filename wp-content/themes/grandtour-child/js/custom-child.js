jQuery(document).ready(function(){ 
	"use strict";

	var wpcf7Elm = document.querySelector( '.wpcf7' );
	if(wpcf7Elm !== null){
	wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {

			console.log('submit');
			
      // hide Form wrapper <div class="hideOnSubmit">
			var elems = document.getElementsByClassName('hideOnSubmit');
			for (var i=0;i<elems.length;i+=1){
				elems[i].style.display = 'none';
			}

}, false );
}
jQuery( "#search_icon" ).click(function() {
	console.log('Toggle Search');
  jQuery( ".search_wrapper" ).slideToggle( "slow", function() {
    // Animation complete.
  });
});
});

jQuery(document).ready(function() {
	jQuery('a[href*=#]').bind('click', function(e) {
			e.preventDefault(); // prevent hard jump, the default behavior

			var target = jQuery(this).attr("href"); // Set the target as variable

			// perform animated scrolling by getting top-position of target-element and set it as scroll target
			var desiredHeight = 120;
			jQuery('html, body').stop().animate({
					scrollTop: jQuery(target).offset().top
			}, 900, function() {
					location.hash = target; //attach the hash (#jumptarget) to the pageurl
			});

			return false;
	});
});

jQuery(window).scroll(function() {
	var scrollDistance = jQuery(window).scrollTop();

	// Show/hide menu on scroll
	//if (scrollDistance >= 850) {
	//		$('nav').fadeIn("fast");
	//} else {
	//		$('nav').fadeOut("fast");
	//}

	// Assign active class to nav links while scolling
	jQuery('.scroll-section').each(function(i) {
			if (jQuery(this).position().top <= scrollDistance) {
				jQuery('.navigation a.active').removeClass('active');
				jQuery('.navigation a').eq(i).addClass('active');
			}
	});
}).scroll();

