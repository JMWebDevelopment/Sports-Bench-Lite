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

namespace Sports_Bench\Classes\Sports\Basketball;

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
class BasketballTeam extends Team {

	/**
	 * Creates the new BasketballTeam object to be used.
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
			'fgm'               => 0,
			'fga'               => 0,
			'3pm'               => 0,
			'3pa'               => 0,
			'ftm'               => 0,
			'fta'               => 0,
			'rebounds'          => 0,
			'off_rebounds'      => 0,
			'def_rebounds'      => 0,
			'assists'           => 0,
			'steals'            => 0,
			'blocks'            => 0,
			'pip'               => 0,
			'to'                => 0,
			'pot'               => 0,
			'fast_break'        => 0,
			'fouls'             => 0,
		];
		$num_games = 0;

		foreach ( $team_stats as $stat ) {
			if ( $team_id === $stat->game_away_id ) {
				$stats_array['points']         += $stat->game_away_final;
				$stats_array['points_against'] += $stat->game_home_final;
				$stats_array['fgm']            += $stat->game_away_fgm;
				$stats_array['fga']            += $stat->game_away_fga;
				$stats_array['3pm']            += $stat->game_away_3pm;
				$stats_array['3pa']            += $stat->game_away_3pa;
				$stats_array['ftm']            += $stat->game_away_ftm;
				$stats_array['fta']            += $stat->game_away_fta;
				$stats_array['rebounds']       += ( $stat->game_away_off_rebound + $stat->game_away_def_rebound );
				$stats_array['off_rebounds']   += $stat->game_away_off_rebound;
				$stats_array['def_rebounds']   += $stat->game_away_def_rebound;
				$stats_array['assists']        += $stat->game_away_assists;
				$stats_array['steals']         += $stat->game_away_steals;
				$stats_array['blocks']         += $stat->game_away_blocks;
				$stats_array['pip']            += $stat->game_away_pip;
				$stats_array['to']             += $stat->game_away_to;
				$stats_array['pot']            += $stat->game_away_pot;
				$stats_array['fast_break']     += $stat->game_away_fast_break;
				$stats_array['fouls']          += $stat->game_away_fouls;
			} else {
				$stats_array['points']         += $stat->game_home_final;
				$stats_array['points_against'] += $stat->game_away_final;
				$stats_array['fgm']            += $stat->game_home_fgm;
				$stats_array['fga']            += $stat->game_home_fga;
				$stats_array['3pm']            += $stat->game_home_3pm;
				$stats_array['3pa']            += $stat->game_home_3pa;
				$stats_array['ftm']            += $stat->game_home_ftm;
				$stats_array['fta']            += $stat->game_home_fta;
				$stats_array['rebounds']       += ( $stat->game_home_off_rebound + $stat->game_home_def_rebound );
				$stats_array['off_rebounds']   += $stat->game_home_off_rebound;
				$stats_array['def_rebounds']   += $stat->game_home_def_rebound;
				$stats_array['assists']        += $stat->game_home_assists;
				$stats_array['steals']         += $stat->game_home_steals;
				$stats_array['blocks']         += $stat->game_home_blocks;
				$stats_array['pip']            += $stat->game_home_pip;
				$stats_array['to']             += $stat->game_home_to;
				$stats_array['pot']            += $stat->game_home_pot;
				$stats_array['fast_break']     += $stat->game_home_fast_break;
				$stats_array['fouls']          += $stat->game_home_fouls;
			}
			$num_games++;
		}

		$avg_stats = array();

		if ( 0 < $num_games ) {
			$avg_stats['points'] = round( ( $stats_array['points'] / $num_games ), 1 );
			$avg_stats['points_against'] = round( ( $stats_array['points_against'] / $num_games ), 1 );
			$avg_stats['fgm'] = round( ( $stats_array['fgm'] / $num_games ), 1 );
			$avg_stats['fg_pct'] = round( ( $stats_array['fgm'] / $stats_array['fga'] ) * 100, 1 );
			$avg_stats['3pm'] = round( ( $stats_array['3pm'] / $num_games ), 1 );
			$avg_stats['3p_pct'] = round( ( $stats_array['3pm'] / $stats_array['3pa'] ) * 100, 1 );
			$avg_stats['ftm'] = round( ( $stats_array['ftm'] / $num_games ), 1 );
			$avg_stats['ft_pct'] = round( ( $stats_array['ftm'] / $stats_array['fta'] ) * 100, 1 );
			$avg_stats['rebounds'] = round( ( $stats_array['rebounds'] / $num_games ), 1 );
			$avg_stats['off_rebounds'] = round( ( $stats_array['off_rebounds'] / $num_games ), 1 );
			$avg_stats['def_rebounds'] = round( ( $stats_array['def_rebounds'] / $num_games ), 1 );
			$avg_stats['assists'] = round( ( $stats_array['assists'] / $num_games ), 1 );
			$avg_stats['steals'] = round( ( $stats_array['steals'] / $num_games ), 1 );
			$avg_stats['blocks'] = round( ( $stats_array['blocks'] / $num_games ), 1 );
			$avg_stats['pip'] = round( ( $stats_array['pip'] / $num_games ), 1 );
			$avg_stats['to'] = round( ( $stats_array['to'] / $num_games ), 1 );
			$avg_stats['pot'] = round( ( $stats_array['pot'] / $num_games ), 1 );
			$avg_stats['fast_break'] = round( ( $stats_array['fast_break'] / $num_games ), 1 );
			$avg_stats['fouls'] = round( ( $stats_array['fouls'] / $num_games ), 1 );
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
			"SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_started ) as STARTS, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_minutes ) as MIN, SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_fga ) as FGA, SUM( g.game_player_3pm ) as TPM, SUM( g.game_player_3pa ) as TPA, SUM( g.game_player_ftm ) as FTM, SUM( g.game_player_fta ) as FTA, SUM( g.game_player_points ) as PTS, SUM( g.game_player_off_rebound ) as OFF_REB, SUM( g.game_player_def_rebound ) as DEF_REB, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_steals) as STEALS, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_to) as TURNOVERS, SUM( g.game_player_plus_minus ) as PM
			FROM $player_table as p LEFT JOIN $game_stats_table as g
			ON p.player_id = g.game_player_id
			LEFT JOIN $game_table as game
			ON game.game_id = g.game_id
			WHERE g.game_team_id = %d and game.game_season = %s
			GROUP BY g.game_player_id
			ORDER BY PTS DESC;",
			$this->team_id,
			$season
		);
		$players          = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$the_player   = new BasketballPlayer( (int) $player->player_id );
			$player_stats = [
				'player_name'       => $player->player_first_name . ' ' . $player->player_last_name,
				'player_page'       => $the_player->get_permalink(),
				'games_played'      => $player->GP,
				'starts'            => $player->STARTS,
				'minutes'           => $player->MIN,
				'fgm'               => $player->FGM,
				'fga'               => $player->FGA,
				'3pm'               => $player->TPM,
				'3pa'               => $player->TPA,
				'ftm'               => $player->FTM,
				'fta'               => $player->FTA,
				'points'            => $player->PTS,
				'points_per_game'   => $the_player->get_points_average( $player->PTS, $player->GP ),
				'off_reb'           => $player->OFF_REB,
				'def_reb'           => $player->DEF_REB,
				'tot_reb'           => $player->OFF_REB + $player->DEF_REB,
				'assists'           => $player->ASSISTS,
				'steals'            => $player->STEALS,
				'blocks'            => $player->BLOCKS,
				'to'                => $player->TURNOVERS,
				'plus_minus'        => $player->PM,
				'team_id'           => $this->team_id,
			];
			array_push( $players_stats, $player_stats );
		}

		return $players_stats;
	}
}
