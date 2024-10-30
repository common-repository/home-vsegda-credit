<?php
/**
 * Plugin Name: Home Vsegda Credit for WooCommerce
 * Plugin URI: https://skyweb.site/projects/home-vsegda-credit-for-woocommerce/
 * Description: Кнопка "Всег.Да Кредит" от Хоум Кредит Банк для WooCommerce.
 * Version: 1.0.0
 * Author: SkyWeb
 * Author URI: https://skyweb.site
 * Text Domain: home-vsegda-credit
 * Domain Path: /languages
 *
 * Requires at least: 5.2
 * Requires PHP: 7.0
 *
 * WC requires at least: 4.0
 * WC tested up to: 5.0
 *
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) || exit;

// Check if required functions are exist
if ( ! function_exists( 'get_plugin_data' ) || ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

// Define main plugin file constant for activation and deactivation plugin hooks
if ( ! defined( 'HOME_VSEGDA_CREDIT_FILE' ) ) {
	define( 'HOME_VSEGDA_CREDIT_FILE', __FILE__ );
}

// Define a constant for assets handle
if ( ! defined( 'HOME_VSEGDA_CREDIT_SLUG' ) ) {
	define( 'HOME_VSEGDA_CREDIT_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

// Define a constant for assets version
if ( ! defined( 'HOME_VSEGDA_CREDIT_VERSION' ) ) {
	define( 'HOME_VSEGDA_CREDIT_VERSION', get_plugin_data( __FILE__ )['Version'] );
}

// Register theme text domain
add_action( 'plugins_loaded', function () {
	load_plugin_textdomain( 'home-vsegda-credit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );

// Check if WooCommerce is active and include plugin settings and classes
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	require __DIR__ . '/includes/class-wc-settings.php';
	require __DIR__ . '/includes/class-main.php';
	require __DIR__ . '/includes/class-helpers.php';
	require __DIR__ . '/includes/class-form.php';

} else {

	if ( is_admin() ) {
		require __DIR__ . '/includes/class-wc-inactive.php';
	}

	return;
}