<?php
/**
 * Creates the football games class.
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
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The football games class.
 *
 * This is used for football games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class FootballGames extends Games {

	/**
	 * Creates the new FootballGames object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version      The version of the plugin.
	 */
	public function __construct( $version ) {
		parent::__construct();
	}

	/**
	 * Creates the linescore table for the game.
	 *
	 * @since 2.0.0
	 *
	 * @param string     $html                 The incoming HTML for the table.
	 * @param Game       $game                 The game object.
	 * @param Team       $away_team            The team object for the away team.
	 * @param Team       $home_team            The team object for the home team.
	 * @param string     $sport                The sport the linescore is for.
	 * @param array      $game_info            The array of information for a game.
	 * @param array|null $linescore_array      The array for the linescore if it's football. It's null if not football.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		foreach ( $game_info as $info ) {
			$html  = '<table class="linescore">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th></th>';
			$html .= '<th></th>';
			$html .= '<th>1</th>';
			$html .= '<th>2</th>';
			$html .= '<th>3</th>';
			$html .= '<th>4</th>';
			if ( null !== $info->game_home_overtime ) {
				$html .= '<th>OT</th>';
			}
			$html .= '<th>F</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';

			/**
			 * Adds styles for the row of the linescore.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_linescore_row', '', $away_team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td class="top-team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_away_first_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_away_third_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_away_fourth_quarter . '</td>';
			if ( null !== $info->game_away_overtime ) {
				$html .= '<td class="score">' . $info->game_away_overtime . '</td>';
			}
			if ( 'in_progress' === $game->get_game_status() ) {
				$html .= '<td class="score">' . $game->get_game_current_away_score() . '</td>';
			} else {
				$html .= '<td class="score">' . $game->get_game_away_final() . '</td>';
			}
			$html .= '</tr>';

			/**
			 * Adds styles for the row of the linescore.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_linescore_row', '', $home_team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td class="top-team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_home_first_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_home_second_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_home_third_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_home_fourth_quarter . '</td>';
			if ( null !== $info->game_home_overtime ) {
				$html .= '<td class="score">' . $info->game_home_overtime . '</td>';
			}
			if ( 'in_progress' === $game->get_game_status() ) {
				$html .= '<td class="score">' . $game->get_game_current_home_score() . '</td>';
			} else {
				$html .= '<td class="score">' . $game->get_game_home_final() . '</td>';
			}
			$html .= '</tr>';
			$html .= '</tbody>';
			$html .= '</table>';
		}

		return $html;
	}

	/**
	 * Displays the infromation for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The incoming HTML for the game information.
	 * @param Game   $game           The current game object.
	 * @param Team   $home_team      The home team object.
	 * @return string                The HTML for the game info.
	 */
	public function sports_bench_do_game_info( $html, $game, $home_team ) {
		global $wpdb;
		$datetime = $game->get_game_day( get_option( 'time_format' ) ) . ' ' . $game->get_game_day( get_option( 'date_format' ) );

		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$quer            = $wpdb->prepare( "SELECT * FROM $game_info_table WHERE game_id = %d;", $game->get_game_id() );
		$game_events     = Database::get_results( $quer );
		$events          = [];
		foreach ( $game_events as $event ) {
			if ( 'football' === get_option( 'sports-bench-sport' ) ) {
				$event_array = [
					'game_info_id'       => $event->game_info_id,
					'game_id'            => $event->game_id,
				];
			} else {
				$event_array = [
					'game_info_id'       => $event->game_info_id,
					'game_id'            => $event->game_id,
				];
			}
			array_push( $events, $event_array );
		}

		if ( null !== $game->get_game_attendance() ) {
			$html .= '<p class="game-info">' . esc_html__( 'Attendance: ', 'sports-bench' ) . $game->get_game_attendance() . '</p>';
		}
		$html .= '<p class="game-info">' . $datetime . '</p>';
		$html .= '<p class="game-info">' . $game->get_game_location_stadium() . ', ' . $game->get_game_location_city() . ', ' . $game->get_game_location_state() . '</p>';

		return $html;
	}

	/**
	 * Displays the events for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The incoming HTML for the game events.
	 * @param array  $events         The list of events to show.
	 * @param Team   $away_team      The away team object.
	 * @param Team   $home_team      The home team object.
	 * @param string $sport          The sport the website is using.
	 * @return string                The HTML for the game events section.
	 */
	public function sports_bench_do_game_events( $html, $events, $away_team, $home_team, $sport ) {
		$html    = '<table class="game-events football">';
		$html   .= '<thead>';
		$html   .= '<tr>';
		$html   .= '<th></th>';
		$html   .= '<th></th>';
		$html   .= '<th></th>';
		$html   .= '<th class="top-team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '<br />' . $away_team->get_team_abbreviation() . '<span class="screen-reader-text">' . $away_team->get_team_name() . '</span></th>';
		$html   .= '<th class="top-team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '<br />' . $home_team->get_team_abbreviation() . '<span class="screen-reader-text">' . $home_team->get_team_name() . '</span></th>';
		$html   .= '</tr>';
		$html   .= '</thead>';
		$html   .= '<tbody>';
		$quarter = 0;
		foreach ( $events as $event ) {
			$team = new Team( (int) $event->game_info_scoring_team_id );
			if ( $event->game_info_quarter !== $quarter ) {
				if ( '1' === $event->game_info_quarter ) {
					$html   .= '<tr class="period"><td colspan="5"><strong>' . esc_html__( 'First Quarter', 'sports-bench' ) . '</strong></td></tr>';
					$quarter = '1';
				} elseif ( '2' === $event->game_info_quarter ) {
					$html   .= '<tr class="period"><td colspan="5"><strong>' . esc_html__( 'Second Quarter', 'sports-bench' ) . '</strong></td></tr>';
					$quarter = '2';
				} elseif ( '3' === $event->game_info_quarter ) {
					$html   .= '<tr class="period"><td colspan="5"><strong>' . esc_html__( 'Third Quarter', 'sports-bench' ) . '</strong></td></tr>';
					$quarter = '3';
				} elseif ( '4' === $event->game_info_quarter ) {
					$html   .= '<tr class="period"><td colspan="5"><strong>' . esc_html__( 'Fourth Quarter', 'sports-bench' ) . '</strong></td></tr>';
					$quarter = '4';
				} else {
					$html   .= '<tr class="period"><td colspan="5"><strong>' . esc_html__( 'Overtime', 'sports-bench' ) . '</strong></td></tr>';
					$quarter = 'OT';
				}
			}

			/**
			 * Adds styles for the row of the game events table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_game_event_row', '', $team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td class="team-logo">' . $team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td class="score">' . $event->game_info_time . '</td>';
			$html .= '<td>' . $event->game_info_play . '</td>';
			$html .= '<td class="score">' . $event->game_info_away_score . '</td>';
			$html .= '<td class="score">' . $event->game_info_home_score . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Displays the team stats for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The incoming HTML for the team stats.
	 * @param array  $game_info      The list of stats to show.
	 * @param Team   $away_team      The away team object.
	 * @param Team   $home_team      The home team object.
	 * @param Game   $game           The game object.
	 * @param string $sport          The sport the website is using.
	 * @return string                The HTML for the team stats section.
	 */
	public function sports_bench_do_team_stats( $html, $game_info, $away_team, $home_team, $game, $sport ) {
		foreach ( $game_info as $info ) {
			$html .= '<table class="team-stats">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Stat', 'sports-bench' ) . '</span></th>';
			$html .= '<th style="' . apply_filters( 'sports_bench_game_recap_team_stats_head_cell', '', $away_team ) . '">' . $home_team->get_team_photo( 'team-logo' ) . ' <span class="screen-reader-text">' . $home_team->get_team_name() . '</span></th>';
			$html .= '<th style="' . apply_filters( 'sports_bench_game_recap_team_stats_head_cell', '', $home_team ) . '">' . $away_team->get_team_photo( 'team-logo' ) . ' <span class="screen-reader-text">' . $away_team->get_team_name() . '</th>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<th></th>';
			$html .= '<th style="' . apply_filters( 'sports_bench_game_recap_team_stats_head_cell', '', $away_team ) . '">' . $home_team->get_team_abbreviation() . '</th>';
			$html .= '<th style="' . apply_filters( 'sports_bench_game_recap_team_stats_head_cell', '', $home_team ) . '">' . $away_team->get_team_abbreviation() . '</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Total Yards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_total . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_total . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Passing Yards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_pass . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_pass . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Rushing Yards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_rush . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_rush . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Turnovers:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_to . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_to . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Interceptions:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_ints . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_ints . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Fumbles-Lost:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_fumbles . '-' . $info->game_away_fumbles_lost . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_fumbles . '-' . $info->game_home_fumbles_lost . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Possession:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_possession . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_possession . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Kick Return-Yards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_kick_returns . '-' . $info->game_away_kick_return_yards . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_kick_returns . '-' . $info->game_home_kick_return_yards . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Penalties-Yards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_penalties . '-' . $info->game_away_penalty_yards . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_penalties . '-' . $info->game_home_penalty_yards . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'First Downs:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_first_downs . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_first_downs . '</td>';
			$html .= '</tr>';
			$html .= '</tbody>';
			$html .= '</table>';
		}

		return $html;
	}

	/**
	 * Displays the individual stats table for a team in a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The incoming HTML for the table.
	 * @param array  $stats          The array of stats to show.
	 * @param Team   $team           The team ojbect.
	 * @param string $team_type      Whether this is the home or away team.
	 * @param string $sport          The sport the website is using.
	 * @return string                The HTML for the individual stats section.
	 */
	public function sports_bench_do_individual_game_stats( $html, $stats, $team, $team_type, $sport ) {
		if ( 'away' === $team_type ) {
			$table_class = 'away-team';
		} else {
			$table_class = 'home-team';
		}

		if ( isset( $stats[0] ) ) {
			$passers = $stats[0];
		} else {
			$passers = '';
		}

		if ( isset( $stats[1] ) ) {
			$rushers = $stats[1];
		} else {
			$rushers = '';
		}

		if ( isset( $stats[2] ) ) {
			$receivers = $stats[2];
		} else {
			$receivers = '';
		}

		if ( isset( $stats[3] ) ) {
			$defenders = $stats[3];
		} else {
			$defenders = '';
		}

		if ( isset( $stats[4] ) ) {
			$kickers = $stats[4];
		} else {
			$kickers = '';
		}

		if ( isset( $stats[5] ) ) {
			$returners = $stats[5];
		} else {
			$returners = '';
		}

		$html  = '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Passing', 'sports-bench' ) . '</th>';
		$html .= '<th>COMP</th>';
		$html .= '<th>ATT</th>';
		$html .= '<th>YARDS</th>';
		$html .= '<th>TD</th>';
		$html .= '<th>INT</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $passers as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_completions . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_attempts . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_pass_yards . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_pass_tds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_pass_ints . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Rushing', 'sports-bench' ) . '</th>';
		$html .= '<th>RUSHES</th>';
		$html .= '<th>YARDS</th>';
		$html .= '<th>TD</th>';
		$html .= '<th>FUMBLES</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $rushers as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_rushes . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_rush_yards . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_rush_tds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_rush_fumbles . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Receiving', 'sports-bench' ) . '</th>';
		$html .= '<th>REC</th>';
		$html .= '<th>YARDS</th>';
		$html .= '<th>TD</th>';
		$html .= '<th>FUMBLES</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $receivers as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_catches . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_receiving_yards . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_receiving_tds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_receiving_fumbles . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Defense', 'sports-bench' ) . '</th>';
		$html .= '<th>TKL</th>';
		$html .= '<th>TFL</th>';
		$html .= '<th>S</th>';
		$html .= '<th>PB</th>';
		$html .= '<th>INT</th>';
		$html .= '<th>TD</th>';
		$html .= '<th>FF</th>';
		$html .= '<th>FR</th>';
		$html .= '<th>BLK</th>';
		$html .= '<th>YDS</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $defenders as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_tackles . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_tfl . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_sacks . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_pbu . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_ints . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_tds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_ff . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_fr . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_blocked . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_yards . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Kicking', 'sports-bench' ) . '</th>';
		$html .= '<th>FGM</th>';
		$html .= '<th>FGA</th>';
		$html .= '<th>XPM</th>';
		$html .= '<th>XPA</th>';
		$html .= '<th>TB</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $kickers as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_fgm . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_fga . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_xpm . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_xpa . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_touchbacks . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats football">';
		$html .= '<thead>';

		/**
		 * Adds styles for the header row of the game individual stats header table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the team.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_individual_stat_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th>' . esc_html__( 'Kick Returns', 'sports-bench' ) . '</th>';
		$html .= '<th>RETURNS</th>';
		$html .= '<th>YARDS</th>';
		$html .= '<th>TD</th>';
		$html .= '<th>FUM</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $returners as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();

			/**
			 * Adds styles for the row of the game individual stats table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles for the row.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles for the row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a></td>';
			$html .= '<td class="stat">' . $stat->game_player_returns . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_return_yards . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_return_tds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_return_fumbles . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
