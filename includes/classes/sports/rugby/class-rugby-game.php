<?php
/**
 * Creates the rugby game class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Sports\Rugby;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;

/**
 * The rugby game class.
 *
 * This is used for rugby game functionality in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/sports/rugby
 */
class RugbyGame extends Game {

	/**
	 * Creates the new RugbyGame object to be used.
	 *
	 * @since 2.0.0
	 *
	 * @param int $game_id      The id of the game player create the object for.
	 */
	public function __construct( $game_id ) {
		parent::__construct( $game_id );
	}

	/**
	 * Displays the linescore for the game.
	 *
	 * @since 2.0.0
	 *
	 * @return string       The HTML to display the linescore.
	 */
	public function get_linescore_display() {
		$linescore_array = '';
		$away_team       = new Team( (int) $this->game_away_id );
		$home_team       = new Team( (int) $this->game_home_id );
		global $wpdb;
		$table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'games';
		$querystr  = $wpdb->prepare( "SELECT * FROM $table WHERE game_id = %d;", $this->game_id );
		$game_info = Database::get_results( $querystr );

		/**
		 * Creates the linescore table for the game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html                      The incoming HTML for the table.
		 * @param Game   $game                      The game object.
		 * @param Team   $away_team                 The team object for the away team.
		 * @param Team   $home_team                 The team object for the home team.
		 * @param string $sport                     The sport the linescore is for.
		 * @param array  $game_info                 The array of information for a game.
		 * @param array|null  $linescore_array      The array for the linescore if it's baseball. It's null if not baseball.
		 * @return string                           The HTML for the linescore table.
		 */
		$html = apply_filters( 'sports_bench_game_linescore', '', $this, $away_team, $home_team, 'rugby', $game_info, $linescore_array );
		return $html;
	}

	/**
	 * Displays the individual stats for a game for the away team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual stats.
	 */
	public function game_box_score_away_team_stats() {
		$html      = '';
		$away_team = new Team( (int) $this->game_away_id );

		$html .= '<div id="away-stats" class="box-score-section">';
		$html .= '<h2><a href="' . $away_team->get_permalink() . '">' . $away_team->get_team_name() . '</a></h2>';
		$html .= $this->get_away_individual_stats();
		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_recap_abbreviation_guide() . '</p>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the individual stats table for a game for the away team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual stats table.
	 */
	public function get_away_individual_stats() {
		$team = new Team( (int) $this->game_away_id );
		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$querystr         = $wpdb->prepare( "SELECT * FROM $game_stats_table AS GAMESTATS INNER JOIN $player_table AS PLAYERS ON PLAYERS.player_id = GAMESTATS.game_player_id WHERE GAMESTATS.game_id = %d AND GAMESTATS.game_team_id = %d;", $this->game_id, $team->get_team_id() );
		$stats            = Database::get_results( $querystr );

		/**
		 * Displays the individual stats table for a team in a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML for the table.
		 * @param array  $stats          The array of stats to show.
		 * @param Team   $team           The team ojbect.
		 * @param string $team_type      Whether this is the home or away team.
		 * @param string $sport          The sport the website is using.
		 * @return string                The HTML for the individual stats section.
		 */
		$html = apply_filters( 'sports_bench_individual_game_stats', '', $stats, $team, 'away', 'rugby' );
		return $html;
	}

	/**
	 * Displays the individual stats for a game for the home team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away home individual stats.
	 */
	public function game_box_score_home_team_stats() {
		$html      = '';
		$home_team = new Team( (int) $this->game_home_id );

		$html .= '<div id="away-stats" class="box-score-section">';
		$html .= '<h2><a href="' . $home_team->get_permalink() . '">' . $home_team->get_team_name() . '</a></h2>';
		$html .= $this->get_home_individual_stats();
		$html .= '<p class="sports-bench-abbreviations">' . sports_bench_show_recap_abbreviation_guide() . '</p>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Displays the individual stats table for a game for the home team.
	 *
	 * @since 2.0.0
	 *
	 * @return string      The HTML for the away team individual home table.
	 */
	public function get_home_individual_stats() {
		$team = new Team( (int) $this->game_home_id );
		global $wpdb;
		$game_stats_table = SPORTS_BENCH_LITE_TABLE_PREFIX . 'game_stats';
		$player_table     = SPORTS_BENCH_LITE_TABLE_PREFIX . 'players';
		$querystr         = $wpdb->prepare( "SELECT * FROM $game_stats_table AS GAMESTATS INNER JOIN $player_table AS PLAYERS ON PLAYERS.player_id = GAMESTATS.game_player_id WHERE GAMESTATS.game_id = %d AND GAMESTATS.game_team_id = %d;", $this->game_id, $team->get_team_id() );
		$stats            = Database::get_results( $querystr );

		/**
		 * Displays the individual stats table for a team in a game.
		 *
		 * @since 2.0.0
		 *
		 * @param string $html           The incoming HTML for the table.
		 * @param array  $stats          The array of stats to show.
		 * @param Team   $team           The team ojbect.
		 * @param string $team_type      Whether this is the home or away team.
		 * @param string $sport          The sport the website is using.
		 * @return string                The HTML for the individual stats section.
		 */
		$html = apply_filters( 'sports_bench_individual_game_stats', '', $stats, $team, 'home', 'rugby' );
		return $html;
	}

}
