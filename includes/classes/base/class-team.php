<?php
/**
 * Creates the team class.
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

use Sports_Bench\Classes\Base\Database;

use Sports_Bench\Classes\Sports\Baseball\BaseballTeam;
use Sports_Bench\Classes\Sports\Basketball\BasketballTeam;
use Sports_Bench\Classes\Sports\Football\FootballTeam;
use Sports_Bench\Classes\Sports\Hockey\HockeyTeam;
use Sports_Bench\Classes\Sports\Rugby\RugbyTeam;
use Sports_Bench\Classes\Sports\Soccer\SoccerTeam;
use Sports_Bench\Classes\Sports\Volleyball\VolleyballTeam;

/**
 * The core team class.
 *
 * This is used for teams in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Team {

	/**
	 * The id of the team
	 *
	 * @var int
	 * @access protected
	 * @since 2.0.0
	 */
	protected $team_id;

	/**
	 * The team's name
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_name;

	/**
	 * The location of the team
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_location;

	/**
	 * The team's nickname
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_nickname;

	/**
	 * The team's abbreviation
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_abbreviation;

	/**
	 * The team's active status
	 *
	 * @var string
	 * @access protected
	 * @since 1.2
	 */
	protected $team_active;

	/**
	 * The first line of the address for the team
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_location_line_one;

	/**
	 * The first line of the address for the team
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_location_line_two;

	/**
	 * The city the team plays in
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_city;

	/**
	 * The state the team plays in
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_state;

	/**
	 * The country the team plays in
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_location_country;

	/**
	 * The zip code the team plays in
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_location_zip_code;

	/**
	 * The stadium the team plays in
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_stadium;

	/**
	 * The capacity of the team's stadium
	 *
	 * @var int
	 * @access protected
	 * @since 1.0
	 */
	protected $team_stadium_capacity;

	/**
	 * The current head coach of the team
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_head_coach;


	/**
	 * The url for the team's logo
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_logo;


	/**
	 * The url for the team's photo
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_photo;


	/**
	 * The id of the division or conference the team plays in
	 *
	 * @var int
	 * @access protected
	 * @since 1.0
	 */
	protected $team_division;

	/**
	 * The hexadecimal color value for the team's primary color
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_primary_color;

	/**
	 * The hexadecimal color value for the team's secondary color
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_secondary_color;

	/**
	 * The slug for the team for url purposes
	 *
	 * @var string
	 * @access protected
	 * @since 1.0
	 */
	protected $team_slug;


	/**
	 * Creates the new Team object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param string|int $team_selector     The team slug or id needed to create the team object.
	 */
	public function __construct( $team_selector ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'teams';

		if ( is_string( $team_selector ) ) {
			$team = Database::get_results( $wpdb->prepare( "SELECT * FROM `$table` WHERE team_slug = %s;", $team_selector ) );
		} else {
			$team = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE team_id = %d;", $team_selector ) );
		}

		if ( $team ) {
			$this->team_id                = $team[0]->team_id;
			$this->team_name              = stripslashes( $team[0]->team_name );
			$this->team_location          = stripslashes( $team[0]->team_location );
			$this->team_nickname          = stripslashes( $team[0]->team_nickname );
			$this->team_abbreviation      = $team[0]->team_abbreviation;
			$this->team_active            = $team[0]->team_active;
			$this->team_location_line_one = stripslashes( $team[0]->team_location_line_one );
			$this->team_location_line_two = stripslashes( $team[0]->team_location_line_two );
			$this->team_city              = stripslashes( $team[0]->team_city );
			$this->team_state             = stripslashes( $team[0]->team_state );
			$this->team_location_country  = stripslashes( $team[0]->team_location_country );
			$this->team_location_zip_code = stripslashes( $team[0]->team_location_zip_code );
			$this->team_stadium           = stripslashes( $team[0]->team_stadium );
			$this->team_stadium_capacity  = $team[0]->team_stadium_capacity;
			$this->team_head_coach        = stripslashes( $team[0]->team_head_coach );
			$this->team_logo              = $team[0]->team_logo;
			$this->team_photo             = $team[0]->team_photo;
			$this->team_division          = $team[0]->team_division;
			$this->team_primary_color     = $team[0]->team_primary_color;
			$this->team_secondary_color   = $team[0]->team_secondary_color;
			$this->team_slug              = $team[0]->team_slug;

		}

	}

	/**
	 * Returns the team id.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The team id.
	 */
	public function get_team_id() {
		return $this->team_id;
	}

	/**
	 * Returns the team name.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team name.
	 */
	public function get_team_name() {
		return $this->team_name;
	}

	/**
	 * Returns the team location.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team location.
	 */
	public function get_team_location() {
		return $this->team_location;
	}

	/**
	 * Returns the team nickname.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team nickname.
	 */
	public function get_team_nickname() {
		return $this->team_nickname;
	}

	/**
	 * Returns the team abbreviation.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team abbreviation.
	 */
	public function get_team_abbreviation() {
		return $this->team_abbreviation;
	}

	/**
	 * Returns the team status.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team status.
	 */
	public function get_team_status() {
		return $this->team_active;
	}

	/**
	 * Returns the team stadium address line one.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium address line one.
	 */
	public function get_team_location_line_one() {
		return $this->team_location_line_one;
	}

	/**
	 * Returns the team stadium address line two.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium address line two.
	 */
	public function get_team_location_line_two() {
		return $this->team_location_line_two;
	}

	/**
	 * Returns the team stadium city.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium city.
	 */
	public function get_team_city() {
		return $this->team_city;
	}

	/**
	 * Returns the team stadium state.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium state.
	 */
	public function get_team_state() {
		return $this->team_state;
	}

	/**
	 * Returns the team stadium country.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium country.
	 */
	public function get_team_location_country() {
		return $this->team_location_country;
	}

	/**
	 * Returns the team stadium ZIP code.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium ZIP code.
	 */
	public function get_team_location_zip_code() {
		return $this->team_location_zip_code;
	}

	/**
	 * Returns the team stadium name.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team stadium name.
	 */
	public function get_team_stadium() {
		return $this->team_stadium;
	}

	/**
	 * Returns the team stadium capacity.
	 *
	 * @since 2.0.0
	 *
	 * @return int      The team stadium capacity.
	 */
	public function get_team_stadium_capacity() {
		return $this->team_stadium_capacity;
	}

	/**
	 * Returns the team head coach.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team head coach.
	 */
	public function get_team_head_coach() {
		return $this->team_head_coach;
	}

	/**
	 * Returns the team logo url.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team logo url.
	 */
	public function get_team_logo_url() {
		return $this->team_logo;
	}

	/**
	 * Returns the team photo.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team photo url.
	 */
	public function get_team_photo_url() {
		return $this->team_photo;
	}

	/**
	 * Returns the team's division or conference.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team's division.
	 */
	public function get_team_division() {
		return $this->team_division;
	}

	/**
	 * Returns the team's primary color.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team's primary color.
	 */
	public function get_team_primary_color() {
		return $this->team_primary_color;
	}

	/**
	 * Returns the team's secondary color.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team's secondary color.
	 */
	public function get_team_secondary_color() {
		return $this->team_secondary_color;
	}

	/**
	 * Returns the team slug.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The team slug.
	 */
	public function get_team_slug() {
		return $this->team_slug;
	}

	/**
	 * Updates the team with new information provided.
	 *
	 * @since 2.0.0
	 *
	 * @param array $values     The values to change for the team in key => value pairs.
	 */
	public function update( $values ) {
		$current_values = [
			'team_id'                => $this->team_id,
			'team_name'              => $this->team_name,
			'team_location'          => $this->team_location,
			'team_nickname'          => $this->team_nickname,
			'team_abbreviation'      => $this->team_abbreviation,
			'team_active'            => $this->team_active,
			'team_location_line_one' => $this->team_location_line_one,
			'team_location_line_two' => $this->team_location_line_two,
			'team_city'              => $this->team_city,
			'team_state'             => $this->team_state,
			'team_location_country'  => $this->team_location_country,
			'team_location_zip_code' => $this->team_location_zip_code,
			'team_stadium'           => $this->team_stadium,
			'team_stadium_capacity'  => $this->team_stadium_capacity,
			'team_head_coach'        => $this->team_head_coach,
			'team_logo'              => $this->team_logo,
			'team_photo'             => $this->team_photo,
			'team_division'          => $this->team_division,
			'team_primary_color'     => $this->team_primary_color,
			'team_secondary_color'   => $this->team_secondary_color,
			'team_slug'              => $this->team_slug,
		];
		$data           = wp_parse_args( $values, $current_values );
		Database::update_row( 'teams', array( 'team_id' => $this->team_id ), $data );

		$this->team_id                = $data['team_id'];
		$this->team_name              = stripslashes( $data['team_name'] );
		$this->team_location          = stripslashes( $data['team_location'] );
		$this->team_nickname          = stripslashes( $data['team_nickname'] );
		$this->team_abbreviation      = $data['team_abbreviation'];
		$this->team_active            = $data['team_active'];
		$this->team_location_line_one = stripslashes( $data['team_location_line_one'] );
		$this->team_location_line_two = stripslashes( $data['team_location_line_two'] );
		$this->team_city              = stripslashes( $data['team_city'] );
		$this->team_state             = stripslashes( $data['team_state'] );
		$this->team_location_country  = stripslashes( $data['team_location_country'] );
		$this->team_location_zip_code = stripslashes( $data['team_location_zip_code'] );
		$this->team_stadium           = stripslashes( $data['team_stadium'] );
		$this->team_stadium_capacity  = $data['team_stadium_capacity'];
		$this->team_head_coach        = stripslashes( $data['team_head_coach'] );
		$this->team_logo              = $data['team_logo'];
		$this->team_photo             = $data['team_photo'];
		$this->team_division          = $data['team_division'];
		$this->team_primary_color     = $data['team_primary_color'];
		$this->team_secondary_color   = $data['team_secondary_color'];
		$this->team_slug              = $data['team_slug'];
	}

	/**
	 * Gets the number of games a team has played in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the games played for.
	 * @return int                The number of games played.
	 */
	public function get_games_played( $season ) {
		global $wpdb;
		$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr     = $wpdb->prepare( "SELECT COUNT( * ) AS GP FROM $table WHERE ( ( game_away_id = %d OR  game_home_id = %d ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $this->team_id, $season );
		$games_played = $wpdb->get_results( $querystr );
		return $games_played[0]->GP;
	}

	/**
	 * Gets the name of the division the team is in.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The name of the division.
	 */
	public function get_division_name() {
		if ( $this->team_division ) {
			global $wpdb;
			$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$division = Database::get_results( $wpdb->prepare( "SELECT * FROM $table WHERE ( division_id = %s );", $this->team_division ) );
			return $division[0]->division_name;
		} else {
			return '';
		}
	}

	/**
	 * Gets the team logo or team photo img element.
	 *
	 * @since 2.0.0
	 *
	 * @param string $image      Whether getting the "team-photo" or "team-logo".
	 * @return string            The img HTML element for the photo or logo.
	 */
	public function get_team_photo( $image ) {
		if ( 'team-photo' === $image ) {
			return '<img src="' . esc_url( $this->team_photo ) . '"  alt="' . $this->team_slug . '-photo" />';
		} elseif ( 'team-logo' === $image ) {
			return '<img src="' . esc_url( $this->team_logo ) . '" alt="' . $this->team_slug . '-logo" />';
		} else {
			return;
		}
	}

	/**
	 * Gets the link to the team's page.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The link to the team's page.
	 */
	public function get_permalink() {
		if ( get_option( 'sports-bench-team-page' ) ) {
			return esc_url( get_home_url() . '/index.php?page_id=' . get_option( 'sports-bench-team-page' ) . '&team_slug=' . $this->team_slug );
		} else {
			return '';
		}
	}

	/**
	 * Gets the schedule for a team for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the schedule for.
	 * @return array              The list of games in the schedule.
	 */
	public function get_schedule( $season ) {
		global $wpdb;
		$table         = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr      = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s ORDER BY game_day ASC;", $this->team_id, $this->team_id, $season );
		$games         = Database::get_results( $querystr );
		$team_schedule = [];
		foreach ( $games as $game ) {
			$the_game = new Game( $game->game_id );
			if ( $this->team_id === $the_game->get_game_home_id() ) {
				$opponent = $the_game->get_game_away_id();
				$location = 'home';
				if ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					$result         = 'W';
					$team_score     = $the_game->get_game_home_final();
					$opponent_score = $the_game->get_game_away_final();
				} elseif ( $the_game->get_game_home_final() < $the_game->get_game_away_final() ) {
					$result         = 'L';
					$team_score     = $the_game->get_game_home_final();
					$opponent_score = $the_game->get_game_away_final();
				} else {
					if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
						if ( $game->game_home_pks > $game->game_away_pks ) {
							$result         = 'W';
							$opponent_score = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$team_score     = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} elseif ( $game->game_home_pks < $game->game_away_pks ) {
							$result         = 'L';
							$opponent_score = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$team_score     = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} else {
							$result         = 'D';
							$team_score     = $the_game->get_game_home_final();
							$opponent_score = $the_game->get_game_away_final();
						}
					} else {
						$result         = 'D';
						$team_score     = $the_game->get_game_home_final();
						$opponent_score = $the_game->get_game_away_final();
					}
				}
			} else {
				$opponent = $the_game->get_game_home_id();
				$location = 'away';
				if ( $the_game->get_game_home_final() < $the_game->get_game_away_final() ) {
					$result         = 'W';
					$team_score     = $the_game->get_game_away_final();
					$opponent_score = $the_game->get_game_home_final();
				} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					$result         = 'L';
					$team_score     = $the_game->get_game_away_final();
					$opponent_score = $the_game->get_game_home_final();
				} else {
					if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
						if ( $game->game_home_pks < $game->game_away_pks ) {
							$result         = 'W';
							$team_score     = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$opponent_score = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} elseif ( $game->game_home_pks > $game->game_away_pks ) {
							$result         = 'L';
							$team_score     = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$opponent_score = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} else {
							$result         = 'D';
							$team_score     = $the_game->get_game_away_final();
							$opponent_score = $the_game->get_game_home_final();
						}
					} else {
						$result         = 'D';
						$team_score     = $the_game->get_game_away_final();
						$opponent_score = $the_game->get_game_home_final();
					}
				}
			}
			if ( null !== $the_game->get_game_week() ) {
				$week = $game->game_week;
			} else {
				$week = '';
			}

			$game_info = array(
				'date'              => $the_game->get_game_day(),
				'week'              => $week,
				'opponent'          => $opponent,
				'location'          => $location,
				'neutral_site'      => $the_game->get_game_neutral_site(),
				'result'            => $result,
				'team_score'        => $team_score,
				'opponent_score'    => $opponent_score,
				'box_score'         => $the_game->get_box_score_permalink(),
			);
			array_push( $team_schedule, $game_info );
		}
		return $team_schedule;
	}

	/**
	 * Gets the number of wins for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the wins from.
	 * @return int                The number of wins in the season.
	 */
	public function get_wins( $season ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final > game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final > game_away_final ) ) ) AND ( game_season = %s )  AND ( game_status = 'final' ) );", $this->team_id, $this->team_id, $season );
		$wins     = Database::get_results( $querystr );
		return $wins[0]->WINS;
	}

	/**
	 * Gets the number of losses for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the losses from.
	 * @return int                The number of losses in the season.
	 */
	public function get_losses( $season ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final < game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final < game_away_final ) ) ) AND ( game_season = %s )  AND ( game_status = 'final' ) );", $this->team_id, $this->team_id, $season );
		$losses   = Database::get_results( $querystr );
		return $losses[0]->LOSSES;
	}

	/**
	 * Gets the number of draws for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the draws from.
	 * @return int                The number of draws in the season.
	 */
	public function get_draws( $season ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT COUNT( * ) AS DRAWS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final = game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final = game_away_final ) ) ) AND ( game_season = %s )  AND ( game_status = 'final' ) );", $this->team_id, $this->team_id, $season );
		$draws    = Database::get_results( $querystr );
		return $draws[0]->DRAWS;
	}

	/**
	 * Gets the number of overtime losses for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the overtime losses from.
	 * @return int                The number of overtime losses in the season.
	 */
	public function get_overtime_losses( $season ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT COUNT( * ) AS OTLOSSES FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final < game_home_final ) AND game_away_overtime IS NOT NULL ) OR ( ( game_home_id = %d ) AND ( game_home_final < game_away_final ) AND game_home_overtime IS NOT NULL ) ) AND ( game_season = %s )  AND ( game_status = 'final' ) );", $this->team_id, $this->team_id, $season );
		$draws    = Database::get_results( $querystr );
		return $draws[0]->OTLOSSES;
	}

	/**
	 * Gets the record for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the record from.
	 * @return array              The list of wins, losses and draws in the season.
	 */
	public function get_record( $season ) {
		$wins   = $this->get_wins( $season );
		$losses = $this->get_losses( $season );
		$draws  = $this->get_draws( $season );
		$record = [ $wins, $losses, $draws ];
		return $record;
	}

	/**
	 * Gets the win percentage for a team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the win percentage from.
	 * @return float              The win percentage for the team.
	 */
	public function get_win_percentage( $season ) {
		$wins        = $this->get_wins( $season );
		$losses      = $this->get_losses( $season );
		$draws       = $this->get_draws( $season );
		$total_games = $wins + $losses + $draws;
		if ( 0 === $total_games ) {
			$win_percent = 0.000;
		} else {
			$win_percent = $wins / $total_games;
		}
		return number_format( (float) $win_percent, 3, '.', '' );
	}

	/**
	 * Gets the roster for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param string|null $season      The season to get the roster for.
	 * @return array                   The list of players on the team's roster.
	 */
	public function get_roster( $season = '' ) {
		global $wpdb;
		$roster = [];
		$table  = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		if ( get_option( 'sports-bench-season-year' ) === $season || '' === $season ) {
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE team_id = %d;", $this->team_id );
		} else {
			$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
			$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
			$querystr   = $wpdb->prepare( "SELECT DISTINCT s.game_player_id as player_id FROM $table AS s LEFT JOIN $game_table AS g ON s.game_id = g.game_id WHERE s.game_team_id = %d AND g.game_season = %s;", $this->team_id, $season );
		}
		$players  = Database::get_results( $querystr );
		foreach ( $players as $player ) {
			$player_info = [];
			$the_player  = new Player( (int) $player->player_id );
			$player_info = [
				'first_name'    => $the_player->get_player_first_name(),
				'last_name'     => $the_player->get_player_last_name(),
				'player_page'   => $the_player->get_permalink(),
				'position'      => $the_player->get_player_position(),
				'age'           => $the_player->get_age(),
				'home_city'     => $the_player->get_player_home_city(),
				'home_state'    => $the_player->get_player_home_state(),
				'height'        => $the_player->get_player_height(),
				'weight'        => $the_player->get_player_weight(),
				'photo'         => $the_player->get_player_photo(),
			];
			array_push( $roster, $player_info );
		}
		return $roster;
	}

	/**
	 * Gets a list of recent results for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $limit       The number of games to get.
	 * @param string $season      The season to get the games from.
	 * @return array              A list of recent games.
	 */
	public function get_recent_results( $limit = 5, $season ) {
		global $wpdb;
		$table           = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr        = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final' ORDER BY game_day DESC LIMIT %d;", $this->team_id, $this->team_id, $season, $limit );
		$games           = Database::get_results( $querystr );
		$recent_schedule = [];
		foreach ( $games as $game ) {
			$the_game = new Game( $game->game_id );
			if ( $this->team_id === $the_game->get_game_home_id() ) {
				$opponent = $the_game->get_game_away_id();
				$location = 'home';
				if ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					$result         = 'W';
					$team_score     = $the_game->get_game_home_final();
					$opponent_score = $the_game->get_game_away_final();
				} elseif ( $the_game->get_game_home_final() < $the_game->get_game_away_final() ) {
					$result         = 'L';
					$team_score     = $the_game->get_game_home_final();
					$opponent_score = $the_game->get_game_away_final();
				} else {
					if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
						if ( $game->game_home_pks > $game->game_away_pks ) {
							$result         = 'W';
							$opponent_score = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$team_score     = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} elseif ( $game->game_home_pks < $game->game_away_pks ) {
							$result         = 'L';
							$opponent_score = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$team_score     = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} else {
							$result         = 'D';
							$team_score     = $the_game->get_game_home_final();
							$opponent_score = $the_game->get_game_away_final();
						}
					} else {
						$result         = 'D';
						$team_score     = $the_game->get_game_home_final();
						$opponent_score = $the_game->get_game_away_final();
					}
				}
			} else {
				$opponent = $the_game->get_game_home_id();
				$location = 'away';
				if ( $the_game->get_game_home_final() < $the_game->get_game_away_final() ) {
					$result         = 'W';
					$team_score     = $the_game->get_game_away_final();
					$opponent_score = $the_game->get_game_home_final();
				} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					$result         = 'L';
					$team_score     = $the_game->get_game_away_final();
					$opponent_score = $the_game->get_game_home_final();
				} else {
					if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
						if ( $game->game_home_pks < $game->game_away_pks ) {
							$result         = 'W';
							$team_score     = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$opponent_score = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} elseif ( $game->game_home_pks > $game->game_away_pks ) {
							$result         = 'L';
							$team_score     = $the_game->get_game_away_final() . '(' . $game->game_away_pks . ')';
							$opponent_score = $the_game->get_game_home_final() . '(' . $game->game_home_pks . ')';
						} else {
							$result         = 'D';
							$team_score     = $the_game->get_game_away_final();
							$opponent_score = $the_game->get_game_home_final();
						}
					} else {
						$result         = 'D';
						$team_score     = $the_game->get_game_away_final();
						$opponent_score = $the_game->get_game_home_final();
					}
				}
			}
			if ( null !== $the_game->get_game_week() ) {
				$week = $game->game_week;
			} else {
				$week = '';
			}

			$game_info = [
				'date'              => $the_game->get_game_day(),
				'week'              => $week,
				'opponent'          => $opponent,
				'location'          => $location,
				'neutral_site'      => $the_game->get_game_neutral_site(),
				'result'            => $result,
				'team_score'        => $team_score,
				'opponent_score'    => $opponent_score,
				'box_score'         => $the_game->get_box_score_permalink(),
			];
			array_push( $recent_schedule, $game_info );
		}
		return $recent_schedule;
	}

	/**
	 * Gets a list of upcoming games for the team.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $limit       The number of games to get.
	 * @param string $season      The season to get the games from.
	 * @return array              A list of upcoming games.
	 */
	public function get_upcoming_schedule( $limit = 5, $season ) {
		global $wpdb;
		$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'scheduled' ORDER BY game_day ASC LIMIT %d;", $this->team_id, $this->team_id, $season, $limit );
		$games             = Database::get_results( $querystr );
		$upcoming_schedule = [];
		foreach ( $games as $game ) {
			$the_game = new Game( $game->game_id );
			if ( $game->game_home_id === $this->team_id ) {
				$opponent = $game->game_away_id;
				$location = 'home';
			} else {
				$opponent = $game->game_home_id;
				$location = 'away';
			}
			if ( null !== $game->game_week ) {
				$week = $game->game_week;
			} else {
				$week = '';
			}

			$game_info = [
				'date'      => $game->game_day,
				'week'      => $week,
				'opponent'  => $opponent,
				'location'  => $location,
				'box_score' => $the_game->get_box_score_permalink(),
			];
			array_push( $upcoming_schedule, $game_info );
		}

		return $upcoming_schedule;
	}

	/**
	 * Get the total number of points/runs/goals scored for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the points/runs/goals scored.
	 * @return int                The total number of points/runs/goals scored.
	 */
	public function get_points_for( $season ) {
		global $wpdb;
		$table           = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr        = $wpdb->prepare( "SELECT SUM( game_away_final ) as GFOR FROM $table WHERE game_away_id = %d AND game_season = %s AND game_status = 'final';", $this->team_id, $season );
		$points_for_away = Database::get_results( $querystr );
		$points_for_away = $points_for_away[0]->GFOR;
		$querystr        = $wpdb->prepare( "SELECT SUM( game_home_final ) as GFOR FROM $table WHERE game_home_id = %d AND game_season = %s AND game_status = 'final';", $this->team_id, $season );
		$points_for_home = Database::get_results( $querystr );
		$points_for_home = $points_for_home[0]->GFOR;
		$points_for      = $points_for_away + $points_for_home;
		return $points_for;
	}

	/**
	 * Get the total number of points/runs/goals given up for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the points/runs/goals given up.
	 * @return int                The total number of points/runs/goals given up.
	 */
	public function get_points_against( $season ) {
		global $wpdb;
		$table               = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr            = $wpdb->prepare( "SELECT SUM( game_home_final ) as AGAINST FROM $table WHERE game_away_id = %d AND game_season = %s AND game_status = 'final';", $this->team_id, $season );
		$points_against_away = Database::get_results( $querystr );
		$points_against_away = $points_against_away[0]->AGAINST;
		$querystr            = $wpdb->prepare( "SELECT SUM( game_away_final ) as AGAINST FROM $table WHERE game_home_id = %d AND game_season = %s AND game_status = 'final';", $this->team_id, $season );
		$points_against_home = Database::get_results( $querystr );
		$points_against_home = $points_against_home[0]->AGAINST;
		$points_against      = $points_against_away + $points_against_home;
		return $points_against;
	}

	/**
	 * Get the points/runs/goals differential for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the points/runs/goals differential.
	 * @return int                The total points/runs/goals differential.
	 */
	public function get_point_differential( $season ) {
		$points_for         = $this->get_points_for( $season );
		$points_against     = $this->get_points_against( $season );
		$point_differential = $points_for - $points_against;
		return $point_differential;
	}

	/**
	 * Gets the number of division wins for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the wins from.
	 * @return int                The number of division wins.
	 */
	public function get_division_wins( $season ) {
		$wins = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id === $this->team_id ) {
				if ( $game->game_away_final > $game->game_home_final ) {
					$opponent = new Team( $game->game_home_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$wins++;
					}
				}
			} else {
				if ( $game->game_home_final > $game->game_away_final ) {
					$opponent = new Team( $game->game_away_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$wins++;
					}
				}
			}
		}
		return $wins;
	}

	/**
	 * Gets the number of division losses for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the lossses from.
	 * @return int                The number of division losses.
	 */
	public function get_division_losses( $season ) {
		$losses = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id === $this->team_id ) {
				if ( $game->game_away_final < $game->game_home_final ) {
					$opponent = new Team( $game->game_home_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$losses++;
					}
				}
			} else {
				if ( $game->game_home_final < $game->game_away_final ) {
					$opponent = new Team( $game->game_away_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$losses++;
					}
				}
			}
		}
		return $losses;
	}

	/**
	 * Gets the number of division draws for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the draws from.
	 * @return int                The number of division draws.
	 */
	public function get_division_draws( $season ) {
		$draws = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id === $this->team_id ) {
				if ( $game->game_away_final === $game->game_home_final ) {
					$opponent = new Team( $game->game_home_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$draws++;
					}
				}
			} else {
				if ( $game->game_home_final === $game->game_away_final ) {
					$opponent = new Team( $game->game_away_id );
					if ( $opponent->get_team_division() === $this->team_division ) {
						$draws++;
					}
				}
			}
		}
		return $draws;
	}

	/**
	 * Gets the division record for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the record from.
	 * @return array              The list of division wins, losses and draws.
	 */
	public function get_division_record( $season ) {
		$wins   = $this->get_division_wins( $season );
		$losses = $this->get_division_losses( $season );
		$draws  = $this->get_division_draws( $season );
		$record = [ $wins, $draws, $losses ];
		return $record;
	}

	/**
	 * Gets the number of conference wins for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the wins from.
	 * @return int                The number of conference wins.
	 */
	public function get_conference_wins( $season ) {
		$wins = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id === $this->team_id ) {
				if ( $game->game_away_final > $game->game_home_final ) {
					$opponent          = new Team( (int) $game->game_home_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$wins++;
					}
				}
			} else {
				if ( $game->game_home_final > $game->game_away_final ) {
					$opponent          = new Team( (int) $game->game_away_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$wins++;
					}
				}
			}
		}
		return $wins;
	}

	/**
	 * Gets the number of conference losses for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the losses from.
	 * @return int                The number of conference losses.
	 */
	public function get_conference_losses( $season ) {
		$losses = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id == $this->team_id ) {
				if ( $game->game_away_final < $game->game_home_final ) {
					$opponent          = new Team( (int) $game->game_home_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$losses++;
					}
				}
			} else {
				if ( $game->game_home_final < $game->game_away_final ) {
					$opponent          = new Team( (int) $game->game_away_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$losses++;
					}
				}
			}
		}
		return $losses;
	}

	/**
	 * Gets the number of conference draws for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the draws from.
	 * @return int                The number of conference draws.
	 */
	public function get_conference_draws( $season ) {
		$draws = 0;
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d OR game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $this->team_id, $season );
		$games    = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			if ( $game->game_away_id === $this->team_id ) {
				if ( $game->game_away_final === $game->game_home_final ) {
					$opponent          = new Team( (int) $game->game_home_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$draws++;
					}
				}
			} else {
				if ( $game->game_home_final === $game->game_away_final ) {
					$opponent          = new Team( (int) $game->game_away_id );
					$table             = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
					$opponent_division = $opponent->team_division;
					$querystr          = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $this->team_division );
					$division          = Database::get_results( $querystr );
					if ( null === $division[0]->division_conference_id ) {
						$division = $division[0]->division_id;
					} else {
						$division = $division[0]->division_conference_id;
					}
					$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE division_conference_id = %d;", $division );
					$divisions = Database::get_results( $querystr );

					$division_ids   = [];
					$division_ids[] = $division;
					if ( null !== $divisions ) {
						foreach ( $divisions as $div ) {
							$division_ids[] = $div->division_id;
						}
					}

					if ( in_array( $opponent_division, $division_ids ) ) {
						$draws++;
					}
				}
			}
		}
		return $draws;
	}

	/**
	 * Gets the conference record for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the record from.
	 * @return array              The list of conference wins, losses and draws.
	 */
	public function get_conference_record( $season ) {
		$wins   = $this->get_conference_wins( $season );
		$losses = $this->get_conference_losses( $season );
		$draws  = $this->get_conference_draws( $season );
		$record = [ $wins, $draws, $losses ];
		return $record;
	}

	/**
	 * Gets the home record for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the record from.
	 * @return array              The list of home wins, losses and draws.
	 */
	public function get_home_record( $season ) {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table WHERE ( ( ( ( game_home_id = %d ) AND ( game_home_final > game_away_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$wins        = Database::get_results( $querystr );
		$wins        = $wins[0]->WINS;
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table WHERE ( ( ( ( game_home_id = %d ) AND ( game_home_final < game_away_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$losses      = Database::get_results( $querystr );
		$losses      = $losses[0]->LOSSES;
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS DRAWS FROM $table WHERE ( ( ( ( game_home_id = %d ) AND ( game_home_final = game_away_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$draws       = Database::get_results( $querystr );
		$draws       = $draws[0]->DRAWS;
		$home_record = [ $wins, $losses, $draws ];
		return $home_record;
	}

	/**
	 * Gets the road record for the team in a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the record from.
	 * @return array              The list of road wins, losses and draws.
	 */
	public function get_road_record ( $season ) {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final > game_home_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$wins        = Database::get_results( $querystr );
		$wins        = $wins[0]->WINS;
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final < game_home_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$losses      = Database::get_results( $querystr );
		$losses      = $losses[0]->LOSSES;
		$querystr    = $wpdb->prepare( "SELECT COUNT( * ) AS DRAWS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final = game_home_final ) ) ) AND ( game_season = %s ) AND ( game_status = 'final' ) );", $this->team_id, $season );
		$draws       = Database::get_results( $querystr );
		$draws       = $draws[0]->DRAWS;
		$road_record = [ $wins, $losses, $draws ];
		return $road_record;
	}

	/**
	 * Gets the number of alltime wins for the team.
	 *
	 * @since 2.0.0
	 *
	 * @return int     The number of alltime wins.
	 */
	public function get_alltime_wins() {
		global $wpdb;
		$alltime_wins = 0;
		$table        = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr     = $wpdb->prepare( "SELECT DISTINCT game_season FROM $table WHERE ( game_away_id = %d OR game_home_id = %d );", $this->team_id, $this->team_id );
		$seasons      = Database::get_results( $querystr );
		foreach ( $seasons as $season ) {
			$querystr      = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final > game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final > game_away_final ) ) ) AND ( game_season = %s ) AND game_status = 'final' );", $this->team_id, $this->team_id, $season->game_season );
			$wins          = Database::get_results( $querystr );
			$alltime_wins += $wins[0]->WINS;
		}
		return $alltime_wins;
	}

	/**
	 * Gets the number of alltime losses for the team.
	 *
	 * @since 2.0.0
	 *
	 * @return int     The number of alltime losses.
	 */
	public function get_alltime_losses() {
		global $wpdb;
		$alltime_losses = 0;
		$table          = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr       = $wpdb->prepare( "SELECT DISTINCT game_season FROM $table WHERE ( game_away_id = %d OR game_home_id = %d );", $this->team_id, $this->team_id );
		$seasons        = Database::get_results( $querystr );
		foreach ( $seasons as $season ) {
			$querystr        = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final < game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final < game_away_final ) ) ) AND ( game_season = %s ) AND game_status = 'final' );", $this->team_id, $this->team_id, $season->game_season );
			$losses          = Database::get_results( $querystr );
			$alltime_losses += $losses[0]->LOSSES;
		}
		return $alltime_losses;
	}

	/**
	 * Gets the number of alltime draws for the team.
	 *
	 * @since 2.0.0
	 *
	 * @return int     The number of alltime draws.
	 */
	public function get_alltime_draws() {
		global $wpdb;
		$alltime_draws = 0;
		$table         = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr      = $wpdb->prepare( "SELECT DISTINCT game_season FROM $table WHERE ( game_away_id = %d OR game_home_id = %d );", $this->team_id, $this->team_id );
		$seasons       = Database::get_results( $querystr );
		foreach ( $seasons as $season ) {
			$querystr       = $wpdb->prepare( "SELECT COUNT( * ) AS DRAWS FROM $table WHERE ( ( ( ( game_away_id = %d ) AND ( game_away_final = game_home_final ) ) OR ( ( game_home_id = %d ) AND ( game_home_final = game_away_final ) ) ) AND ( game_season = %s ) AND game_status = 'final' );", $this->team_id, $this->team_id, $season->game_season );
			$draws          = Database::get_results( $querystr );
			$alltime_draws += $draws[0]->DRAWS;
		}
		return $alltime_draws;
	}

	/**
	 * Gets the number of alltime record for the team.
	 *
	 * @since 2.0.0
	 *
	 * @return array     The list of alltime wins, losses and draws.
	 */
	public function get_alltime_record() {
		$wins   = $this->get_alltime_wins();
		$losses = $this->get_alltime_losses();
		$draws  = $this->get_alltime_draws();
		$record = [ $wins, $draws, $losses ];
		return $record;
	}

	/**
	 * Gets the average attendance for a team for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the average attendance from.
	 * @return float              The average attendance for the season.
	 */
	public function get_average_attendance( $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$attendance = 0;
		$home_games = 0;
		$querystr   = $wpdb->prepare( "SELECT game_attendance FROM $table WHERE ( game_home_id = %d ) AND game_season = %s AND game_status = 'final';", $this->team_id, $season );
		$games      = Database::get_results( $querystr );
		foreach ( $games as $game ) {
			$attendance = $attendance + $game->game_attendance;
			$home_games++;
		}
		$average_attendance = $attendance / $home_games;
		return $average_attendance;
	}

	/**
	 * Gets the range of years that the team has been active.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The range of years that the team has been active in the league.
	 */
	public function get_years() {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d or game_home_id = %d ) ORDER BY game_day ASC LIMIT 1;", $this->team_id, $this->team_id );
		$first_game = $wpdb->get_row( $querystr );
		$first_game = $first_game->game_season;

		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_away_id = %d or game_home_id = %d ) ORDER BY game_day DESC LIMIT 1;", $this->team_id, $this->team_id );
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
	 * Gets the team stats for a given season.
	 *
	 * @since 2.0.0
	 *
	 * @param string $season      The season to get the stats for.
	 * @return array              A list of total and average team stats.
	 */
	public function get_team_season_stats( $season ) {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$team = new BaseballTeam( (int) $this->team_id );
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$team = new BasketballTeam( (int) $this->team_id );
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$team = new FootballTeam( (int) $this->team_id );
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$team = new HockeyTeam( (int) $this->team_id );
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$team = new RugbyTeam( (int) $this->team_id );
		} elseif ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$team = new SoccerTeam( (int) $this->team_id );
		} else {
			$team = new VolleyballTeam( (int) $this->team_id );
		}
		return $team->get_team_season_stats( $season );
	}

	public function get_seasons() {
		global $wpdb;
		$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$seasons     = [];
		$seasons_qry = $wpdb->prepare( "SELECT DISTINCT game_season FROM $table WHERE game_away_id = %d OR game_home_id = %d;", $this->team_id, $this->team_id );
		$seasons_list = Database::get_results( $seasons_qry );

		if ( $seasons_list ) {
			foreach ( $seasons_list as $season ) {
				$seasons[] = $season->game_season;
			}
		}

		return $seasons;
	}

}
