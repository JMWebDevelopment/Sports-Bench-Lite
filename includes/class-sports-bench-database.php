<?php
/**
 * Updates the database structure.
 *
 * This file contains the code to update the database structure during a plugin update.
 * Or when the sport being used is changed.
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 */

namespace Sports_Bench;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 */
class Sports_Bench_Database {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Builds the Sports_Bench_Admin object.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Updates the database structure during a plugin update.
	 *
	 * @since 2.0.0
	 */
	public function update_plugin_database() {

		if ( get_option( 'sports_bench_version' ) < '2.1' ) {
			if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$this->update_soccer_event_assist_column();
			}
		}

		if ( get_option( 'sports_bench_version' ) < '2.0' ) {
			if ( get_option( 'sports_bench_version' ) ) {
				update_option( 'sports_bench_plugin_lifetime_license', 'VcBUPnjMPYRMdPqvWASK' );
			}
		}

		if ( get_option( 'sports_bench_version' ) < '1.9' ) {
			$this->add_player_bio_column();
		}

		if ( get_option( 'sports_bench_version' ) < '1.8' ) {
			$this->add_baseball_order_columns();
		}

		if ( get_option( 'sports_bench_version' ) < '1.4' ) {
			$this->add_location_columns();
		}

		if ( get_option( 'sports_bench_version' ) < '1.3' ) {
			$this->fix_players_table();
		}
		if ( get_option( 'sports_bench_version' ) < '1.2' ) {
			$this->add_active_column();
			$this->add_playoff_tables();
		}

