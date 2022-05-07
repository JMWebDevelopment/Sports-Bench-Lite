<?php
/**
 * Creates the hockey game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Hockey;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The hockey game admin class.
 *
 * This is used for hockey game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/hockey
 */
class HockeyAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new HockeyAdminGame object to be used.
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
					<th class="center"><?php esc_html_e( 'OT', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Shootout', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-period" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-period" name="game_away_first_period" ></td>
					<td><label for="away-team-second-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-period" name="game_away_second_period" /></td>
					<td><label for="away-team-third-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-period" name="game_away_third_period" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" /></td>
					<td><label for="away-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-shootout" name="game_away_shootout" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-period" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-period" name="game_home_first_period" /></td>
					<td><label for="home-team-second-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-period" name="game_home_second_period" /></td>
					<td><label for="home-team-third-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-period" name="game_home_third_period" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" /></td>
					<td><label for="home-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-shootout" name="game_home_shootout" /></td>
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
					<label for="game-current-period"><?php esc_html_e( 'Current Period in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-period" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
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
						<td><?php esc_html_e( 'First Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-first-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team First Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-sog" name="game_away_first_sog" /></td>
						<td><label for="home-team-first-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team First Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-sog" name="game_away_first_sog" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Second Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-second-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-sog" name="game_away_second_sog" /></td>
						<td><label for="home-team-second-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-sog" name="game_away_second_sog" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Third Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-third-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-sog" name="game_away_third_sog" /></td>
						<td><label for="home-team-third-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-sog" name="game_away_third_sog" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Overtime SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-overtime-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime SOG ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime-sog" name="game_away_overtime_sog" /></td>
						<td><label for="home-team-overtime-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Overtime SOG ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime-sog" name="game_away_overtime_sog" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Power Plays', 'sports-bench' ); ?></td>
						<td><label for="away-team-pp" class="screen-reader-text"><?php esc_html_e( 'Away Team Power Plays ', 'sports-bench' ); ?></label><input type="number" id="away-team-pp" name="game_away_power_plays" /></td>
						<td><label for="home-team-pp" class="screen-reader-text"><?php esc_html_e( 'Home Team Power Plays ', 'sports-bench' ); ?></label><input type="number" id="home-team-pp" name="game_away_power_plays" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Power Play Goals', 'sports-bench' ); ?></td>
						<td><label for="away-team-ppg" class="screen-reader-text"><?php esc_html_e( 'Away Team Power Play Goals ', 'sports-bench' ); ?></label><input type="number" id="away-team-ppg" name="game_away_pp_goals" /></td>
						<td><label for="home-team-ppg" class="screen-reader-text"><?php esc_html_e( 'Home Team Power Play Goals ', 'sports-bench' ); ?></label><input type="number" id="home-team-ppg" name="game_away_pp_goals" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Minutes', 'sports-bench' ); ?></td>
						<td><label for="away-team-pm" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-team-pm" name="game_away_pen_minutes" /></td>
						<td><label for="home-team-pm" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-team-pm" name="game_away_pen_minutes" /></td>
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
			<h3><?php esc_html_e( 'Goals', 'sports-bench' ); ?></h3>
			<table id="match-goals" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Period', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assist One', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assist Two', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row game-goal-row">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]"/>
							<input type="hidden" name="game_info_event[]" value="Goal" />
							<select id="match-event-team" name="team_id[]" class="team">
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
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]">
							</select>
						</td>
						<td>
							<label for="match-event-assist-one" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist One ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-one" name="game_info_assist_one_id[]">
							</select>
						</td>
						<td>
							<label for="match-event-assist-two" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist Two ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-two" name="game_info_assist_two_id[]">
							</select>
						</td>
						<input type="hidden" id="match-event-penalty" name="game_info_penalty[]" />
						<td><button class="remove-game-goal"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-goal-empty-row screen-reader-text">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field team" disabled="disabled" />
							<input type="hidden" name="game_info_event[]" value="Goal" class="new-field team" disabled="disabled" />
							<select id="match-event-team" name="team_id[]" class="team" class="new-field team" disabled="disabled">
							</select>
						</td>
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field team" disabled="disabled" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled">
							</select>
						</td>
						<td>
							<label for="match-event-assist-one" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist One ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-one" name="game_info_assist_one_id[]" class="new-field" disabled="disabled">
						</td>
						<td>
							<label for="match-event-assist-two" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist Two ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-two" name="game_info_assist_two_id[]" class="new-field" disabled="disabled">
							</select>
						</td>
						<input type="hidden" id="match-event-penalty" name="game_info_penalty[]" class="new-field" disabled="disabled" />
						<td><button class="remove-game-goal"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-goal"><?php esc_html_e( 'Add Goal', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></h3>
			<table id="match-penalties" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Period', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row game-penalty-row">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]"/>
							<input type="hidden" name="game_info_event[]" value="Goal" />
							<select id="match-event-team" name="team_id[]" class="team">
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
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]">
							</select>
						</td>
						<td><label for="match-event-penalty" class="screen-reader-text"><?php esc_html_e( 'Match Event Penalty ', 'sports-bench' ); ?></label><input type="text" id="match-event-penalty" name="game_info_penalty[]" /></td>
						<input type="hidden" name="game_info_assist_one_id[]" />
						<input type="hidden" name="game_info_assist_two_id[]" />
						<td><button class="remove-game-penalty"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-penalty-empty-row screen-reader-text">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field team" disabled="disabled" />
							<input type="hidden" name="game_info_event[]" value="Goal" class="new-field team" disabled="disabled" />
							<select id="match-event-team" name="team_id[]" class="team" class="new-field team" disabled="disabled">
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
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field team" disabled="disabled" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled">
							</select>
						</td>
						<td><label for="match-event-penalty" class="screen-reader-text"><?php esc_html_e( 'Match Event Penalty ', 'sports-bench' ); ?></label><input type="text" id="match-event-penalty" name="game_info_penalty[]" class="new-field team" disabled="disabled" /></td>
						<input type="hidden" name="game_info_assist_one_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_info_assist_two_id[]" class="new-field" disabled="disabled" />
						<td><button class="remove-game-penalty"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-penalty"><?php esc_html_e( 'Add Penalty', 'sports-bench' ); ?></button>
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
			<h3><?php esc_html_e( 'Players', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table hockey-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shifts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs Won', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]"  /></td>
						<td><label for="away-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen" name="game_player_penalties[]" /></td>
						<td><label for="away-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen-min" name="game_player_pen_minutes[]" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" /></td>
						<td><label for="away-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="away-player-shifts" name="game_player_shifts[]" /></td>
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" /></td>
						<td><label for="away-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs" name="game_player_faceoffs[]" /></td>
						<td><label for="away-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs-wins" name="game_player_faceoff_wins[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_shots_faced[]" />
						<input type="hidden" name="game_player_saves[]" />
						<input type="hidden" name="game_player_goals_allowed[]" />
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]" class="new-field" disabled="disabled"></select></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="away-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen" name="game_player_penalties[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen-min" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="away-player-shifts" name="game_player_shifts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs" name="game_player_faceoffs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs-wins" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_saves[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Goalies', 'sports-bench' ); ?></h3>
			<table id="away-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Saves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-2-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_saves[]" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
						<input type="hidden" name="game_player_goals[]" />
						<input type="hidden" name="game_player_assists[]" />
						<input type="hidden" name="game_player_plus_minus[]" />
						<input type="hidden" name="game_player_sog[]" />
						<input type="hidden" name="game_player_penalties[]" />
						<input type="hidden" name="game_player_pen_minutes[]" />
						<input type="hidden" name="game_player_hits[]" />
						<input type="hidden" name="game_player_shifts[]" />
						<input type="hidden" name="game_player_faceoffs[]" />
						<input type="hidden" name="game_player_faceoff_wins[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]" class="new-field" disabled="disabled"></select></td>
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_saves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_plus_minus[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_penalties[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shifts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoffs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" />
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
		?>
		<div id="home-team-stats" class="game-details">
			<h2><?php esc_html_e( 'Away Team Player Stats', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Players', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table hockey-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shifts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs Won', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]"  /></td>
						<td><label for="home-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen" name="game_player_penalties[]" /></td>
						<td><label for="home-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen-min" name="game_player_pen_minutes[]" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" /></td>
						<td><label for="home-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="home-player-shifts" name="game_player_shifts[]" /></td>
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" /></td>
						<td><label for="home-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs" name="game_player_faceoffs[]" /></td>
						<td><label for="home-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs-wins" name="game_player_faceoff_wins[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_shots_faced[]" />
						<input type="hidden" name="game_player_saves[]" />
						<input type="hidden" name="game_player_goals_allowed[]" />
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]" class="new-field" disabled="disabled"></select></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="home-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen" name="game_player_penalties[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen-min" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="home-player-shifts" name="game_player_shifts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs" name="game_player_faceoffs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs-wins" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_saves[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Goalies', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Saves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-2-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_saves[]" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
						<input type="hidden" name="game_player_goals[]" />
						<input type="hidden" name="game_player_assists[]" />
						<input type="hidden" name="game_player_plus_minus[]" />
						<input type="hidden" name="game_player_sog[]" />
						<input type="hidden" name="game_player_penalties[]" />
						<input type="hidden" name="game_player_pen_minutes[]" />
						<input type="hidden" name="game_player_hits[]" />
						<input type="hidden" name="game_player_shifts[]" />
						<input type="hidden" name="game_player_faceoffs[]" />
						<input type="hidden" name="game_player_faceoff_wins[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]" class="new-field" disabled="disabled"></select></td>
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_saves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_plus_minus[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_penalties[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shifts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoffs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" />
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
			'game_home_first_period'    => 0,
			'game_home_second_period'   => 0,
			'game_home_third_period'    => 0,
			'game_home_shootout'        => '',
			'game_home_overtime'        => '',
			'game_away_first_period'    => 0,
			'game_away_second_period'   => 0,
			'game_away_third_period'    => 0,
			'game_away_shootout'        => '',
			'game_away_overtime'        => '',
			'game_home_first_sog'       => 0,
			'game_home_second_sog'      => 0,
			'game_home_third_sog'       => 0,
			'game_home_overtime_sog'    => '',
			'game_home_power_plays'     => 0,
			'game_home_pp_goals'        => 0,
			'game_home_pen_minutes'     => 0,
			'game_away_first_sog'       => 0,
			'game_away_second_sog'      => 0,
			'game_away_third_sog'       => 0,
			'game_away_overtime_sog'    => '',
			'game_away_power_plays'     => 0,
			'game_away_pp_goals'        => 0,
			'game_away_pen_minutes'     => 0,
			'game_info_id'              => array(),
			'game_info_event'           => array(),
			'game_info_period'          => array(),
			'game_info_time'            => array(),
			'player_id'                 => array(),
			'game_info_assist_one_id'   => array(),
			'game_info_assist_two_id'   => array(),
			'game_info_penalty'         => array(),
			'team_id'                   => array(),
			'game_stats_player_id'      => array(),
			'game_team_id'              => array(),
			'game_player_id'            => array(),
			'game_player_goals'         => array(),
			'game_player_assists'       => array(),
			'game_player_plus_minus'    => array(),
			'game_player_sog'           => array(),
			'game_player_penalties'     => array(),
			'game_player_pen_minutes'   => array(),
			'game_player_hits'          => array(),
			'game_player_shifts'        => array(),
			'game_player_time_on_ice'   => array(),
			'game_player_faceoffs'      => array(),
			'game_player_faceoff_wins'  => array(),
			'game_player_shots_faced'   => array(),
			'game_player_saves'         => array(),
			'game_player_goals_allowed' => array(),
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
				'game_id'                   => intval( $game['game_id'] ),
				'game_week'                 => intval( $game['game_week'] ),
				'game_day'                  => wp_filter_nohtml_kses( sanitize_text_field( $game['game_day'] ) ),
				'game_season'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_season'] ) ),
				'game_home_id'              => intval( $game['game_home_id'] ),
				'game_away_id'              => intval( $game['game_away_id'] ),
				'game_home_final'           => intval( $game['game_home_final'] ),
				'game_away_final'           => intval( $game['game_away_final'] ),
				'game_attendance'           => intval( $game['game_attendance'] ),
				'game_status'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_status'] ) ),
				'game_current_period'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_period'] ) ),
				'game_current_time'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_time'] ) ),
				'game_current_home_score'   => intval( $game['game_current_home_score'] ),
				'game_current_away_score'   => intval( $game['game_current_away_score'] ),
				'game_neutral_site'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_neutral_site'] ) ),
				'game_location_stadium'     => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_stadium'] ) ),
				'game_location_line_one'    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_one'] ) ),
				'game_location_line_two'    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_two'] ) ),
				'game_location_city'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_city'] ) ),
				'game_location_state'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_state'] ) ),
				'game_location_country'     => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_country'] ) ),
				'game_location_zip_code'    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_zip_code'] ) ),
				'game_home_first_period'    => intval( $game['game_home_first_period'] ),
				'game_home_second_period'   => intval( $game['game_home_second_period'] ),
				'game_home_third_period'    => intval( $game['game_home_third_period'] ),
				'game_home_shootout'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_shootout'] ) ),
				'game_home_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_overtime'] ) ),
				'game_away_first_period'    => intval( $game['game_away_first_period'] ),
				'game_away_second_period'   => intval( $game['game_away_second_period'] ),
				'game_away_third_period'    => intval( $game['game_away_third_period'] ),
				'game_away_shootout'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_shootout'] ) ),
				'game_away_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_overtime'] ) ),
				'game_home_first_sog'       => intval( $game['game_home_first_sog'] ),
				'game_home_second_sog'      => intval( $game['game_home_second_sog'] ),
				'game_home_third_sog'       => intval( $game['game_home_third_sog'] ),
				'game_home_overtime_sog'    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_overtime_sog'] ) ),
				'game_home_power_plays'     => intval( $game['game_home_power_plays'] ),
				'game_home_pp_goals'        => intval( $game['game_home_pp_goals'] ),
				'game_home_pen_minutes'     => intval( $game['game_home_pen_minutes'] ),
				'game_away_first_sog'       => intval( $game['game_away_first_sog'] ),
				'game_away_second_sog'      => intval( $game['game_away_second_sog'] ),
				'game_away_third_sog'       => intval( $game['game_away_third_sog'] ),
				'game_away_overtime_sog'    => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_overtime_sog'] ) ),
				'game_away_power_plays'     => intval( $game['game_away_power_plays'] ),
				'game_away_pp_goals'        => intval( $game['game_away_pp_goals'] ),
				'game_away_pen_minutes'     => intval( $game['game_away_pen_minutes'] ),
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

		$game_info_events = $game['game_info_event'];
		unset( $game['game_info_event'] );

		$game_info_periods = $game['game_info_period'];
		unset( $game['game_info_period'] );

		$game_info_times = $game['game_info_time'];
		unset( $game['game_info_time'] );

		$player_ids = $game['player_id'];
		unset( $game['player_id'] );

		$game_info_assist_one_ids = $game['game_info_assist_one_id'];
		unset( $game['game_info_assist_one_id'] );

		$game_info_assist_two_ids = $game['game_info_assist_two_id'];
		unset( $game['game_info_assist_two_id'] );

		$game_info_penalties = $game['game_info_penalty'];
		unset( $game['game_info_penalty'] );

		$team_ids = $game['team_id'];
		unset( $game['team_id'] );

		if ( $team_ids ) {
			$len = count( $team_ids );
		} else {
			$len = 0;
		}

		$events = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_info_ids[ $i ]  ) ) {
				$gi_id = $game_info_ids[ $i ];
			} else {
				$gi_id = '';
			}
			if ( isset( $game_info_assist_one_ids[ $i ] ) ) {
				$assist_one = $game_info_assist_one_ids[ $i ];
			} else {
				$assist_one = '';
			}
			if ( isset( $game_info_assist_two_ids[ $i ] ) ) {
				$assist_two = $game_info_assist_two_ids[ $i ];
			} else {
				$assist_two = '';
			}
			if ( isset( $game_info_penalties[ $i ] ) ) {
				$penalty = $game_info_penalties[ $i ];
			} else {
				$penalty = '';
			}
			if ( isset( $player_ids[ $i ] ) ) {
				$event = array(
					'game_info_id'            => intval( $gi_id ),
					'game_id'                 => intval( $game['game_id'] ),
					'game_info_event'         => wp_filter_nohtml_kses( sanitize_text_field( $game_info_events[ $i ] ) ),
					'game_info_period'        => wp_filter_nohtml_kses( sanitize_text_field( $game_info_periods[ $i ] ) ),
					'game_info_time'          => wp_filter_nohtml_kses( sanitize_text_field( $game_info_times[ $i ] ) ),
					'player_id'               => intval( $player_ids[ $i ] ),
					'game_info_assist_one_id' => intval( $assist_one ),
					'game_info_assist_two_id' => intval( $assist_two ),
					'game_info_penalty'       => wp_filter_nohtml_kses( sanitize_text_field( $penalty ) ),
					'team_id'                 => intval( $team_ids[ $i ] ),
				);
				array_push( $events, $event );
			}
		}

		//* Get the game events already in the database to compare the new ones to
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$game_id         = $game['game_id'];
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
			if ( !in_array( $info_id, $event_ids ) ) {
				$wpdb->query( "DELETE FROM $game_info_table WHERE game_info_id = $info_id" );
			}
		}

		if ( $game['game_home_overtime'] == '' ) {
			$game['game_home_overtime'] = null;
		}

		if ( $game['game_home_overtime_sog'] == '' ) {
			$game['game_home_overtime_sog'] = null;
		}

		if ( $game['game_home_shootout'] == '' ) {
			$game['game_home_shootout'] = null;
		}

		if ( $game['game_away_overtime'] == '' ) {
			$game['game_away_overtime'] = null;
		}

		if ( $game['game_away_overtime_sog'] == '' ) {
			$game['game_away_overtime_sog'] = null;
		}

		if ( $game['game_away_shootout'] == '' ) {
			$game['game_away_shootout'] = null;
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

		//* Pull the player stats out of the $game array
		$game_stats_player_ids = $game['game_stats_player_id'];
		unset( $game['game_stats_player_id'] );

		$team_ids = $game['game_team_id'];
		unset( $game['game_team_id'] );

		$player_ids = $game['game_player_id'];
		unset( $game['game_player_id'] );

		$game_player_goals = $game['game_player_goals'];
		unset( $game['game_player_goals'] );

		$game_player_assists = $game['game_player_assists'];
		unset( $game['game_player_assists'] );

		$game_player_plus_minus = $game['game_player_plus_minus'];
		unset( $game['game_player_plus_minus'] );

		$game_player_sog = $game['game_player_sog'];
		unset( $game['game_player_sog'] );

		$game_player_penalties = $game['game_player_penalties'];
		unset( $game['game_player_penalties'] );

		$game_player_pen_minutes = $game['game_player_pen_minutes'];
		unset( $game['game_player_pen_minutes'] );

		$game_player_hits = $game['game_player_hits'];
		unset( $game['game_player_hits'] );

		$game_player_shifts = $game['game_player_shifts'];
		unset( $game['game_player_shifts'] );

		$game_player_time_on_ice = $game['game_player_time_on_ice'];
		unset( $game['game_player_time_on_ice'] );

		$game_player_faceoffs = $game['game_player_faceoffs'];
		unset( $game['game_player_faceoffs'] );

		$game_player_faceoff_wins = $game['game_player_faceoff_wins'];
		unset( $game['game_player_faceoff_wins'] );

		$game_player_shots_faced = $game['game_player_shots_faced'];
		unset( $game['game_player_shots_faced'] );

		$game_player_saves = $game['game_player_saves'];
		unset( $game['game_player_saves'] );

		$game_player_goals_allowed = $game['game_player_goals_allowed'];
		unset( $game['game_player_goals_allowed'] );

		$len = count( $team_ids );
		$stats = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_stats_player_ids[$i] ) ) {
				$gs_id = $game_stats_player_ids[$i];
			} else {
				$gs_id = '';
			}
			if ( isset( $game_player_time_on_ice[ $i ] ) and strlen( $game_player_time_on_ice[ $i ] ) <= 5 ) {
				$time = '00:' . $game_player_time_on_ice[ $i ];
			} else {
				$time = $game_player_time_on_ice[ $i ];
			}
			if ( $player_ids[ $i ] != '' and $player_ids[ $i ] > 0 ) {
				$stat = array(
					'game_stats_player_id'      => intval( $gs_id ),
					'game_id'                   => intval( $game['game_id'] ),
					'game_team_id'              => intval( $team_ids[ $i ] ),
					'game_player_id'            => intval( $player_ids[ $i ] ),
					'game_player_goals'         => intval( $game_player_goals[ $i ] ),
					'game_player_assists'       => intval( $game_player_assists[ $i ] ),
					'game_player_plus_minus'    => intval( $game_player_plus_minus[ $i ] ),
					'game_player_sog'           => intval( $game_player_sog[ $i ] ),
					'game_player_penalties'     => intval( $game_player_penalties[ $i ] ),
					'game_player_pen_minutes'   => intval( $game_player_pen_minutes[ $i ] ),
					'game_player_hits'          => intval( $game_player_hits[ $i ] ),
					'game_player_shifts'        => intval( $game_player_shifts[ $i ] ),
					'game_player_time_on_ice'   => wp_filter_nohtml_kses( sanitize_text_field( $time ) ),
					'game_player_faceoffs'      => intval( $game_player_faceoffs[ $i ] ),
					'game_player_faceoff_wins'  => intval( $game_player_faceoff_wins[ $i ] ),
					'game_player_shots_faced'   => intval( $game_player_shots_faced[ $i ] ),
					'game_player_saves'         => intval( $game_player_saves[ $i ] ),
					'game_player_goals_allowed' => intval( $game_player_goals_allowed[ $i ] ),
				);
				array_push( $stats, $stat );
			}
		}

		//* Grab the player stats for the game already in the database to compare the new ones to
		$game_info_table = $wpdb->prefix . 'sb_game_stats';
		$game_id = intval( $_REQUEST['game_id'] );
		$quer = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_stats = $wpdb->get_results( $quer );
		$stats_ids = [];
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
			if ( !in_array( $stat_id, $stat_ids ) ) {
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
			if ( $event->game_info_assist_one_id == null ) {
				$assist_one = '';
			} else {
				$assist_one = $event->game_info_assist_one_id;
			}
			if ( $event->game_info_assist_two_id == null ) {
				$assist_two = '';
			} else {
				$assist_two = $event->game_info_assist_two_id;
			}
			if ( $event->game_info_penalty == null ) {
				$penalty = '';
			} else {
				$penalty = $event->game_info_penalty;
			}
			$event_array = array(
				'game_info_id'              => $event->game_info_id,
				'game_id'                   => $event->game_id,
				'game_info_event'           => $event->game_info_event,
				'game_info_period'          => $event->game_info_period,
				'game_info_time'            => $event->game_info_time,
				'player_id'                 => $event->player_id,
				'game_info_assist_one_id'   => $assist_one,
				'game_info_assist_two_id'   => $assist_two,
				'game_info_penalty'         => $penalty,
				'team_id'                   => $event->team_id,
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
					'game_stats_player_id'      => $stat->game_stats_player_id,
					'game_id'                   => $stat->game_id,
					'game_team_id'              => $stat->game_team_id,
					'game_player_id'            => $stat->game_player_id,
					'game_player_goals'         => $stat->game_player_goals,
					'game_player_assists'       => $stat->game_player_assists,
					'game_player_plus_minus'    => $stat->game_player_plus_minus,
					'game_player_sog'           => $stat->game_player_sog,
					'game_player_penalties'     => $stat->game_player_penalties,
					'game_player_pen_minutes'   => $stat->game_player_pen_minutes,
					'game_player_hits'          => $stat->game_player_hits,
					'game_player_shifts'        => $stat->game_player_shifts,
					'game_player_time_on_ice'   => $stat->game_player_time_on_ice,
					'game_player_faceoffs'      => $stat->game_player_faceoffs,
					'game_player_faceoff_wins'  => $stat->game_player_faceoff_wins,
					'game_player_shots_faced'   => $stat->game_player_shots_faced,
					'game_player_saves'         => $stat->game_player_saves,
					'game_player_goals_allowed' => $stat->game_player_goals_allowed,
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
					<th class="center"><?php esc_html_e( 'OT', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Shootout', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-period" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-period" name="game_away_first_period" value="<?php echo esc_attr( $game['game_away_first_period'] ); ?>"/></td>
					<td><label for="away-team-second-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-period" name="game_away_second_period" value="<?php echo esc_attr( $game['game_away_second_period'] ); ?>" /></td>
					<td><label for="away-team-third-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-period" name="game_away_third_period" value="<?php echo esc_attr( $game['game_away_third_period'] ); ?>" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" value="<?php echo esc_attr( $game['game_away_overtime'] ); ?>" /></td>
					<td><label for="away-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-shootout" name="game_away_shootout" value="<?php echo esc_attr( $game['game_away_shootout'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-period" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-period" name="game_home_first_period" value="<?php echo esc_attr( $game['game_home_first_period'] ); ?>"/></td>
					<td><label for="home-team-second-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-period" name="game_home_second_period" value="<?php echo esc_attr( $game['game_home_second_period'] ); ?>" /></td>
					<td><label for="home-team-third-period" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-period" name="game_home_third_period" value="<?php echo esc_attr( $game['game_home_third_period'] ); ?>" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" value="<?php echo esc_attr( $game['game_home_overtime'] ); ?>" /></td>
					<td><label for="home-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-shootout" name="game_home_shootout" value="<?php echo esc_attr( $game['game_home_shootout'] ); ?>" /></td>
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
					<label for="game-current-period"><?php esc_html_e( 'Current Period in Match', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-period" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
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
						<td><?php esc_html_e( 'First Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-first-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team First Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-sog" name="game_away_first_sog" value="<?php echo esc_attr( $game['game_away_first_sog'] ); ?>" /></td>
						<td><label for="home-team-first-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team First Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-sog" name="game_away_first_sog" value="<?php echo esc_attr( $game['game_away_first_sog'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Second Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-second-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-sog" name="game_away_second_sog" value="<?php echo esc_attr( $game['game_away_second_sog'] ); ?>" /></td>
						<td><label for="home-team-second-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-sog" name="game_away_second_sog" value="<?php echo esc_attr( $game['game_away_second_sog'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Third Period SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-third-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-sog" name="game_away_third_sog" value="<?php echo esc_attr( $game['game_away_third_sog'] ); ?>" /></td>
						<td><label for="home-team-third-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Period Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-sog" name="game_away_third_sog" value="<?php echo esc_attr( $game['game_away_third_sog'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Overtime SOG', 'sports-bench' ); ?></td>
						<td><label for="away-team-overtime-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime SOG ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime-sog" name="game_away_overtime_sog" value="<?php echo esc_attr( $game['game_away_overtime_sog'] ); ?>" /></td>
						<td><label for="home-team-overtime-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Overtime SOG ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime-sog" name="game_away_overtime_sog" value="<?php echo esc_attr( $game['game_away_overtime_sog'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Power Plays', 'sports-bench' ); ?></td>
						<td><label for="away-team-pp" class="screen-reader-text"><?php esc_html_e( 'Away Team Power Plays ', 'sports-bench' ); ?></label><input type="number" id="away-team-pp" name="game_away_power_plays" value="<?php echo esc_attr( $game['game_away_power_plays'] ); ?>" /></td>
						<td><label for="home-team-pp" class="screen-reader-text"><?php esc_html_e( 'Home Team Power Plays ', 'sports-bench' ); ?></label><input type="number" id="home-team-pp" name="game_away_power_plays" value="<?php echo esc_attr( $game['game_away_power_plays'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Power Play Goals', 'sports-bench' ); ?></td>
						<td><label for="away-team-ppg" class="screen-reader-text"><?php esc_html_e( 'Away Team Power Play Goals ', 'sports-bench' ); ?></label><input type="number" id="away-team-ppg" name="game_away_pp_goals" value="<?php echo esc_attr( $game['game_away_pp_goals'] ); ?>" /></td>
						<td><label for="home-team-ppg" class="screen-reader-text"><?php esc_html_e( 'Home Team Power Play Goals ', 'sports-bench' ); ?></label><input type="number" id="home-team-ppg" name="game_away_pp_goals" value="<?php echo esc_attr( $game['game_away_pp_goals'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Minutes', 'sports-bench' ); ?></td>
						<td><label for="away-team-pm" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-team-pm" name="game_away_pen_minutes" value="<?php echo esc_attr( $game['game_away_pen_minutes'] ); ?>" /></td>
						<td><label for="home-team-pm" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-team-pm" name="game_away_pen_minutes" value="<?php echo esc_attr( $game['game_away_pen_minutes'] ); ?>" /></td>
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
		$goals     = [];
		$penalties = [];
		if ( $events ) {
			foreach ( $events as $event ) {
				if ( 'Goal' === $event['game_info_event'] ) {
					array_push( $goals, $event );
				} else {
					array_push( $penalties, $event );
				}
			}
		}

		$teams    = $this->get_teams();
		$team_ids = [];
		if ( $teams ) {
			foreach ( $teams as $team ) {
				$team_ids[] = $team->get_team_id();
			}
		}
		?>
		<div class="game-details">
			<h2><?php esc_html_e( 'Game Events', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Goals', 'sports-bench' ); ?></h3>
			<table id="match-goals" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Period', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assist One', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assist Two', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $goals ) {
						foreach ( $goals as $goal ) {
							$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
							$team_id    = $goal['team_id'];
							$quer       = "SELECT * FROM $table_name WHERE team_id = $team_id;";
							$players    = Database::get_results( $quer );
							$player_ids = [];
							foreach ( $players as $player ) {
								$player_ids[] = $player->player_id;
							}
							?>
							<tr class="game-event-row game-goal-row">
								<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
									<input type="hidden" name="game_info_id[]" value="<?php echo esc_attr( $goal['game_info_id'] ); ?>" />
									<input type="hidden" name="game_info_event[]" value="Goal" />
									<select id="match-event-team" name="team_id[]" class="team">
										<?php
										if ( ! in_array( $event['team_id'], $team_ids ) ) {
											$the_team = new Team( (int) $goal['team_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_team->get_team_id() ) . '">' . esc_html( $the_team->get_team_name() ) . '</option>';
										}
										if ( $teams ) {
											foreach ( $teams as $team ) {
												?>
												<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $goal['team_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_location() ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" value="<?php echo esc_attr( $goal['game_info_period'] ); ?>" /></td>
								<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" value="<?php echo esc_attr( $goal['game_info_time'] ); ?>" /></td>
								<td>
									<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
									<select id="match-event-player" name="player_id[]">
										<?php
										if ( ! in_array( $goal['player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $goal['player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $players ) {
											foreach ( $players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $goal['player_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td>
									<label for="match-event-assist-one" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist One ', 'sports-bench' ); ?></label>
									<select id="match-event-assist-one" name="game_info_assist_one_id[]">
										<?php
										if ( ! in_array( $goal['game_info_assist_two_id'], $player_ids ) ) {
											$the_player = new Player( (int) $goal['game_info_assist_one_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $players ) {
											foreach ( $players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $goal['game_info_assist_one_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td>
									<label for="match-event-assist-two" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist Two ', 'sports-bench' ); ?></label>
									<select id="match-event-assist-two" name="game_info_assist_two_id[]">
										<?php
										if ( ! in_array( $goal['game_info_assist_two_id'], $player_ids ) ) {
											$the_player = new Player( (int) $goal['game_info_assist_two_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $players ) {
											foreach ( $players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $goal['game_info_assist_two_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<input type="hidden" id="match-event-penalty" name="game_info_penalty[]" value="<?php echo esc_attr( $goal['game_info_penalty'] ); ?>" />
								<td><button class="remove-game-goal"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row game-goal-row">
							<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
								<input type="hidden" name="game_info_id[]"/>
								<input type="hidden" name="game_info_event[]" value="Goal" />
								<select id="match-event-team" name="team_id[]" class="team">
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
							<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" /></td>
							<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
							<td>
								<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
								<select id="match-event-player" name="player_id[]"></select>
							</td>
							<td>
								<label for="match-event-assist-one" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist One ', 'sports-bench' ); ?></label>
								<select id="match-event-assist-one" name="game_info_assist_one_id[]"></select>
							</td>
							<td>
								<label for="match-event-assist-two" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist Two ', 'sports-bench' ); ?></label>
								<select id="match-event-assist-two" name="game_info_assist_two_id[]"></select>
							</td>
							<input type="hidden" id="match-event-penalty" name="game_info_penalty[]" />
							<td><button class="remove-game-goal"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-goal-empty-row screen-reader-text">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field team" disabled="disabled" />
							<input type="hidden" name="game_info_event[]" value="Goal" class="new-field team" disabled="disabled" />
							<select id="match-event-team" name="team_id[]" class="new-field team" disabled="disabled">
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
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field team" disabled="disabled" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<td>
							<label for="match-event-assist-one" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist One ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-one" name="game_info_assist_one_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<td>
							<label for="match-event-assist-two" class="screen-reader-text"><?php esc_html_e( 'Match Event Assist Two ', 'sports-bench' ); ?></label>
							<select id="match-event-assist-two" name="game_info_assist_two_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<input type="hidden" id="match-event-penalty" name="game_info_penalty[]" class="new-field" disabled="disabled" />
						<td><button class="remove-game-goal"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-goal"><?php esc_html_e( 'Add Goal', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></h3>
			<table id="match-penalties" class="form-table">
				<thead>
					<tr>
						<th class="center"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Period', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $penalties ) {
						foreach ( $penalties as $penalty ) {
							$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
							$team_id    = $penalty['team_id'];
							$quer       = "SELECT * FROM $table_name WHERE team_id = $team_id;";
							$players    = Database::get_results( $quer );
							$player_ids = [];
							foreach ( $players as $player ) {
								$player_ids[] = $player->player_id;
							}
							?>
							<tr class="game-event-row game-penalty-row">
								<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
									<input type="hidden" name="game_info_id[]" value="<?php echo esc_attr( $penalty['game_info_id'] ); ?>" />
									<input type="hidden" name="game_info_event[]" value="Penalty" />
									<select id="match-event-team" name="team_id[]" class="team">
										<?php
										if ( ! in_array( $penalty['team_id'], $team_ids ) ) {
											$the_team = new Team( (int) $penalty['team_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_team->get_team_id() ) . '">' . esc_html( $the_team->get_team_name() ) . '</option>';
										}
										if ( $teams ) {
											foreach ( $teams as $team ) {
												?>
												<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $penalty['team_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_location() ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" value="<?php echo esc_attr( $penalty['game_info_period'] ); ?>" /></td>
								<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" value="<?php echo esc_attr( $penalty['game_info_time'] ); ?>" /></td>
								<td>
									<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
									<select id="match-event-player" name="player_id[]">
										<?php
										if ( ! in_array( $penalty['player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $penalty['player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $players ) {
											foreach ( $players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $penalty['player_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><label for="match-event-penalty" class="screen-reader-text"><?php esc_html_e( 'Match Event Penalty ', 'sports-bench' ); ?></label><input type="text" id="match-event-penalty" name="game_info_penalty[]" value="<?php echo esc_attr( $penalty['game_info_penalty'] ); ?>" /></td>
								<input type="hidden" name="game_info_assist_one_id[]" value="<?php echo esc_attr( $penalty['game_info_assist_one_id'] ); ?>" />
								<input type="hidden" name="game_info_assist_two_id[]" value="<?php echo esc_attr( $penalty['game_info_assist_two_id'] ); ?>" />
								<td><button class="remove-game-penalty"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row game-penalty-row">
							<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
								<input type="hidden" name="game_info_id[]"/>
								<input type="hidden" name="game_info_event[]" value="Goal" />
								<select id="match-event-team" name="team_id[]" class="team">
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
							<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" /></td>
							<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" /></td>
							<td>
								<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
								<select id="match-event-player" name="player_id[]"></select>
							</td>
							<td><label for="match-event-penalty" class="screen-reader-text"><?php esc_html_e( 'Match Event Penalty ', 'sports-bench' ); ?></label><input type="text" id="match-event-penalty" name="game_info_penalty[]" /></td>
							<input type="hidden" name="game_info_assist_one_id[]" />
							<input type="hidden" name="game_info_assist_two_id[]" />
							<td><button class="remove-game-penalty"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-penalty-empty-row screen-reader-text">
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
							<input type="hidden" name="game_info_id[]" class="new-field team" disabled="disabled" />
							<input type="hidden" name="game_info_event[]" value="Goal" class="new-field team" disabled="disabled" />
							<select id="match-event-team" name="team_id[]" class="new-field team" disabled="disabled">
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
						<td><label for="match-event-period" class="screen-reader-text"><?php esc_html_e( 'Match Event Period ', 'sports-bench' ); ?></label><input type="text" id="match-event-period" name="game_info_period[]" class="new-field team" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event time ', 'sports-bench' ); ?></label><input type="text" id="match-event-time" name="game_info_time[]" class="new-field team" disabled="disabled" /></td>
						<td>
							<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<td><label for="match-event-penalty" class="screen-reader-text"><?php esc_html_e( 'Match Event Penalty ', 'sports-bench' ); ?></label><input type="text" id="match-event-penalty" name="game_info_penalty[]" class="new-field team" disabled="disabled" /></td>
						<input type="hidden" name="game_info_assist_one_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_info_assist_two_id[]" class="new-field" disabled="disabled" />
						<td><button class="remove-game-penalty"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-game-penalty"><?php esc_html_e( 'Add Penalty', 'sports-bench' ); ?></button>
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
		$goalies = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_away_id'] ) {
					if ( ( $player_stat['game_player_shots_faced'] > 0 ) || ( $player_stat['game_player_saves'] > 0 ) || ( $player_stat['game_player_goals_allowed'] > 0 ) ) {
						array_push( $goalies, $player_stat );
					} else {
						array_push( $players, $player_stat );
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
			<h3><?php esc_html_e( 'Players', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table hockey-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shifts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs Won', 'sports-bench' ); ?></th>
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
								<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" value="<?php echo esc_attr( $player['game_player_goals'] ); ?>" /></td>
								<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" value="<?php echo esc_attr( $player['game_player_plus_minus'] ); ?>" /></td>
								<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" value="<?php echo esc_attr( $player['game_player_sog'] ); ?>" /></td>
								<td><label for="away-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen" name="game_player_penalties[]" value="<?php echo esc_attr( $player['game_player_penalties'] ); ?>" /></td>
								<td><label for="away-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen-min" name="game_player_pen_minutes[]" value="<?php echo esc_attr( $player['game_player_pen_minutes'] ); ?>" /></td>
								<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" value="<?php echo esc_attr( $player['game_player_hits'] ); ?>" /></td>
								<td><label for="away-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="away-player-shifts" name="game_player_shifts[]" value="<?php echo esc_attr( $player['game_player_shifts'] ); ?>" /></td>
								<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" value="<?php echo esc_attr( $player['game_player_time_on_ice'] ); ?>" /></td>
								<td><label for="away-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs" name="game_player_faceoffs[]" value="<?php echo esc_attr( $player['game_player_faceoffs'] ); ?>" /></td>
								<td><label for="away-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs-wins" name="game_player_faceoff_wins[]" value="<?php echo esc_attr( $player['game_player_faceoff_wins'] ); ?>" /></td>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_shots_faced[]" value="<?php echo esc_attr( $player['game_player_shots_faced'] ); ?>" />
								<input type="hidden" name="game_player_saves[]" value="<?php echo esc_attr( $player['game_player_saves'] ); ?>" />
								<input type="hidden" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $player['game_player_goals_allowed'] ); ?>" />
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
							<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" /></td>
							<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
							<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" /></td>
							<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]"  /></td>
							<td><label for="away-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen" name="game_player_penalties[]" /></td>
							<td><label for="away-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen-min" name="game_player_pen_minutes[]" /></td>
							<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" /></td>
							<td><label for="away-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="away-player-shifts" name="game_player_shifts[]" /></td>
							<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" /></td>
							<td><label for="away-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs" name="game_player_faceoffs[]" /></td>
							<td><label for="away-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs-wins" name="game_player_faceoff_wins[]" /></td>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_shots_faced[]" />
							<input type="hidden" name="game_player_saves[]" />
							<input type="hidden" name="game_player_goals_allowed[]" />
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
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="away-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen" name="game_player_penalties[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="away-player-pen-min" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="away-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="away-player-shifts" name="game_player_shifts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs" name="game_player_faceoffs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="away-player-faceoffs-wins" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_saves[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Goalies', 'sports-bench' ); ?></h3>
			<table id="away-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time on Ice', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Saved', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $goalies ) {
						foreach ( $goalies as $goalie ) {
							?>
							<tr class="game-away-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $goalie['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $goalie['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $goalie['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $goalie['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->player_id ) . '">' . esc_html( $the_player->player_first_name ) . ' ' . esc_html( $the_player->player_last_name ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $goalie['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" value="<?php echo esc_attr( $goalie['game_player_time_on_ice'] ); ?>" /></td>
								<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" value="<?php echo esc_attr( $goalie['game_player_shots_faced'] ); ?>" /></td>
								<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_saves[]" value="<?php echo esc_attr( $goalie['game_player_saves'] ); ?>" /></td>
								<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $goalie['game_player_goals_allowed'] ); ?>" /></td>
								<input type="hidden" name="game_player_goals[]" value="<?php echo esc_attr( $goalie['game_player_goals'] ); ?>" />
								<input type="hidden" name="game_player_assists[]" value="<?php echo esc_attr( $goalie['game_player_assists'] ); ?>" />
								<input type="hidden" name="game_player_plus_minus[]" value="<?php echo esc_attr( $goalie['game_player_plus_minus'] ); ?>" />
								<input type="hidden" name="game_player_sog[]" value="<?php echo esc_attr( $goalie['game_player_sog'] ); ?>" />
								<input type="hidden" name="game_player_penalties[]" value="<?php echo esc_attr( $goalie['game_player_penalties'] ); ?>" />
								<input type="hidden" name="game_player_pen_minutes[]" value="<?php echo esc_attr( $goalie['game_player_pen_minutes'] ); ?>" />
								<input type="hidden" name="game_player_hits[]" value="<?php echo esc_attr( $goalie['game_player_hits'] ); ?>" />
								<input type="hidden" name="game_player_shifts[]" value="<?php echo esc_attr( $goalie['game_player_shifts'] ); ?>" />
								<input type="hidden" name="game_player_faceoffs[]" value="<?php echo esc_attr( $goalie['game_player_faceoffs'] ); ?>" />
								<input type="hidden" name="game_player_faceoff_wins[]" value="<?php echo esc_attr( $goalie['game_player_faceoff_wins'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
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
							<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" /></td>
							<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" /></td>
							<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_saves[]" /></td>
							<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
							<input type="hidden" name="game_player_goals[]" />
							<input type="hidden" name="game_player_assists[]" />
							<input type="hidden" name="game_player_plus_minus[]" />
							<input type="hidden" name="game_player_sog[]" />
							<input type="hidden" name="game_player_penalties[]" />
							<input type="hidden" name="game_player_pen_minutes[]" />
							<input type="hidden" name="game_player_hits[]" />
							<input type="hidden" name="game_player_shifts[]" />
							<input type="hidden" name="game_player_faceoffs[]" />
							<input type="hidden" name="game_player_faceoff_wins[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-2-empty-row screen-reader-text">
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
						<td><label for="away-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_saves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_plus_minus[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_penalties[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shifts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoffs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" />
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
		$players = [];
		$goalies = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_home_id'] ) {
					if ( ( $player_stat['game_player_shots_faced'] > 0 ) || ( $player_stat['game_player_saves'] > 0 ) || ( $player_stat['game_player_goals_allowed'] > 0 ) ) {
						array_push( $goalies, $player_stat );
					} else {
						array_push( $players, $player_stat );
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
			$title        = esc_html__( 'Home Team Player Stats', 'sports-bench' );
			$border_style = '';
		}
		?>
		<div id="home-team-stats" class="game-details" <?php echo wp_kses_post( $border_style ); ?>>
			<h2><?php echo esc_html( $title ); ?></h2>
			<h3><?php esc_html_e( 'Players', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table hockey-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Pen Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Hits', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shifts', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Ice Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Faceoffs Won', 'sports-bench' ); ?></th>
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
								<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" value="<?php echo esc_attr( $player['game_player_goals'] ); ?>" /></td>
								<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" value="<?php echo esc_attr( $player['game_player_plus_minus'] ); ?>" /></td>
								<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" value="<?php echo esc_attr( $player['game_player_sog'] ); ?>" /></td>
								<td><label for="home-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen" name="game_player_penalties[]" value="<?php echo esc_attr( $player['game_player_penalties'] ); ?>" /></td>
								<td><label for="home-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen-min" name="game_player_pen_minutes[]" value="<?php echo esc_attr( $player['game_player_pen_minutes'] ); ?>" /></td>
								<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" value="<?php echo esc_attr( $player['game_player_hits'] ); ?>" /></td>
								<td><label for="home-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="home-player-shifts" name="game_player_shifts[]" value="<?php echo esc_attr( $player['game_player_shifts'] ); ?>" /></td>
								<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" value="<?php echo esc_attr( $player['game_player_time_on_ice'] ); ?>" /></td>
								<td><label for="home-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs" name="game_player_faceoffs[]" value="<?php echo esc_attr( $player['game_player_faceoffs'] ); ?>" /></td>
								<td><label for="home-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs-wins" name="game_player_faceoff_wins[]" value="<?php echo esc_attr( $player['game_player_faceoff_wins'] ); ?>" /></td>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_shots_faced[]" value="<?php echo esc_attr( $player['game_player_shots_faced'] ); ?>" />
								<input type="hidden" name="game_player_saves[]" value="<?php echo esc_attr( $player['game_player_saves'] ); ?>" />
								<input type="hidden" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $player['game_player_goals_allowed'] ); ?>" />
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
							<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" /></td>
							<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
							<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" /></td>
							<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]"  /></td>
							<td><label for="home-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen" name="game_player_penalties[]" /></td>
							<td><label for="home-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen-min" name="game_player_pen_minutes[]" /></td>
							<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" /></td>
							<td><label for="home-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="home-player-shifts" name="game_player_shifts[]" /></td>
							<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" /></td>
							<td><label for="home-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs" name="game_player_faceoffs[]" /></td>
							<td><label for="home-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs-wins" name="game_player_faceoff_wins[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_shots_faced[]" />
							<input type="hidden" name="game_player_saves[]" />
							<input type="hidden" name="game_player_goals_allowed[]" />
						</tr>
						<?php
					}
					?>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
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
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled"  /></td>
						<td><label for="home-player-pen" class="screen-reader-text"><?php esc_html_e( 'Penalties ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen" name="game_player_penalties[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-pen-min" class="screen-reader-text"><?php esc_html_e( 'Penalty Minutes ', 'sports-bench' ); ?></label><input type="number" id="home-player-pen-min" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-hits" class="screen-reader-text"><?php esc_html_e( 'Hits ', 'sports-bench' ); ?></label><input type="number" id="home-player-hits" name="game_player_hits[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shifts" class="screen-reader-text"><?php esc_html_e( 'Shifts ', 'sports-bench' ); ?></label><input type="number" id="home-player-shifts" name="game_player_shifts[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Ice Time ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-faceoffs" class="screen-reader-text"><?php esc_html_e( 'Faceoffs ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs" name="game_player_faceoffs[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-faceoffs-wins" class="screen-reader-text"><?php esc_html_e( 'Faceoff Wins ', 'sports-bench' ); ?></label><input type="number" id="home-player-faceoffs-wins" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_saves[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Goalies', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time on Ice', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Saved', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $goalies ) {
						foreach ( $goalies as $goalie ) {
							?>
							<tr class="game-home-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $goalie['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $goalie['game_team_id'] ); ?>" />
								<td class="player-name">
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $goalie['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $goalie['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->player_id ) . '">' . esc_html( $the_player->player_first_name ) . ' ' . esc_html( $the_player->player_last_name ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $goalie['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" value="<?php echo esc_attr( $goalie['game_player_time_on_ice'] ); ?>" /></td>
								<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" value="<?php echo esc_attr( $goalie['game_player_shots_faced'] ); ?>" /></td>
								<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_saves[]" value="<?php echo esc_attr( $goalie['game_player_saves'] ); ?>" /></td>
								<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $goalie['game_player_goals_allowed'] ); ?>" /></td>
								<input type="hidden" name="game_player_goals[]" value="<?php echo esc_attr( $goalie['game_player_goals'] ); ?>" />
								<input type="hidden" name="game_player_assists[]" value="<?php echo esc_attr( $goalie['game_player_assists'] ); ?>" />
								<input type="hidden" name="game_player_plus_minus[]" value="<?php echo esc_attr( $goalie['game_player_plus_minus'] ); ?>" />
								<input type="hidden" name="game_player_sog[]" value="<?php echo esc_attr( $goalie['game_player_sog'] ); ?>" />
								<input type="hidden" name="game_player_penalties[]" value="<?php echo esc_attr( $goalie['game_player_penalties'] ); ?>" />
								<input type="hidden" name="game_player_pen_minutes[]" value="<?php echo esc_attr( $goalie['game_player_pen_minutes'] ); ?>" />
								<input type="hidden" name="game_player_hits[]" value="<?php echo esc_attr( $goalie['game_player_hits'] ); ?>" />
								<input type="hidden" name="game_player_shifts[]" value="<?php echo esc_attr( $goalie['game_player_shifts'] ); ?>" />
								<input type="hidden" name="game_player_faceoffs[]" value="<?php echo esc_attr( $goalie['game_player_faceoffs'] ); ?>" />
								<input type="hidden" name="game_player_faceoff_wins[]" value="<?php echo esc_attr( $goalie['game_player_faceoff_wins'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
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
							<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" /></td>
							<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" /></td>
							<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_saves[]" /></td>
							<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
							<input type="hidden" name="game_player_goals[]" />
							<input type="hidden" name="game_player_assists[]" />
							<input type="hidden" name="game_player_plus_minus[]" />
							<input type="hidden" name="game_player_sog[]" />
							<input type="hidden" name="game_player_penalties[]" />
							<input type="hidden" name="game_player_pen_minutes[]" />
							<input type="hidden" name="game_player_hits[]" />
							<input type="hidden" name="game_player_shifts[]" />
							<input type="hidden" name="game_player_faceoffs[]" />
							<input type="hidden" name="game_player_faceoff_wins[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
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
						<td><label for="home-player-ice-time" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-ice-time" name="game_player_time_on_ice[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_saves[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_plus_minus[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_penalties[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_pen_minutes[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_hits[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shifts[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoffs[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_faceoff_wins[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
