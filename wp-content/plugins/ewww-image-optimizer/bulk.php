<?php
/**
 * Functions for performing Bulk Optimizations
 * This file contains functions for the main bulk optimize page.
 *
 * @link https://ewww.io
 * @package EWWW_Image_Optimizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Presents the bulk optimize form and optimization results table.
 */
function ewww_image_optimizer_bulk_preview() {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	// Retrieve the attachment IDs that were pre-loaded in the database.
	echo '<div class="wrap"><h1>' . esc_html__( 'Bulk Optimize', 'ewww-image-optimizer' ) . '</h1>';
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_auto' ) ) {
		echo '<div class="error"><p>';
		esc_html_e( 'Please disable Scheduled optimization before continuing.', 'ewww-image-optimizer' );
		echo '</p></div></div>';
		return;
	}
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_cloud_key' ) ) {
		echo '<span><a id="ewww-bulk-credits-available" target="_blank" class="page-title-action" style="float:right;" href="https://ewww.io/my-account/">' . esc_html__( 'Image credits available:', 'ewww-image-optimizer' ) . ' ' . ewww_image_optimizer_cloud_quota() . '</a></span>';
	}
	// Retrieve the value of the 'bulk resume' option and set the button text for the form to use.
	$resume = get_option( 'ewww_image_optimizer_bulk_resume' );
	if ( empty( $resume ) ) {
		$fullsize_count = ewww_image_optimizer_count_optimized( 'media' );
		$button_text    = esc_attr__( 'Start optimizing', 'ewww-image-optimizer' );
	} elseif ( 'scanning' == $resume ) {
		$fullsize_count = ewww_image_optimizer_count_optimized( 'media' );
		$button_text    = esc_attr__( 'Start optimizing', 'ewww-image-optimizer' );
	} else {
		$fullsize_count = ewww_image_optimizer_aux_images_table_count_pending();
		$button_text    = esc_attr__( 'Resume previous optimization', 'ewww-image-optimizer' );
	}
	// Create the html for the bulk optimize form and status divs.
	ewww_image_optimizer_bulk_head_output();
	echo '<div id="ewww-bulk-forms">';
	if ( $fullsize_count < 1 ) {
		echo '<p>' . esc_html__( 'You do not appear to have uploaded any images yet.', 'ewww-image-optimizer' ) . '</p>';
	} else {
		if ( 'true' == $resume ) {
			/* translators: %d: number of images */
			echo '<p class="ewww-media-info ewww-bulk-info">' . sprintf( esc_html( _n( 'There is %d image ready to optimize.', 'There are %d images ready to optimize.', $fullsize_count, 'ewww-image-optimizer' ) ), $fullsize_count ) . '</p>';
		} else {
			if ( ! empty( $_REQUEST['ids'] ) && ( preg_match( '/^[\d,]+$/', $_REQUEST['ids'] ) || is_numeric( $_REQUEST['ids'] ) ) ) {
				/* translators: %d: number of images */
				echo '<p class="ewww-media-info ewww-bulk-info">' . sprintf( esc_html( _n( '%1$d image in the Media Library has been selected.', '%1$d images in the Media Library have been selected.', $fullsize_count, 'ewww-image-optimizer' ) ), $fullsize_count ) . '</p>';
			} else {
				/* translators: %d: number of images */
				echo '<p class="ewww-media-info ewww-bulk-info">' . sprintf( esc_html( _n( '%1$d image in the Media Library has been selected.', '%1$d images in the Media Library have been selected.', $fullsize_count, 'ewww-image-optimizer' ) ), $fullsize_count ) . '<br />' .
					esc_html__( 'The active theme, BuddyPress, WP Symposium, and folders that you have configured will also be scanned for unoptimized images.', 'ewww-image-optimizer' ) . '</p>';
			}
		}
		ewww_image_optimizer_bulk_action_output( $button_text, $fullsize_count, $resume );
	}
	// If the 'bulk resume' option was not empty, offer to reset it so the user can start back from the beginning.
	if ( 'true' == $resume ) {
		ewww_image_optimizer_bulk_reset_form_output();
	}
	echo '</div>';
	ewwwio_memory( __FUNCTION__ );
	ewww_image_optimizer_aux_images();
}

/**
 * Outputs the status area and delay/force controls for the Bulk optimize page.
 */
function ewww_image_optimizer_bulk_head_output() {
	$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
	$delay         = ewww_image_optimizer_get_option( 'ewww_image_optimizer_delay' ) ? (int) ewww_image_optimizer_get_option( 'ewww_image_optimizer_delay' ) : 0;
	?>
		<div id="ewww-bulk-loading">
			<p id="ewww-loading" class="ewww-bulk-info" style="display:none"><?php esc_html_e( 'Importing', 'ewww-image-optimizer' ); ?>&nbsp;<img src='<?php echo $loading_image; ?>' /></p>
		</div>
		<div id="ewww-bulk-progressbar"></div>
		<div id="ewww-bulk-timer" style="float:right;"></div>
		<div id="ewww-bulk-counter"></div>
		<form id="ewww-bulk-stop" style="display:none;" method="post" action="">
			<br /><input type="submit" class="button-secondary action" value="<?php esc_attr_e( 'Stop Optimizing', 'ewww-image-optimizer' ); ?>" />
		</form>
		<div id="ewww-bulk-widgets" class="metabox-holder" style="display:none">
			<div class="meta-box-sortables">
				<div id="ewww-bulk-last" class="postbox">
					<button type="button" class="ewww-handlediv button-link" aria-expanded="true">
						<span class="screen-reader-text"><?php esc_html_e( 'Click to toggle', 'ewww-image-optimizer' ); ?></span>
						<span class="toggle-indicator" aria-hidden="false"></span>
					</button>
					<h2 class="ewww-hndle"><span><?php esc_html_e( 'Last Batch Optimized', 'ewww-image-optimizer' ); ?></span></h2>
					<div class="inside"></div>
				</div>
			</div>
			<div class="meta-box-sortables">
				<div id="ewww-bulk-status" class="postbox">
					<button type="button" class="ewww-handlediv button-link" aria-expanded="true">
						<span class="screen-reader-text"><?php esc_html_e( 'Click to toggle', 'ewww-image-optimizer' ); ?></span>
						<span class="toggle-indicator" aria-hidden="false"></span>
					</button>
					<h2 class="ewww-hndle"><span><?php esc_html_e( 'Optimization Log', 'ewww-image-optimizer' ); ?></span></h2>
					<div class="inside"></div>
				</div>
			</div>
		</div>
		<form class="ewww-bulk-form">
			<p><label for="ewww-force" style="font-weight: bold"><?php esc_html_e( 'Force re-optimize', 'ewww-image-optimizer' ); ?></label>
				&emsp;<input type="checkbox" id="ewww-force" name="ewww-force"<?php echo ( get_transient( 'ewww_image_optimizer_force_reopt' ) ) ? ' checked' : ''; ?>>
				&nbsp;<?php esc_html_e( 'Previously optimized images will be skipped by default, check this box before scanning to override.', 'ewww-image-optimizer' ); ?></p>
			<p><label for="ewww-delay" style="font-weight: bold"><?php esc_html_e( 'Choose how long to pause between images (in seconds, 0 = disabled)', 'ewww-image-optimizer' ); ?></label>&emsp;<input type="text" id="ewww-delay" name="ewww-delay" value="<?php echo $delay; ?>"></p>
			<div id="ewww-delay-slider" style="width:50%"></div>
		</form>
	<?php
}

/**
 * Outputs the buttons and scanner status html for the Bulk optimize page.
 *
 * @param string $button_text Value for the button that starts the optimization (after scanning).
 * @param int    $fullsize_count The total number of images that need to be scanned.
 * @param string $resume Optional. If a bulk operation was interrupted, indicates in which phase it
 *                                 was operating. Accepts 'true', 'scanning', or ''.
 */
function ewww_image_optimizer_bulk_action_output( $button_text, $fullsize_count, $resume = '' ) {
	$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
	/* translators: %d: number of images */
	$scanning_starter_message = sprintf( esc_html__( 'Stage 1, %d images left to scan.', 'ewww-image-optimizer' ), $fullsize_count );
	if ( 'true' == $resume ) {
		$scan_hide  = 'style="display:none"';
		$start_hide = '';
	} else {
		$start_hide = 'style="display:none"';
		$scan_hide  = '';

	}
	?>
	<p id="ewww-nothing" class="ewww-bulk-info" style="display:none"><?php echo esc_html_e( 'There are no images to optimize.', 'ewww-image-optimizer' ); ?></p>
	<p id="ewww-scanning" class="ewww-bulk-info" style="display:none"><?php echo $scanning_starter_message; ?>&nbsp;<img src='<?php echo $loading_image; ?>' alt='loading'/></p>
	<form id="ewww-aux-start" class="ewww-bulk-form" <?php echo $scan_hide; ?> method="post" action="">
		<input id="ewww-aux-first" type="submit" class="button-primary action" value="<?php esc_attr_e( 'Scan for unoptimized images', 'ewww-image-optimizer' ); ?>" />
		<input id="ewww-aux-again" type="submit" class="button-secondary action" style="display:none" value="<?php esc_attr_e( 'Scan Again', 'ewww-image-optimizer' ); ?>" />
	</form>
	<form id="ewww-bulk-start" class="ewww-bulk-form" <?php echo $start_hide; ?> method="post" action="">
		<input id="ewww-aux-first" type="submit" class="button-primary action" value="<?php echo $button_text; ?>" />
	</form>
	<?php
}

/**
 * Outputs the Reset form on the Bulk optimize page.
 */
function ewww_image_optimizer_bulk_reset_form_output() {
	?>
		<p class="ewww-media-info ewww-bulk-info"><?php esc_html_e( 'If you would like to start over again, press the Reset Status button to reset the bulk operation status.', 'ewww-image-optimizer' ); ?></p>
		<form class="ewww-bulk-form" method="post" action="">
			<?php wp_nonce_field( 'ewww-image-optimizer-bulk-reset', 'ewww_wpnonce' ); ?>
			<input type="hidden" name="ewww_reset" value="1">
			<button id="ewww-bulk-reset" type="submit" class="button-secondary action"><?php esc_html_e( 'Reset Status', 'ewww-image-optimizer' ); ?></button>
		</form>
	<?php
}

/**
 * Detect the current memory limit and reduce the query limit appropriately.
 *
 * @param int $max_query The default number of records to query in large batches.
 * @return int The adjusted level based on the memory limit
 */
function ewww_image_optimizer_reduce_query_count( $max_query ) {
	$memory_limit = ewwwio_memory_limit();
	if ( $memory_limit <= 33560000 ) {
		return 500;
	} elseif ( $memory_limit <= 67120000 ) {
		return 1000;
	} elseif ( $memory_limit <= 134300000 ) {
		return 1500;
	} elseif ( $memory_limit <= 268500000 ) {
		return 3000;
	}
	return $max_query;
}

