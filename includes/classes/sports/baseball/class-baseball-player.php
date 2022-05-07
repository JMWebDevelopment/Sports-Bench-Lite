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

namespace Sports_Bench\Classes\Sports\Baseball;

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
class BaseballPlayer extends Player {

	/**
	 * Creates the new BaseballPlayer object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The slug or id of the team player create the object for.
	 */
	public function __construct( $player_selector ) {
		parent::__construct( $player_selector );
	}

	/**
	 * Returns the ERA for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int   $earned_runs           The number of earned runs given up.
	 * @param float $innings_pitched       The number of innings pitched.
	 * @param int   $innings_per_game      The number of innings per game.
	 * @return float|string                The ERA for the player.
	 */
	public function get_ERA( $earned_runs, $innings_pitched, $innings_per_game ) {
		if ( 0 === $innings_pitched && $earned_runs > 0) {
			$era = '&infin;';
		} elseif ( 0 === $innings_pitched && 0 === $earned_runs ) {
			$era = '0.00';
		} else {
			$era = $innings_per_game * ( $earned_runs / $innings_pitched );
			$era = number_format( (float) $era, 2, '.', '' );
		}
		return $era;
	}

	/**
	 * Returns the batting average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $at_bats       The number of at bats.
	 * @param int $hits          The number of hits.
	 * @return float|string      The batting average for the player.
	 */
	public function get_batting_average( $at_bats, $hits ) {
		if ( 0 === $at_bats || '0' === $at_bats ) {
			return '.000';
		}
		$average = $hits / $at_bats;
		$average = number_format( (float) $average, 3, '.', '' );
		return $average;
	}

	/**
	 * Gets the number of wins for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season       The season to check for wins.
	 * @return int                 The number of wins for the player.
	 */
	public function get_pitcher_wins( $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'W' ) AND ( g.game_season = %s ) );", $this->player_id, $season );
		$wins       = Database::s( $querystr );
		if ( ! empty( $wins ) ) {
			return $wins[0]->WINS;
		} else {
			return 0;
		}
	}

	/**
	 * Gets the number of losses for a pitcher.
	 *
	 * @since 2.0.0
	 * @param string $season       The season to check for losses.
	 * @return int                 1
	 */
	public function get_pitcher_losses( $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'L' ) AND ( g.game_season = %s ) );", $this->player_id, $season );
		$losses     = Database::get_results( $querystr );
		if ( ! empty( $losses ) ) {
			return $losses[0]->LOSSES;
		} else {
			return 0;
		}
	}

	/**
	 * Gets the record for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season       The season to get the record.
	 * @return array               The record for the player.
	 */
	public function get_pitcher_record( $season ) {
		$record = [
			'wins'      => $this->get_pitcher_wins( $season ),
			'losses'    => $this->get_pitcher_losses( $season ),
		];
		return $record;
	}

	/**
	 * Gets the number of saves for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season       The season to check for saves.
	 * @return int                 The number of saves for the player.
	 */
	public function get_pitcher_saves( $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS SAVES FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'S' ) AND ( g.game_season = %s ) );", $this->player_id, $season );
		$saves      = Database::get_results( $querystr );
		if ( ! empty( $saves ) ) {
			return $saves[0]->SAVES;
		} else {
			return 0;
		}
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
		$player_id        = $this->player_id;
		$querystr         = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_at_bats ) as AB, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_runs ) as RUNS, SUM( g.game_player_rbis ) as RBI, SUM( g.game_player_doubles ) as DOUBLES, SUM( g.game_player_triples ) as TRIPLES, SUM( g.game_player_homeruns ) as HOMERUNS, SUM( g.game_player_strikeouts ) as STRIKEOUTS, SUM( g.game_player_walks ) as WALKS, SUM(g.game_player_hit_by_pitch ) as HIT_BY_PITCH, SUM( g.game_player_fielders_choice ) as FC, TRUNCATE( ( ( SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) + TRUNCATE( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ),0 ) ) + ( TRUNCATE( ( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ) - TRUNCATE( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ),0 ) ),1 ) / 3 ) ),1 ) as IP, SUM( g.game_player_pitcher_strikeouts ) as KS, SUM( g.game_player_pitcher_walks ) as BB, SUM( g.game_player_hit_batters ) as HPB, SUM( g.game_player_runs_allowed ) as RA, SUM( g.game_player_earned_runs ) as ER, SUM( g.game_player_hits_allowed ) as HA, SUM( g.game_player_homeruns_allowed ) as HRA, SUM( g.game_player_pitch_count ) as PC
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
