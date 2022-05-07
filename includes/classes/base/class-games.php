<?php
/**
 * Creates the game class.
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
class Games {

	/**
	 * Creates the new Teams object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Displays the information about a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html                The current HTML for the filter.
	 * @param Game   $game                The Game object for the game shortcode.
	 * @param Team   $away_team           The team object for the away team.
	 * @param string $away_team_name      The name of the away team.
	 * @param int    $away_score          The score for the away team.
	 * @param Team   $home_team           The team object for the home team.
	 * @param string $home_team_name      The name of the home team.
	 * @param int    $home_score          The score for the home team.
	 * @param string $time_in_game        The current time of the game (or "FINAL" if the game is over).
	 * @param string $location            The location of the game.
	 * @return string                     The HTML to show the information about the game.
	 */
	public function sports_bench_do_game_shortcode_info( $html, $game, $away_team, $away_team_name, $away_score, $home_team, $home_team_name, $home_score, $time_in_game, $location ) {
		if ( 'final' !== $game->get_game_status() ) {
			$time_class = 'scheduled';
		} else {
			$time_class = '';
		}

		/**
		 * Adds in styles for the game shortcode row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles         The incoming styles for the row.
		 * @param int    $game_id        The game id for the shortcode.
		 * @param Team   $away_team      The away team object.
		 * @param Team   $home_team      The home team object.
		 * @return string                The styles for the row.
		 */
		$table_row_styles = apply_filters( 'sports_bench_game_shortcode_game_row', '', $game->get_game_id(), $away_team, $home_team );

		$html .= '<div class="score-info">';
		$html .= '<div class="time"><p>' . $time_in_game . '</p></div>';
		$html .= '<div class="away-team">';
		$html .= '<div class="team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</div>';
		$html .= '<p class="team-name">' . $away_team_name . '</p>';
		$html .= '<p class="team-score">' . $away_score . '</p>';
		$html .= '</div>';
		$html .= '<div class="home-team">';
		$html .= '<div class="team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</div>';
		$html .= '<p class="team-name">' . $home_team_name . '</p>';
		$html .= '<p class="team-score">' . $home_score . '</p>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="location">' . $game->get_full_address() . '</div>';
		$html .= '<a class="button black game-recap-button" href="' . $game->get_box_score_permalink() . '">' . esc_html__( 'View Box Score', 'sports-bench' ) . '</a>';
		if ( 'scheduled' === $game->get_game_status() ) {
			$html .= sports_bench_show_google_maps( $game );
		}
		return $html;
	}

	/**
	 * Displays the information about the rivalry.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html               The current HTML for the filter.
	 * @param int    $game               The first Game object of the rivalry.
	 * @param Team   $team_one           The team object for the first team.
	 * @param string $team_one_name      The name fof the first team.
	 * @param Team   $team_two           The team object for the second team.
	 * @param string $team_two_name      The name fof the second team.
	 * @param string $series_score       The score of the series between the two teams.
	 * @return string                    HTML for the rivalry information.
	 */
	public function sports_bench_do_rivalry_shortcode_info( $html, $game, $team_one, $team_one_name, $team_two, $team_two_name, $series_score ) {

		/**
		 * Adds in the styles for the top row of the rivalry shortcode/block.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles        The current styles for the row.
		 * @param int    $game_id       The id for the game.
		 * @param Team   $team_one      The team object for the first team.
		 * @param Team   $team_two      The team object for the second team.
		 * @return string               The styles for the row.
		 */
		$table_row_styles = apply_filters( 'sports_bench_rivalry_shortcode_top_row', '', $game->game_id, $team_one, $team_two );

		$html .= '<div class="rivalry-info">';
		$html .= '<div class="away-team">';
		$html .= '<div class="team-logo">' . $team_one->get_team_photo( 'team-logo' ) . '</div>';
		$html .= '<p class="team-name">' . $team_one_name . '</p>';
		$html .= '</div>';
		$html .= '<div class="home-team">';
		$html .= '<div class="team-logo">' . $team_two->get_team_photo( 'team-logo' ) . '</div>';
		$html .= '<p class="team-name">' . $team_two_name . '</p>';
		$html .= '</div>';
		$html .= '<div class="series-score"><p>' . $series_score . '</p></div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the most recent games between the two teams.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The current HTML for the filter.
	 * @param array  $games         The list of games between the teams.
	 * @param Team   $team_one      The team object for the first team.
	 * @param Team   $team_two      The team object for the second team.
	 * @return string               HTML for the recent games table.
	 */
	public function sports_bench_do_rivalry_shortcode_recent_game( $html, $games, $team_one, $team_two ) {
		$html .= '<table class="rivalry-recent-results">';

		/**
		 * Adds in styles for the rivalry recent games table header row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles        The incoming styles for the row.
		 * @param Team   $team_one      The team object for the first team.
		 * @param Team   $team_two      The team object for the second team.
		 * @return string               Styles for the table header row.
		 */
		$table_head_styles = apply_filters( 'sports_bench_rivalry_shortcode_recent_head_row', '', $team_one, $team_two );

		$html .= '<thead>';
		$html .= '<tr style="' . $table_head_styles . '">';
		$html .= '<th colspan="7">' . esc_html__( 'Recent Results', 'sports-bench' ) . '</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';

		foreach ( $games as $game ) {
			$the_game  = new Game( $game->game_id );
			$away_team = new Team( (int) $the_game->get_game_away_id() );
			$home_team = new Team( (int) $the_game->get_game_home_id() );
			$date      = strtotime( $the_game->get_game_day() );
			$date      = date( get_option( 'date_format' ), $date );

			if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() ) {
				$away_name  = '<strong>' . $away_team->get_team_name() . '</strong>';
				$away_score = '<strong>' . $the_game->get_game_away_final() . '</strong>';
			} else {
				$away_name  = $away_team->get_team_name();
				$away_score = $the_game->get_game_away_final();
			}

			if ( $the_game->get_game_away_final() < $the_game->get_game_home_final() ) {
				$home_name  = '<strong>' . $home_team->get_team_name() . '</strong>';
				$home_score = '<strong>' . $the_game->get_game_home_final() . '</strong>';
			} else {
				$home_name  = $home_team->get_team_name();
				$home_score = $the_game->get_game_home_final();
			}

			/**
			 * Adds in styles for the rivalry recent games table body row.
			 *
			 * @since 2.0.0
			 *
			 * @param string $styles         The incoming styles for the row.
			 * @param int    $game_id        The id for the current game.
			 * @param Team   $away_team      The team object for the away team.
			 * @param Team   $home_team      The team object for the home team.
			 * @return string                Styles for the table row.
			 */
			$table_row_styles = apply_filters( 'sports_bench_rivalry_shortcode_recent_row', '', $the_game->get_game_id(), $away_team, $home_team );

			$html .= '<tr style="' . $table_row_styles . '">';
			$html .= '<td>' . $date . '</td>';
			$html .= '<td>' . $away_name . '</td>';
			$html .= '<td class="center">' . $away_score . '</td>';
			$html .= '<td class="center">' . esc_html__( 'at', 'sports-bench' ) . '</td>';
			$html .= '<td>' . $home_name . '</td>';
			$html .= '<td class="center">' . $home_score . '</td>';
			if ( $the_game->get_box_score_permalink() ) {
				$html .= '<td class="center"><a href="' . $the_game->get_box_score_permalink() . '">' . esc_html__( 'Box Score', 'sports-bench' ) . '</a></td>';
			} else {
				$html .= '<td></td>';
			}
			$html .= '</tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';

		return $html;
	}

	/**
	 * Displays the HTML for the game preview information.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game preview.
	 */
	public function show_game_preview_info() {
		$html = '';

		$game_id   = get_post_meta( get_the_ID(), 'sports_bench_game', true );
		$game      = new Game( $game_id );
		$away_team = new Team( (int) $game->get_game_away_id() );
		$home_team = new Team( (int) $game->get_game_home_id() );
		if ( null !== $away_team->get_team_nickname() ) {
			$away_team_name = '<span class="team-location">' . $away_team->get_team_location() . '</span><br /><span class="team-nickname">' . $away_team->get_team_nickname() . '</span>';
		} else {
			$away_team_name = '<br /><span class="no-nickname">' . $away_team->get_team_location() . '</span>';
		}
		if ( null !== $home_team->get_team_nickname() ) {
			$home_team_name = '<span class="team-location">' . $home_team->get_team_location() . '</span><br /><span class="team-nickname">' . $home_team->get_team_nickname() . '</span>';
		} else {
			$home_team_name = '<span class="no-nickname">' . $home_team->get_team_location() . '</span>';
		}
		if ( 'final' === $game->get_game_status() ) {
			$away_score  = $game->get_game_away_final();
			$home_score  = $game->get_game_home_final();
			$away_record = '';
			$home_record = '';
		} else {
			$away_score  = '';
			$home_score  = '';
			$away_record = $away_team->get_record( get_option( 'sports-bench-season-year' ) );
			$home_record = $home_team->get_record( get_option( 'sports-bench-season-year' ) );
			if ( 'soccer' === get_option( 'sports-bench-sport' ) || 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$away_record = '  <span class="record">' . $away_record[0] . '–' . $away_record[1] . '–' . $away_record[2] . '</span>';
				$home_record = '  <span class="record">' . $home_record[0] . '–' . $home_record[1] . '–' . $home_record[2] . '</span>';
			} else {
				$away_record = '  <span class="record">' . $away_record[0] . '–' . $away_record[1] . '</span>';
				$home_record = '  <span class="record">' . $home_record[0] . '–' . $home_record[1] . '</span>';
			}
		}

		/**
		 * Adds in the HTML or styles for before the game preview section.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML or styles for the section.
		 * @param Team   $away_team      The away team object.
		 * @param Team   $home_team      The home team object.
		 * @return string                The elements and styles to be shown before the section.
		 */
		$html .= apply_filters( 'sports_bench_before_game_preview', '', $away_team, $home_team );

		/**
		 * Displays the game preview.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html                The incoming HTML for the preview section.
		 * @param Game   $game                The game object for the game.
		 * @param Team   $away_team           The away team object.
		 * @param string $away_team_name      The name of the away team.
		 * @param string $away_record         The record for the away team.
		 * @param int    $away_score          The score for the away team.
		 * @param Team   $home_team           The home team object.
		 * @param string $home_team_name      The name of the home team.
		 * @param string $home_record         The record for the home team.
		 * @param int    $home_score          The score for the home team.
		 *
		 * @return string                     The HTML for the game preview.
		 */
		$html .= apply_filters( 'sports_bench_game_preview', $html, $game, $away_team, $away_team_name, $away_record, $away_score, $home_team, $home_team_name, $home_record, $home_score );

		/**
		 * Adds in the HTML or styles for after the game preview section.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML or styles for the section.
		 * @param Team   $away_team      The away team object.
		 * @param Team   $home_team      The home team object.
		 * @return string                The elements and styles to be shown after the section.
		 */
		$html .= apply_filters( 'sports_bench_after_game_preview', '', $away_team, $home_team );

		return $html;
	}

	/**
	 * Displays the game preview.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html                The incoming HTML for the preview section.
	 * @param Game   $game                The game object for the game.
	 * @param Team   $away_team           The away team object.
	 * @param string $away_team_name      The name of the away team.
	 * @param string $away_record         The record for the away team.
	 * @param int    $away_score          The score for the away team.
	 * @param Team   $home_team           The home team object.
	 * @param string $home_team_name      The name of the home team.
	 * @param string $home_record         The record for the home team.
	 * @param int    $home_score          The score for the home team.
	 */
	public function sports_bench_do_game_preview( $html, $game, $away_team, $away_team_name, $away_record, $away_score, $home_team, $home_team_name, $home_record, $home_score ) {
		$html .= '<aside id="game-info" class="widget">';
		$html .= '<table class="game-info-preview">';

		/**
		 * Adds in styles for the game preview row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the away team.
		 * @return string             The styles for row.
		 */
		$table_row_styles = apply_filters( 'sports_bench_game_preview_row', '', $away_team );

		$html .= '<tr style="' . $table_row_styles . '">';
		$html .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
		$html .= '<td>' . $away_team_name . $away_record . '</td>';
		$html .= '<td>' . $away_score . '</td>';
		$html .= '</tr>';

		/**
		 * Adds in styles for the game preview row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The incoming styles for the row.
		 * @param Team   $team        The team object for the home team.
		 * @return string             The styles for row.
		 */
		$table_row_styles = apply_filters( 'sports_bench_game_preview_row', '', $home_team );

		$html .= '<tr style="' . $table_row_styles . '">';
		$html .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
		$html .= '<td>' . $home_team_name . $home_record . '</td>';
		$html .= '<td>' . $home_score . '</td>';
		$html .= '</tr>';
		$html .= '</table>';

		$date     = date_create( $game->get_game_day() );
		$datetime = date_format( $date, get_option( 'time_format' ) ) . ' ' . date_format( $date, get_option( 'date_format' ) );

		$html .= '<p class="game-details">' . $datetime . '</p>';
		$html .= '<p class="game-details">' . $game->get_full_address() . '</p>';
		if ( $game->get_box_score_permalink() ) {
			$html .= '<a href="' . $game->get_box_score_permalink() . '" class="button black stat-button">' . esc_html__( 'View Box Score', 'sports-bench' ) . '</a>';
		}
		if ( 1 === get_option( 'sports-bench-display-map' ) ) {
			$html .= sports_bench_show_google_maps( $game );
		}
		$html .= '</aside>';

		return $html;
	}

	/**
	 * Shows the stats abbreviation guide for a game recap/box score.
	 *
	 * @since 2.0.0
	 *
	 * @return string     The HTML for the abbreviation guide
	 */
	public function show_recap_abbreviation_guide() {
		$guide = '';

		if ( '1' === get_option( 'sports-bench-abbreviation-guide' ) ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'AB - ' . esc_html__( 'Batting Average', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits', 'sports-bench' ) . '; R - ' . esc_html__( 'Runs', 'sports-bench' ) . '; RBI - ' . esc_html__( 'Runs Batted In', 'sports-bench' ) . '; SO - ' . esc_html__( 'Strikeouts', 'sports-bench' ) . '; BB - ' . esc_html__( 'Walks', 'sports-bench' ) . '; IP - ' . esc_html__( 'Innings Pitched', 'sports-bench' ) . '; R - ' . esc_html__( 'Runs Allowed', 'sports-bench' ) . '; ER - ' . esc_html__( 'Earned Runs', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits Allowed', 'sports-bench' ) . '; NP - ' . esc_html__( 'Number of Pitches', 'sports-bench' );
			} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'MIN - ' . esc_html__( 'Minutes', 'sports-bench' ) . '; GP - ' . esc_html__( 'Games Played', 'sports-bench' ) . '; FG - ' . esc_html__( 'Field Goals', 'sports-bench' ) . '; 3-PT - ' . esc_html__( 'Three Points', 'sports-bench' ) . ' FT - ' . esc_html__( 'Free Throws', 'sports-bench' ) . '; +/- - ' . esc_html__( 'Plus/Minus', 'sports-bench' ) . '; PTS - ' . esc_html__( 'Points', 'sports-bench' ) . '; OFF - ' . esc_html__( 'Offensive Rebounds', 'sports-bench' ) . '; DEF - ' . esc_html__( 'Defensive Rebounds', 'sports-bench' ) . '; AST - ' . esc_html__( 'Assists', 'sports-bench' ) . '; STL - ' . esc_html__( 'Steals', 'sports-bench' ) . '; BLK - ' . esc_html__( 'Blocks', 'sports-bench' ). '; TO - ' . esc_html__( 'Turnovers', 'sports-bench' ) . '; F - ' . esc_html__( 'Fouls', 'sports-bench' );
			} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'COMP - ' . esc_html__( 'Completions', 'sports-bench' ) . '; ATT - ' . esc_html__( 'Attempts', 'sports-bench' ) . '; TD - ' . esc_html__( 'Touchdowns', 'sports-bench' ) . '; INT - ' . esc_html__( 'Interceptions', 'sports-bench' ) . '; REC - ' . esc_html__( 'Receptions', 'sports-bench' ) . '; TKL - ' . esc_html__( 'Tackles', 'sports-bench' ) . '; TFL - ' . esc_html__( 'Tackles for Loss', 'sports-bench' ) . '; S - ' . esc_html__( 'Sacks', 'sports-bench' ) . '; PB - ' . esc_html__( 'Pass Breakups', 'sports-bench' ) .'; FF - ' . esc_html__( 'Forced Fumbles', 'sports-bench' ) . '; FR - ' . esc_html__( 'Fumbles Recovered', 'sports-bench' ) . '; BLK - ' . esc_html__( 'Blocked Kicks', 'sports-bench' ) . '; YDS - ' . esc_html__( 'Return Yards', 'sports-bench' ) . '; FGM - ' . esc_html__( 'Field Goals Made', 'sports-bench' ) . '; FGA - ' . esc_html__( 'Field Goals Attempted', 'sports-bench' ) . '; XPM - ' . esc_html__( 'Extra Points Made', 'sports-bench' ) . '; XPA - ' . esc_html__( 'Extra Points Attempted', 'sports-bench' ) . '; TB - ' . esc_html__( 'Touchbacks', 'sports-bench' ) . '; FUM - ' . esc_html__( 'Fumbles', 'sports-bench' );
			} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'SOG - ' . esc_html__( 'Shots on Goal', 'sports-bench' ) . '; G - ' . esc_html__( 'Goals', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; +/- - ' . esc_html__( 'Plus/Minus', 'sports-bench' ) . '; S - ' . esc_html__( 'Shots', 'sports-bench' ) . '; PM - ' . esc_html__( 'Penalty Minutes', 'sports-bench' ) . '; H - ' . esc_html__( 'Hits', 'sports-bench' ) . '; SH - ' . esc_html__( 'Shifts', 'sports-bench' ) . '; TOI - ' . esc_html__( 'Time on Ice', 'sports-bench' ) . '; FO-W - ' . esc_html__( 'Faceoffs - Faceoff Wins', 'sports-bench' ) . '; SF - ' . esc_html__( 'Shots Faced', 'sports-bench' ) . '; SV - ' . esc_html__( 'Saves', 'sports-bench' ) . '; GA - ' . esc_html__( 'Goals Allowed', 'sports-bench' );
			} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'T - ' . esc_html__( 'Tries', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; C - ' . esc_html__( 'Conversions', 'sports-bench' ) . '; PG - ' . esc_html__( 'Penalty Goals', 'sports-bench' ) . '; DK - ' . esc_html__( 'Drop Kicks', 'sports-bench' ) . '; PC - ' . esc_html__( 'Penalties Conceded', 'sports-bench' ) . '; MR - ' . esc_html__( 'Meters Run', 'sports-bench' ) . '; RED - ' . esc_html__( 'Red Cards', 'sports-bench' ) . '; YELLOW - ' . esc_html__( 'Yellow Cards', 'sports-bench' );
			} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$guide = 'MIN - ' . esc_html__( 'Minutes', 'sports-bench' ) . '; G - ' . esc_html__( 'Goals', 'sports-bench' ) . '; A - ' . esc_html__( 'Assists', 'sports-bench' ) . '; SH - ' . esc_html__( 'Shots', 'sports-bench' ) . '; SOG - ' . esc_html__( 'Shots On Goal', 'sports-bench' ) . '; F - ' . esc_html__( 'Fouls', 'sports-bench' ) . '; FS - ' . esc_html__( 'Fouls Suffered', 'sports-bench' ) . '; SF - ' . esc_html__( 'Shots Faced', 'sports-bench' ) . '; SV - ' . esc_html__( 'Saves', 'sports-bench' ) . '; GA - ' . esc_html__( 'Goals Allowed', 'sports-bench' );
			} else {
				$guide = 'SP - ' . esc_html__( 'Sets Played', 'sports-bench' ) . '; PTS - ' . esc_html__( 'Points', 'sports-bench' ) . '; K - ' . esc_html__( 'Kills', 'sports-bench' ) . '; HE - ' . esc_html__( 'Hitting Errors', 'sports-bench' ) . '; AT - ' . esc_html__( 'Attacks', 'sports-bench' ) . '; HIT % - ' . esc_html__( 'Hitting Percentage', 'sports-bench' ) . '; S - ' . esc_html__( 'Serves', 'sports-bench' ) . '; SE - ' . esc_html__( 'Serving Errors', 'sports-bench' ) . '; ACE - ' . esc_html__( 'Aces', 'sports-bench' ) . '; SET A - ' . esc_html__( 'Set Attempts', 'sports-bench' ) . '; SET E - ' . esc_html__( 'Set Errors', 'sports-bench' ) . '; BA - ' . esc_html__( 'Block Attempts', 'sports-bench' ) . '; B - ' . esc_html__( 'Blocks', 'sports-bench' ) . '; BE - ' . esc_html__( 'Blocking Errors', 'sports-bench' ) . ';  DIG - ' . esc_html__( 'Digs', 'sports-bench' ) . '; RE - ' . esc_html__( 'Reception Errors', 'sports-bench' );
			}
		}

		return $guide;
	}

	/**
	 * Displays the box score for a game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game's box score.
	 */
	public function display_game_box_score() {
		if ( ! isset( $_GET['game_id'] ) ) {
			return '<p>' . esc_html__( 'Please select a game in order to see the box score for it.', 'sports-bench' ) . '</p>';
		}
		$game_id   = sanitize_text_field( $_GET['game_id'] );
		$game      = new Game( (int) $game_id );
		$home_team = new Team( (int) $game->get_game_home_id() );
		$away_team = new Team( (int) $game->get_game_away_id() );
		$html      = '';

		$html .= '<div class="game-box-score">';

		$html .= sports_bench_game_box_score_game_info( $game, $home_team, $away_team );
		$html .= sports_bench_game_box_score_team_stats( $game, $home_team, $away_team );
		$html .= sports_bench_game_box_score_away_team_stats( $game, $away_team );
		$html .= sports_bench_game_box_score_home_team_stats( $game, $home_team );

		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the linescore, game events, team and individual stats for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html           The current HTML for the game stats.
	 * @param Game   $game           The current game object.
	 * @param Team   $away_team      The away team oject for the away team.
	 * @param Team   $home_team      The home team oject for the home team.
	 * @return string                The HTML for the game stats section.
	 */
	public function sports_bench_do_game_stats_info( $html, $game, $away_team, $home_team ) {
		$html .= '<div id="score-info" class="widget">';
		if ( $game->get_game_away_final() > $game->get_game_home_final() ) {
			$score = $away_team->get_team_location() . ' ' . $game->get_game_away_final() . ', ' . $home_team->get_team_location() . ' ' . $game->get_game_home_final();
		} else {
			$score = $home_team->get_team_location() . ' ' . $game->get_game_home_final() . ', ' . $away_team->get_team_location() . ' ' . $game->get_game_away_final();
		}
		$html .= '<h2 class="widgettitle">' . $score . '</h2>';
		$html .= sports_bench_get_linescore_display( $game->get_game_id() );
		$html .= sports_bench_show_game_info( $game->get_game_id() );
		if ( 'basketball' !== get_option( 'sports-bench-sport' ) && 'volleyball' !== get_option( 'sports-bench-sport' ) ) {
			$html .= sports_bench_get_score_info( $game->get_game_id() );
		}
		$html .= '</div>';

		if ( 'baseball' !== get_option( 'sports-bench-sport' ) ) {
			$html .= '<div id="team-stats" class="widget">';
			$html .= '<h2 class="widgettitle">' . esc_html__( 'Team Stats', 'sports-bench' ) . '</h2>';
			$html .= sports_bench_get_team_stats_info( $game->get_game_id() );
			$html .= '</div>';
		}

		$html .= '<div id="away-stats" class="widget">';
		$html .= '<h2 class="widgettitle"><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_name() . '</a></h2>';
		$html .= sports_bench_get_away_individual_stats( $game->get_game_id() );
		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_recap_abbreviation_guide() . '</p>';
		$html .= '</div>';

		$html .= '<div id="home-stats" class="widget">';
		$html .= '<h2 class="widgettitle"><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_name() . '</a></h2>';
		$html .= sports_bench_get_home_individual_stats( $game->get_game_id() );
		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_recap_abbreviation_guide() . '</p>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Sanitizies the input for an array.
	 *
	 * @since 2.1.5
	 *
	 * @param array $input      The array of incoming information to sanitize.
	 * @return array            The array of sanitized data.
	 */
	public function sanitize_array( $input ) {

		// Initialize the new array that will hold the sanitize values
		$new_input = array();

		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {
			if ( is_array( $val ) ) {
				$new_input[ $key ] = $this->sanitize_array( $val );
			} else {
				$new_input[ $key ] = sanitize_text_field( $val );
			}
		}

		return $new_input;

	}

}
