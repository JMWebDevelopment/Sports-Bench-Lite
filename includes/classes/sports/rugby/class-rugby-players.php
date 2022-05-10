<?php
/**
 * Creates the rugby players class.
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
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;

/**
 * The rugby players class.
 *
 * This is used for rugby players functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyPlayers extends Players {

	/**
	 * Creates the new RugbyPlayers object to be used.
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
		$html .= '<table class="player-stats basketball">';
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
		$html .= '<th></th>';
		$html .= '<th>' . __( 'GP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'T', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'C', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'PG', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'DK', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'PC', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'MR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'R', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'Y', 'sports-bench' ) . '</th>';
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
			$html .= '<td class="center">' . $season->GP . '</td>';
			$html .= '<td class="center">' . $season->TRIES . '</td>';
			$html .= '<td class="center">' . $season->ASSISTS . '</td>';
			$html .= '<td class="center">' . $season->CONVERSIONS . '</td>';
			$html .= '<td class="center">' . $season->PK_GOALS . '</td>';
			$html .= '<td class="center">' . $season->DROP_KICKS . '</td>';
			$html .= '<td class="center">' . $season->POINTS . '</td>';
			$html .= '<td class="center">' . $season->PENALTIES_CONCEEDED . '</td>';
			$html .= '<td class="center">' . $season->METERS_RUN . '</td>';
			$html .= '<td class="center">' . $season->REDS . '</td>';
			$html .= '<td class="center">' . $season->YELLOWS . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_tries ) as TRIES, COUNT( g.game_player_meters_run ) as GP, SUM( g.game_player_meters_run ) as METERS_RUN, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_conversions ) as CONVERSIONS, SUM( g.game_player_penalty_goals ) as PK_GOALS, SUM( g.game_player_drop_kicks ) as DROP_KICKS, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_penalties_conceeded ) as PENALTIES_CONCEEDED, SUM( g.game_player_red_cards ) as REDS, SUM( g.game_player_yellow_cards ) as YELLOWS
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
			echo apply_filters( 'sports_bench_player_game_stats_table', '', $season, $team_id, 'rugby', $screen->sanitize_array( $_POST ) );
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
		$html .= '<tr class="new-stats-row">';
		$html .= '<td>&emsp;' . $opponent . '</td>';
		$html .= '<td class="center"></td>';
		$html .= '<td class="center">' . $game->TRIES . '</td>';
		$html .= '<td class="center">' . $game->ASSISTS . '</td>';
		$html .= '<td class="center">' . $game->CONVERSIONS . '</td>';
		$html .= '<td class="center">' . $game->PK_GOALS . '</td>';
		$html .= '<td class="center">' . $game->DROP_KICKS . '</td>';
		$html .= '<td class="center">' . $game->POINTS . '</td>';
		$html .= '<td class="center">' . $game->PENALTIES_CONCEEDED . '</td>';
		$html .= '<td class="center">' . $game->METERS_RUN . '</td>';
		$html .= '<td class="center">' . $game->REDS . '</td>';
		$html .= '<td class="center">' . $game->YELLOWS . '</td>';
		$html .= '</tr>';

		return $html;
	}

}