/**
 * Retrieve image counts for the bulk process.
 *
 * For the media library, returns a simple count of the number of attachments. For other galleries,
 * counts the number of thumbnails/resizes along with how many of each need to be optimized. Uses
 * attachment "metadata" to calculate the counts, which will not be accurate for long.
 *
 * @param string $gallery Bulk page that is calling the function. Accepts 'media', 'ngg', and 'flag'.
 * @return int|array {
 *     The image count(s) found during the search.
 *
 *     @type int $full_count The number of original uploads found.
 *     @type int $unoptimized_full The number of original uploads that have not been optimized.
 *     @type int $resize_count The number of thumbnails/resizes found.
 *     @type int $unoptimized_re The number of resizes that are not optimized.
 * }
 */
function ewww_image_optimizer_count_optimized( $gallery ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	ewwwio_debug_message( "scanning for $gallery" );
	global $wpdb;
	$full_count             = 0;
	$unoptimized_full       = 0;
	$unoptimized_re         = 0;
	$resize_count           = 0;
	$attachment_query       = '';
	$started                = microtime( true ); // Retrieve the time when the counting starts.
	$max_query              = apply_filters( 'ewww_image_optimizer_count_optimized_queries', 4000 );
	$max_query              = (int) $max_query;
	$attachment_query_count = 0;
	switch ( $gallery ) {
		case 'media':
			$ids    = array();
			$resume = get_option( 'ewww_image_optimizer_bulk_resume' );
			// See if we were given attachment IDs to work with via GET/POST.
			if ( ! empty( $_REQUEST['ids'] ) || $resume ) {
				ewwwio_debug_message( 'we have received attachment ids via $_REQUEST' );
				// Retrieve the attachment IDs that were pre-loaded in the database.
				if ( 'scanning' == $resume ) {
					$finished       = (array) get_option( 'ewww_image_optimizer_bulk_attachments' );
					$remaining      = (array) get_option( 'ewww_image_optimizer_scanning_attachments' );
					$attachment_ids = array_merge( $finished, $remaining );
				} elseif ( $resume ) {
					// This shouldn't ever happen, but doesn't hurt to account for the use case, just in case something changes in the future.
					$attachment_ids = get_option( 'ewww_image_optimizer_bulk_attachments' );
				} else {
					$attachment_ids = get_option( 'ewww_image_optimizer_scanning_attachments' );
				}
				if ( ! empty( $attachment_ids ) ) {
					$full_count = count( $attachment_ids );
				}
			} else {
				$full_count = $wpdb->get_var( "SELECT COUNT(ID) FROM $wpdb->posts WHERE (post_type = 'attachment' OR post_type = 'ims_image') AND (post_mime_type LIKE '%%image%%' OR post_mime_type LIKE '%%pdf%%')" );
			}
			return $full_count;
			break;
		case 'ngg':
			// See if we were given attachment IDs to work with via GET/POST.
			if ( ! empty( $_REQUEST['doaction'] ) || get_option( 'ewww_image_optimizer_bulk_ngg_resume' ) ) {
				// Retrieve the attachment IDs that were pre-loaded in the database.
				$attachment_ids = get_option( 'ewww_image_optimizer_bulk_ngg_attachments' );
				array_walk( $attachment_ids, 'intval' );
				while ( $attachment_ids && $attachment_query_count < $max_query ) {
					$attachment_query .= "'" . array_pop( $attachment_ids ) . "',";
					$attachment_query_count++;
				}
				$attachment_query = 'WHERE pid IN (' . substr( $attachment_query, 0, -1 ) . ')';
			}
			// Creating the 'registry' object for working with nextgen.
			$registry = C_Component_Registry::get_instance();
			// Creating a database storage object from the 'registry' object.
			$storage = $registry->get_utility( 'I_Gallery_Storage' );
			// Get an array of sizes available for the $image.
			$sizes = $storage->get_image_sizes();
			global $ewwwngg;
			$offset = 0;
			while ( $attachments = $wpdb->get_col( "SELECT meta_data FROM $wpdb->nggpictures $attachment_query LIMIT $offset, $max_query" ) ) { // WPCS: unprepared SQL ok.
				foreach ( $attachments as $attachment ) {
					if ( class_exists( 'Ngg_Serializable' ) ) {
						$serializer = new Ngg_Serializable();
						$meta       = $serializer->unserialize( $attachment );
					} else {
						$meta = unserialize( $attachment );
					}
					if ( ! is_array( $meta ) ) {
						continue;
					}
					if ( empty( $meta['ewww_image_optimizer'] ) ) {
							$unoptimized_full++;
					}
					$ngg_sizes = $ewwwngg->maybe_get_more_sizes( $sizes, $meta );
					if ( ewww_image_optimizer_iterable( $ngg_sizes ) ) {
						foreach ( $ngg_sizes as $size ) {
							if ( 'full' !== $size ) {
								$resize_count++;
								if ( empty( $meta[ $size ]['ewww_image_optimizer'] ) ) {
									$unoptimized_re++;
								}
							}
						}
					}
				}
				$full_count += count( $attachments );
				$offset     += $max_query;
				if ( ! empty( $attachment_ids ) ) {
					$attachment_query       = '';
					$attachment_query_count = 0;
					$offset                 = 0;
					while ( $attachment_ids && $attachment_query_count < $max_query ) {
						$attachment_query .= "'" . array_pop( $attachment_ids ) . "',";
						$attachment_query_count++;
					}
					$attachment_query = 'WHERE pid IN (' . substr( $attachment_query, 0, -1 ) . ')';
				}
			} // End while().
			break;
		case 'flag':
			if ( ! empty( $_REQUEST['doaction'] ) || get_option( 'ewww_image_optimizer_bulk_flag_resume' ) ) {
				// Retrieve the attachment IDs that were pre-loaded in the database.
				$attachment_ids = get_option( 'ewww_image_optimizer_bulk_flag_attachments' );
				array_walk( $attachment_ids, 'intval' );
				while ( $attachment_ids && $attachment_query_count < $max_query ) {
					$attachment_query .= "'" . array_pop( $attachment_ids ) . "',";
					$attachment_query_count++;
				}
				$attachment_query = 'WHERE pid IN (' . substr( $attachment_query, 0, -1 ) . ')';
			}
			$offset = 0;
			while ( $attachments = $wpdb->get_col( "SELECT meta_data FROM $wpdb->flagpictures $attachment_query LIMIT $offset, $max_query" ) ) { // WPCS: unprepared SQL ok.
				foreach ( $attachments as $attachment ) {
					$meta = unserialize( $attachment );
					if ( ! is_array( $meta ) ) {
						continue;
					}
					if ( empty( $meta['ewww_image_optimizer'] ) ) {
						$unoptimized_full++;
					}
					if ( ! empty( $meta['webview'] ) ) {
						$resize_count++;
						if ( empty( $meta['webview']['ewww_image_optimizer'] ) ) {
							$unoptimized_re++;
						}
					}
					if ( ! empty( $meta['thumbnail'] ) ) {
						$resize_count++;
						if ( empty( $meta['thumbnail']['ewww_image_optimizer'] ) ) {
							$unoptimized_re++;
						}
					}
				}
				$full_count += count( $attachments );
				$offset     += $max_query;
				if ( ! empty( $attachment_ids ) ) {
					$attachment_query       = '';
					$attachment_query_count = 0;
					$offset                 = 0;
					while ( $attachment_ids && $attachment_query_count < $max_query ) {
						$attachment_query .= "'" . array_pop( $attachment_ids ) . "',";
						$attachment_query_count++;
					}
					$attachment_query = 'WHERE pid IN (' . substr( $attachment_query, 0, -1 ) . ')';
				}
			}
			break;
	} // End switch().
	if ( empty( $full_count ) && ! empty( $attachment_ids ) ) {
		ewwwio_debug_message( 'query appears to have failed, just counting total images instead' );
		$full_count = count( $attachment_ids );
	}
	$elapsed = microtime( true ) - $started;
	ewwwio_debug_message( "counting images took $elapsed seconds" );
	ewwwio_debug_message( "found $full_count fullsize ($unoptimized_full unoptimized), and $resize_count resizes ($unoptimized_re unoptimized)" );
	ewwwio_memory( __FUNCTION__ );
	return array( $full_count, $unoptimized_full, $resize_count, $unoptimized_re );
}

/**
 * Prepares the bulk operation and includes the javascript functions.
 *
 * Checks to see if a scan was in progress, or if attachment IDs were POSTed, and loads the
 * appropriate attachments into the list to be scanned. Also sets up the js includes, and
 * defines a few js variables needed for the bulk operation.
 *
 * @global object $wpdb
 *
 * @param string $hook An indicator if this was not called from AJAX, like WP-CLI.
 */
