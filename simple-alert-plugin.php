<?php

/**
 * Plugin Name: Simple Alert Plugin
 * Plugin URI: http://askaryabbas.com/
 * Description: This plugin will add functionality to display alert box based on selected post types.
 * Version: 1.0.1
 * Author: Askary Abbas
 * Author URI: http://askaryabbas.com
 * Text Domain: simple-alert-box
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Plugin version.
if ( ! defined( 'SAB_VERSION' ) ) {
	define( 'SAB_VERSION', '1.0.0' );
}
// Plugin Folder Path.
if ( ! defined( 'SAB_DIR' ) ) {
	define( 'SAB_PLUGIN_DIR', wp_normalize_path( plugin_dir_path( __FILE__ ) ) );
}
// Plugin Folder URL.
if ( ! defined( 'SAB_URL' ) ) {
	define( 'SAB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
// Plugin Root File.
if ( ! defined( 'SAB_FILE' ) ) {
	define( 'SAB_FILE', wp_normalize_path( __FILE__ ) );
}
// Plugin Text Domain
if ( ! defined( 'SAB_TEXT_DOMAIN' ) ) {
	define( 'SAB_TEXT_DOMAIN', 'simple-alert-box' );
}

if ( ! class_exists( 'SAB_Init' ) ) :

	/**
	 * Main SAB_Init Class.
	 *
	 * @since 1.0
	 */
	class SAB_Init {

		/**
		 * The one, true instance of this object.
		 *
		 * @static
		 * @access private
		 * @since 1.0
		 * @var object
		 */
		private static $instance;

		/**
		 * Creates or returns an instance of this class.
		 *
		 * @static
		 * @access public
		 * @since 1.0
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/*       * ************************* Magic Methods ************************** */

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @see SAB_Init::instance()
		 */
		public function __construct() {
			$this->includes();
		}

		/*
		 * Function used for include required files
		 * @since 1.0.0
		 */

		public function includes() {
			$inc_files = array(
				'sab-functions.php',
				'sab-filters.php',
				'sab-scripts.php',
				'sab-ajax.php',
			);
			foreach ( $inc_files as $inc_file ) {
				include_once SAB_PLUGIN_DIR . 'inc/' . $inc_file;
			}
		}

	}

	SAB_Init::get_instance();
endif;
