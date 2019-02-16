<?php
function ppb_text_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'width' => '100',
		'padding' => 30,
		'bgcolor' => '',
		'fontcolor' => '',
		'textalign' => 'left',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	
	if($size!='one')
	{
		$return_html.= '<div class="standard_wrapper">';
	}

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_text"';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).' !important;';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	$return_html.= do_shortcode(grandtour_apply_content($content));
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	if($size!='one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_text', 'ppb_text_func');


function ppb_text_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'width' => '100',
		'padding' => 30,
		'bgcolor' => '',
		'fontcolor' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	
	if($size!='one')
	{
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_text"';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).' !important;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= do_shortcode(grandtour_apply_content($content));
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	if($size!='one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_text_fullwidth', 'ppb_text_fullwidth_func');


function ppb_text_image_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'width' => '100',
		'padding' => 30,
		'textalign' => 'left',
		'background' => '',
		'background_position' => '',
		'parallax' => 0,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	
	switch($size)
	{
		case 'one_half':
			$size = 'one_half_bg';
		break;
		
		case 'one_half last':
			$size = 'one_half_bg last';
		break;
		
		case 'one_third':
			$size = 'one_third_bg';
		break;
		
		case 'one_third last':
			$size = 'one_third_bg last';
		break;
		
		case 'two_third':
			$size = 'two_third_bg';
		break;
		
		case 'two_third last':
			$size = 'two_third_bg last';
		break;
		
		case 'one_fourth':
			$size = 'one_fourth_bg';
		break;
		
		case 'one_fourth last':
			$size = 'one_fourth_bg last';
		break;
	}

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_text_image ';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$return_html.= '"';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).' !important;';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if($size == 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	$return_html.= do_shortcode(grandtour_apply_content($content));
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	$return_html.= '</div></div>';
	
	if($size == 'one')
	{	
		$return_html.= '</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_text_image', 'ppb_text_image_func');


function ppb_text_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'padding' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$return_html = '<div '.$sec_id.' class="one withsmallpadding" ';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.rawurldecode($custom_css).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	$return_html.= do_shortcode(grandtour_apply_content($content)).'</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('ppb_text_sidebar', 'ppb_text_sidebar_func');


function ppb_header_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'textalign' => 'left',
		'width' => '100',
		'padding' => 30,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));

	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	if($size != 'one')
	{
		$return_html.= '<div class="standard_wrapper">';
	}

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_header ';
	
	if(!empty($layout) && $layout == 'fullwidth')
	{
		$return_html.= 'fullwidth ';
	}

	$return_html.= '"';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if($size == 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
	}
	
	$return_html.= '</div>';
	
	if($size == 'one')
	{
		$return_html.= '</div>';
	}
	
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	if($size != 'one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_header', 'ppb_header_func');


function ppb_header_image_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'fontcolor' => '',
		'textalign' => 'left',
		'width' => '100',
		'padding' => 30,
		'background' => '',
		'background_position' => '',
		'bgcolor' => '#000000',
		'opacity' => 100,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'parallax' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	if($size != 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_header ';
	
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
	}
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}

	$return_html.= '"';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if($size == 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
	}
	
	$return_html.= '</div>';
	
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	if($size != 'one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_header_image', 'ppb_header_image_func');


function ppb_divider_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'builder_id' => '',
	), $atts));

	//Set begin wrapper div for live builder
	$return_html= grandtour_live_builder_begin_wrapper($builder_id, 'ppb_divider');
	
	$return_html.= '<div class="divider '.esc_attr($size).'">&nbsp;</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	return $return_html;

}

add_shortcode('ppb_divider', 'ppb_divider_func');


function ppb_gallery_slider_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'gallery' => '',
		'autoplay' => 0,
		'caption' => 0,
		'timer' => 5,
		'padding' => 0,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).'" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= do_shortcode('[tg_gallery_slider gallery_id="'.esc_attr($gallery).'" size="original" autoplay="'.esc_attr($autoplay).'" caption="'.esc_attr($caption).'" timer="'.esc_attr($timer).'" fullwidth="1"]');
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_gallery_slider', 'ppb_gallery_slider_func');


function ppb_gallery_slider_fixed_width_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'gallery' => '',
		'autoplay' => 0,
		'caption' => 0,
		'timer' => 5,
		'padding' => 0,
		'bgcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).'" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper nopadding"><div class="inner">';
	
	$return_html.= do_shortcode('[tg_gallery_slider gallery_id="'.esc_attr($gallery).'" size="original" autoplay="'.esc_attr($autoplay).'" caption="'.esc_attr($caption).'"  timer="'.esc_attr($timer).'"]');
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_gallery_slider_fixed_width', 'ppb_gallery_slider_fixed_width_func');


function ppb_gallery_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'gallery_id' => '',
		'layout' => 'contain',
		'columns' => 4,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'pagination' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	if(!is_numeric($columns))
	{
		$columns = 4;
	}
	
	$custom_css = '';
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_gallery_grid '.esc_attr($size).'" style="'.$custom_css.'">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	$all_photo_count = count($images_arr);
	
	$images_arr = grandtour_resort_gallery_img($images_arr);
	$current_photo_count = count($images_arr);
	
	$custom_id = time().rand();
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
		
		case 5:
			$wrapper_class = 'five_cols';
			$grid_wrapper_class = 'classic5_cols';
			$column_class = 'one_fifth gallery5';
		break;
	}

	if(!empty($images_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery '.esc_attr($wrapper_class).' ' .esc_attr($layout).'" data-columns="'.esc_attr($columns).'">';
		
		$i = 0;
		foreach($images_arr as $key => $image)
		{
			$image_url = wp_get_attachment_image_src($image, 'original', true);
			$small_image_url = wp_get_attachment_image_src($image, 'grandtour-gallery-list', true);
			
			$image_caption = get_post_field('post_excerpt', $image);
			$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
			
			$tg_lightbox_enable_caption = kirki_get_option('tg_lightbox_enable_caption');
			
			$return_html.= '<div class="element grid  ' .esc_attr($grid_wrapper_class).'">';
			$return_html.= '<div class="'.esc_attr($column_class).' static filterable gallery_type animated'.esc_attr($key+1).'">';
			$return_html.= '<a class="fancy-gallery" href="'.esc_url($image_url[0]).'" ';
			
			if(!empty($tg_lightbox_enable_caption)) 
			{
			    $return_html.= 'data-caption="'.esc_attr($image_caption).'" ';
			}
			
			$return_html.= '>';
			$return_html.= '<img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($image_alt).'"/>';
			
			//Get image purchase URL
			$grandtour_purchase_url = get_post_meta($image, 'grandtour_purchase_url', true);
			
			if(!empty($grandtour_purchase_url))
			{
			    $return_html.= '<a href="'.esc_url($grandtour_purchase_url).'" title="'.esc_html__('Purchase', 'grandtour-custom-post' ).'" class="button tooltip"><i class="fa fa-shopping-cart"></i></a>';
			}
			
			$return_html.= '</a>';
			$return_html.= '</div>';
			$return_html.= '</div>';
			
			$i++;
		}
		
		$return_html.= '</div>';
		
		//Check if has pagination
	    if($all_photo_count > $current_photo_count && !empty($pagination))
	    {
	    	$return_html.= '<br class="clear"/>';
	    
			switch($columns)
			{
				case 1:
					$tg_gallery_pagination = kirki_get_option('tg_gallery_pagination_one');
				break;
				
				case 2:
				default:
					$tg_gallery_pagination = kirki_get_option('tg_gallery_pagination_two');
				break;
				
				case 3:
					$tg_gallery_pagination = kirki_get_option('tg_gallery_pagination_three');
				break;
				
				case 4:
					$tg_gallery_pagination = kirki_get_option('tg_gallery_pagination_four');
				break;
				
				case 5:
					$tg_gallery_pagination = kirki_get_option('tg_gallery_pagination_five');
				break;
			}
			
			$return_html.= '<a href="javascript:;" id="infinite_load_more_'.$custom_id.'" class="infinite_load_more" data-start="'.intval($current_photo_count).'" data-items="'.intval($tg_gallery_pagination).'">'.esc_html__('Load more', 'grandtour-custom-post' ).'</a>';
			
			$return_html.= '<div id="infinite_loading_'.$custom_id.'" class="infinite_loading"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>';
		}
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= esc_html__( 'Empty gallery item. Please make sure you have upload image to it or check the short code.', 'grandtour-custom-post' );
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_gallery_grid', 'ppb_gallery_grid_func');


function ppb_image_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'height' => 400,
		'display_caption' => 1,
		'background_position' => 'center',
		'padding' => 0,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));

	if(!is_numeric($height))
	{
		$height = 400;
	}
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' ppb_image_fullwidth" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="one withbg"';
	
	if(!empty($image))
	{
		$return_html.= ' style="background-image:url('.esc_url($image).');background-size:cover;background-position:center '.esc_attr($background_position).';height:'.esc_attr($height).'px;position:relative;"';
	}
	
	$return_html.= '>';
	$return_html.= '</div>';
	
	if(!empty($display_caption))
	{
		//Get image meta data
		$image_id = grandtour_get_image_id($image);
		$image_caption = get_post_field('post_excerpt', $image_id);
		
		if(!empty($image_caption))
		{
			$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		}
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_image_fullwidth', 'ppb_image_fullwidth_func');


function ppb_image_parallax_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'slug' => '',
		'image' => '',
		'height' => 80,
		'display_caption' => 1,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	if(!is_numeric($height))
	{
		$height = 80;
	}
	
	if($height > 100)
	{
		$height = 100;
	}
	
	$image_id = '';
	
	//Set begin wrapper div for live builder
	$return_html = grandtour_live_builder_begin_wrapper($builder_id);

	$return_html.= '<div '.$sec_id.' class="parallax ';
	$return_html.= '" ';
	
	if(!empty($image))
	{
		$custom_css.= 'background-image: url('.esc_url($image).');';
	}
		
	if(!empty($height))
	{
		$custom_css.= 'height:'.$height.'vh; ';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'"';
	}
	
	$return_html.= '>';
	
	$return_html.= '</div>';
	
	if(!empty($display_caption))
	{
		//Get image meta data
		$image_id = grandtour_get_image_id($image);
		$image_caption = get_post_field('post_excerpt', $image_id);
		
		if(!empty($image_caption))
		{
			$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		}
	}

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	return $return_html;
}

add_shortcode('ppb_image_parallax', 'ppb_image_parallax_func');


function ppb_image_fixed_width_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'image' => '',
		'display_caption' => 1,
		'padding' => 0,
		'lightbox' => 0,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' ppb_image_fixed_width" ';
	
	$custom_css.= 'padding-top:'.esc_attr($padding).'px;padding-bottom'.esc_attr($padding).'px;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($image))
	{
		$image_id = grandtour_get_image_id($image);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
		$return_html.= '<div class="image_classic_frame"><div class="image_wrapper">';
		
		if(!empty($lightbox))
		{
			$return_html.= '<a href="'.esc_url($image).'" class="img_frame">';
		}
		
		$return_html.= '<img src="'.esc_url($image).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		
		if(!empty($lightbox))
		{
			$return_html.= '</a>';
		}
		
		$return_html.= '</div>';
	}
	
	if(!empty($display_caption))
	{
		//Get image meta data
		$image_id = grandtour_get_image_id($image);
		$image_caption = get_post_field('post_excerpt', $image_id);
		
		if(!empty($image_caption))
		{
			$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		}
	}
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_image_fixed_width', 'ppb_image_fixed_width_func');


function ppb_content_half_bg_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'background' => '',
		'background_parallax' => '',
		'background_position' => '',
		'padding' => 30,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'align' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'parallax' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_half_bg ';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	$parallax_stellar = '';
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
		$parallax_stellar.= 'data-stellar-ratio="1.3"';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$return_html.= '"';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		if($align == 'left')
		{
			$return_html.= '<div class="one_half_bg" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" '.$parallax_stellar.'>';
		}
		else
		{
			$return_html.= '<div class="one_half_bg floatright" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" '.$parallax_stellar.'>';
		}
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_half_bg', 'ppb_content_half_bg_func');


function ppb_content_center_bg_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'background' => '',
		'background_parallax' => '',
		'background_position' => '',
		'padding' => 30,
		'height' => 600,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'parallax' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	if(empty($height))
	{
		$height = 600;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_center_bg ';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	$parallax_stellar = '';
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
		$parallax_stellar.= 'data-stellar-ratio="1.3"';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	if(!empty($height))
	{
		$custom_css.= 'height:'.intval($height).'px;';
	}
	
	$return_html.= '"';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		$return_html.= '<div class="one_third" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).';padding:'.esc_attr($padding).'px;" '.$parallax_stellar.'>';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_center_bg', 'ppb_content_center_bg_func');


function ppb_image_half_fixed_width_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'image' => '',
		'align' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).'" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_css_fontcolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
	}
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if($align=='left')
	{
		$return_html.= '<div class="one_half">';
		if(!empty($image))
		{
			$image_id = grandtour_get_image_id($image);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
			$return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$return_html.= '<a href="'.esc_url($image).'" class="img_frame"><img src="'.esc_url($image).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/></a>';
			$return_html.= '</div></div>';
		}
		$return_html.= '</div>';
		
		$return_html.= '<div class="one_half last content_middle" style="padding:'.esc_attr($padding).'px;">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
	}
	else
	{	
		$return_html.= '<div class="one_half content_middle textright" style="padding:'.esc_attr($padding).'px;">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
		
		$return_html.= '<div class="one_half last">';
		if(!empty($image))
		{
			$image_id = grandtour_get_image_id($image);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
			$return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$return_html.= '<a href="'.esc_url($image).'" class="img_frame"><img src="'.esc_url($image).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/></a>';
			$return_html.= '</div></div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '<br class="clear"/></div>';
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_image_half_fixed_width', 'ppb_image_half_fixed_width_func');


function ppb_image_half_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'image' => '',
		'height' => 500,
		'align' => 1,
		'padding' => 0,
		'bgcolor' => '',
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'parallax' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	if(!is_numeric($height))
	{
		$height = 500;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).'" ';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$content_custom_css = '';
	if($align=='left')
	{
		$return_html.= '<div class="one_half_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		
		if(!empty($image))
		{
			$return_html.= ' style="background-image:url('.esc_url($image).');height:'.esc_attr($height).'px;"';
		}
		$return_html.= '></div>';
		
		$content_custom_css.= 'style="padding:'.esc_attr($padding).'px;"';
		$return_html.= '<div class="one_half_bg" '.$content_custom_css.'>';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
	}
	else
	{	
		$content_custom_css.= 'style="padding:'.esc_attr($padding).'px;"';
		$return_html.= '<div class="one_half_bg textright" '.$content_custom_css.'>';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
	
		$return_html.= '</div>';
		
		$return_html.= '<div class="one_half_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		
		if(!empty($image))
		{
			$return_html.= ' style="background-image:url('.esc_url($image).');height:'.esc_attr($height).'px;"';
		}
		$return_html.= '></div>';
	}
	
	$return_html.= '<br class="clear"/>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_image_half_fullwidth', 'ppb_image_half_fullwidth_func');


function ppb_image_two_third_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'image' => '',
		'height' => 500,
		'align' => 1,
		'parallax' => 0,
		'bgcolor' => '',
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	if(!is_numeric($height))
	{
		$height = 500;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="ppb_image_two_third_fullwidth '.esc_attr($size).'" ';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$content_custom_css = '';
	if($align=='left')
	{
		$return_html.= '<div class="two_third_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		if(!empty($image))
		{
			$return_html.= ' style="background-image:url('.esc_url($image).');height:'.esc_attr($height).'px;"';
		}
		$return_html.= '></div>';
		
		$return_html.= '<div class="one_third_bg" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{	
		$return_html.= '<div class="one_third_bg textright" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
	
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html.= '<div class="two_third_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		if(!empty($image))
		{
			$return_html.= ' style="background-image:url('.esc_url($image).');height:'.esc_attr($height).'px;"';
		}
		$return_html.= '></div>';
	}
	
	$return_html.= '<br class="clear"/>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_image_two_third_fullwidth', 'ppb_image_two_third_fullwidth_func');


function ppb_two_cols_images_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'display_caption' => 1,
		'padding' => 0,
		'lightbox' => 0,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' ppb_two_cols_images" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';

	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper standard_wrapper"><div class="inner">';
	
	$return_html.= '<div class="one_half">';
	if(!empty($image1))
	{
		$image_id = grandtour_get_image_id($image1);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{	
	    	$return_html.= '<a href="'.esc_url($image1).'" class="img_frame">';
	    }
	    	$return_html.= '<img src="'.esc_url($image1).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    	
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image1);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	$return_html.= '<div class="one_half last">';
	if(!empty($image2))
	{
		$image_id = grandtour_get_image_id($image2);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{	
	    	$return_html.= '<a href="'.esc_url($image2).'" class="img_frame">';
	    }
	    	$return_html.= '<img src="'.esc_url($image2).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    	
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image2);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div></div>';
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_two_cols_images', 'ppb_two_cols_images_func');


function ppb_two_cols_images_no_space_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'height' => 600,
		'parallax' => 0,
		'display_caption' => 1,
		'padding' => 0,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).'" ';
	$custom_css = '';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner" style="padding:0;">';
	
	if(!empty($image1) && !empty($height))
	{
		$return_html.= '<div class="one_half_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		$return_html.= 'style="background-image:url(\''.$image1.'\');height:'.$height.'px;"';
		$return_html.= '>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image1);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	
	if(!empty($image2) && !empty($height))
	{
		$return_html.= '<div class="one_half_bg';
		
		if(!empty($parallax))
		{
			$return_html.= ' parallax';
		}
		
		$return_html.= '"';
		$return_html.= 'style="background-image:url(\''.$image2.'\');height:'.$height.'px;"';
		$return_html.= '>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image2);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_two_cols_images_no_space', 'ppb_two_cols_images_no_space_func');


function ppb_three_cols_images_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'image3' => '',
		'display_caption' => 1,
		'lightbox' => 0,
		'padding' => 0,
		'bgcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_three_cols_images '.esc_attr($size).'" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	//First image
	$return_html.= '<div class="one_third">';
	if(!empty($image1))
	{
		$image_id = grandtour_get_image_id($image1);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image1).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image1).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    
	    if(!empty($lightbox))
		{
			$return_html.= '</a>';
		}
	    $return_html.= '</div>';
	    
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image1);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	//Second image
	$return_html.= '<div class="one_third">';
	if(!empty($image2))
	{
		$image_id = grandtour_get_image_id($image2);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image2).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image2).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    
	    if(!empty($lightbox))
		{
			$return_html.= '</a>';
		}
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image2);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	//Third image
	$return_html.= '<div class="one_third last">';
	if(!empty($image3))
	{
		$image_id = grandtour_get_image_id($image3);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image3).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image3).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    
	    if(!empty($lightbox))
		{
			$return_html.= '</a>';
		}
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image3);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div></div>';
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_three_cols_images', 'ppb_three_cols_images_func');


