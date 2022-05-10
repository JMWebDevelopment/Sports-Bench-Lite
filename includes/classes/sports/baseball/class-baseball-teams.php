<?php
/**
 * Creates the baseball teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Baseball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The baseball teams class.
 *
 * This is used for baseball teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 */
class BaseballTeams extends Teams {

	/**
	 * Creates the new BaseballTeams object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version      The version of the plugin.
	 */
	public function __construct( $version ) {
		parent::__construct();
	}

	/**
	 * Creates the table for the team stats.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html             The incoming HTML for the table.
	 * @param Team   $team             The team object for the team to show the stats for.
	 * @param string $season           The season to show the stats from.
	 * @param array  $stats_array      The array of team stats to show.
	 * @return string                   The HTML for the team stats table.
	 */
	public function sports_bench_do_team_season_stats( $html, $team, $season, $stats_array ) {
		$total_stats   = $stats_array[0];
		$average_stats = $stats_array [1];

		$html .= '<table class="sports-bench-team-stats-table">';

		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th></th>';
		$html .= '<th>' . esc_html__( 'Total Stats', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Average Stats', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';

		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Doubles', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['doubles'] . '</td>';
		$html .= '<td>' . $average_stats['doubles'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Triples', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['triples'] . '</td>';
		$html .= '<td>' . $average_stats['triples'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Home Runs', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['homeruns'] . '</td>';
		$html .= '<td>' . $average_stats['homeruns'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Hits', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['hits'] . '</td>';
		$html .= '<td>' . $average_stats['hits'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Errors', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['errors'] . '</td>';
		$html .= '<td>' . $average_stats['errors'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Left on Base', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['lob'] . '</td>';
		$html .= '<td>' . $average_stats['lob'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Runs Scored', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['runs'] . '</td>';
		$html .= '<td>' . $average_stats['runs'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Runs Given Up', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['runs_against'] . '</td>';
		$html .= '<td>' . $average_stats['runs_against'] . '</td>';
		$html .= '</tr>';
		$html .= '</tbody>';

		$html .= '</table>';

		return $html;
	}

	/**
	 * Creates the player stats table for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html                    The incoming HTML for the player stats.
	 * @param array  $stats                   The array of player stats to show.
	 * @param string $sport                   The sport the website is using.
	 * @return string                         The player stats table for a team.
	 */
	public function sports_bench_do_team_stats_table( $html, $stats, $sport ) {
		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$average[ $key ] = $row['batting_average'];
			}
			array_multisort( $average, SORT_DESC, $stats );
		}

		$html .= '<table class="player-stats">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the header row of the team player stats table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles       The incoming styles for the row.
		 * @param int    $team_id      The team id the table is for.
		 * @return string              The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_player_stats_head_row', '', $stats[0]['team_id'] );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Hitting', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'AB', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'AVG', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'H', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'R', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'RBI', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( '2B', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( '3B', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'HR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'SO', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'BB', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'HBP', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['at_bats'] > 0 ) {

				/**
				 * Adds in styles for the row of the team player stats table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The incoming styles for the row.
				 * @param int    $team_id      The team id the table is for.
				 * @return string              The styles for the row.
				 */
				$table_row_styles = apply_filters( 'sports_bench_team_player_stats_row', '', $stats[0]['team_id'] );

				$html .= '<tr style="' . $table_row_styles . '">';
				$html .= '<td><a href="' . $player['player_page'] . '">' . $player['player_name'] . '</a></td>';
				$html .= '<td class="center">' . $player['at_bats'] . '</td>';
				$html .= '<td class="center">' . $player['batting_average'] . '</td>';
				$html .= '<td class="center">' . $player['hits'] . '</td>';
				$html .= '<td class="center">' . $player['runs'] . '</td>';
				$html .= '<td class="center">' . $player['rbi'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['doubles'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['triples'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['homeruns'] . '</td>';
				$html .= '<td class="center">' . $player['strikeouts'] . '</td>';
				$html .= '<td class="center">' . $player['walks'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['hit_by_pitch'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$era[ $key ] = $row['era'];
			}
			array_multisort( $era, SORT_ASC, $stats );
		}

		$html .= '<table class="player-stats">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the header row of the team player stats table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles       The incoming styles for the row.
		 * @param int    $team_id      The team id the table is for.
		 * @return string              The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_player_stats_head_row', '', $stats[0]['team_id'] );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Pitching', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'IP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'ERA', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'R', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'ER', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'H', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'K', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'BB', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'HPB', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'HR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'PC', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['pitch_count'] > 0 ) {

				/**
				 * Adds in styles for the header row of the team player stats table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The incoming styles for the row.
				 * @param int    $team_id      The team id the table is for.
				 * @return string              The styles for the row.
				 */
				$table_row_styles = apply_filters( 'sports_bench_team_player_stats_row', '', $stats[0]['team_id'] );

				$html .= '<tr style="' . $table_row_styles . '">';
				$html .= '<td><a href="' . $player['player_page'] . '">' . $player['player_name'] . '</a></td>';
				$html .= '<td class="center">' . $player['innings_pitched'] . '</td>';
				$html .= '<td class="center">' . $player['era'] . '</td>';
				$html .= '<td class="center">' . $player['runs_allowed'] . '</td>';
				$html .= '<td class="center">' . $player['earned_runs'] . '</td>';
				$html .= '<td class="center">' . $player['hits_allowed'] . '</td>';
				$html .= '<td class="center">' . $player['pitcher_strikeouts'] . '</td>';
				$html .= '<td class="center">' . $player['pitcher_walks'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['pitcher_hit_batters'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['homeruns_allowed'] . '</td>';
				$html .= '<td class="center">' . $player['pitch_count'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
