<?php
/**
 * Creates the scoreboard class.
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
 * The core scoreboard class.
 *
 * This is used for the scoreboard in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Scoreboard {

	/**
	 * Creates the new Scoreboard object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

	}

	/**
	 * Displays the scoreboard bar.
	 *
	 * @since 2.0.0
	 *
	 * @param string $class      The class(es) to add to the parent scorebard bar div.
	 */
	public function display_scoreboard_bar( $class = null ) {
		$games = $this->get_scoreboard_bar_games();
		?>
		<div id="scoreboard-bar" class="scoreboard row sports-bench-row <?php echo esc_attr( $class ); ?>">
			<div id="scoreboard-left" class="scoreboard-navigation">
				<button id="scoreboard-bar-left">
					<?php
					/**
					 * Displays the content for the scoreboard left button.
					 *
					 * @since 2.0.0
					 *
					 * @param string $html          The current HTML for the button.
					 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
					 * @return string               The content for the scoreboard bar left button.
					 */
					echo wp_kses_post( apply_filters( 'sports_bench_scoreboard_left', '<span class="fal fa-chevron-left"><span class="screen-reader-text">' . esc_html__( 'Move Scoreboard Left', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
					?>
				</button>
			</div>

			<div id="scoreboard-main">

				<div id="scoreboard-inner" class="clearfix">

					<?php
					if ( ! empty( $games ) ) {
						foreach ( $games as $game ) {

							/**
							 * Displays the content for the scoreboard bar game.
							 *
							 * @since 2.0.0
							 *
							 * @param string $html      The current content for the scoreboard bar game.
							 * @param array  $game      Information for the current game.
							 * @return string           HTML for the content of the game.
							 */
							echo apply_filters( 'sports_bench_scoreboard_bar_game', '', $game );
						}
					}
					?>

				</div>

			</div>

			<div id="scoreboard-right" class="scoreboard-navigation">
				<button id="scoreboard-bar-right">
					<?php
					/**
					 * Displays the content for the scoreboard right button.
					 *
					 * @since 2.0.0
					 *
					 * @param string $html          The current HTML for the button.
					 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
					 * @return string               The content for the scoreboard bar right button.
					 */
					echo wp_kses_post( apply_filters( 'sports_bench_scoreboard_right', '<span class="fal fa-chevron-right"><span class="screen-reader-text">' . esc_html__( 'Move Scoreboard Right', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
					?>
				</button>
			</div>
		</div>
		<?php
	}

	/**
	 * Gets the games for the scoreboard bar.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of games to show.
	 */
	public function get_scoreboard_bar_games() {
		global $wpdb;
		$games = [];
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		if ( '1' === get_option( 'sports-bench-display-game' ) ) {
			$week     = get_option( 'sports-bench-week-number' );
			$season   = get_option( 'sports-bench-season-year' );
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_week = %d AND game_season = %s ORDER BY game_day ASC;", $week, $season );
			$games    = Database::get_results( $querystr );
		} else {
			$today      = strtotime( 'today' );
			$lower_date = strtotime( '-3 days', $today );
			$lower_date = date( 'Y-m-d H:i:s', $lower_date );
			$upper_date = strtotime( '+4 days', $today );
			$upper_date = date( 'Y-m-d H:i:s', $upper_date );
			$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE game_day >= %s and game_day <= %s ORDER BY game_day ASC;", $lower_date, $upper_date );
			$games      = Database::get_results( $querystr );
			if ( null === $games ) {
				$today      = strtotime( 'today' );
				$date       = date( 'Y-m-d', $today );
				$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) > %s;", $date );
				$games_left = Database::get_results( $querystr );
				if ( null === $games_left ) {
					$season   = get_option( 'sports-bench-season-year' );
					$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_season = %s ORDER BY game_day DESC LIMIT 1;", $season );
					$games    = Database::get_results( $querystr );
				} else {
					$today    = strtotime( 'today' );
					$date     = date( 'Y-m-d', $today );
					$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
					$games    = Database::get_results( $querystr );
					while ( null === $games ) {
						$today    = strtotime( '+1 day', $today );
						$date     = date( 'Y-m-d', $today );
						$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
						$games    = Database::get_results( $querystr );
					}
				}
			}
		}

		return $games;
	}

	/**
	 * Displays the content for the scoreboard bar game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html      The current content for the scoreboard bar game.
	 * @param array  $game      Information for the current game.
	 * @return string           HTML for the content of the game.
	 */
	public function sports_bench_do_scoreboard_bar_game( $html, $game ) {
		$away_team = new Team( (int) $game->game_away_id );
		$home_team = new Team( (int) $game->game_home_id );
		$the_game  = new Game( (int) $game->game_id );
		$status    = $game->game_status;

		if ( 'in_progress' === $status ) {
			$away_score = $game->game_current_away_score;
			$home_score = $game->game_current_home_score;
			$datetime   = '';
			if ( ( null !== $game->game_current_period && '' !== $game->game_current_period ) && null !== $game->game_current_time ) {
				$sep = ' | ';
			} else {
				$sep = '';
			}
			$period       = $game->game_current_period;
			$time         = stripslashes( $game->game_current_time );
			$time_in_game = $time . $sep . $period;
		} elseif ( 'final' === $status ) {
			$away_score   = $game->game_away_final;
			$home_score   = $game->game_home_final;
			$datetime     = '';
			$time_in_game = 'FINAL';
		} else {
			$away_score   = '';
			$home_score   = '';
			$time_in_game = '';
			$date         = date_create( $game->game_day );
			if ( true === $this->is_game_time_set( $date ) ) {
				$datetime = date_format( $date, 'g:i a, F j' );
			} else {
				$datetime = date_format( $date, 'F j' );
			}
		}

		/**
		 * Adds in styles or HTML elements before a scoreboard bar game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go before the game.
		 * @param int    $game_id        The id of the game.
		 * @param Team   $away_team      The away team for the game.
		 * @param Team   $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for before the game.
		 */
		$html .= apply_filters( 'sports_bench_before_scoreboard_bar_game', '', $game->game_id, $away_team, $home_team );

		$html .= '<div id="' . esc_attr( $game->game_id ) . '" class="scoreboard-game">';
		$html .= '<div class="scoreboard-table">';

		/**
		 * Adds in the styles for a scoreboard bar row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param Team   $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$away_row_style = apply_filters( 'sports_bench_scoreboard_bar_row_styles', '', $away_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $away_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $away_team->get_team_location() ) . '</div>';
		$html          .= '<div class="team-score away-score">' . esc_html( $away_score ) . '</div>';
		$html          .= '</div>';

		/**
		 * Adds in the styles for a scoreboard bar row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param Team   $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$home_row_style = apply_filters( 'sports_bench_scoreboard_bar_row_styles', '', $home_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $home_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $home_team->get_team_location() ) . '</div>';
		$html          .= '<div class="home-score team-score">' . esc_html( $home_score ) . '</div>';
		$html          .= '</div>';
		$html          .= '<div class="game-info-row">';
		$html          .= '<div class="time">' . esc_html( $datetime . $time_in_game ) . '</div>';
		$html          .= '</div>';
		$html          .= '</div>';

		if ( ( null !== $game->game_recap && 'final' === $game->game_status ) || ( null === $game->game_preview && 'scheduled' === $game->game_status ) || ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) ) {
			$html .= '<div class="recap-overlay">';

			if ( null !== $game->game_recap && 'final' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_recap . '">';
				$html .= '<div>' . __( 'RECAP', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			} elseif ( null === $game->game_preview && 'scheduled' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_preview . '">';
				$html .= '<div>' . __( 'PREVIEW', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			if ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) {
				$html .= '<div class="recap-element box-score-element">';
				$html .= '<a href="' . $the_game->get_box_score_permalink() . '">';
				$html .= '<div>' . __( 'BOX SCORE', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			$html .= '</div>';
		}

		$html .= '</div>';

		/**
		 * Adds in styles or HTML elements after a scoreboard bar game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go after the game.
		 * @param int    $game_id        The id of the game.
		 * @param Team   $away_team      The away team for the game.
		 * @param Team   $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for after the game.
		 */
		$html .= apply_filters( 'sports_bench_after_scoreboard_bar_game', '', $game->game_id, $away_team, $home_team );

		return $html;

	}

	/**
	 * Checks to see if the game time has been set for a game.
	 *
	 * @since 2.0.0
	 *
	 * @param DateTime $time      The datetime object for the game date/time.
	 * @return bool               Whether a time has been set for the game.
	 */
	public function is_game_time_set( $time ) {
		if ( 0 === $time->format( 'H' ) && 0 === $time->format( 'i' ) && 0 === $time->format( 's' ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Displays the games for the scoreboard widget.
	 *
	 * @since 2.0.0
	 */
	public function display_scoreboard_widget_games() {
		$game_data = $this->get_scoreboard_widget_games();
		$games     = $game_data[0];
		$today     = $game_data[1];
		$date      = $game_data[2];
		?>

		<?php
		if ( null === $games ) {
			?>
			<p><?php esc_html_e( 'There are no games entered for the given season. Please enter a game.', 'sports-bench' ); ?></p>
			<?php
		} else {
			?>
			<div class="sports-bench-scoreboard-date-row">
				<div id="scoreboard-widget-left-container">
					<button id="scoreboard-widget-left">
						<?php
						/**
						 * Displays the content for the scoreboard left button.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html          The current HTML for the button.
						 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
						 * @return string               The content for the scoreboard bar left button.
						 */
						echo wp_kses_post( apply_filters( 'sports_bench_scoreboard_left', '<span class="fal fa-chevron-left"><span class="screen-reader-text">' . esc_html__( 'Load Earlier Games', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
						?>
					</button>
				</div>

				<div id="scoreboard-title">
					<?php
					if ( '1' === get_option( 'sports-bench-display-game' ) ) {
						?>
						<h3 class="scoreboard-widget-title"><?php echo esc_html__( 'Week', 'sports-bench' ) . ' ' . esc_html( get_option( 'sports-bench-week-number' ) ); ?></h3>
						<?php
					} else {
						?>
						<h3 class="scoreboard-widget-title"><?php echo esc_html( date( 'F j, Y', $today ) ); ?><span id="widget-hidden-date"><?php echo esc_html( trim( trim( $date, "'" ), '"' ) ); ?></span></h3>
						<?php
					}
					?>
				</div>

				<div id="scoreboard-widget-right-container">
					<button id="scoreboard-widget-right">
						<?php
						/**
						 * Displays the content for the scoreboard right button.
						 *
						 * @since 2.0.0
						 *
						 * @param string $html          The current HTML for the button.
						 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
						 * @return string               The content for the scoreboard bar right button.
						 */
						echo wp_kses_post( apply_filters( 'sports_bench_scoreboard_right', '<span class="fal fa-chevron-right"><span class="screen-reader-text">' . esc_html__( 'Load Upcoming Games', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
						?>
					</button>
				</div>
			</div>
			<div id="scoreboard-widget-body">

				<?php
				foreach ( $games as $game ) {
					/**
					 * Displays the content for the scoreboard widget game.
					 *
					 * @since 2.0.0
					 *
					 * @param string $html      The current content for the scoreboard widget game.
					 * @param array  $game      Information for the current game.
					 * @return string           HTML for the content of the game.
					 */
					echo wp_kses_post( apply_filters( 'sports_bench_scoreboard_widget_game', '', $game ) );
				}
				?>

			</div>
			<?php
		}
		?>

		<?php
	}

	/**
	 * Gets the list of games to show for the scoreboard widget.
	 *
	 * @since 2.0.0
	 *
	 * @return array      The list of games to show.
	 */
	public function get_scoreboard_widget_games() {
		global $wpdb;
		$games = [];
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		if ( '1' === get_option( 'sports-bench-display-game' ) ) {
			$week     = get_option( 'sports-bench-week-number' );
			$season   = get_option( 'sports-bench-season-year' );
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_week = %d AND game_season = %s ORDER BY game_day ASC;", $week, $season );
			$games    = Database::get_results( $querystr );
			$today    = '';
			$date     = '';
		} else {
			$today      = strtotime( 'today' );
			$date       = date( 'Y-m-d', $today );
			$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) > %s ORDER BY game_day ASC;", $date );
			$games_left = Database::get_results( $querystr );
			if ( $games_left == null ) {
				$season   = '"' . get_option( 'sports-bench-season-year' ) . '"';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_season = %s ORDER BY game_day DESC LIMIT 1;", $season );
				$games    = Database::get_results( $querystr );
				if ( $games != null ) {
					$game_date = $games[ 0 ]->game_day;
					$today     = strtotime( $game_date );
					$date      = '"' . date( 'Y-m-d', $today ) . '"';
				}
			} else {
				$today    = strtotime( 'today' );
				$date     = '"' . date( 'Y-m-d', $today ) . '"';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
				$games    = Database::get_results( $querystr );
				while ( $games == null ) {
					$today    = strtotime( '+1 day', $today );
					$date     = '"' . date( 'Y-m-d', $today ) . '"';
					$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
					$games    = Database::get_results( $querystr );
				}
			}
		}

		return [ $games, $today, $date ];

	}

	/**
	 * Displays the content for the scoreboard widget game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html      The current content for the scoreboard widget game.
	 * @param array  $game      Information for the current game.
	 * @return string           HTML for the content of the game.
	 */
	public function sports_bench_do_scoreboard_widget_game( $html, $game ) {
		$away_team = new Team( (int) $game->game_away_id );
		$home_team = new Team( (int) $game->game_home_id );
		$the_game  = new Game( (int) $game->game_id );
		$status    = $game->game_status;

		if ( 'in_progress' === $status ) {
			$away_score = $game->game_current_away_score;
			$home_score = $game->game_current_home_score;
			$datetime   = '';
			if ( ( null !== $game->game_current_period && '' !== $game->game_current_period ) && null !== $game->game_current_time ) {
				$sep = ' | ';
			} else {
				$sep = '';
			}
			$period       = $game->game_current_period;
			$time         = stripslashes( $game->game_current_time );
			$time_in_game = $time . $sep . $period;
		} elseif ( 'final' === $status ) {
			$away_score   = $game->game_away_final;
			$home_score   = $game->game_home_final;
			$datetime     = '';
			$time_in_game = 'FINAL';
		} else {
			$away_score   = '';
			$home_score   = '';
			$time_in_game = '';
			$date         = date_create( $game->game_day );
			if ( true === $this->is_game_time_set( $date ) ) {
				$datetime = date_format( $date, 'g:i a, F j' );
			} else {
				$datetime = date_format( $date, 'F j' );
			}
		}

		/**
		 * Adds in styles or HTML elements before a scoreboard widget game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go before the game.
		 * @param int    $game_id        The id of the game.
		 * @param Team   $away_team      The away team for the game.
		 * @param Team   $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for before the game.
		 */
		$html .= apply_filters( 'sports_bench_before_scoreboard_widget_game', '', $game->game_id, $away_team, $home_team );

		$html .= '<div id="widget-game-' . esc_attr( $game->game_id ) . '" class="scoreboard-game">';
		$html .= '<div class="scoreboard-table">';

		/**
		 * Adds in the styles for a scoreboard row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param string $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$away_row_style = apply_filters( 'sports_bench_scoreboard_row_styles', '', $away_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $away_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $away_team->get_team_location() ) . '</div>';
		$html          .= '<div class="away-score team-score">' . esc_html( $away_score ) . '</div>';
		$html          .= '</div>';

		/**
		 * Adds in the styles for a scoreboard row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param string $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$home_row_style = apply_filters( 'sports_bench_scoreboard_row_styles', '', $home_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $home_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $home_team->get_team_location() ) . '</div>';
		$html          .= '<div class="home-score team-score">' . esc_html( $home_score ) . '</div>';
		$html          .= '</div>';
		$html          .= '<div class="game-info-row">';
		$html          .= '<div class="time">' . esc_html( $datetime . $time_in_game ) . '</div>';
		$html          .= '</div>';
		$html          .= '</div>';

		if ( ( null !== $game->game_recap && 'final' === $game->game_status ) || ( null === $game->game_preview && 'scheduled' === $game->game_status ) || ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) ) {
			$html .= '<div class="recap-section">';

			if ( null !== $game->game_recap && 'final' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_recap . '">';
				$html .= '<div>' . __( 'RECAP', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			} elseif ( null === $game->game_preview && 'scheduled' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_preview . '">';
				$html .= '<div>' . __( 'PREVIEW', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			if ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) {
				$html .= '<div class="recap-element box-score-element">';
				$html .= '<a href="' . $the_game->get_box_score_permalink() . '">';
				$html .= '<div>' . __( 'BOX SCORE', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			$html .= '</div>';
		}

		$html .= '</div>';

		/**
		 * Adds in styles or HTML elements after a scoreboard widget game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go after the game.
		 * @param int    $game_id        The id of the game.
		 * @param Team   $away_team      The away team for the game.
		 * @param Team   $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for after the game.
		 */
		$html .= apply_filters( 'sports_bench_after_scoreboard_widget_game', '', $game->game_id, $away_team, $home_team );

		return $html;
	}

	/**
	 * Loads games for the widgets for AJAX calls.
	 *
	 * @since 2.0.0
	 */
	public function widget_load_games() {
		check_ajax_referer( 'sports-bench-load-games', 'nonce' );
		$weekdate  = wp_filter_nohtml_kses( $_POST['weekdate'] );
		$current   = wp_filter_nohtml_kses( $_POST['current'] );
		$direction = wp_filter_nohtml_kses( $_POST['direction'] );

		$data  = $this->load_new_games( $weekdate, $current, $direction );
		$games = $data[0];

		$html       = '';
		$games_html = '';
		foreach ( $games as $game ) {
			$game_html = '';

			/**
			 * Displays the content for the scoreboard widget game.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html      The current content for the scoreboard widget game.
			 * @param array  $game      Information for the current game.
			 * @return string           HTML for the content of the game.
			 */
			$game_html  .= apply_filters( 'sports_bench_scoreboard_widget_game', $game_html, $game );
			$games_html .= $game_html;
		}
		$html   .= $games_html;
		$data[0] = $html;

		wp_send_json_success( $data );
		wp_die();

	}

	/**
	 * Loads a list of new games for the scoreboard.
	 *
	 * @since 2.0.0
	 *
	 * @param string $weekdate         Whether we are getting games by week or by date.
	 * @param int|string $current      The current week or date for the scoreboard.
	 * @param string $direction        Whether the left or right button was hit.
	 * @return array                   Returns an array of a list of games, the new date and the new date in SQL format.
	 */
	private function load_new_games( $weekdate, $current, $direction ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$games = [];

		if ( 'week' === $weekdate ) {
			$week = $current;
			if ( 'left' === $direction ) {
				$week--;
			} else {
				$week++;
			}
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_week = %d ORDER BY game_day ASC;", $week );
			$games    = Database::get_results( $querystr );
			if ( null === $games ) {
				return;
			}
			$the_date = esc_html__( 'Week ', 'sports-bench' ) . $week;
			$sql_date = '';
		} else {
			$today = strtotime( $current );
			if ( 'left' === $direction ) {
				$today = strtotime( '-1 day', $today );
			} else {
				$today = strtotime( '+1 day', $today );
			}
			$date     = date( 'Y-m-d', $today );
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE(game_day) = %s ORDER BY game_day ASC;", $date );
			$games    = Database::get_results( $querystr );
			while ( null === $games ) {
				if ( 'left' === $direction ) {
					$today = strtotime( '-1 day', $today );
				} else {
					$today = strtotime( '+1 day', $today );
				}
				$date     = date( 'Y-m-d', $today );
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE(game_day) = %s ORDER BY game_day ASC;", $date );
				$games    = Database::get_results( $querystr );
			}
			$sql_date = trim( trim( $date, "'" ), '"' );
			$the_date = date( 'F j, Y', $today );
		}

		return [ $games, $the_date, $sql_date ];
	}

	/**
	 * Displays the scoreboard page.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the scoreboard page.
	 */
	public function display_scoreboard_page() {
		$game_data = $this->get_scoreboard_page_games();
		$games     = $game_data[0];
		$today     = $game_data[1];
		$date      = $game_data[2];
		$html      = '';

		if ( null === $games ) {
			$html .= '<p>' . esc_html__( 'There are no games entered for the given season. Please enter a game.', 'sports-bench' ) . '</p>';
		} else {
			$html .= '<div class="sports-bench-scoreboard-date-row">';
			$html .= '<div id="scoreboard-page-left-container">';
			$html .= '<button id="scoreboard-page-left">';

			/**
			 * Displays the content for the scoreboard left button.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the button.
			 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
			 * @return string               The content for the scoreboard bar left button.
			 */
			$html .= wp_kses_post( apply_filters( 'sports_bench_scoreboard_left', '<span class="fal fa-chevron-left"><span class="screen-reader-text">' . esc_html__( 'Load Earlier Games', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
			$html .= '</button>';
			$html .= '</div>';

			$html .= '<div id="scoreboard-title">';
			if ( '1' === get_option( 'sports-bench-display-game' ) ) {
				$html .= '<h3 class="scoreboard-page-title">' . esc_html__( 'Week', 'sports-bench' ) . ' ' . esc_html( get_option( 'sports-bench-week-number' ) ) . '</h3>';
			} else {
				$html .= '<h3 class="scoreboard-page-title">' . esc_html( date( 'F j, Y', $today ) ) . '<span id="widget-hidden-date">' . esc_html( trim( trim( $date, "'" ), '"' ) ) . '</span></h3>';
			}
			$html .= '</div>';

			$html .= '<div id="scoreboard-page-right-container">';
			$html .= '<button id="scoreboard-page-right">';

			/**
			 * Displays the content for the scoreboard right button.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the button.
			 * @param string $location      Whether this filter is being called from the scoreboard bar, widget or page.
			 * @return string               The content for the scoreboard bar right button.
			 */
			$html .= wp_kses_post( apply_filters( 'sports_bench_scoreboard_right', '<span class="fal fa-chevron-right"><span class="screen-reader-text">' . esc_html__( 'Load Upcoming Games', 'sports-bench' ) . '</span></span>', 'scoreboard-bar' ) );
			$html .= '</button>';
			$html .= '</div>';
			$html .= '</div>';

			$html .= '<div id="scoreboard-page-body">';
			foreach ( $games as $game ) {

				/**
				 * Displays the content for the scoreboard game.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html      The current content for the scoreboard game.
				 * @param array  $game      Information for the current game.
				 * @return string           HTML for the content of the game.
				 */
				$html .= wp_kses_post( apply_filters( 'sports_bench_scoreboard_game', '', $game ) );
			}
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Gets a list of games for the scoreboard page,
	 *
	 * @since 2.0.0
	 *
	 * @return array      Returns an array of a list of games, the new date and the new date in SQL format.
	 */
	private function get_scoreboard_page_games() {
		global $wpdb;
		$games = [];
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';

		if ( '1' === get_option( 'sports-bench-display-game' ) ) {
			$week     = get_option( 'sports-bench-week-number' );
			$season   = get_option( 'sports-bench-season-year' );
			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_week = %d AND game_season = %s ORDER BY game_day ASC;", $week, $season );
			$games    = Database::get_results( $querystr );
			$today    = '';
			$date     = '';
		} else {
			$today      = strtotime( 'today' );
			$date       = date( 'Y-m-d', $today );
			$querystr   = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) > %s ORDER BY game_day ASC;", $date );
			$games_left = Database::get_results( $querystr );
			if ( $games_left == null ) {
				$season   = '"' . get_option( 'sports-bench-season-year' ) . '"';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE game_season = %s ORDER BY game_day DESC LIMIT 1;", $season );
				$games    = Database::get_results( $querystr );
				if ( $games != null ) {
					$game_date = $games[ 0 ]->game_day;
					$today     = strtotime( $game_date );
					$date      = '"' . date( 'Y-m-d', $today ) . '"';
				}
			} else {
				$today    = strtotime( 'today' );
				$date     = '"' . date( 'Y-m-d', $today ) . '"';
				$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
				$games    = Database::get_results( $querystr );
				while ( $games == null ) {
					$today    = strtotime( '+1 day', $today );
					$date     = '"' . date( 'Y-m-d', $today ) . '"';
					$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE DATE( game_day ) = %s ORDER BY game_day ASC;", $date );
					$games    = Database::get_results( $querystr );
				}
			}
		}

		return [ $games, $today, $date ];
	}

	/**
	 * Loads games for the widgets for AJAX calls.
	 *
	 * @since 2.0.0
	 */
	public function page_load_games() {
		check_ajax_referer( 'sports-bench-load-games', 'nonce' );
		$weekdate  = wp_filter_nohtml_kses( $_POST['weekdate'] );
		$current   = wp_filter_nohtml_kses( $_POST['current'] );
		$direction = wp_filter_nohtml_kses( $_POST['direction'] );

		$data  = $this->load_new_games( $weekdate, $current, $direction );
		$games = $data[0];

		$html       = '';
		$games_html = '';
		foreach ( $games as $game ) {
			$game_html   = '';
			$game_html  .= apply_filters( 'sports_bench_scoreboard_game', $game_html, $game );
			$games_html .= $game_html;
		}
		$html   .= $games_html;
		$data[0] = $html;

		wp_send_json_success( $data );
		wp_die();
	}

	/**
	 * Displays the content for the scoreboard game.
	 *
	 * @since 2.0.0
	 *
	 * @param string $html      The current content for the scoreboard game.
	 * @param array  $game      Information for the current game.
	 * @return string           HTML for the content of the game.
	 */
	public function sports_bench_do_scoreboard_game( $html, $game ) {
		$away_team = new Team( (int) $game->game_away_id );
		$home_team = new Team( (int) $game->game_home_id );
		$the_game  = new Game( (int) $game->game_id );
		$status    = $game->game_status;

		if ( 'in_progress' === $status ) {
			$away_score = $game->game_current_away_score;
			$home_score = $game->game_current_home_score;
			$datetime   = '';
			if ( ( null !== $game->game_current_period && '' !== $game->game_current_period ) && null !== $game->game_current_time ) {
				$sep = ' | ';
			} else {
				$sep = '';
			}
			$period       = $game->game_current_period;
			$time         = stripslashes( $game->game_current_time );
			$time_in_game = $time . $sep . $period;
		} elseif ( 'final' === $status ) {
			$away_score   = $game->game_away_final;
			$home_score   = $game->game_home_final;
			$datetime     = '';
			$time_in_game = 'FINAL';
		} else {
			$away_score   = '';
			$home_score   = '';
			$time_in_game = '';
			$date         = date_create( $game->game_day );
			if ( true === $this->is_game_time_set( $date ) ) {
				$datetime = date_format( $date, 'g:i a, F j' );
			} else {
				$datetime = date_format( $date, 'F j' );
			}
		}

		/**
		 * Adds in styles or HTML elements after a scoreboard widget game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go after the game.
		 * @param int    $game_id        The id of the game.
		 * @param int    $away_team      The away team for the game.
		 * @param int    $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for after the game.
		 */
		$html .= apply_filters( 'sports_bench_before_scoreboard_widget_game', '', $game->game_id, $away_team, $home_team );

		$html .= '<div id="game-' . esc_attr( $game->game_id ) . '" class="scoreboard-game">';
		$html .= '<div class="game-inner">';
		$html .= '<div class="scoreboard-table">';

		/**
		 * Adds in the styles for a scoreboard row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param Team   $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$away_row_style = apply_filters( 'sports_bench_scoreboard_row_styles', '', $away_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $away_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $away_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $away_team->get_team_location() ) . '</div>';
		$html          .= '<div class="away-score team-score">' . esc_html( $away_score ) . '</div>';
		$html          .= '</div>';

		/**
		 * Adds in the styles for a scoreboard row.
		 *
		 * @since 2.0.0
		 *
		 * @param string $styles      The current styles for the row.
		 * @param Team   $team        The team for the row.
		 * @return string             The styles for the row.
		 */
		$home_row_style = apply_filters( 'sports_bench_scoreboard_row_styles', '', $home_team );
		$html          .= '<div class="team team-row" style="' . esc_attr( $home_row_style ) . '">';
		$html          .= '<div class="team-logo">' . $home_team->get_team_photo( 'team-logo' ) . '</div>';
		$html          .= '<div class="team-location">' . esc_html( $home_team->get_team_location() ) . '</div>';
		$html          .= '<div class="home-score team-score">' . esc_html( $home_score ) . '</div>';
		$html          .= '</div>';
		$html          .= '<div class="game-info-row">';
		$html          .= '<div class="time">' . esc_html( $datetime . $time_in_game ) . '</div>';
		$html          .= '</div>';
		$html          .= '</div>';

		if ( $the_game->get_full_address() ) {
			$html .= '<p>' . wp_kses_post( $the_game->get_full_address() ) . '</p>';
		}

		if ( ( null !== $game->game_recap && 'final' === $game->game_status ) || ( null === $game->game_preview && 'scheduled' === $game->game_status ) || ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) ) {
			$html .= '<div class="recap-section">';

			if ( null !== $game->game_recap && 'final' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_recap . '">';
				$html .= '<div>' . __( 'RECAP', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			} elseif ( null === $game->game_preview && 'scheduled' === $game->game_status ) {
				$html .= '<div class="recap-element">';
				$html .= '<a href="' . $game->game_preview . '">';
				$html .= '<div>' . __( 'PREVIEW', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			if ( null !== get_option( 'sports-bench-box-score-page' ) && '' !== get_option( 'sports-bench-box-score-page' ) ) {
				$html .= '<div class="recap-element box-score-element">';
				$html .= '<a href="' . $the_game->get_box_score_permalink() . '">';
				$html .= '<div>' . __( 'BOX SCORE', 'sports-bench' ) . '</div>';
				$html .= '</a>';
				$html .= '</div>';
			}

			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '</div>';

		/**
		 * Adds in styles or HTML elements after a scoreboard widget game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The current HTML for what should go after the game.
		 * @param int    $game_id        The id of the game.
		 * @param int    $away_team      The away team for the game.
		 * @param int    $home_team      The home team for the game.
		 * @return string                The styles or HTML elements for after the game.
		 */
		$html .= apply_filters( 'sports_bench_after_scoreboard_widget_game', '', $game->game_id, $away_team, $home_team );

		return $html;
	}
}
