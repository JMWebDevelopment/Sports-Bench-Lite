<?php
/**
 * Creates the rugby games class.
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
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The rugby games class.
 *
 * This is used for rugby games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyGames extends Games {

	/**
	 * Creates the new RugbyGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's rugby. It's null if not rugby.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		foreach ( $game_info as $info) {
			$html .= '<table class="linescore">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th></th>';
			$html .= '<th></th>';
			$html .= '<th>1</th>';
			$html .= '<th>2</th>';
			if ( null !== $info->game_home_extratime ) {
				$html .= '<th>ET</th>';
			}
			if ( null !== $info->game_home_shootout ) {
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
			$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_away_first_half . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_half . '</td>';
			if ( null !== $info->game_away_extratime ) {
				$html .= '<td class="score">' . $info->game_away_extratime . '</td>';
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
			$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_home_first_half . '</td>';
			$html .= '<td class="score">' . $info->game_home_second_half . '</td>';
			if ( null !== $info->game_home_extratime ) {
				$html .= '<td class="score">' . $info->game_home_extratime . '</td>';
			}
			if ( null !== $info->game_home_shootout ) {
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
		$html  = '<table class="game-events rugby">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th></th>';
		$html .= '<th class="score">' . $away_team->get_team_photo( 'team-logo' ) . '<br />' . $away_team->get_team_abbreviation() . ' <span class="screen-reader-text">' . $away_team->get_team_name() . '</span></th>';
		$html .= '<th class="score">' . $home_team->get_team_photo( 'team-logo' ) . '<br />' . $home_team->get_team_abbreviation() . ' <span class="screen-reader-text">' . $home_team->get_team_name() . '</span></th>';
		$html .= '<th></th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $events as $event ) {
			$player           = new Player( (int) $event->player_id );
			$team             = new Team( (int) $event->team_id );

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
			if ( $event->team_id === $away_team->get_team_id() ) {
				$logo = $away_team->get_team_photo( 'team-logo' );
			} else {
				$logo = $home_team->get_team_photo( 'team-logo' );
			}
			$html .= '<td class="score">' . $logo . '<br />' . $event->game_info_time . '\'</td>';
			$html .= '<td class="score">' . $event->game_info_away_score . '</td>';
			$html .= '<td class="score">' . $event->game_info_home_score . '</td>';
			$html .= '<td>' . $event->game_info_event . ' &mdash; ' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . '</td>';
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
			$html .= '<td>' . esc_html__( 'Tries:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_tries . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_tries . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Conversions:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_conversions . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_conversions . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Penalty Goals:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_penalty_goals . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_penalty_goals . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Kick Percentage:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_kick_percentage . '%</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_kick_percentage . '%</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Meters:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . ( $info->game_away_meters_hand + $info->game_away_meters_pass + $info->game_away_meters_runs ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . ( $info->game_home_meters_hand + $info->game_home_meters_pass + $info->game_home_meters_runs ) . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Kicks From Hand:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_meters_hand . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_meters_hand . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Passes:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_meters_pass . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_meters_pass . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Runs:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_meters_runs . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_meters_runs . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Possession:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_possession . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_possession . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Clean Breaks:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_clean_breaks . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_clean_breaks . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Defenders Beaten:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_defenders_beaten . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_defenders_beaten . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Offload:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_offload . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_offload . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Rucks:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_rucks . '%</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_rucks . '%</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Mauls:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_mauls . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_mauls . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Turnovers Conceded:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_turnovers_conceeded . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_turnovers_conceeded . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Scrums:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_scrums . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_scrums . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Lineouts:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_lineouts . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_lineouts . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Penalties Conceded:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_penalties_conceeded . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_penalties_conceeded . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Red Cards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_red_cards . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_red_cards . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Yellow Cards:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_yellow_cards . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_yellow_cards . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Free Kicks Conceded:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_free_kicks_conceeded . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_free_kicks_conceeded . '</td>';
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

		$html  = '<table class="' . $table_class . ' individual-stats rugby">';
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
		$html .= '<th>' . esc_html__( 'T', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'A', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'C', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PG', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'DK', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'PC', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'MR', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'R', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Y', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
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
			$html .= '<td class="stat">' . $stat->game_player_tries . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_assists . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_conversions . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_penalty_goals . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_drop_kicks . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_points . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_penalties_conceeded . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_meters_run . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_red_cards . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_yellow_cards . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
