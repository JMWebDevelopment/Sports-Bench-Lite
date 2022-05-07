<?php
/**
 * Creates the games functions.
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

use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Game;

/**
 * Displays the HTML for the game preview information.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the game preview.
 */
function sports_bench_show_game_preview_info() {
	$games = new Games();
	return $games->show_game_preview_info();
}

/**
 * Returns the box score for the game.
 *
 * @since 2.0.0
 *
 * @param Game $game      The game object for the game.
 * @param Team $home      The team object for the home team.
 * @param Team $away      The team object for the away team.
 * @return string         The HTML for the game's box score.
 */
function sports_bench_game_box_score_game_info( $game, $home, $away ) {
	$game = new Game( $game->get_game_id() );
	return $game->game_box_score_game_info();
}

/**
 * Displays the linescore for the game.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string           The HTML to display the linescore.
 */
function sports_bench_get_linescore_display( $game_id ) {
	$game = new Game( $game_id );
	return $game->get_linescore_display();
}

/**
 * Shows the information about a game.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string           The HTML for the game information.
 */
function sports_bench_show_game_info( $game_id ) {
	$game = new Game( $game_id );
	return $game->show_game_info();
}

/**
 * Gets the scoring/event information for the game.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string           The HTML for the game scoring/events section.
 */
function sports_bench_get_score_info( $game_id ) {
	$game = new Game( $game_id );
	return $game->get_score_info();
}

/**
 * Displays the team stats for the game.
 *
 * @since 2.0.0
 *
 * @param Game $game      The game object for the game.
 * @param Team $home      The team object for the home team.
 * @param Team $away      The team object for the away team.
 * @return string         The HTML for the team stats section.
 */
function sports_bench_game_box_score_team_stats( $game, $home, $away ) {
	$game = new Game( $game->get_game_id() );
	return $game->game_box_score_team_stats();
}

/**
 * Returns the team stats for the game.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string           The HTML for the team stats section.
 */
function sports_bench_get_team_stats_info( $game_id ) {
	$game = new Game( $game_id );
	return $game->get_team_stats_info();
}

/**
 * Displays the individual stats for a game for the away team.
 *
 * @since 2.0.0
 *
 * @param Game $game           The game object for the game.
 * @param Team $away_team      The team object for the away team.
 * @return string              The HTML for the away team individual stats.
 */
function sports_bench_game_box_score_away_team_stats( $game, $away_team ) {
	$game = new Game( $game->get_game_id() );
	return $game->game_box_score_away_team_stats();
}

/**
 * Displays the individual stats table for a game for the away team.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string           The HTML for the away team individual stats table.
 */
function sports_bench_get_away_individual_stats( $game_id ) {
	$game = new Game( $game_id );
	return $game->get_away_individual_stats();
}

/**
 * Displays the individual stats for a game for the home team.
 *
 * @since 2.0.0
 *
 * @param Game $game           The game object for the game.
 * @param Team $home_team      The team object for the home team.
 * @return string              The HTML for the away home individual stats.
 */
function sports_bench_game_box_score_home_team_stats( $game, $home_team ) {
	$game = new Game( $game->get_game_id() );
	return $game->game_box_score_home_team_stats();
}

/**
 * Displays the individual stats table for a game for the home team.
 *
 * @since 2.0.0
 *
 * @param int $game_id      The id for the game.
 * @return string      The HTML for the away team individual home table.
 */
function sports_bench_get_home_individual_stats( $game_id ) {
	$game = new Game( $game_id );
	return $game->get_home_individual_stats();
}

/**
 * Shows the stats abbreviation guide for a game recap/box score.
 *
 * @since 2.0.0
 *
 * @return string     The HTML for the abbreviation guide.
 */
function sports_bench_show_recap_abbreviation_guide() {
	$games = new Games();
	return $games->show_recap_abbreviation_guide();
}

/**
 * Displays the box score for a game.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the game's box score.
 */
function sports_bench_display_game_box_score() {
	$games = new Games();
	return $games->display_game_box_score();
}

/**
 * Gets a given team stats for a game.
 *
 * @since 2.0.0
 *
 * @param Game   $game           The game object for the game.
 * @param string $home_away      Whether to get a "home" or "away" stat.
 * @param string $stat           The stat to get.
 * @return int                   The stat being searched.
 */
function sports_bench_get_game_stat( $game, $home_away, $stat ) {
	$game = new Game( $game->get_game_id() );
	return $game->get_game_stat( $home_away, $stat );
}

/**
 * Checks to see if a time has been set for a game.
 *
 * @since 2.0.0
 *
 * @param DateTime $time      The datetime object for the game.
 * @return bool               Whether a time has been set for the game or not.
 */
function sports_bench_is_game_time_set( $time ) {
	if ( 0 === $time->format( 'H' ) && 0 === $time->format( 'i' ) && 0 === $time->format( 's' ) ) {
		return false;
	} else {
		return true;
	}
}
