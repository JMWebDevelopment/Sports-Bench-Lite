<?php
/**
 * Fired during plugin activation.
 *
 * This file creates the activator class which is called during plugin activation.
 * It adds in the tables needed for the plugin.
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 * @author     Jacob Martella <me@jacobmartella.com>
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
class Sports_Bench_Activator {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 *
	 * @var string $version Version of the plugin.
	 * @access private
	 */
	private $version;


	/**
	 * Builds the Sports_Bench_Activator object.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Runs code when the plugin is activated.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version      The current version number of the plugin.
	 */
	public function activate( $version ) {
		if ( is_plugin_active( 'sports-bench/sports-bench.php' ) ) {
			deactivate_plugins( 'sports-bench/sports-bench.php' );
		} else {
			$this->set_sport();
			$this->create_db();
		}
		$this->set_version_number();
	}

	/**
	 * Sets the sport for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function set_sport() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_teams';
		$query      = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( $wpdb->get_var( $query ) != $table_name ) {
			add_option( 'sports-bench-sport', 'baseball' );
		}
	}

	/**
	 * Sets the version number for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function set_version_number() {
		add_option( 'sports_bench_version', $this->version );
	}

	/**
	 * Creates the necessary database tables.
	 *
	 * @since 2.0.0
	 */
	private function create_db() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_teams';
		$query      = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

		if ( $wpdb->get_var( $query ) != $table_name ) {
			$this->add_teams_table();
			$this->add_players_table();
			$this->add_divisions_table();
			$this->add_games_table();
			$this->add_game_info_table();
			$this->add_game_stats_table();
		}
	}

	/**
	 * Creates the teams table.
	 *
	 * @since 2.0.0
	 */
	private function add_teams_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_teams';
		$sql        = "CREATE TABLE $table_name (
				team_id INTEGER NOT NULL AUTO_INCREMENT,
				team_name TEXT NOT NULL,
				team_location TEXT NOT NULL,
				team_nickname TEXT,
				team_abbreviation TEXT NOT NULL,
				team_active TEXT NOT NULL,
				team_location_line_one TEXT,
				team_location_line_two TEXT,
				team_city TEXT NOT NULL,
				team_state TEXT NOT NULL,
				team_location_country TEXT,
				team_location_zip_code TEXT,
				team_stadium TEXT NOT NULL,
				team_stadium_capacity INTEGER NOT NULL,
				team_head_coach TEXT NOT NULL,
				team_division INTEGER NOT NULL,
				team_primary_color TEXT NOT NULL,
				team_secondary_color TEXT NOT NULL,
				team_logo TEXT NOT NULL,
				team_photo TEXT NOT NULL,
				team_slug TEXT NOT NULL,
				PRIMARY KEY (team_id)
		) $charset_collate;";
		dbDelta( $sql );
	}

	/**
	 * Creates the players table.
	 *
	 * @since 2.0.0
	 */
	private function add_players_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_players';
		$sql        = "CREATE TABLE $table_name (
				player_id INTEGER NOT NULL AUTO_INCREMENT,
				player_first_name TEXT NOT NULL,
				player_last_name TEXT NOT NULL,
				player_birth_day DATE NOT NULL,
				player_photo TEXT NOT NULL,
				player_position TEXT NOT NULL,
				player_home_city TEXT NOT NULL,
				player_home_state TEXT NOT NULL,
				team_id INTEGER NOT NULL,
				player_weight INTEGER NOT NULL,
				player_height TEXT NOT NULL,
				player_slug TEXT NOT NULL,
				player_bio TEXT NOT NULL,
				PRIMARY KEY (player_id)
		) $charset_collate;";
		dbDelta( $sql );
	}

	/**
	 * Creates the divisions table.
	 *
	 * @since 2.0.0
	 */
	private function add_divisions_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table_name = $wpdb->prefix . 'sb_divisions';
		$sql        = "CREATE TABLE $table_name (
				division_id INTEGER NOT NULL AUTO_INCREMENT,
				division_name TEXT NOT NULL,
				division_conference TEXT NOT NULL,
				division_conference_id INTEGER,
				division_color TEXT,
				PRIMARY KEY (division_id)
		) $charset_collate;";
		dbDelta( $sql );
	}

	/**
	 * Creates the games table.
	 *
	 * @since 2.0.0
	 */
	private function add_games_table() {
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
	}

	/**
	 * Creates the game info table.
	 *
	 * @since 2.0.0
	 */
	private function add_game_info_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

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
	}

	/**
	 * Creates the game stats table.
	 *
	 * @since 2.0.0
	 */
	private function add_game_stats_table() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

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

}
