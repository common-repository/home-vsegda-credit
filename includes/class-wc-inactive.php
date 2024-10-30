<?php

defined( 'ABSPATH' ) || exit;

class Home_Vsegda_Credit_WC_Inactive {

	/**
	 * Bootstraps the class and hooks required actions
	 */
	public static function init() {
		add_action( 'admin_notices', __CLASS__ . '::wc_inactive_admin_notice' );
	}

	/**
	 * Admin notice if WooCommerce is inactive
	 */
	public static function wc_inactive_admin_notice() {
		$class   = 'notice notice-warning is-dismissible';
		$message = __( 'Home Vsegda Credit needs WooCommerce to run. Please, install and active WooCommerce plugin.', 'home-vsegda-credit' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}

Home_Vsegda_Credit_WC_Inactive::init();