<?php
/**
 * Creates the shortcode function for showing the playoff bracket shortcode.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public/partials/shortcodes
 * @author     Jacob Martella <me@jacobmartella.com>
 */

/**
 * Renders the playoff bracket shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_brackets_shortcode( $atts ) {
	extract(
		shortcode_atts(
			[
				'bracket_id' => 0,
			],
			$atts
		)
	);

	$html = '';

	if ( $bracket_id > 0 ) {
		$html = sports_bench_show_playoff_bracket( $bracket_id );
	}

	return $html;
}

