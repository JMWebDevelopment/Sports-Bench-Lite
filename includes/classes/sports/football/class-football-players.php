<?php
/**
 * Creates the football players class.
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
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;

/**
 * The football players class.
 *
 * This is used for football players functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class FootballPlayers extends Players {

	/**
	 * Creates the new FootballPlayers object to be used.
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

		if ( sports_bench_stat_exists( $seasons, 'ATT' ) ) {
			$html .= '<table class="player-stats football passing">';
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
			$html .= '<th class="left">' . __( 'Career Passing Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'COMP', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'ATT', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'YARDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TD', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'INT', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $season->COMP . '</td>';
				$html .= '<td class="center">' . $season->ATT . '</td>';
				$html .= '<td class="center">' . $season->PASS_YD . '</td>';
				$html .= '<td class="center">' . $season->PASS_TD . '</td>';
				$html .= '<td class="center">' . $season->PASS_INT . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'RUSHES' ) ) {
			$html .= '<table class="player-stats football rushing">';
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
			$html .= '<th class="left">' . __( 'Career Rushing Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'RUSHES', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'YARDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FUMBLES', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $season->RUSHES . '</td>';
				$html .= '<td class="center">' . $season->RUSH_YARDS . '</td>';
				$html .= '<td class="center">' . $season->RUSH_TD . '</td>';
				$html .= '<td class="center">' . $season->RUSH_FUM . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'CATCHES' ) ) {
			$html .= '<table class="player-stats football receiving">';
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
			$html .= '<th class="left">' . __( 'Career Receiving Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'CATCHES', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'YARDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FUMBLES', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $season->CATCHES . '</td>';
				$html .= '<td class="center">' . $season->RECEIVE_YARDS . '</td>';
				$html .= '<td class="center">' . $season->RECEIVE_TD . '</td>';
				$html .= '<td class="center">' . $season->RECEIVE_FUM . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'TACKLES' ) || sports_bench_stat_exists( $seasons, 'INTS' ) || sports_bench_stat_exists( $seasons, 'FF' ) || sports_bench_stat_exists( $seasons, 'FR' ) || sports_bench_stat_exists( $seasons, 'BLOCKED' ) ) {
			$html .= '<table class="player-stats football defense">';
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
			$html .= '<th class="left">' . __( 'Career Defensive Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TCK', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'TFL', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SACKS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'INTS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FF', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FR', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'BLK', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'YDS', 'sports-bench' ) . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $seasons as $season ) {
				$season_team      = new Team( (int) $season->game_team_id );

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
				$html .= '<td class="center">' . $season->TACKLES . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->TFL . '</td>';
				$html .= '<td class="center">' . $season->SACKS . '</td>';
				$html .= '<td class="center">' . $season->INTS . '</td>';
				$html .= '<td class="center">' . $season->TDS . '</td>';
				$html .= '<td class="center">' . $season->FF . '</td>';
				$html .= '<td class="center">' . $season->FR . '</td>';
				$html .= '<td class="center">' . $season->BLOCKED . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->YARDS . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'FGA' ) || sports_bench_stat_exists( $seasons, 'XPA' ) ) {
			$html .= '<table class="player-stats football kicking">';
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
			$table_row_styles = apply_filters( 'sports_bench_player_stats_head_row', '', $player );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<th class="left">' . __( 'Career Passing Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FGM', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FGA', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'XPM', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'XPA', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TOUCHBACKS', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $season->FGM . '</td>';
				$html .= '<td class="center">' . $season->FGA . '</td>';
				$html .= '<td class="center">' . $season->XPM . '</td>';
				$html .= '<td class="center">' . $season->XPA . '</td>';
				$html .= '<td class="center">' . $season->TB . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'RETURNS' ) ) {
			$html .= '<table class="player-stats football returns">';
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
			$table_row_styles = apply_filters( 'sports_bench_player_stats_head_row', '', $player );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<th class="left">' . __( 'Career Receiving Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'RETURNS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'YARDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'TDS', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'FUMBLES', 'sports-bench' ) . '</th>';
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
				$html .= '<td class="center">' . $season->RETURNS . '</td>';
				$html .= '<td class="center">' . $season->RETURN_YARDS . '</td>';
				$html .= '<td class="center">' . $season->RETURN_TDS . '</td>';
				$html .= '<td class="center">' . $season->RETURN_FUMBLES . '</td>';
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_completions ) as COMP, SUM( g.game_player_attempts ) as ATT, SUM( g.game_player_pass_yards ) as PASS_YD, SUM( g.game_player_pass_tds ) as PASS_TD, SUM( g.game_player_pass_ints ) as PASS_INT, SUM( g.game_player_rushes ) as RUSHES, SUM( g.game_player_rush_yards ) as RUSH_YARDS, SUM( g.game_player_rush_tds ) as RUSH_TD, SUM( g.game_player_rush_fumbles ) as RUSH_FUM, SUM( g.game_player_catches ) as CATCHES, SUM( g.game_player_receiving_yards ) as RECEIVE_YARDS, SUM( g.game_player_receiving_tds ) as RECEIVE_TD, SUM( g.game_player_receiving_fumbles ) as RECEIVE_FUM, SUM( g.game_player_tackles ) as TACKLES, SUM( g.game_player_tfl ) as TFL, SUM( g.game_player_sacks ) as SACKS, SUM( g.game_player_pbu ) as PBU, SUM( g.game_player_ints ) as INTS,  SUM( g.game_player_tds ) as TDS, SUM( g.game_player_ff ) as FF, SUM( g.game_player_fr ) as FR,  SUM( g.game_player_blocked ) as BLOCKED, SUM( g.game_player_yards ) as YARDS, SUM( g.game_player_fga ) as FGA,  SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_xpa ) as XPA, SUM( g.game_player_xpm ) as XPM, SUM( g.game_player_touchbacks ) as TB, SUM( g.game_player_returns ) as RETURNS, SUM( g.game_player_return_yards ) as RETURN_YARDS, SUM( g.game_player_return_tds ) as RETURN_TDS, SUM( g.game_player_return_fumbles ) as RETURN_FUMBLES
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
			echo apply_filters( 'sports_bench_player_game_stats_table', '', $season, $team_id, 'football', $screen->sanitize_array( $_POST ) );
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

		if ( 'passing' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->COMP . '</td>';
			$html .= '<td class="center">' . $game->ATT . '</td>';
			$html .= '<td class="center">' . $game->PASS_YD . '</td>';
			$html .= '<td class="center">' . $game->PASS_TD . '</td>';
			$html .= '<td class="center">' . $game->PASS_INT . '</td>';
			$html .= '</tr>';
		} elseif ( 'rushing' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->RUSHES . '</td>';
			$html .= '<td class="center">' . $game->RUSH_YARDS . '</td>';
			$html .= '<td class="center">' . $game->RUSH_TD . '</td>';
			$html .= '<td class="center">' . $game->RUSH_FUM . '</td>';
			$html .= '</tr>';
		} elseif ( 'receiving' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->CATCHES . '</td>';
			$html .= '<td class="center">' . $game->RECEIVE_YARDS . '</td>';
			$html .= '<td class="center">' . $game->RECEIVE_TD . '</td>';
			$html .= '<td class="center">' . $game->RECEIVE_FUM . '</td>';
			$html .= '</tr>';
		} elseif ( 'defense' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->TACKLES . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->TFL . '</td>';
			$html .= '<td class="center">' . $game->SACKS . '</td>';
			$html .= '<td class="center">' . $game->INTS . '</td>';
			$html .= '<td class="center">' . $game->TDS . '</td>';
			$html .= '<td class="center">' . $game->FF . '</td>';
			$html .= '<td class="center">' . $game->FR . '</td>';
			$html .= '<td class="center">' . $game->BLOCKED . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->YARDS . '</td>';
			$html .= '</tr>';
		} elseif ( 'kicking' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->FGM . '</td>';
			$html .= '<td class="center">' . $game->FGA . '</td>';
			$html .= '<td class="center">' . $game->XPM . '</td>';
			$html .= '<td class="center">' . $game->XPA . '</td>';
			$html .= '<td class="center">' . $game->TB . '</td>';
			$html .= '</tr>';
		} elseif ( 'returns' === $POST['stat_group'] ) {
			$html .= '<tr class="new-stats-row">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->RETURNS . '</td>';
			$html .= '<td class="center">' . $game->RETURN_YARDS . '</td>';
			$html .= '<td class="center">' . $game->RETURN_TDS . '</td>';
			$html .= '<td class="center">' . $game->RETURN_FUMBLES . '</td>';
			$html .= '</tr>';
		}

		return $html;
	}

}
