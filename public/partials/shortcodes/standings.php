<?php
/**
 * Creates the shortcode function for showing the standings shortcode.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public/partials/shortcodes
 * @author     Jacob Martella <me@jacobmartella.com>
 */

/**
 * Renders the standings shortcode.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the shortcode.
 */
function sports_bench_standings_shortcode() {
	return sports_bench_standings_page_template();
}
