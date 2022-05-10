<?php
/**
 * Creates the baseball games class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Baseball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Game;

/**
 * The baseball games class.
 *
 * This is used for baseball games functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 */
class BaseballGames extends Games {

	/**
	 * Creates the new BaseballGames object to be used.
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
	 * @param array|null $linescore_array      The array for the linescore if it's baseball. It's null if not baseball.
	 * @return string                          The HTML for the linescore table.
	 */
	public function sports_bench_do_game_linescore( $html, $game, $away_team, $home_team, $sport, $game_info, $linescore_array ) {
		$total_innings = 9;
		foreach ( $linescore_array as $home_away ) {
			foreach ( $home_away as $ha ) {
				if ( $ha['inning'] > $total_innings ) {
					$total_innings = $ha['inning'];
				}
			}
		}

		$html  = '<table class="linescore baseball">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th></th>';
		for ( $i = 0; $i < $total_innings; $i++ ) {
			$inning = $i + 1;
			$html  .= '<th>' . $inning . '</th>';
		}
		$html .= '<th>R</th>';
		$html .= '<th>H</th>';
		$html .= '<th>E</th>';
		$html .= '<th>L</th>';
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
		$html .= '<td><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_location() . '</a></td>';
		for ( $i = 0; $i < $total_innings; $i++ ) {
			$filled = false;
			foreach ( $linescore_array[0] as $inning ) {
				if ( ( $i + 1 ) === $inning['inning'] ) {
					$html  .= '<td class="score">' . $inning['runs_scored'] . '</td>';
					$filled = true;
				}
			}
			if ( false === $filled ) {
				$html .= '<td class="score">0</td>';
			}
		}
		$hits   = $this->get_game_stat( $game, 'away', 'hits' );
		$errors = $this->get_game_stat( $game, 'away', 'errors' );
		$lob    = $this->get_game_stat( $game, 'away', 'lob' );
		if ( 'in_progress' === $game->get_game_status() ) {
			$html .= '<td class="score">' . $game->get_game_current_away_score() . '</td>';
		} else {
			$html .= '<td class="score">' . $game->get_game_away_final() . '</td>';
		}
		$html .= '<td class="score">' . $hits[0]->game_away_hits . '</td>';
		$html .= '<td class="score">' . $errors[0]->game_away_errors . '</td>';
		$html .= '<td class="score">' . $lob[0]->game_away_lob . '</td>';
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
		$html .= '<td><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_location() . '</a></td>';
		for ( $i = 0; $i < $total_innings; $i++ ) {
			$filled = false;
			foreach ( $linescore_array[1] as $inning ) {
				if ( ( $i + 1 ) === $inning['inning'] ) {
					$html  .= '<td class="score">' . $inning['runs_scored'] . '</td>';
					$filled = true;
				}
			}
			if ( false === $filled ) {
				$html .= '<td class="score">0</td>';
			}
		}
		$hits   = $this->get_game_stat( $game, 'home', 'hits' );
		$errors = $this->get_game_stat( $game, 'home', 'errors' );
		$lob    = $this->get_game_stat( $game, 'home', 'lob' );
		if ( 'in_progress' === $game->get_game_status() ) {
			$html .= '<td class="score">' . $game->get_game_current_home_score() . '</td>';
		} else {
			$html .= '<td class="score">' . $game->get_game_home_final() . '</td>';
		}
		$html .= '<td class="score">' . $hits[0]->game_home_hits . '</td>';
		$html .= '<td class="score">' . $errors[0]->game_home_errors . '</td>';
		$html .= '<td class="score">' . $lob[0]->game_home_lob . '</td>';
		$html .= '</tr>';
		$html .= '</tbody>';
		$html .= '</table>';

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
		$runs_played = [];

		if ( $events ) {
			foreach ( $events as $event ) {
				if ( 'runs-scored' === $event->game_info_type ) {
					$runs_played[] = $event;
				}
			}
		}

		$html = '<div id="box-score-events">';
		$html .= '<ul aria-controls="box-score-events" role="tablist">';
		$html .= '<li role="tab" aria-controls="all-tab" tabindex="0" aria-selected="true">' . esc_html__( 'All Events', 'sports-bench' ) . '</li>';
		$html .= '<li role="tab" aria-controls="runs-tab" tabindex="0" aria-selected="false">' . esc_html__( 'Runs Scoring Events', 'sports-bench' ) . '</li>';
		$html .= '</ul>';

		$html .= '<div class="tabs-container">';
		$html .= '<div id="all-tab" class="tabs-content" role="tabpanel" aria-expanded="true">';
		$html .= '<table class="game-events baseball">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th></th>';
		$html .= '<th class="score">' . $away_team->get_team_photo( 'team-logo' ) . '<br />' . $away_team->get_team_abbreviation() . '</th>';
		$html .= '<th class="score">' . $home_team->get_team_photo( 'team-logo' ) . '<br />' . $home_team->get_team_abbreviation() . '</th>';
		$html .= '<th></th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $events as $event ) {
			if ( 'top' === $event->game_info_top_bottom || 'Top' === $event->game_info_top_bottom ) {
				$logo = $away_team->get_team_photo( 'team-logo' );
				$team = $away_team;
				$half = __( 'Top', 'sports-bench' );
			} else {
				$logo = $home_team->get_team_photo( 'team-logo' );
				$team = $home_team;
				$half = __( 'Bottom', 'sports-bench' );
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
			$html .= '<td class="score">' . $logo . '<br />' . $half . ' ' . $event->game_info_inning . '<span class="event-id">' . $event->game_info_id . '</span></td>';
			$html .= '<td class="score">' . $event->game_info_away_score . '</td>';
			$html .= '<td class="score">' . $event->game_info_home_score . '</td>';
			if ( 'runs-scored' === $event->game_info_type ) {
				$html .= '<td><strong>' . $event->game_info_play . '(' . $event->game_info_count . ')</strong></td>';
			} else {
				$html .= '<td>' . $event->game_info_play . '(' . $event->game_info_count . ' - ' . $event->game_info_outs . ' ' . esc_html__( 'Outs', 'sports-bench' ) . ')</td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';

		$html .= '<div id="runs-tab" class="tabs-content" role="tabpanel" aria-expanded="false">';
		$html .= '<table class="game-events baseball runs-scored">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th></th>';
		$html .= '<th class="score">' . $away_team->get_team_photo( 'team-logo' ) . '<br />' . $away_team->get_team_abbreviation() . '</th>';
		$html .= '<th class="score">' . $home_team->get_team_photo( 'team-logo' ) . '<br />' . $home_team->get_team_abbreviation() . '</th>';
		$html .= '<th></th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $runs_played as $event ) {
			if ( 'Top' === $event->game_info_top_bottom ) {
				$logo = $away_team->get_team_photo( 'team-logo' );
				$team = $away_team;
			} else {
				$logo = $home_team->get_team_photo( 'team-logo' );
				$team = $home_team;
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
			$html .= '<td class="score">' . $logo . '<br />' . $event->game_info_top_bottom . ' ' . $event->game_info_inning . '<span class="event-id">' . $event->game_info_id . '</span></td>';
			$html .= '<td class="score">' . $event->game_info_away_score . '</td>';
			$html .= '<td class="score">' . $event->game_info_home_score . '</td>';
			$html .= '<td>' . $event->game_info_play . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

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
		$html .= '<th>AB</th>';
		$html .= '<th>H</th>';
		$html .= '<th>R</th>';
		$html .= '<th>RBI</th>';
		$html .= '<th>SO</th>';
		$html .= '<th>BB</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			if ( 'P' !== $stat->game_player_position ) {
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
				$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . '</a>, ' . $stat->game_player_position . '</a></td>';
				$html .= '<td class="stat">' . $stat->game_player_at_bats . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_hits . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_runs . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_rbis . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_strikeouts . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_walks . '</td>';
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
		$html .= '<th>IP</th>';
		$html .= '<th>R</th>';
		$html .= '<th>ER</th>';
		$html .= '<th>H</th>';
		$html .= '<th>SO</th>';
		$html .= '<th>BB</th>';
		$html .= '<th>NP</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $stats as $stat ) {
			if ( 'P' === $stat->game_player_position ) {
				$player      = new Player( (int) $stat->player_id );
				$player_name = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
				if ( 'ND' !== $stat->game_player_decision ) {
					if ( 'W' === $stat->game_player_decision || 'L' === $stat->game_player_decision ) {
						$record   = sports_bench_get_pitcher_record( (int) $stat->player_id, get_option( 'sports-bench-season-year' ) );
						$decision = ', ' . $stat->game_player_decision . ' (' . $record['wins'] . '-' . $record['losses'] . ')';
					} elseif ( 'S' === $stat->game_player_decision ) {
						$saves    = sports_bench_get_pitcher_saves( (int) $stat->player_id, get_option( 'sports-bench-season-year' ) );
						$decision = ', ' . $stat->game_player_decision . ' (' . $saves . ')';
					} else {
						$decision = ', ' . $stat->game_player_decision;
					}
				} else {
					$decision = '';
				}

				/**
				 * Adds styles for the row of the game individual stats header table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The incoming styles for the row.
				 * @param Team   $team        The team object for the team.
				 * @return string             The styles for the row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_individual_stat_row', '', $team );

				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<td><a href="' . $player->get_permalink() . '">' . $player_name . $decision . '</a></td>';
				$html .= '<td class="stat">' . $stat->game_player_innings_pitched . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_runs_allowed . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_earned_runs . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_hits_allowed . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_pitcher_strikeouts . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_pitcher_walks . '</td>';
				$html .= '<td class="stat">' . $stat->game_player_pitch_count . '</td>';
				$html .= '</tr>';
			}
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Gets a given team stats for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param Game   $game           The game object for the game to get the stat from.
	 * @param string $home_away      Whether to get a "home" or "away" stat.
	 * @param string $stat           The stat to get.
	 * @return int                   The stat being searched.
	 */
	public function get_game_stat( $game, $home_away, $stat ) {
		$column = 'game_' . $home_away . '_' . $stat;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT $column FROM $table WHERE game_id = %d;", $game->get_game_id() );
		$the_stat = Database::get_results( $querystr );
		return $the_stat;
	}

	/**
	 * Runs the AJAX to load the game events in real time.
	 *
	 * @since 2.2
	 *
	 * @return array      The data for the game events table.
	 */
	public function load_live_game_events() {
		check_ajax_referer( 'sports-bench-box-score', 'nonce' );
		$game_id    = $_POST['game_id'];
		$event_ids  = implode(',', $_POST['event_ids'] );
		$all_html   = '';
		$score_html = '';
		$game       = new Game( $game_id );
		$away_team  = new Team( (int)$game->get_game_away_id() );
		$home_team  = new Team( (int)$game->get_game_home_id() );

		global $wpdb;
		$table     = SB_TABLE_PREFIX . 'game_info';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $game_id );
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d AND game_info_id NOT IN ($event_ids) ORDER BY game_info_id ASC;", $game_id );
		}
		$events    = Database::get_results( $querystr );
		$event_ids = explode(',', $event_ids );

		if ( $events ) {
			foreach ( $events as $event ) {
				$event_ids[] = $event->game_info_id;
				if ( 'Top' === $event->game_info_top_bottom || 'top' === $event->game_info_top_bottom) {
					$logo = $away_team->get_team_photo( 'team-logo' );
					$team = $away_team;
					$half = __( 'Top', 'sports-bench' );
				} else {
					$logo = $home_team->get_team_photo( 'team-logo' );
					$team = $home_team;
					$half = __( 'Bottom', 'sports-bench' );
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

				$all_html .= '<tr style="' . $table_row_styles . '">';
				$all_html .= '<td class="score">' . $logo . '<br />' . $half . ' ' . $event->game_info_inning . '<span class="event-id">' . $event->game_info_id . '</span></td>';
				$all_html .= '<td class="score">' . $event->game_info_away_score . '</td>';
				$all_html .= '<td class="score">' . $event->game_info_home_score . '</td>';
				if ( 'runs-scored' === $event->game_info_type ) {
					$all_html .= '<td><strong>' . $event->game_info_play . '(' . $event->game_info_count . ')</strong></td>';
				} else {
					$all_html .= '<td>' . $event->game_info_play . '(' . $event->game_info_count . ' - ' . $event->game_info_outs . ' ' . esc_html__( 'Outs', 'sports-bench' ) . ')</td>';
				}
				$all_html .= '</tr>';

				if ( 'runs-scored' === $event->game_info_type ) {
					$score_html .= '<tr style="' . $table_row_styles . '">';
					$score_html .= '<td class="score">' . $logo . '<br />' . $event->game_info_top_bottom . ' ' . $event->game_info_inning . '<span class="event-id">' . $event->game_info_id . '</span></td>';
					$score_html .= '<td class="score">' . $event->game_info_away_score . '</td>';
					$score_html .= '<td class="score">' . $event->game_info_home_score . '</td>';
					$score_html .= '<td>' . $event->game_info_play . '(' . $event->game_info_count . ')</td>';
					$score_html .= '</tr>';
				}
			}
		}

		$data = [ $all_html, $event_ids, $score_html ];

		wp_send_json_success( $data );
		wp_die();
	}
}
