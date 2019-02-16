function selectBillingModel()
{
	(function($){

		var radioModel = $('input[name="ad_model"]:checked');
		var radioValues = $(".bsaProInputsValues");
		var radioValuesCPC = $(".bsaProInputsValuesCPC");
		var radioValuesCPM = $(".bsaProInputsValuesCPM");
		var radioValuesCPD = $(".bsaProInputsValuesCPD");

		$('input[name="ad_limit_cpc"]').prop('checked', false);
		$('input[name="ad_limit_cpm"]').prop('checked', false);
		$('input[name="ad_limit_cpd"]').prop('checked', false);

		$('input[name="ad_model"]').click(function() {
			$('.bsaInputInnerModel').removeClass('bsaSelected');
		});

		radioValues.slideUp();

		if ( radioModel.val() == 'cpc' ) {
			radioValuesCPC.slideDown();
			radioModel.parent(1).addClass('bsaSelected');
		} else if ( radioModel.val() == 'cpm' ) {
			radioValuesCPM.slideDown();
			radioModel.parent(1).addClass('bsaSelected');
		} else if ( radioModel.val() == 'cpd' ) {
			radioValuesCPD.slideDown();
			radioModel.parent(1).addClass('bsaSelected');
		}

	})(jQuery);
}

(function($){

	$(document).ready(function(){

		if ( $('#bsaSuccessProRedirect').length ) {
			var getRedirectUrl = $('#bsa_payment_url').val();
			setTimeout(function() {
				window.location.replace(getRedirectUrl);
			}, 2000);
		}

		if ( $('#bsaSuccessProAgencyRedirect').length ) {
			var getAgencyRedirectUrl = $('#bsa_payment_agency_url').val();
			setTimeout(function() {
				window.location.replace(getAgencyRedirectUrl);
			}, 2000);
		}

		var bsaProItem = $('.bsaProItem');
		bsaProItem.each(function() {
			if ( $(this).data('animation') != null && $(this).data('animation') !== 'none' ) {
				$(this).addClass('bsaHidden').viewportChecker({
					// Class to add to the elements when they are visible
					classToAdd: 'animated ' + $(this).data('animation'),
					offset: 100,
					repeat: false,
					callbackFunction: function(elem, action){}
				});
			}
		});

	});

})(jQuery);