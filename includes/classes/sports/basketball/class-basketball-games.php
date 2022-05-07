<?php
/**
 * Creates the basketball games class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Basketball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The basketball games class.
 *
 * This is used for basketball games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 */
class BasketballGames extends Games {

	/**
	 * Creates the new BasketballGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's basketball. It's null if not basketball.
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
			if ( 0 === get_option( 'sports-bench-basketball-halves' ) ) {
				$html .= '<th>3</th>';
				$html .= '<th>4</th>';
			}
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
			$html .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_away_first_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_away_second_quarter . '</td>';
			if ( 0 === get_option( 'sports-bench-basketball-halves' ) ) {
				$html .= '<td class="score">' . $info->game_away_third_quarter . '</td>';
				$html .= '<td class="score">' . $info->game_away_fourth_quarter . '</td>';
			}
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
			$html .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_location() . '</a></td>';
			$html .= '<td class="score">' . $info->game_home_first_quarter . '</td>';
			$html .= '<td class="score">' . $info->game_home_second_quarter . '</td>';
			if ( get_option( 'sports-bench-basketball-halves' ) ) {
				$html .= '<td class="score">' . $info->game_home_third_quarter . '</td>';
				$html .= '<td class="score">' . $info->game_home_fourth_quarter . '</td>';
			}
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
			$html = '<table class="team-stats">';
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
			$html .= '<td>' . esc_html__( 'Field Goals:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_fgm . '/' . $info->game_away_fga . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_fgm . '/' . $info->game_home_fga . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'FG Percentage:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . round( $info->game_away_fgm / $info->game_away_fga, 3 ) * 100 . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . round( $info->game_home_fgm / $info->game_home_fga, 3 ) * 100 . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( '3-point Field Goals:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_3pm . '/' . $info->game_away_3pa . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_3pm . '/' . $info->game_home_3pa . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( '3-point FG Percentage:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . round( $info->game_away_3pm / $info->game_away_3pa, 3 ) * 100 . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . round( $info->game_home_3pm / $info->game_home_3pa, 3 ) * 100 . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Free Throws:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_ftm . '/' . $info->game_away_fta . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_ftm . '/' . $info->game_home_fta . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'FT Percentage:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . round( $info->game_away_ftm / $info->game_away_fta, 3 ) * 100 . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . round( $info->game_home_ftm / $info->game_home_fta, 3 ) * 100 . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Off/Def Rebounds:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_off_rebound . '/' . $info->game_away_def_rebound . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_off_rebound . '/' . $info->game_home_def_rebound . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Assists:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_assists . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_assists . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Steals:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_steals . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_steals . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Blocks:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_blocks . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_blocks . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Points in the Paint:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_pip . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_pip . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Turnovers:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_to . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_to . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Points of Turnovers:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_steals . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_steals . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Fast Break Points:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_fast_break . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_fast_break . '</td>';
			$html .= '</tr>';
			$html .= '<tr>';
			$html .= '<td>' . esc_html__( 'Fouls:', 'sports-bench' ) . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $away_team ) . '">' . $info->game_away_fouls . '</td>';
			$html .= '<td class="stat" style="' . apply_filters( 'sports_bench_game_recap_team_stats_cell', '', $home_team ) . '">' . $info->game_home_fouls . '</td>';
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

		$html  = '<table class="' . $table_class . ' individual-stats basketball">';
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
		$html .= '<th>' . esc_html__( 'Scoring', 'sports-bench' ) . '</th>';
		$html .= '<th>MIN</th>';
		$html .= '<th>FG</th>';
		$html .= '<th>3-PT</th>';
		$html .= '<th>FT</th>';
		$html .= '<th>+/-</th>';
		$html .= '<th>PTS</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
			if ( 8 === strlen( $stat->game_player_minutes ) ) {
				$minutes = substr_replace( $stat->game_player_minutes, '', 0, 3 );
			} elseif ( 7 === strlen( $stat->game_player_minutes ) ) {
				$minutes = substr_replace( $stat->game_player_minutes, '', 0, 2 );
			} elseif ( 6 === strlen( $stat->game_player_minutes ) ) {
				$minutes = substr_replace( $stat->game_player_minutes, '', 0, 1 );
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
			$html .= '<td class="stat">' . $minutes . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_fgm . '-' . $stat->game_player_fga . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_3pm . '-' . $stat->game_player_3pa . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_ftm . '-' . $stat->game_player_fta . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_plus_minus . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_points . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '<table class="' . $table_class . ' individual-stats basketball">';
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
		$html .= '<th colspan="3">' . esc_html__( 'REBOUNDS', 'sports-bench' ) . '</th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '<th></th>';
		$html .= '</tr>';

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
		$html .= '<th>OFF</th>';
		$html .= '<th>DEF</th>';
		$html .= '<th>TOT</th>';
		$html .= '<th>AST</th>';
		$html .= '<th>STL</th>';
		$html .= '<th>BLK</th>';
		$html .= '<th>TO</th>';
		$html .= '<th>F</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			$player      = new Player( (int) $stat->player_id );
			$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
			$rebounds    = $stat->game_player_off_rebound + $stat->game_player_def_rebound;

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
			$html .= '<td class="stat">' . $stat->game_player_off_rebound . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_def_rebound . '</td>';
			$html .= '<td class="stat">' . $rebounds . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_assists . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_steals . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_blocks . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_to . '</td>';
			$html .= '<td class="stat">' . $stat->game_player_fouls . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}
}
