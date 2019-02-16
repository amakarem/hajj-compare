<?php
$template_name = 'flat-4';
$crop = (isset($crop) && $crop == 'no' || isset($crop) && $crop == 'ajax') ? $crop : 'yes';

if ( isset($_POST['bsa_get_required_inputs']) ) {

	// -- START -- GET REQUIRED INPUTS
	return 'title,url,img'; // inputs shows in form (default: 'title,desc,url,img or html')
	// -- END -- GET REQUIRED INPUTS

} else {

// -- START -- IF EXAMPLE TEMPLATE
	if ( !isset($ads) && !isset($sid) || isset($sid) && isset($example) && $example == true ) {
		if ( !isset($_POST['bsa_ad_id']) || isset($example) ) { // example content if new ad
			$ads = array(
				array(
					"template" => $template_name,
					"id" => 0,
					"title" => get_option('bsa_pro_plugin_trans_example_title'),
					"url" => get_option('bsa_pro_plugin_trans_example_url'),
					"img" => (isset($custom_image)) ? $custom_image : plugins_url('/bsa-pro-scripteo/frontend/img/example.jpg')
				)
			);
			if ( isset($example) ) {
				$col_per_row = bsa_space($sid, 'col_per_row');
			} else {
				$col_per_row = 1;
				$sid = NULL;
			}
		} else { // get ad content if edit ad
			$ads = array(
				array(
					"template" => $template_name,
					"id" => 0,
					"title" => bsa_ad($_POST['bsa_ad_id'], "title"),
					"url" => bsa_ad($_POST['bsa_ad_id'], "url"),
					"img" => bsa_ad($_POST['bsa_ad_id'], "img")
				)
			);
			$col_per_row = 1;
			$sid = NULL;
		}
	} else { // if ads exists
		$col_per_row = bsa_space($sid, 'col_per_row');
	}
// -- END -- IF EXAMPLE TEMPLATE


// -- START -- TEMPLATE HTML
	echo '<div id="bsa-'.$template_name.'" class="bsaProContainerNew '.((isset($sid)) ? "bsaProContainer-".$sid." " : "").((!isset($sid)) ? "bsaProContainerExample " : "").'bsa-'.$template_name.' bsa-pro-col-'.$col_per_row.'" style="display: block !important">'; // -- START -- CONTAINER

	if ( isset($type) ) { // generate form url
		$form_url = bsaFormURL($sid, $type); // get agency form url
	} else {
		$form_url = bsaFormURL($sid); // get order form url
	}

	if ( isset($sid) && bsa_space($sid, 'title') != '' OR isset($sid) &&  bsa_space($sid, 'add_new') != '' ) {
		// -- START -- HEADER
		echo '<div class="bsaProHeader" style="background-color:'.bsa_space($sid, 'header_bg').'">'; // -- START -- HEADER

		echo '<h3 class="bsaProHeader__title" style="color:'.bsa_space($sid, 'header_color').'"><span>'.bsa_space($sid, 'title').'</span></h3>'; // -- HEADER -- TITLE

		echo '<a class="bsaProHeader__formUrl" href="'.$form_url.'" target="_blank" style="color:'.bsa_space($sid, 'link_color').'"><span>'.bsa_space($sid, 'add_new').'</span></a>'; // -- HEADER -- LINK TO ORDERING FORM

		echo '</div>'; // -- END -- HEADER
	}

	echo '<div class="bsaProItems '.bsa_space($sid, "grid_system").' '.((strpos(bsa_space($sid, 'display_type'), 'carousel') !== false) ? 'bsa-owl-carousel bsa-owl-carousel-'.$sid : '').'" style="background-color:'.bsa_space($sid, 'ads_bg').'">'; // -- START -- ITEMS

	foreach ( $ads as $key => $ad ) {

		if ( $ad['id'] != 0 && bsa_ad($ad['id']) != NULL ) {  // -- COUNTING FUNCTION (DO NOT REMOVE!)
			$model = new BSA_PRO_Model();
			$model->bsaProCounter($ad['id']);
		}

		echo '<div class="bsaProItem '.(($key % $col_per_row == 0) ? "bsaReset" : "").'" data-animation="'.bsa_space($sid, "animation").'" style="'.((bsa_space($sid, "animation") == "none" OR bsa_space($sid, "animation") == NULL) ? "opacity:1" : "").'">'; // -- START -- ITEM

		$url = parse_url($ad['url']); // -- START -- LINK
		$agency_form = get_option('bsa_pro_plugin_agency_ordering_form_url');
		if ( $ad['url'] != '' ) {

			if ( isset($example) ) { // url to form if example in ad space
				echo '<a class="bsaProItem__url"'.(isset($rel) ? $rel : null).' href="'.$form_url.'" target="_blank">';
			} else {
				if ( isset($type) && $type == 'agency' ) {
					echo '<a class="bsaProItem__url"'.(isset($rel) ? $rel : null).' href="'.$agency_form.( (strpos($agency_form, '?')) ? '&' : '?' ).'bsa_pro_id='.$ad['id'].'&bsa_pro_url=1" target="_blank">';
				} else {
					echo '<a class="bsaProItem__url"'.(isset($rel) ? $rel : null).' href="'.get_site_url().( (strpos(get_site_url(), '?')) ? '&' : '?' ).'bsa_pro_id='.$ad['id'].'&bsa_pro_url=1" target="_blank">';
				}
			}

		} else {

			echo '<a href="#">';
		}

		echo '<div class="bsaProItemInner" style="background-color:'.bsa_space($sid, 'ad_bg').'">'; // -- START -- ITEM INNER



		echo '<div class="bsaProItemInner__thumb">'; // -- START -- ITEM THUMB

		echo '<div class="bsaProItemInner__thumbBg" style="background-color:'.bsa_space($sid, 'ad_extra_color_1').'"></div>';

		echo '<div class="bsaProItemInner__img" style="background-image: url(&#39;'.bsa_crop_tool($crop, ((!isset($sid) && !isset($_POST['bsa_ad_id']) || isset($example)) ? $ad['img'] : bsa_upload_url(null, $ad['img'])), 400, 300).'&#39;)"></div>'; // -- ITEM -- IMG

		echo '</div>'; // -- END -- ITEM THUMB


		echo '<div class="bsaProItemInner__copy">'; // -- START -- ITEM COPY

		echo '<div class="bsaProItemInner__copyInner">'; // -- START -- ITEM COPY INNER

		if ( $ad['url'] != '' && $ad['url'] != '#' ) {
			echo '<span class="bsaProItemInner__url" style="color:'.bsa_space($sid, 'ad_url_color').'">http://'.$url['host'].'</span>'; // -- ITEM -- URL
		}

		echo '<span class="bsaProItemInner__line"></span>'; // -- ITEM -- LINE

		echo '<h3 class="bsaProItemInner__title" style="color:'.bsa_space($sid, 'ad_title_color').'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

		echo '</div>'; // -- END -- ITEM COPY INNER

		echo '</div>'; // -- END -- ITEM COPY



		echo '</div>'; // -- END -- ITEM INNER

		if ( $ad['url'] != '' or $ad['url'] == '#' ) { echo '</a>'; } // -- END -- LINK

		bsaProCountdown ( $sid, $ad['id'], (isset($ad['ad_limit']) ? $ad['ad_limit'] : 0), (isset($ad['ad_model']) ? $ad['ad_model'] : 0) );

		echo '</div>'; // -- END -- ITEM

	}
	echo '</div>'; // -- END -- ITEMS

	echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML

// horizontal css
	if ( bsa_space($sid, 'random') == 2 ) {
		bsaProSpaceCss($sid, 'vertical', array('items' => $col_per_row));
	}
}