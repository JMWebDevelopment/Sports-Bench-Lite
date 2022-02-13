<?php
/**
 * Displays the add/edit playoff bracket screen.
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

namespace Sports_Bench\Admin\Partials\Playoffs;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\BracketsScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

$screen = new BracketsScreen();

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

			<?php
			if ( isset( $_GET['bracket_id'] ) && 0 < $_GET['bracket_id'] ) {
				$bracket = $screen->save_bracket( $_REQUEST );

				if ( null === $bracket['bracket_id'] || 0 === $bracket['bracket_id'] || '' === $bracket['bracket_id'] ) {
					$bracket = $screen->get_bracket_info();
				}

				$screen->display_bracket_fields( $bracket );
			} else {
				$screen->display_new_bracket_fields();
			}
			?>

		</div>

	</div>

</div>
