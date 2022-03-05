<?php
/**
 * Holds all of the game REST API functions.
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
use WP_REST_Controller;
use WP_REST_Response;
use WP_Error;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Game;

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run the game REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Game_Stats_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'game_stats';
		register_rest_route(
			$namespace,
			'/' . $base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permissions_check' ],
					'args'                => [ $this->get_collection_params() ],
				],
				[
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_item' ],
					'permission_callback' => [ $this, 'create_item_permissions_check' ],
					'args'                => $this->get_endpoint_args_for_item_schema( true ),
				],
			]
		);
		register_rest_route(
			$namespace,
			'/' . $base . '/(?P<id>[\d]+)',
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
					'args'                => [
						'context' => [
							'default'      => 'view',
							'required'     => true,
						],
						'params'  => [
							'game_stats_player_id' => [
								'description'        => 'The id(s) for the game stat(s) in the search.',
								'type'               => 'integer',
								'default'            => 1,
								'sanitize_callback'  => 'absint',
							],
						],
						$this->get_collection_params(),
					],
				],
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'                => $this->get_endpoint_args_for_item_schema( false ),
				],
				[
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => [ $this, 'delete_item' ],
					'permission_callback' => [ $this, 'delete_item_permissions_check' ],
					'args'                => [
						'force' => [
							'default' => false,
						],
					],
				],
			]
		);
		register_rest_route(
			$namespace,
			'/' . $base . '/schema',
			[
				'methods'         => WP_REST_Server::READABLE,
				'callback'        => [ $this, 'get_public_item_schema' ],
			]
		);
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		$params = $request->get_params();
		$items  = $this->get_game_stats( $params );
		$data   = [];
		if ( $items ) {
			foreach ( $items as $item ) {
				$itemdata = $this->prepare_item_for_response( $item, $request );
				$data[]   = $this->prepare_response_for_collection( $itemdata );
			}
		}

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Get one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		//get parameters from request
		$params = $request->get_params();
		$item   = $this->get_game_stat( $params['id'] );//do a query, call another class, etc
		$data   = $this->prepare_item_for_response( $item, $request );

		//return a response or error based on some conditional
		if ( 1 === 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return new WP_Error( 'code', esc_html__( 'Error', 'sports-bench' ) );
		}
	}

	/**
	 * Create one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( $request ) {

		$item = $this->prepare_item_for_database( $request );

		$data = $this->add_game_stat( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );
	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_game_stat( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->delete_game_stat( $item );
		if ( true === $deleted  ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );
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

	/**
	 * Check if a given request has access to get a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to create items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function create_item_permissions_check( $request ) {
		//return current_user_can( 'edit_something' );
		return true;
	}

	/**
	 * Check if a given request has access to update a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function update_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function delete_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Prepare the item for create or update operation
	 *
	 * @param WP_REST_Request $request Request object
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {

		if ( isset( $request['game_stats_player_id'] ) ) {
			$game_stats_player_id = wp_filter_nohtml_kses( sanitize_text_field( $request['game_stats_player_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$game_stats_player_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$game_stats_player_id = '';
		}

		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_stats_player_id'           => $game_stats_player_id,
				'game_id'                        => intval( $request['game_id'] ),
				'game_team_id'                   => intval( $request['game_team_id'] ),
				'game_player_id'                 => intval( $request['game_player_id'] ),
				'game_player_position'           => wp_filter_nohtml_kses( sanitize_text_field( $request['game_player_position'] ) ),
				'game_player_at_bats'            => intval( $request['game_player_at_bats'] ),
				'game_player_hits'               => intval( $request['game_player_hits'] ),
				'game_player_runs'               => intval( $request['game_player_runs'] ),
				'game_player_rbis'               => intval( $request['game_player_rbis'] ),
				'game_player_doubles'            => intval( $request['game_player_doubles'] ),
				'game_player_triples'            => intval( $request['game_player_triples'] ),
				'game_player_homeruns'           => intval( $request['game_player_homeruns'] ),
				'game_player_strikeouts'         => intval( $request['game_player_strikeouts'] ),
				'game_player_walks'              => intval( $request['game_player_walks'] ),
				'game_player_hit_by_pitch'       => intval( $request['game_player_hit_by_pitch'] ),
				'game_player_fielders_choice'    => intval( $request['game_player_fielders_choice'] ),
				'game_player_innings_pitched'    => floatval( $request['game_player_innings_pitched'] ),
				'game_player_pitcher_strikeouts' => intval( $request['game_player_pitcher_strikeouts'] ),
				'game_player_pitcher_walks'      => intval( $request['game_player_pitcher_walks'] ),
				'game_player_runs_allowed'       => intval( $request['game_player_runs_allowed'] ),
				'game_player_earned_runs'        => intval( $request['game_player_earned_runs'] ),
				'game_player_hits_allowed'       => intval( $request['game_player_hits_allowed'] ),
				'game_player_homeruns_allowed'   => intval( $request['game_player_homeruns_allowed'] ),
				'game_player_pitch_count'        => intval( $request['game_player_pitch_count'] ),
				'game_player_hit_batters'        => intval( $request['game_player_hit_batters'] ),
				'game_player_decision'           => wp_filter_nohtml_kses( sanitize_text_field( $request['game_player_decision'] ) )
			];
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			if ( isset( $request['game_player_minutes'] ) && 5 === strlen( $request['game_player_minutes'] ) ) {
				$time = '00:' . $request['game_player_minutes'];
			} elseif ( isset( $request['game_player_minutes'] ) && 4 === strlen( $request['game_player_minutes'] ) ) {
				$time = '00:0' . $request['game_player_minutes'];
			} elseif ( isset( $request['game_player_minutes'] ) && 2 === strlen( $request['game_player_minutes'] ) ) {
				$time = '00:' . $request['game_player_minutes'] . ':00';
			} elseif ( isset( $request['game_player_minutes'] ) && 1 === strlen( $request['game_player_minutes'] ) ) {
				$time = '00:0' . $request['game_player_minutes'] . ':00';
			} else {
				$time = $request['game_player_minutes'];
			}
			if ( 1 === $request['game_player_started'] ) {
				$started = 1;
			} else {
				$started = 0;
			}
			$item = [
				'game_stats_player_id'    => $game_stats_player_id,
				'game_id'                 => intval( $request['game_id'] ),
				'game_team_id'            => intval( $request['game_team_id'] ),
				'game_player_id'          => intval( $request['game_player_id'] ),
				'game_player_started'     => intval( $started ),
				'game_player_minutes'     => wp_filter_nohtml_kses( sanitize_text_field( $time ) ),
				'game_player_fgm'         => intval( $request['game_player_fgm'] ),
				'game_player_fga'         => intval( $request['game_player_fga'] ),
				'game_player_3pm'         => intval( $request['game_player_3pm'] ),
				'game_player_3pa'         => intval( $request['game_player_3pa'] ),
				'game_player_ftm'         => intval( $request['game_player_ftm'] ),
				'game_player_fta'         => intval( $request['game_player_fta'] ),
				'game_player_points'      => intval( $request['game_player_points'] ),
				'game_player_off_rebound' => intval( $request['game_player_off_rebound'] ),
				'game_player_def_rebound' => intval( $request['game_player_def_rebound'] ),
				'game_player_assists'     => intval( $request['game_player_assists'] ),
				'game_player_steals'      => intval( $request['game_player_steals'] ),
				'game_player_blocks'      => intval( $request['game_player_blocks'] ),
				'game_player_to'          => intval( $request['game_player_to'] ),
				'game_player_fouls'       => intval( $request['game_player_fouls'] ),
				'game_player_plus_minus'  => intval( $request['game_player_plus_minus'] ),
			];
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_stats_player_id'           => $game_stats_player_id,
				'game_id'                        => intval( $request['game_id'] ),
				'game_team_id'                   => intval( $request['game_team_id'] ),
				'game_player_id'                 => intval( $request['game_player_id'] ),
				'game_player_completions'        => intval( $request['game_player_completions'] ),
				'game_player_attempts'           => intval( $request['game_player_attempts'] ),
				'game_player_pass_yards'         => intval( $request['game_player_pass_yards'] ),
				'game_player_pass_tds'           => intval( $request['game_player_pass_tds'] ),
				'game_player_pass_ints'          => intval( $request['game_player_pass_ints'] ),
				'game_player_rushes'             => intval( $request['game_player_rushes'] ),
				'game_player_rush_yards'         => intval( $request['game_player_rush_yards'] ),
				'game_player_rush_tds'           => intval( $request['game_player_rush_tds'] ),
				'game_player_rush_fumbles'       => intval( $request['game_player_rush_fumbles'] ),
				'game_player_catches'            => intval( $request['game_player_catches'] ),
				'game_player_receiving_yards'    => intval( $request['game_player_receiving_yards'] ),
				'game_player_receiving_tds'      => intval( $request['game_player_receiving_tds'] ),
				'game_player_receiving_fumbles'  => intval( $request['game_player_receiving_fumbles'] ),
				'game_player_tackles'            => floatval( $request['game_player_tackles'] ),
				'game_player_tfl'                => floatval( $request['game_player_tfl'] ),
				'game_player_sacks'              => floatval( $request['game_player_sacks'] ),
				'game_player_pbu'                => intval( $request['game_player_pbu'] ),
				'game_player_ints'               => intval( $request['game_player_ints'] ),
				'game_player_tds'                => intval( $request['game_player_tds'] ),
				'game_player_ff'                 => intval( $request['game_player_ff'] ),
				'game_player_fr'                 => intval( $request['game_player_fr'] ),
				'game_player_blocked'            => intval( $request['game_player_blocked'] ),
				'game_player_yards'              => intval( $request['game_player_yards'] ),
				'game_player_fga'                => intval( $request['game_player_fga'] ),
				'game_player_fgm'                => intval( $request['game_player_fgm'] ),
				'game_player_xpa'                => intval( $request['game_player_xpa'] ),
				'game_player_xpm'                => intval( $request['game_player_xpm'] ),
				'game_player_touchbacks'         => intval( $request['game_player_touchbacks'] ),
				'game_player_returns'            => intval( $request['game_player_returns'] ),
				'game_player_return_yards'       => intval( $request['game_player_return_yards'] ),
				'game_player_return_tds'         => intval( $request['game_player_return_tds'] ),
				'game_player_return_fumbles'     => intval( $request['game_player_return_fumbles'] ),
			];
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			if ( isset( $request['game_player_time_on_ice'] ) && strlen( $request['game_player_time_on_ice'] ) <= 5 ) {
				$time = '00:' . $request['game_player_time_on_ice'];
			} else {
				$time = $request['game_player_time_on_ice'];
			}

			$item = [
				'game_stats_player_id'      => $game_stats_player_id,
				'game_id'                   => intval( $request['game_id'] ),
				'game_team_id'              => intval( $request['game_team_id'] ),
				'game_player_id'            => intval( $request['game_player_id'] ),
				'game_player_goals'         => intval( $request['game_player_goals'] ),
				'game_player_assists'       => intval( $request['game_player_assists'] ),
				'game_player_plus_minus'    => intval( $request['game_player_plus_minus'] ),
				'game_player_sog'           => intval( $request['game_player_sog'] ),
				'game_player_penalties'     => intval( $request['game_player_penalties'] ),
				'game_player_pen_minutes'   => intval( $request['game_player_pen_minutes'] ),
				'game_player_hits'          => intval( $request['game_player_hits'] ),
				'game_player_shifts'        => intval( $request['game_player_shifts'] ),
				'game_player_time_on_ice'   => wp_filter_nohtml_kses( sanitize_text_field( $time ) ),
				'game_player_faceoffs'      => intval( $request['game_player_faceoffs'] ),
				'game_player_faceoff_wins'  => intval( $request['game_player_faceoff_wins'] ),
				'game_player_shots_faced'   => intval( $request['game_player_shots_faced'] ),
				'game_player_saves'         => intval( $request['game_player_saves'] ),
				'game_player_goals_allowed' => intval( $request['game_player_goals_allowed'] ),
			];
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_stats_player_id'              => $game_stats_player_id,
				'game_id'                           => intval( $request['game_id'] ),
				'game_team_id'                      => intval( $request['game_team_id'] ),
				'game_player_id'                    => intval( $request['game_player_id'] ),
				'game_player_tries'                 => intval( $request['game_player_tries'] ),
				'game_player_assists'               => intval( $request['game_player_assists'] ),
				'game_player_conversions'           => intval( $request['game_player_conversions'] ),
				'game_player_penalty_goals'         => intval( $request['game_player_penalty_goals'] ),
				'game_player_drop_kicks'            => intval( $request['game_player_drop_kicks'] ),
				'game_player_points'                => intval( $request['game_player_points'] ),
				'game_player_penalties_conceeded'   => intval( $request['game_player_penalties_conceeded'] ),
				'game_player_meters_run'            => intval( $request['game_player_meters_run'] ),
				'game_player_red_cards'             => intval( $request['game_player_red_cards'] ),
				'game_player_yellow_cards'          => intval( $request['game_player_yellow_cards'] ),
			];
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_stats_player_id'       => $game_stats_player_id,
				'game_id'                    => intval( $request['game_id'] ),
				'game_team_id'               => intval( $request['game_team_id'] ),
				'game_player_id'             => intval( $request['game_player_id'] ),
				'game_player_minutes'        => intval( $request['game_player_minutes'] ),
				'game_player_goals'          => intval( $request['game_player_goals'] ),
				'game_player_assists'        => intval( $request['game_player_assists'] ),
				'game_player_shots'          => intval( $request['game_player_shots'] ),
				'game_player_sog'            => intval( $request['game_player_sog'] ),
				'game_player_fouls'          => intval( $request['game_player_fouls'] ),
				'game_player_fouls_suffered' => intval( $request['game_player_fouls_suffered'] ),
				'game_player_shots_faced'    => intval( $request['game_player_shots_faced'] ),
				'game_player_shots_saved'    => intval( $request['game_player_shots_saved'] ),
				'game_player_goals_allowed'  => intval( $request['game_player_goals_allowed'] ),
			];
		} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_stats_player_id'          => $game_stats_player_id,
				'game_id'                       => intval( $request['game_id'] ),
				'game_team_id'                  => intval( $request['game_team_id'] ),
				'game_player_id'                => intval( $request['game_player_id'] ),
				'game_player_sets_played'       => intval( $request['game_player_sets_played'] ),
				'game_player_points'            => intval( $request['game_player_points'] ),
				'game_player_kills'             => intval( $request['game_player_kills'] ),
				'game_player_hitting_errors'    => intval( $request['game_player_hitting_errors'] ),
				'game_player_attacks'           => intval( $request['game_player_attacks'] ),
				'game_player_set_attempts'      => intval( $request['game_player_set_attempts'] ),
				'game_player_set_errors'        => intval( $request['game_player_set_errors'] ),
				'game_player_serves'            => intval( $request['game_player_serves'] ),
				'game_player_serve_errors'      => intval( $request['game_player_serve_errors'] ),
				'game_player_aces'              => intval( $request['game_player_aces'] ),
				'game_player_blocks'            => intval( $request['game_player_blocks'] ),
				'game_player_block_attempts'    => intval( $request['game_player_block_attempts'] ),
				'game_player_block_errors'      => intval( $request['game_player_block_errors'] ),
				'game_player_digs'              => intval( $request['game_player_digs'] ),
				'game_player_receiving_errors'  => intval( $request['game_player_receiving_errors'] ),
			];
		}

		return $item;
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response( $item, $request ) {

		$schema = $this->get_item_schema();
		$data   = [];
		$data   = $item;

		return $data;
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return [
			'game_stats_player_id' => [
				'description'        => 'The id(s) for the game stat(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			],
			'game_id' => [
				'description'        => 'The game id(s) for the game stat(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_team_id' => [
				'description'        => 'The team id(s) for the game stat(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_player_id' => [
				'description'        => 'The player id(s) for the game stat(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'group' => [
				'description'        => 'Whether or not to group the stats by season',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'season' => [
				'description'        => 'The season for the game stat(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
		];
	}

	/**
	 * Get the Entry schema, conforming to JSON Schema.
	 *
	 * @since  2.0-beta-1
	 * @access public
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'entry',
			'type'       => 'object',
			'properties' => [
				'player_id' => [
					'description' => esc_html__( 'The id for the player.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				],
			],
		];
		return $schema;
	}

	public function add_game_stat( $item ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_game_stats';
		$the_id     = $item['game_stats_player_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_stats_player_id = %d", $the_id ) );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_insert', esc_html__( 'There was an error creating the game stat. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_game_insert', esc_html__( 'This game stat has already been created in the database. Maybe try updating the game stat.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	public function update_game_stat( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$the_id     = $item['game_stats_player_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_stats_player_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, [ 'game_stats_player_id' => $item['game_stats_player_id'] ] );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_update', esc_html__( 'There was an error updating the game stat. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game stat does not exist. Try adding the game stat first.', 'sports-bench' ), [ 'status' => 500 ] );
		}
	}

	public function delete_game_stat( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$the_id     = $item['game_stats_player_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_stats_player_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete( $table_name, [ 'game_stats_player_id' => $the_id ], ['%d' ] );
			if ( false === $result ) {
				return new WP_Error( 'error_game_delete', esc_html__( 'There was an error deleting the game stat. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game stat does not exist.', 'sports-bench' ), [ 'status' => 500 ] );
		}
	}

	/**
	 * Takes the REST URL and returns a JSON array of the results
	 *
	 * @params $params WP_REST_Request
	 *
	 * @return string, JSON array of the SQL results
	 *
	 * @since 1.1
	 */
	public function get_game_stats( $params ) {
		$response = '';

		if ( ( isset( $params['game_stats_player_id'] ) && null !== $params['game_stats_player_id'] ) || ( isset( $params['game_id'] ) && null !== $params['game_id'] ) || ( isset( $params['game_team_id'] ) && null !== $params['game_team_id'] ) || ( isset( $params['game_player_id'] ) && null !== $params['game_player_id'] ) ) {

			$and = false;
			$search = '';
			if ( isset( $params['game_stats_player_id'] ) && null !== $params['game_stats_player_id'] ) {
				$search .= 'game_stats_player_id in (' . $params['game_stats_player_id'] . ')';
				$and     = true;
			} if ( isset( $params['game_id'] ) && null !== $params['game_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_id in (' . $params['game_id'] . ')';
				$and     = true;
			} if ( isset( $params['game_team_id'] ) && null !== $params['game_team_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_team_id in (' . $params['game_team_id'] . ')';
				$and     = true;
			} if ( isset( $params['game_player_id'] ) && null !== $params['game_player_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_player_id in (' . $params['game_player_id'] . ')';
			}

			if ( isset( $params['group'] ) && true === $params['group'] && isset( $params['game_team_id'] ) && null !== $params['game_team_id'] ) {
				if ( isset( $params['season']) && null !== $params['season'] ) {
					$and = 'AND game.game_season = "' . $params['season'] . '" ';
				} else {
					$and = '';
				}
				global $wpdb;
				$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
				$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
				$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
				$team_id          = $params['game_team_id'];
				$stats_list       = [];
				if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_at_bats ) as AB, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_runs ) as RUNS, SUM( g.game_player_rbis ) as RBI, SUM( g.game_player_doubles ) as DOUBLES, SUM( g.game_player_triples ) as TRIPLES, SUM( g.game_player_homeruns ) as HOMERUNS, SUM( g.game_player_strikeouts ) as STRIKEOUTS, SUM( g.game_player_walks ) as WALKS, SUM( g.game_player_hit_by_pitch ) as HIT_BY_PITCH, SUM( g.game_player_fielders_choice ) as FC, SUM( g.game_player_innings_pitched ) as IP, SUM( g.game_player_pitcher_strikeouts ) as KS, SUM( g.game_player_pitcher_walks ) as BB, SUM( g.game_player_hit_batters ) as HPB, SUM( g.game_player_runs_allowed ) as RA, SUM( g.game_player_earned_runs ) as ER, SUM( g.game_player_hits_allowed ) as HA, SUM( g.game_player_homeruns_allowed ) as HRA, SUM( g.game_player_pitch_count ) as PC
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach( $players as $player ) {
						if ( 0 === $player->AB ) {
							$batting_average = '.000';
						} else {
							$batting_average = sports_bench_get_batting_average( $player->AB, $player->HITS );
						}
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name'   => $player->player_first_name,
							'player_last_name'    => $player->player_last_name,
							'player_id'           => $player->player_id,
							'player_link'         => $the_player->get_permalink(),
							'at_bats'             => $player->AB,
							'batting_average'     => $batting_average,
							'hits'                => $player->HITS,
							'runs'                => $player->RUNS,
							'rbi'                 => $player->RBI,
							'doubles'             => $player->DOUBLES,
							'triples'             => $player->TRIPLES,
							'homeruns'            => $player->HOMERUNS,
							'strikeouts'          => $player->STRIKEOUTS,
							'walks'               => $player->WALKS,
							'hit_by_pitch'        => $player->HIT_BY_PITCH,
							'fielders_choice'     => $player->FC,
							'innings_pitched'     => $player->IP,
							'pitcher_strikeouts'  => $player->KS,
							'pitcher_walks'       => $player->BB,
							'pitcher_hit_batters' => $player->HPB,
							'runs_allowed'        => $player->RA,
							'earned_runs'         => $player->ER,
							'era'                 => sports_bench_get_ERA( (int) $player->ER, (int) $player->IP, 9 ),
							'hits_allowed'        => $player->HA,
							'homeruns_allowed'    => $player->HRA,
							'pitch_count'         => $player->PC,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_started ) as STARTS, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_minutes ) as MIN, SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_fga ) as FGA, SUM( g.game_player_3pm ) as TPM, SUM( g.game_player_3pa ) as TPA, SUM( g.game_player_ftm ) as FTM, SUM( g.game_player_fta ) as FTA, SUM( g.game_player_points ) as PTS, SUM( g.game_player_off_rebound ) as OFF_REB, SUM( g.game_player_def_rebound ) as DEF_REB, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_steals) as STEALS, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_to) as TURNOVERS, SUM( g.game_player_plus_minus ) as PM
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id
						ORDER BY PTS DESC;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name' => $player->player_first_name,
							'player_last_name'  => $player->player_last_name,
							'player_id'         => $player->player_id,
							'player_link'       => $the_player->get_permalink(),
							'games_played'      => $player->GP,
							'starts'            => $player->STARTS,
							'minutes'           => $player->MIN,
							'fgm'               => $player->FGM,
							'fga'               => $player->FGA,
							'3pm'               => $player->TPM,
							'3pa'               => $player->TPA,
							'ftm'               => $player->FTM,
							'fta'               => $player->FTA,
							'points'            => $player->PTS,
							'points_per_game'   => sports_bench_get_points_average( $player->PTS, $player->GP ),
							'off_reb'           => $player->OFF_REB,
							'def_reb'           => $player->DEF_REB,
							'tot_reb'           => $player->OFF_REB + $player->DEF_REB,
							'assists'           => $player->ASSISTS,
							'steals'            => $player->STEALS,
							'blocks'            => $player->BLOCKS,
							'to'                => $player->TURNOVERS,
							'plus_minus'        => $player->PM,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_completions ) as COMP, SUM( g.game_player_attempts ) as ATT, SUM( g.game_player_pass_yards ) as PASS_YD, SUM( g.game_player_pass_tds ) as PASS_TD, SUM( g.game_player_pass_ints ) as PASS_INT, SUM( g.game_player_rushes ) as RUSHES, SUM( g.game_player_rush_yards ) as RUSH_YARDS, SUM( g.game_player_rush_tds ) as RUSH_TD, SUM( g.game_player_rush_fumbles ) as RUSH_FUM, SUM( g.game_player_catches ) as CATCHES, SUM( g.game_player_receiving_yards ) as RECEIVE_YARDS, SUM( g.game_player_receiving_tds ) as RECEIVE_TD, SUM( g.game_player_receiving_fumbles ) as RECEIVE_FUM, SUM( g.game_player_tackles ) as TACKLES, SUM( g.game_player_tfl ) as TFL, SUM( g.game_player_sacks ) as SACKS, SUM( g.game_player_pbu ) as PBU, SUM( g.game_player_ints ) as INTS,  SUM( g.game_player_tds ) as TDS, SUM( g.game_player_ff ) as FF, SUM( g.game_player_fr ) as FR,  SUM( g.game_player_blocked ) as BLOCKED, SUM( g.game_player_yards ) as YARDS, SUM( g.game_player_fga ) as FGA,  SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_xpa ) as XPA, SUM( g.game_player_xpm ) as XPM, SUM( g.game_player_touchbacks ) as TB, SUM( g.game_player_returns ) as RETURNS, SUM( g.game_player_return_yards ) as RETURN_YARDS, SUM( g.game_player_return_tds ) as RETURN_TDS, SUM( g.game_player_return_fumbles ) as RETURN_FUMBLES
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name'         => $player->player_first_name,
							'player_last_name'          => $player->player_last_name,
							'player_id'                 => $player->player_id,
							'player_link'               => $the_player->get_permalink(),
							'pass_completions'          => $player->COMP,
							'pass_attempts'             => $player->ATT,
							'pass_yards'                => $player->PASS_YD,
							'pass_tds'                  => $player->PASS_TD,
							'pass_ints'                 => $player->PASS_INT,
							'rushes'                    => $player->RUSHES,
							'rush_yards'                => $player->RUSH_YARDS,
							'rush_tds'                  => $player->RUSH_TD,
							'rush_fumbles'              => $player->RUSH_FUM,
							'catches'                   => $player->CATCHES,
							'receiving_yards'           => $player->RECEIVE_YARDS,
							'receiving_tds'             => $player->RECEIVE_TD,
							'receiving_fumbles'         => $player->RECEIVE_FUM,
							'tackles'                   => $player->TACKLES,
							'tfl'                       => $player->TFL,
							'sacks'                     => $player->SACKS,
							'defensive_interceptions'   => $player->INTS,
							'defensive_touchdowns'      => $player->TDS,
							'forced_fumbles'            => $player->FF,
							'fumbles_recovered'         => $player->FR,
							'blocked_kicks'             => $player->BLOCKED,
							'defensive_yards'           => $player->YARDS,
							'fga'                       => $player->FGA,
							'fgm'                       => $player->FGM,
							'xpa'                       => $player->XPA,
							'xpm'                       => $player->XPM,
							'touchbacks'                => $player->TB,
							'returns'                   => $player->RETURNS,
							'return_yards'              => $player->RETURN_YARDS,
							'return_tds'                => $player->RETURN_TDS,
							'return_fumbles'            => $player->RETURN_FUMBLES,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_plus_minus ) as PM, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_penalties ) as PEN, SUM( g.game_player_pen_minutes ) as PEN_MIN, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_shifts ) as SHIFTS, SUM( g.game_player_time_on_ice ) as ICE_TIME, SUM( g.game_player_faceoffs ) as FACE, SUM( g.game_player_faceoff_wins ) as FACE_WINS, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_saves ) as SAVES, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED, COUNT( g.game_player_time_on_ice ) as GP
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id
						ORDER BY GOALS DESC;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name'     => $player->player_first_name,
							'player_last_name'      => $player->player_last_name,
							'player_id'             => $player->player_id,
							'player_link'           => $the_player->get_permalink(),
							'goals'                 => $player->GOALS,
							'assists'               => $player->ASSISTS,
							'points'                => $player->GOALS + $player->ASSISTS,
							'plus_minus'            => $player->PM,
							'sog'                   => $player->SOG,
							'penalties'             => $player->PEN,
							'pen_minutes'           => $player->PEN_MIN,
							'hits'                  => $player->HITS,
							'shifts'                => $player->SHIFTS,
							'ice_time'              => $player->ICE_TIME,
							'faceoffs'              => $player->FACE,
							'faceoff_wins'          => $player->FACE_WINS,
							'shots_faced'           => $player->SHOTS_FACED,
							'saves'                 => $player->SAVES,
							'goals_allowed'         => $player->GOALS_ALLOWED,
							'goals_against_average' => sports_bench_get_goals_against_average( (int)$player->GOALS_ALLOWED, (int)$player->GP ),
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_tries ) as TRIES, COUNT( g.game_player_meters_run ) as GP, SUM( g.game_player_meters_run ) as METERS_RUN, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_conversions ) as CONVERSIONS, SUM( g.game_player_penalty_goals ) as PK_GOALS, SUM( g.game_player_drop_kicks ) as DROP_KICKS, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_penalties_conceeded ) as PENALTIES_CONCEEDED, SUM( g.game_player_red_cards ) as REDS, SUM( g.game_player_yellow_cards ) as YELLOWS
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name'     => $player->player_first_name,
							'player_last_name'      => $player->player_last_name,
							'player_id'             => $player->player_id,
							'player_link'           => $the_player->get_permalink(),
							'games_played'          => $player->GP,
							'tries'                 => $player->TRIES,
							'assists'               => $player->ASSISTS,
							'conversions'           => $player->CONVERSIONS,
							'pk_goals'              => $player->PK_GOALS,
							'drop_kicks'            => $player->DROP_KICKS,
							'points'                => $player->POINTS,
							'penalties_conceded'    => $player->PENALTIES_CONCEEDED,
							'meters_run'            => $player->METERS_RUN,
							'red_cards'             => $player->REDS,
							'yellow_cards'          => $player->YELLOWS,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) as MINUTES, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_shots ) as SHOTS, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_fouls ) as FOULS, SUM( g.game_player_fouls_suffered ) as FOULS_SUFFERED, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_shots_saved ) as SHOTS_SAVED, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player = new Player( (int) $player->player_id );
						$stats_info = [
							'player_first_name'                 => $player->player_first_name,
							'player_last_name'                  => $player->player_last_name,
							'player_id'                         => $player->player_id,
							'player_link'                       => $the_player->get_permalink(),
							'game_player_minutes'               => $player->MINUTES,
							'game_player_goals'                 => $player->GOALS,
							'game_player_assists'               => $player->ASSISTS,
							'game_player_shots'                 => $player->SHOTS,
							'game_player_sog'                   => $player->SOG,
							'game_player_fouls'                 => $player->FOULS,
							'game_player_fouls_suffered'        => $player->FOULS_SUFFERED,
							'game_player_shots_faced'           => $player->SHOTS_FACED,
							'game_player_shots_saved'           => $player->SHOTS_SAVED,
							'game_player_goals_allowed'         => $player->GOALS_ALLOWED,
							'game_player_goals_allowed_average' => sports_bench_get_goals_against_average( (int) $player->GOALS_ALLOWED, (int) $player->GP ),
						];
						array_push( $stats_list, $stats_info );
					}
				} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_sets_played ) as SETS_PLAYED, COUNT( g.game_player_sets_played ) as GP, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_kills ) as KILLS, SUM( g.game_player_hitting_errors ) as HITTING_ERRORS, SUM( g.game_player_attacks ) as ATTACKS, SUM( g.game_player_set_attempts ) as SET_ATT, SUM( g.game_player_set_errors ) as SET_ERR, SUM( g.game_player_serves ) as SERVES, SUM( g.game_player_serve_errors ) as SE, SUM( g.game_player_aces ) as SA, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_block_attempts ) as BA, SUM( g.game_player_block_errors) as BE, SUM( g.game_player_digs ) as DIGS, SUM( g.game_player_receiving_errors) as RE
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_team_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id
						ORDER BY POINTS DESC;",
						$team_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $player ) {
						$the_player   = new Player( (int) $player->player_id );
						$player_stats = [
							'player_first_name' => $player->player_first_name,
							'player_last_name'  => $player->player_last_name,
							'player_id'         => $player->player_id,
							'player_link'       => $the_player->get_permalink(),
							'games_played'      => $player->GP,
							'sets_played'       => $player->SETS_PLAYED,
							'points'            => $player->POINTS,
							'hitting_percent'   => sports_bench_get_hitting_percentage( $player->ATTACKS, $player->KILLS, $player->HITTING_ERRORS ),
							'kills'             => $player->KILLS,
							'attacks'           => $player->ATTACKS,
							'hitting_errors'    => $player->HITTING_ERRORS,
							'set_errors'        => $player->SET_ERR,
							'set_attempts'      => $player->SET_ATT,
							'serves'            => $player->SERVES,
							'serve_errors'      => $player->SE,
							'aces'              => $player->SA,
							'blocks'            => $player->BLOCKS,
							'block_attempts'    => $player->BA,
							'block_errors'      => $player->BE,
							'digs'              => $player->DIGS,
							'rec_errors'        => $player->RE,
						];
						array_push( $stats_list, $player_stats );
					}
				}
				$response = $stats_list;
			} elseif ( ( isset( $params['group'] ) && true === $params['group'] ) && ( isset( $params['game_player_id'] ) && null !== $params['game_player_id'] ) ) {
				if ( isset( $params['season'] ) && null !== $params['season'] ) {
					$and = 'AND game.game_season = "' . $params['season'] . '" ';
				} else {
					$and = '';
				}
				global $wpdb;
				$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
				$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
				$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
				$player_id        = $params['game_player_id'];
				$stats_list       = [];
				if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, game.game_home_id, game.game_away_id, g.game_player_id, SUM( g.game_player_at_bats ) as AB, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_runs ) as RUNS, SUM( g.game_player_rbis ) as RBI, SUM( g.game_player_doubles ) as DOUBLES, SUM( g.game_player_triples ) as TRIPLES, SUM( g.game_player_homeruns ) as HOMERUNS, SUM( g.game_player_strikeouts ) as STRIKEOUTS, SUM( g.game_player_walks ) as WALKS, SUM(g.game_player_hit_by_pitch ) as HIT_BY_PITCH, SUM( g.game_player_fielders_choice ) as FC, TRUNCATE( ( ( SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) + TRUNCATE( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ),0 ) ) + ( TRUNCATE( ( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ) - TRUNCATE( ( ( SUM( g.game_player_innings_pitched ) - SUM( TRUNCATE( g.game_player_innings_pitched,0 ) ) ) / 0.3 ),0 ) ),1 ) / 3 ) ),1 ) as IP, SUM( g.game_player_pitcher_strikeouts ) as KS, SUM( g.game_player_pitcher_walks ) as BB, SUM( g.game_player_hit_batters ) as HPB, SUM( g.game_player_runs_allowed ) as RA, SUM( g.game_player_earned_runs ) as ER, SUM( g.game_player_hits_allowed ) as HA, SUM( g.game_player_homeruns_allowed ) as HRA, SUM( g.game_player_pitch_count ) as PC
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$seasons  = Database::get_results( $querystr );
					foreach ( $seasons as $the_player ) {
						if ( 0 === $the_player->AB ) {
							$batting_average = '.000';
						} else {
							$batting_average = sports_bench_get_batting_average( $the_player->AB, $the_player->HITS );
						}
						$record       = sports_bench_get_pitcher_record( (int) $the_player->player_id, '"' . $the_player->game_season . '"' );
						$season_team  = new Team( (int) $the_player->game_team_id );
						$player_stats = [
							'season'                => $the_player->game_season,
							'team_id'               => $season_team->get_team_id(),
							'team_name'             => $season_team->get_team_name(),
							'team_logo'             => $season_team->get_team_photo( 'team-logo' ),
							'team_link'             => $season_team->get_permalink(),
							'at_bats'               => $the_player->AB,
							'batting_average'       => $batting_average,
							'hits'                  => $the_player->HITS,
							'runs'                  => $the_player->RUNS,
							'rbi'                   => $the_player->RBI,
							'doubles'               => $the_player->DOUBLES,
							'triples'               => $the_player->TRIPLES,
							'homeruns'              => $the_player->HOMERUNS,
							'strikeouts'            => $the_player->STRIKEOUTS,
							'walks'                 => $the_player->WALKS,
							'hit_by_pitch'          => $the_player->HIT_BY_PITCH,
							'innings_pitched'       => $the_player->IP,
							'wins'                  => $record['wins'],
							'losses'                => $record['losses'],
							'saves'                 => sports_bench_get_pitcher_saves( (int) $the_player->player_id, '"' . $the_player->game_season . '"' ),
							'runs_allowed'          => $the_player->RA,
							'earned_runs'           => $the_player->ER,
							'era'                   => sports_bench_get_ERA( (int) $the_player->ER, (int) $the_player->IP, 9 ),
							'hits_allowed'          => $the_player->HA,
							'strikeouts_pitched'    => $the_player->KS,
							'walks_allowed'         => $the_player->BB,
							'hpb'                   => $the_player->HPB,
							'homeruns_allowed'      => $the_player->HRA,
							'pitch_count'           => $the_player->PC,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_started ) as STARTS, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_minutes ) as MIN, SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_fga ) as FGA, SUM( g.game_player_3pm ) as TPM, SUM( g.game_player_3pa ) as TPA, SUM( g.game_player_ftm ) as FTM, SUM( g.game_player_fta ) as FTA, SUM( g.game_player_points ) as PTS, SUM( g.game_player_off_rebound ) as OFF_REB, SUM( g.game_player_def_rebound ) as DEF_REB, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_steals) as STEALS, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_to) as TURNOVERS, SUM( g.game_player_plus_minus ) as PM
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$seasons  = Database::get_results( $querystr );
					foreach ( $seasons as $the_player ) {
						$season_team = new Team( (int) $the_player->game_team_id );
						if ( strlen( $the_player->MIN ) > 4 ) {
							$seconds = substr( $the_player->MIN, -2, 2 );
							$time    = substr_replace( $the_player->MIN, '', -2, 2 );
							$minutes = substr( $time, -2, 2 );
							$time    = substr_replace( $time, '', -2, 2 );
							$times   = array( $time, $minutes, $seconds );
							$time    = implode( ':', $times );
						} else {
							$seconds = substr( $the_player->MIN, -2, 2 );
							$minutes = substr_replace( $the_player->MIN, '', -2, 2 );
							$times   = array( $minutes, $seconds );
							$time    = implode( ':', $times );
						}
						$player_stats = [
							'season'                    => $the_player->game_season,
							'team_id'                   => $season_team->get_team_id(),
							'team_name'                 => $season_team->get_team_name(),
							'team_logo'                 => $season_team->get_team_photo( 'team-logo' ),
							'team_link'                 => $season_team->get_permalink(),
							'games_played'              => $the_player->GP,
							'starts'                    => $the_player->STARTS,
							'minutes_played'            => $time,
							'field_goals_made'          => $the_player->FGM,
							'field_goals_attempts'      => $the_player->FGA,
							'three_pointers_made'       => $the_player->TPM,
							'three_pointers_attempts'   => $the_player->TPA,
							'free_throws_made'          => $the_player->FTM,
							'free_throws_attempts'      => $the_player->FTA,
							'points'                    => $the_player->PTS,
							'points_per_game'           => sports_bench_get_points_average( $the_player->PTS, $the_player->GP ),
							'offensive_rebounds'        => $the_player->OFF_REB,
							'defensive_rebounds'        => $the_player->DEF_REB,
							'assists'                   => $the_player->ASSISTS,
							'steals'                    => $the_player->STEALS,
							'blocks'                    => $the_player->BLOCKS,
							'turnovers'                 => $the_player->TURNOVERS,
							'plus_minus'                => $the_player->PM
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_completions ) as COMP, SUM( g.game_player_attempts ) as ATT, SUM( g.game_player_pass_yards ) as PASS_YD, SUM( g.game_player_pass_tds ) as PASS_TD, SUM( g.game_player_pass_ints ) as PASS_INT, SUM( g.game_player_rushes ) as RUSHES, SUM( g.game_player_rush_yards ) as RUSH_YARDS, SUM( g.game_player_rush_tds ) as RUSH_TD, SUM( g.game_player_rush_fumbles ) as RUSH_FUM, SUM( g.game_player_catches ) as CATCHES, SUM( g.game_player_receiving_yards ) as RECEIVE_YARDS, SUM( g.game_player_receiving_tds ) as RECEIVE_TD, SUM( g.game_player_receiving_fumbles ) as RECEIVE_FUM, SUM( g.game_player_tackles ) as TACKLES, SUM( g.game_player_tfl ) as TFL, SUM( g.game_player_sacks ) as SACKS, SUM( g.game_player_pbu ) as PBU, SUM( g.game_player_ints ) as INTS,  SUM( g.game_player_tds ) as TDS, SUM( g.game_player_ff ) as FF, SUM( g.game_player_fr ) as FR,  SUM( g.game_player_blocked ) as BLOCKED, SUM( g.game_player_yards ) as YARDS, SUM( g.game_player_fga ) as FGA,  SUM( g.game_player_fgm ) as FGM, SUM( g.game_player_xpa ) as XPA, SUM( g.game_player_xpm ) as XPM, SUM( g.game_player_touchbacks ) as TB, SUM( g.game_player_returns ) as RETURNS, SUM( g.game_player_return_yards ) as RETURN_YARDS, SUM( g.game_player_return_tds ) as RETURN_TDS, SUM( g.game_player_return_fumbles ) as RETURN_FUMBLES
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season;",
						$player_id
					);
					$seasons  = Database::get_results( $querystr );

					foreach ( $seasons as $the_player ) {
						$season_team  = new Team( (int) $the_player->game_team_id );
						$player_stats = [
							'season'                    => $the_player->game_season,
							'team_id'                   => $season_team->get_team_id(),
							'team_name'                 => $season_team->get_team_name(),
							'team_logo'                 => $season_team->get_team_photo( 'team-logo' ),
							'team_link'                 => $season_team->get_permalink(),
							'pass_completions'          => $the_player->COMP,
							'pass_attempts'             => $the_player->ATT,
							'pass_yards'                => $the_player->PASS_YD,
							'pass_touchdowns'           => $the_player->PASS_TD,
							'pass_interceptions'        => $the_player->PASS_INT,
							'rush_attempts'             => $the_player->RUSHES,
							'rush_yards'                => $the_player->RUSH_YARDS,
							'rush_touchdowns'           => $the_player->RUSH_TD,
							'rush_fumbles'              => $the_player->RUSH_FUM,
							'catches'                   => $the_player->CATCHES,
							'receiving_yards'           => $the_player->RECEIVE_YARDS,
							'receiving_touchdowns'      => $the_player->RECEIVE_TD,
							'receiving_fumbles'         => $the_player->RECEIVE_FUM,
							'tackles'                   => $the_player->TACKLES,
							'tackles_for_loss'          => $the_player->TFL,
							'sacks'                     => $the_player->SACKS,
							'interceptions'             => $the_player->INTS,
							'defensive_touchdowns'      => $the_player->TDS,
							'forced_fumbles'            => $the_player->FF,
							'fumbles_recovered'         => $the_player->FR,
							'blocked_kicks'             => $the_player->BLOCKED,
							'defensive_yards'           => $the_player->YARDS,
							'field_goals_made'          => $the_player->FGM,
							'field_goals_attempts'      => $the_player->FGA,
							'extra_points_made'         => $the_player->XPM,
							'extra_points_attempt'      => $the_player->XPA,
							'touchbacks'                => $the_player->TB,
							'kick_returns'              => $the_player->RETURNS,
							'kick_return_yards'         => $the_player->RETURN_YARDS,
							'kick_return_touchdowns'    => $the_player->RETURN_TDS,
							'kick_return_fumbles'       => $the_player->RETURN_FUMBLES,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare(  "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_plus_minus ) as PM, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_penalties ) as PEN, SUM( g.game_player_pen_minutes ) as PEN_MIN, SUM( g.game_player_hits ) as HITS, SUM( g.game_player_shifts ) as SHIFTS, SUM( g.game_player_time_on_ice ) as ICE_TIME, SUM( g.game_player_faceoffs ) as FACE, SUM( g.game_player_faceoff_wins ) as FACE_WINS, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_saves ) as SAVES, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED, COUNT( g.game_player_time_on_ice ) as GP
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final'
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$players  = Database::get_results( $querystr );
					foreach ( $players as $the_player ) {
						$season_team = new Team( (int) $the_player->game_team_id );
						if ( strlen( $the_player->ICE_TIME ) > 4 ) {
							$seconds = substr( $the_player->ICE_TIME, -2, 2 );
							$time    = substr_replace( $the_player->ICE_TIME, '', -2, 2 );
							$minutes = substr( $time, -2, 2 );
							$time    = substr_replace( $time, '', -2, 2 );
							$times   = array( $time, $minutes, $seconds );
							$time    = implode( ':', $times );
						} else {
							$seconds = substr( $the_player->ICE_TIME, -2, 2 );
							$minutes = substr_replace( $the_player->ICE_TIME, '', -2, 2 );
							$times   = array( $minutes, $seconds );
							$time    = implode( ':', $times );
						}
						$player_stats = [
							'season'                => $the_player->game_season,
							'team_id'               => $season_team->get_team_id(),
							'team_name'             => $season_team->get_team_name(),
							'team_logo'             => $season_team->get_team_photo( 'team-logo' ),
							'team_link'             => $season_team->get_permalink(),
							'goals'                 => $the_player->GOALS,
							'assists'               => $the_player->ASSISTS,
							'points'                => ( $the_player->GOALS + $the_player->ASSISTS ),
							'sog'                   => $the_player->SOG,
							'plus_minus'            => $the_player->PM,
							'penalties'             => $the_player->PEN,
							'penalty_minutes'       => $the_player->PEN_MIN,
							'hits'                  => $the_player->HITS,
							'shifts'                => $the_player->SHIFTS,
							'time_on_ice'           => $time,
							'faceoffs'              => $the_player->FACE,
							'faceoff_wins'          => $the_player->FACE_WINS,
							'shots-faced'           => $the_player->SHOTS_FACED,
							'saves'                 => $the_player->SAVES,
							'goals_allowed'         => $the_player->GOALS_ALLOWED,
							'goals_against_average' => sports_bench_get_goals_against_average( (int) $the_player->GOALS_ALLOWED, (int) $the_player->GP ),
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_tries ) as TRIES, COUNT( g.game_player_meters_run ) as GP, SUM( g.game_player_meters_run ) as METERS_RUN, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_conversions ) as CONVERSIONS, SUM( g.game_player_penalty_goals ) as PK_GOALS, SUM( g.game_player_drop_kicks ) as DROP_KICKS, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_penalties_conceeded ) as PENALTIES_CONCEEDED, SUM( g.game_player_red_cards ) as REDS, SUM( g.game_player_yellow_cards ) as YELLOWS
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$players = Database::get_results( $querystr );
					foreach( $players as $the_player ) {
						$season_team = new Team( (int) $the_player->game_team_id );
						$player_stats = [
							'season'                => $the_player->game_season,
							'team_id'               => $season_team->get_team_id(),
							'team_name'             => $season_team->get_team_name(),
							'team_logo'             => $season_team->get_team_photo( 'team-logo' ),
							'team_link'             => $season_team->get_permalink(),
							'games_played'          => $the_player->GP,
							'tries'                 => $the_player->TRIES,
							'assists'               => $the_player->ASSISTS,
							'conversions'           => $the_player->CONVERSIONS,
							'pk_goals'              => $the_player->PK_GOALS,
							'drop_kicks'            => $the_player->DROP_KICKS,
							'points'                => $the_player->POINTS,
							'penalties_conceded'    => $the_player->PENALTIES_CONCEEDED,
							'meters_run'            => $the_player->METERS_RUN,
							'red_cards'             => $the_player->REDS,
							'yellow_cards'          => $the_player->YELLOWS,
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_minutes ) as MINUTES, COUNT( g.game_player_minutes ) as GP, SUM( g.game_player_goals ) as GOALS, SUM( g.game_player_assists ) as ASSISTS, SUM( g.game_player_shots ) as SHOTS, SUM( g.game_player_sog ) as SOG, SUM( g.game_player_fouls ) as FOULS, SUM( g.game_player_fouls_suffered ) as FOULS_SUFFERED, SUM( g.game_player_shots_faced ) as SHOTS_FACED, SUM( g.game_player_shots_saved ) as SHOTS_SAVED, SUM( g.game_player_goals_allowed ) as GOALS_ALLOWED
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final' $and
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$players = Database::get_results( $querystr );
					foreach( $players as $the_player ) {
						$season_team = new Team( (int) $the_player->game_team_id );
						$player_stats = [
							'season'                => $the_player->game_season,
							'team_id'               => $season_team->get_team_id(),
							'team_name'             => $season_team->get_team_name(),
							'team_logo'             => $season_team->get_team_photo( 'team-logo' ),
							'team_link'             => $season_team->get_permalink(),
							'minutes'               => $the_player->MINUTES,
							'goals'                 => $the_player->GOALS,
							'assists'               => $the_player->ASSISTS,
							'shots'                 => $the_player->SHOTS,
							'sog'                   => $the_player->SOG,
							'fouls'                 => $the_player->FOULS,
							'fouls_suffered'        => $the_player->FOULS_SUFFERED,
							'shots_faced'           => $the_player->SHOTS_FACED,
							'shots_saved'           => $the_player->SHOTS_SAVED,
							'goals_allowed'         => $the_player->GOALS_ALLOWED,
							'goals_against_average' => sports_bench_get_goals_against_average( (int) $the_player->GOALS_ALLOWED, (int) $the_player->GP )
						];
						array_push( $stats_list, $player_stats );
					}
				} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
					$querystr = $wpdb->prepare( "SELECT p.player_id, p.player_first_name, p.player_last_name, p.team_id, game.game_id, game.game_season, g.game_id, g.game_team_id, g.game_player_id, SUM( g.game_player_sets_played ) as SETS_PLAYED, COUNT( g.game_player_sets_played ) as GP, SUM( g.game_player_points ) as POINTS, SUM( g.game_player_kills ) as KILLS, SUM( g.game_player_hitting_errors ) as HITTING_ERRORS, SUM( g.game_player_attacks ) as ATTACKS, SUM( g.game_player_set_attempts ) as SET_ATT, SUM( g.game_player_set_errors ) as SET_ERR, SUM( g.game_player_serves ) as SERVES, SUM( g.game_player_serve_errors ) as SE, SUM( g.game_player_aces ) as SA, SUM( g.game_player_blocks ) as BLOCKS, SUM( g.game_player_block_attempts ) as BA, SUM( g.game_player_block_errors) as BE, SUM( g.game_player_digs ) as DIGS, SUM( g.game_player_receiving_errors) as RE
						FROM $player_table as p LEFT JOIN $game_stats_table as g
						ON p.player_id = g.game_player_id
						LEFT JOIN $game_table as game
						ON game.game_id = g.game_id
						WHERE g.game_player_id = %d AND game.game_status = 'final'
						GROUP BY g.game_player_id, game.game_season, g.game_team_id;",
						$player_id
					);
					$players = Database::get_results( $querystr );
					foreach( $players as $the_player ) {
						$season_team = new Team( (int) $the_player->game_team_id );
						$player_stats = [
							'season'            => $the_player->game_season,
							'team_id'           => $season_team->get_team_id(),
							'team_name'         => $season_team->get_team_name(),
							'team_logo'         => $season_team->get_team_photo( 'team-logo' ),
							'team_link'         => $season_team->get_permalink(),
							'games_played'      => $the_player->GP,
							'sets_played'       => $the_player->SETS_PLAYED,
							'points'            => $the_player->POINTS,
							'hitting_percent'   => sports_bench_get_hitting_percentage( $the_player->ATTACKS, $the_player->KILLS, $the_player->HITTING_ERRORS ),
							'kills'             => $the_player->KILLS,
							'attacks'           => $the_player->ATTACKS,
							'hitting_errors'    => $the_player->HITTING_ERRORS,
							'set_errors'        => $the_player->SET_ERR,
							'set_attempts'      => $the_player->SET_ATT,
							'serves'            => $the_player->SERVES,
							'serve_errors'      => $the_player->SE,
							'aces'              => $the_player->SA,
							'blocks'            => $the_player->BLOCKS,
							'block_attempts'    => $the_player->BA,
							'block_errors'      => $the_player->BE,
							'digs'              => $the_player->DIGS,
							'rec_errors'        => $the_player->RE,
						];
						array_push( $stats_list, $player_stats );
					}
				}
				$response = $stats_list;
			} else {
				global $wpdb;
				$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
				$querystr   = "SELECT * FROM $table WHERE $search;";
				$game_stats = Database::get_results( $querystr );
				$stats_list = [];

				foreach ( $game_stats as $stats ) {
					if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'              => $stats->game_stats_player_id,
							'game_id'                           => $stats->game_id,
							'game_team_id'                      => $stats->game_team_id,
							'game_player_id'                    => $stats->game_player_id,
							'game_player_at_bats'               => $stats->game_player_at_bats,
							'game_player_hits'                  => $stats->game_player_hits,
							'game_player_runs'                  => $stats->game_player_runs,
							'game_player_rbis'                  => $stats->game_player_rbis,
							'game_player_doubles'               => $stats->game_player_doubles,
							'game_player_triples'               => $stats->game_player_triples,
							'game_player_homeruns'              => $stats->game_player_homeruns,
							'game_player_strikeouts'            => $stats->game_player_strikeouts,
							'game_player_walks'                 => $stats->game_player_walks,
							'game_player_hit_by_pitch'          => $stats->game_player_hit_by_pitch,
							'game_player_fielders_choice'       => $stats->game_player_fielders_choice,
							'game_player_position'              => $stats->game_player_position,
							'game_player_innings_pitched'       => $stats->game_player_innings_pitched,
							'game_player_pitcher_strikeouts'    => $stats->game_player_pitcher_strikeouts,
							'game_player_pitcher_walks'         => $stats->game_player_pitcher_walks,
							'game_player_hit_batters'           => $stats->game_player_hit_batters,
							'game_player_runs_allowed'          => $stats->game_player_runs_allowed,
							'game_player_earned_runs'           => $stats->game_player_earned_runs,
							'game_player_hits_allowed'          => $stats->game_player_hits_allowed,
							'game_player_homeruns_allowed'      => $stats->game_player_homeruns_allowed,
							'game_player_pitch_count'           => $stats->game_player_pitch_count,
							'game_player_decision'              => $stats->game_player_decision
						];
					} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'      => $stats->game_stats_player_id,
							'game_id'                   => $stats->game_id,
							'game_team_id'              => $stats->game_team_id,
							'game_player_id'            => $stats->game_player_id,
							'game_player_started'       => $stats->game_player_started,
							'game_player_minutes'       => $stats->game_player_minutes,
							'game_player_fgm'           => $stats->game_player_fgm,
							'game_player_fga'           => $stats->game_player_fga,
							'game_player_3pm'           => $stats->game_player_3pm,
							'game_player_3pa'           => $stats->game_player_3pa,
							'game_player_ftm'           => $stats->game_player_ftm,
							'game_player_fta'           => $stats->game_player_fta,
							'game_player_points'        => $stats->game_player_points,
							'game_player_off_rebound'   => $stats->game_player_off_rebound,
							'game_player_def_rebound'   => $stats->game_player_def_rebound,
							'game_player_assists'       => $stats->game_player_assists,
							'game_player_steals'        => $stats->game_player_steals,
							'game_player_blocks'        => $stats->game_player_blocks,
							'game_player_to'            => $stats->game_player_to,
							'game_player_fouls'         => $stats->game_player_fouls,
							'game_player_plus_minus'    => $stats->game_player_plus_minus
						];
					} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'          => $stats->game_stats_player_id,
							'game_id'                       => $stats->game_id,
							'game_team_id'                  => $stats->game_team_id,
							'game_player_id'                => $stats->game_player_id,
							'game_player_completions'       => $stats->game_player_completions,
							'game_player_attempts'          => $stats->game_player_attempts,
							'game_player_pass_yards'        => $stats->game_player_pass_yards,
							'game_player_pass_tds'          => $stats->game_player_pass_tds,
							'game_player_pass_ints'         => $stats->game_player_pass_ints,
							'game_player_rushes'            => $stats->game_player_rushes,
							'game_player_rush_yards'        => $stats->game_player_rush_yards,
							'game_player_rush_tds'          => $stats->game_player_rush_tds,
							'game_player_rush_fumbles'      => $stats->game_player_rush_fumbles,
							'game_player_catches'           => $stats->game_player_catches,
							'game_player_receiving_yards'   => $stats->game_player_receiving_yards,
							'game_player_receiving_tds'     => $stats->game_player_receiving_tds,
							'game_player_receiving_fumbles' => $stats->game_player_receiving_fumbles,
							'game_player_tackles'           => $stats->game_player_tackles,
							'game_player_tfl'               => $stats->game_player_tfl,
							'game_player_sacks'             => $stats->game_player_sacks,
							'game_player_pbu'               => $stats->game_player_pbu,
							'game_player_ints'              => $stats->game_player_ints,
							'game_player_tds'               => $stats->game_player_tds,
							'game_player_ff'                => $stats->game_player_ff,
							'game_player_fr'                => $stats->game_player_fr,
							'game_player_blocked'           => $stats->game_player_blocked,
							'game_player_yards'             => $stats->game_player_yards,
							'game_player_fga'               => $stats->game_player_fga,
							'game_player_fgm'               => $stats->game_player_fgm,
							'game_player_xpa'               => $stats->game_player_xpa,
							'game_player_xpm'               => $stats->game_player_xpm,
							'game_player_touchbacks'        => $stats->game_player_touchbacks,
							'game_player_returns'           => $stats->game_player_returns,
							'game_player_return_yards'      => $stats->game_player_return_yards,
							'game_player_return_tds'        => $stats->game_player_return_tds,
							'game_player_return_fumbles'    => $stats->game_player_return_fumbles
						];
					} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'      => $stats->game_stats_player_id,
							'game_id'                   => $stats->game_id,
							'game_team_id'              => $stats->game_team_id,
							'game_player_id'            => $stats->game_player_id,
							'game_player_goals'         => $stats->game_player_goals,
							'game_player_assists'       => $stats->game_player_assists,
							'game_player_plus_minus'    => $stats->game_player_plus_minus,
							'game_player_sog'           => $stats->game_player_sog,
							'game_player_penalties'     => $stats->game_player_penalties,
							'game_player_pen_minutes'   => $stats->game_player_pen_minutes,
							'game_player_hits'          => $stats->game_player_hits,
							'game_player_shifts'        => $stats->game_player_shifts,
							'game_player_time_on_ice'   => $stats->game_player_time_on_ice,
							'game_player_faceoffs'      => $stats->game_player_faceoffs,
							'game_player_faceoff_wins'  => $stats->game_player_faceoff_wins,
							'game_player_shots_faced'   => $stats->game_player_shots_faced,
							'game_player_saves'         => $stats->game_player_saves,
							'game_player_goals_allowed' => $stats->game_player_goals_allowed
						];
					} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'              => $stats->game_stats_player_id,
							'game_id'                           => $stats->game_id,
							'game_team_id'                      => $stats->game_team_id,
							'game_player_id'                    => $stats->game_player_id,
							'game_player_tries'                 => $stats->game_player_tries,
							'game_player_assists'               => $stats->game_player_assists,
							'game_player_conversions'           => $stats->game_player_conversions,
							'game_player_penalty_goals'         => $stats->game_player_penalty_goals,
							'game_player_drop_kicks'            => $stats->game_player_drop_kicks,
							'game_player_points'                => $stats->game_player_points,
							'game_player_penalties_conceeded'   => $stats->game_player_penalties_conceeded,
							'game_player_meters_run'            => $stats->game_player_meters_run,
							'game_player_red_cards'             => $stats->game_player_red_cards,
							'game_player_yellow_cards'          => $stats->game_player_yellow_cards,
						];
					} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'          => $stats->game_stats_player_id,
							'game_id'                       => $stats->game_id,
							'game_team_id'                  => $stats->game_team_id,
							'game_player_id'                => $stats->game_player_id,
							'game_player_minutes'           => $stats->game_player_minutes,
							'game_player_goals'             => $stats->game_player_goals,
							'game_player_assists'           => $stats->game_player_assists,
							'game_player_shots'             => $stats->game_player_shots,
							'game_player_sog'               => $stats->game_player_sog,
							'game_player_fouls'             => $stats->game_player_fouls,
							'game_player_fouls_suffered'    => $stats->game_player_fouls_suffered,
							'game_player_shots_faced'       => $stats->game_player_shots_faced,
							'game_player_shots_saved'       => $stats->game_player_shots_saved,
							'game_player_goals_allowed'     => $stats->game_player_goals_allowed
						];
					} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
						$stats_info = [
							'game_stats_player_id'          => $stats->game_stats_player_id,
							'game_id'                       => $stats->game_id,
							'game_team_id'                  => $stats->game_team_id,
							'game_player_id'                => $stats->game_player_id,
							'game_player_sets_played'       => $stats->game_player_sets_played,
							'game_player_points'            => $stats->game_player_points,
							'game_player_kills'             => $stats->game_player_plus_minus,
							'game_player_hitting_errors'    => $stats->game_player_hitting_errors,
							'game_player_attacks'           => $stats->game_player_attacks,
							'game_player_set_attempts'      => $stats->game_player_set_attempts,
							'game_player_set_errors'        => $stats->game_player_set_errors,
							'game_player_serves'            => $stats->game_player_serves,
							'game_player_serve_errors'      => $stats->game_player_serve_errors,
							'game_player_aces'              => $stats->game_player_aces,
							'game_player_blocks'            => $stats->game_player_blocks,
							'game_player_block_attempts'    => $stats->game_player_block_attempts,
							'game_player_block_errors'      => $stats->game_player_block_errors,
							'game_player_digs'              => $stats->game_player_digs,
							'game_player_receiving_errors'  => $stats->game_player_receiving_errors
						];
					}
					array_push( $stats_list, $stats_info );
				}
				$response = $stats_list;

			}

		} else {
			global $wpdb;
			$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
			$querystr   = "SELECT * FROM $table;";
			$game_stats = Database::get_results( $querystr );
			$stats_list = [];

			foreach ( $game_stats as $stats ) {
				if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'              => $stats->game_stats_player_id,
						'game_id'                           => $stats->game_id,
						'game_team_id'                      => $stats->game_team_id,
						'game_player_id'                    => $stats->game_player_id,
						'game_player_at_bats'               => $stats->game_player_at_bats,
						'game_player_hits'                  => $stats->game_player_hits,
						'game_player_runs'                  => $stats->game_player_runs,
						'game_player_rbis'                  => $stats->game_player_rbis,
						'game_player_doubles'               => $stats->game_player_doubles,
						'game_player_triples'               => $stats->game_player_triples,
						'game_player_homeruns'              => $stats->game_player_homeruns,
						'game_player_strikeouts'            => $stats->game_player_strikeouts,
						'game_player_walks'                 => $stats->game_player_walks,
						'game_player_hit_by_pitch'          => $stats->game_player_hit_by_pitch,
						'game_player_fielders_choice'       => $stats->game_player_fielders_choice,
						'game_player_position'              => $stats->game_player_position,
						'game_player_innings_pitched'       => $stats->game_player_innings_pitched,
						'game_player_pitcher_strikeouts'    => $stats->game_player_pitcher_strikeouts,
						'game_player_pitcher_walks'         => $stats->game_player_pitcher_walks,
						'game_player_hit_batters'           => $stats->game_player_hit_batters,
						'game_player_runs_allowed'          => $stats->game_player_runs_allowed,
						'game_player_earned_runs'           => $stats->game_player_earned_runs,
						'game_player_hits_allowed'          => $stats->game_player_hits_allowed,
						'game_player_homeruns_allowed'      => $stats->game_player_homeruns_allowed,
						'game_player_pitch_count'           => $stats->game_player_pitch_count,
						'game_player_decision'              => $stats->game_player_decision
					];
				} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'      => $stats->game_stats_player_id,
						'game_id'                   => $stats->game_id,
						'game_team_id'              => $stats->game_team_id,
						'game_player_id'            => $stats->game_player_id,
						'game_player_started'       => $stats->game_player_started,
						'game_player_minutes'       => $stats->game_player_minutes,
						'game_player_fgm'           => $stats->game_player_fgm,
						'game_player_fga'           => $stats->game_player_fga,
						'game_player_3pm'           => $stats->game_player_3pm,
						'game_player_3pa'           => $stats->game_player_3pa,
						'game_player_ftm'           => $stats->game_player_ftm,
						'game_player_fta'           => $stats->game_player_fta,
						'game_player_points'        => $stats->game_player_points,
						'game_player_off_rebound'   => $stats->game_player_off_rebound,
						'game_player_def_rebound'   => $stats->game_player_def_rebound,
						'game_player_assists'       => $stats->game_player_assists,
						'game_player_steals'        => $stats->game_player_steals,
						'game_player_blocks'        => $stats->game_player_blocks,
						'game_player_to'            => $stats->game_player_to,
						'game_player_fouls'         => $stats->game_player_fouls,
						'game_player_plus_minus'    => $stats->game_player_plus_minus
					];
				} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'          => $stats->game_stats_player_id,
						'game_id'                       => $stats->game_id,
						'game_team_id'                  => $stats->game_team_id,
						'game_player_id'                => $stats->game_player_id,
						'game_player_completions'       => $stats->game_player_completions,
						'game_player_attempts'          => $stats->game_player_attempts,
						'game_player_pass_yards'        => $stats->game_player_pass_yards,
						'game_player_pass_tds'          => $stats->game_player_pass_tds,
						'game_player_pass_ints'         => $stats->game_player_pass_ints,
						'game_player_rushes'            => $stats->game_player_rushes,
						'game_player_rush_yards'        => $stats->game_player_rush_yards,
						'game_player_rush_tds'          => $stats->game_player_rush_tds,
						'game_player_rush_fumbles'      => $stats->game_player_rush_fumbles,
						'game_player_catches'           => $stats->game_player_catches,
						'game_player_receiving_yards'   => $stats->game_player_receiving_yards,
						'game_player_receiving_tds'     => $stats->game_player_receiving_tds,
						'game_player_receiving_fumbles' => $stats->game_player_receiving_fumbles,
						'game_player_tackles'           => $stats->game_player_tackles,
						'game_player_tfl'               => $stats->game_player_tfl,
						'game_player_sacks'             => $stats->game_player_sacks,
						'game_player_pbu'               => $stats->game_player_pbu,
						'game_player_ints'              => $stats->game_player_ints,
						'game_player_tds'               => $stats->game_player_tds,
						'game_player_ff'                => $stats->game_player_ff,
						'game_player_fr'                => $stats->game_player_fr,
						'game_player_blocked'           => $stats->game_player_blocked,
						'game_player_yards'             => $stats->game_player_yards,
						'game_player_fga'               => $stats->game_player_fga,
						'game_player_fgm'               => $stats->game_player_fgm,
						'game_player_xpa'               => $stats->game_player_xpa,
						'game_player_xpm'               => $stats->game_player_xpm,
						'game_player_touchbacks'        => $stats->game_player_touchbacks,
						'game_player_returns'           => $stats->game_player_returns,
						'game_player_return_yards'      => $stats->game_player_return_yards,
						'game_player_return_tds'        => $stats->game_player_return_tds,
						'game_player_return_fumbles'    => $stats->game_player_return_fumbles
					];
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'      => $stats->game_stats_player_id,
						'game_id'                   => $stats->game_id,
						'game_team_id'              => $stats->game_team_id,
						'game_player_id'            => $stats->game_player_id,
						'game_player_goals'         => $stats->game_player_goals,
						'game_player_assists'       => $stats->game_player_assists,
						'game_player_plus_minus'    => $stats->game_player_plus_minus,
						'game_player_sog'           => $stats->game_player_sog,
						'game_player_penalties'     => $stats->game_player_penalties,
						'game_player_pen_minutes'   => $stats->game_player_pen_minutes,
						'game_player_hits'          => $stats->game_player_hits,
						'game_player_shifts'        => $stats->game_player_shifts,
						'game_player_time_on_ice'   => $stats->game_player_time_on_ice,
						'game_player_faceoffs'      => $stats->game_player_faceoffs,
						'game_player_faceoff_wins'  => $stats->game_player_faceoff_wins,
						'game_player_shots_faced'   => $stats->game_player_shots_faced,
						'game_player_saves'         => $stats->game_player_saves,
						'game_player_goals_allowed' => $stats->game_player_goals_allowed
					];
				} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'              => $stats->game_stats_player_id,
						'game_id'                           => $stats->game_id,
						'game_team_id'                      => $stats->game_team_id,
						'game_player_id'                    => $stats->game_player_id,
						'game_player_tries'                 => $stats->game_player_tries,
						'game_player_assists'               => $stats->game_player_assists,
						'game_player_conversions'           => $stats->game_player_conversions,
						'game_player_penalty_goals'         => $stats->game_player_penalty_goals,
						'game_player_drop_kicks'            => $stats->game_player_drop_kicks,
						'game_player_points'                => $stats->game_player_points,
						'game_player_penalties_conceeded'   => $stats->game_player_penalties_conceeded,
						'game_player_meters_run'            => $stats->game_player_meters_run,
						'game_player_red_cards'             => $stats->game_player_red_cards,
						'game_player_yellow_cards'          => $stats->game_player_yellow_cards,
					];
				} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'          => $stats->game_stats_player_id,
						'game_id'                       => $stats->game_id,
						'game_team_id'                  => $stats->game_team_id,
						'game_player_id'                => $stats->game_player_id,
						'game_player_minutes'           => $stats->game_player_minutes,
						'game_player_goals'             => $stats->game_player_goals,
						'game_player_assists'           => $stats->game_player_assists,
						'game_player_shots'             => $stats->game_player_shots,
						'game_player_sog'               => $stats->game_player_sog,
						'game_player_fouls'             => $stats->game_player_fouls,
						'game_player_fouls_suffered'    => $stats->game_player_fouls_suffered,
						'game_player_shots_faced'       => $stats->game_player_shots_faced,
						'game_player_shots_saved'       => $stats->game_player_shots_saved,
						'game_player_goals_allowed'     => $stats->game_player_goals_allowed
					];
				} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
					$stats_info = [
						'game_stats_player_id'          => $stats->game_stats_player_id,
						'game_id'                       => $stats->game_id,
						'game_team_id'                  => $stats->game_team_id,
						'game_player_id'                => $stats->game_player_id,
						'game_player_sets_played'       => $stats->game_player_sets_played,
						'game_player_points'            => $stats->game_player_points,
						'game_player_kills'             => $stats->game_player_plus_minus,
						'game_player_hitting_errors'    => $stats->game_player_hitting_errors,
						'game_player_attacks'           => $stats->game_player_attacks,
						'game_player_set_attempts'      => $stats->game_player_set_attempts,
						'game_player_set_errors'        => $stats->game_player_set_errors,
						'game_player_serves'            => $stats->game_player_serves,
						'game_player_serve_errors'      => $stats->game_player_serve_errors,
						'game_player_aces'              => $stats->game_player_aces,
						'game_player_blocks'            => $stats->game_player_blocks,
						'game_player_block_attempts'    => $stats->game_player_block_attempts,
						'game_player_block_errors'      => $stats->game_player_block_errors,
						'game_player_digs'              => $stats->game_player_digs,
						'game_player_receiving_errors'  => $stats->game_player_receiving_errors
					];
				}
				array_push( $stats_list, $stats_info );
			}
			$response = $stats_list;
		}

		return $response;
	}

	/**
	 * Returns an array of information for a team
	 *
	 * @param int $game_stat_id
	 *
	 * @return array, information for a team
	 *
	 * @since 1.4
	 */
	public function sports_bench_rest_get_game_stat( $game_stat_id ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE game_stats_player_id = %d;", $game_stat_id );
		$game_stats = Database::get_results( $querystr );
		$stats_list = [];

		foreach ( $game_stats as $stats ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'              => $stats->game_stats_player_id,
					'game_id'                           => $stats->game_id,
					'game_team_id'                      => $stats->game_team_id,
					'game_player_id'                    => $stats->game_player_id,
					'game_player_at_bats'               => $stats->game_player_at_bats,
					'game_player_hits'                  => $stats->game_player_hits,
					'game_player_runs'                  => $stats->game_player_runs,
					'game_player_rbis'                  => $stats->game_player_rbis,
					'game_player_doubles'               => $stats->game_player_doubles,
					'game_player_triples'               => $stats->game_player_triples,
					'game_player_homeruns'              => $stats->game_player_homeruns,
					'game_player_strikeouts'            => $stats->game_player_strikeouts,
					'game_player_walks'                 => $stats->game_player_walks,
					'game_player_hit_by_pitch'          => $stats->game_player_hit_by_pitch,
					'game_player_fielders_choice'       => $stats->game_player_fielders_choice,
					'game_player_position'              => $stats->game_player_position,
					'game_player_innings_pitched'       => $stats->game_player_innings_pitched,
					'game_player_pitcher_strikeouts'    => $stats->game_player_pitcher_strikeouts,
					'game_player_pitcher_walks'         => $stats->game_player_pitcher_walks,
					'game_player_hit_batters'           => $stats->game_player_hit_batters,
					'game_player_runs_allowed'          => $stats->game_player_runs_allowed,
					'game_player_earned_runs'           => $stats->game_player_earned_runs,
					'game_player_hits_allowed'          => $stats->game_player_hits_allowed,
					'game_player_homeruns_allowed'      => $stats->game_player_homeruns_allowed,
					'game_player_pitch_count'           => $stats->game_player_pitch_count,
					'game_player_decision'              => $stats->game_player_decision
				];
			} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'      => $stats->game_stats_player_id,
					'game_id'                   => $stats->game_id,
					'game_team_id'              => $stats->game_team_id,
					'game_player_id'            => $stats->game_player_id,
					'game_player_started'       => $stats->game_player_started,
					'game_player_minutes'       => $stats->game_player_minutes,
					'game_player_fgm'           => $stats->game_player_fgm,
					'game_player_fga'           => $stats->game_player_fga,
					'game_player_3pm'           => $stats->game_player_3pm,
					'game_player_3pa'           => $stats->game_player_3pa,
					'game_player_ftm'           => $stats->game_player_ftm,
					'game_player_fta'           => $stats->game_player_fta,
					'game_player_points'        => $stats->game_player_points,
					'game_player_off_rebound'   => $stats->game_player_off_rebound,
					'game_player_def_rebound'   => $stats->game_player_def_rebound,
					'game_player_assists'       => $stats->game_player_assists,
					'game_player_steals'        => $stats->game_player_steals,
					'game_player_blocks'        => $stats->game_player_blocks,
					'game_player_to'            => $stats->game_player_to,
					'game_player_fouls'         => $stats->game_player_fouls,
					'game_player_plus_minus'    => $stats->game_player_plus_minus
				];
			} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'          => $stats->game_stats_player_id,
					'game_id'                       => $stats->game_id,
					'game_team_id'                  => $stats->game_team_id,
					'game_player_id'                => $stats->game_player_id,
					'game_player_completions'       => $stats->game_player_completions,
					'game_player_attempts'          => $stats->game_player_attempts,
					'game_player_pass_yards'        => $stats->game_player_pass_yards,
					'game_player_pass_tds'          => $stats->game_player_pass_tds,
					'game_player_pass_ints'         => $stats->game_player_pass_ints,
					'game_player_rushes'            => $stats->game_player_rushes,
					'game_player_rush_yards'        => $stats->game_player_rush_yards,
					'game_player_rush_tds'          => $stats->game_player_rush_tds,
					'game_player_rush_fumbles'      => $stats->game_player_rush_fumbles,
					'game_player_catches'           => $stats->game_player_catches,
					'game_player_receiving_yards'   => $stats->game_player_receiving_yards,
					'game_player_receiving_tds'     => $stats->game_player_receiving_tds,
					'game_player_receiving_fumbles' => $stats->game_player_receiving_fumbles,
					'game_player_tackles'           => $stats->game_player_tackles,
					'game_player_tfl'               => $stats->game_player_tfl,
					'game_player_sacks'             => $stats->game_player_sacks,
					'game_player_pbu'               => $stats->game_player_pbu,
					'game_player_ints'              => $stats->game_player_ints,
					'game_player_tds'               => $stats->game_player_tds,
					'game_player_ff'                => $stats->game_player_ff,
					'game_player_fr'                => $stats->game_player_fr,
					'game_player_blocked'           => $stats->game_player_blocked,
					'game_player_yards'             => $stats->game_player_yards,
					'game_player_fga'               => $stats->game_player_fga,
					'game_player_fgm'               => $stats->game_player_fgm,
					'game_player_xpa'               => $stats->game_player_xpa,
					'game_player_xpm'               => $stats->game_player_xpm,
					'game_player_touchbacks'        => $stats->game_player_touchbacks,
					'game_player_returns'           => $stats->game_player_returns,
					'game_player_return_yards'      => $stats->game_player_return_yards,
					'game_player_return_tds'        => $stats->game_player_return_tds,
					'game_player_return_fumbles'    => $stats->game_player_return_fumbles
				];
			} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'      => $stats->game_stats_player_id,
					'game_id'                   => $stats->game_id,
					'game_team_id'              => $stats->game_team_id,
					'game_player_id'            => $stats->game_player_id,
					'game_player_goals'         => $stats->game_player_goals,
					'game_player_assists'       => $stats->game_player_assists,
					'game_player_plus_minus'    => $stats->game_player_plus_minus,
					'game_player_sog'           => $stats->game_player_sog,
					'game_player_penalties'     => $stats->game_player_penalties,
					'game_player_pen_minutes'   => $stats->game_player_pen_minutes,
					'game_player_hits'          => $stats->game_player_hits,
					'game_player_shifts'        => $stats->game_player_shifts,
					'game_player_time_on_ice'   => $stats->game_player_time_on_ice,
					'game_player_faceoffs'      => $stats->game_player_faceoffs,
					'game_player_faceoff_wins'  => $stats->game_player_faceoff_wins,
					'game_player_shots_faced'   => $stats->game_player_shots_faced,
					'game_player_saves'         => $stats->game_player_saves,
					'game_player_goals_allowed' => $stats->game_player_goals_allowed
				];
			} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'              => $stats->game_stats_player_id,
					'game_id'                           => $stats->game_id,
					'game_team_id'                      => $stats->game_team_id,
					'game_player_id'                    => $stats->game_player_id,
					'game_player_tries'                 => $stats->game_player_tries,
					'game_player_assists'               => $stats->game_player_assists,
					'game_player_conversions'           => $stats->game_player_conversions,
					'game_player_penalty_goals'         => $stats->game_player_penalty_goals,
					'game_player_drop_kicks'            => $stats->game_player_drop_kicks,
					'game_player_points'                => $stats->game_player_points,
					'game_player_penalties_conceeded'   => $stats->game_player_penalties_conceeded,
					'game_player_meters_run'            => $stats->game_player_meters_run,
					'game_player_red_cards'             => $stats->game_player_red_cards,
					'game_player_yellow_cards'          => $stats->game_player_yellow_cards,
				];
			} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'          => $stats->game_stats_player_id,
					'game_id'                       => $stats->game_id,
					'game_team_id'                  => $stats->game_team_id,
					'game_player_id'                => $stats->game_player_id,
					'game_player_minutes'           => $stats->game_player_minutes,
					'game_player_goals'             => $stats->game_player_goals,
					'game_player_assists'           => $stats->game_player_assists,
					'game_player_shots'             => $stats->game_player_shots,
					'game_player_sog'               => $stats->game_player_sog,
					'game_player_fouls'             => $stats->game_player_fouls,
					'game_player_fouls_suffered'    => $stats->game_player_fouls_suffered,
					'game_player_shots_faced'       => $stats->game_player_shots_faced,
					'game_player_shots_saved'       => $stats->game_player_shots_saved,
					'game_player_goals_allowed'     => $stats->game_player_goals_allowed
				];
			} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
				$stats_info = [
					'game_stats_player_id'          => $stats->game_stats_player_id,
					'game_id'                       => $stats->game_id,
					'game_team_id'                  => $stats->game_team_id,
					'game_player_id'                => $stats->game_player_id,
					'game_player_sets_played'       => $stats->game_player_sets_played,
					'game_player_points'            => $stats->game_player_points,
					'game_player_kills'             => $stats->game_player_plus_minus,
					'game_player_hitting_errors'    => $stats->game_player_hitting_errors,
					'game_player_attacks'           => $stats->game_player_attacks,
					'game_player_set_attempts'      => $stats->game_player_set_attempts,
					'game_player_set_errors'        => $stats->game_player_set_errors,
					'game_player_serves'            => $stats->game_player_serves,
					'game_player_serve_errors'      => $stats->game_player_serve_errors,
					'game_player_aces'              => $stats->game_player_aces,
					'game_player_blocks'            => $stats->game_player_blocks,
					'game_player_block_attempts'    => $stats->game_player_block_attempts,
					'game_player_block_errors'      => $stats->game_player_block_errors,
					'game_player_digs'              => $stats->game_player_digs,
					'game_player_receiving_errors'  => $stats->game_player_receiving_errors
				];
			}
			array_push( $stats_list, $stats_info );
		}
		$response = $stats_list;

		return $response;
	}

}

