<?php

defined( 'ABSPATH' ) || exit;

class Home_Vsegda_Credit_WC_Settings {

	/**
	 * Bootstraps the class and hooks required actions
	 */
	public static function init() {
		add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
		add_action( 'woocommerce_settings_tabs_home_vsegda_credit_settings', __CLASS__ . '::settings_tab' );
		add_action( 'woocommerce_update_options_home_vsegda_credit_settings', __CLASS__ . '::update_settings' );
	}

	/**
	 * Add a new settings tab to the WooCommerce settings tabs array.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Home Vsegda Credit tab.
	 *
	 * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Home Vsegda Credit tab.
	 */
	public static function add_settings_tab( $settings_tabs ) {
		$settings_tabs['home_vsegda_credit_settings'] = __( 'Home Vsegda Credit', 'home-vsegda-credit' );

		return $settings_tabs;
	}

	/**
	 * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	 *
	 * @uses woocommerce_admin_fields()
	 * @uses self::get_settings()
	 */
	public static function settings_tab() {
		woocommerce_admin_fields( self::get_settings() );
	}

	/**
	 * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	 *
	 * @uses woocommerce_update_options()
	 * @uses self::get_settings()
	 */
	public static function update_settings() {
		woocommerce_update_options( self::get_settings() );
	}

	/**
	 * Get all the settings for this plugin for @return array Array of settings for @see woocommerce_admin_fields() function.
	 *
	 * @see woocommerce_admin_fields() function.
	 *
	 */
	public static function get_settings() {
		$settings = array(
			// Home Vsegda Credit API section.
			'api_section_title'        => array(
				'id'   => 'woocommerce_home_vsegda_credit_api_section_title',
				'name' => __( 'API Settings', 'home-vsegda-credit' ),
				'type' => 'title',
				'desc' => __( 'Unique identifiers of the store.', 'home-vsegda-credit' ),
			),
			'partnerCode'              => array(
				'id'   => 'woocommerce_home_vsegda_credit_partnerCode',
				'name' => __( 'Partner Code', 'home-vsegda-credit' ),
				'desc' => __( 'The unique identifier of the store, responsible for the details to which funds will be transferred.', 'home-vsegda-credit' ),
				'type' => 'text',
			),
			'partnerProductCode'       => array(
				'id'   => 'woocommerce_home_vsegda_credit_partnerProductCode',
				'name' => __( 'Partner Product Code', 'home-vsegda-credit' ),
				'desc' => __( 'Unique category identifier for the partner of banking products.', 'home-vsegda-credit' ),
				'type' => 'text',
			),
			'api_section_end'          => array(
				'id'   => 'woocommerce_home_vsegda_credit_api_section_end',
				'type' => 'sectionend',
			),

			// Front settings section.
			'front_section_title'      => array(
				'id'   => 'woocommerce_home_vsegda_credit_front_section_title',
				'name' => __( 'Customization', 'home-vsegda-credit' ),
				'type' => 'title',
				'desc' => __( 'Vsegda Credit button appearance settings.', 'home-vsegda-credit' ),
			),
			'buttonOpenOnNewWindow'    => array(
				'id'      => 'woocommerce_home_vsegda_credit_buttonOpenOnNewWindow',
				'title'   => __( 'Open On New Window', 'home-vsegda-credit' ),
				'desc'    => __( 'Open loan processing on a new window (tab)?', 'home-vsegda-credit' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			),
			'front_section_end'        => array(
				'type' => 'sectionend',
				'id'   => 'woocommerce_home_vsegda_credit_front_section_end',
			),

			// Output settings section.
			'display_section_title'    => array(
				'id'   => 'woocommerce_home_vsegda_credit_output_section_title',
				'name' => __( 'Output', 'home-vsegda-credit' ),
				'type' => 'title',
				'desc' => __( 'Vsegda Credit button location settings.', 'home-vsegda-credit' ),
			),
			'buttonOnCart'             => array(
				'id'      => 'woocommerce_home_vsegda_credit_buttonOnCart',
				'title'   => __( 'Cart Page', 'home-vsegda-credit' ),
				'desc'    => __( 'Display button on cart page?', 'home-vsegda-credit' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			),
			'buttonOnCartLocation'     => array(
				'id'       => 'woocommerce_home_vsegda_credit_buttonOnCartLocation',
				'title'    => __( 'Location on Cart Page', 'home-vsegda-credit' ),
				'desc_tip' => __( 'Button location on the cart page', 'home-vsegda-credit' ),
				'type'     => 'select',
				'default'  => 'woocommerce_before_cart_collaterals',
				'options'  => array(
					'woocommerce_before_cart'                    => __( 'Before the cart', 'home-vsegda-credit' ),
					'woocommerce_before_cart_collaterals'        => __( 'After the table of goods', 'home-vsegda-credit' ),
					'woocommerce_before_cart_totals'             => __( 'Before the cart totals title',
						'home-vsegda-credit' ),
					'woocommerce_cart_totals_before_order_total' => __( 'Before the cart totals', 'home-vsegda-credit' ),
					'woocommerce_proceed_to_checkout'            => __( 'Before the checkout button',
						'home-vsegda-credit' ),
					'woocommerce_after_cart'                     => __( 'After the cart', 'home-vsegda-credit' ),
				),
			),
			'buttonOnCheckout'         => array(
				'id'      => 'woocommerce_home_vsegda_credit_buttonOnCheckout',
				'title'   => __( 'Checkout Page', 'home-vsegda-credit' ),
				'desc'    => __( 'Display button on checkout page?', 'home-vsegda-credit' ),
				'type'    => 'checkbox',
				'default' => 'yes',
			),
			'buttonOnCheckoutLocation' => array(
				'id'       => 'woocommerce_home_vsegda_credit_buttonOnCheckoutLocation',
				'title'    => __( 'Location on Checkout Page', 'home-vsegda-credit' ),
				'desc_tip' => __( 'Button location on the checkout page', 'home-vsegda-credit' ),
				'type'     => 'select',
				'default'  => 'woocommerce_after_checkout_form',
				'options'  => array(
					'woocommerce_before_checkout_form' => __( 'Before the checkout', 'home-vsegda-credit' ),
					'woocommerce_after_checkout_form'  => __( 'After the checkout', 'home-vsegda-credit' ),
				),
			),
			'display_section_end'      => array(
				'type' => 'sectionend',
				'id'   => 'woocommerce_home_vsegda_credit_output_section_end',
			),
		);

		return apply_filters( 'woocommerce_home_vsegda_credit_settings', $settings );
	}
}

Home_Vsegda_Credit_WC_Settings::init();