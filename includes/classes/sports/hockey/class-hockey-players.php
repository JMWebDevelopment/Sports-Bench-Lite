<?php
/**
 * Creates the hockey players class.
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
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;

/**
 * The hockey players class.
 *
 * This is used for hockey players functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 */
class HockeyPlayers extends Players {

	/**
	 * Creates the new HockeyPlayers object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version      The version of the plugin.
	 */
	public function __construct( $version ) {
		parent::__construct();
	}

	/**
	 * Returns the HTML for the player stats table.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html         The incoming HTML for the table.
	 * @param Player $player       The player object to get the stats table for.
	 * @param string $sport        The sport the website is using.
	 * @param array  $seasons      The list of season stats to use in the table.
	 * @return string              The HTML for the player stats table.
	 */
	public function sports_bench_do_player_stats_table( $html, $player, $sport, $seasons ) {

		if ( sports_bench_stat_exists( $seasons, 'GOALS' ) || sports_bench_stat_exists( $seasons, 'ASSISTS' ) || sports_bench_stat_exists( $seasons, 'PM' ) || sports_bench_stat_exists( $seasons, 'SOG' ) || sports_bench_stat_exists( $seasons, 'PEN' ) || sports_bench_stat_exists( $seasons, 'PEN_MIN' ) || sports_bench_stat_exists( $seasons, 'HITS' ) || sports_bench_stat_exists( $seasons, 'SHIFTS' ) || sports_bench_stat_exists( $seasons, 'ICE_TIME' ) || sports_bench_stat_exists( $seasons, 'FACE' ) || sports_bench_stat_exists( $seasons, 'FACE_WINS' ) ) {
			$html .= '<table class="player-stats hockey normal">';
			$html .= '<thead>';

			/**
			 * Adds in styles for the header row of the player stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Player $player      The player the table is for.
			 * @return string             Styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_player_stats_head_row', '', $player );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<th class="left">' . __( 'Career Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'G', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'A', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'PTS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( '+/-', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'S', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'P', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'PM', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'H', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SFT', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TOI', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FO-FW', 'sports-bench' ) . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $seasons as $season ) {
				$season_team = new Team( (int) $season->game_team_id );
				if ( strlen( $season->ICE_TIME ) > 4 ) {
					$seconds = substr( $season->ICE_TIME, -2, 2 );
					$time    = substr_replace( $season->ICE_TIME, '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $season->ICE_TIME, -2, 2 );
					$minutes = substr_replace( $season->ICE_TIME, '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}

				/**
				 * Adds in styles for a row of the player stats table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The incoming styles for the row.
				 * @param Player $player      The player the table is for.
				 * @return string             Styles for the row.
				 */
				$table_row_styles = apply_filters( 'sports_bench_player_stats_row', '', $player );

				$html .= '<tr style="' . $table_row_styles . '">';
				$html .= '<td class="player-name">' . $season->game_season . ' | ' . $season_team->get_team_name() . ' ' . $season_team->get_team_photo( 'team-logo' ) . '</td>';
				$html .= '<td class="center">' . $season->GOALS . '</td>';
				$html .= '<td class="center">' . $season->ASSISTS . '</td>';
				$html .= '<td class="center">' . ( $season->GOALS + $season->ASSISTS ) . '</td>';
				$html .= '<td class="center">' . $season->SOG . '</td>';
				$html .= '<td class="center">' . $season->PM . '</td>';
				$html .= '<td class="center">' . $season->PEN . '</td>';
				$html .= '<td class="center">' . $season->PEN_MIN . '</td>';
				$html .= '<td class="center">' . $season->HITS . '</td>';
				$html .= '<td class="center">' . $season->SHIFTS . '</td>';
				$html .= '<td class="center">' . $time . '</td>';
				$html .= '<td class="center">' . $season->FACE . '-' . $season->FACE_WINS . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'SHOTS_FACED' ) || sports_bench_stat_exists( $seasons, 'SAVES' ) || sports_bench_stat_exists( $seasons, 'GOALS_ALLOWED' ) ) {
			$html .= '<table class="player-stats hockey goalie">';
			$html .= '<thead>';

			/**
			 * Adds in styles for the header row of the player stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Player $player      The player the table is for.
			 * @return string             Styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_player_stats_head_row', '', $player );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<th class="left">' . __( 'Career Goalie Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SF', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SAVES', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'GA', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'GAA', 'sports-bench' ) . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $seasons as $season ) {
				$season_team = new Team( (int) $season->game_team_id );

				/**
				 * Adds in styles for a row of the player stats table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The incoming styles for the row.
				 * @param Player $player      The player the table is for.
				 * @return string             Styles for the row.
				 */
				$table_row_styles = apply_filters( 'sports_bench_player_stats_row', '', $player );
				$html .= '<tr style="' . $table_row_styles . '">';
				$html .= '<td class="player-name">' . $season->game_season . ' | ' . $season_team->get_team_name() . ' ' . $season_team->get_team_photo( 'team-logo' ) . '</td>';
				$html .= '<td class="center">' . $season->SHOTS_FACED . '</td>';
				$html .= '<td class="center">' . $season->SAVES . '</td>';
				$html .= '<td class="center">' . $season->GOALS_ALLOWED . '</td>';
				$html .= '<td class="center">' . sports_bench_get_goals_against_average( (int) $season->GOALS_ALLOWED, (int) $season->GP ) . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';

		return $html;
	}

