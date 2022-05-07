<?php
/**
 * Displays the licenses options screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/options
 * @author     Jacob Martella <me@jacobmartella.com>
 */

if ( get_option( 'sports-bench-display-game' ) ) {
	$display = get_option( 'sports-bench-display-game' );
} else {
	$display = '0';
}

if ( get_option( 'sports-bench-display-map' ) ) {
	$display_map = get_option( 'sports-bench-display-map' );
} else {
	$display_map = '';
}

if ( get_option( 'sports-bench-week-maps-api-key' ) ) {
	$map_api_key = get_option( 'sports-bench-week-maps-api-key' );
} else {
	$map_api_key = '';
}

if ( get_option( 'sports-bench-abbreviation-guide' ) ) {
	$guide = get_option( 'sports-bench-abbreviation-guide' );
} else {
	$guide = '0';
}

if ( get_option( 'sports-bench-use-fonts' ) ) {
	$font = get_option( 'sports-bench-use-fonts' );
} else {
	$font = '0';
}

if ( get_option( 'sports-bench-sport' ) ) {
	$sport = get_option( 'sports-bench-sport' );
} else {
	$sport = '';
}

if ( get_option( 'sports-bench-season-year' ) ) {
	$sports_year = get_option( 'sports-bench-season-year' );
} else {
	$sports_year = '';
}

if ( get_option( 'sports-bench-season' ) ) {
	$season = get_option( 'sports-bench-season' );
} else {
	$season = '0';
}

if ( get_option( 'sports-bench-week-number' ) ) {
	$week = get_option( 'sports-bench-week-number' );
} else {
	$week = '';
}

if ( get_option( 'sports-bench-basketball-halves' ) ) {
	$halves = get_option( 'sports-bench-basketball-halves' );
} else {
	$halves = '0';
}

if ( get_option( 'sports-bench-player-page' ) ) {
	$player = get_option( 'sports-bench-player-page' );
} else {
	$player = '';
}

if ( get_option( 'sports-bench-team-page' ) ) {
	$team = get_option( 'sports-bench-team-page' );
} else {
	$team = '';
}

if ( get_option( 'sports-bench-box-score-page' ) ) {
	$box_score = get_option( 'sports-bench-box-score-page' );
} else {
	$box_score = '';
}

if ( get_option( 'sports_bench_plugin_license_key' ) ) {
	$license = get_option( 'sports_bench_plugin_license_key' );
} else {
	$license = '';
}

if ( get_option( 'sports_bench_plugin_license_status' ) ) {
	$license_status = get_option( 'sports_bench_plugin_license_status' );
} else {
	$license_status = '';
}

if ( ! get_option( 'sports_bench_plugin_license_key' ) && 'VcBUPnjMPYRMdPqvWASK' === get_option( 'sports_bench_plugin_lifetime_license' ) ) {
	$display_notice = true;
} else {
	$display_notice = false;
}

?>

<div class="forms-container-wrap">

	<h2><?php esc_html_e( 'Upgrade to the Premium Sports Bench Plugin', 'sports-bench' ); ?></h2>

	<p><?php echo wp_kses_post( __( 'Want more features for your sports website, like playoffs, stat searching, import, export and more? Consider <a href="https://sportsbenchwp.com" target="_blank">purchasing the full Sports Bench plugin</a> to get access to those features and premium support!', 'sports-bench' ) ); ?></p>

</div>
