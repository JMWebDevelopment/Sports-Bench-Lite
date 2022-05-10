<?php
/**
 * Displays the games listing screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/games
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Games;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\GamesScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Game;

$screen = new GamesScreen();

if ( isset( $_GET['action'] ) && isset( $_GET['game_id'] ) && 'delete' === $_GET['action'] ) {
	$screen->delete_game( sanitize_text_field( $_GET['game_id'] ) );
}

?>

<?php echo wp_kses_post( $screen->display_header() ); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<div class="top-row">

				<div class="left">
					<h1><?php esc_html_e( 'Games', 'sports-bench' ); ?></h1>
				</div>

				<div class="right">
					<?php
					if ( ! $screen->is_team_manager() ) {
						?>
						<a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-add-game-form' ) ); ?>" class="button"><?php esc_html_e( 'Add New Game', 'sports-bench' ); ?> <span class="fal fa-plus"></span></a>
						<?php
					}
					?>
				</div>

			</div>

			<div class="games-filters">

				<?php echo wp_kses_post( $screen->display_search_filters() ); ?>

			</div>

			<div class="games-listing">

				<?php echo wp_kses_post( $screen->display_games_listing() ); ?>

			</div>

			<div class="games-pagination">

				<?php echo wp_kses_post( $screen->display_pagination() ); ?>

			</div>

		</div>

	</div>

</div>
