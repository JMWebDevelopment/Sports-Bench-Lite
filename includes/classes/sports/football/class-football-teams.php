<?php
/**
 * Creates the football teams class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Football;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Teams;

/**
 * The football teams class.
 *
 * This is used for football teams functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class FootballTeams extends Teams {

	/**
	 * Creates the new FootballTeams object to be used.
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
		$html .= '<td class="left">' . esc_html__( 'Total Yards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['total'] . '</td>';
		$html .= '<td>' . $average_stats['total'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Pass Yards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['pass'] . '</td>';
		$html .= '<td>' . $average_stats['pass'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Rushing Yards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['rush'] . '</td>';
		$html .= '<td>' . $average_stats['rush'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Turnovers', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['turnovers'] . '</td>';
		$html .= '<td>' . $average_stats['turnovers'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Interceptions', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['ints'] . '</td>';
		$html .= '<td>' . $average_stats['ints'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Fumbles', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fumbles'] . '</td>';
		$html .= '<td>' . $average_stats['fumbles'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Fumbles Lost', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['fumbles_lost'] . '</td>';
		$html .= '<td>' . $average_stats['fumbles_lost'] . '</td>';
		$html .= '</tr>';

		$possession = $total_stats['possession'];
		$minutes    = floor( $possession / 60 );
		$seconds    = $possession % 60;
		if ( 9 > $seconds ) {
			$seconds = '0' . $seconds;
		}

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Possession', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $minutes . ':' . $seconds . '</td>';
		$html .= '<td>' . $average_stats['possession'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Kick Returns', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['kick_returns'] . '</td>';
		$html .= '<td>' . $average_stats['kick_returns'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Kick Return Yards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['kick_return_yards'] . '</td>';
		$html .= '<td>' . $average_stats['kick_return_yards'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Penalties', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['penalties'] . '</td>';
		$html .= '<td>' . $average_stats['penalties'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'Penalty Yards', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['penalty_yards'] . '</td>';
		$html .= '<td>' . $average_stats['penalty_yards'] . '</td>';
		$html .= '</tr>';

		$html .= '<tr>';
		$html .= '<td class="left">' . esc_html__( 'First Downs', 'sports-bench' ) . '</td>';
		$html .= '<td>' . $total_stats['first_downs'] . '</td>';
		$html .= '<td>' . $average_stats['first_downs'] . '</td>';
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
		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$passyards[ $key ] = $row['pass_yards'];
			}
			array_multisort( $passyards, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Passing', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'COMP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'ATT', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'YARDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TD', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'INT', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ( $stats as $player ) {
			if ( $player['attempts'] > 0 ) {

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
				$html .= '<td class="center">' . $player['completions'] . '</td>';
				$html .= '<td class="center">' . $player['attempts'] . '</td>';
				$html .= '<td class="center">' . $player['pass_yards'] . '</td>';
				$html .= '<td class="center">' . $player['pass_tds'] . '</td>';
				$html .= '<td class="center">' . $player['pass_ints'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$rushyards[ $key ] = $row['rush_yards'];
				$rushes[ $key ]    = $row['rushes'];
			}
			array_multisort( $rushyards, SORT_DESC, $rushes, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Rushing', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'RUSHES', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'YARDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FUMBLES', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['rushes'] > 0 ) {

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
				$html .= '<td class="center">' . $player['rushes'] . '</td>';
				$html .= '<td class="center">' . $player['rush_yards'] . '</td>';
				$html .= '<td class="center">' . $player['rush_tds'] . '</td>';
				$html .= '<td class="center">' . $player['rush_fumbles'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$receiving_yards[ $key ] = $row['receiving_yards'];
				$catches[ $key ]         = $row['catches'];
			}
			array_multisort( $receiving_yards, SORT_DESC, $catches, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Receiving', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'CATCHES', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'YARDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FUMBLES', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['catches'] > 0 ) {

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
				$html .= '<td class="center">' . $player['catches'] . '</td>';
				$html .= '<td class="center">' . $player['receiving_yards'] . '</td>';
				$html .= '<td class="center">' . $player['receiving_tds'] . '</td>';
				$html .= '<td class="center">' . $player['receiving_fumbles'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ){
			foreach ( $stats as $key => $row ) {
				$tackles[ $key ]           = $row['tackles'];
				$sacks[ $key ]             = $row['sacks'];
				$ints[ $key ]              = $row['ints'];
				$forced_fumbles[ $key ]    = $row['forced_fumbles'];
				$fumbles_recovered[ $key ] = $row['fumbles_recovered'];
				$blocked[ $key ]           = $row['blocked'];
				$yards[ $key ]             = $row['yards'];
			}
			array_multisort( $tackles, SORT_DESC, $sacks, SORT_DESC, $ints, SORT_DESC, $forced_fumbles, SORT_DESC, $fumbles_recovered, SORT_DESC, $blocked, SORT_DESC, $yards, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Defense', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TCK', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'TFL', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'SACKS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'INTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FF', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'BLK', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . esc_html__( 'YDS', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['tackles'] > 0 || $player['ints'] > 0 || $player['forced_fumbles'] > 0 || $player['fumbles_recovered'] > 0 || $player['blocked'] > 0 ) {

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
				$html .= '<td class="center">' . $player['tackles'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['tfl'] . '</td>';
				$html .= '<td class="center">' . $player['sacks'] . '</td>';
				$html .= '<td class="center">' . $player['ints'] . '</td>';
				$html .= '<td class="center">' . $player['tds'] . '</td>';
				$html .= '<td class="center">' . $player['forced_fumbles'] . '</td>';
				$html .= '<td class="center">' . $player['fumbles_recovered'] . '</td>';
				$html .= '<td class="center">' . $player['blocked'] . '</td>';
				$html .= '<td class="center show-for-medium">' . $player['yards'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$fga[ $key ] = $row['fga'];
				$xpa[ $key ] = $row['xpa'];
			}
			array_multisort( $fga, SORT_DESC, $xpa, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Kicking', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FGM', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FGA', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'XPM', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'XPA', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TOUCHBACKS', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['fga'] > 0 || $player['xpa'] > 0 || $player['touchbacks'] > 0 ) {

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
				$html .= '<td class="center">' . $player['fgm'] . '</td>';
				$html .= '<td class="center">' . $player['fga'] . '</td>';
				$html .= '<td class="center">' . $player['xpm'] . '</td>';
				$html .= '<td class="center">' . $player['xpa'] . '</td>';
				$html .= '<td class="center">' . $player['touchbacks'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		if ( ! empty( $stats ) ) {
			foreach ( $stats as $key => $row ) {
				$returnyards[ $key ] = $row['return_yards'];
				$returns[ $key ]     = $row['returns'];
			}
			array_multisort( $returnyards, SORT_DESC, $returns, SORT_DESC, $stats );
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
		$html .= '<th>' . esc_html__( 'Returns', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'RETURNS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'YARDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'TDS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'FUMBLES', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $player ) {
			if ( $player['returns'] > 0 ) {

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
				$html .= '<td class="center">' . $player['returns'] . '</td>';
				$html .= '<td class="center">' . $player['return_yards'] . '</td>';
				$html .= '<td class="center">' . $player['return_tds'] . '</td>';
				$html .= '<td class="center">' . $player['return_fumbles'] . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}
}
