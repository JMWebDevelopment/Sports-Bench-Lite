<?php
/**
 * Creates the shortcode function for showing the game recap shortcode.
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

use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * Renders the game recap shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_game_recap_shortcode( $atts ) {
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
		$game = new Game( $game_id );
		if ( 'final' === $game->get_game_status() ) {
			$home_team = new Team( (int) $game->get_game_home_id() );
			$away_team = new Team( (int) $game->get_game_away_id() );
			$html      = '';

			$html .= '<div class="game-box-score">';

			$html .= sports_bench_game_box_score_game_info( $game, $home_team, $away_team );
			$html .= sports_bench_game_box_score_team_stats( $game, $home_team, $away_team );
			$html .= sports_bench_game_box_score_away_team_stats( $game, $away_team );
			$html .= sports_bench_game_box_score_home_team_stats( $game, $home_team );

			$html .= '</div>';
		}
	}

	return $html;
}
