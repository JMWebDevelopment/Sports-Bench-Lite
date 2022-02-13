<?php
/**
 * The file that defines the screen class
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */

namespace Sports_Bench\Classes\Screens;

/**
 * The core screen class.
 *
 * This is used for functions for admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class Screen {

	/**
	 * Creates the new Screen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Returns a link to a page in the client manager based on the parameters give.
	 *
	 * @since 1.0.0
	 *
	 * @param string|null $page      The page to go to.
	 * @return string                The url for the page to go to.
	 */
	public function get_admin_page_link( $page = null ) {

		if ( null === $page ) {
			return;
		}

		return get_admin_url( null, '/admin.php?page=' . $page );

	}

	/**
	 * Displays the header for all of the Sports Bench admin screens.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML to show the header for the admin pages.
	 */
	public function display_header() {
		$html = '<div class="sports-bench-header">';

		$html .= '<div class="wrap">';
		$html .= '<img src="' . plugin_dir_url( __FILE__ ) . '../../../admin/images/sb-logo-light-blue.png' . '" alt="Sports Bench Logo" />';
		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}


}
