<?php
/**
 * File that creates the widget to display the scoreboard in the sidebar.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public/partials/widgets
 * @author     Jacob Martella <me@jacobmartella.com>
 */

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Stats;

/**
 * Sports_Bench_Scoreboard_Widget creates a custom widget for breaking news.
 *
 * @package    JM_Breaking_News
 * @since      2.0.0
 * @access     public
 */
class Sports_Bench_Stats_Widget extends WP_Widget {

	/**
	 * Sports_Bench_Standings_Widget constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct(
			'sports_bench_stats_widget',
			__( 'Sports Bench Statistic', 'sports-bench' ),
			array(
				'classname'     => 'sports_bench_stat_widget',
				'description'   => esc_html__( 'Display the top 10 leaders for a chosen stat.', 'sports-bench' )
			)
		);
	}

	/**
	 * Outputs the HTML of the widget.
	 *
	 * @since 2.0
	 *
	 * @param array $args          The arguments for the widget.
	 * @param array $instance      The instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$stats = new Stats();
		extract( $args );

		echo wp_kses_post( $args['before_widget'] );

		if ( !empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		/**
		 * Adds in HTML to be shown before the stat widget container.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param string $stat          The stat that is being shown.
		 * @return string               HTML to be shown before the widget container.
		 */
		echo apply_filters( 'sports_bench_before_stat_widget', '', $instance['stat'] );
		echo wp_kses_post( '<p>' . $stats->get_stat_title( $instance['stat'] ) . '</p>' );
		echo wp_kses_post( $stats->get_stats_leaders( $instance['stat'], get_option( 'sports-bench-season-year' ) ) );

		/**
		 * Adds in HTML to be shown after the stat widget container.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html          The current HTML for the filter.
		 * @param string $stat          The stat that is being shown.
		 * @return string               HTML to be shown after the widget container.
		 */
		echo apply_filters( 'sports_bench_after_stat_widget', '', $instance['stat'] );

		if ( isset( $instance['stats_page'] ) && '' !== $instance['stats_page'] ) {
			echo '<a class="button stats-page-button" href="' . esc_attr( get_page_link( $instance['stats_page'] ) ) . '">' . esc_html__( 'View Full Stats', 'sports-bench' ) . '</a>';
		}

