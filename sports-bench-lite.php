<?php
/**
 * Plugin Name:       Sports Bench Lite
 * Plugin URI:        https://sportsbenchwp.com
 * Description:       Creating and keeping up with sports league stats on the internet can be a hassle. Fortunately, the Sports Bench plugin takes all of the hard work away from you. After a simple five-minute (or less) setup, you're ready to start entering teams, players, games and even division and then watch the plugin do all of the other stuff for you. Sports Bench takes care of accumulating the stats you enter as well as the standings and schedules. The plugin has the ability to display the standings, a scoreboard of all game for the current season and statistical leaderboards. Show off game stats next to a recap of a game. Easily create pages for teams and players. And shortcodes allow you to show game, player or team information in any post. And if you use the Sports Bench theme, all of this comes with minimal front-end coding work for you. You have enough to worry about with managing your sports league; let us take care of the hard part.
 * Version:           2.2
 * Author:            Jacob Martella Web Development
 * Author URI:        https://jacobmartella.com
 * Text Domain:       sports-bench-lite
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes
 */

namespace Sports_Bench;

// If this file is called directly, then about execution.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Let's make it easy on ourselves and set the table prefix here.
if ( ! defined( 'SPORTS_BENCH_LITE_TABLE_PREFIX' ) ) {
	global $wpdb;
	define( 'SPORTS_BENCH_LITE_TABLE_PREFIX', $wpdb->prefix . 'sb_' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sports-bench-activator.php
 *
 * @since 2.0.0
 */
function activate_sports_bench_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sports-bench-activator.php';
	$activator = new Sports_Bench_Activator( '2.2' );
	$activator->activate( '2.2' );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sports-bench-deactivator.php
 *
 * @since 2.0.0
 */
function deactivate_sports_bench_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sports-bench-deactivator.php';
	$deactivator = new Sports_Bench_Deactivator( '2.2' );
	$deactivator->deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_sports_bench_lite' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_sports_bench_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
if ( ! class_exists( 'Sports_Bench\Sports_Bench' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-sports-bench.php';
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_sports_bench_lite() {

	$spmm = new Sports_Bench();
	$spmm->run();

}

// Call the above function to begin execution of the plugin.
run_sports_bench_lite();
