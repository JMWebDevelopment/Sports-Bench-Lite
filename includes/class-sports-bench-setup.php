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
				$game_id                   = $_POST['sports_bench_game'];
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
				$game_id                 = $_POST['sports_bench_game'];
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
		$season = $_POST['season'];
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

	/**
	 * Initialize the updater. Hooked into `init` to work with the
	 * wp_version_check cron job, which allows auto-updates.
	 *
	 * @since 2.0.0
	 */
	public function plugin_updater() {

		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
		if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
			return;
		}

		// Retrieve our license key from the DB.
		$license_key = trim( get_option( 'sports_bench_plugin_license_key' ) );

		// Setup the updater.
		$edd_updater = new Sports_Bench_Plugin_Updater(
			SPORTS_BENCH_PLUGIN_STORE_URL,
			SPORTS_BENCH_PLUGIN_FILE,
			array(
				'version' => '2.1.1',
				'license' => $license_key,
				'item_id' => SPORTS_BENCH_PLUGIN_ITEM_ID,       // ID of the product
				'author'  => 'Jacob Martella Web Development', // author of this plugin
				'beta'    => false,
			)
		);

	}

	/**
	 * Activates the license key for the plugin.
	 *
	 * @since 2.0.0
	 */
	public function activate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST['sports_bench_plugin_license_activate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( 'sports_bench_plugin_license_nonce', 'sports_bench_plugin_license_nonce' ) ) {
				return;
			}

			// retrieve the license from the database
			$license = trim( get_option( 'sports_bench_plugin_license_key' ) );

			if ( ! $license && isset( $_POST['sports_bench_plugin_license_key'] ) ) {
				$license = $_POST['sports_bench_plugin_license_key'];
				update_option( 'sports_bench_plugin_license_key', $license );
			}

			// data to send in our API request
			$api_params = array(
				'edd_action'  => 'activate_license',
				'license'     => $license,
				'item_id'     => SPORTS_BENCH_PLUGIN_ITEM_ID,
				'url'         => home_url(),
				'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
			);

			// Call the custom API.
			$response = wp_remote_post( SPORTS_BENCH_PLUGIN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = esc_html__( 'An error occurred, please try again.', 'sports-bench' );
				}

			} else {

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( false === $license_data->success ) {

					switch ( $license_data->error ) {

						case 'expired' :

							$message = sprintf(
								esc_html__( 'Your license key expired on %s.', 'sports-bench' ),
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'disabled' :
						case 'revoked' :

							$message = esc_html__( 'Your license key has been disabled.', 'sports-bench' );
							break;

						case 'missing' :

							//$message = esc_html__( 'Invalid license.' );
							$message = [ $license_data, $license ];
							break;

						case 'invalid' :
						case 'site_inactive' :

							$message = esc_html__( 'Your license is not active for this URL.' );
							break;

						case 'item_name_mismatch' :

							$message = sprintf( esc_html__( 'This appears to be an invalid license key for %s.', 'sports-bench' ), SPORTS_BENCH_PLUGIN_ITEM_NAME );
							break;

						case 'no_activations_left':

							$message = esc_html__( 'Your license key has reached its activation limit.', 'sports-bench' );
							break;

						default :

							$message = esc_html__( 'An error occurred, please try again.', 'sports-bench' );
							break;
					}
				}
			}

			// Check if anything passed on a message constituting a failure
			if ( ! empty( $message ) ) {
				$base_url = admin_url( 'admin.php?page=sports-bench-options&tab=licenses' );
				$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

				wp_redirect( $redirect );
				exit();
			}

			// $license_data->license will be either "valid" or "invalid"
			update_option( 'sports_bench_plugin_license_status', $license_data->license );
			wp_redirect( admin_url( 'admin.php?page=sports-bench-options&tab=licenses' ) );
			exit();
		}
	}

	/**
	 * Deactivates the license key for the plugin.
	 *
	 * @since 2.0.0
	 */
	public function deactivate_license() {

		// listen for our activate button to be clicked
		if ( isset( $_POST['sports_bench_plugin_license_deactivate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( 'sports_bench_plugin_license_nonce', 'sports_bench_plugin_license_nonce' ) ) {
				return; // get out if we didn't click the Activate button
			}

			// retrieve the license from the database
			$license = trim( get_option( 'sports_bench_plugin_license_key' ) );

			if ( ! $license && isset( $_POST['sports_bench_plugin_license_key'] ) ) {
				$license = $_POST['sports_bench_plugin_license_key'];
			}

			// data to send in our API request
			$api_params = array(
				'edd_action'  => 'deactivate_license',
				'license'     => $license,
				'item_name'   => urlencode( SPORTS_BENCH_PLUGIN_ITEM_NAME ), // the name of our product in EDD
				'url'         => home_url(),
				'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
			);

			// Call the custom API.
			$response = wp_remote_post( SPORTS_BENCH_PLUGIN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = esc_html__( 'An error occurred, please try again.', 'sports-bench' );
				}

				$base_url = admin_url( 'admin.php?page=sports-bench-options&tab=licenses' );
				$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

				wp_redirect( $redirect );
				exit();
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// $license_data->license will be either "deactivated" or "failed"
			if ( 'deactivated' === $license_data->license ) {
				update_option( 'sports_bench_plugin_license_key', '' );
				delete_option( 'sports_bench_plugin_license_status' );
			}
			wp_redirect( admin_url( 'admin.php?page=sports-bench-options&tab=licenses' ) );
			exit();

		}
	}

	/**
	 * Checks to see if the license key is still good.
	 *
	 * @since 2.0.0
	 */
	public function check_license() {

		global $wp_version;

		$license = trim( get_option( 'sports_bench_plugin_license_key' ) );

		$api_params = array(
			'edd_action'  => 'check_license',
			'license'     => $license,
			'item_name'   => urlencode( SPORTS_BENCH_PLUGIN_ITEM_NAME ),
			'url'         => home_url(),
			'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
		);

		// Call the custom API.
		$response = wp_remote_post( SPORTS_BENCH_PLUGIN_STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( 'valid' === $license_data->license ) {
			echo 'valid'; exit;
		} else {
			echo 'invalid'; exit;
		}
	}

	/**
	 * Catches and displays any admin notices.
	 *
	 * @since 2.0.0
	 */
	public function license_admin_notices() {
		if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

			switch( $_GET['sl_activation'] ) {

				case 'false':
					$message = urldecode( $_GET['message'] );
					?>
					<div class="error">
						<p><?php echo $message; ?></p>
					</div>
					<?php
					break;

				case 'true':
				default:
					// Developers can put a custom success message here for when activation is successful if they way.
					break;

			}
		}
	}

}
