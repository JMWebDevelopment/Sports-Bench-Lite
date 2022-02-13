<?php
/**
 * Creates the soccer class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Soccer;

use Sports_Bench\Classes\Sports\Soccer\SoccerAdminGame;
use Sports_Bench\Classes\Sports\Soccer\SoccerGames;
use Sports_Bench\Classes\Sports\Soccer\SoccerTeams;
use Sports_Bench\Sports_Bench_Loader;

/**
 * The core soccer class.
 *
 * This is used for soccer functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/soccer
 */
class Soccer {

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
	 * Builds the Soccer object to be used.
	 *
	 * @since  2.0.0
	 *
	 * @param string $version      The version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
		$this->loader  = new Sports_Bench_Loader();
	}

	/**
	 * Runs all of the hooks for the soccer side of the plugin.
	 *
	 * @since 2.0.0
	 */
	public function run() {
		$this->game_admin_hooks();
		$this->team_hooks();
		$this->player_hooks();
		$this->game_hooks();
		$this->loader->run();
	}

	/**
	 * Loads in all of the game admin hooks for soccer.
	 *
	 * @since 2.0.0
	 */
	public function game_admin_hooks() {
		$game = new SoccerAdminGame( $this->version );
		$this->loader->add_action( 'sports_bench_new_game_scoreline', $game, 'new_game_scoreline' );
		$this->loader->add_action( 'sports_bench_new_game_details', $game, 'new_game_details' );
		$this->loader->add_action( 'sports_bench_new_game_team_stats', $game, 'new_game_team_stats' );
		$this->loader->add_action( 'sports_bench_new_game_events', $game, 'new_game_events' );
		$this->loader->add_action( 'sports_bench_new_game_away_stats', $game, 'new_game_away_stats' );
		$this->loader->add_action( 'sports_bench_new_game_home_stats', $game, 'new_game_home_stats' );
		$this->loader->add_filter( 'sports_bench_save_game', $game, 'save_game' );
		$this->loader->add_action( 'sports_bench_edit_game_scoreline', $game, 'edit_game_scoreline', 10, 2 );
		$this->loader->add_action( 'sports_bench_edit_game_details', $game, 'edit_game_details', 10, 2 );
		$this->loader->add_action( 'sports_bench_edit_game_team_stats', $game, 'edit_game_team_stats', 10, 2 );
		$this->loader->add_action( 'sports_bench_edit_game_events', $game, 'edit_game_events', 10, 3 );
		$this->loader->add_action( 'sports_bench_edit_game_away_stats', $game, 'edit_game_away_stats', 10, 3 );
		$this->loader->add_action( 'sports_bench_edit_game_home_stats', $game, 'edit_game_home_stats', 10, 3 );
	}

	/**
	 * Loads in all of the team hooks for soccer.
	 *
	 * @since 2.0.0
	 */
	public function team_hooks() {
		$team = new SoccerTeams( $this->version );
		$this->loader->add_filter( 'sports_bench_team_season_stats', $team, 'sports_bench_do_team_season_stats', 10, 4 );
		$this->loader->add_filter( 'sports_bench_team_stats_table', $team, 'sports_bench_do_team_stats_table', 10, 3 );
	}

	/**
	 * Loads in all of the player hooks for soccer.
	 *
	 * @since 2.0.0
	 */
	public function player_hooks() {
		$player = new SoccerPlayers( $this->version );
		$this->loader->add_filter( 'sports_bench_player_stats_table', $player, 'sports_bench_do_player_stats_table', 10, 4 );
		$this->loader->add_filter( 'sports_bench_player_game_stats_table', $player, 'sports_bench_do_player_game_stats_table', 10, 5 );
		$this->loader->add_action( 'wp_ajax_sports_bench_load_seasons', $player, 'load_seasons' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_load_seasons', $player, 'load_seasons' );
	}

	/**
	 * Loads in all of the game hooks for soccer.
	 *
	 * @since 2.0.0
	 */
	public function game_hooks() {
		$games = new SoccerGames( $this->version );
		$this->loader->add_filter( 'sports_bench_game_linescore', $games, 'sports_bench_do_game_linescore', 10, 7 );
		$this->loader->add_filter( 'sports_bench_game_info', $games, 'sports_bench_do_game_info', 10, 3 );
		$this->loader->add_filter( 'sports_bench_game_events', $games, 'sports_bench_do_game_events', 10, 5 );
		$this->loader->add_filter( 'sports_bench_team_stats', $games, 'sports_bench_do_team_stats', 10, 6 );
		$this->loader->add_filter( 'sports_bench_individual_game_stats', $games, 'sports_bench_do_individual_game_stats', 10, 5 );
		$this->loader->add_action( 'wp_ajax_sports_bench_box_score_ajax', $games, 'load_live_game_events' );
		$this->loader->add_action( 'wp_ajax_nopriv_sports_bench_box_score_ajax', $games, 'load_live_game_events' );
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     2.0.0
	 * @return    Sports_Bench_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}
}
