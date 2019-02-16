<?php

//Setup visual editor for content builder
require_once get_template_directory() . '/modules/js-wp-editor.php' ;

function grandtour_content_create_meta_box() {

	$grandtour_page_postmetas = grandtour_get_page_postmetas();
	
	if ( function_exists('add_meta_box') && isset($grandtour_page_postmetas) && count($grandtour_page_postmetas) > 0 ) {  
		add_meta_box( 'content_metabox', 'Content Builder Option', 'grandtour_content_new_meta_box', 'page', 'normal', 'high' );
		add_meta_box( 'content_metabox', 'Content Builder Option', 'grandtour_content_new_meta_box', 'portfolios', 'normal', 'high' );
	}

} 

function grandtour_content_new_meta_box() {
	$grandtour_page_postmetas = grandtour_get_page_postmetas();
	$post = grandtour_get_wp_post();
	
	require_once get_template_directory() . "/lib/contentbuilder.shortcode.lib.php";
	
	$ppb_enable = get_post_meta($post->ID, 'ppb_enable');
?>

	<input type="hidden" name="ppb_enable" id="ppb_enable" <?php if(!empty($ppb_enable)) { ?>value="1"<?php } else { ?>value="0"<?php } ?> />
	
	<?php if(!empty($ppb_enable)) { ?>
	<div class="fancybox-overlay"></div>
	
	<script>
		jQuery(document).ready(function(){
			jQuery('#postdivrich').hide();
			jQuery('#preview-action').hide();
			jQuery('#page_option_page_custom_template').hide();
			jQuery('#page_template').val('default');
	      	jQuery('#page_template').attr('disabled','disabled');
	      	jQuery('#content_metabox').addClass('visible');
	      	
	      	hideLoading();
		});
	</script>
	<?php } ?>
	
	<input type="hidden" name="ppb_post_type" id="ppb_post_type" value="page"/>
	<input type="hidden" name="ppb_page_id" id="ppb_page_id" value="<?php echo esc_attr($post->ID); ?>"/>
	<input type="hidden" name="ppb_options" id="ppb_options" value=""/>
	<input type="hidden" name="ppb_options_title" id="ppb_options_title" value=""/>
	<input type="hidden" name="ppb_options_unsaved" id="ppb_options_unsaved" value=""/>
	<input type="hidden" name="ppb_remove_all" id="ppb_remove_all" value=""/>
	
	<?php
		$ppb_edit_mode = 'classic';
		
		//Check default edit mode
		if(isset($_GET['ppb_live']))
		{
			$ppb_edit_mode = 'live';
		}
	?>
	<input type="hidden" name="ppb_edit_mode" id="ppb_edit_mode" value="<?php echo esc_attr($ppb_edit_mode); ?>"/>
	
	<div id="ppb_page_content">
		<div class="ppb_page_title_bar">
			<div class="ppb_page_title">
				<a id="ppb_open_dev_bar" title="<?php esc_html_e('Open Developer View', 'grandtour' ); ?>"><span class="dashicons dashicons-list-view"></span></a>
				
				<a id="ppb_open_templates" href="#ppb_template" class="pp_fancybox_inline"><?php esc_html_e('Templates', 'grandtour' ); ?></a>
				
				<a id="ppb_preview_page" data-action="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_preview_page_set_data')); ?>" data-preview="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_preview_page&ppb_post_type=page&page_id='.$post->ID)); ?>" data-page="<?php echo esc_attr($post->ID); ?>"><?php esc_html_e('Preview', 'grandtour' ); ?></a>
				
				<div id="ppb_preview_devices">
					<a id="ppb_desktop" class="ppb_device active" href="javascript:;" data-preview="ppb_preview_desktop"><span class="dashicons dashicons-desktop"></span></a>
					
					<a id="ppb_tablet" class="ppb_device" href="javascript:;" data-preview="ppb_preview_tablet"><span class="dashicons dashicons-tablet"></span></a>
					
					<a id="ppb_mobile" class="ppb_device" href="javascript:;" data-preview="ppb_preview_mobile"><span class="dashicons dashicons-smartphone"></span></a>
				</div>
				
			</div>
			<div class="ppb_page_action">
				<a id="ppb_undo" title="<?php esc_html_e('Undo', 'grandtour' ); ?>"><span class="dashicons dashicons-undo"></span></a>
				
				<a id="ppb_redo" title="<?php esc_html_e('Redo', 'grandtour' ); ?>"><span class="dashicons dashicons-redo"></span></a>
			
				<a id="ppb_page_unsaved" class="tooltipster" title="<?php echo esc_html__('Unsaved Page Content.', 'grandtour' ); ?>"><span class="dashicons dashicons-info"></span></a>
			
				<a id="ppb_live" title="<?php esc_html_e('Live View', 'grandtour' ); ?>"><span class="dashicons dashicons-desktop"></span></a>
				
				<a id="ppb_classic" title="<?php esc_html_e('Classic View', 'grandtour' ); ?>"><span class="dashicons dashicons-editor-insertmore"></span></span></a>
				
				<a id="ppb_refresh" title="<?php esc_html_e('Refresh', 'grandconference' ); ?>"><span class="dashicons dashicons-image-rotate"></span></a>
				
				<a id="ppb_add" title="<?php esc_html_e('Add Content', 'grandtour' ); ?>"><span class="dashicons dashicons-plus"></span></a>
				
				<a id="ppb_save" title="<?php esc_html_e('Saved', 'grandtour' ); ?>" data-saved-title="<?php esc_html_e('Saved', 'grandtour' ); ?>" data-save-title="<?php esc_html_e('Save Changes', 'grandtour' ); ?>" href="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_save_page_builder&page_id='.$post->ID)); ?>" class="inactive"><span class="dashicons dashicons-download"></span><span class="ppb_live_button_title"><?php esc_html_e('Saved', 'grandtour' ); ?></span></a>
				
				<a href="<?php echo GRANDTOUR_BUILDERDOCURL; ?>" target="_blank" id="ppb_help" title="<?php esc_html_e('Content Builder Documentation', 'grandtour' ); ?>"><span class="dashicons dashicons-editor-help"></span></a>
			</div>
		</div>
		<br class="clear"/>

	<?php
		//Display add new content lightbox
		require_once get_template_directory() . "/modules/content_builder/add_content.php";
		
		//Display save template lightbox
		require_once get_template_directory() . "/modules/content_builder/template.php";
	?>
		
	<input type="hidden" id="ppb_inline_current" name="ppb_inline_current" value=""/>
	<input type="hidden" id="ppb_form_data_order" name="ppb_form_data_order" value=""/>
	
	<?php
	    //Get builder item
	    $ppb_form_data_order = get_post_meta($post->ID, 'ppb_form_data_order');
	    $ppb_form_item_arr = array();
	    
	    if(isset($ppb_form_data_order[0]))
	    {
	    	$ppb_form_item_arr = explode(',', $ppb_form_data_order[0]);
	    }
	?>
	
	<!-- Begin classic content builder wrapper -->
	<div id="content_builder_classic_wrapper">
	
	<div id="ppb_page_title_header">
		<div class="ppb_page_title_wrapper">
			<div class="ppb_page_sub_title"><?php esc_html_e('You are editing', 'grandtour' ); ?></div>
			<h3><?php echo get_the_title($post->ID); ?></h3>
		</div>
		<div class="ppb_page_title_expand">
			<span class="dashicons dashicons-arrow-down-alt2"></span>
		</div>
		
		<div id="ppb_page_option_wrapper">
			<ul>
				<li>
					<?php
						//Get Page Menu Transparent Option
						$page_menu_transparent = get_post_meta($post->ID, 'page_menu_transparent', true);
					?>
					<input type="checkbox" name="ppb_page_menu_transparent" id="ppb_page_menu_transparent" class='iphone_checkboxes' <?php if(!empty($page_menu_transparent)) { ?>checked<?php } ?> data-action="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_save_page_custom_field&page_id='.$post->ID)); ?>" /><label for="ppb_page_menu_transparent" class="ppb_page_option_label">Make Menu Transparent</label>
					
					<a href="javascript:;" title="Check this option if you want to display menu in transparent" class="tooltipster"><span class="dashicons dashicons-editor-help"></span></a>
				</li>
				<li>
					<?php
						//Get Page Menu Transparent Option
						$page_show_title = get_post_meta($post->ID, 'page_show_title', true);
					?>
					<input type="checkbox" name="ppb_page_show_title" id="ppb_page_show_title" class='iphone_checkboxes'  <?php if(!empty($page_show_title)) { ?>checked<?php } ?> data-action="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_save_page_custom_field&page_id='.$post->ID)); ?>" /><label for="ppb_page_show_title" class="ppb_page_option_label">Hide Default Page Header</label>
					
					<a href="javascript:;" class="tooltipster" title="Check this option if you want to hide default page header"><span class="dashicons dashicons-editor-help"></span></a>
				</li>
			</ul>
		</div>
	</div>
	
	<ul id="content_builder_sort" class="ppb_sortable <?php if(!isset($ppb_form_item_arr[0]) OR empty($ppb_form_item_arr[0])) { ?>empty<?php } ?>" rel="content_builder_sort_data"> 
	<?php
	    //Count modules in content builder
	    $count_ppb = 0;

	    if(isset($ppb_form_data_order[0]) && !empty($ppb_form_data_order[0]) && is_array($ppb_form_data_order[0]))
	    {
	    	$count_ppb = count($ppb_form_data_order[0]);
	    }
	    
	    if(isset($ppb_form_item_arr[0]) && !empty($ppb_form_item_arr[0]))
	    {
	    	foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    	{
	    		$ppb_form_item_data = get_post_meta($post->ID, $ppb_form_item.'_data');
	    		$ppb_form_item_size = get_post_meta($post->ID, $ppb_form_item.'_size');
	    		$ppb_form_item_data_obj = json_decode($ppb_form_item_data[0]);
	    	
	    		if(isset($ppb_form_item[0]) && isset($ppb_shortcodes[$ppb_form_item_data_obj->shortcode]))
	    		{
	    			$ppb_shortocde_title = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode]['title'];
	    			$ppb_shortocde_icon = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode]['icon'];
	    			
	    			if($ppb_form_item_data_obj->shortcode!='ppb_divider')
	    			{
	    				$obj_title_name = $ppb_form_item_data_obj->shortcode.'_title';
	    				
	    				if(property_exists($ppb_form_item_data_obj, $obj_title_name))
	    				{
	    					$obj_title_name = $ppb_form_item_data_obj->$obj_title_name;
	    				}
	    				else
	    				{
	    					$obj_title_name = '';
	    				}
	    			}
	    			else
	    			{
	    				$obj_title_name = '<div class="shortcode_title">Paragraph Break</div>';
	    				$ppb_shortocde_title = '';
	    			}
	    			
	    			//shortcode icon
	    			$ppb_shortcode_icon = get_template_directory_uri().'/functions/images/builder/'.esc_attr($ppb_shortocde_icon);
	?>
	    	<li id="<?php echo esc_attr($ppb_form_item); ?>" class="ui-state-default <?php echo esc_attr($ppb_form_item_size[0]); ?> <?php echo esc_attr($ppb_form_item_data_obj->shortcode); ?>" data-current-size="<?php echo esc_attr($ppb_form_item_size[0]); ?>" data-shortcode="<?php echo esc_attr($ppb_shortocde_title); ?>" data-icon="<?php echo esc_url($ppb_shortcode_icon); ?>">
	    		<div class="size">
	    			<a href="javascript:;" title="<?php esc_html_e('Increase Size', 'grandtour' ); ?>" class="ppb_plus button">+</a>
	    			<a href="javascript:;" title="<?php esc_html_e('Decrease Size', 'grandtour' ); ?>" class="ppb_minus button">-</a>
	    		</div>
	    		<div class="thumb"><img src="<?php echo get_template_directory_uri(); ?>/functions/images/builder/<?php echo esc_attr($ppb_shortocde_icon); ?>" alt=""/></div>
	    		<div class="title"><div class="shortcode_title"><?php echo esc_html($ppb_shortocde_title); ?></div><?php echo rawurldecode($obj_title_name); ?></div>
	    		
	    		<div class="item_action">
	    			<a href="javascript:;" class="ppb_remove" title="<?php esc_html_e('Remove', 'grandtour' ); ?>"><i class="fa fa-trash"></i></a>
					
					<a href="javascript:;" class="ppb_duplicate" title="<?php esc_html_e('Duplicate', 'grandtour' ); ?>"><i class="fa fa-copy"></i></a>
					
					<a data-rel="<?php echo esc_attr($ppb_form_item); ?>" href="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb&ppb_post_type=page&shortcode='.$ppb_form_item_data_obj->shortcode.'&rel='.$ppb_form_item.'&width=800&height=900&page_id='.$post->ID)); ?>" class="ppb_edit" title="<?php esc_html_e('Edit', 'grandtour' ); ?>"><i class="fa fa-edit"></i></a>
					
					<a data-rel="<?php echo esc_attr($ppb_form_item); ?>" href="javascript:;" class="ppb_add_after" title="<?php esc_html_e('Add Content After This', 'grandtour' ); ?>"><i class="fa fa-plus"></i></a>
	    		</div>
	    		<input type="hidden" class="ppb_setting_columns" value="<?php echo esc_attr($ppb_form_item_size[0]); ?>"/>
	    	</li>
	<?php
	    		}
	    	}
	    }
	?>
	
	</ul>
	
	<input type="hidden" id="ppb_save_current_template" name="ppb_save_current_template"/>
	
	<!-- Begin add content area -->
	<div id="ppb_add_content_wrapper" <?php if(!empty($count_ppb)) { ?>class="not_started"<?php } ?>>
	    <?php
	    	//If content is empty display get started instruction
	    	if(empty($count_ppb))
	    	{
	    ?>
	    <div id="ppb_add_content_wrapper_started">
	    	<h2><?php esc_html_e('Get started', 'grandtour' ); ?></h2>
	    	<div class="ppb_tagline"><?php esc_html_e('Currently you have no content. Start adding content by clicking button below', 'grandtour' ); ?></div>
	    </div>
	    <?php
	    	}
	    ?>
	    
	    <a id="ppb_sortable_add_button" href="#ppb_tab" class="pp_fancybox_inline_fullheight" data-after=""!><i class="fa fa-plus-circle"></i><?php esc_html_e('Add Content', 'grandtour' ); ?></a>
	    
	    <?php
	    	//If content is empty display get started instruction
	    	if(empty($count_ppb))
	    	{
	    ?>
	    <a id="ppb_sortable_template_button" href="#ppb_template" class="pp_fancybox_inline"><i class="fa fa-cloud-download"></i><?php esc_html_e('Import Template', 'grandtour' ); ?></a>
	    <?php
	    	}
	    ?>
	</div>
	<!-- End add content area -->
	
	<!-- Begin live footer buttons area -->
	<div id="ppb_live_footer_wrapper">
		
	</div>
	<!-- End live footer buttons area -->
	
	<div id="ppb_import_tab">
	    <ul>
	    	<li><a href="#tabs-import"><?php esc_html_e('Import', 'grandtour' ); ?></a></li>
	    	<li><a href="#tabs-export"><?php esc_html_e('Export', 'grandtour' ); ?></a></li>
	    </ul>
	    
	    <div id="tabs-import">
	    	<strong><?php esc_html_e('Import Page Content Builder', 'grandtour' ); ?></strong>
	    	<div class="pp_widget_description"><?php esc_html_e('Choose the import file. *Note: Your current content builder content will be overwritten by imported data', 'grandtour' ); ?></div><br/>
	    	
	    	<input type="file" id="ppb_import_current_file" name="ppb_import_current_file" value="0" size="25"/>
	    	<input type="hidden" id="ppb_import_demo_file" name="ppb_import_demo_file"/>
	    	<input type="hidden" id="ppb_import_template_key" name="ppb_import_template_key"/>
	    	<input type="hidden" id="ppb_import_current" name="ppb_import_current"/>
	    	<input type="submit" id="ppb_import_current_button" class="button" value="Import"/>
	    </div>
	    
	    <div id="tabs-export">
	    	<strong><?php esc_html_e('Export Current Page Content Builder', 'grandtour' ); ?></strong>
	    	<div class="pp_widget_description"><?php esc_html_e('Click to export current content builder data. *Note: Please make sure you save all changes and no "unsaved" module', 'grandtour' ); ?></div><br/>
	    	
	    	<input type="hidden" id="ppb_export_current" name="ppb_export_current"/>
	    	<input type="submit" id="ppb_export_current_button" name="ppb_export_current_button" class="button" value="Export"/>
	    </div>
	</div>
	
	<script type="text/javascript">
	jQuery(document).ready(function(){
	<?php
	    foreach($ppb_form_item_arr as $key => $ppb_form_item)
	    {
	    	if(!empty($ppb_form_item))
	    	{
	    		$ppb_form_item_data = get_post_meta($post->ID, $ppb_form_item.'_data');
	?>
	    		jQuery('#<?php echo esc_js($ppb_form_item); ?>').data('ppb_setting', '<?php echo addslashes($ppb_form_item_data[0]); ?>');
	<?php
	    	}
	    }
	?>
	    	jQuery(window).bind('beforeunload', function(){
	    		if(jQuery('#ppb_options_unsaved').val()==1)
	    		{
	    	    	return '<?php esc_html_e('There are unsaved content builder settings', 'grandtour' ); ?>';
	    	    }
	    	});
	});
	
	jQuery(window).load(function(){
	<?php
	    //Check default edit mode
	    if(isset($_GET['ppb_mode']))
	    {
	?>
	jQuery('#ppb_live').trigger('click');
	<?php
	    }
	?>
	});
	</script>
	
	</div>
	<!-- End classic content builder wrapper -->
	
	<!-- Begin live preview frame -->
	<?php
		//get preview URL
		$preview_url = get_permalink($post->ID);
		$url_parts = parse_url($preview_url, PHP_URL_QUERY);
		
		// Returns a string if the URL has parameters or NULL if not
		if ($url_parts) {
		    $preview_url.= '&ppb_preview_page=true&ppb_live=true';
		} else {
		    $preview_url.= '?ppb_preview_page=true&ppb_live=true';
		}
	?>
	<div id="ppb_live_preview_frame_wrapper" rel="ppb_preview_desktop">
		<iframe id="ppb_live_preview_frame" data-action="<?php echo esc_url(admin_url('admin-ajax.php?action=grandtour_ppb_preview_page_set_data')); ?>" data-preview="<?php echo esc_url($preview_url); ?>"></iframe>
	</div>
	<!-- End live preview frame -->
	
	</div>
<?php

}

//init

add_action('admin_menu', 'grandtour_content_create_meta_box'); 
?>
