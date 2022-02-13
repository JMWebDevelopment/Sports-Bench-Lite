<?php
/**
 * File that creates the widget to display the team schedule in the sidebar.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/public/partials/widgets
 * @author     Jacob Martella <me@jacobmartella.com>
 */

use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Teams;

/**
 * Sports_Bench_Scoreboard_Widget creates a widget for a team schedule.
 *
 * @package    Sports_Bench_Lite
 * @since      2.0.0
 * @access     public
 */
class Sports_Bench_Team_Schedule_Widget extends WP_Widget {

	/**
	 * Sports_Bench_Scoreboard_Widget constructor.
	 *
	 * @since 2.0
	 */
	public function __construct() {
		parent::__construct(
			'sports_bench_team_schedule_widget',
			esc_html__( 'Sports Bench Team Schedule', 'sports-bench' ),
			[
				'classname'     => 'sports_bench_team_schedule_widget',
				'description'   => esc_html__( 'Display the season schedule for a team.', 'sports-bench' ),
			]
		);

	}

	/**
	 * Outputs the HTML of the widget
	 *
	 * @since 2.0
	 *
	 * @param array $args          The arguments for the widget.
	 * @param array $instance      The instance of the widget.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$teams = new Teams();
		$team  = new Team( (int) $instance['team_id'] );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['team_id'] ) ) {
			echo wp_kses_post( $args['before_title'] . $team->get_team_name() . ' ' . __( 'Schedule', 'sports-bench' ) . $args['after_title'] );
		}

		/**
		 * Adds in HTML to be shown before the team schedule widget.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The current HTML for the filter.
		 * @param int    $team_id      The id for the team the schedule is for.
		 * @return string              HTML to be shown before the widget.
		 */
		echo wp_kses_post( apply_filters( 'sports_bench_before_team_schedule_widget', '', $instance['team_id'] ) );
		echo wp_kses_post( $teams->show_team_schedule( $instance['team_id'] ) );

		/**
		 * Adds in HTML to be shown after the team schedule widget.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html         The current HTML for the filter.
		 * @param int    $team_id      The id for the team the schedule is for.
		 * @return string              HTML to be shown after the widget.
		 */
		echo wp_kses_post( apply_filters( 'sports_bench_after_team_schedule_widget', '', $instance['team_id'] ) );

		if ( isset( $instance['team_id'] ) && $instance['team_id'] > 0 ) {
			echo '<a class="button team-schedule-page-button" href="' . esc_attr( $team->get_permalink() ) . '">' . esc_html__( 'View Team', 'sports-bench' ) . '</a>';
		}

		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Creates the form on the back end to accept user inputs
	 *
	 * @since 2.0
	 *
	 * @param array $instance      The instance of the widget.
	 */
	public function form( $instance ) {
		$teams = new Teams();

		if ( isset( $instance['team_id'] ) ) {
			$team_id = $instance['team_id'];
		} else {
			$team_id = '';
		}

		$teams = $teams->get_teams( true );

		echo '<p>';
		echo '<label for ="' . esc_attr( $this->get_field_id( 'team_id' ) ) . '">' . esc_html__( 'Team Schedule to Show:', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'team_id' ) ) . '" name="' . esc_attr( $this->get_field_name( 'team_id' ) ) . '">';
		echo '<option value="">' . esc_html__( 'Select a Team', 'sports-bench' ) . '</option>';
		foreach ( $teams as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $team_id, $key, false ) . '>' . esc_html( $label ) . '</option>';
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
		$teams                 = new Teams();
		$teams                 = $teams->get_teams( true );
		$instance              = [];
		$instance['team_id'] = ( ! in_array( $new_instance['team_id'], $teams ) ) ? wp_strip_all_tags( $new_instance['team_id'] ) : '';
		return $instance;
	}

}
