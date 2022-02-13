<?php
/**
 * Holds all of the team REST API functions.
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
use Sports_Bench\Classes\Base\Series;

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run the team REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Series_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'series';
		register_rest_route(
			$namespace,
			'/' . $base,
			array(
				array(
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items'],
					'permission_callback' => [ $this, 'get_items_permissions_check'],
					'args'                => [ $this->get_collection_params() ],
				),
				array(
					'methods'             => WP_REST_Server::CREATABLE,
					'callback'            => [ $this, 'create_item'],
					'permission_callback' => [ $this, 'create_item_permissions_check'],
					'args'                => $this->get_endpoint_args_for_item_schema( true ),
				),
			)
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
							'series_id' => [
								'description'        => 'The id(s) for the series(es) in the search.',
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
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [ $this, 'get_public_item_schema'],
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
		$items  = $this->get_serieses( $params ); //do a query, call another class, etc
		$data   = array();
		foreach ( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[]   = $this->prepare_response_for_collection( $itemdata );
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
		$params = $request->get_params();
		$item   = $this->get_series( $params['id'] );
		$data   = $this->prepare_item_for_response( $item, $request );

		if ( 1 === 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return new WP_Error( 'code', esc_html__( 'message', 'sports-bench' ) );
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

		$data = $this->add_series( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );

	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_series( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );

	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->delete_series( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );
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
		return current_user_can( 'edit_something' );
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

		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_series';

		if ( isset( $request['series_id'] ) ) {
			$series_id = wp_filter_nohtml_kses( sanitize_text_field( $request['series_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$series_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$series_id = '';
		}

		if ( isset( $request['bracket_id'] ) ) {
			$bracket_id = wp_filter_nohtml_kses( sanitize_text_field( $request['bracket_id'] ) );
		} else {
			$bracket_id = '';
		}

		if ( isset( $request['series_format'] ) ) {
			$series_format = wp_filter_nohtml_kses( sanitize_text_field( $request['series_format'] ) );
		} else {
			$series_format = '';
		}

		if ( isset( $request['playoff_round'] ) ) {
			$playoff_round = wp_filter_nohtml_kses( sanitize_text_field( $request['playoff_round'] ) );
		} else {
			$playoff_round = '';
		}

		if ( isset( $request['team_one_id'] ) ) {
			$team_one_id = wp_filter_nohtml_kses( sanitize_text_field( $request['team_one_id'] ) );
		} else {
			$team_one_id = '';
		}

		if ( isset( $request['team_one_seed'] ) ) {
			$team_one_seed = wp_filter_nohtml_kses( sanitize_text_field( $request['team_one_seed'] ) );
		} else {
			$team_one_seed = '';
		}

		if ( isset( $request['team_two_id'] ) ) {
			$team_two_id = wp_filter_nohtml_kses( sanitize_text_field( $request['team_two_id'] ) );
		} else {
			$team_two_id = '';
		}

		if ( isset( $request['team_two_seed'] ) ) {
			$team_two_seed = wp_filter_nohtml_kses( sanitize_text_field( $request['team_two_seed'] ) );
		} else {
			$team_two_seed = '';
		}

		if ( isset( $request['game_ids'] ) ) {
			$game_ids = wp_filter_nohtml_kses( sanitize_text_field( $request['game_ids'] ) );
		} else {
			$game_ids = '';
		}

		$item = [
			'series_id'     => $series_id,
			'bracket_id'    => $bracket_id,
			'series_format' => $series_format,
			'playoff_round' => $playoff_round,
			'team_one_id'   => $team_one_id,
			'team_one_seed' => $team_one_seed,
			'team_two_id'   => $team_two_id,
			'team_two_seed' => $team_two_seed,
			'game_ids'      => $game_ids,
		];

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
			'series_id' => [
				'description'        => 'The id(s) for the series(es) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			],
			'bracket_id' => [
				'description'        => 'The bracket id(s) the series(es) in the search',
				'type'               => 'integer',
				'default'            => '',
				'sanitize_callback'  => 'absint',
			],
			'series_format' => [
				'description'        => 'The format(s) for the series(es) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'playoff_round' => [
				'description'        => 'The round(s) for the series(es) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'team_one_id' => [
				'description'        => 'The ids(s) for the first team(s) in the search',
				'type'               => 'integer',
				'default'            => 0,
				'sanitize_callback'  => 'absint',
			],
			'team_one_seed' => [
				'description'        => 'The seed(s) of the first team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'team_two_id' => [
				'description'        => 'The ids(s) for the second team(s) in the search',
				'type'               => 'integer',
				'default'            => 0,
				'sanitize_callback'  => 'absint',
			],
			'team_two_seed' => [
				'description'        => 'The seed(s) of the second team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'game_ids' => [
				'description'        => 'The id(s) of the games(s) for the series(es) in the search',
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
				'series_id' => [
					'description' => esc_html__( 'The id for the series.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				],
			],
		];
		return $schema;
	}

	public function add_series( $item ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_series';
		$the_id     = $item['series_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE series_id = $the_id" );

		if ( [] === $slug_test ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_series_insert', esc_html__( 'There was an error creating the series. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_series_insert', esc_html__( 'This series has already been created in the database. Maybe try updating the series.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	public function update_series( $item ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_series';
		$the_id     = $item['series_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE series_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, [ 'series_id' => $item['series_id'] ] );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_series_update', esc_html__( 'There was an error updating the series. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_series_update', esc_html__( 'This series does not exist. Try adding the series first.', 'sports-bench' ), [ 'status' => 500 ] );
		}
	}

	public function delete_series( $item ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_series';
		$the_id     = $item['series_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE series_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete(
				$table_name,
				[ 'series_id' => $the_id ],
				[ '%d' ]
			);
			if ( $result == false ) {
				return new WP_Error( 'error_series_delete', esc_html__( 'There was an error deleting the series. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_series_update', esc_html__( 'This series does not exist.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results
	 *
	 * @param WP_REST_Request $params
	 *
	 * @return string, JSON array of the SQL results
	 *
	 * @since 1.1
	 */
	public function get_serieses( $params ) {
		$response = '';

		if ( ( isset( $params['series_id'] ) && null !== $params['series_id'] ) || ( isset( $params['bracket_id'] ) && null !== $params['bracket_id'] ) || ( isset( $params['series_format'] ) && null !== $params['series_format'] ) || ( isset( $params['playoff_round'] ) && null !== $params['playoff_round'] ) || ( isset( $params['team_one_id'] ) && null !== $params['team_one_id'] ) || ( isset( $params['team_one_seed'] ) && null !== $params['team_one_seed'] ) || ( isset( $params['team_two_id'] ) && null !== $params['team_two_id'] ) || ( isset( $params['team_two_seed'] ) && null !== $params['team_two_seed'] ) || ( isset( $params['game_ids'] ) && null !== $params['game_ids'] ) ) {

			$and    = false;
			$search = '';
			if ( isset( $params['series_id'] ) && null !== $params['series_id'] ) {
				$search .= 'series_id in (' . $params['series_id'] . ')';
				$and     = true;
			} if ( isset( $params['bracket_id'] ) && null !== $params['bracket_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'bracket_id in (' . $params['bracket_id'] . ')';
				$and     = true;
			} if ( isset( $params['series_format'] ) && null !== $params['series_format'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'series_format in ( "' . $params['series_format'] . '" )';
				$and     = true;
			} if ( isset( $params['playoff_round'] ) && null !== $params['playoff_round'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'playoff_round in ( "' . $params['playoff_round'] . '" )';
				$and     = true;
			} if ( isset( $params['team_one_id'] ) && null !== $params['team_one_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_one_id in (' . $params['team_one_id'] . ')';
				$and     = true;
			} if ( isset( $params['team_one_seed'] ) && null !== $params['team_one_seed'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_one_seed in (' . $params['team_one_seed'] . ')';
				$and     = true;
			} if ( isset( $params['team_two_id'] ) && null !== $params['team_two_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_two_id in (' . $params['team_two_id'] . ')';
				$and     = true;
			} if ( isset( $params['team_two_seed'] ) && null !== $params['team_two_seed'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_two_seed in (' . $params['team_two_seed'] . ')';
				$and     = true;
			} if ( isset( $params['game_ids'] ) && null !== $params['game_ids'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_ids in ( "' . $params['game_ids'] . '" )';
			}

			global $wpdb;
			$table       = SB_TABLE_PREFIX . 'playoff_series';
			$querystr    = "SELECT * FROM $table WHERE $search;";
			$serieses    = Database::get_results( $querystr );
			$series_list = [];

			foreach ( $serieses as $series ) {
				$series = new Series( (int) $series->series_id );
				$return_series = [
					'series_id'             => $series->series_id,
					'bracket_id'            => $series->bracket_id,
					'series_format'         => $series->series_format,
					'playoff_round'         => $series->playoff_round,
					'team_one_id'           => $series->team_one_id,
					'team_one_seed'         => $series->team_one_seed,
					'team_two_id'           => $series->team_two_id,
					'team_two_seed'         => $series->team_two_seed,
					'game_ids'              => $series->game_ids,
				];

				array_push( $series_list, $return_series);
			}
			$response = $series_list;

		} else {

			global $wpdb;
			$table       = SB_TABLE_PREFIX . 'playoff_series';
			$querystr    = "SELECT * FROM $table;";
			$serieses    = Database::get_results( $querystr );
			$series_list = [];

			foreach ( $serieses as $series ) {
				$series        = new Series( (int) $series->series_id );
				$return_series = [
					'series_id'             => $series->series_id,
					'bracket_id'            => $series->bracket_id,
					'series_format'         => $series->series_format,
					'playoff_round'         => $series->playoff_round,
					'team_one_id'           => $series->team_one_id,
					'team_one_seed'         => $series->team_one_seed,
					'team_two_id'           => $series->team_two_id,
					'team_two_seed'         => $series->team_two_seed,
					'game_ids'              => $series->game_ids,
				];

				array_push( $series_list, $return_series );
			}
			$response = $series_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a series
	 *
	 * @param int $series_id
	 *
	 * @return array, information for a series
	 *
	 * @since 1.4
	 */
	public function get_series( $series_id ) {
		$the_series  = new Series( (int) $series_id );
		$series_info = [
			'series_id'     => $the_series->series_id,
			'bracket_id'    => $the_series->bracket_id,
			'series_format' => $the_series->series_format,
			'playoff_round' => $the_series->playoff_round,
			'team_one_id'   => $the_series->team_one_id,
			'team_one_seed' => $the_series->team_one_seed,
			'team_two_id'   => $the_series->team_two_id,
			'team_two_seed' => $the_series->team_two_seed,
			'game_ids'      => $the_series->game_ids,
		];

		return $series_info;
	}

}
