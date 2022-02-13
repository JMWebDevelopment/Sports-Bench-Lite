<?php
/**
 * Displays the playoff brackets listing screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/playoffs
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Brackets;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\BracketsScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Bracket;

$screen = new BracketsScreen();

if ( isset( $_GET['action'] ) && isset( $_GET['bracket_id'] ) && 'delete' === $_GET['action'] ) {
	//$screen->delete_team( $_GET['bracket_id'] );
}

?>

<?php echo $screen->display_header(); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<div class="top-row">

				<div class="left">
					<h1><?php esc_html_e( 'Brackets', 'sports-bench' ); ?></h1>
				</div>

				<div class="right">
					<a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-add-bracket-form' ) ); ?>" class="button"><?php esc_html_e( 'Add New Bracket', 'sports-bench' ); ?> <span class="fal fa-plus"></span></a>
				</div>

			</div>

			<div class="brackets-listing">

				<?php echo wp_kses_post( $screen->display_brackets_listing() ); ?>

			</div>

		</div>

	</div>

</div>
