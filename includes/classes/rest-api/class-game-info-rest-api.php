<?php
/**
 * Holds all of the game info REST API functions.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 * @author     Jacob Martella <me@jacobmartella.com>
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
 * This class defines all code necessary to run the game info REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Game_Info_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'game_info';
		register_rest_route(
			$namespace,
			'/' . $base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items'],
					'permission_callback' => [ $this, 'get_items_permissions_check'],
					'args'                => [ $this->get_collection_params() ],
				],
				[
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_item'],
					'permission_callback' => [ $this, 'create_item_permissions_check'],
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
					'callback'            => [ $this, 'get_item'],
					'permission_callback' => [ $this, 'get_item_permissions_check'],
					'args'                => [
						'context' => [
							'default'      => 'view',
							'required'     => true,
						],
						'params'  => [
							'game_info_id' => [
								'description'        => 'The id(s) for the game event(s) in the search.',
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
					'callback'            => [ $this, 'update_item'],
					'permission_callback' => [ $this, 'update_item_permissions_check'],
					'args'                => $this->get_endpoint_args_for_item_schema( false ),
				],
				[
					'methods'             => WP_REST_Server::DELETABLE,
					'callback'            => [ $this, 'delete_item'],
					'permission_callback' => [ $this, 'delete_item_permissions_check'],
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
				'callback'        => [ $this, 'get_public_item_schema'],
			]
		);
	}

	/**
	 * Get a collection of items.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		$params = $request->get_params();
		$items  = $this->get_games_info( $params ); //do a query, call another class, etc
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
	 * Get one item from the collection.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		$params = $request->get_params();
		$item   = $this->get_game_info( $params['id'] );
		$data   = $this->prepare_item_for_response( $item, $request );

		if ( 1 === 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return new WP_Error( 'code', esc_html__( 'Error', 'sports-bench' ) );
		}
	}

	/**
	 * Create one item from the collection.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( $request ) {

		$item = $this->prepare_item_for_database( $request );

		$data = $this->add_game_info( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Update one item from the collection.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_game_info( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Delete one item from the collection.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->game_info( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'Error', 'sports-bench'), [ 'status' => 500 ] );
	}

	/**
	 * Check if a given request has access to get items.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		return true;
	}

	/**
	 * Check if a given request has access to get a specific item.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|bool
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to create items.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|bool
	 */
	public function create_item_permissions_check( $request ) {
		return current_user_can( 'edit_something' );
	}

	/**
	 * Check if a given request has access to update a specific item.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|bool
	 */
	public function update_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to delete a specific item.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|bool
	 */
	public function delete_item_permissions_check( $request ) {
		return $this->create_item_permissions_check( $request );
	}

	/**
	 * Prepare the item for create or update operation.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Request object.
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {

		if ( isset( $request['game_info_id'] ) ) {
			$game_info_id = wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$game_info_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$game_info_id = '';
		}

		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_info_id'          => $game_info_id,
				'game_id'               => intval( $request['game_id'] ),
				'game_info_inning'      => intval( $request['game_info_inning'] ),
				'game_info_top_bottom'  => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_top_bottom'] ) ),
				'game_info_home_score'  => intval( $request['game_info_home_score'] ),
				'game_info_away_score'  => intval( $request['game_info_away_score'] ),
				'game_info_runs_scored' => intval( $request['game_info_runs_scored'] ),
				'game_info_score_play'  => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_score_play'] ) )
			];
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_info_id'              => $game_info_id,
				'game_id'                   => intval( $request['game_id'] ),
				'game_info_quarter'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_quarter'] ) ),
				'game_info_time'            => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_time'] ) ),
				'game_info_home_score'      => intval( $request['game_info_home_score'] ),
				'game_info_away_score'      => intval( $request['game_info_away_score'] ),
				'game_info_scoring_team_id' => intval( $request['game_info_scoring_team_id'] ),
				'game_info_play'            => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_play'] ) )
			];
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_info_id'            => $game_info_id,
				'game_id'                 => intval( $request['game_id'] ),
				'game_info_event'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_event'] ) ),
				'game_info_period'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_period'] ) ),
				'game_info_time'          => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_time'] ) ),
				'player_id'               => intval( $request['player_id'] ),
				'game_info_assist_one_id' => intval( $request['game_info_assist_one_id'] ),
				'game_info_assist_two_id' => intval( $request['game_info_assist_two_id'] ),
				'game_info_penalty'       => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_penalty'] ) ),
				'team_id'                 => intval( $request['team_id'] ),
			];
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_info_id'         => $game_info_id,
				'game_id'              => intval( $request['game_id'] ),
				'team_id'              => intval( $request['team_id'] ),
				'game_info_home_score' => intval( $request['game_info_home_score'] ),
				'game_info_away_score' => intval( $request['game_info_away_score'] ),
				'game_info_event'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_event'] ) ),
				'game_info_time'       => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_time'] ) ),
				'player_id'            => intval( $request['player_id'] ),
			];
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$item = [
				'game_info_id'         => $game_info_id,
				'game_id'              => intval( $request['game_id'] ),
				'team_id'              => intval( $request['team_id'] ),
				'game_info_home_score' => intval( $request['game_info_home_score'] ),
				'game_info_away_score' => intval( $request['game_info_away_score'] ),
				'game_info_event'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_event'] ) ),
				'game_info_time'       => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_time'] ) ),
				'player_id'            => intval( $request['player_id'] ),
				'game_player_name'     => '',
				'game_info_assists'    => wp_filter_nohtml_kses( sanitize_text_field( $request['game_info_assists'] ) ),
			];
		}

		return $item;
	}

	/**
	 * Prepare the item for the REST response.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed           $item          WordPress representation of the item.
	 * @param WP_REST_Request $request       Request object.
	 * @return mixed                         The data for the request.
	 */
	public function prepare_item_for_response( $item, $request ) {

		$schema = $this->get_item_schema();
		$data   = [];
		$data   = $item;

		return $data;
	}

	/**
	 * Get the query params for collections.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of collection param.
	 */
	public function get_collection_params() {
		return [
			'game_id' => [
				'description'        => 'The id(s) for the game(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			],
			'game_info_id' => [
				'description'        => 'The id(s) for the game event(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_info_inning' => [
				'description'        => 'The inning(s) for the game event(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_info_quarter' => [
				'description'        => 'The quarter(s) for the game event(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_info_period' => [
				'description'        => 'The period(s) for the game event(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_info_event' => [
				'description'        => 'The event for the game event(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
		];
	}

	/**
	 * Get the Entry schema, conforming to JSON Schema.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The item schema.
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

	/**
	 * Adds a game info row through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to add to the game info table.
	 * @return array|WP_Error      The array of information for the game info or an error.
	 */
	public function add_game_info( $item ) {

		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$the_id     = $item['game_info_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_info_id = %d", $the_id ) );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_insert', esc_html__( 'There was an error creating the game event. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_game_insert', esc_html__( 'This game event has already been created in the database. Maybe try updating the game event.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	/**
	 * Updates a game info row through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to update a row in the game info table.
	 * @return array|WP_Error      The array of information for the game info or an error.
	 */
	public function update_game_info( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$the_id     = $item['game_info_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_info_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, [ 'game_info_id' => $item['game_info_id'] ] );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_update', esc_html__( 'There was an error updating the game event. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game event does not exist. Try adding the game event first.', 'sports-bench' ), [ 'status' => 500 ] );
		}
	}

	/**
	 * Deletes a game info row through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to delete from the game info table.
	 * @return array|WP_Error      The array of information for the game info row or an error.
	 */
	public function delete_game_info( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$the_id     = $item['game_info_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE game_info_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete(
				$table_name,
				[ 'game_info_id' => $the_id ],
				[ '%d' ]
			);
			if ( false === $result ) {
				return new WP_Error( 'error_game_delete', esc_html__( 'There was an error deleting the game event. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game event does not exist.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results for game info.
	 *
	 * @since 2.0.0
	 *
	 * @param array $params      The parameters to search for.
	 * @return string            JSON array of the SQL results
	 */
	public function get_games_info( $params ) {
		$response = '';

		if ( ( isset( $params['game_info_id'] ) && null !== $params['game_info_id'] ) || ( isset( $params['game_id'] ) && null !== $params['game_id'] ) || ( isset( $params['game_info_inning'] ) && null !== $params['game_info_inning'] ) || ( isset( $params['game_info_quarter'] ) && null !== $params['game_info_quarter'] ) || ( isset( $params['game_info_period'] ) && null !== $params['game_info_period'] ) || ( isset( $params['game_info_event'] ) && null !== $params['game_info_event'] ) ) {

			$and    = false;
			$search = '';
			if ( isset( $params['game_info_id'] ) && null !== $params['game_info_id'] ) {
				$search .= 'game_info_id in (' . $params['game_info_id'] . ')';
				$and     = true;
			}
			if ( isset( $params['game_id'] ) && null !== $params['game_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_id in (' . $params['game_id'] . ')';
				$and     = true;
			}
			if ( isset( $params['game_info_inning'] ) && null !== $params['game_info_inning'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_info_inning in (' . $params['game_info_inning'] . ')';
				$and     = true;
			}
			if ( isset( $params['game_info_quarter'] ) && null !== $params['game_info_quarter'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_info_quarter in (' . $params['game_info_quarter'] . ')';
				$and     = true;
			}
			if ( isset( $params['game_info_period'] ) && null !== $params['game_info_period'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_info_period in ( "' . $params['game_info_period'] . '" )';
				$and     = true;
			}
			if ( isset( $params['game_info_event'] ) && null !== $params['game_info_event'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_info_event in ( "' . $params['game_info_event'] . '" )';
				$and     = true;
			}

			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
			$querystr    = "SELECT * FROM $table WHERE $search;";
			$game_events = Database::get_results( $querystr );
			$events_list = [];

			foreach ( $game_events as $event ) {
				if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_inning'      => $event->game_info_inning,
						'game_info_top_bottom'  => $event->game_info_top_bottom,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_runs_scored' => $event->game_info_runs_scored,
						'game_info_score_play'  => $event->game_info_score_play,
					];
				} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_referees'    => $event->game_info_referees,
						'game_info_techs'       => $event->game_info_techs,
					];
				} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'              => $event->game_info_id,
						'game_id'                   => $event->game_id,
						'game_info_quarter'         => $event->game_info_quarter,
						'game_info_time'            => $event->game_info_time,
						'game_info_scoring_team_id' => $event->game_info_scoring_team_id,
						'game_info_home_score'      => $event->game_info_home_score,
						'game_info_away_score'      => $event->game_info_away_score,
						'game_info_play'            => $event->game_info_play,
					];
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'              => $event->game_info_id,
						'game_id'                   => $event->game_id,
						'game_info_event'           => $event->game_info_event,
						'game_info_period'          => $event->game_info_period,
						'game_info_time'            => $event->game_info_time,
						'player_id'                 => $event->player_id,
						'game_info_assist_one_id'   => $event->game_info_assist_one_id,
						'game_info_assist_two_id'   => $event->game_info_assist_two_id,
						'game_info_penalty'         => $event->game_info_penalty,
						'team_id'                   => $event->team_id,
					];
				} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'team_id'               => $event->team_id,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_event'       => $event->game_info_event,
						'game_info_time'        => $event->game_info_time,
						'player_id'             => $event->player_id,
					];
				} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'team_id'               => $event->team_id,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_event'       => $event->game_info_event,
						'game_info_time'        => $event->game_info_time,
						'player_id'             => $event->player_id,
						'game_player_name'      => $event->game_player_name,
						'game_info_assists'     => $event->game_info_assists,
					];
				} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_referees'    => $event->game_info_referees,
					];
				}
				array_push( $events_list, $event_info );
			}
			$response = $events_list;
		} else {
			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
			$querystr    = "SELECT * FROM $table;";
			$game_events = Database::get_results( $querystr );
			$events_list = [];

			foreach ( $game_events as $event ) {
				if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_inning'      => $event->game_info_inning,
						'game_info_top_bottom'  => $event->game_info_top_bottom,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_runs_scored' => $event->game_info_runs_scored,
						'game_info_score_play'  => $event->game_info_score_play,
					];
				} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_referees'    => $event->game_info_referees,
						'game_info_techs'       => $event->game_info_techs,
					];
				} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'              => $event->game_info_id,
						'game_id'                   => $event->game_id,
						'game_info_quarter'         => $event->game_info_quarter,
						'game_info_time'            => $event->game_info_time,
						'game_info_scoring_team_id' => $event->game_info_scoring_team_id,
						'game_info_home_score'      => $event->game_info_home_score,
						'game_info_away_score'      => $event->game_info_away_score,
						'game_info_play'            => $event->game_info_play,
					];
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'              => $event->game_info_id,
						'game_id'                   => $event->game_id,
						'game_info_event'           => $event->game_info_event,
						'game_info_period'          => $event->game_info_period,
						'game_info_time'            => $event->game_info_time,
						'player_id'                 => $event->player_id,
						'game_info_assist_one_id'   => $event->game_info_assist_one_id,
						'game_info_assist_two_id'   => $event->game_info_assist_two_id,
						'game_info_penalty'         => $event->game_info_penalty,
						'team_id'                   => $event->team_id,
					];
				} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'team_id'               => $event->team_id,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_event'       => $event->game_info_event,
						'game_info_time'        => $event->game_info_time,
						'player_id'             => $event->player_id,
					];
				} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'team_id'               => $event->team_id,
						'game_info_home_score'  => $event->game_info_home_score,
						'game_info_away_score'  => $event->game_info_away_score,
						'game_info_event'       => $event->game_info_event,
						'game_info_time'        => $event->game_info_time,
						'player_id'             => $event->player_id,
						'game_player_name'      => $event->game_player_name,
						'game_info_assists'     => $event->game_info_assists,
					];
				} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
					$event_info = [
						'game_info_id'          => $event->game_info_id,
						'game_id'               => $event->game_id,
						'game_info_referees'    => $event->game_info_referees,
					];
				}
				array_push( $events_list, $event_info );
			}
			$response = $events_list;
		}

		return $response;
	}

	/**
	 * Returns an array of information for a game info row.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_info_id      The game info row to get.
	 * @return array                 Information for a division.
	 */
	public function get_game_info( $game_info_id ) {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$querystr    = $wpdb->prepare( "SELECT * FROM $table WHERE game_info_id = %d;", $game_info_id );
		$game_events = Database::get_results( $querystr );
		$events_list = [];

		foreach ( $game_events as $event ) {
			if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'          => $event->game_info_id,
					'game_id'               => $event->game_id,
					'game_info_inning'      => $event->game_info_inning,
					'game_info_top_bottom'  => $event->game_info_top_bottom,
					'game_info_home_score'  => $event->game_info_home_score,
					'game_info_away_score'  => $event->game_info_away_score,
					'game_info_runs_scored' => $event->game_info_runs_scored,
					'game_info_score_play'  => $event->game_info_score_play,
				];
			} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'          => $event->game_info_id,
					'game_id'               => $event->game_id,
					'game_info_referees'    => $event->game_info_referees,
					'game_info_techs'       => $event->game_info_techs,
				];
			} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'              => $event->game_info_id,
					'game_id'                   => $event->game_id,
					'game_info_quarter'         => $event->game_info_quarter,
					'game_info_time'            => $event->game_info_time,
					'game_info_scoring_team_id' => $event->game_info_scoring_team_id,
					'game_info_home_score'      => $event->game_info_home_score,
					'game_info_away_score'      => $event->game_info_away_score,
					'game_info_play'            => $event->game_info_play,
				];
			} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'              => $event->game_info_id,
					'game_id'                   => $event->game_id,
					'game_info_event'           => $event->game_info_event,
					'game_info_period'          => $event->game_info_period,
					'game_info_time'            => $event->game_info_time,
					'player_id'                 => $event->player_id,
					'game_info_assist_one_id'   => $event->game_info_assist_one_id,
					'game_info_assist_two_id'   => $event->game_info_assist_two_id,
					'game_info_penalty'         => $event->game_info_penalty,
					'team_id'                   => $event->team_id,
				];
			} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'          => $event->game_info_id,
					'game_id'               => $event->game_id,
					'team_id'               => $event->team_id,
					'game_info_home_score'  => $event->game_info_home_score,
					'game_info_away_score'  => $event->game_info_away_score,
					'game_info_event'       => $event->game_info_event,
					'game_info_time'        => $event->game_info_time,
					'player_id'             => $event->player_id,
				];
			} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'          => $event->game_info_id,
					'game_id'               => $event->game_id,
					'team_id'               => $event->team_id,
					'game_info_home_score'  => $event->game_info_home_score,
					'game_info_away_score'  => $event->game_info_away_score,
					'game_info_event'       => $event->game_info_event,
					'game_info_time'        => $event->game_info_time,
					'player_id'             => $event->player_id,
					'game_player_name'      => $event->game_player_name,
					'game_info_assists'     => $event->game_info_assists,
				];
			} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
				$event_info = [
					'game_info_id'          => $event->game_info_id,
					'game_id'               => $event->game_id,
					'game_info_referees'    => $event->game_info_referees,
				];
			}
			array_push( $events_list, $event_info );
		}
		$response = $events_list;

		return $response;
	}

}