		update_option( 'sports_bench_version', $this->version );
	}

	/**
	 * Adds in the player bio column to the players table.
	 *
	 * @since 2.1.0
	 */
	private function update_soccer_event_assist_column() {
		global $wpdb;
		$table_name  = $wpdb->prefix . 'sb_game_info';
		$column_test = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'secondary_player_id'" );
		if ( empty( $dob_column_test ) ) {
			$wpdb->query( "ALTER TABLE $table_name CHANGE COLUMN `game_info_assists` `secondary_player_id` TEXT NOT NULL;" );
		}
	}

	/**
	 * Adds in the player bio column to the players table.
	 *
	 * @since 2.0.0
	 */
	private function add_player_bio_column() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'sb_players';
		$dob_column_test = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'player_bio'" );
		if ( empty( $dob_column_test ) ) {
			$wpdb->query( "ALTER TABLE $table_name ADD player_bio TEXT NOT NULL;" );
		}
	}

	/**
	 * Adds in the batting and pitching order columns to the baseball game stats table.
	 *
	 * @since 2.0.0
	 */
	private function add_baseball_order_columns() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_game_stats';
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$batting_order_column_test = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'game_player_batting_order'" );
			if ( empty( $batting_order_column_test ) ) {
				$wpdb->query( "ALTER TABLE $table_name ADD game_player_batting_order INT NOT NULL;" );
			}

			$pitching_order_column_test = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'game_player_pitching_order'" );
			if ( empty( $pitching_order_column_test ) ) {
				$wpdb->query( "ALTER TABLE $table_name ADD game_player_pitching_order INT NOT NULL;" );
			}
		}

	}

	/**
	 * Adds in the location columns for games.
	 *
	 * @since 2.0.0
	 */
	private function add_location_columns() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$table_name = $wpdb->prefix . 'sb_teams';
		$sql        = "ALTER TABLE $table_name ADD COLUMN team_location_line_one TEXT,
			ADD COLUMN team_location_line_two TEXT,
			ADD COLUMN team_location_country TEXT,
			ADD COLUMN team_location_zip_code TEXT;";
		$wpdb->query( $sql );

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "ALTER TABLE $table_name ADD COLUMN game_neutral_site INT,
			ADD COLUMN game_location_stadium TEXT,
			ADD COLUMN game_location_line_one TEXT,
			ADD COLUMN game_location_line_two TEXT,
			ADD COLUMN game_location_city TEXT,
			ADD COLUMN game_location_state TEXT,
			ADD COLUMN game_location_country TEXT,
			ADD COLUMN game_location_zip_code TEXT;";
		$wpdb->query( $sql );
	}

	/**
	 * Fixes the birthday column for the players table.
	 *
	 * @since 2.0.0
	 */
	private function fix_players_table() {
		global $wpdb;
		$table_name      = $wpdb->prefix . 'sb_players';
		$dob_column_test = $wpdb->get_results( "SHOW COLUMNS FROM $table_name LIKE 'player_birth_day'" );
		if ( empty( $dob_column_test ) ) {
			$wpdb->query( "ALTER TABLE $table_name CHANGE COLUMN `player_birthday` `player_birth_day` TEXT NOT NULL;" );
		}
	}

	/**
	 * Adds in an active column to the team table.
	 *
	 * @since 2.0.0
	 */
	private function add_active_column() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'sb_teams';
		$sql        = "ALTER TABLE $table_name ADD team_active TEXT NOT NULL;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	/**
	 * Adds in the playoff brackets and series tables.
	 *
	 * @since 2.0.0
	 */
	private function add_playoff_tables() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$table_name = $wpdb->prefix . 'sb_playoff_brackets';
		$sql = "CREATE TABLE $table_name (
					bracket_id INTEGER NOT NULL AUTO_INCREMENT,
					num_teams INTEGER NOT NULL,
					bracket_format TEXT NOT NULL,
					bracket_title TEXT NOT NULL,
					bracket_season TEXT NOT NULL,
					PRIMARY KEY (bracket_id)
			)";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_playoff_series';
		$sql = "CREATE TABLE $table_name (
					series_id INTEGER NOT NULL AUTO_INCREMENT,
					bracket_id INTEGER NOT NULL,
					series_format TEXT NOT NULL,
					playoff_round TEXT NOT NULL,
					team_one_id INTEGER NOT NULL,
					team_one_seed INTEGER NOT NULL,
					team_two_id INTEGER NOT NULL,
					team_two_seed INTEGER NOT NULL,
					game_ids TEXT NOT NULL,
					opposite_series INTEGER NOT NULL,
					PRIMARY KEY (series_id)
			)";
		dbDelta( $sql );
	}

	/**
	 * Changes the game, game_info and game_stats tables when the sport is changed.
	 *
	 * @since 2.0.0
	 *
	 * @param int $sport      The new sport the website is showing.
	 */
	public function update_sport_tables( $sport ) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$table_name = $wpdb->prefix . 'sb_games';
		if ( $table_name === $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) ) {

			$table_name = $wpdb->prefix . 'sb_games';
			$wpdb->query( "DROP TABLE $table_name;" );

			//* Drop the game info table
			$table_name = $wpdb->prefix . 'sb_game_info';
			$wpdb->query( "DROP TABLE $table_name;" );

			//* Drop the game stats table
			$table_name = $wpdb->prefix . 'sb_game_stats';
			$wpdb->query( "DROP TABLE $table_name;" );
		}

		if ( 'baseball' === $sport ) {
			$this->add_baseball_tables();
		} elseif ( 'basketball' === $sport ) {
			$this->add_basketball_tables();
		} elseif ( 'football' === $sport ) {
			$this->add_football_tables();
		} elseif ( 'hockey' === $sport ) {
			$this->add_hockey_tables();
		} elseif ( 'rugby' === $sport ) {
			$this->add_rugby_tables();
		} elseif ( 'soccer' === $sport ) {
			$this->add_soccer_tables();
		} else {
			$this->add_volleyball_tables();
		}
	}

	/**
	 * Adds in the baseball game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_baseball_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
					game_id INTEGER NOT NULL AUTO_INCREMENT,
					game_week INTEGER,
					game_day DATETIME NOT NULL,
					game_season TEXT NOT NULL,
					game_home_id INTEGER NOT NULL,
					game_away_id INTEGER NOT NULL,
					game_home_final INTEGER,
					game_away_final INTEGER,
					game_attendance INTEGER NOT NULL,
					game_neutral_site INT,
					game_location_stadium TEXT,
					game_location_line_one TEXT,
					game_location_line_two TEXT,
					game_location_city TEXT,
					game_location_state TEXT,
					game_location_country TEXT,
					game_location_zip_code TEXT,
					game_status TEXT NOT NULL,
					game_current_period TEXT,
					game_current_time TEXT,
					game_current_home_score INT,
					game_current_away_score INT,
					game_home_doubles TEXT,
					game_home_triples TEXT,
					game_home_homeruns TEXT,
					game_home_hits INTEGER NOT NULL,
					game_home_errors INTEGER NOT NULL,
					game_home_lob INTEGER NOT NULL,
					game_away_doubles TEXT,
					game_away_triples TEXT,
					game_away_homeruns TEXT,
					game_away_hits INTEGER NOT NULL,
					game_away_errors INTEGER NOT NULL,
					game_away_lob INTEGER NOT NULL,
					game_recap TEXT,
					game_preview TEXT,
					PRIMARY KEY (game_id)
			) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
					game_info_id INTEGER NOT NULL AUTO_INCREMENT,
					game_id INTEGER NOT NULL,
					game_info_inning INTEGER NOT NULL,
					game_info_top_bottom TEXT NOT NULL,
					game_info_home_score INTEGER NOT NULL,
					game_info_away_score INTEGER NOT NULL,
					game_info_runs_scored INT NOT NULL,
					game_info_score_play TEXT NOT NULL,
					PRIMARY KEY (game_info_id)
			)";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
					game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
					game_id INTEGER NOT NULL,
					game_team_id INTEGER NOT NULL,
					game_player_id INTEGER NOT NULL,
					game_player_at_bats INTEGER NOT NULL,
					game_player_hits INTEGER NOT NULL,
					game_player_runs INTEGER NOT NULL,
					game_player_rbis INTEGER NOT NULL,
					game_player_doubles INTEGER NOT NULL,
					game_player_triples INTEGER NOT NULL,
					game_player_homeruns INTEGER NOT NULL,
					game_player_strikeouts INTEGER NOT NULL,
					game_player_walks INTEGER NOT NULL,
					game_player_hit_by_pitch INTEGER NOT NULL,
					game_player_fielders_choice INTEGER NOT NULL,
					game_player_position TEXT NOT NULL,
					game_player_innings_pitched DOUBLE NOT NULL,
					game_player_pitcher_strikeouts INTEGER NOT NULL,
					game_player_pitcher_walks INTEGER NOT NULL,
					game_player_hit_batters INTEGER NOT NULL,
					game_player_runs_allowed INTEGER NOT NULL,
					game_player_earned_runs INTEGER NOT NULL,
					game_player_hits_allowed INTEGER NOT NULL,
					game_player_homeruns_allowed INTEGER NOT NULL,
					game_player_pitch_count INTEGER NOT NULL,
					game_player_decision TEXT,
					PRIMARY KEY (game_stats_player_id)
			)";
		dbDelta( $sql );
	}

	/**
	 * Adds in the basketball game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_basketball_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER NOT NULL,
				game_away_id INTEGER NOT NULL,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_quarter INTEGER,
				game_home_second_quarter INTEGER,
				game_home_third_quarter INTEGER,
				game_home_fourth_quarter INTEGER,
				game_home_overtime INTEGER,
				game_home_fgm INTEGER NOT NULL,
				game_home_fga INTEGER NOT NULL,
				game_home_3pm INTEGER NOT NULL,
				game_home_3pa INTEGER NOT NULL,
				game_home_ftm INTEGER NOT NULL,
				game_home_fta INTEGER NOT NULL,
				game_home_off_rebound INTEGER NOT NULL,
				game_home_def_rebound INTEGER NOT NULL,
				game_home_assists INTEGER NOT NULL,
				game_home_steals INTEGER NOT NULL,
				game_home_blocks INTEGER NOT NULL,
				game_home_pip INTEGER NOT NULL,
				game_home_to INTEGER NOT NULL,
				game_home_pot INTEGER NOT NULL,
				game_home_fast_break INTEGER NOT NULL,
				game_home_fouls INTEGER NOT NULL,
				game_away_first_quarter INTEGER,
				game_away_second_quarter INTEGER,
				game_away_third_quarter INTEGER,
				game_away_fourth_quarter INTEGER,
				game_away_overtime INTEGER,
				game_away_fgm INTEGER NOT NULL,
				game_away_fga INTEGER NOT NULL,
				game_away_3pm INTEGER NOT NULL,
				game_away_3pa INTEGER NOT NULL,
				game_away_ftm INTEGER NOT NULL,
				game_away_fta INTEGER NOT NULL,
				game_away_off_rebound INTEGER NOT NULL,
				game_away_def_rebound INTEGER NOT NULL,
				game_away_assists INTEGER NOT NULL,
				game_away_steals INTEGER NOT NULL,
				game_away_blocks INTEGER NOT NULL,
				game_away_pip INTEGER NOT NULL,
				game_away_to INTEGER NOT NULL,
				game_away_pot INTEGER NOT NULL,
				game_away_fast_break INTEGER NOT NULL,
				game_away_fouls INTEGER NOT NULL,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_info_referees TEXT NOT NULL,
				game_info_techs TEXT,
				PRIMARY KEY (game_info_id)
		)";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_started TEXT,
				game_player_minutes TIME NOT NULL,
				game_player_fgm INTEGER NOT NULL,
				game_player_fga INTEGER NOT NULL,
				game_player_3pm INTEGER NOT NULL,
				game_player_3pa INTEGER NOT NULL,
				game_player_ftm INTEGER NOT NULL,
				game_player_fta INTEGER NOT NULL,
				game_player_points INTEGER NOT NULL,
				game_player_off_rebound INTEGER NOT NULL,
				game_player_def_rebound INTEGER NOT NULL,
				game_player_assists INTEGER NOT NULL,
				game_player_steals INTEGER NOT NULL,
				game_player_blocks INTEGER NOT NULL,
				game_player_to INTEGER NOT NULL,
				game_player_fouls INTEGER NOT NULL,
				game_player_plus_minus DOUBLE UNSIGNED NOT NULL,
				PRIMARY KEY (game_stats_player_id)
		)";
		dbDelta( $sql );

	}

	/**
	 * Adds in the football game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_football_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER NOT NULL,
				game_away_id INTEGER NOT NULL,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_quarter INTEGER,
				game_home_second_quarter INTEGER,
				game_home_third_quarter INTEGER,
				game_home_fourth_quarter INTEGER,
				game_home_overtime INTEGER,
				game_home_total INTEGER NOT NULL,
				game_home_pass INTEGER NOT NULL,
				game_home_rush INTEGER NOT NULL,
				game_home_to INTEGER NOT NULL,
				game_home_ints INTEGER NOT NULL,
				game_home_fumbles INTEGER NOT NULL,
				game_home_fumbles_lost INTEGER NOT NULL,
				game_home_possession TEXT NOT NULL,
				game_home_kick_returns INT NOT NULL,
				game_home_kick_return_yards INT NOT NULL,
				game_home_penalties INT NOT NULL,
				game_home_penalty_yards INT NOT NULL,
				game_home_first_downs INT NOT NULL,
				game_away_first_quarter INTEGER,
				game_away_second_quarter INTEGER,
				game_away_third_quarter INTEGER,
				game_away_fourth_quarter INTEGER,
				game_away_overtime INTEGER,
				game_away_total INTEGER NOT NULL,
				game_away_pass INTEGER NOT NULL,
				game_away_rush INTEGER NOT NULL,
				game_away_to INTEGER NOT NULL,
				game_away_ints INTEGER NOT NULL,
				game_away_fumbles INTEGER NOT NULL,
				game_away_fumbles_lost INTEGER NOT NULL,
				game_away_possession TEXT NOT NULL,
				game_away_kick_returns INT NOT NULL,
				game_away_kick_return_yards INT NOT NULL,
				game_away_penalties INT NOT NULL,
				game_away_penalty_yards INT NOT NULL,
				game_away_first_downs INT NOT NULL,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_info_quarter INTEGER NOT NULL,
				game_info_time TEXT NOT NULL,
				game_info_scoring_team_id INT NOT NULL,
				game_info_home_score INT NOT NULL,
				game_info_away_score INT NOT NULL,
				game_info_play TEXT NOT NULL,
				PRIMARY KEY (game_info_id)
		)";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_completions INTEGER,
				game_player_attempts INTEGER,
				game_player_pass_yards INTEGER,
				game_player_pass_tds INTEGER,
				game_player_pass_ints INTEGER,
				game_player_rushes INTEGER,
				game_player_rush_yards INTEGER,
				game_player_rush_tds INTEGER,
				game_player_rush_fumbles INTEGER,
				game_player_catches INTEGER,
				game_player_receiving_yards INTEGER,
				game_player_receiving_tds INTEGER,
				game_player_receiving_fumbles INTEGER,
				game_player_tackles DOUBLE,
				game_player_tfl DOUBLE,
				game_player_sacks DOUBLE,
				game_player_pbu INTEGER,
				game_player_ints INTEGER,
				game_player_tds INTEGER,
				game_player_ff INTEGER,
				game_player_fr INTEGER,
				game_player_blocked INTEGER,
				game_player_yards INTEGER,
				game_player_fga INTEGER,
				game_player_fgm INTEGER,
				game_player_xpa INTEGER,
				game_player_xpm INTEGER,
				game_player_touchbacks INTEGER,
				game_player_returns INTEGER,
				game_player_return_yards INTEGER,
				game_player_return_tds INTEGER,
				game_player_return_fumbles INTEGER,
				PRIMARY KEY (game_stats_player_id)
		)";
		dbDelta( $sql );
	}

	/**
	 * Adds in the hockey game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_hockey_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER,
				game_away_id INTEGER,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_period INTEGER,
				game_home_first_sog INTEGER,
				game_home_second_period INTEGER,
				game_home_second_sog INTEGER,
				game_home_third_period INTEGER,
				game_home_third_sog INTEGER,
				game_home_overtime INTEGER,
				game_home_overtime_sog INTEGER,
				game_home_shootout INTEGER,
				game_home_power_plays INTEGER,
				game_home_pp_goals INTEGER,
				game_home_pen_minutes INTEGER,
				game_away_first_period INTEGER,
				game_away_first_sog INTEGER,
				game_away_second_period INTEGER,
				game_away_second_sog INTEGER,
				game_away_third_period INTEGER,
				game_away_third_sog INTEGER,
				game_away_overtime INTEGER,
				game_away_overtime_sog INTEGER,
				game_away_shootout INTEGER,
				game_away_power_plays INTEGER,
				game_away_pp_goals INTEGER,
				game_away_pen_minutes INTEGER,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_info_event TEXT NOT NULL,
				game_info_period TEXT NOT NULL,
				game_info_time TEXT NOT NULL,
				player_id INTEGER NOT NULL,
				game_info_assist_one_id INTEGER,
				game_info_assist_two_id INTEGER,
				game_info_penalty TEXT,
				team_id INTEGER,
			  	PRIMARY KEY (game_info_id)
		)";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_goals INTEGER,
				game_player_assists INTEGER,
				game_player_plus_minus INTEGER,
				game_player_sog INTEGER,
				game_player_penalties INTEGER,
				game_player_pen_minutes INTEGER,
				game_player_hits INTEGER,
				game_player_shifts INTEGER,
				game_player_time_on_ice TIME NOT NULL,
				game_player_faceoffs INTEGER,
				game_player_faceoff_wins INTEGER,
				game_player_shots_faced INTEGER,
				game_player_saves INTEGER,
				game_player_goals_allowed INTEGER,
				PRIMARY KEY (game_stats_player_id)
		)";
		dbDelta( $sql );

	}

	/**
	 * Adds in the rugby game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_rugby_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER NOT NULL,
				game_away_id INTEGER NOT NULL,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_half INTEGER,
				game_home_second_half INTEGER,
				game_home_extratime INTEGER,
				game_home_shootout INTEGER,
				game_home_tries INTEGER,
				game_home_conversions INTEGER,
				game_home_penalty_goals INTEGER,
				game_home_kick_percentage INTEGER,
				game_home_meters_runs INTEGER,
				game_home_meters_hand INTEGER,
				game_home_meters_pass INTEGER,
				game_home_possession INTEGER,
				game_home_clean_breaks INTEGER,
				game_home_defenders_beaten INTEGER,
				game_home_offload INTEGER,
				game_home_rucks INTEGER,
				game_home_mauls INTEGER,
				game_home_turnovers_conceeded INTEGER,
				game_home_scrums INTEGER,
				game_home_lineouts INTEGER,
				game_home_penalties_conceeded INTEGER,
				game_home_red_cards INTEGER,
				game_home_yellow_cards INTEGER,
				game_home_free_kicks_conceeded INTEGER,
				game_away_first_half INTEGER,
				game_away_second_half INTEGER,
				game_away_extratime INTEGER,
				game_away_shootout INTEGER,
				game_away_tries INTEGER,
				game_away_conversions INTEGER,
				game_away_penalty_goals INTEGER,
				game_away_kick_percentage INTEGER,
				game_away_meters_runs INTEGER,
				game_away_meters_hand INTEGER,
				game_away_meters_pass INTEGER,
				game_away_possession INTEGER,
				game_away_clean_breaks INTEGER,
				game_away_defenders_beaten INTEGER,
				game_away_offload INTEGER,
				game_away_rucks INTEGER,
				game_away_mauls INTEGER,
				game_away_turnovers_conceeded INTEGER,
				game_away_scrums INTEGER,
				game_away_lineouts INTEGER,
				game_away_penalties_conceeded INTEGER,
				game_away_red_cards INTEGER,
				game_away_yellow_cards INTEGER,
				game_away_free_kicks_conceeded INTEGER,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				team_id INTEGER NOT NULL,
				game_info_home_score INTEGER NOT NULL,
				game_info_away_score INTEGER NOT NULL,
				game_info_event TEXT NOT NULL,
				game_info_time INTEGER NOT NULL,
				player_id INTEGER NOT NULL,
				PRIMARY KEY (game_info_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_tries INTEGER NOT NULL,
				game_player_assists INTEGER NOT NULL,
				game_player_conversions INTEGER NOT NULL,
				game_player_penalty_goals INTEGER NOT NULL,
				game_player_drop_kicks INTEGER NOT NULL,
				game_player_points INTEGER NOT NULL,
				game_player_penalties_conceeded INTEGER NOT NULL,
				game_player_meters_run INTEGER NOT NULL,
				game_player_red_cards INTEGER NOT NULL,
				game_player_yellow_cards INTEGER NOT NULL,
				PRIMARY KEY (game_stats_player_id)
		) $charset_collate;";
		dbDelta( $sql );

	}

	/**
	 * Adds in the soccer game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_soccer_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER NOT NULL,
				game_away_id INTEGER NOT NULL,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_half INTEGER,
				game_home_second_half INTEGER,
				game_home_extratime INTEGER,
				game_home_pks INTEGER,
				game_home_possession INTEGER NOT NULL,
				game_home_shots INTEGER NOT NULL,
				game_home_sog INTEGER NOT NULL,
				game_home_corners INTEGER NOT NULL,
				game_home_offsides INTEGER NOT NULL,
				game_home_fouls INTEGER NOT NULL,
				game_home_saves INTEGER NOT NULL,
				game_home_yellow INTEGER NOT NULL,
				game_home_red INTEGER NOT NULL,
				game_away_first_half INTEGER,
				game_away_second_half INTEGER,
				game_away_extratime INTEGER,
				game_away_pks INTEGER,
				game_away_possession INTEGER NOT NULL,
				game_away_shots INTEGER NOT NULL,
				game_away_sog INTEGER NOT NULL,
				game_away_corners INTEGER NOT NULL,
				game_away_offsides INTEGER NOT NULL,
				game_away_fouls INTEGER NOT NULL,
				game_away_saves INTEGER NOT NULL,
				game_away_yellow INTEGER NOT NULL,
				game_away_red INTEGER NOT NULL,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				team_id INTEGER NOT NULL,
				game_info_home_score INTEGER NOT NULL,
				game_info_away_score INTEGER NOT NULL,
				game_info_event TEXT NOT NULL,
				game_info_time INTEGER NOT NULL,
				player_id INTEGER NOT NULL,
				game_player_id TEXT NOT NULL,
				game_info_assists TEXT,
				PRIMARY KEY (game_info_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_minutes INTEGER NOT NULL,
				game_player_goals INTEGER NOT NULL,
				game_player_assists INTEGER NOT NULL,
				game_player_shots INTEGER NOT NULL,
				game_player_sog INTEGER NOT NULL,
				game_player_fouls INTEGER NOT NULL,
				game_player_fouls_suffered INTEGER NOT NULL,
				game_player_shots_faced INTEGER NOT NULL,
				game_player_shots_saved INTEGER NOT NULL,
				game_player_goals_allowed INTEGER NOT NULL,
				PRIMARY KEY (game_stats_player_id)
		) $charset_collate;";
		dbDelta( $sql );

	}

	/**
	 * Adds in the volleyball game, game_info and game_events tables.
	 *
	 * @since 2.0.0
	 */
	private function add_volleyball_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_games';
		$sql        = "CREATE TABLE $table_name (
				game_id INTEGER NOT NULL AUTO_INCREMENT,
				game_week INTEGER,
				game_day DATETIME NOT NULL,
				game_season TEXT NOT NULL,
				game_home_id INTEGER NOT NULL,
				game_away_id INTEGER NOT NULL,
				game_home_final INTEGER,
				game_away_final INTEGER,
				game_attendance INTEGER NOT NULL,
				game_neutral_site INT,
				game_location_stadium TEXT,
				game_location_line_one TEXT,
				game_location_line_two TEXT,
				game_location_city TEXT,
				game_location_state TEXT,
				game_location_country TEXT,
				game_location_zip_code TEXT,
				game_status TEXT NOT NULL,
				game_current_period TEXT,
				game_current_time TEXT,
				game_current_home_score INT,
				game_current_away_score INT,
				game_home_first_set INTEGER,
				game_home_second_set INTEGER,
				game_home_third_set INTEGER,
				game_home_fourth_set INTEGER,
				game_home_fifth_set INTEGER,
				game_home_kills INTEGER,
				game_home_blocks INTEGER,
				game_home_aces INTEGER,
				game_home_assists INTEGER,
				game_home_digs INTEGER,
				game_home_attacks INTEGER,
				game_home_hitting_errors INTEGER,
				game_away_first_set INTEGER,
				game_away_second_set INTEGER,
				game_away_third_set INTEGER,
				game_away_fourth_set INTEGER,
				game_away_fifth_set INTEGER,
				game_away_kills INTEGER,
				game_away_blocks INTEGER,
				game_away_aces INTEGER,
				game_away_assists INTEGER,
				game_away_digs INTEGER,
				game_away_attacks INTEGER,
				game_away_hitting_errors INTEGER,
				game_recap TEXT,
				game_preview TEXT,
				PRIMARY KEY (game_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_info';
		$sql        = "CREATE TABLE $table_name (
				game_info_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_info_referees TEXT NOT NULL,
				PRIMARY KEY (game_info_id)
		) $charset_collate;";
		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'sb_game_stats';
		$sql        = "CREATE TABLE $table_name (
				game_stats_player_id INTEGER NOT NULL AUTO_INCREMENT,
				game_id INTEGER NOT NULL,
				game_team_id INTEGER NOT NULL,
				game_player_id INTEGER NOT NULL,
				game_player_sets_played INTEGER NOT NULL,
				game_player_points INTEGER NOT NULL,
				game_player_kills INTEGER NOT NULL,
				game_player_hitting_errors INTEGER NOT NULL,
				game_player_attacks INTEGER NOT NULL,
				game_player_set_attempts INTEGER NOT NULL,
				game_player_set_errors INTEGER NOT NULL,
				game_player_serves INTEGER NOT NULL,
				game_player_serve_errors INTEGER NOT NULL,
				game_player_aces INTEGER NOT NULL,
				game_player_blocks INTEGER NOT NULL,
				game_player_block_attempts INTEGER NOT NULL,
				game_player_block_errors INTEGER NOT NULL,
				game_player_digs INTEGER NOT NULL,
				game_player_receiving_errors INTEGER NOT NULL,
				PRIMARY KEY (game_stats_player_id)
		) $charset_collate;";
		dbDelta( $sql );

	}

}