function ppb_three_images_block_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image_portrait' => '',
		'image_portrait_align' => 'left',
		'image2' => '',
		'image3' => '',
		'display_caption' => 1,
		'lightbox' => 0,
		'padding' => 0,
		'bgcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($image_portrait_align))
	{
		$image_portrait_align = 'left';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_three_images_block '.esc_attr($size).'" ';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if($image_portrait_align=='left')
	{
		//First column
		$return_html.= '<div class="one_half">';
		if(!empty($image_portrait))
		{
			$image_id = grandtour_get_image_id($image_portrait);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image_portrait).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image_portrait).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image_portrait);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		$return_html.= '</div>';
		
		//Second column
		$return_html.= '<div class="one_half last">';
		if(!empty($image2))
		{
			$image_id = grandtour_get_image_id($image2);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image2).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image2).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image2);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		
		if(!empty($image3))
		{
			$image_id = grandtour_get_image_id($image3);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image3).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image3).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image3);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		
		$return_html.= '</div>';
	}
	else
	{
		//First column
		$return_html.= '<div class="one_half">';
		if(!empty($image2))
		{
			$image_id = grandtour_get_image_id($image2);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image2).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image2).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image2);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		
		if(!empty($image3))
		{
			$image_id = grandtour_get_image_id($image3);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image3).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image3).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image3);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		
		$return_html.= '</div>';
		
		//Second column
		$return_html.= '<div class="one_half last">';
		if(!empty($image_portrait))
		{
			$image_id = grandtour_get_image_id($image_portrait);
			$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		
		    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
		    
		    if(!empty($lightbox))
			{
		    	$return_html.= '<a href="'.esc_url($image_portrait).'" class="img_frame">';
		    }	
		    $return_html.= '<img src="'.esc_url($image_portrait).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
		    if(!empty($lightbox))
			{
		    	$return_html.= '</a>';
		    }
		    
		    $return_html.= '</div>';
		    if(!empty($display_caption))
		    {
		    	//Get image meta data
		    	$image_id = grandtour_get_image_id($image_portrait);
		    	$image_caption = get_post_field('post_excerpt', $image_id);
		    	
		    	if(!empty($image_caption))
		    	{
		    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
		    	}
		    }
		    $return_html.= '</div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	$return_html.= '<div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_three_images_block', 'ppb_three_images_block_func');


function ppb_four_images_block_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'image3' => '',
		'image4' => '',
		'display_caption' => 1,
		'lightbox' => 0,
		'padding' => 0,
		'bgcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_four_images_block '.esc_attr($size).'" ';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	//First image
	$return_html.= '<div class="one_half grid4">';
	if(!empty($image1))
	{
		$image_id = grandtour_get_image_id($image1);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image1).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image1).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image1);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	//Second image
	$return_html.= '<div class="one_half last grid4">';
	if(!empty($image2))
	{
		$image_id = grandtour_get_image_id($image2);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image2).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image2).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image2);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	$return_html.= '<br class="clear"/>';
	
	//Third image
	$return_html.= '<div class="one_half grid4">';
	if(!empty($image3))
	{
		$image_id = grandtour_get_image_id($image3);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image3).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image3).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image3);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	//Fourth image
	$return_html.= '<div class="one_half last grid4">';
	if(!empty($image4))
	{
		$image_id = grandtour_get_image_id($image4);
		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	    $return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
	    
	    if(!empty($lightbox))
		{
	    	$return_html.= '<a href="'.esc_url($image4).'" class="img_frame">';
	    }
	    $return_html.= '<img src="'.esc_url($image4).'" alt="'.esc_attr($image_alt).'" class="portfolio_img"/>';
	    if(!empty($lightbox))
		{
	    	$return_html.= '</a>';
	    }
	    
	    $return_html.= '</div>';
	    if(!empty($display_caption))
	    {
	    	//Get image meta data
	    	$image_id = grandtour_get_image_id($image4);
	    	$image_caption = get_post_field('post_excerpt', $image_id);
	    	
	    	if(!empty($image_caption))
	    	{
	    		$return_html.= '<div class="ppb_image_caption">'.$image_caption.'</div>';
	    	}
	    }
	    $return_html.= '</div>';
	}
	$return_html.= '</div>';
	
	$return_html.= '</div>';
	$return_html.= '</div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_four_images_block', 'ppb_four_images_block_func');


function ppb_metro_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'image1' => '',
		'image2' => '',
		'image3' => '',
		'image4' => '',
		'image5' => '',
		'height' => 600,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	$return_html.= '<div '.$sec_id.' class="ppb_metro '.esc_attr($size).'" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if(!empty($image1))
	{
		//First image
		$return_html.= '<div class="one_half_bg nopadding" style="background:url('.esc_url($image1).');height:'.intval($height).'px;"></div>';
	}
	
	if(!empty($image2))
	{
		$return_html.= '<div class="one_half_bg nopadding">';
		
		$return_html.= '<div class="one_half_bg" style="background:url('.esc_url($image2).');height:'.intval($height/2).'px;"></div>';
		
		if(!empty($image3))
		{
			$return_html.= '<div class="one_half_bg" style="background:url('.esc_url($image3).');height:'.intval($height/2).'px;"></div>';
		}
		
		if(!empty($image4))
		{
			$return_html.= '<div class="one_half_bg" style="background:url('.esc_url($image4).');height:'.intval($height/2).'px;"></div>';
		}
		
		if(!empty($image5))
		{
			$return_html.= '<div class="one_half_bg" style="background:url('.esc_url($image5).');height:'.intval($height/2).'px;"></div>';
		}
		
	    $return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_metro', 'ppb_metro_func');


function ppb_tour_search_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'url' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_tour_search"';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	
	$return_html.= '<form id="tour_search_form" class="tour_search_form" method="get" action="'.esc_url($url).'">';
    $return_html.= '<div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    		<input id="keyword" name="keyword" type="text" autocomplete="off" placeholder="'.esc_html__('Destination, city', 'grandtour-custom-post' ).'"/>
    		<span class="ti-search"></span>
    		<div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
    	</div>';
    	
    $return_html.= '<div class="one_fourth themeborder">';
	
	//Get available months
	$available_months = grandtour_get_months();

    $return_html.= '<select id="month" name="month">
	    		<option value="">'.esc_html__('Any Month', 'grandtour-custom-post' ).'</option>';
	
	foreach($available_months as $key => $available_month)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($available_month).'</option>';
	}

    $return_html.= '</select>
    		<span class="ti-calendar"></span>
    	</div>
    	<div class="one_fourth themeborder">';

	//Get available months
	$sort_options = grandtour_get_sort_options();

    $return_html.= '<select id="sort_by" name="sort_by">';

	foreach($sort_options as $key => $sort_option)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($sort_option).'</option>';	
	}

    $return_html.= '</select>
    		<span class="ti-exchange-vertical"></span>
    	</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="'.esc_html__( 'Search', 'grandtour-custom-post' ).'"/>
    	</div>';
    	
    //Check if enable advanced search
	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	
	if(!empty($tg_tour_advanced_search))
	{
	    //Display advanced search fields
	    $return_html.= '<br class="clear"/><div class="tour_advance_search_wrapper">
	    <div class="one_fourth themeborder">';
	    
	    //Get tour categories list
	    $tour_cats_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
	    
	    $return_html.= '<select id="tourcat" name="tourcat">
		    		<option value="">'.esc_html__('All Categories', 'grandtour-custom-post' ).'</option>';
		
		if(!empty($tour_cats_arr))
		{
			foreach($tour_cats_arr as $key => $tour_cat)	
			{
				$return_html.= '<option value="'.esc_attr($tour_cat->slug).'">'.esc_attr($tour_cat->name).'</option>';
			}
		}
	
	    $return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
	    //Get destination search options
	    $return_html.= '<div class="one_fourth themeborder">';
	    
	    //Get destination items
	    $args = array(
		    'numberposts' => -1,
		    'post_type' => array('destination'),
		    'suppress_filters' => false,
		    'orderby' => 'title',
		    'order' => 'ASC'
		);
		$destination_arr = get_posts($args);
		
		$return_html.= '<select id="destination_id" name="destination_id">
		    		<option value="">'.esc_html__('Any Destinations', 'grandtour-custom-post' ).'</option>';
		    		
		if(!empty($destination_arr))
		{
			foreach($destination_arr as $key => $destination)	
			{
				$return_html.= '<option value="'.esc_attr($destination->ID).'">'.esc_attr($destination->post_title).'</option>';
			}
		}
		    		
		$return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
		//Display max budget field
		$tg_tour_currency = kirki_get_option('tg_tour_currency');
		
		$return_html.= '<div class="one_fourth themeborder">
	    		<input id="budget" name="budget" type="text" placeholder="'.esc_html__('Max budget ex. 500', 'grandtour-custom-post' ).'"/>
	    		<span>'.esc_attr($tg_tour_currency).'</span>
	    	</div>';
	    
	    $return_html.= '</div>';
	    
	    $return_html.= '</div>';
	    	
	    $return_html.= '<div class="tour_advance_search_wrapper_link">';
	    
	    $return_html.= '<a id="tour_advance_search_toggle" href="javascript:;" class="theme_link_color"><span class="icon ti-angle-down"></span>'.esc_html__( 'Advanced Search', 'grandtour-custom-post' ).'</a>';
	    
	    $return_html.= '</div>';
	}
    	
    $return_html.='
    </div>
</form>';

	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_tour_search', 'ppb_tour_search_func');


function ppb_tour_search_background_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'height' => 400,
		'textalign' => 'left',
		'url' => '',
		'background' => '',
		'background_position' => '',
		'parallax' => 0,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_tour_search_background ';
	
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
	}
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';height:'.esc_attr($height).'px;';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	$return_html.= '"';
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$custom_css_fontcolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	$return_html.= '<div class="center_wrapper">';
	$return_html.= '<div class="inner_content"><div class="standard_wrapper">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	
	$return_html.= '<form id="tour_search_form" class="tour_search_form" method="get" action="'.esc_url($url).'">';
    $return_html.= '<div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    		<input id="keyword" name="keyword" type="text" autocomplete="off" placeholder="'.esc_html__('Destination, city', 'grandtour-custom-post' ).'"/>
    		<span class="ti-search"></span>
    		<div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
    	</div>';
    	
    $return_html.= '<div class="one_fourth themeborder">';
	
	//Get available months
	$available_months = grandtour_get_months();

    $return_html.= '<select id="month" name="month">
	    		<option value="">'.esc_html__('Any Month', 'grandtour-custom-post' ).'</option>';
	
	foreach($available_months as $key => $available_month)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($available_month).'</option>';
	}

    $return_html.= '</select>
    		<span class="ti-calendar"></span>
    	</div>
    	<div class="one_fourth themeborder">';

	//Get tour categories
	$sort_options = grandtour_get_sort_options();

    $return_html.= '<select id="sort_by" name="sort_by">';

	foreach($sort_options as $key => $sort_option)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($sort_option).'</option>';	
	}

    $return_html.= '</select>
    		<span class="ti-exchange-vertical"></span>
    	</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="'.esc_html__( 'Search', 'grandtour-custom-post' ).'"/>
    	</div>';
    	
	//Check if enable advanced search
	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	
	if(!empty($tg_tour_advanced_search))
	{
		//Display advanced search fields
	    $return_html.= '<br class="clear"/><div class="tour_advance_search_wrapper">
	    <div class="one_fourth themeborder">';
	    
	    //Get tour categories list
	    $tour_cats_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
	    
	    $return_html.= '<select id="tourcat" name="tourcat">
		    		<option value="">'.esc_html__('All Categories', 'grandtour-custom-post' ).'</option>';
		
		if(!empty($tour_cats_arr))
		{
			foreach($tour_cats_arr as $key => $tour_cat)	
			{
				$return_html.= '<option value="'.esc_attr($tour_cat->slug).'">'.esc_attr($tour_cat->name).'</option>';
			}
		}
	
	    $return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
	    //Get destination search options
	    $return_html.= '<div class="one_fourth themeborder">';
	    
	    //Get destination items
	    $args = array(
		    'numberposts' => -1,
		    'post_type' => array('destination'),
		    'suppress_filters' => false,
		    'orderby' => 'title',
		    'order' => 'ASC'
		);
		$destination_arr = get_posts($args);
		
		$return_html.= '<select id="destination_id" name="destination_id">
		    		<option value="">'.esc_html__('Any Destinations', 'grandtour-custom-post' ).'</option>';
		    		
		if(!empty($destination_arr))
		{
			foreach($destination_arr as $key => $destination)	
			{
				$return_html.= '<option value="'.esc_attr($destination->ID).'">'.esc_attr($destination->post_title).'</option>';
			}
		}
		    		
		$return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
		//Display max budget field
		$tg_tour_currency = kirki_get_option('tg_tour_currency');
		
		$return_html.= '<div class="one_fourth themeborder">
	    		<input id="budget" name="budget" type="text" placeholder="'.esc_html__('Max budget ex. 500', 'grandtour-custom-post' ).'"/>
	    		<span>'.esc_attr($tg_tour_currency).'</span>
	    	</div>';
	    
	    $return_html.= '</div>';
	    
	    $return_html.= '</div>';
	    	
	    $return_html.= '<div class="tour_advance_search_wrapper_link">';
	    
	    $return_html.= '<a id="tour_advance_search_toggle" href="javascript:;" style="'.esc_attr($custom_css_fontcolor).'"><span class="icon ti-angle-down"></span>'.esc_html__( 'Advanced Search', 'grandtour-custom-post' ).'</a>';
	    
	    $return_html.= '</div>';
	}
    	
	$return_html.= '
    </div>
