<?php
/**
/* Plugin Name: WooCommerce Payment Methods (by vendocrat)
 * Plugin URI:  http://vendocr.at/
 * Description: <strong>Easily display your accepted payment methods from WooCommerce.</strong> Handcrafted with &hearts; by <a href='http://vendocr.at/'>vendocrat</a> in Vienna.
 * Version:     0.1.1
 * Author:      vendocrat
 * Author URI:  http://vendocr.at/
 * License:     GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
	return;

if ( ! class_exists( 'vendocrat_Woo_Payment_Methods' ) ) :

class vendocrat_Woo_Payment_Methods {

	/**
	 * Constructor
	 *
	 * @since 2014-08-15
	 * @version 2014-08-15
	 **************************************************/
	function __construct() {
		define( 'PAYMENT_METHODS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'PAYMENT_METHODS_URI', plugin_dir_url( __FILE__ ) );

		define( 'PAYMENT_METHODS_CSS_URI', trailingslashit( PAYMENT_METHODS_URI . 'assets/css' ) );
		define( 'PAYMENT_METHODS_IMG_URI', trailingslashit( PAYMENT_METHODS_URI . 'assets/img' ) );

		$this->load_functions();
		$this->load_classes();

		// load text domain
		add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );

		// scripts and styles
		if ( ! is_admin() ) :
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		endif;

		// register widgets
		add_action( 'widgets_init', array( &$this, 'register_widgets' ) );

		// add shortcode
		add_shortcode( 'v_woo_payment_methods', array( &$this, 'get_payment_methods' ) );
	}

	/**
	 * Load theme textdomain
	 *
	 * @return void
	 * 
	 * @since 2014-09-08
	 * @version 2014-09-08
	 **************************************************/
	static function load_plugin_textdomain() {
		load_plugin_textdomain( 'vendocrat-payment-methods', PAYMENT_METHODS_DIR .'languages' );
	}

	/**
	 * Override some WooCommerce plugin functionality
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_functions() {}

	/**
	 * Override some WooCommerce plugin functionality
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function load_classes() {}

	/**
	 * Enqueue Styles
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function enqueue_styles() {
		if ( ! wp_style_is( 'vendocrat-payment-webfont', 'registered' ) ) {
			wp_register_style( 'vendocrat-payment-webfont', PAYMENT_METHODS_CSS_URI .'payment-webfont.min.css', array(), false, 'all' );
		}
		wp_enqueue_style( 'vendocrat-payment-webfont' );

		wp_register_style( 'vendocrat-payment-methods', PAYMENT_METHODS_CSS_URI .'payment-methods.css', array(), false, 'all' );
		wp_enqueue_style( 'vendocrat-payment-methods' );
	}

	/**
	 * Enqueue Scripts
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-07
	 **************************************************/
	function enqueue_scripts() {}

	/**
	 * Register Widgets
	 *
	 * @return void
	 *
	 * @since 2014-09-07
	 * @version 2014-09-08
	 **************************************************/
	function register_widgets() {
		require_once PAYMENT_METHODS_DIR .'classes/class-widget-payment-methods.php';
		register_widget( 'vendocrat_Widget_Payment_Methods' );
	}

	/**
	 * Woo Accepted Payment Methods
	 *
	 * @since 2014-09-07
	 * @version 2014-09-08
	 **************************************************/
	function get_payment_methods( $atts = array(), $content = null ) {
		extract(
			shortcode_atts(
				array(
					'methods' => array(),   // keys are the gateway slugs (lowercase) for the icon class, values are the title attributes
					'style'   => 'default', // default, inverse, o/outline
					'tooltip' => false,     // adds data attributes to icon to be used for diplaying tooltips (made for Bootstrap)
					'xclass'  => false,     // add any extra classes, seperated by a space
				), $atts
			)
		);

		$class = 'payment-methods';
		$class.= ($style)  ? ' payment-methods-'. $style : '';
		$class.= ($xclass) ? ' '. $xclass : '';

		$output = '<ul';
		$output.= ($class) ? ' class="'. esc_attr( trim($class) ) .'"' : '';
		$output.= '>';

		// use the passed methods array if it's not empty, otherwhise use available gateways/methods
		if ( empty( $methods ) ) {
			$gateways = $this->get_available_gateways();
			$methods = $gateways['methods'];
		}

		// sort array
		ksort($methods);

		// let the magic happen
		foreach ( $methods as $key => $value ) {
			$id    = $key;
			$title = $value;

			$icon = '';

			switch ( $key ) {
				case 'bank-transfer' :
				case 'cheque' :
				case 'paybox' :
				case 'cash-on-delivery' :
				case 'quick' :
				case 'wirecard' :
					// currently no font icons available, so we spare them
					//$icon = '<b class="'. esc_attr( trim($id) ) .'" title="'. esc_attr( trim($title) ) .'">'. $title .'</b>';
					break;

				default :
					$class = 'pw pw-'. $id .' '. $id;

					$icon = '<i';
					$icon.= ($class) ? ' class="'. esc_attr( trim($class) ) .'"' : '';
					$icon.= ($title) ? ' title="'. esc_attr( trim($title) ) .'"' : '';
					$icon.= ($tooltip) ? ' data-toggle="tooltip" data-placement="bottom"' : '';
					$icon.= '></i>';
					break;
			}

			if ( $icon )
				$output.= '<li>'. $icon .'</li>';
		}

		$output.= '</ul>';

		return $output;
	}

	/**
	 * Get available gateways
	 *
	 * @since 2014-09-07
	 * @version 2014-09-08
	 **************************************************/
	function get_available_gateways() {
		$gateways = array();
		$methods  = array();

		if ( $available_gateways = WC()->payment_gateways->get_available_payment_gateways() ) {

			foreach ( $available_gateways as $gateway ) {
				$gateway_id    = $gateway->id;
				$gateway_title = $gateway->get_title();
				$gateway_desc  = $gateway->get_description();
				$gateway_icon  = $gateway->get_icon();

				switch ( $gateway_id ) {
					case 'bacs' :
						$methods['bank-transfer']    = __( 'Bank Transfer', 'vendocrat-payment-methods' );
						break;

					case 'cheque' :
						$methods['cheque']           = __( 'Pay with Cheque', 'vendocrat-payment-methods' );
						break;

					case 'paypal' :
						$methods['paypal']           = 'PayPal';
						$methods['visa']             = 'Visa';
						$methods['mastercard']       = 'MasterCard';
						$methods['american-express'] = 'American Express';
						$methods['discover']         = 'Discover';
						$methods['diners']           = 'Diners Club';
						$methods['jcb']              = 'JCB';
						break;

					case 'stripe' :
						$methods['stripe']           = 'Stripe';
						$methods['visa']             = 'Visa';
						$methods['mastercard']       = 'MasterCard';
						$methods['american-express'] = 'American Express';
						$methods['discover']         = 'Discover';
						$methods['diners']           = 'Diners Club';
						$methods['jcb']              = 'JCB';
						break;

					case 'wirecard' :
						$methods['wirecard']         = 'WireCard';
						$methods['paypal']           = 'PayPal';
						$methods['visa']             = 'Visa';
						$methods['mastercard']       = 'MasterCard';
						$methods['american-express'] = 'American Express';
						$methods['discover']         = 'Discover';
						$methods['diners']           = 'Diners Club';
						$methods['jcb']              = 'JCB';
						$methods['maestro']          = 'Maestro';
						$methods['quick']            = 'Quick';
						$methods['paybox']           = 'paybox';
						$methods['paysafecard']      = 'paysafecard';
						$methods['bank-transfer']    = __( 'Bank Transfer', 'vendocrat-payment-methods' );
						break;

					case 'ClickAndBuy' :
					case 'clickandbuy' :
						$methods['clickandbuy']      = 'ClickAndBuy';
						$methods['bank-transfer']    = __( 'Bank Transfer', 'vendocrat-payment-methods' );
						break;

					case 'sofortgateway' :
						$methods['clickandbuy']      = 'SofortÜberweisung';
						$methods['bank-transfer']    = __( 'Bank Transfer', 'vendocrat-payment-methods' );
						break;

					case 'amazon' :
					case 'amazon-fps' :
						$methods['amazon']           = 'Amazon';
						break;

					case 'google' :
					case 'wallet' :
					case 'google-wallet' :
						$methods['clickandbuy']      = 'Google Wallet';
						break;

					case 'bitpay' :
					case 'coinbase' :
					case 'bitcoin' :
						$methods['bitcoin']          = 'Bitcoin';
						break;

					case 'cash_on_delivery' :
						$methods['cash-on-delivery'] = __( 'Cash on Delivery', 'vendocrat-payment-methods' );
						break;

					default :
						break;
				}

				$gateways[$gateway_id] = array(
					'id'      => $gateway_id,
					'title'   => $gateway_title,
					'desc'    => $gateway_desc,
					'icon'    => $gateway_icon,
				);
			}

		}

		// remove duplicate methods
		$methods = array_unique($methods);

		// add methods array to gateways array
		$gateways['methods'] = $methods;

		return $gateways;
	}

} // END Class

global $vendocrat_woo_payment_methods;
$vendocrat_woo_payment_methods = new vendocrat_Woo_Payment_Methods();

/**
 * Output payment methods
 *
 * @since 2014-09-08
 * @version 2014-09-08
 **************************************************/
function v_woo_payment_methods( $atts = array() ) {
	global $vendocrat_woo_payment_methods;

	echo $vendocrat_woo_payment_methods->get_payment_methods( $atts );
}

endif;

/*
 * NO MORE LOVE TO GIVE
 */