function ewww_image_optimizer_bulk_script( $hook ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	// Make sure we are being called from the bulk optimization page.
	if ( 'media_page_ewww-image-optimizer-bulk' != $hook ) {
		return;
	}
	// Initialize the $attachments variable.
	$attachments = array();
	// Check to see if we are supposed to reset the bulk operation and verify we are authorized to do so.
	if ( ! empty( $_REQUEST['ewww_reset'] ) && wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk-reset' ) ) {
		// Set the 'bulk resume' option to an empty string to reset the bulk operation.
		update_option( 'ewww_image_optimizer_bulk_resume', '' );
		update_option( 'ewww_image_optimizer_aux_resume', '' );
		update_option( 'ewww_image_optimizer_scanning_attachments', '', false );
		update_option( 'ewww_image_optimizer_bulk_attachments', '', false );
		ewww_image_optimizer_delete_pending();
	}
	global $wpdb;
	// Check to see if we are supposed to reset the bulk operation and verify we are authorized to do so.
	if ( ! empty( $_REQUEST['ewww_reset_aux'] ) && wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-aux-images-reset' ) ) {
		// Set the 'aux resume' option to an empty string to reset the bulk operation.
		update_option( 'ewww_image_optimizer_aux_resume', '' );
		$wpdb->query( "DELETE from $wpdb->ewwwio_images WHERE image_size IS NULL" );
	}
	// Check to see if we are supposed to convert the auxiliary images table and verify we are authorized to do so.
	if ( ! empty( $_REQUEST['ewww_convert'] ) && wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-aux-images-convert' ) ) {
		ewww_image_optimizer_aux_images_convert();
	}
	// Check the 'bulk resume' option.
	$resume   = get_option( 'ewww_image_optimizer_bulk_resume' );
	$scanning = get_option( 'ewww_image_optimizer_aux_resume' );
	if ( ! $resume && ! $scanning ) {
		update_option( 'ewww_image_optimizer_scanning_attachments', '', false );
		update_option( 'ewww_image_optimizer_bulk_attachments', '', false );
		ewww_image_optimizer_delete_pending();
	}
	// See if we were given attachment IDs to work with via GET/POST.
	$ids = array();
	if ( ! empty( $_REQUEST['ids'] ) && ( preg_match( '/^[\d,]+$/', $_REQUEST['ids'], $request_ids ) || is_numeric( $_REQUEST['ids'] ) ) ) {
		ewww_image_optimizer_delete_pending();
		set_transient( 'ewww_image_optimizer_skip_aux', true, 3 * MINUTE_IN_SECONDS );
		if ( is_numeric( $_REQUEST['ids'] ) ) {
			$ids[] = (int) $_REQUEST['ids'];
		} else {
			$ids = explode( ',', $request_ids[0] );
			array_walk( $ids, 'intval' );
		}
		$sample_post_type = get_post_type( $ids[0] );
		// ewwwio_debug_message( "ids: " . $request_ids[0] ); // keeping just in case.
		ewwwio_debug_message( "post type (checking for ims_gallery): $sample_post_type" );
		if ( 'ims_gallery' == $sample_post_type ) {
			$attachments = array();
			foreach ( $ids as $gid ) {
				ewwwio_debug_message( "gallery id: $gid" );
				$ims_images  = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'ims_image' AND post_mime_type LIKE %s AND post_parent = %d ORDER BY ID DESC", '%image%', $gid ) );
				$attachments = array_merge( $attachments, $ims_images );
			}
		} else {
			ewwwio_debug_message( "validating requested ids: {$request_ids[0]}" );
			// Retrieve post IDs correlating to the IDs submitted to make sure they are all valid.
			$attachments = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE (post_type = 'attachment' OR post_type = 'ims_image') AND (post_mime_type LIKE '%%image%%' OR post_mime_type LIKE '%%pdf%%') AND ID IN ({$request_ids[0]}) ORDER BY ID DESC" ); // WPCS: unprepared SQL ok.
		}
		// Unset the 'bulk resume' option since we were given specific IDs to optimize.
		update_option( 'ewww_image_optimizer_bulk_resume', '' );
		// Check if there is a previous bulk operation to resume.
	} elseif ( 'scanning' == $resume ) {
		// Retrieve the attachment IDs that have not been finished from the 'scanning attachments' option.
		$attachments = get_option( 'ewww_image_optimizer_scanning_attachments' );
	} elseif ( $scanning || $resume ) {
		$attachments = array();
		// Since we aren't resuming, and weren't given a list of IDs, we will optimize everything.
	} elseif ( empty( $attachments ) ) {
		delete_transient( 'ewww_image_optimizer_scan_aux' );
		// Load up all the image attachments we can find.
		$attachments = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE (post_type = 'attachment' OR post_type = 'ims_image') AND (post_mime_type LIKE '%%image%%' OR post_mime_type LIKE '%%pdf%%') ORDER BY ID DESC" );
	} // End if().
	// Store the attachment IDs we retrieved in the 'bulk_attachments' option so we can keep track of our progress in the database.
	update_option( 'ewww_image_optimizer_scanning_attachments', $attachments, false );
	wp_enqueue_script( 'ewwwbulkscript', plugins_url( '/includes/eio.js', __FILE__ ), array( 'jquery', 'jquery-ui-slider', 'jquery-ui-progressbar', 'postbox', 'dashboard' ), EWWW_IMAGE_OPTIMIZER_VERSION );
	// Number of images in the ewwwio_table (previously optimized images).
	$image_count = ewww_image_optimizer_aux_images_table_count();
	// Number of image attachments to be optimized.
	$attachment_count = count( $attachments );
	// Submit a couple variables for our javascript to work with.
	$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
	wp_localize_script(
		'ewwwbulkscript',
		'ewww_vars',
		array(
			'_wpnonce'              => wp_create_nonce( 'ewww-image-optimizer-bulk' ),
			'attachments'           => ewww_image_optimizer_aux_images_table_count_pending(),
			'image_count'           => $image_count,
			/* translators: %d: number of images */
			'count_string'          => sprintf( esc_html__( '%d images', 'ewww-image-optimizer' ), $image_count ),
			'scan_fail'             => esc_html__( 'Operation timed out, you may need to increase the max_execution_time or memory_limit for PHP', 'ewww-image-optimizer' ),
			'scan_incomplete'       => esc_html__( 'Scan did not complete, will try again', 'ewww-image-optimizer' ) . "&nbsp;<img src='$loading_image' />",
			'operation_stopped'     => esc_html__( 'Optimization stopped, reload page to resume.', 'ewww-image-optimizer' ),
			'operation_interrupted' => esc_html__( 'Operation Interrupted', 'ewww-image-optimizer' ),
			'temporary_failure'     => esc_html__( 'Temporary failure, attempts remaining:', 'ewww-image-optimizer' ),
			'invalid_response'      => esc_html__( 'Received an invalid response from your website, please check for errors in the Developer Tools console of your browser.', 'ewww-image-optimizer' ),
			'bad_attachment'        => esc_html__( 'Previous failure due to broken/missing metadata, skipped resizes for attachment:', 'ewww-image-optimizer' ),
			'remove_failed'         => esc_html__( 'Could not remove image from table.', 'ewww-image-optimizer' ),
			/* translators: used for Bulk Optimize progress bar, like so: Optimized 32/346 */
			'optimized'             => esc_html__( 'Optimized', 'ewww-image-optimizer' ),
			'last_image_header'     => esc_html__( 'Last Image Optimized', 'ewww-image-optimizer' ),
			'time_remaining'        => esc_html__( 'remaining', 'ewww-image-optimizer' ),
			'original_restored'     => esc_html__( 'Original Restored', 'ewww-image-optimizer' ),
			'restoring'             => '<p>' . esc_html__( 'Restoring', 'ewww-image-optimizer' ) . "&nbsp;<img src='$loading_image' /></p>",
			'bulk_fail_more'        => '<a href="https://docs.ewww.io/article/39-bulk-optimizer-failure" target="_blank" data-beacon-article="596f84f72c7d3a73488b3ca7">' . esc_html__( 'more...', 'ewww-image-optimizer' ) . '</a>',
		)
	);
	// Load the stylesheet for the jquery progressbar.
	wp_enqueue_style( 'jquery-ui-progressbar', plugins_url( '/includes/jquery-ui-1.10.1.custom.css', __FILE__ ) );
	ewwwio_memory( __FUNCTION__ );
}

/**
 * Loads the list of optimized images into memory.
 *
 * Pulls a list of all optimized images from the database, and stores it globally unless there is
 * a memory constraint, or the list of images is too large to be efficient.
 *
 * @global string|array $optimized_list A list of all images that have been optimized, or a string
 *                                      indicating why that is not a good idea.
 * @global object $wpdb
 */
function ewww_image_optimizer_optimized_list() {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	// Retrieve the time when the list building starts.
	$started = microtime( true );
	global $optimized_list;
	global $wpdb;
	if ( strpos( $wpdb->charset, 'utf8' ) === false ) {
		ewww_image_optimizer_db_init();
		global $ewwwdb;
	} else {
		$ewwwdb = $wpdb;
	}
	$offset         = 0;
	$max_query      = (int) apply_filters( 'ewww_image_optimizer_count_optimized_queries', 4000 );
	$optimized_list = array();
	if ( defined( 'EWWW_IMAGE_OPTIMIZER_SCAN_MODE_B' ) && EWWW_IMAGE_OPTIMIZER_SCAN_MODE_B ) { // User manually enabled Plan B.
		ewwwio_debug_message( 'user chose low memory mode' );
		$optimized_list = 'user_configured';
		set_transient( 'ewww_image_optimizer_low_memory_mode', 'user_configured', 90 ); // Put it in low memory mode for at least 10 minutes.
		return;
	}
	if ( get_transient( 'ewww_image_optimizer_low_memory_mode' ) ) {
		$optimized_list = get_transient( 'ewww_image_optimizer_low_memory_mode' );
		ewwwio_debug_message( "staying in low memory mode: $optimized_list" );
		return;
	}
	$starting_memory_usage = memory_get_usage( true );
	while ( $already_optimized = $ewwwdb->get_results( "SELECT id,path,image_size,pending,attachment_id,updated FROM $ewwwdb->ewwwio_images LIMIT $offset,$max_query", ARRAY_A ) ) {
		$ewwwdb->flush();
		foreach ( $already_optimized as $optimized ) {
			$optimized_path = ewww_image_optimizer_relative_path_replace( $optimized['path'] );
			// Check for duplicate records.
			if ( ! empty( $optimized_list[ $optimized_path ] ) && ! empty( $optimized_list[ $optimized_path ]['id'] ) ) {
				$optimized = ewww_image_optimizer_remove_duplicate_records( array( $optimized_list[ $optimized_path ]['id'], $optimized['id'] ) );
			}
			$optimized_list[ $optimized_path ]['image_size']    = $optimized['image_size'];
			$optimized_list[ $optimized_path ]['id']            = $optimized['id'];
			$optimized_list[ $optimized_path ]['pending']       = $optimized['pending'];
			$optimized_list[ $optimized_path ]['attachment_id'] = $optimized['attachment_id'];
			$optimized_list[ $optimized_path ]['updated']       = $optimized['updated'];
		}
		ewwwio_memory( 'removed original records' );
		$offset += $max_query;
		if ( empty( $estimated_batch_memory ) ) {
			$estimated_batch_memory = memory_get_usage( true ) - $starting_memory_usage;
			if ( ! $estimated_batch_memory ) { // If the memory did not appear to increase, set it to a safe default.
				$estimated_batch_memory = 3146000;
			}
			ewwwio_debug_message( "estimated batch memory is $estimated_batch_memory" );
		}
		if ( ! ewwwio_check_memory_available( 3146000 + $estimated_batch_memory ) ) { // Initial batch storage used + 3MB.
			ewwwio_debug_message( 'loading optimized list took too much memory' );
			$optimized_list = 'low_memory';
			set_transient( 'ewww_image_optimizer_low_memory_mode', 'low_memory', 600 ); // Put it in low memory mode for at least 10 minutes so we don't abuse the db server with extra requests.
			return;
		}
		$elapsed = microtime( true ) - $started;
		ewwwio_debug_message( "loading optimized list took $elapsed seconds so far" );
		if ( $elapsed > 5 ) {
			ewwwio_debug_message( 'loading optimized list took too long' );
			$optimized_list = 'large_list';
			set_transient( 'ewww_image_optimizer_low_memory_mode', 'large_list', 600 ); // Use low memory mode so that we don't waste lots of time pulling a huge list of images repeatedly.
			return;
		}
	} // End while().
}

/**
 * Retrieves a selected set of attachment metadata from the postmeta table.
 *
 * @global object $wpdb
 *
 * @param string $attachments_in A comma-imploded array containing a list of attachment IDs.
 * @return array Multi-dimensional array containing all the postmeta and mime-types for the IDs
 * of $attachments_in.
 */
