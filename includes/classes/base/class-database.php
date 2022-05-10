<?php
/**
 * Creates the database class.
 *
 * PHP version 7.0
 *
 * @link       https://sportsbenchwp.com
 * @since      2.0.0
 * @version    2.2
 *
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 * @author     Jacob Martella <me@jacobmartella.com>
 */

namespace Sports_Bench\Classes\Base;

/**
 * The core database class.
 *
 * This is used to add, update, delete or get data from the database.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/base
 */
class Database {

	/**
	 * Adds a row to the specified table
	 *
	 * @since 2.0.0
	 *
	 * @param string $table_name Name of the table to add the row to.
	 * @param array  $data       Data to add to the table.
	 * @return false|int The ID for the new row if successful or false if unsuccessful.
	 */
	public static function add_row( $table_name, $data = array() ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . $table_name;
		return $wpdb->insert( $table, $data ); // db call ok.
	}

	/**
	 * Updates a row in the given table
	 *
	 * @since 2.0.0
	 *
	 * @param string $table_name Name of the table to update the data.
	 * @param array  $where      Array of where clauses to narrow down the rows to update.
	 * @param array  $data       Array of data to update the row.
	 * @return false|int The ID for the row if successful or false if unsuccessful.
	 */
	public static function update_row( $table_name, $where, $data = array() ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . $table_name;
		return $wpdb->update( $table, $data, $where ); // db call ok; no-cache ok.
	}

	/**
	 * Deletes a row in the given table
	 *
	 * @since 2.0.0
	 *
	 * @param string $table_name Name of the table to delete the data.
	 * @param array  $where      Array of where clauses to narrow down the rows to delete.
	 * @return false|int The ID for the deleted row if successful or false if unsuccessful.
	 */
	public static function delete_row( $table_name, $where ) {
		global $wpdb;
		$table = SPORTS_BENCH_LITE_TABLE_PREFIX . $table_name;
		return $wpdb->delete( $table, $where ); // db call ok; no-cache ok.
	}

	/**
	 * Gets the results for a specified SQL query
	 *
	 * @since 2.0.0
	 *
	 * @param string $sql The SQL query to get the data.
	 * @return array|object|null Returns an array or object based on the results given or null if no rows are found.
	 */
	public static function get_results( $sql ) {
		global $wpdb;
		return $wpdb->get_results( $sql ); // db call ok; db no-cache ok; hpcs:ignore unprepared SQL ok.
	}

}