</form>';

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	$return_html.= '</div></div></div>';
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_tour_search_background', 'ppb_tour_search_background_func');


function ppb_tour_search_youtube_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'height' => 400,
		'textalign' => 'left',
		'url' => '',
		'youtube' => '',
		'parallax' => 0,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_tour_search_youtube parallax withbg ';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';height:'.esc_attr($height).'px;';
	
	$return_html.= '"';
	
	if(!empty($youtube))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= ' data-jarallax-video="'.esc_url($youtube).'" ';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$custom_css_fontcolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	$return_html.= '<div class="center_wrapper">';
	$return_html.= '<div class="inner_content"><div class="standard_wrapper">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	
	$return_html.= '<form id="tour_search_form" class="tour_search_form" method="get" action="'.esc_url($url).'">';
    $return_html.= '<div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    		<input id="keyword" name="keyword" type="text" autocomplete="off" placeholder="'.esc_html__('Destination, city', 'grandtour-custom-post' ).'"/>
    		<span class="ti-search"></span>
    		<div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
    	</div>';
    	
    $return_html.= '<div class="one_fourth themeborder">';
	
	//Get available months
	$available_months = grandtour_get_months();

    $return_html.= '<select id="month" name="month">
	    		<option value="">'.esc_html__('Any Month', 'grandtour-custom-post' ).'</option>';
	
	foreach($available_months as $key => $available_month)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($available_month).'</option>';
	}

    $return_html.= '</select>
    		<span class="ti-calendar"></span>
    	</div>
    	<div class="one_fourth themeborder">';

	//Get available months
	$sort_options = grandtour_get_sort_options();

    $return_html.= '<select id="sort_by" name="sort_by">';

	foreach($sort_options as $key => $sort_option)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($sort_option).'</option>';	
	}

    $return_html.= '</select>
    		<span class="ti-exchange-vertical"></span>
    	</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="'.esc_html__( 'Search', 'grandtour-custom-post' ).'"/>
    	</div>';
    	
    //Check if enable advanced search
	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	
	if(!empty($tg_tour_advanced_search))
	{
		//Display advanced search fields
	    $return_html.= '<br class="clear"/><div class="tour_advance_search_wrapper">
	    <div class="one_fourth themeborder">';
	    
	    //Get tour categories list
	    $tour_cats_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
	    
	    $return_html.= '<select id="tourcat" name="tourcat">
		    		<option value="">'.esc_html__('All Categories', 'grandtour-custom-post' ).'</option>';
		
		if(!empty($tour_cats_arr))
		{
			foreach($tour_cats_arr as $key => $tour_cat)	
			{
				$return_html.= '<option value="'.esc_attr($tour_cat->slug).'">'.esc_attr($tour_cat->name).'</option>';
			}
		}
	
	    $return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
	    //Get destination search options
	    $return_html.= '<div class="one_fourth themeborder">';
	    
	    //Get destination items
	    $args = array(
		    'numberposts' => -1,
		    'post_type' => array('destination'),
		    'suppress_filters' => false,
		    'orderby' => 'title',
		    'order' => 'ASC'
		);
		$destination_arr = get_posts($args);
		
		$return_html.= '<select id="destination_id" name="destination_id">
		    		<option value="">'.esc_html__('Any Destinations', 'grandtour-custom-post' ).'</option>';
		    		
		if(!empty($destination_arr))
		{
			foreach($destination_arr as $key => $destination)	
			{
				$return_html.= '<option value="'.esc_attr($destination->ID).'">'.esc_attr($destination->post_title).'</option>';
			}
		}
		    		
		$return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
		//Display max budget field
		$tg_tour_currency = kirki_get_option('tg_tour_currency');
		
		$return_html.= '<div class="one_fourth themeborder">
	    		<input id="budget" name="budget" type="text" placeholder="'.esc_html__('Max budget ex. 500', 'grandtour-custom-post' ).'"/>
	    		<span>'.esc_attr($tg_tour_currency).'</span>
	    	</div>';
	    
	    $return_html.= '</div>';
	    
	    $return_html.= '</div>';
	    	
	    $return_html.= '<div class="tour_advance_search_wrapper_link">';
	    
	    $return_html.= '<a id="tour_advance_search_toggle" href="javascript:;" style="'.esc_attr($custom_css_fontcolor).'"><span class="icon ti-angle-down"></span>'.esc_html__( 'Advanced Search', 'grandtour-custom-post' ).'</a>';
	    
	    $return_html.= '</div>';
	}
    	
    $return_html.='
    </div>
</form>';

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	$return_html.= '</div></div></div>';
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_tour_search_youtube', 'ppb_tour_search_youtube_func');


function ppb_tour_search_vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'height' => 400,
		'textalign' => 'left',
		'url' => '',
		'vimeo' => '',
		'parallax' => 0,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_tour_search_vimeo parallax withbg ';
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';height:'.esc_attr($height).'px;';
	
	$return_html.= '"';
	
	if(!empty($vimeo))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= ' data-jarallax-video="'.esc_url($vimeo).'" ';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$custom_css_fontcolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	$return_html.= '<div class="center_wrapper">';
	$return_html.= '<div class="inner_content"><div class="standard_wrapper">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	
	$return_html.= '<form id="tour_search_form" class="tour_search_form" method="get" action="'.esc_url($url).'">';
    $return_html.= '<div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    		<input id="keyword" name="keyword" type="text" autocomplete="off" placeholder="'.esc_html__('Destination, city', 'grandtour-custom-post' ).'"/>
    		<span class="ti-search"></span>
    		<div id="autocomplete" class="autocomplete" data-mousedown="false"></div>
    	</div>';
    	
    $return_html.= '<div class="one_fourth themeborder">';
	
	//Get available months
	$available_months = grandtour_get_months();

    $return_html.= '<select id="month" name="month">
	    		<option value="">'.esc_html__('Any Month', 'grandtour-custom-post' ).'</option>';
	
	foreach($available_months as $key => $available_month)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($available_month).'</option>';
	}

    $return_html.= '</select>
    		<span class="ti-calendar"></span>
    	</div>
    	<div class="one_fourth themeborder">';

	//Get available months
	$sort_options = grandtour_get_sort_options();

    $return_html.= '<select id="sort_by" name="sort_by">';

	foreach($sort_options as $key => $sort_option)	
	{
		$return_html.= '<option value="'.esc_attr($key).'">'.esc_attr($sort_option).'</option>';	
	}

    $return_html.= '</select>
    		<span class="ti-exchange-vertical"></span>
    	</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="'.esc_html__( 'Search', 'grandtour-custom-post' ).'"/>
    	</div>';
    	
	//Check if enable advanced search
	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	
	if(!empty($tg_tour_advanced_search))
	{
		//Display advanced search fields
	    $return_html.= '<br class="clear"/><div class="tour_advance_search_wrapper">
	    <div class="one_fourth themeborder">';
	    
	    //Get tour categories list
	    $tour_cats_arr = get_terms('tourcat', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
	    
	    $return_html.= '<select id="tourcat" name="tourcat">
		    		<option value="">'.esc_html__('All Categories', 'grandtour-custom-post' ).'</option>';
		
		if(!empty($tour_cats_arr))
		{
			foreach($tour_cats_arr as $key => $tour_cat)	
			{
				$return_html.= '<option value="'.esc_attr($tour_cat->slug).'">'.esc_attr($tour_cat->name).'</option>';
			}
		}
	
	    $return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
	    //Get destination search options
	    $return_html.= '<div class="one_fourth themeborder">';
	    
	    //Get destination items
	    $args = array(
		    'numberposts' => -1,
		    'post_type' => array('destination'),
		    'suppress_filters' => false,
		    'orderby' => 'title',
		    'order' => 'ASC'
		);
		$destination_arr = get_posts($args);
		
		$return_html.= '<select id="destination_id" name="destination_id">
		    		<option value="">'.esc_html__('Any Destinations', 'grandtour-custom-post' ).'</option>';
		    		
		if(!empty($destination_arr))
		{
			foreach($destination_arr as $key => $destination)	
			{
				$return_html.= '<option value="'.esc_attr($destination->ID).'">'.esc_attr($destination->post_title).'</option>';
			}
		}
		    		
		$return_html.= '</select>
	    		<span class="ti-angle-down"></span>
	    	</div>';
	    	
		//Display max budget field
		$tg_tour_currency = kirki_get_option('tg_tour_currency');
		
		$return_html.= '<div class="one_fourth themeborder">
	    		<input id="budget" name="budget" type="text" placeholder="'.esc_html__('Max budget ex. 500', 'grandtour-custom-post' ).'"/>
	    		<span>'.esc_attr($tg_tour_currency).'</span>
	    	</div>';
	    
	    $return_html.= '</div>';
	    
	    $return_html.= '</div>';
	    	
	    $return_html.= '<div class="tour_advance_search_wrapper_link">';
	    
	    $return_html.= '<a id="tour_advance_search_toggle" href="javascript:;" style="'.esc_attr($custom_css_fontcolor).'"><span class="icon ti-angle-down"></span>'.esc_html__( 'Advanced Search', 'grandtour-custom-post' ).'</a>';
	    
	    $return_html.= '</div>';
	}
    	
    $return_html.= '</div>
</form>';

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	$return_html.= '</div></div></div>';
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_tour_search_vimeo', 'ppb_tour_search_vimeo_func');


function ppb_tour_classic_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 9,
		'tourcat' => '',
		'columns' => 2,
		'order' => 'date',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'layout' => 'contain',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_tour_classic '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('tour'),
	    'suppress_filters' => false,
	);
	
	switch($order)
    {
		case 'date':
		default:
			$args['orderby'] = 'post_date';
			$args['order'] = 'DESC';
		break;
		
		case 'price_low':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'ASC';
		break;
		
		case 'price_high':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'DESC';
		break;
		
		case 'name':
			$args['orderby'] = 'post_title';
			$args['order'] = 'ASC';
		break;
		
		case 'popular':
	    	$args['orderby'] = 'post_views';
	    	$args['order'] = 'DESC';
	    break;
	    
	    case 'review':
	    	$args['orderby'] = 'meta_value_num';
	    	$args['meta_key'] = 'average_rating';
	    	$args['order'] = 'DESC';
	    break;
    }
	
	if(!empty($tourcat))
	{
		$args['tourcat'] = $tourcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
	}
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery classic '.esc_attr($wrapper_class).'" data-columns="'.esc_attr($columns).'">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			//Begin display HTML
			$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
			$return_html.= '<div class="'.esc_attr($column_class).' classic static filterable portfolio_type themeborder">';
			
			if(!empty($image_url[0]))
			{
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'">
					<img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr(get_the_title($portfolio_ID)).'" />';
					
				//Get tour label
				$tour_label = get_post_meta($portfolio_ID, 'tour_label', true);
				
				if(!empty($tour_label))
				{
					$return_html.= '<div class="tour_label">'.esc_html($tour_label).'</div>';
				}

				//Get tour price
				$tour_price = get_post_meta($portfolio_ID, 'tour_price', true);
				
				if(!empty($tour_price))
				{
					$tour_discount_price = get_post_meta($portfolio_ID, 'tour_discount_price', true);

					$return_html.= '<div class="tour_price ';
					
					if(!empty($tour_discount_price)) 
					{
						$return_html.= 'has_discount';
					} 
					
					$return_html.= '">';

					if(!empty($tour_discount_price))
					{
						$return_html.= '<span class="normal_price">
								'.esc_html(grandtour_format_tour_price($tour_price)).'
							</span>';
							
						$return_html.= esc_html(grandtour_format_tour_price($tour_discount_price));
					}
					else
					{
						$return_html.= esc_html(grandtour_format_tour_price($tour_price));
					}

					$return_html.= '</div>';
				}
	            $return_html.= '</a>';
				
				$return_html.= '<div class="portfolio_info_wrapper">
        		    <a class="tour_link" href="'.esc_url($permalink_url).'"><h4>'.get_the_title($portfolio_ID).'</h4></a>';
        		    
        		$return_html.= '<div class="tour_excerpt">'.grandtour_get_excerpt_by_id($portfolio_ID).'</div>';
        		$return_html.= '<div class="tour_attribute_wrapper">';

		        $overall_rating_arr = grandtour_get_review($portfolio_ID, 'overall_rating');
				$overall_rating = intval($overall_rating_arr['average']);
				$overall_rating_count = intval($overall_rating_arr['count']);
				
				if(!empty($overall_rating))
				{
					$return_html.= '<div class="tour_attribute_rating">';

					if($overall_rating > 0)
					{
						$return_html.= '<div class="br-theme-fontawesome-stars-o">
									<div class="br-widget">';

						for( $i=1; $i <= $overall_rating; $i++ ) {
							$return_html.= '<a href="javascript:;" class="br-selected"></a>';
						}
						
						$empty_star = 5 - $overall_rating;
						
						if(!empty($empty_star))
						{
							for( $i=1; $i <= $empty_star; $i++ ) {
								$return_html.= '<a href="javascript:;"></a>';
							}
						}
						
						$return_html.= '</div>
								</div>';
					}
								
					if($overall_rating_count > 0)
					{
						$return_html.= '<div class="tour_attribute_rating_count">';
						$return_html.= intval($overall_rating_count).'&nbsp;';

						if($overall_rating_count > 1)
						{
							$return_html.= esc_html__('reviews', 'grandtour-custom-post' );
						}
						else
						{
							$return_html.= esc_html__('review', 'grandtour-custom-post' );
						}
						
						$return_html.= '</div>';
					}

					$return_html.= '</div>';
				}    

			    $tour_days = get_post_meta($portfolio_ID, 'tour_days', true);	
			    			
			    if(!empty($tour_days))
			    {
		        	$return_html.= '<div class="tour_attribute_days">
			    			    <span class="ti-time"></span>';

					if(function_exists('grandtour_get_tour_duration'))
					{
						//Display tour durations
						$return_html.= grandtour_get_tour_duration($portfolio_ID);
					}
					else
					{
						$return_html.= intval($tour_days).'&nbsp;';
										
						if($tour_days > 1)
						{
							$return_html.= esc_html__("days", 'grandtour-custom-post');
						}
						else
						{
							$return_html.= esc_html__("day", 'grandtour-custom-post');
						}
					}
					
		        	$return_html.= '</div>';
			    }
        		
        		$return_html.= '</div>
        		    <br class="clear"/>
				</div>';
			}
			$return_html.= '</div>';
			$return_html.= '</div>';
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tour_classic', 'ppb_tour_classic_func');


