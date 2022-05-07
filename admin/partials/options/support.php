<?php
/**
 * Displays the support screen.
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
?>

<div class="forms-container-wrap">

	<h2><?php esc_html_e( 'Support', 'sports-bench' ); ?></h2>

	<table class="form-table">
		<tbody>
			<tr>
				<th><?php esc_html_e( 'Sports Bench Version:', 'sports-bench' ); ?></th>
				<td>
					<p><?php echo esc_html( get_option( 'sports_bench_version' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'WordPress Version:', 'sports-bench' ); ?></th>
				<td>
					<p><?php echo esc_html( get_bloginfo( 'version' ) ); ?></p>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'PHP Version:', 'sports-bench' ); ?></th>
				<td>
					<p><?php echo esc_html( phpversion() ); ?></p>
				</td>
			</tr>

			<tr>
				<th><?php esc_html_e( 'Report an Issue:', 'sports-bench' ); ?></th>
				<td>
					<p>
						<?php esc_html_e( 'If you run into an issue with Sports Bench, please report it using the form linked to the right. I will respond as quick as I can.', 'sports-bench' ); ?>
					</p>
					<br />
					<a class="button" href="https://sportsbenchwp.com/report-an-issue/" target="_blank"><?php esc_html_e( 'Report an Issue', 'sports-bench' ); ?></a>
				</td>
			</tr>

			<tr>
				<th><?php esc_html_e( 'Submit a Feature Request:', 'sports-bench' ); ?></th>
				<td>
					<p>
						<?php esc_html_e( 'Have an idea for a new feature to be added to Sports Bench? Use the form in the link to the right to submit your idea.', 'sports-bench' ); ?>
					</p>
					<br />
					<a class="button" href="https://sportsbenchwp.com/feature-request/" target="_blank"><?php esc_html_e( 'Submit a Feature Request', 'sports-bench' ); ?></a>
				</td>
			</tr>

			<tr>
				<th><?php esc_html_e( 'Check out the Starting Guide:', 'sports-bench' ); ?></th>
				<td>
					<p>
						<?php esc_html_e( 'Trying to figure out how to get started with Sports Bench? Check out the starting guide to learn how to set up Sports Bench to work for you.', 'sports-bench' ); ?>
					</p>
					<br />
					<a class="button" href="https://sportsbenchwp.com/tutorial-section/getting-started-with-the-sports-bench-plugin/" target="_blank"><?php esc_html_e( 'Read the Starting Guide', 'sports-bench' ); ?></a>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="buttons-grid">
		<div class="button-item">
			<a class="button" href="https://sportsbenchwp.com/forums/" target="_blank"><?php esc_html_e( 'Forums', 'sports-bench' ); ?></a>
		</div>

		<div class="button-item">
			<a class="button" href="https://sportsbenchwp.com/codex/" target="_blank"><?php esc_html_e( 'Codex', 'sports-bench' ); ?></a>
		</div>

		<div class="button-item">
			<a class="button" href="https://sportsbenchwp.com/tutorials/" target="_blank"><?php esc_html_e( 'Tutorials', 'sports-bench' ); ?></a>
		</div>

		<div class="button-item">
			<a class="button" href="https://sportsbenchwp.com/blog/" target="_blank"><?php esc_html_e( 'Blog', 'sports-bench' ); ?></a>
		</div>
	</div>

</div>
