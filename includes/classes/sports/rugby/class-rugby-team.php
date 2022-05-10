<?php
/**
 * Creates the rugby team class.
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
 * The rugby team class.
 *
 * This is used for rugby team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyTeam extends Team {

	/**
	 * Creates the new RugbyTeam object to be used.
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
			'points'                => 0,
			'points_against'        => 0,
			'tries'                 => 0,
			'conversions'           => 0,
			'penalty_goals'         => 0,
			'kick_percentage'       => 0,
			'meters_run'            => 0,
			'meters_hand'           => 0,
			'meters_pass'           => 0,
			'possession'            => 0,
			'clean_breaks'          => 0,
			'defenders_beaten'      => 0,
			'offload'               => 0,
			'rucks'                 => 0,
			'mauls'                 => 0,
			'turnovers_conceeded'   => 0,
			'scrums'                => 0,
			'lineouts'              => 0,
			'penalties_conceeded'   => 0,
			'red_cards'             => 0,
			'yellow_cards'          => 0,
			'free_kicks_conceeded'  => 0,
		];
		$num_games   = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['points']               += $stat->game_away_final;
				$stats_array['points_against']       += $stat->game_home_final;
				$stats_array['tries']                += $stat->game_away_tries;
				$stats_array['conversions']          += $stat->game_away_conversions;
				$stats_array['penalty_goals']        += $stat->game_away_penalty_goals;
				$stats_array['kick_percentage']      += $stat->game_away_kick_percentage;
				$stats_array['meters_run']           += $stat->game_away_meters_runs;
				$stats_array['meters_hand']          += $stat->game_away_meters_hand;
				$stats_array['meters_pass']          += $stat->game_away_meters_pass;
				$stats_array['possession']           += $stat->game_away_possession;
				$stats_array['clean_breaks']         += $stat->game_away_clean_breaks;
				$stats_array['defenders_beaten']     += $stat->game_away_defenders_beaten;
				$stats_array['offload']              += $stat->game_away_offload;
				$stats_array['rucks']                += $stat->game_away_rucks;
				$stats_array['mauls']                += $stat->game_away_mauls;
				$stats_array['turnovers_conceeded']  += $stat->game_away_turnovers_conceeded;
				$stats_array['scrums']               += $stat->game_away_scrums;
				$stats_array['lineouts']             += $stat->game_away_lineouts;
				$stats_array['penalties_conceeded']  += $stat->game_away_penalties_conceeded;
				$stats_array['red_cards']            += $stat->game_away_red_cards;
				$stats_array['yellow_cards']         += $stat->game_away_yellow_cards;
				$stats_array['free_kicks_conceeded'] += $stat->game_away_free_kicks_conceeded;
			} else {
				$stats_array['points']               += $stat->game_home_final;
				$stats_array['points_against']       += $stat->game_away_final;
				$stats_array['tries']                += $stat->game_home_tries;
				$stats_array['conversions']          += $stat->game_home_conversions;
				$stats_array['penalty_goals']        += $stat->game_home_penalty_goals;
				$stats_array['kick_percentage']      += $stat->game_home_kick_percentage;
				$stats_array['meters_run']           += $stat->game_home_meters_runs;
				$stats_array['meters_hand']          += $stat->game_home_meters_hand;
				$stats_array['meters_pass']          += $stat->game_home_meters_pass;
				$stats_array['possession']           += $stat->game_home_possession;
				$stats_array['clean_breaks']         += $stat->game_home_clean_breaks;
				$stats_array['defenders_beaten']     += $stat->game_home_defenders_beaten;
				$stats_array['offload']              += $stat->game_home_offload;
				$stats_array['rucks']                += $stat->game_home_rucks;
				$stats_array['mauls']                += $stat->game_home_mauls;
				$stats_array['turnovers_conceeded']  += $stat->game_home_turnovers_conceeded;
				$stats_array['scrums']               += $stat->game_home_scrums;
				$stats_array['lineouts']             += $stat->game_home_lineouts;
				$stats_array['penalties_conceeded']  += $stat->game_home_penalties_conceeded;
				$stats_array['red_cards']            += $stat->game_home_red_cards;
				$stats_array['yellow_cards']         += $stat->game_home_yellow_cards;
				$stats_array['free_kicks_conceeded'] += $stat->game_home_free_kicks_conceeded;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$avg_stats['points']               = round( ( $stats_array['points'] / $num_games ), 2 );
			$avg_stats['points_against']       = round( ( $stats_array['points_against'] / $num_games ), 2 );
			$avg_stats['tries']                = round( ( $stats_array['tries'] / $num_games ), 1 );
			$avg_stats['conversions']          = round( ( $stats_array['conversions'] / $num_games ), 1 );
			$avg_stats['penalty_goals']        = round( ( $stats_array['penalty_goals'] / $num_games ), 1 );
			$avg_stats['kick_percentage']      = round( ( $stats_array['kick_percentage'] / $num_games ), 1 );
			$avg_stats['meters_run']           = round( ( $stats_array['meters_run'] / $num_games ), 1 );
			$avg_stats['meters_hand']          = round( ( $stats_array['meters_hand'] / $num_games ), 1 );
			$avg_stats['meters_pass']          = round( ( $stats_array['meters_pass'] / $num_games ), 1 );
			$avg_stats['possession']           = round( ( $stats_array['possession'] / $num_games ), 1 );
			$avg_stats['clean_breaks']         = round( ( $stats_array['clean_breaks'] / $num_games ), 1 );
			$avg_stats['defenders_beaten']     = round( ( $stats_array['defenders_beaten'] / $num_games ), 1 );
			$avg_stats['offload']              = round( ( $stats_array['offload'] / $num_games ), 1 );
			$avg_stats['rucks']                = round( ( $stats_array['rucks'] / $num_games ), 1 );
			$avg_stats['mauls']                = round( ( $stats_array['mauls'] / $num_games ), 1 );
			$avg_stats['turnovers_conceeded']  = round( ( $stats_array['turnovers_conceeded'] / $num_games ), 1 );
			$avg_stats['scrums']               = round( ( $stats_array['scrums'] / $num_games ), 1 );
			$avg_stats['lineouts']             = round( ( $stats_array['lineouts'] / $num_games ), 1 );
			$avg_stats['penalties_conceeded']  = round( ( $stats_array['penalties_conceeded'] / $num_games ), 1 );
			$avg_stats['red_cards']            = round( ( $stats_array['red_cards'] / $num_games ), 1 );
			$avg_stats['yellow_cards']         = round( ( $stats_array['yellow_cards'] / $num_games ), 1 );
			$avg_stats['free_kicks_conceeded'] = round( ( $stats_array['free_kicks_conceeded'] / $num_games ), 1 );
		}

		return [ $stats_array, $avg_stats ];
	}

	/**
	 * Gets the player stats for a team for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the stats from.
	 * @return array              The player stats for a team.
	 */
	public function get_players_stats( $season ) {
		global $wpdb;
		$players_stats    = [];
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare(
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_tries ) as TRIES, COUNT( g.game_player_meters_run ) as GP, SUM( g.game_player_meters_run ) as METERS_RUN, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_conversions ) as CONVERSIONS, SUM( g.game_player_penalty_goals ) as PK_GOALS, SUM( g.game_player_drop_kicks ) as DROP_KICKS, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_penalties_conceeded ) as PENALTIES_CONCEEDED, SUM( g.game_player_red_cards ) as REDS, SUM( g.game_player_yellow_cards ) as YELLOWS
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id;",
			$this->team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new RugbyPlayer( (int) $player->player_id );
			$player_stats = [
				'player_name'           => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'           => $the_player->get_permalink(),
				'games_played'          => $player->GP,
				'tries'                 => $player->TRIES,
				'assists'               => $player->ASSISTS,
				'conversions'           => $player->CONVERSIONS,
				'pk_goals'              => $player->PK_GOALS,
				'drop_kicks'            => $player->DROP_KICKS,
				'points'                => $player->POINTS,
				'penalties_conceded'    => $player->PENALTIES_CONCEEDED,
				'meters_run'            => $player->METERS_RUN,
				'red_cards'             => $player->REDS,
				'yellow_cards'          => $player->YELLOWS,
				'team_id'               => $this->team_id,
			];
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
