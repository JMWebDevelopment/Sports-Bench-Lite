<?php
/**
 * Displays the add/edit player screen.
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

namespace Sports_Bench\Admin\Partials\Teams;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\PlayersScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

$screen = new PlayersScreen();

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

			<?php
			if ( isset( $_GET['player_id'] ) && 0 < $_GET['player_id'] ) {
				if ( $screen->user_can_edit_player( sanitize_text_field( $_GET['player_id'] ) ) ) {
					$player = $screen->save_player( $screen->sanitize_array( $_REQUEST ) );

					if ( null === $player['player_id'] || 0 === $player['player_id'] || '' === $player['player_id'] ) {
						$player = $screen->get_player_info();
					}

					$screen->display_player_fields( $player );
				} else {
					?>
					<p><?php esc_html_e( 'You are not allowed to edit this player.', 'sports-bench' ); ?></p>
					<?php
				}
			} else {
				if ( ! $screen->is_team_manager() ) {
					$screen->display_new_player_fields();
				} else {
					?>
					<p><?php esc_html_e( 'You are not allowed to add a new player.', 'sports-bench' ); ?></p>
					<?php
				}
			}
			?>

		</div>

	</div>

</div>
