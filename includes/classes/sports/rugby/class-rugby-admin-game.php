<?php
/**
 * Creates the rugby game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Rugby;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The rugby game admin class.
 *
 * This is used for rugby game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new RugbyAdminGame object to be used.
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
					<th class="center"><?php esc_html_e( 'Shootout', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-half" name="game_away_first_half" /></td>
					<td><label for="away-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-half" name="game_away_second_half" /></td>
					<td><label for="away-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-extra-time" name="game_away_extratime" /></td>
					<td><label for="away-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Shootout ', 'sports-bench' ); ?></label><input type="number" id="away-team-shootout" name="game_away_shootout" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Home Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-half" name="game_home_first_half" /></td>
					<td><label for="home-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-half" name="game_home_second_half" /></td>
					<td><label for="home-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Home Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-extra-time" name="game_home_extratime" /></td>
					<td><label for="home-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Home Team Shootouts ', 'sports-bench' ); ?></label><input type="number" id="home-team-shootout" name="game_home_shootout" /></td>
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
						<td><?php esc_html_e( 'Tries', 'sports-bench' ); ?></td>
						<td><label for="away-team-tries" class="screen-reader-text"><?php esc_html_e( 'Away Team Tries ', 'sports-bench' ); ?></label><input type="number" id="away-team-tries" name="game_away_tries" /></td>
						<td><label for="home-team-tries" class="screen-reader-text"><?php esc_html_e( 'Home Team Tries ', 'sports-bench' ); ?></label><input type="number" id="home-team-tries" name="game_home_tries" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></td>
						<td><label for="away-team-conversions" class="screen-reader-text"><?php esc_html_e( 'Away Team Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-team-conversions" name="game_away_conversions" /></td>
						<td><label for="home-team-conversions" class="screen-reader-text"><?php esc_html_e( 'Home Team Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-team-conversions" name="game_home_conversions" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalty-goals" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalty-goals" name="game_away_penalty_goals" /></td>
						<td><label for="home-team-penalty-goals" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalty-goals" name="game_home_penalty_goals" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Percentage', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-percentage" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Percentage ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-percentage" name="game_away_kick_percentage" /></td>
						<td><label for="home-team-kick-percentage" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Percentage ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-percentage" name="game_home_kick_percentage" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kicks From Hand Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-hand-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Kicks From Hand Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-hand-meters" name="game_away_meters_hand" /></td>
						<td><label for="home-team-hand-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Kicks From Hand Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-hand-meters" name="game_home_meters_hand" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Pass Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-pass-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Pass Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-pass-meters" name="game_away_meters_pass" /></td>
						<td><label for="home-team-pass-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Pass Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-pass-meters" name="game_home_meters_pass" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Run Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-run-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Run Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-run-meters" name="game_away_meters_runs" /></td>
						<td><label for="home-team-run-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Run Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-run-meters" name="game_home_meters_runs" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Possession', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="number" id="away-team-possession" name="game_away_possession" /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="number" id="home-team-possession" name="game_home_possession" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Clean Breaks', 'sports-bench' ); ?></td>
						<td><label for="away-team-clean-breaks" class="screen-reader-text"><?php esc_html_e( 'Away Team Clean Breaks ', 'sports-bench' ); ?></label><input type="number" id="away-team-clean-breaks" name="game_away_clean_breaks" /></td>
						<td><label for="home-team-clean-breaks" class="screen-reader-text"><?php esc_html_e( 'Home Team Clean Breaks ', 'sports-bench' ); ?></label><input type="number" id="home-team-clean-breaks" name="game_home_clean_breaks" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Defenders Beaten', 'sports-bench' ); ?></td>
						<td><label for="away-team-defenders-beaten" class="screen-reader-text"><?php esc_html_e( 'Away Team Defenders Beaten ', 'sports-bench' ); ?></label><input type="number" id="away-team-defenders-beaten" name="game_away_defenders_beaten" /></td>
						<td><label for="home-team-defenders-beaten" class="screen-reader-text"><?php esc_html_e( 'Home Team Defenders Beaten ', 'sports-bench' ); ?></label><input type="number" id="home-team-defenders-beaten" name="game_home_defenders_beaten" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offload', 'sports-bench' ); ?></td>
						<td><label for="away-team-offload" class="screen-reader-text"><?php esc_html_e( 'Away Team Offload ', 'sports-bench' ); ?></label><input type="number" id="away-team-offload" name="game_away_offload" /></td>
						<td><label for="home-team-offload" class="screen-reader-text"><?php esc_html_e( 'Home Team Offload ', 'sports-bench' ); ?></label><input type="number" id="home-team-offload" name="game_home_offload" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Rucks', 'sports-bench' ); ?></td>
						<td><label for="away-team-rucks" class="screen-reader-text"><?php esc_html_e( 'Away Team Rucks ', 'sports-bench' ); ?></label><input type="number" id="away-team-rucks" name="game_away_rucks" /></td>
						<td><label for="home-team-rucks" class="screen-reader-text"><?php esc_html_e( 'Home Team Rucks ', 'sports-bench' ); ?></label><input type="number" id="home-team-rucks" name="game_home_rucks" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Mauls', 'sports-bench' ); ?></td>
						<td><label for="away-team-mauls" class="screen-reader-text"><?php esc_html_e( 'Away Team Mauls ', 'sports-bench' ); ?></label><input type="number" id="away-team-mauls" name="game_away_mauls" /></td>
						<td><label for="home-team-mauls" class="screen-reader-text"><?php esc_html_e( 'Home Team Mauls ', 'sports-bench' ); ?></label><input type="number" id="home-team-mauls" name="game_home_mauls" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-turnovers" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-turnovers" name="game_away_turnovers_conceeded" /></td>
						<td><label for="home-team-turnovers" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-turnovers" name="game_home_turnovers_conceeded" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Scrums', 'sports-bench' ); ?></td>
						<td><label for="away-team-scrums" class="screen-reader-text"><?php esc_html_e( 'Away Team Scrums ', 'sports-bench' ); ?></label><input type="number" id="away-team-scrums" name="game_away_scrums" /></td>
						<td><label for="home-team-scrums" class="screen-reader-text"><?php esc_html_e( 'Home Team Scrums ', 'sports-bench' ); ?></label><input type="number" id="home-team-scrums" name="game_home_scrums"/></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Lineouts', 'sports-bench' ); ?></td>
						<td><label for="away-team-lineouts" class="screen-reader-text"><?php esc_html_e( 'Away Team Lineouts ', 'sports-bench' ); ?></label><input type="number" id="away-team-lineouts" name="game_away_lineouts" /></td>
						<td><label for="home-team-lineouts" class="screen-reader-text"><?php esc_html_e( 'Home Team Lineouts ', 'sports-bench' ); ?></label><input type="number" id="home-team-lineouts" name="game_home_lineouts"/></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalties Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalties Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalties" name="game_away_penalties_conceeded" /></td>
						<td><label for="home-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalties Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalties" name="game_home_penalties_conceeded" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-red-cards" name="game_away_red_cards" /></td>
						<td><label for="home-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-red-cards" name="game_home_red_cards" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yellow-cards" name="game_away_yellow_cards" /></td>
						<td><label for="home-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yellow-cards" name="game_home_yellow_cards" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Kick Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-kicks" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Kick Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-kicks" name="game_away_free_kicks_conceeded" /></td>
						<td><label for="home-team-free-kicks" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Kick Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-kicks" name="game_home_free_kicks_conceeded" /></td>
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
						<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Event', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="remove"></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-event-row">
						<input type="hidden" id="match-event-home-score" name="game_info_id[]" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
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
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<select id="match-event" name="game_info_event[]">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="Try"><?php esc_html_e( 'Try', 'sports-bench' ); ?></option>
								<option value="Conversion"><?php esc_html_e( 'Conversion', 'sports-bench' ); ?></option>
								<option value="Drop Kick"><?php esc_html_e( 'Drop Kick', 'sports-bench' ); ?></option>
								<option value="Penalty Goal"><?php esc_html_e( 'Penalty Goal', 'sports-bench' ); ?></option>
								<option value="Yellow"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="Red"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" /></td>
						<td><label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label><select id="match-event-player" name="player_id[]"></select></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-event-empty-row screen-reader-text">
						<input type="hidden" name="game_info_id[]" class="new-field" disabled="disabled" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><select id="match-event-team" name="team_id[]" class="new-field team" disabled="disabled"></select></td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<select id="match-event" name="game_info_event[]" class="new-field" disabled="disabled">
							<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="Try"><?php esc_html_e( 'Try', 'sports-bench' ); ?></option>
								<option value="Conversion"><?php esc_html_e( 'Conversion', 'sports-bench' ); ?></option>
								<option value="Drop Kick"><?php esc_html_e( 'Drop Kick', 'sports-bench' ); ?></option>
								<option value="Penalty Goal"><?php esc_html_e( 'Penalty Goal', 'sports-bench' ); ?></option>
								<option value="Yellow Card"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="Red Card"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label><select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select></td>
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
			<table id="away-player-stats" class="form-table rugby-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tries', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Drop Kicks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Meters Run', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="away-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="away-player-tries" name="game_player_tries[]" /></td>
							<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
							<td><label for="away-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-player-conversions" name="game_player_conversions[]" /></td>
							<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_penalty_goals[]" /></td>
							<td><label for="away-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-player-drop-kicks" name="game_player_drop_kicks[]" /></td>
							<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
							<td><label for="away-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="away-player-penalties" name="game_player_penalties_conceeded[]" /></td>
							<td><label for="away-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="away-player-meters-run" name="game_player_meters_run[]" /></td>
							<td><label for="away-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-yellow" name="game_player_yellow_cards[]" /></td>
							<td><label for="away-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-red" name="game_player_red_cards[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="away-player-tries" name="game_player_tries[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-player-conversions" name="game_player_conversions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_penalty_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-player-drop-kicks" name="game_player_drop_kicks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="away-player-penalties" name="game_player_penalties_conceeded[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="away-player-meters-run" name="game_player_meters_run[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-yellow" name="game_player_yellow_cards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-red" name="game_player_red_cards[]" class="new-field" disabled="disabled" /></td>
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
			<table id="home-player-stats" class="form-table rugby-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tries', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Drop Kicks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Meters Run', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="home-player-tries" name="game_player_tries[]" /></td>
							<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
							<td><label for="home-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-player-conversions" name="game_player_conversions[]" /></td>
							<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_penalty_goals[]" /></td>
							<td><label for="home-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-player-drop-kicks" name="game_player_drop_kicks[]" /></td>
							<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
							<td><label for="home-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="home-player-penalties" name="game_player_penalties_conceeded[]" /></td>
							<td><label for="home-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="home-player-meters-run" name="game_player_meters_run[]" /></td>
							<td><label for="home-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-yellow" name="game_player_yellow_cards[]" /></td>
							<td><label for="home-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-red" name="game_player_red_cards[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="home-player-tries" name="game_player_tries[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-player-conversions" name="game_player_conversions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_penalty_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-player-drop-kicks" name="game_player_drop_kicks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="home-player-penalties" name="game_player_penalties_conceeded[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="home-player-meters-run" name="game_player_meters_run[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-yellow" name="game_player_yellow_cards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-red" name="game_player_red_cards[]" class="new-field" disabled="disabled" /></td>
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
			'game_home_first_half'              => 0,
			'game_home_second_half'             => 0,
			'game_home_extratime'               => '',
			'game_home_shootout'                => '',
			'game_away_first_half'              => 0,
			'game_away_second_half'             => 0,
			'game_away_extratime'               => '',
			'game_away_shootout'                => '',
			'game_home_tries'                   => 0,
			'game_home_conversions'             => 0,
			'game_home_penalty_goals'           => 0,
			'game_home_kick_percentage'         => 0,
			'game_home_meters_runs'             => 0,
			'game_home_meters_hand'             => 0,
			'game_home_meters_pass'             => 0,
			'game_home_possession'              => 0,
			'game_home_clean_breaks'            => 0,
			'game_home_defenders_beaten'        => 0,
			'game_home_offload'                 => 0,
			'game_home_rucks'                   => 0,
			'game_home_mauls'                   => 0,
			'game_home_turnovers_conceeded'     => 0,
			'game_home_scrums'                  => 0,
			'game_home_lineouts'                => 0,
			'game_home_penalties_conceeded'     => 0,
			'game_home_red_cards'               => 0,
			'game_home_yellow_cards'            => 0,
			'game_home_free_kicks_conceeded'    => 0,
			'game_away_tries'                   => 0,
			'game_away_conversions'             => 0,
			'game_away_penalty_goals'           => 0,
			'game_away_kick_percentage'         => 0,
			'game_away_meters_runs'             => 0,
			'game_away_meters_hand'             => 0,
			'game_away_meters_pass'             => 0,
			'game_away_possession'              => 0,
			'game_away_clean_breaks'            => 0,
			'game_away_defenders_beaten'        => 0,
			'game_away_offload'                 => 0,
			'game_away_rucks'                   => 0,
			'game_away_mauls'                   => 0,
			'game_away_turnovers_conceeded'     => 0,
			'game_away_scrums'                  => 0,
			'game_away_lineouts'                => 0,
			'game_away_penalties_conceeded'     => 0,
			'game_away_red_cards'               => 0,
			'game_away_yellow_cards'            => 0,
			'game_away_free_kicks_conceeded'    => 0,
			'game_info_id'                      => array(),
			'team_id'                           => array(),
			'game_info_home_score'              => array(),
			'game_info_away_score'              => array(),
			'game_info_event'                   => array(),
			'game_info_time'                    => array(),
			'player_id'                         => array(),
			'game_stats_player_id'              => array(),
			'game_team_id'                      => array(),
			'game_player_id'                    => array(),
			'game_player_tries'                 => array(),
			'game_player_assists'               => array(),
			'game_player_conversions'           => array(),
			'game_player_penalty_goals'         => array(),
			'game_player_drop_kicks'            => array(),
			'game_player_points'                => array(),
			'game_player_penalties_conceeded'   => array(),
			'game_player_meters_run'            => array(),
			'game_player_red_cards'             => array(),
			'game_player_yellow_cards'          => array(),
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
				'game_home_first_half'              => intval( $game['game_home_first_half'] ),
				'game_home_second_half'             => intval( $game['game_home_second_half'] ),
				'game_home_extratime'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_extratime'] ) ),
				'game_home_shootout'                => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_shootout'] ) ),
				'game_away_first_half'              => intval( $game['game_away_first_half'] ),
				'game_away_second_half'             => intval( $game['game_away_second_half'] ),
				'game_away_extratime'               => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_extratime'] ) ),
				'game_away_shootout'                => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_shootout'] ) ),
				'game_home_tries'                   => intval( $game['game_home_tries'] ),
				'game_home_conversions'             => intval( $game['game_home_conversions'] ),
				'game_home_penalty_goals'           => intval( $game['game_home_penalty_goals'] ),
				'game_home_kick_percentage'         => intval( $game['game_home_kick_percentage'] ),
				'game_home_meters_runs'             => intval( $game['game_home_meters_runs'] ),
				'game_home_meters_hand'             => intval( $game['game_home_meters_hand'] ),
				'game_home_meters_pass'             => intval( $game['game_home_meters_pass'] ),
				'game_home_possession'              => intval( $game['game_home_possession'] ),
				'game_home_clean_breaks'            => intval( $game['game_home_clean_breaks'] ),
				'game_home_defenders_beaten'        => intval( $game['game_home_defenders_beaten'] ),
				'game_home_offload'                 => intval( $game['game_home_offload'] ),
				'game_home_rucks'                   => intval( $game['game_home_rucks'] ),
				'game_home_mauls'                   => intval( $game['game_home_mauls'] ),
				'game_home_turnovers_conceeded'     => intval( $game['game_home_turnovers_conceeded'] ),
				'game_home_scrums'                  => intval( $game['game_home_scrums'] ),
				'game_home_lineouts'                => intval( $game['game_home_lineouts'] ),
				'game_home_penalties_conceeded'     => intval( $game['game_home_penalties_conceeded'] ),
				'game_home_red_cards'               => intval( $game['game_home_red_cards'] ),
				'game_home_yellow_cards'            => intval( $game['game_home_yellow_cards'] ),
				'game_home_free_kicks_conceeded'    => intval( $game['game_home_free_kicks_conceeded'] ),
				'game_away_tries'                   => intval( $game['game_away_tries'] ),
				'game_away_conversions'             => intval( $game['game_away_conversions'] ),
				'game_away_penalty_goals'           => intval( $game['game_away_penalty_goals'] ),
				'game_away_kick_percentage'         => intval( $game['game_away_kick_percentage'] ),
				'game_away_meters_runs'             => intval( $game['game_away_meters_runs'] ),
				'game_away_meters_hand'             => intval( $game['game_away_meters_hand'] ),
				'game_away_meters_pass'             => intval( $game['game_away_meters_pass'] ),
				'game_away_possession'              => intval( $game['game_away_possession'] ),
				'game_away_clean_breaks'            => intval( $game['game_away_clean_breaks'] ),
				'game_away_defenders_beaten'        => intval( $game['game_away_defenders_beaten'] ),
				'game_away_offload'                 => intval( $game['game_away_offload'] ),
				'game_away_rucks'                   => intval( $game['game_away_rucks'] ),
				'game_away_mauls'                   => intval( $game['game_away_mauls'] ),
				'game_away_turnovers_conceeded'     => intval( $game['game_away_turnovers_conceeded'] ),
				'game_away_scrums'                  => intval( $game['game_away_scrums'] ),
				'game_away_lineouts'                => intval( $game['game_away_lineouts'] ),
				'game_away_penalties_conceeded'     => intval( $game['game_away_penalties_conceeded'] ),
				'game_away_red_cards'               => intval( $game['game_away_red_cards'] ),
				'game_away_yellow_cards'            => intval( $game['game_away_yellow_cards'] ),
				'game_away_free_kicks_conceeded'    => intval( $game['game_away_free_kicks_conceeded'] ),
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

		$team_ids = $game['team_id'];
		unset( $game['team_id'] );

		$game_info_home_scores = $game['game_info_home_score'];;
		unset( $game['game_info_home_score'] );

		$game_info_away_scores = $game['game_info_away_score'];
		unset( $game['game_info_away_score'] );

		$game_info_events = $game['game_info_event'];
		unset( $game['game_info_event'] );

		$game_info_times = $game['game_info_time'];
		unset( $game['game_info_time'] );

		$player_ids = $game['player_id'];
		unset( $game['player_id'] );

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

				$event = array(
					'game_info_id'         => intval( $gi_id ),
					'game_id'              => intval( $game['game_id'] ),
					'team_id'              => intval( $team_ids[ $i ] ),
					'game_info_home_score' => intval( $game_info_home_scores[ $i ] ),
					'game_info_away_score' => intval( $game_info_away_scores[ $i ] ),
					'game_info_event'      => wp_filter_nohtml_kses( sanitize_text_field( $game_info_events[ $i ] ) ),
					'game_info_time'       => wp_filter_nohtml_kses( sanitize_text_field( $game_info_times[ $i ] ) ),
					'player_id'            => intval( $player_ids[ $i ] ),
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
			if ( $event['team_id'] != '' ) {
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

		if ( $game['game_home_extratime'] == '' ) {
			$game['game_home_extratime'] = null;
		}

		if ( $game['game_home_shootout'] == '' ) {
			$game['game_home_shootout'] = null;
		}

		if ( $game['game_away_extratime'] == '' ) {
			$game['game_away_extratime'] = null;
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

		$game_player_tries = $game['game_player_tries'];
		unset( $game['game_player_tries'] );

		$game_player_assists = $game['game_player_assists'];
		unset( $game['game_player_assists'] );

		$game_player_conversions = $game['game_player_conversions'];
		unset( $game['game_player_conversions'] );

		$game_player_penalty_goals = $game['game_player_penalty_goals'];
		unset( $game['game_player_penalty_goals'] );

		$game_player_drop_kicks = $game['game_player_drop_kicks'];
		unset( $game['game_player_drop_kicks'] );

		$game_player_points = $game['game_player_points'];
		unset( $game['game_player_points'] );

		$game_player_penalties_conceeded = $game['game_player_penalties_conceeded'];
		unset( $game['game_player_penalties_conceeded'] );

		$game_player_meters_run = $game['game_player_meters_run'];
		unset( $game['game_player_meters_run'] );

		$game_player_red_cards = $game['game_player_red_cards'];
		unset( $game['game_player_red_cards'] );

		$game_player_yellow_cards = $game['game_player_yellow_cards'];
		unset( $game['game_player_yellow_cards'] );

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
					'game_stats_player_id'              => intval( $gs_id ),
					'game_id'                           => intval( $game['game_id'] ),
					'game_team_id'                      => intval( $team_ids[ $i ] ),
					'game_player_id'                    => intval( $player_ids[ $i ] ),
					'game_player_tries'                 => intval( $game_player_tries[ $i ] ),
					'game_player_assists'               => intval( $game_player_assists[ $i ] ),
					'game_player_conversions'           => intval( $game_player_conversions[ $i ] ),
					'game_player_penalty_goals'         => intval( $game_player_penalty_goals[ $i ] ),
					'game_player_drop_kicks'            => intval( $game_player_drop_kicks[ $i ] ),
					'game_player_points'                => intval( $game_player_points[ $i ] ),
					'game_player_penalties_conceeded'   => intval( $game_player_penalties_conceeded[ $i ] ),
					'game_player_meters_run'            => intval( $game_player_meters_run[ $i ] ),
					'game_player_red_cards'             => intval( $game_player_red_cards[ $i ] ),
					'game_player_yellow_cards'          => intval( $game_player_yellow_cards[ $i ] ),
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
				'game_info_id'         => $event->game_info_id,
				'game_id'              => $event->game_id,
				'team_id'              => $event->team_id,
				'game_info_home_score' => $event->game_info_home_score,
				'game_info_away_score' => $event->game_info_away_score,
				'game_info_event'      => $event->game_info_event,
				'game_info_time'       => $event->game_info_time,
				'player_id'            => $event->player_id,
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
					'game_player_tries'                 => $stat->game_player_tries,
					'game_player_assists'               => $stat->game_player_assists,
					'game_player_conversions'           => $stat->game_player_conversions,
					'game_player_penalty_goals'         => $stat->game_player_penalty_goals,
					'game_player_drop_kicks'            => $stat->game_player_drop_kicks,
					'game_player_points'                => $stat->game_player_points,
					'game_player_penalties_conceeded'   => $stat->game_player_penalties_conceeded,
					'game_player_meters_run'            => $stat->game_player_meters_run,
					'game_player_red_cards'             => $stat->game_player_red_cards,
					'game_player_yellow_cards'          => $stat->game_player_yellow_cards,
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
					<th class="center"><?php esc_html_e( 'Shootout', 'sports-bench' ); ?></th>
					<th class="center"><?php esc_html_e( 'Final', 'sports-bench' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><span id="away-team-name"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></span></td>
					<td><label for="away-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Away Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-half" name="game_away_first_half" value="<?php echo esc_attr( $game['game_away_first_half'] ); ?>"/></td>
					<td><label for="away-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-half" name="game_away_second_half" value="<?php echo esc_attr( $game['game_away_second_half'] ); ?>" /></td>
					<td><label for="away-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Away Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-extra-time" name="game_away_extratime" value="<?php echo esc_attr( $game['game_away_extratime'] ); ?>" /></td>
					<td><label for="away-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Away Team Shootout ', 'sports-bench' ); ?></label><input type="number" id="away-team-shootout" name="game_away_shootout" value="<?php echo esc_attr( $game['game_away_shootout'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-half" class="screen-reader-text"><?php esc_html_e( 'Home Team First Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-half" name="game_home_first_half" value="<?php echo esc_attr( $game['game_home_first_half'] ); ?>" /></td>
					<td><label for="home-team-second-half" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Half Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-half" name="game_home_second_half" value="<?php echo esc_attr( $game['game_home_second_half'] ); ?>" /></td>
					<td><label for="home-team-extra-time" class="screen-reader-text"><?php esc_html_e( 'Home Team Extra Time Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-extra-time" name="game_home_extratime" value="<?php echo esc_attr( $game['game_home_extratime'] ); ?>" /></td>
					<td><label for="home-team-shootout" class="screen-reader-text"><?php esc_html_e( 'Home Team Shootouts ', 'sports-bench' ); ?></label><input type="number" id="home-team-shootout" name="game_home_shootout" value="<?php echo esc_attr( $game['game_home_shootout'] ); ?>" /></td>
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
						<td><?php esc_html_e( 'Tries', 'sports-bench' ); ?></td>
						<td><label for="away-team-tries" class="screen-reader-text"><?php esc_html_e( 'Away Team Tries ', 'sports-bench' ); ?></label><input type="number" id="away-team-tries" name="game_away_tries" value="<?php echo esc_attr( $game['game_away_tries'] ); ?>" /></td>
						<td><label for="home-team-tries" class="screen-reader-text"><?php esc_html_e( 'Home Team Tries ', 'sports-bench' ); ?></label><input type="number" id="home-team-tries" name="game_home_tries" value="<?php echo esc_attr( $game['game_home_tries'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></td>
						<td><label for="away-team-conversions" class="screen-reader-text"><?php esc_html_e( 'Away Team Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-team-conversions" name="game_away_conversions" value="<?php echo esc_attr( $game['game_away_conversions'] ); ?>" /></td>
						<td><label for="home-team-conversions" class="screen-reader-text"><?php esc_html_e( 'Home Team Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-team-conversions" name="game_home_conversions" value="<?php echo esc_attr( $game['game_home_conversions'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalty-goals" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalty-goals" name="game_away_penalty_goals" value="<?php echo esc_attr( $game['game_away_penalty_goals'] ); ?>" /></td>
						<td><label for="home-team-penalty-goals" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalty-goals" name="game_home_penalty_goals" value="<?php echo esc_attr( $game['game_home_penalty_goals'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kick Percentage', 'sports-bench' ); ?></td>
						<td><label for="away-team-kick-percentage" class="screen-reader-text"><?php esc_html_e( 'Away Team Kick Percentage ', 'sports-bench' ); ?></label><input type="number" id="away-team-kick-percentage" name="game_away_kick_percentage" value="<?php echo esc_attr( $game['game_away_kick_percentage'] ); ?>" /></td>
						<td><label for="home-team-kick-percentage" class="screen-reader-text"><?php esc_html_e( 'Home Team Kick Percentage ', 'sports-bench' ); ?></label><input type="number" id="home-team-kick-percentage" name="game_home_kick_percentage" value="<?php echo esc_attr( $game['game_home_kick_percentage'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Kicks From Hand Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-hand-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Kicks From Hand Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-hand-meters" name="game_away_meters_hand" value="<?php echo esc_attr( $game['game_away_meters_hand'] ); ?>" /></td>
						<td><label for="home-team-hand-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Kicks From Hand Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-hand-meters" name="game_home_meters_hand" value="<?php echo esc_attr( $game['game_home_meters_hand'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Pass Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-pass-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Pass Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-pass-meters" name="game_away_meters_pass" value="<?php echo esc_attr( $game['game_away_meters_pass'] ); ?>" /></td>
						<td><label for="home-team-pass-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Pass Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-pass-meters" name="game_home_meters_pass" value="<?php echo esc_attr( $game['game_home_meters_pass'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Run Meters', 'sports-bench' ); ?></td>
						<td><label for="away-team-run-meters" class="screen-reader-text"><?php esc_html_e( 'Away Team Run Meters ', 'sports-bench' ); ?></label><input type="number" id="away-team-run-meters" name="game_away_meters_runs" value="<?php echo esc_attr( $game['game_away_meters_runs'] ); ?>" /></td>
						<td><label for="home-team-run-meters" class="screen-reader-text"><?php esc_html_e( 'Home Team Run Meters ', 'sports-bench' ); ?></label><input type="number" id="home-team-run-meters" name="game_home_meters_runs" value="<?php echo esc_attr( $game['game_home_meters_runs'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Possession', 'sports-bench' ); ?></td>
						<td><label for="away-team-possession" class="screen-reader-text"><?php esc_html_e( 'Away Team Possession ', 'sports-bench' ); ?></label><input type="number" id="away-team-possession" name="game_away_possession" value="<?php echo esc_attr( $game['game_away_possession'] ); ?>" /></td>
						<td><label for="home-team-possession" class="screen-reader-text"><?php esc_html_e( 'Home Team Possession ', 'sports-bench' ); ?></label><input type="number" id="home-team-possession" name="game_home_possession" value="<?php echo esc_attr( $game['game_home_possession'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Clean Breaks', 'sports-bench' ); ?></td>
						<td><label for="away-team-clean-breaks" class="screen-reader-text"><?php esc_html_e( 'Away Team Clean Breaks ', 'sports-bench' ); ?></label><input type="number" id="away-team-clean-breaks" name="game_away_clean_breaks" value="<?php echo esc_attr( $game['game_away_clean_breaks'] ); ?>" /></td>
						<td><label for="home-team-clean-breaks" class="screen-reader-text"><?php esc_html_e( 'Home Team Clean Breaks ', 'sports-bench' ); ?></label><input type="number" id="home-team-clean-breaks" name="game_home_clean_breaks" value="<?php echo esc_attr( $game['game_home_clean_breaks'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Defenders Beaten', 'sports-bench' ); ?></td>
						<td><label for="away-team-defenders-beaten" class="screen-reader-text"><?php esc_html_e( 'Away Team Defenders Beaten ', 'sports-bench' ); ?></label><input type="number" id="away-team-defenders-beaten" name="game_away_defenders_beaten" value="<?php echo esc_attr( $game['game_away_defenders_beaten'] ); ?>" /></td>
						<td><label for="home-team-defenders-beaten" class="screen-reader-text"><?php esc_html_e( 'Home Team Defenders Beaten ', 'sports-bench' ); ?></label><input type="number" id="home-team-defenders-beaten" name="game_home_defenders_beaten" value="<?php echo esc_attr( $game['game_home_defenders_beaten'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offload', 'sports-bench' ); ?></td>
						<td><label for="away-team-offload" class="screen-reader-text"><?php esc_html_e( 'Away Team Offload ', 'sports-bench' ); ?></label><input type="number" id="away-team-offload" name="game_away_offload" value="<?php echo esc_attr( $game['game_away_offload'] ); ?>" /></td>
						<td><label for="home-team-offload" class="screen-reader-text"><?php esc_html_e( 'Home Team Offload ', 'sports-bench' ); ?></label><input type="number" id="home-team-offload" name="game_home_offload" value="<?php echo esc_attr( $game['game_home_offload'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Rucks', 'sports-bench' ); ?></td>
						<td><label for="away-team-rucks" class="screen-reader-text"><?php esc_html_e( 'Away Team Rucks ', 'sports-bench' ); ?></label><input type="number" id="away-team-rucks" name="game_away_rucks" value="<?php echo esc_attr( $game['game_away_rucks'] ); ?>" /></td>
						<td><label for="home-team-rucks" class="screen-reader-text"><?php esc_html_e( 'Home Team Rucks ', 'sports-bench' ); ?></label><input type="number" id="home-team-rucks" name="game_home_rucks" value="<?php echo esc_attr( $game['game_home_rucks'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Mauls', 'sports-bench' ); ?></td>
						<td><label for="away-team-mauls" class="screen-reader-text"><?php esc_html_e( 'Away Team Mauls ', 'sports-bench' ); ?></label><input type="number" id="away-team-mauls" name="game_away_mauls" value="<?php echo esc_attr( $game['game_away_mauls'] ); ?>" /></td>
						<td><label for="home-team-mauls" class="screen-reader-text"><?php esc_html_e( 'Home Team Mauls ', 'sports-bench' ); ?></label><input type="number" id="home-team-mauls" name="game_home_mauls" value="<?php echo esc_attr( $game['game_home_mauls'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-turnovers" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-turnovers" name="game_away_turnovers_conceeded" value="<?php echo esc_attr( $game['game_away_turnovers_conceeded'] ); ?>" /></td>
						<td><label for="home-team-turnovers" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-turnovers" name="game_home_turnovers_conceeded" value="<?php echo esc_attr( $game['game_home_turnovers_conceeded'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Scrums', 'sports-bench' ); ?></td>
						<td><label for="away-team-scrums" class="screen-reader-text"><?php esc_html_e( 'Away Team Scrums ', 'sports-bench' ); ?></label><input type="number" id="away-team-scrums" name="game_away_scrums" value="<?php echo esc_attr( $game['game_away_scrums'] ); ?>" /></td>
						<td><label for="home-team-scrums" class="screen-reader-text"><?php esc_html_e( 'Home Team Scrums ', 'sports-bench' ); ?></label><input type="number" id="home-team-scrums" name="game_home_scrums" value="<?php echo esc_attr( $game['game_home_scrums'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Lineouts', 'sports-bench' ); ?></td>
						<td><label for="away-team-lineouts" class="screen-reader-text"><?php esc_html_e( 'Away Team Lineouts ', 'sports-bench' ); ?></label><input type="number" id="away-team-lineouts" name="game_away_lineouts" value="<?php echo esc_attr( $game['game_away_lineouts'] ); ?>" /></td>
						<td><label for="home-team-lineouts" class="screen-reader-text"><?php esc_html_e( 'Home Team Lineouts ', 'sports-bench' ); ?></label><input type="number" id="home-team-lineouts" name="game_home_lineouts" value="<?php echo esc_attr( $game['game_home_lineouts'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Penalties Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Away Team Penalties Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-penalties" name="game_away_penalties_conceeded" value="<?php echo esc_attr( $game['game_away_penalties_conceeded'] ); ?>" /></td>
						<td><label for="home-team-penalties" class="screen-reader-text"><?php esc_html_e( 'Home Team Penalties Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-penalties" name="game_home_penalties_conceeded" value="<?php echo esc_attr( $game['game_home_penalties_conceeded'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-red-cards" name="game_away_red_cards" value="<?php echo esc_attr( $game['game_away_red_cards'] ); ?>" /></td>
						<td><label for="home-team-red-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-red-cards" name="game_home_red_cards" value="<?php echo esc_attr( $game['game_home_red_cards'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></td>
						<td><label for="away-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Away Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-team-yellow-cards" name="game_away_yellow_cards" value="<?php echo esc_attr( $game['game_away_yellow_cards'] ); ?>" /></td>
						<td><label for="home-team-yellow-cards" class="screen-reader-text"><?php esc_html_e( 'Home Team Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-team-yellow-cards" name="game_home_yellow_cards" value="<?php echo esc_attr( $game['game_home_yellow_cards'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Kick Conceded', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-kicks" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Kick Conceded ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-kicks" name="game_away_free_kicks_conceeded" value="<?php echo esc_attr( $game['game_away_free_kicks_conceeded'] ); ?>" /></td>
						<td><label for="home-team-free-kicks" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Kick Conceded ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-kicks" name="game_home_free_kicks_conceeded" value="<?php echo esc_attr( $game['game_home_free_kicks_conceeded'] ); ?>" /></td>
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
						<th><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Home Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Away Score', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Event', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Time', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
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
							?>
							<tr class="game-event-row">
								<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
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
								<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" value="<?php echo esc_attr( $event['game_info_home_score'] ); ?>" /></td>
								<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" value="<?php echo esc_attr( $event['game_info_away_score'] ); ?>" /></td>
								<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
									<select id="match-event" name="game_info_event[]">
										<option value="" <?php selected( $event['game_info_event'], '' ); ?>><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
										<option value="Try" <?php selected( $event['game_info_event'], 'Try' ); ?>><?php esc_html_e( 'Try', 'sports-bench' ); ?></option>
										<option value="Conversion" <?php selected( $event['game_info_event'], 'Conversion' ); ?>><?php esc_html_e( 'Conversion', 'sports-bench' ); ?></option>
										<option value="Drop Kick" <?php selected( $event['game_info_event'], 'Drop Kick' ); ?>><?php esc_html_e( 'Drop Kick', 'sports-bench' ); ?></option>
										<option value="Penalty Goal" <?php selected( $event['game_info_event'], 'Penalty Goal' ); ?>><?php esc_html_e( 'Penalty Goal', 'sports-bench' ); ?></option>
										<option value="Yellow Card" <?php selected( $event['game_info_event'], 'Yellow Card' ); ?>><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
										<option value="Red Card" <?php selected( $event['game_info_event'], 'Red Card' ); ?>><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
									</select>
								</td>
								<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" value="<?php echo esc_attr( $event['game_info_time'] ); ?>" /></td>
								<td>
									<label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label>
									<select id="match-event-player" name="player_id[]">
										<?php
										if ( ! in_array( $event['team_id'], $player_ids ) ) {
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
								<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
							</tr>
							<?php
						}
					} else {
						?>
						<tr class="game-event-row">
						<input type="hidden" name="game_info_id[]" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label>
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
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<select id="match-event" name="game_info_event[]">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="Try"><?php esc_html_e( 'Try', 'sports-bench' ); ?></option>
								<option value="Conversion"><?php esc_html_e( 'Conversion', 'sports-bench' ); ?></option>
								<option value="Drop Kick"><?php esc_html_e( 'Drop Kick', 'sports-bench' ); ?></option>
								<option value="Penalty Goal"><?php esc_html_e( 'Penalty Goal', 'sports-bench' ); ?></option>
								<option value="Yellow Card"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="Red Card"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" /></td>
						<td><label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label><select id="match-event-player" name="player_id[]"></select></td>
						<td><button class="remove-game-event"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Event', 'sports-bench' ); ?></span></button></td>
					</tr>
						<?php
					}
					?>
					<tr class="game-event-empty-row screen-reader-text">
						<input type="hidden" name="game_info_id[]" class="new-field" disabled="disabled" />
						<td><label for="match-event-team" class="screen-reader-text"><?php esc_html_e( 'Match Event Team ', 'sports-bench' ); ?></label><select id="match-event-team" name="team_id[]" class="new-field team" disabled="disabled">
							<?php
							if ( $teams ) {
								foreach ( $teams as $team ) {
									?>
									<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_location() ); ?></option>
									<?php
								}
							}
							?>
						</select></td>
						<td><label for="match-event-home-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Home Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-home-score" name="game_info_home_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-away-score" class="screen-reader-text"><?php esc_html_e( 'Match Event Away Score ', 'sports-bench' ); ?></label><input type="number" id="match-event-away-score" name="game_info_away_score[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event" class="screen-reader-text"><?php esc_html_e( 'Match Event ', 'sports-bench' ); ?></label>
							<select id="match-event" name="game_info_event[]" class="new-field" disabled="disabled">
								<option value=""><?php esc_html_e( 'Select Event', 'sports-bench' ); ?></option>
								<option value="Try"><?php esc_html_e( 'Try', 'sports-bench' ); ?></option>
								<option value="Conversion"><?php esc_html_e( 'Conversion', 'sports-bench' ); ?></option>
								<option value="Drop Kick"><?php esc_html_e( 'Drop Kick', 'sports-bench' ); ?></option>
								<option value="Penalty Goal"><?php esc_html_e( 'Penalty Goal', 'sports-bench' ); ?></option>
								<option value="Yellow Card"><?php esc_html_e( 'Yellow Card', 'sports-bench' ); ?></option>
								<option value="Red Card"><?php esc_html_e( 'Red Card', 'sports-bench' ); ?></option>
							</select>
						</td>
						<td><label for="match-event-time" class="screen-reader-text"><?php esc_html_e( 'Match Event Time ', 'sports-bench' ); ?></label><input type="number" id="match-event-time" name="game_info_time[]" class="new-field" disabled="disabled" /></td>
						<td><label for="match-event-player" class="screen-reader-text"><?php esc_html_e( 'Match Event Player ', 'sports-bench' ); ?></label><select id="match-event-player" name="player_id[]" class="new-field" disabled="disabled"></select></td>
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
			<table id="away-player-stats" class="form-table rugby-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tries', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Drop Kicks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Meters Run', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></th>
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
								<td><label for="away-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="away-player-tries" name="game_player_tries[]" value="<?php echo esc_attr( $player['game_player_tries'] ); ?>" /></td>
								<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="away-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-player-conversions" name="game_player_conversions[]" value="<?php echo esc_attr( $player['game_player_conversions'] ); ?>" /></td>
								<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_penalty_goals[]" value="<?php echo esc_attr( $player['game_player_penalty_goals'] ); ?>" /></td>
								<td><label for="away-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-player-drop-kicks" name="game_player_drop_kicks[]" value="<?php echo esc_attr( $player['game_player_drop_kicks'] ); ?>" /></td>
								<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="away-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="away-player-penalties" name="game_player_penalties_conceeded[]" value="<?php echo esc_attr( $player['game_player_penalties_conceeded'] ); ?>" /></td>
								<td><label for="away-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="away-player-meters-run" name="game_player_meters_run[]" value="<?php echo esc_attr( $player['game_player_meters_run'] ); ?>" /></td>
								<td><label for="away-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-yellow" name="game_player_yellow_cards[]" value="<?php echo esc_attr( $player['game_player_yellow_cards'] ); ?>" /></td>
								<td><label for="away-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-red" name="game_player_red_cards[]" value="<?php echo esc_attr( $player['game_player_red_cards'] ); ?>" /></td>
								<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
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
							<td><label for="away-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="away-player-tries" name="game_player_tries[]" /></td>
							<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
							<td><label for="away-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-player-conversions" name="game_player_conversions[]" /></td>
							<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_penalty_goals[]" /></td>
							<td><label for="away-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-player-drop-kicks" name="game_player_drop_kicks[]" /></td>
							<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
							<td><label for="away-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="away-player-penalties" name="game_player_penalties_conceeded[]" /></td>
							<td><label for="away-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="away-player-meters-run" name="game_player_meters_run[]" /></td>
							<td><label for="away-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-yellow" name="game_player_yellow_cards[]" /></td>
							<td><label for="away-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-red" name="game_player_red_cards[]" /></td>
							<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
						</tr>
						<?php
					}
					?>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<input class="away-player-team new-field" type="hidden" name="game_team_id[]" disabled="disabled" />
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
						<td><label for="away-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="away-player-tries" name="game_player_tries[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="away-player-conversions" name="game_player_conversions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="away-player-goals" name="game_player_penalty_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="away-player-drop-kicks" name="game_player_drop_kicks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="away-player-penalties" name="game_player_penalties_conceeded[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="away-player-meters-run" name="game_player_meters_run[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-yellow" name="game_player_yellow_cards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls-red" name="game_player_red_cards[]" class="new-field" disabled="disabled" /></td>
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
			<table id="home-player-stats" class="form-table rugby-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Tries', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Assists', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Conversions', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalty Goals', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Drop Kicks', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Points', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Penalties', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Meters Run', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Yellow Cards', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Red Cards', 'sports-bench' ); ?></th>
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
								<td><label for="home-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="home-player-tries" name="game_player_tries[]" value="<?php echo esc_attr( $player['game_player_tries'] ); ?>" /></td>
								<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="home-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-player-conversions" name="game_player_conversions[]" value="<?php echo esc_attr( $player['game_player_conversions'] ); ?>" /></td>
								<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_penalty_goals[]" value="<?php echo esc_attr( $player['game_player_penalty_goals'] ); ?>" /></td>
								<td><label for="home-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-player-drop-kicks" name="game_player_drop_kicks[]" value="<?php echo esc_attr( $player['game_player_drop_kicks'] ); ?>" /></td>
								<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="home-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="home-player-penalties" name="game_player_penalties_conceeded[]" value="<?php echo esc_attr( $player['game_player_penalties_conceeded'] ); ?>" /></td>
								<td><label for="home-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="home-player-meters-run" name="game_player_meters_run[]" value="<?php echo esc_attr( $player['game_player_meters_run'] ); ?>" /></td>
								<td><label for="home-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-yellow" name="game_player_yellow_cards[]" value="<?php echo esc_attr( $player['game_player_yellow_cards'] ); ?>" /></td>
								<td><label for="home-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-red" name="game_player_red_cards[]" value="<?php echo esc_attr( $player['game_player_red_cards'] ); ?>" /></td>
								<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
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
							<td><label for="home-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="home-player-tries" name="game_player_tries[]" /></td>
							<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
							<td><label for="home-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-player-conversions" name="game_player_conversions[]" /></td>
							<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_penalty_goals[]" /></td>
							<td><label for="home-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-player-drop-kicks" name="game_player_drop_kicks[]" /></td>
							<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
							<td><label for="home-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="home-player-penalties" name="game_player_penalties_conceeded[]" /></td>
							<td><label for="home-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="home-player-meters-run" name="game_player_meters_run[]" /></td>
							<td><label for="home-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-yellow" name="game_player_yellow_cards[]" /></td>
							<td><label for="home-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-red" name="game_player_red_cards[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
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
						<td><label for="home-player-tries" class="screen-reader-text"><?php esc_html_e( 'Tried ', 'sports-bench' ); ?></label><input type="number" id="home-player-tries" name="game_player_tries[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-conversions" class="screen-reader-text"><?php esc_html_e( 'Conversions ', 'sports-bench' ); ?></label><input type="number" id="home-player-conversions" name="game_player_conversions[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-goals" class="screen-reader-text"><?php esc_html_e( 'Penalty Goals ', 'sports-bench' ); ?></label><input type="number" id="home-player-goals" name="game_player_penalty_goals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-drop-kicks" class="screen-reader-text"><?php esc_html_e( 'Drop Kicks ', 'sports-bench' ); ?></label><input type="number" id="home-player-drop-kicks" name="game_player_drop_kicks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-penalties" class="screen-reader-text"><?php esc_html_e( 'Penalties Conceeded ', 'sports-bench' ); ?></label><input type="number" id="home-player-penalties" name="game_player_penalties_conceeded[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-meters-run" class="screen-reader-text"><?php esc_html_e( 'Meters Run ', 'sports-bench' ); ?></label><input type="number" id="home-player-meters-run" name="game_player_meters_run[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-yellow" class="screen-reader-text"><?php esc_html_e( 'Yellow Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-yellow" name="game_player_yellow_cards[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-red" class="screen-reader-text"><?php esc_html_e( 'Red Cards ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls-red" name="game_player_red_cards[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
