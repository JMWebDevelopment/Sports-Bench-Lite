<?php
/**
 * Creates the basketball player class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The basketball player class.
 *
 * This is used for basketball player functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 */
class BasketballPlayer extends Player {

	/**
	 * Creates the new BasketballPlayer object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The slug or id of the team player create the object for.
	 */
	public function __construct( $player_selector ) {
		parent::__construct( $player_selector );
	}

	/**
	 * Gets the points per game average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $points      The number of points scored.
	 * @param int $games       The number of games played.
	 * @return float           The points per game for the player.
	 */
	public function get_points_average( $points, $games ) {
		$average = $points / $games;
		$average = number_format( (float) $average, 2, '.', '' );

		return $average;
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_started ) as STARTS, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_minutes ) as MIN, SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_fga ) as FGA, SUM( g.game_player_3pm ) as TPM, SUM( g.game_player_3pa ) as TPA, SUM( g.game_player_ftm ) as FTM, SUM( g.game_player_fta ) as FTA, SUM( g.game_player_points ) as PTS, SUM( g.game_player_off_rebound ) as OFF_REB, SUM( g.game_player_def_rebound ) as DEF_REB, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_steals) as STEALS, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_to) as TURNOVERS, SUM( g.game_player_plus_minus ) as PM
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
