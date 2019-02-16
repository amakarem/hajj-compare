<?php

/**
 * The PHP code for setup Theme page custom fields.
 */

function grandtour_page_create_meta_box() {

	$grandtour_page_postmetas = grandtour_get_page_postmetas();
	
	if ( function_exists('add_meta_box') && isset($grandtour_page_postmetas) && count($grandtour_page_postmetas) > 0 ) {  
		add_meta_box( 'page_metabox', 'Page Options', 'grandtour_page_new_meta_box', 'page', 'normal', 'default' );  
	}

}  

function grandtour_page_new_meta_box() {
	$post = grandtour_get_wp_post();
	$grandtour_page_postmetas = grandtour_get_page_postmetas();
	
	//Get page template sample URL
	$page_template_url = array (
	  'Default Template' 						=> grandtour_get_demo_url('/pages/page-fullwidth/'),
	  'Blog Fullwidth' 							=> grandtour_get_demo_url('/blog/blog-fullwidth/'),
	  'Blog Full + Grid Fullwidth' 				=> grandtour_get_demo_url('/blog/blog-full-post-grid-fullwidth/'),
	  'Blog Full + Grid Left Sidebar' 			=> grandtour_get_demo_url('/blog/blog-full-post-grid-left-sidebar/'),
	  'Blog Full + Grid Right Sidebar' 			=> grandtour_get_demo_url('/blog/blog-full-post-grid-right-sidebar/'),
	  'Blog Grid Fullwidth' 					=> grandtour_get_demo_url('/blog/blog-grid-fullwidth/'),
	  'Blog Grid Left Sidebar' 					=> grandtour_get_demo_url('/blog/blog-grid-left-sidebar/'),
	  'Blog Grid Right Sidebar' 				=> grandtour_get_demo_url('/blog/blog-grid-right-sidebar/'),
	  'Blog Left Sidebar' 						=> grandtour_get_demo_url('/blog/blog-left-sidebar/'),
	  'Blog Right Sidebar' 						=> grandtour_get_demo_url('/blog/blog-right-sidebar/'),
	  'Tour 2 Columns Classic' 					=> grandtour_get_demo_url('/tour/tour-2-columns-classic/'),
	  'Tour 3 Columns Classic' 					=> grandtour_get_demo_url('/tour/tour-3-columns-classic/'),
	  'Tour 4 Columns Classic' 					=> grandtour_get_demo_url('/tour/tour-4-columns-classic/'),
	  'Tour Classic Right Sidebar' 				=> grandtour_get_demo_url('/tour/tour-classic-right-sidebar/'),
	  'Tour Classic Left Sidebar' 				=> grandtour_get_demo_url('/tour/tour-classic-left-sidebar/'),
	  'Tour 2 Columns Grid' 					=> grandtour_get_demo_url('/tour/tour-2-columns-grid/'),
	  'Tour 3 Columns Grid' 					=> grandtour_get_demo_url('/tour/tour-3-columns-grid/'),
	  'Tour 4 Columns Grid' 					=> grandtour_get_demo_url('/tour/tour-4-columns-grid/'),
	  'Tour Grid Right Sidebar' 				=> grandtour_get_demo_url('/tour/tour-grid-right-sidebar/'),
	  'Tour Grid Left Sidebar' 					=> grandtour_get_demo_url('/tour/tour-grid-left-sidebar/'),
	  'Tour List Right Sidebar' 				=> grandtour_get_demo_url('/tour/tour-list-right-sidebar/'),
	  'Tour List Left Sidebar' 					=> grandtour_get_demo_url('/tour/tour-list-left-sidebar/'),
	  'Destination Fullwidth' 					=> grandtour_get_demo_url('/destination-fullwidth/'),
	  'Destination Right Sidebar' 				=> grandtour_get_demo_url('/destination-right-sidebar/'),
	  'Destination Left Sidebar' 				=> grandtour_get_demo_url('/destination-left-sidebar/'),

	  'Page Left Sidebar' 						=> grandtour_get_demo_url('/pages/page-left-sidebar/'),
	  'Page Right Sidebar' 						=> grandtour_get_demo_url('/pages/page-right-sidebar/'),
	);

	echo '<input type="hidden" name="pp_meta_form" id="pp_meta_form" value="' . wp_create_nonce('grandtour_once') . '" />';
	
	$meta_section = '';
	$key = 0;
	foreach ( $grandtour_page_postmetas as $key => $postmeta ) {

		$meta_id = $postmeta['id'];
		$meta_title = $postmeta['title'];
		$meta_description = $postmeta['description'];
		$meta_section = $postmeta['section'];
		
		$meta_type = '';
		if(isset($postmeta['type']))
		{
			$meta_type = $postmeta['type'];
		}
		
		echo '<div id="page_option_'.strtolower($postmeta['id']).'" class="pp_meta_option page key'.intval($key+1).' '.$meta_type.'">';
		echo "<div class=\"meta_title_wrapper\">";
		echo "<strong>".$meta_title."</strong>";
		
		echo "<div class='pp_widget_description'>$meta_description</div>";
		
		echo "</div>";
		echo "<div class=\"meta_title_field\">";

		if ($meta_type == 'checkbox') {
			$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
			echo "<input type='checkbox' name='$meta_id' id='$meta_id' class='iphone_checkboxes' value='1' $checked />";
		}
		else if ($meta_type == 'select') {
			echo "<select name='$meta_id' id='$meta_id'>";
			
			if(!empty($postmeta['items']))
			{
				foreach ($postmeta['items'] as $key => $item)
				{
					$page_style = get_post_meta($post->ID, $meta_id);
				
					if(isset($page_style[0]) && $key == $page_style[0])
					{
						$css_string = 'selected';
					}
					else
					{
						$css_string = '';
					}
				
					echo '<option value="'.$key.'" '.$css_string.'>'.$item.'</option>';
				}
			}
			
			echo "</select>";
		}
		else if ($meta_type == 'template') {
		    $current_value = get_post_meta($post->ID, $meta_id, true);
		    
		    echo "<input type='hidden' name='$meta_id' id='$meta_id' value='$current_value' />";
		    echo "<ul name=\"".$meta_id."_list\" id=\"".$meta_id."_list\" class=\"meta_template_list\">";
		    
		    echo '<li data-parent="'.$meta_id.'" data-value="Default Template" data-type="page" ';
		    
		    if($current_value == 'Default Template')
		    {
		        echo 'class="checked"';
		    }
		    
		    echo '>';
		    
		    echo '<a href="'.esc_url($page_template_url['Default Template']).'" target="_blank" title="View Sample" class="tooltipster meta_template_link"><i class="fa fa-external-link"></i></a>';
		    echo '<div class="template_title">Default Template</div>';
		    echo '</li>';
		    
		    if(!empty($postmeta['items']))
		    {
		    	foreach ($postmeta['items'] as $key => $image_thumb)
		    	{
		    		if(array_key_exists($key, $page_template_url))
		    		{
			    		echo '<li data-parent="'.$meta_id.'" data-value="'.esc_attr($key).'" data-type="page" ';
			    		
			    		if($key == $current_value)
			    		{
			    			echo 'class="checked"';
			    		}
			    		
			    		echo '>';
			    		
			    		if(isset($page_template_url[$key]))
						{
						    echo '<a href="'.esc_url($page_template_url[$key]).'" target="_blank" title="View Sample" class="tooltipster meta_template_link"><i class="fa fa-external-link"></i></a>';
						}
			    		echo '<div class="template_title">'.$key.'</div>';
			    		echo '</li>';
			    	}
		    	}
		    }
		    
		    echo "</ul>";
		}
		else if ($meta_type == 'file') { 
		    echo "<input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:calc(100% - 75px)' /><input id='".$meta_id."_button' name='".$meta_id."_button' type='button' value='Upload' class='metabox_upload_btn button' readonly='readonly' rel='".$meta_id."' style='margin:0 0 0 5px' />";
		}
		else if ($meta_type == 'textarea') { 
			echo "<textarea name='$meta_id' id='$meta_id' class='' style='width:100%' rows='7'>".get_post_meta($post->ID, $meta_id, true)."</textarea>";
		}
		else {
			echo "<input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:100%' />";
		}
		
		echo '</div>';
		echo '</div>';
	}

}

