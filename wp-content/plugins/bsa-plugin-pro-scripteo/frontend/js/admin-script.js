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