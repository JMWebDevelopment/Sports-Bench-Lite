<?php
/**
 * The file that defines the TinyMCE buttons class
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

$sports_bench_plugin_path = plugin_dir_path( __FILE__ );
define( 'SPORTS_BENCH_PATH', $sports_bench_plugin_path );

/**
 * The button class.
 *
 * This is used for functions for the TinyMCE buttons in the plugin.
 *
 * @since      2.0.0
 * @package    Sports_Bench_Lite
 * @subpackage Sports_Bench_Lite/includes/classes/screen
 */
class Sports_Bench_Button {

	/**
	 * Name of the TinyMCE plugin
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $pluginname = 'sportsbench';

	/**
	 * The path for to JS for the button.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $path = '';

	/**
	 * The internal version of the buttons.
	 *
	 * @since 2.0.0
	 *
	 * @var int
	 */
	public $internalVersion = 200;

	/**
	 * Creates the Sports_Bench_Button object.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {
		// Set path to sports-bench-editor_plugin.js
		$this->path = SPORTS_BENCH_PATH . 'js/';

		// Modify the version when tinyMCE plugins are changed.
		add_filter( 'tiny_mce_version', array( &$this, 'change_tinymce_version' ) );

		// init process for button control
		add_action( 'init', array( &$this, 'addbuttons')  );
	}

	/**
	 * Adds the buttons to the editor.
	 *
	 * @since 2.0.0
	 */
	public function addbuttons() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		// Add only in Rich Editor mode
		if ( get_user_option( 'rich_editing' ) == 'true' ) {

			// add the button for wp2.5 in a new way
			add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ), 5 );
			add_filter( 'mce_buttons', array( &$this, 'register_button' ), 5 );
		}
	}

	/**
	 * Registers the new buttons to the editor.
	 *
	 * @since 2.0.0
	 *
	 * @param array $buttons      The list of buttons already registered.
	 * @return array              The list of buttons registered.
	 */
	public function register_button( $buttons ) {
		array_push( $buttons, 'separator', $this->pluginname );
		return $buttons;
	}

	/**
	 * Adds our buttons JS file to the list.
	 *
	 * @since 2.0.0
	 *
	 * @param array $plugin_array      The array of plugins already registered.
	 * @return array                   The list of plugins registered.
	 */
	public function add_tinymce_plugin( $plugin_array ) {
		$plugin_array[ $this->pluginname ] = plugins_url( 'sports-bench/admin/js/sports-bench-editor-plugin.min.js' );
		return $plugin_array;
	}

	/**
	 * Changes the version of TinyMCE.
	 *
	 * @since 2.0.0
	 *
	 * @param int $version      The current version of TinyMCE.
	 * @return int              The new version of TinyMCE.
	 */
	public function change_tinymce_version( $version ) {
		$version = $version + $this->internalVersion;
		return $version;
	}
}

$tinymce_button = new Sports_Bench_Button();
