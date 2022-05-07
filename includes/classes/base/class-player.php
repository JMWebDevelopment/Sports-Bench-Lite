<?php
/**
 * Creates the player class.
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

use DateTime;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;

use Sports_Bench\Classes\Sports\Baseball\BaseballPlayer;
use Sports_Bench\Classes\Sports\Basketball\BasketballPlayer;
use Sports_Bench\Classes\Sports\Football\FootballPlayer;
use Sports_Bench\Classes\Sports\Hockey\HockeyPlayer;
use Sports_Bench\Classes\Sports\Rugby\RugbyPlayer;
use Sports_Bench\Classes\Sports\Soccer\SoccerPlayer;
use Sports_Bench\Classes\Sports\Volleyball\VolleyballPlayer;

/**
 * The core player class.
 *
 * This is used for players in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Player {

	/**
	 * The id of the player.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_id;

	/**
	 * The player's first name.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_first_name;

	/**
	 * The player's last name.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_last_name;

	/**
	 * The url to the player's photo.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_photo;

	/**
	 * The position the player plays.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_position;

	/**
	 * The player's hometown.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_home_city;

	/**
	 * The player's home state.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_home_state;

	/**
	 * The player's date of birth.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_birth_day;

	/**
	 * The team id for the team the player currently plays for.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_id;

	/**
	 * The weight of the player.
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_weight;

	/**
	 * The height of the player.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_height;

	/**
	 * The slug for the player for url purposes.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_slug;

	/**
	 * The bio for the player.
	 *
	 * @var string
	 * @access protected
	 * @since 2.0.0
	 */
	protected $player_bio;


	/**
	 * Creates the new Player object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $player_selector      The player slug or id needed to create the player object.
	 */
	public function __construct( $player_selector ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';

		if ( is_string( $player_selector ) ) {
			$player = Database::get_results( $wpdb->prepare( "SELECT * FROM  $table WHERE player_slug = %s;", $player_selector ) );
		} else {
			$player = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE player_id = %d;", $player_selector ) );
		}

		if ( $player ) {
			$this->player_id         = $player[0]->player_id;
			$this->player_first_name = stripslashes( $player[0]->player_first_name );
			$this->player_last_name  = stripslashes( $player[0]->player_last_name );
			$this->player_photo      = $player[0]->player_photo;
			$this->player_position   = $player[0]->player_position;
			$this->player_home_city  = stripslashes( $player[0]->player_home_city );
			$this->player_home_state = stripslashes( $player[0]->player_home_state );
			$this->player_birth_day  = $player[0]->player_birth_day;
			$this->team_id           = $player[0]->team_id;
			$this->player_weight     = $player[0]->player_weight;
			$this->player_height     = stripslashes( $player[0]->player_height );
			$this->player_slug       = $player[0]->player_slug;
			$this->player_bio        = $player[0]->player_bio;

		}

	}

	/**
	 * Returns the player id.
	 *
	 * @since 2.0
	 *
	 * @return int      The player id.
	 */
	public function get_player_id() {
		return $this->player_id;
	}

	/**
	 * Returns the player first name.
	 *
	 * @since 2.0
	 *
	 * @return string      The player first name.
	 */
	public function get_player_first_name() {
		return $this->player_first_name;
	}

	/**
	 * Returns the player last name.
	 *
	 * @since 2.0
	 *
	 * @return string      The player last name.
	 */
	public function get_player_last_name() {
		return $this->player_last_name;
	}

	/**
	 * Returns the player photo url.
	 *
	 * @since 2.0
	 *
	 * @return string      The player photo url.
	 */
	public function get_player_photo_url() {
		return $this->player_photo;
	}

	/**
	 * Returns the player position.
	 *
	 * @since 2.0
	 *
	 * @return string      The player position.
	 */
	public function get_player_position() {
		return $this->player_position;
	}

	/**
	 * Returns the player's home city.
	 *
	 * @since 2.0
	 *
	 * @return string      The player's home city.
	 */
	public function get_player_home_city() {
		return $this->player_home_city;
	}

	/**
	 * Returns the player's home state.
	 *
	 * @since 2.0
	 *
	 * @return string      The player's home state.
	 */
	public function get_player_home_state() {
		return $this->player_home_state;
	}

	/**
	 * Returns the player date of birth.
	 *
	 * @since 2.0
	 *
	 * @return string      The player date of birth.
	 */
	public function get_player_birth_day() {
		return $this->player_birth_day;
	}

	/**
	 * Returns the player's team id.
	 *
	 * @since 2.0
	 *
	 * @return int      The player's team id.
	 */
	public function get_team_id() {
		return $this->team_id;
	}

	/**
	 * Returns the player weight.
	 *
	 * @since 2.0
	 *
	 * @return string      The player weight.
	 */
	public function get_player_weight() {
		return $this->player_weight;
	}

	/**
	 * Returns the player height.
	 *
	 * @since 2.0
	 *
	 * @return string      The player height.
	 */
	public function get_player_height() {
		return $this->player_height;
	}

	/**
	 * Returns the player slug.
	 *
	 * @since 2.0
	 *
	 * @return string      The player slug.
	 */
	public function get_player_slug() {
		return $this->player_slug;
	}

	/**
	 * Returns the player bio.
	 *
	 * @since 2.0
	 *
	 * @return string      The player bio.
	 */
	public function get_player_bio() {
		return $this->player_bio;
	}

	/**
	 * Updates the player with new information provided.
	 *
	 * @since 2.0.0
	 *
	 * @param array $values     The values to change for the player in key => value pairs.
	 */
	public function update( $values ) {
		$current_values = [
			'player_id'         => $this->player_id,
			'player_first_name' => $this->player_first_name,
			'player_last_name'  => $this->player_last_name,
			'player_photo'      => $this->player_photo,
			'player_position'   => $this->player_position,
			'player_home_city'  => $this->player_home_city,
			'player_home_state' => $this->player_home_state,
			'player_birth_day'  => $this->player_birth_day,
			'team_id'           => $this->team_id,
			'player_weight'     => $this->player_weight,
			'player_height'     => $this->player_height,
			'player_slug'       => $this->player_slug,
			'player_bio'        => $this->player_bio,
		];
		$data           = wp_parse_args( $values, $current_values );
		Database::update_row( 'players', array( 'player_id' => $this->player_id ), $data );

		$this->player_id         = intval( $data['player_id'] );
		$this->player_first_name = stripslashes( $data['player_first_name'] );
		$this->player_last_name  = stripslashes( $data['player_last_name'] );
		$this->player_photo      = $data['player_photo'];
		$this->player_position   = $data['player_position'];
		$this->player_home_city  = stripslashes( $data['player_home_city'] );
		$this->player_home_state = stripslashes( $data['player_home_state'] );
		$this->player_birth_day  = $data['player_birth_day'];
		$this->team_id           = intval( $data['team_id'] );
		$this->player_weight     = $data['player_weight'];
		$this->player_height     = stripslashes( $data['player_height'] );
		$this->player_slug       = $data['player_slug'];
		$this->player_bio        = stripslashes( $data['player_bio'] );
	}

	/**
	 * Gets the team oject for the player's current team.
	 *
	 * @since 2.0.0
	 *
	 * @return Team      The team object for the player's current team.
	 */
	public function get_team() {
		if ( 0 < $this->team_id ) {
			return new Team( (int) $this->team_id );
		} else {
			return;
		}
	}

	/**
	 * Returns the link to the player's page.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The link to the player's page.
	 */
	public function get_permalink() {
		if ( get_option( 'sports-bench-player-page' ) ) {
			return esc_url( get_home_url() . '/?page_id=' . get_option( 'sports-bench-player-page' ) . '&player_slug=' . $this->player_slug );
		} else {
			return '';
		}
	}

	/**
	 * Returns the age of the player in years.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The age of the player.
	 */
	public function get_age() {
		if ( '0000-00-00' !== $this->player_birth_day ) {
			$birthdate = new DateTime( $this->player_birth_day );
			$today     = new DateTime( 'today' );
			$age       = $birthdate->diff( $today )->y;

			return $age;
		}

		return '';
	}

	/**
	 * Returns the photo for the player.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The img element for the player's photo.
	 */
	public function get_player_photo() {
		if ( $this->player_photo ) {
			return '<img src="' . esc_url( $this->player_photo ) . ' alt="' . $this->player_slug . ' photo" />';
		} else {
			return '<img src="' . plugins_url( '../../../public/images/mystery-person.jpg', __FILE__ ) . '" alt="mystery-person" />';
		}
	}

	/**
	 * Returns the number of seasons played in the league.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The number of seasons played.
	 */
	public function get_seasons_played() {
		global $wpdb;
		$seasons_played   = [];
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare( "SELECT DISTINCT Game.game_season FROM $game_table AS Game LEFT JOIN $game_stats_table AS GameStats ON GameStats.game_player_id = %d;", $this->player_id );
		$seasons          = Database::get_results( $querystr );
		foreach ( $seasons as $season ) {
			array_push( $seasons_played, $season->game_season );
		}
		return count( $seasons_played );
	}

	/**
	 * Gets the year range the player played in the league.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The range of years the player played.
	 */
	public function get_years() {
		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr         = $wpdb->prepare( "SELECT DISTINCT Game.game_season FROM $game_table AS Game LEFT JOIN $game_stats_table AS GameStats ON GameStats.game_player_id = %d ORDER BY Game.game_day ASC LIMIT 1;", $this->player_id );
		$first_game       = $wpdb->get_row( $querystr );
		$first_game       = $first_game->game_season;

		$querystr  = $wpdb->prepare( "SELECT DISTINCT Game.game_season FROM $game_table AS Game LEFT JOIN $game_stats_table AS GameStats ON GameStats.game_player_id = $this->player_id ORDER BY Game.game_day ASC LIMIT 1;", $this->player_id );
		$last_game = $wpdb->get_row( $querystr );
		$last_game = $last_game->game_season;

		if ( $first_game && $last_game ) {
			if ( $first_game === $last_game ) {
				return $first_game;
			} elseif ( get_option( 'sports-bench-season-year' ) === $last_game ) {
				return $first_game . ' &mdash; ' . esc_html__( 'Present', 'sports-bench' );
			} else {
				return $first_game . ' &mdash; ' . $last_game;
			}
		} else {
			return '';
		}
	}

	/**
	 * Gets the stats for a season for the player.
	 *
	 * @since 2.0.0
	 *
	 * @return array      A list of season stats for a player.
	 */
	public function get_seasons_stats() {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$player = new BaseballPlayer( (int) $this->player_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$player = new BasketballPlayer( (int) $this->player_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$player = new FootballPlayer( (int) $this->player_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$player = new HockeyPlayer( (int) $this->player_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$player = new RugbyPlayer( (int) $this->player_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$player = new SoccerPlayer( (int) $this->player_id );
		} else {
			$player = new VolleyballPlayer( (int) $this->player_id );
		}
		return $player->get_seasons_stats();
	}


}
