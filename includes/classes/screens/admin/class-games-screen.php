<?php
/**
 * The file that defines the games screen class
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
use Sports_Bench\Classes\Base\Game;

/**
 * The games screen class.
 *
 * This is used for functions for games admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class GamesScreen extends Screen {

	/**
	 * Creates the new GamesScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Displays a list of games.
	 *
	 * @since 2.0.0
	 *
	 * @return string     The HTML for the list of games.
	 */
	public function display_games_listing() {
		$games = $this->get_games();
		$count = 1;

		if ( $games ) {
			$html  = '<table class="games-table form-table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>' . esc_html__( 'Teams', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Date/Time', 'sports-bench' ) . '</th>';
			$html .= '<th>' . esc_html__( 'Status', 'sports-bench' ) . '</th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Edit Game Column', 'sports-bench' ) . '</span></th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Delete Game Column', 'sports-bench' ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';
			foreach ( $games as $game ) {
				if ( 0 === $count % 2 ) {
					$row = 'even';
				} else {
					$row = 'odd';
				}
				$away_team = $game->get_away_team();
				$home_team = $game->get_home_team();
				$html     .= '<tr class="' . esc_attr( $row ) . '" style="border-left: 2px solid ' . $away_team->get_team_primary_color() . '">';
				$html     .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . ' ' . $away_team->get_team_name() . '</td>';
				$html     .= '<td>' . $game->get_game_day( 'h:i a' ) . '</td>';
				$html     .= '<td class="status-column" rowspan="2">' . $game->get_game_status() . '</td>';
				$html     .= '<td class="edit-column" rowspan="2"><a href="' . $this->get_admin_page_link( 'sports-bench-edit-game-form&game_id=' . $game->get_game_id() ) . '" class="button">' . esc_html__( 'Edit', 'sports-bench' ) . '</a></td>';
				$html     .= '<td class="delete-column" rowspan="2"><a href="' . $this->get_admin_page_link( 'sports-bench-games&action=delete&game_id=' . $game->get_game_id() ) . '" class="button red">' . esc_html__( 'Delete', 'sports-bench' ) . '</a></td>';
				$html     .= '</tr>';
				$html     .= '<tr class="' . esc_attr( $row ) . '" style="border-left: 2px solid ' . $home_team->get_team_primary_color() . '">';
				$html     .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . ' ' . $home_team->get_team_name() . '</td>';
				$html     .= '<td>' . $game->get_game_day( 'F j, Y' ) . '</td>';
				$html     .= '</tr>';
				$count++;
			}
			$html .= '</tbody>';

			$html .= '</table>';
		} else {
			$html = '<p>' . esc_html__( 'There are no games in the database.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Gets a list of games to show.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of games.
	 */
	private function get_games() {
		global $wpdb;
		$games       = [];
		$games_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$per_page    = 20;
		$user        = wp_get_current_user();

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
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) ORDER BY game_day DESC LIMIT %d OFFSET %d", $team->get_team_id(), $team->get_team_id(), $per_page, $sql_paged );
		} else {
			if ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_away_id = %d AND game_home_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_away_id'] ), sanitize_text_field( $_GET['game_home_id'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND pgame_away_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_away_id'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_home_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_home_id'] ), $per_page, $sql_paged );
			} elseif ( ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_away_id = %d AND game_home_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['game_away_id'] ), sanitize_text_field( $_GET['game_home_id'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_away_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['game_away_id'] ), $per_page, $sql_paged );
			} elseif ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_home_id = %d ORDER BY game_day DESC LIMIT %d OFFSET %d", sanitize_text_field( $_GET['game_home_id'] ), $per_page, $sql_paged );
			} else {
				$sql = $wpdb->prepare( "SELECT game_id FROM $games_table ORDER BY game_day DESC LIMIT %d OFFSET %d", $per_page, $sql_paged );
			}
		}

		$games_data = Database::get_results( $sql );

		if ( $games_data ) {
			foreach ( $games_data as $game ) {
				$games[] = new Game( $game->game_id );
			}
		}

		return $games;
	}

	/**
	 * Displays search filters that can be used to easily find games.
	 *
	 * @since 2.0.0
	 */
	public function display_search_filters() {
		$teams = $this->get_all_teams();
		?>
		<div class="search-row clearfix">
			<form action="admin.php?page=sports-bench-games" method="get">

				<input type="hidden" name="page" value="sports-bench-games" />

				<div class="search-column">
					<label for="team_id"><?php esc_html_e( 'Team:', 'sports-bench' ); ?></label>
					<select id="team_id" class="search-input" name="team_id">
						<option value=""><?php esc_html_e( 'All Teams', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								if ( isset( $_GET['team_id'] ) ) {
									$selected = selected( sanitize_text_field( $_GET['team_id'] ), $team->get_team_id(), false );
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
					<label for="game_away_id"><?php esc_html_e( 'Away Team:', 'sports-bench' ); ?></label>
					<select id="game_away_id" class="search-input" name="game_away_id">
						<option value=""><?php esc_html_e( 'All Teams', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								if ( isset( $_GET['game_away_id'] ) ) {
									$selected = selected( sanitize_text_field( $_GET['game_away_id'] ), $team->get_team_id(), false );
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
					<label for="game_home_id"><?php esc_html_e( 'Home Team:', 'sports-bench' ); ?></label>
					<select id="game_home_id" class="search-input" name="game_home_id">
						<option value=""><?php esc_html_e( 'All Teams', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								if ( isset( $_GET['game_home_id'] ) ) {
									$selected = selected( sanitize_text_field( $_GET['game_home_id'] ), $team->get_team_id(), false );
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
					<input id="clear-game-search" type="reset" value="<?php esc_html_e( 'Clear', 'sports-bench' ); ?>" />
				</div>


			</form>
		</div>
		<?php
	}

	/**
	 * Displays the pagination section for the games listing screen.
	 *
	 * @since 2.0.0
	 */
	public function display_pagination() {
		global $wpdb;
		$html        = '';
		$per_page    = 20;
		$games_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

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

		if ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_away_id = %d AND game_home_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_away_id'] ), sanitize_text_field( $_GET['game_home_id'] ) );
			$url = '&team_id=' . sanitize_text_field( $_GET['team_id'] ) . '&game_away_id=' . sanitize_text_field( $_GET['game_away_id'] ) . '&team=' . sanitize_text_field( $_GET['team'] );
		} elseif ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_away_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_away_id'] ) );
			$url = '&team_id=' . sanitize_text_field( $_GET['team_id'] ) . '&player_last_name=' . sanitize_text_field( $_GET['player_last_name'] );
		} elseif ( ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_home_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['game_home_id'] ) );
			$url = '&team_id=' . sanitize_text_field( $_GET['team_id'] ) . '&game_home_id=' . sanitize_text_field( $_GET['game_home_id'] );
		} elseif ( ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) && ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_away_id = %d AND game_home_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['game_away_id'] ), sanitize_text_field( $_GET['game_home_id'] ) );
			$url = '&player_last_name=' . sanitize_text_field( $_GET['game_away_id'] ) . '&game_home_id=' . sanitize_text_field( $_GET['game_home_id'] );
		} elseif ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE ( game_away_id = %d OR game_home_id = %d ) ORDER BY game_day DESC", sanitize_text_field( $_GET['team_id'] ), sanitize_text_field( $_GET['team_id'] ) );
			$url = '&team_id=' . sanitize_text_field( $_GET['team_id'] );
		} elseif ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_away_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['game_away_id'] ) );
			$url = '&game_away_id=' . sanitize_text_field( $_GET['game_away_id'] );
		} elseif ( isset( $_GET['team'] ) && '' !== $_GET['game_home_id'] ) {
			$sql = $wpdb->prepare( "SELECT game_id FROM $games_table WHERE game_home_id = %d ORDER BY game_day DESC", sanitize_text_field( $_GET['game_home_id'] ) );
			$url = '&game_home_id=' . sanitize_text_field( $_GET['game_home_id'] );
		} else {
			$sql = "SELECT game_id FROM $games_table ORDER BY game_day DESC";
		}
		$num_games   = Database::get_results( $sql );
		$num_games   = count( $num_games );
		$total_pages = ceil( $num_games / $per_page );

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
				<a href="?page=sports-bench-games&paged=<?php echo esc_attr( $current_page + 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black next">
					<span class="dashicons dashicons-arrow-right-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page + 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<form action="admin.php?page=sports-bench-games" method="get">

			<input type="hidden" name="page" value="sports-bench-games" />

			<?php
			if ( isset( $_GET['team_id'] ) && '' !== $_GET['team_id'] ) {
				?>
				<input type="hidden" name="team_id" value="<?php echo esc_attr( sanitize_text_field( $_GET['team_id'] ) ); ?>" />
				<?php
			}
			?>

			<?php
			if ( isset( $_GET['game_away_id'] ) && '' !== $_GET['game_away_id'] ) {
				?>
				<input type="hidden" name="game_away_id" value="<?php echo esc_attr( sanitize_text_field( $_GET['game_away_id'] ) ); ?>" />
				<?php
			}
			?>

			<?php
			if ( isset( $_GET['game_home_id'] ) && '' !== $_GET['game_home_id'] ) {
				?>
				<input type="hidden" name="game_home_id" value="<?php echo esc_attr( sanitize_text_field( $_GET['game_home_id'] ) ); ?>" />
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
				<a href="?page=sports-bench-games&paged=<?php echo esc_attr( $current_page - 1 ); ?><?php echo esc_attr( $url ); ?>" class="button black previous">
					<span class="dashicons dashicons-arrow-left-alt2"></span><span class="screen-reader-text"><?php echo esc_html__( 'Go to page', 'sports-bench' ) . ' ' . esc_html( $current_page - 1 ); ?></span>
				</a>
				<?php
			}
			?>
		</div>

		<?php
	}

	/**
	 * Gets all of the teams.
	 *
	 * @since 2.0.0
	 *
	 * @param bool $active      Whether to limit the list to active teams or not.
	 * @return array            A list of teams.
	 */
	public function get_all_teams( $active = false ) {
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';
		$teams = [];

		if ( true === $active ) {
			$teams_list = Database::get_results( "SELECT team_id FROM $table WHERE team_active = 'active' ORDER BY team_name ASC;" );
		} else {
			$teams_list = Database::get_results( "SELECT team_id FROM $table ORDER BY team_name ASC;" );
		}

		if ( $teams_list ) {
			foreach ( $teams_list as $team ) {
				$teams[] = new Team( (int) $team->team_id );
			}
		}

		return $teams;
	}

	/**
	 * Gets the game ID to give to a new game.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The game id for the new game.
	 */
	public function get_new_game_id() {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$default_row = Database::get_results( "SELECT * FROM $table ORDER BY game_id DESC LIMIT 1;" );
		if ( $default_row ) {
			return $default_row[0]->game_id + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Checks to see if the game already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the game to check.
	 * @return bool        Whether the game exists or not.
	 */
	public function game_exists( $id ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$check = Database::get_results( "SELECT player_id FROM $table WHERE game_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Displays the fields for a new game.
	 *
	 * @since 2.0.0
	 */
	public function display_new_game_fields() {
		$game_id = $this->get_new_game_id();
		$teams   = $this->get_all_teams();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-game-form&game_id=<?php echo esc_attr( $game_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-game' ) ); ?>"/>
			<input type="hidden" name="id" value="<?php echo esc_attr( $game_id ); ?>"/>

			<div class="game-form-container-teams">

				<div class="field one-column">
					<label for="game-away-id"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></label>
					<select id="game-away-id" name="game_away_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
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

				<div class="field one-column">
					<label for="game-home-id"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></label>
					<select id="game-home-id" name="game_home_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
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

			<div class="game-form-container-details">

				<div class="left">
					<?php
					/**
					 * Fires to show the fields for a new game scoreline.
					 *
					 * @since 2.0.0
					 */
					do_action( 'sports_bench_new_game_scoreline' );
					?>

					<?php
					/**
					 * Fires to show the fields for a new game team stats.
					 *
					 * @since 2.0.0
					 */
					do_action( 'sports_bench_new_game_team_stats' );
					?>
				</div>

				<div class="right">
					<?php
					/**
					 * Fires to show the fields for a new game details.
					 *
					 * @since 2.0.0
					 */
					do_action( 'sports_bench_new_game_details' );
					?>
				</div>

			</div>

			<div class="game-form-container-game-events">
				<?php
				/**
				 * Fires to show the fields for a new game events.
				 *
				 * @since 2.0.0
				 */
				do_action( 'sports_bench_new_game_events' );
				?>
			</div>

			<div class="game-form-container-away-stats">
				<?php
				/**
				 * Fires to show the fields for a new game away team individual stats.
				 *
				 * @since 2.0.0
				 */
				do_action( 'sports_bench_new_game_away_stats' );
				?>
			</div>

			<div class="game-form-container-home-stats">
				<?php
				/**
				 * Fires to show the fields for a new game home team individual stats.
				 *
				 * @since 2.0.0
				 */
				do_action( 'sports_bench_new_game_home_stats' );
				?>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</div>
		<?php
	}

	/**
	 * Saves the information for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The array of information from the submitted form.
	 * @return array              The saved game.
	 */
	public function save_game( $request ) {
		/**
		 * Saves the data for the game that's being added/edited.
		 *
		 * If you are customizing the add/edit game form with your own fields and columns
		 * you can use this filter to save that information.
		 *
		 * @since 2.0.0
		 *
		 * @param array $request      The array of information from the submitted form.
		 * @return array              The saved information for the game.
		 */
		return apply_filters( 'sports_bench_save_game', $request );
	}

	/**
	 * Deletes a given game.
	 *
	 * @since 2.0.3
	 *
	 * @param int $game_id      The team to be deleted.
	 */
	public function delete_team( $game_id ) {
		Database::delete_row( 'games', [ 'game_id' => $game_id ] );
		Database::delete_row( 'game_info', [ 'game_id' => $game_id ] );
		Database::delete_row( 'game_stats', [ 'game_id' => $game_id ] );
	}

	/**
	 * Displays the fields for the edit game field.
	 *
	 * @since 2.0.0
	 *
	 * @param int   $game_id     The ID for the game.
	 * @param array $game        The array of game information.
	 * @param array $events      The array of events for the game.
	 * @param array $stats       The array of stats for the game.
	 */
	public function display_game_fields( $game_id, $game, $events, $stats ) {
		$teams = $this->get_all_teams();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-game-form&game_id=<?php echo esc_attr( $game_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-game' ) ); ?>"/>
			<input type="hidden" name="id" value="<?php echo esc_attr( $game_id ); ?>"/>

			<div class="game-form-container-teams">

				<div class="field one-column">
					<label for="game-away-id"><?php esc_html_e( 'Away Team', 'sports-bench' ); ?></label>
					<select id="game-away-id" name="game_away_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								?>
								<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $game['game_away_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

				<div class="field one-column">
					<label for="game-home-id"><?php esc_html_e( 'Home Team', 'sports-bench' ); ?></label>
					<select id="game-home-id" name="game_home_id">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $team ) {
								?>
								<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $game['game_home_id'], $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>

			</div>

			<div class="game-form-container-details">

				<div class="left">
					<?php
					/**
					 * Fires to show the fields for a game scoreline.
					 *
					 * @since 2.0.0
					 *
					 * @param array $game      The information for the game.
					 */
					do_action( 'sports_bench_edit_game_scoreline', $game );
					?>

					<?php
					/**
					 * Fires to show the fields for a game team stats.
					 *
					 * @since 2.0.0
					 *
					 * @param array $game      The information for the game.
					 */
					do_action( 'sports_bench_edit_game_team_stats', $game );
					?>
				</div>

				<div class="right">
					<?php
					/**
					 * Fires to show the fields for a game details.
					 *
					 * @since 2.0.0
					 *
					 * @param array $game      The information for the game.
					 */
					do_action( 'sports_bench_edit_game_details', $game );
					?>
				</div>

			</div>

			<div class="game-form-container-game-events">
				<?php
				/**
				 * Fires to show the fields for a game events.
				 *
				 * @since 2.0.0
				 *
				 * @param array $events      The information for the game events.
				 */
				do_action( 'sports_bench_edit_game_events', $events, $game );
				?>
			</div>

			<div class="game-form-container-away-stats">
				<?php
				/**
				 * Fires to show the fields for a game away team individual stats.
				 *
				 * @since 2.0.0
				 *
				 * @param array $stats      The information for the game individual stats.
				 * @param array $game       The information for the game.
				 */
				do_action( 'sports_bench_edit_game_away_stats', $stats, $game );
				?>
			</div>

			<div class="game-form-container-home-stats">
				<?php
				/**
				 * Fires to show the fields for a game home team individual stats.
				 *
				 * @since 2.0.0
				 *
				 * @param array $stats      The information for the game individual stats.
				 * @param array $game       The information for the game.
				 */
				do_action( 'sports_bench_edit_game_home_stats', $stats, $game );
				?>
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</div>
		<?php
	}

	/**
	 * Checks to see if a user can edit the current game.
	 *
	 * @since 2.2
	 *
	 * @param int $game      The game id for the current game.
	 * @return boolean       Whether the user can edit the current game.
	 */
	public function user_can_edit_game( $game ) {
		$user      = wp_get_current_user();
		$game      = new Game( $game );
		$home_team = $game->get_game_home_id();
		$away_team = $game->get_game_away_id();
		if ( $this->is_team_manager() ) {
			$team = new Team( (int)get_the_author_meta( 'sports_bench_team', $user->ID ) );

			if ( $away_team === $team->get_team_id() || $home_team === $team->get_team_id() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
