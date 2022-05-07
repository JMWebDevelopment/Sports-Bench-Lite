<?php
/**
 * Creates the teams class.
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

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * The core teams class.
 *
 * This is used for the teams in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Teams {

	/**
	 * Creates the new Teams object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Gets a list of teams.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $alphabetical      Whether the list should be alphabetical or not.
	 * @param bool $active            Whether to only include active teams or all teams.
	 * @param int  $division_id       The id of the division to get teams from. Leave blank or use 0 to get all teams regardless of division.
	 * @return array                  List of teams.
	 */
	public function get_teams( $alphabetical = false, $active = true, $division_id = 0 ) {
		global $wpdb;
		$teams_array = [];
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		if ( true === $alphabetical ) {
			$order = 'team_name';
		} else {
			$order = 'team_id';
		}

		if ( true === $active ) {
			$active = "WHERE team_active LIKE 'active'";
		} else {
			$active = '';
		}

		if ( $division_id > 0 && true === $active ) {
			$division = 'AND team_division = ' . $division_id;
		} elseif ( $division_id > 0 && '' === $active ) {
			$division = 'WHERE team_division = ' . $division_id;
		} else {
			$division = '';
		}

		$querystr = "SELECT * FROM $table $active $division ORDER BY $order ASC";
		$teams    = Database::get_results( $querystr );

		if ( null === $teams && $division_id > 0 ) {
			$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division_id );
			$divisions = Database::get_results( $querystr );

			$division_ids = [];
			$division_ids[] = $division_id;
			foreach ( $divisions as $div ) {
				$division_ids[] = $div->division_id;
			}

			if ( '' !== $active ) {
				$where = "AND team_active LIKE 'active'";
			} else {
				$where = '';
			}

			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_division IN (%s) $where;", implode( ',', $division_ids ) );
			$teams    = Database::get_results( $querystr );
		}

		foreach ( $teams as $team ) {
			$the_team                                = new Team( (int) $team->team_id );
			$teams_array[ $the_team->get_team_id() ] = $the_team->get_team_name();
		}
		return $teams_array;
	}

	/**
	 * Displays the listing information for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The current HTML for the filter.
	 * @param int    $team_id        The id for the team to show the listing for.
	 * @param string $team_name      The name of the team to show the listing for.
	 * @param int    $num_teams      The number of teams that are being shown.
	 * @param int    $count          The counter for the current number of iterations for the loop (minus one).
	 * @return string                HTML for the team listing.
	 */
	public function sports_bench_do_team_listing_info( $html, $team_id, $team_name, $num_teams, $count ) {
		$current_team = new Team( (int) $team_id );

		/**
		 * Adds in the styles and elements before the team listing.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html              The incoming HTML for the filter.
		 * @param Team   $current_team      The team object for the current team.
		 * @return string                   The styles and elements for before the listing.
		 */
		$html .= apply_filters( 'sports_bench_before_team_listing', '', $current_team );
		$html .= '<div class="team-info clearfix">';

		$html .= '<h3 class="team-name">' . esc_html( $team_name ) . '</h3>';

		$html .= '<div class="right">';
		$html .= $current_team->get_team_photo( 'team-logo' );
		$html .= '</div>';

		$html .= '<p>';
		$html .= $current_team->get_division_name() . '<br />';
		$html .= esc_html__( 'Location', 'sports-bench' ) . ': ' . $current_team->get_team_city() . ', ' . $current_team->get_team_state() . '<br />';
		$html .= esc_html__( 'Stadium', 'sports-bench' ) . ': ' . $current_team->get_team_stadium() . '<br />';
		$html .= esc_html__( 'Head Coach', 'sports-bench' ) . ': ' . $current_team->get_team_head_coach() . '<br />';
		$html .= '</p>';

		$html .= '<a class="button" href="' . esc_attr( $current_team->get_permalink() ) . '">' . esc_html__( 'View Team', 'sports-bench' ) . '</a>';

		$html .= '</div>';

		/**
		 * Adds in the styles and elements after the team listing.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html              The incoming HTML for the filter.
		 * @param Team   $current_team      The team object for the current team.
		 * @return string                   The styles and elements for after the listing.
		 */
		$html .= apply_filters( 'sports_bench_after_team_listing', '', $current_team );
		$count++;

		return $html;
	}

	/**
	 * Displays the schedule for a given team.
	 *
	 * @since 2.0.0
	 *
	 * @param int         $team_id     The id for the team to get the schedule.
	 * @param string|null $season      The season to get the schedule for.
	 * @return string                  The HTML for the team schedule.
	 */
	public function show_team_schedule( $team_id, $season = '' ) {
		$html = '';
		$team = new Team( (int) $team_id );
		if ( '' === $season ) {
			$season = get_option( 'sports-bench-season-year' );
		}
		$schedule = $team->get_schedule( $season );

		/**
		 * Creates the schedule for the team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The incoming HTML for the schedule.
		 * @param array  $schedule      The list of games for the schedule.
		 * @param int    $team_id       The id of the team the schedule is for.
		 * @return string               HTML for the team schedule table.
		 */
		$html .= apply_filters( 'sports_bench_schedule_table', $html, $schedule, $team_id );

		return $html;
	}

	/**
	 * Creates the schedule for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The incoming HTML for the schedule.
	 * @param array  $schedule      The list of games for the schedule.
	 * @param int    $team_id       The id of the team the schedule is for.
	 * @return string               HTML for the team schedule table.
	 */
	public function sports_bench_do_schedule_table( $html, $schedule, $team_id ) {
		$html .= '<table id="team-schedule">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the schedule table header row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles       The incoming styles for the row.
		 * @param int    $team_id      The id of the team the schedule is for.
		 * @return string              The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_schedule_head_row', '', $team_id );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th colspan="2">' . esc_html__( 'Opponent', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Date', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Score', 'sports-bench' ) . '</th>';
		$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Box Score for Game', 'sports-bench' ) . '</span></th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $schedule as $game ) {
			$opponent = new Team( (int) $game['opponent'] );
			if ( 0 === $game['neutral_site'] ) {
				if ( 'away' === $game['location'] ) {
					$location = esc_html__( 'at ', 'sports-bench' );
				} else {
					$location = '';
				}
			} else {
				$location = 'vs. ';
			}
			$date = strtotime( $game['date'] );
			if ( null !== $game['team_score'] && null !== $game['opponent_score'] ) {
				$result = $game['result'] . ' ' . $game['team_score'] . '&#8211;' . $game['opponent_score'];
			} else {
				$result = '';
			}
			if ( $game['box_score'] ) {
				$box_score = '<a href="' . $game['box_score'] . '">' . esc_html__( 'Box Score', 'sports-bench' ) . '</a>';
			} else {
				$box_score = '';
			}

			/**
			 * Adds in styles for the schedule table game row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The incoming styles for the row.
			 * @param int    $team_id       The id of the team the schedule is for.
			 * @param Team   $opponent      The team object for the opponent.
			 * @return string               The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_team_schedule_game_row', '', $team_id, $opponent );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td><a href="' . $opponent->get_permalink() . '">' . $opponent->get_team_photo( 'team-logo' ) . '</a></td>';
			$html .= '<td><a href="' . $opponent->get_permalink() . '">' . $location . $opponent->get_team_location() . '</a></td>';
			$html .= '<td class="center">' . date( 'M j', $date ) . '</td>';
			$html .= '<td class="center">' . $result . '</td>';
			$html .= '<td class="center">' . $box_score . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Displays the information about the team for the shortcode.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html        The current HTML for the filter.
	 * @param Team   $team        The Team object the shortcode is for.
	 * @param array  $record      The record for the team.
	 * @return string             The HTML to show the information about the team.
	 */
	public function sports_bench_do_team_shortcode_information( $html, $team, $record ) {
		$html .= '<div id="team-photo">';
		$html .= '<a href="' . $team->get_permalink() . '">' . $team->get_team_photo( 'team-logo' ) . '</a>';
		$html .= '</div>';
		$html .= '<div id="team-info">';
		$html .= '<h2 class="team-name"><a href="' . $team->get_permalink() . '">' . $team->get_team_name() . '</a></h2>';
		$html .= '<p class="team-location">' . $team->get_team_city() . ', ' . $team->get_team_state() . '</p>';
		$html .= '<p class="team-stadium">' . $team->get_team_stadium() . '</p>';
		$html .= '<p class="team-coach">' . $team->get_team_head_coach() . '</p>';
		$html .= '<p class="team-record">' . $record[0] . '-' . $record[1] . '-' . $record[2] . '</p>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the last five game results for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The current HTML for the filter.
	 * @param Team   $team          The Team object the shortcode is for.
	 * @param array  $schedule      The array of recent games for the team.
	 * @return string               The HTML to show the recent games for the team.
	 */
	public function sports_bench_do_team_shortcode_recent_games( $html, $team, $schedule ) {
		$html .= '<table id="team-recent-schedule">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the recent games table header row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The id of the team the recent games are for.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_shortcode_recent_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th colspan="2" class="left">' . esc_html__( 'Recent Results', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Score', 'sports-bench' ) . '</th>';
		$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Box Score for Game', 'sports-bench' ) . '</span></th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $schedule as $game ) {
			$opponent = new Team( (int) $game['opponent'] );
			if ( 'away' === $game['location'] ) {
				$location = esc_html__( 'at ', 'sports-bench' );
			} else {
				$location = '';
			}

			if ( null !== $game['team_score'] && null !== $game['opponent_score'] ) {
				$score = $game['result'] . ' ' . $game['team_score'] . '&#8211;' . $game['opponent_score'];
			} else {
				$score = '';
			}

			if ( $game['box_score'] ) {
				$box_score = '<a href="' . $game['box_score'] . '">' . esc_html__( 'Box Score', 'sports-bench' ) . '</a>';
			} else {
				$box_score = '';
			}

			/**
			 * Adds in styles for the recent games table row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The incoming styles for the row.
			 * @param Team   $opponent      The team object for the opponent.
			 * @return string               The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_team_shortcode_recent_row', '', $opponent );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $opponent->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td>' . $location . $opponent->get_team_location() . '</td>';
			$html .= '<td class="center">' . $score . '</td>';
			$html .= '<td class="center">' . $box_score . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Displays the next five games for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The current HTML for the filter.
	 * @param Team   $team          The Team object the shortcode is for.
	 * @param array  $schedule      The array of upcoming games for the team.
	 * @return string               The HTML to show the upcoming games for the team.
	 */
	public function sports_bench_do_team_shortcode_upcoming_games( $html, $team, $schedule ) {
		$html .= '<table id="team-upcoming-schedule">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the upcoming games table header row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The id of the team the upcoming games are for.
		 * @return string             The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_shortcode_upcoming_head_row', '', $team );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th colspan="2" class="left">' . esc_html__( 'Upcoming Games', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Date', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $schedule as $game ) {
			$opponent = new Team( (int) $game['opponent'] );
			if ( 'away' === $game['location'] ) {
				$location = esc_html__( 'at ', 'sports-bench' );
			} else {
				$location = '';
			}
			$date = strtotime( $game['date'] );

			/**
			 * Adds in styles for the upcoming games table row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The incoming styles for the row.
			 * @param Team   $opponent      The team object for the opponent.
			 * @return string               The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_team_shortcode_upcoming_row', '', $opponent );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $opponent->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td>' . $location . $opponent->get_team_location() . '</td>';
			$html .= '<td class="center">' . date( 'g:i a, M j', $date ) . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Displays the team stats for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param Team   $team        The team object for the team to get stats from.
	 * @param string $season      The season to get the stats from.
	 * @return string             The HTML for the team stats table.
	 */
	public function team_season_stats( $team, $season ) {
		$stats_array = $team->get_team_season_stats( $season );

		/**
		 * Creates the table for the team stats.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the table.
		 * @param Team   $team             The team object for the team to show the stats for.
		 * @param string $season           The season to show the stats from.
		 * @param array  $stats_array      The array of team stats to show.
		 * @return string                  The HTML for the team stats table.
		 */
		return apply_filters( 'sports_bench_team_season_stats', '', $team, $season, $stats_array );
	}

	/**
	 * Gets the player stats for a team for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $team_id     The id of the team to get the stats for.
	 * @param string $season      The season to get the stats from.
	 * @return string             The player stats for a team.
	 */
	public function get_players_stats( $team_id, $season ) {

		/**
		 * Gets the player stats for a team for a given season.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html        The incoming HTML for the player stats.
		 * @param int    $team_id     The id of the team to get the stats for.
		 * @param string $season      The season to get the stats from.
		 * @return string             The player stats for a team.
		 */
		return apply_filters( 'sports_bench_team_player_stats', '', $team_id, $season );
	}

	/**
	 * Displays the player stats table for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param array $player_stats_array      The array of player stats to show.
	 * @return string                        The table of player stats.
	 */
	public function get_players_stats_table( $player_stats_array ) {
		$html = '';

		/**
		 * Creates the player stats table for a team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html                    The incoming HTML for the player stats.
		 * @param array  $player_stats_array      The array of player stats to show.
		 * @param string $sport                   The sport the website is using.
		 * @return string                         The player stats table for a team.
		 */
		$html .= apply_filters( 'sports_bench_team_stats_table', $html, $player_stats_array, get_option( 'sports-bench-sport' ) );
		return $html;
	}

	/**
	 * Displays the roster table for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param int         $team_id     The id of the team to get the roster from.
	 * @param string|null $season      The season to get the roster for.
	 * @return string                  The HTML for the roster table.
	 */
	public function show_roster( $team_id, $season = '' ) {
		$html    = '';
		$team    = new Team( (int) $team_id );
		$players = $team->get_roster( $season );

		/**
		 * Creates the table for the team's roster.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The incoming HTML for the filter.
		 * @param array  $players      The list of players for the roster.
		 * @param int    $team_id      The id of the team the roster is for.
		 * @return string              The HTML for the table.
		 */
		$html .= apply_filters( 'sports_bench_team_roster_table', $html, $players, $team_id );

		return $html;
	}

	/**
	 * Creates the table for the team's roster.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html         The incoming HTML for the filter.
	 * @param array  $players      The list of players for the roster.
	 * @param int    $team_id      The id of the team the roster is for.
	 * @return string              The HTML for the table.
	 */
	public function sports_bench_do_team_roster_table( $html, $players, $team_id ) {
		$html .= '<table id="roster">';
		$html .= '<thead>';

		/**
		 * Adds in styles for the team roster table header row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles       The incoming styles for the row.
		 * @param int    $team_id      The id of the team the roster is for.
		 * @return string              The styles for the row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_team_roster_head_row', '', $team_id );

		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th class="left">' . esc_html__( 'Player', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Position', 'sports-bench' ) . '</th>';
		$html .= '<th>' . esc_html__( 'Hometown', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		foreach ( $players as $player ) {

			/**
			 * Adds in styles for the team roster table player row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles       The incoming styles for the row.
			 * @param int    $team_id      The id of the team the roster is for.
			 * @return string              The styles for the row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_team_roster_player_row', '', $team_id );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td><a href="' . $player['player_page'] . '">' . $player['first_name'] . ' ' . $player['last_name'] . '</a></td>';
			$html .= '<td class="center">' . $player['position'] . '</td>';
			$html .= '<td class="center">' . $player['home_city'] . ', ' . $player['home_state'] . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Shows the standings for the division or conference the team is in.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The id for the division the team is in. If you want to get the league standings, use 0.
	 * @return string               The HTML for the standings.
	 */
	public function team_division_standings( $division_id ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_division = %d AND team_active LIKE 'active';", $division_id );
		$teams    = Database::get_results( $querystr );

		/**
		 * Displays the division standings for a team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The incoming HTML for the standings table.
		 * @param array  $teams         The list of teams for the standings.
		 * @param array  $division      The information for the division.
		 * @param string $sport         The sport being used for the website.
		 * @return string               HTML for the standings table.
		 */
		$html = apply_filters( 'sports_bench_team_division_standings', '', $teams, $division_id, get_option( 'sports-bench-sport' ) );

		return $html;
	}

	/**
	 * Shows the information for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $team_id     The id for the team.
	 * @param string $season      The season the listing is for.
	 * @return string             The HTML for the team information.
	 */
	public function show_team_info( $team_id, $season = '' ) {
		$html = '';
		$team = new Team( (int) $team_id );

		/**
		 * Shows the information for a team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html        The incoming HTML for the team info section.
		 * @param Team   $team        The team object for the team.
		 * @param string $season      The season the listing is for.
		 * @return string             The HTML for the team information.
		 */
		$html .= apply_filters( 'sports_bench_team_info', $html, $team, $season );

		return $html;
	}

	/**
	 * Shows the information for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html        The incoming HTML for the team info section.
	 * @param Team   $team        The team object for the team.
	 * @param string $season      The season the listing is for.
	 * @return string             The HTML for the team information.
	 */
	public function sports_bench_do_team_info( $html, $team, $season = '' ) {
		$html .= '<div class="team-info-logo">';
		$html .= $team->get_team_photo( 'team-logo' );
		$html .= '</div>';
		$html .= '<div class="team-info-text">';
		$html .= '<p>';
		if ( get_option( 'sports-bench-season-year' ) === $season ) {
			$html .= esc_html__( 'Location', 'sports-bench' ) . ': ' . $team->get_team_city() . ', ' . $team->get_team_state() . '<br />';
			$html .= esc_html__( 'Stadium', 'sports-bench' ) . ': ' . $team->get_team_stadium() . '<br />';
			$html .= esc_html__( 'Head Coach', 'sports-bench' ) . ': ' . $team->get_team_head_coach() . '<br />';
		}
		$html .= '</p>';

		$seasons = $team->get_seasons();

		if ( $seasons ) {
			$html .= '<ul>';
			foreach ( $seasons as $season ) {
				$html .= '<li><a href="' . esc_attr( $team->get_permalink() . '&team_year=' . $season ) . '">' . wp_kses_post( $season ) . '</a></li>';
			}
			$html .= '</ul>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the teams page template.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the teams page template.
	 */
	public function teams_page_template() {
		$html = '';

		if ( get_query_var( 'team_slug' ) ) {
			$team = new Team( get_query_var( 'team_slug' ) );

			if ( get_query_var( 'team_year' ) ) {
				$season = get_query_var( 'team_year' );
			} else {
				$season = get_option( 'sports-bench-season-year' );
			}

			$html .= '<div class="sports-bench-team-page">';

			if ( $team->get_team_photo_url() ) {
				$html .= '<div class="team-photo">';
				$html .= $team->get_team_photo( 'team-photo' );
				$html .= '</div>';
			}

			$html .= '<div class="team-name">';

			$html .= '<div class="team-logo">';
			$html .= $team->get_team_photo( 'team-logo' );
			$html .= '</div>';

			$html .= '<div class="team-title">';
			$html .= '<h2>' . $team->get_team_name() . '</h2>';
			$html .= '</div>';

			$html .= '</div>';

			$html .= '<div class="stat-section">';
			$html .= '<div id="team-stats" class="team-section">';

			/**
			 * Adds in the styles or elements to be shown before the team stats section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for before the team stats section.
			 */
			$html .= apply_filters( 'sports_bench_before_team_stats', '', $team );
			$html .= '<h3 class="team-section-title">' . $season . ' ' . esc_html__( 'Stats', 'sports-bench' ) . '</h3>';
			$html .= '<h4>' . esc_html__( 'Team', 'sports-bench' ) . '</h4>';
			$html .= sports_bench_team_season_stats( $team, $season );
			$html .= '<h4>' . esc_html__( 'Individual', 'sports-bench' ) . '</h4>';
			$html .= sports_bench_get_players_stats_table( sports_bench_get_players_stats( $team->get_team_id(), $season ) );

			/**
			 * Adds in the styles or elements to be shown after the team stats section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for after the team stats section.
			 */
			$html .= apply_filters( 'sports_bench_after_team_stats', '', $team );
			$html .= '</div>';

			$html .= '<div id="team-roster" class="team-section">';

			/**
			 * Adds in the styles or elements to be shown before the team roster section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for before the team roster section.
			 */
			$html .= apply_filters( 'sports_bench_before_team_roster', '', $team );
			$html .= '<h3 class="team-section-title">' . esc_html__( 'Roster', 'sports-bench' ) . '</h3>';
			$html .= sports_bench_show_roster( $team->get_team_id(), $season );

			/**
			 * Adds in the styles or elements to be shown after the team roster section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for after the team roster section.
			 */
			$html .= apply_filters( 'sports_bench_after_team_roster', '', $team );
			$html .= '</div>';

			$html .= '<div id="team-schedule-info" class="team-section">';

			/**
			 * Adds in the styles or elements to be shown before the team schedule section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for before the team schedule section.
			 */
			$html .= apply_filters( 'sports_bench_before_team_schedule', '', $team );
			$html .= '<h3 class="team-section-title">' . $team->get_team_name() . ' ' . $season . ' ' . esc_html__( 'Schedule', 'sports-bench' ) . '</h3>';
			$html .= sports_bench_show_team_schedule( $team->get_team_id(), $season );

			/**
			 * Adds in the styles or elements to be shown after the team schedule section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for after the team schedule section.
			 */
			$html .= apply_filters( 'sports_bench_after_team_schedule', '', $team );
			$html .= '</div>';

			$html .= '<div id="team-info-section">';

			if ( get_option( 'sports-bench-season-year' ) === $season ) {
				global $wpdb;
				$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $team->get_team_division() );
				$division = Database::get_results( $querystr );
				$html    .= '<div id="team-standings" class="team-section">';

				/**
				 * Adds in the styles or elements to be shown before the team standings section.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The incoming styles.
				 * @param Team   $team        The team object for the team.
				 * @return string             The styles or elements for before the team standings section.
				 */
				$html          .= apply_filters( 'sports_bench_before_team_standings', '', $team );
				$division_title = $division[0]->division_name . ' ' . esc_html__( 'Standings', 'sports-bench' );
				$html          .= '<h4 class="team-section-title">' . $division_title . '</h4>';
				$html          .= sports_bench_team_division_standings( $team->get_team_division() );

				/**
				 * Adds in the styles or elements to be shown after the team standings section.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles      The incoming styles.
				 * @param Team   $team        The team object for the team.
				 * @return string             The styles or elements for after the team standings section.
				 */
				$html .= apply_filters( 'sports_bench_after_team_standings', '', $team );
				$html .= '</div>';
			}

			$html .= '<div id="team-info" class="team-section clearfix">';

			/**
			 * Adds in the styles or elements to be shown before the team info section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for before the team info section.
			 */
			$html .= apply_filters( 'sports_bench_before_team_info', '', $team );
			$html .= '<h3 class="team-section-title">' . esc_html__( 'Team Info', 'sports-bench' ) . '</h3>';
			$html .= '<div class="team-info-section clearfix">';
			$html .= sports_bench_show_team_info( $team->get_team_id(), $season );
			$html .= '</div>';

			/**
			 * Adds in the styles or elements to be shown after the team info section.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles      The incoming styles.
			 * @param Team   $team        The team object for the team.
			 * @return string             The styles or elements for after the team info section.
			 */
			$html .= apply_filters( 'sports_bench_after_team_info', '', $team );
			$html .= '</div>';
			$html .= '</div>';

			$html .= '</div>';

			$html .= '</div>';
		} else {
			$html .= '<div class="sports-bench-teams-page">';
			$html .= sports_bench_show_team_listing();
			$html .= '</div>';
		}

		return $html;

	}

	/**
	 * Gets the number of points in the season for a team in the standings.
	 *
	 * @since 2.0.0
	 *
	 * @param int $team_id      The id of the team to get the points for.
	 * @return int              The number of points for the team.
	 */
	public function get_points( $team_id ) {
		$team = new Team( (int) $team_id );
		if ( 'soccer' === get_option( 'sports-bench-sport' ) || 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$record = $team->get_record( get_option( 'sports-bench-season-year' ) );
			$points = ( (int) $record[0] * 3 ) + (int) $record[2];
			return $points;
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$record = $team->get_record( get_option( 'sports-bench-season-year' ) );
			$points = ( (int) $record[0] * 2 ) + $team->get_overtime_losses( get_option( 'sports-bench-season-year' ) );
			return $points;
		}
		return;
	}

	/**
	 * Gets the total number of points for each team in a volleyball game.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The id of the game to get the points from.
	 * @return array            A list of points for the away and home team in a volleyball game.
	 */
	public function total_points( $game_id ) {
		$game        = new Game( $game_id );
		$home_points = 0;
		$away_points = 0;

		global $wpdb;
		$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $game->get_game_id() );
		$game_info = Database::get_results( $querystr );
		foreach ( $game_info as $info ) {
			$away_points = $info->game_away_first_set + $info->game_away_second_set + $info->game_away_third_set + $info->game_away_fourth_set + $info->game_away_fifth_set;
			$home_points = $info->game_home_first_set + $info->game_home_second_set + $info->game_home_third_set + $info->game_home_fourth_set + $info->game_home_fifth_set;
		}

		$return_array = [
			'away'  => $away_points,
			'home'  => $home_points,
		];

		return $return_array;
	}
}
