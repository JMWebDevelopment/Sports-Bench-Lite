<?php
/**
 * Displays the players listing screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/players
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Players;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\PlayersScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Player;

$screen = new PlayersScreen();

if ( isset( $_GET['action'] ) && isset( $_GET['player_id'] ) && 'delete' === $_GET['action'] ) {
	$screen->delete_player( sanitize_text_field( $_GET['player_id'] ) );
}

?>

<?php echo wp_kses_post( $screen->display_header() ); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<div class="top-row">

				<div class="left">
					<h1><?php esc_html_e( 'Players', 'sports-bench' ); ?></h1>
				</div>

				<div class="right">
					<?php
					if ( ! $screen->is_team_manager() ) {
						?>
						<a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-add-player-form' ) ); ?>" class="button"><?php esc_html_e( 'Add New Player', 'sports-bench' ); ?> <span class="fal fa-plus"></span></a>
						<?php
					}
					?>
				</div>

			</div>

			<div class="players-filters">

				<?php echo wp_kses_post( $screen->display_search_filters() ); ?>

			</div>

			<div class="players-listing">

				<?php echo wp_kses_post( $screen->display_players_listing() ); ?>

			</div>

			<div class="players-pagination">

				<?php echo wp_kses_post( $screen->display_pagination() ); ?>

			</div>

		</div>

	</div>

</div>