function ewww_image_optimizer_fetch_metadata_batch( $attachments_in ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	if ( ! preg_match( '/^[\d,]+$/', $attachments_in ) ) {
		ewwwio_debug_message( 'invalid attachments string' );
		return array();
	}
	ewwwio_debug_message( 'attachment query length: ' . strlen( $attachments_in ) );
	global $wpdb;
	// Retrieve image attachment metadata from the database (in batches).
	$attachments = $wpdb->get_results( "SELECT metas.post_id,metas.meta_key,metas.meta_value,posts.post_mime_type FROM $wpdb->postmeta metas INNER JOIN $wpdb->posts posts ON posts.ID = metas.post_id WHERE (posts.post_mime_type LIKE '%%image%%' OR posts.post_mime_type LIKE '%%pdf%%') AND metas.post_id IN ($attachments_in)", ARRAY_A ); // WPCS: unprepared SQL ok.
	ewwwio_debug_message( 'fetched ' . count( $attachments ) . ' attachment meta items' );
	$wpdb->flush();
	$attachment_meta = array();
	foreach ( $attachments as $attachment ) {
		if ( '_wp_attached_file' == $attachment['meta_key'] ) {
			$attachment_meta[ $attachment['post_id'] ]['_wp_attached_file'] = $attachment['meta_value'];
			if ( ! empty( $attachment['post_mime_type'] ) && empty( $attachment_meta[ $attachment['post_id'] ]['type'] ) ) {
				$attachment_meta[ $attachment['post_id'] ]['type'] = $attachment['post_mime_type'];
			}
			continue;
		} elseif ( '_wp_attachment_metadata' == $attachment['meta_key'] ) {
			$attachment_meta[ $attachment['post_id'] ]['meta'] = $attachment['meta_value'];
			if ( ! empty( $attachment['post_mime_type'] ) && empty( $attachment_meta[ $attachment['post_id'] ]['type'] ) ) {
				$attachment_meta[ $attachment['post_id'] ]['type'] = $attachment['post_mime_type'];
			}
			continue;
		} elseif ( 'tiny_compress_images' == $attachment['meta_key'] ) {
			$attachment_meta[ $attachment['post_id'] ]['tinypng'] = true;
		}
		if ( ! empty( $attachment['post_mime_type'] ) && empty( $attachment_meta[ $attachment['post_id'] ]['type'] ) ) {
			$attachment_meta[ $attachment['post_id'] ]['type'] = $attachment['post_mime_type'];
		}
	}
	unset( $attachments );
	return $attachment_meta;
}

/**
 * Scans the Media Library for images that need optimizing.
 *
 * Searches for images using the attachment metadata and stores them in the ewwwio_images table.
 * Optionally restricted to specific attachments selected by the user. If Force Re-optimize is
 * checked, marks existing records as pending also.
 *
 * @global object $wpdb
 * @global object $ewwwdb A clone of $wpdb unless it is lacking utf8 connectivity.
 * @global string|array $optimized_list A list of all images that have been optimized, or a string
 *                                      indicating why that is not a good idea.
 *
 * @param string $hook An indicator if this was not called from AJAX, like WP-CLI.
 */