function ppb_tour_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 9,
		'tourcat' => '',
		'columns' => 2,
		'order' => 'date',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'layout' => 'contain',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_tour_grid '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('tour'),
	    'suppress_filters' => false,
	);
	
	switch($order)
    {
		case 'date':
		default:
			$args['orderby'] = 'post_date';
			$args['order'] = 'DESC';
		break;
		
		case 'price_low':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'ASC';
		break;
		
		case 'price_high':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'DESC';
		break;
		
		case 'name':
			$args['orderby'] = 'post_title';
			$args['order'] = 'ASC';
		break;
		
		case 'popular':
	    	$args['orderby'] = 'post_views';
	    	$args['order'] = 'DESC';
	    break;
	    
	    case 'review':
	    	$args['orderby'] = 'meta_value_num';
	    	$args['meta_key'] = 'average_rating';
	    	$args['order'] = 'DESC';
	    break;
    }
	
	if(!empty($tourcat))
	{
		$args['tourcat'] = $tourcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
	}
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid '.esc_attr($wrapper_class).'" data-columns="'.esc_attr($columns).'">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			if(!empty($image_url[0]))
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($small_image_url[0]).');">';
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';
				
				//Get tour label
				$tour_label = get_post_meta($portfolio_ID, 'tour_label', true);
				
				if(!empty($tour_label))
				{
					$return_html.= '<div class="tour_label">'.esc_html($tour_label).'</div>';
				}

				$return_html.= '<div class="portfolio_info_wrapper">';
				
				//Get tour price
				$tour_price = get_post_meta($portfolio_ID, 'tour_price', true);
				
				if(!empty($tour_price))
				{
					$tour_discount_price = get_post_meta($portfolio_ID, 'tour_discount_price', true);

					$return_html.= '<div class="tour_price ';
					
					if(!empty($tour_discount_price)) 
					{
						$return_html.= 'has_discount';
					} 
					
					$return_html.= '">';

					if(!empty($tour_discount_price))
					{
						$return_html.= '<span class="normal_price">
								'.esc_html(grandtour_format_tour_price($tour_price)).'
							</span>';
							
						$return_html.= esc_html(grandtour_format_tour_price($tour_discount_price));
					}
					else
					{
						$return_html.= esc_html(grandtour_format_tour_price($tour_price));
					}

					$return_html.= '</div>';
				}
				
				$return_html.= '<h4>'.get_the_title($portfolio_ID).'</h4>';
        		$return_html.= '<div class="tour_attribute_wrapper">';

		        $overall_rating_arr = grandtour_get_review($portfolio_ID, 'overall_rating');
				$overall_rating = intval($overall_rating_arr['average']);
				$overall_rating_count = intval($overall_rating_arr['count']);
				
				if(!empty($overall_rating))
				{
					$return_html.= '<div class="tour_attribute_rating">';

					if($overall_rating > 0)
					{
						$return_html.= '<div class="br-theme-fontawesome-stars-o">
									<div class="br-widget">';

						for( $i=1; $i <= $overall_rating; $i++ ) {
							$return_html.= '<a href="javascript:;" class="br-selected"></a>';
						}
						
						$empty_star = 5 - $overall_rating;
						
						if(!empty($empty_star))
						{
							for( $i=1; $i <= $empty_star; $i++ ) {
								$return_html.= '<a href="javascript:;"></a>';
							}
						}
						
						$return_html.= '</div>
								</div>';
					}
								
					if($overall_rating_count > 0)
					{
						$return_html.= '<div class="tour_attribute_rating_count">';
						$return_html.= intval($overall_rating_count).'&nbsp;';

						if($overall_rating_count > 1)
						{
							$return_html.= esc_html__('reviews', 'grandtour-custom-post' );
						}
						else
						{
							$return_html.= esc_html__('review', 'grandtour-custom-post' );
						}
						
						$return_html.= '</div>';
					}

					$return_html.= '</div>';
				}    

			    $tour_days = get_post_meta($portfolio_ID, 'tour_days', true);	
			    			
			    if(!empty($tour_days))
			    {
		        	$return_html.= '<div class="tour_attribute_days">
			    			    <span class="ti-time"></span>';

					if(function_exists('grandtour_get_tour_duration'))
					{
						//Display tour durations
						$return_html.= grandtour_get_tour_duration($portfolio_ID);
					}
					else
					{
						$return_html.= intval($tour_days).'&nbsp;';
										
						if($tour_days > 1)
						{
							$return_html.= esc_html__("days", 'grandtour-custom-post');
						}
						else
						{
							$return_html.= esc_html__("day", 'grandtour-custom-post');
						}
					}
					
		        	$return_html.= '</div>';
			    }
        		
        		$return_html.= '</div>
        		    <br class="clear"/>
				</div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tour_grid', 'ppb_tour_grid_func');


function ppb_tour_grid_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'items' => 9,
		'tourcat' => '',
		'columns' => 2,
		'order' => 'date',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'layout' => 'contain',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_tour_grid_sidebar '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('tour'),
	    'suppress_filters' => false,
	);
	
	switch($order)
    {
		case 'date':
		default:
			$args['orderby'] = 'post_date';
			$args['order'] = 'DESC';
		break;
		
		case 'price_low':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'ASC';
		break;
		
		case 'price_high':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'DESC';
		break;
		
		case 'name':
			$args['orderby'] = 'post_title';
			$args['order'] = 'ASC';
		break;
		
		case 'popular':
	    	$args['orderby'] = 'post_views';
	    	$args['order'] = 'DESC';
	    break;
	    
	    case 'review':
	    	$args['orderby'] = 'meta_value_num';
	    	$args['meta_key'] = 'average_rating';
	    	$args['order'] = 'DESC';
	    break;
    }
	
	if(!empty($tourcat))
	{
		$args['tourcat'] = $tourcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'two_cols';
	$grid_wrapper_class = 'classic2_cols';
	$column_class = 'one_half gallery2';
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid '.esc_attr($wrapper_class).'" data-columns="'.esc_attr($columns).'">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			if(!empty($image_url[0]))
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($small_image_url[0]).');">';
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';
				
				//Get tour label
				$tour_label = get_post_meta($portfolio_ID, 'tour_label', true);
				
				if(!empty($tour_label))
				{
					$return_html.= '<div class="tour_label">'.esc_html($tour_label).'</div>';
				}

				$return_html.= '<div class="portfolio_info_wrapper">';
				
				//Get tour price
				$tour_price = get_post_meta($portfolio_ID, 'tour_price', true);
				
				if(!empty($tour_price))
				{
					$tour_discount_price = get_post_meta($portfolio_ID, 'tour_discount_price', true);

					$return_html.= '<div class="tour_price ';
					
					if(!empty($tour_discount_price)) 
					{
						$return_html.= 'has_discount';
					} 
					
					$return_html.= '">';

					if(!empty($tour_discount_price))
					{
						$return_html.= '<span class="normal_price">
								'.esc_html(grandtour_format_tour_price($tour_price)).'
							</span>';
							
						$return_html.= esc_html(grandtour_format_tour_price($tour_discount_price));
					}
					else
					{
						$return_html.= esc_html(grandtour_format_tour_price($tour_price));
					}

					$return_html.= '</div>';
				}
				
				$return_html.= '<h4>'.get_the_title($portfolio_ID).'</h4>';
        		$return_html.= '<div class="tour_attribute_wrapper">';

		        $overall_rating_arr = grandtour_get_review($portfolio_ID, 'overall_rating');
				$overall_rating = intval($overall_rating_arr['average']);
				$overall_rating_count = intval($overall_rating_arr['count']);
				
				if(!empty($overall_rating))
				{
					$return_html.= '<div class="tour_attribute_rating">';

					if($overall_rating > 0)
					{
						$return_html.= '<div class="br-theme-fontawesome-stars-o">
									<div class="br-widget">';

						for( $i=1; $i <= $overall_rating; $i++ ) {
							$return_html.= '<a href="javascript:;" class="br-selected"></a>';
						}
						
						$empty_star = 5 - $overall_rating;
						
						if(!empty($empty_star))
						{
							for( $i=1; $i <= $empty_star; $i++ ) {
								$return_html.= '<a href="javascript:;"></a>';
							}
						}
						
						$return_html.= '</div>
								</div>';
					}
								
					if($overall_rating_count > 0)
					{
						$return_html.= '<div class="tour_attribute_rating_count">';
						$return_html.= intval($overall_rating_count).'&nbsp;';

						if($overall_rating_count > 1)
						{
							$return_html.= esc_html__('reviews', 'grandtour-custom-post' );
						}
						else
						{
							$return_html.= esc_html__('review', 'grandtour-custom-post' );
						}
						
						$return_html.= '</div>';
					}

					$return_html.= '</div>';
				}    

			    $tour_days = get_post_meta($portfolio_ID, 'tour_days', true);	
			    			
			    if(!empty($tour_days))
			    {
		        	$return_html.= '<div class="tour_attribute_days">
			    			    <span class="ti-time"></span>';

					if(function_exists('grandtour_get_tour_duration'))
					{
						//Display tour durations
						$return_html.= grandtour_get_tour_duration($portfolio_ID);
					}
					else
					{
						$return_html.= intval($tour_days).'&nbsp;';
										
						if($tour_days > 1)
						{
							$return_html.= esc_html__("days", 'grandtour-custom-post');
						}
						else
						{
							$return_html.= esc_html__("day", 'grandtour-custom-post');
						}
					}
					
		        	$return_html.= '</div>';
			    }
        		
        		$return_html.= '</div>
        		    <br class="clear"/>
				</div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tour_grid_sidebar', 'ppb_tour_grid_sidebar_func');


function ppb_tour_classic_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'items' => 9,
		'tourcat' => '',
		'order' => 'date',
		'columns' => 2,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'layout' => 'contain',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_tour_classic_sidebar '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('tour'),
	    'suppress_filters' => false,
	);
	
	switch($order)
    {
		case 'date':
		default:
			$args['orderby'] = 'post_date';
			$args['order'] = 'DESC';
		break;
		
		case 'price_low':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'ASC';
		break;
		
		case 'price_high':
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'tour_price';
			$args['order'] = 'DESC';
		break;
		
		case 'name':
			$args['orderby'] = 'post_title';
			$args['order'] = 'ASC';
		break;
		
		case 'popular':
	    	$args['orderby'] = 'post_views';
	    	$args['order'] = 'DESC';
	    break;
	    
	    case 'review':
	    	$args['orderby'] = 'meta_value_num';
	    	$args['meta_key'] = 'average_rating';
	    	$args['order'] = 'DESC';
	    break;
    }
	
	if(!empty($tourcat))
	{
		$args['tourcat'] = $tourcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'two_cols';
	$grid_wrapper_class = 'classic2_cols';
	$column_class = 'one_half gallery2';
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery classic '.esc_attr($wrapper_class).'" data-columns="'.esc_attr($columns).'">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			//Begin display HTML
			$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
			$return_html.= '<div class="'.esc_attr($column_class).' classic static filterable portfolio_type themeborder">';
			
			if(!empty($image_url[0]))
			{
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'">
					<img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr(get_the_title($portfolio_ID)).'" />';
					
				//Get tour label
				$tour_label = get_post_meta($portfolio_ID, 'tour_label', true);
				
				if(!empty($tour_label))
				{
					$return_html.= '<div class="tour_label">'.esc_html($tour_label).'</div>';
				}

				//Get tour price
				$tour_price = get_post_meta($portfolio_ID, 'tour_price', true);
				
				if(!empty($tour_price))
				{
					$tour_discount_price = get_post_meta($portfolio_ID, 'tour_discount_price', true);

					$return_html.= '<div class="tour_price ';
					
					if(!empty($tour_discount_price)) 
					{
						$return_html.= 'has_discount';
					} 
					
					$return_html.= '">';

					if(!empty($tour_discount_price))
					{
						$return_html.= '<span class="normal_price">
								'.esc_html(grandtour_format_tour_price($tour_price)).'
							</span>';
							
						$return_html.= esc_html(grandtour_format_tour_price($tour_discount_price));
					}
					else
					{
						$return_html.= esc_html(grandtour_format_tour_price($tour_price));
					}

					$return_html.= '</div>';
				}
	            $return_html.= '</a>';
				
				$return_html.= '<div class="portfolio_info_wrapper">
        		    <a class="tour_link" href="'.esc_url($permalink_url).'"><h4>'.get_the_title($portfolio_ID).'</h4></a>';
        		    
        		$return_html.= '<div class="tour_excerpt">'.grandtour_get_excerpt_by_id($portfolio_ID).'</div>';
        		$return_html.= '<div class="tour_attribute_wrapper">';

		        $overall_rating_arr = grandtour_get_review($portfolio_ID, 'overall_rating');
				$overall_rating = intval($overall_rating_arr['average']);
				$overall_rating_count = intval($overall_rating_arr['count']);
				
				if(!empty($overall_rating))
				{
					$return_html.= '<div class="tour_attribute_rating">';

					if($overall_rating > 0)
					{
						$return_html.= '<div class="br-theme-fontawesome-stars-o">
									<div class="br-widget">';

						for( $i=1; $i <= $overall_rating; $i++ ) {
							$return_html.= '<a href="javascript:;" class="br-selected"></a>';
						}
						
						$empty_star = 5 - $overall_rating;
						
						if(!empty($empty_star))
						{
							for( $i=1; $i <= $empty_star; $i++ ) {
								$return_html.= '<a href="javascript:;"></a>';
							}
						}
						
						$return_html.= '</div>
								</div>';
					}
								
					if($overall_rating_count > 0)
					{
						$return_html.= '<div class="tour_attribute_rating_count">';
						$return_html.= intval($overall_rating_count).'&nbsp;';

						if($overall_rating_count > 1)
						{
							$return_html.= esc_html__('reviews', 'grandtour-custom-post' );
						}
						else
						{
							$return_html.= esc_html__('review', 'grandtour-custom-post' );
						}
						
						$return_html.= '</div>';
					}

					$return_html.= '</div>';
				}    

			    $tour_days = get_post_meta($portfolio_ID, 'tour_days', true);	
			    			
			    if(!empty($tour_days))
			    {
		        	$return_html.= '<div class="tour_attribute_days">
			    			    <span class="ti-time"></span>';

					if(function_exists('grandtour_get_tour_duration'))
					{
						//Display tour durations
						$return_html.= grandtour_get_tour_duration($portfolio_ID);
					}
					else
					{
						$return_html.= intval($tour_days).'&nbsp;';
										
						if($tour_days > 1)
						{
							$return_html.= esc_html__("days", 'grandtour-custom-post');
						}
						else
						{
							$return_html.= esc_html__("day", 'grandtour-custom-post');
						}
					}
					
		        	$return_html.= '</div>';
			    }
        		
        		$return_html.= '</div>
        		    <br class="clear"/>
				</div>';
			}
			$return_html.= '</div>';
			$return_html.= '</div>';
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tour_classic_sidebar', 'ppb_tour_classic_sidebar_func');


function ppb_destination_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 9,
		'destinationcat' => '',
		'title_align' => 'baseline',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
		'layout' => 'contain',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	$columns = 2;
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_destination_grid '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('destination'),
	    'suppress_filters' => false,
	    'orderby' => 'menu_order',
	    'order' => 'ASC'
	);
	
	if(!empty($destinationcat))
	{
		$args['destinationcat'] = $destinationcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'four_cols';
	$grid_wrapper_class = 'classic4_cols';
	$column_class = 'one_fourth gallery4';
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid portrait '.esc_attr($wrapper_class).'" data-columns="4">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			if(!empty($image_url[0]))
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($title_align).' '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($small_image_url[0]).');">';
				
				if($title_align == 'center')
				{
					$return_html.= '<div class="ppb_background_overlay light"></div>';	
				}
				
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';

				$return_html.= '<div class="portfolio_info_wrapper"><div class="portfolio_info_content">';
				$return_html.= '<h3>'.get_the_title($portfolio_ID).'</h3>';
        		$return_html.= '</div></div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_destination_grid', 'ppb_destination_grid_func');


function ppb_destination_grid_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'items' => 9,
		'destinationcat' => '',
		'title_align' => 'baseline',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
		'layout' => 'contain',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_destination_grid_sidebar '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('destination'),
	    'suppress_filters' => false,
	    'orderby' => 'menu_order',
	    'order' => 'ASC'
	);
	
	if(!empty($destinationcat))
	{
		$args['destinationcat'] = $destinationcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'three_cols';
	$grid_wrapper_class = 'classic3_cols';
	$column_class = 'one_thitd gallery3';
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid portrait '.esc_attr($wrapper_class).'" data-columns="4">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			if(!empty($image_url[0]))
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($title_align).' '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($small_image_url[0]).');">';
				
				if($title_align == 'center')
				{
					$return_html.= '<div class="ppb_background_overlay light"></div>';	
				}
				
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';

				$return_html.= '<div class="portfolio_info_wrapper"><div class="portfolio_info_content">';
				$return_html.= '<h3>'.get_the_title($portfolio_ID).'</h3>';
        		$return_html.= '</div></div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_destination_grid_sidebar', 'ppb_destination_grid_sidebar_func');


