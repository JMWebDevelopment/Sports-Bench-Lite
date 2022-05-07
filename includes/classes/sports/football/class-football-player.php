<?php
/**
 * Creates the football player class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The football player class.
 *
 * This is used for football player functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class FootballPlayer extends Player {

	/**
	 * Creates the new FootballPlayer object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The slug or id of the team player create the object for.
	 */
	public function __construct( $player_selector ) {
		parent::__construct( $player_selector );
	}

	/**
	 * Gets the stats for a season for the player.
	 *
	 * @since 2.0.0
	 *
	 * @return array      A list of season stats for a player.
	 */
	public function get_seasons_stats() {
		global $wpdb;
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$player_id        = $this->get_player_id();
		$querystr         = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_completions ) as COMP, SUM( g.game_player_attempts ) as ATT, SUM( g.game_player_pass_yards ) as PASS_YD, SUM( g.game_player_pass_tds ) as PASS_TD, SUM( g.game_player_pass_ints ) as PASS_INT, SUM( g.game_player_rushes ) as RUSHES, SUM( g.game_player_rush_yards ) as RUSH_YARDS, SUM( g.game_player_rush_tds ) as RUSH_TD, SUM( g.game_player_rush_fumbles ) as RUSH_FUM, SUM( g.game_player_catches ) as CATCHES, SUM( g.game_player_receiving_yards ) as RECEIVE_YARDS, SUM( g.game_player_receiving_tds ) as RECEIVE_TD, SUM( g.game_player_receiving_fumbles ) as RECEIVE_FUM, SUM( g.game_player_tackles ) as TACKLES, SUM( g.game_player_tfl ) as TFL, SUM( g.game_player_sacks ) as SACKS, SUM( g.game_player_pbu ) as PBU, SUM( g.game_player_ints ) as INTS,  SUM( g.game_player_tds ) as TDS, SUM( g.game_player_ff ) as FF, SUM( g.game_player_fr ) as FR,  SUM( g.game_player_blocked ) as BLOCKED, SUM( g.game_player_yards ) as YARDS, SUM( g.game_player_fga ) as FGA,  SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_xpa ) as XPA, SUM( g.game_player_xpm ) as XPM, SUM( g.game_player_touchbacks ) as TB, SUM( g.game_player_returns ) as RETURNS, SUM( g.game_player_return_yards ) as RETURN_YARDS, SUM( g.game_player_return_tds ) as RETURN_TDS, SUM( g.game_player_return_fumbles ) as RETURN_FUMBLES
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_player_id = %d AND game.game_status = 'final'
			GROUP BY g.game_player_id, game.game_season;",
			$player_id
		);
		$seasons          = Database::get_results( $querystr );
		return $seasons;
	}

}
