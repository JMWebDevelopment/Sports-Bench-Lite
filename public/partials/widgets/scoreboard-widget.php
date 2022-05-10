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

use Sports_Bench\Classes\Base\Scoreboard;

/**
 * Sports_Bench_Scoreboard_Widget creates a custom widget for breaking news.
 *
 * @package    JM_Breaking_News
 * @since      2.0.0
 * @access     public
 */
class Sports_Bench_Scoreboard_Widget extends WP_Widget {

	/**
	 * Sports_Bench_Scoreboard_Widget constructor.
	 *
	 * @since 2.0
	 */
	public function __construct() {
		parent::__construct(
			'sports_bench_scoreboard_widget',
			__( 'Sports Bench Scoreboard', 'sports-bench' ),
			[
				'classname'   => 'sports_bench_scoreboard_widget',
				'description' => esc_html__( 'Display the league scoreboard.', 'sports-bench' ),
			]
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
		extract( $args );

		echo wp_kses_post( $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		$scoreboard = new Scoreboard();
		$scoreboard->display_scoreboard_widget_games();

		if ( isset( $instance['scoreboard_page'] ) && '' !== $instance['scoreboard_page'] ) {
			echo '<a class="button scoreboard-page-button" href="' . esc_attr( get_page_link( $instance['scoreboard_page'] ) ) . '">' . esc_html__( 'View Full Scoreboard', 'sports-bench' ) . '</a>';
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

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}

		if ( isset( $instance['scoreboard_page'] ) ) {
			$scoreboard_page = $instance['scoreboard_page'];
		} else {
			$scoreboard_page = '';
		}

		$page_list     = [];
		$pages         = get_pages();
		$page_list[''] = __( 'Select a Page', 'sports-bench' );
		foreach ( $pages as $page ) {
			$page_list[ $page->ID ] = $page->post_title;
		}

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'sports-bench' ) . '</label>';
		echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) .'" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'scoreboard_page' ) ) . '">' . esc_html__( 'Scoreboard Page: ', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'scoreboard_page' ) ) . '" name="' . esc_attr( $this->get_field_name( 'scoreboard_page' ) ) . '">';
		foreach ( $page_list as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '" ' . selected( $scoreboard_page, $key ) . '>' . esc_html( $label ) . '</option>';
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
		$instance                    = [];
		$instance['title']           = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['scoreboard_page'] = ( ! empty( $new_instance['scoreboard_page'] ) ) ? wp_strip_all_tags( $new_instance['scoreboard_page'] ) : '';
		return $instance;
	}

}
