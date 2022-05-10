<?php
/**
 * Creates the rugby player class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The rugby player class.
 *
 * This is used for rugby player functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyPlayer extends Player {

	/**
	 * Creates the new RugbyPlayer object to be used.
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_tries ) as TRIES, COUNT( g.game_player_meters_run ) as GP, SUM( g.game_player_meters_run ) as METERS_RUN, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_conversions ) as CONVERSIONS, SUM( g.game_player_penalty_goals ) as PK_GOALS, SUM( g.game_player_drop_kicks ) as DROP_KICKS, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_penalties_conceeded ) as PENALTIES_CONCEEDED, SUM( g.game_player_red_cards ) as REDS, SUM( g.game_player_yellow_cards ) as YELLOWS
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_player_id = %d AND game.game_status = 'final'
			GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
			$player_id
		);
		$seasons          = Database::get_results( $querystr );
		return $seasons;
	}

}
