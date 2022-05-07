<?php
/**
 * Creates the players functions.
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

use Sports_Bench\Classes\Base\Players;

/**
 * Returns the goals against average for a player.
 *
 * @since 2.0.0
 *
 * @param int $goals_allowed      The number of goals allowed.
 * @param int $games_played       The number of games/matches played.
 * @return float                  The goals against average.
 */
function sports_bench_get_goals_against_average( $goals_allowed, $games_played ) {
	$player = new Players();
	return $player->get_goals_against_average( $goals_allowed, $games_played );
}

/**
 * Returns the ERA for a player.
 *
 * @since 2.0.0
 *
 * @param int   $earned_runs           The number of earned runs given up.
 * @param float $innings_pitched       The number of innings pitched.
 * @param int   $innings_per_game      The number of innings per game.
 * @return float|string                The ERA for the player.
 */
function sports_bench_get_ERA( $earned_runs, $innings_pitched, $innings_per_game ) {
	$player = new Players();
	return $player->get_ERA( $earned_runs, $innings_pitched, $innings_per_game );
}

/**
 * Returns the batting average for a player.
 *
 * @since 2.0.0
 *
 * @param int $at_bats       The number of at bats.
 * @param int $hits          The number of hits.
 * @return float|string      The batting average for the player.
 */
function sports_bench_get_batting_average( $at_bats, $hits ) {
	$player = new Players();
	return $player->get_batting_average( $at_bats, $hits );
}

/**
 * Gets the points per game average for a player.
 *
 * @since 2.0.0
 *
 * @param int $points      The number of points scored.
 * @param int $games       The number of games played.
 * @return float           The points per game for the player.
 */
function sports_bench_get_points_average( $points, $games ) {
	$player = new Players();
	return $player->get_points_average( $points, $games );
}

/**
 * Gets the hitting percentage for a player.
 *
 * @since 2.0.0
 *
 * @param int $attacks        The number of attacks.
 * @param int $kills          The number of kills.
 * @param int $errors         The number of hitting errors.
 * @return float|string       The hitting percentage for the player.
 */
function sports_bench_get_hitting_percentage( $attacks, $kills, $errors ) {
	$player = new Players();
	return $player->get_hitting_percentage( $attacks, $kills, $errors );
}

/**
 * Gets the season stats table for a player.
 *
 * @since 2.0.0
 *
 * @param Player $player_object      The player object to get the stats table for.
 * @return string                    The HTML for the stats table.
 */
function sports_bench_get_season_stats( $player_object ) {
	$player = new Players();
	return $player->get_season_stats( $player_object );
}

/**
 * Checks to see if a stat exists for a player.
 *
 * @since 2.0.0
 *
 * @param array  $seasons      The array to check to see if the stat exists.
 * @param string $stat         The stat to search for.
 * @return bool                Whether the stat exists or not.
 */
function sports_bench_stat_exists( $seasons, $stat ) {
	$player = new Players();
	return $player->stat_exists( $seasons, $stat );
}

/**
 * Gets the number of wins for a pitcher.
 *
 * @since 2.0.0
 *
 * @param int    $player_id      The id for the player.
 * @param string $season         The season to check for wins.
 * @return int                   The number of wins for the player.
 */
function sports_bench_get_pitcher_wins( $player_id, $season ) {
	$player = new Players();
	return $player->get_pitcher_wins( $player_id, $season );
}

/**
 * Gets the number of losses for a pitcher.
 *
 * @since 2.0.0
 *
 * @param int    $player_id      The id for the player.
 * @param string $season         The season to check for losses.
 * @return int                   The number of losses for the player.
 */
function sports_bench_get_pitcher_losses( $player_id, $season ) {
	$player = new Players();
	return $player->get_pitcher_losses( $player_id, $season );
}

/**
 * Gets the record for a pitcher.
 *
 * @since 2.0.0
 *
 * @param int    $player_id      The id for the player.
 * @param string $season         The season to get the record.
 * @return int                   The record for the player.
 */
function sports_bench_get_pitcher_record( $player_id, $season ) {
	$player = new Players();
	return $player->get_pitcher_record( $player_id, $season );
}

/**
 * Gets the number of saves for a pitcher.
 *
 * @since 2.0.0
 *
 * @param int    $player_id      The id for the player.
 * @param string $season         The season to check for saves.
 * @return int                   The number of saves for the player.
 */
function sports_bench_get_pitcher_saves( $player_id, $season ) {
	$player = new Players();
	return $player->get_pitcher_saves( $player_id, $season );
}

/**
 * Returns the HTML for the select dropdown for the team select on the players page.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the select dropdown.
 */
function sports_bench_show_team_player_select() {
	$player = new Players();
	return $player->show_team_player_select();
}

/**
 * Shows the information for a player.
 *
 * @since 2.0.0
 *
 * @param int $player_id      The id of the player to show information about.
 * @return string             The information about a player.
 */
function sports_bench_show_player_info( $player_id ) {
	$player = new Players();
	return $player->show_player_info( $player_id );
}

/**
 * Gets the shooting average for a player.
 *
 * @since 2.0.0
 *
 * @param int $made          The number of made shots.
 * @param int $attempts      The number of shot attempts.
 * @return float|string      The shooting averate for the player.
 */
function sports_bench_get_shooting_average( $made, $attempts ) {
	$player = new Players();
	return $player->get_shooting_average( $made, $attempts );
}