		echo wp_kses_post( $args['after_widget'] );

	}

	/**
	 * Creates the form on the back end to accept user inputs.
	 *
	 * @since 2.0
	 *
	 * @param array $instance      The instance of the widget.
	 */
	public function form( $instance ) {
		$stats_items = $this->stat_items();

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = '';
		}
		if ( isset( $instance['stat'] ) ) {
			$stat = $instance['stat'];
		} else {
			$stat = 'goals';
		}

		if ( isset( $instance['stats_page'] ) ) {
			$stats_page = $instance['stats_page'];
		}
		else {
			$stats_page = '';
		}

		$page_list = [];
		$pages = get_pages();
		$page_list[''] = esc_html__( 'Select a Page', 'sports-bench' );
		foreach ( $pages as $page ) {
			$page_list[ $page->ID ] = $page->post_title;
		}

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'sports-bench' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) .'" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( esc_attr( $title ) ) . '" />';
		echo '</p>';

		echo '<p>';
		echo '<label for ="' . esc_attr( $this->get_field_id( 'stat' ) ) . '">' . esc_html__( 'Stat Set to Show:', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'stat' ) ) . '" name="' . esc_attr( $this->get_field_name( 'stat' ) ) . '">';
		foreach ( $stats_items as $key => $label ) {
			if ( esc_attr( $stat ) === $key ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $key ) . '"' . wp_kses_post( $selected ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'stats_page' ) ) . '">' . esc_html__( 'Stats Page: ', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'stats_page' ) ) . '" name="' . esc_attr( $this->get_field_name( 'stats_page' ) ) . '">';
		foreach ( $page_list as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '" ' . selected( $stats_page, $key ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
		echo '</p>';
	}

	/**
	 * Updates the widget when the user hits save.
	 *
	 * @since 2.0
	 *
	 * @param array $new_instance      The new instance of the widget to save.
	 * @param array $old_instance      The old instance of the widget.
	 * @return array                   An instance of the widget with the updated options.
	 */
	public function update( $new_instance, $old_instance ) {
		$stats_items            = $this->stat_items();
		$instance               = array();
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['stat']       = ( ! in_array( $new_instance['stat'], $stats_items ) ) ? strip_tags( $new_instance['stat'] ) : '';
		$instance['stats_page'] = ( ! empty( $new_instance['stats_page'] ) ) ? strip_tags( $new_instance['stats_page'] ) : '';
		return $instance;
	}

	/**
	 * Returns an array of available stats based on the selected sport
	 *
	 * @since 2.0.0
	 *
	 * @return array      List of available stats to pick from.
	 * @access private
	 */
	private function stat_items() {
		if ( 'soccer' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'shots'                 => esc_html__( 'Shots', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'fouls_suffered'        => esc_html__( 'Fouls Suffered', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'shots_saved'           => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			);
		} elseif ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'at_bats'               => esc_html__( 'At Bats', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'batting_average'       => esc_html__( 'Batting Average', 'sports-bench' ),
				'runs'                  => esc_html__( 'Runs', 'sports-bench' ),
				'rbis'                  => esc_html__( 'RBI', 'sports-bench' ),
				'doubles'               => esc_html__( 'Doubles', 'sports-bench' ),
				'triples'               => esc_html__( 'Triples', 'sports-bench' ),
				'homeruns'              => esc_html__( 'Home Runs', 'sports-bench' ),
				'strikeouts'            => esc_html__( 'Strikeouts', 'sports-bench' ),
				'walks'                 => esc_html__( 'Walks', 'sports-bench' ),
				'hit_by_pitch'          => esc_html__( 'Hit By Pitch', 'sports-bench' ),
				'innings_pitched'       => esc_html__( 'Innings Pitched', 'sports-bench' ),
				'pitcher_strikeouts'    => esc_html__( 'Pitcher Strikeouts', 'sports-bench' ),
				'pitcher_walks'         => esc_html__( 'Pitcher Walks', 'sports-bench' ),
				'hit_batters'           => esc_html__( 'Hit Batters', 'sports-bench' ),
				'runs_allowed'          => esc_html__( 'Runs Allowed', 'sports-bench' ),
				'earned_runs'           => esc_html__( 'Earned Runs', 'sports-bench' ),
				'era'                   => esc_html__( 'ERA', 'sports-bench' ),
				'hits_allowed'          => esc_html__( 'Hits Allowed', 'sports-bench' ),
				'homeruns_allowed'      => esc_html__( 'Home Runs Allowed', 'sports-bench' ),
				'pitch_count'           => esc_html__( 'Pitch Count', 'sports-bench' ),
			);
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'started'               => esc_html__( 'Starts', 'sports-bench' ),
				'minutes'               => esc_html__( 'Minutes', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'points_per_game'       => esc_html__( 'Points Per Game', 'sports-bench' ),
				'shooting_percentage'   => esc_html__( 'Shooting Percentage', 'sports-bench' ),
				'ft_percentage'         => esc_html__( 'Free Throw Percentage', 'sports-bench' ),
				'3p_percentage'         => esc_html__( '3-Point Percentage', 'sports-bench' ),
				'off_rebound'           => esc_html__( 'Offensive Rebounds', 'sports-bench' ),
				'def_rebound'           => esc_html__( 'Defensive Rebounds', 'sports-bench' ),
				'rebounds'              => esc_html__( 'Total Rebounds', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'steals'                => esc_html__( 'Steals', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'to'                    => esc_html__( 'Turnovers', 'sports-bench' ),
				'fouls'                 => esc_html__( 'Fouls', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
			);
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'completions'       => esc_html__( 'Completions', 'sports-bench' ),
				'attempts'          => esc_html__( 'Attempts', 'sports-bench' ),
				'comp_percentage'   => esc_html__( 'Completion Percentage', 'sports-bench' ),
				'pass_yards'        => esc_html__( 'Passing Yards', 'sports-bench' ),
				'pass_tds'          => esc_html__( 'Passing Touchdowns', 'sports-bench' ),
				'pass_ints'         => esc_html__( 'Interceptions', 'sports-bench' ),
				'rushes'            => esc_html__( 'Rushes', 'sports-bench' ),
				'rush_yards'        => esc_html__( 'Rushing Yards', 'sports-bench' ),
				'rush_tds'          => esc_html__( 'Rushing Touchdowns', 'sports-bench' ),
				'rush_fumbles'      => esc_html__( 'Rushing Fumbles', 'sports-bench' ),
				'catches'           => esc_html__( 'Catches', 'sports-bench' ),
				'receiving_yards'   => esc_html__( 'Receiving Yards', 'sports-bench' ),
				'receiving_tds'     => esc_html__( 'Receiving Touchdowns', 'sports-bench' ),
				'receiving_fumbles' => esc_html__( 'Receiving Fumbles', 'sports-bench' ),
				'tackles'           => esc_html__( 'Tackles', 'sports-bench' ),
				'tfl'               => esc_html__( 'Tackles For Loss', 'sports-bench' ),
				'sacks'             => esc_html__( 'Sacks', 'sports-bench' ),
				'pbu'               => esc_html__( 'Pass Breakups', 'sports-bench' ),
				'ints'              => esc_html__( 'Interceptions', 'sports-bench' ),
				'tds'               => esc_html__( 'Defensive Touchdowns', 'sports-bench' ),
				'ff'                => esc_html__( 'Forced Fumbles', 'sports-bench' ),
				'fr'                => esc_html__( 'Fumbles Recovered', 'sports-bench' ),
				'blocked'           => esc_html__( 'Blocked Kicks', 'sports-bench' ),
				'yards'             => esc_html__( 'Defensive Return Yards', 'sports-bench' ),
				'fgm'               => esc_html__( 'Made Field Goals', 'sports-bench' ),
				'fg_percentage'     => esc_html__( 'Field Goal Percentage', 'sports-bench' ),
				'xpm'               => esc_html__( 'Made Extra Points', 'sports-bench' ),
				'xp_percentage'     => esc_html__( 'Extra Point Percentage', 'sports-bench' ),
				'touchbacks'        => esc_html__( 'Touchbacks', 'sports-bench' ),
				'returns'           => esc_html__( 'Returns', 'sports-bench' ),
				'return_yards'      => esc_html__( 'Return Yards', 'sports-bench' ),
				'return_tds'        => esc_html__( 'Return Touchdowns', 'sports-bench' ),
				'return_fumbles'    => esc_html__( 'Return Fumbles', 'sports-bench' ),
			);
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'goals'                 => esc_html__( 'Goals', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'plus_minus'            => esc_html__( 'Plus/Minus', 'sports-bench' ),
				'sog'                   => esc_html__( 'Shots on Goal', 'sports-bench' ),
				'penalties'             => esc_html__( 'Penalties', 'sports-bench' ),
				'pen_minutes'           => esc_html__( 'Penalty Minutes', 'sports-bench' ),
				'hits'                  => esc_html__( 'Hits', 'sports-bench' ),
				'shifts'                => esc_html__( 'Shifts', 'sports-bench' ),
				'time_on_ice'           => esc_html__( 'Time on Ice', 'sports-bench' ),
				'faceoffs'              => esc_html__( 'Faceoffs', 'sports-bench' ),
				'faceoff_wins'          => esc_html__( 'Faceoff WIns', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'shots_saved'           => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			);
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'tries'                 => esc_html__( 'Tries', 'sports-bench' ),
				'assists'               => esc_html__( 'Assists', 'sports-bench' ),
				'conversions'           => esc_html__( 'Conversions', 'sports-bench' ),
				'penalty_goals'         => esc_html__( 'Penalty Goals', 'sports-bench' ),
				'drop_kicks'            => esc_html__( 'Drop Kicks', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'penalties_conceeded'   => esc_html__( 'Penalties Conceded', 'sports-bench' ),
				'meters_run'            => esc_html__( 'Meters Run', 'sports-bench' ),
				'red_cards'             => esc_html__( 'Red Cards', 'sports-bench' ),
				'yellow_cards'          => esc_html__( 'Yellow Cards', 'sports-bench' ),
			);
		} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = array(
				'sets_played'           => esc_html__( 'Sets Played', 'sports-bench' ),
				'points'                => esc_html__( 'Points', 'sports-bench' ),
				'kills'                 => esc_html__( 'Kills', 'sports-bench' ),
				'hitting_errors'        => esc_html__( 'Hitting Errors', 'sports-bench' ),
				'attacks'               => esc_html__( 'Attacks', 'sports-bench' ),
				'hitting_percentage'    => esc_html__( 'Hitting Percentage', 'sports-bench' ),
				'set_attempts'          => esc_html__( 'Set Attempts', 'sports-bench' ),
				'set_errors'            => esc_html__( 'Setting Errors', 'sports-bench' ),
				'serves'                => esc_html__( 'Serves', 'sports-bench' ),
				'serve_errors'          => esc_html__( 'Serving Errors', 'sports-bench' ),
				'aces'                  => esc_html__( 'Aces', 'sports-bench' ),
				'blocks'                => esc_html__( 'Blocks', 'sports-bench' ),
				'block_attempts'        => esc_html__( 'Block Attempts', 'sports-bench' ),
				'block_errors'          => esc_html__( 'Blocking Errors', 'sports-bench' ),
				'digs'                  => esc_html__( 'Digs', 'sports-bench' ),
				'receiving_errors'      => esc_html__( 'Receiving Erros', 'sports-bench' ),
			);
		}
		return $stats_items;
	}
}
