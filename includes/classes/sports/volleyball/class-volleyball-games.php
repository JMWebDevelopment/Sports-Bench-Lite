<?php
/**
 * Creates the volleyball games class.
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
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Sports\Volleyball\VolleyballPlayer;

/**
 * The volleyball games class.
 *
 * This is used for volleyball games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/volleyball
 */
class VolleyballGames extends Games {

	/**
	 * Creates the new VolleyballGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's volleyball. It's null if not volleyball.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		foreach ( $game_info as $info ) {
			$html .= '<table class="linescore">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th></th>';
			$html .= '<th></th>';
			$html .= '<th>1</th>';
			$html .= '<th>2</th>';
			$html .= '<th>3</th>';
			if ( null !== $info->game_home_fourth_set ) {
				$html .= '<th>4</th>';
			}
			if ( null !== $info->game_home_fifth_set ) {
				$html .= '<th>5</th>';
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
			$html .= '<td class="score">' . $info->game_away_first_set . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_set . '</td>';
			$html .= '<td class="score">' . $info->game_away_third_set . '</td>';
			if ( null !== $info->game_away_fourth_set ) {
				$html .= '<td class="score">' . $info->game_away_fourth_set . '</td>';
			}
			if ( null !== $info->game_away_fifth_set ) {
				$html .= '<td class="score">' . $info->game_away_fifth_set . '</td>';
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
			$html            .= '<tr style="' . $table_row_styles . '">';
			$html            .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html            .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_location() . '</a></td>';
			$html            .= '<td class="score">' . $info->game_home_first_set . '</td>';
			$html            .= '<td class="score">' . $info->game_home_second_set . '</td>';
			$html            .= '<td class="score">' . $info->game_home_third_set . '</td>';
			if ( null !== $info->game_home_fourth_set ) {
				$html .= '<td class="score">' . $info->game_home_fourth_set . '</td>';
			}
			if ( null !== $info->game_home_fifth_set ) {
				$html .= '<td class="score">' . $info->game_home_fifth_set . '</td>';
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
			$points = sports_bench_total_points( $game->get_game_id() );
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
			$html .= '<td>' . esc_html__( 'Total Points:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $points[ 'away' ] . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $points[ 'home' ] . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Hitting Percentage:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . number_format( (float) ( $info->game_away_kills - $info->game_away_hitting_errors )/$info->game_away_attacks, 3, '.', '' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . number_format( (float) ( $info->game_home_kills - $info->game_home_hitting_errors )/$info->game_home_attacks, 3, '.', '' ) . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Kills:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_kills . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_kills . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Blocks:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_blocks . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_blocks . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Aces:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_aces . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_aces . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Assists:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_assists . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_assists . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Digs:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_digs . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_digs . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Attacks:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_attacks . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_attacks . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Hitting Errors:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_hitting_errors . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_hitting_errors . '</td>';
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
		$html .= '<th>' . esc_html__( 'Attack', 'sports-bench' ) . '</th>';
		$html .= '<th>SP</th>';
		$html .= '<th>PTS</th>';
		$html .= '<th>K</th>';
		$html .= '<th>HE</th>';
		$html .= '<th>AT</th>';
		$html .= '<th>HIT %</th>';
		$html .= '<th>S</th>';
		$html .= '<th>SE</th>';
		$html .= '<th>ACE</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			$player      = new VolleyballPlayer( (int) $stat->player_id );
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
			$html .= '<td class="stat">' . $stat->game_player_sets_played . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_points . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_kills . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_hitting_errors . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_attacks . '</td>';
			$html .= '<td class="stat">' . $player->get_hitting_percentage( $stat->game_player_attacks, $stat->game_player_kills, $stat->game_player_hitting_errors) . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_serves . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_serve_errors . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_aces . '</td>';
			$html .= '</tr>';
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
		$html .= '<th>' . esc_html__( 'Defense', 'sports-bench' ) . '</th>';
		$html .= '<th>SET A</th>';
		$html .= '<th>SET E</th>';
		$html .= '<th>BA</th>';
		$html .= '<th>B</th>';
		$html .= '<th>BE</th>';
		$html .= '<th>DIG</th>';
		$html .= '<th>RE</th>';
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
			$html .= '<td class="stat">' . $stat->game_player_set_attempts . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_set_errors . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_block_attempts . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_blocks . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_block_errors . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_digs . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_receiving_errors . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
