<?php
/**
 * Displays the general options screen.
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

	<h2><?php esc_html_e( 'General Options', 'sports-bench' ); ?></h2>

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
					<td><label for="sports-bench-sport"><?php esc_html_e( 'Sport:', 'sports-bench' ); ?></td>
					<td>
						<select id="sports-bench-sport" name="sports-bench-sport">
							<option value="baseball" <?php selected( $sport, 'baseball' ); ?>><?php esc_html_e( 'Baseball', 'sports-bench' ); ?></option>
							<option value="basketball" <?php selected( $sport, 'basketball' ); ?>><?php esc_html_e( 'Basketball', 'sports-bench' ); ?></option>
							<option value="football" <?php selected( $sport, 'football' ); ?>><?php esc_html_e( 'Football', 'sports-bench' ); ?></option>
							<option value="hockey" <?php selected( $sport, 'hockey' ); ?>><?php esc_html_e( 'Hockey', 'sports-bench' ); ?></option>
							<option value="rugby" <?php selected( $sport, 'rugby' ); ?>><?php esc_html_e( 'Rugby', 'sports-bench' ); ?></option>
							<option value="soccer" <?php selected( $sport, 'soccer' ); ?>><?php esc_html_e( 'Soccer', 'sports-bench' ); ?></option>
							<option value="volleyball" <?php selected( $sport, 'volleyball' ); ?>><?php esc_html_e( 'Volleyball', 'sports-bench' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="sports-bench-season-year"><?php esc_html_e( 'Current Season:', 'sports-bench' ); ?></td>
					<td><input type="text" id="sports-bench-season-year" name="sports-bench-season-year" value="<?php echo esc_attr( $sports_year ); ?>" /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-season"><?php esc_html_e( 'Does the league\'s season span two numerical years? (i.e. 2015-16):', 'sports-bench' ); ?></td>
					<td><input type="checkbox" id="sports-bench-season" name="sports-bench-season" value="1" <?php checked( $season, 1 ); ?> /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-week-number"><?php esc_html_e( 'Current Week:', 'sports-bench' ); ?></td>
					<td><input type="number" id="sports-bench-week-number" name="sports-bench-week-number" value="<?php echo esc_attr( $week ); ?>" /></td>
				</tr>
				<tr>
					<td><label for="sports-bench-basketball-halves"><?php esc_html_e( 'Display basketball scoreline by half:', 'sports-bench' ); ?></td>
					<td><input type="checkbox" id="sports-bench-basketball-halves" name="sports-bench-basketball-halves" value="1" <?php checked( $halves, 1 ); ?> /></td>
				</tr>
			</tbody>
		</table>

		<input type="hidden" name="sports-bench-display-game" value="<?php echo esc_attr( $display ); ?>" />
		<input type="hidden" name="sports-bench-display-map" value="<?php echo esc_attr( $display_map ); ?>" />
		<input type="hidden" name="sports-bench-week-maps-api-key" value="<?php echo esc_attr( $map_api_key ); ?>" />
		<input type="hidden" name="sports-bench-abbreviation-guide" value="<?php echo esc_attr( $guide ); ?>" />
		<input type="hidden" name="sports-bench-use-fonts" value="<?php echo esc_attr( $font ); ?>" />
		<input type="hidden" name="sports-bench-player-page" value="<?php echo esc_attr( $player ); ?>" />
		<input type="hidden" name="sports-bench-team-pagee" value="<?php echo esc_attr( $team ); ?>" />
		<input type="hidden" name="sports-bench-box-score-page" value="<?php echo esc_attr( $box_score ); ?>" />
		<input type="hidden" name="sports_bench_plugin_license_key" value="<?php echo esc_attr( $license ); ?>" />
		<input type="hidden" name="action" value="update" />
		<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
	</form>

</div>
