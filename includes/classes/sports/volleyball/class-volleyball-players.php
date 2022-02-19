<?php
/**
 * Creates the volleyball players class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Volleyball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Sports\Volleyball\VolleyballPlayer;

/**
 * The volleyball players class.
 *
 * This is used for volleyball players functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 */
class VolleyballPlayers extends Players {

	/**
	 * Creates the new VolleyballPlayers object to be used.
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
		$player = new VolleyballPlayer( (int) $player->get_player_id() );

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
		$html .= '<th>' . __( 'SP', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'HIT %', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'K', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'ATT', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'HE', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'SET E', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'SET A', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'S', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'SE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'ACE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'B', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'BA', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'BE', 'sports-bench' ) . '</th>';
		$html .= '<th>' . __( 'DIG', 'sports-bench' ) . '</th>';
		$html .= '<th class="show-for-medium">' . __( 'RE', 'sports-bench' ) . '</th>';
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
			$html .= '<td class="center">' . $season->SETS_PLAYED . '</td>';
			$html .= '<td class="center">' . $season->POINTS . '</td>';
			$html .= '<td class="center">' . $player->get_hitting_percentage( $season->ATTACKS, $season->KILLS, $season->HITTING_ERRORS ) . '</td>';
			$html .= '<td class="center">' . $season->KILLS . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->ATTACKS . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->HITTING_ERRORS . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->SET_ERR . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->SET_ATT . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->SERVES . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->SE . '</td>';
			$html .= '<td class="center">' . $season->SA . '</td>';
			$html .= '<td class="center">' . $season->BLOCKS . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->BA . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->BE . '</td>';
			$html .= '<td class="center">' . $season->DIGS . '</td>';
			$html .= '<td class="center show-for-medium">' . $season->RE . '</td>';
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
		$team    = $_POST['team'];
		$team    = new Team( $team );
		$team_id = $team->get_team_id();
		$player  = (int) $_POST['player'];
		$season  = $_POST['season'];

		ob_start();

		global $wpdb;
		$player_table     = SB_TABLE_PREFIX . 'players';
		$game_stats_table = SB_TABLE_PREFIX . 'game_stats';
		$game_table       = SB_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_sets_played ) as SETS_PLAYED, COUNT( g.game_player_sets_played ) as GP, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_kills ) as KILLS, SUM( g.game_player_hitting_errors ) as HITTING_ERRORS, SUM( g.game_player_attacks ) as ATTACKS, SUM( g.game_player_set_attempts ) as SET_ATT, SUM( g.game_player_set_errors ) as SET_ERR, SUM( g.game_player_serves ) as SERVES, SUM( g.game_player_serve_errors ) as SE, SUM( g.game_player_aces ) as SA, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_block_attempts ) as BA, SUM( g.game_player_block_errors) as BE, SUM( g.game_player_digs ) as DIGS, SUM( g.game_player_receiving_errors) as RE
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
			echo apply_filters( 'sports_bench_player_game_stats_table', '', $season, $team_id, 'soccer', $_POST );
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
		$html .= '<td class="center"></td>';
		$html .= '<td class="center">' . $game->POINTS . '</td>';
		$html .= '<td class="center">' . sports_bench_get_hitting_percentage( $game->ATTACKS, $game->KILLS, $game->HITTING_ERRORS ) . '</td>';
		$html .= '<td class="center">' . $game->KILLS . '</td>';
		$html .= '<td class="center">' . $game->ATTACKS . '</td>';
		$html .= '<td class="center">' . $game->HITTING_ERRORS . '</td>';
		$html .= '<td class="center">' . $game->SET_ERR . '</td>';
		$html .= '<td class="center">' . $game->SET_ATT . '</td>';
		$html .= '<td class="center">' . $game->SERVES . '</td>';
		$html .= '<td class="center">' . $game->SE . '</td>';
		$html .= '<td class="center">' . $game->SA . '</td>';
		$html .= '<td class="center">' . $game->BLOCKS . '</td>';
		$html .= '<td class="center">' . $game->BA . '</td>';
		$html .= '<td class="center">' . $game->BE . '</td>';
		$html .= '<td class="center">' . $game->DIGS . '</td>';
		$html .= '<td class="center">' . $game->RE . '</td>';
		$html .= '</tr>';

		return $html;
	}

}