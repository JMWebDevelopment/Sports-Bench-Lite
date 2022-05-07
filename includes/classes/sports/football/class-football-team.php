<?php
/**
 * Creates the football team class.
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
 * The football team class.
 *
 * This is used for football team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class FootballTeam extends Team {

	/**
	 * Creates the new FootballTeam object to be used.
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
			'points'            => 0,
			'points_against'    => 0,
			'total'             => 0,
			'pass'              => 0,
			'rush'              => 0,
			'turnovers'         => 0,
			'ints'              => 0,
			'fumbles'           => 0,
			'fumbles_lost'      => 0,
			'possession'        => 0,
			'kick_returns'      => 0,
			'kick_return_yards' => 0,
			'penalties'         => 0,
			'penalty_yards'     => 0,
			'first_downs'       => 0,
		];
		$num_games   = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$possession                        = explode( ':', $stat->game_away_possession );
				$stats_array['points']            += $stat->game_away_final;
				$stats_array['points_against']    += $stat->game_home_final;
				$stats_array['total']             += $stat->game_away_total;
				$stats_array['pass']              += $stat->game_away_pass;
				$stats_array['rush']              += $stat->game_away_rush;
				$stats_array['turnovers']         += $stat->game_away_to;
				$stats_array['ints']              += $stat->game_away_ints;
				$stats_array['fumbles']           += $stat->game_away_fumbles;
				$stats_array['fumbles_lost']      += $stat->game_away_fumbles_lost;
				$stats_array['possession']        += ( ( intval( $possession[0] ) * 60 ) + intval( $possession[1] ) );
				$stats_array['kick_returns']      += $stat->game_away_kick_returns;
				$stats_array['kick_return_yards'] += $stat->game_away_kick_return_yards;
				$stats_array['penalties']         += $stat->game_away_penalties;
				$stats_array['penalty_yards']     += $stat->game_away_penalty_yards;
				$stats_array['first_downs']       += $stat->game_away_first_downs;
			} else {
				$possession = explode( ':', $stat->game_home_possession );
				$stats_array['points']            += $stat->game_home_final;
				$stats_array['points_against']    += $stat->game_away_final;
				$stats_array['total']             += $stat->game_home_total;
				$stats_array['pass']              += $stat->game_home_pass;
				$stats_array['rush']              += $stat->game_home_rush;
				$stats_array['turnovers']         += $stat->game_home_to;
				$stats_array['ints']              += $stat->game_home_ints;
				$stats_array['fumbles']           += $stat->game_home_fumbles;
				$stats_array['fumbles_lost']      += $stat->game_home_fumbles_lost;
				$stats_array['possession']        += ( ( intval( $possession[0] ) * 60 ) + intval( $possession[1] ) );
				$stats_array['kick_returns']      += $stat->game_home_kick_returns;
				$stats_array['kick_return_yards'] += $stat->game_home_kick_return_yards;
				$stats_array['penalties']         += $stat->game_home_penalties;
				$stats_array['penalty_yards']     += $stat->game_home_penalty_yards;
				$stats_array['first_downs']       += $stat->game_home_first_downs;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$possession = round( ( $stats_array['possession'] / $num_games ), 0 );
			$minutes    = floor( $possession / 60 );
			$seconds    = $possession % 60;
			if ( 9 > $seconds ) {
				$seconds = '0' . $seconds;
			}
			$avg_stats['points']            = round( ( $stats_array['points'] / $num_games ), 2 );
			$avg_stats['points_against']    = round( ( $stats_array['points_against'] / $num_games ), 2 );
			$avg_stats['possession']        = $minutes . ':' . $seconds;
			$avg_stats['total']             = round( ( $stats_array['total'] / $num_games ), 1 );
			$avg_stats['pass']              = round( ( $stats_array['pass'] / $num_games ), 1 );
			$avg_stats['rush']              = round( ( $stats_array['rush'] / $num_games ), 1 );
			$avg_stats['turnovers']         = round( ( $stats_array['turnovers'] / $num_games ), 1 );
			$avg_stats['ints']              = round( ( $stats_array['ints'] / $num_games ), 1 );
			$avg_stats['fumbles']           = round( ( $stats_array['fumbles'] / $num_games ), 1 );
			$avg_stats['fumbles_lost']      = round( ( $stats_array['fumbles_lost'] / $num_games ), 1 );
			$avg_stats['kick_returns']      = round( ( $stats_array['kick_returns'] / $num_games ), 1 );
			$avg_stats['kick_returns']      = round( ( $stats_array['kick_returns'] / $num_games ), 1 );
			$avg_stats['kick_return_yards'] = round( ( $stats_array['kick_return_yards'] / $num_games ), 1 );
			$avg_stats['penalties']         = round( ( $stats_array['penalties'] / $num_games ), 1 );
			$avg_stats['penalty_yards']     = round( ( $stats_array['penalty_yards'] / $num_games ), 1 );
			$avg_stats['first_downs']       = round( ( $stats_array['first_downs'] / $num_games ), 1 );
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
		$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_completions ) as COMP, SUM( g.game_player_attempts ) as ATT, SUM( g.game_player_pass_yards ) as PASS_YD, SUM( g.game_player_pass_tds ) as PASS_TD, SUM( g.game_player_pass_ints ) as PASS_INT, SUM( g.game_player_rushes ) as RUSHES, SUM( g.game_player_rush_yards ) as RUSH_YARDS, SUM( g.game_player_rush_tds ) as RUSH_TD, SUM( g.game_player_rush_fumbles ) as RUSH_FUM, SUM( g.game_player_catches ) as CATCHES, SUM( g.game_player_receiving_yards ) as RECEIVE_YARDS, SUM( g.game_player_receiving_tds ) as RECEIVE_TD, SUM( g.game_player_receiving_fumbles ) as RECEIVE_FUM, SUM( g.game_player_tackles ) as TACKLES, SUM( g.game_player_tfl ) as TFL, SUM( g.game_player_sacks ) as SACKS, SUM( g.game_player_pbu ) as PBU, SUM( g.game_player_ints ) as INTS,  SUM( g.game_player_tds ) as TDS, SUM( g.game_player_ff ) as FF, SUM( g.game_player_fr ) as FR,  SUM( g.game_player_blocked ) as BLOCKED, SUM( g.game_player_yards ) as YARDS, SUM( g.game_player_fga ) as FGA,  SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_xpa ) as XPA, SUM( g.game_player_xpm ) as XPM, SUM( g.game_player_touchbacks ) as TB, SUM( g.game_player_returns ) as RETURNS, SUM( g.game_player_return_yards ) as RETURN_YARDS, SUM( g.game_player_return_tds ) as RETURN_TDS, SUM( g.game_player_return_fumbles ) as RETURN_FUMBLES
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id;",
			$this->team_id,
			$season
		);
		$players = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new FootballPlayer( (int) $player->player_id );
			$player_stats = array(
				'player_name'       => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'       => $the_player->get_permalink(),
				'completions'       => $player->COMP,
				'attempts'          => $player->ATT,
				'pass_yards'        => $player->PASS_YD,
				'pass_tds'          => $player->PASS_TD,
				'pass_ints'         => $player->PASS_INT,
				'rushes'            => $player->RUSHES,
				'rush_yards'        => $player->RUSH_YARDS,
				'rush_tds'          => $player->RUSH_TD,
				'rush_fumbles'      => $player->RUSH_FUM,
				'catches'           => $player->CATCHES,
				'receiving_yards'   => $player->RECEIVE_YARDS,
				'receiving_tds'     => $player->RECEIVE_TD,
				'receiving_fumbles' => $player->RECEIVE_FUM,
				'tackles'           => $player->TACKLES,
				'tfl'               => $player->TFL,
				'sacks'             => $player->SACKS,
				'ints'              => $player->INTS,
				'tds'               => $player->TDS,
				'forced_fumbles'    => $player->FF,
				'fumbles_recovered' => $player->FR,
				'blocked'           => $player->BLOCKED,
				'yards'             => $player->YARDS,
				'fga'               => $player->FGA,
				'fgm'               => $player->FGM,
				'xpa'               => $player->XPA,
				'xpm'               => $player->XPM,
				'touchbacks'        => $player->TB,
				'returns'           => $player->RETURNS,
				'return_yards'      => $player->RETURN_YARDS,
				'return_tds'        => $player->RETURN_TDS,
				'return_fumbles'    => $player->RETURN_FUMBLES,
				'team_id'           => $this->team_id
			);
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
