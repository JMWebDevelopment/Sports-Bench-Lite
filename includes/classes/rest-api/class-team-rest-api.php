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
use Sports_Bench\Classes\Base\Team;

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run the team REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Team_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'teams';
		register_rest_route(
			$namespace,
			'/' . $base,
			[
				[
					'methods'             => WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items'],
					'permission_callback' => [ $this, 'get_items_permissions_check'],
					'args'                => $this->get_collection_params(),
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
						'context'          => [
							'default'      => 'view',
							'required'     => true,
						],
						'params' => [
							'required' => false,
							'team_id'  => [
								'description'        => 'The id(s) for the team(s) in the search.',
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
							'default'      => false,
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
				'permission_callback' => [ $this, 'get_items_permissions_check' ],
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
		$items  = $this->get_teams( $params );
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
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_item( $request ) {
		$params = $request->get_params();
		$item   = $this->get_team( $params['id'] );
		$data   = $this->prepare_item_for_response( $item, $request );

		if ( 1 == 1 ) {
			return new WP_REST_Response( $data, 200 );
		}else{
			return new WP_Error( 'code', __( 'message', 'sports-bench' ) );
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

		$data = $this->add_team( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', __( 'message', 'sports-bench' ), ['status' => 500 ] );

	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_team( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', __( 'message', 'sports-bench' ), ['status' => 500 ] );

	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->delete_team( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', __( 'message', 'sports-bench' ), ['status' => 500 ] );
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
	 * @param WP_REST_Request $request       Request object.
	 * @return WP_Error|object               The prepared item.
	 */
	protected function prepare_item_for_database( $request ) {

		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';

		if ( isset( $request['team_id'] ) ) {
			$team_id = wp_filter_nohtml_kses( sanitize_text_field( $request['team_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$team_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$team_id = '';
		}

		if ( isset( $request['team_name'] ) ) {
			$team_name = wp_filter_nohtml_kses( sanitize_text_field( $request['team_name'] ) );
		} else {
			$team_name = '';
		}

		if ( isset( $request['team_location'] ) ) {
			$team_location = wp_filter_nohtml_kses( sanitize_text_field( $request['team_location'] ) );
		} else {
			$team_location = '';
		}

		if ( isset( $request['team_nickname'] ) ) {
			$team_nickname = wp_filter_nohtml_kses( sanitize_text_field( $request['team_nickname'] ) );
		} else {
			$team_nickname = '';
		}

		if ( isset( $request['team_abbreviation'] ) ) {
			$team_abbreviation = wp_filter_nohtml_kses( sanitize_text_field( $request['team_abbreviation'] ) );
		} else {
			$team_abbreviation = '';
		}

		if ( isset( $request['team_active'] ) ) {
			$team_active = wp_filter_nohtml_kses( sanitize_text_field( $request['team_active'] ) );
		} else {
			$team_active = '';
		}

		if ( isset( $request['team_city'] ) ) {
			$team_city = wp_filter_nohtml_kses( sanitize_text_field( $request['team_city'] ) );
		} else {
			$team_city = '';
		}

		if ( isset( $request['team_state'] ) ) {
			$team_state = wp_filter_nohtml_kses( sanitize_text_field( $request['team_state'] ) );
		} else {
			$team_state = '';
		}

		if ( isset( $request['team_stadium'] ) ) {
			$team_stadium = wp_filter_nohtml_kses( sanitize_text_field( $request['team_stadium'] ) );
		} else {
			$team_stadium = '';
		}

		if ( isset( $request['team_location_line_one'] ) ) {
			$team_location_line_one = wp_filter_nohtml_kses( sanitize_text_field( $request['team_location_line_one'] ) );
		} else {
			$team_location_line_one = '';
		}

		if ( isset( $request['team_location_line_two'] ) ) {
			$team_location_line_two = wp_filter_nohtml_kses( sanitize_text_field( $request['team_location_line_two'] ) );
		} else {
			$team_location_line_two = '';
		}

		if ( isset( $request['team_location_country'] ) ) {
			$team_location_country = wp_filter_nohtml_kses( sanitize_text_field( $request['team_location_country'] ) );
		} else {
			$team_location_country = '';
		}

		if ( isset( $request['team_location_zip_code'] ) ) {
			$team_location_zip_code = wp_filter_nohtml_kses( sanitize_text_field( $request['team_location_zip_code'] ) );
		} else {
			$team_location_zip_code = '';
		}

		if ( isset( $request['team_stadium_capacity'] ) ) {
			$team_stadium_capacity = intval( $request['team_stadium_capacity'] );
		} else {
			$team_stadium_capacity = '';
		}

		if ( isset( $request['team_head_coach'] ) ) {
			$team_head_coach = wp_filter_nohtml_kses( sanitize_text_field( $request['team_head_coach'] ) );
		} else {
			$team_head_coach = '';
		}

		if ( isset( $request['team_division'] ) ) {
			$team_division = intval( $request['team_division'] );
		} else {
			$team_division = '';
		}

		if ( isset( $request['team_primary_color'] ) ) {
			$team_primary_color = wp_filter_nohtml_kses( sanitize_text_field( $request['team_primary_color'] ) );
		} else {
			$team_primary_color = '';
		}

		if ( isset( $request['team_secondary_color'] ) ) {
			$team_secondary_color = wp_filter_nohtml_kses( sanitize_text_field( $request['team_secondary_color'] ) );
		} else {
			$team_secondary_color = '';
		}

		if ( isset( $request['team_logo'] ) ) {
			$team_logo = wp_filter_nohtml_kses( sanitize_text_field( $request['team_logo'] ) );
		} else {
			$team_logo = '';
		}

		if ( isset( $request['team_photo'] ) ) {
			$team_photo = wp_filter_nohtml_kses( sanitize_text_field( $request['team_photo'] ) );
		} else {
			$team_photo = '';
		}

		if ( isset( $request['team_slug'] ) ) {
			$team_slug = wp_filter_nohtml_kses( sanitize_text_field( $request['team_slug'] ) );
		} else {
			if ( isset( $request['team_name'] ) ) {
				$slug                 = strtolower( $request['team_name'] );
				$request['team_slug'] = preg_replace( "/[\s_]/", '-', $slug );
				$slug                 = '"' . $request['team_slug'] . '"';
				$slug_test            = Databse::get_results( "SELECT * FROM $table_name WHERE team_slug = $slug" );
				$i = 1;
				while ( $slug_test !== [] && $request['team_id'] !== $slug_test[0]->team_id ) {
					$i++;
					$slug      = '"' . $request['team_slug'] . '-' . $i . '"';
					$slug_test = Databse::get_results( "SELECT * FROM $table_name WHERE team_slug = $slug" );
					if ( $slug_test ==  [] ) {
						$request['team_slug'] = $request['team_slug'] . '-' . $i;
						break;
					}
				}
				$team_slug = $request['team_slug'];
			} else {
				$team_slug = '';
			}
		}

		$item = array(
			'team_id'                   => $team_id,
			'team_name'                 => $team_name,
			'team_location'             => $team_location,
			'team_nickname'             => $team_nickname,
			'team_abbreviation'         => $team_abbreviation,
			'team_active'               => $team_active,
			'team_city'                 => $team_city,
			'team_state'                => $team_state,
			'team_stadium'              => $team_stadium,
			'team_location_line_one'    => $team_location_line_one,
			'team_location_line_two'    => $team_location_line_two,
			'team_location_country'     => $team_location_country,
			'team_location_zip_code'    => $team_location_zip_code,
			'team_stadium_capacity'     => $team_stadium_capacity,
			'team_head_coach'           => $team_head_coach,
			'team_division'             => $team_division,
			'team_primary_color'        => $team_primary_color,
			'team_secondary_color'      => $team_secondary_color,
			'team_logo'                 => $team_logo,
			'team_photo'                => $team_photo,
			'team_slug'                 => $team_slug,
		);

		return $item;
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @since 2.0
	 *
	 * @param array           $item         WordPress representation of the item.
	 * @param WP_REST_Request $request      Request object.
	 * @return mixed
	 */
	public function prepare_item_for_response( $item, $request ) {

		$schema = $this->get_item_schema();
		$data   = array();
		$data   = $item;
		$team   = new Team( (int) $item['team_id'] );

		$data['team_link'] = $team->get_permalink();
		$data['team_link'] = str_replace( '&#038;', '&', $data['team_link'] );

		return $data;
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'team_id' => array(
				'description'        => 'The id(s) for the team(s) in the search.',
				'type'               => 'integer',
				'default'            => null,
				'sanitize_callback'  => 'absint',
			),
			'team_name' => array(
				'description'        => 'The name(s) the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_location' => array(
				'description'        => 'The location(s) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_nickname' => array(
				'description'        => 'The nickname(s) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_abbreviation' => array(
				'description'        => 'The abbreviation(s) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_city' => array(
				'description'        => 'The team_city for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_state' => array(
				'description'        => 'The state(s) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_head_coach' => array(
				'description'        => 'The head coach(es) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_division' => array(
				'description'        => 'The id(s) division(s) for the team(s) in the search',
				'type'               => 'integer',
				'default'            => null,
				'sanitize_callback'  => 'absint',
			),
			'team_slug' => array(
				'description'        => 'The slug(s) for the team(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_active' => array(
				'description'        => 'Whether or not the team(s) are active',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
		);
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
		$schema = array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => 'entry',
			'type'       => 'object',
			'properties' => array(
				'team_id' => array(
					'description' => __( 'The id for the team.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
			),
		);
		return $schema;
	}

	public function add_team( $item ) {

		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$team_name  = $item['team_name'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE team_name LIKE $team_name" );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_team_insert', __( 'There was an error creating the team. Please check your data and try again.', 'sports-bench' ), array( 'status' => 500 ) );
			}
		} else {
			return new WP_Error( 'error_team_insert', __( 'This team has already been created in the database. Maybe try updating the team.', 'sports-bench' ), array( 'status' => 500 ) );
		}

	}

	public function update_team( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';

		$team_id = $item['team_id'];
		$slug_test = Database::get_results( "SELECT * FROM $table_name WHERE team_id = $team_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, ['team_id' => $item['team_id'] ] );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_team_update', __( 'There was an error updating the team. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			}
		} else {
			return new WP_Error( 'error_team_update', __( 'This team does not exist. Try adding the team first.', 'sports-bench' ), array ( 'status' => 500 ) );
		}
	}

	public function delete_team( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$team_id    = $item['team_id'];

		$slug_test = Database::get_results( "SELECT * FROM $table_name WHERE team_id = $team_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete( $table_name, ['team_id' => $team_id ], ['%d'] );
			if ( false === $result ) {
				return new WP_Error( 'error_team_delete', __( 'There was an error deleting the team. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_team_update', __( 'This team does not exist.', 'sports-bench' ), array ( 'status' => 500 ) );
		}

	}

	/**
	 * Takes the REST URL and returns an array of the results
	 *
	 * @param array $params
	 *
	 * @return array, array of the SQL results
	 *
	 * @since 1.1
	 */
	function get_teams( $params ) {
		$response = '';

		if ( ( isset( $params['team_id'] ) && $params['team_id'] != null ) || ( isset( $params['team_name'] ) && $params['team_name'] != null ) || ( isset( $params['team_location'] ) && $params['team_location'] != null ) || ( isset( $params['team_nickname'] ) && $params['team_nickname'] != null ) || ( isset( $params['team_abbreviation'] ) && $params['team_abbreviation'] != null ) || ( isset( $params['team_active'] ) && $params['team_active'] != null ) || ( isset( $params['team_city'] ) && $params['team_city'] != null ) || ( isset( $params['team_state'] ) && $params['team_state'] != null ) || ( isset( $params['team_head_coach'] ) && $params['team_head_coach'] != null ) || ( isset( $params['team_division'] ) && $params['team_division'] != null ) || ( isset( $params['team_slug'] ) && $params['team_slug'] != null ) ) {

			$and    = false;
			$search = '';
			if ( isset( $params['team_id'] ) && null !== $params['team_id'] ) {
				$search .= 'team_id in (' . $params['team_id'] . ')';
				$and = true;
			} if ( isset( $params['team_name'] ) && $params['team_name'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_name LIKE "%' . $params['team_name'] . '%"';
				$and = true;
			} if ( isset( $params['team_location'] ) && $params['team_location'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_location in ( "' . $params['team_location'] . '" )';
				$and = true;
			} if ( isset( $params['team_nickname'] ) && $params['team_nickname'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_nickname in ( "' . $params['team_nickname'] . '" )';
				$and = true;
			} if ( isset( $params['team_abbreviation'] ) && $params['team_abbreviation'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				}  else {
					$prefix = '';
				}
				$search .= $prefix . 'team_abbreviation in ( "' . $params['team_abbreviation'] . '" )';
				$and = true;
			} if ( isset( $params['team_active'] ) && $params['team_active'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_active LIKE "' . $params['team_active'] . '"';
				$and = true;
			} if ( isset( $params['team_city'] ) && $params['team_city'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_city in ( "' . $params['team_city'] . '" )';
				$and = true;
			} if ( isset( $params['team_state'] ) && $params['team_state'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_state in ( "' . $params['team_state'] . '" )';
				$and = true;
			} if ( isset( $params['team_division'] ) && $params['team_division'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_division in ( "' . $params['team_division'] . '" )';
				$and = true;
			} if ( isset( $params['team_slug'] ) && $params['team_slug'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_slug in ( "' . $params['team_slug'] . '" )';
			}

			global $wpdb;
			$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$querystr  = "SELECT * FROM $table WHERE $search;";
			$teams     = Database::get_results( $querystr );
			$team_list = [];

			foreach ( $teams as $team ) {
				$team        = new Team( (int) $team->team_id );
				$return_team = [
					'team_id'                => $team->get_team_id(),
					'team_name'              => $team->get_team_name(),
					'team_location'          => $team->get_team_location(),
					'team_nickname'          => $team->get_team_nickname(),
					'team_abbreviation'      => $team->get_team_abbreviation(),
					'team_active'            => $team->get_team_status(),
					'team_location_line_one' => $team->get_team_location_line_one(),
					'team_location_line_two' => $team->get_team_location_line_two(),
					'team_city'              => $team->get_team_city(),
					'team_state'             => $team->get_team_state(),
					'team_location_country'  => $team->get_team_location_country(),
					'team_location_zip_code' => $team->get_team_location_zip_code(),
					'team_stadium'           => $team->get_team_stadium(),
					'team_stadium_capacity'  => $team->get_team_stadium_capacity(),
					'team_head_coach'        => $team->get_team_head_coach(),
					'team_logo'              => $team->get_team_logo_url(),
					'team_photo'             => $team->get_team_photo_url(),
					'team_division'          => $team->get_team_division(),
					'team_primary_color'     => $team->get_team_primary_color(),
					'team_secondary_color'   => $team->get_team_secondary_color(),
					'team_slug'              => $team->get_team_slug(),
				];

				array_push( $team_list, $return_team );
			}
			$response = $team_list;

		} else {

			$teams     = $this->get_all_teams();
			$team_list = [];

			foreach ( $teams as $team ) {
				$the_team  = $team;
				$team_info = [
					'team_id'                => $the_team->get_team_id(),
					'team_name'              => $the_team->get_team_name(),
					'team_location'          => $the_team->get_team_location(),
					'team_nickname'          => $the_team->get_team_nickname(),
					'team_abbreviation'      => $the_team->get_team_abbreviation(),
					'team_active'            => $the_team->get_team_status(),
					'team_location_line_one' => $the_team->get_team_location_line_one(),
					'team_location_line_two' => $the_team->get_team_location_line_two(),
					'team_city'              => $the_team->get_team_city(),
					'team_state'             => $the_team->get_team_state(),
					'team_location_country'  => $the_team->get_team_location_country(),
					'team_location_zip_code' => $the_team->get_team_location_zip_code(),
					'team_stadium'           => $the_team->get_team_stadium(),
					'team_stadium_capacity'  => $the_team->get_team_stadium_capacity(),
					'team_head_coach'        => $the_team->get_team_head_coach(),
					'team_logo'              => $the_team->get_team_logo_url(),
					'team_photo'             => $the_team->get_team_photo_url(),
					'team_division'          => $the_team->get_team_division(),
					'team_primary_color'     => $the_team->get_team_primary_color(),
					'team_secondary_color'   => $the_team->get_team_secondary_color(),
					'team_slug'              => $the_team->get_team_slug(),
				];
				array_push( $team_list, $team_info );
			}
			$response = $team_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a team
	 *
	 * @param int $team_id
	 *
	 * @return array, information for a team
	 *
	 * @since 1.4
	 */
	function get_team( $team_id ) {
		$the_team  = new Team( (int) $team_id );
		$team_info = [
			'team_id'                => $the_team->get_team_id(),
			'team_name'              => $the_team->get_team_name(),
			'team_location'          => $the_team->get_team_location(),
			'team_nickname'          => $the_team->get_team_nickname(),
			'team_abbreviation'      => $the_team->get_team_abbreviation(),
			'team_active'            => $the_team->get_team_status(),
			'team_location_line_one' => $the_team->get_team_location_line_one(),
			'team_location_line_two' => $the_team->get_team_location_line_two(),
			'team_city'              => $the_team->get_team_city(),
			'team_state'             => $the_team->get_team_state(),
			'team_location_country'  => $the_team->get_team_location_country(),
			'team_location_zip_code' => $the_team->get_team_location_zip_code(),
			'team_stadium'           => $the_team->get_team_stadium(),
			'team_stadium_capacity'  => $the_team->get_team_stadium_capacity(),
			'team_head_coach'        => $the_team->get_team_head_coach(),
			'team_logo'              => $the_team->get_team_logo_url(),
			'team_photo'             => $the_team->get_team_photo_url(),
			'team_division'          => $the_team->get_team_division(),
			'team_primary_color'     => $the_team->get_team_primary_color(),
			'team_secondary_color'   => $the_team->get_team_secondary_color(),
			'team_slug'              => $the_team->get_team_slug(),
		];

		return $team_info;
	}

	public function get_all_teams() {
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$querystr   = "SELECT team_id FROM $table";
		$teams      = Database::get_results( $querystr );
		$teams_list = [];

		if ( $teams ) {
			foreach ( $teams as $team ) {
				$teams_list[] = new Team( (int) $team->team_id );
			}
		}

		return $teams_list;
	}

}
