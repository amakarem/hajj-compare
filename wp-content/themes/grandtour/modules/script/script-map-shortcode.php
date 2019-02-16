<?php
header("content-type: application/x-javascript"); 

$map_data = unserialize(stripslashes($_GET['data']));

$marker = '{ ';
$marker.= 'MapOptions: { ';

if(!empty($map_data['type']))
{
    $marker.= 'mapTypeId: google.maps.MapTypeId.'.esc_js($map_data['type']).',';
}

if(!empty($map_data['zoom']))
{
	$marker.= 'zoom: '.esc_js($map_data['zoom']).',';
}

$marker.= 'scrollwheel: false,';

$pp_googlemap_style = get_option('pp_googlemap_style');
if(!empty($pp_googlemap_style) && empty($map_data['type']))
{
	$marker.= 'styles: '.stripslashes($pp_googlemap_style).',';
}
$marker.= ' }';
$marker.= ' }';

?>
jQuery(document).ready(function(){ jQuery("#<?php echo esc_js($map_data['id']); ?>").simplegmaps(<?php echo stripslashes($marker); ?>); });
<?php
if(isset($_GET['fullheight']) && $_GET['fullheight'] == 'true')
{
?>
jQuery(document).ready(function(){ 
	var mapHeight = jQuery("#<?php echo esc_js($map_data['id']); ?>").parent().parent().height();
	if(mapHeight>0)
	{
		jQuery("#<?php echo esc_js($map_data['id']); ?>").css('height', mapHeight+'px');
	}
});
<?php
}
?>
