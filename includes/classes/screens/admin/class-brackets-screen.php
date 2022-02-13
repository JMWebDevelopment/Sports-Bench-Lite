<?php
/**
 * The file that defines the brackets screen class
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screens/admin
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Screens\Admin;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Bracket;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Series;
use Sports_Bench\Classes\Base\Game;

/**
 * The brackets screen class.
 *
 * This is used for functions for brackets admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class BracketsScreen extends Screen {

	/**
	 * Creates the new TeamsScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Displays the list of playoff brackets.
	 *
	 * @since 2.0.0
	 */
	public function display_brackets_listing() {
		$brackets = $this->get_brackets();

		if ( $brackets ) {
			$html  = '<table class="brackets-table form-table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>' . esc_html__( 'Title', 'sports-bench' ) . '</th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Edit Bracket Column', 'sports-bench' ) . '</span></th>';
			$html .= '<th><span class="screen-reader-text">' . esc_html__( 'Delete Bracket Column', 'sports-bench' ) . '</span></th>';
			$html .= '</tr>';
			$html .= '</thead>';

			$html .= '<tbody>';
			foreach ( $brackets as $bracket ) {
				$html .= '<tr>';
				$html .= '<td>' . $bracket->get_bracket_title() . '</td>';
				$html .= '<td class="edit-column"><a href="' . $this->get_admin_page_link( 'sports-bench-edit-bracket-form&bracket_id=' . $bracket->get_bracket_id() ) . '" class="button">' . esc_html__( 'Edit', 'sports-bench' ) . '</a></td>';
				$html .= '<td class="delete-column"><a href="' . $this->get_admin_page_link( 'sports-bench-brackets&action=delete&bracket_id=' . $bracket->get_bracket_id() ) . '" class="button red">' . esc_html__( 'Delete', 'sports-bench' ) . '</a></td>';
				$html .= '</tr>';
			}
			$html .= '</tbody>';

			$html .= '</table>';
		} else {
			$html = '<p>' . esc_html__( 'There are no brackets in the database.', 'sports-bench' ) . '</p>';
		}

		return $html;
	}

	/**
	 * Gets the list of brackets to show.
	 *
	 * @since 2.0.0
	 *
	 * @access private
	 */
	private function get_brackets() {
		global $wpdb;
		$brackets      = [];
		$bracket_table = SB_TABLE_PREFIX . 'playoff_brackets';

		$sql = "SELECT bracket_id FROM $bracket_table ORDER BY bracket_title ASC";

		$brackets_data = Database::get_results( $sql );

		if ( $brackets_data ) {
			foreach ( $brackets_data as $bracket ) {
				$brackets[] = new Bracket( (int) $bracket->bracket_id );
			}
		}

		return $brackets;
	}

	/**
	 * Gets the bracket ID to give to a new bracket.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The bracket id for the new bracket.
	 */
	public function get_new_bracket_id() {
		global $wpdb;
		$table       = SB_TABLE_PREFIX . 'playoff_brackets';
		$default_row = Database::get_results( "SELECT * FROM $table ORDER BY bracket_id DESC LIMIT 1;" );
		if ( $default_row ) {
			return $default_row[0]->bracket_id + 1;
		} else {
			return 1;
		}
	}

	/**
	 * Checks to see if the bracket already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the bracket to check.
	 * @return bool        Whether the bracket exists or not.
	 */
	public function bracket_exists( $id ) {
		global $wpdb;
		$table = SB_TABLE_PREFIX . 'playoff_brackets';
		$check = Database::get_results( "SELECT bracket_id FROM $table WHERE bracket_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks to see if the braseriescket already exists in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param int $id      The id of the series to check.
	 * @return bool        Whether the series exists or not.
	 */
	public function series_exists( $id ) {
		global $wpdb;
		$table = SB_TABLE_PREFIX . 'playoff_series';
		$check = Database::get_results( "SELECT series_id FROM $table WHERE series_id = $id;" );
		if ( $check ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Displays the fields for a new playoff bracket.
	 *
	 * @since 2.0.0
	 */
	public function display_new_bracket_fields() {
		$bracket_id = $this->get_new_bracket_id();
		$seasons    = $this->get_seasons();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-bracket-form&bracket_id=<?php echo esc_attr( $bracket_id ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-bracket' ) ); ?>"/>
			<input type="hidden" name="bracket_id" value="<?php echo esc_attr( $bracket_id ); ?>"/>

			<div class="form-top-container">
				<div class="bracket-title full-width">
					<label for="bracket-title"><?php esc_html_e( 'Bracket Title:', 'sports-bench' ); ?></label>
					<input type="text" id="bracket-title" name="bracket_title" />
				</div>

				<div class="field one-column">
					<label for="num-teams"><?php esc_html_e( 'Number of Teams:', 'sports-bench' ); ?></label>
					<select id="num-teams" name="num_teams">
						<option value=""><?php esc_html_e( 'Number of Teams', 'sports-bench' ); ?></option>
						<option value="2"><?php esc_html_e( '2 Teams', 'sports-bench' ); ?></option>
						<option value="4"><?php esc_html_e( '4 Teams', 'sports-bench' ); ?></option>
						<option value="6"><?php esc_html_e( '6 Teams', 'sports-bench' ); ?></option>
						<option value="8"><?php esc_html_e( '8 Teams', 'sports-bench' ); ?></option>
						<option value="12"><?php esc_html_e( '12 Teams', 'sports-bench' ); ?></option>
						<option value="16"><?php esc_html_e( '16 Teams', 'sports-bench' ); ?></option>
						<option value="32"><?php esc_html_e( '32 Teams', 'sports-bench' ); ?></option>
						<option value="64"><?php esc_html_e( '64 Teams', 'sports-bench' ); ?></option>
					</select>
				</div>

				<div class="field one-column">
					<label for="bracket-format"><?php esc_html_e( 'Bracket Format:', 'sports-bench' ); ?></label>
					<select id="bracket-format" name="bracket_format">
						<option value=""><?php esc_html_e( 'Format', 'sports-bench' ); ?></option>
						<option value="single"><?php esc_html_e( 'Single Elimination', 'sports-bench' ); ?></option>
						<option value="double"><?php esc_html_e( 'Double Elimination', 'sports-bench' ); ?></option>
					</select>
				</div>

				<div class="field one-column">
					<label for="bracket-season"><?php esc_html_e( 'Season:', 'sports-bench' ); ?></label>
					<select id="bracket-season" name="bracket_season">
						<option value=""><?php esc_html_e( 'Season', 'sports-bench' ); ?></option>
						<?php
						if ( $seasons ) {
							foreach ( $seasons as $season ) {
								?>
								<option value="<?php echo esc_attr( $season->game_season ); ?>"><?php echo esc_html( $season->game_season ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div class="field one-column button-column">
					<button id="create-bracket" class="button-primary"><?php esc_html_e( 'Create Bracket', 'sports-bench' ); ?></button>
				</div>
			</div>

			<div class="form-series-container">
			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</form>
		<?php
	}

	/**
	 * Displays the fields for a bracket.
	 *
	 * @since 2.0.0
	 */
	public function display_bracket_fields( $bracket ) {
		$seasons = $this->get_seasons();
		?>
		<form id="form" method="POST" action="?page=sports-bench-edit-bracket-form&bracket_id=<?php echo esc_attr( $bracket['bracket_id'] ); ?>">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'sports-bench-bracket' ) ); ?>"/>
			<input type="hidden" name="bracket_id" value="<?php echo esc_attr( $bracket['bracket_id'] ); ?>"/>

			<div class="form-top-container">
				<div class="bracket-title full-width">
					<label for="bracket-title"><?php esc_html_e( 'Bracket Title:', 'sports-bench' ); ?></label>
					<input type="text" id="bracket-title" name="bracket_title" value="<?php echo esc_attr( $bracket['bracket_title'] ); ?>" />
				</div>

				<div class="field one-column">
					<label for="num-teams"><?php esc_html_e( 'Number of Teams:', 'sports-bench' ); ?></label>
					<select id="num-teams" name="num_teams">
						<option value="" <?php selected( $bracket['num_teams'], '' ); ?>><?php esc_html_e( 'Number of Teams', 'sports-bench' ); ?></option>
						<option value="2" <?php selected( $bracket['num_teams'], '2' ); ?>><?php esc_html_e( '2 Teams', 'sports-bench' ); ?></option>
						<option value="4" <?php selected( $bracket['num_teams'], '4' ); ?>><?php esc_html_e( '4 Teams', 'sports-bench' ); ?></option>
						<option value="6" <?php selected( $bracket['num_teams'], '6' ); ?>><?php esc_html_e( '6 Teams', 'sports-bench' ); ?></option>
						<option value="8" <?php selected( $bracket['num_teams'], '8' ); ?>><?php esc_html_e( '8 Teams', 'sports-bench' ); ?></option>
						<option value="12" <?php selected( $bracket['num_teams'], '12' ); ?>><?php esc_html_e( '12 Teams', 'sports-bench' ); ?></option>
						<option value="16" <?php selected( $bracket['num_teams'], '16' ); ?>><?php esc_html_e( '16 Teams', 'sports-bench' ); ?></option>
						<option value="32" <?php selected( $bracket['num_teams'], '32' ); ?>><?php esc_html_e( '32 Teams', 'sports-bench' ); ?></option>
						<option value="64" <?php selected( $bracket['num_teams'], '64' ); ?>><?php esc_html_e( '64 Teams', 'sports-bench' ); ?></option>
					</select>
				</div>

				<div class="field one-column">
					<label for="bracket-format"><?php esc_html_e( 'Bracket Format:', 'sports-bench' ); ?></label>
					<select id="bracket-format" name="bracket_format">
						<option value="" <?php selected( $bracket['bracket_format'], '' ); ?>><?php esc_html_e( 'Format', 'sports-bench' ); ?></option>
						<option value="single" <?php selected( $bracket['bracket_format'], 'single' ); ?>><?php esc_html_e( 'Single Elimination', 'sports-bench' ); ?></option>
						<option value="double" <?php selected( $bracket['bracket_format'], 'double' ); ?>><?php esc_html_e( 'Double Elimination', 'sports-bench' ); ?></option>
					</select>
				</div>

				<div class="field one-column">
					<label for="bracket-season"><?php esc_html_e( 'Season:', 'sports-bench' ); ?></label>
					<select id="bracket-season" name="bracket_season">
						<option value=""><?php esc_html_e( 'Season', 'sports-bench' ); ?></option>
						<?php
						if ( $seasons ) {
							foreach ( $seasons as $season ) {
								?>
								<option value="<?php echo esc_attr( $season->game_season ); ?>" <?php selected( $bracket['bracket_season'], $season->game_season ); ?>><?php echo esc_html( $season->game_season ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div class="field one-column button-column">
					<button id="create-bracket" class="button-primary"><?php esc_html_e( 'Create Bracket', 'sports-bench' ); ?></button>
				</div>
			</div>

			<div class="form-series-container">

				<?php $this->display_series( $bracket ); ?>

			</div>

			<input type="submit" value="<?php esc_html_e( 'Save', 'sports-bench' ); ?>" id="submit" class="button-primary" name="submit">
		</form>
		<?php
	}

	/**
	 * Gets a list of seasons for the league.
	 *
	 * @since 2.0.0
	 */
	public function get_seasons() {
		$table_name = SB_TABLE_PREFIX . 'games';
		$seasons    = Database::get_results( "SELECT DISTINCT game_season FROM $table_name;" );

		return $seasons;
	}

	/**
	 * Saves the playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request      The request array sent from the submitted form.
	 * @return array              The saved playoff bracket.
	 */
	public function save_bracket( $request ) {
		global $wpdb;
		$default_bracket = [
			'bracket_id'     => '',
			'num_teams'      => '',
			'bracket_format' => '',
			'bracket_title'  => '',
			'bracket_season' => '',
		];

		if ( isset( $request['nonce'] ) && wp_verify_nonce( $request['nonce'], 'sports-bench-bracket' ) ) {
			$bracket = shortcode_atts( $default_bracket, $request );
			$bracket = [
				'bracket_id'     => $bracket['bracket_id'],
				'num_teams'      => $bracket['num_teams'],
				'bracket_format' => $bracket['bracket_format'],
				'bracket_title'  => stripslashes( $bracket['bracket_title'] ),
				'bracket_season' => $bracket['bracket_season'],
			];

			if ( $this->bracket_exists( $bracket['bracket_id'] ) ) {
				$bracket_object = new Bracket( $bracket['bracket_id'] );
				$bracket_object->update( $bracket );
			} else {
				Database::add_row( 'playoff_brackets', $bracket );
			}

			$this->save_series( $request, $bracket['bracket_id'] );

			return $bracket;
		}
	}

	/**
	 * Saves all of the series in a playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param array $request         The request array sent from the submitted form.
	 * @param int   $bracket_id      The id of the playoff bracket the series belong to.
	 * @return array                 An array containing $request and the ids of the saved series.
	 */
	public function save_series( $request, $bracket_id ) {
		global $wpdb;

		$series_ids = $request['series_id'];
		unset( $request['series_id'] );

		$series_formats = $request['series_format'];
		unset( $request['series_format'] );

		$playoff_rounds = $request['playoff_round'];
		unset( $request['playoff_round'] );

		$team_one_id = $request['team_one_id'];
		unset( $request['team_one_id'] );

		$team_one_seeds = $request['team_one_seed'];
		unset( $request['team_one_seed'] );

		$team_two_id = $request['team_two_id'];
		unset( $request['team_two_id'] );

		$team_two_seeds = $request['team_two_seed'];
		unset( $request['team_two_seed'] );

		$game_one_ids = $request['game_one_id'];
		unset( $request['game_one_id'] );

		$game_two_ids = $request['game_two_id'];
		unset( $request['game_two_id'] );

		$game_three_ids = $request['game_three_id'];
		unset( $request['game_three_id'] );

		$game_four_ids = $request['game_four_id'];
		unset( $request['game_four_id'] );

		$game_five_ids = $request['game_five_id'];
		unset( $request['game_five_id'] );

		$game_six_ids = $request['game_six_id'];
		unset( $request['game_six_id'] );

		$game_seven_ids = $request['game_seven_id'];
		unset( $request['game_seven_id'] );

		$len      = count( $playoff_rounds );
		$serieses = [];
		for ( $i = 0; $i < $len; $i++ ) {
			if ( isset( $series_ids[ $i ] ) ) {
				$s_id = $series_ids[ $i ];
			} else {
				$s_id = '';
			}
			$game_ids = array( intval( $game_one_ids[ $i ] ), intval( $game_two_ids[ $i ] ), intval( $game_three_ids[ $i ] ), intval( $game_four_ids[ $i ] ), intval( $game_five_ids[ $i ] ), intval( $game_six_ids[ $i ] ), intval( $game_seven_ids[ $i ] ) );
			$game_ids = implode( ', ', $game_ids );
			$series = [
				'series_id'            => intval( $s_id ),
				'bracket_id'           => intval( $request['bracket_id'] ),
				'series_format'        => wp_filter_nohtml_kses( sanitize_text_field( $series_formats[ $i ] ) ),
				'playoff_round'        => wp_filter_nohtml_kses( sanitize_text_field( $playoff_rounds[ $i ] ) ),
				'team_one_id'          => intval( $team_one_id[ $i ] ),
				'team_one_seed'        => intval( $team_one_seeds[ $i ] ),
				'team_two_id'          => intval( $team_two_id[ $i ] ),
				'team_two_seed'        => intval( $team_two_seeds[ $i ] ),
				'game_ids'             => wp_filter_nohtml_kses( sanitize_text_field( $game_ids ) ),
			];
			array_push( $serieses, $series );
		}

		//* Get the game events already in the database to compare the new ones to
		$series_table   = SB_TABLE_PREFIX . 'playoff_series';
		$bracket_id     = $request['bracket_id'];
		$quer           = $wpdb->prepare( "SELECT * FROM $series_table WHERE bracket_id = %d;", $bracket_id );
		$bracket_series = Database::get_results( $quer );
		$serieses_ids   = [];
		foreach ( $bracket_series as $series ) {
			array_push( $serieses_ids, $series->series_id );
		}

		foreach ( $serieses as $series ) {
			if ( '' !== $series['team_one_id'] && '' !== $series['team_two_id'] ) {
				if ( in_array( $series['series_id'], $serieses_ids ) ) {
					Database::update_row( 'playoff_series', [ 'series_id' => $series['series_id'] ], $series );
				} else {
					//* If the event is new, add it to the database
					$series['series_id'] = Database::add_row( 'playoff_series', $series );
				}
			}
		}

		$serieses_ids = [];
		foreach ( $serieses as $event ) {
			array_push( $serieses_ids, $event[ 'series_id' ] );
		}

		//* If a series is in the database but not the $requests array, delete it from the database
		foreach ( $series_ids as $series_id ) {
			if ( ! in_array( $series_id, $serieses_ids ) ) {
				Database::get_results( $wpdb->prepare( "DELETE FROM $series_table WHERE game_info_id = %d", $series_id ) );
			}
		}

		return [ $request, $serieses ];

	}

	/**
	 * Gets the information for a selected playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param array      The information for the selected playoff bracket.
	 */
	public function get_bracket_info() {
		$the_bracket = new Bracket( (int) $_GET['bracket_id'] );
		$bracket = [
			'bracket_id'     => $the_bracket->get_bracket_id(),
			'num_teams'      => $the_bracket->get_num_teams(),
			'bracket_format' => $the_bracket->get_bracket_format(),
			'bracket_title'  => $the_bracket->get_bracket_title(),
			'bracket_season' => $the_bracket->get_bracket_season(),
		];

		return $bracket;
	}

	/**
	 * Deletes a playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param int $bracket_id      The playoff bracket to delete.
	 */
	public function delete_bracket( $bracket_id ) {
		Database::delete_row( 'playoff_brackets', [ 'bracket_id' => $bracket_id ] );
	}

	/**
	 * Displays the potential series for a newly created bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $num_teams             The number of teams in the playoff bracket.
	 * @param string $elimination_type      Whether it's a single or double elimination bracket.
	 * @param string $season                The season the playoff bracket is for.
	 */
	public function display_new_series( $num_teams, $elimination_type, $season ) {
		if ( 2 === $num_teams ) {
			$num_rounds = 1;
			$byes       = false;
		} elseif ( '4' === $num_teams ) {
			$num_rounds = 2;
			$byes       = false;
		} elseif ( '6' === $num_teams ) {
			$num_rounds = 3;
			$byes       = true;
		} elseif ( '8' === $num_teams ) {
			$num_rounds = 3;
			$byes       = false;
		} elseif ( '12' === $num_teams ) {
			$num_rounds = 4;
			$byes       = true;
		} elseif ( '16' === $num_teams ) {
			$num_rounds = 4;
			$byes       = false;
		} elseif ( '24' === $num_teams ) {
			$num_rounds = 5;
			$byes       = true;
		} elseif ( '32' === $num_teams ) {
			$num_rounds = 5;
			$byes       = false;
		} else {
			$num_rounds = 6;
			$byes       = false;
		}

		if ( 'double' === $elimination_type ) {
			$num_rounds = 5;
			$byes       = false;
		}

		$teams = $this->get_teams_list( $season );

		if ( 'double' === $elimination_type ) {
			$first_round  = 2;
			$second_round = 2;
			$third_round  = 1;
			$fourth_round = 1;
			$fifth_round  = 1;
		} elseif ( true === $byes ) {
			if ( '6' === $num_teams ) {
				$first_round  = 2;
				$second_round = 2;
				$third_round  = 1;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '12' === $num_teams ) {
				$first_round  = 4;
				$second_round = 4;
				$third_round  = 2;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} else {
				$first_round  = 8;
				$second_round = 8;
				$third_round  = 4;
				$fourth_round = 2;
				$fifth_round  = 1;
				$sixth_round  = 0;
			}
		} else {
			if ( '2' === $num_teams ) {
				$first_round  = 1;
				$second_round = 0;
				$third_round  = 0;
				$third_round  = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '4' === $num_teams ) {
				$first_round  = 2;
				$second_round = 1;
				$third_round  = 0;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '8' === $num_teams ) {
				$first_round  = 4;
				$second_round = 2;
				$third_round  = 1;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '16' === $num_teams ) {
				$first_round  = 8;
				$second_round = 4;
				$third_round  = 2;
				$fourth_round = 1;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '32' === $num_teams ) {
				$first_round  = 16;
				$second_round = 8;
				$third_round  = 4;
				$fourth_round = 2;
				$fifth_round  = 1;
				$sixth_round  = 0;
			} else {
				$first_round  = 32;
				$second_round = 16;
				$third_round  = 8;
				$fourth_round = 4;
				$fifth_round  = 2;
				$sixth_round  = 1;
			}
		}
		?>
		<h2><?php esc_html_e( 'First Round Matchups', 'sports-bench' ); ?></h2>
		<div class="playoff-matchups-container">
			<?php
			$g = 1;
			$t = 1;
			while ( $g <= $first_round ) {
				?>
				<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
					<div class="playoff-series-inner">
						<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
						<p class=""></p>
						<input type="hidden" name="series_id[]" />
						<input type="hidden" name="playoff_round[]" value="first" />
						<table class="form-table">
							<thead>
								<tr>
									<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
									<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
									<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
										<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
									</td>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
										<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
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
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
										<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
									</td>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
										<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
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
									</td>
									<td>
									</td>
								</tr>
							<tbody>
						</table>
						<div class="field">
							<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
							<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
								<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
								<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
								<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
								<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
								<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
								<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
							</select>
						</div>
						<div class="field series-games">
							<table>
								<thead>
									<tr>
										<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
										<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
											</select>
										</td>
									</tr>
									<tr class="two-legs">
										<td>
											<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
											</select>
										</td>
									</tr>
									<tr class="three-games">
										<td>
											<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
											</select>
										</td>
									</tr>
									<tr class="five-games">
										<td>
											<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
											</select>
										</td>
									</tr>
									<tr class="five-games">
										<td>
											<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
											</select>
										</td>
									</tr>
									<tr class="seven-games">
										<td>
											<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
											</select>
										</td>
									</tr>
									<tr class="seven-games">
										<td>
											<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
											</select>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
				$g++;
				$t++;
			}
			?>
		</div>
		<?php
		if ( $num_rounds > 1 ) {
			?>
			<h2><?php esc_html_e( 'Second Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $second_round ) {
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]" />
							<input type="hidden" name="playoff_round[]" value="second" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="team-one">
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
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="team-two">
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
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 2 ) {
			?>
			<h2><?php esc_html_e( 'Third Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $third_round ) {
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]" />
							<input type="hidden" name="playoff_round[]" value="third" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="team-one">
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
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="team-two">
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
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 3 ) {
			?>
			<h2><?php esc_html_e( 'Fourth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $fourth_round ) {
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]" />
							<input type="hidden" name="playoff_round[]" value="fourth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="team-one">
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
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="team-two">
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
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 4 ) {
			?>
			<h2><?php esc_html_e( 'Fifth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $fifth_round ) {
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]" />
							<input type="hidden" name="playoff_round[]" value="fifth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="team-one">
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
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="team-two">
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
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 5 ) {
			?>
			<h2><?php esc_html_e( 'Sixth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $second_round ) {
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]" />
							<input type="hidden" name="playoff_round[]" value="sixth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $teams->get_team_id() ); ?>"><?php echo esc_html( $teams->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $teams->get_team_id() ); ?>"><?php echo esc_html( $teams->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game"><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs"><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three"><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five"><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven"><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
	}

	public function get_teams_list( $season ) {
		global $wpdb;
		$table_name = SB_TABLE_PREFIX . 'teams';
		$teams      = [];
		if ( $season ) {
			$table_name = SB_TABLE_PREFIX . 'teams';
			$sql        = "SELECT team_id FROM $table_name ORDER BY team_name ASC";
		} else {
			$table_name = SB_TABLE_PREFIX . 'teams';
			$sql        = "SELECT team_id FROM $table_name ORDER BY team_name ASC";
		}
		$results = Database::get_results( $sql );

		if ( $results ) {
			foreach ( $results as $team ) {
				$teams[] = new Team( (int) $team->team_id );
			}
		}

		return $teams;
	}

	/**
	 * Displays the series in the admin area for a selected bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param array $bracket      The array of information for a selected bracket.
	 */
	public function display_series( $bracket ) {
		$bracket            = new Bracket( $bracket['bracket_id'] );
		$first_round_games  = $bracket->get_series( 'first' );
		$second_round_games = $bracket->get_series( 'second' );
		$third_round_games  = $bracket->get_series( 'third' );
		$fourth_round_games = $bracket->get_series( 'fourth' );
		$fifth_round_games  = $bracket->get_series( 'fifth' );
		$sixth_round_games  = $bracket->get_series( 'sixth' );

		$num_teams        = $bracket->get_num_teams();
		$elimination_type = $bracket->get_bracket_format();
		$season           = $bracket->get_bracket_season();

		if ( 2 === $num_teams ) {
			$num_rounds = 1;
			$byes       = false;
		} elseif ( '4' === $num_teams ) {
			$num_rounds = 2;
			$byes       = false;
		} elseif ( '6' === $num_teams ) {
			$num_rounds = 3;
			$byes       = true;
		} elseif ( '8' === $num_teams ) {
			$num_rounds = 3;
			$byes       = false;
		} elseif ( '12' === $num_teams ) {
			$num_rounds = 4;
			$byes       = true;
		} elseif ( '16' === $num_teams ) {
			$num_rounds = 4;
			$byes       = false;
		} elseif ( '24' === $num_teams ) {
			$num_rounds = 5;
			$byes       = true;
		} elseif ( '32' === $num_teams ) {
			$num_rounds = 5;
			$byes       = false;
		} else {
			$num_rounds = 6;
			$byes       = false;
		}

		if ( 'double' === $elimination_type ) {
			$num_rounds = 5;
			$byes       = false;
		}

		$teams = $this->get_teams_list( $season );

		if ( 'double' === $elimination_type ) {
			$first_round  = 2;
			$second_round = 2;
			$third_round  = 1;
			$fourth_round = 1;
			$fifth_round  = 1;
		} elseif ( true === $byes ) {
			if ( '6' === $num_teams ) {
				$first_round  = 2;
				$second_round = 2;
				$third_round  = 1;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '12' === $num_teams ) {
				$first_round  = 4;
				$second_round = 4;
				$third_round  = 2;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} else {
				$first_round  = 8;
				$second_round = 8;
				$third_round  = 4;
				$fourth_round = 2;
				$fifth_round  = 1;
				$sixth_round  = 0;
			}
		} else {
			if ( '2' === $num_teams ) {
				$first_round  = 1;
				$second_round = 0;
				$third_round  = 0;
				$third_round  = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '4' === $num_teams ) {
				$first_round  = 2;
				$second_round = 1;
				$third_round  = 0;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '8' === $num_teams ) {
				$first_round  = 4;
				$second_round = 2;
				$third_round  = 1;
				$fourth_round = 0;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '16' === $num_teams ) {
				$first_round  = 8;
				$second_round = 4;
				$third_round  = 2;
				$fourth_round = 1;
				$fifth_round  = 0;
				$sixth_round  = 0;
			} elseif ( '32' === $num_teams ) {
				$first_round  = 16;
				$second_round = 8;
				$third_round  = 4;
				$fourth_round = 2;
				$fifth_round  = 1;
				$sixth_round  = 0;
			} else {
				$first_round  = 32;
				$second_round = 16;
				$third_round  = 8;
				$fourth_round = 4;
				$fifth_round  = 2;
				$sixth_round  = 1;
			}
		}

		?>
		<h2><?php esc_html_e( 'First Round Matchups', 'sports-bench' ); ?></h2>
		<div class="playoff-matchups-container">
			<?php
			$g = 1;
			$t = 1;
			while ( $g <= $first_round ) {
				$series   = $first_round_games[ $g - 1 ];
				$games    = $this->get_series_games( $series, $season );
				$game_ids = explode( ', ', $series->get_game_ids() );
				?>
				<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
					<div class="playoff-series-inner">
						<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
						<p class=""></p>
						<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
						<input type="hidden" name="playoff_round[]" value="first" />
						<table class="form-table">
							<thead>
								<tr>
									<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
									<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
									<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
										<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
									</td>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
										<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
											<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
											<?php
											if ( $teams ) {
												foreach ( $teams as $team ) {
													?>
													<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
										<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
									</td>
									<td>
										<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
										<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
											<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
											<?php
											if ( $teams ) {
												foreach ( $teams as $team ) {
													?>
													<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
													<?php
												}
											}
											?>
										</select>
									</td>
									<td>
									</td>
								</tr>
							<tbody>
						</table>
						<div class="field">
							<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
							<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
								<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
								<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
								<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
								<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
								<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
								<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
							</select>
						</div>
						<div class="field series-games">
							<table>
								<thead>
									<tr>
										<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
										<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
										</td>
									</tr>
									<tr class="two-legs">
										<td>
											<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>
									<tr class="three-games">
										<td>
											<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>
									<tr class="five-games">
										<td>
											<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>
									<tr class="five-games">
										<td>
											<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>
									<tr class="seven-games">
										<td>
											<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>
									<tr class="seven-games">
										<td>
											<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
										</td>
										<td>
											<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
												<?php
												foreach ( $games as $game ) {
													$home_team = new Team( (int) $game->get_game_home_id() );
													$away_team = new Team( (int) $game->get_game_away_id() );
													if ( $game_ids[0] === $game->get_game_id() ) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													?>
													<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
													<?php
												}
												?>
											</select>
											</select>
										</td>
									</tr>

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php
				$g++;
				$t++;
			}
			?>
		</div>
		<?php
		if ( $num_rounds > 1 ) {
			?>
			<h2><?php esc_html_e( 'Second Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $second_round ) {
					$series   = $second_round_games[ $g - 1 ];
					$games    = $this->get_series_games( $series, $season );
					$game_ids = explode( ', ', $series->get_game_ids() );
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
							<input type="hidden" name="playoff_round[]" value="second" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 2 ) {
			?>
			<h2><?php esc_html_e( 'Third Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $third_round ) {
					$series   = $third_round_games[ $g - 1 ];
					$games    = $this->get_series_games( $series, $season );
					$game_ids = explode( ', ', $series->get_game_ids() );
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
							<input type="hidden" name="playoff_round[]" value="third" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 3 ) {
			?>
			<h2><?php esc_html_e( 'Fourth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $fourth_round ) {
					$series   = $fourth_round_games[ $g - 1 ];
					$games    = $this->get_series_games( $series, $season );
					$game_ids = explode( ', ', $series->get_game_ids() );
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
							<input type="hidden" name="playoff_round[]" value="fourth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 4 ) {
			?>
			<h2><?php esc_html_e( 'Fifth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $fifth_round ) {
					$series   = $fifth_round_games[ $g - 1 ];
					$games    = $this->get_series_games( $series, $season );
					$game_ids = explode( ', ', $series->get_game_ids() );
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
							<input type="hidden" name="playoff_round[]" value="fifth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
			</div>
			<?php
		}
		if ( $num_rounds > 5 ) {
			?>
			<h2><?php esc_html_e( 'Sixth Round Matchups', 'sports-bench' ); ?></h2>
			<div class="playoff-matchups-container">
				<?php
				$g = 1;
				while ( $g <= $second_round ) {
					$series   = $sixth_round_games[ $g - 1 ];
					$games    = $this->get_series_games( $series, $season );
					$game_ids = explode( ', ', $series->get_game_ids() );
					?>
					<div class="playoff-matchup playoff-series" id="series-<?php echo esc_attr( $t ); ?>">
						<div class="playoff-series-inner">
							<h3><?php esc_html_e( 'Game', 'sports-bench' ); ?> <?php echo esc_html( $t ); ?></h3>
							<p class=""></p>
							<input type="hidden" name="series_id[]"  value="<?php echo esc_attr( $series->get_series_id() ); ?>" />
							<input type="hidden" name="playoff_round[]" value="sixth" />
							<table class="form-table">
								<thead>
									<tr>
										<th class="seed"><?php esc_html_e( 'Seed', 'sports-bench' ); ?></th>
										<th class="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></th>
										<th class="score"><?php esc_html_e( 'Score', 'sports-bench' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one-seed" class="screen-reader-text"><?php esc_html_e( 'Team One Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-one-seed" name="team_one_seed[]" value="<?php echo esc_attr( $series->get_team_one_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-one" class="screen-reader-text"><?php esc_html_e( 'Team One', 'sports-bench' ); ?></label>
											<select name="team_one_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-one" class="series-team team-one">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_one_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two-seed" class="screen-reader-text"><?php esc_html_e( 'Team Two Seed', 'sports-bench' ); ?></label>
											<input type="number" id="series-<?php echo esc_attr( $t ); ?>-team-two-seed" name="team_two_seed[]" value="<?php echo esc_attr( $series->get_team_two_seed() ); ?>" />
										</td>
										<td>
											<label for="series-<?php echo esc_attr( $t ); ?>-team-two" class="screen-reader-text"><?php esc_html_e( 'Team Two', 'sports-bench' ); ?></label>
											<select name="team_two_id[]" id="series-<?php echo esc_attr( $t ); ?>-team-two" class="series-team team-two">
												<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
												<?php
												if ( $teams ) {
													foreach ( $teams as $team ) {
														?>
														<option value="<?php echo esc_attr( $team->get_team_id() ); ?>" <?php selected( $series->get_team_two_id(), $team->get_team_id() ); ?>><?php echo esc_html( $team->get_team_name() ); ?></option>
														<?php
													}
												}
												?>
											</select>
										</td>
										<td>
										</td>
									</tr>
								<tbody>
							</table>
							<div class="field">
								<label for="series-<?php echo esc_attr( $t ); ?>-format"><?php esc_html_e( 'Format', 'sports-bench' ); ?></label>
								<select name="series_format[]" id="series-<?php echo esc_attr( $t ); ?>-format" class="format-select">
									<option value=""><?php esc_html_e( 'Select a Format', 'sports-bench' ); ?></option>
									<option value="single-game" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'single-game' ); ?>><?php esc_html_e( 'One Game', 'sports-bench' ); ?></option>
									<option value="two-legs" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'two-legs' ); ?>><?php esc_html_e( 'Two Games', 'sports-bench' ); ?></option>
									<option value="best-of-three" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-three' ); ?>><?php esc_html_e( 'Best of Three', 'sports-bench' ); ?></option>
									<option value="best-of-five" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-five' ); ?>><?php esc_html_e( 'Best of Five', 'sports-bench' ); ?></option>
									<option value="best-of-seven" <?php selected( $first_round_games[ $g - 1 ]->get_series_format(), 'best-of-seven' ); ?>><?php esc_html_e( 'Best of Seven', 'sports-bench' ); ?></option>
								</select>
							</div>
							<div class="field series-games">
								<table>
									<thead>
										<tr>
											<th><?php esc_html_e( 'Game Number', 'sports-bench' ); ?></th>
											<th><?php esc_html_e( 'Selected Game', 'sports-bench' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<label for="game-one-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game One', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-one-<?php echo esc_attr( $t ); ?>" name="game_one_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[0], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>
										<tr class="two-legs">
											<td>
												<label for="game-two-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Two', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-two-<?php echo esc_attr( $t ); ?>" name="game_two_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[1], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="three-games">
											<td>
												<label for="game-three-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Three', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-three-<?php echo esc_attr( $t ); ?>" name="game_three_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[2], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-four-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Four', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-four-<?php echo esc_attr( $t ); ?>" name="game_four_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[3], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="five-games">
											<td>
												<label for="game-five-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Five', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-five-<?php echo esc_attr( $t ); ?>" name="game_five_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[4], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-six-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Six', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-six-<?php echo esc_attr( $t ); ?>" name="game_six_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[5], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>
										<tr class="seven-games">
											<td>
												<label for="game-seven-<?php echo esc_attr( $t ); ?>"><?php esc_html_e( 'Game Seven', 'sports-bench' ); ?></label>
											</td>
											<td>
												<select class="series-game" id="game-seven-<?php echo esc_attr( $t ); ?>" name="game_seven_id[]">
													<?php
													foreach ( $games as $game ) {
														$home_team = new Team( (int) $game->get_game_home_id() );
														$away_team = new Team( (int) $game->get_game_away_id() );
														if ( $game_ids[0] === $game->get_game_id() ) {
															$selected = 'selected="selected"';
														} else {
															$selected = '';
														}
														?>
														<option value="<?php echo esc_attr( $game->get_game_id() ); ?>" <?php selected( $game_ids[6], $game->get_game_id() ); ?>><?php echo esc_html( $game->get_game_day( 'F j, Y' ) . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name() ); ?></option>
														<?php
													}
													?>
												</select>
												</select>
											</td>
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php
					$g++;
					$t++;
				}
				?>
				</div>
			<?php
		}
	}

	/**
	 * Gets the games for a select playoff series.
	 *
	 * @since 2.0.0
	 *
	 * @param Series $series      The series object to get games from.
	 * @param string $season      The season to get the games from.
	 * @return array              The list of Game objects for the series.
	 */
	public function get_series_games( $series, $season ) {
		global $wpdb;
		$table      = SB_TABLE_PREFIX . 'games';
		$games_list = [];

		if ( $series ) {
			$sql        = $wpdb->prepare( "SELECT game_id FROM $table WHERE ( game_home_id = %d AND game_away_id = %d ) OR ( game_home_id = %d AND game_away_id = %d ) AND game_season = %s;", $series->get_team_one_id(), $series->get_team_two_id(), $series->get_team_two_id(), $series->get_team_one_id(), $season );
			$games      = Database::get_results( $sql );

			if ( $games ) {
				foreach ( $games as $game ) {
					$games_list[] = new Game( $game->game_id );
				}
			}
		}

		return $games_list;
	}
}
