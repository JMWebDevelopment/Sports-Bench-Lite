<?php
/**
 * Holds all of the public side functions.
 *
 * PHP version 7.3
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public
 */

namespace Sports_Bench;

use Sports_Bench\Sports_Bench_Loader;
use Sports_Bench\Classes\Base\Games;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Scoreboard;
use Sports_Bench\Classes\Base\Standings;
use Sports_Bench\Classes\Base\Stats;
use Sports_Bench\Classes\Base\Teams;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Players;
use Sports_Bench\Classes\Base\Team;

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run on the public side of the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public
 */
class Sports_Bench_Public {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @var   Sports_Bench_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Builds the Sports_Bench_Public object.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
		$this->loader  = new Sports_Bench_Loader();
	}

	/**
	 * Enqueues the styles for the public side of the plugin.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_styles() {
		global $scoreboard_bar;

		wp_enqueue_style( 'sports-bench-general-styles', plugin_dir_url( __FILE__ ) . 'css/sports-bench-general.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-scoreboard-bar-styles', plugin_dir_url( __FILE__ ) . 'css/scoreboard-bar.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-scoreboard-widget-styles', plugin_dir_url( __FILE__ ) . 'css/scoreboard-widget.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-scoreboard-styles', plugin_dir_url( __FILE__ ) . 'css/scoreboard.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-team-block', plugin_dir_url( __FILE__ ) . 'css/team-block.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-teams', plugin_dir_url( __FILE__ ) . 'css/teams.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-player-block', plugin_dir_url( __FILE__ ) . 'css/player-block.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-player-page', plugin_dir_url( __FILE__ ) . 'css/player-page.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-game-block', plugin_dir_url( __FILE__ ) . 'css/game-block.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-box-score', plugin_dir_url( __FILE__ ) . 'css/box-score.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-standings', plugin_dir_url( __FILE__ ) . 'css/standings.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-standings-widget', plugin_dir_url( __FILE__ ) . 'css/standings-widget.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-stats', plugin_dir_url( __FILE__ ) . 'css/stats.min.css', [], $this->version, 'all' );
		wp_enqueue_style( 'sports-bench-stats-widget', plugin_dir_url( __FILE__ ) . 'css/stats-widget.min.css', [], $this->version, 'all' );
	}

	/**
	 * Enqueues the scripts for the public side of the plugin.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'sports-bench-scoreboard-bar', plugin_dir_url( __FILE__ ) . 'js/scoreboard-bar.min.js', [ 'jquery', 'jquery-ui-core' ], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-scoreboard-bar', 'async', true );
		wp_script_add_data( 'sports-bench-scoreboard-bar', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-scoreboard' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
		];
		wp_localize_script( 'sports-bench-scoreboard-bar', 'sbscoreboard', $args );

		wp_enqueue_script( 'sports-bench-scoreboard', plugin_dir_url( __FILE__ ) . 'js/scoreboard.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-scoreboard', 'async', true );
		wp_script_add_data( 'sports-bench-scoreboard', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-load-games' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
		];
		wp_localize_script( 'sports-bench-scoreboard', 'sbloadgames', $args );

		wp_enqueue_script( 'sports-bench-load-player-list', plugin_dir_url( __FILE__ ) . 'js/load-player-list.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-load-player-list', 'async', true );
		wp_script_add_data( 'sports-bench-load-player-list', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-load-player-list-nonce' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
		];
		wp_localize_script( 'sports-bench-load-player-list', 'sbloadplayerlist', $args );

		$player = new Player( get_query_var( 'pagename' ) );

		wp_enqueue_script( 'sports-bench-load-seasons', plugin_dir_url( __FILE__ ) . 'js/load-seasons.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-load-seasons', 'async', true );
		wp_script_add_data( 'sports-bench-load-seasons', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-load-seasons' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
		];
		wp_localize_script( 'sports-bench-load-seasons', 'sbloadseasons', $args );

		wp_enqueue_script( 'sports-bench-standings', plugin_dir_url( __FILE__ ) . 'js/standings.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-standings', 'async', true );
		wp_script_add_data( 'sports-bench-standings', 'precache', true );

		wp_enqueue_script( 'sports-bench-stats', plugin_dir_url( __FILE__ ) . 'js/stats.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-stats', 'async', true );
		wp_script_add_data( 'sports-bench-stats', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-statistics' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
		];
		wp_localize_script( 'sports-bench-stats', 'sbloadstats', $args );

		wp_enqueue_script( 'sports-bench-box-score', plugin_dir_url( __FILE__ ) . 'js/box-score.min.js', [], $this->version, 'all' );
		wp_script_add_data( 'sports-bench-box-score', 'async', true );
		wp_script_add_data( 'sports-bench-box-score', 'precache', true );
		$args = [
			'nonce'    => wp_create_nonce( 'sports-bench-box-score' ),
			'url'      => admin_url( 'admin-ajax.php' ),
			'rest_url' => get_home_url() . '/wp-json/',
			'sport'    => get_option( 'sports-bench-sport' ),
		];
		wp_localize_script( 'sports-bench-box-score', 'sbboxscore', $args );
	}

	/**
	 * Registers the widgets for the plugin.
	 *
	 * @since 2.0.0
	 */
	public function register_widgets() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/widgets/scoreboard-widget.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/widgets/standings-widget.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/widgets/stats-widget.php';

		register_widget( 'Sports_Bench_Scoreboard_Widget' );
		register_widget( 'Sports_Bench_Standings_Widget' );
		register_widget( 'Sports_Bench_Stats_Widget' );
	}

	/**
	 * Registers the shortcodes for the plugin.
	 *
	 * @since 2.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'sports-bench-box-score', 'sports_bench_box_score_shortcode' );
		add_shortcode( 'sports-bench-game', 'sports_bench_game_shortcode' );
		add_shortcode( 'sports-bench-scoreboard', 'sports_bench_scoreboard_shortcode' );
		add_shortcode( 'sports-bench-standings', 'sports_bench_standings_shortcode' );
		add_shortcode( 'sports-bench-stats', 'sports_bench_stats_shortcode' );
		add_shortcode( 'sports-bench-player', 'sports_bench_player_shortcode' );
		add_shortcode( 'sports-bench-player-page', 'sports_bench_player_page_shortcode' );
		add_shortcode( 'sports-bench-team', 'sports_bench_team_shortcode' );
		add_shortcode( 'sports-bench-team-page', 'sports_bench_team_page_shortcode' );
	}

	/**
	 * Adds the team and player query vars.
	 *
	 * @since 2.0.0
	 *
	 * @param array $vars      The current query vars.
	 * @return array           The updated list of query vars.
	 */
	public function add_vars( $vars ) {
		$vars[] = 'team_slug';
		$vars[] = 'player_slug';
		$vars[] = 'team_year';
		return $vars;
	}

	/**
	 * Redirects the URL for a single team or player.
	 *
	 * @since 2.0.0
	 */
	public function template_redirect() {
		if ( isset( $_REQUEST['team_slug'] ) && get_option( 'sports-bench-team-page' ) ) {
			global $wp_query;
			global $post;
			$team                              = new Team( wp_filter_nohtml_kses( sanitize_text_field( $_REQUEST['team_slug'] ) ) );
			$team_slug                         = $team->get_team_slug();
			$wp_query->query_vars['team_slug'] = $team_slug;
			$myurl                             = esc_url( get_home_url() );
			$myurl                            .= '/' . basename( get_permalink( get_the_ID( get_option( 'sports-bench-team-page' ) ) ) ) . '/';
			$myurl                            .= trim( sanitize_title_for_query( $team_slug ) ) . "/";

			if ( isset( $_REQUEST['team_year'] ) ) {
				$wp_query->query_vars['team_year'] = wp_filter_nohtml_kses( sanitize_text_field( $_REQUEST['team_year'] ) );
				$myurl                            .= trim( sanitize_title_for_query( $_REQUEST['team_year'] ) ) . "/";
			}

			wp_redirect( $myurl );
			exit();
		}
		if ( isset( $_REQUEST['player_slug'] ) && get_option( 'sports-bench-player-page' ) ) {
			global $wp_query;
			global $post;
			$player = new Player( wp_filter_nohtml_kses( sanitize_text_field( $_REQUEST['player_slug'] ) ) );
			$player_slug = $player->get_player_slug();
			$wp_query->query_vars['player_slug'] = $player_slug;
			$wp_query->query_vars['page'] = get_option( 'sports-bench-player-page' );
			$wp_query->query_vars['p'] = get_option( 'sports-bench-player-page' );
			$myurl = esc_url( get_home_url() );
			$myurl .= '/' . basename( get_permalink( get_the_ID( get_option( 'sports-bench-player-page' ) ) ) ) . '/';
			$myurl .= trim( sanitize_title_for_query( $player_slug ) ) . "/";
			$post  = get_post( get_option( 'sports-bench-player-page' ) );
			wp_redirect( $myurl );
			exit();
		}
	}

	/**
	 * Rewrites the URL for a single team or player.
	 *
	 * @since 2.0.0
	 */
	public function rewrite_rule() {
		global $post;
		if ( get_post( get_option( 'sports-bench-team-page' ) ) ) {
			$team_page = get_post( get_option( 'sports-bench-team-page' ) );
			$team_page_slug = $team_page->post_name;
			add_rewrite_rule( '^' . $team_page_slug . '/([^/]*)/([^/]*)/?', 'index.php?page_id=' . get_option( 'sports-bench-team-page' ) . '&team_slug=$matches[1]&team_year=$matches[2]', 'top' );
			add_rewrite_rule( '^' . $team_page_slug . '/([^/]*)/?', 'index.php?page_id=' . get_option( 'sports-bench-team-page' ) . '&team_slug=$matches[1]', 'top' );
		}
		if ( get_post( get_option( 'sports-bench-player-page' ) ) ) {
			$player_page      = get_post( get_option( 'sports-bench-player-page' ) );
			$player_page_slug = $player_page->post_name;
			add_rewrite_rule( '^' . $player_page_slug . '/([^/]*)/?', 'index.php?page_id=' . get_option( 'sports-bench-player-page' ) . '&player_slug=$matches[1]', 'top' );
		}
	}

	public function rewrite_tags() {
		add_rewrite_tag( '%team_slug%', '([^&]+)' );
		add_rewrite_tag( '%team_year%', '([^&]+)' );
		add_rewrite_tag( '%player_slug%', '([^&]+)' );
	}

	/**
	 * Changes the page title for a single team or player.
	 *
	 * @since 2.0.0
	 *
	 * @param array $title       The information for the title.
	 * @return array             The updated information for the title.
	 */
	public function page_title( $title ) {
		if ( get_query_var( 'team_slug' ) && get_option( 'sports-bench-team-page' ) ) {
			$team           = new Team( get_query_var( 'team_slug' ) );
			$title['title'] = $team->get_team_name();
		}
		if ( get_query_var( 'player_slug' ) && get_option( 'sports-bench-player-page' ) ) {
			$player         = new Player( get_query_var( 'player_slug' ) );
			$title['title'] = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
		}
		return $title;
	}

	/**
	 * Runs all of the team hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_teams() {
		$teams = new Teams();
		$this->loader->add_filter( 'sports_bench_team_listing_info', $teams, 'sports_bench_do_team_listing_info', 10, 5 );
		$this->loader->add_filter( 'sports_bench_schedule_table', $teams, 'sports_bench_do_schedule_table', 10, 3 );
		$this->loader->add_filter( 'sports_bench_team_shortcode_information', $teams, 'sports_bench_do_team_shortcode_information', 10, 3 );
		$this->loader->add_filter( 'sports_bench_team_shortcode_recent_games', $teams, 'sports_bench_do_team_shortcode_recent_games', 10, 3 );
		$this->loader->add_filter( 'sports_bench_team_shortcode_upcoming_games', $teams, 'sports_bench_do_team_shortcode_upcoming_games', 10, 3 );
		$this->loader->add_filter( 'sports_bench_team_info', $teams, 'sports_bench_do_team_info', 10, 3 );
		$this->loader->add_filter( 'sports_bench_team_roster_table', $teams, 'sports_bench_do_team_roster_table', 10, 3 );
		$this->loader->run();
	}

	/**
	 * Runs all of the player hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_player() {
		$players = new Players();
		$this->loader->add_filter( 'sports_bench_player_shortcode_information', $players, 'sports_bench_do_player_shortcode_information', 10, 3 );
		$this->loader->add_filter( 'sports_bench_player_listing_information', $players, 'sports_bench_do_player_listing_information', 10, 5 );
		$this->loader->add_filter( 'sports_bench_player_information', $players, 'sports_bench_do_player_information', 10, 3 );
		$this->loader->add_action( 'wp_ajax_sports_bench_load_player_list', $players, 'load_player_list' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_player_list', $players, 'load_player_list' );
		$this->loader->run();
	}

	/**
	 * Runs all of the game hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_games() {
		$games = new Games();
		$this->loader->add_filter( 'sports_bench_game_shortcode_info', $games, 'sports_bench_do_game_shortcode_info', 10, 10 );
		$this->loader->add_filter( 'sports_bench_rivalry_shortcode_info', $games, 'sports_bench_do_rivalry_shortcode_info', 10, 7 );
		$this->loader->add_filter( 'sports_bench_rivalry_shortcode_recent_game', $games, 'sports_bench_do_rivalry_shortcode_recent_game', 10, 5 );
		$this->loader->add_filter( 'sports_bench_game_preview', $games, 'sports_bench_do_game_preview', 10, 10 );
		$this->loader->add_filter( 'sports_bench_game_stats_info', $games, 'sports_bench_do_game_stats_info', 10, 5 );
	}

	/**
	 * Runs all of the scoreboard hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_scoreboard() {
		$scoreboard = new Scoreboard();
		$this->loader->add_filter( 'sports_bench_scoreboard_bar_game', $scoreboard, 'sports_bench_do_scoreboard_bar_game', 10, 2 );
		$this->loader->add_filter( 'sports_bench_scoreboard_widget_game', $scoreboard, 'sports_bench_do_scoreboard_widget_game', 10, 2 );
		$this->loader->add_filter( 'sports_bench_scoreboard_game', $scoreboard, 'sports_bench_do_scoreboard_game', 10, 2 );
		$this->loader->add_action( 'wp_ajax_sports_bench_widget_load_games', $scoreboard, 'widget_load_games' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_widget_load_games', $scoreboard, 'widget_load_games' );
		$this->loader->add_action( 'wp_ajax_sports_bench_load_games', $scoreboard, 'page_load_games' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_games', $scoreboard, 'page_load_games' );
		$this->loader->run();
	}

	/**
	 * Runs all of the standings hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_standings() {
		$standings = new Standings();
		$this->loader->add_filter( 'sports_bench_team_division_standings', $standings, 'sports_bench_do_team_division_standings', 10, 4 );
		$this->loader->add_filter( 'sports_bench_standings_widget', $standings, 'sports_bench_do_standings_widget', 10, 4 );
		$this->loader->add_filter( 'sports_bench_standings_table', $standings, 'sports_bench_do_standings_table', 10, 6 );
		$this->loader->run();
	}

	/**
	 * Runs all of the stats hooks.
	 *
	 * @since 2.0.0
	 */
	public function run_stats() {
		$stats = new Stats();
		$this->loader->add_action( 'wp_ajax_sports_bench_load_stats', $stats, 'sports_bench_statistics' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_stats', $stats, 'sports_bench_statistics' );
		$this->loader->add_filter( 'sports_bench_stat_leader_table', $stats, 'sports_bench_do_stat_leader_table', 10, 4 );
		$this->loader->run();
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

	public function add_toolbar_links_to_edit( $wp_admin_bar ) {
		global $wp_query;
		if ( get_query_var( 'team_slug' ) && get_option( 'sports-bench-team-page' ) ) {
			$team    = new Team( get_query_var( 'team_slug' ) );
			$team_id = $team->get_team_id();
			$args    = [
				'id'     => 'edit_team',
				'title'  => esc_html__( 'Edit Team', 'sports-bench' ),
				'href'   => admin_url( 'admin.php?page=sports-bench-edit-team-form&team_id=' . $team_id ),
				'parent' => false,
				'meta'   => array( 'class' => 'sports-bench-team' )
			];
			$wp_admin_bar->add_node( $args );
		}

		if ( get_query_var( 'player_slug' ) && get_option( 'sports-bench-player-page' ) ) {
			$player    = new Player( get_query_var( 'player_slug' ) );
			$player_id = $player->get_player_id();
			$args    = [
				'id'     => 'edit_player',
				'title'  => esc_html__( 'Edit Player', 'sports-bench' ),
				'href'   => admin_url( 'admin.php?page=sports-bench-edit-player-form&player_id=' . $player_id ),
				'parent' => false,
				'meta'   => array( 'class' => 'sports-bench-player' )
			];
			$wp_admin_bar->add_node( $args );
		}

		if ( isset( $_GET['game_id'] ) && get_option( 'sports-bench-box-score-page' ) && ! is_admin() ) {
			$game    = new Game( sanitize_text_field( $_GET['game_id'] ) );
			$game_id = $game->get_game_id();
			$args    = [
				'id'     => 'edit_game',
				'title'  => esc_html__( 'Edit Game', 'sports-bench' ),
				'href'   => admin_url( 'admin.php?page=sports-bench-edit-game-form&game_id=' . $game_id ),
				'parent' => false,
				'meta'   => array( 'class' => 'sports-bench-game' )
			];
			$wp_admin_bar->add_node( $args );
		}

	}

}
