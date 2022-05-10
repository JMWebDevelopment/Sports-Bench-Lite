<?php
/**
 * Displays the standings meta box.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/posts
 * @author     Jacob Martella <me@jacobmartella.com>
 */

global $post;

if ( 'soccer' === get_option( 'sports-bench-sport' ) || 'hockey' === get_option( 'sports-bench-sport' ) ) {
	$standings_items = array(
		'goals-for'             => esc_html__( 'Goals For', 'sports-bench' ),
		'goals-against'         => esc_html__( 'Goals Against', 'sports-bench' ),
		'goals-differential'    => esc_html__( 'Goal Differential', 'sports-bench' ),
		'home-record'           => esc_html__( 'Home Record', 'sports-bench' ),
		'away-record'           => esc_html__( 'Away Record', 'sports-bench' ),
		'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
		'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
	);
} elseif ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
	$standings_items = array(
		'runs-for'          => esc_html__( 'Runs For', 'sports-bench' ),
		'runs-against'      => esc_html__( 'Runs Against', 'sports-bench' ),
		'run-differential'  => esc_html__( 'Run Differential', 'sports-bench' ),
		'home-record'       => esc_html__( 'Home Record', 'sports-bench' ),
		'away-record'       => esc_html__( 'Away Record', 'sports-bench' ),
		'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
		'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
	);
} else {
	$standings_items = array(
		'points-for'            => esc_html__( 'Points For', 'sports-bench' ),
		'points-against'        => esc_html__( 'Points Against', 'sports-bench' ),
		'points-differential'   => esc_html__( 'Point Differential', 'sports-bench' ),
		'home-record'           => esc_html__( 'Home Record', 'sports-bench' ),
		'away-record'           => esc_html__( 'Away Record', 'sports-bench' ),
		'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
		'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
	);
}

$values = get_post_custom( $post->ID );
if ( isset( $values['sports_bench_standings_league'] ) ) {
	$league = $values['sports_bench_standings_league'][0];
} else {
	$league = '';
}
if ( isset( $values['sports_bench_standings_conference'] ) ) {
	$conference = $values['sports_bench_standings_conference'][0];
} else {
	$conference = '';
}
if ( isset( $values['sports_bench_standings_division'] ) ) {
	$division = $values['sports_bench_standings_division'][0];
} else {
	$division = '';
}
$items = get_post_meta( $post->ID, 'sports_bench_standings_items', true );
wp_nonce_field( 'sports_bench_standings_meta_box_nonce', 'sports_bench_standings_meta_box_nonce' );

echo '<table cellspacing="2" cellpadding="5" style="width: 100%; max-width: 100%;" class="form-table">';

echo '<tr>';
echo '<td>' . esc_html__( 'Displays to Show', 'sports-bench' ) . '</label></td>';
echo '<td><span class="game-status-input"><label for="sports_bench_standings_league">' . apply_filters( 'sports_bench_league_name', esc_html__( 'League', 'sports-bench' ) ) . ' ' . esc_html__( 'Standings: ', 'sports-bench' ) . '</label><input id="sports_bench_standings_league" name="sports_bench_standings_league" type="checkbox" value="1" ' . checked( '1', esc_attr( $league ), false ) . ' size="6"></span></td>';
echo '<td><span class="game-status-input"><label for="sports_bench_standings_conference">' . apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Standings: ', 'sports-bench' ) . '</label><input id="sports_bench_standings_conference" name="sports_bench_standings_conference" type="checkbox" value="1" ' . checked( '1', esc_attr( $conference ), false ) . ' size="6"></span></td>';
echo '<td><span class="game-status-input"><label for="sports_bench_standings_division">' . apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Standings: ', 'sports-bench' ) . '</label><input id="sports_bench_standings_division" name="sports_bench_standings_division" type="checkbox" value="1" ' . checked( '1', esc_attr( $division ), false ) . ' size="6"></span></td>';
echo '</tr>';

echo '</table>';
echo '<table cellspacing="2" cellpadding="5" style="width: 100%; max-width: 100%;" class="form-table">';
echo '<tbody style="width: 100%; max-width: 100%;">';
echo '<tr style="width: 100%; max-width: 100%;">';
echo '<th>' . esc_html__( 'Items to Show', 'sports-bench' ) . '</th>';
echo '<td>';
if ( $items ) {
	foreach ( $items as $item ) {
		echo '<div class="standings-item" style="text-align: center;float: left; display: inline-block;margin: 5px;"><select name="sports_bench_standings_items[]" id="sports_bench_standings_items" style="margin-bottom: 5px;">';
		foreach ( $standings_items as $key => $name ) {
			if ( $key === $item['sports_bench_standings_items'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . wp_kses_post( $name ) . '</option>';
		}
		echo '</select><br /><a class="button sports-bench-remove-item" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></div>';
	}
} else {
	echo '<div class="standings-item" style="text-align: center;float: left; display: inline-block;margin: 5px;"><select name="sports_bench_standings_items[]" id="sports_bench_standings_items" style="margin-bottom: 5px;">';
	foreach ( $standings_items as $key => $name ) {
		echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $name ) . '</option>';
	}
	echo '</select><br /><a class="button sports-bench-remove-item" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></div>';
}
echo '<div class="sports-bench-empty-item screen-reader-text" style="text-align: center;float: left; display: inline-block;margin: 5px;"><select class="new-field" name="sports_bench_standings_items[]" id="sports_bench_standings_items" disabled="disabled" style="margin-bottom: 5px;">';
foreach ( $standings_items as $key => $name ) {
	echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $name ) . '</option>';
}
echo '</select><br /><a class="button sports-bench-remove-item" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></div>';
echo '</td>';
echo '</tr>';
echo '<tr><td><a id="sports-bench-add-item" class="button" href="#">' . esc_html__( 'Add Item', 'sports-bench' ) . '</a></td></tr>';
echo '</tbody>';
echo '</table>';
