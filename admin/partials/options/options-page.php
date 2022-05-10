<?php
/**
 * Displays the options page screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/options
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Options;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\OptionsScreen;

$screen = new OptionsScreen();

$theme        = wp_get_theme();
$parent_theme = $theme->parent();

?>

<?php echo wp_kses_post( $screen->display_header() ); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<h1><?php esc_html_e( 'Sports Bench Options', 'sports-bench' ); ?></h1>

			<div id="sports-bench-options-container">

				<div class="tabs">

					<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'general' ) ); ?>">
						<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=general"><?php esc_html_e( 'General', 'sports-bench' ); ?></a></p>
					</div>

					<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'pages' ) ); ?>">
						<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=pages"><?php esc_html_e( 'Pages', 'sports-bench' ); ?></a></p>
					</div>

					<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'display' ) ); ?>">
						<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=display"><?php esc_html_e( 'Display', 'sports-bench' ); ?></a></p>
					</div>

					<?php
					if ( 'Sports Bench' === $theme->name || ( 'Sports Bench' === $parent_theme && $parent_theme->name ) ) {
						?>
						<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'theme' ) ); ?>">
							<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=theme"><?php esc_html_e( 'Theme Options', 'sports-bench' ); ?></a></p>
						</div>
						<?php
					}
					?>

					<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'licenses' ) ); ?>">
						<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=licenses"><?php esc_html_e( 'Upgrade to Premium', 'sports-bench' ); ?></a></p>
					</div>
					<div class="tab <?php echo esc_attr( $screen->tab_active_class( 'support' ) ); ?>">
						<p class="tab-title"><a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-options' ) ); ?>&tab=support"><?php esc_html_e( 'Support', 'sports-bench' ); ?></a></p>
					</div>

				</div>

				<div class="main-area">
					<?php
					if ( isset( $_GET['tab'] ) && 'general' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/general.php';
					} elseif ( isset( $_GET['tab'] ) && 'pages' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/pages.php';
					} elseif ( isset( $_GET['tab'] ) && 'display' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/display.php';
					} elseif ( isset( $_GET['tab'] ) && 'theme' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/theme.php';
					} elseif ( isset( $_GET['tab'] ) && 'import' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/import.php';
					} elseif ( isset( $_GET['tab'] ) && 'export' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/export.php';
					} elseif ( isset( $_GET['tab'] ) && 'licenses' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/licenses.php';
					} elseif ( isset( $_GET['tab'] ) && 'support' === $_GET['tab'] ) {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/support.php';
					} else {
						require_once plugin_dir_path( dirname( __FILE__ ) ) . 'options/general.php';
					}
					?>
				</div>

			</div>

		</div>

	</div>

</div>
