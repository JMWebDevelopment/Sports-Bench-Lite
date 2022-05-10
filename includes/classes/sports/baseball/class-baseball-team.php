<?php
/**
 * Creates the baseball team class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The baseball team class.
 *
 * This is used for baseball team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 */
class BaseballTeam extends Team {

	/**
	 * Creates the new BaseballTeam object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $team_selector      The slug or id of the team to create the object for.
	 */
	public function __construct( $team_selector ) {
		parent::__construct( $team_selector );
	}

	/**
	 * Gets the team stats for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the stats for.
	 * @return array              A list of total and average team stats.
	 */
	public function get_team_season_stats( $season ) {
		global $wpdb;
		$team_id          = $this->get_team_id();
		$team_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare( "SELECT * FROM $game_table WHERE ( game_home_id = %d OR game_away_id = %d ) AND game_season = %s AND game_status LIKE 'final'", $team_id, $team_id, $season );
		$team_stats       = Database::get_results( $querystr );

		$stats_array = [
			'doubles'      => 0,
			'triples'      => 0,
			'homeruns'     => 0,
			'hits'         => 0,
			'errors'       => 0,
			'runs'         => 0,
			'lob'          => 0,
			'runs_against' => 0,
		];
		$num_games   = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['doubles']      += count( explode( ';', $stat->game_away_doubles ) );
				$stats_array['triples']      += count( explode( ';', $stat->game_away_triples ) );
				$stats_array['homeruns']     += count( explode( ';', $stat->game_away_homeruns ) );
				$stats_array['hits']         += $stat->game_away_hits;
				$stats_array['errors']       += $stat->game_away_errors;
				$stats_array['runs']         += $stat->game_away_final;
				$stats_array['lob']          += $stat->game_away_lob;
				$stats_array['runs_against'] += $stat->game_home_final;
			} else {
				$stats_array['doubles']      += count( explode( ';', $stat->game_home_doubles ) );
				$stats_array['triples']      += count( explode( ';', $stat->game_home_triples ) );
				$stats_array['homeruns']     += count( explode( ';', $stat->game_home_homeruns ) );
				$stats_array['hits']         += $stat->game_home_hits;
				$stats_array['errors']       += $stat->game_home_errors;
				$stats_array['runs']         += $stat->game_home_final;
				$stats_array['lob']          += $stat->game_home_lob;
				$stats_array['runs_against'] += $stat->game_away_final;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$avg_stats['doubles']      = round( ( $stats_array['doubles'] / $num_games ), 2 );
			$avg_stats['triples']      = round( ( $stats_array['triples'] / $num_games ), 1 );
			$avg_stats['homeruns']     = round( ( $stats_array['homeruns'] / $num_games ), 1 );
			$avg_stats['hits']         = round( ( $stats_array['hits'] / $num_games ), 1 );
			$avg_stats['errors']       = round( ( $stats_array['errors'] / $num_games ), 1 );
			$avg_stats['runs']         = round( ( $stats_array['runs'] / $num_games ), 1 );
			$avg_stats['lob']          = round( ( $stats_array['lob'] / $num_games ), 1 );
			$avg_stats['runs_against'] = round( ( $stats_array['runs_against'] / $num_games ), 1 );
		}

		return [ $stats_array, $avg_stats ];
	}

	/**
	 * Gets the player stats for a team for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the stats from.
	 * @return string             The player stats for a team.
	 */
	public function get_players_stats( $season ) {
		global $wpdb;
		$players_stats    = [];
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_at_bats ) as AB, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_runs ) as RUNS, SUM( g.game_player_rbis ) as RBI, SUM( g.game_player_doubles ) as DOUBLES, SUM( g.game_player_triples ) as TRIPLES, SUM( g.game_player_homeruns ) as HOMERUNS, SUM( g.game_player_strikeouts ) as STRIKEOUTS, SUM( g.game_player_walks ) as WALKS, SUM( g.game_player_hit_by_pitch ) as HIT_BY_PITCH, SUM( g.game_player_fielders_choice ) as FC, SUM( g.game_player_innings_pitched ) as IP, SUM( g.game_player_pitcher_strikeouts ) as KS, SUM( g.game_player_pitcher_walks ) as BB, SUM( g.game_player_hit_batters ) as HPB, SUM( g.game_player_runs_allowed ) as RA, SUM( g.game_player_earned_runs ) as ER, SUM( g.game_player_hits_allowed ) as HA, SUM( g.game_player_homeruns_allowed ) as HRA, SUM( g.game_player_pitch_count ) as PC
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id;",
			$this->team_id,
			$season
		);
		$players = $wpdb->get_results( $querystr );

		/**
		 * Sets the number of normal innings for a game.
		 *
		 * @since 2.0.0
		 *
		 * @param int $innings      The default number of innings per game.
		 * @return int              The number of innings per game for your league.
		 */
		$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );

		foreach ( $players as $player ) {
			$the_player = new BaseballPlayer( (int) $player->player_id );

			if ( 0 === $player->AB ) {
				$batting_average = '.000';
			} else {
				$batting_average = $the_player->get_batting_average( $player->AB, $player->HITS );
			}

			$player_stats = array(
				'player_name'           => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'           => $the_player->get_permalink(),
				'at_bats'               => $player->AB,
				'batting_average'       => $batting_average,
				'hits'                  => $player->HITS,
				'runs'                  => $player->RUNS,
				'rbi'                   => $player->RBI,
				'doubles'               => $player->DOUBLES,
				'triples'               => $player->TRIPLES,
				'homeruns'              => $player->HOMERUNS,
				'strikeouts'            => $player->STRIKEOUTS,
				'walks'                 => $player->WALKS,
				'hit_by_pitch'          => $player->HIT_BY_PITCH,
				'fielders_choice'       => $player->FC,
				'innings_pitched'       => $player->IP,
				'pitcher_strikeouts'    => $player->KS,
				'pitcher_walks'         => $player->BB,
				'pitcher_hit_batters'   => $player->HPB,
				'runs_allowed'          => $player->RA,
				'earned_runs'           => $player->ER,
				'era'                   => $the_player->get_ERA( (int) $player->ER, (int) $player->IP, $innings_per_game ),
				'hits_allowed'          => $player->HA,
				'homeruns_allowed'      => $player->HRA,
				'pitch_count'           => $player->PC,
				'team_id'               => $this->team_id,
			);
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
