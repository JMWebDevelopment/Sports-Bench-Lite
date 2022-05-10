<?php
/**
 * Holds all of the block functions.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/blocks
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench;

use Sports_Bench\Sports_Bench_Loader;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * Runs the blocks.
 *
 * This class defines all code necessary to run the blocks for the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/blocks
 */
class Sports_Bench_Blocks {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 *
	 * @var string $version Description.
	 * @access private
	 */
	private $version;

	/**
	 * Builds the Sports_Bench_Blocks object.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Enqueues the scripts and styles needed for the blocks.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_blocks() {
		$block_path      = 'js/editor.blocks.js';
		$editor_style_path = 'css/blocks.editor.css';

		wp_enqueue_script(
			'sportsbench-blocks-js',
			plugins_url( $block_path, __FILE__ ),
			['wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api', 'wp-editor'],
			filemtime( plugin_dir_path( __FILE__ ) . 'js/editor.blocks.js' ),
			true
		);

		wp_localize_script(
			'sportsbench-blocks-js',
			'sportsbench_globals',
			[
				'rest_url'  => esc_url( rest_url() ),
				'nonce'     => wp_create_nonce( 'wp_rest' ),
				'sport'     => get_option( 'sports-bench-sport' ),
			]
		);

		wp_enqueue_style(
			'sportsbench-editor-blocks-styles',
			plugins_url( $editor_style_path, __FILE__ ),
			[],
			$this->version
		);

	}

	/**
	 * Adds in a Sports Bench blocks category.
	 *
	 * @since 2.0.0
	 *
	 * @param array $categories      The current set of block categories.
	 * @return array                 The set of block categories with the Sports Bench block category.
	 */
	public function add_block_categories( $categories ) {
		$categories[] = [
			'slug'  => 'sports-bench-blocks',
			'title' => __( 'Sports Bench', 'sports-bench' ),
		];
		return $categories;
	}

	/**
	 * Loads the callback functions to render the dynamic blocks.
	 *
	 * @since 2.0.0
	 */
	public function render_blocks() {
		register_block_type(
			'sportsbench/scoreboard',
			[
				'render_callback' => [ $this, 'render_scoreboard'],
			]
		);

		register_block_type(
			'sportsbench/list-division',
			[
				'render_callback' => [ $this, 'render_list_division'],
			]
		);

		register_block_type(
			'sportsbench/team-schedule',
			[
				'render_callback' => [ $this, 'render_team_schedule'],
			]
		);

		register_block_type(
			'sportsbench/team',
			[
				'render_callback' => [ $this, 'render_team'],
			]
		);

		register_block_type(
			'sportsbench/team-page',
			[
				'render_callback' => [ $this, 'render_team_page'],
			]
		);

		register_block_type(
			'sportsbench/player',
			[
				'render_callback' => [ $this, 'render_player'],
			]
		);

		register_block_type(
			'sportsbench/player-page',
			[
				'render_callback' => [ $this, 'render_player_page'],
			]
		);

		register_block_type(
			'sportsbench/game',
			[
				'render_callback' => [ $this, 'render_game'],
			]
		);

		register_block_type(
			'sportsbench/rivalry',
			[
				'render_callback' => [ $this, 'render_rivalry'],
			]
		);

		register_block_type(
			'sportsbench/box-score',
			[
				'render_callback' => [ $this, 'render_box_score'],
			]
		);

		register_block_type(
			'sportsbench/game-recap',
			[
				'render_callback' => [ $this, 'render_game_recap'],
			]
		);

		register_block_type(
			'sportsbench/standings',
			[
				'render_callback' => [ $this, 'render_standings'],
			]
		);

		register_block_type(
			'sportsbench/stats',
			[
				'render_callback' => [ $this, 'render_stats'],
			]
		);

		register_block_type(
			'sportsbench/stat-search',
			[
				'render_callback' => [ $this, 'render_stat_search'],
			]
		);

		register_block_type(
			'sportsbench/bracket',
			[
				'render_callback' => [ $this, 'render_bracket'],
			]
		);
	}

