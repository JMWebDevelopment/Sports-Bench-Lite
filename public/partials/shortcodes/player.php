<?php
/**
 * Creates the shortcode function for showing the player shortcode.
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

use Sports_Bench\Classes\Base\Player;

/**
 * Renders the player shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_player_shortcode( $atts ) {
	extract(
		shortcode_atts(
			[
				'player_id' => 0,
			],
			$atts
		)
	);

	$html = '';

	if ( $player_id > 0 ) {
		$player = new Player( (int) $player_id );
		$html  .= '<div id="sports-bench-player-' . $player->get_player_id() . '" class="sports-bench-player-shortcode">';

		/**
		 * Adds in HTML to be shown before the player shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the filter.
		 * @param Player $player         The Player object the shortcode is for.
		 * @return string                HTML to be shown before the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_before_player_shortcode', '', $player );
		$html .= '<div id="sports-bench-player-id">' . $player->get_player_id() . '</div>';

		/**
		 * Displays the information about the player for the shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param Player $player        The Player object the shortcode is for.
		 * @param array  $team          The current team id of the team the player plays for.
		 * @return string               The HTML to show the information about the player.
		 */
		$html .= apply_filters( 'sports_bench_player_shortcode_information', '', $player, $player->get_team_id() );
		$html .= '<div class="career-stats">';
		$html .= sports_bench_get_season_stats( $player );
		$html .= '</div>';

		/**
		 * Adds in HTML to be shown after the player shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the filter.
		 * @param Player $player         The Player object the shortcode is for.
		 * @return string                HTML to be shown after the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_after_player_shortcode', '', $player );
		$html .= '</div>';
	}

	return $html;
}
