<?php
/**
 * Displays the import options screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/options
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Options;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\OptionsScreen;

$screen = new OptionsScreen();

$mimes = [ 'application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv' ];

$game_columns = [
	'baseball'      => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_doubles, game_home_triples, game_home_homeruns, game_home_hits, game_home_errors, game_home_lob, game_away_doubles, game_away_triples, game_away_homeruns, game_away_hits, game_away_errors, game_away_lob',
	'basketball'    => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_time_of_game, game_home_first_quarter, game_home_second_quarter, game_home_third_quarter, game_home_third_quarter, game_home_fourth_quarter, game_home_overtime, game_home_fgm, game_home_fga, game_home_3pm, game_home_3pa, game_home_ftm, game_home_fta, game_home_off_rebound, game_home_def_rebound, game_home_assists, game_home_steals, game_home_blocks, game_home_pip, game_home_to, game_home_pot, game_home_fast_break, game_home_fouls, game_away_first_quarter, game_away_second_quarter, game_away_third_quarter, game_away_fourth_quarter, game_away_overtime, game_away_fgm, game_away_fga, game_away_3pm, game_away_3pa, game_away_ftm, game_away_fta, game_away_off_rebound, game_away_def_rebound, game_away_assists, game_away_steals, game_away_blocks, game_away_pip, game_away_to, game_away_pot, game_away_fast_break, game_away_fouls',
	'football'      => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_first_quarter, game_home_second_quarter, game_home_third_quarter, game_home_fourth_quarter, game_home_overtime, game_home_total, game_home_pass, game_home_rush, game_home_to, game_home_ints, game_home_fumbles game_home_fumbles_lost, game_home_possession, game_home_kick_returns, game_home_kick_return_yards, game_home_penalties, game_home_penalty_yards, game_home_first_downs, game_away_first_quarter, game_away_second_quarter, game_away_third_quarter, game_away_fourth_quarter, game_away_overtime, game_away_total, game_away_pass, game_away_rush, game_away_to, game_away_ints, game_away_fumbles, game_away_fumbles_lost, game_away_possession, game_away_kick_returns, game_away_kick_return_yards, game_away_penalties, game_away_penalty_yards, game_away_first_downs',
	'hockey'        => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_first_period, game_home_first_sog, game_home_second_period, game_home_second_sog, game_home_third_period, game_home_third_sog, game_home_overtime, game_home_overtime_sog, game_home_shootout, game_home_power_plays, game_home_pp_goals, game_home_pen_minutes, game_away_first_period, game_away_first_sog, game_away_second_period, game_away_second_sog, game_away_third_period, game_away_third_sog, game_away_overtime, game_away_overtime_sog, game_away_shootout, game_away_power_plays, game_away_pp_goals, game_away_pen_minutes',
	'rugby'         => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_first_half, game_home_second_half, game_home_extratime, game_home_shootout, game_home_tries, game_home_conversions, game_home_penalty_goals, game_home_kick_percentage, game_home_meters_runs, game_home_meters_hand, game_home_meters_pass, game_home_possession, game_home_clean_breaks, game_home_defenders_beaten, game_home_offload, game_home_rucks, game_home_mauls, game_home_turnovers_conceeded, game_home_scrums, game_home_lineouts, game_home_penalties_conceeded, game_home_red_cards, game_home_yellow_cards, game_home_free_kicks_conceeded, game_away_first_half, game_away_second_half,game_away_extratime, game_away_shootout, game_away_tries, game_away_conversions, game_away_penalty_goals, game_away_kick_percentage, game_away_meters_runs, game_away_meters_hand, game_away_meters_pass, game_away_possession, game_away_clean_breaks, game_away_defenders_beaten, game_away_offload, game_away_rucks, game_away_mauls, game_away_turnovers_conceeded, game_away_scrums, game_away_lineouts, game_away_penalties_conceeded, game_away_red_cards, game_away_yellow_cards, game_away_free_kicks_conceeded',
	'soccer'        => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_first_half, game_home_second_half, game_home_extratime, game_home_pks, game_home_possession, game_home_shots, game_home_sog, game_home_corners, game_home_offsides, game_home_fouls, game_home_saves, game_home_yellow, game_home_red, game_away_first_half, game_away_second_half, game_away_extratime, game_away_pks, game_away_possession, game_away_shots, game_away_sog, game_away_corners, game_away_offsides, game_away_fouls, game_away_saves, game_away_yellow, game_away_red',
	'volleyball'    => 'game_id, game_week, , game_day, game_season, game_home_id, game_away_id, game_home_final, game_away_final, game_attendance, game_status, game_recap, game_preview, game_current_period, game_current_time, game_current_home_score, game_current_away_score, game_recap, game_preview, game_home_first_set, game_home_second_set, game_home_third_set, game_home_fourth_set, game_home_fifth_set, game_home_kills, game_home_blocks, game_home_aces, game_home_assists, game_home_digs, game_home_attacks, game_home_hitting_errors, game_away_first_set, game_away_second_set, game_away_third_set, game_away_fourth_set, game_away_fifth_set, game_away_kills, game_away_blocks, game_away_aces, game_away_assists, game_away_digs, game_away_attacks, game_away_hitting_errors',
];

$game_info_columns = [
	'baseball'      => 'game_info_id, game_id, game_info_inning, game_info_top_bottom, game_info_home_score, game_info_away_score, game_info_runs_scored, game_info_score_play',
	'basketball'    => '',
	'football'      => 'game_info_id, game_id, game_info_quarter, game_info_time, game_info_scoring_team_id, game_info_home_score, game_info_away_score, game_info_play',
	'hockey'        => 'game_info_id, game_id, game_info_event, game_info_period, game_info_time, player_id, game_info_assist_one_id, game_info_assist_two_id, team_id',
	'rugby'         => 'game_info_id, game_id, team_id, game_info_home_score, game_info_away_score, game_info_event, game_info_time, player_id',
	'soccer'        => 'game_info_id, game_id, team_id, game_info_home_score, game_info_away_score, game_info_event, game_info_time, player_id, game_player_name, game_info_assists',
	'volleyball'    => '',
];

$game_stats_columns = [
	'baseball'      => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_at_bats, game_player_hits, game_player_runs, game_player_rbis, game_player_doubles, game_player_triples, game_player_homeruns, game_player_strikeouts, game_player_strikeouts, game_player_walks, game_player_hit_by_pitch, game_player_fielders_choice, game_player_position, game_player_innings_pitched, game_player_pitcher_strikeouts, game_player_pitcher_walks, game_player_hit_batters, game_player_runs_allowed, game_player_earned_runs, game_player_hits_allowed, game_player_homeruns_allowed, game_player_pitch_count, game_player_decision',
	'basketball'    => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_started, game_player_minutes, game_player_fgm, game_player_fga, game_player_3pm, game_player_3pa, game_player_ftm, game_player_fta, game_player_points, game_player_off_rebound, game_player_def_rebound, game_player_assists, game_player_steals, game_player_blocks, game_player_to, game_player_fouls, game_player_plus_minus',
	'football'      => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_completions, game_player_attempts, game_player_pass_yards, game_player_pass_tds, game_player_pass_ints, game_player_rushes, game_player_rush_yards, game_player_rush_tds, game_player_rush_fumbles, game_player_catches, game_player_receiving_yards, game_player_receiving_tds, game_player_receiving_fumbles, game_player_tackles, game_player_tfl, game_player_sacks, game_player_pbu, game_player_ints, game_player_tds, game_player_ff, game_player_fr, game_player_blocked, game_player_yards, game_player_fga, game_player_fgm, game_player_xpa, game_player_xpm, game_player_touchbacks, game_player_returns, game_player_return_yards, game_player_return_tds, game_player_return_fumbles',
	'hockey'        => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_goals, game_player_assists, game_player_plus_minus, game_player_sog, game_player_penalties, game_player_pen_minutes, game_player_hits, game_player_shifts, game_player_time_on_ice, game_player_faceoffs, game_player_faceoff_wins, game_player_shots_faced, game_player_saves, game_player_goals_allowed',
	'rugby'         => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_tries, game_player_assists, game_player_conversions, game_player_penalty_goals, game_player_drop_kicks, game_player_points, game_player_penalties_conceeded, game_player_meters_run, game_player_red_cards, game_player_yellow_cards',
	'soccer'        => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_minutes, game_player_goals, game_player_assists, game_player_shots game_player_sog, game_player_fouls, game_player_fouls_suffered, game_player_shots_faced, game_player_shots_saved, game_player_goals_allowed',
	'volleyball'    => 'game_stats_player_id, game_id, game_team_id, game_player_id, game_player_sets_played, game_player_points, game_player_kills, game_player_hitting_errors, game_player_attacks, game_player_set_attempts, game_player_set_errors, game_player_serves, game_player_serve_errors, game_player_aces, game_player_blocks, game_player_block_attempts, game_player_block_errors, game_player_digs, game_player_receiving_errors',
];

$available_columns = [
	'divisions'         => 'division_id, division_name, division_conference, division_conference_id, division_color',
	'games'             => $game_columns[ get_option( 'sports-bench-sport' ) ],
	'game_info'         => $game_info_columns[ get_option( 'sports-bench-sport' ) ],
	'game_stats'        => $game_stats_columns[ get_option( 'sports-bench-sport' ) ],
	'players'           => 'player_id, player_first_name, player_last_name, player_birth_day, player_photo, player_position, player_home_city, player_home_state, team_id, player_weight, player_height, player_slug',
	'playoff_brackets'  => 'bracket_id, num_teams, bracket_format, bracket_title, bracket_season',
	'playoff_series'    => 'series_id, bracket_id, series_format, playoff_round, team_one_id, team_one_seed, team_two_id, team_two_seed, game_ids, opposite_series',
	'teams'             => 'team_id, team_name, team_location, team_nickname, team_abbreviation, team_active, team_city, team_state, team_stadium, team_stadium_capacity, team_head_coach, team_division, team_primary_color, team_secondary_color, team_logo, team_photo, team_slug',
];


?>

<div class="forms-container-wrap">

	<?php
	if ( isset( $_FILES['sports_bench_csv_upload'] ) && in_array( $_FILES['sports_bench_csv_upload']['type'], $mimes ) ) {
		$message = $screen->upload_csv( $_POST );
	} else {
		if ( ! isset( $_FILES['sports_bench_csv_upload'] ) ) {
			$message = [];
		} else {
			$message = [ '', esc_html__( 'There has been an error uploading the csv file. Please make sure the file has an extension of csv and re-upload the file.', 'sports-bench' ) ];
		}
	}
	?>

	<?php
	if ( is_array( $message ) ) {
		if ( isset( $message[0] ) && '' !== $message[0] ) {
			?>
			<div id="message" class="updated"><p><?php echo esc_html( $message[0] ); ?></p></div>
			<?php
		} elseif ( isset( $message[1] ) && '' !== $message[1] ) {
			?>
			<div id="notice" class="error"><p><?php echo esc_html( $message[1] ); ?></p></div>
			<?php
		}
	}
	?>

	<h2><?php esc_html_e( 'Import', 'sports-bench' ); ?></h2>

	<p><?php esc_html_e( 'If you\'ve already got a database for your sports league that you want to bring over to this site, you can import it as a csv here. Please note that you\'ll need a separate csv for each of the tables listed below. You\'ll also need the csv to have to correct column headings listed for each column. The rows don\'t necessarily need values for the columns, but the columns need to be there in order for the import to work.', 'sports-bench' ); ?></p>

	<div class="import-section">

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Divisions', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your division csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['divisions'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_division"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_division" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="divisions" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Games', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your game csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['games'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_games"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_games" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="games" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Game Events', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your game events csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['game_info'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_game_info"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_game_info" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="game_info" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Game Stats', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your game stats csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['game_stats'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_game_stats"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_game_stats" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="game_stats" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Players', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your player csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['players'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_players"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_players" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="players" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Playoff Brackets', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your playoff bracket csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['playoff_brackets'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_playoff_brackets"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_playoff_brackets" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="playoff_brackets" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Playoff Series', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your playoff series csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['playoff_series'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_playoff_series"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_playoff_series" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="playoff_series" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

		<div class="import-table-section">

			<div class="import-table-section-header">

				<h3><?php esc_html_e( 'Add Teams', 'sports-bench' ); ?></h3>

			</div>

			<div class="import-table-section-body">

				<p><?php esc_html_e( 'Here are the column headers you will need for your teams csv file:', 'sports-bench' ); ?></p>
				<p><?php echo esc_html( $available_columns['teams'] ); ?></p>

				<form class="import-form" method="post" enctype="multipart/form-data" action="?page=sports-bench-options&tab=import">
					<?php wp_nonce_field( 'sports_bench_import_nonce', 'sports_bench_import_nonce' ); ?>

					<table>
						<tr>
							<td><label for="sports_bench_csv_upload_teams"><?php esc_html_e( 'File to Upload', 'sports-bench' ); ?></label></td>
							<td><input type="file" id="sports_bench_csv_upload_teams" name="sports_bench_csv_upload" /></td>
						</tr>
					</table>
					<input type="hidden" name="sports_bench_table" value="teams" />
					<?php submit_button( esc_html__( 'Upload CSV', 'sports-bench' ) ); ?>
				</form>

			</div>

		</div>

	</div>

</div>
