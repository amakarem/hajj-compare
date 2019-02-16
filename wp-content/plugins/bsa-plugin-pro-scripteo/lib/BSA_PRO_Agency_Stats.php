<?php
require_once dirname(__FILE__) . '/BSA_PRO_Agency_Ordering_form.php'; // require ordering form if stats
$ad_id = $_GET['bsa_pro_id'];
$model = new BSA_PRO_Model();
$statsFrom = (($model->bsaIntervalStats($ad_id, 'from') != null) ? $model->bsaIntervalStats($ad_id, 'from') : 0);
$countClicks = (($model->bsaIntervalStats($ad_id, 'from') != null) ? $model->bsaCountClicks($ad_id, $statsFrom[0]) : 0);
$countViews = (($model->bsaIntervalStats($ad_id, 'from') != null) ? $model->bsaCountViews($ad_id, $statsFrom[0]) : 0);
echo '
<div class="bsaStatsWrapperBg"></div>
<div class="bsaStatsWrapper" data-ad-id="'.$ad_id.'" data-days="7" data-from="'.$statsFrom[0].'" data-time="'.time().'">
	<div class="bsaStatsWrapperInner">
		<h2><span>'.get_option("bsa_pro_plugin_trans_stats_header").'</span> <span class="bsaLoader bsaLoaderStats" style="display: none"></span></h2>
		<div class="bsaStatsButtons">
			<a class="bsaPrevWeek" href="#" onclick="bsaPrevStats()">'.get_option("bsa_pro_plugin_trans_stats_prev_week").'</a>
			<a class="bsaNextWeek" href="#" onclick="bsaNextStats()">'.get_option("bsa_pro_plugin_trans_stats_next_week").'</a>
		</div>
		<div class="bsaStatsChart">
			<div class="bsaSumStats">
				'.get_option("bsa_pro_plugin_trans_stats_clicks").' <strong>'.$countClicks[0].'</strong>
			</div>
			<div class="bsaSumStats" style="margin: 0 5%">
				'.get_option("bsa_pro_plugin_trans_stats_views").' <strong>'.$countViews[0].'</strong>
			</div>
			<div class="bsaSumStats">
				'.get_option("bsa_pro_plugin_trans_stats_ctr").' <strong>'.(($countViews[0] > 1) ? number_format(($countClicks[0] / $countViews[0]) * 100, 2)." %" : " - " ).'</strong>
			</div>
		</div>';
$report = plugin_dir_path( __FILE__ ) . 'PDF/reports/ad-'.$ad_id.'.txt';
if ( file_exists( $report ) ) {
	echo 	'<div style="text-align: right">
			<span>'.bsa_get_trans('statistics', 'full_stats').'</span>
			<a style="margin-left: 10px;" href="' . plugin_dir_url(__FILE__) . 'pdf.php?pdf=' . substr(md5($ad_id . '1'), 1, 11) . '&ad_id=' . $ad_id . '&stats=90">'.bsa_get_trans('statistics', 'last_90').'</a>
			<a style="margin-left: 10px;" href="' . plugin_dir_url(__FILE__) . 'pdf.php?pdf=' . substr(md5($ad_id . '1'), 1, 11) . '&ad_id=' . $ad_id . '&stats=30">'.bsa_get_trans('statistics', 'last_30').'</a>
			<a style="margin-left: 10px;" href="' . plugin_dir_url(__FILE__) . 'pdf.php?pdf=' . substr(md5($ad_id . '1'), 1, 11) . '&ad_id=' . $ad_id . '&stats=7">'.bsa_get_trans('statistics', 'last_7').'</a>
		</div>';
}
echo '	<div class="bsaChart ct-chart"></div>';
echo '<h3 class="bsaHeaderClicks">'.get_option("bsa_pro_plugin_trans_stats_clicks").'</h3>';
echo '<div class="bsaStatsClicks"></div>';
echo '<span class="bsaStatsClose"></span>
	</div>