function ewww_image_optimizer_media_scan( $hook = '' ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );

	$permissions = apply_filters( 'ewww_image_optimizer_bulk_permissions', '' );
	if ( 'ewww-image-optimizer-cli' !== $hook && empty( $_REQUEST['ewww_scan'] ) ) {
		ewwwio_debug_message( 'bailing no cli' );
		ewww_image_optimizer_debug_log();
		ewwwio_ob_clean();
		die( ewwwio_json_encode( array( 'error' => esc_html__( 'Access denied.', 'ewww-image-optimizer' ) ) ) );
	}
	if ( ! empty( $_REQUEST['ewww_scan'] ) && ( ! wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' ) || ! current_user_can( $permissions ) ) ) {
		ewwwio_debug_message( 'bailing no nonce' );
		ewww_image_optimizer_debug_log();
		ewwwio_ob_clean();
		die( ewwwio_json_encode( array( 'error' => esc_html__( 'Access token has expired, please reload the page.', 'ewww-image-optimizer' ) ) ) );
	}
	global $wpdb;
	if ( strpos( $wpdb->charset, 'utf8' ) === false ) {
		ewww_image_optimizer_db_init();
		global $ewwwdb;
	} else {
		$ewwwdb = $wpdb;
	}
	global $optimized_list;
	$image_count           = 0;
	$attachments_processed = 0;
	$attachment_query      = '';
	$images                = array();
	$attachment_images     = array();
	$reset_images          = array();
	$queued_ids            = array();
	$field_formats         = array(
		'%s', // path.
		'%s', // gallery.
		'%d', // orig_size.
		'%d', // attachment_id.
		'%s', // resize.
		'%d', // pending.
	);
	ewwwio_debug_message( 'scanning for media attachments' );
	update_option( 'ewww_image_optimizer_bulk_resume', 'scanning' );
	set_transient( 'ewww_image_optimizer_no_scheduled_optimization', true, 60 * MINUTE_IN_SECONDS );

	// Retrieve the time when the scan starts.
	$started        = microtime( true );
	$attachment_ids = get_option( 'ewww_image_optimizer_scanning_attachments' );
	// Make the Force Re-optimize option persistent.
	if ( ! empty( $_REQUEST['ewww_force'] ) ) {
		set_transient( 'ewww_image_optimizer_force_reopt', true, HOUR_IN_SECONDS );
	} else {
		delete_transient( 'ewww_image_optimizer_force_reopt' );
	}

	if ( ! empty( $attachment_ids ) && count( $attachment_ids ) > 300 ) {
		ewww_image_optimizer_debug_log();
		ewww_image_optimizer_optimized_list();
	} elseif ( ! empty( $attachment_ids ) ) {
		$optimized_list = 'small_scan';
	}
	ewww_image_optimizer_debug_log();

	list( $bad_attachments, $bad_attachment ) = ewww_image_optimizer_get_bad_attachments();

	$max_query = apply_filters( 'ewww_image_optimizer_count_optimized_queries', 4000 );
	$max_query = (int) $max_query;

	$attachment_ids = get_option( 'ewww_image_optimizer_scanning_attachments' );
	if ( empty( $attachment_ids ) ) {
		// When the media library is finished, run the aux script function to scan for additional images.
		ewww_image_optimizer_aux_images_script();
	}

	$disabled_sizes = get_option( 'ewww_image_optimizer_disable_resizes_opt' );

	$enabled_types = array();
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_jpg_level' ) ) {
		$enabled_types[] = 'image/jpeg';
	}
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
		$enabled_types[] = 'image/png';
	}
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_gif_level' ) ) {
		$enabled_types[] = 'image/gif';
	}
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_pdf_level' ) ) {
		$enabled_types[] = 'application/pdf';
	}

	ewww_image_optimizer_debug_log();
	$starting_memory_usage = memory_get_usage( true );
	while ( microtime( true ) - $started < apply_filters( 'ewww_image_optimizer_timeout', 22 ) && count( $attachment_ids ) ) {
		ewww_image_optimizer_debug_log();
		if ( ! empty( $estimated_batch_memory ) && ! ewwwio_check_memory_available( 3146000 + $estimated_batch_memory ) ) { // Initial batch storage used + 3MB.
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				if ( is_array( $optimized_list ) ) {
					set_transient( 'ewww_image_optimizer_low_memory_mode', 'low_memory', 600 ); // Keep us in low memory mode for up to 10 minutes.
					$optimized_list = 'low_memory';
				}
			} else {
				break;
			}
		}
		if ( ! empty( $attachment_ids ) && is_array( $attachment_ids ) ) {
			$selected_ids = null;
			ewwwio_debug_message( 'remaining items: ' . count( $attachment_ids ) );
			// Retrieve the attachment IDs that were pre-loaded in the database.
			$selected_ids = array_splice( $attachment_ids, 0, $max_query );
			array_walk( $selected_ids, 'intval' );
			ewwwio_debug_message( 'selected items: ' . count( $selected_ids ) );
			$attachments_in = implode( ',', $selected_ids );
		} else {
			ewwwio_debug_message( 'no array found' );
			ewwwio_ob_clean();
			die( ewwwio_json_encode( array( 'error' => esc_html__( 'List of attachment IDs not found.', 'ewww-image-optimizer' ) ) ) );
		}

		$failsafe_selected_ids = $selected_ids;

		$attachment_meta = ewww_image_optimizer_fetch_metadata_batch( $attachments_in );
		$attachments_in  = null;

		// If we just completed the first batch, check how much the memory usage increased.
		if ( empty( $estimated_batch_memory ) ) {
			$estimated_batch_memory = memory_get_usage( true ) - $starting_memory_usage;
			if ( ! $estimated_batch_memory ) { // If the memory did not appear to increase, set it to a safe default.
				$estimated_batch_memory = 3146000;
			}
			ewwwio_debug_message( "estimated batch memory is $estimated_batch_memory" );
		}

		ewwwio_debug_message( 'validated ' . count( $attachment_meta ) . ' attachment meta items' );
		ewwwio_debug_message( 'remaining items after selection: ' . count( $attachment_ids ) );
		foreach ( $selected_ids as $selected_id ) {
			$attachments_processed++;
			if ( 0 == $attachments_processed % 5 && ( microtime( true ) - $started > apply_filters( 'ewww_image_optimizer_timeout', 22 ) || ! ewwwio_check_memory_available( 2194304 ) ) ) {
				ewwwio_debug_message( 'time exceeded, or memory exceeded' );
				ewww_image_optimizer_debug_log();
				$attachment_ids = array_merge( $failsafe_selected_ids, $attachment_ids );
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					if ( is_array( $optimized_list ) ) {
						set_transient( 'ewww_image_optimizer_low_memory_mode', 'low_memory', 600 ); // Keep us in low memory mode for up to 10 minutes.
						$optimized_list = 'low_memory';
					}
					break;
				} else {
					break 2;
				}
			}
			ewww_image_optimizer_debug_log();
			array_shift( $failsafe_selected_ids );
			clearstatcache();
			$pending     = false;
			$remote_file = false;
			if ( ! empty( $attachment_meta[ $selected_id ]['tinypng'] ) ) {
				ewwwio_debug_message( "TinyPNG already compressed $selected_id" );
				continue;
			}
			if ( empty( $attachment_meta[ $selected_id ]['meta'] ) ) {
				ewwwio_debug_message( "empty meta for $selected_id" );
				$meta = array();
			} else {
				$meta = maybe_unserialize( $attachment_meta[ $selected_id ]['meta'] );
			}
			if ( ! empty( $attachment_meta[ $selected_id ]['type'] ) ) {
				$mime = $attachment_meta[ $selected_id ]['type'];
				ewwwio_debug_message( "got mime via db query: $mime" );
			} elseif ( ! empty( $meta['file'] ) ) {
				$mime = ewww_image_optimizer_quick_mimetype( $meta['file'] );
				ewwwio_debug_message( "got quick mime via filename: $mime" );
			} elseif ( ! empty( $selected_id ) ) {
				$mime = get_post_mime_type( $selected_id );
				ewwwio_debug_message( "checking mime via get_post_mime_type: $mime" );
			}
			if ( empty( $mime ) ) {
				ewwwio_debug_message( "missing mime for $selected_id" );
			}

			if ( 'application/pdf' != $mime // NOT a pdf...
				&& ! in_array( $selected_id, $bad_attachments ) // AND NOT a known broken attachment, which would mean we already tried this once before...
				&& ( // AND...
					empty( $meta ) // metadata is empty...
					|| ( is_string( $meta ) && 'processing' == $meta ) // OR the string 'processing'...
					|| ( is_array( $meta ) && ! empty( $meta[0] ) && 'processing' == $meta[0] ) // OR array( 'processing' ).
				)
			) {
				// Attempt to rebuild the metadata.
				ewwwio_debug_message( "attempting to rebuild attachment meta for $selected_id" );
				set_transient( 'ewww_image_optimizer_rebuilding_attachment', $selected_id, 5 * MINUTE_IN_SECONDS );
				ewww_image_optimizer_debug_log();
				$new_meta = ewww_image_optimizer_rebuild_meta( $selected_id );
				delete_transient( 'ewww_image_optimizer_rebuilding_attachment' );
				if ( is_array( $new_meta ) ) {
					$meta = $new_meta;
				} else {
					$meta = array();
				}
			}

			if ( ! in_array( $mime, $enabled_types ) ) {
				continue;
			}
			ewwwio_debug_message( "id: $selected_id and type: $mime" );
			ewww_image_optimizer_debug_log();
			$attached_file = ( ! empty( $attachment_meta[ $selected_id ]['_wp_attached_file'] ) ? $attachment_meta[ $selected_id ]['_wp_attached_file'] : '' );

			list( $file_path, $upload_path ) = ewww_image_optimizer_attachment_path( $meta, $selected_id, $attached_file, false );

			// Run a quick fix for as3cf files.
			if ( class_exists( 'Amazon_S3_And_CloudFront' ) && strpos( $file_path, 's3' ) === 0 ) {
				ewww_image_optimizer_check_table_as3cf( $meta, $selected_id, $file_path );
			}
			ewww_image_optimizer_debug_log();
			if ( ( strpos( $file_path, 's3' ) === 0 || ! is_file( $file_path ) ) && ( class_exists( 'WindowsAzureStorageUtil' ) || class_exists( 'Amazon_S3_And_CloudFront' ) ) ) {
				// Construct a $file_path and proceed IF a supported CDN plugin is installed.
				ewwwio_debug_message( 'Azure or S3 detected and no local file found' );
				$file_path = get_attached_file( $selected_id );
				if ( strpos( $file_path, 's3' ) === 0 ) {
					$file_path = get_attached_file( $selected_id, true );
				}
				ewwwio_debug_message( "remote file possible: $file_path" );
				if ( ! $file_path ) {
					ewwwio_debug_message( 'no file found on remote storage, bailing' );
					continue;
				}
				$remote_file = true;
			} elseif ( ! $file_path ) {
				ewwwio_debug_message( "no file path for $selected_id" );
				continue;
			}
			ewww_image_optimizer_debug_log();
			$attachment_images['full'] = $file_path;
			$retina_path               = ewww_image_optimizer_hidpi_optimize( $file_path, true );
			if ( $retina_path ) {
				$attachment_images['full-retina'] = $retina_path;
			}
			ewww_image_optimizer_debug_log();
			// Resized versions available, see what we can find.
			if ( isset( $meta['sizes'] ) && ewww_image_optimizer_iterable( $meta['sizes'] ) ) {
				// Meta sizes don't contain a full path, so we calculate one.
				$base_ims_dir = trailingslashit( dirname( $file_path ) ) . '_resized/';
				$base_dir     = trailingslashit( dirname( $file_path ) );
				// To keep track of the ones we have already processed.
				$processed = array();
				foreach ( $meta['sizes'] as $size => $data ) {
					ewwwio_debug_message( "checking for size: $size" );
					ewww_image_optimizer_debug_log();
					if ( strpos( $size, 'webp' ) === 0 ) {
						continue;
					}
					if ( ! empty( $disabled_sizes[ $size ] ) ) {
						continue;
					}
					if ( ! empty( $disabled_sizes['pdf-full'] ) && 'full' == $size ) {
						continue;
					}
					if ( empty( $data['file'] ) ) {
						continue;
					}

					// Check to see if an IMS record exist from before a resize was moved to the IMS _resized folder.
					$ims_path = $base_ims_dir . $data['file'];
					if ( file_exists( $ims_path ) ) {
						// We reset base_dir, because base_dir potentially gets overwritten with base_ims_dir.
						$base_dir      = trailingslashit( dirname( $file_path ) );
						$ims_temp_path = $base_dir . $data['file'];
						ewwwio_debug_message( "ims path: $ims_path" );
						if ( $file_path != $ims_temp_path && is_array( $optimized_list ) && isset( $optimized_list[ $ims_temp_path ] ) ) {
							$optimized_list[ $ims_path ] = $optimized_list[ $ims_temp_path ];
							ewwwio_debug_message( "updating record {$optimized_list[ $ims_temp_path ]['id']} with $ims_path" );
							// Update our records so that we have the correct path going forward.
							$ewwwdb->update(
								$ewwwdb->ewwwio_images,
								array(
									'path'    => ewww_image_optimizer_relative_path_remove( $ims_path ),
									'updated' => $optimized_list[ $ims_temp_path ]['updated'],
								),
								array(
									'id' => $optimized_list[ $ims_temp_path ]['id'],
								)
							);
						}
						$base_dir = $base_ims_dir;
					}

					// Check through all the sizes we've processed so far.
					foreach ( $processed as $proc => $scan ) {
						// If a previous resize had identical dimensions...
						if ( $scan['height'] == $data['height'] && $scan['width'] == $data['width'] ) {
							// Found a duplicate size, get outta here!
							continue( 2 );
						}
					}
					$resize_path = $base_dir . $data['file'];
					if ( ( $remote_file || is_file( $resize_path ) ) && 'application/pdf' == $mime && 'full' == $size ) {
						$attachment_images[ 'pdf-' . $size ] = $resize_path;
					} elseif ( $remote_file || is_file( $resize_path ) ) {
						$attachment_images[ $size ] = $resize_path;
					}
					// Optimize retina image, if it exists.
					if ( function_exists( 'wr2x_get_retina' ) ) {
						$retina_path = wr2x_get_retina( $resize_path );
					} else {
						$retina_path = false;
					}
					if ( $retina_path && is_file( $retina_path ) ) {
						ewwwio_debug_message( "found retina via wr2x_get_retina $retina_path" );
						$attachment_images[ $size . '-retina' ] = $retina_path;
					} else {
						$retina_path = ewww_image_optimizer_hidpi_optimize( $resize_path, true );
						if ( $retina_path ) {
							ewwwio_debug_message( "found retina via hidpi_opt $retina_path" );
							$attachment_images[ $size . '-retina' ] = $retina_path;
						}
					}
					// Store info on the sizes we've processed, so we can check the list for duplicate sizes.
					$processed[ $size ]['width']  = $data['width'];
					$processed[ $size ]['height'] = $data['height'];
				} // End foreach().
			} // End if().

			ewww_image_optimizer_debug_log();
			// Queue sizes from a custom theme.
			if ( isset( $meta['image_meta']['resized_images'] ) && ewww_image_optimizer_iterable( $meta['image_meta']['resized_images'] ) ) {
				$imagemeta_resize_pathinfo = pathinfo( $file_path );
				$imagemeta_resize_path     = '';
				foreach ( $meta['image_meta']['resized_images'] as $index => $imagemeta_resize ) {
					$imagemeta_resize_path = $imagemeta_resize_pathinfo['dirname'] . '/' . $imagemeta_resize_pathinfo['filename'] . '-' . $imagemeta_resize . '.' . $imagemeta_resize_pathinfo['extension'];
					if ( is_file( $imagemeta_resize_path ) ) {
						$attachment_images[ 'resized-images-' . $index ] = $imagemeta_resize_path;
					}
				}
			}

			ewww_image_optimizer_debug_log();
			// Queue size from another custom theme.
			if ( isset( $meta['custom_sizes'] ) && ewww_image_optimizer_iterable( $meta['custom_sizes'] ) ) {
				$custom_sizes_pathinfo = pathinfo( $file_path );
				$custom_size_path      = '';
				foreach ( $meta['custom_sizes'] as $dimensions => $custom_size ) {
					$custom_size_path = $custom_sizes_pathinfo['dirname'] . '/' . $custom_size['file'];
					if ( is_file( $custom_size_path ) ) {
						$attachment_images[ 'custom-size-' . $dimensions ] = $custom_size_path;
					}
				}
			}

			ewww_image_optimizer_debug_log();
			// Check if the files are 'prev opt', pending, or brand new, and then queue the file as needed.
			foreach ( $attachment_images as $size => $file_path ) {
				ewwwio_debug_message( "here is a path $file_path" );
				ewww_image_optimizer_debug_log();
				if ( ! $remote_file && strpos( $file_path, 's3' ) !== 0 && ! defined( 'EWWW_IMAGE_OPTIMIZER_RELATIVE' ) ) {
					$file_path = realpath( $file_path );
				}
				if ( empty( $file_path ) ) {
					continue;
				}
				if ( apply_filters( 'ewww_image_optimizer_bypass', false, $file_path ) === true ) {
					ewwwio_debug_message( "skipping $file_path as instructed" );
					ewww_image_optimizer_debug_log();
					continue;
				}
				ewwwio_debug_message( "here is the real path $file_path" );
				ewwwio_debug_message( 'memory used: ' . memory_get_usage( true ) );
				ewww_image_optimizer_debug_log();
				$already_optimized = false;
				if ( ! is_array( $optimized_list ) && is_string( $optimized_list ) ) {
					$already_optimized = ewww_image_optimizer_find_already_optimized( $file_path );
				} elseif ( is_array( $optimized_list ) && isset( $optimized_list[ $file_path ] ) ) {
					$already_optimized = $optimized_list[ $file_path ];
				}
				if ( is_array( $already_optimized ) && ! empty( $already_optimized ) ) {
					ewwwio_debug_message( 'potential match found' );
					ewww_image_optimizer_debug_log();
					if ( ! empty( $already_optimized['pending'] ) ) {
						$pending = true;
						ewwwio_debug_message( "pending record for $file_path" );
						ewww_image_optimizer_debug_log();
						continue;
					}
					if ( $remote_file ) {
						$image_size = $already_optimized['image_size'];
						ewwwio_debug_message( "image size for remote file is $image_size" );
						ewww_image_optimizer_debug_log();
					} else {
						$image_size = filesize( $file_path );
						ewwwio_debug_message( "image size is $image_size" );
						if ( ! $image_size ) {
							continue;
						}
						ewww_image_optimizer_debug_log();
					}
					if ( $image_size < ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_size' ) ) {
						ewwwio_debug_message( "file skipped due to filesize: $file_path" );
						ewww_image_optimizer_debug_log();
						continue;
					}
					if ( 'image/png' == $mime && ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_png_size' ) && $image_size > ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_png_size' ) ) {
						ewwwio_debug_message( "file skipped due to PNG filesize: $file_path" );
						ewww_image_optimizer_debug_log();
						continue;
					}
					if ( $already_optimized['image_size'] == $image_size && empty( $_REQUEST['ewww_force'] ) ) {
						ewwwio_debug_message( "match found for $file_path" );
						ewww_image_optimizer_debug_log();
						continue;
					} else {
						ewwwio_debug_message( "mismatch found for $file_path, db says " . $already_optimized['image_size'] . " vs. current $image_size" );
						ewww_image_optimizer_debug_log();
						$pending = true;
						if ( empty( $already_optimized['attachment_id'] ) ) {
							ewwwio_debug_message( "updating record for $file_path, with id $selected_id and resize $size" );
							ewww_image_optimizer_debug_log();
							$ewwwdb->update(
								$ewwwdb->ewwwio_images,
								array(
									'pending'       => 1,
									'attachment_id' => $selected_id,
									'gallery'       => 'media',
									'resize'        => $size,
									'updated'       => $already_optimized['updated'],
								),
								array(
									'id' => $already_optimized['id'],
								)
							);
							ewwwio_debug_message( 'updated record' );
						} else {
							ewwwio_debug_message( "adding $selected_id to reset queue" );
							ewww_image_optimizer_debug_log();
							$reset_images[] = (int) $already_optimized['id'];
						}
					}
					ewww_image_optimizer_debug_log();
				} else { // Looks like a new image.
					if ( ! empty( $images[ $file_path ] ) ) {
						continue;
					}
					$pending = true;
					ewwwio_debug_message( "queuing $file_path" );
					ewww_image_optimizer_debug_log();
					if ( $remote_file ) {
						$image_size = 0;
						ewwwio_debug_message( 'image size set to 0' );
					} else {
						$image_size = filesize( $file_path );
						ewwwio_debug_message( "image size is $image_size" );
						if ( ! $image_size ) {
							continue;
						}
						ewww_image_optimizer_debug_log();
						if ( $image_size < ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_size' ) ) {
							ewwwio_debug_message( "file skipped due to filesize: $file_path" );
							ewww_image_optimizer_debug_log();
							continue;
						}
						if ( 'image/png' == $mime && ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_png_size' ) && $image_size > ewww_image_optimizer_get_option( 'ewww_image_optimizer_skip_png_size' ) ) {
							ewwwio_debug_message( "file skipped due to PNG filesize: $file_path" );
							ewww_image_optimizer_debug_log();
							continue;
						}
					}
					if ( seems_utf8( $file_path ) ) {
						ewwwio_debug_message( 'file seems utf8' );
						$utf8_file_path = $file_path;
					} else {
						ewwwio_debug_message( 'file will become utf8' );
						$utf8_file_path = utf8_encode( $file_path );
					}
					ewww_image_optimizer_debug_log();
					$images[ $file_path ] = array(
						'path'          => ewww_image_optimizer_relative_path_remove( $utf8_file_path ),
						'gallery'       => 'media',
						'orig_size'     => $image_size,
						'attachment_id' => $selected_id,
						'resize'        => $size,
						'pending'       => 1,
					);
					$image_count++;
					ewwwio_debug_message( 'image added to $images queue' );
					ewww_image_optimizer_debug_log();
				} // End if().
				if ( $image_count > 1000 || count( $reset_images ) > 1000 ) {
					ewwwio_debug_message( 'making a dump run' );
					ewww_image_optimizer_debug_log();
					// Let's dump what we have so far to the db.
					$image_count = 0;
					if ( ! empty( $images ) ) {
						ewwwio_debug_message( 'doing mass insert' );
						ewww_image_optimizer_debug_log();
						ewww_image_optimizer_mass_insert( $wpdb->ewwwio_images, $images, $field_formats );
					}
					$images = array();
					if ( ! empty( $reset_images ) ) {
						ewwwio_debug_message( 'marking reset_images as pending' );
						ewww_image_optimizer_debug_log();
						$ewwwdb->query( "UPDATE $ewwwdb->ewwwio_images SET pending = 1, updated = updated WHERE id IN (" . implode( ',', $reset_images ) . ')' );
					}
					$reset_images = array();
				}
			} // End foreach().
			// End of loop checking all the attachment_images for selected_id to see if they are optimized already or pending already.
			if ( $pending ) {
				ewwwio_debug_message( "$selected_id added to queue" );
				ewww_image_optimizer_debug_log();
				$queued_ids[] = $selected_id;
			}
			$attachment_images = array();
			ewwwio_debug_message( 'checking for bad attachment' );
			ewww_image_optimizer_debug_log();
			if ( $selected_id == $bad_attachment ) {
				ewwwio_debug_message( 'found bad attachment, bailing to reset the counter' );
				ewww_image_optimizer_debug_log();
				if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
					$attachment_ids = array_merge( $failsafe_selected_ids, $attachment_ids );
					break 2;
				}
			}
		} // End foreach().
		// End of loop for the selected_id.
		ewwwio_debug_message( 'finished foreach, storing remaining attachments in scanning_attachments' );
		ewww_image_optimizer_debug_log();
		update_option( 'ewww_image_optimizer_scanning_attachments', $attachment_ids, false );
		$attachments_queued = get_option( 'ewww_image_optimizer_bulk_attachments' );
		if ( empty( $attachments_queued ) || ! is_array( $attachments_queued ) ) {
			ewwwio_debug_message( 'storing queued attachments in bulk_attachments' );
			ewww_image_optimizer_debug_log();
			update_option( 'ewww_image_optimizer_bulk_attachments', $queued_ids, false );
		} else {
			ewwwio_debug_message( 'storing queued attachments in bulk_attachments, merged with existing' );
			ewww_image_optimizer_debug_log();
			update_option( 'ewww_image_optimizer_bulk_attachments', array_merge( $attachments_queued, $queued_ids ), false );
		}
		$queued_ids = array();
		ewwwio_debug_message( 'finished a loop in the while, going back for more possibly' );
		ewww_image_optimizer_debug_log();
	} // End while().
	ewwwio_debug_message( 'done for a while, wrapping up' );
	ewww_image_optimizer_debug_log();
	if ( ! empty( $images ) ) {
		ewww_image_optimizer_mass_insert( $wpdb->ewwwio_images, $images, $field_formats );
	}
	if ( ! empty( $reset_images ) ) {
		$ewwwdb->query( "UPDATE $ewwwdb->ewwwio_images SET pending = 1, updated = updated WHERE id IN (" . implode( ',', $reset_images ) . ')' );
	}
	if ( 250 > $attachments_processed ) { // in-memory table is too slow.
		ewwwio_debug_message( 'using in-memory table is too slow, switching to plan b' );
		set_transient( 'ewww_image_optimizer_low_memory_mode', 'slow_list', 600 ); // Put it in low memory mode for at least 10 minutes.
	}
	ewwwio_debug_message( 'storing remaining attachments in scanning_attachments' );
	ewww_image_optimizer_debug_log();
	update_option( 'ewww_image_optimizer_scanning_attachments', $attachment_ids, false );
	if ( ! empty( $queued_ids ) ) {
		$attachments_queued = get_option( 'ewww_image_optimizer_bulk_attachments' );
		if ( empty( $attachments_queued ) || ! is_array( $attachments_queued ) ) {
			ewwwio_debug_message( 'storing queued attachments in bulk_attachments' );
			ewww_image_optimizer_debug_log();
			update_option( 'ewww_image_optimizer_bulk_attachments', $queued_ids, false );
		} else {
			ewwwio_debug_message( 'storing queued attachments in bulk_attachments, merged with existing' );
			ewww_image_optimizer_debug_log();
			update_option( 'ewww_image_optimizer_bulk_attachments', array_merge( $attachments_queued, $queued_ids ), false );
		}
	}
	$elapsed = microtime( true ) - $started;
	ewwwio_debug_message( "counting images took $elapsed seconds" );
	ewwwio_memory( __FUNCTION__ );
	ewww_image_optimizer_debug_log();
	if ( 'ewww-image-optimizer-cli' === $hook ) {
		return;
	}
	$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
	$notice        = ( 'low_memory' == get_transient( 'ewww_image_optimizer_low_memory_mode' ) ? esc_html__( "Increasing PHP's memory_limit setting will allow for faster scanning with fewer database queries. Please allow up to 10 minutes for changes to memory limit to be detected.", 'ewww-image-optimizer' ) : '' );
	if ( count( $attachment_ids ) ) {
		ewwwio_ob_clean();
		die(
			ewwwio_json_encode(
				array(
					/* translators: %d: number of images */
					'remaining'      => sprintf( esc_html__( 'Stage 1, %d images left to scan.', 'ewww-image-optimizer' ), count( $attachment_ids ) ) . "&nbsp;<img src='$loading_image' />",
					'notice'         => $notice,
					'bad_attachment' => $bad_attachment,
				)
			)
		);
	} else {
		ewwwio_ob_clean();
		die(
			ewwwio_json_encode(
				array(
					'remaining'      => esc_html__( 'Stage 2, please wait.', 'ewww-image-optimizer' ) . "&nbsp;<img src='$loading_image' />",
					'notice'         => $notice,
					'bad_attachment' => $bad_attachment,
				)
			)
		);
	}
}

