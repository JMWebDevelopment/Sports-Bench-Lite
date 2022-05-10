<?php
/**
 * Creates the window when the TinyMCE Sports Bench button is hit in the editor.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/functions
 * @author     Jacob Martella <me@jacobmartella.com>
 */

use Sports_Bench\Classes\Base\Bracket;
use Sports_Bench\Classes\Base\Game;
use Sports_Bench\Classes\Base\Player;
use Sports_Bench\Classes\Base\Team;


//* Load the necessary scripts
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-position');
wp_enqueue_script('jquery');
wp_enqueue_script('wp-tinymce');
wp_enqueue_script( 'sports-bench-window', plugin_dir_url( __FILE__ ) . 'js/window.min.js', [], $this->version, 'all' );

//* Load the necessary global variables
global $wp_scripts;
global $wpdb;

//* Load the seasons played
$seasons = [];
$seasons[ '' ] = __( 'Select a Season', 'sports-bench' );
$table_name = $wpdb->prefix . 'sb_games';
$quer = "SELECT DISTINCT game_season FROM $table_name;";
$seasons_list = $wpdb->get_results( $quer );
foreach ( $seasons_list as $season ) {
	$seasons[ $season->game_season ] = $season->game_season;
}

//* Load the games for each season
$games = [];
foreach ( $seasons as $season ) {
	if ( $season == 'Select a Season' ) {
		continue;
	}
	$season_games = [];
	$season_games[ '' ] = __( 'Select a Game', 'sports-bench' );
	$table_name  = $wpdb->prefix . 'sb_games';
	$quer        = "SELECT * FROM $table_name WHERE game_season = $season ORDER BY game_day DESC;";
	$games_list  = $wpdb->get_results( $quer );
	foreach ( $games_list as $game ) {
		$away_team               = new Team( (int) $game->game_away_id );
		$home_team               = new Team( (int) $game->game_home_id );
		$date                    = new DateTime( $game->game_day );
		$game_date               = date_format( $date, 'F j, Y' );
		$season_games[ $game->game_id ] = $game_date . ': ' . $away_team->get_team_name() . ' at ' . $home_team->get_team_name();
	}
	$games[ $season ] = $season_games;
}

//* Load the players
$players = [];
$players[ '' ] = __( 'Select a Player', 'sports-bench' );
$table_name = $wpdb->prefix . 'sb_players';
$quer = "SELECT * FROM $table_name;";
$players_list = $wpdb->get_results( $quer );
foreach ( $players_list as $the_player ) {
	$player = new Player( (int)$the_player->player_id );
	$players[ $player->get_player_id() ] = $player->get_player_first_name() . ' ' . $player->get_player_last_name();
}

$divisions = [];
$table_name = $wpdb->prefix . 'sb_divisions';
$divisions_list = $wpdb->get_results( "SELECT t1.division_id AS conference_id, t1.division_name AS conference_name, t2.division_id AS division_id, t2.division_name AS division_name, t2.division_conference_id AS division_conference_id, t2.division_conference AS division_conference FROM $table_name AS t1 LEFT JOIN $table_name AS t2 ON t1.division_id = t2.division_conference_id WHERE t2.division_id IS NOT NULL ORDER BY t1.division_id" );
$conference = '';
if ( $divisions_list != null ) {
	foreach ( $divisions_list as $item ) {
		if ( $conference != $item->conference_name ) {
			$division   = array(
				'division_id'            => $item->conference_id,
				'division_name'          => $item->conference_name,
				'division_conference_id' => '',
				'division_conference'    => 'Conference'
			);
			$conference = $item->conference_name;
			array_push( $divisions, $division );
		}
		$division = array(
			'division_id'            => $item->division_id,
			'division_name'          => $item->division_name,
			'division_conference_id' => $item->division_conference_id,
			'division_conference'    => 'Division'
		);
		array_push( $divisions, $division );
	}
} else {
	$divisions_list = $wpdb->get_results( "SELECT * FROM $table_name" );

	if ( $divisions_list != null ) {
        foreach ( $divisions_list as $item ) {
	        $division = array(
		        'division_id'            => $item->division_id,
		        'division_name'          => $item->division_name,
		        'division_conference_id' => $item->division_conference_id,
		        'division_conference'    => ''
	        );
	        array_push( $divisions, $division );
        }
    }
}

