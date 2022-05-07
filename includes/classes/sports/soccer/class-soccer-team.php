<?php
/**
 * Creates the soccer team class.
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
 * The soccer team class.
 *
 * This is used for soccer team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class SoccerTeam extends Team {

	/**
	 * Creates the new SoccerTeam object to be used.
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
			'goals'         => 0,
			'goals_against' => 0,
			'possession'    => 0,
			'shots'         => 0,
			'sog'           => 0,
			'corners'       => 0,
			'offsides'      => 0,
			'fouls'         => 0,
			'saves'         => 0,
			'yellows'       => 0,
			'reds'          => 0,
		];
		$num_games   = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['goals']         += $stat->game_away_final;
				$stats_array['goals_against'] += $stat->game_home_final;
				$stats_array['possession']    += $stat->game_away_possession;
				$stats_array['shots']         += $stat->game_away_shots;
				$stats_array['sog']           += $stat->game_away_sog;
				$stats_array['corners']       += $stat->game_away_corners;
				$stats_array['offsides']      += $stat->game_away_offsides;
				$stats_array['fouls']         += $stat->game_away_fouls;
				$stats_array['saves']         += $stat->game_away_saves;
				$stats_array['yellows']       += $stat->game_away_yellow;
				$stats_array['reds']          += $stat->game_away_red;
			} else {
				$stats_array['goals']         += $stat->game_home_final;
				$stats_array['goals_against'] += $stat->game_away_final;
				$stats_array['possession']    += $stat->game_home_possession;
				$stats_array['shots']         += $stat->game_home_shots;
				$stats_array['sog']           += $stat->game_home_sog;
				$stats_array['corners']       += $stat->game_home_corners;
				$stats_array['offsides']      += $stat->game_home_offsides;
				$stats_array['fouls']         += $stat->game_home_fouls;
				$stats_array['saves']         += $stat->game_home_saves;
				$stats_array['yellows']       += $stat->game_home_yellow;
				$stats_array['reds']          += $stat->game_home_red;
			}
			$num_games++;
		}

		$avg_stats = [];

		if ( 0 < $num_games ) {
			$avg_stats['goals']         = round( ( $stats_array['goals'] / $num_games ), 2 );
			$avg_stats['goals_against'] = round( ( $stats_array['goals_against'] / $num_games ), 2 );
			$avg_stats['possession']    = round( ( $stats_array['possession'] / $num_games ), 1 );
			$avg_stats['shots']         = round( ( $stats_array['shots'] / $num_games ), 1 );
			$avg_stats['sog']           = round( ( $stats_array['sog'] / $num_games ), 1 );
			$avg_stats['corners']       = round( ( $stats_array['corners'] / $num_games ), 1 );
			$avg_stats['offsides']      = round( ( $stats_array['offsides'] / $num_games ), 1 );
			$avg_stats['fouls']         = round( ( $stats_array['fouls'] / $num_games ), 1 );
			$avg_stats['saves']         = round( ( $stats_array['saves'] / $num_games ), 1 );
			$avg_stats['yellows']       = round( ( $stats_array['yellows'] / $num_games ), 1 );
			$avg_stats['reds']          = round( ( $stats_array['reds'] / $num_games ), 1 );
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
		$querystr         = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) as MINUTES, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_shots ) as SHOTS, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_fouls ) as FOULS, SUM( g.game_player_fouls_suffered ) as FOULS_SUFFERED, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_shots_saved ) as SHOTS_SAVED, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id
			ORDER BY MINUTES DESC;",
			$this->team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new SoccerPlayer( (int) $player->player_id );
			$player_stats = [
				'player_id'             => $player->player_id,
				'player_page'           => $the_player->get_permalink(),
				'player_name'           => $player->player_first_name . ' ' . $player->player_last_name,
				'minutes'               => $player->MINUTES,
				'goals'                 => $player->GOALS,
				'assists'               => $player->ASSISTS,
				'shots'                 => $player->SHOTS,
				'sog'                   => $player->SOG,
				'fouls'                 => $player->FOULS,
				'fouls_suffered'        => $player->FOULS_SUFFERED,
				'shots_faced'           => $player->SHOTS_FACED,
				'shots_saved'           => $player->SHOTS_SAVED,
				'goals_allowed'         => $player->GOALS_ALLOWED,
				'goals_against_average' => $the_player->get_goals_against_average( (int) $player->GOALS_ALLOWED, (int) $player->GP ),
				'team_id'               => $this->team_id,
			];
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