/**
 * Called via AJAX to get an update on the API quota usage.
 */
function ewww_image_optimizer_bulk_quota_update() {
	// Verify that an authorized user has made the request.
	$permissions = apply_filters( 'ewww_image_optimizer_bulk_permissions', '' );
	if ( ! wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' ) || ! current_user_can( $permissions ) ) {
		ewwwio_ob_clean();
		die( esc_html__( 'Access token has expired, please reload the page.', 'ewww-image-optimizer' ) );
	}
	ewwwio_ob_clean();
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_cloud_key' ) ) {
		echo esc_html__( 'Image credits available:', 'ewww-image-optimizer' ) . ' ' . ewww_image_optimizer_cloud_quota();
	}
	ewwwio_memory( __FUNCTION__ );
	die();
}

/**
 * Called via AJAX to start the bulk operation and get the name of the first image in the queue.
 */
function ewww_image_optimizer_bulk_initialize() {
	// Verify that an authorized user has made the request.
	$permissions = apply_filters( 'ewww_image_optimizer_bulk_permissions', '' );
	if ( ! wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' ) || ! current_user_can( $permissions ) ) {
		ewwwio_ob_clean();
		die( ewwwio_json_encode( array( 'error' => esc_html__( 'Access token has expired, please reload the page.', 'ewww-image-optimizer' ) ) ) );
	}
	session_write_close();
	$output      = array();
	$attachments = get_option( 'ewww_image_optimizer_bulk_attachments' );
	if ( ! is_array( $attachments ) && ! empty( $attachments ) ) {
		$attachments = unserialize( $attachments );
	}
	if ( ! is_array( $attachments ) ) {
		// See if we care about the attachment list missing: resizing or converting to be done.
		if ( ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_maxmediawidth' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_maxmediaheight' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_maxotherwidth' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_maxotherheight' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_jpg_to_png' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_to_jpg' ) ||
			ewww_image_optimizer_get_option( 'ewww_image_optimizer_gif_to_png' ) ) &&
			ewww_image_optimizer_aux_images_table_count_pending_media()
		) {
			if ( ewww_image_optimizer_function_exists( 'print_r' ) ) {
				ewwwio_ob_clean();
				die(
					ewwwio_json_encode(
						array(
							'error' => esc_html__( 'Error retrieving list of images', 'ewww-image-optimizer' ),
							'data'  => print_r( $attachments, true ),
						)
					)
				);
			} else {
				ewwwio_ob_clean();
				die(
					ewwwio_json_encode(
						array(
							'error' => esc_html__( 'Error retrieving list of images', 'ewww-image-optimizer' ),
							'data'  => 'print_r disabled',
						)
					)
				);
			}
		}
	}
	// Update the 'bulk resume' option to show that an operation is in progress.
	update_option( 'ewww_image_optimizer_bulk_resume', 'true' );
	$attachment = (int) array_shift( $attachments );
	ewwwio_debug_message( "first image: $attachment" );
	$first_image = new EWWW_Image( $attachment, 'media' );
	$file        = $first_image->file;
	// Generate the WP spinner image for display.
	$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
	// Let the user know that we are beginning.
	if ( $file ) {
		$output['results'] = '<p>' . esc_html__( 'Optimizing', 'ewww-image-optimizer' ) . " <b>$file</b>&nbsp;<img src='$loading_image' /></p>";
	} else {
		$output['results'] = '<p>' . esc_html__( 'Optimizing', 'ewww-image-optimizer' ) . "&nbsp;<img src='$loading_image' /></p>";
	}
	$output['start_time'] = time();
	ewwwio_memory( __FUNCTION__ );
	ewwwio_ob_clean();
	die( ewwwio_json_encode( $output ) );
}

