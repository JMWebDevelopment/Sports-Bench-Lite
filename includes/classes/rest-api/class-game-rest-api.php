<?php
/**
 * Holds all of the game REST API functions.
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
 * This class defines all code necessary to run the game REST APIs for Sports Bench.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/classes/rest-api
 */
class Game_REST_Controller extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 *
	 * @since 2.0.0
	 */
	public function register_routes() {
		$namespace = 'sportsbench';
		$base = 'games';
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
		$items = $this->get_games( $params ); //do a query, call another class, etc
		$data = array();
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
		$item   = $this->get_game( $params['id'] );//do a query, call another class, etc
		$data   = $this->prepare_item_for_response( $item, $request );

		//return a response or error based on some conditional
		if ( 1 === 1 ) {
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

		$data = $this->add_game( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 201 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-create', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );

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

		$data = $this->update_game( $item );
		if ( is_array( $data ) ) {
			return new WP_REST_Response( $data, 200 );
		} else {
			return $data;
		}

		return new WP_Error( 'cant-update', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );

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

		$deleted = $this->delete_game( $item );
		if (  $deleted == true  ) {
			return new WP_REST_Response( true, 200 );
		} else {
			return $deleted;
		}

		return new WP_Error( 'cant-delete', esc_html__( 'message', 'sports-bench'), ['status' => 500 ] );
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
	 * @return WP_Error|object
	 */
	protected function prepare_item_for_database( $request ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_games';

		if ( isset( $request['game_id'] ) ) {
			$game_id = wp_filter_nohtml_kses( sanitize_text_field( $request['game_id'] ) );
		} elseif ( isset( $request['id'] ) ) {
			$game_id = wp_filter_nohtml_kses( sanitize_text_field( $request['id'] ) );
		} else {
			$game_id = '';
		}

		if ( isset( $request['game_week'] ) ) {
			$game_week = wp_filter_nohtml_kses( sanitize_text_field( $request['game_week'] ) );
		} else {
			$game_week = '';
		}

		if ( isset( $request['game_day'] ) ) {
			$game_day = wp_filter_nohtml_kses( sanitize_text_field( $request['game_day'] ) );
		} else {
			$game_day = '';
		}

		if ( isset( $request['game_season'] ) ) {
			$game_season = wp_filter_nohtml_kses( sanitize_text_field( $request['game_season'] ) );
		} else {
			$game_season = '';
		}

		if ( isset( $request['game_home_id'] ) ) {
			$game_home_id = wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_id'] ) );
		} else {
			$game_home_id = '';
		}

		if ( isset( $request['game_away_id'] ) ) {
			$game_away_id = wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_id'] ) );
		} else {
			$game_away_id = '';
		}

		if ( isset( $request['game_home_final'] ) ) {
			$game_home_final = wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_final'] ) );
		} else {
			$game_home_final = '';
		}

		if ( isset( $request['game_away_final'] ) ) {
			$game_away_final = wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_final'] ) );
		} else {
			$game_away_final = '';
		}

		if ( isset( $request['game_attendance'] ) ) {
			$game_attendance = wp_filter_nohtml_kses( sanitize_text_field( $request['game_attendance'] ) );
		} else {
			$game_attendance = '';
		}

		if ( isset( $request['game_status'] ) ) {
			$game_status = wp_filter_nohtml_kses( sanitize_text_field( $request['game_status'] ) );
		} else {
			$game_status = '';
		}

		if ( isset( $request['game_current_period'] ) ) {
			$game_current_period = wp_filter_nohtml_kses( sanitize_text_field( $request['game_current_period'] ) );
		} else {
			$game_current_period = '';
		}

		if ( isset( $request['game_current_time'] ) ) {
			$game_current_time = wp_filter_nohtml_kses( sanitize_text_field( $request['game_current_time'] ) );
		} else {
			$game_current_time = '';
		}

		if ( isset( $request['game_current_home_score'] ) ) {
			$game_current_home_score = wp_filter_nohtml_kses( sanitize_text_field( $request['game_current_home_score'] ) );
		} else {
			$game_current_home_score = '';
		}

		if ( isset( $request['game_current_away_score'] ) ) {
			$game_current_away_score = wp_filter_nohtml_kses( sanitize_text_field( $request['game_current_away_score'] ) );
		} else {
			$game_current_away_score = '';
		}

		if ( isset( $request['game_neutral_site'] ) ) {
			$game_neutral_site = wp_filter_nohtml_kses( sanitize_text_field( $request['game_neutral_site'] ) );
		} else {
			$game_neutral_site = '';
		}

		if ( isset( $request['game_location_stadium'] ) ) {
			$game_location_stadium = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_stadium'] ) );
		} else {
			$game_location_stadium = '';
		}

		if ( isset( $request['game_location_line_one'] ) ) {
			$game_location_line_one = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_line_one'] ) );
		} else {
			$game_location_line_one = '';
		}

		if ( isset( $request['game_location_line_two'] ) ) {
			$game_location_line_two = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_line_two'] ) );
		} else {
			$game_location_line_two = '';
		}

		if ( isset( $request['game_location_city'] ) ) {
			$game_location_city = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_city'] ) );
		} else {
			$game_location_city = '';
		}

		if ( isset( $request['game_location_state'] ) ) {
			$game_location_state = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_state'] ) );
		} else {
			$game_location_state = '';
		}

		if ( isset( $request['game_location_country'] ) ) {
			$game_location_country = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_country'] ) );
		} else {
			$game_location_country = '';
		}

		if ( isset( $request['game_location_zip_code'] ) ) {
			$game_location_zip_code = wp_filter_nohtml_kses( sanitize_text_field( $request['game_location_zip_code'] ) );
		} else {
			$game_location_zip_code = '';
		}

		if ( get_option( 'sports-bench-sport' ) == 'baseball' ) {
			$item_array = array(
				'game_home_errors'          => intval( $request['game_home_errors'] ),
				'game_home_lob'             => intval( $request['game_home_lob'] ),
				'game_away_hits'            => intval( $request['game_away_hits'] ),
				'game_away_errors'          => intval( $request['game_away_errors'] ),
				'game_away_lob'             => intval( $request['game_away_lob'] ),
				'game_home_doubles'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_doubles'] ) ),
				'game_home_triples'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_triples'] ) ),
				'game_home_homeruns'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_homeruns'] ) ),
				'game_away_doubles'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_doubles'] ) ),
				'game_away_triples'         => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_triples'] ) ),
				'game_away_homeruns'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_homeruns'] ) )
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'basketball' ) {
			$item_array = array(
				'game_home_first_quarter'   => intval( $request['game_home_first_quarter'] ),
				'game_home_second_quarter'  => intval( $request['game_home_second_quarter'] ),
				'game_home_third_quarter'   => intval( $request['game_home_third_quarter'] ),
				'game_home_fourth_quarter'  => intval( $request['game_home_fourth_quarter'] ),
				'game_home_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_overtime'] ) ),
				'game_away_first_quarter'   => intval( $request['game_away_first_quarter'] ),
				'game_away_second_quarter'  => intval( $request['game_away_second_quarter'] ),
				'game_away_third_quarter'   => intval( $request['game_away_third_quarter'] ),
				'game_away_fourth_quarter'  => intval( $request['game_away_fourth_quarter'] ),
				'game_away_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_overtime'] ) ),
				'game_home_fgm'             => intval( $request['game_home_fgm'] ),
				'game_home_fga'             => intval( $request['game_home_fga'] ),
				'game_home_3pm'             => intval( $request['game_home_3pm'] ),
				'game_home_3pa'             => intval( $request['game_home_3pa'] ),
				'game_home_ftm'             => intval( $request['game_home_ftm'] ),
				'game_home_fta'             => intval( $request['game_home_fta'] ),
				'game_home_off_rebound'     => intval( $request['game_home_off_rebound'] ),
				'game_home_def_rebound'     => intval( $request['game_home_def_rebound'] ),
				'game_home_assists'         => intval( $request['game_home_assists'] ),
				'game_home_steals'          => intval( $request['game_home_steals'] ),
				'game_home_blocks'          => intval( $request['game_home_blocks'] ),
				'game_home_pip'             => intval( $request['game_home_pip'] ),
				'game_home_to'              => intval( $request['game_home_to'] ),
				'game_home_pot'             => intval( $request['game_home_pot'] ),
				'game_home_fast_break'      => intval( $request['game_home_fast_break'] ),
				'game_home_fouls'           => intval( $request['game_home_fouls'] ),
				'game_away_fgm'             => intval( $request['game_away_fgm'] ),
				'game_away_fga'             => intval( $request['game_away_fga'] ),
				'game_away_3pm'             => intval( $request['game_away_3pm'] ),
				'game_away_3pa'             => intval( $request['game_away_3pa'] ),
				'game_away_ftm'             => intval( $request['game_away_ftm'] ),
				'game_away_fta'             => intval( $request['game_away_fta'] ),
				'game_away_off_rebound'     => intval( $request['game_away_off_rebound'] ),
				'game_away_def_rebound'     => intval( $request['game_away_def_rebound'] ),
				'game_away_assists'         => intval( $request['game_away_assists'] ),
				'game_away_steals'          => intval( $request['game_away_steals'] ),
				'game_away_blocks'          => intval( $request['game_away_blocks'] ),
				'game_away_pip'             => intval( $request['game_away_pip'] ),
				'game_away_to'              => intval( $request['game_away_to'] ),
				'game_away_pot'             => intval( $request['game_away_pot'] ),
				'game_away_fast_break'      => intval( $request['game_away_fast_break'] ),
				'game_away_fouls'           => intval( $request['game_away_fouls'] ),
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'football' ) {
			$item_array = array(
				'game_home_first_quarter'       => intval( $request['game_home_first_quarter'] ),
				'game_home_second_quarter'      => intval( $request['game_home_second_quarter'] ),
				'game_home_third_quarter'       => intval( $request['game_home_third_quarter'] ),
				'game_home_fourth_quarter'      => intval( $request['game_home_fourth_quarter'] ),
				'game_home_overtime'            => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_overtime'] ) ),
				'game_away_first_quarter'       => intval( $request['game_away_first_quarter'] ),
				'game_away_second_quarter'      => intval( $request['game_away_second_quarter'] ),
				'game_away_third_quarter'       => intval( $request['game_away_third_quarter'] ),
				'game_away_fourth_quarter'      => intval( $request['game_away_fourth_quarter'] ),
				'game_away_overtime'            => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_overtime'] ) ),
				'game_home_total'               => intval( $request['game_home_total'] ),
				'game_home_pass'                => intval( $request['game_home_pass'] ),
				'game_home_rush'                => intval( $request['game_home_rush'] ),
				'game_home_to'                  => intval( $request['game_home_to'] ),
				'game_home_ints'                => intval( $request['game_home_ints'] ),
				'game_home_fumbles'             => intval( $request['game_home_fumbles'] ),
				'game_home_fumbles_lost'        => intval( $request['game_home_fumbles_lost'] ),
				'game_home_possession'          => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_possession'] ) ),
				'game_home_kick_returns'        => intval( $request['game_home_kick_returns'] ),
				'game_home_kick_return_yards'   => intval( $request['game_home_kick_return_yards'] ),
				'game_home_penalties'           => intval( $request['game_home_penalties'] ),
				'game_home_penalty_yards'       => intval( $request['game_home_penalty_yards'] ),
				'game_home_first_downs'         => intval( $request['game_home_first_downs'] ),
				'game_away_total'               => intval( $request['game_away_total'] ),
				'game_away_pass'                => intval( $request['game_away_pass'] ),
				'game_away_rush'                => intval( $request['game_away_rush'] ),
				'game_away_to'                  => intval( $request['game_away_to'] ),
				'game_away_ints'                => intval( $request['game_away_fumbles'] ),
				'game_away_fumbles'             => intval( $request['game_away_fumbles'] ),
				'game_away_fumbles_lost'        => intval( $request['game_away_fumbles_lost'] ),
				'game_away_possession'          => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_possession'] ) ),
				'game_away_kick_returns'        => intval( $request['game_away_kick_returns'] ),
				'game_away_kick_return_yards'   => intval( $request['game_away_kick_return_yards'] ),
				'game_away_penalties'           => intval( $request['game_away_penalties'] ),
				'game_away_penalty_yards'       => intval( $request['game_away_penalty_yards'] ),
				'game_away_first_downs'         => intval( $request['game_away_first_downs'] ),
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'hockey' ) {
			$item_array = array(
				'game_home_first_period'    => intval( $request['game_home_first_period'] ),
				'game_home_second_period'   => intval( $request['game_home_second_period'] ),
				'game_home_third_period'    => intval( $request['game_home_third_period'] ),
				'game_home_shootout'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_shootout'] ) ),
				'game_home_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_overtime'] ) ),
				'game_away_first_period'    => intval( $request['game_away_first_period'] ),
				'game_away_second_period'   => intval( $request['game_away_second_period'] ),
				'game_away_third_period'    => intval( $request['game_away_third_period'] ),
				'game_away_shootout'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_shootout'] ) ),
				'game_away_overtime'        => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_overtime'] ) ),
				'game_home_first_sog'       => intval( $request['game_home_first_sog'] ),
				'game_home_second_sog'      => intval( $request['game_home_second_sog'] ),
				'game_home_third_sog'       => intval( $request['game_home_third_sog'] ),
				'game_home_overtime_sog'    => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_overtime_sog'] ) ),
				'game_home_power_plays'     => intval( $request['game_home_power_plays'] ),
				'game_home_pp_goals'        => intval( $request['game_home_pp_goals'] ),
				'game_home_pen_minutes'     => intval( $request['game_home_pen_minutes'] ),
				'game_away_first_sog'       => intval( $request['game_away_first_sog'] ),
				'game_away_second_sog'      => intval( $request['game_away_second_sog'] ),
				'game_away_third_sog'       => intval( $request['game_away_third_sog'] ),
				'game_away_overtime_sog'    => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_overtime_sog'] ) ),
				'game_away_power_plays'     => intval( $request['game_away_power_plays'] ),
				'game_away_pp_goals'        => intval( $request['game_away_pp_goals'] ),
				'game_away_pen_minutes'     => intval( $request['game_away_pen_minutes'] ),
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'rugby' ) {
			$item_array = array(
				'game_home_first_half'              => intval( $request['game_home_first_half'] ),
				'game_home_second_half'             => intval( $request['game_home_second_half'] ),
				'game_home_extratime'               => intval( $request['game_home_extratime'] ),
				'game_home_shootout'                => intval( $request['game_home_shootout'] ),
				'game_home_tries'                   => intval( $request['game_home_tries'] ),
				'game_home_conversions'             => intval( $request['game_home_conversions'] ),
				'game_home_penalty_goals'           => intval( $request['game_home_penalty_goals'] ),
				'game_home_kick_percentage'         => intval( $request['game_home_kick_percentage'] ),
				'game_home_meters_runs'             => intval( $request['game_home_meters_runs'] ),
				'game_home_meters_hand'             => intval( $request['game_home_meters_hand'] ),
				'game_home_meters_pass'             => intval( $request['game_home_meters_pass'] ),
				'game_home_possession'              => intval( $request['game_home_possession'] ),
				'game_home_clean_breaks'            => intval( $request['game_home_clean_breaks'] ),
				'game_home_defenders_beaten'        => intval( $request['game_home_defenders_beaten'] ),
				'game_home_offload'                 => intval( $request['game_home_offload'] ),
				'game_home_rucks'                   => intval( $request['game_home_rucks'] ),
				'game_home_mauls'                   => intval( $request['game_home_mauls'] ),
				'game_home_turnovers_conceeded'     => intval( $request['game_home_turnovers_conceeded'] ),
				'game_home_scrums'                  => intval( $request['game_home_scrums'] ),
				'game_home_lineouts'                => intval( $request['game_home_lineouts'] ),
				'game_home_penalties_conceeded'     => intval( $request['game_home_penalties_conceeded'] ),
				'game_home_red_cards'               => intval( $request['game_home_red_cards'] ),
				'game_home_yellow_cards'            => intval( $request['game_home_yellow_cards'] ),
				'game_home_free_kicks_conceeded'    => intval( $request['game_home_free_kicks_conceeded'] ),
				'game_away_first_half'              => intval( $request['game_away_first_half'] ),
				'game_away_second_half'             => intval( $request['game_away_second_half'] ),
				'game_away_extratime'               => intval( $request['game_away_extratime'] ),
				'game_away_shootout'                => intval( $request['game_away_shootout'] ),
				'game_away_tries'                   => intval( $request['game_away_tries'] ),
				'game_away_conversions'             => intval( $request['game_away_conversions'] ),
				'game_away_penalty_goals'           => intval( $request['game_away_penalty_goals'] ),
				'game_away_kick_percentage'         => intval( $request['game_away_kick_percentage'] ),
				'game_away_meters_runs'             => intval( $request['game_away_meters_runs'] ),
				'game_away_meters_hand'             => intval( $request['game_away_meters_hand'] ),
				'game_away_meters_pass'             => intval( $request['game_away_meters_pass'] ),
				'game_away_possession'              => intval( $request['game_away_possession'] ),
				'game_away_clean_breaks'            => intval( $request['game_away_clean_breaks'] ),
				'game_away_defenders_beaten'        => intval( $request['game_away_defenders_beaten'] ),
				'game_away_offload'                 => intval( $request['game_away_offload'] ),
				'game_away_rucks'                   => intval( $request['game_away_rucks'] ),
				'game_away_mauls'                   => intval( $request['game_away_mauls'] ),
				'game_away_turnovers_conceeded'     => intval( $request['game_away_turnovers_conceeded'] ),
				'game_away_scrums'                  => intval( $request['game_away_scrums'] ),
				'game_away_lineouts'                => intval( $request['game_away_lineouts'] ),
				'game_away_penalties_conceeded'     => intval( $request['game_away_penalties_conceeded'] ),
				'game_away_red_cards'               => intval( $request['game_away_red_cards'] ),
				'game_away_yellow_cards'            => intval( $request['game_away_yellow_cards'] ),
				'game_away_free_kicks_conceeded'    => intval( $request['game_away_free_kicks_conceeded'] ),
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'soccer' ) {
			$item_array = array(
				'game_home_first_half'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_first_half'] ) ),
				'game_home_second_half'     => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_second_half'] ) ),
				'game_home_extratime'       => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_extratime'] ) ),
				'game_home_pks'             => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_pks'] ) ),
				'game_away_first_half'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_first_half'] ) ),
				'game_away_second_half'     => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_second_half'] ) ),
				'game_away_extratime'       => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_extratime'] ) ),
				'game_away_pks'             => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_pks'] ) ),
				'game_home_possession'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_possession'] ) ),
				'game_home_shots'           => intval( $request['game_home_shots'] ),
				'game_home_sog'             => intval( $request['game_home_sog'] ),
				'game_home_corners'         => intval( $request['game_home_corners'] ),
				'game_home_offsides'        => intval( $request['game_home_offsides'] ),
				'game_home_fouls'           => intval( $request['game_home_fouls'] ),
				'game_home_saves'           => intval( $request['game_home_saves'] ),
				'game_home_yellow'          => intval( $request['game_home_yellow'] ),
				'game_home_red'             => intval( $request['game_home_red'] ),
				'game_away_possession'      => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_possession'] ) ),
				'game_away_shots'           => intval( $request['game_away_shots'] ),
				'game_away_sog'             => intval( $request['game_away_sog'] ),
				'game_away_corners'         => intval( $request['game_away_corners'] ),
				'game_away_offsides'        => intval( $request['game_away_offsides'] ),
				'game_away_fouls'           => intval( $request['game_away_fouls'] ),
				'game_away_saves'           => intval( $request['game_away_saves'] ),
				'game_away_yellow'          => intval( $request['game_away_yellow'] ),
				'game_away_red'             => intval( $request['game_away_red'] )
			);
		} elseif ( get_option( 'sports-bench-sport' ) == 'volleyball' ) {
			$item_array = array(
				'game_home_first_set'           => intval( $request['game_home_first_set'] ),
				'game_home_second_set'          => intval( $request['game_home_second_set'] ),
				'game_home_third_set'           => intval( $request['game_home_third_set'] ),
				'game_home_fourth_set'          => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_fourth_set'] ) ),
				'game_home_fifth_set'           => wp_filter_nohtml_kses( sanitize_text_field( $request['game_home_fifth_set'] ) ),
				'game_away_first_set'           => intval( $request['game_away_first_set'] ),
				'game_away_second_set'          => intval( $request['game_away_second_set'] ),
				'game_away_third_set'           => intval( $request['game_away_third_set'] ),
				'game_away_fourth_set'          => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_fourth_set'] ) ),
				'game_away_fifth_set'           => wp_filter_nohtml_kses( sanitize_text_field( $request['game_away_fifth_set'] ) ),
				'game_home_kills'               => intval( $request['game_home_kills'] ),
				'game_home_blocks'              => intval( $request['game_home_blocks'] ),
				'game_home_aces'                => intval( $request['game_home_aces'] ),
				'game_home_assists'             => intval( $request['game_home_assists'] ),
				'game_home_digs'                => intval( $request['game_home_digs'] ),
				'game_home_attacks'             => intval( $request['game_home_attacks'] ),
				'game_home_hitting_errors'      => intval( $request['game_home_hitting_errors'] ),
				'game_away_kills'               => intval( $request['game_away_kills'] ),
				'game_away_blocks'              => intval( $request['game_away_blocks'] ),
				'game_away_aces'                => intval( $request['game_away_aces'] ),
				'game_away_assists'             => intval( $request['game_away_assists'] ),
				'game_away_digs'                => intval( $request['game_away_digs'] ),
				'game_away_attacks'             => intval( $request['game_away_attacks'] ),
				'game_away_hitting_errors'      => intval( $request['game_away_hitting_errors'] ),
			);
		}

		$item = array(
			'game_id'                   => $game_id,
			'game_week'                 => $game_week,
			'game_day'                  => $game_day,
			'game_season'               => $game_season,
			'game_home_id'              => $game_home_id,
			'game_away_id'              => $game_away_id,
			'game_home_final'           => $game_home_final,
			'game_away_final'           => $game_away_final,
			'game_attendance'           => $game_attendance,
			'game_status'               => $game_status,
			'game_current_period'       => $game_current_period,
			'game_current_time'         => $game_current_time,
			'game_current_home_score'   => $game_current_home_score,
			'game_current_away_score'   => $game_current_away_score,
			'game_neutral_site'         => $game_neutral_site,
			'game_location_stadium'     => $game_location_stadium,
			'game_location_line_one'    => $game_location_line_one,
			'game_location_line_two'    => $game_location_line_two,
			'game_location_city'        => $game_location_city,
			'game_location_state'       => $game_location_state,
			'game_location_country'     => $game_location_country,
			'game_location_zip_code'    => $game_location_zip_code,
		);

		array_merge( $item, $item_array );

		return $item;
	}

	/**
	 * Prepare the item for the REST response.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed           $item          WordPress representation of the item.
	 * @param WP_REST_Request $request       Request object.
	 * @return mixed
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
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'game_id' => array(
				'description'        => 'The id(s) for the game(s) in the search.',
				'type'               => 'integer',
				'default'            => 1,
				'sanitize_callback'  => 'absint',
			),
			'game_week' => array(
				'description'        => 'The week for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_day' => array(
				'description'        => 'The day for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_season' => array(
				'description'        => 'The season(s) for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_home_id' => array(
				'description'        => 'The home team id for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_away_id' => array(
				'description'        => 'The away team id for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_attendance' => array(
				'description'        => 'The attendance for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'game_status' => array(
				'description'        => 'The status for the game(s) in the search',
				'type'               => 'string',
				'default'            => '',
				'sanitize_callback'  => 'sanitize_text_field',
			),
			'seasons' => array(
			'description'        => 'Whether to get the list of seasons for the league',
			'type'               => 'boolean',
			'default'            => '',
			'sanitize_callback'  => 'sanitize_text_field',
		)
		);
	}

	/**
	 * Get the Entry schema, conforming to JSON Schema.
	 *
	 * @since 2.0.0
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
					'description' => esc_html__( 'The id for the player.', 'sports-bench' ),
					'type'        => 'integer',
					'readonly'    => true,
				),
			),
		);
		return $schema;
	}


	public function add_game( $item ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_games';
		$the_id = $item['game_id'];
		$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE game_id = $the_id" );

		if ( $slug_test == [] ) {
			$result = $wpdb->insert( $table_name, $item );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_insert', esc_html__( 'There was an error creating the game. Please check your data and try again.', 'sports-bench' ), ['status' => 500 ] );
			}
		} else {
			return new WP_Error( 'error_game_insert', esc_html__( 'This game has already been created in the database. Maybe try game the player.', 'sports-bench' ), ['status' => 500 ] );
		}

	}

	function update_game( $item ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_games';

		$the_id = $item['game_id'];
		$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE game_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->update( $table_name, $item, array ( 'game_id' => $item['game_id'] ) );
			if ( $result ) {
				return $item;
			} else {
				return new WP_Error( 'error_game_update', esc_html__( 'There was an error updating the game. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game does not exist. Try adding the game first.', 'sports-bench' ), array ( 'status' => 500 ) );
		}
	}

	function elete_game( $item ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sb_games';
		$the_id = $item['game_id'];
		$slug_test = $wpdb->get_results( "SELECT * FROM $table_name WHERE game_id = $the_id" );

		if ( is_array( $slug_test ) ) {
			$result = $wpdb->delete( $table_name,
				array ( 'game_id' => $the_id ), array ( '%d' ) );
			if ( $result == false ) {
				return new WP_Error( 'error_game_delete', esc_html__( 'There was an error deleting the game. Please check your data and try again.', 'sports-bench' ), array ( 'status' => 500 ) );
			} else {
				return true;
			}
		} else {
			return new WP_Error( 'error_game_update', esc_html__( 'This game does not exist.', 'sports-bench' ), array ( 'status' => 500 ) );
		}

	}

	/**
	 * Takes the REST URL and returns a JSON array of the results
	 *
	 * @params WP_REST_Request $params
	 *
	 * @return string, JSON array of the SQL results
	 *
	 * @since 1.1
	 */
	function get_games( $params ) {
		$response = '';

		if ( isset( $params['seasons'] ) && $params['seasons'] == true ) {
			if ( isset( $params['team_id'] ) && $params['team_id'] !== null ) {
				global $wpdb;
				$team_id        = $params['team_id'];
				$games_list     = [];
				$games_list[''] = esc_html__( 'Select a Season', 'sports-bench' );
				$table_name     = $wpdb->prefix . 'sb_games';
				$quer           = "SELECT DISTINCT game_season FROM $table_name WHERE game_home_id = $team_id OR game_away_id = $team_id;";
				$seasons_list   = $wpdb->get_results( $quer );
				foreach ( $seasons_list as $season ) {
					$games_list[ $season->game_season ] = $season->game_season;
				}
				$response = $games_list;
			} else {
				global $wpdb;
				$games_list     = [];
				$games_list[''] = esc_html__( 'Select a Season', 'sports-bench' );
				$table_name     = $wpdb->prefix . 'sb_games';
				$quer           = "SELECT DISTINCT game_season FROM $table_name;";
				$seasons_list   = $wpdb->get_results( $quer );
				foreach ( $seasons_list as $season ) {
					$games_list[ $season->game_season ] = $season->game_season;
				}
				$response = $games_list;
			}
		} elseif (  ( isset( $params['game_one_id'] ) && $params['game_one_id'] != null ) and ( isset( $params['game_two_id'] ) &&  $params['game_two_id'] != null ) and ( isset( $params['game_season'] ) && $params['game_season'] != null ) ) {
			$team_one_id = $params['game_one_id'];
			$team_two_id = $params['game_two_id'];
			$game_season = '"' . $params['game_season'] . '"';
			$search = "( game_home_id = $team_one_id AND game_away_id = $team_two_id ) OR ( game_home_id = $team_two_id AND game_away_id = $team_one_id ) AND game_season = $game_season;";

			global $wpdb;
			$table = $wpdb->prefix . 'sb_games';
			$querystr = "SELECT * FROM $table WHERE $search;";
			$games = $wpdb->get_results( $querystr );
			$games_list = [];

			foreach ( $games as $game ) {
				$the_game  = new Game( (int) $game->game_id );
				if ( get_option( 'sports-bench-sport' ) == 'baseball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_doubles'       => $game->game_home_doubles,
						'game_home_triples'       => $game->game_home_triples,
						'game_home_homeruns'      => $game->game_home_homeruns,
						'game_home_hits'          => $game->game_home_hits,
						'game_home_errors'        => $game->game_home_errors,
						'game_home_lob'           => $game->game_home_lob,
						'game_away_doubles'       => $game->game_away_doubles,
						'game_away_triples'       => $game->game_away_triples,
						'game_away_homeruns'      => $game->game_away_homeruns,
						'game_away_hits'          => $game->game_away_hits,
						'game_away_errors'        => $game->game_away_errors,
						'game_away_lob'           => $game->game_away_lob
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'basketball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'   => $game->game_home_first_quarter,
						'game_home_second_quarter'  => $game->game_home_second_quarter,
						'game_home_third_quarter'   => $game->game_home_third_quarter,
						'game_home_fourth_quarter'  => $game->game_home_fourth_quarter,
						'game_home_overtime'        => $game->game_home_overtime,
						'game_home_fgm'             => $game->game_home_fgm,
						'game_home_fga'             => $game->game_home_fga,
						'game_home_3pm'             => $game->game_home_3pm,
						'game_home_3pa'             => $game->game_home_3pa,
						'game_home_ftm'             => $game->game_home_ftm,
						'game_home_fta'             => $game->game_home_fta,
						'game_home_off_rebound'     => $game->game_home_off_rebound,
						'game_home_def_rebound'     => $game->game_home_def_rebound,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_steals'          => $game->game_home_steals,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_pip'             => $game->game_home_pip,
						'game_home_to'              => $game->game_home_to,
						'game_home_pot'             => $game->game_home_pot,
						'game_home_fast_break'      => $game->game_home_fast_break,
						'game_home_fouls'           => $game->game_home_fouls,
						'game_away_first_quarter'   => $game->game_away_first_quarter,
						'game_away_second_quarter'  => $game->game_away_second_quarter,
						'game_away_third_quarter'   => $game->game_away_third_quarter,
						'game_away_fourth_quarter'  => $game->game_away_fourth_quarter,
						'game_away_overtime'        => $game->game_away_overtime,
						'game_away_fgm'             => $game->game_away_fgm,
						'game_away_fga'             => $game->game_away_fga,
						'game_away_3pm'             => $game->game_away_3pm,
						'game_away_3pa'             => $game->game_away_3pa,
						'game_away_ftm'             => $game->game_away_ftm,
						'game_away_fta'             => $game->game_away_fta,
						'game_away_off_rebound'     => $game->game_away_off_rebound,
						'game_away_def_rebound'     => $game->game_away_def_rebound,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_steals'          => $game->game_away_steals,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_pip'             => $game->game_away_pip,
						'game_away_to'              => $game->game_away_to,
						'game_away_pot'             => $game->game_away_pot,
						'game_away_fast_break'      => $game->game_away_fast_break,
						'game_away_fouls'           => $game->game_away_fouls
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'football' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'       => $game->game_home_first_quarter,
						'game_home_second_quarter'      => $game->game_home_second_quarter,
						'game_home_third_quarter'       => $game->game_home_third_quarter,
						'game_home_fourth_quarter'      => $game->game_home_fourth_quarter,
						'game_home_overtime'            => $game->game_home_overtime,
						'game_home_total'               => $game->game_home_total,
						'game_home_pass'                => $game->game_home_pass,
						'game_home_rush'                => $game->game_home_rush,
						'game_home_to'                  => $game->game_home_to,
						'game_home_ints'                => $game->game_home_ints,
						'game_home_fumbles'             => $game->game_home_fumbles,
						'game_home_fumbles_lost'        => $game->game_home_fumbles_lost,
						'game_home_possession'          => $game->game_home_possession,
						'game_home_kick_returns'        => $game->game_home_kick_returns,
						'game_home_kick_return_yards'   => $game->game_home_kick_return_yards,
						'game_home_penalties'           => $game->game_home_penalties,
						'game_home_penalty_yards'       => $game->game_home_penalty_yards,
						'game_home_first_downs'         => $game->game_home_first_downs,
						'game_away_first_quarter'       => $game->game_away_first_quarter,
						'game_away_second_quarter'      => $game->game_away_second_quarter,
						'game_away_third_quarter'       => $game->game_away_third_quarter,
						'game_away_fourth_quarter'      => $game->game_away_fourth_quarter,
						'game_away_overtime'            => $game->game_away_overtime,
						'game_away_total'               => $game->game_away_total,
						'game_away_pass'                => $game->game_away_pass,
						'game_away_rush'                => $game->game_away_rush,
						'game_away_to'                  => $game->game_away_to,
						'game_away_ints'                => $game->game_away_ints,
						'game_away_fumbles'             => $game->game_away_fumbles,
						'game_away_fumbles_lost'        => $game->game_away_fumbles_lost,
						'game_away_possession'          => $game->game_away_possession,
						'game_away_kick_returns'        => $game->game_away_kick_returns,
						'game_away_kick_return_yards'   => $game->game_away_kick_return_yards,
						'game_away_penalties'           => $game->game_away_penalties,
						'game_away_penalty_yards'       => $game->game_away_penalty_yards,
						'game_away_first_downs'         => $game->game_away_first_downs
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'hockey' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_period'  => $game->game_home_first_period,
						'game_home_first_sog'     => $game->game_home_first_sog,
						'game_home_second_period' => $game->game_home_second_period,
						'game_home_second_sog'    => $game->game_home_second_sog,
						'game_home_third_period'  => $game->game_home_third_period,
						'game_home_third_sog'     => $game->game_home_third_sog,
						'game_home_overtime'      => $game->game_home_overtime,
						'game_home_overtime_sog'  => $game->game_home_overtime_sog,
						'game_home_shootout'      => $game->game_home_shootout,
						'game_home_power_plays'   => $game->game_home_power_plays,
						'game_home_pp_goals'      => $game->game_home_pp_goals,
						'game_home_pen_minutes'   => $game->game_home_pen_minutes,
						'game_away_first_period'  => $game->game_away_first_period,
						'game_away_first_sog'     => $game->game_away_first_sog,
						'game_away_second_period' => $game->game_away_second_period,
						'game_away_second_sog'    => $game->game_away_second_sog,
						'game_away_third_period'  => $game->game_away_third_period,
						'game_away_third_sog'     => $game->game_away_third_sog,
						'game_away_overtime'      => $game->game_away_overtime,
						'game_away_overtime_sog'  => $game->game_away_overtime_sog,
						'game_away_shootout'      => $game->game_away_shootout,
						'game_away_power_plays'   => $game->game_away_power_plays,
						'game_away_pp_goals'      => $game->game_away_pp_goals,
						'game_away_pen_minutes'   => $game->game_away_pen_minutes,
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'rugby' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'              => $game->game_home_first_half,
						'game_home_second_half'             => $game->game_home_second_half,
						'game_home_extratime'               => $game->game_home_extratime,
						'game_home_shootout'                => $game->game_home_shootout,
						'game_home_tries'                   => $game->game_home_tries,
						'game_home_conversions'             => $game->game_home_conversions,
						'game_home_penalty_goals'           => $game->game_home_penalty_goals,
						'game_home_kick_percentage'         => $game->game_home_kick_percentage,
						'game_home_meters_runs'             => $game->game_home_meters_runs,
						'game_home_meters_hand'             => $game->game_home_meters_hand,
						'game_home_meters_pass'             => $game->game_home_meters_pass,
						'game_home_possession'              => $game->game_home_possession,
						'game_home_clean_breaks'            => $game->game_home_clean_breaks,
						'game_home_defenders_beaten'        => $game->game_home_defenders_beaten,
						'game_home_offload'                 => $game->game_home_offload,
						'game_home_rucks'                   => $game->game_home_rucks,
						'game_home_mauls'                   => $game->game_home_mauls,
						'game_home_turnovers_conceeded'     => $game->game_home_turnovers_conceeded,
						'game_home_scrums'                  => $game->game_home_scrums,
						'game_home_lineouts'                => $game->game_home_lineouts,
						'game_home_penalties_conceeded'     => $game->game_home_penalties_conceeded,
						'game_home_red_cards'               => $game->game_home_red_cards,
						'game_home_yellow_cards'            => $game->game_home_yellow_cards,
						'game_home_free_kicks_conceeded'    => $game->game_home_free_kicks_conceeded,
						'game_away_first_half'              => $game->game_away_first_half,
						'game_away_second_half'             => $game->game_away_second_half,
						'game_away_extratime'               => $game->game_away_extratime,
						'game_away_shootout'                => $game->game_away_shootout,
						'game_away_tries'                   => $game->game_away_tries,
						'game_away_conversions'             => $game->game_away_conversions,
						'game_away_penalty_goals'           => $game->game_away_penalty_goals,
						'game_away_kick_percentage'         => $game->game_away_kick_percentage,
						'game_away_meters_runs'             => $game->game_away_meters_runs,
						'game_away_meters_hand'             => $game->game_away_meters_hand,
						'game_away_meters_pass'             => $game->game_away_meters_pass,
						'game_away_possession'              => $game->game_away_possession,
						'game_away_clean_breaks'            => $game->game_away_clean_breaks,
						'game_away_defenders_beaten'        => $game->game_away_defenders_beaten,
						'game_away_offload'                 => $game->game_away_offload,
						'game_away_rucks'                   => $game->game_away_rucks,
						'game_away_mauls'                   => $game->game_away_mauls,
						'game_away_turnovers_conceeded'     => $game->game_away_turnovers_conceeded,
						'game_away_scrums'                  => $game->game_away_scrums,
						'game_away_lineouts'                => $game->game_away_lineouts,
						'game_away_penalties_conceeded'     => $game->game_away_penalties_conceeded,
						'game_away_red_cards'               => $game->game_away_red_cards,
						'game_away_yellow_cards'            => $game->game_away_yellow_cards,
						'game_away_free_kicks_conceeded'    => $game->game_away_free_kicks_conceeded
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'soccer' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'    => $game->game_home_first_half,
						'game_home_second_half'   => $game->game_home_second_half,
						'game_home_extratime'     => $game->game_home_extratime,
						'game_home_pks'           => $game->game_home_pks,
						'game_home_possession'    => $game->game_home_possession,
						'game_home_shots'         => $game->game_home_shots,
						'game_home_sog'           => $game->game_home_sog,
						'game_home_corners'       => $game->game_home_corners,
						'game_home_offsides'      => $game->game_home_offsides,
						'game_home_fouls'         => $game->game_home_fouls,
						'game_home_saves'         => $game->game_home_saves,
						'game_home_yellow'        => $game->game_home_yellow,
						'game_home_red'           => $game->game_home_red,
						'game_away_first_half'    => $game->game_away_first_half,
						'game_away_second_half'   => $game->game_away_second_half,
						'game_away_extratime'     => $game->game_away_extratime,
						'game_away_pks'           => $game->game_away_pks,
						'game_away_possession'    => $game->game_away_possession,
						'game_away_shots'         => $game->game_away_shots,
						'game_away_sog'           => $game->game_away_sog,
						'game_away_corners'       => $game->game_away_corners,
						'game_away_offsides'      => $game->game_away_offsides,
						'game_away_fouls'         => $game->game_away_fouls,
						'game_away_saves'         => $game->game_away_saves,
						'game_away_yellow'        => $game->game_away_yellow,
						'game_away_red'           => $game->game_away_red
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'volleyball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_set'       => $game->game_home_first_set,
						'game_home_second_set'      => $game->game_home_second_set,
						'game_home_third_set'       => $game->game_home_third_set,
						'game_home_fourth_set'      => $game->game_home_fourth_set,
						'game_home_fifth_set'       => $game->game_home_fifth_set,
						'game_home_kills'           => $game->game_home_kills,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_aces'            => $game->game_home_aces,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_digs'            => $game->game_home_digs,
						'game_home_attacks'         => $game->game_home_attacks,
						'game_home_hitting_errors'  => $game->game_home_hitting_errors,
						'game_away_first_set'       => $game->game_away_first_set,
						'game_away_second_set'      => $game->game_away_second_set,
						'game_away_third_set'       => $game->game_away_third_set,
						'game_away_fourth_set'      => $game->game_away_fourth_set,
						'game_away_fifth_set'       => $game->game_away_fifth_set,
						'game_away_kills'           => $game->game_away_kills,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_aces'            => $game->game_away_aces,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_digs'            => $game->game_away_digs,
						'game_away_attacks'         => $game->game_away_attacks,
						'game_away_hitting_errors'  => $game->game_away_hitting_errors
					);
				}
				$away_team = new Team( (int)$the_game->get_game_away_id() );
				$home_team = new Team( (int)$the_game->get_game_home_id() );
				$gametime = date_create( $the_game->get_game_day() );
				$game_info['game_away_team'] = $away_team->get_team_name();
				$game_info['game_home_team'] = $home_team->get_team_name();
				$game_info['game_date'] = date_format( $gametime, 'F j, Y' );
				array_push( $games_list, $game_info );
			}
			$response = $games_list;
		} elseif ( ( isset( $params['game_id'] ) && $params['game_id'] != null ) or ( isset( $params['game_week'] ) && $params['game_week'] != null ) or ( isset( $params['game_season'] ) && $params['game_season'] != null ) or ( isset( $params['game_day'] ) && $params['game_day'] != null ) or ( isset( $params['game_home_id'] ) && $params['game_home_id'] != null ) or ( isset( $params['game_away_id'] ) && $params['game_away_id'] != null ) or ( isset( $params['game_attendance'] ) && $params['game_attendance'] != null ) or ( isset( $params['game_status'] ) && $params['game_status'] != null ) ) {
			$and = false;
			$search = '';
			if ( isset( $params['game_id'] ) && $params['game_id'] != null ) {
				$search .= 'game_id in (' . $params['game_id'] . ')';
				$and = true;
			} if ( isset( $params['game_week'] ) &&  $params['game_week'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				}  else {
					$prefix = '';
				}
				$search .= $prefix . 'game_week in (' . $params['game_week'] . ')';
				$and = true;
			} if ( isset( $params['game_season'] ) && $params['game_season'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_season in ( "' . $params['game_season'] . '" )';
				$and = true;
			} if ( isset( $params['game_day'] ) && $params['game_day'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$date = strtotime( $params['game_day'] );
				$date = '"' . date( 'Y-m-d', $date ) . '"';
				$search .= $prefix . 'DATE( game_day ) = ' . $date . '';
				$and = true;
			} if ( isset( $params['game_home_id'] ) && $params['game_home_id'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_home_id in (' . $params['game_home_id'] . ')';
				$and = true;
			} if ( isset( $params['game_away_id'] ) && $params['game_away_id'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_away_id in (' . $params['game_away_id'] . ')';
				$and = true;
			} if ( isset( $params['game_attendance'] ) && $params['game_attendance'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_attendance in (' . $params['game_attendance'] . ')';
				$and = true;
			} if ( isset( $params['game_status'] ) && $params['game_status'] != null ) {
				if ( $and == true ) {
					$prefix = ' AND ';
				} else {
					$prefix = '';
				}
				$search .= $prefix . 'game_status in ( "' . $params['game_status'] . '" )';
			}

			global $wpdb;
			$table = $wpdb->prefix . 'sb_games';
			$querystr = "SELECT * FROM $table WHERE $search;";
			$games = $wpdb->get_results( $querystr );
			$games_list = [];

			foreach ( $games as $game ) {
				$the_game  = new Game( (int) $game->game_id );
				if ( get_option( 'sports-bench-sport' ) == 'baseball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_doubles'       => $game->game_home_doubles,
						'game_home_triples'       => $game->game_home_triples,
						'game_home_homeruns'      => $game->game_home_homeruns,
						'game_home_hits'          => $game->game_home_hits,
						'game_home_errors'        => $game->game_home_errors,
						'game_home_lob'           => $game->game_home_lob,
						'game_away_doubles'       => $game->game_away_doubles,
						'game_away_triples'       => $game->game_away_triples,
						'game_away_homeruns'      => $game->game_away_homeruns,
						'game_away_hits'          => $game->game_away_hits,
						'game_away_errors'        => $game->game_away_errors,
						'game_away_lob'           => $game->game_away_lob
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'basketball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'   => $game->game_home_first_quarter,
						'game_home_second_quarter'  => $game->game_home_second_quarter,
						'game_home_third_quarter'   => $game->game_home_third_quarter,
						'game_home_fourth_quarter'  => $game->game_home_fourth_quarter,
						'game_home_overtime'        => $game->game_home_overtime,
						'game_home_fgm'             => $game->game_home_fgm,
						'game_home_fga'             => $game->game_home_fga,
						'game_home_3pm'             => $game->game_home_3pm,
						'game_home_3pa'             => $game->game_home_3pa,
						'game_home_ftm'             => $game->game_home_ftm,
						'game_home_fta'             => $game->game_home_fta,
						'game_home_off_rebound'     => $game->game_home_off_rebound,
						'game_home_def_rebound'     => $game->game_home_def_rebound,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_steals'          => $game->game_home_steals,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_pip'             => $game->game_home_pip,
						'game_home_to'              => $game->game_home_to,
						'game_home_pot'             => $game->game_home_pot,
						'game_home_fast_break'      => $game->game_home_fast_break,
						'game_home_fouls'           => $game->game_home_fouls,
						'game_away_first_quarter'   => $game->game_away_first_quarter,
						'game_away_second_quarter'  => $game->game_away_second_quarter,
						'game_away_third_quarter'   => $game->game_away_third_quarter,
						'game_away_fourth_quarter'  => $game->game_away_fourth_quarter,
						'game_away_overtime'        => $game->game_away_overtime,
						'game_away_fgm'             => $game->game_away_fgm,
						'game_away_fga'             => $game->game_away_fga,
						'game_away_3pm'             => $game->game_away_3pm,
						'game_away_3pa'             => $game->game_away_3pa,
						'game_away_ftm'             => $game->game_away_ftm,
						'game_away_fta'             => $game->game_away_fta,
						'game_away_off_rebound'     => $game->game_away_off_rebound,
						'game_away_def_rebound'     => $game->game_away_def_rebound,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_steals'          => $game->game_away_steals,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_pip'             => $game->game_away_pip,
						'game_away_to'              => $game->game_away_to,
						'game_away_pot'             => $game->game_away_pot,
						'game_away_fast_break'      => $game->game_away_fast_break,
						'game_away_fouls'           => $game->game_away_fouls
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'football' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'       => $game->game_home_first_quarter,
						'game_home_second_quarter'      => $game->game_home_second_quarter,
						'game_home_third_quarter'       => $game->game_home_third_quarter,
						'game_home_fourth_quarter'      => $game->game_home_fourth_quarter,
						'game_home_overtime'            => $game->game_home_overtime,
						'game_home_total'               => $game->game_home_total,
						'game_home_pass'                => $game->game_home_pass,
						'game_home_rush'                => $game->game_home_rush,
						'game_home_to'                  => $game->game_home_to,
						'game_home_ints'                => $game->game_home_ints,
						'game_home_fumbles'             => $game->game_home_fumbles,
						'game_home_fumbles_lost'        => $game->game_home_fumbles_lost,
						'game_home_possession'          => $game->game_home_possession,
						'game_home_kick_returns'        => $game->game_home_kick_returns,
						'game_home_kick_return_yards'   => $game->game_home_kick_return_yards,
						'game_home_penalties'           => $game->game_home_penalties,
						'game_home_penalty_yards'       => $game->game_home_penalty_yards,
						'game_home_first_downs'         => $game->game_home_first_downs,
						'game_away_first_quarter'       => $game->game_away_first_quarter,
						'game_away_second_quarter'      => $game->game_away_second_quarter,
						'game_away_third_quarter'       => $game->game_away_third_quarter,
						'game_away_fourth_quarter'      => $game->game_away_fourth_quarter,
						'game_away_overtime'            => $game->game_away_overtime,
						'game_away_total'               => $game->game_away_total,
						'game_away_pass'                => $game->game_away_pass,
						'game_away_rush'                => $game->game_away_rush,
						'game_away_to'                  => $game->game_away_to,
						'game_away_ints'                => $game->game_away_ints,
						'game_away_fumbles'             => $game->game_away_fumbles,
						'game_away_fumbles_lost'        => $game->game_away_fumbles_lost,
						'game_away_possession'          => $game->game_away_possession,
						'game_away_kick_returns'        => $game->game_away_kick_returns,
						'game_away_kick_return_yards'   => $game->game_away_kick_return_yards,
						'game_away_penalties'           => $game->game_away_penalties,
						'game_away_penalty_yards'       => $game->game_away_penalty_yards,
						'game_away_first_downs'         => $game->game_away_first_downs
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'hockey' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_period'  => $game->game_home_first_period,
						'game_home_first_sog'     => $game->game_home_first_sog,
						'game_home_second_period' => $game->game_home_second_period,
						'game_home_second_sog'    => $game->game_home_second_sog,
						'game_home_third_period'  => $game->game_home_third_period,
						'game_home_third_sog'     => $game->game_home_third_sog,
						'game_home_overtime'      => $game->game_home_overtime,
						'game_home_overtime_sog'  => $game->game_home_overtime_sog,
						'game_home_shootout'      => $game->game_home_shootout,
						'game_home_power_plays'   => $game->game_home_power_plays,
						'game_home_pp_goals'      => $game->game_home_pp_goals,
						'game_home_pen_minutes'   => $game->game_home_pen_minutes,
						'game_away_first_period'  => $game->game_away_first_period,
						'game_away_first_sog'     => $game->game_away_first_sog,
						'game_away_second_period' => $game->game_away_second_period,
						'game_away_second_sog'    => $game->game_away_second_sog,
						'game_away_third_period'  => $game->game_away_third_period,
						'game_away_third_sog'     => $game->game_away_third_sog,
						'game_away_overtime'      => $game->game_away_overtime,
						'game_away_overtime_sog'  => $game->game_away_overtime_sog,
						'game_away_shootout'      => $game->game_away_shootout,
						'game_away_power_plays'   => $game->game_away_power_plays,
						'game_away_pp_goals'      => $game->game_away_pp_goals,
						'game_away_pen_minutes'   => $game->game_away_pen_minutes
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'rugby' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'              => $game->game_home_first_half,
						'game_home_second_half'             => $game->game_home_second_half,
						'game_home_extratime'               => $game->game_home_extratime,
						'game_home_shootout'                => $game->game_home_shootout,
						'game_home_tries'                   => $game->game_home_tries,
						'game_home_conversions'             => $game->game_home_conversions,
						'game_home_penalty_goals'           => $game->game_home_penalty_goals,
						'game_home_kick_percentage'         => $game->game_home_kick_percentage,
						'game_home_meters_runs'             => $game->game_home_meters_runs,
						'game_home_meters_hand'             => $game->game_home_meters_hand,
						'game_home_meters_pass'             => $game->game_home_meters_pass,
						'game_home_possession'              => $game->game_home_possession,
						'game_home_clean_breaks'            => $game->game_home_clean_breaks,
						'game_home_defenders_beaten'        => $game->game_home_defenders_beaten,
						'game_home_offload'                 => $game->game_home_offload,
						'game_home_rucks'                   => $game->game_home_rucks,
						'game_home_mauls'                   => $game->game_home_mauls,
						'game_home_turnovers_conceeded'     => $game->game_home_turnovers_conceeded,
						'game_home_scrums'                  => $game->game_home_scrums,
						'game_home_lineouts'                => $game->game_home_lineouts,
						'game_home_penalties_conceeded'     => $game->game_home_penalties_conceeded,
						'game_home_red_cards'               => $game->game_home_red_cards,
						'game_home_yellow_cards'            => $game->game_home_yellow_cards,
						'game_home_free_kicks_conceeded'    => $game->game_home_free_kicks_conceeded,
						'game_away_first_half'              => $game->game_away_first_half,
						'game_away_second_half'             => $game->game_away_second_half,
						'game_away_extratime'               => $game->game_away_extratime,
						'game_away_shootout'                => $game->game_away_shootout,
						'game_away_tries'                   => $game->game_away_tries,
						'game_away_conversions'             => $game->game_away_conversions,
						'game_away_penalty_goals'           => $game->game_away_penalty_goals,
						'game_away_kick_percentage'         => $game->game_away_kick_percentage,
						'game_away_meters_runs'             => $game->game_away_meters_runs,
						'game_away_meters_hand'             => $game->game_away_meters_hand,
						'game_away_meters_pass'             => $game->game_away_meters_pass,
						'game_away_possession'              => $game->game_away_possession,
						'game_away_clean_breaks'            => $game->game_away_clean_breaks,
						'game_away_defenders_beaten'        => $game->game_away_defenders_beaten,
						'game_away_offload'                 => $game->game_away_offload,
						'game_away_rucks'                   => $game->game_away_rucks,
						'game_away_mauls'                   => $game->game_away_mauls,
						'game_away_turnovers_conceeded'     => $game->game_away_turnovers_conceeded,
						'game_away_scrums'                  => $game->game_away_scrums,
						'game_away_lineouts'                => $game->game_away_lineouts,
						'game_away_penalties_conceeded'     => $game->game_away_penalties_conceeded,
						'game_away_red_cards'               => $game->game_away_red_cards,
						'game_away_yellow_cards'            => $game->game_away_yellow_cards,
						'game_away_free_kicks_conceeded'    => $game->game_away_free_kicks_conceeded
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'soccer' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'    => $game->game_home_first_half,
						'game_home_second_half'   => $game->game_home_second_half,
						'game_home_extratime'     => $game->game_home_extratime,
						'game_home_pks'           => $game->game_home_pks,
						'game_home_possession'    => $game->game_home_possession,
						'game_home_shots'         => $game->game_home_shots,
						'game_home_sog'           => $game->game_home_sog,
						'game_home_corners'       => $game->game_home_corners,
						'game_home_offsides'      => $game->game_home_offsides,
						'game_home_fouls'         => $game->game_home_fouls,
						'game_home_saves'         => $game->game_home_saves,
						'game_home_yellow'        => $game->game_home_yellow,
						'game_home_red'           => $game->game_home_red,
						'game_away_first_half'    => $game->game_away_first_half,
						'game_away_second_half'   => $game->game_away_second_half,
						'game_away_extratime'     => $game->game_away_extratime,
						'game_away_pks'           => $game->game_away_pks,
						'game_away_possession'    => $game->game_away_possession,
						'game_away_shots'         => $game->game_away_shots,
						'game_away_sog'           => $game->game_away_sog,
						'game_away_corners'       => $game->game_away_corners,
						'game_away_offsides'      => $game->game_away_offsides,
						'game_away_fouls'         => $game->game_away_fouls,
						'game_away_saves'         => $game->game_away_saves,
						'game_away_yellow'        => $game->game_away_yellow,
						'game_away_red'           => $game->game_away_red
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'volleyball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_set'       => $game->game_home_first_set,
						'game_home_second_set'      => $game->game_home_second_set,
						'game_home_third_set'       => $game->game_home_third_set,
						'game_home_fourth_set'      => $game->game_home_fourth_set,
						'game_home_fifth_set'       => $game->game_home_fifth_set,
						'game_home_kills'           => $game->game_home_kills,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_aces'            => $game->game_home_aces,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_digs'            => $game->game_home_digs,
						'game_home_attacks'         => $game->game_home_attacks,
						'game_home_hitting_errors'  => $game->game_home_hitting_errors,
						'game_away_first_set'       => $game->game_away_first_set,
						'game_away_second_set'      => $game->game_away_second_set,
						'game_away_third_set'       => $game->game_away_third_set,
						'game_away_fourth_set'      => $game->game_away_fourth_set,
						'game_away_fifth_set'       => $game->game_away_fifth_set,
						'game_away_kills'           => $game->game_away_kills,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_aces'            => $game->game_away_aces,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_digs'            => $game->game_away_digs,
						'game_away_attacks'         => $game->game_away_attacks,
						'game_away_hitting_errors'  => $game->game_away_hitting_errors
					);
				}
				$away_team = new Team( (int) $the_game->get_game_away_id() );
				$home_team = new Team( (int) $the_game->get_game_home_id() );
				$game_info['game_away_team'] = $away_team->get_team_name();
				$game_info['game_home_team'] = $home_team->get_team_name();
				$game_info['game_date'] = $the_game->get_game_day( 'F j, Y' );
				array_push( $games_list, $game_info );
			}
			$response = $games_list;

		} else {

			global $wpdb;
			$table = $wpdb->prefix . 'sb_games';
			$querystr = "SELECT * FROM $table;";
			$games = $wpdb->get_results( $querystr );
			$games_list = [];

			foreach ( $games as $game ) {
				$the_game  = new Game( (int) $game->game_id );
				if ( get_option( 'sports-bench-sport' ) == 'baseball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_doubles'       => $game->game_home_doubles,
						'game_home_triples'       => $game->game_home_triples,
						'game_home_homeruns'      => $game->game_home_homeruns,
						'game_home_hits'          => $game->game_home_hits,
						'game_home_errors'        => $game->game_home_errors,
						'game_home_lob'           => $game->game_home_lob,
						'game_away_doubles'       => $game->game_away_doubles,
						'game_away_triples'       => $game->game_away_triples,
						'game_away_homeruns'      => $game->game_away_homeruns,
						'game_away_hits'          => $game->game_away_hits,
						'game_away_errors'        => $game->game_away_errors,
						'game_away_lob'           => $game->game_away_lob
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'basketball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'   => $game->game_home_first_quarter,
						'game_home_second_quarter'  => $game->game_home_second_quarter,
						'game_home_third_quarter'   => $game->game_home_third_quarter,
						'game_home_fourth_quarter'  => $game->game_home_fourth_quarter,
						'game_home_overtime'        => $game->game_home_overtime,
						'game_home_fgm'             => $game->game_home_fgm,
						'game_home_fga'             => $game->game_home_fga,
						'game_home_3pm'             => $game->game_home_3pm,
						'game_home_3pa'             => $game->game_home_3pa,
						'game_home_ftm'             => $game->game_home_ftm,
						'game_home_fta'             => $game->game_home_fta,
						'game_home_off_rebound'     => $game->game_home_off_rebound,
						'game_home_def_rebound'     => $game->game_home_def_rebound,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_steals'          => $game->game_home_steals,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_pip'             => $game->game_home_pip,
						'game_home_to'              => $game->game_home_to,
						'game_home_pot'             => $game->game_home_pot,
						'game_home_fast_break'      => $game->game_home_fast_break,
						'game_home_fouls'           => $game->game_home_fouls,
						'game_away_first_quarter'   => $game->game_away_first_quarter,
						'game_away_second_quarter'  => $game->game_away_second_quarter,
						'game_away_third_quarter'   => $game->game_away_third_quarter,
						'game_away_fourth_quarter'  => $game->game_away_fourth_quarter,
						'game_away_overtime'        => $game->game_away_overtime,
						'game_away_fgm'             => $game->game_away_fgm,
						'game_away_fga'             => $game->game_away_fga,
						'game_away_3pm'             => $game->game_away_3pm,
						'game_away_3pa'             => $game->game_away_3pa,
						'game_away_ftm'             => $game->game_away_ftm,
						'game_away_fta'             => $game->game_away_fta,
						'game_away_off_rebound'     => $game->game_away_off_rebound,
						'game_away_def_rebound'     => $game->game_away_def_rebound,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_steals'          => $game->game_away_steals,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_pip'             => $game->game_away_pip,
						'game_away_to'              => $game->game_away_to,
						'game_away_pot'             => $game->game_away_pot,
						'game_away_fast_break'      => $game->game_away_fast_break,
						'game_away_fouls'           => $game->game_away_fouls
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'football' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_quarter'       => $game->game_home_first_quarter,
						'game_home_second_quarter'      => $game->game_home_second_quarter,
						'game_home_third_quarter'       => $game->game_home_third_quarter,
						'game_home_fourth_quarter'      => $game->game_home_fourth_quarter,
						'game_home_overtime'            => $game->game_home_overtime,
						'game_home_total'               => $game->game_home_total,
						'game_home_pass'                => $game->game_home_pass,
						'game_home_rush'                => $game->game_home_rush,
						'game_home_to'                  => $game->game_home_to,
						'game_home_ints'                => $game->game_home_ints,
						'game_home_fumbles'             => $game->game_home_fumbles,
						'game_home_fumbles_lost'        => $game->game_home_fumbles_lost,
						'game_home_possession'          => $game->game_home_possession,
						'game_home_kick_returns'        => $game->game_home_kick_returns,
						'game_home_kick_return_yards'   => $game->game_home_kick_return_yards,
						'game_home_penalties'           => $game->game_home_penalties,
						'game_home_penalty_yards'       => $game->game_home_penalty_yards,
						'game_home_first_downs'         => $game->game_home_first_downs,
						'game_away_first_quarter'       => $game->game_away_first_quarter,
						'game_away_second_quarter'      => $game->game_away_second_quarter,
						'game_away_third_quarter'       => $game->game_away_third_quarter,
						'game_away_fourth_quarter'      => $game->game_away_fourth_quarter,
						'game_away_overtime'            => $game->game_away_overtime,
						'game_away_total'               => $game->game_away_total,
						'game_away_pass'                => $game->game_away_pass,
						'game_away_rush'                => $game->game_away_rush,
						'game_away_to'                  => $game->game_away_to,
						'game_away_ints'                => $game->game_away_ints,
						'game_away_fumbles'             => $game->game_away_fumbles,
						'game_away_fumbles_lost'        => $game->game_away_fumbles_lost,
						'game_away_possession'          => $game->game_away_possession,
						'game_away_kick_returns'        => $game->game_away_kick_returns,
						'game_away_kick_return_yards'   => $game->game_away_kick_return_yards,
						'game_away_penalties'           => $game->game_away_penalties,
						'game_away_penalty_yards'       => $game->game_away_penalty_yards,
						'game_away_first_downs'         => $game->game_away_first_downs
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'hockey' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_period'  => $game->game_home_first_period,
						'game_home_first_sog'     => $game->game_home_first_sog,
						'game_home_second_period' => $game->game_home_second_period,
						'game_home_second_sog'    => $game->game_home_second_sog,
						'game_home_third_period'  => $game->game_home_third_period,
						'game_home_third_sog'     => $game->game_home_third_sog,
						'game_home_overtime'      => $game->game_home_overtime,
						'game_home_overtime_sog'  => $game->game_home_overtime_sog,
						'game_home_shootout'      => $game->game_home_shootout,
						'game_home_power_plays'   => $game->game_home_power_plays,
						'game_home_pp_goals'      => $game->game_home_pp_goals,
						'game_home_pen_minutes'   => $game->game_home_pen_minutes,
						'game_away_first_period'  => $game->game_away_first_period,
						'game_away_first_sog'     => $game->game_away_first_sog,
						'game_away_second_period' => $game->game_away_second_period,
						'game_away_second_sog'    => $game->game_away_second_sog,
						'game_away_third_period'  => $game->game_away_third_period,
						'game_away_third_sog'     => $game->game_away_third_sog,
						'game_away_overtime'      => $game->game_away_overtime,
						'game_away_overtime_sog'  => $game->game_away_overtime_sog,
						'game_away_shootout'      => $game->game_away_shootout,
						'game_away_power_plays'   => $game->game_away_power_plays,
						'game_away_pp_goals'      => $game->game_away_pp_goals,
						'game_away_pen_minutes'   => $game->game_away_pen_minutes
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'rugby' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'              => $game->game_home_first_half,
						'game_home_second_half'             => $game->game_home_second_half,
						'game_home_extratime'               => $game->game_home_extratime,
						'game_home_shootout'                => $game->game_home_shootout,
						'game_home_tries'                   => $game->game_home_tries,
						'game_home_conversions'             => $game->game_home_conversions,
						'game_home_penalty_goals'           => $game->game_home_penalty_goals,
						'game_home_kick_percentage'         => $game->game_home_kick_percentage,
						'game_home_meters_runs'             => $game->game_home_meters_runs,
						'game_home_meters_hand'             => $game->game_home_meters_hand,
						'game_home_meters_pass'             => $game->game_home_meters_pass,
						'game_home_possession'              => $game->game_home_possession,
						'game_home_clean_breaks'            => $game->game_home_clean_breaks,
						'game_home_defenders_beaten'        => $game->game_home_defenders_beaten,
						'game_home_offload'                 => $game->game_home_offload,
						'game_home_rucks'                   => $game->game_home_rucks,
						'game_home_mauls'                   => $game->game_home_mauls,
						'game_home_turnovers_conceeded'     => $game->game_home_turnovers_conceeded,
						'game_home_scrums'                  => $game->game_home_scrums,
						'game_home_lineouts'                => $game->game_home_lineouts,
						'game_home_penalties_conceeded'     => $game->game_home_penalties_conceeded,
						'game_home_red_cards'               => $game->game_home_red_cards,
						'game_home_yellow_cards'            => $game->game_home_yellow_cards,
						'game_home_free_kicks_conceeded'    => $game->game_home_free_kicks_conceeded,
						'game_away_first_half'              => $game->game_away_first_half,
						'game_away_second_half'             => $game->game_away_second_half,
						'game_away_extratime'               => $game->game_away_extratime,
						'game_away_shootout'                => $game->game_away_shootout,
						'game_away_tries'                   => $game->game_away_tries,
						'game_away_conversions'             => $game->game_away_conversions,
						'game_away_penalty_goals'           => $game->game_away_penalty_goals,
						'game_away_kick_percentage'         => $game->game_away_kick_percentage,
						'game_away_meters_runs'             => $game->game_away_meters_runs,
						'game_away_meters_hand'             => $game->game_away_meters_hand,
						'game_away_meters_pass'             => $game->game_away_meters_pass,
						'game_away_possession'              => $game->game_away_possession,
						'game_away_clean_breaks'            => $game->game_away_clean_breaks,
						'game_away_defenders_beaten'        => $game->game_away_defenders_beaten,
						'game_away_offload'                 => $game->game_away_offload,
						'game_away_rucks'                   => $game->game_away_rucks,
						'game_away_mauls'                   => $game->game_away_mauls,
						'game_away_turnovers_conceeded'     => $game->game_away_turnovers_conceeded,
						'game_away_scrums'                  => $game->game_away_scrums,
						'game_away_lineouts'                => $game->game_away_lineouts,
						'game_away_penalties_conceeded'     => $game->game_away_penalties_conceeded,
						'game_away_red_cards'               => $game->game_away_red_cards,
						'game_away_yellow_cards'            => $game->game_away_yellow_cards,
						'game_away_free_kicks_conceeded'    => $game->game_away_free_kicks_conceeded
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'soccer' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_half'    => $game->game_home_first_half,
						'game_home_second_half'   => $game->game_home_second_half,
						'game_home_extratime'     => $game->game_home_extratime,
						'game_home_pks'           => $game->game_home_pks,
						'game_home_possession'    => $game->game_home_possession,
						'game_home_shots'         => $game->game_home_shots,
						'game_home_sog'           => $game->game_home_sog,
						'game_home_corners'       => $game->game_home_corners,
						'game_home_offsides'      => $game->game_home_offsides,
						'game_home_fouls'         => $game->game_home_fouls,
						'game_home_saves'         => $game->game_home_saves,
						'game_home_yellow'        => $game->game_home_yellow,
						'game_home_red'           => $game->game_home_red,
						'game_away_first_half'    => $game->game_away_first_half,
						'game_away_second_half'   => $game->game_away_second_half,
						'game_away_extratime'     => $game->game_away_extratime,
						'game_away_pks'           => $game->game_away_pks,
						'game_away_possession'    => $game->game_away_possession,
						'game_away_shots'         => $game->game_away_shots,
						'game_away_sog'           => $game->game_away_sog,
						'game_away_corners'       => $game->game_away_corners,
						'game_away_offsides'      => $game->game_away_offsides,
						'game_away_fouls'         => $game->game_away_fouls,
						'game_away_saves'         => $game->game_away_saves,
						'game_away_yellow'        => $game->game_away_yellow,
						'game_away_red'           => $game->game_away_red
					);
				} elseif ( get_option( 'sports-bench-sport' ) == 'volleyball' ) {
					$game_info = array (
						'game_id'                 => $the_game->get_game_id(),
						'game_week'               => $the_game->get_game_week(),
						'game_season'             => $the_game->get_game_season(),
						'game_day'                => $the_game->get_game_day(),
						'game_home_id'            => $the_game->get_game_home_id(),
						'game_home_final'         => $the_game->get_game_home_final(),
						'game_away_id'            => $the_game->get_game_away_id(),
						'game_away_final'         => $the_game->get_game_away_final(),
						'game_attendance'         => $the_game->get_game_attendance(),
						'game_status'             => $the_game->get_game_status(),
						'game_neutral_site'       => $the_game->get_game_neutral_site(),
						'game_location_stadium'   => $the_game->get_game_location_stadium(),
						'game_location_line_one'  => $the_game->get_game_location_line_one(),
						'game_location_line_two'  => $the_game->get_game_location_line_two(),
						'game_location_city'      => $the_game->get_game_location_city(),
						'game_location_state'     => $the_game->get_game_location_state(),
						'game_location_country'   => $the_game->get_game_location_country(),
						'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
						'game_current_time'       => $the_game->get_game_current_time(),
						'game_current_period'     => $the_game->get_game_current_period(),
						'game_current_home_score' => $the_game->get_game_current_home_score(),
						'game_current_away_score' => $the_game->get_game_current_away_score(),
						'preview_link'            => $the_game->get_game_preview(),
						'recap_link'              => $the_game->get_game_recap(),
						'game_home_first_set'       => $game->game_home_first_set,
						'game_home_second_set'      => $game->game_home_second_set,
						'game_home_third_set'       => $game->game_home_third_set,
						'game_home_fourth_set'      => $game->game_home_fourth_set,
						'game_home_fifth_set'       => $game->game_home_fifth_set,
						'game_home_kills'           => $game->game_home_kills,
						'game_home_blocks'          => $game->game_home_blocks,
						'game_home_aces'            => $game->game_home_aces,
						'game_home_assists'         => $game->game_home_assists,
						'game_home_digs'            => $game->game_home_digs,
						'game_home_attacks'         => $game->game_home_attacks,
						'game_home_hitting_errors'  => $game->game_home_hitting_errors,
						'game_away_first_set'       => $game->game_away_first_set,
						'game_away_second_set'      => $game->game_away_second_set,
						'game_away_third_set'       => $game->game_away_third_set,
						'game_away_fourth_set'      => $game->game_away_fourth_set,
						'game_away_fifth_set'       => $game->game_away_fifth_set,
						'game_away_kills'           => $game->game_away_kills,
						'game_away_blocks'          => $game->game_away_blocks,
						'game_away_aces'            => $game->game_away_aces,
						'game_away_assists'         => $game->game_away_assists,
						'game_away_digs'            => $game->game_away_digs,
						'game_away_attacks'         => $game->game_away_attacks,
						'game_away_hitting_errors'  => $game->game_away_hitting_errors
					);
				}
				$away_team = new Team( (int) $the_game->get_game_away_id() );
				$home_team = new Team( (int) $the_game->get_game_home_id() );
				$gametime = date_create( $the_game->get_game_day() );
				$game_info['game_away_team'] = $away_team->get_team_name();
				$game_info['game_home_team'] = $home_team->get_team_name();
				$game_info['game_date'] = date_format( $gametime, 'F j, Y' );
				array_push( $games_list, $game_info );
			}
			$response = $games_list;

		}

		return $response;
	}

	/**
	 * Returns an array of information for a team
	 *
	 * @param int $game_id
	 *
	 * @return array, information for a team
	 *
	 * @since 1.4
	 */
	function get_game( $game_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'sb_games';
		$querystr = "SELECT * FROM $table WHERE game_id = $game_id;";
		$games = $wpdb->get_results( $querystr );
		$games_list = [];

		foreach ( $games as $game ) {
			$the_game  = new Game( (int) $game->game_id );
			if ( get_option( 'sports-bench-sport' ) == 'baseball' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_doubles'       => $game->game_home_doubles,
					'game_home_triples'       => $game->game_home_triples,
					'game_home_homeruns'      => $game->game_home_homeruns,
					'game_home_hits'          => $game->game_home_hits,
					'game_home_errors'        => $game->game_home_errors,
					'game_home_lob'           => $game->game_home_lob,
					'game_away_doubles'       => $game->game_away_doubles,
					'game_away_triples'       => $game->game_away_triples,
					'game_away_homeruns'      => $game->game_away_homeruns,
					'game_away_hits'          => $game->game_away_hits,
					'game_away_errors'        => $game->game_away_errors,
					'game_away_lob'           => $game->game_away_lob
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'basketball' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_quarter'   => $game->game_home_first_quarter,
					'game_home_second_quarter'  => $game->game_home_second_quarter,
					'game_home_third_quarter'   => $game->game_home_third_quarter,
					'game_home_fourth_quarter'  => $game->game_home_fourth_quarter,
					'game_home_overtime'        => $game->game_home_overtime,
					'game_home_fgm'             => $game->game_home_fgm,
					'game_home_fga'             => $game->game_home_fga,
					'game_home_3pm'             => $game->game_home_3pm,
					'game_home_3pa'             => $game->game_home_3pa,
					'game_home_ftm'             => $game->game_home_ftm,
					'game_home_fta'             => $game->game_home_fta,
					'game_home_off_rebound'     => $game->game_home_off_rebound,
					'game_home_def_rebound'     => $game->game_home_def_rebound,
					'game_home_assists'         => $game->game_home_assists,
					'game_home_steals'          => $game->game_home_steals,
					'game_home_blocks'          => $game->game_home_blocks,
					'game_home_pip'             => $game->game_home_pip,
					'game_home_to'              => $game->game_home_to,
					'game_home_pot'             => $game->game_home_pot,
					'game_home_fast_break'      => $game->game_home_fast_break,
					'game_home_fouls'           => $game->game_home_fouls,
					'game_away_first_quarter'   => $game->game_away_first_quarter,
					'game_away_second_quarter'  => $game->game_away_second_quarter,
					'game_away_third_quarter'   => $game->game_away_third_quarter,
					'game_away_fourth_quarter'  => $game->game_away_fourth_quarter,
					'game_away_overtime'        => $game->game_away_overtime,
					'game_away_fgm'             => $game->game_away_fgm,
					'game_away_fga'             => $game->game_away_fga,
					'game_away_3pm'             => $game->game_away_3pm,
					'game_away_3pa'             => $game->game_away_3pa,
					'game_away_ftm'             => $game->game_away_ftm,
					'game_away_fta'             => $game->game_away_fta,
					'game_away_off_rebound'     => $game->game_away_off_rebound,
					'game_away_def_rebound'     => $game->game_away_def_rebound,
					'game_away_assists'         => $game->game_away_assists,
					'game_away_steals'          => $game->game_away_steals,
					'game_away_blocks'          => $game->game_away_blocks,
					'game_away_pip'             => $game->game_away_pip,
					'game_away_to'              => $game->game_away_to,
					'game_away_pot'             => $game->game_away_pot,
					'game_away_fast_break'      => $game->game_away_fast_break,
					'game_away_fouls'           => $game->game_away_fouls
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'football' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_quarter'       => $game->game_home_first_quarter,
					'game_home_second_quarter'      => $game->game_home_second_quarter,
					'game_home_third_quarter'       => $game->game_home_third_quarter,
					'game_home_fourth_quarter'      => $game->game_home_fourth_quarter,
					'game_home_overtime'            => $game->game_home_overtime,
					'game_home_total'               => $game->game_home_total,
					'game_home_pass'                => $game->game_home_pass,
					'game_home_rush'                => $game->game_home_rush,
					'game_home_to'                  => $game->game_home_to,
					'game_home_ints'                => $game->game_home_ints,
					'game_home_fumbles'             => $game->game_home_fumbles,
					'game_home_fumbles_lost'        => $game->game_home_fumbles_lost,
					'game_home_possession'          => $game->game_home_possession,
					'game_home_kick_returns'        => $game->game_home_kick_returns,
					'game_home_kick_return_yards'   => $game->game_home_kick_return_yards,
					'game_home_penalties'           => $game->game_home_penalties,
					'game_home_penalty_yards'       => $game->game_home_penalty_yards,
					'game_home_first_downs'         => $game->game_home_first_downs,
					'game_away_first_quarter'       => $game->game_away_first_quarter,
					'game_away_second_quarter'      => $game->game_away_second_quarter,
					'game_away_third_quarter'       => $game->game_away_third_quarter,
					'game_away_fourth_quarter'      => $game->game_away_fourth_quarter,
					'game_away_overtime'            => $game->game_away_overtime,
					'game_away_total'               => $game->game_away_total,
					'game_away_pass'                => $game->game_away_pass,
					'game_away_rush'                => $game->game_away_rush,
					'game_away_to'                  => $game->game_away_to,
					'game_away_ints'                => $game->game_away_ints,
					'game_away_fumbles'             => $game->game_away_fumbles,
					'game_away_fumbles_lost'        => $game->game_away_fumbles_lost,
					'game_away_possession'          => $game->game_away_possession,
					'game_away_kick_returns'        => $game->game_away_kick_returns,
					'game_away_kick_return_yards'   => $game->game_away_kick_return_yards,
					'game_away_penalties'           => $game->game_away_penalties,
					'game_away_penalty_yards'       => $game->game_away_penalty_yards,
					'game_away_first_downs'         => $game->game_away_first_downs
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'hockey' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_period'  => $game->game_home_first_period,
					'game_home_first_sog'     => $game->game_home_first_sog,
					'game_home_second_period' => $game->game_home_second_period,
					'game_home_second_sog'    => $game->game_home_second_sog,
					'game_home_third_period'  => $game->game_home_third_period,
					'game_home_third_sog'     => $game->game_home_third_sog,
					'game_home_overtime'      => $game->game_home_overtime,
					'game_home_overtime_sog'  => $game->game_home_overtime_sog,
					'game_home_shootout'      => $game->game_home_shootout,
					'game_home_power_plays'   => $game->game_home_power_plays,
					'game_home_pp_goals'      => $game->game_home_pp_goals,
					'game_home_pen_minutes'   => $game->game_home_pen_minutes,
					'game_away_first_period'  => $game->game_away_first_period,
					'game_away_first_sog'     => $game->game_away_first_sog,
					'game_away_second_period' => $game->game_away_second_period,
					'game_away_second_sog'    => $game->game_away_second_sog,
					'game_away_third_period'  => $game->game_away_third_period,
					'game_away_third_sog'     => $game->game_away_third_sog,
					'game_away_overtime'      => $game->game_away_overtime,
					'game_away_overtime_sog'  => $game->game_away_overtime_sog,
					'game_away_shootout'      => $game->game_away_shootout,
					'game_away_power_plays'   => $game->game_away_power_plays,
					'game_away_pp_goals'      => $game->game_away_pp_goals,
					'game_away_pen_minutes'   => $game->game_away_pen_minutes
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'rugby' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_half'              => $game->game_home_first_half,
					'game_home_second_half'             => $game->game_home_second_half,
					'game_home_extratime'               => $game->game_home_extratime,
					'game_home_shootout'                => $game->game_home_shootout,
					'game_home_tries'                   => $game->game_home_tries,
					'game_home_conversions'             => $game->game_home_conversions,
					'game_home_penalty_goals'           => $game->game_home_penalty_goals,
					'game_home_kick_percentage'         => $game->game_home_kick_percentage,
					'game_home_meters_runs'             => $game->game_home_meters_runs,
					'game_home_meters_hand'             => $game->game_home_meters_hand,
					'game_home_meters_pass'             => $game->game_home_meters_pass,
					'game_home_possession'              => $game->game_home_possession,
					'game_home_clean_breaks'            => $game->game_home_clean_breaks,
					'game_home_defenders_beaten'        => $game->game_home_defenders_beaten,
					'game_home_offload'                 => $game->game_home_offload,
					'game_home_rucks'                   => $game->game_home_rucks,
					'game_home_mauls'                   => $game->game_home_mauls,
					'game_home_turnovers_conceeded'     => $game->game_home_turnovers_conceeded,
					'game_home_scrums'                  => $game->game_home_scrums,
					'game_home_lineouts'                => $game->game_home_lineouts,
					'game_home_penalties_conceeded'     => $game->game_home_penalties_conceeded,
					'game_home_red_cards'               => $game->game_home_red_cards,
					'game_home_yellow_cards'            => $game->game_home_yellow_cards,
					'game_home_free_kicks_conceeded'    => $game->game_home_free_kicks_conceeded,
					'game_away_first_half'              => $game->game_away_first_half,
					'game_away_second_half'             => $game->game_away_second_half,
					'game_away_extratime'               => $game->game_away_extratime,
					'game_away_shootout'                => $game->game_away_shootout,
					'game_away_tries'                   => $game->game_away_tries,
					'game_away_conversions'             => $game->game_away_conversions,
					'game_away_penalty_goals'           => $game->game_away_penalty_goals,
					'game_away_kick_percentage'         => $game->game_away_kick_percentage,
					'game_away_meters_runs'             => $game->game_away_meters_runs,
					'game_away_meters_hand'             => $game->game_away_meters_hand,
					'game_away_meters_pass'             => $game->game_away_meters_pass,
					'game_away_possession'              => $game->game_away_possession,
					'game_away_clean_breaks'            => $game->game_away_clean_breaks,
					'game_away_defenders_beaten'        => $game->game_away_defenders_beaten,
					'game_away_offload'                 => $game->game_away_offload,
					'game_away_rucks'                   => $game->game_away_rucks,
					'game_away_mauls'                   => $game->game_away_mauls,
					'game_away_turnovers_conceeded'     => $game->game_away_turnovers_conceeded,
					'game_away_scrums'                  => $game->game_away_scrums,
					'game_away_lineouts'                => $game->game_away_lineouts,
					'game_away_penalties_conceeded'     => $game->game_away_penalties_conceeded,
					'game_away_red_cards'               => $game->game_away_red_cards,
					'game_away_yellow_cards'            => $game->game_away_yellow_cards,
					'game_away_free_kicks_conceeded'    => $game->game_away_free_kicks_conceeded
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'soccer' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_half'    => $game->game_home_first_half,
					'game_home_second_half'   => $game->game_home_second_half,
					'game_home_extratime'     => $game->game_home_extratime,
					'game_home_pks'           => $game->game_home_pks,
					'game_home_possession'    => $game->game_home_possession,
					'game_home_shots'         => $game->game_home_shots,
					'game_home_sog'           => $game->game_home_sog,
					'game_home_corners'       => $game->game_home_corners,
					'game_home_offsides'      => $game->game_home_offsides,
					'game_home_fouls'         => $game->game_home_fouls,
					'game_home_saves'         => $game->game_home_saves,
					'game_home_yellow'        => $game->game_home_yellow,
					'game_home_red'           => $game->game_home_red,
					'game_away_first_half'    => $game->game_away_first_half,
					'game_away_second_half'   => $game->game_away_second_half,
					'game_away_extratime'     => $game->game_away_extratime,
					'game_away_pks'           => $game->game_away_pks,
					'game_away_possession'    => $game->game_away_possession,
					'game_away_shots'         => $game->game_away_shots,
					'game_away_sog'           => $game->game_away_sog,
					'game_away_corners'       => $game->game_away_corners,
					'game_away_offsides'      => $game->game_away_offsides,
					'game_away_fouls'         => $game->game_away_fouls,
					'game_away_saves'         => $game->game_away_saves,
					'game_away_yellow'        => $game->game_away_yellow,
					'game_away_red'           => $game->game_away_red
				);
			} elseif ( get_option( 'sports-bench-sport' ) == 'volleyball' ) {
				$game_info = array (
					'game_id'                 => $the_game->get_game_id(),
					'game_week'               => $the_game->get_game_week(),
					'game_season'             => $the_game->get_game_season(),
					'game_day'                => $the_game->get_game_day(),
					'game_home_id'            => $the_game->get_game_home_id(),
					'game_home_final'         => $the_game->get_game_home_final(),
					'game_away_id'            => $the_game->get_game_away_id(),
					'game_away_final'         => $the_game->get_game_away_final(),
					'game_attendance'         => $the_game->get_game_attendance(),
					'game_status'             => $the_game->get_game_status(),
					'game_neutral_site'       => $the_game->get_game_neutral_site(),
					'game_location_stadium'   => $the_game->get_game_location_stadium(),
					'game_location_line_one'  => $the_game->get_game_location_line_one(),
					'game_location_line_two'  => $the_game->get_game_location_line_two(),
					'game_location_city'      => $the_game->get_game_location_city(),
					'game_location_state'     => $the_game->get_game_location_state(),
					'game_location_country'   => $the_game->get_game_location_country(),
					'game_location_zip_code'  => $the_game->get_game_location_zip_code(),
					'game_current_time'       => $the_game->get_game_current_time(),
					'game_current_period'     => $the_game->get_game_current_period(),
					'game_current_home_score' => $the_game->get_game_current_home_score(),
					'game_current_away_score' => $the_game->get_game_current_away_score(),
					'preview_link'            => $the_game->get_game_preview(),
					'recap_link'              => $the_game->get_game_recap(),
					'game_home_first_set'       => $game->game_home_first_set,
					'game_home_second_set'      => $game->game_home_second_set,
					'game_home_third_set'       => $game->game_home_third_set,
					'game_home_fourth_set'      => $game->game_home_fourth_set,
					'game_home_fifth_set'       => $game->game_home_fifth_set,
					'game_home_kills'           => $game->game_home_kills,
					'game_home_blocks'          => $game->game_home_blocks,
					'game_home_aces'            => $game->game_home_aces,
					'game_home_assists'         => $game->game_home_assists,
					'game_home_digs'            => $game->game_home_digs,
					'game_home_attacks'         => $game->game_home_attacks,
					'game_home_hitting_errors'  => $game->game_home_hitting_errors,
					'game_away_first_set'       => $game->game_away_first_set,
					'game_away_second_set'      => $game->game_away_second_set,
					'game_away_third_set'       => $game->game_away_third_set,
					'game_away_fourth_set'      => $game->game_away_fourth_set,
					'game_away_fifth_set'       => $game->game_away_fifth_set,
					'game_away_kills'           => $game->game_away_kills,
					'game_away_blocks'          => $game->game_away_blocks,
					'game_away_aces'            => $game->game_away_aces,
					'game_away_assists'         => $game->game_away_assists,
					'game_away_digs'            => $game->game_away_digs,
					'game_away_attacks'         => $game->game_away_attacks,
					'game_away_hitting_errors'  => $game->game_away_hitting_errors
				);
			}
			array_push( $games_list, $game_info );
		}
		$response = $games_list;

		return $response;
	}

}