function ppb_destination_metro_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 9,
		'destinationcat' => '',
		'title_align' => 'baseline',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
		'layout' => 'contain',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	$columns = 2;
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_destination_metro '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column">';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'post_type' => array('destination'),
	    'suppress_filters' => false,
	    'orderby' => 'menu_order',
	    'order' => 'ASC'
	);
	
	if(!empty($destinationcat))
	{
		$args['destinationcat'] = $destinationcat;
	}
	
	$portfolios_arr = get_posts($args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'four_cols';
	$large_counter = 1;
	$next_number_to_add = 5;
	$next_trigger = 1;
	
	if(!empty($portfolios_arr) && is_array($portfolios_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid metro portrait '.esc_attr($wrapper_class).'" data-columns="4">';
	
		foreach($portfolios_arr as $key => $portfolio)
		{
			$image_url = '';
			$portfolio_ID = $portfolio->ID;
			
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
			$grandtour_image_size = 'grandtour-gallery-grid';
			
			$large_counter_trigger = FALSE;
			
			if($next_trigger == $key+1)
			{
				$large_counter_trigger = TRUE;
				$next_trigger = $next_trigger+$next_number_to_add;
				
				if($next_number_to_add == 5)
				{
					$next_number_to_add = 1;
				}
				else if($next_number_to_add==1)
				{
					$next_number_to_add = 5;
				}
			}
			
			if($large_counter_trigger)
			{
				$wrapper_class.= ' double_size';
				$grid_wrapper_class.= ' double_size';
				$column_class.= ' double_size';
				$grandtour_image_size = 'grandtour-blog';
			}
			
			$large_counter++;
					
			if(has_post_thumbnail($portfolio_ID, 'original'))
			{
			    $image_id = get_post_thumbnail_id($portfolio_ID);
			    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
			    
			    $small_image_url = wp_get_attachment_image_src($image_id, $grandtour_image_size, true);
			}
			
			$permalink_url = get_permalink($portfolio_ID);
			
			if(!empty($image_url[0]))
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($title_align).' '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($small_image_url[0]).');">';
				
				if($title_align == 'center')
				{
					$return_html.= '<div class="ppb_background_overlay light"></div>';	
				}
				
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';

				$return_html.= '<div class="portfolio_info_wrapper"><div class="portfolio_info_content">';
				$return_html.= '<h3>'.get_the_title($portfolio_ID).'</h3>';
        		$return_html.= '</div></div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_destination_metro', 'ppb_destination_metro_func');


function ppb_tourcat_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 9,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
		'layout' => 'contain',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	$columns = 2;
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_tourcat_grid '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column">';
	
	//Get tour categories
	$args = array(
		'hide_empty' => false,
		'hierarchical' => false,
		'parent' => false,
	    'number' => $items,
	    'orderby' => 'menu_order',
	);
	
	$tour_cats_arr = get_terms('tourcat', $args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'four_cols';
	$grid_wrapper_class = 'classic4_cols';
	$column_class = 'one_fourth gallery4';
	
	if(!empty($tour_cats_arr) && is_array($tour_cats_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid portrait '.esc_attr($wrapper_class).'" data-columns="4">';
	
		$i = 1;
		foreach($tour_cats_arr as $key => $tour_cat)
		{
			$image_url = '';
			$term_ID = $tour_cat->term_id;
					
			if(function_exists('z_taxonomy_image_url'))
		    {
			    $image_url = z_taxonomy_image_url($term_ID);
			}
			
			$permalink_url = get_term_link($term_ID);
			
			if(!empty($image_url) && $i<=$items)
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($image_url).');">';
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';

				$return_html.= '<div class="portfolio_info_wrapper">';
				$return_html.= '<h3>'.$tour_cat->name.'</h3>';
        		$return_html.= '</div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
			
			$i++;
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour category that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tourcat_grid', 'ppb_tourcat_grid_func');


function ppb_tourcat_grid_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'items' => 9,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
		'layout' => 'contain',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 9;
	}
	$all_items = $items;
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_tourcat_grid_sidebar '.$size.' nopadding ';
	
	$return_html.= '" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	//Get tour categories
	$args = array(
		'hide_empty' => false,
		'hierarchical' => false,
		'parent' => false,
	    'number' => $items,
	    'orderby' => 'menu_order',
	);
	
	$tour_cats_arr = get_terms('tourcat', $args);
	
	$custom_id = time().rand();
	
	$wrapper_class = 'three_cols';
	$grid_wrapper_class = 'classic3_cols';
	$column_class = 'one_thitd gallery3';
	
	if(!empty($tour_cats_arr) && is_array($tour_cats_arr))
	{
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery grid portrait '.esc_attr($wrapper_class).'" data-columns="4">';
	
		$i = 1;
		foreach($tour_cats_arr as $key => $tour_cat)
		{
			$image_url = '';
			$term_ID = $tour_cat->term_id;
					
			if(function_exists('z_taxonomy_image_url'))
		    {
			    $image_url = z_taxonomy_image_url($term_ID);
			}
			
			$permalink_url = get_term_link($term_ID);
			
			if(!empty($image_url) && $i<=$items)
			{
			
				//Begin display HTML
				$return_html.= '<div class="element grid '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
				$return_html.= '<div class="'.esc_attr($column_class).' grid static filterable portfolio_type themeborder" style="background-image:url('.esc_url($image_url).');">';
				$return_html.= '<a class="tour_image" href="'.esc_url($permalink_url).'"></a>';

				$return_html.= '<div class="portfolio_info_wrapper">';
				$return_html.= '<h3>'.$tour_cat->name.'</h3>';
        		$return_html.= '</div>';
				$return_html.= '</div>';
				$return_html.= '</div>';
			}
			
			$i++;
		}
		
		$return_html.= '</div>';
	}
	else
	{
		$return_html.= '<div class="tour_search_noresult"><span class="ti-info-alt"></span>'.esc_html_e("We haven't found any tour category that matches you're criteria", 'grandtour-custom-post').'</div>';
	}
	
	$return_html.= '</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_tourcat_grid_sidebar', 'ppb_tourcat_grid_sidebar_func');


function ppb_blog_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'cat' => '',
		'items' => '',
		'padding' => '',
		'custom_css' => '',
		'link_title' => '',
		'link_url' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	
	$return_html.= '<div '.$sec_id.' class="ppb_blog_grid '.$size.' nopadding"';
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.rawurldecode($custom_css).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	if(!is_numeric($items))
	{
		$items = 3;
	}
	
	//Get blog posts
	$args = array(
	    'numberposts' => $items,
	    'order' => 'DESC',
	    'orderby' => 'post_date',
	    'post_type' => array('post'),
	    'suppress_filters' => false,
	);

	if(!empty($cat))
	{
		$args['category'] = $cat;
	}
	$posts_arr = get_posts($args);
	
	if(!empty($posts_arr) && is_array($posts_arr))
	{
		$return_html.= '<div class="blog_grid_wrapper sidebar_content full_width ppb_blog_posts">';
	
		foreach($posts_arr as $key => $ppb_post)
		{
			$animate_layer = $key+7;
			$current_order = $key+1;
			$image_thumb = '';
										
			if(has_post_thumbnail($ppb_post->ID, 'large'))
			{
			    $image_id = get_post_thumbnail_id($ppb_post->ID);
			    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
			}
			
			$last_class = '';
			if($current_order%3 == 0)
			{
				$last_class = 'last';
			}
			
			$return_html.= '<div id="post-'.$ppb_post->ID.'" class="post type-post hentry status-publish '.esc_attr($last_class).'">
			<div class="post_wrapper grid_layout">';
			
			 //Get post featured content
		    $post_ft_type = get_post_meta($ppb_post->ID, 'post_ft_type', true);
		    
		    switch($post_ft_type)
		    {
		    	case 'Image':
		    	default:
		        	if(!empty($image_thumb))
		        	{
		        		$small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-blog', true);
		
		    	    $return_html.= '<div class="post_img small static">
		    	    	<a href="'.esc_url(get_permalink($ppb_post->ID)).'">
		    	    		<img src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($ppb_post->post_title).'" class=""/>
		                </a>
		    	    </div>';
		    		}
		    	break;
		    	
		    	case 'Vimeo Video':
		    		$post_ft_vimeo = get_post_meta($ppb_post->ID, 'post_ft_vimeo', true);
		
					$return_html.= do_shortcode('[tg_vimeo video_id="'.$post_ft_vimeo.'" width="670" height="377"]').'<br/>';
		    	break;
		    	
		    	case 'Youtube Video':
		    		$post_ft_youtube = get_post_meta($ppb_post->ID, 'post_ft_youtube', true);

		    		$return_html.= do_shortcode('[tg_youtube video_id="'.$post_ft_youtube.'" width="670" height="377"]').'<br/>';
		    	break;
		    	
		    } //End switch
		    
		    $return_html.= '<div class="post_header_wrapper">';
		    
		    $return_html.= '<div class="post_header grid">';
				
			$return_html.= '
				<div class="post_detail single_post">
				    <span class="post_info_date">
				    	<a href="'.esc_url(get_permalink($ppb_post->ID)).'" title="'.get_the_title($ppb_post->ID).'">'.get_the_time(GRANDTOUR_THEMEDATEFORMAT, $ppb_post->ID).'</a>
				    </span>
				</div>
				<h6><a href="'.esc_url(get_permalink($ppb_post->ID)).'" title="'.get_the_title($ppb_post->ID).'">'.get_the_title($ppb_post->ID).'</a></h6>
			</div>';
				
			$return_html.= grandtour_substr(grandtour_get_excerpt_by_id($ppb_post->ID), 80);
			    		    
			$return_html.= '
				<div class="post_button_wrapper">
			    	<a class="readmore" href="'.esc_url(get_permalink($ppb_post->ID)).'">'.esc_html__('Read More', 'grandtour-custom-post' ).'<span class="ti-angle-right"></span></a>
					</div>
			</div>';
		    
		    $return_html.= '    
				</div>
			</div>';
		$clear_br = '';

		}
		
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	if(!empty($link_title) && !empty($link_url))
	{
		$return_html.= '<br class="clear"/><div class="blog_recent_link">
		<a href="'.esc_url($link_url).'" class="button">'.rawurldecode($link_title).'</a>
	</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div></div>';
	
	return $return_html;
}

add_shortcode('ppb_blog_grid', 'ppb_blog_grid_func');


function ppb_service_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'items' => 3,
		'padding' => 30,
		'cat' => '',
		'columns' => '3',
		'align' => 'left',
		'layout' => 'fixedwidth',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));

	if(!is_numeric($items))
	{
		$items = 4;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withpadding ';
	
	if(!empty($layout) && $layout == 'fullwidth')
	{
		$return_html.= 'fullwidth ';
	}
	
	$return_html.= '" ';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner" ';
	if($layout == 'fullwidth')
	{
		$return_html.= 'style="width:100%;"';
	}
	$return_html.= '>';
	
	$service_order = 'ASC';
	$service_order_by = 'menu_order';
	
	//Get service items
	$args = array(
	    'numberposts' => $items,
	    'order' => $service_order,
	    'orderby' => $service_order_by,
	    'post_type' => array('services'),
	);
	
	if(!empty($cat))
	{
		$args['servicecats'] = $cat;
	}
	$services_arr = get_posts($args);
	
	//Check display columns
	$count_column = 3;
	$columns_class = 'one_third';
	$service_h = 'h3';
	
	switch($columns)
	{
		case 1:
			$count_column = 1;
			$columns_class = 'one';
			$service_h = 'h3';
		break;
	
		case 2:
			$count_column = 2;
			$columns_class = 'one_half';
			$service_h = 'h3';
		break;
		
		case 3:
		default:
			$count_column = 3;
			$columns_class = 'one_third';
			$service_h = 'h3';
		break;
		
		case 4:
			$count_column = 4;
			$columns_class = 'one_fourth';
			$service_h = 'h6';
		break;
	}
	
	if(!empty($content))
	{
		$return_html.= '<div class="one_third"  style="text-align:left">';
		$content = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $content);
		$return_html.= $content;
		$return_html.= '</div>';
	}

	if(!empty($services_arr) && is_array($services_arr))
	{
		if(!empty($content))
		{
			$return_html.= '<div class="two_third last">';
		}
	
		$return_html.= '<div class="service_content_wrapper">';
		$last_class = '';
	
		foreach($services_arr as $key => $service)
		{
			if(($key+1)%$count_column==0)
			{
				$last_class = 'last';
			}
			else
			{
				$last_class = '';
			}
			
			$return_html.= '<div class="'.$columns_class.' '.$last_class.'">';
			
			$image_url = '';
			$service_ID = $service->ID;
					
			//check if use font awesome
			$service_icon_code ='';
			$service_font_awesome = get_post_meta($service_ID, 'service_font_awesome', true);
					
			if(!empty($service_font_awesome))
			{
				$service_icon_code = get_post_meta($service_ID, 'service_font_awesome_code', true);
			}
			else
			{
				if(has_post_thumbnail($service_ID, 'large'))
				{
				    $image_id = get_post_thumbnail_id($service_ID);
				    $image_url = wp_get_attachment_image_src($image_id, 'original', true);
				    $service_icon_code = '<img src="'.$image_url[0].'" alt="'.esc_attr($service->post_title).'" />';
				}
			}
			$return_html.= '<div class="service_wrapper '.esc_attr(rawurldecode($align)).'">';
			
			if(!empty($service_icon_code))
			{
				$return_html.= '<div class="service_icon">'.$service_icon_code.'<div class="service_border"></div></div>';
			}
			
			$return_html.= '<div class="service_title">';
			$return_html.= '<'.$service_h.'>'.$service->post_title.'</'.$service_h.'>';
			$return_html.= '<div class="service_content">'.$service->post_content.'</div>';
			$return_html.= '</div>';
			
			$return_html.= '</div>';
			$return_html.= '</div>';
		}
		
		$return_html.= '</div>';
		
		if(!empty($content))
		{
			$return_html.= '</div>';
		}
	}
	
	$return_html.= '</div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_service', 'ppb_service_func');


function ppb_service_content_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'items' => 3,
		'padding' => 30,
		'cat' => '',
		'order' => 'default',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));

	if(!is_numeric($items))
	{
		$items = 3;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withpadding ';
	
	if(!empty($layout) && $layout == 'fullwidth')
	{
		$return_html.= 'fullwidth ';
	}
	
	$return_html.= '" ';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper"><div class="inner"> ';
	
	if(!empty($content))
	{
		$return_html.= '<div class="one_half">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title">'.rawurldecode($title).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="ppb_subtitle">'.rawurldecode($subtitle).'</div>';
		}
		
		$return_html.= do_shortcode(grandtour_apply_content($content));
		$return_html.= '</div>';
	}

	//display service content
	$return_html.= '<div class="one_half last">';	
	$return_html.= do_shortcode('[tg_service_vertical cat="'.esc_attr($cat).'" items="'.esc_attr($items).'" align="left"]');
	$return_html.= '</div>';
	
	$return_html.= '</div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_service_content', 'ppb_service_content_func');


function ppb_fullwidth_button_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'padding' => 30,
		'slug' => '',
		'title' => '',
		'bgcolor' => '',
		'fontcolor' => '#000',
		'button_text' => '',
		'link_url' => '',
		'button_bgcolor' => '',
		'button_fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	//Set begin wrapper div for live builder
	$return_html= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' ppb_fullwidth_button" ';
	
	$custom_css = '';
	
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="padding:'.$padding.'px 0 '.$padding.'px 0;'.rawurldecode($custom_css).'" ';
	}
	
	$return_html.= '>';
	
	$return_html.= '<div class="standard_wrapper">';
	
	if(!empty($title))
	{
		$return_html.= '<h2 class="title" style="color:'.esc_attr($fontcolor).';">'.rawurldecode($title).'</h2>';
	}
	
	$custom_css = '';
	if(!empty($button_text))
	{
		if(!empty($button_bgcolor))
		{
			$custom_css.= 'background-color:'.$button_bgcolor.';border-color:'.$button_bgcolor.';';
		}
		
		if(!empty($button_fontcolor))
		{
			$custom_css.= 'color:'.$button_fontcolor.';';
		}
	
		$return_html.= '<a href="'.esc_url($link_url).'" class="button" ';
		
		if(!empty($custom_css))
		{
			$return_html.= 'style="'.$custom_css.'"';
		}
		
		$return_html.= '>'.rawurldecode($button_text).'</a>';
	}
	
	$return_html.= '</div>';
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	return $return_html;

}

