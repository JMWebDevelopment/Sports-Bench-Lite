<?php
/**
 * Creates the teams functions.
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

use Sports_Bench\Classes\Base\Teams;

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
function sports_bench_get_teams( $alphabetical = false, $active = true, $division_id = 0 ) {
	$teams = new Teams();
	return $teams->get_teams( $alphabetical, $active, $division_id );
}

/**
 * Shows the information for each team.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the teams listing.
 */
function sports_bench_show_team_listing() {
	$html      = '';
	$teams     = new Teams();
	$teams     = $teams->get_teams( true );
	$num_teams = count( $teams );
	$count     = 0;
	$html     .= '<div class="teams-grid">';
	foreach ( $teams as $team_id => $team_name ) {

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
		$team_info = apply_filters( 'sports_bench_team_listing_info', '', $team_id, $team_name, $num_teams, $count );
		$count++;
		$html .= $team_info;
	}
	$html .= '</div>';

	return $html;
}

/**
 * Displays the schedule for a given team.
 *
 * @since 2.0.0
 *
 * @param int         $team_id     The id for the team to get the schedule.
 * @param string|null $season      The season to get the schedule for.
 * @return string           The HTML for the team schedule.
 */
function sports_bench_show_team_schedule( $team_id, $season = '' ) {
	$teams = new Teams();
	return $teams->show_team_schedule( $team_id, $season );
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
function sports_bench_team_season_stats( $team, $season ) {
	$teams = new Teams();
	return $teams->team_season_stats( $team, $season );
}

/**
 * Displays the player stats table for a team.
 *
 * @since 2.0.0
 *
 * @param array $player_stats_array      The array of player stats to show.
 * @return string                        The table of player stats.
 */
function sports_bench_get_players_stats_table( $player_stats_array ) {
	$teams = new Teams();
	return $teams->get_players_stats_table( $player_stats_array );
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
function sports_bench_get_players_stats( $team_id, $season ) {
	if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Baseball\BaseballTeam( (int) $team_id );
	} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Basketball\BasketballTeam( (int) $team_id );
	} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Football\FootballTeam( (int) $team_id );
	} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Hockey\HockeyTeam( (int) $team_id );
	} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Rugby\RugbyTeam( (int) $team_id );
	} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
		$team = new Sports_Bench\Classes\Sports\Soccer\SoccerTeam( (int) $team_id );
	} else {
		$team = new Sports_Bench\Classes\Sports\Volleyball\VolleyballTeam( (int) $team_id );
	}
	return $team->get_players_stats( $season );
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
function sports_bench_show_roster( $team_id, $season = '' ) {
	$teams = new Teams();
	return $teams->show_roster( $team_id, $season );
}

/**
 * Shows the standings for the division or conference the team is in.
 *
 * @since 2.0.0
 *
 * @param int $division_id      The id for the division the team is in. If you want to get the league standings, use 0.
 * @return string               The HTML for the standings.
 */
function sports_bench_team_division_standings( $division_id ) {
	$teams = new Teams();
	return $teams->team_division_standings( $division_id );
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
function sports_bench_show_team_info( $team_id, $season = '' ) {
	$teams = new Teams();
	return $teams->show_team_info( $team_id, $season );
}

/**
 * Displays the teams page template.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the teams page template.
 */
function sports_bench_teams_page_template() {
	$teams = new Teams();
	return $teams->teams_page_template();
}

/**
 * Gets the number of points in the season for a team in the standings.
 *
 * @since 2.0.0
 *
 * @param int $team_id      The id of the team to get the points for.
 * @return int              The number of points for the team.
 */
function sports_bench_get_points( $team_id ) {
	$teams = new Teams();
	return $teams->get_points( $team_id );
}

/**
 * Gets the total number of points for each team in a volleyball game.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id of the game to get the points from.
 * @return array            A list of points for the away and home team in a volleyball game.
 */
function sports_bench_total_points( $game_id ) {
	$teams = new Teams();
	return $teams->total_points( $game_id );
}
