<div class="bsaActionNotice bsaTemplateRemoved" style="display:none">
	Ad Template has been removed.
</div>

<h2>
	<span class="dashicons dashicons-plus-alt"></span> Creator for Standard Ad Templates
</h2>

<form action="" method="post" class="bsaNewStandardAd">
	<input type="hidden" value="adCreator" name="bsaProAction">
	<table class="bsaAdminTable form-table">
		<tbody class="bsaTbody">
		<tr>
			<th colspan="2">
				<h3><span class="dashicons dashicons-exerpt-view"></span> Create Custom Size</h3>
			</th>
		</tr>
		<tr>
			<th scope="row"><label for="ad_width">Image Width</label></th>
			<td>
				<input id="ad_width" name="ad_width" type="number" class="regular-text" value=""> <em>px</em>
			</td>
		</tr>
		<tr>
			<th class="bsaLast" scope="row"><label for="ad_height">Image Height</label></th>
			<td class="bsaLast">
				<input id="ad_height" name="ad_height" type="number" class="regular-text" value=""> <em>px</em>
			</td>
		</tr>
		</tbody>
	</table>
	<input class="bsa_inputs_required" name="inputs_required" type="hidden" value="">
	<p class="submit">
		<input type="submit" value="Save Ad Template" class="button button-primary" id="bsa_pro_submit" name="submit">
	</p>
</form>

<?php
$custom_templates = get_option('bsa_pro_plugin_custom_templates');
if ( $custom_templates && $custom_templates != '' ) {
	?><h3><span class="dashicons dashicons-exerpt-view"></span> Custom Sizes</h3><?php
	$custom_templates = explode(',', $custom_templates);
	foreach ( $custom_templates as $custom_template ) {
		$template = explode('--', $custom_template);
		$width = isset($template[0]) ? $template[0] : null;
		$height = isset($template[1]) ? $template[1] : null;
		if ( $custom_template != '' && isset($width) && isset($height) ) {
			echo '<div class="bsaCreatorItem bsaCustomItem-'.$width.'--'.$height.'">';
			echo $width.' x '.$height.' <span class="bsaRemoveCustomItem button button-primary" data-id="'.$width.'--'.$height.'">remove</span>';
			echo '</div>';
		}
	}
}
?>
<script>
	(function($) {
		// - start - open page
		var bsaItemsWrap = $(".wrap");
		setTimeout(function () {
			bsaItemsWrap.fadeIn(400);
		}, 400);
		// - end - open page

		$('.bsaRemoveCustomItem').click(function(){
			var id = $(this).data('id');
			var customItem = $('.bsaCustomItem-' + id);
			customItem.css('opacity', 0.5);
			$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_admin_action_callback",type:'remove_template',id:id,data:$(this).data('data')}, function(result) {
				if ( result == 'removed' ) {
					var notice = $('.bsaTemplateRemoved');
					notice.fadeIn();
					customItem.fadeOut();
					setTimeout(function () {
						notice.fadeOut();
					}, 2000);
				}
			});
		});
	})(jQuery);
</script>