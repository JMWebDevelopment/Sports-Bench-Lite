<?php
/**
 * Creates the playoff bracket class.
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

namespace Sports_Bench\Classes\Base;

use Sports_Bench\Classes\Base\Series;

/**
 * The core bracket class.
 *
 * This is used for brackets in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Bracket {

	/**
	 * The id of the bracket.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $bracket_id;

	/**
	 * The number of teams in the bracket.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	public $num_teams;

	/**
	 * The format of the bracket.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $bracket_format;

	/**
	 * The title of the bracket.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $bracket_title;

	/**
	 * The season of the bracket.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $bracket_season;


	/**
	 * Creates the new Bracket object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param int $bracket_id      The ID of the bracket to create the object for.
	 */
	public function __construct( $bracket_id ) {
		global $wpdb;
		$table   = SB_TABLE_PREFIX . 'playoff_brackets';
		$bracket = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE bracket_id = %d;", $bracket_id ) );

		if ( $bracket ) {
			$this->bracket_id     = $bracket[0]->bracket_id;
			$this->num_teams      = $bracket[0]->num_teams;
			$this->bracket_format = $bracket[0]->bracket_format;
			$this->bracket_title  = $bracket[0]->bracket_title;
			$this->bracket_season = $bracket[0]->bracket_season;
		}
	}

	/**
	 * Returns the bracket id.
	 *
	 * @since 2.0
	 *
	 * @return int      The bracket id.
	 */
	public function get_bracket_id() {
		return $this->bracket_id;
	}

	/**
	 * Returns the number of teams in the bracket.
	 *
	 * @since 2.0
	 *
	 * @return int      The number of teams in the bracket.
	 */
	public function get_num_teams() {
		return $this->num_teams;
	}

	/**
	 * Returns the bracket format.
	 *
	 * @since 2.0
	 *
	 * @return string      The bracket format.
	 */
	public function get_bracket_format() {
		return $this->bracket_format;
	}

	/**
	 * Returns the bracket title.
	 *
	 * @since 2.0
	 *
	 * @return string      The bracket title.
	 */
	public function get_bracket_title() {
		return $this->bracket_title;
	}

	/**
	 * Returns the bracket string.
	 *
	 * @since 2.0
	 *
	 * @return string      The bracket season.
	 */
	public function get_bracket_season() {
		return $this->bracket_season;
	}

	/**
	 * Updates the bracket with new information provided.
	 *
	 * @since 2.0.0
	 *
	 * @param array $values     The values to change for the bracket in key => value pairs.
	 */
	public function update( $values ) {
		$current_values = [
			'bracket_id'     => $this->bracket_id,
			'num_teams'      => $this->num_teams,
			'bracket_format' => $this->bracket_format,
			'bracket_title'  => $this->bracket_title,
			'bracket_season' => $this->bracket_season,
		];
		$data           = wp_parse_args( $values, $current_values );
		Database::update_row( 'playoff_brackets', array( 'bracket_id' => $this->bracket_id ), $data );

		$this->bracket_id     = $data['bracket_id'];
		$this->num_teams      = $data['num_teams'];
		$this->bracket_format = $data['bracket_format'];
		$this->bracket_title  = stripslashes( $data['bracket_title'] );
		$this->bracket_season = $data['bracket_season'];
	}

	/**
	 * Gets a list of series for a selected round for the bracket.
	 *
	 * @since 2.0.0
	 *
	 * @param string|null $round     The round to get the series for. Leave blank to get all of the series for the bracket.
	 * @return array                 The list of series.
	 */
	public function get_series( $round = null ) {
		global $wpdb;
		$table  = SB_TABLE_PREFIX . 'playoff_series';
		$series = [];

		if ( null !== $round ) {
			$sql = $wpdb->prepare( "SELECT series_id FROM $table WHERE bracket_id = %d AND playoff_round = %s", $this->bracket_id, $round );
		} else {
			$sql = "SELECT series_id FROM $table";
		}
		$results = Database::get_results( $sql );

		if ( $results ) {
			foreach ( $results as $result ) {
				$series[] = new Series( $result->series_id );
			}
		}

		return $series;
	}

	/**
	 * Displays the playoff bracket.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the bracket.
	 */
	public function show_playoff_bracket() {

		$html = '';

		$title     = $this->bracket_title;
		$num_teams = $this->num_teams;
		$format    = $this->bracket_format;

		$round_count = 0;
		$i           = $num_teams;
		while ( $i > 1 ) {
			$i = $i / 2;
			$round_count++;
		}

		if ( 'double' === $format ) {
			$round_count = 5;
		}

		if ( 0 === $num_teams % 6 ) {
			$byes = true;
		} else {
			$byes = false;
		}

		if ( true === $byes && 6 === $num_teams ) {
			$num_teams = 4;
		} elseif ( true === $byes && 12 === $num_teams ) {
			$num_teams = 8;
		}

		$first_round  = $this->get_series( 'first' );
		$second_round = $this->get_series( 'second' );
		$third_round  = $this->get_series( 'third' );
		$fourth_round = $this->get_series( 'fourth' );
		$fifth_round  = $this->get_series( 'fifth' );
		$sixth_round  = $this->get_series( 'sixth' );

		$first_round_index  = 0;
		$second_round_index = 0;
		$third_round_index  = 0;
		$fourth_round_index = 0;
		$fifth_round_index  = 0;
		$sixth_round_index  = 0;

		$round_two   = 0;
		$round_three = 0;
		$round_four  = 0;
		$round_five  = 0;
		$round_six   = 0;

		$game_numbers = [ esc_html__( 'Game One', 'sports-bench' ), esc_html__( 'Game Two', 'sports-bench' ), esc_html__( 'Game Three', 'sports-bench' ),__( 'Game Four', 'sports-bench' ), esc_html__( 'Game Five', 'sports-bench' ), esc_html__( 'Game Six', 'sports-bench' ), esc_html__( 'Game Seven', 'sports-bench' ) ];
		$round_title  = [ esc_html__( 'First Round', 'sports-bench' ), esc_html__( 'Second Round', 'sports-bench' ), esc_html__( 'Third Round', 'sports-bench' ),__( 'Fourth Round', 'sports-bench' ), esc_html__( 'Fifth Round', 'sports-bench' ), esc_html__( 'Sixth Round', 'sports-bench' ) ];

		$html .= '<h3 class="bracket-title">' . $title . '</h3>';
		$html .= '<div class="sports-bench-bracket">';
		if ( false === $byes && 'single' === $format ) {
			$html .= '<table>';
			$html .= '<thead>';
			$html .= '<tr>';
			for ( $i = 0; $i < $round_count; $i++ ) {
				$html .= '<th class="round-title">' . $round_title[ $i ] . '</th>';
			}
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			for ( $i = 1; $i < $num_teams; $i++ ) {
				$html .= '<tr>';
				for ( $j = 1; $j <= $round_count; $j++ ) {
					$html .= '<td>';
					if ( ( 1 === $i % 2 ) && ( 1 === $j ) ) {
						$series   = $first_round[ $first_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$first_round_index++;
					} elseif ( ( 2 === $i || $round_two + 4 == $i ) && ( 2 === $j ) ) {
						$series   = $second_round[ $second_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( $team_two->get_team_nickname() != null ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html     .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html     .= '</div>';
						$round_two = $i;
						$second_round_index++;
					} elseif ( ( 4 === $i || $round_three + 8 == $i ) && ( 3 === $j ) ) {
						$series   = $third_round[ $third_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html       .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html       .= '</div>';
						$round_three = $i;
						$third_round_index++;
					} elseif ( ( 8 === $i || $round_four + 16 == $i ) && ( 4 === $j ) ) {
						$series   = $fourth_round[ $fourth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html      .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html      .= '</div>';
						$round_four = $i;
						$fourth_round_index++;
					} elseif ( ( 16 === $i || $round_five + 32 == $i ) && ( 5 === $j ) ) {
						$series   = $fifth_round[ $fifth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html      .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html      .= '</div>';
						$round_five = $i;
						$fifth_round_index++;
					} elseif ( ( 32 === $i || $round_six + 64 == $i ) && ( 6 === $j ) ) {
						$series   = $sixth_round[ $sixth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html     .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html     .= '</div>';
						$round_six = $i;
						$sixth_round_index++;
					}
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} elseif ( true === $byes  && 'single' === $format ) {
			$html .= '<table>';
			$html .= '<thead>';
			$html .= '<tr>';
			for ( $i = 0; $i < $round_count; $i++ ) {
				$html .= '<th class="round-title">' . $round_title[ $i ] . '</th>';
			}
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			for ( $i = 1; $i < $num_teams; $i++ ) {
				$html .= '<tr>';
				for ( $j = 1; $j <= $round_count; $j++ ) {
					$html .= '<td>';
					if ( ( 1 === $i % 2 ) && ( 1 === $j ) ) {
						$series   = $first_round[ $first_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$first_round_index++;
					} elseif ( ( $i % 2 === 1 ) && ( 2 === $j ) ) {
						$series   = $second_round[ $second_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$second_round_index++;
					} elseif ( ( 2 === $i || $round_three + 4 == $i ) && ( 3 === $j ) ) {
						$series   = $third_round[ $third_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html       .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html       .= '</div>';
						$round_three = $i;
						$third_round_index++;
					} elseif ( ( 4 === $i || $round_four + 8 == $i ) && ( 4 === $j ) ) {
						$series   = $fourth_round[ $fourth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html      .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html      .= '</div>';
						$round_four = $i;
						$fourth_round_index++;
					} elseif ( ( 8 === $i || $round_five + 16 == $i ) && ( 5 === $j ) ) {
						$series   = $fifth_round[ $fifth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html      .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html      .= '</div>';
						$round_five = $i;
						$fifth_round_index++;
					}
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		} elseif ( 'double' === $format ) {
			$html .= '<table>';
			$html .= '<thead>';
			$html .= '<tr>';
			for ( $i = 0; $i < $round_count; $i++ ) {
				$html .= '<th class="round-title">' . $round_title[ $i ] . '</th>';
			}
			$html .= '</tr>';
			$html .= '</thead>';
			$html .= '<tbody>';
			for ( $i = 1; $i <= $num_teams; $i++ ) {
				$html .= '<tr>';
				for ( $j = 1; $j <= $round_count; $j++ ) {
					$html .= '<td>';
					if ( ( 1 === $i % 2 ) && ( 1 === $j ) ) {
						$series   = $first_round[ $first_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$first_round_index++;
					} elseif ( ( 0 === $i % 2 ) && ( 2 === $j ) ) {
						$series   = $second_round[ $second_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$second_round_index++;
					} elseif ( ( 3 === $i ) && ( 3 === $j ) ) {
						$series   = $third_round[ $third_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$third_round_index++;
					} elseif ( ( 2 == $i ) && ( 4 === $j ) ) {
						$series  = $fourth_round[ $fourth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$fourth_round_index++;
					} elseif ( ( 2 === $i ) && ( 5 === $j ) ) {
						$series   = $fifth_round[ $fifth_round_index ];
						$team_one = new Team( (int) $series->get_team_one_id() );
						$team_two = new Team( (int) $series->get_team_two_id() );
						if ( null !== $team_one->get_team_nickname() ) {
							$team_one_name  = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
							$team_one_class = ' has-nickname';
						} else {
							$team_one_name  = $team_one->get_team_location();
							$team_one_class = '';
						}
						if ( null !== $team_two->get_team_nickname() ) {
							$team_two_name  = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
							$team_two_class = ' has-nickname';
						} else {
							$team_two_name  = $team_two->get_team_nickname();
							$team_two_class = '';
						}
						$html .= '<div class="playoff-series">';

						/**
						 * Displays the series for the playoff bracket.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html                The incoming HTML for the series.
						 * @param Series $series              The current playoff series object.
						 * @param Team   $team_one            The team object for the first team.
						 * @param string $team_one_class      The CSS class for the first team.
						 * @param string $team_one_name       The name of the first team.
						 * @param Team   $team_two            The team object for the second team.
						 * @param string $team_two_class      The CSS class for the second team.
						 * @param string $team_two_name       The name of the second team.
						 * @param array  $game_numbers        The list of possible game numbers for the series.
						 * @return string                     The HTML to display the playoff series.
						 */
						$html .= apply_filters( 'sports_bench_playoff_series', '', $series, $team_one, $team_one_class, $team_one_name, $team_two, $team_two_class, $team_two_name, $game_numbers );
						$html .= '</div>';
						$fifth_round_index++;
					}
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
			$html .= '</tbody>';
			$html .= '</table>';
		}
		$html .= '</div>';

		return $html;
	}

}
