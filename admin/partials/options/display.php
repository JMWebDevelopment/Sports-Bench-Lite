<?php
/**
 * Displays the dislpay options screen.
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

?>

<div class="forms-container-wrap">

	<h2><?php esc_html_e( 'Display Options', 'sports-bench' ); ?></h2>

	<form id="form" method="POST" action="options.php">
		<?php
		wp_nonce_field( 'update-options' );
		settings_fields( 'sports_bench_options_settings' );
		?>
		<table class="form-table">
			<thead>
				<tr>
					<th><span class="screen-reader-text"><?php esc_html_e( 'Option', 'sports-bench' ); ?></span>
					<th><span class="screen-reader-text"><?php esc_html_e( 'Field', 'sports-bench' ); ?></span>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label for="sports-bench-display-game"><?php esc_html_e( 'Display games in the scoreboard by week:', 'sports-bench' ); ?></td>
					<td><input type="checkbox" id="sports-bench-display-game" name="sports-bench-display-game" value="1" <?php checked( $display, 1 ); ?> /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-display-map"><?php esc_html_e( 'Display Google Map with Game Location in Preview:', 'sports-bench' ); ?></td>
					<td><input type="checkbox" id="sports-bench-display-map" name="sports-bench-display-map" value="1" <?php checked( $display_map, 1 ); ?> /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-week-maps-api-key"><?php esc_html_e( 'Google Maps API Key:', 'sports-bench' ); ?></td>
					<td><input type="text" id="sports-bench-week-maps-api-key" name="sports-bench-week-maps-api-key" value="<?php echo esc_attr( $map_api_key ); ?>" /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-abbreviation-guide"><?php esc_html_e( 'Display abbreviation guide:', 'sports-bench' ); ?></td>
					<td><input type="checkbox" id="sports-bench-abbreviation-guide" name="sports-bench-abbreviation-guide" value="1" <?php checked( $guide, 1 ); ?> /></td>
				</tr>
			</tbody>
		</table>

		<input type="hidden" name="sports-bench-sport" value="<?php echo esc_attr( $sport ); ?>" />
		<input type="hidden" name="sports-bench-season-year" value="<?php echo esc_attr( $sports_year ); ?>" />
		<input type="hidden" name="sports-bench-season" value="<?php echo esc_attr( $season ); ?>" />
		<input type="hidden" name="sports-bench-week-number" value="<?php echo esc_attr( $week ); ?>" />
		<input type="hidden" name="sports-bench-basketball-halves" value="<?php echo esc_attr( $halves ); ?>" />
		<input type="hidden" name="sports-bench-player-page" value="<?php echo esc_attr( $player ); ?>" />
		<input type="hidden" name="sports-bench-team-pagee" value="<?php echo esc_attr( $team ); ?>" />
		<input type="hidden" name="sports-bench-box-score-page" value="<?php echo esc_attr( $box_score ); ?>" />
		<input type="hidden" name="sports_bench_plugin_license_key" value="<?php echo esc_attr( $license ); ?>" />
		<input type="hidden" name="action" value="update" />
		<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
	</form>

</div>
