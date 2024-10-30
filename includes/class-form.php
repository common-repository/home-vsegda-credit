<?php

defined( 'ABSPATH' ) || exit;

class Home_Vsegda_Credit_Form {

	/**
	 * Bootstraps the class and hooks required actions
	 */
	public static function init() {
		// Settings
		$buttonOnCartLocation     = get_option( 'woocommerce_home_vsegda_credit_buttonOnCartLocation' ) ?
			esc_attr( get_option( 'woocommerce_home_vsegda_credit_buttonOnCartLocation' ) ) :
			'woocommerce_before_cart_collaterals';
		$buttonOnCheckoutLocation = get_option( 'woocommerce_home_vsegda_credit_buttonOnCheckoutLocation' ) ?
			esc_attr( get_option( 'woocommerce_home_vsegda_credit_buttonOnCheckoutLocation' ) ) :
			'woocommerce_before_checkout_form';

		// Form integration
		add_action( $buttonOnCartLocation, __CLASS__ . '::cart' );
		add_action( $buttonOnCheckoutLocation, __CLASS__ . '::checkout' );

		// TODO - check
		// AJAX coupon handler
		add_action( 'wp_ajax_home_vsegda_credit_when_coupon_apply', __CLASS__ . '::when_coupon_apply' );
		add_action( 'wp_ajax_nopriv_home_vsegda_credit_when_coupon_apply', __CLASS__ . '::when_coupon_apply' );
	}

	/**
	 * Render Home Vsegda Credit forms on cart page
	 */
	public static function cart() {

		if ( false !== Home_Vsegda_Credit_Helpers::validate_checkbox_option( get_option( 'woocommerce_home_vsegda_credit_buttonOnCart' ) ) ) {
			static::cart_and_checkout_forms();
		}
	}

	/**
	 * Render Home Vsegda Credit forms on checkout page
	 */
	public static function checkout() {

		if ( false !== Home_Vsegda_Credit_Helpers::validate_checkbox_option( get_option( 'woocommerce_home_vsegda_credit_buttonOnCheckout' ) ) ) {
			static::cart_and_checkout_forms();
		}
	}

	/**
	 * Render Home Vsegda Credit forms for cart and checkout pages
	 */
	public static function cart_and_checkout_forms() {

		$options = Home_Vsegda_Credit_Helpers::get_options();

		if ( ! empty( $options['partnerCode'] ) ) {

			$user      = Home_Vsegda_Credit_Helpers::get_auth_user_info();
			$reference = date( 'dmy' ) . time();

			ob_start();
			?>

            <button type="button" class="VD_BUTTON"
                    onclick="vd.create({
                            partnerCode: '<?php echo $options['partnerCode']; ?>',
                            partnerProductCode: '<?php echo $options['partnerProductCode']; ?>',
                            items: [<?php echo static::products_list(); ?>],
                            orderNum: '<?php echo $reference; ?>',
                            clientInfo: {
                            firstName: '<?php echo $user['firstname']; ?>',
                            lastName: '<?php echo $user['lastname']; ?>',
                            email: '<?php echo $user['email']; ?>',
                            },
                            })"
            ></button>

			<?php

			$html = ob_get_contents();
			ob_end_clean();

			echo $html;
		}
	}

	/**
	 * Render products list on cart page
	 */
	public static function products_list() {

		$products        = '';
		$cart_items      = WC()->cart->get_cart();
		$applied_coupons = WC()->cart->get_applied_coupons();

		foreach ( $cart_items as $cart_item ) {

			$product_quantity = $cart_item['quantity'];

			// Price of the product
			if ( $applied_coupons ) {

				// Get the first applied coupon code
				$first_applied_coupon = $applied_coupons[0];
				// Get a new instance of the WC_Coupon object
				$coupon = new WC_Coupon( $first_applied_coupon );

				$line_unit_price = $cart_item['line_total'] / $product_quantity;
				$product_object  = wc_get_product( $cart_item['product_id'] );

				if ( $coupon->is_valid_for_product( $product_object ) ) {

					$cart_item_price = round( $line_unit_price, 2 );

				} else {
					$cart_item_price = $cart_item['data']->get_price();
				}

			} else {
				$cart_item_price = $cart_item['data']->get_price();
			}

			$cart_item_price = Home_Vsegda_Credit_Helpers::is_fraction( $cart_item_price ) ? $cart_item_price : $cart_item_price . '.00';
			$cart_item_name  = substr( $cart_item['data']->get_name(), 0, 255 );

			$products .= '{';
			$products .= "name: '$cart_item_name', ";
			$products .= "price: $cart_item_price, ";
			$products .= "quantity: $product_quantity";
			$products .= '},';
		}

		return $products;
	}

	// TODO - check
	// Coupon AJAX handler
	public static function when_coupon_apply() {
		check_ajax_referer( 'apply-coupon', 'security' );

		if ( ! empty( $_POST['coupon_code'] ) ) {
			WC()->cart->add_discount( wc_format_coupon_code( wp_unslash( $_POST['coupon_code'] ) ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

			echo static::products_list();

			wp_die();
		}
	}

}

Home_Vsegda_Credit_Form::init();