<?php
/**
 * The file that defines the divisions screen class
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screens/admin
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Screens\Admin;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Division;

/**
 * The divisions screen class.
 *
 * This is used for functions for divisions admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class DivisionsScreen extends Screen {

	/**
	 * The array of division/conferences options for a select droppdown.
	 *
	 * @since 2.0.0
	 *
	 * @var array $division_dropdown
	 * @access    protected
	 */
	protected $division_dropdown;

	/**
	 * The array of conferences for a select droppdown.
	 *
	 * @since 2.0.0
	 *
	 * @var array $conferences
	 * @access    protected
	 */
	protected $conferences;

	/**
	 * Creates the new DivisionsScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();

		$this->division_dropdown = [
			'Division'   => __( 'Divisions', 'sports-bench' ),
			'Conference' => __( 'Conference', 'sports-bench' ),
		];

		//* Get the Divisions/Conferences into an array
		$table_name  = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$confs       = Database::get_results( "SELECT * FROM $table_name WHERE division_conference_id IS NULL" );
		$this->conferences = [];
		foreach ( $confs as $conf ) {
			$conference = array(
				'division_id'   => $conf->division_id,
				'division_name' => $conf->division_name,
			);
			array_push( $this->conferences, $conference );
		}
	}

	/**
	 * Displays a table of all of the divisions and conferences.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the division and conference table.
	 */
	public function display_divisions_conferences() {
		$divisions = $this->get_divisions_conferences();

		if ( $divisions ) {
			$html  = '<table class="teams-table form-table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>' . esc_html__( 'Name', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Type', 'sports-bench' ) . '</th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Edit Team Column', 'sports-bench' ) . '</span></th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Delete Team Column', 'sports-bench' ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';
			foreach ( $divisions as $division ) {
				$html .= '<tr>';
				$html .= '<td>' . $division['division_name'] . '</td>';
				$html .= '<td>' . $division['division_conference'] . '</td>';
				$html .= '<td class="edit-column"><a href="' . $this->get_admin_page_link( 'sports-bench-divisions&division_id=' . $division['division_id'] ) . '" class="button">' . esc_html__( 'Edit', 'sports-bench' ) . '</a></td>';
				$html .= '<td class="delete-column"><a href="' . $this->get_admin_page_link( 'sports-bench-divisions&action=delete&division_id=' . $division['division_id'] ) . '" class="button red">' . esc_html__( 'Delete', 'sports-bench' ) . '</a></td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';

			$html .= '</table>';
		} else {
			$html = '<p>' . esc_html__( 'There are no divisions in the database.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Gets the list of divisions and conferences.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of divisions and conferences.
	 */
	public function get_divisions_conferences() {
		$conferences    = [];
		$divisions      = [];
		$table_name     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$division_items = Database::get_results( "SELECT t1.division_id AS conference_id, t1.division_name AS conference_name, t2.division_id AS division_id, t2.division_name AS division_name, t2.division_conference_id AS division_conference_id, t2.division_conference AS division_conference FROM $table_name AS t1 LEFT JOIN $table_name AS t2 ON t1.division_id = t2.division_conference_id WHERE t2.division_id IS NOT NULL ORDER BY t1.division_id" );
		$conference     = '';

		if ( null !== $division_items && ! empty( $division_items ) ) {
			foreach ( $division_items as $division_item ) {
				if ( $conference !== $division_item->conference_name ) {
					$division = [
						'division_id'            => $division_item->conference_id,
						'division_name'          => $division_item->conference_name,
						'division_conference_id' => '',
						'division_conference'    => 'Conference',
					];
					$conference = $division_item->conference_name;
					array_push( $divisions, $division );
				}
				$division = [
					'division_id'            => $division_item->division_id,
					'division_name'          => $division_item->division_name,
					'division_conference_id' => $division_item->division_conference_id,
					'division_conference'    => 'Division',
				];
				array_push( $divisions, $division );
			}
		} else {
			$divisions = Database::get_results( "SELECT * FROM $table_name" );
			$the_items = [];
			foreach ( $divisions as $division_item ) {
				$division = [
					'division_id'            => $division_item->division_id,
					'division_name'          => $division_item->division_name,
					'division_conference_id' => $division_item->division_conference_id,
					'division_conference'    => $division_item->division_conference,
				];
				array_push( $the_items, $division );
			}
			$divisions = $the_items;
		}

		return $divisions;
	}

	/**
	 * Displays the fields for the a new division or conference.
	 *
	 * @since 2.0.0
	 */
	public function add_new_division_conference() {
		$division_id = $this->get_new_division_id();
		?>
		<form id="form" method="POST" action="?page=sports-bench-divisions&division_id=<?php echo esc_attr( $division_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-division' ) ); ?>"/>
			<input type="hidden" name="division_id" value="<?php echo esc_attr( $division_id ); ?>"/>

			<div class="field one-column">
				<label for="division-name"><?php esc_html_e( 'Name:', 'sports-bench' ); ?></label>
				<input type="text" id="division-name" name="division_name" />
			</div>

			<div class="field one-column">
				<label for="division-conference"><?php esc_html_e( 'Division/Conference:', 'sports-bench' ); ?></label>
				<select name="division_conference" id="division-conference">
					<?php
					foreach ( $this->division_dropdown as $key => $label ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<div id="division-conference-section" class="field one-column">
				<label for="division-conference-id"><?php esc_html_e( 'Conference:', 'sports-bench' ); ?></label>
				<select name="division_conference_id" id="division-conference-id">
					<?php
					foreach ( $this->conferences as $conference ) {
						?>
						<option value="<?php echo esc_attr( $conference['division_id'] ); ?>"><?php echo esc_html( $conference['division_name'] ); ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<div class="field one-column">
				<label for="division-color"><?php esc_html_e( 'Color:', 'sports-bench' ); ?></label>
				<input type="text" id="division-color" name="division_color" class="cpa-color-picker" />
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</form>
		<?php
	}

	/**
	 * Dislays the fields to edit a division or conference.
	 *
	 * @since 2.0.0
	 *
	 * @param array $division      The array of information for the current division.
	 */
	public function edit_division_conference( $division ) {
		?>
		<form id="form" method="POST" action="?page=sports-bench-divisions&division_id=<?php echo esc_attr( $division['division_id'] ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-division' ) ); ?>"/>
			<input type="hidden" name="division_id" value="<?php echo esc_attr( $division['division_id'] ); ?>"/>

			<div class="field one-column">
				<label for="division-name"><?php esc_html_e( 'Name:', 'sports-bench' ); ?></label>
				<input type="text" id="division-name" name="division_name" value="<?php echo esc_attr( $division['division_name'] ); ?>" />
			</div>

			<div class="field one-column">
				<label for="division-conference"><?php esc_html_e( 'Division/Conference:', 'sports-bench' ); ?></label>
				<select name="division_conference" id="division-conference">
					<?php
					foreach ( $this->division_dropdown as $key => $label ) {
						?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $division['division_conference'], $key ); ?>><?php echo esc_html( $label ); ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<?php
			if ( 'conference' === $division['division_conference'] ) {
				$style = 'style="display:none;';
			} else {
				$style = '';
			}
			?>

			<div id="division-conference-section" class="field one-column" <?php echo esc_html( $style ); ?>>
				<label for="division-conference-id"><?php esc_html_e( 'Conference:', 'sports-bench' ); ?></label>
				<select name="division_conference_id" id="division-conference-id">
					<?php
					foreach ( $this->conferences as $conference ) {
						?>
						<option value="<?php echo esc_attr( $conference['division_id'] ); ?>" <?php selected( $division['division_conference_id'], $conference['division_id'] ); ?>><?php echo esc_html( $conference['division_name'] ); ?></option>
						<?php
					}
					?>
				</select>
			</div>

			<div class="field one-column">
				<label for="division-color"><?php esc_html_e( 'Color:', 'sports-bench' ); ?></label>
				<input type="text" id="division-color" name="division_color" class="cpa-color-picker" value="<?php echo esc_attr( $division['division_color'] ); ?>" />
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</form>
		<?php
	}

	/**
	 * Saves the information for the division.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The request array sent from the submitted form.
	 * @return array               The saved division.
	 */
	public function save_division_conference( $request ) {
		global $wpdb;
		$default_division = [
			'division_id'            => '',
			'division_name'          => '',
			'division_conference'    => '',
			'division_conference_id' => '',
			'division_color'         => '',
		];

		if ( isset( $request['nonce'] ) && wp_verify_nonce( $request['nonce'], 'sports-bench-division' ) ) {
			$division = shortcode_atts( $default_division, $request );
			$division = [
				'division_id'            => intval( $division['division_id'] ),
				'division_name'          => stripslashes( $division['division_name'] ),
				'division_conference'    => stripslashes( $division['division_conference'] ),
				'division_conference_id' => $division['division_conference_id'],
				'division_color'         => stripslashes( $division['division_color'] ),
			];

			if ( '' === $division['division_conference_id'] ) {
				$division['division_conference_id'] = null;
			}

			if ( $this->division_exists( $division['division_id'] ) ) {
				$division_object = new Division( $division['division_id'] );
				$division_object->update( $division );
			} else {
				Database::add_row( 'divisions', $division );
			}

			return $division;
		}
	}

	/**
	 * Deletes a given division.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The division to be deleted.
	 */
	public function delete_division( $division_id ) {
		Database::delete_row( 'divisions', [ 'division_id' => $division_id ] );
	}

	/**
	 * Gets the information for a given division.
	 *
	 * @since 2.0.0
	 *
	 * @return array       The information for a division.
	 */
	public function get_division_info() {
		$the_division = new Division( sanitize_text_field( $_GET['division_id'] ) );
		$division = [
			'division_id'            => $the_division->get_division_id(),
			'division_name'          => $the_division->get_division_name(),
			'division_conference'    => $the_division->get_division_conference(),
			'division_conference_id' => $the_division->get_division_conference_id(),
			'division_color'         => $the_division->get_division_color(),
		];

		return $division;
	}

	/**
	 * Gets the division ID to give to a new division.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The division id for the new division.
	 */
	public function get_new_division_id() {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$default_row = Database::get_results( "SELECT * FROM $table ORDER BY division_id DESC LIMIT 1;" );
		if ( $default_row ) {
			return $default_row[0]->division_id + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Checks to see if the division already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the division to check.
	 * @return bool        Whether the division exists or not.
	 */
	public function division_exists( $id ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$check = Database::get_results( "SELECT division_id FROM $table WHERE division_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}
}
