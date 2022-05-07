<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
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
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 */
class Sports_Bench {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  2.0.0
	 *
	 * @access protected
	 * @var    Sports_Bench_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since  2.0.0
	 *
	 * @access protected
	 * @var    string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  2.0.0
	 *
	 * @access protected
	 * @var    string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Builds the main object for the plugin.
	 *
	 * @since  2.0.0
	 */
	public function __construct() {

		$this->plugin_slug = 'sports-bench-lite';
		$this->version     = '2.2';

		$this->load_dependencies();
		$this->load_classes();
		$this->load_functions();
		$this->set_locale();
		$this->define_setup_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_rest_api_hooks();
		$this->load_sport();
		$this->define_block_hooks();
		$this->update_database();

		/**
		 * Fires to load custom functions and files after Sports Bench is loaded.
		 *
		 * @since 2.0.0
		 */
		do_action( 'sports_bench_loaded' );

	}

	/**
	 * Loads all of the files we're depending on to run the plugin.
	 *
	 * @since  2.0.0
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sports-bench-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sports-bench-setup.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sports-bench-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sports-bench-public.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sports-bench-database.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'blocks/class-sports-bench-blocks.php';

		require_once plugin_dir_path( __FILE__ ) . 'class-sports-bench-loader.php';
		$this->loader = new Sports_Bench_Loader();

	}

	/**
	 * Loads all of the classes used for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function load_classes() {

		// Base classes.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-database.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-display.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-division.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-game.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-games.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-player.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-players.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-scoreboard.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-standings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-stats.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-team.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/base/class-teams.php';

		// Screen classes.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/class-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-divisions-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-games-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-options-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-players-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-teams-screen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/screens/admin/class-tinymce-button.php';

		// REST API classes.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-division-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-game-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-game-info-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-game-stats-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-player-rest-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/rest-api/class-team-rest-api.php';

		// Sports Classes.
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/baseball/class-baseball-teams.php';
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/basketball/class-basketball-teams.php';
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/football/class-football-teams.php';
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/hockey/class-hockey-teams.php';
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/rugby/class-rugby-teams.php';
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/soccer/class-soccer-teams.php';
		} else {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-admin-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-game.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-games.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-player.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-players.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-team.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/sports/volleyball/class-volleyball-teams.php';
		}
	}

	/**
	 * Loads in the files that create functions that can be used in the plugin.
	 *
	 * @since 2.0.0
	 */
	private function load_functions() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/games.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/display.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/players.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/scoreboard.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/standings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/stats.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/teams.php';

