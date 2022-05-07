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

namespace Sports_Bench\Classes\Sports\Football;

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
class FootballAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new FootballAdminGame object to be used.
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
					<th class="center"><?php esc_html_e( 'OT', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-quarter" name="game_away_first_quarter" /></td>
					<td><label for="away-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-quarter" name="game_away_second_quarter" /></td>
					<td><label for="away-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-quarter" name=" game_away_third_quarter"  /></td>
					<td><label for="away-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-quarter" name="game_away_fourth_quarter" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-quarter" name="game_home_first_quarter" /></td>
					<td><label for="home-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-quarter" name="game_home_second_quarter" /></td>
					<td><label for="home-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-quarter" name=" game_home_third_quarter" /></td>
					<td><label for="home-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-quarter" name="game_home_fourth_quarter" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" />
				</div>
				<div class="field one-column">
					<label for="game-current-quarter"><?php esc_html_e( 'Current Quarter in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-quarter" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
				</div>
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
						<td><?php esc_html_e( 'Total Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Total Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yards" name="game_away_total" /></td>
						<td><label for="home-team-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Total Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yards" name="game_home_total" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Pass Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-pass" class="screen-reader-text"><?php esc_html_e( 'Away Team Pass Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-pass" name="game_away_pass" /></td>
						<td><label for="home-team-pass" class="screen-reader-text"><?php esc_html_e( 'Home Team Pass Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-pass" name="game_home_pass" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Rush Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-rush" class="screen-reader-text"><?php esc_html_e( 'Away Team Rush Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-rush" name="game_away_rush" /></td>
						<td><label for="home-team-rush" class="screen-reader-text"><?php esc_html_e( 'Home Team Rush Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-rush" name="game_home_rush" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-to" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-to" name="game_away_to" /></td>
						<td><label for="home-team-to" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-to" name="game_home_to" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Interceptions Thrown', 'sports-bench' ); ?></td>
						<td><label for="away-team-int" class="screen-reader-text"><?php esc_html_e( 'Away Team Interceptions Thrown ', 'sports-bench' ); ?></label><input type="number" id="away-team-int" name="game_away_ints" /></td>
						<td><label for="home-team-int" class="screen-reader-text"><?php esc_html_e( 'Home Team Interceptions Thrown ', 'sports-bench' ); ?></label><input type="number" id="home-team-int" name="game_home_ints" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></td>
						<td><label for="away-team-fumbles" class="screen-reader-text"><?php esc_html_e( 'Away Team Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-team-fumbles" name="game_away_fumbles"  /></td>
						<td><label for="home-team-fumbles" class="screen-reader-text"><?php esc_html_e( 'Home Team Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-team-fumbles" name="game_home_fumbles" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fumbles Lost', 'sports-bench' ); ?></td>
						<td><label for="away-team-fumbles-lost" class="screen-reader-text"><?php esc_html_e( 'Away Team Fumbles Lost ', 'sports-bench' ); ?></label><input type="number" id="away-team-fumbles-lost" name="game_away_fumbles_lost" /></td>
						<td><label for="home-team-fumbles-lost" class="screen-reader-text"><?php esc_html_e( 'Home Team Fumbles Lost ', 'sports-bench' ); ?></label><input type="number" id="home-team-fumbles-lost" name="game_home_fumbles_lost" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Possession', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="text" id="away-team-possession" name="game_away_possession"  /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="text" id="home-team-possession" name="game_home_possession" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-returns" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Returns ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-returns" name="game_away_kick_returns" /></td>
						<td><label for="home-team-kick-returns" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Returns ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-returns" name="game_home_kick_returns" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Returns Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-returns-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Returns Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-returns-yards" name="game_away_kick_return_yards" /></td>
						<td><label for="home-team-kick-returns-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Returns Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-returns-yards" name="game_home_kick_return_yards" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalties" name="game_away_penalties" /></td>
						<td><label for="home-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalties" name="game_home_penalties" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalty-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalty-yards" name="game_away_penalty_yards" /></td>
						<td><label for="home-team-penalty-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalty-yards" name="game_home_penalty_yards" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'First Downs', 'sports-bench' ); ?></td>
						<td><label for="away-team-first-downs" class="screen-reader-text"><?php esc_html_e( 'Away Team First Downs ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-downs" name="game_away_first_downs" /></td>
						<td><label for="home-team-first-downs" class="screen-reader-text"><?php esc_html_e( 'Home Team First Downs ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-downs" name="game_home_first_downs" /></td>
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
			<h2><?php esc_html_e( 'Match Events', 'sports-bench' ); ?></h2>
			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Quarter', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Scoring Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Scoring Play', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row">
						<td><label for="match-event-quarter" class="screen-reader-text"><?php esc_html_e( 'Match Event Quarter ', 'sports-bench' ); ?></label><input type="number" id="match-event-quarter" name="game_info_quarter[]" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" />
							<select id="match-event-team" name="game_info_scoring_team_id[]" class="team">
								<?php
								if ( $teams ) {
									foreach ( $teams as $team ) {
										?>
										<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_location() ); ?></option>
										<?php
									}
								}
								?>
							</select>
						</td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" /></td>
						<td><label for="match-event-play" class="screen-reader-text"><?php esc_html_e( 'Match Event Scoring Play ', 'sports-bench' ); ?></label><input type="text" id="match-event-play" name="game_info_play[]" /></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-event-empty-row screen-reader-text">
						<td><label for="match-event-quarter" class="screen-reader-text"><?php esc_html_e( 'Match Event Quarter ', 'sports-bench' ); ?></label><input type="number" id="match-event-quarter" name="game_info_quarter[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field" disabled="disabled" />
							<select id="match-event-team" name="game_info_scoring_team_id[]" class="team new-field" disabled="disabled">
								<?php
								if ( $teams ) {
									foreach ( $teams as $team ) {
										?>
										<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_location() ); ?></option>
										<?php
									}
								}
								?>
							</select>
						</td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-play" class="screen-reader-text"><?php esc_html_e( 'Match Event Scoring Play ', 'sports-bench' ); ?></label><input type="text" id="match-event-play" name="game_info_play[]" /></td>
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
		?>
		<div id="away-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Away Team Player Stats', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Passing', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Completions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'INTs', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-comp" name="game_player_completions[]" /></td>
						<td><label for="away-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-attempts" name="game_player_attempts[]" /></td>
						<td><label for="away-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-yards" name="game_player_pass_yards[]" /></td>
						<td><label for="away-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-td" name="game_player_pass_tds[]" /></td>
						<td><label for="away-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-int" name="game_player_pass_ints[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-comp" name="game_player_completions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-attempts" name="game_player_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-yards" name="game_player_pass_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-td" name="game_player_pass_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-int" name="game_player_pass_ints[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Rushing', 'sports-bench' ); ?></h3>
			<table id="away-keeper-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Rushes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-2-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush" name="game_player_rushes[]" /></td>
						<td><label for="away-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-yards" name="game_player_rush_yards[]" /></td>
						<td><label for="away-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-td" name="game_player_rush_tds[]" /></td>
						<td><label for="away-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-fum" name="game_player_rush_fumbles[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush" name="game_player_rushes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-yards" name="game_player_rush_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-td" name="game_player_rush_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-fum" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Receiving', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Catches', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-3-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-catches" name="game_player_catches[]" /></td>
						<td><label for="away-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-yards" name="game_player_receiving_yards[]" /></td>
						<td><label for="away-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-td" name="game_player_receiving_tds[]" /></td>
						<td><label for="away-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-fum" name="game_player_receiving_fumbles[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-3-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-catches" name="game_player_catches[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-yards" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-td" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-fum" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-3" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Defense', 'sports-bench' ); ?></h3>
			<table id="away-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles for Loss', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pass Break Ups', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Interceptions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdown Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Forced Fumbles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles Recovered', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kick Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Return Yards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-4-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="away-player-tackles" name="game_player_tackles[]" /></td>
						<td><label for="away-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="away-player-tfl" name="game_player_tfl[]" /></td>
						<td><label for="away-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-sacks" name="game_player_sacks[]" /></td>
						<td><label for="away-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="away-player-pbu" name="game_player_pbu[]" /></td>
						<td><label for="away-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-ints" name="game_player_ints[]" /></td>
						<td><label for="away-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-tds" name="game_player_tds[]" /></td>
						<td><label for="away-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-ff" name="game_player_ff[]" /></td>
						<td><label for="away-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fr" name="game_player_fr[]" /></td>
						<td><label for="away-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-rkick-blocks" name="game_player_blocked[]" /></td>
						<td><label for="away-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-yards" name="game_player_yards[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-4-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="away-player-tackles" name="game_player_tackles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="away-player-tfl" name="game_player_tfl[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-sacks" name="game_player_sacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="away-player-pbu" name="game_player_pbu[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-ints" name="game_player_ints[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-tds" name="game_player_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-ff" name="game_player_ff[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fr" name="game_player_fr[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-rkick-blocks" name="game_player_blocked[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-yards" name="game_player_yards[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-4" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kicking', 'sports-bench' ); ?></h3>
			<table id="away-kicking-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchbacks', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-5-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" /></td>
						<td><label for="away-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpa" name="game_player_xpa[]" /></td>
						<td><label for="away-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpm" name="game_player_xpm[]" /></td>
						<td><label for="away-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-touchbacks" name="game_player_touchbacks[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-5-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpa" name="game_player_xpa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpm" name="game_player_xpm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-touchbacks" name="game_player_touchbacks[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-5" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></h3>
			<table id="away-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-6-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="away-player-returns" name="game_player_returns[]" /></td>
						<td><label for="away-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-yards" name="game_player_return_yards[]" /></td>
						<td><label for="away-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-td" name="game_player_return_tds[]" /></td>
						<td><label for="away-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-fum" name="game_player_return_fumbles[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-6-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="away-player-returns" name="game_player_returns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-yards" name="game_player_return_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-td" name="game_player_return_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-fum" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-6" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
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
			<h3><?php esc_html_e( 'Passing', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Completions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'INTs', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-comp" name="game_player_completions[]" /></td>
						<td><label for="home-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-attempts" name="game_player_attempts[]" /></td>
						<td><label for="home-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-yards" name="game_player_pass_yards[]" /></td>
						<td><label for="home-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-td" name="game_player_pass_tds[]" /></td>
						<td><label for="home-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-int" name="game_player_pass_ints[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-comp" name="game_player_completions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-attempts" name="game_player_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-yards" name="game_player_pass_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-td" name="game_player_pass_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-int" name="game_player_pass_ints[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Rushing', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Rushes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-2-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush" name="game_player_rushes[]" /></td>
						<td><label for="home-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-yards" name="game_player_rush_yards[]" /></td>
						<td><label for="home-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-td" name="game_player_rush_tds[]" /></td>
						<td><label for="home-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-fum" name="game_player_rush_fumbles[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush" name="game_player_rushes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-yards" name="game_player_rush_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-td" name="game_player_rush_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-fum" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Receiving', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Catches', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-3-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-catches" name="game_player_catches[]" /></td>
						<td><label for="home-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-yards" name="game_player_receiving_yards[]" /></td>
						<td><label for="home-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-td" name="game_player_receiving_tds[]" /></td>
						<td><label for="home-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-fum" name="game_player_receiving_fumbles[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-3-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-catches" name="game_player_catches[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-yards" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-td" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-fum" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-3" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Defense', 'sports-bench' ); ?></h3>
			<table id="home-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles for Loss', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pass Break Ups', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Interceptions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdown Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Forced Fumbles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles Recovered', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kick Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Return Yards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-4-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="home-player-tackles" name="game_player_tackles[]" /></td>
						<td><label for="home-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="home-player-tfl" name="game_player_tfl[]" /></td>
						<td><label for="home-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-sacks" name="game_player_sacks[]" /></td>
						<td><label for="home-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="home-player-pbu" name="game_player_pbu[]" /></td>
						<td><label for="home-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-ints" name="game_player_ints[]" /></td>
						<td><label for="home-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-tds" name="game_player_tds[]" /></td>
						<td><label for="home-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-ff" name="game_player_ff[]" /></td>
						<td><label for="home-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fr" name="game_player_fr[]" /></td>
						<td><label for="home-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-rkick-blocks" name="game_player_blocked[]" /></td>
						<td><label for="home-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-yards" name="game_player_yards[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-4-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="home-player-tackles" name="game_player_tackles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="home-player-tfl" name="game_player_tfl[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-sacks" name="game_player_sacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="home-player-pbu" name="game_player_pbu[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-ints" name="game_player_ints[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-tds" name="game_player_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-ff" name="game_player_ff[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fr" name="game_player_fr[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-rkick-blocks" name="game_player_blocked[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-yards" name="game_player_yards[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-4" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kicking', 'sports-bench' ); ?></h3>
			<table id="home-kicking-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Passing', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchbacks', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-5-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" /></td>
						<td><label for="home-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpa" name="game_player_xpa[]" /></td>
						<td><label for="home-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpm" name="game_player_xpm[]" /></td>
						<td><label for="home-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-touchbacks" name="game_player_touchbacks[]" /></td>
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_returns[]" />
						<input type="hidden" name="game_player_return_yards[]" />
						<input type="hidden" name="game_player_return_tds[]" />
						<input type="hidden" name="game_player_return_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-5-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpa" name="game_player_xpa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpm" name="game_player_xpm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-touchbacks" name="game_player_touchbacks[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-5" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></h3>
			<table id="home-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-6-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="home-player-returns" name="game_player_returns[]" /></td>
						<td><label for="home-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-yards" name="game_player_return_yards[]" /></td>
						<td><label for="home-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-td" name="game_player_return_tds[]" /></td>
						<td><label for="home-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-fum" name="game_player_return_fumbles[]" /></td>
						<input type="hidden" name="game_player_completions[]" />
						<input type="hidden" name="game_player_attempts[]" />
						<input type="hidden" name="game_player_pass_yards[]" />
						<input type="hidden" name="game_player_pass_tds[]" />
						<input type="hidden" name="game_player_pass_ints[]" />
						<input type="hidden" name="game_player_catches[]" />
						<input type="hidden" name="game_player_receiving_yards[]" />
						<input type="hidden" name="game_player_receiving_tds[]" />
						<input type="hidden" name="game_player_receiving_fumbles[]" />
						<input type="hidden" name="game_player_tackles[]" />
						<input type="hidden" name="game_player_tfl[]" />
						<input type="hidden" name="game_player_sacks[]" />
						<input type="hidden" name="game_player_pbu[]" />
						<input type="hidden" name="game_player_ints[]" />
						<input type="hidden" name="game_player_tds[]" />
						<input type="hidden" name="game_player_ff[]" />
						<input type="hidden" name="game_player_fr[]" />
						<input type="hidden" name="game_player_blocked[]" />
						<input type="hidden" name="game_player_yards[]" />
						<input type="hidden" name="game_player_fga[]" />
						<input type="hidden" name="game_player_fgm[]" />
						<input type="hidden" name="game_player_xpa[]" />
						<input type="hidden" name="game_player_xpm[]" />
						<input type="hidden" name="game_player_touchbacks[]" />
						<input type="hidden" name="game_player_rushes[]" />
						<input type="hidden" name="game_player_rush_yards[]" />
						<input type="hidden" name="game_player_rush_tds[]" />
						<input type="hidden" name="game_player_rush_fumbles[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-6-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="home-player-returns" name="game_player_returns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-yards" name="game_player_return_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-td" name="game_player_return_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-fum" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-6" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
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
			'game_home_first_quarter'       => 0,
			'game_home_second_quarter'      => 0,
			'game_home_third_quarter'       => 0,
			'game_home_fourth_quarter'      => 0,
			'game_home_overtime'            => '',
			'game_away_first_quarter'       => 0,
			'game_away_second_quarter'      => 0,
			'game_away_third_quarter'       => 0,
			'game_away_fourth_quarter'      => 0,
			'game_away_overtime'            => '',
			'game_home_total'               => 0,
			'game_home_pass'                => 0,
			'game_home_rush'                => 0,
			'game_home_to'                  => 0,
			'game_home_ints'                => 0,
			'game_home_fumbles'             => 0,
			'game_home_fumbles_lost'        => 0,
			'game_home_possession'          => '',
			'game_home_kick_returns'        => 0,
			'game_home_kick_return_yards'   => 0,
			'game_home_penalties'           => 0,
			'game_home_penalty_yards'       => 0,
			'game_home_first_downs'         => 0,
			'game_away_total'               => 0,
			'game_away_pass'                => 0,
			'game_away_rush'                => 0,
			'game_away_to'                  => 0,
			'game_away_ints'                => 0,
			'game_away_fumbles'             => 0,
			'game_away_fumbles_lost'        => 0,
			'game_away_possession'          => '',
			'game_away_kick_returns'        => 0,
			'game_away_kick_return_yards'   => 0,
			'game_away_penalties'           => 0,
			'game_away_penalty_yards'       => 0,
			'game_away_first_downs'         => 0,
			'game_info_id'                  => array(),
			'game_info_quarter'             => array(),
			'game_info_time'                => array(),
			'game_info_scoring_team_id'     => array(),
			'game_info_home_score'          => array(),
			'game_info_away_score'          => array(),
			'game_info_play'                => array(),
			'game_stats_player_id'          => array(),
			'game_team_id'                  => array(),
			'game_player_id'                => array(),
			'game_stats_section'            => array(),
			'game_player_completions'       => array(),
			'game_player_attempts'          => array(),
			'game_player_pass_yards'        => array(),
			'game_player_pass_tds'          => array(),
			'game_player_pass_ints'         => array(),
			'game_player_rushes'            => array(),
			'game_player_rush_yards'        => array(),
			'game_player_rush_tds'          => array(),
			'game_player_rush_fumbles'      => array(),
			'game_player_catches'           => array(),
			'game_player_receiving_yards'   => array(),
			'game_player_receiving_tds'     => array(),
			'game_player_receiving_fumbles' => array(),
			'game_player_tackles'           => array(),
			'game_player_tfl'               => array(),
			'game_player_sacks'             => array(),
			'game_player_pbu'               => array(),
			'game_player_ints'              => array(),
			'game_player_yards'             => array(),
			'game_player_tds'               => array(),
			'game_player_ff'                => array(),
			'game_player_fr'                => array(),
			'game_player_blocked'           => array(),
			'game_player_fgm'               => array(),
			'game_player_fga'               => array(),
			'game_player_xpm'               => array(),
			'game_player_xpa'               => array(),
			'game_player_touchbacks'        => array(),
			'game_player_returns'           => array(),
			'game_player_return_yards'      => array(),
			'game_player_return_tds'        => array(),
			'game_player_return_fumbles'    => array(),
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
				'game_id'                     => intval( $game['game_id'] ),
				'game_week'                   => intval( $game['game_week'] ),
				'game_day'                    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_day'] ) ),
				'game_season'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_season'] ) ),
				'game_home_id'                => intval( $game['game_home_id'] ),
				'game_away_id'                => intval( $game['game_away_id'] ),
				'game_home_final'             => intval( $game['game_home_final'] ),
				'game_away_final'             => intval( $game['game_away_final'] ),
				'game_attendance'             => intval( $game['game_attendance'] ),
				'game_status'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_status'] ) ),
				'game_current_period'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_period'] ) ),
				'game_current_time'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_time'] ) ),
				'game_current_home_score'     => intval( $game['game_current_home_score'] ),
				'game_current_away_score'     => intval( $game['game_current_away_score'] ),
				'game_neutral_site'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_neutral_site'] ) ),
				'game_location_stadium'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_stadium'] ) ),
				'game_location_line_one'      => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_one'] ) ),
				'game_location_line_two'      => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_two'] ) ),
				'game_location_city'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_city'] ) ),
				'game_location_state'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_state'] ) ),
				'game_location_country'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_country'] ) ),
				'game_location_zip_code'      => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_zip_code'] ) ),
				'game_home_first_quarter'     => intval( $game['game_home_first_quarter'] ),
				'game_home_second_quarter'    => intval( $game['game_home_second_quarter'] ),
				'game_home_third_quarter'     => intval( $game['game_home_third_quarter'] ),
				'game_home_fourth_quarter'    => intval( $game['game_home_fourth_quarter'] ),
				'game_home_overtime'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_overtime'] ) ),
				'game_away_first_quarter'     => intval( $game['game_away_first_quarter'] ),
				'game_away_second_quarter'    => intval( $game['game_away_second_quarter'] ),
				'game_away_third_quarter'     => intval( $game['game_away_third_quarter'] ),
				'game_away_fourth_quarter'    => intval( $game['game_away_fourth_quarter'] ),
				'game_away_overtime'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_overtime'] ) ),
				'game_home_total'             => $game['game_home_total'],
				'game_home_pass'              => $game['game_home_pass'],
				'game_home_rush'              => $game['game_home_rush'],
				'game_home_to'                => $game['game_home_to'],
				'game_home_ints'              => $game['game_home_ints'],
				'game_home_fumbles'           => $game['game_home_fumbles'],
				'game_home_fumbles_lost'      => $game['game_home_fumbles_lost'],
				'game_home_possession'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_possession'] ) ),
				'game_home_kick_returns'      => intval( $game['game_home_kick_returns'] ),
				'game_home_kick_return_yards' => intval( $game['game_home_kick_return_yards'] ),
				'game_home_penalties'         => intval( $game['game_home_penalties'] ),
				'game_home_penalty_yards'     => intval( $game['game_home_penalty_yards'] ),
				'game_home_first_downs'       => intval( $game['game_home_first_downs'] ),
				'game_away_total'             => intval( $game['game_away_total'] ),
				'game_away_pass'              => intval( $game['game_away_pass'] ),
				'game_away_rush'              => intval( $game['game_away_rush'] ),
				'game_away_to'                => intval( $game['game_away_to'] ),
				'game_away_ints'              => intval( $game['game_away_ints'] ),
				'game_away_fumbles'           => intval( $game['game_away_fumbles'] ),
				'game_away_fumbles_lost'      => intval( $game['game_away_fumbles_lost'] ),
				'game_away_possession'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_possession'] ) ),
				'game_away_kick_returns'      => intval( $game['game_away_kick_returns'] ),
				'game_away_kick_return_yards' => intval( $game['game_away_kick_return_yards'] ),
				'game_away_penalties'         => intval( $game['game_away_penalties'] ),
				'game_away_penalty_yards'     => intval( $game['game_away_penalty_yards'] ),
				'game_away_first_downs'       => intval( $game['game_away_first_downs'] ),
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

		//* Pull the game events out of the $games array
		$game_info_ids = $game['game_info_id'];
		unset( $game['game_info_id'] );

		$game_info_quarters = $game['game_info_quarter'];
		unset( $game['game_info_quarter'] );

		$game_info_times = $game['game_info_time'];
		unset( $game['game_info_time'] );

		$game_info_home_scores = $game['game_info_home_score'];;
		unset( $game['game_info_home_score'] );

		$game_info_away_scores = $game['game_info_away_score'];
		unset( $game['game_info_away_score'] );

		$game_info_scoring_team_ids = $game['game_info_scoring_team_id'];
		unset( $game['game_info_scoring_team_id'] );

		$game_info_plays = $game['game_info_play'];
		unset( $game['game_info_play'] );

		if ( $game_info_quarters ) {
			$len = count( $game_info_quarters );
		} else {
			$len = 0;
		}

		$events = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_info_ids[ $i ] ) ) {
				$gi_id = $game_info_ids[ $i ];
			} else {
				$gi_id = '';
			}
			if ( isset( $game_info_plays[ $i ] ) ) {
				$event = array(
					'game_info_id'              => intval( $gi_id ),
					'game_id'                   => intval( $game['game_id'] ),
					'game_info_quarter'         => wp_filter_nohtml_kses( sanitize_text_field( $game_info_quarters[ $i ] ) ),
					'game_info_time'            => wp_filter_nohtml_kses( sanitize_text_field( $game_info_times[ $i ] ) ),
					'game_info_home_score'      => intval( $game_info_home_scores[ $i ] ),
					'game_info_away_score'      => intval( $game_info_away_scores[ $i ] ),
					'game_info_scoring_team_id' => intval( $game_info_scoring_team_ids[ $i ] ),
					'game_info_play'            => wp_filter_nohtml_kses( sanitize_text_field( $game_info_plays[ $i ] ) )
				);
				array_push( $events, $event );
			}
		}

		//* Get the game events already in the database to compare the new ones to
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$game_id         = intval( $_REQUEST['game_id'] );
		$quer            = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_events     = $wpdb->get_results( $quer );
		$info_ids        = [];
		foreach ( $game_events as $event ) {
			array_push( $info_ids, $event->game_info_id );
		}

		//* Go through the array of new events and compare them to the ones already in the database
		foreach ( $events as $event ) {
			if ( in_array( $event['game_info_id'], $info_ids ) ) {
				//* If the event id is already in the database, update it
				$wpdb->update( $wpdb->prefix . 'sb_game_info', $event, array( 'game_info_id' => $event['game_info_id'] ) );
			} else {
				//* If the event is new, add it to the database
				$wpdb->insert( $game_info_table, $event );
				$event['game_info_id'] = $wpdb->insert_id;
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

		if ( $game['game_home_overtime'] == '' ) {
			$game['game_home_overtime'] = null;
		}

		if ( $game['game_away_overtime'] == '' ) {
			$game['game_away_overtime'] = null;
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

		$game_stats_player_ids = $game['game_stats_player_id'];
		unset( $game['game_stats_player_id'] );

		$game_stats_section = $game['game_stats_section'];
		unset( $game['game_stats_section'] );

		$team_ids = $game['game_team_id'];
		unset( $game['game_team_id'] );

		$player_ids = $game['game_player_id'];
		unset( $game['game_player_id'] );

		$game_player_completions = $game['game_player_completions'];
		unset( $game['game_player_completions'] );

		$game_player_attempts = $game['game_player_attempts'];
		unset( $game['game_player_attempts'] );

		$game_player_pass_yards = $game['game_player_pass_yards'];
		unset( $game['game_player_pass_yards'] );

		$game_player_pass_tds = $game['game_player_pass_tds'];
		unset( $game['game_player_pass_tds'] );

		$game_player_pass_ints = $game['game_player_pass_ints'];
		unset( $game['game_player_pass_ints'] );

		$game_player_rushes = $game['game_player_rushes'];
		unset( $game['game_player_rushes'] );

		$game_player_rush_yards = $game['game_player_rush_yards'];
		unset( $game['game_player_rush_yards'] );

		$game_player_rush_tds = $game['game_player_rush_tds'];
		unset( $game['game_player_rush_tds'] );

		$game_player_rush_fumbles = $game['game_player_rush_fumbles'];
		unset( $game['game_player_rush_fumbles'] );

		$game_player_catches = $game['game_player_catches'];
		unset( $game['game_player_catches'] );

		$game_player_receiving_yards = $game['game_player_receiving_yards'];
		unset( $game['game_player_receiving_yards'] );

		$game_player_receiving_tds = $game['game_player_receiving_tds'];
		unset( $game['game_player_receiving_tds'] );

		$game_player_receiving_fumbles = $game['game_player_receiving_fumbles'];
		unset( $game['game_player_receiving_fumbles'] );

		$game_player_tackles = $game['game_player_tackles'];
		unset( $game['game_player_tackles'] );

		$game_player_tfl = $game['game_player_tfl'];
		unset( $game['game_player_tfl'] );

		$game_player_sacks = $game['game_player_sacks'];
		unset( $game['game_player_sacks'] );

		$game_player_pbu = $game['game_player_pbu'];
		unset( $game['game_player_pbu'] );

		$game_player_ints = $game['game_player_ints'];
		unset( $game['game_player_ints'] );

		$game_player_tds = $game['game_player_tds'];
		unset( $game['game_player_tds'] );

		$game_player_ff = $game['game_player_ff'];
		unset( $game['game_player_ff'] );

		$game_player_fr = $game['game_player_fr'];
		unset( $game['game_player_fr'] );

		$game_player_blocked = $game['game_player_blocked'];
		unset( $game['game_player_blocked'] );

		$game_player_yards = $game['game_player_yards'];
		unset( $game['game_player_yards'] );

		$game_player_fga = $game['game_player_fga'];
		unset( $game['game_player_fga'] );

		$game_player_fgm = $game['game_player_fgm'];
		unset( $game['game_player_fgm'] );

		$game_player_xpa = $game['game_player_xpa'];
		unset( $game['game_player_xpa'] );

		$game_player_xpm = $game['game_player_xpm'];
		unset( $game['game_player_xpm'] );

		$game_player_touchbacks = $game['game_player_touchbacks'];
		unset( $game['game_player_touchbacks'] );

		$game_player_returns = $game['game_player_returns'];
		unset( $game['game_player_returns'] );

		$game_player_return_yards = $game['game_player_return_yards'];
		unset( $game['game_player_return_yards'] );

		$game_player_return_tds = $game['game_player_return_tds'];
		unset( $game['game_player_return_tds'] );

		$game_player_return_fumbles = $game['game_player_return_fumbles'];
		unset( $game['game_player_return_fumbles'] );

		//* Loop through each of the player stats and add it to the array of stats to be added or updated
		$len = count( $player_ids );
		$stats = [];
		$ids = [];
		for ( $i = 0; $i < $len; $i++ ) {

			if ( isset( $game_stats_player_ids[$i] ) ) {
				$gs_id = $game_stats_player_ids[$i];
			} else {
				$gs_id = '';
			}
			//* Check to see if the player already has stats in the array
			if ( isset( $player_ids[ $i ] ) && in_array( $player_ids[ $i ], $ids ) ) {
				//* If the player has stats in the array and we're adding the passing stats, add the passing stats, but keep the other stats
				$j = array_search( $player_ids[ $i ], $ids );
				if ( $game_stats_section[ $i ] === 'pass' ) {
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $game_player_completions[ $i ] ),
						'game_player_attempts'           => intval( $game_player_attempts[ $i ] ),
						'game_player_pass_yards'         => intval( $game_player_pass_yards[ $i ] ),
						'game_player_pass_tds'           => intval( $game_player_pass_tds[ $i ] ),
						'game_player_pass_ints'          => intval( $game_player_pass_ints[ $i ] ),
						'game_player_rushes'             => intval( $stats[ $j ]['game_player_rushes'] ),
						'game_player_rush_yards'         => intval( $stats[ $j ]['game_player_rush_yards'] ),
						'game_player_rush_tds'           => intval( $stats[ $j ]['game_player_rush_tds'] ),
						'game_player_rush_fumbles'       => intval( $stats[ $j ]['game_player_rush_fumbles'] ),
						'game_player_catches'            => intval( $stats[ $j ]['game_player_catches'] ),
						'game_player_receiving_yards'    => intval( $stats[ $j ]['game_player_receiving_yards'] ),
						'game_player_receiving_tds'      => intval( $stats[ $j ]['game_player_receiving_tds'] ),
						'game_player_receiving_fumbles'  => intval( $stats[ $j ]['game_player_receiving_fumbles'] ),
						'game_player_tackles'            => floatval( $stats[ $j ]['game_player_tackles'] ),
						'game_player_tfl'                => floatval( $stats[ $j ]['game_player_tfl'] ),
						'game_player_sacks'              => floatval( $stats[ $j ]['game_player_sacks'] ),
						'game_player_pbu'                => intval( $stats[ $j ]['game_player_pbu'] ),
						'game_player_ints'               => intval( $stats[ $j ]['game_player_ints'] ),
						'game_player_tds'                => intval( $stats[ $j ]['game_player_tds'] ),
						'game_player_ff'                 => intval( $stats[ $j ]['game_player_ff'] ),
						'game_player_fr'                 => intval( $stats[ $j ]['game_player_fr'] ),
						'game_player_blocked'            => intval( $stats[ $j ]['game_player_blocked'] ),
						'game_player_yards'              => intval( $stats[ $j ]['game_player_yards'] ),
						'game_player_fga'                => intval( $stats[ $j ]['game_player_fga'] ),
						'game_player_fgm'                => intval( $stats[ $j ]['game_player_fgm'] ),
						'game_player_xpa'                => intval( $stats[ $j ]['game_player_xpa'] ),
						'game_player_xpm'                => intval( $stats[ $j ]['game_player_xpm'] ),
						'game_player_touchbacks'         => intval( $stats[ $j ]['game_player_touchbacks'] ),
						'game_player_returns'            => intval( $stats[ $j ]['game_player_returns'] ),
						'game_player_return_yards'       => intval( $stats[ $j ]['game_player_return_yards'] ),
						'game_player_return_tds'         => intval( $stats[ $j ]['game_player_return_tds'] ),
						'game_player_return_fumbles'     => intval( $stats[ $j ]['game_player_return_fumbles'] ),
					);
				} elseif ( $game_stats_section[ $i ] == 'rush' ) {
					//* If the player has stats in the array and we're adding the rushing stats, add the rushing stats, but keep the other stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $stats[ $j ]['game_player_completions'] ),
						'game_player_attempts'           => intval( $stats[ $j ]['game_player_attempts'] ),
						'game_player_pass_yards'         => intval( $stats[ $j ]['game_player_pass_yards'] ),
						'game_player_pass_tds'           => intval( $stats[ $j ]['game_player_pass_tds'] ),
						'game_player_pass_ints'          => intval( $stats[ $j ]['game_player_pass_ints'] ),
						'game_player_rushes'             => intval( $game_player_rushes[ $i ] ),
						'game_player_rush_yards'         => intval( $game_player_rush_yards[ $i ] ),
						'game_player_rush_tds'           => intval( $game_player_rush_tds[ $i ] ),
						'game_player_rush_fumbles'       => intval( $game_player_rush_fumbles[ $i ] ),
						'game_player_catches'            => intval( $stats[ $j ]['game_player_catches'] ),
						'game_player_receiving_yards'    => intval( $stats[ $j ]['game_player_receiving_yards'] ),
						'game_player_receiving_tds'      => intval( $stats[ $j ]['game_player_receiving_tds'] ),
						'game_player_receiving_fumbles'  => intval( $stats[ $j ]['game_player_receiving_fumbles'] ),
						'game_player_tackles'            => floatval( $stats[ $j ]['game_player_tackles'] ),
						'game_player_tfl'                => floatval( $stats[ $j ]['game_player_tfl'] ),
						'game_player_sacks'              => floatval( $stats[ $j ]['game_player_sacks '] ),
						'game_player_pbu'                => intval( $stats[ $j ]['game_player_pbu'] ),
						'game_player_ints'               => intval( $stats[ $j ]['game_player_ints'] ),
						'game_player_tds'                => intval( $stats[ $j ]['game_player_tds'] ),
						'game_player_ff'                 => intval( $stats[ $j ]['game_player_ff'] ),
						'game_player_fr'                 => intval( $stats[ $j ]['game_player_fr'] ),
						'game_player_blocked'            => intval( $stats[ $j ]['game_player_blocked'] ),
						'game_player_yards'              => intval( $stats[ $j ]['game_player_yards'] ),
						'game_player_fga'                => intval( $stats[ $j ]['game_player_fga'] ),
						'game_player_fgm'                => intval( $stats[ $j ]['game_player_fgm'] ),
						'game_player_xpa'                => intval( $stats[ $j ]['game_player_xpa'] ),
						'game_player_xpm'                => intval( $stats[ $j ]['game_player_xpm'] ),
						'game_player_touchbacks'         => intval( $stats[ $j ]['game_player_touchbacks'] ),
						'game_player_returns'            => intval( $stats[ $j ]['game_player_returns'] ),
						'game_player_return_yards'       => intval( $stats[ $j ]['game_player_return_yards'] ),
						'game_player_return_tds'         => intval( $stats[ $j ]['game_player_return_tds'] ),
						'game_player_return_fumbles'     => intval( $stats[ $j ]['game_player_return_fumbles'] ),
					);
				}
				elseif ( $game_stats_section[ $i ] == 'receive' ) {
					//* If the player has stats in the array and we're adding the receiving stats, add the receiving stats, but keep the other stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ] ['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $stats[ $j ]['game_player_completions'] ),
						'game_player_attempts'           => intval( $stats[ $j ]['game_player_attempts'] ),
						'game_player_pass_yards'         => intval( $stats[ $j ]['game_player_pass_yards'] ),
						'game_player_pass_tds'           => intval( $stats[ $j ]['game_player_pass_tds'] ),
						'game_player_pass_ints'          => intval( $stats[ $j ]['game_player_pass_ints'] ),
						'game_player_rushes'             => intval( $stats[ $j ]['game_player_rushes'] ),
						'game_player_rush_yards'         => intval( $stats[ $j ]['game_player_rush_yards'] ),
						'game_player_rush_tds'           => intval( $stats[ $j ]['game_player_rush_tds'] ),
						'game_player_rush_fumbles'       => intval( $stats[ $j ]['game_player_rush_fumbles'] ),
						'game_player_catches'            => intval( $game_player_catches[ $i ] ),
						'game_player_receiving_yards'    => intval( $game_player_receiving_yards[ $i ] ),
						'game_player_receiving_tds'      => intval( $game_player_receiving_tds[ $i ] ),
						'game_player_receiving_fumbles'  => intval( $game_player_receiving_fumbles[ $i ] ),
						'game_player_tackles'            => floatval( $stats[ $j ]['game_player_tackles'] ),
						'game_player_tfl'                => floatval( $stats[ $j ]['game_player_tfl'] ),
						'game_player_sacks'              => floatval( $stats[ $j ]['game_player_sacks'] ),
						'game_player_pbu'                => intval( $stats[ $j ]['game_player_pbu'] ),
						'game_player_ints'               => intval( $stats[ $j ]['game_player_ints'] ),
						'game_player_tds'                => intval( $stats[ $j ]['game_player_tds'] ),
						'game_player_ff'                 => intval( $stats[ $j ]['game_player_ff'] ),
						'game_player_fr'                 => intval( $stats[ $j ]['game_player_fr'] ),
						'game_player_blocked'            => intval( $stats[ $j ]['game_player_blocked'] ),
						'game_player_yards'              => intval( $stats[ $j ]['game_player_yards'] ),
						'game_player_fga'                => intval( $stats[ $j ]['game_player_fga'] ),
						'game_player_fgm'                => intval( $stats[ $j ]['game_player_fgm'] ),
						'game_player_xpa'                => intval( $stats[ $j ]['game_player_xpa'] ),
						'game_player_xpm'                => intval( $stats[ $j ]['game_player_xpm'] ),
						'game_player_touchbacks'         => intval( $stats[ $j ]['game_player_touchbacks'] ),
						'game_player_returns'            => intval( $stats[ $j ]['game_player_returns'] ),
						'game_player_return_yards'       => intval( $stats[ $j ]['game_player_return_yards'] ),
						'game_player_return_tds'         => intval( $stats[ $j ]['game_player_return_tds'] ),
						'game_player_return_fumbles'     => intval( $stats[ $j ]['game_player_return_fumbles'] ),
					);
				} elseif ( $game_stats_section[ $i ] == 'defend' ) {
					//* If the player has stats in the array and we're adding the defensive stats, add the defensive stats, but keep the other stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $stats[ $j ]['game_player_completions'] ),
						'game_player_attempts'           => intval( $stats[ $j ]['game_player_attempts'] ),
						'game_player_pass_yards'         => intval( $stats[ $j ]['game_player_pass_yards'] ),
						'game_player_pass_tds'           => intval( $stats[ $j ]['game_player_pass_tds'] ),
						'game_player_pass_ints'          => intval( $stats[ $j ]['game_player_pass_ints'] ),
						'game_player_rushes'             => intval( $stats[ $j ]['game_player_rushes'] ),
						'game_player_rush_yards'         => intval( $stats[ $j ]['game_player_rush_yards'] ),
						'game_player_rush_tds'           => intval( $stats[ $j ]['game_player_rush_tds'] ),
						'game_player_rush_fumbles'       => intval( $stats[ $j ]['game_player_rush_fumbles'] ),
						'game_player_catches'            => intval( $stats[ $j ]['game_player_catches'] ),
						'game_player_receiving_yards'    => intval( $stats[ $j ]['game_player_receiving_yards'] ),
						'game_player_receiving_tds'      => intval( $stats[ $j ]['game_player_receiving_tds'] ),
						'game_player_receiving_fumbles'  => intval( $stats[ $j ]['game_player_receiving_fumbles'] ),
						'game_player_tackles'            => floatval( $game_player_tackles[ $i ] ),
						'game_player_tfl'                => floatval( $game_player_tfl[ $i ] ),
						'game_player_sacks'              => floatval( $game_player_sacks[ $i ] ),
						'game_player_pbu'                => intval( $game_player_pbu[ $i ] ),
						'game_player_ints'               => intval( $game_player_ints[ $i ] ),
						'game_player_tds'                => intval( $game_player_tds[ $i ] ),
						'game_player_ff'                 => intval( $game_player_ff[ $i ] ),
						'game_player_fr'                 => intval( $game_player_fr[ $i ] ),
						'game_player_blocked'            => intval( $game_player_blocked[ $i ] ),
						'game_player_yards'              => intval( $game_player_yards[ $i ] ),
						'game_player_fga'                => intval( $stats[ $j ]['game_player_fga'] ),
						'game_player_fgm'                => intval( $stats[ $j ]['game_player_fgm'] ),
						'game_player_xpa'                => intval( $stats[ $j ]['game_player_xpa'] ),
						'game_player_xpm'                => intval( $stats[ $j ]['game_player_xpm'] ),
						'game_player_touchbacks'         => intval( $stats[ $j ]['game_player_touchbacks'] ),
						'game_player_returns'            => intval( $stats[ $j ]['game_player_returns'] ),
						'game_player_return_yards'       => intval( $stats[ $j ]['game_player_return_yards'] ),
						'game_player_return_tds'         => intval( $stats[ $j ]['game_player_return_tds'] ),
						'game_player_return_fumbles'     => intval( $stats[ $j ]['game_player_return_fumbles'] ),
					);
				}
				elseif ( $game_stats_section[ $i ] == 'kick' ) {
					//* If the player has stats in the array and we're adding the kicking stats, add the kicking stats, but keep the other stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $stats[ $j ]['game_player_completions'] ),
						'game_player_attempts'           => intval( $stats[ $j ]['game_player_attempts'] ),
						'game_player_pass_yards'         => intval( $stats[ $j ]['game_player_pass_yards'] ),
						'game_player_pass_tds'           => intval( $stats[ $j ]['game_player_pass_tds'] ),
						'game_player_pass_ints'          => intval( $stats[ $j ]['game_player_pass_ints'] ),
						'game_player_rushes'             => intval( $stats[ $j ]['game_player_rushes'] ),
						'game_player_rush_yards'         => intval( $stats[ $j ]['game_player_rush_yards'] ),
						'game_player_rush_tds'           => intval( $stats[ $j ]['game_player_rush_tds'] ),
						'game_player_rush_fumbles'       => intval( $stats[ $j ]['game_player_rush_fumbles'] ),
						'game_player_catches'            => intval( $stats[ $j ]['game_player_catches'] ),
						'game_player_receiving_yards'    => intval( $stats[ $j ]['game_player_receiving_yards'] ),
						'game_player_receiving_tds'      => intval( $stats[ $j ]['game_player_receiving_tds'] ),
						'game_player_receiving_fumbles'  => intval( $stats[ $j ]['game_player_receiving_fumbles'] ),
						'game_player_tackles'            => floatval( $stats[ $j ]['game_player_tackles'] ),
						'game_player_tfl'                => floatval( $stats[ $j ]['game_player_tfl'] ),
						'game_player_sacks'              => floatval( $stats[ $j ]['game_player_sacks'] ),
						'game_player_pbu'                => intval( $stats[ $j ]['game_player_pbu'] ),
						'game_player_ints'               => intval( $stats[ $j ]['game_player_ints'] ),
						'game_player_tds'                => intval( $stats[ $j ]['game_player_tds'] ),
						'game_player_ff'                 => intval( $stats[ $j ]['game_player_ff'] ),
						'game_player_fr'                 => intval( $stats[ $j ]['game_player_fr'] ),
						'game_player_blocked'            => intval( $stats[ $j ]['game_player_blocked'] ),
						'game_player_yards'              => intval( $stats[ $j ]['game_player_yards'] ),
						'game_player_fga'                => intval( $game_player_fga[ $i ] ),
						'game_player_fgm'                => intval( $game_player_fgm[ $i ] ),
						'game_player_xpa'                => intval( $game_player_xpa[ $i ] ),
						'game_player_xpm'                => intval( $game_player_xpm[ $i ] ),
						'game_player_touchbacks'         => intval( $game_player_touchbacks[ $i ] ),
						'game_player_returns'            => intval( $stats[ $j ]['game_player_returns'] ),
						'game_player_return_yards'       => intval( $stats[ $j ]['game_player_return_yards'] ),
						'game_player_return_tds'         => intval( $stats[ $j ]['game_player_return_tds'] ),
						'game_player_return_fumbles'     => intval( $stats[ $j ]['game_player_return_fumbles'] ),
					);
				}
				else {
					//* If the player has stats in the array and we're adding the return stats, add the return stats, but keep the other stats
					$stats[ $j ] = array(
						'game_stats_player_id'           => intval( $stats[ $j ]['game_stats_player_id'] ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $stats[ $j ]['game_team_id'] ),
						'game_player_id'                 => intval( $stats[ $j ]['game_player_id'] ),
						'game_player_completions'        => intval( $stats[ $j ]['game_player_completions'] ),
						'game_player_attempts'           => intval( $stats[ $j ]['game_player_attempts'] ),
						'game_player_pass_yards'         => intval( $stats[ $j ]['game_player_pass_yards'] ),
						'game_player_pass_tds'           => intval( $stats[ $j ]['game_player_pass_tds'] ),
						'game_player_pass_ints'          => intval( $stats[ $j ]['game_player_pass_ints'] ),
						'game_player_rushes'             => intval( $stats[ $j ]['game_player_rushes'] ),
						'game_player_rush_yards'         => intval( $stats[ $j ]['game_player_rush_yards'] ),
						'game_player_rush_tds'           => intval( $stats[ $j ]['game_player_rush_tds'] ),
						'game_player_rush_fumbles'       => intval( $stats[ $j ]['game_player_rush_fumbles'] ),
						'game_player_catches'            => intval( $stats[ $j ]['game_player_catches'] ),
						'game_player_receiving_yards'    => intval( $stats[ $j ]['game_player_receiving_yards'] ),
						'game_player_receiving_tds'      => intval( $stats[ $j ]['game_player_receiving_tds'] ),
						'game_player_receiving_fumbles'  => intval( $stats[ $j ]['game_player_receiving_fumbles'] ),
						'game_player_tackles'            => floatval( $stats[ $j ]['game_player_tackles'] ),
						'game_player_tfl'                => floatval( $stats[ $j ]['game_player_tfl'] ),
						'game_player_sacks'              => floatval( $stats[ $j ]['game_player_sacks'] ),
						'game_player_pbu'                => intval( $stats[ $j ]['game_player_pbu'] ),
						'game_player_ints'               => intval( $stats[ $j ]['game_player_ints'] ),
						'game_player_tds'                => intval( $stats[ $j ]['game_player_tds'] ),
						'game_player_ff'                 => intval( $stats[ $j ]['game_player_ff'] ),
						'game_player_fr'                 => intval( $stats[ $j ]['game_player_fr'] ),
						'game_player_blocked'            => intval( $stats[ $j ]['game_player_blocked'] ),
						'game_player_yards'              => intval( $stats[ $j ]['game_player_yards'] ),
						'game_player_fga'                => intval( $stats[ $j ]['game_player_fga'] ),
						'game_player_fgm'                => intval( $stats[ $j ]['game_player_fgm'] ),
						'game_player_xpa'                => intval( $stats[ $j ]['game_player_xpa'] ),
						'game_player_xpm'                => intval( $stats[ $j ]['game_player_xpm'] ),
						'game_player_touchbacks'         => intval( $stats[ $j ]['game_player_touchbacks'] ),
						'game_player_returns'            => intval( $game_player_returns[ $i ] ),
						'game_player_return_yards'       => intval( $game_player_return_yards[ $i ] ),
						'game_player_return_tds'         => intval( $game_player_return_tds[ $i ] ),
						'game_player_return_fumbles'     => intval( $game_player_return_fumbles[ $i ] ),
					);
				}
			} else {
				if ( $player_ids[ $i ] > 0 ) {
					$stat = array(
						'game_stats_player_id'           => intval( $gs_id ),
						'game_id'                        => intval( $game['game_id'] ),
						'game_team_id'                   => intval( $team_ids[ $i ] ),
						'game_player_id'                 => intval( $player_ids[ $i ] ),
						'game_player_completions'        => intval( $game_player_completions[ $i ] ),
						'game_player_attempts'           => intval( $game_player_attempts[ $i ] ),
						'game_player_pass_yards'         => intval( $game_player_pass_yards[ $i ] ),
						'game_player_pass_tds'           => intval( $game_player_pass_tds[ $i ] ),
						'game_player_pass_ints'          => intval( $game_player_pass_ints[ $i ] ),
						'game_player_rushes'             => intval( $game_player_rushes[ $i ] ),
						'game_player_rush_yards'         => intval( $game_player_rush_yards[ $i ] ),
						'game_player_rush_tds'           => intval( $game_player_rush_tds[ $i ] ),
						'game_player_rush_fumbles'       => intval( $game_player_rush_fumbles[ $i ] ),
						'game_player_catches'            => intval( $game_player_catches[ $i ] ),
						'game_player_receiving_yards'    => intval( $game_player_receiving_yards[ $i ] ),
						'game_player_receiving_tds'      => intval( $game_player_receiving_tds[ $i ] ),
						'game_player_receiving_fumbles'  => intval( $game_player_receiving_fumbles[ $i ] ),
						'game_player_tackles'            => floatval( $game_player_tackles[ $i ] ),
						'game_player_tfl'                => floatval( $game_player_tfl[ $i ] ),
						'game_player_sacks'              => floatval( $game_player_sacks[ $i ] ),
						'game_player_pbu'                => intval( $game_player_pbu[ $i ] ),
						'game_player_ints'               => intval( $game_player_ints[ $i ] ),
						'game_player_tds'                => intval( $game_player_tds[ $i ] ),
						'game_player_ff'                 => intval( $game_player_ff[ $i ] ),
						'game_player_fr'                 => intval( $game_player_fr[ $i ] ),
						'game_player_blocked'            => intval( $game_player_blocked[ $i ] ),
						'game_player_yards'              => intval( $game_player_yards[ $i ] ),
						'game_player_fga'                => intval( $game_player_fga[ $i ] ),
						'game_player_fgm'                => intval( $game_player_fgm[ $i ] ),
						'game_player_xpa'                => intval( $game_player_xpa[ $i ] ),
						'game_player_xpm'                => intval( $game_player_xpm[ $i ] ),
						'game_player_touchbacks'         => intval( $game_player_touchbacks[ $i ] ),
						'game_player_returns'            => intval( $game_player_returns[ $i ] ),
						'game_player_return_yards'       => intval( $game_player_return_yards[ $i ] ),
						'game_player_return_tds'         => intval( $game_player_return_tds[ $i ] ),
						'game_player_return_fumbles'     => intval( $game_player_return_fumbles[ $i ] ),
					);
					array_push( $stats, $stat );
					array_push( $ids, $player_ids[ $i ] );
				}
			}
		}

		//* Grab the player stats for the game already in the database to compare the new ones to
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_id         = intval( $_REQUEST['game_id'] );
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
			if ( null === $event->game_info_play ) {
				$assists = '';
			} else {
				$assists = $event->game_info_play;
			}
			$event_array = array(
				'game_info_id'              => $event->game_info_id,
				'game_id'                   => $event->game_id,
				'game_info_quarter'         => $event->game_info_quarter,
				'game_info_time'            => $event->game_info_time,
				'game_info_home_score'      => $event->game_info_home_score,
				'game_info_away_score'      => $event->game_info_away_score,
				'game_info_scoring_team_id' => $event->game_info_scoring_team_id,
				'game_info_play'            => $event->game_info_play,
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
					'game_stats_player_id'           => $stat->game_stats_player_id,
					'game_id'                        => $stat->game_id,
					'game_team_id'                   => $stat->game_team_id,
					'game_player_id'                 => $stat->game_player_id,
					'game_player_completions'        => $stat->game_player_completions,
					'game_player_attempts'           => $stat->game_player_attempts,
					'game_player_pass_yards'         => $stat->game_player_pass_yards,
					'game_player_pass_tds'           => $stat->game_player_pass_tds,
					'game_player_pass_ints'          => $stat->game_player_pass_ints,
					'game_player_rushes'             => $stat->game_player_rushes,
					'game_player_rush_yards'         => $stat->game_player_rush_yards,
					'game_player_rush_tds'           => $stat->game_player_rush_tds,
					'game_player_rush_fumbles'       => $stat->game_player_rush_fumbles,
					'game_player_catches'            => $stat->game_player_catches,
					'game_player_receiving_yards'    => $stat->game_player_receiving_yards,
					'game_player_receiving_tds'      => $stat->game_player_receiving_tds,
					'game_player_receiving_fumbles'  => $stat->game_player_receiving_fumbles,
					'game_player_tackles'            => $stat->game_player_tackles,
					'game_player_tfl'                => $stat->game_player_tfl,
					'game_player_sacks'              => $stat->game_player_sacks,
					'game_player_pbu'                => $stat->game_player_pbu,
					'game_player_ints'               => $stat->game_player_ints,
					'game_player_tds'                => $stat->game_player_tds,
					'game_player_ff'                 => $stat->game_player_ff,
					'game_player_fr'                 => $stat->game_player_fr,
					'game_player_blocked'            => $stat->game_player_blocked,
					'game_player_yards'              => $stat->game_player_yards,
					'game_player_fga'                => $stat->game_player_fga,
					'game_player_fgm'                => $stat->game_player_fgm,
					'game_player_xpa'                => $stat->game_player_xpa,
					'game_player_xpm'                => $stat->game_player_xpm,
					'game_player_touchbacks'         => $stat->game_player_touchbacks,
					'game_player_returns'            => $stat->game_player_returns,
					'game_player_return_yards'       => $stat->game_player_return_yards,
					'game_player_return_tds'         => $stat->game_player_return_tds,
					'game_player_return_fumbles'     => $stat->game_player_return_fumbles,
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
					<th class="center"><?php esc_html_e( 'OT', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-quarter" name="game_away_first_quarter" value="<?php echo esc_attr( $game['game_away_first_quarter'] ); ?>"/></td>
					<td><label for="away-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-quarter" name="game_away_second_quarter" value="<?php echo esc_attr( $game['game_away_second_quarter'] ); ?>" /></td>
					<td><label for="away-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-quarter" name=" game_away_third_quarter" value="<?php echo esc_attr( $game['game_away_third_quarter'] ); ?>" /></td>
					<td><label for="away-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-quarter" name="game_away_fourth_quarter" value="<?php echo esc_attr( $game['game_away_fourth_quarter'] ); ?>" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" value="<?php echo esc_attr( $game['game_away_overtime'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-quarter" name="game_home_first_quarter" value="<?php echo esc_attr( $game['game_home_first_quarter'] ); ?>"/></td>
					<td><label for="home-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-quarter" name="game_home_second_quarter" value="<?php echo esc_attr( $game['game_home_second_quarter'] ); ?>" /></td>
					<td><label for="home-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-quarter" name=" game_home_third_quarter" value="<?php echo esc_attr( $game['game_home_third_quarter'] ); ?>" /></td>
					<td><label for="home-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Fourth Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-quarter" name="game_home_fourth_quarter" value="<?php echo esc_attr( $game['game_home_fourth_quarter'] ); ?>" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" value="<?php echo esc_attr( $game['game_away_overtime'] ); ?>" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" value="<?php echo esc_attr( stripslashes( $game['game_current_time'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-current-quarter"><?php esc_html_e( 'Current Quarter in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-quarter" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
				</div>
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
						<td><?php esc_html_e( 'Total Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Total Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yards" name="game_away_total" value="<?php echo esc_attr( $game['game_away_total'] ); ?>" /></td>
						<td><label for="home-team-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Total Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yards" name="game_home_total" value="<?php echo esc_attr( $game['game_home_total'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Pass Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-pass" class="screen-reader-text"><?php esc_html_e( 'Away Team Pass Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-pass" name="game_away_pass" value="<?php echo esc_attr( $game['game_away_pass'] ); ?>" /></td>
						<td><label for="home-team-pass" class="screen-reader-text"><?php esc_html_e( 'Home Team Pass Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-pass" name="game_home_pass" value="<?php echo esc_attr( $game['game_home_pass'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Rush Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-rush" class="screen-reader-text"><?php esc_html_e( 'Away Team Rush Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-rush" name="game_away_rush" value="<?php echo esc_attr( $game['game_away_rush'] ); ?>" /></td>
						<td><label for="home-team-rush" class="screen-reader-text"><?php esc_html_e( 'Home Team Rush Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-rush" name="game_home_rush" value="<?php echo esc_attr( $game['game_home_rush'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-to" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-to" name="game_away_to" value="<?php echo esc_attr( $game['game_away_to'] ); ?>" /></td>
						<td><label for="home-team-to" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-to" name="game_home_to" value="<?php echo esc_attr( $game['game_home_to'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Interceptions Thrown', 'sports-bench' ); ?></td>
						<td><label for="away-team-int" class="screen-reader-text"><?php esc_html_e( 'Away Team Interceptions Thrown ', 'sports-bench' ); ?></label><input type="number" id="away-team-int" name="game_away_ints" value="<?php echo esc_attr( $game['game_away_ints'] ); ?>" /></td>
						<td><label for="home-team-int" class="screen-reader-text"><?php esc_html_e( 'Home Team Interceptions Thrown ', 'sports-bench' ); ?></label><input type="number" id="home-team-int" name="game_home_ints" value="<?php echo esc_attr( $game['game_home_ints'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></td>
						<td><label for="away-team-fumbles" class="screen-reader-text"><?php esc_html_e( 'Away Team Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-team-fumbles" name="game_away_fumbles" value="<?php echo esc_attr( $game['game_away_fumbles'] ); ?>" /></td>
						<td><label for="home-team-fumbles" class="screen-reader-text"><?php esc_html_e( 'Home Team Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-team-fumbles" name="game_home_fumbles" value="<?php echo esc_attr( $game['game_home_fumbles'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fumbles Lost', 'sports-bench' ); ?></td>
						<td><label for="away-team-fumbles-lost" class="screen-reader-text"><?php esc_html_e( 'Away Team Fumbles Lost ', 'sports-bench' ); ?></label><input type="number" id="away-team-fumbles-lost" name="game_away_fumbles_lost" value="<?php echo esc_attr( $game['game_away_fumbles_lost'] ); ?>" /></td>
						<td><label for="home-team-fumbles-lost" class="screen-reader-text"><?php esc_html_e( 'Home Team Fumbles Lost ', 'sports-bench' ); ?></label><input type="number" id="home-team-fumbles-lost" name="game_home_fumbles_lost" value="<?php echo esc_attr( $game['game_home_fumbles_lost'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Possession', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="text" id="away-team-possession" name="game_away_possession" value="<?php echo esc_attr( $game['game_away_possession'] ); ?>" /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="text" id="home-team-possession" name="game_home_possession" value="<?php echo esc_attr( $game['game_home_possession'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-returns" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Returns ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-returns" name="game_away_kick_returns" value="<?php echo esc_attr( $game['game_away_kick_returns'] ); ?>" /></td>
						<td><label for="home-team-kick-returns" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Returns ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-returns" name="game_home_kick_returns" value="<?php echo esc_attr( $game['game_home_kick_returns'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Returns Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-returns-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Returns Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-returns-yards" name="game_away_kick_return_yards" value="<?php echo esc_attr( $game['game_away_kick_return_yards'] ); ?>" /></td>
						<td><label for="home-team-kick-returns-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Returns Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-returns-yards" name="game_home_kick_return_yards" value="<?php echo esc_attr( $game['game_home_kick_return_yards'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalties" name="game_away_penalties" value="<?php echo esc_attr( $game['game_away_penalties'] ); ?>" /></td>
						<td><label for="home-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalties" name="game_home_penalties" value="<?php echo esc_attr( $game['game_home_penalties'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Yards', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalty-yards" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Yards ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalty-yards" name="game_away_penalty_yards" value="<?php echo esc_attr( $game['game_away_penalty_yards'] ); ?>" /></td>
						<td><label for="home-team-penalty-yards" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Yards ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalty-yards" name="game_home_penalty_yards" value="<?php echo esc_attr( $game['game_home_penalty_yards'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'First Downs', 'sports-bench' ); ?></td>
						<td><label for="away-team-first-downs" class="screen-reader-text"><?php esc_html_e( 'Away Team First Downs ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-downs" name="game_away_first_downs" value="<?php echo esc_attr( $game['game_away_first_downs'] ); ?>" /></td>
						<td><label for="home-team-first-downs" class="screen-reader-text"><?php esc_html_e( 'Home Team First Downs ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-downs" name="game_home_first_downs" value="<?php echo esc_attr( $game['game_home_first_downs'] ); ?>" /></td>
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
			<h2><?php esc_html_e( 'Match Events', 'sports-bench' ); ?></h2>
			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Quarter', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Scoring Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Scoring Play', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $events ) {
						foreach ( $events as $event ) {
							$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
							$team_id    = $event['game_info_scoring_team_id'];
							$quer       = "SELECT * FROM $table_name WHERE team_id = $team_id;";
							$players    = Database::get_results( $quer );
							$player_ids = [];
							foreach ( $players as $player ) {
								$player_ids[] = $player->player_id;
							}
							?>
							<tr class="game-event-row">
								<td><label for="match-event-quarter" class="screen-reader-text"><?php esc_html_e( 'Match Event Quarter ', 'sports-bench' ); ?></label><input type="number" id="match-event-quarter" name="game_info_quarter[]" value="<?php echo esc_attr( $event['game_info_quarter'] ); ?>" /></td>
								<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" value="<?php echo esc_attr( $event['game_info_time'] ); ?>" /></td>
								<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
									<input type="hidden" name="game_info_id[]" value="<?php echo esc_attr( $event['game_info_id'] ); ?>" />
									<select id="match-event-team" name="game_info_scoring_team_id[]" class="team">
										<?php
										if ( ! in_array( $event['game_info_scoring_team_id'], $team_ids ) ) {
											$the_team = new Team( (int) $event['game_info_scoring_team_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_team->get_team_id() ) . '">' . esc_html( $the_team->get_team_name() ) . '</option>';
										}
										if ( $teams ) {
											foreach ( $teams as $team ) {
												?>
												<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $event['game_info_scoring_team_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_location() ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" value="<?php echo esc_attr( $event['game_info_home_score'] ); ?>" /></td>
								<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" value="<?php echo esc_attr( $event['game_info_away_score'] ); ?>" /></td>
								<td><label for="match-event-play" class="screen-reader-text"><?php esc_html_e( 'Match Event Scoring Play ', 'sports-bench' ); ?></label><input type="text" id="match-event-play" name="game_info_play[]" value="<?php echo esc_attr( $event['game_info_play'] ); ?>" /></td>
								<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row">
							<td><label for="match-event-quarter" class="screen-reader-text"><?php esc_html_e( 'Match Event Quarter ', 'sports-bench' ); ?></label><input type="number" id="match-event-quarter" name="game_info_quarter[]" /></td>
							<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
							<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
								<input type="hidden" name="game_info_id[]" />
								<select id="match-event-team" name="game_info_scoring_team_id[]" class="team">
									<?php
									if ( $teams ) {
										foreach ( $teams as $team ) {
											?>
											<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_location() ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
							<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" /></td>
							<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" /></td>
							<td><label for="match-event-play" class="screen-reader-text"><?php esc_html_e( 'Match Event Scoring Play ', 'sports-bench' ); ?></label><input type="text" id="match-event-play" name="game_info_play[]" /></td>
							<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-event-empty-row screen-reader-text">
						<td><label for="match-event-quarter" class="screen-reader-text"><?php esc_html_e( 'Match Event Quarter ', 'sports-bench' ); ?></label><input type="number" id="match-event-quarter" name="game_info_quarter[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field" disabled="disabled" />
							<select id="match-event-team" name="game_info_scoring_team_id[]" class="team new-field" disabled="disabled">
								<?php
								if ( $teams ) {
									foreach ( $teams as $team ) {
										?>
										<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_location() ); ?></option>
										<?php
									}
								}
								?>
							</select>
						</td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-play" class="screen-reader-text"><?php esc_html_e( 'Match Event Scoring Play ', 'sports-bench' ); ?></label><input type="text" id="match-event-play" name="game_info_play[]" /></td>
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
		$passers       = [];
		$rushers       = [];
		$receivers     = [];
		$defenders     = [];
		$kickers       = [];
		$kickreturners = [];

		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_away_id'] ) {
					if ( $player_stat['game_player_attempts'] > 0 ) {
						array_push( $passers, $player_stat );
					}
					if ( $player_stat['game_player_rushes'] > 0 ) {
						array_push( $rushers, $player_stat );
					}
					if ( $player_stat['game_player_catches'] > 0 ) {
						array_push( $receivers, $player_stat );
					}
					if ( $player_stat['game_player_tackles'] > 0 || $player_stat['game_player_pbu'] > 0 || $player_stat['game_player_ints'] > 0 || $player_stat['game_player_ff'] > 0 || $player_stat['game_player_fr'] > 0 || $player_stat['game_player_blocked'] > 0 ) {
						array_push( $defenders, $player_stat );
					}
					if ( $player_stat['game_player_fga'] > 0 || $player_stat['game_player_xpa'] > 0 ) {
						array_push( $kickers, $player_stat );
					}
					if ( $player_stat['game_player_returns'] > 0 ) {
						array_push( $kickreturners, $player_stat );
					}
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
			<h3><?php esc_html_e( 'Passing', 'sports-bench' ); ?></h3>
			<table id="away-passing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Completions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'INTs', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $passers ) {
						foreach ( $passers as $passer ) {
							?>
							<tr class="game-away-1-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $passer['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $passer['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass"/>
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $passer['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $passer['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $passer['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="away-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-comp" name="game_player_completions[]" value="<?php echo esc_attr( $passer['game_player_completions'] ); ?>" /></td>
								<td><label for="away-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-attempts" name="game_player_attempts[]" value="<?php echo esc_attr( $passer['game_player_attempts'] ); ?>" /></td>
								<td><label for="away-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-yards" name="game_player_pass_yards[]" value="<?php echo esc_attr( $passer['game_player_pass_yards'] ); ?>" /></td>
								<td><label for="away-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-td" name="game_player_pass_tds[]" value="<?php echo esc_attr( $passer['game_player_pass_tds'] ); ?>" /></td>
								<td><label for="away-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-int" name="game_player_pass_ints[]" value="<?php echo esc_attr( $passer['game_player_pass_ints'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $passer['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $passer['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $passer['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $passer['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $passer['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $passer['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $passer['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $passer['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $passer['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $passer['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $passer['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $passer['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $passer['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $passer['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $passer['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $passer['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $passer['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $passer['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $passer['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $passer['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $passer['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $passer['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $passer['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $passer['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $passer['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $passer['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $passer['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass"/>
							<td>
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
							<td><label for="away-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-comp" name="game_player_completions[]" /></td>
							<td><label for="away-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-attempts" name="game_player_attempts[]" /></td>
							<td><label for="away-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-yards" name="game_player_pass_yards[]" /></td>
							<td><label for="away-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-td" name="game_player_pass_tds[]" /></td>
							<td><label for="away-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-int" name="game_player_pass_ints[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-comp" name="game_player_completions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="away-player-attempts" name="game_player_attempts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-yards" name="game_player_pass_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-td" name="game_player_pass_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-pass-int" name="game_player_pass_ints[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Rushing', 'sports-bench' ); ?></h3>
			<table id="away-rushing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Rushes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $rushers ) {
						foreach ( $rushers as $rusher ) {
							?>
							<tr class="game-away-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $rusher['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $rusher['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $rusher['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $rusher['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $rusher['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="away-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush" name="game_player_rushes[]" value="<?php echo esc_attr( $rusher['game_player_rushes'] ); ?>" /></td>
								<td><label for="away-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-yards" name="game_player_rush_yards[]" value="<?php echo esc_attr( $rusher['game_player_rush_yards'] ); ?>" /></td>
								<td><label for="away-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-td" name="game_player_rush_tds[]" value="<?php echo esc_attr( $rusher['game_player_rush_tds'] ); ?>" /></td>
								<td><label for="away-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-fum" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_rush_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $rusher['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $rusher['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $rusher['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $rusher['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $rusher['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $rusher['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $rusher['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $rusher['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $rusher['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $rusher['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $rusher['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $rusher['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $rusher['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $rusher['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $rusher['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $rusher['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $rusher['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $rusher['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $rusher['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $rusher['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $rusher['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $rusher['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $rusher['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $rusher['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $rusher['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $rusher['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-2-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
							<td>
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
							<td><label for="away-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush" name="game_player_rushes[]" /></td>
							<td><label for="away-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-yards" name="game_player_rush_yards[]" /></td>
							<td><label for="away-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-td" name="game_player_rush_tds[]" /></td>
							<td><label for="away-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-fum" name="game_player_rush_fumbles[]" /></td>
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush" name="game_player_rushes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-yards" name="game_player_rush_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-td" name="game_player_rush_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rush-fum" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Receiving', 'sports-bench' ); ?></h3>
			<table id="away-passing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Catches', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $receivers ) {
						foreach ( $receivers as $receiver ) {
							?>
							<tr class="game-away-3-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $receiver['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $receiver['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $receiver['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $receiver['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $receiver['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="away-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-catches" name="game_player_catches[]" value="<?php echo esc_attr( $receiver['game_player_catches'] ); ?>" /></td>
								<td><label for="away-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-yards" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $receiver['game_player_receiving_yards'] ); ?>" /></td>
								<td><label for="away-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-td" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $receiver['game_player_receiving_tds'] ); ?>" /></td>
								<td><label for="away-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-fum" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_receiving_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $receiver['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $receiver['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $receiver['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $receiver['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $receiver['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $receiver['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $receiver['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $receiver['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $receiver['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $receiver['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $receiver['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $receiver['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $receiver['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $receiver['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $receiver['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $receiver['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $receiver['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $receiver['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $receiver['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $receiver['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $receiver['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $receiver['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $receiver['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $receiver['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $receiver['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $receiver['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-3-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
							<td>
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
							<td><label for="away-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-catches" name="game_player_catches[]" /></td>
							<td><label for="away-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-yards" name="game_player_receiving_yards[]" /></td>
							<td><label for="away-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-td" name="game_player_receiving_tds[]" /></td>
							<td><label for="away-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-fum" name="game_player_receiving_fumbles[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-3-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="away-player-catches" name="game_player_catches[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-yards" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-td" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-rec-fum" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-3" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Defense', 'sports-bench' ); ?></h3>
			<table id="away-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles for Loss', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pass Break Ups', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Interceptions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdown Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Forced Fumbles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles Recovered', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kick Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Return Yards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $defenders ) {
						foreach ( $defenders as $defender ) {
							?>
							<tr class="game-away-4-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $defender['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $defender['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $defender['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $defender['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $defender['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="away-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="away-player-tackles" name="game_player_tackles[]" value="<?php echo esc_attr( $defender['game_player_tackles'] ); ?>" /></td>
								<td><label for="away-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="away-player-tfl" name="game_player_tfl[]" value="<?php echo esc_attr( $defender['game_player_tfl'] ); ?>" /></td>
								<td><label for="away-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-sacks" name="game_player_sacks[]" value="<?php echo esc_attr( $defender['game_player_sacks'] ); ?>" /></td>
								<td><label for="away-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="away-player-pbu" name="game_player_pbu[]" value="<?php echo esc_attr( $defender['game_player_pbu'] ); ?>" /></td>
								<td><label for="away-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-ints" name="game_player_ints[]" value="<?php echo esc_attr( $defender['game_player_ints'] ); ?>" /></td>
								<td><label for="away-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-tds" name="game_player_tds[]" value="<?php echo esc_attr( $defender['game_player_tds'] ); ?>" /></td>
								<td><label for="away-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-ff" name="game_player_ff[]" value="<?php echo esc_attr( $defender['game_player_ff'] ); ?>" /></td>
								<td><label for="away-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fr" name="game_player_fr[]" value="<?php echo esc_attr( $defender['game_player_fr'] ); ?>" /></td>
								<td><label for="away-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-rkick-blocks" name="game_player_blocked[]" value="<?php echo esc_attr( $defender['game_player_blocked'] ); ?>" /></td>
								<td><label for="away-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-yards" name="game_player_yards[]" value="<?php echo esc_attr( $defender['game_player_yards'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $defender['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $defender['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $defender['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $defender['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $defender['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $defender['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $defender['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $defender['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $defender['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $defender['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $defender['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $defender['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $defender['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $defender['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $defender['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $defender['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $defender['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $defender['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $defender['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $defender['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $defender['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $defender['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-4-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
							<td>
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
							<td><label for="away-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="away-player-tackles" name="game_player_tackles[]" /></td>
							<td><label for="away-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="away-player-tfl" name="game_player_tfl[]" /></td>
							<td><label for="away-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-sacks" name="game_player_sacks[]" /></td>
							<td><label for="away-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="away-player-pbu" name="game_player_pbu[]" /></td>
							<td><label for="away-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-ints" name="game_player_ints[]" /></td>
							<td><label for="away-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-tds" name="game_player_tds[]" /></td>
							<td><label for="away-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-ff" name="game_player_ff[]" /></td>
							<td><label for="away-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fr" name="game_player_fr[]" /></td>
							<td><label for="away-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-rkick-blocks" name="game_player_blocked[]" /></td>
							<td><label for="away-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-yards" name="game_player_yards[]" /></td>
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-4-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="away-player-tackles" name="game_player_tackles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="away-player-tfl" name="game_player_tfl[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-sacks" name="game_player_sacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="away-player-pbu" name="game_player_pbu[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-ints" name="game_player_ints[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-tds" name="game_player_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-ff" name="game_player_ff[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fr" name="game_player_fr[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-rkick-blocks" name="game_player_blocked[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-yards" name="game_player_yards[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-4" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kicking', 'sports-bench' ); ?></h3>
			<table id="away-kicking-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchbacks', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $kickers ) {
						foreach ( $kickers as $kicker ) {
							?>
							<tr class="game-away-5-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $kicker['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $kicker['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $kicker['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $kicker['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $kicker['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" value="<?php echo esc_attr( $kicker['game_player_fga'] ); ?>" /></td>
								<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" value="<?php echo esc_attr( $kicker['game_player_fgm'] ); ?>" /></td>
								<td><label for="away-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpa" name="game_player_xpa[]" value="<?php echo esc_attr( $kicker['game_player_xpa'] ); ?>" /></td>
								<td><label for="away-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpm" name="game_player_xpm[]" value="<?php echo esc_attr( $kicker['game_player_xpm'] ); ?>" /></td>
								<td><label for="away-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-touchbacks" name="game_player_touchbacks[]" value="<?php echo esc_attr( $kicker['game_player_touchbacks'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $kicker['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $kicker['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $kicker['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $kicker['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $kicker['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $kicker['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $kicker['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $kicker['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $kicker['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $kicker['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $kicker['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $kicker['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $kicker['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $kicker['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $kicker['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $kicker['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $kicker['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $kicker['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $kicker['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $kicker['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $kicker['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $kicker['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $kicker['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $kicker['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-5-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
							<td>
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
							<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" /></td>
							<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" /></td>
							<td><label for="away-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpa" name="game_player_xpa[]" /></td>
							<td><label for="away-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpm" name="game_player_xpm[]" /></td>
							<td><label for="away-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-touchbacks" name="game_player_touchbacks[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-5-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpa" name="game_player_xpa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-xpm" name="game_player_xpm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="away-player-touchbacks" name="game_player_touchbacks[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-5" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></h3>
			<table id="away-kick-returns-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $kickreturners ) {
						foreach ( $kickreturners as $kickreturner ) {
							?>
							<tr class="game-away-6-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $kickreturner['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $kickreturner['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $kickreturner['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $kickreturner['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $kickreturner['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="away-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="away-player-returns" name="game_player_returns[]" value="<?php echo esc_attr( $kickreturner['game_player_returns'] ); ?>" /></td>
								<td><label for="away-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-yards" name="game_player_return_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_return_yards'] ); ?>" /></td>
								<td><label for="away-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-td" name="game_player_return_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_return_tds'] ); ?>" /></td>
								<td><label for="away-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-fum" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_return_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $kickreturner['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $kickreturner['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $kickreturner['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $kickreturner['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $kickreturner['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $kickreturner['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $kickreturner['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $kickreturner['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $kickreturner['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $kickreturner['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $kickreturner['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $kickreturner['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $kickreturner['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $kickreturner['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $kickreturner['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $kickreturner['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $kickreturner['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_fumbles'] ); ?>" />\
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-6-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
							<td>
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
							<td><label for="away-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="away-player-returns" name="game_player_returns[]" /></td>
							<td><label for="away-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-yards" name="game_player_return_yards[]" /></td>
							<td><label for="away-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-td" name="game_player_return_tds[]" /></td>
							<td><label for="away-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-fum" name="game_player_return_fumbles[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-6-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="away-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="away-player-returns" name="game_player_returns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-yards" name="game_player_return_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-td" name="game_player_return_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="away-player-return-fum" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />]
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-6" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
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
		$passers       = [];
		$rushers       = [];
		$receivers     = [];
		$defenders     = [];
		$kickers       = [];
		$kickreturners = [];

		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_home_id'] ) {
					if ( $player_stat['game_player_attempts'] > 0 ) {
						array_push( $passers, $player_stat );
					}
					if ( $player_stat['game_player_rushes'] > 0 ) {
						array_push( $rushers, $player_stat );
					}
					if ( $player_stat['game_player_catches'] > 0 ) {
						array_push( $receivers, $player_stat );
					}
					if ( $player_stat['game_player_tackles'] > 0 || $player_stat['game_player_pbu'] > 0 || $player_stat['game_player_ints'] > 0 || $player_stat['game_player_ff'] > 0 || $player_stat['game_player_fr'] > 0 || $player_stat['game_player_blocked'] > 0 ) {
						array_push( $defenders, $player_stat );
					}
					if ( $player_stat['game_player_fga'] > 0 || $player_stat['game_player_xpa'] ) {
						array_push( $kickers, $player_stat );
					}
					if ( $player_stat['game_player_returns'] > 0 ) {
						array_push( $kickreturners, $player_stat );
					}
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
			<h3><?php esc_html_e( 'Passing', 'sports-bench' ); ?></h3>
			<table id="home-passing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Completions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Attempts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'INTs', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $passers ) {
						foreach ( $passers as $passer ) {
							?>
							<tr class="game-home-1-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $passer['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $passer['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $passer['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $passer['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $passer['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . wp_kses_post( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="home-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-comp" name="game_player_completions[]" value="<?php echo esc_attr( $passer['game_player_completions'] ); ?>" /></td>
								<td><label for="home-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-attempts" name="game_player_attempts[]" value="<?php echo esc_attr( $passer['game_player_attempts'] ); ?>" /></td>
								<td><label for="home-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-yards" name="game_player_pass_yards[]" value="<?php echo esc_attr( $passer['game_player_pass_yards'] ); ?>" /></td>
								<td><label for="home-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-td" name="game_player_pass_tds[]" value="<?php echo esc_attr( $passer['game_player_pass_tds'] ); ?>" /></td>
								<td><label for="home-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-int" name="game_player_pass_ints[]" value="<?php echo esc_attr( $passer['game_player_pass_ints'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $passer['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $passer['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $passer['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $passer['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $passer['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $passer['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $passer['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $passer['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $passer['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $passer['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $passer['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $passer['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $passer['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $passer['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $passer['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $passer['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $passer['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $passer['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $passer['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $passer['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $passer['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $passer['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $passer['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $passer['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $passer['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $passer['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $passer['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" />
							<td>
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
							<td><label for="home-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-comp" name="game_player_completions[]" /></td>
							<td><label for="home-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-attempts" name="game_player_attempts[]" /></td>
							<td><label for="home-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-yards" name="game_player_pass_yards[]" /></td>
							<td><label for="home-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-td" name="game_player_pass_tds[]" /></td>
							<td><label for="home-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-int" name="game_player_pass_ints[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="pass" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-comp" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-comp" name="game_player_completions[]" class="new-field" disabled="disabled" /></td>
							<td><label for="home-player-attempts" class="screen-reader-text"><?php esc_html_e( 'Attempts ', 'sports-bench' ); ?></label><input type="number" id="home-player-attempts" name="game_player_attempts[]" class="new-field" disabled="disabled" /></td>
							<td><label for="home-player-pass-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-yards" name="game_player_pass_yards[]" class="new-field" disabled="disabled" /></td>
							<td><label for="home-player-pass-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-td" name="game_player_pass_tds[]" class="new-field" disabled="disabled" /></td>
							<td><label for="home-player-pass-int" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-pass-int" name="game_player_pass_ints[]" class="new-field" disabled="disabled" /></td>
							<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
							<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Rushing', 'sports-bench' ); ?></h3>
			<table id="home-rushing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Rushes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $rushers ) {
						foreach ( $rushers as $rusher ) {
							?>
							<tr class="game-home-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $rusher['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $rusher['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $rusher['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $rusher['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $rusher['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="home-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush" name="game_player_rushes[]" value="<?php echo esc_attr( $rusher['game_player_rushes'] ); ?>" /></td>
								<td><label for="home-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-yards" name="game_player_rush_yards[]" value="<?php echo esc_attr( $rusher['game_player_rush_yards'] ); ?>" /></td>
								<td><label for="home-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-td" name="game_player_rush_tds[]" value="<?php echo esc_attr( $rusher['game_player_rush_tds'] ); ?>" /></td>
								<td><label for="home-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-fum" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_rush_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $rusher['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $rusher['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $rusher['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $rusher['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $rusher['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $rusher['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $rusher['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $rusher['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $rusher['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $rusher['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $rusher['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $rusher['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $rusher['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $rusher['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $rusher['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $rusher['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $rusher['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $rusher['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $rusher['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $rusher['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $rusher['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $rusher['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $rusher['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $rusher['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $rusher['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $rusher['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $rusher['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-2-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" />
							<td>
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
							<td><label for="home-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush" name="game_player_rushes[]" /></td>
							<td><label for="home-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-yards" name="game_player_rush_yards[]" /></td>
							<td><label for="home-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-td" name="game_player_rush_tds[]" /></td>
							<td><label for="home-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-fum" name="game_player_rush_fumbles[]" /></td>
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="rush" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-rush" class="screen-reader-text"><?php esc_html_e( 'Rushes ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush" name="game_player_rushes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-yards" name="game_player_rush_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-td" name="game_player_rush_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rush-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rush-fum" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Receiving', 'sports-bench' ); ?></h3>
			<table id="home-passing-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Catches', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TDs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $receivers ) {
						foreach ( $receivers as $receiver ) {
							?>
							<tr class="game-home-3-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $receiver['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $receiver['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $receiver['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $passer['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $receiver['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="home-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-catches" name="game_player_catches[]" value="<?php echo esc_attr( $receiver['game_player_catches'] ); ?>" /></td>
								<td><label for="home-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-yards" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $receiver['game_player_receiving_yards'] ); ?>" /></td>
								<td><label for="home-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-td" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $receiver['game_player_receiving_tds'] ); ?>" /></td>
								<td><label for="home-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-fum" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_receiving_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $receiver['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $receiver['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $receiver['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $receiver['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $receiver['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $receiver['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $receiver['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $receiver['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $receiver['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $receiver['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $receiver['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $receiver['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $receiver['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $receiver['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $receiver['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $receiver['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $receiver['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $receiver['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $receiver['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $receiver['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $receiver['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $receiver['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $receiver['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $receiver['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $receiver['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $receiver['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $receiver['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-3-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" />
							<td>
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
							<td><label for="home-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-catches" name="game_player_catches[]" /></td>
							<td><label for="home-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-yards" name="game_player_receiving_yards[]" /></td>
							<td><label for="home-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-td" name="game_player_receiving_tds[]" /></td>
							<td><label for="home-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-fum" name="game_player_receiving_fumbles[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-3-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="receive" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-catches" class="screen-reader-text"><?php esc_html_e( 'Completions ', 'sports-bench' ); ?></label><input type="number" id="home-player-catches" name="game_player_catches[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-yards" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-td" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-rec-fum" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-rec-fum" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-3" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Defense', 'sports-bench' ); ?></h3>
			<table id="home-defense-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tackles for Loss', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Sacks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pass Break Ups', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Interceptions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdown Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Forced Fumbles', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles Recovered', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Kick Blocks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Return Yards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $defenders ) {
						foreach ( $defenders as $defender ) {
							?>
							<tr class="game-home-4-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $defender['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $defender['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $defender['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $defender['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $defender['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="home-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="home-player-tackles" name="game_player_tackles[]" value="<?php echo esc_attr( $defender['game_player_tackles'] ); ?>" /></td>
								<td><label for="home-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="home-player-tfl" name="game_player_tfl[]" value="<?php echo esc_attr( $defender['game_player_tfl'] ); ?>" /></td>
								<td><label for="home-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-sacks" name="game_player_sacks[]" value="<?php echo esc_attr( $defender['game_player_sacks'] ); ?>" /></td>
								<td><label for="home-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="home-player-pbu" name="game_player_pbu[]" value="<?php echo esc_attr( $defender['game_player_pbu'] ); ?>" /></td>
								<td><label for="home-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-ints" name="game_player_ints[]" value="<?php echo esc_attr( $defender['game_player_ints'] ); ?>" /></td>
								<td><label for="home-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-tds" name="game_player_tds[]" value="<?php echo esc_attr( $defender['game_player_tds'] ); ?>" /></td>
								<td><label for="home-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-ff" name="game_player_ff[]" value="<?php echo esc_attr( $defender['game_player_ff'] ); ?>" /></td>
								<td><label for="home-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fr" name="game_player_fr[]" value="<?php echo esc_attr( $defender['game_player_fr'] ); ?>" /></td>
								<td><label for="home-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-rkick-blocks" name="game_player_blocked[]" value="<?php echo esc_attr( $defender['game_player_blocked'] ); ?>" /></td>
								<td><label for="home-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-yards" name="game_player_yards[]" value="<?php echo esc_attr( $defender['game_player_yards'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $defender['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $defender['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $defender['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $defender['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $defender['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $defender['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $defender['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $defender['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $defender['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $defender['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $defender['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $defender['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $defender['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $defender['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $defender['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $defender['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $defender['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $defender['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $defender['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $defender['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $defender['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $defender['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-4-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" />
							<td>
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
							<td><label for="home-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="home-player-tackles" name="game_player_tackles[]" /></td>
							<td><label for="home-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="home-player-tfl" name="game_player_tfl[]" /></td>
							<td><label for="home-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-sacks" name="game_player_sacks[]" /></td>
							<td><label for="home-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="home-player-pbu" name="game_player_pbu[]" /></td>
							<td><label for="home-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-ints" name="game_player_ints[]" /></td>
							<td><label for="home-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-tds" name="game_player_tds[]" /></td>
							<td><label for="home-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-ff" name="game_player_ff[]" /></td>
							<td><label for="home-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fr" name="game_player_fr[]" /></td>
							<td><label for="home-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-rkick-blocks" name="game_player_blocked[]" /></td>
							<td><label for="home-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-yards" name="game_player_yards[]" /></td>
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-4-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="defend" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-tackles" class="screen-reader-text"><?php esc_html_e( 'Tackles ', 'sports-bench' ); ?></label><input type="number" id="home-player-tackles" name="game_player_tackles[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-tfl" class="screen-reader-text"><?php esc_html_e( 'Tackles for Loss ', 'sports-bench' ); ?></label><input type="number" id="home-player-tfl" name="game_player_tfl[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sacks" class="screen-reader-text"><?php esc_html_e( 'Sacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-sacks" name="game_player_sacks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pbu" class="screen-reader-text"><?php esc_html_e( 'Pass Break Ups ', 'sports-bench' ); ?></label><input type="number" id="home-player-pbu" name="game_player_pbu[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-ints" class="screen-reader-text"><?php esc_html_e( 'Interceptions ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-ints" name="game_player_ints[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-tds" class="screen-reader-text"><?php esc_html_e( 'Defensive Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-tds" name="game_player_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ff" class="screen-reader-text"><?php esc_html_e( 'Forced Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-ff" name="game_player_ff[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fr" class="screen-reader-text"><?php esc_html_e( 'Fumbles Recovered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fr" name="game_player_fr[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-kick-blocks" class="screen-reader-text"><?php esc_html_e( 'Kick Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-rkick-blocks" name="game_player_blocked[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-yards" class="screen-reader-text"><?php esc_html_e( 'Return Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-yards" name="game_player_yards[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-4" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kicking', 'sports-bench' ); ?></h3>
			<table id="home-kicking-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FG Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Attempted', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'XP Made', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchbacks', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $kickers ) {
						foreach ( $kickers as $kicker ) {
							?>
							<tr class="game-home-5-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $kicker['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]"  value="<?php echo esc_attr( $kicker['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
									<?php
									if ( ! in_array( $kicker['game_player_id'], $player_ids ) ) {
										$the_player = new Player( (int) $kicker['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									}

									foreach ( $player_list as $single_player ) {
										if ( $kicker['game_player_id'] === $single_player['player_id'] ) {
											$selected = 'selected="selected"';
										} else {
											$selected = '';
										}
										echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
									}
									?>
									</select>
								</td>
								<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" value="<?php echo esc_attr( $kicker['game_player_fga'] ); ?>" /></td>
								<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" value="<?php echo esc_attr( $kicker['game_player_fgm'] ); ?>" /></td>
								<td><label for="home-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpa" name="game_player_xpa[]" value="<?php echo esc_attr( $kicker['game_player_xpa'] ); ?>" /></td>
								<td><label for="home-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpm" name="game_player_xpm[]" value="<?php echo esc_attr( $kicker['game_player_xpm'] ); ?>" /></td>
								<td><label for="home-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-touchbacks" name="game_player_touchbacks[]" value="<?php echo esc_attr( $kicker['game_player_touchbacks'] ); ?>" /></td>
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $kicker['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $kicker['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $kicker['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_rush_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $kicker['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $kicker['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $kicker['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $kicker['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $kicker['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $kicker['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $kicker['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $kicker['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $kicker['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $kicker['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $kicker['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $kicker['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $kicker['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $kicker['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $kicker['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $kicker['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $kicker['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $kicker['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_returns[]" value="<?php echo esc_attr( $kicker['game_player_returns'] ); ?>" />
								<input type="hidden" name="game_player_return_yards[]" value="<?php echo esc_attr( $kicker['game_player_return_yards'] ); ?>" />
								<input type="hidden" name="game_player_return_tds[]" value="<?php echo esc_attr( $kicker['game_player_return_tds'] ); ?>" />
								<input type="hidden" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $kicker['game_player_return_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-5-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" />
							<td>
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
							<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" /></td>
							<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" /></td>
							<td><label for="home-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpa" name="game_player_xpa[]" /></td>
							<td><label for="home-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpm" name="game_player_xpm[]" /></td>
							<td><label for="home-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-touchbacks" name="game_player_touchbacks[]" /></td>
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_returns[]" />
							<input type="hidden" name="game_player_return_yards[]" />
							<input type="hidden" name="game_player_return_tds[]" />
							<input type="hidden" name="game_player_return_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-5-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="kick" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-xpa" class="screen-reader-text"><?php esc_html_e( 'Extra Points Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpa" name="game_player_xpa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-xpm" class="screen-reader-text"><?php esc_html_e( 'Extra Points Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-xpm" name="game_player_xpm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-touchbacks" class="screen-reader-text"><?php esc_html_e( 'Touchbacks ', 'sports-bench' ); ?></label><input type="number" id="home-player-touchbacks" name="game_player_touchbacks[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_returns[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-5" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Kick Returns', 'sports-bench' ); ?></h3>
			<table id="home-kick-returns-stats" class="form-table football-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Returns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Touchdowns', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fumbles', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $kickreturners ) {
						foreach ( $kickreturners as $kickreturner ) {
							?>
							<tr class="game-home-6-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $kickreturner['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $kickreturner['game_team_id'] ); ?>" />
								<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $kickreturner['game_player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $kickreturner['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $kickreturner['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="home-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="home-player-returns" name="game_player_returns[]" value="<?php echo esc_attr( $kickreturner['game_player_returns'] ); ?>" /></td>
								<td><label for="home-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-yards" name="game_player_return_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_return_yards'] ); ?>" /></td>
								<td><label for="home-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-td" name="game_player_return_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_return_tds'] ); ?>" /></td>
								<td><label for="home-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-fum" name="game_player_return_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_return_fumbles'] ); ?>" /></td>
								<input type="hidden" name="game_player_completions[]" value="<?php echo esc_attr( $kickreturner['game_player_completions'] ); ?>" />
								<input type="hidden" name="game_player_attempts[]" value="<?php echo esc_attr( $kickreturner['game_player_attempts'] ); ?>" />
								<input type="hidden" name="game_player_pass_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_yards'] ); ?>" />
								<input type="hidden" name="game_player_pass_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_tds'] ); ?>" />
								<input type="hidden" name="game_player_pass_ints[]" value="<?php echo esc_attr( $kickreturner['game_player_pass_ints'] ); ?>" />
								<input type="hidden" name="game_player_catches[]" value="<?php echo esc_attr( $kickreturner['game_player_catches'] ); ?>" />
								<input type="hidden" name="game_player_receiving_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_yards'] ); ?>" />
								<input type="hidden" name="game_player_receiving_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_tds'] ); ?>" />
								<input type="hidden" name="game_player_receiving_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_receiving_fumbles'] ); ?>" />
								<input type="hidden" name="game_player_tackles[]" value="<?php echo esc_attr( $kickreturner['game_player_tackles'] ); ?>" />
								<input type="hidden" name="game_player_tfl[]" value="<?php echo esc_attr( $kickreturner['game_player_tfl'] ); ?>" />
								<input type="hidden" name="game_player_sacks[]" value="<?php echo esc_attr( $kickreturner['game_player_sacks'] ); ?>" />
								<input type="hidden" name="game_player_pbu[]" value="<?php echo esc_attr( $kickreturner['game_player_pbu'] ); ?>" />
								<input type="hidden" name="game_player_ints[]" value="<?php echo esc_attr( $kickreturner['game_player_ints'] ); ?>" />
								<input type="hidden" name="game_player_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_tds'] ); ?>" />
								<input type="hidden" name="game_player_ff[]" value="<?php echo esc_attr( $kickreturner['game_player_ff'] ); ?>" />
								<input type="hidden" name="game_player_fr[]" value="<?php echo esc_attr( $kickreturner['game_player_fr'] ); ?>" />
								<input type="hidden" name="game_player_blocked[]" value="<?php echo esc_attr( $kickreturner['game_player_blocked'] ); ?>" />
								<input type="hidden" name="game_player_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_yards'] ); ?>" />
								<input type="hidden" name="game_player_fga[]" value="<?php echo esc_attr( $kickreturner['game_player_fga'] ); ?>" />
								<input type="hidden" name="game_player_fgm[]" value="<?php echo esc_attr( $kickreturner['game_player_fgm'] ); ?>" />
								<input type="hidden" name="game_player_xpa[]" value="<?php echo esc_attr( $kickreturner['game_player_xpa'] ); ?>" />
								<input type="hidden" name="game_player_xpm[]" value="<?php echo esc_attr( $kickreturner['game_player_xpm'] ); ?>" />
								<input type="hidden" name="game_player_touchbacks[]" value="<?php echo esc_attr( $kickreturner['game_player_touchbacks'] ); ?>" />
								<input type="hidden" name="game_player_rushes[]" value="<?php echo esc_attr( $kickreturner['game_player_rushes'] ); ?>" />
								<input type="hidden" name="game_player_rush_yards[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_yards'] ); ?>" />
								<input type="hidden" name="game_player_rush_tds[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_tds'] ); ?>" />
								<input type="hidden" name="game_player_rush_fumbles[]" value="<?php echo esc_attr( $kickreturner['game_player_rush_fumbles'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-6-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
							<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" />
							<td>
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
							<td><label for="home-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="home-player-returns" name="game_player_returns[]" /></td>
							<td><label for="home-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-yards" name="game_player_return_yards[]" /></td>
							<td><label for="home-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-td" name="game_player_return_tds[]" /></td>
							<td><label for="home-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-fum" name="game_player_return_fumbles[]" /></td>
							<input type="hidden" name="game_player_completions[]" />
							<input type="hidden" name="game_player_attempts[]" />
							<input type="hidden" name="game_player_pass_yards[]" />
							<input type="hidden" name="game_player_pass_tds[]" />
							<input type="hidden" name="game_player_pass_ints[]" />
							<input type="hidden" name="game_player_catches[]" />
							<input type="hidden" name="game_player_receiving_yards[]" />
							<input type="hidden" name="game_player_receiving_tds[]" />
							<input type="hidden" name="game_player_receiving_fumbles[]" />
							<input type="hidden" name="game_player_tackles[]" />
							<input type="hidden" name="game_player_tfl[]" />
							<input type="hidden" name="game_player_sacks[]" />
							<input type="hidden" name="game_player_pbu[]" />
							<input type="hidden" name="game_player_ints[]" />
							<input type="hidden" name="game_player_tds[]" />
							<input type="hidden" name="game_player_ff[]" />
							<input type="hidden" name="game_player_fr[]" />
							<input type="hidden" name="game_player_blocked[]" />
							<input type="hidden" name="game_player_yards[]" />
							<input type="hidden" name="game_player_fga[]" />
							<input type="hidden" name="game_player_fgm[]" />
							<input type="hidden" name="game_player_xpa[]" />
							<input type="hidden" name="game_player_xpm[]" />
							<input type="hidden" name="game_player_touchbacks[]" />
							<input type="hidden" name="game_player_rushes[]" />
							<input type="hidden" name="game_player_rush_yards[]" />
							<input type="hidden" name="game_player_rush_tds[]" />
							<input type="hidden" name="game_player_rush_fumbles[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-6-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input id="game_stats_section" name="game_stats_section[]" type="hidden" value="return" class="new-field" disabled="disabled" />
						<td>
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
						<td><label for="home-player-returns" class="screen-reader-text"><?php esc_html_e( 'Returns ', 'sports-bench' ); ?></label><input type="number" id="home-player-returns" name="game_player_returns[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-yards" class="screen-reader-text"><?php esc_html_e( 'Yards ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-yards" name="game_player_return_yards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-td" class="screen-reader-text"><?php esc_html_e( 'Touchdowns ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-td" name="game_player_return_tds[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-return-fumb" class="screen-reader-text"><?php esc_html_e( 'Fumbles ', 'sports-bench' ); ?></label><input type="number" id="home-player-return-fum" name="game_player_return_fumbles[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_completions[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_attempts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pass_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_catches[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_receiving_fumbles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tackles[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tfl[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pbu[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ints[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_ff[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fr[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_blocked[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fga[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fgm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpa[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_xpm[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_touchbacks[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rushes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_yards[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_tds[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_rush_fumbles[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-6" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
