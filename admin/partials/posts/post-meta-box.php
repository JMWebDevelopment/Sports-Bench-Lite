<?php
/**
 * Displays the post meta box.
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

global $wpdb;
global $post;

$seasons      = [];
$seasons['']  = esc_html__( 'Select a Season', 'sports-bench' );
$table_name   = $wpdb->prefix . 'sb_games';
$seasons_list = $wpdb->get_results( $wpdb->prepare( 'SELECT DISTINCT game_season FROM %s', $table_name ) );
foreach ( $seasons_list as $season ) {
	$seasons[ $season->game_season ] = $season->game_season;
}

$games      = [];
$games['']  = esc_html__( 'Select a Game', 'sports-bench' );
$table_name = $wpdb->prefix . 'sb_games';
$games_list = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %s ORDER BY game_day DESC;', $table_name ) );
foreach ( $games_list as $game ) {
	$away_team                     = new Team( (int) $game->get_game_away_id() );
	$home_team                     = new Team( (int) $game->get_game_home_id() );
	$date                          = new DateTime( $game->get_game_day() );
	$game_date                     = date_format( $date, get_option( 'date_format' ) );
	$games[ $game->get_game_id() ] = $game_date . ': ' . $away_team->get_team_name . ' at ' . $home_team->get_team_name();
}

$values = get_post_custom( $post->ID );
if ( isset( $values['sports_bench_photo_credit'] ) ) {
	$photo_credit = $values['sports_bench_photo_credit'][0];
} else {
	$photo_credit = '';
}

if ( isset( $values['sports_bench_video'] ) ) {
	$video = $values['sports_bench_video'][0];
} else {
	$video = '';
}

if ( isset( $values['sports_bench_game_preview_recap'] ) ) {
	$preview_recap = $values['sports_bench_game_preview_recap'][0];
} else {
	$preview_recap = 'none';
}

if ( isset( $values['sports_bench_game'] ) ) {
	$game_link = $values['sports_bench_game'][0];
} else {
	$game_link = '';
}

if ( isset( $values['sports_bench_game'] ) ) {
	$games     = [];
	$games['']  = __( 'Select a Game', 'sports-bench' );
	$table_name = $wpdb->prefix . 'sb_games';
	$game       = new Sports_Bench_Game( $values['sports_bench_game'][0] );
	$season     = '"' . $game->game_season . '"';
	$quer       = "SELECT * FROM $table_name WHERE game_season = $season ORDER BY game_day DESC;";
	$games_list = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %s WHERE game_season = %s ORDER BY game_day DESC;', $table_name, $season ) );
	foreach ( $games_list as $game ) {
		$away_team               = new Sports_Bench_Team( (int) $game->game_away_id );
		$home_team               = new Sports_Bench_Team( (int) $game->game_home_id );
		$date                    = new DateTime( $game->game_day );
		$game_date               = date_format( $date, 'F j, Y' );
		$games[ $game->game_id ] = $game_date . ': ' . $away_team->team_name . ' at ' . $home_team->team_name;
	}
}

wp_nonce_field( 'sports_bench_nonce', 'meta_box_nonce' );

echo '<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">';

echo '<tr>';
echo '<td><label for="sports_bench_photo_credit">' . esc_html__( 'Photo Credit', 'sports-bench' ) . '</label></td>';
echo '<td colspan="2"><input type="text" name="sports_bench_photo_credit" id="sports_bench_photo_credit" value="' . esc_attr( $photo_credit ) . '" style="width: 90%;" /></td>';
echo '</tr>';

echo '<tr>';
echo '<td><label for="sports_bench_video">' . esc_html__( 'Link to a Featured Video', 'sports-bench' ) . '</label></td>';
echo '<td colspan="2"><input type="text" name="sports_bench_video" id="sports_bench_video" value="' . esc_attr( $video ) . '" style="width: 90%;" /></td>';
echo '</tr>';

echo '<tr>';
echo '<td><label for="sports-bench-preview-recap">' . esc_html__( 'Preview/Recap', 'sports-bench' ) . '</label></td>';
echo '<td colspan="2"><span class="game-status-input"><label for="sports_bench_game_preview_recap">' . esc_html__( 'None: ', 'sports-bench' ) . '</label><input id="game_none" name="sports_bench_game_preview_recap" type="radio" value="none" ' . checked( 'none', esc_attr( $preview_recap ), false ) . ' size="6"></span>
			<span class="game-status-input"><label for="sports_bench_game_preview_recap">' . esc_html__( 'Preview: ', 'sports-bench' ) . '</label><input id="game_preview" name="sports_bench_game_preview_recap" type="radio" value="preview" ' . checked( 'preview', esc_attr( $preview_recap ), false ) . ' size="6"></span>
			<span class="game-status-input"><label for="sports_bench_game_preview_recap">' . esc_html__( 'Recap: ', 'sports-bench' ) . '</label><input id="game_recap" name="sports_bench_game_preview_recap" type="radio" value="recap" ' . checked( 'recap', esc_attr( $preview_recap ), false ) . ' size="6"></span></td>';
echo '</tr>';

echo '<tr>';
echo '<td><label for="sports_bench_game">' . esc_html__( 'Game', 'sports-bench' ) . '</label></td>';
echo '<td><select id="sports_bench_season" name="sports_bench_season">';
foreach ( $seasons as $key => $name ) {
	if ( '' !== $game_link ) {
		$game   = new Sports_Bench_Game( $game_link );
		$season = $game->game_season;
		if ( $key === $season ) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
	} else {
		$selected = '';
	}
	echo '<option value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $name ) . '</option>';
}
echo '</select></td>';
echo '<td><select id="sports_bench_game" name="sports_bench_game">';
if ( '' !== $game_link ) {
	foreach ( $games as $key => $name ) {
		if ( $key === $game_link ) {
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		echo '<option value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $name ) . '</option>';
	}
}
echo '</select></td>';
echo '</tr>';

echo '</table>';
