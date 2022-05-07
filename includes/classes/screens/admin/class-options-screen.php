<?php
/**
 * The file that defines the options screen class
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screens/admin
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Screens\Admin;

use Sports_Bench\Classes\Screens\Screen;
use Sports_Bench\Classes\Base\Database;
use Sports_Bench\Classes\Base\Team;
use Sports_Bench\Classes\Base\Player;

/**
 * The options screen class.
 *
 * This is used for functions for options admin screens in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class OptionsScreen extends Screen {

	/**
	 * Creates the new PlayersScreen object to be used.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Checks to see if a tab is active.
	 *
	 * @since 2.0.0
	 *
	 * @param string $tab      The tab to check.
	 * @return bool            Whether or not the tab is active.
	 */
	public function is_tab_active( $tab ) {
		if ( isset( $_GET['tab'] ) && $tab === $_GET['tab'] ) {
			return true;
		}

		if ( ! isset( $_GET['tab'] ) && 'general' === $tab ) {
			return true;
		}

		return false;
	}

	/**
	 * Adds in the "current-tab" class to the active tab.
	 *
	 * @since 2.0.0
	 *
	 * @param string $tab      The tab to check and add the class to.
	 * @return string          The class to add or not add to the tab.
	 */
	public function tab_active_class( $tab ) {
		$tab_class = '';
		if ( $this->is_tab_active( $tab ) ) {
			$tab_class = 'current-tab';
		}

		return $tab_class;
	}

	/**
	 * Handles uploading the CSV file to the right table in the database.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data      The data submitted through the form.
	 * @return array           Messages about whether the upload was successful or not.
	 */
	public function upload_csv( $data ) {
		if ( isset( $data['sports_bench_import_nonce'] ) && wp_verify_nonce( $data['sports_bench_import_nonce'], 'sports_bench_import_nonce' ) ) {

			global $wpdb;
			if ( 'divisions' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_divisions';
			} elseif ( 'games' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_games';
			} elseif ( 'game_info' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_game_info';
			} elseif ( 'game_stats' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_game_stats';
			} elseif ( 'players' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_players';
			} elseif ( 'playoff_brackets' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_playoff_brackets';
			} elseif ( 'playoff_series' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_playoff_series';
			} elseif ( 'teams' === $data['sports_bench_table'] ) {
				$table = $wpdb->prefix . 'sb_teams';
			} else {
				$table = $wpdb->prefix . 'sb_teams';
			}

			$uploaded_pdf = media_handle_upload( 'sports_bench_csv_upload', 0 );

			if ( is_wp_error( $uploaded_pdf ) ) {
				return ['', $uploaded_pdf->get_error_message() ];
			} else {
				$csv_url = wp_get_attachment_url( $uploaded_pdf );

				$data_rows = $this->get_data( $csv_url );

				$issue = false;
				$rows  = 0;

				foreach ( $data_rows as $item ) {
					if ( $this->check_for_duplicate( $item, $data['sports_bench_table'] ) ) {
						if ( 'divisions' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['division_id' => $item['division_id'] ] );
						} elseif ( 'games' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['game_id' => $item['game_id'] ] );
						} elseif ( 'game_info' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['game_info_id' => $item['game_info_id'] ] );
						} elseif ( 'game_stats' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['game_stats_player_id' => $item['game_stats_player_id'] ] );
						} elseif ( 'players' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['player_id' => $item['player_id'] ] );
						} elseif ( 'playoff_brackets' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['bracket_id' => $item['bracket_id'] ] );
						} elseif ( 'playoff_series' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['series_id' => $item['series_id'] ] );
						} elseif ( 'teams' === $data['sports_bench_table'] ) {
							$result = $wpdb->update( $table, $item, ['team_id' => $item['team_id'] ] );
						} else {
							return;
						}
					} else {
						$result = $wpdb->insert( $table, $item );
						if ( 'players' === $data['sports_bench_table'] ) {
							$this->add_to_player_taxonomy( $item );
						} elseif ( 'teams' === $data['sports_bench_table'] ) {
							$this->add_to_team_taxonomy( $item );
						}
					}
					if ( $result ) {
						$rows++;
					} else {
						$issue = true;
						break;
					}
				}

				if ( $issue ) {
					$message = '';
					$error   = esc_html__( 'There\'s been an error adding the rows to the database. Please double check your CSV file and re-upload the file.', 'sports-bench' );
				} else {
					$message = $rows . ' ' . esc_html__( 'rows added or updated to the database.', 'sports-bench' );
					$error   = '';
				}

				wp_delete_attachment( $uploaded_pdf );

				return [ $message, $error ];
			}
		} else {
			return ['', esc_html__( 'There has been an error trying to submit the form. Please try again.', 'sports-bench' ) ];
		}
	}

	/**
	 * Gets the data out of the uploaded CSV file.
	 *
	 * @since 2.0.0
	 *
	 * @param string $file      The URL to the file to open and use.
	 * @return array            The data pulled from the CSV file.
	 */
	private function get_data( $file ) {
		$data   = [];
		$errors = [];

		if ( $_file = fopen( $file, "r" ) ) {
			$team   = [];
			$header = fgetcsv( $_file );
			while ( $row = fgetcsv( $_file ) ) {
				foreach ( $header as $i => $key ) {
					$team[ str_replace( ' ', '', $key ) ] = $row[ $i ];
				}
				$data[] = $team;
			}
			fclose( $_file );
		} else {
			$errors[] = "File ' . $file . ' could not be opened. Check the file's permissions to make sure it's readable by your server.";
		}
		if ( ! empty( $errors ) ) {

		}
		return $data;
	}

	/**
	 * Checks to see if the item for upload is already in that table.
	 *
	 * @since 2.0.0
	 *
	 * @param array  $item       The item to check.
	 * @param string $table      The table to check to see if the item is in.
	 * @return bool              Whether the item is already in that table or not.
	 */
	private function check_for_duplicate( $item, $table ) {
		if ( 'divisions' === $table && isset( $item['division_id'] ) ) {
			global $wpdb;
			$table     = $wpdb->prefix . 'sb_' . $table;
			$divisions = $wpdb->get_col( "SELECT division_id FROM $table;" );
			return in_array( $item['division_id'], $divisions );
		} elseif ( 'games' === $table && isset( $item['game_id'] ) ) {
			global $wpdb;
			$table = $wpdb->prefix . 'sb_' . $table;
			$games = $wpdb->get_col( "SELECT game_id FROM $table;" );
			return in_array( $item['game_id'], $games );
		} elseif ( 'game_info' === $table && isset( $item['game_info_id'] ) ) {
			global $wpdb;
			$table = $wpdb->prefix . 'sb_' . $table;
			$info  = $wpdb->get_col( "SELECT game_info_id FROM $table;" );
			return in_array( $item['game_info_id'], $info );
		} elseif ( 'game_stats' === $table && isset( $item['game_stats_player_id'] ) ) {
			global $wpdb;
			$table = $wpdb->prefix . 'sb_' . $table;
			$stats = $wpdb->get_col( "SELECT game_stats_player_id FROM $table;" );
			return in_array( $item['game_stats_player_id'], $stats );
		} elseif ( 'players' === $table && isset( $item['player_id'] ) ) {
			global $wpdb;
			$table   = $wpdb->prefix . 'sb_' . $table;
			$players = $wpdb->get_col( "SELECT player_id FROM $table;" );
			return in_array( $item['player_id'], $players );
		} elseif ( 'playoff_brackets' === $table && isset( $item['bracket_id'] ) ) {
			global $wpdb;
			$table    = $wpdb->prefix . 'sb_' . $table;
			$brackets = $wpdb->get_col( "SELECT bracket_id FROM $table;" );
			return in_array( $item['bracket_id'], $brackets );
		} elseif ( 'playoff_series' === $table && isset( $item['series_id'] ) ) {
			global $wpdb;
			$table  = $wpdb->prefix . 'sb_' . $table;
			$series = $wpdb->get_col( "SELECT series_id FROM $table;" );
			return in_array( $item['series_id'], $series );
		} elseif ( 'teams' === $table && isset( $item['team_id'] ) ) {
			global $wpdb;
			$table = $wpdb->prefix . 'sb_' . $table;
			$teams = $wpdb->get_col( "SELECT team_id FROM $table;" );
			return in_array( $item['team_id'], $teams );
		} else {
			return false;
		}
	}

	/**
	 * Adds a player into the player taxonomy if it's not already there.
	 *
	 * @since 2.0.0
	 *
	 * @param array $player      The information for the player to add.
	 */
	private function add_to_player_taxonomy( $player ) {
		$id_found = false;

		$existing_terms = get_terms(
			'sports-bench-post-players',
			[
				'hide_empty' => false,
			]
		);

		foreach ( $existing_terms as $term ) {
			if ( $term->slug === $player['player_slug'] ) {
				$id_found = true;
			}
		}

		if ( false === $id_found ) {
			wp_insert_term(
				$player['player_first_name'] . ' ' . $player['player_last_name'],
				'sports-bench-post-players',
				[
					'slug' => $player['player_slug'],
				]
			);
		}
	}

	/**
	 * Adds a team into the team taxonomy if it's not already there.
	 *
	 * @since 2.0.0
	 *
	 * @param array $team      The information for the team to add.
	 */
	private function add_to_team_taxonomy( $team ) {
		$id_found = false;

		$existing_terms = get_terms(
			'sports-bench-post-teams',
			[
				'hide_empty' => false,
			]
		);

		foreach ( $existing_terms as $term ) {
			if ( $term->slug === $team['team_slug'] ) {
				$id_found = true;
			}
		}

		if ( false === $id_found ) {
			wp_insert_term(
				$team['team_name'],
				'sports-bench-post-teams',
				[
					'slug' => $team['team_slug'],
				]
			);
		}
	}
}
