<?php
/**
 * Holds all of the admin side functions.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench;

use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Team;

/**
 * Runs the admin side.
 *
 * This class defines all code necessary to run on the admin side of the plugin.
 *
 * @since      2.0.0
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin
 */
class Sports_Bench_Admin {

	/**
	 * Version of the plugin.
	 *
	 * @since 2.0.0
	 *
	 * @var string $version Description.
	 *
	 * @access private
	 */
	private $version;


	/**
	 * Builds the Sports_Bench_Admin object.
	 *
	 * @since 2.0.0
	 *
	 * @param string $version       Version of the plugin.
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Enqueues the styles for the admin side of the plugin.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_styles() {

		if ( $this->is_sports_bench_page() ) {
			wp_enqueue_style( 'sports-bench-chivo-font', '//fonts.googleapis.com/css2?family=Chivo:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], $this->version, 'all' );
			wp_enqueue_style( 'sports-bench-nunito-font', '//fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], $this->version, 'all' );
			wp_enqueue_style( 'sports-bench-nunito-font', '//fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], $this->version, 'all' );
			wp_enqueue_style( 'sports-bench-global', plugin_dir_url( __FILE__ ) . 'css/global.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-teams' ) ) {
			wp_enqueue_style( 'sports-bench-teams-listing', plugin_dir_url( __FILE__ ) . 'css/teams-listing.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-add-team-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-team-form' ) ) {
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'sports-bench-teams-single', plugin_dir_url( __FILE__ ) . 'css/single-team.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-players' ) ) {
			wp_enqueue_style( 'sports-bench-players-listing', plugin_dir_url( __FILE__ ) . 'css/players-listing.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-add-player-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-player-form' ) ) {
			wp_enqueue_style( 'sports-bench-date-time-style', plugin_dir_url( __FILE__ ) . 'css/datetime-picker.min.css', [], $this->version, 'all' );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'sports-bench-players-single', plugin_dir_url( __FILE__ ) . 'css/single-player.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-divisions' ) ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'sports-bench-divisions', plugin_dir_url( __FILE__ ) . 'css/divisions.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-games' ) ) {
			wp_enqueue_style( 'sports-bench-games-listing', plugin_dir_url( __FILE__ ) . 'css/games-listing.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-add-game-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-game-form' ) ) {
			wp_enqueue_style( 'sports-bench-date-time-style', plugin_dir_url( __FILE__ ) . 'css/datetime-picker.min.css', [], $this->version, 'all' );
			wp_enqueue_style( 'sports-bench-games-single', plugin_dir_url( __FILE__ ) . 'css/single-game.min.css', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-options' ) ) {
			wp_enqueue_style( 'sports-bench-options', plugin_dir_url( __FILE__ ) . 'css/option.min.css', [], $this->version, 'all' );
		}

		if ( is_admin() ) {
			wp_enqueue_style( 'sports-bench-dashboard-widgets', plugin_dir_url( __FILE__ ) . 'css/dashboard-widgets.min.css', [], $this->version, 'all' );
		}

	}

	/**
	 * Enqueues the scripts for the admin side of the plugin.
	 *
	 * @since 2.0.0
	 */
	public function enqueue_scripts() {
		global $post;
		global $pagenow;

		if ( $this->is_sports_bench_page( 'sports-bench-add-team-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-team-form' ) ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'sports-bench-teams-single', plugin_dir_url( __FILE__ ) . 'js/team-admin.min.js', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-add-player-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-player-form' ) ) {
			wp_enqueue_script( 'sports-bench-date-time', plugin_dir_url( __FILE__ ) . 'js/datetime-picker.min.js', [], $this->version, 'all' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'sports-bench-player-single', plugin_dir_url( __FILE__ ) . 'js/player-admin.min.js', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-divisions' ) ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'sports-bench-divisions', plugin_dir_url( __FILE__ ) . 'js/divisions-admin.min.js', [], $this->version, 'all' );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-add-game-form' ) || $this->is_sports_bench_page( 'sports-bench-edit-game-form' ) ) {
			wp_enqueue_script( 'sports-bench-date-time', plugin_dir_url( __FILE__ ) . 'js/datetime-picker.min.js', [], $this->version, 'all' );
			wp_enqueue_script( 'sports-bench-game-page-admin', plugin_dir_url( __FILE__ ) . 'js/game-page-admin.min.js', [], $this->version, 'all' );
			$args = [
				'nonce'         => wp_create_nonce( 'sports-bench-load-games' ),
				'url'           => admin_url( 'admin-ajax.php' ),
				'rest_url'      => get_home_url() . '/wp-json/',
				'select_player' => esc_html__( 'Select a Player', 'sports-bench' ),
			];
			wp_localize_script( 'sports-bench-game-page-admin', 'sbloadgames', $args );
		}

		if ( $this->is_sports_bench_page( 'sports-bench-options' ) ) {
			wp_enqueue_script( 'sports-bench-import', plugin_dir_url( __FILE__ ) . 'js/import.min.js', [], $this->version, 'all' );
		}

		if ( ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && ( 'page' === $post->post_type ) ) {
			wp_enqueue_script( 'sports-bench-page-admin-script', plugin_dir_url( __FILE__ ) . 'js/custom-fields.min.js', [], $this->version, 'all' );
			//wp_enqueue_style( 'sports-bench-page-admin-style', plugins_url( 'css/sports-bench-page-backend.min.css', __FILE__ ) );
			//wp_enqueue_style( 'sports-bench-post-admin-style', plugins_url( 'css/sports-bench-post-tinymce-popup.min.css', __FILE__ ) );
		}

		if ( ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) && ( 'post' === $post->post_type ) ) {
			// wp_enqueue_style( 'sports-bench-post-admin-style', plugins_url( 'css/sports-bench-post-tinymce-popup.min.css', __FILE__ ) );
			//wp_enqueue_style( 'sports-bench-page-admin-style', plugins_url( 'css/sports-bench-page-backend.min.css', __FILE__ ) );
			wp_enqueue_script( 'sports-bench-page-admin-script', plugin_dir_url( __FILE__ ) . 'js/custom-fields.min.js', [], $this->version, 'all' );
		}

