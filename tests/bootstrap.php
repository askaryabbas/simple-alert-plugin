<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Simple_Alert_Plugin
 */

if ( class_exists( '\Yoast\PHPUnitPolyfills\Autoload' ) === false ) {
	require_once 'vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
}

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/simple-alert-plugin.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