	/**
	 * Renders the scoreboard block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_scoreboard( $attributes ) {
		return sports_bench_scoreboard_page_template();
	}

	/**
	 * Renders the list division block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_list_division( $attributes ) {
		$division_id = $attributes['division_id'];
		$html        = '';

		$html     .= '<div class="list-division-teams">';
		$teams     = sports_bench_get_teams( true, true, $division_id );
		$num_teams = count( $teams );
		$count     = 0;

		foreach ( $teams as $team_id => $team_name ) {

			/**
			 * Displays the listing information for the team.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html           The current HTML for the filter.
			 * @param int    $team_id        The id for the team to show the listing for.
			 * @param string $team_name      The name of the team to show the listing for.
			 * @param int    $num_teams      The number of teams that are being shown.
			 * @param int    $count          The counter for the current number of iterations for the loop (minus one).
			 * @return string                HTML for the team listing.
			 */
			$html .= apply_filters( 'sports_bench_team_listing_info', '', $team_id, $team_name, $num_teams, $count );
			$count++;
		}
		$html .= '</div>';

		return $html;
	}

	/**
	 * Renders the team schedule block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_team_schedule( $attributes ) {
		$season  = $attributes['team_season'];
		$team_id = $attributes['team_id'];
		$html    = '';

		if ( $team_id > 0 ) {
			$html .= '<div class="team-schedule-block">';

			/**
			 * Adds in HTML to be shown before the team schedule widget/block.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The current HTML for the filter.
			 * @param int    $team_id      The id for the team the schedule is for.
			 * @return string              HTML to be shown before the widget/block.
			 */
			$html    .= apply_filters( 'sports_bench_before_team_schedule_widget', '', $team_id );
			$team     = new Team( (int) $team_id );
			$schedule = $team->get_schedule( $season );

			/**
			 * Displays the table for a team's schedule.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The current HTML for the filter.
			 * @param array  $schedule     The schedule to be shown for the team as an array.
			 * @param int    $team_id      The id for the team the schedule is for.
			 * @return string              The HTML for the schedule table.
			 */
			$html .= apply_filters( 'sports_bench_schedule_table', $html, $schedule, $team_id );

			/**
			 * Adds in HTML to be shown after the team schedule widget/block.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The current HTML for the filter.
			 * @param int    $team_id      The id for the team the schedule is for.
			 * @return string              HTML to be shown after the widget/block.
			 */
			$html .= apply_filters( 'sports_bench_after_team_schedule_widget', '', $team_id );
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Renders the team block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_team( $attributes ) {
		$team_id = $attributes['team_id'];
		$html    = '';

		if ( $team_id > 0 ) {
			$team   = new Team( (int) $team_id );
			$record = $team->get_record( get_option( 'sports-bench-season-year' ) );
			$html  .= '<div id="sports-bench-team-' . $team->get_team_id() . '" class="sports-bench-shortcode-team row">';

			/**
			 * Adds in HTML to be shown before the team shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The current HTML for the filter.
			 * @param Team   $team         The Team object the shortcode is for.
			 * @return string              HTML to be shown before the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_before_team_shortcode', '', $team );
			$html .= '<div class="row team-information">';

			/**
			 * Displays the information about the team for the shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html        The current HTML for the filter.
			 * @param Team   $team        The Team object the shortcode is for.
			 * @param array  $record      The record for the team.
			 * @return string             The HTML to show the information about the team.
			 */
			$html    .= apply_filters( 'sports_bench_team_shortcode_information', '', $team, $record );
			$html    .= '</div>';
			$html    .= '<div class="row team-schedules">';
			$html    .= '<div id="recent-schedule">';
			$schedule = $team->get_recent_results( 5, get_option( 'sports-bench-season-year' ) );

			/**
			 * Displays the last five game results for the team.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param Team   $team          The Team object the shortcode is for.
			 * @param array  $schedule      The array of recent games for the team.
			 * @return string               The HTML to show the recent games for the team.
			 */
			$html    .= apply_filters( 'sports_bench_team_shortcode_recent_games', '', $team, $schedule );
			$html    .= '</div>';
			$html    .= '<div id="upcoming-schedule">';
			$schedule = $team->get_upcoming_schedule( 5, get_option( 'sports-bench-season-year' ) );

			/**
			 * Displays the next five games for the team.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param Team   $team          The Team object the shortcode is for.
			 * @param array  $schedule      The array of upcoming games for the team.
			 * @return string               The HTML to show the upcoming games for the team.
			 */
			$html .= apply_filters( 'sports_bench_team_shortcode_upcoming_games', '', $team, $schedule );
			$html .= '</div>';
			$html .= '</div>';

			/**
			 * Adds in HTML to be shown after the team shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html         The current HTML for the filter.
			 * @param Team   $team         The Team object the shortcode is for.
			 * @return string              HTML to be shown after the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_after_team_shortcode', '', $team );
			$html .= '</div>';
		}
		return $html;
	}

	/**
	 * Renders the team page block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_team_page( $attributes ) {
		return sports_bench_teams_page_template();
	}

	/**
	 * Renders the player block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_player( $attributes ) {
		$player_id = $attributes['player_id'];
		$html      = '';

		if ( $player_id > 0 ) {
			$player = new Player( (int) $player_id );
			$html  .= '<div id="sports-bench-player-' . $player->get_player_id() . '" class="sports-bench-player-shortcode">';

			/**
			 * Adds in HTML to be shown before the player shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html           The current HTML for the filter.
			 * @param Player $player         The Player object the shortcode is for.
			 * @return string                HTML to be shown before the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_before_player_shortcode', '', $player );
			$html .= '<div id="sports-bench-player-id">' . $player->get_player_id() . '</div>';

			/**
			 * Displays the information about the player for the shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param Player $player        The Player object the shortcode is for.
			 * @param int    $team_id       The current team id of the team the player plays for.
			 * @return string               The HTML to show the information about the player.
			 */
			$html .= apply_filters( 'sports_bench_player_shortcode_information', '', $player, $player->get_team_id() );
			$html .= '<div class="career-stats">';
			$html .= sports_bench_get_season_stats( $player );
			$html .= '</div>';

			/**
			 * Adds in HTML to be shown after the player shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html           The current HTML for the filter.
			 * @param Player $player         The Player object the shortcode is for.
			 * @return string                HTML to be shown after the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_after_player_shortcode', '', $player );
			$html .= '</div>';
		}

		return $html;

	}

	/**
	 * Renders the player page block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_player_page( $attributes ) {
		$html = '';

		if ( get_query_var( 'player_slug' ) ) {
			$player = new Player( get_query_var( 'player_slug' ) );
			$team   = new Team( (int) $player->get_team_id() );

			$html .= '<div class="sports-bench-player-page">';
			$html .= '<div id="player-info" class="player-section clearfix">';
			$html .= '<h2 class="player-section-title">' . esc_html__( 'Player Information', 'sports-bench' ) . '</h2>';
			$html .= sports_bench_show_player_info( $player->get_player_id() );
			$html .= '</div>';

			/**
			 * Adds in HTML to be shown before the player stats.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html           The current HTML for the filter.
			 * @param Player $player         The Player object the stats are for.
			 * @return string                HTML to be shown before the stats.
			 */
			$html .= apply_filters( 'sports_bench_before_player_stats', '', $team );
			$html .= '<div id="player-stats" class="player-section">';
			$html .= '<h3 class="player-section-title">' . esc_html__( 'Career Stats', 'sports-bench' ) . '</h3>';
			$html .= sports_bench_get_season_stats( $player );
			$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_stats_abbreviation_guide() . '</p>';
			$html .= '</div>';

			/**
			 * Adds in HTML to be shown after the player stats.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html           The current HTML for the filter.
			 * @param Player $player         The Player object the stats are for.
			 * @return string                HTML to be shown after the stats.
			 */
			$html .= apply_filters( 'sports_bench_after_player_stats', '', $team );
			$html .= '</div>';
		} else {
			$html .= sports_bench_show_team_player_select();
		}

		return $html;

	}

	/**
	 * Renders the game block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_game( $attributes ) {
		$game_id = $attributes['game_id'];

		$html = '';

		if ( $game_id > 0 ) {
			$game      = new Game( (int) $game_id );
			$away_team = new Team( (int) $game->get_game_away_id() );
			$home_team = new Team( (int) $game->get_game_home_id() );
			if ( 'final' !== $game->get_game_status() ) {
				$away_score = '';
				$home_score = '';
				$time       = $game->get_game_day( get_option( 'time_format' ) );
				$time_class = 'scheduled';
				$period     = $game->get_game_day( get_option( 'date_format' ) );
				$location   = $game->get_game_location_stadium() . ', ' . $game->get_game_location_city() . ', ' . $game->get_game_location_state();
			} else {
				$away_score = $game->get_game_away_final();
				$home_score = $game->get_game_home_final();
				$time       = $game->get_game_day( get_option( 'date_format' ) ) . ' &mdash; ' . esc_html__( 'FINAL', 'sports-bench' );
				$time_class = '';
				$period     = '';
				$location   = $game->get_game_location_stadium() . ', ' . $game->get_game_location_city() . ', ' . $game->get_game_location_state();
			}
			if ( null !== $away_team->get_team_nickname() ) {
				$away_team_name = '<span class="team-location">' . $away_team->get_team_location() . '</span><br /><span class="team-nickname">' . $away_team->get_team_nickname() . '</span>';
			} else {
				$away_team_name = $away_team->get_team_location();
			}
			if ( null !== $home_team->get_team_nickname() ) {
				$home_team_name = '<span class="team-location">' . $home_team->get_team_location() . '</span><br /><span class="team-nickname">' . $home_team->get_team_nickname() . '</span>';
			} else {
				$home_team_name = $home_team->get_team_location();
			}
			$time_in_game = '<span class="time">' . $time . '</span><br /><span class="period">' . $period . '</span>';

			$html .= '<div id="sports-bench-game-' . $game->get_game_id() . '" class="sports-bench-shortcode-game row sports-bench-row">';

			/**
			 * Adds in HTML to be shown before the game shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the filter.
			 * @param int    $game_id         The Player object the stats are for.
			 * @param Team   $away_team       The team object for the away team.
			 * @param Team   $home_team       The team object for the home team.
			 * @return string                 HTML to be shown before the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_before_game_shortcode', '', $game->get_game_id(), $away_team, $home_team );

			/**
			 * Displays the information about a game.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html                The current HTML for the filter.
			 * @param Game   $game                The Game object for the game shortcode.
			 * @param Team   $away_team           The team object for the away team.
			 * @param string $away_team_name      The name of the away team.
			 * @param int    $away_score          The score for the away team.
			 * @param Team   $home_team           The team object for the home team.
			 * @param string $home_team_name      The name of the home team.
			 * @param int    $home_score          The score for the home team.
			 * @param string $time_in_game        The current time of the game (or "FINAL" if the game is over).
			 * @param string $location            The location of the game.
			 * @return string                     The HTML to show the information about the game.
			 */
			$html .= apply_filters( 'sports_bench_game_shortcode_info', '', $game, $away_team, $away_team_name, $away_score, $home_team, $home_team_name, $home_score, $time_in_game, $location );

			/**
			 * Adds in HTML to be shown after the game shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html            The current HTML for the filter.
			 * @param int    $game_id         The Player object the stats are for.
			 * @param Team   $away_team       The team object for the away team.
			 * @param Team   $home_team       The team object for the home team.
			 * @return string                 HTML to be shown after the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_after_game_shortcode', '', $game->get_game_id(), $away_team, $home_team );
			$html .= '</div>';

		}

		return $html;
	}

	/**
	 * Renders the rivalry block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_rivalry( $attributes ) {
		$team_one_id = $attributes['team_one_id'];
		$team_two_id = $attributes['team_two_id'];

		$html = '';

		if ( isset( $attributes['recent_games'] ) ) {
			$recent_games = $attributes['recent_games'];
		} else {
			$recent_games = 5;
		}

		if ( 0 !== $team_one_id && 0 !== $team_two_id ) {
			$team_one = new Team( (int) $team_one_id );
			$team_two = new Team( (int) $team_two_id );
			if ( null !== $team_one->get_team_nickname() ) {
				$team_one_name = '<span class="team-location">' . $team_one->get_team_location() . '</span><br /><span class="team-nickname">' . $team_one->get_team_nickname() . '</span>';
			} else {
				$team_one_name = $team_one->get_team_location();
			}
			if ( null !== $team_two->get_team_nickname() ) {
				$team_two_name = '<span class="team-location">' . $team_two->get_team_location() . '</span><br /><span class="team-nickname">' . $team_two->get_team_nickname() . '</span>';
			} else {
				$team_two_name = $team_two->get_team_location();
			}

			global $wpdb;
			$table         = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
			$querystr      = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_home_id = %d AND game_away_id = %d ) OR ( game_home_id = %d AND game_away_id = %d ) LIMIT %d", $team_one_id, $team_two_id, $team_two_id, $team_one_id, $recent_games );
			$games         = Database::get_results( $querystr );
			$team_one_wins = 0;
			$team_two_wins = 0;
			$draws         = 0;
			foreach ( $games as $game ) {
				$the_game = new Game( $game->game_id );
				if ( $the_game->get_game_away_final() > $the_game->get_game_home_final() ) {
					if ( $the_game->get_game_away_id() === $team_one_id ) {
						$team_one_wins++;
					} else {
						$team_two_wins++;
					}
				} elseif ( $the_game->get_game_home_final() > $the_game->get_game_away_final() ) {
					if ( $the_game->get_game_home_id() === $team_one_id ) {
						$team_one_wins++;
					} else {
						$team_two_wins++;
					}
				} else {
					$draws++;
				}
			}
			if ( $team_one_wins > $team_two_wins ) {
				$series_score = $team_one->team_name . ' ' . esc_html__( 'lead the all-time series', 'sports-bench' ) . ' ' . $team_one_wins . '-' . $team_two_wins . '-' . $draws;
			} elseif ( $team_two_wins > $team_one_wins ) {
				$series_score = $team_two->team_name . ' ' . esc_html__( 'lead the all-time series', 'sports-bench' ) . ' ' . $team_two_wins . '-' . $team_one_wins . '-' . $draws;
			} else {
				$series_score = esc_html__( 'The all-time series is tied', 'sports-bench' ) . ' ' . $team_one_wins . '-' . $team_two_wins . '-' . $draws;
			}

			$querystr = $wpdb->prepare( "SELECT * FROM $table WHERE ( game_home_id = %d AND game_away_id = %d ) OR ( game_home_id = %d AND game_away_id = %d ) AND game_status = 'final' ORDER BY game_day DESC LIMIT %d", $team_one_id, $team_two_id, $team_two_id, $team_one_id, $recent_games );
			$games    = Database::get_results( $querystr );

			$html .= '<div class="sports-bench-rivalry row sports-bench-row">';

			/**
			 * Adds in HTML to be shown before the rivalry shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param int    $game          The first Game object of the rivalry.
			 * @param Team   $team_one      The team object for the first team.
			 * @param Team   $team_two      The team object for the second team.
			 * @return string               HTML to be shown before the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_before_rivalry_shortcode', '', $games[0], $team_one, $team_two );

			/**
			 * Displays the information about the rivalry between the two teams.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html               The current HTML for the filter.
			 * @param int    $game               The first Game object of the rivalry.
			 * @param Team   $team_one           The team object for the first team.
			 * @param string $team_one_name      The name fof the first team.
			 * @param Team   $team_two           The team object for the second team.
			 * @param string $team_two_name      The name fof the second team.
			 * @param string $series_score       The score of the series between the two teams.
			 * @return string                    HTML for the rivalry information.
			 */
			$html .= apply_filters( 'sports_bench_rivalry_shortcode_info', '', $games[0], $team_one, $team_one_name, $team_two, $team_two_name, $series_score );

			/**
			 * Displays the most recent games between the two teams.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param array  $games         The list of games between the teams.
			 * @param Team   $team_one      The team object for the first team.
			 * @param Team   $team_two      The team object for the second team.
			 * @return string               HTML for the recent games table.
			 */
			$html .= apply_filters( 'sports_bench_rivalry_shortcode_recent_game', '', $games, $team_one, $team_two );

			/**
			 * Adds in HTML to be shown after the rivalry shortcode.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html          The current HTML for the filter.
			 * @param int    $game          The first Game object of the rivalry.
			 * @param Team   $team_one      The team object for the first team.
			 * @param Team   $team_two      The team object for the second team.
			 * @return string               HTML to be shown after the shortcode.
			 */
			$html .= apply_filters( 'sports_bench_after_rivalry_shortcode', '', $games[0], $team_one, $team_two );
			$html .= '</div>';
		}

		return $html;

	}

	/**
	 * Renders the box score block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_box_score( $attributes ) {
		$html  = '';
		$html .= sports_bench_display_game_box_score();

		return $html;
	}

	/**
	 * Renders the game recap block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_game_recap( $attributes ) {
		$game_id = $attributes['game_id'];

		$html = '';

		if ( $game_id > 0 ) {
			$game = new Game( $game_id );
			if ( 'final' === $game->get_game_status() ) {
				$home_team = new Team( (int) $game->get_game_home_id() );
				$away_team = new Team( (int) $game->get_game_away_id() );
				$html      = '';

				$html .= '<div class="game-box-score">';

				$html .= sports_bench_game_box_score_game_info( $game, $home_team, $away_team );
				$html .= sports_bench_game_box_score_team_stats( $game, $home_team, $away_team );
				$html .= sports_bench_game_box_score_away_team_stats( $game, $away_team );
				$html .= sports_bench_game_box_score_home_team_stats( $game, $home_team );

				$html .= '</div>';
			}
		}

		return $html;
	}

	/**
	 * Renders the team standings block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_standings( $attributes ) {
		$standings = [];
		foreach ( $attributes['standings'] as $standing_attribute ) {
			array_push( $standings, $standing_attribute['value'] );
		}
		$html = '';

		$html .= '<div id="sports-bench-standings">';
		$html .= '<ul aria-controls="sports-bench-standings" role="tablist">';
		if ( in_array( 'sports_bench_standings_league', $standings ) ) {
			$html .= '<li role="tab" aria-controls="league-tab" tabindex="0" aria-selected="true">' . apply_filters( 'sports_bench_league_name', esc_html__( 'League', 'sports-bench' ) ) . '</li>';
		}
		if ( in_array( 'sports_bench_standings_conference', $standings ) ) {
			if ( ! in_array( 'sports_bench_standings_league', $standings ) ) {
				$conference_tab_bool = 'true';
			} else {
				$conference_tab_bool = 'false';
			}
			$html .= '<li role="tab" aria-controls="conference-tab" tabindex="0" aria-selected="' . esc_attr( $conference_tab_bool ) . '">' . apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . '</li>';
		}
		if ( in_array( 'sports_bench_standings_division', $standings ) ) {
			if ( ! in_array( 'sports_bench_standings_league', $standings ) && ! in_array( 'sports_bench_standings_conference', $standings ) ) {
				$division_tab_bool = 'true';
			} else {
				$division_tab_bool = 'false';
			}
			$html .= '<li role="tab" aria-controls="division-tab" tabindex="0" aria-selected="' . esc_attr( $division_tab_bool ) . '">' . apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . '</a></li>';
		}
		$html .= '</ul>';
		$html .= '<div class="tabs-container">';
		if ( in_array( 'sports_bench_standings_league', $standings ) ) {
			$html .= '<div id="league-tab" class="tabs-content" role="tabpanel" aria-expanded="true">';

			/**
			 * Adds in HTML to be shown before the standings container.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The current HTML for the filter.
			 * @param string $type             The type of standing that is being shown.
			 * @param int    $division_id      The id of the division or conference being shown that is being shown.
			 * @return string                  HTML to be shown before the container.
			 */
			$html .= apply_filters( 'sports_bench_before_standings_container', '', 'all', 0 );
			$html .= '<div class="standings-container">';
			$html .= sports_bench_all_team_standings();
			$html .= '</div>';

			/**
			 * Adds in HTML to be shown after the standings container.
			 *
			 * @since 2.0.0
			 *
			 * @param string $html             The current HTML for the filter.
			 * @param string $type             The type of standing that is being shown.
			 * @param int    $division_id      The id of the division or conference being shown that is being shown.
			 * @return string                  HTML to be shown after the container.
			 */
			$html .= apply_filters( 'sports_bench_after_standings_container', '', 'all', 0 );
			$html .= '</div>';
		}
		if ( in_array( 'sports_bench_standings_conference', $standings ) ) {
			if ( ! in_array( 'sports_bench_standings_league', $standings ) ) {
				$conference_tab_bool = 'true';
			} else {
				$conference_tab_bool = 'false';
			}
			$html .= '<div id="conference-tab" class="tabs-content" role="tabpanel" aria-expanded="' . esc_attr( $conference_tab_bool ) . '">';
			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr    = "SELECT * FROM $table WHERE division_conference = 'Conference';";
			$conferences = Database::get_results( $querystr );
			foreach ( $conferences as $conference ) {

				/**
				 * Adds in HTML to be shown before the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the container.
				 */
				$html .= apply_filters( 'sports_bench_before_standings_container', '', 'conference', $conference->division_id );
				$html .= '<div class="standings-container">';
				$html .= sports_bench_conference_division_standings( $conference->division_id );
				$html .= '</div>';

				/**
				 * Adds in HTML to be shown after the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown after the container.
				 */
				$html .= apply_filters( 'sports_bench_after_standings_container', '', 'conference', $conference->division_id );
			}
			$html .= '</div>';
		}
		if ( in_array( 'sports_bench_standings_division', $standings ) ) {
			if ( ! in_array( 'sports_bench_standings_league', $standings ) && ! in_array( 'sports_bench_standings_conference', $standings ) ) {
				$division_tab_bool = 'true';
			} else {
				$division_tab_bool = 'false';
			}
			$html .= '<div id="division-tab" class="tabs-content" role="tabpanel" aria-expanded="' . esc_attr( $division_tab_bool ) . '">';
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
					$html      .= '<h3 class="conference-name">' . $division->conference_name . '</h3>';
					$conference = $division->conference_name;
				}

				/**
				 * Adds in HTML to be shown before the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown before the container.
				 */
				$html .= apply_filters( 'sports_bench_before_standings_container', '', 'division', $division->division_id );
				$html .= '<div class="standings-container">';
				$html .= sports_bench_conference_division_standings( $division->division_id );
				$html .= '</div>';

				/**
				 * Adds in HTML to be shown after the standings container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html             The current HTML for the filter.
				 * @param string $type             The type of standing that is being shown.
				 * @param int    $division_id      The id of the division or conference being shown that is being shown.
				 * @return string                  HTML to be shown after the container.
				 */
				$html .= apply_filters( 'sports_bench_after_standings_container', '', 'division', $division->division_id );
			}
			$html .= '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Renders the stats block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_stats( $attributes ) {
		$stats = [];
		foreach ( $attributes[ 'items' ] as $attribute ) {
			$item = array(
				'sports_bench_stats' => $attribute['value'],
			);
			array_push( $stats, $item );
		}

		$html = '';

		if ( $stats ) {
			$html .= '<div class="sports-bench-stats">';
			foreach ( $stats as $stat ) {

				/**
				 * Adds in HTML to be shown before the stat container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html          The current HTML for the filter.
				 * @param string $stat          The stat that is being shown.
				 * @return string               HTML to be shown before the container.
				 */
				$html .= apply_filters( 'sports_bench_before_stat', '', $stat['sports_bench_stats'] );
				$html .= '<div class="stat-container">';
				$html .= '<div id="' . $stat['sports_bench_stats'] . '-stat" class="stat-div sports-bench-stat">';
				$html .= '<h2>' . sports_bench_get_stat_title( $stat['sports_bench_stats'] ) . '</h2>';
				$html .= sports_bench_get_stats_leaders( $stat['sports_bench_stats'], get_option( 'sports-bench-season-year' ) );
				$html .= '</div>';
				$html .= '</div>';

				/**
				 * Adds in HTML to be shown after the stat container.
				 *
				 * @since 2.0.0
				 *
				 * @param string $html          The current HTML for the filter.
				 * @param string $stat          The stat that is being shown.
				 * @return string               HTML to be shown after the container.
				 */
				$html .= apply_filters( 'sports_bench_after_stat', '', $stat['sports_bench_stats'] );
			}
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Renders the stat search block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_stat_search( $attributes ) {
		return sports_bench_stat_search_page();
	}

	/**
	 * Renders the playoff bracket block.
	 *
	 * @since 2.0.0
	 *
	 * @param array $attributes      The attributes for the block.
	 * @return string                The HTML for the block.
	 */
	public function render_bracket( $attributes ) {
		$bracket_id = $attributes['bracket_id'];
		$html       = '';

		if ( $bracket_id > 0 ) {
			$html = sports_bench_show_playoff_bracket( $bracket_id );
		}

		return $html;
	}

}
