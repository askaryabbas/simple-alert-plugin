<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class for enqueue styles and scripts.
 */
if ( ! class_exists( 'SAB_Scripts' ) ) {

	class SAB_Scripts {

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'sab_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'sab_admin_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'sab_enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'sab_admin_enqueue_styles' ) );
		}

		public function sab_enqueue_scripts() {
			wp_enqueue_script( SAB_TEXT_DOMAIN . '-script', SAB_PLUGIN_URL . 'assets/js/simple-alert-plugin.js', array( 'jquery' ), SAB_VERSION );
			wp_localize_script( SAB_TEXT_DOMAIN . '-script', 'sab_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		}

		public function sab_admin_enqueue_scripts() {
			wp_enqueue_script( SAB_TEXT_DOMAIN . '-admin-script', SAB_PLUGIN_URL . 'assets/js/simple-alert-plugin-admin.js', array( 'jquery' ), SAB_VERSION );
		}

		public function sab_enqueue_styles() {
			wp_enqueue_style( SAB_TEXT_DOMAIN . '-style', SAB_PLUGIN_URL . 'assets/css/simple-alert-plugin.css', array(), SAB_VERSION, 'all' );
		}

		public function sab_admin_enqueue_styles() {
			wp_enqueue_style( SAB_TEXT_DOMAIN . '-admin-style', SAB_PLUGIN_URL . 'assets/css/simple-alert-plugin-admin.css', array(), SAB_VERSION, 'all' );
		}

	}

	new SAB_Scripts();
}
