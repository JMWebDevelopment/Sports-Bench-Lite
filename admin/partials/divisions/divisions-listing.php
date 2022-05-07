<?php
/**
 * Displays the divisions listing screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/divisions
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Divisions;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\DivisionsScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;

$screen = new DivisionsScreen();

if ( isset( $_GET['action'] ) && isset( $_GET['division_id'] ) && 'delete' === $_GET['action'] ) {
	$screen->delete_division( sanitize_text_field( $_GET['division_id'] ) );
}

?>

<?php echo wp_kses_post( $screen->display_header() ); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<div class="top-row">

				<div class="full-width">
					<h1><?php esc_html_e( 'Divisions/Conferences', 'sports-bench' ); ?></h1>
				</div>

			</div>

			<div class="divisions-container">

				<div class="divisions-left">

				<?php
				if ( isset( $_GET['division_id'] ) && 0 < $_GET['division_id'] ) {
					$division = $screen->save_division_conference( $screen->sanitize_array( $_REQUEST ) );

					if ( null === $division['division_id'] || 0 === $division['division_id'] || '' === $division['division_id'] ) {
						$division = $screen->get_division_info();
					}

					$screen->edit_division_conference( $division );
				} else {
					$screen->add_new_division_conference();
				}
				?>

				</div>

				<div class="divisions-right">

					<?php echo wp_kses_post( $screen->display_divisions_conferences() ); ?>

				</div>

			</div>

		</div>

	</div>

</div>