//* Load the teams
$teams = [];
$teams[ '' ] = __( 'Select a Team', 'sports-bench' );
$table_name = $wpdb->prefix . 'sb_teams';
$quer = "SELECT * FROM $table_name;";
$teams_list = $wpdb->get_results( $quer );
foreach ( $teams_list as $the_team ) {
	$team = new Team( (int)$the_team->team_id );
	$teams[ $team->get_team_id() ] = $team->get_team_name();
}

//* Load the brackets
$brackets = [];
$brackets[ '' ] = __( 'Select a Bracket', 'sports-bench' );
$table_name = $wpdb->prefix . 'sb_playoff_brackets';
$quer = "SELECT * FROM $table_name ORDER BY bracket_id DESC;";
$brackets_list = $wpdb->get_results( $quer );
foreach ( $brackets_list as $the_bracket ) {
	$bracket                          = new Bracket( (int)$the_bracket->bracket_id );
	$brackets[ $bracket->get_bracket_id() ] =  $bracket->get_bracket_season() . ': ' . $bracket->get_bracket_title();
}
?>
<?php //* Create the actual modal ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php esc_html_e( 'Add Sports Bench Shortcode', 'sports-bench' ) ?></title>
	<?php wp_print_scripts(); ?>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo wp_kses_post( get_option('blog_charset') ); ?>" />
	<base target="_self" />
</head>

