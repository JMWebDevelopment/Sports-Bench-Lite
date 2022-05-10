<?php
/**
 * Creates the basketball game admin class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Basketball;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The basketball game admin class.
 *
 * This is used for basketball game admin functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/basketball
 */
class BasketballAdminGame {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Creates the new BasketballAdminGame object to be used.
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
		<h2><?php esc_html_e( 'Scoring by Quarter', 'sports-bench' ); ?></h2>
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
					<td><label for="away-team-first-quater" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-quarter" name="game_away_first_quarter"/></td>
					<td><label for="away-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-quarter" name="game_away_second_quarter" /></td>
					<td><label for="away-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-quarter" name="game_away_third_quarter" /></td>
					<td><label for="away-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Fourth Quarter ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-quarter" name="game_away_fourth_quarter" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-quater" class="screen-reader-text"><?php esc_html_e( 'Home Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-quarter" name="game_home_first_quarter"/></td>
					<td><label for="home-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-quarter" name="game_home_second_quarter" /></td>
					<td><label for="home-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-quarter" name="game_home_third_quarter" /></td>
					<td><label for="home-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Fourth Quarter ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-quarter" name="game_home_fourth_quarter" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Home Team Overtime ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Game', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" />
				</div>
				<div class="field one-column">
					<label for="game-current-period"><?php esc_html_e( 'Current Period in Game', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-period" name="game_current_period" />
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
						<td><?php esc_html_e( 'Field Goals Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-field-goals-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-field-goals-made" name="game_away_fgm" /></td>
						<td><label for="home-team-field-goals-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-field-goals-made" name="game_home_fgm" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Field Goals Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-field-goals-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-field-goals-attempted" /></td>
						<td><label for="home-team-field-goals-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-field-goals-attempted" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Three Pointers Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-three-pointers-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-three-pointers-made" name="game_away_3pm" /></td>
						<td><label for="home-team-three-pointers-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-sthree-pointers-madeog" name="game_home_3pm" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Three Pointers Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-three-pointers-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-three-pointers-attempted" /></td>
						<td><label for="home-team-three-pointers-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-three-pointers-attempted" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Throws Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-throws-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-throws-made" name="game_away_ftm" /></td>
						<td><label for="home-team-free-throws-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-throws-made" name="game_home_ftm" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Throws Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-throws-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-throws-attempted" name="game_away_fta" /></td>
						<td><label for="home-team-free-throws-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-throws-attempted" name="game_home_fta" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offensive Rebounds', 'sports-bench' ); ?></td>
						<td><label for="away-team-off-rebounds" class="screen-reader-text"><?php esc_html_e( 'Away Team Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-team-off-rebounds" name="game_away_off_rebound" /></td>
						<td><label for="home-team-off-rebounds" class="screen-reader-text"><?php esc_html_e( 'Home Team Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-team-off-rebounds" name="game_home_off_rebound" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Defensive Rebounds', 'sports-bench' ); ?></td>
						<td><label for="away-team-def-rebounds" class="screen-reader-text"><?php esc_html_e( 'Away Team Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-team-def-rebounds" name="game_away_def_rebound" /></td>
						<td><label for="home-team-def-rebounds" class="screen-reader-text"><?php esc_html_e( 'Home Team Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-team-def-rebounds" name="game_home_def_rebound" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Assists', 'sports-bench' ); ?></td>
						<td><label for="away-team-assists" class="screen-reader-text"><?php esc_html_e( 'Away Team Assists ', 'sports-bench' ); ?></label><input type="number" id="away-team-assists" name="game_away_assists" /></td>
						<td><label for="home-team-assists" class="screen-reader-text"><?php esc_html_e( 'Home Team Assists ', 'sports-bench' ); ?></label><input type="number" id="home-team-assists" name="game_home_assists" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Steals', 'sports-bench' ); ?></td>
						<td><label for="away-team-steals" class="screen-reader-text"><?php esc_html_e( 'Away Team Steals ', 'sports-bench' ); ?></label><input type="number" id="away-team-steals" name="game_away_steals" /></td>
						<td><label for="home-team-steals" class="screen-reader-text"><?php esc_html_e( 'Home Team Steals ', 'sports-bench' ); ?></label><input type="number" id="home-team-steals" name="game_home_steals" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></td>
						<td><label for="away-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Away Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-team-blocks" name="game_away_blocks" /></td>
						<td><label for="home-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Home Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-team-blocks" name="game_home_blocks" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Points in the Paint', 'sports-bench' ); ?></td>
						<td><label for="away-team-pip" class="screen-reader-text"><?php esc_html_e( 'Away Team Points in the Paint ', 'sports-bench' ); ?></label><input type="number" id="away-team-pip" name="game_away_pip" /></td>
						<td><label for="home-team-pip" class="screen-reader-text"><?php esc_html_e( 'Home Team Points in the Paint ', 'sports-bench' ); ?></label><input type="number" id="home-team-pip" name="game_home_pip" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-to" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-to" name="game_away_to" /></td>
						<td><label for="home-team-to" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-to" name="game_home_to" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Points off of Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-pot" class="screen-reader-text"><?php esc_html_e( 'Away Team Points off of Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-pot" name="game_away_pot" /></td>
						<td><label for="home-team-pot" class="screen-reader-text"><?php esc_html_e( 'Home Team Points off of Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-pot" name="game_home_pot" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fast Break Points', 'sports-bench' ); ?></td>
						<td><label for="away-team-fb" class="screen-reader-text"><?php esc_html_e( 'Away Team Fast Break Points ', 'sports-bench' ); ?></label><input type="number" id="away-team-fb" name="game_away_fast_break" /></td>
						<td><label for="home-team-fb" class="screen-reader-text"><?php esc_html_e( 'Home Team Fast Break Points ', 'sports-bench' ); ?></label><input type="number" id="home-team-fb" name="game_home_fast_break" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></td>
						<td><label for="away-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Away Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-team-fouls" name="game_away_fouls" /></td>
						<td><label for="home-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Home Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-team-fouls" name="game_home_fouls" /></td>
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
			<table id="away-player-stats" class="form-table basketball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Start', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Min', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'PTS', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Off Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Def Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'AST', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'STL', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BLK', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'F', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-away-1-row">
						<input class="away-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td class="player-name"><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" class="away-player" name="game_player_id[]"></select></td>
						<td><label for="away-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" /></td>
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" /></td>
						<td><label for="away-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pm" name="game_player_3pm[]" /></td>
						<td><label for="away-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pa" name="game_player_3pa[]" /></td>
						<td><label for="away-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-ftm" name="game_player_ftm[]" /></td>
						<td><label for="away-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fta" name="game_player_fta[]"/></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
						<td><label for="away-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-off-reb" name="game_player_off_rebound[]" /></td>
						<td><label for="away-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-reb" name="game_player_def_rebound[]" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
						<td><label for="away-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="away-player-steals" name="game_player_steals[]" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" /></td>
						<td><label for="away-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-player-to" name="game_player_to[]" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" /></td>
						<td class="remove"><button class="remove-away-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-away-1-empty-row screen-reader-text">
						<input class="away-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td class="player-name"><label for="away-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="away-player" name="game_player_id[]" class="new-field away-player" disabled="disabled"></select></td>
						<td><label for="away-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field new-field" value="1" disabled="disabled"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0" class="new-field" disabled="disabled"></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pm" name="game_player_3pm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pa" name="game_player_3pa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-ftm" name="game_player_ftm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fta" name="game_player_fta[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-off-reb" name="game_player_off_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-reb" name="game_player_def_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="away-player-steals" name="game_player_steals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-player-to" name="game_player_to[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
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
			<table id="home-player-stats" class="form-table basketball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Start', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Min', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'PTS', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Off Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Def Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'AST', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'STL', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BLK', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'F', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr class="game-home-1-row">
						<input class="home-player-team" type="hidden" name="game_team_id[]" />
						<input type="hidden" name="game_stats_player_id[]" />
						<td class="player-name"><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" class="home-player" name="game_player_id[]"></select></td>
						<td><label for="home-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-minutes" name="game_player_minutes[]" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" /></td>
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" /></td>
						<td><label for="home-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pm" name="game_player_3pm[]" /></td>
						<td><label for="home-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pa" name="game_player_3pa[]" /></td>
						<td><label for="home-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-ftm" name="game_player_ftm[]" /></td>
						<td><label for="home-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fta" name="game_player_fta[]"/></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
						<td><label for="home-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-off-reb" name="game_player_off_rebound[]" /></td>
						<td><label for="home-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-reb" name="game_player_def_rebound[]" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
						<td><label for="home-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="home-player-steals" name="game_player_steals[]" /></td>
						<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" /></td>
						<td><label for="home-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-player-to" name="game_player_to[]" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
					<tr class="game-home-1-empty-row screen-reader-text">
						<input class="home-player-team" type="hidden" name="game_team_id[]" class="new-field" disabled="disabled" />
						<input type="hidden" name="game_stats_player_id[]" class="new-field" disabled="disabled" />
						<td class="player-name"><label for="home-player" class="screen-reader-text"><?php esc_html_e( 'Player ', 'sports-bench' ); ?></label><select id="home-player" name="game_player_id[]" class="new-field home-player" disabled="disabled"></select></td>
						<td><label for="home-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field new-field" value="1" disabled="disabled"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0" class="new-field" disabled="disabled"></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pm" name="game_player_3pm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pa" name="game_player_3pa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-ftm" name="game_player_ftm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fta" name="game_player_fta[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-off-reb" name="game_player_off_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-reb" name="game_player_def_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="home-player-steals" name="game_player_steals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-player-to" name="game_player_to[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
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
			'game_home_first_quarter'   => 0,
			'game_home_second_quarter'  => 0,
			'game_home_third_quarter'   => 0,
			'game_home_fourth_quarter'  => 0,
			'game_home_overtime'        => '',
			'game_away_first_quarter'   => 0,
			'game_away_second_quarter'  => 0,
			'game_away_third_quarter'   => 0,
			'game_away_fourth_quarter'  => 0,
			'game_away_overtime'        => '',
			'game_home_fgm'             => 0,
			'game_home_fga'             => 0,
			'game_home_3pm'             => 0,
			'game_home_3pa'             => 0,
			'game_home_ftm'             => 0,
			'game_home_fta'             => 0,
			'game_home_off_rebound'     => 0,
			'game_home_def_rebound'     => 0,
			'game_home_assists'         => 0,
			'game_home_steals'          => 0,
			'game_home_blocks'          => 0,
			'game_home_pip'             => 0,
			'game_home_to'              => 0,
			'game_home_pot'             => 0,
			'game_home_fast_break'      => 0,
			'game_home_fouls'           => 0,
			'game_away_fgm'             => 0,
			'game_away_fga'             => 0,
			'game_away_3pm'             => 0,
			'game_away_3pa'             => 0,
			'game_away_ftm'             => 0,
			'game_away_fta'             => 0,
			'game_away_off_rebound'     => 0,
			'game_away_def_rebound'     => 0,
			'game_away_assists'         => 0,
			'game_away_steals'          => 0,
			'game_away_blocks'          => 0,
			'game_away_pip'             => 0,
			'game_away_to'              => 0,
			'game_away_pot'             => 0,
			'game_away_fast_break'      => 0,
			'game_away_fouls'           => 0,
			'game_stats_player_id'      => array(),
			'game_team_id'              => array(),
			'game_player_id'            => array(),
			'game_player_started'       => array(),
			'game_player_minutes'       => array(),
			'game_player_fgm'           => array(),
			'game_player_fga'           => array(),
			'game_player_3pm'           => array(),
			'game_player_3pa'           => array(),
			'game_player_ftm'           => array(),
			'game_player_fta'           => array(),
			'game_player_points'        => array(),
			'game_player_off_rebound'   => array(),
			'game_player_def_rebound'   => array(),
			'game_player_assists'       => array(),
			'game_player_steals'        => array(),
			'game_player_blocks'        => array(),
			'game_player_to'            => array(),
			'game_player_fouls'         => array(),
			'game_player_plus_minus'    => array(),
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
				'game_home_first_quarter'   => intval( $game['game_home_first_quarter'] ),
				'game_home_second_quarter'  => intval( $game['game_home_second_quarter'] ),
				'game_home_third_quarter'   => intval( $game['game_home_third_quarter'] ),
				'game_home_fourth_quarter'  => intval( $game['game_home_fourth_quarter'] ),
				'game_home_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_home_overtime'] ) ),
				'game_away_first_quarter'   => intval( $game['game_away_first_quarter'] ),
				'game_away_second_quarter'  => intval( $game['game_away_second_quarter'] ),
				'game_away_third_quarter'   => intval( $game['game_away_third_quarter'] ),
				'game_away_fourth_quarter'  => intval( $game['game_away_fourth_quarter'] ),
				'game_away_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $game['game_away_overtime'] ) ),
				'game_home_fgm'             => intval( $game['game_home_fgm'] ),
				'game_home_fga'             => intval( $game['game_home_fga'] ),
				'game_home_3pm'             => intval( $game['game_home_3pm'] ),
				'game_home_3pa'             => intval( $game['game_home_3pa'] ),
				'game_home_ftm'             => intval( $game['game_home_ftm'] ),
				'game_home_fta'             => intval( $game['game_home_fta'] ),
				'game_home_off_rebound'     => intval( $game['game_home_off_rebound'] ),
				'game_home_def_rebound'     => intval( $game['game_home_def_rebound'] ),
				'game_home_assists'         => intval( $game['game_home_assists'] ),
				'game_home_steals'          => intval( $game['game_home_steals'] ),
				'game_home_blocks'          => intval( $game['game_home_blocks'] ),
				'game_home_pip'             => intval( $game['game_home_pip'] ),
				'game_home_to'              => intval( $game['game_home_to'] ),
				'game_home_pot'             => intval( $game['game_home_pot'] ),
				'game_home_fast_break'      => intval( $game['game_home_fast_break'] ),
				'game_home_fouls'           => intval( $game['game_home_fouls'] ),
				'game_away_fgm'             => intval( $game['game_away_fgm'] ),
				'game_away_fga'             => intval( $game['game_away_fga'] ),
				'game_away_3pm'             => intval( $game['game_away_3pm'] ),
				'game_away_3pa'             => intval( $game['game_away_3pa'] ),
				'game_away_ftm'             => intval( $game['game_away_ftm'] ),
				'game_away_fta'             => intval( $game['game_away_fta'] ),
				'game_away_off_rebound'     => intval( $game['game_away_off_rebound'] ),
				'game_away_def_rebound'     => intval( $game['game_away_def_rebound'] ),
				'game_away_assists'         => intval( $game['game_away_assists'] ),
				'game_away_steals'          => intval( $game['game_away_steals'] ),
				'game_away_blocks'          => intval( $game['game_away_blocks'] ),
				'game_away_pip'             => intval( $game['game_away_pip'] ),
				'game_away_to'              => intval( $game['game_away_to'] ),
				'game_away_pot'             => intval( $game['game_away_pot'] ),
				'game_away_fast_break'      => intval( $game['game_away_fast_break'] ),
				'game_away_fouls'           => intval( $game['game_away_fouls'] ),
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

		$game_player_started = $game['game_player_started'];
		unset( $game['game_player_started'] );

		$game_player_minutes = $game['game_player_minutes'];;
		unset( $game['game_player_minutes'] );

		$game_player_fgm = $game['game_player_fgm'];
		unset( $game['game_player_fgm'] );

		$game_player_fga = $game['game_player_fga'];
		unset( $game['game_player_fga'] );

		$game_player_3pm = $game['game_player_3pm'];
		unset( $game['game_player_3pm'] );

		$game_player_3pa = $game['game_player_3pa'];
		unset( $game['game_player_3pa'] );

		$game_player_ftm = $game['game_player_ftm'];
		unset( $game['game_player_ftm'] );

		$game_player_fta = $game['game_player_fta'];
		unset( $game['game_player_fta'] );

		$game_player_points = $game['game_player_points'];
		unset( $game['game_player_points'] );

		$game_player_off_rebound = $game['game_player_off_rebound'];
		unset( $game['game_player_off_rebound'] );

		$game_player_def_rebound = $game['game_player_def_rebound'];
		unset( $game['game_player_def_rebound'] );

		$game_player_assists = $game['game_player_assists'];
		unset( $game['game_player_assists'] );

		$game_player_steals = $game['game_player_steals'];
		unset( $game['game_player_steals'] );

		$game_player_blocks = $game['game_player_blocks'];
		unset( $game['game_player_blocks'] );

		$game_player_to = $game['game_player_to'];
		unset( $game['game_player_to'] );

		$game_player_fouls = $game['game_player_fouls'];
		unset( $game['game_player_fouls'] );

		$game_player_plus_minus = $game['game_player_plus_minus'];
		unset( $game['game_player_plus_minus'] );

		//* Loop through each of the player stats and add it to the array of stats to be added or updated
		$len = count( $team_ids );
		$stats = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $game_stats_player_ids[ $i ] ) ) {
				$gs_id = $game_stats_player_ids[ $i ];
			} else {
				$gs_id = '';
			}
			if ( isset( $game_player_minutes[ $i ] ) && 5 === strlen( $game_player_minutes[ $i ] ) ) {
				$time = '00:' . $game_player_minutes[ $i ];
			} elseif ( isset( $game_player_minutes[ $i ] ) && 4 === strlen( $game_player_minutes[ $i ] ) ) {
				$time = '00:0' . $game_player_minutes[ $i ];
			} elseif ( isset( $game_player_minutes[ $i ] ) && 2 === strlen( $game_player_minutes[ $i ] ) ) {
				$time = '00:' . $game_player_minutes[ $i ] . ':00';
			} elseif ( isset( $game_player_minutes[ $i ] ) && 1 === strlen( $game_player_minutes[ $i ] ) ) {
				$time = '00:0' . $game_player_minutes[ $i ] . ':00';
			} else {
				$time = $game_player_minutes[ $i ];
			}
			if ( '1' === $game_player_started[ $i ] ) {
				$started = 1;
			} else {
				$started = 0;
			}
			//* Add the player's stats to the array of player stats
			if ( $player_ids[ $i ] != '' ) {
				$stat = [
					'game_stats_player_id'    => intval( $gs_id ),
					'game_id'                 => intval( $game['game_id'] ),
					'game_team_id'            => intval( $team_ids[ $i ] ),
					'game_player_id'          => intval( $player_ids[ $i ] ),
					'game_player_started'     => intval( $started ),
					'game_player_minutes'     => wp_filter_nohtml_kses( sanitize_text_field( $time ) ),
					'game_player_fgm'         => intval( $game_player_fgm[ $i ] ),
					'game_player_fga'         => intval( $game_player_fga[ $i ] ),
					'game_player_3pm'         => intval( $game_player_3pm[ $i ] ),
					'game_player_3pa'         => intval( $game_player_3pa[ $i ] ),
					'game_player_ftm'         => intval( $game_player_ftm[ $i ] ),
					'game_player_fta'         => intval( $game_player_fta[ $i ] ),
					'game_player_points'      => intval( $game_player_points[ $i ] ),
					'game_player_off_rebound' => intval( $game_player_off_rebound[ $i ] ),
					'game_player_def_rebound' => intval( $game_player_def_rebound[ $i ] ),
					'game_player_assists'     => intval( $game_player_assists[ $i ] ),
					'game_player_steals'      => intval( $game_player_steals[ $i ] ),
					'game_player_blocks'      => intval( $game_player_blocks[ $i ] ),
					'game_player_to'          => intval( $game_player_to[ $i ] ),
					'game_player_fouls'       => intval( $game_player_fouls[ $i ] ),
					'game_player_plus_minus'  => intval( $game_player_plus_minus[ $i ] ),
				];
				array_push( $stats, $stat );
			}
		}

		//* Grab the player stats for the game already in the database to compare the new ones to
		$game_info_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_id    = $game['game_id'];
		$quer       = "SELECT * FROM $game_info_table WHERE game_id = $game_id;";
		$game_stats = $wpdb->get_results( $quer );
		$stats_ids  = [];
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

		for ( $i = 0; $i < $len; $i++ ) {
			if ( 8 === strlen( $stats[ $i ]['game_player_minutes'] ) ) {
				$stats[ $i ]['game_player_minutes'] = substr_replace( $stats[ $i ]['game_player_minutes'], "", 0, 3 );
			} elseif ( 7 === strlen( $stats[ $i ]['game_player_minutes'] ) ) {
				$stats[ $i ]['game_player_minutes'] = substr_replace( $stats[ $i ]['game_player_minutes'], "", 0, 2 );
			} elseif ( 6 === strlen( $stats[ $i ]['game_player_minutes'] ) ) {
				$stats[ $i ]['game_player_minutes'] = substr_replace( $stats[ $i ]['game_player_minutes'], "", 0, 1 );
			} else {
				$stats[ $i ]['game_player_minutes'] = $stats[ $i ]['game_player_minutes'];
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
		$events     = [];
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
				if ( 8 === strlen( $stat->game_player_minutes ) ) {
					$minutes = substr_replace( $stat->game_player_minutes, '', 0, 3 );
				} elseif ( 7 === strlen( $stat->game_player_minutes ) ) {
					$minutes = substr_replace( $stat->game_player_minutes, '', 0, 2 );
				} elseif ( 6 === strlen( $stat->game_player_minutes ) ) {
					$minutes = substr_replace( $stat->game_player_minutes, '', 0, 1 );
				} else {
					$minutes = $stat->game_player_minutes;
				}
				$stat_array = [
					'game_stats_player_id'      => $stat->game_stats_player_id,
					'game_id'                   => $stat->game_id,
					'game_team_id'              => $stat->game_team_id,
					'game_player_id'            => $stat->game_player_id,
					'game_player_started'       => $stat->game_player_started,
					'game_player_minutes'       => $minutes,
					'game_player_fgm'           => $stat->game_player_fgm,
					'game_player_fga'           => $stat->game_player_fga,
					'game_player_3pm'           => $stat->game_player_3pm,
					'game_player_3pa'           => $stat->game_player_3pa,
					'game_player_ftm'           => $stat->game_player_ftm,
					'game_player_fta'           => $stat->game_player_fta,
					'game_player_off_rebound'   => $stat->game_player_off_rebound,
					'game_player_def_rebound'   => $stat->game_player_def_rebound,
					'game_player_points'        => $stat->game_player_points,
					'game_player_assists'       => $stat->game_player_assists,
					'game_player_steals'        => $stat->game_player_steals,
					'game_player_blocks'        => $stat->game_player_blocks,
					'game_player_to'            => $stat->game_player_to,
					'game_player_fouls'         => $stat->game_player_fouls,
					'game_player_plus_minus'    => $stat->game_player_plus_minus,
				];
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
					<td><label for="away-team-first-quater" class="screen-reader-text"><?php esc_html_e( 'Away Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-first-quarter" name="game_away_first_quarter" value="<?php echo esc_attr( $game['game_away_first_quarter'] ); ?>"/></td>
					<td><label for="away-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-second-quarter" name="game_away_second_quarter" value="<?php echo esc_attr( $game['game_away_second_quarter'] ); ?>" /></td>
					<td><label for="away-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-third-quarter" name="game_away_third_quarter" value="<?php echo esc_attr( $game['game_away_third_quarter'] ); ?>" /></td>
					<td><label for="away-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Away Fourth Quarter ', 'sports-bench' ); ?></label><input type="number" id="away-team-fourth-quarter" name="game_away_fourth_quarter" value="<?php echo esc_attr( $game['game_away_fourth_quarter'] ); ?>" /></td>
					<td><label for="away-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Away Team Overtime ', 'sports-bench' ); ?></label><input type="number" id="away-team-overtime" name="game_away_overtime" value="<?php echo esc_attr( $game['game_away_overtime'] ); ?>" /></td>
					<td><label for="away-team-final" class="screen-reader-text"><?php esc_html_e( 'Away Team Final Score ', 'sports-bench' ); ?></label><input type="number" id="away-team-final" name="game_away_final" value="<?php echo esc_attr( $game['game_away_final'] ); ?>" /></td>
				</tr>
				<tr>
					<td><span id="home-team-name"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></span></td>
					<td><label for="home-team-first-quater" class="screen-reader-text"><?php esc_html_e( 'Home Team First Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-first-quarter" name="game_home_first_quarter" value="<?php echo esc_attr( $game['game_home_first_quarter'] ); ?>"/></td>
					<td><label for="home-team-second-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Team Second Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-second-quarter" name="game_home_second_quarter" value="<?php echo esc_attr( $game['game_home_second_quarter'] ); ?>" /></td>
					<td><label for="home-team-third-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Team Third Quarter Score ', 'sports-bench' ); ?></label><input type="number" id="home-team-third-quarter" name="game_home_third_quarter" value="<?php echo esc_attr( $game['game_home_third_quarter'] ); ?>" /></td>
					<td><label for="home-team-fourth-quarter" class="screen-reader-text"><?php esc_html_e( 'Home Fourth Quarter ', 'sports-bench' ); ?></label><input type="number" id="home-team-fourth-quarter" name="game_home_fourth_quarter" value="<?php echo esc_attr( $game['game_home_fourth_quarter'] ); ?>" /></td>
					<td><label for="home-team-overtime" class="screen-reader-text"><?php esc_html_e( 'Home Team Overtime ', 'sports-bench' ); ?></label><input type="number" id="home-team-overtime" name="game_home_overtime" value="<?php echo esc_attr( $game['game_home_overtime'] ); ?>" /></td>
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
					<label for="game-current-time"><?php esc_html_e( 'Current Time in Game', 'sports-bench' ); ?></label>
					<input type="text" id="game-current-time" name="game_current_time" value="<?php echo esc_attr( stripslashes( $game['game_current_time'] ) ); ?>" />
				</div>
				<div class="field one-column">
					<label for="game-current-period"><?php esc_html_e( 'Current Period in Game', 'sports-bench' ); ?></label>
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
						<td><?php esc_html_e( 'Field Goals Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-field-goals-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-field-goals-made" name="game_away_fgm" value="<?php echo esc_attr( $game['game_away_fgm'] ); ?>" /></td>
						<td><label for="home-team-field-goals-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-field-goals-made" name="game_home_fgm" value="<?php echo esc_attr( $game['game_home_fgm'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Field Goals Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-field-goals-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-field-goals-attempted" name="game_away_fga" value="<?php echo esc_attr( $game['game_away_fga'] ); ?>" /></td>
						<td><label for="home-team-field-goals-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-field-goals-attempted" name="game_home_fga" value="<?php echo esc_attr( $game['game_home_fga'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Three Pointers Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-three-pointers-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-three-pointers-made" name="game_away_3pm" value="<?php echo esc_attr( $game['game_away_3pm'] ); ?>" /></td>
						<td><label for="home-team-three-pointers-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-sthree-pointers-madeog" name="game_home_3pm" value="<?php echo esc_attr( $game['game_home_3pm'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Three Pointers Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-three-pointers-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-three-pointers-attempted" name="game_away_3pa" value="<?php echo esc_attr( $game['game_away_3pa'] ); ?>" /></td>
						<td><label for="home-team-three-pointers-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-three-pointers-attempted" name="game_home_3pa" value="<?php echo esc_attr( $game['game_home_3pa'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Throws Made', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-throws-made" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-throws-made" name="game_away_ftm" value="<?php echo esc_attr( $game['game_away_ftm'] ); ?>" /></td>
						<td><label for="home-team-free-throws-made" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-throws-made" name="game_home_ftm" value="<?php echo esc_attr( $game['game_home_ftm'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Free Throws Attempted', 'sports-bench' ); ?></td>
						<td><label for="away-team-free-throws-attempted" class="screen-reader-text"><?php esc_html_e( 'Away Team Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-team-free-throws-attempted" name="game_away_fta" value="<?php echo esc_attr( $game['game_away_fta'] ); ?>" /></td>
						<td><label for="home-team-free-throws-attempted" class="screen-reader-text"><?php esc_html_e( 'Home Team Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-team-free-throws-attempted" name="game_home_fta" value="<?php echo esc_attr( $game['game_home_fta'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Offensive Rebounds', 'sports-bench' ); ?></td>
						<td><label for="away-team-off-rebounds" class="screen-reader-text"><?php esc_html_e( 'Away Team Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-team-off-rebounds" name="game_away_off_rebound" value="<?php echo esc_attr( $game['game_away_off_rebound'] ); ?>" /></td>
						<td><label for="home-team-off-rebounds" class="screen-reader-text"><?php esc_html_e( 'Home Team Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-team-off-rebounds" name="game_home_off_rebound" value="<?php echo esc_attr( $game['game_home_off_rebound'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Defensive Rebounds', 'sports-bench' ); ?></td>
						<td><label for="away-team-def-rebounds" class="screen-reader-text"><?php esc_html_e( 'Away Team Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-team-def-rebounds" name="game_away_def_rebound" value="<?php echo esc_attr( $game['game_away_def_rebound'] ); ?>" /></td>
						<td><label for="home-team-def-rebounds" class="screen-reader-text"><?php esc_html_e( 'Home Team Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-team-def-rebounds" name="game_home_def_rebound" value="<?php echo esc_attr( $game['game_home_def_rebound'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Assists', 'sports-bench' ); ?></td>
						<td><label for="away-team-assists" class="screen-reader-text"><?php esc_html_e( 'Away Team Assists ', 'sports-bench' ); ?></label><input type="number" id="away-team-assists" name="game_away_assists" value="<?php echo esc_attr( $game['game_away_assists'] ); ?>" /></td>
						<td><label for="home-team-assists" class="screen-reader-text"><?php esc_html_e( 'Home Team Assists ', 'sports-bench' ); ?></label><input type="number" id="home-team-assists" name="game_home_assists" value="<?php echo esc_attr( $game['game_home_assists'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Steals', 'sports-bench' ); ?></td>
						<td><label for="away-team-steals" class="screen-reader-text"><?php esc_html_e( 'Away Team Steals ', 'sports-bench' ); ?></label><input type="number" id="away-team-steals" name="game_away_steals" value="<?php echo esc_attr( $game['game_away_steals'] ); ?>" /></td>
						<td><label for="home-team-steals" class="screen-reader-text"><?php esc_html_e( 'Home Team Steals ', 'sports-bench' ); ?></label><input type="number" id="home-team-steals" name="game_home_steals" value="<?php echo esc_attr( $game['game_home_steals'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Blocks', 'sports-bench' ); ?></td>
						<td><label for="away-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Away Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-team-blocks" name="game_away_blocks" value="<?php echo esc_attr( $game['game_away_blocks'] ); ?>" /></td>
						<td><label for="home-team-blocks" class="screen-reader-text"><?php esc_html_e( 'Home Team Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-team-blocks" name="game_home_blocks" value="<?php echo esc_attr( $game['game_home_blocks'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Points in the Paint', 'sports-bench' ); ?></td>
						<td><label for="away-team-pip" class="screen-reader-text"><?php esc_html_e( 'Away Team Points in the Paint ', 'sports-bench' ); ?></label><input type="number" id="away-team-pip" name="game_away_pip" value="<?php echo esc_attr( $game['game_away_pip'] ); ?>" /></td>
						<td><label for="home-team-pip" class="screen-reader-text"><?php esc_html_e( 'Home Team Points in the Paint ', 'sports-bench' ); ?></label><input type="number" id="home-team-pip" name="game_home_pip" value="<?php echo esc_attr( $game['game_home_pip'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-to" class="screen-reader-text"><?php esc_html_e( 'Away Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-to" name="game_away_to" value="<?php echo esc_attr( $game['game_away_to'] ); ?>" /></td>
						<td><label for="home-team-to" class="screen-reader-text"><?php esc_html_e( 'Home Team Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-to" name="game_home_to" value="<?php echo esc_attr( $game['game_home_to'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Points off of Turnovers', 'sports-bench' ); ?></td>
						<td><label for="away-team-pot" class="screen-reader-text"><?php esc_html_e( 'Away Team Points off of Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-team-pot" name="game_away_pot" value="<?php echo esc_attr( $game['game_away_pot'] ); ?>" /></td>
						<td><label for="home-team-pot" class="screen-reader-text"><?php esc_html_e( 'Home Team Points off of Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-team-pot" name="game_home_pot" value="<?php echo esc_attr( $game['game_home_pot'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fast Break Points', 'sports-bench' ); ?></td>
						<td><label for="away-team-fb" class="screen-reader-text"><?php esc_html_e( 'Away Team Fast Break Points ', 'sports-bench' ); ?></label><input type="number" id="away-team-fb" name="game_away_fast_break" value="<?php echo esc_attr( $game['game_away_fast_break'] ); ?>" /></td>
						<td><label for="home-team-fb" class="screen-reader-text"><?php esc_html_e( 'Home Team Fast Break Points ', 'sports-bench' ); ?></label><input type="number" id="home-team-fb" name="game_home_fast_break" value="<?php echo esc_attr( $game['game_home_fast_break'] ); ?>" /></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Fouls', 'sports-bench' ); ?></td>
						<td><label for="away-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Away Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-team-fouls" name="game_away_fouls" value="<?php echo esc_attr( $game['game_away_fouls'] ); ?>" /></td>
						<td><label for="home-team-fouls" class="screen-reader-text"><?php esc_html_e( 'Home Team Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-team-fouls" name="game_home_fouls" value="<?php echo esc_attr( $game['game_home_fouls'] ); ?>" /></td>
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
			<table id="away-player-stats" class="form-table basketball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Start', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Min', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'PTS', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Off Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Def Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'AST', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'STL', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BLK', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'F', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
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
										$the_player = new Player( (int) $player['game_player_id'] );
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
								<td><label for="away-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1" <?php checked( 1, $player['game_player_started'] ); ?>> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
								<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $player['game_player_minutes'] ); ?>" /></td>
								<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" value="<?php echo esc_attr( $player['game_player_fgm'] ); ?>" /></td>
								<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" value="<?php echo esc_attr( $player['game_player_fga'] ); ?>" /></td>
								<td><label for="away-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pm" name="game_player_3pm[]" value="<?php echo esc_attr( $player['game_player_3pm'] ); ?>" /></td>
								<td><label for="away-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pa" name="game_player_3pa[]" value="<?php echo esc_attr( $player['game_player_3pa'] ); ?>" /></td>
								<td><label for="away-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-ftm" name="game_player_ftm[]" value="<?php echo esc_attr( $player['game_player_ftm'] ); ?>" /></td>
								<td><label for="away-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fta" name="game_player_fta[]" value="<?php echo esc_attr( $player['game_player_fta'] ); ?>" /></td>
								<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="away-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-off-reb" name="game_player_off_rebound[]" value="<?php echo esc_attr( $player['game_player_off_rebound'] ); ?>" /></td>
								<td><label for="away-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-reb" name="game_player_def_rebound[]" value="<?php echo esc_attr( $player['game_player_def_rebound'] ); ?>" /></td>
								<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="away-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="away-player-steals" name="game_player_steals[]" value="<?php echo esc_attr( $player['game_player_steals'] ); ?>" /></td>
								<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" value="<?php echo esc_attr( $player['game_player_blocks'] ); ?>" /></td>
								<td><label for="away-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-player-to" name="game_player_to[]" value="<?php echo esc_attr( $player['game_player_to'] ); ?>" /></td>
								<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" value="<?php echo esc_attr( $player['game_player_fouls'] ); ?>" /></td>
								<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" value="<?php echo esc_attr( $player['game_player_plus_minus'] ); ?>" /></td>
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
							<td><label for="away-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
							<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" /></td>
							<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" /></td>
							<td><label for="away-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pm" name="game_player_3pm[]" /></td>
							<td><label for="away-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pa" name="game_player_3pa[]" /></td>
							<td><label for="away-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-ftm" name="game_player_ftm[]" /></td>
							<td><label for="away-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fta" name="game_player_fta[]" /></td>
							<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" /></td>
							<td><label for="away-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-off-reb" name="game_player_off_rebound[]" /></td>
							<td><label for="away-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-reb" name="game_player_def_rebound[]" /></td>
							<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" /></td>
							<td><label for="away-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="away-player-steals" name="game_player_steals[]" /></td>
							<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" /></td>
							<td><label for="away-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-player-to" name="game_player_to[]" /></td>
							<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" /></td>
							<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" /></td>
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
						<td><label for="away-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field new-field" value="1" disabled="disabled"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0" class="new-field" disabled="disabled"></td>
						<td><label for="away-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="away-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pm" name="game_player_3pm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-3pa" name="game_player_3pa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="away-player-ftm" name="game_player_ftm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="away-player-fta" name="game_player_fta[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="away-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-off-reb" name="game_player_off_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="away-player-def-reb" name="game_player_def_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="away-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="away-player-steals" name="game_player_steals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="away-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="away-player-to" name="game_player_to[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="away-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="away-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="away-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
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
			<table id="home-player-stats" class="form-table basketball-player-stats">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Player', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Start', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Min', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FGA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '3PA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTM', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'FTA', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'PTS', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Off Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'Def Reb', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'AST', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'STL', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'BLK', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'TO', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( 'F', 'sports-bench' ); ?></th>
						<th class="center"><?php esc_html_e( '+/-', 'sports-bench' ); ?></th>
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
										echo 'not in team';
										$the_player = new Player( (int) $player['game_player_id'] );
										echo '<option selected="selected" value="' . esc_attr( $the_player->get_player_id() ) . '">' . esc_html( $the_player->get_player_first_name() ) . ' ' . esc_html( $the_player->get_player_last_name() ) . '</option>';
									} else {
										echo 'in team';
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
								<td><label for="home-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1" <?php checked( 1, esc_attr( $player['game_player_started'] ) ); ?>> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
								<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-minutes" name="game_player_minutes[]" value="<?php echo esc_attr( $player['game_player_minutes'] ); ?>" /></td>
								<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" value="<?php echo esc_attr( $player['game_player_fgm'] ); ?>" /></td>
								<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" value="<?php echo esc_attr( $player['game_player_fga'] ); ?>" /></td>
								<td><label for="home-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pm" name="game_player_3pm[]" value="<?php echo esc_attr( $player['game_player_3pm'] ); ?>" /></td>
								<td><label for="home-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pa" name="game_player_3pa[]" value="<?php echo esc_attr( $player['game_player_3pa'] ); ?>" /></td>
								<td><label for="home-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-ftm" name="game_player_ftm[]" value="<?php echo esc_attr( $player['game_player_ftm'] ); ?>" /></td>
								<td><label for="home-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fta" name="game_player_fta[]" value="<?php echo esc_attr( $player['game_player_fta'] ); ?>" /></td>
								<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" value="<?php echo esc_attr( $player['game_player_points'] ); ?>" /></td>
								<td><label for="home-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-off-reb" name="game_player_off_rebound[]" value="<?php echo esc_attr( $player['game_player_off_rebound'] ); ?>" /></td>
								<td><label for="home-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-reb" name="game_player_def_rebound[]" value="<?php echo esc_attr( $player['game_player_def_rebound'] ); ?>" /></td>
								<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" value="<?php echo esc_attr( $player['game_player_assists'] ); ?>" /></td>
								<td><label for="home-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="home-player-steals" name="game_player_steals[]" value="<?php echo esc_attr( $player['game_player_steals'] ); ?>" /></td>
								<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" value="<?php echo esc_attr( $player['game_player_blocks'] ); ?>" /></td>
								<td><label for="home-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-player-to" name="game_player_to[]" value="<?php echo esc_attr( $player['game_player_to'] ); ?>" /></td>
								<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" value="<?php echo esc_attr( $player['game_player_fouls'] ); ?>" /></td>
								<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" value="<?php echo esc_attr( $player['game_player_plus_minus'] ); ?>" /></td>
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
							<td><label for="home-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field" value="1"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0"></td>
							<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-minutes" name="game_player_minutes[]" /></td>
							<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" /></td>
							<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" /></td>
							<td><label for="home-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pm" name="game_player_3pm[]" /></td>
							<td><label for="home-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pa" name="game_player_3pa[]" /></td>
							<td><label for="home-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-ftm" name="game_player_ftm[]" /></td>
							<td><label for="home-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fta" name="game_player_fta[]" /></td>
							<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" /></td>
							<td><label for="home-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-off-reb" name="game_player_off_rebound[]" /></td>
							<td><label for="home-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-reb" name="game_player_def_rebound[]" /></td>
							<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" /></td>
							<td><label for="home-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="home-player-steals" name="game_player_steals[]" /></td>
							<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" /></td>
							<td><label for="home-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-player-to" name="game_player_to[]" /></td>
							<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" /></td>
							<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" /></td>
							<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
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
						<td><label for="home-player-start" class="screen-reader-text"><?php esc_html_e( 'Started? ', 'sports-bench' ); ?></label><input id="game-player-start" name="game_player_started[]" type="checkbox" class="started-field new-field" value="1" disabled="disabled"> <input id="game_player_started_hidden" name="game_player_started[]" type="hidden" value="0" class="new-field" disabled="disabled"></td>
						<td><label for="home-player-minutes" class="screen-reader-text"><?php esc_html_e( 'Minutes Played ', 'sports-bench' ); ?></label><input type="text" id="home-player-minutes" name="game_player_minutes[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fgm" class="screen-reader-text"><?php esc_html_e( 'Field Goals Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-fgm" name="game_player_fgm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fga" class="screen-reader-text"><?php esc_html_e( 'Field Goals Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fga" name="game_player_fga[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-3pm" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pm" name="game_player_3pm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-3pa" class="screen-reader-text"><?php esc_html_e( 'Three Pointers Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-3pa" name="game_player_3pa[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-ftm" class="screen-reader-text"><?php esc_html_e( 'Free Throws Made ', 'sports-bench' ); ?></label><input type="number" id="home-player-ftm" name="game_player_ftm[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fta" class="screen-reader-text"><?php esc_html_e( 'Free Throws Attempted ', 'sports-bench' ); ?></label><input type="number" id="home-player-fta" name="game_player_fta[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-points" class="screen-reader-text"><?php esc_html_e( 'Points ', 'sports-bench' ); ?></label><input type="number" id="home-player-points" name="game_player_points[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-off-reb" class="screen-reader-text"><?php esc_html_e( 'Offensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-off-reb" name="game_player_off_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-def-reb" class="screen-reader-text"><?php esc_html_e( 'Defensive Rebounds ', 'sports-bench' ); ?></label><input type="number" id="home-player-def-reb" name="game_player_def_rebound[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-assists" class="screen-reader-text"><?php esc_html_e( 'Assists ', 'sports-bench' ); ?></label><input type="number" id="home-player-assists" name="game_player_assists[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-steals" class="screen-reader-text"><?php esc_html_e( 'Steals ', 'sports-bench' ); ?></label><input type="number" id="home-player-steals" name="game_player_steals[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-blocks" class="screen-reader-text"><?php esc_html_e( 'Blocks ', 'sports-bench' ); ?></label><input type="number" id="home-player-blocks" name="game_player_blocks[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-to" class="screen-reader-text"><?php esc_html_e( 'Turnovers ', 'sports-bench' ); ?></label><input type="number" id="home-player-to" name="game_player_to[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-fouls" class="screen-reader-text"><?php esc_html_e( 'Fouls ', 'sports-bench' ); ?></label><input type="number" id="home-player-fouls" name="game_player_fouls[]" class="new-field" disabled="disabled" /></td>
						<td><label for="home-player-plus-minus" class="screen-reader-text"><?php esc_html_e( 'Plus/Minus ', 'sports-bench' ); ?></label><input type="number" id="home-player-plus-minus" name="game_player_plus_minus[]" class="new-field" disabled="disabled" /></td>
						<td class="remove"><button class="remove-home-player"><span class="fal fa-minus-circle"></span> <span class="screen-reader-text"><?php esc_html_e( 'Remove Player', 'sports-bench' ); ?></span></button></td>
					</tr>
				</tbody>
			</table>
			<button id="add-home-1" class="add-player"><?php esc_html_e( 'Add Player', 'sports-bench' ); ?></button>
		</div>
		<?php
	}

}
