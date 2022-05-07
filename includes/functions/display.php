<?php
/**
 * Creates the display functions.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/functions
 * @author     Jacob Martella <me@jacobmartella.com>
 */

use Sports_Bench\Classes\Base\Display;

/**
 * Returns code to display a Google map for a game's location.
 *
 * @since 2.0.0
 *
 * @param Game $game      The Game object to display the map for.
 * @return string         An iFrame for the map.
 */
function sports_bench_show_google_maps( $game ) {
	$display = new Display();
	return $display->show_google_maps( $game );
}

/**
 * Gets a list of seasons for the league.
 *
 * @since 2.0.0
 *
 * @return array      The list of seasons for the league.
 */
function sports_bench_get_seasons() {
	$display = new Display();
	return $display->get_seasons();
}

/**
 * Adds in top border colors for a div based on the entered teams.
 *
 * @since 2.0.0
 *
 * @param int      $team_one_id      The ID for the first team.
 * @param int|null $team_two_id      The ID for the second team.
 * @param int|null $div              The ID of the div the border is for.
 * @return string                    Styling for the top border of the div.
 */
function sports_bench_border_top_colors( $team_one_id, $team_two_id = null, $div = null ) {
	$display = new Display();
	return $display->border_top_colors( $team_one_id, $team_two_id, $div );
}

/**
 * Gets the color of a given division/conference.
 *
 * @since 2.0.0
 *
 * @param int $division_id      The ID of the division or conference.
 * @return string               The color of the division or conference in hexidecimal format.
 */
function sports_bench_division_color( $division_id ) {
	$display = new Display();
	return $display->division_color( $division_id );
}

/**
 * Returns a horizontal gradient based on a team's color.
 *
 * @since 2.0.0
 *
 * @param string $team_color      The team color to apply the gradient.
 * @return string                 The styling for the gradient.
 */
function sports_bench_team_horizontal_gradient( $team_color ) {
	$display = new Display();
	return $display->team_horizontal_gradient( $team_color );
}

/**
 * Shows the games stats for the game selected in post meta.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the game stats.
 */
function sports_bench_show_game_stats_info() {
	$display = new Display();
	return $display->show_game_stats_info();
}

/**
 * Adds in top colors for a div based on the teams in a game selected in post meta.
 *
 * @since 2.0.0
 *
 * @return string      Styling for the border of a div.
 */
function sports_bench_show_team_border_colors() {
	$display = new Display();
	return $display->show_team_border_colors();
}

/**
 * Returns the category for a post or a scoreline for a game if one is selected for the post.
 *
 * @since 2.0.0
 *
 * @return string      The labelhead for a post.
 */
function sports_bench_show_label_head() {
	$display = new Display();
	return $display->show_label_head();
}

/**
 * Shows information for a game if selected for a post in a featured slideshow.
 *
 * @since 2.0.0
 *
 * @return string       The HTML for showing game information.
 */
function sports_bench_show_slider_game_info() {
	$display = new Display();
	return $display->show_slider_game_info();
}

/**
 * Changes a hexidecimal color value into a rgb or rgba value.
 *
 * @since 2.0.0
 *
 * @param string     $color        The hexidecimal value of the color to change.
 * @param float|bool $opacity      The opacity for the color. Leave blank if you want to use rgb only.
 * @return string                  The color as a rgb or rgba value.
 */
function sports_bench_hex2rgba( $color, $opacity = false ) {
	$display = new Display();
	return $display->hex2rgba( $color, $opacity );
}

/**
 * Gets the season stats for a selected team.
 *
 * @since 2.0.0
 *
 * @param Team   $team        The Team object to get the season stats from.
 * @param string $season      The season to get the stats from.
 * @return array              The total and average stats for a team for the season.
 */
function sports_bench_get_team_season_stats( $team, $season ) {
	if ( $team instanceof Classes\Sports\Baseball\BaseballTeam || $team instanceof Classes\Sports\Basketball\BaseketballTeam || $team instanceof Classes\Sports\Football\FootballTeam || $team instanceof Classes\Sports\Hockey\HocketTeam || $team instanceof Classes\Sports\Rugby\RugbyTeam || $team instanceof Classes\Sports\Soccer\SoccerTeam || $team instanceof Classes\Sports\Volleyball\VolleyballTeam ) {
		return $team->get_team_season_stats( $season );
	} else {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Baseball\BaseballTeam( (int) $team->get_team_id() );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Basketball\BasketballTeam( (int) $team->get_team_id() );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Football\FootballTeam( (int) $team->get_team_id() );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Hockey\HockeyTeam( (int) $team->get_team_id() );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Rugby\RugbyTeam( (int) $team->get_team_id() );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$team = new Classes\Sports\Soccer\SoccerTeam( (int) $team->get_team_id() );
		} else {
			$team = new Classes\Sports\Volleyball\VolleyballTeam( (int) $team->get_team_id() );
		}
		return $team->get_team_season_stats( $season );
	}
}

/**
 * Removes a filter that's been added by the Sports Bench plugin.
 *
 * @since 2.0.0
 *
 * @param string $tag                The filter tag to target with removal.
 * @param string $function_name      The name of the function to remove as a filter.
 * @param int    $priority           The priority of removing the filter.
 */
function sports_bench_remove_filter( $tag, $function_name, $priority = 10 ) {
	global $wp_filter;

	if ( isset( $wp_filter[ $tag ]->callbacks[ $priority ] ) && ! empty( $wp_filter[ $tag ]->callbacks[ $priority ] ) ) {
		$wp_filter[ $tag ]->callbacks[ $priority ] = array_filter(
			$wp_filter[ $tag ]->callbacks[ $priority ],
			function( $v, $k ) use ( $function_name ) {
				return ( false === stripos( $k, $function_name ) );
			},
			ARRAY_FILTER_USE_BOTH
		);
	}
}

/**
 * Removes an action that's been added by the Sports Bench plugin.
 *
 * @since 2.0.0
 *
 * @param string $tag                The action tag to target with removal.
 * @param string $function_name      The name of the function to remove as an action.
 * @param int    $priority           The priority of removing the action.
 */
function sports_bench_remove_action( $tag, $function_name, $priority = 10 ) {
	global $wp_filter;

	if ( isset( $wp_filter[ $tag ]->callbacks[ $priority ] ) && ! empty( $wp_filter[ $tag ]->callbacks[ $priority ] ) ) {
		$wp_filter[ $tag ]->callbacks[ $priority ] = array_filter(
			$wp_filter[ $tag ]->callbacks[ $priority ],
			function( $v, $k ) use ( $function_name ) {
				return ( false === stripos( $k, $function_name ) );
			},
			ARRAY_FILTER_USE_BOTH
		);
	}
}
