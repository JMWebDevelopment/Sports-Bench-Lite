<?php
/**
 * Displays the add/edit team screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/teams
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Admin\Partials\Teams;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Screens\Admin\TeamsScreen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;

$screen = new TeamsScreen();

?>

<?php echo wp_kses_post( $screen->display_header() ); ?>

<div class="wrap">

	<div class="sports-bench">

		<div class="wrap">

			<div class="top-row">

				<div class="left">
					<h1><?php esc_html_e( 'Teams', 'sports-bench' ); ?></h1>
				</div>

				<div class="right">
					<a href="<?php echo esc_attr( $screen->get_admin_page_link( 'sports-bench-add-team-form' ) ); ?>" class="button"><?php esc_html_e( 'Add New Team', 'sports-bench' ); ?> <span class="fal fa-plus"></span></a>
				</div>

			</div>

			<?php
			if ( isset( $_GET['team_id'] ) && 0 < $_GET['team_id'] ) {
				$team = $screen->save_team( $_REQUEST );

				if ( null === $team['team_id'] || 0 === $team['team_id'] || '' === $team['team_id'] ) {
					$team = $screen->get_team_info();
				}

				$screen->display_team_fields( $team );
			} else {
				$screen->display_new_team_fields();
			}
			?>

		</div>

	</div>

</div>
