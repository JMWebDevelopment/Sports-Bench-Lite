<?php
/**
 * Creates the soccer teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Soccer;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The soccer teams class.
 *
 * This is used for soccer teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class SoccerTeams extends Teams {

	/**
	 * Creates the new SoccerTeams object to be used.
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
		$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Stat', 'sports-bench' ) . '</span></th>';
		$html .= '<th>' . esc_html__( 'Total Stats', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Average Stats', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';

		$html .= '<tbody>';
		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Goals', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['goals'] . '</td>';
		$html .= '<td>' . $average_stats['goals'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Possession', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['possession'] . '</td>';
		$html .= '<td>' . $average_stats['possession'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Shots', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['shots'] . '</td>';
		$html .= '<td>' . $average_stats['shots'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Shots on Goal', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['sog'] . '</td>';
		$html .= '<td>' . $average_stats['sog'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Corners', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['corners'] . '</td>';
		$html .= '<td>' . $average_stats['corners'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Offsides', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['offsides'] . '</td>';
		$html .= '<td>' . $average_stats['offsides'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Fouls', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fouls'] . '</td>';
		$html .= '<td>' . $average_stats['fouls'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Saves', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['saves'] . '</td>';
		$html .= '<td>' . $average_stats['saves'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Goals Against', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['goals_against'] . '</td>';
		$html .= '<td>' . $average_stats['goals_against'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Yellow Cards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['yellows'] . '</td>';
		$html .= '<td>' . $average_stats['yellows'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Red Cards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['reds'] . '</td>';
		$html .= '<td>' . $average_stats['reds'] . '</td>';
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
		$html .= '<th></th>';
		$html .= '<th>' . esc_html__( 'MIN', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'G', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SH', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SOG', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'F', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FS', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['shots_faced'] <= 0 && $player['minutes'] > 0 ) {

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
				$html .= '<td class="center">' . $player['minutes'] . '</td>';
				$html .= '<td class="center">' . $player['goals'] . '</td>';
				$html .= '<td class="center">' . $player['assists'] . '</td>';
				$html .= '<td class="center">' . $player['shots'] . '</td>';
				$html .= '<td class="center">' . $player['sog'] . '</td>';
				$html .= '<td class="center">' . $player['fouls'] . '</td>';
				$html .= '<td class="center">' . $player['fouls_suffered'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

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
		$html .= '<th>' . esc_html__( 'Keepers', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'MIN', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SF', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SV', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'GA', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'GAA', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['shots_faced'] > 0 ) {

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
				$html .= '<td class="center">' . $player['minutes'] . '</td>';
				$html .= '<td class="center">' . $player['shots_faced'] . '</td>';
				$html .= '<td class="center">' . $player['shots_saved'] . '</td>';
				$html .= '<td class="center">' . $player['goals_allowed'] . '</td>';
				$html .= '<td class="center">' . $player['goals_against_average'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
