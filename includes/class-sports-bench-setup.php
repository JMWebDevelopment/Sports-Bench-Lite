<?php
/**
 * Add in extra functionality like custom post types or taxonomies.
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.0.3
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench;

use Sports_Bench\Sports_Bench_Plugin_Updater;

/**
 * Add in extra functionality like custom post types or taxonomies.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 */
class Sports_Bench_Setup {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 *
	 * @var string $version Description.
	 */
	private $version;


	/**
	 * Builds the Sports_Bench_Setup object.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Adds in custom taxonomies for teams and players.
	 *
	 * @since 2.0.0
	 */
	public function custom_taxonomies() {
		$team_args = [
			'label'        => esc_html__( 'Teams', 'sports-bench' ),
			'hierarchical' => true,
			'capabilities' => [
				'assign_terms' => 'edit_posts',
				'edit_terms'   => 'administrator',
			],
			'show_in_rest' => true,
		];
		register_taxonomy( 'sports-bench-post-teams', 'post', $team_args );

		$player_args = [
			'label'        => esc_html__( 'Players', 'sports-bench' ),
			'hierarchical' => true,
			'capabilities' => [
				'assign_terms' => 'edit_posts',
				'edit_terms'   => 'administrator',
			],
			'show_in_rest' => true,
		];
		register_taxonomy( 'sports-bench-post-players', 'post', $player_args );

		if ( 1 === empty( get_terms( [ 'taxonomy' => 'sports-bench-post-teams' ] ) ) ) {
			$this->add_teams_to_tax();
		}

		if ( 1 === empty( get_terms( [ 'taxonomy' => 'sports-bench-post-players' ] ) ) ) {
			$this->add_players_to_tax();
		}
	}

	/**
	 * Adds teams that aren't in the team taxonomy to the taxonomy.
	 *
	 * @since 2.0.0
	 */
	public function add_teams_to_tax() {
		$teams = sports_bench_get_teams();
		foreach ( $teams as $key => $label ) {
			$the_team = new Team( (int) $key );
			wp_insert_term(
				$the_team->get_team_name(),
				'sports-bench-post-teams',
				[
					'slug' => $the_team->get_team_slug(),
				]
			);
		}
	}

	/**
	 * Adds players that aren't in the player taxonomy to the taxonomy.
	 *
	 * @since 2.0.0
	 */
	public function add_players_to_tax() {
		$players = sports_bench_get_players();
		foreach ( $players as $key => $label ) {
			$the_player = new Player( (int) $key );
			wp_insert_term(
				$the_player->get_player_first_name() . ' ' . $the_player->get_player_last_name(),
				'sports-bench-post-players',
				[
					'slug' => $the_player->get_player_slug(),
				]
			);
		}
	}

	/**
	 * Adds the basic Sports Bench Information meta box for posts.
	 *
	 * @since 2.0.0
	 */
	public function add_meta_box() {
		add_meta_box( 'sports-bench-meta', esc_html__( 'Sports Bench Information', 'sports-bench' ), [ $this, 'create_meta_box' ], 'post', 'side', 'default' );
	}

