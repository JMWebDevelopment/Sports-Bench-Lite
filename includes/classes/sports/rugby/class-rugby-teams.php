<?php
/**
 * Creates the rugby teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Rugby;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The rugby teams class.
 *
 * This is used for rugby teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyTeams extends Teams {

	/**
	 * Creates the new RugbyTeams object to be used.
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
		$html .= '<td class="left">' . esc_html__( 'Points', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['points'] . '</td>';
		$html .= '<td>' . $average_stats['points'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Tries', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['tries'] . '</td>';
		$html .= '<td>' . $average_stats['tries'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Conversions', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['conversions'] . '</td>';
		$html .= '<td>' . $average_stats['conversions'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Penalty Goals', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['penalty_goals'] . '</td>';
		$html .= '<td>' . $average_stats['penalty_goals'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Kick Percentage', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['kick_percentage'] . '</td>';
		$html .= '<td>' . $average_stats['kick_percentage'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Runs', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['meters_run'] . '</td>';
		$html .= '<td>' . $average_stats['meters_run'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Kicks from Hand', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['meters_hand'] . '</td>';
		$html .= '<td>' . $average_stats['meters_hand'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Passes', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['meters_pass'] . '</td>';
		$html .= '<td>' . $average_stats['meters_pass'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Possession', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['meters_pass'] . '</td>';
		$html .= '<td>' . $average_stats['possession'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Clean Breaks', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['clean_breaks'] . '</td>';
		$html .= '<td>' . $average_stats['clean_breaks'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Defenders Beaten', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['defenders_beaten'] . '</td>';
		$html .= '<td>' . $average_stats['defenders_beaten'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Offload', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['offload'] . '</td>';
		$html .= '<td>' . $average_stats['offload'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Rucks', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['rucks'] . '</td>';
		$html .= '<td>' . $average_stats['rucks'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Mauls', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['mauls'] . '</td>';
		$html .= '<td>' . $average_stats['mauls'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Turnovers Conceded', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['turnovers_conceeded'] . '</td>';
		$html .= '<td>' . $average_stats['turnovers_conceeded'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Scrums', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['scrums'] . '</td>';
		$html .= '<td>' . $average_stats['scrums'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Lineouts', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['lineouts'] . '</td>';
		$html .= '<td>' . $average_stats['lineouts'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Penalties Conceded', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['penalties_conceeded'] . '</td>';
		$html .= '<td>' . $average_stats['penalties_conceeded'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Red Cards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['red_cards'] . '</td>';
		$html .= '<td>' . $average_stats['red_cards'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Yellow Cards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['yellow_cards'] . '</td>';
		$html .= '<td>' . $average_stats['yellow_cards'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Free Kicks Conceded', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['free_kicks_conceeded'] . '</td>';
		$html .= '<td>' . $average_stats['free_kicks_conceeded'] . '</td>';
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
		$html .= '<table class="rugby player-stats">';
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
		$html .= '<th></th>';
		$html .= '<th>' . esc_html__( 'GP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'T', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PT', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'C', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PG', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'DK', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PC', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'MR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'R', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Y', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['games_played'] > 0 ) {

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
				$html .= '<td class="center">' . $player['games_played'] . '</td>';
				$html .= '<td class="center">' . $player['tries'] . '</td>';
				$html .= '<td class="center">' . $player['points'] . '</td>';
				$html .= '<td class="center">' . $player['assists'] . '</td>';
				$html .= '<td class="center">' . $player['conversions'] . '</td>';
				$html .= '<td class="center">' . $player['pk_goals'] . '</td>';
				$html .= '<td class="center">' . $player['drop_kicks'] . '</td>';
				$html .= '<td class="center">' . $player['points'] . '</td>';
				$html .= '<td class="center">' . $player['penalties_conceded'] . '</td>';
				$html .= '<td class="center">' . $player['meters_run'] . '</td>';
				$html .= '<td class="center">' . $player['red_cards'] . '</td>';
				$html .= '<td class="center">' . $player['yellow_cards'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
