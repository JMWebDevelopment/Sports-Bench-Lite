<?php
/**
 * Creates the shortcode function for showing the game shortcode.
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

use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * Renders the game block.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the block.
 * @return string          The HTML for the block.
 */
function sports_bench_game_shortcode( $atts ) {
	extract(
		shortcode_atts(
			[
				'game_id' => 0,
			],
			$atts
		)
	);

	$html = '';

	if ( $game_id > 0 ) {
		$game      = new Game( (int) $game_id );
		$away_team = new Team( (int) $game->get_game_away_id() );
		$home_team = new Team( (int) $game->get_game_home_id() );
		if ( 'final' !== $game->get_game_status() ) {
			$away_score = '';
			$home_score = '';
			$time       = $game->get_game_day( get_option( 'time_format' ) );
			$time_class = 'scheduled';
			$period     = $game->get_game_day( get_option( 'date_format' ) );
			$location   = $game->get_game_location_stadium() . ', ' . $game->get_game_location_city() . ', ' . $game->get_game_location_state();
		} else {
			$away_score = $game->get_game_away_final();
			$home_score = $game->get_game_home_final();
			$time       = $game->get_game_day( get_option( 'date_format' ) ) . ' &mdash; ' . esc_html__( 'FINAL', 'sports-bench' );
			$time_class = '';
			$period     = '';
			$location   = $game->get_game_location_stadium() . ', ' . $game->get_game_location_city() . ', ' . $game->get_game_location_state();
		}
		if ( null !== $away_team->get_team_nickname() ) {
			$away_team_name = '<span class="team-location">' . $away_team->get_team_location() . '</span><br /><span class="team-nickname">' . $away_team->get_team_nickname() . '</span>';
		} else {
			$away_team_name = $away_team->get_team_location();
		}
		if ( null !== $home_team->get_team_nickname() ) {
			$home_team_name = '<span class="team-location">' . $home_team->get_team_location() . '</span><br /><span class="team-nickname">' . $home_team->get_team_nickname() . '</span>';
		} else {
			$home_team_name = $home_team->get_team_location();
		}
		$time_in_game = '<span class="time">' . $time . '</span><br /><span class="period">' . $period . '</span>';

		$html .= '<div id="sports-bench-game-' . $game->get_game_id() . '" class="sports-bench-shortcode-game row sports-bench-row">';

		/**
		 * Adds in HTML to be shown before the game shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html            The current HTML for the filter.
		 * @param int    $game_id         The Player object the stats are for.
		 * @param Team   $away_team       The team object for the away team.
		 * @param Team   $home_team       The team object for the home team.
		 * @return string                 HTML to be shown before the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_before_game_shortcode', '', $game->get_game_id(), $away_team, $home_team );

		/**
		 * Displays the information about a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html                The current HTML for the filter.
		 * @param Game   $game                The Game object for the game shortcode.
		 * @param Team   $away_team           The team object for the away team.
		 * @param string $away_team_name      The name of the away team.
		 * @param int    $away_score          The score for the away team.
		 * @param Team   $home_team           The team object for the home team.
		 * @param string $home_team_name      The name of the home team.
		 * @param int    $home_score          The score for the home team.
		 * @param string $time_in_game        The current time of the game (or "FINAL" if the game is over).
		 * @param string $location            The location of the game.
		 * @return string                     The HTML to show the information about the game.
		 */
		$html .= apply_filters( 'sports_bench_game_shortcode_info', '', $game, $away_team, $away_team_name, $away_score, $home_team, $home_team_name, $home_score, $time_in_game, $location );

		/**
		 * Adds in HTML to be shown after the game shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html            The current HTML for the filter.
		 * @param int    $game_id         The Player object the stats are for.
		 * @param Team   $away_team       The team object for the away team.
		 * @param Team   $home_team       The team object for the home team.
		 * @return string                 HTML to be shown after the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_after_game_shortcode', '', $game->get_game_id(), $away_team, $home_team );
		$html .= '</div>';

	}

	return $html;
}
