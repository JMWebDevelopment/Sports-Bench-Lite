<?php
/**
 * Creates the shortcode function for showing the team shortcode.
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

use Sports_Bench\Classes\Base\Team;

/**
 * Renders the team shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_team_shortcode( $atts ) {
	extract(
		shortcode_atts(
			[
				'team_id' => 0,
			],
			$atts
		)
	);

	$html = '';

	if ( $team_id > 0 ) {
		$team   = new Team( (int) $team_id );
		$record = $team->get_record( get_option( 'sports-bench-season-year' ) );
		$html   .= '<div id="sports-bench-team-' . $team->get_team_id() . '" class="sports-bench-shortcode-team row">';

		/**
		 * Adds in HTML to be shown before the team shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The current HTML for the filter.
		 * @param Team   $team         The Team object the shortcode is for.
		 * @return string              HTML to be shown before the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_before_team_shortcode', '', $team );
		$html .= '<div class="team-information">';

		/**
		 * Displays the information about the team for the shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html        The current HTML for the filter.
		 * @param Team   $team        The Team object the shortcode is for.
		 * @param array  $record      The record for the team.
		 * @return string             The HTML to show the information about the team.
		 */
		$html    .= apply_filters( 'sports_bench_team_shortcode_information', '', $team, $record );
		$html    .= '</div>';
		$html    .= '<div class="team-schedules">';
		$html    .= '<div id="recent-schedule" class="large-6 medium-6 small-12 columns">';
		$schedule = $team->get_recent_results( 5, get_option( 'sports-bench-season-year' ) );

		/**
		 * Displays the last five game results for the team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param Team   $team          The Team object the shortcode is for.
		 * @param array  $schedule      The array of recent games for the team.
		 * @return string               The HTML to show the recent games for the team.
		 */
		$html    .= apply_filters( 'sports_bench_team_shortcode_recent_games', '', $team, $schedule );
		$html    .= '</div>';
		$html    .= '<div id="upcoming-schedule" class="large-6 medium-6 small-12 columns">';
		$schedule = $team->get_upcoming_schedule( 5, get_option( 'sports-bench-season-year' ) );

		/**
		 * Displays the next five games for the team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param Team   $team          The Team object the shortcode is for.
		 * @param array  $schedule      The array of upcoming games for the team.
		 * @return string               The HTML to show the upcoming games for the team.
		 */
		$html .= apply_filters( 'sports_bench_team_shortcode_upcoming_games', '', $team, $schedule );
		$html .= '</div>';
		$html .= '</div>';

		/**
		 * Adds in HTML to be shown after the team shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The current HTML for the filter.
		 * @param Team   $team         The Team object the shortcode is for.
		 * @return string              HTML to be shown after the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_after_team_shortcode', '', $team );
		$html .= '</div>';
	}

	return $html;
}
