<?php
/**
 * Creates the stats class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Base;

use Sports_Bench\Classes\Base\Team;

/**
 * The core stats class.
 *
 * This is used for the stats in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Stats {

	/**
	 * Creates the new Stats object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Returns the abbreviation guide if the option is selected.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The abbreviation guide.
	 */
	public function show_stats_abbreviation_guide() {
		$guide = '';

		if ( 1 === get_option( 'sports-bench-abbreviation-guide' ) ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'AB - ' . esc_html__( 'Batting Average', 'sports-bench' ) . '; AVG - ' . esc_html__( 'Batting Average', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits', 'sports-bench' ) . '; R - ' . esc_html__( 'Runs', 'sports-bench' ) . '; RBI - ' . esc_html__( 'Runs Batted In', 'sports-bench' ) . '; 2B - ' . esc_html__( 'Doubles', 'sports-bench' ) . '; 3B - ' . esc_html__( 'Triples', 'sports-bench' ) . '; HR - ' . esc_html__( 'Home Runs', 'sports-bench' ) . '; SO - ' . esc_html__( 'Strikeouts', 'sports-bench' ) . '; BB - ' . esc_html__( 'Walks', 'sports-bench' ) . '; HBP - ' . esc_html__( 'Hit By Pitch', 'sports-bench' ) . '; IP - ' . esc_html__( 'Innings Pitched', 'sports-bench' ) . '; ERA  - ' . esc_html__( 'Earned Run Average', 'sports-bench' ) . '; R - ' . esc_html__( 'Runs Allowed', 'sports-bench' ) . '; ER - ' . esc_html__( 'Earned Runs', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits Allowed', 'sports-bench' ) . '; K - ' . esc_html__( 'Strikeouts', 'sports-bench' ) . '; PC - ' . esc_html__( 'Pitch Count', 'sports-bench' );
			} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'MIN - ' . esc_html__( 'Minutes', 'sports-bench' ) . '; GP - ' . esc_html__( 'Games Played', 'sports-bench' ) . '; FG - ' . esc_html__( 'Field Goals', 'sports-bench' ) . '; 3-PT - ' . esc_html__( 'Three Points', 'sports-bench' ) . ' FT - ' . esc_html__( 'Free Throws', 'sports-bench' ) . '; +/- - ' . esc_html__( 'Plus/Minus', 'sports-bench' ) . '; PTS - ' . esc_html__( 'Points', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; S - ' . esc_html__( 'Steals', 'sports-bench' ) . '; B - ' . esc_html__( 'Blocks', 'sports-bench' ). '; TO - ' . esc_html__( 'Turnovers', 'sports-bench' ) . '; F - ' . esc_html__( 'Fouls', 'sports-bench' ) . 'O - ' . esc_html__( 'Offensive Rebounds', 'sports-bench' ) . '; D - ' . esc_html__( 'Defensive Rebounds', 'sports-bench' ) . '; TOT - ' . esc_html__( 'Total Rebounds', 'sports-bench' );
			} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'COMP - ' . esc_html__( 'Completions', 'sports-bench' ) . '; ATT - ' . esc_html__( 'Attempts', 'sports-bench' ) . '; TD - ' . esc_html__( 'Touchdowns', 'sports-bench' ) . '; INT - ' . esc_html__( 'Interceptions', 'sports-bench' ) . '; REC - ' . esc_html__( 'Receptions', 'sports-bench' ) . '; TKL - ' . esc_html__( 'Tackles', 'sports-bench' ) . '; TFL - ' . esc_html__( 'Tackles for Loss', 'sports-bench' ) . '; S - ' . esc_html__( 'Sacks', 'sports-bench' ) . '; PB - ' . esc_html__( 'Pass Breakups', 'sports-bench' ) .'; FF - ' . esc_html__( 'Forced Fumbles', 'sports-bench' ) . '; FR - ' . esc_html__( 'Fumbles Recovered', 'sports-bench' ) . '; BLK - ' . esc_html__( 'Blocked Kicks', 'sports-bench' ) . '; YDS - ' . esc_html__( 'Return Yards', 'sports-bench' ) . '; FGM - ' . esc_html__( 'Field Goals Made', 'sports-bench' ) . '; FGA - ' . esc_html__( 'Field Goals Attempted', 'sports-bench' ) . '; XPM - ' . esc_html__( 'Extra Points Made', 'sports-bench' ) . '; XPA - ' . esc_html__( 'Extra Points Attempted', 'sports-bench' ) . '; TB - ' . esc_html__( 'Touchbacks', 'sports-bench' ) . '; FUM - ' . esc_html__( 'Fumbles', 'sports-bench' );
			} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'SOG - ' . esc_html__( 'Shots on Goal', 'sports-bench' ) . '; G - ' . esc_html__( 'Goals', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; +/- - ' . esc_html__( 'Plus/Minus', 'sports-bench' ) . '; S - ' . esc_html__( 'Shots', 'sports-bench' ) . '; PM - ' . esc_html__( 'Penalty Minutes', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits', 'sports-bench' ) . '; SFT - ' . esc_html__( 'Shifts', 'sports-bench' ) . '; TOI - ' . esc_html__( 'Time on Ice', 'sports-bench' ) . '; FO-W - ' . esc_html__( 'Faceoffs - Faceoff Wins', 'sports-bench' ) . '; SF - ' . esc_html__( 'Shots Faced', 'sports-bench' ) . '; SV - ' . esc_html__( 'Saves', 'sports-bench' ) . '; GA - ' . esc_html__( 'Goals Allowed', 'sports-bench' ) . '; P - ' . esc_html__( 'Penalties', 'sports-bench' ) . '; PTS - ' . esc_html__( 'Points', 'sports-bench' ) . '; GAA - ' . esc_html__( 'Goals Against Average', 'sports-bench' ) . '; SFT - ' . esc_html__( 'Shifts', 'sports-bench' );
			} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'T - ' . esc_html__( 'Tries', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; C - ' . esc_html__( 'Conversions', 'sports-bench' ) . '; PG - ' . esc_html__( 'Penalty Goals', 'sports-bench' ) . '; DK - ' . esc_html__( 'Drop Kicks', 'sports-bench' ) . '; PC - ' . esc_html__( 'Penalties Conceded', 'sports-bench' ) . '; MR - ' . esc_html__( 'Meters Run', 'sports-bench' ) . '; RED - ' . esc_html__( 'Red Cards', 'sports-bench' ) . '; YELLOW - ' . esc_html__( 'Yellow Cards', 'sports-bench' );
			} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'MIN - ' . esc_html__( 'Minutes', 'sports-bench' ) . '; G - ' . esc_html__( 'Goals', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; SH - ' . esc_html__( 'Shots', 'sports-bench' ) . '; SOG - ' . esc_html__( 'Shots On Goal', 'sports-bench' ) . '; F - ' . esc_html__( 'Fouls', 'sports-bench' ) . '; FS - ' . esc_html__( 'Fouls Suffered', 'sports-bench' ) . '; SF - ' . esc_html__( 'Shots Faced', 'sports-bench' ) . '; SV - ' . esc_html__( 'Saves', 'sports-bench' ) . '; GA - ' . esc_html__( 'Goals Allowed', 'sports-bench' ) . '; GAA - ' . esc_html__( 'Goals Against Average', 'sports-bench' );
			} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'SP - ' . esc_html__( 'Sets Played', 'sports-bench' ) . '; PTS - ' . esc_html__( 'Points', 'sports-bench' ) . '; K - ' . esc_html__( 'Kills', 'sports-bench' ) . '; HE - ' . esc_html__( 'Hitting Errors', 'sports-bench' ) . '; AT - ' . esc_html__( 'Attacks', 'sports-bench' ) . '; HIT % - ' . esc_html__( 'Hitting Percentage', 'sports-bench' ) . '; S - ' . esc_html__( 'Serves', 'sports-bench' ) . '; SE - ' . esc_html__( 'Serving Errors', 'sports-bench' ) . '; ACE - ' . esc_html__( 'Aces', 'sports-bench' ) . '; SET A - ' . esc_html__( 'Set Attempts', 'sports-bench' ) . '; SET E - ' . esc_html__( 'Set Errors', 'sports-bench' ) . '; BA - ' . esc_html__( 'Block Attempts', 'sports-bench' ) . '; B - ' . esc_html__( 'Blocks', 'sports-bench' ) . '; BE - ' . esc_html__( 'Blocking Errors', 'sports-bench' ) . ';  DIG - ' . esc_html__( 'Digs', 'sports-bench' ) . '; RE - ' . esc_html__( 'Reception Errors', 'sports-bench' ) . '; GP - ' . esc_html__( 'Games Played', 'sports-bench' );
			}
		}

		return $guide;
	}

	/**
	 * Displays the stats leaderboard page template.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the stats leaderboard page template.
	 */
	public function stats_page_template() {
		$html = '';

		$stats = get_post_meta( get_the_ID(), 'sports_bench_stats', true );

		if ( $stats ) {
			$html .= '<div class="sports-bench-stats">';
			foreach ( $stats as $stat ) {

				/**
				 * Adds in HTML to be shown before the stat container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html          The current HTML for the filter.
				 * @param string $stat          The stat that is being shown.
				 * @return string               HTML to be shown before the container.
				 */
				$html .= apply_filters( 'sports_bench_before_stat', '', $stat['sports_bench_stats'] );
				$html .= '<div class="stat-container">';
				$html .= '<div id="' . $stat['sports_bench_stats'] . '-stat" class="stat-div sports-bench-stat">';
				$html .= '<h2>' . $this->get_stat_title( $stat['sports_bench_stats'] ) . '</h2>';
				$html .= $this->get_stats_leaders( $stat['sports_bench_stats'], get_option( 'sports-bench-season-year' ) );
				$html .= '</div>';
				$html .= '</div>';

				/**
				 * Adds in HTML to be shown after the stat container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html          The current HTML for the filter.
				 * @param string $stat          The stat that is being shown.
				 * @return string               HTML to be shown after the container.
				 */
				$html .= apply_filters( 'sports_bench_after_stat', '', $stat['sports_bench_stats'] );
			}
			$html .= '</div>';
		}

		return $html;

	}

	/**
	 * Displays a table of leaders for a stat.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat        The stat to look for.
	 * @param string $season      The season to look for the stat in.
	 * @return string             Table of players for that stat.
	 */
	public function get_stats_leaders( $stat, $season ) {
		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		/**
		 * Determines how many players to get for the stat.
		 *
		 * @since 2.0.0
		 *
		 * @param int $num_players      The default number of players to get.
		 * @return int                  The number of players to get.
		 */
		$limit = apply_filters( 'sports_bench_stat_leader_limit', 10 );
		if ( 'batting_average' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_at_bats ) AS AB, SUM( g.game_player_hits ) AS HITS
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->AB ) {
					$batting_average = '.000';
				} else {
					$batting_average = sports_bench_get_batting_average( (int) $player->AB, (int) $player->HITS );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $batting_average,
				];
				array_push( $the_players, $the_player );
			}

			if ( ! empty( $the_players ) ) {
				foreach ( $the_players as $key => $row ) {
					$average[ $key ] = $row['stat'];
				}
				array_multisort( $average, SORT_DESC, $the_players );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array  $the_players     The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'wins' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, COUNT( g.game_player_decision ) AS WINS, SUM( g.game_player_innings_pitched ) as IP
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE g.game_player_decision = 'W' AND game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->IP ) {
					continue;
				} else {
					$wins = $player->WINS;
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $wins,
				];
				array_push( $the_players, $the_player );
			}

			$wins = [];
			foreach ( $the_players as $key => $row ) {
				$wins[ $key ] = $row['stat'];
			}
			array_multisort( $wins, SORT_DESC, $the_players );

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'saves' === $stat ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, COUNT( g.game_player_decision ) AS SAVES, SUM( g.game_player_innings_pitched ) as IP
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE g.game_player_decision = 'S' AND game.game_season = %s
					GROUP BY g.game_player_id, game.game_season",
					$season
				);
				$players     = Database::get_results( $querystr );
				$html        = '';
				$the_players = [];
				foreach ( $players as $player ) {
					if ( 0 === $player->IP ) {
						continue;
					} else {
						$saves = $player->SAVES;
					}
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => $saves,
					];
					array_push( $the_players, $the_player );
				}

				$saves = [];
				foreach ( $the_players as $key => $row ) {
					$saves[ $key ] = $row['stat'];
				}
				array_multisort( $saves, SORT_DESC, $the_players );

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_$stat ) AS STAT
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT DESC
					LIMIT %d;",
					$season,
					$limit
				);
				$players  = Database::get_results( $querystr );
				$html     = '';

				$the_players = [];
				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => $player->STAT,
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
			}
		} elseif ( 'era' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_innings_pitched ) AS IP, SUM( g.game_player_earned_runs ) AS ER
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players          = Database::get_results( $querystr );
			$html             = '';
			$the_players      = [];
			$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );

			foreach ( $players as $player ) {
				if ( 0 === $player->IP ) {
					continue;
				} else {
					$era = sports_bench_get_ERA( (int) $player->ER, (int) $player->IP, $innings_per_game );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $era,
				];
				array_push( $the_players, $the_player );
			}

			$era = [];
			foreach ( $the_players as $key => $row ) {
				$era[ $key ] = $row['stat'];
			}
			array_multisort( $era, SORT_ASC, $the_players );

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'minutes' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) AS MIN
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY MIN DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				if ( strlen( $player->MIN ) > 4 ) {
					$seconds = substr( $player->MIN, -2, 2 );
					$time    = substr_replace( $player->MIN, '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $player->MIN, -2, 2 );
					$minutes = substr_replace( $player->MIN, '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $time,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'points_per_game' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_points ) AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY STAT DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->STAT,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'shooting_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_fgm ) AS FGM, SUM( g.game_player_fga ) AS FGA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->FGM ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->FGM, (int) $player->FGA, 9 );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$shooting_percentage = [];
			foreach ( $the_players as $key => $row ) {
				$shooting_percentage[ $key ] = $row['stat'];
			}
			array_multisort( $shooting_percentage, SORT_DESC, $the_players );

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'ft_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_ftm ) AS FTM, SUM( g.game_player_fta ) AS FTA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->FTA ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->FTM, (int) $player->FTA );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$ft_percent = [];
			foreach ( $the_players as $key => $row ) {
				$ft_percent[ $key ] = $row['stat'];
			}
			array_multisort( $ft_percent, SORT_DESC, $the_players );

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( '3p_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_3pm ) AS TPM, SUM( g.game_player_3pa ) AS TPA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->TPA ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->TPM, (int) $player->TPA );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$tp_percentage = [];
			foreach ( $the_players as $key => $row ) {
				$tp_percentage[ $key ] = $row['stat'];
			}
			array_multisort( $tp_percentage, SORT_DESC, $the_players );

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'rebounds' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_off_rebound ) + SUM( g.game_player_def_rebound ) ) AS TOTAL
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY TOTAL ASC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->TOTAL,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'comp_percentage' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_completions ) / SUM( g.game_player_attempts ) ) AS COMP_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_attempts > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY COMP_PERC DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->COMP_PERC, 2, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'fg_percentage' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_fgm ) / SUM( g.game_player_fga ) ) AS FG_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_fga > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY FG_PERC DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->FG_PERC, 2, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'xp_percentage' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_xpm ) / SUM( g.game_player_xpa ) ) AS XP_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_xpa > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY XP_PERC DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->XP_PERC, 2, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'points' === $stat ) {
			if ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_goals ) + SUM( g.game_player_assists ) ) AS POINTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY POINTS DESC
					LIMIT %d;",
					$season,
					$limit
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_points ) AS POINTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY POINTS DESC
					LIMIT %d;",
					$season,
					$limit
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
			}

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->POINTS,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'time_on_ice' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_time_on_ice ) AS MIN
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY MIN DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				if ( strlen( $player->MIN ) > 4 ) {
					$seconds = substr( $player->MIN, -2, 2 );
					$time    = substr_replace( $player->MIN, '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $player->MIN, -2, 2 );
					$minutes = substr_replace( $player->MIN, '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $time,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} elseif ( 'goals_against_average' === $stat ) {
			if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_goals_allowed ) AS STAT, SUM( g.game_player_shots_faced ) AS SHOTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s and g.game_player_shots_faced > 0
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT ASC
					LIMIT %d;",
					$season,
					$limit
				);
				$players  = Database::get_results( $querystr );
				$html     = '';

				$the_players = [];
				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => number_format( (float) $player->STAT, 2, '.', '' ),
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_goals_allowed ) AS STAT, SUM( g.game_player_saves ) AS SHOTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT DESC
					LIMIT %d;",
					$season,
					$limit
				);
				$players  = Database::get_results( $querystr );
				$html     = '';

				$the_players = [];
				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => number_format( (float) $player->STAT, 2, '.', '' ),
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
			}
		} elseif ( 'hitting_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_attacks ) AS ATTACKS, SUM( g.game_player_kills ) AS KILLS, SUM( g.game_player_hitting_errors ) AS HIT_ERRORS
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->ATTACKS  ) {
					$hitting_percentage = '.000';
				} else {
					$hitting_percentage = sports_bench_get_hitting_percentage( (int) $player->ATTACKS, (int) $player->KILLS, (int) $player->HIT_ERRORS );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $hitting_percentage,
				];
				array_push( $the_players, $the_player );
			}

			if ( ! empty( $the_players ) ) {
				foreach ( $the_players as $key => $row ) {
					$average[ $key ] = $row['stat'];
				}
				array_multisort( $average, SORT_DESC, $the_players );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		} else {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_$stat ) AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY STAT DESC
				LIMIT %d;",
				$season,
				$limit
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->STAT,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'first' );
		}
		return $html;
	}

	/**
	 * Returns more stat leaders for a give stat.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat        The stat to look for.
	 * @param string $season      The season to look for the stat in.
	 * @param int    $offset      The number of players to ignore first to avoid duplicates.
	 * @return string             Table of players for that stat.
	 */
	public function get_more_stats_leaders( $stat, $season, $offset = 0 ) {
		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		/**
		 * Determines how many players to get for the stat.
		 *
		 * @since 2.0.0
		 *
		 * @param int $num_players      The default number of players to get.
		 * @return int                  The number of players to get.
		 */
		$limit            = apply_filters( 'sports_bench_stat_leader_limit', 10 );
		if ( 'batting_average' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_at_bats ) AS AB, SUM( g.game_player_hits ) AS HITS
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->AB ) {
					$batting_average = '.000';
				} else {
					$batting_average = sports_bench_get_batting_average( (int) $player->AB, (int) $player->HITS );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $batting_average,
				];
				array_push( $the_players, $the_player );
			}

			foreach ( $the_players as $key => $row ) {
				$average[ $key ] = $row['stat'];
			}
			array_multisort( $average, SORT_DESC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat );
		} elseif ( 'wins' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, COUNT( g.game_player_decision ) AS WINS, SUM( g.game_player_innings_pitched ) as IP
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE g.game_player_decision = 'W' AND game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->IP ) {
					continue;
				} else {
					$wins = $player->WINS;
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $wins,
				];
				array_push( $the_players, $the_player );
			}

			$wins = [];
			foreach ( $the_players as $key => $row ) {
				$wins[ $key ] = $row['stat'];
			}
			array_multisort( $wins, SORT_DESC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'saves' === $stat ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, COUNT( g.game_player_decision ) AS SAVES, SUM( g.game_player_innings_pitched ) as IP
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE g.game_player_decision = 'S' AND game.game_season = %s
					GROUP BY g.game_player_id, game.game_season",
					$season
				);
				$players     = Database::get_results( $querystr );
				$html        = '';
				$the_players = [];
				foreach ( $players as $player ) {
					if ( 0 === $player->IP ) {
						continue;
					} else {
						$saves = $player->SAVES;
					}
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => $saves,
					];
					array_push( $the_players, $the_player );
				}

				$saves = [];
				foreach ( $the_players as $key => $row ) {
					$saves[ $key ] = $row['stat'];
				}
				array_multisort( $saves, SORT_DESC, $the_players );

				if ( 0 !== $offset ) {
					$the_players = array_splice( $the_players, $offset - 1 );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_$stat ) AS STAT
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT DESC
					LIMIT %d
					OFFSET %d;",
					$season,
					$limit,
					$offset
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => $player->STAT,
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

			}
		} elseif ( 'era' === $stat ) {
			$querystr         = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_innings_pitched ) AS IP, SUM( g.game_player_earned_runs ) AS ER
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players          = Database::get_results( $querystr );
			$html             = '';
			$the_players      = [];
			$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );

			foreach ( $players as $player ) {
				if ( 0 === $player->IP ) {
					continue;
				} else {
					$batting_average = sports_bench_get_ERA( (int) $player->ER, (int) $player->IP, $innings_per_game );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $batting_average,
				];
				array_push( $the_players, $the_player );
			}

			foreach ( $the_players as $key => $row ) {
				$era[ $key ] = $row['stat'];
			}
			array_multisort( $era, SORT_ASC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'minutes' === $stat ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) AS MIN
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY MIN DESC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				if ( strlen( $player->MIN ) > 4 ) {
					$seconds = substr( $player->MIN, -2, 2 );
					$time    = substr_replace( $player->MIN, '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $player->MIN, -2, 2 );
					$minutes = substr_replace( $player->MIN, '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $time,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

		} elseif ( 'points_per_game' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_points ) AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY STAT ASC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->STAT,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'shooting_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_fgm ) AS FGM, SUM( g.game_player_fga ) AS FGA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->FGM ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->FGM, (int) $player->FGA, 9 );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$shooting_percentage = [];
			foreach ( $the_players as $key => $row ) {
				$shooting_percentage[ $key ] = $row['stat'];
			}
			array_multisort( $shooting_percentage, SORT_DESC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'ft_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_ftm ) AS FTM, SUM( g.game_player_fta ) AS FTA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->FGM ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->FTM, (int) $player->FTA );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$ft_percent = [];
			foreach ( $the_players as $key => $row ) {
				$ft_percent[ $key ] = $row['stat'];
			}
			array_multisort( $ft_percent, SORT_DESC, $the_players );

			if ( $offset != 0 ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( '3p_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_3pm ) AS TPM, SUM( g.game_player_3pa ) AS TPA
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season;",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( 0 === $player->TPA ) {
					$shooting_average = '0';
				} else {
					$shooting_average = sports_bench_get_shooting_average( (int) $player->TPA, (int) $player->TPM );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $shooting_average,
				];
				array_push( $the_players, $the_player );
			}

			$tp_percentage = [];
			foreach ( $the_players as $key => $row ) {
				$tp_percentage[ $key ] = $row['stat'];
			}
			array_multisort( $tp_percentage, SORT_DESC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'rebounds' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_off_rebound ) + SUM( g.game_player_def_rebound ) ) AS TOTAL
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY TOTAL ASC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->TOTAL,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( 'comp_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_completions ) / SUM( g.game_player_attempts ) ) AS COMP_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_attempts > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY COMP_PERC ASC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->COMP_PERC * 100, 1, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

		} elseif ( 'fg_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_fgm ) / SUM( g.game_player_fga ) ) AS FG_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_fga > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY FG_PERC DESC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->FG_PERC * 100, 1, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

		} elseif ( 'xp_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_xpm ) / SUM( g.game_player_xpa ) ) AS XP_PERC
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s AND g.game_player_xpa > 0
				GROUP BY g.game_player_id, game.game_season
				ORDER BY XP_PERC DESC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => number_format( (float) $player->XP_PERC * 100, 1, '.', '' ),
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

		} elseif ( 'points' === $stat ) {
			if ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, ( SUM( g.game_player_goals ) + SUM( g.game_player_assists ) ) AS POINTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY POINTS DESC
					LIMIT %d
					OFFSET %d;",
					$season,
					$limit,
					$offset
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_points ) AS POINTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY POINTS ASC
					LIMIT %d
					OFFSET %d;",
					$season,
					$limit,
					$offset
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
			}
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->STAT,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} elseif ( $stat == 'time_on_ice' ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_time_on_ice ) AS MIN
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY MIN DESC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players  = Database::get_results( $querystr );
			$html     = '';

			$the_players = [];
			foreach ( $players as $player ) {
				if ( strlen( $player->MIN ) > 4 ) {
					$seconds = substr( $player->MIN, -2, 2 );
					$time    = substr_replace( $player->MIN, '', -2, 2 );
					$minutes = substr( $time, -2, 2 );
					$time    = substr_replace( $time, '', -2, 2 );
					$times   = array( $time, $minutes, $seconds );
					$time    = implode( ':', $times );
				} else {
					$seconds = substr( $player->MIN, -2, 2 );
					$minutes = substr_replace( $player->MIN, '', -2, 2 );
					$times   = array( $minutes, $seconds );
					$time    = implode( ':', $times );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $time,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

		} elseif ( 'goals_against_average' === $stat ) {
			if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_goals_allowed ) AS STAT, SUM( g.game_player_shots_faced ) AS SHOTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s AND ( p.player_position LIKE 'Goalie' or p.player_position LIKE 'Goalkeeper' or p.player_position LIKE 'Keeper' )
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT ASC
					LIMIT %d
					OFFSET %d;",
					$season,
					$limit,
					$offset
				);
				$players     = Database::get_results( $querystr );
				$html        = '';
				$the_players = [];

				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => number_format( (float) $player->STAT, 2, '.', '' )
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
			} else {
				$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, AVG( g.game_player_goals_allowed ) AS STAT, SUM( g.game_player_saves ) AS SHOTS
					FROM $player_table as p LEFT JOIN $game_stats_table as g
					ON p.player_id = g.game_player_id
					LEFT JOIN $game_table as game
					ON game.game_id = g.game_id
					WHERE  game.game_season = %s
					GROUP BY g.game_player_id, game.game_season
					ORDER BY STAT DESC
					LIMIT %d
					OFFSET %d;",
					$season,
					$limit,
					$offset
				);
				$players  = Database::get_results( $querystr );
				$html     = '';
				$the_players = [];

				foreach ( $players as $player ) {
					$the_player = [
						'player_id' => $player->player_id,
						'stat'      => number_format( (float) $player->STAT, 2, '.', '' )
					];
					array_push( $the_players, $the_player );
				}

				/**
				 * Creates the table for the stats leaders.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html            The current HTML for the table.
				 * @param array $the_players      The list of players for the table.
				 * @param string $stat            The stat the table is for.
				 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
				 * @return string                 HTML for the stat table.
				 */
				$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );

			}
		} elseif ( 'hitting_percentage' === $stat ) {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_attacks ) AS ATTACKS, SUM( g.game_player_kills ) AS KILLS, SUM( g.game_player_hitting_errors ) AS HIT_ERRORS
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season",
				$season
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];
			foreach ( $players as $player ) {
				if ( $player->ATTACKS == 0 ) {
					$hitting_percentage = '.000';
				} else {
					$hitting_percentage = sports_bench_get_hitting_percentage( (int) $player->ATTACKS, (int) $player->KILLS, (int) $player->HIT_ERRORS );
				}
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $hitting_percentage,
				];
				array_push( $the_players, $the_player );
			}

			foreach ( $the_players as $key => $row ) {
				$average[ $key ] = $row['stat'];
			}
			array_multisort( $average, SORT_DESC, $the_players );

			if ( 0 !== $offset ) {
				$the_players = array_splice( $the_players, $offset - 1 );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		} else {
			$querystr    = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_$stat ) AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE  game.game_season = %s
				GROUP BY g.game_player_id, game.game_season
				ORDER BY STAT DESC
				LIMIT %d
				OFFSET %d;",
				$season,
				$limit,
				$offset
			);
			$players     = Database::get_results( $querystr );
			$html        = '';
			$the_players = [];

			foreach ( $players as $player ) {
				$the_player = [
					'player_id' => $player->player_id,
					'stat'      => $player->STAT,
				];
				array_push( $the_players, $the_player );
			}

			/**
			 * Creates the table for the stats leaders.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the table.
			 * @param array $the_players      The list of players for the table.
			 * @param string $stat            The stat the table is for.
			 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
			 * @return string                 HTML for the stat table.
			 */
			$html .= apply_filters( 'sports_bench_stat_leader_table', $html, $the_players, $stat, 'more' );
		}
		return $html;
	}

	/**
	 * Gets the title for a given stat slug.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat      The slug for a given stat.
	 * @return string           The title for the stat.
	 */
	public function get_stat_title( $stat ) {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'at_bats'               => esc_html__( 'At Bats', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'batting_average'       => esc_html__( 'Batting Average', 'sports-bench' ),
				'runs'                  => esc_html__( 'Runs', 'sports-bench' ),
				'rbis'                  => esc_html__( 'RBI', 'sports-bench' ),
				'doubles'               => esc_html__( 'Doubles', 'sports-bench' ),
				'triples'               => esc_html__( 'Triples', 'sports-bench' ),
				'homeruns'              => esc_html__( 'Home Runs', 'sports-bench' ),
				'strikeouts'            => esc_html__( 'Strikeouts', 'sports-bench' ),
				'walks'                 => esc_html__( 'Walks', 'sports-bench' ),
				'hit_by_pitch'          => esc_html__( 'Hit By Pitch', 'sports-bench' ),
				'wins'                  => esc_html__( 'Wins', 'sports-bench' ),
				'saves'                 => esc_html__( 'Saves', 'sports-bench' ),
				'innings_pitched'       => esc_html__( 'Innings Pitched', 'sports-bench' ),
				'pitcher_strikeouts'    => esc_html__( 'Pitcher Strikeouts', 'sports-bench' ),
				'pitcher_walks'         => esc_html__( 'Pitcher Walks', 'sports-bench' ),
				'hit_batters'           => esc_html__( 'Hit Batters', 'sports-bench' ),
				'runs_allowed'          => esc_html__( 'Runs Allowed', 'sports-bench' ),
				'earned_runs'           => esc_html__( 'Earned Runs', 'sports-bench' ),
				'era'                   => esc_html__( 'ERA', 'sports-bench' ),
				'hits_allowed'          => esc_html__( 'Hits Allowed', 'sports-bench' ),
				'homeruns_allowed'      => esc_html__( 'Home Runs Allowed', 'sports-bench' ),
				'pitch_count'           => esc_html__( 'Pitch Count', 'sports-bench' ),
			);
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'started'               => esc_html__( 'Starts', 'sports-bench' ),
				'minutes'               => esc_html__( 'Minutes', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'points_per_game'       => esc_html__( 'Points Per Game', 'sports-bench' ),
				'shooting_percentage'   => esc_html__( 'Shooting Percentage', 'sports-bench' ),
				'ft_percentage'         => esc_html__( 'Free Throw Percentage', 'sports-bench' ),
				'3p_percentage'         => esc_html__( '3-Point Percentage', 'sports-bench' ),
				'off_rebound'           => esc_html__( 'Offensive Rebounds', 'sports-bench' ),
				'def_rebound'           => esc_html__( 'Defensive Rebounds', 'sports-bench' ),
				'rebounds'              => esc_html__( 'Total Rebounds', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'steals'                => esc_html__( 'Steals', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'to'                    => esc_html__( 'Turnovers', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
			);
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'completions'       => esc_html__( 'Completions', 'sports-bench' ),
				'attempts'          => esc_html__( 'Attempts', 'sports-bench' ),
				'comp_percentage'   => esc_html__( 'Completion Percentage', 'sports-bench' ),
				'pass_yards'        => esc_html__( 'Passing Yards', 'sports-bench' ),
				'pass_tds'          => esc_html__( 'Passing Touchdowns', 'sports-bench' ),
				'pass_ints'         => esc_html__( 'Interceptions', 'sports-bench' ),
				'rushes'            => esc_html__( 'Rushes', 'sports-bench' ),
				'rush_yards'        => esc_html__( 'Rushing Yards', 'sports-bench' ),
				'rush_tds'          => esc_html__( 'Rushing Touchdowns', 'sports-bench' ),
				'rush_fumbles'      => esc_html__( 'Rushing Fumbles', 'sports-bench' ),
				'catches'           => esc_html__( 'Catches', 'sports-bench' ),
				'receiving_yards'   => esc_html__( 'Receiving Yards', 'sports-bench' ),
				'receiving_tds'     => esc_html__( 'Receiving Touchdowns', 'sports-bench' ),
				'receiving_fumbles' => esc_html__( 'Receiving Fumbles', 'sports-bench' ),
				'tackles'           => esc_html__( 'Tackles', 'sports-bench' ),
				'tfl'               => esc_html__( 'Tackles For Loss', 'sports-bench' ),
				'sacks'             => esc_html__( 'Sacks', 'sports-bench' ),
				'pbu'               => esc_html__( 'Pass Breakups', 'sports-bench' ),
				'ints'              => esc_html__( 'Interceptions', 'sports-bench' ),
				'tds'               => esc_html__( 'Defensive Touchdowns', 'sports-bench' ),
				'ff'                => esc_html__( 'Forced Fumbles', 'sports-bench' ),
				'fr'                => esc_html__( 'Fumbles Recovered', 'sports-bench' ),
				'blocked'           => esc_html__( 'Blocked Kicks', 'sports-bench' ),
				'yards'             => esc_html__( 'Defensive Return Yards', 'sports-bench' ),
				'fgm'               => esc_html__( 'Made Field Goals', 'sports-bench' ),
				'fg_percentage'     => esc_html__( 'Field Goal Percentage', 'sports-bench' ),
				'xpm'               => esc_html__( 'Made Extra Points', 'sports-bench' ),
				'xp_percentage'     => esc_html__( 'Extra Point Percentage', 'sports-bench' ),
				'touchbacks'        => esc_html__( 'Touchbacks', 'sports-bench' ),
				'returns'           => esc_html__( 'Returns', 'sports-bench' ),
				'return_yards'      => esc_html__( 'Return Yards', 'sports-bench' ),
				'return_tds'        => esc_html__( 'Return Touchdowns', 'sports-bench' ),
				'return_fumbles'    => esc_html__( 'Return Fumbles', 'sports-bench' )
			);
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'penalties'             => esc_html__( 'Penalties', 'sports-bench' ),
				'pen_minutes'           => esc_html__( 'Penalty Minutes', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'shifts'                => esc_html__( 'Shifts', 'sports-bench' ),
				'time_on_ice'           => esc_html__( 'Time on Ice', 'sports-bench' ),
				'faceoffs'              => esc_html__( 'Faceoffs', 'sports-bench' ),
				'faceoff_wins'          => esc_html__( 'Faceoff Wins', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'saves'                 => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			);
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'tries'                 => esc_html__( 'Tries', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'conversions'           => esc_html__( 'Conversions', 'sports-bench' ),
				'penalty_goals'         => esc_html__( 'Penalty Goals', 'sports-bench' ),
				'drop_kicks'            => esc_html__( 'Drop Kicks', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'penalties_conceeded'   => esc_html__( 'Penalties Conceded', 'sports-bench' ),
				'meters_run'            => esc_html__( 'Meters Run', 'sports-bench' ),
				'red_cards'             => esc_html__( 'Red Cards', 'sports-bench' ),
				'yellow_cards'          => esc_html__( 'Yellow Cards', 'sports-bench' ),
			);
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'shots'                 => esc_html__( 'Shots', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'fouls_suffered'        => esc_html__( 'Fouls Suffered', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'shots_saved'           => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			);
		} else {
			$stats_items = array(
				'sets_played'           => esc_html__( 'Sets Played', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'kills'                 => esc_html__( 'Kills', 'sports-bench' ),
				'hitting_errors'        => esc_html__( 'Hitting Errors', 'sports-bench' ),
				'attacks'               => esc_html__( 'Attacks', 'sports-bench' ),
				'hitting_percentage'    => esc_html__( 'Hitting Percentage', 'sports-bench' ),
				'set_attempts'          => esc_html__( 'Set Attempts', 'sports-bench' ),
				'set_errors'            => esc_html__( 'Setting Errors', 'sports-bench' ),
				'serves'                => esc_html__( 'Serves', 'sports-bench' ),
				'serve_errors'          => esc_html__( 'Serving Errors', 'sports-bench' ),
				'aces'                  => esc_html__( 'Aces', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'block_attempts'        => esc_html__( 'Block Attempts', 'sports-bench' ),
				'block_errors'          => esc_html__( 'Blocking Errors', 'sports-bench' ),
				'digs'                  => esc_html__( 'Digs', 'sports-bench' ),
				'receiving_errors'      => esc_html__( 'Receiving Erros', 'sports-bench' ),
			);
		}
		foreach ( $stats_items as $key => $label ) {
			if ( $key === $stat ) {
				return $label;
			}
		}
		return '';
	}

	/**
	 * Takes a selected stat and sends a table of more stat leaders to the JavaScript for the page.
	 *
	 * @since 2.0.0
	 */
	public function sports_bench_statistics() {
		check_ajax_referer( 'sports-bench-statistics', 'nonce' );
		$stat   = wp_filter_nohtml_kses( $_POST['stat'] );
		$offset = wp_filter_nohtml_kses( $_POST['offset'] );
		$season = get_option( 'sports-bench-season-year' );

		$data = $this->get_more_stats_leaders( $stat, $season, $offset );

		wp_send_json_success( $data );
		wp_die();
	}

	/**
	 * Creates the table for the stats leaders.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html            The current HTML for the table.
	 * @param array $the_players      The list of players for the table.
	 * @param string $stat            The stat the table is for.
	 * @param string $type            Whether this is the first set of players or a list to be added to a current table.
	 * @return string                 HTML for the stat table.
	 */
	public function sports_bench_do_stat_leader_table( $html, $stats, $stat, $type ) {

		/**
		 * Determines how many players to get for the stat.
		 *
		 * @since 2.0.0
		 *
		 * @param int $num_players      The default number of players to get.
		 * @return int                  The number of players to get.
		 */
		$limit = apply_filters( 'sports_bench_stat_leader_limit', 10 );
		if ( 'first' === $type ) {
			$html .= '<table id="' . $stat . '" class="stat-table">';
			$html .= '<thead>';

			/**
			 * Outputs the styles for the table's header row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The current styles for the row.
			 * @param string $stat        The stat the table is for.
			 * @return string             The styles for the table header row.
			 */
			$table_head_style = apply_filters( 'sports_bench_stats_head_row', '', $stat );

			$html .= '<tr style="' . $table_head_style . '">';
			$html .= '<th class="left"><span class="screen-reader-text">' . esc_html__( 'Team', 'sports-bench' ) . '</span></th>';
			$html .= '<th class="left"><span class="screen-reader-text">' . esc_html__( 'Player', 'sports-bench' ) . '</span></th>';
			$html .= '<th class="left"><span class="screen-reader-text">' . $this->get_stat_title( $stat ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$count = 1;
			foreach ( $stats as $player ) {
				$the_player = new Player( (int) $player['player_id'] );
				$team       = new Team( (int) $the_player->get_team_id() );

				/**
				 * Outputs the styles for the player's stat row.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The current styles for the row.
				 * @param Player $player      The player object for the row.
				 * @param Team   $team        The team object for the row.
				 * @param string $stat        The stat the table is for.
				 * @return string             The styles for the player's stat row.
				 */
				$table_row_style = apply_filters( 'sports_bench_stats_player_row', '', $player, $team, $stat );

				$html .= '<tr style="' . $table_row_style . '">';
				$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . '</td>';
				$html .= '<td><a href="' . $the_player->get_permalink() . ' ">' . $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() . '</a></td>';
				$html .= '<td class="center">' . $player['stat'] . '</td>';
				$html .= '</tr>';
				if ( $count === $limit ) {
					break;
				}
				$count++;
			}
			$html .= '</tbody>';
			$html .= '</table>';
			$html .= '<a class="button black stat-button">' . esc_html__( 'Load More', 'sports-bench' ) . '</a>';
		} else {
			$count = 1;
			foreach ( $stats as $player ) {
				$the_player = new Player( (int) $player['player_id'] );
				$team       = new Team( (int) $the_player->get_team_id() );

				/**
				 * Outputs the styles for the player's stat row.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The current styles for the row.
				 * @param Player $player      The player object for the row.
				 * @param Team   $team        The team object for the row.
				 * @param string $stat        The stat the table is for.
				 * @return string             The styles for the player's stat row.
				 */
				$table_row_style = apply_filters( 'sports_bench_stats_player_row', '', $player, $team, $stat );

				$html .= '<tr style="' . $table_row_style . '">';
				$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . '</td>';
				$html .= '<td><a href="' . $the_player->get_permalink() . ' ">' . $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() . '</a></td>';
				$html .= '<td class="center">' . $player['stat'] . '</td>';
				$html .= '</tr>';
				if ( $count === $limit ) {
					break;
				}
				$count++;
			}
		}

		return $html;
	}

	/**
	 * Takes the inputs from the stat search filters and outputs a table to match those filters.
	 *
	 * @since 2.0.0
	*/
	public function search_stats() {
		check_ajax_referer( 'sports-bench-search-stats', 'nonce' );
		$first_name = wp_filter_nohtml_kses( $_POST['player_first_name'] );
		$last_name  = wp_filter_nohtml_kses( $_POST['player_last_name'] );
		$stat       = wp_filter_nohtml_kses( $_POST['stat'] );
		$stat_type  = wp_filter_nohtml_kses( $_POST['stat_type'] );
		$stat_total = wp_filter_nohtml_kses( $_POST['stat_total'] );
		$compare    = wp_filter_nohtml_kses( $_POST['compare'] );
		$offset     = wp_filter_nohtml_kses( $_POST['offset'] );
		$team_id    = wp_filter_nohtml_kses( $_POST['team'] );
		$season     = wp_filter_nohtml_kses( $_POST['season'] );

		/**
		 * Determines how many players to get for the stat.
		 *
		 * @since 2.0.0
		 *
		 * @param int $num_players      The default number of players to get.
		 * @return int                  The number of players to get.
		 */
		$limit      = apply_filters( 'sports_bench_stat_search_limit', 10 );
		$data       = '';

		if ( '' !== $first_name ) {
			$first_name_sql = "p.player_first_name = '$first_name'";
		} else {
			$first_name_sql = '';
		}
		if ( '' !== $last_name ) {
			$last_name_sql = "p.player_last_name = '$last_name'";
		} else {
			$last_name_sql = '';
		}
		if ( '' !== $first_name_sql || '' !== $last_name_sql ) {
			if ( '' !== $first_name_sql && '' !== $last_name_sql ) {
				$comparison = ' AND ';
			} else {
				$comparison = '';
			}
		}

		if ( '' !== $compare ) {
			$stat_compare = 'HAVING STAT ' . $compare . ' ' . $stat_total;
		} else {
			$stat_compare = '';
		}

		$stat_query = $this->search_stat( $stat );
		$direction  = $this->search_stat_direction( $stat );
		$where      = $this->search_stat_limit( $stat );

		if ( 0 < $team_id ) {
			$team = "( game.game_home_id = $team_id OR game.game_away_id = $team_id ) AND g.game_team_id = $team_id";
			if ( '' !== $where ) {
				$team_compare = ' AND ';
			} else {
				$team_compare = 'WHERE ';
			}
		} else {
			$team         = '';
			$team_compare = '';
		}

		if ( '' !== $season ) {
			$season = "game.game_season LIKE '$season'";
			if (  '' !== $where || 0 < $team_id ) {
				$season_compare = ' AND ';
			} else {
				$season_compare = 'WHERE ';
			}
		} else {
			$season         = '';
			$season_compare = '';
		}

		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		if ( 'single-game' === $stat_type ) {
			$group = 'GROUP BY g.game_player_id, g.game_id';
		} elseif ( 'season' === $stat_type ) {
			$group = 'GROUP BY g.game_player_id, game.game_season';
		} else {
			$group = 'GROUP BY g.game_player_id';
		}
		if ( $offset > 0 ) {
			$offset = "OFFSET $offset";
		} else {
			$offset = '';
		}
		if ( '' !== $first_name_sql || '' !== $last_name_sql ) {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, $stat_query AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				WHERE $first_name_sql $comparison $last_name_sql
				GROUP BY g.game_player_id
				ORDER BY STAT $direction
				LIMIT %d
				$offset;",
				$limit
			);
		} else {
			$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.player_position, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, $stat_query AS STAT
				FROM $player_table as p LEFT JOIN $game_stats_table as g
				ON p.player_id = g.game_player_id
				LEFT JOIN $game_table as game
				ON game.game_id = g.game_id
				$where $team_compare $team $season_compare $season
				$group
				$stat_compare
				ORDER BY STAT $direction
				LIMIT %d
				$offset;",
				$limit
			);
		}
		$players = Database::get_results( $querystr );

		if ( $players ) {
			if ( '' !== $offset ) {
				foreach ( $players as $player ) {

					/**
					 * Outputs the stat search table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $html           The current HTML for the table.
					 * @param array  $player         The array for the current player.
					 * @param string $stat_type      The type of stat being searched.
					 * @return string                The table for the stat search.
					 */
					$data .= apply_filters( 'sports_bench_stat_search_table', '', $player, $stat_type );
				}
			} else {
				$data .= '<table class="sports-bench-search-results">';
				foreach ( $players as $player ) {

					/**
					 * Outputs the stat search table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $html           The current HTML for the table.
					 * @param array  $player         The array for the current player.
					 * @param string $stat_type      The type of stat being searched.
					 * @return string                The table for the stat search.
					 */
					$data .= apply_filters( 'sports_bench_stat_search_table', '', $player, $stat_type );
				}
				$data .= '</table>';

				if ( 10 <= count( $players ) ) {
					$data .= '<button id="sports-bench-search-results-load" class="off-black"><i class="fal fa-arrow-down" aria-hidden="true"></i> ' . esc_html__( 'Load More', 'sports-bench' ) . '</button>';
				}
			}
		}
		wp_send_json_success( $data );
		wp_die();
	}

	/**
	 * Creates the SQL for the column to search for in the stat search.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat      The stat being searched for.
	 * @return string           The SQL to search for the stat.
	 */
	public function search_stat( $stat ) {
		if ( 'batting_average' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_hits ) / SUM( g.game_player_at_bats ), 3 )";
		} elseif ( 'era' === $stat ) {
			$innings_per_game = apply_filters( 'sports_bench_baseball_innings_per_game', 9 );
			$stat_query       = "ROUND( ( $innings_per_game * SUM( g.game_player_earned_runs ) ) / SUM( g.game_player_innings_pitched ), 2 )";
		} elseif ( 'minutes' === $stat ) {
			$stat_query = "SEC_TO_TIME( SUM( TIME_TO_SEC( g.game_player_minutes ) ) )";
		} elseif ( 'points_per_game' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_points ) / COUNT( g.game_player_minutes ), 1 )";
		} elseif ( 'shooting_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_fgm ) / SUM( g.game_player_fga ) * 100, 1 )";
		} elseif ( 'ft_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_ftm ) / SUM( g.game_player_fta ) * 100, 1 )";
		} elseif ( '3p_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_3pm ) / SUM( g.game_player_3pa ) * 100, 1 )";
		} elseif ( 'comp_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_completions  ) / SUM( g.game_player_attempts ) * 100, 1 )";
		} elseif ( 'fg_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_fgm ) / SUM( g.game_player_fga ) * 100, 1 )";
		} elseif ( 'xp_percentage' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_xpm ) / SUM( g.game_player_xpa ) * 100, 1 )";
		} elseif ( 'time_on_ice' === $stat ) {
			$stat_query = "SEC_TO_TIME( SUM( TIME_TO_SEC( g.game_player_time_on_ice ) ) )";
		} elseif ( 'goals_against_average' === $stat ) {
			$stat_query = "ROUND( SUM( g.game_player_goals_allowed) / COUNT( game.game_id ), 3 )";
		} elseif ( 'hitting_percentage' === $stat ) {
			$stat_query = "ROUND( ( SUM( g.game_player_kills ) - SUM( g.game_player_hitting_errors ) ) / SUM( g.game_player_attacks ), 3 )";
		} else {
			$stat_query = "SUM( g.game_player_$stat )";
		}

		return $stat_query;
	}

	/**
	 * Determines the direction the stat search needs to go for a given stat.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat      The stat being searched for.
	 * @return string           The SQL direction for the stat search.
	 */
	public function search_stat_direction( $stat ) {
		if ( 'strikeouts' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'pitcher_walks' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'hit_batters' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'runs_allowed' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'earned_runs' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'era' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'hits_allowed' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'homeruns_allowed' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'era' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'pass_ints' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'rush_fumbles' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'receiving_fumbles' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'return_fumbles' === $stat ) {
			$direction = 'ASC';
		} elseif ( 'goals_against_average' === $stat ) {
			$direction = 'ASC';
		} else {
			$direction = 'DESC';
		}

		return $direction;
	}

	/**
	 * Creates an SQL limit to only search for players eligible for the given stat.
	 *
	 * @since 2.0.0
	 *
	 * @param string $stat      The stat being searched for.
	 * @return string           The SQL for limiting to search for players with that stat.
	 */
	public function search_stat_limit( $stat ) {
		if ( 'strikeouts' === $stat ) {
			$where = 'WHERE g.game_player_at_bats > 0';
		} elseif( 'pitcher_walks' === $stat || 'hit_batters' === $stat || 'runs_allowed' === $stat || 'earned_runs' === $stat || 'era' === $stat || 'hits_allowed' === $stat || 'homeruns_allowed' === $stat || 'era' === $stat ) {
			$where = 'WHERE g.game_player_innings_pitched > 0';
		} elseif ( 'shooting_percentage' === $stat ) {
			$where = 'WHERE g.game_player_fga > 0';
		} elseif ( 'ft_percentage' === $stat ) {
			$where = 'WHERE g.game_player_fta > 0';
		} elseif ( '3p_percentage' === $stat ) {
			$where = 'WHERE g.game_player_3pa > 0';
		} elseif ( 'comp_percentage' === $stat ) {
			$where = 'WHERE g.game_player_attempts > 0';
		} elseif ( 'fg_percentage' === $stat ) {
			$where = 'WHERE g.game_player_fga > 0';
		} elseif ( 'xp_percentage' === $stat ) {
			$where = 'WHERE g.game_player_xpa > 0';
		} elseif ( 'goals_allowed' === $stat ) {
			$where = 'WHERE g.game_player_shots_faced > 0';
		} elseif ( 'goals_against_average' === $stat ) {
			$where = 'WHERE g.game_player_shots_faced > 0';
		} elseif ( 'hitting_percentage' === $stat ) {
			$where = 'WHERE g.game_player_attacks > 0';
		} else {
			$where = '';
		}

		return $where;
	}

	/**
	 * Outputs the stat search table.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The current HTML for the table.
	 * @param array  $player         The array for the current player.
	 * @param string $stat_type      The type of stat being searched.
	 * @return string                The table for the stat search.
	 */
	public function sports_bench_do_stat_search_table( $html, $player, $stat_type ) {
		$the_player = new Player( (int) $player->player_id );
		$team       = new Team( (int) $the_player->get_team_id() );

		/**
		 * Outputs the styles for the player's stat row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles          The current styles for the row.
		 * @param Player $the_player      The player object for the row.
		 * @param Team   $team            The team object for the row.
		 * @return string                 The styles for the player's stat row.
		 */
		$row_styles = apply_filters( 'sports_bench_search_results_row', '', $the_player, $team );

		if ( 'single-game' === $stat_type ) {
			$game = new Game( $player->game_id );
			if ( $game->get_game_away_id() === $the_player->get_team_id() ) {
				$location = esc_html__( 'at', 'sports-bench' );
				$opponent = new Team( (int) $game->get_game_home_id() );
			} else {
				$location = esc_html__( 'vs', 'sports-bench' );
				$opponent = new Team( (int) $game->get_game_away_id() );
			}
			$date = $game->get_game_day( get_option( 'date_format' ) );
			if ( '' !== $game->get_game_recap() ) {
				$middle_column = '<a href="' . $game->get_game_recap() . '">' . $location . ' ' . $opponent->get_team_name() . ', ' . $date . '</a>';
			} else {
				$middle_column = $location . ' ' . $opponent->get_team_name() . ', ' . $date;
			}
		} elseif ( 'season' === $stat_type ) {
			$middle_column = $player->game_season;
		} else {
			$middle_column = '';
		}

		$html .= '<tr style="' . $row_styles . '">';
		$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . '</td>';
		$html .= '<td><a href="' . $the_player->get_permalink() . '">' . $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() . '</a></td>';
		$html .= '<td>' . $middle_column . '</td>';
		$html .= '<td>' . $player->STAT . '</td>';
		$html .= '</tr>';

		return $html;
	}

	/**
	 * Outputs the stat search page.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the stat search page.
	 */
	public function stat_search_page() {
		$html = '';

		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'at_bats'               => esc_html__( 'At Bats', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'batting_average'       => esc_html__( 'Batting Average', 'sports-bench' ),
				'runs'                  => esc_html__( 'Runs', 'sports-bench' ),
				'rbis'                  => esc_html__( 'RBI', 'sports-bench' ),
				'doubles'               => esc_html__( 'Doubles', 'sports-bench' ),
				'triples'               => esc_html__( 'Triples', 'sports-bench' ),
				'homeruns'              => esc_html__( 'Home Runs', 'sports-bench' ),
				'strikeouts'            => esc_html__( 'Strikeouts', 'sports-bench' ),
				'walks'                 => esc_html__( 'Walks', 'sports-bench' ),
				'hit_by_pitch'          => esc_html__( 'Hit By Pitch', 'sports-bench' ),
				'wins'                  => esc_html__( 'Wins', 'sports-bench' ),
				'saves'                 => esc_html__( 'Saves', 'sports-bench' ),
				'innings_pitched'       => esc_html__( 'Innings Pitched', 'sports-bench' ),
				'pitcher_strikeouts'    => esc_html__( 'Pitcher Strikeouts', 'sports-bench' ),
				'pitcher_walks'         => esc_html__( 'Pitcher Walks', 'sports-bench' ),
				'hit_batters'           => esc_html__( 'Hit Batters', 'sports-bench' ),
				'runs_allowed'          => esc_html__( 'Runs Allowed', 'sports-bench' ),
				'earned_runs'           => esc_html__( 'Earned Runs', 'sports-bench' ),
				'era'                   => esc_html__( 'ERA', 'sports-bench' ),
				'hits_allowed'          => esc_html__( 'Hits Allowed', 'sports-bench' ),
				'homeruns_allowed'      => esc_html__( 'Home Runs Allowed', 'sports-bench' ),
				'pitch_count'           => esc_html__( 'Pitch Count', 'sports-bench' ),
			];
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'started'               => esc_html__( 'Starts', 'sports-bench' ),
				'minutes'               => esc_html__( 'Minutes', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'points_per_game'       => esc_html__( 'Points Per Game', 'sports-bench' ),
				'shooting_percentage'   => esc_html__( 'Shooting Percentage', 'sports-bench' ),
				'ft_percentage'         => esc_html__( 'Free Throw Percentage', 'sports-bench' ),
				'3p_percentage'         => esc_html__( '3-Point Percentage', 'sports-bench' ),
				'off_rebound'           => esc_html__( 'Offensive Rebounds', 'sports-bench' ),
				'def_rebound'           => esc_html__( 'Defensive Rebounds', 'sports-bench' ),
				'rebounds'              => esc_html__( 'Total Rebounds', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'steals'                => esc_html__( 'Steals', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'to'                    => esc_html__( 'Turnovers', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
			];
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'completions'       => esc_html__( 'Completions', 'sports-bench' ),
				'attempts'          => esc_html__( 'Attempts', 'sports-bench' ),
				'comp_percentage'   => esc_html__( 'Completion Percentage', 'sports-bench' ),
				'pass_yards'        => esc_html__( 'Passing Yards', 'sports-bench' ),
				'pass_tds'          => esc_html__( 'Passing Touchdowns', 'sports-bench' ),
				'pass_ints'         => esc_html__( 'Interceptions', 'sports-bench' ),
				'rushes'            => esc_html__( 'Rushes', 'sports-bench' ),
				'rush_yards'        => esc_html__( 'Rushing Yards', 'sports-bench' ),
				'rush_tds'          => esc_html__( 'Rushing Touchdowns', 'sports-bench' ),
				'rush_fumbles'      => esc_html__( 'Rushing Fumbles', 'sports-bench' ),
				'catches'           => esc_html__( 'Catches', 'sports-bench' ),
				'receiving_yards'   => esc_html__( 'Receiving Yards', 'sports-bench' ),
				'receiving_tds'     => esc_html__( 'Receiving Touchdowns', 'sports-bench' ),
				'receiving_fumbles' => esc_html__( 'Receiving Fumbles', 'sports-bench' ),
				'tackles'           => esc_html__( 'Tackles', 'sports-bench' ),
				'tfl'               => esc_html__( 'Tackles For Loss', 'sports-bench' ),
				'sacks'             => esc_html__( 'Sacks', 'sports-bench' ),
				'pbu'               => esc_html__( 'Pass Breakups', 'sports-bench' ),
				'ints'              => esc_html__( 'Interceptions', 'sports-bench' ),
				'tds'               => esc_html__( 'Defensive Touchdowns', 'sports-bench' ),
				'ff'                => esc_html__( 'Forced Fumbles', 'sports-bench' ),
				'fr'                => esc_html__( 'Fumbles Recovered', 'sports-bench' ),
				'blocked'           => esc_html__( 'Blocked Kicks', 'sports-bench' ),
				'yards'             => esc_html__( 'Defensive Return Yards', 'sports-bench' ),
				'fgm'               => esc_html__( 'Made Field Goals', 'sports-bench' ),
				'fg_percentage'     => esc_html__( 'Field Goal Percentage', 'sports-bench' ),
				'xpm'               => esc_html__( 'Made Extra Points', 'sports-bench' ),
				'xp_percentage'     => esc_html__( 'Extra Point Percentage', 'sports-bench' ),
				'touchbacks'        => esc_html__( 'Touchbacks', 'sports-bench' ),
				'returns'           => esc_html__( 'Returns', 'sports-bench' ),
				'return_yards'      => esc_html__( 'Return Yards', 'sports-bench' ),
				'return_tds'        => esc_html__( 'Return Touchdowns', 'sports-bench' ),
				'return_fumbles'    => esc_html__( 'Return Fumbles', 'sports-bench' )
			];
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'penalties'             => esc_html__( 'Penalties', 'sports-bench' ),
				'pen_minutes'           => esc_html__( 'Penalty Minutes', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'shifts'                => esc_html__( 'Shifts', 'sports-bench' ),
				'time_on_ice'           => esc_html__( 'Time on Ice', 'sports-bench' ),
				'faceoffs'              => esc_html__( 'Faceoffs', 'sports-bench' ),
				'faceoff_wins'          => esc_html__( 'Faceoff Wins', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'saves'                 => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			];
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'tries'                 => esc_html__( 'Tries', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'conversions'           => esc_html__( 'Conversions', 'sports-bench' ),
				'penalty_goals'         => esc_html__( 'Penalty Goals', 'sports-bench' ),
				'drop_kicks'            => esc_html__( 'Drop Kicks', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'penalties_conceeded'   => esc_html__( 'Penalties Conceded', 'sports-bench' ),
				'meters_run'            => esc_html__( 'Meters Run', 'sports-bench' ),
				'red_cards'             => esc_html__( 'Red Cards', 'sports-bench' ),
				'yellow_cards'          => esc_html__( 'Yellow Cards', 'sports-bench' ),
			];
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'shots'                 => esc_html__( 'Shots', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'fouls_suffered'        => esc_html__( 'Fouls Suffered', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'shots_saved'           => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			];
		} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
				'sets_played'           => esc_html__( 'Sets Played', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'kills'                 => esc_html__( 'Kills', 'sports-bench' ),
				'hitting_errors'        => esc_html__( 'Hitting Errors', 'sports-bench' ),
				'attacks'               => esc_html__( 'Attacks', 'sports-bench' ),
				'hitting_percentage'    => esc_html__( 'Hitting Percentage', 'sports-bench' ),
				'set_attempts'          => esc_html__( 'Set Attempts', 'sports-bench' ),
				'set_errors'            => esc_html__( 'Setting Errors', 'sports-bench' ),
				'serves'                => esc_html__( 'Serves', 'sports-bench' ),
				'serve_errors'          => esc_html__( 'Serving Errors', 'sports-bench' ),
				'aces'                  => esc_html__( 'Aces', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'block_attempts'        => esc_html__( 'Block Attempts', 'sports-bench' ),
				'block_errors'          => esc_html__( 'Blocking Errors', 'sports-bench' ),
				'digs'                  => esc_html__( 'Digs', 'sports-bench' ),
				'receiving_errors'      => esc_html__( 'Receiving Erros', 'sports-bench' ),
			];
		} else {
			$stats_items = [];
		}
		$teams   = sports_bench_get_teams( true, false );
		$seasons = sports_bench_get_seasons();

		$html .= '<form id="sports-bench-stat-search-form">';
		$html .= '<div class="sports-bench-search-filters">';
		$html .= '<div class="search-filter"><span class="screen-reader-text"><label for="sports-bench-player-first-name">' . esc_html__( 'First Name', 'sports-bench' ) . '</label></span><input type="text" id="sports-bench-player-first-name" name="sports-bench-player-first-name" placeholder="' . esc_html__( 'First Name', 'sports-bench' ) . '" /></div>';
		$html .= '<div class="search-filter"><span class="screen-reader-text"><label for="sports-bench-player-last-name">' . esc_html__( 'Last Name', 'sports-bench' ) . '</label></span><input type="text" id="sports-bench-player-last-name" name="sports-bench-player-last-name" placeholder="' . esc_html__( 'Last Name', 'sports-bench' ) . '" /></div>';
		$html .= '<div class="search-filter">';
		$html .= '<span class="screen-reader-text"><label for="sports-bench-stat">' . esc_html__( 'Stat', 'sports-bench' ) . '</label></span>';
		$html .= '<select id="sports-bench-stat" name="sports-bench-stat">';
		$html .= '<option value="">' . esc_html__( 'Stat', 'sports-bench' ) . '</option>';
		foreach ( $stats_items as $key => $label ) {
			$html .= '<option value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="search-filter">';
		$html .= '<span class="screen-reader-text"><label for="sports-bench-stat-type">' . esc_html__( 'Stat Type', 'sports-bench' ) . '</label></span>';
		$html .= '<select id="sports-bench-stat-type" name="sports-bench-stat-type">';
		$html .= '<option value="">' . esc_html__( 'Stat Type', 'sports-bench' ) . '</option>';
		$html .= '<option value="single-game">' . esc_html__( 'Single Game', 'sports-bench' ) . '</option>';
		$html .= '<option value="season">' . esc_html__( 'Season', 'sports-bench' ) . '</option>';
		$html .= '<option value="career">' . esc_html__( 'Career', 'sports-bench' ) . '</option>';
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="search-filter">';
		$html .= '<span class="screen-reader-text"><label for="sports-bench-stat-direction">' . esc_html__( 'Comparison', 'sports-bench' ) . '</label></span>';
		$html .= '<select id="sports-bench-stat-direction" name="sports-bench-stat-direction">';
		$html .= '<option value="">' . esc_html__( 'Comparison', 'sports-bench' ) . '</option>';
		$html .= '<option value="=">' . esc_html__( 'Equals', 'sports-bench' ) . '</option>';
		$html .= '<option value="<">' . esc_html__( 'Less Than', 'sports-bench' ) . '</option>';
		$html .= '<option value="<=">' . esc_html__( 'Less Than or Equal to', 'sports-bench' ) . '</option>';
		$html .= '<option value=">">' . esc_html__( 'Greater Than', 'sports-bench' ) . '</option>';
		$html .= '<option value=">=">' . esc_html__( 'Greater Than or Equal to', 'sports-bench' ) . '</option>';
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="search-filter"><span class="screen-reader-text"><label for="sports-bench-stat-total">' . esc_html__( 'Stat Total', 'sports-bench' ) . '</label></span><input type="text" id="sports-bench-stat-total" name="sports-bench-stat-total" placeholder="' . esc_html__( 'Stat Total', 'sports-bench' ) . '" /></div>';
		$html .= '<div class="search-filter">';
		$html .= '<span class="screen-reader-text"><label for="sports-bench-team">' . esc_html__( 'Team', 'sports-bench' ) . '</label></span>';
		$html .= '<select id="sports-bench-team" name="sports-bench-team">';
		$html .= '<option value="">' . esc_html__( 'Team', 'sports-bench' ) . '</option>';
		foreach ( $teams as $key => $label ) {
			$html .= '<option value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="search-filter">';
		$html .= '<span class="screen-reader-text"><label for="sports-bench-season">' . esc_html__( 'Season', 'sports-bench' ) . '</label></span>';
		$html .= '<select id="sports-bench-season" name="sports-bench-season">';
		$html .= '<option value="">' . esc_html__( 'Season', 'sports-bench' ) . '</option>';
		foreach ( $seasons as $season ) {
			$html .= '<option value="' . esc_attr( $season ) . '">' . esc_html( $season ) . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '<div class="search-filter"><input type="submit" id="sports-bench-stat-search" class="off-black" value="' . esc_html__( 'Search', 'sports-bench' ) . '" /></div>';
		$html .= '<div class="search-filter"><input type="reset" id="sports-bench-stat-clear" class="off-black" value="' . esc_html__( 'Clear', 'sports-bench' ) . '" /></div>';
		$html .= '</div>';
		$html .= '</form>';

		$html .= '<div class="sports-bench-results-row">';
		$html .= '<div id="sports-bench-results">';
		$html .= '<h2 class="sports-bench-result-title">' . esc_html__( 'Results', 'sports-bench' ) . '</h2>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

}
