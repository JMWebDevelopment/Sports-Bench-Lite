<?php
/**
 * Creates the volleyball player class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Volleyball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The volleyball player class.
 *
 * This is used for volleyball player functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 */
class VolleyballPlayer extends Player {

	/**
	 * Creates the new VolleyballPlayer object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The slug or id of the team player create the object for.
	 */
	public function __construct( $player_selector ) {
		parent::__construct( $player_selector );
	}

	/**
	 * Gets the hitting percentage for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $attacks        The number of attacks.
	 * @param int $kills          The number of kills.
	 * @param int $errors         The number of hitting errors.
	 * @return float|string       The hitting percentage for the player.
	 */
	public function get_hitting_percentage( $attacks, $kills, $errors ) {
		if ( '0' === $attacks ) {
			$hit_percent = '.000';
		} else {
			$hit_percent = number_format( (float) ( $kills - $errors ) / $attacks, 3, '.', '' );
		}

		return $hit_percent;
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
		$querystr         = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_sets_played ) as SETS_PLAYED, COUNT( g.game_player_sets_played ) as GP, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_kills ) as KILLS, SUM( g.game_player_hitting_errors ) as HITTING_ERRORS, SUM( g.game_player_attacks ) as ATTACKS, SUM( g.game_player_set_attempts ) as SET_ATT, SUM( g.game_player_set_errors ) as SET_ERR, SUM( g.game_player_serves ) as SERVES, SUM( g.game_player_serve_errors ) as SE, SUM( g.game_player_aces ) as SA, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_block_attempts ) as BA, SUM( g.game_player_block_errors) as BE, SUM( g.game_player_digs ) as DIGS, SUM( g.game_player_receiving_errors) as RE
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
