<?php
/**
 * Displays the stats meta box.
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

if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'at_bats'               => esc_html__( 'At Bats', 'sports-bench' ),
		'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
		'batting_average'       => esc_html__( 'Batting Average', 'sports-bench' ),
		'runs'                  => esc_html__( 'Runs', 'sports-bench' ),
		'rbis'                  => esc_html__( 'RBI', 'sports-bench' ),
		'doubles'               => esc_html__( 'Doubles', 'sports-bench' ),
		'triples'               => esc_html__( 'Triples', 'sports-bench' ),
		'homeruns'              => esc_html__( 'Home Runs', 'sports-bench' ),
		'strikeouts'            => esc_html__( 'Strikeouts', 'sports-bench' ),
		'walks'                 => esc_html__( 'Walks', 'sports-bench' ),
		'hit_by_pitch'          => esc_html__( 'Hit By Pitch', 'sports-bench' ),
		'wins'                  => esc_html__( 'Wins', 'sports-bench' ),
		'saves'                 => esc_html__( 'Saves', 'sports-bench' ),
		'innings_pitched'       => esc_html__( 'Innings Pitched', 'sports-bench' ),
		'pitcher_strikeouts'    => esc_html__( 'Pitcher Strikeouts', 'sports-bench' ),
		'pitcher_walks'         => esc_html__( 'Pitcher Walks', 'sports-bench' ),
		'hit_batters'           => esc_html__( 'Hit Batters', 'sports-bench' ),
		'runs_allowed'          => esc_html__( 'Runs Allowed', 'sports-bench' ),
		'earned_runs'           => esc_html__( 'Earned Runs', 'sports-bench' ),
		'era'                   => esc_html__( 'ERA', 'sports-bench' ),
		'hits_allowed'          => esc_html__( 'Hits Allowed', 'sports-bench' ),
		'homeruns_allowed'      => esc_html__( 'Home Runs Allowed', 'sports-bench' ),
		'pitch_count'           => esc_html__( 'Pitch Count', 'sports-bench' ),
	];
} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'started'               => esc_html__( 'Starts', 'sports-bench' ),
		'minutes'               => esc_html__( 'Minutes', 'sports-bench' ),
		'points'                => esc_html__( 'Points', 'sports-bench' ),
		'points_per_game'       => esc_html__( 'Points Per Game', 'sports-bench' ),
		'shooting_percentage'   => esc_html__( 'Shooting Percentage', 'sports-bench' ),
		'ft_percentage'         => esc_html__( 'Free Throw Percentage', 'sports-bench' ),
		'3p_percentage'         => esc_html__( '3-Point Percentage', 'sports-bench' ),
		'off_rebound'           => esc_html__( 'Offensive Rebounds', 'sports-bench' ),
		'def_rebound'           => esc_html__( 'Defensive Rebounds', 'sports-bench' ),
		'rebounds'              => esc_html__( 'Total Rebounds', 'sports-bench' ),
		'assists'               => esc_html__( 'Assists', 'sports-bench' ),
		'steals'                => esc_html__( 'Steals', 'sports-bench' ),
		'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
		'to'                    => esc_html__( 'Turnovers', 'sports-bench' ),
		'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
		'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
	];
} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'completions'       => esc_html__( 'Completions', 'sports-bench' ),
		'attempts'          => esc_html__( 'Attempts', 'sports-bench' ),
		'comp_percentage'   => esc_html__( 'Completion Percentage', 'sports-bench' ),
		'pass_yards'        => esc_html__( 'Passing Yards', 'sports-bench' ),
		'pass_tds'          => esc_html__( 'Passing Touchdowns', 'sports-bench' ),
		'pass_ints'         => esc_html__( 'Interceptions', 'sports-bench' ),
		'rushes'            => esc_html__( 'Rushes', 'sports-bench' ),
		'rush_yards'        => esc_html__( 'Rushing Yards', 'sports-bench' ),
		'rush_tds'          => esc_html__( 'Rushing Touchdowns', 'sports-bench' ),
		'rush_fumbles'      => esc_html__( 'Rushing Fumbles', 'sports-bench' ),
		'catches'           => esc_html__( 'Catches', 'sports-bench' ),
		'receiving_yards'   => esc_html__( 'Receiving Yards', 'sports-bench' ),
		'receiving_tds'     => esc_html__( 'Receiving Touchdowns', 'sports-bench' ),
		'receiving_fumbles' => esc_html__( 'Receiving Fumbles', 'sports-bench' ),
		'tackles'           => esc_html__( 'Tackles', 'sports-bench' ),
		'tfl'               => esc_html__( 'Tackles For Loss', 'sports-bench' ),
		'sacks'             => esc_html__( 'Sacks', 'sports-bench' ),
		'pbu'               => esc_html__( 'Pass Breakups', 'sports-bench' ),
		'ints'              => esc_html__( 'Interceptions', 'sports-bench' ),
		'tds'               => esc_html__( 'Defensive Touchdowns', 'sports-bench' ),
		'ff'                => esc_html__( 'Forced Fumbles', 'sports-bench' ),
		'fr'                => esc_html__( 'Fumbles Recovered', 'sports-bench' ),
		'blocked'           => esc_html__( 'Blocked Kicks', 'sports-bench' ),
		'yards'             => esc_html__( 'Defensive Return Yards', 'sports-bench' ),
		'fgm'               => esc_html__( 'Made Field Goals', 'sports-bench' ),
		'fg_percentage'     => esc_html__( 'Field Goal Percentage', 'sports-bench' ),
		'xpm'               => esc_html__( 'Made Extra Points', 'sports-bench' ),
		'xp_percentage'     => esc_html__( 'Extra Point Percentage', 'sports-bench' ),
		'touchbacks'        => esc_html__( 'Touchbacks', 'sports-bench' ),
		'returns'           => esc_html__( 'Returns', 'sports-bench' ),
		'return_yards'      => esc_html__( 'Return Yards', 'sports-bench' ),
		'return_tds'        => esc_html__( 'Return Touchdowns', 'sports-bench' ),
		'return_fumbles'    => esc_html__( 'Return Fumbles', 'sports-bench' )
	];
} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
		'assists'               => esc_html__( 'Assists', 'sports-bench' ),
		'points'                => esc_html__( 'Points', 'sports-bench' ),
		'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
		'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
		'penalties'             => esc_html__( 'Penalties', 'sports-bench' ),
		'pen_minutes'           => esc_html__( 'Penalty Minutes', 'sports-bench' ),
		'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
		'shifts'                => esc_html__( 'Shifts', 'sports-bench' ),
		'time_on_ice'           => esc_html__( 'Time on Ice', 'sports-bench' ),
		'faceoffs'              => esc_html__( 'Faceoffs', 'sports-bench' ),
		'faceoff_wins'          => esc_html__( 'Faceoff Wins', 'sports-bench' ),
		'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
		'saves'                 => esc_html__( 'Shots Saved', 'sports-bench' ),
		'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
		'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
	];
} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'tries'                 => esc_html__( 'Tries', 'sports-bench' ),
		'assists'               => esc_html__( 'Assists', 'sports-bench' ),
		'conversions'           => esc_html__( 'Conversions', 'sports-bench' ),
		'penalty_goals'         => esc_html__( 'Penalty Goals', 'sports-bench' ),
		'drop_kicks'            => esc_html__( 'Drop Kicks', 'sports-bench' ),
		'points'                => esc_html__( 'Points', 'sports-bench' ),
		'penalties_conceeded'   => esc_html__( 'Penalties Conceded', 'sports-bench' ),
		'meters_run'            => esc_html__( 'Meters Run', 'sports-bench' ),
		'red_cards'             => esc_html__( 'Red Cards', 'sports-bench' ),
		'yellow_cards'          => esc_html__( 'Yellow Cards', 'sports-bench' ),
	];
} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
	$stats_items = [
		'sets_played'           => esc_html__( 'Sets Played', 'sports-bench' ),
		'points'                => esc_html__( 'Points', 'sports-bench' ),
		'kills'                 => esc_html__( 'Kills', 'sports-bench' ),
		'hitting_errors'        => esc_html__( 'Hitting Errors', 'sports-bench' ),
		'attacks'               => esc_html__( 'Attacks', 'sports-bench' ),
		'hitting_percentage'    => esc_html__( 'Hitting Percentage', 'sports-bench' ),
		'set_attempts'          => esc_html__( 'Set Attempts', 'sports-bench' ),
		'set_errors'            => esc_html__( 'Setting Errors', 'sports-bench' ),
		'serves'                => esc_html__( 'Serves', 'sports-bench' ),
		'serve_errors'          => esc_html__( 'Serving Errors', 'sports-bench' ),
		'aces'                  => esc_html__( 'Aces', 'sports-bench' ),
		'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
		'block_attempts'        => esc_html__( 'Block Attempts', 'sports-bench' ),
		'block_errors'          => esc_html__( 'Blocking Errors', 'sports-bench' ),
		'digs'                  => esc_html__( 'Digs', 'sports-bench' ),
		'receiving_errors'      => esc_html__( 'Receiving Errors', 'sports-bench' ),
	];
} else {
	$stats_items = [
		'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
		'assists'               => esc_html__( 'Assists', 'sports-bench' ),
		'shots'                 => esc_html__( 'Shots', 'sports-bench' ),
		'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
		'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
		'fouls_suffered'        => esc_html__( 'Fouls Suffered', 'sports-bench' ),
		'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
		'shots_saved'           => esc_html__( 'Shots Saved', 'sports-bench' ),
		'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
		'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
	];
}

$items = get_post_meta( $post->ID, 'sports_bench_stats', true );
wp_nonce_field( 'sports_bench_stats_meta_box_nonce', 'sports_bench_stats_meta_box_nonce' );

echo '<table cellspacing="2" cellpadding="5" style="width: 100%; max-width: 100%;" class="form-table">';
echo '<tbody style="width: 100%; max-width: 100%;">';
if ( $items ) {
	foreach ( $items as $item ) {
		echo '<tr class="sports-bench-stat-row">';
		echo '<td class="stats-item"><span class="screen-reader-text"><label for="sports_bench_stats">' . esc_html__( 'Select a Stat', 'sports-bench' ) . '</label></span><select name="sports_bench_stats[]" id="sports_bench_stats" style="margin-right: 5px;">';
		foreach ( $stats_items as $key => $name ) {
			if ( $key === $item['sports_bench_stats'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $key ) . '" ' . wp_kses_post( $selected ) . '>' . esc_html( $name ) . '</option>';
		}
		echo '</select><a class="button sports-bench-remove-stat" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></td>';
		echo '</tr>';
	}
} else {
	echo '<tr class="sports-bench-stat-row">';
	echo '<td class="stats-item"><span class="screen-reader-text"><label for="sports_bench_stats">' . esc_html__( 'Select a Stat', 'sports-bench' ) . '</label></span><select name="sports_bench_stats[]" id="sports_bench_stats" style="margin-right: 5px;">';
	foreach ( $stats_items as $key => $name ) {
		echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $name ) . '</option>';
	}
	echo '</select><a class="button sports-bench-remove-stat" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></td>';
	echo '</tr>';
}
echo '<tr class="sports-bench-empty-stat-row screen-reader-text">';
echo '<td><span class="screen-reader-text"><label for="sports_bench_stats">' . esc_html__( 'Select a Stat', 'sports-bench' ) . '</label></span><select class="new-field" name="sports_bench_stats[]" id="sports_bench_stats" disabled="disabled" style="margin-right: 5px;">';
foreach ( $stats_items as $key => $name ) {
	echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $name ) . '</option>';
}
echo '</select><a class="button sports-bench-remove-stat" href="#">' . esc_html__( 'Remove Item', 'sports-bench' ) . '</a></td>';
echo '</tr>';
echo '</tbody>';
echo '</table>';
echo '<tr><td><a id="sports-bench-add-stat" class="button" href="#">' . esc_html__( 'Add Item', 'sports-bench' ) . '</a></td></tr>';
