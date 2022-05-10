<?php
/**
 * Creates the scoreboard functions.
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

use Sports_Bench\Classes\Base\Scoreboard;

/**
 * Displays the scoreboard bar.
 *
 * @since 2.0.0
 *
 * @param string $class      The class(es) to add to the parent scorebard bar div.
 */
function sports_bench_scoreboard_bar( $class = '' ) {
	$scoreboard = new Scoreboard();
	$scoreboard->display_scoreboard_bar( $class );
}

/**
 * Creates the scoreboard page template.
 *
 * @since 2.0.0
 *
 * @return string      The HTML for the scoreboard page.
 */
function sports_bench_scoreboard_page_template() {
	$scoreboard = new Scoreboard();
	$html       = '<div class="sports-bench-scoreboard-page">';
	$html      .= $scoreboard->display_scoreboard_page();
	$html      .= '</div>';

	return $html;
}
