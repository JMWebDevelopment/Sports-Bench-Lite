<?php
/**
 * Displays the add/edit game screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.4
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/games
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Games;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\GamesScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Game;

$screen = new GamesScreen();

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
					<a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-add-game-form' ) ); ?>" class="button"><?php esc_html_e( 'Add New Game', 'sports-bench' ); ?> <span class="fal fa-plus"></span></a>
				</div>

			</div>

			<?php
			if ( isset( $_GET['game_id'] ) && 0 < $_GET['game_id'] ) {
				$game = $screen->save_game( $screen->sanitize_array( $_REQUEST ) );

				$screen->display_game_fields( sanitize_text_field( $_GET['game_id'] ), $game[0], $game[1], $game[2] );
			} else {
				$screen->display_new_game_fields();
			}
			?>

		</div>

	</div>

</div>
