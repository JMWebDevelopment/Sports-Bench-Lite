<?php
/**
 * Creates the soccer games class.
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
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The soccer games class.
 *
 * This is used for soccer games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class SoccerGames extends Games {

	/**
	 * Creates the new SoccerGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's soccer. It's null if not soccer.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		foreach ( $game_info as $info) {
			$home_et  = $info->game_home_extratime;
			$home_pks = $info->game_home_pks;
			$html     = '<table class="linescore">';
			$html    .= '<thead>';
			$html    .= '<tr>';
			$html    .= '<th></th>';
			$html    .= '<th></th>';
			$html    .= '<th>1</th>';
			$html    .= '<th>2</th>';
			if ( null !== $home_et ) {
				$html .= '<th>ET</th>';
			}
			if ( null !== $home_pks ) {
				$html .= '<th>PKs</th>';
			}
			$html .= '<th>FT</th>';
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
			$table_row_styles = apply_filters( 'sports_bench_linescore_row', '', $home_team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_name() . '</a></td>';
			$html .= '<td class="score">' . $info->game_home_first_half . '</td>';
			$html .= '<td class="score">' . $info->game_home_second_half . '</td>';
			if ( null !== $home_et ) {
				$html .= '<td class="score">' . $info->game_home_extratime . '</td>';
			}
			if ( null !== $home_pks ) {
				$html .= '<td class="score">' . $info->game_home_pks . '</td>';
			}
			if ( 'in_progress' === $game->get_game_status() ) {
				$html .= '<td class="score">' . $game->get_game_current_home_score() . '</td>';
			} else {
				$html .= '<td class="score">' . $game->get_game_home_final() . '</td>';
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
			$table_row_styles = apply_filters( 'sports_bench_linescore_row', '', $away_team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_name() . '</a></td>';
			$html .= '<td class="score">' . $info->game_away_first_half . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_half . '</td>';
			if ( null !== $home_et ) {
				$html .= '<td class="score">' . $info->game_away_extratime . '</td>';
			}
			if ( null !== $home_pks ) {
				$html .= '<td class="score">' . $info->game_away_pks . '</td>';
			}
			if ( 'in_progress' === $game->get_game_status() ) {
				$html .= '<td class="score">' . $game->get_game_current_away_score() . '</td>';
			} else {
				$html .= '<td class="score">' . $game->get_game_away_final() . '</td>';
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
		$html  = '<table class="game-events">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th colspan="2">' . __( 'Match Events', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		foreach ( $events as $event ) {
			$team   = new Team( (int) $event->team_id );
			$player = new Player( (int) $event->player_id );
			$assist = '';
			$action = '';
			if ( null !== $event->secondary_player_id && '' !== $event->secondary_player_id ) {

				if ( ! is_numeric( $event->secondary_player_id ) ) {
					$assist = ' (' . $event->secondary_player_id . ')';
				} else {
					if ( ( 'goal' === $event->game_info_event || 'Goal' === $event->game_info_event ) && 0 < $event->secondary_player_id ) {
						$second_player = new Player( (int) $event->secondary_player_id );
						$assist        = ' (' . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
						$action        = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal', 'sports-bench' );
					} elseif ( 'goal' === $event->game_info_event || 'Goal' === $event->game_info_event ) {
						$action = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal', 'sports-bench' );
					} elseif ( 'pk-goal' === $event->game_info_event || 'Goal (PK)' === $event->game_info_event ) {
						$action = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal (PK)', 'sports-bench' );
					} elseif ( 'pk-given' === $event->game_info_event ) {
						$action        = '<span class="fal fa-whistle"></span> ' . esc_html__( 'Penalty Kick won by', 'sports-bench' );
						$second_player = new Player( (int) $event->secondary_player_id );
						$assist        = ' (' . esc_html__( 'given up by ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
					} elseif ( 'corner-kick' === $event->game_info_event ) {
						$action = '<span class="fal fa-flag"></span> ' . esc_html__( 'Corner kick conceeded by', 'sports-bench' );
					} elseif ( 'foul' === $event->game_info_event ) {
						$action        = '<span class="fal fa-whistle"></span> ' . esc_html__( 'Corner kick conceeded by', 'sports-bench' );
						$second_player = new Player( (int) $event->secondary_player_id );
						$assist        = ' (' . esc_html__( 'on ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
					} elseif ( 'shot-missed' === $event->game_info_event ) {
						$action = '<span class="fal fa-times"></span> ' . esc_html__( 'Shot missed by', 'sports-bench' );
					} elseif ( 'shot-saved' === $event->game_info_event ) {
						$action        = '<span class="fal fa-times"></span> ' . esc_html__( 'Shot saved: ', 'sports-bench' );
						$second_player = new Player( (int) $event->secondary_player_id );
						$assist        = ' (' . esc_html__( 'by ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
					} elseif ( 'offside' === $event->game_info_event ) {
						$action = '<span class="fal fa-flag"></span> ' . esc_html__( 'Offside on', 'sports-bench' );
					} elseif ( 'yellow' === $event->game_info_event || 'Yellow' === $event->game_info_event ) {
						$action = '<span class="fas fa-square yellow"></span> ' . esc_html__( 'Yellow card to', 'sports-bench' );
					} elseif ( 'red' === $event->game_info_event || 'Red' === $event->game_info_event ) {
						$action = '<span class="fas fa-square red"></span> ' . esc_html__( 'Red card to', 'sports-bench' );
					}
				}
			}
			$table_row_styles = apply_filters( 'sports_bench_game_event_row', '', $team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . '<span class="event-id">' . $event->game_info_id . '</span></td>';
			$html .= '<td>' . $event->game_info_time . "' &mdash; " . $action . ' ' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . $assist . '</td>';
			$html .= '</tr>';
		}
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
			$html .= '<td>' . __( 'Possession:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_possession . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_possession . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Shots:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_shots . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_shots . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Shots on goal:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_sog . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_sog . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Corners:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_corners . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_corners . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Offsides:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_offsides . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_offsides . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Fouls:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_fouls . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_fouls . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Saves:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_saves . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_saves . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Yellow cards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_yellow . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_yellow . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . __( 'Red cards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_home_red . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_away_red . '</td>';
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
		$html .= '<th>MIN</th>';
		$html .= '<th>G</th>';
		$html .= '<th>A</th>';
		$html .= '<th>SH</th>';
		$html .= '<th>SOG</th>';
		$html .= '<th>F</th>';
		$html .= '<th>FS</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			$player = new Player( (int) $stat->game_player_id );
			if ( 'Goalkeeper' !== $player->get_player_position() ) {
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
				$html .= '<td class="stat">' . $stat->game_player_minutes . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_goals . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_assists . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_shots . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_sog . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_fouls . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_fouls_suffered . '</td>';
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
		$html .= '<th>' . __( 'Goalkeepers', 'sports-bench' ) . '</th>';
		$html .= '<th>MIN</th>';
		$html .= '<th>SF</th>';
		$html .= '<th>SV</th>';
		$html .= '<th>GA</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			$player = new Player( (int) $stat->game_player_id );
			if ( 'Goalkeeper' === $player->get_player_position() ) {
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
				$html .= '<td class="stat">' . $stat->game_player_minutes . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_shots_faced . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_shots_saved . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_goals_allowed . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	public function load_live_game_events() {
		check_ajax_referer( 'sports-bench-box-score', 'nonce' );
		$game_id   = wp_filter_nohtml_kses( $_POST['game_id'] );
		$event_ids = implode(',', $this->sanitize_array( $_POST['event_ids'] ) );
		$html      = '';

		global $wpdb;
		$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $game_id );
		if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d AND game_info_id NOT IN ($event_ids) ORDER BY game_info_time DESC;", $game_id );
		}
		$events    = Database::get_results( $querystr );
		$event_ids = explode(',', $event_ids );

		if ( $events ) {
			foreach ( $events as $event ) {
				$event_ids[] = $event->game_info_id;
				$team        = new Team( (int) $event->team_id );
				$player      = new Player( (int) $event->player_id );
				$assist      = '';
				$action      = '';
				if ( null !== $event->secondary_player_id && '' !== $event->secondary_player_id ) {

					if ( ! is_numeric( $event->secondary_player_id ) ) {
						$assist = ' (' . $event->secondary_player_id . ')';
					} else {
						if ( ( 'goal' === $event->game_info_event || 'Goal' === $event->game_info_event ) && 0 < $event->secondary_player_id ) {
							$second_player = new Player( (int) $event->secondary_player_id );
							$assist        = ' (' . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
							$action        = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal', 'sports-bench' );
						} elseif ( 'goal' === $event->game_info_event || 'Goal' === $event->game_info_event ) {
							$action = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal', 'sports-bench' );
						} elseif ( 'pk-goal' === $event->game_info_event || 'Goal (PK)' === $event->game_info_event ) {
							$action = '<span class="fal fa-futbol"></span> ' . esc_html__( 'Goal (PK)', 'sports-bench' );
						} elseif ( 'pk-given' === $event->game_info_event ) {
							$action        = '<span class="fal fa-whistle"></span> ' . esc_html__( 'Penalty Kick won by', 'sports-bench' );
							$second_player = new Player( (int) $event->secondary_player_id );
							$assist        = ' (' . esc_html__( 'given up by ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
						} elseif ( 'corner-kick' === $event->game_info_event ) {
							$action = '<span class="fal fa-flag"></span> ' . esc_html__( 'Corner kick conceeded by', 'sports-bench' );
						} elseif ( 'foul' === $event->game_info_event ) {
							$action        = '<span class="fal fa-whistle"></span> ' . esc_html__( 'Corner kick conceeded by', 'sports-bench' );
							$second_player = new Player( (int) $event->secondary_player_id );
							$assist        = ' (' . esc_html__( 'on ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
						} elseif ( 'shot-missed' === $event->game_info_event ) {
							$action = '<span class="fal fa-times"></span> ' . esc_html__( 'Shot missed by', 'sports-bench' );
						} elseif ( 'shot-saved' === $event->game_info_event ) {
							$action        = '<span class="fal fa-times"></span> ' . esc_html__( 'Shot saved: ', 'sports-bench' );
							$second_player = new Player( (int) $event->secondary_player_id );
							$assist        = ' (' . esc_html__( 'by ', 'sports-bench' ) . $second_player->get_player_first_name() . ' ' . $second_player->get_player_last_name() . ')';
						} elseif ( 'offside' === $event->game_info_event ) {
							$action = '<span class="fal fa-flag"></span> ' . esc_html__( 'Offside on', 'sports-bench' );
						} elseif ( 'yellow' === $event->game_info_event || 'Yellow' === $event->game_info_event ) {
							$action = '<span class="fas fa-square yellow"></span> ' . esc_html__( 'Yellow card to', 'sports-bench' );
						} elseif ( 'red' === $event->game_info_event || 'Red' === $event->game_info_event ) {
							$action = '<span class="fas fa-square red"></span> ' . esc_html__( 'Red card to', 'sports-bench' );
						}
					}
				}
				$table_row_styles = apply_filters( 'sports_bench_game_event_row', '', $team );

				$html .= '<tr style="' . $table_row_styles . '">';
				$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . '<span class="event-id">' . $event->game_info_id . '</span></td>';
				$html .= '<td>' . $event->game_info_time . "' &mdash; " . $action . ' ' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . $assist . '</td>';
				$html .= '</tr>';
			}
		}

		$data = [ $html, $event_ids ];

		wp_send_json_success( $data );
		wp_die();
	}
}
