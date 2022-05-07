<?php
/**
 * Creates the shortcode function for showing the player page shortcode.
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
use Sports_Bench\Classes\Base\Team;

/**
 * Renders the player page shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_player_page_shortcode( $atts ) {
	$html = '';

	if ( get_query_var( 'player_slug' ) ) {
		$player = new Player( get_query_var( 'player_slug' ) );
		$team   = new Team( (int) $player->get_team_id() );

		$html .= '<div class="sports-bench-player-page">';
		$html .= '<div id="player-info" class="player-section clearfix">';
		$html .= '<h2 class="player-section-title">' . __( 'Player Information', 'sports-bench' ) . '</h2>';
		$html .= sports_bench_show_player_info( $player->get_player_id() );
		$html .= '</div>';

		/**
		 * Adds in HTML to be shown before the player stats.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the filter.
		 * @param Player $player         The Player object the stats are for.
		 * @return string                HTML to be shown before the stats.
		 */
		$html .= apply_filters( 'sports_bench_before_player_stats', '', $team );
		$html .= '<div id="player-stats" class="player-section">';
		$html .= '<h3 class="player-section-title">' . __( 'Career Stats', 'sports-bench' ) . '</h3>';
		$html .= sports_bench_get_season_stats( $player );
		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';
		$html .= '</div>';

		/**
		 * Adds in HTML to be shown after the player stats.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the filter.
		 * @param Player $player         The Player object the stats are for.
		 * @return string                HTML to be shown after the stats.
		 */
		$html .= apply_filters( 'sports_bench_after_player_stats', '', $team );
		$html .= '</div>';
	} else {
		$html .= sports_bench_show_team_player_select();
	}

	return $html;
}

