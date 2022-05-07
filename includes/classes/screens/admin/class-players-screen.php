<?php
/**
 * The file that defines the players screen class
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
use Sports_Bench\Classes\Base\Player;

/**
 * The players screen class.
 *
 * This is used for functions for players admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class PlayersScreen extends Screen {

	/**
	 * Creates the new PlayersScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Displays a list of players.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the list of players.
	 */
	public function display_players_listing() {
		$players = $this->get_players();

		if ( $players ) {
			$html  = '<table class="players-table form-table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>' . esc_html__( 'Player', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Team', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Position', 'sports-bench' ) . '</th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Edit Player Column', 'sports-bench' ) . '</span></th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Delete Player Column', 'sports-bench' ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';
			foreach ( $players as $player ) {
				if ( $player->get_team() ) {
					$team      = $player->get_team();
					$team_name = $team->get_team_name();
				} else {
					$team_name = __( 'Free Agent', 'sports-bench' );
				}
				$html .= '<tr>';
				$html .= '<td>' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . '</td>';
				$html .= '<td>' . $team_name . '</td>';
				$html .= '<td class="status-column">' . $player->get_player_position() . '</td>';
				$html .= '<td class="edit-column"><a href="' . $this->get_admin_page_link( 'sports-bench-edit-player-form&player_id=' . $player->get_player_id() ) . '" class="button">' . esc_html__( 'Edit', 'sports-bench' ) . '</a></td>';
				$html .= '<td class="delete-column"><a href="' . $this->get_admin_page_link( 'sports-bench-players&action=delete&player_id=' . $player->get_player_id() ) . '" class="button red">' . esc_html__( 'Delete', 'sports-bench' ) . '</a></td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';

			$html .= '</table>';
		} else {
			$html = '<p>' . esc_html__( 'There are no players in the database.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Gets a list of players.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of players.
	 */
	private function get_players() {
		global $wpdb;
		$players       = [];
		$players_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$per_page      = 20;
		$user          = wp_get_current_user();

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
			if ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND player_first_name = %s AND player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND  player_first_name = %s AND player_last_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND  player_first_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND  player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field(  $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND  player_first_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field( $_GET['player_first_name'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d AND  player_last_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d",$team->get_team_id(), sanitize_text_field( $_GET['player_last_name'] ), $per_page, $sql_paged );
			} else {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d", $team->get_team_id(), $per_page, $sql_paged );
			}
		} else {
			if ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND player_last_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_first_name'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_last_name = %s ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['player_last_name'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d ORDER BY player_last_name ASC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team'] ), $per_page, $sql_paged );
			} else {
				$sql = $wpdb->prepare( "SELECT player_id FROM $players_table ORDER BY player_last_name ASC LIMIT %d OFFSET %d", $per_page, $sql_paged );
			}
		}

		$players_data = Database::get_results( $sql );

		if ( $players_data ) {
			foreach ( $players_data as $player ) {
				$players[] = new Player( (int) $player->player_id );
			}
		}

		return $players;
	}

	/**
	 * Displays the search filters for getting a specific player.
	 *
	 * @since 2.0.0
	 */
	public function display_search_filters() {
		$teams = $this->get_all_teams();
		?>
		<div class="search-row clearfix">
			<form action="admin.php?page=sports-bench-players" method="get">

				<input type="hidden" name="page" value="sports-bench-players" />

				<div class="search-column">
					<?php
					if ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) {
						$player_first_name = sanitize_text_field( $_GET['player_first_name'] );
					} else {
						$player_first_name = '';
					}
					?>
					<label for="player_first_name"><?php esc_html_e( 'First Name:', 'sports-bench' ); ?></label>
					<input type="text" class="search-input" id="player_first_name" name="player_first_name" placeholder="<?php esc_html_e( 'First Name', 'sports-bench' ); ?>" value="<?php echo esc_attr( $player_first_name ); ?>" />
				</div>

				<div class="search-column">
					<?php
					if ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) {
						$player_last_name = sanitize_text_field( $_GET['player_last_name'] );
					} else {
						$player_last_name = '';
					}
					?>
					<label for="player_last_name"><?php esc_html_e( 'Last Name:', 'sports-bench' ); ?></label>
					<input type="text" class="search-input" id="player_last_name" name="player_last_name" placeholder="<?php esc_html_e( 'Last Name', 'sports-bench' ); ?>" value="<?php echo esc_attr( $player_last_name ); ?>" />
				</div>

				<div class="search-column">
					<label for="team"><?php esc_html_e( 'Team:', 'sports-bench' ); ?></label>
					<select id="team" class="search-input" name="team">
						<option value=""><?php esc_html_e( 'All Teams', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								if ( isset( $_GET['team'] ) ) {
									$selected = selected( sanitize_text_field( $_GET['team'] ), $team->get_team_id(), false );
								} else {
									$selected = '';
								}
								?>
								<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php echo esc_html( $selected ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
								<?php
							}
						}
						?>
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
	 * Displays the pagination for the list of players.
	 *
	 * @since 2.0.0
	 */
	public function display_pagination() {
		global $wpdb;
		$html          = '';
		$per_page      = 20;
		$players_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';

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

		if ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ) );
			$url = '&player_first_name=' . sanitize_text_field( $_GET['player_first_name'] ) . '&player_last_name=' . sanitize_text_field( $_GET['player_last_name'] ) . '&team=' . sanitize_text_field( $_GET['team'] );
		} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND player_last_name = %s ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['player_last_name'] ) );
			$url = '&player_first_name=' . sanitize_text_field( $_GET['player_first_name'] ) . '&player_last_name=' . sanitize_text_field( $_GET['player_last_name'] );
		} elseif ( ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s AND team_id = %d ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_first_name'] ), sanitize_text_field( $_GET['team'] ) );
			$url = '&player_first_name=' . sanitize_text_field( $_GET['player_first_name'] ) . '&team=' . sanitize_text_field( $_GET['team'] );
		} elseif ( ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) && ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_last_name = %s AND team_id = %d ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_last_name'] ), sanitize_text_field( $_GET['team'] ) );
			$url = '&player_last_name=' . sanitize_text_field( $_GET['player_last_name'] ) . '&team=' . sanitize_text_field( $_GET['team'] );
		} elseif ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_first_name = %s ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_first_name'] ) );
			$url = '&player_first_name=' . sanitize_text_field( $_GET['player_first_name'] );
		} elseif ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE player_last_name = %s ORDER BY player_last_name ASC", sanitize_text_field( $_GET['player_last_name'] ) );
			$url = '&player_last_name=' . sanitize_text_field( $_GET['player_last_name'] );
		} elseif ( isset( $_GET['team'] ) && '' !== sanitize_text_field( $_GET['team'] ) ) {
			$sql = $wpdb->prepare( "SELECT player_id FROM $players_table WHERE team_id = %d ORDER BY player_last_name ASC", sanitize_text_field( $_GET['team'] ) );
			$url = '&team=' . sanitize_text_field( $_GET['team'] );
		} else {
			$sql = "SELECT player_id FROM $players_table ORDER BY player_last_name ASC";
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
				<a href="?page=sports-bench-players&paged=<?php echo esc_attr( $current_page + 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black next">
					<span class="dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page + 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<form action="admin.php?page=sports-bench-players" method="get">

			<input type="hidden" name="page" value="sports-bench-players" />

			<?php
			if ( isset( $_GET['player_first_name'] ) && '' !== $_GET['player_first_name'] ) {
				?>
				<input type="hidden" name="player_first_name" value="<?php echo esc_attr( sanitize_text_field( $_GET['player_first_name'] ) ); ?>" />
				<?php
			}
			?>

			<?php
			if ( isset( $_GET['player_last_name'] ) && '' !== $_GET['player_last_name'] ) {
				?>
				<input type="hidden" name="player_last_name" value="<?php echo esc_attr( sanitize_text_field( $_GET['player_last_name'] ) ); ?>" />
				<?php
			}
			?>

			<?php
			if ( isset( $_GET['team'] ) && '' !== $_GET['team'] ) {
				?>
				<input type="hidden" name="team" value="<?php echo esc_attr( sanitize_text_field( $_GET['team'] ) ); ?>" />
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
				<a href="?page=sports-bench-players&paged=<?php echo esc_attr( $current_page - 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black previous">
					<span class="dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page - 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<?php
	}

	/**
	 * Gets the player ID to give to a new player.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The player id for the new player.
	 */
	public function get_new_player_id() {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$default_row = Database::get_results( "SELECT * FROM $table ORDER BY player_id DESC LIMIT 1;" );
		if ( $default_row ) {
			return $default_row[0]->player_id + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Checks to see if the player already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the player to check.
	 * @return bool        Whether the player exists or not.
	 */
	public function player_exists( $id ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$check = Database::get_results( "SELECT player_id FROM $table WHERE player_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Gets all of the teams in the database.
	 *
	 * @since 2.0.0
	 *
	 * @return array      A list of all teams.
	 */
	public function get_all_teams() {
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$teams = [];

		$teams_list = Database::get_results( "SELECT team_id FROM $table ORDER BY team_name ASC;" );

		if ( $teams_list ) {
			foreach ( $teams_list as $team ) {
				$teams[] = new Team( (int) $team->team_id );
			}
		}

		return $teams;
	}

	/**
	 * Displays the fields for a new player.
	 *
	 * @since 2.0.0
	 */
	public function display_new_player_fields() {
		$player_id = $this->get_new_player_id();
		$teams     = $this->get_all_teams();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-player-form&player_id=<?php echo esc_attr( $player_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-player' ) ); ?>"/>
			<input type="hidden" name="id" value="<?php echo esc_attr( $player_id ); ?>"/>

			<div class="form-container">

				<?php
				/**
				 * Fires to show the fields for a player.
				 *
				 * @since 2.0.0
				 */
				do_action( 'sports_bench_new_player_fields' );
				?>

			</div>
		</form>
		<?php
	}

	/**
	 * Displays all of the fields for the edit player screen.
	 *
	 * @since 2.0.0
	 *
	 * @param array $player      The information for the player.
	 */
	public function display_player_fields( $player ) {
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-player-form&player_id=<?php echo esc_attr( $player['player_id'] ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-player' ) ); ?>"/>
			<input type="hidden" name="player_id" value="<?php echo esc_attr( $player['player_id'] ); ?>"/>

			<div class="form-container">

				<?php
				/**
				 * Fires to show the fields for a game scoreline.
				 *
				 * @since 2.0.0
				 *
				 * @param array $player      The array of information for the team.
				 */

				do_action( 'sports_bench_edit_player_fields', $player );
				?>

			</div>
		</form>
		<?php
	}

	/**
	 * Saves the information for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The array of information from the submitted form.
	 * @return array              The saved player.
	 */
	public function save_player( $request ) {

		/**
		 * Saves the information for a player.
		 *
		 * @since 2.0.0
		 *
		 * @param array $request      The array of information from the submitted form.
		 * @return array              The saved player.
		 */
		return apply_filters( 'sports_bench_save_player', $request );
	}

	/**
	 * Gets the information for the selected player.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The array of information for the player.
	 */
	public function get_player_info() {
		$the_player = new Player( (int) intval( $_GET['player_id'] ) );

		/**
		 * Gets the information for a player.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html            The incoming information for the player.
		 * @param Player $the_player      The current player object.
		 * @return array                  The information for a player.
		 */
		$player = apply_filters( 'sports_bench_get_admin_player_info', '', $the_player );

		return $player;
	}

	/**
	 * Deletes a given player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $player_id      The player to be deleted.
	 */
	public function delete_player( $player_id ) {
		Database::delete_row( 'players', [ 'player_id' => $player_id ] );
	}

	/**
	 * Adds a player to the player taxonomy if they aren't already there.
	 *
	 * @since 2.0.0
	 *
	 * @param array $player      The array of information for the player.
	 */
	private function add_to_player_taxonomy( $player ) {
		$id_found = false;

		$existing_terms = get_terms(
			'sports-bench-post-players',
			[
				'hide_empty' => false,
			]
		);

		foreach ( $existing_terms as $term ) {
			if ( $term->slug === $player['player_slug'] ) {
				$id_found = true;
			}
		}

		if ( false === $id_found ) {
			wp_insert_term(
				$player['player_first_name'] . ' ' . $player['player_last_name'],
				'sports-bench-post-players',
				[
					'slug' => $player['player_slug'],
				]
			);
		}
	}

	/**
	 * Displays the fields for a new team.
	 *
	 * @since 2.0.0
	 */
	public function sports_bench_do_default_new_player_fields() {
		$teams = $this->get_all_teams();
		?>
		<div class="form-left">

			<div class="fields-container">
				<div class="field one-column">
					<label for="player-first-name"><?php esc_html_e( 'First Name:', 'sports-bench' ); ?></label>
					<input type="text" id="player-first-name" name="player_first_name" />
				</div>

				<div class="field one-column">
				<label for="player-last-name"><?php esc_html_e( 'Last Name:', 'sports-bench' ); ?></label>
					<input type="text" id="player-last-name" name="player_last_name" />
				</div>
			</div>

			<h2><?php esc_html_e( 'Player Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="player-position"><?php esc_html_e( 'Player Position:', 'sports-bench' ); ?></label>
					<input type="text" id="player-position" name="player_position" />
				</div>

				<div class="field one-column">
					<label for="player-birthday"><?php esc_html_e( 'Player Birthday:', 'sports-bench' ); ?></label>
					<input type="text" id="player-birthday" name="player_birth_day" />
				</div>

				<div class="field one-column">
					<label for="player-height"><?php esc_html_e( 'Height:', 'sports-bench' ); ?></label>
					<input type="text" id="player-height" name="player_height" />
				</div>

				<div class="field one-column">
					<label for="player-weight"><?php esc_html_e( 'Weight:', 'sports-bench' ); ?></label>
					<input type="number" id="player-weight" name="player_weight" />
				</div>

				<div class="field one-column">
					<label for="player-home-city"><?php esc_html_e( 'Home City:', 'sports-bench' ); ?></label>
					<input type="text" id="player-home-city" name="player_home_city" />
				</div>

				<div class="field one-column">
					<label for="player-home-state"><?php esc_html_e( 'Home State:', 'sports-bench' ); ?></label>
					<input type="text" id="player-home-state" name="player_home_state" />
				</div>

			</div>

			</div>

			<div class="form-right">
			<div class="form-right-inner">
				<div class="photo-field">
					<label for="player-photo"><?php esc_html_e( 'Player Photo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-photo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo" /><br />
					<img class="user-preview-image" id="photo" width="100%" style="margin-bottom: 10px; display: none;" src="" alt="blank space">
					<input type="hidden" name="player_photo" id="player-photo" />
					<button class="button-primary" id="uploadphoto"><?php esc_html_e( 'Upload Photo', 'sports-bench' ); ?></button>
					<button class="button" id="removephoto"><?php esc_html_e( 'Remove Photo', 'sports-bench' ); ?></button>
				</div>

				<div class="field one-column">
					<label for="player-team"><?php esc_html_e( 'Team:', 'sports-bench' ); ?></label>
					<select id="player-team" name="team_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
						<option value="0"><?php esc_html_e( 'Free Agent', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								?>
								<option value="<?php echo esc_attr( $team->get_team_id() ); ?>"><?php echo esc_html( $team->get_team_name() ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</div>
		<?php
	}

	/**
	 * Displays all of the fields for the edit player screen.
	 *
	 * @since 2.0.0
	 *
	 * @param array $player      The information for the player.
	 */
	public function sports_bench_do_default_player_fields( $player ) {
		$teams = $this->get_all_teams();
		?>
		<div class="form-left">

			<div class="fields-container">
				<div class="field one-column">
					<label for="player-first-name"><?php esc_html_e( 'First Name:', 'sports-bench' ); ?></label>
					<input type="text" id="player-first-name" name="player_first_name" value="<?php echo esc_attr( $player['player_first_name'] ); ?>" />
				</div>

				<div class="field one-column">
				<label for="player-last-name"><?php esc_html_e( 'Last Name:', 'sports-bench' ); ?></label>
					<input type="text" id="player-last-name" name="player_last_name" value="<?php echo esc_attr( $player['player_last_name'] ); ?>" />
				</div>
			</div>

			<h2><?php esc_html_e( 'Player Information', 'sports-bench' ); ?></h2>

			<div class="fields-container">

				<div class="field one-column">
					<label for="player-position"><?php esc_html_e( 'Player Position:', 'sports-bench' ); ?></label>
					<input type="text" id="player-position" name="player_position" value="<?php echo esc_attr( $player['player_position'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="player-birthday"><?php esc_html_e( 'Player Birthday:', 'sports-bench' ); ?></label>
					<input type="text" id="player-birthday" name="player_birth_day" value="<?php echo esc_attr( $player['player_birth_day'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="player-height"><?php esc_html_e( 'Height:', 'sports-bench' ); ?></label>
					<input type="text" id="player-height" name="player_height" value="<?php echo esc_attr( $player['player_height'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="player-weight"><?php esc_html_e( 'Weight:', 'sports-bench' ); ?></label>
					<input type="number" id="player-weight" name="player_weight" value="<?php echo esc_attr( $player['player_weight'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="player-home-city"><?php esc_html_e( 'Home City:', 'sports-bench' ); ?></label>
					<input type="text" id="player-home-city" name="player_home_city" value="<?php echo esc_attr( $player['player_home_city'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="player-home-state"><?php esc_html_e( 'Home State:', 'sports-bench' ); ?></label>
					<input type="text" id="player-home-state" name="player_home_state" value="<?php echo esc_attr( $player['player_home_state'] ); ?>" />
				</div>

			</div>

			</div>

			<div class="form-right">
			<div class="form-right-inner">
				<div class="photo-field">
					<label for="player-photo"><?php esc_html_e( 'Player Photo:', 'sports-bench' ); ?></label>
					<img class="user-preview-image" id="placeholder-photo" src="<?php echo plugin_dir_url( __FILE__ ) . '../../../../admin/images/mystery-person.jpg'; ?>" alt="default photo" <?php if ( '' !== $player['player_photo'] ) { echo 'style="display: none;"'; } ?> /><br />
					<img class="user-preview-image" id="photo" width="100%" style="margin-bottom: 10px; <?php if ( '' === $player['player_photo'] ) { echo esc_attr( 'display: none;' ); } ?>" src="<?php echo esc_attr( $player['player_photo'] ); ?>" alt="blank space">
					<input type="hidden" name="player_photo" id="player-photo" value="<?php echo esc_attr( $player['player_photo'] ); ?>" />
					<button class="button-primary" id="uploadphoto"><?php esc_html_e( 'Upload Photo', 'sports-bench' ); ?></button>
					<button class="button" id="removephoto"><?php esc_html_e( 'Remove Photo', 'sports-bench' ); ?></button>
				</div>
				<div class="field one-column">
					<label for="player-team"><?php esc_html_e( 'Team:', 'sports-bench' ); ?></label>
					<select id="player-team" name="team_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
						<option value="0" <?php checked( $player['team_id'], 0 ); ?>><?php esc_html_e( 'Free Agent', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								?>
								<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $player['team_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</div>
		<?php
	}

	/**
	 * Gets the information for a player for the edit player screen.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html            The incoming information for the player.
	 * @param Player $the_player      The current player object.
	 * @return array                  The information for the player.
	 */
	public function sports_bench_do_get_player_admin_info( $html, $the_player ) {
		$player     = [
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

		return $player;
	}

	/**
	 * Saves the new player information
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The submitted information for the player.
	 * @return array              The information for the player.
	 */
	public function sports_bench_do_save_player( $request ) {
		global $wpdb;
		$default_player = [
			'player_id'         => '',
			'player_first_name' => '',
			'player_last_name'  => '',
			'player_photo'      => '',
			'player_position'   => '',
			'player_home_city'  => '',
			'player_home_state' => '',
			'player_birth_day'  => '',
			'team_id'           => 0,
			'player_weight'     => '',
			'player_height'     => '',
			'player_height'     => '',
			'player_slug'       => '',
			'player_bio'        => '',
		];

		if ( isset( $request['nonce'] ) && wp_verify_nonce( $request['nonce'], 'sports-bench-player' ) ) {
			$player = shortcode_atts( $default_player, $request );
			$player = [
				'player_id'         => intval( $player['player_id'] ),
				'player_first_name' => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_first_name'] ) ) ),
				'player_last_name'  => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_last_name'] ) ) ),
				'player_photo'      => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_photo'] ) ) ),
				'player_position'   => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_position'] ) ) ),
				'player_home_city'  => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_home_city'] ) ) ),
				'player_home_state' => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_home_state'] ) ) ),
				'player_birth_day'  => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_birth_day'] ) ) ),
				'team_id'           => intval( $player['team_id'] ),
				'player_weight'     => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_weight'] ) ) ),
				'player_height'     => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_height'] ) ) ),
				'player_slug'       => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_slug'] ) ) ),
				'player_bio'        => wp_filter_nohtml_kses( sanitize_text_field( stripslashes( $player['player_bio'] ) ) ),
			];

			$table_name            = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
			$slug                  = strtolower( $player['player_first_name'] . ' ' . $player['player_last_name'] );
			$player['player_slug'] = preg_replace( "/[\s_]/", "-", $slug );
			$slug_test             = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE player_slug = %s", $player['player_slug'] ) );

			$i = 1;
			while ( $slug_test !== [] && $player['player_slug'] !== $slug_test[0]->player_slug ) {
				$i++;
				$slug      = $player['player_slug'] . '-' . $i;
				$slug_test = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name WHERE player_slug = %s", $player['player_slug'] ) );
				if ( $slug_test ==  [] ) {
					$player['player_slug'] = $player['player_slug'] . '-' . $i;
					break;
				}
			}

			if ( $this->player_exists( $player['player_id'] ) ) {
				$player_object = new Player( (int) $player['player_id'] );
				$player_object->update( $player );
			} else {
				Database::add_row( 'players', $player );
				$this->add_to_player_taxonomy( $player );
			}

			return $player;
		}
	}

	/**
	 * Checks to see if a user can edit the current player.
	 *
	 * @since 2.2
	 *
	 * @param int $current_player      The player id for the current player.
	 * @return boolean                 Whether the user can edit the current player.
	 */
	public function user_can_edit_player( $current_player ) {
		$user         = wp_get_current_user();
		$player       = new Player( (int)$current_player );
		$current_team = $player->get_team_id();
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
