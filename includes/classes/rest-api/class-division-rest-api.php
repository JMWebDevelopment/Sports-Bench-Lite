<?php
/**
 * Holds all of the division REST API functions.
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
 * This class defines all code necessary to run the division REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Division_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'divisions';
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
							'default'  => 'view',
							'required' => true,
						],
						'params'  => [
							'bracket_id' => [
								'description'        => 'The id(s) for the division(s) in the search.',
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
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_public_item_schema' ],
				'permission_callback' => [ $this, 'get_items_permissions_check' ],
			]
		);
	}

	/**
	 * Get a collection of items
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_items( $request ) {
		$params = $request->get_params();
		$items  = $this->sports_bench_rest_get_divisions( $params ); //do a query, call another class, etc
		$data   = [];
		foreach ( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[] = $this->prepare_response_for_collection( $itemdata );
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
		//get parameters from request
		$params = $request->get_params();
		$item   = $this->sports_bench_rest_get_division( $params['id'] );//do a query, call another class, etc
		$data   = $this->prepare_item_for_response( $item, $request );

		//return a response or error based on some conditional
		if ( 1 == 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return new WP_Error( 'code', esc_html__( 'message', 'sports-bench' ) );
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

		$data = sports_bench_rest_add_division( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );

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

		$data = $this->sports_bench_rest_update_division( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );

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

		$deleted = $this->sports_bench_rest_delete_division( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );
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
	 * @param WP_REST_Request $request      The request object.
	 * @return WP_Error|object              The item for the database or an error.
	 */
	protected function prepare_item_for_database( $request ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_divisions';

		if ( isset( $request['division_id'] ) ) {
			$division_id = wp_filter_nohtml_kses( sanitize_text_field( $request['division_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$division_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$division_id = '';
		}

		if ( isset( $request['division_name'] ) ) {
			$division_name = wp_filter_nohtml_kses( sanitize_text_field( $request['division_name'] ) );
		} else {
			$division_name = '';
		}

		if ( isset( $request['division_conference'] ) ) {
			$division_conference = intval( $request['division_conference'] );
		} else {
			$division_conference = null;
		}

		if ( isset( $request['division_conference_id'] ) ) {
			$division_conference_id = wp_filter_nohtml_kses( sanitize_text_field( $request['division_conference_id'] ) );
		} else {
			$division_conference_id = '';
		}

		if ( isset( $request['division_color'] ) ) {
			$division_color = wp_filter_nohtml_kses( sanitize_text_field( $request['division_color'] ) );
		} else {
			$division_color = '';
		}

		$item = array(
			'division_id'               => $division_id,
			'division_name'             => $division_name,
			'division_conference'       => $division_conference,
			'division_conference_id'    => $division_conference_id,
			'division_color'            => $division_color,
		);

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
		$data   = array();
		$data   = $item;

		return $data;
	}

	/**
	 * Get the query params for collections.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The collection params.
	 */
	public function get_collection_params() {
		return array(
			'division_id' => array(
				'description'        => 'The id(s) for the division(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			),
			'division_name' => array(
				'description'        => 'The name(s) the division(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'division_conference' => array(
				'description'        => 'Whether the search should include conferences or divisions.',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'division_conference_id' => array(
				'description'        => 'The conference id(s) for the division(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'division_color' => array(
				'description'        => 'The color(s) for the division(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
		);
	}

	/**
	 * Get the Entry schema, conforming to JSON Schema.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The item schema.
	 */
	public function get_item_schema() {
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'entry',
			'type'       => 'object',
			'properties' => array(
				'player_id' => array(
					'description' => __( 'The id for the division.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
			),
		);
		return $schema;
	}

	/**
	 * Adds a division through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to add to the divisions table.
	 * @return array|WP_Error      The array of information for the division or an error.
	 */
	public function sports_bench_rest_add_division( $item ) {

		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'sb_divisions';
		$the_id     = $item['division_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE division_id = %d", $the_id ) );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error(
					'error_division_insert',
					esc_html__( 'There was an error creating the division. Please check your data and try again.', 'sports-bench' ),
					[
						'status' => 500,
					]
				);
			}
		} else {
			return new WP_Error(
				'error_division_insert',
				esc_html__( 'This division has already been created in the database. Maybe try updating the division.', 'sports-bench' ),
				[
					'status' => 500,
				]
			);
		}

	}

	/**
	 * Updates a division through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to update a row in the divisions table.
	 * @return array|WP_Error      The array of information for the division or an error.
	 */
	public function sports_bench_rest_update_division( $item ) {
		global $wpdb;
		$table_name = JM_TABLE_PREFIX . 'divisions';

		$the_id    = $item['division_id'];
		$slug_test = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE division_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, array ( 'division_id' => $item['division_id'] ) );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error(
					'error_division_update',
					esc_html__( 'There was an error updating the division. Please check your data and try again.', 'sports-bench' ),
					[
						'status' => 500,
					]
				);
			}
		} else {
			return new WP_Error(
				'error_division_update',
				esc_html__( 'This division does not exist. Try adding the division first.', 'sports-bench' ),
				[
					'status' => 500,
				]
			);
		}
	}

	/**
	 * Deletes a division through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to delete from the division table.
	 * @return array|WP_Error      The array of information for the division or an error.
	 */
	public function sports_bench_rest_delete_division( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$the_id     = $item['division_id'];
		$slug_test  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE division_id = %d", $the_id ) );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete( $table_name, array ( 'division_id' => $the_id ), array ( '%d' ) );
			if ( false === $result ) {
				return new WP_Error(
					'error_division_delete',
					esc_html__( 'There was an error deleting the division. Please check your data and try again.', 'sports-bench' ),
					[
						'status' => 500,
					]
				);
			} else {
				return true;
			}
		} else {
			return new WP_Error(
				'error_division_update',
				esc_html__( 'This division does not exist.', 'sports-bench' ),
				[
					'status' => 500,
				]
			);
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results for divisions.
	 *
	 * @since 2.0.0
	 *
	 * @param array $params      The parameters to search for.
	 * @return string            JSON array of the SQL results
	 */
	public function sports_bench_rest_get_divisions( $params ) {
		$response = '';

		if ( ( ( isset( $params['division_id'] ) ) && null !== $params['division_id'] ) || ( ( isset( $params['division_name'] ) ) && null !== $params['division_name'] ) || ( ( isset( $params['division_conference'] ) ) && null !== $params['division_conference'] ) || ( ( isset( $params['division_conference_id'] ) ) && null !== $params['division_conference_id'] ) || ( ( isset( $params['division_color'] ) ) && null !== $params['division_color'] ) ) {

			$and = false;
			$search = '';
			if ( isset( $params['division_id'] ) && null !== $params['division_id'] ) {
				$search .= 'division_id in (' . $params['division_id'] . ')';
				$and     = true;
			} if ( isset( $params['division_name'] ) && null !== $params['division_name'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'division_name in ( "' . $params['division_name'] . '" )';
				$and     = true;
			} if ( isset( $params['division_conference'] ) && null !== $params['division_conference'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'division_conference in ( "' . $params['division_conference'] . '" )';
				$and     = true;
			} if ( isset( $params['division_conference_id'] ) && null !== $params['division_conference_id'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'division_conference_id in ( "' . $params['division_conference_id'] . '" )';
				$and     = true;
			} if ( isset( $params['division_color'] ) && null !== $params['division_color'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'division_color in ( "' . $params['division_color'] . '" )';
				$and = true;
			}

			global $wpdb;
			$table          = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr       = "SELECT * FROM $table WHERE $search;";
			$divisions      = $wpdb->get_results( $querystr );
			$divisions_list = [];

			foreach ( $divisions as $division ) {
				$division_info = [
					'division_id'               => $division->division_id,
					'division_name'             => $division->division_name,
					'division_conference'       => $division->division_conference,
					'division_conference_id'    => $division->division_conference_id,
					'division_color'            => $division->division_color,
				];
				array_push( $divisions_list, $division_info );
			}
			$response = $divisions_list;

		} else {

			global $wpdb;
			$table          = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr       = "SELECT * FROM $table;";
			$divisions      = $wpdb->get_results( $querystr );
			$divisions_list = [];

			foreach ( $divisions as $division ) {
				$division_info = [
					'division_id'               => $division->division_id,
					'division_name'             => $division->division_name,
					'division_conference'       => $division->division_conference,
					'division_conference_id'    => $division->division_conference_id,
					'division_color'            => $division->division_color,
				];
				array_push( $divisions_list, $division_info );
			}
			$response = $divisions_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a division.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The division to get.
	 * @return array                Information for a division.
	 */
	public function sports_bench_rest_get_division( $division_id ) {
		global $wpdb;
		$table          = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$querystr       = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $division_id );
		$divisions      = Database::get_results( $querystr );
		$divisions_list = [];
		foreach ( $divisions as $division ) {
			$divisions_list = [
				'division_id'               => $division->division_id,
				'division_name'             => $division->division_name,
				'division_conference'       => $division->division_conference,
				'division_conference_id'    => $division->division_conference_id,
				'division_color'            => $division->division_color,
			];
		}

		return $divisions_list;
	}

}