<body id="link">
<form name="sports-bench-shortcode" action="#">
	<table border="0" cellpadding="4" cellspacing="0">
		<tr>
			<td><?php esc_html_e( 'Chose Shortcode', 'sports-bench' ); ?></td>
			<td><select id="shortcode" name="shortcode">
					<option value=""><?php esc_html_e( 'Select a Shortcode', 'sports-bench' ); ?></option>
					<option value="game"><?php esc_html_e( 'Game', 'sports-bench' ); ?></option>
					<option value="player"><?php esc_html_e( 'Player', 'sports-bench' ); ?></option>
					<option value="team"><?php esc_html_e( 'Team', 'sports-bench' ); ?></option>
					<option value="division"><?php esc_html_e( 'Conference/Division List', 'sports-bench' ); ?></option>
					<option value="scoreboard"><?php esc_html_e( 'Scoreboard', 'sports-bench' ); ?></option>
					<option value="standings"><?php esc_html_e( 'Standings', 'sports-bench' ); ?></option>
					<option value="stats"><?php esc_html_e( 'Stats', 'sports-bench' ); ?></option>
					<option value="bracket"><?php esc_html_e( 'Playoff Brackets', 'sports-bench' ); ?></option>
					<option value="rivalry"><?php esc_html_e( 'Rivalry', 'sports-bench' ); ?></option>
					<option value="game-recap"><?php esc_html_e( 'Game Recap', 'sports-bench' ); ?></option>
					<option value="player-page"><?php esc_html_e( 'Player Page', 'sports-bench' ); ?></option>
					<option value="team-page"><?php esc_html_e( 'Team Page', 'sports-bench' ); ?></option>
					<option value="game-recap-sidebar"><?php esc_html_e( 'Game Recap for Sidebar', 'sports-bench' ); ?></option>
					<option value="stat-search"><?php esc_html_e( 'Stat Search', 'sports-bench' ); ?></option>
					<option value="box-score"><?php esc_html_e( 'Box Score', 'sports-bench' ); ?></option>
				</select>
			</td>
		</tr>
		<tr id="game">
			<td><?php esc_html_e( 'Select Game', 'sports-bench' ); ?></td>
			<td><select id="shortcode-season" name="shortcode-season">
					<?php
					foreach ( $seasons as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
				</select>
			</td>
			<td>
				<?php foreach ( $games as $season => $game ) { ?>
					<select id="shortcode-game-<?php echo esc_attr( $season ); ?>" name="shortcode-game" class="games" <?php if ( $season != get_option( 'sports-bench-season-year' ) ) { ?>disabled="disabled"<?php } ?>>
						<?php
						foreach ( $game as $key => $name ) {
							echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
						}
						?>
					</select>
				<?php } ?>
			</td>
		</tr>
		<tr id="player">
			<td><?php esc_html_e( 'Select Player', 'sports-bench' ); ?></td>
			<td><select id="shortcode-player" name="shortcode-player">
					<?php
					foreach ( $players as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr id="team">
			<td><?php esc_html_e( 'Select Team', 'sports-bench' ); ?></td>
			<td><select id="shortcode-team" name="shortcode-team">
					<?php
					foreach ( $teams as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
        <tr id="division">
            <td><?php esc_html_e( 'Select Conference/Division', 'sports-bench' ); ?></td>
            <td><select id="shortcode-division" name="shortcode-division">
					<?php
					echo '<option value="">' . esc_html__( 'Select a Conference or Division', 'sports-bench' ) . '</option>';
					foreach ( $divisions as $division ) {
					    if ( null !== $division[ 'division_conference_id' ] ) {
					        $prefix = '&mdash; ';
                        } else {
					        $prefix = '';
                        }
						echo '<option value="' . esc_attr( $division[ 'division_id' ] ) . '">' . wp_kses_post( $prefix . $division[ 'division_name' ] ) . '</option>';
					}
					?>
                </select>
            </td>
        </tr>
        <tr id="bracket">
            <td><?php esc_html_e( 'Select Playoff Bracket', 'sports-bench' ); ?></td>
            <td><select id="shortcode-bracket" name="shortcode-bracket">
					<?php
					foreach ( $brackets as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
                </select>
            </td>
        </tr>
        <tr id="rivalry">
            <td><?php esc_html_e( 'Select First Team', 'sports-bench' ); ?></td>
            <td><select id="shortcode-rivalry-team-one" name="shortcode-rivalry-team-one">
					<?php
					foreach ( $teams as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
                </select>
            </td>
            <td><?php esc_html_e( 'Select Second Team', 'sports-bench' ); ?></td>
            <td><select id="shortcode-rivalry-team-two" name="shortcode-rivalry-team-two">
			        <?php
			        foreach ( $teams as $key => $name ) {
				        echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
			        }
			        ?>
                </select>
            </td>
            <td>
                <?php esc_html_e( 'Number of Recent Games', 'sports-bench' ); ?>
            </td>
            <td>
                <input type="number" id="shortcode-rivalry-recent-games" name="shortcode-rivalry-recent-games" value="5" />
            </td>
        </tr>
        <tr id="game-recap">
            <td><?php esc_html_e( 'Select Game', 'sports-bench' ); ?></td>
            <td><select id="shortcode-recap-season" name="shortcode-recap-season">
					<?php
					foreach ( $seasons as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
					}
					?>
                </select>
            </td>
            <td>
				<?php foreach ( $games as $season => $game ) { ?>
                    <select id="shortcode-game-recap-<?php echo esc_attr( $season ); ?>" name="shortcode-game-recap" class="games" <?php if ( $season != get_option( 'sports-bench-season-year' ) ) { ?>disabled="disabled"<?php } ?>>
						<?php
						foreach ( $game as $key => $name ) {
							echo '<option value="' . esc_attr( $key ) . '">' . wp_kses_post( $name ) . '</option>';
						}
						?>
                    </select>
				<?php } ?>
            </td>
        </tr>

	</table>

	<div>
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'themedelta'); ?>" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'themedelta'); ?>" onClick="insertsportsbenchshortcode();" />
		</div>
	</div>
</form>
</body>
</html>
