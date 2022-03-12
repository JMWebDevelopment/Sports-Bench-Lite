<?php
/**
 * Holds all of the player REST API functions.
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

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run the player REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Player_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base      = 'players';
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
					'methods'         => WP_REST_Server::READABLE,
					'callback'        => [ $this, 'get_item' ],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
					'args'            => [
						'context'          => [
							'default'      => 'view',
							'required'     => true,
						],
						'params' => [
							'player_id' => [
								'description'        => 'The id(s) for the player(s) in the search.',
								'type'               => 'integer',
								'default'            => 1,
								'sanitize_callback'  => 'absint',
							],
						],
						$this->get_collection_params(),
					],
				],
				[
					'methods'         => WP_REST_Server::EDITABLE,
					'callback'        => [ $this, 'update_item' ],
					'permission_callback' => [ $this, 'update_item_permissions_check' ],
					'args'            => $this->get_endpoint_args_for_item_schema( false ),
				],
				[
					'methods'  => WP_REST_Server::DELETABLE,
					'callback' => [ $this, 'delete_item' ],
					'permission_callback' => [ $this, 'delete_item_permissions_check' ],
					'args'     => [
						'force'    => [
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
				'callback'        => [ $this, 'get_public_item_schema' ],
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
		$items  = $this->get_players( $params ); //do a query, call another class, etc
		$data   = array();
		foreach ( $items as $item ) {
			$itemdata = $this->prepare_item_for_response( $item, $request );
			$data[] = $this->prepare_response_for_collection( $itemdata );
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
		$item = $this->get_player( $params[ 'id' ] );
		$data = $this->prepare_item_for_response( $item, $request );

		if ( 1 == 1 ) {
			return new WP_REST_Response( $data, 200 );
		} else {
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

		$data = $this->add_player( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', __( 'message', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Update one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function update_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$data = $this->update_player( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', __( 'message', 'sports-bench'), [ 'status' => 500 ] );

	}

	/**
	 * Delete one item from the collection
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function delete_item( $request ) {
		$item = $this->prepare_item_for_database( $request );

		$deleted = $this->delete_player( $item );
		if ( true === $deleted ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', __( 'message', 'sports-bench'), [ 'status' => 500 ] );
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
	 * Prepare the item for create || update operation
	 *
	 * @param WP_REST_Request $request Request object
	 * @return WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_players';

		if ( isset( $request[ 'player_id' ] ) ) {
			$player_id = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_id' ] ) );
		} elseif ( isset( $request[ 'id' ] ) ) {
			$player_id = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'id' ] ) );
		} else {
			$player_id = '';
		}

		if ( isset( $request[ 'player_first_name' ] ) ) {
			$player_first_name = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_first_name' ] ) );
		} else {
			$player_first_name = '';
		}

		if ( isset( $request[ 'player_last_name' ] ) ) {
			$player_last_name = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_last_name' ] ) );
		} else {
			$player_last_name = '';
		}

		if ( isset( $request[ 'player_photo' ] ) ) {
			$player_photo = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_photo' ] ) );
		} else {
			$player_photo = '';
		}

		if ( isset( $request[ 'player_position' ] ) ) {
			$player_position = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_position' ] ) );
		} else {
			$player_position = '';
		}

		if ( isset( $request[ 'player_home_city' ] ) ) {
			$player_home_city = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_home_city' ] ) );
		} else {
			$player_home_city = '';
		}

		if ( isset( $request[ 'player_home_state' ] ) ) {
			$player_home_state = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_home_state' ] ) );
		} else {
			$player_home_state = '';
		}

		if ( isset( $request[ 'player_birth_day' ] ) ) {
			$player_birth_day = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_birth_day' ] ) );
		} else {
			$player_birth_day = '';
		}

		if ( isset( $request[ 'team_id' ] ) ) {
			$team_id = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'team_id' ] ) );
		} else {
			$team_id = '';
		}

		if ( isset( $request[ 'player_weight' ] ) ) {
			$player_weight = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_weight' ] ) );
		} else {
			$player_weight = '';
		}

		if ( isset( $request[ 'player_height' ] ) ) {
			$player_height = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_height' ] ) );
		} else {
			$player_height = '';
		}

		if ( isset( $request[ 'player_slug' ] ) ) {
			$player_slug = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_slug' ] ) );
		} else {
			$player_slug = '';
		}

		if ( isset( $request[ 'player_slug' ] ) ) {
			$player_slug = wp_filter_nohtml_kses( sanitize_text_field( $request[ 'player_slug' ] ) );
		} else {
			if ( isset( $request[ 'player_first_name' ] ) ) {
				$slug = strtolower( $request[ 'player_first_name' ]. ' ' . $request[ 'player_last_name' ] );
				$request[ 'player_slug' ] = $string = preg_replace( "/[\s_]/", "-", $slug );
				$slug = '"' . $request[ 'player_slug' ] . '"';
				$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE team_slug = $slug" );
				$i = 1;
				while ( $slug_test !== [] and $slug_test[ 0 ]->team_id !== $request[ 'player_id' ] ) {
					$i++;
					$slug = '"' . $request[ 'player_slug' ] . '-' . $i . '"';
					$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE team_slug = $slug" );
					if ( $slug_test ==  [] ) {
						$request[ 'player_slug' ] = $request[ 'player_slug' ] . '-' . $i;
						break;
					}
				}
				$player_slug = $request[ 'player_slug' ];
			} else {
				$player_slug = '';
			}
		}

		$item = array(
			'player_id'         => $player_id,
			'player_first_name' => $player_first_name,
			'player_last_name'  => $player_last_name,
			'player_photo'      => $player_photo,
			'player_position'   => $player_position,
			'player_home_city'  => $player_home_city,
			'player_home_state' => $player_home_state,
			'player_birth_day'  => $player_birth_day,
			'team_id'           => $team_id,
			'player_weight'     => $player_weight,
			'player_height'     => $player_height,
			'player_slug'       => $player_slug,
		);

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
		$data   = array();
		$data   = $item;
		$player = new Player( (int) $item['player_id'] );

		$data['player_link'] = $player->get_permalink();
		$data['player_link'] = str_replace( '&#038;', '&', $data['player_link'] );

		return $data;
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'player_id' => array(
				'description'        => 'The id(s) for the player(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			),
			'player_first_name' => array(
				'description'        => 'The first name(s) the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_last_name' => array(
				'description'        => 'The last name(s) for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_photo' => array(
				'description'        => 'The photo url(s) for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_position' => array(
				'description'        => 'The position(s) for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_home_city' => array(
				'description'        => 'The city for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_home_state' => array(
				'description'        => 'The state(s) for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_birth_day' => array(
				'description'        => 'The birthday for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'team_id' => array(
				'description'        => 'The id(s) of the team(s) for the player(s) in the search',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			),
			'player_weight' => array(
				'description'        => 'The weight for the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_height' => array(
				'description'        => 'The height of the player(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'player_slug' => array(
				'description'        => 'The slug(s) for the player(s) in the search',
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
				'player_id' => array(
					'description' => __( 'The id for the player.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
			),
		);
		return $schema;
	}

	public function add_player( $item ) {

		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$the_id     = $item[ 'player_id' ];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE player_id = $the_id" );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_player_insert', __( 'There was an error creating the player. Please check your data and try again.', 'sports-bench' ), array( 'status' => 500 ) );
			}
		} else {
			return new WP_Error( 'error_player_insert', __( 'This player has already been created in the database. Maybe try updating the player.', 'sports-bench' ), array( 'status' => 500 ) );
		}
	}

	public function update_player( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';

		$the_id    = $item[ 'player_id' ];
		$slug_test = Database::get_results( "SELECT * FROM $table_name WHERE player_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, array ( 'player_id' => $item[ 'player_id' ] ) );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_player_update', __( 'There was an error updating the player. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			}
		} else {
			return new WP_Error( 'error_player_update', __( 'This player does not exist. Try adding the player first.', 'sports-bench' ), array ( 'status' => 500 ) );
		}
	}

	public function delete_player( $item ) {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$the_id     = $item['player_id'];
		$slug_test  = Database::get_results( "SELECT * FROM $table_name WHERE player_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete( $table_name, [ 'player_id' => $the_id ], [ '%d' ] );
			if ( false === $result ) {
				return new WP_Error( 'error_player_delete', __( 'There was an error deleting the player. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_player_update', __( 'This player does not exist.', 'sports-bench' ), array ( 'status' => 500 ) );
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results
	 *
	 * @params WP_REST_Request $request
	 *
	 * @return string, JSON array of the SQL results
	 *
	 * @since 1.1
	 */
	public function get_players( $params ) {
		$response = '';

		if ( ( ( isset( $params[ 'player_id' ] ) ) && $params[ 'player_id' ] != null ) || ( ( isset( $params[ 'player_first_name' ] ) ) && $params[ 'player_first_name' ] != null ) || ( ( isset( $params[ 'player_last_name' ] ) ) && $params[ 'player_last_name' ] != null ) || ( ( isset( $params[ 'player_position' ] ) ) && $params[ 'player_position' ] != null ) || ( ( isset( $params[ 'player_home_city' ] ) ) && $params[ 'player_home_city' ] != null ) || ( ( isset( $params[ 'player_home_state' ] ) ) && $params[ 'player_home_state' ] != null ) || ( ( isset( $params[ 'player_birth_day' ] ) ) && $params[ 'player_birth_day' ] != null ) || ( ( isset( $params[ 'team_id' ] ) ) && $params[ 'team_id' ] != null ) || ( ( isset( $params[ 'player_weight' ] ) ) && $params[ 'player_weight' ] != null ) || ( ( isset( $params[ 'player_height' ] ) ) && $params[ 'player_height' ] != null ) || ( ( isset( $params[ 'player_slug' ] ) ) && $params[ 'player_slug' ] != null ) ) {

			$and = false;
			$search = '';
			if ( isset( $params[ 'player_id' ]) && $params[ 'player_id' ] != null ) {
				$search .= 'player_id in (' . $params[ 'player_id' ] . ')';
				$and = true;
			} if ( isset( $params[ 'player_first_name' ]) && $params[ 'player_first_name' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_first_name in ( "' . $params[ 'player_first_name' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_last_name' ]) && $params[ 'player_last_name' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_last_name in ( "' . $params[ 'player_last_name' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_position' ]) && $params[ 'player_position' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_position in ( "' . $params[ 'player_position' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_home_city' ]) && $params[ 'player_home_city' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_home_city in ( "' . $params[ 'player_home_city' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_home_state' ]) && $params[ 'player_home_state' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_home_state in ( "' . $params[ 'player_home_state' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_birth_day' ]) && $params[ 'player_date_of_birth' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_birth_day in ( "' . $params[ 'player_birth_day' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'team_id' ]) && $params[ 'team_id' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'team_id in (' . $params[ 'team_id' ] . ')';
				$and     = true;
			} if ( isset( $params[ 'player_weight' ]) && $params[ 'player_weight' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_weight in (' . $params[ 'player_weight' ] . ')';
				$and     = true;
			} if ( isset( $params[ 'player_height' ]) && $params[ 'player_height' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_height in ( "' . $params[ 'player_height' ] . '" )';
				$and = true;
			} if ( isset( $params[ 'player_slug' ]) && $params[ 'player_slug' ] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'player_slug in ( "' . $params[ 'player_slug' ] . '" )';
				$and = true;
			}

			global $wpdb;
			$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$querystr     = "SELECT * FROM $table WHERE $search;";
			$players      = Database::get_results( $querystr );
			$players_list = [];

			foreach ( $players as $player ) {
				$the_player  = new Player( (int) $player->player_id );
				$player_info = array (
					'player_id'         => $the_player->get_player_id(),
					'player_first_name' => $the_player->get_player_first_name(),
					'player_last_name'  => $the_player->get_player_last_name(),
					'player_photo'      => $the_player->get_player_photo_url(),
					'player_position'   => $the_player->get_player_position(),
					'player_home_city'  => $the_player->get_player_home_city(),
					'player_home_state' => $the_player->get_player_home_state(),
					'player_birth_day'  => $the_player->get_player_birth_day(),
					'team_id'           => $the_player->get_team_id(),
					'player_weight'     => $the_player->get_player_weight(),
					'player_height'     => $the_player->get_player_height(),
					'player_slug'       => $the_player->get_player_slug(),
					'player_bio'        => $the_player->get_player_bio(),
				);
				array_push( $players_list, $player_info );
			}
			$response = $players_list;

		} else {

			global $wpdb;
			$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$querystr     = "SELECT * FROM $table;";
			$players      = Database::get_results( $querystr );
			$players_list = [];

			foreach ( $players as $player ) {
				$the_player  = new Player( (int) $player->player_id );
				$player_info = array (
					'player_id'         => $the_player->get_player_id(),
					'player_first_name' => $the_player->get_player_first_name(),
					'player_last_name'  => $the_player->get_player_last_name(),
					'player_photo'      => $the_player->get_player_photo_url(),
					'player_position'   => $the_player->get_player_position(),
					'player_home_city'  => $the_player->get_player_home_city(),
					'player_home_state' => $the_player->get_player_home_state(),
					'player_birth_day'  => $the_player->get_player_birth_day(),
					'team_id'           => $the_player->get_team_id(),
					'player_weight'     => $the_player->get_player_weight(),
					'player_height'     => $the_player->get_player_height(),
					'player_slug'       => $the_player->get_player_slug(),
					'player_bio'        => $the_player->get_player_bio(),
				);
				array_push( $players_list, $player_info );
			}
			$response = $players_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a team
	 *
	 * @param int $player_id
	 *
	 * @return array, information for a team
	 *
	 * @since 1.4
	 */
	public function get_player( $player_id ) {
		$the_player  = new Player( (int) $player_id );
		$player_info = [
			'player_id'         => $the_player->get_player_id(),
			'player_first_name' => $the_player->get_player_first_name(),
			'player_last_name'  => $the_player->get_player_last_name(),
			'player_photo'      => $the_player->get_player_photo_url(),
			'player_position'   => $the_player->get_player_position(),
			'player_home_city'  => $the_player->get_player_home_city(),
			'player_home_state' => $the_player->get_player_home_state(),
			'player_birth_day'  => $the_player->get_player_birth_day(),
			'team_id'           => $the_player->get_team_id(),
			'player_weight'     => $the_player->get_player_weight(),
			'player_height'     => $the_player->get_player_height(),
			'player_slug'       => $the_player->get_player_slug(),
			'player_bio'        => $the_player->get_player_bio(),
		];

		return $player_info;
	}

}
