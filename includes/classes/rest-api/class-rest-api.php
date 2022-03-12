<?php
/**
 * Holds all of the REST API functions.
 *
 * PHP version 7.3
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */

namespace Sports_Bench\Classes\REST_API;

use WP_REST_Server;

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run the REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Sports_Bench_REST_API {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 * @var string $version Description.
	 */
	private $version;

	/**
	 * Builds the Sports_Bench_Public object.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Register the custom routes for the tables
	 *
	 * @since 2.0
	 */
	public function register_endpoints() {

		// Register the division route.
		$division_route = new Division_REST_Controller();
		$division_route->register_routes();

		// Register the games route.
		$game_route = new Game_REST_Controller();
		$game_route->register_routes();

		// Register the game info route.
		$game_info_route = new Game_Info_REST_Controller();
		$game_info_route->register_routes();

		// Register the game stats route.
		$game_stats_route = new Game_Stats_REST_Controller();
		$game_stats_route->register_routes();

		// Register the players route.
		$players_route = new Player_REST_Controller();
		$players_route->register_routes();

		// Register the teams route.
		$teams_route = new Team_REST_Controller();
		$teams_route->register_routes();

	}

	/**
	 * Register the custom routes for the tables
	 *
	 * @since 2.0
	 */
	public function register_routes() {

		register_rest_route(
			'sportsbench',
			'options',
			[
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [ $this, 'rest_get_options' ],
				'permission_callback' => [ $this, 'get_items_permissions_check' ],
			]
		);

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results
	 *
	 * @since 2.0
	 *
	 * @param WP_REST_Request $request      The current WP_REST_Request object.
	 * @return string JSON array of the SQL results
	 */
	public function sports_bench_rest_get_options( WP_REST_Request $request ) {
		$response = '';

		$options = array(
			'sports-bench-sport'                => get_option( 'sports-bench-sport' ),
			'sports-bench-season-year'          => get_option( 'sports-bench-season-year' ),
			'sports-bench-season'               => get_option( 'sports-bench-season' ),
			'sports-bench-display-game'         => get_option( 'sports-bench-display-game' ),
			'sports-bench-week-number'          => get_option( 'sports-bench-week-number' ),
			'sports-bench-player-page'          => get_option( 'sports-bench-player-page' ),
			'sports-bench-team-page'            => get_option( 'sports-bench-team-page' ),
			'sports-bench-display-map'          => get_option( 'sports-bench-display-map' ),
			'sports-bench-week-maps-api-key'    => get_option( 'sports-bench-week-maps-api-key' ),
		);

		$response = $options;

		return new WP_REST_Response( $response, 200 );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		return true;
	}

}
