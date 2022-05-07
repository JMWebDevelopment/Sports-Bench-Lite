<?php
/**
 * Creates the baseball game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Baseball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The baseball game admin class.
 *
 * This is used for baseball game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/baseball
 */
class BaseballAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new BaseballAdminGame object to be used.
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
					<th class="center"><?php esc_html_e( 'Runs', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Errors', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Left on Base', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-runs" class="screen-reader-text"><?php esc_html_e( 'Away Team Runs ', 'sports-bench' ); ?></label><input type="number" id="away-team-runs" name="game_away_final" /></td>
					<td><label for="away-team-hits" class="screen-reader-text"><?php esc_html_e( 'Away Team Hits ', 'sports-bench' ); ?></label><input type="number" id="away-team-hits" name="game_away_hits" /></td>
					<td><label for="away-team-errors" class="screen-reader-text"><?php esc_html_e( 'Away Team Errors ', 'sports-bench' ); ?></label><input type="number" id="away-team-errors" name="game_away_errors" /></td>
					<td><label for="away-team-lob" class="screen-reader-text"><?php esc_html_e( 'Away Team Left on Base ', 'sports-bench' ); ?></label><input type="number" id="away-team-lob" name="game_away_lob" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-runs" class="screen-reader-text"><?php esc_html_e( 'Home Team Runs ', 'sports-bench' ); ?></label><input type="number" id="home-team-runs" name="game_home_final" /></td>
					<td><label for="home-team-hits" class="screen-reader-text"><?php esc_html_e( 'Home Team Hits ', 'sports-bench' ); ?></label><input type="number" id="home-team-hits" name="game_home_hits" /></td>
					<td><label for="home-team-errors" class="screen-reader-text"><?php esc_html_e( 'Home Team Errors ', 'sports-bench' ); ?></label><input type="number" id="home-team-errors" name="game_home_errors" /></td>
					<td><label for="home-team-lob" class="screen-reader-text"><?php esc_html_e( 'Home Team Left on Base ', 'sports-bench' ); ?></label><input type="number" id="home-team-lob" name="game_home_lob" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" />
				</div>
				<input type="hidden" name="game_current_period" />
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
						<td><?php esc_html_e( 'Doubles', 'sports-bench' ); ?></td>
						<td><label for="away-team-doubles" class="screen-reader-text"><?php esc_html_e( 'Away Team Doubles ', 'sports-bench' ); ?></label><input type="text" id="away-team-doubles" name="game_away_doubles" /></td>
						<td><label for="home-team-doubles" class="screen-reader-text"><?php esc_html_e( 'Home Team Doubles ', 'sports-bench' ); ?></label><input type="text" id="home-team-doubles" name="game_home_doubles" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Triples', 'sports-bench' ); ?></td>
						<td><label for="away-team-triples" class="screen-reader-text"><?php esc_html_e( 'Away Team Triples ', 'sports-bench' ); ?></label><input type="text" id="away-team-triples" name="game_away_triples" /></td>
						<td><label for="home-team-triples" class="screen-reader-text"><?php esc_html_e( 'Home Team Triples ', 'sports-bench' ); ?></label><input type="text" id="home-team-triples" name="game_home_triples" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Homeruns', 'sports-bench' ); ?></td>
						<td><label for="away-team-homeruns" class="screen-reader-text"><?php esc_html_e( 'Away Team Homeruns ', 'sports-bench' ); ?></label><input type="text" id="away-team-homeruns" name="game_away_homeruns" /></td>
						<td><label for="home-team-homeruns" class="screen-reader-text"><?php esc_html_e( 'Home Team Homeruns ', 'sports-bench' ); ?></label><input type="text" id="home-team-homeruns" name="game_home_homeruns" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game events.
	 *
	 * @since 2.0.0
	 */
	public function new_game_events() {
		$teams = $this->get_teams();
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Plays', 'sports-bench' ); ?></h2>
			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Inning', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Top/Bottom', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Outs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Count', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Type', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Play', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row">
						<input type="hidden" name="game_info_id" />
						<input type="hidden" id="match-event-home-score" name="game_info_id[]" />
						<td><label for="game-event-inning" class="screen-reader-text"><?php esc_html_e( 'Inning ', 'sports-bench' ); ?></label><input type="number" id="game-event-inning" name="game_info_inning[]" /></td>
						<td><label for="game-event-top-bottom" class="screen-reader-text"><?php esc_html_e( 'Top/Bottom of Inning ', 'sports-bench' ); ?></label>
							<select id="game-event-top-bottom" name="game_info_top_bottom[]">
								<option value=""><?php esc_html_e( 'Select Half of Inning', 'sports-bench' ); ?></option>
								<option value="top"><?php esc_html_e( 'Top', 'sports-bench' ); ?></option>
								<option value="bottom"><?php esc_html_e( 'Bottom', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-home-score" name="game_info_home_score[]" /></td>
						<td><label for="game-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-away-score" name="game_info_away_score[]" /></td>
						<td><label for="game-event-outs" class="screen-reader-text"><?php esc_html_e( 'Game Event Outs ', 'sports-bench' ); ?></label><input type="number" id="game-event-outs" name="game_info_outs[]" /></td>
						<td><label for="game-event-count" class="screen-reader-text"><?php esc_html_e( 'Game Event Count ', 'sports-bench' ); ?></label><input type="text" id="game-event-away-count" name="game_info_count[]" /></td>
						<td><label for="game-event-type" class="screen-reader-text"><?php esc_html_e( 'Game Event Type ', 'sports-bench' ); ?></label>
							<select id="game-event-type" name="game_info_type[]">
								<option value=""><?php esc_html_e( 'Select Type', 'sports-bench' ); ?></option>
								<option value="runs-scored"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></option>
								<option value="runs-position-change"><?php esc_html_e( 'Position Changed', 'sports-bench' ); ?></option>
								<option value="outs-walk"><?php esc_html_e( 'Outs/Walk/Other', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-runs-scored" class="screen-reader-text"><?php esc_html_e( 'Game Event Runs Scores ', 'sports-bench' ); ?></label><input type="number" id="game-event-runs-scored" name="game_info_runs_scored[]" /></td>
						<td><label for="game-event-play" class="screen-reader-text"><?php esc_html_e( 'Play ', 'sports-bench' ); ?></label><input type="text" id="game-event-played" name="game_info_play[]" /></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-event-empty-row screen-reader-text">
						<input type="hidden" id="match-event-home-score" name="game_info_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_info_id" class="new-field team" disabled="disabled" />
						<td><label for="game-event-inning" class="screen-reader-text"><?php esc_html_e( 'Inning ', 'sports-bench' ); ?></label><input type="number" id="game-event-inning" name="game_info_inning[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-top-bottom" class="screen-reader-text"><?php esc_html_e( 'Top/Bottom of Inning ', 'sports-bench' ); ?></label>
							<select id="game-event-top-bottom" name="game_info_top_bottom[]" class="new-field team" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Half of Inning', 'sports-bench' ); ?></option>
								<option value="top"><?php esc_html_e( 'Top', 'sports-bench' ); ?></option>
								<option value="bottom"><?php esc_html_e( 'Bottom', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-home-score" name="game_info_home_score[]"  class="new-field team" disabled="disabled"/></td>
						<td><label for="game-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-away-score" name="game_info_away_score[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-outs" class="screen-reader-text"><?php esc_html_e( 'Game Event Outs ', 'sports-bench' ); ?></label><input type="number" id="game-event-outs" name="game_info_outs[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-count" class="screen-reader-text"><?php esc_html_e( 'Game Event Count ', 'sports-bench' ); ?></label><input type="text" id="game-event-away-count" name="game_info_count[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-type" class="screen-reader-text"><?php esc_html_e( 'Game Event Type ', 'sports-bench' ); ?></label>
							<select id="game-event-type" name="game_info_type[]" class="new-field team" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Type', 'sports-bench' ); ?></option>
								<option value="runs-scored"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></option>
								<option value="runs-position-change"><?php esc_html_e( 'Position Changed', 'sports-bench' ); ?></option>
								<option value="outs-walk"><?php esc_html_e( 'Outs/Walk/Other', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-runs-scored" class="screen-reader-text"><?php esc_html_e( 'Game Event Runs Scores ', 'sports-bench' ); ?></label><input type="number" id="game-event-runs-scored" name="game_info_runs_scored[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-play" class="screen-reader-text"><?php esc_html_e( 'Play ', 'sports-bench' ); ?></label><input type="text" id="game-event-play" name="game_info_play[]" class="new-field team" disabled="disabled" /></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-event"><?php esc_html_e( 'Add Event', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game away team individual stats.
	 *
	 * @since 2.0.0
	 */
	public function new_game_away_stats() {
		$decisions = [
			'ND'    => esc_html__( 'No Decision', 'sports-bench' ),
			'W'     => esc_html__( 'Win', 'sports-bench' ),
			'L'     => esc_html__( 'Loss', 'sports-bench' ),
			'H'     => esc_html__( 'Hold', 'sports-bench' ),
			'S'     => esc_html__( 'Save', 'sports-bench' ),
			'BS'    => esc_html__( 'Blown Save', 'sports-bench' ),
		];
		?>
		<div id="away-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Away Team Player Stats', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Batting', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table baseball-player-stats">
			<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Position', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ABs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'RBI', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '2B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FC', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input type="hidden" name="game_stats_player_id[]" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<td class="player-name">
							<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="away-player" class="away-player" name="game_player_id[]">
							</select>
						</td>
						<td><label for="away-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="away-player-position" name="game_player_position[]" /></td>
						<td><label for="away-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="away-player-at-bats" name="game_player_at_bats[]" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" /></td>
						<td><label for="away-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs" name="game_player_runs[]" /></td>
						<td><label for="away-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="away-player-rbis" name="game_player_rbis[]" /></td>
						<td><label for="away-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="away-player-doubles" name="game_player_doubles[]" /></td>
						<td><label for="away-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="away-player-triples" name="game_player_triples[]"  /></td>
						<td><label for="away-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs" name="game_player_homeruns[]" /></td>
						<td><label for="away-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-strikeouts" name="game_player_strikeouts[]" /></td>
						<td><label for="away-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-walks" name="game_player_walks[]" /></td>
						<td><label for="away-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="away-player-hbp" name="game_player_hit_by_pitch[]"/></td>
						<td><label for="away-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="away-player-fielders-choice" name="game_player_fielders_choice[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" />
						<input type="hidden" name="game_player_hit_batters[]" />
						<input type="hidden" name="game_player_pitcher_walks[]" />
						<input type="hidden" name="game_player_runs_allowed[]" />
						<input type="hidden" name="game_player_earned_runs[]" />
						<input type="hidden" name="game_player_hits_allowed[]" />
						<input type="hidden" name="game_player_homeruns_allowed[]" />
						<input type="hidden" name="game_player_pitch_count[]" />
						<input type="hidden" name="game_player_decision[]" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="1" size="6">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<td class="player-name">
							<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled">
							</select>
						</td>
						<td><label for="away-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="away-player-position" name="game_player_position[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="away-player-at-bats" name="game_player_at_bats[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs" name="game_player_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="away-player-rbis" name="game_player_rbis[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="away-player-doubles" name="game_player_doubles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="away-player-triples" name="game_player_triples[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="away-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs" name="game_player_homeruns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-strikeouts" name="game_player_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-walks" name="game_player_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="away-player-hbp" name="game_player_hit_by_pitch[]"  class="new-field" disabled="disabled"/></td>
						<td><label for="away-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="away-player-fielders-choice" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled"/>
						<input type="hidden" name="game_player_hit_batters[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_earned_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitch_count[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_decision[]" class="new-field" disabled="disabled" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field" class="new-field" disabled="disabled"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Pitching', 'sports-bench' ); ?></h3>
			<table id="away-pitcher-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
					<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Decision', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'IP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ER', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'K', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'NP', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-2-row">
						<input type="hidden" name="game_stats_player_id[]" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<td class="player-name">
							<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="away-player" class="away-player" name="game_player_id[]">
							</select>
						</td>
						<td>
							<label for="away-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="away-player-decision" name="game_player_decision[]">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="away-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="away-player-innings-pitched" name="game_player_innings_pitched[]" step="any" lang="en-150" /></td>
						<td><label for="away-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs-allowed" name="game_player_runs_allowed[]" /></td>
						<td><label for="away-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-earned-runs" name="game_player_earned_runs[]" /></td>
						<td><label for="away-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits-allowed" name="game_player_hits_allowed[]" /></td>
						<td><label for="away-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" /></td>
						<td><label for="away-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-walks" name="game_player_pitcher_walks[]" /></td>
						<td><label for="away-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="away-player-hit-batters" name="game_player_hit_batters[]" /></td>
						<td><label for="away-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs-allowed" name="game_player_homeruns_allowed[]" /></td>
						<td><label for="away-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitch-count" name="game_player_pitch_count[]" /></td>
						<input type="hidden" name="game_player_position[]" value="P" />
						<input type="hidden" name="game_player_at_bats[]" />
						<input type="hidden" name="game_player_hits[]" />
						<input type="hidden" name="game_player_runs[]" />
						<input type="hidden" name="game_player_rbis[]" />
						<input type="hidden" name="game_player_doubles[]" />
						<input type="hidden" name="game_player_triples[]" />
						<input type="hidden" name="game_player_homeruns[]" />
						<input type="hidden" name="game_player_strikeouts[]" />
						<input type="hidden" name="game_player_walks[]" />
						<input type="hidden" name="game_player_hit_by_pitch[]" />
						<input type="hidden" name="game_player_fielders_choice[]" />
						<input type="hidden" name="game_player_batting_order[]" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" value="1" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-2-empty-row screen-reader-text">
					<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<td class="player-name">
							<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled">
							</select>
						</td>
						<td>
							<label for="away-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="away-player-decision" name="game_player_decision[]" class="new-field" disabled="disabled">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="away-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="away-player-innings-pitched" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" step="any" lang="en-150" /></td>
						<td><label for="away-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs-allowed" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-earned-runs" name="game_player_earned_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits-allowed" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-walks" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="away-player-hit-batters" name="game_player_hit_batters[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Homeruns Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs-allowed" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitch-count" name="game_player_pitch_count[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_position[]" value="P" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_at_bats[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rbis[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_doubles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_triples[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_strikeouts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hit_by_pitch[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_batting_order[]" class="new-field" disabled="disabled" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" class="new-field" disabled="disabled" value="0" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

	/**
	 * Creates the fields for a new game home team individual stats.
	 *
	 * @since 2.0.0
	 */
	public function new_game_home_stats() {

		$decisions = [
			'ND'    => esc_html__( 'No Decision', 'sports-bench' ),
			'W'     => esc_html__( 'Win', 'sports-bench' ),
			'L'     => esc_html__( 'Loss', 'sports-bench' ),
			'H'     => esc_html__( 'Hold', 'sports-bench' ),
			'S'     => esc_html__( 'Save', 'sports-bench' ),
			'BS'    => esc_html__( 'Blown Save', 'sports-bench' ),
		];
		?>
		<div id="home-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Home Team Player Stats', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Batting', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Position', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ABs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'RBI', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '2B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FC', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input type="hidden" name="game_stats_player_id[]" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<td class="player-name">
							<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="home-player" class="home-player" name="game_player_id[]">
							</select>
						</td>
						<td><label for="home-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="home-player-position" name="game_player_position[]" /></td>
						<td><label for="home-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="home-player-at-bats" name="game_player_at_bats[]" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" /></td>
						<td><label for="home-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs" name="game_player_runs[]" /></td>
						<td><label for="home-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="home-player-rbis" name="game_player_rbis[]" /></td>
						<td><label for="home-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="home-player-doubles" name="game_player_doubles[]" /></td>
						<td><label for="home-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="home-player-triples" name="game_player_triples[]"  /></td>
						<td><label for="home-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs" name="game_player_homeruns[]" /></td>
						<td><label for="home-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-strikeouts" name="game_player_strikeouts[]" /></td>
						<td><label for="home-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-walks" name="game_player_walks[]" /></td>
						<td><label for="home-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="home-player-hbp" name="game_player_hit_by_pitch[]"/></td>
						<td><label for="home-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="home-player-fielders-choice" name="game_player_fielders_choice[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" />
						<input type="hidden" name="game_player_hit_batters[]" />
						<input type="hidden" name="game_player_pitcher_walks[]" />
						<input type="hidden" name="game_player_runs_allowed[]" />
						<input type="hidden" name="game_player_earned_runs[]" />
						<input type="hidden" name="game_player_hits_allowed[]" />
						<input type="hidden" name="game_player_homeruns_allowed[]" />
						<input type="hidden" name="game_player_pitch_count[]" />
						<input type="hidden" name="game_player_decision[]" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="1" size="6">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<td class="player-name">
							<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled">
							</select>
						</td>
						<td><label for="home-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="home-player-position" name="game_player_position[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="home-player-at-bats" name="game_player_at_bats[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs" name="game_player_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="home-player-rbis" name="game_player_rbis[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="home-player-doubles" name="game_player_doubles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="home-player-triples" name="game_player_triples[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="home-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs" name="game_player_homeruns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-strikeouts" name="game_player_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-walks" name="game_player_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="home-player-hbp" name="game_player_hit_by_pitch[]"  class="new-field" disabled="disabled"/></td>
						<td><label for="home-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="home-player-fielders-choice" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled"/>
						<input type="hidden" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hit_batters[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_earned_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitch_count[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_decision[]" class="new-field" disabled="disabled" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field" class="new-field" disabled="disabled"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Pitching', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table baseball-player-stats">
			<thead>
					<tr>
					<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Decision', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'IP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ER', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'K', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'NP', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-2-row">
						<input type="hidden" name="game_stats_player_id[]" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<td class="player-name">
							<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="home-player" class="home-player" name="game_player_id[]">
							</select>
						</td>
						<td>
							<label for="home-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="home-player-decision" name="game_player_decision[]">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="home-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="home-player-innings-pitched" name="game_player_innings_pitched[]" step="any" lang="en-150" /></td>
						<td><label for="home-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs-allowed" name="game_player_runs_allowed[]" /></td>
						<td><label for="home-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-earned-runs" name="game_player_earned_runs[]" /></td>
						<td><label for="home-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits-allowed" name="game_player_hits_allowed[]" /></td>
						<td><label for="home-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" /></td>
						<td><label for="home-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-walks" name="game_player_pitcher_walks[]" /></td>
						<td><label for="home-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="home-player-hit-batters" name="game_player_hit_batters[]" /></td>
						<td><label for="home-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs-allowed" name="game_player_homeruns_allowed[]" /></td>
						<td><label for="home-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitch-count" name="game_player_pitch_count[]" /></td>
						<input type="hidden" name="game_player_position[]" value="P" />
						<input type="hidden" name="game_player_at_bats[]" />
						<input type="hidden" name="game_player_hits[]" />
						<input type="hidden" name="game_player_runs[]" />
						<input type="hidden" name="game_player_rbis[]" />
						<input type="hidden" name="game_player_doubles[]" />
						<input type="hidden" name="game_player_triples[]" />
						<input type="hidden" name="game_player_homeruns[]" />
						<input type="hidden" name="game_player_strikeouts[]" />
						<input type="hidden" name="game_player_walks[]" />
						<input type="hidden" name="game_player_hit_by_pitch[]" />
						<input type="hidden" name="game_player_fielders_choice[]" />
						<input type="hidden" name="game_player_batting_order[]" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" value="1" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-2-empty-row screen-reader-text">
					<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<td class="player-name">
							<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
							<select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled">
							</select>
						</td>
						<td>
							<label for="home-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="home-player-decision" name="game_player_decision[]" class="new-field" disabled="disabled">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="home-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="home-player-innings-pitched" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" step="any" lang="en-150" /></td>
						<td><label for="home-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs-allowed" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-earned-runs" name="game_player_earned_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits-allowed" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-walks" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="home-player-hit-batters" name="game_player_hit_batters[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Homeruns Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs-allowed" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitch-count" name="game_player_pitch_count[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_position[]" value="P" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_at_bats[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rbis[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_doubles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_triples[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_strikeouts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hit_by_pitch[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_batting_order[]" class="new-field" disabled="disabled" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" class="new-field" disabled="disabled" value="0" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
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
			'game_id'                           => $game['game_id'],
			'game_week'                         => 0,
			'game_day'                          => '',
			'game_season'                       => '',
			'game_home_id'                      => 0,
			'game_away_id'                      => 0,
			'game_home_final'                   => '',
			'game_away_final'                   => '',
			'game_attendance'                   => 0,
			'game_status'                       => '',
			'game_current_period'               => '',
			'game_current_time'                 => '',
			'game_current_home_score'           => '',
			'game_current_away_score'           => '',
			'game_neutral_site'                 => 0,
			'game_location_stadium'             => '',
			'game_location_line_one'            => '',
			'game_location_line_two'            => '',
			'game_location_city'                => '',
			'game_location_state'               => '',
			'game_location_country'             => '',
			'game_location_zip_code'            => '',
			'game_home_hits'                    => 0,
			'game_home_errors'                  => 0,
			'game_home_lob'                     => 0,
			'game_away_hits'                    => 0,
			'game_away_errors'                  => 0,
			'game_away_lob'                     => 0,
			'game_home_doubles'                 => '',
			'game_home_triples'                 => '',
			'game_home_homeruns'                => '',
			'game_away_doubles'                 => '',
			'game_away_triples'                 => '',
			'game_away_homeruns'                => '',
			'game_info_id'                      => array(),
			'game_info_inning'                  => array(),
			'game_info_top_bottom'              => array(),
			'game_info_home_score'              => array(),
			'game_info_away_score'              => array(),
			'game_info_runs_scored'             => array(),
			'game_info_play'                    => array(),
			'game_info_outs'                    => array(),
			'game_info_count'                   => array(),
			'game_info_type'                    => array(),
			'game_stats_player_id'              => array(),
			'game_stats_pitch_field'            => array(),
			'game_team_id'                      => array(),
			'game_player_id'                    => array(),
			'game_player_at_bats'               => array(),
			'game_player_hits'                  => array(),
			'game_player_runs'                  => array(),
			'game_player_rbis'                  => array(),
			'game_player_doubles'               => array(),
			'game_player_triples'               => array(),
			'game_player_homeruns'              => array(),
			'game_player_strikeouts'            => array(),
			'game_player_walks'                 => array(),
			'game_player_hit_by_pitch'          => array(),
			'game_player_fielders_choice'       => array(),
			'game_player_position'              => array(),
			'game_player_innings_pitched'       => array(),
			'game_player_pitcher_strikeouts'    => array(),
			'game_player_pitcher_walks'         => array(),
			'game_player_hit_batters'           => array(),
			'game_player_runs_allowed'          => array(),
			'game_player_earned_runs'           => array(),
			'game_player_hits_allowed'          => array(),
			'game_player_homeruns_allowed'      => array(),
			'game_player_pitch_count'           => array(),
			'game_player_decision'              => array(),
			'game_player_batting_order'         => array(),
			'game_player_pitching_order'        => array(),
		];

		if ( isset( $game['nonce'] ) && wp_verify_nonce( $game['nonce'], 'sports-bench-game' ) ) {

			$game = shortcode_atts( $default_game, $game );
			$game = $this->save_game_events( $game );
			$game = $this->save_player_stats( $game[0] );
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
				'game_id'                           => intval( $game['game_id'] ),
				'game_week'                         => intval( $game['game_week'] ),
				'game_day'                          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_day'] ) ),
				'game_season'                       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_season'] ) ),
				'game_home_id'                      => intval( $game['game_home_id'] ),
				'game_away_id'                      => intval( $game['game_away_id'] ),
				'game_home_final'                   => intval( $game['game_home_final'] ),
				'game_away_final'                   => intval( $game['game_away_final'] ),
				'game_attendance'                   => intval( $game['game_attendance'] ),
				'game_status'                       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_status'] ) ),
				'game_current_period'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_period'] ) ),
				'game_current_time'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_time'] ) ),
				'game_current_home_score'           => intval( $game['game_current_home_score'] ),
				'game_current_away_score'           => intval( $game['game_current_away_score'] ),
				'game_neutral_site'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_neutral_site'] ) ),
				'game_location_stadium'             => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_stadium'] ) ),
				'game_location_line_one'            => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_one'] ) ),
				'game_location_line_two'            => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_two'] ) ),
				'game_location_city'                => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_city'] ) ),
				'game_location_state'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_state'] ) ),
				'game_location_country'             => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_country'] ) ),
				'game_location_zip_code'            => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_zip_code'] ) ),
				'game_home_hits'                    => intval( $game['game_home_hits'] ),
				'game_home_errors'                  => intval( $game['game_home_errors'] ),
				'game_home_lob'                     => intval( $game['game_home_lob'] ),
				'game_away_hits'                    => intval( $game['game_away_hits'] ),
				'game_away_errors'                  => intval( $game['game_away_errors'] ),
				'game_away_lob'                     => intval( $game['game_away_lob'] ),
				'game_home_doubles'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_doubles'] ) ),
				'game_home_triples'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_triples'] ) ),
				'game_home_homeruns'                => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_homeruns'] ) ),
				'game_away_doubles'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_doubles'] ) ),
				'game_away_triples'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_triples'] ) ),
				'game_away_homeruns'                => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_homeruns'] ) ),
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
	 * Saves the game event information.
	 *
	 * @since 2.0.0
	 *
	 * @param array $game      The array of events information for the game.
	 * @return array           The updated information for the game.
	 */
	public function save_game_events( $game ) {
		global $wpdb;

		$game_info_ids = $game['game_info_id'];
		unset( $game['game_info_id'] );

		$game_info_innings = $game['game_info_inning'];
		unset( $game['game_info_inning'] );

		$game_info_top_bottoms = $game['game_info_top_bottom'];
		unset( $game['game_info_top_bottom'] );

		$game_info_home_scores = $game['game_info_home_score'];;
		unset( $game['game_info_home_score'] );

		$game_info_away_scores = $game['game_info_away_score'];
		unset( $game['game_info_away_score'] );

		$game_info_runs_scoreds = $game['game_info_runs_scored'];
		unset( $game['game_info_runs_scored'] );

		$game_info_plays = $game['game_info_play'];
		unset( $game['game_info_play'] );

		$game_info_outs = $game['game_info_outs'];
		unset( $game['game_info_outs'] );

		$game_info_count = $game['game_info_count'];
		unset( $game['game_info_count'] );

		$game_info_type = $game['game_info_type'];
		unset( $game['game_info_type'] );

		$len = count( $game_info_innings );

		$events = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_info_ids[ $i ] ) ) {
				$gi_id = $game_info_ids[ $i ];
			} else {
				$gi_id = '';
			}
			if ( isset( $game_info_innings[ $i ] ) ) {
				$event = array(
					'game_info_id'          => intval( $gi_id ),
					'game_id'               => intval( $game['game_id'] ),
					'game_info_inning'      => intval( $game_info_innings[ $i ] ),
					'game_info_top_bottom'  => wp_filter_nohtml_kses( sanitize_text_field( $game_info_top_bottoms[ $i ] ) ),
					'game_info_home_score'  => intval( $game_info_home_scores[ $i ] ),
					'game_info_away_score'  => intval( $game_info_away_scores[ $i ] ),
					'game_info_runs_scored' => intval( $game_info_runs_scoreds[ $i ] ),
					'game_info_play'        => wp_filter_nohtml_kses( sanitize_text_field( $game_info_plays[ $i ] ) ),
					'game_info_outs'        => wp_filter_nohtml_kses( sanitize_text_field( $game_info_outs[ $i ] ) ),
					'game_info_count'       => wp_filter_nohtml_kses( sanitize_text_field( $game_info_count[ $i ] ) ),
					'game_info_type'        => wp_filter_nohtml_kses( sanitize_text_field( $game_info_type[ $i ] ) )
				);
				array_push( $events, $event );
			}
		}

		//* Get the game events already in the database to compare the new ones to
		$game_info_table = SB_TABLE_PREFIX . 'game_info';
		$game_id         = $game['game_id'];
		$quer            = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_events     = $wpdb->get_results( $quer );
		$info_ids        = [];
		foreach ( $game_events as $event ) {
			array_push( $info_ids, $event->game_info_id );
		}

		foreach ( $events as $event ) {
			if ( '' !== $event['game_info_inning'] ) {
				if ( in_array( $event['game_info_id'], $info_ids ) ) {
					//* If the event id is already in the database, update it
					$wpdb->update( $wpdb->prefix . 'sb_game_info', $event, array( 'game_info_id' => $event['game_info_id'] ) );
				} else {
					//* If the event is new, add it to the database
					$wpdb->insert( $game_info_table, $event );
					$event['game_info_id'] = $wpdb->insert_id;
				}
			}
		}

		$event_ids = [];
		foreach ( $events as $event ) {
			array_push( $event_ids, $event['game_info_id'] );
		}

		//* If an event is in the database but not the $games array, delete it from the database
		foreach ( $info_ids as $info_id ) {
			if ( ! in_array( $info_id, $event_ids ) ) {
				$wpdb->query( "DELETE FROM $game_info_table WHERE game_info_id = $info_id" );
			}
		}

		return array( $game, $events );

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

		// Pull the player stats out of the $game array.
		$game_stats_player_ids = $game['game_stats_player_id'];
		unset( $game['game_stats_player_id'] );

		$game_stats_pitch_field = $game['game_stats_pitch_field'];
		unset( $game['game_stats_pitch_field'] );

		$team_ids = $game['game_team_id'];
		unset( $game['game_team_id'] );

		$player_ids = $game['game_player_id'];
		unset( $game['game_player_id'] );

		$game_player_position = $game['game_player_position'];
		unset( $game['game_player_position'] );

		$game_player_at_bats = $game['game_player_at_bats'];;
		unset( $game['game_player_at_bats'] );

		$game_player_hits = $game['game_player_hits'];
		unset( $game['game_player_hits'] );

		$game_player_runs = $game['game_player_runs'];
		unset( $game['game_player_runs'] );

		$game_player_rbis = $game['game_player_rbis'];
		unset( $game['game_player_rbis'] );

		$game_player_doubles = $game['game_player_doubles'];
		unset( $game['game_player_doubles'] );

		$game_player_triples = $game['game_player_triples'];
		unset( $game['game_player_triples'] );

		$game_player_homeruns = $game['game_player_homeruns'];
		unset( $game['game_player_homeruns'] );

		$game_player_strikeouts = $game['game_player_strikeouts'];
		unset( $game['game_player_strikeouts'] );

		$game_player_walks = $game['game_player_walks'];
		unset( $game['game_player_walks'] );

		$game_player_hit_by_pitch = $game['game_player_hit_by_pitch'];
		unset( $game['game_player_hit_by_pitch'] );

		$game_player_fielders_choice = $game['game_player_fielders_choice'];
		unset( $game['game_player_fielders_choice'] );

		$game_player_innings_pitched = $game['game_player_innings_pitched'];
		unset( $game['game_player_innings_pitched'] );

		$game_player_pitcher_strikeouts = $game['game_player_pitcher_strikeouts'];
		unset( $game['game_player_pitcher_strikeouts'] );

		$game_player_pitcher_walks = $game['game_player_pitcher_walks'];
		unset( $game['game_player_pitcher_walks'] );

		$game_player_runs_allowed = $game['game_player_runs_allowed'];
		unset( $game['game_player_runs_allowed'] );

		$game_player_earned_runs = $game['game_player_earned_runs'];
		unset( $game['game_player_earned_runs'] );

		$game_player_hits_allowed = $game['game_player_hits_allowed'];
		unset( $game['game_player_hits_allowed'] );

		$game_player_homeruns_allowed = $game['game_player_homeruns_allowed'];
		unset( $game['game_player_homeruns_allowed'] );

		$game_player_pitch_count = $game['game_player_pitch_count'];
		unset( $game['game_player_pitch_count'] );

		$game_player_hit_batters = $game['game_player_hit_batters'];
		unset( $game['game_player_hit_batters'] );

		$game_player_decision = $game['game_player_decision'];
		unset( $game['game_player_decision'] );

		$game_player_batting_order = $game['game_player_batting_order'];
		unset( $game['game_player_batting_order'] );

		$game_player_pitching_order = $game['game_player_pitching_order'];
		unset( $game['game_player_pitching_order'] );


		//* Loop through each of the player stats and add it to the array of stats to be added or updated
		if ( is_array( $team_ids ) ) {
			$len = count( $team_ids );
		} else {
			$len = 0;
		}
		$stats = [];
		$ids   = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_stats_player_ids[ $i ] ) ) {
				$gs_id = $game_stats_player_ids[ $i ];
			} else {
				$gs_id = '';
			}
			//* Check to see if the player already has stats in the array
			if ( isset( $game_stats_player_ids[ $i ] ) && in_array( $game_stats_player_ids[ $i ], $ids ) ) {
				$j = array_search( $game_stats_player_ids[ $i ], $ids );
				if ( 'field' === $game_stats_pitch_field[ $i ] ) {
					//* If the player has stats in the array and we're adding the batting stats, add the batting stats, but keep the pitching stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $team_ids[ $i ] ),
						'game_player_id'                 => intval( $player_ids[ $i ] ),
						'game_player_position'           => wp_filter_nohtml_kses( sanitize_text_field( $game_player_position[ $i ] ) ),
						'game_player_at_bats'            => intval( $game_player_at_bats[ $i ] ),
						'game_player_hits'               => intval( $game_player_hits[ $i ] ),
						'game_player_runs'               => intval( $game_player_runs[ $i ] ),
						'game_player_rbis'               => intval( $game_player_rbis[ $i ] ),
						'game_player_doubles'            => intval( $game_player_doubles[ $i ] ),
						'game_player_triples'            => intval( $game_player_triples[ $i ] ),
						'game_player_homeruns'           => intval( $game_player_homeruns[ $i ] ),
						'game_player_strikeouts'         => intval( $game_player_strikeouts[ $i ] ),
						'game_player_walks'              => intval( $game_player_walks[ $i ] ),
						'game_player_hit_by_pitch'       => intval( $game_player_hit_by_pitch[ $i ] ),
						'game_player_fielders_choice'    => intval( $game_player_fielders_choice[ $i ] ),
						'game_player_innings_pitched'    => floatval( $stats[ $j ]['game_player_innings_pitched'] ),
						'game_player_pitcher_strikeouts' => intval( $stats[ $j ]['game_player_pitcher_strikeouts'] ),
						'game_player_pitcher_walks'      => intval( $stats[ $j ]['game_player_pitcher_walks'] ),
						'game_player_runs_allowed'       => intval( $stats[ $j ]['game_player_runs_allowed'] ),
						'game_player_earned_runs'        => intval( $stats[ $j ]['game_player_earned_runs'] ),
						'game_player_hits_allowed'       => intval( $stats[ $j ]['game_player_hits_allowed'] ),
						'game_player_homeruns_allowed'   => intval( $stats[ $j ]['game_player_homeruns_allowed'] ),
						'game_player_pitch_count'        => intval( $stats[ $j ]['game_player_pitch_count'] ),
						'game_player_hit_batters'        => intval( $stats[ $j ]['game_player_hit_batters'] ),
						'game_player_decision'           => wp_filter_nohtml_kses( sanitize_text_field( $stats[ $j ]['game_player_decision'] ) ),
						'game_player_batting_order'      => intval( $game_player_batting_order[ $i ] ),
						'game_player_pitching_order'     => intval( $stats[ $j ]['game_player_pitching_order'] ),
					);
				} else {
					//* If the player has stats in the array and we're adding the pitching stats, add the pitching stats, but keep the batting stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $team_ids[ $i ] ),
						'game_player_id'                 => intval( $player_ids[ $i ] ),
						'game_player_position'           => wp_filter_nohtml_kses( sanitize_text_field( $game_player_position[ $i ] ) ),
						'game_player_at_bats'            => intval( $stats[ $j ]['game_player_at_bats'] ),
						'game_player_hits'               => intval( $stats[ $j ]['game_player_hits'] ),
						'game_player_runs'               => intval( $stats[ $j ]['game_player_runs'] ),
						'game_player_rbis'               => intval( $stats[ $j ]['game_player_rbis'] ),
						'game_player_doubles'            => intval( $stats[ $j ]['game_player_doubles'] ),
						'game_player_triples'            => intval( $stats[ $j ]['game_player_triples'] ),
						'game_player_homeruns'           => intval( $stats[ $j ]['game_player_homeruns'] ),
						'game_player_strikeouts'         => intval( $stats[ $j ]['game_player_strikeouts'] ),
						'game_player_walks'              => intval( $stats[ $j ]['game_player_walks'] ),
						'game_player_hit_by_pitch'       => intval( $stats[ $j ]['game_player_hit_by_pitch'] ),
						'game_player_fielders_choice'    => intval( $stats[ $j ]['game_player_fielders_choice'] ),
						'game_player_innings_pitched'    => floatval( $game_player_innings_pitched[ $i ] ),
						'game_player_pitcher_strikeouts' => intval( $game_player_pitcher_strikeouts[ $i ] ),
						'game_player_pitcher_walks'      => intval( $game_player_pitcher_walks[ $i ] ),
						'game_player_runs_allowed'       => intval( $game_player_runs_allowed[ $i ] ),
						'game_player_earned_runs'        => intval( $game_player_earned_runs[ $i ] ),
						'game_player_hits_allowed'       => intval( $game_player_hits_allowed[ $i ] ),
						'game_player_homeruns_allowed'   => intval( $game_player_homeruns_allowed[ $i ] ),
						'game_player_pitch_count'        => intval( $game_player_pitch_count[ $i ] ),
						'game_player_hit_batters'        => intval( $game_player_hit_batters[ $i ] ),
						'game_player_decision'           => wp_filter_nohtml_kses( sanitize_text_field( $game_player_decision[ $i ] ) ),
						'game_player_batting_order'      => intval( $stats[ $j ]['game_player_batting_order'] ),
						'game_player_pitching_order'     => intval( $game_player_pitching_order[ $i ] ),
					);
				}
			} else {
				//* This is a brand new player, so add all of the stats
				if ( isset( $player_ids[ $i ] ) && 0 !== $player_ids[ $i ] ) {
					$stat = array(
						'game_stats_player_id'           => intval( $gs_id ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $team_ids[ $i ] ),
						'game_player_id'                 => intval( $player_ids[ $i ] ),
						'game_player_position'           => wp_filter_nohtml_kses( sanitize_text_field( $game_player_position[ $i ] ) ),
						'game_player_at_bats'            => intval( $game_player_at_bats[ $i ] ),
						'game_player_hits'               => intval( $game_player_hits[ $i ] ),
						'game_player_runs'               => intval( $game_player_runs[ $i ] ),
						'game_player_rbis'               => intval( $game_player_rbis[ $i ] ),
						'game_player_doubles'            => intval( $game_player_doubles[ $i ] ),
						'game_player_triples'            => intval( $game_player_triples[ $i ] ),
						'game_player_homeruns'           => intval( $game_player_homeruns[ $i ] ),
						'game_player_strikeouts'         => intval( $game_player_strikeouts[ $i ] ),
						'game_player_walks'              => intval( $game_player_walks[ $i ] ),
						'game_player_hit_by_pitch'       => intval( $game_player_hit_by_pitch[ $i ] ),
						'game_player_fielders_choice'    => intval( $game_player_fielders_choice[ $i ] ),
						'game_player_innings_pitched'    => floatval( $game_player_innings_pitched[ $i ] ),
						'game_player_pitcher_strikeouts' => intval( $game_player_pitcher_strikeouts[ $i ] ),
						'game_player_pitcher_walks'      => intval( $game_player_pitcher_walks[ $i ] ),
						'game_player_runs_allowed'       => intval( $game_player_runs_allowed[ $i ] ),
						'game_player_earned_runs'        => intval( $game_player_earned_runs[ $i ] ),
						'game_player_hits_allowed'       => intval( $game_player_hits_allowed[ $i ] ),
						'game_player_homeruns_allowed'   => intval( $game_player_homeruns_allowed[ $i ] ),
						'game_player_pitch_count'        => intval( $game_player_pitch_count[ $i ] ),
						'game_player_hit_batters'        => intval( $game_player_hit_batters[ $i ] ),
						'game_player_decision'           => wp_filter_nohtml_kses( sanitize_text_field( $game_player_decision[ $i ] ) ),
						'game_player_batting_order'      => intval( $game_player_batting_order[ $i ] ),
						'game_player_pitching_order'     => intval( $game_player_pitching_order[ $i ] ),
					);
					array_push( $stats, $stat );
					array_push( $ids, $player_ids[ $i ] );
				}
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
				$wpdb->update( SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats', $stat, array( 'game_stats_player_id' => $stat['game_stats_player_id'] ) );
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
		$events     = $this->get_game_events( $game_id );
		$stats      = $this->get_game_player_stats( $game_id );

		return [ $game, $events, $stats ];
	}

	/**
	 * Gets the events for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The id of the game to get.
	 * @return array            The game events.
	 */
	public function get_game_events( $game_id ) {
		global $wpdb;
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$quer            = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_events     = $wpdb->get_results( $quer );
		$events          = [];
		foreach ( $game_events as $event ) {
			$event_array = array(
				'game_info_id'          => $event->game_info_id,
				'game_id'               => $event->game_id,
				'game_info_inning'      => $event->game_info_inning,
				'game_info_top_bottom'  => $event->game_info_top_bottom,
				'game_info_home_score'  => $event->game_info_home_score,
				'game_info_away_score'  => $event->game_info_away_score,
				'game_info_runs_scored' => $event->game_info_runs_scored,
				'game_info_score_play'  => $event->game_info_score_play,

			);
			array_push( $events, $event_array );
		}
		return $events;
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
					'game_stats_player_id'              => $stat->game_stats_player_id,
					'game_id'                           => $stat->game_id,
					'game_team_id'                      => $stat->game_team_id,
					'game_player_id'                    => $stat->game_player_id,
					'game_player_at_bats'               => $stat->game_player_at_bats,
					'game_player_hits'                  => $stat->game_player_hits,
					'game_player_runs'                  => $stat->game_player_runs,
					'game_player_rbis'                  => $stat->game_player_rbis,
					'game_player_doubles'               => $stat->game_player_doubles,
					'game_player_triples'               => $stat->game_player_triples,
					'game_player_homeruns'              => $stat->game_player_homeruns,
					'game_player_strikeouts'            => $stat->game_player_strikeouts,
					'game_player_walks'                 => $stat->game_player_walks,
					'game_player_hit_by_pitch'          => $stat->game_player_hit_by_pitch,
					'game_player_fielders_choice'       => $stat->game_player_fielders_choice,
					'game_player_position'              => $stat->game_player_position,
					'game_player_innings_pitched'       => $stat->game_player_innings_pitched,
					'game_player_pitcher_strikeouts'    => $stat->game_player_pitcher_strikeouts,
					'game_player_pitcher_walks'         => $stat->game_player_pitcher_walks,
					'game_player_hit_batters'           => $stat->game_player_hit_batters,
					'game_player_runs_allowed'          => $stat->game_player_runs_allowed,
					'game_player_earned_runs'           => $stat->game_player_earned_runs,
					'game_player_hits_allowed'          => $stat->game_player_hits_allowed,
					'game_player_homeruns_allowed'      => $stat->game_player_homeruns_allowed,
					'game_player_pitch_count'           => $stat->game_player_pitch_count,
					'game_player_decision'              => $stat->game_player_decision,

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
		<h2><?php esc_html_e( 'Stat Line', 'sports-bench' ); ?></h2>
		<table id="score-line" class="form-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Runs', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Errors', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Left on Base', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-runs" class="screen-reader-text"><?php esc_html_e( 'Away Team Runs ', 'sports-bench' ); ?></label><input type="number" id="away-team-runs" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>"/></td>
					<td><label for="away-team-hits" class="screen-reader-text"><?php esc_html_e( 'Away Team Hits ', 'sports-bench' ); ?></label><input type="number" id="away-team-hits" name="game_away_hits" value="<?php echo esc_attr( $game['game_away_hits'] ); ?>" /></td>
					<td><label for="away-team-errors" class="screen-reader-text"><?php esc_html_e( 'Away Team Errors ', 'sports-bench' ); ?></label><input type="number" id="away-team-errors" name="game_away_errors" value="<?php echo esc_attr( $game['game_away_errors'] ); ?>" /></td>
					<td><label for="away-team-lob" class="screen-reader-text"><?php esc_html_e( 'Away Team Left on Base ', 'sports-bench' ); ?></label><input type="number" id="away-team-lob" name="game_away_lob" value="<?php echo esc_attr( $game['game_away_lob'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-runs" class="screen-reader-text"><?php esc_html_e( 'Home Team Runs ', 'sports-bench' ); ?></label><input type="number" id="home-team-runs" name="game_home_final" value="<?php echo esc_attr( $game['game_home_final'] ); ?>" /></td>
					<td><label for="home-team-hits" class="screen-reader-text"><?php esc_html_e( 'Home Team Hits ', 'sports-bench' ); ?></label><input type="number" id="home-team-hits" name="game_home_hits" value="<?php echo esc_attr( $game['game_home_hits'] ); ?>" /></td>
					<td><label for="home-team-errors" class="screen-reader-text"><?php esc_html_e( 'Home Team Errors ', 'sports-bench' ); ?></label><input type="number" id="home-team-errors" name="game_home_errors" value="<?php echo esc_attr( $game['game_home_errors'] ); ?>" /></td>
					<td><label for="home-team-lob" class="screen-reader-text"><?php esc_html_e( 'Home Team Left on Base ', 'sports-bench' ); ?></label><input type="number" id="home-team-lob" name="game_home_lob" value="<?php echo esc_attr( $game['game_home_lob'] ); ?>" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" value="<?php echo esc_attr( $game['game_current_time'] ); ?>" />
				</div>
				<input type="hidden" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
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
						<td><?php esc_html_e( 'Doubles', 'sports-bench' ); ?></td>
						<td><label for="away-team-doubles" class="screen-reader-text"><?php esc_html_e( 'Away Team Doubles ', 'sports-bench' ); ?></label><input type="text" id="away-team-doubles" name="game_away_doubles" value="<?php echo esc_attr( $game['game_away_doubles'] ); ?>" /></td>
						<td><label for="home-team-doubles" class="screen-reader-text"><?php esc_html_e( 'Home Team Doubles ', 'sports-bench' ); ?></label><input type="text" id="home-team-doubles" name="game_home_doubles" value="<?php echo esc_attr( $game['game_home_doubles'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Triples', 'sports-bench' ); ?></td>
						<td><label for="away-team-triples" class="screen-reader-text"><?php esc_html_e( 'Away Team Triples ', 'sports-bench' ); ?></label><input type="text" id="away-team-triples" name="game_away_triples" value="<?php echo esc_attr( $game['game_away_triples'] ); ?>" /></td>
						<td><label for="home-team-triples" class="screen-reader-text"><?php esc_html_e( 'Home Team Triples ', 'sports-bench' ); ?></label><input type="text" id="home-team-triples" name="game_home_triples" value="<?php echo esc_attr( $game['game_home_triples'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Homeruns', 'sports-bench' ); ?></td>
						<td><label for="away-team-homeruns" class="screen-reader-text"><?php esc_html_e( 'Away Team Homeruns ', 'sports-bench' ); ?></label><input type="text" id="away-team-homeruns" name="game_away_homeruns" value="<?php echo esc_attr( $game['game_away_homeruns'] ); ?>" /></td>
						<td><label for="home-team-homeruns" class="screen-reader-text"><?php esc_html_e( 'Home Team Homeruns ', 'sports-bench' ); ?></label><input type="text" id="home-team-homeruns" name="game_home_homeruns" value="<?php echo esc_attr( $game['game_home_homeruns'] ); ?>" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Fires to show the fields for a game events.
	 *
	 * @since 2.0.0
	 *
	 * @param array $events      The information for the game events.
	 */
	public function edit_game_events( $events ) {
		$teams    = $this->get_teams();
		$team_ids = [];
		if ( $teams ) {
			foreach ( $teams as $team ) {
				$team_ids[] = $team->get_team_id();
			}
		}
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Scoring Plays', 'sports-bench' ); ?></h2>
			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Inning', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Top/Bottom', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Outs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Count', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Type', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Play', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $events ) {
						foreach ( $events as $event ) {
							?>
							<tr class="game-event-row">
								<input type="hidden" name="game_info_id[]" value="<?php echo esc_attr( $event['game_info_id'] ); ?>" />
								<td><label for="game-event-inning" class="screen-reader-text"><?php esc_html_e( 'Inning ', 'sports-bench' ); ?></label><input type="number" id="game-event-inning" name="game_info_inning[]" value="<?php echo esc_attr( $event['game_info_inning'] ); ?>" /></td>
								<td><label for="game-event-top-bottom" class="screen-reader-text"><?php esc_html_e( 'Top/Bottom of Inning ', 'sports-bench' ); ?></label>
									<select id="game-event-top-bottom" name="game_info_top_bottom[]">
										<option value=""><?php esc_html_e( 'Select Half of Inning', 'sports-bench' ); ?></option>
										<option value="top" <?php selected( $event['game_info_top_bottom'], 'top' ); ?>><?php esc_html_e( 'Top', 'sports-bench' ); ?></option>
										<option value="bottom" <?php selected( $event['game_info_top_bottom'], 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'sports-bench' ); ?></option>
									</select>
								</td>
								<td><label for="game-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-home-score" name="game_info_home_score[]" value="<?php echo esc_attr( $event['game_info_home_score'] ); ?>" /></td>
								<td><label for="game-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-away-score" name="game_info_away_score[]" value="<?php echo esc_attr( $event['game_info_away_score'] ); ?>" /></td>
								<td><label for="game-event-outs" class="screen-reader-text"><?php esc_html_e( 'Game Event Outs ', 'sports-bench' ); ?></label><input type="number" id="game-event-outs" name="game_info_outs[]" value="<?php echo esc_attr( $event['game_info_outs'] ); ?>" /></td>
								<td><label for="game-event-count" class="screen-reader-text"><?php esc_html_e( 'Game Event Count ', 'sports-bench' ); ?></label><input type="text" id="game-event-away-count" name="game_info_count[]" value="<?php echo esc_attr( $event['game_info_count'] ); ?>" /></td>
								<td><label for="game-event-type" class="screen-reader-text"><?php esc_html_e( 'Game Event Type ', 'sports-bench' ); ?></label>
									<select id="game-event-type" name="game_info_type[]">
										<option value=""><?php esc_html_e( 'Select Type', 'sports-bench' ); ?></option>
										<option value="runs-scored" <?php selected( $event['game_info_type'], 'runs-scored' ); ?>><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></option>
										<option value="runs-position-change" <?php selected( $event['game_info_type'], 'runs-position-change' ); ?>><?php esc_html_e( 'Position Changed', 'sports-bench' ); ?></option>
										<option value="outs-walk" <?php selected( $event['game_info_type'], 'outs-walk' ); ?>><?php esc_html_e( 'Outs/Walk/Other', 'sports-bench' ); ?></option>
									</select>
								</td>
								<td><label for="game-event-runs-scored" class="screen-reader-text"><?php esc_html_e( 'Game Event Runs Scores ', 'sports-bench' ); ?></label><input type="number" id="game-event-runs-scored" name="game_info_runs_scored[]" value="<?php echo esc_attr( $event['game_info_runs_scored'] ); ?>" /></td>
								<td><label for="game-event-play" class="screen-reader-text"><?php esc_html_e( 'Play ', 'sports-bench' ); ?></label><input type="text" id="game-event-play" name="game_info_play[]" value="<?php echo esc_attr( $event['game_info_play'] ); ?>" /></td>
								<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row">
							<input type="hidden" name="game_info_id[]" />
							<td><label for="game-event-inning" class="screen-reader-text"><?php esc_html_e( 'Inning ', 'sports-bench' ); ?></label><input type="number" id="game-event-inning" name="game_info_inning[]" /></td>
							<td><label for="game-event-top-bottom" class="screen-reader-text"><?php esc_html_e( 'Top/Bottom of Inning ', 'sports-bench' ); ?></label>
								<select id="game-event-top-bottom" name="game_info_top_bottom[]">
									<option value=""><?php esc_html_e( 'Select Half of Inning', 'sports-bench' ); ?></option>
									<option value="top"><?php esc_html_e( 'Top', 'sports-bench' ); ?></option>
									<option value="bottom"><?php esc_html_e( 'Bottom', 'sports-bench' ); ?></option>
								</select>
							</td>
							<td><label for="game-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-home-score" name="game_info_home_score[]" /></td>
							<td><label for="game-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-away-score" name="game_info_away_score[]" /></td>
							<td><label for="game-event-outs" class="screen-reader-text"><?php esc_html_e( 'Game Event Outs ', 'sports-bench' ); ?></label><input type="number" id="game-event-outs" name="game_info_outs[]" /></td>
							<td><label for="game-event-count" class="screen-reader-text"><?php esc_html_e( 'Game Event Count ', 'sports-bench' ); ?></label><input type="text" id="game-event-away-count" name="game_info_count[]" /></td>
							<td><label for="game-event-type" class="screen-reader-text"><?php esc_html_e( 'Game Event Type ', 'sports-bench' ); ?></label>
								<select id="game-event-type" name="game_info_type[]">
									<option value=""><?php esc_html_e( 'Select Type', 'sports-bench' ); ?></option>
									<option value="runs-scored"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></option>
									<option value="runs-position-change"><?php esc_html_e( 'Position Changed', 'sports-bench' ); ?></option>
									<option value="outs-walk"><?php esc_html_e( 'Outs/Walk/Other', 'sports-bench' ); ?></option>
								</select>
							</td>
							<td><label for="game-event-runs-scored" class="screen-reader-text"><?php esc_html_e( 'Game Event Runs Scores ', 'sports-bench' ); ?></label><input type="number" id="game-event-runs-scored" name="game_info_runs_scored[]" /></td>
							<td><label for="game-event-play" class="screen-reader-text"><?php esc_html_e( 'Play ', 'sports-bench' ); ?></label><input type="text" id="game-event-played" name="game_info_play[]" /></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-event-empty-row screen-reader-text">
						<input type="hidden" name="game_info_id[]" class="new-field team" disabled="disabled" />
						<td><label for="game-event-inning" class="screen-reader-text"><?php esc_html_e( 'Inning ', 'sports-bench' ); ?></label><input type="number" id="game-event-inning" name="game_info_inning[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-top-bottom" class="screen-reader-text"><?php esc_html_e( 'Top/Bottom of Inning ', 'sports-bench' ); ?></label>
							<select id="game-event-top-bottom" name="game_info_top_bottom[]" class="new-field team" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Half of Inning', 'sports-bench' ); ?></option>
								<option value="top"><?php esc_html_e( 'Top', 'sports-bench' ); ?></option>
								<option value="bottom"><?php esc_html_e( 'Bottom', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-home-score" name="game_info_home_score[]"  class="new-field team" disabled="disabled"/></td>
						<td><label for="game-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Game Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="game-event-away-score" name="game_info_away_score[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-outs" class="screen-reader-text"><?php esc_html_e( 'Game Event Outs ', 'sports-bench' ); ?></label><input type="number" id="game-event-outs" name="game_info_outs[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-count" class="screen-reader-text"><?php esc_html_e( 'Game Event Count ', 'sports-bench' ); ?></label><input type="text" id="game-event-away-count" name="game_info_count[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-type" class="screen-reader-text"><?php esc_html_e( 'Game Event Type ', 'sports-bench' ); ?></label>
							<select id="game-event-type" name="game_info_type[]" class="new-field team" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Type', 'sports-bench' ); ?></option>
								<option value="runs-scored"><?php esc_html_e( 'Runs Scored', 'sports-bench' ); ?></option>
								<option value="runs-position-change"><?php esc_html_e( 'Position Changed', 'sports-bench' ); ?></option>
								<option value="outs-walk"><?php esc_html_e( 'Outs/Walk/Other', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="game-event-runs-scored" class="screen-reader-text"><?php esc_html_e( 'Game Event Runs Scores ', 'sports-bench' ); ?></label><input type="number" id="game-event-runs-scored" name="game_info_runs_scored[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="game-event-play" class="screen-reader-text"><?php esc_html_e( 'Play ', 'sports-bench' ); ?></label><input type="text" id="game-event-play" name="game_info_play[]" class="new-field team" disabled="disabled" /></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-event"><?php esc_html_e( 'Add Event', 'sports-bench' ); ?></button>
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
		$fielders    = [];
		$pitchers    = [];
		$player_list = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_away_id'] ) {
					if ( ( $player_stat['game_player_pitch_count'] > 0 ) && ( ( $player_stat['game_player_at_bats'] > 0 ) || ( $player_stat['game_player_walks'] > 0 ) || ( $player_stat['game_player_hit_by_pitch'] > 0 ) || ( $player_stat['game_player_fielders_choice'] > 0 ) ) ) {
						array_push( $pitchers, $player_stat );
						array_push( $fielders, $player_stat );
					} elseif ( ( $player_stat['game_player_pitch_count'] > 0 ) ) {
						array_push( $pitchers, $player_stat );
					} else {
						array_push( $fielders, $player_stat );
					}
				}
			}
		}

		$decisions = array (
			'ND'    => esc_html__( 'No Decision', 'sports-bench' ),
			'W'     => esc_html__( 'Win', 'sports-bench' ),
			'L'     => esc_html__( 'Loss', 'sports-bench' ),
			'H'     => esc_html__( 'Hold', 'sports-bench' ),
			'S'     => esc_html__( 'Save', 'sports-bench' ),
			'BS'    => esc_html__( 'Blown Save', 'sports-bench' ),
		);

		if ( $game['game_away_id'] > 0 ) {
			//* Get the away team players into an array
			$table_name   = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$team_id      = $game['game_away_id'];
			$quer         = "SELECT * FROM $table_name WHERE team_id = $team_id;";
			$the_players  = Database::get_results( $quer );
			$player_array = array(
				'player_id'   => '',
				'player_name' => esc_html__( 'Pick a Player', 'sports-bench' ),
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

		$player_ids = [];
		foreach ( $player_list as $player ) {
			$player_ids[] = $player['player_id'];
		}
		?>
		<div id="away-team-stats" class="game-details" <?php echo wp_kses_post( $border_style ); ?>>
			<h2><?php echo esc_html( $title ); ?></h2>
			<h3><?php esc_html_e( 'Batting', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Position', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ABs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'RBI', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '2B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FC', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $fielders ) {
						foreach ( $fielders as $player ) {
							$batter_count = 1;
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
								<td><label for="away-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="away-player-position" name="game_player_position[]" value="<?php echo esc_attr( $player['game_player_position'] ); ?>" /></td>
								<td><label for="away-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="away-player-at-bats" name="game_player_at_bats[]" value="<?php echo esc_attr( $player['game_player_at_bats'] ); ?>" /></td>
								<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" value="<?php echo esc_attr( $player['game_player_hits'] ); ?>" /></td>
								<td><label for="away-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs" name="game_player_runs[]" value="<?php echo esc_attr( $player['game_player_runs'] ); ?>" /></td>
								<td><label for="away-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="away-player-rbis" name="game_player_rbis[]" value="<?php echo esc_attr( $player['game_player_rbis'] ); ?>" /></td>
								<td><label for="away-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="away-player-doubles" name="game_player_doubles[]" value="<?php echo esc_attr( $player['game_player_doubles'] ); ?>" /></td>
								<td><label for="away-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="away-player-triples" name="game_player_triples[]" value="<?php echo esc_attr( $player['game_player_triples'] ); ?>" /></td>
								<td><label for="away-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs" name="game_player_homeruns[]" value="<?php echo esc_attr( $player['game_player_homeruns'] ); ?>" /></td>
								<td><label for="away-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-strikeouts" name="game_player_strikeouts[]" value="<?php echo esc_attr( $player['game_player_strikeouts'] ); ?>" /></td>
								<td><label for="away-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-walks" name="game_player_walks[]" value="<?php echo esc_attr( $player['game_player_walks'] ); ?>" /></td>
								<td><label for="away-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="away-player-hbp" name="game_player_hit_by_pitch[]" value="<?php echo esc_attr( $player['game_player_hit_by_pitch'] ); ?>" /></td>
								<td><label for="away-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="away-player-fielders-choice" name="game_player_fielders_choice[]" value="<?php echo esc_attr( $player['game_player_fielders_choice'] ); ?>" /></td>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_innings_pitched[]" value="<?php echo esc_attr( $player['game_player_innings_pitched'] ); ?>" />
								<input type="hidden" name="game_player_pitcher_strikeouts[]" value="<?php echo esc_attr( $player['game_player_pitcher_strikeouts'] ); ?>" />
								<input type="hidden" name="game_player_hit_batters[]" value="<?php echo esc_attr( $player['game_player_hit_batters'] ); ?>" />
								<input type="hidden" name="game_player_pitcher_walks[]" value="<?php echo esc_attr( $player['game_player_hit_batters'] ); ?>" />
								<input type="hidden" name="game_player_runs_allowed[]" value="<?php echo esc_attr( $player['game_player_runs_allowed'] ); ?>" />
								<input type="hidden" name="game_player_earned_runs[]" value="<?php echo esc_attr( $player['game_player_earned_runs'] ); ?>" />
								<input type="hidden" name="game_player_hits_allowed[]" value="<?php echo esc_attr( $player['game_player_hits_allowed'] ); ?>" />
								<input type="hidden" name="game_player_homeruns_allowed[]" value="<?php echo esc_attr( $player['game_player_homeruns_allowed'] ); ?>" />
								<input type="hidden" name="game_player_pitch_count[]" value="<?php echo esc_attr( $player['game_player_pitch_count'] ); ?>" />
								<input type="hidden" name="game_player_decision[]" value="<?php echo esc_attr( $player['game_player_decision'] ); ?>" />
								<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
								<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="<?php echo esc_attr( $batter_count ); ?>" size="6">
								<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
							</tr>
							<?php
							$batter_count++;
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
							<td><label for="away-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="away-player-position" name="game_player_position[]" /></td>
							<td><label for="away-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="away-player-at-bats" name="game_player_at_bats[]" /></td>
							<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" /></td>
							<td><label for="away-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs" name="game_player_runs[]" /></td>
							<td><label for="away-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="away-player-rbis" name="game_player_rbis[]" /></td>
							<td><label for="away-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="away-player-doubles" name="game_player_doubles[]" /></td>
							<td><label for="away-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="away-player-triples" name="game_player_triples[]"  /></td>
							<td><label for="away-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs" name="game_player_homeruns[]" /></td>
							<td><label for="away-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-strikeouts" name="game_player_strikeouts[]" /></td>
							<td><label for="away-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-walks" name="game_player_walks[]" /></td>
							<td><label for="away-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="away-player-hbp" name="game_player_hit_by_pitch[]"/></td>
							<td><label for="away-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="away-player-fielders-choice" name="game_player_fielders_choice[]" /></td>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_innings_pitched[]" />
							<input type="hidden" name="game_player_pitcher_strikeouts[]" />
							<input type="hidden" name="game_player_hit_batters[]" />
							<input type="hidden" name="game_player_runs_allowed[]" />
							<input type="hidden" name="game_player_pitcher_walks[]" />
							<input type="hidden" name="game_player_earned_runs[]" />
							<input type="hidden" name="game_player_hits_allowed[]" />
							<input type="hidden" name="game_player_homeruns_allowed[]" />
							<input type="hidden" name="game_player_pitch_count[]" />
							<input type="hidden" name="game_player_decision[]" />
							<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
							<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="1" size="6">
							<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
						</tr>
						<?php
					}
					?>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td><label for="away-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="away-player-position" name="game_player_position[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="away-player-at-bats" name="game_player_at_bats[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs" name="game_player_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="away-player-rbis" name="game_player_rbis[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="away-player-doubles" name="game_player_doubles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="away-player-triples" name="game_player_triples[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="away-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs" name="game_player_homeruns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-strikeouts" name="game_player_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-walks" name="game_player_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="away-player-hbp" name="game_player_hit_by_pitch[]"  class="new-field" disabled="disabled"/></td>
						<td><label for="away-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="away-player-fielders-choice" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled"/>
						<input type="hidden" name="game_player_hit_batters[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_earned_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitch_count[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_decision[]" class="new-field" disabled="disabled" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field" class="new-field" disabled="disabled"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Pitching', 'sports-bench' ); ?></h3>
			<table id="away-pitcher-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Decision', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'IP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ER', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'K', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'NP', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $pitchers ) {
						$pitcher_count = 1;
						foreach ( $pitchers as $pitcher ) {
							?>
							<tr class="game-away-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $pitcher['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $pitcher['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $pitcher['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $pitcher['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->player_id ) . '">' . esc_html( $the_player->player_first_name ) . ' ' . esc_html( $the_player->player_last_name ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $pitcher['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td>
									<label for="away-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
									<select id="away-player-decision" name="game_player_decision[]">
										<option value="ND" <?php selected( $pitcher['game_player_decision'], 'ND' ); ?>><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
										<option value="W" <?php selected( $pitcher['game_player_decision'], 'W' ); ?>><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
										<option value="L" <?php selected( $pitcher['game_player_decision'], 'L' ); ?>><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
										<option value="H" <?php selected( $pitcher['game_player_decision'], 'H' ); ?>><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
										<option value="S" <?php selected( $pitcher['game_player_decision'], 'S' ); ?>><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
										<option value="BS" <?php selected( $pitcher['game_player_decision'], 'BS' ); ?>><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
									</select>
								</td>
								<td><label for="away-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="away-player-innings-pitched" name="game_player_innings_pitched[]" step="any" lang="en-150" value="<?php echo esc_attr( $pitcher['game_player_innings_pitched'] ); ?>" /></td>
								<td><label for="away-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs-allowed" name="game_player_runs_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_runs_allowed'] ); ?>" /></td>
								<td><label for="away-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earn Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-earned-runs" name="game_player_earned_runs[]" value="<?php echo esc_attr( $pitcher['game_player_earned_runs'] ); ?>" /></td>
								<td><label for="away-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits-allowed" name="game_player_hits_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_hits_allowed'] ); ?>" /></td>
								<td><label for="away-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" value="<?php echo esc_attr( $pitcher['game_player_pitcher_strikeouts'] ); ?>" /></td>
								<td><label for="away-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-walks" name="game_player_pitcher_walks[]" value="<?php echo esc_attr( $pitcher['game_player_pitcher_walks'] ); ?>" /></td>
								<td><label for="away-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="away-player-hit-batters" name="game_player_hit_batters[]" value="<?php echo esc_attr( $pitcher['game_player_hit_batters'] ); ?>" /></td>
								<td><label for="away-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs-allowed" name="game_player_homeruns_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_homeruns_allowed'] ); ?>" /></td>
								<td><label for="away-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitch-count" name="game_player_pitch_count[]" value="<?php echo esc_attr( $pitcher['game_player_pitch_count'] ); ?>" /></td>
								<input type="hidden" name="game_player_position[]" value="P" />
								<input type="hidden" name="game_player_at_bats[]" value="<?php echo esc_attr( $pitcher['game_player_at_bats'] ); ?>" />
								<input type="hidden" name="game_player_hits[]" value="<?php echo esc_attr( $pitcher['game_player_hits'] ); ?>" />
								<input type="hidden" name="game_player_runs[]" value="<?php echo esc_attr( $pitcher['game_player_runs'] ); ?>" />
								<input type="hidden" name="game_player_rbis[]" value="<?php echo esc_attr( $pitcher['game_player_rbis'] ); ?>" />
								<input type="hidden" name="game_player_doubles[]" value="<?php echo esc_attr( $pitcher['game_player_doubles'] ); ?>" />
								<input type="hidden" name="game_player_triples[]" value="<?php echo esc_attr( $pitcher['game_player_triples'] ); ?>" />
								<input type="hidden" name="game_player_homeruns[]" value="<?php echo esc_attr( $pitcher['game_player_homeruns'] ); ?>" />
								<input type="hidden" name="game_player_strikeouts[]" value="<?php echo esc_attr( $pitcher['game_player_strikeouts'] ); ?>" />
								<input type="hidden" name="game_player_walks[]" value="<?php echo esc_attr( $pitcher['game_player_walks'] ); ?>" />
								<input type="hidden" name="game_player_hit_by_pitch[]" value="<?php echo esc_attr( $pitcher['game_player_hit_by_pitch'] ); ?>" />
								<input type="hidden" name="game_player_fielders_choice[]" value="<?php echo esc_attr( $pitcher['game_player_fielders_choice'] ); ?>" />
								<input type="hidden" name="game_player_batting_order[]" value="0" />
								<input type="hidden" name="game_player_pitching_order[]" value="<?php echo esc_attr( $pitcher_count ); ?>" />
								<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
							$pitcher_count++;
						}
					} else {
						?>
						<tr class="game-away-2-row">
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
							<td>
								<label for="away-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
								<select id="away-player-decision" name="game_player_decision[]">
									<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
									<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
									<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
									<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
									<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
									<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
								</select>
							</td>
							<td><label for="away-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="away-player-innings-pitched" name="game_player_innings_pitched[]" step="any" lang="en-150" /></td>
							<td><label for="away-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs-allowed" name="game_player_runs_allowed[]" /></td>
							<td><label for="away-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-earned-runs" name="game_player_earned_runs[]" /></td>
							<td><label for="away-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits-allowed" name="game_player_hits_allowed[]" /></td>
							<td><label for="away-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" /></td>
							<td><label for="away-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-walks" name="game_player_pitcher_walks[]" /></td>
							<td><label for="away-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="away-player-hit-batters" name="game_player_hit_batters[]" /></td>
							<td><label for="away-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs-allowed" name="game_player_homeruns_allowed[]" /></td>
							<td><label for="away-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitch-count" name="game_player_pitch_count[]" /></td>
							<input type="hidden" name="game_player_position[]" value="P" />
							<input type="hidden" name="game_player_at_bats[]" />
							<input type="hidden" name="game_player_hits[]" />
							<input type="hidden" name="game_player_runs[]" />
							<input type="hidden" name="game_player_rbis[]" />
							<input type="hidden" name="game_player_doubles[]" />
							<input type="hidden" name="game_player_triples[]" />
							<input type="hidden" name="game_player_homeruns[]" />
							<input type="hidden" name="game_player_strikeouts[]" />
							<input type="hidden" name="game_player_walks[]" />
							<input type="hidden" name="game_player_hit_by_pitch[]" />
							<input type="hidden" name="game_player_fielders_choice[]" />
							<input type="hidden" name="game_player_batting_order[]" value="1" />
							<input type="hidden" name="game_player_pitching_order[]" value="0" />
							<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td>
							<label for="away-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="away-player-decision" name="game_player_decision[]" class="new-field" disabled="disabled">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="away-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="away-player-innings-pitched" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" step="any" lang="en-150" /></td>
						<td><label for="away-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-runs-allowed" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="away-player-earned-runs" name="game_player_earned_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits-allowed" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitcher-walks" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="away-player-hit-batters" name="game_player_hit_batters[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Homeruns Allowed ', 'sports-bench' ); ?></label><input type="number" id="away-player-home-runs-allowed" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="away-player-pitch-count" name="game_player_pitch_count[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_position[]" value="P" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_at_bats[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rbis[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_doubles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_triples[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_strikeouts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hit_by_pitch[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_batting_order[]" class="new-field" disabled="disabled" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" class="new-field" disabled="disabled" value="0" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
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
		$fielders    = [];
		$pitchers    = [];
		$player_list = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_home_id'] ) {
					if ( ( $player_stat['game_player_pitch_count'] > 0 ) && ( ( $player_stat['game_player_at_bats'] > 0 ) || ( $player_stat['game_player_walks'] > 0 ) || ( $player_stat['game_player_hit_by_pitch'] > 0 ) || ( $player_stat['game_player_fielders_choice'] > 0 ) ) ) {
						array_push( $pitchers, $player_stat );
						array_push( $fielders, $player_stat );
					} elseif ( ( $player_stat['game_player_pitch_count'] > 0 ) ) {
						array_push( $pitchers, $player_stat );
					} else {
						array_push( $fielders, $player_stat );
					}
				}
			}
		}

		$decisions = array (
			'ND'    => esc_html__( 'No Decision', 'sports-bench' ),
			'W'     => esc_html__( 'Win', 'sports-bench' ),
			'L'     => esc_html__( 'Loss', 'sports-bench' ),
			'H'     => esc_html__( 'Hold', 'sports-bench' ),
			'S'     => esc_html__( 'Save', 'sports-bench' ),
			'BS'    => esc_html__( 'Blown Save', 'sports-bench' ),
		);

		if ( $game['game_home_id'] > 0 ) {
			//* Get the home team players into an array
			$table_name   = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$team_id      = $game['game_home_id'];
			$quer         = "SELECT * FROM $table_name WHERE team_id = $team_id;";
			$the_players  = Database::get_results( $quer );
			$player_array = array(
				'player_id'   => '',
				'player_name' => esc_html__( 'Pick a Player', 'sports-bench' ),
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

		$player_ids = [];
		foreach ( $player_list as $player ) {
			$player_ids[] = $player['player_id'];
		}
		?>
		<div id="home-team-stats" class="game-details" <?php echo wp_kses_post( $border_style ); ?>>
			<h2><?php echo esc_html( $title ); ?></h2>
			<h3><?php esc_html_e( 'Batting', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Position', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ABs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'RBI', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '2B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3B', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FC', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $fielders ) {
						foreach ( $fielders as $player ) {
							$batter_count = 1;
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
								<td><label for="home-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="home-player-position" name="game_player_position[]" value="<?php echo esc_attr( $player['game_player_position'] ); ?>" /></td>
								<td><label for="home-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="home-player-at-bats" name="game_player_at_bats[]" value="<?php echo esc_attr( $player['game_player_at_bats'] ); ?>" /></td>
								<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" value="<?php echo esc_attr( $player['game_player_hits'] ); ?>" /></td>
								<td><label for="home-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs" name="game_player_runs[]" value="<?php echo esc_attr( $player['game_player_runs'] ); ?>" /></td>
								<td><label for="home-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="home-player-rbis" name="game_player_rbis[]" value="<?php echo esc_attr( $player['game_player_rbis'] ); ?>" /></td>
								<td><label for="home-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="home-player-doubles" name="game_player_doubles[]" value="<?php echo esc_attr( $player['game_player_doubles'] ); ?>" /></td>
								<td><label for="home-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="home-player-triples" name="game_player_triples[]" value="<?php echo esc_attr( $player['game_player_triples'] ); ?>" /></td>
								<td><label for="home-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs" name="game_player_homeruns[]" value="<?php echo esc_attr( $player['game_player_homeruns'] ); ?>" /></td>
								<td><label for="home-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-strikeouts" name="game_player_strikeouts[]" value="<?php echo esc_attr( $player['game_player_strikeouts'] ); ?>" /></td>
								<td><label for="home-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-walks" name="game_player_walks[]" value="<?php echo esc_attr( $player['game_player_walks'] ); ?>" /></td>
								<td><label for="home-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="home-player-hbp" name="game_player_hit_by_pitch[]" value="<?php echo esc_attr( $player['game_player_hit_by_pitch'] ); ?>" /></td>
								<td><label for="home-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="home-player-fielders-choice" name="game_player_fielders_choice[]" value="<?php echo esc_attr( $player['game_player_fielders_choice'] ); ?>" /></td>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_innings_pitched[]" value="<?php echo esc_attr( $player['game_player_innings_pitched'] ); ?>" />
								<input type="hidden" name="game_player_pitcher_strikeouts[]" value="<?php echo esc_attr( $player['game_player_pitcher_strikeouts'] ); ?>" />
								<input type="hidden" name="game_player_hit_batters[]" value="<?php echo esc_attr( $player['game_player_hit_batters'] ); ?>" />
								<input type="hidden" name="game_player_pitcher_walks[]" value="<?php echo esc_attr( $player['game_player_hit_batters'] ); ?>" />
								<input type="hidden" name="game_player_runs_allowed[]" value="<?php echo esc_attr( $player['game_player_runs_allowed'] ); ?>" />
								<input type="hidden" name="game_player_earned_runs[]" value="<?php echo esc_attr( $player['game_player_earned_runs'] ); ?>" />
								<input type="hidden" name="game_player_hits_allowed[]" value="<?php echo esc_attr( $player['game_player_hits_allowed'] ); ?>" />
								<input type="hidden" name="game_player_homeruns_allowed[]" value="<?php echo esc_attr( $player['game_player_homeruns_allowed'] ); ?>" />
								<input type="hidden" name="game_player_pitch_count[]" value="<?php echo esc_attr( $player['game_player_pitch_count'] ); ?>" />
								<input type="hidden" name="game_player_decision[]" value="<?php echo esc_attr( $player['game_player_decision'] ); ?>" />
								<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
								<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="<?php echo esc_attr( $batter_count ); ?>" size="6">
								<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
							</tr>
							<?php
							$batter_count++;
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
							<td><label for="home-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="home-player-position" name="game_player_position[]" /></td>
							<td><label for="home-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="home-player-at-bats" name="game_player_at_bats[]" /></td>
							<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" /></td>
							<td><label for="home-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs" name="game_player_runs[]" /></td>
							<td><label for="home-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="home-player-rbis" name="game_player_rbis[]" /></td>
							<td><label for="home-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="home-player-doubles" name="game_player_doubles[]" /></td>
							<td><label for="home-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="home-player-triples" name="game_player_triples[]"  /></td>
							<td><label for="home-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs" name="game_player_homeruns[]" /></td>
							<td><label for="home-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-strikeouts" name="game_player_strikeouts[]" /></td>
							<td><label for="home-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-walks" name="game_player_walks[]" /></td>
							<td><label for="home-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="home-player-hbp" name="game_player_hit_by_pitch[]"/></td>
							<td><label for="home-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="home-player-fielders-choice" name="game_player_fielders_choice[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_innings_pitched[]" />
							<input type="hidden" name="game_player_pitcher_strikeouts[]" />
							<input type="hidden" name="game_player_pitcher_walks[]" />
							<input type="hidden" name="game_player_hit_batters[]" />
							<input type="hidden" name="game_player_runs_allowed[]" />
							<input type="hidden" name="game_player_earned_runs[]" />
							<input type="hidden" name="game_player_hits_allowed[]" />
							<input type="hidden" name="game_player_homeruns_allowed[]" />
							<input type="hidden" name="game_player_pitch_count[]" />
							<input type="hidden" name="game_player_decision[]" />
							<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field"/>
							<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="1" size="6">
							<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6">
						</tr>
						<?php
					}
					?>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td><label for="home-player-position" class="screen-reader-text"><?php esc_html_e( 'Position ', 'sports-bench' ); ?></label><input type="text" id="home-player-position" name="game_player_position[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-at-bats" class="screen-reader-text"><?php esc_html_e( 'At Bats ', 'sports-bench' ); ?></label><input type="number" id="home-player-at-bats" name="game_player_at_bats[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-runs" class="screen-reader-text"><?php esc_html_e( 'Runs Scored ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs" name="game_player_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rbis" class="screen-reader-text"><?php esc_html_e( 'RBIs ', 'sports-bench' ); ?></label><input type="number" id="home-player-rbis" name="game_player_rbis[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-doubles" class="screen-reader-text"><?php esc_html_e( 'Doubles ', 'sports-bench' ); ?></label><input type="number" id="home-player-doubles" name="game_player_doubles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-triples" class="screen-reader-text"><?php esc_html_e( 'Triples ', 'sports-bench' ); ?></label><input type="number" id="home-player-triples" name="game_player_triples[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="home-player-home-runs" class="screen-reader-text"><?php esc_html_e( 'Home Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs" name="game_player_homeruns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-strikeouts" name="game_player_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-walks" class="screen-reader-text"><?php esc_html_e( 'Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-walks" name="game_player_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hbp" class="screen-reader-text"><?php esc_html_e( 'Hit By Pitch ', 'sports-bench' ); ?></label><input type="number" id="home-player-hbp" name="game_player_hit_by_pitch[]"  class="new-field" disabled="disabled"/></td>
						<td><label for="home-player-fielders-choice" class="screen-reader-text"><?php esc_html_e( 'Fielder\'s Choice ', 'sports-bench' ); ?></label><input type="number" id="home-player-fielders-choice" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled"/>
						<input type="hidden" name="game_player_hit_batters[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_earned_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pitch_count[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_decision[]" class="new-field" disabled="disabled" />
						<input id="game_stats_pitch_field" name="game_stats_pitch_field[]" type="hidden" value="field" class="new-field" disabled="disabled"/>
						<input id="game_player_batting_order" name="game_player_batting_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<input id="game_player_pitching_order" name="game_player_pitching_order[]" type="hidden" value="0" size="6" class="new-field" disabled="disabled">
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Pitching', 'sports-bench' ); ?></h3>
			<table id="home-pitcher-stats" class="form-table baseball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Decision', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'IP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'R', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'ER', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'H', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'K', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BB', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HBP', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'HR', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'NP', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $pitchers ) {
						$pitcher_count = 1;
						foreach ( $pitchers as $pitcher ) {
							?>
							<tr class="game-home-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $pitcher['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $pitcher['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $pitcher['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $pitcher['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $pitcher['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td>
									<label for="home-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
									<select id="home-player-decision" name="game_player_decision[]">
										<option value="ND" <?php selected( $pitcher['game_player_decision'], 'ND' ); ?>><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
										<option value="W" <?php selected( $pitcher['game_player_decision'], 'W' ); ?>><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
										<option value="L" <?php selected( $pitcher['game_player_decision'], 'L' ); ?>><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
										<option value="H" <?php selected( $pitcher['game_player_decision'], 'H' ); ?>><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
										<option value="S" <?php selected( $pitcher['game_player_decision'], 'S' ); ?>><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
										<option value="BS" <?php selected( $pitcher['game_player_decision'], 'BS' ); ?>><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
									</select>
								</td>
								<td><label for="home-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="home-player-innings-pitched" name="game_player_innings_pitched[]" value="<?php echo esc_attr( $pitcher['game_player_innings_pitched'] ); ?>" step="any" lang="en-150" /></td>
								<td><label for="home-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs-allowed" name="game_player_runs_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_runs_allowed'] ); ?>" /></td>
								<td><label for="home-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earn Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-earned-runs" name="game_player_earned_runs[]" value="<?php echo esc_attr( $pitcher['game_player_earned_runs'] ); ?>" /></td>
								<td><label for="home-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits-allowed" name="game_player_hits_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_hits_allowed'] ); ?>" /></td>
								<td><label for="home-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" value="<?php echo esc_attr( $pitcher['game_player_pitcher_strikeouts'] ); ?>" /></td>
								<td><label for="home-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-walks" name="game_player_pitcher_walks[]" value="<?php echo esc_attr( $pitcher['game_player_pitcher_walks'] ); ?>" /></td>
								<td><label for="home-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="home-player-hit-batters" name="game_player_hit_batters[]" value="<?php echo esc_attr( $pitcher['game_player_hit_batters'] ); ?>" /></td>
								<td><label for="home-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs-allowed" name="game_player_homeruns_allowed[]" value="<?php echo esc_attr( $pitcher['game_player_homeruns_allowed'] ); ?>" /></td>
								<td><label for="home-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitch-count" name="game_player_pitch_count[]" value="<?php echo esc_attr( $pitcher['game_player_pitch_count'] ); ?>" /></td>
								<input type="hidden" name="game_player_position[]" value="P" />
								<input type="hidden" name="game_player_at_bats[]" value="<?php echo esc_attr( $pitcher['game_player_at_bats'] ); ?>" />
								<input type="hidden" name="game_player_hits[]" value="<?php echo esc_attr( $pitcher['game_player_hits'] ); ?>" />
								<input type="hidden" name="game_player_runs[]" value="<?php echo esc_attr( $pitcher['game_player_runs'] ); ?>" />
								<input type="hidden" name="game_player_rbis[]" value="<?php echo esc_attr( $pitcher['game_player_rbis'] ); ?>" />
								<input type="hidden" name="game_player_doubles[]" value="<?php echo esc_attr( $pitcher['game_player_doubles'] ); ?>" />
								<input type="hidden" name="game_player_triples[]" value="<?php echo esc_attr( $pitcher['game_player_triples'] ); ?>" />
								<input type="hidden" name="game_player_homeruns[]" value="<?php echo esc_attr( $pitcher['game_player_homeruns'] ); ?>" />
								<input type="hidden" name="game_player_strikeouts[]" value="<?php echo esc_attr( $pitcher['game_player_strikeouts'] ); ?>" />
								<input type="hidden" name="game_player_walks[]" value="<?php echo esc_attr( $pitcher['game_player_walks'] ); ?>" />
								<input type="hidden" name="game_player_hit_by_pitch[]" value="<?php echo esc_attr( $pitcher['game_player_hit_by_pitch'] ); ?>" />
								<input type="hidden" name="game_player_fielders_choice[]" value="<?php echo esc_attr( $pitcher['game_player_fielders_choice'] ); ?>" />
								<input type="hidden" name="game_player_batting_order[]" value="0" />
								<input type="hidden" name="game_player_pitching_order[]" value="<?php echo esc_attr( $pitcher_count ); ?>" />
								<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
							$pitcher_count++;
						}
					} else {
						?>
						<tr class="game-home-2-row">
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
							<td>
								<label for="home-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
								<select id="home-player-decision" name="game_player_decision[]">
									<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
									<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
									<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
									<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
									<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
									<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
								</select>
							</td>
							<td><label for="home-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="home-player-innings-pitched" name="game_player_innings_pitched[]" step="any" lang="en-150" /></td>
							<td><label for="home-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs-allowed" name="game_player_runs_allowed[]" /></td>
							<td><label for="home-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-earned-runs" name="game_player_earned_runs[]" /></td>
							<td><label for="home-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits-allowed" name="game_player_hits_allowed[]" /></td>
							<td><label for="home-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" /></td>
							<td><label for="home-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-walks" name="game_player_pitcher_walks[]" /></td>
							<td><label for="home-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="home-player-hit-batters" name="game_player_hit_batters[]" /></td>
							<td><label for="home-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Home Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs-allowed" name="game_player_homeruns_allowed[]" /></td>
							<td><label for="home-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitch-count" name="game_player_pitch_count[]" /></td>
							<input type="hidden" name="game_player_position[]" value="P" />
							<input type="hidden" name="game_player_at_bats[]" />
							<input type="hidden" name="game_player_hits[]" />
							<input type="hidden" name="game_player_runs[]" />
							<input type="hidden" name="game_player_rbis[]" />
							<input type="hidden" name="game_player_doubles[]" />
							<input type="hidden" name="game_player_triples[]" />
							<input type="hidden" name="game_player_homeruns[]" />
							<input type="hidden" name="game_player_strikeouts[]" />
							<input type="hidden" name="game_player_walks[]" />
							<input type="hidden" name="game_player_hit_by_pitch[]" />
							<input type="hidden" name="game_player_fielders_choice[]" />
							<input type="hidden" name="game_player_batting_order[]" value="0" />
							<input type="hidden" name="game_player_pitching_order[]" value="1" />
							<input name="game_stats_pitch_field[]" type="hidden" value="pitch"/>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td>
							<label for="home-player-decision" class="screen-reader-text"><?php esc_html_e( 'Decision ', 'sports-bench' ); ?></label>
							<select id="home-player-decision" name="game_player_decision[]" class="new-field" disabled="disabled">
								<option value="ND"><?php esc_html_e( 'No Decision', 'sports-bench' ); ?></option>
								<option value="W"><?php esc_html_e( 'Win', 'sports-bench' ); ?></option>
								<option value="L"><?php esc_html_e( 'Loss', 'sports-bench' ); ?></option>
								<option value="H"><?php esc_html_e( 'Hold', 'sports-bench' ); ?></option>
								<option value="S"><?php esc_html_e( 'Save', 'sports-bench' ); ?></option>
								<option value="BS"><?php esc_html_e( 'Blown Save', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="home-player-innings-pitched" class="screen-reader-text"><?php esc_html_e( 'Innings Pitched ', 'sports-bench' ); ?></label><input type="number" id="home-player-innings-pitched" name="game_player_innings_pitched[]" class="new-field" disabled="disabled" step="any" lang="en-150" /></td>
						<td><label for="home-player-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Runs Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-runs-allowed" name="game_player_runs_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-earned-runs" class="screen-reader-text"><?php esc_html_e( 'Earned Runs ', 'sports-bench' ); ?></label><input type="number" id="home-player-earned-runs" name="game_player_earned_runs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits-allowed" class="screen-reader-text"><?php esc_html_e( 'Hits Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits-allowed" name="game_player_hits_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitcher-strikeouts" class="screen-reader-text"><?php esc_html_e( 'Pitcher Strikeouts ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-strikeouts" name="game_player_pitcher_strikeouts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitcher-walks" class="screen-reader-text"><?php esc_html_e( 'Pitcher Walks ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitcher-walks" name="game_player_pitcher_walks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hit-batters" class="screen-reader-text"><?php esc_html_e( 'Hit Batters ', 'sports-bench' ); ?></label><input type="number" id="home-player-hit-batters" name="game_player_hit_batters[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-home-runs-allowed" class="screen-reader-text"><?php esc_html_e( 'Homeruns Allowed ', 'sports-bench' ); ?></label><input type="number" id="home-player-home-runs-allowed" name="game_player_homeruns_allowed[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pitch-count" class="screen-reader-text"><?php esc_html_e( 'Pitch Count ', 'sports-bench' ); ?></label><input type="number" id="home-player-pitch-count" name="game_player_pitch_count[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_position[]" value="P" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_at_bats[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_runs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rbis[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_doubles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_triples[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_homeruns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_strikeouts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_walks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hit_by_pitch[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fielders_choice[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_batting_order[]" class="new-field" disabled="disabled" value="0" />
						<input type="hidden" name="game_player_pitching_order[]" class="new-field" disabled="disabled" value="0" />
						<input name="game_stats_pitch_field[]" type="hidden" value="pitch" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
