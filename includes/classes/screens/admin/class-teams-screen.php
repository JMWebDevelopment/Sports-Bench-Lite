<?php
/**
 * The file that defines the teams screen class
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
use Sports_Bench\Classes\Base\Team;

/**
 * The teams screen class.
 *
 * This is used for functions for teams admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class TeamsScreen extends Screen {

	/**
	 * Creates the new TeamsScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Displays a list of teams.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the list of teams.
	 */
	public function display_teams_listing() {
		$teams = $this->get_teams();

		if ( $teams ) {
			$html  = '<table class="teams-table form-table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>' . esc_html__( 'Team', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Division/Conference', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Status', 'sports-bench' ) . '</th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Edit Team Column', 'sports-bench' ) . '</span></th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Delete Team Column', 'sports-bench' ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';
			foreach ( $teams as $team ) {
				$html .= '<tr style="border-left: 2px solid ' . $team->get_team_primary_color() . '">';
				$html .= '<td>' . $team->get_team_photo( 'team-logo' ) . ' ' . $team->get_team_name() . '</td>';
				$html .= '<td>' . $team->get_division_name() . '</td>';
				$html .= '<td class="status-column">' . $team->get_team_status() . '</td>';
				$html .= '<td class="edit-column"><a href="' . $this->get_admin_page_link( 'sports-bench-edit-team-form&team_id=' . $team->get_team_id() ) . '" class="button">' . esc_html__( 'Edit', 'sports-bench' ) . '</a></td>';
				$html .= '<td class="delete-column"><a href="' . $this->get_admin_page_link( 'sports-bench-teams&action=delete&team_id=' . $team->get_team_id() ) . '" class="button red">' . esc_html__( 'Delete', 'sports-bench' ) . '</a></td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';

			$html .= '</table>';
		} else {
			$html = '<p>' . esc_html__( 'There are no teams in the database.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Gets a list of teams.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of teams.
	 */
	private function get_teams() {
		global $wpdb;
		$teams      = [];
		$team_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$per_page   = 20;
		$user       = wp_get_current_user();

		if ( isset( $_REQUEST['paged'] ) && $_REQUEST['paged'] > 1 ) {
			$paged = ( intval( $_REQUEST['paged'] ) - 1 ) * $per_page;
		} else {
			$paged = 1;
		}

		if ( 1 === $paged ) {
			$sql_paged = 0;
		} else {
			$sql_paged = $paged;
		}

		if ( $this->is_team_manager() ) {
			$team  = new Team( (int)get_the_author_meta( 'sports_bench_team', $user->ID ) );
			$sql   = $wpdb->prepare( "SELECT team_id FROM $team_table WHERE team_id = %d ORDER BY team_name ASC LIMIT %d OFFSET %d", $team->get_team_id(), $per_page, $sql_paged );
		} else {
			if ( ( isset( $_GET['team_search'] ) && '' !== $_GET['team_search'] ) && ( isset( $_GET['team_active'] ) && '' !== $_GET['team_active'] ) ) {
				$sql = $wpdb->prepare( "SELECT team_id FROM $team_table WHERE team_name = %s AND team_active = %s ORDER BY team_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_search'] ), sanitize_text_field( $_GET['team_active'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['team_search'] )  && '' !== $_GET['team_search'] ) {
				$sql = $wpdb->prepare( "SELECT team_id FROM $team_table WHERE team_name = %s ORDER BY team_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_search'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['team_active'] ) && '' !== $_GET['team_active'] ) {
				$sql = $wpdb->prepare( "SELECT team_id FROM $team_table WHERE team_active = %s ORDER BY team_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_active'] ), $per_page, $sql_paged );
			} else {
				$sql = $wpdb->prepare( "SELECT team_id FROM $team_table ORDER BY team_name ASC LIMIT %d OFFSET %d", $per_page, $sql_paged );
			}
		}

		$teams_data = Database::get_results( $sql );

		if ( $teams_data ) {
			foreach ( $teams_data as $team ) {
				$teams[] = new Team( (int) $team->team_id );
			}
		}

		return $teams;
	}

	/**
	 * Displays the search filters for getting a specific team.
	 *
	 * @since 2.0.0
	 */
	public function display_search_filters() {
		?>
		<div class="search-row clearfix">
			<form action="admin.php?page=sports-bench-teams" method="get">

				<input type="hidden" name="page" value="sports-bench-teams" />

				<div class="search-column">
					<?php
					if ( isset( $_GET['team_search'] ) && '' !== $_GET['team_search'] ) {
						$team_search = sanitize_text_field( $_GET['team_search'] );
					} else {
						$team_search = '';
					}
					?>
					<label for="team_search"><?php esc_html_e( 'Team Name:', 'sports-bench' ); ?></label>
					<input type="text" class="search-input" id="team_search" name="team_search" placeholder="<?php esc_html_e( 'Team', 'sports-bench' ); ?>" value="<?php echo esc_attr( $team_search ); ?>" />
				</div>

				<div class="search-column">
					<label for="team-active"><?php esc_html_e( 'Team Status:', 'sports-bench' ); ?></label>
					<select id="team-active" class="search-input" name="team_active">
						<option value=""><?php esc_html_e( 'All Teams', 'sports-bench' ); ?></option>
						<option value="active" <?php if ( isset( $_GET['team_active'] ) && 'active' === $_GET['team_active'] ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Active', 'sports-bench' ); ?></option>
						<option value="inactive" <?php if ( isset( $_GET['team_active'] ) && 'inactive' === $_GET['team_active'] ) { echo 'selected="selected"'; } ?>><?php esc_html_e( 'Inactive', 'sports-bench' ); ?></option>
					</select>
				</div>

				<div class="search-column">
					<input type="submit" value="<?php esc_html_e( 'Search', 'sports-bench' ); ?>" />
				</div>

				<div class="search-column">
					<input id="clear-team-search" type="reset" value="<?php esc_html_e( 'Clear', 'sports-bench' ); ?>" />
				</div>


			</form>
		</div>
		<?php
	}

	/**
	 * Displays the pagination for the list of teams.
	 *
	 * @since 2.0.0
	 */
	public function display_pagination() {
		global $wpdb;
		$html       = '';
		$per_page   = 20;
		$team_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';

		if ( isset( $_REQUEST['paged'] ) && $_REQUEST['paged'] > 1 ) {
			$paged = ( intval( $_REQUEST['paged'] ) - 1 ) * $per_page;
		} else {
			$paged = 1;
		}

		if ( 1 === $paged ) {
			$sql_paged = 0;
		} else {
			$sql_paged = $paged;
		}
		$url = '';

		if ( ( isset( $_GET['team_search'] ) && '' !== $_GET['team_search'] ) && ( isset( $_GET['team_active'] ) && '' !== $_GET['team_active'] ) ) {
			$sql = $wpdb->prepare( "SELECT team_id AS num_teams FROM $team_table WHERE team_name = %s AND team_active = %s ORDER BY team_name ASC", sanitize_text_field( $_GET['team_search'] ), sanitize_text_field( $_GET['team_active'] ) );
			$url .= '&team_search=' . sanitize_text_field( $_GET['team_search'] ) . '&team_active=' . sanitize_text_field( $_GET['team_active'] );
		} elseif ( isset( $_GET['team_search'] )  && '' !== $_GET['team_search'] ) {
			$sql = $wpdb->prepare( "SELECT team_id AS num_teams FROM $team_table WHERE team_name = %s ORDER BY team_name ASC", sanitize_text_field( $_GET['team_search'] ) );
			$url .= '&team_search=' . sanitize_text_field( $_GET['team_search'] );
		} elseif ( isset( $_GET['team_active'] ) && '' !== $_GET['team_active'] ) {
			$sql = $wpdb->prepare( "SELECT team_id AS num_teams FROM $team_table WHERE team_active = %s ORDER BY team_name ASC", sanitize_text_field( $_GET['team_active'] ) );
			$url .= '&team_active=' . sanitize_text_field( $_GET['team_active'] );
		} else {
			$sql = "SELECT team_id FROM $team_table ORDER BY team_name ASC";
		}
		$num_teams   = Database::get_results( $sql );
		$num_teams   = count( $num_teams );
		$total_pages = ceil( $num_teams / $per_page );

		if ( isset( $_REQUEST['paged'] ) ) {
			$current_page = intval( $_REQUEST['paged'] );
		} else {
			$current_page = 1;
		}
		?>
		<div class="pagination-link">
			<?php
			if ( $current_page + 1 <= $total_pages ) {
				?>
				<a href="?page=sports-bench-teams&paged=<?php echo esc_attr( $current_page + 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black next">
					<span class="dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page + 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<form action="admin.php?page=sports-bench-teams" method="get">

			<input type="hidden" name="page" value="sports-bench-teams" />

			<?php
			if ( isset( $_GET['team_active'] ) && '' !== $_GET['team_active'] ) {
				?>
				<input type="hidden" name="team_active" value="<?php echo esc_attr( sanitize_text_field( $_GET['team_active'] ) ); ?>" />
				<?php
			}
			?>

			<?php
			if ( isset( $_GET['team_search'] ) && '' !== $_GET['team_search'] ) {
				?>
				<input type="hidden" name="team_search" value="<?php echo esc_attr( sanitize_text_field( $_GET['team_search'] ) ); ?>" />
				<?php
			}
			?>

			<div class="pagination-link">

				<label for="go-to-page" class="screen-reader-text"><?php esc_html_e( 'Go to page number:', 'sports-bench' ); ?></label>

				<input type="number" id="go-to-page" name="paged" min="0" max="<?php echo esc_attr( $total_pages ); ?>" value="<?php echo esc_attr( $current_page ); ?>" />

				<input type="submit" value="<?php esc_html_e( 'Go', 'sports-bench' ); ?>" />

			</div>

		</form>

		<div class="pagination-link">
			<?php
			if ( $current_page > 1 ) {
				?>
				<a href="?page=sports-bench-teams&paged=<?php echo esc_attr( $current_page - 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black previous">
					<span class="dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page - 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<?php
	}

	/**
	 * Gets the team ID to give to a new team.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The team id for the new team.
	 */
	public function get_new_team_id() {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$default_row = Database::get_results( "SELECT * FROM $table ORDER BY team_id DESC LIMIT 1;" );
		if ( $default_row ) {
			return $default_row[0]->team_id + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Checks to see if the team already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the team to check.
	 * @return bool        Whether the team exists or not.
	 */
	public function team_exists( $id ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$check = Database::get_results( "SELECT team_id FROM $table WHERE team_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Displays the fields for a new team.
	 *
	 * @since 2.0.0
	 */
	public function display_new_team_fields() {
		$team_id = $this->get_new_team_id();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-team-form&team_id=<?php echo esc_attr( $team_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-team' ) ); ?>"/>
			<input type="hidden" name="id" value="<?php echo esc_attr( $team_id ); ?>"/>

			<div class="form-container">

				<?php
				/**
				 * Fires to show the fields for a game scoreline.
				 *
				 * @since 2.0.0
				 */
				do_action( 'sports_bench_new_team_fields' );
				?>

			</div>
		</form>
		<?php
	}

	/**
	 * Displays all of the fields for the edit team screen.
	 *
	 * @since 2.0.0
	 *
	 * @param array $team      The information for the team.
	 */
	public function display_team_fields( $team ) {
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-team-form&team_id=<?php echo esc_attr( $team['team_id'] ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-team' ) ); ?>"/>
			<input type="hidden" name="id" value="<?php echo esc_attr( $team['team_id'] ); ?>"/>

			<div class="form-container">

				<?php
				/**
				 * Fires to show the fields for a game scoreline.
				 *
				 * @since 2.0.0
				 *
				 * @param array $team      The array of information for the team.
				 */

				do_action( 'sports_bench_edit_team_fields', $team );
				?>

			</div>
		</form>
		<?php
	}

	/**
	 * Returns a list of statuses a team can have.
	 *
	 * @since 2.0.0
	 *
	 * @return array       List of statuses a team can have.
	 */
	public function get_team_statuses() {
		return [
			'active'   => esc_html__( 'Active', 'sports-bench' ),
			'inactive' => esc_html__( 'Inactive', 'sports-bench' ),
		];
	}

	/**
	 * Gets a list of divisions and conferences.
	 *
	 * @since 2.0.0
	 *
	 * @return array      List of divisions and conferences.
	 */
	public function get_divisions_list() {
		global $wpdb;
		$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$sql        = "SELECT t1.division_id AS conference_id, t1.division_name AS conference_name, t2.division_id AS division_id, t2.division_name AS division_name, t2.division_conference_id AS division_conference_id FROM $table_name AS t1 LEFT JOIN $table_name AS t2 ON t1.division_id = t2.division_conference_id WHERE t2.division_id IS NOT NULL ORDER BY t1.division_id";
		$divs       = Database::get_results( $sql );
		$conference = '';
		$div_confs  = [];
		if ( $divs ) {
			foreach ( $divs as $div ) {
				if ( null === $div->division_name ) {
					continue;
				}
				if ( $div->conference_name !== $conference ) {
					$div_array = array(
						'division_id'   => $div->conference_id,
						'division_name' => $div->conference_name,
					);
					array_push( $div_confs, $div_array );
					$conference = $div->conference_name;
				}
				$div_array = array(
					'division_id'   => $div->division_id,
					'division_name' => '&nbsp; &nbsp; &nbsp; &nbsp;' . $div->division_name,
				);
				array_push( $div_confs, $div_array );
			}
		} else {
			$sql       = "SELECT * FROM $table_name";
			$divs      = Database::get_results( $sql );
			$div_confs = [];
			foreach ( $divs as $div ) {
				$div_array = array(
					'division_id'   => $div->division_id,
					'division_name' => $div->division_name,
				);
				array_push( $div_confs, $div_array );
			}
		}

		return $div_confs;
	}

	/**
	 * Saves the information for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The array of information from the submitted form.
	 * @return array              The saved team.
	 */
	public function save_team( $request ) {

		/**
		 * Saves the information for a team.
		 *
		 * @since 2.0.0
		 *
		 * @param array $request      The array of information from the submitted form.
		 * @return array              The saved team.
		 */
		return apply_filters( 'sports_bench_save_team', $request );
	}

	/**
	 * Gets the information for the selected team.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The array of information for the team.
	 */
	public function get_team_info() {
		$the_team = new Team( (int) intval( $_GET['team_id'] ) );

		/**
		 * Gets the information for a team.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The incoming information for the team.
		 * @param Team   $the_team      The current team object.
		 * @return array                The information for a team.
		 */
		$team = apply_filters( 'sports_bench_get_admin_team_info', '', $the_team );

		return $team;
	}

	/**
	 * Deletes a given team.
	 *
	 * @since 2.0.0
	 *
	 * @param int $team_id      The team to be deleted.
	 */
	public function delete_team( $team_id ) {
		Database::delete_row( 'teams', [ 'team_id' => $team_id ] );
	}

	/**
	 * Adds a team to the team taxonomy if they aren't already there.
	 *
	 * @since 2.0.0
	 *
	 * @param array $team      The array of information for the team.
	 */
	private function add_to_team_taxonomy( $team ) {
		$id_found = false;

		$existing_terms = get_terms(
			'sports-bench-post-teams',
			[
				'hide_empty' => false,
			]
		);

		foreach ( $existing_terms as $term ) {
			if ( $term->slug === $team['team_slug'] ) {
				$id_found = true;
			}
		}

		if ( false === $id_found ) {
			wp_insert_term(
				$team['team_name'],
				'sports-bench-post-teams',
				[
					'slug' => $team['team_slug'],
				]
			);
		}
	}

	/**
	 * Displays the fields for a new team.
	 *
	 * @since 2.0.0
	 */
	public function sports_bench_do_default_new_team_fields() {
		$team_id = $this->get_new_team_id();
		?>
		<div class="form-left">

			<div class="team-name full-width">
				<label for="team-name"><?php esc_html_e( 'Team Name:', 'sports-bench' ); ?></label>
				<input type="text" id="team-name" name="team_name" />
			</div>

			<h2><?php esc_html_e( 'Team Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="team-location"><?php esc_html_e( 'Team Location:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location" name="team_location" />
				</div>

				<div class="field one-column">
					<label for="team-nickname"><?php esc_html_e( 'Team Nickname:', 'sports-bench' ); ?></label>
					<input type="text" id="team-nickname" name="team_nickname" />
				</div>

				<div class="field one-column">
					<label for="team-abbreviation"><?php esc_html_e( 'Team Abbreviation:', 'sports-bench' ); ?></label>
					<input type="text" id="team-abbreviation" name="team_abbreviation" />
				</div>

				<div class="field one-column">
					<label for="team-status"><?php esc_html_e( 'Team Status:', 'sports-bench' ); ?></label>
					<select id="team-status" name="team_active">
						<option value=""><?php esc_html_e( 'Select a Status', 'sports-bench' ); ?></option>
						<?php
						$options = $this->get_team_statuses();
						if ( $options ) {
							foreach ( $options as $key => $label ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

				<div class="field one-column">
					<label for="team-head-coach"><?php esc_html_e( 'Team Head Coach:', 'sports-bench' ); ?></label>
					<input type="text" id="team-head-coach" name="team_head_coach" />
				</div>

				<div class="field one-column">
					<label for="team-division"><?php esc_html_e( 'Conference/Division:', 'sports-bench' ); ?></label>
					<select id="team-division" name="team_division">
						<option value=""><?php esc_html_e( 'Select a Conference/Division', 'sports-bench' ); ?></option>
						<?php
						$options = $this->get_divisions_list();
						if ( $options ) {
							foreach ( $options as $option ) {
								?>
								<option value="<?php echo esc_attr( $option['division_id'] ); ?>"><?php echo esc_html( $option['division_name'] ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

				<div class="field one-column">
					<label for="team-priary-color"><?php esc_html_e( 'Primary Color:', 'sports-bench' ); ?></label>
					<input type="text" name="team_primary_color" value="" class="cpa-color-picker" />
				</div>

				<div class="field one-column">
					<label for="team-secondary-color"><?php esc_html_e( 'Secondary Color:', 'sports-bench' ); ?></label>
					<input type="text" name="team_secondary_color" value="" class="cpa-color-picker" />
				</div>

			</div>

			<h2><?php esc_html_e( 'Stadium Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="team-stadium"><?php esc_html_e( 'Stadium Name:', 'sports-bench' ); ?></label>
					<input type="text" id="team-stadium" name="team_stadium" />
				</div>

				<div class="field one-column">
					<label for="team-stadium-capacity"><?php esc_html_e( 'Stadium Capacity:', 'sports-bench' ); ?></label>
					<input type="text" id="team-stadium-capacity" name="team_stadium_capacity" />
				</div>

				<div class="field one-column">
					<label for="team-location-one"><?php esc_html_e( 'Stadium Address Line One:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location-one" name="team_location_line_one" />
				</div>

				<div class="field one-column">
					<label for="team-location-two"><?php esc_html_e( 'Stadium Address Line Two:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location-two" name="team_location_line_two" />
				</div>

				<div class="field one-column">
					<label for="team-city"><?php esc_html_e( 'Stadium City:', 'sports-bench' ); ?></label>
					<input type="text" id="team-city" name="team_city" />
				</div>

				<div class="field one-column">
					<label for="team-state"><?php esc_html_e( 'Stadium State/Province:', 'sports-bench' ); ?></label>
					<input type="text" id="team-division" name="team_division" />
				</div>

				<div class="field one-column">
					<label for="team-zip-code"><?php esc_html_e( 'Stadium ZIP Code:', 'sports-bench' ); ?></label>
					<input type="text" id="team-zip-code" name="team_location_zip_code" />
				</div>

				<div class="field one-column">
					<label for="team-country"><?php esc_html_e( 'Stadium Country:', 'sports-bench' ); ?></label>
					<input type="text" id="team-country" name="team_country" />
				</div>

			</div>

			</div>

			<div class="form-right">
			<div class="form-right-inner">
				<div class="photo-field">
					<label for="team-logo"><?php esc_html_e( 'Team Logo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-logo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo"><br />
					<img class="user-preview-image" id="logo" width="100%" style="margin-bottom: 10px; display: none;" src="" alt="blank space">
					<input type="hidden" name="team_logo" id="team-logo" />
					<button class="button-primary" id="uploadlogo"><?php esc_html_e( 'Upload Logo', 'sports-bench' ); ?></button>
					<button class="button" id="removelogo"><?php esc_html_e( 'Remove Logo', 'sports-bench' ); ?></button>
				</div>

				<div class="photo-field">
					<label for="team-photo"><?php esc_html_e( 'Team Photo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-photo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo"><br />
					<img class="user-preview-image" id="photo" width="100%" style="margin-bottom: 10px; display: none;" src="" alt="blank space">
					<input type="hidden" name="team_photo" id="team-photo" />
					<button class="button-primary" id="uploadphoto"><?php esc_html_e( 'Upload Photo', 'sports-bench' ); ?></button>
					<button class="button" id="removephoto"><?php esc_html_e( 'Remove Photo', 'sports-bench' ); ?></button>
				</div>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
			</div>
		<?php
	}

	/**
	 * Displays all of the fields for the edit team screen.
	 *
	 * @since 2.0.0
	 *
	 * @param array $team      The information for the team.
	 */
	public function sports_bench_do_default_team_fields( $team ) {
		?>
		<div class="form-left">

			<div class="team-name full-width">
				<label for="team-name"><?php esc_html_e( 'Team Name:', 'sports-bench' ); ?></label>
				<input type="text" id="team-name" name="team_name" value="<?php echo esc_attr( $team['team_name'] ); ?>" />
			</div>

			<h2><?php esc_html_e( 'Team Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="team-location"><?php esc_html_e( 'Team Location:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location" name="team_location" value="<?php echo esc_attr( $team['team_location'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-nickname"><?php esc_html_e( 'Team Nickname:', 'sports-bench' ); ?></label>
					<input type="text" id="team-nickname" name="team_nickname" value="<?php echo esc_attr( $team['team_nickname'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-abbreviation"><?php esc_html_e( 'Team Abbreviation:', 'sports-bench' ); ?></label>
					<input type="text" id="team-abbreviation" name="team_abbreviation" value="<?php echo esc_attr( $team['team_abbreviation'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-status"><?php esc_html_e( 'Team Status:', 'sports-bench' ); ?></label>
					<select id="team-status" name="team_active">
						<option value=""><?php esc_html_e( 'Select a Status', 'sports-bench' ); ?></option>
						<?php
						$options = $this->get_team_statuses();
						if ( $options ) {
							foreach ( $options as $key => $label ) {
								?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $team['team_active'], $key ); ?>><?php echo esc_html( $label ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

				<div class="field one-column">
					<label for="team-head-coach"><?php esc_html_e( 'Team Head Coach:', 'sports-bench' ); ?></label>
					<input type="text" id="team-head-coach" name="team_head_coach" value="<?php echo esc_attr( $team['team_head_coach'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-division"><?php esc_html_e( 'Conference/Division:', 'sports-bench' ); ?></label>
					<select id="team-division" name="team_division">
						<option value=""><?php esc_html_e( 'Select a Conference/Division', 'sports-bench' ); ?></option>
						<?php
						$options = $this->get_divisions_list();
						if ( $options ) {
							foreach ( $options as $option ) {
								?>
								<option value="<?php echo esc_attr( $option['division_id'] ); ?>" <?php selected( $team['team_division'], $option['division_id'] ); ?>><?php echo esc_html( $option['division_name'] ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

				<div class="field one-column">
					<label for="team-priary-color"><?php esc_html_e( 'Primary Color:', 'sports-bench' ); ?></label>
					<input type="text" name="team_primary_color" value="<?php echo esc_attr( $team['team_primary_color'] ); ?>" class="cpa-color-picker" />
				</div>

				<div class="field one-column">
					<label for="team-secondary-color"><?php esc_html_e( 'Secondary Color:', 'sports-bench' ); ?></label>
					<input type="text" name="team_secondary_color" value="<?php echo esc_attr( $team['team_secondary_color'] ); ?>" class="cpa-color-picker" />
				</div>

			</div>

			<h2><?php esc_html_e( 'Stadium Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="team-stadium"><?php esc_html_e( 'Stadium Name:', 'sports-bench' ); ?></label>
					<input type="text" id="team-stadium" name="team_stadium" value="<?php echo esc_attr( $team['team_stadium'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-stadium-capacity"><?php esc_html_e( 'Stadium Capacity:', 'sports-bench' ); ?></label>
					<input type="text" id="team-stadium-capacity" name="team_stadium_capacity" value="<?php echo esc_attr( $team['team_stadium_capacity'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-location-one"><?php esc_html_e( 'Stadium Address Line One:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location-one" name="team_location_line_one" value="<?php echo esc_attr( $team['team_location_line_one'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-location-two"><?php esc_html_e( 'Stadium Address Line Two:', 'sports-bench' ); ?></label>
					<input type="text" id="team-location-two" name="team_location_line_two" value="<?php echo esc_attr( $team['team_location_line_two'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-city"><?php esc_html_e( 'Stadium City:', 'sports-bench' ); ?></label>
					<input type="text" id="team-city" name="team_city" value="<?php echo esc_attr( $team['team_city'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-state"><?php esc_html_e( 'Stadium State/Province:', 'sports-bench' ); ?></label>
					<input type="text" id="team-division" name="team_state" value="<?php echo esc_attr( $team['team_state'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-zip-code"><?php esc_html_e( 'Stadium ZIP Code:', 'sports-bench' ); ?></label>
					<input type="text" id="team-zip-code" name="team_location_zip_code" value="<?php echo esc_attr( $team['team_location_zip_code'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="team-country"><?php esc_html_e( 'Stadium Country:', 'sports-bench' ); ?></label>
					<input type="text" id="team-country" name="team_location_country" value="<?php echo esc_attr( $team['team_location_country'] ); ?>" />
				</div>

			</div>

			</div>

			<div class="form-right">
			<div class="form-right-inner">
				<div class="photo-field">
					<label for="team-logo"><?php esc_html_e( 'Team Logo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-logo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo" <?php if ( '' !== $team['team_logo'] ) { echo 'style="display: none;"'; } ?> /><br />
					<img class="user-preview-image" id="logo" width="100%" style="margin-bottom: 10px; <?php if ( '' === $team['team_logo'] ) { echo esc_attr( 'display: none;' ); } ?>" src="<?php echo esc_attr( $team['team_logo'] ); ?>" alt="blank space">
					<input type="hidden" name="team_logo" id="team-logo" value="<?php echo esc_attr( $team['team_logo'] ); ?>" />
					<button class="button-primary" id="uploadlogo"><?php esc_html_e( 'Upload Logo', 'sports-bench' ); ?></button>
					<button class="button" id="removelogo"><?php esc_html_e( 'Remove Logo', 'sports-bench' ); ?></button>
				</div>

				<div class="photo-field">
					<label for="team-photo"><?php esc_html_e( 'Team Photo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-photo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo" <?php if ( '' !== $team['team_photo'] ) { echo 'style="display: none;"'; } ?> /><br />
					<img class="user-preview-image" id="photo" width="100%" style="margin-bottom: 10px; <?php if ( '' === $team['team_photo'] ) { echo esc_attr( 'display: none;' ); } ?>" src="<?php echo esc_attr( $team['team_photo'] ); ?>" alt="blank space">
					<input type="hidden" name="team_photo" id="team-photo" value="<?php echo esc_attr( $team['team_photo'] ); ?>" />
					<button class="button-primary" id="uploadphoto"><?php esc_html_e( 'Upload Photo', 'sports-bench' ); ?></button>
					<button class="button" id="removephoto"><?php esc_html_e( 'Remove Photo', 'sports-bench' ); ?></button>
				</div>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
			</div>
		<?php
	}

	/**
	 * Gets the information for a team for the edit team screen.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The incoming information for the team.
	 * @param Team   $the_team      The current team object.
	 * @return array                The information for the team.
	 */
	public function sports_bench_do_get_team_admin_info( $html, $the_team ) {
		$team = [
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

		return $team;
	}

	/**
	 * Saves the new team information
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The submitted information for the team.
	 * @return array              The information for the team.
	 */
	public function sports_bench_do_save_team( $request ) {
		global $wpdb;
		$default_team = [
			'team_id'                => '',
			'team_name'              => '',
			'team_location'          => '',
			'team_nickname'          => '',
			'team_abbreviation'      => '',
			'team_active'            => '',
			'team_location_line_one' => '',
			'team_location_line_two' => '',
			'team_city'              => '',
			'team_state'             => '',
			'team_location_country'  => '',
			'team_location_zip_code' => '',
			'team_stadium'           => '',
			'team_stadium_capacity'  => '',
			'team_head_coach'        => '',
			'team_logo'              => '',
			'team_photo'             => '',
			'team_division'          => 0,
			'team_primary_color'     => '',
			'team_secondary_color'   => '',
			'team_slug'              => '',
		];

		if ( isset( $request['nonce'] ) && wp_verify_nonce( $request['nonce'], 'sports-bench-team' ) ) {
			$team = shortcode_atts( $default_team, $request );
			$team = [
				'team_id'                => intval( $team['team_id'] ),
				'team_name'              => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_name'] ) ) ),
				'team_location'          => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_location'] ) ) ),
				'team_nickname'          => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_nickname'] ) ) ),
				'team_abbreviation'      => wp_filter_nohtml_kses( sanitize_text_field( $team['team_abbreviation'] ) ),
				'team_active'            => wp_filter_nohtml_kses( sanitize_text_field( $team['team_active'] ) ),
				'team_location_line_one' => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_location_line_one'] ) ) ),
				'team_location_line_two' => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_location_line_two'] ) ) ),
				'team_city'              => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_city'] ) ) ),
				'team_state'             => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_state'] ) ) ),
				'team_location_country'  => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_location_country'] ) ) ),
				'team_location_zip_code' => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_location_zip_code'] ) ) ),
				'team_stadium'           => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_stadium'] ) ) ),
				'team_stadium_capacity'  => intval( $team['team_stadium_capacity'] ),
				'team_head_coach'        => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $team['team_head_coach'] ) ) ),
				'team_logo'              => wp_filter_nohtml_kses( sanitize_text_field( $team['team_logo'] ) ),
				'team_photo'             => wp_filter_nohtml_kses( sanitize_text_field( $team['team_photo'] ) ),
				'team_division'          => intval( $team['team_division'] ),
				'team_primary_color'     => wp_filter_nohtml_kses( sanitize_text_field( $team['team_primary_color'] ) ),
				'team_secondary_color'   => wp_filter_nohtml_kses( sanitize_text_field( $team['team_secondary_color'] ) ),
				'team_slug'              => wp_filter_nohtml_kses( sanitize_text_field( $team['team_slug'] ) ),
			];

			$table_name        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
			$slug              = strtolower( $team['team_name'] );
			$team['team_slug'] = preg_replace( "/[\s_]/", "-", $slug );
			$slug_test         = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE team_slug = %s", $team['team_slug'] ) );

			$i                 = 1;
			while ( $slug_test !== [] && $team['team_slug'] !== $slug_test[0]->team_slug ) {
				$i++;
				$slug      = $team['team_slug'] . '-' . $i;
				$slug_test = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE team_slug = %s", $team['team_slug'] ) );
				if ( $slug_test ==  [] ) {
					$team['team_slug'] = $team['team_slug'] . '-' . $i;
					break;
				}
			}

			if ( $this->team_exists( $team['team_id'] ) ) {
				$team_object = new Team( (int) $team['team_id'] );
				$team_object->update( $team );
			} else {
				Database::add_row( 'teams', $team );
				$this->add_to_team_taxonomy( $team );
			}

			return $team;
		}
	}

	/**
	 * Checks to see if a user can edit the current team.
	 *
	 * @since 2.2
	 *
	 * @param int $current_team      The team id for the current team.
	 * @return boolean               Whether the user can edit the current team.
	 */
	public function user_can_edit_team( $current_team ) {
		$user = wp_get_current_user();
		if ( $this->is_team_manager() ) {
			$team = new Team( (int)get_the_author_meta( 'sports_bench_team', $user->ID ) );

			if ( $current_team === $team->get_team_id() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

}