add_shortcode('ppb_fullwidth_button', 'ppb_fullwidth_button_func');


function ppb_pricing_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'skin' => 'normal',
		'items' => 3,
		'cat' => '',
		'columns' => '3',
		'highlightcolor' => '#001d2c',
		'bgcolor' => '',
		'padding' => 30,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));

	if(!is_numeric($items))
	{
		$items = 4;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' ppb_pricing"';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	$pricing_order = 'ASC';
	$pricing_order_by = 'menu_order';
	
	//Get portfolio items
	$args = array(
	    'numberposts' => $items,
	    'order' => $pricing_order,
	    'orderby' => $pricing_order_by,
	    'post_type' => array('pricing'),
	);
	
	if(!empty($cat))
	{
		$args['pricingcats'] = $cat;
	}
	$pricing_arr = get_posts($args);
	
	//Check display columns
	$count_column = 3;
	$columns_class = 'one_third';
	
	switch($columns)
	{
		case 2:
			$count_column = 2;
			$columns_class = 'one_half';
		break;
		
		case 3:
		default:
			$count_column = 3;
			$columns_class = 'one_third';
		break;
		
		case 4:
			$count_column = 4;
			$columns_class = 'one_fourth';
		break;
	}
	
	$custom_header = '';
	$custom_button = '';
	$custom_price = '';
	switch($skin)
	{
		case 'light':
		default:
			$custom_header = 'color:'.$highlightcolor.';';
			$custom_price = 'color:'.$highlightcolor.';';
			$custom_button = 'background:'.$highlightcolor.';border-color:'.$highlightcolor.';color:#fff;';
			
		break;
		
		case 'normal':
			$custom_header = 'background:'.$highlightcolor.';';
			$custom_price = 'color:'.$highlightcolor.';';
			$custom_button = 'background:'.$highlightcolor.';border-color:'.$highlightcolor.';color:#fff;';
		break;
	}

	if(!empty($pricing_arr) && is_array($pricing_arr))
	{
		$return_html.= '<div class="pricing_content_wrapper '.$skin.'">';
		$last_class = '';
	
		foreach($pricing_arr as $key => $pricing)
		{
			if(($key+1)%$count_column==0)
			{
				$last_class = 'last';
			}
			else
			{
				$last_class = '';
			}
			
			//Check if featured
			$priing_featured_class = '';
			$priing_button_class = '';
			$pricing_plan_featured = get_post_meta($pricing->ID, 'pricing_featured', true);
			if(!empty($pricing_plan_featured))
			{
				$priing_featured_class = 'featured';
			}
			
			$return_html.= '<div class="pricing '.esc_attr($columns_class).' '.esc_attr($priing_featured_class).' '.esc_attr($last_class).'">';
			$return_html.= '<div class="pricing_wrapper_border"><ul class="pricing_wrapper">';
			
			$return_html.= '<li class="title_row '.esc_attr($priing_featured_class).'" style="'.esc_attr($custom_header).'">'.$pricing->post_title.'</li>';
			
			//Check price
			$pricing_plan_currency = get_post_meta($pricing->ID, 'pricing_plan_currency', true);
			$pricing_plan_price = get_post_meta($pricing->ID, 'pricing_plan_price', true);
			$pricing_plan_time = get_post_meta($pricing->ID, 'pricing_plan_time', true);
			
			$return_html.= '<li class="price_row">';
			$return_html.= '<strong>'.$pricing_plan_currency.'</strong>';
			$return_html.= '<em class="exact_price" style="'.esc_attr($custom_price).'">'.$pricing_plan_price.'</em>';
			$return_html.= '<em class="time">'.$pricing_plan_time.'</em>';
			$return_html.= '</li>';
			
			//Get pricing features
			$pricing_plan_features = get_post_meta($pricing->ID, 'pricing_plan_features', true);
			$pricing_plan_features = trim($pricing_plan_features);
			$pricing_plan_features_arr = explode("\n", $pricing_plan_features);
			$pricing_plan_features_arr = array_filter($pricing_plan_features_arr, 'trim');
			
			foreach ($pricing_plan_features_arr as $feature) {
			    $return_html.= '<li>'.$feature.'</li>';
			}
			
			//Get button
			$pricing_button_text = get_post_meta($pricing->ID, 'pricing_button_text', true);
			$pricing_button_url = get_post_meta($pricing->ID, 'pricing_button_url', true);
			
			$return_html.= '<li class="button_row '.esc_attr($priing_featured_class).'"><a href="'.esc_url($pricing_button_url).'" class="button"  style="'.esc_attr($custom_button).'">'.$pricing_button_text.'</a></li>';
			
			$return_html.= '</ul></div>';
			$return_html.= '</div>';
		}
		
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_pricing', 'ppb_pricing_func');


function ppb_team_column_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'columns' => 4,
		'title' => '',
		'items' => 4,
		'cat' => '',
		'order' => 'default',
		'layout' => 'contain',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 4;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_team_column" ';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper page_main_content sidebar_content full_width fixed_column photoframe">';
	
	$team_order = 'ASC';
	$team_order_by = 'menu_order';
	switch($order)
	{
		case 'default':
			$team_order = 'ASC';
			$team_order_by = 'menu_order';
		break;
		
		case 'newest':
			$team_order = 'DESC';
			$team_order_by = 'post_date';
		break;
		
		case 'oldest':
			$team_order = 'ASC';
			$team_order_by = 'post_date';
		break;
		
		case 'title':
			$team_order = 'ASC';
			$team_order_by = 'title';
		break;
		
		case 'random':
			$team_order = 'ASC';
			$team_order_by = 'rand';
		break;
	}
	
	//Check display columns
	$wrapper_class = '';
	$grid_wrapper_class = '';
	$column_class = '';
	
	switch($columns)
	{
		case 2:
			$wrapper_class = 'two_cols';
			$grid_wrapper_class = 'classic2_cols';
			$column_class = 'one_half gallery2';
		break;
		
		case 3:
			$wrapper_class = 'three_cols';
			$grid_wrapper_class = 'classic3_cols';
			$column_class = 'one_third gallery3';
		break;
		
		case 4:
			$wrapper_class = 'four_cols';
			$grid_wrapper_class = 'classic4_cols';
			$column_class = 'one_fourth gallery4';
		break;
		
		case 5:
			$wrapper_class = 'five_cols';
			$grid_wrapper_class = 'classic5_cols';
			$column_class = 'one_fifth gallery5';
		break;
	}
	
	$custom_id = time().rand();
	
	//Get team items
	$args = array(
	    'numberposts' => $items,
	    'order' => $team_order,
	    'orderby' => $team_order_by,
	    'post_type' => array('team'),
	);
	
	if(!empty($cat))
	{
		$args['teamcats'] = $cat;
	}
	$team_arr = get_posts($args);
	
	if(!empty($team_arr) && is_array($team_arr))
	{
		if($layout == 'contain')
		{
			$return_html.= '<div class="standard_wrapper">';
		}
	
		$return_html.= '<div id="'.$custom_id.'" class="portfolio_filter_wrapper gallery '.esc_attr($wrapper_class).'" data-columns="'.esc_attr($columns).'">';
	
		foreach($team_arr as $key => $member)
		{
			$image_url = '';
			$member_ID = $member->ID;
					
			if(has_post_thumbnail($member_ID, 'grandtour-gallery-list'))
			{
			    $image_id = get_post_thumbnail_id($member_ID);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-list', true);
			}
			
			//Begin display HTML
			$return_html.= '<div class="element grid photoframe fixed_columns '.esc_attr($grid_wrapper_class).' animated'.($key+1).'">';
			$return_html.= '<div class="'.esc_attr($column_class).' classic filterable">';
			
			if(!empty($small_image_url[0]))
			{
				$return_html.= '<div class="post_img">';
				$return_html.= '<img class="team_pic" src="'.esc_url($small_image_url[0]).'" alt=""/>';
				
				$member_facebook = get_post_meta($member_ID, 'member_facebook', true);
				$member_twitter = get_post_meta($member_ID, 'member_twitter', true);
				$member_google = get_post_meta($member_ID, 'member_google', true);
				$member_linkedin = get_post_meta($member_ID, 'member_linkedin', true);
	            
	            if(!empty($member_facebook) OR !empty($member_twitter) OR !empty($member_google) OR !empty($member_linkedin))
				{
				    $return_html.= '<ul class="social_wrapper team">';
				    
				    if(!empty($member_twitter))
				    {
				        $return_html.= '<li><a title="'.esc_attr($member->post_title).' on Twitter" target="_blank" class="tooltip" href="https://twitter.com/'.$member_twitter.'"><i class="fa fa-twitter"></i></a></li>';
				    }
		 
				    if(!empty($member_facebook))
				    {
				        $return_html.= '<li><a title="'.esc_attr($member->post_title).' on Facebook" target="_blank" class="tooltip" href="https://facebook.com/'.$member_facebook.'"><i class="fa fa-facebook"></i></a></li>';
				    }
				    
				    if(!empty($member_google))
				    {
				        $return_html.= '<li><a title="'.esc_attr($member->post_title).' on Google+" target="_blank" class="tooltip" href="'.$member_google.'"><i class="fa fa-google-plus"></i></a></li>';
				    }
				        
				    if(!empty($member_linkedin))
				    {
				        $return_html.= '<li><a title="'.esc_attr($member->post_title).' on Linkedin" target="_blank" class="tooltip" href="'.$member_linkedin.'"><i class="fa fa-linkedin"></i></a></li>';
				    }
				    
				    $return_html.= '</ul>';
				}
				
				$return_html.= '</div>';
			}
			
			$team_position = get_post_meta($member_ID, 'team_position', true);
			
			$return_html.= '<div class="portfolio_info_wrapper center">';
            $return_html.= '<h4>'.$member->post_title.'</h4>';
            if(!empty($team_position))
            {
            	$return_html.= '<div class="page_tagline">'.$team_position.'</div>';
            }

			$return_html.= '</div>';
			$return_html.= '</div>';
			$return_html.= '</div>';
		}
		
		$return_html.= '</div>';
		
		if($layout == 'contain')
		{
			$return_html.= '</div>';
		}
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_team_column', 'ppb_team_column_func');


function ppb_promo_box_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'button_text' => '',
		'button_url' => '',
		'background_color' => '',
		'builder_id' => '',
	), $atts));
	
	$return_html = '<div class="one skinbg" ';
	
	if(!empty($background_color))
	{
		$return_html.= 'style="background:'.esc_attr($background_color).'"';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.='<div class="page_content_wrapper promo_box_wrapper">';
	$return_html.= do_shortcode('[tg_promo_box title="'.$title.'" button_text="'.rawurldecode($button_text).'" button_url="'.esc_url($button_url).'" button_style="button transparent"]'.$content.'[/tg_promo_box]');
	$return_html.='</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_promo_box', 'ppb_promo_box_func');


