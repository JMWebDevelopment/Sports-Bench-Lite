<?php
/**
 * Creates the standings functions.
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

use Sports_Bench\Classes\Base\Standings;

/**
 * Displays the league-wide standings.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the league-wide standings table.
 */
function sports_bench_all_team_standings() {
	$standings = new Standings();
	return $standings->all_team_standings();
}

/**
 * Displays the standings for a division or conference.
 *
 * @since 2.0.0
 *
 * @param int $division_id      The division id of the standings to show.
 * @return string               The HTML for the league-wide standings table.
 */
function sports_bench_conference_division_standings( $division_id ) {
	$standings = new Standings();
	return $standings->conference_division_standings( $division_id );
}

/**
 * Displays the standings for widget.
 *
 * @since 2.0.0
 *
 * @param int|null $division_id      The division id of the standings to show. Leave blank to show the league standings.
 * @return string                    The HTML for the league-wide standings table.
 */
function sports_bench_widget_standings( $division_id = null ) {
	$standings = new Standings();
	return $standings->widget_standings( $division_id );
}

/**
 * Displays the standings page template.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the standings page.
 */
function sports_bench_standings_page_template() {
	$standings = new Standings();
	return $standings->standings_page_template();
}

/**
 * Displays the league-wide standings for the standings block.
 *
 * @since 2.0.0
 *
 * @param array $attributes      The attributes for the block.
 * @return string                The HTML for the standings table.
 */
function sports_bench_all_teams_standings_gutenberg( $attributes ) {
	$standings = new Standings();
	return $standings->all_teams_standings_gutenberg( $attributes );
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
function sports_bench_conference_division_standings_gutenberg( $division_id, $attributes ) {
	$standings = new Standings();
	return $standings->conference_division_standings_gutenberg( $division_id, $attributes );
}
