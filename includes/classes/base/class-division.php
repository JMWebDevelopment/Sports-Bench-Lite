<?php
/**
 * Creates the division class.
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

namespace Sports_Bench\Classes\Base;

/**
 * The core division class.
 *
 * This is used for divisions in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Division {

	/**
	 * The id of the division.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $division_id;

	/**
	 * The name of the division.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	public $division_name;

	/**
	 * Whether the division is a division or conference.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $division_conference;

	/**
	 * The id of the conference the division is in.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $division_conference_id;

	/**
	 * The color of the division.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $division_color;


	/**
	 * Creates the new Division object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The ID of the division to create the object for.
	 */
	public function __construct( $division_id ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$division = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $division_id ) );

		if ( $division ) {
			$this->division_id            = $division[0]->division_id;
			$this->division_name          = $division[0]->division_name;
			$this->division_conference    = $division[0]->division_conference;
			$this->division_conference_id = $division[0]->division_conference_id;
			$this->division_color         = $division[0]->division_color;

		}
	}

	/**
	 * Returns the division id.
	 *
	 * @since 2.0
	 *
	 * @return int      The division id.
	 */
	public function get_division_id() {
		return $this->division_id;
	}

	/**
	 * Returns the name of the division.
	 *
	 * @since 2.0
	 *
	 * @return string      The name of the division.
	 */
	public function get_division_name() {
		return $this->division_name;
	}

	/**
	 * Returns the type of division.
	 *
	 * @since 2.0
	 *
	 * @return string      The type of division.
	 */
	public function get_division_conference() {
		return $this->division_conference;
	}

	/**
	 * Returns the conference id for a division.
	 *
	 * @since 2.0
	 *
	 * @return string      The conference id for a division.
	 */
	public function get_division_conference_id() {
		return $this->division_conference_id;
	}

	/**
	 * Returns the division color.
	 *
	 * @since 2.0
	 *
	 * @return string      The division color.
	 */
	public function get_division_color() {
		return $this->division_color;
	}

	/**
	 * Updates the division with new information provided.
	 *
	 * @since 2.0.0
	 *
	 * @param array $values     The values to change for the division in key => value pairs.
	 */
	public function update( $values ) {
		$current_values = [
			'division_id'            => intval( $this->division_id ),
			'division_name'          => $this->division_name,
			'division_conference'    => $this->division_conference,
			'division_conference_id' => intval( $this->division_conference_id ),
			'division_color'         => $this->division_color,
		];
		$data           = wp_parse_args( $values, $current_values );
		Database::update_row( 'divisions', array( 'division_id' => $this->division_id ), $data );

		$this->division_id            = $data['division_id'];
		$this->division_name          = $data['division_name'];
		$this->division_conference    = $data['division_conference'];
		$this->division_conference_id = $data['division_conference_id'];
		$this->division_color         = $data['division_color'];
	}

}
