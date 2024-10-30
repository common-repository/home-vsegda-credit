<?php

defined( 'ABSPATH' ) || exit;

class Home_Vsegda_Credit_Main {

	/**
	 * Bootstraps the class and hooks required actions
	 */
	public static function init() {
		register_activation_hook( HOME_VSEGDA_CREDIT_FILE, array( __CLASS__, 'activation' ) );
		register_uninstall_hook( HOME_VSEGDA_CREDIT_FILE, array( __CLASS__, 'uninstall' ) );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets' );
		add_filter( 'plugin_action_links_' . plugin_basename( HOME_VSEGDA_CREDIT_FILE ), __CLASS__ . '::add_plugin_page_settings_link' );
	}

	// Add basic settings on first plugin activation
	public static function activation() {
		add_option( 'woocommerce_home_vsegda_credit_buttonOpenOnNewWindow', 'yes' );
		add_option( 'woocommerce_home_vsegda_credit_buttonOnCart', 'yes' );
		add_option( 'woocommerce_home_vsegda_credit_buttonOnCartLocation', 'woocommerce_before_cart_collaterals' );
		add_option( 'woocommerce_home_vsegda_credit_buttonOnCheckout' );
		add_option( 'woocommerce_home_vsegda_credit_buttonOnCheckoutLocation', 'woocommerce_before_checkout_form' );
	}

	// Remove settings on the plugin uninstall
	public static function uninstall() {
		delete_option( 'woocommerce_home_vsegda_credit_partnerCode' );
		delete_option( 'woocommerce_home_vsegda_credit_partnerProductCode' );
		delete_option( 'woocommerce_home_vsegda_credit_buttonOpenOnNewWindow' );
		delete_option( 'woocommerce_home_vsegda_credit_buttonOnCart' );
		delete_option( 'woocommerce_home_vsegda_credit_buttonOnCartLocation' );
		delete_option( 'woocommerce_home_vsegda_credit_buttonOnCheckout' );
		delete_option( 'woocommerce_home_vsegda_credit_buttonOnCheckoutLocation' );
	}

	// Enqueue assets on the cart page only
	public static function assets() {
		if ( is_cart() ) {
			wp_enqueue_script(
				'home-vsegda-app',
				'//application.vsegda-da.com/vd-online.js',
				array( 'jquery', 'woocommerce', ),
				null,
				true
			);

			wp_enqueue_script(
				HOME_VSEGDA_CREDIT_SLUG,
				plugin_dir_url( HOME_VSEGDA_CREDIT_FILE ) . 'assets/js/home-vsegda-credit.js',
				array( 'home-vsegda-app' ),
				HOME_VSEGDA_CREDIT_VERSION,
				true
			);
		}
	}

	// Add plugin page settings link
	public static function add_plugin_page_settings_link( $links ) {
		$links[] = '<a href="' .
		           admin_url( 'admin.php?page=wc-settings&tab=home_vsegda_credit_settings' ) .
		           '">' . __( 'Settings', 'home-vsegda-credit' ) . '</a>';

		return $links;
	}
}

Home_Vsegda_Credit_Main::init();