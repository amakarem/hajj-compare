<?php
/**
 * Class and methods to implement ExactDN (based on Photon implementation).
 *
 * @link https://ewww.io
 * @package EWWW_Image_Optimizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enables EWWW IO to filter the page content and replace image urls with ExactDN urls.
 */
class ExactDN extends EWWWIO_Page_Parser {

	/**
	 * Allowed image extensions.
	 *
	 * @access private
	 * @var array $extensions
	 */
	protected $extensions = array(
		'gif',
		'jpg',
		'jpeg',
		'jpe',
		'png',
	);


	/**
	 * A list of user-defined exclusions, populated by validate_user_exclusions().
	 *
	 * @access protected
	 * @var array $user_exclusions
	 */
	protected $user_exclusions = array();

	/**
	 * A list of image sizes registered for attachments.
	 *
	 * @access protected
	 * @var array $image_sizes
	 */
	protected static $image_sizes = null;

	/**
	 * Indicates if we are in full-page filtering mode.
	 *
	 * @access public
	 * @var bool $filtering_the_page
	 */
	public $filtering_the_page = false;

	/**
	 * Indicates if we are in content filtering mode.
	 *
	 * @access public
	 * @var bool $filtering_the_content
	 */
	public $filtering_the_content = false;

	/**
	 * List of permitted domains for ExactDN rewriting.
	 *
	 * @access public
	 * @var array $allowed_domains
	 */
	public $allowed_domains = array();

	/**
	 * The ExactDN domain/zone.
	 *
	 * @access private
	 * @var float $elapsed_time
	 */
	private $exactdn_domain = false;

	/**
	 * The detected site scheme (http/https).
	 *
	 * @access private
	 * @var string $scheme
	 */
	private $scheme = false;

	/**
	 * Allow us to track how much overhead ExactDN introduces.
	 *
	 * @access private
	 * @var float $elapsed_time
	 */
	private $elapsed_time = 0;

	/**
	 * Register (once) actions and filters for ExactDN. If you want to use this class, use the global.
	 */
	function __construct() {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		global $exactdn;
		if ( is_object( $exactdn ) ) {
			return 'you are doing it wrong';
		}

		// Make sure we have an ExactDN domain to use.
		if ( ! $this->setup() ) {
			return;
		}

		if ( ! $this->scheme ) {
			$site_url = get_home_url();
			$scheme   = 'http';
			if ( strpos( $site_url, 'https://' ) !== false ) {
				$scheme = 'https';
			}
			$this->scheme = $scheme;
		}

		// Images in post content and galleries.
		add_filter( 'the_content', array( $this, 'filter_the_content' ), 999999 );
		// Start an output buffer before any output starts.
		add_action( 'template_redirect', array( $this, 'buffer_start' ), 1 );

		// Core image retrieval.
		if ( ! function_exists( 'aq_resize' ) ) {
			add_filter( 'image_downsize', array( $this, 'filter_image_downsize' ), 10, 3 );
		} else {
			ewwwio_debug_message( 'aq_resize detected, image_downsize filter disabled' );
		}
		// Disable image_downsize filter during themify_get_image().
		add_action( 'themify_before_post_image', array( $this, 'disable_image_downsize' ) );

		// Overrides for admin-ajax images.
		add_filter( 'exactdn_admin_allow_image_downsize', array( $this, 'allow_admin_image_downsize' ), 10, 2 );
		// Overrides for "pass through" images.
		add_filter( 'exactdn_pre_args', array( $this, 'exactdn_remove_args' ), 10, 3 );

		// Responsive image srcset substitution.
		add_filter( 'wp_calculate_image_srcset', array( $this, 'filter_srcset_array' ), 1001, 5 );
		add_filter( 'wp_calculate_image_sizes', array( $this, 'filter_sizes' ), 1, 2 ); // Early so themes can still filter.

		// Filter for NextGEN image urls within JS.
		add_filter( 'ngg_pro_lightbox_images_queue', array( $this, 'ngg_pro_lightbox_images_queue' ) );
		add_filter( 'ngg_get_image_url', array( $this, 'ngg_get_image_url' ) );

		// DNS prefetching.
		add_action( 'wp_head', array( $this, 'dns_prefetch' ) );

		// Get all the script/css urls and rewrite them (if enabled).
		if ( ewww_image_optimizer_get_option( 'exactdn_all_the_things' ) ) {
			add_filter( 'style_loader_src', array( $this, 'parse_enqueue' ), 20 );
			add_filter( 'script_loader_src', array( $this, 'parse_enqueue' ), 20 );
		}

		// Configure Autoptimize with our CDN domain.
		add_filter( 'autoptimize_filter_cssjs_multidomain', array( $this, 'autoptimize_cdn_url' ) );
		if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
			$ao_cdn_url = ewww_image_optimizer_get_option( 'autoptimize_cdn_url' );
			if ( empty( $ao_cdn_url ) ) {
				ewww_image_optimizer_set_option( 'autoptimize_cdn_url', '//' . $this->exactdn_domain );
			} elseif ( strpos( $ao_cdn_url, 'exactdn' ) && '//' . $this->exactdn_domain !== $ao_cdn_url ) {
				ewww_image_optimizer_set_option( 'autoptimize_cdn_url', '//' . $this->exactdn_domain );
			}
		}