		// Shortcodes.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/box-score.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/game.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/scoreboard.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/standings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/stats.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/player.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/player-page.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/team.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/shortcodes/team-page.php';
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sports_Bench_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    2.0.0
	 *
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Sports_Bench_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Runs all of the setup functions for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function define_setup_hooks() {
		$plugin_setup = new Sports_Bench_Setup( $this->get_version() );
		$this->loader->add_action( 'init', $plugin_setup, 'custom_taxonomies' );
		$this->loader->add_action( 'admin_menu', $plugin_setup, 'add_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_setup, 'save_meta_box' );
		$this->loader->add_action( 'wp_ajax_sports_bench_load_season_games', $plugin_setup, 'load_season_games' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_season_games', $plugin_setup, 'load_season_games' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_setup, 'load_season_games_js' );
	}

	/**
	 * Runs all of the admin hooks for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function define_admin_hooks() {
		$admin        = new Sports_Bench_Admin( $this->get_version() );
		$plugin_setup = new Sports_Bench_Setup( $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $admin, 'add_menu_pages' );
		$this->loader->add_action( 'wp_ajax_sports_bench_load_bracket', $admin, 'load_bracket' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_bracket', $admin, 'load_bracket' );
		$this->loader->add_action( 'admin_init', $admin, 'register_plugin_options' );
		$this->loader->add_action( 'admin_menu', $admin, 'add_meta_boxes' );
		$this->loader->add_action( 'save_post', $admin, 'save_post_meta_box' );
		$this->loader->add_action( 'save_post', $admin, 'save_standings_meta_box' );
		$this->loader->add_action( 'save_post', $admin, 'save_stats_meta_box' );
		$this->loader->add_action( 'admin_bar_menu', $admin, 'add_items_to_add_item_menu', 999 );
		$this->loader->add_action( 'admin_bar_menu', $admin, 'add_quick_admin_menu', 999 );
		$this->loader->add_action( 'admin_post_generate_csv', $admin, 'print_csv' );
		$this->loader->add_action( 'wp_dashboard_setup', $admin, 'add_dashboard_widget' );
		$this->loader->add_action( 'wp_ajax_sportsbench_tinymce', $admin, 'ajax_tinymce' );
		$this->loader->add_action( 'admin_notices', $admin, 'add_upgrade_admin_notice' );
		$this->loader->add_action( 'wp_ajax_sports_bench_lite_dismiss_upgrade_notice', $admin, 'dismiss_upgrade_notice' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_lite_dismiss_upgrade_notice', $admin, 'dismiss_upgrade_notice' );
		$this->loader->add_action( 'init', $admin, 'add_team_manager_role' );
		$this->loader->add_action( 'show_user_profile', $admin, 'add_user_fields' );
		$this->loader->add_action( 'edit_user_profile', $admin, 'add_user_fields' );
		$this->loader->add_action( 'personal_options_update', $admin, 'save_user_fields' );
		$this->loader->add_action( 'edit_user_profile_update', $admin, 'save_user_fields' );

		$team = new Classes\Screens\Admin\TeamsScreen();
		$this->loader->add_action( 'sports_bench_new_team_fields', $team, 'sports_bench_do_default_new_team_fields' );
		$this->loader->add_filter( 'sports_bench_save_team', $team, 'sports_bench_do_save_team' );
		$this->loader->add_filter( 'sports_bench_get_admin_team_info', $team, 'sports_bench_do_get_team_admin_info', 10, 2 );
		$this->loader->add_action( 'sports_bench_edit_team_fields', $team, 'sports_bench_do_default_team_fields', 10, 2 );

		$player = new Classes\Screens\Admin\PlayersScreen();
		$this->loader->add_action( 'sports_bench_new_player_fields', $player, 'sports_bench_do_default_new_player_fields' );
		$this->loader->add_filter( 'sports_bench_save_player', $player, 'sports_bench_do_save_player' );
		$this->loader->add_filter( 'sports_bench_get_admin_player_info', $player, 'sports_bench_do_get_player_admin_info', 10, 2 );
		$this->loader->add_action( 'sports_bench_edit_player_fields', $player, 'sports_bench_do_default_player_fields', 10, 2 );
	}

	/**
	 * Runs all of the public hooks for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function define_public_hooks() {
		$public = new Sports_Bench_Public( $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );
		$this->loader->add_action( 'widgets_init', $public, 'register_widgets' );
		$this->loader->add_action( 'init', $public, 'register_shortcodes' );
		$this->loader->add_filter( 'query_vars', $public, 'add_vars', 10, 1 );
		$this->loader->add_action( 'template_redirect', $public, 'template_redirect' );
		$this->loader->add_action( 'init', $public, 'rewrite_tags', 10, 0 );
		$this->loader->add_action( 'init', $public, 'rewrite_rule', 10, 0 );
		$this->loader->add_filter( 'document_title_parts', $public, 'page_title', 10 );
		$this->loader->add_action( 'admin_bar_menu', $public, 'add_toolbar_links_to_edit', 999 );
		$public->run_scoreboard();
		$public->run_teams();
		$public->run_player();
		$public->run_games();
		$public->run_standings();
		$public->run_stats();
	}

	/**
	 * Runs all of the block hooks for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function define_block_hooks() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}
		$blocks = new Sports_Bench_Blocks( $this->get_version() );
		$this->loader->add_action( 'enqueue_block_editor_assets', $blocks, 'enqueue_blocks' );
		$this->loader->add_action( 'init', $blocks, 'render_blocks' );
		$this->loader->add_filter( 'block_categories', $blocks, 'add_block_categories' );
	}

	/**
	 * Runs any updates needed to the database
	 *
	 * @since 2.0.0
	 */
	private function update_database() {
		$database = new Sports_Bench_Database( $this->version );
		$this->loader->add_action( 'plugins_loaded', $database, 'update_plugin_database' );
		update_option( 'sports_bench_version', $this->get_version() );
	}

	/**
	 * Runs all of the REST API hooks for the plugin.
	 *
	 * @since 2.0.0
	 */
	private function define_rest_api_hooks() {
		$rest_apis = new Classes\REST_API\Sports_Bench_REST_API( $this->get_version() );
		$this->loader->add_action( 'rest_api_init', $rest_apis, 'register_endpoints' );
		$this->loader->add_action( 'rest_api_init', $rest_apis, 'register_routes' );
	}

	/**
	 * Loads in the sport-specific hooks based on the selected sport.
	 *
	 * @since 2.0.0
	 */
	private function load_sport() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Baseball\Baseball( $this->version );
			$sport->run();
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Basketball\Basketball( $this->version );
			$sport->run();
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Football\Football( $this->version );
			$sport->run();
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Hockey\Hockey( $this->version );
			$sport->run();
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Rugby\Rugby( $this->version );
			$sport->run();
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new Classes\Sports\Soccer\Soccer( $this->version );
			$sport->run();
		} else {
			$sport = new Classes\Sports\Volleyball\Volleyball( $this->version );
			$sport->run();
		}
	}

	/**
	 * Runs the plugin set up.
	 *
	 * @since 2.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Gets the current version of the plugin.
	 *
	 * @since  2.0.0
	 *
	 * @return string    The version of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     2.0.0
	 *
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 *
	 * @return    Sports_Bench_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
}
