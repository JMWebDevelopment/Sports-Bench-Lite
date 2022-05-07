<?php
/**
 * Creates the soccer player class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Soccer;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The soccer player class.
 *
 * This is used for soccer player functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class SoccerPlayer extends Player {

	/**
	 * Creates the new SoccerPlayer object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The slug or id of the team player create the object for.
	 */
	public function __construct( $player_selector ) {
		parent::__construct( $player_selector );
	}

	/**
	 * Returns the goals against average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $goals_allowed      The number of goals allowed.
	 * @param int $games_played       The number of games/matches played.
	 * @return float                  The goals against average.
	 */
	public function get_goals_against_average( $goals_allowed, $games_played ) {
		$average = $goals_allowed / $games_played;
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) as MINUTES, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_shots ) as SHOTS, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_fouls ) as FOULS, SUM( g.game_player_fouls_suffered ) as FOULS_SUFFERED, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_shots_saved ) as SHOTS_SAVED, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED
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