		// Find the "local" domain.
		$upload_dir          = wp_upload_dir( null, false );
		$this->upload_domain = defined( 'EXACTDN_LOCAL_DOMAIN' ) && EXACTDN_LOCAL_DOMAIN ? $this->parse_url( EXACTDN_LOCAL_DOMAIN, PHP_URL_HOST ) : $this->parse_url( $upload_dir['baseurl'], PHP_URL_HOST );
		ewwwio_debug_message( "allowing images from here: $this->upload_domain" );
		$this->allowed_domains[] = $this->upload_domain;
		if ( strpos( $this->upload_domain, 'www' ) === false ) {
			$this->allowed_domains[] = 'www.' . $this->upload_domain;
		} else {
			$nonwww = ltrim( 'www.', $this->upload_domain );
			if ( $nonwww !== $this->upload_domain ) {
				$this->allowed_domains[] = $nonwww;
			}
		}
		$wpml_domains = apply_filters( 'wpml_setting', array(), 'language_domains' );
		if ( ewww_image_optimizer_iterable( $wpml_domains ) ) {
			ewwwio_debug_message( 'wpml domains: ' . implode( ',', $wpml_domains ) );
			$this->allowed_domains[] = $this->parse_url( get_option( 'home' ), PHP_URL_HOST );
			foreach ( $wpml_domains as $wpml_domain ) {
				$this->allowed_domains[] = $wpml_domain;
			}
		}
		$this->allowed_domains = apply_filters( 'exactdn_allowed_domains', $this->allowed_domains );
		ewwwio_debug_message( 'allowed domains: ' . implode( ',', $this->allowed_domains ) );
		$this->validate_user_exclusions();
	}

	/**
	 * If ExactDN is enabled, validates and configures the ExactDN domain name.
	 */
	function setup() {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		// If we don't have a domain yet, go grab one.
		if ( ! $this->get_exactdn_domain() ) {
			ewwwio_debug_message( 'attempting to activate exactDN' );
			$exactdn_domain = $this->activate_site();
		} else {
			ewwwio_debug_message( 'grabbing existing exactDN domain' );
			$exactdn_domain = $this->get_exactdn_domain();
		}
		if ( ! $exactdn_domain ) {
			if ( get_option( 'ewww_image_optimizer_exactdn_failures' ) < 5 ) {
				$failures = (int) get_option( 'ewww_image_optimizer_exactdn_failures' );
				$failures++;
				ewwwio_debug_message( "could not activate ExactDN, failures: $failures" );
				update_option( 'ewww_image_optimizer_exactdn_failures', $failures );
				return false;
			}
			delete_option( 'ewww_image_optimizer_exactdn' );
			delete_site_option( 'ewww_image_optimizer_exactdn' );
			return false;
		}
		// If we have a domain, verify it.
		if ( $this->verify_domain( $exactdn_domain ) ) {
			ewwwio_debug_message( 'verified existing exactDN domain' );
			delete_option( 'ewww_image_optimizer_exactdn_failures' );
			$this->exactdn_domain = $exactdn_domain;
			ewwwio_debug_message( 'exactdn_domain: ' . $exactdn_domain );
			return true;
		} elseif ( $this->get_exactdn_option( 'checkin' ) < time() - 5 && get_option( 'ewww_image_optimizer_exactdn_failures' ) < 10 ) {
			$failures = (int) get_option( 'ewww_image_optimizer_exactdn_failures' );
			$failures++;
			ewwwio_debug_message( "could not verify existing exactDN domain, failures: $failures" );
			update_option( 'ewww_image_optimizer_exactdn_failures', $failures );
			$this->set_exactdn_option( 'checkin', time() + 300 );
			return false;
		} elseif ( get_option( 'ewww_image_optimizer_exactdn_failures' ) < 10 ) {
			$failures = (int) get_option( 'ewww_image_optimizer_exactdn_failures' );
			ewwwio_debug_message( 'could not verify existing exactDN domain, waiting for ' . $this->human_time_diff( $this->get_exactdn_option( 'checkin' ) ) );
			ewwwio_debug_message( 10 - $failures . ' attempts remaining' );
			return false;
		}
		delete_option( 'ewww_image_optimizer_exactdn_domain' );
		delete_option( 'ewww_image_optimizer_exactdn_verified' );
		delete_site_option( 'ewww_image_optimizer_exactdn_domain' );
		delete_site_option( 'ewww_image_optimizer_exactdn_verified' );
		return false;
	}

	/**
	 * Use the Site URL to get the zone domain.
	 */
	function activate_site() {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$site_url = defined( 'EXACTDN_LOCAL_DOMAIN' ) && EXACTDN_LOCAL_DOMAIN ? EXACTDN_LOCAL_DOMAIN : get_home_url();
		$url      = 'http://optimize.exactlywww.com/exactdn/activate.php';
		$ssl      = wp_http_supports( array( 'ssl' ) );
		if ( $ssl ) {
			$url = set_url_scheme( $url, 'https' );
		}
		add_filter( 'http_headers_useragent', 'ewww_image_optimizer_cloud_useragent', PHP_INT_MAX );
		$result = wp_remote_post(
			$url,
			array(
				'timeout' => 10,
				'body'    => array(
					'site_url' => $site_url,
				),
			)
		);
		if ( is_wp_error( $result ) ) {
			$error_message = $result->get_error_message();
			ewwwio_debug_message( "exactdn activation request failed: $error_message" );
			return false;
		} elseif ( ! empty( $result['body'] ) && strpos( $result['body'], 'domain' ) !== false ) {
			$response = json_decode( $result['body'], true );
			if ( ! empty( $response['domain'] ) ) {
				return $this->set_exactdn_domain( $response['domain'] );
			}
		} elseif ( ! empty( $result['body'] ) && strpos( $result['body'], 'error' ) !== false ) {
			$response      = json_decode( $result['body'], true );
			$error_message = $response['error'];
			ewwwio_debug_message( "exactdn activation request failed: $error_message" );
			return false;
		}
		return false;
	}

	/**
	 * Verify the ExactDN domain.
	 *
	 * @param string $domain The ExactDN domain to verify.
	 * @return bool Whether the domain is still valid.
	 */
	function verify_domain( $domain ) {
		if ( empty( $domain ) ) {
			return false;
		}
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		// Check the time, to see how long it has been since we verified the domain.
		$last_checkin = $this->get_exactdn_option( 'checkin' );
		if ( ! empty( $last_checkin ) && $last_checkin > time() ) {
			ewwwio_debug_message( 'not time yet: ' . $this->human_time_diff( $this->get_exactdn_option( 'checkin' ) ) );
			if ( $this->get_exactdn_option( 'suspended' ) ) {
				return false;
			}
			return true;
		}

		$this->check_verify_method();

		if ( ! defined( 'EXACTDN_LOCAL_DOMAIN' ) && $this->get_exactdn_option( 'verify_method' ) > 0 ) {
			// Test with an image file that should be available on the ExactDN zone.
			$test_url     = plugins_url( '/images/test.png', EWWW_IMAGE_OPTIMIZER_PLUGIN_FILE );
			$local_domain = $this->parse_url( $test_url, PHP_URL_HOST );
			$test_url     = str_replace( $local_domain, $domain, $test_url );
			ewwwio_debug_message( "test url is $test_url" );
			add_filter( 'http_headers_useragent', 'ewww_image_optimizer_cloud_useragent', PHP_INT_MAX );
			$test_result = wp_remote_get( $test_url );
			if ( is_wp_error( $test_result ) ) {
				$error_message = $test_result->get_error_message();
				ewwwio_debug_message( "exactdn verification request failed: $error_message" );
				$this->set_exactdn_option( 'suspended', 1 );
				return false;
			} elseif ( ! empty( $test_result['body'] ) && strlen( $test_result['body'] ) > 300 ) {
				if ( 200 === $test_result['response']['code'] &&
					( '89504e470d0a1a0a' === bin2hex( substr( $test_result['body'], 0, 8 ) ) || '52494646' === bin2hex( substr( $test_result['body'], 0, 4 ) ) ) ) {
					ewwwio_debug_message( 'exactdn (real-world) verification succeeded' );
					$this->set_exactdn_option( 'checkin', time() + 3600 );
					$this->set_exactdn_option( 'verified', 1, false );
					$this->set_exactdn_option( 'suspended', 0 );
					return true;
				}
				ewwwio_debug_message( 'mime check failed: ' . bin2hex( substr( $test_result['body'], 0, 3 ) ) );
			}
			$this->set_exactdn_option( 'suspended', 1 );
			return false;
		}

		// Secondary test against the API db.
		$url = 'http://optimize.exactlywww.com/exactdn/verify.php';
		$ssl = wp_http_supports( array( 'ssl' ) );
		if ( $ssl ) {
			$url = set_url_scheme( $url, 'https' );
		}
		add_filter( 'http_headers_useragent', 'ewww_image_optimizer_cloud_useragent', PHP_INT_MAX );
		$result = wp_remote_post(
			$url,
			array(
				'timeout' => 10,
				'body'    => array(
					'alias' => $domain,
				),
			)
		);
		if ( is_wp_error( $result ) ) {
			$error_message = $result->get_error_message();
			ewwwio_debug_message( "exactdn verification request failed: $error_message" );
			$this->set_exactdn_option( 'suspended', 1 );
			return false;
		} elseif ( ! empty( $result['body'] ) && strpos( $result['body'], 'error' ) === false ) {
			$response = json_decode( $result['body'], true );
			if ( ! empty( $response['success'] ) ) {
				ewwwio_debug_message( 'exactdn (secondary) verification succeeded' );
				$this->set_exactdn_option( 'checkin', time() + 3600 );
				$this->set_exactdn_option( 'verified', 1, false );
				$this->set_exactdn_option( 'suspended', 0 );
				return true;
			}
		} elseif ( ! empty( $result['body'] ) ) {
			$response      = json_decode( $result['body'], true );
			$error_message = $response['error'];
			ewwwio_debug_message( "exactdn activation request failed: $error_message" );
			$this->set_exactdn_option( 'suspended', 1 );
			return false;
		}
		$this->set_exactdn_option( 'suspended', 1 );
		return false;
	}

	/**
	 * Run a simulation to decide which verification method to use.
	 */
	function check_verify_method() {
		if ( ! $this->get_exactdn_option( 'verify_method' ) ) {
			ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
			// Prelim test with a known valid image to ensure http(s) connectivity.
			$sim_url = 'https://optimize.exactdn.com/exactdn/testorig.jpg';
			add_filter( 'http_headers_useragent', 'ewww_image_optimizer_cloud_useragent', PHP_INT_MAX );
			$sim_result = wp_remote_get( $sim_url );
			if ( is_wp_error( $sim_result ) ) {
				$error_message = $sim_result->get_error_message();
				ewwwio_debug_message( "exactdn (simulated) verification request failed: $error_message" );
			} elseif ( ! empty( $sim_result['body'] ) && strlen( $sim_result['body'] ) > 300 ) {
				if ( 'ffd8ff' === bin2hex( substr( $sim_result['body'], 0, 3 ) ) ) {
					ewwwio_debug_message( 'exactdn (simulated) verification succeeded' );
					$this->set_exactdn_option( 'verify_method', 1, false );
					return;
				}
			}
			ewwwio_debug_message( 'exactdn (simulated) verification request failed, error unknown' );
			$this->set_exactdn_option( 'verify_method', -1, false );
		}
	}

	/**
	 * Validate the ExactDN domain.
	 *
	 * @param string $domain The unverified ExactDN domain.
	 * @return string The validated ExactDN domain.
	 */
	function sanitize_domain( $domain ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( ! $domain ) {
			return;
		}
		if ( strlen( $domain ) > 80 ) {
			ewwwio_debug_message( "$domain too long" );
			return false;
		}
		if ( ! preg_match( '#^[A-Za-z0-9\.\-]+$#', $domain ) ) {
			ewwwio_debug_message( "$domain has bad characters" );
			return false;
		}
		return $domain;
	}

	/**
	 * Get the ExactDN domain name to use.
	 *
	 * @return string The ExactDN domain name for this site or network.
	 */
	function get_exactdn_domain() {
		if ( defined( 'EXACTDN_DOMAIN' ) && EXACTDN_DOMAIN ) {
			return $this->sanitize_domain( EXACTDN_DOMAIN );
		}
		if ( is_multisite() ) {
			if ( ! SUBDOMAIN_INSTALL ) {
				return $this->sanitize_domain( get_site_option( 'ewww_image_optimizer_exactdn_domain' ) );
			}
		}
		return $this->sanitize_domain( get_option( 'ewww_image_optimizer_exactdn_domain' ) );
	}

	/**
	 * Get the ExactDN option.
	 *
	 * @param string $option_name The name of the ExactDN option.
	 * @return int The numerical value of the option.
	 */
	function get_exactdn_option( $option_name ) {
		if ( defined( 'EXACTDN_DOMAIN' ) && EXACTDN_DOMAIN ) {
			return (int) get_option( 'ewww_image_optimizer_exactdn_' . $option_name );
		}
		if ( is_multisite() ) {
			if ( ! SUBDOMAIN_INSTALL ) {
				return (int) get_site_option( 'ewww_image_optimizer_exactdn_' . $option_name );
			}
		}
		return (int) get_option( 'ewww_image_optimizer_exactdn_' . $option_name );
	}

	/**
	 * Set the ExactDN domain name to use.
	 *
	 * @param string $domain The ExactDN domain name for this site or network.
	 */
	function set_exactdn_domain( $domain ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( defined( 'EXACTDN_DOMAIN' ) && $this->sanitize_domain( EXACTDN_DOMAIN ) ) {
			return true;
		}
		$domain = $this->sanitize_domain( $domain );
		if ( ! $domain ) {
			return false;
		}
		if ( is_multisite() ) {
			if ( ! SUBDOMAIN_INSTALL ) {
				update_site_option( 'ewww_image_optimizer_exactdn_domain', $domain );
				return $domain;
			}
		}
		update_option( 'ewww_image_optimizer_exactdn_domain', $domain );
		return $domain;
	}

	/**
	 * Set an option for ExactDN.
	 *
	 * @param string $option_name The name of the ExactDN option.
	 * @param int    $option_value The value to set for the ExactDN option.
	 * @param bool   $autoload Optional. Whether to load the option when WordPress starts up.
	 */
	function set_exactdn_option( $option_name, $option_value, $autoload = null ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( defined( 'EXACTDN_DOMAIN' ) && EXACTDN_DOMAIN ) {
			return update_option( 'ewww_image_optimizer_exactdn_' . $option_name, $option_value, $autoload );
		}
		if ( is_multisite() ) {
			if ( ! SUBDOMAIN_INSTALL ) {
				return update_site_option( 'ewww_image_optimizer_exactdn_' . $option_name, $option_value );
			}
		}
		return update_option( 'ewww_image_optimizer_exactdn_' . $option_name, $option_value, $autoload );
	}

	/**
	 * Validate the user-defined exclusions for "all the things" rewriting.
	 */
	function validate_user_exclusions() {
		if ( defined( 'EXACTDN_EXCLUDE' ) && EXACTDN_EXCLUDE ) {
			$user_exclusions = EXACTDN_EXCLUDE;
		}
		if ( ! empty( $user_exclusions ) ) {
			if ( is_string( $user_exclusions ) ) {
				$user_exclusions = array( $user_exclusions );
			}
			if ( is_array( $user_exclusions ) ) {
				foreach ( $user_exclusions as $exclusion ) {
					if ( false !== strpos( $exclusion, 'wp-content' ) ) {
						$exclusion = preg_replace( '#([^"\'?>]+?)?wp-content/#i', '', $exclusion );
					}
					$this->user_exclusions[] = ltrim( $exclusion, '/' );
				}
			}
		}
	}

	/**
	 * Get $content_width, with a filter.
	 *
	 * @return bool|string The content width, if set. Default false.
	 */
	function get_content_width() {
		$content_width = isset( $GLOBALS['content_width'] ) ? $GLOBALS['content_width'] : false;
		/**
		 * Filter the Content Width value.
		 *
		 * @param string $content_width Content Width value.
		 */
		return apply_filters( 'exactdn_content_width', $content_width );
	}

	/**
	 * Get the width from an image element.
	 *
	 * @param string $img The full image element.
	 * @return string The width found or an empty string.
	 */
	public function get_img_width( $img ) {
		$width = $this->get_attribute( $img, 'width' );
		// Then check for an inline max-width directive.
		if ( preg_match( '#max-width:\s?(\d+)px#', $img, $max_width_string ) ) {
			if ( $max_width_string[1] && ( ! $width || $max_width_string[1] < $width ) ) {
				$width = $max_width_string[1];
			}
		}
		return $width;
	}

	/**
	 * Get width within an ExactDN url.
	 *
	 * @param string $url The ExactDN url to parse.
	 * @return string The width, if found.
	 */
	public function get_exactdn_width_from_url( $url ) {
		$url_args = $this->parse_url( $url, PHP_URL_QUERY );
		if ( ! $url_args ) {
			return '';
		}
		$args = explode( '&', $url_args );
		foreach ( $args as $arg ) {
			if ( preg_match( '#w=(\d+)#', $arg, $width_match ) ) {
				return $width_match[1];
			}
			if ( preg_match( '#resize=(\d+)#', $arg, $width_match ) ) {
				return $width_match[1];
			}
			if ( preg_match( '#fit=(\d+)#', $arg, $width_match ) ) {
				return $width_match[1];
			}
		}
		return '';
	}

	/**
	 * Starts an output buffer and registers the callback function to do ExactDN url replacement.
	 */
	function buffer_start() {
		ob_start( array( $this, 'filter_the_page' ) );
	}

	/**
	 * Identify images in page content, and if images are local (uploaded to the current site), pass through ExactDN.
	 *
	 * @param string $content The page/post content.
	 * @return string The content with ExactDN image urls.
	 */
	function filter_the_page( $content ) {
		$this->filtering_the_page = true;

		$content = $this->filter_the_content( $content );

		$this->filtering_the_page = false;
		ewwwio_debug_message( "parsing page took $this->elapsed_time seconds" );
		return $content;
	}

	/**
	 * Identify images in the content, and if images are local (uploaded to the current site), pass through ExactDN.
	 *
	 * @param string $content The page/post content.
	 * @return string The content with ExactDN image urls.
	 */
	function filter_the_content( $content ) {
		$started = microtime( true );
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$images = $this->get_images_from_html( $content, true );

		if ( ! empty( $images ) ) {
			ewwwio_debug_message( 'we have images to parse' );
			$content_width = false;
			if ( ! $this->filtering_the_page ) {
				$this->filtering_the_content = true;
				ewwwio_debug_message( 'filtering the content' );
				$content_width = $this->get_content_width();
			}
			$resize_existing = defined( 'EXACTDN_RESIZE_EXISTING' ) && EXACTDN_RESIZE_EXISTING;

			$image_sizes = $this->image_sizes();

			foreach ( $images[0] as $index => $tag ) {
				// Default to resize, though fit may be used in certain cases where a dimension cannot be ascertained.
				$transform = 'resize';

				// Start with a clean slate each time.
				$attachment_id = false;
				$exactdn_url   = false;
				$width         = false;

				// Flag if we need to munge a fullsize URL.
				$fullsize_url = false;

				// Identify image source.
				$src      = $images['img_url'][ $index ];
				$src_orig = $images['img_url'][ $index ];
				ewwwio_debug_message( $src );

				/**
				 * Allow specific images to be skipped by ExactDN.
				 *
				 * @param bool false Should ExactDN ignore this image. Default false.
				 * @param string $src Image URL.
				 * @param string $tag Image HTML Tag.
				 */
				if ( apply_filters( 'exactdn_skip_image', false, $src, $tag ) ) {
					continue;
				}

				ewwwio_debug_message( 'made it passed the filters' );
				// Support Lazy Load plugins.
				// Don't modify $tag yet as we need unmodified version later.
				if ( preg_match( '#data-lazy-src=["|\'](.+?)["|\']#i', $images['img_tag'][ $index ], $lazy_load_src ) ) {
					$placeholder_src      = $src;
					$placeholder_src_orig = $src;
					$src                  = $lazy_load_src[1];
					$src_orig             = $lazy_load_src[1];
				} elseif ( preg_match( '#data-lazy-original=["|\'](.+?)["|\']#i', $images['img_tag'][ $index ], $lazy_load_src ) ) {
					$placeholder_src      = $src;
					$placeholder_src_orig = $src;
					$src                  = $lazy_load_src[1];
					$src_orig             = $lazy_load_src[1];
				} elseif ( strpos( $images['img_tag'][ $index ], 'a3-lazy-load/assets/images/lazy_placeholder' ) && preg_match( '#data-src=["|\'](.+?)["|\']#i', $images['img_tag'][ $index ], $lazy_load_src ) ) {
					$placeholder_src      = $src;
					$placeholder_src_orig = $src;
					$src                  = $lazy_load_src[1];
					$src_orig             = $lazy_load_src[1];
				}

				// Check if image URL should be used with ExactDN.
				if ( $this->validate_image_url( $src ) ) {
					ewwwio_debug_message( 'url validated' );

					// Find the width and height attributes.
					$width  = $this->get_img_width( $images['img_tag'][ $index ] );
					$height = $this->get_attribute( $images['img_tag'][ $index ], 'height' );
					// Falsify them if empty.
					$width  = $width ? $width : false;
					$height = $height ? $height : false;

					// Can't pass both a relative width and height, so unset the dimensions in favor of not breaking the horizontal layout.
					if ( false !== strpos( $width, '%' ) && false !== strpos( $height, '%' ) ) {
						$width  = false;
						$height = false;
					}

					// Detect WP registered image size from HTML class.
					if ( preg_match( '#class=["|\']?[^"\']*size-([^"\'\s]+)[^"\']*["|\']?#i', $images['img_tag'][ $index ], $size ) ) {
						$size = array_pop( $size );

						ewwwio_debug_message( "detected $size" );
						if ( false === $width && false === $height && 'full' != $size && array_key_exists( $size, $image_sizes ) ) {
							$width     = (int) $image_sizes[ $size ]['width'];
							$height    = (int) $image_sizes[ $size ]['height'];
							$transform = $image_sizes[ $size ]['crop'] ? 'resize' : 'fit';
						}
					} else {
						unset( $size );
					}

					list( $filename_width, $filename_height ) = $this->get_dimensions_from_filename( $src );
					// WP Attachment ID, if uploaded to this site.
					preg_match( '#class=["|\']?[^"\']*wp-image-([\d]+)[^"\']*["|\']?#i', $images['img_tag'][ $index ], $attachment_id );
					if ( ! ewww_image_optimizer_get_option( 'exactdn_prevent_db_queries' ) && empty( $attachment_id ) ) {
						ewwwio_debug_message( 'looking for attachment id' );
						$attachment_id = array( attachment_url_to_postid( $src ) );
					}
					if ( ! ewww_image_optimizer_get_option( 'exactdn_prevent_db_queries' ) && ! empty( $attachment_id ) ) {
						ewwwio_debug_message( 'using attachment id to get source image' );
						$attachment_id = intval( array_pop( $attachment_id ) );

						if ( $attachment_id ) {
							ewwwio_debug_message( "detected attachment $attachment_id" );
							$attachment = get_post( $attachment_id );

							// Basic check on returned post object.
							if ( is_object( $attachment ) && ! is_wp_error( $attachment ) && 'attachment' == $attachment->post_type ) {
								$src_per_wp = wp_get_attachment_image_src( $attachment_id, 'full' );

								if ( $src_per_wp && is_array( $src_per_wp ) ) {
									ewwwio_debug_message( "src retrieved from db: {$src_per_wp[0]}, checking for match" );
									$fullsize_url_path = $this->parse_url( $src_per_wp[0], PHP_URL_PATH );
									if ( is_null( $fullsize_url_path ) ) {
										$src_per_wp = false;
									} elseif ( $fullsize_url_path ) {
										$fullsize_url_basename = pathinfo( $fullsize_url_path, PATHINFO_FILENAME );
										ewwwio_debug_message( "looking for $fullsize_url_basename in $src" );
										if ( strpos( wp_basename( $src ), $fullsize_url_basename ) === false ) {
											ewwwio_debug_message( 'fullsize url does not match' );
											$src_per_wp = false;
										}
									} else {
										$src_per_wp = false;
									}
								}

								if ( $src_per_wp && $this->validate_image_url( $src_per_wp[0] ) ) {
									ewwwio_debug_message( "detected $width filenamew $filename_width" );
									if ( $resize_existing || ( $width && $filename_width != $width ) ) {
										ewwwio_debug_message( 'resizing existing or width does not match' );
										$src = $src_per_wp[0];
									}
									$fullsize_url = true;

									// Prevent image distortion if a detected dimension exceeds the image's natural dimensions.
									if ( ( false !== $width && $width > $src_per_wp[1] ) || ( false !== $height && $height > $src_per_wp[2] ) ) {
										$width  = false === $width ? false : min( $width, $src_per_wp[1] );
										$height = false === $height ? false : min( $height, $src_per_wp[2] );
									}

									// If no width and height are found, max out at source image's natural dimensions.
									// Otherwise, respect registered image sizes' cropping setting.
									if ( false === $width && false === $height ) {
										$width     = $src_per_wp[1];
										$height    = $src_per_wp[2];
										$transform = 'fit';
									} elseif ( isset( $size ) && array_key_exists( $size, $image_sizes ) && isset( $image_sizes[ $size ]['crop'] ) ) {
										$transform = (bool) $image_sizes[ $size ]['crop'] ? 'resize' : 'fit';
									}
								}
							} else {
								unset( $attachment_id );
								unset( $attachment );
							}
						}
					}

					// If width is available, constrain to $content_width.
					if ( false !== $width && false === strpos( $width, '%' ) && is_numeric( $content_width ) ) {
						if ( $width > $content_width && false !== $height && false === strpos( $height, '%' ) ) {
							ewwwio_debug_message( 'constraining to content width' );
							$height = round( ( $content_width * $height ) / $width );
							$width  = $content_width;
						} elseif ( $width > $content_width ) {
							ewwwio_debug_message( 'constraining to content width' );
							$width = $content_width;
						}
					}

					// Set a width if none is found and $content_width is available.
					// If width is set in this manner and height is available, use `fit` instead of `resize` to prevent skewing.
					if ( false === $width && is_numeric( $content_width ) ) {
						$width = (int) $content_width;

						if ( false !== $height ) {
							$transform = 'fit';
						}
					}

					// Detect if image source is for a custom-cropped thumbnail and prevent further URL manipulation.
					if ( ! $fullsize_url && preg_match_all( '#-e[a-z0-9]+(-\d+x\d+)?\.(' . implode( '|', $this->extensions ) . '){1}$#i', wp_basename( $src ), $filename ) ) {
						$fullsize_url = true;
					}

					// Build array of ExactDN args and expose to filter before passing to ExactDN URL function.
					$args = array();

					if ( false !== $width && false !== $height && false === strpos( $width, '%' ) && false === strpos( $height, '%' ) ) {
						$args[ $transform ] = $width . ',' . $height;
					} elseif ( false !== $width ) {
						$args['w'] = $width;
					} elseif ( false !== $height ) {
						$args['h'] = $height;
					}

					if ( ! $resize_existing && ( ! $width || $filename_width == $width ) ) {
						ewwwio_debug_message( 'preventing resize' );
						$args = array();
					} elseif ( ! $fullsize_url ) {
						// Build URL, first maybe removing WP's resized string so we pass the original image to ExactDN (for higher quality).
						$src = $this->strip_image_dimensions_maybe( $src );
					}

					if ( ! ewww_image_optimizer_get_option( 'exactdn_prevent_db_queries' ) && ! empty( $attachment_id ) ) {
						ewwwio_debug_message( 'using attachment id to check smart crop' );
						$args = $this->maybe_smart_crop( $args, $attachment_id );
					}

					/**
					 * Filter the array of ExactDN arguments added to an image.
					 * By default, only includes width and height values.
					 *
					 * @param array $args Array of ExactDN Arguments.
					 * @param array $args {
					 *     Array of image details.
					 *
					 *     @type $tag Image tag (Image HTML output).
					 *     @type $src Image URL.
					 *     @type $src_orig Original Image URL.
					 *     @type $width Image width.
					 *     @type $height Image height.
					 * }
					 */
					$args = apply_filters( 'exactdn_post_image_args', $args, compact( 'tag', 'src', 'src_orig', 'width', 'height' ) );
					ewwwio_debug_message( "width $width" );
					ewwwio_debug_message( "height $height" );
					ewwwio_debug_message( "transform $transform" );

					$exactdn_url = $this->generate_url( $src, $args );
					ewwwio_debug_message( "new url $exactdn_url" );

					// Modify image tag if ExactDN function provides a URL
					// Ensure changes are only applied to the current image by copying and modifying the matched tag, then replacing the entire tag with our modified version.
					if ( $src != $exactdn_url ) {
						$new_tag = $tag;

						// If present, replace the link href with an ExactDN URL for the full-size image.
						if ( ! empty( $images['link_url'][ $index ] ) && $this->validate_image_url( $images['link_url'][ $index ] ) ) {
							$new_tag = preg_replace( '#(href=["|\'])' . $images['link_url'][ $index ] . '(["|\'])#i', '\1' . $this->generate_url( $images['link_url'][ $index ] ) . '\2', $new_tag, 1 );
						}

						// Insert new image src into the srcset as well, if we have a width.
						if ( false !== $width && false === strpos( $width, '%' ) ) {
							ewwwio_debug_message( 'checking to see if srcset width already exists' );
							$srcset_url = $exactdn_url . ' ' . (int) $width . 'w, ';
							if ( false === strpos( $tag, $width . 'w' ) ) {
								// For double-quotes...
								$new_tag = str_replace( 'srcset="', 'srcset="' . $srcset_url, $new_tag );
								// and for single-quotes.
								$new_tag = str_replace( "srcset='", "srcset='" . $srcset_url, $new_tag );
							}
						}

						// Supplant the original source value with our ExactDN URL.
						$exactdn_url = str_replace( '&#038;', '&', esc_url( $exactdn_url ) );
						$new_tag     = str_replace( $src_orig, $exactdn_url, $new_tag );

						// If Lazy Load is in use, pass placeholder image through ExactDN.
						if ( isset( $placeholder_src ) && $this->validate_image_url( $placeholder_src ) ) {
							$placeholder_src = $this->generate_url( $placeholder_src );

							if ( $placeholder_src != $placeholder_src_orig ) {
								$new_tag = str_replace( $placeholder_src_orig, str_replace( '&#038;', '&', esc_url( $placeholder_src ) ), $new_tag );
							}

							unset( $placeholder_src );
						}

						// Replace original tag with modified version.
						$content = str_replace( $tag, $new_tag, $content );
					}
				} elseif ( ! preg_match( '#data-lazy-(original|src)=#i', $images['img_tag'][ $index ] ) && $this->validate_image_url( $src, true ) ) {
					ewwwio_debug_message( 'found a potential exactdn src url to insert into srcset' );
					// Find the width attribute.
					$width = $this->get_img_width( $images['img_tag'][ $index ] );
					if ( $width ) {
						ewwwio_debug_message( 'found the width' );
						// Insert new image src into the srcset as well, if we have a width.
						if (
							false !== $width &&
							false === strpos( $width, '%' ) &&
							false !== strpos( $src, $width ) &&
							false !== strpos( $src, $this->exactdn_domain )
						) {
							$new_tag     = $tag;
							$exactdn_url = $src;
							ewwwio_debug_message( 'checking to see if srcset width already exists' );
							$srcset_url = $exactdn_url . ' ' . (int) $width . 'w, ';
							if ( false === strpos( $tag, $width . 'w' ) ) {
								ewwwio_debug_message( 'src not in srcset, adding' );
								// For double-quotes...
								$new_tag = str_replace( 'srcset="', 'srcset="' . $srcset_url, $new_tag );
								// and for single-quotes.
								$new_tag = str_replace( "srcset='", "srcset='" . $srcset_url, $new_tag );
								// Replace original tag with modified version.
								$content = str_replace( $tag, $new_tag, $content );
							}
						}
					}
				} // End if().
				// At this point, we discard the original src in favor of the ExactDN url.
				if ( ! empty( $exactdn_url ) ) {
					$src = $exactdn_url;
				}
				if ( ! ewww_image_optimizer_get_option( 'exactdn_prevent_srcset_fill' ) && ! preg_match( '#data-lazy-(original|src)=#i', $images['img_tag'][ $index ] ) && false !== strpos( $src, $this->exactdn_domain ) ) {
					if ( ! $this->get_attribute( $images['img_tag'][ $index ], 'srcset' ) && ! $this->get_attribute( $images['img_tag'][ $index ], 'sizes' ) ) {
						$zoom = false;
						// If $width is empty, we'll search the url for a width param, then we try searching the img element, with fall back to the filename.
						if ( empty( $width ) ) {
							// This only searches for w, resize, or fit flags, others are ignored.
							$width = $this->get_exactdn_width_from_url( $src );
							if ( $width ) {
								$zoom = true;
							}
						}
						if ( empty( $width ) ) {
							$width = $this->get_img_width( $images['img_tag'][ $index ] );
						}
						if ( empty( $width ) ) {
							list( $width, $discard_height ) = $this->get_dimensions_from_filename( $src );
						}
						if ( false !== strpos( $src, 'crop=' ) || false !== strpos( $src, '&h=' ) || false !== strpos( $src, '?h=' ) ) {
							$width = false;
						}
						// Then add a srcset and sizes.
						if ( $width ) {
							$srcset = $this->generate_image_srcset( $src, $width, $zoom );
							if ( $srcset ) {
								$new_tag = $images['img_tag'][ $index ];
								$this->set_attribute( $new_tag, 'srcset', $srcset );
								$this->set_attribute( $new_tag, 'sizes', sprintf( '(max-width: %1$dpx) 100vw, %1$dpx', $width ) );
								// Replace original tag with modified version.
								$content = str_replace( $images['img_tag'][ $index ], $new_tag, $content );
							}
						}
					}
				}
			} // End foreach().
		} // End if();
		if ( $this->filtering_the_page && ewww_image_optimizer_get_option( 'exactdn_all_the_things' ) ) {
			ewwwio_debug_message( 'rewriting all other wp_content urls' );
			if ( $this->exactdn_domain && $this->upload_domain ) {
				$escaped_upload_domain = str_replace( '.', '\.', ltrim( $this->upload_domain, 'w.' ) );
				ewwwio_debug_message( $escaped_upload_domain );
				if ( ! empty( $this->user_exclusions ) ) {
					$content = preg_replace( '#(https?)://(?:www\.)?' . $escaped_upload_domain . '([^"\'?>]+?)?/wp-content/([^"\'?>]+?)?(' . implode( '|', $this->user_exclusions ) . ')#i', '$1://' . $this->upload_domain . '$2/?wpcontent-bypass?/$3$4', $content );
				}
				// Pre-empt rewriting of simple-social-icons SVG (because they aren't allowed in use tags.
				$content = preg_replace( '#(https?)://(?:www\.)?' . $escaped_upload_domain . '([^"\'?>]+?)?/wp-content/plugins/simple-social-icons#i', '$1://' . $this->upload_domain . '$2/?wpcontent-bypass?/plugins/simple-social-icons', $content );
				// Pre-empt rewriting of wp-includes and wp-content if the extension is not allowed by using a temporary placeholder.
				$content = preg_replace( '#(https?)://(?:www\.)?' . $escaped_upload_domain . '([^"\'?>]+?)?/wp-content/([^"\'?>]+?)\.(php|ashx|m4v|mov|wvm|qt|webm|ogv|mp4|m4p|mpg|mpeg|mpv)#i', '$1://' . $this->upload_domain . '$2/?wpcontent-bypass?/$3.$4', $content );
				$content = str_replace( 'wp-content/themes/jupiter"', '?wpcontent-bypass?/themes/jupiter"', $content );
				$content = preg_replace( '#(https?)://(?:www\.)?' . $escaped_upload_domain . '/([^"\'?>]+?)?(nextgen-image|wp-includes|wp-content)/#i', '$1://' . $this->exactdn_domain . '/$2$3/', $content );
				$content = str_replace( '?wpcontent-bypass?', 'wp-content', $content );
			}
		}
		ewwwio_debug_message( 'done parsing page' );
		$this->filtering_the_content = false;

		$elapsed_time = microtime( true ) - $started;
		ewwwio_debug_message( "parsing the_content took $elapsed_time seconds" );
		$this->elapsed_time += microtime( true ) - $started;
		ewwwio_debug_message( "parsing the page took $this->elapsed_time seconds so far" );
		if ( $this->elapsed_time > .5 ) {
			ewww_image_optimizer_set_option( 'exactdn_prevent_db_queries', true );
		}
		return $content;
	}

	/**
	 * Allow resizing of images for some admin-ajax requests.
	 *
	 * @param bool  $allow Will normally be false, unless already modified by another function.
	 * @param array $image Bunch of information about the image, but we don't care about that here.
	 * @return bool True if it's an allowable admin-ajax request, false for all other admin requests.
	 */
	function allow_admin_image_downsize( $allow, $image ) {
		if ( ! wp_doing_ajax() ) {
			return $allow;
		}
		if ( ! empty( $_POST['action'] ) && 'eddvbugm_viewport_downloads' == $_POST['action'] ) {
			return true;
		}
		if ( ! empty( $_POST['action'] ) && 'vc_get_vc_grid_data' == $_POST['action'] ) {
			return true;
		}
		if ( ! empty( $_POST['action'] ) && 'Essential_Grid_Front_request_ajax' == $_POST['action'] ) {
			return true;
		}
		return $allow;
	}

	/**
	 * Disable resizing of images during image_downsize().
	 *
	 * @param mixed $param Could be anything (or nothing), we just pass it along untouched.
	 * @return mixed Just the same value, going back out the door.
	 */
	function disable_image_downsize( $param = false ) {
		remove_filter( 'image_downsize', array( $this, 'filter_image_downsize' ) );
		add_action( 'themify_after_post_image', array( $this, 'enable_image_downsize' ) );
		return $param;
	}

	/**
	 * Re-enable resizing of images during image_downsize().
	 */
	function enable_image_downsize() {
		add_filter( 'image_downsize', array( $this, 'filter_image_downsize' ), 10, 3 );
	}

	/**
	 * Filter post thumbnail image retrieval, passing images through ExactDN.
	 *
	 * @param array|bool   $image Defaults to false, but may be a url if another plugin/theme has already filtered the value.
	 * @param int          $attachment_id The ID number for the image attachment.
	 * @param string|array $size The name of the image size or an array of width and height. Default 'medium'.
	 * @uses is_admin, apply_filters, wp_get_attachment_url, this::validate_image_url, this::image_sizes, this::generate_url
	 * @filter image_downsize
	 * @return string|bool
	 */
	function filter_image_downsize( $image, $attachment_id, $size ) {
		$started = microtime( true );
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		// Don't foul up the admin side of things, unless a plugin wants to.
		if ( is_admin() &&
			/**
			 * Provide plugins a way of running ExactDN for images in the WordPress Dashboard (wp-admin).
			 *
			 * Note: enabling this will result in ExactDN URLs added to your post content, which could make migrations across domains (and off ExactDN) a bit more challenging.
			 *
			 * @param bool false Stop ExactDN from being run on the Dashboard. Default to false.
			 * @param array $args {
			 *     Array of image details.
			 *
			 *     @type array|bool  $image Image URL or false.
			 *     @type int          $attachment_id Attachment ID of the image.
			 *     @type array|string $size Image size. Can be a string (name of the image size, e.g. full) or an array of height and width.
			 * }
			 */
			false === apply_filters( 'exactdn_admin_allow_image_downsize', false, compact( 'image', 'attachment_id', 'size' ) )
		) {
			return $image;
		}

		/**
		 * Provide plugins a way of preventing ExactDN from being applied to images retrieved from WordPress Core.
		 *
		 * @param bool false Stop ExactDN from being applied to the image. Default to false.
		 * @param array $args {
		 *     Array of image details.
		 *
		 *     @type string|bool  $image Image URL or false.
		 *     @type int          $attachment_id Attachment ID of the image.
		 *     @type array|string $size Image size. Can be a string (name of the image size, e.g. full) or an array of height and width.
		 * }
		 */
		if ( apply_filters( 'exactdn_override_image_downsize', false, compact( 'image', 'attachment_id', 'size' ) ) ) {
			return $image;
		}

		if ( function_exists( 'aq_resize' ) ) {
			ewwwio_debug_message( 'aq_resize detected, image_downsize filter disabled' );
			return $image;
		}

		if ( $this->filtering_the_content || $this->filtering_the_page ) {
			ewwwio_debug_message( 'end image_downsize early' );
			return $image;
		}

		// Get the image URL and proceed with ExactDN replacement if successful.
		$image_url = wp_get_attachment_url( $attachment_id );
		ewwwio_debug_message( $image_url );
		ewwwio_debug_message( $attachment_id );
		if ( is_string( $size ) || is_int( $size ) ) {
			ewwwio_debug_message( $size );
		} elseif ( is_array( $size ) ) {
			foreach ( $size as $dimension ) {
				ewwwio_debug_message( 'dimension: ' . $dimension );
			}
		}
		// Set this to true later when we know we have size meta.
		$has_size_meta = false;

		if ( $image_url ) {
			// Check if image URL should be used with ExactDN.
			if ( ! $this->validate_image_url( $image_url ) ) {
				return $image;
			}

			$intermediate    = true; // For the fourth array item returned by the image_downsize filter.
			$resize_existing = defined( 'EXACTDN_RESIZE_EXISTING' ) && EXACTDN_RESIZE_EXISTING;

			// If an image is requested with a size known to WordPress, use that size's settings with ExactDN.
			if ( is_string( $size ) && array_key_exists( $size, $this->image_sizes() ) ) {
				$image_args = $this->image_sizes();
				$image_args = $image_args[ $size ];

				$exactdn_args = array();

				$image_meta = image_get_intermediate_size( $attachment_id, $size );

				// 'full' is a special case: We need consistent data regardless of the requested size.
				if ( 'full' === $size ) {
					$image_meta   = wp_get_attachment_metadata( $attachment_id );
					$intermediate = false;
				} elseif ( ! $image_meta ) {
					// If we still don't have any image meta at this point, it's probably from a custom thumbnail size
					// for an image that was uploaded before the custom image was added to the theme. Try to determine the size manually.
					$image_meta = wp_get_attachment_metadata( $attachment_id );

					if ( isset( $image_meta['width'], $image_meta['height'] ) ) {
						$image_resized = image_resize_dimensions( $image_meta['width'], $image_meta['height'], $image_args['width'], $image_args['height'], $image_args['crop'] );
						if ( $image_resized ) { // This could be false when the requested image size is larger than the full-size image.
							$image_meta['width']  = $image_resized[6];
							$image_meta['height'] = $image_resized[7];
						}
					}
				}

				if ( isset( $image_meta['width'], $image_meta['height'] ) ) {
					$image_args['width']  = $image_meta['width'];
					$image_args['height'] = $image_meta['height'];

					list( $image_args['width'], $image_args['height'] ) = image_constrain_size_for_editor( $image_args['width'], $image_args['height'], $size, 'display' );

					$has_size_meta = true;
				}

				// Expose determined arguments to a filter before passing to ExactDN.
				$transform = $image_args['crop'] ? 'resize' : 'fit';

				// Check specified image dimensions and account for possible zero values; ExactDN fails to resize if a dimension is zero.
				if ( 0 == $image_args['width'] || 0 == $image_args['height'] ) {
					if ( 0 == $image_args['width'] && 0 < $image_args['height'] ) {
						$exactdn_args['h'] = $image_args['height'];
					} elseif ( 0 == $image_args['height'] && 0 < $image_args['width'] ) {
						$exactdn_args['w'] = $image_args['width'];
					}
				} else {
					$image_meta = wp_get_attachment_metadata( $attachment_id );
					if ( ( 'resize' === $transform ) && $image_meta ) {
						if ( isset( $image_meta['width'], $image_meta['height'] ) ) {
							// Lets make sure that we don't upscale images since wp never upscales them as well.
							$smaller_width  = ( ( $image_meta['width'] < $image_args['width'] ) ? $image_meta['width'] : $image_args['width'] );
							$smaller_height = ( ( $image_meta['height'] < $image_args['height'] ) ? $image_meta['height'] : $image_args['height'] );

							$exactdn_args[ $transform ] = $smaller_width . ',' . $smaller_height;
						}
					} else {
						$exactdn_args[ $transform ] = $image_args['width'] . ',' . $image_args['height'];
					}
				}

				if ( ! empty( $image_meta['sizes'] ) && 'full' !== $size && ! empty( $image_meta['sizes'][ $size ]['file'] ) ) {
					$image_url_basename = wp_basename( $image_url );
					$intermediate_url   = str_replace( $image_url_basename, $image_meta['sizes'][ $size ]['file'], $image_url );

					list( $filename_width, $filename_height ) = $this->get_dimensions_from_filename( $intermediate_url );
					if ( $filename_width && $filename_height && $image_args['width'] === $filename_width && $image_args['height'] === $filename_height ) {
						$image_url = $intermediate_url;
					} else {
						$resize_existing = true;
					}
				} else {
					$resize_existing = true;
				}

				$exactdn_args = $this->maybe_smart_crop( $exactdn_args, $attachment_id, $image_meta );

				/**
				 * Filter the ExactDN arguments added to an image, when that image size is a string.
				 * Image size will be a string (e.g. "full", "medium") when it is known to WordPress.
				 *
				 * @param array $exactdn_args ExactDN arguments.
				 * @param array  $args {
				 *     Array of image details.
				 *
				 *     @type array  $image_args Image arguments (width, height, crop).
				 *     @type string $image_url Image URL.
				 *     @type int    $attachment_id Attachment ID of the image.
				 *     @type string $size Image size name.
				 *     @type string $transform Value can be resize or fit.
				 * }
				 */
				$exactdn_args = apply_filters( 'exactdn_image_downsize_string', $exactdn_args, compact( 'image_args', 'image_url', 'attachment_id', 'size', 'transform' ) );

				// Generate ExactDN URL.
				if ( ! $resize_existing ) {
					$image = array(
						$this->generate_url( $image_url ),
						$has_size_meta ? $image_args['width'] : false,
						$has_size_meta ? $image_args['height'] : false,
						$intermediate,
					);
				} else {
					$image = array(
						$this->generate_url( $image_url, $exactdn_args ),
						$has_size_meta ? $image_args['width'] : false,
						$has_size_meta ? $image_args['height'] : false,
						$intermediate,
					);
				}
			} elseif ( is_array( $size ) ) {
				// Pull width and height values from the provided array, if possible.
				$width  = isset( $size[0] ) ? (int) $size[0] : false;
				$height = isset( $size[1] ) ? (int) $size[1] : false;

				// Don't bother if necessary parameters aren't passed.
				if ( ! $width || ! $height ) {
					return $image;
				}
				ewwwio_debug_message( "requested w$width by h$height" );

				$image_meta = wp_get_attachment_metadata( $attachment_id );
				if ( isset( $image_meta['width'], $image_meta['height'] ) ) {
					$image_resized = image_resize_dimensions( $image_meta['width'], $image_meta['height'], $width, $height, true );

					if ( $image_resized ) { // This could be false when the requested image size is larger than the full-size image.
						$width  = $image_resized[6];
						$height = $image_resized[7];
						ewwwio_debug_message( "using resize dims w$width by h$height" );
					} else {
						$width  = $image_meta['width'];
						$height = $image_meta['height'];
						ewwwio_debug_message( "using meta dims w$width by h$height" );
					}
					$has_size_meta = true;
				}

				list( $width, $height ) = image_constrain_size_for_editor( $width, $height, $size );
				ewwwio_debug_message( "constrained to w$width by h$height" );

				// Expose arguments to a filter before passing to ExactDN.
				$exactdn_args = array(
					'fit' => $width . ',' . $height,
				);

				$exactdn_args = $this->maybe_smart_crop( $exactdn_args, $attachment_id, $image_meta );

				/**
				 * Filter the ExactDN arguments added to an image, when the image size is an array of height and width values.
				 *
				 * @param array $exactdn_args ExactDN arguments/parameters.
				 * @param array $args {
				 *     Array of image details.
				 *
				 *     @type int    $width Image width.
				 *     @type int    $height Image height.
				 *     @type string $image_url Image URL.
				 *     @type int    $attachment_id Attachment ID of the image.
				 * }
				 */
				$exactdn_args = apply_filters( 'exactdn_image_downsize_array', $exactdn_args, compact( 'width', 'height', 'image_url', 'attachment_id' ) );

				// Generate ExactDN URL.
				$image = array(
					$this->generate_url( $image_url, $exactdn_args ),
					$has_size_meta ? $width : false,
					$has_size_meta ? $height : false,
					$intermediate,
				);
			}
		}
		if ( ! empty( $image[0] ) && is_string( $image[0] ) ) {
			ewwwio_debug_message( $image[0] );
		}
		ewwwio_debug_message( 'end image_downsize' );
		$elapsed_time = microtime( true ) - $started;
		ewwwio_debug_message( "parsing image_downsize took $elapsed_time seconds" );
		$this->elapsed_time += microtime( true ) - $started;
		return $image;
	}

	/**
	 * Filters an array of image `srcset` values, replacing each URL with its ExactDN equivalent.
	 *
	 * @param array  $sources An array of image urls and widths.
	 * @param array  $size_array Array of width and height values in pixels.
	 * @param string $image_src The 'src' of the image.
	 * @param array  $image_meta The image metadata as returned by 'wp_get_attachment_metadata()'.
	 * @param int    $attachment_id Image attachment ID or 0.
	 * @uses this::validate_image_url, this::generate_url, this::parse_from_filename
	 * @uses this::strip_image_dimensions_maybe, this::get_content_width
	 * @return array An array of ExactDN image urls and widths.
	 */
	public function filter_srcset_array( $sources = array(), $size_array = array(), $image_src = '', $image_meta = array(), $attachment_id = 0 ) {
		$started = microtime( true );
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		// Don't foul up the admin side of things, unless a plugin wants to.
		if ( is_admin() &&
			/**
			 * Provide plugins a way of running ExactDN for images in the WordPress Dashboard (wp-admin).
			 *
			 * @param bool false Stop ExactDN from being run on the Dashboard. Default to false, use true to run in wp-admin.
			 * @param array $args {
			 *     Array of image details.
			 *
			 *     @type string|bool  $image Image URL or false.
			 *     @type int          $attachment_id Attachment ID of the image.
			 * }
			 */
			false === apply_filters( 'exactdn_admin_allow_image_srcset', false, compact( 'image_src', 'attachment_id' ) )
		) {
			return $sources;
		}
		if ( ! is_array( $sources ) ) {
			return $sources;
		}
		$upload_dir      = wp_get_upload_dir();
		$resize_existing = defined( 'EXACTDN_RESIZE_EXISTING' ) && EXACTDN_RESIZE_EXISTING;

		foreach ( $sources as $i => $source ) {
			if ( ! $this->validate_image_url( $source['url'] ) ) {
				continue;
			}

			/** This filter is already documented in class-exactdn.php */
			if ( apply_filters( 'exactdn_skip_image', false, $source['url'], $source ) ) {
				continue;
			}

			$url = $source['url'];

			list( $width, $height ) = $this->get_dimensions_from_filename( $url );
			if ( ! $resize_existing && 'w' === $source['descriptor'] && $source['value'] == $width ) {
				ewwwio_debug_message( "preventing further processing for $url" );
				$sources[ $i ]['url'] = $this->generate_url( $source['url'] );
				continue;
			}
			ewwwio_debug_message( 'continuing: ' . $width . ' vs. ' . $source['value'] );

			// It's quicker to get the full size with the data we have already, if available.
			if ( ! empty( $attachment_id ) ) {
				$url = wp_get_attachment_url( $attachment_id );
			} else {
				$url = $this->strip_image_dimensions_maybe( $url );
			}
			ewwwio_debug_message( "building srcs from $url" );

			$args = array();
			if ( 'w' === $source['descriptor'] ) {
				if ( $height && ( $source['value'] == $width ) ) {
					$args['resize'] = $width . ',' . $height;
				} else {
					$args['w'] = $source['value'];
				}
			}

			$args = $this->maybe_smart_crop( $args, $attachment_id, $image_meta );

			$sources[ $i ]['url'] = $this->generate_url( $url, $args );
		}

		/**
		 * At this point, $sources is the original srcset with ExactDN URLs.
		 * Now, we're going to construct additional sizes based on multiples of the content_width.
		 * TODO: Then we will also insert additional sizes from the ExactDN feedback loop.
		 * This will reduce the gap between the largest defined size and the original image.
		 */

		/**
		 * Filter the multiplier ExactDN uses to create new srcset items.
		 * Return false to short-circuit and bypass auto-generation.
		 *
		 * @param array|bool $multipliers Array of multipliers to use or false to bypass.
		 */
		$multipliers = apply_filters( 'exactdn_srcset_multipliers', array( .2, .4, .6, .8, 1, 2, 3 ) );
		$url         = trailingslashit( $upload_dir['baseurl'] ) . $image_meta['file'];

		if (
			/** Short-circuit via exactdn_srcset_multipliers filter. */
			is_array( $multipliers )
			/** This filter is already documented in class-exactdn.php */
			&& ! apply_filters( 'exactdn_skip_image', false, $url, null )
			/** The original url is valid/allowed. */
			&& $this->validate_image_url( $url )
			/** Verify basic meta is intact. */
			&& isset( $image_meta['width'] ) && isset( $image_meta['height'] ) && isset( $image_meta['file'] )
			/** Verify we have the requested width/height. */
			&& isset( $size_array[0] ) && isset( $size_array[1] )
			) {

			$fullwidth  = $image_meta['width'];
			$fullheight = $image_meta['height'];
			$reqwidth   = $size_array[0];
			$reqheight  = $size_array[1];
			ewwwio_debug_message( "requested w $reqwidth h $reqheight full w $fullwidth full h $fullheight" );

			$constrained_size = wp_constrain_dimensions( $fullwidth, $fullheight, $reqwidth );
			$expected_size    = array( $reqwidth, $reqheight );

			ewwwio_debug_message( $constrained_size[0] );
			ewwwio_debug_message( $constrained_size[1] );
			if ( abs( $constrained_size[0] - $expected_size[0] ) <= 1 && abs( $constrained_size[1] - $expected_size[1] ) <= 1 ) {
				$crop = 'soft';
				$base = $this->get_content_width() ? $this->get_content_width() : 1900; // Provide a default width if none set by the theme.
			} else {
				$crop = 'hard';
				$base = $reqwidth;
			}
			ewwwio_debug_message( "base width: $base" );

			$currentwidths = array_keys( $sources );
			$newsources    = null;

			foreach ( $multipliers as $multiplier ) {

				$newwidth = intval( $base * $multiplier );
				foreach ( $currentwidths as $currentwidth ) {
					// If a new width would be within 50 pixels of an existing one or larger than the full size image, skip.
					if ( abs( $currentwidth - $newwidth ) < 50 || ( $newwidth > $fullwidth ) ) {
						continue 2; // Back to the foreach ( $multipliers as $multiplier ).
					}
				} // foreach ( $currentwidths as $currentwidth ){

				if ( 'soft' == $crop ) {
					$args = array(
						'w' => $newwidth,
					);
				} else { // hard crop, e.g. add_image_size( 'example', 200, 200, true ).
					$args = array(
						'zoom'   => $multiplier,
						'resize' => $reqwidth . ',' . $reqheight,
					);
				}

				$args = $this->maybe_smart_crop( $args, $attachment_id, $image_meta );

				$newsources[ $newwidth ] = array(
					'url'        => $this->generate_url( $url, $args ),
					'descriptor' => 'w',
					'value'      => $newwidth,
				);
			} // foreach ( $multipliers as $multiplier )
			if ( is_array( $newsources ) ) {
				$sources = array_replace( $sources, $newsources );
			}
		} // if ( isset( $image_meta['width'] ) && isset( $image_meta['file'] ) )
		$elapsed_time = microtime( true ) - $started;
		ewwwio_debug_message( "parsing srcset took $elapsed_time seconds" );
		/* ewwwio_debug_message( print_r( $sources, true ) ); */
		$this->elapsed_time += microtime( true ) - $started;
		return $sources;
	}

	/**
	 * Filters an array of image `sizes` values, using $content_width instead of image's full size.
	 *
	 * @param array $sizes An array of media query breakpoints.
	 * @param array $size  Width and height of the image.
	 * @uses this::get_content_width
	 * @return array An array of media query breakpoints.
	 */
	public function filter_sizes( $sizes, $size ) {
		$started = microtime( true );
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( ! doing_filter( 'the_content' ) ) {
			return $sizes;
		}
		$content_width = $this->get_content_width();
		if ( ! $content_width ) {
			$content_width = 1900;
		}

		if ( ( is_array( $size ) && $size[0] < $content_width ) ) {
			return $sizes;
		}

		$elapsed_time = microtime( true ) - $started;
		ewwwio_debug_message( "parsing sizes took $elapsed_time seconds" );
		$this->elapsed_time += microtime( true ) - $started;
		return sprintf( '(max-width: %1$dpx) 100vw, %1$dpx', $content_width );
	}

	/**
	 * Creates an image `srcset` attribute based on the detected width.
	 *
	 * @param string $url The url of the image.
	 * @param int    $width Image width to use for calculations.
	 * @param bool   $zoom Whether to use zoom or w param.
	 * @uses this::validate_image_url, this::generate_url, this::parse_from_filename
	 * @uses this::strip_image_dimensions_maybe, this::get_content_width
	 * @return string A srcset attribute with ExactDN image urls and widths.
	 */
	public function generate_image_srcset( $url, $width, $zoom = false ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		// Don't foul up the admin side of things.
		if ( is_admin() ) {
			return '';
		}

		/**
		 * Filter the multiplier ExactDN uses to create new srcset items.
		 * Return false to short-circuit and bypass auto-generation.
		 *
		 * @param array|bool $multipliers Array of multipliers to use or false to bypass.
		 */
		$multipliers = apply_filters( 'exactdn_srcset_multipliers', array( .2, .4, .6, .8, 1, 2, 3 ) );
		/**
		 * Filter the width ExactDN will use to create srcset attribute.
		 * Return a falsy value to short-circuit and bypass srcset fill.
		 *
		 * @param int|bool $width The max width for this $url, or false to bypass.
		 */
		$width  = apply_filters( 'exactdn_srcset_fill_width', $width, $url );
		$srcset = '';

		if (
			/** Short-circuit via exactdn_srcset_multipliers filter. */
			is_array( $multipliers )
			&& $width
			/** This filter is already documented in class-exactdn.php */
			&& ! apply_filters( 'exactdn_skip_image', false, $url, null )
		) {
			$sources = null;

			foreach ( $multipliers as $multiplier ) {
				$newwidth = intval( $width * $multiplier );

				if ( $zoom ) {
					$args = array(
						'zoom' => $multiplier,
					);
				} else {
					$args = array(
						'w' => $newwidth,
					);
				}

				$sources[ $newwidth ] = array(
					'url'        => $this->generate_url( $url, $args ),
					'descriptor' => 'w',
					'value'      => $newwidth,
				);
			}
		}
		if ( ! empty( $sources ) ) {
			foreach ( $sources as $source ) {
				$srcset .= str_replace( ' ', '%20', $source['url'] ) . ' ' . $source['value'] . $source['descriptor'] . ', ';
			}
		}
		/* ewwwio_debug_message( print_r( $sources, true ) ); */
		return rtrim( $srcset, ', ' );
	}

	/**
	 * Check for smart-cropping plugin to adjust cropping parameters.
	 * Currently supports Theia Smart Thumbnails using the theiaSmartThumbnails_position meta.
	 *
	 * @param array $args The arguments that have been generated so far.
	 * @param int   $attachment_id The ID number for the current image.
	 * @param array $meta Optional. The attachment (image) metadata. Default false.
	 * @return array The arguments, possibly altered for smart cropping.
	 */
	function maybe_smart_crop( $args, $attachment_id, $meta = false ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( ! empty( $args['crop'] ) ) {
			ewwwio_debug_message( 'already cropped' );
			return $args;
		}
		// Doing something other than a hard crop, or we don't know what the ID is.
		if ( empty( $args['resize'] ) || empty( $attachment_id ) ) {
			ewwwio_debug_message( 'not resizing, so no custom crop' );
			return $args;
		}
		// TST is not active.
		if ( ! defined( 'TST_VERSION' ) ) {
			ewwwio_debug_message( 'no TST plugin' );
			return $args;
		}
		if ( ! class_exists( 'TstPostOptions' ) || ! defined( 'TstPostOptions::META_POSITION' ) ) {
			ewwwio_debug_message( 'no TstPostOptions class' );
			return $args;
		}
		if ( ! $meta || ! is_array( $meta ) || empty( $meta['sizes'] ) ) {
			// $focus_point = get_post_meta( $attachment_id, TstPostOptions::META_POSITION, true );
			$meta = wp_get_attachment_metadata( $attachment_id );
			if ( ! is_array( $meta ) || empty( $meta['width'] ) || empty( $meta['height'] ) ) {
				ewwwio_debug_message( 'unusable meta retrieved' );
				return $args;
			}
			$focus_point = TstPostOptions::get_meta( $attachment_id, $meta['width'], $meta['height'] );
		} elseif ( ! empty( $meta['tst_thumbnail_version'] ) ) {
			if ( empty( $meta['width'] ) || empty( $meta['height'] ) ) {
				ewwwio_debug_message( 'unusable meta passed' );
				return $args;
			}
			$focus_point = TstPostOptions::get_meta( $attachment_id, $meta['width'], $meta['height'] );
		} else {
			ewwwio_debug_message( 'unusable meta' );
			return $args;
		}
		if ( empty( $focus_point ) || ! is_array( $focus_point ) ) {
			ewwwio_debug_message( 'unusable focus point' );
			return $args;
		}

		$dimensions = explode( ',', $args['resize'] );

		$new_w = $dimensions[0];
		$new_h = $dimensions[1];
		ewwwio_debug_message( "full size dims: w{$meta['width']} h{$meta['height']}" );
		ewwwio_debug_message( "smart crop dims: w$new_w h$new_h" );
		if ( ! empty( $args['zoom'] ) ) {
			$new_w = round( $args['zoom'] * $new_w );
			$new_h = round( $args['zoom'] * $new_h );
			ewwwio_debug_message( "zooming: {$args['zoom']} w$new_w h$new_h" );
		}
		if ( ! $new_w || ! $new_h ) {
			ewwwio_debug_message( 'empty dimension, not cropping' );
			return $args;
		}
		$size_ratio = max( $new_w / $meta['width'], $new_h / $meta['height'] );
		$crop_w     = round( $new_w / $size_ratio );
		$crop_h     = round( $new_h / $size_ratio );
		$s_x        = floor( ( $meta['width'] - $crop_w ) * $focus_point[0] );
		$s_y        = floor( ( $meta['height'] - $crop_h ) * $focus_point[1] );
		ewwwio_debug_message( "doing the math with size_ratio of $size_ratio" );

		$args = array( 'crop' => $s_x . 'px,' . $s_y . 'px,' . $crop_w . 'px,' . $crop_h . 'px' ) + $args;
		ewwwio_debug_message( $args['crop'] );
		return $args;
	}

	/**
	 * Make sure the image domain is on the list of approved domains.
	 *
	 * @param string $domain The hostname to validate.
	 * @return bool True if the hostname is allowed, false otherwise.
	 */
	public function allow_image_domain( $domain ) {
		$domain = trim( $domain );
		foreach ( $this->allowed_domains as $allowed ) {
			$allowed = trim( $allowed );
			if ( $domain === $allowed ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Ensure image URL is valid for ExactDN.
	 * Though ExactDN functions address some of the URL issues, we should avoid unnecessary processing if we know early on that the image isn't supported.
	 *
	 * @param string $url The image url to be validated.
	 * @param bool   $exactdn_is_valid Optional. Whether an ExactDN URL should be considered valid. Default false.
	 * @uses wp_parse_args
	 * @return bool True if the url is considerd valid, false otherwise.
	 */
	protected function validate_image_url( $url, $exactdn_is_valid = false ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$parsed_url = $this->parse_url( $url );
		if ( ! $parsed_url ) {
			ewwwio_debug_message( 'could not parse' );
			return false;
		}

		// Parse URL and ensure needed keys exist, since the array returned by `parse_url` only includes the URL components it finds.
		$url_info = wp_parse_args(
			$parsed_url,
			array(
				'scheme' => null,
				'host'   => null,
				'port'   => null,
				'path'   => null,
			)
		);

		// Bail if scheme isn't http or port is set that isn't port 80.
		if (
			( 'http' != $url_info['scheme'] || ! in_array( $url_info['port'], array( 80, null ) ) ) &&
			/**
			 * Tells ExactDN to ignore images that are served via HTTPS.
			 *
			 * @param bool $reject_https Should ExactDN ignore images using the HTTPS scheme. Default to false.
			 */
			apply_filters( 'exactdn_reject_https', false )
		) {
			ewwwio_debug_message( 'rejected https via filter' );
			return false;
		}

		// Bail if no host is found.
		if ( is_null( $url_info['host'] ) ) {
			ewwwio_debug_message( 'null host' );
			return false;
		}

		// Bail if the image already went through ExactDN.
		if ( ! $exactdn_is_valid && $this->exactdn_domain === $url_info['host'] ) {
			ewwwio_debug_message( 'exactdn image' );
			return false;
		}

		// Bail if the image already went through Photon to avoid conflicts.
		if ( preg_match( '#^i[\d]{1}.wp.com$#i', $url_info['host'] ) ) {
			ewwwio_debug_message( 'photon/wp.com image' );
			return false;
		}

		// Bail if no path is found.
		if ( is_null( $url_info['path'] ) ) {
			ewwwio_debug_message( 'null path' );
			return false;
		}

		// Ensure image extension is acceptable, unless it's a dynamic NextGEN image.
		if ( ! in_array( strtolower( pathinfo( $url_info['path'], PATHINFO_EXTENSION ) ), $this->extensions ) && false === strpos( $url_info['path'], 'nextgen-image/' ) ) {
			ewwwio_debug_message( 'invalid extension' );
			return false;
		}

		// Make sure this is an allowed image domain/hostname for ExactDN on this site.
		if ( ! $this->allow_image_domain( $url_info['host'] ) ) {
			ewwwio_debug_message( 'invalid host for ExactDN' );
			return false;
		}

		// If we got this far, we should have an acceptable image URL,
		// but let folks filter to decline if they prefer.
		/**
		 * Overwrite the results of the previous validation steps an image goes through to be considered valid for ExactDN.
		 *
		 * @param bool true Is the image URL valid and can it be used by ExactDN. Default to true.
		 * @param string $url Image URL.
		 * @param array $parsed_url Array of information about the image url.
		 */
		return apply_filters( 'exactdn_validate_image_url', true, $url, $parsed_url );
	}

	/**
	 * Checks if the file exists before it passes the file to ExactDN.
	 *
	 * @param string $src The image URL.
	 * @return string The possibly altered URL without dimensions.
	 **/
	protected function strip_image_dimensions_maybe( $src ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$stripped_src = $src;

		// Build URL, first removing WP's resized string so we pass the original image to ExactDN.
		if ( preg_match( '#(-\d+x\d+)\.(' . implode( '|', $this->extensions ) . '){1}(?:\?.+)?$#i', $src, $src_parts ) ) {
			$stripped_src = str_replace( $src_parts[1], '', $src );
			$upload_dir   = wp_get_upload_dir();

			// Extracts the file path to the image minus the base url.
			$file_path = substr( $stripped_src, strlen( $upload_dir['baseurl'] ) );

			if ( file_exists( $upload_dir['basedir'] . $file_path ) ) {
				$src = $stripped_src;
			}
			ewwwio_debug_message( 'stripped dims' );
		}
		return $src;
	}

	/**
	 * Provide an array of available image sizes and corresponding dimensions.
	 * Similar to get_intermediate_image_sizes() except that it includes image sizes' dimensions, not just their names.
	 *
	 * @global $wp_additional_image_sizes
	 * @uses get_option
	 * @return array
	 */
	protected function image_sizes() {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( null == self::$image_sizes ) {
			global $_wp_additional_image_sizes;

			// Populate an array matching the data structure of $_wp_additional_image_sizes so we have a consistent structure for image sizes.
			$images = array(
				'thumb'  => array(
					'width'  => intval( get_option( 'thumbnail_size_w' ) ),
					'height' => intval( get_option( 'thumbnail_size_h' ) ),
					'crop'   => (bool) get_option( 'thumbnail_crop' ),
				),
				'medium' => array(
					'width'  => intval( get_option( 'medium_size_w' ) ),
					'height' => intval( get_option( 'medium_size_h' ) ),
					'crop'   => false,
				),
				'large'  => array(
					'width'  => intval( get_option( 'large_size_w' ) ),
					'height' => intval( get_option( 'large_size_h' ) ),
					'crop'   => false,
				),
				'full'   => array(
					'width'  => null,
					'height' => null,
					'crop'   => false,
				),
			);

			// Compatibility mapping as found in wp-includes/media.php.
			$images['thumbnail'] = $images['thumb'];

			// Update class variable, merging in $_wp_additional_image_sizes if any are set.
			if ( is_array( $_wp_additional_image_sizes ) && ! empty( $_wp_additional_image_sizes ) ) {
				self::$image_sizes = array_merge( $images, $_wp_additional_image_sizes );
			} else {
				self::$image_sizes = $images;
			}
		}

		return is_array( self::$image_sizes ) ? self::$image_sizes : array();
	}

	/**
	 * Handle image urls within the NextGEN pro lightbox displays.
	 *
	 * @param array $images An array of NextGEN images and associate attributes.
	 * @return array The ExactDNified array of images.
	 */
	function ngg_pro_lightbox_images_queue( $images ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( ewww_image_optimizer_iterable( $images ) ) {
			foreach ( $images as $index => $image ) {
				if ( ! empty( $image['image'] ) && $this->validate_image_url( $image['image'] ) ) {
					$images[ $index ]['image'] = $this->generate_url( $image['image'] );
				}
				if ( ! empty( $image['thumb'] ) && $this->validate_image_url( $image['thumb'] ) ) {
					$images[ $index ]['thumb'] = $this->generate_url( $image['thumb'] );
				}
				if ( ! empty( $image['full_image'] ) && $this->validate_image_url( $image['full_image'] ) ) {
					$images[ $index ]['full_image'] = $this->generate_url( $image['full_image'] );
				}
				if ( ewww_image_optimizer_iterable( $image['srcsets'] ) ) {
					foreach ( $image['srcsets'] as $size => $srcset ) {
						if ( $this->validate_image_url( $srcset ) ) {
							$images[ $index ]['srcsets'][ $size ] = $this->generate_url( $srcset );
						}
					}
				}
				if ( ewww_image_optimizer_iterable( $image['full_srcsets'] ) ) {
					foreach ( $image['full_srcsets'] as $size => $srcset ) {
						if ( $this->validate_image_url( $srcset ) ) {
							$images[ $index ]['full_srcsets'][ $size ] = $this->generate_url( $srcset );
						}
					}
				}
			}
		}
		return $images;
	}

	/**
	 * Handle image urls within NextGEN.
	 *
	 * @param string $image A url for a NextGEN image.
	 * @return string The ExactDNified image url.
	 */
	function ngg_get_image_url( $image ) {
		// Don't foul up the admin side of things, unless a plugin wants to.
		if ( is_admin() &&
			/**
			 * Provide plugins a way of running ExactDN for images in the WordPress Dashboard (wp-admin).
			 *
			 * @param bool false Stop ExactDN from being run on the Dashboard. Default to false, use true to run in wp-admin.
			 * @param array $args {
			 *     Array of image details.
			 *
			 *     @type string|bool  $image Image URL or false.
			 *     @type int          $attachment_id Attachment ID of the image.
			 * }
			 */
			false === apply_filters( 'exactdn_admin_allow_ngg_url', false, $image )
		) {
			return $image;
		}
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( $this->validate_image_url( $image ) ) {
			return $this->generate_url( $image );
		}
		return $image;
	}

	/**
	 * Enqueue ExactDN helper script
	 */
	public function action_wp_enqueue_scripts() {
		wp_enqueue_script( 'exactdn', plugins_url( 'includes/exactdn.js', EWWW_IMAGE_OPTIMIZER_PLUGIN_FILE ), array( 'jquery' ), EWWW_IMAGE_OPTIMIZER_VERSION, true );
	}

	/**
	 * Suppress query args for certain files, typically for placholder images.
	 *
	 * @param array|string $args Array of ExactDN arguments.
	 * @param string       $image_url Image URL.
	 * @param string|null  $scheme Image scheme. Default to null.
	 * @return array Empty if it matches our search, otherwise just $args untouched.
	 */
	function exactdn_remove_args( $args, $image_url, $scheme ) {
		if ( strpos( $image_url, 'revslider/admin/assets/images/dummy.png' ) ) {
			return array();
		}
		if ( strpos( $image_url, 'lazy_placeholder.gif' ) ) {
			return array();
		}
		if ( strpos( $image_url, 'essential-grid/public/assets/images/' ) ) {
			return array();
		}
		if ( strpos( $image_url, 'LayerSlider/static/img' ) ) {
			return array();
		}
		return $args;
	}

	/**
	 * Converts a local script/css url to use ExactDN.
	 *
	 * @param string $url URL to the resource being parsed.
	 * @return string The ExactDN version of the resource, if it was local.
	 */
	function parse_enqueue( $url ) {
		if ( is_admin() ) {
			return $url;
		}
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$parsed_url = $this->parse_url( $url );

		if ( $this->user_exclusions ) {
			foreach ( $this->user_exclusions as $exclusion ) {
				if ( false !== strpos( $url, $exclusion ) ) {
					ewwwio_debug_message( "user excluded $url via $exclusion" );
					return $url;
				}
			}
		}
		if ( false !== strpos( $url, 'wp-admin/' ) ) {
			return $url;
		}
		if ( false !== strpos( $url, 'xmlrpc.php' ) ) {
			return $url;
		}
		// Unable to parse.
		if ( ! $parsed_url || ! is_array( $parsed_url ) || empty( $parsed_url['host'] ) || empty( $parsed_url['path'] ) ) {
			ewwwio_debug_message( 'src url no good' );
			return $url;
		}

		// Make sure this is an allowed image domain/hostname for ExactDN on this site.
		if ( ! $this->allow_image_domain( $parsed_url['host'] ) ) {
			ewwwio_debug_message( "invalid host for ExactDN: {$parsed_url['host']}" );
			return $url;
		}

		// Figure out which CDN (sub)domain to use.
		if ( empty( $this->exactdn_domain ) ) {
			ewwwio_debug_message( 'no exactdn domain configured' );
			return $url;
		}

		// You can't run an ExactDN URL through again because query strings are stripped.
		// So if the image is already an ExactDN URL, append the new arguments to the existing URL.
		if ( $this->exactdn_domain === $parsed_url['host'] ) {
			ewwwio_debug_message( 'url already has exactdn domain' );
			return $url;
		}

		global $wp_version;
		// If a resource doesn't have a version string, we add one to help with cache-busting.
		if ( ( empty( $parsed_url['query'] ) || 'ver=' . $wp_version == $parsed_url['query'] ) && false !== strpos( $url, 'wp-content/' ) ) {
			$modified = ewww_image_optimizer_function_exists( 'filemtime' ) ? filemtime( get_template_directory() ) : '';
			if ( empty( $modified ) ) {
				$modified = (int) EWWW_IMAGE_OPTIMIZER_VERSION;
			}
			/**
			 * Allows a custom version string for resources that are missing one.
			 *
			 * @param string EWWW IO version.
			 */
			$parsed_url['query'] = apply_filters( 'exactdn_version_string', "m=$modified" );
		} elseif ( empty( $parsed_url['query'] ) ) {
			$parsed_url['query'] = '';
		}

		$exactdn_url = '//' . $this->exactdn_domain . '/' . ltrim( $parsed_url['path'], '/' ) . '?' . $parsed_url['query'];
		ewwwio_debug_message( "exactdn css/script url: $exactdn_url" );
		return $exactdn_url;
	}

	/**
	 * Generates an ExactDN URL.
	 *
	 * @param string       $image_url URL to the publicly accessible image you want to manipulate.
	 * @param array|string $args An array of arguments, i.e. array( 'w' => '300', 'resize' => '123,456' ), or in string form (w=123&h=456).
	 * @param string       $scheme Indicates http or https, other schemes are invalid.
	 * @return string The raw final URL. You should run this through esc_url() before displaying it.
	 */
	function generate_url( $image_url, $args = array(), $scheme = null ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		$image_url = trim( $image_url );

		if ( is_null( $scheme ) ) {
			$scheme = $this->scheme;
		}

		/**
		 * Disables ExactDN URL processing for local development.
		 *
		 * @param bool false default
		 */
		if ( true === apply_filters( 'exactdn_development_mode', false ) ) {
			return $image_url;
		}

		/**
		 * Allow specific image URls to avoid going through ExactDN.
		 *
		 * @param bool false Should the image be returned as is, without going through ExactDN. Default to false.
		 * @param string $image_url Image URL.
		 * @param array|string $args Array of ExactDN arguments.
		 * @param string|null $scheme Image scheme. Default to null.
		 */
		if ( true === apply_filters( 'exactdn_skip_for_url', false, $image_url, $args, $scheme ) ) {
			return $image_url;
		}

		// TODO: Not differentiated yet, but it will be, so stay tuned!
		$jpg_quality  = apply_filters( 'jpeg_quality', null, 'image_resize' );
		$webp_quality = apply_filters( 'jpeg_quality', $jpg_quality, 'image/webp' );

		$more_args = array();
		if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_metadata_remove' ) ) {
			$more_args['strip'] = 'all';
		}
		if ( ewww_image_optimizer_get_option( 'exactdn_lossy' ) ) {
			$more_args['lossy'] = is_numeric( ewww_image_optimizer_get_option( 'exactdn_lossy' ) ) ? (int) ewww_image_optimizer_get_option( 'exactdn_lossy' ) : 80;
		}
		if ( ! is_null( $jpg_quality ) && 82 != $jpg_quality ) {
			$more_args['quality'] = $jpg_quality;
		}
		// Merge given args with the automatic (option-based) args, and also makes sure args is an array if it was previously a string.
		$args = wp_parse_args( $args, $more_args );

		/**
		 * Filter the original image URL before it goes through ExactDN.
		 *
		 * @param string $image_url Image URL.
		 * @param array|string $args Array of ExactDN arguments.
		 * @param string|null $scheme Image scheme. Default to null.
		 */
		$image_url = apply_filters( 'exactdn_pre_image_url', $image_url, $args, $scheme );

		/**
		 * Filter the ExactDN image parameters before they are applied to an image.
		 *
		 * @param array|string $args Array of ExactDN arguments.
		 * @param string $image_url Image URL.
		 * @param string|null $scheme Image scheme. Default to null.
		 */
		$args = apply_filters( 'exactdn_pre_args', $args, $image_url, $scheme );

		if ( empty( $image_url ) ) {
			return $image_url;
		}

		$image_url_parts = $this->parse_url( $image_url );

		// Unable to parse.
		if ( ! is_array( $image_url_parts ) || empty( $image_url_parts['host'] ) || empty( $image_url_parts['path'] ) ) {
			ewwwio_debug_message( 'src url no good' );
			return $image_url;
		}

		if ( is_array( $args ) ) {
			// Convert values that are arrays into strings.
			foreach ( $args as $arg => $value ) {
				if ( is_array( $value ) ) {
					$args[ $arg ] = implode( ',', $value );
				}
			}

			// Encode argument values.
			$args = rawurlencode_deep( $args );
		}

		ewwwio_debug_message( $image_url_parts['host'] );

		// Figure out which CDN (sub)domain to use.
		if ( empty( $this->exactdn_domain ) ) {
			ewwwio_debug_message( 'no exactdn domain configured' );
			return $image_url;
		}

		// You can't run an ExactDN URL through again because query strings are stripped.
		// So if the image is already an ExactDN URL, append the new arguments to the existing URL.
		if ( $this->exactdn_domain === $image_url_parts['host'] ) {
			ewwwio_debug_message( 'url already has exactdn domain' );
			$exactdn_url = add_query_arg( $args, $image_url );
			return $this->url_scheme( $exactdn_url, $scheme );
		}

		// ExactDN doesn't support query strings so we ignore them and look only at the path.
		// However some source images are served via PHP so check the no-query-string extension.
		// For future proofing, this is a blacklist of common issues rather than a whitelist.
		$extension = pathinfo( $image_url_parts['path'], PATHINFO_EXTENSION );
		if ( ( empty( $extension ) && false === strpos( $image_url_parts['path'], 'nextgen-image/' ) ) || in_array( $extension, array( 'php', 'ashx' ) ) ) {
			ewwwio_debug_message( 'bad extension' );
			return $image_url;
		}

		$domain      = 'http://' . $this->exactdn_domain . '/';
		$exactdn_url = $domain . ltrim( $image_url_parts['path'], '/' );
		ewwwio_debug_message( "bare exactdn url: $exactdn_url" );

		/**
		 * Add query strings to ExactDN URL.
		 * By default, ExactDN doesn't support query strings so we ignore them.
		 * This setting is ExactDN Server dependent.
		 *
		 * @param bool false Should query strings be added to the image URL. Default is false.
		 * @param string $image_url_parts['host'] Image URL's host.
		 */
		if ( isset( $image_url_parts['query'] ) && apply_filters( 'exactdn_add_query_string_to_domain', false, $image_url_parts['host'] ) ) {
			$exactdn_url .= '?q=' . rawurlencode( $image_url_parts['query'] );
		}
		// This is disabled, as I don't think we really need it.
		if ( false && ! empty( $image_url_parts['query'] ) && false !== strpos( $image_url_parts['query'], 'theia_smart' ) ) {
			$args = wp_parse_args( $image_url_parts['query'], $args );
		}

		if ( $args ) {
			if ( is_array( $args ) ) {
				$exactdn_url = add_query_arg( $args, $exactdn_url );
			} else {
				// You can pass a query string for complicated requests, although this should have been converted to an array already.
				$exactdn_url .= '?' . $args;
			}
		}
		ewwwio_debug_message( "exactdn url with args: $exactdn_url" );

		if ( isset( $image_url_parts['scheme'] ) && 'https' == $image_url_parts['scheme'] ) {
			$exactdn_url = add_query_arg( 'ssl', 1, $exactdn_url );
			$scheme      = 'https';
		}

		return $this->url_scheme( $exactdn_url, $scheme );
	}

	/**
	 * Prepends schemeless urls or replaces non-http scheme with a valid scheme, defaults to 'http'.
	 *
	 * @param string      $url The URL to parse.
	 * @param string|null $scheme Retrieve specific URL component.
	 * @return string Result of parse_url.
	 */
	function url_scheme( $url, $scheme ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( ! in_array( $scheme, array( 'http', 'https' ) ) ) {
			ewwwio_debug_message( 'not a valid scheme' );
			if ( preg_match( '#^(https?:)?//#', $url ) ) {
				ewwwio_debug_message( 'url has a valid scheme already' );
				return $url;
			}
			ewwwio_debug_message( 'invalid scheme provided, and url sucks, defaulting to http' );
			$scheme = 'http';
		}
		ewwwio_debug_message( "valid $scheme - $url" );
		return preg_replace( '#^([a-z:]+)?//#i', "$scheme://", $url );
	}

	/**
	 * A wrapper for PHP's parse_url, prepending assumed scheme for network path
	 * URLs. PHP versions 5.4.6 and earlier do not correctly parse without scheme.
	 *
	 * @param string  $url The URL to parse.
	 * @param integer $component Retrieve specific URL component.
	 * @return mixed Result of parse_url.
	 */
	function parse_url( $url, $component = -1 ) {
		if ( 0 === strpos( $url, '//' ) ) {
			$url = ( is_ssl() ? 'https:' : 'http:' ) . $url;
		}
		if ( false === strpos( $url, 'http' ) && '/' !== substr( $url, 0, 1 ) ) {
			$url = ( is_ssl() ? 'https://' : 'http://' ) . $url;
		}
		// Because encoded ampersands in the filename break things.
		$url = str_replace( '&#038;', '&', $url );
		return parse_url( $url, $component );
	}

	/**
	 * A wrapper for human_time_diff() that gives sub-minute times in seconds.
	 *
	 * @param int $from Unix timestamp from which the difference begins.
	 * @param int $to Optional. Unix timestamp to end the time difference. Default is time().
	 * @return string Human readable time difference.
	 */
	function human_time_diff( $from, $to = '' ) {
		if ( empty( $to ) ) {
			$to = time();
		}
		$diff = (int) abs( $to - $from );
		if ( $diff < 60 ) {
			return "$diff sec";
		}
		return human_time_diff( $from, $to );
	}

	/**
	 * Adds link to header which enables DNS prefetching for faster speed.
	 */
	function dns_prefetch() {
		if ( $this->exactdn_domain ) {
			echo "\r\n";
			printf( "<link rel='dns-prefetch' href='%s'>\r\n", '//' . esc_attr( $this->exactdn_domain ) );
		}
	}

	/**
	 * Adds the ExactDN domain to the list of 'local' domains for Autoptimize.
	 *
	 * @param array $domains A list of domains considered 'local' by Autoptimize.
	 * @return array The same list, with the ExactDN domain appended.
	 */
	function autoptimize_cdn_url( $domains ) {
		ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
		if ( is_array( $domains ) && ! in_array( $this->exactdn_domain, $domains ) ) {
			ewwwio_debug_message( 'adding to AO list: ' . $this->exactdn_domain );
			$domains[] = $this->exactdn_domain;
		}
		return $domains;
	}
}

global $exactdn;
$exactdn = new ExactDN();