	/**
	 * Loads the game stats for a player in a selected season.
	 *
	 * @since 2.0.0
	 */
	public function load_seasons() {
		check_ajax_referer( 'sports-bench-load-seasons', 'nonce' );
		$team    = wp_filter_nohtml_kses( $_POST['team'] );
		$team    = new Team( $team );
		$team_id = $team->get_team_id();
		$player  = (int) wp_filter_nohtml_kses( $_POST['player'] );
		$season  = wp_filter_nohtml_kses( $_POST['season'] );

		ob_start();

		global $wpdb;
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_plus_minus ) as PM, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_penalties ) as PEN, SUM( g.game_player_pen_minutes ) as PEN_MIN, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_shifts ) as SHIFTS, SUM( g.game_player_time_on_ice ) as ICE_TIME, SUM( g.game_player_faceoffs ) as FACE, SUM( g.game_player_faceoff_wins ) as FACE_WINS, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_saves ) as SAVES, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED, COUNT( g.game_player_time_on_ice ) as GP
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_player_id = %d and ( game.game_home_id = %d or game.game_away_id = %d ) and game.game_season = %s AND game.game_status = 'final'
			GROUP BY g.game_player_id, game.game_season, game.game_id ;",
			$player,
			$team_id,
			$team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $season ) {

			/**
			 * Creates the game stats table for a player.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The incoming HTML for the player.
			 * @param array  $game         The array of information for the game.
			 * @param int    $team_id      The id of the team the player was playing for.
			 * @param string $sport        The sport the website is using.
			 * @param array  $POST         The incoming information from the AJAX call.
			 * @return string              The HTML for the table.
			 */
			echo apply_filters( 'sports_bench_player_game_stats_table', '', $season, $team_id, 'hockey', $screen->sanitize_array( $_POST ) );
		}

		$data = ob_get_clean();
		wp_send_json_success( $data );
		wp_die();
	}

	/**
	 * Creates the game stats table for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html         The incoming HTML for the player.
	 * @param array  $game         The array of information for the game.
	 * @param int    $team_id      The id of the team the player was playing for.
	 * @param string $sport        The sport the website is using.
	 * @param array  $POST         The incoming information from the AJAX call.
	 * @return string              The HTML for the table.
	 */
	public function sports_bench_do_player_game_stats_table( $html, $game, $team_id, $sport, $POST = [] ) {
		if ( $game->game_away_id === $team_id ) {
			$opponent = new Team( (int) $game->game_home_id );
			$opponent = $opponent->get_team_location() . ' ' . $opponent->get_team_photo( 'team-logo' );
		} else {
			$opponent = new Team( (int) $game->game_away_id );
			$opponent = 'at ' . $opponent->get_team_location() . ' ' . $opponent->get_team_photo( 'team-logo' );
		}
		if ( strlen( $game->ICE_TIME ) > 4 ) {
			$seconds = substr( $game->ICE_TIME, -2, 2 );
			$time    = substr_replace( $game->ICE_TIME, '', -2, 2 );
			$minutes = substr( $time, -2, 2 );
			$time    = substr_replace( $time, '', -2, 2 );
			$times   = array( $time, $minutes, $seconds );
			$time    = implode( ':', $times );
		} else {
			$seconds = substr( $game->ICE_TIME, -2, 2 );
			$minutes = substr_replace( $game->ICE_TIME, '', -2, 2 );
			$times   = array( $minutes, $seconds );
			$time    = implode( ':', $times );
		}
		if ( 'normal' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->GOALS . '</td>';
			$html .= '<td class="center">' . $game->ASSISTS . '</td>';
			$html .= '<td class="center">' . ( $game->GOALS + $game->ASSISTS ) . '</td>';
			$html .= '<td class="center">' . $game->SOG . '</td>';
			$html .= '<td class="center">' . $game->PM . '</td>';
			$html .= '<td class="center">' . $game->PEN . '</td>';
			$html .= '<td class="center">' . $game->PEN_MIN . '</td>';
			$html .= '<td class="center">' . $game->HITS . '</td>';
			$html .= '<td class="center">' . $game->SHIFTS . '</td>';
			$html .= '<td class="center">' . $time . '</td>';
			$html .= '<td class="center">' . $game->FACE . '-' . $game->FACE_WINS . '</td>';
			$html .= '</tr>';
		} elseif ( 'goalie' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->SHOTS_FACED . '</td>';
			$html .= '<td class="center">' . $game->SAVES . '</td>';
			$html .= '<td class="center">' . $game->GOALS_ALLOWED . '</td>';
			$html .= '</tr>';
		}

		return $html;
	}

}
