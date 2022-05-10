<?php
/**
 * Creates the players class.
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
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The core teams class.
 *
 * This is used for the teams in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Players {

	/**
	 * Creates the new Teams object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Returns the goals against average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $goals_allowed      The number of goals allowed.
	 * @param int $games_played       The number of games/matches played.
	 * @return float                  The goals against average.
	 */
	public function get_goals_against_average( $goals_allowed, $games_played ) {
		$average = $goals_allowed / $games_played;
		$average = number_format( (float) $average, 2, '.', '' );

		return $average;
	}

	/**
	 * Returns the ERA for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int   $earned_runs           The number of earned runs given up.
	 * @param float $innings_pitched       The number of innings pitched.
	 * @param int   $innings_per_game      The number of innings per game.
	 * @return float|string                The ERA for the player.
	 */
	public function get_ERA( $earned_runs, $innings_pitched, $innings_per_game ) {
		if ( 0 === $innings_pitched && $earned_runs > 0 ) {
			$era = '&infin;';
		} elseif ( 0 === $innings_pitched && 0 === $earned_runs ) {
			$era = '0.00';
		} else {
			$era = $innings_per_game * ( $earned_runs / $innings_pitched );
			$era = number_format( (float) $era, 2, '.', '' );
		}
		return $era;
	}

	/**
	 * Returns the batting average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $at_bats       The number of at bats.
	 * @param int $hits          The number of hits.
	 * @return float|string      The batting average for the player.
	 */
	public function get_batting_average( $at_bats, $hits ) {
		if ( 0 === $at_bats ) {
			return '.000';
		}
		$average = $hits / $at_bats;
		$average = number_format( (float) $average, 3, '.', '' );
		return $average;
	}

	/**
	 * Gets the points per game average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $points      The number of points scored.
	 * @param int $games       The number of games played.
	 * @return float           The points per game for the player.
	 */
	public function get_points_average( $points, $games ) {
		$average = $points / $games;
		$average = number_format( (float) $average, 2, '.', '' );

		return $average;
	}

	/**
	 * Gets the hitting percentage for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $attacks        The number of attacks.
	 * @param int $kills          The number of kills.
	 * @param int $errors         The number of hitting errors.
	 * @return float|string       The hitting percentage for the player.
	 */
	public function get_hitting_percentage( $attacks, $kills, $errors ) {
		if ( 0 === $attacks ) {
			$hit_percent = '.000';
		} else {
			$hit_percent = number_format( (float) ( $kills - $errors ) / $attacks, 3, '.', '' );
		}

		return $hit_percent;
	}

	/**
	 * Gets the shooting average for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $made          The number of made shots.
	 * @param int $attempts      The number of shot attempts.
	 * @return float|string      The shooting averate for the player.
	 */
	public function get_shooting_average( $made, $attempts ) {
		if ( 0 === $attempts ) {
			$average = '0.00';
		} else {
			$average = $made / $attempts;
			$average = number_format( (float) $average, 3, '.', '' );
			$average = $average * 100;
		}
		return $average;
	}

	/**
	 * Gets the season stats tabe for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param Player $player      The player object to get the stats table for.
	 * @return string             The HTML for the stats table.
	 */
	public function get_season_stats( $player ) {
		$html    = '';
		$seasons = $player->get_seasons_stats();

		/**
		 * Returns the HTML for the player stats table.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The incoming HTML for the table.
		 * @param Player $player       The player object to get the stats table for.
		 * @param string $sport        The sport the website is using.
		 * @param array  $seasons      The list of season stats to use in the table.
		 * @return string              The HTML for the player stats table.
		 */
		$html .= apply_filters( 'sports_bench_player_stats_table', $html, $player, get_option( 'sports-bench-sport' ), $seasons );

		return $html;
	}

	/**
	 * Displays the information about the player for the shortcode.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html          The current HTML for the filter.
	 * @param Player $player        The Player object the shortcode is for.
	 * @param array  $team          The current team id of the team the player plays for.
	 * @return string               The HTML to show the information about the player.
	 */
	public function sports_bench_do_player_shortcode_information( $html, $player, $team ) {
		if ( 0 < $team ) {
			$team = new Team( (int) $team );
		} else {
			$team = 0;
		}
		$html .= '<div class="player-top-info">';
		$html .= '<div class="player-photo">';
		if ( $player->get_player_photo() ) {
			$html .= '<div class="player-photo">';
			$html .= $player->get_player_photo();
			$html .= '</div>';
		} else {
			$html .= '<div class="player-photo">';
			$html .= '<img src="' . plugins_url( '../../../public/images/mystery-person.jpg', __FILE__ ) . '" alt="mystery-person" />';
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '<div class="player-info">';
		$html .= '<h2 class="player-name"><a href="' . $player->get_permalink() . '">' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . '</a></h2>';
		if ( '' !== $player->get_player_home_city() && '' !== $player->get_player_home_state() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_city() . ', ' . $player->get_player_home_state() . '</p>';
		} elseif ( '' !== $player->get_player_home_city() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_city() . '</p>';
		} elseif ( '' !== $player->get_player_home_state() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_state() . '</p>';
		}
		if ( 0 !== $team ) {
			$html .= '<p class="player-team">' . $team->get_team_name() . '</p>';
		}
		if ( '' !== $player->get_age() ) {
			$html .= '<p class="player-details">' . esc_html__( 'Age: ', 'sports-bench' ) . $player->get_age() . '</p>';
		}
		$html .= '<p class="player-seasons-played">' . esc_html__( 'Seasons Played: ', 'sports-bench' ) . $player->get_seasons_played() . '</p>';
		$html .= apply_filters( 'the_content', $player->get_player_bio() );
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Checks to see if a stat exists for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $player      The array to check to see if the stat exists.
	 * @param string $stat        The stat to search for.
	 * @return bool               Whether the stat exists or not.
	 */
	public function stat_exists( $player, $stat ) {
		foreach ( $player as $the_player ) {
			if ( $the_player->$stat > 0 && null !== $the_player->$stat ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Gets the number of wins for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $player_id      The id for the player.
	 * @param string $season         The season to check for wins.
	 * @return int                   The number of wins for the player.
	 */
	public function get_pitcher_wins( $player_id, $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS WINS FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'W' ) AND ( g.game_season = %s ) );", $player_id, $season );
		$wins       = Database::get_results( $querystr );
		if ( ! empty( $wins ) ) {
			return $wins[0]->WINS;
		} else {
			return 0;
		}
	}

	/**
	 * Gets the number of losses for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $player_id      The id for the player.
	 * @param string $season         The season to check for losses.
	 * @return int                   The number of losses for the player.
	 */
	public function get_pitcher_losses( $player_id, $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS LOSSES FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'L' ) AND ( g.game_season = %s ) );", $player_id, $season );
		$losses     = Database::get_results( $querystr );
		if ( ! empty( $losses ) ) {
			return $losses[0]->LOSSES;
		} else {
			return 0;
		}
	}

	/**
	 * Gets the record for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $player_id      The id for the player.
	 * @param string $season         The season to get the record.
	 * @return array                 The record for the player.
	 */
	public function get_pitcher_record( $player_id, $season ) {
		$record = [
			'wins'      => $this->get_pitcher_wins( $player_id, $season ),
			'losses'    => $this->get_pitcher_losses( $player_id, $season ),
		];
		return $record;
	}

	/**
	 * Gets the number of saves for a pitcher.
	 *
	 * @since 2.0.0
	 *
	 * @param int    $player_id      The id for the player.
	 * @param string $season         The season to check for saves.
	 * @return int                   The number of saves for the player.
	 */
	public function get_pitcher_saves( $player_id, $season ) {
		global $wpdb;
		$table      = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$game_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr   = $wpdb->prepare( "SELECT COUNT( * ) AS SAVES FROM $table AS gs LEFT JOIN $game_table AS g ON gs.game_id = g.game_id WHERE ( ( gs.game_player_id = %d ) AND ( gs.game_player_decision = 'S' ) AND ( g.game_season = %s ) );", $player_id, $season );
		$saves      = Database::get_results( $querystr );
		if ( ! empty( $saves ) ) {
			return $saves[0]->SAVES;
		} else {
			return 0;
		}
	}

	/**
	 * Returns the HTML for the select dropdown for the team select on the players page.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the select dropdown.
	 */
	public function show_team_player_select() {
		$html  = '';
		$html .= '<div id="team-select" class="row sports-bench-row">';
		$html .= '<label for="player-page-select">' . esc_html__( 'Select a Team', 'sports-bench' ) . '</label>';
		$html .= '<select name="player-page-select" id="player-page-select">';
		$html .= '<option value="">' . esc_html__( '--- Select a Team ---', 'sports-bench' ) . '</option>';
		$html .= '<option value="0">' . esc_html__( 'Free Agent', 'sports-bench' ) . '</option>';
		$teams = sports_bench_get_teams( true );
		foreach ( $teams as $team_id => $team_name ) {
			$html .= '<option value="' . $team_id . '">' . $team_name . '</option>';
		}
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div id="team-players" class="row sports-bench-row"></div>';

		return $html;
	}

	/**
	 * Returns a list of players for a team selected through AJAX.
	 *
	 * @since 2.0.0
	 */
	public function load_player_list() {
		check_ajax_referer( 'sports-bench-load-player-list-nonce', 'nonce' );

		$html        = '';
		$team_id     = wp_filter_nohtml_kses( $_POST['team_id'] );
		$team        = new Team( (int) $team_id );
		$players     = $team->get_roster();
		$num_players = count( $players );
		$count       = 0;

		foreach ( $players as $player ) {

			/**
			 * Displays the player information in the player listing.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The incoming HTML for the listing.
			 * @param array  $player           The array of information for the player.
			 * @param Team   $team             The team object for the player's current team.
			 * @param int    $num_players      The total number of players in the list.
			 * @param int    $count            The current number of player.
			 * @return string                  The HTML for the listing.
			 */
			$html .= apply_filters( 'sports_bench_player_listing_information', '', $player, $team, $num_players, $count );
			$count++;
		}

		wp_send_json_success( $html );
		wp_die();

	}

	/**
	 * Displays the player information in the player listing.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html             The incoming HTML for the listing.
	 * @param array  $player           The array of information for the player.
	 * @param Team   $team             The team object for the player's current team.
	 * @param int    $num_players      The total number of players in the list.
	 * @param int    $count            The current number of player.
	 * @return string                  The HTML for the listing.
	 */
	public function sports_bench_do_player_listing_information( $html, $player, $team, $num_players, $count ) {

		/**
		 * Returns the styles or HTML elements to show before the player listing information.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html      The incoming HTML or styles.
		 * @param Team   $team      The team object for the player's current team.
		 * @return string           The styles or HTML elements to show before the player listing information.
		 */
		$html .= apply_filters( 'sports_bench_before_player_info', '', $team );
		$html .= '<div class="player">';
		$html .= '<aside class="player-info clearfix">';
		$html .= '<p class="playername">' . $player['first_name'] . ' ' . $player['last_name'] . '</p>';
		$html .= '<div class="right">';
		$html .= $player['photo'];
		$html .= '</div>';
		$html .= '<p>';
		$html .= $player['position'] . '<br />';
		if ( '' !== $player['age'] ) {
			$html .= $player['age'] . '<br />';
		}
		if ( '' !== $player['home_city'] && '' !== $player['home_state'] ) {
			$html .= '<p class="player-details">' . $player['home_city'] . ', ' . $player['home_state'] . '</p>';
		} elseif ( '' !== $player['home_city'] ) {
			$html .= '<p class="player-details">' . $player['home_city'] . '</p>';
		} elseif ( '' !== $player['home_state'] ) {
			$html .= '<p class="player-details">' . $player['home_state'] . '</p>';
		}
		$html .= '</p>';
		$html .= '<a class="button" href="' . $player['player_page'] . '">' . esc_html__( 'View Player', 'sports-bench' ) . '</a>';
		$html .= '</aside>';
		$html .= '</div>';

		/**
		 * Returns the styles or HTML elements to show after the player listing information.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html      The incoming HTML or styles.
		 * @param Team   $team      The team object for the player's current team.
		 * @return string           The styles or HTML elements to show after the player listing information.
		 */
		$html .= apply_filters( 'sports_bench_after_player_info', '', $team );
		return $html;
	}

	/**
	 * Shows the information for a player.
	 *
	 * @since 2.0.0
	 *
	 * @param int $player_id      The id of the player to show information about.
	 * @return string             The information about a player.
	 */
	public function show_player_info( $player_id ) {
		$html   = '';
		$player = new Player( (int) $player_id );
		$team   = new Team( (int) $player->get_team_id() );

		/**
		 * Displays the player information.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html             The incoming HTML for the listing.
		 * @param Player $player           The player object for the current player.
		 * @param Team   $team             The team object for the player's current team.
		 * @return string                  The HTML for the player information.
		 */
		$html .= apply_filters( 'sports_bench_player_information', $html, $player, $team );

		return $html;
	}

	/**
	 * Displays the player information.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html             The incoming HTML for the listing.
	 * @param Player  $player          The player object for the current player.
	 * @param Team   $team             The team object for the player's current team.
	 * @return string                  The HTML for the player information.
	 */
	public function sports_bench_do_player_information( $html, $player, $team ) {
		$html .= '<div class="player-photo">';
		if ( $player->get_player_photo() ) {
			$html .= '<div class="player-photo">';
			$html .= $player->get_player_photo();
			$html .= '</div>';
		} else {
			$html .= '<div class="player-photo">';
			$html .= '<img src="' . plugins_url( '../images/mystery-person.jpg', __FILE__ ) . '" alt="mystery-person" />';
			$html .= '</div>';
		}
		$html .= '</div>';

		$html .= '<div class="player-details">';
		$html .= '<h2 class="player-name">' . $player->get_player_first_name() . ' ' . $player->get_player_last_name() . '</h2>';
		$html .= '<p class="player-details">' . $player->get_player_position() . '</p>';
		$html .= '<p class="player-details">' . $team->get_team_name() . '</p>';
		if ( '' !== $player->get_player_home_city() && '' !== $player->get_player_home_state() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_city() . ', ' . $player->get_player_home_state() . '</p>';
		} elseif ( '' !== $player->get_player_home_city() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_city() . '</p>';
		} elseif ( '' !== $player->get_player_home_state() ) {
			$html .= '<p class="player-details">' . $player->get_player_home_state() . '</p>';
		}
		if ( '' !== $player->get_age() ) {
			$html .= '<p class="player-details">' . esc_html__( 'Age: ', 'sports-bench' ) . $player->get_age() . '</p>';
		}
		if ( '' !== $player->get_player_height() && 0 < $player->get_player_weight() ) {
			$html .= '<p class="player-details">' . stripslashes( $player->get_player_height() ) . ' | ' . $player->get_player_weight() . '</p>';
		} elseif ( '' !== $player->get_player_height() ) {
			$html .= '<p class="player-details">' . stripslashes( $player->get_player_height() ) . '</p>';
		} elseif ( 0 < $player->get_player_weight() ) {
			$html .= '<p class="player-details">' . $player->get_player_weight() . '</p>';
		}
		$html .= '<p class="player-seasons-played">' . esc_html__( 'Seasons Played: ', 'sports-bench' ) . $player->get_seasons_played() . '</p>';
		$html .= apply_filters( 'the_content', $player->get_player_bio() );
		$html .= '<div id="sports-bench-player-id" class="hide">' . $player->get_player_id() . '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Sanitizies the input for an array.
	 *
	 * @since 2.1.5
	 *
	 * @param array $input      The array of incoming information to sanitize.
	 * @return array            The array of sanitized data.
	 */
	public function sanitize_array( $input ) {

		// Initialize the new array that will hold the sanitize values
		$new_input = array();

		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {
			if ( is_array( $val ) ) {
				$new_input[ $key ] = $this->sanitize_array( $val );
			} else {
				$new_input[ $key ] = sanitize_text_field( $val );
			}
		}

		return $new_input;

	}

}
