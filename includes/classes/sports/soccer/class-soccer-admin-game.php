<?php
/**
 * Creates the soccer game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Soccer;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The soccer game admin class.
 *
 * This is used for soccer game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class SoccerAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new SoccerAdminGame object to be used.
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
					<th class="center"><?php esc_html_e( '1H', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '2H', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'ET', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'PKs', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-half" name="game_away_first_half" /></td>
					<td><label for="away-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-half" name="game_away_second_half" /></td>
					<td><label for="away-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-extra-time" name="game_away_extratime" /></td>
					<td><label for="away-team-pks" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-pks" name="game_away_pks" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Home Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-half" name="game_home_first_half" /></td>
					<td><label for="home-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-half" name="game_home_second_half" /></td>
					<td><label for="home-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Home Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-extra-time" name="game_home_extratime" /></td>
					<td><label for="home-team-pks" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-pks" name="game_home_pks" /></td>
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
						<td><?php esc_html_e( 'Possesion', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="number" id="away-team-possession" name="game_away_possession" /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="number" id="home-team-possession" name="game_home_possession" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Shots', 'sports-bench' ); ?></td>
						<td><label for="away-team-shots" class="screen-reader-text"><?php esc_html_e( 'Away Team Shots ', 'sports-bench' ); ?></label><input type="number" id="away-team-shots" name="game_away_shots" /></td>
						<td><label for="home-team-shots" class="screen-reader-text"><?php esc_html_e( 'Home Team Shots ', 'sports-bench' ); ?></label><input type="number" id="home-team-shots" name="game_home_shots" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Shots on Goal', 'sports-bench' ); ?></td>
						<td><label for="away-team-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-sog" name="game_away_sog" /></td>
						<td><label for="home-team-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-sog" name="game_home_sog" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Corners', 'sports-bench' ); ?></td>
						<td><label for="away-team-corners" class="screen-reader-text"><?php esc_html_e( 'Away Team Corners ', 'sports-bench' ); ?></label><input type="number" id="away-team-corners" name="game_away_corners" /></td>
						<td><label for="home-team-corners" class="screen-reader-text"><?php esc_html_e( 'Home Team Corners ', 'sports-bench' ); ?></label><input type="number" id="home-team-corners" name="game_home_corners" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offsides', 'sports-bench' ); ?></td>
						<td><label for="away-team-offsides" class="screen-reader-text"><?php esc_html_e( 'Away Team Offsides ', 'sports-bench' ); ?></label><input type="number" id="away-team-offsides" name="game_away_offsides" /></td>
						<td><label for="home-team-offsides" class="screen-reader-text"><?php esc_html_e( 'Home Team Offsides ', 'sports-bench' ); ?></label><input type="number" id="home-team-offsides" name="game_home_offsides" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></td>
						<td><label for="away-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Away Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-team-fouls" name="game_away_fouls" /></td>
						<td><label for="home-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Home Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-team-fouls" name="game_home_fouls" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Saves', 'sports-bench' ); ?></td>
						<td><label for="away-team-saves" class="screen-reader-text"><?php esc_html_e( 'Away Team Saves ', 'sports-bench' ); ?></label><input type="number" id="away-team-saves" name="game_away_saves" /></td>
						<td><label for="home-team-saves" class="screen-reader-text"><?php esc_html_e( 'Home Team Saves ', 'sports-bench' ); ?></label><input type="number" id="home-team-saves" name="game_home_saves" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yellow-cards" name="game_away_yellow" /></td>
						<td><label for="home-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yellow-cards" name="game_home_yellow" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-red-cards" name="game_away_red" /></td>
						<td><label for="home-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-red-cards" name="game_home_red" /></td>
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
			<table id="in-progress-fields">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></th>
						<th><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></th>
						<th><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="field one-column">
							<label for="game-away-current-score" class="screen-reader-text"><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></label>
							<input type="number" id="game-away-current-score" name="game_current_away_score" />
						</td>
						<td class="field one-column">
							<label for="game-home-current-score" class="screen-reader-text"><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></label>
							<input type="number" id="game-home-current-score" name="game_current_home_score" />
						</td>
						<td class="field one-column">
							<label for="game-current-time" class="screen-reader-text"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
							<input type="text" id="game-current-time" name="game_current_time" />
							<input type="hidden" name="game_current_period" />
						</td>
					</tr>
				</tbody>
			</table>

			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Event', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Primary Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Secondary Player', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row">
						<input type="hidden" id="match-event-home-score" name="game_info_id[]" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><br />
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
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-home-score" name="game_info_home_score[]" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-away-score" name="game_info_away_score[]" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-time" name="game_info_time[]" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label><br />
							<select id="match-event" name="game_info_event[]" class="match-event-category">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="goal"><?php esc_html_e( 'Goal', 'sports-bench' ); ?></option>
								<option value="goal-pk"><?php esc_html_e( 'Goal (PK)', 'sports-bench' ); ?></option>
								<option value="pk-given"><?php esc_html_e( 'Penalty Kick Awarded To', 'sports-bench' ); ?></option>
								<option value="corner-kick"><?php esc_html_e( 'Corner Kick Conceeded', 'sports-bench' ); ?></option>
								<option value="foul"><?php esc_html_e( 'Foul', 'sports-bench' ); ?></option>
								<option value="shot-missed"><?php esc_html_e( 'Shot Missed', 'sports-bench' ); ?></option>
								<option value="shot-saved"><?php esc_html_e( 'Shot Saved', 'sports-bench' ); ?></option>
								<option value="offside"><?php esc_html_e( 'Offside', 'sports-bench' ); ?></option>
								<option value="yellow"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="red"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td>
							<label for="match-event-player">
								<span class="primary-player-label goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-awarded"><?php esc_html_e( 'Player Awarded PK', 'sports-bench' ); ?></span>
								<span class="primary-player-label ck-conceeded"><?php esc_html_e( 'Player Who Conceeded Corner Kick', 'sports-bench' ); ?></span>
								<span class="primary-player-label foul-given"><?php esc_html_e( 'Fouling Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-missed"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-saved"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label offside"><?php esc_html_e( 'Player Offside', 'sports-bench' ); ?></span>
								<span class="primary-player-label card-given"><?php esc_html_e( 'Player Given Card', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-player" name="player_id[]"></select>
						</td>
						<td>
							<label for="match-event-secondary">
								<span class="secondary-player-label goal-scored"><?php esc_html_e( 'Primary Assist', 'sports-bench' ); ?></span>
								<span class="secondary-player-label pk-awarded"><?php esc_html_e( 'Player Who Gave Up PK', 'sports-bench' ); ?></span>
								<span class="secondary-player-label foul-given"><?php esc_html_e( 'Fouled Player', 'sports-bench' ); ?></span>
								<span class="secondary-player-label shot-saved"><?php esc_html_e( 'Keeper Who Saved Shot', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-secondary" name="secondary_player_id[]"></select>
						</td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-event-empty-row screen-reader-text">
						<input type="hidden" id="match-event-home-score" name="game_info_id[]" class="new-field" disabled="disabled" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><br /><select id="match-event-team" name="team_id[]" class="new-field team" disabled="disabled"></select></td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<br />
							<select id="match-event" name="game_info_event[]" class="match-event-category new-field" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="goal"><?php esc_html_e( 'Goal', 'sports-bench' ); ?></option>
								<option value="goal-pk"><?php esc_html_e( 'Goal (PK)', 'sports-bench' ); ?></option>
								<option value="pk-given"><?php esc_html_e( 'Penalty Kick Awarded To', 'sports-bench' ); ?></option>
								<option value="corner-kick"><?php esc_html_e( 'Corner Kick Conceeded', 'sports-bench' ); ?></option>
								<option value="foul"><?php esc_html_e( 'Foul', 'sports-bench' ); ?></option>
								<option value="shot-missed"><?php esc_html_e( 'Shot Missed', 'sports-bench' ); ?></option>
								<option value="shot-saved"><?php esc_html_e( 'Shot Saved', 'sports-bench' ); ?></option>
								<option value="offside"><?php esc_html_e( 'Offside', 'sports-bench' ); ?></option>
								<option value="yellow"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="red"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td>
							<label for="match-event-player">
								<span class="primary-player-label goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-awarded"><?php esc_html_e( 'Player Awarded PK', 'sports-bench' ); ?></span>
								<span class="primary-player-label ck-conceeded"><?php esc_html_e( 'Player Who Conceeded Corner Kick', 'sports-bench' ); ?></span>
								<span class="primary-player-label foul-given"><?php esc_html_e( 'Fouling Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-missed"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-saved"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label offside"><?php esc_html_e( 'Player Offside', 'sports-bench' ); ?></span>
								<span class="primary-player-label card-given"><?php esc_html_e( 'Player Given Card', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<td>
							<label for="match-event-secondary">
								<span class="secondary-player-label goal-scored"><?php esc_html_e( 'Primary Assist', 'sports-bench' ); ?></span>
								<span class="secondary-player-label pk-awarded"><?php esc_html_e( 'Player Who Gave Up PK', 'sports-bench' ); ?></span>
								<span class="secondary-player-label foul-given"><?php esc_html_e( 'Fouled Player', 'sports-bench' ); ?></span>
								<span class="secondary-player-label shot-saved"><?php esc_html_e( 'Keeper Who Saved Shot', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-assists" name="secondary_player_id[]" class="new-field" disabled="disabled"></select>
						</td>
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
			<h3><?php esc_html_e( 'Outfield Players', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls Suffered', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
						<td><label for="away-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots" name="game_player_shots[]" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" /></td>
						<td><label for="away-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-suffered" name="game_player_fouls_suffered[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_shots_faced[]" />
						<input type="hidden" name="game_player_shots_saved[]" />
						<input type="hidden" name="game_player_goals_allowed[]" />
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-suffered" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots_saved[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Keepers', 'sports-bench' ); ?></h3>
			<table id="away-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
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
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_goals[]" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_assists[]" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_shots[]" /></td>
						<input type="hidden" name="game_player_goals[]" />
						<input type="hidden" name="game_player_assists[]" />
						<input type="hidden" name="game_player_shots[]" />
						<input type="hidden" name="game_player_sog[]" />
						<input type="hidden" name="game_player_fouls[]" />
						<input type="hidden" name="game_player_fouls_suffered[]" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" />
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
			<h2><?php esc_html_e( 'Home Team Player Stats', 'sports-bench' ); ?></h2>
			<h3><?php esc_html_e( 'Outfield Players', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls Suffered', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
						<td><label for="home-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots" name="game_player_shots[]" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" /></td>
						<td><label for="home-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-suffered" name="game_player_fouls_suffered[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						<input type="hidden" name="game_player_shots_faced[]" />
						<input type="hidden" name="game_player_shots_saved[]" />
						<input type="hidden" name="game_player_goals_allowed[]" />
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-suffered" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots_saved[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Keepers', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
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
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_goals[]" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_assists[]" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_shots[]" /></td>
						<input type="hidden" name="game_player_goals[]" />
						<input type="hidden" name="game_player_assists[]" />
						<input type="hidden" name="game_player_shots[]" />
						<input type="hidden" name="game_player_sog[]" />
						<input type="hidden" name="game_player_fouls[]" />
						<input type="hidden" name="game_player_fouls_suffered[]" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" />
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
			'game_home_first_half'          => '',
			'game_home_second_half'         => '',
			'game_home_extratime'           => '',
			'game_home_pks'                 => '',
			'game_away_first_half'          => '',
			'game_away_second_half'         => '',
			'game_away_extratime'           => '',
			'game_away_pks'                 => '',
			'game_home_possession'          => '',
			'game_home_shots'               => 0,
			'game_home_sog'                 => 0,
			'game_home_corners'             => 0,
			'game_home_offsides'            => 0,
			'game_home_fouls'               => 0,
			'game_home_saves'               => 0,
			'game_home_yellow'              => 0,
			'game_home_red'                 => 0,
			'game_away_possession'          => '',
			'game_away_shots'               => 0,
			'game_away_sog'                 => 0,
			'game_away_corners'             => 0,
			'game_away_offsides'            => 0,
			'game_away_fouls'               => 0,
			'game_away_saves'               => 0,
			'game_away_yellow'              => 0,
			'game_away_red'                 => 0,
			'game_info_id'                  => array(),
			'team_id'                       => array(),
			'game_info_home_score'          => array(),
			'game_info_away_score'          => array(),
			'game_info_event'               => array(),
			'game_info_time'                => array(),
			'player_id'                     => array(),
			'secondary_player_id'           => array(),
			'game_stats_player_id'          => array(),
			'game_team_id'                  => array(),
			'game_player_id'                => array(),
			'game_player_minutes'           => array(),
			'game_player_goals'             => array(),
			'game_player_assists'           => array(),
			'game_player_shots'             => array(),
			'game_player_sog'               => array(),
			'game_player_fouls'             => array(),
			'game_player_fouls_suffered'    => array(),
			'game_player_shots_faced'       => array(),
			'game_player_shots_saved'       => array(),
			'game_player_goals_allowed'     => array(),

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
				'game_id'                       => intval( $game['game_id'] ),
				'game_week'                     => intval( $game['game_week'] ),
				'game_day'                      => wp_filter_nohtml_kses( sanitize_text_field( $game['game_day'] ) ),
				'game_season'                   => wp_filter_nohtml_kses( sanitize_text_field( $game['game_season'] ) ),
				'game_home_id'                  => intval( $game['game_home_id'] ),
				'game_away_id'                  => intval( $game['game_away_id'] ),
				'game_home_final'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_final'] ) ),
				'game_away_final'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_final'] ) ),
				'game_attendance'               => intval( $game['game_attendance'] ),
				'game_status'                   => wp_filter_nohtml_kses( sanitize_text_field( $game['game_status'] ) ),
				'game_current_period'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_period'] ) ),
				'game_current_time'             => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_time'] ) ),
				'game_current_home_score'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_home_score'] ) ),
				'game_current_away_score'       => wp_filter_nohtml_kses( sanitize_text_field( $game['game_current_away_score'] ) ),
				'game_neutral_site'             => intval( $game['game_neutral_site'] ),
				'game_location_stadium'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_stadium'] ) ),
				'game_location_line_one'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_one'] ) ),
				'game_location_line_two'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_line_two'] ) ),
				'game_location_city'            => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_city'] ) ),
				'game_location_state'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_state'] ) ),
				'game_location_country'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_country'] ) ),
				'game_location_zip_code'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_location_zip_code'] ) ),
				'game_home_first_half'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_first_half'] ) ),
				'game_home_second_half'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_second_half'] ) ),
				'game_home_extratime'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_extratime'] ) ),
				'game_home_pks'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_pks'] ) ),
				'game_away_first_half'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_first_half'] ) ),
				'game_away_second_half'         => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_second_half'] ) ),
				'game_away_extratime'           => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_extratime'] ) ),
				'game_away_pks'                 => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_pks'] ) ),
				'game_home_possession'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_possession'] ) ),
				'game_home_shots'               => intval( $game['game_home_shots'] ),
				'game_home_sog'                 => intval( $game['game_home_sog'] ),
				'game_home_corners'             => intval( $game['game_home_corners'] ),
				'game_home_offsides'            => intval( $game['game_home_offsides'] ),
				'game_home_fouls'               => intval( $game['game_home_fouls'] ),
				'game_home_saves'               => intval( $game['game_home_saves'] ),
				'game_home_yellow'              => intval( $game['game_home_yellow'] ),
				'game_home_red'                 => intval( $game['game_home_red'] ),
				'game_away_possession'          => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_possession'] ) ),
				'game_away_shots'               => intval( $game['game_away_shots'] ),
				'game_away_sog'                 => intval( $game['game_away_sog'] ),
				'game_away_corners'             => intval( $game['game_away_corners'] ),
				'game_away_offsides'            => intval( $game['game_away_offsides'] ),
				'game_away_fouls'               => intval( $game['game_away_fouls'] ),
				'game_away_saves'               => intval( $game['game_away_saves'] ),
				'game_away_yellow'              => intval( $game['game_away_yellow'] ),
				'game_away_red'                 => intval( $game['game_away_red'] ),
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

		$team_ids = $game['team_id'];
		unset( $game['team_id'] );

		$game_info_home_scores = $game['game_info_home_score'];
		unset( $game['game_info_home_score'] );

		$game_info_away_scores = $game['game_info_away_score'];
		unset( $game['game_info_away_score'] );

		$game_info_events = $game['game_info_event'];
		unset( $game['game_info_event'] );

		$game_info_times = $game['game_info_time'];
		unset( $game['game_info_time'] );

		$player_ids = $game['player_id'];
		unset( $game['player_id'] );

		$game_info_assists = $game['secondary_player_id'];
		unset( $game['secondary_player_id'] );

		if ( $team_ids ) {
			$len = count( $team_ids );
		} else {
			$len = 0;
		}

		$events = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $player_ids[ $i ] ) ) {
				if ( isset( $game_info_ids[ $i ] ) ) {
					$gi_id = $game_info_ids[ $i ];
				} else {
					$gi_id = '';
				}
				if ( $game_info_assists[ $i ] == null ) {
					$assists = '';
				} else {
					$assists = $game_info_assists[ $i ];
				}
				$event = array(
					'game_info_id'         => intval( $gi_id ),
					'game_id'              => intval( $game['game_id'] ),
					'team_id'              => intval( $team_ids[ $i ] ),
					'game_info_home_score' => intval( $game_info_home_scores[ $i ] ),
					'game_info_away_score' => intval( $game_info_away_scores[ $i ] ),
					'game_info_event'      => wp_filter_nohtml_kses( sanitize_text_field( $game_info_events[ $i ] ) ),
					'game_info_time'       => wp_filter_nohtml_kses( sanitize_text_field( $game_info_times[ $i ] ) ),
					'player_id'            => intval( $player_ids[ $i ] ),
					'game_player_name'     => '',
					'secondary_player_id'  => intval( $assists ),
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

		foreach ( $events as $event ) {
			if ( '' !== $event['team_id'] ) {
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

		if ( '' === $game['game_home_extratime'] ) {
			$game['game_home_extratime'] = null;
		}

		if ( '' === $game['game_home_pks'] ) {
			$game['game_home_pks'] = null;
		}

		if ( '' === $game['game_away_extratime'] ) {
			$game['game_away_extratime'] = null;
		}

		if ( '' === $game['game_away_pks'] ) {
			$game['game_away_pks'] = null;
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

		$game_player_minutes = $game['game_player_minutes'];
		unset( $game['game_player_minutes'] );

		$game_player_goals = $game['game_player_goals'];
		unset( $game['game_player_goals'] );

		$game_player_assists = $game['game_player_assists'];
		unset( $game['game_player_assists'] );

		$game_player_shots = $game['game_player_shots'];
		unset( $game['game_player_shots'] );

		$game_player_sog = $game['game_player_sog'];
		unset( $game['game_player_sog'] );

		$game_player_fouls = $game['game_player_fouls'];
		unset( $game['game_player_fouls'] );

		$game_player_fouls_suffered = $game['game_player_fouls_suffered'];
		unset( $game['game_player_fouls_suffered'] );

		$game_player_shots_faced = $game['game_player_shots_faced'];
		unset( $game['game_player_shots_faced'] );

		$game_player_shots_saved = $game['game_player_shots_saved'];
		unset( $game['game_player_shots_saved'] );

		$game_player_goals_allowed = $game['game_player_goals_allowed'];
		unset( $game['game_player_goals_allowed'] );

		//* Loop through each of the player stats and add it to the array of stats to be added or updated
		if ( is_array( $team_ids ) ) {
			$len = count( $team_ids );
		} else {
			$len = 0;
		}
		$stats = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_stats_player_ids[ $i ] ) ) {
				$gs_id = $game_stats_player_ids[ $i ];
			} else {
				$gs_id = '';
			}
			if ( $game_player_assists[ $i ] == null ) {
				$assists = '';
			} else {
				$assists = $game_player_assists[ $i ];
			}
			if ( '' !== $player_ids[ $i ] ) {
				$stat = array(
					'game_stats_player_id'       => intval( $gs_id ),
					'game_id'                    => intval( $game['game_id'] ),
					'game_team_id'               => intval( $team_ids[ $i ] ),
					'game_player_id'             => intval( $player_ids[ $i ] ),
					'game_player_minutes'        => intval( $game_player_minutes[ $i ] ),
					'game_player_goals'          => intval( $game_player_goals[ $i ] ),
					'game_player_assists'        => intval( $assists ),
					'game_player_shots'          => intval( $game_player_shots[ $i ] ),
					'game_player_sog'            => intval( $game_player_sog[ $i ] ),
					'game_player_fouls'          => intval( $game_player_fouls[ $i ] ),
					'game_player_fouls_suffered' => intval( $game_player_fouls_suffered[ $i ] ),
					'game_player_shots_faced'    => intval( $game_player_shots_faced[ $i ] ),
					'game_player_shots_saved'    => intval( $game_player_shots_saved[ $i ] ),
					'game_player_goals_allowed'  => intval( $game_player_goals_allowed[ $i ] ),
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
			if ( $event->secondary_player_id == null ) {
				$assists = '';
			} else {
				$assists = $event->secondary_player_id;
			}
			$event_array = array(
				'game_info_id'         => $event->game_info_id,
				'game_id'              => $event->game_id,
				'team_id'              => $event->team_id,
				'game_info_home_score' => $event->game_info_home_score,
				'game_info_away_score' => $event->game_info_away_score,
				'game_info_event'      => $event->game_info_event,
				'game_info_time'       => $event->game_info_time,
				'player_id'            => $event->player_id,
				'game_player_name'     => $event->game_player_name,
				'secondary_player_id'  => $assists,
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
					'game_stats_player_id'       => $stat->game_stats_player_id,
					'game_id'                    => $stat->game_id,
					'game_team_id'               => $stat->game_team_id,
					'game_player_id'             => $stat->game_player_id,
					'game_player_minutes'        => $stat->game_player_minutes,
					'game_player_goals'          => $stat->game_player_goals,
					'game_player_assists'        => $stat->game_player_assists,
					'game_player_shots'          => $stat->game_player_shots,
					'game_player_sog'            => $stat->game_player_sog,
					'game_player_fouls'          => $stat->game_player_fouls,
					'game_player_fouls_suffered' => $stat->game_player_fouls_suffered,
					'game_player_shots_faced'    => $stat->game_player_shots_faced,
					'game_player_shots_saved'    => $stat->game_player_shots_saved,
					'game_player_goals_allowed'  => $stat->game_player_goals_allowed,
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
					<th class="center"><?php esc_html_e( '1H', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( '2H', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'ET', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'PKs', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-half" name="game_away_first_half" value="<?php echo esc_attr( $game['game_away_first_half'] ); ?>"/></td>
					<td><label for="away-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-half" name="game_away_second_half" value="<?php echo esc_attr( $game['game_away_second_half'] ); ?>" /></td>
					<td><label for="away-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-extra-time" name="game_away_extratime" value="<?php echo esc_attr( $game['game_away_extratime'] ); ?>" /></td>
					<td><label for="away-team-pks" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-team-pks" name="game_away_pks" value="<?php echo esc_attr( $game['game_away_pks'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Home Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-half" name="game_home_first_half" value="<?php echo esc_attr( $game['game_home_first_half'] ); ?>" /></td>
					<td><label for="home-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-half" name="game_home_second_half" value="<?php echo esc_attr( $game['game_home_second_half'] ); ?>" /></td>
					<td><label for="home-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Home Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-extra-time" name="game_home_extratime" value="<?php echo esc_attr( $game['game_home_extratime'] ); ?>" /></td>
					<td><label for="home-team-pks" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-team-pks" name="game_home_pks" value="<?php echo esc_attr( $game['game_home_pks'] ); ?>" /></td>
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
						<td><?php esc_html_e( 'Possesion', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="number" id="away-team-possession" name="game_away_possession" value="<?php echo esc_attr( $game['game_away_possession'] ); ?>" /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="number" id="home-team-possession" name="game_home_possession" value="<?php echo esc_attr( $game['game_home_possession'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Shots', 'sports-bench' ); ?></td>
						<td><label for="away-team-shots" class="screen-reader-text"><?php esc_html_e( 'Away Team Shots ', 'sports-bench' ); ?></label><input type="number" id="away-team-shots" name="game_away_shots" value="<?php echo esc_attr( $game['game_away_shots'] ); ?>" /></td>
						<td><label for="home-team-shots" class="screen-reader-text"><?php esc_html_e( 'Home Team Shots ', 'sports-bench' ); ?></label><input type="number" id="home-team-shots" name="game_home_shots" value="<?php echo esc_attr( $game['game_home_shots'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Shots on Goal', 'sports-bench' ); ?></td>
						<td><label for="away-team-sog" class="screen-reader-text"><?php esc_html_e( 'Away Team Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-team-sog" name="game_away_sog" value="<?php echo esc_attr( $game['game_away_sog'] ); ?>" /></td>
						<td><label for="home-team-sog" class="screen-reader-text"><?php esc_html_e( 'Home Team Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-team-sog" name="game_home_sog" value="<?php echo esc_attr( $game['game_home_sog'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Corners', 'sports-bench' ); ?></td>
						<td><label for="away-team-corners" class="screen-reader-text"><?php esc_html_e( 'Away Team Corners ', 'sports-bench' ); ?></label><input type="number" id="away-team-corners" name="game_away_corners" value="<?php echo esc_attr( $game['game_away_corners'] ); ?>" /></td>
						<td><label for="home-team-corners" class="screen-reader-text"><?php esc_html_e( 'Home Team Corners ', 'sports-bench' ); ?></label><input type="number" id="home-team-corners" name="game_home_corners" value="<?php echo esc_attr( $game['game_home_corners'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offsides', 'sports-bench' ); ?></td>
						<td><label for="away-team-offsides" class="screen-reader-text"><?php esc_html_e( 'Away Team Offsides ', 'sports-bench' ); ?></label><input type="number" id="away-team-offsides" name="game_away_offsides" value="<?php echo esc_attr( $game['game_away_offsides'] ); ?>" /></td>
						<td><label for="home-team-offsides" class="screen-reader-text"><?php esc_html_e( 'Home Team Offsides ', 'sports-bench' ); ?></label><input type="number" id="home-team-offsides" name="game_home_offsides" value="<?php echo esc_attr( $game['game_home_offsides'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></td>
						<td><label for="away-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Away Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-team-fouls" name="game_away_fouls" value="<?php echo esc_attr( $game['game_away_fouls'] ); ?>" /></td>
						<td><label for="home-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Home Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-team-fouls" name="game_home_fouls" value="<?php echo esc_attr( $game['game_home_fouls'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Saves', 'sports-bench' ); ?></td>
						<td><label for="away-team-saves" class="screen-reader-text"><?php esc_html_e( 'Away Team Saves ', 'sports-bench' ); ?></label><input type="number" id="away-team-saves" name="game_away_saves" value="<?php echo esc_attr( $game['game_away_saves'] ); ?>" /></td>
						<td><label for="home-team-saves" class="screen-reader-text"><?php esc_html_e( 'Home Team Saves ', 'sports-bench' ); ?></label><input type="number" id="home-team-saves" name="game_home_saves" value="<?php echo esc_attr( $game['game_home_saves'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yellow-cards" name="game_away_yellow" value="<?php echo esc_attr( $game['game_away_yellow'] ); ?>" /></td>
						<td><label for="home-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yellow-cards" name="game_home_yellow" value="<?php echo esc_attr( $game['game_home_yellow'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-red-cards" name="game_away_red" value="<?php echo esc_attr( $game['game_away_red'] ); ?>" /></td>
						<td><label for="home-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-red-cards" name="game_home_red" value="<?php echo esc_attr( $game['game_home_red'] ); ?>" /></td>
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
	public function edit_game_events( $events, $game ) {
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
			<table id="in-progress-fields" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></th>
						<th><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></th>
						<th><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="field one-column">
							<label for="game-away-current-score" class="screen-reader-text"><?php esc_html_e( 'Away Team Current Score', 'sports-bench' ); ?></label>
							<input type="number" id="game-away-current-score" name="game_current_away_score" value="<?php echo esc_attr( $game['game_current_away_score'] ); ?>" />
						</td>
						<td class="field one-column">
							<label for="game-home-current-score" class="screen-reader-text"><?php esc_html_e( 'Home Team Current Score', 'sports-bench' ); ?></label>
							<input type="number" id="game-home-current-score" name="game_current_home_score" value="<?php echo esc_attr( $game['game_current_home_score'] ); ?>" />
						</td>
						<td class="field one-column">
							<label for="game-current-time" class="screen-reader-text"><?php esc_html_e( 'Current Time in Match', 'sports-bench' ); ?></label>
							<input type="text" id="game-current-time" name="game_current_time" value="<?php echo esc_attr( stripslashes( $game['game_current_time'] ) ); ?>" />
							<input type="hidden" name="game_current_period" value="<?php echo esc_attr( $game['game_current_period'] ); ?>" />
						</td>
					</tr>
				</tbody>
			</table>

			<table id="match-events" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Event', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Primary Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Secondary Player', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $events ) {
						foreach ( $events as $event ) {
							$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
							$team_id    = $event['team_id'];
							$quer       = "SELECT * FROM $table_name WHERE team_id = $team_id;";
							$players    = Database::get_results( $quer );
							$player_ids = [];
							foreach ( $players as $player ) {
								$player_ids[] = $player->player_id;
							}

							if ( in_array( $event['game_info_event'], [ 'pk-given', 'foul', 'shot-saved' ] ) ) {
								if ( $game['game_away_id'] === $team_id ) {
									$opp_team_id = $game['game_home_id'];
								} else {
									$opp_team_id = $game['game_away_id'];
								}
								$quer       = "SELECT * FROM $table_name WHERE team_id = $opp_team_id;";
								$opp_players    = Database::get_results( $quer );
								$opp_player_ids = [];
								foreach ( $opp_players as $player ) {
									$opp_player_ids[] = $player->player_id;
								}
							} elseif ( 'goal' === $event['game_info_event'] || 'Goal' === $event['game_info_event'] ) {
								$opp_players    = $players;
								$opp_player_ids = $player_ids;
							} else {
								$opp_players    = [];
								$opp_player_ids = [];
							}
							?>
							<tr class="game-event-row">
								<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><br />
									<input type="hidden" name="game_info_id[]" value="<?php echo esc_attr( $event['game_info_id'] ); ?>" />
									<select id="match-event-team" name="team_id[]" class="team">
										<?php
										if ( ! in_array( $event['team_id'], $team_ids ) ) {
											$the_team = new Team( (int) $event['team_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_team->get_team_id() ) . '">' . esc_html( $the_team->get_team_name() ) . '</option>';
										}
										if ( $teams ) {
											foreach ( $teams as $team ) {
												?>
												<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $event['team_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_location() ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-home-score" name="game_info_home_score[]" value="<?php echo esc_attr( $event['game_info_home_score'] ); ?>" /></td>
								<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-away-score" name="game_info_away_score[]" value="<?php echo esc_attr( $event['game_info_away_score'] ); ?>" /></td>
								<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-time" name="game_info_time[]" value="<?php echo esc_attr( $event['game_info_time'] ); ?>" /></td>
								<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label><br />
									<select id="match-event" name="game_info_event[]" class="match-event-category">
										<option value=""
											<?php
											if ( in_array( $event['game_info_event'], [ '' ] ) ) {
												echo 'selected="selected"';
											}
											?>
										>
											<?php esc_html_e( 'Select Event', 'sports-bench' ); ?>
										</option>
										<option value="goal"
											<?php
											if ( in_array( $event['game_info_event'], [ 'Goal', 'goal' ] ) ) {
												echo 'selected="selected"';
											}
											?>
										>
											<?php esc_html_e( 'Goal', 'sports-bench' ); ?>
										</option>
										<option value="goal-pk"
											<?php
											if ( in_array( $event['game_info_event'], [ 'Goal (PK)', 'goal-pk' ] ) ) {
												echo 'selected="selected"';
											}
											?>
										>
											<?php esc_html_e( 'Goal (PK)', 'sports-bench' ); ?>
										</option>
										<option value="pk-given" <?php selected( $event['game_info_event'], 'pk-given' ); ?>><?php esc_html_e( 'Penalty Kick Awarded To', 'sports-bench' ); ?></option>
										<option value="corner-kick" <?php selected( $event['game_info_event'], 'corner-kick' ); ?>><?php esc_html_e( 'Corner Kick Conceeded', 'sports-bench' ); ?></option>
										<option value="foul" <?php selected( $event['game_info_event'], 'foul' ); ?>><?php esc_html_e( 'Foul', 'sports-bench' ); ?></option>
										<option value="shot-missed" <?php selected( $event['game_info_event'], 'shot-missed' ); ?>><?php esc_html_e( 'Shot Missed', 'sports-bench' ); ?></option>
										<option value="shot-saved" <?php selected( $event['game_info_event'], 'shot-saved' ); ?>><?php esc_html_e( 'Shot Saved', 'sports-bench' ); ?></option>
										<option value="offside" <?php selected( $event['game_info_event'], 'offside' ); ?>><?php esc_html_e( 'Offside', 'sports-bench' ); ?></option>
										<option value="yellow"
											<?php
											if ( in_array( $event['game_info_event'], [ 'Yellow', 'yellow' ] ) ) {
												echo 'selected="selected"';
											}
											?>
										>
											<?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?>
										</option>
										<option value="red"
											<?php
											if ( in_array( $event['game_info_event'], [ 'Red', 'red' ] ) ) {
												echo 'selected="selected"';
											}
											?>
										>
											<?php esc_html_e( 'Red Card', 'sports-bench' ); ?>
										</option>
									</select>
								</td>
								<td>
									<label for="match-event-player" class="showed-label">
										<span class="primary-player-label goal-scored <?php if ( 'Goal' === $event['game_info_event'] || 'goal' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
										<span class="primary-player-label pk-goal-scored <?php if ( 'Goal (PK)' === $event['game_info_event'] || 'goal-pk' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
										<span class="primary-player-label pk-awarded <?php if ( 'pk-given' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Player Awarded PK', 'sports-bench' ); ?></span>
										<span class="primary-player-label ck-conceeded <?php if ( 'corner-kick' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Player Who Conceeded Corner Kick', 'sports-bench' ); ?></span>
										<span class="primary-player-label foul-given <?php if ( 'foul' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Fouling Player', 'sports-bench' ); ?></span>
										<span class="primary-player-label shot-missed <?php if ( 'shot-missed' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
										<span class="primary-player-label shot-saved <?php if ( 'shot-saved' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
										<span class="primary-player-label offside <?php if ( 'offside' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Player Offside', 'sports-bench' ); ?></span>
										<span class="primary-player-label card-given <?php if ( 'Yellow' === $event['game_info_event'] || 'yellow' === $event['game_info_event'] || 'Red' === $event['game_info_event'] || 'red' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Player Given Card', 'sports-bench' ); ?></span>
									</label>
									<br />
									<select id="match-event-player" name="player_id[]">
										<?php
										if ( ! in_array( $event['player_id'], $player_ids ) ) {
											$the_player = new Player( (int) $event['player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $players ) {
											foreach ( $players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $event['player_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
									</td>
								<td>
									<label for="match-event-secondary" class="<?php if ( 'Goal' === $event['game_info_event'] || 'goal' === $event['game_info_event'] || 'pk-given' === $event['game_info_event'] || 'foul' === $event['game_info_event'] || 'shot-saved' === $event['game_info_event'] ) { echo esc_attr( 'showed-label' ); } ?>">
										<span class="secondary-player-label goal-scored <?php if ( 'Goal' === $event['game_info_event'] || 'goal' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Primary Assist', 'sports-bench' ); ?></span>
										<span class="secondary-player-label pk-awarded <?php if ( 'pk-given' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Player Who Gave Up PK', 'sports-bench' ); ?></span>
										<span class="secondary-player-label foul-given <?php if ( 'foul' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Fouled Player', 'sports-bench' ); ?></span>
										<span class="secondary-player-label shot-saved <?php if ( 'shot-saved' === $event['game_info_event'] ) { echo esc_attr( 'show' ); } ?>"><?php esc_html_e( 'Keeper Who Saved Shot', 'sports-bench' ); ?></span>
									</label>
									<br />
									<select id="match-event-secondary" name="secondary_player_id[]">
										<?php
										if ( ! is_numeric( $event['secondary_player_id'] ) ) {
											$the_player = new Player( str_replace(' ', '-', strtolower( $event['secondary_player_id'] ) ) );
											$event['secondary_player_id'] = $the_player->get_player_id();
										}
										if ( ! in_array( $event['secondary_player_id'], $opp_player_ids ) ) {
											$the_player = new Player( (int) $event['secondary_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name() ) . '</option>';
										}
										if ( $opp_players ) {
											foreach ( $opp_players as $player ) {
												?>
												<option value="<?php echo esc_attr( $player->player_id ); ?>" <?php selected( $event['secondary_player_id'], $player->player_id ); ?>><?php echo esc_html( $player->player_first_name . ' ' . $player->player_last_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</td>
								<td><br /><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row">
						<td>
							<input type="hidden" name="game_info_id[]" />
							<label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
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
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<select id="match-event" name="game_info_event[]" class="match-event-category">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="goal"><?php esc_html_e( 'Goal', 'sports-bench' ); ?></option>
								<option value="goal-pk"><?php esc_html_e( 'Goal (PK)', 'sports-bench' ); ?></option>
								<option value="pk-given"><?php esc_html_e( 'Penalty Kick Awarded To', 'sports-bench' ); ?></option>
								<option value="corner-kick"><?php esc_html_e( 'Corner Kick Conceeded', 'sports-bench' ); ?></option>
								<option value="foul"><?php esc_html_e( 'Foul', 'sports-bench' ); ?></option>
								<option value="shot-missed"><?php esc_html_e( 'Shot Missed', 'sports-bench' ); ?></option>
								<option value="shot-saved"><?php esc_html_e( 'Shot Saved', 'sports-bench' ); ?></option>
								<option value="offside"><?php esc_html_e( 'Offside', 'sports-bench' ); ?></option>
								<option value="yellow"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="red"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td>
							<label for="match-event-player">
								<span class="primary-player-label goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-awarded"><?php esc_html_e( 'Player Awarded PK', 'sports-bench' ); ?></span>
								<span class="primary-player-label ck-conceeded"><?php esc_html_e( 'Player Who Conceeded Corner Kick', 'sports-bench' ); ?></span>
								<span class="primary-player-label foul-given"><?php esc_html_e( 'Fouling Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-missed"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-saved"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label offside"><?php esc_html_e( 'Player Offside', 'sports-bench' ); ?></span>
								<span class="primary-player-label card-given"><?php esc_html_e( 'Player Given Card', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-player" name="player_id[]"></select>
						</td>
						<td>
							<label for="match-event-secondary">
								<span class="secondary-player-label goal-scored"><?php esc_html_e( 'Primary Assist', 'sports-bench' ); ?></span>
								<span class="secondary-player-label pk-awarded"><?php esc_html_e( 'Player Who Gave Up PK', 'sports-bench' ); ?></span>
								<span class="secondary-player-label foul-given"><?php esc_html_e( 'Fouled Player', 'sports-bench' ); ?></span>
								<span class="secondary-player-label shot-saved"><?php esc_html_e( 'Keeper Who Saved Shot', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select type="text" id="match-event-secondary" name="secondary_player_id[]"></select>
						</td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
						<?php
					}
					?>
					<tr class="game-event-empty-row screen-reader-text">
						<td>
							<input type="hidden" name="game_info_id[]" class="new-field" disabled="disabled" />
							<label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><br />
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
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><br /><input type="number" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label><br />
							<select id="match-event" name="game_info_event[]" class="new-field match-event-category" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="goal"><?php esc_html_e( 'Goal', 'sports-bench' ); ?></option>
								<option value="goal-pk"><?php esc_html_e( 'Goal (PK)', 'sports-bench' ); ?></option>
								<option value="pk-given"><?php esc_html_e( 'Penalty Kick Awarded To', 'sports-bench' ); ?></option>
								<option value="corner-kick"><?php esc_html_e( 'Corner Kick Conceeded', 'sports-bench' ); ?></option>
								<option value="foul"><?php esc_html_e( 'Foul', 'sports-bench' ); ?></option>
								<option value="shot-missed"><?php esc_html_e( 'Shot Missed', 'sports-bench' ); ?></option>
								<option value="shot-saved"><?php esc_html_e( 'Shot Saved', 'sports-bench' ); ?></option>
								<option value="offside"><?php esc_html_e( 'Offside', 'sports-bench' ); ?></option>
								<option value="yellow"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="red"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td>
							<label for="match-event-player">
								<span class="primary-player-label goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-goal-scored"><?php esc_html_e( 'Scorer', 'sports-bench' ); ?></span>
								<span class="primary-player-label pk-awarded"><?php esc_html_e( 'Player Awarded PK', 'sports-bench' ); ?></span>
								<span class="primary-player-label ck-conceeded"><?php esc_html_e( 'Player Who Conceeded Corner Kick', 'sports-bench' ); ?></span>
								<span class="primary-player-label foul-given"><?php esc_html_e( 'Fouling Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-missed"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label shot-saved"><?php esc_html_e( 'Shooting Player', 'sports-bench' ); ?></span>
								<span class="primary-player-label offside"><?php esc_html_e( 'Player Offside', 'sports-bench' ); ?></span>
								<span class="primary-player-label card-given"><?php esc_html_e( 'Player Given Card', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select>
						</td>
						<td>
							<label for="match-event-secondary">
								<span class="secondary-player-label goal-scored"><?php esc_html_e( 'Primary Assist', 'sports-bench' ); ?></span>
								<span class="secondary-player-label pk-awarded"><?php esc_html_e( 'Player Who Gave Up PK', 'sports-bench' ); ?></span>
								<span class="secondary-player-label foul-given"><?php esc_html_e( 'Fouled Player', 'sports-bench' ); ?></span>
								<span class="secondary-player-label shot-saved"><?php esc_html_e( 'Keeper Who Saved Shot', 'sports-bench' ); ?></span>
							</label>
							<br />
							<select type="text" id="match-event-secondary" name="secondary_player_id[]" class="new-field" disabled="disabled"></select>
						</td>
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
		$players = [];
		$keepers = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_away_id'] ) {
					if ( ( $player_stat['game_player_shots_faced'] > 0 ) || ( $player_stat['game_player_shots_saved'] > 0 ) || ( $player_stat['game_player_goals_allowed'] > 0 ) ) {
						array_push( $keepers, $player_stat );
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
			<h3><?php esc_html_e( 'Outfield Players', 'sports-bench' ); ?></h3>
			<table id="away-player-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls Suffered', 'sports-bench' ); ?></th>
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
								<td>
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
								<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $player['game_player_minutes'] ); ?>" /></td>
								<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" value="<?php echo esc_attr( $player['game_player_goals'] ); ?>" /></td>
								<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="away-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots" name="game_player_shots[]" value="<?php echo esc_attr( $player['game_player_shots'] ); ?>" /></td>
								<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" value="<?php echo esc_attr( $player['game_player_sog'] ); ?>" /></td>
								<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" value="<?php echo esc_attr( $player['game_player_fouls'] ); ?>" /></td>
								<td><label for="away-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-suffered" name="game_player_fouls_suffered[]" value="<?php echo esc_attr( $player['game_player_fouls_suffered'] ); ?>" /></td>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_shots_faced[]" value="<?php echo esc_attr( $player['game_player_shots_faced'] ); ?>" />
								<input type="hidden" name="game_player_shots_saved[]" value="<?php echo esc_attr( $player['game_player_shots_saved'] ); ?>" />
								<input type="hidden" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $player['game_player_goals_allowed'] ); ?>" />
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
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
							<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" /></td>
							<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
							<td><label for="away-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots" name="game_player_shots[]" /></td>
							<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" /></td>
							<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" /></td>
							<td><label for="away-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-suffered" name="game_player_fouls_suffered[]" /></td>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_shots_faced[]" />
							<input type="hidden" name="game_player_shots_saved[]" />
							<input type="hidden" name="game_player_goals_allowed[]" />
						</tr>
						<?php
					}
					?>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="away-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-suffered" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots_saved[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-away-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Keepers', 'sports-bench' ); ?></h3>
			<table id="away-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Saves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $keepers ) {
						foreach ( $keepers as $keeper ) {
							?>
							<tr class="game-away-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $keeper['game_stats_player_id'] ); ?>" />
								<input class="away-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $keeper['game_team_id'] ); ?>" />
								<td>
									<label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="away-player" class="away-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $keeper['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $keeper['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->player_id ) . '">' . esc_html( $the_player->player_first_name ) . ' ' . esc_html( $the_player->player_last_name ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $keeper['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $keeper['game_player_minutes'] ); ?>" /></td>
								<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" value="<?php echo esc_attr( $keeper['game_player_shots_faced'] ); ?>" /></td>
								<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_shots_saved[]" value="<?php echo esc_attr( $keeper['game_player_shots_saved'] ); ?>" /></td>
								<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $keeper['game_player_goals_allowed'] ); ?>" /></td>
								<input type="hidden" name="game_player_goals[]" value="<?php echo esc_attr( $keeper['game_player_goals'] ); ?>" />
								<input type="hidden" name="game_player_assists[]" value="<?php echo esc_attr( $keeper['game_player_assists'] ); ?>" />
								<input type="hidden" name="game_player_shots[]" value="<?php echo esc_attr( $keeper['game_player_shots'] ); ?>" />
								<input type="hidden" name="game_player_sog[]" value="<?php echo esc_attr( $keeper['game_player_sog'] ); ?>" />
								<input type="hidden" name="game_player_fouls[]" value="<?php echo esc_attr( $keeper['game_player_fouls'] ); ?>" />
								<input type="hidden" name="game_player_fouls_suffered[]" value="<?php echo esc_attr( $keeper['game_player_fouls_suffered'] ); ?>" />
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-away-2-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="away-player-team" type="hidden" name="game_team_id[]" />
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
							<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" /></td>
							<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_shots_saved[]" /></td>
							<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
							<input type="hidden" name="game_player_goals[]" />
							<input type="hidden" name="game_player_assists[]" />
							<input type="hidden" name="game_player_shots[]" />
							<input type="hidden" name="game_player_sog[]" />
							<input type="hidden" name="game_player_fouls[]" />
							<input type="hidden" name="game_player_fouls_suffered[]" />
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
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
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="away-player-shots-saved" name="game_player_shots_saved[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" />
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
		$keepers = [];
		if ( $stats ) {
			foreach ( $stats as $player_stat ) {
				if ( $player_stat['game_team_id'] === $game['game_home_id'] ) {
					if ( ( $player_stat['game_player_shots_faced'] > 0 ) || ( $player_stat['game_player_shots_saved'] > 0 ) || ( $player_stat['game_player_goals_allowed'] > 0 ) ) {
						array_push( $keepers, $player_stat );
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
			<h3><?php esc_html_e( 'Outfield Players', 'sports-bench' ); ?></h3>
			<table id="home-player-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'SOG', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Fouls Suffered', 'sports-bench' ); ?></th>
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
								<td>
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
								<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $player['game_player_minutes'] ); ?>" /></td>
								<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" value="<?php echo esc_attr( $player['game_player_goals'] ); ?>" /></td>
								<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="home-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots" name="game_player_shots[]" value="<?php echo esc_attr( $player['game_player_shots'] ); ?>" /></td>
								<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" value="<?php echo esc_attr( $player['game_player_sog'] ); ?>" /></td>
								<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" value="<?php echo esc_attr( $player['game_player_fouls'] ); ?>" /></td>
								<td><label for="home-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-suffered" name="game_player_fouls_suffered[]" value="<?php echo esc_attr( $player['game_player_fouls_suffered'] ); ?>" /></td>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
								<input type="hidden" name="game_player_shots_faced[]" value="<?php echo esc_attr( $player['game_player_shots_faced'] ); ?>" />
								<input type="hidden" name="game_player_shots_saved[]" value="<?php echo esc_attr( $player['game_player_shots_saved'] ); ?>" />
								<input type="hidden" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $player['game_player_goals_allowed'] ); ?>" />
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-1-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
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
							<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" /></td>
							<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
							<td><label for="home-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots" name="game_player_shots[]" /></td>
							<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" /></td>
							<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" /></td>
							<td><label for="home-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-suffered" name="game_player_fouls_suffered[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							<input type="hidden" name="game_player_shots_faced[]" />
							<input type="hidden" name="game_player_shots_saved[]" />
							<input type="hidden" name="game_player_goals_allowed[]" />
						</tr>
						<?php
					}
					?>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
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
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots" name="game_player_shots[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-sog" class="screen-reader-text"><?php esc_html_e( 'Shots on Goal ', 'sports-bench' ); ?></label><input type="number" id="home-player-sog" name="game_player_sog[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls-suffered" class="screen-reader-text"><?php esc_html_e( 'Fouls Suffered ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-suffered" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_shots_faced[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots_saved[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
			<h3><?php esc_html_e( 'Keepers', 'sports-bench' ); ?></h3>
			<table id="home-keeper-stats" class="form-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Minutes', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Shots Faced', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Saves', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Goals Allowed', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php
					if ( $keepers ) {
						foreach ( $keepers as $keeper ) {
							?>
							<tr class="game-home-2-row">
								<input type="hidden" name="game_stats_player_id[]" value="<?php echo esc_attr( $keeper['game_stats_player_id'] ); ?>" />
								<input class="home-player-team" type="hidden" name="game_team_id[]" value="<?php echo esc_attr( $keeper['game_team_id'] ); ?>" />
								<td>
									<label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label>
									<select id="home-player" class="home-player" name="game_player_id[]">
										<?php
										if ( ! in_array( $keeper['game_player_id'], $player_ids ) ) {
											$the_player = new Player( $keeper['game_player_id'] );
											echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
										}

										foreach ( $player_list as $single_player ) {
											if ( $keeper['game_player_id'] === $single_player['player_id'] ) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
											echo '<option ' . esc_html( $selected ) . ' value="' . esc_attr( $single_player['player_id'] ) . '">' . esc_html( $single_player['player_name'] ) . '</option>';
										}
										?>
									</select>
								</td>
								<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $keeper['game_player_minutes'] ); ?>" /></td>
								<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" value="<?php echo esc_attr( $keeper['game_player_shots_faced'] ); ?>" /></td>
								<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_shots_saved[]" value="<?php echo esc_attr( $keeper['game_player_shots_saved'] ); ?>" /></td>
								<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" value="<?php echo esc_attr( $keeper['game_player_goals_allowed'] ); ?>" /></td>
								<input type="hidden" name="game_player_goals[]" value="<?php echo esc_attr( $keeper['game_player_goals'] ); ?>" />
								<input type="hidden" name="game_player_assists[]" value="<?php echo esc_attr( $keeper['game_player_assists'] ); ?>" />
								<input type="hidden" name="game_player_shots[]" value="<?php echo esc_attr( $keeper['game_player_shots'] ); ?>" />
								<input type="hidden" name="game_player_sog[]" value="<?php echo esc_attr( $keeper['game_player_sog'] ); ?>" />
								<input type="hidden" name="game_player_fouls[]" value="<?php echo esc_attr( $keeper['game_player_fouls'] ); ?>" />
								<input type="hidden" name="game_player_fouls_suffered[]" value="<?php echo esc_attr( $keeper['game_player_fouls_suffered'] ); ?>" />
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-home-2-row">
							<input type="hidden" name="game_stats_player_id[]" />
							<input class="home-player-team" type="hidden" name="game_team_id[]" />
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
							<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" /></td>
							<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_shots_saved[]" /></td>
							<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" /></td>
							<input type="hidden" name="game_player_goals[]" />
							<input type="hidden" name="game_player_assists[]" />
							<input type="hidden" name="game_player_shots[]" />
							<input type="hidden" name="game_player_sog[]" />
							<input type="hidden" name="game_player_fouls[]" />
							<input type="hidden" name="game_player_fouls_suffered[]" />
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-home-2-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled"/>
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
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="number" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-faced" class="screen-reader-text"><?php esc_html_e( 'Shots Faced ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-faced" name="game_player_shots_faced[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-shots-saved" class="screen-reader-text"><?php esc_html_e( 'Shots Saved ', 'sports-bench' ); ?></label><input type="number" id="home-player-shots-saved" name="game_player_shots_saved[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals-allowed" class="screen-reader-text"><?php esc_html_e( 'Shots ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals-allowed" name="game_player_goals_allowed[]" class="new-field" disabled="disabled" /></td>
						<input type="hidden" name="game_player_goals[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_assists[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_shots[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_sog[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_player_fouls_suffered[]" class="new-field" disabled="disabled" />
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-2" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
