<?php
/**
 * Creates the playoffs class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Base;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * The core teams class.
 *
 * This is used for the teams in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Playoffs {

	/**
	 * Creates the new Teams object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Adds in the series for the playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html                The incoming HTML for the series.
	 * @param Series $series              The current playoff series object.
	 * @param Team   $team_one            The team object for the first team.
	 * @param string $team_one_class      The CSS class for the first team.
	 * @param string $team_one_name       The name of the first team.
	 * @param Team   $team_two            The team object for the second team.
	 * @param string $team_two_class      The CSS class for the second team.
	 * @param string $team_two_name       The name of the second team.
	 * @param array  $game_numbers        The list of possible game numbers for the series.
	 */
	public function sports_bench_do_playoff_series( $html, $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers ) {
		$html .= '<table>';

		$team_row_styles = apply_filters( 'sports_bench_playoff_team_row', '', $team_one );

		$html .= '<tr class="team-row" style="' . $team_row_styles . '">';
		$html .= '<td class="seed">' . $series->get_team_one_seed() . '</td>';
		$html .= '<td class="logo">' . $team_one->get_team_photo( 'team-logo' ) . '</td>';
		$html .= '<td class="name ' . $team_one_class . '">' . $team_one_name . '</td>';
		$html .= '<td class="score">' . $series->get_team_score( 'team-one' ) . '</td>';
		$html .= '</tr>';

		$team_row_styles = apply_filters( 'sports_bench_playoff_team_row', '', $team_two );

		$html .= '<tr class="team-row" style="' . $team_row_styles . '">';
		$html .= '<td class="seed">' . $series->get_team_two_seed() . '</td>';
		$html .= '<td class="logo">' . $team_two->get_team_photo( 'team-logo' ) . '</td>';
		$html .= '<td class="name' . $team_two_class . '">' . $team_two_name . '</td>';
		$html .= '<td class="score">' . $series->get_team_score( 'team-two' ) . '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td class="series-details" colspan="3">' . $series->get_series_score() . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td colspan="4">';
		$html .= '<p class="js-expandmore" data-hideshow-prefix-class="mini-combo">' . esc_html__( 'View Matchup Details', 'sports-bench' ) . '</p>';
		$html .= '<div class="js-to_expand">';
		$html .= '<table class="series-games-table">';
		$games = $series->get_game_ids();
		$games = explode( ', ', $games );
		$k     = 0;
		if ( ! empty( $games ) ) {
			$played_games = [];
			foreach ( $games as $game ) {
				if ( 0 === $game || in_array( $game, $played_games ) ) {
					continue;
				}
				$played_games[] = $game;
				$the_game = new Game( (int) $game );
				$home     = new Team( (int) $the_game->get_game_home_id() );
				$away     = new Team( (int) $the_game->get_game_away_id() );
				if ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					$scoreline = $home->get_team_location() . ' ' . $the_game->get_game_home_final() . ', ' . $away->get_team_location() . ' ' . $the_game->get_game_away_final();
				} else {
					$scoreline = $away->get_team_location() . ' ' . $the_game->get_game_away_final() . ', ' . $home->get_team_location() . ' ' . $the_game->get_game_home_final();
				}
				if ( 0 !== $game && 'final' === $the_game->get_game_status() ) {
					$html .= '<tr>';
					if ( 'single-game' === $series->get_series_format() ) {
						$html .= '';
					} else {
						$html .= '<td class="modal-game-number">' . $game_numbers[ $k ] . '</td>';
					}
					$html .= '<td class="modal-game-score" colspan="3">' . $scoreline . '</td>';
					if ( $the_game->get_box_score_permalink() ) {
						$html .= '<td class="modal-game-recap"><a href="' . $the_game->get_box_score_permalink() . '">' . esc_html__( 'Box Score', 'sports-bench' ) . '</a></td>';
					} else {
						$html .= '<td></td>';
					}
					$html .= '</tr>';
					$k++;
				}
			}
		}
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</td>';
		$html .= '</tr>';

		$html .= '</table>';

		return $html;
	}
}
