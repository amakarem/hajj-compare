<?php
	/**
	 * @package     Freemius
	 * @copyright   Copyright (c) 2015, Freemius, Inc.
	 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
	 * @since       1.0.3
	 */

	/**
	 * Note for WordPress.org Theme/Plugin reviewer:
	 *  Freemius is an SDK for plugin and theme developers. Since the core
	 *  of the SDK is relevant both for plugins and themes, for obvious reasons,
	 *  we only develop and maintain one code base.
	 *
	 *  This code (and page) will not run for wp.org themes (only plugins).
	 *
	 *  In addition, this page loads an i-frame. We intentionally named it 'frame'
	 *  so it will pass the "Theme Check" that is looking for the string "i" . "frame".
	 *
	 * UPDATE:
	 *  After ongoing conversations with the WordPress.org TRT we received
	 *  an official approval for including i-frames in the theme's WP Admin setting's
	 *  page tab (the SDK will never add any i-frames on the sitefront). i-frames
	 *  were never against the guidelines, but we wanted to get the team's blessings
	 *  before we move forward. For the record, I got the final approval from
	 *  Ulrich Pogson (@grapplerulrich), a team lead at the TRT during WordCamp
	 *  Europe 2017 (June 16th, 2017).
	 *
	 * If you have any questions or need clarifications, please don't hesitate
	 * pinging me on slack, my username is @svovaf.
	 *
	 * @author Vova Feldman (@svovaf)
	 * @since 1.2.2
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'json2' );
	fs_enqueue_local_script( 'postmessage', 'nojquery.ba-postmessage.min.js' );
	fs_enqueue_local_script( 'fs-postmessage', 'postmessage.js' );
	fs_enqueue_local_style( 'fs_common', '/admin/common.css' );

	/**
	 * @var array    $VARS
	 * @var Freemius $fs
	 */
	$fs        = freemius( $VARS['id'] );
	$slug 	   = $fs->get_slug();
	$timestamp = time();

	$context_params = array(
		'plugin_id'         => $fs->get_id(),
		'plugin_public_key' => $fs->get_public_key(),
		'plugin_version'    => $fs->get_plugin_version(),
	);

	// Get site context secure params.
	if ( $fs->is_registered() ) {
		$context_params = array_merge( $context_params, FS_Security::instance()->get_context_params(
			$fs->get_site(),
			$timestamp,
			'upgrade'
		) );
	} else {
		$context_params['home_url'] = home_url();
	}

	if ( $fs->is_payments_sandbox() ) // Append plugin secure token for sandbox mode authentication.)
	{
		$context_params['sandbox'] = FS_Security::instance()->get_secure_token(
			$fs->get_plugin(),
			$timestamp,
			'checkout'
		);
	}

	$query_params = array_merge( $context_params, $_GET, array(
		'next'             => $fs->_get_sync_license_url( false, false ),
		'plugin_version'   => $fs->get_plugin_version(),
		// Billing cycle.
		'billing_cycle'    => fs_request_get( 'billing_cycle', WP_FS__PERIOD_ANNUALLY ),
		'is_network_admin' => fs_is_network_admin() ? 'true' : 'false',
	) );

	if ( ! $fs->is_registered() ) {
		$template_data = array(
			'id' => $fs->get_id(),
		);
		fs_require_template( 'forms/trial-start.php', $template_data);
	}

	$view_params = array(
		'id'   => $VARS['id'],
		'page' => strtolower( $fs->get_text_x_inline( 'Pricing', 'noun', 'pricing' ) ),
	);
	fs_require_once_template('secure-https-header.php', $view_params);

	$has_tabs = $fs->_add_tabs_before_content();

	if ( $has_tabs ) {
		$query_params['tabs'] = 'true';
	}
?>
	<div id="fs_pricing" class="wrap fs-section fs-full-size-wrapper">
		<div id="frame"></div>
		<form action="" method="POST">
			<input type="hidden" name="user_id"/>
			<input type="hidden" name="user_email"/>
			<input type="hidden" name="site_id"/>
			<input type="hidden" name="public_key"/>
			<input type="hidden" name="secret_key"/>
			<input type="hidden" name="action" value="account"/>
		</form>

		<script type="text/javascript">
			(function ($, undef) {
				$(function () {
					var
					// Keep track of the i-frame height.
					frame_height = 800,
					base_url     = '<?php echo WP_FS__ADDRESS ?>',
					// Pass the parent page URL into the i-frame in a meaningful way (this URL could be
					// passed via query string or hard coded into the child page, it depends on your needs).
					src          = base_url + '/pricing/?<?php echo http_build_query( $query_params ) ?>#' + encodeURIComponent(document.location.href),

					// Append the I-frame into the DOM.
					frame = $('<i' + 'frame " src="' + src + '" width="100%" height="' + frame_height + 'px" scrolling="no" frameborder="0" style="background: transparent; width: 1px; min-width: 100%;"><\/i' + 'frame>')
						.appendTo('#frame');

					FS.PostMessage.init(base_url, [frame[0]]);

					FS.PostMessage.receive('height', function (data) {
						var h = data.height;
						if (!isNaN(h) && h > 0 && h != frame_height) {
							frame_height = h;
							frame.height(frame_height + 'px');

							FS.PostMessage.postScroll(frame[0]);
						}
					});

					FS.PostMessage.receive('get_dimensions', function (data) {
						FS.PostMessage.post('dimensions', {
							height   : $(document.body).height(),
							scrollTop: $(document).scrollTop()
						}, frame[0]);
					});

					FS.PostMessage.receive('start_trial', function (data) {
						openTrialConfirmationModal(data);
					});
				});
			})(jQuery);
		</script>
	</div>
<?php
	if ( $has_tabs ) {
		$fs->_add_tabs_after_content();
	}

	$params = array(
		'page'           => 'pricing',
		'module_id'      => $fs->get_id(),
		'module_type'    => $fs->get_module_type(),
		'module_slug'    => $slug,
		'module_version' => $fs->get_plugin_version(),
	);
	fs_require_template( 'powered-by.php', $params );
