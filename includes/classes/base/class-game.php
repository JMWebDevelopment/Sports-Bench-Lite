<?php
/**
 * Creates the game class.
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

use Sports_Bench\Classes\Base\Team;

use Sports_Bench\Classes\Sports\Baseball\BaseballGame;
use Sports_Bench\Classes\Sports\Basketball\BasketballGame;
use Sports_Bench\Classes\Sports\Football\FootballGame;
use Sports_Bench\Classes\Sports\Hockey\HockeyGame;
use Sports_Bench\Classes\Sports\Rugby\RugbyGame;
use Sports_Bench\Classes\Sports\Soccer\SoccerGame;
use Sports_Bench\Classes\Sports\Volleyball\VolleyballGame;

/**
 * The core game class.
 *
 * This is used for games in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Game {

	/**
	 * The id of the game.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_id;

	/**
	 * The week of the game.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_week;

	/**
	 * The season the game is in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_season;

	/**
	 * The date of the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_day;

	/**
	 * The id of home team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_home_id;

	/**
	 * The final score for the home team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_home_final;

	/**
	 * The id of the away team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_away_id;

	/**
	 * The final score for the away team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_away_final;

	/**
	 * The attendance of the game.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_attendance;

	/**
	 * The link to the preview of the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $preview_link;

	/**
	 * The link to the recap of the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $recap_link;

	/**
	 * The current status of the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_status;

	/**
	 * The current time in the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_current_time;

	/**
	 * The current period/quarter/inning the game is currently in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	public $game_current_period;

	/**
	 * The current score for the home team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_current_home_score;

	/**
	 * The current score for the away team.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_current_away_score;

	/**
	 * Whether the game is at a neutral site or not.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_neutral_site;

	/**
	 * The stadium for the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_stadium;

	/**
	 * The first line of the address for the stadium for the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_line_one;

	/**
	 * The second line of the address for the stadium for the game.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_line_two;

	/**
	 * The city that the stadium for the game is in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_city;

	/**
	 * The state that the stadium for the game is in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_state;

	/**
	 * The country that the stadium for the game is in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_country;

	/**
	 * The zip code that the stadium for the game is in.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $game_location_zip_code;


	/**
	 * Creates the new Game object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The ID of the game to create the object for.
	 */
	public function __construct( $game_id ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$game  = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $game_id ) );

		if ( $game ) {
			$this->game_id                 = $game[0]->game_id;
			$this->game_week               = $game[0]->game_week;
			$this->game_season             = $game[0]->game_season;
			$this->game_day                = $game[0]->game_day;
			$this->game_home_id            = $game[0]->game_home_id;
			$this->game_home_final         = $game[0]->game_home_final;
			$this->game_away_id            = $game[0]->game_away_id;
			$this->game_away_final         = $game[0]->game_away_final;
			$this->game_attendance         = $game[0]->game_attendance;
			$this->game_status             = $game[0]->game_status;
			$this->game_current_time       = stripslashes( $game[0]->game_current_time );
			$this->game_current_period     = $game[0]->game_current_period;
			$this->game_current_home_score = $game[0]->game_current_home_score;
			$this->game_current_away_score = $game[0]->game_current_away_score;
			$this->preview_link            = $game[0]->game_preview;
			$this->recap_link              = $game[0]->game_recap;
			$this->game_neutral_site       = $game[0]->game_neutral_site;
			$this->game_location_stadium   = stripslashes( $game[0]->game_location_stadium );
			$this->game_location_line_one  = stripslashes( $game[0]->game_location_line_one );
			$this->game_location_line_two  = stripslashes( $game[0]->game_location_line_two );
			$this->game_location_city      = stripslashes( $game[0]->game_location_city );
			$this->game_location_state     = stripslashes( $game[0]->game_location_state );
			$this->game_location_country   = stripslashes( $game[0]->game_location_country );
			$this->game_location_zip_code  = stripslashes( $game[0]->game_location_zip_code );
		}
	}

	/**
	 * Returns the game id.
	 *
	 * @since 2.0
	 *
	 * @return int      The game id.
	 */
	public function get_game_id() {
		return $this->game_id;
	}

	/**
	 * Returns the game week.
	 *
	 * @since 2.0
	 *
	 * @return string      The game week.
	 */
	public function get_game_week() {
		return $this->game_week;
	}

	/**
	 * Returns the game season.
	 *
	 * @since 2.0
	 *
	 * @return string      The game season.
	 */
	public function get_game_season() {
		return $this->game_season;
	}

	/**
	 * Returns the game day.
	 *
	 * @since 2.0
	 *
	 * @param null|string $format      The format to return the date in.
	 * @return string                  The game day.
	 */
	public function get_game_day( $format = null ) {
		if ( null === $format ) {
			return $this->game_day;
		} else {
			return date_format( date_create( $this->game_day ), $format );
		}
	}

	/**
	 * Returns the game home team id.
	 *
	 * @since 2.0
	 *
	 * @return int      The game home team id.
	 */
	public function get_game_home_id() {
		return $this->game_home_id;
	}

	/**
	 * Returns the game home team final.
	 *
	 * @since 2.0
	 *
	 * @return int      The game home team final.
	 */
	public function get_game_home_final() {
		return $this->game_home_final;
	}

	/**
	 * Returns the game away team id.
	 *
	 * @since 2.0
	 *
	 * @return int      The game away team id.
	 */
	public function get_game_away_id() {
		return $this->game_away_id;
	}

	/**
	 * Returns the game away team final.
	 *
	 * @since 2.0
	 *
	 * @return int      The game away team final.
	 */
	public function get_game_away_final() {
		return $this->game_away_final;
	}

	/**
	 * Returns the game attendance.
	 *
	 * @since 2.0
	 *
	 * @return int      The game attendance.
	 */
	public function get_game_attendance() {
		return $this->game_attendance;
	}

	/**
	 * Returns the game status.
	 *
	 * @since 2.0
	 *
	 * @return string      The game status.
	 */
	public function get_game_status() {
		return $this->game_status;
	}

	/**
	 * Returns the game current time.
	 *
	 * @since 2.0
	 *
	 * @return string      The game current time.
	 */
	public function get_game_current_time() {
		return $this->game_current_time;
	}

	/**
	 * Returns the game period.
	 *
	 * @since 2.0
	 *
	 * @return int      The game period.
	 */
	public function get_game_current_period() {
		return $this->game_current_period;
	}

	/**
	 * Returns the game current home score.
	 *
	 * @since 2.0
	 *
	 * @return int      The current home score.
	 */
	public function get_game_current_home_score() {
		return $this->game_current_home_score;
	}

	/**
	 * Returns the game current away score.
	 *
	 * @since 2.0
	 *
	 * @return int      The current away score.
	 */
	public function get_game_current_away_score() {
		return $this->game_current_away_score;
	}

	/**
	 * Returns the game preview link.
	 *
	 * @since 2.0
	 *
	 * @return string      The game preview link.
	 */
	public function get_game_preview() {
		return $this->preview_link;
	}

	/**
	 * Returns the game recap link.
	 *
	 * @since 2.0
	 *
	 * @return string      The game recap link.
	 */
	public function get_game_recap() {
		return $this->recap_link;
	}

	/**
	 * Returns the game neutral site.
	 *
	 * @since 2.0
	 *
	 * @return int      The game neutral site.
	 */
	public function get_game_neutral_site() {
		return $this->game_neutral_site;
	}

	/**
	 * Returns the game location stadium.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location stadum.
	 */
	public function get_game_location_stadium() {
		return $this->game_location_stadium;
	}

	/**
	 * Returns the game location address first line.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location address first line.
	 */
	public function get_game_location_line_one() {
		return $this->game_location_line_one;
	}

	/**
	 * Returns the game location address second line.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location address second line.
	 */
	public function get_game_location_line_two() {
		return $this->game_location_line_two;
	}

	/**
	 * Returns the game location city.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location city.
	 */
	public function get_game_location_city() {
		return $this->game_location_city;
	}

	/**
	 * Returns the game location state.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location state.
	 */
	public function get_game_location_state() {
		return $this->game_location_state;
	}

	/**
	 * Returns the game location country.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location country.
	 */
	public function get_game_location_country() {
		return $this->game_location_country;
	}

	/**
	 * Returns the game location ZIP code.
	 *
	 * @since 2.0
	 *
	 * @return string      The game location ZIP code.
	 */
	public function get_game_location_zip_code() {
		return $this->game_location_zip_code;
	}

	/**
	 * Returns a team object for the away team.
	 *
	 * @since 2.0
	 *
	 * @return Team      The team object for the away team.
	 */
	public function get_away_team() {
		return new Team( (int) $this->game_away_id );
	}

	/**
	 * Returns a team object for the home team.
	 *
	 * @since 2.0
	 *
	 * @return Team      The team object for the home team.
	 */
	public function get_home_team() {
		return new Team( (int) $this->game_home_id );
	}

	/**
	 * Updates the game with new information provided.
	 *
	 * @since 2.0.0
	 *
	 * @param array $values     The values to change for the game in key => value pairs.
	 */
	public function update( $values ) {
		$current_values = [
			'game_id'                 => $this->game_id,
			'game_week'               => $this->game_week,
			'game_season'             => $this->game_season,
			'game_day'                => $this->game_day,
			'game_home_id'            => $this->game_home_id,
			'game_home_final'         => $this->game_home_final,
			'game_away_id'            => $this->game_away_id,
			'game_away_final'         => $this->game_away_final,
			'game_attendance'         => $this->game_attendance,
			'game_status'             => $this->game_status,
			'game_current_time'       => $this->game_current_time,
			'game_current_period'     => $this->game_current_period,
			'game_current_home_score' => $this->game_current_home_score,
			'game_current_away_score' => $this->game_current_away_score,
			'game_preview'            => $this->preview_link,
			'game_recap'              => $this->recap_link,
			'game_neutral_site'       => $this->game_neutral_site,
			'game_location_stadium'   => $this->game_location_stadium,
			'game_location_line_one'  => $this->game_location_line_one,
			'game_location_line_two'  => $this->game_location_line_two,
			'game_location_city'      => $this->game_location_city,
			'game_location_state'     => $this->game_location_state,
			'game_location_country'   => $this->game_location_country,
			'game_location_zip_code'  => $this->game_location_zip_code,
		];
		$data           = wp_parse_args( $values, $current_values );
		Database::update_row( 'games', array( 'game_id' => $this->game_id ), $data );

		$this->game_id                 = $data['game_id'];
		$this->game_week               = $data['game_week'];
		$this->game_season             = $data['game_season'];
		$this->game_day                = $data['game_day'];
		$this->game_home_id            = $data['game_home_id'];
		$this->game_home_final         = $data['game_home_final'];
		$this->game_away_id            = $data['game_away_id'];
		$this->game_away_final         = $data['game_away_final'];
		$this->game_attendance         = $data['game_attendance'];
		$this->game_status             = $data['game_status'];
		$this->game_current_time       = stripslashes( $data['game_current_time'] );
		$this->game_current_period     = $data['game_current_period'];
		$this->game_current_home_score = $data['game_current_home_score'];
		$this->game_current_away_score = $data['game_current_away_score'];
		$this->preview_link            = $data['game_preview'];
		$this->recap_link              = $data['game_recap'];
		$this->game_neutral_site       = $data['game_neutral_site'];
		$this->game_location_stadium   = stripslashes( $data['game_location_stadium'] );
		$this->game_location_line_one  = stripslashes( $data['game_location_line_one'] );
		$this->game_location_line_two  = stripslashes( $data['game_location_line_two'] );
		$this->game_location_city      = stripslashes( $data['game_location_city'] );
		$this->game_location_state     = stripslashes( $data['game_location_state'] );
		$this->game_location_country   = stripslashes( $data['game_location_country'] );
		$this->game_location_zip_code  = stripslashes( $data['game_location_zip_code'] );
	}

	/**
	 * Returns the permalink for the game box score.
	 *
	 * @since 2.0
	 *
	 * @return string       Link to the box score for the game.
	 */
	public function get_box_score_permalink() {
		if ( get_option( 'sports-bench-box-score-page' ) ) {
			return get_permalink( get_option( 'sports-bench-box-score-page' ) ) . '?game_id=' . $this->game_id;
		}

		return;
	}

	/**
	 * Returns the full address for the stadium the game is being played at.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The full address for the stadium.
	 */
	public function get_full_address() {
		$address = $this->get_address();

		if ( $this->game_location_stadium && ( null !== $address && '' !== $address ) ) {
			return $this->game_location_stadium . '<br />' . $address;
		} elseif ( $this->game_location_stadium ) {
			return $this->game_location_stadium;
		} else {
			return $address;
		}
	}

	/**
	 * Returns the address the game is being played at.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The address for the stadium.
	 */
	public function get_address() {
		$line_one   = false;
		$line_two   = false;
		$line_three = false;
		$address    = '';

		if ( $this->game_location_line_one ) {
			$address .= $this->game_location_line_one;
			$line_one = true;
		}

		if ( $this->game_location_line_two && true === $line_one ) {
			$address .= '<br />' . $this->game_location_line_two;
			$line_two = true;
		} elseif ( $this->game_location_line_two ) {
			$address .= $this->game_location_line_two;
			$line_two = true;
		}

		if ( $this->game_location_city && ( true === $line_one || true === $line_two ) ) {
			$address   .= '<br />' . $this->game_location_city;
			$line_three = true;
		} elseif ( $this->game_location_city ) {
			$address   .= $this->game_location_city;
			$line_three = true;
		}

		if ( $this->game_location_state && true === $line_three ) {
			$address .= ', ' . $this->game_location_state;
		} elseif ( $this->game_location_line_two ) {
			$address   .= $this->game_location_state;
			$line_three = true;
		}

		if ( $this->game_location_country && true === $line_three ) {
			$address .= ', ' . $this->game_location_country;
		} elseif ( $this->game_location_country ) {
			$address   .= $this->game_location_country;
			$line_three = true;
		}

		if ( $this->game_location_zip_code && true === $line_three ) {
			$address .= ', ' . $this->game_location_zip_code;
		} elseif ( $this->game_location_zip_code ) {
			$address .= $this->game_location_zip_code;
		}

		return $address;
	}

	/**
	 * Returns the box score for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game's box score.
	 */
	public function game_box_score_game_info() {
		$html = '';
		$home = new Team( (int) $this->game_home_id );
		$away = new Team( (int) $this->game_away_id );

		$html .= '<div id="score-info" class="box-score-section">';
		if ( $this->game_away_final > $this->game_home_final ) {
			$score = $away->get_team_name() . ' ' . $this->game_away_final . ', ' . $home->get_team_name() . ' ' . $this->game_home_final;
		} else {
			$score = $home->get_team_name() . ' ' . $this->game_home_final . ', ' . $away->get_team_name() . ' ' . $this->game_away_final;
		}
		$html .= '<h2>' . $score . '</h2>';
		$html .= $this->get_linescore_display();
		$html .= $this->show_game_info();

		if ( 'basketball' !== get_option( 'sports-bench-sport' ) && 'volleyball' !== get_option( 'sports-bench-sport' ) ) {
			$html .= $this->get_score_info();
		}
		$html .= '</div>';

		return $html;

	}

	/**
	 * Gets the linescore for a baseball game.
	 *
	 * @since 2.0.0
	 *
	 * @return array|null      The array for the linescore if the website is using baseball. Null if it's not.
	 */
	public function get_linescore() {

		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
			return $sport->get_linescore();
		}

		return;
	}

	/**
	 * Displays the linescore for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string       The HTML to display the linescore.
	 */
	public function get_linescore_display() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BasketballGame( $this->game_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new FootballGame( $this->game_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new HockeyGame( $this->game_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new RugbyGame( $this->game_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new SoccerGame( $this->game_id );
		} else {
			$sport = new VolleyballGame( $this->game_id );
		}
		return $sport->get_linescore_display();
	}

	/**
	 * Shows the information about a game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game information.
	 */
	public function show_game_info() {
		$html      = '';
		$home_team = new Team( (int) $this->game_home_id );

		/**
		 * Displays the infromation for a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML for the game information.
		 * @param Game   $game           The current game object.
		 * @param Team   $home_team      The home team object.
		 * @return string                The HTML for the game info.
		 */
		$html .= apply_filters( 'sports_bench_game_info', $html, $this, $home_team );
		return $html;
	}

	/**
	 * Gets the scoring/event information for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game scoring/events section.
	 */
	public function get_score_info() {
		global $wpdb;
		$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_info';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $this->game_id );
		if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			if ( 'in_progress' === $this->game_status ) {
				$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d ORDER BY game_info_time DESC;", $this->game_id );
			} else {
				$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d ORDER BY game_info_time ASC;", $this->game_id );
			}
		} elseif ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			if ( 'in_progress' === $this->game_status ) {
				$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d ORDER BY game_info_id DESC;", $this->game_id );
			} else {
				$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d ORDER BY game_info_id ASC;", $this->game_id );
			}
		}
		$events    = Database::get_results( $querystr );
		$away_team = new Team( (int) $this->game_away_id );
		$home_team = new Team( (int) $this->game_home_id );

		/**
		 * Displays the events for a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML for the game events.
		 * @param array  $events         The list of events to show.
		 * @param Team   $away_team      The away team object.
		 * @param Team   $home_team      The home team object.
		 * @param string $sport          The sport the website is using.
		 * @return string                The HTML for the game events section.
		 */
		$html = apply_filters( 'sports_bench_game_events', '', $events, $away_team, $home_team, get_option( 'sports-bench-sport' ) );
		return $html;
	}

	/**
	 * Displays the team stats for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the team stats section.
	 */
	public function game_box_score_team_stats() {
		$html  = '';
		$html .= '<div id="team-stats" class="box-score-section">';
		$html .= '<h2>' . __( 'Team Stats', 'sports-bench' ) . '</h2>';
		$html .= $this->get_team_stats_info();
		$html .= '</div>';

		return $html;
	}

	/**
	 * Returns the team stats for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the team stats section.
	 */
	public function get_team_stats_info() {
		$away_team = new Team( (int) $this->game_away_id );
		$home_team = new Team( (int) $this->game_home_id );
		global $wpdb;
		$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $this->game_id );
		$game_info = Database::get_results( $querystr );

		/**
		 * Displays the team stats for a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML for the team stats.
		 * @param array  $events         The list of stats to show.
		 * @param Team   $away_team      The away team object.
		 * @param Team   $home_team      The home team object.
		 * @param Game   $game           The game object.
		 * @param string $sport          The sport the website is using.
		 * @return string                The HTML for theteam stats section.
		 */
		$html = apply_filters( 'sports_bench_team_stats', '', $game_info, $away_team, $home_team, $this, get_option( 'sports-bench-sport' ) );
		return $html;
	}

	/**
	 * Displays the individual stats for a game for the away team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual stats.
	 */
	public function game_box_score_away_team_stats() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BasketballGame( $this->game_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new FootballGame( $this->game_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new HockeyGame( $this->game_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new RugbyGame( $this->game_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new SoccerGame( $this->game_id );
		} else {
			$sport = new VolleyballGame( $this->game_id );
		}
		return $sport->game_box_score_away_team_stats();
	}

	/**
	 * Displays the individual stats table for a game for the away team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual stats table.
	 */
	public function get_away_individual_stats() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BasketballGame( $this->game_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new FootballGame( $this->game_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new HockeyGame( $this->game_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new RugbyGame( $this->game_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new SoccerGame( $this->game_id );
		} else {
			$sport = new VolleyballGame( $this->game_id );
		}
		return $sport->get_away_individual_stats();
	}

	/**
	 * Displays the individual stats for a game for the home team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away home individual stats.
	 */
	public function game_box_score_home_team_stats() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BasketballGame( $this->game_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new FootballGame( $this->game_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new HockeyGame( $this->game_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new RugbyGame( $this->game_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new SoccerGame( $this->game_id );
		} else {
			$sport = new VolleyballGame( $this->game_id );
		}
		return $sport->game_box_score_home_team_stats();
	}

	/**
	 * Displays the individual stats table for a game for the home team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual home table.
	 */
	public function get_home_individual_stats() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BaseballGame( $this->game_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$sport = new BasketballGame( $this->game_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$sport = new FootballGame( $this->game_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$sport = new HockeyGame( $this->game_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$sport = new RugbyGame( $this->game_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$sport = new SoccerGame( $this->game_id );
		} else {
			$sport = new VolleyballGame( $this->game_id );
		}
		return $sport->get_home_individual_stats();
	}

	/**
	 * Gets a given team stats for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $home_away      Whether to get a "home" or "away" stat.
	 * @param string $stat           The stat to get.
	 * @return int                   The stat being searched.
	 */
	public function get_game_stat( $home_away, $stat ) {
		$column = 'game_' . $home_away . '_' . $stat;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT $column FROM $table WHERE game_id = %d;", $this->game_id );
		$the_stat = Database::get_results( $querystr );
		return $the_stat;
	}

	/**
	 * Gets the shootout score for a team.
	 *
	 * @since 2.0.0
	 *
	 * @param int $team_id      The team id to get the shootout score for.
	 * @return bool|int         The shootout score for the team. If there is no shootout, it returns false.
	 */
	public function get_shootout( $team_id ) {

		$shootout_score = false;

		if ( 'soccer' === get_option( 'sports-bench-sport' ) || 'hockey' === get_option( 'sports-bench-sport' ) ) {

			$game_id = $this->game_id;
			global $wpdb;
			$table     = $wpdb->prefix . 'sb_games';
			$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d", $game_id );
			$game_info = Database::get_results( $querystr );

			foreach ( $game_info as $game ) {

				if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
					if ( $team_id === $game->game_away_id && null !== $game->game_away_pks ) {
						$shootout_score = $game->game_away_pks;
					} elseif ( $team_id === $game->game_home_id && null !== $game->game_home_pks ) {
						$shootout_score = $game->game_home_pks;
					}
				} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
					if ( $team_id === $game->game_away_id && null !== $game->game_away_shootout ) {
						$shootout_score = $game->game_away_shootout;
					} elseif ( $team_id === $game->game_home_id && null !== $game->game_home_shootout ) {
						$shootout_score = $game->game_home_shootout;
					}
				}
			}
		}

		return $shootout_score;

	}

}