function ppb_testimonial_slider_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'slug' => '',
		'items' => '',
		'cat' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'background' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	wp_enqueue_script("flexslider", get_template_directory_uri()."/js/flexslider/jquery.flexslider-min.js", false, GRANDTOUR_THEMEVERSION, true);
	wp_enqueue_script("script-testimonials-flexslider", admin_url('admin-ajax.php')."?action=grandtour_script_testimonials_flexslider", false, GRANDTOUR_THEMEVERSION, true);
	
	$testimonials_order = 'ASC';
	$testimonials_order_by = 'menu_order';
	
	//Get testimonial items
	$args = array(
	    'numberposts' => $items,
	    'order' => $testimonials_order,
	    'orderby' => $testimonials_order_by,
	    'post_type' => array('testimonials'),
	);
	
	if(!empty($cat))
	{
		$args['testimonialcats'] = $cat;
	}
	$testimonial_arr = get_posts($args);
	
	$return_html = '';
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
	}
	
	$return_html.= '" ';
	
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}

	if(!empty($background))
	{
		$custom_css.= 'background-image:url('.esc_url($background).');background-size:cover; ';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div class="page_content_wrapper" style="text-align:center"><div class="inner">';
	
	if(!empty($testimonial_arr) && is_array($testimonial_arr))
	{
		$return_html.= '<div class="testimonial_slider_wrapper">';
		$return_html.= '<div class="flexslider" data-height="750">';
		$return_html.= '<ul class="slides">';
		
		foreach($testimonial_arr as $key => $testimonial)
		{
			$testimonial_ID = $testimonial->ID;
		
			//Get testimonial meta
			$testimonial_name = get_post_meta($testimonial_ID, 'testimonial_name', true);
			
			$return_html.= '<li>';
			$return_html.= '<div class="testimonial_slider_wrapper">';
			
			if(!empty($testimonial->post_content))
			{
				$return_html.= $testimonial->post_content;
			}
			
			if(!empty($testimonial_name))
			{
				$return_html.= '<div class="testimonial_slider_meta">';
				
				//Get customer picture
				if(has_post_thumbnail($testimonial_ID, 'thumbnail'))
				{
				    $image_id = get_post_thumbnail_id($testimonial_ID);
				    $small_image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
				}
				
				if(!empty($small_image_url[0]))
				{
					$return_html.= '<div class="testimonial_image animated" data-animation="bigEntrance">';
					$return_html.='<img class="team_pic" src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($testimonial_name).'"/>';
					$return_html.= '</div>';
				}
				
				$return_html.= '<h6 ';
				
				if(!empty($fontcolor))
				{
				    $return_html.= 'style="color:'.esc_attr($fontcolor).'"';
				}
				
				$return_html.= '>'.$testimonial_name.'</h6>';
				
				$return_html.= '</div>';
			}
			
			$return_html.= '</div>';
			$return_html.= '</li>';
		}
		
		$return_html.= '</ul>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('ppb_testimonial_slider', 'ppb_testimonial_slider_func');


function ppb_testimonial_column_func($atts, $content) {
	remove_filter('the_content', 'pp_formatter', 99);

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'columns' => 2,
		'items' => 4,
		'cat' => '',
		'fontcolor' => '',
		'bgcolor' => '',
		'background' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(!is_numeric($items))
	{
		$items = 4;
	}
	
	if(!is_numeric($columns))
	{
		$columns = 2;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '';
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_testimonial_column"';
	
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	
	if(!empty($background))
	{
		$custom_css.= 'background-image:url('.esc_url($background).');background-size:cover; ';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	$return_html.= '<div class="standard_wrapper">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$testimonials_order = 'ASC';
	$testimonials_order_by = 'menu_order';
	
	//Check display columns
	$count_column = 3;
	$columns_class = 'one_third';
	
	switch($columns)
	{	
		case 2:
			$count_column = 2;
			$columns_class = 'one_half';
		break;
		
		case 3:
		default:
			$count_column = 3;
			$columns_class = 'one_third';
		break;
		
		case 4:
			$count_column = 4;
			$columns_class = 'one_fourth';
		break;
	}
	
	//Get testimonial items
	$args = array(
	    'numberposts' => $items,
	    'order' => $testimonials_order,
	    'orderby' => $testimonials_order_by,
	    'post_type' => array('testimonials'),
	);
	
	if(!empty($cat))
	{
		$args['testimonialcats'] = $cat;
	}
	$testimonial_arr = get_posts($args);
	
	if(!empty($testimonial_arr) && is_array($testimonial_arr))
	{
		$return_html.= '<div class="page_content_wrapper"><div class="inner"><div class="testimonial_wrapper">';
	
		foreach($testimonial_arr as $key => $testimonial)
		{
			$image_url = '';
			$testimonial_ID = $testimonial->ID;
					
			//Get customer picture
			if(has_post_thumbnail($testimonial_ID, 'thumbnail'))
			{
			    $image_id = get_post_thumbnail_id($testimonial_ID);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'thumbnail', true);
			}
			
			$last_class = '';
			if(($key+1)%$count_column==0)
			{
				$last_class = 'last';
			}
			
			//Begin display HTML
			$return_html.= '<div class="'.esc_attr($columns_class).' testimonial_column_element animated'.($key+1).' '.esc_attr($last_class).'">';
			
			//Get testimonial meta
			$testimonial_name = get_post_meta($testimonial_ID, 'testimonial_name', true);
			$testimonial_position = get_post_meta($testimonial_ID, 'testimonial_position', true);
			$testimonial_company_name = get_post_meta($testimonial_ID, 'testimonial_company_name', true);
			$testimonial_company_website = get_post_meta($testimonial_ID, 'testimonial_company_website', true);
			
			if(!empty($small_image_url[0]))
			{
				$return_html.= '<div class="testimonial_image animated" data-animation="bigEntrance">';
				$return_html.='<img class="team_pic" src="'.esc_url($small_image_url[0]).'" alt="'.esc_attr($testimonial_name).'"/>';
				$return_html.= '</div>';
			}
			
			if(!empty($testimonial->post_content))
			{
				$return_html.= '<div class="testimonial_content">';
				$return_html.= $testimonial->post_content;
				
				if(!empty($testimonial_name))
				{
					$return_html.= '<br/><br/><div class="testimonial_customer">';
					$return_html.= '<h6 ';
					
					if(!empty($fontcolor))
					{
						$return_html.= 'style="color:'.esc_attr($fontcolor).';"';
					}
					
					$return_html.= '>'.$testimonial_name.'</h6>';
					
					if(!empty($testimonial_position))
					{
						$return_html.= '<div class="testimonial_customer_position" ';
						
						if(!empty($fontcolor))
						{
							$return_html.= 'style="color:'.esc_attr($fontcolor).';"';
						}
						
						$return_html.= '>'.$testimonial_position.'</div>';
					}
					
					if(!empty($testimonial_company_name))
					{
						$return_html.= '-<div class="testimonial_customer_company">';
						
						if(!empty($testimonial_company_website))
						{
							$return_html.= '<a href="'.esc_url($testimonial_company_website).'" target="_blank" ';
							
							if(!empty($fontcolor))
							{
								$return_html.= 'style="color:'.esc_attr($fontcolor).';"';
							}
							
							$return_html.= '>';
						}
						
						$return_html.=$testimonial_company_name;
						
						if(!empty($testimonial_company_website))
						{
							$return_html.= '</a>';
						}
						
						$return_html.= '</div>';
					}
					
					$return_html.= '</div>';
				}
				
				$return_html.= '</div>';
			}
			
			$return_html.= '</div>';
		}
		
		$return_html.= '</div></div></div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_testimonial_column', 'ppb_testimonial_column_func');


function ppb_contact_map_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'lat' => 0,
		'long' => 0,
		'zoom' => 8,
		'type' => '',
		'popup' => '',
		'address' => '',
		'marker' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'buttonbgcolor' => '',
		'custom_css' => '',
		'contactform' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="ppb_contact_map one nopadding" ';
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="floatleft nopadding"><div class="one_half_bg contact_form" ';
	
	$contact_form_custom_css = '';
	if(!empty($bgcolor))
	{
		$contact_form_custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$contact_form_custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($contact_form_custom_css))
	{
		$return_html.= 'style="'.esc_attr($contact_form_custom_css).'"';
	}
	
	$return_html.= '>';
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	//Display Title
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" ';
		if(!empty($fontcolor))
		{
			$return_html.= 'style="'.esc_attr($custom_css_fontcolor).';"';
		}
		$return_html.= '>'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	//Display Content
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	//Display Content
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.rawurldecode($content).'</div>';
	}
	
	//Display contact form
    
    //Setup Google Map API Key
	grandtour_set_map_api();

	$return_html.= '<div class="contact_form7_wrapper">';
  	$return_html.= do_shortcode('[contact-form-7 id="'.esc_attr($contactform).'"]');	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Display Map
	$return_html.= '<div class="one_half_bg nopadding" style="height:100%">';
	$return_html.= '<div id="map'.$custom_id.'" class="map_shortcode_wrapper" style="width:100%;height:100%">';
	$return_html.= '<div class="map-marker" ';
	
	if(!empty($popup))
	{
		$return_html.= 'data-title="'.esc_attr(rawurldecode($popup)).'" ';
	}
	
	if(!empty($lat) && !empty($long))
	{
		$return_html.= 'data-latlng="'.esc_attr(rawurldecode($lat)).','.esc_attr(rawurldecode($long)).'" ';
	}
	
	if(!empty($address))
	{
		$return_html.= 'data-address="'.esc_attr(rawurldecode($address)).'" ';
	}
	
	if(!empty($marker))
	{
		$return_html.= 'data-icon="'.esc_attr(rawurldecode($marker)).'" ';
	}
		
	$return_html.= '>';
	
	if(!empty($popup))
	{
		$return_html.= '<div class="map-infowindow">'.rawurldecode($popup).'</div>';
	}
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	$ext_attr = array(
		'id' => 'map'.$custom_id,
		'zoom' => $zoom,
		'type' => $type,
	);
	
	$ext_attr_serialize = serialize($ext_attr);
	
	wp_enqueue_script("simplegmaps", get_template_directory_uri()."/js/jquery.simplegmaps.min.js", false, GRANDTOUR_THEMEVERSION, true);
	wp_enqueue_script("script-contact-map".$custom_id, admin_url('admin-ajax.php')."?action=grandtour_script_map_shortcode&fullheight=true&data=".$ext_attr_serialize, false, GRANDTOUR_THEMEVERSION, true);
	$return_html.= '</div>';
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('ppb_contact_map', 'ppb_contact_map_func');


function ppb_contact_sidebar_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'title' => '',
		'slug' => '',
		'subtitle' => '',
		'sidebar' => '',
		'sidebar_layout' => 'left',
		'padding' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'contactform' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$sidebar_class = '';
	if($sidebar_layout == 'left')
	{
		$sidebar_class = 'left_sidebar';
	}
	
	$return_html = '';
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div '.$sec_id.' class="ppb_contact_sidebar one withsmallpadding" ';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.rawurldecode($custom_css).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner"><div class="inner_wrapper">';
	
	$return_html.= '<div class="sidebar_content '.esc_attr($sidebar_class).'">';
	
	//Display Title
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	//Display Content
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline">'.rawurldecode($subtitle).'</div>';
	}
	
	//Display Content
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
	}
	
	//Display contact form
	$return_html.= '<div class="contact_form7_wrapper">';
  	$return_html.= do_shortcode('[contact-form-7 id="'.esc_attr($contactform).'"]');	
	$return_html.= '</div>';
	
	$return_html.= '</div>';
	
	//Display Sidebar
	$return_html.= '<div class="sidebar_wrapper '.esc_attr($sidebar_class).'"><div class="sidebar"><div class="content"><ul class="sidebar_widget">';
	$return_html.= grandtour_get_dynamic_sidebar(rawurldecode($sidebar));
	$return_html.= '</ul></div></div></div>';
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('ppb_contact_sidebar', 'ppb_contact_sidebar_func');


function ppb_contact_half_bg_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'background' => '',
		'background_parallax' => '',
		'background_position' => '',
		'padding' => 30,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'align' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'parallax' => 0,
		'contactform' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_contact_half_bg ';
	
	if(!empty($background))
	{
		$return_html.= 'withbg ';
		$custom_css.= 'background-image:url('.esc_url($background).');';
	}
	
	$parallax_stellar = '';
	if(!empty($parallax))
	{
		$return_html.= 'parallax ';
		$parallax_stellar.= 'data-stellar-ratio="1.3"';
	}
	
	if(!empty($background_position))
	{
		$custom_css.= 'background-position: center '.esc_attr($background_position).';';
	}
	
	$return_html.= '"';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		if($align == 'left')
		{
			$return_html.= '<div class="one_half_bg" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" '.$parallax_stellar.'>';
		}
		else
		{
			$return_html.= '<div class="one_half_bg floatright" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" '.$parallax_stellar.'>';
		}
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		//Display contact form
		$return_html.= '<div class="contact_form7_wrapper">';
	  	$return_html.= do_shortcode('[contact-form-7 id="'.esc_attr($contactform).'"]');	
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_contact_half_bg', 'ppb_contact_half_bg_func');


function ppb_contact_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'width' => '100%',
		'padding' => 30,
		'bgcolor' => '',
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	
	if($size!='one')
	{
		$return_html.= '<div class="standard_wrapper">';
	}

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_contact_fullwidth"';
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).' !important;';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	
	//Display contact form
	//Get contact form random ID
	$custom_id = time().rand();
	$pp_contact_form = unserialize(get_option('pp_contact_form_sort_data'));
	
	//Setup Google Map API Key
	grandtour_set_map_api();
	
	wp_enqueue_script("validate", get_template_directory_uri()."/js/jquery.validate.js", false, GRANDTOUR_THEMEVERSION, true);
	
	wp_register_script("script-contact-form", admin_url('admin-ajax.php')."?action=grandtour_script_contact_form&form=".$custom_id, false, GRANDTOUR_THEMEVERSION, true);
	$params = array(
	  'ajaxurl' => admin_url('admin-ajax.php'),
	  'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
	);
	wp_localize_script( 'script-contact-form', 'tgAjax', $params );
	wp_enqueue_script("script-contact-form", admin_url('admin-ajax.php')."?action=grandtour_script_contact_form&form=".$custom_id, false, GRANDTOUR_THEMEVERSION, true);
	
	$return_html.= '<div id="reponse_msg_'.$custom_id.'" class="contact_form_response"><ul></ul></div>';
	
	$return_html.= '<form id="contact_form_'.$custom_id.'" class="contact_form_wrapper" method="post" action="/wp-admin/admin-ajax.php">';
	$return_html.= '<input type="hidden" id="action" name="action" value="grandtour_contact_mailer"/>';
	
	if(is_array($pp_contact_form) && !empty($pp_contact_form))
	{
	    foreach($pp_contact_form as $form_input)
	    {
	    	switch($form_input)
	    	{
	    			case 1:
	    			
	    			$return_html.= '<label for="your_name">'.esc_html__('Name *', 'grandtour-custom-post' ).'</label>
	    			<input id="your_name" name="your_name" type="text" class="required_field" placeholder="'.esc_html__('Name *', 'grandtour-custom-post' ).'"/>
	    			';	
	
	    			break;
	    			
	    			case 2:
	    			
	    			$return_html.= '<label for="email">'.esc_html__('Email *', 'grandtour-custom-post' ).'</label>
	    			<input id="email" name="email" type="text" class="required_field email" placeholder="'.esc_html__('Email *', 'grandtour-custom-post' ).'"/>
	    			';	
	
	    			break;
	    			
	    			case 3:
	    			
	    			$return_html.= '<label for="message">'.esc_html__('Message *', 'grandtour-custom-post' ).'</label>
	    			<textarea id="message" name="message" rows="7" cols="10" class="required_field" style="width:96%;" placeholder="'.esc_html__('Message *', 'grandtour-custom-post' ).'"></textarea>
	    			';	
	
	    			break;
	    			
	    			case 4:
	    			
	    			$return_html.= '<label for="address">'.esc_html__('Address', 'grandtour-custom-post' ).'</label>
	    			<input id="address" name="address" type="text" placeholder="'.esc_html__('Address', 'grandtour-custom-post' ).'"/>
	    			';	
	
	    			break;
	    			
	    			case 5:
	    			
	    			$return_html.= '<label for="phone">'.esc_html__('Phone', 'grandtour-custom-post' ).'</label>
	    			<input id="phone" name="phone" type="text" placeholder="'.esc_html__('Phone', 'grandtour-custom-post' ).'"/>
	    			';
	
	    			break;
	    			
	    			case 6:
	    			
	    			$return_html.= '<label for="mobile">'.esc_html__('Mobile', 'grandtour-custom-post' ).'</label>
	    			<input id="mobile" name="mobile" type="text" placeholder="'.esc_html__('Mobile', 'grandtour-custom-post' ).'"/>
	    			';		
	
	    			break;
	    			
	    			case 7:
	    			
	    			$return_html.= '<label for="company">'.esc_html__('Company Name', 'grandtour-custom-post' ).'</label>
	    			<input id="company" name="company" type="text" placeholder="'.esc_html__('Company Name', 'grandtour-custom-post' ).'"/>
	    			';
	
	    			break;
	    			
	    			case 8:
	    			
	    			$return_html.= '<label for="country">'.esc_html__('Country', 'grandtour-custom-post' ).'</label>				
	    			<input id="country" name="country" type="text" placeholder="'.esc_html__('Country', 'grandtour-custom-post' ).'"/>
	    			';
	    			break;
	    		}
	    	}
	    }
	
	    $pp_contact_enable_captcha = get_option('pp_contact_enable_captcha');
	    
	    if(!empty($pp_contact_enable_captcha))
	    {
	    
	    $return_html.= '<div id="captcha-wrap">
	    	<div class="captcha-box">
	    		<img src="'.get_template_directory_uri().'/get_captcha.php" alt="" id="captcha" />
	    	</div>
	    	<div class="text-box">
	    		<label>Type the two words:</label>
	    		<input name="captcha-code" type="text" id="captcha-code">
	    	</div>
	    	<div class="captcha-action">
	    		<img src="'.get_template_directory_uri().'/images/refresh.jpg"  alt="" id="captcha-refresh" />
	    	</div>
	    </div>
	    <br class="clear"/><br/>';
	
	}
	
	$return_html.= '<br/><br/><div class="contact_submit_wrapper">
	    <input id="contact_submit_btn'.$custom_id.'" name="contact_submit_btn'.$custom_id.'" type="submit" class="solidbg" value="'.esc_html__('Send', 'grandtour-custom-post' ).'" ';
	
	$return_html.= '/>
	</div>';
	
	$return_html.= '</form>';
	
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	if($size!='one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_contact_fullwidth', 'ppb_contact_fullwidth_func');


