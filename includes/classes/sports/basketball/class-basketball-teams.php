<?php
/**
 * Creates the basketball teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Basketball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The basketball teams class.
 *
 * This is used for basketball teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 */
class BasketballTeams extends Teams {

	/**
	 * Creates the new BasketballTeams object to be used.
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
		$html .= '<td class="left">' . esc_html__( 'Field Goals Made/Percentage', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fgm'] . '</td>';
		$html .= '<td>' . $average_stats['fg_pct'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Three Pointers Made/Percentage', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['3pm'] . '</td>';
		$html .= '<td>' . $average_stats['3p_pct'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Free Throws Made/Percentage', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['ftm'] . '</td>';
		$html .= '<td>' . $average_stats['ft_pct'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Total Rebounds', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['rebounds'] . '</td>';
		$html .= '<td>' . $average_stats['rebounds'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Offensive Rebounds', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['off_rebounds'] . '</td>';
		$html .= '<td>' . $average_stats['off_rebounds'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Defensive Rebounds', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['def_rebounds'] . '</td>';
		$html .= '<td>' . $average_stats['def_rebounds'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Assists', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['assists'] . '</td>';
		$html .= '<td>' . $average_stats['assists'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Steals', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['steals'] . '</td>';
		$html .= '<td>' . $average_stats['steals'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Blocks', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['blocks'] . '</td>';
		$html .= '<td>' . $average_stats['blocks'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Points in the Paint', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['pip'] . '</td>';
		$html .= '<td>' . $average_stats['pip'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Turnovers', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['to'] . '</td>';
		$html .= '<td>' . $average_stats['to'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Points off Turnovers', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['pot'] . '</td>';
		$html .= '<td>' . $average_stats['pot'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Fast Break Points', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fast_break'] . '</td>';
		$html .= '<td>' . $average_stats['fast_break'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Fouls', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fouls'] . '</td>';
		$html .= '<td>' . $average_stats['fouls'] . '</td>';
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
		$html .= '<table class="basketball player-stats">';
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
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th></th>';
		$html .= '<th colspan="2"  class="show-for-medium">' . esc_html__( 'REBOUNDS', 'sports-bench' ) . '</th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th class="show-for-medium"></th>';
		$html .= '<th></th>';
		$html .= '</tr>';

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
		$html .= '<th>' . esc_html__( 'ST', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'MIN', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'FG', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( '3-PT', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'FT', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'AVG', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'O-D', 'sports-bench' ) . '</th>';
		$html .= '<th><span class="show-for-medium">' . esc_html__( 'TOTAL', 'sports-bench' ) . '</span></th>';
		$html .= '<th>' . esc_html__( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'S', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'B', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'TO', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( '+/-', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ( $stats as $player ) {
			if ( $player['games_played'] > 0 ) {
				if ( strlen( $player['minutes'] ) > 4 ) {
					$seconds = substr( $player['minutes'], -2, 2 );
					$time    = substr_replace( $player['minutes'], '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $player['minutes'], -2, 2 );
					$minutes = substr_replace( $player['minutes'], '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}

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
				$html .= '<td class="center">' . $player['starts'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $time . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['fgm'] . '-' . $player['fga'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['3pm'] . '-' . $player['3pa'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['ftm'] . '-' . $player['fta'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['points'] . '</td>';
				$html .= '<td class="center">' . $player['points_per_game'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['off_reb'] . '-' . $player['def_reb'] . '</td>';
				$html .= '<td class="center">' . $player['tot_reb'] . '</td>';
				$html .= '<td class="center">' . $player['assists'] . '</td>';
				$html .= '<td class="center">' . $player['steals'] . '</td>';
				$html .= '<td class="center">' . $player['blocks'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['to'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['plus_minus'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