		if ( is_admin() ) {
			wp_enqueue_script( 'sports-bench-lite-upgrade-notice', plugin_dir_url( __FILE__ ) . 'js/lite-upgrade-notice.min.js', [], $this->version, 'all' );
			$args = [
				'url'           => admin_url( 'admin-ajax.php' )
			];
			wp_localize_script( 'sports-bench-lite-upgrade-notice', 'sbliteupgrade', $args );
		}
	}

	/**
	 * Determines if the page being loaded is a part of Sports Bench or not.
	 *
	 * @since 2.0.0
	 *
	 * @param null|string $page     Current page being loaded in the admin area.
	 * @return bool                 Whether the page loaded is a part of  Sports Bench or not.
	 */
	private function is_sports_bench_page( $page = null ) {
		global $pagenow;

		if ( ! isset( $_GET['page'] ) ) {
			return false;
		}

		if ( null === $page && ( ( 'admin.php' === $pagenow )  && ( 'sports-bench-teams' === $_GET['page'] || 'sports-bench-add-team-form' === $_GET['page'] || 'sports-bench-edit-team-form' === $_GET['page'] || 'sports-bench-players' === $_GET['page'] || 'sports-bench-add-player-form' === $_GET['page'] || 'sports-bench-edit-player-form' === $_GET['page'] || 'sports-bench-divisions' === $_GET['page'] || 'sports-bench-brackets' === $_GET['page'] || 'sports-bench-add-bracket-form' === $_GET['page'] || 'sports-bench-edit-bracket-form' === $_GET['page'] || 'sports-bench-games' === $_GET['page'] || 'sports-bench-add-game-form' === $_GET['page'] || 'sports-bench-edit-game-form' === $_GET['page'] || 'sports-bench-options' === $_GET['page'] ) ) ) {
			return true;
		}

		if ( ( 'admin.php' === $pagenow ) && ( $page === $_GET['page'] ) ) {
			return true;
		}

		return false;

	}

	/**
	 * Adds in the admin pages for Sports Bench.
	 *
	 * @since 2.0.0
	 */
	public function add_menu_pages() {

		// Teams pages.
		add_menu_page(
			__( 'Teams', 'sports-bench' ),
			__( 'Teams', 'sports-bench' ),
			'edit_posts',
			'sports-bench-teams',
			[ $this, 'team_listing_page'],
			'dashicons-groups',
			6
		);
		add_submenu_page(
			'sports-bench-teams',
			__( 'Teams', 'sports-bench' ),
			__( 'All Teams', 'sports-bench' ),
			'edit_posts',
			'sports-bench-teams',
			[ $this, 'team_listing_page']
		);
		add_submenu_page(
			'sports-bench-teams',
			__( 'Add New Team', 'sports-bench' ),
			__( 'Add New', 'sports-bench' ),
			'edit_posts',
			'sports-bench-add-team-form',
			[ $this, 'add_edit_team_page']
		);
		add_submenu_page(
			'',
			__( 'Edit Team', 'sports-bench' ),
			'',
			'edit_posts',
			'sports-bench-edit-team-form',
			[ $this, 'add_edit_team_page']
		);
		add_submenu_page(
			'sports-bench-teams',
			__( 'Divisions/Conferences', 'sports-bench' ),
			__( 'Divisions/Conferences', 'sports-bench' ),
			'edit_posts',
			'sports-bench-divisions',
			[ $this, 'division_page']
		);

		// Players pages.
		add_menu_page(
			__( 'Players', 'sports-bench' ),
			__( 'Players', 'sports-bench' ),
			'edit_posts',
			'sports-bench-players',
			[ $this, 'player_listing_page'],
			'dashicons-admin-users',
			6
		);
		add_submenu_page(
			'sports-bench-players',
			__( 'Players', 'sports-bench' ),
			__( 'All Players', 'sports-bench' ),
			'edit_posts',
			'sports-bench-players',
			[ $this, 'player_listing_page']
		);
		add_submenu_page(
			'sports-bench-players',
			__( 'Add New Player', 'sports-bench' ),
			__( 'Add New', 'sports-bench' ),
			'edit_posts',
			'sports-bench-add-player-form',
			[ $this, 'add_edit_player_page']
		);
		add_submenu_page(
			'',
			__( 'Edit Player', 'sports-bench' ),
			'',
			'edit_posts',
			'sports-bench-edit-player-form',
			[ $this, 'add_edit_player_page']
		);

		// Players pages.
		add_menu_page(
			__( 'Games', 'sports-bench' ),
			__( 'Games', 'sports-bench' ),
			'edit_posts',
			'sports-bench-games',
			[ $this, 'games_listing_page'],
			'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0OTYuMDMgMjkxLjM4Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzIzMWYyMDt9PC9zdHlsZT48L2RlZnM+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNMTA4LjE0LDE2Mmw0OCwxNDIuMjksNDgtMTQyLjI5aC0zNS45VjExMy42NEgyOTMuODlWMTYySDI1OS41bC04MiwyMzcuOTFIMTE4LjcyTDMzLjg3LDE2MmgtMzRWMTEzLjY0SDE0NVYxNjJaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjE0IC0xMTAuNDMpIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNNDMzLjUzLDEzNy4yNlYxMTMuNjRoNDguMzh2ODYuMTdINDMzLjUzcS0zLTIwLjc3LTEzLjUxLTMxLjI3VDM5Mi45LDE1OC4wNWEzMS4yLDMxLjIsMCwwLDAtMjAsNi42MXEtOC4zMyw2LjYzLTguMzIsMTYuNjNhMjMuMjksMjMuMjksMCwwLDAsNS4yOSwxNS4zMSw0NC4zMyw0NC4zMywwLDAsMCwxMy42MSwxMC44NnE4LjMxLDQuNDYsMjQuOTQsMTEuODJsMTEuNTMsNC45MXEzNy41OSwxNi4yNSw1Ni43OCwzOC4xN3QxOS4xOCw1NC44cTAsMzkuMTItMjIuNDksNjEuODh0LTYwLjQ2LDIyLjc4cS0zNy4wNSwwLTU3LjY0LTI3Ljc4djI0LjM3SDMwNi45M1YzMDEuNjZIMzU1LjNxMS41MSwyNS4xNCwxMi45NSwzOC4yN3QzMC44OSwxMy4xM2EzMC4xMywzMC4xMywwLDAsMCwyMi04Ljg4LDI5LjE4LDI5LjE4LDAsMCwwLDktMjEuNTRxMC0xMi44Ni0xMC4zLTIzLjUzdC0zNS4wNS0yMS40NHEtNDIuMTMtMTguNTMtNjEuMTMtMzkuODh0LTE5LTQ5LjEzYTgwLDgwLDAsMCwxLDEwLTM5LjY4LDczLjY3LDczLjY3LDAsMCwxLDI3LjY5LTI4LjI1LDc1LDc1LDAsMCwxLDM4LjQ1LTEwLjMsNjYuNzIsNjYuNzIsMCwwLDEsMzAuMjMsNi44QTU4LjEzLDU4LjEzLDAsMCwxLDQzMy41MywxMzcuMjZaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjE0IC0xMTAuNDMpIi8+PC9zdmc+',
			6
		);
		add_submenu_page(
			'sports-bench-games',
			__( 'Games', 'sports-bench' ),
			__( 'All Games', 'sports-bench' ),
			'edit_posts',
			'sports-bench-games',
			[ $this, 'games_listing_page']
		);
		add_submenu_page(
			'sports-bench-games',
			__( 'Add New Game', 'sports-bench' ),
			__( 'Add New', 'sports-bench' ),
			'edit_posts',
			'sports-bench-add-game-form',
			[ $this, 'add_edit_game_page']
		);
		add_submenu_page(
			'',
			__( 'Edit Game', 'sports-bench' ),
			'',
			'edit_posts',
			'sports-bench-edit-game-form',
			[ $this, 'add_edit_game_page']
		);

		// Sports Bench options pages.
		add_menu_page(
			__( 'Sports Bench', 'sports-bench' ),
			__( 'Sports Bench', 'sports-bench' ),
			'edit_posts',
			'sports-bench-options',
			[ $this, 'options_page'],
			'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0NjIuODUgMzU2Ljg2Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzIzMWYyMDt9PC9zdHlsZT48L2RlZnM+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNMCwxNTMuODVhMjIuOTIsMjIuOTIsMCwwLDEsNy42OC0xNy40LDI2LjA1LDI2LjA1LDAsMCwxLDE4LjQzLTcuMTdBMjUuNDMsMjUuNDMsMCwwLDEsNDQsMTM2LjQ1YTIyLjkyLDIyLjkyLDAsMCwxLDcuNjgsMTcuNEEyMy40OCwyMy40OCwwLDAsMSw0NCwxNzEuNzdhMjUuMzgsMjUuMzgsMCwwLDEtMTcuOTIsNy4xNywyNiwyNiwwLDAsMS0xOC40My03LjE3QTIzLjQ4LDIzLjQ4LDAsMCwxLDAsMTUzLjg1Wm0wLDUxLjJhMjUuMTUsMjUuMTUsMCwwLDEsNy42OC0xOC40MywyNS4xMywyNS4xMywwLDAsMSwxOC40My03LjY4QTI0LjU1LDI0LjU1LDAsMCwxLDQ0LDE4Ni42MmEyNiwyNiwwLDAsMSwwLDM2Ljg3LDI0LjU1LDI0LjU1LDAsMCwxLTE3LjkyLDcuNjgsMjUuMTMsMjUuMTMsMCwwLDEtMTguNDMtNy42OEEyNS4xNSwyNS4xNSwwLDAsMSwwLDIwNS4wNVptMCwyMDQuOGEyMi45MiwyMi45MiwwLDAsMSw3LjY4LTE3LjQsMjYuMDUsMjYuMDUsMCwwLDEsMTguNDMtNy4xN0EyNS40MywyNS40MywwLDAsMSw0NCwzOTIuNDVhMjMuNTYsMjMuNTYsMCwwLDEsMCwzNC44MSwyNS4zOCwyNS4zOCwwLDAsMS0xNy45Miw3LjE3LDI2LDI2LDAsMCwxLTE4LjQzLTcuMTdBMjIuOSwyMi45LDAsMCwxLDAsNDA5Ljg1Wk01MS4yLDI1NS43NGEyMy43NCwyMy43NCwwLDAsMSw3LjY4LTE3LjY2LDI1LjU3LDI1LjU3LDAsMCwxLDE4LjQzLTcuNDMsMjUsMjUsMCwwLDEsMTcuOTIsNy40MywyMy43NCwyMy43NCwwLDAsMSw3LjY4LDE3LjY2LDI0LjMxLDI0LjMxLDAsMCwxLTcuNjgsMTguMTgsMjUsMjUsMCwwLDEtMTcuOTIsNy40MiwyNS41NiwyNS41NiwwLDAsMS0xOC40My03LjQyQTI0LjMxLDI0LjMxLDAsMCwxLDUxLjIsMjU1Ljc0Wm0uNTEtMTUyLjU3YTI0LjU1LDI0LjU1LDAsMCwxLDcuNjgtMTcuOTIsMjUuMTUsMjUuMTUsMCwwLDEsMTguNDMtNy42OCwyNC41NSwyNC41NSwwLDAsMSwxNy45Miw3LjY4LDI0LjU1LDI0LjU1LDAsMCwxLDcuNjgsMTcuOTIsMjUuMTUsMjUuMTUsMCwwLDEtNy42OCwxOC40MywyNC41NSwyNC41NSwwLDAsMS0xNy45Miw3LjY4LDI2LjIyLDI2LjIyLDAsMCwxLTI2LjExLTI2LjExWm0wLDMwNi42OGEyMy4yNiwyMy4yNiwwLDAsMSw3LjQzLTE3LjQsMjUuMzMsMjUuMzMsMCwwLDEsMzUuMzIsMCwyNC4xLDI0LjEsMCwwLDEsMCwzNC44MSwyNS4zMywyNS4zMywwLDAsMS0zNS4zMiwwQTIzLjIzLDIzLjIzLDAsMCwxLDUxLjcxLDQwOS44NVptNTAuMTgtLjUxYTIzLDIzLDAsMCwxLDcuNjgtMTcuNDEsMjYuNzQsMjYuNzQsMCwwLDEsMTguOTQtNy4xNiwyNi4wOSwyNi4wOSwwLDAsMSwxOC40Myw3LjE2LDIzLDIzLDAsMCwxLDcuNjgsMTcuNDEsMjMuNDgsMjMuNDgsMCwwLDEtNy42OCwxNy45MiwyNiwyNiwwLDAsMS0xOC40Myw3LjE3LDI2LjY2LDI2LjY2LDAsMCwxLTE4Ljk0LTcuMTdBMjMuNDgsMjMuNDgsMCwwLDEsMTAxLjg5LDQwOS4zNFptMS0xNTMuMDlhMjQuNjgsMjQuNjgsMCwwLDEsNy40My0xOC4xNywyNC43LDI0LjcsMCwwLDEsMzUuMzIsMCwyNS45NCwyNS45NCwwLDAsMSwwLDM2LjM1LDI0LjczLDI0LjczLDAsMCwxLTM1LjMyLDBBMjQuNjcsMjQuNjcsMCwwLDEsMTAyLjkxLDI1Ni4yNVptLjUxLTE1My42QTI1LDI1LDAsMCwxLDE0Ni4xOCw4NWEyNC43NCwyNC43NCwwLDAsMSwwLDM1LjMzLDI1LjEsMjUuMSwwLDAsMS00Mi43Ni0xNy42N1ptNDkuNjcsMjA0LjI5YTIzLjc0LDIzLjc0LDAsMCwxLDcuNjgtMTcuNjYsMjYuNTcsMjYuNTcsMCwwLDEsMzYuODYsMCwyMy43NCwyMy43NCwwLDAsMSw3LjY4LDE3LjY2LDI0LjMxLDI0LjMxLDAsMCwxLTcuNjgsMTguMTgsMjYuNiwyNi42LDAsMCwxLTM2Ljg2LDBBMjQuMzEsMjQuMzEsMCwwLDEsMTUzLjA5LDMwNi45NFptLjUxLTIwNC4yOUEyMy4zNiwyMy4zNiwwLDAsMSwxNjEuNTQsODVhMjcuMDksMjcuMDksMCwwLDEsMTkuMi03LjQyQTI2LjQ5LDI2LjQ5LDAsMCwxLDE5OS40Miw4NWEyMy42MiwyMy42MiwwLDAsMSwwLDM1LjMzLDI2LjQ1LDI2LjQ1LDAsMCwxLTE4LjY4LDcuNDIsMjcsMjcsMCwwLDEtMTkuMi03LjQyQTIzLjM1LDIzLjM1LDAsMCwxLDE1My42LDEwMi42NVptMSwyNTZhMjUuNTksMjUuNTksMCwwLDEsNy40My0xOC40MywyNC4yOSwyNC4yOSwwLDAsMSwxOC4xNy03LjY4LDIzLjc0LDIzLjc0LDAsMCwxLDE3LjY3LDcuNjgsMjYuNjEsMjYuNjEsMCwwLDEsMCwzNi44NywyMy43NCwyMy43NCwwLDAsMS0xNy42Nyw3LjY4LDI0LjI5LDI0LjI5LDAsMCwxLTE4LjE3LTcuNjhBMjUuNiwyNS42LDAsMCwxLDE1NC42MiwzNTguNjVaIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwIC03Ny41NykiLz48cGF0aCBjbGFzcz0iY2xzLTEiIGQ9Ik0yNTYsMTAzLjE3QTI0LjMxLDI0LjMxLDAsMCwxLDI2My42OCw4NWEyNS42LDI1LjYsMCwwLDEsMTguNDMtNy40MkEyNSwyNSwwLDAsMSwzMDAsODVhMjUuMzUsMjUuMzUsMCwwLDEsMCwzNi4zNSwyNSwyNSwwLDAsMS0xNy45Miw3LjQzLDI1LjU3LDI1LjU3LDAsMCwxLTE4LjQzLTcuNDNBMjQuMjksMjQuMjksMCwwLDEsMjU2LDEwMy4xN1ptMCw1MS4yYTI0LjMxLDI0LjMxLDAsMCwxLDcuNjgtMTguMTgsMjcuOSwyNy45LDAsMCwxLDM3Ljg5LDAsMjUuMzUsMjUuMzUsMCwwLDEsMCwzNi4zNSwyNy44NywyNy44NywwLDAsMS0zNy44OSwwQTI0LjI5LDI0LjI5LDAsMCwxLDI1NiwxNTQuMzdabTAsNTEuMmEyNC4zMSwyNC4zMSwwLDAsMSw3LjY4LTE4LjE4LDI3LjksMjcuOSwwLDAsMSwzNy44OSwwLDI1LjM1LDI1LjM1LDAsMCwxLDAsMzYuMzUsMjcuODcsMjcuODcsMCwwLDEtMzcuODksMEEyNC4yOSwyNC4yOSwwLDAsMSwyNTYsMjA1LjU3Wm0wLDUwLjY4YTIzLjc0LDIzLjc0LDAsMCwxLDcuNjgtMTcuNjYsMjUuNiwyNS42LDAsMCwxLDE4LjQzLTcuNDJBMjUsMjUsMCwwLDEsMzAwLDIzOC41OWEyMy43NCwyMy43NCwwLDAsMSw3LjY4LDE3LjY2QTI0LjMsMjQuMywwLDAsMSwzMDAsMjc0LjQzYTI1LDI1LDAsMCwxLTE3LjkyLDcuNDIsMjUuNTYsMjUuNTYsMCwwLDEtMTguNDMtNy40MkEyNC4zLDI0LjMsMCwwLDEsMjU2LDI1Ni4yNVpNMjU2LDMwOGEyMi45MywyMi45MywwLDAsMSw3LjY4LTE3LjQxLDI2LjcsMjYuNywwLDAsMSwxOC45NC03LjE3LDI2LjA4LDI2LjA4LDAsMCwxLDE4LjQ0LDcuMTcsMjMuNTYsMjMuNTYsMCwwLDEsMCwzNC44MSwyNiwyNiwwLDAsMS0xOC40NCw3LjE3LDI2LjY2LDI2LjY2LDAsMCwxLTE4Ljk0LTcuMTdBMjIuODksMjIuODksMCwwLDEsMjU2LDMwOFptMCw1MC4xN0EyNC4yOSwyNC4yOSwwLDAsMSwyNjMuNjgsMzQwYTI2LjIsMjYuMiwwLDAsMSwxOC45NC03LjQzQTI1LjYsMjUuNiwwLDAsMSwzMDEuMDYsMzQwYTI1LjM1LDI1LjM1LDAsMCwxLDAsMzYuMzUsMjUuNTksMjUuNTksMCwwLDEtMTguNDQsNy40MiwyNi4xOSwyNi4xOSwwLDAsMS0xOC45NC03LjQyQTI0LjMxLDI0LjMxLDAsMCwxLDI1NiwzNTguMTRabTAsNTEuMmEyMywyMywwLDAsMSw3LjY4LTE3LjQxLDI3LjMsMjcuMywwLDAsMSwzNi44NiwwLDIzLDIzLDAsMCwxLDcuNjgsMTcuNDEsMjMuNDgsMjMuNDgsMCwwLDEtNy42OCwxNy45MiwyNy4yNywyNy4yNywwLDAsMS0zNi44NiwwQTIzLjQ4LDIzLjQ4LDAsMCwxLDI1Niw0MDkuMzRabTUxLjcxLTMwNy43MXEwLTkuNzIsNy42OC0xNi45YTI2LjEsMjYuMSwwLDAsMSwxOC40My03LjE2LDI1LjQ2LDI1LjQ2LDAsMCwxLDE3LjkyLDcuMTZxNy42OCw3LjE4LDcuNjgsMTYuOXQtNy42OCwxNi45YTI1LjQyLDI1LjQyLDAsMCwxLTE3LjkyLDcuMTYsMjYuMDYsMjYuMDYsMCwwLDEtMTguNDMtNy4xNlEzMDcuNzEsMTExLjM2LDMwNy43MSwxMDEuNjNabTAsMTU0LjYyYTI0LjA5LDI0LjA5LDAsMCwxLDcuNDMtMTcuNjYsMjQuNzIsMjQuNzIsMCwwLDEsMTguMTctNy40MiwyNS4zNCwyNS4zNCwwLDAsMSwyNS4wOSwyNS4wOEEyNC43NCwyNC43NCwwLDAsMSwzNTEsMjc0LjQzYTI0LjE0LDI0LjE0LDAsMCwxLTE3LjY3LDcuNDIsMjUuMzUsMjUuMzUsMCwwLDEtMjUuNi0yNS42Wm0uNTEsMTUzLjA5YTIzLjMzLDIzLjMzLDAsMCwxLDcuNDMtMTcuNDEsMjUuMTksMjUuMTksMCwwLDEsMTguMTctNy4xNiwyNC41OSwyNC41OSwwLDAsMSwxNy42Nyw3LjE2LDIzLjM2LDIzLjM2LDAsMCwxLDcuNDIsMTcuNDEsMjMuOSwyMy45LDAsMCwxLTcuNDIsMTcuOTIsMjQuNTIsMjQuNTIsMCwwLDEtMTcuNjcsNy4xNywyNS4xMiwyNS4xMiwwLDAsMS0xOC4xNy03LjE3QTIzLjg3LDIzLjg3LDAsMCwxLDMwOC4yMiw0MDkuMzRaTTM1OC40LDI1Ni4yNWEyNC41MiwyNC41MiwwLDAsMSw3LjE3LTE3LjY2LDIzLjksMjMuOSwwLDAsMSwxNy45Mi03LjQyLDIzLjM2LDIzLjM2LDAsMCwxLDE3LjQxLDcuNDIsMjUuMzcsMjUuMzcsMCwwLDEsMCwzNS4zMywyMy4zMiwyMy4zMiwwLDAsMS0xNy40MSw3LjQyLDIzLjg2LDIzLjg2LDAsMCwxLTE3LjkyLTcuNDJBMjQuNTEsMjQuNTEsMCwwLDEsMzU4LjQsMjU2LjI1Wm0uNTEsMTUzLjA5YTI0LjA5LDI0LjA5LDAsMCwxLDcuNDMtMTcuNjYsMjUuOTQsMjUuOTQsMCwwLDEsMzYuMzUsMCwyNC43NCwyNC43NCwwLDAsMSwwLDM1LjMzLDI2LDI2LDAsMCwxLTM2LjM1LDBBMjQuMSwyNC4xLDAsMCwxLDM1OC45MSw0MDkuMzRabS41MS0zMDcuNzFhMjIuNzcsMjIuNzcsMCwwLDEsNy40My0xNi45LDI2LjY1LDI2LjY1LDAsMCwxLDM2LjM1LDAsMjMsMjMsMCwwLDEsMCwzMy44LDI2LjY1LDI2LjY1LDAsMCwxLTM2LjM1LDBBMjIuNzQsMjIuNzQsMCwwLDEsMzU5LjQyLDEwMS42M1ptNDguNjQsMjA1LjgyQTI0LjcyLDI0LjcyLDAsMCwxLDQxNiwyODlhMjcuMjMsMjcuMjMsMCwwLDEsMTkuNzEtNy42OCwyNi42LDI2LjYsMCwwLDEsMTkuMiw3LjY4LDI1LjM3LDI1LjM3LDAsMCwxLDAsMzYuODcsMjYuNiwyNi42LDAsMCwxLTE5LjIsNy42OEEyNy4yMywyNy4yMywwLDAsMSw0MTYsMzI1Ljg5LDI0LjcyLDI0LjcyLDAsMCwxLDQwOC4wNiwzMDcuNDVabTEtMTU0LjExYTI0LjQ4LDI0LjQ4LDAsMSwxLDcuMTcsMTcuNDFBMjMuNjksMjMuNjksMCwwLDEsNDA5LjA5LDE1My4zNFptMS41MywyMDUuMzFBMjMuNzQsMjMuNzQsMCwwLDEsNDE4LjMsMzQxYTI2LjYxLDI2LjYxLDAsMCwxLDM2Ljg3LDAsMjMuNzQsMjMuNzQsMCwwLDEsNy42OCwxNy42NiwyNC4zLDI0LjMsMCwwLDEtNy42OCwxOC4xOCwyNi42MSwyNi42MSwwLDAsMS0zNi44NywwQTI0LjMsMjQuMywwLDAsMSw0MTAuNjIsMzU4LjY1Wm0uNTItMTUzLjZhMjUuNTgsMjUuNTgsMCwwLDEsNy40Mi0xOC40MywyNC4zLDI0LjMsMCwwLDEsMTguMTgtNy42OCwyMy43NCwyMy43NCwwLDAsMSwxNy42Niw3LjY4LDI1LjYyLDI1LjYyLDAsMCwxLDcuNDIsMTguNDNBMjYuMjQsMjYuMjQsMCwwLDEsNDU0LjQsMjI0YTIzLjc0LDIzLjc0LDAsMCwxLTE3LjY2LDcuNjhBMjQuMywyNC4zLDAsMCwxLDQxOC41NiwyMjQsMjYuMTksMjYuMTksMCwwLDEsNDExLjE0LDIwNS4wNVoiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAgLTc3LjU3KSIvPjwvc3ZnPg==',
			59
		);
		add_submenu_page(
			'sports-bench-options',
			__( 'Sports Bench Options', 'sports-bench' ),
			__( 'Sports Bench Options', 'sports-bench' ),
			'edit_posts',
			'sports-bench-options',
			[ $this, 'options_page']
		);

	}

	/**
	 * Loads the partial for the teams listing page.
	 *
	 * @since 2.0.0
	 */
	public function team_listing_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/teams/teams-listing.php';
	}

	/**
	 * Loads the partial for the add/edit team page.
	 *
	 * @since 2.0.0
	 */
	public function add_edit_team_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/teams/add-edit-team.php';
	}

	/**
	 * Loads the partial for the players listing page.
	 *
	 * @since 2.0.0
	 */
	public function player_listing_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/players/players-listing.php';
	}

	/**
	 * Loads the partial for the add/edit player page.
	 *
	 * @since 2.0.0
	 */
	public function add_edit_player_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/players/add-edit-player.php';
	}

	/**
	 * Loads the partial for the divisions listing page.
	 *
	 * @since 2.0.0
	 */
	public function division_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/divisions/divisions-listing.php';
	}

	/**
	 * Loads the partial for the games listing page.
	 *
	 * @since 2.0.0
	 */
	public function games_listing_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/games/games-listing.php';
	}

	/**
	 * Loads the partial for the add/edit game page.
	 *
	 * @since 2.0.0
	 */
	public function add_edit_game_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/games/add-edit-game.php';
	}

	/**
	 * Loads the partial for the options page.
	 *
	 * @since 2.0.0
	 */
	public function options_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/options/options-page.php';
	}

	/**
	 * Registers the Sports Bench options.
	 *
	 *
	 * @since 2.0.0
	 */
	public function register_plugin_options() {
		register_setting( 'sports_bench_options_settings', 'sports-bench-sport', [ $this, 'sports_bench_check_change_sport' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-season-year', [ $this, 'sports_bench_check_text' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-season', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-display-game', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-week-number', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-player-page', [ $this, 'sports_bench_check_change_page' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-team-page', [ $this, 'sports_bench_check_change_page' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-box-score-page', [ $this, 'sports_bench_check_change_page' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-display-map', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-week-maps-api-key', [ $this, 'sports_bench_check_text' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-abbreviation-guide', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-basketball-halves', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports-bench-use-fonts', [ $this, 'sports_bench_check_num' ] );
		register_setting( 'sports_bench_options_settings', 'sports_bench_plugin_license_key', [ $this, 'sanitize_license' ] );
	}

	/**
	 * Adds in the meta boxes for posts, standings and stats.
	 *
	 * @since 2.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box( 'sports-bench-meta', esc_html__( 'Sports Bench Information', 'sports-bench' ), [ $this, 'create_post_meta_box' ], 'post', 'side', 'default' );
		add_meta_box( 'sports-bench-standings', esc_html__( 'Standings Information', 'sports-bench' ), [ $this, 'create_standings_meta_box'], ['page', 'post'], 'normal', 'default' );
		add_meta_box( 'sports-bench-stats', esc_html__( 'Statistics', 'sports-bench' ), [ $this, 'create_stats_meta_box'], ['page', 'post'], 'normal', 'default' );
	}

	/**
	 * Creates the Sports Bench Information meta box for posts.
	 *
	 * @since 2.0.0
	 */
	public function create_post_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/posts/post-meta-box.php';
	}

	/**
	 * Creates the Sports Bench Standings meta box for pages.
	 *
	 * @since 2.0.0
	 */
	public function create_standings_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/posts/standings-meta-box.php';
	}

	/**
	 * Creates the Sports Bench Stats meta box for pages.
	 *
	 * @since 2.0.0
	 */
	public function create_stats_meta_box() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/posts/stats-meta-box.php';
	}

	/**
	 * Saves the basic Sports Bench Information meta box for posts.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id      The ID for the post of the meta box data being saved.
	 */
	public function save_post_meta_box( $post_id ) {
		global $wpdb;
		$games      = [];
		$games['']  = esc_html__( 'Select a Game', 'sports-bench' );
		$table_name = $wpdb->prefix . 'sb_games';
		$games_list = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %s ORDER BY game_day DESC;', $table_name ) );
		foreach ( $games_list as $game ) {
			$away_team                     = new Team( (int) $game->get_game_away_id() );
			$home_team                     = new Team( (int) $game->get_game_home_id() );
			$date                          = new DateTime( $game->get_game_day() );
			$game_date                     = date_format( $date, get_option( 'date_format' ) );
			$games[ $game->get_game_id() ] = $game_date . ': ' . $away_team->get_team_name . ' at ' . $home_team->get_team_name();
		}

		$old_link = get_post_meta( $post_id, 'sports_bench_game', true );

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['meta_box_nonce'], 'sports_bench_nonce' ) ) {
			return;
		}

		if ( isset( $_POST['sports_bench_photo_credit'] ) ) {
			update_post_meta( $post_id, 'sports_bench_photo_credit', wp_filter_nohtml_kses( $_POST['sports_bench_photo_credit'] ) );
		}

		if ( isset( $_POST['sports_bench_video'] ) ) {
			update_post_meta( $post_id, 'sports_bench_video', wp_filter_nohtml_kses( $_POST['sports_bench_video'] ) );
		}

		if ( isset( $_POST['sports_bench_game_preview_recap'] ) ) {
			update_post_meta( $post_id, 'sports_bench_game_preview_recap', wp_filter_nohtml_kses( $_POST['sports_bench_game_preview_recap'] ) );
		}

		if ( isset( $_POST['sports_bench_game_preview_recap'] ) && 'preview' === $_POST['sports_bench_game_preview_recap'] ) {
			if ( isset( $_POST['sports_bench_game'] ) && array_key_exists( $_POST['sports_bench_game'], $games ) ) {

				if ( isset( $old_link ) ) {
					$table                = $wpdb->prefix . 'games';
					$link['game_preview'] = '';
					$wpdb->update( $table, ['game_preview' => ''], ['game_id' => $old_link ] );
				}

				update_post_meta( $post_id, 'sports_bench_game', wp_filter_nohtml_kses( $_POST['sports_bench_game'] ) );
				$post_link            = get_permalink( $post_id );
				$table                = $wpdb->prefix . 'sb_games';
				$link['game_preview'] = $post_link;
				$game_id              = wp_filter_nohtml_kses( $_POST['sports_bench_game'] );
				$wpdb->update( $table, $link, ['game_id' => $game_id ] );
			}
		} elseif ( isset( $_POST['sports_bench_game_preview_recap'] ) and $_POST['sports_bench_game_preview_recap'] == 'recap' ) {
			if ( isset( $_POST['sports_bench_game'] ) && array_key_exists( $_POST['sports_bench_game'], $games ) ) {
				if ( isset( $old_link ) ) {
					$table              = $wpdb->prefix . 'sb_games';
					$link['game_recap'] = '';
					$wpdb->update( $table, ['game_recap' => ''], ['game_id' => $old_link ] );
				}

				update_post_meta( $post_id, 'sports_bench_game', wp_filter_nohtml_kses( $_POST['sports_bench_game'] ) );
				$post_link          = get_permalink( $post_id );
				$table              = $wpdb->prefix . 'sb_games';
				$link['game_recap'] = $post_link;
				$game_id            = wp_filter_nohtml_kses( $_POST['sports_bench_game'] );
				$wpdb->update( $table, $link, ['game_id' => $game_id ] );
			}
		} else {

		}

	}

	/**
	 * Saves the basic Sports Bench Stanings meta box for pages.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id      The ID for the page of the meta box data being saved.
	 */
	public function save_standings_meta_box( $post_id ) {
		if ( 'soccer' === get_option( 'sports-bench-sport' ) || 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$standings_items = array(
				'goals-for'             => esc_html__( 'Goals For', 'sports-bench' ),
				'goals-against'         => esc_html__( 'Goals Against', 'sports-bench' ),
				'goals-differential'    => esc_html__( 'Goal Differential', 'sports-bench' ),
				'home-record'           => esc_html__( 'Home Record', 'sports-bench' ),
				'away-record'           => esc_html__( 'Away Record', 'sports-bench' ),
				'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
				'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
			);
		} elseif ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$standings_items = array(
				'runs-for'          => esc_html__( 'Runs For', 'sports-bench' ),
				'runs-against'      => esc_html__( 'Runs Against', 'sports-bench' ),
				'run-differential'  => esc_html__( 'Run Differential', 'sports-bench' ),
				'home-record'       => esc_html__( 'Home Record', 'sports-bench' ),
				'away-record'       => esc_html__( 'Away Record', 'sports-bench' ),
				'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
				'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
			);
		} else {
			$standings_items = array(
				'points-for'            => esc_html__( 'Points For', 'sports-bench' ),
				'points-against'        => esc_html__( 'Points Against', 'sports-bench' ),
				'points-differential'   => esc_html__( 'Point Differential', 'sports-bench' ),
				'home-record'           => esc_html__( 'Home Record', 'sports-bench' ),
				'away-record'           => esc_html__( 'Away Record', 'sports-bench' ),
				'division-record'       => apply_filters( 'sports_bench_division_name', esc_html__( 'Division', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' ),
				'conference-record'     => apply_filters( 'sports_bench_conference_name', esc_html__( 'Conference', 'sports-bench' ) ) . ' ' . esc_html__( 'Record', 'sports-bench' )
			);
		}

		if ( ! isset( $_POST['sports_bench_standings_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['sports_bench_standings_meta_box_nonce'], 'sports_bench_standings_meta_box_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$old = get_post_meta( $post_id, 'sports_bench_standings_items', true );
		$new = [];

		$lines = $this->sanitize_array( $_POST['sports_bench_standings_items'] );

		$num = count( $lines );

		if ( isset( $_POST['sports_bench_standings_league'] ) && '1' === $_POST['sports_bench_standings_league'] ) {
			$league = 1;
		} else {
			$league = 0;
		}
		update_post_meta( $post_id, 'sports_bench_standings_league', wp_filter_nohtml_kses( $league ) );

		if ( isset( $_POST['sports_bench_standings_conference'] ) && '1' === $_POST['sports_bench_standings_conference'] ) {
			$conference = 1;
		} else {
			$conference = 0;
		}
		update_post_meta( $post_id, 'sports_bench_standings_conference', wp_filter_nohtml_kses( $conference ) );

		if ( isset( $_POST['sports_bench_standings_division'] ) && '1' === $_POST['sports_bench_standings_division'] ) {
			$division = 1;
		} else {
			$division = 0;
		}
		update_post_meta( $post_id, 'sports_bench_standings_division', wp_filter_nohtml_kses( $division ) );

		for ( $i = 0; $i < $num; $i++ ) {
			if ( $lines[ $i ] && array_key_exists( $lines[ $i ], $standings_items ) ) {
				$new[ $i ]['sports_bench_standings_items'] = wp_filter_nohtml_kses( $lines[ $i ] );
			}
		}

		if ( ! empty( $new ) && $new !== $old ) {
			update_post_meta( $post_id, 'sports_bench_standings_items', $new );
		} elseif ( empty( $new ) && $old ) {
			delete_post_meta( $post_id, 'sports_bench_standings_items', $old );
		}

	}

	/**
	 * Saves the basic Sports Bench Stats meta box for pages.
	 *
	 * @since 2.0.0
	 *
	 * @param int $post_id      The ID for the page of the meta box data being saved.
	 */
	public function save_stats_meta_box( $post_id ) {
		if ( 'baseball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
				'wins'                  => esc_html__( 'Wins', 'sports-bench' ),
				'saves'                 => esc_html__( 'Saves', 'sports-bench' ),
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
			];
		} elseif ( 'basketball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
			];
		} elseif ( 'football' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
				'return_fumbles'    => esc_html__( 'Return Fumbles', 'sports-bench' )
			];
		} elseif ( 'hockey' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
				'faceoff_wins'          => esc_html__( 'Faceoff Wins', 'sports-bench' ),
				'shots_faced'           => esc_html__( 'Shots Faced', 'sports-bench' ),
				'saves'                 => esc_html__( 'Shots Saved', 'sports-bench' ),
				'goals_allowed'         => esc_html__( 'Goals Allowed', 'sports-bench' ),
				'goals_against_average' => esc_html__( 'Goals Against Average', 'sports-bench' ),
			];
		} elseif ( 'rugby' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
			];
		} elseif ( 'volleyball' === get_option( 'sports-bench-sport' ) ) {
			$stats_items = [
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
				'receiving_errors'      => esc_html__( 'Receiving Errors', 'sports-bench' ),
			];
		} else {
			$stats_items = [
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
			];
		}

		if ( ! isset( $_POST['sports_bench_stats_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['sports_bench_stats_meta_box_nonce'], 'sports_bench_stats_meta_box_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$old = get_post_meta( $post_id, 'sports_bench_stats', true );
		$new = [];

		$lines = $this->sanitize_array( $_POST['sports_bench_stats'] );

		$num = count( $lines );

		for ( $i = 0; $i < $num; $i++ ) {

			if ( $lines[ $i ] && array_key_exists( $lines[ $i ], $stats_items ) ) {
				$new[ $i ]['sports_bench_stats'] = wp_filter_nohtml_kses( $lines[ $i ] );
			}
		}

		if ( ! empty( $new ) && $new !== $old ) {
			update_post_meta( $post_id, 'sports_bench_stats', $new );
		} elseif ( empty( $new ) && $old ) {
			delete_post_meta( $post_id, 'sports_bench_stats', $old );
		}

	}

	/**
	 * Checks to see if the sport has been changes and runs the function
	 * to re-create the database tables based on the new sport.
	 *
	 * @since 2.0.0
	 *
	 * @param string $input      The sport that has been selected.
	 * @return string            The sport that has been selected.
	 */
	public function sports_bench_check_change_sport( $input ) {
		$current_sport = get_option( 'sports-bench-sport' );
		if ( $current_sport !== $input ) {
			$database = new Sports_Bench_Database( $this->version );
			$database->update_sport_tables( $input );
		}

		return $input;
	}

	/**
	 * Checks to make sure that the selected page is an actual page.
	 * Then it updates the option if it is different.
	 *
	 * @since 2.0.0
	 *
	 * @param int $input      The ID of the page selected.
	 * @return int            The ID of the page selected.
	 */
	public function sports_bench_check_change_page( $input ) {
		$pages            = get_pages();
		$page_ags['none'] = esc_html__( 'None', 'sports-bench' );
		foreach ( $pages as $page ) {
			$page_ags[ $page->ID ] = $page->post_title;
		}

		$input = sanitize_key( $input );
		if ( array_key_exists( $input, $page_ags ) ) {
			return $input;
		}
	}

	/**
	 * Makes sure the inputted humber is an integer.
	 *
	 * @since 2.0.0
	 *
	 * @param int $input      The entered number.
	 * @return int            The returned number as an integer (if it wasn't already).
	 */
	public function sports_bench_check_num( $input ) {
		return absint( $input );
	}

	/**
	 * Sanitizes the text that's inputted.
	 *
	 * @since 2.0.0
	 *
	 * @param string $input      The entered text string.
	 * @return string            The sanitized text string.
	 */
	public function sports_bench_check_text( $input ) {
		return wp_filter_nohtml_kses( $input );
	}

	/**
	 * Sanitizes the license key for use.
	 *
	 * @since 2.0.0
	 *
	 * @param string $new      The incoming license key.
	 * @return string          The sanitized license key.
	 */
	public function sanitize_license( $new ) {
		$old = get_option( 'sports_bench_plugin_license_key' );
		if ( $old && $old !== $new ) {
			delete_option( 'sports_bench_plugin_license_status' );
		}
		return $new;
	}

	/**
	 * Adds in add team, player, game and playoff bracket pages
	 * to the "Add New" menu in the top admin menu bar.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Admin_Bar $wp_admin_bar      The current WP_Admin_Bar object.
	 */
	public function add_items_to_add_item_menu( $wp_admin_bar ) {
		$team_args    = [
			'id'        => 'add_team',
			'title'     => esc_html__( 'Team', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-add-team-form' ),
			'parent'    => 'new-content',
			'meta'      => array( 'class' => 'sports-bench-team' ),
		];
		$player_args  = [
			'id'        => 'add_player',
			'title'     => esc_html__( 'Player', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-add-player-form' ),
			'parent'    => 'new-content',
			'meta'      => array( 'class' => 'sports-bench-player' ),
		];
		$game_args    = [
			'id'        => 'add_game',
			'title'     => esc_html__( 'Game', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-add-game-form' ),
			'parent'    => 'new-content',
			'meta'      => array( 'class' => 'sports-bench-game' ),
		];
		$bracket_args = [
			'id'        => 'add_bracket',
			'title'     => esc_html__( 'Playoff Bracket', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-add-bracket-form' ),
			'parent'    => 'new-content',
			'meta'      => array( 'class' => 'sports-bench-bracket' ),
		];
		$wp_admin_bar->add_node( $team_args );
		$wp_admin_bar->add_node( $player_args );
		$wp_admin_bar->add_node( $game_args );
		$wp_admin_bar->add_node( $bracket_args );
	}

	/**
	 * Adds in a Sports Bench menu to the top admin bar you can see on the front end.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Admin_Bar $wp_admin_bar      The current WP_Admin_Bar object.
	 */
	public function add_quick_admin_menu( $wp_admin_bar ) {
		$main_args = [
			'id'        => 'sports-bench-main',
			'title'     => esc_html__( 'Sports Bench', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-options' ),
		];

		$options_args = [
			'id'        => 'sports-bench-options',
			'title'     => esc_html__( 'Options', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-options' ),
			'parent'    => 'sports-bench-main',
		];

		$teams_args = [
			'id'        => 'sports-bench-teams',
			'title'     => esc_html__( 'Teams', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-teams' ),
			'parent'    => 'sports-bench-main',
		];

		$players_args = [
			'id'        => 'sports-bench-players',
			'title'     => esc_html__( 'Players', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-players' ),
			'parent'    => 'sports-bench-main',
		];

		$games_args = [
			'id'        => 'sports-bench-games',
			'title'     => esc_html__( 'Games', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-games' ),
			'parent'    => 'sports-bench-main',
		];

		$brackets_args = [
			'id'        => 'sports-bench-brackets',
			'title'     => esc_html__( 'Brackets', 'sports-bench' ),
			'href'      => admin_url( 'admin.php?page=sports-bench-brackets' ),
			'parent'    => 'sports-bench-main',
		];
		$wp_admin_bar->add_node( $main_args );
		$wp_admin_bar->add_node( $options_args );
		$wp_admin_bar->add_node( $teams_args );
		$wp_admin_bar->add_node( $players_args );
		$wp_admin_bar->add_node( $games_args );
		$wp_admin_bar->add_node( $brackets_args );
	}

	/**
	 * Prints a selected table into a CSV for exporting it.
	 *
	 * @since 2.0.0
	 */
	public function print_csv() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;

		$sb_export_table = sanitize_text_field( $_POST['sb_export_table'] );

		$filename       = 'sb_' . $sb_export_table;
		$generated_date = date( 'd-m-Y His' );
		$table_name     = SPORTS_BENCH_LITE_TABLE_PREFIX . $sb_export_table;

		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Cache-Control: private', false );
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="' . $filename . ' ' . $generated_date . '.csv";' );
		header( 'Content-Transfer-Encoding: binary' );

		$output                 = fopen( 'php://output', 'w' );
		$table_headings_results = Database::get_results( "SHOW COLUMNS FROM $table_name" );

		$table_headings = array();
		foreach ( $table_headings_results as $heading ) {
			$table_headings[] = $heading->Field;
		}
		fputcsv( $output, $table_headings );

		$results = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A );

		foreach ( $results as $key => $value ) {

			if ( 'divisions' === $sb_export_table ) {
				$modified_values = [
					$value['division_id'],
					$value['division_name'],
					$value['division_conference'],
					$value['division_conference_id'],
					$value['division_color'],
				];
			} elseif ( 'games' === $sb_export_table ) {
				$modified_values = $this->export_game_arrays( $value, get_option( 'sports-bench-sport' ), 'games' );
			} elseif ( 'game_info' === $sb_export_table ) {
				$modified_values = $this->export_game_arrays( $value, get_option( 'sports-bench-sport' ), 'game_info' );
			} elseif ( 'game_stats' === $sb_export_table ) {
				$modified_values = $this->export_game_arrays( $value, get_option( 'sports-bench-sport' ), 'game_stats' );
			} elseif ( 'players' === $sb_export_table ) {
				$modified_values = [
					$value['player_id'],
					$value['player_first_name'],
					$value['player_last_name'],
					$value['player_birth_day'],
					$value['player_photo'],
					$value['player_position'],
					$value['player_home_city'],
					$value['player_home_state'],
					$value['player_weight'],
					$value['player_height'],
					$value['player_slug'],
				];
			} elseif ( 'playoff_brackets' === $sb_export_table ) {
				$modified_values = [
					$value['bracket_id'],
					$value['num_teams'],
					$value['bracket_format'],
					$value['bracket_title'],
					$value['bracket_season'],
				];
			} elseif ( 'playoff_series' === $sb_export_table ) {
				$modified_values = [
					$value['series_id'],
					$value['bracket_id'],
					$value['series_format'],
					$value['playoff_round'],
					$value['team_one_id'],
					$value['team_one_seed'],
					$value['team_two_id'],
					$value['team_two_seed'],
					$value['game_ids'],
					$value['opposite_series']
				];
			} elseif ( 'teams' === $sb_export_table ) {
				$modified_values = [
					$value['team_id'],
					$value['team_name'],
					$value['team_location'],
					$value['team_nickname'],
					$value['team_abbreviation'],
					$value['team_city'],
					$value['team_state'],
					$value['team_stadium'],
					$value['team_stadium_capacity'],
					$value['team_head_coach'],
					$value['team_division'],
					$value['team_primary_color'],
					$value['team_secondary_color'],
					$value['team_logo'],
					$value['team_photo'],
					$value['team_slug'],
					$value['team_location_line_one'],
					$value['team_location_line_two'],
					$value['team_location_country'],
					$value['team_location_zip_code'],
					$value['team_active'],
				];
			} else {
				return;
			}

			fputcsv( $output, $modified_values );
		}
		return $output;
	}

	public function export_game_arrays( $data, $sport, $table ) {
		$values = [];

		if ( 'games' === $table ) {
			if ( 'baseball' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_doubles'],
					$data['game_home_triples'],
					$data['game_home_homeruns'],
					$data['game_home_hits'],
					$data['game_home_errors'],
					$data['game_home_lob'],
					$data['game_away_doubles'],
					$data['game_away_triples'],
					$data['game_away_homeruns'],
					$data['game_away_hits'],
					$data['game_away_errors'],
					$data['game_away_lob'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} elseif ( 'basketball' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_time_of_game'],
					$data['game_home_first_quarter'],
					$data['game_home_second_quarter'],
					$data['game_home_third_quarter'],
					$data['game_home_fourth_quarter'],
					$data['game_home_overtime'],
					$data['game_home_fgm'],
					$data['game_home_fga'],
					$data['game_home_3pm'],
					$data['game_home_3pa'],
					$data['game_home_ftm'],
					$data['game_home_fta'],
					$data['game_home_off_rebound'],
					$data['game_home_def_rebound'],
					$data['game_home_assists'],
					$data['game_home_steals'],
					$data['game_home_blocks'],
					$data['game_home_pip'],
					$data['game_home_to'],
					$data['game_home_pot'],
					$data['game_home_fast_break'],
					$data['game_home_fouls'],
					$data['game_away_first_quarter'],
					$data['game_away_second_quarter'],
					$data['game_away_third_quarter'],
					$data['game_away_fourth_quarter'],
					$data['game_away_overtime'],
					$data['game_away_fgm'],
					$data['game_away_fga'],
					$data['game_away_3pm'],
					$data['game_away_3pa'],
					$data['game_away_ftm'],
					$data['game_away_fta'],
					$data['game_away_off_rebound'],
					$data['game_away_def_rebound'],
					$data['game_away_assists'],
					$data['game_away_steals'],
					$data['game_away_blocks'],
					$data['game_away_pip'],
					$data['game_away_to'],
					$data['game_away_pot'],
					$data['game_away_fast_break'],
					$data['game_away_fouls'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} elseif ( 'football' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_first_quarter'],
					$data['game_home_second_quarter'],
					$data['game_home_third_quarter'],
					$data['game_home_fourth_quarter'],
					$data['game_home_overtime'],
					$data['game_home_total'],
					$data['game_home_pass'],
					$data['game_home_rush'],
					$data['game_home_to'],
					$data['game_home_ints'],
					$data['game_home_fumbles'],
					$data['game_home_fumbles_lost'],
					$data['game_home_possession'],
					$data['game_home_kick_returns'],
					$data['game_home_kick_return_yards'],
					$data['game_home_penalties'],
					$data['game_home_penalty_yards'],
					$data['game_home_first_downs'],
					$data['game_away_total'],
					$data['game_away_pass'],
					$data['game_away_rush'],
					$data['game_away_to'],
					$data['game_away_ints'],
					$data['game_away_fumbles'],
					$data['game_away_fumbles_lost'],
					$data['game_away_possession'],
					$data['game_away_kick_returns'],
					$data['game_away_kick_return_yards'],
					$data['game_away_penalties'],
					$data['game_away_penalty_yards'],
					$data['game_away_first_downs'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} elseif ( 'hockey' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_first_period'],
					$data['game_home_first_sog'],
					$data['game_home_second_period'],
					$data['game_home_second_sog'],
					$data['game_home_third_period'],
					$data['game_home_third_sog'],
					$data['game_home_overtime'],
					$data['game_home_overtime_sog'],
					$data['game_home_shootout'],
					$data['game_home_power_plays'],
					$data['game_home_pp_goals'],
					$data['game_home_pen_minutes'],
					$data['game_away_first_period'],
					$data['game_away_first_sog'],
					$data['game_away_second_period'],
					$data['game_away_second_sog'],
					$data['game_away_third_period'],
					$data['game_away_third_sog'],
					$data['game_away_overtime'],
					$data['game_away_overtime_sog'],
					$data['game_away_shootout'],
					$data['game_away_power_plays'],
					$data['game_away_pp_goals'],
					$data['game_away_pen_minutes'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} elseif ( 'rugby' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_first_half'],
					$data['game_home_second_half'],
					$data['game_home_extratime'],
					$data['game_home_shootout'],
					$data['game_home_tries'],
					$data['game_home_conversions'],
					$data['game_home_penalty_goals'],
					$data['game_home_kick_percentage'],
					$data['game_home_meters_runs'],
					$data['game_home_meters_hand'],
					$data['game_home_meters_pass'],
					$data['game_home_possession'],
					$data['game_home_clean_breaks'],
					$data['game_home_defenders_beaten'],
					$data['game_home_offload'],
					$data['game_home_rucks'],
					$data['game_home_mauls'],
					$data['game_home_turnovers_conceeded'],
					$data['game_home_scrums'],
					$data['game_home_lineouts'],
					$data['game_home_penalties_conceeded'],
					$data['game_home_red_cards'],
					$data['game_home_yellow_cards'],
					$data['game_home_free_kicks_conceeded'],
					$data['game_away_first_half'],
					$data['game_away_second_half'],
					$data['game_away_extratime'],
					$data['game_away_shootout'],
					$data['game_away_tries'],
					$data['game_away_conversions'],
					$data['game_away_penalty_goals'],
					$data['game_away_kick_percentage'],
					$data['game_away_meters_runs'],
					$data['game_away_meters_hand'],
					$data['game_away_meters_pass'],
					$data['game_away_possession'],
					$data['game_away_clean_breaks'],
					$data['game_away_defenders_beaten'],
					$data['game_away_offload'],
					$data['game_away_rucks'],
					$data['game_away_mauls'],
					$data['game_away_turnovers_conceeded'],
					$data['game_away_scrums'],
					$data['game_away_lineouts'],
					$data['game_away_penalties_conceeded'],
					$data['game_away_red_cards'],
					$data['game_away_yellow_cards'],
					$data['game_away_free_kicks_conceeded'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} elseif ( 'soccer' === $sport ) {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_first_half'],
					$data['game_home_second_half'],
					$data['game_home_extratime'],
					$data['game_home_pks'],
					$data['game_home_possession'],
					$data['game_home_shots'],
					$data['game_home_sog'],
					$data['game_home_corners'],
					$data['game_home_offsides'],
					$data['game_home_fouls'],
					$data['game_home_saves'],
					$data['game_home_yellow'],
					$data['game_home_red'],
					$data['game_away_first_half'],
					$data['game_away_second_half'],
					$data['game_away_extratime'],
					$data['game_away_pks'],
					$data['game_away_possession'],
					$data['game_away_shots'],
					$data['game_away_sog'],
					$data['game_away_corners'],
					$data['game_away_offsides'],
					$data['game_away_fouls'],
					$data['game_away_saves'],
					$data['game_away_yellow'],
					$data['game_away_red'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			} else {
				$values = [
					$data['game_id'],
					$data['game_week'],
					$data['game_day'],
					$data['game_season'],
					$data['game_home_id'],
					$data['game_away_id'],
					$data['game_home_final'],
					$data['game_away_final'],
					$data['game_attendance'],
					$data['game_status'],
					$data['game_current_period'],
					$data['game_current_time'],
					$data['game_current_home_score'],
					$data['game_current_away_score'],
					$data['game_home_first_set'],
					$data['game_home_second_set'],
					$data['game_home_third_set'],
					$data['game_home_fourth_set'],
					$data['game_home_fifth_set'],
					$data['game_home_kills'],
					$data['game_home_blocks'],
					$data['game_home_aces'],
					$data['game_home_assists'],
					$data['game_home_digs'],
					$data['game_home_attacks'],
					$data['game_home_hitting_errors'],
					$data['game_away_first_set'],
					$data['game_away_second_set'],
					$data['game_away_third_set'],
					$data['game_away_fourth_set'],
					$data['game_away_fifth_set'],
					$data['game_away_kills'],
					$data['game_away_blocks'],
					$data['game_away_aces'],
					$data['game_away_assists'],
					$data['game_away_digs'],
					$data['game_away_attacks'],
					$data['game_away_hitting_errors'],
					$data['game_recap'],
					$data['game_preview'],
					$data['game_neutral_site'],
					$data['game_location_stadium'],
					$data['game_location_line_one'],
					$data['game_location_line_two'],
					$data['game_location_city'],
					$data['game_location_state'],
					$data['game_location_country'],
					$data['game_location_zip_code'],
				];
			}
		} elseif ( 'game_info' === $table ) {
			if ( 'baseball' === $sport ) {
				$values = [
					$data['game_info_id'],
					$data['game_id'],
					$data['game_info_inning'],
					$data['game_info_top_bottom'],
					$data['game_info_home_score'],
					$data['game_info_away_score'],
					$data['game_info_runs_scored'],
					$data['game_info_score_play'],
				];
			} elseif ( 'basketball' === $sport ) {
				$values = [];
			} elseif ( 'football' === $sport ) {
				$values = [
					$data['game_info_id'],
					$data['game_id'],
					$data['game_info_quarter'],
					$data['game_info_time'],
					$data['game_info_scoring_team_id'],
					$data['game_info_home_score'],
					$data['game_info_away_score'],
					$data['game_info_play'],
				];
			} elseif ( 'hockey' === $sport ) {
				$values = [
					$data['game_info_id'],
					$data['game_id'],
					$data['game_info_event'],
					$data['game_info_period'],
					$data['game_info_time'],
					$data['player_id'],
					$data['game_info_assist_one_id'],
					$data['game_info_assist_two_id'],
					$data['game_info_penalty'],
					$data['team_id'],
				];
			} elseif ( 'rugby' === $sport ) {
				$values = [
					$data['game_info_id'],
					$data['game_id'],
					$data['team_id'],
					$data['game_info_home_score'],
					$data['game_info_away_score'],
					$data['game_info_event'],
					$data['game_info_time'],
					$data['player_id'],
				];
			} elseif ( 'soccer' === $sport ) {
				$values = [
					$data['game_info_id'],
					$data['game_id'],
					$data['team_id'],
					$data['game_info_home_score'],
					$data['game_info_away_score'],
					$data['game_info_event'],
					$data['game_info_time'],
					$data['player_id'],
					$data['game_player_name'],
					$data['game_info_assists'],
				];
			} else {
				$values = [];
			}
		} elseif ( 'game_stats' === $table ) {
			if ( 'baseball' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_at_bats'],
					$data['game_player_hits'],
					$data['game_player_runs'],
					$data['game_player_rbis'],
					$data['game_player_doubles'],
					$data['game_player_triples'],
					$data['game_player_homeruns'],
					$data['game_player_strikeouts'],
					$data['game_player_walks'],
					$data['game_player_hit_by_pitch'],
					$data['game_player_fielders_choice'],
					$data['game_player_position'],
					$data['game_player_innings_pitched'],
					$data['game_player_pitcher_strikeouts'],
					$data['game_player_pitcher_walks'],
					$data['game_player_hit_batters'],
					$data['game_player_runs_allowed'],
					$data['game_player_earned_runs'],
					$data['game_player_hits_allowed'],
					$data['game_player_homeruns_allowed'],
					$data['game_player_pitch_count'],
					$data['game_player_decision'],
				];
			} elseif ( 'basketball' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_started'],
					$data['game_player_minutes'],
					$data['game_player_fgm'],
					$data['game_player_fga'],
					$data['game_player_3pm'],
					$data['game_player_3pa'],
					$data['game_player_ftm'],
					$data['game_player_fta'],
					$data['game_player_points'],
					$data['game_player_off_rebound'],
					$data['game_player_def_rebound'],
					$data['game_player_assists'],
					$data['game_player_steals'],
					$data['game_player_blocks'],
					$data['game_player_to'],
					$data['game_player_fouls'],
					$data['game_player_plus_minus'],
				];
			} elseif ( 'football' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_completions'],
					$data['game_player_attempts'],
					$data['game_player_pass_yards'],
					$data['game_player_pass_tds'],
					$data['game_player_pass_ints'],
					$data['game_player_rushes'],
					$data['game_player_rush_yards'],
					$data['game_player_rush_tds'],
					$data['game_player_rush_fumbles'],
					$data['game_player_catches'],
					$data['game_player_receiving_yards'],
					$data['game_player_receiving_tds'],
					$data['game_player_receiving_fumbles'],
					$data['game_player_tackles'],
					$data['game_player_tfl'],
					$data['game_player_sacks'],
					$data['game_player_pbu'],
					$data['game_player_ints'],
					$data['game_player_tds'],
					$data['game_player_ff'],
					$data['game_player_fr'],
					$data['game_player_blocked'],
					$data['game_player_yards'],
					$data['game_player_fga'],
					$data['game_player_fgm'],
					$data['game_player_xpa'],
					$data['game_player_xpm'],
					$data['game_player_touchbacks'],
					$data['game_player_returns'],
					$data['game_player_return_yards'],
					$data['game_player_return_tds'],
					$data['game_player_return_fumbles'],
				];
			} elseif ( 'hockey' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_goals'],
					$data['game_player_assists'],
					$data['game_player_plus_minus'],
					$data['game_player_sog'],
					$data['game_player_penalties'],
					$data['game_player_pen_minutes'],
					$data['game_player_hits'],
					$data['game_player_shifts'],
					$data['game_player_time_on_ice'],
					$data['game_player_faceoffs'],
					$data['game_player_faceoff_wins'],
					$data['game_player_shots_faced'],
					$data['game_player_saves'],
					$data['game_player_goals_allowed'],
				];
			} elseif ( 'rugby' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_tries'],
					$data['game_player_assists'],
					$data['game_player_conversions'],
					$data['game_player_penalty_goals'],
					$data['game_player_drop_kicks'],
					$data['game_player_points'],
					$data['game_player_penalties_conceeded'],
					$data['game_player_meters_run'],
					$data['game_player_red_cards'],
					$data['game_player_yellow_cards'],
				];
			} elseif ( 'soccer' === $sport ) {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_minutes'],
					$data['game_player_goals'],
					$data['game_player_assists'],
					$data['game_player_shots'],
					$data['game_player_sog'],
					$data['game_player_fouls'],
					$data['game_player_fouls_suffered'],
					$data['game_player_shots_faced'],
					$data['game_player_shots_saved'],
					$data['game_player_goals_allowed'],
				];
			} else {
				$values = [
					$data['game_stats_player_id'],
					$data['game_id'],
					$data['game_team_id'],
					$data['game_player_id'],
					$data['game_player_sets_played'],
					$data['game_player_points'],
					$data['game_player_kills'],
					$data['game_player_hitting_errors'],
					$data['game_player_attacks'],
					$data['game_player_set_attempts'],
					$data['game_player_set_errors'],
					$data['game_player_serves'],
					$data['game_player_serve_errors'],
					$data['game_player_aces'],
					$data['game_player_blocks'],
					$data['game_player_block_attempts'],
					$data['game_player_block_errors'],
					$data['game_player_digs'],
					$data['game_player_receiving_errors'],
				];
			}
		} else {
			return;
		}

		return $values;
	}

	/**
	 * Adds in the standings and games dashboard widget.
	 *
	 * @since 2.0.0
	 */
	public function add_dashboard_widget() {
		wp_add_dashboard_widget( 'sports_bench_standings_dashboard_widget', esc_html__( 'Standings', 'sports-bench' ), [ $this, 'dashboard_standings'], [ $this, 'dashboard_standings_options'] );
		wp_add_dashboard_widget( 'sports_bench_games_dashboard_widget', esc_html__( 'Games', 'sports-bench' ), [ $this, 'dashboard_games'], [ $this, 'dashboard_games_options'] );
	}

	/**
	 * Creates the dashboard standings widget.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Post $post             The current WP_Post object.
	 * @param array $callback_args      The arguments for the callback function.
	 */
	public function dashboard_standings( $post, $callback_args ) {
		if ( ! get_option( 'sports_bench_dashboard_widget_options' ) ) {
			$standings_widget_options = array();
		} else {
			$standings_widget_options = get_option( 'sports_bench_dashboard_widget_options' );
		}

		if ( ! isset( $standings_widget_options['sports_bench_dashboard_standings'] ) ) {
			$standings_widget_options['sports_bench_dashboard_standings'] = 'all';
		}

		if ( 'conference' === $standings_widget_options['sports_bench_dashboard_standings'] ) {
			global $wpdb;
			$table       = SPORTS_BENCH_LITE_TABLE_PREFIX . 'divisions';
			$querystr    = "SELECT * FROM $table WHERE division_conference = 'Conference';";
			$conferences = Database::get_results( $querystr );
			foreach ( $conferences as $conference ) {
				echo sports_bench_widget_standings( $conference->division_id );
			}
		} elseif ( 'division' === $standings_widget_options['sports_bench_dashboard_standings'] ) {
			global $wpdb;
			$table_name = SPORTS_BENCH_LITE_TABLE_PREFIX . 'sb_divisions';
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
				echo sports_bench_widget_standings( $division->division_id );
			}
		} else {
			echo sports_bench_widget_standings();
		}
	}

	/**
	 * Creates the options section for the dashboard standings widget.
	 *
	 * @since 2.0.0
	 */
	public function dashboard_standings_options() {
		$conference_division_array = [
			'all'           => esc_html__( 'Entire League', 'sports-bench' ),
			'conference'    => esc_html__( 'Conference Standings', 'sports-bench' ),
			'division'      => esc_html__( 'Division Standings', 'sports-bench' ),
		];

		if ( ! get_option( 'sports_bench_dashboard_widget_options' ) ) {
			$standings_widget_options = [];
		} else {
			$standings_widget_options = get_option( 'sports_bench_dashboard_widget_options' );
		}

		if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['sports_bench_dashboard_widget_options'] ) ) {
			$standings_widget_options['sports_bench_dashboard_standings'] = sanitize_text_field( $_POST['sports_bench_dashboard_widget_options']['sports_bench_dashboard_standings'] );
			update_option( 'sports_bench_dashboard_widget_options', $standings_widget_options );
		}

		if ( ! isset( $standings_widget_options['sports_bench_dashboard_standings'] ) ) {
			$standings_widget_options['sports_bench_dashboard_standings'] = 'all';
		}

		echo '<h2>' . esc_html__( 'Standings Options', 'sports-bench' ) . '</h2>';
		echo '<div class="sports-bench-dashboard-standings-options">';
		echo '<label for="sports_bench_dashboard_standings">' . esc_html__( 'Standings Set to Show:', 'sports-bench' ) . '</label>';
		echo '<select id="sports_bench_dashboard_standings" name="sports_bench_dashboard_widget_options[sports_bench_dashboard_standings]">';
		foreach ( $conference_division_array as $key => $label ) {
			if ( $key === $standings_widget_options['sports_bench_dashboard_standings'] ) {
				$selected = 'selected="selected"';
			} else {
				$selected = '';
			}
			echo '<option value="' . esc_attr( $key ) . '"' . wp_kses_post( $selected ) . '>' . wp_kses_post( $label ) . '</option>';
		}
		echo '</select>';
		echo '</div>';
	}

	/**
	 * Creates the dashboard games widget.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Post $post             The current WP_Post object.
	 * @param array $callback_args      The arguments for the callback function.
	 */
	public function dashboard_games( $post, $callback_args ) {
		if ( ! get_option( 'sports_bench_dashboard_widget_options' ) ) {
			$games_widget_options = [];
		} else {
			$games_widget_options = get_option( 'sports_bench_dashboard_widget_options' );
		}

		if ( ! isset( $games_widget_options['sports_bench_dashboard_recent_games'] ) ) {
			$games_widget_options['sports_bench_dashboard_recent_games'] = 5;
		}

		if ( ! isset( $games_widget_options['sports_bench_dashboard_upcoming_games'] ) ) {
			$games_widget_options['sports_bench_dashboard_upcoming_games'] = 5;
		}

		$upcoming_count = $games_widget_options['sports_bench_dashboard_upcoming_games'];
		$recent_count   = $games_widget_options['sports_bench_dashboard_recent_games'];

		global $wpdb;
		$table = $wpdb->prefix . 'sb_games';

		$querystr       = "SELECT * FROM $table WHERE game_status = 'scheduled' ORDER BY game_day DESC LIMIT $upcoming_count;";
		$upcoming_games = Database::get_results( $querystr );

		if ( $upcoming_games ) {
			?>
			<div class="upcoming-games">
			<h3 class="games-section-title"><?php esc_html_e( 'Upcoming Games', 'sports-bench' ); ?></h3>
			<table class="games-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date/Time' ); ?></th>
						<th colspan="2"><?php esc_html_e( 'Away Team' ); ?></th>
						<th colspan="2"><?php esc_html_e( 'Home Team' ); ?></th>
						<th><span class="screen-reader-text"><?php esc_html_e( 'Edit Game' ); ?></span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $upcoming_games as $game ) {
						$game      = new Game( $game->game_id );
						$away_team = new Team( (int) $game->get_game_away_id() );
						$home_team = new Team( (int) $game->get_game_home_id() );
						$date      = strtotime( $game->get_game_day() );
						if ( 'final' === $game->get_game_status() ) {
							$away_score = $game->get_game_away_final();
							$home_score = $game->get_game_home_final();
						} elseif ( 'in_progress' === $game->get_game_status() ) {
							$away_score = $game->get_game_current_away_score();
							$home_score = $game->get_game_current_home_score();
							if ( null !== $game->get_game_current_period() && null !== $game->get_game_current_time() ) {
								$sep = ' | ';
							} else {
								$sep = '';
							}
							$period       = $game->get_game_current_period();
							$time         = stripslashes( $game->get_game_current_time() );
							$time_in_game = $time . $sep . $period;
						} else {
							$away_score = '';
							$home_score = '';
						}
						?>
						<tr>
							<td><?php echo date( get_option( 'time_format' ), $date ) . '<br />' . date( get_option( 'date_format' ), $date ); ?></td>
							<td><?php echo wp_kses_post( $away_team->get_team_photo( 'team-logo' ) ); ?></td>
							<td><span class="team-name"><?php echo wp_kses_post( $away_team->get_team_location() ); ?></span></td>
							<td><?php echo wp_kses_post( $home_team->get_team_photo( 'team-logo' ) ); ?></td>
							<td><span class="team-name"><?php echo wp_kses_post( $home_team->get_team_location() ); ?></span></td>
							<td><a href="<?php echo sprintf( '?page=sports-bench-edit-game-form&game_id=%s', $game->get_game_id() ); ?>" class="button edit"><?php esc_html_e( 'Edit Game', 'sports-bench' ) ?></a></td>
						</tr>
						<?php
					}
					?>
				</thead>
			</table>
			</div>
			<?php
		}

		$querystr     = "SELECT * FROM $table WHERE game_status = 'final' ORDER BY game_day ASC LIMIT $recent_count;";
		$recent_games = $wpdb->get_results( $querystr );

		if ( $recent_games ) {
			?>
			<div class="recent-games">
			<h3 class="games-section-title"><?php esc_html_e( 'Recent Games', 'sports-bench' ); ?></h3>
			<table class="games-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Date/Time' ); ?></th>
						<th colspan="2"><?php esc_html_e( 'Away Team' ); ?></th>
						<th colspan="2"><?php esc_html_e( 'Home Team' ); ?></th>
						<th><span class="screen-reader-text"><?php esc_html_e( 'Edit Game' ); ?></span></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $recent_games as $game ) {
						$game      = new Game( $game->game_id );
						$away_team = new Team( (int) $game->get_game_away_id() );
						$home_team = new Team( (int) $game->get_game_home_id() );
						$date      = strtotime( $game->get_game_day() );
						if ( 'final' === $game->get_game_status() ) {
							$away_score = $game->get_game_away_final();
							$home_score = $game->get_game_home_final();
						} elseif ( 'in_progress' === $game->get_game_status() ) {
							$away_score = $game->get_game_current_away_score();
							$home_score = $game->get_game_current_home_score();
							if ( null !== $game->get_game_current_period() && null !== $game->get_game_current_time() ) {
								$sep = ' | ';
							} else {
								$sep = '';
							}
							$period       = $game->get_game_current_period();
							$time         = stripslashes( $game->get_game_current_time() );
							$time_in_game = $time . $sep . $period;
						} else {
							$away_score = '';
							$home_score = '';
						}
						?>
						<tr>
							<td><?php echo date( get_option( 'time_format' ), $date ) . '<br />' . date( get_option( 'date_format' ), $date ); ?></td>
							<td><?php echo wp_kses_post( $away_team->get_team_photo( 'team-logo' ) ); ?></td>
							<td><span class="team-name"><?php echo wp_kses_post( $away_team->get_team_location() ); ?> &mdash; <?php echo esc_html( $away_score ); ?></span></td>
							<td><?php echo wp_kses_post( $home_team->get_team_photo( 'team-logo' ) ); ?></td>
							<td><span class="team-name"><?php echo wp_kses_post( $home_team->get_team_location() ); ?></span> &mdash; <?php echo esc_html( $home_score ); ?></td>
							<td><a href="<?php echo sprintf( '?page=sports-bench-edit-game-form&game_id=%s', $game->get_game_id() ); ?>" class="button edit"><?php esc_html_e( 'Edit Game', 'sports-bench' ) ?></a></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			</div>
			<?php
		}
	}

	/**
	 * Creates the options section for the dashboard games widget.
	 *
	 * @since 2.0.0
	 */
	public function dashboard_games_options() {
		if ( ! get_option( 'sports_bench_dashboard_widget_options' ) ) {
			$games_widget_options = [];
		} else {
			$games_widget_options = get_option( 'sports_bench_dashboard_widget_options' );
		}

		if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['sports_bench_dashboard_widget_options'] ) ) {
			$games_widget_options['sports_bench_dashboard_upcoming_games'] = intval( $_POST['sports_bench_dashboard_widget_options']['sports_bench_dashboard_upcoming_games'] );
			$games_widget_options['sports_bench_dashboard_recent_games'] = intval( $_POST['sports_bench_dashboard_widget_options']['sports_bench_dashboard_recent_games'] );
			update_option( 'sports_bench_dashboard_widget_options', $games_widget_options );
		}

		if ( ! isset( $games_widget_options['sports_bench_dashboard_recent_games'] ) ) {
			$games_widget_options['sports_bench_dashboard_recent_games'] = 6;
		}

		if ( ! isset( $games_widget_options['sports_bench_dashboard_upcoming_games'] ) ) {
			$games_widget_options['sports_bench_dashboard_upcoming_games'] = 6;
		}

		echo '<h2>' . esc_html__( 'Game Options', 'sports-bench' ) . '</h2>';
		echo '<div class="sports-bench-dashboard-games-options">';
		echo '<table class="game-options">';
		echo '<tr>';
		echo '<td><label for="sports_bench_dashboard_upcoming_games">' . esc_html__( 'Number of upcoming games to show:', 'sports-bench' ) . '</label></td>';
		echo '<td><input type="number" min="1" max="100" step="1" id="sports_bench_dashboard_upcoming_games" name="sports_bench_dashboard_widget_options[sports_bench_dashboard_upcoming_games]" value="' . wp_kses_post( $games_widget_options['sports_bench_dashboard_upcoming_games'] ) . '" /></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><label for="sports_bench_dashboard_recent_games">' . esc_html__( 'Number of recent games to show:', 'sports-bench' ) . '</label></td>';
		echo '<td><input type="number" min="1" max="100" step="1" id="sports_bench_dashboard_recent_games" name="sports_bench_dashboard_widget_options[sports_bench_dashboard_recent_games]" value="' . wp_kses_post( $games_widget_options['sports_bench_dashboard_recent_games'] ) . '" /></td>';
		echo '</tr>';
		echo '</table>';
		echo '</div>';
	}

	/**
	 * Adds in the TinyMCE window when the "Sports Bench" button is pressed.
	 *
	 * @since 2.0.0
	 */
	public function ajax_tinymce() {
		if ( ! current_user_can( 'edit_pages' ) && ! current_user_can( 'edit_posts' ) ) {
			die( esc_html__( 'You are not allowed to be here', 'sports-bench' ) );
		}

			require_once plugin_dir_path( dirname( __FILE__ ) ) . './includes/functions/window.php';
		die();
	}

	/**
	 * Adds in an admin notice if the license key has not been added.
	 *
	 * @since 2.0.1
	 */
	public function add_license_key_admin_notice() {
		if ( '' === get_option( 'sports_bench_plugin_license_key' ) ) {
			echo '<div class="notice notice-warning is-dismissible">';
			echo '<p>' . esc_html__( 'Please add in your Sports Bench Plugin license key on the', 'sports-bench' ) . ' <a href="' . esc_attr( get_admin_url( null, '/admin.php?page=sports-bench-options' ) ) . '&tab=import">' . esc_html__( 'licenses page.', 'sports-bench' ) . '</a></p>';
			echo '</div>';
		}
	}

	/**
	 * Adds in an upgrade notice for Sports Bench.
	 *
	 * @since 2.1.2
	 *
	 * @return void
	 */
	public function add_upgrade_admin_notice() {
		if ( get_option( 'sports-bench-lite-upgrade-notice' ) ) {
			return;
		}

		?>
		<div class="updated notice notice-warning sports-bench-lite-upgrade-notice is-dismissible">
			<p><?php echo wp_kses_post( __( 'Want more features for your sports website, like playoffs, stat searching, import, export and more? Consider <a href="https://sportsbenchwp.com" target="_blank">purchasing the full Sports Bench plugin</a> to get access to those features and premium support!', 'sports-bench' ) ); ?></p>
		</div>
		<?php
	}

	/**
	 * Hides the upgrade notice when the user dismisses it.
	 *
	 * @since 2.1.2
	 *
	 * @return void
	 */
	public function dismiss_upgrade_notice() {
		update_option( 'sports-bench-lite-upgrade-notice', true );
	}

	/**
	 * Sanitizies the input for an array.
	 *
	 * @since 2.1.5
	 *
	 * @param array $input      The array of incoming information to sanitize.
	 * @return array            The array of sanitized data.
	 */
	public function sanitize_array( $input ) {

		// Initialize the new array that will hold the sanitize values
		$new_input = array();

		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {
			if ( is_array( $val ) ) {
				$new_input[ $key ] = $this->sanitize_array( $val );
			} else {
				$new_input[ $key ] = sanitize_text_field( $val );
			}
		}

		return $new_input;

	}

	/**
	 * Adds in the team manager role for Sports Bench.
	 *
	 * @since 2.2
	 */
	public function add_team_manager_role() {
		add_role(
			'team_manager',
			__( 'Team Manager', 'sports-bench' ),
			array(
				'upload_files' => true,
				'edit_posts'   => true,
				'edit_published_posts' => true,
				'publish_posts'   => true,
				'read' => true,
				'level_2'   => true,
				'level_1' => true,
				'level_0'   => true,
				'delete_posts' => true,
				'delete_published_posts'   => true,
			)
		);
	}

	/**
	 * Adds the user field to give a team manager a team.
	 *
	 * @since 2.2
	 *
	 * @param WP_User $user      The user object for the current user.
	 */
	public function add_user_fields( $user ) {
		$teams = sports_bench_get_teams();
		if ( get_the_author_meta( 'sports_bench_team', $user->ID ) ) {
			$team = get_the_author_meta( 'sports_bench_team', $user->ID );
		} else {
			$team = '';
		}
		?>
		<h3><?php esc_html_e( 'Sports Bench Information', 'sports-bench' ); ?></h3>
		<table class="form-table">
			<tr>
				<th><label for="sports-bench-team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></label></th>
				<td>
					<select id="sports-bench-team" name="sports_bench_team">
						<option value=""><?php esc_html_e( 'Select a Team', 'sports-bench' ); ?></option>
						<?php
						if ( $teams ) {
							foreach ( $teams as $key => $label ) {
								$the_team = new Team( (int)$key );
								?>
								<option value="<?php echo $the_team->get_team_id(); ?>" <?php selected( $team, $the_team->get_team_id() ); ?>><?php echo $the_team->get_team_name(); ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Saves the team for a team manager.
	 *
	 * @since 2.2
	 *
	 * @param int $user_id      The current user id.
	 */
	public function save_user_fields( $user_id ) {
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		if ( empty( intval( $_POST['sports_bench_team'] ) ) ) {
			return false;
		}

		update_usermeta( $user_id, 'sports_bench_team', intval( $_POST['sports_bench_team'] ) );
	}
}
