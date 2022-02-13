<?php
/**
 * Creates the shortcode function for showing the rivalry shortcode.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public/partials/shortcodes
 * @author     Jacob Martella <me@jacobmartella.com>
 */

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * Renders the rivalry shortcode.
 *
 * @since 2.0.0
 *
 * @param array $atts      The attributes for the shortcode.
 * @return string          The HTML for the shortcode.
 */
function sports_bench_rivalry_shortcode( $atts ) {

	extract(
		shortcode_atts(
			[
				'team_one_id'   => 0,
				'team_two_id'   => 0,
				'recent_games'  => 5,
			],
			$atts
		)
	);

	$html = '';

	if ( 0 !== $team_one_id && 0 !== $team_two_id ) {
		$team_one = new Team( (int) $team_one_id );
		$team_two = new Team( (int) $team_two_id );
		if ( null !== $team_one->get_team_nickname() ) {
			$team_one_name = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
		} else {
			$team_one_name = $team_one->get_team_location();
		}
		if ( null !== $team_two->get_team_nickname() ) {
			$team_two_name = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
		} else {
			$team_two_name = $team_two->get_team_location();
		}

		global $wpdb;
		$table         = SB_TABLE_PREFIX . 'games';
		$querystr      = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_home_id = %d AND game_away_id = %d ) OR ( game_home_id = %d AND game_away_id = %d ) LIMIT %d", $team_one_id, $team_two_id, $team_two_id, $team_one_id, $recent_games );
		$games         = Database::get_results( $querystr );
		$team_one_wins = 0;
		$team_two_wins = 0;
		$draws         = 0;
		foreach ( $games as $game ) {
			$the_game = new Game( $game->game_id );
			if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() ) {
				if ( $the_game->get_game_away_id() === $team_one_id ) {
					$team_one_wins++;
				} else {
					$team_two_wins++;
				}
			} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
				if ( $the_game->get_game_home_id() === $team_one_id ) {
					$team_one_wins++;
				} else {
					$team_two_wins++;
				}
			} else {
				$draws++;
			}
		}
		if ( $team_one_wins > $team_two_wins ) {
			$series_score = $team_one->team_name . ' ' . __( 'lead the all-time series', 'sports-bench' ) . ' ' . $team_one_wins . '-' . $team_two_wins . '-' . $draws;
		} elseif ( $team_two_wins > $team_one_wins ) {
			$series_score = $team_two->team_name . ' ' . __( 'lead the all-time series', 'sports-bench' ) . ' ' . $team_two_wins . '-' . $team_one_wins . '-' . $draws;
		} else {
			$series_score = __( 'The all-time series is tied', 'sports-bench' ) . ' ' . $team_one_wins . '-' . $team_two_wins . '-' . $draws;
		}

		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_home_id = %d AND game_away_id = %d ) OR ( game_home_id = %d AND game_away_id = %d ) AND game_status = 'final' ORDER BY game_day DESC LIMIT %d", $team_one_id, $team_two_id, $team_two_id, $team_one_id, $recent_games );
		$games    = Database::get_results( $querystr );

		$html .= '<div class="sports-bench-rivalry row sports-bench-row">';

		/**
		 * Adds in HTML to be shown before the rivalry shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param int    $game          The first Game object of the rivalry.
		 * @param Team   $team_one      The team object for the first team.
		 * @param Team   $team_two      The team object for the second team.
		 * @return string               HTML to be shown before the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_before_rivalry_shortcode', '', $games[0], $team_one, $team_two );

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
		$html .= apply_filters( 'sports_bench_rivalry_shortcode_info', '', $games[0], $team_one, $team_one_name, $team_two, $team_two_name, $series_score );

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
		$html .= apply_filters( 'sports_bench_rivalry_shortcode_recent_game', '', $games, $team_one, $team_two );

		/**
		 * Adds in HTML to be shown after the rivalry shortcode.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param int    $game          The first Game object of the rivalry.
		 * @param Team   $team_one      The team object for the first team.
		 * @param Team   $team_two      The team object for the second team.
		 * @return string               HTML to be shown after the shortcode.
		 */
		$html .= apply_filters( 'sports_bench_after_rivalry_shortcode', '', $games[0], $team_one, $team_two );
		$html .= '</div>';
	}

	return $html;

}
