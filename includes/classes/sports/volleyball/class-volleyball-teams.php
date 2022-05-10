<?php
/**
 * Creates the volleyball teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Volleyball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The volleyball teams class.
 *
 * This is used for volleyball teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 */
class VolleyballTeams extends Teams {

	/**
	 * Creates the new VolleyballTeams object to be used.
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
		$html .= '<td class="left">' . esc_html__( 'Kills', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['kills'] . '</td>';
		$html .= '<td>' . $average_stats['kills'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Blocks', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['blocks'] . '</td>';
		$html .= '<td>' . $average_stats['blocks'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Aces', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['aces'] . '</td>';
		$html .= '<td>' . $average_stats['aces'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Assists', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['assists'] . '</td>';
		$html .= '<td>' . $average_stats['assists'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Digs', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['digs'] . '</td>';
		$html .= '<td>' . $average_stats['digs'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Attacks', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['attacks'] . '</td>';
		$html .= '<td>' . $average_stats['attacks'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Hitting Errors', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['hitting_errors'] . '</td>';
		$html .= '<td>' . $average_stats['hitting_errors'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Points Against', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['points_against'] . '</td>';
		$html .= '<td>' . $average_stats['points_against'] . '</td>';
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
		$html .= '<table class="volleyball player-stats">';
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
		$html .= '<th>' . esc_html__( 'SP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'HIT %', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'K', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'ATT', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'HE', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'SET E', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'SET A', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'S', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'SE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'ACE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'B', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'BA', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'BE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'DIG', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'RE', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $player['sets_played'] . '</td>';
				$html .= '<td class="center">' . $player['points'] . '</td>';
				$html .= '<td class="center">' . $player['hitting_percent'] . '</td>';
				$html .= '<td class="center">' . $player['kills'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['attacks'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['hitting_errors'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['set_errors'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['set_attempts'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['serves'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['serve_errors'] . '</td>';
				$html .= '<td class="center">' . $player['aces'] . '</td>';
				$html .= '<td class="center">' . $player['blocks'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['block_attempts'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['block_errors'] . '</td>';
				$html .= '<td class="center">' . $player['digs'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['rec_errors'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
