<?php
/**
 * Creates the shortcode function for showing the team listing shortcode.
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
 * Renders the team listing shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the block.
 * @return string          The HTML for the block.
 */
function sports_bench_list_teams_by_division( $atts ) {
	extract(
		shortcode_atts(
			[
				'division_id'   => 0,
			],
			$atts
		)
	);

	$html      = '';
	$html     .= '<div class="list-division-teams">';
	$teams     = sports_bench_get_teams( true, true, $division_id );
	$num_teams = count( $teams );
	$count     = 0;

	foreach ( $teams as $team_id => $team_name ) {

		/**
		 * Displays the listing information for the team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the filter.
		 * @param int    $team_id        The id for the team to show the listing for.
		 * @param string $team_name      The name of the team to show the listing for.
		 * @param int    $num_teams      The number of teams that are being shown.
		 * @param int    $count          The counter for the current number of iterations for the loop (minus one).
		 * @return string                HTML for the team listing.
		 */
		$html .= apply_filters( 'sports_bench_team_listing_info', '', $team_id, $team_name, $num_teams, $count );
		$count++;
	}
	$html .= '</div>';

	return $html;
}
