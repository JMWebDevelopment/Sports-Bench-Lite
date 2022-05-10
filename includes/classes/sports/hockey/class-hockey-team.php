<?php
/**
 * Creates the hockey team class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Hockey;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The hockey team class.
 *
 * This is used for hockey team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 */
class HockeyTeam extends Team {

	/**
	 * Creates the new HockeyTeam object to be used.
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
			'goals'             => 0,
			'goals_against'     => 0,
			'shots_on_goal'     => 0,
			'power_plays'       => 0,
			'power_play_goals'  => 0,
			'penalty_minutes'   => 0
		];
		$num_games = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['goals']            += $stat->game_away_final;
				$stats_array['goals_against']    += $stat->game_home_final;
				$stats_array['shots_on_goal']    += ( $stat->game_away_first_sog + $stat->game_away_second_sog + $stat->game_away_third_sog + $stat->game_away_overtime_sog );
				$stats_array['power_plays']      += $stat->game_away_power_plays;
				$stats_array['power_play_goals'] += $stat->game_away_pp_goals;
				$stats_array['penalty_minutes']  += $stat->game_away_pen_minutes;
			} else {
				$stats_array['goals']            += $stat->game_home_final;
				$stats_array['goals_against']    += $stat->game_away_final;
				$stats_array['shots_on_goal']    += ( $stat->game_home_first_sog + $stat->game_home_second_sog + $stat->game_home_third_sog + $stat->game_home_overtime_sog );
				$stats_array['power_plays']      += $stat->game_home_power_plays;
				$stats_array['power_play_goals'] += $stat->game_home_pp_goals;
				$stats_array['penalty_minutes']  += $stat->game_home_pen_minutes;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$avg_stats['goals']            = round( ( $stats_array['goals'] / $num_games ), 2 );
			$avg_stats['goals_against']    = round( ( $stats_array['goals_against'] / $num_games ), 2 );
			$avg_stats['shots_on_goal']    = round( ( $stats_array['shots_on_goal'] / $num_games ), 1 );
			$avg_stats['power_plays']      = round( ( $stats_array['power_plays'] / $num_games ), 1 );
			$avg_stats['power_play_goals'] = round( ( $stats_array['power_play_goals'] / $num_games ), 1 );
			$avg_stats['penalty_minutes']  = round( ( $stats_array['penalty_minutes'] / $num_games ), 1 );
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
		$querystr         = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_plus_minus ) as PM, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_penalties ) as PEN, SUM( g.game_player_pen_minutes ) as PEN_MIN, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_shifts ) as SHIFTS, SUM( g.game_player_time_on_ice ) as ICE_TIME, SUM( g.game_player_faceoffs ) as FACE, SUM( g.game_player_faceoff_wins ) as FACE_WINS, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_saves ) as SAVES, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED, COUNT( g.game_player_time_on_ice ) as GP
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id
			ORDER BY GOALS DESC;",
			$this->team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new HockeyPlayer( (int) $player->player_id );
			$player_stats = array(
				'player_name'           => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'           => $the_player->get_permalink(),
				'goals'                 => $player->GOALS,
				'assists'               => $player->ASSISTS,
				'points'                => $player->GOALS + $player->ASSISTS,
				'plus_minus'            => $player->PM,
				'sog'                   => $player->SOG,
				'penalties'             => $player->PEN,
				'pen_minutes'           => $player->PEN_MIN,
				'hits'                  => $player->HITS,
				'shifts'                => $player->SHIFTS,
				'ice_time'              => $player->ICE_TIME,
				'faceoffs'              => $player->FACE,
				'faceoff_wins'          => $player->FACE_WINS,
				'shots_faced'           => $player->SHOTS_FACED,
				'saves'                 => $player->SAVES,
				'goals_allowed'         => $player->GOALS_ALLOWED,
				'goals_against_average' => $the_player->get_goals_against_average( (int) $player->GOALS_ALLOWED, (int) $player->GP ),
				'team_id'               => $this->team_id,
			);
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
