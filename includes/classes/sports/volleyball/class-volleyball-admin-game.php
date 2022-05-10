<?php
/**
 * Creates the football game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Volleyball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The football game admin class.
 *
 * This is used for football game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/football
 */
class VolleyballAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new VolleyballAdminGame object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version      The version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Creates the fields for a new game scoreline.
	 *
	 * @since 2.0.0
	 */
	public function new_game_scoreline() {
		?>
		<h2><?php esc_html_e( 'Scoring by Half', 'sports-bench' ); ?></h2>
		<table id="score-line" class="form-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '1', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '2', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '3', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '4', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '5', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
			<tr>
				<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
				<td><label for="away-team-first-set" class="screen-reader-text"><?php esc_html_e( 'Away Team First Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-set" name="game_away_first_set" /></td>
				<td><label for="away-team-second-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-set" name="game_away_second_set" /></td>
				<td><label for="away-team-third-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-set" name="game_away_third_set" /></td>
				<td><label for="away-team-fourth-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-set" name="game_away_fourth_set" /></td>
				<td><label for="away-team-fifth-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Fifth Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fifth-set" name="game_away_fifth_set" /></td>
				<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
			</tr>
			<tr>
				<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
				<td><label for="home-team-first-set" class="screen-reader-text"><?php esc_html_e( 'Home Team First Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-set" name="game_home_first_set" /></td>
				<td><label for="home-team-second-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-set" name="game_home_second_set" /></td>
				<td><label for="home-team-third-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-set" name="game_home_third_set" /></td>
				<td><label for="home-team-fourth-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Fourth Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-set" name="game_home_fourth_set" /></td>
				<td><label for="home-team-fifth-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Fifth Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fifth-set" name="game_home_fifth_set" /></td>
				<td><label for="home-team-final" class="screen-reader-text"><?php esc_html_e( 'Home Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-final" name="game_home_final" /></td>
			</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Creates the fields for a new game details.
	 *
	 * @since 2.0.0
	 */
	public function new_game_details() {
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Game Information', 'sports-bench' ); ?></h2>
			<div class="field one-column">
				<label for="game-status"><?php esc_html_e( 'Status', 'sports-bench' ); ?></label>
				<select id="game-status" name="game_status">
					<option value=""><?php esc_html_e( 'Select a Status', 'sports-bench' ); ?></option>
					<option value="scheduled"><?php esc_html_e( 'Scheduled', 'sports-bench' ); ?></option>
					<option value="in_progress"><?php esc_html_e( 'In Progress', 'sports-bench' ); ?></option>
					<option value="final"><?php esc_html_e( 'Final', 'sports-bench' ); ?></option>
				</select>
			</div>
			<div id="in-progress-fields">
				<div class="field one-column">
					<label for="game-away-current-score"><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></label>
					<input type="number" id="game-away-current-score" name="game_current_away_score" />
				</div>
				<div class="field one-column">
					<label for="game-home-current-score"><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></label>
					<input type="number" id="game-home-current-score" name="game_current_home_score" />
				</div>
				<div class="field one-column">
					<label for="game-current-period"><?php esc_html_e( 'Current Set in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-period" name="game_current_period" />
				</div>
				<input type="hidden" name="game_current_time" value="<?php echo esc_attr( $game['game_current_time'] ); ?>" />
			</div>
			<div class="field one-column">
				<label for="game-day"><?php esc_html_e( 'Game Date/Time', 'sports-bench' ); ?></label>
				<input type="text" id="game-day" name="game_day" />
			</div>
			<div class="field one-column">
				<label for="game-week"><?php esc_html_e( 'Game Week', 'sports-bench' ); ?></label>
				<input type="text" id="game-week" name="game_week" />
			</div>
			<div class="field one-column">
				<label for="game-season"><?php esc_html_e( 'Game Season', 'sports-bench' ); ?></label>
				<input type="text" id="game-season" name="game_season" />
			</div>
			<div class="field one-column">
				<label for="game-attendance"><?php esc_html_e( 'Game Attendance', 'sports-bench' ); ?></label>
				<input type="text" id="game-attendance" name="game_attendance" />
			</div>
			<div class="field one-column">
				<p><?php esc_html_e( 'Neutral Site', 'sports-bench' ); ?></p>
				<input type="radio" id="neutral-site-yes" name="game_neutral_site" value="1">
				<label for="neutral-site-yes"><?php esc_html_e( 'Yes', 'sports-bench' ); ?></label><br>
				<input type="radio" id="neutral-site-no" name="game_neutral_site" value="0" checked="checked">
				<label for="neutral-site-no"><?php esc_html_e( 'No', 'sports-bench' ); ?></label><br>
			</div>
			<div id="neutral-site-fields">
				<div class="field one-column">
					<label for="game-location-stadium"><?php esc_html_e( 'Stadium', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-stadium" name="game_location_stadium" />
				</div>
				<div class="field one-column">
					<label for="game-location-line-one"><?php esc_html_e( 'Location Line 1', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-line-one" name="game_location_line_one" />
				</div>
				<div class="field one-column">
					<label for="game-line-two"><?php esc_html_e( 'Location Line 2', 'sports-bench' ); ?></label>
					<input type="text" id="game-line-two" name="game_location_line_two" />
				</div>
				<div class="field one-column">
					<label for="game-location-city"><?php esc_html_e( 'Location City', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-city" name="game_location_city" />
				</div>
				<div class="field one-column">
					<label for="game-location-state"><?php esc_html_e( 'Location State', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-state" name="game_location_state" />
				</div>
				<div class="field one-column">
					<label for="game-location-country"><?php esc_html_e( 'Location Country', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-country" name="game_location_country" />
				</div>
				<div class="field one-column">
					<label for="game-location-zip-code"><?php esc_html_e( 'Location ZIP Code', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-zip-code" name="game_location_zip_code" />
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game team stats.
	 *
	 * @since 2.0.0
	 */
	public function new_game_team_stats() {
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Team Stats', 'sports-bench' ); ?></h2>
			<table class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Stat', 'sports-bench' ); ?></th>
						<th class="center"><span id="away-team-stat-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></th>
						<th class="center"><span id="home-team-stat-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></th>
					</tr>
				</thead>

				<tbody>
				<tr>
						<td><?php esc_html_e( 'Kills', 'sports-bench' ); ?></td>
						<td><label for="away-team-kills" class="screen-reader-text"><?php esc_html_e( 'Away Team Kills ', 'sports-bench' ); ?></label><input type="number" id="away-team-kills" name="game_away_kills" /></td>
						<td><label for="home-team-kills" class="screen-reader-text"><?php esc_html_e( 'Home Team Kills ', 'sports-bench' ); ?></label><input type="number" id="home-team-kills" name="game_home_kills" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></td>
						<td><label for="away-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Away Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-team-blocks" name="game_away_blocks" /></td>
						<td><label for="home-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Home Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-team-blocks" name="game_home_blocks" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Aces', 'sports-bench' ); ?></td>
						<td><label for="away-team-aces" class="screen-reader-text"><?php esc_html_e( 'Away Team Aces ', 'sports-bench' ); ?></label><input type="number" id="away-team-aces" name="game_away_aces" /></td>
						<td><label for="home-team-aces" class="screen-reader-text"><?php esc_html_e( 'Home Team Aces ', 'sports-bench' ); ?></label><input type="number" id="home-team-aces" name="game_home_aces" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Assists', 'sports-bench' ); ?></td>
						<td><label for="away-team-assists" class="screen-reader-text"><?php esc_html_e( 'Away Team Assists ', 'sports-bench' ); ?></label><input type="number" id="away-team-assists" name="game_away_assists" /></td>
						<td><label for="home-team-assists" class="screen-reader-text"><?php esc_html_e( 'Home Team Assists ', 'sports-bench' ); ?></label><input type="number" id="home-team-assists" name="game_home_assists" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Digs', 'sports-bench' ); ?></td>
						<td><label for="away-team-digs" class="screen-reader-text"><?php esc_html_e( 'Away Team Digs ', 'sports-bench' ); ?></label><input type="number" id="away-team-digs" name="game_away_digs" /></td>
						<td><label for="home-team-digs" class="screen-reader-text"><?php esc_html_e( 'Home Team Digs ', 'sports-bench' ); ?></label><input type="number" id="home-team-digs" name="game_home_digs" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></td>
						<td><label for="away-team-attacks" class="screen-reader-text"><?php esc_html_e( 'Away Team Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-team-attacks" name="game_away_attacks" /></td>
						<td><label for="home-team-attacks" class="screen-reader-text"><?php esc_html_e( 'Home Team Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-team-attacks" name="game_home_attacks" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></td>
						<td><label for="away-team-errors" class="screen-reader-text"><?php esc_html_e( 'Away Team Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-team-errors" name="game_away_hitting_errors" /></td>
						<td><label for="home-team-errors" class="screen-reader-text"><?php esc_html_e( 'Home Team Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-team-errors" name="game_home_hitting_errors" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game away team individual stats.
	 *
	 * @since 2.0.0
	 */
	public function new_game_away_stats() {
		?>
		<div id="away-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Away Team Player Stats', 'sports-bench' ); ?></h2>
			<table id="away-player-stats" class="form-table volleyball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sets', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kills', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serve Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Aces', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Digs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Receiving Errors', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td class="player-name"><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-sets-played" name="game_player_sets_played[]"/></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
						<td><label for="away-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="away-player-kills" name="game_player_kills[]" /></td>
						<td><label for="away-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-hitting-errors" name="game_player_hitting_errors[]" /></td>
						<td><label for="away-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-attacks" name="game_player_attacks[]" /></td>
						<td><label for="away-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-attempts" name="game_player_set_attempts[]" /></td>
						<td><label for="away-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-errors" name="game_player_set_errors[]" /></td>
						<td><label for="away-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="away-player-serves" name="game_player_serves[]" /></td>
						<td><label for="away-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-serve-errors" name="game_player_serve_errors[]" /></td>
						<td><label for="away-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="away-player-aces" name="game_player_aces[]" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" /></td>
						<td><label for="away-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-attempts" name="game_player_block_attempts[]" /></td>
						<td><label for="away-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-errors" name="game_player_block_errors[]" /></td>
						<td><label for="away-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="away-player-digs" name="game_player_digs[]" /></td>
						<td><label for="away-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-receive-errors" name="game_player_receiving_errors[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td class="player-name"><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-sets-played" name="game_player_sets_played[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="away-player-kills" name="game_player_kills[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-hitting-errors" name="game_player_hitting_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-attacks" name="game_player_attacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-attempts" name="game_player_set_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-errors" name="game_player_set_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="away-player-serves" name="game_player_serves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-serve-errors" name="game_player_serve_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="away-player-aces" name="game_player_aces[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-attempts" name="game_player_block_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-errors" name="game_player_block_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="away-player-digs" name="game_player_digs[]" /></td>
						<td><label for="away-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-receive-errors" name="game_player_receiving_errors[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game home team individual stats.
	 *
	 * @since 2.0.0
	 */
	public function new_game_home_stats() {
		?>
		<div id="home-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Home Team Player Stats', 'sports-bench' ); ?></h2>
			<table id="home-player-stats" class="form-table volleyball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sets', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kills', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serve Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Aces', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Digs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Receiving Errors', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td class="player-name"><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-sets-played" name="game_player_sets_played[]"/></td>
							<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
							<td><label for="home-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="home-player-kills" name="game_player_kills[]" /></td>
							<td><label for="home-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-hitting-errors" name="game_player_hitting_errors[]" /></td>
							<td><label for="home-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-attacks" name="game_player_attacks[]" /></td>
							<td><label for="home-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-attempts" name="game_player_set_attempts[]" /></td>
							<td><label for="home-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-errors" name="game_player_set_errors[]" /></td>
							<td><label for="home-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="home-player-serves" name="game_player_serves[]" /></td>
							<td><label for="home-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-serve-errors" name="game_player_serve_errors[]" /></td>
							<td><label for="home-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="home-player-aces" name="game_player_aces[]" /></td>
							<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" /></td>
							<td><label for="home-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-attempts" name="game_player_block_attempts[]" /></td>
							<td><label for="home-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-errors" name="game_player_block_errors[]" /></td>
							<td><label for="home-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="home-player-digs" name="game_player_digs[]" /></td>
							<td><label for="home-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-receive-errors" name="game_player_receiving_errors[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td class="player-name"><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-sets-played" name="game_player_sets_played[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="home-player-kills" name="game_player_kills[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-hitting-errors" name="game_player_hitting_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-attacks" name="game_player_attacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-attempts" name="game_player_set_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-errors" name="game_player_set_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="home-player-serves" name="game_player_serves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-serve-errors" name="game_player_serve_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="home-player-aces" name="game_player_aces[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-attempts" name="game_player_block_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-errors" name="game_player_block_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="home-player-digs" name="game_player_digs[]" /></td>
						<td><label for="home-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-receive-errors" name="game_player_receiving_errors[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Gets an array of teams.
	 *
	 * @since 2.0.0
	 *
	 * @return array      A list of team objects.
	 */
	public function get_teams() {
		$table   = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$teams   = [];
		$results = Database::get_results( "SELECT team_id FROM $table ORDER BY team_name ASC;" );

		if ( $results ) {
			foreach ( $results as $team ) {
				$teams[] = new Team( (int) $team->team_id );
			}
		}

		return $teams;
	}

	/**
	 * Saves the data for the game that's being added/edited.
	 *
	 * If you are customizing the add/edit game form with your own fields and columns
	 * you can use this filter to save that information.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The array of information from the submitted form.
	 * @return array              The saved information for the game.
	 */
	public function save_game( $request ) {
		$this->save_game_info( $request );

		return $this->get_game_info( $request['game_id'] );
	}

	/**
	 * Saves the game information.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The array of information for the game.
	 */
	public function save_game_info( $game ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		$default_game = [
			'game_id'                       => $game['game_id'],
			'game_week'                     => 0,
			'game_day'                      => '',
			'game_season'                   => '',
			'game_home_id'                  => 0,
			'game_away_id'                  => 0,
			'game_home_final'               => '',
			'game_away_final'               => '',
			'game_attendance'               => 0,
			'game_status'                   => '',
			'game_current_period'           => '',
			'game_current_time'             => '',
			'game_current_home_score'       => '',
			'game_current_away_score'       => '',
			'game_neutral_site'             => 0,
			'game_location_stadium'         => '',
			'game_location_line_one'        => '',
			'game_location_line_two'        => '',
			'game_location_city'            => '',
			'game_location_state'           => '',
			'game_location_country'         => '',
			'game_location_zip_code'        => '',
			'game_home_first_set'           => 0,
			'game_home_second_set'          => 0,
			'game_home_third_set'           => 0,
			'game_home_fourth_set'          => '',
			'game_home_fifth_set'           => '',
			'game_away_first_set'           => 0,
			'game_away_second_set'          => 0,
			'game_away_third_set'           => 0,
			'game_away_fourth_set'          => '',
			'game_away_fifth_set'           => '',
			'game_home_kills'               => 0,
			'game_home_blocks'              => 0,
			'game_home_aces'                => 0,
			'game_home_assists'             => 0,
			'game_home_digs'                => 0,
			'game_home_attacks'             => 0,
			'game_home_hitting_errors'      => 0,
			'game_away_kills'               => 0,
			'game_away_blocks'              => 0,
			'game_away_aces'                => 0,
			'game_away_assists'             => 0,
			'game_away_digs'                => 0,
			'game_away_attacks'             => 0,
			'game_away_hitting_errors'      => 0,
			'game_stats_player_id'          => array(),
			'game_team_id'                  => array(),
			'game_player_id'                => array(),
			'game_player_sets_played'       => array(),
			'game_player_points'            => array(),
			'game_player_kills'             => array(),
			'game_player_hitting_errors'    => array(),
			'game_player_attacks'           => array(),
			'game_player_set_attempts'      => array(),
			'game_player_set_errors'        => array(),
			'game_player_serves'            => array(),
			'game_player_serve_errors'      => array(),
			'game_player_aces'              => array(),
			'game_player_blocks'            => array(),
			'game_player_block_attempts'    => array(),
			'game_player_block_errors'      => array(),
			'game_player_digs'              => array(),
			'game_player_receiving_errors'  => array(),
		];

		if ( isset( $game['nonce'] ) && wp_verify_nonce( $game['nonce'], 'sports-bench-game' ) ) {

			$game = shortcode_atts( $default_game, $game );
			$game = $this->save_player_stats( $game );
			$game = $game[0];
			if ( 0 === $game['game_neutral_site'] && $game['game_home_id'] > 0 ) {
				$home_team = new Team( (int) $game['game_home_id'] );

				$game['game_location_stadium']  = $home_team->get_team_stadium();
				$game['game_location_line_one'] = $home_team->get_team_location_line_one();
				$game['game_location_line_two'] = $home_team->get_team_location_line_two();
				$game['game_location_city']     = $home_team->get_team_city();
				$game['game_location_state']    = $home_team->get_team_state();
				$game['game_location_country']  = $home_team->get_team_location_country();
				$game['game_location_zip_code'] = $home_team->get_team_location_zip_code();
			}

			$game = [
				'game_id'                       => intval( $game['game_id'] ),
				'game_week'                     => intval( $game['game_week'] ),
				'game_day'                      => wp_filter_nohtml_kses( sanitize_text_field( $game['game_day'] ) ),
				'game_season'                   => wp_filter_nohtml_kses( sanitize_text_field( $game['game_season'] ) ),
				'game_home_id'                  => intval( $game['game_home_id'] ),
				'game_away_id'                  => intval( $game['game_away_id'] ),
				'game_home_final'               => intval( $game['game_home_final'] ),
				'game_away_final'               => intval( $game['game_away_final'] ),
				'game_attendance'               => intval( $game['game_attendance'] ),
				'game_status'                   => wp_filter_nohtml_kses( sanitize_text_field( $game['game_status'] ) ),
				'game_current_period'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_period'] ) ),
				'game_current_time'             => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_time'] ) ),
				'game_current_home_score'       => intval( $game['game_current_home_score'] ),
				'game_current_away_score'       => intval( $game['game_current_away_score'] ),
				'game_neutral_site'             => wp_filter_nohtml_kses( sanitize_text_field( $game['game_neutral_site'] ) ),
				'game_location_stadium'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_stadium'] ) ),
				'game_location_line_one'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_one'] ) ),
				'game_location_line_two'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_two'] ) ),
				'game_location_city'            => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_city'] ) ),
				'game_location_state'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_state'] ) ),
				'game_location_country'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_country'] ) ),
				'game_location_zip_code'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_zip_code'] ) ),
				'game_home_first_set'           => intval( $game['game_home_first_set'] ),
				'game_home_second_set'          => intval( $game['game_home_second_set'] ),
				'game_home_third_set'           => intval( $game['game_home_third_set'] ),
				'game_home_fourth_set'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_fourth_set'] ) ),
				'game_home_fifth_set'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_fifth_set'] ) ),
				'game_away_first_set'           => intval( $game['game_away_first_set'] ),
				'game_away_second_set'          => intval( $game['game_away_second_set'] ),
				'game_away_third_set'           => intval( $game['game_away_third_set'] ),
				'game_away_fourth_set'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_fourth_set'] ) ),
				'game_away_fifth_set'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_fifth_set'] ) ),
				'game_home_kills'               => intval( $game['game_home_kills'] ),
				'game_home_blocks'              => intval( $game['game_home_blocks'] ),
				'game_home_aces'                => intval( $game['game_home_aces'] ),
				'game_home_assists'             => intval( $game['game_home_assists'] ),
				'game_home_digs'                => intval( $game['game_home_digs'] ),
				'game_home_attacks'             => intval( $game['game_home_attacks'] ),
				'game_home_hitting_errors'      => intval( $game['game_home_hitting_errors'] ),
				'game_away_kills'               => intval( $game['game_away_kills'] ),
				'game_away_blocks'              => intval( $game['game_away_blocks'] ),
				'game_away_aces'                => intval( $game['game_away_aces'] ),
				'game_away_assists'             => intval( $game['game_away_assists'] ),
				'game_away_digs'                => intval( $game['game_away_digs'] ),
				'game_away_attacks'             => intval( $game['game_away_attacks'] ),
				'game_away_hitting_errors'      => intval( $game['game_away_hitting_errors'] ),
			];

			$the_id    = $game['game_id'];
			$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE game_id = $the_id" );
			if ( [] === $slug_test ) {
				$result = $wpdb->insert( $table_name, $game );
			} else {
				$result = $wpdb->update( $table_name, $game, array( 'game_id' => $game['game_id'] ) );
			}
		}
	}

	/**
	 * Saves the game player stats information.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The array of player stats information for the game.
	 * @return array           The updated information for the game.
	 */
	public function save_player_stats( $game ) {
		global $wpdb;

		//* Pull the player stats out of the $game array
		$game_stats_player_ids = $game['game_stats_player_id'];
		unset( $game['game_stats_player_id'] );

		$team_ids = $game['game_team_id'];
		unset( $game['game_team_id'] );

		$player_ids = $game['game_player_id'];
		unset( $game['game_player_id'] );

		$game_player_sets_played = $game['game_player_sets_played'];
		unset( $game['game_player_sets_played'] );

		$game_player_points = $game['game_player_points'];;
		unset( $game['game_player_points'] );

		$game_player_kills = $game['game_player_kills'];
		unset( $game['game_player_kills'] );

		$game_player_hitting_errors = $game['game_player_hitting_errors'];
		unset( $game['game_player_hitting_errors'] );

		$game_player_attacks = $game['game_player_attacks'];
		unset( $game['game_player_attacks'] );

		$game_player_set_attempts = $game['game_player_set_attempts'];
		unset( $game['game_player_set_attempts'] );

		$game_player_set_errors = $game['game_player_set_errors'];
		unset( $game['game_player_set_errors'] );

		$game_player_serves = $game['game_player_serves'];
		unset( $game['game_player_serves'] );

		$game_player_serve_errors = $game['game_player_serve_errors'];
		unset( $game['game_player_serve_errors'] );

		$game_player_aces = $game['game_player_aces'];
		unset( $game['game_player_aces'] );

		$game_player_blocks = $game['game_player_blocks'];
		unset( $game['game_player_blocks'] );

		$game_player_block_attempts = $game['game_player_block_attempts'];
		unset( $game['game_player_block_attempts'] );

		$game_player_block_errors = $game['game_player_block_errors'];
		unset( $game['game_player_block_errors'] );

		$game_player_digs = $game['game_player_digs'];
		unset( $game['game_player_digs'] );

		$game_player_receiving_errors = $game['game_player_receiving_errors'];
		unset( $game['game_player_receiving_errors'] );

		//* Loop through each of the player stats and add it to the array of stats to be added or updated
		$len = count( $team_ids );
		$stats = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_stats_player_ids[ $i ] ) ) {
				$gs_id = $game_stats_player_ids[ $i ];
			} else {
				$gs_id = '';
			}
			//* Add the player's stats to the array of player stats
			if ( $player_ids[ $i ] != '' ) {
				$stat = array(
					'game_stats_player_id'          => intval( $gs_id ),
					'game_id'                       => intval( $game['game_id'] ),
					'game_team_id'                  => intval( $team_ids[ $i ] ),
					'game_player_id'                => intval( $player_ids[ $i ] ),
					'game_player_sets_played'       => intval( $game_player_sets_played[ $i ] ),
					'game_player_points'            => intval( $game_player_points[ $i ] ),
					'game_player_kills'             => intval( $game_player_kills[ $i ] ),
					'game_player_hitting_errors'    => intval( $game_player_hitting_errors[ $i ] ),
					'game_player_attacks'           => intval( $game_player_attacks[ $i ] ),
					'game_player_set_attempts'      => intval( $game_player_set_attempts[ $i ] ),
					'game_player_set_errors'        => intval( $game_player_set_errors[ $i ] ),
					'game_player_serves'            => intval( $game_player_serves[ $i ] ),
					'game_player_serve_errors'      => intval( $game_player_serve_errors[ $i ] ),
					'game_player_aces'              => intval( $game_player_aces[ $i ] ),
					'game_player_blocks'            => intval( $game_player_blocks[ $i ] ),
					'game_player_block_attempts'    => intval( $game_player_block_attempts[ $i ] ),
					'game_player_block_errors'      => intval( $game_player_block_errors[ $i ] ),
					'game_player_digs'              => intval( $game_player_digs[ $i ] ),
					'game_player_receiving_errors'  => intval( $game_player_receiving_errors[ $i ] ),
				);
				array_push( $stats, $stat );
			}
		}

		//* Grab the player stats for the game already in the database to compare the new ones to
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_id         = $game['game_id'];
		$quer            = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_stats      = $wpdb->get_results( $quer );
		$stats_ids       = [];
		foreach ( $game_stats as $stat ) {
			array_push( $stats_ids, $stat->game_stats_player_id );
		}

		foreach ( $stats as $stat ) {
			if ( in_array( $stat['game_stats_player_id'], $stats_ids ) ) {
				//* If the player's stats for the game are already in the database, update the stats
				$wpdb->update( $wpdb->prefix . 'sb_game_stats', $stat, array( 'game_stats_player_id' => $stat['game_stats_player_id'] ) );
			} else {
				//* If the player's stats for the game aren't already in the database, add the stats
				$wpdb->insert( $game_info_table, $stat );
				$stat['game_stats_player_id'] = $wpdb->insert_id;
			}
		}

		$stat_ids = [];
		foreach ( $stats as $stat ) {
			array_push( $stat_ids, $stat['game_stats_player_id'] );
		}

		//* Check to see if player stats are in the database, but not the player stats array
		foreach ( $stats_ids as $stat_id ) {
			if ( ! in_array( $stat_id, $stat_ids ) ) {
				//* If the database stats aren't in the player stats array, delete them
				$wpdb->query( "DELETE FROM $game_info_table WHERE game_stats_player_id = $stat_id" );
			}
		}

		$len = count( $stats );

		return array( $game, $stats );

	}

	/**
	 * Gets the information for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The id of the game to get.
	 * @return array            The game info, events and player stats.
	 */
	public function get_game_info( $game_id ) {
		global $wpdb;
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$game       = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $game_table WHERE game_id = %d", $game_id ), ARRAY_A );
		$events     = '';
		$stats      = $this->get_game_player_stats( $game_id );

		return [ $game, $events, $stats ];
	}

	/**
	 * Gets the player stats for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The id of the game to get.
	 * @return array            The game stats.
	 */
	public function get_game_player_stats( $game_id ) {
		global $wpdb;
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$quer            = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_stats      = Database::get_results( $quer );
		$stats           = [];
		if ( null !== $game_stats ) {
			foreach ( $game_stats as $stat ) {
				$stat_array = array(
					'game_stats_player_id'          => $stat->game_stats_player_id,
					'game_id'                       => $stat->game_id,
					'game_team_id'                  => $stat->game_team_id,
					'game_player_id'                => $stat->game_player_id,
					'game_player_sets_played'       => $stat->game_player_sets_played,
					'game_player_points'            => $stat->game_player_points,
					'game_player_kills'             => $stat->game_player_kills,
					'game_player_hitting_errors'    => $stat->game_player_hitting_errors,
					'game_player_attacks'           => $stat->game_player_attacks,
					'game_player_set_attempts'      => $stat->game_player_set_attempts,
					'game_player_set_errors'        => $stat->game_player_set_errors,
					'game_player_serves'            => $stat->game_player_serves,
					'game_player_serve_errors'      => $stat->game_player_serve_errors,
					'game_player_aces'              => $stat->game_player_aces,
					'game_player_blocks'            => $stat->game_player_blocks,
					'game_player_block_attempts'    => $stat->game_player_block_attempts,
					'game_player_block_errors'      => $stat->game_player_block_errors,
					'game_player_digs'              => $stat->game_player_digs,
					'game_player_receiving_errors'  => $stat->game_player_receiving_errors,
				);
				array_push( $stats, $stat_array );
			}
		}
		return $stats;
	}
	/**
	 * Fires to show the fields for a game scoreline.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The information for the game.
	 */
	public function edit_game_scoreline( $game ) {
		?>
		<h2><?php esc_html_e( 'Scoring by Half', 'sports-bench' ); ?></h2>
		<table id="score-line" class="form-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '1', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '2', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '3', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '4', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '5', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-set" class="screen-reader-text"><?php esc_html_e( 'Away Team First Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-set" name="game_away_first_set" value="<?php echo esc_attr( $game['game_away_first_set'] ); ?>"/></td>
					<td><label for="away-team-second-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-set" name="game_away_second_set" value="<?php echo esc_attr( $game['game_away_second_set'] ); ?>" /></td>
					<td><label for="away-team-third-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-set" name="game_away_third_set" value="<?php echo esc_attr( $game['game_away_third_set'] ); ?>" /></td>
					<td><label for="away-team-fourth-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-set" name="game_away_fourth_set" value="<?php echo esc_attr( $game['game_away_fourth_set'] ); ?>" /></td>
					<td><label for="away-team-fifth-set" class="screen-reader-text"><?php esc_html_e( 'Away Team Fifth Set Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fifth-set" name="game_away_fifth_set" value="<?php echo esc_attr( $game['game_away_fifth_set'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-set" class="screen-reader-text"><?php esc_html_e( 'Home Team First Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-set" name="game_home_first_set" value="<?php echo esc_attr( $game['game_home_first_set'] ); ?>"/></td>
					<td><label for="home-team-second-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-set" name="game_home_second_set" value="<?php echo esc_attr( $game['game_home_second_set'] ); ?>" /></td>
					<td><label for="home-team-third-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-set" name="game_home_third_set" value="<?php echo esc_attr( $game['game_home_third_set'] ); ?>" /></td>
					<td><label for="home-team-fourth-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Fourth Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-set" name="game_home_fourth_set" value="<?php echo esc_attr( $game['game_home_fourth_set'] ); ?>" /></td>
					<td><label for="home-team-fifth-set" class="screen-reader-text"><?php esc_html_e( 'Home Team Fifth Set Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fifth-set" name="game_home_fifth_set" value="<?php echo esc_attr( $game['game_home_fifth_set'] ); ?>" /></td>
					<td><label for="home-team-final" class="screen-reader-text"><?php esc_html_e( 'Home Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-final" name="game_home_final" value="<?php echo esc_attr( $game['game_home_final'] ); ?>" /></td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Fires to show the fields for a game details.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The information for the game.
	 */
	public function edit_game_details( $game ) {
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Game Information', 'sports-bench' ); ?></h2>
			<div class="field one-column">
				<label for="game-status"><?php esc_html_e( 'Status', 'sports-bench' ); ?></label>
				<select id="game-status" name="game_status">
					<option value="" <?php selected( $game['game_status'], '' ); ?>><?php esc_html_e( 'Select a Status', 'sports-bench' ); ?></option>
					<option value="scheduled" <?php selected( $game['game_status'], 'scheduled' ); ?>><?php esc_html_e( 'Scheduled', 'sports-bench' ); ?></option>
					<option value="in_progress" <?php selected( $game['game_status'], 'in_progress' ); ?>><?php esc_html_e( 'In Progress', 'sports-bench' ); ?></option>
					<option value="final" <?php selected( $game['game_status'], 'final' ); ?>><?php esc_html_e( 'Final', 'sports-bench' ); ?></option>
				</select>
			</div>
			<div id="in-progress-fields">
				<div class="field one-column">
					<label for="game-away-current-score"><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></label>
					<input type="number" id="game-away-current-score" name="game_current_away_score" value="<?php echo esc_attr( $game['game_current_away_score'] ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-home-current-score"><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></label>
					<input type="number" id="game-home-current-score" name="game_current_home_score" value="<?php echo esc_attr( $game['game_current_home_score'] ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-current-period"><?php esc_html_e( 'Current Set in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-period" name="game_current_period" value="<?php echo esc_attr( stripslashes( $game['game_current_period'] ) ); ?>" />
				</div>
				<input type="hidden" name="game_current_time" value="<?php echo esc_attr( $game['game_current_time'] ); ?>" />
			</div>
			<div class="field one-column">
				<label for="game-day"><?php esc_html_e( 'Game Date/Time', 'sports-bench' ); ?></label>
				<input type="text" id="game-day" name="game_day" value="<?php echo esc_attr( $game['game_day'] ); ?>" />
			</div>
			<div class="field one-column">
				<label for="game-week"><?php esc_html_e( 'Game Week', 'sports-bench' ); ?></label>
				<input type="text" id="game-week" name="game_week" value="<?php echo esc_attr( $game['game_week'] ); ?>" />
			</div>
			<div class="field one-column">
				<label for="game-season"><?php esc_html_e( 'Game Season', 'sports-bench' ); ?></label>
				<input type="text" id="game-season" name="game_season" value="<?php echo esc_attr( $game['game_season'] ); ?>" />
			</div>
			<div class="field one-column">
				<label for="game-attendance"><?php esc_html_e( 'Game Attendance', 'sports-bench' ); ?></label>
				<input type="text" id="game-attendance" name="game_attendance" value="<?php echo esc_attr( $game['game_attendance'] ); ?>" />
			</div>
			<div class="field one-column">
				<p><?php esc_html_e( 'Neutral Site', 'sports-bench' ); ?></p>
				<input type="radio" id="neutral-site-yes" name="game_neutral_site" value="1" <?php checked( $game['game_neutral_site'], 1 ); ?>>
				<label for="neutral-site-yes"><?php esc_html_e( 'Yes', 'sports-bench' ); ?></label><br>
				<input type="radio" id="neutral-site-no" name="game_neutral_site" value="0" <?php checked( $game['game_neutral_site'], 0 ); ?>>
				<label for="neutral-site-no"><?php esc_html_e( 'No', 'sports-bench' ); ?></label><br>
			</div>
			<div id="neutral-site-fields">
				<div class="field one-column">
					<label for="game-location-stadium"><?php esc_html_e( 'Stadium', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-stadium" name="game_location_stadium" value="<?php echo esc_attr( stripslashes( $game['game_location_stadium'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-location-line-one"><?php esc_html_e( 'Location Line 1', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-line-one" name="game_location_line_one" value="<?php echo esc_attr( stripslashes( $game['game_location_line_one'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-line-two"><?php esc_html_e( 'Location Line 2', 'sports-bench' ); ?></label>
					<input type="text" id="game-line-two" name="game_location_line_two" value="<?php echo esc_attr( stripslashes( $game['game_location_line_two'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-location-city"><?php esc_html_e( 'Location City', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-city" name="game_location_city" value="<?php echo esc_attr( stripslashes( $game['game_location_city'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-location-state"><?php esc_html_e( 'Location State', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-state" name="game_location_state" value="<?php echo esc_attr( stripslashes( $game['game_location_state'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-location-country"><?php esc_html_e( 'Location Country', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-country" name="game_location_country" value="<?php echo esc_attr( stripslashes( $game['game_location_country'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-location-zip-code"><?php esc_html_e( 'Location ZIP Code', 'sports-bench' ); ?></label>
					<input type="text" id="game-location-zip-code" name="game_location_zip_code" value="<?php echo esc_attr( stripslashes( $game['game_location_zip_code'] ) ); ?>" />
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Fires to show the fields for a game team stats.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The information for the game.
	 */
	public function edit_game_team_stats( $game ) {
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Team Stats', 'sports-bench' ); ?></h2>
			<table class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Stat', 'sports-bench' ); ?></th>
						<th class="center"><span id="away-team-stat-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></th>
						<th class="center"><span id="home-team-stat-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td><?php esc_html_e( 'Kills', 'sports-bench' ); ?></td>
						<td><label for="away-team-kills" class="screen-reader-text"><?php esc_html_e( 'Away Team Kills ', 'sports-bench' ); ?></label><input type="number" id="away-team-kills" name="game_away_kills" value="<?php echo esc_attr( $game['game_away_kills'] ); ?>" /></td>
						<td><label for="home-team-kills" class="screen-reader-text"><?php esc_html_e( 'Home Team Kills ', 'sports-bench' ); ?></label><input type="number" id="home-team-kills" name="game_home_kills" value="<?php echo esc_attr( $game['game_home_kills'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></td>
						<td><label for="away-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Away Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-team-blocks" name="game_away_blocks" value="<?php echo esc_attr( $game['game_away_blocks'] ); ?>" /></td>
						<td><label for="home-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Home Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-team-blocks" name="game_home_blocks" value="<?php echo esc_attr( $game['game_home_blocks'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Aces', 'sports-bench' ); ?></td>
						<td><label for="away-team-aces" class="screen-reader-text"><?php esc_html_e( 'Away Team Aces ', 'sports-bench' ); ?></label><input type="number" id="away-team-aces" name="game_away_aces" value="<?php echo esc_attr( $game['game_away_aces'] ); ?>" /></td>
						<td><label for="home-team-aces" class="screen-reader-text"><?php esc_html_e( 'Home Team Aces ', 'sports-bench' ); ?></label><input type="number" id="home-team-aces" name="game_home_aces" value="<?php echo esc_attr( $game['game_home_aces'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Assists', 'sports-bench' ); ?></td>
						<td><label for="away-team-assists" class="screen-reader-text"><?php esc_html_e( 'Away Team Assists ', 'sports-bench' ); ?></label><input type="number" id="away-team-assists" name="game_away_assists" value="<?php echo esc_attr( $game['game_away_assists'] ); ?>" /></td>
						<td><label for="home-team-assists" class="screen-reader-text"><?php esc_html_e( 'Home Team Assists ', 'sports-bench' ); ?></label><input type="number" id="home-team-assists" name="game_home_assists" value="<?php echo esc_attr( $game['game_home_assists'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Digs', 'sports-bench' ); ?></td>
						<td><label for="away-team-digs" class="screen-reader-text"><?php esc_html_e( 'Away Team Digs ', 'sports-bench' ); ?></label><input type="number" id="away-team-digs" name="game_away_digs" value="<?php echo esc_attr( $game['game_away_digs'] ); ?>" /></td>
						<td><label for="home-team-digs" class="screen-reader-text"><?php esc_html_e( 'Home Team Digs ', 'sports-bench' ); ?></label><input type="number" id="home-team-digs" name="game_home_digs" value="<?php echo esc_attr( $game['game_home_digs'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></td>
						<td><label for="away-team-attacks" class="screen-reader-text"><?php esc_html_e( 'Away Team Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-team-attacks" name="game_away_attacks" value="<?php echo esc_attr( $game['game_away_attacks'] ); ?>" /></td>
						<td><label for="home-team-attacks" class="screen-reader-text"><?php esc_html_e( 'Home Team Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-team-attacks" name="game_home_attacks" value="<?php echo esc_attr( $game['game_home_attacks'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></td>
						<td><label for="away-team-errors" class="screen-reader-text"><?php esc_html_e( 'Away Team Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-team-errors" name="game_away_hitting_errors" value="<?php echo esc_attr( $game['game_away_hitting_errors'] ); ?>" /></td>
						<td><label for="home-team-errors" class="screen-reader-text"><?php esc_html_e( 'Home Team Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-team-errors" name="game_home_hitting_errors" value="<?php echo esc_attr( $game['game_home_hitting_errors'] ); ?>" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Fires to show the fields for a game away team individual stats.
	 *
	 * @since 2.0.0
	 *
	 * @param array $stats      The information for the game individual stats.
	 * @param array $game       The information for the game.
	 */
	public function edit_game_away_stats( $stats, $game ) {
		$players = [];
		$keepers = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_away_id'] ) {
					array_push( $players, $player_stat );
				}
			}
		}

		$player_list = [];
		if ( $game['game_away_id'] ) {
			//* Get the away team players into an array
			$table_name   = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$team_id      = $game['game_away_id'];
			$quer         = "SELECT * FROM $table_name WHERE team_id = $team_id;";
			$the_players  = Database::get_results( $quer );
			$player_array = array(
				'player_id'   => '',
				'player_name' => __( 'Pick a Player', 'sports-bench' ),
			);
			$player_ids   = [];
			array_push( $player_list, $player_array );
			foreach ( $the_players as $the_player ) {
				$player_array = [
					'player_id'   => $the_player->player_id,
					'player_name' => $the_player->player_first_name . ' ' . $the_player->player_last_name,
				];
				$player_ids[] = $the_player->player_id;
				array_push( $player_list, $player_array );
			}
			$away_team    = new Team( (int) $game['game_away_id'] );
			$title        = $away_team->get_team_location() . ' ' . esc_html__( 'Player Stats', 'sports-bench' );
			$border_style = 'style="border: 1px solid ' . $away_team->get_team_primary_color() . '"';
		} else {
			$title        = esc_html__( 'Away Team Player Stats', 'sports-bench' );
			$border_style = '';
		}
		?>
		<div id="away-team-stats" class="game-details" <?php echo wp_kses_post( $border_style ); ?>>
			<h2><?php echo esc_html( $title ); ?></h2>
			<table id="away-player-stats" class="form-table volleyball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sets', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kills', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serve Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Aces', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Digs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Receiving Errors', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $players ) {
						foreach ( $players as $player ) {
							?>
							<tr class="game-away-1-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $player['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $player['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $player['game_player_id'], $player_ids ) ) {
										$the_player = new Player( $player['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $player['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="away-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-sets-played" name="game_player_sets_played[]" value="<?php echo esc_attr( $player['game_player_sets_played'] ); ?>" /></td>
								<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="away-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="away-player-kills" name="game_player_kills[]" value="<?php echo esc_attr( $player['game_player_kills'] ); ?>" /></td>
								<td><label for="away-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-hitting-errors" name="game_player_hitting_errors[]" value="<?php echo esc_attr( $player['game_player_hitting_errors'] ); ?>" /></td>
								<td><label for="away-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-attacks" name="game_player_attacks[]" value="<?php echo esc_attr( $player['game_player_attacks'] ); ?>" /></td>
								<td><label for="away-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-attempts" name="game_player_set_attempts[]" value="<?php echo esc_attr( $player['game_player_set_attempts'] ); ?>" /></td>
								<td><label for="away-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-errors" name="game_player_set_errors[]" value="<?php echo esc_attr( $player['game_player_set_errors'] ); ?>" /></td>
								<td><label for="away-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="away-player-serves" name="game_player_serves[]" value="<?php echo esc_attr( $player['game_player_serves'] ); ?>" /></td>
								<td><label for="away-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-serve-errors" name="game_player_serve_errors[]" value="<?php echo esc_attr( $player['game_player_serve_errors'] ); ?>" /></td>
								<td><label for="away-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="away-player-aces" name="game_player_aces[]" value="<?php echo esc_attr( $player['game_player_aces'] ); ?>" /></td>
								<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" value="<?php echo esc_attr( $player['game_player_blocks'] ); ?>" /></td>
								<td><label for="away-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-attempts" name="game_player_block_attempts[]" value="<?php echo esc_attr( $player['game_player_block_attempts'] ); ?>" /></td>
								<td><label for="away-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-errors" name="game_player_block_errors[]" value="<?php echo esc_attr( $player['game_player_block_errors'] ); ?>" /></td>
								<td><label for="away-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="away-player-digs" name="game_player_digs[]" value="<?php echo esc_attr( $player['game_player_digs'] ); ?>" /></td>
								<td><label for="away-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-receive-errors" name="game_player_receiving_errors[]" value="<?php echo esc_attr( $player['game_player_receiving_errors'] ); ?>" /></td>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<td class="player-name">
								<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
								<select id="away-player" class="away-player" name="game_player_id[]">
								<?php
								if ( [] !== $player_list ) {
									foreach ( $player_list as $single_player ) {
										echo '<option value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
								}
								?>
								</select>
							</td>
							<td><label for="away-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-sets-played" name="game_player_sets_played[]"/></td>
							<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
							<td><label for="away-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="away-player-kills" name="game_player_kills[]" /></td>
							<td><label for="away-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-hitting-errors" name="game_player_hitting_errors[]" /></td>
							<td><label for="away-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-attacks" name="game_player_attacks[]" /></td>
							<td><label for="away-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-attempts" name="game_player_set_attempts[]" /></td>
							<td><label for="away-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-errors" name="game_player_set_errors[]" /></td>
							<td><label for="away-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="away-player-serves" name="game_player_serves[]" /></td>
							<td><label for="away-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-serve-errors" name="game_player_serve_errors[]" /></td>
							<td><label for="away-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="away-player-aces" name="game_player_aces[]" /></td>
							<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" /></td>
							<td><label for="away-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-attempts" name="game_player_block_attempts[]" /></td>
							<td><label for="away-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-errors" name="game_player_block_errors[]" /></td>
							<td><label for="away-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="away-player-digs" name="game_player_digs[]" /></td>
							<td><label for="away-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-receive-errors" name="game_player_receiving_errors[]" /></td>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<td class="player-name">
							<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled">
								<?php
								if ( [] !== $player_list ) {
									foreach ( $player_list as $single_player ) {
										echo '<option value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
								}
								?>
							</select>
						</td>
						<td><label for="away-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-sets-played" name="game_player_sets_played[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="away-player-kills" name="game_player_kills[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-hitting-errors" name="game_player_hitting_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-attacks" name="game_player_attacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-attempts" name="game_player_set_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-set-errors" name="game_player_set_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="away-player-serves" name="game_player_serves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-serve-errors" name="game_player_serve_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="away-player-aces" name="game_player_aces[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-attempts" name="game_player_block_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-block-errors" name="game_player_block_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="away-player-digs" name="game_player_digs[]" /></td>
						<td><label for="away-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="away-player-receive-errors" name="game_player_receiving_errors[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Fires to show the fields for a game home team individual stats.
	 *
	 * @since 2.0.0
	 *
	 * @param array $stats      The information for the game individual stats.
	 * @param array $game       The information for the game.
	 */
	public function edit_game_home_stats( $stats, $game ) {
		$players = [];
		$keepers = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_home_id'] ) {
					array_push( $players, $player_stat );
				}
			}
		}

		$player_list = [];
		if ( $game['game_home_id'] ) {
			//* Get the home team players into an array
			$table_name   = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$team_id      = $game['game_home_id'];
			$quer         = "SELECT * FROM $table_name WHERE team_id = $team_id;";
			$the_players  = Database::get_results( $quer );
			$player_array = array(
				'player_id'   => '',
				'player_name' => __( 'Pick a Player', 'sports-bench' ),
			);
			$player_ids   = [];
			array_push( $player_list, $player_array );
			foreach ( $the_players as $the_player ) {
				$player_array = [
					'player_id'   => $the_player->player_id,
					'player_name' => $the_player->player_first_name . ' ' . $the_player->player_last_name,
				];
				$player_ids[] = $the_player->player_id;
				array_push( $player_list, $player_array );
			}
			$home_team    = new Team( (int) $game['game_home_id'] );
			$title        = $home_team->get_team_location() . ' ' . esc_html__( 'Player Stats', 'sports-bench' );
			$border_style = 'style="border: 1px solid ' . $home_team->get_team_primary_color() . '"';
		} else {
			$title        = esc_html__( 'Away Team Player Stats', 'sports-bench' );
			$border_style = '';
		}
		?>
		<div id="home-team-stats" class="game-details" <?php echo wp_kses_post( $border_style ); ?>>
			<h2><?php echo esc_html( $title ); ?></h2>
			<table id="home-player-stats" class="form-table volleyball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sets', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kills', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hitting Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Set Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Serve Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Aces', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Block Errors', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Digs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Receiving Errors', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $players ) {
						foreach ( $players as $player ) {
							?>
							<tr class="game-home-1-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $player['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $player['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $player['game_player_id'], $player_ids ) ) {
										$the_player = new Player( $player['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $player['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="home-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-sets-played" name="game_player_sets_played[]" value="<?php echo esc_attr( $player['game_player_sets_played'] ); ?>" /></td>
								<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="home-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="home-player-kills" name="game_player_kills[]" value="<?php echo esc_attr( $player['game_player_kills'] ); ?>" /></td>
								<td><label for="home-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-hitting-errors" name="game_player_hitting_errors[]" value="<?php echo esc_attr( $player['game_player_hitting_errors'] ); ?>" /></td>
								<td><label for="home-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-attacks" name="game_player_attacks[]" value="<?php echo esc_attr( $player['game_player_attacks'] ); ?>" /></td>
								<td><label for="home-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-attempts" name="game_player_set_attempts[]" value="<?php echo esc_attr( $player['game_player_set_attempts'] ); ?>" /></td>
								<td><label for="home-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-errors" name="game_player_set_errors[]" value="<?php echo esc_attr( $player['game_player_set_errors'] ); ?>" /></td>
								<td><label for="home-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="home-player-serves" name="game_player_serves[]" value="<?php echo esc_attr( $player['game_player_serves'] ); ?>" /></td>
								<td><label for="home-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-serve-errors" name="game_player_serve_errors[]" value="<?php echo esc_attr( $player['game_player_serve_errors'] ); ?>" /></td>
								<td><label for="home-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="home-player-aces" name="game_player_aces[]" value="<?php echo esc_attr( $player['game_player_aces'] ); ?>" /></td>
								<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" value="<?php echo esc_attr( $player['game_player_blocks'] ); ?>" /></td>
								<td><label for="home-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-attempts" name="game_player_block_attempts[]" value="<?php echo esc_attr( $player['game_player_block_attempts'] ); ?>" /></td>
								<td><label for="home-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-errors" name="game_player_block_errors[]" value="<?php echo esc_attr( $player['game_player_block_errors'] ); ?>" /></td>
								<td><label for="home-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="home-player-digs" name="game_player_digs[]" value="<?php echo esc_attr( $player['game_player_digs'] ); ?>" /></td>
								<td><label for="home-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-receive-errors" name="game_player_receiving_errors[]" value="<?php echo esc_attr( $player['game_player_receiving_errors'] ); ?>" /></td>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<td class="player-name">
								<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
								<select id="home-player" class="home-player" name="game_player_id[]">
								<?php
								if ( [] !== $player_list ) {
									foreach ( $player_list as $single_player ) {
										echo '<option value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
								}
								?>
								</select>
							</td>
							<td><label for="home-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-sets-played" name="game_player_sets_played[]"/></td>
							<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
							<td><label for="home-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="home-player-kills" name="game_player_kills[]" /></td>
							<td><label for="home-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-hitting-errors" name="game_player_hitting_errors[]" /></td>
							<td><label for="home-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-attacks" name="game_player_attacks[]" /></td>
							<td><label for="home-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-attempts" name="game_player_set_attempts[]" /></td>
							<td><label for="home-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-errors" name="game_player_set_errors[]" /></td>
							<td><label for="home-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="home-player-serves" name="game_player_serves[]" /></td>
							<td><label for="home-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-serve-errors" name="game_player_serve_errors[]" /></td>
							<td><label for="home-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="home-player-aces" name="game_player_aces[]" /></td>
							<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" /></td>
							<td><label for="home-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-attempts" name="game_player_block_attempts[]" /></td>
							<td><label for="home-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-errors" name="game_player_block_errors[]" /></td>
							<td><label for="home-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="home-player-digs" name="game_player_digs[]" /></td>
							<td><label for="home-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-receive-errors" name="game_player_receiving_errors[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]"  disabled="disabled" />
						<td class="player-name">
							<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled">
								<?php
								if ( [] !== $player_list ) {
									foreach ( $player_list as $single_player ) {
										echo '<option value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
								}
								?>
							</select>
						</td>
						<td><label for="home-player-sets-played" class="screen-reader-text"><?php esc_html_e( 'Sets Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-sets-played" name="game_player_sets_played[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-kills" class="screen-reader-text"><?php esc_html_e( 'Kills ', 'sports-bench' ); ?></label><input type="number" id="home-player-kills" name="game_player_kills[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hitting-errors" class="screen-reader-text"><?php esc_html_e( 'Hitting Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-hitting-errors" name="game_player_hitting_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-attacks" class="screen-reader-text"><?php esc_html_e( 'Attacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-attacks" name="game_player_attacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-set-attempts" class="screen-reader-text"><?php esc_html_e( 'Set Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-attempts" name="game_player_set_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-set-errors" class="screen-reader-text"><?php esc_html_e( 'Set Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-set-errors" name="game_player_set_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-serves" class="screen-reader-text"><?php esc_html_e( 'Serves ', 'sports-bench' ); ?></label><input type="number" id="home-player-serves" name="game_player_serves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-serve-errors" class="screen-reader-text"><?php esc_html_e( 'Serve Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-serve-errors" name="game_player_serve_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-aces" class="screen-reader-text"><?php esc_html_e( 'Aces ', 'sports-bench' ); ?></label><input type="number" id="home-player-aces" name="game_player_aces[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-block-attempts" class="screen-reader-text"><?php esc_html_e( 'Block Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-attempts" name="game_player_block_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-block-errors" class="screen-reader-text"><?php esc_html_e( 'Block Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-block-errors" name="game_player_block_errors[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-digs" class="screen-reader-text"><?php esc_html_e( 'Digs ', 'sports-bench' ); ?></label><input type="number" id="home-player-digs" name="game_player_digs[]" /></td>
						<td><label for="home-player-receive-errors" class="screen-reader-text"><?php esc_html_e( 'Receiving Errors ', 'sports-bench' ); ?></label><input type="number" id="home-player-receive-errors" name="game_player_receiving_errors[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