</div>'; ?>
<script>
	(function($){
		var bsaStatsWrapperBg = $(".bsaStatsWrapperBg");
		var bsaStatsWrapper = $(".bsaStatsWrapper");
		var bsaBody = $("body");
		bsaBody.css({"overflow" : "hidden", "height" : ( bsaBody.hasClass("logged-in") ) ? $( window ).height() - 32 : $( window ).height()});
		bsaStatsWrapper.appendTo(document.body).addClass("animated zoomInDown");
		bsaStatsWrapperBg.appendTo(document.body).addClass("animated zoomInDown");
		bsaInitStatsChart();
		bsaInitClicksList();
		$(document).ready(function() {
			var bsaStatsClose = $(".bsaStatsClose");
			var bsaChartDirect = $(".bsaStatsChart");
			var bsaStatsClicks = $(".bsaStatsClicks");
			bsaChartDirect.css({"max-height" : "300px"});
			bsaStatsClicks.css({"max-height" : "400px"});
			bsaStatsClose.click(function () {
				bsaBody.css({"overflow" : "", "height" : ""});
				bsaChartDirect.addClass("animated zoomOut");
				bsaStatsClose.addClass("animated zoomOut");
				bsaStatsClicks.addClass("animated zoomOut");
				setTimeout(function(){
					bsaStatsWrapper.removeClass("zoomInDown").addClass("animated zoomOutUp");
					bsaStatsWrapperBg.removeClass("zoomInDown").addClass("animated zoomOutUp");
				}, 400);
			});
		});
	})(jQuery);
	function bsaInitStatsChart()
	{
		(function($) {
			var bsaStatsWrapper = $(".bsaStatsWrapper");
			var bsaChartDirect = $(".bsaChart");
			var bsaLoader = $(".bsaLoaderStats");
			var bsaPrevWeek = $(".bsaPrevWeek");
			bsaChartDirect.addClass("animated zoomOut");
			bsaLoader.fadeIn(400);
			if ( parseInt(bsaStatsWrapper.attr("data-time")) - parseInt(bsaStatsWrapper.attr("data-days")) * 24 * 60 * 60 < bsaStatsWrapper.attr("data-from") ) {
				bsaPrevWeek.fadeOut();
			} else {
				bsaPrevWeek.fadeIn();
			}
			$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_stats_chart_callback",ad_id:bsaStatsWrapper.attr("data-ad-id"),days:bsaStatsWrapper.attr("data-days")}, function(result) {
				bsaChartDirect.removeClass("zoomOut").addClass("animated zoomIn");
				bsaLoader.fadeOut(400);
				var chart = $.parseJSON(result);
				var data = {
					labels: chart.labels,
					series: [
						{
							name: "<?php echo get_option("bsa_pro_plugin_trans_stats_clicks") ?>",
							data: chart.clicks
						},
						{
							name: "<?php echo get_option("bsa_pro_plugin_trans_stats_views") ?>",
							data: chart.views
						}
					]
				};
				var options = {
					height: "200px"
				};
				new Chartist.Line(".ct-chart", data, options);
			});
		})(jQuery);
	}
	function bsaInitClicksList()
	{
		(function($) {
			var bsaStatsWrapper = $(".bsaStatsWrapper");
			var bsaListDirect = $(".bsaStatsClicks");
			var bsaHeaderClicks = $(".bsaHeaderClicks");
			var bsaLoader = $(".bsaLoaderStats");
			bsaListDirect.addClass("animated zoomOut");
			bsaLoader.fadeIn(400);
			$.post("<?php echo admin_url("admin-ajax.php") ?>", {action:"bsa_stats_clicks_callback",ad_id:bsaStatsWrapper.attr("data-ad-id"),days:bsaStatsWrapper.attr("data-days")}, function(result) {
				if ( result != 0 ) {
					bsaHeaderClicks.fadeIn();
					bsaListDirect.html(result).removeClass("zoomOut").addClass("animated zoomIn");
				} else {
					bsaHeaderClicks.fadeOut();
				}
				bsaLoader.fadeOut(400);
			});
		})(jQuery);
	}
	function bsaPrevStats()
	{
		(function($) {
			var bsaStatsWrapper = $(".bsaStatsWrapper");
			var bsaNextWeek = $(".bsaNextWeek");
			var bsaPrevWeek = $(".bsaPrevWeek");
//			console.log(parseInt(bsaStatsWrapper.attr("data-time")));
//			console.log(parseInt(bsaStatsWrapper.attr("data-days")) * 24 * 60 * 60);
//			console.log(parseInt(bsaStatsWrapper.attr("data-time")) + parseInt(bsaStatsWrapper.attr("data-days")) * 24 * 60 * 60);
//			console.log(bsaStatsWrapper.attr("data-from"));
			if ( parseInt(bsaStatsWrapper.attr("data-time")) - parseInt(bsaStatsWrapper.attr("data-days")) * 24 * 60 * 60 < bsaStatsWrapper.attr("data-from") ) {
				bsaPrevWeek.fadeOut();
			} else {
				bsaPrevWeek.fadeIn();
			}
			bsaStatsWrapper.attr( "data-days", (parseInt(bsaStatsWrapper.attr("data-days")) + 7) );
			if ( parseInt(bsaStatsWrapper.attr("data-days")) >= 7 ) {
				bsaNextWeek.fadeIn();
			} else {
				bsaNextWeek.fadeOut();
			}
			bsaInitStatsChart();
			bsaInitClicksList();
		})(jQuery);
	}
	function bsaNextStats()
	{
		(function($) {
			var bsaStatsWrapper = $(".bsaStatsWrapper");
			var bsaNextWeek = $(".bsaNextWeek");
			if ( parseInt(bsaStatsWrapper.attr("data-days")) >= 21 ) {
				bsaNextWeek.fadeIn();
			} else {
				bsaNextWeek.fadeOut();
			}
			bsaStatsWrapper.attr( "data-days", bsaStatsWrapper.attr("data-days") - 7 );
			bsaInitStatsChart();
			bsaInitClicksList();
		})(jQuery);
	}
</script>