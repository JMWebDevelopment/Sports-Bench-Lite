<?php
/**
 * Creates the volleyball team class.
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
 * The volleyball team class.
 *
 * This is used for volleyball team functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 */
class VolleyballTeam extends Team {

	/**
	 * Creates the new VolleyballTeam object to be used.
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
			'kills'             => 0,
			'blocks'            => 0,
			'aces'              => 0,
			'assists'           => 0,
			'digs'              => 0,
			'attacks'           => 0,
			'hitting_errors'    => 0,
		];
		$num_games   = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['points']         += ( $stat->game_away_first_set + $stat->game_away_second_set + $stat->game_away_third_set + $stat->game_away_fourth_set + $stat->game_away_fifth_set );
				$stats_array['points_against'] += ( $stat->game_home_first_set + $stat->game_home_second_set + $stat->game_home_third_set + $stat->game_home_fourth_set + $stat->game_home_fifth_set );
				$stats_array['kills']          += $stat->game_away_kills;
				$stats_array['blocks']         += $stat->game_away_blocks;
				$stats_array['aces']           += $stat->game_away_aces;
				$stats_array['assists']        += $stat->game_away_assists;
				$stats_array['digs']           += $stat->game_away_digs;
				$stats_array['attacks']        += $stat->game_away_attacks;
				$stats_array['hitting_errors'] += $stat->game_away_hitting_errors;
			} else {
				$stats_array['points']         += ( $stat->game_home_first_set + $stat->game_home_second_set + $stat->game_home_third_set + $stat->game_home_fourth_set + $stat->game_home_fifth_set );
				$stats_array['points_against'] += ( $stat->game_away_first_set + $stat->game_away_second_set + $stat->game_away_third_set + $stat->game_away_fourth_set + $stat->game_away_fifth_set );
				$stats_array['kills']          += $stat->game_home_kills;
				$stats_array['blocks']         += $stat->game_home_blocks;
				$stats_array['aces']           += $stat->game_home_aces;
				$stats_array['assists']        += $stat->game_home_assists;
				$stats_array['digs']           += $stat->game_home_digs;
				$stats_array['attacks']        += $stat->game_home_attacks;
				$stats_array['hitting_errors'] += $stat->game_home_hitting_errors;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$avg_stats['points']          = round( ( $stats_array['points'] / $num_games ), 2 );
			$avg_stats['points_against']  = round( ( $stats_array['points_against'] / $num_games ), 2 );
			$avg_stats['kills']           = round( ( $stats_array['kills'] / $num_games ), 1 );
			$avg_stats['blocks']          = round( ( $stats_array['blocks'] / $num_games ), 1 );
			$avg_stats['aces']            = round( ( $stats_array['aces'] / $num_games ), 1 );
			$avg_stats['assists']         = round( ( $stats_array['assists'] / $num_games ), 1 );
			$avg_stats['digs']            = round( ( $stats_array['digs'] / $num_games ), 1 );
			$avg_stats['attacks']         = round( ( $stats_array['attacks'] / $num_games ), 1 );
			$avg_stats['hitting_errors']  = round( ( $stats_array['hitting_errors'] / $num_games ), 1 );
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
		$querystr         = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_sets_played ) as SETS_PLAYED, COUNT( g.game_player_sets_played ) as GP, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_kills ) as KILLS, SUM( g.game_player_hitting_errors ) as HITTING_ERRORS, SUM( g.game_player_attacks ) as ATTACKS, SUM( g.game_player_set_attempts ) as SET_ATT, SUM( g.game_player_set_errors ) as SET_ERR, SUM( g.game_player_serves ) as SERVES, SUM( g.game_player_serve_errors ) as SE, SUM( g.game_player_aces ) as SA, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_block_attempts ) as BA, SUM( g.game_player_block_errors) as BE, SUM( g.game_player_digs ) as DIGS, SUM( g.game_player_receiving_errors) as RE
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id
			ORDER BY POINTS DESC;",
			$this->team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new VolleyballPlayer( (int) $player->player_id );
			$player_stats = [
				'player_name'       => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'       => $the_player->get_permalink(),
				'games_played'      => $player->GP,
				'sets_played'       => $player->SETS_PLAYED,
				'points'            => $player->POINTS,
				'hitting_percent'   => $the_player->get_hitting_percentage( $player->ATTACKS, $player->KILLS, $player->HITTING_ERRORS ),
				'kills'             => $player->KILLS,
				'attacks'           => $player->ATTACKS,
				'hitting_errors'    => $player->HITTING_ERRORS,
				'set_errors'        => $player->SET_ERR,
				'set_attempts'      => $player->SET_ATT,
				'serves'            => $player->SERVES,
				'serve_errors'      => $player->SE,
				'aces'              => $player->SA,
				'blocks'            => $player->BLOCKS,
				'block_attempts'    => $player->BA,
				'block_errors'      => $player->BE,
				'digs'              => $player->DIGS,
				'rec_errors'        => $player->RE,
				'team_id'           => $this->team_id,
			];
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