function ppb_map_func($atts) {
	//extract short code attr
	extract(shortcode_atts(array(
		'height' => 600,
		'slug' => '',
		'lat' => 0,
		'long' => 0,
		'zoom' => 8,
		'type' => '',
		'popup' => '',
		'address' => '',
		'marker' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$return_html = '<div '.$sec_id.' class="one nopadding">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);

	$custom_id = time().rand();
	$return_html = '<div class="map_shortcode_wrapper" id="map'.$custom_id.'" style="width:100%;height:'.esc_attr($height).'px">';
	$return_html.= '<div class="map-marker" ';
	
	if(!empty($popup))
	{
		$return_html.= 'data-title="'.esc_attr(rawurldecode($popup)).'" ';
	}
	
	if(!empty($lat) && !empty($long))
	{
		$return_html.= 'data-latlng="'.esc_attr(rawurldecode($lat)).','.esc_attr(rawurldecode($long)).'" ';
	}
	
	if(!empty($address))
	{
		$return_html.= 'data-address="'.esc_attr(rawurldecode($address)).'" ';
	}
	
	if(!empty($marker))
	{
		$return_html.= 'data-icon="'.esc_attr(rawurldecode($marker)).'" ';
	}
		
	$return_html.= '>';
	
	if(!empty($popup))
	{
		$return_html.= '<div class="map-infowindow">'.rawurldecode($popup).'</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	$ext_attr = array(
		'id' => 'map'.$custom_id,
		'zoom' => $zoom,
		'type' => $type,
	);
	
	$ext_attr_serialize = serialize($ext_attr);
	
	//Setup Google Map API Key
	grandtour_set_map_api();
	
	wp_enqueue_script("simplegmaps", get_template_directory_uri()."/js/jquery.simplegmaps.min.js", false, GRANDTOUR_THEMEVERSION, true);
	wp_enqueue_script("script-contact-map".$custom_id, admin_url('admin-ajax.php')."?action=grandtour_script_map_shortcode&data=".$ext_attr_serialize, false, GRANDTOUR_THEMEVERSION, true);

	return $return_html;

}

add_shortcode('ppb_map', 'ppb_map_func');


function ppb_animated_gallery_grid_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'slug' => '',
		'gallery_id' => '',
		'rows' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}
	
	$custom_css = '';
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).'" style="'.esc_attr(rawurldecode($custom_css)).'">';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$images_arr = get_post_meta($gallery_id, 'wpsimplegallery_gallery', true);
	
	if(!empty($images_arr))
	{
		//Get contact form random ID
		$custom_id = time().rand();
	
		wp_enqueue_script("modernizr", get_template_directory_uri()."/js/modernizr.js", false, GRANDTOUR_THEMEVERSION, true);
		wp_enqueue_script("gridrotator", get_template_directory_uri()."/js/jquery.gridrotator.js", false, GRANDTOUR_THEMEVERSION, true);
		wp_enqueue_script("grandtour-script-gridrotator-".$custom_id, admin_url('admin-ajax.php')."?action=grandtour_script_gridrotator&grid=".$custom_id.'&rows='.$rows, false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= '<div id="'.$custom_id.'" class="ri-grid ri-grid-size-3">';
		
		$return_html.= '<ul>';
		
		foreach($images_arr as $key => $image)
		{
			$image_url = wp_get_attachment_image_src($image, 'thumbnail', true);
			$image_alt = get_post_meta($image, '_wp_attachment_image_alt', true);
			
			$return_html.= '<li><a href="javascript:;"><img src="'.esc_url($image_url[0]).'" alt="'.esc_attr($image_alt).'"/></a></li>';
		}
		
		$return_html.= '</ul>';
		$return_html.= '</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	
	return $return_html;
}

add_shortcode('ppb_animated_gallery_grid', 'ppb_animated_gallery_grid_func');


function ppb_header_youtube_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'fontcolor' => '',
		'textalign' => 'left',
		'width' => '100',
		'padding' => 30,
		'youtube' => '',
		'bgcolor' => '#000000',
		'opacity' => 100,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	if($size != 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_header_youtube withbg parallax" ';
	
	if(!empty($youtube))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
	}
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if($size == 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
	}
	
	$return_html.= '</div>';
	
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	if($size != 'one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_header_youtube', 'ppb_header_youtube_func');


function ppb_header_vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'fontcolor' => '',
		'textalign' => 'left',
		'width' => '100',
		'padding' => 30,
		'vimeo' => '',
		'bgcolor' => '#000000',
		'opacity' => 100,
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';
	if($size != 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}

	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_header_vimeo withbg parallax" ';
	
	if(!empty($vimeo))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
	}
	
	$custom_css.= 'text-align:'.esc_attr($textalign).';padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	$custom_bgcolor_css = '';
	if(!empty($bgcolor))
	{
	    $ori_bgcolor = $bgcolor;
	    $opacity = $opacity/100;
	    $bgcolor = grandtour_hex_to_rgb($bgcolor);
	
	    $custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
	    $custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    $custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
	    
	    $return_html.= '<div class="overlay_background" style="'.esc_attr($custom_bgcolor_css).'"></div>';
	}
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if($size == 'one')
	{	
		$return_html.= '<div class="standard_wrapper">';
	}
	
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($width))
	{
		$return_html.= '<div style="margin:auto;width:'.esc_attr(rawurldecode($width)).'%">';
	}
	
	//Add title and content
	if(!empty($title))
	{
		$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
	}
	
	if(!empty($subtitle))
	{
		$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
	}
	
	if(!empty($content))
	{
		$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
	}
	
	$return_html.= '</div>';
	
	if(!empty($width))
	{
		$return_html.= '</div>';
	}
	
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	if($size != 'one')
	{
		$return_html.= '</div>';
	}

	return $return_html;

}

add_shortcode('ppb_header_vimeo', 'ppb_header_vimeo_func');


function ppb_youtube_parallax_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'slug' => '',
		'youtube' => '',
		'height' => 50,
		'display_title' => 1,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	if(!is_numeric($height))
	{
		$height = 80;
	}
	
	if($height > 100)
	{
		$height = 100;
	}
	
	$image_id = '';
	
	//Set begin wrapper div for live builder
	$return_html = grandtour_live_builder_begin_wrapper($builder_id);

	$return_html.= '<div '.$sec_id.' class="parallax" ';
	
	if(!empty($youtube))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
	}
		
	if(!empty($height))
	{
		$custom_css.= 'height:'.$height.'vh; ';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'"';
	}
	
	$return_html.= '>';
	
	$return_html.= '</div>';
	
	if(!empty($display_title))
	{
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_image_caption">'.$title.'</div>';
		}
	}

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	return $return_html;
}

add_shortcode('ppb_youtube_parallax', 'ppb_youtube_parallax_func');


function ppb_vimeo_parallax_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'slug' => '',
		'vimeo' => '',
		'height' => 50,
		'display_title' => 1,
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	if(!is_numeric($height))
	{
		$height = 80;
	}
	
	if($height > 100)
	{
		$height = 100;
	}
	
	$image_id = '';
	
	//Set begin wrapper div for live builder
	$return_html = grandtour_live_builder_begin_wrapper($builder_id);

	$return_html.= '<div '.$sec_id.' class="parallax" ';
	
	if(!empty($vimeo))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
	}
		
	if(!empty($height))
	{
		$custom_css.= 'height:'.$height.'vh; ';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'"';
	}
	
	$return_html.= '>';
	
	$return_html.= '</div>';
	
	if(!empty($display_title))
	{
		if(!empty($title))
		{
			$return_html.= '<div class="ppb_image_caption">'.$title.'</div>';
		}
	}

	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);

	return $return_html;
}

add_shortcode('ppb_vimeo_parallax', 'ppb_vimeo_parallax_func');


function ppb_content_half_youtube_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'padding' => 30,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'align' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'youtube' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_half_youtube parallax" ';
	
	if(!empty($youtube))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
	}
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		if($align == 'left')
		{
			$return_html.= '<div class="one_half_bg" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" data-stellar-ratio="1.3">';
		}
		else
		{
			$return_html.= '<div class="one_half_bg floatright" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" data-stellar-ratio="1.3">';
		}
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_half_youtube', 'ppb_content_half_youtube_func');


function ppb_content_half_vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'padding' => 30,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'align' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'vimeo' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_half_vimeo parallax" ';
	
	if(!empty($vimeo))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
	}
	
	$custom_css.= 'padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		if($align == 'left')
		{
			$return_html.= '<div class="one_half_bg" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" data-stellar-ratio="1.3">';
		}
		else
		{
			$return_html.= '<div class="one_half_bg floatright" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).'" data-stellar-ratio="1.3">';
		}
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_half_vimeo', 'ppb_content_half_vimeo_func');


function ppb_content_center_youtube_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'padding' => 30,
		'height' => 600,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'youtube' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	if(empty($height))
	{
		$height = 600;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_center_bg withbg parallax" ';
	
	if(!empty($youtube))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
	}
	
	if(!empty($height))
	{
		$custom_css.= 'height:'.intval($height).'px;';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		$return_html.= '<div class="one_third" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).';padding:'.esc_attr($padding).'px;" data-stellar-ratio="1.3">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_center_youtube', 'ppb_content_center_youtube_func');


function ppb_content_center_vimeo_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'padding' => 30,
		'height' => 600,
		'bgcolor' => '#000000',
		'opacity' => 100,
		'fontcolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'vimeo' => '',
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($bgcolor))
	{
		$bgcolor = '#ffffff';
	}
	
	if(empty($height))
	{
		$height = 600;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_content_center_bg withbg parallax" ';
	
	if(!empty($vimeo))
	{
		//Add jarallax video script
		wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
		
		$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
	}
	
	if(!empty($height))
	{
		$custom_css.= 'height:'.intval($height).'px;';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	if(!empty($title) OR !empty($subtitle) OR !empty($content))
	{
		$custom_bgcolor_css = '';
		if(!empty($bgcolor))
		{
			$ori_bgcolor = $bgcolor;
			$opacity = $opacity/100;
			$bgcolor = grandtour_hex_to_rgb($bgcolor);
		
			$custom_bgcolor_css.= 'background:'.$ori_bgcolor.';';
			$custom_bgcolor_css.= 'background:rgb('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
			$custom_bgcolor_css.= 'background:rgba('.$bgcolor['r'].','.$bgcolor['g'].','.$bgcolor['b'].','.$opacity.');';
		}
		
		$custom_css_fontcolor = '';
		$custom_css_bordercolor = '';
		if(!empty($fontcolor))
		{
			$custom_css.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
			$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
		}
	
		$return_html.= '<div class="one_third" style="'.esc_attr($custom_bgcolor_css.$custom_css_fontcolor).';padding:'.esc_attr($padding).'px;" data-stellar-ratio="1.3">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_content_center_vimeo', 'ppb_content_center_vimeo_func');


function ppb_youtube_two_third_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'height' => 500,
		'align' => 1,
		'youtube' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	if(!is_numeric($height))
	{
		$height = 500;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="ppb_image_two_third_fullwidth '.esc_attr($size).'" ';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$content_custom_css = '';
	if($align=='left')
	{
		$return_html.= '<div class="two_third_bg parallax" ';

		if(!empty($youtube))
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
		}
		
		$return_html.= ' style="height:'.esc_attr($height).'px;"></div>';
		
		$return_html.= '<div class="one_third_bg" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{	
		$return_html.= '<div class="one_third_bg textright" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
	
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html.= '<div class="two_third_bg parallax" ';

		if(!empty($youtube))
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			$return_html.= 'data-jarallax-video="'.esc_url($youtube).'" ';
		}
		
		$return_html.= ' style="height:'.esc_attr($height).'px;"></div>';
	}
	
	$return_html.= '<br class="clear"/>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_youtube_two_third_fullwidth', 'ppb_youtube_two_third_fullwidth_func');


function ppb_vimeo_two_third_fullwidth_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'title' => '',
		'subtitle' => '',
		'height' => 500,
		'align' => 1,
		'vimeo' => '',
		'bgcolor' => '',
		'fontcolor' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	if(!is_numeric($height))
	{
		$height = 500;
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="ppb_image_two_third_fullwidth '.esc_attr($size).'" ';
	if(!empty($bgcolor))
	{
		$custom_css.= 'background-color:'.esc_attr($bgcolor).';';
	}
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
	}
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
		$custom_css.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
		$custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$content_custom_css = '';
	if($align=='left')
	{
		$return_html.= '<div class="two_third_bg parallax" ';

		if(!empty($vimeo))
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
		}
		
		$return_html.= ' style="height:'.esc_attr($height).'px;"></div>';
		
		$return_html.= '<div class="one_third_bg" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
	}
	else
	{	
		$return_html.= '<div class="one_third_bg textright" style="height:'.esc_attr($height).'px;">';
		
		$return_html.= '<div class="center_wrapper"><div class="inner_content">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		//Add title and content
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
	
		$return_html.= '</div>';
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html.= '<div class="two_third_bg parallax" ';

		if(!empty($vimeo))
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			$return_html.= 'data-jarallax-video="'.esc_url($vimeo).'" ';
		}
		
		$return_html.= ' style="height:'.esc_attr($height).'px;"></div>';
	}
	
	$return_html.= '<br class="clear"/>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_vimeo_two_third_fullwidth', 'ppb_vimeo_two_third_fullwidth_func');


function ppb_card_two_cols_with_image_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'title' => '',
		'subtitle' => '',
		'slug' => '',
		'image_width' => 50,
		'image' => '',
		'align' => 1,
		'content_width' => 50,
		'padding' => 0,
		'bgcolor' => '#fff',
		'fontcolor' => '',
		'bordercolor' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'custom_css' => '',
		'builder_id' => '',
	), $atts));
	
	if(empty($align))
	{
		$align = 'left';
	}
	
	if(!is_numeric($image_width))
	{
		$image_width = 50;
	}
	if(!is_numeric($content_width))
	{
		$content_width = 50;
	}
	
	if(empty($bgcolor))
	{
		$bgcolor = '#fff';
	}
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '<div '.$sec_id.' class="'.esc_attr($size).' ppb_card_two_cols_with_image" ';
	$custom_css.= 'position:relative;padding:'.esc_attr($padding).'px 0 '.esc_attr($padding).'px 0;';
	
	$custom_css_fontcolor = '';
	$custom_css_bordercolor = '';
	if(!empty($fontcolor))
	{
	    $custom_css.= 'color:'.esc_attr($fontcolor).';';
	    $custom_css_fontcolor.= 'color:'.esc_attr($fontcolor).';';
	    $custom_css_bordercolor.= 'border-color:'.esc_attr($fontcolor).';';
	}

	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= 'style="'.esc_attr(urldecode($custom_css)).'" ';
	}
	
	//Get content block custom CSS
	$content_custom_css = 'background:'.esc_attr($bgcolor).';';
	
	if(!empty($bordercolor))
	{
	    $content_custom_css.= 'border: 1px solid '.$bordercolor.';';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper"><div class="page_content_wrapper"><div class="inner">';
	
	if($align=='left')
	{
		$return_html.= '<div class="one_half parallax_scroll_image" style="width:'.esc_attr($image_width).'%;">';
		if(!empty($image))
		{
			$return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$return_html.= '<img src="'.esc_url($image).'" alt="" class="portfolio_img"/>';
			$return_html.= '</div></div>';
		}
		$return_html.= '</div>';
		
		$return_html.= '<div class="one_half last parallax_scroll" style="width:'.esc_attr($content_width).'%;position:absolute;padding:'.esc_attr($padding).'px;'.esc_attr($content_custom_css).'" data-stellar-ratio="1.3">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
	}
	else
	{	
		$return_html.= '<div class="one_half parallax_scroll" style="width:'.esc_attr($content_width).'%;position:absolute;padding:'.esc_attr($padding).'px;z-index:2;block !important;'.esc_attr($content_custom_css).'" data-stellar-ratio="1.3">';
		
		//Add title and content
		if(!empty($title))
		{
			$return_html.= '<h2 class="ppb_title" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode(grandtour_get_first_title_word($title)).'</h2>';
		}
		
		if(!empty($subtitle))
		{
			$return_html.= '<div class="page_tagline" style="'.esc_attr($custom_css_fontcolor).'">'.rawurldecode($subtitle).'</div>';
		}
		
		if(!empty($content))
		{
			$return_html.= '<div class="ppb_header_content">'.do_shortcode(grandtour_apply_content($content)).'</div>';
		}
		$return_html.= '</div>';
		
		$return_html.= '<div class="one_half parallax_scroll_image last" style="width:'.$image_width.'%;">';
		if(!empty($image))
		{
			$return_html.= '<div class="image_classic_frame expand"><div class="image_wrapper">';
			$return_html.= '<img src="'.esc_url($image).'" alt="" class="portfolio_img"/>';
			$return_html.= '</div></div>';
		}
		$return_html.= '</div>';
	}
	
	$return_html.= '<br class="clear"/></div>';
	$return_html.= '</div>';
	$return_html.= '</div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;
}

add_shortcode('ppb_card_two_cols_with_image', 'ppb_card_two_cols_with_image_func');


function ppb_revslider_func($atts, $content) {
	
    //extract short code attr
    extract(shortcode_atts(array(
    	'size' => 'one',
    	'slug' => '',
    	'slider_id' => '',
    	'display' => '',
    	'builder_id' => '',
    ), $atts));
    
    $sec_id = '';
    if(!empty($slug))
    {
    	$sec_id = 'id="'.esc_attr($slug).'"';
    }

    $return_html = '<div '.$sec_id.' class="'.esc_attr($size).' fullwidth ';
    
    if($display == 'force')
    {
    	$return_html.= 'slideronly';
    }
    
    $return_html.= '">';
    
    //Set begin wrapper div for live builder
    $return_html.= grandtour_live_builder_begin_wrapper($builder_id);
    
    $return_html.= do_shortcode('[rev_slider '.$slider_id.']');
    
    //Set end wrapper div for live builder
    $return_html.= grandtour_live_builder_end_wrapper($builder_id);
    
    $return_html.= '</div>';

    return $return_html;

}

add_shortcode('ppb_revslider', 'ppb_revslider_func');
?>
