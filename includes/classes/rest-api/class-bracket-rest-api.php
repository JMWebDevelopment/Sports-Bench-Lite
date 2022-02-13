<?php
/**
 * Holds all of the bracket REST API functions.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
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
use Sports_Bench\Classes\Base\Bracket;

/**
 * This class defines all code necessary to run the bracket REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Bracket_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'brackets';
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
								'description'        => 'The id(s) for the bracket(s) in the search.',
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
				'methods'  => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_public_item_schema' ),
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
		$items  = $this->get_brackets( $params ); //do a query, call another class, etc
		$data   = [];
		foreach ( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[]   = $this->prepare_response_for_collection( $itemdata );
		}

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Get one item from the collection
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		//get parameters from request
		$params = $request->get_params();
		$item   = $this->get_bracket( $params['id'] );//do a query, call another class, etc
		$data   = $this->prepare_item_for_response( $item, $request );

		//return a response or error based on some conditional
		if ( 1 === 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return new WP_Error( 'code', esc_html__( 'message', 'sports-bench' ) );
		}
	}

	/**
	 * Create one item from the collection
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function create_item( $request ) {

		$item = $this->prepare_item_for_database( $request );

		$data = $this->add_bracket( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			echo 'not created';
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Update one item from the collection
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_bracket( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Delete one item from the collection
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->delete_bracket( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'message', 'sports-bench'), [ 'status' => 500 ] );
	}

	/**
	 * Check if a given request has access to get items
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
	 * Check if a given request has access to get a specific item
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
	 * Check if a given request has access to create items
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
	 * Check if a given request has access to update a specific item
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
	 * Check if a given request has access to delete a specific item
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
	 * Prepare the item for create or update operation
	 *
	 * @since 2.0.0
	 *
	 * @param WP_REST_Request $request       Request object
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {

		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_brackets';

		if ( isset( $request['bracket_id'] ) ) {
			$bracket_id = wp_filter_nohtml_kses( sanitize_text_field( $request['bracket_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$bracket_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$bracket_id = '';
		}

		if ( isset( $request['num_teams'] ) ) {
			$num_teams = wp_filter_nohtml_kses( sanitize_text_field( $request['num_teams'] ) );
		} else {
			$num_teams = '';
		}

		if ( isset( $request['bracket_format'] ) ) {
			$bracket_format = wp_filter_nohtml_kses( sanitize_text_field( $request['bracket_format'] ) );
		} else {
			$bracket_format = '';
		}

		if ( isset( $request['bracket_title'] ) ) {
			$bracket_title = wp_filter_nohtml_kses( sanitize_text_field( $request['bracket_title'] ) );
		} else {
			$bracket_title = '';
		}

		if ( isset( $request['bracket_season'] ) ) {
			$bracket_season = wp_filter_nohtml_kses( sanitize_text_field( $request['bracket_season'] ) );
		} else {
			$bracket_season = '';
		}

		$item = [
			'bracket_id'     => $bracket_id,
			'num_teams'      => $num_teams,
			'bracket_format' => $bracket_format,
			'bracket_title'  => $bracket_title,
			'bracket_season' => $bracket_season,
		];

		return $item;
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @since 2.0.0
	 *
	 * @param mixed           $item          WordPress representation of the item.
	 * @param WP_REST_Request $request       Request object.
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
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return [
			'bracket_id' => [
				'description'        => 'The id(s) for the bracket(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			],
			'num_teams' => [
				'description'        => 'The number of teams in the bracket(s) in the search',
				'type'               => 'integer',
				'default'            => 0,
				'sanitize_callback'  => 'absint',
			],
			'bracket_format' => [
				'description'        => 'The format(s) for the bracket(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'bracket_title' => [
				'description'        => 'The title(s) for the bracket(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
			'bracket_season' => [
				'description'        => 'The season(s) for the bracket(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			],
		];
	}

	/**
	 * Get the Entry schema, conforming to JSON Schema.
	 *
	 * @since  2.0.0
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = [
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'entry',
			'type'       => 'object',
			'properties' => [
				'bracket_id' => [
					'description' => esc_html__( 'The id for the bracket.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				],
			],
		];
		return $schema;
	}

	/**
	 * Adds a bracket through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to add to the brackets table.
	 * @return array|WP_Error      The array of information for the bracket or an error.
	 */
	public function add_bracket( $item ) {

		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_brackets';
		$the_id     = $item['bracket_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE bracket_id = $the_id" );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_series_insert', esc_html__( 'There was an error creating the bracket. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_series_insert', esc_html__( 'This bracket has already been created in the database. Maybe try bracket the series.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	/**
	 * Updates a bracket through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to update a row in the brackets table.
	 * @return array|WP_Error      The array of information for the bracket or an error.
	 */
	public function update_bracket( $item ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_brackets';
		$the_id     = $item['bracket_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE bracket_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, [ 'bracket_id' => $item['bracket_id'] ] );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_series_update', esc_html__( 'There was an error updating the bracket. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_series_update', esc_html__( 'This bracket does not exist. Try adding the bracket first.', 'sports-bench' ), [ 'status' => 500 ] );
		}
	}

	/**
	 * Deletes a bracket through the REST API.
	 *
	 * @since 2.0.0
	 *
	 * @param array $item          The information to delete from the brackets table.
	 * @return array|WP_Error      The array of information for the bracket or an error.
	 */
	public function delete_bracket( $item ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'playoff_brackets';
		$the_id     = $item['bracket_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE bracket_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete(
				$table_name,
				[ 'bracket_id' => $the_id ],
				[ '%d' ]
			);
			if ( false === $result ) {
				return new WP_Error( 'error_brackets_delete', esc_html__( 'There was an error deleting the bracket. Please check your data and try again.', 'sports-bench' ), [ 'status' => 500 ] );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_brackets_update', esc_html__( 'This bracket does not exist.', 'sports-bench' ), [ 'status' => 500 ] );
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results for brackets.
	 *
	 * @since 2.0.0
	 *
	 * @param array $params      The parameters to search for.
	 * @return string            JSON array of the SQL results
	 */
	public function get_brackets( $params ) {
		$response = '';

		if ( ( isset( $params['bracket_id'] ) && null !== $params['bracket_id'] ) || ( isset( $params['num_teams'] ) && null !== $params['num_teams'] ) || ( isset( $params['bracket_format'] ) && null !== $params['bracket_format'] ) || ( isset( $params['bracket_title'] ) && null !== $params['bracket_title'] ) || ( isset( $params['bracket_season'] ) && null !== $params['bracket_season'] ) ) {

			$and    = false;
			$search = '';
			if ( isset( $params['bracket_id'] ) && null !== $params['bracket_id'] ) {
				$search .= 'bracket_id in (' . $params['bracket_id'] . ')';
				$and     = true;
			} if ( isset( $params['num_teams'] ) && null !== $params['num_teams'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'num_teams in (' . $params['num_teams'] . ')';
				$and     = true;
			} if ( isset( $params['bracket_format'] ) && null !== $params['bracket_format'] ) {
				if ( null === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'bracket_format in ( "' . $params['bracket_format'] . '" )';
				$and     = true;
			} if ( isset( $params['bracket_title'] ) && null !== $params['bracket_title'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'bracket_title LIKE "%' . $params['bracket_title'] . '%"';
				$and     = true;
			} if ( isset( $params['bracket_season'] ) && null !== $params['bracket_season'] ) {
				if ( true === $and ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'bracket_season in ( "' . $params['bracket_season'] . '" )';
			}

			global $wpdb;
			$table        = SB_TABLE_PREFIX . 'playoff_brackets';
			$querystr     = "SELECT * FROM $table WHERE $search;";
			$brackets     = Database::get_results( $querystr );
			$bracket_list = [];

			foreach ( $brackets as $bracket ) {
				$bracket        = new Bracket( (int) $bracket->bracket_id );
				$return_bracket = [
					'bracket_id'     => $bracket->get_bracket_id(),
					'num_teams'      => $bracket->get_num_teams(),
					'bracket_format' => $bracket->get_bracket_format(),
					'bracket_title'  => $bracket->get_bracket_title(),
					'bracket_season' => $bracket->get_bracket_season(),
				];

				array_push( $bracket_list, $return_bracket);
			}
			$response = $bracket_list;

		} else {

			global $wpdb;
			$table        = SB_TABLE_PREFIX . 'playoff_brackets';
			$querystr     = "SELECT * FROM $table;";
			$brackets     = Database::get_results( $querystr );
			$bracket_list = [];

			foreach ( $brackets as $bracket ) {
				$bracket      = new Bracket( (int) $bracket->bracket_id );
				$bracket_info = [
					'bracket_id'     => $bracket->get_bracket_id(),
					'num_teams'      => $bracket->get_num_teams(),
					'bracket_format' => $bracket->get_bracket_format(),
					'bracket_title'  => $bracket->get_bracket_title(),
					'bracket_season' => $bracket->get_bracket_season(),
				];
				array_push( $bracket_list, $bracket_info );
			}
			$response = $bracket_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param int $bracket_id      The bracket to get.
	 * @return array               Information for a bracket.
	 */
	public function get_bracket( $bracket_id ) {
		$bracket      = new Bracket( (int) $bracket_id );
		$bracket_info = [
			'bracket_id'     => $bracket->get_bracket_id(),
			'num_teams'      => $bracket->get_num_teams(),
			'bracket_format' => $bracket->get_bracket_format(),
			'bracket_title'  => $bracket->get_bracket_title(),
			'bracket_season' => $bracket->get_bracket_season(),
		];

		return $bracket_info;
	}

}
