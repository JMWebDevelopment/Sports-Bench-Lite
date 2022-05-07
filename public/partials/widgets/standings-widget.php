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
use Sports_Bench\Classes\Base\Standings;

/**
 * Sports_Bench_Scoreboard_Widget creates a custom widget for breaking news.
 *
 * @package    JM_Breaking_News
 * @since      2.0.0
 * @access     public
 */
class Sports_Bench_Standings_Widget extends WP_Widget {

	/**
	 * Sports_Bench_Standings_Widget constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct(
			'sports_bench_standings_widget',
			esc_html__( 'Sports Bench Standings', 'sports-bench' ),
			array(
				'classname'     => 'sports_bench_standings_widget',
				'description'   => esc_html__( 'Displays the league, conference or division standings.', 'sports-bench' )
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
		extract( $args );

		echo wp_kses_post( $args['before_widget'] );

		if ( !empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		if ( 'conference' === $instance['division-conference'] ) {
			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr    = "SELECT * FROM $table WHERE division_conference = 'Conference';";
			$conferences = Database::get_results( $querystr );
			foreach ( $conferences as $conference ) {

				/**
				 * Adds in HTML to be shown before the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the widget container.
				 */
				echo apply_filters( 'sports_bench_before_standings_widget_container', '', 'conference', $conference->division_id );
				echo sports_bench_widget_standings( $conference->division_id );

				/**
				 * Adds in HTML to be shown after the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown after the widget container.
				 */
				echo apply_filters( 'sports_bench_after_standings_widget_container', '', 'conference', $conference->division_id );
			}
		} elseif ( 'division' === $instance['division-conference'] ) {
			global $wpdb;
			$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$quer       = "SELECT t1.division_id AS conference_id, t1.division_name AS conference_name, t2.division_id AS division_id, t2.division_name AS division_name, t2.division_conference_id AS division_conference_id FROM $table_name AS t1 LEFT JOIN $table_name AS t2 ON t1.division_id = t2.division_conference_id WHERE t2.division_id IS NOT NULL ORDER BY t1.division_id";
			$divisions  = Database::get_results( $quer );
			$conference = '';
			foreach ( $divisions as $division ) {
				if ( null === $division->division_name ) {
					continue;
				}
				if ( $division->conference_name !== $conference ) {
					echo '<h3 class="conference-name">' . wp_kses_post( $division->conference_name ) .'</h3>';
					$conference = $division->conference_name;
				}

				/**
				 * Adds in HTML to be shown before the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the widget container.
				 */
				echo apply_filters( 'sports_bench_before_standings_widget_container', '', 'division', $division->division_id );
				echo sports_bench_widget_standings( $division->division_id );

				/**
				 * Adds in HTML to be shown before the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the widget container.
				 */
				echo apply_filters( 'sports_bench_after_standings_widget_container', '', 'division', $division->division_id );
			}
		} else {

			/**
				 * Adds in HTML to be shown before the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the widget container.
				 */
			echo apply_filters( 'sports_bench_before_standings_widget_container', '', 'all', 0 );
			echo sports_bench_widget_standings();

			/**
				 * Adds in HTML to be shown before the standings widget container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the widget container.
				 */
			echo apply_filters( 'sports_bench_after_standings_widget_container', '', 'all', 0 );
		}

		if ( isset( $instance['standings_page'] ) && '' !== $instance['standings_page'] ) {
			echo '<a class="button standings-page-button" href="' . esc_attr( get_page_link( $instance['standings_page'] ) ) . '">' . esc_html__( 'View Full Standings', 'sports-bench' ) . '</a>';
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
		$conference_division_array = [
			'all'           => esc_html__( 'Entire League', 'sports-bench' ),
			'conference'    => esc_html__( 'Conference Standings', 'sports-bench' ),
			'division'      => esc_html__( 'Division Standings', 'sports-bench' ),
		];

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}
		if ( isset( $instance['division-conference'] ) ) {
			$division_conference = $instance['division-conference'];
		} else {
			$division_conference = 'all';
		}

		if ( isset( $instance['standings_page'] ) ) {
			$standings_page = $instance['standings_page'];
		} else {
			$standings_page = '';
		}

		$page_list     = [];
		$pages         = get_pages();
		$page_list[''] = esc_html__( 'Select a Page', 'sports-bench' );
		foreach ( $pages as $page ) {
			$page_list[ $page->ID ] = $page->post_title;
		}

		echo '<p>';
			echo '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'sports-bench' ) . '</label>';
			echo '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" />';
		echo '</p>';

		echo '<p>';
		echo '<label for ="' . esc_attr( $this->get_field_id( 'division-conference' ) ) . '">' . esc_html__( 'Standings Set to Show:', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'division-conference' ) ) . '" name="' . esc_attr( $this->get_field_name( 'division-conference' ) ) . '">';
		foreach ( $conference_division_array as $key => $label ) {
			if ( esc_attr( $division_conference ) === $key ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $key ) . '"' . wp_kses_post( $selected ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . esc_attr( $this->get_field_id( 'standings_page' ) ) . '">' . esc_html__( 'Standings Page: ', 'sports-bench' ) . '</label>';
		echo '<select id="' . esc_attr( $this->get_field_id( 'standings_page' ) ) .'" name="' . esc_attr( $this->get_field_name( 'standings_page' ) ) . '">';
		foreach ( $page_list as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '" ' . selected( $standings_page, $key ) . '>' . esc_html( $label ) . '</option>';
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
		$conference_division_array = [
			'all'           => esc_html__( 'Entire League', 'sports-bench' ),
			'conference'    => esc_html__( 'Conference Standings', 'sports-bench' ),
			'division'      => esc_html__( 'Division Standings', 'sports-bench' ),
		];
		$instance                        = [];
		$instance['title']               = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['division-conference'] = ( ! in_array( $new_instance['division-conference'], $conference_division_array ) ) ? strip_tags( $new_instance['division-conference'] ) : '';
		$instance['standings_page']      = ( ! empty( $new_instance['standings_page'] ) ) ? strip_tags( $new_instance['standings_page'] ) : '';
		return $instance;
	}
}
