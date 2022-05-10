<?php
/**
 * Creates the standings class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The core standings class.
 *
 * This is used for the standings in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Standings {

	/**
	 * Creates the new Standings object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

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
	public function sports_bench_do_team_division_standings( $html, $teams, $division, $sport ) {

		$standings = [];
		if ( 'soccer' === $sport || 'rugby' === $sport ) {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'       => $the_team->get_team_id(),
					'team_link'     => $the_team->get_permalink(),
					'team_location' => $the_team->get_team_location(),
					'games_played'  => $the_team->get_games_played( get_option( 'sports-bench-season-year' ) ),
					'wins'          => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'        => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'draws'         => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
					'points'        => sports_bench_get_points( $the_team->get_team_id() ),
				];
				array_push( $standings, $standing );
			}

			foreach ( $standings as $key => $row ) {
				$points[ $key ] = $row['points'];
			}
			array_multisort( $points, SORT_DESC, $standings );

			/**
			 * Adds styles for the header row of the standings table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The current styles for the row.
			 * @param array  $division      The information for the division.
			 * @return string               The styles for the table's header row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', $division );

			$html  = '<table class="standings">';
			$html .= '<thead>';
			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<th></th>';
			$html .= '<th>' . esc_html__( 'GP', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'D', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

				$html .= '<tr style="' . $table_team_styles . '">';
				$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_location'] . '</a></td>';
				$html .= '<td class="center">' . $team['games_played'] . '</td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['draws'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				$html .= '<td class="center">' . $team['points'] . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} elseif ( 'hockey' === $sport ) {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'           => $the_team->get_team_id(),
					'team_location'     => $the_team->get_team_location(),
					'team_link'         => $the_team->get_permalink(),
					'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'overtime_losses'   => $the_team->get_overtime_losses( get_option( 'sports-bench-season-year' ) ),
					'points'            => sports_bench_get_points( $the_team->get_team_id() ),
				];
				array_push( $standings, $standing );
			}

			foreach ( $standings as $key => $row ) {
				$points[ $key ] = $row['points'];
			}
			array_multisort( $points, SORT_DESC, $standings );

			/**
			 * Adds styles for the header row of the standings table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The current styles for the row.
			 * @param array  $division      The information for the division.
			 * @return string               The styles for the table's header row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', $division );

			$html = '<table class="standings">';
			$html .= '<thead>';
			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<th></th>';
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'OTL', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

				$html .= '<tr styles="' . $table_team_styles . '">';
				$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_location'] . '</a></td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				$html .= '<td class="center">' . $team['overtime_losses'] . '</td>';
				$html .= '<td class="center">' . $team['points'] . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} else {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'           => $the_team->get_team_id(),
					'team_location'     => $the_team->get_team_location(),
					'team_link'         => $the_team->get_permalink(),
					'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'draws'             => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
					'win_percentage'    => $the_team->get_win_percentage( get_option( 'sports-bench-season-year' ) ),
				];
				array_push( $standings, $standing );
			}

			foreach ( $standings as $key => $row ) {
				$percent[ $key ] = $row['win_percentage'];
			}
			array_multisort( $percent, SORT_DESC, $standings );

			$i = 0;
			foreach ( $standings as $team ) {
				$games_back = ( ( $standings[0]['wins'] - $team['wins'] ) + ( $team['losses'] - $standings[0]['losses'] ) ) / 2;
				if ( 0 === $games_back ) {
					$games_back = '&#8212;';
				} else {
					$games_back = number_format( (float) $games_back, 1, '.', '' );
				}
				$standings[ $i ]['games_back'] = $games_back;
				$i++;
			}

			$games_back = [];
			foreach ( $standings as $key => $row ) {
				$games_back[ $key ] = $row['games_back'];
			}
			array_multisort( $games_back, SORT_ASC, $standings );

			/**
			 * Adds styles for the header row of the standings table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles        The current styles for the row.
			 * @param array  $division      The information for the division.
			 * @return string               The styles for the table's header row.
			 */
			$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', $division );

			$html = '<table class="standings">';
			$html .= '<thead>';
			$html .= '<tr style="' . $table_head_styles . '">';
			$html .= '<th></th>';
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'D', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'GB', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PCT', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

				$html .= '<tr style="' . $table_team_styles . '">';
				$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_location'] . '</a></td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['draws'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				if ( 0 === $team['games_back'] ) {
					$html .= '<td class="center">&#8212;</td>';
				} else {
					$html .= '<td class="center">' . $team['games_back'] . '</td>';
				}
				$html .= '<td class="center">' . $team['win_percentage'] . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		return $html;
	}

	/**
	 * Displays the league-wide standings.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the league-wide standings table.
	 */
	public function all_team_standings() {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$querystr = "SELECT * FROM $table WHERE team_active LIKE 'active';";
		$teams    = Database::get_results( $querystr );
		$items    = get_post_meta( get_the_ID(), 'sports_bench_standings_items', true );

		/**
		 * Displays the table for the standings table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the table.
		 * @param array  $teams            The list of teams for the table.
		 * @param int    $division_id      The id for the division. Use 0 if trying to get all teams.
		 * @param string $sport            The sport the website is using.
		 * @param string $type             The type of standings to get. Can use "all", "conference" or "division".
		 * @param array  $items            The array of meta items to add into the standings table, like home record, away record, etc.
		 * @return string                  The HTML for the standings table.
		 */
		$html = apply_filters( 'sports_bench_standings_table', '', $teams, 0, get_option( 'sports-bench-sport' ), 'all', $items );

		return $html;
	}

	/**
	 * Displays the standings for a division or conference.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The division id of the standings to show.
	 * @return string               The HTML for the league-wide standings table.
	 */
	public function conference_division_standings( $division_id ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $division_id );
		$division = Database::get_results( $querystr );

		if ( 'Conference' === $division[0]->division_conference ) {
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division_id );
			$divisions = Database::get_results( $querystr );

			$division_ids   = [];
			$division_ids[] = $division_id;
			foreach ( $divisions as $div ) {
				$division_ids[] = $div->division_id;
			}

			$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$division_ids = implode( ',', $division_ids );
			$querystr     = "SELECT * FROM $table WHERE team_division IN ($division_ids) AND team_active LIKE 'active';";
			$teams        = Database::get_results( $querystr );

		} else {
			global $wpdb;
			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_division = %d AND team_active LIKE 'active';", $division_id );
			$teams    = Database::get_results( $querystr );
		}
		$standings = [];
		$items     = get_post_meta( get_the_ID(), 'sports_bench_standings_items', true );

		/**
		 * Displays the table for the standings table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the table.
		 * @param array  $teams            The list of teams for the table.
		 * @param int    $division_id      The id for the division. Use 0 if trying to get all teams.
		 * @param string $sport            The sport the website is using.
		 * @param string $type             The type of standings to get. Can use "all", "conference" or "division".
		 * @param array  $items            The array of meta items to add into the standings table, like home record, away record, etc.
		 * @return string                  The HTML for the standings table.
		 */
		$html = apply_filters( 'sports_bench_standings_table', '', $teams, $division, get_option( 'sports-bench-sport' ), 'league', $items );

		return $html;
	}

	/**
	 * Displays the standings for widget.
	 *
	 * @since 2.0.0
	 *
	 * @param int|null $division_id      The division id of the standings to show. Leave blank to show the league standings.
	 * @return string                    The HTML for the league-wide standings table.
	 */
	public function widget_standings( $division_id = null ) {
		global $wpdb;
		if ( null === $division_id ) {
			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$querystr = "SELECT * FROM $table WHERE team_active = 'active';";
			$teams    = Database::get_results( $querystr );
			$division = 0;
		} else {
			global $wpdb;
			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr = "SELECT * FROM $table WHERE division_id = $division_id;";
			$division = Database::get_results( $querystr );

			if ( 'Conference' === $division[0]->division_conference ) {
				$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division_id );
				$divisions = Database::get_results( $querystr );

				$division_ids   = [];
				$division_ids[] = $division_id;
				foreach ( $divisions as $div ) {
					$division_ids[] = $div->division_id;
				}

				$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
				$division_ids = implode( ',', $division_ids );
				$querystr     = $wpdb->prepare( "SELECT * FROM $table WHERE team_division IN (%s);", $division_ids );
				$teams        = Database::get_results( $querystr );

			} else {
				global $wpdb;
				$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_division = %d AND team_active = 'active';", $division_id );
				$teams    = Database::get_results( $querystr );
			}
		}

		if ( $teams ) {
			$standings = [];

			/**
			 * Displays the table for the widget standings table.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The incoming HTML for the table.
			 * @param array  $teams            The list of teams for the table.
			 * @param string $sport            The sport the website is using.
			 * @param array  $division         The information for the division or conference.
			 * @return string                  The HTML for the standings table.
			 */
			$html = apply_filters( 'sports_bench_standings_widget', '', $teams, get_option( 'sports-bench-sport' ), $division );
		} else {
			$html = '<p>' . esc_html__( 'Please add teams in order to set up the standings.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Displays the standings page template.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the standings page.
	 */
	public function standings_page_template() {
		$html = '';

		$html .= '<div id="sports-bench-standings">';
		$html .= '<ul aria-controls="sports-bench-standings" role="tablist">';
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) ) {
			$html .= '<li role="tab" aria-controls="league-tab" tabindex="0" aria-selected="true">' . apply_filters( 'sports_bench_league_name', esc_html__( 'League', 'sports-bench' ) ) . '</li>';
		}
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_conference', true ) ) {
			if ( '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) ) {
				$conference_tab_bool = 'true';
			} else {
				$conference_tab_bool = 'false';
			}
			$html .= '<li role="tab" aria-controls="conference-tab" tabindex="0" aria-selected="' . esc_attr( $conference_tab_bool ) . '">' . apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . '</li>';
		}
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_division', true ) ) {
			if ( '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) && '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_conference', true ) ) {
				$division_tab_bool = 'true';
			} else {
				$division_tab_bool = 'false';
			}
			$html .= '<li role="tab" aria-controls="division-tab" tabindex="0" aria-selected="' . esc_attr( $division_tab_bool ) . '">' . apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . '</a></li>';
		}
		$html .= '</ul>';
		$html .= '<div class="tabs-container">';
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) ) {
			$html .= '<div id="league-tab" class="tabs-content" role="tabpanel" aria-expanded="true">';

			/**
			 * Displays styles or elements to be shown before the standings container.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The incoming HTML.
			 * @param string $type             The type of standings being show.
			 * @param int    $division_id      The id for the division or conference.
			 * @return string                  HTML for things to be shown before the standings container.
			 */
			$html .= apply_filters( 'sports_bench_before_standings_container', '', 'all', 0 );
			$html .= '<div class="standings-container">';
			$html .= sports_bench_all_team_standings();
			$html .= '</div>';

			/**
			 * Displays styles or elements to be shown after the standings container.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The incoming HTML.
			 * @param string $type             The type of standings being show.
			 * @param int    $division_id      The id for the division or conference.
			 * @return string                  HTML for things to be shown after the standings container.
			 */
			$html .= apply_filters( 'sports_bench_after_standings_container', '', 'all', 0 );
			$html .= '</div>';
		}
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_conference', true ) ) {
			if ( '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) ) {
				$conference_tab_bool = 'true';
			} else {
				$conference_tab_bool = 'false';
			}
			$html .= '<div id="conference-tab" class="tabs-content" role="tabpanel" aria-expanded="' . esc_attr( $conference_tab_bool ) . '">';
			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr    = "SELECT * FROM $table WHERE division_conference = 'Conference';";
			$conferences = Database::get_results( $querystr );
			foreach ( $conferences as $conference ) {

				/**
				 * Displays styles or elements to be shown before the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The incoming HTML.
				 * @param string $type             The type of standings being show.
				 * @param int    $division_id      The id for the division or conference.
				 * @return string                  HTML for things to be shown before the standings container.
				 */
				$html .= apply_filters( 'sports_bench_before_standings_container', '', 'conference', $conference->division_id );
				$html .= '<div class="standings-container">';
				$html .= sports_bench_conference_division_standings( $conference->division_id );
				$html .= '</div>';

				/**
				 * Displays styles or elements to be shown after the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The incoming HTML.
				 * @param string $type             The type of standings being show.
				 * @param int    $division_id      The id for the division or conference.
				 * @return string                  HTML for things to be shown after the standings container.
				 */
				$html .= apply_filters( 'sports_bench_after_standings_container', '', 'conference', $conference->division_id );
			}
			$html .= '</div>';
		}
		if ( '1' === get_post_meta( get_the_ID(), 'sports_bench_standings_division', true ) ) {
			if ( '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_league', true ) && '0' === get_post_meta( get_the_ID(), 'sports_bench_standings_conference', true ) ) {
				$division_tab_bool = 'true';
			} else {
				$division_tab_bool = 'false';
			}
			$html .= '<div id="division-tab" class="tabs-content" role="tabpanel" aria-expanded="' . esc_attr( $division_tab_bool ) . '">';
			global $wpdb;
			$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$quer       = "SELECT t1.division_id AS conference_id, t1.division_name AS conference_name, t2.division_id AS division_id, t2.division_name AS division_name, t2.division_conference_id AS division_conference_id FROM $table_name AS t1 LEFT JOIN $table_name AS t2 ON t1.division_id = t2.division_conference_id WHERE t2.division_id IS NOT NULL ORDER BY t1.division_id";
			$divisions  = Database::get_results( $quer );
			$conference = '';
			foreach ( $divisions as $division ) {
				if ( null === $division->division_name ) {
					continue;
				}
				if ( $division->conference_name !== $conference ) {
					$html      .= '<h3 class="conference-name">' . $division->conference_name . '</h3>';
					$conference = $division->conference_name;
				}

				/**
				 * Displays styles or elements to be shown before the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The incoming HTML.
				 * @param string $type             The type of standings being show.
				 * @param int    $division_id      The id for the division or conference.
				 * @return string                  HTML for things to be shown before the standings container.
				 */
				$html .= apply_filters( 'sports_bench_before_standings_container', '', 'division', $division->division_id );
				$html .= '<div class="standings-container">';
				$html .= sports_bench_conference_division_standings( $division->division_id );
				$html .= '</div>';

				/**
				 * Displays styles or elements to be shown after the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The incoming HTML.
				 * @param string $type             The type of standings being show.
				 * @param int    $division_id      The id for the division or conference.
				 * @return string                  HTML for things to be shown after the standings container.
				 */
				$html .= apply_filters( 'sports_bench_after_standings_container', '', 'division', $division->division_id );
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the table for the widget standings table.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html             The incoming HTML for the table.
	 * @param array  $teams            The list of teams for the table.
	 * @param string $sport            The sport the website is using.
	 * @param array  $division         The information for the division or conference.
	 * @return string                  The HTML for the standings table.
	 */
	public function sports_bench_do_standings_widget( $html, $teams, $sport, $division ) {

		$standings = [];

		if ( 'soccer' === $sport || 'rugby' === $sport ) {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'        => $the_team->get_team_id(),
					'team_name'      => $the_team->get_team_name(),
					'games_played' => $the_team->get_games_played( get_option( 'sports-bench-season-year' ) ),
					'wins'         => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'       => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'draws'        => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
					'points'       => sports_bench_get_points( $the_team->get_team_id() ),
				];
				array_push( $standings, $standing );
			}
			foreach ( $standings as $key => $row ) {
				$points[ $key ] = $row['points'];
			}
			array_multisort( $points, SORT_DESC, $standings );

			$html = '<table class="standings">';
			if ( 0 === $division ) {

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', 0 );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th></th>';
			} else {

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', $division[0] );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th class="left">' . $division[0]->division_name . '</th>';
			}
			$html .= '<th>' . esc_html__( 'GP', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'D', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_widget_team_row', '', $team['team_id'] );

				$html .= '<tr style="' . $table_team_styles . '">';
				$html .= '<td>' . $team['team_name'] . '</td>';
				$html .= '<td class="center">' . $team['games_played'] . '</td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['draws'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				$html .= '<td class="center">' . $team['points'] . '</td>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} elseif ( 'hockey' === $sport ) {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'         => $the_team->get_team_id(),
					'team_name'       => $the_team->get_team_name(),
					'wins'            => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'          => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'overtime_losses' => $the_team->get_overtime_losses( get_option( 'sports-bench-season-year' ) ),
					'points'          => sports_bench_get_points( $the_team->get_team_id() ),
				];
				array_push( $standings, $standing );
			}

			foreach ( $standings as $key => $row ) {
				$points[ $key ] = $row['points'];
			}
			array_multisort( $points, SORT_DESC, $standings );

			if ( 0 === $division ) {
				$html = '<table class="standings">';

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', 0 );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th></th>';
			} else {
				$html = '<table class="standings">';

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', $division[0] );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th class="left">' . $division[0]->division_name . '</th>';
			}
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'OTL', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_widget_team_row', '', $team['team_id'] );

				$html .= '<tr style="' . $table_team_styles . '">';
				$html .= '<td>' . $team['team_name'] . '</td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				$html .= '<td class="center">' . $team['overtime_losses'] . '</td>';
				$html .= '<td class="center">' . $team['points'] . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} else {
			foreach ( $teams as $team ) {
				$the_team = new Team( (int) $team->team_id );
				$standing = [
					'team_id'        => $the_team->get_team_id(),
					'team_name'      => $the_team->get_team_name(),
					'team_link'      => $the_team->get_permalink(),
					'wins'           => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
					'losses'         => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
					'draws'          => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
					'win_percentage' => $the_team->get_win_percentage( get_option( 'sports-bench-season-year' ) ),
				];
				array_push( $standings, $standing );
			}

			foreach ( $standings as $key => $row ) {
				$percent[ $key ] = $row['win_percentage'];
				$wins[ $key ]    = $row['wins'];
				$losses[ $key ]  = $row['losses'];
			}
			array_multisort( $percent, SORT_DESC, $wins, SORT_DESC, $losses, SORT_ASC, $standings );
			$i = 0;
			foreach ( $standings as $team ) {
				$games_back = ( ( $standings[0]['wins'] - $team['wins'] )
								+ ( $team['losses']
									- $standings[0]['losses'] ) ) / 2;
				if ( 0 === $games_back ) {
					$games_back = 0;
				} else {
					$games_back = number_format( (float) $games_back, 1, '.', '' );
				}
				$standings[ $i ]['games_back'] = $games_back;
				$i ++;
			}

			$games_back = [];
			foreach ( $standings as $key => $row ) {
				$games_back[ $key ] = $row['games_back'];
			}
			array_multisort( $games_back, SORT_ASC, $standings );

			if ( 0 === $division ) {
				$html = '<table class="standings">';

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', 0 );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th></th>';
			} else {
				$html = '<table class="standings">';

				/**
				 * Adds styles for the header row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_widget_head_row', '', $division[0] );
				$html             .= '<thead style="' . $table_head_styles . '">';
				$html             .= '<tr>';
				$html             .= '<th class="left">' . $division[0]->division_name . '</th>';
			}
			$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'GB', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'PCT', 'sports-bench' ) . '</th>';
			$html .= '<tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			foreach ( $standings as $team ) {

				/**
				 * Adds styles for a team row of the widget standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles       The current styles for the row.
				 * @param array  $team_id      The id for the team.
				 * @return string              The styles for the team's row.
				 */
				$table_team_styles = apply_filters( 'sports_bench_standings_widget_team_row', '', $team['team_id'] );

				$html .= '<tr style="' . $table_team_styles . '">';
				$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
				$html .= '<td class="center">' . $team['wins'] . '</td>';
				$html .= '<td class="center">' . $team['losses'] . '</td>';
				if ( 0 === $team['games_back'] ) {
					$html .= '<td class="center">&#8212;</td>';
				} else {
					$html .= '<td class="center">' . $team['games_back'] . '</td>';
				}
				$html .= '<td class="center">' . $team['win_percentage'] . '</td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}

		return $html;

	}

	/**
	 * Displays the table for the standings table.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html             The incoming HTML for the table.
	 * @param array  $teams            The list of teams for the table.
	 * @param int    $division_id      The id for the division. Use 0 if trying to get all teams.
	 * @param string $sport            The sport the website is using.
	 * @param string $type             The type of standings to get. Can use "all", "conference" or "division".
	 * @param array  $items            The array of meta items to add into the standings table, like home record, away record, etc.
	 * @return string                  The HTML for the standings table.
	 */
	public function sports_bench_do_standings_table( $html, $teams, $division, $sport, $type, $items ) {

		$standings = [];
		if ( 'soccer' === $sport || 'rugby' === $sport ) {
			if ( 'league' === $type ) {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = [
						'team_id'       => $the_team->get_team_id(),
						'team_name'     => $the_team->get_team_name(),
						'team_link'     => $the_team->get_permalink(),
						'games_played'  => $the_team->get_games_played( get_option( 'sports-bench-season-year' ) ),
						'wins'          => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'        => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'draws'         => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
						'points'        => sports_bench_get_points( $the_team->get_team_id() ),
					];
					if ( $items ) {
						foreach ( $items as $item ) {
							if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
								$standing['goals-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
								$standing['goals-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
								$standing['goal-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'home-record' === $item['sports_bench_standings_items'] ) {
								$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'away-record' === $item['sports_bench_standings_items'] ) {
								$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'division-record' === $item['sports_bench_standings_items'] ) {
								$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
								$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
							}
						}
					}
					array_push( $standings, $standing );
				}
				foreach ( $standings as $key => $row ) {
					$points[ $key ] = $row['points'];
				}
				array_multisort( $points, SORT_DESC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', $division[0] );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th class="left">' . $division[0]->division_name . '</th>';
				$html .= '<th>' . esc_html__( 'GP', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'D', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GF', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GA', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GD', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '</tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

					$html .= '<tr style="' . $table_team_styles . '">';
					$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html .= '<td class="center">' . $team['games_played'] . '</td>';
					$html .= '<td class="center">' . $team['wins'] . '</td>';
					$html .= '<td class="center">' . $team['draws'] . '</td>';
					$html .= '<td class="center">' . $team['losses'] . '</td>';
					$html .= '<td class="center">' . $team['points'] . '</td>';
					if ( isset( $team['goals-for'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-for'] . '</td>';
					}
					if ( isset( $team['goals-against'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-against'] . '</td>';
					}
					if ( isset( $team['goal-differential'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goal-differential'] . '</td>';
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2]  . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			} else {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = array(
						'team_id'       => $the_team->get_team_id(),
						'team_name'     => $the_team->get_team_name(),
						'team_link'     => $the_team->get_permalink(),
						'games_played'  => $the_team->get_games_played( get_option( 'sports-bench-season-year' ) ),
						'wins'          => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'        => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'draws'         => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
						'points'        => sports_bench_get_points( $the_team->get_team_id() ),
					);
					if ( $items ) {
						foreach ( $items as $item ) {
							if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
								$standing['goals-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
								$standing['goals-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
								$standing['goal-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'home-record' === $item['sports_bench_standings_items'] ) {
								$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'away-record' === $item['sports_bench_standings_items'] ) {
								$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'division-record' === $item['sports_bench_standings_items'] ) {
								$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
								$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
							}
						}
					}
					array_push( $standings, $standing );
				}
				foreach ( $standings as $key => $row ) {
					$points[ $key ] = $row['points'];
				}
				array_multisort( $points, SORT_DESC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', 0 );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th></th>';
				$html .= '<th>' . esc_html__( 'GP', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'D', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GF', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GA', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GD', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '<tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

					$html .= '<tr style="' . $table_team_styles . '">';
					$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html .= '<td class="center">' . $team['games_played'] . '</td>';
					$html .= '<td class="center">' . $team['wins'] . '</td>';
					$html .= '<td class="center">' . $team['draws'] . '</td>';
					$html .= '<td class="center">' . $team['losses'] . '</td>';
					$html .= '<td class="center">' . $team['points'] . '</td>';
					if ( isset( $team['goals-for'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-for'] . '</td>';
					}
					if ( isset( $team['goals-against'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-against'] . '</td>';
					}
					if ( isset( $team['goal-differential'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goal-differential'] . '</td>';
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2] . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			}
		} elseif ( 'hockey' === $sport ) {
			if ( 'league' === $type ) {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = array(
						'team_id'           => $the_team->get_team_id(),
						'team_name'         => $the_team->get_team_name(),
						'team_link'         => $the_team->get_permalink(),
						'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'overtime_losses'   => $the_team->get_overtime_losses( get_option( 'sports-bench-season-year' ) ),
						'points'            => sports_bench_get_points( $the_team->get_team_id() ),
					);
					if ( $items ) {
						foreach ( $items as $item ) {
							if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
								$standing['goals-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
								$standing['goals-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
								$standing['goal-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'home-record' === $item['sports_bench_standings_items'] ) {
								$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'away-record' === $item['sports_bench_standings_items'] ) {
								$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'division-record' === $item['sports_bench_standings_items'] ) {
								$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
								$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
							}
						}
					}
					array_push( $standings, $standing );
				}

				foreach ( $standings as $key => $row ) {
					$points[ $key ] = $row['points'];
				}
				array_multisort( $points, SORT_DESC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', 0 );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th class="left">' . $division[0]->division_name . '</th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'OTL', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GF', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GA', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GD', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '<tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

					$html .= '<tr style="' . $table_team_styles . '">';
					$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html .= '<td class="center">' . $team['wins'] . '</td>';
					$html .= '<td class="center">' . $team['losses'] . '</td>';
					$html .= '<td class="center">' . $team['overtime_losses'] . '</td>';
					$html .= '<td class="center">' . $team['points'] . '</td>';
					if ( isset( $team['goals-for'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-for'] . '</td>';
					}
					if ( isset( $team['goals-against'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-against'] . '</td>';
					}
					if ( isset( $team['goal-differential'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goal-differential'] . '</td>';
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2] . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			} else {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = [
						'team_id'           => $the_team->get_team_id(),
						'team_name'         => $the_team->get_team_name(),
						'team_link'         => $the_team->get_permalink(),
						'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'overtime_losses'   => $the_team->get_overtime_losses( get_option( 'sports-bench-season-year' ) ),
						'points'            => sports_bench_get_points( $the_team->get_team_id() ),
					];
					if ( $items ) {
						foreach ( $items as $item ) {
							if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
								$standing['goals-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
								$standing['goals-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
								$standing['goal-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'home-record' === $item['sports_bench_standings_items'] ) {
								$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'away-record' === $item['sports_bench_standings_items'] ) {
								$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'division-record' === $item['sports_bench_standings_items'] ) {
								$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
							}
							if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
								$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
							}
						}
					}
					array_push( $standings, $standing );
				}

				foreach ( $standings as $key => $row ) {
					$points[ $key ] = $row['points'];
				}
				array_multisort( $points, SORT_DESC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', 0 );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th></th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'OTL', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PTS', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'goals-for' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GF', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-against' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GA', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'goals-differential' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'GD', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '<tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

					$html .= '<tr style="' . $table_team_styles . '">';
					$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html .= '<td class="center">' . $team['wins'] . '</td>';
					$html .= '<td class="center">' . $team['losses'] . '</td>';
					$html .= '<td class="center">' . $team['overtime_losses'] . '</td>';
					$html .= '<td class="center">' . $team['points'] . '</td>';
					if ( isset( $team['goals-for'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-for'] . '</td>';
					}
					if ( isset( $team['goals-against'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goals-against'] . '</td>';
					}
					if ( isset( $team['goal-differential'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['goal-differential'] . '</td>';
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2] . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			}
		} else {
			if ( 'league' === $type ) {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = [
						'team_id'           => $the_team->get_team_id(),
						'team_name'         => $the_team->get_team_name(),
						'team_link'         => $the_team->get_permalink(),
						'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'draws'             => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
						'win_percentage'    => $the_team->get_win_percentage( get_option( 'sports-bench-season-year' ) ),
					];
					if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
						if ( $items ) {
							foreach ( $items as $item ) {
								if ( 'runs-for' === $item['sports_bench_standings_items'] ) {
									$standing['runs-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'runs-against' === $item['sports_bench_standings_items'] ) {
									$standing['runs-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'run-differential' === $item['sports_bench_standings_items'] ) {
									$standing['run-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'home-record' === $item['sports_bench_standings_items'] ) {
									$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'away-record' === $item['sports_bench_standings_items'] ) {
									$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'division-record' === $item['sports_bench_standings_items'] ) {
									$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
									$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
								}
							}
						}
					} else {
						if ( $items ) {
							foreach ( $items as $item ) {
								if ( 'points-for' === $item['sports_bench_standings_items'] ) {
									$standing['points-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'points-against' === $item['sports_bench_standings_items'] ) {
									$standing['points-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'points-differential' === $item['sports_bench_standings_items'] ) {
									$standing['points-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'home-record' === $item['sports_bench_standings_items'] ) {
									$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'away-record' === $item['sports_bench_standings_items'] ) {
									$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'division-record' === $item['sports_bench_standings_items'] ) {
									$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
									$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
								}
							}
						}
					}
					array_push( $standings, $standing );
				}

				foreach ( $standings as $key => $row ) {
					$percent[ $key ] = $row['win_percentage'];
					$wins[ $key ]    = $row['wins'];
					$losses[ $key ]  = $row['losses'];
				}
				array_multisort( $percent, SORT_DESC, $wins, SORT_DESC, $losses, SORT_ASC, $standings );

				$i = 0;
				foreach ( $standings as $team ) {
					$games_back = ( ( $standings[0]['wins'] - $team['wins'] ) + ( $team['losses'] - $standings[0]['losses'] ) ) / 2;
					if ( 0 === $games_back ) {
						$games_back = 0;
					} else {
						$games_back = number_format( (float) $games_back, 1, '.', '' );
					}
					$standings[ $i ]['games_back'] = $games_back;
					$i++;
				}

				$games_back = [];
				foreach ( $standings as $key => $row ) {
					$games_back[ $key ] = $row['games_back'];
				}
				array_multisort( $games_back, SORT_ASC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', $division[0] );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th class="left">' . $division[0]->division_name . '</th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'GB', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PCT', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'runs-for' === $item['sports_bench_standings_items'] || 'points-for' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RF', 'sports-bench' ) . '</th>';
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PF', 'sports-bench' ) . '</th>';
							}
						}
						if ( 'runs-against' === $item['sports_bench_standings_items'] || 'points-against' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RA', 'sports-bench' ) . '</th>';
								continue;
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PF', 'sports-bench' ) . '</th>';
								continue;
							}
						}
						if ( 'run-differential' === $item['sports_bench_standings_items'] || 'points-differential' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RD', 'sports-bench' ) . '</th>';
								continue;
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PD', 'sports-bench' ) . '</th>';
								continue;
							}
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '<tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );
					$html             .= '<tr style="' . $table_team_styles . '">';
					$html             .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html             .= '<td class="center">' . $team['wins'] . '</td>';
					$html             .= '<td class="center">' . $team['losses'] . '</td>';
					if ( 0 === $team['games_back'] ) {
						$html .= '<td class="center">&#8212;</td>';
					} else {
						$html .= '<td class="center">' . $team['games_back'] . '</td>';
					}
					$html .= '<td class="center">' . $team['win_percentage'] . '</td>';
					if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
						if ( isset( $team['runs-for'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['runs-for'] . '</td>';
						}
						if ( isset( $team['runs-against'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['runs-against'] . '</td>';
						}
						if ( isset( $team['run-differential'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['run-differential'] . '</td>';
						}
					} else {
						if ( isset( $team['points-for'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-for'] . '</td>';
						}
						if ( isset( $team['points-against'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-against'] . '</td>';
						}
						if ( isset( $team['points-differential'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-differential'] . '</td>';
						}
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2] . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			} else {
				foreach ( $teams as $team ) {
					$the_team = new Team( (int) $team->team_id );
					$standing = [
						'team_id'           => $the_team->get_team_id(),
						'team_name'         => $the_team->get_team_name(),
						'team_link'         => $the_team->get_permalink(),
						'wins'              => $the_team->get_wins( get_option( 'sports-bench-season-year' ) ),
						'losses'            => $the_team->get_losses( get_option( 'sports-bench-season-year' ) ),
						'draws'             => $the_team->get_draws( get_option( 'sports-bench-season-year' ) ),
						'win_percentage'    => $the_team->get_win_percentage( get_option( 'sports-bench-season-year' ) ),
					];
					if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
						if ( $items ) {
							foreach ( $items as $item ) {
								if ( 'runs-for' === $item['sports_bench_standings_items'] ) {
									$standing['runs-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'runs-against' === $item['sports_bench_standings_items'] ) {
									$standing['runs-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'run-differential' === $item['sports_bench_standings_items'] ) {
									$standing['run-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'home-record' === $item['sports_bench_standings_items'] ) {
									$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'away-record' === $item['sports_bench_standings_items'] ) {
									$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'division-record' === $item['sports_bench_standings_items'] ) {
									$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
									$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
								}
							}
						}
					} else {
						if ( $items ) {
							foreach ( $items as $item ) {
								if ( 'points-for' === $item['sports_bench_standings_items'] ) {
									$standing['points-for'] = $the_team->get_points_for( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'points-against' === $item['sports_bench_standings_items'] ) {
									$standing['points-against'] = $the_team->get_points_against( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'points-differential' === $item['sports_bench_standings_items'] ) {
									$standing['points-differential'] = $the_team->get_point_differential( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'home-record' === $item['sports_bench_standings_items'] ) {
									$standing['home-record'] = $the_team->get_home_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'away-record' === $item['sports_bench_standings_items'] ) {
									$standing['away-record'] = $the_team->get_road_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'division-record' === $item['sports_bench_standings_items'] ) {
									$standing['division-record'] = $the_team->get_division_record( get_option( 'sports-bench-season-year' ) );
								}
								if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
									$standing['conference-record'] = $the_team->get_conference_record( get_option( 'sports-bench-season-year' ) );
								}
							}
						}
					}
					array_push( $standings, $standing );
				}

				foreach ( $standings as $key => $row ) {
					$percent[ $key ] = $row['win_percentage'];
					$wins[ $key ]    = $row['wins'];
					$losses[ $key ]  = $row['losses'];
				}
				array_multisort( $percent, SORT_DESC, $wins, SORT_DESC, $losses, SORT_ASC, $standings );

				$i = 0;
				foreach ( $standings as $team ) {
					$games_back = ( ( $standings[0]['wins'] - $team['wins'] ) + ( $team['losses'] - $standings[0]['losses'] ) ) / 2;
					if ( 0 === $games_back ) {
						$games_back = 0;
					} else {
						$games_back = number_format( (float) $games_back, 1, '.', '' );
					}
					$standings[ $i ]['games_back'] = $games_back;
					$i++;
				}

				$games_back = [];
				foreach ( $standings as $key => $row ) {
					$games_back[ $key ] = $row['games_back'];
				}
				array_multisort( $games_back, SORT_ASC, $standings );

				/**
				 * Adds styles for the header row of the standings table.
				 *
				 * @since 2.0.0
				 *
				 * @param string $styles        The current styles for the row.
				 * @param array  $division      The information for the division.
				 * @return string               The styles for the table's header row.
				 */
				$table_head_styles = apply_filters( 'sports_bench_standings_head_row', '', 0 );

				$html  = '<table class="standings">';
				$html .= '<thead>';
				$html .= '<tr style="' . $table_head_styles . '">';
				$html .= '<th></th>';
				$html .= '<th>' . esc_html__( 'W', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'L', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'GB', 'sports-bench' ) . '</th>';
				$html .= '<th>' . esc_html__( 'PCT', 'sports-bench' ) . '</th>';
				if ( $items ) {
					foreach ( $items as $item ) {
						if ( 'runs-for' === $item['sports_bench_standings_items'] || 'points-for' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RF', 'sports-bench' ) . '</th>';
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PF', 'sports-bench' ) . '</th>';
							}
						}
						if ( 'runs-against' === $item['sports_bench_standings_items'] || 'points-against' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RA', 'sports-bench' ) . '</th>';
								continue;
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PF', 'sports-bench' ) . '</th>';
								continue;
							}
						}
						if ( 'run-differential' === $item['sports_bench_standings_items'] || 'points-differential' === $item['sports_bench_standings_items'] ) {
							if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'RD', 'sports-bench' ) . '</th>';
								continue;
							} else {
								$html .= '<th class="sb-show-for-medium">' . esc_html__( 'PD', 'sports-bench' ) . '</th>';
								continue;
							}
						}
						if ( 'home-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'HOME', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'away-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'AWAY', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'division-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'DIV', 'sports-bench' ) . '</th>';
							continue;
						}
						if ( 'conference-record' === $item['sports_bench_standings_items'] ) {
							$html .= '<th class="sb-show-for-medium">' . esc_html__( 'CONF', 'sports-bench' ) . '</th>';
							continue;
						}
					}
				}
				$html .= '<tr>';
				$html .= '</thead>';
				$html .= '<tbody>';
				foreach ( $standings as $team ) {

					/**
					 * Adds styles for a team row of the standings table.
					 *
					 * @since 2.0.0
					 *
					 * @param string $styles       The current styles for the row.
					 * @param array  $team_id      The id for the team.
					 * @return string              The styles for the team's row.
					 */
					$table_team_styles = apply_filters( 'sports_bench_standings_team_row', '', $team['team_id'] );

					$html .= '<tr style="'. $table_team_styles . '">';
					$html .= '<td><a href="' . $team['team_link'] . '">' . $team['team_name'] . '</a></td>';
					$html .= '<td class="center">' . $team['wins'] . '</td>';
					$html .= '<td class="center">' . $team['losses'] . '</td>';
					if ( 0 === $team['games_back'] ) {
						$html .= '<td class="center">&#8212;</td>';
					} else {
						$html .= '<td class="center">' . $team['games_back'] . '</td>';
					}
					$html .= '<td class="center">' . $team['win_percentage'] . '</td>';
					if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
						if ( isset( $team['runs-for'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['runs-for'] . '</td>';
						}
						if ( isset( $team['runs-against'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['runs-against'] . '</td>';
						}
						if ( isset( $team['run-differential'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['run-differential'] . '</td>';
						}
					} else {
						if ( isset( $team['points-for'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-for'] . '</td>';
						}
						if ( isset( $team['points-against'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-against'] . '</td>';
						}
						if ( isset( $team['points-differential'] ) ) {
							$html .= '<td class="center sb-show-for-medium">' . $team['points-differential'] . '</td>';
						}
					}
					if ( isset( $team['home-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['home-record'][0] . '-' . $team['home-record'][1] . '-' . $team['home-record'][2] . '</td>';
					}
					if ( isset( $team['away-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['away-record'][0] . '-' . $team['away-record'][1] . '-' . $team['away-record'][2] . '</td>';
					}
					if ( isset( $team['division-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['division-record'][0] . '-' . $team['division-record'][1] . '-' . $team['division-record'][2] . '</td>';
					}
					if ( isset( $team['conference-record'] ) ) {
						$html .= '<td class="center sb-show-for-medium">' . $team['conference-record'][0] . '-' . $team['conference-record'][1] . '-' . $team['conference-record'][2] . '</td>';
					}
					$html .= '</tr>';
				}
				$html .= '</tbody>';
				$html .= '</table>';
			}
		}

		return $html;
	}

	/**
	 * Displays the league-wide standings for the standings block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the standings table.
	 */
	public function all_teams_standings_gutenberg( $attributes ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$querystr = "SELECT * FROM $table WHERE team_active LIKE 'active';";
		$teams    = Database::get_results( $querystr );
		$items    = [];

		foreach ( $attributes as $attribute ) {
			$item = [
				'sports_bench_standings_items' => $attribute['value'],
			];
			array_push( $items, $item );
		}

		/**
		 * Displays the table for the standings table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the table.
		 * @param array  $teams            The list of teams for the table.
		 * @param int    $division_id      The id for the division. Use 0 if trying to get all teams.
		 * @param string $sport            The sport the website is using.
		 * @param string $type             The type of standings to get. Can use "all", "conference" or "division".
		 * @param array  $items            The array of meta items to add into the standings table, like home record, away record, etc.
		 * @return string                  The HTML for the standings table.
		 */
		$html = apply_filters( 'sports_bench_standings_table', '', $teams, 0, get_option( 'sports-bench-sport' ), 'all', $items );

		return $html;
	}

	/**
	 * Displays the division/conference standings for the standings block.
	 *
	 * @since 2.0.0
	 *
	 * @param int   $division_id      The id for the division.
	 * @param array $attributes       The attributes for the block.
	 * @return string                 The HTML for the standings table.
	 */
	public function conference_division_standings_gutenberg( $division_id, $attributes ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $division_id );
		$division = Databse::get_results( $querystr );
		$items    = [];

		foreach ( $attributes as $attribute ) {
			$item = [
				'sports_bench_standings_items' => $attribute['value']
			];
			array_push( $items, $item );
		}

		if ( 'Conference' === $division[0]->division_conference ) {
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division_id );
			$divisions = Database::get_results( $querystr );

			$division_ids   = [];
			$division_ids[] = $division_id;
			foreach ( $divisions as $div ) {
				$division_ids[] = $div->division_id;
			}

			$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$division_ids = implode( ',', $division_ids );
			$querystr     = $wpdb->prepare( "SELECT * FROM $table WHERE team_division IN (%s) AND team_active LIKE 'active';", $division_ids );
			$teams        = Database::get_results( $querystr );

		} else {
			global $wpdb;
			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_division = %d AND team_active LIKE 'active';", $division_id );
			$teams    = Database::get_results( $querystr );
		}
		$standings = [];

		/**
		 * Displays the table for the standings table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the table.
		 * @param array  $teams            The list of teams for the table.
		 * @param int    $division_id      The id for the division. Use 0 if trying to get all teams.
		 * @param string $sport            The sport the website is using.
		 * @param string $type             The type of standings to get. Can use "all", "conference" or "division".
		 * @param array  $items            The array of meta items to add into the standings table, like home record, away record, etc.
		 * @return string                  The HTML for the standings table.
		 */
		$html = apply_filters( 'sports_bench_standings_table', '', $teams, $division, get_option( 'sports-bench-sport' ), 'league', $items );

		return $html;
	}

}