/**
 * Skips an un-optimizable image after all counter-measures have been attempted.
 *
 * @param object $image The EWWW_Image object representing the image to skip.
 */
function ewww_image_optimizer_bulk_skip_image( $image ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	ewww_image_optimizer_update_table( $image->file, filesize( $image->file ), filesize( $image->file ) );
}

/**
 * Checks if any optimization failures have been detected and attempts to react accordingly.
 *
 * @param object $image The EWWW_Image object representing the currently queued image.
 */
function ewww_image_optimizer_bulk_counter_measures( $image ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	if ( ! empty( $_REQUEST['ewww_error_counter'] ) ) {
		$error_counter = (int) $_REQUEST['ewww_error_counter'];
		if ( 30 != $error_counter ) {
			$failed_file              = get_transient( 'ewww_image_optimizer_failed_file' );
			$previous_incomplete_file = get_transient( 'ewww_image_optimizer_bulk_current_image' );
			if ( is_array( get_transient( 'ewww_image_optimizer_bulk_counter_measures' ) ) ) {
				$previous_countermeasures = get_transient( 'ewww_image_optimizer_bulk_counter_measures' );
			} else {
				$previous_countermeasures = array(
					'resize_existing' => false,
					'png50'           => false,
					'png40'           => false,
					'png2jpg'         => false,
					'pngdefaults'     => false,
					'jpg2png'         => false,
					'jpg40'           => false,
					'gif2png'         => false,
					'pdf20'           => false,
				);
			}
			if ( $failed_file == $image->file || $previous_incomplete_file == $image->file ) {
				ewwwio_debug_message( "failed file detected, taking evasive action: $failed_file" );
				// Use the constants for temporary overrides, while keeping track of which ones we've used.
				if ( 'image/png' == ewww_image_optimizer_quick_mimetype( $image->file ) ) {
					if ( empty( $previous_countermeasures['png50'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL' ) && 50 == ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
						ewwwio_debug_message( 'png50' );
						// If the file is a PNG and compression is 50, try 40.
						define( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL', 40 );
						$previous_countermeasures['png50'] = true;
					} elseif ( empty( $previous_countermeasures['png40'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL' ) && 40 <= ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
						ewwwio_debug_message( 'png40' );
						// If the file is a PNG and compression is 40 (or higher), try 20.
						define( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL', 20 );
						$previous_countermeasures['png40'] = true;
					} elseif ( empty( $previous_countermeasures['png2jpg'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_PNG_TO_JPG' ) && ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_to_jpg' ) ) {
						ewwwio_debug_message( 'png2jpg' );
						// If the file is a PNG and PNG2JPG is enabled.
						// also set png level to 20 if needed...
						define( 'EWWW_IMAGE_OPTIMIZER_PNG_TO_JPG', false );
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL' ) && 40 <= ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL', 20 );
						}
						$previous_countermeasures['png2jpg'] = true;
					} elseif ( empty( $previous_countermeasures['pngdefaults'] )
						&& 10 == ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' )
						&& ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_optipng_level' ) > 2
						|| ! ewww_image_optimizer_get_option( 'ewww_image_optimizer_disable_pngout' ) )
					) {
						ewwwio_debug_message( 'pngdefaults' );
						// If PNG compression is 10 with pngout or optipng set higher than 2 or pngout enabled.
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_OPTIPNG_LEVEL' ) && 2 < ewww_image_optimizer_get_option( 'ewww_image_optimizer_optipng_level' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_OPTIPNG_LEVEL', 2 );
						}
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_DISABLE_PNGOUT' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_DISABLE_PNGOUT', true );
						}
						$previous_countermeasures['pngdefaults'] = true;
					} elseif ( empty( $previous_countermeasures['resize_existing'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_RESIZE_EXISTING' ) && ewww_image_optimizer_get_option( 'ewww_image_optimizer_resize_existing' ) ) {
						ewwwio_debug_message( 'resize_existing' );
						// If resizing is enabled, try to disable it.
						define( 'EWWW_IMAGE_OPTIMIZER_RESIZE_EXISTING', false );
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL' ) && 40 <= ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_PNG_LEVEL', 20 );
						}
						if ( 10 == ewww_image_optimizer_get_option( 'ewww_image_optimizer_png_level' ) ) {
							if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_OPTIPNG_LEVEL' ) && 2 < ewww_image_optimizer_get_option( 'ewww_image_optimizer_optipng_level' ) ) {
								define( 'EWWW_IMAGE_OPTIMIZER_OPTIPNG_LEVEL', 2 );
							}
							if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_DISABLE_PNGOUT' ) ) {
								define( 'EWWW_IMAGE_OPTIMIZER_DISABLE_PNGOUT', true );
							}
						}
						$previous_countermeasures['resize_existing'] = true;
					} else {
						// If the file is a PNG and nothing else worked, skip it.
						ewww_image_optimizer_bulk_skip_image( $image );
					} // End if().
				} // End if().
				if ( 'image/jpeg' == ewww_image_optimizer_quick_mimetype( $image->file ) ) {
					if ( empty( $previous_countermeasures['jpg2png'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG' ) && ewww_image_optimizer_get_option( 'ewww_image_optimizer_jpg_to_png' ) ) {
						ewwwio_debug_message( 'jpg2png' );
						// If the file is a JPG and JPG2PNG is enabled.
						define( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG', false );
						$previous_countermeasures['jpg2png'] = true;
					} elseif ( empty( $previous_countermeasures['jpg40'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_JPG_LEVEL' ) && 40 == ewww_image_optimizer_get_option( 'ewww_image_optimizer_jpg_level' ) ) {
						ewwwio_debug_message( 'jpg40' );
						// If the file is a JPG and level 40 is enabled, drop it to 30 (and nuke jpg2png).
						define( 'EWWW_IMAGE_OPTIMIZER_JPG_LEVEL', 30 );
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG', false );
						}
						$previous_countermeasures['jpg40'] = true;
					} elseif ( empty( $previous_countermeasures['resize_existing'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_RESIZE_EXISTING' ) && ewww_image_optimizer_get_option( 'ewww_image_optimizer_resize_existing' ) ) {
						ewwwio_debug_message( 'resize_existing' );
						// If resizing is enabled, try to disable it.
						define( 'EWWW_IMAGE_OPTIMIZER_RESIZE_EXISTING', false );
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_JPG_LEVEL' ) && 40 == ewww_image_optimizer_get_option( 'ewww_image_optimizer_jpg_level' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_JPG_LEVEL', 30 );
						}
						if ( ! defined( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG' ) ) {
							define( 'EWWW_IMAGE_OPTIMIZER_JPG_TO_PNG', false );
						}
						$previous_countermeasures['resize_existing'] = true;
					} else {
						// If all else fails, skip it.
						ewww_image_optimizer_bulk_skip_image( $image );
					}
				}
				if ( 'image/gif' == ewww_image_optimizer_quick_mimetype( $image->file ) ) {
					if ( empty( $previous_countermeasures['gif2png'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_GIF_TO_PNG' ) && ewww_image_optimzer_get_option( 'ewww_image_optimizer_gif_to_png' ) ) {
						ewwwio_debug_message( 'gif2png' );
						// If the file is a GIF and GIF2PNG is enabled.
						define( 'EWWW_IMAGE_OPTIMIZER_GIF_TO_PNG', false );
						$previous_countermeasures['gif2png'] = true;
					} else {
						// If all else fails, skip it.
						ewww_image_optimizer_bulk_skip_image( $image );
					}
				}
				if ( 'application/pdf' == ewww_image_optimizer_quick_mimetype( $image->file ) ) {
					if ( empty( $previous_countermeasures['pdf20'] ) && ! defined( 'EWWW_IMAGE_OPTIMIZER_PDF_LEVEL' ) && 20 == ewww_image_optimzer_get_option( 'ewww_image_optimizer_pdf_level' ) ) {
						ewwwio_debug_message( 'pdf20' );
						// If lossy PDF is enabled, drop it down a notch.
						define( 'EWWW_IMAGE_OPTIMIZER_PDF_LEVEL', 10 );
						$previous_countermeasures['pdf20'] = true;
					} else {
						// If all else fails, skip it.
						ewww_image_optimizer_bulk_skip_image( $image );
					}
				}
				set_transient( 'ewww_image_optimizer_bulk_counter_measures', $previous_countermeasures, 600 );
				// MAYBE:::In any of the cases, output some sort of warning to let the user know we took evasive action, and they might need to adjust their settings.
			} // End if().
			set_transient( 'ewww_image_optimizer_failed_file', $image->file, 600 );
			return $previous_countermeasures;
		} else {
			delete_transient( 'ewww_image_optimizer_failed_file' );
			delete_transient( 'ewww_image_optimizer_bulk_counter_measures' );
		} // End if().
	} // End if().
	return false;
}
/**
 * Called by AJAX to process each image in the queue.
 *
 * @global object $wpdb
 * @global bool $ewww_defer Change to false so nothing is deferred.
 *
 * @param string $hook Optional. Lets us know if WP-CLI is running. Default empty.
 * @param int    $delay Optional. Number of seconds to pause between images. Default 0.
 * @return bool When using WP-CLI, true keeps the process running, false indicates completion.
 */
function ewww_image_optimizer_bulk_loop( $hook = '', $delay = 0 ) {
	ewwwio_debug_message( '<b>' . __FUNCTION__ . '()</b>' );
	global $ewww_defer;
	$ewww_defer      = false;
	$output          = array();
	$time_adjustment = 0;
	// Verify that an authorized user has started the optimizer.
	$permissions = apply_filters( 'ewww_image_optimizer_bulk_permissions', '' );
	if ( 'ewww-image-optimizer-cli' !== $hook && ( ! wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' ) || ! current_user_can( $permissions ) ) ) {
		ewwwio_ob_clean();
		die( ewwwio_json_encode( array( 'error' => esc_html__( 'Access token has expired, please reload the page.', 'ewww-image-optimizer' ) ) ) );
	}
	session_write_close();
	// Retrieve the time when the optimizer starts.
	$started = microtime( true );
	// Prevent the scheduled optimizer from firing during a bulk optimization.
	set_transient( 'ewww_image_optimizer_no_scheduled_optimization', true, 10 * MINUTE_IN_SECONDS );
	// Make the Force Re-optimize option persistent.
	if ( ! empty( $_REQUEST['ewww_force'] ) ) {
		set_transient( 'ewww_image_optimizer_force_reopt', true, HOUR_IN_SECONDS );
	} else {
		delete_transient( 'ewww_image_optimizer_force_reopt' );
	}
	// Find out if our nonce is on it's last leg/tick.
	if ( ! empty( $_REQUEST['ewww_wpnonce'] ) ) {
		$tick = wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' );
		if ( 2 === $tick ) {
			$output['new_nonce'] = wp_create_nonce( 'ewww-image-optimizer-bulk' );
		} else {
			$output['new_nonce'] = '';
		}
	}
	$batch_image_limit = ( empty( $_REQUEST['ewww_batch_limit'] ) ? 999 : 1 );
	// Get the 'bulk attachments' with a list of IDs remaining.
	$attachments = get_option( 'ewww_image_optimizer_bulk_attachments' );
	if ( ! empty( $attachments ) && is_array( $attachments ) ) {
		$attachment = (int) $attachments[0];
	} else {
		$attachment = 0;
	}
	$image = new EWWW_Image( $attachment, 'media' );
	if ( ! $image->file ) {
		ewwwio_ob_clean();
		die(
			ewwwio_json_encode(
				array(
					'done'      => 1,
					'completed' => 0,
				)
			)
		);
	}

	$output['results']   = '';
	$output['completed'] = 0;
	while ( $output['completed'] < $batch_image_limit && $image->file && microtime( true ) - $started + $time_adjustment < apply_filters( 'ewww_image_optimizer_timeout', 15 ) ) {
		$output['completed']++;
		$meta = false;
		// See if the image needs fetching from a CDN.
		if ( ! is_file( $image->file ) ) {
			$meta      = wp_get_attachment_metadata( $image->attachment_id );
			$file_path = ewww_image_optimizer_remote_fetch( $image->attachment_id, $meta );
			unset( $meta );
			if ( ! $file_path ) {
				ewwwio_debug_message( 'could not retrieve path' );
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					WP_CLI::line( __( 'Could not find image', 'ewww-image-optimizer' ) . ' ' . $image->file );
				} else {
					$output['results'] .= sprintf( '<p>' . esc_html__( 'Could not find image', 'ewww-image-optimizer' ) . ' <strong>%s</strong></p>', esc_html( $image->file ) );
				}
			}
		}
		// If a resize is missing, see if it should (and can) be regenerated.
		if ( $image->resize && 'full' != $image->resize && ! is_file( $image->file ) ) {
			// TODO: Make sure this is optional, because of CDN offloading: resized image does not exist, regenerate it.
		}
		$countermeasures = ewww_image_optimizer_bulk_counter_measures( $image );
		if ( $countermeasures ) {
			$batch_image_limit = 1;
		}
		set_transient( 'ewww_image_optimizer_bulk_current_image', $image->file, 600 );
		if ( 'full' === $image->resize && ewww_image_optimizer_get_option( 'ewww_image_optimizer_resize_existing' ) && ! function_exists( 'imsanity_get_max_width_height' ) ) {
			if ( ! $meta || ! is_array( $meta ) ) {
				$meta = wp_get_attachment_metadata( $image->attachment_id );
			}
			$new_dimensions = ewww_image_optimizer_resize_upload( $image->file );
			if ( ! empty( $new_dimensions ) && is_array( $new_dimensions ) ) {
				$meta['width']  = $new_dimensions[0];
				$meta['height'] = $new_dimensions[1];
			}
		}
		list( $file, $msg, $converted, $original ) = ewww_image_optimizer( $image->file, 1, false, false, 'full' == $image->resize );
		// Gotta make sure we don't delete a pending record if the license is exceeded, so the license check goes first.
		$ewww_status = get_transient( 'ewww_image_optimizer_cloud_status' );
		if ( ! empty( $ewww_status ) && preg_match( '/exceeded/', $ewww_status ) ) {
			$output['error'] = esc_html__( 'License Exceeded', 'ewww-image-optimizer' );
			delete_transient( 'ewww_image_optimizer_bulk_counter_measures' );
			delete_transient( 'ewww_image_optimizer_bulk_current_image' );
			ewwwio_ob_clean();
			die( ewwwio_json_encode( $output ) );
		}
		// Delete a pending record if the optimization failed for whatever reason.
		if ( ! $file && $image->id ) {
			global $wpdb;
			$wpdb->delete(
				$wpdb->ewwwio_images,
				array(
					'id' => $image->id,
				),
				array( '%d' )
			);
		}
		// If this is a full size image and it was converted.
		if ( 'full' == $image->resize && ( false !== $image->increment || false !== $converted ) ) {
			if ( ! $meta || ! is_array( $meta ) ) {
				$meta = wp_get_attachment_metadata( $image->attachment_id );
			}
			if ( $converted ) {
				$image->increment = $converted;
			}
			$image->file      = $file;
			$image->converted = $original;
			$meta['file']     = trailingslashit( dirname( $meta['file'] ) ) . basename( $file );
			$image->update_converted_attachment( $meta );
			$meta = $image->convert_sizes( $meta );
		}

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::line( __( 'Optimized', 'ewww-image-optimizer' ) . ' ' . $image->file );
			WP_CLI::line( str_replace( '&nbsp;', '', $msg ) );
		}
		$output['results'] .= sprintf( '<p>' . esc_html__( 'Optimized', 'ewww-image-optimizer' ) . ' <strong>%s</strong><br>', esc_html( $image->file ) );
		$output['results'] .= "$msg</p>";

		// Do metadata update after full-size is processed, usually because of conversion or resizing.
		if ( 'full' == $image->resize && $image->attachment_id ) {
			if ( $meta && is_array( $meta ) ) {
				$meta_saved = wp_update_attachment_metadata( $image->attachment_id, $meta );
				if ( ! $meta_saved ) {
					ewwwio_debug_message( 'failed to save meta' );
				}
			}
		}

		// Pull the next image.
		$next_image = new EWWW_Image( $attachment, 'media' );

		// When we finish all the sizes, we want to fire off any filters for plugins that might need to take action when an image is updated.
		if ( $attachment && $attachment != $next_image->attachment_id ) {
			$meta = apply_filters( 'wp_update_attachment_metadata', wp_get_attachment_metadata( $image->attachment_id ), $image->attachment_id );
		}
		// When an image (attachment) is done, pull the next attachment ID off the stack.
		if ( ( 'full' == $next_image->resize || empty( $next_image->resize ) ) && ! empty( $attachment ) && $attachment != $next_image->attachment_id ) {
			$attachment = (int) array_shift( $attachments ); // Pull the last image off the stack first.
			if ( ! empty( $attachments ) && is_array( $attachments ) ) {
				$attachment = (int) $attachments[0]; // Then grab the next one (if any are left).
			} else {
				$attachment = 0;
			}
			$next_image = new EWWW_Image( $attachment, 'media' );
		}
		$image           = $next_image;
		$time_adjustment = $image->time_estimate();
	} // End while().

	ewwwio_debug_message( 'ending loop for now' );
	// Calculate how much time has elapsed since we started.
	$elapsed = microtime( true ) - $started;
	// Output how much time has elapsed since we started.
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		/* translators: %s: number of seconds */
		WP_CLI::line( sprintf( _n( 'Elapsed: %s second', 'Elapsed: %s seconds', $elapsed, 'ewww-image-optimizer' ), number_format_i18n( $elapsed ) ) );
		if ( ewww_image_optimizer_function_exists( 'sleep' ) ) {
			sleep( $delay );
		}
	}
	/* translators: %s: number of seconds */
	$output['results'] .= sprintf( '<p>' . esc_html( _n( 'Elapsed: %s second', 'Elapsed: %s seconds', $elapsed, 'ewww-image-optimizer' ) ) . '</p>', number_format_i18n( $elapsed ) );
	// Store the updated list of attachment IDs back in the 'bulk_attachments' option.
	update_option( 'ewww_image_optimizer_bulk_attachments', $attachments, false );
	if ( ewww_image_optimizer_get_option( 'ewww_image_optimizer_debug' ) ) {
		global $ewww_debug;
		$debug_button       = esc_html__( 'Show Debug Output', 'ewww-image-optimizer' );
		$debug_id           = uniqid();
		$output['results'] .= "<button type='button' class='ewww-show-debug-meta button button-secondary' data-id='$debug_id'>$debug_button</button><div class='ewww-debug-meta-$debug_id' style='background-color:#ffff99;display:none;'>$ewww_debug</div>";
	}
	if ( ! empty( $next_image->file ) ) {
		$next_file = esc_html( $next_image->file );
		// Generate the WP spinner image for display.
		$loading_image = plugins_url( '/images/wpspin.gif', __FILE__ );
		if ( $next_file ) {
			$output['next_file'] = '<p>' . esc_html__( 'Optimizing', 'ewww-image-optimizer' ) . " <b>$next_file</b>&nbsp;<img src='$loading_image' /></p>";
		} else {
			$output['next_file'] = '<p>' . esc_html__( 'Optimizing', 'ewww-image-optimizer' ) . "&nbsp;<img src='$loading_image' /></p>";
		}
	} else {
		$output['done'] = 1;
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			delete_transient( 'ewww_image_optimizer_bulk_counter_measures' );
			delete_transient( 'ewww_image_optimizer_bulk_current_image' );
			return false;
		}
	}
	ewww_image_optimizer_debug_log();
	delete_transient( 'ewww_image_optimizer_bulk_counter_measures' );
	delete_transient( 'ewww_image_optimizer_bulk_current_image' );
	ewwwio_memory( __FUNCTION__ );
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return true;
	}
	$output['current_time'] = time();
	ewwwio_ob_clean();
	die( ewwwio_json_encode( $output ) );
}

/**
 * Called by javascript to cleanup after ourselves after a bulk operation.
 */
function ewww_image_optimizer_bulk_cleanup() {
	// Verify that an authorized user has started the optimizer.
	$permissions = apply_filters( 'ewww_image_optimizer_bulk_permissions', '' );
	if ( ! wp_verify_nonce( $_REQUEST['ewww_wpnonce'], 'ewww-image-optimizer-bulk' ) || ! current_user_can( $permissions ) ) {
		ewwwio_ob_clean();
		die( '<p><b>' . esc_html__( 'Access token has expired, please reload the page.', 'ewww-image-optimizer' ) . '</b></p>' );
	}
	// All done, so we can update the bulk options with empty values.
	update_option( 'ewww_image_optimizer_aux_resume', '' );
	update_option( 'ewww_image_optimizer_bulk_resume', '' );
	update_option( 'ewww_image_optimizer_bulk_attachments', '', false );
	delete_transient( 'ewww_image_optimizer_skip_aux' );
	delete_transient( 'ewww_image_optimizer_force_reopt' );
	// Let the user know we are done.
	ewwwio_memory( __FUNCTION__ );
	ewwwio_ob_clean();
	die( '<p><b>' . esc_html__( 'Finished', 'ewww-image-optimizer' ) . '</b> - <a href="upload.php">' . esc_html__( 'Return to Media Library', 'ewww-image-optimizer' ) . '</a></p>' );
}

add_action( 'admin_enqueue_scripts', 'ewww_image_optimizer_bulk_script' );
add_action( 'wp_ajax_bulk_scan', 'ewww_image_optimizer_media_scan' );
add_action( 'wp_ajax_bulk_init', 'ewww_image_optimizer_bulk_initialize' );
add_action( 'wp_ajax_bulk_filename', 'ewww_image_optimizer_bulk_filename' );
add_action( 'wp_ajax_bulk_loop', 'ewww_image_optimizer_bulk_loop' );
add_action( 'wp_ajax_bulk_cleanup', 'ewww_image_optimizer_bulk_cleanup' );
add_action( 'wp_ajax_bulk_quota_update', 'ewww_image_optimizer_bulk_quota_update' );
add_filter( 'ewww_image_optimizer_count_optimized_queries', 'ewww_image_optimizer_reduce_query_count' );
?>
