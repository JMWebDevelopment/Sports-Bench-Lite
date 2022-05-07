<?php
/**
 * Creates the hockey teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Hockey;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The hockey teams class.
 *
 * This is used for hockey teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 */
class HockeyTeams extends Teams {

	/**
	 * Creates the new HockeyTeams object to be used.
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
		$html .= '<td class="left">' . esc_html__( 'Goals', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['goals'] . '</td>';
		$html .= '<td>' . $average_stats['goals'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Shots on Goal', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['shots_on_goal'] . '</td>';
		$html .= '<td>' . $average_stats['shots_on_goal'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Power Plays', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['power_plays'] . '</td>';
		$html .= '<td>' . $average_stats['power_plays'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Power Play Goals', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['power_play_goals'] . '</td>';
		$html .= '<td>' . $average_stats['power_play_goals'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Penalty Minutes', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['penalty_minutes'] . '</td>';
		$html .= '<td>' . $average_stats['penalty_minutes'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Goals Against', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['goals_against'] . '</td>';
		$html .= '<td>' . $average_stats['goals_against'] . '</td>';
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
		$html .= '<th>' . esc_html__( 'G', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( '+/-', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'SOG', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'PEN', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PM', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'H', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SFT', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TOI', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FO-FW', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( strlen( $player['ice_time'] ) > 4 ) {
				$seconds = substr( $player['ice_time'], -2, 2 );
				$time    = substr_replace( $player['ice_time'], '', -2, 2 );
				$minutes = substr( $time, -2, 2 );
				$time    = substr_replace( $time, '', -2, 2 );
				$times   = array( $time, $minutes, $seconds );
				$time    = implode( ':', $times );
			} else {
				$seconds = substr( $player['ice_time'], -2, 2 );
				$minutes = substr_replace( $player['ice_time'], '', -2, 2 );
				$times   = array( $minutes, $seconds );
				$time    = implode( ':', $times );
			}
			if ( $player['shots_faced'] <= 0 ) {

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
				$html .= '<td class="center">' . $player['goals'] . '</td>';
				$html .= '<td class="center">' . $player['assists'] . '</td>';
				$html .= '<td class="center">' . $player['points'] . '</td>';
				$html .= '<td class="center">' . $player['plus_minus'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['sog'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['penalties'] . '</td>';
				$html .= '<td class="center">' . $player['pen_minutes'] . '</td>';
				$html .= '<td class="center">' . $player['hits'] . '</td>';
				$html .= '<td class="center">' . $player['shifts'] . '</td>';
				$html .= '<td class="center">' . $time . '</td>';
				$html .= '<td class="center">' . $player['faceoffs'] . '-' . $player['faceoff_wins'] . '</td>';
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
		$html .= '<th>' . esc_html__( 'Goalies', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SF', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SAVES', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $player['shots_faced'] . '</td>';
				$html .= '<td class="center">' . $player['saves'] . '</td>';
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
