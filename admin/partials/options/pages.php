<?php
/**
 * Displays the pages options screen.
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

if ( get_option( 'sports_bench_plugin_license_key' ) ) {
	$license = get_option( 'sports_bench_plugin_license_key' );
} else {
	$license = '';
}

$page_list        = get_pages();
$page_ags['none'] = esc_html__( 'None', 'sports-bench' );
foreach ( $page_list as $the_page ) {
	$page_ags[ $the_page->ID ] = $the_page->post_title;
}

?>

<div class="forms-container-wrap">

	<h2><?php esc_html_e( 'Page Options', 'sports-bench' ); ?></h2>

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
					<td><label for="sports-bench-player-page"><?php esc_html_e( 'Player Page:', 'sports-bench' ); ?></td>
					<td>
						<select id="sports-bench-player-page" name="sports-bench-player-page">
							<?php
							foreach ( $page_ags as $key => $label ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $player ); ?>><?php echo esc_html( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
				<td><label for="sports-bench-team-page"><?php esc_html_e( 'Team Page:', 'sports-bench' ); ?></td>
					<td>
						<select id="sports-bench-team-page" name="sports-bench-team-page">
							<?php
							foreach ( $page_ags as $key => $label ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $team ); ?>><?php echo esc_html( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
				<td><label for="sports-bench-box-score-page"><?php esc_html_e( 'Box Score Page:', 'sports-bench' ); ?></td>
					<td>
						<select id="sports-bench-box-score-page" name="sports-bench-box-score-page">
							<?php
							foreach ( $page_ags as $key => $label ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $box_score ); ?>><?php echo esc_html( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="hidden" name="sports-bench-display-game" value="<?php echo esc_attr( $display ); ?>" />
		<input type="hidden" name="sports-bench-display-map" value="<?php echo esc_attr( $display_map ); ?>" />
		<input type="hidden" name="sports-bench-week-maps-api-key" value="<?php echo esc_attr( $map_api_key ); ?>" />
		<input type="hidden" name="sports-bench-abbreviation-guide" value="<?php echo esc_attr( $guide ); ?>" />
		<input type="hidden" name="sports-bench-use-fonts" value="<?php echo esc_attr( $font ); ?>" />
		<input type="hidden" name="sports-bench-sport" value="<?php echo esc_attr( $sport ); ?>" />
		<input type="hidden" name="sports-bench-season-year" value="<?php echo esc_attr( $sports_year ); ?>" />
		<input type="hidden" name="sports-bench-season" value="<?php echo esc_attr( $season ); ?>" />
		<input type="hidden" name="sports-bench-week-number" value="<?php echo esc_attr( $week ); ?>" />
		<input type="hidden" name="sports-bench-basketball-halves" value="<?php echo esc_attr( $halves ); ?>" />
		<input type="hidden" name="sports_bench_plugin_license_key" value="<?php echo esc_attr( $license ); ?>" />
		<input type="hidden" name="action" value="update" />
		<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
	</form>

</div>