function grandtour_page_save_postdata( $post_id ) {

	$grandtour_page_postmetas = grandtour_get_page_postmetas();

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['pp_meta_form']) && !wp_verify_nonce( $_POST['pp_meta_form'], 'grandtour_once' )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}
	
	if (isset($_POST['pp_meta_form'])) 
	{
		//If import page content builder
		if(is_admin() && isset($_POST['ppb_import_current']) && !empty($_POST['ppb_import_current']))
		{
			//If upload import builder file
			if(isset($_FILES['ppb_import_current_file']['name']) && !empty($_FILES['ppb_import_current_file']['name']))
			{
				//Check if zip file
				$import_filename = $_FILES['ppb_import_current_file']['name'];
				$import_type = $_FILES['ppb_import_current_file']['type'];
				$is_zip = FALSE;
				$new_filename = basename($import_filename, '_.zip');
				
				$accepted_types = array('application/zip', 
	                                'application/x-zip-compressed', 
	                                'multipart/x-zip', 
	                                'application/s-compressed');
	 
			    foreach($accepted_types as $mime_type) {
			        if($mime_type == $import_type) {
			            $is_zip = TRUE;
			            break;
			        } 
			    }
			}
			//If import demo pages
			else if(isset($_POST['ppb_import_demo_file']) && !empty($_POST['ppb_import_demo_file']))
			{
				$is_zip = FALSE;
			}
			//If import from saved template
			else if(isset($_POST['ppb_import_template_key']) && !empty($_POST['ppb_import_template_key']))
			{
				$is_zip = FALSE;
			} 
			
			WP_Filesystem();
			
			if($is_zip)
			{
				$upload_dir = wp_upload_dir();
				$cache_dir = '';
				
				if(isset($upload_dir['basedir']))
				{
					$cache_dir = $upload_dir['basedir'].'/meteors';
				}
				
				move_uploaded_file($_FILES["ppb_import_current_file"]["tmp_name"], $cache_dir.'/'.$import_filename);
				//$unzipfile = unzip_file( $cache_dir.'/'.$import_filename, $cache_dir);
				
				$zip = new ZipArchive();
				$x = $zip->open($cache_dir.'/'.$import_filename);
				
				for($i = 0; $i < $zip->numFiles; $i++) {
			        $new_filename = $zip->getNameIndex($i);
			        break;
			    }  
				
				if ($x === true) {
					$zip->extractTo($cache_dir); 
					$zip->close();
				}

				$wp_filesystem = grandtour_get_wp_filesystem();
				$import_options_json = $wp_filesystem->get_contents($cache_dir.'/'.$new_filename);
				
				unlink($cache_dir.'/'.$import_filename);
				unlink($cache_dir.'/'.$new_filename);
			}
			else
			{
				$wp_filesystem = grandtour_get_wp_filesystem();
			
				//If import demo pages
				if(isset($_POST['ppb_import_demo_file']) && !empty($_POST['ppb_import_demo_file']))
				{
					$import_options_json = $wp_filesystem->get_contents(get_template_directory().'/cache/demos/pages/'.$_POST['ppb_import_demo_file']);
				}
				//If import from saved template
				else if(isset($_POST['ppb_import_template_key']) && !empty($_POST['ppb_import_template_key']))
				{
					$import_options_json = get_option( GRANDTOUR_SHORTNAME."_template_".$_POST['ppb_import_template_key']);
				}
				//If upload import builder file
				else
				{
					//If .json file then import
					$import_options_json = $wp_filesystem->get_contents($_FILES["ppb_import_current_file"]["tmp_name"]);
				}
			}
			
			//Decode JSON content
			$import_options_arr = json_decode($import_options_json, true);
			
			if(isset($import_options_arr['ppb_form_data_order'][0]) && !empty($import_options_arr['ppb_form_data_order'][0]))
			{
				grandtour_page_update_custom_meta($post_id, $import_options_arr['ppb_form_data_order'][0], 'ppb_form_data_order');
			}
			
			$ppb_item_arr = explode(',', $import_options_arr['ppb_form_data_order'][0]);
			
			if(is_array($ppb_item_arr) && !empty($ppb_item_arr))
			{
				foreach($ppb_item_arr as $key => $ppb_item_arr)
				{
					if(isset($import_options_arr[$ppb_item_arr.'_data'][0]) && !empty($import_options_arr[$ppb_item_arr.'_data'][0]))
					{
						grandtour_page_update_custom_meta($post_id, $import_options_arr[$ppb_item_arr.'_data'][0], $ppb_item_arr.'_data');
					}
					
					if(isset($import_options_arr[$ppb_item_arr.'_size'][0]) && !empty($import_options_arr[$ppb_item_arr.'_size'][0]))
					{
						grandtour_page_update_custom_meta($post_id, $import_options_arr[$ppb_item_arr.'_size'][0], $ppb_item_arr.'_size');
					}
				}
			}
			
			$refresh_url = '';
			if(isset($_POST['ppb_edit_mode']) && $_POST['ppb_edit_mode'] == 'live')
			{
				$refresh_url.= '&ppb_mode=live';
			}
			
			header("Location: ".$_SERVER['HTTP_REFERER'].$refresh_url);
			exit;
		}
	
		//If export page content builder
		if(is_admin() && isset($_POST['ppb_export_current']) && !empty($_POST['ppb_export_current']))
		{
			$json_file_name = $post_id;
	
			header('Content-disposition: attachment; filename='.$json_file_name.'.json');
			header('Content-type: application/json');
			
			//Get current content builder data
			$ppb_form_data_order = get_post_meta($post_id, 'ppb_form_data_order');
			$export_options_arr = array();
			
			if(!empty($ppb_form_data_order))
			{
				$export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

				//Get each builder module data
				$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
			
				foreach($ppb_form_item_arr as $key => $ppb_form_item)
				{
					$ppb_form_item_data = get_post_meta($post_id, $ppb_form_item.'_data');
					$export_options_arr[$ppb_form_item.'_data'] = $ppb_form_item_data;
					
					$ppb_form_item_size = get_post_meta($post_id, $ppb_form_item.'_size');
					$export_options_arr[$ppb_form_item.'_size'] = $ppb_form_item_size;
				}
			}
		
			echo json_encode($export_options_arr);
			
			exit;
		}
	
		foreach ( $grandtour_page_postmetas as $postmeta ) 
		{
		
			if (isset($_POST[$postmeta['id']]) && $_POST[$postmeta['id']]) {
				grandtour_page_update_custom_meta($post_id, $_POST[$postmeta['id']], $postmeta['id']);
			}
	
			if (isset($_POST[$postmeta['id']]) && $_POST[$postmeta['id']] == "") {
				delete_post_meta($post_id, $postmeta['id']);
			}
			
			if (!isset($_POST[$postmeta['id']])) {
				delete_post_meta($post_id, $postmeta['id']);
			}
		}
		
		// Saving Page Builder Data
		if(isset($_POST['ppb_enable']) && !empty($_POST['ppb_enable']))
		{
			grandtour_page_update_custom_meta($post_id, $_POST['ppb_enable'], 'ppb_enable');
		}
		else
		{
			delete_post_meta($post_id, 'ppb_enable');
		}

		if(isset($_POST['ppb_form_data_order']) && !empty($_POST['ppb_form_data_order']))
		{
			grandtour_page_update_custom_meta($post_id, $_POST['ppb_form_data_order'], 'ppb_form_data_order');
			
			$ppb_item_arr = explode(',', $_POST['ppb_form_data_order']);
			if(is_array($ppb_item_arr) && !empty($ppb_item_arr))
			{
				foreach($ppb_item_arr as $key => $ppb_item_arr)
				{
					if(isset($_POST[$ppb_item_arr.'_data']) && !empty($_POST[$ppb_item_arr.'_data']))
					{
						grandtour_page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_data'], $ppb_item_arr.'_data');
					}
					
					if(isset($_POST[$ppb_item_arr.'_size']) && !empty($_POST[$ppb_item_arr.'_size']))
					{
						grandtour_page_update_custom_meta($post_id, $_POST[$ppb_item_arr.'_size'], $ppb_item_arr.'_size');
					}
				}
			}
		}
		//If content builder is empty
		else if(isset($_POST['ppb_remove_all']) && !empty($_POST['ppb_remove_all']))
		{
			grandtour_page_update_custom_meta($post_id, '', 'ppb_form_data_order');
		}
	}
	
	//If enable Content Builder then also copy its content to standard page content
	if (isset($_POST['ppb_enable']) && !empty($_POST['ppb_enable']) && ! wp_is_post_revision( $post_id ) )
	{
		//unhook this function so it doesn't loop infinitely
		remove_action('save_post', 'grandtour_page_save_postdata');
	
		//update the post, which calls save_post again
		$ppb_page_content = grandtour_apply_builder($post_id, 'page', FALSE);
		
		$current_post = array (
	      'ID'           => $post_id,
	      'post_content' => $ppb_page_content,
	    );
	    
	    wp_update_post($current_post);
	    if (is_wp_error($post_id)) {
			$errors = $post_id->get_error_messages();
			foreach ($errors as $error) {
				echo esc_html($error);
			}
		}

		//re-hook this function
		add_action('save_post', 'grandtour_page_save_postdata');
	}

}

function grandtour_page_update_custom_meta($postID, $newvalue, $field_name) {

	if (isset($_POST['pp_meta_form'])) 
	{
		if (!get_post_meta($postID, $field_name)) {
			add_post_meta($postID, $field_name, $newvalue);
		} else {
			update_post_meta($postID, $field_name, $newvalue);
		}
	}

}

//init

add_action('admin_menu', 'grandtour_page_create_meta_box'); 
add_action('save_post', 'grandtour_page_save_postdata');  

/*
	End creating custom fields
*/

?>
