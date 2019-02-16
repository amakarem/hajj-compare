<?php
	//Find all tabs
    $ppb_tabs = array();
    
    foreach($ppb_shortcodes as $key => $ppb_shortcode)		
    {
    	if(is_numeric($key) && $ppb_shortcode['title']!='Close')
    	{
    		$ppb_tabs[$key] = $ppb_shortcode['title'];
    	}
    }

    //Add tabs
    if(!empty($ppb_tabs))
    {
?>
    <div id="ppb_tab">
    	<ul>
<?php
    	foreach($ppb_tabs as $tab_key => $ppb_tab)	
    	{
?>
    	<li><a href="#tabs-<?php echo esc_attr($tab_key); ?>"><?php echo esc_html($ppb_tab); ?></a></li>
<?php	
    	}
?>
    	</ul>
<?php
    }
?>

<?php
    foreach($ppb_shortcodes as $key => $ppb_shortcode)		
    {
    	//If new tab
    	if(is_numeric($key) && $ppb_shortcode['title']!='Close')
    	{
?>
    <div id="tabs-<?php echo esc_attr($key); ?>">
    	<ul id="ppb_module_wrapper">
<?php
    	}
    	
    	//If normal content builder module
    	if(!isset($ppb_shortcode['type']) && isset($ppb_shortcode['icon']) && !empty($ppb_shortcode['icon']))
    	{
    		//shortcode icon
    		$ppb_shortcode_icon = get_template_directory_uri().'/functions/images/builder/'.esc_attr($ppb_shortcode['icon']);
    		
    		//preview screenshot
    		$ppb_shortcode_preview = get_template_directory_uri().'/functions/images/builder_screenshots/'.esc_attr($ppb_shortcode['image']);
?>
<li id="ppb_module_<?php echo esc_attr($key); ?>" data-module="<?php echo esc_attr($key); ?>" data-title="<?php echo esc_attr($ppb_shortcode['title']); ?>" data-type="module" data-shortcode="<?php echo esc_attr($ppb_shortcode['title']); ?>" data-icon="<?php echo esc_url($ppb_shortcode_icon); ?>"><img src="<?php echo esc_url($ppb_shortcode_preview); ?>" alt="" title="<?php echo esc_attr($ppb_shortcode['title']); ?>" class="builder_thumb"/>
    <div class="builder_title"><?php echo esc_html($ppb_shortcode['title']); ?></div>
</li>
<?php
    	}
    				
    	//If next is new tab
    	if(is_numeric($key) && $ppb_shortcode['title']=='Close')
    	{
?>
    	</ul>
    </div>
<?php
    	}
    } //End foreach
    
    //Add tabs
    if(!empty($ppb_tabs))
    {
?>
    </div>
<?php
    }
?>