	/**
	 * Creates the basic Sports Bench Information meta box for posts.
	 *
	 * @since 2.0.0
	 */
	public function create_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/posts/post-meta-box.php';
	}

	/**
	 * Saves the basic Sports Bench Information meta box for posts.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id      The ID for the post of the meta box data being saved.
	 */
	public function save_meta_box( $post_id ) {
		global $wpdb;

		$seasons      = [];
		$seasons['']  = esc_html__( 'Select a Season', 'sports-bench' );
		$table_name   = $wpdb->prefix . 'sb_games';
		$seasons_list = $wpdb->get_results( $wpdb->prepare( 'SELECT DISTINCT game_season FROM %s', $table_name ) );
		foreach ( $seasons_list as $season ) {
			$seasons[ $season->game_season ] = $season->game_season;
		}

		$games      = [];
		$games['']  = esc_html__( 'Select a Game', 'sports-bench' );
		$table_name = $wpdb->prefix . 'sb_games';
		$games_list = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %s ORDER BY game_day DESC;', $table_name ) );
		foreach ( $games_list as $game ) {
			$away_team               = new Sports_Bench_Team( (int) $game->game_away_id );
			$home_team               = new Sports_Bench_Team( (int) $game->game_home_id );
			$date                    = new DateTime( $game->game_day );
			$game_date               = date_format( $date, 'F j, Y' );
			$games[ $game->game_id ] = $game_date . ': ' . $away_team->team_name . ' at ' . $home_team->team_name;
		}

		$old_link = get_post_meta( $post_id, 'sports_bench_game', true );

		// Check if this is an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the nonce to make sure it's set and that it is correct.
		if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'sports_bench_nonce' ) ) {
			return;
		}

		// Save the post credit.
		if ( isset( $_POST['sports_bench_photo_credit'] ) ) {
			update_post_meta( $post_id, 'sports_bench_photo_credit', wp_filter_nohtml_kses( $_POST['sports_bench_photo_credit'] ) );
		}

		// Save the video.
		if ( isset( $_POST['sports_bench_video'] ) ) {
			update_post_meta( $post_id, 'sports_bench_video', wp_filter_nohtml_kses( $_POST['sports_bench_video'] ) );
		}

		// Save the none-preview-recap option.
		if ( isset( $_POST['sports_bench_game_preview_recap'] ) ) {
			update_post_meta( $post_id, 'sports_bench_game_preview_recap', wp_filter_nohtml_kses( $_POST['sports_bench_game_preview_recap'] ) );
		}

		// Save the game this post is related to.
		if ( isset( $_POST['sports_bench_game_preview_recap'] ) && 'preview' === $_POST['sports_bench_game_preview_recap'] ) {

			if ( isset( $_POST['sports_bench_game'] ) && array_key_exists( $_POST['sports_bench_game'], $games ) ) {

				if ( isset( $old_link ) ) {
					$table                     = $wpdb->prefix . 'games';
					$post_link['game_preview'] = '';
					$wpdb->update( $table, [ 'game_preview' => '' ], [ 'game_id' => $old_link ] );
				}

				update_post_meta( $post_id, 'sports_bench_game', wp_filter_nohtml_kses( $_POST['sports_bench_game'] ) );
				$post_link                 = get_permalink( $post_id );
				$table                     = $wpdb->prefix . 'sb_games';
				$post_link['game_preview'] = $post_link;
				$game_id                   = wp_filter_nohtml_kses( $_POST['sports_bench_game'] );
				$wpdb->update( $table, $post_link, [ 'game_id' => $game_id ] );
			}
		} elseif ( isset( $_POST['sports_bench_game_preview_recap'] ) && 'recap' === $_POST['sports_bench_game_preview_recap'] ) {
			if ( isset( $_POST['sports_bench_game'] ) && array_key_exists( $_POST['sports_bench_game'], $games ) ) {

				if ( isset( $old_link ) ) {
					$table                   = $wpdb->prefix . 'sb_games';
					$post_link['game_recap'] = '';
					$wpdb->update( $table, [ 'game_recap' => '' ], [ 'game_id' => $old_link ] );
				}

				update_post_meta( $post_id, 'sports_bench_game', wp_filter_nohtml_kses( $_POST['sports_bench_game'] ) );
				$post_link               = get_permalink( $post_id );
				$table                   = $wpdb->prefix . 'sb_games';
				$post_link['game_recap'] = $post_link;
				$game_id                 = wp_filter_nohtml_kses( $_POST['sports_bench_game'] );
				$wpdb->update( $table, $post_link, [ 'game_id' => $game_id ] );
			}
		}
	}

	/**
	 * Loads the games in a season based on a selected year.
	 *
	 * @since 2.0.0
	 */
	public function load_season_games() {
		global $wpdb;
		check_ajax_referer( 'sports-bench-load-season-games', 'nonce' );
		$season = wp_filter_nohtml_kses( $_POST['season'] );
		$season = '"' . $season . '"';

		$games      = [];
		$games['']  = esc_html__( 'Select a Game', 'sports-bench' );
		$table_name = $wpdb->prefix . 'sb_games';
		$games_list = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %s WHERE game_season = %s ORDER BY game_day DESC;', $table_name, $season ) );
		foreach ( $games_list as $game ) {
			$away_team               = new Sports_Bench_Team( (int) $game->game_away_id );
			$home_team               = new Sports_Bench_Team( (int) $game->game_home_id );
			$date                    = new DateTime( $game->game_day );
			$game_date               = date_format( $date, 'F j, Y' );
			$games[ $game->game_id ] = $game_date . ': ' . $away_team->team_name . ' at ' . $home_team->team_name;
		}

		ob_start();

		foreach ( $games as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
		}

		$data = ob_get_clean();
		wp_send_json_success( $data );
		wp_die();
	}

	/**
	 * Loads in the JavaScript to load the games for a selected year.
	 *
	 * @since 2.0.0
	 */
	public function load_season_games_js() {
		global $pagenow;
		global $post;

		$args = array(
			'nonce' => wp_create_nonce( 'sports-bench-load-season-games' ),
			'url'   => admin_url( 'admin-ajax.php' ),
		);

		if ( ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && ( ( 'page' === $post->post_type ) || ( 'post' === $post->post_type ) ) ) {

			wp_enqueue_script( 'sports-bench-load-season-games', plugin_dir_url( __FILE__ ) . 'js/post-custom-fields.min.js', [], $this->version, 'all' );
			wp_localize_script( 'sports-bench-load-season-games', 'sbloadseasongames', $args );

		}

	}

}
