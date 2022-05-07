<?php
/**
 * Creates the stats functions.
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

use Sports_Bench\Classes\Base\Stats;

/**
 * Returns the abbreviation guide if the option is selected.
 *
 * @since 2.0.0
 *
 * @return string      The abbreviation guide.
 */
function sports_bench_show_stats_abbreviation_guide() {
	$stats = new Stats();
	return $stats->show_stats_abbreviation_guide();
}

/**
 * Displays the stats leaderboard page template.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the stats leaderboard page template.
 */
function sports_bench_stats_page_template() {
	$stats = new Stats();
	return $stats->stats_page_template();
}

/**
 * Displays a table of leaders for a stat.
 *
 * @since 2.0.0
 *
 * @param string $stat        The stat to look for.
 * @param string $season      The season to look for the stat in.
 * @return string             Table of players for that stat.
 */
function sports_bench_get_stats_leaders( $stat, $season ) {
	$stats = new Stats();
	return $stats->get_stats_leaders( $stat, $season );
}

/**
 * Returns more stat leaders for a give stat.
 *
 * @since 2.0.0
 *
 * @param string $stat        The stat to look for.
 * @param string $season      The season to look for the stat in.
 * @param int    $offset      The number of players to ignore first to avoid duplicates.
 * @return string             Table of players for that stat.
 */
function sports_bench_get_more_stats_leaders( $stat, $season, $offset = 0 ) {
	$stats = new Stats();
	return $stats->get_more_stats_leaders( $stat, $season, $offset );
}

/**
 * Gets the title for a given stat slug.
 *
 * @since 2.0.0
 *
 * @param string $stat      The slug for a given stat.
 * @return string           The title for the stat.
 */
function sports_bench_get_stat_title( $stat ) {
	$stats = new Stats();
	return $stats->get_stat_title( $stat );
}

/**
 * Creates the SQL for the column to search for in the stat search.
 *
 * @since 2.0.0
 *
 * @param string $stat      The stat being searched for.
 * @return string           The SQL to search for the stat.
 */
function sports_bench_search_stat( $stat ) {
	$stats = new Stats();
	return $stats->search_stat( $stat );
}

/**
 * Determines the direction the stat search needs to go for a given stat.
 *
 * @since 2.0.0
 *
 * @param string $stat      The stat being searched for.
 * @return string           The SQL direction for the stat search.
 */
function sports_bench_search_stat_direction( $stat ) {
	$stats = new Stats();
	return $stats->search_stat_direction( $stat );
}

/**
 * Creates an SQL limit to only search for players eligible for the given stat.
 *
 * @since 2.0.0
 *
 * @param string $stat      The stat being searched for.
 * @return string           The SQL for limiting to search for players with that stat.
 */
function sports_bench_search_stat_limit( $stat ) {
	$stats = new Stats();
	return $stats->search_stat_limit( $stat );
}

/**
 * Outputs the stat search page.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the stat search page.
 */
function sports_bench_stat_search_page() {
	$stats = new Stats();
	return $stats->stat_search_page();
}
