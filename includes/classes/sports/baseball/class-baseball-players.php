<?php
/**
 * Creates the baseball players class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Baseball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Sports\Baseball\BaseballPlayer;

/**
 * The baseball players class.
 *
 * This is used for baseball players functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 */
class BaseballPlayers extends Players {

	/**
	 * Creates the new BaseballPlayers object to be used.
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
		$player = new BaseballPlayer( $player->get_player_id() );

		if ( sports_bench_stat_exists( $seasons, 'AB' ) ) {
			$html .= '<table class="player-stats baseball batting">';
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
			$html .= '<th class="left">' . __( 'Career Batting Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'AB', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'AVG', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'H', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'R', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'RBI', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( '2B', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( '3B', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'HR', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SO', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'BB', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'HBP', 'sports-bench' ) . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $seasons as $season ) {
				$season_team = new Team( (int) $season->game_team_id );
				if ( 0 === $season->AB ) {
					$batting_average = '.000';
				} else {
					$batting_average = $player->get_batting_average( $season->AB, $season->HITS );
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
				$html .= '<td class="center">' . $season->AB . '</td>';
				$html .= '<td class="center">' . $batting_average . '</td>';
				$html .= '<td class="center">' . $season->HITS . '</td>';
				$html .= '<td class="center">' . $season->RUNS . '</td>';
				$html .= '<td class="center">' . $season->RBI . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->DOUBLES . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->TRIPLES . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->HOMERUNS . '</td>';
				$html .= '<td class="center">' . $season->STRIKEOUTS . '</td>';
				$html .= '<td class="center">' . $season->WALKS . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->HIT_BY_PITCH . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		if ( sports_bench_stat_exists( $seasons, 'PC' ) ) {
			$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );
			$html .= '<table class="player-stats baseball pitching">';
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
			$html .= '<th class="left">' . __( 'Career Pitching Stats', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'W-L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'SV', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'IP', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'ERA', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'R', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'ER', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'H', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'K', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'BB', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'HPB', 'sports-bench' ) . '</th>';
			$html .= '<th class="show-for-medium">' . __( 'HR', 'sports-bench' ) . '</th>';
			$html .= '<th>' . __( 'PC', 'sports-bench' ) . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $seasons as $season ) {
				$season_team = new Team( (int) $season->game_team_id );
				$record      = $player->get_pitcher_record( (int) $season->player_id, '"' . $season->game_season . '"' );

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
				$html .= '<td class="center">' . $record[ 'wins' ] . '-' . $record[ 'losses' ] . '</td>';
				$html .= '<td class="center">' . $player->get_pitcher_saves( (int) $season->player_id, '"' . $season->game_season . '"' ) . '</td>';
				$html .= '<td class="center">' . $season->IP . '</td>';
				$html .= '<td class="center">' . $player->get_ERA( (int) $season->ER, (int) $season->IP, $innings_per_game ) . '</td>';
				$html .= '<td class="center">' . $season->RA . '</td>';
				$html .= '<td class="center">' . $season->ER . '</td>';
				$html .= '<td class="center">' . $season->HA . '</td>';
				$html .= '<td class="center">' . $season->KS . '</td>';
				$html .= '<td class="center">' . $season->BB . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->HPB . '</td>';
				$html .= '<td class="center show-for-medium">' . $season->HRA . '</td>';
				$html .= '<td class="center">' . $season->PC . '</td>';
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_at_bats ) as AB, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_runs ) as RUNS, SUM( g.game_player_rbis ) as RBI, SUM( g.game_player_doubles ) as DOUBLES, SUM( g.game_player_triples ) as TRIPLES, SUM( g.game_player_homeruns ) as HOMERUNS, SUM( g.game_player_strikeouts ) as STRIKEOUTS, SUM( g.game_player_walks ) as WALKS, SUM(g.game_player_hit_by_pitch ) as HIT_BY_PITCH, SUM(g.game_player_fielders_choice ) as FC, SUM(g.game_player_innings_pitched ) as IP, SUM(g.game_player_pitcher_strikeouts ) as KS, SUM(g.game_player_pitcher_walks ) as BB, SUM(g.game_player_hit_batters ) as HPB, SUM(g.game_player_runs_allowed ) as RA, SUM(g.game_player_earned_runs ) as ER, SUM(g.game_player_hits_allowed ) as HA, SUM(g.game_player_homeruns_allowed ) as HRA, SUM(g.game_player_pitch_count ) as PC
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_player_id = %d and ( game.game_home_id = %d or game.game_away_id = %d ) and game.game_season = %s AND game.game_status = 'final'
			GROUP BY g.game_player_id, game.game_season, game.game_id; ",
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
			echo apply_filters( 'sports_bench_player_game_stats_table', '', $season, $team_id, 'baseball', $screen->sanitize_array( $_POST ) );
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
		if ( $POST['stat_group'] == 'batting' ) {
			if ( $game->AB == 0 ) {
				$batting_average = '.000';
			} else {
				$batting_average = sports_bench_get_batting_average( $game->AB, $game->HITS );
			}
			$html .= '<tr class="new-stats-row season-' . $POST['season'] . '">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td class="center">' . $game->AB . '</td>';
			$html .= '<td class="center">' . $batting_average . '</td>';
			$html .= '<td class="center">' . $game->HITS . '</td>';
			$html .= '<td class="center">' . $game->RUNS . '</td>';
			$html .= '<td class="center">' . $game->RBI . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->DOUBLES . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->TRIPLES . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->HOMERUNS . '</td>';
			$html .= '<td class="center">' . $game->STRIKEOUTS . '</td>';
			$html .= '<td class="center">' . $game->WALKS . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->HIT_BY_PITCH . '</td>';
			$html .= '</tr>';
		} else {

			/**
			 * Sets the number of normal innings for a game.
			 *
			 * @since 2.0.0
			 *
			 * @param int $innings      The default number of innings per game.
			 * @return int              The number of innings per game for your league.
			 */
			$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );

			$html .= '<tr class="new-stats-row season-' . $POST['season'] . '">';
			$html .= '<td>&emsp;' . $opponent . '</td>';
			$html .= '<td></td>';
			$html .= '<td></td>';
			$html .= '<td class="center">' . $game->IP . '</td>';
			$html .= '<td class="center">' . sports_bench_get_ERA( (int) $game->ER, (int) $game->IP, $innings_per_game ) . '</td>';
			$html .= '<td class="center">' . $game->RA . '</td>';
			$html .= '<td class="center">' . $game->ER . '</td>';
			$html .= '<td class="center">' . $game->HA . '</td>';
			$html .= '<td class="center">' . $game->KS . '</td>';
			$html .= '<td class="center">' . $game->BB . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->HPB . '</td>';
			$html .= '<td class="center show-for-medium">' . $game->HRA . '</td>';
			$html .= '<td class="center">' . $game->PC . '</td>';
			$html .= '</tr>';
		}


		return $html;
	}

}
