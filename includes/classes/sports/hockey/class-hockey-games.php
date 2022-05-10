<?php
/**
 * Creates the hockey games class.
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
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The hockey games class.
 *
 * This is used for hockey games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 */
class HockeyGames extends Games {

	/**
	 * Creates the new HockeyGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's hockey. It's null if not hockey.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		foreach ( $game_info as $info ) {
			$html = '<table class="linescore">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th></th>';
			$html .= '<th></th>';
			$html .= '<th>1</th>';
			$html .= '<th>2</th>';
			$html .= '<th>3</th>';
			if ( null !== $info->game_home_overtime || null !== $info->game_away_overtime ) {
				$html .= '<th>OT</th>';
			}
			if ( null !== $info->game_home_shootout || null !== $info->game_away_shootout ) {
				$html .= '<th>SO</th>';
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
			$html .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_name() . '</a></td>';
			$html .= '<td class="score">' . $info->game_away_first_period . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_period . '</td>';
			$html .= '<td class="score">' . $info->game_away_third_period . '</td>';
			if ( null !== $info->game_away_overtime ) {
				$html .= '<td class="score">' . $info->game_away_overtime . '</td>';
			}
			if ( null !== $info->game_away_shootout ) {
				$html .= '<td class="score">' . $info->game_away_shootout . '</td>';
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
			$html .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_name() . '</a></td>';
			$html .= '<td class="score">' . $info->game_home_first_period . '</td>';
			$html .= '<td class="score">' . $info->game_home_second_period . '</td>';
			$html .= '<td class="score">' . $info->game_home_third_period . '</td>';
			if ( $info->game_home_overtime != null ) {
				$html .= '<td class="score">' . $info->game_home_overtime . '</td>';
			}
			if ( $info->game_home_shootout != null ) {
				$html .= '<td class="score">' . $info->game_home_shootout . '</td>';
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
			if ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
				$event_array = [
					'game_info_id'       => $event->game_info_id,
					'game_id'            => $event->game_id,
					'game_info_referees' => $event->game_info_referees,
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
		$goals = [];
		$penalties = [];
		foreach ( $events as $event ) {
			if ( $event->game_info_event == 'Goal' ) {
				array_push( $goals, $event );
			} else {
				array_push( $penalties, $event );
			}
		}
		$html       = '<table class="game-events">';
		$html      .= '<thead>';
		$html      .= '<tr>';
		$html      .= '<th></th>';
		$html      .= '<th></th>';
		$html      .= '<th></th>';
		$html      .= '<th class="top-team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</th>';
		$html      .= '<th class="top-team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</th>';
		$html      .= '</tr>';
		$html      .= '</thead>';
		$html      .= '<tbody>';
		$home_score = 0;
		$away_score = 0;
		$period     = 0;
		if ( $goals ) {
			$html .= '<tr class="event"><td colspan="5">' . esc_html__( 'Goals', 'sports-bench' ) . '</td></tr>';
			foreach ( $goals as $goal ) {
				$player      = new Player( (int) $goal->player_id );
				$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
				$assist      = '';
				if ( $goal->game_info_assist_one_id ) {
					$assist_one        = new Player( (int) $goal->game_info_assist_one_id );
					$assist_one_player = $assist_one->get_player_first_name() . ' ' . $assist_one->get_player_last_name();
					$assist            = __( 'Assists: ', 'sports-bench' ) . $assist_one_player;
				}
				if ( $goal->game_info_assist_two_id ) {
					$assist_two        = new Player( (int) $goal->game_info_assist_two_id );
					$assist_two_player = $assist_two->get_player_first_name() . ' ' . $assist_two->get_player_last_name();
					$assist .= ', ' . $assist_two_player;
				}
				$team = new Team( (int) $goal->team_id );
				if ( $team->get_team_id() == $away_team->get_team_id() ) {
					$away_score += 1;
				} else {
					$home_score += 1;
				}

				if ( $goal->game_info_period !== $period ) {
					if ( '1' === $goal->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . esc_html__( 'First Period', 'sports-bench' ) . '</td></tr>';
						$period = '1';
					} elseif ( '2' === $goal->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . esc_html__( 'Second Period', 'sports-bench' ) . '</td></tr>';
						$period = '2';
					} elseif ( '3' === $goal->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . esc_html__( 'Third Period', 'sports-bench' ) . '</td></tr>';
						$period = '3';
					} else {
						$html  .= '<tr class="period"><td colspan="5">' . esc_html__( 'Overtime', 'sports-bench' ) . '</td></tr>';
						$period = '4';
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
				$html .= '<td class="team-logo">' . $team->get_team_photo( 'team-logo' ) . ' <span class="screen-reader-text">' . $team->get_team_name() . '</td>';
				$html .= '<td class="score">' . $goal->game_info_time . '</td>';
				$html .= '<td>' . __( 'Goal scored by ', 'sports-bench' ) . $player_name . '. ' . $assist . '</td>';
				$html .= '<td class="score">' . $away_score . '</td>';
				$html .= '<td class="score">' . $home_score . '</td>';
				$html .= '</tr>';
			}
		}
		$period = 0;
		if ( $penalties ) {
			$html .= '<tr class="event"><td colspan="5">' . esc_html__( 'Penalties', 'sports-bench' ) . '</td></tr>';
			foreach ( $penalties as $penalty ) {
				$player      = new Player( (int) $goal->player_id );
				$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
				$team        = new Team( (int) $penalty->team_id );
				if ( $penalty->game_info_period !== $period ) {
					if ( '1' === $penalty->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . __( 'First Period', 'sports-bench' ) . '</td></tr>';
						$period = '1';
					} elseif ( '2' === $penalty->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . __( 'Second Period', 'sports-bench' ) . '</td></tr>';
						$period = '2';
					} elseif ( '3' === $penalty->game_info_period ) {
						$html  .= '<tr class="period"><td colspan="5">' . __( 'Third Period', 'sports-bench' ) . '</td></tr>';
						$period = '3';
					} else {
						$html  .= '<tr class="period"><td colspan="5">' . __( 'Overtime', 'sports-bench' ) . '</td></tr>';
						$period = '4';
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
				$html .= '<td class="team-logo">' . $team->get_team_photo( 'team-logo' ) . ' <span class="screen-reader-text">' . $team->get_team_name() . '</span></td>';
				$html .= '<td class="score">' . $penalty->game_info_time . '</td>';
				$html .= '<td colspan="3">' . $player_name . ' ' . $penalty->game_info_penalty . '</td>';
				$html .= '</tr>';
			}
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
	function sports_bench_do_team_stats( $html, $game_info, $away_team, $home_team, $game, $sport ) {
		foreach ( $game_info as $info ) {
			$html  = '<table class="team-stats">';
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
			$html .= '<td>' . esc_html__( 'First Period SOG', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_first_sog . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_first_sog . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Second Period SOG', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_second_sog . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_second_sog . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Third Period SOG', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_third_sog . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_third_sog . '</td>';
			$html .= '</tr>';
			if ( $info->game_away_overtime != null ) {
				$html .= '<tr>';
				$html .= '<td>' . esc_html__( 'Overtime SOG', 'sports-bench' ) . '</td>';
				$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_overtime_sog . '</td>';
				$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_overtime_sog . '</td>';
				$html .= '</tr>';
			}
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Power Play Opportunities-Goals', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_power_plays . '-' . $info->game_away_pp_goals . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_power_plays . '-' . $info->game_home_pp_goals . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Penalty Minutes', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_pen_minutes . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_pen_minutes . '</td>';
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
	function sports_bench_do_individual_game_stats( $html, $stats, $team, $team_type, $sport ) {

		if ( 'away' === $team_type ) {
			$table_class = 'away-team';
		} else {
			$table_class = 'home-team';
		}

		$html  = '<table class="' . $table_class . ' individual-stats">';
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
		$html .= '<th></th>';
		$html .= '<th>G</th>';
		$html .= '<th>A</th>';
		$html .= '<th>+/-</th>';
		$html .= '<th>S</th>';
		$html .= '<th>PM</th>';
		$html .= '<th>H</th>';
		$html .= '<th>SH</th>';
		$html .= '<th>TOI</th>';
		$html .= '<th>FO-W</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			if ( '0' === $stat->game_player_shots_faced ) {
				$player      = new Player( (int) $stat->player_id );
				$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
				if ( 8 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 3 );
				} elseif ( 7 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 2 );
				} elseif ( 6 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 1 );
				} else {
					$minutes = $stat->game_player_minutes;
				}

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
				$html .= '<td class="stat">' . $stat->game_player_goals . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_assists . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_plus_minus . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_sog . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_pen_minutes . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_hits . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_shifts . '</td>';
				$html .= '<td class="stat">' . $minutes . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_faceoffs . '-' . $stat->game_player_faceoff_wins . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats">';
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
		$html .= '<th></th>';
		$html .= '<th>SF</th>';
		$html .= '<th>SV</th>';
		$html .= '<th>GA</th>';
		$html .= '<th>TOI</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			if ( $stat->game_player_shots_faced > 0 ) {
				$player      = new Player( (int) $stat->player_id );
				$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
				if ( 8 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 3 );
				} elseif ( 7 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 2 );
				} elseif ( 6 === strlen( $stat->game_player_time_on_ice ) ) {
					$minutes = substr_replace( $stat->game_player_time_on_ice, '', 0, 1 );
				} else {
					$minutes = $stat->game_player_minutes;
				}

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
				$html .= '<td class="stat">' . $stat->game_player_shots_faced . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_saves . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_goals_allowed . '</td>';
				$html .= '<td class="stat">' . $minutes . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
