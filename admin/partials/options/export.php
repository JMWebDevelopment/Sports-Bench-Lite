<?php
/**
 * Displays the export options screen.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.1.1
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/admin/partials/options
 * @author     Jacob Martella <me@jacobmartella.com>
 */

$table_options = array(
	'divisions'         => esc_html__( 'Divisions', 'sports-bench' ),
	'games'             => esc_html__( 'Games', 'sports-bench' ),
	'game_info'         => esc_html__( 'Game Info', 'sports-bench' ),
	'game_stats'        => esc_html__( 'Game Stats', 'sports-bench' ),
	'players'           => esc_html__( 'Players', 'sports-bench' ),
	'playoff_brackets'  => esc_html__( 'Playoff Brackets', 'sports-bench' ),
	'playoff_series'    => esc_html__( 'Playoff Series', 'sports-bench' ),
	'teams'             => esc_html__( 'Teams', 'sports-bench' ),
);

?>

<div class="forms-container-wrap">

	<h2><?php esc_html_e( 'Export', 'sports-bench' ); ?></h2>

	<form method="POST" action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>">

		<label for="sb_export_table"><?php esc_html_e( 'Please select a table to export as a CSV file.', 'sports-bench' ); ?></label><br/>
		<select id="sb_export_table" name="sb_export_table">
			<?php
			foreach ( $table_options as $key => $label ) {
				echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</option>';
			}
			?>
		</select>
		<br />
		<input type="hidden" name="action" value="generate_csv" />
		<input type="submit" name="submit" class="button button-primary" value="<?php esc_attr_e( 'Generate & Download CSV File', 'sports-bench' ); ?>" />
	</form>

</div>
