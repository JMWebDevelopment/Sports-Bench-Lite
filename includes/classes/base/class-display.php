<?php
/**
 * Creates the display class.
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
use Sports_Bench\Classes\Base\Team;

/**
 * The core display class.
 *
 * This is used for the display methords in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Display {

	/**
	 * Creates the new Display object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Returns code to display a Google map for a game's location.
	 *
	 * @since 2.0.0
	 *
	 * @param Game $game      The Game object to display the map for.
	 * @return string         An iFrame for the map.
	 */
	public function show_google_maps( $game ) {
		$key = get_option( 'sports-bench-week-maps-api-key' );

		if ( $key ) {
			$map = '<iframe width="100%" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=' . wp_kses_post( $key ) . ' &q=' . wp_kses_post( $game->get_game_location_line_one() ) . ' + ' . wp_kses_post( $game->get_game_location_line_two() ) . ',' . wp_kses_post( $game->get_game_location_city() ) . '+' . wp_kses_post( $game->get_game_location_state() ) . '+' . wp_kses_post( $game->get_game_location_country() ) . '+' . wp_kses_post( $game->get_game_location_zip_code() ) . '" allowfullscreen></iframe>';
		} else {
			$map = '';
		}

		return $map;
	}

	/**
	 * Gets a list of seasons for the league.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of seasons for the league.
	 */
	public function get_seasons() {
		$seasons_array = array();
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr = "SELECT DISTINCT game_season FROM $table;";
		$seasons  = Database::get_results( $querystr );
		foreach ( $seasons as $season ) {
			array_push( $seasons_array, $season->game_season );
		}

		return $seasons_array;
	}

	/**
	 * Adds in top border colors for a div based on the entered teams.
	 *
	 * @since 2.0.0
	 *
	 * @param int      $team_one_id      The ID for the first team.
	 * @param int|null $team_two_id      The ID for the second team.
	 * @param int|null $div              The ID of the div the border is for.
	 * @return string                    Styling for the top border of the div.
	 */
	public function border_top_colors( $team_one_id, $team_two_id = null, $div = null ) {
		$team_one = new Team( (int) $team_one_id );
		if ( null === $team_two_id && null === $div ) {
			$style = 'style="border-top: 2px solid ' . $team_one->get_team_primary_color() . '"';
		} elseif ( null === $team_two_id && null !== $div ) {
			$style = '<style type="text/css">
						#' . $div . ' {
							border-top: 2px solid ' . $team_one->get_team_primary_color() . ';
						}
					</style>';
		} else {
			$team_two = new Team( (int) $team_two_id );
			$style = '<style type="text/css">
						#' . $div . ' {
							border-top: 2px solid ' . $team_one->get_team_primary_color() . ';
							position: relative;
						}
						#' . $div . ':after {
							content: "";
							display: block;
							position: absolute;
							width: 50%;
							top: -2px;
							right: 0px;
							border-top: 2px solid ' . $team_two->get_team_primary_color() . ';
						}
					</style>';
		}

		return $style;
	}

	/**
	 * Gets the color of a given division/conference.
	 *
	 * @since 2.0.0
	 *
	 * @param int $division_id      The ID of the division or conference.
	 * @return string               The color of the division or conference in hexidecimal format.
	 */
	public function division_color( $division_id ) {
		global $wpdb;
		$table    = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
		$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $division_id );
		$division = Database::get_results( $querystr );
		if ( 'Conference' === $division[0]->division_conference ) {
			$color = $division[0]->division_color;
		} else {
			$conference = $division[0]->division_conference_id;
			$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE division_id = %d;", $conference );
			$division   = Database::get_results( $querystr );
			$color      = $division[0]->division_color;
		}

		return $color;
	}

	/**
	 * Returns a horizontal gradient based on a team's color.
	 *
	 * @since 2.0.0
	 *
	 * @param string $team_color      The team color to apply the gradient.
	 * @return string                 The styling for the gradient.
	 */
	public function team_horizontal_gradient( $team_color ) {
		$style = 'background: ' . $team_color . '; background: -webkit-linear-gradient(left, ' . $team_color . ' , rgba(0,0,0,0)); background: -o-linear-gradient(right, ' . $team_color . ', rgba(0,0,0,0)); background: -moz-linear-gradient(right, ' . $team_color . ', rgba(0,0,0,0)); background: linear-gradient(to right, ' . $team_color . ' , rgba(0,0,0,0));';
		return $style;
	}

	/**
	 * Shows the games stats for the game selected in post meta.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the game stats.
	 */
	public function show_game_stats_info() {
		$html = '';

		$game_id   = get_post_meta( get_the_ID(), 'sports_bench_game', true );
		$game      = new Game( $game_id );
		$away_team = new Team( (int) $game->get_game_away_id() );
		$home_team = new Team( (int) $game->get_game_home_id() );

		/**
		 * Displays the linescore, game events, team and individual stats for a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for the game stats.
		 * @param Game   $game           The current game object.
		 * @param Team   $away_team      The away team oject for the away team.
		 * @param Team   $home_team      The home team oject for the home team.
		 * @return string                The HTML for the game stats section.
		 */
		$html .= apply_filters( 'sports_bench_game_stats_info', '', $game, $away_team, $home_team );

		return $html;
	}

	/**
	 * Adds in top colors for a div based on the teams in a game selected in post meta.
	 *
	 * @since 2.0.0
	 *
	 * @return string      Styling for the border of a div.
	 */
	public function show_team_border_colors() {

		$teams     = sports_bench_get_teams( true, false );
		$team_tags = [];
		foreach ( $teams as $key => $label ) {
			$team = new Team( (int) $key );
			array_push( $team_tags, $team->get_team_slug() );
		}

		if ( get_post_meta( get_the_ID(), 'sports_bench_game', true ) ) {
			$game_id   = get_post_meta( get_the_ID(), 'sports_bench_game', true );
			$game      = new Game( $game_id );
			$away_team = new Team( (int) $game->get_game_away_id() );
			$home_team = new Team( (int) $game->get_game_home_id() );
			$style     = $this->border_top_colors( $home_team->get_team_id(), $away_team->get_team_id(), 'post-' . get_the_id() );
		} else {
			$found     = false;
			$tags      = get_the_tags();
			$tags_list = [];
			if ( $tags ) {
				foreach ( $tags as $tag ) {
					array_push( $tags_list, $tag->slug );
				}
			}
			foreach ( $team_tags as $team ) {
				if ( in_array( $team, $tags_list ) ) {
					$team_slug = $team;
					$found     = true;
				}
			}
			if ( true === $found ) {
				$team  = new Team( $team_slug );
				$style = $this->border_top_colors( $team->get_team_id(), 'post-' . get_the_id() );
			} else {
				$style = '';
			}
		}

		return $style;
	}

	/**
	 * Returns the category for a post or a scoreline for a game if one is selected for the post.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The labelhead for a post.
	 */
	public function show_label_head() {
		$html = '';

		if ( get_post_meta( get_the_ID(), 'sports_bench_game', true ) ) {
			$game_id   = get_post_meta( get_the_ID(), 'sports_bench_game', true );
			$game      = new Game( $game_id );
			$away_team = new Team( (int) $game->get_game_away_id() );
			$home_team = new Team( (int) $game->get_game_home_id() );

			if ( 'recap' === get_post_meta( get_the_ID(), 'sports_bench_game_preview_recap', true ) ) {
				if ( $game->get_game_away_final() > $game->get_game_home_final() || $game->get_game_away_final() === $game->get_game_home_final() ) {
					$html .= '<p class="label-head">' . $away_team->get_team_location() . ' ' . $game->get_game_away_final() . ', ' . $home_team->get_team_location() . ' ' . $game->get_game_home_final() . '</p>';
				} else {
					$html .= '<p class="label-head">' . $home_team->get_team_location() . ' ' . $game->get_game_home_final() . ', ' . $away_team->get_team_location() . ' ' . $game->get_game_away_final() . '</p>';
				}
			} else {
				$html .= '<p class="label-head">' . $away_team->get_team_location() . ' ' . esc_html__( 'at', 'sports-bench' ) . ' ' . $home_team->get_team_location() . '</p>';
			}
		} else {
			$cat   = get_the_category();
			$html .= '<p class="label-head">' . $cat[0]->name . '</p>';
		}

		return $html;
	}

	/**
	 * Shows information for a game if selected for a post in a featured slideshow.
	 *
	 * @since 2.0.0
	 *
	 * @return string       The HTML for showing game information.
	 */
	public function show_slider_game_info() {
		$html = '';

		if ( get_post_meta( get_the_ID(), 'sports_bench_game', true ) ) {
			$game_id   = get_post_meta( get_the_ID(), 'sports_bench_game', true );
			$game      = new Game( $game_id );
			$away_team = new Team( (int) $game->get_game_away_id() );
			$home_team = new Team( (int) $game->get_game_home_id() );
			if ( 'sports_bench_game_preview_recap' === get_post_meta( get_the_ID(), 'sports_bench_game', true ) ) {
				$away_score = $game->get_game_away_final();
				$home_score = $game->get_game_home_final();
			} else {
				$away_score = '';
				$home_score = '';
			}
			$html .= '<div class="game-score">';
			$html .= '<div class="away-score" style="' . sports_bench_team_horizontal_gradient( $away_team->get_team_primary_color ) . '>">';
			$html .= '<table>';
			$html .= '<tr>';
			$html .= '<td>' . $away_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><h3 class="team-name">' . $away_team->get_team_location() . '</h3></td>';
			$html .= '<td class="right"><h3 class="team-name">' . $away_score . '</h3></td>';
			$html .= '</tr>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '<div class="home-score" style="' . sports_bench_team_horizontal_gradient( $home_team->get_team_primary_color ) . '">';
			$html .= '<table>';
			$html .= '<tr>';
			$html .= '<td>' . $home_team->get_team_photo( 'team-logo' ) . '</td>';
			$html .= '<td><h3 class="team-name">' . $home_team->get_team_location() . '</h3></td>';
			$html .= '<td class="right"><h3 class="team-name">' . $home_score . '</h3></td>';
			$html .= '</tr>';
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Changes a hexidecimal color value into a rgb or rgba value.
	 *
	 * @since 2.0.0
	 *
	 * @param string     $color        The hexidecimal value of the color to change.
	 * @param float|bool $opacity      The opacity for the color. Leave blank if you want to use rgb only.
	 * @return string                  The color as a rgb or rgba value.
	 */
	public function hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		if ( empty( $color ) ) {
			return $default;
		}

		if ( '#' === $color[0] ) {
			$color = substr( $color, 1 );
		}

		if ( 6 === strlen( $color ) ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( 3 === strlen( $color ) ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		$rgb =  array_map( 'hexdec', $hex );

		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode( ',', $rgb ) . ')';
		}

		return $output;
	}

}
